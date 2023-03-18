<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Organization;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
//session_start();

class OrganizationController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data['organizations'] = Organization::get();
		return view('admin.config.manage_organization',$data);					
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
		$data['org_id'] 			= '';
		$data['org_full_name'] 		= '';		
		$data['org_short_name'] 	= '';
		$data['org_code'] 			= '';
		$data['reg_no'] 			= '';
		$data['org_logo'] 			= 'public/org_logo/default.png';
		$data['pre_org_logo'] 		= 'default.png';
		$data['favicon'] 			= '';
		$data['org_address'] 		= '';
		$data['org_contact'] 		= '';
		$data['org_email'] 			= '';
		$data['org_web_address'] 	= '';
		$data['org_start_date'] 	= date('Y-m-d');
		$data['org_status'] 		= 1;
		//
		$data['action'] 			= '/org-manager';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ''; 		
		$data['Heading'] 			= 'Add Organization';
		$data['button_text'] 		= 'Save';
		return view('admin.config.organization_form',$data);	
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
		$org_info = Organization:: where('org_id', $id)->first();
		$data['org_id'] = $org_info->org_id;
		$data['org_full_name'] 		= $org_info->org_full_name;
		$data['org_short_name'] 	= $org_info->org_short_name;
		$data['org_code'] 			= $org_info->org_code;
		$data['reg_no'] 			= $org_info->reg_no;
		$data['org_logo'] 			= $org_info->org_logo;
		$data['org_logo'] 			= 'public/org_logo/'.$org_info->org_logo;	
		$data['pre_org_logo'] 		= $org_info->org_logo;	
		$data['org_address'] 		= $org_info->org_address;
		$data['org_contact'] 		= $org_info->org_contact;
		$data['org_email'] 			= $org_info->org_email;
		$data['org_web_address'] 	= $org_info->org_web_address;
		$data['org_start_date'] 	= $org_info->org_start_date;
		$data['org_status'] 		= $org_info->org_status;
		$data['action'] 			= "/org-manager/$id";
		$data['method'] 			= 'POST';
		$data['method_control'] 	= "<input type='hidden' name='_method' value='PUT' />"; 		
		$data['Heading'] 			= 'Edit Organization';
		$data['button_text'] 		= 'Update';
		return view('admin.config.organization_form',$data);
    }
	
	public function store(Request $request)
    {
		$data = request()->except(['_token','_method','pre_org_logo']);
		
		if($request->file('org_logo'))
		{
			$data['org_logo'] = $request->org_logo->getClientOriginalName();
			$request->org_logo->move(public_path('org_logo'), $data['org_logo']);
		}
		else
		{
			$data['org_logo'] = "default.png";
		}
		
		$status = DB::table('tbl_ogranization')->insertGetId($data);
		if($status)
		{	
			Session::put('message','Data Saved Successfully');		
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
		
		return Redirect::to('/org-manager');
    }
	
	public function update(Request $request, $id)
    {		
		$data = request()->except(['_token','_method','pre_org_logo']);

		if($request->file('org_logo'))
		{
			$data['org_logo'] = $request->org_logo->getClientOriginalName();
			$request->org_logo->move(public_path('org_logo'), $data['org_logo']);
		}
		else
		{
			$data['org_logo'] = $request->input('pre_org_logo');
		}
				
		$status = DB::table('tbl_ogranization')
            ->where('org_id', $id)
            ->update($data);
			
		if($status)
		{
			Session::put('message','Data Updated Successfully');         			
		}
		else
		{
			Session::put('message','Error: Unable to Update Data');
		}
		
		 return Redirect::to('/org-manager');
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
