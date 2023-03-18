<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer_remarks extends Model
{
    protected $table = 'tbl_transfer_remarks';
    protected $fillable = ['remarks_note','status'];
}
