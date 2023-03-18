<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupSubject extends Model
{
    protected $table = 'tbl_subject';
	
	protected $fillable = [
        'subject_code', 'subject_name',
    ];
}
