<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecificSalaryComponent extends Model
{
	protected $table='specific_salary_components';
    protected $fillable=['name','gl_code','project_code','type','comment','emp_id','duration','grants','status','starts','ends'];
    public function user()
    {
        return $this->belongsTo('App\User','emp_id');
    }
}
