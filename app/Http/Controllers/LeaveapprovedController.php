<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Middleware\Checkuser;
use DB;
use Session;
class LeaveapprovedController extends Controller
{

	 public function __construct() 
	{
		$this->middleware("CheckUserSession");
	} 
	
	public function index()
    {
        $data = array();
		$data['emp_approve_list'] = DB::table('tbl_leave_history') 
									->leftJoin("tbl_emp_basic_info as emp",function($join){
											$join->on("emp.emp_id","=","tbl_leave_history.emp_id");
									})
									 ->leftJoin('tbl_branch as b', 'tbl_leave_history.branch_code', '=', 'b.br_code') 
									 ->leftJoin('tbl_designation as d', 'tbl_leave_history.designation_code', '=', 'd.designation_code') 
									/* ->leftJoin("tbl_emp_non_id as nid",function($join){
											$join->on("nid.sacmo_id","=","tbl_leave_history.emp_id")
												->on("nid.emp_type_code","=","tbl_leave_history.emp_type");
										}) 
									->leftjoin('tbl_emp_type as et',function($join){
										$join->on('et.id', "=","tbl_leave_history.emp_type"); 
									})*/
									->leftjoin('tbl_leave_type as lt',function($join){
										$join->on('lt.id', "=","tbl_leave_history.type_id"); 
									})	 
									->where('tbl_leave_history.for_which',1)
									->where('tbl_leave_history.is_view',1)
									->where('tbl_leave_history.f_year_id',4)
									->orderby('tbl_leave_history.serial_no','desc')
									->select('tbl_leave_history.*','emp.emp_name_eng as emp_name','b.branch_name','d.designation_name','lt.type_name')
									->get();
		/*  echo '<pre>';
		print_r($data['emp_approve_list']);
		exit; */  
		return view('admin.leave.leave_approved_list',$data);
    }
	 
