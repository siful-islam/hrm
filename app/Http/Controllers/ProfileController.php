<?php

namespace App\Http\Controllers;
use App\Mail\LeaveApplication;
use App\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Session;
use Illuminate\Support\Facades\Redirect;

use DateTime;

//session_start();

class ProfileController extends Controller
{
	public function __construct()
	{
		$this->middleware("CheckUserSession");
	}

	public function index()
	{
		$data 			= array();
		$emp_id 		= Session::get('emp_id');
		$letter_date 	= date('Y-m-d');
		
		$data['emp_mapping'] = DB::table('tbl_emp_mapping as mapping')
			->leftjoin('tbl_department as dept','mapping.current_department_id','=','dept.department_id')
			->leftjoin('tbl_unit_name as unit','mapping.unit_id','=','unit.id')
			->where('mapping.emp_id', $emp_id)
			->orderBy('mapping.id', 'desc')
			->select('dept.department_name', 'unit.unit_name', 'mapping.current_program_id')
			->first();
		
		//dd($data);
		//exit;	
			
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
				
				
			$employee_info = DB::table('tbl_master_tra')
				->leftjoin('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'tbl_master_tra.emp_id')
				->leftjoin('tbl_department', 'tbl_department.department_id', '=', 'tbl_master_tra.department_code')
				->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_master_tra.designation_code')
				->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_master_tra.br_code')
				->leftjoin('tbl_grade_new', 'tbl_grade_new.grade_code', '=', 'tbl_master_tra.grade_code')
				->leftjoin('tbl_resignation', 'tbl_resignation.emp_id', '=', 'tbl_master_tra.emp_id')
				->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_master_tra.emp_id')
				->where('tbl_master_tra.sarok_no', $max_sarok->sarok_no)
				->where('tbl_master_tra.status', 1)
				->select('tbl_master_tra.sarok_no', 'tbl_master_tra.br_join_date', 'tbl_master_tra.next_increment_date', 'tbl_master_tra.effect_date as sa_effect_date', 'tbl_master_tra.br_code', 'tbl_master_tra.grade_code', 'tbl_master_tra.grade_effect_date', 'tbl_master_tra.grade_step', 'tbl_master_tra.department_code', 'tbl_master_tra.is_permanent', 'tbl_emp_basic_info.emp_name_eng', 'tbl_emp_basic_info.org_join_date', 'tbl_designation.designation_name', 'tbl_master_tra.basic_salary', 'tbl_master_tra.salary_br_code', 'tbl_department.department_name', 'tbl_emp_basic_info.gender', 'tbl_branch.branch_name', 'tbl_grade_new.grade_name', 'tbl_emp_photo.emp_photo', 'tbl_resignation.effect_date')
				->first();

			$data['emp_id'] 				= $emp_id;
			$data['emp_name'] 				= $employee_info->emp_name_eng;
			$data['joining_date'] 			= $employee_info->org_join_date;
			$data['designation_name'] 		= $employee_info->designation_name;
			$data['department_name'] 		= $employee_info->department_name;
			$data['department_code'] 		= $employee_info->department_code;
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
			$data['org_join_date'] 			= $employee_info->org_join_date;
			$data['basic_salary'] 			= $employee_info->basic_salary;
			$data['gender'] 				= $employee_info->gender;
			$data['emp_photo'] 				= $employee_info->emp_photo;
			$data['resign_date'] 			= $employee_info->effect_date;
			$data['p_effect_date'] = DB::table('tbl_permanent')
				->where('emp_id', $emp_id)
				->select('tbl_permanent.effect_date')
				->first();
				
			

			$data['promotion'] = DB::table('tbl_promotion')
				->where('emp_id', '=', $emp_id)
				->select('emp_id', DB::raw('max(effect_date) as effect_date'))
				->groupBy('emp_id')
				->first();
		
		return view('admin.my_info.my_profile', $data);
	}

	public function leave_visit(Request $request)
	{
		$emp_id 		= Session::get('emp_id');
		$letter_date 	= date('Y-m-d');
		$data = array();
		$data['emp_id'] = $emp_id;
		$genders = DB::table('tbl_emp_basic_info')
			->where('emp_id', $emp_id)
			->select('tbl_emp_basic_info.gender')
			->first();
		$emp_gender = $genders->gender == 'Male' ? 1 : 2;
		$data['leave_types'] = DB::table('tbl_leave_type')
			->where('leave_category', 3)
			->where(function ($q) use ($emp_gender) {
				$q->where('gender_for', 3)
					->orWhere('gender_for', $emp_gender);
			})
			->select('tbl_leave_type.id', 'tbl_leave_type.type_name')
			->orderBy('tbl_leave_type.display_order', 'asc')
			->get();


		$data['leave_types_all'] = DB::table('tbl_leave_type')
			->select('tbl_leave_type.id', 'tbl_leave_type.type_name')
			->orderBy('tbl_leave_type.display_order', 'asc')
			->get();

		$data['gender'] = $emp_gender;
		$supervisor = DB::table('supervisor_mapping_ho as mapping')
					->leftJoin('supervisors as supervisor', 'supervisor.supervisors_emp_id', '=', 'mapping.supervisor_id')
					->leftJoin('tbl_designation as designation', 'designation.designation_code', '=', 'supervisor.designation_code')
					->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'mapping.emp_id')
					->where('mapping.emp_id', $emp_id)
					->where('mapping.supervisor_type', 1)
					->select('supervisor.supervisors_name', 'mapping.supervisor_id', 'designation.designation_name', 'basic.emp_name_eng', 'supervisor.supervisors_email')
					->orderBy('mapping.mapping_id', 'desc')
					->first();

		$sub_supervisors = DB::table('supervisor_mapping_ho as mapping')
			->leftJoin('supervisors as supervisor', 'supervisor.supervisors_emp_id', '=', 'mapping.supervisor_id')
			->where('mapping.emp_id', $emp_id)
			->where('mapping.supervisor_type', 2)
			->select('supervisor.supervisors_email', 'supervisor.supervisors_emp_id')
			->first();
		$data['emp_br'] = 9999;
		$data['emp_name'] 					= $supervisor->emp_name_eng;
		$data['supervisor_email'] 			= $supervisor->supervisors_email;
		if ($sub_supervisors) {
			$data['sub_supervisor_email'] 		= $sub_supervisors->supervisors_email;
			$data['sub_supervisors_emp_id'] 	= $sub_supervisors->supervisors_emp_id;
		} else {
			$data['sub_supervisor_email'] 		= '';
			$data['sub_supervisors_emp_id'] 	= '';
		}
		
		
		

		$select_fiscal_year = DB::table('tbl_financial_year')
			->where('running_status', 1)
			->first();

		$data['fiscal_year'] = DB::table('tbl_leave_balance as lib')
			->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'lib.f_year_id')
			->where('lib.emp_id', $emp_id)
			 
			->where('lib.f_year_id', $select_fiscal_year->id)
			->select('lib.*', 'fy.f_year_from', 'fy.f_year_to')
			->first();

		$data['leave_balance'] = DB::table('tbl_leave_balance')
			->where('emp_id', $emp_id)
			 
			->where('f_year_id', $select_fiscal_year->id)
			->first();
		/// full day
		$data['earn_full_day'] = DB::table('tbl_leave_history')
			->where('emp_id', $emp_id)
			 
			->where('type_id', 1)
			->where('apply_for', 1)
			//->where('leave_adjust', 1)
			->where('f_year_id', $select_fiscal_year->id)
			->sum('no_of_days');
		$data['earn_half_day'] = DB::table('tbl_leave_history')
			->where('emp_id', $emp_id)
			 
			->where('type_id', 1)
			->where('apply_for', '!=', 1)
			//->where('leave_adjust', 1)
			->where('f_year_id', $select_fiscal_year->id)
			->sum('no_of_days');

		$data['casual_full_day'] = DB::table('tbl_leave_history')
			->where('emp_id', $emp_id)
			->where('type_id', 5)
			->where('apply_for', 1)
			//->where('leave_adjust', 1)
			->where('f_year_id', $select_fiscal_year->id)
			->sum('no_of_days');
		$data['casual_half_day'] = DB::table('tbl_leave_history')
			->where('emp_id', $emp_id)
			->where('type_id', 5)
			->where('apply_for', '!=', 1)
			//->where('leave_adjust', 1)
			->where('f_year_id', $select_fiscal_year->id)
			->sum('no_of_days');
		$data['maternity'] = DB::table('tbl_leave_history')
			->where('emp_id', $emp_id)
			 
			->where('type_id', 2)
			->where('f_year_id', $select_fiscal_year->id)
			->sum('no_of_days');
		$data['quarantine'] = DB::table('tbl_leave_history')
			->where('emp_id', $emp_id)	
			->where('type_id', 4)
			->where('f_year_id', $select_fiscal_year->id)
			->sum('no_of_days');
		$data['special'] = DB::table('tbl_leave_history')
			->where('emp_id', $emp_id) 
			->where('type_id', 3)
			->where('f_year_id', $select_fiscal_year->id)
			->sum('no_of_days');

		$data['report_to'] 		= $supervisor->supervisor_id;
		$data['report_to_show'] = $supervisor->designation_name . ' [ ' . $supervisor->supervisor_id . ' - ' . $supervisor->supervisors_name  . ' ]';

		$data['branch_list'] = DB::table('tbl_branch')
			->where('status', 1)
			->orderby('branch_name', 'asc')
			->select('br_code', 'branch_name')
			->get();

