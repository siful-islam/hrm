<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class leave extends Model
{
    protected $table = 'leave_application';
    protected $fillable = ['id','emp_id	','application_date','leave_from','leave_to','remarks','reported_to'];
}
