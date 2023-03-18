<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Travel extends Model
{
    protected $table = 'tbl_travels';
    protected $fillable = ['emp_id','travel_country','departure_date','return_date','purpose_id','sponsor_by','description'];
}
