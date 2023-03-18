<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edmssubcategory extends Model
{
    protected $table = 'tbl_edms_subcategory';
    protected $primaryKey = 'subcat_id';
	
	protected $fillable = ['category_id','subcategory_name','status'];
}
