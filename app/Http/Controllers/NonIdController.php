<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\NonId;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class NonIdController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	 
	public function get_last_nonid_sarok()
	{
		$result = DB::table('tbl_nonid_official_info') 
				  ->max('sarok_no');
		return $result+1;
	}	
	public function index()
    {        	
		$data = array();
		$current_date = date("Y-m-d");
		$data['results'] =DB::table('tbl_emp_non_id')  
							  ->leftjoin('tbl_nonid_official_info',function($join) use($current_date){
												$join->on("tbl_emp_non_id.emp_id","=","tbl_nonid_official_info.emp_id")
													->where('tbl_nonid_official_info.sarok_no',DB::raw("(SELECT 
																				  max(tbl_nonid_official_info.sarok_no)
																				  FROM tbl_nonid_official_info 
																				   where tbl_emp_non_id.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
																				  max(t.joining_date)
																				  FROM tbl_nonid_official_info as t 
																				   where tbl_emp_non_id.emp_id = t.emp_id AND t.joining_date <=  '$current_date')
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
							//->leftjoin('tbl_branch as br_t', 'br_t.br_code', '=', 'tbl_nonid_transfer.to_branch_code' )
							//->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_emp_non_id.emp_id' )
							 ->leftjoin('tbl_emp_non_id_cancel',function($join) use($current_date){
												$join->on("tbl_emp_non_id.emp_id","=","tbl_emp_non_id_cancel.emp_id")
												->where('tbl_emp_non_id_cancel.cancel_date','<=',$current_date); 
														})	
							
							->where('tbl_emp_non_id.for_which', 1) 
							->select('tbl_emp_non_id.id','tbl_emp_non_id.emp_id','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.emp_type','tbl_emp_non_id.emp_name','tbl_emp_non_id.joining_date','br_o.branch_name as branch_name_o','tbl_emp_non_id.contact_num','tbl_emp_non_id.national_id','tbl_nonid_official_info.next_renew_date','tbl_emp_non_id_cancel.cancel_date','tbl_nonid_salary.console_salary','tbl_nonid_salary.gross_salary','et.type_name') 
							//->offset($start)
							//->limit($limit) 
							->orderBy('tbl_emp_non_id.id', 'desc') 
							->get();
		/* echo '<pre>';
		print_r($data['results']);
		exit; */
		
		return view('admin.employee.manage_non_id',$data);					
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
		$data['emp_id'] 				= $this->get_last_emp_id(); 
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
		$data['maritial_status'] 		= 'Married';
		$data['gender'] 				= 'male';
		$data['blood_group'] 			= '';
		$data['joining_date'] 			= date('Y-m-d'); 
		$data['br_join_date'] 			= date('Y-m-d'); 		
		$data['present_add'] 			= '';
		$data['vill_road'] 				= '';
		$data['post_office'] 			= '';
		$data['district_code'] 			= '';
		$data['thana_code'] 			= '';
		$data['permanent_add'] 			= '';
		$data['last_education'] 		= '';
		$data['referrence_name'] 		= '';
		$data['reference_phone'] 		= '';
		$data['nec_phone_num'] 			= '';
		$data['basic_salary'] 			= 0;
		$data['npa_a'] 					= 0;  
		$data['f_allowance'] 			= 0;  
		$data['motor_a'] 				= 0;
		$data['mobile_a'] 				= 0;
		$data['maintenance_a'] 			= 0;
		$data['internet_a'] 			= 0;
		$data['gross_salary'] 			= 0;
		$data['medical_a'] 				= 0;
		$data['field_a'] 				= 0;
		$data['convence_a'] 			= 0;
		$data['house_rent'] 			= 0;
		$data['console_salary'] 		= 0;
		$data['is_Consolidated'] 		= 1;
		$data['salary_br_code'] 		= '';
		$data['br_code'] 				= '';
		$data['designation_code'] 		= '';
		$data['emp_type'] 				= '';
		$data['sacmo_id'] 				= '';
		$data['after_trai_join_date'] 	= '';
		//$data['next_renew_date'] 		= date('Y-m-d',strtotime($data['joining_date'] . "+12 month"));   
		//$data['next_renew_date'] 		= '';   
		$data['effect_date'] 			= date('Y-m-d');
		$data['c_end_date'] 			= '';
		$data['next_renew_date'] 			= '';
		$data['end_type'] 				= 0;
		$data['after_trai_br_code'] 	= '';
		$data['pre_emp_id'] 			= '';
		$data['org_code'] 				= '181';
		//
		$data['action'] 			= '/non-appoinment';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ''; 		
		$data['Heading'] 			= 'Add Non ID';
		$data['button_text'] 		= 'Save';		
		//		
		$data['all_emp_type'] 		= DB::table('tbl_emp_type')->where('for_which',1)->where('id','>',1)->where('status',1)->get();
		$data['branches'] 		    = DB::table('tbl_branch')->where('status',1)->orderBy('branch_name','asc')->get();
		$data['districts'] 		    = DB::table('tbl_district')->where('status',1)->orderBy('district_name','asc')->get();
		$data['thanas'] 		    = DB::table('tbl_thana')->where('status',1)->orderBy('thana_name','asc')->get();
		 
		$data['designation'] 		= DB::table('tbl_designation')->where('status',1)->orderBy('designation_name','asc')->get();		
		//
		
		return view('admin.employee.non_id_form',$data);	
    }	
	
	
	public function get_last_emp_id()
	{
		$result = DB::table('tbl_emp_non_id')
			//->where('join_as',1)
			->max('emp_id');
		return $result+1;
	}	
	
	public function get_non_max($emp_type)
	{
		$result = DB::table('tbl_emp_non_id')
						->where('emp_type_code',$emp_type)
						->max('sacmo_id');
		return $result+1;
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
								->leftjoin('tbl_emp_type', 'tbl_emp_type.id', '=', 'tbl_emp_non_id.emp_type_code')
								->select('tbl_nonid_official_info.after_trai_br_code','tbl_emp_non_id.id','tbl_emp_non_id.blood_group','tbl_emp_non_id.present_add','tbl_emp_non_id.vill_road','tbl_emp_non_id.post_office','tbl_emp_non_id.district_code','tbl_emp_non_id.thana_code','tbl_emp_non_id.permanent_add','tbl_emp_non_id.last_education','tbl_emp_non_id.referrence_name','tbl_emp_non_id.reference_phone','tbl_emp_non_id.nec_phone_num','tbl_nonid_official_info.br_code','tbl_nonid_official_info.designation_code','tbl_nonid_official_info.c_end_date','tbl_nonid_official_info.end_type','tbl_nonid_official_info.after_trai_join_date','tbl_emp_non_id.emp_id','tbl_emp_non_id.father_name','tbl_emp_non_id.mother_name','tbl_emp_non_id.birth_date','tbl_emp_non_id.nationality','tbl_emp_non_id.religion','tbl_emp_non_id.email','tbl_emp_non_id.national_id','tbl_emp_non_id.birth_certificate','tbl_emp_non_id.maritial_status','tbl_emp_non_id.gender','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.emp_type_code','tbl_emp_non_id.emp_name','tbl_nonid_official_info.joining_date','tbl_nonid_official_info.br_join_date','tbl_emp_non_id.contact_num','tbl_nonid_official_info.next_renew_date','tbl_nonid_salary.basic_salary','tbl_nonid_salary.plus_item_id','tbl_nonid_salary.item_plus_amt','tbl_nonid_salary.is_Consolidated','tbl_nonid_salary.gross_salary','tbl_nonid_official_info.salary_br_code','tbl_nonid_official_info.designation_code','tbl_nonid_salary.effect_date','tbl_nonid_salary.console_salary','tbl_emp_type.is_field_reduce')
								->where('tbl_emp_non_id.id',$id)
								->first();
							/* ->select('tbl_emp_non_id.id','tbl_emp_non_id.blood_group','tbl_emp_non_id.present_add','tbl_emp_non_id.vill_road','tbl_emp_non_id.post_office','tbl_emp_non_id.district_code','tbl_emp_non_id.thana_code','tbl_emp_non_id.permanent_add','tbl_emp_non_id.last_education','tbl_emp_non_id.referrence_name','tbl_emp_non_id.nec_phone_num','tbl_nonid_salary.basic_salary','tbl_nonid_salary.npa_a','tbl_nonid_salary.motor_a','tbl_nonid_salary.mobile_a','tbl_nonid_salary.medical_a','tbl_nonid_salary.field_a','tbl_nonid_salary.convence_a','tbl_nonid_salary.house_rent','tbl_nonid_salary.gross_salary','tbl_nonid_official_info.br_code','tbl_nonid_official_info.designation_code','tbl_nonid_salary.effect_date','tbl_nonid_official_info.c_end_date','tbl_nonid_official_info.after_trai_join_date','tbl_emp_non_id.emp_id','tbl_emp_non_id.father_name','tbl_emp_non_id.mother_name','tbl_emp_non_id.birth_date','tbl_emp_non_id.nationality','tbl_emp_non_id.religion','tbl_emp_non_id.email','tbl_emp_non_id.national_id','tbl_emp_non_id.maritial_status','tbl_emp_non_id.gender','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.emp_type','tbl_emp_non_id.emp_name','tbl_nonid_official_info.joining_date','tbl_nonid_salary.console_salary','tbl_emp_non_id.contact_num','tbl_nonid_official_info.next_renew_date') */
							 

		  
		$data['id'] 					= $result->id;
		$data['is_field_reduce'] 	    = $result->is_field_reduce;
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
		$data['email'] 					= $result->email;
		$data['birth_certificate'] 		= $result->birth_certificate;
		$data['national_id'] 			= $result->national_id;
		$data['maritial_status'] 		= $result->maritial_status;
		$data['gender'] 				= $result->gender;
		$data['blood_group'] 			= $result->blood_group;
		$data['joining_date'] 			= $result->joining_date;
		$data['br_join_date'] 			= $result->br_join_date;
		$data['present_add'] 			= $result->present_add;
		$data['after_trai_join_date'] 	= $result->after_trai_join_date;
		$data['next_renew_date'] 		= $result->next_renew_date;
		$data['designation_code'] 		= $result->designation_code;
		$data['br_code'] 				= $result->br_code;
		$data['salary_br_code'] 		= $result->salary_br_code;
		$data['after_trai_br_code'] 	= $result->after_trai_br_code;
		$data['c_end_date'] 			= $result->c_end_date;
		$data['end_type'] 				= $result->end_type;
		$data['vill_road'] 				= $result->vill_road;
		$data['post_office'] 			= $result->post_office;
		$data['district_code'] 			= $result->district_code;
		$data['thana_code'] 			= $result->thana_code;
		$data['permanent_add'] 			= $result->permanent_add;
		$data['last_education'] 		= $result->last_education;
		$data['referrence_name'] 		= $result->referrence_name;
		$data['reference_phone'] 		= $result->reference_phone;
		$data['nec_phone_num'] 			= $result->nec_phone_num; 
		//salary  
		$data['effect_date']			= $result->effect_date;
		$data['console_salary']			= $result->console_salary;
		$data['basic_salary']			= $result->basic_salary;
		
		$data['npa_a']					= 0;
		$data['motor_a']				= 0;
		$data['f_allowance']			= 0;
		$data['maintenance_a']			= 0;
		$data['internet_a']				= 0;
		$data['medical_a']				= 0;
		$data['house_rent']				= 0;
		$data['convence_a']				= 0;
		$data['field_a']				= 0;
		$data['mobile_a']				= 0;
		
		
		if(!empty($result->plus_item_id)){
			$plus_item_id1 =   explode(',',$result->plus_item_id);
			$item_plus_amt1 =   explode(',',$result->item_plus_amt);
			 //print_r($item_plus_amt);
			 foreach($plus_item_id1 as $key=>$v_plus){
				  //echo $key;
 			 if($v_plus == 1){
					$data['npa_a']			     = $item_plus_amt1[$key]; 
				 }else if($v_plus == 2){
					$data['f_allowance']		 = $item_plus_amt1[$key]; 
				 }else if($v_plus == 3){
					$data['house_rent']		     = $item_plus_amt1[$key]; 
				 }else if($v_plus == 4){
					$data['motor_a']		     = $item_plus_amt1[$key]; 
				 }else if($v_plus == 5){
					$data['medical_a']		     = $item_plus_amt1[$key]; 
				 }else if($v_plus == 6){
					$data['internet_a']		     = $item_plus_amt1[$key]; 
				 }else if($v_plus == 7){
					$data['convence_a']		     = $item_plus_amt1[$key]; 
				 }else if($v_plus == 8){
					$data['field_a']		     = $item_plus_amt1[$key]; 
				 }else if($v_plus == 9){
					$data['mobile_a']		     = $item_plus_amt1[$key]; 
				 }else if($v_plus == 10){
					$data['maintenance_a']		 = $item_plus_amt1[$key]; 
				 }  
				 
			 } 
		}  
		
		$data['gross_salary']			= $result->gross_salary;
		$data['is_Consolidated'] 		= $result->is_Consolidated;
		 
		
		
		
		$data['action'] 				= "/non-appoinment/$id";
		$data['method'] 				= 'POST';
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 		
		$data['Heading'] 				= 'Edit Employee Non Id';
		$data['button_text'] 			= 'Update';
		//	
		$data['all_emp_type'] 		= DB::table('tbl_emp_type')->where('id','>',1)->where('status',1)->get();
		$data['branches'] 		   		= DB::table('tbl_branch')->where('status',1)->orderBy('branch_name','asc')->get();
		$data['districts'] 		   		= DB::table('tbl_district')->where('status',1)->orderBy('district_name','asc')->get();
		$data['thanas'] 		   		= DB::table('tbl_thana')->where('status',1)->orderBy('thana_name','asc')->get(); 
		$data['designation'] 			= DB::table('tbl_designation')->where('status',1)->orderBy('designation_name','asc')->get();	
		//
		 
		return view('admin.employee.non_id_form_edit',$data);	
	}
	public function non_id_info_edit($id)
	{
		/* $action_id = 3;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		} */

		$data = array();
			$result = 	NonId::leftjoin('tbl_emp_type', 'tbl_emp_type.id', '=', 'tbl_emp_non_id.emp_type_code')
								->select('tbl_emp_non_id.*','tbl_emp_type.is_field_reduce')
								->where('tbl_emp_non_id.id',$id)
								->first();
							  
		$data['id'] 					= $result->id;
		/* echo '<pre>';
		print_r($result );
		exit;  */
		$data['is_field_reduce'] 	    = $result->is_field_reduce;
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
		$data['email'] 					= $result->email;
		$data['birth_certificate'] 		= $result->birth_certificate;
		$data['national_id'] 			= $result->national_id;
		$data['maritial_status'] 		= $result->maritial_status;
		$data['gender'] 				= $result->gender;
		$data['blood_group'] 			= $result->blood_group;
		$data['joining_date'] 			= $result->joining_date;
		$data['br_join_date'] 			= $result->br_join_date;
		$data['present_add'] 			= $result->present_add; 
		$data['vill_road'] 				= $result->vill_road;
		$data['post_office'] 			= $result->post_office;
		$data['district_code'] 			= $result->district_code;
		$data['thana_code'] 			= $result->thana_code;
		$data['permanent_add'] 			= $result->permanent_add;
		$data['last_education'] 		= $result->last_education;
		$data['referrence_name'] 		= $result->referrence_name;
		$data['reference_phone'] 		= $result->reference_phone;
		$data['nec_phone_num'] 			= $result->nec_phone_num; 
		//salary  
		 
		 
		 
		
		  
		
		 
		
		
		$data['action'] 				= "/non_id_info_update";
		$data['method'] 				= 'POST';
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 		
		$data['Heading'] 				= 'Edit Employee Non Id';
		$data['button_text'] 			= 'Update';
		//	
		$data['all_emp_type'] 		= DB::table('tbl_emp_type')->where('id','>',1)->where('status',1)->get();
		$data['branches'] 		   		= DB::table('tbl_branch')->where('status',1)->orderBy('branch_name','asc')->get();
		$data['districts'] 		   		= DB::table('tbl_district')->where('status',1)->orderBy('district_name','asc')->get();
		$data['thanas'] 		   		= DB::table('tbl_thana')->where('status',1)->orderBy('thana_name','asc')->get(); 
	 
		 
		return view('admin.employee.non_id_form_edit_basic_info',$data);	
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
		$plus_item_id 	= array();
		$item_plus_amt 	= array(); 
		 
		$data['emp_id'] 			= $emp_id 	= $this->get_last_emp_id(); 
		
		$emp_type1 = explode(',',$request->emp_type);
		$data['emp_type'] 			= $emp_type = $emp_type1[0];
		$data['emp_type_code'] 		= $emp_type1[0];
		$data['emp_name'] 			= $request->emp_name; 
		$data['mother_name'] 		= $request->mother_name;
		$data['father_name'] 		= $request->father_name;
		$data['birth_date'] 		= $request->birth_date;
		$data['gender'] 			= $request->gender;
		//$data['present_age'] 		= $request->present_age;
		$data['nationality'] 		= $request->nationality;
		$data['religion'] 			= $request->religion;
		$data['contact_num'] 		= $request->contact_num;
		$data['email'] 				= $request->email;
		$data['national_id'] 		= $request->national_id;
		$data['birth_certificate'] 	= $request->birth_certificate;
		$data['maritial_status']	= $request->maritial_status;
		$data['last_education']		= $request->last_education;
		$data['blood_group']		= $request->blood_group;
		$data['joining_date'] 		= $request->joining_date;
		$data['nec_phone_num']		= $request->nec_phone_num;
		$data['referrence_name']	= $request->referrence_name;
		$data['reference_phone']	= $request->reference_phone;
		$data['vill_road']			= $request->vill_road;
		$data['post_office']		= $request->post_office;
		$data['district_code']		= $request->district_code;
		$data['thana_code']			= $request->thana_code;
		$data['permanent_add']		= $request->permanent_add;
		$data['present_add']		= $request->present_add;
		$data['created_by'] 		= Session::get('admin_id');
		$data['org_code'] 		 	= Session::get('admin_org_code');
		$data['sacmo_id'] 			= $request->sacmo_id;
		
		
		$odata['is_first_entry']			= 1 ;
		$odata['emp_id']					= $emp_id;
		$odata['designation_code']			= $request->designation_code;
		$odata['salary_br_code'] 			= $request->salary_br_code;
		$odata['br_code'] 					= $request->br_code;
		$odata['joining_date'] 				= $request->joining_date;
		$odata['br_join_date'] 				= $request->br_join_date;
		$odata['after_trai_join_date'] 		= $request->after_trai_join_date;
		//$odata['next_renew_date'] 		= $request->next_renew_date;
		
		if(isset($request->end_type)){
			$odata['end_type'] 			= 0;
		}else{
			$odata['end_type'] 			= 1;
			$odata['c_end_date'] 		= $request->c_end_date;
		}
		
		
		$odata['after_trai_br_code']= $request->after_trai_br_code;
		$odata['org_code'] 			= Session::get('admin_org_code');
		$odata['created_by'] 		= Session::get('admin_id');
		
		
		
		$sdata['is_first_entry']	= 1;
		$sdata['emp_id']			= $emp_id;
		$sdata['effect_date']		= $request->effect_date;
		$sdata['console_salary']	= $request->console_salary;
		$sdata['basic_salary']		= $request->basic_salary;
		if($request->npa_a > 0){
			$item_plus_amt[] = $request->npa_a;
			$plus_item_id[] = 1;
		}
		 if($request->f_allowance > 0){
			$item_plus_amt[] = $request->f_allowance;
			$plus_item_id[] =  2;
		}
		if($request->house_rent > 0){
			$item_plus_amt[] =  $request->house_rent;
			$plus_item_id[] =  3;
		} 
		 if($request->motor_a > 0){
			$item_plus_amt[] =  $request->motor_a;
			$plus_item_id[] =  4;
		}
		 if($request->medical_a > 0){
			$item_plus_amt[] =  $request->medical_a;
			$plus_item_id[] =  5;
		}
		if($request->internet_a > 0){
			$item_plus_amt[] =  $request->internet_a;
			$plus_item_id[] =  6;
		}
		if($request->convence_a > 0){
			$item_plus_amt[] =  $request->convence_a;
			$plus_item_id[] =  7;
		} 
		if($request->field_a > 0){
			$item_plus_amt[] =  $request->field_a;
			$plus_item_id[] =  8;
		} 	
		if($request->mobile_a > 0){
			$item_plus_amt[] =  $request->mobile_a;
			$plus_item_id[] =  9;
		}if($request->maintenance_a > 0){
			$item_plus_amt[] =  $request->maintenance_a;
			$plus_item_id[] =  10;
		}  
		 if(!empty($plus_item_id)){
			$plus_item_id = implode(",", $plus_item_id); 
		 }else{
			 $plus_item_id = '';
		 }
		 if(!empty($item_plus_amt)){
			$item_plus_amt = implode(",", $item_plus_amt); 
		 }else{
			 $item_plus_amt = '';
		 }
		$sdata['item_plus_amt']		= $item_plus_amt;
		$sdata['plus_item_id']		= $plus_item_id;
		$sdata['gross_salary']		= $request->gross_salary;
		$sdata['org_code'] 			= Session::get('admin_org_code');
		$sdata['created_by'] 		= Session::get('admin_id');
		if(isset($request->is_Consolidated)){
			$sdata['is_Consolidated'] 	= 2;
		}else{ 
			$sdata['is_Consolidated'] 	= 1;
		}
	 	/* echo '<pre>';
		print_r($data);	
		echo '<pre>';
		print_r($odata);	
		echo '<pre>';
		print_r($sdata); 
		  
		exit; */
		$leavedata = array();
		$leave_joining_date = date('Y-m-d',strtotime($data['joining_date']));
		$join_year			  = date('Y',strtotime($leave_joining_date)); 
		$join_month 		  = date('m',strtotime($leave_joining_date));
	   if (date('m') <= 6) { 
			$f_year_start  = (date('Y')-1) ;
			$f_year_end    = date('Y');   
		}else{ 
			$f_year_start  = date('Y');  
			$f_year_end    = (date('Y') + 1); 
		}
	 
		$f_date_start   =  date('Y-m-d',strtotime(($f_year_start)."-"."06"."-"."30"));
		$join_day 		= date('d',strtotime($leave_joining_date));
		$additional_day = 0;
		$additional_day_casual = 0;
		if($leave_joining_date > $f_date_start){
			 if($join_day <= 10){
				$additional_day = 1.5;
			}else if($join_day <= 20){
				$additional_day = 1;
			}else{
				$additional_day = 0.5;
			} 
			if($join_day <=15){
				$additional_day_casual = 1;
			}else{
				$additional_day_casual = 0;
			}
			$month_difference =(($f_year_end * 12 )+ 6)-(($join_year*12) + $join_month);
			$current_date = $leave_joining_date;
		}else{
			$month_difference = 12; 
			$current_date = date('Y-m-d');
		}
		if($month_difference <  12 && $month_difference >= 0){
			$total_day = ($month_difference * 1.5 ) + $additional_day;
			$total_day_casual = ($month_difference * 1 ) + $additional_day_casual;
		}else if($month_difference < 0 && $month_difference >= -12){
			$month_difference = 12 + $month_difference;
			$total_day = ($month_difference * 1.5 ) + $additional_day;
			$total_day_casual = ($month_difference * 1 ) + $additional_day_casual;
		}else{
			$total_day = 18 ;
			$total_day_casual = 12 ;
		}
		if($data['joining_date'] >= '2020'.'-'.'11'.'-'.'30'){
			$total_day_casual = $total_day_casual;
		}else{
			$total_day_casual = 7;
		}
		$financial_year = DB::table('tbl_financial_year')
					->where('f_year_from','<=', $current_date)
					->where('f_year_to','>=', $current_date)
					->first(); 
					
		$leavedata['emp_id'] 				=$data['sacmo_id']; 
		$leavedata['emp_type'] 				= $emp_type; 
		$leavedata['branch_code'] 			= $odata['br_code'];
		$leavedata['f_year_id'] 			= $financial_year->id;
		$leavedata['cum_balance'] 			= 0; 
		$leavedata['current_open_balance'] 	=$total_day;
		$leavedata['casual_leave_open'] 	= $total_day_casual;
		$leavedata['casual_leave_close'] 	= $total_day_casual;
		$leavedata['eid_earn_leave_open'] 	= 6;
		$leavedata['eid_earn_leave_close'] 	= 6;
		$leavedata['no_of_days'] 			= 0;
		$leavedata['cum_close_balance'] 	= 0;
		$leavedata['current_close_balance'] =$total_day; 
		$leavedata['last_update_date'] 		= date('Y-m-d');
		$leavedata['created_by'] 			= Session::get('admin_id');
		$leavedata['status'] 				= 2;
		
		
		$validation_status = $this->validation($emp_id);
		if($validation_status == 1)
		{
			Session::put('message','This Employee Already Exit');
			return Redirect::to('/non-appoinment/create');
		} 
		$odata['sarok_no'] 	= $this->get_last_nonid_sarok();
		DB::beginTransaction();
		try {		
			DB::table('tbl_emp_non_id')->insert($data);
			DB::table('tbl_nonid_official_info')->insert($odata);
			DB::table('tbl_nonid_salary')->insert($sdata);
			DB::table('tbl_leave_balance')->insert($leavedata);
			DB::commit();
			Session::put('message','Data Saved Successfully');
		}catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		}
		 /* echo '<pre>'; 
		print_r($data);
		echo '<pre>';
		print_r($odata);
		echo '<pre>';
		print_r($sdata);
		echo '<pre>';
		print_r($leavedata); */
		//exit;  
		//exit;
		return Redirect::to('/non-appoinment');
    } 
	
	public function non_id_info_update(Request $request)
    {			 
		$data = array(); 
		$emp_type1 					= explode(',',$request->emp_type); 
		$emp_type 					= $emp_type1[0]; 
		$sacmo_id 					= $request->sacmo_id; 
		$id 					= $request->db_id;  
		$emp_id 					= $request->emp_id;  
		$data['emp_name'] 			= $request->emp_name; 
		$data['mother_name'] 		= $request->mother_name;
		$data['father_name'] 		= $request->father_name;
		$data['birth_date'] 		= $request->birth_date;
		$data['gender'] 			= $request->gender; 
		$data['nationality'] 		= $request->nationality;
		$data['religion'] 			= $request->religion;
		$data['contact_num'] 		= $request->contact_num;
		$data['email'] 				= $request->email;
		$data['birth_certificate'] 	= $request->birth_certificate;
		$data['national_id'] 		= $request->national_id;
		$data['maritial_status']	= $request->maritial_status;
		$data['last_education']		= $request->last_education;
		$data['blood_group']		= $request->blood_group; 
		$data['nec_phone_num']		= $request->nec_phone_num;
		$data['referrence_name']	= $request->referrence_name;
		$data['reference_phone']	= $request->reference_phone;
		$data['vill_road']			= $request->vill_road;
		$data['post_office']		= $request->post_office;
		$data['district_code']		= $request->district_code;
		$data['thana_code']			= $request->thana_code;
		$data['permanent_add']		= $request->permanent_add;
		$data['present_add']		= $request->present_add; 
		 
		/*  echo '<pre>';
		print_r($data);
		 exit;   */ 
		//Data Update 
		DB::beginTransaction();
		try{				
			DB::table('tbl_emp_non_id')
				->where('id', $id)
				->update($data); 
			DB::commit();
			Session::put('message','Data Updated Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Updated Data');
			DB::rollback();
		}
		//exit;
		return Redirect::to('/non-appoinment');
    }
	public function update(Request $request, $id)
    {			 
		$data = array();
		$odata = array();
		$sdata = array(); 
		$item_plus_amt = array(); 
		$plus_item_id = array(); 
		$emp_type1 					= explode(',',$request->emp_type); 
		$emp_type 					= $emp_type1[0]; 
		$sacmo_id 					= $request->sacmo_id; 
		$emp_id 					= $request->emp_id; 
		$data['emp_name'] 			= $request->emp_name; 
		$data['mother_name'] 		= $request->mother_name;
		$data['father_name'] 		= $request->father_name;
		$data['birth_date'] 		= $request->birth_date;
		$data['gender'] 			= $request->gender; 
		$data['nationality'] 		= $request->nationality;
		$data['religion'] 			= $request->religion;
		$data['contact_num'] 		= $request->contact_num;
		$data['email'] 				= $request->email;
		$data['birth_certificate'] 	= $request->birth_certificate;
		$data['national_id'] 		= $request->national_id;
		$data['maritial_status']	= $request->maritial_status;
		$data['last_education']		= $request->last_education;
		$data['blood_group']		= $request->blood_group; 
		$data['nec_phone_num']		= $request->nec_phone_num;
		$data['referrence_name']	= $request->referrence_name;
		$data['reference_phone']	= $request->reference_phone;
		$data['vill_road']			= $request->vill_road;
		$data['post_office']		= $request->post_office;
		$data['district_code']		= $request->district_code;
		$data['thana_code']			= $request->thana_code;
		$data['permanent_add']		= $request->permanent_add;
		$data['present_add']		= $request->present_add;
		$data['joining_date']		= $request->joining_date;
		// official info
		$odata['designation_code']	= $request->designation_code;
		$odata['br_code']			= $request->br_code;
		$odata['salary_br_code']	= $request->salary_br_code;
		$odata['joining_date']		= $request->joining_date;
		$odata['br_join_date']		= $request->br_join_date;
		$odata['after_trai_join_date']= $request->after_trai_join_date; 
		$odata['after_trai_br_code']= $request->after_trai_br_code;
		$odata['next_renew_date']	= $request->next_renew_date;
		if(isset($request->end_type)){
			$odata['end_type'] 			= 0;
			$odata['c_end_date'] 		= null;
		}else{
			$odata['end_type'] 			= 1;
			$odata['c_end_date'] 		= $request->c_end_date;
		} 
		$odata['updated_at'] 		= date('Y-m-d');
		$odata['updated_by'] 		= Session::get('admin_id');
		
		// salary 
		$sdata['effect_date']		= $request->effect_date;
		$sdata['console_salary']	= $request->console_salary;
		$sdata['basic_salary']		= $request->basic_salary;
		
		
		if($request->npa_a > 0){
			$item_plus_amt[] = $request->npa_a;
			$plus_item_id[] = 1;
		}
		 if($request->f_allowance > 0){
			$item_plus_amt[] = $request->f_allowance;
			$plus_item_id[] =  2;
		}
		if($request->house_rent > 0){
			$item_plus_amt[] =  $request->house_rent;
			$plus_item_id[] =  3;
		} 
		 if($request->motor_a > 0){
			$item_plus_amt[] =  $request->motor_a;
			$plus_item_id[] =  4;
		}
		 if($request->medical_a > 0){
			$item_plus_amt[] =  $request->medical_a;
			$plus_item_id[] =  5;
		}
		if($request->internet_a > 0){
			$item_plus_amt[] =  $request->internet_a;
			$plus_item_id[] =  6;
		}
		if($request->convence_a > 0){
			$item_plus_amt[] =  $request->convence_a;
			$plus_item_id[] =  7;
		} 
		if($request->field_a > 0){
			$item_plus_amt[] =  $request->field_a;
			$plus_item_id[] =  8;
		} 	
		if($request->mobile_a > 0){
			$item_plus_amt[] =  $request->mobile_a;
			$plus_item_id[] =  9;
		}
		if($request->maintenance_a > 0){
			$item_plus_amt[] =  $request->maintenance_a;
			$plus_item_id[] =  10;
		}  
		 if(!empty($plus_item_id)){
			$plus_item_id = implode(",", $plus_item_id); 
		 }else{
			$plus_item_id = '';
		 }
		 if(!empty($item_plus_amt)){
			$item_plus_amt = implode(",", $item_plus_amt); 
		 }else{
			 $item_plus_amt = '';
		 }
		 //print_r($item_plus_amt);
		$sdata['item_plus_amt']		= $item_plus_amt;
		$sdata['plus_item_id']		= $plus_item_id; 
		$sdata['gross_salary']		= $request->gross_salary;
		$sdata['updated_at'] 		= date('Y-m-d');
		$sdata['updated_by'] 		= Session::get('admin_id');
		if(isset($request->is_Consolidated)){
			$sdata['is_Consolidated'] 		= 2; 
		}else{ 
			$sdata['is_Consolidated'] 		= 1;
		} 
		/* echo '<pre>';
		print_r($sdata);
		exit; */
		/// leave 
		$leavedata = array();
		$leave_joining_date = date('Y-m-d',strtotime($odata['joining_date']));
		$join_year			  = date('Y',strtotime($leave_joining_date)); 
		$join_month 		  = date('m',strtotime($leave_joining_date));
	   if (date('m') <= 6) { 
			$f_year_start  = (date('Y')-1) ;
			$f_year_end    = date('Y');   
		}else{ 
			$f_year_start  = date('Y');  
			$f_year_end    = (date('Y') + 1); 
		}
	 
		$f_date_start   =  date('Y-m-d',strtotime(($f_year_start)."-"."06"."-"."30"));
		$join_day 		= date('d',strtotime($leave_joining_date));
		$additional_day = 0;
		if($leave_joining_date > $f_date_start){
			 if($join_day <= 10){
				$additional_day = 1.5;
			}else if($join_day <= 20){
				$additional_day = 1;
			}else{
				$additional_day = 0;
			} 
			$month_difference =(($f_year_end * 12 )+ 6)-(($join_year*12) + $join_month);
			$current_date = $leave_joining_date;
		}else{
			$month_difference = 12; 
			$current_date = date('Y-m-d');
		}
		if($month_difference <  12 && $month_difference >= 0){
			$total_day = ($month_difference * 1.5 ) + $additional_day;
		}else if($month_difference < 0 && $month_difference >= -12){
			$month_difference = 12 + $month_difference;
			$total_day = ($month_difference * 1.5 ) + $additional_day;
		}else{
			$total_day = 18 ;
		}
		$financial_year = DB::table('tbl_financial_year')
					->where('f_year_from','<=', $current_date)
					->where('f_year_to','>=', $current_date)
					->first(); 
					
		$leavedata['emp_id'] 				= $sacmo_id; 
		$leavedata['emp_type'] 				= $emp_type; 
		$leavedata['branch_code'] 			= $odata['br_code'];
		$leavedata['f_year_id'] 			= $f_year_id = $financial_year->id;
		$leavedata['cum_balance'] 			= 0; 
		$leavedata['current_open_balance'] 	=$total_day;
		$leavedata['no_of_days'] 			= 0;
		$leavedata['cum_close_balance'] 	= 0;
		$leavedata['current_close_balance'] =$total_day; 
		$leavedata['last_update_date'] 		= date('Y-m-d');
		$leavedata['status'] 				= 2;
		
		 /* echo '<pre>';
		print_r($sdata);
		 exit;    */
		//Data Update 
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
			/* DB::table('tbl_leave_balance')
				->where('emp_id', $sacmo_id)
				->where('emp_type', $emp_type)
				->where('f_year_id', $f_year_id)
				->update($leavedata);  */
			DB::commit();
			Session::put('message','Data Updated Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Updated Data');
			DB::rollback();
		}
		//exit;
		return Redirect::to('/non-appoinment');
    }
	
	public function show($id)
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
		$current_date = date("Y-m-d");
		 $result = 	NonId::leftjoin('tbl_nonid_official_info as nmax',function($join) use($current_date){
												$join->on("tbl_emp_non_id.emp_id","=","nmax.emp_id") 
														->where('nmax.sarok_no',DB::raw("(SELECT 
																				  max(tbl_nonid_official_info.sarok_no)
																				  FROM tbl_nonid_official_info 
																				   where tbl_emp_non_id.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
																				  max(t.joining_date)
																				  FROM tbl_nonid_official_info as t 
																				   where tbl_emp_non_id.emp_id = t.emp_id AND t.joining_date <=  '$current_date')
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
					
					->select('nmin.br_code as join_br_code','nmin.after_trai_br_code','tbl_emp_non_id.blood_group','tbl_emp_non_id.present_add','tbl_emp_non_id.vill_road','tbl_emp_non_id.post_office','tbl_emp_non_id.district_code','tbl_emp_non_id.thana_code','tbl_emp_non_id.permanent_add','tbl_emp_non_id.last_education','tbl_emp_non_id.referrence_name','tbl_emp_non_id.reference_phone','tbl_emp_non_id.nec_phone_num','nmax.br_code','nmax.designation_code','nmax.c_end_date','nmax.end_type','nmin.after_trai_join_date','tbl_emp_non_id.emp_id','tbl_emp_non_id.father_name','tbl_emp_non_id.mother_name','tbl_emp_non_id.birth_date','tbl_emp_non_id.nationality','tbl_emp_non_id.religion','tbl_emp_non_id.email','tbl_emp_non_id.national_id','tbl_emp_non_id.birth_certificate','tbl_emp_non_id.maritial_status','tbl_emp_non_id.gender','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.emp_type','tbl_emp_non_id.emp_type_code','tbl_emp_non_id.emp_name','nmin.joining_date','tbl_emp_non_id.contact_num','nmax.next_renew_date','tbl_nonid_salary.basic_salary','tbl_nonid_salary.plus_item_id','tbl_nonid_salary.item_plus_amt','tbl_nonid_salary.gross_salary','tbl_nonid_salary.nara_tion','nmax.salary_br_code','nmax.designation_code','tbl_nonid_salary.effect_date','tbl_nonid_salary.console_salary','et.type_name','et.is_field_reduce','tbl_nonid_salary.is_Consolidated')
					->where('tbl_emp_non_id.id',$id)
					->first();
		
		//$result = NonId::find($id);

	/* 	echo "<pre>";
		print_r($data);
		exit; */
		$data['id'] 					= $result->id;
		$data['is_field_reduce'] 		= $result->is_field_reduce;
		$data['emp_id'] 				= $result->emp_id;
		$data['emp_type'] 				= $result->emp_type_code;
		$data['emp_name'] 				= $result->emp_name;
		$data['father_name'] 			= $result->father_name;
		$data['mother_name'] 			= $result->mother_name;
		$data['birth_date'] 			= $result->birth_date;
		$data['nationality'] 			= $result->nationality;
		$data['religion'] 				= $result->religion;
		$data['contact_num']			= $result->contact_num;
		$data['email'] 					= $result->email;
		$data['national_id'] 			= $result->national_id;
		$data['birth_certificate'] 		= $result->birth_certificate;
		$data['maritial_status'] 		= $result->maritial_status;
		$data['gender'] 				= $result->gender;
		$data['blood_group'] 			= $result->blood_group;
		$data['joining_date'] 			= $result->joining_date;
		$data['present_add'] 			= $result->present_add;
		$data['after_trai_join_date'] 	= $result->after_trai_join_date;
		$data['vill_road'] 				= $result->vill_road;
		$data['post_office'] 			= $result->post_office;
		$data['district_code'] 			= $result->district_code;
		$data['thana_code'] 			= $result->thana_code;
		$data['permanent_add'] 			= $result->permanent_add;
		$data['last_education'] 		= $result->last_education;
		$data['referrence_name'] 		= $result->referrence_name;
		$data['reference_phone'] 		= $result->reference_phone;
		$data['nec_phone_num'] 			= $result->nec_phone_num;
		$data['basic_salary'] 			= $result->basic_salary;
		$data['gross_salary'] 			= $result->gross_salary;
		$data['br_code'] 				= $result->br_code;
		$data['salary_br_code'] 		= $result->salary_br_code;
		$data['designation_code'] 		= $result->designation_code;
		$data['join_br_code'] 			= $result->join_br_code;
		$data['nara_tion'] 				= $result->nara_tion;
		 
		
		$data['type_name'] 				= $result->type_name;
		$data['sacmo_id'] 				= $result->sacmo_id;
		$data['pre_emp_id'] 			= $result->pre_emp_id;
		$data['after_trai_join_date'] 	= $result->after_trai_join_date;
		$data['c_end_date'] 			= $result->c_end_date;
		$data['end_type'] 			   = $result->end_type;
		$data['after_trai_br_code']    = $result->after_trai_br_code;
		$data['effect_date']  		   = $result->effect_date;
		$data['console_salary']  	   = $result->console_salary;
		$data['npa_a']					= 0;
		$data['motor_a']				= 0;
		$data['f_allowance']			= 0;
		$data['internet_a']				= 0;
		$data['maintenance_a']			= 0;
		$data['medical_a']				= 0;
		$data['house_rent']				= 0;
		$data['convence_a']				= 0;
		$data['field_a']				= 0;
		$data['mobile_a']				= 0;
		
		
		if(!empty($result->plus_item_id)){
			$plus_item_id1 =   explode(',',$result->plus_item_id);
			$item_plus_amt1 =   explode(',',$result->item_plus_amt);
			 //print_r($item_plus_amt);
			 foreach($plus_item_id1 as $key=>$v_plus){
				  //echo $key;
 			 if($v_plus == 1){
					$data['npa_a']			     = $item_plus_amt1[$key]; 
				 }else if($v_plus == 2){
					$data['f_allowance']		 = $item_plus_amt1[$key]; 
				 }else if($v_plus == 3){
					$data['house_rent']		     = $item_plus_amt1[$key]; 
				 }else if($v_plus == 4){
					$data['motor_a']		     = $item_plus_amt1[$key]; 
				 }else if($v_plus == 5){
					$data['medical_a']		     = $item_plus_amt1[$key]; 
				 }else if($v_plus == 6){
					$data['internet_a']		     = $item_plus_amt1[$key]; 
				 }else if($v_plus == 7){
					$data['convence_a']		     = $item_plus_amt1[$key]; 
				 }else if($v_plus == 8){
					$data['field_a']		     = $item_plus_amt1[$key]; 
				 }else if($v_plus == 9){
					$data['mobile_a']		     = $item_plus_amt1[$key]; 
				 }else if($v_plus == 10){
					$data['maintenance_a']		     = $item_plus_amt1[$key]; 
				 }  
				 
			 } 
		}  
		
		
		
		
		$data['is_Consolidated']  	   = $result->is_Consolidated;
		//
			
		$data['action'] 				= "/non-appoinment/$id";
		$data['method'] 				= 'POST';
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 		
		$data['Heading'] 				= 'Edit Employee Non Id';
		$data['button_text'] 			= 'Update'; 
		//	
		$data['branches'] 		   		= DB::table('tbl_branch')->where('status',1)->orderBy('branch_name','asc')->get();
		$data['districts'] 		   		= DB::table('tbl_district')->where('status',1)->orderBy('district_name','asc')->get();
		$data['thanas'] 		   		= DB::table('tbl_thana')->where('status',1)->orderBy('thana_name','asc')->get(); 
		$data['designation'] 			= DB::table('tbl_designation')->where('status',1)->orderBy('designation_name','asc')->get();	
		
		
		//
		return view('admin.employee.non_id_form_view',$data);	
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
					$option = '<a class="btn btn-sm btn-success btn-xs" title="Edit" href="non-appoinment/'.$result->id.'/edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
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
