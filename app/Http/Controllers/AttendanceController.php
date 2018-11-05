<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Traits\Attendance as AttendanceTrait;
use App\User;
use App\DailyAttendance;
use App\Attendance;
use App\Holiday;
use App\WorkingPeriod;
use App\Timesheet;
use App\TimesheetDetail;
use App\Shift;
use App\ShiftSchedule;
use App\UserShiftSchedule;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use App\ShiftSwap;
use Auth;

class AttendanceController extends Controller
{ 
	use AttendanceTrait;
	public function absenceManagement(Request $request)
	{
		$date=date('Y-m-d');
		$attendances=[];
		$lates=0;
		$earlys=0;
		$absentees= User::whereDoesntHave('attendances', function ($query) use ($date) {
		    $query->whereDate('date', $date);
		})->get();
		
		$wp=WorkingPeriod::all()->first();

		$users=User::whereHas('attendances', function ($query) use ($date) {
			    $query->whereDate('date', $date);
			})->get();
		foreach ($users as $user) {
			$attendances[$user->id]['emp_num']=$user->emp_num;
			$attendances[$user->id]['name']=$user->name;
			$attendances[$user->id]['hours']=$this->getDayHours($user->emp_num,$date);
			$attendances[$user->id]['first_clock_in']=Attendance::where(['emp_num'=>$user->emp_num,'date'=>$date])->first()->attendancedetails()->orderBy('clock_in', 'asc')->first()->clock_in;
			$attendances[$user->id]['first_clock_out']=Attendance::where(['emp_num'=>$user->emp_num,'date'=>$date])->first()->attendancedetails()->orderBy('clock_out', 'desc')->first()->clock_out;
			$attendances[$user->id]['attendance_id']=Attendance::where(['emp_num'=>$user->emp_num,'date'=>$date])->first()->id;
			$attendances[$user->id]['created_at']=Attendance::where(['emp_num'=>$user->emp_num,'date'=>$date])->first()->created_at;
			$attendances[$user->id]['updated_at']=Attendance::where(['emp_num'=>$user->emp_num,'date'=>$date])->first()->updated_at;
			$attendances[$user->id]['diff']=$this->time_diff($attendances[$user->id]['first_clock_in'],$wp->sob);
			if ($attendances[$user->id]['diff']>0) {
				$earlys++;
			} else {
				$lates++;
			}	

		}
		// return $attendances;
		return view('attendance.absenceManagement',compact('attendances','lates','earlys','absentees'));
	}

	

