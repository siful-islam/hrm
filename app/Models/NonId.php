<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NonId extends Model
{
    protected $table = 'tbl_emp_non_id';
    protected $fillable = ['emp_id','emp_name','father_name','mother_name','birth_date','nationality','religion','contact_num','emp_po','emp_po','email','national_id','maritial_status','gender','blood_group','joining_date','present_add','vill_road','post_office','district_code','thana_code','permanent_add','last_education','referrence_name','nec_phone_num','basic_salary','npa_a','motor_a','motor_a','gross_salary','br_code','designation_code','emp_type','br_join_date','org_code'];
}
