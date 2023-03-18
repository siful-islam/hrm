<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Transfer_remarks;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
////session_start();

class Transfer_remarksController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data['remarks'] = Transfer_remarks::get();
		return view('admin.settings.manage_transfer_remarks',$data);					
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
		$data['id'] 			= '';
		$data['remarks_note'] 		= '';		
		$data['status'] 			= 1;
		//
		$data['action'] 			= '/transfer-remarks';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ''; 		
		$data['Heading'] 			= 'Add Transfer Remarks';
		$data['button_text'] 		= 'Save';
		return view('admin.settings.transfer_remarks_form',$data);	
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
		$org_info = Transfer_remarks:: where('id', $id)->first();
		
		$data['id'] 				= $org_info->id;
		$data['remarks_note'] 		= $org_info->remarks_note;
		$data['status'] 			= $org_info->status;
		//
		$data['action'] 			= "/transfer-remarks/$id";
		$data['method'] 			= 'POST';
		$data['method_control'] 	= "<input type='hidden' name='_method' value='PUT' />"; 		
		$data['Heading'] 			= 'Edit Transfer Remarks';
		$data['button_text'] 		= 'Update';
		return view('admin.settings.transfer_remarks_form',$data);	
    }
	
	public function store(Request $request)
    {
		$data = request()->except(['_token','_method']);
		
		$data['created_by'] = Session::get('admin_id');
		$data['updated_by'] = Session::get('admin_id');
		$data['org_code'] 	= Session::get('admin_org_code');
		
		$status = DB::table('tbl_transfer_remarks')->insertGetId($data);
		if($status)
		{	
			Session::put('message','Data Saved Successfully');		
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
		
		return Redirect::to('/transfer-remarks');
    }
	
	public function update(Request $request, $id)
    {		
		$data = request()->except(['_token','_method']);
		$status = DB::table('tbl_transfer_remarks')
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
		
		 return Redirect::to('/transfer-remarks');
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
