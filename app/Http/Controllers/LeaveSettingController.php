<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeavePeriod;
use App\Holiday;
use App\Shift;
use App\Grade;
use App\Leave;
use App\Setting;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class LeaveSettingController extends Controller
{
    public function index($value='')
	{
		$holidays=Holiday::all();
		$leaveperiods=LeavePeriod::all();
		$leaves=Leave::all();
		$grades=Grade::doesntHave('leaveperiod')->get();
		$shifts=Shift::all();
		$leave_includes_holiday=Setting::where('name','leave_includes_holiday')->first();
		$leave_includes_weekend=Setting::where('name','leave_includes_weekend')->first();
		return view('settings.leavesettings.index',compact('holidays','leaveperiods','grades','shifts','leaves','leave_includes_holiday','leave_includes_weekend'));
	}
	public function switchLeaveIncludesHoliday(Request $request)
	  {
	    $setting=Setting::where('name','leave_includes_holiday')->first();
	    if ($setting->value==1) {
	     $setting->update(['value'=>0]);
	      return 2;
	    }elseif($setting->value==0){
	      $setting->update(['value'=>1]);
	       return 1;
	    }
	  }
	  public function switchLeaveIncludesWeekend(Request $request)
	  {
	    $setting=Setting::where('name','leave_includes_weekend')->first();
	    if ($setting->value==1) {
	     $setting->update(['value'=>0]);
	      return 2;
	    }elseif($setting->value==0){
	      $setting->update(['value'=>1]);
	       return 1;
	    }
	  }
	public function saveHoliday(Request $request)
	{
		Holiday::updateorCreate(['id'=>$request->holiday_id],['title'=>$request->title,'date'=>date('Y-m-d',strtotime($request->date)),'created_by'=>Auth::user()->id]);
		return  response()->json('success',200);
	}
	public function getHoliday($holiday_id)
	{
		$holiday=Holiday::find($holiday_id);
		return  response()->json($holiday,200);
	}
	public function deleteHoliday($holiday_id)
	{
		$holiday=Holiday::find($holiday_id);
		if ($holiday) {
			$holiday->delete();
		}else{
			return  response()->json(['failed'],200);
		}
		return  response()->json(['success'],200);
	}
	public function saveLeave(Request $request)
	{
		Leave::updateorCreate(['id'=>$request->leave_id],['name'=>$request->name,'created_by'=>Auth::user()->id]);
		return  response()->json('success',200);
	}
	public function getLeave($leave_id)
	{
		$leave=Leave::find($leave_id);
		return  response()->json($leave,200);
	}
	public function deleteLeave($leave_id)
	{
		$leave=Leave::find($leave_id);
		if ($leave) {
			$leave->delete();
		}else{
			return  response()->json(['failed'],200);
		}
		return  response()->json(['success'],200);
	}

	
	public function saveShift(Request $request)
	{
		Shift::updateOrCreate(['id'=>$request->shift_id],['type'=>$request->type,'start_time'=>$request->start_time,'end_time'=>$request->end_time]);
		return  response()->json('success',200);
	}
	public function getShift($shift_id)
	{
		$shift=Shift::find($shift_id);
		return  response()->json($shift,200);
	}
	public function deleteShift($shift_id)
	{
		$shift=Shift::find($shift_id);
		if ($shift) {
			$shift->delete();
		}else{
			return  response()->json(['failed'],200);
		}
		return  response()->json(['success'],200);
	}
	
}
