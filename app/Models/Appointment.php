<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'tbl_appointment_info';
    protected $fillable = ['emp_id','letter_date','emp_name','emp_name_bangla','fathers_name','fathers_name_bangla','emp_village','emp_village_bangla','emp_po','emp_po_bangla','emp_district','emp_thana','joining_date','joining_branch','join_as','period','gross_salary','diposit_money','emp_designation','emp_department','reported_to','joined_date','letter_body'];
}
