<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuGroup extends Model
{
    protected $table = 'tbl_navbar_group';
    protected $fillable = ['nav_group_id','nav_group_name','grpup_icon','is_sub_menu','user_access'.'nav_group_status'];
}
