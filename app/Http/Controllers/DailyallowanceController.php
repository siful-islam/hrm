<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Dailyallowance;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class DailyallowanceController extends Controller
{

    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}	
	
	public function index()
    {        
		$data['daily_allowance_list'] = DB::table('tbl_move_bill_allow_con as tr')
										->leftJoin("tbl_grade_new as g",function($join){
												$join->on("g.grade_code","=","tr.grade_code");
										})  
										->select('tr.*','g.grade_name')
										->get(); 
		return view('admin.settings.manage_dailyallowance',$data);					
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
		$data['breakfast']			= ''; 
		$data['from_date']			= ''; 
		$data['to_date']			= ''; 
		$data['status'] 			= 1;
		$data['lunch']				= '';
		$data['dinner'] 			= '';
		$data['grade_code'] 		= '';
		//
		$data['action'] 			= '/daily_allowance';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ''; 		
		$data['Heading'] 			= 'Add Daily Allowance';
		$data['button_text'] 		= 'Save';
		$data['grade_list'] = DB::table('tbl_grade_new')  
								->select('grade_code','grade_name')
								->get();
		return view('admin.settings.dailyallowance_form', $data);
		
    } 
	
	public function edit($id)
    {
       
	    $info = Dailyallowance:: where('id', $id)->first();
		$action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		$data = array();
		$data['id'] 				= $info->id;
		$data['breakfast']			= $info->breakfast; 
		$data['lunch'] 				= $info->lunch;
		$data['dinner'] 			= $info->dinner;
		$data['grade_code'] 		= $info->grade_code;
		$data['from_date'] 			= $info->from_date;
		$data['to_date'] 			= $info->to_date;
		$data['status'] 			= $info->status; 
		 
		//
		$data['action'] 			= "/daily_allowance/$id";
		$data['method'] 			= 'POST';
		$data['method_control'] 	= "<input type='hidden' name='_method' value='PUT' />";	
		$data['Heading'] 			= 'Edit Daily Allowance';
		$data['button_text'] 		= 'Update';
		$data['grade_list'] = DB::table('tbl_grade_new')  
								->select('grade_code','grade_name')
								->get();
		return view('admin.settings.dailyallowance_form', $data);
    }	
	
	public function store(Request $request)
    {
        $data = request()->except(['_token','_method']);
		$data['created_by'] = Session::get('admin_id');
		/* echo '<pre>';
		print_r( $data);
		exit; */
		$status = DB::table('tbl_move_bill_allow_con')->insertGetId($data);
		if($status)
		{	
			Session::put('message','Data Saved Successfully');		
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
		return Redirect::to('/daily_allowance');
    }
	
    public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);
		$data['updated_by'] = Session::get('admin_id');
		$data['updated_at'] = date("Y-m-d");
		$status = DB::table('tbl_move_bill_allow_con')
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
		
		return Redirect::to('/daily_allowance');
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
