<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class EmpAssignController extends Controller
{
	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data['title'] = 'Employee Assign';
		$data['assign_info'] = DB::table('tbl_emp_assign as ea')							
							->leftJoin('tbl_emp_basic_info as e', 'ea.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_branch as b', 'ea.br_code', '=', 'b.br_code')
							->leftJoin('tbl_designation as d', 'ea.designation_code', '=', 'd.designation_code')
							->orderBy('ea.open_date', 'DESC')
							->select('ea.id','ea.emp_id','ea.open_date','ea.incharge_as','ea.select_type','ea.status','e.emp_name_eng','d.designation_name','b.branch_name')
							->get();
		return view('admin.pages.emp_assign.emp_assign_list',$data);			
    }

    public function create()
    {
		// SAVE = 2 
		$action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		//
		$data = array();
		$data['title'] = 'Employee Assign';
		$data['action'] 				= '/emp-assign';
		$data['method'] 				= 'post';
		$data['method_field'] 			= '';
		$data['id'] 					= '';
		
		$data['emp_id'] 				= '';
		$data['open_date'] = date('Y-m-d');  		$data['select_type'] = '';  $data['emp_name']  = '';
		$data['designation_code'] = '';			   	$data['br_code'] 	 = '';  $data['incharge_as'] = '';  
		$data['salary_br_code'] 	 = '';
		//
		$data['Heading'] 	 = 'Add Assign';
		$data['button_text'] = 'Save';
		//
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		return view('admin.pages.emp_assign.emp_assign_form',$data);	

    }

	public function store(Request $request)
    {
		$data = request()->except(['_token','_method','branch_code']);
		$branch_code = $request->input('branch_code');
		
		($data['select_type'] == 2) ? $data['br_code'] = $data['br_code'] : $data['br_code'] = $branch_code;
		if($data['select_type'] == 1) {
			($data['designation_code']==15 || $data['designation_code']==125) ? $data['status'] = 2 : $data['status'] = 1;
		} else if ($data['select_type'] == 2) {
			$data['status'] = 3;
			$data['salary_br_code'] = $data['salary_br_code'];
			/* insert data tbl_sarok_no */
			$sarok_id = DB::table('tbl_sarok_no')->max('sarok_no');
			$data['sarok_no'] = $sarok_id+1;
			$sarok_data['sarok_no']    			= $data['sarok_no'];
			$sarok_data['letter_date'] 			= $data['open_date'];
			$sarok_data['emp_id'] 	   			= $data['emp_id'];
			$sarok_data['transection_type'] 	= 13;
			DB::table('tbl_sarok_no')->insert($sarok_data);
			
			/* update data tbl_master_tra */
			$emp_last_info = DB::table('tbl_master_tra')->where('emp_id', $data['emp_id'])->orderBy('id', 'DESC')->select('id','emp_id','br_code','salary_br_code')->first();
			DB::table('tbl_master_tra')->where('id', $emp_last_info->id)->update(['salary_br_code' => $data['salary_br_code']]);
			
		} else if ($data['select_type'] == 3) {
			$data['status'] = 4;
		} else if ($data['select_type'] == 4) {
			$data['status'] = 5;
		} else if ($data['select_type'] == 5) {
			$data['status'] = 6;
		} else if ($data['select_type'] == 6) {
			$data['status'] = 7;
		}
		//print_r ($data); exit;
		
		DB::table('tbl_emp_assign')->insert($data);
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/emp-assign');			

    }

    public function edit($id)
    {
		//UPDATE = 3;
		$action_id = 3;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		$data = array();
		$data['title'] = 'Employee Assign';
		$assign_info = DB::table('tbl_emp_assign as ea')
						->leftJoin('tbl_emp_basic_info as e', 'ea.emp_id', '=', 'e.emp_id')
						->where('ea.id', $id)->first();
		
		$data['id'] 				= $id;
		$data['emp_id'] 			= $assign_info->emp_id;
		$data['open_date'] 			= $assign_info->open_date;
		$data['select_type'] 		= $assign_info->select_type;
		$data['emp_name'] 			= $assign_info->emp_name_eng;
		$data['designation_code'] 	= $assign_info->designation_code;
		$data['br_code'] 			= $assign_info->br_code;
		$data['incharge_as'] 		= $assign_info->incharge_as;
		$data['salary_br_code'] 	= $assign_info->salary_br_code;
		$data['button_text'] 		= 'Update';
		//print_r ($training_info);

		$data['action'] 				= '/emp-assign/'.$id;
		$data['method'] 				= 'post';
		$data['method_field'] 			= '<input name="_method" value="PATCH" type="hidden">';
		$data['id'] 					= $id;
		
		if (empty($assign_info->close_date)) {
			$data['close_date'] = '';
		} else {
			$close_date 	= $assign_info->close_date;
			if ($close_date == '0000-00-00') {
				$data['close_date'] = '';
			} else {
				$data['close_date'] = $close_date;
			}
		}
		//
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->get();
		return view('admin.pages.emp_assign.emp_assign_form',$data);	
    }
	
    public function show($id)
    {
        $data['title'] = 'Employee Assign';
		$data['assign_info'] = DB::table('tbl_emp_assign as ea')
						->leftJoin('tbl_emp_basic_info as e', 'ea.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_designation as d', 'ea.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'ea.br_code', '=', 'b.br_code')
						->leftJoin('tbl_branch as sb', 'ea.salary_br_code', '=', 'sb.br_code')
						->where('ea.id', $id)
						->select('ea.*','e.emp_name_eng','d.designation_name','b.branch_name','sb.branch_name as salary_branch_name')
						->first();
		//print_r ($data['assign_info']);
		return view('admin.pages.emp_assign.emp_assign_view',$data);
    }
	
	public function update(Request $request, $id)
    {
        $data = request()->except(['_token','_method','branch_code']);
		$branch_code = $request->input('branch_code');
		//print_r ($data); exit;
		($data['select_type'] == 2) ? $data['br_code'] = $data['br_code'] : $data['br_code'] = $branch_code;
		if($data['select_type'] == 1) {
			($data['designation_code']==15 || $data['designation_code']==125) ? $data['status'] = 2 : $data['status'] = 1;
		} else if ($data['select_type'] == 2) {
			$data['status'] = 3;
			$data['salary_br_code'] = $data['salary_br_code'];		
			/* update data tbl_master_tra */
			$emp_last_info = DB::table('tbl_master_tra')->where('emp_id', $data['emp_id'])->orderBy('id', 'DESC')->select('id','emp_id','br_code','salary_br_code')->first();
			DB::table('tbl_master_tra')->where('id', $emp_last_info->id)->update(['salary_br_code' => $data['salary_br_code']]);
		
		} else if ($data['select_type'] == 3) {
			$data['status'] = 4;
		} else if ($data['select_type'] == 4) {
			$data['status'] = 5;
		} else if ($data['select_type'] == 5) {
			$data['status'] = 6;
		} else if ($data['select_type'] == 6) {
			$data['status'] = 7;
		}
		//print_r ($data); exit;
		DB::table('tbl_emp_assign')->where('id', $id)->update($data);
		Session::put('message','Data Update Successfully');
		return redirect('emp-assign');
    }
	
	public function EmpAssignClose(Request $request)
    {
		$assign_id = $request->input('assign_id');
		$designation_code = $request->input('designation_code');
		$close_date = $request->input('close_date');
		$emp_id = $request->input('emp_id');
		//print_r ($branch_code.'**'.$designation_code.'**'.$close_date); exit;
		if (!empty($close_date)) {
			DB::table('tbl_emp_assign')->where('id', $assign_id)->update(['close_date' => $close_date, 'status' => 0]);
			/* update data tbl_master_tra */
			//$emp_last_info = DB::table('tbl_master_tra')->where('emp_id', $emp_id)->orderBy('id', 'DESC')->select('id','emp_id','br_code','salary_br_code')->first();
			//DB::table('tbl_master_tra')->where('id', $emp_last_info->id)->update(['salary_br_code' => $emp_last_info->br_code]);
		} else {
			($designation_code==15 || $designation_code==125) ? $status = 2 : $status = 1;
			DB::table('tbl_emp_assign')->where('id', $assign_id)->update(['close_date' => $close_date, 'status' => $status]);
		}
		Session::put('message','Data Update Successfully');
		return redirect('emp-assign');
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
