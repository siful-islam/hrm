<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;

//session_start();

class NonIdSalaryController extends Controller
{
	public function __construct()
	{
		$this->middleware("CheckUserSession");
	}

	public function index()
	{
		$data = array();
		$current_date = date("Y-m-d");
		$data['results'] 	= DB::table('tbl_nonid_salary')
			->leftjoin('tbl_emp_non_id', 'tbl_nonid_salary.emp_id', '=', 'tbl_emp_non_id.emp_id')
			->leftjoin('tbl_emp_non_id_cancel', function ($join) use ($current_date) {
				$join->on("tbl_emp_non_id_cancel.emp_id", "=", "tbl_nonid_salary.emp_id")
					->where('tbl_emp_non_id_cancel.cancel_date', '<', $current_date);
			})
			->leftjoin('tbl_emp_type as et', function ($join) {
				$join->on('et.id', "=", "tbl_emp_non_id.emp_type_code");
			})
			->where('tbl_emp_non_id.for_which', 1)
			->where('tbl_nonid_salary.is_first_entry', '!=', 1)
			->orderBy('tbl_nonid_salary.id', 'desc')
			->select('tbl_nonid_salary.console_salary', 'tbl_nonid_salary.effect_date', 'tbl_nonid_salary.basic_salary', 'tbl_nonid_salary.gross_salary', 'tbl_nonid_salary.nara_tion', 'tbl_nonid_salary.id', 'tbl_emp_non_id.emp_name', 'tbl_emp_non_id.emp_name', 'tbl_emp_non_id.sacmo_id', 'tbl_emp_non_id.emp_type_code', 'tbl_emp_non_id_cancel.cancel_date', 'et.type_name')
			->get();
		return view('admin.employee.manage_non_id_salary', $data);
	}


