<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class ArrearSetupController extends Controller
{
	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data['all_result'] = DB::table('arrear_salary as ars')
							->leftJoin('tbl_emp_basic_info as e', 'ars.arrear_emp_id', '=', 'e.emp_id')
							->select('ars.*','e.emp_name_eng')
							->get();
		return view('admin.pages.arrear.arrear_setup_list',$data);		
    }

    public function create()
    {
		$data = array();
		$data['action'] 		= '/arrear_setup';
		$data['method'] 		= 'post';
		$data['method_field'] 	= '';
		$data['id'] 			= '';
		
		$data['arrear_emp_id'] = ''; 
		$data['arrear_effect_date_from'] = ''; 
		$data['arrear_effect_date_to'] = ''; 
		$data['arrear_basic'] = ''; 
		$data['arrear_basic_amount'] = ''; 
		$data['arrear_to_pay_month'] = ''; 
		$data['arrear_paid_basic'] = ''; 
		$data['comments'] = ''; 
		 
		//
		$data['Heading'] 	 = 'Add Assign';
		$data['button_text'] = 'Save';
		//
		return view('admin.pages.arrear.arrear_setup_form',$data);	

    } 
	public function store(Request $request)
    {
		$data = request()->except(['_token','_method']);
		//print_r ($data); exit;
		$data['created_by'] = Session::get('admin_id');
		DB::table('arrear_salary')->insert($data);
			 
		//print_r ($data); exit;
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/arrear_setup');			

    }
	public function get_emp_info_arr($arrear_emp_id)
	{
		$data = array();
		$effect_date = date("Y-m-d");
		$max_id = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $arrear_emp_id)
						->where('m.br_join_date', '=', function($query) use ($arrear_emp_id,$effect_date)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$arrear_emp_id)
										  ->where('br_join_date', '<=', $effect_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('emp_id')
						->first();
		
		if(!empty($max_id))
		{
			$emp_info = DB::table('tbl_master_tra as  m')
						->leftJoin('tbl_emp_basic_info as e', 'e.emp_id', '=', 'm.emp_id')
						->where('m.sarok_no', $max_id->sarok_no)
						->select('m.basic_salary','e.emp_name_eng') 
						->first();
			
		
		} 
		//echo $max_id;		
		if(!empty($emp_info)) { 
			$data['arrear_emp_id'] 				= $arrear_emp_id;
			$data['emp_name'] 				= $emp_info->emp_name_eng; 
			$data['basic_salary'] 			= $emp_info->basic_salary; 
			$data['error'] 					= '';
		
		} else {
			$data['arrear_emp_id'] 				= '';
			$data['emp_name'] 				= ''; 
			$data['basic_salary'] 			= 0;
			$data['error'] 					= 1;
		}
		
		return $data;
	}
	public function calculation_arrear_amt(Request $request)
	{
		$data = array(); 
		date_default_timezone_set('Asia/Dhaka');
		$total_basic = array();
		$arrear_effect_date_from 	= $request->input('arrear_effect_date_from');  //date('2021-01-15');
		$arrear_effect_date_to 		= $request->input('arrear_effect_date_to');  
		$basic_salary 				= $request->input('arrear_basic'); 
		$data['final_total_basic']  = $this->total_basic_calculation($arrear_effect_date_from,$arrear_effect_date_to,$basic_salary);
		
		return $data;
	}
	public function total_basic_calculation($arrear_effect_date_from,$arrear_effect_date_to,$basic_salary)
	{
		$month_from = date("m",strtotime($arrear_effect_date_from));
		$year_from = date("Y",strtotime($arrear_effect_date_from));
		$month_year_from = date("m-Y",strtotime($arrear_effect_date_from));
		
		$month_to = date("m",strtotime($arrear_effect_date_to));
		$year_to = date("Y",strtotime($arrear_effect_date_to));
		$month_year_to = date("m-Y",strtotime($arrear_effect_date_to));
		
		 
		
		if(( $month_year_to != $month_year_from ) ){
			$total_month = (($year_to - $year_from) * 12) + ($month_to - $month_from);   
			$dates = array(); 
			$dates[] = $arrear_effect_date_from;
			for($i=0; $i < $total_month - 1; $i++){ 
				$arrear_effect_date_from = date('Y-m-01',  strtotime("+1 month", strtotime($arrear_effect_date_from))); 
				$dates[] 	= $arrear_effect_date_from;
			}
			$dates[] 		= $arrear_effect_date_to;
			$last_row 		= count($dates);
			$i = 1; 
			foreach($dates as $v_dates){
				 $first_day = date("d",strtotime($v_dates));
				 
				 if($last_row == $i){
					$first_date = date("Y-m-01",strtotime($v_dates));
					$total_basic[] 	= $this->day_wise_calculation($first_date,$v_dates,$basic_salary);
				 }else if($first_day == 01){ 
					$total_basic[] 	=  $this->month_wise_calculation($v_dates,$basic_salary); 
				 }else{
					$last_date = date("Y-m-t",strtotime($v_dates));
					$total_basic[] 	=  $this->day_wise_calculation($v_dates,$last_date,$basic_salary);
				 } 
				$i++;
			}
		}else{ 
			$total_basic[] 	= $this->day_wise_calculation($arrear_effect_date_from,$arrear_effect_date_to,$basic_salary); 
		} 
		$final_total_basic = array_sum($total_basic);
		 
		return $final_total_basic;
	} 
	public function total_basic_calculation1($arrear_effect_date_from,$arrear_effect_date_to)
	{
		
		$r_from_date = array(); 
		$r_to_date = array(); 
		$month_from = date("m",strtotime($arrear_effect_date_from));
		$year_from = date("Y",strtotime($arrear_effect_date_from));
		$month_year_from = date("m-Y",strtotime($arrear_effect_date_from));
		
		$month_to = date("m",strtotime($arrear_effect_date_to));
		$year_to = date("Y",strtotime($arrear_effect_date_to));
		$month_year_to = date("m-Y",strtotime($arrear_effect_date_to));
		
		 
		
		if(( $month_year_to != $month_year_from ) ){
			$total_month = (($year_to - $year_from) * 12) + ($month_to - $month_from);   
			$dates = array(); 
			$dates[] = $arrear_effect_date_from;
			for($i=0; $i < $total_month - 1; $i++){ 
				$arrear_effect_date_from = date('Y-m-01',  strtotime("+1 month", strtotime($arrear_effect_date_from))); 
				$dates[] 	= $arrear_effect_date_from;
			}
			$dates[] 		= $arrear_effect_date_to;
			$last_row 		= count($dates);
			$i = 1; 
			foreach($dates as $v_dates){
				 $first_day = date("d",strtotime($v_dates));
				 
				 if($last_row == $i){
					 $r_from_date[] = date("Y-m-01",strtotime($v_dates));
					 $r_to_date[] = date("Y-m-d",strtotime($v_dates));
					//$total_basic[] 	= $this->day_wise_calculation($first_date,$v_dates,$basic_salary);
				 }else if($first_day == 01){ 
					 $r_from_date[] = date("Y-m-01",strtotime($v_dates));
					 $r_to_date[] = date("Y-m-t",strtotime($v_dates));
					//$total_basic[] 	=  $this->month_wise_calculation($v_dates,$basic_salary); 
				 }else{
					  $r_from_date[] = date("Y-m-d",strtotime($v_dates));
					  $r_to_date[] = date("Y-m-t",strtotime($v_dates));
				 
					//$total_basic[] 	=  $this->day_wise_calculation($v_dates,$last_date,$basic_salary);
				 } 
				$i++;
			}
		}else{ 
			  $r_from_date[] = $arrear_effect_date_from;
			  $r_to_date[] = $arrear_effect_date_to; 
		} 
		echo "<pre>";
		print_r($r_from_date);
		echo "<pre>";
		print_r($r_to_date);
		
		 
	} 
	public function day_wise_calculation($from_date,$to_date,$basic_salary)
	{
		$date1=date_create($from_date);
		$date2=date_create($to_date);
		$diff=date_diff($date1,$date2); 
		$day_difference = ($diff->format("%R%a"));
		
		$total_day = date("t", strtotime($to_date));
		$total_due = round((($basic_salary) / $total_day ) * ( $day_difference + 1)); 
		/*  print_r($total_due); 
		 exit; */
		return $total_due;
	} 
	public function month_wise_calculation($from_date,$basic_salary)
	{     
		return $basic_salary;
	} 
	public function arrear_setup_pay($arrear_id)
    { 
		$data = array();
		$data['action'] 		= '/arrear_pay_insert';
		$data['method'] 		= 'post';
		$data['method_field'] 	= '';
		$data['id'] 			= '';
		
		$arrear_info = DB::table('arrear_salary as ars')
							->leftJoin('tbl_emp_basic_info as e', 'ars.arrear_emp_id', '=', 'e.emp_id')
							->where('ars.arrear_id', '=', $arrear_id)
							->select('ars.*','e.emp_name_eng')
							->first();
		
		$data['arrear_id'] 					= $arrear_info->arrear_id;   
		$data['arrear_emp_id'] 				= $arrear_info->arrear_emp_id;   
		$data['arrear_basic_amount'] 		= $arrear_info->arrear_basic_amount; 
		$data['arrear_basic'] 				= $arrear_info->arrear_basic; 
		$data['arrear_days'] 				= $arrear_info->arrear_days; 
		$data['emp_name'] 					= $arrear_info->emp_name_eng; 
		$data['arrear_effect_date_from']	= $arrear_info->arrear_effect_date_from; 
		$data['arrear_effect_date_to']		= $arrear_info->arrear_effect_date_to; 
		$data['arrear_to_pay_month'] 		= ''; 
		$data['arrear_paid_basic'] 			= ''; 
		$data['comments'] = ''; 
		 
		//
		$data['Heading'] 	 = 'Add Assign';
		$data['button_text'] = 'Save';
		//
		return view('admin.pages.arrear.arrear_pay_form',$data);	

    } 
	public function calc_arrear_amt_payment(Request $request) 
	{
		$data = array(); 
		date_default_timezone_set('Asia/Dhaka');
		$total_basic = array();
		$arrear_effect_date_from 	= $request->input('arrear_effect_date_from');  //date('2021-01-15');
		$arrear_effect_date_to_original 		= $request->input('arrear_effect_date_to');  
		$basic_salary 				= $request->input('arrear_basic'); 
		$arrear_paid_days 			= $request->input('arrear_paid_days');  
		$arrear_paid_days 			= $arrear_paid_days - 1;  
		$arrear_effect_date_to 		= date('Y-m-d', strtotime($arrear_effect_date_from . '+ '.$arrear_paid_days.'days')); 
		$data['final_total_basic']  = $this->total_basic_calculation($arrear_effect_date_from,$arrear_effect_date_to,$basic_salary);
		$data['arrear_effect_date_from_payment']  = $arrear_effect_date_from_payment =  date('Y-m-d', strtotime($arrear_effect_date_to . "+1 days"));
		$data['due_total_basic']  = $this->total_basic_calculation($arrear_effect_date_from_payment,$arrear_effect_date_to_original,$basic_salary);
		return $data;
	}
	public function arrear_pay_insert(Request $request)
    { 
		$data = array();
		$data_insert = array();
		$arrear_id	 =  $request->input('arrear_id'); 
		$paid_status = $data['paid_status'] 	= $request->input('paid_status'); 
		$data['arrear_to_pay_month'] 			= $request->input('arrear_to_pay_month'); 
		$data['pay_at'] = date("Y-m-d");
		$data['pay_by'] = Session::get('admin_id'); 
		if($paid_status == 1){
			$data['arrear_paid_days'] 				= $request->input('arrear_days');  
			$data['arrear_paid_basic'] 				= $request->input('arrear_basic_amount');
			/* echo "<pre>";
			print_r ($data);  */
			
			 DB::table('arrear_salary')
					->where('arrear_id', $arrear_id) 
					->update($data);
		}else{
			
			$data_insert['arrear_emp_id'] 					= $request->input('arrear_emp_id');  
			$data_insert['comments'] 						= $request->input('comments');  
			$data_insert['arrear_effect_date_from'] 		= $request->input('arrear_effect_date_from_payment');  
			$data_insert['arrear_effect_date_to'] 			= $request->input('arrear_effect_date_to');  
			$data_insert['arrear_days'] 					= $request->input('arrear_days') - $request->input('arrear_paid_days');  
			$data_insert['arrear_basic'] 					= $request->input('arrear_basic');  
			$data_insert['arrear_basic_amount'] 			= $request->input('due_total_basic');  
			$data['arrear_paid_days'] 						= $request->input('arrear_paid_days');  
			$data['arrear_paid_basic'] 						= $request->input('arrear_paid_basic');
			$data_insert['created_by'] 						= Session::get('admin_id');
			/* echo "<pre>";
			print_r ($data); 
			echo "<pre>";
			print_r ($data_insert); 
			exit; */
			
			DB::beginTransaction();
			try {
				DB::table('arrear_salary')
						->where('arrear_id', $arrear_id) 
						->update($data);	
				DB::table('arrear_salary')->insert($data_insert); 		
				DB::commit(); 
			}catch (\Exception $e) { 
				DB::rollback();
			}
		} 
		//exit;  
		//print_r ($data); exit;
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/arrear_setup');			

    }
}
