<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\NonId;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class NonIdbranchController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	public function index()
    {        	
		$data = array();
		$br_code 					= Session::get('branch_code');
		$data['results'] =DB::table('tbl_emp_non_id')  
							  ->leftjoin('tbl_nonid_official_info',function($join){
												$join->on("tbl_emp_non_id.emp_id","=","tbl_nonid_official_info.emp_id")
													->where('tbl_nonid_official_info.sarok_no',DB::raw("(SELECT 
																				  max(tbl_nonid_official_info.sarok_no)
																				  FROM tbl_nonid_official_info 
																				   where tbl_emp_non_id.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
																				  max(t.joining_date)
																				  FROM tbl_nonid_official_info as t 
																				   where tbl_emp_non_id.emp_id = t.emp_id)
																				  )") 		 
															); 
														})	
							  ->leftjoin('tbl_nonid_salary',function($join){
												$join->on("tbl_emp_non_id.emp_id","=","tbl_nonid_salary.emp_id")
												->where('tbl_nonid_salary.effect_date',DB::raw("(SELECT 
																				  max(tbl_nonid_salary.effect_date)
																				  FROM tbl_nonid_salary 
																				   where tbl_emp_non_id.emp_id = tbl_nonid_salary.emp_id
																				  )") 		 
															); 
														})					  
							->leftjoin('tbl_nonid_transfer',function($join){
												$join->on("tbl_nonid_transfer.emp_id","=","tbl_emp_non_id.emp_id")
												->where('tbl_nonid_transfer.effect_date',DB::raw("(SELECT 
																				  max(tbl_nonid_transfer.effect_date)
																				  FROM tbl_nonid_transfer 
																				   where tbl_emp_non_id.emp_id = tbl_nonid_transfer.emp_id
																				  )") 		 
															); 
														})	 
							->leftjoin('tbl_emp_type as et',function($join){
												$join->on('et.id', "=","tbl_emp_non_id.emp_type_code"); 
											})	   
							->leftjoin('tbl_branch as br_o', 'br_o.br_code', '=', 'tbl_nonid_official_info.br_code' )
							->leftjoin('tbl_branch as br_t', 'br_t.br_code', '=', 'tbl_nonid_transfer.to_branch_code' )
							->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_emp_non_id.emp_id' )
							->where('tbl_nonid_official_info.br_code', $br_code) 
							->where('tbl_emp_non_id.for_which', 2) 
							->orderBy('tbl_emp_non_id.id', 'desc') 
							->select('tbl_emp_non_id.id','tbl_emp_non_id.emp_id','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.emp_type','tbl_emp_non_id.emp_name','tbl_emp_non_id.joining_date','br_o.branch_name as branch_name_o','br_t.branch_name as branch_name_t','tbl_emp_non_id.contact_num','tbl_nonid_official_info.next_renew_date','tbl_emp_non_id_cancel.cancel_date','tbl_nonid_salary.console_salary','et.type_name') 
							//->offset($start)
							//->limit($limit)  
							->get();
		/* echo '<pre>';
		print_r($data['results']);
		exit; */
		
		return view('admin.branch_employee.manage_non_id_br',$data);					
    }
	
	
	public function create()
    {
		/* $action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id); */
		/* echo '<pre>';
		print_r($get_permission);
		exit; */
		/* if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		} */
		$data = array();
		$data['id'] 					= '';
		$data['emp_id'] 				= ''; 
		$data['emp_name'] 				= '';
		$data['father_name'] 			= '';
		$data['mother_name'] 			= '';
		$data['birth_date'] 			= ''; 	
		$data['nationality'] 			= 'Bangladeshi';
		$data['religion'] 				= '';
		$data['contact_num']			= '';
		$data['email'] 					= '';
		$data['birth_certificate'] 		= '';
		$data['national_id'] 			= '';
		$data['gender'] 				= 'male';
		$data['blood_group'] 			= '';
		$data['joining_date'] 			= date('Y-m-d'); 
		$data['present_add'] 			= '';
		$data['vill_road'] 				= '';
		$data['post_office'] 			= '';
		$data['district_code'] 			= '';
		$data['thana_code'] 			= '';
		$data['permanent_add'] 			= ''; 
		
		$data['gross_salary'] 			= '';
		$data['console_salary'] 		= '';
		$data['emp_type'] 				= '';
		$data['sacmo_id'] 				= '';
		
		$data['org_code'] 				= '181';
		//
		$data['action'] 			= '/bra_contractual';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ''; 		
		$data['Heading'] 			= 'Add Contractual Employee';
		$data['button_text'] 		= 'Save';		
		//		
		$data['all_emp_type'] 		= DB::table('tbl_emp_type')->where('for_which',2)->where('status',1)->get();
		$data['branches'] 		    = DB::table('tbl_branch')->where('status',1)->orderBy('branch_name','asc')->get();
		$data['designation'] 		= DB::table('tbl_designation')->where('status',1)->orderBy('designation_name','asc')->get();		
		//
		
		return view('admin.branch_employee.non_id_branch_form',$data);	
    }	
	public function edit($id)
	{
		/* $action_id = 3;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		} */

		$data = array();
			$result = 	NonId::leftjoin('tbl_nonid_official_info', 'tbl_nonid_official_info.emp_id', '=', 'tbl_emp_non_id.emp_id' )
								->leftjoin('tbl_nonid_salary', 'tbl_nonid_salary.emp_id', '=', 'tbl_emp_non_id.emp_id' )
								->select('tbl_nonid_official_info.after_trai_br_code','tbl_emp_non_id.blood_group','tbl_emp_non_id.present_add','tbl_emp_non_id.vill_road','tbl_emp_non_id.post_office','tbl_emp_non_id.district_code','tbl_emp_non_id.thana_code','tbl_emp_non_id.permanent_add','tbl_emp_non_id.last_education','tbl_emp_non_id.referrence_name','tbl_emp_non_id.reference_phone','tbl_emp_non_id.nec_phone_num','tbl_nonid_official_info.br_code','tbl_nonid_official_info.designation_code','tbl_nonid_official_info.c_end_date','tbl_nonid_official_info.end_type','tbl_nonid_official_info.after_trai_join_date','tbl_emp_non_id.emp_id','tbl_emp_non_id.father_name','tbl_emp_non_id.mother_name','tbl_emp_non_id.birth_date','tbl_emp_non_id.nationality','tbl_emp_non_id.religion','tbl_emp_non_id.email','tbl_emp_non_id.national_id','tbl_emp_non_id.birth_certificate','tbl_emp_non_id.maritial_status','tbl_emp_non_id.gender','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.emp_type_code','tbl_emp_non_id.emp_name','tbl_nonid_official_info.joining_date','tbl_nonid_official_info.br_join_date','tbl_emp_non_id.contact_num','tbl_nonid_official_info.next_renew_date','tbl_nonid_salary.basic_salary','tbl_nonid_salary.plus_item_id','tbl_nonid_salary.item_plus_amt','tbl_nonid_salary.is_Consolidated','tbl_nonid_salary.gross_salary','tbl_nonid_official_info.salary_br_code','tbl_nonid_official_info.designation_code','tbl_nonid_salary.effect_date','tbl_nonid_salary.console_salary')
								->where('tbl_emp_non_id.id',$id)
								->first(); 
		$data['id'] 					= $result->id;
		$data['emp_id'] 				= $result->emp_id;
		$data['emp_type'] 				= $result->emp_type_code;
		$data['sacmo_id'] 				= $result->sacmo_id;
		$data['pre_emp_id'] 			= $result->pre_emp_id;
		$data['emp_name'] 				= $result->emp_name;
		$data['father_name'] 			= $result->father_name;
		$data['mother_name'] 			= $result->mother_name;
		$data['birth_date'] 			= $result->birth_date;
		$data['nationality'] 			= $result->nationality;
		$data['religion'] 				= $result->religion;
		$data['contact_num']			= $result->contact_num; 
		$data['national_id'] 			= $result->national_id; 
		$data['birth_certificate'] 		= $result->birth_certificate; 
		$data['gender'] 				= $result->gender; 
		$data['joining_date'] 			= $result->joining_date; 
		$data['present_add'] 			= $result->present_add;  
		$data['permanent_add'] 			= $result->permanent_add;  
		//salary   
		   
		$data['console_salary']			= $result->console_salary;
		$data['action'] 				= "/bra_contractual/$id";
		$data['method'] 				= 'POST';
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 		
		$data['Heading'] 				= 'Edit Contractual Employee';
		$data['button_text'] 			= 'Update';  
	 
		$data['all_emp_type'] 			= DB::table('tbl_emp_type')->where('for_which',2)->where('status',1)->get();
		$data['branches'] 		   		= DB::table('tbl_branch')->where('status',1)->orderBy('branch_name','asc')->get();
		$data['designation'] 			= DB::table('tbl_designation')->where('status',1)->orderBy('designation_name','asc')->get();	
		//
		 
		return view('admin.branch_employee.non_id_branch_form_edit',$data);	
	}
	
	
	public function validation($emp_id)
	{
		$info = DB::table('tbl_emp_non_id')
							->where('tbl_emp_non_id.emp_id', $emp_id)
							->select('tbl_emp_non_id.emp_id')
							->first();	
		if($info)
		{
			$status = 1;
		}
		else
		{
			$status = 0;
		}	
		return	$status; 	
	}
	
	public function store(Request $request)
    {
		$data 			= array();
		$odata 			= array();
		$sdata 			= array(); 
		$data['emp_type'] 			= $emp_type = $request->emp_type;
		
		//$br_code 					= $request->br_code;
		$br_code 					= Session::get('branch_code');
		
		$data['emp_type_code'] 		= $request->emp_type;
		$data['emp_name'] 			= $request->emp_name; 
		$data['mother_name'] 		= $request->mother_name;
		$data['father_name'] 		= $request->father_name;
		$data['birth_date'] 		= $request->birth_date;
		$data['gender'] 			= $request->gender;
		$data['nationality'] 		= $request->nationality;
		$data['religion'] 			= $request->religion;
		$data['contact_num'] 		= $request->contact_num;
		$data['national_id'] 		= $request->national_id;
		$data['joining_date'] 		= $request->joining_date; 
		$data['permanent_add']		= $request->permanent_add;
		$data['present_add']		= $request->present_add;
		$data['for_which']			= 2;
		$data['created_by'] 		= Session::get('admin_id');
		$data['org_code'] 		 	= Session::get('admin_org_code'); 
		
		 
		
		$sacmo_id1 = DB::table('tbl_emp_non_id')
						->where('emp_type_code',$emp_type)
						->max('sacmo_id'); 
		$data['sacmo_id'] 	= $sacmo_id 	= $sacmo_id1 + 1;
		 
		$select_emp_id = DB::table('tbl_emp_non_id')
							->max('emp_id');
					
		 $data['emp_id'] 			= $emp_id   = $select_emp_id + 1;
		
		$odata['is_first_entry']	= 1 ;
		$odata['emp_id']			= $emp_id;
		if($emp_type == 9){
			$odata['designation_code']	= 242; // sisok teacher
		}else if($emp_type == 5){
			$odata['designation_code']	= 74; // cook
		}
		
		$odata['salary_br_code'] 	= $br_code; 
		$odata['br_code'] 			= $br_code;
		$odata['joining_date'] 		= $request->joining_date;
		$odata['br_join_date'] 		= $request->joining_date;
		$odata['end_type'] 			= 0;
		$odata['org_code'] 			= Session::get('admin_org_code');
		$odata['created_by'] 		= Session::get('admin_id');
		$odata['sarok_no'] 			= $this->get_last_nonid_sarok();
		
		
		$sdata['is_first_entry']	= 1;
		$sdata['emp_id']			= $emp_id;
		$sdata['effect_date']		= $request->joining_date;
		$sdata['gross_salary']		= $request->console_salary;
		 
		  
		$sdata['org_code'] 			= Session::get('admin_org_code');
		$sdata['created_by'] 		= Session::get('admin_id');
		$sdata['is_Consolidated'] 	= 2;
		$sdata['console_salary']	= $request->console_salary;   
		$validation_status = $this->validation($emp_id);
		if($validation_status == 1)
		{
			Session::put('message','This Employee Already Exit');
			return Redirect::to('/bra_contractual/create');
		}
		  
		DB::beginTransaction();
		try {				
			DB::table('tbl_emp_non_id')->insert($data);
			DB::table('tbl_nonid_official_info')->insert($odata);
			DB::table('tbl_nonid_salary')->insert($sdata);
			DB::commit();
			Session::put('message1',$sacmo_id);
		}catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		} 
		return Redirect::to('/bra_contractual');
    } 
	public function get_last_nonid_sarok()
	{
		$result = DB::table('tbl_nonid_official_info') 
				  ->max('sarok_no');
		return $result+1;
	}	
	public function update(Request $request, $id)
    {			 
		$data = array();
		$odata = array();
		$sdata = array();
		$plus_item_id 	= array();
		$item_plus_amt 	= array(); 		
		$emp_type 					= $request->emp_type; 
		$emp_id 					= $request->emp_id; 
		$data['emp_name'] 			= $request->emp_name; 
		$data['mother_name'] 		= $request->mother_name;
		$data['father_name'] 		= $request->father_name;
		$data['birth_date'] 		= $request->birth_date;
		$data['gender'] 			= $request->gender; 
		$data['nationality'] 		= $request->nationality;
		$data['religion'] 			= $request->religion;
		$data['contact_num'] 		= $request->contact_num;
		$data['birth_certificate'] 	= $request->birth_certificate;
		$data['national_id'] 		= $request->national_id; 
		$data['permanent_add']		= $request->permanent_add;
		$data['present_add']		= $request->present_add;
		$data['joining_date']		= $request->joining_date;
		// official info 
		$odata['joining_date']		= $request->joining_date;
		$odata['br_join_date']		= $request->joining_date;
		$odata['updated_at'] 		= date('Y-m-d');
		$odata['updated_by'] 		= Session::get('admin_id');
		
		// salary 
		
		$sdata['effect_date']		= $request->joining_date;
		$sdata['gross_salary']		= $request->console_salary;
		$sdata['console_salary']	= $request->console_salary;
		$sdata['updated_at'] 		= date('Y-m-d');
		$sdata['updated_by'] 		= Session::get('admin_id');
		 
		/* echo '<pre>';
		print_r($sdata);
		exit; */  
		DB::beginTransaction();
		try{				
			DB::table('tbl_emp_non_id')
				->where('id', $id)
				->update($data);
		 	DB::table('tbl_nonid_official_info')
				->where('emp_id', $emp_id)
				->update($odata);
			DB::table('tbl_nonid_salary')
				->where('emp_id', $emp_id)
				->update($sdata);  
			DB::commit();
			Session::put('message','Data Updated Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Updated Data');
			DB::rollback();
		}
		//exit;
		return Redirect::to('/bra_contractual');
    }
	
	public function bra_view_non_id($id)
	{
		/*
		$action_id = 3;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		*/
		
		$data = array(); 
		 $result = 	NonId::leftjoin('tbl_nonid_official_info as nmax',function($join){
												$join->on("tbl_emp_non_id.emp_id","=","nmax.emp_id")
													->where('nmax.joining_date',DB::raw("(SELECT 
																				  max(tbl_nonid_official_info.joining_date)
																				  FROM tbl_nonid_official_info 
																				   where tbl_emp_non_id.emp_id = tbl_nonid_official_info.emp_id
																				  )") 		 
															); 
														})
					->leftjoin('tbl_nonid_official_info as nmin',function($join){
												$join->on("tbl_emp_non_id.emp_id","=","nmin.emp_id")
													->where('nmin.joining_date',DB::raw("(SELECT 
																				  min(tbl_nonid_official_info.joining_date)
																				  FROM tbl_nonid_official_info 
																				   where tbl_emp_non_id.emp_id = tbl_nonid_official_info.emp_id
																				  )") 		 
															); 
														})	
							  ->leftjoin('tbl_nonid_salary',function($join){
												$join->on("tbl_emp_non_id.emp_id","=","tbl_nonid_salary.emp_id")
												->where('tbl_nonid_salary.effect_date',DB::raw("(SELECT 
																				  max(tbl_nonid_salary.effect_date)
																				  FROM tbl_nonid_salary 
																				   where tbl_emp_non_id.emp_id = tbl_nonid_salary.emp_id
																				  )") 		 
															); 
														})
					->leftjoin('tbl_emp_type as et',function($join){
												$join->on('et.id', "=","tbl_emp_non_id.emp_type_code"); 
											})	 
					->select('nmin.br_code as join_br_code','nmin.after_trai_br_code','tbl_emp_non_id.blood_group','tbl_emp_non_id.present_add','tbl_emp_non_id.vill_road','tbl_emp_non_id.post_office','tbl_emp_non_id.district_code','tbl_emp_non_id.thana_code','tbl_emp_non_id.permanent_add','tbl_emp_non_id.last_education','tbl_emp_non_id.referrence_name','tbl_emp_non_id.reference_phone','tbl_emp_non_id.nec_phone_num','nmax.br_code','nmax.designation_code','nmax.c_end_date','nmax.end_type','nmin.after_trai_join_date','tbl_emp_non_id.emp_id','tbl_emp_non_id.father_name','tbl_emp_non_id.mother_name','tbl_emp_non_id.birth_date','tbl_emp_non_id.nationality','tbl_emp_non_id.religion','tbl_emp_non_id.email','tbl_emp_non_id.national_id','tbl_emp_non_id.birth_certificate','tbl_emp_non_id.maritial_status','tbl_emp_non_id.gender','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.emp_type','tbl_emp_non_id.emp_name','nmin.joining_date','tbl_emp_non_id.contact_num','nmax.next_renew_date','tbl_nonid_salary.basic_salary','tbl_nonid_salary.plus_item_id','tbl_nonid_salary.item_plus_amt','tbl_nonid_salary.gross_salary','tbl_nonid_salary.nara_tion','nmax.salary_br_code','nmax.designation_code','tbl_nonid_salary.effect_date','tbl_nonid_salary.console_salary','et.type_name','tbl_nonid_salary.is_Consolidated')
					->where('tbl_emp_non_id.id',$id)
					->first();
		
		//$result = NonId::find($id);

		$data['id'] 					= $result->id;
		$data['emp_id'] 				= $result->emp_id;
		$data['emp_name'] 				= $result->emp_name;
		$data['father_name'] 			= $result->father_name;
		$data['mother_name'] 			= $result->mother_name;
		$data['birth_date'] 			= $result->birth_date;
		$data['nationality'] 			= $result->nationality;
		$data['religion'] 				= $result->religion;
		$data['contact_num']			= $result->contact_num;
		$data['national_id'] 			= $result->national_id;
		$data['birth_certificate'] 		= $result->birth_certificate;
		$data['gender'] 				= $result->gender;
		$data['joining_date'] 			= $result->joining_date;
		$data['present_add'] 			= $result->present_add;
		$data['permanent_add'] 			= $result->permanent_add;
		$data['br_code'] 				= $result->br_code;
		$data['designation_code'] 		= $result->designation_code;
		$data['type_name'] 				= $result->type_name;
		$data['console_salary']  	   = $result->console_salary;
		
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />";
		$data['Heading'] 				= 'View Contractual Employee';
		//	
		$data['branches'] 		   		= DB::table('tbl_branch')->where('status',1)->orderBy('branch_name','asc')->get();
		$data['designation'] 			= DB::table('tbl_designation')->where('status',1)->orderBy('designation_name','asc')->get();	
		//
		return view('admin.branch_employee.non_id_branch_view',$data);	
	}
	
	
	public function all_data(Request $request)
    {       
		$columns = array( 
			0 =>'tbl_emp_non_id.id', 
			1 =>'tbl_emp_non_id.sacmo_id',
			2 =>'tbl_emp_non_id.emp_type',
			3=> 'tbl_emp_non_id.joining_date',
			4=> 'tbl_emp_non_id.emp_name',
			5=> 'tbl_emp_non_id.father_name',
			6=> 'tbl_nonid_official_info.designation_code',
			7=> 'tbl_nonid_salary.basic_salary',
			8=> 'tbl_nonid_salary.gross_salary',
		);
  
        $totalData 		= NonId::count();
        $totalFiltered  = $totalData; 
        $limit 			= $request->input('length');
        $start 			= $request->input('start');
        $order 			= $columns[$request->input('order.0.column')];
        $dir 			= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $results = NonId::leftjoin('tbl_nonid_official_info', 'tbl_nonid_official_info.emp_id', '=', 'tbl_emp_non_id.emp_id' )
							->leftjoin('tbl_nonid_salary', 'tbl_nonid_salary.emp_id', '=', 'tbl_emp_non_id.emp_id' )
							->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_nonid_official_info.br_code' )
							->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_emp_non_id.emp_id' )
							->select('tbl_emp_non_id.id','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.emp_type','tbl_emp_non_id.emp_name','tbl_nonid_official_info.joining_date','tbl_branch.branch_name','tbl_nonid_salary.gross_salary','tbl_emp_non_id.contact_num','tbl_nonid_official_info.next_renew_date','tbl_emp_non_id_cancel.cancel_date')
							->offset($start)
							->limit($limit)
							->orderBy('tbl_emp_non_id.sacmo_id', 'desc')
							->get();
        }
		
		else 
		{
            $search = $request->input('search.value'); 
            $results =  NonId::leftjoin('tbl_nonid_official_info', 'tbl_nonid_official_info.emp_id', '=', 'tbl_emp_non_id.emp_id' )
							->leftjoin('tbl_nonid_salary', 'tbl_nonid_salary.emp_id', '=', 'tbl_emp_non_id.emp_id' ) 
							->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_nonid_official_info.br_code' )
							->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_emp_non_id.emp_id' )
							->select('tbl_emp_non_id.id','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.emp_type','tbl_emp_non_id.emp_name','tbl_nonid_official_info.joining_date','tbl_branch.branch_name','tbl_nonid_salary.gross_salary','tbl_emp_non_id.contact_num','tbl_nonid_official_info.next_renew_date','tbl_emp_non_id_cancel.cancel_date')
							->where('tbl_emp_non_id.sacmo_id','LIKE',"%{$search}%")
							->orWhere('tbl_emp_non_id.emp_type', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
							->orderBy('tbl_emp_non_id.sacmo_id', 'desc')
                            ->get();
            $totalFiltered = NonId::where('tbl_emp_non_id.sacmo_id','LIKE', "%{$search}%")->orWhere('tbl_emp_non_id.emp_type', 'LIKE',"%{$search}%")
                            ->count();
        }
       

        $data = array();
        if(!empty($results))
        {
            $i=1;
            foreach ($results as $result)
            {
				if($result->cancel_date == '')
				{
					$status = '<span style="color:green">Active</span>';
					$option = '<a class="btn btn-sm btn-success btn-xs" title="Edit" href="bra_contractual/'.$result->id.'/edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
								<a class="btn btn-sm btn-info btn-xs" title="Edit" href="view-non-id/'.$result->id.'"><i class="fa fa-eye"></i> View</a>';
				}
				else
				{
					$status = '<span style="color:red">Canceled</span>';
					$option = '<a class="btn btn-sm btn-info btn-xs" title="Edit" href="view-non-id/'.$result->id.'"><i class="fa fa-eye"></i> View</a>';
				}
				
				
				if($result->emp_type == 'non_id')
				{
					$type = 'OT';
				}
				elseif($result->emp_type == 'sacmo')
				{
					$type = 'CH';
				}
				elseif($result->emp_type == 'shs')
				{
					$type = 'SHS';
				}

			    $nestedData['id'] 				= $i++;
                $nestedData['sacmo_id'] 		= $result->sacmo_id; 
                $nestedData['emp_type'] 		= $type; 
				$nestedData['emp_name'] 		= $result->emp_name;
                $nestedData['joining_date'] 	= $result->joining_date;    
				$nestedData['br_code'] 			= $result->branch_name;
				$nestedData['gross_salary'] 	= $result->gross_salary;
                $nestedData['contact_num'] 		= $result->contact_num;             
                //$nestedData['next_renew_date'] 	= $result->next_renew_date;                       
                $nestedData['status'] 			= $status;


				
				$nestedData['options'] 			= $option;			
				$data[] = $nestedData;
            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                );
            
        echo json_encode($json_data); 
        
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
	
	function age_calculation($birth_date){
		$date_upto = date('Y-m-d');
		$big_date=date_create($date_upto);
			$small_date=date_create($birth_date);
			$diff=date_diff($big_date,$small_date); 
			printf($diff->format('%y Year %m Month %d Day' ));  
	} 
	function is_contract_check_edit($id,$emp_id){
		$data = array();
		$is_exist_official = 0;
		$is_exist_salary = 0;
		$is_multiple    	= DB::table('tbl_nonid_official_info') 
								->where('emp_id', function ( $query ) use ($emp_id) {
										$query->select('emp_id')->from('tbl_nonid_official_info')->where('emp_id', '=', $emp_id)->groupBy('emp_id')->havingRaw('count(*) > 1');
									}) 
								->select('emp_id')
								->first();
		if($is_multiple){
			$is_exist_official = 1;
		}
		$is_multiple1    	= DB::table('tbl_nonid_official_info')
								 
								->Where('emp_id', function ( $query ) use ($emp_id) {
										$query->select('emp_id')->from('tbl_nonid_salary')->where('emp_id', '=', $emp_id)->groupBy('emp_id')->havingRaw('count(*) > 1');
									})
									->select('emp_id')
									->first();
		if($is_multiple1){
			$is_exist_salary = 1;
		}
		$data['is_exist_official'] = $is_exist_official;
		$data['is_exist_salary'] = $is_exist_salary;
		echo json_encode($data);
		//echo '<pre>';
		//print_r($data); 
		 
		//echo $emp_id;
		
	} 
}
