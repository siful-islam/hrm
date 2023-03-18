<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offense extends Model
{
    protected $table 	= 'tbl_crime';
    protected $fillable = ['crime_subject','crime_detail','punishment','status'];
}
