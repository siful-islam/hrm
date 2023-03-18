<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Middleware\Checkuser;
use DB;
use Session;
class EmployeeleavController extends Controller
{ 
	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
    public function index()
    {  
		$data = array(); 
		$indata = array(0);   
		$br_code 				= Session::get('branch_code'); 
		if(in_array($br_code,$indata)){
		  $current_date = "2020-06-30";
		}else{
		  $current_date = date('Y-m-d');
		} 
		//$current_date = "2021-06-30";
		$fiscal_year 			= DB::table('tbl_financial_year')
											->where('f_year_from','<=',$current_date)
											->where('f_year_to','>=',$current_date)
											->first();
		$f_year_id 				= $fiscal_year->id; 
		$data['emp_leave_list'] = DB::table('tbl_leave_history') 
									->leftJoin("tbl_emp_basic_info as emp",function($join){
											$join->on("emp.emp_id","=","tbl_leave_history.emp_id");
									})
									 ->leftJoin('tbl_branch as b', 'tbl_leave_history.branch_code', '=', 'b.br_code') 
									 ->leftJoin('tbl_designation as d', 'tbl_leave_history.designation_code', '=', 'd.designation_code') 
									->where('tbl_leave_history.for_which',2)
									->where('tbl_leave_history.is_view',1)
									->where('tbl_leave_history.branch_code',$br_code)
									->where('tbl_leave_history.f_year_id',$f_year_id)
									->orderby('tbl_leave_history.serial_no','desc')
									->select('tbl_leave_history.*','emp.emp_name_eng as emp_name','b.branch_name','d.designation_name')
									->get();
									/*  print_r($data['emp_leave_list']);
									exit;  */
		
		/*  echo $br_code;
		exit; */
		
		return view('admin.leave.emp_leave_list',$data);
    }
    
	
	
