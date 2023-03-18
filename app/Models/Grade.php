<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'tbl_grade';
    protected $fillable = ['grade_name','scale_id','status'];
}
