<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resignation extends Model
{
    protected $table = 'tbl_resignation';
    protected $fillable = ['emp_id','sarok_no','letter_date','effect_date','resignation_by'];
}
