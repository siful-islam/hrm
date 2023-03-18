<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class DepartmentController extends Controller
{

    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}	
	
	public function index()
    {        	
		$data['departments'] = Department::get();
		return view('admin.settings.manage_department',$data);					
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
		$data['department_id']		= '';
		$data['department_name'] 	= '';
		$data['department_bangla'] 	= '';
		$data['status'] 			= 1;
		//
		$data['action'] 			= '/config-department';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ''; 		
		$data['Heading'] 			= 'Add Department';
		$data['button_text'] 		= 'Save';
		return view('admin.settings.department_form', $data);
		
    } 
	
	public function edit($id)
    {
       
	    $info = Department:: where('id', $id)->first();
		$action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		$data = array();
		$data['id'] 				= $info->id;
		$data['department_id']		= $info->department_id;
		$data['department_name'] 	= $info->department_name;
		$data['department_bangla'] 	= $info->department_bangla;
		$data['status'] 			= $info->status;
		//
		$data['action'] 			= "/config-department/$id";
		$data['method'] 			= 'POST';
		$data['method_control'] 	= "<input type='hidden' name='_method' value='PUT' />";	
		$data['Heading'] 			= 'Edit Department';
		$data['button_text'] 		= 'Update';
		return view('admin.settings.department_form', $data);
    }	
	
	public function store(Request $request)
    {
        $data = request()->except(['_token','_method']);
		
		$status = DB::table('tbl_department')->insertGetId($data);
		if($status)
		{	
			Session::put('message','Data Saved Successfully');		
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
		return Redirect::to('/config-department');
    }
	
    public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);
		
		$status = DB::table('tbl_department')
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
		
		return Redirect::to('/config-department');
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