	public function create()
	{
		
		$data = array();
		$salaryPlusItems = DB::select( DB::raw("SELECT item_id,items_name FROM tbl_plus_items"));
		$salaryMinusItems = DB::select( DB::raw("SELECT item_id,items_name FROM tbl_minus_items"));
		$salaryExtraAllowanceItems = DB::select( DB::raw("SELECT id,type_name FROM extra_allowance_type"));
		$data['branches'] 		    = DB::table('tbl_branch')->where('status',1)->get();
		$data['transections'] 		= DB::table('tbl_transections')->where('transaction_status',1)->where('is_effect_salary',1)->get();
		$data['id'] 					= '';
		$data['emp_id'] 				= '';
		$data['letter_date'] 			= date("Y-m-d");
		$data['sarok_no'] 				= rand();
		$data['basic_salary'] 			= 0;
		$data['npa_a'] 					= 0;
		$data['motor_a'] 				= 0;
		$data['mobile_a'] 				= 0;
		$data['gross_salary'] 			= 0;
		$data['nara_tion'] 				= '';
		$data['medical_a'] 				= 0;
		$data['internet_a'] 			= 0;
		$data['f_allowance'] 			= 0;
		$data['field_a'] 				= 0;
		$data['convence_a'] 			= 0;
		$data['maintenance_a'] 			= 0;
		$data['is_consolidated'] 		= 0;
		$data['house_rent'] 			= 0;
		$data['is_field_reduce'] 		= 0;
		$data['console_salary'] 		= 0;
		$data['br_code'] 				= '';
		$data['emp_name'] 				= '';
		$data['designation_code'] 		= '';
		$data['emp_type'] 				= 2;
		$data['sacmo_id'] 				= '';
		$data['effect_date'] 			= '';
		$data['designation_name']		= '';
		$data['joining_date']			= '';
		$data['branch_name']			= '';
		$data['org_code'] 				= '181';
		//
		$data['action'] 			= '/con_salary';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= '';
		$data['mode'] 				= '';
		$data['Heading'] 			= 'Add Non ID Salary';
		$data['button_text'] 		= 'Save';
		$data['salaryPlusItems'] 		= $salaryPlusItems;
		$data['salaryMinusItems'] 		= $salaryMinusItems;
		$data['salaryExtraAllowanceItems'] 		= $salaryExtraAllowanceItems;

		$data['all_emp_type'] 		= DB::table('tbl_emp_type')->where('id', '>', 1)->where('status', 1)->get();
		return view('admin.employee.non_id_salary_form', $data);
	}
	public function check_nonid_salary_effect_date($emp_id, $effect_date)
	{
		$is_less_date = 0;
		$results = DB::table('tbl_nonid_salary')
			->where('emp_id', $emp_id)
			->where('effect_date', $effect_date)
			->select('emp_id')
			->first();
		if ($results) {
			$is_less_date = 1;
		}
		echo $is_less_date;
	}
	public function con_salary_edit($id, $effect_date)
	{
		/* $action_id = 3;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		} */

		$sdata = array();
		$result = DB::table('tbl_nonid_salary')
			->leftjoin('tbl_emp_non_id', 'tbl_emp_non_id.emp_id', '=', 'tbl_nonid_salary.emp_id')
			->leftjoin('tbl_nonid_official_info', function ($join) use ($effect_date) {
				$join->on("tbl_nonid_salary.emp_id", "=", "tbl_nonid_official_info.emp_id")
					->where('tbl_nonid_official_info.joining_date', DB::raw("(SELECT 
																				  max(tbl_nonid_official_info.joining_date)
																				  FROM tbl_nonid_official_info 
																				   where tbl_nonid_salary.emp_id = tbl_nonid_official_info.emp_id AND   tbl_nonid_official_info.joining_date >= $effect_date
																				  )"));
			})
			->leftjoin('tbl_emp_type', 'tbl_emp_type.id', '=', 'tbl_emp_non_id.emp_type_code')
			->leftjoin('tbl_branch as obr', 'obr.br_code', '=', 'tbl_nonid_official_info.br_code')
			->leftjoin('tbl_branch as abr', 'abr.br_code', '=', 'tbl_nonid_official_info.after_trai_br_code')
			->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_nonid_official_info.designation_code')
			->where('tbl_nonid_salary.id', $id)
			->select('tbl_nonid_salary.*', 'tbl_emp_non_id.sacmo_id', 'tbl_emp_non_id.emp_name', 'tbl_emp_non_id.emp_type_code', 'tbl_emp_non_id.joining_date', 'tbl_designation.designation_name', 'obr.branch_name', 'abr.branch_name as after_trai_branch_name', 'tbl_nonid_official_info.after_trai_br_code', 'tbl_emp_type.is_field_reduce')
			->first();


		$sdata['emp_id']			= $result->emp_id;
		$sdata['is_field_reduce']	= $result->is_field_reduce;
		$sdata['sacmo_id']			= $result->sacmo_id;
		$sdata['emp_type']			= $result->emp_type_code;
		$sdata['emp_name']			= $result->emp_name;
		$sdata['designation_name']	= $result->designation_name;
		$sdata['joining_date']		= $result->joining_date;
		$sdata['branch_name']		= $result->branch_name;
		$sdata['effect_date']		= $result->effect_date;
		$sdata['console_salary']	= $result->console_salary;
		$sdata['basic_salary']		= $result->basic_salary;
		$sdata['is_Consolidated']	= $result->is_Consolidated;
		$sdata['npa_a']					= 0;
		$sdata['motor_a']				= 0;
		$sdata['f_allowance']			= 0;
		$sdata['internet_a']			= 0;
		$sdata['maintenance_a']			= 0;
		$sdata['medical_a']				= 0;
		$sdata['house_rent']			= 0;
		$sdata['convence_a']			= 0;
		$sdata['field_a']				= 0;
		$sdata['mobile_a']				= 0;


		if (!empty($result->plus_item_id)) {
			$plus_item_id1 =   explode(',', $result->plus_item_id);
			$item_plus_amt1 =   explode(',', $result->item_plus_amt);
			//print_r($item_plus_amt);
			foreach ($plus_item_id1 as $key => $v_plus) {
				//echo $key;
				if ($v_plus == 1) {
					$sdata['npa_a']			     = $item_plus_amt1[$key];
				} else if ($v_plus == 2) {
					$sdata['f_allowance']		 = $item_plus_amt1[$key];
				} else if ($v_plus == 3) {
					$sdata['house_rent']		 = $item_plus_amt1[$key];
				} else if ($v_plus == 4) {
					$sdata['motor_a']		     = $item_plus_amt1[$key];
				} else if ($v_plus == 5) {
					$sdata['medical_a']		     = $item_plus_amt1[$key];
				} else if ($v_plus == 6) {
					$sdata['internet_a']		 = $item_plus_amt1[$key];
				} else if ($v_plus == 7) {
					$sdata['convence_a']		 = $item_plus_amt1[$key];
				} else if ($v_plus == 8) {
					$sdata['field_a']		     = $item_plus_amt1[$key];
				} else if ($v_plus == 9) {
					$sdata['mobile_a']		     = $item_plus_amt1[$key];
				} else if ($v_plus == 10) {
					$sdata['maintenance_a']		 = $item_plus_amt1[$key];
				}
			}
		}

		$sdata['gross_salary']		= $result->gross_salary;
		$sdata['nara_tion']			= $result->nara_tion;
		$sdata['after_trai_branch_name'] = $result->after_trai_branch_name;
		// 
		$sdata['action'] 				= "/con_salary/$id";
		$sdata['method'] 				= 'POST';
		$sdata['mode'] 					= 'edit';
		$sdata['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />";
		$sdata['Heading'] 				= 'Edit Employee Non Id';
		$sdata['button_text'] 			= 'Update';
		//
		$sdata['all_emp_type'] 		= DB::table('tbl_emp_type')->where('id', '>', 1)->where('status', 1)->get();
		return view('admin.employee.non_id_salary_form', $sdata);
	}
	public function get_nonemployee_info($emp_id, $letter_date)
	{
		$data = array();
		if($emp_id > 200000){
			$max_sarok = DB::table('tbl_master_tra as m')
							->where('m.emp_id', '=', $emp_id)
							->where('m.letter_date', '=', function ($query) use ($emp_id, $letter_date) {
								$query->select(DB::raw('max(letter_date)'))
									->from('tbl_master_tra')
									->where('emp_id', $emp_id)
									->where('letter_date', '<=', $letter_date);
							})
							->select('m.emp_id', DB::raw('max(m.sarok_no) as sarok_no'))
							->groupBy('emp_id')
							->first();
								
			if($max_sarok){
				$employee_info = DB::table('tbl_master_tra')
							->leftjoin('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'tbl_master_tra.emp_id')
							->leftjoin('tbl_department', 'tbl_department.department_id', '=', 'tbl_master_tra.department_code')
							->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_master_tra.designation_code')
							->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_master_tra.br_code')
							->leftjoin('tbl_grade_new', 'tbl_grade_new.grade_id', '=', 'tbl_master_tra.grade_code')
							->leftjoin('tbl_resignation', 'tbl_resignation.emp_id', '=', 'tbl_master_tra.emp_id')
							->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_master_tra.emp_id')
							->where('tbl_master_tra.sarok_no', $max_sarok->sarok_no)
							->where('tbl_master_tra.status', 1)
							->select('tbl_master_tra.emp_id', 'tbl_master_tra.sarok_no', 'tbl_master_tra.tran_type_no', 'tbl_master_tra.is_consolidated', 'tbl_master_tra.br_join_date', 'tbl_master_tra.next_increment_date', 'tbl_master_tra.effect_date as sa_effect_date', 'tbl_master_tra.br_code', 'tbl_master_tra.grade_code', 'tbl_master_tra.grade_effect_date', 'tbl_master_tra.grade_step', 'tbl_master_tra.department_code', 'tbl_master_tra.is_permanent', 'tbl_emp_basic_info.emp_name_eng', 'tbl_emp_basic_info.org_join_date', 'tbl_designation.designation_name', 'tbl_master_tra.basic_salary', 'tbl_master_tra.salary_br_code', 'tbl_department.department_name', 'tbl_emp_basic_info.gender', 'tbl_branch.branch_name', 'tbl_grade_new.grade_name', 'tbl_emp_photo.emp_photo', 'tbl_resignation.effect_date')
							->first();
			}
			
		}
			
				
			//dd($employee_info);
		if (!empty($employee_info)) {
			$data['emp_id'] 				=  $employee_info->emp_id;
			$data['br_code'] 				=  $employee_info->br_code;  
			$data['salary_br_code'] 		=  $employee_info->salary_br_code;  
			$data['sarok_no'] 				=  $employee_info->sarok_no;  
			$data['is_consolidated'] 		=  $employee_info->is_consolidated;  
			$data['branch_name'] 			=  $employee_info->branch_name; 
			$data['emp_name'] 				=  $employee_info->emp_name_eng; 
			$data['designation_name'] 		=  $employee_info->designation_name; 
			$data['cancel_date'] 			=  $employee_info->effect_date;
			$data['effect_date'] 			=  $employee_info->sa_effect_date;
			$data['transection'] 			=  $employee_info->tran_type_no;
			$data['letter_date'] 			=  $letter_date;
		} else {
			$data['emp_id'] 				=  '';  
			$data['emp_name'] 				=  '';
			$data['branch_name'] 			=  '';
			$data['designation_name'] 		=  ''; 
			$data['cancel_date'] 		=  ''; 
			$data['br_code'] 		=  ''; 
			$data['sarok_no'] 		=  ''; 
			$data['salary_br_code'] 		=  ''; 
			$data['transection'] 		=  ''; 
			$data['is_consolidated'] 		=  0; 
			$data['letter_date'] 		=  date("Y-m-d"); 
			$data['effect_date'] 		=  date("Y-m-d"); 
		}
		return $data; 
	}

	public function store(Request $request)
	{
		$data = array();
		$data['sarok_no']		= $request->sarok_no;
		$data['letter_date']	= $request->effect_date;
		$data['effect_date']	= $request->effect_date;
		$data['emp_id']			= $request->emp_id;
		$data['br_code']		= $request->br_code;

		$plus_item_id	= $request->plus_item_id;
		$plus_item		= $request->plus_item;
		$minus_item_id	= $request->minus_item_id;
		$minus_item		= $request->minus_item;
		
		if($plus_item_id)
		{
			$data['plus_item_id'] 	= implode(",", $plus_item_id);   
			$data['plus_item'] 		= implode(",", $plus_item);	
		}else{
			$data['plus_item_id'] 	= '';   
			$data['plus_item'] 		= '';
		}
		
		if($minus_item_id)
		{
			$data['minus_item_id'] 	= implode(",", $minus_item_id);   
			$data['minus_item'] 	= implode(",", $minus_item);
		}else{
			$data['minus_item_id'] 	= '';   
			$data['minus_item'] 	= '';
		}
		$data['salary_basic']	= $request->salary_basic;
		$data['total_plus']		= $request->total_plus;
		$data['total_minus']	= $request->total_minus;
		$data['payable']		= $request->payable;
		$data['net_payable']	= $request->net_payable;
		$data['gross_total']	= $request->gross_total;
		$data['is_consolidated']= $request->is_consolidated;
		$data['transection']	= $request->transection;
		$data['created_by']		= Session::get('admin_id');
		
		$emp_id 						= $request->emp_id;
		$sarok_no 						= $request->sarok_no;
		$master_data['salary_br_code'] 	= $request->salary_br_code;
		$master_data['basic_salary'] 	= $request->salary_basic;  
		$master_data['is_consolidated'] 	= $request->is_consolidated;  
		
		/* echo '<pre>';
		print_r($master_data);
		echo '<pre>';
		print_r($data);
		exit; */
		DB::beginTransaction();
		try {				
			DB::table('tbl_master_tra')
            ->where('sarok_no', $sarok_no)
			->where('emp_id', $emp_id)
            ->update($master_data);
			$data['status'] = DB::table('tbl_emp_salary')->insertGetId($data);
			
			DB::commit();
			Session::put('message','Data Saved Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Updated Data');
			DB::rollback();
		}
		
		
		//$insert['status'] 		= DB::table('tbl_emp_salary')->insertGetId($data);
		//echo '<pre>';
		//print_r($insert);
		//echo '</pre>';
		//exit;
		return Redirect::to('/staff-salary');
	}

	public function update(Request $request, $id)
	{
		$sdata = array();
		$item_plus_amt = array();
		$plus_item_id = array();
		$emp_id 					= $request->emp_id;
		$sdata['effect_date']		= $request->effect_date;
		$sdata['console_salary']	= $request->console_salary;
		$sdata['basic_salary']		= $request->basic_salary;
		$sdata['gross_salary']		= $request->gross_salary;
		$sdata['is_Consolidated']		= $request->is_Consolidated;
		$sdata['nara_tion']			= $request->nara_tion;
		$sdata['updated_by'] 		= Session::get('admin_id');

		if ($request->npa_a > 0) {
			$item_plus_amt[] = $request->npa_a;
			$plus_item_id[] = 1;
		}
		if ($request->f_allowance > 0) {
			$item_plus_amt[] = $request->f_allowance;
			$plus_item_id[] =  2;
		}
		if ($request->house_rent > 0) {
			$item_plus_amt[] =  $request->house_rent;
			$plus_item_id[] =  3;
		}
		if ($request->motor_a > 0) {
			$item_plus_amt[] =  $request->motor_a;
			$plus_item_id[] =  4;
		}
		if ($request->medical_a > 0) {
			$item_plus_amt[] =  $request->medical_a;
			$plus_item_id[] =  5;
		}
		if ($request->internet_a > 0) {
			$item_plus_amt[] =  $request->internet_a;
			$plus_item_id[] =  6;
		}
		if ($request->convence_a > 0) {
			$item_plus_amt[] =  $request->convence_a;
			$plus_item_id[] =  7;
		}
		if ($request->field_a > 0) {
			$item_plus_amt[] =  $request->field_a;
			$plus_item_id[] =  8;
		}
		if ($request->mobile_a > 0) {
			$item_plus_amt[] =  $request->mobile_a;
			$plus_item_id[] =  9;
		}
		if ($request->maintenance_a > 0) {
			$item_plus_amt[] =  $request->maintenance_a;
			$plus_item_id[] =  10;
		}
		if (!empty($plus_item_id)) {
			$plus_item_id = implode(",", $plus_item_id);
		} else {
			$plus_item_id = '';
		}
		if (!empty($item_plus_amt)) {
			$item_plus_amt = implode(",", $item_plus_amt);
		} else {
			$item_plus_amt = '';
		}
		//print_r($item_plus_amt);
		$sdata['item_plus_amt']		= $item_plus_amt;
		$sdata['plus_item_id']		= $plus_item_id;

		/* 
		  echo '<pre>';
		print_r($sdata);
		 exit;    */
		//Data Update 
		DB::beginTransaction();
		try {
			/* echo '<pre>';
				print_r($sdata);
				 exit;   */
			DB::table('tbl_nonid_salary')
				->where('id', $id)
				->update($sdata);
			DB::commit();
			Session::put('message', 'Data Updated Successfully');
		} catch (\Exception $e) {

			Session::put('message', 'Error: Unable to Updated Data');
			DB::rollback();
		}
		return Redirect::to('/con_salary');
	}

	public function view_nonid_salary($id, $effect_date)
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

		$result = DB::table('tbl_nonid_salary')
			->leftjoin('tbl_emp_non_id', 'tbl_emp_non_id.emp_id', '=', 'tbl_nonid_salary.emp_id')

			->leftjoin('tbl_nonid_official_info', function ($join) use ($effect_date) {
				$join->on("tbl_nonid_salary.emp_id", "=", "tbl_nonid_official_info.emp_id")
					->where('tbl_nonid_official_info.joining_date', DB::raw("(SELECT 
																				  max(tbl_nonid_official_info.joining_date)
																				  FROM tbl_nonid_official_info 
																				   where tbl_nonid_salary.emp_id = tbl_nonid_official_info.emp_id AND   tbl_nonid_official_info.joining_date >= $effect_date
																				  )"));
			})
			->leftjoin('tbl_branch as obr', 'obr.br_code', '=', 'tbl_nonid_official_info.br_code')
			->leftjoin('tbl_branch as abr', 'abr.br_code', '=', 'tbl_nonid_official_info.after_trai_br_code')
			->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_nonid_official_info.designation_code')
			->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_emp_non_id.emp_id')
			->leftjoin('tbl_emp_type as et', function ($join) {
				$join->on('et.id', "=", "tbl_emp_non_id.emp_type_code");
			})
			->where('tbl_nonid_salary.id', $id)
			->select('tbl_nonid_salary.*', 'tbl_emp_non_id.sacmo_id', 'tbl_emp_non_id.emp_name', 'tbl_emp_non_id.emp_type_code', 'tbl_emp_non_id.joining_date', 'tbl_designation.designation_name', 'tbl_emp_non_id_cancel.cancel_date', 'et.type_name', 'et.is_field_reduce', 'obr.branch_name', 'abr.branch_name as after_trai_branch_name')
			->first();

		$sdata['emp_id']			= $result->emp_id;
		$sdata['is_field_reduce']	= $result->is_field_reduce;
		$sdata['cancel_date']		= $result->cancel_date;
		$sdata['sacmo_id']			= $result->sacmo_id;
		$sdata['type_name']			= $result->type_name;
		$sdata['emp_name']			= $result->emp_name;
		$sdata['designation_name']	= $result->designation_name;
		$sdata['joining_date']		= date("d-m-Y", strtotime($result->joining_date));
		$sdata['branch_name']		= $result->branch_name;
		$sdata['effect_date']		= $result->effect_date;
		$sdata['gross_salary']	= $result->gross_salary;
		$sdata['console_salary']	= $result->console_salary;
		$sdata['basic_salary']		= $result->basic_salary;

		$sdata['npa_a']					= 0;
		$sdata['motor_a']				= 0;
		$sdata['f_allowance']			= 0;
		$sdata['internet_a']			= 0;
		$sdata['medical_a']				= 0;
		$sdata['house_rent']			= 0;
		$sdata['convence_a']			= 0;
		$sdata['field_a']				= 0;
		$sdata['mobile_a']				= 0;
		$sdata['maintenance_a']				= 0;
		if (!empty($result->plus_item_id)) {
			$plus_item_id1 =   explode(',', $result->plus_item_id);
			$item_plus_amt1 =   explode(',', $result->item_plus_amt);
			//print_r($item_plus_amt);
			foreach ($plus_item_id1 as $key => $v_plus) {
				//echo $key;
				if ($v_plus == 1) {
					$sdata['npa_a']			     = $item_plus_amt1[$key];
				} else if ($v_plus == 2) {
					$sdata['f_allowance']		 = $item_plus_amt1[$key];
				} else if ($v_plus == 3) {
					$sdata['house_rent']		     = $item_plus_amt1[$key];
				} else if ($v_plus == 4) {
					$sdata['motor_a']		     = $item_plus_amt1[$key];
				} else if ($v_plus == 5) {
					$sdata['medical_a']		     = $item_plus_amt1[$key];
				} else if ($v_plus == 6) {
					$sdata['internet_a']		     = $item_plus_amt1[$key];
				} else if ($v_plus == 7) {
					$sdata['convence_a']		     = $item_plus_amt1[$key];
				} else if ($v_plus == 8) {
					$sdata['field_a']		     = $item_plus_amt1[$key];
				} else if ($v_plus == 9) {
					$sdata['mobile_a']		     = $item_plus_amt1[$key];
				} else if ($v_plus == 10) {
					$sdata['maintenance_a']		     = $item_plus_amt1[$key];
				}
			}
		}

		$sdata['is_Consolidated']	= $result->is_Consolidated;
		$sdata['nara_tion']			= $result->nara_tion;
		$sdata['after_trai_branch_name'] = $result->after_trai_branch_name;
		$sdata['action'] 				= "/con_salary/$id";
		$sdata['method'] 				= 'POST';
		$sdata['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />";
		$sdata['Heading'] 				= 'Edit Employee Non Id';
		$sdata['mode'] 					= 'edit';
		$sdata['button_text'] 			= 'Update';
		//
		return view('admin.employee.non_id_salary_view', $sdata);
	}
	public function get_nonid_salary_info($emp_id)
	{
		$results = DB::table('tbl_nonid_salary')
			->where('tbl_nonid_salary.emp_id', $emp_id)
			->orderBy('tbl_nonid_salary.effect_date', 'desc')
			->select('tbl_nonid_salary.console_salary', 'tbl_nonid_salary.basic_salary', 'tbl_nonid_salary.effect_date')
			->get();

		echo '<tr>';
		echo "<th>Sl</th>";
		echo "<th>Console Salary</th>";
		echo "<th>Basic Salary</th>";
		echo "<th>Duration</th>";
		echo "<th>Effect Date</th>";
		echo '</tr>';
		$i = 1;
		$next_day = date("Y-m-d");
		$to_date = date("Y-m-d");
		foreach ($results as $result) {
			$show_effect = date('d-m-Y', strtotime($result->effect_date));
			if ($i == 1) {
				$date_upto = $to_date;
			} else {
				$date_upto = $next_day;
			}
			$big_date = date_create($date_upto);
			$small_date = date_create($result->effect_date);
			$diff = date_diff($big_date, $small_date);
			echo '<tr>';
			echo "<td>$i</td>";
			echo "<td>$result->console_salary</td>";
			echo "<td>$result->basic_salary</td>";
			echo "<td style='color:blue;'>";
			printf($diff->format('%y Year %m Month %d Day'));
			echo "</td>";
			echo "<td>$show_effect</td>";
			echo '</tr>';
			$next_day = $result->effect_date;
			$i++;
		}
	}
	public function del_nonid_salary_info($id)
	{
		DB::table('tbl_nonid_salary')
			->where('id', $id)
			->delete();
		return Redirect::to('/con_salary');
	}
}
