<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Heldup extends Model
{
    protected $table = 'tbl_heldup';
    protected $fillable = ['emp_id','sarok_no','letter_date','br_code','designation_code','what_heldup','heldup_time','heldup_until_date','heldup_cause','status','org_code'];
}
