<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permanent extends Model
{
    protected $table = 'tbl_permanent';
    protected $fillable = ['emp_id','sarok_no','punishment_type','punishment_details','punishment_by','status'];
}
