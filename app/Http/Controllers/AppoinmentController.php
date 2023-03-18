<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Appointment;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class AppoinmentController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	public function index()
    {        	
		$data = array();
		//$data['all_appointment_info'] = DB::table('tbl_appointment_info')->orderBy('emp_id', 'desc')->get();
		return view('admin.employee.manage_appointment',$data);					
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
		$session_branch_code = Session::get('branch_code');
		$data = array();
		$data['id'] 				= 0;
		$data['sarok_no'] 			= '';
		//$data['emp_id'] 			= $this->get_last_emp_id(); 
		$data['emp_id'] 			= 0; 
		$data['letter_date'] 		= date('Y-m-d'); 
		$data['emp_name'] 			= '';
		$data['fathers_name'] 		= '';
		$data['emp_name_bangla'] 	= '';
		$data['fathers_name_bangla']= '';
		$data['reference_id'] = '';
		$data['mother_name']= '';
		$data['mother_name_ban']= '';
		$data['birth_date']= '';
		$data['nationality']= '';
		$data['religion']= '';
		$data['national_id']= '';
		$data['birth_certificate']= '';
		$data['country_id']= '';
		$data['contact_num']= '';
		$data['email']= '';
		$data['maritial_status']= '';
		$data['gender']= '';
		$data['blood_group']= '';
		$data['present_add']= '';
		$data['permanent_add']= '';
		$session_branch_code != 9999 ? $data['emp_group']= 2 : $data['emp_group']= '';
		$data['emp_type']= '';
		$session_branch_code != 9999 ? $data['salary_br_code']= $session_branch_code : $data['salary_br_code']= '';
		
		$data['emp_village_bangla'] = '';
		$data['emp_po_bangla'] 		= '';
		$data['emp_village'] 		= '';
		$data['emp_po'] 			= '';
		$data['emp_district'] 		= '';
		$data['emp_thana'] 			= ''; 
		$data['joining_date'] 		= date('Y-m-d');
		$data['br_join_date'] 		= date('Y-m-d');
		$session_branch_code != 9999 ? $data['joining_branch']= $session_branch_code : $data['joining_branch']= '';
		$session_branch_code != 9999 ? $data['join_as']= 3 : $data['join_as']= 1;
		$data['period'] 			= 6;
		$data['gross_salary'] 		= 0; 
		$data['diposit_money'] 		= 0;
		$data['emp_designation'] 	= '';
		$data['emp_department'] 	= '';
		$session_branch_code != 9999 ? $data['reported_to']= 16 : $data['reported_to']= '';
		$data['joined_date'] 		= date('Y-m-d');
		//$data['next_permanent_date'] = date('Y-m-d',strtotime($data['joining_date'] . "+6 month"));    
		$data['next_permanent_date'] = '';    
		$data['grade_code'] 		= '';
		$data['grade_step'] 		= 0;
		$data['project_id'] 		= '';
		$session_branch_code != 9999 ? $data['mother_program_id']= 1 : $data['mother_program_id']= '';
		$session_branch_code != 9999 ? $data['current_program_id']= 1 : $data['current_program_id']= '';
		$session_branch_code != 9999 ? $data['mother_department_id']= 25 : $data['mother_department_id']= '';
		$session_branch_code != 9999 ? $data['current_department_id']= 25 : $data['current_department_id']= '';
		$session_branch_code != 9999 ? $data['unit_id']= 1 : $data['unit_id']= '';
		//
		$data['action'] 			= '/employee-appointment';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ''; 		
		$data['Heading'] 			= 'Add Appoinment';
		$data['button_text'] 		= 'Save';		
		//		
		$data['all_emp_group'] 		= DB::table('tbl_emp_group')->get();
		//$data['all_emp_type'] 		= DB::table('tbl_emp_type')->whereIn('id', [1, 8, 10])->get();
		$data['branches'] 		    = DB::table('tbl_branch')->where('status',1)->get();
		$data['districts'] 		    = DB::table('tbl_district')->where('status',1)->get();
		$data['thanas'] 		    = DB::table('tbl_thana')->where('status',1)->get();
		$data['departments'] 	    = DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		= DB::table('tbl_designation')->where('status',1)->get();	
		$data['grades'] 		    = DB::table('tbl_grade_new')->where('status',1)->get();
		$data['reportable'] 		= DB::table('tbl_designation')->where('status',1)->where('is_reportable',1)->get();			
		$data['all_unit_name'] 		= DB::table('tbl_unit_name')->where('status',1)->get();			
		$data['all_project'] 		= DB::table('tbl_project')->where('status',1)->get();			
		$data['all_supervisors'] 	= DB::table('supervisors')->where('active_status',1)->get();			
		//
		//Session::put('message','Data Save Successfully, Employee ID is Generated -'. 2692);
		return view('admin.employee.appoiontment_form',$data);	
    }	
	
	public function get_last_emp_id()
	{
		$result = DB::table('tbl_appointment_info')->where('join_as',1)->max('emp_id');
		return $result+1;
	}
	
	public function SelectEmpType($emp_group)
    {  
		$all_emp_type = DB::table('tbl_emp_type')
					  ->select('*')
					  ->where('type_id', $emp_group) 
					  ->where('status', 1) 
                      ->get();
		//print_r ($all_emp_type);			  
		echo "<option value=''>--Select--</option>";
		foreach($all_emp_type as $emp_type){
			echo "<option value='$emp_type->id'>$emp_type->type_name</option>";
		}
    }
	public function SelectUnit($department_code)
    {  
		$all_unit = DB::table('tbl_unit_name')
					  ->select('*')
					  ->where('department_code', $department_code) 
					  ->where('status',1)
                      ->get();
		//print_r ($all_unit);			  
		echo "<option value=''>--Select--</option>";
		foreach($all_unit as $unit){
			echo "<option value='$unit->id'>$unit->unit_name</option>";
		}
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

		$data = array();
		//$appoinment_info = Appointment::find($id);
		$appoinment_info = DB::table('tbl_appointment_info')->where('id', $id)->first();
		//print_r ($appoinment_info);
		$data['id'] 				= $appoinment_info->id;
		$data['sarok_no'] 			= $appoinment_info->sarok_no;
		$data['emp_id'] 			= $appoinment_info->emp_id;
		$data['letter_date'] 		= $appoinment_info->letter_date;
		$data['emp_name'] 			= $appoinment_info->emp_name;
		$data['fathers_name'] 		= $appoinment_info->fathers_name;
		$data['emp_name_bangla'] 	= $appoinment_info->emp_name_bangla;
		$data['fathers_name_bangla']= $appoinment_info->fathers_name_bangla;
		$data['mother_name']		= $appoinment_info->mother_name;
		$data['mother_name_ban']	= $appoinment_info->mother_name_ban;
		$data['birth_date']			= $appoinment_info->birth_date;
		$data['religion']			= $appoinment_info->religion;
		$data['maritial_status']	= $appoinment_info->maritial_status;
		$data['nationality']		= $appoinment_info->nationality;
		$data['national_id']		= $appoinment_info->national_id;
		$data['birth_certificate']	= $appoinment_info->birth_certificate;
		$data['gender']				= $appoinment_info->gender;
		$data['blood_group']		= $appoinment_info->blood_group;
		$data['contact_num']		= $appoinment_info->contact_num;
		$data['email']				= $appoinment_info->email;
		$data['emp_village_bangla'] = $appoinment_info->emp_village_bangla;
		$data['emp_po_bangla'] 		= $appoinment_info->emp_po_bangla;
		$data['emp_village'] 		= $appoinment_info->emp_village;
		$data['emp_po'] 			= $appoinment_info->emp_po;
		$data['emp_district'] 		= $appoinment_info->emp_district;
		$data['emp_thana'] 			= $appoinment_info->emp_thana;
		$data['emp_group'] 			= $appoinment_info->emp_group;
		$data['emp_type'] 			= $appoinment_info->emp_type;
		$data['joining_date'] 		= $appoinment_info->joining_date;
		$data['joining_branch'] 	= $appoinment_info->joining_branch;
		$data['salary_br_code'] 	= $appoinment_info->salary_br_code;
		$data['join_as'] 			= $appoinment_info->join_as;
		$data['period'] 			= $appoinment_info->period;
		$data['gross_salary'] 		= $appoinment_info->gross_salary; 
		$data['diposit_money'] 		= $appoinment_info->diposit_money;
		$data['emp_designation'] 	= $appoinment_info->emp_designation;
		$data['emp_department'] 	= $appoinment_info->emp_department;
		$data['reported_to'] 		= $appoinment_info->reported_to;
		$data['next_permanent_date'] = $appoinment_info->next_permanent_date;
		$data['grade_code'] 		= $appoinment_info->grade_code;
		$data['grade_step'] 		= $appoinment_info->grade_step;
		$data['br_join_date'] 		= $appoinment_info->br_join_date;
		$data['reference_id'] 		= $appoinment_info->reference_id;
		//
		$data['action'] 			= "/employee-appointment/$id";
		$data['method'] 			= 'POST';
		$data['method_control'] 	= "<input type='hidden' name='_method' value='PUT' />"; 		
		$data['Heading'] 			= 'Edit Employee Appointment';
		$data['button_text'] 		= 'Update';
		//	
		$data['letter_link'] 		= "/employee-appointment/$id";
		
		$letter_id = 1;
		if($letter_id ==2)
		{
			$data['letter_link_button'] = 'Create Appointment Letter';  
		}else{
			$data['letter_link_button'] = 'Update Appointment Letter';
		}
		
		$mapping_data = DB::table('tbl_emp_mapping')->where('emp_id',$appoinment_info->emp_id)->first();
		$data['mother_program_id'] 		= $mapping_data->mother_program_id;
		$data['current_program_id'] = $mapping_data->current_program_id;
		$data['mother_department_id'] 		= $mapping_data->mother_department_id;
		$data['current_department_id'] 		= $mapping_data->current_department_id;
		$data['unit_id'] 		= $mapping_data->unit_id;
		$data['project_id'] 		= $mapping_data->project_id;
		
		//print_r($data['mapping_data']); 
		$data['all_emp_group'] 		= DB::table('tbl_emp_group')->get();
		$data['all_emp_type'] 		= DB::table('tbl_emp_type')->get();
		$data['branches'] 		    = DB::table('tbl_branch')->where('status',1)->get();
		$data['districts'] 		    = DB::table('tbl_district')->where('status',1)->get();
		$data['thanas'] 		    = DB::table('tbl_thana')->where('status',1)->get();
		$data['departments'] 	    = DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		= DB::table('tbl_designation')->where('status',1)->get();	
		$data['grades'] 		    = DB::table('tbl_grade_new')->where('status',1)->get();
		$data['steps'] 		    	= DB::table('tbl_steps')->where('step_status',1)->get();
		$data['reportable'] 		= DB::table('tbl_designation')->where('status',1)->where('is_reportable',1)->get();			
		$data['all_unit_name'] 		= DB::table('tbl_unit_name')->where('status',1)->get();			
		$data['all_project'] 		= DB::table('tbl_project')->where('status',1)->get();			
		$data['all_supervisors'] 	= DB::table('supervisors')->where('active_status',1)->get();		
		//
		return view('admin.employee.appoiontment_form',$data);	
	}
	
	
	public function validation($emp_id)
	{
		$appoinment_info = DB::table('tbl_appointment_info')
							->where('tbl_appointment_info.emp_id', $emp_id)
							->select('tbl_appointment_info.emp_id','tbl_appointment_info.id')
							->first();	
							
		$info = DB::table('tbl_permanent')
							->where('tbl_permanent.emp_id', $emp_id)
							->select('tbl_permanent.emp_id','tbl_permanent.id')
							->first();	
		
		
		
		if($info)
		{
			$status = 1;
		}
		else
		{
			$status = 0;
		}


		if($appoinment_info)
		{
			$status = 3;
		}


		
		return	$status; 	
	}
	
	public function SelectNationalId($national_id,$emp_id,$id)
	{
		$info = DB::table('tbl_emp_basic_info')
				->where(function($query) use ($national_id,$emp_id,$id) {
					if($id == 0) {
						$query->where('national_id', $national_id);
					} else {
						$query->where('emp_id', '!=', $emp_id);
						$query->where('national_id', $national_id);
					}	
				})
				->select('emp_id','emp_name_eng')
				->first();		
		
		if(!empty($info->emp_id)){
			echo 0; 
		}else{
			echo 1; 
		}
			
	}
	
	public function store(Request $request)
    {
		$data = request()->except(['_token','_method','mother_program_id','current_program_id','mother_department_id','current_department_id','unit_id','project_id','c_end_date']);
		//$datamap = request()->only(['mother_program','current_program','mother_department','current_department','unit_code']);
		//print_r ($data); exit;
		/* $emp_id = $request->input('emp_id');
		$validation_status = $this->validation($emp_id);
		if($validation_status == 1)
		{
			Session::put('message','This Employee Already Permanent');
			return Redirect::to('/employee-appointment/create');
		}
		
		if($validation_status == 3)
		{
			Session::put('message','This Employee Already Saved');
			return Redirect::to('/employee-appointment/create');
		} */

		$sarok_id = DB::table('tbl_sarok_no')->max('sarok_no');
		$data['sarok_no'] 		   				= $sarok_id+1;
		$data['created_by'] 	   				= Session::get('admin_id');
		$data['org_code'] 		   				= Session::get('admin_org_code');
		$data['grade_code'] 			= ($data['emp_group'] == 1) ? $data['grade_code'] : 27;
		$data['grade_step'] 			= ($data['emp_group'] == 1) ? $data['grade_step'] : 0;
		$data['next_permanent_date'] 	= ($data['emp_group'] == 1) ? $request->input('next_permanent_date') : $request->input('c_end_date');
		// FOR Employee Basic TABLE
		//$basic_data['emp_id'] 			= $data['emp_id'];
		$basic_data['emp_name_eng'] 		= $data['emp_name'];
		$basic_data['emp_name_ban'] 		= $data['emp_name_bangla'];
		$basic_data['father_name'] 			= $data['fathers_name'];
		$basic_data['father_name_ban'] 		= $data['fathers_name_bangla'];
		$basic_data['mother_name'] 			= $data['mother_name'];
		$basic_data['mother_name_ban'] 		= $data['mother_name_ban'];
		$basic_data['birth_date'] 			= $data['birth_date'];
		$basic_data['nationality'] 			= $data['nationality'];
		$basic_data['religion']				= $data['religion'];
		$basic_data['country_id'] 			= '';
		$basic_data['contact_num'] 			= $data['contact_num'];
		$basic_data['email'] 				= $data['email'];
		$basic_data['national_id'] 			= $data['national_id'];
		$basic_data['maritial_status'] 		= $data['maritial_status'];
		$basic_data['gender'] 				= $data['gender'];
		$basic_data['blood_group'] 			= $data['blood_group'];
		$basic_data['present_add'] 			= '';
		$basic_data['vill_road'] 			= $data['emp_village'];
		$basic_data['post_office'] 			= $data['emp_po'];
		$basic_data['district_code'] 		= $data['emp_district'];
		$basic_data['thana_code'] 			= $data['emp_thana'];
		$basic_data['permanent_add'] 		= '';
		$basic_data['org_join_date'] 		= $data['joining_date'];
		$basic_data['emp_group'] 			= $data['emp_group'];
		$basic_data['emp_type'] 			= $data['emp_type'];
		$basic_data['created_by'] 			= Session::get('admin_id');
		//$basic_data['updated_by'] 			= Session::get('admin_id');
		$basic_data['org_code'] 			= Session::get('admin_org_code');	
		//SET SAROK TABLE//
		$sarok_data['sarok_no']    				= $data['sarok_no'];
		//$sarok_data['emp_id'] 	   			= $request->input('emp_id');
		$sarok_data['letter_date'] 				= $request->input('letter_date');
		$sarok_data['transection_type'] 		= 1;		
		// FOR PROBATION TABLE
		//$probation_data['emp_id'] 				= $data['emp_id'];
		$probation_data['sarok_no'] 			= $data['sarok_no'];
		$probation_data['letter_date'] 			= $data['letter_date'];
		$probation_data['effect_date'] 			= $data['joining_date'];
		$probation_data['br_joined_date'] 		= $data['br_join_date'];
		$probation_data['designation_code'] 	= $data['emp_designation'];
		$probation_data['br_code'] 				= $data['joining_branch'];
		$probation_data['grade_code'] 			= ($data['emp_group'] == 1) ? $data['grade_code'] : 27;
		$probation_data['grade_step'] 			= ($data['emp_group'] == 1) ? $data['grade_step'] : 0;
		$probation_data['permanent_date'] 		= ($data['emp_group'] == 1) ? $request->input('next_permanent_date') : $request->input('c_end_date');
		//$probation_data['department_code']	= $data['emp_department'];
		$probation_data['report_to'] 			= $data['reported_to'];
		$probation_data['probation_time'] 		= $data['period'];
		//$probation_data['permanent_date'] 		= $data['next_permanent_date'];
		$probation_data['created_by'] 			= Session::get('admin_id');
		//$probation_data['updated_by'] 			= Session::get('admin_id');
		$probation_data['org_code'] 			= Session::get('admin_org_code');
		$probation_data['status'] 				= 1;				
		//$probation_data['basic_salary'] 	  	= $data['gross_salary'];				
		//SET FOR MASTER Table
		//$master_data['emp_id'] 					= $request->input('emp_id');
		$master_data['sarok_no'] 				= $data['sarok_no'];
		$master_data['tran_type_no']			= 1;
		$master_data['letter_date'] 			= $request->input('letter_date');
		$master_data['effect_date'] 			= $request->input('joining_date');
		if($data['emp_group'] != 1) {	
			$master_data['next_increment_date'] 	= $request->input('c_end_date');  
		}
		$master_data['grade_effect_date'] 		= $request->input('joining_date');  
		$master_data['br_join_date'] 			= $request->input('br_join_date');
		$master_data['designation_code']		= $request->input('emp_designation');
		$master_data['br_code'] 				= $request->input('joining_branch');
		$master_data['salary_br_code'] 			= $request->input('salary_br_code');
		$master_data['grade_code'] 				= ($data['emp_group'] == 1) ? $data['grade_code'] : 27;
		$master_data['grade_step'] 				= ($data['emp_group'] == 1) ? $data['grade_step'] : 0;
		$master_data['basic_salary'] 			= $request->input('gross_salary');
		//$master_data['department_code'] 		= $request->input('emp_department');
		$master_data['report_to'] 				= $request->input('reported_to');
		$master_data['is_permanent']			= $request->input('join_as');
		$master_data['provision_time']			= $request->input('period');
		$master_data['status'] 					= 1;
		$master_data['created_by'] 				= Session::get('admin_id');
		$master_data['org_code'] 				= Session::get('admin_org_code');
		//SET FOR Employee Mapping Table
		//$mapping_data['emp_id'] 					= $request->input('emp_id');
		$mapping_data['mother_program_id'] 		= $request->input('mother_program_id');
		$mapping_data['current_program_id'] 		= $request->input('current_program_id');  
		$mapping_data['mother_department_id'] 	= $request->input('mother_department_id');  
		$mapping_data['current_department_id'] 	= $request->input('current_department_id');
		$mapping_data['unit_id']					= $request->input('unit_id');
		$mapping_data['project_id'] 				= $request->input('project_id');
		$mapping_data['start_date'] 				= $request->input('joining_date');
		$mapping_data['end_date'] 				= '';
		$mapping_data['created_by'] 				= Session::get('admin_id');
		//SET FOR Supervisor Mapping Table
		$supervisor_data['emp_name'] 			= $request->input('emp_name'); 
		$supervisor_data['br_id'] 				= $data['joining_branch'];
		$supervisor_data['supervisor_id'] 		= $request->input('reported_to');  
		$supervisor_data['supervisor_type'] 	= 1;
		$supervisor_data['active_from'] 		= $request->input('joining_date');
		$supervisor_data['mapping_status'] 		= 1;
		$supervisor_data['created_by'] 			= Session::get('admin_id');

		////////////////START SAIFUL///////////
		$leavedata = array();
		$leave_joining_date = date('Y-m-d',strtotime($data['joining_date']));
		$join_year			  = date('Y',strtotime($leave_joining_date)); 
		$join_month 		  = date('m',strtotime($leave_joining_date));
	   if (date('m') <= 6) { 
			$f_year_start  = (date('Y')-1) ;
			$f_year_end    = date('Y');   
		}else{ 
			$f_year_start  = date('Y');  
			$f_year_end    = (date('Y') + 1); 
		}
	 
		$f_date_start   =  date('Y-m-d',strtotime(($f_year_start)."-"."06"."-"."30"));
		$join_day 		= date('d',strtotime($leave_joining_date));
		$additional_day = 0;
		$additional_day_casual = 0;
		if($leave_joining_date > $f_date_start){
			 if($join_day <= 10){
				$additional_day = 2;
			}else if($join_day <= 20){
				$additional_day = 1.5;
			}else{
				$additional_day = 1;
			}
			if($join_day <=15){
				$additional_day_casual = 1;
			}else{
				$additional_day_casual = 0;
			}
			$month_difference =(($f_year_end * 12 )+ 6)-(($join_year*12) + $join_month);
			$current_date = $leave_joining_date;
		}else{
			$month_difference = 12; 
			$current_date = date('Y-m-d');
		}
		if($month_difference <  12 && $month_difference >= 0){
			$total_day = ($month_difference * 2 ) + $additional_day;
			$total_day_casual = ($month_difference * 1 ) + $additional_day_casual;
		}else if($month_difference < 0 && $month_difference >= -12){
			$month_difference = 12 + $month_difference;
			$total_day = ($month_difference * 2 ) + $additional_day;
			$total_day_casual = ($month_difference * 1 ) + $additional_day_casual;
		}else{
			$total_day = 24 ;
			$total_day_casual = 12 ;
		}
		if($data['joining_date'] >= '2020'.'-'.'11'.'-'.'30'){
			$total_day_casual = $total_day_casual;
		}else{
			$total_day_casual = 7;
		}
		$financial_year = DB::table('tbl_financial_year')
						->where('f_year_from','<=', $current_date)
						->where('f_year_to','>=', $current_date)
						->first(); 
						
						
						
						
		
						
						
		//$leavedata['emp_id'] = $data['emp_id'];  
		$leavedata['branch_code'] = $data['joining_branch'];
		$leavedata['f_year_id'] = $financial_year->id;
		$leavedata['cum_balance'] = 0; 
		$leavedata['current_open_balance'] = $total_day; 
		$leavedata['casual_leave_open'] = $total_day_casual;
		$leavedata['casual_leave_close'] = $total_day_casual; 
		$leavedata['no_of_days'] = 0;
		$leavedata['cum_close_balance'] = 0;
		$leavedata['current_close_balance'] = $total_day; 
		$leavedata['last_update_date'] = date('Y-m-d');
		$leavedata['status'] = 2;
		$leavedata['created_by'] 			= Session::get('admin_id');
		////////////////END SAIFUL///////////
		
		
		
		//DB::table('tbl_leave_balance')->insert($leavedata);
		
		//echo '<pre>';
		//print_r($leavedata);
		//exit;
		//DB::table('tbl_appointment_info')->insert($data);
		//DB::table('tbl_emp_basic_info')->insert($basic_data);
		//DB::table('tbl_probation')->insert($probation_data);
		//DB::table('tbl_sarok_no')->insert($sarok_data);
		//DB::table('tbl_master_tra')->insert($master_data);
		//DB::table('tbl_leave_balance')->insert($leavedata);
		//DB::table('tbl_emp_mapping')->insert($mapping_data);
		//DB::table('supervisor_mapping_ho')->insert($supervisor_data);
		//print_r ($basic_data); exit;
		/* $max_emp_id = DB::table('tbl_appointment_info')->where('emp_group',$data['emp_group'])->max('emp_id');
		$data['emp_id'] = $max_emp_id+1;
		DB::table('tbl_appointment_info')->insert($data);
		exit; */
		/* print_r ($probation_data);
		if($data['emp_group'] == 1) {
			$max_emp_id = DB::table('tbl_appointment_info')->where('emp_group',$data['emp_group'])->max('emp_id');
		} else if ($data['emp_group'] == 2 || $data['emp_group'] == 3) {
			$max_emp_id = DB::table('tbl_appointment_info')->max('emp_id');
		}
		$emp_id = $max_emp_id+1;
		$leavedata['emp_id'] = $emp_id;
		DB::table('tbl_leave_balance')->insert($leavedata);	
		exit; */
		DB::beginTransaction();
		try {				
			if($data['emp_group'] == 1) {
				$max_emp_id = DB::table('tbl_appointment_info')->where('emp_group',$data['emp_group'])->max('emp_id');
			} else if ($data['emp_group'] == 2 || $data['emp_group'] == 3) {
				$max_emp_id = DB::table('tbl_appointment_info')->max('emp_id');
			}				
			$data['emp_id'] = $emp_id = $max_emp_id+1;
			//print_r ($data); exit;
			DB::table('tbl_appointment_info')->insert($data);
			$basic_data['emp_id'] = $emp_id;
			DB::table('tbl_emp_basic_info')->insert($basic_data);
			$probation_data['emp_id'] = $emp_id;
			DB::table('tbl_probation')->insert($probation_data);
			$sarok_data['emp_id'] = $emp_id;
			DB::table('tbl_sarok_no')->insert($sarok_data);
			$master_data['emp_id'] = $emp_id;
			DB::table('tbl_master_tra')->insert($master_data);	
			$leavedata['emp_id'] = $emp_id;
			DB::table('tbl_leave_balance')->insert($leavedata);
			$mapping_data['emp_id'] = $emp_id;
			DB::table('tbl_emp_mapping')->insert($mapping_data);
			$supervisor_data['emp_id'] = $emp_id;
			DB::table('supervisor_mapping_ho')->insert($supervisor_data);
			DB::commit();
			Session::put('message','Data Save Successfully, Employee ID is Generated -'. $emp_id);
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		}

		return Redirect::to('/employee-appointment');
    }
	
	public function update(Request $request, $id)
    {				
		$data = request()->except(['_token','_method','mother_program_id','current_program_id','mother_department_id','current_department_id','unit_id','project_id','c_end_date']);
		//$datamap = request()->only(['mother_program','current_program','mother_department','current_department','unit_code']);
		//print_r ($data); exit;
		/* $emp_id = $request->input('emp_id');
		$validation_status = $this->validation($emp_id);
		if($validation_status == 1)
		{
			Session::put('message','This Employee Already Permanent');
			return Redirect::to('/employee-appointment/create');
		}
		
		if($validation_status == 3)
		{
			Session::put('message','This Employee Already Saved');
			return Redirect::to('/employee-appointment/create');
		} */

		$data['created_by'] 	   				= Session::get('admin_id');
		$data['org_code'] 		   				= Session::get('admin_org_code');
		$data['grade_code'] 					= ($data['emp_group'] == 1) ? $data['grade_code'] : 27;
		$data['grade_step'] 					= ($data['emp_group'] == 1) ? $data['grade_step'] : 0;
		$data['next_permanent_date'] 			= ($data['emp_group'] == 1) ? $request->input('next_permanent_date') : $request->input('c_end_date');
		// FOR Employee Basic TABLE
		$emp_id 				= $data['emp_id'];
		$sarok_no 				= $data['sarok_no'];
		$basic_data['emp_name_eng'] 		= $data['emp_name'];
		$basic_data['emp_name_ban'] 		= $data['emp_name_bangla'];
		$basic_data['father_name'] 			= $data['fathers_name'];
		$basic_data['father_name_ban'] 		= $data['fathers_name_bangla'];
		$basic_data['mother_name'] 			= $data['mother_name'];
		$basic_data['mother_name_ban'] 		= $data['mother_name_ban'];
		$basic_data['birth_date'] 			= $data['birth_date'];
		$basic_data['nationality'] 			= $data['nationality'];
		$basic_data['religion']				= $data['religion'];
		$basic_data['country_id'] 			= '';
		$basic_data['contact_num'] 			= $data['contact_num'];
		$basic_data['email'] 				= $data['email'];
		$basic_data['national_id'] 			= $data['national_id'];
		$basic_data['maritial_status'] 		= $data['maritial_status'];
		$basic_data['gender'] 				= $data['gender'];
		$basic_data['blood_group'] 			= $data['blood_group'];
		$basic_data['present_add'] 			= '';
		$basic_data['vill_road'] 			= $data['emp_village'];
		$basic_data['post_office'] 			= $data['emp_po'];
		$basic_data['district_code'] 		= $data['emp_district'];
		$basic_data['thana_code'] 			= $data['emp_thana'];
		$basic_data['permanent_add'] 		= '';
		$basic_data['org_join_date'] 		= $data['joining_date'];
		$basic_data['emp_group'] 			= $data['emp_group'];
		$basic_data['emp_type'] 			= $data['emp_type'];
		//$basic_data['created_by'] 			= Session::get('admin_id');
		$basic_data['updated_by'] 			= Session::get('admin_id');
		$basic_data['org_code'] 			= Session::get('admin_org_code');	
	
		// FOR PROBATION TABLE
		//$probation_data['emp_id'] 				= $data['emp_id'];
		//$probation_data['sarok_no'] 			= $data['sarok_no'];
		$probation_data['letter_date'] 			= $data['letter_date'];
		$probation_data['effect_date'] 			= $data['joining_date'];
		$probation_data['br_joined_date'] 		= $data['br_join_date'];
		$probation_data['designation_code'] 	= $data['emp_designation'];
		$probation_data['br_code'] 				= $data['joining_branch'];
		$probation_data['grade_code'] 			= ($data['emp_group'] == 1) ? $data['grade_code'] : 27;
		$probation_data['grade_step'] 			= ($data['emp_group'] == 1) ? $data['grade_step'] : 0;
		$probation_data['permanent_date'] 		= ($data['emp_group'] == 1) ? $request->input('next_permanent_date') : $request->input('c_end_date');
		//$probation_data['department_code']	= $data['emp_department'];
		$probation_data['report_to'] 			= $data['reported_to'];
		$probation_data['probation_time'] 		= $data['period'];
		//$probation_data['permanent_date'] 		= $data['next_permanent_date'];
		//$probation_data['created_by'] 			= Session::get('admin_id');
		$probation_data['updated_by'] 			= Session::get('admin_id');
		$probation_data['org_code'] 			= Session::get('admin_org_code');
		$probation_data['status'] 				= 1;				
		$probation_data['basic_salary'] 	  	= $data['gross_salary'];				
		//SET FOR MASTER Table
		//$master_data['emp_id'] 					= $request->input('emp_id');
		$master_data['sarok_no'] 				= $data['sarok_no'];
		$master_data['tran_type_no']			= 1;
		$master_data['letter_date'] 			= $request->input('letter_date');
		$master_data['effect_date'] 			= $request->input('joining_date');
		if($data['emp_group'] != 1) {	
			$master_data['next_increment_date'] 	= $request->input('c_end_date');  
		}
		$master_data['grade_effect_date'] 		= $request->input('joining_date');  
		$master_data['br_join_date'] 			= $request->input('br_join_date');
		$master_data['designation_code']		= $request->input('emp_designation');
		$master_data['br_code'] 				= $request->input('joining_branch');
		$master_data['salary_br_code'] 			= $request->input('salary_br_code');
		$master_data['grade_code'] 				= ($data['emp_group'] == 1) ? $data['grade_code'] : 27;
		$master_data['grade_step'] 				= ($data['emp_group'] == 1) ? $data['grade_step'] : 0;
		$master_data['basic_salary'] 			= $request->input('gross_salary');
		//$master_data['department_code'] 		= $request->input('emp_department');
		$master_data['report_to'] 				= $request->input('reported_to');
		$master_data['is_permanent']			= $request->input('join_as');
		$master_data['provision_time']			= $request->input('period');
		$master_data['status'] 					= 1;
		$master_data['created_by'] 				= Session::get('admin_id');
		$master_data['org_code'] 				= Session::get('admin_org_code');
		//SET FOR Employee Mapping Table
		//$mapping_data['emp_id'] 					= $request->input('emp_id');
		$mapping_data['mother_program_id'] 		= $request->input('mother_program_id');
		$mapping_data['current_program_id'] 		= $request->input('current_program_id');  
		$mapping_data['mother_department_id'] 	= $request->input('mother_department_id');  
		$mapping_data['current_department_id'] 	= $request->input('current_department_id');
		$mapping_data['unit_id']					= $request->input('unit_id');
		//$mapping_data['project_id'] 				= $request->input('project_id');
		$mapping_data['start_date'] 				= $request->input('joining_date');
		$mapping_data['end_date'] 				= '';
		$mapping_data['created_by'] 				= Session::get('admin_id');
		//SET FOR Supervisor Mapping Table
		$supervisor_data['emp_name'] 			= $request->input('emp_name'); 
		//$supervisor_data['emp_id'] 				= $request->input('emp_id');
		$supervisor_data['supervisor_id'] 		= $request->input('reported_to');  
		$supervisor_data['supervisor_type'] 	= 1;
		$supervisor_data['active_from'] 		= $request->input('joining_date');
		$supervisor_data['mapping_status'] 		= 1;
		$supervisor_data['created_by'] 			= Session::get('admin_id');
		
		//echo '<pre>';
		//exit;
		//DB::table('tbl_appointment_info')->insert($data);
		//DB::table('tbl_emp_basic_info')->insert($basic_data);
		//DB::table('tbl_probation')->insert($probation_data);
		//DB::table('tbl_master_tra')->insert($master_data);
		//DB::table('tbl_emp_mapping')->insert($mapping_data);
		//DB::table('supervisor_mapping_ho')->insert($supervisor_data);
		//print_r ($basic_data); exit;
		/* $max_emp_id = DB::table('tbl_appointment_info')->where('emp_group',$data['emp_group'])->max('emp_id');
		$basic_data['emp_id'] = $max_emp_id+1;
		DB::table('tbl_emp_basic_info')->insert($basic_data); */
		$mapping_row = DB::table('tbl_emp_mapping')->where('emp_id',$emp_id)->first();
		DB::beginTransaction();
		try {
			//print_r ($data); exit;
			DB::table('tbl_appointment_info')->where('sarok_no', $sarok_no)->where('emp_id', $emp_id)->update($data);
			$basic_data['emp_id'] = $emp_id;
			DB::table('tbl_emp_basic_info')->where('emp_id', $emp_id)->update($basic_data);
			$probation_data['emp_id'] = $emp_id;
			DB::table('tbl_probation')->where('sarok_no', $sarok_no)->where('emp_id', $emp_id)->update($probation_data);
			$master_data['emp_id'] = $emp_id;
			DB::table('tbl_master_tra')->where('sarok_no', $sarok_no)->where('emp_id', $emp_id)->update($master_data);	
			$mapping_data['emp_id'] = $emp_id;
			DB::table('tbl_emp_mapping')->where('id', $mapping_row->id)->where('emp_id', $emp_id)->update($mapping_data);
			$supervisor_data['emp_id'] = $emp_id;
			DB::table('supervisor_mapping_ho')->where('emp_id', $emp_id)->update($supervisor_data);
			DB::commit();
			Session::put('message','Data Save Successfully, Employee ID is Generated -'. $emp_id);
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		}
		return Redirect::to('/employee-appointment');
    }
	
	
	public function update_pre(Request $request, $id)
    {				
		$data = request()->except(['_token','_method']);		
		
		$sarok_no		   						= $request->input('sarok_no');
		$data['sarok_no'] 		   				= $sarok_no;
		//SET SAROK TABLE//
		$sarok_data['emp_id'] 	   				= $request->input('emp_id');
		$sarok_data['letter_date'] 				= $request->input('letter_date');	
		// FOR PROBATION TABLE
		$probation_data['emp_id'] 				= $data['emp_id'];
		$probation_data['letter_date'] 			= $data['letter_date'];
		$probation_data['br_joined_date'] 		= $data['br_join_date'];
		$probation_data['designation_code'] 	= $data['emp_designation'];
		$probation_data['br_code'] 				= $data['joining_branch'];
		$probation_data['grade_code'] 			= $data['grade_code'];
		$probation_data['grade_step'] 			= $data['grade_step'];
		$master_data['basic_salary'] 			= $data['gross_salary'];
		$probation_data['department_code']		= $data['emp_department'];
		$probation_data['report_to'] 			= $data['reported_to'];
		$probation_data['probation_time'] 		= $data['period'];
		$probation_data['next_permanent_date'] 	= $data['joining_date'];//+period
		$probation_data['updated_by'] 			= Session::get('admin_id');			
		//SET FOR MASTER Table
		$master_data['emp_id'] 					= $request->input('emp_id');
		$master_data['letter_date'] 			= $request->input('letter_date');
		$master_data['effect_date'] 			= $request->input('joining_date');
		$master_data['br_join_date'] 			= $request->input('br_join_date');
		$master_data['designation_code']		= $request->input('emp_designation');
		$master_data['br_code'] 				= $request->input('joining_branch');
		$master_data['grade_code'] 				= $request->input('grade_code');
		$master_data['grade_step'] 				= $request->input('grade_step');
		$master_data['department_code'] 		= $request->input('emp_department');
		$master_data['report_to'] 				= $request->input('reported_to');
		$master_data['is_permanent'] 			= $request->input('join_as');
		$master_data['updated_by'] 				= Session::get('admin_id');
		
		
		$basic_data['org_join_date'] 			= $request->input('joining_date');
		
		//Data Update 
		DB::beginTransaction();
		try {				
			DB::table('tbl_appointment_info')
            ->where('sarok_no', $sarok_no)
            ->update($data);
			DB::table('tbl_probation')
            ->where('sarok_no', $sarok_no)
            ->update($probation_data);
			DB::table('tbl_sarok_no')
            ->where('sarok_no', $sarok_no)
            ->update($sarok_data);
			DB::table('tbl_master_tra')
            ->where('sarok_no', $sarok_no)
            ->update($master_data);
			//
			DB::table('tbl_emp_basic_info')
            ->where('emp_id', $request->input('emp_id'))
            ->update($basic_data);

			DB::commit();
			Session::put('message','Data Updated Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Updated Data');
			DB::rollback();
		}
		return Redirect::to('/employee-appointment');
    }
	
	public function show($id)
	{
		$appoinment_info = DB::table('tbl_appointment_info')
										->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_appointment_info.joining_branch')
										->join('tbl_designation as d1', 'd1.designation_code', '=', 'tbl_appointment_info.emp_designation')
										->join('tbl_district', 'tbl_district.district_code', '=', 'tbl_appointment_info.emp_district')
										->join('tbl_thana', 'tbl_thana.thana_code', '=', 'tbl_appointment_info.emp_thana')
										->where('tbl_appointment_info.id', $id)
										->select('tbl_appointment_info.*','tbl_branch.br_name_bangla','d1.designation_bangla','tbl_district.district_bangla','tbl_thana.thana_bangla')
										->first();
										
		//echo '<pre>';
		//print_r($appoinment_info);
		//exit();		
		//	


 

 

	
										
		$data = array();															
		$data['emp_id'] 			= $appoinment_info->emp_id;								
		$data['letter_date'] 		= $appoinment_info->letter_date;								
		$data['emp_name'] 			= $appoinment_info->emp_name_bangla;
		$data['fathers_name'] 		= $appoinment_info->fathers_name_bangla;
		$data['emp_village'] 		= $appoinment_info->emp_village_bangla;
		$data['emp_po'] 			= $appoinment_info->emp_po_bangla;
		$data['joining_date'] 		= $appoinment_info->joining_date;
		$data['join_as'] 			= $appoinment_info->join_as;
		$data['period'] 			= $appoinment_info->period;
		$data['gross_salary'] 		= $appoinment_info->gross_salary;
		$data['diposit_money'] 		= $appoinment_info->diposit_money;
		$data['reported_to'] 		= $appoinment_info->reported_to;
		$data['joined_date'] 		= $appoinment_info->br_join_date;							
		$data['br_name_bangla'] 	= $appoinment_info->br_name_bangla;								
		$data['designation_bangla'] = $appoinment_info->designation_bangla;								
		$data['district_bangla'] 	= $appoinment_info->district_bangla;								
		//$data['department_bangla'] 	= $appoinment_info->department_bangla;								
		$data['thana_bangla'] 		= $appoinment_info->thana_bangla;	
		
		$joining_branch 			= $appoinment_info->joining_branch;	
		

		if($appoinment_info->joining_date < '2021-05-31')
		{
			$hr_head_name = ' সৈয়দ লুৎফর রহমান';
			$hr_head_designation = ' ভারপ্রাপ্ত জিএম ( মানবসম্পদ বিভাগ )';
		}
		else{
			$hr_head_name = ' এস.আবদুল আহাদ, এফসিএমএ ';
			$hr_head_designation = ' পরিচালক (ফাইন্যান্স এন্ড অপারেশন্স)';
		}
		
		
		
		
		/*if($joining_branch == 0)
		{
			$br_type = 0;
		}
		else{
			$br_type = 1;
			
		}
		
		$letter_sample = DB::table('tbl_appoinment_letter_sample')
									->where('sample_type', $br_type)
									->first();
		*/
		$letter_info = DB::table('tbl_appointment_letter')
									->where('emp_id', $data['emp_id'])
									->first();
									
		if($letter_info)
		{
			$data['id'] 		 = $letter_info->id;	
			$data['letter_body'] = $letter_info->letter_body;
		}
		else{
			$data['id'] 		 = '';	
			
			$data['letter_body'] = "

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>".$data['letter_date']."</p>

<h1 style='text-align:center'>&nbsp; <ins>নিয়োগপত্র</ins></h1>

<p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; আইডি নং&nbsp; : ".$data['emp_id']."</strong><br />
<br />
<strong>&nbsp;".$data['emp_name']."</strong><br />
&nbsp;পিতা&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: ".$data['fathers_name']."<br />
&nbsp;গ্রাম&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :&nbsp;".$data['emp_village']."<br />
&nbsp;ডাকঘর&nbsp; &nbsp; &nbsp;:&nbsp;".$data['emp_po']."<br />
&nbsp;উপজেলা&nbsp; : ".$data['thana_bangla']."&nbsp;<br />
জেলা&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: ".$data['district_bangla']."&nbsp;</p>

<p>জনাব,</p>

<p>আপনার আবেদন ও সাক্ষাতের ভিত্তিতে আপনাকে &#39; <strong>".$data['designation_bangla']."</strong> &#39;&nbsp;<strong> </strong>পদে নিম্নলিখিত শর্তে অস্থায়ীভাবে নিয়োগ দেয়া হলো।</p>

<ol>
	<li>আপনাকে সংস্থায় ০৬ (ছয়) মাস শিক্ষানবিসকালিন (Probation Period )দায়িত্ব পালন করতে হবে। এই সময়ে আপনাকে প্রতি মাসে বেতন বাবদ ১৪৫০০ /- টাকা, মাঠ ভাতা ৪০০০ /- টাকা, মোবাইল ও ইন্টারনেট ভাতা ৫০০ /- টাকা এবং যানবাহন ও রক্ষনাবেক্ষন ভাতা ৫০০ /- টাকা সহ সর্বসাকুল্যে ১৯৫০০ /- ( ঊনিশ হাজার পাঁচ শত ) টাকা প্রদান করা হবে। এছাড়া মোটর-সাইকেল ব্যাবহার সাপেক্ষে ১০০০ /- টাকা জ্বালানী ভাতা প্রাপ্য হবেন। অফিসের আবাসন খালি থাকা সাপেক্ষে অবস্থান করতে পারবেন। এক্ষেত্রে প্রতিমাসে ৪৪০ /- ( চারশত চল্লিশ ) টাকা বাড়ী ভাড়া কর্তন হবে। অফিসের আবাসিক খালি ন থাকলে নিজ দায়িত্বে আবাসনের ব্যাবস্থা&nbsp; করতে হবে।</li>
	<li>শিক্ষানবিসকাল&nbsp; অতিক্রান্ত হওয়ার পর মূল্যায়ন পত্রের ভিত্তিতে আপনাকে স্থায়ী করা হবে এবং সংস্থার নিয়মানুযায়ী নির্ধারিত বেতন স্কেলে বেতন-ভাতা প্রদান করা হবে।&nbsp;&nbsp;&nbsp;</li>
	<li>আপনি সংস্থার নিয়ম অনুযায়ী উৎসব ভাতা পাবেন।</li>
	<li>সংস্থার নিয়ম অনুসারে ছুটি ভোগ করতে পারবেন।</li>
	<li>আপনাকে সংস্থার সর্ব প্রকার নিয়ম-নিতি মেনে চলতে হবে।</li>
	<li>শিক্ষানবিসকালিন সময়ে&nbsp; আপনাকে বিনা ক্ষতিপূরণে, বিনা নোটিশে চাকরি হতে অব্যাহতি দেয়া যাবে।</li>
	<li>চাকরি হতে অব্যাহতি নিতে&nbsp;চাইলে একমাস পূর্বে লিখিতভাবে জানাতে হবে অন্যথায় একমাসের মূল বেতনের সমপরিমাণ টাকা নোটিশ -পে হিসেবে কর্তন হবে অথবা সংস্থা ইচ্ছা করলে আপনাকে একমাসের বেতনের সমপরিমাণ টাকা নোটিশ -পে দিয়ে চাকরি হতে অব্যাহতি প্রদান করতে পারবে।</li>
	<li>ভবিষ্যতে সংস্থা কর্তৃক&nbsp;নিয়োগ সংক্রান্ত বিষয়ে কোন পরিবর্তন আনা হলে তা মেনে নিয়ে সংস্থার চাহিদা মোতাবেক প্রয়োজনীয় ডকুমেন্টস সরবরাহ করতে বাধ্য থাকবেন অন্যথায় &nbsp;সংস্থা কর্তৃক&nbsp;আপনার নিয়োগ&nbsp;বাতিল করার প্রয়োজনীয়তা দেখা দিলে সেক্ষেত্রে আপনার কোন ওজর- আপত্তি গ্রহণযোগ্য হবে না।</li>
</ol>

<p>&nbsp;</p>

<p>ধন্যবাদান্তে,</p>

<p><br />
<strong> $hr_head_name </strong>&nbsp;<br />
$hr_head_designation</p>


<p>&nbsp;</p>

<p>উপরক্ত শর্তাবলী আপনার নিকট গ্রহণযোগ্য হলে &#39; <strong>".$data['designation_bangla']."</strong> &#39; পদে  <span>".$data['joining_date']."</span> তারিখে সংস্থার &#39; <strong>".$data['br_name_bangla']."</strong> ব্রাঞ্চে&nbsp;&#39;&nbsp;&nbsp;যোগদান করবেন।</p>

<p>অনুলিপিঃ</p>

<p>১. এরিয়া ম্যানেজার, নোয়াখালী এরিয়া।&nbsp;<br />
১. ব্রাঞ্চ ম্যানেজার, সোনাপুর ব্রাঞ্চ&nbsp;ঃ উক্ত কর্মীর যোগদানের প্রয়োজনীয় ব্যবস্থা গ্রহন করবেন।&nbsp;<br />
৩. ব্যক্তিগত ফাইল।</p>

<p>&nbsp;</p>

<p>&nbsp;</p>


";
		}							
		$data['action'] 			= "/save-appoimtment-letter";
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ""; 		
		$data['Heading'] 			= 'Save Employee Appoinment Letter';
		$data['button_text'] 		= 'Save Laeeter';
			
		return view('admin.employee.appoiontment_letter_form',$data);	
	}
	
	public function save_appoimtment_letter(Request $request)
    {
		$data = request()->except(['_token','_method']);		
		$id 			= $request->input('id');		

		if($id !='')
		{
			$status = DB::table('tbl_appointment_letter')
            ->where('id', $id)
            ->update($data);
		}
		else
		{
			echo 'insert';
			$data['created_by'] = Session::get('admin_id');
			$data['status'] 	= 1;
			$status  = DB::table('tbl_appointment_letter')->insertGetId($data);	
		}
		
		if($status)
		{	
			Session::put('message','Letter Saved Successfully');
            			
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
		
		return Redirect::to('/employee-appointment');
    }
	
	public function allappoinments(Request $request)
    {       
		$session_branch_code = Session::get('branch_code');
		$session_admin_id  = Session::get('admin_id');
		$columns = array( 
			0 =>'tbl_appointment_info.id', 
			1 =>'tbl_appointment_info.emp_id',
			2=> 'tbl_appointment_info.letter_date',
			3=> 'tbl_appointment_info.emp_name',
			4=> 'tbl_appointment_info.fathers_name',
			5=> 'tbl_appointment_info.emp_village',
			6=> 'tbl_appointment_info.emp_po',
			7=> 'tbl_appointment_info.emp_district',
			8=> 'tbl_appointment_info.id',
		);
  
        $totalData = Appointment::where(function($query) use ($session_branch_code, $session_admin_id) {
											if($session_branch_code !=9999) {
												$query->Where('tbl_appointment_info.created_by', $session_admin_id);
											}
										})->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.1.dir');
        
        if(empty($request->input('search.value')))
        {            
            $appoinments = Appointment::join('tbl_district', 'tbl_district.district_code', '=', 'tbl_appointment_info.emp_district' )
							->offset($start)
							->where(function($query) use ($session_branch_code, $session_admin_id) {
											if($session_branch_code !=9999) {
												$query->Where('tbl_appointment_info.created_by', $session_admin_id);
											}
										})
							->select('tbl_appointment_info.*','tbl_district.district_name')
							->limit($limit)
							//->orderBy('tbl_appointment_info.id', 'DESC')
							->orderBy($order,$dir)
							->get();
        }
        else {
            $search = $request->input('search.value');
            $appoinments =  Appointment::join('tbl_district', 'tbl_district.district_code', '=', 'tbl_appointment_info.emp_district' )
							->where(function($query) use ($session_branch_code, $session_admin_id) {
											if($session_branch_code !=9999) {
												$query->Where('tbl_appointment_info.created_by', $session_admin_id);
											}
										})
							->where('emp_id',$search)
							->select('tbl_appointment_info.*','tbl_district.district_name')
                            ->offset($start)
                            ->limit($limit)							
                            ->orderBy($order,$dir)
							//->orderBy('tbl_appointment_info.id', 'DESC')
                            ->get();

            $totalFiltered = Appointment::where('emp_id',$search)
							->where(function($query) use ($session_branch_code, $session_admin_id) {
											if($session_branch_code !=9999) {
												$query->Where('tbl_appointment_info.created_by', $session_admin_id);
											}
										})
                             ->count();
        }

        $data = array();
        if(!empty($appoinments))
        {
            $i=1;
            foreach ($appoinments as $v_appoinments)
            {
                $nestedData['id'] 			= $i++;
                $nestedData['emp_id'] 		= $v_appoinments->emp_id;
                $nestedData['letter_date'] 	= $v_appoinments->letter_date;
                $nestedData['emp_name'] 	= $v_appoinments->emp_name;
				$nestedData['fathers_name'] = $v_appoinments->fathers_name;
				$nestedData['emp_village'] 	= $v_appoinments->emp_village;
                $nestedData['emp_po'] 		= $v_appoinments->emp_po;             
                $nestedData['emp_district'] = $v_appoinments->district_name;             
                $nestedData['status'] 		= $v_appoinments->status;             
				$nestedData['options'] 		= '<a class="btn btn-sm btn-success btn-xs" title="Edit" href="employee-appointment/'.$v_appoinments->id.'/edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				<a class="btn btn-sm btn-primary btn-xs" title="Edit" href="employee-appointment/'.$v_appoinments->id.'"><i class="fa fa-eye"></i> Preview and Save</a>';				
				$data[] = $nestedData;
            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
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
	
	public function get_emp_idcard(){
		echo "Emp ID Card";
	}	
	
  
}
