<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Skill extends Model
{
	protected $table="emp_skills";
	protected $fillable=['skill','experience','rating','remarks','user_id'];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
