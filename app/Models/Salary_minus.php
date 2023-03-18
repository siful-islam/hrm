<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary_minus extends Model
{
    protected $table = 'tbl_salary_minus';
    protected $fillable = ['item_name','percentage','ho_bo','status'];
}
