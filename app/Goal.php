<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    //

    protected $fillable =['objective', 'commitment', 'user_id', 'assigned_to', 'goal_cat_id','quarter'];

    public function goalcat(){
    	return $this->belongsTo('App\GoalCat','goal_cat_id')->withDefault();
    }

    public function user(){
    	return $this->belongsTo('App\User','user_id')->withDefault();
    }
    public function rating(){
    	return $this->hasMany('App\Rating','goal_id');
    }
    public function getObjectDetail($type,$yearquarter){
        $id=$this->id;
        $getRating=\App\Rating::whereHas('goal',function($query) use ($id){
                                    $query->where('id',$id);
                                })
                                ->where('quarter', $yearquarter->quarter)
                                    ->whereYear('created_at',$yearquarter->year)
                                    ->value($type);
        return is_null($getRating) ? '[Not Available.]' : $getRating;
    }
}