	public function userShiftSchedule($user_id)
	{
		$user=User::find($user_id);
		return view('attendance.userShiftSchedule', compact('user'));
	}
	public function myAttendance($user_id)
	{
		$user=User::find($user_id);
		return view('attendance.userAttendance', compact('user'));
		
	}
	public function myAttendanceCalendar(Request $request,$user_id)
	{
		$user=User::find($user_id);
		$dispemp=[];
		
		$startdate=$request->start;
		$enddate=$request->end;
		$day_num=0;
		
		$begin = new \DateTime($startdate);
			$end = new \DateTime($enddate. '+1 days');
			
			$interval = \DateInterval::createFromDateString('1 day');
			$period = new \DatePeriod($begin, $interval, $end);
			
			foreach ($period as $dt) {
		 $attendance=Attendance::where(['emp_num'=>$user->emp_num,'date'=>$dt->format(" Y-m-d")])->first();
			$isweekend=0;
		$isholiday=0;
				if($attendance){
					$clock_in=$attendance->attendancedetails()->orderBy('clock_in', 'asc')->first()->clock_in;
			   $clock_out=$attendance->attendancedetails()->orderBy('clock_out', 'desc')->first()->clock_out;
			   $day_num=intval(date('N',strtotime($attendance->date)));
			   if ($day_num>=6) {
			    $isweekend=1;
			   }
			
			   $isholiday=$this->checkHoliday($attendance->date);
			   if ($isweekend==1) {
			   
			   	 $dispemp[]=[
			    	
			    	'title'=>'Weekend',
			    	'start'=>($clock_in) ? $attendance->date.'T'.$clock_in: $attendance->date,
			    	'end'=>($clock_out) ? $attendance->date.'T'.$clock_out: $attendance->date,
			    	'color' =>'#67a8e4',
			    	'id'=>($clock_in) ? $attendance->id:''];
			   } elseif ($isholiday==1) {
			   	 $dispemp[]=[
			    	
			    	'title'=>'Public Holiday',
			    	'start'=>($clock_in) ? $attendance->date.'T'.$clock_in: $attendance->date,
			    	'end'=>($clock_out) ? $attendance->date.'T'.$clock_out: $attendance->date,
			    	'color' =>'#67a8e4',
			    	'id'=>($clock_in) ? $attendance->id:''];
			   }elseif($clock_in) {
			   	 $dispemp[]=[
			    	
			    	'title'=>'Present',
			    	'start'=>$attendance->date.'T'.$clock_in,
			    	'end'=>$attendance->date.'T'.$clock_out,
			    	'color' =>'#3aac76',
			    	'id'=>($clock_in) ? $attendance->id:''];
			   }else{
			   	$dispemp[]=[
			    	
			    	'title'=>'Absent',
			    	'start'=>$attendance->date,
			    	'end'=>$attendance->date,
			    	'color' =>'#be3030',
			    	'id'=>''];
			   }
			   
				}else{
					$dispemp[]=[
			    	
			    	'title'=>'Absent',
			    	'start'=>$dt->format(" Y-m-d"),
			    	'end'=>$dt->format(" Y-m-d"),
			    	'color' =>'#be3030',
			    	'id'=>''];

				}	
			   
			

			
		}

		if(isset($dispemp)):
			return response()->json($dispemp);
			else:
			$dispemp=['title'=>'Nil','start'=>'2018-09-09'];
			return response()->json($dispemp);
			endif;
	}
	public function userShiftScheduleCalendar(Request $request,$user_id)
	{
		$user=User::find($user_id);
		$dispemp=[];
		$startdate=$request->start;
		$enddate=$request->end;
		$shift_schedules=User::find($user_id)->usershiftschedules()->whereHas('schedule',function ($query) use ($startdate,$enddate) {
                $query->whereBetween('start_date', [$startdate, $enddate])
		->orWhereBetween('end_date',[$startdate, $enddate]);
            })->with(['schedule','shift'])->get();
		$colours=[ '#67a8e4', '#f32f53', '#77c949', '#FFC1CC', '#ffbb44', '#f32f53', '#67a8e4'];
		$i=0;
		foreach ($shift_schedules as $shift_schedule) {
			$begin = new \DateTime($shift_schedule->schedule->start_date);
			$end = new \DateTime($shift_schedule->schedule->end_date. '+1 days');
			$col=$colours[$i];
			$interval = \DateInterval::createFromDateString('1 day');
			$period = new \DatePeriod($begin, $interval, $end);

			foreach ($period as $dt) {
			   
			    $dispemp[]=[
			    	'title'=>$shift_schedule->shift->type,
			    	'start'=>$dt->format(" Y-m-d").'T'.$shift_schedule->shift->start_time,
			    	'end'=>$dt->format(" Y-m-d").'T'.$shift_schedule->shift->end_time,
			    	'color' =>$col,
			    	'id'=>$shift_schedule->id];
			}

			$i++;
		}

			if(isset($dispemp)):
			return response()->json($dispemp);
			else:
			$dispemp=['title'=>'Nil','start'=>'2016-09-09'];
			return response()->json($dispemp);
			endif;


	}
	public function userShiftScheduleDetails(Request $request,$id)
	{
		$user_shift_schedule=UserShiftSchedule::find($id);
		$shift_id=$user_shift_schedule->shift_id;
		$users=UserShiftSchedule::find($id)
		->schedule
		->users()
		->whereHas('usershiftschedules.shift' ,function ($query) use($shift_id) {
				    $query->where('shift_id', '!=', $shift_id);
				})
		->get();
		$shifts=Shift::where('id','!=',$shift_id)->get();
		return response()->json(['users'=>$users,'shifts'=>$shifts]);
	}
	public function swapShift(Request $request)
	{
		$userShiftSchedule=UserShiftSchedule::find($request->user_shift_schedule_id);
		$shiftSwap=ShiftSwap::where(['owner_id'=>Auth::user()->id,'user_shift_schedule_id'=>$request->user_shift_schedule_id,'date'=>$request->date])->first();
		if ($shiftSwap) {
			return  response()->json('exists',401);
		}

		ShiftSwap::create(['owner_id'=>Auth::user()->id,'swapper_id'=>$request->swapper_id,'approved_by'=>0,'user_shift_schedule_id'=>$request->user_shift_schedule_id,'status'=>0,'reason'=>$request->reason,'new_shift_id'=>$request->shift_id,'date'=>$request->date]);
		return  response()->json('success',200);
	}
	public function myShiftSwaps()
	{
		
		$initiatedShiftSwaps=ShiftSwap::where(['owner_id'=>Auth::user()->id])->get();
		$suggestedShiftSwaps=ShiftSwap::where(['swapper_id'=>Auth::user()->id])->get();
		return view('attendance.myShiftSwaps',compact('initiatedShiftSwaps','suggestedShiftSwaps'));
	}
	public function shiftSwaps()
	{
		$shiftswaps=ShiftSwap::all();
		return view('attendance.shiftSwaps',compact('shiftswaps'));
	}
	public function cancelShiftSwap($shiftSwap_id)
	{
		$shiftSwap=ShiftSwap::where(['owner_id'=>Auth::user()->id,'id'=>$shiftSwap_id,'status'=>0]);
		if ($shiftSwap) {
			$shift->delete();
			return  response()->json('success',200);
		}else{
			return response()->json('denied',200);
		}
	}
	public function rejectShiftSwap($shiftSwap_id)
	{
		$shiftSwap=ShiftSwap::where(['id'=>$shiftSwap_id,'status'=>0]);
		if ($shiftSwap) {
			$shift->update(['status' => 2,'approved_by'=>Auth::user()->id]);
			return  response()->json('success',200);
		}else{
			return response()->json('denied',200);
		}
	}
	public function approveShiftSwap($shiftSwap_id)
	{
		$shiftSwap=ShiftSwap::where(['id'=>$shiftSwap_id,'status'=>0]);
		if ($shiftSwap) {
			$shift->update(['status' => 1,'approved_by'=>Auth::user()->id]);
			return  response()->json('success',200);
		}else{
			return response()->json('denied',200);
		}
	}
	public function shift_schedules(){
		$shift_schedules=ShiftSchedule::all();
		return view('attendance.shiftSchedules',compact('shift_schedules'));
	}
	public function shift_schedule_details($shift_schedule_id){
		$shift_schedule=ShiftSchedule::find($shift_schedule_id);

		return view('attendance.viewShiftSchedule',compact('shift_schedule'));
	}
	public function schedule_shift(Request $request)
	{
		$startdate=$request->startdate;
		$enddate=$request->enddate;
		$users=User::all();
		$shifts=Shift::all()->toArray();
		$shifts_count=Shift::all()->count();
		$schedule_exists=ShiftSchedule::whereBetween('start_date', [date('Y-m-d',strtotime($startdate)),date('Y-m-d',strtotime($enddate))])->count();
		if ($schedule_exists>0) {
			return 'exists';
		}
		$shiftadd=0;
		$last_shift_schedule=ShiftSchedule::latest()->first();
		$shift_schedule=new ShiftSchedule();
		$shift_schedule->start_date= date('Y-m-d',strtotime($startdate));
		$shift_schedule->end_date=date('Y-m-d',strtotime($enddate));
		$shift_schedule->save();
		if ($last_shift_schedule) {
			foreach ($users as $user) {
			$last_user_shift_schedule=$user->usershiftschedules()->latest()->first();
			$shift_index= array_search($last_user_shift_schedule->shift_id,$shifts);
			if ($last_user_shift_schedule->shift_id==$shifts[$shiftadd]['id']&&$shift_index==$shifts_count-1) {
				$user->shifts()->attach($shifts[0]['id'], ['shift_schedule_id' => $shift_schedule->id,'created_at'=>date('Y-m-d h:i:s'),'updated_at'=>date('Y-m-d h:i:s')]);
			}elseif ($last_user_shift_schedule->shift_id==$shifts[$shiftadd]['id']&&$shift_index<$shifts_count-1) {
				$user->shifts()->attach($shifts[$shift_index+1]['id'], ['shift_schedule_id' => $shift_schedule->id,'created_at'=>date('Y-m-d h:i:s'),'updated_at'=>date('Y-m-d h:i:s')]);
			}else{
				$user->shifts()->attach($shifts[$shift_index+1]['id'], ['shift_schedule_id' => $shift_schedule->id,'created_at'=>date('Y-m-d h:i:s'),'updated_at'=>date('Y-m-d h:i:s')]);
			}
			
		// $shiftadd++;
				if ($shiftadd==$shifts_count-1) {
					$shiftadd=0;
				}else{
					$shiftadd++;
				}

			}
		} else{
			foreach ($users as $user) {
				
			$user->shifts()->attach($shifts[$shiftadd]['id'], ['shift_schedule_id' => $shift_schedule->id]);
		if ($shiftadd==$shifts_count-1) {
					$shiftadd=0;
				}else{
					$shiftadd++;
				}

			}
			
		}
		

		return 'success';
	}
	public function queueTimesheet($month=0,$year=0)
	{
		// \Artisan::queue('timesheet:month',['month' => $month,'year'=>$year, '--queue' => 'default']);
		\Artisan::call('queue:work');
		return redirect('timesheets');
	}
	public function timesheetExcel($timesheet_id)
	{
		$timesheet=Timesheet::find($timesheet_id);
		$holidays=Holiday::whereMonth('date',$timesheet->month)->whereYear('date',$timesheet->year)->get();
		$view='attendance.exceltimesheet';
		$this->exportToExcel($timesheet,$holidays,$view);

	}
	private function exportToExcel($datas,$holidays,$view){

        return     \Excel::create("$view", function($excel) use ($datas,$view,$holidays) {

            $excel->sheet("$view", function($sheet) use ($datas,$view,$holidays) {
                $sheet->loadView("$view",compact("datas","holidays"))
                ->setOrientation('landscape');
            });

        })->export('xlsx');
    }


