<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;

class TmsaComponent extends Model
{
    protected $table='tmsa_components';
    protected $fillable=['company_id','name','constant','amount','status','type','taxable','comment','gl_code','project_code'];

    public function company()
    {
    	return $this->belongsTo('App\Company','company_id');
    }
    public function exemptions()
    {
        return $this->belongsToMany('App\User','tmsa_component_exemptions','tmsa_component_id','user_id');
    }
    public function payrolls()
    {
        return $this->belongsToMany('App\Payroll','payroll_tmsa_component','tmsa_component_id','payroll_id');
    }
     protected static function boot()
    {
        parent::boot();
      
        static::addGlobalScope(new CompanyScope);
    }
}
