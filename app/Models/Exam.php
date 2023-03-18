<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'tbl_exam_name';
	
	protected $fillable = [
        'exam_code', 'exam_name', 'level_id', 'status', 'org_code',
    ];
}
