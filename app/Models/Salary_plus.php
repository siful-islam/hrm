<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary_plus extends Model
{
    protected $table = 'tbl_salary_plus';
    protected $fillable = ['item_name','percentage','ho_bo','status'];
}
