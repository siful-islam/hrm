<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'tbl_emp_salary';
    protected $fillable = ['emp_id','transection_id','salary_basic'];
}
