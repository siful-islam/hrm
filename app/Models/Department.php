<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'tbl_department';
    protected $fillable = ['department_id','dept_name','dept_bangla','dept_status'];
}
