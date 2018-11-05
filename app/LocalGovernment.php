<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalGovernment extends Model
{
    protected $table='cities';
    public function state()
    {
    	return $this->belongsTo('App\State','state_id');
    }
}
