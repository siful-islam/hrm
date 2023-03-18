<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffSecurity extends Model
{
    protected $table = 'tbl_staff_security';
    protected $fillable = ['emp_id','diposit_date','diposit_amount','status'];
}