	public function approvedleave($id,$f_year_id,$emp_id)
    { 
		$datahis = array();
		$data = array();
		$br_code = 9999;
		$form_date 				= date('Y-m-d'); 
		$designation			= array(1,26,29,38,47,99,166,48,194,111,145,144,167,162,147,209,211,225,263,257,264,273,277,278,276,275,282,271);
		$datahis['fiscal_year'] = DB::table('tbl_financial_year')->where('status',1)->get();
		$datahis['leave_type'] 	= DB::table('tbl_leave_type')->get();
		$zonal_designation = 26;
		$nonid_designation = 38;
		$nonid_designation1 = 194; 
		$nonid_designation2 = 169;
		$nonid_designation3 = 144;
		$nonid_designation4 = 224;
		$nonid_designation5 = 264;
		/* echo '<pre>';
		print_r($datahis['leave_type']);
		exit;   */
		$datahis['db_id'] 	= $id;
		 
			 	$emp_leave_his = DB::table('tbl_leave_history') 
					 ->leftJoin('tbl_emp_basic_info as emp', 'tbl_leave_history.emp_id', '=', 'emp.emp_id')
					 ->leftJoin('tbl_designation as d', 'tbl_leave_history.designation_code', '=', 'd.designation_code') 
					 ->leftJoin('tbl_branch as b', 'tbl_leave_history.branch_code', '=', 'b.br_code') 
					 ->where('tbl_leave_history.id',$id)  
                     ->select('tbl_leave_history.*','emp.emp_name_eng as emp_name','emp.org_join_date','b.branch_name','d.designation_name')
					 ->first(); 
		  
	
					  
        
        $datahis['branch_name'] 		= $emp_leave_his->branch_name; 
        $datahis['designation_name'] 	= $emp_leave_his->designation_name; 
        $datahis['emp_name'] 			= $emp_leave_his->emp_name; 
        $datahis['employee_id'] 		= $emp_leave_his->emp_id; 
        $datahis['emp_id'] 				= $emp_id = $emp_leave_his->emp_id; 
        $datahis['joining_date'] 		= $emp_leave_his->org_join_date;  
        $datahis['serial_no'] 			= $emp_leave_his->serial_no; 
        $datahis['f_year_id'] 			= $f_year_id = $emp_leave_his->f_year_id; 
        $datahis['designation_code']	= $emp_leave_his->designation_code; 
        $datahis['branch_code']			= $emp_leave_his->branch_code; 
        $datahis['type_id']				= $emp_leave_his->type_id; 
        $datahis['is_pay']				= $emp_leave_his->is_pay; 
        $datahis['application_date']	= $emp_leave_his->application_date; 
        $datahis['from_date']			= $emp_leave_his->from_date; 
        $datahis['to_date']				= $emp_leave_his->to_date; 
        $datahis['no_of_days']			= $emp_leave_his->no_of_days;  
        $datahis['leave_remain']		= $emp_leave_his->leave_remain;   
        $datahis['remarks']				= $emp_leave_his->remarks; 
        $datahis['approved_id']			= $emp_leave_his->approved_id;  
        $datahis['appr_desig_code']		= $emp_leave_his->appr_desig_code;  
        $datahis['appr_from_date']		=  $emp_leave_his->from_date;  
        $datahis['sup_recom_date']		=  $emp_leave_his->from_date;  
        $datahis['appr_to_date']		=  $emp_leave_his->to_date;  
        $datahis['appr_appr_date']		=  $emp_leave_his->to_date;  
        $datahis['no_of_days_appr']		=  $emp_leave_his->no_of_days;  
        $datahis['tot_earn_leave']		=  $emp_leave_his->tot_earn_leave;  
        $datahis['leave_adjust']		=  $emp_leave_his->leave_adjust;
        $datahis['apply_for']		=  $emp_leave_his->apply_for;
        
		 
		$emp_leave_balance = DB::table('tbl_leave_balance as lb') 
									->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'lb.f_year_id') 
									->where('lb.emp_id',$emp_id)  
									->where('lb.f_year_id',$f_year_id) 
									->select('fy.f_year_from','lb.no_of_days','lb.current_open_balance','lb.casual_leave_close','lb.cum_close_balance','lb.current_close_balance','lb.cum_balance_less_close_12','lb.pre_cumulative_close')
									->first(); 
		$datahis['f_year_from'] 				= $emp_leave_balance->f_year_from;
		$datahis['pre_cumulative_open'] 		= $emp_leave_balance->pre_cumulative_close; 
		$datahis['cum_balance'] 				= $emp_leave_balance->cum_close_balance; 
		$datahis['current_open_balance'] 		= $emp_leave_balance->current_close_balance;	
		$datahis['casual_leave_open'] 			= $emp_leave_balance->casual_leave_close ;	
		$datahis['cum_balance_less_12'] 		= $emp_leave_balance->cum_balance_less_close_12; 
		if(($emp_leave_his->leave_adjust == 1) && ($emp_leave_his->type_id == 1)){
			$datahis['current_open_balance'] 	= $emp_leave_balance->current_close_balance + $emp_leave_his->no_of_days;
			 $datahis['leave_remain']			= $emp_leave_his->leave_remain - $emp_leave_his->no_of_days;  
		}else if(($emp_leave_his->leave_adjust == 1) && ($emp_leave_his->type_id == 5)){
			$datahis['casual_leave_open'] 	= $emp_leave_balance->casual_leave_close + $emp_leave_his->no_of_days; 
		}else if($emp_leave_his->leave_adjust == 2){
			$datahis['cum_balance'] 				= $emp_leave_balance->cum_close_balance + $emp_leave_his->no_of_days; 
			$datahis['pre_cumulative_open'] 		= $emp_leave_balance->pre_cumulative_close + $emp_leave_his->no_of_days; 
		}else if($emp_leave_his->leave_adjust == 3){
			$datahis['cum_balance_less_12'] 		= $emp_leave_balance->cum_balance_less_close_12 + $emp_leave_his->no_of_days; 
		}
		
		$datahis['pre_cumulative_close'] 		= $emp_leave_balance->pre_cumulative_close;
		$datahis['cum_close_balance'] 		    = $emp_leave_balance->cum_close_balance;
		$datahis['current_close_balance'] 		= $emp_leave_balance->current_close_balance;
		$datahis['casual_leave_close'] 		= $emp_leave_balance->casual_leave_close;
		$datahis['cum_balance_less_close_12'] 	= $emp_leave_balance->cum_balance_less_close_12; 
		$datahis['tot_expense'] 				= $emp_leave_balance->no_of_days; 
        $datahis['last_update_date'] 			=  date('Y-m-d');  
		
