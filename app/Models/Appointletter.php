<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointletter extends Model
{
    protected $table = 'tbl_appointment_letter';
    protected $fillable = ['emp_id','letter_body'];
}