	public function addleave()
    {
		$data = array(); 
		$indata = array(0);
		$data['br_code'] = $br_code = Session::get('branch_code'); 
		if(in_array($br_code,$indata)){
		 $data['application_date'] 		=  "2020-06-30";
		$data['form_date'] 				= $form_date = "2020-06-30"; 
		}else{
		  $data['application_date'] 		=  date('Y-m-d');
		  $data['form_date'] 				= $form_date = date('Y-m-d'); 
		}
		//$data['application_date'] 		=  "2021-06-30";
		//$data['form_date'] 				= $form_date = "2021-06-30"; 
		$data['action'] 				= 'insert_emp_leave_br/';   
		$data['emp_id'] 				= ""; 
		$data['db_id'] 					= ""; 
		$data['designation_code'] 		= ""; 
		$data['mode'] 					= ""; 
		$data['type_id'] 				= 1;  
		$data['no_of_days_appr'] 		= 0; 
		$data['is_pay'] 				= 1;  
		$data['button'] 				= "Save"; 
		$data['employee_his']			= ""; 
		$data['method_control'] 		=''; 
		$data['designation_name'] 		=''; 
		$data['emp_name'] 		=''; 
		   
		$data['from_date'] 				= date('Y-m-d'); 
		$data['to_date'] 				= ''; 
		$data['current_open_balance'] 	= 0; 
		$data['current_close_balance'] 	= 0; 
		$data['casual_leave_open'] 		= 0; 
		$data['casual_leave_close'] 	= 0; 
		$data['emp_photo'] 				= ''; 
		$data['no_of_days']				=0;
		$data['leave_remain']			=0;
		$data['remarks']				='';
		$data['status'] 				= $status = 1;
		
		
		
		$data['leave_type'] 			= DB::table('tbl_leave_type')->where('for_which',2)->orwhere('for_which',3)->get();
		$data['all_emp_type'] 			= DB::table('tbl_emp_type')->where('status',1)->get();
		$data['fiscal_year'] 			= DB::table('tbl_financial_year')
											->where('f_year_from','<=',$form_date)
											->where('f_year_to','>=',$form_date)
											->first();
		$data['f_year_id'] 				= $f_year_id = $data['fiscal_year']->id;
		$max_serial_no 		= DB::table('tbl_leave_history') 
									->where('for_which',2) 
									->where('branch_code',$br_code) 
									->where('f_year_id',$f_year_id) 
									->max('serial_no'); 	
		
		
		$data['serial_no'] 			= $max_serial_no + 1; 									
											
		 
	 
		/*  echo '<pre>';
		print_r($data['all_result']); 
		exit;  */
		return   view('admin.leave.employee_leave_form',$data);
    }
	public function get_emp_leave_info($emp_id,$f_year_id)
    {
		$data = array();  
		$form_date  				= date("Y-m-d");
        $data['emp_id'] 		= $emp_id ; 
        $data['f_year_id'] 			= $f_year_id; 		 
        $br_code 				= Session::get('branch_code'); 	
      
			$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $emp_id)
						->where('m.br_join_date', '=', function($query) use ($emp_id,$form_date)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $form_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('emp_id')
						->first();
				//print_r ($max_sarok);
			if(!empty($max_sarok)){
					$data_result = DB::table('tbl_master_tra as m')
								->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
								->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
								->leftJoin('tbl_designation_group as dg', 'd.designation_group_code', '=', 'dg.desig_group_code')
								->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
								->where('m.sarok_no', '=', $max_sarok->sarok_no)
								->select('e.emp_name_eng as emp_name','e.org_join_date as joining_date','e.permanent_add','m.br_join_date','m.br_code','d.designation_name','d.designation_code','b.branch_name','dg.desig_group_code')
								->first();
								
					$assign_designation = DB::table('tbl_emp_assign as ea')
												->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
												->leftJoin('tbl_designation_group as dg', 'de.designation_group_code', '=', 'dg.desig_group_code')
												->where('ea.emp_id', $emp_id)
												->where('ea.status', '!=', 0)
												->where('ea.select_type', '=', 5)
												->select('ea.emp_id','ea.open_date','de.designation_name','de.designation_code','dg.desig_group_code')
												->first();
					if(!empty($assign_designation)) { 
						$designation_name = $assign_designation->designation_name;
						$designation_code = $assign_designation->designation_code;
						$desig_group_code = $assign_designation->desig_group_code;
					} else {
						$designation_name 		= $data_result->designation_name;
						$desig_group_code 	=  $data_result->desig_group_code;
						$designation_code 	=  $data_result->designation_code;
					}
					$assign_branch = DB::table('tbl_emp_assign as ea')
												->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code')
												->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
												->where('ea.emp_id', $emp_id)
												->where('ea.open_date', '<=', $form_date)
												->where('ea.status', '!=', 0)
												->where('ea.select_type', '=', 2)
												->select('ea.emp_id','ea.open_date','ea.br_code','br.branch_name','ar.area_name')
												->first();
					if(!empty($assign_branch)) {
						$asign_branch_code = $assign_branch->br_code;
						$asign_branch_name = $assign_branch->branch_name;
						$asign_area_name = $assign_branch->area_name;
					} else {
						$asign_branch_code = '';
						$asign_branch_name = '';
						$asign_area_name =  '';
						$asign_open_date =  '';
					}		
					$data['desig_group_code'] 	= $desig_group_code; 
					$data['designation_code'] 	= $designation_code; 
					$data['joining_date'] 		= $data_result->joining_date;
					$data['joining_date_view'] 	= date("d-m-Y",strtotime($data_result->joining_date));						
					$data['branch_name'] 		= $data_result->branch_name;					
					$data['br_code'] 			= $data_result->br_code;					
					$data['designation_name'] 	= $designation_name;					
					$data['emp_name'] 			= $data_result->emp_name;					
					$data['emp_photo'] 			= $emp_id.'.jpg';	 
				}else{
					$data['br_code'] 			= ''; 
					$data['desig_group_code']	= '';
					$data['designation_code']	= '';
				} 				
		
	if($br_code == $data['br_code'] ){
		$emp_leave_balance = DB::table('tbl_leave_balance as lb') 
									->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'lb.f_year_id')
									->where('lb.emp_id',$emp_id) 
									->where('lb.f_year_id',$f_year_id) 
									->select('fy.f_year_from','lb.no_of_days','lb.current_open_balance','lb.cum_close_balance','lb.current_close_balance','lb.cum_balance_less_close_12','lb.pre_cumulative_close','lb.cum_close_balance','lb.casual_leave_open','lb.casual_leave_close')
									->first(); 
		
		  if($emp_leave_balance){
			    $data['f_year_from']  			= $emp_leave_balance->f_year_from;	
				$data['tot_expense']  			= $emp_leave_balance->no_of_days;  
				$data['current_open_balance'] 	= $emp_leave_balance->current_open_balance; 
				$data['casual_leave_open'] 		= $emp_leave_balance->casual_leave_open; 
				$data['casual_leave_close'] 	= $emp_leave_balance->casual_leave_close; 
				$data['leave_remain'] 			= $data['current_open_balance'] - $data['tot_expense']; 
				$data['current_close_balance'] 	= $emp_leave_balance->current_close_balance; 
				$data['pre_cumulative_close'] 	= $emp_leave_balance->pre_cumulative_close; 
				$data['cum_close_balance'] 	= $emp_leave_balance->cum_close_balance; 
				$data['is_current_br'] 			= 1;  
		  }
	}else{
		 
			    $data['f_year_from']  			= '';	
				$data['tot_expense']  			= '';  
				$data['current_open_balance'] 	= ''; 
				$data['casual_leave_open'] 	= ''; 
				$data['casual_leave_close'] 	= ''; 
				$data['leave_remain'] 			= ''; 
				$data['current_close_balance'] 	= ''; 
				$data['pre_cumulative_close'] 	= ''; 
				$data['cum_close_balance'] 	= ''; 
				$data['is_current_br'] 			= 2; 
				 
		 
	}
			
	  
		/* echo '<pre>';
		print_r($br_code);
		exit;   */
	 
