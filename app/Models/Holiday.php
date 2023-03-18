<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $table = 'tbl_holidays';
    protected $fillable = ['holiday_name','description','description_bn','holiday_date'];
}
