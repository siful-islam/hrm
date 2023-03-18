<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Middleware\CheckUserSession;
use DB;
use Session;

class LeavehrmheadController extends Controller
{

	public function __construct()
	{
	 
		$this->middleware('CheckUserSession'); 
	}   
    
	public function approved_by_hrm()
    {  
		$data = array();
		$current_date = date("Y-m-d");
		$data['leave_recoment_list'] = array(); /// this ID come from session 
		$supervisor_id = $data['supervisor_id'] = Session::get('emp_id'); /// this ID come from session 
		$leave_recoment_list = DB::table('leave_application as ap') 
										->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'ap.emp_id')
										->leftJoin('supervisor_mapping_ho as mho',function($join) use($current_date){
												$join->on("mho.emp_id","=","ap.emp_id")
												->where('mho.active_from',DB::raw("(SELECT 
																				  max(supervisor_mapping_ho.active_from) as active_from
																				  FROM supervisor_mapping_ho 
																				   where ap.emp_id = supervisor_mapping_ho.emp_id and supervisor_mapping_ho.active_from <= '$current_date'
																				  )") 		 
															); 
														})	  
										->leftJoin('tbl_leave_type as ltype', 'ap.leave_type', '=', 'ltype.id')
										->leftJoin('tbl_emp_basic_info as emp', 'ap.emp_id', '=', 'emp.emp_id')
										->leftJoin('tbl_emp_basic_info as emp1', 'mho.supervisor_id', '=', 'emp1.emp_id')
										->where(function($query){ 
												$query->Where('ap.super_action',1);
												//$query->orWhere('ap.hrhd_action',2); 
												})
										->where('ap.executor_action','!=',1)		
										->orderby('ap.application_id','desc')
										->select('ap.*','ltype.type_name','emp.emp_name_eng as emp_name','emp1.emp_name_eng as approved_name','mho.supervisor_type','tbl_emp_photo.emp_photo')  
										->get(); 
		/* echo "<pre>";
				print_r($leave_recoment_list);  	 */							
										
