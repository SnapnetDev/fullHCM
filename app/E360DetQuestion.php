<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class E360DetQuestion extends Model
{
    protected $table="e360_det_questions";
   protected $fillable=['e360_det_id','question'];

   	public function det()
    {
        return $this->belongsTo('App\E360Det', 'e360_det_id');
    }
	public function options()
    {
        return $this->hasMany('App\E360DetQuestionOption', 'e360_det_question_id');
    }
}
