<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NonIdCancel extends Model
{
    protected $table = 'tbl_emp_non_id_cancel';
    protected $fillable = ['emp_id','emp_code','emp_type','br_code','cancel_date','cancel_date','cancel_by'];
}
