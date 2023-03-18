<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'tbl_emp_training';
	
	protected $fillable = [
        'emp_id', 'br_code', 'designation_code', 'tr_date_from', 'tr_date_to', 'tr_venue', 'tr_venue_other', 'tr_result', 'created_by', 'updated_by',
    ];
}
