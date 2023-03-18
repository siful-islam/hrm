<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class CovidNineteenController extends Controller
{
	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data['all_result'] = DB::table('tbl_covid_nineteen as cn')							
							->leftJoin('tbl_emp_basic_info as e', function($join)
									{
										$join->on('cn.emp_id', '=', 'e.emp_id')
										->where('cn.emp_type', '=', 1);

									})
							->leftJoin('tbl_emp_non_id as en', function($join)
									{
										$join->on('cn.emp_id', '=', 'en.sacmo_id')
										->on('cn.emp_type', '=', 'en.emp_type_code');

									})
							->leftJoin('tbl_branch as b', 'cn.br_code', '=', 'b.br_code')
							->leftJoin('tbl_designation as d', 'cn.designation_code', '=', 'd.designation_code')
							->Leftjoin('tbl_emp_type as et', 'cn.emp_type', '=', 'et.id')
							->select('cn.id','cn.emp_id','cn.entry_date','cn.emp_type','cn.comments','e.emp_name_eng','d.designation_name','b.branch_name','en.sacmo_id','en.emp_name','et.type_name')
							->orderBy('cn.id', 'desc')
							->get();
		//print_r($data['all_result']);
		return view('admin.pages.covid_nineteen.covid_nineteen_list',$data);			
    }

    public function create()
    {
		$data = array();
		$data['action'] 		= '/covid-nineteen';
		$data['method'] 		= 'post';
		$data['method_field'] 	= '';
		$data['id'] 			= '';
		
		$data['emp_type'] = 1; $data['emp_id'] = '';  $data['emp_name'] = ''; $data['entry_date'] = date("Y-m-d"); 
		$data['br_code'] = ''; $data['designation_code'] = ''; $data['comments'] = '';
		$data['nonid_emp_id'] 	= ''; 
		//
		$data['button_text'] = 'Save';
		//
		$data['all_emp_type'] = DB::table('tbl_emp_type')
								->get();
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->get();
		
		return view('admin.pages.covid_nineteen.covid_nineteen_form',$data);	

    }

	public function store(Request $request)
    {
		$data = request()->except(['_token','_method']);
		//print_r ($data); exit;

		$data['created_by'] = Session::get('admin_id');
		DB::table('tbl_covid_nineteen')->insert($data);
		//print_r ($data); exit;
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/covid-nineteen');			

    }
	
	public function CovidNineteenView($emp_id,$id)
    {
        $data = array();
		$data['result_info'] = DB::table('tbl_covid_nineteen as cn')
						->leftJoin('tbl_emp_basic_info as e', function($join)
										{
											$join->on('cn.emp_id', '=', 'e.emp_id')
											->where('cn.emp_type', '=', 1);

										})
						->leftJoin('tbl_emp_non_id as en', function($join)
										{
											$join->on('cn.emp_id', '=', 'en.sacmo_id')
											->on('cn.emp_type', '=', 'en.emp_type_code');

										})				
						->Leftjoin('tbl_designation as d', 'cn.designation_code', '=', 'd.designation_code')				
						->Leftjoin('tbl_branch as b', 'cn.br_code', '=', 'b.br_code')				
						->Leftjoin('tbl_emp_type as et', 'cn.emp_type', '=', 'et.id')				
						->where('cn.emp_id', $emp_id)
						->where('cn.id', $id)
						->select('cn.id','cn.emp_id','cn.emp_type','cn.entry_date','cn.comments','e.emp_name_eng','en.sacmo_id','en.emp_name','d.designation_name','b.branch_name','et.type_name')
						->first();
		
		//
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->get();
		return view('admin.pages.covid_nineteen.covid_nineteen_view',$data);
    }
	
	public function edit($id)
    {
		
		$data = array();
		$data['title'] = 'Covid-19';
		$result_info = DB::table('tbl_covid_nineteen as cn')
						->leftJoin('tbl_emp_basic_info as e', function($join)
										{
											$join->on('cn.emp_id', '=', 'e.emp_id')
											->where('cn.emp_type', '=', 1);

										})
						->leftJoin('tbl_emp_non_id as en', function($join)
										{
											$join->on('cn.emp_id', '=', 'en.sacmo_id')
											->on('cn.emp_type', '=', 'en.emp_type_code');

										})				
						->Leftjoin('tbl_designation as d', 'cn.designation_code', '=', 'd.designation_code')				
						->Leftjoin('tbl_branch as b', 'cn.br_code', '=', 'b.br_code')				
						->Leftjoin('tbl_emp_type as et', 'cn.emp_type', '=', 'et.id')
						->where('cn.id', $id)
						->select('cn.id','cn.emp_id','cn.emp_type','cn.entry_date','cn.designation_code','cn.br_code','cn.comments','e.emp_name_eng','en.sacmo_id','en.emp_name','d.designation_name','b.branch_name','et.type_name')
						->first();
		$data['emp_type'] 		= $result_info->emp_type;
		$data['emp_id'] 		= $result_info->emp_id;
		$data['entry_date'] 		= $result_info->entry_date;
		
		$data['emp_name'] = ($result_info->emp_type == 1 ? $result_info->emp_name_eng : $result_info->emp_name);
		$data['designation_code'] 		= $result_info->designation_code;
		$data['br_code'] 		= $result_info->br_code;
		$data['comments'] 		= $result_info->comments;
		$data['button_text'] 	= 'Update';
		//print_r ($training_info);

		$data['action'] 				= '/covid-nineteen/'.$id;
		$data['method'] 				= 'post';
		$data['method_field'] 			= '<input name="_method" value="PATCH" type="hidden">';
		$data['id'] 					= $id;
		
		//
		$data['all_emp_type'] = DB::table('tbl_emp_type')->get();
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->get();
		return view('admin.pages.covid_nineteen.covid_nineteen_form',$data);	
    }
	
	public function update(Request $request, $id)
    {
        $data = request()->except(['_token','_method']);		
		//print_r ($data); exit;		
		DB::table('tbl_covid_nineteen')->where('id', $id)->update($data);
		Session::put('message','Data Update Successfully');
		return Redirect::to('/covid-nineteen');

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
