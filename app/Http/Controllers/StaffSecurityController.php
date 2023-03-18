<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StaffSecurity;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class StaffSecurityController extends Controller
{

    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}	
	
	public function index()
    {        	
		
		$data['securities'] = StaffSecurity::get();
		return view('admin.accounts.manage_staff_security',$data);					
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
		$data['diposit_date'] 		= date('Y-m-d');
		$data['diposit_amount']		= '';
		$data['status'] 			= 1;
		//
		$data['action'] 			= '/staff-security';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ''; 		
		$data['Heading'] 			= 'Add Staff Security';
		$data['button_text'] 		= 'Save';
		return view('admin.accounts.staff_security_form', $data);
		
    } 
	
	public function edit($id)
    {
       
	    $info = StaffSecurity:: where('id', $id)->first();
		$action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		$data = array();
		$data['id'] 				= $info->id;
		$data['emp_id'] 			= $info->emp_id;
		$data['diposit_date'] 		= $info->diposit_date;
		$data['diposit_amount']		= $info->diposit_amount;
		$data['status'] 			= $info->status;
		//
		$data['action'] 			= "/staff-security/$id";
		$data['method'] 			= 'POST';
		$data['method_control'] 	= "<input type='hidden' name='_method' value='PUT' />";	
		$data['Heading'] 			= 'Edit Staff Security';
		$data['button_text'] 		= 'Update';
		return view('admin.accounts.staff_security_form', $data);
    }	
	
	public function store(Request $request)
    {
        $data = request()->except(['_token','_method']);
		
		$data['created_by'] =  Session::get('admin_id');
		$data['updated_by'] =  Session::get('admin_id');
		$data['org_code'] 	=  Session::get('admin_org_code');
		
		$status = DB::table('tbl_staff_security')->insertGetId($data);
		
		$emp_id 			= $request->emp_id;
		$diposit_date 		= $request->diposit_date;
		$diposit_amount 	= $request->diposit_amount;
		$info = DB::table('security_register')
				->where('emp_id', $emp_id)
				->orderBy('security_register_id', 'DESC')
				->first();
		if($info)
		{
			$sdata['emp_id'] 					= $emp_id;
			$sdata['security_opening_balance'] 	= $info->security_ending_balance;
			$sdata['security_payment_amount'] 	= $diposit_amount;
			$sdata['security_ending_balance'] 	= $info->security_ending_balance + $diposit_amount;
			$sdata['security_paid_month'] 		= $diposit_date;
			$sdata['security_user_code'] 		= Session::get('admin_id');
		}else{
			$sdata['emp_id'] 					= $emp_id;
			$sdata['security_opening_balance'] 	= 0;
			$sdata['security_payment_amount'] 	= $diposit_amount;
			$sdata['security_ending_balance'] 	= $diposit_amount;
			$sdata['security_paid_month'] 		= $diposit_date;
			$sdata['security_user_code'] 		= Session::get('admin_id');
		}
		
		DB::table('security_register')->insertGetId($sdata);
		
		if($status)
		{	
			Session::put('message','Data Saved Successfully');		
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
		return Redirect::to('/staff-security');
    }
	
    public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);
		$data['updated_by'] =  Session::get('admin_id');
		
		$status = DB::table('tbl_staff_security')
            ->where('id', $id)
            ->update($data);
			
		if($status)
		{
			Session::put('message','Data Updated Successfully');         			
		}
		else
		{
			Session::put('message','Error: Unable to Update Data');
		}
		
		return Redirect::to('/staff-security');
    }  
	
	
	public function show($id)
	{
		//$info = StaffSecurity:: where('id', $id)->first();

		$info = DB::table('tbl_staff_security')
										->join('tbl_appointment_info', 'tbl_appointment_info.emp_id', '=', 'tbl_staff_security.emp_id')
										->join('tbl_admin', 'tbl_admin.admin_id', '=', 'tbl_staff_security.created_by')
										->where('tbl_staff_security.id', $id)
										->select('tbl_staff_security.*','tbl_appointment_info.emp_name','tbl_admin.admin_name')
										->first();
		
		
		$data = array();
		$data['id'] 				= $info->id;
		$data['emp_name'] 			= $info->emp_name;
		$data['emp_id'] 			= $info->emp_id;
		$data['diposit_date'] 		= $info->diposit_date;
		$data['diposit_amount']		= $info->diposit_amount;
		$data['status'] 			= $info->status;
		$data['admin_name'] 		= $info->admin_name;
		//
		
		
		//print_r($data);
		//exit;
		
		
		
		
		return view('admin.accounts.security_money_receipt', $data);
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
