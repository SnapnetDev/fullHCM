<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\User;
use App\WorkingPeriod;
use App\Attendance;
use App\Leave;
use App\LeaveRequest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pending_leave_requests=LeaveRequest::where('status',0)->whereYear('start_date', date('Y'))->count();
        $date=date('Y-m-d');
     $yesterday=date('Y-m-d', strtotime('yesterday'));
     $lastmonth=date('m', strtotime('first day of previous month'));
        $absentees= User::whereDoesntHave('attendances', function ($query) use ($date) {
            $query->whereDate('date', $date);

        })->count();
        // $lt=User::whereHas('attendancedetails', function ($query) use ($date) {
        //     $query->whereDate('date', $date);

        // })->count();
        $usersPresent=User::whereHas('attendances', function ($query) use ($date) {
                $query->whereDate('date', $date);
            })->count();
        $yesterday_absentees= User::whereDoesntHave('attendances', function ($query) use ($yesterday) {
            $query->whereDate('date', $yesterday);
        })->count();
        $yesterday_usersPresent=User::whereHas('attendances', function ($query) use ($yesterday) {
                $query->whereDate('date', $yesterday);
            })->count();
        $lates=0;
        $yesterday_lates=0;
        $earlys=0;
        $yesterday_earlys=0;
        $first_clock_in='';
        $diff=0;
        $wp=WorkingPeriod::all()->first();
        
        $users=User::whereHas('attendances', function ($query) use ($date) {
                $query->whereDate('date', $date);
            })->get();
        foreach ($users as $user) {
           
            $first_clock_in=Attendance::where(['emp_num'=>$user->emp_num,'date'=>$date])->first()->attendancedetails()->orderBy('clock_in', 'asc')->first()->clock_in;
            $first_clock_in_yesterday=Attendance::where(['emp_num'=>$user->emp_num,'date'=>$yesterday])->first()->attendancedetails()->orderBy('clock_in', 'asc')->first()->clock_in;
            
        
            $diff=$this->time_diff($first_clock_in,$wp->sob);
            $yesterday_diff=$this->time_diff($first_clock_in_yesterday,$wp->sob);
            if ($diff>0) {
                $earlys++;
            } else {
                $lates++;
            }
            if ($yesterday_diff>0) {
                $yesterday_earlys++;
            } else {
                $yesterday_lates++;
            }   

        }
        $last_month_early_users=\App\TimesheetDetail::orderBy('average_first_clock_in','asc')->take(5)->get();
        $last_month_late_users=\App\TimesheetDetail::orderBy('average_first_clock_in','desc')->take(5)->get();
        $companies=Company::all();
        return view('demo_home',compact('companies','absentees','usersPresent','yesterday_absentees','yesterday_usersPresent','earlys','lates','yesterday_earlys','yesterday_lates','last_month_early_users','last_month_late_users','pending_leave_requests'));
    }
    public function executiveView()
    {
        
        return view('executiveview.index');
    }
    public function executiveViewLeave()
    {
        
        return view('executiveview.leave');
    }
    public function executiveViewAttendance()
    {
        
        return view('executiveview.attendance');
    }
    public function time_diff($time1, $time2)
    {
        $time1 = strtotime("1/1/2018 $time1");
        $time2 = strtotime("1/1/2018 $time2");

    // if ($time2 < $time1)
    // {
    //  $time2 = $time2 + 86400;
    // }

    return ($time2 - $time1) / 3600;
    }
}
