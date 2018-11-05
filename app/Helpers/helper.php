<?php

function parentCompany(){
	return \App\Company::where('is_parent',1)->get()->first()->name;
}

function punctualityStatus($time){
	$wp=\App\WorkingPeriod::all()->first();
	$time1 = strtotime("1/1/2018 $time1");
		$time2 = strtotime("1/1/2018 $time2");

	return ($time2 - $time1) / 3600;
}
function employeeFirstClockin($emp_num,$date){
	return $ci=\App\Attendance::where(['emp_num'=>$emp_num,'date'=>$date])->first()->attendancedetails()->orderBy('clock_in', 'asc')->first()->clock_in;
}
function employeeLastClockout($emp_num,$date){
	return $co=\App\Attendance::where(['emp_num'=>$emp_num,'date'=>$date])->first()->attendancedetails()->orderBy('clock_out', 'desc')->first()->clock_out;
}
function userAttendanceId($emp_num,$date){
	return $id=\App\Attendance::where(['emp_num'=>$emp_num,'date'=>$date])->first()->id;
}
function time_to_seconds($time) {
    $sec = 0;
    foreach (array_reverse(explode(':', $time)) as $k => $v) $sec += pow(60, $k) * $v;
    return $sec;
}