<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'tbl_admin';
    protected $fillable = ['admin_id','emp_id','admin_name','email_address','admin_password','access_label','org_code'];
}
