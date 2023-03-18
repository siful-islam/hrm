<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Punishment_type extends Model
{
    protected $table 	= 'tbl_punishment_type';
    protected $fillable = ['punishment_type','status'];
}
