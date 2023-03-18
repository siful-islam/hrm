<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dailyallowance extends Model
{
    protected $table = 'tbl_move_bill_allow_con';
    protected $fillable = ['grade_code','breakfast','lunch','dinner','from_date','to_date'];
}
