<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDailyShift extends Model
{
    protected $table='user_daily_shifts';
<<<<<<< HEAD
    protected $fillable=['user_id','shift_id','starts','ends','sdate'];
=======

>>>>>>> 756669c79ba12453137381addef2325f0d752945

    

    public function user(){
<<<<<<< HEAD
        return $this->belongsTo('App\User')->withDefault();
    }

    public function shift(){
        return $this->belongsTo('App\Shift','shift_id')->withDefault();
=======
    	return $this->belongsTo('App\User')->withDefault();
    }

    public function shift(){
    	return $this->belongsTo('App\Shift','shift_id')->withDefault();
>>>>>>> 756669c79ba12453137381addef2325f0d752945
    }

}
