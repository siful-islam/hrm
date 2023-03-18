<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncrementLetter extends Model
{
    protected $table = 'tbl_increment_letter';
	
	protected $fillable = [
        'letter_date','increment_date','grade_code','old_basic','branch_type','letter_heading','letter_body_1','letter_body_2','letter_body_3',
    ];
}
