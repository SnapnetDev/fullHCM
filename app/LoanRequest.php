<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;


class LoanRequest extends Model
{
    protected $table='loan_requests';
    protected $fillable=['user_id','amount','netpay','monthly_deduction','deduction_count','period','months_deducted','current_rate','repayment_starts','status','approved_by','completed','created_at','updated_at'];

    public function user()
    {
    	return $this->belongsTo('App\User','user_id');
    }
    protected static function boot()
    {
        parent::boot();
      
        static::addGlobalScope(new CompanyScope);
    }
    public function approver()
    {
    	return $this->belongsTo('App\User','approved_by');
    }
}
