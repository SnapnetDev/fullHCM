<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $fillable = ['title', 'date','created_by'];
    public function user()
    {
        return $this->belongsTo('App\User','created_by');
    }
    public function getDateAttribute($value)
    {
    	return date('m/d/Y',strtotime($value));
    }
    
}
