<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayrollPolicy extends Model
{
    protected $table='payroll_policies';
    protected $fillable=['payroll_runs','basic_pay_percentage','user_id','workflow_id'];

    public function editor()
    {
    	return $this->belongsTo('App\User','user_id');
    }
    public function workflow()
    {
    	return $this->belongsTo('App\Workflow','workflow_id');
    }
}
