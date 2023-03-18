<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
//session_start();

class ViewRecordsController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
    
	public function index()
    {
		$data = array();
		$data['Heading'] = 'View Records';
		$data['emp_id'] = ''; 
		$data['employee_info'] = array(); 
		return view('admin.employee.view_records',$data);
    }
	
	
	public function store(Request $request)
	{
		$data = array();
		$data['Heading'] = 'View Records';
		$emp_id = $request->input('emp_id');
		

		$all_sarok = DB::table('tbl_sarok_no')
							->join('tbl_transections', 'tbl_transections.transaction_code', '=', 'tbl_sarok_no.transection_type')
							->where('tbl_sarok_no.emp_id', $emp_id)
							->orderBy('tbl_sarok_no.letter_date','ASC')
							->select('tbl_sarok_no.emp_id','tbl_sarok_no.sarok_no','tbl_sarok_no.transection_type','tbl_transections.transaction_name','tbl_transections.transection_table')
							->get();
							
									
		
		//echo '<pre>';
		//print_r($all_sarok);
		//exit;
		
		$transection_info = array();

			foreach($all_sarok as $v_all_sarok)
			{
				$emp_id 			= $v_all_sarok->emp_id;
				$sarok_no 			= $v_all_sarok->sarok_no;
				$transection_type 	= $v_all_sarok->transection_type;
				$transection_table 	= $v_all_sarok->transection_table;
				$transaction_name  	= $v_all_sarok->transaction_name;
				
				if($transection_type == 1 || $transection_type == 2 || $transection_type == 3 ||$transection_type == 4  || $transection_type == 6 || $transection_type == 10 || $transection_type == 8 || $transection_type == 17)
				{
					$transection_info[] = DB::table($transection_table)
										->join('tbl_appointment_info', 'tbl_appointment_info.emp_id', '=', $transection_table.'.emp_id')
										->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', $transection_table.'.emp_id')
										->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', $transection_table.'.br_code')
										->leftjoin('tbl_grade_new', 'tbl_grade_new.grade_code', '=', $transection_table.'.grade_code')
										->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', $transection_table.'.designation_code')
										->leftjoin('tbl_department', 'tbl_department.department_id', '=', $transection_table.'.department_code')
										->leftjoin('tbl_sarok_no', 'tbl_sarok_no.sarok_no', '=', $transection_table.'.sarok_no')	
										->leftjoin('tbl_transections', 'tbl_transections.transaction_code', '=','tbl_sarok_no.transection_type')
										->where($transection_table.'.sarok_no', $sarok_no)	
										->select($transection_table.'.emp_id',$transection_table.'.letter_date',$transection_table.'.sarok_no',$transection_table.'.grade_step',$transection_table.'.basic_salary','tbl_appointment_info.emp_village','tbl_appointment_info.emp_name','tbl_emp_photo.emp_photo','tbl_branch.branch_name','tbl_grade_new.grade_name','tbl_designation.designation_name','tbl_transections.transaction_code','tbl_transections.transaction_name','tbl_department.department_name')
										->first();
				}						
										
				else if($transection_type == 9) // Punishment
				{
					$transection_info[] = DB::table($transection_table)
								->join('tbl_appointment_info', 'tbl_appointment_info.emp_id', '=', $transection_table.'.emp_id')
								->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', $transection_table.'.emp_id')
								->leftjoin('tbl_punishment_type', 'tbl_punishment_type.id', '=', $transection_table.'.punishment_type')
								->leftjoin('tbl_crime', 'tbl_crime.id', '=', $transection_table.'.crime_id')
								->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', $transection_table.'.br_code')
								->leftjoin('tbl_grade_new', 'tbl_grade_new.grade_code', '=', $transection_table.'.grade_code')
								->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', $transection_table.'.designation_code')
								->leftjoin('tbl_department', 'tbl_department.department_id', '=', $transection_table.'.department_code')
								->leftjoin('tbl_sarok_no', 'tbl_sarok_no.sarok_no', '=', $transection_table.'.sarok_no')	
								->leftjoin('tbl_transections', 'tbl_transections.transaction_code', '=','tbl_sarok_no.transection_type')
								->where($transection_table.'.sarok_no', $sarok_no)	
								->select($transection_table.'.emp_id',$transection_table.'.letter_date',$transection_table.'.sarok_no',$transection_table.'.punishment_by',$transection_table.'.punishment_details','tbl_appointment_info.emp_village','tbl_appointment_info.emp_name','tbl_emp_photo.emp_photo','tbl_branch.branch_name','tbl_grade_new.grade_name','tbl_designation.designation_name','tbl_transections.transaction_code','tbl_transections.transaction_name','tbl_department.department_name','tbl_punishment_type.punishment_type','tbl_crime.crime_subject')
								->first();
				}	
				
				else if($transection_type == 7) // Resignation
				{
					$transection_info[] = DB::table($transection_table)
								->join('tbl_appointment_info', 'tbl_appointment_info.emp_id', '=', $transection_table.'.emp_id')
								->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', $transection_table.'.emp_id')
								->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', $transection_table.'.br_code')
								->leftjoin('tbl_grade_new', 'tbl_grade_new.grade_code', '=', $transection_table.'.grade_code')
								->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', $transection_table.'.designation_code')
								->leftjoin('tbl_department', 'tbl_department.department_id', '=', $transection_table.'.department_code')
								->leftjoin('tbl_sarok_no', 'tbl_sarok_no.sarok_no', '=', $transection_table.'.sarok_no')	
								->leftjoin('tbl_transections', 'tbl_transections.transaction_code', '=','tbl_sarok_no.transection_type')
								->where($transection_table.'.sarok_no', $sarok_no)	
								->select($transection_table.'.emp_id',$transection_table.'.letter_date',$transection_table.'.sarok_no',$transection_table.'.effect_date',$transection_table.'.resignation_by','tbl_appointment_info.emp_village','tbl_appointment_info.emp_name','tbl_emp_photo.emp_photo','tbl_branch.branch_name','tbl_grade_new.grade_name','tbl_designation.designation_name','tbl_transections.transaction_code','tbl_transections.transaction_name','tbl_department.department_name')
								->first();
				}	
				
				else if($transection_type == 5) // Heldup
				{
					$transection_info[] = DB::table($transection_table)
								->join('tbl_appointment_info', 'tbl_appointment_info.emp_id', '=', $transection_table.'.emp_id')
								->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', $transection_table.'.emp_id')
								->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', $transection_table.'.br_code')
								->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', $transection_table.'.designation_code')
								->leftjoin('tbl_sarok_no', 'tbl_sarok_no.sarok_no', '=', $transection_table.'.sarok_no')	
								->leftjoin('tbl_transections', 'tbl_transections.transaction_code', '=','tbl_sarok_no.transection_type')
								->where($transection_table.'.sarok_no', $sarok_no)	
								->select($transection_table.'.emp_id',$transection_table.'.letter_date',$transection_table.'.sarok_no',$transection_table.'.what_heldup',$transection_table.'.heldup_time',$transection_table.'.heldup_until_date',$transection_table.'.heldup_cause','tbl_appointment_info.emp_village','tbl_appointment_info.emp_name','tbl_emp_photo.emp_photo','tbl_branch.branch_name','tbl_designation.designation_name','tbl_transections.transaction_code','tbl_transections.transaction_name')
								->first(); 
				}	 
									
						 
			}
		
		
		
		//echo '<pre>';
		//print_r($transection_info);
		//exit;

		
		$data['emp_id'] = $emp_id;
		$data['employee_info'] = $transection_info;
		
		
		
		
		return view('admin.employee.view_records',$data);
		
							

	}
	

}
