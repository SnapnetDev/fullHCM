<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class E360Evaluation extends Model
{
    protected $table="e360_evaluations";
   protected $fillable=['e360_det_id','user_id','evaluator_id','evaluated_at'];

   public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function evaluator()
    {
        return $this->belongsTo('App\User', 'evaluator_id');
    }
    public function det()
    {
        return $this->belongsTo('App\E360Det', 'e360_det_id');
    }
    public function details()
    {
        return $this->hasMany('App\E360EvaluationDetail', 'e360_evaluation_id');
    }
}
