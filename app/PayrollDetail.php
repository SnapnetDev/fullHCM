<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayrollDetail extends Model
{
    
    protected $fillable=['payroll_id','user_id','annual_gross_pay','gross_pay','basic_pay','deductions','allowances','working_days','worked_days','details','is_anniversary','taxable_income','annual_paye','paye'];
    protected $table='payroll_details';
    public function payroll()
    {
    	return $this->belongsTo('App\Payroll','payroll_id');
    }
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
