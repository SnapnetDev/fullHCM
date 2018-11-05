<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaryComponent extends Model
{
    protected $table='salary_components';
    protected $fillable=['name','type','constant','formula','comment','status'];

    public function exemptions()
    {
        return $this->belongsToMany('App\User','salary_component_exemptions','salary_component_id','user_id');
    }
}
