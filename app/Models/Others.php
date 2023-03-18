<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Others extends Model
{
    protected $table = 'tbl_others';
    protected $fillable = ['emp_id','sarok_no','letter_date','effect_date','designation_code','br_code','grade_code','department_code','report_to','next_increment_date','created_by','org_code','status'];
}
