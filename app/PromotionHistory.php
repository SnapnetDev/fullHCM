<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionHistory extends Model
{
    //
    protected $table='emp_promotion_histories';
    protected $fillable=['user_id','approved_by','approved_on','old_grade_id','grade_id'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function grade()
    {
        return $this->belongsTo('App\Grade','grade_id');
    }
}