<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    protected $table = 'tbl_emp_general_info';
    protected $fillable = ['emp_id','emp_name','father_name','monther_name','date_of_birth','religion','gender','marrital_status','nationality','nid_no','blood_group','joining_date','contact_no','email_address','emp_designation','village','post_office','police_station','district','present_address'];
}
