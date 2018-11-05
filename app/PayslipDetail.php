<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayslipDetail extends Model
{
    protected $table='payslip_details';
    protected $fillable=['watermark_text','logo'];
}
