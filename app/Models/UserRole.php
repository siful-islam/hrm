<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'tbl_admin_user_role';
    protected $fillable = ['role_id','admin_role_name','role_status'];
}
