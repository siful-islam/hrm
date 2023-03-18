<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class Salary_adjustmentController extends Controller
{

    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}


	
	public function index()
    {        	
		$data = array();
		$data['adjustment_info'] = DB::table('tbl_salary_adjustment')
							->join('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'tbl_salary_adjustment.emp_id')
							->select('tbl_salary_adjustment.id','tbl_salary_adjustment.emp_id','tbl_salary_adjustment.letter_date','tbl_salary_adjustment.adjustment_amount','tbl_emp_basic_info.emp_name_eng') 
							->get();				
		return view('admin.payroll.manage_salary_adjustment',$data);
    }
	
	
	public function create()
    {
		$action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		$data = array();
		$data['id'] 				= '';
		$data['emp_id'] 			= '';
		$data['letter_date'] 		= date('Y-m-d');
		$data['effect_date'] 		= date('Y-m-d');
		$data['adjustment_note'] 	= '';
		$data['emp_status'] 		= 'Active';
		$data['basic_salary'] 		= 0;
		$data['new_basic_salary'] 	= 0;
		$data['adjustment_amount'] 	= 0;
		$data['sarok_no'] 			= 0;
		///
		$data['emp_name'] 			= '';
		$data['designation_name'] 	= '';
		$data['joining_date'] 		= '';
		$data['branch_name'] 		= '';
		$data['designation_code'] 	= '';
		$data['br_code'] 			= '';
		$data['grade_code'] 		= '';
		$data['grade_step'] 		= '';
		$data['department_code'] 	= '';
		$data['report_to'] 			= '';
		$data['status'] 			= '';
		$data['emp_photo'] 			= '';
		$data['grade_name'] 			= '';
		///
		$data['action'] 			= '/salary-adjustment';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ''; 	
		$data['button_text'] 		= 'Save';
		
		return view('admin.payroll.salary_adjust_form',$data);	
    }
	
	
	public function store(Request $request)
	{
		$data = request()->except(['_token','_method']);
		$transection_type 	= 9;
		$sarok_id 			= DB::table('tbl_sarok')->max('sarok_no');
		$data['sarok_no'] 		   = $sarok_id+1;

		$data['created_by'] 	= Session::get('admin_id');
		$data['updated_by'] 	= Session::get('admin_id');
		$data['org_code'] 		= Session::get('admin_org_code');

		$max_id = DB::table('tbl_master_tran')
					->where('emp_id', $data['emp_id'])
					->where('letter_date','<=', $data['letter_date'])
					->max('id');
		////
		$pre_data = DB::table('tbl_master_tran')
					->where('id','=', $max_id)
					->first();		
		
		//SET SAROK TABLE//
		$sarok_data['sarok_no']    		= $data['sarok_no'];
		$sarok_data['emp_id'] 	   		= $request->input('emp_id');
		$sarok_data['letter_date'] 		= $request->input('letter_date');
		$sarok_data['transection_type'] = $transection_type; 
	
		//SET FOR MASTER TABLE
		$master_data['emp_id'] 				= $request->input('emp_id');
		$master_data['sarok_no'] 			= $data['sarok_no'];
		$master_data['transection_type']	= $transection_type; 
		$master_data['letter_date'] 		= $request->input('letter_date');
		$master_data['effect_date'] 		= $request->input('effect_date');
		$master_data['br_joined_date'] 		= $pre_data->br_joined_date; 
		$master_data['next_increment_date']	= $pre_data->next_increment_date;
		$master_data['designation_code']	= $pre_data->designation_code;
		$master_data['br_code'] 			= $pre_data->br_code;
		$master_data['grade_code'] 			= $pre_data->grade_code;
		$master_data['grade_step'] 			= $pre_data->grade_step;  
		$master_data['basic_salary'] 		= $request->input('new_basic_salary');  
		$master_data['department_code'] 	= $pre_data->department_code;
		$master_data['report_to'] 			= $pre_data->report_to;
		$master_data['status'] 				= $pre_data->status;
		$master_data['created_by'] 			= Session::get('admin_id');
		$master_data['updated_by'] 			= Session::get('admin_id');
		$master_data['org_code'] 			= Session::get('admin_org_code');

		//DATA MANUPULITION WITH TRANSACTION
		DB::beginTransaction();
		try {				
			//INSERT INTO TRANSACTION TABLE
			DB::table('tbl_salary_adjustment')->insertGetId($data);
			//INSERT INTO SAROK TABLE
			DB::table('tbl_sarok')->insert($sarok_data);
			//INSERT INTO MASTER TABLE
			DB::table('tbl_master_tran')->insert($master_data);
			//COMMIT DB
			DB::commit();
			//PUSH SUCCESS MESSAGE
			Session::put('message','Data Saved Successfully');
		} catch (\Exception $e) {
			//PUSH FAIL MESSAGE
			Session::put('message','Error: Unable to Save Data');
			//DB ROLLBACK
			DB::rollback();
		}		
		//echo '<pre>';
		//print_r($data);		
		return Redirect::to("/salary-adjustment");				
	}
	
	
	public function edit($id)
    {

		$action_id = 3;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		
		$adjust_info 				= DB::table('tbl_salary_adjustment')
										->where('id',$id)
										->first();
		
		$data = array();
		$data['id'] 				= $adjust_info->id;
		$emp_id  					= $adjust_info->emp_id;
		$data['emp_id']  			= $emp_id;
		$letter_date				= $adjust_info->letter_date;
		$data['letter_date']		= $letter_date;
		$data['effect_date']		= $adjust_info->effect_date;
		$data['basic_salary']		= $adjust_info->basic_salary;
		$data['adjustment_amount']	= $adjust_info->adjustment_amount;
		$data['new_basic_salary']	= $adjust_info->new_basic_salary;
		$data['adjustment_note']	= $adjust_info->adjustment_note;
		$data['sarok_no']			= $adjust_info->sarok_no;
		$data['emp_status']			= 'Active';
		///
		$data['emp_name'] 			= '';
		$data['designation_name'] 	= '';
		$data['joining_date'] 		= '';
		$data['branch_name'] 		= '';
		$data['designation_code'] 	= '';
		$data['br_code'] 			= '';
		$data['grade_code'] 		= '';
		$data['grade_step'] 		= '';
		$data['department_code'] 	= '';
		$data['report_to'] 			= '';
		$data['status'] 			= '';
		$data['emp_photo'] 			= '';
		$data['grade_name'] 		= '';
		///
		$data['action'] 			= "/salary-adjustment/$id";
		$data['method'] 			= 'POST';
		$data['method_control'] 	= "<input type='hidden' name='_method' value='PUT' />"; 	
		
		$data['button_text'] 		= 'Update';
		

		$max_id = DB::table('tbl_master_tran')
					->where('emp_id', $emp_id)
					->where('letter_date','<=', $letter_date)
					->max('id');
				
		$employee_info = DB::table('tbl_master_tran')
						->join('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'tbl_master_tran.emp_id')
						->join('tbl_designation', 'tbl_designation.id', '=', 'tbl_master_tran.designation_code')
						->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_master_tran.br_code')
						->join('tbl_grade', 'tbl_grade.id', '=', 'tbl_master_tran.grade_code')
						->join('tbl_scale', 'tbl_scale.scale_id', '=', 'tbl_grade.scale_id')
						->leftJoin('tbl_resignation', 'tbl_resignation.emp_id', '=', 'tbl_master_tran.emp_id')
						->leftJoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_master_tran.emp_id')
						->where('tbl_master_tran.id', $max_id)
						->select('tbl_master_tran.id','tbl_master_tran.emp_id','tbl_master_tran.sarok_no','tbl_master_tran.next_increment_date','tbl_master_tran.designation_code','tbl_master_tran.br_code','tbl_master_tran.grade_code','tbl_master_tran.grade_step','tbl_master_tran.department_code','tbl_master_tran.report_to','tbl_master_tran.is_permanent','tbl_emp_basic_info.emp_name_eng','tbl_emp_basic_info.father_name','tbl_emp_basic_info.org_join_date','tbl_emp_photo.emp_photo','tbl_designation.designation_name','tbl_branch.branch_name','tbl_grade.grade_name','tbl_scale.scale_name','tbl_scale.scale_basic_1st_step','tbl_scale.increment_amount','tbl_resignation.effect_date','tbl_master_tran.transection_type') 
						->first();	

			$data['emp_name'] 				= $employee_info->emp_name_eng;
			$data['joining_date'] 			= $employee_info->org_join_date;
			$data['designation_code'] 		= $employee_info->designation_code;
			$data['designation_name'] 		= $employee_info->designation_name;
			$data['department_code'] 		= $employee_info->department_code;
			$data['report_to'] 				= $employee_info->report_to;
			$data['br_code'] 				= $employee_info->br_code;
			$data['grade_code'] 			= $employee_info->grade_code;
			$data['grade_step'] 			= $employee_info->grade_step;
			$data['branch_name'] 			= $employee_info->branch_name;
			$data['grade_name'] 			= $employee_info->grade_name;
			$data['scale_name'] 			= $employee_info->scale_name;
	

			if($employee_info->emp_photo !='')
			{
				$data['emp_photo'] 			= $employee_info->emp_photo;
			}
			else{
				$data['emp_photo'] 			= 'default.png';
			}			
			$data['resign_date'] 			= $employee_info->effect_date;
			$data['emp_status'] 			= 'Active';			

		return view('admin.payroll.salary_adjust_form',$data);		
		exit;
	}
	
	
	
	public function update(Request $request)
	{
		$data = request()->except(['_token','_method','id','sarok_no']);
		
		$id 		= $request->input('id');
		$sarok_no 	= $request->input('sarok_no');
		
		$master_data['letter_date'] 	= $data['letter_date'];
		$master_data['effect_date'] 	= $data['effect_date'];
		$master_data['basic_salary']	= $data['new_basic_salary'];
		
		
		//DATA MANUPULITION WITH TRANSACTION
		DB::beginTransaction();
		try {				
			//Update TRANSACTION TABLE
			DB::table('tbl_salary_adjustment')
					->where('id', $id)
					->update($data);

			//Update MASTER TABLE
				DB::table('tbl_master_tran')
					->where('sarok_no', $sarok_no)
					->update($master_data);
			//COMMIT DB
			DB::commit();
			//PUSH SUCCESS MESSAGE
			Session::put('message','Data Updated Successfully');
		} catch (\Exception $e) {
			//PUSH FAIL MESSAGE
			Session::put('message','Error: Unable to Updated Data');
			//DB ROLLBACK
			DB::rollback();
		}		
		//echo '<pre>';
		//print_r($data);		
		return Redirect::to("/salary-adjustment");	
	}
	

	private function cheeck_action_permission($action_id)
	{
		$access_label 	= Session::get('admin_access_label');		
		$nav_name 		=  '/'.request()->segment(1);
		$nav_info		= DB::table('tbl_navbar')->where('nav_action',$nav_name)->first();	
		$nav_id 		= $nav_info->nav_id;
		$permission    	= DB::table('tbl_user_permissions')
							->where('user_role_id',$access_label)
							->where('nav_id',$nav_id)
							->where('status',1)
							->first();
		if($permission)
		{
			if(in_array($action_id,$p = explode(",", $permission->permission)))
			{
				return true;
			}
			else
			{
				return false;
			}
		}	
		else
		{
			return false;
		}
	}
}
