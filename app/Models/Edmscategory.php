<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edmscategory extends Model
{
    protected $table = 'tbl_edms_category';
    protected $primaryKey = 'category_id';
	
	protected $fillable = ['category_name', 'status'];
}