		$pre_application_id = 0;						
		foreach($leave_recoment_list as $v_leave_recoment_list){
			if($v_leave_recoment_list->application_id != $pre_application_id){ 
				 
				$return_result =  $this->approve_leave_byhrm_for_list($v_leave_recoment_list->application_id);
				
							
				 
				  $data['leave_recoment_list'][] = array(  
											'id'       	 			=> $v_leave_recoment_list->application_id, 
											'uni_emp_id'       	 		=> $v_leave_recoment_list->emp_id, 
											'emp_id'       	 		=> $return_result['emp_id'],  
											'f_year_id'       	 	=> $return_result['f_year_id'], 
											'designation_code'       	 	=> $return_result['designation_code'], 
											'branch_code'       	 	=> $return_result['br_code'], 
											'approved_id'       	 	=> $return_result['sup_emp_id'], 
											'appr_desig_code'       	=> $return_result['sup_designation_code'], 
											'tot_earn_leave'       	=> $return_result['tot_earn_leave'], 
											'cum_balance_less_12'       	=> $return_result['cum_balance_less_12'], 
											'cum_balance'       	=> $return_result['cum_balance'], 
											'pre_cumulative_open'       	=> $return_result['pre_cumulative_open'], 
											'current_open_balance'       	=> $return_result['current_open_balance'], 
											'casual_leave_open'       	=> $return_result['casual_leave_open'], 
											'designation_name'       	=> $return_result['designation_name'], 
											'branch_name'       	=> $return_result['branch_name'], 
											'type_id'       		=> $v_leave_recoment_list->leave_type ,  
											'type_name'       		=> $v_leave_recoment_list->type_name ,  
											'apply_for'       		=> $v_leave_recoment_list->apply_for ,  
											'remarks'       		=> $v_leave_recoment_list->remarks ,  
											'executor_action'       => $v_leave_recoment_list->executor_action , 
											'reported_to'       	=> $v_leave_recoment_list->reported_to, 
											'leave_to'       	 	=> $v_leave_recoment_list->leave_to, 
											'no_of_days'       	 	=> $v_leave_recoment_list->no_of_days, 
											'leave_from'       	 	=> $v_leave_recoment_list->leave_from, 
											'emp_name'       	 	=> $v_leave_recoment_list->emp_name, 
											'approved_name'       	=> $v_leave_recoment_list->approved_name, 
											'emp_photo'       		=> $v_leave_recoment_list->emp_photo,  
											'supervisor_type'       => $v_leave_recoment_list->supervisor_type,  
											'super_action'     		=> $v_leave_recoment_list->super_action,
											'first_super_action'    => $v_leave_recoment_list->first_super_action, 
											'application_date'      => $v_leave_recoment_list->application_date 
										); 
			}
			$pre_application_id = $v_leave_recoment_list->application_id;
		} 
		//exit;
		   /*  echo "<pre>";
		print_r($data['leave_recoment_list']);
		exit;  */
		return view('admin.leave.leave_recommend_hrm_list',$data);
    } 
	public function approve_leave_byhrm_for_list($id)
    {
		$data = array(); 
		$data['application_id'] 	= $id;
		
		$current_date = date('Y-m-d');
		
		$leave_appli_info = DB::table('leave_application')->where('application_id',$id)->first();
		 
		$approved_id 				= $leave_appli_info->super_emp_id;
		$data['reported_to']   = $reported_to 				= $leave_appli_info->reported_to;
		$data['application_date']   =    $application_date 		= $leave_appli_info->application_date; 
		$data['from_date'] 			=$from_date =  $leave_appli_info->leave_from; 
		$data['to_date'] 			= $leave_appli_info->leave_to; 
		$data['no_of_days'] 		=$leave_appli_info->no_of_days; 
		$data['apply_for'] 		=$leave_appli_info->apply_for; 
		/* echo $data['no_of_days'] ;
		exit; */ 
		$joining_date  = '';
		$data['remarks'] 		= $leave_appli_info->remarks; 
		$data['tot_earn_leave'] 	  = $leave_appli_info->tot_earn_leave; 
		$data['type_id'] 	    	= $leave_appli_info->leave_type; 
		 
		$emp_id = $uni_emp_id 	= $leave_appli_info->emp_id;
		$fiscal_year = DB::table('tbl_financial_year') 
									->where('running_status',1) 
									->first(); 
									/* echo "<pre>";
									print_r($data['fiscal_year']);
									exit; */
		$f_year_from = $fiscal_year->f_year_from;  
		$data['f_year_id']   = $f_year_id = $fiscal_year->id;    
				$max_sarok = DB::table('tbl_master_tra as m')
							->where('m.emp_id', '=', $uni_emp_id)
							->where('m.br_join_date', '=', function($query) use ($uni_emp_id,$current_date)
									{
										$query->select(DB::raw('max(br_join_date)'))
											  ->from('tbl_master_tra')
											  ->where('emp_id',$uni_emp_id)
											  ->where('br_join_date', '<=', $current_date);
									})
							->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
							->groupBy('emp_id')
							->first();	
				if($max_sarok){	
					$emp_info = DB::table('tbl_master_tra as m') 
									->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id') 
									->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
									->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->select('emp.emp_id','emp.emp_name_eng as emp_name','emp.org_join_date as joining_date','b.br_code','d.designation_name','d.designation_code','b.branch_name')
									->first(); 
					
					$assign_emp = DB::table('tbl_emp_assign as ea')
									->where('ea.emp_id',$uni_emp_id)
									->where('ea.status', '!=', 0)
									->where('ea.select_type', '=', 1)
									->select('ea.emp_id','ea.open_date','ea.incharge_as')
									->first();
					$assign_branch = DB::table('tbl_emp_assign as ea')
												->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code')
												->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
												->where('ea.emp_id',$uni_emp_id)
												->where('ea.open_date', '<=', $current_date)
												->where('ea.status', '!=', 0)
												->where('ea.select_type', '=', 2)
												->select('ea.emp_id','ea.open_date','br.branch_name','br.br_code','ar.area_name')
												->first();
					$assign_designation = DB::table('tbl_emp_assign as ea')
												->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
												->where('ea.emp_id',$uni_emp_id)
												->where('ea.status', '!=', 0)
												->where('ea.select_type', '=', 5)
												->select('ea.emp_id','ea.open_date','de.designation_name','de.designation_code')
												->first(); 
					
					}
					
					$joining_date = $emp_info->joining_date; 
					if($reported_to != "Chairman"){
						$supervisor_info = $this->supervisor_info($approved_id);
						$data['sup_emp_id'] 			= $supervisor_info['employee_his']['emp_id'];
						$data['sup_designation_code'] 	= $supervisor_info['employee_his']['designation_code'];
					}    
		   
		 if(!empty($assign_branch)){
				 $branch_name = $assign_branch->branch_name; 
				 $br_code = $assign_branch->br_code; 
			 }else{
				  $branch_name = $emp_info->branch_name; 
				 $br_code = $emp_info->br_code;
			 } 
			 if(!empty($assign_designation)){
				  $designation_name 	= $assign_designation->designation_name; 
				 $designation_code 		= $assign_designation->designation_code;
			 }else{
				  $designation_name = $emp_info->designation_name; 
				 $designation_code = $emp_info->designation_code;
			 }
		
		$data['emp_id'] 			= $emp_id;
		$data['emp_name'] 			= $emp_info->emp_name; 
		$data['joining_date'] 		= $emp_info->joining_date; 
		$data['designation_code'] 	= $designation_code;  
		$data['designation_name'] 	= $designation_name;  
		$data['branch_name'] 	= $branch_name;  
		$data['br_code'] 			= $br_code; 
		
		 $emp_leave_balance = DB::table('tbl_leave_balance as lb') 
									->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'lb.f_year_id') 
									 
									->where('lb.emp_id',$emp_id) 
									->where('lb.f_year_id',$f_year_id) 
									->select('fy.f_year_from','lb.no_of_days','lb.current_open_balance','lb.cum_close_balance','lb.current_close_balance','lb.cum_balance_less_close_12','lb.pre_cumulative_close','lb.casual_leave_close')
									->first(); 
		 
		
		  if($emp_leave_balance){
			    $data['f_year_from']  			= $emp_leave_balance->f_year_from;	
				$data['tot_expense']  			= $emp_leave_balance->no_of_days;	
				$data['pre_cumulative_open'] 	= $emp_leave_balance->pre_cumulative_close; 
				$data['casual_leave_open'] 	= $emp_leave_balance->casual_leave_close; 
				$data['cum_balance'] 			= $emp_leave_balance->cum_close_balance; 
				$data['current_open_balance'] 	= $emp_leave_balance->current_close_balance; 
				$data['cum_balance_less_12'] 	= $emp_leave_balance->cum_balance_less_close_12; 
		  } 
		$data['employee_id'] 		= $emp_id;  
		 /* echo '<pre>';
		print_r($from_date);
		exit;  */
		 
		$year = date('Y',strtotime($f_year_from));
		$data['tot_earn_leave']  = $this->earn_leave($from_date, $joining_date, $year);
		/* echo '<pre>';
		print_r($data['tot_earn_leave']);
		exit;  */
		 return $data;
    }
	public function insert_aprove_leave_byhrm(Request $request)
    {	
			$dataup = array();
			$datahis = array();
			$data9_12 = array();  
			$datapre = array();  
			$datacur = array();  
			$data = array();  
			$datac = array();  
			$datahis['id_application'] 				= $application_id 				= $request->application_id; 
			$datahis['emp_id'] 				= $emp_id = $request->emp_id;  
			$datahis['emp_type'] 			= 1;  
			$datahis['serial_no'] 			= $request->serial_no; 
			$datahis['f_year_id'] 			= $f_year_id = $request->f_year_id; 
			$datahis['designation_code']	= $request->designation_code; 
			$datahis['branch_code']			= $request->branch_code; 
			$datahis['type_id']				= $type_id =  $request->type_id; 
			
			$datahis['application_date']	= $request->application_date; 
			$datahis['apply_for']	= $apply_for = $request->apply_for; 
			  
			$datahis['remarks']				= $request->remarks;  
			$appr_id_desig					= $request->approved_id;   
			$appr_id						= explode(",",$appr_id_desig);
			$datahis['approved_id'] 	 		= $appr_id[0];   
			$datahis['appr_desig_code'] 	 	= $appr_id[1];  
			$datahis['sup_status']			= 1;  
			$datahis['appr_status']			= 1;  
			$datahis['leave_remain']		= $request->leave_remain;
			
			
			$datahis['tot_earn_leave']		=  $request->tot_earn_leave;  
			$is_pay							=  $request->is_pay;  
			$datahis['is_application_flag']	= 1;  
			
			$datahis['user_code'] 			= Session::get('admin_id');
			$cum_balance_less_12  	= $request->cum_balance_less_12;
			$cum_balance 			= $request->cum_balance;
			$pre_cumulative_open  			= $request->pre_cumulative_open;
			$current_open_balance 			=  $request->current_open_balance;
			$casual_leave_open 			=  $request->casual_leave_open;
			$from_date						= $request->from_date;
			$to_date						= $request->to_date;
			$no_of_days						= $request->no_of_days;
			$no_of_days_form				= $request->no_of_days;
			 
			/*  echo "<pre>";
						print_r($pre_cumulative_open);
						exit;  */
						
						
						
						
		$leave_dates = DB::table('leave_application')
						->where('application_id', $application_id)
						//->where('application_id', 8)
						->first();
		$dates = explode(",",$leave_dates->leave_dates);
		//print_r($dates);
		//exit;
		$total_days = $max_no_leave = $leave_dates->no_of_days;
		
		if($is_pay == 2){
						$leave_dates = implode(",",$dates); 
						$old_leave_date_from = $dates[0];
						$old_leave_date_to = $dates[$total_days - 1];
						if($apply_for != 1){
							$datahis['no_of_days']				= $no_of_days_form;
							$datahis['no_of_days_appr']			=  $no_of_days_form;
						}else{
							$datahis['no_of_days']				= $total_days;
							$datahis['no_of_days_appr']			=  $total_days;
						}
						$datahis['leave_dates']				= $leave_dates;
						$datahis['from_date']				= $old_leave_date_from;
						$datahis['to_date']					= $old_leave_date_to;
						
						$datahis['leave_adjust']			=  1;
						$datahis['is_pay']					= 2;
						$datahis['appr_from_date']			=  $old_leave_date_from;  
						$datahis['sup_recom_date']			=  $old_leave_date_from;
						$datahis['appr_to_date']			=  $old_leave_date_to;  
						$datahis['appr_appr_date']			=  $old_leave_date_to; 
						  DB::table('tbl_leave_history')
							->insert($datahis);
		} else if($datahis['type_id']	== 1){
			$check_old_balance 		= $cum_balance_less_12;
			$check_pre_balance 		= $pre_cumulative_open;
			$check_current_balance 	= $current_open_balance;
		
		if($cum_balance_less_12 > 0.5 && $apply_for == 1)
		{
			$for_old_dates 			= array_slice($dates, 0, $cum_balance_less_12); 
			$rest_dates_from_old 	= array_slice($dates,$cum_balance_less_12);
			
			
			
			$no_of_days 				= count($for_old_dates);
			$rest_old_days 				= count($rest_dates_from_old);
			if($max_no_leave >= $cum_balance_less_12)
			{
				$old_leave_date_from = $dates[0];
				$old_leave_date_to = $dates[$cum_balance_less_12 - 1]; 
				$leave_dates = implode(",",$for_old_dates); 
				$old_flag = 2;
				$datahis['from_date']		= $old_leave_date_from;
				$datahis['to_date']			= $old_leave_date_to;
				$datahis['leave_dates']		= $leave_dates;
				
				if($apply_for != 1){ 
					$no_of_days = $no_of_days_form;
				}
				$datahis['no_of_days']		= $no_of_days;
				$datahis['no_of_days_appr']	=  $no_of_days;
				$datahis['leave_adjust']	=  3;
				$datahis['is_pay']			= 1;
				$datahis['appr_from_date']		=  $old_leave_date_from;  
				$datahis['sup_recom_date']		=  $old_leave_date_from;
				$datahis['appr_to_date']		=  $old_leave_date_to;  
				$datahis['appr_appr_date']		=  $old_leave_date_to; 
				$cum_balance_less_12 = $cum_balance_less_12 - $no_of_days; 
				$data9_12['cum_balance_less_close_12'] 	= $cum_balance_less_12;
				$data9_12['last_update_date'] 			=  date('Y-m-d'); 
				 DB::table('tbl_leave_history')
					->insert($datahis);  
				 DB::table('tbl_leave_balance') 
					->where('emp_id', $emp_id)
					->where('f_year_id', $f_year_id)
					->update($data9_12);
			}else{
				$old_leave_date_from = $dates[0];
				$old_leave_date_to = $dates[$max_no_leave - 1]; 
				$old_flag = 1;
				$leave_dates = implode(",",$for_old_dates); 
				$datahis['leave_dates']			= $leave_dates;
				$datahis['from_date']			= $old_leave_date_from;
				$datahis['to_date']				= $old_leave_date_to;  
				$datahis['appr_from_date']		=  $old_leave_date_from;  
				$datahis['sup_recom_date']		=  $old_leave_date_from;
				$datahis['appr_to_date']		=  $old_leave_date_to;  
				$datahis['appr_appr_date']		=  $old_leave_date_to; 
				$datahis['no_of_days']			= $max_no_leave;
				$datahis['no_of_days_appr']		=  $max_no_leave;
				$datahis['leave_adjust']		=  3;
				$datahis['is_pay']				= 1;
				if($apply_for != 1){ 
					$no_of_days = $no_of_days_form;
				}
				$data9_12['cum_balance_less_close_12'] 	=$cum_balance_less_12 - $no_of_days;
				$data9_12['last_update_date'] 			=  date('Y-m-d'); 
				/*  echo "<pre>";
				print_r($datahis); */
				DB::table('tbl_leave_history')
					->insert($datahis);  
				 DB::table('tbl_leave_balance') 
					->where('emp_id', $emp_id)
					->where('f_year_id', $f_year_id)
					->update($data9_12); 
			} 
			$dates = $rest_dates_from_old;
			$total_days = count($dates); 
				
		}else if($cum_balance_less_12 == 0.5 && $apply_for != 1){
				$datahis['leave_dates']			= $from_date;
				$datahis['from_date']			= $from_date;
				$datahis['to_date']				= $to_date;  
				$datahis['appr_from_date']		=  $from_date;  
				$datahis['sup_recom_date']		=  $from_date;
				$datahis['appr_to_date']		=  $to_date;  
				$datahis['appr_appr_date']		=  $to_date; 
				$datahis['no_of_days']			= $max_no_leave;
				$datahis['no_of_days_appr']		=  $max_no_leave;
				$datahis['leave_adjust']		=  3;
				$datahis['is_pay']				= 1; 
				$data9_12['cum_balance_less_close_12'] 	=$cum_balance_less_12 - $no_of_days_form;
				$data9_12['last_update_date'] 			=  date('Y-m-d'); 
				/*  echo "<pre>";
				print_r($datahis); */
				DB::table('tbl_leave_history')
					->insert($datahis);  
				 DB::table('tbl_leave_balance') 
					->where('emp_id', $emp_id)
					->where('f_year_id', $f_year_id)
					->update($data9_12); 
					$old_flag = 3;
					$total_days = 0;
		}else
		{
			$old_flag = 3;
		}
		if($total_days > 0){
			if($pre_cumulative_open > 0.5 && $apply_for == 1)
			{
				$rest_old_days 			= count($dates); 
				
				if($old_flag == 2 ){
					 
					
					
					$for_old_dates 			= array_slice($dates, 0, $pre_cumulative_open); 
					$rest_dates_from_old 	= array_slice($dates,$pre_cumulative_open);
						
					 
						if($rest_old_days >= $pre_cumulative_open)
						{
								$old_leave_date_from = $dates[0];
								$old_leave_date_to = $dates[$pre_cumulative_open - 1]; 
								$old_flag_pre = 2; 
								$leave_dates = implode(",",$for_old_dates); 
								$datahis['leave_dates']			= $leave_dates;
								$datahis['from_date']		= $old_leave_date_from;
								$datahis['to_date']			= $old_leave_date_to;
								if($apply_for != 1){ 
									$rest_old_days = $no_of_days_form;
								}
								$datahis['no_of_days']		= $rest_old_days;
								$datahis['no_of_days_appr']	=  $rest_old_days;
								$datahis['leave_adjust']	=  2;
								$datahis['is_pay']			= 1;
								$datahis['appr_from_date']		=  $old_leave_date_from;  
								$datahis['sup_recom_date']		=  $old_leave_date_from;
								$datahis['appr_to_date']		=  $old_leave_date_to;  
								$datahis['appr_appr_date']		=  $old_leave_date_to; 
								$pre_cumulative_open =   $pre_cumulative_open - $rest_old_days ;
								$cum_balance = $cum_balance - $rest_old_days;
								$datapre['pre_cumulative_close'] 	= $pre_cumulative_open;
								$datapre['cum_close_balance'] 	= $cum_balance;
								
								$datapre['last_update_date'] 			=  date('Y-m-d'); 
								
								 
								  DB::table('tbl_leave_history')
									->insert($datahis);  
								 DB::table('tbl_leave_balance') 
									->where('emp_id', $emp_id)
									->where('f_year_id', $f_year_id)
									->update($datapre); 
							
							
							
						}
						else{
								$old_leave_date_from = $dates[0];
								$old_leave_date_to = $dates[$rest_old_days - 1]; 
								$old_flag_pre = 1;
								$leave_dates = implode(",",$for_old_dates); 
								$datahis['leave_dates']			= $leave_dates;
								$datahis['from_date']				= $old_leave_date_from;
								$datahis['to_date']					= $old_leave_date_to;  
								$datahis['appr_from_date']			=  $old_leave_date_from;  
								$datahis['sup_recom_date']			=  $old_leave_date_from;
								$datahis['appr_to_date']			=  $old_leave_date_to;  
								$datahis['appr_appr_date']			=  $old_leave_date_to; 
								if($apply_for != 1){ 
									$rest_old_days = $no_of_days_form;
								}
								$datahis['no_of_days']				= $rest_old_days;
								$datahis['no_of_days_appr']			=  $rest_old_days;
								$datahis['leave_adjust']			=  2;
								$datahis['is_pay']					= 1;
								
								$pre_cumulative_open = $pre_cumulative_open -  $rest_old_days;
								$cum_balance = $cum_balance -  $rest_old_days;
								$datapre['pre_cumulative_close'] 	= $pre_cumulative_open;
								$datapre['cum_close_balance'] 	= $cum_balance;
								
								
								$datapre['last_update_date'] 			=  date('Y-m-d');
								/*  echo "<pre>";
								print_r($datahis);
								exit; */
								 DB::table('tbl_leave_history')
									->insert($datahis);  
								 DB::table('tbl_leave_balance') 
									->where('emp_id', $emp_id)
									->where('f_year_id', $f_year_id)
									->update($datapre); 
							
						} 
						$dates = $rest_dates_from_old;  
						$total_days = count($dates); 
						
					
				}else if($old_flag == 3){
					
					$for_old_dates 			= array_slice($dates, 0, $pre_cumulative_open); 
					$rest_dates_from_old 	= array_slice($dates,$pre_cumulative_open);
					$old_days 				= count($for_old_dates);
					$rest_old_days 			= count($rest_dates_from_old);
					 
					if($max_no_leave >= $pre_cumulative_open)
					{
						$old_leave_date_from = $dates[0];
						$old_leave_date_to = $dates[$pre_cumulative_open - 1]; 
						$old_flag_pre = 2; 
						$leave_dates = implode(",",$for_old_dates); 
						$datahis['leave_dates']			= $leave_dates;
						$datahis['from_date']		= $old_leave_date_from;
						$datahis['to_date']			= $old_leave_date_to;
						if($apply_for != 1){ 
							$old_days = $no_of_days_form;
						}
						$datahis['no_of_days']		= $old_days;
						$datahis['no_of_days_appr']	=  $old_days;
						$datahis['leave_adjust']	=  2;
						$datahis['is_pay']			= 1;
						$datahis['appr_from_date']		=  $old_leave_date_from;  
						$datahis['sup_recom_date']		=  $old_leave_date_from;
						$datahis['appr_to_date']		=  $old_leave_date_to;  
						$datahis['appr_appr_date']		=  $old_leave_date_to; 
						$pre_cumulative_open = $pre_cumulative_open - $old_days ;
						$cum_balance =  $cum_balance - $old_days;
						$datapre['pre_cumulative_close'] 	= $pre_cumulative_open;
						$datapre['cum_close_balance'] 	= $cum_balance;
						$datapre['last_update_date'] 			=  date('Y-m-d'); 
						
						 
						  DB::table('tbl_leave_history')
							->insert($datahis);  
						 DB::table('tbl_leave_balance') 
							->where('emp_id', $emp_id)
							->where('f_year_id', $f_year_id)
							->update($datapre); 
						
					}
					else{
						$old_leave_date_from = $dates[0];
						$old_leave_date_to = $dates[$max_no_leave - 1]; 
						$old_flag_pre = 1; 
						$leave_dates = implode(",",$for_old_dates); 
						$datahis['leave_dates']			= $leave_dates;
						$datahis['from_date']				= $old_leave_date_from;
						$datahis['to_date']					= $old_leave_date_to;  
						$datahis['appr_from_date']			=  $old_leave_date_from;  
						$datahis['sup_recom_date']			=  $old_leave_date_from;
						$datahis['appr_to_date']			=  $old_leave_date_to;  
						$datahis['appr_appr_date']			=  $old_leave_date_to; 
						if($apply_for != 1){ 
							$old_days = $no_of_days_form;
						}
						$datahis['no_of_days']				= $old_days;
						$datahis['no_of_days_appr']			=  $old_days;
						$datahis['leave_adjust']			=  2;
						$datahis['is_pay']					= 1;
						
						$pre_cumulative_open = $pre_cumulative_open -  $old_days;
						$cum_balance = $cum_balance -  $old_days;
						
						$datapre['pre_cumulative_close'] 	= $pre_cumulative_open;
						$datapre['cum_close_balance'] 	= $cum_balance;
						$datapre['last_update_date'] 			=  date('Y-m-d');
						/*  echo "<pre>";
						print_r($datahis);
						exit; */
						 DB::table('tbl_leave_history')
							->insert($datahis);  
						 DB::table('tbl_leave_balance') 
							->where('emp_id', $emp_id)
							->where('f_year_id', $f_year_id)
							->update($datapre); 
					}
					 
					$dates = $rest_dates_from_old;
					$total_days = count($dates); 
				}else{
					$old_flag_pre = 3;
				}
				
			}else if($pre_cumulative_open == 0.5 && $apply_for != 1){
						$datahis['leave_dates']			= $from_date;
						$datahis['from_date']		= $from_date;
						$datahis['to_date']			= $to_date;
						 
						$datahis['no_of_days']		= $no_of_days_form;
						$datahis['no_of_days_appr']	=  $no_of_days_form;
						$datahis['leave_adjust']	=  2;
						$datahis['is_pay']			= 1;
						$datahis['appr_from_date']		=  $from_date;  
						$datahis['sup_recom_date']		=  $from_date;
						$datahis['appr_to_date']		=  $to_date;  
						$datahis['appr_appr_date']		=  $to_date; 
						$pre_cumulative_open = $pre_cumulative_open - $no_of_days_form ;
						$cum_balance =  $cum_balance - $no_of_days_form;
						$datapre['pre_cumulative_close'] 	= $pre_cumulative_open;
						$datapre['cum_close_balance'] 	= $cum_balance;
						$datapre['last_update_date'] 			=  date('Y-m-d'); 
						
						 
						  DB::table('tbl_leave_history')
							->insert($datahis);  
						 DB::table('tbl_leave_balance') 
							->where('emp_id', $emp_id)
							->where('f_year_id', $f_year_id)
							->update($datapre); 
							$old_flag_pre = 3;
							$total_days = 0;
			}
			else
			{
				$old_flag_pre = 3;
			} 
		}
		if($total_days > 0){
				if($current_open_balance > 0.5 && $apply_for == 1)
					{ 
						if($old_flag_pre == 2 ){
							 
							$rest_old_days 			= count($dates); 
								
							
							$for_old_dates 			= array_slice($dates, 0, $current_open_balance); 
							
							
							$rest_dates_from_old 	= array_slice($dates,$current_open_balance);
								
								 
							if($rest_old_days >= $current_open_balance)
							{
								$old_leave_date_from = $dates[0];
								$old_leave_date_to = $dates[$current_open_balance - 1];  
								$old_flag_current = 2;  
								$leave_dates = implode(",",$for_old_dates); 
								$datahis['leave_dates']			= $leave_dates;
								$datahis['from_date']				= $old_leave_date_from;
								$datahis['to_date']					= $old_leave_date_to;
								if($apply_for != 1){ 
									$rest_old_days = $no_of_days_form;
								}
								$datahis['no_of_days']				= $rest_old_days;
								$datahis['no_of_days_appr']			=  $rest_old_days;
								$datahis['leave_adjust']			=  1;
								$datahis['is_pay']					= 1;
								$datahis['appr_from_date']			=  $old_leave_date_from;  
								$datahis['sup_recom_date']			=  $old_leave_date_from;
								$datahis['appr_to_date']			=  $old_leave_date_to;  
								$datahis['appr_appr_date']			=  $old_leave_date_to; 
								$current_open_balance 				=$current_open_balance -  $rest_old_days; 
								$datacur['current_close_balance'] 	= $current_open_balance; 
								$datacur['last_update_date'] 			=  date('Y-m-d'); 
								
								 $datacur['no_of_days'] 				= ($rest_old_days + $request->tot_expense);
								  DB::table('tbl_leave_history')
									->insert($datahis);  
								 DB::table('tbl_leave_balance')
									 
									->where('emp_id', $emp_id)
									->where('f_year_id', $f_year_id)
									->update($datacur); 
							}
							else{
								
								$old_leave_date_from = $dates[0];
								$old_leave_date_to = $dates[$rest_old_days - 1]; 
								$old_flag_current = 1; 
								$leave_dates = implode(",",$for_old_dates); 
								$datahis['leave_dates']			= $leave_dates;
								$datahis['from_date']				= $old_leave_date_from;
								$datahis['to_date']					= $old_leave_date_to;  
								$datahis['appr_from_date']			=  $old_leave_date_from;  
								$datahis['sup_recom_date']			=  $old_leave_date_from;
								$datahis['appr_to_date']			=  $old_leave_date_to;  
								$datahis['appr_appr_date']			=  $old_leave_date_to;
								if($apply_for != 1){ 
									$rest_old_days = $no_of_days_form;
								}
								$datahis['no_of_days']				= $rest_old_days;
								$datahis['no_of_days_appr']			=  $rest_old_days;
								$datahis['leave_adjust']			= 1;
								$datahis['is_pay']					= 1;
								$datacur['current_close_balance'] 	= 0; 
								$current_open_balance 				= $current_open_balance - $rest_old_days;
								$datacur['last_update_date'] 			=  date('Y-m-d'); 
								 
								/*  echo "<pre>";
								print_r($datahis);
								exit; */
								 DB::table('tbl_leave_history')
									->insert($datahis);  
								 DB::table('tbl_leave_balance') 
									->where('emp_id', $emp_id)
									->where('f_year_id', $f_year_id)
									->update($datacur); 
								
							} 
							$dates = $rest_dates_from_old;
							$total_days = count($dates); 
							
						}else if($old_flag_pre == 3){
							
							$for_old_dates 			= array_slice($dates, 0, $current_open_balance); 
							$rest_dates_from_old 		= array_slice($dates,$current_open_balance);
							$old_days 					= count($for_old_dates);
							$rest_old_days 				= count($rest_dates_from_old);
							
							if($max_no_leave >= $current_open_balance)
							{
								
								$old_leave_date_from = $dates[0];
								$old_leave_date_to = $dates[$current_open_balance - 1];
								 
								$old_flag_current = 2; 
								$leave_dates = implode(",",$for_old_dates); 
								$datahis['leave_dates']			= $leave_dates;
								$datahis['from_date']				= $old_leave_date_from;
								$datahis['to_date']					= $old_leave_date_to;
								if($apply_for != 1){ 
									$old_days = $no_of_days_form;
								}
								$datahis['no_of_days']				= $old_days;
								$datahis['no_of_days_appr']			=  $old_days;
								$datahis['leave_adjust']			=  1;
								$datahis['is_pay']					= 1;
								$datahis['appr_from_date']			=  $old_leave_date_from;  
								$datahis['sup_recom_date']			=  $old_leave_date_from;
								$datahis['appr_to_date']			=  $old_leave_date_to;  
								$datahis['appr_appr_date']			=  $old_leave_date_to; 
								$current_open_balance 				= $current_open_balance - $old_days; 
								$datacur['current_close_balance'] 	= $current_open_balance; 
								$datacur['last_update_date'] 			=  date('Y-m-d'); 
								
								 $datacur['no_of_days'] 				= ($old_days + $request->tot_expense);
								  DB::table('tbl_leave_history')
									->insert($datahis);  
								 DB::table('tbl_leave_balance') 
									->where('emp_id', $emp_id)
									->where('f_year_id', $f_year_id)
									->update($datacur); 
							}
							else{
								$old_leave_date_from = $dates[0];
								$old_leave_date_to = $dates[$max_no_leave - 1];
								$leave_dates = array();
								$old_flag_current = 1;  
								$leave_dates = implode(",",$for_old_dates); 
								$datahis['leave_dates']			= $leave_dates;
								$datahis['from_date']				= $old_leave_date_from;
								$datahis['to_date']					= $old_leave_date_to;  
								$datahis['appr_from_date']			=  $old_leave_date_from;  
								$datahis['sup_recom_date']			=  $old_leave_date_from;
								$datahis['appr_to_date']			=  $old_leave_date_to;  
								$datahis['appr_appr_date']			=  $old_leave_date_to; 
								if($apply_for != 1){ 
									$old_days = $no_of_days_form;
								}
								$datahis['no_of_days']				= $old_days;
								$datahis['no_of_days_appr']			=  $old_days;
								$datahis['leave_adjust']			= 1;
								$datahis['is_pay']					= 1;
								$datacur['current_close_balance'] 	= $current_open_balance - $old_days;
								$datacur['last_update_date'] 			=  date('Y-m-d'); 
								 DB::table('tbl_leave_history')
									->insert($datahis);  
								 DB::table('tbl_leave_balance') 
									->where('emp_id', $emp_id)
									->where('f_year_id', $f_year_id)
									->update($datacur);  
								
							}
							$dates = $rest_dates_from_old; 
							$total_days = count($dates); 
						}else{
							$old_flag_current = 3; 
						}
						
					}else if($current_open_balance == 0.5 && $apply_for != 1){
						$datahis['leave_dates']			= $from_date;
						$datahis['from_date']				= $from_date;
						$datahis['to_date']					= $to_date;
						 
						$datahis['no_of_days']				= $no_of_days_form;
						$datahis['no_of_days_appr']			=  $no_of_days_form;
						$datahis['leave_adjust']			=  1;
						$datahis['is_pay']					= 1;
						$datahis['appr_from_date']			=  $from_date;  
						$datahis['sup_recom_date']			=  $from_date;
						$datahis['appr_to_date']			=  $to_date;  
						$datahis['appr_appr_date']			=  $to_date; 
						$current_open_balance 				= $current_open_balance - $no_of_days_form; 
						$datacur['current_close_balance'] 	= $current_open_balance; 
						$datacur['last_update_date'] 			=  date('Y-m-d'); 
						
						 $datacur['no_of_days'] 				= ($no_of_days_form + $request->tot_expense);
						  DB::table('tbl_leave_history')
							->insert($datahis);  
						 DB::table('tbl_leave_balance') 
							->where('emp_id', $emp_id)
							->where('f_year_id', $f_year_id)
							->update($datacur); 
							$old_flag_current = 3;
							$total_days = 0;
					}
					else
					{
						$old_flag_current = 3;
					}
		}
		
		if($total_days > 0){
			 
				 
			$rest_old_days 			= count($dates);
			$for_old_dates 			= array_slice($dates, 0, $rest_old_days); 	
			if($rest_old_days > 0){
				$old_leave_date_from = $dates[0];
				$old_leave_date_to = $dates[$rest_old_days - 1];
				$leave_dates = implode(",",$for_old_dates); 
				$datahis['leave_dates']			= $leave_dates;
				$old_flag_current = 1;
				$datahis['from_date']				= $old_leave_date_from;
				$datahis['to_date']					= $old_leave_date_to;
				if($apply_for != 1){ 
					$rest_old_days = $no_of_days_form;
				}
				$datahis['no_of_days']				= $rest_old_days;
				$datahis['no_of_days_appr']			=  $rest_old_days;
				$datahis['leave_adjust']			=  1;
				$datahis['is_pay']					= 1;
				$datahis['appr_from_date']			=  $old_leave_date_from;  
				$datahis['sup_recom_date']			=  $old_leave_date_from;
				$datahis['appr_to_date']			=  $old_leave_date_to;  
				$datahis['appr_appr_date']			=  $old_leave_date_to; 
				  DB::table('tbl_leave_history')
					->insert($datahis);  	
			}   
		}
	}else if($datahis['type_id'] == 5){
				$rest_old_days 			= count($dates);
				$for_old_dates 			= array_slice($dates, 0, $rest_old_days); 
				$leave_dates = implode(",",$for_old_dates); 
				$datahis['leave_dates']			= $leave_dates;
				$datahis['from_date']		= $from_date;
				$datahis['to_date']			= $to_date; 
				$datahis['no_of_days']		= $no_of_days;
				$datahis['no_of_days_appr']	=  $no_of_days;
				$datahis['leave_adjust']	=  1;
				$datahis['is_pay']			= 1;
				$datahis['appr_from_date']		=  $from_date;  
				$datahis['sup_recom_date']		=  $from_date;
				$datahis['appr_to_date']		=  $to_date;  
				$datahis['appr_appr_date']		=  $to_date; 
				$casual_leave_open = $casual_leave_open -  $no_of_days;
				$datac['casual_leave_close'] 	= $casual_leave_open;
				$datac['last_update_date'] 			=  date('Y-m-d');  
				/* echo "<pre>";
				print_r($datahis);
				exit; */
				DB::table('tbl_leave_history')
					->insert($datahis);

					  
				 DB::table('tbl_leave_balance') 
					->where('emp_id', $emp_id)
					->where('f_year_id', $f_year_id)
					->update($datac); 
	}else{
			$rest_old_days 			= count($dates);
			$for_old_dates 			= array_slice($dates, 0, $rest_old_days); 
			$leave_dates = implode(",",$for_old_dates); 
			$datahis['leave_dates']				= $leave_dates;
			$datahis['from_date']				= $from_date;
			$datahis['to_date']					= $to_date;
			$datahis['no_of_days']				= $no_of_days;
			$datahis['no_of_days_appr']			=  $no_of_days;
			$datahis['leave_adjust']			=  1;
			$datahis['is_pay']					= 1;
			$datahis['appr_from_date']			=  $from_date;  
			$datahis['sup_recom_date']			=  $from_date;
			$datahis['appr_to_date']			=  $to_date;  
			$datahis['appr_appr_date']			=  $to_date; 
			  DB::table('tbl_leave_history')
				->insert($datahis);  
			}
			$dataup['executor_emp_id'] = Session::get('emp_id');
			$dataup['executor_action'] = 1;
			$dataup['stage'] = 3;
			$dataup['executor_action_date'] = date("Y-m-d");
			DB::table('leave_application') 
					->where('application_id', $application_id)
					->update($dataup);
		
			 return Redirect::to('/approved_by_hrm'); 
    } 
	public function leave_bulk_action_hrm1(Request $request){
		$flags 				= $request->input('flag');
		$uni_emp_ids 			= $request->input('uni_emp_id');
		$application_id 				= $request->input('application_id');
		foreach($uni_emp_ids as $cnt => $uni_emp_id) 
		{
			if (in_array($uni_emp_id, $flags)) 
			{
				echo $uni_emp_id;
			}
		}
		echo $application_id;
	}
	public function leave_bulk_action_hrm(Request $request){
		$dataup = array();
		$datahis = array();
		$data9_12 = array();  
		$datapre = array();  
		$datacur = array();  
		$data = array();  
		$datac = array();  
		$datahis['emp_type'] 			= 1;  
		$flags 				= $request->input('flag');
		
		$multi_application_id 			= $request->input('application_id');
		
		 
		foreach($multi_application_id as $cnt => $uapplication_id) 
		{
			 
			if (in_array($uapplication_id, $flags))
			{  
				$datahis['id_application'] 				= $application_id 				= $request->input('application_id')[$cnt];
				$datahis['emp_id']				= $emp_id = $request->input('emp_id')[$cnt]; 
				$datahis['f_year_id']			= $f_year_id = $request->input('f_year_id')[$cnt];
				$datahis['type_id']				= $type_id = $request->input('type_id')[$cnt];
				$datahis['designation_code']	= $request->input('designation_code')[$cnt];
				$datahis['branch_code']			= $request->input('branch_code')[$cnt];
				$datahis['application_date']	= $request->input('application_date')[$cnt];
				$datahis['apply_for']			= $apply_for = $request->input('apply_for')[$cnt];
				$datahis['remarks']			= $request->input('remarks')[$cnt];
				$datahis['approved_id']			= $request->input('approved_id')[$cnt];
				$datahis['appr_desig_code']			= $request->input('appr_desig_code')[$cnt];
				$datahis['sup_status']			= 1;  
				$datahis['appr_status']			= 1;   
				$datahis['leave_remain']			= $request->input('leave_remain')[$cnt];
				$datahis['tot_earn_leave']			= $request->input('tot_earn_leave')[$cnt];
				$datahis['is_application_flag']	= 1; 
				$datahis['user_code'] 			= Session::get('admin_id');
				$max_serial_no 		= DB::table('tbl_leave_history') 
											->where('for_which',1) 
											->where('f_year_id',$f_year_id) 
											->max('serial_no'); 	
				
				
				$datahis['serial_no'] 			= $max_serial_no + 1; 
				$cum_balance_less_12  			= $request->input('cum_balance_less_12')[$cnt];
				$cum_balance 					= $request->input('cum_balance')[$cnt];
				$pre_cumulative_open  			= $request->input('pre_cumulative_open')[$cnt];
				$current_open_balance 			=  $request->input('current_open_balance')[$cnt];
				$casual_leave_open 				=  $request->input('casual_leave_open')[$cnt];
				$from_date						= $request->input('from_date')[$cnt];
				$to_date						= $request->input('to_date')[$cnt];
				$no_of_days						= $request->input('no_of_days')[$cnt];
				$no_of_days_form				= $request->input('no_of_days')[$cnt];
				$leave_dates = DB::table('leave_application')
								->where('application_id', $application_id) 
								->first();
				$dates = explode(",",$leave_dates->leave_dates);
				$total_days = $max_no_leave = $leave_dates->no_of_days;
				if($datahis['type_id']	== 1){ 
					if($cum_balance_less_12 > 0.5 && $apply_for == 1)
					{
						$for_old_dates 			= array_slice($dates, 0, $cum_balance_less_12); 
						$rest_dates_from_old 	= array_slice($dates,$cum_balance_less_12);
						
						
						
						$no_of_days 				= count($for_old_dates);
						$rest_old_days 				= count($rest_dates_from_old);
						if($max_no_leave >= $cum_balance_less_12)
						{
							$old_leave_date_from = $dates[0];
							$old_leave_date_to = $dates[$cum_balance_less_12 - 1]; 
							$leave_dates = implode(",",$for_old_dates); 
							$old_flag = 2;
							$datahis['from_date']		= $old_leave_date_from;
							$datahis['to_date']			= $old_leave_date_to;
							$datahis['leave_dates']		= $leave_dates;
							if($apply_for != 1){ 
								$no_of_days = $no_of_days_form;
							}
							$datahis['no_of_days']		= $no_of_days;
							$datahis['no_of_days_appr']	=  $no_of_days;
							$datahis['leave_adjust']	=  3;
							$datahis['is_pay']			= 1;
							$datahis['appr_from_date']		=  $old_leave_date_from;  
							$datahis['sup_recom_date']		=  $old_leave_date_from;
							$datahis['appr_to_date']		=  $old_leave_date_to;  
							$datahis['appr_appr_date']		=  $old_leave_date_to; 
							$cum_balance_less_12 = $cum_balance_less_12 - $no_of_days;
							$data9_12['cum_balance_less_close_12'] 	= $cum_balance_less_12;
							$data9_12['last_update_date'] 			=  date('Y-m-d'); 
							 DB::table('tbl_leave_history')
								->insert($datahis);  
							 DB::table('tbl_leave_balance') 
								->where('emp_id', $emp_id)
								->where('f_year_id', $f_year_id)
								->update($data9_12);
						}else{
							$old_leave_date_from = $dates[0];
							$old_leave_date_to = $dates[$max_no_leave - 1]; 
							$old_flag = 1;
							$leave_dates = implode(",",$for_old_dates); 
							$datahis['leave_dates']			= $leave_dates;
							$datahis['from_date']			= $old_leave_date_from;
							$datahis['to_date']				= $old_leave_date_to;  
							$datahis['appr_from_date']		=  $old_leave_date_from;  
							$datahis['sup_recom_date']		=  $old_leave_date_from;
							$datahis['appr_to_date']		=  $old_leave_date_to;  
							$datahis['appr_appr_date']		=  $old_leave_date_to; 
							$datahis['no_of_days']			= $max_no_leave;
							$datahis['no_of_days_appr']		=  $max_no_leave;
							$datahis['leave_adjust']		=  3;
							$datahis['is_pay']				= 1;
							$data9_12['cum_balance_less_close_12'] 	= $cum_balance_less_12 - $max_no_leave;
							$data9_12['last_update_date'] 			=  date('Y-m-d'); 
							//$no_of_days = $no_of_days - $cum_balance_less_12;
							/*  echo "<pre>";
							print_r($datahis); */
							DB::table('tbl_leave_history')
								->insert($datahis);  
							 DB::table('tbl_leave_balance') 
								->where('emp_id', $emp_id)
								->where('f_year_id', $f_year_id)
								->update($data9_12); 
						} 
						$dates = $rest_dates_from_old;
						$total_days = count($dates); 
							
					}else if($cum_balance_less_12 == 0.5 && $apply_for != 1){
							$datahis['leave_dates']			= $from_date;
							$datahis['from_date']			= $from_date;
							$datahis['to_date']				= $to_date;  
							$datahis['appr_from_date']		=  $from_date;  
							$datahis['sup_recom_date']		=  $from_date;
							$datahis['appr_to_date']		=  $to_date;  
							$datahis['appr_appr_date']		=  $to_date; 
							$datahis['no_of_days']			= $max_no_leave;
							$datahis['no_of_days_appr']		=  $max_no_leave;
							$datahis['leave_adjust']		=  3;
							$datahis['is_pay']				= 1; 
							$data9_12['cum_balance_less_close_12'] 	=$cum_balance_less_12 - $no_of_days_form;
							$data9_12['last_update_date'] 			=  date('Y-m-d'); 
							/*  echo "<pre>";
							print_r($datahis); */
							DB::table('tbl_leave_history')
								->insert($datahis);  
							 DB::table('tbl_leave_balance') 
								->where('emp_id', $emp_id)
								->where('f_year_id', $f_year_id)
								->update($data9_12); 
						$old_flag = 3; 
						$total_days = 0;
					}
					else
					{
						$old_flag = 3;
					}
					if($total_days > 0){
						if($pre_cumulative_open > 0.5 && $apply_for == 1)
						{
							$rest_old_days 			= count($dates); 
							
							if($old_flag == 2 ){
								 
								
								
								$for_old_dates 			= array_slice($dates, 0, $pre_cumulative_open); 
								$rest_dates_from_old 	= array_slice($dates,$pre_cumulative_open);
									
								 
									if($rest_old_days >= $pre_cumulative_open)
									{
											$old_leave_date_from = $dates[0];
											$old_leave_date_to = $dates[$pre_cumulative_open - 1]; 
											$old_flag_pre = 2; 
											$leave_dates = implode(",",$for_old_dates); 
											$datahis['leave_dates']			= $leave_dates;
											$datahis['from_date']		= $old_leave_date_from;
											$datahis['to_date']			= $old_leave_date_to;
											if($apply_for != 1){ 
												$rest_old_days = $no_of_days_form;
											}
											$datahis['no_of_days']		= $rest_old_days;
											$datahis['no_of_days_appr']	=  $rest_old_days;
											$datahis['leave_adjust']	=  2;
											$datahis['is_pay']			= 1;
											$datahis['appr_from_date']		=  $old_leave_date_from;  
											$datahis['sup_recom_date']		=  $old_leave_date_from;
											$datahis['appr_to_date']		=  $old_leave_date_to;  
											$datahis['appr_appr_date']		=  $old_leave_date_to; 
											$pre_cumulative_open = $pre_cumulative_open - $rest_old_days;
											$cum_balance = $cum_balance - $rest_old_days;
											$datapre['pre_cumulative_close'] 	= $pre_cumulative_open;
											$datapre['cum_close_balance'] 	= $cum_balance;
											$datapre['last_update_date'] 			=  date('Y-m-d'); 
											
											 
											  DB::table('tbl_leave_history')
												->insert($datahis);  
											 DB::table('tbl_leave_balance') 
												->where('emp_id', $emp_id)
												->where('f_year_id', $f_year_id)
												->update($datapre); 
										
										
										
									}
									else{
											$old_leave_date_from = $dates[0];
											$old_leave_date_to = $dates[$rest_old_days - 1]; 
											$old_flag_pre = 1;
											$leave_dates = implode(",",$for_old_dates); 
											$datahis['leave_dates']			= $leave_dates;
											$datahis['from_date']				= $old_leave_date_from;
											$datahis['to_date']					= $old_leave_date_to;  
											$datahis['appr_from_date']			=  $old_leave_date_from;  
											$datahis['sup_recom_date']			=  $old_leave_date_from;
											$datahis['appr_to_date']			=  $old_leave_date_to;  
											$datahis['appr_appr_date']			=  $old_leave_date_to; 
											if($apply_for != 1){ 
												$rest_old_days = $no_of_days_form;
											}
											$datahis['no_of_days']				= $rest_old_days;
											$datahis['no_of_days_appr']			=  $rest_old_days;
											$datahis['leave_adjust']			=  2;
											$datahis['is_pay']					= 1;
											$pre_cumulative_open = $pre_cumulative_open - $rest_old_days;
											$cum_balance = $cum_balance - $rest_old_days;
											$datapre['pre_cumulative_close'] 	= $pre_cumulative_open;
											$datapre['cum_close_balance'] 	= $cum_balance;
											
											$datapre['last_update_date'] 			=  date('Y-m-d');
											/*  echo "<pre>";
											print_r($datahis);
											exit; */
											 DB::table('tbl_leave_history')
												->insert($datahis);  
											 DB::table('tbl_leave_balance') 
												->where('emp_id', $emp_id)
												->where('f_year_id', $f_year_id)
												->update($datapre); 
										
									} 
									$dates = $rest_dates_from_old;  
									$total_days = count($dates); 
									
								
							}else if($old_flag == 3){
								
								$for_old_dates 			= array_slice($dates, 0, $pre_cumulative_open); 
								$rest_dates_from_old 	= array_slice($dates,$pre_cumulative_open);
								$old_days 				= count($for_old_dates);
								$rest_old_days 			= count($rest_dates_from_old);
								 
								if($max_no_leave >= $pre_cumulative_open)
								{
									$old_leave_date_from = $dates[0];
									$old_leave_date_to = $dates[$pre_cumulative_open - 1]; 
									$old_flag_pre = 2; 
									$leave_dates = implode(",",$for_old_dates); 
									$datahis['leave_dates']			= $leave_dates;
									$datahis['from_date']		= $old_leave_date_from;
									$datahis['to_date']			= $old_leave_date_to;
									if($apply_for != 1){ 
										$old_days = $no_of_days_form;
									}
									$datahis['no_of_days']		= $old_days;
									$datahis['no_of_days_appr']	=  $old_days;
									$datahis['leave_adjust']	=  2;
									$datahis['is_pay']			= 1;
									$datahis['appr_from_date']		=  $old_leave_date_from;  
									$datahis['sup_recom_date']		=  $old_leave_date_from;
									$datahis['appr_to_date']		=  $old_leave_date_to;  
									$datahis['appr_appr_date']		=  $old_leave_date_to; 
									$pre_cumulative_open = $pre_cumulative_open - $old_days;
									$cum_balance =  $cum_balance - $old_days ;
									$datapre['pre_cumulative_close'] 	= $pre_cumulative_open;
									$datapre['cum_close_balance'] 	= $cum_balance;
									$datapre['last_update_date'] 			=  date('Y-m-d'); 
									
									 
									  DB::table('tbl_leave_history')
										->insert($datahis);  
									 DB::table('tbl_leave_balance') 
										->where('emp_id', $emp_id)
										->where('f_year_id', $f_year_id)
										->update($datapre); 
									
								}
								else{
									$old_leave_date_from = $dates[0];
									$old_leave_date_to = $dates[$max_no_leave - 1]; 
									$old_flag_pre = 1; 
									$leave_dates = implode(",",$for_old_dates); 
									$datahis['leave_dates']			= $leave_dates;
									$datahis['from_date']				= $old_leave_date_from;
									$datahis['to_date']					= $old_leave_date_to;  
									$datahis['appr_from_date']			=  $old_leave_date_from;  
									$datahis['sup_recom_date']			=  $old_leave_date_from;
									$datahis['appr_to_date']			=  $old_leave_date_to;  
									$datahis['appr_appr_date']			=  $old_leave_date_to; 
									if($apply_for != 1){ 
										$old_days = $no_of_days_form;
									}
									$datahis['no_of_days']				= $old_days;
									$datahis['no_of_days_appr']			=  $old_days;
									$datahis['leave_adjust']			=  2;
									$datahis['is_pay']					= 1;
									$pre_cumulative_open = $pre_cumulative_open - $old_days;
										$cum_balance = $cum_balance - $old_days;
									$datapre['pre_cumulative_close'] 	= $pre_cumulative_open;
									$datapre['cum_close_balance'] 	= $cum_balance;
									$datapre['last_update_date'] 			=  date('Y-m-d');
									/*  echo "<pre>";
									print_r($datahis);
									exit; */
									 DB::table('tbl_leave_history')
										->insert($datahis);  
									 DB::table('tbl_leave_balance') 
										->where('emp_id', $emp_id)
										->where('f_year_id', $f_year_id)
										->update($datapre); 
								}
								 
								$dates = $rest_dates_from_old;
								$total_days = count($dates); 
							}else{
								$old_flag_pre = 3;
							}
							
						}else if($pre_cumulative_open == 0.5 && $apply_for != 1){
								$datahis['leave_dates']			= $from_date;
								$datahis['from_date']		= $from_date;
								$datahis['to_date']			= $to_date;
								 
								$datahis['no_of_days']		= $no_of_days_form;
								$datahis['no_of_days_appr']	=  $no_of_days_form;
								$datahis['leave_adjust']	=  2;
								$datahis['is_pay']			= 1;
								$datahis['appr_from_date']		=  $from_date;  
								$datahis['sup_recom_date']		=  $from_date;
								$datahis['appr_to_date']		=  $to_date;  
								$datahis['appr_appr_date']		=  $to_date; 
								$pre_cumulative_open = $pre_cumulative_open - $no_of_days_form ;
								$cum_balance =  $cum_balance - $no_of_days_form;
								$datapre['pre_cumulative_close'] 	= $pre_cumulative_open;
								$datapre['cum_close_balance'] 	= $cum_balance;
								$datapre['last_update_date'] 			=  date('Y-m-d'); 
								
								 
								  DB::table('tbl_leave_history')
									->insert($datahis);  
								 DB::table('tbl_leave_balance') 
									->where('emp_id', $emp_id)
									->where('f_year_id', $f_year_id)
									->update($datapre); 
									$old_flag_pre = 3;
									$total_days = 0;
						}
						else
						{
							$old_flag_pre = 3;
						} 
					}
					if($total_days > 0){
							if($current_open_balance > 0.5 && $apply_for == 1)
								{ 
									if($old_flag_pre == 2 ){
										 
										$rest_old_days 			= count($dates); 
											
										
										$for_old_dates 			= array_slice($dates, 0, $current_open_balance); 
										
										
										$rest_dates_from_old 	= array_slice($dates,$current_open_balance);
											
											 
										if($rest_old_days >= $current_open_balance)
										{
											$old_leave_date_from = $dates[0];
											$old_leave_date_to = $dates[$current_open_balance - 1];  
											$old_flag_current = 2;  
											$leave_dates = implode(",",$for_old_dates); 
											$datahis['leave_dates']			= $leave_dates;
											$datahis['from_date']				= $old_leave_date_from;
											$datahis['to_date']					= $old_leave_date_to;
											if($apply_for != 1){ 
												$rest_old_days = $no_of_days_form;
											}
											$datahis['no_of_days']				= $rest_old_days;
											$datahis['no_of_days_appr']			=  $rest_old_days;
											$datahis['leave_adjust']			=  1;
											$datahis['is_pay']					= 1;
											$datahis['appr_from_date']			=  $old_leave_date_from;  
											$datahis['sup_recom_date']			=  $old_leave_date_from;
											$datahis['appr_to_date']			=  $old_leave_date_to;  
											$datahis['appr_appr_date']			=  $old_leave_date_to; 
											$current_open_balance 				= $current_open_balance -  $rest_old_days; 
											$datacur['current_close_balance'] 	= $current_open_balance; 
											$datacur['last_update_date'] 			=  date('Y-m-d'); 
											
											 $datacur['no_of_days'] 				= ($rest_old_days + $request->tot_expense);
											  DB::table('tbl_leave_history')
												->insert($datahis);  
											 DB::table('tbl_leave_balance') 
												->where('emp_id', $emp_id)
												->where('f_year_id', $f_year_id)
												->update($datacur); 
										}
										else{
											
											$old_leave_date_from = $dates[0];
											$old_leave_date_to = $dates[$rest_old_days - 1]; 
											$old_flag_current = 1; 
											$leave_dates = implode(",",$for_old_dates); 
											$datahis['leave_dates']			= $leave_dates;
											$datahis['from_date']				= $old_leave_date_from;
											$datahis['to_date']					= $old_leave_date_to;  
											$datahis['appr_from_date']			=  $old_leave_date_from;  
											$datahis['sup_recom_date']			=  $old_leave_date_from;
											$datahis['appr_to_date']			=  $old_leave_date_to;  
											$datahis['appr_appr_date']			=  $old_leave_date_to;
											if($apply_for != 1){ 
												$rest_old_days = $no_of_days_form;
											}
											$datahis['no_of_days']				= $rest_old_days;
											$datahis['no_of_days_appr']			=  $rest_old_days;
											$datahis['leave_adjust']			= 1;
											$datahis['is_pay']					= 1;
											$current_open_balance 				= $current_open_balance -  $rest_old_days; 
											$datacur['current_close_balance'] 	= $current_open_balance; 
											$datacur['last_update_date'] 			=  date('Y-m-d'); 
											 
											/*  echo "<pre>";
											print_r($datahis);
											exit; */
											 DB::table('tbl_leave_history')
												->insert($datahis);  
											 DB::table('tbl_leave_balance') 
												->where('emp_id', $emp_id)
												->where('f_year_id', $f_year_id)
												->update($datacur); 
											
										} 
										$dates = $rest_dates_from_old;
										$total_days = count($dates); 
										
									}else if($old_flag_pre == 3){
										
										$for_old_dates 			= array_slice($dates, 0, $current_open_balance); 
										$rest_dates_from_old 		= array_slice($dates,$current_open_balance);
										$old_days 					= count($for_old_dates);
										$rest_old_days 				= count($rest_dates_from_old);
										
										if($max_no_leave >= $current_open_balance)
										{
											
											$old_leave_date_from = $dates[0];
											$old_leave_date_to = $dates[$current_open_balance - 1];
											 
											$old_flag_current = 2; 
											$leave_dates = implode(",",$for_old_dates); 
											$datahis['leave_dates']			= $leave_dates;
											$datahis['from_date']				= $old_leave_date_from;
											$datahis['to_date']					= $old_leave_date_to;
											if($apply_for != 1){ 
												$old_days = $no_of_days_form;
											}
											$datahis['no_of_days']				= $old_days;
											$datahis['no_of_days_appr']			=  $old_days;
											$datahis['leave_adjust']			=  1;
											$datahis['is_pay']					= 1;
											$datahis['appr_from_date']			=  $old_leave_date_from;  
											$datahis['sup_recom_date']			=  $old_leave_date_from;
											$datahis['appr_to_date']			=  $old_leave_date_to;  
											$datahis['appr_appr_date']			=  $old_leave_date_to; 
											$current_open_balance 				= $current_open_balance -  $old_days; 
											$datacur['current_close_balance'] 	= $current_open_balance; 
											$datacur['last_update_date'] 			=  date('Y-m-d'); 
											
											 $datacur['no_of_days'] 				= ($old_days + $request->tot_expense);
											  DB::table('tbl_leave_history')
												->insert($datahis);  
											 DB::table('tbl_leave_balance') 
												->where('emp_id', $emp_id)
												->where('f_year_id', $f_year_id)
												->update($datacur); 
										}
										else{
											$old_leave_date_from = $dates[0];
											$old_leave_date_to = $dates[$max_no_leave - 1];
											$leave_dates = array();
											$old_flag_current = 1;  
											$leave_dates = implode(",",$for_old_dates); 
											$datahis['leave_dates']			= $leave_dates;
											$datahis['from_date']				= $old_leave_date_from;
											$datahis['to_date']					= $old_leave_date_to;  
											$datahis['appr_from_date']			=  $old_leave_date_from;  
											$datahis['sup_recom_date']			=  $old_leave_date_from;
											$datahis['appr_to_date']			=  $old_leave_date_to;  
											$datahis['appr_appr_date']			=  $old_leave_date_to;
											if($apply_for != 1){ 
												$old_days = $no_of_days_form;
											}											
											$datahis['no_of_days']				= $old_days;
											$datahis['no_of_days_appr']			=  $old_days;
											$datahis['leave_adjust']			= 1;
											$datahis['is_pay']					= 1;
											$current_open_balance 				= $current_open_balance -  $old_days;
											$datacur['current_close_balance'] 	= $current_open_balance; 
											$datacur['last_update_date'] 			=  date('Y-m-d'); 
											 DB::table('tbl_leave_history')
												->insert($datahis);  
											 DB::table('tbl_leave_balance') 
												->where('emp_id', $emp_id)
												->where('f_year_id', $f_year_id)
												->update($datacur);  
											
										}
										$dates = $rest_dates_from_old; 
										$total_days = count($dates); 
									}else{
										$old_flag_current = 3; 
									}
									
								}else if($current_open_balance == 0.5 && $apply_for != 1){
										$datahis['leave_dates']			= $from_date;
										$datahis['from_date']				= $from_date;
										$datahis['to_date']					= $to_date;
										 
										$datahis['no_of_days']				= $no_of_days_form;
										$datahis['no_of_days_appr']			=  $no_of_days_form;
										$datahis['leave_adjust']			=  1;
										$datahis['is_pay']					= 1;
										$datahis['appr_from_date']			=  $from_date;  
										$datahis['sup_recom_date']			=  $from_date;
										$datahis['appr_to_date']			=  $to_date;  
										$datahis['appr_appr_date']			=  $to_date; 
										$current_open_balance 				= $current_open_balance - $no_of_days_form; 
										$datacur['current_close_balance'] 	= $current_open_balance; 
										$datacur['last_update_date'] 			=  date('Y-m-d'); 
										
										 $datacur['no_of_days'] 				= ($no_of_days_form + $request->tot_expense);
										  DB::table('tbl_leave_history')
											->insert($datahis);  
										 DB::table('tbl_leave_balance') 
											->where('emp_id', $emp_id)
											->where('f_year_id', $f_year_id)
											->update($datacur); 
											$old_flag_current = 3;
											$total_days = 0;
									}
								else
								{
									$old_flag_current = 3;
								}
					}
					
					if($total_days > 0){
						 
							 
						$rest_old_days 			= count($dates);
						$for_old_dates 			= array_slice($dates, 0, $rest_old_days); 	
						if($rest_old_days > 0){
							$old_leave_date_from = $dates[0];
							$old_leave_date_to = $dates[$rest_old_days - 1];
							$leave_dates = implode(",",$for_old_dates); 
							$datahis['leave_dates']			= $leave_dates;
							$old_flag_current = 1;
							$datahis['from_date']				= $old_leave_date_from;
							$datahis['to_date']					= $old_leave_date_to;
							if($apply_for != 1){ 
								$rest_old_days = $no_of_days_form;
							}
							$datahis['no_of_days']				= $rest_old_days;
							$datahis['no_of_days_appr']			=  $rest_old_days;
							$datahis['leave_adjust']			=  1;
							$datahis['is_pay']					= 1;
							$datahis['appr_from_date']			=  $old_leave_date_from;  
							$datahis['sup_recom_date']			=  $old_leave_date_from;
							$datahis['appr_to_date']			=  $old_leave_date_to;  
							$datahis['appr_appr_date']			=  $old_leave_date_to; 
							  DB::table('tbl_leave_history')
								->insert($datahis);  	
						}   
					}
				}else if($datahis['type_id'] == 5){
							$rest_old_days 			= count($dates);
							$for_old_dates 			= array_slice($dates, 0, $rest_old_days); 
							$leave_dates = implode(",",$for_old_dates); 
							$datahis['leave_dates']			= $leave_dates;
							$datahis['from_date']		= $from_date;
							$datahis['to_date']			= $to_date;
							$datahis['no_of_days']		= $no_of_days;
							$datahis['no_of_days_appr']	=  $no_of_days;
							$datahis['leave_adjust']	=  1;
							$datahis['is_pay']			= 1;
							$datahis['appr_from_date']		=  $from_date;  
							$datahis['sup_recom_date']		=  $from_date;
							$datahis['appr_to_date']		=  $to_date;  
							$datahis['appr_appr_date']		=  $to_date; 
							$casual_leave_open = $casual_leave_open -  $no_of_days;
							$datac['casual_leave_close'] 	= $casual_leave_open;
							$datac['last_update_date'] 			=  date('Y-m-d');  
							/* echo "<pre>";
							print_r($datahis);
							exit; */
							DB::table('tbl_leave_history')
								->insert($datahis);

								  
							 DB::table('tbl_leave_balance') 
								->where('emp_id', $emp_id)
								->where('f_year_id', $f_year_id)
								->update($datac); 
				}else{
						$rest_old_days 			= count($dates);
						$for_old_dates 			= array_slice($dates, 0, $rest_old_days); 
						$leave_dates = implode(",",$for_old_dates); 
						$datahis['leave_dates']				= $leave_dates;
						$datahis['from_date']				= $from_date;
						$datahis['to_date']					= $to_date;
						$datahis['no_of_days']				= $no_of_days;
						$datahis['no_of_days_appr']			=  $no_of_days;
						$datahis['leave_adjust']			=  1;
						$datahis['is_pay']					= 1;
						$datahis['appr_from_date']			=  $from_date;  
						$datahis['sup_recom_date']			=  $from_date;
						$datahis['appr_to_date']			=  $to_date;  
						$datahis['appr_appr_date']			=  $to_date; 
						  DB::table('tbl_leave_history')
							->insert($datahis);  
						}
						$dataup['executor_emp_id'] = Session::get('emp_id');
						$dataup['executor_action'] = 1;
						$dataup['stage'] = 3;
						$dataup['executor_action_date'] = date("Y-m-d");
						DB::table('leave_application') 
								->where('application_id', $application_id)
								->update($dataup);
				}
				/* echo "<pre>";
				print_r($datahis); */
		}
		 return Redirect::to('/approved_by_hrm');
	}
	public function approve_leave_byhrm($id)
    {
		$data = array(); 
		$data['application_id'] 	= $id;
		
		$current_date = date('Y-m-d');
		
		$leave_appli_info = DB::table('leave_application')->where('application_id',$id)->first();
		 
		$approved_id 				= $leave_appli_info->super_emp_id;
		$data['reported_to']   = $reported_to 				= $leave_appli_info->reported_to;
		$data['application_date']   =    $application_date 		= $leave_appli_info->application_date; 
		$data['from_date'] 			=$from_date =  $leave_appli_info->leave_from; 
		$data['to_date'] 			= $leave_appli_info->leave_to; 
		$data['no_of_days'] 		=$leave_appli_info->no_of_days; 
		$data['apply_for'] 		=$leave_appli_info->apply_for; 
		/* echo $data['no_of_days'] ;
		exit; */ 
		$joining_date  = '';
		$data['remarks'] 		= $leave_appli_info->remarks; 
		$data['tot_earn_leave'] 	  = $leave_appli_info->tot_earn_leave; 
		$data['type_id'] 	    	= $leave_appli_info->leave_type; 
		 
		$emp_id = $uni_emp_id 	= $leave_appli_info->emp_id;
		$data['fiscal_year'] = DB::table('tbl_financial_year') 
									->where('running_status',1) 
									->first(); 
									/* echo "<pre>";
									print_r($data['fiscal_year']);
									exit; */
		$f_year_from = $data['fiscal_year']->f_year_from;  
		$data['f_year_id']   = $f_year_id = $data['fiscal_year']->id;  
		$data['leave_type'] 	= DB::table('tbl_leave_type')->get(); 
				$max_sarok = DB::table('tbl_master_tra as m')
							->where('m.emp_id', '=', $uni_emp_id)
							->where('m.br_join_date', '=', function($query) use ($uni_emp_id,$current_date)
									{
										$query->select(DB::raw('max(br_join_date)'))
											  ->from('tbl_master_tra')
											  ->where('emp_id',$uni_emp_id)
											  ->where('br_join_date', '<=', $current_date);
									})
							->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
							->groupBy('emp_id')
							->first();	
				if($max_sarok){	
					$emp_info = DB::table('tbl_master_tra as m') 
									->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id') 
									->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
									->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->select('emp.emp_id','emp.emp_name_eng as emp_name','emp.org_join_date as joining_date','b.br_code','d.designation_name','d.designation_code','b.branch_name')
									->first(); 
					
					$assign_emp = DB::table('tbl_emp_assign as ea')
									->where('ea.emp_id',$uni_emp_id)
									->where('ea.status', '!=', 0)
									->where('ea.select_type', '=', 1)
									->select('ea.emp_id','ea.open_date','ea.incharge_as')
									->first();
					$assign_branch = DB::table('tbl_emp_assign as ea')
												->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code')
												->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
												->where('ea.emp_id',$uni_emp_id)
												->where('ea.open_date', '<=', $current_date)
												->where('ea.status', '!=', 0)
												->where('ea.select_type', '=', 2)
												->select('ea.emp_id','ea.open_date','br.branch_name','br.br_code','ar.area_name')
												->first();
					$assign_designation = DB::table('tbl_emp_assign as ea')
												->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
												->where('ea.emp_id',$uni_emp_id)
												->where('ea.status', '!=', 0)
												->where('ea.select_type', '=', 5)
												->select('ea.emp_id','ea.open_date','de.designation_name','de.designation_code')
												->first(); 
					
					}
					
					$joining_date = $emp_info->joining_date; 
					if($reported_to != "Chairman"){
						$data['supervisor_info'] = $this->supervisor_info($approved_id);
					}    
		  
		 if(!empty($assign_branch)){
				 $branch_name = $assign_branch->branch_name; 
				 $br_code = $assign_branch->br_code; 
			 }else{
				  $branch_name = $emp_info->branch_name; 
				 $br_code = $emp_info->br_code;
			 } 
			 if(!empty($assign_designation)){
				  $designation_name 	= $assign_designation->designation_name; 
				 $designation_code 		= $assign_designation->designation_code;
			 }else{
				  $designation_name = $emp_info->designation_name; 
				 $designation_code = $emp_info->designation_code;
			 }
		
		$data['employee_his'] = array(
										'emp_id' 			 	=> $emp_id, 
										'emp_name'       	 	=> $emp_info->emp_name, 
										'joining_date'       	=> $emp_info->joining_date, 
										'designation_code'   	=> $designation_code,
										'branch_name'   		=> $branch_name,
										'br_code'   			=> $br_code,
										'designation_name'   	=> $designation_name
									);  
		
		
		 $emp_leave_balance = DB::table('tbl_leave_balance as lb') 
									->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'lb.f_year_id') 
									
									->where('lb.emp_id',$emp_id) 
									->where('lb.f_year_id',$f_year_id) 
									->select('fy.f_year_from','lb.no_of_days','lb.current_open_balance','lb.cum_close_balance','lb.current_close_balance','lb.cum_balance_less_close_12','lb.pre_cumulative_close','lb.casual_leave_close')
									->first(); 
		$max_serial_no 		= DB::table('tbl_leave_history') 
									->where('for_which',1) 
									->where('f_year_id',$f_year_id) 
									->max('serial_no'); 	
		
		
		$data['serial_no'] 			= $max_serial_no + 1; 
		
		  if($emp_leave_balance){
			    $data['f_year_from']  			= $emp_leave_balance->f_year_from;	
				$data['tot_expense']  			= $emp_leave_balance->no_of_days;	
				$data['pre_cumulative_open'] 	= $emp_leave_balance->pre_cumulative_close; 
				$data['casual_leave_open'] 	= $emp_leave_balance->casual_leave_close; 
				$data['cum_balance'] 			= $emp_leave_balance->cum_close_balance; 
				$data['current_open_balance'] 	= $emp_leave_balance->current_close_balance; 
				$data['cum_balance_less_12'] 	= $emp_leave_balance->cum_balance_less_close_12; 
		  } 
		$data['button'] 			= 'Save';   
		$data['employee_id'] 		= $emp_id; 
		
		 /* echo '<pre>';
		print_r($from_date);
		exit;  */
		 
		$year = date('Y',strtotime($f_year_from));
		$data['tot_earn_leave']  = $this->earn_leave($from_date, $joining_date, $year);
		/* echo '<pre>';
		print_r($data['tot_earn_leave']);
		exit;  */
		$data['all_emp_type'] = DB::table('tbl_emp_type')->where('status',1)->get();
		return view('admin.leave.emp_approved_pre_form_byhrm',$data);
    }
	public function earn_leave($from_date, $joining_date, $f_year_start)
	{
		
		date_default_timezone_set('Asia/Dhaka');
				 
				$j_additional_day = 0;
			
			  
				 if($joining_date > $f_year_start.'-'.'07'.'-'.'01'){ 
					 $system_time = date("Y-m-d",strtotime('+1 month', strtotime($joining_date)));
					 $join_day   =  date('d',strtotime($system_time));
					 $join_month   =  date('m',strtotime($system_time));
					 
					  if($join_day <= 10){
							$j_additional_day = 1.5;
						}else if($join_day <= 20){
							$j_additional_day = 1;
						}else{
							$j_additional_day = 0.5;
						} 
					 
					 
				}else{
					 $system_time = $f_year_start.'-'.'07'.'-'.'01'; 
				} 
			 
				 
				 $within_date = date('Y-m-03',strtotime($from_date));	
				 
				 
				$system_time = date('Y-m-01',strtotime($system_time)); 
				$date1=date_create($system_time);
				$date2=date_create($within_date);
				$diff=date_diff($date1,$date2);
 
			    $total_month= ($diff->format("%R%a"))/30;

				$total_month = intval($total_month); 
				 
				 if(strtotime($within_date) < strtotime($system_time)){
					$tot_earn_leave = ((-$total_month) * 1.5)+ $j_additional_day;
				}else{
					$tot_earn_leave = ($total_month * 1.5) + $j_additional_day;
				} 
				return $total_month;
	}
	
	public function supervisor_info($uni_emp_id)
	{
		$data = array();
		 $current_date = date("Y-m-d");
		 
				$max_sarok = DB::table('tbl_master_tra as m')
							->where('m.emp_id', '=', $uni_emp_id)
							->where('m.br_join_date', '=', function($query) use ($uni_emp_id,$current_date)
									{
										$query->select(DB::raw('max(br_join_date)'))
											  ->from('tbl_master_tra')
											  ->where('emp_id',$uni_emp_id)
											  ->where('br_join_date', '<=', $current_date);
									})
							->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
							->groupBy('emp_id')
							->first();	
				if($max_sarok){	
					$emp_info = DB::table('tbl_master_tra as m') 
									->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id') 
									->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')  
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->select('emp.emp_name_eng as emp_name','d.designation_name','d.designation_code')
									->first(); 
					}  
		$data['employee_his'] = array(
										'emp_name'       	 	=> $emp_info->emp_name,
										'emp_id'       	 		=> $uni_emp_id,
										'designation_name'   	=> $emp_info->designation_name,
										'designation_code'   	=> $emp_info->designation_code
									);  
		return $data;
	}
	
	public function day_calculation($from_date,$to_date){
		date_default_timezone_set('Asia/Dhaka');
		$date1=date_create($from_date);
		$date2=date_create($to_date);
		$diff=date_diff($date1,$date2);
		$no_of_days = $diff->format("%a")+1; 
		return $no_of_days;
	}
	public function leave_date_exist_app($from_date,$to_date,$emp_id){
				 
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
		
		$data['is_leave_date'] = $is_leave_date;
		$data['flag'] = $flag;
		$data['message'] = $message;
		$data['days'] = $leave_days;
		$data['leave_dates'] = $leave_dates;
		return $data;
	}
	
	
}
