<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table = 'tbl_zone';
    protected $fillable = ['zone_name','zone_code','status'];
}
