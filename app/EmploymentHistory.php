<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmploymentHistory extends Model
{
    //
    protected $table="emp_histories";
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
