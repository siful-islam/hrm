<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scale extends Model
{
    protected $table = 'tbl_scale';
    protected $fillable = ['scale_id','scale_name','status'];
}
