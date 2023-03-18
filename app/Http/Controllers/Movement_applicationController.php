<?php
namespace App\Http\Controllers;
use App\Mail\VisitApplication;
use App\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Movement;
use Session;
use Illuminate\Support\Facades\Redirect;
use DateTime;
//session_start();

class Movement_applicationController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}	 
	public function index(Request $request)
    {
		
		$action['status'] = true;
		echo json_encode($action);
		
	}
	


    public function store(Request $request)
    {
		$data =array();
		$data1 =array();
		$udata =array();
		$data['application_date'] =date("Y-m-d");  
		$data['visit_reported_to'] = $request->visit_reported_to;  
		$data['created_by'] = Session::get('admin_id'); 
		$data['visit_sub_supervisors_emp_id'] =$request->visit_sub_supervisors_emp_id; 
		$id = $request->move_id;
		if($id == '')
		{  
			if(!empty($data['visit_sub_supervisors_emp_id'])){
				$data['stage'] = 0;
			}else{
				$data['stage'] = 1;
			}
			$data['emp_id'] 				= Session::get('emp_id');  
			$data['visit_type'] 			= $request->visit_type; 
			if($data['visit_type'] == 1){
				$data['destination_code'] 	= implode(",", $request->destination_code);
			}else{
				$data['destination_code'] 	= $request->loc_destination;
			}
			$data['purpose'] 				= $request->purpose; 
			$data['is_need_vehicle_sup'] 	= $request->is_need_vehicle_sup; 
			$data['leave_time'] 			= $request->leave_time; 
			$data['from_date'] 				= $request->from_date; 
			$data['to_date'] 				= $request->to_date; 
			$data['arrival_date'] 			= $request->to_date; 
			$data['arrival_time'] 			= $request->arrival_time; 
			$data['return_time'] 			= $request->arrival_time; 
			$datetime1       = new DateTime($request->from_date);
			$datetime2 		 = new DateTime($request->to_date);
			$interval 		 = $datetime1->diff($datetime2);
			$tot_day 		 =  $interval->format('%R%a');
			$data['tot_day'] =  $tot_day + 1;
			$data['status'] 				=0; 
			/* $db_id = 0;
			$action1 = $this->visit_check_date($data['emp_id'],$data['from_date'],$data['to_date'],$db_id,$data['leave_time']);
			if($action1 == 1){ */
			
			if($data['emp_id'] == 4188){
				
				
				$data['stage'] = 2;
				$data['super_action'] 				= 1;
				$data['super_emp_id'] 				= 0;
				$data['super_action_date'] 			= $data['application_date'];
			}
				$move_id = Movement::insertGetId($data); 
				$action['status'] = 1;
				
			if($data['emp_id'] != 4188){		
								//Mail
			/* $v_mail_data['move_id'] 					= $move_id;
			$v_mail_data['application_date'] 			= date("Y-m-d");  
			$v_mail_data['emp_name'] 					= $request->input('visit_emp_name');
			$v_mail_data['emp_id'] 						= $request->input('visit_emp_id');
			$v_mail_data['from_date'] 					= $request->input('from_date');
			$v_mail_data['to_date'] 					= $request->input('to_date');
			$v_mail_data['leave_time'] 					= $request->input('leave_time');
			$v_mail_data['arrival_time'] 				= $request->input('arrival_time');
			$visit_type 								= $request->visit_type; 
			if($visit_type == 1)
			{
				$branch_list = DB::table('tbl_branch')  
									->select('br_code','branch_name')
									->get(); 
				$branch_name 		= ''; 
				$destination_code 	= explode(',',$data['destination_code']);
											$i = 1;
											foreach ($branch_list as $branch){
												if (in_array($branch->br_code, $destination_code)){
													if($i == 1){
														$branch_name  .= $branch->branch_name; 
													}else{
														$branch_name  .= ', '.$branch->branch_name;
													}
													$i++;
												}
											}
					$v_mail_data['destination_code']		= $branch_name;
				}else
				{
					$v_mail_data['destination_code'] 		= $request->loc_destination;
				}
				$v_mail_data['purpose'] 					= $request->input('purpose');
				$v_mail_data['supervisor_email'] 			= $request->input('visit_supervisor_email');
				$v_mail_data['supervisors_emp_id'] 			= $request->input('visit_reported_to');
				$v_mail_data['sub_supervisor_email'] 		= $request->input('visit_sub_supervisor_email');
				$v_mail_data['sub_supervisors_emp_id'] 		= $request->input('visit_sub_supervisors_emp_id');
				\Mail::send(new VisitApplication($v_mail_data)); */
				// End Email
			/* }
			else
			{
				$action['status'] = 2; 
			} */
			//
			
			$move_id 					= $move_id;
			$application_date			= date("Y-m-d");  
			$str 						= $request->input('visit_emp_name');
			$emp_name 					= str_replace(' ', '-', $str);
			$emp_id 					= $request->input('visit_emp_id');
			$from_date 					= $request->input('from_date');
			$to_date					= $request->input('to_date');
			$leave_time_str 			= $request->input('leave_time');
			$leave_time_st 				= str_replace("%20"," ",$leave_time_str);
			$leave_time 				= str_replace(' ', '-', $leave_time_st);
			$arrival_time_str 			= $request->input('arrival_time');
			
			$arrival_time_st 			= str_replace("%20"," ",$arrival_time_str);
			$arrival_time 				= str_replace(' ', '-', $arrival_time_st);
			$visit_type 				= $request->visit_type; 
			if($visit_type == 1)
			{
				$branch_list = DB::table('tbl_branch')  
									->select('br_code','branch_name')
									->get(); 
				$branch_name 		= ''; 
				$destination_code 	= explode(',',$data['destination_code']);
											$i = 1;
											foreach ($branch_list as $branch){
												if (in_array($branch->br_code, $destination_code)){
													if($i == 1){
														$branch_name  .= $branch->branch_name; 
													}else{
														$branch_name  .= ', '.$branch->branch_name;
													}
													$i++;
												}
											} 
					$destination_code_mail		= $branch_name;
				}else
				{ 
					$destination_code_mail 		= $request->loc_destination;
				} 
				$destination_code 			= str_replace(' ', '-', $destination_code_mail);
				$purpose_str 				= $request->input('purpose');
				$purpose 					= str_replace(' ', '-', $purpose_str); 
				$supervisor_email 			= $request->input('visit_supervisor_email');
				$supervisors_emp_id 		= $request->input('visit_reported_to');
				
				$sub_supervisor_email		= $request->input('visit_sub_supervisor_email');
				$sub_supervisors_emp_id		= $request->input('visit_sub_supervisors_emp_id'); 
				if(empty($sub_supervisor_email)){
					$sub_supervisor_email 		= 'test@cdipbd.org'; 
					$sub_supervisors_emp_id		= 0;
				}
				$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_check_visit/'.$move_id.'/'.$application_date.'/'.$emp_name.'/'.$emp_id.'/'.$from_date.'/'.$to_date.'/'.$leave_time.'/'.$arrival_time.'/'.$destination_code.'/'.$purpose.'/'.$supervisor_email.'/'.$sub_supervisor_email.'/'.$supervisors_emp_id.'/'.$sub_supervisors_emp_id); 
			}
		}
		else
		{ 
				if(!empty($data['visit_sub_supervisors_emp_id'])){
					$udata['stage'] = 0;
				}else{
					$udata['stage'] = 1;
				} 
				$udata['visit_type'] 				= $request->visit_type; 
				if($udata['visit_type'] == 1){
					$udata['destination_code'] 		= implode(",", $request->destination_code);
				}else{
					$udata['destination_code'] 		= $request->loc_destination;
				}
				
				$udata['purpose'] 				= $request->purpose; 
				$udata['is_need_vehicle_sup'] 	= $request->is_need_vehicle_sup; 
				$udata['leave_time'] 			= $request->leave_time; 
				$udata['from_date'] 				= $request->from_date; 
				$udata['to_date'] 				= $request->to_date; 
				$udata['arrival_date'] 				= $request->to_date; 
				$udata['return_time'] 			= $request->arrival_time;  
				$udata['arrival_time'] 			= $request->arrival_time;
				$udata['updated_by'] = Session::get('admin_id');
				$udata['updated_at'] = date("Y-m-d");
				$datetime1       = new DateTime($request->from_date);
				$datetime2 		 = new DateTime($request->to_date);
				$interval 		 = $datetime1->diff($datetime2);
				$tot_day 		 =  $interval->format('%R%a');
				$udata['tot_day'] =  $tot_day + 1;
				
				$emp_id = Session::get('emp_id');
				$db_id = $id;
				/* $action1 = $this->visit_check_date($emp_id,$udata['from_date'],$udata['to_date'],$db_id,$udata['leave_time']);
				
				if($action1 == 1){ */
							DB::table('tbl_movement_register')
								->where('move_id', $id) 
								->update($udata); 
					$action['status'] = 3;
				/* }else{
					$action['status'] = 2; 
				}  */
								
		} 

     
	 echo json_encode($action); 
	 
	 }
	  public function visit_check_date($emp_id,$from_date,$to_date,$db_id,$leave_time_form,$arrival_time){
			 /// 1=yes, 2= No
			 $from_time = str_replace("%20"," ",$leave_time_form);
			 $return_time = str_replace("%20"," ",$arrival_time);
			 $from_date_time = strtotime($from_date) + strtotime($from_time);
			 $return_date_time = strtotime($to_date) + strtotime($return_time);
			
			$dates = array();
			  $current = strtotime($from_date);
			  $to_date1 = strtotime($to_date);
			  $stepVal = '+1 day';
			  while( $current <= $to_date1 ) {
				 $dates[] = date("Y-m-d", $current);
				 $current = strtotime($stepVal, $current);
				 
				 
			  }  
			  $permission = 1;
			   foreach($dates as $v_dates){
				 
				$date_exist =  DB::table('tbl_movement_register') 
								->where('move_id','!=',$db_id) 
								->where('emp_id', $emp_id) 
								->where('first_super_action','!=',2) 
								->where('super_action','!=',2) 
								->where('arrival_date', '>=', $v_dates) 
								->where('from_date', '<=', $v_dates) 
								->select('move_id','from_date','leave_time','arrival_date','return_time') 
								->first(); 
			   if($date_exist){
				  $db_from_date_time 	= strtotime($date_exist->from_date) + strtotime($date_exist->leave_time);
				  $db_return_date_time 	= strtotime($date_exist->arrival_date) + strtotime($date_exist->return_time);
				  $db_arrival_date 	= $date_exist->arrival_date;
				  
				  
				  if(( $db_from_date_time <=  $from_date_time ) && ($from_date_time <=  $db_return_date_time ) ){
					  $permission  = 2;
					  break;
				  }else if(( $db_from_date_time <=  $return_date_time ) && ($return_date_time <=  $db_return_date_time )){
					   $permission  = 2;
					  break;
				  }   
			  } 
			  /* if($date_exist){
				  $db_from_date 	= $date_exist->from_date;
				  $db_arrival_date 	= $date_exist->arrival_date;
				   if($db_from_date == $db_arrival_date){
					  if($from_date == $to_date){
							$leave_time = strtotime($date_exist->leave_time); 
							$return_time = strtotime($date_exist->return_time); 
							$leave_time_form = strtotime($leave_time_form);  
							if(( $leave_time <=  $leave_time_form ) && ($leave_time_form <  $return_time ) ){
								$permission  = 2;
							}else{
								$permission  = 1;
							}
						}else{
							$permission  = 2;
						}
					}else{
						$permission  = 2;
					} 
			  } */
			}  
		    return 	$permission;		
	} 
	public function get_move_info($id)
	{
		$data =array();
		$info = DB::table('tbl_movement_register as app')
							->leftJoin('tbl_emp_basic_info as basic_sub', 'app.visit_sub_supervisors_emp_id', '=', 'basic_sub.emp_id')
							->leftJoin('tbl_emp_basic_info as basic', 'app.visit_reported_to', '=', 'basic.emp_id')
							->leftJoin('tbl_move_vehicle_assign as va', 'app.move_id', '=', 'va.move_id')
							->leftJoin('microfineye_vehicle.tbl_vehicle as v', 'v.id', '=', 'va.vehicle_id')
							->leftJoin('microfineye_vehicle.tbl_driver as d', 'd.id', '=', 'va.driver_id')
							->where('app.move_id', '=', $id)
							->select('app.*', 'basic.emp_name_eng as supervisor_name', 'basic_sub.emp_name_eng as sub_supervisor_name','v.model_no','d.name','va.dri_mobile')
							->first(); 
	 
		 $ref_move_id = $info->ref_move_id;
		$data['move_id'] 				=$move_id = $info->move_id;
		$data['emp_id'] 				= $info->emp_id;		
		$data['application_date'] 		= $info->application_date;		
		$data['from_date'] 				= $info->from_date;		
		$data['leave_time'] 			= $info->leave_time;		
		$data['arrival_time'] 			= $info->arrival_time;	 
		$data['to_date'] 				= $info->to_date;	
		$data['arrival_date'] 			= $info->arrival_date;	 
		$data['return_time'] 			= $info->return_time;	 
		$data['is_reopen'] 				= $info->is_reopen;	 
		$data['visit_type'] 			= $info->visit_type;
		$data['vehicle_id'] 			= $info->model_no;
		$data['driver_id'] 			= $info->name;
		$data['dri_mobile'] 			= $info->dri_mobile;
		
		if($data['visit_type'] == 1){
			$data['destination_code'] 		= explode(",", $info->destination_code);
		}else{
			$data['destination_code'] 		= $info->destination_code;
		}
	 
		$data['purpose'] 					= $info->purpose;		
		$data['is_need_vehicle_sup'] 		= $info->is_need_vehicle_sup;		
		$data['first_super_emp_id'] 		= $info->first_super_emp_id;		
		$data['first_super_action_date'] 	= $info->first_super_action_date;				
		$data['first_super_action'] 		= $info->first_super_action;
		$data['first_super_remarks'] 		= $info->first_super_remarks;		
		$data['super_emp_id'] 				= $info->super_emp_id;		
		$data['super_action_date'] 			= $info->super_action_date;		
		$data['super_action'] 				= $info->super_action;		
		$data['super_remarks'] 				= $info->super_remarks;		
		$data['achd_emp_id'] 				= $info->achd_emp_id;		
		$data['achd_action_date'] 			= $info->achd_action_date;		
		$data['achd_action'] 				= $info->achd_action;		
		$data['achd_remarks'] 				= $info->achd_remarks;		
		$data['executor_emp_id'] 			= $info->executor_emp_id;		
		$data['executor_action_date'] 		= $info->executor_action_date;		
		$data['executor_action'] 			= $info->executor_action;		
		$data['executor_remarks'] 			= $info->executor_remarks;	
		$data['sub_supervisor_name'] 		= $info->sub_supervisor_name;
		$data['supervisor_name'] 			= $info->supervisor_name;
		$data['visit_sub_supervisors_emp_id'] 			= $info->visit_sub_supervisors_emp_id;
		$data['visit_reported_to'] 				= $info->visit_reported_to;
		return $data;
	}	
	 
	public function movement_close($id)
	{
		$data =array();
		$info = DB::table('tbl_movement_register')	            
							->where('move_id', '=', $id )
							->first(); 
		$data['leave_time'] 			= $info->leave_time; 
		$data['arrival_time'] 			= $info->arrival_time;
		$data['move_id'] 				= $info->move_id;
		$data['emp_id'] 				= $info->emp_id;		
		$data['application_date'] 		= $info->application_date;		
		$data['from_date'] 				= $info->from_date;		
		$data['to_date'] 				= $info->to_date;		
		$data['arrival_date'] 			= $info->arrival_date;		
		$data['return_time'] 			= $info->return_time;		
		$data['is_reopen'] 			= $info->is_reopen;	
		$data['visit_type'] 			= $info->visit_type;	
		
		if($data['visit_type'] == 1){
			$data['destination_code'] 		= explode(',',$info->destination_code);
		}else{
			$data['destination_code'] 		=  $info->destination_code;
		}
		
		$data['purpose'] 					= $info->purpose; 
		$data['is_need_vehicle_sup'] 		= $info->is_need_vehicle_sup; 
		
	
		
		return $data;
	}	
	public function save_visit_close(Request $request)
    {
		$data = array(); 
		$udata = array(); 
		$udata1 = array(); 
		//$tot_day 		 =  0;
		$to_date 				= $request->c_to_date; 
		$from_date 				= $request->c_from_date; 
		$udata['arrival_date'] 	= $request->return_date;
		$pre_return_date 	= $request->pre_return_date;
		$pre_return_time 	= $request->pre_return_time;
		$move_id 				= $request->c_move_id;  
		 $datetime1       = new DateTime($from_date);
		 $datetime2 		 = new DateTime($udata['arrival_date']);
		 $interval 		 = $datetime1->diff($datetime2);
		 $tot_day 		 =  $interval->format('%R%a');
		  
		 //echo  $tot_day;
		// exit;
		 $udata['tot_day'] =   $udata1['tot_day'] =  $tot_day + 1;
		 //return $udata['tot_day'];
		 $visit_type 								= $request->c_visit_type; 
		if($visit_type == 1){
			$udata['destination_code'] =  $udata1['destination_code'] 	= implode(",", $request->c_destination_code);
		}else{
			$udata['destination_code'] = $udata1['destination_code'] 	= $request->c_loc_destination;
		}   
		 if(strtotime($udata['arrival_date'])> strtotime($pre_return_date)){
			 
			 
				
			 $udata1['is_reopen'] 						= 1; 
			  
			 $udata1['arrival_date'] 					    	= $udata['arrival_date']; 
			 
			$udata1['return_time'] 						= $request->return_time;  
			
			
			$visit_sub_supervisors_emp_id 		= $request->visit_sub_supervisors_emp_id_c; 
			$udata1['purpose'] 							= $request->c_purpose;
			if(!empty($visit_sub_supervisors_emp_id)){
				$udata1['stage'] = 0;
			}else{
				$udata1['stage'] = 1;
			} 
			$udata1['super_action'] = 0; 
			$udata1['first_super_action'] = 0;
			$emp_id = $request->c_emp_id;
			if($emp_id == 4188){
				$udata1['stage'] = 2;
				$udata1['super_action'] 				= 1;
				$udata1['super_emp_id'] 				= 0;
				$udata1['super_action_date'] 			= date("Y-m-d");
			}
			
			$action['status'] = DB::table('tbl_movement_register')
								->where('move_id', $move_id)
								->update($udata1);	
			if($emp_id != 4188){
			//Mail
			$move_id 					= $move_id;
			$application_date			= date("Y-m-d");  
			$str 						= $request->c_visit_emp_name;
			$emp_name 					= str_replace(' ', '-', $str);
			$emp_id 					= $request->c_emp_id;
			$from_date 					= $from_date;
			$to_date					= $udata['arrival_date'];
			$leave_time_str 			= $request->c_leave_time;
			$leave_time_st 				= str_replace("%20"," ",$leave_time_str);
			$leave_time 				= str_replace(' ', '-', $leave_time_st);
			$arrival_time_str 			= $udata1['return_time']; 
			
			$arrival_time_st 			= str_replace("%20"," ",$arrival_time_str);
			$arrival_time 				= str_replace(' ', '-', $arrival_time_st);
			 
			if($visit_type == 1)
			{
				$branch_list = DB::table('tbl_branch')  
									->select('br_code','branch_name')
									->get(); 
				$branch_name 		= ''; 
				$destination_code 	= explode(',',$data['destination_code']);
											$i = 1;
											foreach ($branch_list as $branch){
												if (in_array($branch->br_code, $destination_code)){
													if($i == 1){
														$branch_name  .= $branch->branch_name; 
													}else{
														$branch_name  .= ', '.$branch->branch_name;
													}
													$i++;
												}
											} 
					$destination_code_mail		= $branch_name;
				}else
				{ 
					$destination_code_mail 		= $udata1['destination_code'];
				} 
				$destination_code 			= str_replace(' ', '-', $destination_code_mail);
				$purpose_str 				= $udata1['purpose'];
				$purpose 					= str_replace(' ', '-', $purpose_str); 
				$supervisor_email 			= $request->visit_supervisor_email_c;
				$supervisors_emp_id 		= $request->visit_reported_to;
				
				$sub_supervisor_email		= $request->visit_sub_supervisor_email_c;
				$sub_supervisors_emp_id		= $request->visit_sub_supervisors_emp_id_c;
				if(empty($sub_supervisor_email)){
					$sub_supervisor_email 		= 'test@cdipbd.org'; 
					$sub_supervisors_emp_id		= 0;
				}
				$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_check_visit/'.$move_id.'/'.$application_date.'/'.$emp_name.'/'.$emp_id.'/'.$from_date.'/'.$to_date.'/'.$leave_time.'/'.$arrival_time.'/'.$destination_code.'/'.$purpose.'/'.$supervisor_email.'/'.$sub_supervisor_email.'/'.$supervisors_emp_id.'/'.$sub_supervisors_emp_id);
			
			}
								
		}else{
			
			
			
			 $udata['is_close'] 	= 2;  
			$udata['return_time'] 	= $request->return_time; 
			$action['status'] = DB::table('tbl_movement_register')
								->where('move_id', $move_id)
								->update($udata);
		}
		
		   
		   
		 
		 return $data; 
    } 
	public function get_movement_info($id)
	{
		$data =array();
		$data['destination_code']  =array();
		$info = DB::table('tbl_movement_register')	            
							->where('move_id', '=', $id )
							->first();
		$data['move_id'] 				= $info->move_id;
		$data['emp_id'] 				= $info->emp_id;
		$data['visit_type'] 			= $info->visit_type;	
		if($data['visit_type'] == 1){
			$data['destination_code'] 		= explode(',',$info->destination_code);
		}else{
			$data['destination_code'] 		=  $info->destination_code;
		}
		/* echo "<pre>";
		print_r($destination_code);
		exit; */
		
		 		
		$data['application_date'] 		= $info->application_date;		
		$data['from_date'] 				= $info->from_date;		
		$data['to_date'] 				= $info->to_date;		
		$data['arrival_time'] 			= $info->arrival_time;		
		$data['leave_time'] 			= $info->leave_time;		
			
		$data['purpose'] 				= $info->purpose;	
		$data['is_need_vehicle_sup'] 	= $info->is_need_vehicle_sup;	
		 			
		return $data;
	}
	
	public function delete_move_application($id,$ref_move_id)
    {
		$udata =array();
		$udata['is_reopen'] = 0; 
		if($ref_move_id != 0){
			$delete_info = DB::table('tbl_movement_register')	            
							->where('move_id', '=', $ref_move_id )
							->first();
			if($delete_info){
							DB::table('tbl_movement_register')
								->where('move_id', $ref_move_id)
								->update($udata);
			}
		}
		
		$data['del_status'] =  DB::table('tbl_movement_register')->where('move_id', '=', $id)->delete();
		
        echo json_encode($data);
    }
   public function all_movement_application(Request $request)
    {   
		
		$data['destination_code'] 		= array();
		$emp_id 	= Session::get('emp_id');	
		$columns = array( 
			0 =>'move_id', 
			1 =>'application_date',
			2 =>'destination',
			3 =>'from_date',
			4 => 'to_date',
			5 => 'tot_day',
			6 => 'purpose',
			7 => 'stage',
			8 => 'Options', 
			9 => 'stage',
		);
        $totalData 		= Movement::where('emp_id',$emp_id)->count();
        $totalFiltered 	= $totalData; 
        $limit 			= $request->input('length');
        $start 			= $request->input('start');
        $order 			= $columns[$request->input('order.0.column')];
        $dir 			= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Movement::offset($start) 
							->where('emp_id',$emp_id)
							->limit($limit)
							//->orderBy('move_id', $dir)
							->orderBy('move_id', 'DESC')
							->get();
        }
        else 
		{
            $search = $request->input('search.value'); 
            $infos =  Movement::where('emp_id', $emp_id)
							->where(function ($q) use ($search) {
								$q->where('application_date', 'LIKE', "%{$search}%") 
									->orWhere('comments', 'LIKE', "%{$search}%")
									->orWhere('from_date', 'LIKE', "%{$search}%")
									->orWhere('to_date', 'LIKE', "%{$search}%");
							})
							//->where('application_date',$search)
                            ->offset($start)
                            ->limit($limit)							
                            //->orderBy('move_id', $dir)
							->orderBy('move_id', 'DESC')
                            ->get();
            $totalFiltered = Movement::where('emp_id', $emp_id)
							->where(function ($q) use ($search) {
								$q->where('application_date', 'LIKE', "%{$search}%") 
									->orWhere('comments', 'LIKE', "%{$search}%") 
									->orWhere('from_date', 'LIKE', "%{$search}%")
									->orWhere('to_date', 'LIKE', "%{$search}%");
							})
							->count();
        }
       $data = array();
        if(!empty($infos))
        {
            $i = 1;
			$status_flag = 0; 
            foreach ($infos as $info)
            {
				$nestedData['sl'] 						= $i++;
                $nestedData['application_date'] 		= date("d-m-Y",strtotime($info->application_date));
                $visit_type 		= $info->visit_type;
				if($visit_type == 1){ 
					$destination_code = explode(',',$info->destination_code);
					 $branch_info = DB::table('tbl_branch') 
									->where(function ($query) use($visit_type,$destination_code) {
										if($visit_type == 1){
											$query->whereIn('br_code', $destination_code);
										} 	 	 
									})  
									->select('br_code','branch_name')
									->get();  
					
					 if(!empty($branch_info)){
						 $destination = '';
						foreach($branch_info as $branch_info_v){
							$destination 	= $destination . ' | ' . $branch_info_v->branch_name . ' | ';
						}
					}else{
						$destination 	= '&nbsp;';
					} 
					$nestedData['destination'] 				= $destination;
				}else{
					$nestedData['destination'] 				= $info->destination_code;
				}  				
                $nestedData['from_date'] 				= date("d-m-Y",strtotime($info->from_date));
                $nestedData['to_date']					= date("d-m-Y",strtotime($info->to_date));                              
                $nestedData['purpose']					= $info->purpose;
                $nestedData['tot_day']					= $info->tot_day;
				
				
				
				if($info->stage == 0) { 
					$status = 'Pending..';
					$class = 'label label-default';
					
					
					
					
					if($info->is_reopen == 1){
						$action = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';	
					}else{
						$action = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';	
					/* 	$action = '<button class="btn btn-sm btn-primary btn-xs"  title="Edit" onclick="get_movement_info('.$info->move_id.')"><i class="fa fa-pencil" aria-hidden="true"></i></button>
													       <button class="btn btn-sm btn-danger btn-xs"  title="Delete" onclick="delete_move_application('.$info->move_id.','.$info->ref_move_id.')"><i class="fa fa-times" aria-hidden="true"></i></button>';	 */
					}
					
					
				}
				else if ($info->stage == 1 && $info->first_super_action == 1) {
					$status = 'Recomended for Visit'; 
					$class = 'label label-info';
					$action = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';
				}
				else if ($info->stage == 1 && $info->first_super_action == 2) {
					$status = 'Rejected by Sub Supervisor';
					$class = 'label label-warning';
					$action = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';
				}
				else if ($info->stage == 1 && $info->first_super_action == 0) {
					$status = 'Pending..';
					$class = 'label label-default';
					
					if($info->is_reopen == 1){
						$action = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';
					}else{
						$action = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';
						
						/* $action = '<button class="btn btn-sm btn-primary btn-xs"  title="Edit" onclick="get_movement_info('.$info->move_id.')"><i class="fa fa-pencil" aria-hidden="true"></i></button>
													       <button class="btn btn-sm btn-danger btn-xs"  title="Delete" onclick="delete_move_application('.$info->move_id.','.$info->ref_move_id.')"><i class="fa fa-times" aria-hidden="true"></i></button>'; */
					}
					
				}
				elseif ($info->stage == 2 && $info->super_action == 1) {
					$status = 'Approved';
					$class = 'label label-success';
					$action = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';
				} 
				elseif ($info->stage == 2 && $info->super_action == 2) {
					$status = 'Rejected by supervisor';
					$class = 'label label-danger';
					$action = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';
				} 
				elseif ($info->stage == 3) {
					$status = 'Execute by Accounts';
					$class = 'label label-success';
					$action = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';
				}  
                $nestedData['status']					= '<span class="'.$class.'">'.$status.'<span>';  
				
				if($status == 'Approved'){
					  
						if($info->is_close == 2){
							if($info->is_create_bill == 2){ 
								$button ='<button class="btn btn-sm btn-success btn-xs"  title="view Voucher" onclick="add_voucher('.$info->move_id.','.$info->visit_type.')"> Bill Voucher</button>';
							}else{
								$button =	'<a class="btn btn-sm btn-primary btn-xs" title="Create bill" href="movement_bill_create/'.$info->move_id.'"> Create Bill</a>';
							}
						
						}else{ 
								$button ='<button class="btn btn-sm btn-warning btn-xs"  title="visit close" onclick="movement_close('.$info->move_id.')">Visit Close</button>'; 	
						} 
					$nestedData['view'] = '<button class="btn btn-sm btn-info btn-xs"  title="View" onclick="view_move_info('.$info->move_id.')">View</button>&nbsp;&nbsp;&nbsp;'.$button;
				}else{
					$nestedData['view'] = '<button class="btn btn-sm btn-info btn-xs"  title="View" onclick="view_move_info('.$info->move_id.')">View</button>';
				}  

				$nestedData['options'] 		= $action;			
				
				$data[] = $nestedData;
            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );          
        echo json_encode($json_data);       
    }
	
	
	public function visit_detail_info($emp_id)
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
		   
			$data['all_visit_info']  = DB::table('tbl_movement_register')
									->where('super_action', 1)
									->where('emp_id', $emp_id)
									->select('*')
									->get();
			$data['branch_list'] = DB::table('tbl_branch') 
									->orderby('branch_name','asc')
									->select('br_code','branch_name')
									->get();
		
		/* echo "<pre>";
		print_r($data['branch_list']);	
		exit;	 */ 
		return   view('admin.movement_register.movement_details_report',$data);
    }
	/// EID Leave Execution
	public function eid_leave_execute()
    {
		$data = array();
		$data['from_date'] 		= "2021-07-25";
		$data['to_date'] 		= "2021-07-26";
		$data['date_within'] 	= "2021-07-20";
		$data['branches'] = DB::table('tbl_branch')->where('status', '=',1)->where('eid_leave_status', '=', 0)->orderBy('branch_name', 'ASC')->get();
		  
		return view('admin.leave.eid_leave_execution_form',$data);
    }
	public function insert_eid_leave_execute(Request $request)
    {
		$data = array(); 
		$udata = array(); 
		$udata1 = array();
		$data['branches'] = DB::table('tbl_branch')->where('status', '=',1)->where('eid_leave_status', '=', 0)->orderBy('branch_name', 'ASC')->get();
		$data['date_within'] 	= $date_within = $request->input('date_within');
		$from_date = $request->input('from_date');
		$to_date = $request->input('to_date');
		$no_of_days = $request->input('no_of_days');
		$leave_for = $request->input('leave_for');
		$type_id = $request->input('type_id');
		$br_code = $request->input('br_code');
		
		//$br_code = 9999;
		$status = 1; //// running and cancel 2 tar jonno execute hobe ai kaj ta korte hobe leave execute korar age////
		$action = 0;
		
		
		$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.salary_br_code', '=', $br_code)
						->where('m.br_join_date', '<=', $date_within)
						->where(function($query) use ($status, $date_within) {
								if($status !=2) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $date_within);
								} else {
									$query->Where('r.effect_date', '<=', $date_within);
								}
							})
						
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get()->toArray();
		//print_r($all_result);
		////////////////   emp assign data thakle history table e data insert hay na ata tik korte hobe //////
		$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										->where('eas.salary_br_code', '=', $br_code)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($status, $date_within) {
											if($status !=2) {
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $date_within);
											} else {
												$query->Where('r.effect_date', '<=', $date_within);
											}
										})									
										->select('eas.emp_id')
										->get()->toArray();
		//print_r ($assign_branch);
		//$all_result1 = array_merge($all_result,$assign_branch);
		$all_result1 = array_unique(array_merge($all_result,$assign_branch), SORT_REGULAR);
		
		
		if (!empty($all_result1)) {
			foreach ($all_result1 as $result) {
				 
			 
				$emp_id = $result->emp_id;
				$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $result->emp_id)
						 ->where('m.br_join_date', '=', function($query) use ($emp_id,$date_within)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $date_within);
								}) 
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('m.emp_id')
						->first();
				//print_r ($max_sarok);
				$data_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'm.salary_br_code', '=', 'b.br_code')
							->leftJoin('tbl_emp_assign as ea', function($join){
											$join->where('ea.status',1)
												->on('m.emp_id', '=', 'ea.emp_id');
										})
							->where('m.sarok_no', '=', $max_sarok->sarok_no)
							->select('m.salary_br_code','m.br_code','m.designation_code','e.emp_name_eng')
							->first();
				//print_r ($data_result);
				//// employee assign ////
				$assign_designation = DB::table('tbl_emp_assign as ea')
											->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
											->where('ea.emp_id', $result->emp_id)
											->where('ea.status', '!=', 0)
											->where('ea.select_type', '=', 5)
											->select('ea.designation_code')
											->first();
				if(!empty($assign_designation)) {
					$designation_code = $assign_designation->designation_code; 
				} else {
					$designation_code = $data_result->designation_code; 
				}
				$assign_branch = DB::table('tbl_emp_assign as ea')
											->leftJoin('tbl_branch as br', 'ea.salary_br_code', '=', 'br.br_code')
											->where('ea.emp_id', $result->emp_id)
											->where('ea.open_date', '<=', $date_within)
											->where('ea.status', '!=', 0)
											->where('ea.select_type', '=', 2)
											->select('ea.salary_br_code','ea.br_code')
											->first();
				if(!empty($assign_branch)) {
					$result_br_code = $assign_branch->salary_br_code; 
					$ori_br_code = $assign_branch->br_code; 
				} else {
					$result_br_code = $data_result->salary_br_code; 
					$ori_br_code = $data_result->br_code; 
				}
				////////				
				if ($result_br_code == $br_code) {
						
					$data['all_result'][] = array(
						'emp_id' => $result->emp_id,
						'emp_name'      => $data_result->emp_name_eng,
						'br_code'      => $ori_br_code,
						'designation_code'      => $designation_code
					);
				}				
			}  
		}
		if(!empty($data['all_result'])){ 
		
			foreach($data['all_result'] as $v_all_result){
										$emp_leave_balance = DB::table('tbl_leave_balance') 
															->where('emp_id',$v_all_result['emp_id'])   
															->where('f_year_id',5)  
															->first(); 
										 
										if($emp_leave_balance){
											
										
										$max_serial_no 		= DB::table('tbl_leave_history') 
																->where('for_which',1) 
																->where('f_year_id',5) 
																->max('serial_no'); 
				
										$datahis = array(); 
										$datahis['emp_id'] 				= $v_all_result['emp_id'];  
										$datahis['serial_no'] 			= $max_serial_no + 1 ; 
										$datahis['f_year_id'] 			= 5; 
										$datahis['designation_code']	= $v_all_result['designation_code']; 
										$datahis['branch_code']			= $v_all_result['br_code']; 
										$datahis['type_id']				= $type_id; 
										$datahis['is_pay']				= 1; 
										$datahis['application_date']	= $date_within; 
										$datahis['from_date']			= $from_date; 
										$datahis['to_date']				= $to_date; 
										$datahis['no_of_days']			= $no_of_days;  
										$datahis['leave_dates']			= '2021-07-25,2021-07-26';   
										$datahis['leave_remain']		= 0; 
										if($leave_for == 1){
											$datahis['remarks']				= "Vacation For Eid Ul Fitr"; 
										}else{
											$datahis['remarks']				= "Vacation For Eid Ul Adha"; 
										}	
										 
										$datahis['approved_id'] 	 	= 4188;   
										$datahis['appr_desig_code'] 	= 1;  
										$datahis['sup_status']			= 1;  
										$datahis['appr_status']			= 1;  
										$datahis['appr_from_date']		=  $from_date;  
										$datahis['sup_recom_date']		=  $from_date;  
										$datahis['appr_to_date']		=  $to_date;  
										$datahis['appr_appr_date']		=  $to_date;  
										$datahis['apply_for']			=  1;  
										$datahis['no_of_days_appr']		=  $no_of_days;  
										$datahis['tot_earn_leave']		=  0;  
										$datahis['leave_adjust']		=  1;
										$datahis['is_eid_execution']	=  1;
										$datahis['user_code'] 			= Session::get('admin_id');
										
										   DB::table('tbl_leave_history')
												->insert($datahis); 
										/*  echo "<pre>";
											print_r($datahis); */
										 
										$udata['current_close_balance'] 	= $emp_leave_balance->current_close_balance - $no_of_days;
										$udata['no_of_days'] 	= $emp_leave_balance->no_of_days + $no_of_days;
										//print_r($udata);
										
											 DB::table('tbl_leave_balance')  
												->where('emp_id', $v_all_result['emp_id'])
												->where('f_year_id', 5)
												->update($udata); 
									}
			}
										$udata1['eid_leave_status'] = 1;
								$action	=		DB::table('tbl_branch') 
													->where('br_code', $br_code) 
													->update($udata1); 
		}
		
		
		
		/*  echo "<pre>";
		print_r($data['all_result']);
		exit; */ 
        echo json_encode($action);
		 
    } 

  public function test_mail(){ 
	 			          
				$move_id 					= 1;
				
				$application_date			= date("Y-m-d");  
				 
				$emp_name 					= 'dd';
				$emp_id 					= 2999;
				$from_date 					= date("Y-m-d");
				$to_date					= date("Y-m-d");
				 
				$leave_time 				= "1"; 
				$arrival_time 				= "1";
				 
				$destination_code 			= 'test,hhh,ggg';
				 
				$purpose 					= '25';
				$supervisor_email 			= 'saidul@cdipbd.org';
				$supervisors_emp_id 		= 2999;
				$sub_supervisor_email 		= 'test@cdipbd.org'; 
				$sub_supervisors_emp_id		= 2999;  
				
				 
			$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_check_visit/'.$move_id.'/'.$application_date.'/'.$emp_name.'/'.$emp_id.'/'.$from_date.'/'.$to_date.'/'.$leave_time.'/'.$arrival_time.'/'.$destination_code.'/'.$purpose.'/'.$supervisor_email.'/'.$sub_supervisor_email.'/'.$supervisors_emp_id.'/'.$sub_supervisors_emp_id);
			echo $file;
 } 
	
}
