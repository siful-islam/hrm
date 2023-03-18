<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'tbl_district';
	
	protected $fillable = [
        'district_code', 'district_name', 'status', 'org_code',
    ];
}
