<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests; 
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class Contractual_renewController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	public function index()
    {        	
		$data = array();
		$current_date = date("Y-m-d");
		$data['results'] 	= DB::table('tbl_contractual_renew as rn') 
							->join('tbl_emp_basic_info as eb', 'eb.emp_id', '=', 'rn.emp_id')
							->leftjoin('tbl_branch as b', 'b.br_code', '=', 'rn.br_code' )
							->leftjoin('tbl_designation as d', 'd.designation_code', '=', 'rn.designation_code' )
							 ->leftjoin('tbl_resignation as r',function($join) use($current_date){
												$join->on("r.emp_id","=","rn.emp_id")
												->where('r.effect_date','<',$current_date); 
														})	
							->select('rn.*','eb.emp_name_eng as emp_name','b.branch_name','d.designation_name','r.effect_date as cancel_date') 
							->orderBy('rn.id','desc')
							->get();
		//dd($data['results'] );
		// $data['results'] 	= '';
		return view('admin.employee.manage_contract_renew',$data);					
    }
	

	public function create()
    { 
		$data = array();
		$data['id'] 					= ''; 
		$data['emp_id'] 				= '';  
		$data['br_code'] 				= '';
		$data['salary_br_code'] 		= '';
		$data['emp_name'] 				= '';
		$data['designation_code'] 		= '';
		$data['emp_type'] 				= '';
		$data['sacmo_id'] 				= '';   
		//$data['after_trai_br_code'] 	= '';   
		$data['after_trai_join_date'] 	= '';   
		$data['next_renew_date'] 		= '';   
		$data['end_type'] 				= 0;   
		$data['c_end_date'] 			= '';   
		$data['effect_date'] 			= ''; 
		$data['designation_name']		='';
		$data['joining_date']			= '';
		$data['sarok_no']				= '';
		$data['branch_name']			= '';
		$data['org_code'] 				= '181';
		$data['mode'] 					= '';
		//
		$data['action'] 			= '/contractual_renew';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ''; 		
		$data['Heading'] 			= 'Add Non ID Salary';
		$data['button_text'] 		= 'Save';  
		return view('admin.employee.contract_renew_form',$data);	
    }	 
	public function edit($id)
	{
		 
		$sdata = array();
		
		 
		$current_date = date("Y-m-d");
		
		$result = DB::table('tbl_contractual_renew as rn')
						->join('tbl_emp_basic_info as eb', 'eb.emp_id', '=', 'rn.emp_id')
						->leftjoin('tbl_branch as b', 'b.br_code', '=', 'rn.br_code' )
						->leftjoin('tbl_designation as d', 'd.designation_code', '=', 'rn.designation_code' )
						->leftjoin('tbl_resignation as r',function($join) use($current_date){
											$join->on("r.emp_id","=","rn.emp_id")
											->where('r.effect_date','<',$current_date); 
													}) 
						->where('rn.id',$id)
						->select('rn.*','eb.org_join_date','eb.emp_name_eng as emp_name','b.branch_name','d.designation_name','r.effect_date as cancel_date')
						->first();
						
						 
		
		$sdata['emp_id']			= $result->emp_id;  
		$sdata['sarok_no']			= $result->sarok_no;
		$sdata['emp_name']			= $result->emp_name;
		$sdata['designation_name']	= $result->designation_name;
		$sdata['joining_date']		= $result->org_join_date;
		 
		$sdata['branch_name']		= $result->branch_name;
		 
		$sdata['br_code']			= $result->br_code;
		$sdata['salary_br_code']	= $result->salary_br_code;
		$sdata['designation_code']	= $result->designation_code;
	 
		$sdata['next_renew_date']		= $result->effect_date;
		 
		$sdata['c_end_date']			= $result->c_end_date;
		 
		$sdata['mode']				= 'edit' ;
		 /*  echo '<pre>';
		print_r($sdata);
		exit; */
		// 
		$sdata['action'] 				= "/contractual_renew/$id";
		$sdata['method'] 				= 'POST';
		$sdata['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 		
		$sdata['Heading'] 				= 'Edit Employee Non Id';
		$sdata['button_text'] 			= 'Update';   
		//
		
		return view('admin.employee.contract_renew_form',$sdata);	
	} 
	public function get_nonemployee_contract_info($emp_id)
	{
		$data = array();
		$emp_id = $emp_id;
		$letter_date = date("Y-m-d");
		$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $emp_id)
						->where('m.letter_date', '=', function($query) use ($emp_id,$letter_date)
								{
									$query->select(DB::raw('max(letter_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $letter_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('emp_id')
						->first();

		//echo 	$max_id;
		//	exit;		

		if($max_sarok !=NULL)
		{
			$employee_info = DB::table('tbl_master_tra')
						->join('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'tbl_master_tra.emp_id')
						->join('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_master_tra.designation_code')
						->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_master_tra.br_code')
						->leftjoin('tbl_grade_new', 'tbl_grade_new.grade_id', '=', 'tbl_master_tra.grade_code')
						->leftjoin('tbl_resignation', 'tbl_resignation.emp_id', '=', 'tbl_master_tra.emp_id')
						->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_master_tra.emp_id')
						->where('tbl_master_tra.sarok_no', $max_sarok->sarok_no)
						->where('tbl_master_tra.status', 1)
						->select('tbl_master_tra.id','tbl_master_tra.emp_id','tbl_master_tra.sarok_no','tbl_master_tra.br_join_date','tbl_master_tra.next_increment_date','tbl_master_tra.effect_date as sa_effect_date','tbl_master_tra.designation_code','tbl_master_tra.br_code','tbl_master_tra.grade_code','tbl_master_tra.grade_effect_date','tbl_master_tra.grade_step','tbl_master_tra.department_code','tbl_master_tra.report_to','tbl_master_tra.is_permanent','tbl_emp_basic_info.emp_name_eng','tbl_emp_basic_info.father_name','tbl_emp_basic_info.org_join_date','tbl_emp_photo.emp_photo','tbl_designation.designation_name','tbl_branch.branch_name','tbl_grade_new.grade_name','tbl_resignation.effect_date','tbl_master_tra.basic_salary','tbl_master_tra.salary_br_code') 
						->first();	
		//print_r ($employee_info); exit;
			$data['emp_id'] 				= $emp_id; 
			$data['tra_id'] 				= $employee_info->id;
			$data['emp_name'] 				= $employee_info->emp_name_eng;
			$data['joining_date'] 			= $employee_info->org_join_date;
			$data['designation_code'] 		= $employee_info->designation_code;
			$data['designation_name'] 		= $employee_info->designation_name;
			$data['department_code'] 		= $employee_info->department_code;
			$data['report_to'] 				= $employee_info->report_to;
			$data['br_join_date'] 			= $employee_info->br_join_date;
			$data['effect_date'] 			= $employee_info->sa_effect_date;
			$data['br_code'] 				= $employee_info->br_code;
			$data['grade_code'] 			= $employee_info->grade_code;
			$data['grade_step'] 			= $employee_info->grade_step;
			$data['grade_effect_date'] 		= $employee_info->grade_effect_date;
			$data['next_increment_date'] 	= $employee_info->next_increment_date;
			$data['branch_name'] 			= $employee_info->branch_name;
			$data['grade_name'] 			= $employee_info->grade_name;
			$data['is_permanent'] 			= $employee_info->is_permanent;
			$data['salary_br_code'] 		= $employee_info->salary_br_code;
			
			$data['basic_salary'] 			= $employee_info->basic_salary;
			if($employee_info->emp_photo !='')
			{
				$data['emp_photo'] 			= $employee_info->emp_photo;
			}
			else{
				$data['emp_photo'] 			= 'default.png';
			}
			$data['resign_date'] 			= $employee_info->effect_date;
			$data['emp_status'] 			= 'Active';	
		}
		else
		{
			$data['emp_id'] 				= $emp_id;
			$data['tra_id'] 				= '';
			$data['emp_name'] 				= '';
			$data['joining_date'] 			= '';
			$data['designation_code'] 		= '';
			$data['designation_name'] 		= '';
			$data['department_code'] 		= '';
			$data['report_to'] 				= '';
			$data['br_code'] 				= '';
			$data['grade_code'] 			= '';
			$data['grade_step'] 			= '';
			$data['branch_name'] 			= '';
			$data['branch_name'] 			= '';
			$data['grade_name'] 			= '';
			$data['emp_photo'] 				= 'default.png';
			$data['emp_status'] 			= 'Employee Status';
			$data['resign_date'] 			= '';
			$data['salary_br_code'] 		= '';
			$data['br_join_date'] 		= '';
		}
		
		//echo '<pre>';
		//print_r($data);
		//exit;
		return $data;
		 
		
	}
	public function check_contract_effect_date($emp_id,$effect_date)
	{
		$is_less_date = 0;
		$results = DB::table('tbl_master_tra') 
						->where('emp_id',$emp_id) 
						->where('effect_date','>=',$effect_date) 
						->select('emp_id')
						->first();
		if($results){
			  $is_less_date = 1;
		}	
		echo $is_less_date;	
	} 
	public function store(Request $request)
    { 
		
		$odata = array(); 
		$sdata = array(); 
		$rdata = array(); 
		$tra_id			= $request->tra_id;	
		$letter_date	= date("Y-m-d");	
		$employee_info = DB::table('tbl_master_tra')->where('id',$tra_id)->first();	
		//dd($employee_info);
		$odata['emp_id']					= $employee_info->emp_id;
		
		
		$result = DB::table('tbl_sarok_no') 
				  ->max('sarok_no'); 
		$rdata['sarok_no']	=$odata['sarok_no']	= $sdata['sarok_no'] =  $result+1;
		$sdata['transection_type']			=  16;
		$rdata['emp_id'] = $sdata['emp_id']  = $employee_info->emp_id;  
		$sdata['letter_date'] 				= $letter_date; 
		$odata['letter_date'] 				= $letter_date; 
		$odata['pre_designation_code'] 		= $employee_info->pre_designation_code;
		$rdata['designation_code'] 			= $odata['designation_code'] 			= $employee_info->designation_code;
		$odata['department_code'] 			= $employee_info->department_code;
		$odata['pre_br_code'] 			= $employee_info->pre_br_code;
		$rdata['br_code'] 				= $odata['br_code'] 			= $employee_info->br_code;
		$rdata['salary_br_code'] 		= $odata['salary_br_code'] 			= $employee_info->salary_br_code;
		$odata['br_join_date'] 			= $employee_info->br_join_date;
		$odata['grade_step'] 			= $employee_info->grade_step;
		$odata['grade_code'] 			= $employee_info->grade_code;
		$odata['scale_code'] 		= $employee_info->scale_code;
		$odata['basic_salary'] 		= $employee_info->basic_salary;
		$odata['is_consolidated'] 		= $employee_info->is_consolidated;
		$odata['total_pay'] 		= $employee_info->total_pay;
		$odata['total_minus'] 		= $employee_info->total_minus;
		$odata['net_pay'] 		= $employee_info->net_pay;
		$odata['others_allowance'] 		= $employee_info->others_allowance;
		$rdata['c_end_date'] 		=  $odata['next_increment_date'] 		= $request->c_end_date;
		$rdata['effect_date'] 		= $odata['effect_date'] 		= $request->next_renew_date;
		$odata['tran_type_no'] 		= $employee_info->tran_type_no;
		$odata['increment_review'] 		= $employee_info->increment_review;
		$odata['is_permanent'] 		= $employee_info->is_permanent;
		$odata['provision_time'] 		= $employee_info->provision_time;
		$odata['grade_effect_date'] 		= $employee_info->grade_effect_date;
		$odata['report_to'] 		= $employee_info->report_to;
		$odata['report_to_designation_code'] 		= $employee_info->report_to_designation_code;
		$odata['report_to_new'] 		= $employee_info->report_to_new;
		$odata['report_to_emp_type'] 		= $employee_info->report_to_emp_type;
		$rdata['org_code'] 		= $odata['org_code'] 		= $employee_info->org_code;
		$odata['status'] 		= $employee_info->status; 
		$rdata['created_by'] 		= $odata['created_by'] 		= Session::get('admin_id');
	 
		DB::beginTransaction();
		try {	 
			DB::table('tbl_master_tra')->insert($odata);
			DB::table('tbl_contractual_renew')->insert($rdata);
			DB::table('tbl_sarok_no')->insert($sdata);
			DB::commit();
			Session::put('message','Data Saved Successfully');
		}catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		}

		return Redirect::to('/contractual_renew');
    } 
	
	public function update(Request $request, $id)
    {	  
		$odata = array(); 
		$tdata = array(); 
		$sarok_no  = $request->sarok_no;
		
		$tdata['effect_date']		  = $odata['effect_date']		  = $request->next_renew_date;
		  
	
		$tdata['next_increment_date'] = $odata['c_end_date'] 		= $request->c_end_date;
		
		$tdata['updated_at'] = $odata['updated_at'] 		  = date("Y-m-d");
		$tdata['updated_by'] = $odata['updated_by'] 		  = Session::get('admin_id');
		  
		DB::beginTransaction();
		try{	
			 DB::table('tbl_master_tra')
				->where('sarok_no', $sarok_no)
				->update($tdata); 
				
			DB::table('tbl_contractual_renew')
				->where('id', $id)
				->update($odata);
			DB::commit();
			Session::put('message','Data Updated Successfully');
		} catch (\Exception $e) {
			
			Session::put('message','Error: Unable to Updated Data');
			DB::rollback();
		}
		return Redirect::to('/contractual_renew');
    }
	
	public function view_contract_renew_info($id)
	{
		$current_date = date("Y-m-d");
		 
		  
		$result = DB::table('tbl_contractual_renew as rn')
						->join('tbl_emp_basic_info as eb', 'eb.emp_id', '=', 'rn.emp_id')
						->leftjoin('tbl_branch as b', 'b.br_code', '=', 'rn.br_code' )
						->leftjoin('tbl_designation as d', 'd.designation_code', '=', 'rn.designation_code' )
						 ->leftjoin('tbl_resignation as r',function($join) use($current_date){
											$join->on("r.emp_id","=","rn.emp_id")
											->where('r.effect_date','<',$current_date); 
													}) 
						->where('rn.id',$id)
						->select('rn.*','eb.org_join_date','eb.emp_name_eng as emp_name','b.branch_name','d.designation_name','r.effect_date as cancel_date')
						->first(); 				
		
		$sdata['emp_id']			= $result->emp_id;
		$sdata['cancel_date']		= $result->cancel_date; 
		$sdata['emp_name']			= $result->emp_name;
		$sdata['designation_name']	= $result->designation_name;
		$sdata['effect_date']		= $result->effect_date;
		$sdata['branch_name']		= $result->branch_name;
		$sdata['c_end_date']		= $result->c_end_date;
		$sdata['joining_date']		= $result->org_join_date;
		$sdata['Heading'] 			= 'View Contractual';
		$sdata['button_text'] 		= 'View'; 
		return view('admin.employee.contract_renew_view',$sdata);	
	}   
}
