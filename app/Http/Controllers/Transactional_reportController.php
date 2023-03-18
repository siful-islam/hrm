<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
////session_start();

class Transactional_reportController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}	
	
	public function index()
    {
		$data = array();
		$data['Heading'] 		= '';
		$data['action'] 		= '/employee-appointment';
		$data['method'] 		= '';
		$data['method_control'] = '';
		
		$data['transactions'] = DB::table('tbl_transections')
							  ->select('*')
							  ->where('is_effect_salary',1) 
							  ->where('transaction_status',1) 
							  ->get(); 

		return view('admin.reports.transactional',$data);
    }
	
    
	public function show_report($report_category,$date_from,$date_to)
	{
		$data = array();
		
		$data['report_category'] 	= $report_category;
		$data['date_from'] 			= $date_from;
		$data['date_to'] 			= $date_to;
		
		$transactions_table = DB::table('tbl_transections')
							  ->select('transection_table')
							  ->where('transaction_id',$report_category) 
							  ->first(); 

		$table = $transactions_table->transection_table;

		$data['results'] = DB::table($table)
						->join('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', $table.'.emp_id')
						->join('tbl_designation', 'tbl_designation.id', '=', $table.'.designation_code')
						->join('tbl_branch', 'tbl_branch.br_code', '=', $table.'.br_code')
						->join('tbl_grade', 'tbl_grade.id', '=', $table.'.grade_code')
						->join('tbl_scale', 'tbl_scale.scale_id', '=', 'tbl_grade.scale_id')
						->join('tbl_district', 'tbl_district.district_code', '=', 'tbl_emp_basic_info.district_code')
					  	->select($table.'.emp_id',$table.'.letter_date',$table.'.designation_code',$table.'.br_code',$table.'.grade_code',$table.'.br_joined_date','tbl_emp_basic_info.emp_name_eng','tbl_emp_basic_info.father_name','tbl_emp_basic_info.org_join_date','tbl_emp_basic_info.permanent_add','tbl_designation.designation_name','tbl_branch.branch_name','tbl_grade.grade_name','tbl_scale.scale_name','tbl_district.district_code','tbl_district.district_name') 
						->where($table.'.effect_date', '>=', $date_from) 
						->where($table.'.effect_date', '<=', $date_to) 
						->get();
	
		$data['groups'] = DB::table('tbl_designation')
							->select('*')
							->where('status',1) 
							->get(); 

		return view('admin.reports.transactional_report',$data);
							
		
	}	

}
