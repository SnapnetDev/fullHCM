<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Separation extends Model
{
    protected $table='separations';
    protected $fillable=['user_id','separation_type_id','date_of_separation','days_of_employment'];

    public function seperation_type()
    {
    	return $this->belongsTo('App\SeperationType');
    }
    public function user()
    {
    	return $this->belongsTo('App\User');
    }


}
