<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $table = 'supervisor_mapping_ho';
    protected $fillable = ['emp_id','supervisor_id','supervisor_designation','active_from','mapping_status'];
}
