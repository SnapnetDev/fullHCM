<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
	protected $table="jobroles";
    protected $fillable=['name','department_id','parent_id','description','personnel'];
    //
    public function users()
    {
        return $this->belongsToMany('App\User','employee_job','job_id','user_id')->withPivot('started', 'ended')->withTimestamps();
    }
    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function skills()
    {
        return $this->belongsToMany('App\Skill')->using('App\UserSkillCompetency')->withTimestamps()->withPivot('competency_id');
    }

    public function parent()
    {
       return $this->belongsTo('App\Job','parent_id');
    }

    public function children()
    {
       return $this->hasMany('App\Job','parent_id');
    }
}
