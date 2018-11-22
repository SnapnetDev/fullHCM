<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
	protected $table="jobroles";
    //
    public function users()
    {
        return $this->hasMany('App\User','job_id');
    }
    public function department()
    {
        return $this->belongsTo('App\Department');
    }
}
