<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $table = 'tbl_ogranization';
    protected $fillable = ['org_full_name','org_short_name','org_code','org_logo','org_address','org_contact','org_email','org_web_address','org_start_date','org_status'];
}
