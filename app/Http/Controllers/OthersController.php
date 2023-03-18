<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Others;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class OthersController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data['others_info'] = Others::join('tbl_appointment_info', 'tbl_others.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->select('tbl_others.id','tbl_others.emp_id','tbl_others.sarok_no','tbl_others.letter_date','tbl_others.effect_date','tbl_others.status','tbl_appointment_info.emp_name')
							->get();
											
		return view('admin.employee.manage_others',$data);	
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
		$data['action_table'] 			= 'tbl_others';
		$data['action_controller'] 		= 'promotion';
		$data['transection_type'] 		= 4;
		$data['Heading'] 				= 'Add Others';
		$data['button_text'] 			= 'Save';
		$data['designation_name'] 		= '';
		$data['branch_name'] 			= '';
		//
		$data['id'] 					= '';
		$data['emp_id'] 				= '';		
		$data['emp_name'] 				= '';
		$data['joining_date'] 			= '';
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
		$data['next_increment_date'] 	= date('Y-m-d',strtotime($data['effect_date'] . "+12 month"));
		$data['status'] 				= 1;
		$data['emp_photo'] 				= 'default.png';
		//
		$data['designation_name'] 		= '';
		$data['branch_name'] 			= '';
		$data['Heading'] 				= 'Add Others';
		$data['button_text'] 			= 'Save';
		//
		$data['branches'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['grades'] 		    	= DB::table('tbl_grade_new')->where('status',1)->get();
		$data['departments'] 		    = DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		$data['reportable'] 		    = DB::table('tbl_designation')->where('status',1)->where('is_reportable',1)->get();
		
		return view('admin.employee.promotion_form',$data);	
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
		$promotion_info = DB::table('tbl_others')->where('id', $id)->first();
		$emp_id 						= $promotion_info->emp_id;
		$data['letter_date'] 			= $promotion_info->letter_date;
		$data['effect_date'] 			= $promotion_info->effect_date;
		$data['sarok_no'] 				= $promotion_info->sarok_no;
		$data['br_code'] 				= $promotion_info->br_code;
		$data['designation_code'] 		= $promotion_info->designation_code;
		$data['department_code'] 		= $promotion_info->department_code;
		$data['report_to'] 				= $promotion_info->report_to ;
		$data['grade_code'] 			= $promotion_info->grade_code;
		$data['grade_step'] 			= $promotion_info->grade_step;
		$data['next_increment_date'] 	= $promotion_info->next_increment_date;
		$data['promotion_type'] 		= $promotion_info->promotion_type;
		$data['status'] 				= $promotion_info->status;
		
		//
		$data['action'] 				= "/update-transection";
		$data['action_table'] 			= 'tbl_others';
		$data['action_controller'] 		= 'promotion';
		$data['transection_type'] 		= 1;
		$data['Heading'] 				= 'Edit Others';
		$data['button_text'] 			= 'Update';
		//
		/*$employee_info = DB::table('tbl_appointment_info')
						->join('tbl_designation', 'tbl_designation.id', '=', 'tbl_appointment_info.emp_designation')
						->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_appointment_info.joining_branch')
						->where('emp_id', $emp_id)
						->first();*/
						
		$employee_info = DB::table('tbl_appointment_info')
				->leftjoin('tbl_others', 'tbl_others.emp_id', '=', 'tbl_appointment_info.emp_id')
				->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_others.designation_code')
				->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_appointment_info.joining_branch')
				->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_appointment_info.emp_id')
				->where('tbl_appointment_info.emp_id', $emp_id)
				->first();	
		if(!empty($employee_info->emp_photo))
		{
			$data['emp_photo'] 			= $employee_info->emp_photo;
		}
		else
		{
			$data['emp_photo'] 			= 'default.png';
		}

				
		$data['id'] 					= $id;
		$data['emp_id'] 				= $employee_info->emp_id;		
		$data['emp_name'] 				= $employee_info->emp_name;
		$data['joining_date'] 			= $employee_info->joining_date;
		$data['br_joined_date'] 		= $employee_info->joining_date;
		$data['designation_name'] 		= $employee_info->designation_name;
		$data['branch_name'] 			= $employee_info->branch_name;
		//
		$data['branches'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		/*$data['grades'] 		    	= DB::table('tbl_grade')
											->where('start_from', '<=', $data['letter_date'])
											->where('end_to', '>=', $data['letter_date'])
											->where('status',1)
											->get();*/
		$data['grades'] 		    	= DB::table('tbl_grade_new')->where('status',1)->get();	
		$data['departments'] 		    = DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		    = DB::table('tbl_designation')->get();
		$data['reportable'] 		    = DB::table('tbl_designation')->where('status',1)->where('is_reportable',1)->get();
		return view('admin.employee.promotion_form',$data);	
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
