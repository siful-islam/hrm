<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class EmpMappingController extends Controller
{
	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data['mapping_info'] = DB::table('tbl_emp_mapping as em')							
							->leftJoin('tbl_emp_basic_info as e', 'em.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_department as d', 'em.current_department_id', '=', 'd.department_id')
							->leftJoin('tbl_unit_name as u', 'em.unit_id', '=', 'u.id')
							->orderBy('em.start_date', 'DESC')
							->select('em.id','em.emp_id','em.current_program_id','em.start_date','e.emp_name_eng','d.department_name','u.unit_name')
							->get();
		return view('admin.pages.emp_mapping.emp_mapping_list',$data);			
    }

    public function MappingEmpCreate()
    {
		$data = array();
		$data['action'] 				= '/emp-mapping';
		$data['method'] 				= 'post';
		$data['method_field'] 			= '';
		$data['id'] 					= '';
		
		$data['emp_id'] 				= '';
		//
		$data['Heading'] 	 = 'Add Assign';
		$data['button_text'] = 'Save';
		$data['id'] = '';
		$data['value_id'] = 1;
		return view('admin.pages.emp_mapping.emp_mapping_form',$data);	

    }
	
	public function MappingEmp(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Employee Mapping';
		$data['emp_id'] 	= $emp_id 	= $request->input('emp_id');
		$data['form_date'] 	= $form_date = date('Y-m-d');
		$data['action'] 	= '/emp-mapping';
		$data['method'] 	= 'post';
		$data['method_field'] 	= '';
		$data['button_text'] = 'Save';
		
		$user_type 	= Session::get('user_type');
		$branch_code = Session::get('branch_code');
		if(!empty($emp_id)) {
			$all_result = DB::table('tbl_emp_mapping as em')
					->leftJoin('tbl_resignation as r', 'em.emp_id', '=', 'r.emp_id')
					->leftJoin('tbl_emp_basic_info as e', 'em.emp_id', '=', 'e.emp_id')
					->leftJoin('tbl_department as d', 'em.mother_department_id', '=', 'd.department_id')
					->leftJoin('tbl_department as de', 'em.current_department_id', '=', 'de.department_id')
					->leftJoin('tbl_unit_name as u', 'em.unit_id', '=', 'u.id')
					->where('em.emp_id', '=', $emp_id)
					//->whereNull('r.emp_id')
					//->orWhere('r.effect_date', '>', $form_date)
					->select('em.id','em.emp_id','em.mother_program_id','em.current_program_id','em.current_program_id','em.start_date','e.emp_name_eng','d.department_name','de.department_name as current_department','u.unit_name')
					->orderBy('em.start_date', 'DESC')
					->first();
			//print_r ($all_result); exit;
			if(!empty($all_result)) {
				$data['all_result'] = $all_result;	
				$data['id'] = $all_result->id;	
				$data['value_id'] = 1;	
			} else {
				$data['value_id'] = 2;
			}		
		}
		return view('admin.pages.emp_mapping.emp_mapping_form',$data);
    }

	public function store(Request $request)
    {
		$data = request()->except(['_token','_method','id']);
		$id = $request->input('id');
		//print_r ($data); exit;
		DB::table('tbl_emp_mapping')->insert($data);
		$end_date = date('Y-m-d', strtotime($data['start_date'] . ' -1 day'));
		DB::table('tbl_emp_mapping')->where('id', $id)->update(['end_date' => $end_date]);
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/emp-mapping');			

    }
	
	public function MappingEmpView($emp_id,$id)
    {
        $data['all_result'] = DB::table('tbl_emp_mapping as em')
					->leftJoin('tbl_emp_basic_info as e', 'em.emp_id', '=', 'e.emp_id')
					->leftJoin('tbl_department as d', 'em.mother_department_id', '=', 'd.department_id')
					->leftJoin('tbl_department as de', 'em.current_department_id', '=', 'de.department_id')
					->leftJoin('tbl_unit_name as u', 'em.unit_id', '=', 'u.id')
					->where('em.emp_id', '=', $emp_id)
					->where('em.id', '=', $id)
					->select('em.id','em.emp_id','em.mother_program_id','em.current_program_id','em.current_program_id','em.start_date','e.emp_name_eng','d.department_name','de.department_name as current_department','u.unit_name')
					//->orderBy('em.id', 'DESC')
					->first();
		$data['mapping_info'] = DB::table('tbl_emp_mapping as em')
					->leftJoin('tbl_emp_basic_info as e', 'em.emp_id', '=', 'e.emp_id')
					->leftJoin('tbl_department as d', 'em.mother_department_id', '=', 'd.department_id')
					->leftJoin('tbl_department as de', 'em.current_department_id', '=', 'de.department_id')
					->leftJoin('tbl_unit_name as u', 'em.unit_id', '=', 'u.id')
					->where('em.emp_id', '=', $emp_id)
					->select('em.id','em.emp_id','em.mother_program_id','em.current_program_id','em.current_program_id','em.start_date','e.emp_name_eng','d.department_name','de.department_name as current_department','u.unit_name')
					->orderBy('em.id', 'DESC')
					->get();
		return view('admin.pages.emp_mapping.emp_mapping_view',$data);
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
