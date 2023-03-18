<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ExtraAllowance extends Model
{
    protected $table = 'extra_allowance';
    protected $fillable = ['extra_allowance_type','extra_allowance_emp_id','extra_allowance_emp_type','extra_allowance_amount','extra_allowance_from_date','extra_allowance_to_date'];
}