		$data['destination_code'] 		= array();
		$data['action']					= "movement_application";
		$data['button']					= 'Save';
		$data['method_control'] 		= '';
		$data['purpose'] 				= '';
		$data['leave_time'] 			= 'now';
		$data['from_date'] 				= date("Y-m-d");
		$data['to_date'] 				= date("Y-m-d");
		$data['arrival_time'] 			= '';
		$data['approved'] 				= 0;
		$data['arrival_date'] 			= date("Y-m-d");
		$data['visit_type'] 			= 1;
		$data['status'] 				= 0;
		$data['mode'] 					= "";
		$data['common_date'] 			= "common_date";		
		//echo $next_leave_date = $this->next_leave_date();
		
		
		//dd($data);
		return view('admin.my_info.leave_visit', $data);
	}


	public function select_next_holiday($max_date)
	{
		$result = DB::table('tbl_holidays')
			->where('holiday_date', $max_date)
			->select('holiday_date')
			->get();
		return $result;
	}


	public function basic_info(Request $request)
	{
		/* $emp_id 		= Session::get('emp_id');
		$letter_date 	= date('Y-m-d');
		$data = array();

		$data['emp_id'] = $emp_id;



		return view('admin.my_info.basic_info', $data); */

		$emp_id 		= Session::get('emp_id');
		/* Start CV Information */
		$emp_cv_basic = DB::table('tbl_emp_basic_info')
			->where('emp_id', $emp_id)
			->first();

		$emp_cv_edu = DB::table('tbl_emp_edu_info as ed')
			->leftJoin('tbl_exam_name as en', 'ed.exam_code', '=', 'en.exam_code')
			->leftJoin('tbl_board_university as bu', 'ed.school_code', '=', 'bu.board_uni_code')
			->leftJoin('tbl_subject as sb', 'ed.subject_code', '=', 'sb.subject_code')
			->where('ed.emp_id', $emp_id)
			->orderBy('en.level_id', 'ASC')
			->get();

		$emp_cv_tra = DB::table('tbl_emp_train_info')
			->where('emp_id', $emp_id)
			->get();

		$emp_cv_exp = DB::table('tbl_emp_exp_info')
			->where('emp_id', $emp_id)
			->get();

		$emp_cv_ref = DB::table('tbl_emp_ref_info')
			->where('emp_id', $emp_id)
			->get();

		$emp_cv_photo = DB::table('tbl_emp_photo')
			->where('emp_id', $emp_id)
			->first();

		/* End CV Information */
		/* Start Timeline Information */
		$all_transaction = DB::table('tbl_master_tra as m')
			->leftJoin('tbl_transections as t', 'm.tran_type_no', '=', 't.transaction_code')
			->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
			->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
			->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
			->where('m.emp_id', $emp_id)
			->whereIn('m.tran_type_no', [1, 2, 3, 4, 8])
			->orderBy('m.sarok_no', 'DESC')
			->select('m.emp_id', 'm.letter_date', 'm.effect_date', 'm.grade_effect_date', 'm.basic_salary', 'm.designation_code', 't.transaction_name', 'b.branch_name', 'd.designation_name', 'g.grade_name')
			->get();
		//print_r($all_transaction);
		$emp_history_designation = DB::table('tbl_master_tra')
			->leftJoin('tbl_designation as des', 'des.designation_code', '=', 'tbl_master_tra.designation_code')
			->where('tbl_master_tra.emp_id', $emp_id)
			/*  ->where(function($query)
										{
											 
												$query->where('tbl_master_tra.effect_date','!=', '0000-00-00')
												->where('tbl_master_tra.effect_date','!=','1900-01-01');
										})  */
			->groupby('tbl_master_tra.designation_code', 'tbl_master_tra.effect_date')
			->orderby('tbl_master_tra.letter_date', 'asc')
			->select(DB::raw('min(tbl_master_tra.letter_date) as letter_date'), 'tbl_master_tra.designation_code', DB::raw('max(des.designation_name) as designation_name'), DB::raw('min(tbl_master_tra.effect_date) as effect_date'), DB::raw('min(tbl_master_tra.br_join_date) as br_join_date'))
			->get();
		//print_r ($emp_history_designation);
		$pre_designation_code = '';
		//$data['emp_history_designation'] = '';		

		foreach ($emp_history_designation as $v_emp_history_designation) {
			if ($v_emp_history_designation->designation_code != $pre_designation_code) {
				if (($v_emp_history_designation->effect_date == '0000-00-00') || ($v_emp_history_designation->effect_date == '1900-01-01')) {
					$data['emp_history_designation'][] = array(
						'designation_code'      => $v_emp_history_designation->designation_code,
						'designation_name'      => $v_emp_history_designation->designation_name,
						'effect_date'      => $v_emp_history_designation->br_join_date,
						'letter_date'      => $v_emp_history_designation->letter_date
					);
				} else {
					$data['emp_history_designation'][] = array(
						'designation_code'      => $v_emp_history_designation->designation_code,
						'designation_name'      => $v_emp_history_designation->designation_name,
						'effect_date'      => $v_emp_history_designation->effect_date,
						'letter_date'      => $v_emp_history_designation->letter_date
					);
				}
			}
			$pre_designation_code = $v_emp_history_designation->designation_code;
		}
		if (!empty($data['emp_history_designation'])) {
			$keys = array_column($data['emp_history_designation'], 'effect_date');
			array_multisort($keys, SORT_DESC, $data['emp_history_designation']);
		}
		/* foreach ($all_transaction as $transaction) {
			foreach ($data['emp_history_designation'] as $emp_history_designation) {
				if($transaction->designation_code == $emp_history_designation['designation_code'] ) {
					$data['emp_transaction'][] = array( 
							'transaction_name'      => $transaction->transaction_name,
							'designation_code'      => $transaction->designation_code,
							'designation_name'      => $transaction->designation_name,
							'effect_date'      => $emp_history_designation['effect_date'],
							'letter_date'      => $transaction->letter_date
						);	
				}
			}
		} */
		//print_r ($data['emp_transaction']);
		/* End Timeline Information */

		$emp_cv_view = view('admin.my_info.emp_cv')
			->with('emp_cv_basic', $emp_cv_basic)
			->with('emp_cv_edu', $emp_cv_edu)
			->with('emp_cv_tra', $emp_cv_tra)
			->with('emp_cv_exp', $emp_cv_exp)
			->with('emp_cv_ref', $emp_cv_ref)
			->with('emp_cv_photo', $emp_cv_photo)
			->with('all_transaction', $all_transaction)
			->with('emp_history_designation', $data['emp_history_designation']);

		return view('admin.admin_master')
			->with('main_content', $emp_cv_view);
	}


	/*
	version-1
	public function pay_slips(Request $request)
	{
		
		$emp_id 		= Session::get('emp_id');
		$letter_date 	= date('Y-m-d');
		$data = array();

		$data['emp_id'] = $emp_id;

		$data['basic_info'] 	= DB::table('tbl_emp_basic_info')
			->where('emp_id', $emp_id)
			->select('emp_name_eng', 'emp_id')
			->first();

		return view('admin.my_info.pay_slips', $data);
	}*/	
	// version-2
	public function pay_slips(Request $request)
	{
		$emp_id 		= Session::get('emp_id');
		$letter_date 	= date('Y-m-d');
		$data = array();

		$data['emp_id'] = $emp_id;

		$salary_months 	= DB::table('pay_sheets')
									->where('emp_id', $emp_id)
									->orderBy('pay_sheet_id', 'desc')
									->select('salary_month')
									->first();
		@$salary_months->salary_month;
		$data['salary_months']= date('m',strtotime(@$salary_months->salary_month));
		$data['salary_years']= date('Y',strtotime(@$salary_months->salary_month));
		return view('admin.my_info.pay_slips', $data);
	}
	
	public function payRollDetails(Request $request, $search_month)
	{
		$salary_month   =  date("Y-m-t", strtotime($search_month));

		if($salary_month < '2021-06-30')
		{
			$emp_id 		= Session::get('emp_id');
			$date_upto 		= date('Y-m-d');
			$salary_month   =  date("Y-m-t", strtotime($search_month));
			$data = array();
			$data['salary_month'] = date("M-Y", strtotime($search_month));
			$month = date('m', strtotime($search_month));
			$year = date('Y', strtotime($search_month));	
			$data['emp_mapping'] = DB::table('tbl_emp_mapping as mapping')
				->leftjoin('tbl_department as dept','mapping.current_department_id','=','dept.department_id')
				->leftjoin('tbl_unit_name as unit','mapping.unit_id','=','unit.id')
				->where('mapping.emp_id', $emp_id)
				->orderBy('mapping.id', 'desc')
				->select('dept.department_name', 'unit.unit_name', 'mapping.current_program_id')
				->first();

				$max_sarok = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $emp_id)
					->where('m.letter_date', '=', function ($query) use ($emp_id, $date_upto) {
						$query->select(DB::raw('max(letter_date)'))
							->from('tbl_master_tra')
							->where('emp_id', $emp_id)
							->where('letter_date', '<=', $date_upto);
					})
					->select('m.emp_id', DB::raw('max(m.sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
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
					->select('tbl_master_tra.sarok_no', 'tbl_master_tra.br_join_date', 'tbl_master_tra.next_increment_date', 'tbl_master_tra.effect_date as sa_effect_date', 'tbl_master_tra.br_code', 'tbl_master_tra.grade_code', 'tbl_master_tra.grade_effect_date', 'tbl_master_tra.grade_step', 'tbl_master_tra.department_code', 'tbl_master_tra.is_permanent', 'tbl_emp_basic_info.emp_name_eng', 'tbl_emp_basic_info.org_join_date', 'tbl_designation.designation_name', 'tbl_master_tra.basic_salary', 'tbl_master_tra.salary_br_code', 'tbl_department.department_name', 'tbl_emp_basic_info.gender', 'tbl_branch.branch_name', 'tbl_grade_new.grade_name', 'tbl_emp_photo.emp_photo', 'tbl_resignation.effect_date')
					->first();

				$data['emp_id'] 				= $emp_id;
				$data['emp_name'] 				= $employee_info->emp_name_eng;
				$data['designation_name'] 		= $employee_info->designation_name;
				$data['department_name'] 		= $employee_info->department_name;
				$data['branch_name'] 			= $employee_info->branch_name;
				$data['grade_name'] 			= $employee_info->grade_name;

				$all_pay = DB::table('pay_roll as pr')
					->leftJoin('pay_roll_details as pd', 'pr.pay_roll_id', '=', 'pd.pay_roll_id')
					->where('pd.emp_id', '=', $emp_id)
					//->where('pr.salary_month', '=', $salary_month)
					->whereRaw('MONTH(salary_month) = '.$month)
					->whereRaw('YEAR(salary_month) = '.$year)
					->select('pd.*')
					->first();

				if (!empty($all_pay) && $all_pay->salary_plus_id) {

					if ($all_pay->loan_schedule_product_id) {
						$loanCategory = DB::select(DB::raw("SELECT loan_product_name FROM loan_product WHERE loan_product_id IN($all_pay->loan_schedule_product_id)"));
						$loanCatgoryArray = array();

						foreach ($loanCategory as $loanCat) {
							$loanCatgoryArray[] = $loanCat->loan_product_name;
						}
						$loan_schedule_value_interest = array_combine(explode(",", $all_pay->loan_schedule_value_pr), explode(",", $all_pay->loan_schedule_value_int));
						$loanScheduleValueInterestArray = array();
						foreach ($loan_schedule_value_interest as $key => $value) {
							$loanScheduleValueInterestArray[] = $key + $value;
						}
						$data['salaryComponent'] = array(
							'basic_salary' => $all_pay->basic_salary,
							'salary_plus' => array_combine(explode(",", $all_pay->salary_plus_name), explode(",", $all_pay->salary_plus_value)),
							'salary_minus' => array_combine(explode(",", $all_pay->salary_minus_name), explode(",", $all_pay->salary_minus_value)),
							'other_minus' => array_combine(explode(",", $all_pay->other_minus_name), explode(",", $all_pay->other_minus_value)),
							'loan' => array_combine($loanCatgoryArray, $loanScheduleValueInterestArray)
						);
					} 
					else 
					{
						$data['salaryComponent'] = array(
							'basic_salary' => $all_pay->basic_salary,
							'salary_plus' => array_combine(explode(",", $all_pay->salary_plus_name), explode(",", $all_pay->salary_plus_value)),
							'salary_minus' => array_combine(explode(",", $all_pay->salary_minus_name), explode(",", $all_pay->salary_minus_value)),
							'other_minus' => array_combine(explode(",", $all_pay->other_minus_name), explode(",", $all_pay->other_minus_value)),
							'loan' => array()
						);
					}
						$extraAllowance = DB::select(DB::raw("
								SELECT 
									extra_allowance.extra_allowance_amount, 
									extra_allowance_type.type_name 
								FROM 
									`extra_allowance` 
									LEFT JOIN extra_allowance_type ON extra_allowance_type.id = extra_allowance.extra_allowance_type 
								WHERE 
									extra_allowance.extra_allowance_emp_id = $emp_id
						"));
						
					if(!empty($extraAllowance)){
						$data['extraAllowance']=$extraAllowance;
					}

					return view('admin.my_info.pay_slip_pv', $data);
				} else {
					echo '<center><h1>No information Found</h1></center>';
				}
		}else
		{
			
			$emp_id 				= Session::get('emp_id');
			$date_upto 				= date('Y-m-d');
			$salary_month   		= date("Y-m-t", strtotime($search_month));
			$data 					= array();
			$data['salary_month'] 	= date("M-Y", strtotime($search_month));
			$month 					= date('m', strtotime($search_month));
			$year 					= date('Y', strtotime($search_month));	
			


			$data['emp_mapping'] = DB::table('tbl_emp_mapping as mapping')
				->leftjoin('tbl_department as dept','mapping.current_department_id','=','dept.department_id')
				->leftjoin('tbl_unit_name as unit','mapping.unit_id','=','unit.id')
				->where('mapping.emp_id', $emp_id)
				->orderBy('mapping.id', 'desc')
				->select('dept.department_name', 'unit.unit_name', 'mapping.current_program_id')
				->first();

				$max_sarok = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $emp_id)
					->where('m.letter_date', '=', function ($query) use ($emp_id, $date_upto) {
						$query->select(DB::raw('max(letter_date)'))
							->from('tbl_master_tra')
							->where('emp_id', $emp_id)
							->where('letter_date', '<=', $date_upto);
					})
					->select('m.emp_id', DB::raw('max(m.sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
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
					->select('tbl_master_tra.sarok_no', 'tbl_master_tra.br_join_date', 'tbl_master_tra.next_increment_date', 'tbl_master_tra.effect_date as sa_effect_date', 'tbl_master_tra.br_code', 'tbl_master_tra.grade_code', 'tbl_master_tra.grade_effect_date', 'tbl_master_tra.grade_step', 'tbl_master_tra.department_code', 'tbl_master_tra.is_permanent', 'tbl_emp_basic_info.emp_name_eng', 'tbl_emp_basic_info.org_join_date', 'tbl_designation.designation_name', 'tbl_master_tra.basic_salary', 'tbl_master_tra.salary_br_code', 'tbl_department.department_name', 'tbl_emp_basic_info.gender', 'tbl_branch.branch_name', 'tbl_grade_new.grade_name', 'tbl_emp_photo.emp_photo', 'tbl_resignation.effect_date')
					->first();

				$data['emp_id'] 				= $emp_id;
				$data['emp_name'] 				= $employee_info->emp_name_eng;
				$data['designation_name'] 		= $employee_info->designation_name;
				$data['department_name'] 		= $employee_info->department_name;
				$data['branch_name'] 			= $employee_info->branch_name;
				$data['grade_name'] 			= $employee_info->grade_name;


			$salary_info = DB::table('pay_sheets as pay')
									->leftjoin('payroll as roll', 'roll.payroll_id', '=', 'pay.salary_code')
									->where('pay.emp_id', $emp_id)
									->where('pay.salary_month', $salary_month)
									->select('pay.*', 'roll.heads_name')
									->first();

									
			if(!empty($salary_info)) 
			{
				$data['basic_salary'] 	= $salary_info->pay_basic;
				// PLUS 
				$plus_heads_codes   = explode(',',$salary_info->plus_heads_code);	 
				$plus_heads_amounts = explode(',',$salary_info->plus_heads_amount);	
				$s_values = array();
				$s = 0;
				foreach($plus_heads_amounts as $plus_heads_amount)
				{
					if($plus_heads_amount != 0)
					{
						$plus_heads_code = $plus_heads_codes[$s];
						$plus_heads_name = DB::table('payroll_head_2')
											->where('pay_head_id', $plus_heads_code)
											->select('pay_head_name','is_view_in_payslips')
											->first();
						if($plus_heads_name->is_view_in_payslips == 1)
						{
							$s_values[$plus_heads_name->pay_head_name] = $plus_heads_amount;
						}
					}
					$s ++;
				}


							
				
				// Allowance 
				
				$allowance_codess   = explode(',',$salary_info->allowance_codes);	
				$allowance_amounts  = explode(',',$salary_info->allowance_amount);	
				$a_values = array();
				$s = 0;
				foreach($allowance_amounts as $allowance_amount)
				{
					if($allowance_amount != 0)
					{
						$allowance_codes = $allowance_codess[$s];
						$allwance_heads_name = DB::table('payroll_head_2')
											->where('pay_head_id', $allowance_codes)
											->select('pay_head_name','is_view_in_payslips')
											->first();
						if($allwance_heads_name->is_view_in_payslips == 1)
						{
							$a_values[$allwance_heads_name->pay_head_name] = $allowance_amount;
						}
					}
					$s ++;
				}
				// MINUS
				$minus_heads_codes  = explode(',',$salary_info->minus_heads_code);	
				$minus_head_amounts = explode(',',$salary_info->minus_head_amount);	
				$m_values = array();
				$m = 0;
				foreach($minus_head_amounts as $minus_head_amount)
				{
					if($minus_head_amount != 0)
					{
						$minus_heads_code = $minus_heads_codes[$m];
						$minus_heads_name = DB::table('payroll_head_2')
											->where('pay_head_id', $minus_heads_code)
											->select('pay_head_name','is_view_in_payslips')
											->first();
						if($minus_heads_name->is_view_in_payslips == 1)
						{
							$m_values[$minus_heads_name->pay_head_name] = $minus_head_amount;
						}
					}
					$m ++;
				}
				
				$data['salary_allowance']  = array_merge($s_values,$a_values);
				$data['diductions'] 		= $m_values;
				
				
				
				return view('admin.my_info.pay_slip', $data);
				
			}else
			{
				echo '<center><h1>No information Found</h1></center>';
			}
			
			
		}
		
		
	}
	
	// END Payroll version-2

	public function my_benefit(Request $request)
	{
		$emp_id 		= Session::get('emp_id');
		$date_upto 		= date('Y-m-d');
		$data['basic_info'] 	= DB::table('tbl_emp_basic_info')
			->where('emp_id', $emp_id)
			->select('emp_name_eng', 'emp_id')
			->first();
			$max_sarok = DB::table('tbl_master_tra as m')
				->where('m.emp_id', '=', $emp_id)
				->where('m.letter_date', '=', function ($query) use ($emp_id, $date_upto) {
					$query->select(DB::raw('max(letter_date)'))
						->from('tbl_master_tra')
						->where('emp_id', $emp_id)
						->where('letter_date', '<=', $date_upto);
				})
				->select('m.emp_id', DB::raw('max(m.sarok_no) as sarok_no'))
				->groupBy('emp_id')
				->first();
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
				->select('tbl_master_tra.sarok_no', 'tbl_master_tra.br_join_date', 'tbl_master_tra.next_increment_date', 'tbl_master_tra.effect_date as sa_effect_date', 'tbl_master_tra.br_code', 'tbl_master_tra.grade_code', 'tbl_master_tra.grade_effect_date', 'tbl_master_tra.grade_step', 'tbl_master_tra.department_code', 'tbl_master_tra.is_permanent', 'tbl_emp_basic_info.emp_name_eng', 'tbl_emp_basic_info.org_join_date', 'tbl_designation.designation_name', 'tbl_master_tra.basic_salary', 'tbl_master_tra.salary_br_code', 'tbl_department.department_name', 'tbl_emp_basic_info.gender', 'tbl_branch.branch_name', 'tbl_grade_new.grade_name', 'tbl_emp_photo.emp_photo', 'tbl_resignation.effect_date')
				->first();

			$data['emp_id'] 				= $emp_id;
			$data['emp_name'] 				= $employee_info->emp_name_eng;
			$data['designation_name'] 		= $employee_info->designation_name;
			$data['department_name'] 		= $employee_info->department_name;
			$data['branch_name'] 			= $employee_info->branch_name;
			$data['grade_name'] 			= $employee_info->grade_name;
		$data['emp_mapping'] = DB::table('tbl_emp_mapping as mapping')
			->leftjoin('tbl_department as dept','mapping.current_department_id','=','dept.department_id')
			->leftjoin('tbl_unit_name as unit','mapping.unit_id','=','unit.id')
			->where('mapping.emp_id', $emp_id)
			->orderBy('mapping.id', 'desc')
			->select('dept.department_name', 'unit.unit_name', 'mapping.current_program_id')
			->first();
		
		$fin_year = 2021;
		$fin_month = date("m");
		$fin_date = date("t");
		
		if ($fin_month < 7) {
			$fin_pre_year = $fin_year - 1;
		} else {
			$fin_pre_year = $fin_year;
		}
		$fin_pre_month = "07";
		
		/*			
		$data['pf_opening_infos'] 	= DB::table('pf_register')
									->where('emp_id', $emp_id)
									->where('for_month', '2020-07-30')
									//->orderBy('pf_register.for_month', 'asc')
									->first();
		$data['pf_info'] 		= DB::table('pf_register')
			->selectRaw("*, sum(self_fund) as total_self_fund, sum(org_fund) as total_org_fund, sum(interest_amount_stuff) as total_interest_amount_stuff, sum(interest_amount_org) as total_interest_amount_org, max(for_month) as for_month, closing_balance")
			->where('pf_register.emp_id', $emp_id)
			//->where('for_month', ">=", "$fin_pre_year-$fin_pre_month-01")
			//->where('for_month', "<=", "$fin_year-$fin_month-$fin_date")
			->orderBy('pf_register.for_month', 'desc')
			->first();			
		*/	
		
		$financial_year = $fin_year.'-06-30';		
	
			
		$data['pf_opening_infos'] 	= DB::table('pf_register')
									  ->where('emp_id', $emp_id)
									  ->where('for_month', $financial_year)
									  ->first();							
		
		$from_open_date = $fin_year.'-07-01';		
		$fin_year_future = $fin_year+1;
		$to_open_date = $fin_year_future.'-06-30';
		
			

		$data['pf_info'] 		= DB::table('pf_register')
								->selectRaw("*, sum(self_fund) as total_self_fund, sum(org_fund) as total_org_fund, sum(interest_amount_stuff) as total_interest_amount_stuff, sum(interest_amount_org) as total_interest_amount_org, max(for_month) as for_month, closing_balance")
								->where('pf_register.emp_id', $emp_id)
								->where('for_month', ">=", "$from_open_date")
								->where('for_month', "<=", "$to_open_date")
								->orderBy('pf_register.for_month', 'desc')
								->first();
			
		//dd($data['pf_info']);
		
		$data['pf_infos'] 	= DB::table('pf_register')  
								->where('emp_id', $emp_id)
								->orderBy('pf_register.pf_register_id', 'desc')
								->first();
								
		$data['undistribute'] 	= DB::table('pf_register')  
							  ->where('emp_id', $emp_id)
							  ->where('for_month', '2021-12-31')
							  ->first();						
								
		//dd($data['pf_infos']);						

		$data['basic_info'] 	= DB::table('tbl_emp_basic_info')
			->where('emp_id', $emp_id)
			->select('emp_name_eng', 'emp_id', 'org_join_date')
			->first();

		$data['gratuity'] 	= $this->gratuity_amount($emp_id, $data['basic_info']->org_join_date);

		$data['death_coverage'] = DB::table('death_coverage_register')
			->where('emp_id', $emp_id)
			->orderBy('death_coverage_register.death_coverage_register_id', 'desc')
			->first();


		$data['security'] = DB::table('security_register')
			->where('emp_id', $emp_id)
			->orderBy('security_register.security_register_id', 'desc')
			->first();

		$to_date 	= date('Y-m-d');
		date_default_timezone_set('Asia/Dhaka');
		$input_date = new DateTime($to_date);
		$org_date = new DateTime($data['basic_info']->org_join_date);
		$difference = date_diff($org_date, $input_date);
		$data['service_length'] =  $difference->y . " years, " . $difference->m . " months";
		
		
		//dd($data['pf_info']);
		
		//$pf_info->for_month
		
		return view('admin.my_info.my_benefit', $data);
	}


	public function gratuity_amount($emp_id, $org_join_date)
	{
		$emp_salary 	= DB::table('tbl_emp_salary')
			->where('emp_id', $emp_id)
			->select('salary_basic')
			->orderBy('tbl_emp_salary.id', 'desc')
			->first();
		$date_upto 		= new DateTime(date('Y-m-d'));
		$org_date 		= new DateTime($org_join_date);
		$differen 		= date_diff($org_date, $date_upto);
		$gratuity_year 	= $differen->y;
		$month 			= $differen->m;
		$gratuity_year >= 20 ? $gratuity_year = 20: $gratuity_year = $gratuity_year;
		$gratuity 		= DB::table('gratuity_conf')
			->where('start_year', '<=', $gratuity_year)
			->where('end_year', '>=', $gratuity_year)
			->first();
		$gra_amt_year = $emp_salary->salary_basic * $gratuity->point * $gratuity_year;
		$gra_amt_month = ($emp_salary->salary_basic * $gratuity->point * $month) / 12;
		
		if($gratuity_year >= 20)
		{
			$gratuity_amt = round($gra_amt_year);	
		}else{
			$gratuity_amt = round($gra_amt_year + $gra_amt_month);
		}
		return $gratuity_amt; 
	}



	public function my_loan(Request $request)
	{
		$emp_id 		= Session::get('emp_id');
		$data = array();
		$data['emp_id'] = $emp_id;
		$loanData = DB::table('loan as l')
			->leftJoin("loan_product as lp", 'lp.loan_product_id', '=', 'l.loan_product_code')
			->leftJoin('tbl_emp_basic_info as emp', 'l.emp_id', '=', 'emp.emp_id')
			->where('l.emp_id', $emp_id)
			->orderBy('l.loan_id', 'Desc')
			->select('emp.emp_name_eng', 'lp.loan_product_name', 'l.loan_id', 'l.application_date', 'l.loan_code', 'l.disbursement_date', 'l.first_repayment_date', 'l.emp_id', 'l.loan_amount')
			->get();


		$data['loan_types'] = DB::table('loan_category as l')
			->leftJoin("loan_product as lp", 'lp.category_id', '=', 'l.loan_category_id')
			->select('l.loan_category_id', 'l.loan_category_name', 'lp.interest_rate', 'lp.loan_product_id', 'lp.loan_product_name')
			->get();

		$info = DB::table('supervisor_mapping_ho as mapping')
			->leftJoin('supervisors as supervisor', 'supervisor.supervisors_emp_id', '=', 'mapping.supervisor_id')
			->leftJoin('tbl_designation as designation', 'designation.designation_code', '=', 'supervisor.designation_code')
			->where('mapping.emp_id', $emp_id)
			->where('mapping.supervisor_type', 1)
			->select('supervisor.supervisors_name', 'mapping.supervisor_id', 'designation.designation_name')
			->orderBy('mapping.mapping_id', 'desc')
			->first();

		$data['report_to'] 		= $info->supervisor_id;
		$data['report_to_show'] = $info->designation_name . ' [ ' . $info->supervisor_id . ' (' . $info->supervisors_name . ') ' . ' ]';
		$data['loanData'] = $loanData;

		//print_r($data['loan_types']);
		return view('admin.my_info.my_loan', $data);
	}

	public function e_approval(Request $request)
	{
		$emp_id 		= Session::get('emp_id');
		$letter_date 	= date('Y-m-d');
		$data = array();
		return view('admin.my_info.e_approval', $data);
	}



	public function my_documents(Request $request)
	{
		$emp_id 		= Session::get('emp_id');
		$letter_date 	= date('Y-m-d');
		$data = array();
		$data['emp_id'] = $emp_id;
		
		$data['emp_document_list'] 	= DB::table('tbl_edms_document')
			->leftJoin('tbl_edms_subcategory', 'tbl_edms_subcategory.subcat_id', '=', 'tbl_edms_document.subcat_id')
			->where('tbl_edms_document.emp_id', $emp_id)
			->where('tbl_edms_subcategory.is_visible_self_care', 1)
			->select('tbl_edms_document.document_name', 'tbl_edms_document.effect_date', 'tbl_edms_subcategory.subcategory_name', 'tbl_edms_document.category_id', 'tbl_edms_document.subcat_id')
			->orderBy('tbl_edms_document.effect_date', 'Desc')
			->get();
		//print_r($data['emp_document_list']);
		//exit;
		return view('admin.my_info.my_documents', $data);
	}

	public function weblinks(Request $request)
	{
		$emp_id 		= Session::get('emp_id');
		$letter_date 	= date('Y-m-d');
		$data = array();
		$data['emp_id'] = $emp_id;
		return view('admin.my_info.weblinks', $data);
	}
	
	public function leave_application_recovery_server()
	{

		
		
		/*
		
		$earn_leave_info = DB::table('leave_application')
					//->sum('no_of_days')
					->where('leave_type', 5)
					->where('emp_id', 3304)
					//->select(DB::raw("SUM(no_of_days) as leave_days"))
					->sum('no_of_days');
					//->get();
		
		
		
		echo '<pre>';
		print_r($earn_leave_info);
		exit; 
		
		
		
		$infos = DB::table('leave_application')
			->select('emp_id')
			->groupBy('emp_id') 
			->get();
				
		foreach($infos as $info)
		{
			$emp_id = $info->emp_id;
			
			$casual_infos = DB::table('leave_application')
					->where('leave_type', 1)
					->where('emp_id', $emp_id)
					->select('emp_id')
					->groupBy('emp_id') 
					->get();
			
		}
				
				
		echo '<pre>';
		print_r($infos);
		exit; 
		
		
		*/
		
		$infos = DB::table('leave_application')
				->where('application_id', '>', 106)
				//->where('sub_reported_to', '=', 3304)
				//->orderBy('application_date', 'asc')
				->get();
		
		$abc = array();
		
		foreach($infos as $info)
		{
			$history_infos = DB::table('tbl_leave_history')
					->where('id_application', $info->application_id)
					->get();
			
			
			if(count($history_infos) > 1)
			{
				$duplicate[] =  $info->application_id;
			}
			
			
		

		
			
			
			//$info->application_id;
			//$data['application_id'] 	= $info->application_id;
			//$data['emp_id'] 			= $info->emp_id;
			//$form_date 					= $info->leave_from;
			//$to_date					= $info->leave_to;
			//$data['emp_app_serial'] 	= '';
			//$data['leave_dates'] 		= '';
			//$data['sub_reported_to'] 	= '';
			//$data['stage'] 			= '';
			
			/*$form_date_new = date('Y-m-d', strtotime($form_date . "-1 days"));
			$dates = array($form_date_new);
			$actual_dates = array();
			while (end($dates) < $to_date) {
				$dates[] = date('Y-m-d', strtotime(end($dates) . ' +1 day'));
				$for_holiday_day =  date('Y-m-d', strtotime(end($dates)));
				$check_day = date('D', strtotime($for_holiday_day));
				if ($check_day != 'Fri' && $check_day != 'Sat') {
					$holiday = DB::table("tbl_holidays")
						->where("holiday_date", $for_holiday_day)
						->first();
					if (empty($holiday)) {
						$actual_dates[] = $for_holiday_day;
					}
				}
			}

			$data['leave_dates'] =	implode(",", $actual_dates);
			*/
			
			/*
			$sub = DB::table('supervisor_mapping_ho')
					->where('emp_id', '=', $info->emp_id)
					->where('supervisor_type', '=', 2)
					->orderBy('mapping_id', 'Desc')
					->first();

			if($sub)
			{
				$sub_supervisors_emp_id = $sub->supervisor_id;
			}else{
				$sub_supervisors_emp_id = '';
			}
			*/
			
			/*
			if ($sub_supervisors_emp_id == '') {
				$data['stage'] 			= 1;
			} else {
				$data['stage'] 			= 0;
			}
			*/
			
			/*$max_id = DB::table('leave_application')
				->where('emp_id', $info->emp_id)
				->max('emp_app_serial');
				
			if($max_id)
			{
				$data['emp_app_serial'] = $max_id + 1;
			}else{
				$data['emp_app_serial'] = 1;
			}*/	

			//$data['sub_reported_to']    = $sub_supervisors_emp_id;	
			
			
			//$data['first_super_action_date']    = $info->application_date;	
			//$data['super_action_date']    = $info->application_date;	
			

			/*DB::table('leave_application')
				->where('application_id', $info->application_id)
				->update($data);
		
			*/
			//$abc[]  = $data;
			
			
			/*
			$his['serial_no'] = $info->emp_app_serial;
			
			DB::table('tbl_leave_history')
				->where('id_application', $info->application_id)
				->update($his);
			*/
		}			
		echo '<pre>';
		print_r($duplicate);
		
		//echo 'Updates';
	}





	public function leave_approved(Request $request)
	{
		$emp_id 		= Session::get('emp_id');
		$letter_date 	= date('Y-m-d');
		$data = array();
		$data['leave_types_all'] = DB::table('tbl_leave_type')
			->select('tbl_leave_type.id', 'tbl_leave_type.type_name')
			->orderBy('tbl_leave_type.display_order', 'asc')
			->get();
		$data['my_stafs'] = DB::table('supervisor_mapping_ho as staff')
			->leftJoin("leave_application as app", 'app.emp_id', '=', 'staff.emp_id')
			->leftJoin('tbl_leave_type as leave_type', 'leave_type.id', '=', 'app.leave_type')
			->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'staff.emp_id')
			->where('staff.supervisor_id', $emp_id)
			->where(function ($query) {

				$query->where('app.stage', '=', 0)->Where('staff.supervisor_type', 2);
				$query->orwhere('app.stage', '=', 1)->Where('staff.supervisor_type', 1);
			})
			->orderBy('staff.emp_id', 'ASC')
			->orderBy('app.application_id', 'ASC')
			->select('staff.*','app.*','tbl_emp_photo.*','app.emp_id','leave_type.type_name')
			->get();
			
		//echo count($data['my_stafs']);
			
			
		//echo '<pre>';
		//print_r($data['my_stafs']);
		//exit;


		$data['Heading'] 		= $data['title'] = 'Approval Status';
		$data['form_date']		= date('Y-m-d');
		$data['to_date']		= date('Y-m-d');
		$data['emp_id']			= '';
		$data['activities']		= 0;
		$data['all_result'] = array();
		
		return view('admin.my_info.leave_approval', $data);
	}
	
	// QUICK ACTION
	public function leave_approval(Request $request)
	{
		$data = array();
		$application_id = $request->application_id;
		$supervisor_id = $request->supervisor_id;
		$action_id = $request->action_id;
		if ($action_id == 1) //Sub->Recomendation
		{
			$data['stage'] = 1;
			$data['first_super_emp_id'] = $supervisor_id;
			$data['first_super_action_date'] = date('Y-m-d');
			$data['first_super_action'] = 1;
			$data['sub_action_point'] 	= 1; 
		} elseif ($action_id == 2) //Sub->Reject
		{
			$data['stage'] = 1;
			$data['first_super_emp_id'] = $supervisor_id;
			$data['first_super_action_date'] = date('Y-m-d');
			$data['first_super_action'] = 2;
			$data['sub_action_point'] 	= 1; 
		} elseif ($action_id == 3) //Supervisor->Proceed
		{
			$data['stage'] = 2;
			$data['super_emp_id'] 		= $supervisor_id;
			$data['super_action_date'] 	= date('Y-m-d');
			$data['super_action'] 		= 1;
			$data['action_point'] 		= 1; 
		} elseif ($action_id == 4) //Supervisor->Reject
		{
			$data['stage'] 				= 2;
			$data['super_emp_id']		= $supervisor_id;
			$data['super_action_date'] 	= date('Y-m-d');
			$data['super_action']	 	= 2;
			$data['action_point'] 		= 1;
		} 
		// UPDATE DATA
		
		DB::table('leave_application')
			->where('application_id', $application_id)
			->update($data);
			
		//GET LAST INFO 	
		$info = DB::table('leave_application as app')
					->leftJoin('tbl_leave_type as leave_type', 'leave_type.id', '=', 'app.leave_type')
					->leftJoin('supervisors as super', 'super.supervisors_emp_id', '=', 'app.reported_to')
					->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'app.emp_id')
					->where('app.application_id', $application_id)
					->select('app.*','super.supervisors_email','basic.emp_name_eng','leave_type.type_name')
					->first();	
					
		$fiscal_year = DB::table('tbl_financial_year') 
									->where('running_status',1) 
									->first(); 			
		//dd($info);			
					
		// Sub super: Proceed :) MAIL Fire to Supervisor
		if($action_id == 1) 
		{
			//Mail			
			/*
			$mail_data['application_id'] 				= $application_id;
			$mail_data['application_date'] 				= $info->application_date;
			$mail_data['emp_name'] 						= $info->emp_name_eng;
			$mail_data['emp_id'] 						= $info->emp_id;
			$mail_data['leave_from'] 					= $info->leave_from;
			if($info->modify_cancel == 1) {
				$mail_data['leave_to'] 					= $info->prev_leave_date_to;
			}else{
				$mail_data['leave_to'] 					= $info->leave_to;
			}
			$mail_data['no_of_days'] 					= $info->no_of_days;
			$mail_data['remarks'] 						= $info->remarks;
			$mail_data['supervisor_email'] 				= $info->supervisors_email;
			$mail_data['supervisors_emp_id'] 			= $info->reported_to;
			$mail_data['sub_supervisor_email'] 			= '';
			$mail_data['sub_supervisors_emp_id'] 		= $info->sub_reported_to;
			$mail_data['modify_cancel'] 				= $info->modify_cancel;
			$mail_data['modify_remarks'] 				= $info->modify_remarks;
			$mail_data['leave_type_name'] 				= $info->type_name;
			 \Mail::send(new LeaveApplication($mail_data));
			*/
			$application_id					= $application_id;
			$application_date				= $info->application_date;
			$str 							= $info->emp_name_eng;
			$emp_name 						= str_replace(' ', '-', $str);
			$emp_id 						= $info->emp_id;
			$leave_from 					= $info->leave_from;
			if($info->modify_cancel == 1) {
				$leave_to 					= $info->prev_leave_date_to;
			}else{
				$leave_to 					= $info->leave_to;
			}
			$no_of_days						= $info->no_of_days;
			$remarks_str 					= $info->remarks;
			$remarks 						= str_replace(' ', '-', $remarks_str); 
			$supervisor_email 				= $info->supervisors_email;
			$supervisors_emp_id 			= $info->reported_to;
			$sub_supervisor_email 			= 'test@cdipbd.org'; 
			$sub_supervisors_emp_id 		= $info->sub_reported_to;
			$modify_cancel					= $info->modify_cancel;
			$modify_remarks_str				= $info->modify_remarks;
			$modify_remarks 				= str_replace(' ', '-', $modify_remarks_str); 
			$leave_type_name				= $info->type_name;	
			$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_check/'.$application_id.'/'.$application_date.'/'.$emp_name.'/'.$emp_id.'/'.$leave_from.'/'.$leave_to.'/'.$no_of_days.'/'.$remarks.'/'.$supervisor_email.'/'.$supervisors_emp_id.'/'.$sub_supervisor_email.'/'.$sub_supervisors_emp_id.'/'.$modify_cancel.'/'.$modify_remarks.'/'.$leave_type_name);
		}
		// Sub: reject in modified appliacation :) ager status e cole jabe
		elseif($action_id == 2 && $info->modify_cancel == 1) 
		{
			$prev_leave_dates = explode(",",$info->prev_leave_dates);
			$set_pre_data['leave_to'] 				= $info->prev_leave_date_to;
			$set_pre_data['leave_dates'] 			= $info->prev_leave_dates;
			$set_pre_data['no_of_days'] 			= count($prev_leave_dates);
			DB::table('leave_application')
				->where('application_id', $application_id)
				->update($set_pre_data);
		}
		// Supervisor: Approve in fresh application :) Balance Update hobe
		elseif($action_id == 3 && $info->modify_cancel == 0) 
		{
			$status = $this->set_leave_balance($application_id);
		}
		// Supervisor: Approve in modified application :) ager balance roll back and new Balance Update hobe 
		elseif($action_id == 3 && $info->modify_cancel == 1) 
		{
			// Histoty
			$prev_leave_dates 				= explode(",",$info->prev_leave_dates);
			$history['to_date'] 			= $info->prev_leave_date_to;
			$history['appr_to_date'] 		= $info->prev_leave_date_to;
			$history['modify_cancel'] 		= $info->modify_cancel;
			$history['leave_dates'] 		= $info->prev_leave_dates;
			$history['no_of_days'] 			= count($prev_leave_dates);
			$history['no_of_days_appr'] 	= count($prev_leave_dates);
			// START BALANCE ROLE BACK
			$emp_id = $info->emp_id;
			$balance_info = DB::table('tbl_leave_balance')
						->where('emp_id', $emp_id)
						->where('status', 2)
						->first();		
			if($info->leave_type == 5)
			{
				// CASUAL
				$history_add['emp_id'] 						= $info->emp_id;
				$history_add['is_application_flag'] 		= 1;
				$history_add['id_application'] 				= $application_id;
				$history_add['serial_no'] 					= $info->emp_app_serial;
				$history_add['f_year_id'] 					= $fiscal_year->id;
				$history_add['designation_code'] 			= '';
				$history_add['branch_code'] 				= '';
				$history_add['type_id'] 					= $info->leave_type; 
				$history_add['apply_for'] 					= $info->apply_for; 
				$history_add['is_pay'] 						= 1; 
				$history_add['application_date'] 			= $info->application_date; 
				$history_add['from_date'] 					= $info->leave_from; 
				$history_add['to_date'] 					= $info->leave_to; 
				$history_add['leave_dates'] 				= $info->leave_dates; 
				$history_add['no_of_days'] 					= $info->no_of_days; 
				$history_add['leave_remain'] 				= 0; 
				$history_add['remarks'] 					= $info->remarks; 
				$history_add['supervisor_id'] 				= 0; 
				$history_add['recom_desig_code'] 			= 0; 
				$history_add['approved_id'] 				= $info->reported_to;  
				$history_add['appr_desig_code'] 			= 0; 
				$history_add['sup_status'] 					= 1; 
				$history_add['appr_status'] 				= 1; 
				$history_add['appr_from_date'] 				= $info->leave_from;
				$history_add['appr_to_date'] 				= $info->leave_to;
				$history_add['sup_recom_date'] 				= ''; 
				$history_add['appr_appr_date'] 				= $info->super_action_date; 
				$history_add['no_of_days_appr'] 			= $info->no_of_days; 
				$history_add['tot_earn_leave'] 				= ''; 
				$history_add['leave_adjust'] 				= 0; //  
				$history_add['is_view'] 					= 1; 
				$history_add['for_which'] 					= 1; 
				$history_add['user_code'] 					= Session::get('admin_id');
				$prev_leave_dates = explode(",",$info->prev_leave_dates);
				$balance['casual_leave_close'] 	= $balance_info->casual_leave_close + (count($prev_leave_dates) - $info->no_of_days);
				$balance['casual_leave_close'] 	=10;
				DB::beginTransaction();
				try {				
					DB::table('tbl_leave_balance')
						->where('emp_id', $emp_id)
						->where('status', 2)
						->update($balance);	
					DB::table('tbl_leave_history')
					->where('id_application', $application_id)
					->update($history);
					DB::table('tbl_leave_history')->insert($history_add); 
					DB::commit();
					$flag = true;
				} catch (\Exception $e) {
					$flag = false;
					DB::rollback();
				}
			}
			elseif($info->leave_type == 1)
			{
				// EARN
				$balance['cum_balance_less_close_12'] 	= $balance_info->cum_balance_less_close_12 + $info->old_adjust_number;
				$balance['pre_cumulative_close'] 		= $balance_info->pre_cumulative_close + $info->prev_adjust_number;
				$balance['cum_close_balance'] 			= $balance_info->cum_close_balance + $info->prev_adjust_number;
				$balance['current_close_balance'] 		= $balance_info->current_close_balance + $info->current_adjust_number;
				$balance['no_of_days'] 					= $balance_info->no_of_days - $info->current_adjust_number;
				DB::beginTransaction();
				try {				
					DB::table('tbl_leave_balance')
						->where('emp_id', $emp_id)
						->where('status', 2)
						->update($balance);	
					DB::table('tbl_leave_history')
					->where('id_application', $application_id)
					->update($history);
					DB::commit();
					$flag = true;
				} catch (\Exception $e) {
					$flag = false;
					DB::rollback();
				}
				$status = $this->set_leave_balance($application_id);
			}
		}
		elseif($action_id == 3 && $info->modify_cancel == 2) 
		{
			$history['modify_cancel'] 			= $info->modify_cancel;
			// EARN
				$emp_id = $info->emp_id;
				$balance_info = DB::table('tbl_leave_balance')
						->where('emp_id', $emp_id)
						->where('status', 2)
						->first();
			if($info->leave_type == 1)
			{
				$balance['cum_balance_less_close_12'] 	= $balance_info->cum_balance_less_close_12 + $info->old_adjust_number;
				$balance['pre_cumulative_close'] 		= $balance_info->pre_cumulative_close + $info->prev_adjust_number;
				$balance['cum_close_balance'] 			= $balance_info->cum_close_balance + $info->prev_adjust_number;
				$balance['current_close_balance'] 		= $balance_info->current_close_balance + $info->current_adjust_number;
				$balance['no_of_days'] 					= $balance_info->no_of_days - $info->current_adjust_number;
				DB::beginTransaction();
				try {				
					DB::table('tbl_leave_balance')
						->where('emp_id', $emp_id)
						->where('status', 2)
						->update($balance);	
					DB::table('tbl_leave_history')
					->where('id_application', $application_id)
					->update($history);
					DB::commit();
					$flag = true;
				} catch (\Exception $e) {
					$flag = false;
					DB::rollback();
				}
			}
			else if($info->leave_type == 5){
				// CASUAL
				$prev_leave_dates = explode(",",$info->prev_leave_dates);
				$balance['casual_leave_close'] 	= $balance_info->casual_leave_close + $info->no_of_days;
				DB::beginTransaction();
				try {				
					DB::table('tbl_leave_balance')
						->where('emp_id', $emp_id)
						->where('status', 2)
						->update($balance);	
					DB::table('tbl_leave_history')
					->where('id_application', $application_id)
					->update($history);
					DB::commit();
					$flag = true;
				} catch (\Exception $e) {
					$flag = false;
					DB::rollback();
				}
			}
		}
		elseif($action_id == 4 && $info->modify_cancel == 1) // Supervisor: Reject in modified application :) ager status e cole jabe
		{
			$prev_leave_dates 					= explode(",",$info->prev_leave_dates);
			$set_pre_data['leave_to'] 			= $info->prev_leave_date_to;
			$set_pre_data['leave_dates'] 		= $info->prev_leave_dates;
			$set_pre_data['no_of_days'] 		= count($prev_leave_dates);
			DB::table('leave_application')
				->where('application_id', $application_id)
				->update($set_pre_data);
		}
		$action = true;
		echo json_encode($action);
	}
	
	// DETAIL ACTION
	public function leave_approve(Request $request)
	{
		$application_id 	= $request->application_id;
		$supervisor_type 	= $request->supervisor_type;
		$supervisor_id 		= $request->supervisor_id;
		$action 			= $request->action;
		$remarks 			= $request->remarks;
		$data = array();
		if ($supervisor_type == 2) {
			$data['stage'] = 1;
			$data['first_super_emp_id'] = $supervisor_id;
			$data['first_super_action_date'] = date('Y-m-d');
			$data['first_super_action'] = $action;
			$data['first_super_remarks'] = $remarks;
			$data['sub_action_point'] 	= 2;
		} elseif ($supervisor_type == 1) {

			$data['stage'] 				= 2;
			$data['super_emp_id'] 		= $supervisor_id;
			$data['super_action_date'] 	= date('Y-m-d');
			$data['super_action'] 		= $action;
			$data['super_remarks'] 		= $remarks;
			$data['action_point'] 		= 2;
		}
		DB::table('leave_application')
			->where('application_id', $application_id)
			->update($data);
		
		/* START ROLLBACK */
		$info = DB::table('leave_application as app')
					->leftJoin('tbl_leave_type as leave_type', 'leave_type.id', '=', 'app.leave_type')
					->leftJoin('supervisors as super', 'super.supervisors_emp_id', '=', 'app.reported_to')
					->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'app.emp_id')
					->where('app.application_id', $application_id)
					->select('app.*','super.supervisors_email','basic.emp_name_eng','leave_type.type_name')
					->first();	
					
		$fiscal_year = DB::table('tbl_financial_year') 
									->where('running_status',1) 
									->first(); 		
		if($supervisor_type == 2 && $action == 1)
		{
			
			/*
			//Mail
			$mail_data['application_id'] 				= $application_id;
			$mail_data['application_date'] 				= $info->application_date;
			$mail_data['emp_name'] 						= $info->emp_name_eng;
			$mail_data['emp_id'] 						= $info->emp_id;
			$mail_data['leave_from'] 					= $info->leave_from;
			if($info->modify_cancel == 1) {
				$mail_data['leave_to'] 					= $info->prev_leave_date_to;
			}else{
				$mail_data['leave_to'] 					= $info->leave_to;
			}
			$mail_data['no_of_days'] 					= $info->no_of_days;
			$mail_data['remarks'] 						= $info->remarks;
			$mail_data['supervisor_email'] 				= $info->supervisors_email;
			$mail_data['supervisors_emp_id'] 			= $info->reported_to;
			$mail_data['sub_supervisor_email'] 			= '';
			$mail_data['sub_supervisors_emp_id'] 		= $info->sub_reported_to;
			$mail_data['modify_cancel'] 				= $info->modify_cancel;
			$mail_data['modify_remarks'] 				= $info->modify_remarks;
			$mail_data['leave_type_name'] 				= $info->type_name;
			 \Mail::send(new LeaveApplication($mail_data)); 
			*/

			$application_id					= $application_id;
			$application_date				= $info->application_date;
			$str 							= $info->emp_name_eng;
			$emp_name 						= str_replace(' ', '-', $str);
			$emp_id 						= $info->emp_id;
			$leave_from 					= $info->leave_from;
			if($info->modify_cancel == 1) {
				$leave_to 					= $info->prev_leave_date_to;
			}else{
				$leave_to 					= $info->leave_to;
			}
			$no_of_days						= $info->no_of_days;
			$remarks_str 					= $info->remarks;
			$remarks 						= str_replace(' ', '-', $remarks_str); 
			$supervisor_email 				= $info->supervisors_email;
			$supervisors_emp_id 			= $info->reported_to;
			$sub_supervisor_email 			= 'test@cdipbd.org'; 
			$sub_supervisors_emp_id 		= $info->sub_reported_to;
			$modify_cancel					= $info->modify_cancel;
			$modify_remarks_str				= $info->modify_remarks;
			$modify_remarks 				= str_replace(' ', '-', $modify_remarks_str); 
			$leave_type_name				= $info->type_name;	
			$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_check/'.$application_id.'/'.$application_date.'/'.$emp_name.'/'.$emp_id.'/'.$leave_from.'/'.$leave_to.'/'.$no_of_days.'/'.$remarks.'/'.$supervisor_email.'/'.$supervisors_emp_id.'/'.$sub_supervisor_email.'/'.$sub_supervisors_emp_id.'/'.$modify_cancel.'/'.$modify_remarks.'/'.$leave_type_name);

		}
		elseif($supervisor_type == 2 && $action == 2 && $info->modify_cancel == 1)
		{
			$prev_leave_dates = explode(",",$info->prev_leave_dates);
			$set_pre_data['leave_to'] 				= $info->prev_leave_date_to;
			$set_pre_data['leave_dates'] 			= $info->prev_leave_dates;
			$set_pre_data['no_of_days'] 			= count($prev_leave_dates);
			DB::table('leave_application')
				->where('application_id', $application_id)
				->update($set_pre_data);
		}
		elseif($supervisor_type == 1 && $action == 1 && $info->modify_cancel == 0)
		{
			$status = $this->set_leave_balance($application_id);
		}
		elseif($supervisor_type == 1 && $action == 1 && $info->modify_cancel == 1)
		{
						// Histoty
			$prev_leave_dates 				= explode(",",$info->prev_leave_dates);
			$history['to_date'] 			= $info->prev_leave_date_to;
			$history['appr_to_date'] 		= $info->prev_leave_date_to;
			$history['modify_cancel'] 		= $info->modify_cancel;
			$history['leave_dates'] 		= $info->prev_leave_dates;
			$history['no_of_days'] 			= count($prev_leave_dates);
			$history['no_of_days_appr'] 	= count($prev_leave_dates);
			// START BALANCE ROLE BACK
			$emp_id = $info->emp_id;
			$balance_info = DB::table('tbl_leave_balance')
						->where('emp_id', $emp_id)
						->where('status', 2)
						->first();		
			if($info->leave_type == 5)
			{
				// CASUAL
				$history_add['emp_id'] 						= $info->emp_id;
				$history_add['is_application_flag'] 		= 1;
				$history_add['id_application'] 				= $application_id;
				$history_add['serial_no'] 					= $info->emp_app_serial;
				$history_add['f_year_id'] 					= $fiscal_year->id;
				$history_add['designation_code'] 			= '';
				$history_add['branch_code'] 				= '';
				$history_add['type_id'] 					= $info->leave_type; 
				$history_add['apply_for'] 					= $info->apply_for; 
				$history_add['is_pay'] 						= 1; 
				$history_add['application_date'] 			= $info->application_date; 
				$history_add['from_date'] 					= $info->leave_from; 
				$history_add['to_date'] 					= $info->leave_to; 
				$history_add['leave_dates'] 				= $info->leave_dates; 
				$history_add['no_of_days'] 					= $info->no_of_days; 
				$history_add['leave_remain'] 				= 0; 
				$history_add['remarks'] 					= $info->remarks; 
				$history_add['supervisor_id'] 				= 0; 
				$history_add['recom_desig_code'] 			= 0; 
				$history_add['approved_id'] 				= $info->reported_to;  
				$history_add['appr_desig_code'] 			= 0; 
				$history_add['sup_status'] 					= 1; 
				$history_add['appr_status'] 				= 1; 
				$history_add['appr_from_date'] 				= $info->leave_from;
				$history_add['appr_to_date'] 				= $info->leave_to;
				$history_add['sup_recom_date'] 				= ''; 
				$history_add['appr_appr_date'] 				= $info->super_action_date; 
				$history_add['no_of_days_appr'] 			= $info->no_of_days; 
				$history_add['tot_earn_leave'] 				= ''; 
				$history_add['leave_adjust'] 				= 0; //  
				$history_add['is_view'] 					= 1; 
				$history_add['for_which'] 					= 1; 
				$history_add['user_code'] 					= Session::get('admin_id');
				$prev_leave_dates = explode(",",$info->prev_leave_dates);
				$balance['casual_leave_close'] 	= $balance_info->casual_leave_close + (count($prev_leave_dates) - $info->no_of_days);
				DB::beginTransaction();
				try {				
					DB::table('tbl_leave_balance')
						->where('emp_id', $emp_id)
						->where('status', 2)
						->update($balance);	
					DB::table('tbl_leave_history')
					->where('id_application', $application_id)
					->update($history);
					DB::table('tbl_leave_history')->insert($history_add); 
					DB::commit();
					$flag = true;
				} catch (\Exception $e) {
					$flag = false;
					DB::rollback();
				}
			}
			elseif($info->leave_type == 1)
			{
				// EARN
				$balance['cum_balance_less_close_12'] 	= $balance_info->cum_balance_less_close_12 + $info->old_adjust_number;
				$balance['pre_cumulative_close'] 		= $balance_info->pre_cumulative_close + $info->prev_adjust_number;
				$balance['cum_close_balance'] 			= $balance_info->cum_close_balance + $info->prev_adjust_number;
				$balance['current_close_balance'] 		= $balance_info->current_close_balance + $info->current_adjust_number;
				$balance['no_of_days'] 					= $balance_info->no_of_days - $info->current_adjust_number;
				DB::beginTransaction();
				try {				
					DB::table('tbl_leave_balance')
						->where('emp_id', $emp_id)
						->where('status', 2)
						->update($balance);	
					DB::table('tbl_leave_history')
					->where('id_application', $application_id)
					->update($history);
					DB::commit();
					$flag = true;
				} catch (\Exception $e) {
					$flag = false;
					DB::rollback();
				}
				$status = $this->set_leave_balance($application_id);
			}
		}
		elseif($supervisor_type == 1 && $action == 1 && $info->modify_cancel == 2)
		{
			$history['modify_cancel'] 			= $info->modify_cancel;
			// EARN
				$emp_id = $info->emp_id;
				$balance_info = DB::table('tbl_leave_balance')
						->where('emp_id', $emp_id)
						->where('status', 2)
						->first();
			if($info->leave_type == 1)
			{
				$balance['cum_balance_less_close_12'] 	= $balance_info->cum_balance_less_close_12 + $info->old_adjust_number;
				$balance['pre_cumulative_close'] 		= $balance_info->pre_cumulative_close + $info->prev_adjust_number;
				$balance['cum_close_balance'] 			= $balance_info->cum_close_balance + $info->prev_adjust_number;
				$balance['current_close_balance'] 		= $balance_info->current_close_balance + $info->current_adjust_number;
				$balance['no_of_days'] 					= $balance_info->no_of_days - $info->current_adjust_number;
				DB::beginTransaction();
				try {				
					DB::table('tbl_leave_balance')
						->where('emp_id', $emp_id)
						->where('status', 2)
						->update($balance);	
					DB::table('tbl_leave_history')
					->where('id_application', $application_id)
					->update($history);
					DB::commit();
					$flag = true;
				} catch (\Exception $e) {
					$flag = false;
					DB::rollback();
				}
			}
			else if($info->leave_type == 5){
				// CASUAL
				$prev_leave_dates = explode(",",$info->prev_leave_dates);
				$balance['casual_leave_close'] 	= $balance_info->casual_leave_close + $info->no_of_days;
				DB::beginTransaction();
				try {				
					DB::table('tbl_leave_balance')
						->where('emp_id', $emp_id)
						->where('status', 2)
						->update($balance);	
					DB::table('tbl_leave_history')
					->where('id_application', $application_id)
					->update($history);
					DB::commit();
					$flag = true;
				} catch (\Exception $e) {
					$flag = false;
					DB::rollback();
				}
			}
		}
		elseif($supervisor_type == 1 && $action == 2 && $info->modify_cancel == 1)
		{
			$prev_leave_dates 					= explode(",",$info->prev_leave_dates);
			$set_pre_data['leave_to'] 			= $info->prev_leave_date_to;
			$set_pre_data['leave_dates'] 		= $info->prev_leave_dates;
			$set_pre_data['no_of_days'] 		= count($prev_leave_dates);
			DB::table('leave_application')
				->where('application_id', $application_id)
				->update($set_pre_data);
		}
		/* END ROLLBACK */
		$action = true;
		echo json_encode($action);
	}

	
	
	function set_leave_balance($application_id)
	{
		//Application information
		$info = DB::table('leave_application as app')
					->leftJoin('supervisors as super', 'super.supervisors_emp_id', '=', 'app.reported_to')
					->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'app.emp_id')
					->where('app.application_id', $application_id)
					->select('app.*','super.supervisors_email','basic.emp_name_eng')
					->first();
		//Active FiscalYear
		$fiscal_year = DB::table('tbl_financial_year') 
									->where('running_status',1) 
									->first(); 
		//Current Leave Balance 							
		$remaining_old	 = DB::table('tbl_leave_balance as balance')
								->where('balance.emp_id', $info->emp_id)
								->where('balance.f_year_id', $fiscal_year->id)
								->first();				
		$leave_type 		= $info->leave_type;
		$no_of_days 		= $info->no_of_days;
		$old_balance 		= $remaining_old->cum_balance_less_close_12;
		$previous_balance 	= $remaining_old->pre_cumulative_close;
		$current_balance 	= $remaining_old->current_close_balance;
		$casual_balance 	= $remaining_old->casual_leave_close;
		
		$data = array();
		$data['no_of_days'] = $no_of_days;
	
		if($leave_type == 1) // earned 
		{
			if($old_balance > 0)
			{
				if($old_balance >= $no_of_days)
				{
					$data['old_adjust_remaining'] 		= $old_balance - $no_of_days;
					$data['prev_adjust_remaining'] 		= $previous_balance;
					$data['current_adjust_remaining'] 	= $current_balance;
					$data['old_adjust_number'] 			= $no_of_days;
					$data['prev_adjust_number'] 		= 0;
					$data['current_adjust_number'] 		= 0;
					$data['no_of_days'] = 0;
				}
				else
				{
					$data['old_adjust_remaining'] 		= 0;
					$data['prev_adjust_remaining'] 		= $previous_balance;
					$data['current_adjust_remaining'] 	= $current_balance;
					$data['old_adjust_number'] 			= 0;
					$data['prev_adjust_number'] 		= 0;
					$data['current_adjust_number'] 		= 0;
					$data['no_of_days'] 				= $no_of_days - $old_balance;
				}
			}
			if($data['no_of_days'] > 0 && $previous_balance > 0)
			{
				if($previous_balance >= $data['no_of_days'])
				{
					$data['old_adjust_remaining'] 		= 0;
					$data['prev_adjust_remaining'] 		= $previous_balance - $data['no_of_days'];
					$data['current_adjust_remaining'] 	= $current_balance;
					$data['old_adjust_number'] 			= $old_balance;
					$data['prev_adjust_number'] 		= $data['no_of_days'];
					$data['current_adjust_number'] 		= 0;
					$data['no_of_days'] 				= 0;  
				}
				else{
					$data['old_adjust_remaining'] 		= 0;
					$data['prev_adjust_remaining'] 		= 0;
					$data['current_adjust_remaining'] 	= $current_balance;
					$data['old_adjust_number'] 			= 0;
					$data['prev_adjust_number'] 		= $previous_balance;
					$data['current_adjust_number'] 		= 0;
					$data['no_of_days'] 				= $data['no_of_days'] - $previous_balance;
				}
			}
			if($data['no_of_days'] > 0 && $current_balance > 0)
			{
				if($current_balance >= $data['no_of_days'])
				{
					$data['old_adjust_remaining'] 		= 0;
					$data['prev_adjust_remaining'] 		= 0;
					$data['current_adjust_remaining'] 	= $current_balance - $data['no_of_days'];
					$data['old_adjust_number'] 			= $old_balance;
					$data['prev_adjust_number'] 		= $previous_balance;
					$data['current_adjust_number'] 		= $data['no_of_days']; 
					$data['no_of_days'] 				= 0;
					
				}
				else{ 
					$data['old_adjust_remaining'] 		= 0;
					$data['prev_adjust_remaining'] 		= 0;
					$data['current_adjust_remaining'] 	= $current_balance - $data['no_of_days'];
					$data['old_adjust_number'] 			= 0;
					$data['prev_adjust_number'] 		= 0;
					$data['current_adjust_number'] 		= 0;
					$data['no_of_days'] 				= $data['no_of_days'] - $current_balance;
				}
			}
			$balance['cum_balance_less_close_12'] 	= $data['old_adjust_remaining']; 
			$balance['pre_cumulative_close'] 		= $data['prev_adjust_remaining']; 
			$balance['current_close_balance'] 		= $data['current_adjust_remaining']; 
			$balance['cum_close_balance'] 			= $data['prev_adjust_remaining']; 
			$balance['no_of_days'] 					= $remaining_old->no_of_days + $data['current_adjust_number']; 
			$balance['last_update_date'] 			= date('Y-m-d'); 
			$balance['updated_by'] 					= Session::get('admin_id');
		}
		elseif($leave_type == 5){ // casual  

			$data['casual_remaining'] 				= $casual_balance - $data['no_of_days'];
			$data['casual_adjust_number'] 			= $data['no_of_days'];
			$data['no_of_days'] 					= $data['no_of_days'];
			$balance['casual_leave_close'] 			= $data['casual_remaining'];		
			$balance['last_update_date'] 			= date('Y-m-d'); 
			$balance['updated_by'] 					= Session::get('admin_id');
			$data['old_adjust_number'] 				= 0;
			$data['prev_adjust_number'] 			= 0;
			$data['current_adjust_number'] 			= 0;
		}
		else
		{
			$balance['eid_earn_leave_open'] 		= $remaining_old->eid_earn_leave_open; 
		}

		// Balance Update
		// END BALANCE DATA SET 
		// Data-Set for History Table
		$history['emp_id'] 						= $info->emp_id;
		$history['is_application_flag'] 		= 1;
		$history['id_application'] 				= $application_id;
		$history['serial_no'] 					= $info->emp_app_serial;
		$history['f_year_id'] 					= $fiscal_year->id;
		$history['designation_code'] 			= '';
		$history['branch_code'] 				= '';
		$history['type_id'] 					= $info->leave_type; 
		$history['apply_for'] 					= $info->apply_for; 
		$history['is_pay'] 						= 1; 
		$history['application_date'] 			= $info->application_date; 
		$history['from_date'] 					= $info->leave_from; 
		$history['to_date'] 					= $info->leave_to; 
		$history['leave_dates'] 				= $info->leave_dates; 
		$history['no_of_days'] 					= $info->no_of_days; 
		$history['leave_remain'] 				= 0; 
		$history['remarks'] 					= $info->remarks; 
		$history['supervisor_id'] 				= 0; 
		$history['recom_desig_code'] 			= 0; 
		$history['approved_id'] 				= $info->reported_to;  
		$history['appr_desig_code'] 			= 0; 
		$history['sup_status'] 					= 1; 
		$history['appr_status'] 				= 1; 
		$history['appr_from_date'] 				= $info->leave_from;
		$history['appr_to_date'] 				= $info->leave_to;
		$history['sup_recom_date'] 				= ''; 
		$history['appr_appr_date'] 				= $info->super_action_date; 
		$history['no_of_days_appr'] 			= $info->no_of_days; 
		$history['tot_earn_leave'] 				= ''; 
		$history['leave_adjust'] 				= 0; //  
		$history['is_view'] 					= 1; 
		$history['for_which'] 					= 1; 
		$history['user_code'] 					= Session::get('admin_id');

		$app_adjust['old_adjust_number'] 		= 0;
		$app_adjust['prev_adjust_number'] 		= 0;
		$app_adjust['current_adjust_number'] 	= 0;

		// END HISTORY DATA SET 
		// INSERT IN HISTORY AND UPDATE LEAVE BALANCE 
		DB::beginTransaction();
		try {				
			DB::table('tbl_leave_history')->insert($history); 
			DB::table('tbl_leave_balance')
				->where('id', $remaining_old->id)
				->update($balance);
				if($leave_type == 1)
				{
					$app_adjust['old_adjust_number'] 		= $data['old_adjust_number'];
					$app_adjust['prev_adjust_number'] 		= $data['prev_adjust_number'];
					$app_adjust['current_adjust_number'] 	= $data['current_adjust_number'];
					DB::table('leave_application')
					->where('application_id', $application_id)
					->update($app_adjust);
				}
			DB::commit();
			$flag = true;
		} catch (\Exception $e) {
			$flag = false;
			DB::rollback();
		}
		// RETURN SUCCESS STATUS
		return($data);
	}
	

	// QUICK ACTION
	
	/* 
	START ROLLBACK
	public function leave_approval(Request $request)
	{
		$data = array();
		$application_id = $request->application_id;
		$supervisor_id = $request->supervisor_id;
		$action_id = $request->action_id;
		if ($action_id == 1) //Sub->Recomendation
		{
			$data['stage'] = 1;
			$data['first_super_emp_id'] = $supervisor_id;
			$data['first_super_action_date'] = date('Y-m-d');
			$data['first_super_action'] = 1;
		} elseif ($action_id == 2) //Sub->Reject
		{
			$data['stage'] = 1;
			$data['first_super_emp_id'] = $supervisor_id;
			$data['first_super_action_date'] = date('Y-m-d');
			$data['first_super_action'] = 2;
		} elseif ($action_id == 3) //Supervisor->Proceed
		{
			$data['stage'] = 2;
			$data['super_emp_id'] = $supervisor_id;
			$data['super_action_date'] = date('Y-m-d');
			$data['super_action'] = 1;
		} elseif ($action_id == 4) //Supervisor->Reject
		{
			$data['stage'] = 2;
			$data['super_emp_id'] = $supervisor_id;
			$data['super_action_date'] = date('Y-m-d');
			$data['super_action'] = 2;
		} elseif ($action_id == 5) //Executor->Execute
		{
			$data['stage'] = 3;
			$data['executor_emp_id'] = $supervisor_id;
			$data['executor_action_date'] = date('Y-m-d');
			$data['executor_action'] = 1;
		}

		$action['status'] = DB::table('leave_application')
			->where('application_id', $application_id)
			->update($data);
			
		$info = DB::table('leave_application as app')
					->leftJoin('supervisors as super', 'super.supervisors_emp_id', '=', 'app.reported_to')
					->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'app.emp_id')
					->where('app.application_id', $application_id)
					->select('app.*','super.supervisors_email','basic.emp_name_eng')
					->first();	
		if($action_id == 1)
		{
			//Mail
			$mail_data['application_id'] 				= $application_id;
			$mail_data['application_date'] 				= $info->application_date;
			$mail_data['emp_name'] 						= $info->emp_name_eng;
			$mail_data['emp_id'] 						= $info->emp_id;
			$mail_data['leave_from'] 					= $info->leave_from;
			$mail_data['leave_to'] 						= $info->leave_to;
			$mail_data['no_of_days'] 					= $info->no_of_days;
			$mail_data['remarks'] 						= $info->remarks;
			$mail_data['supervisor_email'] 				= $info->supervisors_email;
			$mail_data['supervisors_emp_id'] 			= $info->reported_to;
			$mail_data['sub_supervisor_email'] 			= '';
			$mail_data['sub_supervisors_emp_id'] 		= $info->sub_reported_to;
			\Mail::send(new LeaveApplication($mail_data));
		}
		elseif($action_id == 3)
		{
			$status = $this->set_leave_balance($application_id);
		}
		echo json_encode($action);
	}

	// DETAIL ACTION
	public function leave_approve(Request $request)
	{
		$application_id = $request->application_id;
		$supervisor_type = $request->supervisor_type;
		$supervisor_id 	= $request->supervisor_id;
		$action 		= $request->action;
		$remarks 		= $request->remarks;
		$data = array();
		if ($supervisor_type == 2) {
			$data['stage'] = 1;
			$data['first_super_emp_id'] = $supervisor_id;
			$data['first_super_action_date'] = date('Y-m-d');
			$data['first_super_action'] = $action;
			$data['first_super_remarks'] = $remarks;
		} elseif ($supervisor_type == 1) {

			$data['stage'] 				= 2;
			$data['super_emp_id'] 		= $supervisor_id;
			$data['super_action_date'] 	= date('Y-m-d');
			$data['super_action'] 		= $action;
			$data['super_remarks'] 		= $remarks;
		}
		DB::table('leave_application')
			->where('application_id', $application_id)
			->update($data);
		
		if($supervisor_type == 2 && $action == 1)
		{
			//Mail
			$info = DB::table('leave_application as app')
					->leftJoin('supervisors as super', 'super.supervisors_emp_id', '=', 'app.reported_to')
					->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'app.emp_id')
					->where('app.application_id', $application_id)
					->select('app.*','super.supervisors_email','basic.emp_name_eng')
					->first();
			$mail_data['application_id'] 				= $application_id;
			$mail_data['application_date'] 				= $info->application_date;
			$mail_data['emp_name'] 						= $info->emp_name_eng;
			$mail_data['emp_id'] 						= $info->emp_id;
			$mail_data['leave_from'] 					= $info->leave_from;
			$mail_data['leave_to'] 						= $info->leave_to;
			$mail_data['no_of_days'] 					= $info->no_of_days;
			$mail_data['remarks'] 						= $info->remarks;
			$mail_data['supervisor_email'] 				= $info->supervisors_email;
			$mail_data['supervisors_emp_id'] 			= $info->reported_to;
			$mail_data['sub_supervisor_email'] 			= '';
			$mail_data['sub_supervisors_emp_id'] 		= $info->sub_reported_to;
			\Mail::send(new LeaveApplication($mail_data));
		}elseif($supervisor_type == 1 && $action == 1)
		{
			$status = $this->set_leave_balance($application_id);
			
		}
		
		$action = true;
		echo json_encode($action);
	}
	
	
	function set_leave_balance($application_id)
	{
		//Application information
		$info = DB::table('leave_application as app')
					->leftJoin('supervisors as super', 'super.supervisors_emp_id', '=', 'app.reported_to')
					->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'app.emp_id')
					->where('app.application_id', $application_id)
					->select('app.*','super.supervisors_email','basic.emp_name_eng')
					->first();
		//Active FiscalYear
		$fiscal_year = DB::table('tbl_financial_year') 
									->where('running_status',1) 
									->first(); 
		//Current Leave Balance 							
		$remaining_old	 = DB::table('tbl_leave_balance as balance')
								->where('balance.emp_id', $info->emp_id)
								->where('balance.f_year_id', $fiscal_year->id)
								->first();				
		$leave_type 		= $info->leave_type;
		$no_of_days 		= $info->no_of_days;
		$old_balance 		= $remaining_old->cum_balance_less_close_12;
		$previous_balance 	= $remaining_old->pre_cumulative_close;
		$current_balance 	= $remaining_old->current_close_balance;
		$casual_balance 	= $remaining_old->casual_leave_close;
		//
		$data = array();
		$data['no_of_days'] = $no_of_days;
		if($leave_type == 1) // earned 
		{
			if($old_balance > 0)
			{
				if($old_balance >= $no_of_days)
				{
					$data['old_adjust_remaining'] 		= $old_balance - $no_of_days;
					$data['prev_adjust_remaining'] 		= $previous_balance;
					$data['current_adjust_remaining'] 	= $current_balance;
					$data['old_adjust_number'] 			= $old_balance;
					$data['prev_adjust_number'] 		= 0;
					$data['current_adjust_number'] 		= 0;
					$data['no_of_days'] = 0;
				}
				else
				{
					$data['old_adjust_remaining'] 		= 0;
					$data['prev_adjust_remaining'] 		= $previous_balance;
					$data['current_adjust_remaining'] 	= $current_balance;
					$data['old_adjust_number'] 			= 0;
					$data['prev_adjust_number'] 		= 0;
					$data['current_adjust_number'] 		= 0;
					$data['no_of_days'] 				= $no_of_days - $old_balance;
				}
			}
			if($data['no_of_days'] > 0 && $previous_balance > 0)
			{
				if($previous_balance >= $data['no_of_days'])
				{
					$data['old_adjust_remaining'] 		= 0;
					$data['prev_adjust_remaining'] 		= $previous_balance - $data['no_of_days'];
					$data['current_adjust_remaining'] 	= $current_balance;
					$data['old_adjust_number'] 			= $old_balance;
					//$data['prev_adjust_number'] 		= $previous_balance;
					$data['prev_adjust_number'] 		= $info->no_of_days;
					$data['current_adjust_number'] 		= 0;
					$data['no_of_days'] 				= 0;
				}
				else{
					$data['old_adjust_remaining'] 		= 0;
					$data['prev_adjust_remaining'] 		= 0;
					$data['current_adjust_remaining'] 	= $current_balance;
					$data['old_adjust_number'] 			= 0;
					$data['prev_adjust_number'] 		= 0;
					$data['current_adjust_number'] 		= 0;
					$data['no_of_days'] 				= $data['no_of_days'] - $previous_balance;
				}
			}
			if($data['no_of_days'] > 0 && $current_balance > 0)
			{
				if($current_balance >= $data['no_of_days'])
				{
					$data['old_adjust_remaining'] 		= 0;
					$data['prev_adjust_remaining'] 		= 0;
					$data['current_adjust_remaining'] 	= $current_balance - $data['no_of_days'];
					$data['old_adjust_number'] 			= $old_balance;
					$data['prev_adjust_number'] 		= $previous_balance;
					$data['current_adjust_number'] 		= $data['no_of_days'];
					$data['no_of_days'] 				= 0;
					
				}
				else{
					$data['old_adjust_remaining'] 		= 0;
					$data['prev_adjust_remaining'] 		= 0;
					$data['current_adjust_remaining'] 	= $current_balance - $data['no_of_days'];
					$data['old_adjust_number'] 			= 0;
					$data['prev_adjust_number'] 		= 0;
					$data['current_adjust_number'] 		= 0;
					$data['no_of_days'] 				= $data['no_of_days'] - $current_balance;
				}
			}
			$balance['cum_balance_less_close_12'] 	= $data['old_adjust_remaining']; 
			$balance['pre_cumulative_close'] 		= $data['prev_adjust_remaining']; 
			$balance['current_close_balance'] 		= $data['current_adjust_remaining']; 
			$balance['cum_close_balance'] 			= $data['prev_adjust_remaining']; 
			$balance['no_of_days'] 					= $remaining_old->no_of_days + $data['current_adjust_number']; 
			$balance['last_update_date'] 			= date('Y-m-d'); 
			$balance['updated_by'] 					= Session::get('admin_id');
		}
		elseif($leave_type == 5){ // casual  

			$data['casual_remaining'] 				= $casual_balance - $data['no_of_days'];
			$data['casual_adjust_number'] 			= $data['no_of_days'];
			$data['no_of_days'] 					= $data['no_of_days'];
			$balance['casual_leave_close'] 			= $data['casual_remaining'];		
			$balance['last_update_date'] 			= date('Y-m-d'); 
			$balance['updated_by'] 					= Session::get('admin_id');
		}
		else
		{
			$balance['eid_earn_leave_open'] 		= $remaining_old->eid_earn_leave_open; 
		}
		// Balance Update
		// END BALANCE DATA SET 
		// Data-Set for History Table
		$history['emp_id'] 						= $info->emp_id;
		$history['is_application_flag'] 		= 1;
		$history['id_application'] 				= $application_id;
		$history['serial_no'] 					= $info->emp_app_serial;
		$history['f_year_id'] 					= $fiscal_year->id;
		$history['designation_code'] 			= '';
		$history['branch_code'] 				= '';
		$history['type_id'] 					= $info->leave_type; 
		$history['apply_for'] 					= $info->apply_for; 
		$history['is_pay'] 						= 1; 
		$history['application_date'] 			= $info->application_date; 
		$history['from_date'] 					= $info->leave_from; 
		$history['to_date'] 					= $info->leave_to; 
		$history['leave_dates'] 				= $info->leave_dates; 
		$history['no_of_days'] 					= $info->no_of_days; 
		$history['leave_remain'] 				= 0; 
		$history['remarks'] 					= $info->remarks; 
		$history['supervisor_id'] 				= 0; 
		$history['recom_desig_code'] 			= 0; 
		$history['approved_id'] 				= $info->reported_to; 
		$history['appr_desig_code'] 			= 0; 
		$history['sup_status'] 					= 1; 
		$history['appr_status'] 				= 1; 
		$history['appr_from_date'] 				= $info->leave_from;
		$history['appr_to_date'] 				= $info->leave_to;
		$history['sup_recom_date'] 				= ''; 
		$history['appr_appr_date'] 				= $info->super_action_date; 
		$history['no_of_days_appr'] 			= $info->no_of_days; 
		$history['tot_earn_leave'] 				= ''; 
		$history['leave_adjust'] 				= 0; //  
		$history['is_view'] 					= 1; 
		$history['for_which'] 					= 1; 
		$history['user_code'] 					= Session::get('admin_id');
		// END HISTORY DATA SET 
		
		// INSERT IN HISTORY AND UPDATE LEAVE BALANCE 
		DB::beginTransaction();
		try {				
			DB::table('tbl_leave_history')->insert($history); 
			DB::table('tbl_leave_balance')
				->where('id', $remaining_old->id)
				->update($balance);
				if($leave_type == 1)
				{
					$app_adjust['old_adjust_number'] 		= $data['old_adjust_number'];
					$app_adjust['prev_adjust_number'] 		= $data['prev_adjust_number'];
					$app_adjust['current_adjust_number'] 	= $data['current_adjust_number'];
					DB::table('leave_application')
					->where('application_id', $application_id)
					->update($app_adjust);
				}
			
			DB::commit();
			$flag = true;
		} catch (\Exception $e) {
			$flag = false;
			DB::rollback();
		}
		// RETURN SUCCESS STATUS
		return($data);
	} 
	
	END ROLLBACK */

	// BULK ACTION
	public function leave_bulk_action(Request $request)
	{
		$application_id 			= $request->application_id;
		$supervisor_type 			= $request->supervisor_type;
		$supervisor_id 				= $request->supervisor_id;
		$flag 						= $request->flag;
		if ($flag) {
			$accept 			= $flag;
		} else {
			$accept 			= array();
		}
		$result = array_intersect($application_id, $accept);
		$applications = array_combine($application_id, $supervisor_type);

		foreach ($applications as $key => $sup_type) {
			if (in_array($key, $result)) {
				$action = 1;
			} else {
				$action = 2;
			}
			if ($sup_type == 2) {
				$sub_data = array();
				$sub_data['stage'] = 1;
				$sub_data['first_super_emp_id'] = $supervisor_id[0];
				$sub_data['first_super_action_date'] = date('Y-m-d');
				$sub_data['first_super_action'] = $action;
				DB::table('leave_application')
					->where('application_id', $key)
					->update($sub_data);
			} elseif ($sup_type == 1) {
				$main_data = array();
				$main_data['stage'] = 2;
				$main_data['super_emp_id'] = $supervisor_id[0];
				$main_data['super_action_date'] = date('Y-m-d');
				$main_data['super_action'] = $action;
				DB::table('leave_application')
					->where('application_id', $key)
					->update($main_data);
			}
		}
		return Redirect::to('/leave_approved');
	}