	public function timesheets()
	{
		$timesheets=Timesheet::all();
		return view('attendance.timesheet',compact('timesheets'));
	}
	public function timesheetDetail($timesheet_id)
	{
		$timesheet=Timesheet::find($timesheet_id);
		return view('attendance.timesheetdetails',compact('timesheet'));
	}
	public function userTimesheetDetail($user_id)
	{
		// $user=User::find($user_id);
		$detail=TimesheetDetail::where('user_id',$user_id)->get()->first();
		return view('attendance.partials.userTimesheetDetails',compact('detail'));
	}
	public function getDetails($attendance_id)
	{
		$attendancedetails=Attendance::find($attendance_id)->attendancedetails;
		return view('attendance.partials.AttendanceDetails',compact('attendancedetails'));
	}

	public function getWorkingDays(Request $request)
	{
		$timesheet=[];
		$tdays=[];
		$users=User::all();
		$count=$users->count();
		$days=cal_days_in_month(CAL_GREGORIAN,$request->month,$request->year);
		$total_hours=0;
		foreach ($users as $user) {
			
			$monthHours=$this->getMonthHours($user->emp_num,$request->month,$request->year);
			$weekdayHours=$this->getWeekdayHours($user->emp_num,$request->month,$request->year);
			$basicWorkHours=$this->getBasicWorkHours($user->emp_num,$request->month,$request->year);
			$overtimeWeekdayHours=$this->getOvertimeWeekdayHours($user->emp_num,$request->month,$request->year);
			$overtimeSaturdaysHours=$this->getOvertimeSaturdaysHours($user->emp_num,$request->month,$request->year);
			$overtimeSundaysHours=$this->getOvertimeSundaysHours($user->emp_num,$request->month,$request->year);
			$overtimeHolidaysHours=$this->getOvertimeHolidayHours($user->emp_num,$request->month,$request->year);
			$expectedworkhours=$this->getExpectedHours($user->emp_num,$request->month,$request->year);
			$expectedworkdays=$this->getExpectedDays($user->emp_num,$request->month,$request->year);
			$timesheet[$user->id]['sn']=$count;
			$timesheet[$user->id]['badge_no']=$user->emp_num;
			$timesheet[$user->id]['name']=$user->name;
			$timesheet[$user->id]['position']=$user->position->name;
			$timesheet[$user->id]['staff_location']=$user->position->name;
			$timesheet[$user->id]['category']=$user->position->name;
			$timesheet[$user->id]['employee_type']=$user->position->name;
			// $timesheet[$user->id]['cost_center']=$user->cost_center->code;
			for ($i=1; $i <=$days ; $i++) { 

				$timesheet[$user->id][$i]=$this->getDayHours($user->emp_num,$request->year.'-'.$request->month.'-'.$i);
				$tdays[$user->id][$i]=$timesheet[$user->id][$i];
				$total_hours+=$timesheet[$user->id][$i];
			}
			$timesheet[$user->id]['total_hours']=$total_hours;
			$timesheet[$user->id]['weekdayHours']=$weekdayHours;
			$timesheet[$user->id]['basicWorkHours']=$basicWorkHours;
			$timesheet[$user->id]['overtimeWeekdayHours']=$overtimeWeekdayHours;
			$timesheet[$user->id]['overtimeSaturdaysHours']=$overtimeSaturdaysHours;
			$timesheet[$user->id]['overtimeHolidaysHours']=$overtimeHolidaysHours;
			$timesheet[$user->id]['overtimeSundaysHours']=$overtimeSundaysHours;
			$timesheet[$user->id]['monthHours']=$monthHours;
			$timesheet[$user->id]['expectedworkhours']=$expectedworkhours;
			$timesheet[$user->id]['expectedworkdays']=$expectedworkdays;
			$timesheet[$user->id]['test']=$this->testTime("$request->year-$request->month-25");
			

		}
		return $timesheet;
		// $attendances = Attendance::where('emp_num'=>$request->emp_num)
		// 			->whereMonth('created_at', '7')
		// 			 ->whereYear('created_at', '2018')
		// 			 ->get();
		//  foreach ($attendances as $attendance) {
		//  	$attendance->attendancedetails;
		//  }
	}
	public function getDayHours($emp_num,$date)
	{
		$wp=WorkingPeriod::all()->first();
		$hours=0;
		$diff=0;
		$time='';
		// dd($date);
		$attendance=Attendance::has('attendancedetails')->whereDate('date', $date)->where('emp_num',$emp_num)->first();
		
		if ($attendance ) {
			$details = \App\AttendanceDetail::whereHas('attendance', function ($query) use ($emp_num,$date) {
				    $query->whereDate('date', $date)->where('emp_num',$emp_num);
				})->orderBy('id','asc')->get();
			// $details=$attendance->attendancedetails->orderBy('id','desc');
		// $acount=$attendance->attendancedetails->count();
			$time=$details->first()->clock_in;
			foreach ($details as $detail) {
				$hours+=$this->get_time_difference($detail->clock_in, $detail->clock_out);
			}
			$diff=$this->time_diff($time,$wp->sob);
			if ($diff>0) {
				return $hours-$diff;
			}

		}
		
			return $hours;
	}
		
