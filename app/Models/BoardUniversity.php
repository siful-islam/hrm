<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardUniversity extends Model
{
    protected $table = 'tbl_board_university';
	
	protected $fillable = [
        'board_uni_code', 'board_uni_name', 'status', 'org_code',
    ];
}
