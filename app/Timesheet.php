<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $table="timesheets";
    protected $fillable=['month','year'];

    public function timesheetdetails()
    {
        return $this->hasMany('App\TimesheetDetail','timesheet_id');
    }
}
