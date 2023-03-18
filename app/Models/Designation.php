<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = 'tbl_designation';
    protected $fillable = ['designation_name','designation_bangla','is_reportable','status'];
}
