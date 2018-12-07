<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\CompanyScope;



class SpecificSalaryComponent extends Model
{
	protected $table='specific_salary_components';
    protected $fillable=['name','gl_code','project_code','type','comment','emp_id','duration','grants','status','starts','ends','company_id'];
    public function user()
    {
        return $this->belongsTo('App\User','emp_id');
    }
    protected static function boot()
    {
        parent::boot();
      
        static::addGlobalScope(new CompanyScope);
    }
}
