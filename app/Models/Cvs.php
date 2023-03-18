<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cvs extends Model
{
    protected $table = 'tbl_emp_basic_info';
    protected $fillable = ['emp_id','emp_name_eng','birth_date','nationality','gender','district_code','thana_code'];
}