	public function getMonthHours($emp_num,$month,$year)
	{
		$total_hours=0;
		$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
		for ($i=1; $i <=$days ; $i++) { 
				$total_hours+=$this->getDayHours($emp_num,$year.'-'.$month.'-'.$i);
				
			}
			return $total_hours;
	}

	public function getWeekdayHours($emp_num,$month,$year)
	{
		$total_hours=0;
		$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
		for ($i=1; $i <=$days ; $i++) { 
			if (date('N',strtotime("$year-$month-$i"))<6 && $this->checkHoliday("$year-$month-$i")==false) {
				$total_hours+=$this->getDayHours($emp_num,$year.'-'.$month.'-'.$i);
			}
				
				
		}
			return $total_hours;

	}
	public function getBasicWorkHours($emp_num,$month,$year)
	{
		$wp=WorkingPeriod::all()->first();
		$expectedworkhours=$this->get_time_difference($wp->sob, $wp->cob)-1;
		$total_hours=0;
		$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
		// return $expectedworkhours;
		for ($i=1; $i <=$days ; $i++) { 
			if (date('N',strtotime("$year-$month-$i"))<6 && $this->checkHoliday("$year-$month-$i")==false) {
				if ($this->getDayHours($emp_num,"$year-$month-$i")>=$expectedworkhours) {
					$total_hours+=$expectedworkhours;
				}else{
					$total_hours+=$this->getDayHours($emp_num,$year.'-'.$month.'-'.$i);
				}
			}
				
				
		}
			return $total_hours;

	}
	public function getOvertimeWeekdayHours($emp_num,$month,$year)
	{
		$wp=WorkingPeriod::all()->first();
		$expectedworkhours=$this->get_time_difference($wp->sob, $wp->cob)-1;
		$total_hours=0;
		$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
			for ($i=1; $i <=$days ; $i++) { 
				if (date('N',strtotime("$year-$month-$i"))<6 && $this->checkHoliday("$year-$month-$i")==false) {
					if ($this->getDayHours($emp_num,"$year-$month-$i")>$expectedworkhours) {
						$total_hours+=$this->getDayHours($emp_num,"$year-$month-$i")-$expectedworkhours;
					}
				}
					
					
			}
			return $total_hours;
	}
	public function getOvertimeSaturdaysHours($emp_num,$month,$year)
	{
		$total_hours=0;
		$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
			for ($i=1; $i <=$days ; $i++) { 
				if (date('N',strtotime("$year-$month-$i"))==6 && $this->checkHoliday("$year-$month-$i")==false) {
					$total_hours+=$this->getDayHours($emp_num,$year.'-'.$month.'-'.$i);
				}
					
					
			}
			return $total_hours;
	}
	public function getOvertimeSundaysHours($emp_num,$month,$year)
	{
		$total_hours=0;
		$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
			for ($i=1; $i <=$days ; $i++) { 
				if (date('N',strtotime("$year-$month-$i"))==7 && $this->checkHoliday("$year-$month-$i")==false) {
					$total_hours+=$this->getDayHours($emp_num,$year.'-'.$month.'-'.$i);
				}
					
					
			}
			return $total_hours;
	}
	public function getOvertimeHolidayHours($emp_num,$month,$year)
	{
		
		$total_hours=0;
		$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
			for ($i=1; $i <=$days ; $i++) { 
				if ( $this->checkHoliday($year.'-'.$month.'-'.$i)==true) {
					$total_hours+=$this->getDayHours($emp_num,$year.'-'.$month.'-'.$i);
				}
					
					
			}
			return $total_hours;
	}
	public function getExpectedHours($emp_num,$month,$year)
	{
		$wp=WorkingPeriod::all()->first();
		$expectedworkhours=$this->get_time_difference($wp->sob, $wp->cob)-1;
		$total_hours=0;
		$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
		// return $expectedworkhours;
		for ($i=1; $i <=$days ; $i++) { 
			if (date('N',strtotime("$year-$month-$i"))<6 && $this->checkHoliday("$year-$month-$i")==false) {
				
					$total_hours+=$expectedworkhours;
				
			}
				
				
		}
			return $total_hours;
	}
	public function getExpectedDays($emp_num,$month,$year)
	{
		$wp=WorkingPeriod::all()->first();
		// $expectedworkhours=$this->get_time_difference($wp->sob, $wp->cob)-1;
		$total_days=0;
		$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
		// return $expectedworkhours;
		for ($i=1; $i <=$days ; $i++) { 
			if (date('N',strtotime("$year-$month-$i"))<6 && $this->checkHoliday("$year-$month-$i")==false) {
				
					$total_days++;
				
			}
				
				
		}
			return $total_days;
	}
	public function get_time_difference($time1, $time2)
	{
		$time1 = strtotime("1/1/2018 $time1");
		$time2 = strtotime("1/1/2018 $time2");

	if ($time2 < $time1)
	{
		$time2 = $time2 + 86400;
	}

	return ($time2 - $time1) / 3600;

	}
	public function time_diff($time1, $time2)
	{
		$time1 = strtotime("1/1/2018 $time1");
		$time2 = strtotime("1/1/2018 $time2");

	// if ($time2 < $time1)
	// {
	// 	$time2 = $time2 + 86400;
	// }

	return ($time2 - $time1) / 3600;
	}
	public function checkHoliday($date)
	{
		$has_holiday=Holiday::whereDate('date', $date)->first();
		$retVal = ($has_holiday) ? true : false ;
		return $retVal;
	}
	public function testTime($date)
	{
		$wp=WorkingPeriod::all()->first();
		$hours=0;
		$diff=0;
		$time='';
		// dd($date);
		$attendance=Attendance::whereDate('date', $date)->first();
		if ($attendance) {
			$details = \App\AttendanceDetail::whereHas('attendance', function ($query) use ($date) {
				    $query->whereDate('date', $date);
				})->orderBy('id','desc')->get();
			// $details=$attendance->attendancedetails->orderBy('id','desc');
		// $acount=$attendance->attendancedetails->count();
			$time=$details->first()->clock_in;
			foreach ($details as $detail) {
				$hours+=$this->get_time_difference($detail->clock_in, $detail->clock_out);
			}
			$diff=$this->get_time_difference($time,$wp->sob);


		}
		
			return $diff;
	}
	public function viewAttendanceCalendar($value='')
	{
		return view('xtrafeature.attendance360');
	}
	public function displayCalendar(Request $request)
	{
		try {
			$attendances=DailyAttendance::whereBetween('date',[$request->start,$request->end])->get();
			
			
		$emps=\DB::table('users')
						->join('daily_attendance','users.emp_num','=','daily_attendance.emp_num')
						->select('users.name','daily_attendance.clock_in as startdate')
						->whereBetween('daily_attendance.date',[$request->start,$request->end])
						->get();
		 
			foreach($emps as $empres):
			
			$dispemp[]=['title'=>$empres->name,'start'=>$empres->startdate];
			 
			endforeach;
			if(isset($dispemp)):
			return response()->json($dispemp);
			else:
			$dispemp=['title'=>'Nil','start'=>'2016-09-09'];
			return response()->json($dispemp);
			endif;
			
		}
		
		catch(\Exception $ex){
			
			return response()->json("Error:$ex");
		}
	}
}