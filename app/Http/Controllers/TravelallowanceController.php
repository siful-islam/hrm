<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Travelallowance;
use Session;
use Illuminate\Support\Facades\Redirect;
////session_start();

class TravelallowanceController extends Controller
{

    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}	
	
	public function index()
    {        
		$data['travel_allowance_list'] = DB::table('tbl_move_tra_allow_con as tr')
										->leftJoin("tbl_branch as b",function($join){
												$join->on("b.br_code","=","tr.source_br_code");
										}) 
										->leftJoin("tbl_branch as bd",function($join){
												$join->on("bd.br_code","=","tr.dest_br_code");
										})  
										->select('tr.*','b.branch_name as source_branch_name','bd.branch_name as destination_branch_name')
										->get(); 
		return view('admin.settings.manage_travelallowance',$data);					
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
		$data['travel_amt']			= ''; 
		$data['from_date']			= '2018-01-01'; 
		$data['to_date']			= '2025-01-01'; 
		$data['status'] 			= 1;
		$data['source_br_code']		= '';
		$data['dest_br_code'] 		= '';
		//
		$data['action'] 			= '/travel_allowance';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ''; 		
		$data['Heading'] 			= 'Add Travel Allowance';
		$data['button_text'] 		= 'Save';
		$data['branch_list'] = DB::table('tbl_branch') 
								->where('status',1)
								->orderby('branch_name','asc')
								->select('br_code','branch_name')
								->get();
		return view('admin.settings.travelallowance_form', $data);
		
    } 
	
	public function edit($id)
    {
       
	    $info = Travelallowance:: where('id', $id)->first();
		$action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		$data = array();
		$data['id'] 				= $info->id;
		$data['source_br_code']		= $info->source_br_code;
		$data['dest_br_code'] 		= $info->dest_br_code;
		$data['travel_amt'] 		= $info->travel_amt;
		$data['from_date'] 			= $info->from_date;
		$data['to_date'] 			= $info->to_date;
		$data['status'] 			= $info->status;
		//
		$data['action'] 			= "/travel_allowance/$id";
		$data['method'] 			= 'POST';
		$data['method_control'] 	= "<input type='hidden' name='_method' value='PUT' />";	
		$data['Heading'] 			= 'Edit Travel Allowance';
		$data['button_text'] 		= 'Update';
		$data['branch_list'] = DB::table('tbl_branch') 
								->where('status',1)
								->orderby('branch_name','asc')
								->select('br_code','branch_name')
								->get();
		return view('admin.settings.travelallowance_form', $data);
    }	
	
	public function store(Request $request)
    {
        $data = request()->except(['_token','_method']);
		$data['created_by'] = Session::get('admin_id');
		/* echo '<pre>';
		print_r( $data);
		exit; */
		$status = DB::table('tbl_move_tra_allow_con')->insertGetId($data);
		if($status)
		{	
			Session::put('message','Data Saved Successfully');		
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
		return Redirect::to('/travel_allowance');
    }
	
    public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);
		$data['updated_by'] = Session::get('admin_id');
		$data['updated_at'] = date("Y-m-d");
		$status = DB::table('tbl_move_tra_allow_con')
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
		
		return Redirect::to('/travel_allowance');
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
