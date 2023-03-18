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
										->leftJoin("tbl_emp_non_id as nid",function($join){
											$join->on("nid.emp_id","=","ap.emp_id")
												->where("nid.emp_id",">",100000);
										})
										
										->leftJoin('tbl_emp_basic_info as emp', 'ap.emp_id', '=', 'emp.emp_id')
										->leftJoin('tbl_emp_basic_info as emp1', 'mho.supervisor_id', '=', 'emp1.emp_id')
										->where(function($query){ 
												$query->Where('ap.super_action',1);
												//$query->orWhere('ap.hrhd_action',2); 
												})
										->orderby('ap.application_id','desc')
										->select('ap.*','emp.emp_name_eng as emp_name','emp1.emp_name_eng as approved_name','nid.sacmo_id as non_emp_id','nid.emp_name as emp_name2','nid.emp_type_code as emp_type','mho.supervisor_type','tbl_emp_photo.emp_photo')  
										->get(); 
		$pre_application_id = 0;						
		foreach($leave_recoment_list as $v_leave_recoment_list){
			if($v_leave_recoment_list->application_id != $pre_application_id){ 
				 
				$return_result =  $this->approve_leave_byhrm_for_list($v_leave_recoment_list->application_id);
				
				/* echo "<pre>";
				print_r($return_result);  */				
				 
				  $data['leave_recoment_list'][] = array(  
											'id'       	 			=> $v_leave_recoment_list->application_id, 
											'uni_emp_id'       	 		=> $v_leave_recoment_list->emp_id, 
											'emp_id'       	 		=> $return_result['emp_id'], 
											'emp_type'       	 	=> $return_result['emp_type'], 
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
											'emp_name2'       		=> $v_leave_recoment_list->emp_name2,
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
		if($uni_emp_id < 100000){
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
					$emp_type = 1;
					if($reported_to != "Chairman"){
						$supervisor_info = $this->supervisor_info($approved_id);
						$data['sup_emp_id'] 			= $supervisor_info['employee_his']['emp_id'];
						$data['sup_designation_code'] 	= $supervisor_info['employee_his']['designation_code'];
					}    
		}else{
			 
			$emp_info  = DB::table('tbl_emp_non_id as nid')  
										  ->leftjoin('tbl_nonid_official_info as oinf',function($join){
												$join->on("nid.emp_id","=","oinf.emp_id")
												->where('oinf.sarok_no',DB::raw("(SELECT 
																				  max(tbl_nonid_official_info.sarok_no)
																				  FROM tbl_nonid_official_info 
																				   where nid.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
																				  max(t.joining_date)
																				  FROM tbl_nonid_official_info as t 
																				   where nid.emp_id = t.emp_id)
																				  )") 		 
															); 
														})	 
										 ->leftJoin('tbl_designation as d', 'oinf.designation_code', '=', 'd.designation_code') 
										 ->leftJoin('tbl_branch as b', 'oinf.br_code', '=', 'b.br_code') 
										 ->where('nid.emp_id',$uni_emp_id)   
										 ->select('nid.sacmo_id as emp_id','nid.emp_name','nid.joining_date','b.br_code','d.designation_code','b.branch_name','d.designation_name','nid.emp_type_code as emp_type')
										 ->first(); 
			/*  echo '<pre>';
			print_r($datahis['employee_his']);
			exit; */ 							 
			$emp_id = $emp_info->emp_id;
			$emp_type = $emp_info->emp_type;
			$joining_date = $emp_info->joining_date;
			if($reported_to != "Chairman"){
				$supervisor_info = $this->supervisor_info($approved_id);
				$data['sup_emp_id'] 			= $supervisor_info['employee_his']['emp_id'];
				$data['sup_designation_code'] 	= $supervisor_info['employee_his']['designation_code'];
			}  
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
		$data['emp_type'] 			= $emp_type;
		$data['emp_name'] 			= $emp_info->emp_name; 
		$data['joining_date'] 		= $emp_info->joining_date; 
		$data['designation_code'] 	= $designation_code;  
		$data['designation_name'] 	= $designation_name;  
		$data['branch_name'] 	= $branch_name;  
		$data['br_code'] 			= $br_code; 
		
		 $emp_leave_balance = DB::table('tbl_leave_balance as lb') 
									->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'lb.f_year_id') 
									->where('lb.emp_type',$emp_type) 
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
		$data['emp_type'] 			= $emp_type; 
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
			$application_id 				= $request->application_id; 
			$datahis['emp_id'] 				= $emp_id = $request->emp_id; 
			$datahis['emp_type'] 			= $emp_type = $request->emp_type; 
			$datahis['serial_no'] 			= $request->serial_no; 
			$datahis['f_year_id'] 			= $f_year_id = $request->f_year_id; 
			$datahis['designation_code']	= $request->designation_code; 
			$datahis['branch_code']			= $request->branch_code; 
			$datahis['type_id']				= $type_id =  $request->type_id; 
			
			$datahis['application_date']	= $request->application_date; 
			$datahis['apply_for']	= $request->apply_for; 
			  
			$datahis['remarks']				= $request->remarks;  
			$appr_id_desig					= $request->approved_id;   
			$appr_id						= explode(",",$appr_id_desig);
			$datahis['approved_id'] 	 		= $appr_id[0];   
			$datahis['appr_desig_code'] 	 	= $appr_id[1];  
			$datahis['sup_status']			= 1;  
			$datahis['appr_status']			= 1;  
			$datahis['leave_remain']		= $request->leave_remain;
			
			
			$datahis['tot_earn_leave']		=  $request->tot_earn_leave;  
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
			 
			/*  echo "<pre>";
						print_r($pre_cumulative_open);
						exit;  */
			if($datahis['type_id'] == 1){
				$is_flag_9_12 = 0;
				$is_flag_pre = 0;
				$is_flag_cur = 0;
				if( $cum_balance_less_12 > 0 ){
					 if(0 < $no_of_days){
						if($no_of_days <= $cum_balance_less_12 ){
							$datahis['from_date']		= $from_date;
							$datahis['to_date']			= $to_date;
							$datahis['no_of_days']		= $no_of_days;
							$datahis['no_of_days_appr']	=  $no_of_days;
							$datahis['leave_adjust']	=  3;
							$datahis['is_pay']			= 1;
							$datahis['appr_from_date']		=  $from_date;  
							$datahis['sup_recom_date']		=  $from_date;
							$datahis['appr_to_date']		=  $to_date;  
							$datahis['appr_appr_date']		=  $to_date; 
							$cum_balance_less_12 = $cum_balance_less_12 -  $no_of_days;
							$data9_12['cum_balance_less_close_12'] 	= $cum_balance_less_12;
							$data9_12['last_update_date'] 			=  date('Y-m-d'); 
							 DB::table('tbl_leave_history')
								->insert($datahis);  
							 DB::table('tbl_leave_balance')
								->where('emp_type', $emp_type)
								->where('emp_id', $emp_id)
								->where('f_year_id', $f_year_id)
								->update($data9_12);	
						   $no_of_days = 0;
						}else{
							$is_flag_9_12 = 1;
							$add_day = ($cum_balance_less_12 -1);
							$datahis['from_date']			= $from_date;
							$datahis['to_date']				= $new_to_date = date('Y-m-d', strtotime($from_date. " + $add_day days"));  
							$datahis['appr_from_date']		=  $from_date;  
							$datahis['sup_recom_date']		=  $from_date;
							$datahis['appr_to_date']		=  $new_to_date;  
							$datahis['appr_appr_date']		=  $new_to_date; 
							$datahis['no_of_days']			= $cum_balance_less_12;
							$datahis['no_of_days_appr']		=  $cum_balance_less_12;
							$datahis['leave_adjust']		=  3;
							$datahis['is_pay']				= 1;
							$data9_12['cum_balance_less_close_12'] 	= 0;
							$data9_12['last_update_date'] 			=  date('Y-m-d'); 
							$no_of_days = $no_of_days - $cum_balance_less_12;
							/*  echo "<pre>";
							print_r($datahis); */
							DB::table('tbl_leave_history')
								->insert($datahis);  
							 DB::table('tbl_leave_balance')
								->where('emp_type', $emp_type)
								->where('emp_id', $emp_id)
								->where('f_year_id', $f_year_id)
								->update($data9_12); 
						}
					 }
				}
				if($pre_cumulative_open > 0){
					  if(0 < $no_of_days){
						if($no_of_days < $pre_cumulative_open ){
								if($is_flag_9_12 == 1){
									$from_date = date('Y-m-d', strtotime($new_to_date. " + 1 days")); 
								}else{
									$from_date = $from_date; 
								}
								$datahis['from_date']		= $from_date;
								$datahis['to_date']			= $to_date;
								$datahis['no_of_days']		= $no_of_days;
								$datahis['no_of_days_appr']	=  $no_of_days;
								$datahis['leave_adjust']	=  2;
								$datahis['is_pay']			= 1;
								$datahis['appr_from_date']		=  $from_date;  
								$datahis['sup_recom_date']		=  $from_date;
								$datahis['appr_to_date']		=  $to_date;  
								$datahis['appr_appr_date']		=  $to_date; 
								$pre_cumulative_open = $pre_cumulative_open -  $no_of_days;
								$cum_balance = $cum_balance -  $no_of_days;
								$datapre['pre_cumulative_close'] 	= $pre_cumulative_open;
								$datapre['cum_close_balance'] 	= $cum_balance;
								$datapre['last_update_date'] 			=  date('Y-m-d'); 
								
								 
								  DB::table('tbl_leave_history')
									->insert($datahis);  
								 DB::table('tbl_leave_balance')
									->where('emp_type', $emp_type)
									->where('emp_id', $emp_id)
									->where('f_year_id', $f_year_id)
									->update($datapre); 
									$no_of_days = 0;
						}else{ 
								$is_flag_pre = 1;
								if($is_flag_9_12 == 1){
									$from_date = date('Y-m-d', strtotime($new_to_date. " + 1 days")); 
								}else{
									$from_date = $from_date; 
								}
								$add_day = ($pre_cumulative_open -1);
								$datahis['from_date']				= $from_date;
								$datahis['to_date']					= $new_to_date = date('Y-m-d', strtotime($from_date. " + $add_day days"));  
								$datahis['appr_from_date']			=  $from_date;  
								$datahis['sup_recom_date']			=  $from_date;
								$datahis['appr_to_date']			=  $new_to_date;  
								$datahis['appr_appr_date']			=  $new_to_date; 
								$datahis['no_of_days']				= $pre_cumulative_open;
								$datahis['no_of_days_appr']			=  $pre_cumulative_open;
								$datahis['leave_adjust']			=  2;
								$datahis['is_pay']					= 1;
								$datapre['pre_cumulative_close'] 	= 0;
								$datapre['cum_close_balance'] 	= 0;
								$datapre['last_update_date'] 			=  date('Y-m-d'); 
								$no_of_days = $no_of_days - $pre_cumulative_open;
								/*  echo "<pre>";
								print_r($datahis);
								exit; */
								 DB::table('tbl_leave_history')
									->insert($datahis);  
								 DB::table('tbl_leave_balance')
									->where('emp_type', $emp_type)
									->where('emp_id', $emp_id)
									->where('f_year_id', $f_year_id)
									->update($datapre); 
							}
						}
					}
				if($current_open_balance > 0){
					 if(0 < $no_of_days){
						 
					 
						if($no_of_days < $current_open_balance ){
							if($is_flag_pre == 1){
								$from_date = date('Y-m-d', strtotime($new_to_date. " + 1 days")); 
							}else{
								$from_date = $from_date; 
							}
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
							$current_open_balance 				= $current_open_balance -  $no_of_days; 
							$datacur['current_close_balance'] 	= $current_open_balance; 
							$datacur['last_update_date'] 			=  date('Y-m-d'); 
							
							 $datacur['no_of_days'] 				= ($no_of_days + $request->tot_expense);
							  DB::table('tbl_leave_history')
								->insert($datahis);  
							 DB::table('tbl_leave_balance')
								->where('emp_type', $emp_type)
								->where('emp_id', $emp_id)
								->where('f_year_id', $f_year_id)
								->update($datacur); 
							$no_of_days = 0;
						}else{ 
							$is_flag_cur = 1;
							if($is_flag_pre == 1){
								$from_date = date('Y-m-d', strtotime($new_to_date. " + 1 days")); 
							}else{
								$from_date = $from_date; 
							}
							$add_day = ($current_open_balance -1);
							$datahis['from_date']				= $from_date;
							$datahis['to_date']					= $new_to_date = date('Y-m-d', strtotime($from_date. " + $add_day days"));  
							$datahis['appr_from_date']			=  $from_date;  
							$datahis['sup_recom_date']			=  $from_date;
							$datahis['appr_to_date']			=  $new_to_date;  
							$datahis['appr_appr_date']			=  $new_to_date; 
							$datahis['no_of_days']				= $current_open_balance;
							$datahis['no_of_days_appr']			=  $current_open_balance;
							$datahis['leave_adjust']			= 1;
							$datahis['is_pay']					= 1;
							$datacur['current_close_balance'] 	= 0; 
							$datacur['last_update_date'] 			=  date('Y-m-d'); 
							$no_of_days = $no_of_days - $current_open_balance;
							/*  echo "<pre>";
							print_r($datahis);
							exit; */
							 DB::table('tbl_leave_history')
								->insert($datahis);  
							 DB::table('tbl_leave_balance')
								->where('emp_type', $emp_type)
								->where('emp_id', $emp_id)
								->where('f_year_id', $f_year_id)
								->update($datacur); 
						}
					
					}
				}
				if($no_of_days > 0){
					if($is_flag_cur == 1){
							$from_date = date('Y-m-d', strtotime($new_to_date. " + 1 days")); 
						}else{
							$from_date = $from_date; 
						}
						$datahis['from_date']				= $from_date;
						$datahis['to_date']					= $to_date;
						$datahis['no_of_days']				= $no_of_days;
						$datahis['no_of_days_appr']			=  $no_of_days;
						$datahis['leave_adjust']			=  1;
						$datahis['is_pay']					= 2;
						$datahis['appr_from_date']			=  $from_date;  
						$datahis['sup_recom_date']			=  $from_date;
						$datahis['appr_to_date']			=  $to_date;  
						$datahis['appr_appr_date']			=  $to_date; 
						  DB::table('tbl_leave_history')
							->insert($datahis);  
						$no_of_days	 = 0;
				}
			}else if($datahis['type_id'] == 5){
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
								->where('emp_type', $emp_type)
								->where('emp_id', $emp_id)
								->where('f_year_id', $f_year_id)
								->update($datac); 
			}else{
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
		$flags 				= $request->input('flag');
		$uni_emp_ids 			= $request->input('uni_emp_id');
		foreach($uni_emp_ids as $cnt => $uni_emp_id) 
		{
			 
			if (in_array($uni_emp_id, $flags)) 
			{
				$application_id 				= $request->input('application_id')[$cnt];
				$datahis['emp_id']				= $emp_id = $request->input('emp_id')[$cnt];
				$datahis['emp_type']			= $emp_type = $request->input('emp_type')[$cnt];
				$datahis['f_year_id']			= $f_year_id = $request->input('f_year_id')[$cnt];
				$datahis['type_id']				= $type_id = $request->input('type_id')[$cnt];
				$datahis['designation_code']	= $request->input('designation_code')[$cnt];
				$datahis['branch_code']			= $request->input('branch_code')[$cnt];
				$datahis['application_date']	= $request->input('application_date')[$cnt];
				$datahis['apply_for']			= $request->input('apply_for')[$cnt];
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
				$cum_balance_less_12  	= $request->input('cum_balance_less_12')[$cnt];
				$cum_balance 			= $request->input('cum_balance')[$cnt];
				$pre_cumulative_open  			= $request->input('pre_cumulative_open')[$cnt];
				$current_open_balance 			=  $request->input('current_open_balance')[$cnt];
				$casual_leave_open 			=  $request->input('casual_leave_open')[$cnt];
				$from_date						= $request->input('from_date')[$cnt];
				$to_date						= $request->input('to_date')[$cnt];
				$no_of_days						= $request->input('no_of_days')[$cnt];
		
				if($datahis['type_id'] == 1){
					$is_flag_9_12 = 0;
					$is_flag_pre = 0;
					$is_flag_cur = 0;
					if( $cum_balance_less_12 > 0 ){
						 if(0 < $no_of_days){
							if($no_of_days <= $cum_balance_less_12 ){
								$datahis['from_date']		= $from_date;
								$datahis['to_date']			= $to_date;
								$datahis['no_of_days']		= $no_of_days;
								$datahis['no_of_days_appr']	=  $no_of_days;
								$datahis['leave_adjust']	=  3;
								$datahis['is_pay']			= 1;
								$datahis['appr_from_date']		=  $from_date;  
								$datahis['sup_recom_date']		=  $from_date;
								$datahis['appr_to_date']		=  $to_date;  
								$datahis['appr_appr_date']		=  $to_date; 
								$cum_balance_less_12 = $cum_balance_less_12 -  $no_of_days;
								$data9_12['cum_balance_less_close_12'] 	= $cum_balance_less_12;
								$data9_12['last_update_date'] 			=  date('Y-m-d'); 
								/*  DB::table('tbl_leave_history')
									->insert($datahis);  
								 DB::table('tbl_leave_balance')
									->where('emp_type', $emp_type)
									->where('emp_id', $emp_id)
									->where('f_year_id', $f_year_id)
									->update($data9_12);	 */
							   $no_of_days = 0;
							}else{
								$is_flag_9_12 = 1;
								$add_day = ($cum_balance_less_12 -1);
								$datahis['from_date']			= $from_date;
								$datahis['to_date']				= $new_to_date = date('Y-m-d', strtotime($from_date. " + $add_day days"));  
								$datahis['appr_from_date']		=  $from_date;  
								$datahis['sup_recom_date']		=  $from_date;
								$datahis['appr_to_date']		=  $new_to_date;  
								$datahis['appr_appr_date']		=  $new_to_date; 
								$datahis['no_of_days']			= $cum_balance_less_12;
								$datahis['no_of_days_appr']		=  $cum_balance_less_12;
								$datahis['leave_adjust']		=  3;
								$datahis['is_pay']				= 1;
								$data9_12['cum_balance_less_close_12'] 	= 0;
								$data9_12['last_update_date'] 			=  date('Y-m-d'); 
								$no_of_days = $no_of_days - $cum_balance_less_12;
							 
								/* DB::table('tbl_leave_history')
									->insert($datahis);  
								 DB::table('tbl_leave_balance')
									->where('emp_type', $emp_type)
									->where('emp_id', $emp_id)
									->where('f_year_id', $f_year_id)
									->update($data9_12); */ 
							}
						 }
					}
					if($pre_cumulative_open > 0){
						  if(0 < $no_of_days){
							if($no_of_days < $pre_cumulative_open ){
									if($is_flag_9_12 == 1){
										$from_date = date('Y-m-d', strtotime($new_to_date. " + 1 days")); 
									}else{
										$from_date = $from_date; 
									}
									$datahis['from_date']		= $from_date;
									$datahis['to_date']			= $to_date;
									$datahis['no_of_days']		= $no_of_days;
									$datahis['no_of_days_appr']	=  $no_of_days;
									$datahis['leave_adjust']	=  2;
									$datahis['is_pay']			= 1;
									$datahis['appr_from_date']		=  $from_date;  
									$datahis['sup_recom_date']		=  $from_date;
									$datahis['appr_to_date']		=  $to_date;  
									$datahis['appr_appr_date']		=  $to_date; 
									$pre_cumulative_open = $pre_cumulative_open -  $no_of_days;
									$cum_balance = $cum_balance -  $no_of_days;
									$datapre['pre_cumulative_close'] 	= $pre_cumulative_open;
									$datapre['cum_close_balance'] 	= $cum_balance;
									$datapre['last_update_date'] 			=  date('Y-m-d'); 
									
									 
									  /* DB::table('tbl_leave_history')
										->insert($datahis);  
									 DB::table('tbl_leave_balance')
										->where('emp_type', $emp_type)
										->where('emp_id', $emp_id)
										->where('f_year_id', $f_year_id)
										->update($datapre) */; 
										$no_of_days = 0;
							}else{ 
									$is_flag_pre = 1;
									if($is_flag_9_12 == 1){
										$from_date = date('Y-m-d', strtotime($new_to_date. " + 1 days")); 
									}else{
										$from_date = $from_date; 
									}
									$add_day = ($pre_cumulative_open -1);
									$datahis['from_date']				= $from_date;
									$datahis['to_date']					= $new_to_date = date('Y-m-d', strtotime($from_date. " + $add_day days"));  
									$datahis['appr_from_date']			=  $from_date;  
									$datahis['sup_recom_date']			=  $from_date;
									$datahis['appr_to_date']			=  $new_to_date;  
									$datahis['appr_appr_date']			=  $new_to_date; 
									$datahis['no_of_days']				= $pre_cumulative_open;
									$datahis['no_of_days_appr']			=  $pre_cumulative_open;
									$datahis['leave_adjust']			=  2;
									$datahis['is_pay']					= 1;
									$datapre['pre_cumulative_close'] 	= 0;
									$datapre['cum_close_balance'] 	= 0;
									$datapre['last_update_date'] 			=  date('Y-m-d'); 
									$no_of_days = $no_of_days - $pre_cumulative_open;
									 
									/*  DB::table('tbl_leave_history')
										->insert($datahis);  
									 DB::table('tbl_leave_balance')
										->where('emp_type', $emp_type)
										->where('emp_id', $emp_id)
										->where('f_year_id', $f_year_id)
										->update($datapre);  */
								}
							}
						}
					if($current_open_balance > 0){
						 if(0 < $no_of_days){
							 
						 
							if($no_of_days < $current_open_balance ){
								if($is_flag_pre == 1){
									$from_date = date('Y-m-d', strtotime($new_to_date. " + 1 days")); 
								}else{
									$from_date = $from_date; 
								}
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
								$current_open_balance 				= $current_open_balance -  $no_of_days; 
								$datacur['current_close_balance'] 	= $current_open_balance; 
								$datacur['last_update_date'] 			=  date('Y-m-d'); 
								
								 $datacur['no_of_days'] 				= ($no_of_days + $request->tot_expense);
								 /*  DB::table('tbl_leave_history')
									->insert($datahis);  
								 DB::table('tbl_leave_balance')
									->where('emp_type', $emp_type)
									->where('emp_id', $emp_id)
									->where('f_year_id', $f_year_id)
									->update($datacur);  */
								$no_of_days = 0;
							}else{ 
								$is_flag_cur = 1;
								if($is_flag_pre == 1){
									$from_date = date('Y-m-d', strtotime($new_to_date. " + 1 days")); 
								}else{
									$from_date = $from_date; 
								}
								$add_day = ($current_open_balance -1);
								$datahis['from_date']				= $from_date;
								$datahis['to_date']					= $new_to_date = date('Y-m-d', strtotime($from_date. " + $add_day days"));  
								$datahis['appr_from_date']			=  $from_date;  
								$datahis['sup_recom_date']			=  $from_date;
								$datahis['appr_to_date']			=  $new_to_date;  
								$datahis['appr_appr_date']			=  $new_to_date; 
								$datahis['no_of_days']				= $current_open_balance;
								$datahis['no_of_days_appr']			=  $current_open_balance;
								$datahis['leave_adjust']			= 1;
								$datahis['is_pay']					= 1;
								$datacur['current_close_balance'] 	= 0; 
								$datacur['last_update_date'] 			=  date('Y-m-d'); 
								$no_of_days = $no_of_days - $current_open_balance;
								 
								 /* DB::table('tbl_leave_history')
									->insert($datahis);  
								 DB::table('tbl_leave_balance')
									->where('emp_type', $emp_type)
									->where('emp_id', $emp_id)
									->where('f_year_id', $f_year_id)
									->update($datacur);  */
							}
						
						}
					}
					if($no_of_days > 0){
						if($is_flag_cur == 1){
								$from_date = date('Y-m-d', strtotime($new_to_date. " + 1 days")); 
							}else{
								$from_date = $from_date; 
							}
							$datahis['from_date']				= $from_date;
							$datahis['to_date']					= $to_date;
							$datahis['no_of_days']				= $no_of_days;
							$datahis['no_of_days_appr']			=  $no_of_days;
							$datahis['leave_adjust']			=  1;
							$datahis['is_pay']					= 2;
							$datahis['appr_from_date']			=  $from_date;  
							$datahis['sup_recom_date']			=  $from_date;
							$datahis['appr_to_date']			=  $to_date;  
							$datahis['appr_appr_date']			=  $to_date; 
							/*   DB::table('tbl_leave_history')
								->insert($datahis);   */
							$no_of_days	 = 0;
					}
				}else if($datahis['type_id'] == 5){
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
								/* DB::table('tbl_leave_history')
									->insert($datahis);

									  
								 DB::table('tbl_leave_balance')
									->where('emp_type', $emp_type)
									->where('emp_id', $emp_id)
									->where('f_year_id', $f_year_id)
									->update($datac);  */
				}else{
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
							  /* DB::table('tbl_leave_history')
								->insert($datahis);  */ 
				}
				$dataup['executor_emp_id'] = Session::get('emp_id');
				$dataup['executor_action'] = 1;
				$dataup['stage'] = 3;
				$dataup['executor_action_date'] = date("Y-m-d");
				/* DB::table('leave_application') 
						->where('application_id', $application_id)
						->update($dataup); */
				}
				echo "<pre>";
				print_r($datahis);
		}
		exit;
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
		if($uni_emp_id < 100000){
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
					$emp_type = 1;
					if($reported_to != "Chairman"){
						$data['supervisor_info'] = $this->supervisor_info($approved_id);
					}    
		}else{
			 
			$emp_info  = DB::table('tbl_emp_non_id as nid')  
										  ->leftjoin('tbl_nonid_official_info as oinf',function($join){
												$join->on("nid.emp_id","=","oinf.emp_id")
												->where('oinf.sarok_no',DB::raw("(SELECT 
																				  max(tbl_nonid_official_info.sarok_no)
																				  FROM tbl_nonid_official_info 
																				   where nid.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
																				  max(t.joining_date)
																				  FROM tbl_nonid_official_info as t 
																				   where nid.emp_id = t.emp_id)
																				  )") 		 
															); 
														})	 
										 ->leftJoin('tbl_designation as d', 'oinf.designation_code', '=', 'd.designation_code') 
										 ->leftJoin('tbl_branch as b', 'oinf.br_code', '=', 'b.br_code') 
										 ->where('nid.emp_id',$uni_emp_id)   
										 ->select('nid.sacmo_id as emp_id','nid.emp_name','nid.joining_date','b.br_code','d.designation_code','b.branch_name','d.designation_name','nid.emp_type_code as emp_type')
										 ->first(); 
			/*  echo '<pre>';
			print_r($datahis['employee_his']);
			exit; */ 							 
			$emp_id = $emp_info->emp_id;
			$emp_type = $emp_info->emp_type;
			$joining_date = $emp_info->joining_date;
			if($reported_to != "Chairman"){
				$data['supervisor_info'] = $this->supervisor_info($approved_id);
			}  
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
										'emp_type' 			 	=> $emp_type,
										'emp_name'       	 	=> $emp_info->emp_name, 
										'joining_date'       	=> $emp_info->joining_date, 
										'designation_code'   	=> $designation_code,
										'branch_name'   		=> $branch_name,
										'br_code'   			=> $br_code,
										'designation_name'   	=> $designation_name
									);  
		
		
		 $emp_leave_balance = DB::table('tbl_leave_balance as lb') 
									->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'lb.f_year_id') 
									->where('lb.emp_type',$emp_type) 
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
		$data['emp_type'] 			= $emp_type; 
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
		if($uni_emp_id < 100000){
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
		}else{
			 
			$emp_info  = DB::table('tbl_emp_non_id as nid')  
										  ->leftjoin('tbl_nonid_official_info as oinf',function($join){
												$join->on("nid.emp_id","=","oinf.emp_id")
												->where('oinf.sarok_no',DB::raw("(SELECT 
																				  max(tbl_nonid_official_info.sarok_no)
																				  FROM tbl_nonid_official_info 
																				   where nid.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
																				  max(t.joining_date)
																				  FROM tbl_nonid_official_info as t 
																				   where nid.emp_id = t.emp_id)
																				  )") 		 
															); 
														})	 
										 ->leftJoin('tbl_designation as d', 'oinf.designation_code', '=', 'd.designation_code')  
										 ->where('nid.emp_id',$uni_emp_id)   
										 ->select( 'nid.emp_name','d.designation_code','d.designation_name')
										 ->first(); 
			/*  echo '<pre>';
			print_r($datahis['employee_his']);
			exit; */ 	
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
	public function leave_date_exist_app($from_date,$to_date,$emp_type,$emp_id){
				 
		
			$check_leave_date_half = DB::table('tbl_leave_history') 
										->where('emp_id',$emp_id) 
										->where('emp_type',$emp_type)  
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
											->where('emp_type',$emp_type)  
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
					echo '1';
				}else{
					echo '0';
				}
	}
	
	
}
