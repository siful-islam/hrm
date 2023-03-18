<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Middleware\CheckUserSession;
use DB;
use Session;

class LeavesuvisorController extends Controller
{

	public function __construct()
	{
	 
		$this->middleware('CheckUserSession'); 
	}  
	public function index()
    {
		$supervisor_id = Session::get('emp_id');
		if($supervisor_id == 100009){
			$data = $this->index_hrm_head();
			return view('admin.leave.leave_recommend_list_hr_head',$data);
		}else{
			$data = $this->index_general();
			return view('admin.leave.leave_recommend_list',$data);
		}
	}
	public function index_hrm_head()
	{
		$data = array();
		$current_date = date("Y-m-d");
		$data['leave_recoment_list'] = array(); /// this ID come from session 
		$supervisor_id = $data['supervisor_id'] = Session::get('emp_id'); /// this ID come from session 
		$leave_recoment_list = DB::table('leave_application as ap') 
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
										->where(function($query) use ($supervisor_id) {
												$query->where('mho.supervisor_id',$supervisor_id);
												
												$query->orwhereBetween('ap.hrhd_action',[1,4]);
												/* $query->orWhere('ap.hrhd_action',0);
												$query->orWhere('ap.hrhd_action',1);
												$query->orWhere('ap.hrhd_action',2);
												$query->orWhere('ap.hrhd_action',3);  */
												})
										->orderby('ap.application_id','desc')
										->select('ap.*','emp.emp_name_eng as emp_name','emp1.emp_name_eng as approved_name','nid.emp_name as emp_name2','mho.supervisor_type')  
										->get(); 
		$pre_application_id = 0;						
		foreach($leave_recoment_list as $v_leave_recoment_list){
			if($v_leave_recoment_list->application_id != $pre_application_id){ 
				$data['leave_recoment_list'][] = array(  
											'id'       	 			=> $v_leave_recoment_list->application_id, 
											'from_date'       	 			=> $v_leave_recoment_list->leave_from, 
											'to_date'       	 			=> $v_leave_recoment_list->leave_to, 
											'emp_id'       	 		=> $v_leave_recoment_list->emp_id, 
											'emp_name'       	 	=> $v_leave_recoment_list->emp_name, 
											'approved_name'       	=> $v_leave_recoment_list->approved_name, 
											'emp_name2'       		=> $v_leave_recoment_list->emp_name2,
											'supervisor_type'       => $v_leave_recoment_list->supervisor_type,
											'hrhd_action'       			=> $v_leave_recoment_list->hrhd_action, 
											'super_action'     	=> $v_leave_recoment_list->super_action,
											'first_super_action'     => $v_leave_recoment_list->first_super_action, 
											'application_date'      => $v_leave_recoment_list->application_date 
										); 
			}
			$pre_application_id =$v_leave_recoment_list->application_id;
		}
		
		
	/* 	 echo "<pre>";
		print_r($data['leave_recoment_list']);
		exit;  */
	return $data;	
}
	public function index_general(){	
        $data = array();
		$current_date = date("Y-m-d");
		$data['leave_recoment_list'] = array(); /// this ID come from session 
		$data['supervisor_id'] = Session::get('emp_id'); /// this ID come from session 
		$leave_recoment_list = DB::table('leave_application as ap') 
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
										->where('mho.supervisor_id',$data['supervisor_id']) 
										->select('ap.*','emp.emp_name_eng as emp_name','emp1.emp_name_eng as approved_name','nid.emp_name as emp_name2','mho.supervisor_type') 
										->get();
		
		
		foreach($leave_recoment_list as $v_leave_recoment_list){
			if($v_leave_recoment_list->supervisor_type == 1){
								$sub_sup_info = DB::table('leave_application as ap')  
												->where('ap.application_id',$v_leave_recoment_list->application_id)   
												->first();
								$sub_sup_info_type = DB::table('supervisor_mapping_ho')  
													->where('emp_id',$v_leave_recoment_list->emp_id)   
													->where('supervisor_type',2)   
													->first();
			
								
				if(!empty($sub_sup_info_type)){
					if($sub_sup_info->first_super_action == 3){
					
					$data['leave_recoment_list'][] = array(  
											'id'       	 			=> $v_leave_recoment_list->application_id, 
											'emp_id'       	 		=> $v_leave_recoment_list->emp_id, 
											'emp_name'       	 	=> $v_leave_recoment_list->emp_name, 
											'approved_name'       	=> $v_leave_recoment_list->approved_name, 
											'super_action'     	=> $v_leave_recoment_list->super_action,
											'first_super_action'     => $v_leave_recoment_list->first_super_action,
											'supervisor_type'       => $v_leave_recoment_list->supervisor_type, 
											'hrhd_action'       			=> $v_leave_recoment_list->hrhd_action, 
											'emp_name2'       		=> $v_leave_recoment_list->emp_name2, 
											'application_date'      => $v_leave_recoment_list->application_date 
										); 
				}
				}else{ 
					$data['leave_recoment_list'][] = array(  
											'id'       	 			=> $v_leave_recoment_list->application_id, 
											'emp_id'       	 		=> $v_leave_recoment_list->emp_id, 
											'emp_name'       	 	=> $v_leave_recoment_list->emp_name, 
											'approved_name'       	=> $v_leave_recoment_list->approved_name, 
											'super_action'     	=> $v_leave_recoment_list->super_action,
											'first_super_action'     => $v_leave_recoment_list->first_super_action,
											'supervisor_type'       => $v_leave_recoment_list->supervisor_type, 
											'hrhd_action'       			=> $v_leave_recoment_list->hrhd_action, 
											'emp_name2'       		=> $v_leave_recoment_list->emp_name2, 
											'application_date'      => $v_leave_recoment_list->application_date 
										); 
				 
				}   
			}else{
				$data['leave_recoment_list'][] = array(  
											'id'       	 			=> $v_leave_recoment_list->application_id, 
											'emp_id'       	 		=> $v_leave_recoment_list->emp_id, 
											'emp_name'       	 	=> $v_leave_recoment_list->emp_name, 
											'approved_name'       	=> $v_leave_recoment_list->approved_name, 
											'emp_name2'       		=> $v_leave_recoment_list->emp_name2,
											'supervisor_type'       => $v_leave_recoment_list->supervisor_type,
											'hrhd_action'       			=> $v_leave_recoment_list->hrhd_action, 
											'super_action'     	=> $v_leave_recoment_list->super_action,
											'first_super_action'     => $v_leave_recoment_list->first_super_action, 
											'application_date'      => $v_leave_recoment_list->application_date 
										); 
			}
		}
		return $data; 
    }
    public function recommendedit($id,$emp_id)
    {
		$datahis = array();
		$datahis['method_control'] ="<input type='hidden' name='_method' value='PUT' />"; 
		$datahis['leave_type'] 	= DB::table('tbl_leave_type')->get();
		$datahis['emp_id'] 	= $emp_id;
		$datahis['supervisor_id'] =Session::get('emp_id');  /// this ID come from session 
		$emp_leave_his = DB::table('leave_application') 
					  ->where('application_id',$id)  
                      ->first(); 
		$super_his = DB::table('supervisor_mapping_ho') 
					  ->where('supervisor_id',$datahis['supervisor_id'])  
					  ->where('emp_id',$emp_id)  
                      ->first(); 
		$datahis['supervisor_type'] 	 = $super_his->supervisor_type;
		
		$datahis['emp_cv_photo']=DB::table('tbl_emp_photo')
										->where('emp_id',$emp_id)
										->first();
		
		 
		$current_date = date('Y-m-d');
		if($emp_id < 100000){
			$max_sarok = DB::table('tbl_master_tra as m')
									->where('m.emp_id', '=', $emp_id)
									->where('m.br_join_date', '=', function($query) use ($emp_id,$current_date)
											{
												$query->select(DB::raw('max(br_join_date)'))
													  ->from('tbl_master_tra')
													  ->where('emp_id',$emp_id)
													  ->where('br_join_date', '<=', $current_date);
											})
									->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
									->groupBy('emp_id')
									->first();	
				 
					
			$datahis['emp_info']  = DB::table('tbl_master_tra as m') 
									->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id') 
									->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
									->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->select('emp.emp_id','emp.emp_name_eng as emp_name','emp.org_join_date','b.br_code','d.designation_name','d.designation_code','b.branch_name')
									->first();   
			$emp_type = 1; 
		}else{
			$datahis['emp_info']  = DB::table('tbl_emp_non_id as nid')  
										  ->leftjoin('tbl_nonid_official_info as oinf',function($join) use ($current_date){
												$join->on("nid.emp_id","=","oinf.emp_id")
												->where('oinf.sarok_no',DB::raw("(SELECT 
																				  max(tbl_nonid_official_info.sarok_no)
																				  FROM tbl_nonid_official_info 
																				   where nid.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
																				  max(t.joining_date)
																				  FROM tbl_nonid_official_info as t 
																				   where nid.emp_id = t.emp_id AND t.joining_date <=  '$current_date')
																				  )") 		 
															); 
														})	 
										 ->leftJoin('tbl_designation as d', 'oinf.designation_code', '=', 'd.designation_code') 
										 ->leftJoin('tbl_branch as b', 'oinf.br_code', '=', 'b.br_code') 
										 ->where('nid.emp_id',$emp_id)  
										 //->where('nid.emp_type_code',$emp_type)  
										 ->select('nid.sacmo_id as emp_id','nid.emp_name','nid.joining_date as org_join_date','b.br_code','d.designation_code','b.branch_name','d.designation_name','nid.emp_type_code as emp_type')
										 ->first(); 
				$emp_id = 	$datahis['emp_info']->emp_id;					 
				$emp_type = 	$datahis['emp_info']->emp_type;					 
		}
		
		
		$datahis['fiscal_year'] = DB::table('tbl_financial_year') 
									->where('running_status',1) 
									->first(); 
		 
