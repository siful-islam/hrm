<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Travelallowance extends Model
{
    protected $table = 'tbl_move_tra_allow_con';
    protected $fillable = ['source_br_code','dest_br_code','travel_amt','from_date','to_date'];
}
