<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'email','address','user_id','logo'];
    
    public function users()
    {
        return $this->hasMany('App\User','company_id');
    }
    public function departments()
    {
        return $this->hasMany('App\Department');
    }
    public function branches()
    {
        return $this->hasMany('App\Branch');
    }
    public function weekend()
    {
        return $this->hasOne('App\Weekend');
    }
    public function workingperiod()
    {
        return $this->hasOne('App\WorkingPeriod');
    }
    public function jobs()
    {
       return $this->hasManyThrough('App\Job','App\Department');
    }
    public function manager()
    {
        return $this->belongsTo('App\User','user_id');
    }
   
}
