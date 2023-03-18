<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'tbl_branch';
    protected $fillable = ['br_code','branch_name','branch_contact_no','branch_email','branch_address','start_date','area_code','status'];
}