/*
version-1
	public function payRollDetails(Request $request, $search_month)
	{
		$emp_id 		= Session::get('emp_id');
	
		$date_upto 		= date('Y-m-d');
		$salary_month   =  date("Y-m-t", strtotime($search_month));
		$data = array();


		$data['salary_month'] =
			date("M-Y", strtotime($search_month));
			
			
			
		$month = date('m', strtotime($search_month));
		$year = date('Y', strtotime($search_month));	
			
	
			
			
		$data['emp_mapping'] = DB::table('tbl_emp_mapping as mapping')
			->leftjoin('tbl_department as dept','mapping.current_department_id','=','dept.department_id')
			->leftjoin('tbl_unit_name as unit','mapping.unit_id','=','unit.id')
			->where('mapping.emp_id', $emp_id)
			->orderBy('mapping.id', 'desc')
			->select('dept.department_name', 'unit.unit_name', 'mapping.current_program_id')
			->first();

			$max_sarok = DB::table('tbl_master_tra as m')
				->where('m.emp_id', '=', $emp_id)
				->where('m.letter_date', '=', function ($query) use ($emp_id, $date_upto) {
					$query->select(DB::raw('max(letter_date)'))
						->from('tbl_master_tra')
						->where('emp_id', $emp_id)
						->where('letter_date', '<=', $date_upto);
				})
				->select('m.emp_id', DB::raw('max(m.sarok_no) as sarok_no'))
				->groupBy('emp_id')
				->first();
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
				->select('tbl_master_tra.sarok_no', 'tbl_master_tra.br_join_date', 'tbl_master_tra.next_increment_date', 'tbl_master_tra.effect_date as sa_effect_date', 'tbl_master_tra.br_code', 'tbl_master_tra.grade_code', 'tbl_master_tra.grade_effect_date', 'tbl_master_tra.grade_step', 'tbl_master_tra.department_code', 'tbl_master_tra.is_permanent', 'tbl_emp_basic_info.emp_name_eng', 'tbl_emp_basic_info.org_join_date', 'tbl_designation.designation_name', 'tbl_master_tra.basic_salary', 'tbl_master_tra.salary_br_code', 'tbl_department.department_name', 'tbl_emp_basic_info.gender', 'tbl_branch.branch_name', 'tbl_grade_new.grade_name', 'tbl_emp_photo.emp_photo', 'tbl_resignation.effect_date')
				->first();

			$data['emp_id'] 				= $emp_id;
			$data['emp_name'] 				= $employee_info->emp_name_eng;
			$data['designation_name'] 		= $employee_info->designation_name;
			$data['department_name'] 		= $employee_info->department_name;
			$data['branch_name'] 			= $employee_info->branch_name;
			$data['grade_name'] 			= $employee_info->grade_name;



		
		$all_pay = DB::table('pay_roll as pr')
			->leftJoin('pay_roll_details as pd', 'pr.pay_roll_id', '=', 'pd.pay_roll_id')
			->where('pd.emp_id', '=', $emp_id)
			//->where('pr.salary_month', '=', $salary_month)
			->whereRaw('MONTH(salary_month) = '.$month)
			->whereRaw('YEAR(salary_month) = '.$year)
			->select('pd.*')
			->first();
			
			
		//dd($all_pay);
			
		
		//if (!empty($all_pay)) {
		//if($month <12 && $year <)
		//{
			//echo '<center><h1>No information Found</h1></center>';
		//}
		
		
		if (!empty($all_pay) && $all_pay->salary_plus_id) {
			
			
			if ($all_pay->loan_schedule_product_id) {
				$loanCategory = DB::select(DB::raw("SELECT loan_product_name FROM loan_product WHERE loan_product_id IN($all_pay->loan_schedule_product_id)"));
				$loanCatgoryArray = array();

				foreach ($loanCategory as $loanCat) {
					$loanCatgoryArray[] = $loanCat->loan_product_name;
				}
				$loan_schedule_value_interest = array_combine(explode(",", $all_pay->loan_schedule_value_pr), explode(",", $all_pay->loan_schedule_value_int));
				$loanScheduleValueInterestArray = array();
				foreach ($loan_schedule_value_interest as $key => $value) {
					$loanScheduleValueInterestArray[] = $key + $value;
				}
				$data['salaryComponent'] = array(
					'basic_salary' => $all_pay->basic_salary,
					'salary_plus' => array_combine(explode(",", $all_pay->salary_plus_name), explode(",", $all_pay->salary_plus_value)),
					//
					'salary_minus' => array_combine(explode(",", $all_pay->salary_minus_name), explode(",", $all_pay->salary_minus_value)),
					'other_minus' => array_combine(explode(",", $all_pay->other_minus_name), explode(",", $all_pay->other_minus_value)),
					'loan' => array_combine($loanCatgoryArray, $loanScheduleValueInterestArray)
				);
			} else {
				$data['salaryComponent'] = array(
					'basic_salary' => $all_pay->basic_salary,
					'salary_plus' => array_combine(explode(",", $all_pay->salary_plus_name), explode(",", $all_pay->salary_plus_value)),
					'salary_minus' => array_combine(explode(",", $all_pay->salary_minus_name), explode(",", $all_pay->salary_minus_value)),
					'other_minus' => array_combine(explode(",", $all_pay->other_minus_name), explode(",", $all_pay->other_minus_value)),
					'loan' => array()
				);
			}
			
				$extraAllowance = DB::select(DB::raw("
						SELECT 
							extra_allowance.extra_allowance_amount, 
							extra_allowance_type.type_name 
						FROM 
							`extra_allowance` 
							LEFT JOIN extra_allowance_type ON extra_allowance_type.id = extra_allowance.extra_allowance_type 
						WHERE 
							extra_allowance.extra_allowance_emp_id = $emp_id
				"));
				
			if(!empty($extraAllowance)){
				$data['extraAllowance']=$extraAllowance;
			}

			return view('admin.my_info.pay_slip', $data);
		} else {
			echo '<center><h1>No information Found</h1></center>';
		}
	}
	
	*/

	public function get_leave_info($id)
	{
		$data = array();
		$info = DB::table('leave_application as app')
			->leftJoin('tbl_emp_basic_info as basic_emp', 'app.emp_id', '=', 'basic_emp.emp_id')
			->leftJoin('tbl_emp_basic_info as basic_sub', 'app.sub_reported_to', '=', 'basic_sub.emp_id')
			->leftJoin('tbl_emp_basic_info as basic', 'app.reported_to', '=', 'basic.emp_id')
			->where('app.application_id', '=', $id)
			->select('app.*', 'basic_emp.emp_name_eng as emp_name','basic.emp_name_eng as supervisor_name', 'basic_sub.emp_name_eng as sub_supervisor_name')
			->first();

		$data['application_id'] 		= $info->application_id;
		$data['emp_name'] 				= $info->emp_name;
		$data['emp_id'] 				= $info->emp_id;
		$data['application_date'] 		= date("d-m-Y", strtotime($info->application_date)); 
		$data['leave_from'] 			= $info->leave_from;  
		$data['leave_to'] 				= $info->leave_to; 
		$data['v_leave_from'] 			= date("d-m-Y", strtotime($info->leave_from)); 
		$data['v_leave_to'] 			= date("d-m-Y", strtotime($info->leave_to)); 
		$data['leave_type'] 			= $info->leave_type;
		$data['remarks'] 				= $info->remarks;
		$data['first_super_emp_id'] 		= $info->first_super_emp_id;
		if($info->first_super_action_date == '')
		{
			$data['first_super_action_date'] 			= '-';	
		}else{
			$data['first_super_action_date'] 			= date("d-m-Y", strtotime($info->first_super_action_date));
		}
		$data['first_super_action'] 		= $info->first_super_action;
		$data['first_super_remarks'] 		= $info->first_super_remarks;
		$data['super_emp_id'] 				= $info->super_emp_id;
		if($info->super_action_date == '')
		{
			$data['super_action_date'] 			= '-';	
		}else{
			$data['super_action_date'] 			= date("d-m-Y", strtotime($info->super_action_date));
		}
		$data['super_action'] 				= $info->super_action;
		$data['super_remarks'] 				= $info->super_remarks;
		$data['no_of_days'] 				= $info->no_of_days;
		$data['sub_supervisor_name'] 		= $info->sub_supervisor_name;
		$data['supervisor_name'] 			= $info->supervisor_name;
		$data['sub_reported_to'] 			= $info->sub_reported_to;
		$data['reported_to'] 				= $info->reported_to;
		$data['modify_remarks'] 			= $info->modify_remarks;
		$data['modify_cancel'] 				= $info->modify_cancel;
		return $data;
	}

	public function abc($salary_month)
	{
		$data = array();
		$data['emp_id'] = 2397;
		return $data;
	}

	private function cheeck_action_permission($action_id)
	{
		$access_label 	= Session::get('admin_access_label');
		$nav_name 		=  '/' . request()->segment(1);
		$nav_info		= DB::table('tbl_navbar')->where('nav_action', $nav_name)->first();
		$nav_id 		= $nav_info->nav_id;
		$permission    	= DB::table('tbl_user_permissions')
			->where('user_role_id', $access_label)
			->where('nav_id', $nav_id)
			->where('status', 1)
			->first();
		if ($permission) {
			if (in_array($action_id, $p = explode(",", $permission->permission))) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}


	public function reported_to($emp_id, $br_code, $department_code, $designation_code)
	{

		if ($br_code == 9999) {
			$reported_to = DB::table('reported_to as to')
				->where('to.department', '=', $department_code)
				->select('to.*')
				->first();

			if ($reported_to->reported_designation == $designation_code) {
				$dep_info = DB::table('tbl_department')
					->where('department_id', '=', $department_code)
					->select('*')
					->first();

				$report_to 						= $dep_info->dp_head_designation;
				$report_to_designation_code 	= $dep_info->dp_head_desig_code;
				$report_to_new 					= $dep_info->dp_head_emp_id;
				$report_to_emp_type 			= $dep_info->dp_emp_type;
			} else {
				$report_to 						= $reported_to->designation_name;
				$report_to_designation_code 	= $reported_to->reported_designation;
				$report_to_new 					= $reported_to->reported_emp_id;
				$report_to_emp_type 			= $reported_to->emp_type;
			}
		} else {
			$reported_to = DB::table('tbl_designation')
				->where('designation_code', '=', $designation_code)
				->select('*')
				->first();
			if ($reported_to) {
				$report_to 						= $reported_to->reported_designation;
				$report_to_designation_code 	= $reported_to->to_reported;
				$report_to_new 					= 0;
				$report_to_emp_type 			= $reported_to->reported_emp_type;
			} else {
				$report_to 						= 'Branch Manager';
				$report_to_designation_code 	= 24;
				$report_to_new 					= 0;
				$report_to_emp_type 			= 1;
			}
		}

		$data['report_to'] 					= $report_to;
		$data['report_to_designation_code'] = $report_to_designation_code;
		$data['report_to_new'] 				= $report_to_new;
		$data['report_to_emp_type'] 		= $report_to_emp_type;

		return $data;
	}


	public function getLoanDetailsById(Request $request, $loan_id)
	{

		$LoanAllData = DB::table('loan_schedule')
			->where('loan_id', $loan_id)
			->where('status', '!=', 'Edited')
			->orderBy('loan_schedule_id', 'ASC')
			->get();
		$lastLoanAllData = count($LoanAllData);
		echo '<table width="100%" border="1">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle">Pmt No.</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle">Payment Date</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle">Beginning Balance</th>
                                    <th colspan="3" style="text-align: center; vertical-align: middle">Payment</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle">Ending Principal</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle">Ending Interest</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle">Principal</th>
                                    <th style="text-align: center; vertical-align: middle">Interest</th>
                                    <th style="text-align: center; vertical-align: middle">Total amount</th>
                                </tr>
                                </thead>
                                <tbody>';
		$i = 1;
		$total_interest = 0;
		$total_principal = 0;
		$lastLoanAllData = count($LoanAllData);
		$ending_interest = $LoanAllData[$lastLoanAllData - 1]->cumulative_interest;
		// dd($ending_interest);
		foreach ($LoanAllData as $LoanData) {
			$date = date("M-Y", strtotime($LoanData->repayment_date));
			if ($LoanData->status != "Not Paid") {
				$status = "class=' bg-success'";
			} else {
				$status = "class=' bg-warning'";
			}
			$beginning_balance = number_format($LoanData->beginning_balance, 2, '.', ',');
			$principal_payable = number_format($LoanData->principal_payable, 2, '.', ',');
			$interest_payable = number_format($LoanData->interest_payable, 2, '.', ',');
			$installment_amount = number_format($LoanData->installment_amount, 2, '.', ',');
			$ending_balance = number_format($LoanData->ending_balance, 2, '.', ',');
			$total_interest += $LoanData->interest_payable;
			$ending_interest = $ending_interest - $LoanData->interest_payable;
			echo "<tr $status>
                                
                                    <td align='right'> $i  </td>
                                
                                    <td align='right'> $date </td>
                                
                                    <td align='right'> $beginning_balance </td>
                                
                                    <td align='right'> $principal_payable </td>
                                
                                    <td align='right'> $interest_payable </td>
                                    
                                    <td align='right'> $installment_amount </td>
                                
                                    <td align='right'> $ending_balance </td>
                                
                                    <td align='right'> $ending_interest </td>
                                </tr>";
			$i++;
			$total_principal += $LoanData->principal_payable;
		}
		$total = $total_principal + $total_interest;
		$total_principal = number_format($total_principal, 2, '.', ',');
		$total_interest = number_format($total_interest, 2, '.', ',');
		$total = number_format($total, 2, '.', ',');
		echo "</tbod>
                            <tr>
                                <td colspan='3' align='right'><strong>Total = </strong></td>
                                <td align='right'>$total_principal</td>
                                <td align='right'>$total_interest</td>
                                <td align='right'>$total</td>
                                <td colspan='2'></td>
                            </tr>
                            </table>";
		if ($i == 1) {
			echo "<h3>No records found!</h3>";
		}

	}
	
	public function leave_reprt_2($emp_id)
	{
		$data = array(); 
		$data['emp_id'] 				= $emp_id;
		$data['from_date'] 				= date('Y-m-d');
		//$data['from_date'] 				= date('2021-06-30');
		$current_date 					= date('Y-m-d');
			$max_sarok = DB::table('tbl_master_tra as m')
				->where('m.emp_id', '=', $emp_id)
				->where('m.br_join_date', '=', function ($query) use ($emp_id, $current_date) {
					$query->select(DB::raw('max(br_join_date)'))
						->from('tbl_master_tra')
						->where('emp_id', $emp_id)
						->where('br_join_date', '<=', $current_date);
				})
				->select('m.emp_id', DB::raw('max(m.sarok_no) as sarok_no'))
				->groupBy('emp_id')
				->first();

			if (!empty($max_sarok)) {

				$data['employee_his']  = DB::table('tbl_master_tra as m')
					->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
					->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
					->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
					->leftJoin('tbl_zone as z', 'z.zone_code', '=', 'b.zone_code')
					->where('m.sarok_no', '=', $max_sarok->sarok_no)
					->select('emp.emp_id', 'emp.emp_name_eng as emp_name', 'b.br_code', 'd.designation_name', 'd.designation_code', 'b.branch_name', 'z.zone_name', 'emp.org_join_date as joining_date')
					->first();

				$assign_designation = DB::table('tbl_emp_assign as ea')
					->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
					->where('ea.emp_id', $emp_id)
					->where('ea.status', '!=', 0)
					->where('ea.select_type', '=', 5)
					->select('ea.emp_id', 'ea.open_date', 'de.designation_name', 'de.designation_code')
					->first();
				if (!empty($assign_designation)) {
					$designation_name = $assign_designation->designation_name;
				} else {
					$designation_name = $data['employee_his']->designation_name;
				}

				$assign_branch = DB::table('tbl_emp_assign as ea')
					->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code')
					->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
					->leftJoin('tbl_zone as z', 'z.zone_code', '=', 'br.zone_code')
					->where('ea.emp_id', $emp_id)
					->where('ea.open_date', '<=', $current_date)
					->where('ea.status', '!=', 0)
					->where('ea.select_type', '=', 2)
					->select('ea.emp_id', 'ea.open_date', 'ea.br_code', 'br.branch_name', 'ar.area_name', 'z.zone_name')
					->first();

				if (!empty($assign_branch)) {
					$br_code = $assign_branch->br_code;
					$branch_name = $assign_branch->branch_name;
					$zone_name = $assign_branch->zone_name;
				} else {
					$br_code = $data['employee_his']->br_code;
					$branch_name = $data['employee_his']->branch_name;
					$zone_name 	 = $data['employee_his']->zone_name;
				}

				$data['emp_id'] 			= $data['employee_his']->emp_id;
				$data['br_code'] 		= $br_code;
				$data['branch_name'] 		= $branch_name;
				$data['designation_name'] 	= $designation_name;
				$data['emp_name'] 			= $data['employee_his']->emp_name;
				$data['zone_name'] 			= $zone_name;
			} else {
				$data['emp_id'] 			= '';
			}
		 

		$select_fiscal_year = DB::table('tbl_financial_year')
			->where('running_status', 1)
			->select('id')
			->first();
		if (!empty($data['employee_his'])) {

			$data['fiscal_year'] = DB::table('tbl_leave_balance as lib')
				->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'lib.f_year_id')
				->where('lib.emp_id', $emp_id)
				->where('lib.f_year_id', $select_fiscal_year->id)
				->select('lib.*', 'fy.f_year_from', 'fy.f_year_to')
				->first();

			$data['fiscal_year1'] = DB::table('tbl_leave_history as lib')
				->where('lib.modify_cancel',0) 
				->where('lib.emp_id', $emp_id)
				->where('lib.f_year_id', $select_fiscal_year->id)
				->select(DB::raw('max(tot_earn_leave) as tot_earn_leave'))
				->first();

			$get_date  = DB::table('tbl_leave_history as linf')
				->where('linf.modify_cancel',0) 
				->where('linf.emp_id', $emp_id)
				->where('linf.f_year_id', $select_fiscal_year->id)
				->select(DB::raw('max(application_date) as sys_date_time'))
				->first();

			$month = date('m', strtotime($data['from_date']));
			$year = date('Y', strtotime($data['from_date']));
			if ($month <= 6) {
				$f_year_start  = ($year - 1);
			} else {
				$f_year_start  = $year;
			}
			date_default_timezone_set('Asia/Dhaka');
			$joining_date = $data['employee_his']->joining_date;
			/* $j_additional_day = 0;


			if ($joining_date > $f_year_start . '-' . '07' . '-' . '01') {
				$system_time = date("Y-m-d", strtotime('+1 month', strtotime($joining_date)));
				$join_day   =  date('d', strtotime($system_time));
				$join_month   =  date('m', strtotime($system_time));

				if ($join_day <= 10) {
					$j_additional_day = 2;
				} else if ($join_day <= 20) {
					$j_additional_day = 1.5;
				} else {
					$j_additional_day = 1;
				}
			} else {
				$system_time = $f_year_start . '-' . '07' . '-' . '01';
			}


			$within_date = date('Y-m-03', strtotime($data['from_date']));


			$system_time = date('Y-m-01', strtotime($system_time));
			$date1 = date_create($system_time);
			$date2 = date_create($within_date);
			$diff = date_diff($date1, $date2);

			$total_month = ($diff->format("%R%a")) / 30;

			$total_month = intval($total_month);

			if (strtotime($within_date) < strtotime($system_time)) {
				$data['extra_earn'] = ((-$total_month) * 2) + $j_additional_day;
			} else {
				$data['extra_earn'] = ($total_month * 2) + $j_additional_day;
			} */

			$j_additional_day = 0;
				
			  
				 if($joining_date > $f_year_start.'-'.'07'.'-'.'01'){ 
					 $system_time = date("Y-m-d",strtotime('+1 month', strtotime($joining_date)));
					 $join_day   =  date('d',strtotime($system_time));
					 $join_month   =  date('m',strtotime($system_time));
					 
					 
					 if($joining_date > '2020-12-31'){
						  if($join_day <= 10){
							$j_additional_day = 2;
							}else if($join_day <= 20){
								$j_additional_day = 1.5;
							}else{
								$j_additional_day = 1;
							} 
					 }else{
						  if($join_day <= 10){
							$j_additional_day = 1.5;
						}else if($join_day <= 20){
							$j_additional_day = 1;
						}else{
							$j_additional_day = .5;
						} 
					 }  
				}else{
					 $system_time = $f_year_start.'-'.'07'.'-'.'01'; 
					  
				} 
				
				/* if($data['from_date'] > '2020-12-31'){
					$within_date = '2020-12-31';	 
					$system_time = date('Y-m-01',strtotime($system_time)); 
					$date1=date_create($system_time);
					$date2=date_create($within_date);
					$diff=date_diff($date1,$date2);
	 
					$total_month= ($diff->format("%R%a"))/30;

					$total_month = intval($total_month); 
					 
					if(strtotime($within_date) < strtotime($system_time)){
						$data['extra_earn'] = ((-$total_month) * 1.5);
					}else{
						$data['extra_earn'] = ($total_month * 1.5);
					}
					
					$within_date = date('Y-m-03',strtotime($data['from_date']));	
					$system_time = '2021-01-01'; 
					$date1=date_create($system_time);
					$date2=date_create($within_date);
					$diff=date_diff($date1,$date2);
	 
					$total_month= ($diff->format("%R%a"))/30;

					$total_month = intval($total_month); 
					 
					if(strtotime($within_date) < strtotime($system_time)){
						$data['extra_earn'] += ((-$total_month) * 2);
					}else{
						$data['extra_earn'] += ($total_month * 2);
					}
					
					$data['extra_earn'] +=  $j_additional_day;
				 }else{ */
					$within_date = date('Y-m-03',strtotime($data['from_date']));	 
					$system_time = date('Y-m-01',strtotime($system_time)); 
					$date1=date_create($system_time);
					$date2=date_create($within_date);
					$diff=date_diff($date1,$date2);
	 
					$total_month= ($diff->format("%R%a"))/30;

					$total_month = intval($total_month); 
					 
					if(strtotime($within_date) < strtotime($system_time)){
						$data['extra_earn'] = ((-$total_month) * 2)+ $j_additional_day;
					}else{
						$data['extra_earn'] = ($total_month * 2) + $j_additional_day;
					}  
				// }

			$fiscal_end_year = $f_year_start + 1;
			$fiscal_end_date =  $fiscal_end_year . '-' . '06' . '-' . '30';
			$data['getleaveinfowithpay']   = DB::table('tbl_leave_history as linf')
				->where('linf.modify_cancel',0) 
				->where('linf.f_year_id', $select_fiscal_year->id)
				//->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where('linf.is_pay', 1)
				->where('linf.type_id', 1) 
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();

			$data['getcasualleaveinfowithpay']   = DB::table('tbl_leave_history as linf')
				->where('linf.modify_cancel',0) 
				->where('linf.f_year_id', $select_fiscal_year->id)
				//->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where(function ($q) {
					$q->where('linf.is_pay', 1)
						->orwhere('linf.is_pay', 3);
				})

				->where('linf.type_id', 5) 
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();
			$data['total_leave_withpay']   = DB::table('tbl_leave_history as linf')
				->where('linf.modify_cancel',0) 
				->where('linf.f_year_id', $select_fiscal_year->id)
				//->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where('linf.is_pay', 1)
				->where('linf.type_id', '!=', 3)
				->where('linf.type_id', '!=', 2)
				->where('linf.type_id', '!=', 4) 
				->sum('linf.no_of_days');
			$data['getleaveprevious']   = DB::table('tbl_leave_history as linf')
			   ->where('linf.modify_cancel',0) 
				->where('linf.f_year_id', $select_fiscal_year->id)
				//->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where('linf.is_pay', 1)
				->where('linf.type_id', '!=', 3) 
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();
			$data['pre_totalleave']   = DB::table('tbl_leave_history as linf')
			   ->where('linf.modify_cancel',0) 
				->where('linf.f_year_id', $select_fiscal_year->id)
				//->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where('linf.is_pay', 1)
				->where('linf.type_id', '!=', 3) 
				->where('linf.is_view', 1)
				->sum('linf.no_of_days');
			$data['getleavemeternity']   = DB::table('tbl_leave_history as linf')
				->where('linf.modify_cancel',0) 
				->where('linf.f_year_id', $select_fiscal_year->id)
				//->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where('linf.is_pay', 1)
				->where('linf.type_id', 2) 
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();
			$data['getleavespecial']   = DB::table('tbl_leave_history as linf')
				->where('linf.modify_cancel',0) 
				->where('linf.f_year_id', $select_fiscal_year->id)
				//->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where('linf.type_id', 3)
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();
			$data['fiscal_year_9_12']   = DB::table('tbl_leave_history as linf')
			    ->where('linf.modify_cancel',0) 
				->where('linf.f_year_id', $select_fiscal_year->id)
				//->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id)  
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();
			$data['getleaveinfowithoutpay']   = DB::table('tbl_leave_history as linf')
				->where('linf.modify_cancel',0) 
				->where('linf.f_year_id', $select_fiscal_year->id)
				//->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where('linf.type_id', '!=', 3)
				->where('linf.is_pay', 2)
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();
			$data['finalwithoutpay']   = DB::table('tbl_leave_history as linf')
				->where('linf.modify_cancel',0) 
				->where('linf.emp_id', $emp_id) 
				->where('linf.type_id', '!=', 3)
				->where('linf.is_pay', 2)
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();
			$data['getleavequarantine']   = DB::table('tbl_leave_history as linf')
				->where('linf.modify_cancel',0) 
				->where('linf.f_year_id', $select_fiscal_year->id)
				//->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where('linf.type_id', 4)
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();
		}

		$data['all_emp_type'] = DB::table('tbl_emp_type')->where('status', 1)->get();
		//print_r($data);
		return view('admin.reports.leave_report_form_2', $data);
	}

	/* public function leave_reprt_2($emp_id)
	{
		$data = array(); 
		$data['emp_id'] 				= $emp_id;
		$data['from_date'] 				= date('Y-m-d');
		$current_date 					= date('Y-m-d');
			$max_sarok = DB::table('tbl_master_tra as m')
				->where('m.emp_id', '=', $emp_id)
				->where('m.br_join_date', '=', function ($query) use ($emp_id, $current_date) {
					$query->select(DB::raw('max(br_join_date)'))
						->from('tbl_master_tra')
						->where('emp_id', $emp_id)
						->where('br_join_date', '<=', $current_date);
				})
				->select('m.emp_id', DB::raw('max(m.sarok_no) as sarok_no'))
				->groupBy('emp_id')
				->first();

			if (!empty($max_sarok)) {

				$data['employee_his']  = DB::table('tbl_master_tra as m')
					->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
					->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
					->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
					->leftJoin('tbl_zone as z', 'z.zone_code', '=', 'b.zone_code')
					->where('m.sarok_no', '=', $max_sarok->sarok_no)
					->select('emp.emp_id', 'emp.emp_name_eng as emp_name', 'b.br_code', 'd.designation_name', 'd.designation_code', 'b.branch_name', 'z.zone_name', 'emp.org_join_date as joining_date')
					->first();

				$assign_designation = DB::table('tbl_emp_assign as ea')
					->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
					->where('ea.emp_id', $emp_id)
					->where('ea.status', '!=', 0)
					->where('ea.select_type', '=', 5)
					->select('ea.emp_id', 'ea.open_date', 'de.designation_name', 'de.designation_code')
					->first();
				if (!empty($assign_designation)) {
					$designation_name = $assign_designation->designation_name;
				} else {
					$designation_name = $data['employee_his']->designation_name;
				}

				$assign_branch = DB::table('tbl_emp_assign as ea')
					->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code')
					->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
					->leftJoin('tbl_zone as z', 'z.zone_code', '=', 'br.zone_code')
					->where('ea.emp_id', $emp_id)
					->where('ea.open_date', '<=', $current_date)
					->where('ea.status', '!=', 0)
					->where('ea.select_type', '=', 2)
					->select('ea.emp_id', 'ea.open_date', 'ea.br_code', 'br.branch_name', 'ar.area_name', 'z.zone_name')
					->first();

				if (!empty($assign_branch)) {
					$br_code = $assign_branch->br_code;
					$branch_name = $assign_branch->branch_name;
					$zone_name = $assign_branch->zone_name;
				} else {
					$br_code = $data['employee_his']->br_code;
					$branch_name = $data['employee_his']->branch_name;
					$zone_name 	 = $data['employee_his']->zone_name;
				}

				$data['emp_id'] 			= $data['employee_his']->emp_id;
				$data['br_code'] 		= $br_code;
				$data['branch_name'] 		= $branch_name;
				$data['designation_name'] 	= $designation_name;
				$data['emp_name'] 			= $data['employee_his']->emp_name;
				$data['zone_name'] 			= $zone_name;
			} else {
				$data['emp_id'] 			= '';
			}
		 

		$select_fiscal_year = DB::table('tbl_financial_year')
			->where('running_status', 1)
			->select('id')
			->first();
		if (!empty($data['employee_his'])) {

			$data['fiscal_year'] = DB::table('tbl_leave_balance as lib')
				->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'lib.f_year_id')
				->where('lib.emp_id', $emp_id)
				->where('lib.f_year_id', $select_fiscal_year->id)
				->select('lib.*', 'fy.f_year_from', 'fy.f_year_to')
				->first();

			$data['fiscal_year1'] = DB::table('tbl_leave_history as lib')
				->where('lib.emp_id', $emp_id)
				->where('lib.f_year_id', $select_fiscal_year->id)
				->select(DB::raw('max(tot_earn_leave) as tot_earn_leave'))
				->first();

			$get_date  = DB::table('tbl_leave_history as linf')
				->where('linf.emp_id', $emp_id)
				->where('linf.f_year_id', $select_fiscal_year->id)
				->select(DB::raw('max(application_date) as sys_date_time'))
				->first();

			$month = date('m', strtotime($data['from_date']));
			$year = date('Y', strtotime($data['from_date']));
			if ($month <= 6) {
				$f_year_start  = ($year - 1);
			} else {
				$f_year_start  = $year;
			}
			date_default_timezone_set('Asia/Dhaka');
			$joining_date = $data['employee_his']->joining_date;
			$j_additional_day = 0;


			if ($joining_date > $f_year_start . '-' . '07' . '-' . '01') {
				$system_time = date("Y-m-d", strtotime('+1 month', strtotime($joining_date)));
				$join_day   =  date('d', strtotime($system_time));
				$join_month   =  date('m', strtotime($system_time));

				if ($join_day <= 10) {
					$j_additional_day = 2;
				} else if ($join_day <= 20) {
					$j_additional_day = 1.5;
				} else {
					$j_additional_day = 1;
				}
			} else {
				$system_time = $f_year_start . '-' . '07' . '-' . '01';
			}


			$within_date = date('Y-m-03', strtotime($data['from_date']));


			$system_time = date('Y-m-01', strtotime($system_time));
			$date1 = date_create($system_time);
			$date2 = date_create($within_date);
			$diff = date_diff($date1, $date2);

			$total_month = ($diff->format("%R%a")) / 30;

			$total_month = intval($total_month);

			if (strtotime($within_date) < strtotime($system_time)) {
				$data['extra_earn'] = ((-$total_month) * 2) + $j_additional_day;
			} else {
				$data['extra_earn'] = ($total_month * 2) + $j_additional_day;
			}



			$fiscal_end_year = $f_year_start + 1;
			$fiscal_end_date =  $fiscal_end_year . '-' . '06' . '-' . '30';
			$data['getleaveinfowithpay']   = DB::table('tbl_leave_history as linf')
				->where('linf.f_year_id', $select_fiscal_year->id)
				->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where('linf.is_pay', 1)
				->where('linf.type_id', 1)
				//->where('linf.leave_adjust', 1)
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();

			$data['getcasualleaveinfowithpay']   = DB::table('tbl_leave_history as linf')
				->where('linf.f_year_id', $select_fiscal_year->id)
				->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where(function ($q) {
					$q->where('linf.is_pay', 1)
						->orwhere('linf.is_pay', 3);
				})

				->where('linf.type_id', 5)
				//->where('linf.leave_adjust', 1)
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();
			$data['total_leave_withpay']   = DB::table('tbl_leave_history as linf')
				->where('linf.f_year_id', $select_fiscal_year->id)
				->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where('linf.is_pay', 1)
				->where('linf.type_id', '!=', 3)
				->where('linf.type_id', '!=', 2)
				->where('linf.type_id', '!=', 4)
				//->where('linf.leave_adjust', 1)
				->sum('linf.no_of_days');
			$data['getleaveprevious']   = DB::table('tbl_leave_history as linf')
				->where('linf.f_year_id', $select_fiscal_year->id)
				->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where('linf.is_pay', 1)
				->where('linf.type_id', '!=', 3)
				//->where('linf.leave_adjust', 2)
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();
			$data['pre_totalleave']   = DB::table('tbl_leave_history as linf')
				->where('linf.f_year_id', $select_fiscal_year->id)
				->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where('linf.is_pay', 1)
				->where('linf.type_id', '!=', 3)
				//->where('linf.leave_adjust', 2)
				->where('linf.is_view', 1)
				->sum('linf.no_of_days');
			$data['getleavemeternity']   = DB::table('tbl_leave_history as linf')
				->where('linf.f_year_id', $select_fiscal_year->id)
				->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where('linf.is_pay', 1)
				->where('linf.type_id', 2)
				//->where('linf.leave_adjust', 1)
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();
			$data['getleavespecial']   = DB::table('tbl_leave_history as linf')
				->where('linf.f_year_id', $select_fiscal_year->id)
				->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where('linf.type_id', 3)
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();
			$data['fiscal_year_9_12']   = DB::table('tbl_leave_history as linf')
				->where('linf.f_year_id', $select_fiscal_year->id)
				->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				//->where('linf.leave_adjust', 3)
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();
			$data['getleaveinfowithoutpay']   = DB::table('tbl_leave_history as linf')
				->where('linf.f_year_id', $select_fiscal_year->id)
				->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where('linf.type_id', '!=', 3)
				->where('linf.is_pay', 2)
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();
			$data['finalwithoutpay']   = DB::table('tbl_leave_history as linf')
				->where('linf.emp_id', $emp_id) 
				->where('linf.type_id', '!=', 3)
				->where('linf.is_pay', 2)
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();
			$data['getleavequarantine']   = DB::table('tbl_leave_history as linf')
				->where('linf.f_year_id', $select_fiscal_year->id)
				->where('linf.application_date', '<=', $fiscal_end_date)
				->where('linf.emp_id', $emp_id) 
				->where('linf.type_id', 4)
				->where('linf.is_view', 1)
				->orderby('linf.appr_from_date', 'asc')
				->select('linf.*')
				->get();
		}

		$data['all_emp_type'] = DB::table('tbl_emp_type')->where('status', 1)->get();
		//print_r($data);
		return view('admin.reports.leave_report_form_2', $data);
	} */

	public function delete_leave_application($id)
	{
		$data['del_status'] =  DB::table('leave_application')->where('application_id', '=', $id)->delete();
		echo json_encode($data);
	}
	
	
	
	function set_leave_balance_manual($application_id)
	{
		//Application information
		$info = DB::table('leave_application as app')
					->leftJoin('supervisors as super', 'super.supervisors_emp_id', '=', 'app.reported_to')
					->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'app.emp_id')
					->where('app.application_id', $application_id)
					->select('app.*','super.supervisors_email','basic.emp_name_eng')
					->first();
					
		//dd($info);
		
		//Active FiscalYear
		$fiscal_year = DB::table('tbl_financial_year') 
									->where('running_status',1) 
									->first(); 
		//Current Leave Balance 							
		$remaining_old	 = DB::table('tbl_leave_balance as balance')
								->where('balance.emp_id', $info->emp_id)
								->where('balance.f_year_id', $fiscal_year->id)
								->first();				
		$leave_type 		= $info->leave_type;
		$no_of_days 		= $info->no_of_days;
		$old_balance 		= $remaining_old->cum_balance_less_close_12;
		$previous_balance 	= $remaining_old->pre_cumulative_close;
		$current_balance 	= $remaining_old->current_close_balance;
		$casual_balance 	= $remaining_old->casual_leave_close;
		
		$data = array();
		$data['no_of_days'] = $no_of_days;
	
		if($leave_type == 1) // earned 
		{
			if($old_balance > 0)
			{
				if($old_balance >= $no_of_days)
				{
					$data['old_adjust_remaining'] 		= $old_balance - $no_of_days;
					$data['prev_adjust_remaining'] 		= $previous_balance;
					$data['current_adjust_remaining'] 	= $current_balance;
					$data['old_adjust_number'] 			= $no_of_days;
					$data['prev_adjust_number'] 		= 0;
					$data['current_adjust_number'] 		= 0;
					$data['no_of_days'] = 0;
				}
				else
				{
					$data['old_adjust_remaining'] 		= 0;
					$data['prev_adjust_remaining'] 		= $previous_balance;
					$data['current_adjust_remaining'] 	= $current_balance;
					$data['old_adjust_number'] 			= 0;
					$data['prev_adjust_number'] 		= 0;
					$data['current_adjust_number'] 		= 0;
					$data['no_of_days'] 				= $no_of_days - $old_balance;
				}
			}
			if($data['no_of_days'] > 0 && $previous_balance > 0)
			{
				if($previous_balance >= $data['no_of_days'])
				{
					$data['old_adjust_remaining'] 		= 0;
					$data['prev_adjust_remaining'] 		= $previous_balance - $data['no_of_days'];
					$data['current_adjust_remaining'] 	= $current_balance;
					$data['old_adjust_number'] 			= $old_balance;
					$data['prev_adjust_number'] 		= $data['no_of_days'];
					$data['current_adjust_number'] 		= 0;
					$data['no_of_days'] 				= 0;  
				}
				else{
					$data['old_adjust_remaining'] 		= 0;
					$data['prev_adjust_remaining'] 		= 0;
					$data['current_adjust_remaining'] 	= $current_balance;
					$data['old_adjust_number'] 			= 0;
					$data['prev_adjust_number'] 		= $previous_balance;
					$data['current_adjust_number'] 		= 0;
					$data['no_of_days'] 				= $data['no_of_days'] - $previous_balance;
				}
			}
			if($data['no_of_days'] > 0 && $current_balance > 0)
			{
				if($current_balance >= $data['no_of_days'])
				{
					$data['old_adjust_remaining'] 		= 0;
					$data['prev_adjust_remaining'] 		= 0;
					$data['current_adjust_remaining'] 	= $current_balance - $data['no_of_days'];
					$data['old_adjust_number'] 			= $old_balance;
					$data['prev_adjust_number'] 		= $previous_balance;
					$data['current_adjust_number'] 		= $data['no_of_days']; 
					$data['no_of_days'] 				= 0;
					
				}
				else{ 
					$data['old_adjust_remaining'] 		= 0;
					$data['prev_adjust_remaining'] 		= 0;
					$data['current_adjust_remaining'] 	= $current_balance - $data['no_of_days'];
					$data['old_adjust_number'] 			= 0;
					$data['prev_adjust_number'] 		= 0;
					$data['current_adjust_number'] 		= 0;
					$data['no_of_days'] 				= $data['no_of_days'] - $current_balance;
				}
			}
			$balance['cum_balance_less_close_12'] 	= $data['old_adjust_remaining']; 
			$balance['pre_cumulative_close'] 		= $data['prev_adjust_remaining']; 
			$balance['current_close_balance'] 		= $data['current_adjust_remaining']; 
			$balance['cum_close_balance'] 			= $data['prev_adjust_remaining']; 
			$balance['no_of_days'] 					= $remaining_old->no_of_days + $data['current_adjust_number']; 
			$balance['last_update_date'] 			= date('Y-m-d'); 
			$balance['updated_by'] 					= Session::get('admin_id');
		}
		elseif($leave_type == 5){ // casual  

			$data['casual_remaining'] 				= $casual_balance - $data['no_of_days'];
			$data['casual_adjust_number'] 			= $data['no_of_days'];
			$data['no_of_days'] 					= $data['no_of_days'];
			$balance['casual_leave_close'] 			= $data['casual_remaining'];		
			$balance['last_update_date'] 			= date('Y-m-d'); 
			$balance['updated_by'] 					= Session::get('admin_id');
			$data['old_adjust_number'] 				= 0;
			$data['prev_adjust_number'] 			= 0;
			$data['current_adjust_number'] 			= 0;
		}
		else
		{
			$balance['eid_earn_leave_open'] 		= $remaining_old->eid_earn_leave_open; 
		}

		// Balance Update
		// END BALANCE DATA SET 
		// Data-Set for History Table
		$history['emp_id'] 						= $info->emp_id;
		$history['is_application_flag'] 		= 1;
		$history['id_application'] 				= $application_id;
		$history['serial_no'] 					= $info->emp_app_serial;
		$history['f_year_id'] 					= $fiscal_year->id;
		$history['designation_code'] 			= '';
		$history['branch_code'] 				= '';
		$history['type_id'] 					= $info->leave_type; 
		$history['apply_for'] 					= $info->apply_for; 
		$history['is_pay'] 						= 1; 
		$history['application_date'] 			= $info->application_date; 
		$history['from_date'] 					= $info->leave_from; 
		$history['to_date'] 					= $info->leave_to; 
		$history['leave_dates'] 				= $info->leave_dates; 
		$history['no_of_days'] 					= $info->no_of_days; 
		$history['leave_remain'] 				= 0; 
		$history['remarks'] 					= $info->remarks; 
		$history['supervisor_id'] 				= 0; 
		$history['recom_desig_code'] 			= 0; 
		$history['approved_id'] 				= $info->reported_to;  
		$history['appr_desig_code'] 			= 0; 
		$history['sup_status'] 					= 1; 
		$history['appr_status'] 				= 1; 
		$history['appr_from_date'] 				= $info->leave_from;
		$history['appr_to_date'] 				= $info->leave_to;
		$history['sup_recom_date'] 				= ''; 
		$history['appr_appr_date'] 				= $info->super_action_date; 
		$history['no_of_days_appr'] 			= $info->no_of_days; 
		$history['tot_earn_leave'] 				= ''; 
		$history['leave_adjust'] 				= 0; //  
		$history['is_view'] 					= 1; 
		$history['for_which'] 					= 1; 
		$history['user_code'] 					= Session::get('admin_id');

		$app_adjust['old_adjust_number'] 		= 0;
		$app_adjust['prev_adjust_number'] 		= 0;
		$app_adjust['current_adjust_number'] 	= 0;

		// END HISTORY DATA SET 
		// INSERT IN HISTORY AND UPDATE LEAVE BALANCE 
		DB::beginTransaction();
		try {				
			DB::table('tbl_leave_history')->insert($history); 
			DB::table('tbl_leave_balance')
				->where('id', $remaining_old->id)
				->update($balance);
				if($leave_type == 1)
				{
					$app_adjust['old_adjust_number'] 		= $data['old_adjust_number'];
					$app_adjust['prev_adjust_number'] 		= $data['prev_adjust_number'];
					$app_adjust['current_adjust_number'] 	= $data['current_adjust_number'];
					DB::table('leave_application')
					->where('application_id', $application_id)
					->update($app_adjust);
				}
			DB::commit();
			$flag = true;
		} catch (\Exception $e) {
			$flag = false;
			DB::rollback();
		}
		// RETURN SUCCESS STATUS
		return($data);
	}
	
	
	




	public function emp_pay_slips(Request $request)
	{
		$data = array();
		return view('admin.my_info.staff_pay_slips', $data);
	}


	public function paySliplDetails(Request $request, $search_month,$emp_id) 
	{
		$salary_month   =  date("Y-m-t", strtotime($search_month));

		if($salary_month < '2021-06-30')
		{
			$date_upto 		= date('Y-m-d');
			$salary_month   =  date("Y-m-t", strtotime($search_month));
			$data = array();
			$data['salary_month'] = date("M-Y", strtotime($search_month));
			$month = date('m', strtotime($search_month));
			$year = date('Y', strtotime($search_month));	
			$data['emp_mapping'] = DB::table('tbl_emp_mapping as mapping')
				->leftjoin('tbl_department as dept','mapping.current_department_id','=','dept.department_id')
				->leftjoin('tbl_unit_name as unit','mapping.unit_id','=','unit.id')
				->where('mapping.emp_id', $emp_id)
				->orderBy('mapping.id', 'desc')
				->select('dept.department_name', 'unit.unit_name', 'mapping.current_program_id')
				->first();

				$max_sarok = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $emp_id)
					->where('m.letter_date', '=', function ($query) use ($emp_id, $date_upto) {
						$query->select(DB::raw('max(letter_date)'))
							->from('tbl_master_tra')
							->where('emp_id', $emp_id)
							->where('letter_date', '<=', $date_upto);
					})
					->select('m.emp_id', DB::raw('max(m.sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
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
					->select('tbl_master_tra.sarok_no', 'tbl_master_tra.br_join_date', 'tbl_master_tra.next_increment_date', 'tbl_master_tra.effect_date as sa_effect_date', 'tbl_master_tra.br_code', 'tbl_master_tra.grade_code', 'tbl_master_tra.grade_effect_date', 'tbl_master_tra.grade_step', 'tbl_master_tra.department_code', 'tbl_master_tra.is_permanent', 'tbl_emp_basic_info.emp_name_eng', 'tbl_emp_basic_info.org_join_date', 'tbl_designation.designation_name', 'tbl_master_tra.basic_salary', 'tbl_master_tra.salary_br_code', 'tbl_department.department_name', 'tbl_emp_basic_info.gender', 'tbl_branch.branch_name', 'tbl_grade_new.grade_name', 'tbl_emp_photo.emp_photo', 'tbl_resignation.effect_date')
					->first();

				$data['emp_id'] 				= $emp_id;
				$data['emp_name'] 				= $employee_info->emp_name_eng;
				$data['designation_name'] 		= $employee_info->designation_name;
				$data['department_name'] 		= $employee_info->department_name;
				$data['branch_name'] 			= $employee_info->branch_name;
				$data['grade_name'] 			= $employee_info->grade_name;

				$all_pay = DB::table('pay_roll as pr')
					->leftJoin('pay_roll_details as pd', 'pr.pay_roll_id', '=', 'pd.pay_roll_id')
					->where('pd.emp_id', '=', $emp_id)
					//->where('pr.salary_month', '=', $salary_month)
					->whereRaw('MONTH(salary_month) = '.$month)
					->whereRaw('YEAR(salary_month) = '.$year)
					->select('pd.*')
					->first();

				if (!empty($all_pay) && $all_pay->salary_plus_id) {

					if ($all_pay->loan_schedule_product_id) {
						$loanCategory = DB::select(DB::raw("SELECT loan_product_name FROM loan_product WHERE loan_product_id IN($all_pay->loan_schedule_product_id)"));
						$loanCatgoryArray = array();

						foreach ($loanCategory as $loanCat) {
							$loanCatgoryArray[] = $loanCat->loan_product_name;
						}
						$loan_schedule_value_interest = array_combine(explode(",", $all_pay->loan_schedule_value_pr), explode(",", $all_pay->loan_schedule_value_int));
						$loanScheduleValueInterestArray = array();
						foreach ($loan_schedule_value_interest as $key => $value) {
							$loanScheduleValueInterestArray[] = $key + $value;
						}
						$data['salaryComponent'] = array(
							'basic_salary' => $all_pay->basic_salary,
							'salary_plus' => array_combine(explode(",", $all_pay->salary_plus_name), explode(",", $all_pay->salary_plus_value)),
							'salary_minus' => array_combine(explode(",", $all_pay->salary_minus_name), explode(",", $all_pay->salary_minus_value)),
							'other_minus' => array_combine(explode(",", $all_pay->other_minus_name), explode(",", $all_pay->other_minus_value)),
							'loan' => array_combine($loanCatgoryArray, $loanScheduleValueInterestArray)
						);
					} 
					else 
					{
						$data['salaryComponent'] = array(
							'basic_salary' => $all_pay->basic_salary,
							'salary_plus' => array_combine(explode(",", $all_pay->salary_plus_name), explode(",", $all_pay->salary_plus_value)),
							'salary_minus' => array_combine(explode(",", $all_pay->salary_minus_name), explode(",", $all_pay->salary_minus_value)),
							'other_minus' => array_combine(explode(",", $all_pay->other_minus_name), explode(",", $all_pay->other_minus_value)),
							'loan' => array()
						);
					}
						$extraAllowance = DB::select(DB::raw("
								SELECT 
									extra_allowance.extra_allowance_amount, 
									extra_allowance_type.type_name 
								FROM 
									`extra_allowance` 
									LEFT JOIN extra_allowance_type ON extra_allowance_type.id = extra_allowance.extra_allowance_type 
								WHERE 
									extra_allowance.extra_allowance_emp_id = $emp_id
						"));
						
					if(!empty($extraAllowance)){
						$data['extraAllowance']=$extraAllowance;
					}

					return view('admin.my_info.pay_slip_pv', $data);
				} else {
					echo '<center><h1>No information Found</h1></center>';
				}
		}else
		{
			
			$date_upto 				= date('Y-m-d');
			$salary_month   		= date("Y-m-t", strtotime($search_month));
			$data 					= array();
			$data['salary_month'] 	= date("M-Y", strtotime($search_month));
			$month 					= date('m', strtotime($search_month));
			$year 					= date('Y', strtotime($search_month));	
			


			$data['emp_mapping'] = DB::table('tbl_emp_mapping as mapping')
				->leftjoin('tbl_department as dept','mapping.current_department_id','=','dept.department_id')
				->leftjoin('tbl_unit_name as unit','mapping.unit_id','=','unit.id')
				->where('mapping.emp_id', $emp_id)
				->orderBy('mapping.id', 'desc')
				->select('dept.department_name', 'unit.unit_name', 'mapping.current_program_id')
				->first();

				$max_sarok = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $emp_id)
					->where('m.letter_date', '=', function ($query) use ($emp_id, $date_upto) {
						$query->select(DB::raw('max(letter_date)'))
							->from('tbl_master_tra')
							->where('emp_id', $emp_id)
							->where('letter_date', '<=', $date_upto);
					})
					->select('m.emp_id', DB::raw('max(m.sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
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
					->select('tbl_master_tra.sarok_no', 'tbl_master_tra.br_join_date', 'tbl_master_tra.next_increment_date', 'tbl_master_tra.effect_date as sa_effect_date', 'tbl_master_tra.br_code', 'tbl_master_tra.grade_code', 'tbl_master_tra.grade_effect_date', 'tbl_master_tra.grade_step', 'tbl_master_tra.department_code', 'tbl_master_tra.is_permanent', 'tbl_emp_basic_info.emp_name_eng', 'tbl_emp_basic_info.org_join_date', 'tbl_designation.designation_name', 'tbl_master_tra.basic_salary', 'tbl_master_tra.salary_br_code', 'tbl_department.department_name', 'tbl_emp_basic_info.gender', 'tbl_branch.branch_name', 'tbl_grade_new.grade_name', 'tbl_emp_photo.emp_photo', 'tbl_resignation.effect_date')
					->first();

				$data['emp_id'] 				= $emp_id;
				$data['emp_name'] 				= $employee_info->emp_name_eng;
				$data['designation_name'] 		= $employee_info->designation_name;
				$data['department_name'] 		= $employee_info->department_name;
				$data['branch_name'] 			= $employee_info->branch_name;
				$data['grade_name'] 			= $employee_info->grade_name;


			$salary_info = DB::table('pay_sheets as pay')
									->leftjoin('payroll as roll', 'roll.payroll_id', '=', 'pay.salary_code')
									->where('pay.emp_id', $emp_id)
									->where('pay.salary_month', $salary_month)
									->select('pay.*', 'roll.heads_name')
									->first();

									
			if(!empty($salary_info)) 
			{
				$data['basic_salary'] 	= $salary_info->pay_basic;
				// PLUS 
				$plus_heads_codes   = explode(',',$salary_info->plus_heads_code);	 
				$plus_heads_amounts = explode(',',$salary_info->plus_heads_amount);	
				$s_values = array();
				$s = 0;
				foreach($plus_heads_amounts as $plus_heads_amount)
				{
					if($plus_heads_amount != 0)
					{
						$plus_heads_code = $plus_heads_codes[$s];
						$plus_heads_name = DB::table('payroll_head_2')
											->where('pay_head_id', $plus_heads_code)
											->select('pay_head_name','is_view_in_payslips')
											->first();
						if($plus_heads_name->is_view_in_payslips == 1)
						{
							$s_values[$plus_heads_name->pay_head_name] = $plus_heads_amount;
						}
					}
					$s ++;
				}


							
				
				// Allowance 
				
				$allowance_codess   = explode(',',$salary_info->allowance_codes);	
				$allowance_amounts  = explode(',',$salary_info->allowance_amount);	
				$a_values = array();
				$s = 0;
				foreach($allowance_amounts as $allowance_amount)
				{
					if($allowance_amount != 0)
					{
						$allowance_codes = $allowance_codess[$s];
						$allwance_heads_name = DB::table('payroll_head_2')
											->where('pay_head_id', $allowance_codes)
											->select('pay_head_name','is_view_in_payslips')
											->first();
						if($allwance_heads_name->is_view_in_payslips == 1)
						{
							$a_values[$allwance_heads_name->pay_head_name] = $allowance_amount;
						}
					}
					$s ++;
				}
				// MINUS
				$minus_heads_codes  = explode(',',$salary_info->minus_heads_code);	
				$minus_head_amounts = explode(',',$salary_info->minus_head_amount);	
				$m_values = array();
				$m = 0;
				foreach($minus_head_amounts as $minus_head_amount)
				{
					if($minus_head_amount != 0)
					{
						$minus_heads_code = $minus_heads_codes[$m];
						$minus_heads_name = DB::table('payroll_head_2')
											->where('pay_head_id', $minus_heads_code)
											->select('pay_head_name','is_view_in_payslips')
											->first();
						if($minus_heads_name->is_view_in_payslips == 1)
						{
							$m_values[$minus_heads_name->pay_head_name] = $minus_head_amount;
						}
					}
					$m ++;
				}
				
				$data['salary_allowance']  = array_merge($s_values,$a_values);
				$data['diductions'] 		= $m_values;
				
				
				
				return view('admin.my_info.pay_slip', $data);
				
			}else
			{
				echo '<center><h1>No information Found</h1></center>';
			}
			
			
		}
		
		
	}
	
	
	Public function testmail() 
	{
		$application_id		 		= 504;
		$application_date	 		= '2021-11-15';
		$str			 			= 'Saiful Islam Sheikh';
		$emp_name 					= str_replace(' ', '-', $str);
		$emp_id             		= 2397;
		$leave_from 				= '2021-11-15';
		$leave_to  					= '2021-11-15';
		$no_of_days          		=  2;
		$remarks_str 				= 'abc';
		$remarks 					= str_replace(' ', '-', $remarks_str); 
		$supervisor_email 			= 'polash@cdipbd.org';
		$supervisors_emp_id 		= 2397;
		$sub_supervisor_email  		= 'polash@cdipbd.org';
		$sub_supervisors_emp_id  	= 2397;
		$modify_cancel  			= 0;
		$modify_remarks_str			= 'Test er';
		$modify_remarks  			= str_replace(' ', '-', $modify_remarks_str); 
		$leave_type_name 		 	= 'Earned'; 
		$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_check/'.$application_id.'/'.$application_date.'/'.$emp_name.'/'.$emp_id.'/'.$leave_from.'/'.$leave_to.'/'.$no_of_days.'/'.$remarks.'/'.$supervisor_email.'/'.$supervisors_emp_id.'/'.$sub_supervisor_email.'/'.$sub_supervisors_emp_id.'/'.$modify_cancel.'/'.$modify_remarks.'/'.$leave_type_name); 
		echo $application_id;
	}


}