		$f_year_id = $datahis['fiscal_year']->id;
		$datahis['emp_leave_balance'] = DB::table('tbl_leave_balance') 
										->where('f_year_id',$f_year_id) 
										->where('emp_type',$emp_type) 
										->where('emp_id',$emp_id) 
										->first(); 
		
		  /* echo '<pre>';
		print_r( $datahis['fiscal_year']);
		exit;  */ 
		
		
		$datahis['id'] 					= $id;  
		$datahis['action']				= "approved_by_sup/$id"; 
        $datahis['application_date'] 	= $emp_leave_his->application_date; 
        $datahis['application_date'] 	= $emp_leave_his->application_date; 
        $datahis['type_id'] 			= $emp_leave_his->leave_type; 
        $datahis['from_date'] 			= $emp_leave_his->leave_from;
        $datahis['to_date'] 			= $emp_leave_his->leave_to;
		
		$date1=date_create($datahis['from_date']);
		$date2=date_create($datahis['to_date']);
		$diff=date_diff($date1,$date2);
		$datahis['no_of_days'] 			= $diff->format("%a")+1; 
		
		if($datahis['supervisor_type'] == 2){
			$datahis['button'] 				= "Recommend"; 
			$datahis['recommend_type'] 		= 3; 
		}else{
			if($datahis['no_of_days'] < 10){
				$datahis['button'] 				= "Approved"; 
				$datahis['recommend_type'] 		= 2;
			}else {
				$datahis['button'] 				= "Recommend"; 
				$datahis['recommend_type'] 		= 3;
			}
			
		}
		
		
        $datahis['remarks'] 			= $emp_leave_his->remarks;   

