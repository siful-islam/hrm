<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SLoan extends Model
{
    protected $table = 'emp_loan_applications';
    protected $fillable = ['loan_app_id','emp_app_serial','application_date','bank_account_id','loan_type_id','loan_amount','loan_purpose'];
}