		$all_result = DB::table('tbl_master_tra as m')
					 ->leftJoin('tbl_resignation as r',function($join) use ($form_date){
												$join->on("m.emp_id","=","r.emp_id") 
												->Where('r.effect_date', '<=', $form_date);
														})	 
					->where('m.br_code', '=', $br_code)
					->orWhere('m.designation_code', '=', 211)
					->where('m.br_join_date', '<=', $form_date) 
					->select('m.emp_id','r.effect_date') 
					->groupBy('m.emp_id')
					->get(); 
				 if (!empty($all_result)) {
					foreach ($all_result as $result) {
						if(empty($result->effect_date)){
							$emp_id1 = $result->emp_id; 
							$max_sarok = DB::table('tbl_master_tra as m')
										->where('m.emp_id', '=', $emp_id1)
										->where('m.br_join_date', '=', function($query) use ($emp_id1,$form_date)
												{
													$query->select(DB::raw('max(br_join_date)'))
														  ->from('tbl_master_tra')
														  ->where('emp_id',$emp_id1)
														  ->where('br_join_date', '<=', $form_date);
												})
										->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
										->groupBy('emp_id')
										->first();	
						$emp_info = DB::table('tbl_master_tra as m') 
									//->leftJoin('tbl_appointment_info as emp', 'emp.emp_id', '=', 'm.emp_id')   
									->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
									->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')  
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->select('emp.emp_id','emp.emp_name_eng as emp_name','d.designation_name','m.designation_code')
									->first();  
							 if(in_array($emp_info->designation_code, $designation)) {
								$datahis['branch_staff'][] = array(
									'emp_id' 			 => $emp_info->emp_id,
									'emp_name'       	 => $emp_info->emp_name, 
									'designation_code'   => $emp_info->designation_code,
									'designation_name'   => $emp_info->designation_name
								); 
							 }  	
					}
					}
				} 
				/* $getnonidStaff = DB::table('tbl_emp_non_id as nonid')   
										->leftjoin('tbl_nonid_official_info',function($join){
												$join->on("nonid.emp_id","=","tbl_nonid_official_info.emp_id")
													->where('tbl_nonid_official_info.sarok_no',DB::raw("(SELECT 
																				  max(tbl_nonid_official_info.sarok_no)
																				  FROM tbl_nonid_official_info 
																				   where nonid.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
																				  max(t.joining_date)
																				  FROM tbl_nonid_official_info as t 
																				   where nonid.emp_id = t.emp_id)
																				  )") 		 
															); 
														})	
									->leftJoin('tbl_designation as dg', 'dg.designation_code', '=', 'tbl_nonid_official_info.designation_code') 
									->where('tbl_nonid_official_info.designation_code',$nonid_designation) 
									->orwhere('tbl_nonid_official_info.designation_code',$nonid_designation1) 
									->orwhere('tbl_nonid_official_info.designation_code',$nonid_designation2) 
									->orwhere('tbl_nonid_official_info.designation_code',$nonid_designation3) 
									->orwhere('tbl_nonid_official_info.designation_code',$nonid_designation4) 
									->orwhere('tbl_nonid_official_info.designation_code',$nonid_designation5) 
									->select('nonid.sacmo_id as emp_id','nonid.emp_name','dg.designation_name','dg.designation_code')
									->get(); 
				
				
				if(!empty($getnonidStaff)){
					 foreach ($getnonidStaff as $nonidStaff) {
						$datahis['branch_staff'][] = array(
									'emp_id'   		   => $nonidStaff->emp_id,
									'emp_name' 		   => $nonidStaff->emp_name,  
									'designation_code' => $nonidStaff->designation_code, 
									'designation_name' => $nonidStaff->designation_name  
								);
					}
				} */
		$datahis['all_emp_type'] = DB::table('tbl_emp_type')->where('status',1)->get();				
	/* 	echo '<pre>';
		print_r($datahis);
		exit;  */
		return view('admin.leave.emp_approved_pre_form_edit',$datahis);
    } 
	public function add_aprove_leave()
    {
		$datahis = array();
		$datahis['employee_his'] 		= ''; 
		$datahis['is_pay'] 				= ''; 
		$datahis['leave_adjust'] 		= '';  
		$datahis['employee_id'] 		= ''; 
		$datahis['type_id'] 			= ''; 
		$datahis['approved_id'] 		= ''; 
		$datahis['appr_desig_code'] 		= ''; 
		$current_date                   = date('Y-m-d');
		//$current_date                   = "2019-06-30";
		$f_year_id						= DB::table('tbl_financial_year')
												->where('f_year_from','<=',$current_date)
												->where('f_year_to','>=',$current_date)
												->select('id')
												->first();
		$datahis['f_year_id'] 			= $f_year_id->id; 
		/* echo '<pre>';
		print_r($datahis['f_year_id'] );
		exit;  */
		$datahis['all_emp_type'] 		= DB::table('tbl_emp_type')->where('status',1)->get(); 
		/* echo '<pre>';
		print_r($datahis['emp_type'] );
		exit; */
		$datahis['fiscal_year'] 		= DB::table('tbl_financial_year')->where('status',1)->get();
		return view('admin.leave.emp_approved_pre_form',$datahis);
    }
	public function search_emp_info(Request $request)
    {
		$data = array();
		$datahis = array();
		$asigndata = array(1,2,5); 
		$br_code	 			= 9999; 
		$designation			= array(1,26,29,38,47,99,166,48,194,111,145,144,167,162,147,209,211,225,263,257,176,264,273,277,278,276,275,282,271);
		$zonal_designation = 26;
		$nonid_designation = 38;
		$nonid_designation1 = 194; 
		$nonid_designation2 = 169;
		$nonid_designation3 = 144;
		$nonid_designation4 = 224;
		$datahis['f_year_id']   = $f_year_id = $request->f_year_start; 
		$datahis['fiscal_year'] = DB::table('tbl_financial_year')->where('status',1)->get(); 
		$datahis['employee_id'] = $employee_id 	= $request->employee_id; 
		$form_date 				= date('Y-m-d'); 
		$datahis['leave_type'] 	= DB::table('tbl_leave_type')->get();
		 
		$datahis['employee_his']  = DB::table('tbl_emp_assign as es')  
										->leftJoin('tbl_emp_basic_info as emp', 'es.emp_id', '=', 'emp.emp_id')
										->leftJoin('tbl_designation as d', 'es.designation_code', '=', 'd.designation_code') 
										->leftJoin('tbl_branch as b', 'es.br_code', '=', 'b.br_code') 
										->leftJoin('tbl_zone as z', 'z.zone_code', '=', 'b.zone_code') 
										->where('es.emp_id',$employee_id)
										->where('es.open_date', '<=', $form_date)
										->where('es.status', '!=', 0)
										->whereIn('es.select_type', $asigndata)
										->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','z.zone_name','emp.org_join_date as joining_date')
										->first(); 
			
			if(empty($datahis['employee_his'])){
				 
				$max_sarok = DB::table('tbl_master_tra as m')
										->where('m.emp_id', '=', $employee_id)
										->where('m.br_join_date', '=', function($query) use ($employee_id,$form_date)
												{
													$query->select(DB::raw('max(br_join_date)'))
														  ->from('tbl_master_tra')
														  ->where('emp_id',$employee_id)
														  ->where('br_join_date', '<=', $form_date);
												})
										->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
										->groupBy('emp_id')
										->first();				
				if(!empty($max_sarok)){
					$datahis['employee_his']  = DB::table('tbl_master_tra as m')  
											->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
											->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
											->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
											->where('m.sarok_no', '=', $max_sarok->sarok_no)
											->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','emp.org_join_date as joining_date')
											->first(); 
				}
				
			}
	 
		 $emp_leave_balance = DB::table('tbl_leave_balance as lb') 
									->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'lb.f_year_id') 
									->where('lb.emp_id',$employee_id) 
									->where('lb.f_year_id',$f_year_id) 
									->select('fy.f_year_from','lb.no_of_days','lb.current_open_balance','lb.casual_leave_close','lb.cum_close_balance','lb.current_close_balance','lb.cum_balance_less_close_12','lb.pre_cumulative_close')
									->first();
		
		/* echo '<pre>';
		print_r($f_year_id);
		exit;    */
		$max_serial_no 		= DB::table('tbl_leave_history') 
									->where('for_which',1) 
									->where('f_year_id',$f_year_id) 
									->max('serial_no'); 	
		
		
		$datahis['serial_no'] 			= $max_serial_no + 1; 
		
		  if($emp_leave_balance){
			    $datahis['f_year_from']  			= $emp_leave_balance->f_year_from;	
				$datahis['tot_expense']  			= $emp_leave_balance->no_of_days;	
				$datahis['pre_cumulative_open'] 	= $emp_leave_balance->pre_cumulative_close; 
				$datahis['casual_leave_open'] 		= $emp_leave_balance->casual_leave_close; 
				$datahis['cum_balance'] 			= $emp_leave_balance->cum_close_balance; 
				$datahis['current_open_balance'] 	= $emp_leave_balance->current_close_balance; 
				$datahis['cum_balance_less_12'] 	= $emp_leave_balance->cum_balance_less_close_12; 
		  }
		
	/* 	echo '<pre>';
		print_r($datahis['employee_his']);
		exit;   */
		$datahis['button'] 			= 'Save'; 
		$datahis['is_pay'] 			= 1; 
		$datahis['leave_adjust'] 	= 1; 
		$datahis['type_id'] 	    = 1;  
		$datahis['approved_id'] 	= 1;  
		$datahis['appr_desig_code'] = 1;  
		
		$all_result = DB::table('tbl_master_tra as m')
					
					 ->leftJoin('tbl_resignation as r',function($join) use ($form_date){
												$join->on("m.emp_id","=","r.emp_id") 
												->Where('r.effect_date', '<=', $form_date);
														})	
					
					->where('m.br_code', '=', $br_code)
					->orWhere('m.designation_code', '=', 211)
					->where('m.br_join_date', '<=', $form_date) 
					->select('m.emp_id','r.effect_date')
					->groupBy('m.emp_id')
					->get(); 
					/* echo '<pre>';
						 print_r($all_result);
exit;		 	 */		 
				 if (!empty($all_result)) {
					foreach ($all_result as $result) {
						if(empty($result->effect_date)){
								$emp_id1 = $result->emp_id;
						 
							$max_sarok = DB::table('tbl_master_tra as m')
										->where('m.emp_id', '=', $emp_id1)
										->where('m.br_join_date', '=', function($query) use ($emp_id1,$form_date)
												{
													$query->select(DB::raw('max(br_join_date)'))
														  ->from('tbl_master_tra')
														  ->where('emp_id',$emp_id1)
														  ->where('br_join_date', '<=', $form_date);
												})
										->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
										->groupBy('emp_id')
										->first();	
						
						/*  echo '<pre>';
						 print_r($max_sarok);
						  */
						if($max_sarok){  
						$emp_info = DB::table('tbl_master_tra as m') 
									//->leftJoin('tbl_appointment_info as emp', 'emp.emp_id', '=', 'm.emp_id')   
									->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
									->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')  
									->where('m.sarok_no', $max_sarok->sarok_no)
									->select('emp.emp_id','emp.emp_name_eng as emp_name','d.designation_name','m.designation_code')
									->first();  
							 if(in_array($emp_info->designation_code, $designation)) {
								  
									$datahis['branch_staff'][] = array(
										'emp_id' 			 => $emp_info->emp_id,
										'emp_name'       	 => $emp_info->emp_name, 
										'designation_code'   => $emp_info->designation_code,
										'designation_name'   => $emp_info->designation_name
									);  
								 
								
							 } 
						 }
						}
							 	
					}
				}   	 			
		//exit; 
		return view('admin.leave.emp_approved_pre_form',$datahis);
    }
	
	
	public function insert_aprove_leave(Request $request)
    {
		$datahis = array();
		$data = array();  
		$data1 = array();  
        $datahis['emp_id'] 				= $emp_id = $request->emp_id;  
        $datahis['serial_no'] 			= $request->serial_no; 
        $datahis['f_year_id'] 			= $f_year_id = $request->f_year_id; 
        $datahis['designation_code']	= $request->designation_code; 
        $datahis['branch_code']			= $request->branch_code; 
        $datahis['type_id']				= $type_id =  $request->type_id; 
        $datahis['is_pay']				= $request->is_pay; 
        $datahis['application_date']	= $request->application_date; 
        $datahis['from_date']			= $request->from_date; 
        $datahis['to_date']				= $request->to_date; 
		
		$data1 = $this->leave_validation($datahis['from_date'],$datahis['to_date'],0);
		
        $datahis['leave_dates']			= $data1['leave_dates'];  
        $datahis['no_of_days']			= $request->no_of_days;  
        $datahis['leave_remain']		= $request->leave_remain;  
        $datahis['remarks']				= $request->remarks;  
        $appr_id_desig					= $request->approved_id;   
		$appr_id						= explode(",",$appr_id_desig);
		$datahis['approved_id'] 	 		= $appr_id[0];   
		$datahis['appr_desig_code'] 	 	= $appr_id[1];  
        $datahis['sup_status']			= 1;  
        $datahis['appr_status']			= 1;  
        $datahis['appr_from_date']		=  $request->from_date;  
        $datahis['sup_recom_date']		=  $request->from_date;  
        $datahis['appr_to_date']		=  $request->to_date;  
        $datahis['appr_appr_date']		=  $request->to_date;  
        $datahis['apply_for']			=  $request->apply_for;  
        $datahis['no_of_days_appr']		=  $request->no_of_days;  
        $datahis['tot_earn_leave']		=  $request->tot_earn_leave;  
        $datahis['leave_adjust']		=  $request->leave_adjust;
        $datahis['user_code'] 			= Session::get('admin_id');
		
		 DB::table('tbl_leave_history')
				->insert($datahis);  
		$data['cum_close_balance'] 			= $request->cum_close_balance;
		$data['casual_leave_close'] 		= $request->casual_leave_close;
		$data['pre_cumulative_close'] 		= $request->pre_cumulative_close;
		$data['current_close_balance'] 		= $request->current_close_balance;
		$data['cum_balance_less_close_12'] 	= $request->cum_balance_less_close_12;
        $data['last_update_date'] 			=  date('Y-m-d');  		
		/* echo '<pre>';
		print_r($data);
		exit; */
		if($datahis['is_pay'] == 1){
			if($datahis['type_id'] == 1){
				if($datahis['leave_adjust'] == 1){
					$data['no_of_days'] 				= ($request->no_of_days + $request->tot_expense); 
				}else{
					$data['no_of_days'] 				= $request->tot_expense; 
				}
				DB::table('tbl_leave_balance') 
					->where('emp_id', $emp_id)
					->where('f_year_id', $f_year_id)
					->update($data);
			}else if($datahis['type_id'] == 5){
				DB::table('tbl_leave_balance') 
					->where('emp_id', $emp_id)
					->where('f_year_id', $f_year_id)
					->update($data);
			}
			
			
		}/* else if($type_id == 2){ // if meternity leave enjoy then 9 days leaves deducted from current leave
			$data['current_open_balance'] 		= $request->current_open_balance - 9; 
			$data['current_close_balance'] 		= $request->current_close_balance - 9 ;
			DB::table('tbl_leave_balance') 
				->where('emp_id', $emp_id)
				->where('f_year_id', $f_year_id)
				->update($data);
		}   */
		 return Redirect::to('/approved-leave'); 
    } 
	public function update_aprove_leave(Request $request)
    {
		$datahis = array();
		$data = array();  
		$data1 = array();  
        $db_id = $request->db_id;  
        $pre_no_of_days					= $request->pre_no_of_days; 
        $f_year_id						= $request->f_year_id;  
        $emp_id							= $request->emp_id; 
        $type_id						= $request->type_id; 
        $is_pay							= $request->is_pay; 
        $datahis['application_date']	= $request->application_date; 
        $datahis['from_date']			= $request->from_date; 
        $datahis['to_date']				= $request->to_date; 
		
		$data1 = $this->leave_validation($datahis['from_date'],$datahis['to_date'],0);
		
		
        $datahis['leave_dates']			= $data1['leave_dates'];  
        $datahis['no_of_days']			= $request->no_of_days;  
        $datahis['leave_remain']		= $request->leave_remain;  
        $datahis['remarks']				= $request->remarks;   
		$appr_id_desig					= $request->approved_id;   
		$appr_id						= explode(",",$appr_id_desig);
		$datahis['approved_id'] 	 		= $appr_id[0];   
		$datahis['appr_desig_code'] 	 	= $appr_id[1];  
        $datahis['appr_from_date']		=  $request->from_date;  
        $datahis['sup_recom_date']		=  $request->from_date;  
        $datahis['apply_for']			=  $request->apply_for;  
        $datahis['appr_to_date']		=  $request->to_date;  
        $datahis['appr_appr_date']		=  $request->to_date;  
        $datahis['no_of_days_appr']		=  $request->no_of_days;  
        $datahis['tot_earn_leave']		=  $request->tot_earn_leave;  
        $leave_adjust					=  $request->leave_adjust;
        $datahis['user_code'] 			= Session::get('admin_id');
		
		 
			DB::table('tbl_leave_history')
				->where('id', $db_id) 
				->update($datahis);
				
		  	
		$data['cum_close_balance'] 			= $request->cum_close_balance;
		$data['casual_leave_close'] 		= $request->casual_leave_close;
		$data['current_close_balance'] 		= $request->current_close_balance;
		$data['cum_balance_less_close_12'] 	= $request->cum_balance_less_close_12;
		$data['pre_cumulative_close'] 		= $request->pre_cumulative_close;
        $data['last_update_date'] 			=  date('Y-m-d');  		
		/* echo '<pre>';
		print_r($data);
		exit; */
		if($is_pay == 1){
			if($type_id == 1){
				if($leave_adjust == 1){
					$data['no_of_days'] 				=  $request->tot_expense + ($datahis['no_of_days'] - $pre_no_of_days); 
				}else{
					$data['no_of_days'] 				= $request->tot_expense; 
				}
				DB::table('tbl_leave_balance') 
					->where('emp_id', $emp_id)
					->where('f_year_id', $f_year_id)
					->update($data);
			}else if($type_id == 5){
				DB::table('tbl_leave_balance') 
					->where('emp_id', $emp_id)
					->where('f_year_id', $f_year_id)
					->update($data);
			}
			
		} 
		 return Redirect::to('/approved-leave'); 
    }  
	public function update(Request $request, $id)
    {
		$data 			= array();
		$udatedata 		= array();
		$udatedata['appr_status'] 		= 1;  
		$udatedata['appr_from_date'] 	= $request->from_date; 
		$udatedata['appr_to_date'] 		= $request->to_date; 
		$udatedata['no_of_days_appr'] 	= $request->no_of_days; 
		$udatedata['no_of_days_appr'] 	= $request->no_of_days; 
		$udatedata['type_id'] 			= $request->type_id; 
		$udatedata['is_pay'] 			= $request->is_pay; 
		$udatedata['leave_adjust'] 		= $request->leave_adjust;
		
		$emp_id							= $request->emp_id; 
		$data['no_of_days'] 			= ($request->no_of_days + $request->tot_expense);
		$f_year_id 						= $request->f_year_id; 
		$data['cum_close_balance'] 		= $request->cum_close_balance;
		$data['current_close_balance'] 	= $request->current_close_balance;
		//$data['cum_balance'] 			= $request->cum_balance;
        //$data['current_open_balance'] 	= $request->current_open_balance; 
        $data['last_update_date'] 		=  date('Y-m-d');  
		DB::table('tbl_leave_history')
				->where('id', $id)
				->update($udatedata);
		DB::table('tbl_leave_balance')
				->where('emp_id', $emp_id)
				->where('f_year_id', $f_year_id)
				->update($data);
		 
		 return Redirect::to('/approved-leave'); 
    } 
	public function approvedreject(Request $request,$id)
    {
		$data = array();
		$datahis = array();
		$emp_id							= $request->emp_id; 
		$appr_status					= $request->appr_status; 
		$f_year_id 						= $request->f_year_id; 
		
		if($appr_status == 1){
			
			$leave_balance = DB::table('tbl_leave_balance')
							->where('f_year_id', $f_year_id) 
							->where('emp_id',$emp_id)
							->select('no_of_days','current_close_balance')
							->first();
			
			$data['no_of_days'] 			= ($leave_balance->no_of_days - $request->no_of_days); 
			$data['current_close_balance'] 	= ($leave_balance->current_close_balance + $request->no_of_days);
			$data['last_update_date'] 		=  date('Y-m-d');
			DB::table('tbl_leave_balance')
				->where('emp_id', $emp_id)
				->where('f_year_id', $f_year_id)
				->update($data);
		}
		
		
		$datahis['appr_status'] 		= 2; 
		
		DB::table('tbl_leave_history')
				->where('id', $id)
				->update($datahis);
		 return Redirect::to('/approved-leave'); 
    }
	public function approved_leave_delete($id,$f_year_id,$emp_id)
    {
		$data = array();
		 
		$leave_history 	= DB::table('tbl_leave_history')
							->where('id', $id) 
							->first();		
		$leave_adjust 			= $leave_history->leave_adjust;
		$type_id 				= $leave_history->type_id; 
		$is_pay 				= $leave_history->is_pay;
		$no_of_days_appr 		= $leave_history->no_of_days_appr;
		
		DB::table('tbl_leave_history')
				->where('id', $id)
				->delete();
		$leave_balance = DB::table('tbl_leave_balance')
							->where('f_year_id', $f_year_id)
							->where('emp_id',$emp_id)  
							->first();		
		if(($leave_adjust == 1 )&& ($type_id == 1) && ($is_pay == 1)){
			$no_of_days   =  $leave_balance->no_of_days - $no_of_days_appr;
			$current_close_balance   =  $leave_balance->current_close_balance + $no_of_days_appr;
			DB::table('tbl_leave_balance') 
				->where('f_year_id', $f_year_id) 
				->where('emp_id',$emp_id) 
				->update(['no_of_days' => $no_of_days,'current_close_balance' => $current_close_balance]);	
		}
		if(($leave_adjust == 1 )&& ($type_id == 5) && ($is_pay == 1)){ 
			$casual_leave_close   =  $leave_balance->casual_leave_close + $no_of_days_appr;
			DB::table('tbl_leave_balance') 
				->where('f_year_id', $f_year_id) 
				->where('emp_id',$emp_id) 
				->update(['casual_leave_close' => $casual_leave_close]);
		}
		if(($leave_adjust == 2) && ($is_pay == 1)){
			$cum_close_balance   =  $leave_balance->cum_close_balance + $no_of_days_appr;
			$pre_cumulative_close   =  $leave_balance->pre_cumulative_close + $no_of_days_appr;
			DB::table('tbl_leave_balance') 
				->where('f_year_id', $f_year_id) 
				->where('emp_id',$emp_id) 
				->update(['cum_close_balance' => $cum_close_balance,'pre_cumulative_close' => $pre_cumulative_close,]);	
		}
		if($leave_adjust == 3){
			$cum_balance_less_close_12   =  $leave_balance->cum_balance_less_close_12  + $no_of_days_appr;
			DB::table('tbl_leave_balance') 
				->where('f_year_id', $f_year_id) 
				->where('emp_id',$emp_id) 
				->update(['cum_balance_less_close_12' => $cum_balance_less_close_12]);	
		} 		
		if($type_id == 2){
			$no_of_days   =  $leave_balance->no_of_days - 9;
			$current_close_balance   =  $leave_balance->current_close_balance + 9;
			 DB::table('tbl_leave_balance') 
				->where('f_year_id', $f_year_id) 
				->where('emp_id',$emp_id) 
				->update(['no_of_days' => $no_of_days,'current_close_balance' => $current_close_balance]);	
		}	
		 return Redirect::to('/approved-leave'); 
    }
	public function leave_date_exist($from_date,$to_date,$emp_id){
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
	public function leave_date_exist_edit($from_date,$to_date,$emp_id,$db_id){
				 
		
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
	/* public function leaveyearadd($year_id)
    {
		$data 				= array();
		$data1 				= array();
		//$branch_code 		= Session::get('branch_code');
		//$branch_code 		= 1;
		$data1['status']	=	1; 
		$year_id 			= 	4;
		$employee_list = DB::table('tbl_leave_balance')
							->where('f_year_id', $year_id)
							//->where('emp_id','>=',200000)
							->where('status',2)
							->get();
		
	 /*   echo '<pre>';
		print_r($employee_list);
		exit;   
		if(!empty($employee_list)){
			foreach($employee_list as $employee){
				$data['f_year_id'] 					= ($employee->f_year_id + 1); 
				$data['branch_code'] 				= $employee->branch_code; 
				$data['emp_id'] 					= $employee->emp_id;   
				if($employee->emp_id < 200000){
					$data['cum_balance'] 				=($employee->cum_close_balance + $employee->current_close_balance );  
					$data['cum_close_balance'] 			=($employee->cum_close_balance + $employee->current_close_balance);
					$data['pre_cumulative_open'] 		=( $employee->current_close_balance + $employee->pre_cumulative_close); 
					$data['pre_cumulative_close'] 		=( $employee->current_close_balance + $employee->pre_cumulative_close);  
					$data['cum_balance_less_12'] 		=( $employee->cum_balance_less_close_12); 
					$data['cum_balance_less_close_12'] 	=( $employee->cum_balance_less_close_12);
				}else{
					$data['cum_balance'] 				= 0;  
					$data['cum_close_balance'] 			=0;
					$data['pre_cumulative_open'] 		=0; 
					$data['pre_cumulative_close'] 		=0;  
					$data['cum_balance_less_12'] 		=0; 
					$data['cum_balance_less_close_12'] 	=0;
				}
				 
				$data['casual_leave_open'] 			=12; 
				$data['casual_leave_close'] 		=12; 
				$data['current_open_balance'] 		=24; 
				$data['no_of_days'] 				=0; 
				$data['current_close_balance'] 		=24; 
				$data['status'] 					=2; 
				$data['last_update_date'] 			=date('Y-m-d'); 
				
				 DB::table('tbl_leave_balance')
					->where('emp_id', $data['emp_id'])  
					->update($data1);
				
				DB::table('tbl_leave_balance') 
					->insert($data);
			}
		} 
		return Redirect::to('/year-close'); 
    }  */
}
