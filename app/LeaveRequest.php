<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
	
    protected $fillable=['leave_id','start_date','end_date','paystatus','priority','reason','absence_doc','user_id','workflow_id','status'];
     public function leave()
    {
    	return $this->belongsTo('App\Leave','leave_id');
    }
    public function leave_approvals()
    {
    	return $this->hasMany('App\LeaveApproval','leave_request_id');
    }
     public function user()
    {
    	return $this->belongsTo('App\User','user_id');
    }
}
