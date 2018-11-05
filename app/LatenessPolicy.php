<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LatenessPolicy extends Model
{
   protected $table="lateness_policies";
   protected $fillable=['late_minute','deduction_type','deduction','status','policy_name'];

  public function grades()
  {
  	return $this->hasMany('App\Grade','grade_id');
  }
}
