<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    //
    protected $fillable=['month','year','company_id','workflow_id'];
    protected $table="payroll";

    public function company()
    {
    	return $this->belongsTo('App\Company');
    }

    public function workflow()
    {
    	return $this->belongsTo('App\Workflow');
    }
    public function payroll_details()
    {
    	return $this->hasMany('App\PayrollDetail');
    }
}
