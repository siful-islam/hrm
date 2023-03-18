<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $table = 'tbl_navbar';
    protected $fillable = ['nav_id','nav_group_id','nav_name','user_access','nav_action','nav_status'];
}
