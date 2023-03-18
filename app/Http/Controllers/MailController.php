<?php
namespace App\Http\Controllers;
use App\Mail\LeaveApplication;
use App\Mail\VisitApplication;
use App\Mail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Session;

//session_start();

class MailController extends Controller
{
	public function leave_mail(Request $request)
	{
		try {
			Mail::send(new LeaveApplication());
			dd("OK");
		} catch (\Exception $e) {
			dd($e);
		}
	}
	
	public function leave_mail_response(Request $request)
	{
		$application_id = $request->application_id;
		$supervisor_id = $request->supervisor_id;
		echo $action_id = $request->action_id;
	}
	
	public function leave_approval_mail(Request $request)
	{
		$data = array();
		$application_id 			= $request->application_id;
		$supervisor_id 				= $request->supervisor_id;
		$action_id 					= $request->action_id;
		$supervisor_type 			= $request->supervisor_type;
		
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
		if($info->modify_cancel == 0)
		{
			if($supervisor_type == 1) // SUPERVISOR
			{
				if($info->super_action == 0)
				{
					$data['stage'] 						= 2;
					$data['super_emp_id'] 				= $supervisor_id;
					$data['super_action_date'] 			= date('Y-m-d');
					$data['super_action'] 				= $action_id;
					$data['action_point'] 				= 3; 
					DB::table('leave_application')
					->where('application_id', $application_id)
					->update($data);
					if($action_id == 1)
					{
						$status = $this->set_leave_balance($application_id);
						$action_message = 'You have approved the application successfully.';
					}
					else
					{
						$action_message = 'You have rejected the application successfully.';
					}
					$action	= $action_message;
					$class	= 'green';
				}
				else
				{
					$action	= 'You have already taken the action.';
					$class	= 'red';
				}
			}
			elseif($supervisor_type == 2) //// SUB SUPERVISOR
			{
				if($info->first_super_action == 0)
				{
					$data['stage'] 						= 1;
					$data['first_super_emp_id'] 		= $supervisor_id;
					$data['first_super_action_date'] 	= date('Y-m-d');
					$data['first_super_action'] 		= $action_id;
					$data['sub_action_point'] 			= 3; 
					DB::table('leave_application')
					->where('application_id', $application_id)
					->update($data);
					//
					if($action_id == 1)
					{
						$action_message = 'You have recommended the application successfully.';
					}
					else
					{
						$action_message = 'You have rejected the application successfully.';
					}
					$action	= $action_message;
					$class	= 'green';
					
					$info = DB::table('leave_application as app')
						->leftJoin('tbl_leave_type as leave_type', 'leave_type.id', '=', 'app.leave_type')
						->leftJoin('supervisors as super', 'super.supervisors_emp_id', '=', 'app.reported_to')
						->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'app.emp_id')
						->where('app.application_id', $application_id)
						->select('app.*','super.supervisors_email','basic.emp_name_eng','leave_type.type_name')
						->first();
					$application_id 				= $application_id;
					$application_date 				= $info->application_date;
					$str			 				= $info->emp_name_eng;
					$emp_name 						= str_replace(' ', '-', $str);
					$emp_id							= $info->emp_id;
					$leave_from 					= $info->leave_from;
					$leave_to 						= $info->leave_to;
					$no_of_days 					= $info->no_of_days;
					$remarks_str 					= $info->remarks;
					$remarks 						= str_replace(' ', '-', $remarks_str); 
					$supervisor_email 				= $info->supervisors_email;
					$supervisors_emp_id 			= $info->reported_to;
					$sub_supervisor_email 			= 'test@cdipbd.org'; 
					$sub_supervisors_emp_id			= $info->sub_reported_to;
					$modify_cancel 					= $info->modify_cancel;
					if($info->modify_remarks)
					{
						$modify_remarks_str			= $info->modify_remarks;
						$modify_remarks  			= str_replace(' ', '-', $modify_remarks_str); 
					}
					$modify_remarks  				= '-'; 
					$leave_type_name 				= $info->type_name; 
					//  \Mail::send(new LeaveApplication($mail_data));
					 $file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_check/'.$application_id.'/'.$application_date.'/'.$emp_name.'/'.$emp_id.'/'.$leave_from.'/'.$leave_to.'/'.$no_of_days.'/'.$remarks.'/'.$supervisor_email.'/'.$supervisors_emp_id.'/'.$sub_supervisor_email.'/'.$sub_supervisors_emp_id.'/'.$modify_cancel.'/'.$modify_remarks.'/'.$leave_type_name); 
				}
				else
				{
					$action	= 'You have already taken the action.';
					$class	= 'red';
				}
			}
		}
		elseif($info->modify_cancel == 1)
		{
			if($supervisor_type == 1) // SUPERVISOR
			{
						if($info->super_action == 0)
						{
							$data['stage'] 						= 2;
							$data['super_emp_id'] 				= $supervisor_id;
							$data['super_action_date'] 			= date('Y-m-d');
							$data['super_action'] 				= $action_id;
							$data['action_point'] 				= 3; 
							DB::table('leave_application')
							->where('application_id', $application_id)
							->update($data);
							//
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
								$history_add['user_code'] 					= 0;
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

							if($action_id == 1)
							{
								$action_message = 'You have approved the application successfully.';
							}
							else
							{
								$action_message = 'You have rejected the application successfully.';
							}
							$action	= $action_message;
							$class	= 'green';
						}
						else
						{
							$action	= 'You have already taken the action.';
							$class	= 'red';
						}
			}
			elseif($supervisor_type == 2)
			{
				if($info->first_super_action == 0)
				{
					$data['stage'] 						= 1;
					$data['first_super_emp_id'] 		= $supervisor_id;
					$data['first_super_action_date'] 	= date('Y-m-d');
					$data['first_super_action'] 		= $action_id;
					$data['sub_action_point'] 			= 3; 
					DB::table('leave_application')
					->where('application_id', $application_id)
					->update($data);
					//
					if($action_id == 1)
					{						
						$info = DB::table('leave_application as app')
							->leftJoin('tbl_leave_type as leave_type', 'leave_type.id', '=', 'app.leave_type')
							->leftJoin('supervisors as super', 'super.supervisors_emp_id', '=', 'app.reported_to')
							->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'app.emp_id')
							->where('app.application_id', $application_id)
							->select('app.*','super.supervisors_email','basic.emp_name_eng','leave_type.type_name')
							->first();
						/*	
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
						$mail_data['modify_cancel'] 				= $info->modify_cancel;
						$mail_data['modify_remarks'] 				= $info->modify_remarks;
						$mail_data['leave_type_name'] 				= $info->type_name; 
						//OFF-POLASH
							\Mail::send(new LeaveApplication($mail_data));
						*/

						$application_id 				= $application_id;
						$application_date 				= $info->application_date;
						$str			 				= $info->emp_name_eng;
						$emp_name 						= str_replace(' ', '-', $str);
						$emp_id							= $info->emp_id;
						$leave_from 					= $info->leave_from;
						$leave_to 						= $info->leave_to;
						$no_of_days 					= $info->no_of_days;
						$remarks_str 					= $info->remarks;
						$remarks 						= str_replace(' ', '-', $remarks_str); 
						$supervisor_email 				= $info->supervisors_email;
						$supervisors_emp_id 			= $info->reported_to;
						$sub_supervisor_email 			= 'test@cdipbd.org'; 
						$sub_supervisors_emp_id			= $info->sub_reported_to;
						$modify_cancel 					= $info->modify_cancel;
						$modify_remarks_str				= $info->modify_remarks;
						$modify_remarks  				= str_replace(' ', '-', $modify_remarks_str); 
						$leave_type_name 				= $info->type_name; 
						//	$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_check/'.$application_id.'/'.$application_date.'/'.$emp_name.'/'.$emp_id.'/'.$leave_from.'/'.$leave_to.'/'.$no_of_days.'/'.$remarks.'/'.$supervisor_email.'/'.$supervisors_emp_id.'/'.$sub_supervisor_email.'/'.$sub_supervisors_emp_id.'/'.$modify_cancel.'/'.$modify_remarks.'/'.$leave_type_name); 
						$action_message = 'You have recommended the application successfully.';
					}
					else
					{
						$action_message = 'You have rejected the application successfully.';
					}
					$action	= $action_message;
					$class	= 'green';
				}
				else
				{
					$action	= 'You have already taken the action.';
					$class	= 'red';
				}
						
			}
		}
		// CANCELLATION 
		else if($info->modify_cancel == 2)
		{
					if($supervisor_type == 1) // SUPERVISOR
					{
						if($info->super_action == 0)
						{
							$data['stage'] 						= 2;
							$data['super_emp_id'] 				= $supervisor_id;
							$data['super_action_date'] 			= date('Y-m-d');
							$data['super_action'] 				= $action_id;
							$data['action_point'] 				= 3; 
							DB::table('leave_application')
							->where('application_id', $application_id)
							->update($data);
							//
							if($action_id == 1)
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
										//$status = $this->set_leave_balance($application_id);
									}
									else if($info->leave_type == 5){
										// CASUAL
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

								$action_message = 'You have approved the application successfully.';
							}
							else
							{
								$action_message = 'You have rejected the application successfully.';
							}
							$action	= $action_message;
							$class	= 'green';
						}
						else
						{
							$action	= 'You have already taken the action.';
							$class	= 'red';
						}
					}
					elseif($supervisor_type == 2) //// SUB SUPERVISOR
					{
						if($info->first_super_action == 0)
						{
							$data['stage'] 						= 1;
							$data['first_super_emp_id'] 		= $supervisor_id;
							$data['first_super_action_date'] 	= date('Y-m-d');
							$data['first_super_action'] 		= $action_id;
							$data['sub_action_point'] 			= 3; 
							
							DB::table('leave_application')
							->where('application_id', $application_id)
							->update($data);

							if($action_id == 1)
							{
								$action_message = 'You have recommended the application successfully.';
								$info = DB::table('leave_application as app')
									->leftJoin('tbl_leave_type as leave_type', 'leave_type.id', '=', 'app.leave_type')
									->leftJoin('supervisors as super', 'super.supervisors_emp_id', '=', 'app.reported_to')
									->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'app.emp_id')
									->where('app.application_id', $application_id)
									->select('app.*','super.supervisors_email','basic.emp_name_eng','leave_type.type_name')
									->first();
									
								/*
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
								$mail_data['modify_cancel'] 				= $info->modify_cancel;
								$mail_data['modify_remarks'] 				= $info->modify_remarks;
								$mail_data['leave_type_name'] 				= $info->type_name; 
								//OFF-POLASH
								 \Mail::send(new LeaveApplication($mail_data));
								*/

								$application_id 				= $application_id;
								$application_date 				= $info->application_date;
								$str			 				= $info->emp_name_eng;
								$emp_name 						= str_replace(' ', '-', $str);
								$emp_id							= $info->emp_id;
								$leave_from 					= $info->leave_from;
								$leave_to 						= $info->leave_to;
								$no_of_days 					= $info->no_of_days;
								$remarks_str 					= $info->remarks;
								$remarks 						= str_replace(' ', '-', $remarks_str); 
								$supervisor_email 				= $info->supervisors_email;
								$supervisors_emp_id 			= $info->reported_to;
								$sub_supervisor_email 			= 'test@cdipbd.org'; 
								$sub_supervisors_emp_id			= $info->sub_reported_to;
								$modify_cancel 					= $info->modify_cancel;
								$modify_remarks_str				= $info->modify_remarks;
								$modify_remarks  				= str_replace(' ', '-', $modify_remarks_str); 
								$leave_type_name 				= $info->type_name; 
								$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_check/'.$application_id.'/'.$application_date.'/'.$emp_name.'/'.$emp_id.'/'.$leave_from.'/'.$leave_to.'/'.$no_of_days.'/'.$remarks.'/'.$supervisor_email.'/'.$supervisors_emp_id.'/'.$sub_supervisor_email.'/'.$sub_supervisors_emp_id.'/'.$modify_cancel.'/'.$modify_remarks.'/'.$leave_type_name); 
							}
							else
							{
								$action_message = 'You have rejected the application successfully.';
							}
							$action	= $action_message;
							$class	= 'green';
						}
						else
						{
							$action	= 'You have already taken the action.';
							$class	= 'red';
						}
					}
		}

		$message['body']  = $action; 
		$message['class'] = $class; 
		return view('admin.email.mail_feedback',$message);
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
		$history['user_code'] 					= 0;

		$app_adjust['old_adjust_number'] 		= 0;
		$app_adjust['prev_adjust_number'] 		= 0;
		$app_adjust['current_adjust_number'] 	= 0;

		
		
		
		
		//dd($balance);
		
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
	
	function set_leave_balance_manual($application_id)
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
		$history['user_code'] 					= 0;

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
	
	/* BEFORE ROLEBACK
	
	public function leave_approval_mail(Request $request)
	{
		$data = array();
		$application_id 			= $request->application_id;
		$supervisor_id 				= $request->supervisor_id;
		$action_id 					= $request->action_id;
		$supervisor_type 			= $request->supervisor_type;

		$info = DB::table('leave_application')->where('application_id', $application_id)->first();
		if($supervisor_type == 1) // SUPERVISOR
		{
			if($info->super_action == 0)
			{
				$data['stage'] 						= 2;
				$data['super_emp_id'] 				= $supervisor_id;
				$data['super_action_date'] 			= date('Y-m-d');
				$data['super_action'] 				= $action_id;
				DB::table('leave_application')
				->where('application_id', $application_id)
				->update($data);
				//
				if($action_id == 1)
				{
					$action_message = 'You have approved the application successfully.';
					$status = $this->set_leave_balance($application_id);
				}
				else
				{
					$action_message = 'You have rejected the application successfully.';
				}
				$action	= $action_message;
				$class	= 'green';
			}
			else
			{
				$action	= 'You have already taken the action.';
				$class	= 'red';
			}
		}
		elseif($supervisor_type == 2) //// SUB SUPERVISOR
		{
			if($info->first_super_action == 0)
			{
				$data['stage'] 						= 1;
				$data['first_super_emp_id'] 		= $supervisor_id;
				$data['first_super_action_date'] 	= date('Y-m-d');
				$data['first_super_action'] 		= $action_id;
				DB::table('leave_application')
				->where('application_id', $application_id)
				->update($data);
				//
				if($action_id == 1)
				{
					$action_message = 'You have recommended the application successfully.';
				}
				else
				{
					$action_message = 'You have rejected the application successfully.';
				}
				$action	= $action_message;
				$class	= 'green';
				
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
			}
			else
			{
				$action	= 'You have already taken the action.';
				$class	= 'red';
			}
		}

		$message['body']  = $action; 
		$message['class'] = $class; 
		return view('admin.email.mail_feedback',$message);

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
	END BEFORE ROLLBACK */
	
	///Visit 
	public function visit_approval_mail(Request $request)
	{
		$data = array();
		$data_vehicle = array();
		
		$move_id 					= $request->move_id;
		$supervisor_id 				= $request->supervisor_id;
		$action_id 					= $request->action_id;
		$supervisor_type 			= $request->supervisor_type;
		$info = DB::table('tbl_movement_register')->where('move_id', $move_id)->first();
		if($supervisor_type == 1) // SUPERVISOR
		{
			if($info->super_action == 0)
			{
				$data['stage'] 						= 2;
				$data['super_emp_id'] 				= $supervisor_id;
				$data['super_action_date'] 			= date('Y-m-d');
				$data['super_action'] 				= $action_id;
				DB::table('tbl_movement_register')
				->where('move_id', $move_id)
				->update($data); 
				
				//
				if($action_id == 1)
				{
					if($info->is_need_vehicle_sup == 1){
					 
						$data_vehicle['from_date'] 			= $info->from_date;  
						$data_vehicle['from_time'] 			= $info->leave_time;  
						$data_vehicle['to_date'] 			= $info->to_date;  
						$data_vehicle['to_time'] 			= $info->arrival_time;  
						$data_vehicle['return_date'] 		= $info->to_date;  
						$data_vehicle['return_time'] 		= $info->arrival_time;  
						$data_vehicle['move_id'] 			= $move_id;  
						$data_vehicle['created_by'] 		= $info->visit_reported_to; 
						DB::table('tbl_move_vehicle_assign')->insert($data_vehicle); 
					} 
					$action_message = 'You have approved the application successfully.';
				}
				else
				{
					$action_message = 'You have rejected the application successfully.';
				}
				$action	= $action_message;
				$class	= 'green';
			}
			else
			{
				$action	= 'You have already taken the action.';
				$class	= 'red';
			}
		}
		elseif($supervisor_type == 2) //// SUB SUPERVISOR
		{
			if($info->first_super_action == 0)
			{
				$data['stage'] 						= 1;
				$data['first_super_emp_id'] 		= $supervisor_id;
				$data['first_super_action_date'] 	= date('Y-m-d');
				$data['first_super_action'] 		= $action_id;
				DB::table('tbl_movement_register')
				->where('move_id', $move_id)
				->update($data);
				//
				if($action_id == 1)
				{
					$action_message = 'You have recommended the application successfully.';
				}
				else
				{
					$action_message = 'You have rejected the application successfully.';
				}
				$action	= $action_message;
				$class	= 'green';
				
				$info = DB::table('tbl_movement_register as visit')
						->leftJoin('supervisors as super', 'super.supervisors_emp_id', '=', 'visit.visit_reported_to')
						->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'visit.emp_id')
						->where('visit.move_id', $move_id)
						->select('visit.*','super.supervisors_email','basic.emp_name_eng')
						->first();	
				
				/* $visit_type 								= $info->visit_type; 
				if($visit_type == 1){
					
					$branch_list = DB::table('tbl_branch')  
										->select('br_code','branch_name')
										->get();
					$branch_name = '';
					$destination_code = explode(',',$info->destination_code);
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
										
					$v_mail_data['destination_code'] 		= $branch_name;
				}else{
					$v_mail_data['destination_code'] 		= $info->destination_code;
				}
				$v_mail_data['move_id'] 					= $move_id;
				$v_mail_data['application_date'] 			= $info->application_date;  
				$v_mail_data['emp_name'] 					= $info->emp_name_eng;
				$v_mail_data['emp_id'] 						= $info->emp_id;
				$v_mail_data['from_date'] 					= $info->from_date;
				$v_mail_data['to_date'] 					= $info->arrival_date;
				$v_mail_data['leave_time'] 					= $info->leave_time;
				$v_mail_data['arrival_time'] 				= $info->return_time;
				
				$v_mail_data['purpose'] 					= $info->purpose;
				$v_mail_data['supervisor_email'] 			= $info->supervisors_email;
				$v_mail_data['supervisors_emp_id'] 			= $info->visit_reported_to;
				$v_mail_data['sub_supervisor_email'] 		= '';
				$v_mail_data['sub_supervisors_emp_id'] 		= $info->visit_sub_supervisors_emp_id;
				//OFF-POLASH
				 \Mail::send(new VisitApplication($v_mail_data));  */
				 
				$move_id 					= $move_id;
				$application_date			= $info->application_date;
				$str 						= $info->emp_name_eng;
				$emp_name 					= str_replace(' ', '-', $str);
				$emp_id 					= $info->emp_id;
				$from_date 					= $info->from_date;
				$to_date					= $info->arrival_date;
				$leave_time_str 			= $info->leave_time;
				$leave_time_st 				= str_replace("%20"," ",$leave_time_str);
				$leave_time 				= str_replace(' ', '-', $leave_time_st);
				$arrival_time_str 			= $info->return_time;
				
				$arrival_time_st 			= str_replace("%20"," ",$arrival_time_str);
				$arrival_time 				= str_replace(' ', '-', $arrival_time_st);
				$visit_type 				= $info->visit_type; 
				if($visit_type == 1)
				{
					$branch_list = DB::table('tbl_branch')  
										->select('br_code','branch_name')
										->get(); 
					$branch_name 		= ''; 
					$destination_code 	= explode(',',$info->destination_code);
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
					$destination_code_mail 		= $info->destination_code;
				} 
					$destination_code 			= str_replace(' ', '-', $destination_code_mail);
					$purpose_str 				=  $info->purpose;
					$purpose 					= str_replace(' ', '-', $purpose_str); 
					$supervisor_email 			= $info->supervisors_email;
					$supervisors_emp_id 		=$info->visit_reported_to;
					
					$sub_supervisor_email		= 'test@cdipbd.org'; 
					$sub_supervisors_emp_id		= $info->visit_sub_supervisors_emp_id;
					
					$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_check_visit/'.$move_id.'/'.$application_date.'/'.$emp_name.'/'.$emp_id.'/'.$from_date.'/'.$to_date.'/'.$leave_time.'/'.$arrival_time.'/'.$destination_code.'/'.$purpose.'/'.$supervisor_email.'/'.$sub_supervisor_email.'/'.$supervisors_emp_id.'/'.$sub_supervisors_emp_id);  
			}
			else
			{
				$action	= 'You have already taken the action.';
				$class	= 'red';
			}
		}

		$message['body']  = $action; 
		$message['class'] = $class; 
		return view('admin.email.mail_feedback',$message);

	}

	
}
