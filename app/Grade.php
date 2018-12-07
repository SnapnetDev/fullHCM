<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
     protected $fillable = ['level','basic_pay','leave_length','lateness_policy_id','company_id'];
    public function leaveperiod()
    {
        return $this->hasOne('App\LeavePeriod','grade_id');
    }
    public function lateness_policy()
    {
    	return $this->belongsTo('App\LatenessPolicy','lateness_policy_id');
    }


}
