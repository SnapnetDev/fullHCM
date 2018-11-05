<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecificSalaryComponent extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User','emp_id');
    }
}
