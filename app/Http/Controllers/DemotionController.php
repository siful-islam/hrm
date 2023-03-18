<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Demotion;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class DemotionController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data['demotion_info'] = Demotion::join('tbl_appointment_info', 'tbl_demotion.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->orderBy('tbl_demotion.id', 'desc')
							->select('tbl_demotion.id','tbl_demotion.emp_id','tbl_demotion.sarok_no','tbl_demotion.letter_date','tbl_demotion.effect_date','tbl_demotion.status','tbl_appointment_info.emp_name')
							->get();
		return view('admin.employee.manage_demotion',$data);	
    }
	
	public function get_employee_info($emp_id)
	{
		$employee_info = DB::table('tbl_appointment_info')
						->join('tbl_designation', 'tbl_designation.id', '=', 'tbl_appointment_info.emp_designation')
						->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_appointment_info.joining_branch')
						->where('emp_id', $emp_id)
						->first();
		$data = array();
		if($employee_info)
		{
			$data['emp_id'] 				= $emp_id;
			$data['emp_name'] 				= $employee_info->emp_name;
			$data['joining_date'] 			= $employee_info->joined_date;
			$data['designation_code'] 		= $employee_info->emp_designation;
			$data['designation_name'] 		= $employee_info->designation_name;
			$data['department_code'] 		= $employee_info->emp_department;
			$data['report_to'] 				= $employee_info->reported_to;
			$data['br_code'] 				= $employee_info->joining_branch;
			$data['branch_name'] 			= $employee_info->branch_name;
		}else{
			$data['emp_id'] 				= $emp_id;
			$data['emp_name'] 				= '';
			$data['joining_date'] 			= '';
			$data['designation_code'] 		= '';
			$data['designation_name'] 		= '';
			$data['department_code'] 		= '';
			$data['report_to'] 				= '';
			$data['br_code'] 				= '';
			$data['branch_name'] 			= '';
		}
		return $data;
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
		$data['action'] 				= '/save-transection';
		$data['action_table'] 			= 'tbl_demotion';
		$data['action_controller'] 		= 'demotion';
		$data['transection_type'] 		= 14;
		$data['Heading'] 				= 'Add Demotion';
		$data['button_text'] 			= 'Save';
		$data['designation_name'] 		= '';
		$data['branch_name'] 			= '';
		//
		$data['id'] 					= '';
		$data['emp_id'] 				= '';		
		$data['emp_name'] 				= '';
		$data['joining_date'] 			= '';
		$data['is_permanent'] 			= '';
		//
		$data['letter_date'] 			= date('Y-m-d');
		$data['effect_date'] 			= date('Y-m-d');
		$data['br_joined_date'] 		= date('Y-m-d');
		$data['sarok_no'] 				= 0;
		$data['br_code'] 				= '';
		$data['designation_code'] 		= '';
		$data['grade_code'] 			= '';
		$data['grade_step'] 			= '';
		$data['department_code'] 		= '';
		$data['report_to'] 				= '' ;
		$todate 		= date('Y-m-d');
		$tomonth 		= date('m');
		$toyear 		= date('Y');

		if($tomonth == '01' || $tomonth == '02' || $tomonth == '03' ||$tomonth == '04' ||$tomonth == '05' ||$tomonth == '06')
		{
			$next_year 		= $toyear;
		}
		else if($tomonth == '07' || $tomonth == '08' || $tomonth == '09' ||$tomonth == '10' ||$tomonth == '11' ||$tomonth == '12')
		{
			$next_year 		= $toyear+1;
		}
		$data['next_increment_date'] = $next_year.'-07-01';
		
		$data['status'] 				= 1;
		$data['demotion_type'] 			= 'Demotion';
		$data['designation_name'] 		= '';
		$data['branch_name'] 			= '';
		$data['Heading'] 				= 'Add Demotion';
		$data['button_text'] 			= 'Save';
		$data['steps'] 		    		= DB::table('tbl_steps')->where('step_status',1)->get();
		$data['branches'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['grades'] 		    	= DB::table('tbl_grade_new')->where('status',1)->get();
		$data['departments'] 		    = DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		$data['reportable'] 		    = DB::table('tbl_designation')->where('status',1)->where('is_reportable',1)->get();
		return view('admin.employee.demotion_form',$data);	
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
		$demotion_info = DB::table('tbl_demotion')->where('id', $id)->first();
		$emp_id 						= $demotion_info->emp_id;
		$data['letter_date'] 			= $demotion_info->letter_date;
		$data['effect_date'] 			= $demotion_info->effect_date;
		$data['sarok_no'] 				= $demotion_info->sarok_no;
		$data['br_code'] 				= $demotion_info->br_code;
		$data['designation_code'] 		= $demotion_info->designation_code;
		$data['department_code'] 		= $demotion_info->department_code;
		$data['report_to'] 				= $demotion_info->report_to ;
		$data['grade_code'] 			= $demotion_info->grade_code;
		$data['grade_step'] 			= $demotion_info->grade_step;
		$data['next_increment_date'] 	= $demotion_info->next_increment_date;
		$data['demotion_type'] 			= $demotion_info->demotion_type;
		$data['status'] 				= $demotion_info->status;
		$data['is_permanent'] 			= '';
		//
		$data['action'] 				= "/update-transection";
		$data['action_table'] 			= 'tbl_demotion';
		$data['action_controller'] 		= 'demotion';
		$data['transection_type'] 		= 14;
		$data['Heading'] 				= 'Edit Demotion';
		$data['button_text'] 			= 'Update';
		//
		$employee_info = DB::table('tbl_appointment_info')
						->join('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_appointment_info.emp_designation')
						->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_appointment_info.joining_branch')
						->where('emp_id', $emp_id)
						->first();
		$data['id'] 					= $id;
		$data['emp_id'] 				= $employee_info->emp_id;		
		$data['emp_name'] 				= $employee_info->emp_name;
		$data['joining_date'] 			= $employee_info->joining_date;
		$data['br_joined_date'] 		= $employee_info->joining_date;
		$data['designation_name'] 		= $employee_info->designation_name;
		$data['branch_name'] 			= $employee_info->branch_name;
		//
		$data['steps'] 		    		= DB::table('tbl_steps')->where('step_status',1)->get();
		$data['branches'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['grades'] 		    	= DB::table('tbl_grade_new')->where('status',1)->get();
		$data['departments'] 		    = DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		$data['reportable'] 		    = DB::table('tbl_designation')->where('status',1)->where('is_reportable',1)->get();
		return view('admin.employee.demotion_form',$data);	
    }
	
	
    public function show($id)
    {
        return "Show".$id;
    }
	
    public function destroy($id)
    {
        echo 'Delete '.$id;
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
