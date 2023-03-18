<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Probation extends Model
{
    protected $table = 'tbl_probation';
    protected $fillable = ['emp_id','sarok_no','letter_date','effect_date','designation_code','br_code','grade_code','department_code','report_to','probation_time','next_increment_date','created_by','org_code','status'];
}
