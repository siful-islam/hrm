<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = 'tbl_transfer';
    protected $fillable = ['emp_id','sarok_no','letter_date','effect_date','join_date','br_code','designation_code','grade_code','department_code','report_to','created_at','status','org_code'];
}
