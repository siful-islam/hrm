<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\District;

class Thana extends Model
{
    protected $table = 'tbl_thana';
	
	protected $fillable = [
        'thana_code', 'thana_name', 'district_code', 'status', 'org_code',
    ];
	
	public function district(){
        return $this->belongsToMany(District::class);
    }
}
