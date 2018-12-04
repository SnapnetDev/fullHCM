<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublishedGoalFY extends Model
{
    //
    protected $table="published_goal_FY";
    protected $fillable=['year','published'];
}
