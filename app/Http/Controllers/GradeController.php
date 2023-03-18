<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Grade;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class GradeController extends Controller
{

    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}	
	public function index()
    {        	
		$data['grades'] = Grade::join('tbl_scale', 'tbl_scale.scale_id', '=', 'tbl_grade.scale_id')
						->select('tbl_grade.id','tbl_grade.grade_name','tbl_grade.status','tbl_scale.scale_name','tbl_grade.start_from','tbl_grade.end_to')
						->orderBy('tbl_grade.id', 'desc')
						->get();
		return view('admin.settings.manage_grade',$data);					
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
		$data['grade_name']			= '';
		$data['scale_id'] 			= '';
		$data['status'] 			= 1;
		$data['start_from'] 		= date('Y-m-d');
		$data['end_to'] 			= date('Y-m-d');
		//
		$data['action'] 			= '/config-grade';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ''; 		
		$data['Heading'] 			= 'Add Grade';
		$data['button_text'] 		= 'Save';
		$data['all_scale'] 	= DB::table('tbl_scale')->where('status', 1)->get();
		return view('admin.settings.grade_form', $data);
		
    } 
	
	public function edit($id)
    {
       
	    $info = Grade:: where('id', $id)->first();
		$action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		$data = array();
		$data['id'] 				= $info->id;
		$data['grade_name']			= $info->grade_name;
		$data['scale_id'] 			= $info->scale_id;
		$data['status'] 			= $info->status;
		$data['start_from'] 		= $info->start_from;
		$data['end_to'] 			= $info->end_to;
		//
		$data['action'] 			= "/config-grade/$id";
		$data['method'] 			= 'POST';
		$data['method_control'] 	= "<input type='hidden' name='_method' value='PUT' />";	
		$data['Heading'] 			= 'Edit Grade';
		$data['button_text'] 		= 'Update';
		$data['all_scale'] 	= DB::table('tbl_scale')->where('status', 1)->get();
		return view('admin.settings.grade_form', $data);
    }	
	
	public function store(Request $request)
    {
        $data = request()->except(['_token','_method']);
		
		$status = DB::table('tbl_grade')->insertGetId($data);
		if($status)
		{	
			Session::put('message','Data Saved Successfully');		
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
		return Redirect::to('/config-grade');
    }
	
    public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);
		
		$status = DB::table('tbl_grade')
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
		
		return Redirect::to('/config-grade');
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
