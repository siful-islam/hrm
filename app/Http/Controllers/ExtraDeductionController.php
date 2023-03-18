<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class ExtraDeductionController extends Controller
{
	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data['all_result'] = DB::table('tbl_extra_deduction as ed')
							->leftJoin('tbl_emp_basic_info as e', 'ed.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_branch as b', 'ed.br_code', '=', 'b.br_code')
							->leftJoin('tbl_designation as d', 'ed.designation_code', '=', 'd.designation_code')
							->select('ed.incre_id','ed.emp_id','ed.entry_date','ed.type_id','ed.emp_type','ed.total_amount','ed.comments','e.emp_name_eng','d.designation_name','b.branch_name')
							->groupBy('ed.incre_id')
							->get();
		return view('admin.pages.extra_deduction.extra_deduction_list',$data);			
    }

    public function create()
    {
		// SAVE = 2 
		/* $action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		} */
		//
		$data = array();
		$data['action'] 		= '/extra_deduction';
		$data['method'] 		= 'post';
		$data['method_field'] 	= '';
		$data['id'] 			= '';
		
		$data['emp_id'] = ''; $data['entry_date'] = ''; $data['emp_name'] = ''; $data['br_code'] = ''; 
		$data['designation_code'] = ''; $data['type_id'] = ''; $data['total_amount'] = '';
		$data['from_month_year'] = ''; $data['to_month_year'] = ''; $data['comments'] = '';
		$data['emp_type'] = ''; 	$data['nonid_emp_id'] 	= '';
		//
		$data['Heading'] 	 = 'Add Assign';
		$data['button_text'] = 'Save';
		//
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->get();
		$data['all_deduc_type'] 		    = DB::table('tbl_ext_deduc_config')->where('status',1)->get();
		
		return view('admin.pages.extra_deduction.extra_deduction_form',$data);	

    }
	
	public function GetEmpInfo($emp_id)
	{
		$data = array();
		
		$max_id = DB::table('tbl_master_tra')
					->where('emp_id', $emp_id)
					->max('sarok_no');	
		//echo $max_id;		
		if($max_id !=NULL) {
			$employee_info = DB::table('tbl_master_tra as m')
						->Leftjoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->where('m.sarok_no', $max_id)
						->select('m.emp_id','m.designation_code','m.br_code','e.emp_name_eng') 
						->first();	

			$data['emp_id'] 				= $emp_id;
			$data['emp_name'] 				= $employee_info->emp_name_eng;
			$data['designation_code'] 		= $employee_info->designation_code;
			$data['br_code'] 				= $employee_info->br_code;
			$data['error'] 					= '';
		
		} else {
			$data['error'] 					= 1;
		}
		
		return $data;
	}

	public function store(Request $request)
    {
		$data = request()->except(['_token','_method','search_dates']);
		//print_r ($data); exit;
		$search_dates = $request->input('search_dates');
		$search_date = explode(",",$search_dates);
		$no_of_month = count($search_date);
		//$data['month_year'] = $search_date;
		$data['monthly_pay'] = intval($data['total_amount']/$no_of_month);
		$month_amt = $data['monthly_pay'] * $no_of_month;
		$last_month_amt = $data['total_amount'] - $month_amt;
		$incre_id = DB::table('tbl_extra_deduction')->max('incre_id');
		$data['incre_id'] = $incre_id+1;
		$i = 1;
		foreach ($search_date as $val) {
			if($i == $no_of_month) { 
			$data['monthly_pay'] = $data['monthly_pay'] + $last_month_amt;
			}
			$data['month_year'] = $val;
			$data['created_by'] = Session::get('admin_id');
			DB::table('tbl_extra_deduction')->insert($data);
			$i++;
		}
		
		//print_r ($data); exit;
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/extra_deduction');			

    }

    public function edit($id)
    {
		//UPDATE = 3;
		/* $action_id = 3;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		} */
		$data = array();
		$result_info = DB::table('tbl_extra_deduction as ed')
						->leftJoin('tbl_emp_basic_info as e', 'ed.emp_id', '=', 'e.emp_id')
						->where('ed.incre_id', $id)
						->select('ed.emp_id','ed.emp_type','ed.entry_date','ed.designation_code','ed.br_code','ed.type_id','ed.total_amount','ed.comments','e.emp_name_eng',DB::raw('min(ed.month_year) as min_month'),DB::raw('max(ed.month_year) as max_month'))
						->first();
		//print_r($result_info);
		$data['id'] 				= $id;
		$data['emp_id'] 			= $result_info->emp_id;
		$data['emp_name'] 			= $result_info->emp_name_eng;		
		$data['emp_type'] 			= $result_info->emp_type;
		$data['entry_date'] 		= $result_info->entry_date;
		$data['type_id'] 			= $result_info->type_id;		
		$data['designation_code'] 	= $result_info->designation_code;
		$data['br_code'] 			= $result_info->br_code;
		$data['total_amount'] 		= $result_info->total_amount;
		$data['from_month_year'] 	= date('Y-m',strtotime($result_info->min_month));
		$data['to_month_year'] 		= date('Y-m',strtotime($result_info->max_month));
		$data['comments'] 			= $result_info->comments;
		$data['button_text'] 		= 'Update';
		//print_r ($training_info);

		$data['action'] 			= '/extra_deduction/'.$id;
		$data['method'] 			= 'post';
		$data['method_field'] 		= '<input name="_method" value="PATCH" type="hidden">';
		$data['id'] 				= $id;		
		//
		$data['all_branch'] 	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] = DB::table('tbl_designation')->get();
		$data['all_deduc_type'] = DB::table('tbl_ext_deduc_config')->where('status',1)->get();
		
		return view('admin.pages.extra_deduction.extra_deduction_form',$data);	
    }
	
    public function show($id)
    {
        $data['assign_info'] = DB::table('tbl_emp_assign as ea')
						->leftJoin('tbl_emp_basic_info as e', 'ea.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_designation as d', 'ea.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'ea.br_code', '=', 'b.br_code')
						->where('ea.id', $id)
						->select('ea.*','e.emp_name_eng','d.designation_name','b.branch_name')
						->first();
		//print_r ($data['assign_info']);
		return view('admin.pages.extra_deduction.extra_deduction_view',$data);
    }
	
	public function update(Request $request, $id)
    {
        $data = request()->except(['_token','_method','search_dates']);
		$search_dates = $request->input('search_dates');
		$search_date = explode(",",$search_dates);
		$no_of_month = count($search_date);
		//print_r ($data); exit;
		//$data['month_year'] = $search_date;
		$data['monthly_pay'] = intval($data['total_amount']/$no_of_month);
		//$fraction_amt = explode('.', $data['monthly_pay']);
		//print_r($data['monthly_pay']); //exit;
		$month_amt = $data['monthly_pay'] * $no_of_month;
		$last_month_amt = $data['total_amount'] - $month_amt; //exit;
		DB::table('tbl_extra_deduction')->where('incre_id',$id)->delete();
		$data['incre_id'] = $id;
		$i = 1;
		foreach ($search_date as $val) {
			if($i == $no_of_month) { 
			$data['monthly_pay'] = $data['monthly_pay'] + $last_month_amt;
			}
			$data['month_year'] = $val;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$data['updated_by'] = Session::get('admin_id');
			DB::table('tbl_extra_deduction')->insert($data);
			$i++;
		}
		
		
		Session::put('message','Data Update Successfully');
		return Redirect::to('/extra_deduction');

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
