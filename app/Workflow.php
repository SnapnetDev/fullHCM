<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Workflow extends Model
{
  protected $fillable=['name'];
  public function stages()
  {
    return $this->hasMany('App\Stage','workflow_id')
    ->orderBy('position', 'asc');
  }
  public function payrolls()
  {
    return $this->hasManyThrough('App\Payroll','App\Stage');
  }
  // public function audit_logs()
  // {
  //     return $this->morphMany('App\AuditLog', 'auditable');
  // }

}