		$datahis['fiscal_year'] = DB::table('tbl_financial_year') 
									->where('running_status',1) 
									->first(); 
		 
        $org_join_date 		= $datahis['emp_info']->org_join_date; 
		
		$month = date('m',strtotime($datahis['from_date']));
		$year = date('Y',strtotime($datahis['from_date']));
		if ($month<= 6) { 
				$f_year_start  = ($year-1) ; 
			}else{ 
				$f_year_start  = $year;   
			} 
		$datahis['tot_earn_leave'] 		=  $this->earn_leave($datahis['from_date'],$org_join_date, $f_year_start);
       
		
		return view('admin.leave.emp_recommend_form',$datahis);
    }
	
	public function recommend_leave_view($id,$emp_id)
    {
		$datahis = array();
		$datahis['method_control'] ="<input type='hidden' name='_method' value='PUT' />"; 
		$datahis['leave_type'] 	= DB::table('tbl_leave_type')->get();
		$datahis['emp_id'] 	= $emp_id;
		$datahis['supervisor_id'] =Session::get('emp_id');  /// this ID come from session 
		$emp_leave_his = DB::table('leave_application') 
					  ->where('application_id',$id)  
                      ->first(); 
		$super_his = DB::table('supervisor_mapping_ho') 
					  ->where('supervisor_id',$datahis['supervisor_id'])  
					  ->where('emp_id',$emp_id)  
                      ->first(); 
		$datahis['supervisor_type'] 	 = $super_his->supervisor_type;
		
		$datahis['emp_cv_photo']=DB::table('tbl_emp_photo')
										->where('emp_id',$emp_id)
										->first();
		
		 
		$current_date = date('Y-m-d');
		if($emp_id < 100000){
			$max_sarok = DB::table('tbl_master_tra as m')
									->where('m.emp_id', '=', $emp_id)
									->where('m.br_join_date', '=', function($query) use ($emp_id,$current_date)
											{
												$query->select(DB::raw('max(br_join_date)'))
													  ->from('tbl_master_tra')
													  ->where('emp_id',$emp_id)
													  ->where('br_join_date', '<=', $current_date);
											})
									->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
									->groupBy('emp_id')
									->first();	
				 
					
			$datahis['emp_info']  = DB::table('tbl_master_tra as m') 
									->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id') 
									->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
									->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->select('emp.emp_id','emp.emp_name_eng as emp_name','emp.org_join_date','b.br_code','d.designation_name','d.designation_code','b.branch_name')
									->first();   
			$emp_type = 1; 
		}else{
			$datahis['emp_info']  = DB::table('tbl_emp_non_id as nid')  
										  ->leftjoin('tbl_nonid_official_info as oinf',function($join) use ($current_date){
												$join->on("nid.emp_id","=","oinf.emp_id")
												->where('oinf.sarok_no',DB::raw("(SELECT 
																				  max(tbl_nonid_official_info.sarok_no)
																				  FROM tbl_nonid_official_info 
																				   where nid.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
																				  max(t.joining_date)
																				  FROM tbl_nonid_official_info as t 
																				   where nid.emp_id = t.emp_id AND t.joining_date <=  '$current_date')
																				  )") 		 
															); 
														})	 
										 ->leftJoin('tbl_designation as d', 'oinf.designation_code', '=', 'd.designation_code') 
										 ->leftJoin('tbl_branch as b', 'oinf.br_code', '=', 'b.br_code') 
										 ->where('nid.emp_id',$emp_id)  
										 //->where('nid.emp_type_code',$emp_type)  
										 ->select('nid.sacmo_id as emp_id','nid.emp_name','nid.joining_date as org_join_date','b.br_code','d.designation_code','b.branch_name','d.designation_name','nid.emp_type_code as emp_type')
										 ->first(); 
				$emp_id = 	$datahis['emp_info']->emp_id;					 
				$emp_type = 	$datahis['emp_info']->emp_type;					 
		}
		
		
		$datahis['fiscal_year'] = DB::table('tbl_financial_year') 
									->where('running_status',1) 
									->first(); 
		 
		$f_year_id = $datahis['fiscal_year']->id;
		$datahis['emp_leave_balance'] = DB::table('tbl_leave_balance') 
										->where('f_year_id',$f_year_id) 
										->where('emp_type',$emp_type) 
										->where('emp_id',$emp_id) 
										->first(); 
		
		  /* echo '<pre>';
		print_r( $datahis['fiscal_year']);
		exit;  */ 
		
		
		$datahis['id'] 					= $id;  
		$datahis['action']				= "approved_by_sup/$id"; 
        $datahis['application_date'] 	= $emp_leave_his->application_date; 
        $datahis['application_date'] 	= $emp_leave_his->application_date; 
        $datahis['type_id'] 			= $emp_leave_his->leave_type; 
        $datahis['from_date'] 			= $emp_leave_his->leave_from;
        $datahis['to_date'] 			= $emp_leave_his->leave_to;
		
		$date1=date_create($datahis['from_date']);
		$date2=date_create($datahis['to_date']);
		$diff=date_diff($date1,$date2);
		$datahis['no_of_days'] 			= $diff->format("%a")+1; 
		
		if($datahis['supervisor_type'] == 2){
			$datahis['button'] 				= "Recommend"; 
			$datahis['recommend_type'] 		= 3; 
		}else{
			if($datahis['no_of_days'] < 10){
				$datahis['button'] 				= "Approved"; 
				$datahis['recommend_type'] 		= 2;
			}else {
				$datahis['button'] 				= "Recommend"; 
				$datahis['recommend_type'] 		= 3;
			}
			
		}
		
		
        $datahis['remarks'] 			= $emp_leave_his->remarks;   

		$datahis['fiscal_year'] = DB::table('tbl_financial_year') 
									->where('running_status',1) 
									->first(); 
		 
        $org_join_date 		= $datahis['emp_info']->org_join_date; 
		
		$month = date('m',strtotime($datahis['from_date']));
		$year = date('Y',strtotime($datahis['from_date']));
		if ($month<= 6) { 
				$f_year_start  = ($year-1) ; 
			}else{ 
				$f_year_start  = $year;   
			} 
		$datahis['tot_earn_leave'] 		=  $this->earn_leave($datahis['from_date'],$org_join_date, $f_year_start);
       
		
		return view('admin.leave.emp_recommend_form_view',$datahis);
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
				return $tot_earn_leave;
	}
	
    public function approved_by_sup_approve_hrhead($id,$supervisor_type)
    {
		$data1 = array();
		$data2 = array();
		$datahis = array();  
       
		$emp_leave_his = DB::table('leave_application') 
					  ->where('application_id',$id)  
                      ->first();
		$emp_id = $emp_leave_his->emp_id;				
		$leave_from = $emp_leave_his->leave_from;				
		$leave_to = $emp_leave_his->leave_to;				
        $supervisor_id =Session::get('emp_id'); 
		 
		  
		$no_of_days = $this->day_calculation($leave_from,$leave_to);
		
		if($supervisor_type == 2){
			$recommend_type 		= 3; 
		}else{
			if($no_of_days < 10){
				$recommend_type 		= 2;
			}else {
				$recommend_type 		= 3;
			}
			
		}
		
		if($supervisor_type ==2){
			$data2['first_super_action'] = 3;
			$data2['stage'] = 1;
			$data2['first_super_emp_id'] = Session::get('emp_id');
			$data2['first_super_action_date'] = date('Y-m-d'); 
			DB::table('leave_application')
				->where('application_id', $id)
				->update($data2);
		}else if($supervisor_type == 1){
			
			$data1['super_action'] = $recommend_type;
			if( $no_of_days >= 10){
					$data1['hrhd_action']   = 1;
			}  
			$data1['stage'] = 2;	
			$data1['super_emp_id'] = Session::get('emp_id');
			$data1['super_action_date'] = date('Y-m-d');
			DB::table('leave_application')
				->where('application_id', $id)
				->update($data1);
		}   
		 return Redirect::to('/approved_by_sup'); 
    }
	public function update(Request $request, $id)
    {
		$data1 = array();
		$data2 = array();
        $recommend_type = $request->recommend_type;  
        $no_of_days = $request->no_of_days;  
        $supervisor_type = $request->supervisor_type;  
        $data2['tot_earn_leave'] =$data1['tot_earn_leave'] =$request->tot_earn_leave;  
		
		if($supervisor_type ==2){
			$data2['first_super_action'] = 3;
			$data2['stage'] = 1;
			$data2['first_super_emp_id'] = Session::get('emp_id');
			$data2['first_super_action_date'] = date('Y-m-d'); 
			DB::table('leave_application')
				->where('application_id', $id)
				->update($data2);
		}else if($supervisor_type == 1){
			
			$data1['super_action'] = $recommend_type;
			if( $no_of_days >= 10){
					$data1['hrhd_action']   = 1;
			}  
			$data1['stage'] = 2;	
			$data1['super_emp_id'] = Session::get('emp_id');
			$data1['super_action_date'] = date('Y-m-d');
			DB::table('leave_application')
				->where('application_id', $id)
				->update($data1);
		}   
		 return Redirect::to('/approved_by_sup'); 
    }
	public function approved_by_sup_reject($id,$supervisor_type)
    {
		$data1 = array();
		$data2 = array();
		
		if($supervisor_type ==2){
			$data2['first_super_action'] = 4;
			$data2['stage'] = 1;
			$data2['first_super_emp_id'] = Session::get('emp_id');
			$data2['first_super_action_date'] = date('Y-m-d'); 
			DB::table('leave_application')
				->where('application_id', $id)
				->update($data2);
		}else if($supervisor_type == 1){
			$data1['super_action'] = 4;
			$data1['stage'] = 2;
			$data1['hrhd_action']   = '';
			$data1['super_emp_id'] = Session::get('emp_id');
			$data1['super_action_date'] = date('Y-m-d');
			 /* echo "<pre>";
			print_r($data1);
			exit; */
			DB::table('leave_application')
				->where('application_id', $id)
				->update($data1); 
		} 
		
		 return Redirect::to('/approved_by_sup'); 
    } 
	public function day_calculation($from_date,$to_date){
		date_default_timezone_set('Asia/Dhaka');
		$date1=date_create($from_date);
		$date2=date_create($to_date);
		$diff=date_diff($date1,$date2);
		$no_of_days = $diff->format("%a")+1; 
		return $no_of_days;
	}
}
