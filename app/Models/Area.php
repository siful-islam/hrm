<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'tbl_area';
    protected $fillable = ['area_name','area_code','zone_code','status'];
}
