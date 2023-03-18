<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'tbl_promotion';
    protected $fillable = ['emp_id','sarok_no','letter_date','effect_date','designation_code','br_code','grade_code','department_code','report_to','next_increment_date','promotion_type','created_by','org_code','status'];
}
