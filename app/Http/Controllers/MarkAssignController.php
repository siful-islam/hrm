<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class MarkAssignController extends Controller
{
	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data['mark_assign_info'] = DB::table('tbl_mark_assign as ma')							
							->leftJoin('tbl_emp_basic_info as e', 'ma.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_branch as b', 'ma.br_code', '=', 'b.br_code')
							->leftJoin('tbl_designation as d', 'ma.designation_code', '=', 'd.designation_code')
							->orderBy('ma.open_date', 'DESC')
							->select('ma.id','ma.emp_id','ma.open_date','ma.marked_for','ma.status','e.emp_name_eng','d.designation_name','b.branch_name')
							->get();
		return view('admin.pages.mark_assign.mark_assign_list',$data);			
    }

    public function create()
    {
		// SAVE = 2 
		$action_id = 2;
		$get_permission = $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		//
		$data = array();
		$data['action'] 				= '/mark-assign';
		$data['method'] 				= 'post';
		$data['method_field'] 			= '';
		$data['id'] 					= '';
		
		$data['emp_id'] 				= '';
		$data['open_date'] = date('Y-m-d');  		$data['emp_name']  = '';    $data['br_code'] 	 = '';
		$data['designation_code'] = '';			   	$data['marked_for'] = '';  $data['marked_details'] = '';  
		//
		$data['Heading'] 	 = 'Add';
		$data['button_text'] = 'Save';
		//
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		return view('admin.pages.mark_assign.mark_assign_form',$data);	

    }

	public function store(Request $request)
    {
		$data = request()->except(['_token','_method']);		
		$data['status'] = 0;
		$data['created_by'] = Session::get('admin_id');
		//print_r ($data); exit;
		DB::table('tbl_mark_assign')->insert($data);
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/mark-assign');			

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
		$mark_assign = DB::table('tbl_mark_assign as ma')
						->leftJoin('tbl_emp_basic_info as e', 'ma.emp_id', '=', 'e.emp_id')
						->where('ma.id', $id)->first();
		
		$data['id'] 				= $id;
		$data['emp_id'] 			= $mark_assign->emp_id;
		$data['open_date'] 			= $mark_assign->open_date;
		$data['emp_name'] 			= $mark_assign->emp_name_eng;
		$data['designation_code'] 	= $mark_assign->designation_code;
		$data['br_code'] 			= $mark_assign->br_code;
		$data['marked_for'] 		= $mark_assign->marked_for;
		$data['marked_details'] 	= $mark_assign->marked_details;
		$data['button_text'] 		= 'Update';
		//print_r ($training_info);

		$data['action'] 				= '/mark-assign/'.$id;
		$data['method'] 				= 'post';
		$data['method_field'] 			= '<input name="_method" value="PATCH" type="hidden">';
		$data['id'] 					= $id;
		
		if (empty($mark_assign->close_date)) {
			$data['close_date'] = '';
		} else {
			$close_date 	= $mark_assign->close_date;
			if ($close_date == '0000-00-00') {
				$data['close_date'] = '';
			} else {
				$data['close_date'] = $close_date;
			}
		}
		//
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->get();
		return view('admin.pages.mark_assign.mark_assign_form',$data);	
    }
	
    public function show($id)
    {
        $data['mark_assign_info'] = DB::table('tbl_mark_assign as ma')
						->leftJoin('tbl_emp_basic_info as e', 'ma.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_designation as d', 'ma.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'ma.br_code', '=', 'b.br_code')
						->where('ma.id', $id)
						->select('ma.*','e.emp_name_eng','d.designation_name','b.branch_name')
						->first();
		//print_r ($data['mark_assign_info']);
		return view('admin.pages.mark_assign.mark_assign_view',$data);
    }
	
	public function update(Request $request, $id)
    {
        $data = request()->except(['_token','_method']);
		//print_r ($data); exit;
		DB::table('tbl_mark_assign')->where('id', $id)->update($data);
		Session::put('message','Data Update Successfully');
		return redirect('mark-assign');
    }
	
	public function MarkAssignClose(Request $request)
    {
		$assign_id = $request->input('assign_id');
		$close_date = $request->input('close_date');
		$updated_at = date('Y-m-d H:i:s');
		$updated_by = Session::get('admin_id');
		//print_r ($branch_code.'**'.$designation_code.'**'.$close_date); exit;
		if (!empty($close_date)) {
			DB::table('tbl_mark_assign')->where('id', $assign_id)->update(['close_date' => $close_date, 'status' => 1, 'close_user_code' => $updated_by, 'updated_at' => $updated_at, 'updated_by' => $updated_by]);
		} else {
			DB::table('tbl_mark_assign')->where('id', $assign_id)->update(['close_date' => $close_date, 'status' => 0]);
		}
		Session::put('message','Data Update Successfully');
		return redirect('mark-assign');
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
