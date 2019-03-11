<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class E360MeasurementPeriod extends Model
{
    protected $table="e360_measurement_periods";
   protected $fillable=['from','to'];

   public function dets()
    {
        return $this->hasMany('App\E360Det', 'measurement_period_id');
    }
}
