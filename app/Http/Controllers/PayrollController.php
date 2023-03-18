<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;

//session_start();

class PayrollController extends Controller
{
	public function __construct()
	{
		//$this->middleware("CheckUserSession");
	}
	
	public function index(Request $request)
	{

		$data = array();
		return view('admin.payroll.payroll_master',$data);

			$payroll_heads 	= 		DB::table('payroll_head')
										->where('active_status', '=', 1)
										->get(); 
							
			$data['payroll_heads_plus'] 	= DB::table('payroll_head')
										->where('head_type', '=', 1)
										->where('active_status', '=', 1)
										->get(); 
			$data['payroll_heads_minus'] 	= DB::table('payroll_head')
										->where('head_type', '=', 2)
										->where('active_status', '=', 1)
										->get(); 

			//dd($payroll_heads);
			$data['branches'] 	= DB::table('tbl_branch')->orderBy('branch_name', 'ASC')->get();

			$data['upto_date'] 	= date('Y-m-d');
			$data['status']    	= 1;
			$data['br_code'] 	= '';
			$data['all_result'] = array();
		
			return view('admin.payroll.payroll_entry_from',$data);
			
			exit;
		/* ************************************************** */
		
		
	}	
	
	public function generate_payroll(Request $request) 
	{
		$data = array();
		$br_code 			= $request->input('br_code');
		$staff_type 		= $request->input('type');

		if($br_code ==9999 && $staff_type == 1)
		{
			$head_for = 1;
		}elseif($br_code ==9999 && $staff_type == 2)
		{
			$head_for = 3;
		}elseif($br_code !=9999)
		{
			$head_for = 2;
		}
		
		//echo $head_for ;
		
		$data['branches'] 		= DB::table('tbl_branch')->orderBy('branch_name', 'ASC')->get();
		$data['loan_products'] 	= DB::table('loan_product')->orderBy('payroll_order', 'ASC')->get();
		$data['payroll_heads_plus'] 	= DB::table('payroll_head')
										->where('head_type', '=', 1)
										->where('head_for', '=', 4)
										->where('active_status', '=', 1)
										->orwhere(function($query) use ($head_for) {
											$query->where('head_for', '=', $head_for);
										})
										->get(); 
										
										
										
										
		//dd($data['payroll_heads_plus']);								
										
										
		$data['payroll_heads_minus'] 	= DB::table('payroll_head')
										->where('head_type', '=', 2)
										->where('active_status', '=', 1)
										->get(); 
		$data['projects'] 	= DB::table('tbl_project')
										->where('status', '=', 1)
										->get(); 
										
		if($br_code !='')
		{
			$salary_month 		= $request->input('salary_month');
			$salary_year 		= $request->input('salary_year');
			$staff_type 		= $request->input('type');
			$number_of_days 	= cal_days_in_month(CAL_GREGORIAN, $salary_month, $salary_year);
			$upto_date 			= $salary_year.'-'.$salary_month.'-'.$number_of_days;
			$status 	= 1;
			
			$data['salary_month'] 	= $salary_month;
			$data['salary_year'] 	= $salary_year;
			$data['status']    		= $status;
			$data['staff_type']    	= $staff_type;
			$data['br_code'] 		= $br_code;
			$data['all_result'] 	= $this->get_br_employee($br_code,$upto_date,$status,$staff_type);
		}else{
			$data['salary_month'] 	= date('m');
			$data['salary_year'] 	= date('Y');
			$data['status']    		= 1;
			$data['staff_type']    	= 1;
			$data['br_code'] 		= '';
			$data['head_for'] 		= '';
			$data['all_result'] 	= array();
		}
		return view('admin.payroll.payroll_entry_from',$data);
	}
	
	
	
	
	public function get_br_employee($br_code,$upto_date,$status,$staff_type)
	{
		$data = array();
		$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.br_join_date', '<=', $upto_date)
						->where('m.effect_date', '>', '2015-06-30')
						->where(function($query) use ($status, $upto_date) {
								if($status !=2) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $upto_date);
								} else {
									$query->Where('r.effect_date', '<=', $upto_date);
								}
							})
						->where(function($query) use ($staff_type,$br_code) {
								if($staff_type != 2) {
									$query->where('m.br_code', '=', $br_code);								
								} else {
									$query->where('m.salary_br_code', '=', 9999);
								}
							})
						
						->select('m.emp_id')
						->groupBy('m.emp_id')
						//->orderBy('m.grade_code', 'ASC')
						->orderBy(DB::raw('MIN(m.grade_code)', 'ASC'))
						//->orderBy(DB::raw('MAX(m.basic_salary)', 'DESC'))
						->orderBy('m.emp_id', 'ASC')
						->get()->toArray();
						
		
		//echo '<pre>';
		//print_r($all_result);
		//exit;
		
		$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										->where('eas.br_code', '=', $br_code)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($status, $upto_date) {
											if($status !=2) {
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $upto_date);
											} else {
												$query->Where('r.effect_date', '<=', $upto_date);
											}
										})									
										->select('eas.emp_id')
										->get()->toArray();
		$all_result1 = array_unique(array_merge($all_result,$assign_branch), SORT_REGULAR);
		if (!empty($all_result1)) {
			foreach ($all_result1 as $result) {
				$emp_id = $result->emp_id;
				$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $result->emp_id)
						->where('m.br_join_date', '=', function($query) use ($emp_id,$upto_date)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $upto_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('emp_id')
						->first();
				$data_result = DB::table('tbl_master_tra as m')
					->leftJoin('tbl_appointment_info as e', 'm.emp_id', '=', 'e.emp_id')
					->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
					->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
					->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
					->leftJoin('tbl_zone as z', 'a.zone_code', '=', 'z.zone_code')
					->where('m.sarok_no', '=', $max_sarok->sarok_no)
					->select('e.emp_name','e.joining_date','m.br_join_date','m.br_code','m.salary_br_code','a.area_code','z.zone_code','m.designation_code','d.designation_name','b.branch_name','m.basic_salary','m.effect_date','m.is_permanent','m.grade_code')
					->first();
				$assign_designation = DB::table('tbl_emp_assign as ea')
											->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
											->where('ea.emp_id', $result->emp_id)
											->where('ea.status', '!=', 0)
											->where('ea.select_type', '=', 5)
											->select('ea.emp_id','ea.open_date','de.designation_name')
											->first();
				if(!empty($assign_designation)) {
					$asign_desig = $assign_designation->designation_name;
					$desig_open_date = $assign_designation->open_date;
				} else {
					$asign_desig = '';
					$desig_open_date =  '';
				}
				$assign_branch = DB::table('tbl_emp_assign as ea')
											->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code')
											->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
											->where('ea.emp_id', $result->emp_id)
											->where('ea.open_date', '<=', $upto_date)
											->where('ea.status', '!=', 0)
											->where('ea.select_type', '=', 2)
											->select('ea.emp_id','ea.open_date','ea.br_code','br.branch_name','ar.area_name')
											->first();
				if(!empty($assign_branch)) {
					$result_br_code = $assign_branch->br_code;
					$asign_branch_name = $assign_branch->branch_name;
					$asign_area_name = $assign_branch->area_name;
					$asign_open_date = date('d M Y',strtotime($assign_branch->open_date));
				} else {
					$result_br_code = $data_result->br_code;
					$asign_branch_name = '';
					$asign_area_name =  '';
					$asign_open_date =  '';
				}
				if ($result_br_code == $br_code && $staff_type == 1) {	
					if($data_result->salary_br_code == 9999 && $data_result->br_code == 9999 ){
						$emp_ho_bo  = 1; //HO
					}else{
						$emp_ho_bo  = 2; //BO
					}
					$basic_info 	= $this->get_basic_salary($emp_id,$data_result->br_join_date,$data_result->effect_date,$data_result->basic_salary);

					$payroll_heads_plus = DB::table('payroll_head')
										->where('head_type', '=', 1)
										->where('active_status', '=', 1)
										->get(); 
					$payroll_heads_minus= DB::table('payroll_head')
										->where('head_type', '=', 2)
										->where('active_status', '=', 1)
										->get(); 
					
					$plus_allowance 	= array();
					foreach($payroll_heads_plus as $payroll_head_plus)
					{
						$plus_allowance[]  = $this->get_allowance_value($upto_date,$payroll_head_plus->pay_head_id,$result->emp_id,$emp_ho_bo,$data_result->designation_code,$data_result->grade_code,$data_result->is_permanent,$basic_info['basic_salary']);
					}
					
					//print_r($plus_allowance);
					
					$minus_allowance 	= array();
					foreach($payroll_heads_minus as $payroll_head_minus)
					{
						$minus_allowance[]  = $this->get_allowance_value($upto_date,$payroll_head_minus->pay_head_id,$result->emp_id,$emp_ho_bo,$data_result->designation_code,$data_result->grade_code,$data_result->is_permanent,$basic_info['basic_salary']);
					}

					$data[] = array(
						'emp_id' 				=> $result->emp_id,
						'emp_name_eng'      	=> $data_result->emp_name,
						'org_join_date'     	=> $data_result->joining_date,
						'br_join_date'     		=> $data_result->br_join_date,
						'designation_name'  	=> $data_result->designation_name,
						'branch_name'      		=> $data_result->branch_name,
						'br_code'      			=> $result_br_code,
						'salary_br_code'      	=> $data_result->salary_br_code,
						'area_code'      		=> $data_result->area_code,
						'zone_code'      		=> $data_result->zone_code,
						'designation_code'      => $data_result->designation_code,
						'grade_code'      		=> $data_result->grade_code,
						'is_permanent'      	=> $data_result->is_permanent,
						'basic_salary'     		=> $basic_info['basic_salary'],
						'is_breaking'      		=> $basic_info['is_breaking'],
						'arrear_basic'      	=> $basic_info['arrear_basic'],
						'is_arrear'      		=> $basic_info['is_arrear'],
						'plus_allowance'      	=> $plus_allowance,
						'minus_allowance'      	=> $minus_allowance
					);
		
				}else if(($staff_type == 2) && ($data_result->salary_br_code == 9999) && ($result_br_code != 9999))
				{
					if($data_result->salary_br_code == 9999 && $data_result->br_code == 9999 ){
						$emp_ho_bo  = 1; //HO
					}else{
						$emp_ho_bo  = 2; //BO
					}
					$basic_info 	= $this->get_basic_salary($emp_id,$data_result->br_join_date,$data_result->effect_date,$data_result->basic_salary);
					$payroll_heads_plus = DB::table('payroll_head')
										->where('head_type', '=', 1)
										->where('active_status', '=', 1)
										->get(); 
					$payroll_heads_minus= DB::table('payroll_head')
										->where('head_type', '=', 2)
										->where('active_status', '=', 1)
										->get(); 
					
					$plus_allowance 	= array();
					foreach($payroll_heads_plus as $payroll_head_plus)
					{
						$plus_allowance[]  = $this->get_allowance_value($upto_date,$payroll_head_plus->pay_head_id,$result->emp_id,$emp_ho_bo,$data_result->designation_code,$data_result->grade_code,$data_result->is_permanent,$basic_info['basic_salary']);
					}
					$minus_allowance 	= array();
					foreach($payroll_heads_minus as $payroll_head_minus)
					{
						$minus_allowance[]  = $this->get_allowance_value($upto_date,$payroll_head_minus->pay_head_id,$result->emp_id,$emp_ho_bo,$data_result->designation_code,$data_result->grade_code,$data_result->is_permanent,$basic_info['basic_salary']);
					}
					$data[] = array(
						'emp_id' 				=> $result->emp_id,
						'emp_name_eng'      	=> $data_result->emp_name,
						'org_join_date'     	=> $data_result->joining_date,
						'br_join_date'     		=> $data_result->br_join_date,
						'designation_name'  	=> $data_result->designation_name,
						'branch_name'      		=> $data_result->branch_name,
						'br_code'      			=> $result_br_code,
						'salary_br_code'      	=> $data_result->salary_br_code,
						'area_code'      		=> $data_result->area_code,
						'zone_code'      		=> $data_result->zone_code,
						'designation_code'      => $data_result->designation_code,
						'grade_code'      		=> $data_result->grade_code,
						'is_permanent'      	=> $data_result->is_permanent,
						'basic_salary'     		=> $basic_info['basic_salary'],
						'is_breaking'      		=> $basic_info['is_breaking'],
						'arrear_basic'      	=> $basic_info['arrear_basic'],
						'is_arrear'      		=> $basic_info['is_arrear'],
						'plus_allowance'      	=> $plus_allowance,
						'minus_allowance'      	=> $minus_allowance
					);
				}					
			}				
		}
		return $data;
	}
	
	
	
	public function get_allowance_value($upto_date, $pay_head_id,$emp_id,$emp_ho_bo,$emp_designation,$emp_grade,$emp_is_permanent,$emp_basic)
	{
		$infos = DB::table('payroll_head')->where('pay_head_id', '=', $pay_head_id)->first();
		$calculation_method = $infos->calculation_method;
		if($calculation_method == 1)
		{
			//if($infos->is_regular_salary >0) { 
			if($emp_id < 200000) { 
				if($infos->persentage_fixed == 1 && $emp_is_permanent == 2)
				{
					if($emp_ho_bo == 1)
					{
						$amount = round(($emp_basic * $infos->ho_persentage/100));
					}
					else{
						$amount = round(($emp_basic * $infos->bo_persentage/100));
					}
					
				}
				else if($infos->persentage_fixed == 2 && $emp_is_permanent == 2)
				{
					if($emp_ho_bo == 1)
					{
						$amount = $infos->ho_fixed;
					}else{
						$amount = $infos->bo_fixed;
					}
				}								
				else{
					$amount = 0;
				}
			}else{

					$salary_infos = DB::table('tbl_emp_salary')
							->where('emp_id', '=', $emp_id)
							->orderBy('sarok_no', 'DESC')
							->select('plus_item_id','plus_item')
							->first();
				
					$plus_item_id 				= explode(",",$salary_infos->plus_item_id);
					$plus_item_amount  			= explode(",",$salary_infos->plus_item);
					$salary_amount_array		= array_combine($plus_item_id,$plus_item_amount);
					
					if(array_key_exists($pay_head_id,$salary_amount_array))
					{
						$amount = $salary_amount_array[$pay_head_id];
					}
					else{
						$amount = 0;
					}
				
				
			}
		}
		else if($calculation_method == 2)
		{
			$infos = DB::table('tbl_salary_plus')
							->where('designation_for', '=', $emp_designation)
							->where('item_name', '=', $infos->is_regular_salary)
							->select('fixed_amount')
							->first();
			if($infos)
			{
				$amount = $infos->fixed_amount;
			}else{
				$amount = 0;
			}
		}
		else if($calculation_method == 10) // LOAN
		{
			$loan_product_code 		= 1;
			$first_date = date("Y-m-01", strtotime($upto_date));
			$infos = DB::table('loan as loan')
					->leftJoin('loan_schedule as schedule', 'schedule.loan_id', '=', 'loan.loan_id')
					->where('loan.emp_id', '=', $emp_id)
					->where('loan.loan_product_code', '=', $loan_product_code)
					->where('loan.loan_status', '=', 1)
					->where('schedule.repayment_date', '>=', $first_date)
					->where('schedule.repayment_date', '<=', $upto_date)
					//->whereMonth('schedule.repayment_date', '=', '02')
					//->whereYear('schedule.repayment_date', '=', '2021')
					->where('schedule.status', '=', 'Not Paid')
					->select('schedule.principal_payable','schedule.interest_payable')
					->first();
			dd($infos);
		}
		
		
		
		
		
		
		
		
		
		
		
		
		else if($calculation_method == 3)
		{
			$amount = 0;
		}
		else if($calculation_method == 4)
		{
			$amount = 0;
		}
		else if($calculation_method == 5)
		{
			$infos = DB::table('tax_config')->where('emp_id', '=', $emp_id)->first();
			$amount = $infos->tax_amount; 
		}
		else if($calculation_method == 6)
		{
			$amount = 0;
		}
		else if($calculation_method == 7)
		{
			$amount = 0;
		}
		else if($calculation_method == 8)
		{
			if($emp_ho_bo ==1)
			{
				$grades 					= explode(",",$infos->grades);
				$grades_amount  			= explode(",",$infos->grades_amount);
				$grade_amount_array			= array_combine($grades,$grades_amount);
				
				$designations 		 		= explode(",",$infos->designations);
				$designation_amount  		= explode(",",$infos->designation_amount);
				$designation_amount_array	= array_combine($designations,$designation_amount);

				$grade_amount_array		 	= array_combine($grades,$grades_amount);
				$designation_amount_array	= array_combine($designations,$designation_amount);
				
				if(array_key_exists($emp_grade,$grade_amount_array))
				{
					$amount = $grade_amount_array[$emp_grade];
				}
				elseif(array_key_exists($emp_designation,$designation_amount_array))
				{
					$amount = $designation_amount_array[$emp_designation];
				}
				else{
					$amount = 0;
				}
			}
			elseif($emp_ho_bo == 2)
			{
				$amount = 0;
			}
		}
		else if($calculation_method == 0)
		{
			$amount = 0;
		}
		
		return $amount;
	}
	
	
	
	
	
	
	
	
	
	
	public function get_basic_salary($emp_id,$br_join_date,$effect_date,$regular_basic_salary)
	{
		$number_of_days 		= cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
		$month_open_date 		= date('Y-m-01');
		$month_close_date 		= date('Y-m-'.$number_of_days);
		
		if($effect_date <= $month_open_date && $br_join_date <= $month_open_date)
		{
			$basic_salary 		= $regular_basic_salary;
			$is_breaking 		= 0;
			$breakdown_basic    = 0; 
		}else if($br_join_date > $month_open_date && $br_join_date == $effect_date)
		{
			$date1 = date_create($month_open_date);
			$date2 = date_create($br_join_date);
			$diff  = date_diff($date1,$date2);
			$days  = $diff->format("%a");
			$calculation_of_basic = $number_of_days - $days;
			$basic_salary = round(($regular_basic_salary * $calculation_of_basic ) / $number_of_days);
			$is_breaking 	= 0;
			$breakdown_basic= 0;
		}
		else if($effect_date > $month_open_date && $br_join_date < $month_open_date)
		{
			// IMMIDIATE LAST DATA FROM MASTAR
			$immidiate_last_info 	= DB::table('tbl_master_tra')
										->where('emp_id', '=', $emp_id)
										->where('basic_salary', '<', $regular_basic_salary)
										->orderBy('basic_salary', 'DESC')
										->first();
			$immidiate_last_basic = $immidiate_last_info->basic_salary;	
			$date1 			= date_create($effect_date);
			$date2 			= date_create($month_open_date);
			$diff  			= date_diff($date1,$date2);
			$pre_days  		= $diff->format("%a");
			$post_days 		= $number_of_days - $pre_days;
			$basic_salary 	= ($regular_basic_salary * $post_days ) / $number_of_days;
			$breakdown_basic= round(($immidiate_last_basic * $pre_days ) / $number_of_days);
			$is_breaking 	= 1;
		}else{
			$basic_salary 		= $regular_basic_salary;
			$breakdown_basic 	= 0;
			$is_breaking 		= 0;
			$arrear_basic 		= 0;
			$is_arrear 			= 0;
		}
		
		$check_arrear 	= DB::table('arrear_salary')
							->where('arrear_to_pay_month', '>=', $month_open_date)
							->where('arrear_to_pay_month', '<=', $month_close_date)
							->where('arrear_emp_id', $emp_id)
							->where('paid_status', '=', 0)
							->first(); 
		if($check_arrear)
		{
			$arrear_basic 	= $check_arrear->arrear_paid_basic;
			$is_arrear 		= 1;
		}
		else{
			$is_arrear 		= 0;
			$arrear_basic 	= 0;
		}


		$is_basic_effect 	= DB::table('tbl_extra_deduction')
								->where('month_year', '>=', $month_open_date)
								->where('emp_id', $emp_id)
								->where('type_id', '=', 7)
								->first(); 

		
		if($is_basic_effect)
		{
			$emp_basic_salary = ($basic_salary - $is_basic_effect->monthly_pay);
		}else{
			$emp_basic_salary = $basic_salary;
		}
		
		if($emp_id == 2333)
		{
			$emp_basic_salary 	= 11280;
			$breakdown_basic 	= 0;
			$is_breaking 		= 0;
			$arrear_basic 		= 0;
			$is_arrear 			= 0;
		}

		$data['basic_salary'] 	= $emp_basic_salary;
		$data['breakdown_basic']= $breakdown_basic;
		$data['is_breaking'] 	= $is_breaking;
		$data['arrear_basic'] 	= $arrear_basic;
		$data['is_arrear'] 		= $is_arrear;
		return $data;
	}
	
	
	

	
	
	
	
	
	
	
	
	
	
	
	public function get_regular_salary_plus($head_id,$emp_ho_bo,$emp_designation,$emp_grade,$basic_salary)
	{
	
		$effect_date 	= date('Y-m-d');
		$is_permanent 	= 2;
		/*$infos 	= DB::table('tbl_salary_plus')
							->where('item_name', '=', $head_id)
							->where('ho_bo', '=', $emp_ho_bo)
							->where('status', '=', 1)
							->first(); 
							
		*/					
							
		$infos						= DB::table('tbl_salary_plus as plus')
										->join('tbl_plus_items as item', 'item.item_id', '=', 'plus.item_name')
										// DESIGNATION
										->where([
										['plus.active_from', 	'<=', $effect_date],
										['plus.active_upto', 	'>=', $effect_date],
										['plus.item_name', 	'=', $head_id],
										['plus.status', 		'=', 1],
										['plus.ho_bo', 			'=', $emp_ho_bo],
										['plus.designation_for','=', $emp_designation],
										])
										// GRADE
										->orwhere([
										['plus.active_from', 	'<=', $effect_date],
										['plus.active_upto', 	'>=', $effect_date],
										['plus.item_name', 	'=', $head_id],
										['plus.status', 		'=', 1],
										['plus.ho_bo', 			'=', $emp_ho_bo],
										['plus.designation_for','=', 0],
										['plus.emp_grade', 		'=', $emp_grade]
										])
										// HO/ BO
										->orwhere([
										['plus.active_from', 	'<=', $effect_date],
										['plus.active_upto', 	'>=', $effect_date],
										['plus.item_name', 	'=', $head_id],
										['plus.status', 		'=', 1],
										['plus.ho_bo', 			'=', $emp_ho_bo],
										['plus.epmloyee_status','=', $is_permanent],
										])
										->first();

		//echo '<pre>';
		//print_r($infos);
		//exit;
		
							
		if($infos->type == 1)
		{
			$amount = round(($basic_salary * $infos->percentage)/100);
		}else{
			$amount = $infos->fixed_amount;
		}
		
		echo $amount;
		
	}

}
