<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveApproval extends Model
{
    protected $fillable=['leave_request_id','stage_id','comments','status'];
    public function leave_request()
    {
    	return $this->belongsTo('App\LeaveRequest','leave_request_id');
    }
}