		return $data;
		 
    }
	public function selecttotleave($type_id)
    {   
		 $y_tot_leave = DB::table('tbl_leave_type')
					  ->select('no_of_days')
					  ->where('id',$type_id) 
					  ->where('sta_tus',1) 
                      ->first();
		if(!empty($y_tot_leave)){
			echo $y_tot_leave->no_of_days;
		}else{
			echo 0;
		}  
	}
    public function insert_emp_leave_br(Request $request)
    {
		 
		$datahis = array(); 
		$datatest = array(); 
		$data = array(); 
		$data1 = array(); 
		$data2 = array(); 
		$datahis['emp_id'] 				= $emp_id = $request->emp_id;
		$datahis['serial_no'] 			= $request->serial_no;
		$datahis['designation_code'] 	= $request->designation_code;
		$datahis['branch_code'] 		= $request->branch_code; 
		$datahis['supervisor_id'] 		= Session::get('emp_id');
		$datahis['approved_id'] 		= Session::get('emp_id');
        $datahis['application_date'] 	= $request->application_date; 
        $datahis['type_id'] 			= $request->type_id;
        $datahis['is_pay'] 				= $request->is_pay;
        $datahis['f_year_id'] 			= $f_year_id = $request->f_year_start;
        $datahis['from_date'] 			= $request->from_date;
        $datahis['to_date'] 			= $request->to_date;
		
		$data2 = $this->leave_validation($datahis['from_date'],$datahis['to_date'],0);
		
		$datahis['leave_dates']			= $data2['leave_dates'];
		
        $datahis['appr_to_date'] 		= $request->to_date;
        $datahis['appr_from_date'] 		= $request->from_date;
        $datahis['sup_recom_date'] 		= date("Y-m-d");
        $datahis['appr_appr_date'] 		= date("Y-m-d");
        $datahis['no_of_days_appr']		= $request->no_of_days;
		$datahis['tot_earn_leave']		= $request->tot_earn_leave;
        $datahis['no_of_days']			= $request->no_of_days;
        $datahis['remarks'] 			= $request->remarks; 
        $datahis['leave_adjust'] 		= $leave_adjust = $request->leave_adjust; 
        $datahis['sup_status'] 			= 1; 
        $datahis['appr_status'] 		= 1; 
        $datahis['for_which'] 			= 2; 
        $datahis['leave_remain'] 		= $request->leave_remain; 
        $datahis['user_code'] 			= Session::get('admin_id');
		
		
		
		 
		$casual_leave_close 				= $request->casual_leave_close; 
		$pre_cumulative_close 				= $request->pre_cumulative_close; 
		$cum_close_balance 					= $request->cum_close_balance; 
		
		
		DB::beginTransaction();
		try {	
			
			$datatest['his_id'] = DB::table('tbl_leave_history')->insertGetId($datahis);
			        
			if( ($datahis['type_id'] == 1) &&  ($datahis['is_pay'] == 1 ) &&  ($datahis['leave_adjust'] == 1 )){
				$data['current_close_balance'] 		= $request->current_close_balance; 
				$data['last_update_date'] 			=  date('Y-m-d');  	 
				$data['no_of_days'] 				= ($request->no_of_days + $request->tot_expense);  
				DB::table('tbl_leave_balance')
					->where('emp_id', $emp_id)
					->where('f_year_id', $f_year_id)
					->update($data);
			}else if(($datahis['type_id'] == 5) &&  ($datahis['is_pay'] == 1 ) &&  ($datahis['leave_adjust'] == 1 )){
				$data1['casual_leave_close'] 		= $request->casual_leave_close; 
				$data1['last_update_date'] 			=  date('Y-m-d'); 
				DB::table('tbl_leave_balance')
					->where('emp_id', $emp_id)
					->where('f_year_id', $f_year_id)
					->update($data1); 
			}else if($leave_adjust == 2){
					DB::table('tbl_leave_balance')
					->where('emp_id', $emp_id)
					->where('f_year_id', $f_year_id)
					->update(['pre_cumulative_close' => $pre_cumulative_close,'cum_close_balance' => $cum_close_balance]);
			}
			
			DB::commit();
			Session::put('message','Data Saved Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		} 
	/* 	echo '<pre>';
		print_r($datahis); 
		exit; */
		
		//DB::table('tbl_leave_history')->insert($datahis);
		return Redirect::to('/emp-leave');
    } 
    public function emp_leave_br_edit($id)
    {
        $datahis = array();
		$datahis['designation_name'] 	= '';  
		$datahis['db_id'] 				= $id;  
		//$datahis['method_control'] ="<input type='hidden' name='_method' value='PUT' />"; 
		$datahis['leave_type'] 	= DB::table('tbl_leave_type')->get();
		
		$datahis['all_emp_type'] 			= DB::table('tbl_emp_type')->where('status',1)->get();
		
		$emp_leave_his = DB::table('tbl_leave_history') 
					  ->where('id',$id)  
                      ->first(); 
		$datahis['serial_no'] 			= $emp_leave_his->serial_no;
		$datahis['f_year_id'] 			=$f_year_id 			= $emp_leave_his->f_year_id;
		$datahis['emp_id'] 				=$emp_id 			= $emp_leave_his->emp_id;
		$datahis['br_code'] 			=$branch_code 		= $emp_leave_his->branch_code;
		$datahis['designation_code'] 	=$designation_code 	= $emp_leave_his->designation_code;
		$datahis['button'] = "Update"; 
		$datahis['action'] = "emp_leave_br_update"; 
		$datahis['mode'] = 'edit';  
		/* echo '<pre>';
		print_r($emp_leave_his); 
		exit; */ 
		$result = DB::table('tbl_emp_basic_info as m') 
								->where('m.emp_id', '=', $emp_id)
								->select('m.emp_name_eng as emp_name','m.org_join_date as joining_date')
								->first();
			$datahis['joining_date'] 		= $result->joining_date;					
			$datahis['emp_name'] 			= $result->emp_name;					
			$datahis['emp_photo'] 			= $emp_id.'.jpg';					
								
		 
		$designation_info = DB::table('tbl_designation') 
									->where('designation_code',$designation_code) 
									->select('designation_name')
									->first();
		if($designation_info){
			$datahis['designation_name'] 			= $designation_info->designation_name;
		}							
		
		$emp_leave_balance 			= DB::table('tbl_leave_balance')
										->select('*')
										->where('f_year_id',$f_year_id)  
										->where('emp_id',$emp_id) 
										->first();
										
		$datahis['fiscal_year'] 		= DB::table('tbl_financial_year')->where('id', '=', $f_year_id)->first(); 
        $datahis['no_of_days'] 				= $emp_leave_balance->no_of_days; 
		//print_r($datahis['no_of_days']);
        $datahis['casual_leave_open'] 	= $emp_leave_balance->casual_leave_open; 
        $datahis['casual_leave_close'] 	= $emp_leave_balance->casual_leave_close; 
        $datahis['current_open_balance'] 	= $emp_leave_balance->current_open_balance; 
        $datahis['current_close_balance'] 	= $emp_leave_balance->current_close_balance; 
        $datahis['cum_close_balance'] 		= $emp_leave_balance->cum_close_balance; 
        $datahis['pre_cumulative_close'] 	= $emp_leave_balance->pre_cumulative_close; 
        $datahis['application_date'] 		= $emp_leave_his->application_date; 
        $datahis['type_id'] 				= $emp_leave_his->type_id; 
        $datahis['is_pay'] 					= $emp_leave_his->is_pay;
        $datahis['from_date'] 				= $emp_leave_his->from_date;
        $datahis['to_date'] 				= $emp_leave_his->to_date;
        $datahis['no_of_days_appr'] 		= $emp_leave_his->no_of_days_appr; 
		$datahis['leave_adjust'] 			= $emp_leave_his->leave_adjust; 
		if(($datahis['type_id']==1) && ($datahis['is_pay'] == 1) && ($datahis['leave_adjust'] == 1) ){
			$datahis['no_of_days'] = $datahis['no_of_days'] - $datahis['no_of_days_appr']; 
		} 
		$datahis['leave_remain'] 			= $datahis['current_open_balance'] -  $datahis['no_of_days'];
        $datahis['tot_earn_leave'] 			= $emp_leave_his->tot_earn_leave; 
        $datahis['remarks'] 				= $emp_leave_his->remarks; 
        $datahis['reported_to'] 			= $emp_leave_his->supervisor_id; 
		//print_r($datahis['no_of_days_appr']);
		/* print_r($datahis['no_of_days']);
		exit; */
		return view('admin.leave.employee_leave_form_edit',$datahis); 
    }
    public function emp_leave_br_update(Request $request)
    {
		$data1 = array();
		$data = array();
		$ldata = array();
		$cdata = array();
		$db_id 		= $request->db_id;
		$current_open_balance 				= $request->current_open_balance;
		$ldata['current_close_balance'] 	= $request->current_close_balance;
		$f_year_id 							= $request->f_year_id;
		$emp_id 							= $request->emp_id; 
		$data['application_date'] 			= $request->application_date; 
        $type_id 							= $request->type_id; 
        $data['is_pay'] 					= $request->is_pay; 
        $data['from_date'] 					= $request->from_date;
        $data['to_date'] 					= $request->to_date;
		
		$data1 = $this->leave_validation($data['from_date'],$data['to_date'],0);
		
		$data['leave_dates']			= $data1['leave_dates'];
		 
        $data['appr_to_date'] 				= $request->to_date;
        $data['appr_from_date'] 			= $request->from_date;
        $data['sup_recom_date'] 			= $request->from_date;
        $data['appr_appr_date'] 			= $request->from_date;
        $data['no_of_days_appr']			= $request->no_of_days;
        $data['no_of_days']					= $request->no_of_days;
        $leave_adjust 						= $request->leave_adjust;
        $pre_cumulative_close 				= $request->pre_cumulative_close;
        $cum_close_balance 					= $request->cum_close_balance;
        $cdata['casual_leave_close']		= $request->casual_leave_close;
        $data['remarks'] 					= $request->remarks; 
        $data['tot_earn_leave'] 			= $request->tot_earn_leave;
        $data['leave_remain'] 				= $request->leave_remain;
       
		
		DB::beginTransaction();
		try {	
			
			 DB::table('tbl_leave_history')
				->where('id', $db_id)
				->update($data);
			 
				if(($type_id == 1) &&($leave_adjust == 1)){
			 
						$ldata['no_of_days'] 				=  $current_open_balance  - $ldata['current_close_balance']; 
					 
					 DB::table('tbl_leave_balance') 
						->where('emp_id', $emp_id)
						->where('f_year_id', $f_year_id)
						->update($ldata); 
				}else if(($type_id == 5) &&($leave_adjust == 1)){
			  
					 DB::table('tbl_leave_balance') 
						->where('emp_id', $emp_id)
						->where('f_year_id', $f_year_id)
						->update($cdata); 
				}else if($leave_adjust == 2){
					 DB::table('tbl_leave_balance') 
						->where('emp_id', $emp_id)
						->where('f_year_id', $f_year_id)
						->update(['pre_cumulative_close' => $pre_cumulative_close,'cum_close_balance' => $cum_close_balance]);
				} 
			DB::commit();
			Session::put('message','Data Update Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		}
		/* echo '<pre>';
		print_r($data);
		exit; */
		 return Redirect::to('/emp-leave');
    }
	public function emp_leave_br_del($id)
    {
		$data = array();
		$ldata = array();
		$liv_his = DB::table('tbl_leave_history')
					->where('id', $id)
					->first();  
		$emp_id 			=$liv_his->emp_id;
		$f_year_id 			=$liv_his->f_year_id;
		$type_id 			=$liv_his->type_id;
		$is_pay 			=$liv_his->is_pay;
		$no_of_days_appr 	=$liv_his->no_of_days_appr;  
		$leave_adjust 		=$liv_his->leave_adjust;  
		DB::beginTransaction();
		try {	
			
			 DB::table('tbl_leave_history')
				->where('id', $id)
				->delete();
			
				if(($type_id == 1) && ($is_pay == 1) && ($leave_adjust == 1)){ 
					 $query = DB::table('tbl_leave_balance') 
								->where('emp_id', $emp_id)
								->where('f_year_id', $f_year_id);
						 $query->increment('current_close_balance', $no_of_days_appr);
						 $query->decrement('no_of_days', $no_of_days_appr); 
				}else if(($type_id == 5) && ($is_pay == 1)){ 
					 $query = DB::table('tbl_leave_balance') 
								->where('emp_id', $emp_id)
								->where('f_year_id', $f_year_id);
						 $query->increment('casual_leave_close', $no_of_days_appr);
				}else if(($leave_adjust == 2) && ($is_pay == 1)){
					 $query = DB::table('tbl_leave_balance') 
								->where('emp_id', $emp_id)
								->where('f_year_id', $f_year_id);
						 $query->increment('pre_cumulative_close', $no_of_days_appr); 
						 $query->increment('cum_close_balance',$no_of_days_appr); 
				 
				} 
			DB::commit();
			Session::put('message','Data Delete Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		}
		/* echo '<pre>';
		print_r($data);
		exit; */
		 return Redirect::to('/emp-leave');
    }
	public function leave_date_exist_br($from_date,$to_date,$emp_id){
			$data = array();	 
		
			$check_leave_date_half = DB::table('tbl_leave_history') 
										->where('emp_id',$emp_id)    
										->where('is_view',1)
										->where(function($q) use ($from_date) {
													 $q->where('appr_from_date','>=', $from_date)
													   ->orWhere('appr_to_date','>=', $from_date);
												 })
										->where(function($q) use ($to_date) {
											 $q->where('appr_from_date','<=', $to_date)
											   ->orWhere('appr_to_date','<=', $to_date);
										 })
										->select('no_of_days')	
										->first();	 
				//print_r($check_leave_date_half);
				
				if($check_leave_date_half){
					if($check_leave_date_half->no_of_days == 0.5 ){
						$check_leave_date = '';
					}else{ 
						$check_leave_date = DB::table('tbl_leave_history') 
											->where('emp_id',$emp_id)   
											->where('is_view',1)
											->where(function($q) use ($from_date) {
													 $q->where('appr_from_date','>=', $from_date)
													   ->orWhere('appr_to_date','>=', $from_date);
												 })
											->where(function($q) use ($to_date) {
												 $q->where('appr_from_date','<=', $to_date)
												   ->orWhere('appr_to_date','<=', $to_date);
											 })
											->select('no_of_days')	
											->first();		
					}  
				}else{
					$check_leave_date = '';
				}
				 
				//print_r($from_date);
				if($check_leave_date){
					//echo '1';
					$data = $this->leave_validation($from_date,$to_date,1);
				}else{
					//echo '0';
					$data = $this->leave_validation($from_date,$to_date,0);
				}
				return $data;
	}
	public function leave_date_exist_edit_br($from_date,$to_date,$emp_id,$db_id)
	{
				 
		$data = array();	
			$check_leave_date_half = DB::table('tbl_leave_history')  
										->where('emp_id',$emp_id)  
										->where('id','!=',$db_id)
										->where('is_view',1)
										->where(function($q) use ($from_date) {
													 $q->where('appr_from_date','>=', $from_date)
													   ->orWhere('appr_to_date','>=', $from_date);
												 })
										->where(function($q) use ($to_date) {
											 $q->where('appr_from_date','<=', $to_date)
											   ->orWhere('appr_to_date','<=', $to_date);
										 }) 
										->select('no_of_days')	
										->first();
				//print_r($check_leave_date_half);
				
				if($check_leave_date_half){
					if($check_leave_date_half->no_of_days == 0.5 ){
						$check_leave_date = '';
					}else{ 
						$check_leave_date = DB::table('tbl_leave_history') 
											->where('emp_id',$emp_id)  
											->where('is_view',1)
											->where('id','!=',$db_id)
											->where(function($q) use ($from_date) {
													 $q->where('appr_from_date','>=', $from_date)
													   ->orWhere('appr_to_date','>=', $from_date);
												 })
											->where(function($q) use ($to_date) {
												 $q->where('appr_from_date','<=', $to_date)
												   ->orWhere('appr_to_date','<=', $to_date);
											 })  
											->select('no_of_days')	
											->first();		
					}  
				}else{
					$check_leave_date = '';
				}
				 
				//print_r($from_date);
				if($check_leave_date){
					//echo '1';
					 $data = $this->leave_validation($from_date,$to_date,1); 
				}else{
					//echo '0';
					 $data = $this->leave_validation($from_date,$to_date,0); 
				}
				return $data;
	}
	public function leave_validation($form_date, $to_date,$is_leave_date)
	{
		$actual_dates = array();
		date_default_timezone_set('Asia/Dhaka');
		if($form_date <= "2020-11-30"){
			$dStart=date_create($form_date);
			$dEnd=date_create($to_date);
			$dDiff=date_diff($dStart,$dEnd);
			$duration = $dDiff->format('%r%a')+1;
			$leave_days = $duration;
			$flag = 1;
			$leave_dates = '';
		}else{ 
			$form_date_new = date('Y-m-d', strtotime($form_date . "-1 days"));
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

			$leave_days = count($actual_dates);
			if ($leave_days == 0) {
				$flag = 0;
				$leave_days = 0;
				$message = 'There is no date during this period.'; 
				$leave_dates = '';
			}
			else{
				$flag = 1;
				$message = '';
				$leave_dates =	implode(",", $actual_dates);
			}
		
		}
					
		
		$data['is_leave_date'] = $is_leave_date;
		$data['flag'] = $flag;
		$data['days'] = $leave_days;
		$data['leave_dates'] = $leave_dates;
		return $data;
	}
}
