<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['emp_num','shift_id','date'];

    public function user()
    {
    	return $this->belongsTo('App\User','emp_num','emp_num');
    }
    public function attendancedetails()
    {
    	return $this->hasMany('App\AttendanceDetail','attendance_id');
    }
    public function shift()
    {
    	return $this->belongsTo('App\User','shift_id');
    }
    
}
