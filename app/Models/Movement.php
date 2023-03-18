<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $table = 'tbl_movement_register';
    protected $fillable = ['id','emp_id	','from_date','to_date'];
}
