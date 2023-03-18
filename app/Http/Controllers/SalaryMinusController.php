<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Salary_minus;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class SalaryMinusController extends Controller
{

    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}	
	public function index()
    {        	
		//$data['all_scale'] 	= DB::table('tbl_scale')->where('status', 1)->get();	
		$data['items'] 	= Salary_minus::join('tbl_designation as d1', 'd1.designation_code', '=', 'tbl_salary_minus.designation_for','left')
							->join('tbl_minus_items as item', 'item.item_id', '=', 'tbl_salary_minus.item_name','left')
							->join('tbl_department as dept', 'dept.id', '=', 'tbl_salary_minus.emp_department','left')
							->join('tbl_grade_new as grade', 'grade.grade_id', '=', 'tbl_salary_minus.emp_grade','left')
							->select('tbl_salary_minus.*','d1.designation_name','item.items_name','dept.department_name','grade.grade_name')
							->get(); 
		return view('admin.settings.manage_salary_minus',$data);					
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
		$data['item_name']			= '';
		$data['type']				= 1;
		$data['percentage']			= 0;
		$data['fixed_amount']		= 0;
		$data['ho_bo']				= 1;
		$data['designation_for']	= 0;
		$data['emp_department']		= 0;
		$data['emp_grade']			= 0;
		$data['epmloyee_status']	= 0;
		$data['status'] 			= 1;
		$data['active_from'] 		= date('Y-m-d');
		$data['active_upto'] 		= date('Y-m-d');
		//
		$data['action'] 			= '/salary-minus';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ''; 		
		$data['Heading'] 			= 'Add Salary Minus Item';
		$data['button_text'] 		= 'Save';
		$data['designations'] 		= DB::table('tbl_designation')->where('status',1)->get();
		$data['departments'] 		= DB::table('tbl_department')->where('status',1)->get();	
		$data['grades'] 			= DB::table('tbl_grade_new')->where('status',1)->get();			
		$data['minus_items'] 		= DB::table('tbl_minus_items')->where('status',1)->get();
		return view('admin.settings.minus_form', $data);
		
    } 
	
	public function edit($id)
    {
       
	    $info = Salary_minus:: where('id', $id)->first();
		$action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		$data = array();
		$data['id'] 				= $info->id;
		$data['item_name']			= $info->item_name;
		$data['type']				= $info->type;
		$data['percentage']			= $info->percentage;
		$data['fixed_amount']		= $info->fixed_amount;
		$data['ho_bo']				= $info->ho_bo;
		$data['designation_for']	= $info->designation_for;
		$data['emp_department']		= $info->emp_department;
		$data['emp_grade']			= $info->emp_grade;
		$data['epmloyee_status']	= $info->epmloyee_status;
		$data['status'] 			= $info->status;
		$data['active_from'] 		= $info->active_from;
		$data['active_upto'] 		= $info->active_upto;
		//
		$data['action'] 			= "/salary-minus/$id";
		$data['method'] 			= 'POST';
		$data['method_control'] 	= "<input type='hidden' name='_method' value='PUT' />";	
		$data['Heading'] 			= 'Edit Salary Minus Item';
		$data['button_text'] 		= 'Update';
		$data['minus_items'] 		= DB::table('tbl_minus_items')->where('status',1)->get();
		$data['designations'] 		= DB::table('tbl_designation')->where('status',1)->get();
		$data['departments'] 		= DB::table('tbl_department')->where('status',1)->get();
		$data['grades'] 			= DB::table('tbl_grade_new')->where('status',1)->get();			
		return view('admin.settings.minus_form', $data);
    }	
	
	public function store(Request $request)
    {
        $data = request()->except(['_token','_method']);
		
		$data['created_by'] =  Session::get('admin_id');
		$data['updated_by'] =  Session::get('admin_id');
		$data['org_code'] 	=  Session::get('admin_org_code');
		
		$status = DB::table('tbl_salary_minus')->insertGetId($data);
		if($status)
		{	
			Session::put('message','Data Saved Successfully');		
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
		return Redirect::to('/salary-minus');
    }
	
    public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);
		
		$data['updated_by'] =  Session::get('admin_id');

		$status = DB::table('tbl_salary_minus')
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
		
		return Redirect::to('/salary-minus');
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
