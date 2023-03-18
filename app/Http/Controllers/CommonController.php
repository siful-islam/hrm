<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;



class CommonController extends Controller
{
	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	public function get_assign_info($emp_id,$effect_date,$tran_type_no)
	{
		//$max_date = DB::table('tbl_master_tra')
					//->where('emp_id', $id)
					//->max('effect_date');
		//return $max_date;
		
		return $emp_id;
	}	
	
	public function get_max_effect_date($id)
	{
		$max_date = DB::table('tbl_master_tra')
					->where('emp_id', $id)
					->max('effect_date');
		return $max_date;
	}
	
	
	public function get_crime_info($id)
	{
		$crime_info = DB::table('tbl_crime')
						->where('id', $id)
						->select('punishment')
						->first();
		$data =array();
		$data['punishment'] = $crime_info->punishment;
		return $data;
	}
	

	public function get_employee_info($emp_id,$letter_date)
	{
		$data = array();
		$emp_id = $emp_id;
		$letter_date = $letter_date;
		$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $emp_id)
						->where('m.br_join_date', '=', function($query) use ($emp_id,$letter_date)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $letter_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('emp_id')
						->first();

		//echo 	$max_id;
		//	exit;		

		if($max_sarok !=NULL)
		{
			$employee_info = DB::table('tbl_master_tra')
						->join('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'tbl_master_tra.emp_id')
						->join('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_master_tra.designation_code')
						->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_master_tra.br_code')
						->leftjoin('tbl_grade_new', 'tbl_grade_new.grade_id', '=', 'tbl_master_tra.grade_code')
						->leftjoin('tbl_resignation', 'tbl_resignation.emp_id', '=', 'tbl_master_tra.emp_id')
						->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_master_tra.emp_id')
						->where('tbl_master_tra.sarok_no', $max_sarok->sarok_no)
						->where('tbl_master_tra.status', 1)
						->select('tbl_master_tra.id','tbl_master_tra.emp_id','tbl_master_tra.sarok_no','tbl_master_tra.br_join_date','tbl_master_tra.next_increment_date','tbl_master_tra.effect_date as sa_effect_date','tbl_master_tra.designation_code','tbl_master_tra.br_code','tbl_master_tra.grade_code','tbl_master_tra.grade_effect_date','tbl_master_tra.grade_step','tbl_master_tra.department_code','tbl_master_tra.report_to','tbl_master_tra.is_permanent','tbl_emp_basic_info.emp_name_eng','tbl_emp_basic_info.father_name','tbl_emp_basic_info.org_join_date','tbl_emp_photo.emp_photo','tbl_designation.designation_name','tbl_branch.branch_name','tbl_grade_new.grade_name','tbl_resignation.effect_date','tbl_master_tra.basic_salary','tbl_master_tra.salary_br_code') 
						->first();	
		//print_r ($employee_info); exit;
			$data['emp_id'] 				= $emp_id;
			$data['emp_name'] 				= $employee_info->emp_name_eng;
			$data['joining_date'] 			= $employee_info->org_join_date;
			$data['designation_code'] 		= $employee_info->designation_code;
			$data['designation_name'] 		= $employee_info->designation_name;
			$data['department_code'] 		= $employee_info->department_code;
			$data['report_to'] 				= $employee_info->report_to;
			$data['br_join_date'] 			= $employee_info->br_join_date;
			$data['effect_date'] 			= $employee_info->sa_effect_date;
			$data['br_code'] 				= $employee_info->br_code;
			$data['grade_code'] 			= $employee_info->grade_code;
			$data['grade_step'] 			= $employee_info->grade_step;
			$data['grade_effect_date'] 		= $employee_info->grade_effect_date;
			$data['next_increment_date'] 	= $employee_info->next_increment_date;
			$data['branch_name'] 			= $employee_info->branch_name;
			$data['grade_name'] 			= $employee_info->grade_name;
			$data['is_permanent'] 			= $employee_info->is_permanent;
			$data['salary_br_code'] 		= $employee_info->salary_br_code;
			
			$data['basic_salary'] 			= $employee_info->basic_salary;
			if($employee_info->emp_photo !='')
			{
				$data['emp_photo'] 			= $employee_info->emp_photo;
			}
			else{
				$data['emp_photo'] 			= 'default.png';
			}
			$data['resign_date'] 			= $employee_info->effect_date;
			$data['emp_status'] 			= 'Active';	
		}
		else
		{
			$data['emp_id'] 				= $emp_id;
			$data['emp_name'] 				= '';
			$data['joining_date'] 			= '';
			$data['designation_code'] 		= '';
			$data['designation_name'] 		= '';
			$data['department_code'] 		= '';
			$data['report_to'] 				= '';
			$data['br_code'] 				= '';
			$data['grade_code'] 			= '';
			$data['grade_step'] 			= '';
			$data['branch_name'] 			= '';
			$data['branch_name'] 			= '';
			$data['grade_name'] 			= '';
			$data['emp_photo'] 				= 'default.png';
			$data['emp_status'] 			= 'Employee Status';
			$data['resign_date'] 			= '';
			$data['salary_br_code'] 		= '';
		}
		
		//echo '<pre>';
		//print_r($data);
		//exit;
		return $data;
	}
	

	public function cheeck_action_permission($action_id)
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
	
	public function store_transection(Request $request)
	{
		$action_table 					= $request->input('action_table');
		$action_controller 				= $request->input('action_controller');
		$transection_type 				= $request->input('transection_type');
		if($transection_type == 1)
		{
			$data = request()->except(['_token','sarok_no','action_table','action_controller','transection_type','next_increment_date','is_permanent','grade_code_old','report_to']);
		}
		elseif($transection_type == 8)
		{
			$data = request()->except(['_token','sarok_no','action_table','salary_br_code','action_controller','transection_type','next_increment_date','is_permanent','grade_code_old','designation_code_old','report_to']);
		}
		else
		{
			$data = request()->except(['_token','sarok_no','action_table','action_controller','transection_type','is_permanent','grade_code_old','report_to']);
		}

		$grade_code 		= $request->input('grade_code');
		$grade_step 		= $request->input('grade_step');	
		
		/*$all_basic			= DB::table('tbl_grade_new as grade')
							->where('grade.grade_code', $grade_code)
							->select('grade.*')
							->first();
		$col 				= 'step_'.$grade_step;
		$basic_salary 		= $all_basic->$col;	
		*/
		
		if($request->input('emp_id') < 200000)
		{
			$all_basic			= DB::table('tbl_grade_new as grade')
								->where('grade.grade_code', $grade_code)
								->select('grade.*')
								->first();
			$col 				= 'step_'.$grade_step;
			$basic_salary 		= $all_basic->$col;	
		}
		else{
			$all_basic			= DB::table('tbl_emp_salary')
									->where('emp_id', $request->input('emp_id'))
									->orderBy('id', 'DESC')
									->select('salary_basic')
									->first();
			$basic_salary 		= $all_basic->salary_basic;
		}
		
		
		if($transection_type == 8)
		{
			$salary_br_code 				= $request->input('salary_br_code');
			$master_data['effect_date'] 	= $request->input('br_joined_date'); 
		}else{
			$salary_br_code = $request->input('br_code');
		}
		
		
		//print_r ($data); exit;
		
		
		$br_code 			= $request->input('br_code');
		$department_code 	= $request->input('department_code');
		$designation_code	= $request->input('designation_code');
	
		if($br_code ==9999)
		{
			/*$reported_to = DB::table('reported_to as to')
							->where('to.department', '=', $department_code)
							->select('to.*')
							->first();
							
			if($reported_to->reported_designation == $designation_code)
			{
				$dep_info = DB::table('tbl_department')
							->where('department_id', '=', $department_code)
							->select('*')
							->first();
				
				$report_to 						= $dep_info->dp_head_designation;
				$report_to_designation_code 	= $dep_info->dp_head_desig_code;
				$report_to_new 					= $dep_info->dp_head_emp_id;
				$report_to_emp_type 			= $dep_info->dp_emp_type;
				
			}
			else{
				$report_to 						= $reported_to->designation_name;
				$report_to_designation_code 	= $reported_to->reported_designation;
				$report_to_new 					= $reported_to->reported_emp_id;
				$report_to_emp_type 			= $reported_to->emp_type;
			}*/
			
			$report_to 						= '';
			$report_to_designation_code 	= '';
			$report_to_new 					= '';
			$report_to_emp_type 			= 1;
		}
		else
		{
			$reported_to = DB::table('tbl_designation')
							->where('designation_code', '=', $designation_code)
							->select('*')
							->first();
			if($reported_to)
			{
				$report_to 						= $reported_to->reported_designation;
				$report_to_designation_code 	= $reported_to->to_reported;
				$report_to_new 					= 0;
				$report_to_emp_type 			= $reported_to->reported_emp_type;
			}
			else
			{
				$report_to 						= 'Branch Manager';
				$report_to_designation_code 	= 24;
				$report_to_new 					= 0;
				$report_to_emp_type 			= 1;
			}
		}
		
		
		
		/*$avab['report_to'] = $report_to;
		$avab['report_to_designation_code'] = $report_to_designation_code;
		$avab['report_to_new'] = $report_to_new;
		$avab['report_to_emp_type'] = $report_to_emp_type;
		print_r($avab);
		exit;
		*/
		
		
		
		
			
		// ENd Dynamic Reported to 
		

		$sarok_id = DB::table('tbl_sarok_no')->max('sarok_no');
		$data['sarok_no'] 		   			= $sarok_id+1;
		if($report_to)
		{
			$data['report_to'] 		   			= $report_to;
		}
		else{
			$data['report_to'] 		   			= '-';
		}
		$data['created_by'] 	   			= Session::get('admin_id');
		$data['org_code'] 		   			= Session::get('admin_org_code');			
		//SET SAROK TABLE//
		$sarok_data['sarok_no']    			= $data['sarok_no'];
		$sarok_data['emp_id'] 	   			= $request->input('emp_id');
		$sarok_data['letter_date'] 			= $request->input('letter_date');
		$sarok_data['transection_type'] 	= $transection_type;
		//SET FOR MASTER TABLE
		$master_data['emp_id'] 				= $request->input('emp_id');
		$master_data['sarok_no'] 			= $data['sarok_no'];
		$master_data['tran_type_no']		= $transection_type;
		$master_data['letter_date'] 		= $request->input('letter_date');
		$master_data['effect_date'] 		= $request->input('effect_date');
		$master_data['br_join_date'] 		= $request->input('br_joined_date');
		$master_data['next_increment_date']	= $request->input('next_increment_date');
		$master_data['designation_code']	= $request->input('designation_code');
		$master_data['br_code'] 			= $request->input('br_code');
		$master_data['salary_br_code'] 		= $salary_br_code;
		$master_data['grade_code'] 			= $request->input('grade_code');
		$grade_code_old 					= $request->input('grade_code_old');
		$master_data['grade_step'] 			= $request->input('grade_step');  
		$master_data['basic_salary'] 		= $basic_salary;
		$master_data['department_code']		= $request->input('department_code');
		//
		$master_data['report_to'] 					= $report_to;
		$master_data['report_to_designation_code'] 	= $report_to_designation_code;
		$master_data['report_to_new'] 				= $report_to_new;
		$master_data['report_to_emp_type'] 			= $report_to_emp_type;
		
		
		$master_data['status'] 				= $request->input('status');
		$designation_code_old 				= $request->input('designation_code_old');
		$master_data['created_by'] 			= Session::get('admin_id');
		$master_data['org_code'] 			= Session::get('admin_org_code');
		
		
		if($action_table == 'tbl_transfer') {
			$master_data['grade_effect_date'] 	= $request->input('grade_effect_date');
			if($master_data['designation_code'] != $designation_code_old) {
				$master_data['effect_date'] 	= $request->input('br_joined_date');
			}
			/////////update 'tbl_emp_assign' for change the branch/////////
			$br_assign			= DB::table('tbl_emp_assign')
								->where('emp_id', $data['emp_id'])
								->where('select_type', 2)
								->where('open_date', '<=', $data['br_joined_date'])
								->whereNull('close_date')
								->select('id','emp_id')
								->first();
			if($br_assign) 
			{
				DB::table('tbl_emp_assign')->where('id', $br_assign->id)->update(['close_date' => $data['br_joined_date'], 'status' => 0]);
			}
		} else {
			if($master_data['grade_code'] != $grade_code_old) {
				$master_data['grade_effect_date'] 	= $request->input('effect_date');
			} else {
				$master_data['grade_effect_date'] 	= $request->input('grade_effect_date');
			}
		}

		
		$master_data['is_permanent'] 		= $request->input('is_permanent');
		
		
		//echo '<pre>';
		//print_r($master_data);
		//exit; 

		
		//DB::table('tbl_master_tra')->insert($master_data);
		//return Redirect::to("/$action_controller");			
		//exit;
		//DB::table($action_table)->insertGetId($data);
		//exit;
		//INSERT DATA USING TRANSACTION
		DB::beginTransaction();
		try {				
			//INSERT INTO TRANSACTION TABLE
			DB::table($action_table)->insertGetId($data);
			//INSERT INTO SAROK TABLE
			DB::table('tbl_sarok_no')->insert($sarok_data);
			//INSERT INTO MASTER TABLE
			DB::table('tbl_master_tra')->insert($master_data);
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
		// RETURN TO TRANSACTION MANAGER
		return Redirect::to("/$action_controller");						
	}

	
	// UPDATE FOR PROBATION, PERMANENT
	public function update_transection(Request $request)
	{
		$action_table 					= $request->input('action_table');
		$action_controller 				= $request->input('action_controller');
		$transection_type 				= $request->input('transection_type');		
		if($transection_type == 1)
		{
			//DATA FOR TRANSECTION TABLE
			$data = request()->except(['_token','sarok_no','action_table','action_controller','transection_type','next_increment_date','is_permanent','grade_code_old']);
		}
		else
		{
			//DATA FOR TRANSECTION TABLE
			$data = request()->except(['_token','sarok_no','action_table','action_controller','transection_type','next_increment_date','is_permanent','grade_code_old']);
		}
		$id  = $request->input('id');		
		$data['updated_by'] = Session::get('admin_id');		
		$sarok_no 			= $request->input('sarok_no');	
		

		$grade_code 		= $request->input('grade_code');
		$grade_step 		= $request->input('grade_step');

		if($grade_step > 0)
		{
			$all_basic						= DB::table('tbl_grade_new as grade')
											->where('grade.grade_id', $grade_code)
											->select('grade.*')
											->first();
			$col 							= 'step_'.$grade_step;
			$basic_salary 					= $all_basic->$col;	
			$master_data['basic_salary'] 	= $basic_salary;
		}
		
		//DATA FOR MASTER Table		
		$master_data['letter_date'] 		= $request->input('letter_date');
		$master_data['effect_date'] 		= $request->input('effect_date');
		$master_data['br_join_date'] 		= $request->input('br_joined_date');
		$master_data['designation_code']	= $request->input('designation_code');
		$master_data['br_code'] 			= $request->input('br_code');
		$master_data['grade_code'] 			= $request->input('grade_code');
		$master_data['grade_step'] 			= $request->input('grade_step');
		$grade_code_old 					= $request->input('grade_code_old');
		$master_data['department_code']	 	= $request->input('department_code');
		$master_data['report_to'] 			= $request->input('report_to');
		$master_data['status'] 				= $request->input('status');
		$master_data['updated_by'] 			= Session::get('admin_id');
		if($action_table == 'tbl_transfer') {
			$master_data['grade_effect_date'] 	= $request->input('grade_effect_date');
			$data['grade_effect_date'] 	= $request->input('grade_effect_date');
		} else {
			if($master_data['grade_code'] != $grade_code_old) {
				$master_data['grade_effect_date'] 	= $request->input('effect_date');
			} else {
				$master_data['grade_effect_date'] 	= $request->input('grade_effect_date');
			}
		}
		
		
		//echo '<pre>';
		//print_r($master_data);
		//echo $sarok_no;
		//exit;

	// UPDATE USING TRANSACTION
		DB::beginTransaction();
		try {				
			//UPDATE TRANSECTION TABLE
			$status = DB::table($action_table)
            ->where('id', $id)
            ->update($data);
			//UPDATE MASTER TABLE		
			DB::table('tbl_master_tra')
            ->where('sarok_no', $sarok_no) 
            ->update($master_data);			
			//Update SAROK TABLE
			DB::table('tbl_sarok_no')
            ->where('sarok_no', $sarok_no)
			->update(['letter_date' => $request->input('letter_date')]);
			// COMMIT DB
			DB::commit();
			// PUSH SUCCESS MESSAGE
			Session::put('message','Data Updated Successfully');
		} catch (\Exception $e) {
			// PUSH FAIL MESSAGE
			Session::put('message','Error: Unable to Updated Data');
			// ROLLBACK BD
			DB::rollback();
		}
		// REDIRECT TO MANAGE CONTROLLER
		return Redirect::to("/$action_controller");	
	}

}
