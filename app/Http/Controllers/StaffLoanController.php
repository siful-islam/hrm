<?php
namespace App\Http\Controllers;
use App\Models\SLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use DateTime;

//session_start();

class StaffLoanController extends Controller
{
	public function __construct()
	{
		date_default_timezone_set('Asia/Dhaka');
		$this->middleware("CheckUserSession");
	}
	

	
	public function dm_scp(Request $request)
	{
		$data = array();
		$emp_id = Session::get('emp_id'); 
		$scp_supervisor = DB::table('loan_approval_authority')
										->where('author_role',4)
										->first();
		$data['report_to'] 		= $scp_supervisor->author_emp_id;
		$data['report_to_show'] = $scp_supervisor->author_designation;
		$data['layer'] 			= 1; 
		$data['ho_bo'] 			= 2; 
		
		$data['emp_id'] = $emp_id;
		$loanData = DB::table('loan as l')
			->leftJoin("loan_product as lp", 'lp.loan_product_id', '=', 'l.loan_product_code')
			->leftJoin('tbl_emp_basic_info as emp', 'l.emp_id', '=', 'emp.emp_id')
			->where('l.emp_id', $emp_id)
			->orderBy('l.loan_id', 'Desc')
			->select('emp.emp_name_eng', 'lp.loan_product_name', 'l.loan_id', 'l.application_date', 'l.loan_code', 'l.disbursement_date', 'l.first_repayment_date', 'l.emp_id', 'l.loan_amount','l.loan_status')
			->get();

		$data['loan_types'] = DB::table('loan_category as l')
			->leftJoin("loan_product as lp", 'lp.category_id', '=', 'l.loan_category_id')
			->select('l.name_bangla','l.loan_category_id', 'l.loan_category_name', 'lp.interest_rate', 'lp.loan_product_id', 'lp.loan_product_name')
			->where('l.status', 1)
			->get();
			
		$data['banks'] = DB::table('banks')
			->where('bank_status',1)
			->get();
			
		$data['loan_purpouse'] = DB::table('loan_purpouse')
			->where('category_code',7)
			->get();
			
		$my_infos 					= $this->emp_info($emp_id);
		$data['emp_name'] 			= $my_infos['emp_name']; 
		$data['designation_code'] 	= $my_infos['designation_code']; 
		$data['designation_name'] 	= $my_infos['designation_name']; 
		$data['branch_name'] 		= $my_infos['branch_name'];
		$data['loanData'] 			= $loanData; 
		//print_r($data);
		return view('admin.my_info.scp_loan', $data);  
	}
	
	public function dm_scp_save(Request $request)
	{
		$emp_id 						= $request->input('emp_id');
		$supervisor_emp_id 				= $request->input('supervisor_emp_id'); 
		$sc_heads 						= DB::table('loan_approval_authority')
										->where('author_role',4)
										->first();
		$data['emp_id'] 				= $emp_id;
		$data['is_self'] 				= 4;
		$max_id = DB::table('emp_loan_applications')->where('emp_id', $data['emp_id'])->max('emp_app_serial');
		$data['emp_app_serial'] 		= $max_id + 1;
		$data['ho_bo'] 					= $request->input('ho_bo'); 
		$data['application_date'] 		= $request->input('application_date');
		$data['loan_type_id'] 			= $request->input('loan_type_id');
		$data['interest'] 				= $request->input('interest');
		$data['loan_amount'] 			= $request->input('loan_amount'); 
		$my_infos 						= $this->emp_info($emp_id);	
		$data['emp_name'] 				= $my_infos['emp_name']; 
		$data['designation_code'] 		= $my_infos['designation_code'];  
		$data['designation_name'] 		= $my_infos['designation_name'];  
		$data['branch_name'] 			= $my_infos['branch_name']; 
		$data['emp_branch'] 			= $my_infos['br_code'];  
		$data['emp_area'] 				= $my_infos['area_code'];  
		$data['emp_zone'] 				= $my_infos['zone_code'];  
		$self_group 					= $my_infos['self_group']; 
		if($data['loan_type_id'] == 7)
		{
			$equipments 				= $request->input('equipments'); 
			$data['equipments'] 		= implode(",", $equipments); 
		}
		$data['loan_purpose'] 			= $request->input('loan_purpose');
		$data['loan_duration'] 			= $request->input('loan_duration'); 
		// BANK
		$data['accounts_holder'] 		= $request->input('accounts_holder'); 
		$data['bank_id'] 				= $request->input('bank_id');
		$data['bank_branch_id'] 		= $request->input('bank_branch_id');
		$data['accounts_number'] 		= $request->input('accounts_number');
		$data['routing_number'] 		= $request->input('routing_number');
		$layer 							= 1;
		$data['left_action'] 			= $sc_heads->author_emp_id;
		$data['perform_action'] 		= 0;
		$data['application_stage'] 	= 0;
		$loan_app_id  					= DB::table('emp_loan_applications')->insertGetId($data);
		
		$sc_head 						= $sc_heads->author_emp_id;
		$sc['emp_id'] 					= $emp_id;	  
		$sc['application_id'] 			= $loan_app_id;	 
		$sc['supervisors_id'] 			= $sc_head;	
		$sc['actions'] 					= 0;	 
		$sc['actions_remarks'] 			= '';
		$sc['supervisors_name'] 		= $sc_heads->author_name;
		$sc['supervisor_designation']	= $sc_heads->author_designation;
		$sc_id  						= DB::table('loan_approval')->insertGetId($sc);	

		
		if($data['loan_type_id'] == 1) 
		{
			$h_hr 			= DB::table('loan_approval_authority')
								->where('author_role',1)
								->first();										
			if($emp_id != $h_hr->author_emp_id)
			{
				$pf['emp_id'] 					= $emp_id;	 
				$pf['application_id'] 			= $loan_app_id;	 
				$pf['supervisors_id'] 			= $h_hr->author_emp_id;	
				$pf['action_date'] 				= '';
				$pf['actions'] 					= 0;	 
				$pf['actions_remarks'] 			= '';
				$pf['supervisors_name'] 		= $h_hr->author_name;
				$pf['supervisor_designation']	= $h_hr->author_designation;
				$pf_id  						= DB::table('loan_approval')->insertGetId($pf);	
			}
		}
		
		// Mail Fire to Supervisor	
		$supervisor_mail 		= $sc_heads->author_mail;
		$emp_id 				= $emp_id; 
		$emp_name_string 		= $data['emp_name']; 
		$emp_name 				= str_replace(' ', '-', $emp_name_string);
		$designation_name_string= $data['designation_name'];
		$designation_name 		= str_replace(' ', '-', $designation_name_string);
		$branch_name_string 	= $data['branch_name'];
		$branch_name 			= str_replace(' ', '-', $branch_name_string);
		$application_date 		= $request->input('application_date');
		$loan_type_id 			= $request->input('loan_type_id');
		$loan_amount 			= $request->input('loan_amount'); 
		$loan_duration 			= $request->input('loan_duration'); 
		
		$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_loan/'.$supervisor_mail.'/'.$emp_id.'/'.$emp_name.'/'.$designation_name.'/'.$branch_name.'/'.$application_date.'/'.$loan_type_id.'/'.$loan_amount.'/'.$loan_duration);
		
		$action['status']  = 1;		
		echo json_encode($action);
	}
	
	public function agri_application()
	{
		$branch_code 	= Session::get('branch_code');
		$emp_type 		= Session::get('emp_type');
		$user_type 		= Session::get('user_type');
		$area_code 		= Session::get('area_code');
		$zone_code 		= Session::get('zone_code');
		$data['loan_types'] = DB::table('loan_category as l')
			->leftJoin("loan_product as lp", 'lp.category_id', '=', 'l.loan_category_id')
			->select('l.name_bangla','l.loan_category_id', 'l.loan_category_name', 'lp.interest_rate', 'lp.loan_product_id', 'lp.loan_product_name')
			->where('l.status', 1)
			->get();
		$data['banks'] = DB::table('banks')
			->where('bank_status',1)
			->get();
			
		$data['loan_purpouse'] = DB::table('loan_purpouse')
			->where('category_code',7)
			->get();
		$self_group = 22;
		$data['my_staffs'] 				= $this->designation_staff_zone($self_group,$zone_code);
		$my_info 						= $this->get_emp($branch_code,$user_type);										
		$data['supervisor_emp_id']		= $my_info['emp_id'];
		$data['supervisors_name']		= $my_info['emp_name_eng'];
		$data['supervisor_designation']	= $my_info['designation_name'];
		$data['app_type'] 				= 2;
		$data['action'] 				= '/loan_save_agri';
		//echo '<pre>';
		//print_r($my_staffs);
		return view('admin.my_info.all_loan_agri', $data); 
	}
	
	public function loan_save_agri(Request $request)
	{
		$emp_id 						= $request->input('emp_id');
		$supervisor_emp_id 				= $request->input('supervisor_emp_id'); 
		$my_infos 						= $this->emp_info($emp_id);	
		$emp_zone 						= $my_infos['zone_code']; 
		$program_heads 					= DB::table('tbl_zone')->where('zone_code',$emp_zone)->first();																		
		$supervisors 					= DB::table('loan_approval_authority')
										->where('author_role',8)
										->first();						
		$data['emp_id'] 				= $emp_id;
		$data['is_self'] 				= 5;
		$max_id = DB::table('emp_loan_applications')->where('emp_id', $data['emp_id'])->max('emp_app_serial');
		$data['emp_app_serial'] 		= $max_id + 1;
		$data['ho_bo'] 					= $request->input('ho_bo'); 
		$data['application_date'] 		= $request->input('application_date');
		$data['loan_type_id'] 			= $request->input('loan_type_id');
		$data['interest'] 				= $request->input('interest');
		$data['loan_amount'] 			= $request->input('loan_amount'); 
		$my_infos 						= $this->emp_info($emp_id);	
		$data['emp_name'] 				= $my_infos['emp_name']; 
		$data['designation_code'] 		= $my_infos['designation_code'];  
		$data['designation_name'] 		= $my_infos['designation_name'];  
		$data['branch_name'] 			= $my_infos['branch_name']; 
		$data['emp_branch'] 			= $my_infos['br_code'];  
		$data['emp_area'] 				= $my_infos['area_code'];  
		$data['emp_zone'] 				= $my_infos['zone_code'];  
		$self_group 					= $my_infos['self_group']; 
		if($data['loan_type_id'] == 7)
		{
			$equipments 				= $request->input('equipments'); 
			$data['equipments'] 		= implode(",", $equipments); 
		}
		$data['loan_purpose'] 			= $request->input('loan_purpose');
		$data['loan_duration'] 			= $request->input('loan_duration'); 
		// BANK
		$data['accounts_holder'] 		= $request->input('accounts_holder'); 
		$data['bank_id'] 				= $request->input('bank_id');
		$data['bank_branch_id'] 		= $request->input('bank_branch_id');
		$data['accounts_number'] 		= $request->input('accounts_number');
		$data['routing_number'] 		= $request->input('routing_number');
		$data['left_action'] 			= $supervisors->author_emp_id;
		$data['perform_action'] 		= 1;
		$data['application_stage'] 		= 0;
		if($data['loan_type_id'] == 1)
		{
			$data['pf_hhr_action'] 		= 1; // 
		}
		$post_actions 					= $request->input('actions');
		$post_actions_remarks 			= $request->input('actions_remarks');
		$post_supervisors_name 			= $request->input('supervisors_name');
		$post_supervisor_designation 	= $request->input('supervisor_designation');
		// INSERT
		$loan_app_id  					= DB::table('emp_loan_applications')->insertGetId($data);
		$applicant_supervisor['application_id'] 		= $loan_app_id;
		$applicant_supervisor['emp_id'] 				= $emp_id;
		$applicant_supervisor['supervisors_id'] 		= $supervisor_emp_id;
		$applicant_supervisor['actions'] 				= $post_actions;
		$applicant_supervisor['action_date'] 			= date('Y-m-d');
		$applicant_supervisor['actions_remarks'] 		= $post_actions_remarks;
		$applicant_supervisor['supervisors_name']		= $post_supervisors_name;
		$applicant_supervisor['supervisor_designation']	= $post_supervisor_designation;
		$insert_id = DB::table('loan_approval')->insertGetId($applicant_supervisor);
		$supervisor['application_id'] 			= $loan_app_id;	 
		$supervisor['emp_id'] 					= $emp_id;	
		$supervisor['supervisors_id'] 			= $supervisors->author_emp_id;
		$supervisor['actions'] 					= 0;	 
		$supervisor['actions_remarks'] 			= '';
		$supervisor['supervisors_name'] 		= $supervisors->author_name;
		$supervisor['supervisor_designation']	= $supervisors->author_designation;
		$insert_id  							= DB::table('loan_approval')->insertGetId($supervisor);	

		$program_head['application_id'] 		= $loan_app_id;	 
		$program_head['emp_id'] 				= $emp_id;	
		$program_head['supervisors_id'] 		= $program_heads->program_supervisor_id;
		$program_head['actions'] 				= 0;	 
		$program_head['actions_remarks'] 		= '';
		$program_head['supervisors_name'] 		= $program_heads->program_supervisor_name;
		$program_head['supervisor_designation']	= $program_heads->program_supervisor_designatation;
		$insert_id  							= DB::table('loan_approval')->insertGetId($program_head);	
		if($data['loan_type_id'] == 1) 
		{
			$h_hr 			= DB::table('loan_approval_authority')
								->where('author_role',1)
								->first();										
			if($emp_id != $h_hr->author_emp_id)
			{
				$pf['emp_id'] 					= $emp_id;	 
				$pf['application_id'] 			= $loan_app_id;	 
				$pf['supervisors_id'] 			= $h_hr->author_emp_id;	
				$pf['action_date'] 				= '';
				$pf['actions'] 					= 0;	 
				$pf['actions_remarks'] 			= '';
				$pf['supervisors_name'] 		= $h_hr->author_name;
				$pf['supervisor_designation']	= $h_hr->author_designation;
				$pf_id  						= DB::table('loan_approval')->insertGetId($pf);	
			}
		}
		
		// Mail Fire to Supervisor	
		$supervisor_mail 		= $program_heads->author_mail;
		$emp_id 				= $emp_id; 
		$emp_name_string 		= $data['emp_name']; 
		$emp_name 				= str_replace(' ', '-', $emp_name_string);
		$designation_name_string= $data['designation_name'];
		$designation_name 		= str_replace(' ', '-', $designation_name_string);
		$branch_name_string 	= $data['branch_name'];
		$branch_name 			= str_replace(' ', '-', $branch_name_string);
		$application_date 		= $request->input('application_date');
		$loan_type_id 			= $request->input('loan_type_id');
		$loan_amount 			= $request->input('loan_amount'); 
		$loan_duration 			= $request->input('loan_duration'); 
		
		$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_loan/'.$supervisor_mail.'/'.$emp_id.'/'.$emp_name.'/'.$designation_name.'/'.$branch_name.'/'.$application_date.'/'.$loan_type_id.'/'.$loan_amount.'/'.$loan_duration);
		
		$action['status']  = 1;		
		echo json_encode($action);
	}

	public function agri_recomendation_list()
	{
		$supervisor_emp_id 		= Session::get('emp_id');
		$branch_code 			= Session::get('branch_code'); 
		$data['pending'] 	= DB::table('emp_loan_applications as la')
									->leftJoin('loan_product as pr', 'la.loan_type_id', '=', 'pr.loan_product_id')
									->where('left_action',$supervisor_emp_id)
									->where('la.application_stage',0)
									->where('la.is_reject',0)
									->where('la.next_action',1)
									->select('la.*','pr.loan_product_name')
									->get();	
		//echo '<pre>';
		//print_r($data['pending']);
		//exit;
		$data['btn_link'] 		= 'Recommend';
		$data['action_type'] 	= 7; 		
		return view('admin.my_info.loan_pending_approval', $data);	
	}	
	
		
	public function agri_recomendation_process(Request $request)
	{
		$emp_id 					= $request->input('emp_id');	 
		$loan_type_id 				= $request->input('loan_type_id');	 
		$application_id 			= $request->input('application_id');	
		$actions 					= $request->input('actions');
		$approval_info 				= DB::table('loan_approval')
										->where('application_id',$application_id)
										->where('actions', 0)
										->orderBy('approval_id', 'asc')
										->select('approval_id')
										->first();							

		$update['actions'] 			= $request->input('actions');	
		$update['action_date'] 		= date('Y-m-d');	
		$update['actions_remarks'] 	= $request->input('actions_remarks');		  
		DB::table('loan_approval')->where('approval_id', $approval_info->approval_id)->update($update); 
		
		$loan_info 					= DB::table('emp_loan_applications')->where('loan_app_id',$application_id)->first();
		
		if($loan_info->perform_action == 1)
		{
			$my_infos 						= $this->emp_info($emp_id);	
			$emp_zone 						= $my_infos['zone_code']; 
			$ph 							= DB::table('tbl_zone')
												->where('zone_code',$emp_zone)
												->first();	
			$data['left_action'] 		= $ph->program_supervisor_id;
			$data['application_stage']	= 0;
			// MAil
			if($loan_info->left_action ==0)
			{
				$supervisor_mail_address 	= 'nafis@cdipbd.org'; 
			}else{
				$supervisor_mail_address 	= $ph->program_supervisor_mail;	
			}
			$supervisor_mail 			= $supervisor_mail_address; 
			$emp_id 					= $emp_id; 
			$emp_name_string 			= $loan_info->emp_name;  
			$emp_name 					= str_replace(' ', '-', $emp_name_string);
			$designation_name_string	= $loan_info->designation_name;
			$designation_name 			= str_replace(' ', '-', $designation_name_string);
			$branch_name_string 		= $loan_info->branch_name;
			$branch_name 				= str_replace(' ', '-', $branch_name_string);
			$application_date 			= $loan_info->application_date;
			$loan_type_id 				= $loan_info->loan_type_id;
			$loan_amount 				= $loan_info->loan_amount;
			$loan_duration 				= $loan_info->loan_duration;
			//$mail = $this->send_mail($supervisor_mail,$emp_id,$emp_name,$designation_name,$branch_name,$application_date,$loan_type_id,$loan_amount,$loan_duration);
			// END MAil

		}elseif($loan_info->perform_action == 2){
			$data['left_action'] 		= 0;
			$data['application_stage']	= 1;
		}
		$data['perform_action'] 		= $loan_info->perform_action + 1;
		
		if($actions == 1)
		{
			$data['next_action'] 		= 1;
		}else{
			$data['is_reject'] 			= 1;
		}
		if($loan_type_id == 1)
		{
			$data['application_stage']	= 0;
			$data['pf_hhr_action'] 		= 1;
		}
		DB::table('emp_loan_applications')->where('loan_app_id', $application_id)->update($data);
		return Redirect::to("/agri_recomendation_list");	
	}	

	public function health_recomendation_list()
	{
		$supervisor_emp_id 	= Session::get('emp_id');
		$branch_code 		= Session::get('branch_code'); 
		$data['pending'] 	= DB::table('emp_loan_applications as la')
									->leftJoin('loan_product as pr', 'la.loan_type_id', '=', 'pr.loan_product_id')
									->where('left_action',$supervisor_emp_id)
									->where('la.application_stage',0)
									->where('la.is_reject',0)
									->where('la.next_action',1)
									->select('la.*','pr.loan_product_name')
									->get();	
		$data['btn_link'] 		= 'Recommend';
		$data['action_type'] 	= 6; 		
		return view('admin.my_info.loan_pending_approval', $data);	
	}

	
	public function health_recomendation_process(Request $request)
	{
		$emp_id 					= $request->input('emp_id');	 
		$loan_type_id 				= $request->input('loan_type_id');	 
		$application_id 			= $request->input('application_id');	
		$actions 					= $request->input('actions');
		$approval_info 				= DB::table('loan_approval')
										->where('application_id',$application_id)
										->where('actions', 0)
										->orderBy('approval_id', 'asc')
										->select('approval_id')
										->first();							
 		$update['supervisors_id'] 			= $request->input('supervisors_id');	
		$update['actions'] 					= $request->input('actions');	
		$update['action_date'] 				= date('Y-m-d');	
		$update['actions_remarks'] 			= $request->input('actions_remarks');		  
		$update['supervisors_name'] 		= $request->input('supervisors_name');	
		$update['supervisor_designation'] 	= $request->input('supervisor_designation');	
		DB::table('loan_approval')->where('approval_id', $approval_info->approval_id)->update($update);  
		$loan_info 					= DB::table('emp_loan_applications')->where('loan_app_id',$application_id)->first();
		$data['left_action'] 		= 0;
		$data['application_stage']	= 1;
		$data['perform_action'] 		= $loan_info->perform_action + 1;
		if($actions == 1)
		{
			$data['next_action'] 		= 1;
		}else{
			$data['is_reject'] 			= 1;
		}
		if($loan_type_id == 1)
		{
			$data['application_stage']	= 0;
			$data['pf_hhr_action'] 		= 1;
		}
		DB::table('emp_loan_applications')->where('loan_app_id', $application_id)->update($data);
		return Redirect::to("/health_recomendation_list");	
	}
	
	public function sc_application()
	{
		$branch_code 	= Session::get('branch_code');
		$emp_type 		= Session::get('emp_type');
		$user_type 		= Session::get('user_type');
		$area_code 		= Session::get('area_code');
		$zone_code 		= Session::get('zone_code');
		$data['loan_types'] = DB::table('loan_category as l')
			->leftJoin("loan_product as lp", 'lp.category_id', '=', 'l.loan_category_id')
			->select('l.name_bangla','l.loan_category_id', 'l.loan_category_name', 'lp.interest_rate', 'lp.loan_product_id', 'lp.loan_product_name')
			->where('l.status', 1)
			->get();
		$data['banks'] = DB::table('banks')
			->where('bank_status',1)
			->get();
			
		$data['loan_purpouse'] = DB::table('loan_purpouse')
			->where('category_code',7)
			->get();
		$self_group = 21;
		$data['my_staffs'] 				= $this->designation_staff($self_group);
		//echo '<pre>';
		//print_r($data['my_staffs']);
		//exit;
		$my_info 						= DB::table('loan_approval_authority')
												->where('author_role',7)
												->first();										
		$data['supervisor_emp_id']		= $my_info->author_emp_id;
		$data['supervisors_name']		= $my_info->author_name;
		$data['supervisor_designation']	= $my_info->author_designation;
		$data['app_type'] 				= 2;
		$data['action'] 				= '/loan_save_sc';
		//echo '<pre>';
		//print_r($data['my_staffs']);
		return view('admin.my_info.all_loan_social', $data);  
	}

	public function loan_save_sc(Request $request)
	{
		$emp_id 						= $request->input('emp_id');
		$supervisor_emp_id 				= $request->input('supervisor_emp_id'); 
		$sc_heads 						= DB::table('loan_approval_authority')
										->where('author_role',4)
										->first();
		$data['emp_id'] 				= $emp_id;
		$data['is_self'] 				= 4;
		$max_id = DB::table('emp_loan_applications')->where('emp_id', $data['emp_id'])->max('emp_app_serial');
		$data['emp_app_serial'] 		= $max_id + 1;
		$data['ho_bo'] 					= $request->input('ho_bo'); 
		$data['application_date'] 		= $request->input('application_date');
		$data['loan_type_id'] 			= $request->input('loan_type_id');
		$data['interest'] 				= $request->input('interest');
		$data['loan_amount'] 			= $request->input('loan_amount'); 
		$my_infos 						= $this->emp_info($emp_id);	
		$data['emp_name'] 				= $my_infos['emp_name']; 
		$data['designation_code'] 		= $my_infos['designation_code'];  
		$data['designation_name'] 		= $my_infos['designation_name'];  
		$data['branch_name'] 			= $my_infos['branch_name']; 
		$data['emp_branch'] 			= $my_infos['br_code'];  
		$data['emp_area'] 				= $my_infos['area_code'];  
		$data['emp_zone'] 				= $my_infos['zone_code'];  
		$self_group 					= $my_infos['self_group'];  
		if($data['loan_type_id'] == 7)
		{
			$equipments 				= $request->input('equipments'); 
			$data['equipments'] 		= implode(",", $equipments); 
		}
		$data['loan_purpose'] 			= $request->input('loan_purpose');
		$data['loan_duration'] 			= $request->input('loan_duration'); 
		// BANK
		$data['accounts_holder'] 		= $request->input('accounts_holder'); 
		$data['bank_id'] 				= $request->input('bank_id');
		$data['bank_branch_id'] 		= $request->input('bank_branch_id');
		$data['accounts_number'] 		= $request->input('accounts_number');
		$data['routing_number'] 		= $request->input('routing_number');
		$layer 							= 2;
		$data['left_action'] 			= $sc_heads->author_emp_id;
		$data['perform_action'] 		= 2;
		$data['next_action'] 			= 1;  
		$data['application_stage'] 		= 0;  
		$post_actions 					= $request->input('actions');
		$post_actions_remarks 			= $request->input('actions_remarks');
		$post_supervisors_name 			= $request->input('supervisors_name');
		$post_supervisor_designation 	= $request->input('supervisor_designation');
		// INSERT
		$loan_app_id  					= DB::table('emp_loan_applications')->insertGetId($data);
		$sup['application_id'] 			= $loan_app_id;
		$sup['emp_id'] 					= $emp_id;
		$sup['supervisors_id'] 			= $supervisor_emp_id;
		$sup['actions'] 				= $post_actions;
		$sup['action_date'] 			= date('Y-m-d');
		$sup['actions_remarks'] 		= $post_actions_remarks;
		$sup['supervisors_name']		= $post_supervisors_name;
		$sup['supervisor_designation']	= $post_supervisor_designation;
		$status = DB::table('loan_approval')->insertGetId($sup);
		$sc_head 						= $sc_heads->author_emp_id;
		$sc['emp_id'] 					= $emp_id;	  
		$sc['application_id'] 			= $loan_app_id;	 
		$sc['supervisors_id'] 			= $sc_head;	
		$sc['actions'] 					= 0;	 
		$sc['actions_remarks'] 			= '';
		$sc['supervisors_name'] 		= $sc_heads->author_name;
		$sc['supervisor_designation']	= $sc_heads->author_designation;
		$sc_id  						= DB::table('loan_approval')->insertGetId($sc);	
		if($data['loan_type_id'] == 1) 
		{
			$h_hr 			= DB::table('loan_approval_authority')
								->where('author_role',1)
								->first();										
			if($emp_id != $h_hr->author_emp_id)
			{
				$pf['emp_id'] 					= $emp_id;	 
				$pf['application_id'] 			= $loan_app_id;	 
				$pf['supervisors_id'] 			= $h_hr->author_emp_id;	
				$pf['action_date'] 				= '';
				$pf['actions'] 					= 0;	 
				$pf['actions_remarks'] 			= '';
				$pf['supervisors_name'] 		= $h_hr->author_name;
				$pf['supervisor_designation']	= $h_hr->author_designation;
				$pf_id  						= DB::table('loan_approval')->insertGetId($pf);	
			}
		}
		
		// Mail Fire to Supervisor	
		$supervisor_mail 		= $sc_heads->author_mail;
		$emp_id 				= $emp_id; 
		$emp_name_string 		= $data['emp_name']; 
		$emp_name 				= str_replace(' ', '-', $emp_name_string);
		$designation_name_string= $data['designation_name'];
		$designation_name 		= str_replace(' ', '-', $designation_name_string);
		$branch_name_string 	= $data['branch_name'];
		$branch_name 			= str_replace(' ', '-', $branch_name_string);
		$application_date 		= $request->input('application_date');
		$loan_type_id 			= $request->input('loan_type_id');
		$loan_amount 			= $request->input('loan_amount'); 
		$loan_duration 			= $request->input('loan_duration'); 
		$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_loan/'.$supervisor_mail.'/'.$emp_id.'/'.$emp_name.'/'.$designation_name.'/'.$branch_name.'/'.$application_date.'/'.$loan_type_id.'/'.$loan_amount.'/'.$loan_duration);
		
		$action['status']  = 1;		
		echo json_encode($action);
	}

	public function sc_recomendation_list()
	{
		$supervisor_emp_id 		= Session::get('emp_id');
		$branch_code 			= Session::get('branch_code'); 
		$data['pending'] = DB::table('emp_loan_applications as la')
							->leftJoin('loan_product as pr', 'la.loan_type_id', '=', 'pr.loan_product_id')
							->where('la.next_action',1)
							->where('la.is_reject',0)
							->where('la.left_action',$supervisor_emp_id)
							->select('la.*','pr.loan_product_name')
							->get();					
		$data['btn_link'] 		= 'Recommend';
		$data['action_type'] 	= 5; 		
		return view('admin.my_info.loan_pending_approval', $data);	
	}
	
	public function sc_loan_recomendation_process(Request $request)
	{
		$emp_id 					= $request->input('emp_id');	 
		$loan_type_id 				= $request->input('loan_type_id');	 
		$application_id 			= $request->input('application_id');	
		$actions 					= $request->input('actions');
		$approval_info 				= DB::table('loan_approval')
										->where('application_id',$application_id)
										->where('actions', 0)
										->orderBy('approval_id', 'asc')
										->select('approval_id')
										->first();
										
		$update['supervisors_id'] 	= $request->input('supervisors_id');	
		$update['actions'] 			= $request->input('actions');	
		$update['action_date'] 		= date('Y-m-d');	
		$update['actions_remarks'] 	= $request->input('actions_remarks');		
		DB::table('loan_approval')->where('approval_id', $approval_info->approval_id)->update($update);

		if($actions == 1)
		{
			$data['next_action'] 				= 1;
			$data['left_action'] 				= 0;
		}else{
			$data['is_reject'] 			    	= 1;
		}
		$data['perform_action'] 				= 2;
		

		if($loan_type_id == 1)
		{
			if($actions == 1)
			{
				$data['application_stage']	= 0;
				$data['pf_hhr_action'] 		= 1;
			}else{
				$data['is_reject'] 			= 1;
			}
						
		}else{
			$data['application_stage'] 		= 1;  
		}
		DB::table('emp_loan_applications')->where('loan_app_id', $application_id)->update($data);
		return Redirect::to("/sc_recomendation_list");	 
	}
	
	public function auditor_application()
	{
		$branch_code 	= Session::get('branch_code');
		$emp_type 		= Session::get('emp_type');
		$user_type 		= Session::get('user_type');
		$area_code 		= Session::get('area_code');
		$zone_code 		= Session::get('zone_code');
		$data['loan_types'] = DB::table('loan_category as l')
			->leftJoin("loan_product as lp", 'lp.category_id', '=', 'l.loan_category_id')
			->select('l.name_bangla','l.loan_category_id', 'l.loan_category_name', 'lp.interest_rate', 'lp.loan_product_id', 'lp.loan_product_name')
			->where('l.status', 1)
			->get();
		$data['banks'] = DB::table('banks')
			->where('bank_status',1)
			->get();
			
		$data['loan_purpouse'] = DB::table('loan_purpouse')
			->where('category_code',7)
			->get();

		$self_group = 20;
		$data['my_staffs'] 				= $this->designation_staff($self_group);
		$my_info 						= DB::table('loan_approval_authority')
												->where('author_role',6)
												->first();
		$data['supervisor_emp_id']		= $my_info->author_emp_id;
		$data['supervisors_name']		= $my_info->author_name;
		$data['supervisor_designation']	= $my_info->author_designation;
		$data['app_type'] 				= 3;
		$data['action'] 				= '/loan_save_audit';
		//echo '<pre>';
		//print_r($data['my_staffs']);
		return view('admin.my_info.all_loan_audit', $data);
	}

	public function loan_save_audit(Request $request)
	{
		//$data 			   			= request()->except(['_token']); 
		$emp_id 						= $request->input('emp_id');
		$supervisor_emp_id 				= $request->input('supervisor_emp_id');
		$data['emp_id'] 				= $emp_id;
		$data['is_self'] 				= 3;
		$max_id = DB::table('emp_loan_applications')->where('emp_id', $data['emp_id'])->max('emp_app_serial');
		$data['emp_app_serial'] 		= $max_id + 1;
		$data['ho_bo'] 					= $request->input('ho_bo'); 
		$data['application_date'] 		= $request->input('application_date');
		$data['loan_type_id'] 			= $request->input('loan_type_id');
		$data['interest'] 				= $request->input('interest');
		$data['loan_amount'] 			= $request->input('loan_amount'); 
		$my_infos 						= $this->emp_info($emp_id);	
		$data['emp_name'] 				= $my_infos['emp_name']; 
		$data['designation_code'] 		= $my_infos['designation_code'];  
		$data['designation_name'] 		= $my_infos['designation_name'];  
		$data['branch_name'] 			= $my_infos['branch_name']; 
		$data['emp_branch'] 			= $my_infos['br_code'];  
		$data['emp_area'] 				= $my_infos['area_code'];  
		$data['emp_zone'] 				= $my_infos['zone_code'];  
		$self_group 					= $my_infos['self_group']; 
		if($data['loan_type_id'] == 7)
		{
			$equipments 				= $request->input('equipments'); 
			$data['equipments'] 		= implode(",", $equipments); 
		}
		$data['loan_purpose'] 			= $request->input('loan_purpose');
		$data['loan_duration'] 			= $request->input('loan_duration'); 
		// BANK
		$data['accounts_holder'] 		= $request->input('accounts_holder'); 
		$data['bank_id'] 				= $request->input('bank_id');
		$data['bank_branch_id'] 		= $request->input('bank_branch_id');
		$data['accounts_number'] 		= $request->input('accounts_number');
		$data['routing_number'] 		= $request->input('routing_number');
		
		$layer 							= 1;
		$data['left_action'] 			= 0; 
		$data['perform_action'] 		= 1;
		if($data['loan_type_id'] == 1)
		{
			$data['application_stage'] 	= 0; // 
			$data['pf_hhr_action'] 		= 1; // 
		}else{
			$data['application_stage'] 	= 1; // 
		}
		$post_actions 					= $request->input('actions');
		$post_actions_remarks 			= $request->input('actions_remarks');
		$post_supervisors_name 			= $request->input('supervisors_name');
		$post_supervisor_designation 	= $request->input('supervisor_designation');
		// INSERT
		$loan_app_id  					= DB::table('emp_loan_applications')->insertGetId($data);	
		$sup['application_id'] 			= $loan_app_id;
		$sup['emp_id'] 					= $emp_id;
		$sup['supervisors_id'] 			= $supervisor_emp_id;
		$sup['actions'] 				= $post_actions;
		$sup['action_date'] 			= date('Y-m-d');
		$sup['actions_remarks'] 		= $post_actions_remarks;
		$sup['supervisors_name']		= $post_supervisors_name;
		$sup['supervisor_designation']	= $post_supervisor_designation;
		$status = DB::table('loan_approval')->insertGetId($sup);		
		if($data['loan_type_id'] == 1) 
		{
			$h_hr 			= DB::table('loan_approval_authority')
								->where('author_role',1)
								->first();										
			if($emp_id != $h_hr->author_emp_id)
			{
				$pf['emp_id'] 					= $emp_id;	 
				$pf['application_id'] 			= $loan_app_id;	 
				$pf['supervisors_id'] 			= $h_hr->author_emp_id;	
				$pf['action_date'] 				= '';
				$pf['actions'] 					= 0;	 
				$pf['actions_remarks'] 			= '';
				$pf['supervisors_name'] 		= $h_hr->author_name;
				$pf['supervisor_designation']	= $h_hr->author_designation;
				$pf_id  						= DB::table('loan_approval')->insertGetId($pf);	
			}
		}
		
		// Mail Fire to Supervisor	
		$supervisor_mail 		= 'nafis@cdipbd.org';
		$emp_id 				= $emp_id; 
		$emp_name_string 		= $request->input('emp_name'); 
		$emp_name 				= str_replace(' ', '-', $emp_name_string);
		$designation_name_string= $request->input('designation_name');
		$designation_name 		= str_replace(' ', '-', $designation_name_string);
		$branch_name_string 	= $request->input('branch_name');
		$branch_name 			= str_replace(' ', '-', $branch_name_string);
		$application_date 		= $request->input('application_date');
		$loan_type_id 			= $request->input('loan_type_id');
		$loan_amount 			= $request->input('loan_amount'); 
		$loan_duration 			= $request->input('loan_duration'); 
		
		//$mail = $this->send_mail($supervisor_mail,$emp_id,$emp_names,$designation_names,$branch_names,$application_date,$loan_type_id,$loan_amount,$loan_duration);
		
		$action['status']  = 1;		
		echo json_encode($action);
	}	
	
	
	public function bellow_bm_application()
	{
		$branch_code 	= Session::get('branch_code');
		$emp_type 		= Session::get('emp_type');
		$user_type 		= Session::get('user_type');
		$area_code 		= Session::get('area_code');
		$zone_code 		= Session::get('zone_code');
		$data['loan_types'] = DB::table('loan_category as l')
			->leftJoin("loan_product as lp", 'lp.category_id', '=', 'l.loan_category_id')
			->select('l.name_bangla','l.loan_category_id', 'l.loan_category_name', 'lp.interest_rate', 'lp.loan_product_id', 'lp.loan_product_name')
			->where('l.status', 1)
			->get();
		$data['banks'] = DB::table('banks')
			->where('bank_status',1)
			->get();
		$data['loan_purpouse'] = DB::table('loan_purpouse')
			->where('category_code',7)
			->get();
			
		$data['my_staffs'] 				= $this->my_staffs_br($branch_code);
		$my_info 						= $this->get_emp($branch_code,$user_type);
		$data['supervisor_emp_id']		= $my_info['emp_id'];
		$data['supervisors_name']		= $my_info['emp_name_eng'];
		$data['supervisor_designation']	= $my_info['designation_name'];
		$data['app_type'] 				= 2;
		$data['action'] 				= '/loan_save';
		//echo '<pre>';
		//print_r($data['my_staffs']);
		return view('admin.my_info.my_loan_my_staff', $data);
	}
	
	
	public function loan_save(Request $request)
	{
		$emp_id 						= $request->input('emp_id');
		$supervisor_emp_id 				= $request->input('supervisor_emp_id');
		$data['emp_id'] 				= $emp_id;
		$data['is_self'] 				= 2;
		$max_id = DB::table('emp_loan_applications')->where('emp_id', $data['emp_id'])->max('emp_app_serial');
		$data['emp_app_serial'] 		= $max_id + 1;
		$data['application_stage'] 		= 0;
		$data['ho_bo'] 					= $request->input('ho_bo'); 
		$data['application_date'] 		= $request->input('application_date');
		$data['loan_type_id'] 			= $request->input('loan_type_id');
		$data['interest'] 				= $request->input('interest');
		$data['loan_amount'] 			= $request->input('loan_amount'); 
		$my_infos 						= $this->emp_info($emp_id);	
		$data['emp_name'] 				= $my_infos['emp_name']; 
		$data['designation_code'] 		= $my_infos['designation_code'];  
		$data['designation_name'] 		= $my_infos['designation_name'];  
		$data['branch_name'] 			= $my_infos['branch_name']; 
		$data['emp_branch'] 			= $my_infos['br_code'];  
		$data['emp_area'] 				= $my_infos['area_code'];  
		$data['emp_zone'] 				= $my_infos['zone_code'];  
		$self_group 					= $my_infos['self_group']; 
		if($data['loan_type_id'] == 7)
		{
			$equipments 				= $request->input('equipments'); 
			$data['equipments'] 		= implode(",", $equipments); 
		}
		$data['loan_purpose'] 			= $request->input('loan_purpose');
		$data['loan_duration'] 			= $request->input('loan_duration'); 
		// BANK
		$data['accounts_holder'] 		= $request->input('accounts_holder'); 
		$data['bank_id'] 				= $request->input('bank_id');
		$data['bank_branch_id'] 		= $request->input('bank_branch_id');
		$data['accounts_number'] 		= $request->input('accounts_number');
		$data['routing_number'] 		= $request->input('routing_number');
		$layer 							= $request->input('layer'); 
		$data['left_action'] 			= 3; 
		$data['perform_action'] 		= 2;
		$post_actions 					= $request->input('actions');
		$post_actions_remarks 			= $request->input('actions_remarks');
		$post_supervisors_name 			= $request->input('supervisors_name');
		$post_supervisor_designation 	= $request->input('supervisor_designation');
		$zone_info 						= DB::table('tbl_zone')
												->where('zone_code',$data['emp_zone'])
												->first();
		if($data['designation_code'] == 16)// Accountant
		{
			$layer 							= 3;
			$data['left_action'] 			= 3; 
			$data['perform_action'] 		= 2;
			$acc_super_info 				= DB::table('loan_approval_authority')
												->where('author_role',9)
												->first();
												
			$data['left_action'] 			= $zone_info->acc_supervisor_id; 
			$data['perform_action'] 		= 1;
			$supervisor_mail_address 		= $zone_info->acc_supervisor_mail;
			// INSERT
			$loan_app_id  					= DB::table('emp_loan_applications')->insertGetId($data);
			for($i=1;$i<=$layer;$i++)
			{
				if($i == 1)
				{
					$supervisors_id 			= $supervisor_emp_id;
					$action_date 				= date('Y-m-d');
					$actions 					= $post_actions;
					$actions_remarks 			= $post_actions_remarks;
					$supervisors_name 			= $post_supervisors_name;
					$supervisor_designation 	= $post_supervisor_designation;
				}elseif($i == 2){
					$supervisors_id 			= $zone_info->acc_supervisor_id;
					$action_date 				= '';
					$actions 					= 0;
					$actions_remarks 			= '';
					$supervisors_name 			= $zone_info->acc_supervisor_name;
					$supervisor_designation 	= $zone_info->acc_supervisor_designation;
				}elseif($i == 3){
					$supervisors_id 			= $acc_super_info->author_emp_id;
					$action_date 				= '';
					$actions 					= 0;
					$actions_remarks 			= '';
					$supervisors_name 			= $acc_super_info->author_name;
					$supervisor_designation 	= $acc_super_info->author_designation;
				}
				$sup['application_id'] 			= $loan_app_id; 
				$sup['emp_id'] 					= $emp_id;
				$sup['supervisors_id'] 			= $supervisors_id;
				$sup['actions'] 				= $actions;
				$sup['action_date'] 			= $action_date;
				$sup['actions_remarks'] 		= $actions_remarks;
				$sup['supervisors_name']		= $supervisors_name;
				$sup['supervisor_designation']	= $supervisor_designation;

				$status = DB::table('loan_approval')->insertGetId($sup);
			}
		}elseif($data['designation_code'] == 173)// SACCMO
		{
			$layer 							= 3;
			$data['left_action'] 			= 2;  //am and dm 
			$data['perform_action'] 		= 2;
			
			
			$area_mail =  DB::table('tbl_area')
									->where('area_code',$data['emp_area'])
									->select('area_email')
									->first();
			$supervisor_mail_address = $area_mail->area_email;
			// INSERT
			$loan_app_id  					= DB::table('emp_loan_applications')->insertGetId($data);
			
			for($i=1;$i<=$layer;$i++)
			{
				if($i == 1)
				{
					$supervisors_id 			= $supervisor_emp_id;
					$action_date 				= date('Y-m-d');
					$actions 					= $post_actions;
					$actions_remarks 			= $post_actions_remarks;
					$supervisors_name 			= $post_supervisors_name;
					$supervisor_designation 	= $post_supervisor_designation; 
				}				
				elseif($i == 2)
				{
					$supervisors_id 			= 0;
					$action_date 				= '';
					$actions 					= 0;
					$actions_remarks 			= '';
					$supervisors_name 			= '';
					$supervisor_designation 	= 'Area Manager'; 
				}elseif($i == 3)
				{
					$supervisors_id 			= 0;
					$action_date 				= '';
					$actions 					= 0;
					$actions_remarks 			= '';
					$supervisors_name 			= '';
					$supervisor_designation 	= 'District Manager'; 
				}
				else{
					$health_super_info 		= DB::table('loan_approval_authority')
												->where('author_role',4)
												->first();
					$supervisors_id 			= $health_super_info->author_emp_id;  
					$action_date 				= '';
					$actions 					= 0;
					$actions_remarks 			= '';
					$supervisors_name 			= $health_super_info->author_name;
					$supervisor_designation 	= $health_super_info->author_designation;
				}
				$sup['application_id'] 			= $loan_app_id; 
				$sup['emp_id'] 					= $emp_id;
				$sup['supervisors_id'] 			= $supervisors_id;
				$sup['actions'] 				= $actions;
				$sup['action_date'] 			= $action_date;
				$sup['actions_remarks'] 		= $actions_remarks;
				$sup['supervisors_name']		= $supervisors_name;
				$sup['supervisor_designation']	= $supervisor_designation;
				$status = DB::table('loan_approval')->insertGetId($sup);
			}
			$health_program_heads 				= DB::table('loan_approval_authority')
												->where('author_role',4)
												->first();
			// Program Head	
			$health_program_head['application_id'] 			= $loan_app_id; 
			$health_program_head['emp_id'] 					= $emp_id;
			$health_program_head['supervisors_id'] 			= $health_program_heads->author_emp_id;
			$health_program_head['actions'] 				= $actions;
			$health_program_head['action_date'] 			= $action_date;
			$health_program_head['actions_remarks'] 		= $actions_remarks;
			$health_program_head['supervisors_name']		= $health_program_heads->author_name;
			$health_program_head['supervisor_designation']	= $health_program_heads->author_designation;
			$health_program_head_status = DB::table('loan_approval')->insertGetId($health_program_head);
		}else{
			// INSERT
			$loan_app_id  	= DB::table('emp_loan_applications')->insertGetId($data);
			$area_mail 		=  DB::table('tbl_area')
								->where('area_code',$data['emp_area'])
								->select('area_email')
								->first();
			$supervisor_mail_address = $area_mail->area_email;
			
			for($i=1;$i<=$layer;$i++)
			{
				if($i == 1)
				{
					$supervisors_id 			= $supervisor_emp_id;
					$action_date 				= date('Y-m-d');
					$actions 					= $post_actions;
					$actions_remarks 			= $post_actions_remarks;
					$supervisors_name 			= $post_supervisors_name;
					$supervisor_designation 	= $post_supervisor_designation;
				}elseif($i == 2)
				{
					$supervisors_id 			= 0;
					$action_date 				= '';
					$actions 					= 0;
					$actions_remarks 			= '';
					$supervisors_name 			= '';
					$supervisor_designation 	= 'Area Manager';
				}elseif($i == 3)
				{
					$supervisors_id 			= 0;
					$action_date 				= '';
					$actions 					= 0;
					$actions_remarks 			= '';
					$supervisors_name 			= '';
					$supervisor_designation 	= 'District Manager';
				}else{
					$supervisors_id 			= $zone_info->program_supervisor_id;
					$action_date 				= '';
					$actions 					= 0;
					$actions_remarks 			= '';
					$supervisors_name 			= $zone_info->program_supervisor_name;
					$supervisor_designation 	= $zone_info->program_supervisor_designatation;
				}
				$sup['application_id'] 			= $loan_app_id;
				$sup['emp_id'] 					= $emp_id;
				$sup['supervisors_id'] 			= $supervisors_id;
				$sup['actions'] 				= $actions;
				$sup['action_date'] 			= $action_date;
				$sup['actions_remarks'] 		= $actions_remarks;
				$sup['supervisors_name']		= $supervisors_name;
				$sup['supervisor_designation']	= $supervisor_designation;
				$status = DB::table('loan_approval')->insertGetId($sup);
			}
		}
		if($data['loan_type_id'] == 1) 
		{
			$h_hr 			= DB::table('loan_approval_authority')
								->where('author_role',1)
								->first();										
			if($emp_id != $h_hr->author_emp_id)
			{
				$pf['emp_id'] 					= $emp_id;	 
				$pf['application_id'] 			= $loan_app_id;	 
				$pf['supervisors_id'] 			= $h_hr->author_emp_id;	
				$pf['action_date'] 				= '';
				$pf['actions'] 					= 0;	 
				$pf['actions_remarks'] 			= '';
				$pf['supervisors_name'] 		= $h_hr->author_name;
				$pf['supervisor_designation']	= $h_hr->author_designation;
				$pf_id  						= DB::table('loan_approval')->insertGetId($pf);	
			}
		}

		// Mail Fire to Supervisor	
		$supervisor_mail 		= $supervisor_mail_address;
		$emp_id 				= $emp_id; 
		$emp_name_string 		= $request->input('emp_name'); 
		$emp_name 				= str_replace(' ', '-', $emp_name_string);
		$designation_name_string= $request->input('designation_name');
		$designation_name 		= str_replace(' ', '-', $designation_name_string);
		$branch_name_string 	= $request->input('branch_name');
		$branch_name 			= str_replace(' ', '-', $branch_name_string);
		$application_date 		= $request->input('application_date');
		$loan_type_id 			= $request->input('loan_type_id');
		$loan_amount 			= $request->input('loan_amount'); 
		$loan_duration 			= $request->input('loan_duration'); 
		//$mail = $this->send_mail($supervisor_mail,$emp_id,$emp_names,$designation_names,$branch_names,$application_date,$loan_type_id,$loan_amount,$loan_duration);
		// Mail		
		$action['status']  = 1;		
		echo json_encode($action);
	}
	
	public function all_loan_application_bellow_bm(Request $request)
	{
		$emp_id 		= Session::get('emp_id');
		$branch_code 	= Session::get('branch_code');
		$columns = array(
			0 => 'emp_app_serial',
			1 => 'emp_name',
			2 => 'emp_id',
			3 => 'designation_name',
			4 => 'application_date',
			5 => 'loan_type_id',
			6 => 'loan_amount',
			7 => 'application_stage'
		);
		$totalData 		= SLoan::where('emp_loan_applications.emp_branch', $branch_code)->where('emp_loan_applications.is_self', 2)->count();
		$totalFiltered 	= $totalData;
		$limit 			= $request->input('length');
		$start 			= $request->input('start');
		$order 			= @$columns[$request->input('order.0.column')];
		$dir 			= $request->input('order.0.dir');
		if (empty($request->input('search.value'))) {
			$infos = SLoan::leftjoin('loan_product', 'loan_product.loan_product_id', '=', 'emp_loan_applications.loan_type_id')
				->offset($start)
				->where('emp_loan_applications.emp_branch', $branch_code)
				->where('emp_loan_applications.is_self', 2)
				->select('emp_loan_applications.*','loan_product.loan_product_name')
				->limit($limit)
				->orderBy('loan_app_id', $dir)
				->get();
		}else {
			$search = $request->input('search.value');
			$infos =  SLoan::leftjoin('loan_product', 'loan_product.loan_product_id', '=', 'emp_loan_applications.loan_type_id')
				->where('emp_loan_applications.emp_branch', $branch_code)
				->where('emp_loan_applications.is_self', 2)
				->where(function ($q) use ($search) {
					$q->where('emp_loan_applications.application_date', 'LIKE', "%{$search}%")
						->orWhere('loan_product.loan_product_name', 'LIKE', "%{$search}%");
				})
				->select('emp_loan_applications.*','loan_product.loan_product_name')
				->offset($start)
				->limit($limit)
				->get();
			$totalFiltered = SLoan::leftjoin('loan_product', 'loan_product.loan_product_id', '=', 'emp_loan_applications.loan_type_id')
				->where('emp_loan_applications.emp_branch', $branch_code)
				->where('emp_loan_applications.is_self', 2)
				->where(function ($q) use ($search) {
					$q->where('emp_loan_applications.application_date', 'LIKE', "%{$search}%")
						->orWhere('loan_product.loan_product_name', 'LIKE', "%{$search}%");
				})
			->count();
		}
		$data = array();
		if (!empty($infos)) {
			$i = 1;
			foreach ($infos as $info) {
				$stages = array(0=>'Pending',1=>'Supervisor',2=>'Approvers',3=>'Finance');

				if($info->application_stage == 0)
				{
					$status = 'Pending';
					$class = 'label label-default';
				}
				elseif($info->application_stage == 1)
				{
					$status = 'Recomended';
					$class = 'label label-warning';
				}elseif($info->application_stage == 2)
				{
					$status = 'Approved';
					$class = 'label label-info';
				}elseif($info->application_stage == 3)
				{
					$status = 'Disbursed';
					$class = 'label label-success';
				}
				if($info->is_reject == 1){
					$status = 'Rejected';
					$class = 'label label-danger';
				}
				$nestedData['sl'] 						= $info->emp_app_serial;
				$nestedData['emp_name'] 				= $info->emp_name;
				$nestedData['emp_id'] 					= $info->emp_id;
				$nestedData['application_date'] 		= date("d-m-Y", strtotime($info->application_date));
				$nestedData['loan_type'] 				= $info->loan_product_name;
				$nestedData['loan_amount'] 				= $info->loan_amount;
				$nestedData['application_stage']		= '<a href="application_location/'.$info->loan_app_id.'"><span class="' . $class . '">' . $status . '<span></a>';
				$nestedData['view']						= '<a class="btn btn-sm btn-success btn-xs" target="_blank" href="my_loan/'.$info->loan_app_id.'"><i class="fa fa-file" aria-hidden="true"></i></a>';
				$nestedData['options'] 					= '<button><i class="fa fa-lock" aria-hidden="true"></i></button>';
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
	
	
	public function all_loan_application_audit(Request $request)
	{
		$emp_id 		= Session::get('emp_id');
		$branch_code 	= Session::get('branch_code');
		$columns = array(
			0 => 'emp_app_serial',
			1 => 'emp_name',
			2 => 'emp_id',
			3 => 'application_date',
			4 => 'loan_type_id',
			5 => 'loan_amount',
			6 => 'application_stage'
		);
		$totalData 		= SLoan::where('emp_loan_applications.emp_branch', $branch_code)->where('emp_loan_applications.is_self', 2)->count();
		$totalFiltered 	= $totalData;
		$limit 			= $request->input('length');
		$start 			= $request->input('start');
		$order 			= @$columns[$request->input('order.0.column')];
		$dir 			= $request->input('order.0.dir');
		if (empty($request->input('search.value'))) {
			$infos = SLoan::leftjoin('loan_product', 'loan_product.loan_product_id', '=', 'emp_loan_applications.loan_type_id')
				->offset($start)
				->where('emp_loan_applications.is_self', 3)
				->select('emp_loan_applications.*','loan_product.loan_product_name')
				->limit($limit)
				->orderBy('loan_app_id', $dir)
				->get();
		}else {
			$search = $request->input('search.value');
			$infos =  SLoan::leftjoin('loan_product', 'loan_product.loan_product_id', '=', 'emp_loan_applications.loan_type_id')
				->where('emp_loan_applications.is_self', 3)
				->where(function ($q) use ($search) {
					$q->where('emp_loan_applications.application_date', 'LIKE', "%{$search}%")
						->orWhere('loan_product.loan_product_name', 'LIKE', "%{$search}%");
				})
				->select('emp_loan_applications.*','loan_product.loan_product_name')
				->offset($start)
				->limit($limit)
				->get();
			$totalFiltered = SLoan::leftjoin('loan_product', 'loan_product.loan_product_id', '=', 'emp_loan_applications.loan_type_id')
				->where('emp_loan_applications.is_self', 3)
				->where(function ($q) use ($search) {
					$q->where('emp_loan_applications.application_date', 'LIKE', "%{$search}%")
						->orWhere('loan_product.loan_product_name', 'LIKE', "%{$search}%");
				})
			->count();
		}
		$data = array();
		if (!empty($infos)) {
			$i = 1;
			foreach ($infos as $info) {
				$stages = array(0=>'Pending',1=>'Supervisor',2=>'Approvers',3=>'Finance');

				if($info->application_stage == 0)
				{
					$status = 'Pending';
					$class = 'label label-default';
				}
				elseif($info->application_stage == 1)
				{
					$status = 'Recomended';
					$class = 'label label-warning';
				}elseif($info->application_stage == 2)
				{
					$status = 'Approved';
					$class = 'label label-info';
				}elseif($info->application_stage == 3)
				{
					$status = 'Disbursed';
					$class = 'label label-success';
				}
				if($info->is_reject == 1){
					$status = 'Rejected';
					$class = 'label label-danger';
				}
				$nestedData['sl'] 						= $info->emp_app_serial;
				$nestedData['emp_name'] 				= $info->emp_name;
				$nestedData['emp_id'] 					= $info->emp_id;
				$nestedData['application_date'] 		= date("d-m-Y", strtotime($info->application_date));
				$nestedData['loan_type'] 				= $info->loan_product_name;
				$nestedData['loan_amount'] 				= $info->loan_amount;
				$nestedData['application_stage']		= '<a href="application_location/'.$info->loan_app_id.'"><span class="label label-warning">Application Location<span><span class="' . $class . '">' . $status . '<span></a>';
				$nestedData['view']						= '<a class="btn btn-sm btn-success btn-xs" target="_blank" href="my_loan/'.$info->loan_app_id.'"><i class="fa fa-file" aria-hidden="true"></i></a>';
				$nestedData['options'] 					= '<button><i class="fa fa-lock" aria-hidden="true"></i></button>';
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
	
	public function all_loan_application_sc(Request $request)
	{
		$emp_id 		= Session::get('emp_id');
		$branch_code 	= Session::get('branch_code');
		$columns = array(
			0 => 'emp_app_serial',
			1 => 'emp_name',
			2 => 'emp_id',
			3 => 'application_date',
			4 => 'loan_type_id',
			5 => 'loan_amount',
			6 => 'application_stage'
		);
		$totalData 		= SLoan::where('emp_loan_applications.emp_branch', $branch_code)->where('emp_loan_applications.is_self', 2)->count();
		$totalFiltered 	= $totalData;
		$limit 			= $request->input('length');
		$start 			= $request->input('start');
		$order 			= @$columns[$request->input('order.0.column')];
		$dir 			= $request->input('order.0.dir');
		if (empty($request->input('search.value'))) {
			$infos = SLoan::leftjoin('loan_product', 'loan_product.loan_product_id', '=', 'emp_loan_applications.loan_type_id')
				->offset($start)
				->where('emp_loan_applications.is_self', 4)
				->select('emp_loan_applications.*','loan_product.loan_product_name')
				->limit($limit)
				->orderBy('loan_app_id', $dir)
				->get();
		}else {
			$search = $request->input('search.value');
			$infos =  SLoan::leftjoin('loan_product', 'loan_product.loan_product_id', '=', 'emp_loan_applications.loan_type_id')
				->where('emp_loan_applications.is_self', 4)
				->where(function ($q) use ($search) {
					$q->where('emp_loan_applications.application_date', 'LIKE', "%{$search}%")
						->orWhere('loan_product.loan_product_name', 'LIKE', "%{$search}%");
				})
				->select('emp_loan_applications.*','loan_product.loan_product_name')
				->offset($start)
				->limit($limit)
				->get();
			$totalFiltered = SLoan::leftjoin('loan_product', 'loan_product.loan_product_id', '=', 'emp_loan_applications.loan_type_id')
				->where('emp_loan_applications.is_self', 4)
				->where(function ($q) use ($search) {
					$q->where('emp_loan_applications.application_date', 'LIKE', "%{$search}%")
						->orWhere('loan_product.loan_product_name', 'LIKE', "%{$search}%");
				})
			->count();
		}
		$data = array();
		if (!empty($infos)) {
			$i = 1;
			foreach ($infos as $info) {
				$stages = array(0=>'Pending',1=>'Supervisor',2=>'Approvers',3=>'Finance');

				if($info->application_stage == 0)
				{
					$status = 'Pending';
					$class = 'label label-default';
				}
				elseif($info->application_stage == 1)
				{
					$status = 'Recomended';
					$class = 'label label-warning';
				}elseif($info->application_stage == 2)
				{
					$status = 'Approved';
					$class = 'label label-info';
				}elseif($info->application_stage == 3)
				{
					$status = 'Disbursed';
					$class = 'label label-success';
				}
				if($info->is_reject == 1){
					$status = 'Rejected';
					$class = 'label label-danger';
				}
				$nestedData['sl'] 						= $info->emp_app_serial;
				$nestedData['emp_name'] 				= $info->emp_name;
				$nestedData['emp_id'] 					= $info->emp_id;
				$nestedData['application_date'] 		= date("d-m-Y", strtotime($info->application_date));
				$nestedData['loan_type'] 				= $info->loan_product_name;
				$nestedData['loan_amount'] 				= $info->loan_amount;
				$nestedData['application_stage']		= '<a href="application_location/'.$info->loan_app_id.'"><span class="' . $class . '">' . $status . '<span></a>';
				$nestedData['view']						= '<a class="btn btn-sm btn-success btn-xs" target="_blank" href="my_loan/'.$info->loan_app_id.'"><i class="fa fa-file" aria-hidden="true"></i>';
				$nestedData['options'] 					= '<button><i class="fa fa-lock" aria-hidden="true"></i></button>';
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
	
	public function all_loan_application_agri(Request $request)
	{
		$emp_id 		= Session::get('emp_id');
		$branch_code 	= Session::get('branch_code');
		$columns = array(
			0 => 'emp_app_serial',
			1 => 'emp_name',
			2 => 'emp_id',
			3 => 'application_date',
			4 => 'loan_type_id',
			5 => 'loan_amount',
			6 => 'application_stage'
		);
		$totalData 		= SLoan::where('emp_loan_applications.emp_branch', $branch_code)->where('emp_loan_applications.is_self', 2)->count();
		$totalFiltered 	= $totalData;
		$limit 			= $request->input('length');
		$start 			= $request->input('start');
		$order 			= @$columns[$request->input('order.0.column')];
		$dir 			= $request->input('order.0.dir');
		if (empty($request->input('search.value'))) {
			$infos = SLoan::leftjoin('loan_product', 'loan_product.loan_product_id', '=', 'emp_loan_applications.loan_type_id')
				->offset($start)
				->where('emp_loan_applications.is_self', 5)
				->select('emp_loan_applications.*','loan_product.loan_product_name')
				->limit($limit)
				->orderBy('loan_app_id', $dir)
				->get();
		}else {
			$search = $request->input('search.value');
			$infos =  SLoan::leftjoin('loan_product', 'loan_product.loan_product_id', '=', 'emp_loan_applications.loan_type_id')
				->where('emp_loan_applications.is_self', 5)
				->where(function ($q) use ($search) {
					$q->where('emp_loan_applications.application_date', 'LIKE', "%{$search}%")
						->orWhere('loan_product.loan_product_name', 'LIKE', "%{$search}%");
				})
				->select('emp_loan_applications.*','loan_product.loan_product_name')
				->offset($start)
				->limit($limit)
				->get();
			$totalFiltered = SLoan::leftjoin('loan_product', 'loan_product.loan_product_id', '=', 'emp_loan_applications.loan_type_id')
				->where('emp_loan_applications.is_self', 5)
				->where(function ($q) use ($search) {
					$q->where('emp_loan_applications.application_date', 'LIKE', "%{$search}%")
						->orWhere('loan_product.loan_product_name', 'LIKE', "%{$search}%");
				})
			->count();
		}
		$data = array();
		if (!empty($infos)) {
			$i = 1;
			foreach ($infos as $info) {
				$stages = array(0=>'Pending',1=>'Supervisor',2=>'Approvers',3=>'Finance');

				if($info->application_stage == 0)
				{
					$status = 'Pending';
					$class = 'label label-default';
				}
				elseif($info->application_stage == 1)
				{
					$status = 'Recomended';
					$class = 'label label-warning';
				}elseif($info->application_stage == 2)
				{
					$status = 'Approved';
					$class = 'label label-info';
				}elseif($info->application_stage == 3)
				{
					$status = 'Disbursed';
					$class = 'label label-success';
				}
				if($info->is_reject == 1){
					$status = 'Rejected';
					$class = 'label label-danger';
				}
				$nestedData['sl'] 						= $info->emp_app_serial;
				$nestedData['emp_name'] 				= $info->emp_name;
				$nestedData['emp_id'] 					= $info->emp_id;
				$nestedData['application_date'] 		= date("d-m-Y", strtotime($info->application_date));
				$nestedData['loan_type'] 				= $info->loan_product_name;
				$nestedData['loan_amount'] 				= $info->loan_amount;
				$nestedData['application_stage']		= '<a href="application_location/'.$info->loan_app_id.'"><span class="' . $class . '">' . $status . '<span></a>';
				$nestedData['view']						= '<a class="btn btn-sm btn-success btn-xs" target="_blank" href="my_loan/'.$info->loan_app_id.'"><i class="fa fa-file" aria-hidden="true"></i>';
				$nestedData['options'] 					= '<button><i class="fa fa-lock" aria-hidden="true"></i></button>';
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
	
	
	public function index(Request $request)
	{
		$branch_code 	= Session::get('branch_code');
		$emp_type 		= Session::get('emp_type');
		$user_type 		= Session::get('user_type');
		$area_code 		= Session::get('area_code');
		$zone_code 		= Session::get('zone_code');

		if($branch_code == 9999)
		{
			$emp_id = Session::get('emp_id');
		}else{
			$get_employee = $this->get_emp($branch_code,$user_type);
			$emp_id = $get_employee['emp_id'];
			Session::put( 'emp_id', $emp_id );
		}

		$data = array();
		$data['emp_id'] = $emp_id;
		$loanData = DB::table('loan as l')
			->leftJoin("loan_product as lp", 'lp.loan_product_id', '=', 'l.loan_product_code')
			->leftJoin('tbl_emp_basic_info as emp', 'l.emp_id', '=', 'emp.emp_id')
			->where('l.emp_id', $emp_id)
			->orderBy('l.loan_id', 'Desc')
			->select('emp.emp_name_eng', 'lp.loan_product_name', 'l.loan_id', 'l.application_date', 'l.loan_code', 'l.disbursement_date', 'l.first_repayment_date', 'l.emp_id', 'l.loan_amount','l.loan_status')
			->get();

		$data['loan_types'] = DB::table('loan_category as l')
			->leftJoin("loan_product as lp", 'lp.category_id', '=', 'l.loan_category_id')
			->select('l.name_bangla','l.loan_category_id', 'l.loan_category_name', 'lp.interest_rate', 'lp.loan_product_id', 'lp.loan_product_name')
			->where('l.status', 1)
			->get();
			
		$data['banks'] = DB::table('banks')
			->where('bank_status',1)
			->get();
			
		$data['loan_purpouse'] = DB::table('loan_purpouse')
			->where('category_code',7)
			->get();
			
		$my_infos = $this->emp_info($emp_id);
		
		if($my_infos['br_code'] == 9999)
		{
			$supervisors = DB::table('supervisor_mapping_ho as mapping')
					->leftJoin('supervisors as supervisor', 'supervisor.supervisors_emp_id', '=', 'mapping.supervisor_id')
					->leftJoin('tbl_designation as designation', 'designation.designation_code', '=', 'supervisor.designation_code')
					->where('mapping.emp_id', $emp_id)
					->select('supervisor.supervisors_name', 'mapping.supervisor_id', 'designation.designation_name','mapping.supervisor_type')
					->orderBy('mapping.mapping_id', 'desc')
					->get();
			$s = 1; 
			foreach($supervisors as $supervisor)
			{
				if($supervisor->supervisor_type == 1)
				{
					$data['report_to'] 		= $supervisor->supervisor_id;
					$data['report_to_show'] = $supervisor->designation_name . ' [ ' . $supervisor->supervisor_id . ' (' . $supervisor->supervisors_name . ') ' . ' ]';
				}
				$data['layer'] 			= $s;
				$s ++; 
			}
			$data['ho_bo'] 			= 1; 
		}else{
			$data['report_to'] 		= 0;
			$supervisor_info 		= $this->branch_supervisor_mapping($my_infos['designation_code']);
			$data['report_to_show'] = $supervisor_info['reported_to'];
			$data['layer'] 			= $supervisor_info['layer']; 
			$data['ho_bo'] 			= 2; 
		}
		$data['emp_name'] 			= $my_infos['emp_name']; 
		$data['designation_code'] 	= $my_infos['designation_code']; 
		$data['designation_name'] 	= $my_infos['designation_name']; 
		$data['branch_name'] 		= $my_infos['branch_name']; 
		$data['loanData'] 			= $loanData; 
		return view('admin.my_info.my_loan', $data);
	}
	

	public function all_loan_application(Request $request)
	{
		$emp_id 	= Session::get('emp_id');
		$columns = array(
			0 => 'emp_app_serial',
			1 => 'application_date',
			2 => 'loan_type_id',
			3 => 'loan_amount',
			4 => 'application_stage'
		);
		$totalData 		= SLoan::where('emp_id', $emp_id)->count();
		$totalFiltered 	= $totalData;
		$limit 			= $request->input('length');
		$start 			= $request->input('start');
		$order 			= @$columns[$request->input('order.0.column')];
		$dir 			= $request->input('order.0.dir');
		if (empty($request->input('search.value'))) {
			$infos = SLoan::leftjoin('loan_product', 'loan_product.loan_product_id', '=', 'emp_loan_applications.loan_type_id')
				->offset($start)
				->where('emp_loan_applications.emp_id', $emp_id)
				->select('emp_loan_applications.*','loan_product.loan_product_name')
				->limit($limit)
				//->orderBy($order, $dir)
				->orderBy('loan_app_id', $dir)
				->get();
		}else {
			$search = $request->input('search.value');
			$infos =  SLoan::leftjoin('loan_product', 'loan_product.loan_product_id', '=', 'emp_loan_applications.loan_type_id')
				->where('emp_loan_applications.emp_id', $emp_id)
				->where(function ($q) use ($search) {
					$q->where('emp_loan_applications.application_date', 'LIKE', "%{$search}%")
						->orWhere('loan_product.loan_product_name', 'LIKE', "%{$search}%");
				})
				->select('emp_loan_applications.*','loan_product.loan_product_name')
				->offset($start)
				->limit($limit)
				//->orderBy($order, $dir)
				->orderBy('loan_app_id', $dir)
				->get();
			$totalFiltered = SLoan::leftjoin('loan_product', 'loan_product.loan_product_id', '=', 'emp_loan_applications.loan_type_id')
				->where('emp_loan_applications.emp_id', $emp_id)
				->where(function ($q) use ($search) {
					$q->where('emp_loan_applications.application_date', 'LIKE', "%{$search}%")
						->orWhere('loan_product.loan_product_name', 'LIKE', "%{$search}%");
				})
			->count();
		}
		$data = array();
		if (!empty($infos)) {
			$i = 1;
			foreach ($infos as $info) {
				$stages = array(0=>'Pending',1=>'Supervisor',2=>'Approvers',3=>'Finance');

				if($info->application_stage == 0)
				{
					$status = 'Pending';
					$class = 'label label-default';
				}
				elseif($info->application_stage == 1)
				{
					$status = 'Recomended';
					$class = 'label label-warning';
				}elseif($info->application_stage == 2)
				{
					$status = 'Approved';
					$class = 'label label-info';
				}elseif($info->application_stage == 3)
				{
					$status = 'Disbursed';
					$class = 'label label-success';
				}
				if($info->is_reject == 1){
					$status = 'Rejected';
					$class = 'label label-danger';
				}
				$nestedData['sl'] 						= $info->emp_app_serial;
				$nestedData['application_date'] 		= date("d-m-Y", strtotime($info->application_date));
				$nestedData['loan_type'] 				= $info->loan_product_name;
				$nestedData['loan_amount'] 				= $info->loan_amount;
				$nestedData['application_stage']		= '<a href="application_location/'.$info->loan_app_id.'"><span class="' . $class . '">' . $status . '<span></a>';
				$nestedData['view']						= '<a class="btn btn-sm btn-success btn-xs" target="_blank" href="my_loan/'.$info->loan_app_id.'"><i class="fa fa-file" aria-hidden="true"></i>';
				$nestedData['options'] 					= '<button><i class="fa fa-lock" aria-hidden="true"></i></button>';
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
	
	public function store(Request $request)
	{
		$emp_id 	= $request->input('emp_id');
		$ed 		= DB::table('loan_approval_authority')
										->where('author_role',10)
										->first();
		if($emp_id == $ed->author_emp_id) // ED 
		{
			$data['emp_id'] 				= $emp_id;
			$chairman						= DB::table('loan_approval_authority')
												->where('author_role',12)
												->first();
			$max_id = DB::table('emp_loan_applications')->where('emp_id', $data['emp_id'])->max('emp_app_serial');
			$data['emp_app_serial'] 		= $max_id + 1;
			$data['application_stage'] 		= 3;
			$data['ho_bo'] 					= $request->input('ho_bo'); 
			$data['emp_name'] 				= $request->input('emp_name'); 
			$data['designation_code'] 		= $request->input('designation_code');
			$data['designation_name'] 		= $request->input('designation_name');
			$data['branch_name'] 			= $request->input('branch_name');
			$data['application_date'] 		= $request->input('application_date');
			$data['loan_type_id'] 			= $request->input('loan_type_id');
			$data['interest'] 				= $request->input('interest');
			$data['loan_amount'] 			= $request->input('loan_amount'); 
			$data['is_self'] 				= 1; 
			if($data['loan_type_id'] == 7)
			{
				$equipments 				= $request->input('equipments');
				$data['equipments'] 		= implode(",", $equipments); 
			}
			if($data['loan_type_id'] == 1)
			{
				$data['approvers_name'] 		= $chairman->author_name;
				$data['approvers_designation'] 	= $chairman->author_designation;
				$data['approvers_id'] 			= $chairman->author_emp_id;
				$data['approve_date'] 			= date('Y-m-d');
				$data['approve_action'] 		= 1;
				$data['approve_remarks'] 		= 'Approved';
				$data['pf_hhr_action'] 			= 2;
			}
			$data['loan_purpose'] 			= $request->input('loan_purpose');
			$data['loan_duration'] 			= $request->input('loan_duration'); 
			// BANK
			$data['accounts_holder'] 		= $request->input('accounts_holder'); 
			$data['bank_id'] 				= $request->input('bank_id');
			$data['bank_branch_id'] 		= $request->input('bank_branch_id');
			$data['accounts_number'] 		= $request->input('accounts_number');
			$data['routing_number'] 		= $request->input('routing_number'); 
			//
			$data['emp_branch'] 			= Session::get('branch_code');
			$data['emp_area'] 				= Session::get('area_code');
			$data['emp_zone'] 				= Session::get('zone_code');
			
			$data['left_action'] 			= 0;
			$data['perform_action'] 		= 1;
			// INSERT INTO APPLICATION
			$loan_app_id  					= DB::table('emp_loan_applications')->insertGetId($data);			
			// APPROVAL
			$approval['application_id'] 		= $loan_app_id;
			$approval['emp_id'] 				= $emp_id;
			$approval['supervisors_id'] 		= $chairman->author_emp_id;
			$approval['action_date'] 			= date('Y-m-d');
			$approval['supervisors_name'] 		= $chairman->author_name;
			$approval['supervisor_designation'] = $chairman->author_designation;
			$approval['actions'] 				= 1;
			$approval['actions_remarks'] 		= 'Recomended';
			$status 							= DB::table('loan_approval')->insertGetId($approval);
			
		}else{ // OTHERS STAFF of SELF CARE 
		
			$data['emp_id'] 				= $emp_id;
			$max_id = DB::table('emp_loan_applications')->where('emp_id', $data['emp_id'])->max('emp_app_serial');
			$data['emp_app_serial'] 		= $max_id + 1;
			$data['application_stage'] 		= 0;
			$data['ho_bo'] 					= $request->input('ho_bo'); 
			$data['is_self'] 				= 1; 
			$data['emp_name'] 				= $request->input('emp_name'); 
			$data['designation_code'] 		= $request->input('designation_code');
			$data['designation_name'] 		= $request->input('designation_name');
			$data['branch_name'] 			= $request->input('branch_name');
			$data['application_date'] 		= $request->input('application_date');
			$data['loan_type_id'] 			= $request->input('loan_type_id');
			$data['loan_amount'] 			= $request->input('loan_amount'); 
			if($data['loan_type_id'] == 7)
			{
				$equipments 				= $request->input('equipments');
				$data['equipments'] 		= implode(",", $equipments); 
			}
			$data['loan_purpose'] 			= $request->input('loan_purpose');
			$data['loan_duration'] 			= $request->input('loan_duration'); 
			// BANK
			$data['accounts_holder'] 		= $request->input('accounts_holder'); 
			$data['bank_id'] 				= $request->input('bank_id');
			$data['bank_branch_id'] 		= $request->input('bank_branch_id');
			$data['accounts_number'] 		= $request->input('accounts_number');
			$data['routing_number'] 		= $request->input('routing_number');
			//
			$data['emp_branch'] 			= Session::get('branch_code');
			$data['emp_area'] 				= Session::get('area_code');
			$data['emp_zone'] 				= Session::get('zone_code');
			$layer 							= $request->input('layer'); 
			$total_action 					= array('4'=>1,'3'=>2,'2'=>3,'1'=>4);
			$data['left_action'] 			= $layer;
			if($data['emp_branch'] == 9999){
				$data['perform_action'] 	= 0;
			}else{
				$data['perform_action'] 	= array_search($layer,$total_action);
			}
			// INSERT
			$loan_app_id  					= DB::table('emp_loan_applications')->insertGetId($data);
			if($data['emp_branch'] == 9999)
			{
				$supervisors = DB::table('supervisor_mapping_ho as m')
								->leftJoin('supervisors as s', 's.supervisors_emp_id', '=', 'm.supervisor_id')
								->leftJoin('tbl_designation as d', 'd.designation_code', '=', 's.designation_code')
								->where('m.emp_id',$emp_id)
								->select('m.*','s.supervisors_name','s.supervisors_email','d.designation_name')
								->orderBy('m.supervisor_type', 'Desc')
								->get();
				$i=0; foreach($supervisors as $supervisor)
				{
					if($i == 0)
					{
						$supervisor_mail_address 	= $supervisor->supervisors_email;
					}
					$sup['application_id'] 			= $loan_app_id;
					$sup['emp_id'] 					= $emp_id;
					$sup['supervisors_id'] 			= $supervisor->supervisor_id;
					$sup['supervisors_name'] 		= $supervisor->supervisors_name;
					$sup['supervisor_designation'] 	= $supervisor->designation_name;
					$sup['action_date'] 			= '';
					$sup['actions'] 				= 0;
					$sup['actions_remarks'] 		= '';
					$status 						= DB::table('loan_approval')->insertGetId($sup);
					$i++;
				}
			}else{
				for($i=1;$i<=$layer;$i++)
				{
					if($i == 3)
					{
						$supervisor_designation = 'Area Manager';
					}elseif($i == 2)
					{
						$supervisor_designation = 'District Manager';
					}elseif($i == 1)
					{
						$supervisor_designation = 'Program Coordinator';
					}
					$sup['application_id'] 			= $loan_app_id;
					$sup['emp_id'] 					= $emp_id;
					$sup['supervisors_id'] 			= 0;
					$sup['supervisors_name'] 		= '';
					$sup['supervisor_designation'] 	= $supervisor_designation;
					$sup['action_date'] 			= '';
					$sup['actions'] 				= 0;
					$sup['actions_remarks'] 		= '';
					$status 						= DB::table('loan_approval')->insertGetId($sup);
				}
				
				// Mail Fire to Supervisor	
				$emp_branch 			= Session::get('branch_code');
				$emp_area 				= Session::get('area_code');
				$emp_zone 				= Session::get('zone_code');
				$layer 					= $request->input('layer'); 
				if($layer == 4)
				{
					$branch_mail =  DB::table('tbl_branch')
									->where('br_code',$emp_branch)
									->select('branch_email')
									->first();
					$supervisor_mail_address = $branch_mail->branch_email;
					
				}else if($layer == 3)
				{
					$area_mail =  DB::table('tbl_area')
									->where('area_code',$emp_area)
									->select('area_email')
									->first();
					$supervisor_mail_address = $area_mail->area_email;
					
				}else if($layer == 2) 
				{
					$zone_mail =  DB::table('tbl_zone')
									->where('zone_code',$emp_zone)
									->select('zone_email')
									->first();
					$supervisor_mail_address = $zone_mail->zone_email;
				}else if($layer == 1)
				{
					$pc_mail =  DB::table('tbl_zone')
									->where('zone_code',$emp_zone)
									->select('program_supervisor_mail')
									->first();				
					$supervisor_mail_address = $pc_mail->program_supervisor_mail;
				}
				// Supervisor
			}
			if($data['loan_type_id'] == 1) 
			{
				$h_hr 			= DB::table('loan_approval_authority')
									->where('author_role',1)
									->first();										
				if($emp_id != $h_hr->author_emp_id)
				{
					$pf['emp_id'] 					= $emp_id;	 
					$pf['application_id'] 			= $loan_app_id;	 
					$pf['supervisors_id'] 			= $h_hr->author_emp_id;	
					$pf['action_date'] 				= '';
					$pf['actions'] 					= 0;	 
					$pf['actions_remarks'] 			= '';
					$pf['supervisors_name'] 		= $h_hr->author_name;
					$pf['supervisor_designation']	= $h_hr->author_designation;
					$pf_id  						= DB::table('loan_approval')->insertGetId($pf);	
				}
			}
		}
		

		// Mail Fire to Supervisor	
		$supervisor_mail 		= $supervisor_mail_address;
		$emp_id 				= $emp_id; 
		$emp_name_string 		= $request->input('emp_name'); 
		$emp_name 				= str_replace(' ', '-', $emp_name_string);
		$designation_name_string= $request->input('designation_name');
		$designation_name 		= str_replace(' ', '-', $designation_name_string);
		$branch_name_string 	= $request->input('branch_name');
		$branch_name 			= str_replace(' ', '-', $branch_name_string); 
		$application_date 		= $request->input('application_date');
		$loan_type_id 			= $request->input('loan_type_id');
		$loan_amount 			= $request->input('loan_amount'); 
		$loan_duration 			= $request->input('loan_duration'); 
		$mail = $this->send_mail($supervisor_mail,$emp_id,$emp_name,$designation_name,$branch_name,$application_date,$loan_type_id,$loan_amount,$loan_duration);
		// Mail
		$action['status']  = 1;	
		echo json_encode($action);
	}
	
	public function edit($id)
	{
		echo $id;
		echo '<h1>Under Construction</h1>';
	}	
	
	public function show($id)
	{
		$data=array();	
		$data['info'] = DB::table('emp_loan_applications as ap')
				->leftJoin('tbl_emp_basic_info as e', 'ap.emp_id', '=', 'e.emp_id')
				->leftJoin('loan_product as lp', 'ap.loan_type_id', '=', 'lp.loan_product_id')	
				->leftJoin('tbl_branch as b', 'ap.emp_branch', '=', 'b.br_code')	
				->leftjoin('banks as bnk', 'bnk.bank_id', '=', 'ap.bank_id')					
				->leftjoin('bank_branches as bbr', 'bbr.branch_id', '=', 'ap.bank_branch_id')		
				->where('loan_app_id',$id)
				->select('ap.*','bbr.bank_branch_name','bnk.bank_name','e.emp_name_eng','b.branch_name','lp.loan_product_name','e.father_name','e.org_join_date','e.permanent_add','e.present_add','lp.product_name_bangla')
				->first(); 
				
		$data['salary_info'] = DB::table('tbl_emp_salary')	
				->where('emp_id',$data['info']->emp_id)
				->orderBy('id', 'desc')
				->select('gross_total')
				->first();
				
		$data['previous_loan_info'] = DB::table('loan as ap')
								->leftJoin('loan_product as lp', 'ap.loan_product_code', '=', 'lp.loan_product_id')	
								->where('ap.emp_id',$data['info']->emp_id)
								->select('ap.*','lp.loan_product_name')
								->get();								
		//echo '<pre>';						
		//print_r($data['info']);
		//exit;					
		return view('admin.my_info.loan_application_view',$data);
	}


	public function loan_product_info($loan_product_id)
    {  
		$loanProductInfo=array();
		$emp_id = Session::get('emp_id');
		$prv_infos 	= DB::table('loan')
					->where('emp_id',$emp_id)
					->where('loan_product_code',$loan_product_id)
					->orderBy('loan_id', 'desc')
					->first();
		if($prv_infos) 
		{
			$times = 2;	
		}else{
			$times = 1;
		}		
		$infos 	= DB::table('loan_product')
					->where('loan_product_id',$loan_product_id)
					->first();
		if($times == 2)
		{
			$loanProductInfo['interest_rate'] = $infos->int_rate_next;	
		}else{
			$loanProductInfo['interest_rate'] = $infos->interest_rate;	
		}
		$mim_tenore = $infos->min_installment; 
		$max_tenore = $infos->max_installment; 
		$loanProductInfo['options']='';
		for($m =$mim_tenore; $m<=$max_tenore;$m++) {
			$loanProductInfo['options'].= "<option value='".$m."'> $m Months</option>";
		}
		echo json_encode($loanProductInfo);
    }

	public function loan_product_infos($loan_product_id,$emp_id)
    {  
		$loanProductInfo=array();
		$prv_infos 	= DB::table('loan')
					->where('emp_id',$emp_id)
					->where('loan_product_code',$loan_product_id)
					->orderBy('loan_id', 'desc')
					->first();
		if($prv_infos) 
		{
			$times = 2;	
		}else{
			$times = 1;
		}		
		$infos 	= DB::table('loan_product')
					->where('loan_product_id',$loan_product_id)
					->first();
		if($times == 2)
		{
			$loanProductInfo['interest_rate'] = $infos->int_rate_next;	
		}else{
			$loanProductInfo['interest_rate'] = $infos->interest_rate;	
		}
		$mim_tenore = $infos->min_installment; 
		$max_tenore = $infos->max_installment; 
		$loanProductInfo['options']='';
		for($m =$mim_tenore; $m<=$max_tenore;$m++) {
			$loanProductInfo['options'].= "<option value='".$m."'> $m Months</option>";
		}
		echo json_encode($loanProductInfo);
    }	
	
	public function banks_branch($bank_id)
    {  
		$branches = DB::table('bank_branches')
							->where('bank_id',$bank_id)
							->get();
		echo "<option value='' hidden>--SELECT--</option>";
		foreach($branches as $branch){
			echo "<option value='$branch->branch_id'>$branch->bank_branch_name</option>";
		}
    }
	
	
	public function application_validation($application_date,$emp_id,$loan_type_id,$loan_amount,$loan_duration)
	{
		$today 						= date('Y-m-d');
		$prayer_loan_amount 		= $loan_amount; 
		$prayer_loan_tenore 		= $loan_duration; 
		// LOAN INFORMATION
		$emp_is_running_loan = $this->loan_info($emp_id,$loan_type_id);
		// EMP Update Informations
		$my_infos = $this->emp_info($emp_id);						
		if($my_infos['is_permanent'] == 2)
		{
			$today 						= date('Y-m-d');
			$permanent_date 			= date('Y-m-d',strtotime($my_infos['permanent_date'] . "+1 days"));
			$starts_date 				= new DateTime($today);
			$permanent_dates			= new DateTime($permanent_date);	
			$difference 				= date_diff($permanent_dates, $starts_date);
			$service_length 			= $difference->y . " years, " . $difference->m." months"; 
			$emp_duration_of_includ_pf 	= ($difference->y * 12)+$difference->m;
			$emp_is_permanent			= $my_infos['is_permanent'];
		}else{
			$emp_duration_of_includ_pf 	= 0;
			$emp_is_permanent			= 1;
		}
		$todays 				= new DateTime(date('Y-m-d'));
		$org_date 				= new DateTime($my_infos['org_join_date']);
		$different 				= date_diff($org_date, $todays);
		$service_length_month 	= ($different->y*12 + $different->m);		
		// PF INFORMATION 
		$pf_info 				= DB::table('pf_register')	
									->where('emp_id',$emp_id)
									->orderBy('pf_register_id', 'Desc')  
									->first();	
		if($pf_info)
		{
			$pf_fund_self 	  = $pf_info->closing_balance_staff;
			$pf_fund_self_org = $pf_info->closing_balance_org;
		}else{
			$pf_fund_self 	  = 0;
			$pf_fund_self_org = 0;
		}
		$self_org = $pf_fund_self + $pf_fund_self_org;
		//
		$validation_working_station		= 3; // 1=HO,2=BO,3=Both
		$validation_is_permanent    	= 2; // 1=Probation,2=Permanent

		if($loan_type_id == 1)
		{
				if($prayer_loan_amount<=300000)
				{
					$validation_min_duration		= 12;
					$validation_max_duration		= 36;
				}elseif($prayer_loan_amount > 300000)
				{
					$validation_min_duration		= 12;
					$validation_max_duration		= 60;			
				}

				if($emp_duration_of_includ_pf < 36)
				{
					$max_loan_amount = round(($pf_fund_self*80)/100);	//80% of self fund (principal)
				}elseif($emp_duration_of_includ_pf > 36 && $emp_duration_of_includ_pf < 120)
				{
					$max_loan_amount = 	round(($self_org*80)/100);//80% of self + ORG fund (principal)
				}elseif($emp_duration_of_includ_pf >= 120)
				{
					$max_loan_amount = round(($self_org*90)/100);	// 90% of self + ORG fund (principal)
				}

				//Permanent Validation//
				if($emp_is_permanent != $validation_is_permanent)
				{
					$flag_1 	= 1;
					$messge[] = 'শুধু স্থায়ী কর্মীর জন্য প্রযোজ্য।  ';
				}else{
					$flag_1 	= 0;
					$messge[] = '';
				}

				//Exist Loan Validation//
				if($emp_is_running_loan == 0)
				{
					$flag_2 	= 0;
					$messge[] 	= '';
				}else{
					$flag_2 	= 1;
					$messge[] 	= 'পূর্বের লোন চলমান। ';
				}
				
				//Amount Validation//
				if($prayer_loan_amount > $max_loan_amount)
				{
					$flag_3 	= 1;
					$messge[] 	= 'এই পরিমান টাকার জন্য উপযুক্ত না। ';  //$max_loan_amount; //;
				}
				else{
					$flag_3 	= 0;
					$messge[] 	= '';
				}

				//Duration Validation MIN //
				if($validation_min_duration > $prayer_loan_tenore)
				{
					$flag_4 	= 1;
					$messge[] = 'Invalid Duration(Small)';
				}
				else{
					$flag_4 	= 0;
					$messge[] = '';
				}		
				
				//Duration Validation MAX //
				if($validation_max_duration < $prayer_loan_tenore)
				{
					$flag_5 	= 1;
					$messge[] = 'Invalid Duration(Big)';
				}
				else{
					$flag_5 	= 0;
					$messge[] = '';
				}
				$flag_6 	= 0;
				$messge[] 	= '';
		}
		elseif($loan_type_id == 7)//Equipment Loan
		{

			if($emp_is_permanent != $validation_is_permanent)
			{
				$flag_1 	= 1;
				$messge[] = 'শুধু স্থায়ী কর্মীর জন্য প্রযোজ্য।  '; 
			}else{
				$flag_1 	= 0;
				$messge[] = '';
			}
			
			//Exist Loan Validation//
			if($emp_is_running_loan == 0)
			{
				$flag_2 	= 0;
				$messge[] 	= '';
			}else{
				$flag_2 	= 1;
				$messge[] 	= 'পূর্বের লোন চলমান। ';
			}
			$pf_amount 		 = $this->pf_amounts($emp_id);
			$gratuity_amount = $this->gratuity_amount($emp_id,$my_infos['org_join_date']);
			$pf_gra = $pf_amount + $gratuity_amount;
			$max_amount 	= 50000;
			if($prayer_loan_amount >$pf_gra)
			{
				$flag_3 	= 1;
				$messge[] 	= 'পিএফ এবং গ্রাইচুইটি তে সমপরিমাণ টাকা নাই। '; 
			}else{
				$flag_3 	= 0;
				$messge[] 	= '';
			}
		
			$loan_paid_duration = $this->loan_paid_status($emp_id,$loan_type_id);
			if($loan_paid_duration < 24 && $loan_paid_duration != 475)
			{
				$flag_4 	= 1;
				$messge[] 	= 'আগের লোন পরিশোধের ২ বছর হয় নাই। অপেক্ষা করুন। ';
			}else{
				$flag_4 	= 0;
				$messge[] 	= ''; 
			}
			
			if($prayer_loan_amount >$max_amount) 
			{
				$flag_5 	= 1;
				$messge[] 	= ' সর্বোচ্চ আবেদন ৫০,০০০ হাজার। ';
			}else{
				$flag_5 	= 0;
				$messge[] 	= '';
			}
			$flag_6 	= 0;
			$messge[] 	= '';
		}
		elseif($loan_type_id == 4)//Motorcycle Loan
		{
			if($emp_is_permanent == $validation_is_permanent)
			{
				$flag_1 	= 0;
				$messge[] = '';
			}elseif($service_length_month > 5)
			{
				$flag_1 	= 0;
				$messge[] = '';
			}else{
				$flag_1 	= 1;
				$messge[] 	=  $service_length_month; 'শুধু স্থায়ী কর্মীর জন্য প্রযোজ্য। ';
			}
			//Exist Loan Validation//
			if($emp_is_running_loan == 0)
			{
				$flag_2 	= 0;
				$messge[] 	= '';
			}else{
				$flag_2 	= 1;
				$messge[] = 'পূর্বের লোন চলমান।';
			}
			
			//Branch Loan Validation//
			if($my_infos['br_code'] == 9999)
			{
				$flag_3 	= 1;
				$messge[] 	= 'শুধু ব্রাঞ্চ এর কর্মীর জন্য প্রযোজ্য। '; 
			}else{
				$flag_3 	= 0;
				$messge[]   = '';
			}
			//Driving Lisence Validation//
			$license_info = DB::table('tbl_edms_driver_license')	
							->where('emp_id',$emp_id)
							->where('license_exp_date','>',$today)
							->first();
			if($license_info)
			{
				$flag_4 	= 0;
				$messge[] 	= '';
			}else{
				$flag_4 	= 1;
				$messge[]   = 'বৈধ ড্রাইভিং লাইসেন্স নাই। ';
			}
			$dms = array(209,211,244,253,255);
			if(in_array($my_infos['designation_code'], $dms))
			{
				$flag_5 	= 1;
				$messge[] 	= 'আপনার পদবির জন্য প্রযোজ্য নয়। ';
			}
			else
			{
				$flag_5 	= 0;
				$messge[] 	= '';
			}
			
			$max_amount 	= 100000;
			if($prayer_loan_amount >$max_amount)
			{
				$flag_6 	= 1;
				$messge[] 	= ' সর্বোচ্চ আবেদন ১০০০০০ হাজার। ';
			}else{
				$flag_6 	= 0;
				$messge[] 	= '';
			}
		}elseif($loan_type_id == 5) // Bicycle
		{
			$allowed_designation = array(11,192,226,16,170);
			if (in_array($my_infos['designation_code'], $allowed_designation))
			{
				$flag_1 	= 0;
				$messge[] 	= '';
			}
			else
			{
				$flag_1 	= 1;
				$messge[] 	= 'আপনার পদবির জন্য প্রযোজ্য নয়। ';
			}			
			
			if($service_length_month > 1)
			{
				$flag_2 	= 0;
				$messge[] 	= '';
			}
			else
			{
				$flag_2 	= 1;
				$messge[] 	= 'আপনার জন্য প্রযোজ্য নয়।( চাকরির বয়স) । '; 
			}
			$loan_paid_duration = $this->loan_paid_status($emp_id,$loan_type_id);
			if($loan_paid_duration < 36)
			{
				$flag_3 	= 1;
				$messge[] 	= 'আগের লোন পরিশোধের ০৩ বছর হয় নাই। অপেক্ষা করুন। ';
			}else{
				$flag_3 	= 0;
				$messge[] 	= '';
			}
			$flag_4 	= 0;
			$messge[] 	= '';
			$flag_5 	= 0;
			$messge[] 	= '';
			$flag_6 	= 0;
			$messge[] 	= '';
		}
		
		$flags 	= $flag_1 + $flag_2 + $flag_3 + $flag_4 + $flag_5 + $flag_6;
		
		if($flags >0)
		{
			return $messge;
		}else{
			$messge = 0;
			return $messge;
		}
	}
	
	
	private function loan_info($emp_id,$loan_product_code)
	{
		$loan_info = DB::table('loan as l')	
				->where('l.emp_id',$emp_id)
				->where('l.loan_product_code',$loan_product_code)
				->where('l.loan_status',1)
				->select('l.loan_id')
				->first();
		if($loan_info)
		{
			$emp_is_is_running_loan 	= 1; 
		}else{
			$emp_is_is_running_loan 	= 0; 
		}
		return $emp_is_is_running_loan;
	}
	
	private function gratuity_amount($emp_id, $org_join_date)
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
		$gra_amt_year  = $emp_salary->salary_basic * $gratuity->point * $gratuity_year;
		$gra_amt_month = ($emp_salary->salary_basic * $gratuity->point * $month) / 12;
		if($gratuity_year >= 20)
		{
			$gratuity_amt = round($gra_amt_year);	
		}else{
			$gratuity_amt = round($gra_amt_year + $gra_amt_month);
		}
		return $gratuity_amt; 
	}
	
	
	private function pf_amounts($emp_id)
	{
		$pf_info 		= DB::table('pf_register')	
							->where('emp_id',$emp_id)
							->orderBy('pf_register_id', 'Desc')
							->first();	
		if($pf_info){
			$pf_fund_self 	  	= $pf_info->closing_balance_staff;
			$pf_fund_self_org 	= $pf_info->closing_balance_org;	
			$pf_amaount	  		= $pf_fund_self + $pf_fund_self_org;
		}else{
			$pf_amaount = 0;
		}
		return $pf_amaount; 
	}	
	
	private function loan_paid_status($emp_id,$loan_product_code)
	{
		$loan_infos 		= DB::table('loan')	
								->where('emp_id',$emp_id)
								->where('loan_product_code',$loan_product_code)
								->where('loan_status',3)
								->orderBy('loan_id', 'Desc')
								->first();	
		if($loan_infos){			
			$loan_id 		= $loan_infos->loan_id;
			$loan_paid_info = DB::table('loan_collection')	
									->where('loan_id',$loan_id)
									->orderBy('loan_collection_id', 'Desc')
									->select('loan_collection_date') 
									->first();	
			$loan_paid_date = $loan_paid_info->loan_collection_date;
			
			$today 			= new DateTime(date('Y-m-d'));
			$paid_date 		= new DateTime($loan_paid_date);
			$different 		= date_diff($paid_date, $today);
			$year 			= $different->y;
			$month 			= $different->m;
			$duratation 	= (($year*12) + $month);

		}else{
			$duratation = 475;
		}
		return $duratation; 
	}
	

	
	public function hr_recomendation_pf()
	{
		$hr_head 			= DB::table('loan_approval_authority')
									->where('author_role',1)
									->first();
		$data['pending'] 	= DB::table('emp_loan_applications as la')
								->leftJoin('loan_product as pr', 'la.loan_type_id', '=', 'pr.loan_product_id')
								->where('la.left_action',0) //
								->where('la.next_action',1)
								->where('la.is_reject',0) 
								->where('la.pf_hhr_action',1)
								->where('la.application_stage',0)
								->select('la.*','pr.loan_product_name')
								->get();
		$data['btn_link'] 		= 'Recommend';
		$data['action_type'] 	= 3; 		
		return view('admin.my_info.loan_pending_approval', $data);	
	}
	
	public function loan_approval_list()
	{						
		$pf 				= 1; 							
		$user 				= Session::get('emp_id');	
		$pf_secratery 		= DB::table('loan_approval_authority')
									->where('author_role',2)
									->first();	
		$pf_chairman 		= DB::table('loan_approval_authority')
									->where('author_role',10)
									->first();
		$director 				= DB::table('loan_approval_authority')
									->where('author_role',11)
									->first();			
		$h_hr 					= DB::table('loan_approval_authority')
									->where('author_role',1)
									->first();							
		$pf_secratery_id 	= $pf_secratery->author_emp_id;								
		$pf_chairman_id 	= $pf_chairman->author_emp_id;								
		$director_id 		= $director->author_emp_id;	
		$h_hr_id 			= $h_hr->author_emp_id;		
		$data['pending'] 	= DB::table('emp_loan_applications as la')
								->leftJoin('loan_product as pr', 'la.loan_type_id', '=', 'pr.loan_product_id')
								->leftJoin('tbl_branch as br', 'br.br_code', '=', 'la.emp_branch')
								->leftJoin('tbl_area as ar', 'ar.area_code', '=', 'la.emp_area')
								->leftJoin('tbl_zone as zn', 'zn.zone_code', '=', 'ar.zone_code')
								->where('la.application_stage',1)
								->where('la.next_action',1)
								->where('la.is_reject',0)
								 ->where(function($query) use ($pf,$user,$pf_secratery_id,$pf_chairman_id,$director_id,$h_hr_id) {
										if($user == $pf_secratery_id) 
										{
											$query->where('la.loan_type_id',$pf);
											$query->where('la.pf_hhr_action',2);
											$query->where('la.emp_id','!=',$pf_secratery_id);
										}elseif($user == $pf_chairman_id) 
										{
											$query->where('la.loan_type_id',$pf);
											$query->where('la.pf_hhr_action',2);
											$query->where('la.emp_id','=',$pf_secratery_id);
										}elseif($user == $director_id)
										{
											$query->where('la.emp_id','=',$h_hr_id);
										}else{
											$query->where('la.emp_id','!=',$h_hr_id);
											$query->where('la.loan_type_id','>',$pf);
										}
									})	 
								->select('la.*','pr.loan_product_name','ar.area_name','zn.zone_name')	
								->get();	 
		$data['btn_link'] 		= 'Approve';
		$data['action_type'] 	= 2; 
		$data['action'] 		= 2; 
		return view('admin.my_info.loan_pending_approval', $data);	
	}
	
	public function acc_pending_application()
	{
		$supervisor_emp_id 		= Session::get('emp_id');
		$branch_code 			= Session::get('branch_code'); 
		$data['pending'] 		= DB::table('emp_loan_applications as la')
									->leftJoin('loan_product as pr', 'la.loan_type_id', '=', 'pr.loan_product_id')
									->where('la.next_action',1)
									->where('la.is_reject',0)
									->where('la.left_action',$supervisor_emp_id)
									->select('la.*','pr.loan_product_name')
									->get();
		$data['btn_link'] 		= 'Recommend';
		$data['action_type'] 	= 4; 		
		return view('admin.my_info.loan_pending_approval', $data);	
	}
	
	public function acc_loan_recomendation_process(Request $request)
	{
		$emp_id 			= $request->input('emp_id');	 
		$loan_type_id 		= $request->input('loan_type_id');	 
		$hr_heads 			= DB::table('loan_approval_authority')
									->where('author_role',1)
									->first();
		$hr_head 					= $hr_heads->author_emp_id;
		$application_id 			= $request->input('application_id');	
			
		$actions 					= $request->input('actions');
		$approval_info 				= DB::table('loan_approval')
										->where('application_id',$application_id)
										->where('actions', 0)
										->orderBy('approval_id', 'asc')
										->select('approval_id')
										->first();
		$update['supervisors_id'] 	= $request->input('supervisors_id');	
		$update['actions'] 			= $request->input('actions');	
		$update['action_date'] 		= date('Y-m-d');	
		$update['actions_remarks'] 	= $request->input('actions_remarks');		
		DB::table('loan_approval')->where('approval_id', $approval_info->approval_id)->update($update);
		
		$loan_info 	= DB::table('emp_loan_applications')->where('loan_app_id',$application_id)->first();
		if($actions == 1)
		{
			$data['next_action'] 				= 1;
		}else{
			$data['is_reject'] 			    	= 1;
		}
		$acc_top_recomendation 					= DB::table('loan_approval_authority')->where('author_role',9)->first();

		$data['perform_action'] 				= $loan_info->perform_action + 1;
		
		if($data['perform_action'] == 3)
		{
			$data['left_action'] 	= 0;
		}elseif($data['perform_action'] == 2)
		{
			$data['left_action'] = $acc_top_recomendation->author_emp_id;
		}
		if($data['left_action'] == 0){ 
			if($loan_type_id == 1)
			{
				if($actions == 1)
				{
					$data['next_action'] 		= 1;
					$data['application_stage']	= 0;
					$data['pf_hhr_action'] 		= 1;
				}else{
					$data['is_reject'] 			= 1;
				}
							
			}else{
				$data['application_stage'] 		= 1;
			}
		}
		DB::table('emp_loan_applications')->where('loan_app_id', $application_id)->update($data);
		return Redirect::to("/pending_approval");	 
	}
	
	
	
	public function field_ho_recomendation()
	{
		$emp_id 				= Session::get('emp_id');
		$my_zones = DB::table('tbl_zone')
					->select('zone_code')
					->where('program_supervisor_id',$emp_id)
					->get();	
		$pending = array();
		foreach($my_zones as $my_zone)
		{
			$zone_code = $my_zone->zone_code;
			$pendings = DB::table('emp_loan_applications as la')
					->leftJoin('loan_product as pr', 'la.loan_type_id', '=', 'pr.loan_product_id')
					->leftJoin('tbl_branch as br', 'br.br_code', '=', 'la.emp_branch')
					->leftJoin('tbl_area as ar', 'ar.area_code', '=', 'la.emp_area')
					->leftJoin('tbl_zone as zn', 'zn.zone_code', '=', 'ar.zone_code')
					->where('la.next_action',1)
					->where('la.application_stage',0)
					->where('la.is_reject',0)
					->where('la.left_action',1)
					->where('la.emp_zone',$zone_code)
					->select('la.*','pr.loan_product_name','ar.area_name','zn.zone_name')	
					->get();	
			foreach($pendings as $pen){
				$pending[] = $pen;
			}		
		}	
		$data['pending'] 		= $pending;
		$data['action_type'] 	= 1;
		$data['btn_link'] 		= 'Recommend';
		return view('admin.my_info.loan_pending_approval_field', $data);
	}
	
	public function pending_approval() 
	{
		$branch_code 	= Session::get('branch_code');
		$emp_type 		= Session::get('emp_type');
		$user_type 		= Session::get('user_type');
		$area_code 		= Session::get('area_code');
		$zone_code 		= Session::get('zone_code');
		if($branch_code == 9999)
		{
			$emp_id 				= Session::get('emp_id');
		}else{
			$get_employee 			= $this->get_emp($branch_code,$user_type);
			$emp_id 				= $get_employee['emp_id'];
			$supervisors_name 		= $get_employee['emp_name_eng'];
			$supervisor_designation = $get_employee['designation_name'];
			Session::put( 'emp_id', $emp_id );
			Session::put( 'supervisors_name', $supervisors_name );
			Session::put( 'supervisor_designation', $supervisor_designation );
		}
		
		$supervisor_emp_id 		= Session::get('emp_id');
		$branch_code 			= Session::get('branch_code'); 
		$data['btn_link'] 		= 'Recommend';
		$data['action_type'] 	= 1; 
		//for H/O
		if($branch_code == 9999)
		{			
			$data['pending'] = DB::select(DB::raw("SELECT
								   emp_loan_applications.*,
								   loan_product.loan_product_name
								FROM
									emp_loan_applications
									LEFT JOIN loan_product ON loan_product.loan_product_id=emp_loan_applications.loan_type_id
								WHERE
									emp_id IN(
									SELECT
										emp_id
									FROM
										supervisor_mapping_ho
									WHERE
										supervisor_id = $supervisor_emp_id
								) AND left_action =(
									SELECT
										supervisor_mapping_ho.supervisor_type
									FROM
										supervisor_mapping_ho
									WHERE
										supervisor_id = $supervisor_emp_id AND emp_loan_applications.emp_id = supervisor_mapping_ho.emp_id
								) AND emp_loan_applications.is_reject=0 AND emp_loan_applications.next_action=1"));
			return view('admin.my_info.loan_pending_approval', $data);
		}else{
			//for B/O
			$my_info 					= $this->emp_info($supervisor_emp_id);
			$my_branch 					= $my_info['br_code'];
			$my_area 					= $my_info['area_code'];
			$my_zone 					= $my_info['zone_code'];
			$my_designation 			= $my_info['designation_code'];
			$my_designation_group_code 	= $my_info['designation_group_code'];
			if($my_designation_group_code == 12)
			{
				$where_column 	= 'la.emp_branch';
				$where_value 	= $my_branch;
				$action_level 	= 1;
			}elseif($my_designation_group_code == 11)
			{
				$where_column 	= 'la.emp_area';
				$where_value 	= $my_area;
				$action_level 	= 2;
			}elseif($my_designation_group_code == 8) 
			{
				$where_column 	= 'la.emp_zone';
				$where_value 	= $my_zone;
				$action_level 	= 3;
			}
			$data['pending'] 	= DB::table('emp_loan_applications as la')
									->leftJoin('loan_product as pr', 'la.loan_type_id', '=', 'pr.loan_product_id')
									->leftJoin('tbl_branch as br', 'br.br_code', '=', 'la.emp_branch')
					->leftJoin('tbl_area as ar', 'ar.area_code', '=', 'la.emp_area')
					->leftJoin('tbl_zone as zn', 'zn.zone_code', '=', 'ar.zone_code')
									->where($where_column,$where_value)
									->where('la.perform_action',$action_level)
									->where('la.application_stage',0)
									->where('la.is_reject',0)
									->where('la.next_action',1)
									->select('la.*','pr.loan_product_name','ar.area_name','zn.zone_name')	
									->get();				
			return view('admin.my_info.loan_pending_approval_field', $data);	
		}
	}


	public function loan_recomendation_process(Request $request) 
	{
		$emp_id 			= $request->input('emp_id');	 
		$loan_type_id 		= $request->input('loan_type_id');	 
		$hr_heads 			= DB::table('loan_approval_authority')
									->where('author_role',1)
									->first();
		$hr_head 					= $hr_heads->author_emp_id;
		
		$application_id 			= $request->input('application_id');	
		$actions 					= $request->input('actions');
		$approval_info 				= DB::table('loan_approval')
										->where('application_id',$application_id)
										->where('actions', 0)
										->orderBy('approval_id', 'asc')
										->select('approval_id')
										->first();
		$ho_bo 								= $request->input('ho_bo');	
		$update['supervisors_id'] 			= $request->input('supervisors_id');	
		$update['actions'] 					= $request->input('actions');	
		$update['action_date'] 				= date('Y-m-d');	
		$update['actions_remarks'] 			= $request->input('actions_remarks');
		
		if($emp_id == $hr_head)
		{
			DB::table('loan_approval')->where('approval_id', $approval_info->approval_id)->update($update);
			if($actions == 1)
			{
				$data['next_action'] 				= 1;
				if($loan_type_id == 1)
				{
					$data['pf_hhr_action'] 			= 2;
				}
				$data['application_stage'] 			= 1;
				$data['left_action'] 				= 0;
				$data['perform_action'] 			= 1;
				
			}else{
				$data['is_reject'] 			    	= 1;
			}
		}else{
			if($ho_bo != 9999)
			{
				$update['supervisors_name'] 		= $request->input('supervisors_name');
				$update['supervisor_designation'] 	= $request->input('supervisor_designation');
			}
			DB::table('loan_approval')->where('approval_id', $approval_info->approval_id)->update($update);
			$loan_info 	= DB::table('emp_loan_applications')->where('loan_app_id',$application_id)->first();
			if($actions == 1)
			{
				$data['next_action'] 				= 1;
			}else{
				$data['is_reject'] 			    	= 1;
			}
			$data['left_action'] 					= $loan_info->left_action - 1;
			$data['perform_action'] 				= $loan_info->perform_action + 1;

			if($data['left_action'] == 0){
				if($loan_info->designation_code == 173)//SACMO 
				{
					$data['application_stage'] 	= 0;
					$health_coordinators 		= DB::table('loan_approval_authority')
													->where('author_role',4)
													->first();			
					$data['left_action'] 		= $health_coordinators->author_emp_id;
				}else{
					$data['application_stage'] 	= 1;
				}
				if($loan_type_id == 1)
				{
					if($actions == 1)
					{
						$data['application_stage']	= 0;
						$data['pf_hhr_action'] 		= 1;
					}else{
						$data['is_reject'] 			= 1;
					}		
				}
			}
		}
		DB::table('emp_loan_applications')->where('loan_app_id', $application_id)->update($data);
		
		// MIAL 
		if($actions == 1)
		{
			if($loan_info->ho_bo == 1)
			{
				$left_action 		= $loan_info->left_action - 1;
				if($left_action == 0)
				{
					$supervisor_mail_address = 'nafis@cdipbd.org';
				}else{
					$mail_address 		=  DB::table('supervisor_mapping_ho as m') 
					->leftJoin('supervisors as s', 'm.supervisor_id', '=', 's.supervisors_emp_id')
					->where('m.emp_id',$emp_id)
					->where('m.supervisor_type',$left_action)
					->select('s.supervisors_email')
					->first();	
					$supervisor_mail_address = $mail_address->supervisors_email;
				}
				
				
			}else
			{
				$emp_area 		= $loan_info->emp_area;
				$emp_zone 		= $loan_info->emp_zone;
				if($loan_info->left_action == 3)
				{
					$area_mail 		=  DB::table('tbl_area')
										->where('area_code',$emp_area)
										->select('area_email')
										->first();
					$supervisor_mail_address = $area_mail->area_email;
				}elseif($loan_info->left_action == 2){
					$zone_info 		= DB::table('tbl_zone')
									->where('zone_code',$emp_zone)
									->first();
					$supervisor_mail_address = $zone_info->zone_email;
				}elseif($loan_info->left_action == 1){
					$zone_info 		= DB::table('tbl_zone')
									->where('zone_code',$emp_zone)
									->first();
					$supervisor_mail_address = $zone_info->program_supervisor_mail;
				}else{
					$supervisor_mail_address = 'nafis@cdipbd.org';
				}

			}
			$supervisor_mail 		= $supervisor_mail_address; 
			$emp_id 				= $emp_id; 
			$emp_name_string 		= $loan_info->emp_name;  
			$emp_name 				= str_replace(' ', '-', $emp_name_string);
			$designation_name_string= $loan_info->designation_name;
			$designation_name 		= str_replace(' ', '-', $designation_name_string);
			$branch_name_string 	= $loan_info->branch_name;
			$branch_name 			= str_replace(' ', '-', $branch_name_string);
			$application_date 		= $loan_info->application_date;
			$loan_type_id 			= $loan_info->loan_type_id;
			$loan_amount 			= $loan_info->loan_amount;
			$loan_duration 			= $loan_info->loan_duration;
			//$mail = $this->send_mail($supervisor_mail,$emp_id,$emp_name,$designation_name,$branch_name,$application_date,$loan_type_id,$loan_amount,$loan_duration);	
		}
		return Redirect::to("/pending_approval");	 
	}
	
	public function loan_approval($loan_app_id,$action_type)
	{
		$supervisor_emp_id 				= Session::get('emp_id');
		$supervisors_name 				= Session::get('supervisors_name');
		$supervisor_designation 		= Session::get('supervisor_designation');
		$data['supervisor_emp_id'] 		= $supervisor_emp_id;
		
		$data['supervisors_name'] 		= $supervisors_name;
		$data['supervisor_designation'] = $supervisor_designation; 
		
		$program_author = DB::table('loan_approval_authority') 
				->select('author_name','author_designation')
				->where('author_emp_id',$supervisor_emp_id)
				->first();
		if($program_author)
		{
			$data['supervisors_name'] 		= $program_author->author_name;
			$data['supervisor_designation'] = $program_author->author_designation; 
		}	
		
		if($action_type == 1) 
		{ 
			$data['positive_action'] 	= 'Recommend';
			$data['action'] 			= '/loan_recomendation_process';
		}elseif($action_type == 3) 
		{ 
			$data['positive_action'] 	= 'Recommend';
			$data['action'] 			= '/pf_loan_recomendation_process';
		}elseif($action_type == 4) 
		{ 
			$data['positive_action'] 	= 'Recommend';
			$data['action'] 			= '/acc_loan_recomendation_process'; //ACC
		}elseif($action_type == 5) 
		{ 
			$data['positive_action'] 	= 'Recommend';
			$data['action'] 			= '/sc_loan_recomendation_process'; //SC
		}
		elseif($action_type == 6) 
		{ 
			$data['positive_action'] 	= 'Recommend';
			$data['action'] 			= '/health_recomendation_process'; //Health
		}elseif($action_type == 7) 
		{ 
			$data['positive_action'] 	= 'Recommend';
			$data['action'] 			= '/agri_recomendation_process'; //Agri
		}else{
			$data['positive_action'] 	= 'Approve';
			$data['action'] 			= '/loan_approve_process';
		}
		$data['action_type'] 			= $action_type;	
		$data['loan_app_id'] = $loan_app_id;
		$data['info'] = DB::table('emp_loan_applications as ap')
				->leftJoin('tbl_emp_basic_info as e', 'ap.emp_id', '=', 'e.emp_id')
				->leftJoin('loan_product as lp', 'ap.loan_type_id', '=', 'lp.loan_product_id')	
				->leftJoin('tbl_branch as b', 'ap.emp_branch', '=', 'b.br_code')	
				->leftjoin('banks as bnk', 'bnk.bank_id', '=', 'ap.bank_id')					
				->leftjoin('bank_branch as bbr', 'bbr.bank_branch_id', '=', 'ap.bank_branch_id')		
				->where('loan_app_id',$loan_app_id)
				->select('ap.*','bbr.bank_branch_name','bnk.bank_name','e.emp_name_eng','b.branch_name','lp.loan_product_name')
				->first(); 
				
		////
		if($data['info']->emp_branch == 9999)
		{
			$data['ho_bo'] 	= 9999;
		}else{
			$data['ho_bo'] 	= 1;
		}
		$emp_id = $data['info']->emp_id;

		$previous_loan_info = DB::table('loan as lo')
								->leftJoin('tbl_emp_basic_info as e', 'lo.emp_id', '=', 'e.emp_id')	
								->leftJoin('loan_product as lp', 'lo.loan_product_code', '=', 'lp.loan_product_id')	
								->where('lo.emp_id',$emp_id)
								->select('lo.*','e.emp_name_eng','lp.loan_product_name') 
								->get();
								
		$basic_info 			= $this->emp_info($emp_id);
		$pf_info 				= DB::table('pf_register')	
									->where('emp_id',$emp_id)
									->orderBy('pf_register_id', 'Desc')  
									->first();	
		if($pf_info)
		{
			$pf_fund_self 	  = $pf_info->closing_balance_staff;
			$pf_fund_self_org = $pf_info->closing_balance_org;
		}else{
			$pf_fund_self 	  = 0;
			$pf_fund_self_org = 0;
		}
		$gratuity_info 		= $this->gratuity_amount($emp_id,$basic_info['org_join_date']); 
		$offence_info 		= DB::table('tbl_punishment as off')
								->leftJoin('tbl_emp_basic_info as e', 'off.emp_id', '=', 'e.emp_id')	
								->where('off.emp_id',$emp_id)
								->select('off.*','e.emp_name_eng')
								->orderBy('letter_date', 'desc')
								->get();	
		
		$recomendation_info = DB::table('loan_approval as app')
								->where('app.application_id',$loan_app_id)
								->where('app.actions','>',0)
								->get();

								
		$data['previous_loan_info']	= $previous_loan_info;
		$data['basic_info'] 		= $basic_info;
		$data['gratuity_info'] 		= $gratuity_info;
		$data['pf_info'] 			= $pf_info;
		$data['offence_info'] 		= $offence_info;
		$data['recomendation_info'] = $recomendation_info;
		
		//echo '<pre>';
		//print_r($data['offence_info']);
		//exit;			
		return view('admin.my_info.loan_approval', $data);				
	}

	public function loan_approve_process(Request $request)
	{
		$application_id	= $request->input('application_id');
		$action_type 	= $request->input('action_type');
		$actions 		= $request->input('actions');
		if($actions == 1)
		{
			$data['application_stage'] 		= 2;
			$data['next_action'] 			= 1;
		}else{
			$data['is_reject'] 			    = 1;
			$data['next_action'] 		    = 0;
		}
		$supervisors_id 					= $request->input('supervisors_id');
		$supervisor_info 					= DB::table('loan_approval_authority')
												->where('author_emp_id',$supervisors_id)
												->first();										
		$data['approvers_id'] 				= $supervisors_id;
		$data['approvers_name'] 			= $supervisor_info->author_name;
		$data['approvers_designation'] 		= $supervisor_info->author_designation;
		$data['approve_date'] 				= date('Y-m-d');
		$data['approve_action'] 			= $request->input('actions');
		$data['approve_remarks']			= $request->input('actions_remarks');
		$data['motorcycle_registration']	= $request->input('motorcycle_registration'); 
		DB::table('emp_loan_applications')->where('loan_app_id', $application_id)->update($data);
		
		// Mail Fire to Supervisor	
		if($actions == 1)
		{
			$app_info 				= DB::table('emp_loan_applications')
												->where('loan_app_id',$application_id)
												->first();
			$supervisor_mail 		= 'nafisrahman2012@gmail.com';
			$emp_id 				= $app_info->emp_id; 
			$emp_name_string 		= $app_info->emp_name;  
			$emp_name 				= str_replace(' ', '-', $emp_name_string);
			$designation_name_string= $app_info->designation_name;
			$designation_name 		= str_replace(' ', '-', $designation_name_string);
			$branch_name_string 	= $app_info->branch_name;
			$branch_name 			= str_replace(' ', '-', $branch_name_string);
			$application_date 		= $app_info->application_date;
			$loan_type_id 			= $app_info->loan_type_id;
			$loan_amount 			= $app_info->loan_amount;
			$loan_duration 			= $app_info->loan_duration;
			//$mail = $this->send_mail($supervisor_mail,$emp_id,$emp_name,$designation_name,$branch_name,$application_date,$loan_type_id,$loan_amount,$loan_duration);		
		}
		// Mail

		return Redirect::to("/loan_approval_list");	
	}	
	
	public function pf_loan_recomendation_process(Request $request)
	{
		$application_id			= $request->input('application_id');
		$action_type 			= $request->input('action_type');
		$actions 				= $request->input('actions');
		$approve_remarks		= $request->input('actions_remarks');
		$supervisors_id 		= $request->input('supervisors_id');
		if($actions == 1)
		{
			$data['application_stage'] 		= 1;
			$data['next_action'] 			= 1;
			$data['pf_hhr_action'] 			= 2;
		}else{
			$data['is_reject'] 			    = 1;
			$data['next_action'] 		    = 0;
		}
		DB::table('emp_loan_applications')->where('loan_app_id', $application_id)->update($data);
		//
		$approval['action_date']		= date('Y-m-d');
		$approval['actions'] 			= $actions;
		$approval['actions_remarks'] 	= $approve_remarks;
		DB::table('loan_approval')
				->where('supervisors_id', $supervisors_id)
				->where('application_id', $application_id)
				->update($approval);	
		//echo '<pre>';
		//print_r($approval);
		return Redirect::to("/hr_recomendation_pf");	 
	}	
	
	
	
	public function loan_report($date_from,$date_to)
	{
		$supervisor_id 		= Session::get('emp_id');	
		$data['results'] 	= DB::table('emp_loan_applications as la')
			->leftJoin('loan_approval as ap', 'ap.application_id', '=', 'la.loan_app_id')
			->leftJoin('loan_product as pr', 'la.loan_type_id', '=', 'pr.loan_product_id')
			->where('ap.supervisors_id',$supervisor_id)
			->where('la.application_date','>=',$date_from)
			->where('la.application_date','<=',$date_to)
			->select('la.*','pr.loan_product_name')
			->get();		
		return view('admin.my_info.loan_report_ajax', $data); 
	}		
	
	public function loan_test($emp_id) 
	{
		$data = array();
		
		$self_group = 22;
		
		$emp_type 			= 1;
		$form_date 			= date('Y-m-d');
		$all_designation_code = DB::table('tbl_designation')
								->where('self_group', '=', $self_group)
								->select('designation_code')
								->get();
		foreach($all_designation_code as $all_designation) {
			$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.designation_code', $all_designation->designation_code)
						->where('m.br_join_date', '<=', $form_date)
						->whereNull('r.emp_id')
						->orWhere('r.effect_date', '>', $form_date)
						->groupBy('m.emp_id')
						->select('m.emp_id')
						->get();
						
			if(!empty($all_result)) {
				foreach($all_result as $result) {
					$emp_id = $result->emp_id;
					$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $result->emp_id)
						->where('m.br_join_date', '=', function($query) use ($emp_id,$form_date)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $form_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('m.emp_id')
						->first();
						
					$desig_nation = DB::table('tbl_master_tra')
										->where('emp_id', $result->emp_id)
										->where('sarok_no', $max_sarok->sarok_no)
										->select('emp_id','sarok_no','designation_code')
										->first();
					if($all_designation->designation_code == $desig_nation->designation_code) {
						$result_data = DB::table('tbl_master_tra as m')
											->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
											->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
											->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
											->where('m.emp_id', '=', $desig_nation->emp_id)
											->where('m.sarok_no', '=', $desig_nation->sarok_no)
											->select('m.emp_id','m.br_code','e.emp_name_eng','e.org_join_date','m.br_join_date','m.grade_effect_date','d.designation_name','b.branch_name','d.designation_code','d.designation_group_code')
											->first();
						if($result_data->br_code !=9999)
						{
							$data[] = array(
							'emp_id' 					=> $result_data->emp_id,
							'emp_name_eng'      		=> $result_data->emp_name_eng,
							'designation_name'  		=> $result_data->designation_name,
							'branch_name'      			=> $result_data->branch_name,
							'designation_group_code'    => $result_data->designation_group_code,
							'designation_code'      	=> $result_data->designation_code
						);
						}
					}
				}
			}
		}
		
		//return $data;
		echo '<pre>';
		print_r($data); exit;
	}	
	
	
	public function branch_supervisor_mapping($emp_designation)
	{
		$bellow_bm 			= DB::table('tbl_designation')
							->where('to_reported',24)
							->where('status',1)
							->select('designation_code')
							->get();
							
		$level_bm 			= DB::table('tbl_designation')
							->where('to_reported',122)
							->where('status',1)
							->select('designation_code')
							->get();
							
		$level_am 			= DB::table('tbl_designation')
							->where('to_reported',209)
							->where('status',1)
							->select('designation_code')
							->get();
		
		$level_dm 			= DB::table('tbl_designation')
							->where('to_reported',277)
							->where('status',1)
							->select('designation_code')
							->get();

							
		foreach($bellow_bm as $v_bellow_bm)
		{
			$all_bellow_bm[] = $v_bellow_bm->designation_code;
		}			
						
		foreach($level_bm as $v_level_bm)
		{
			$all_bm[] = $v_level_bm->designation_code;
		}			
		
		foreach($level_am as $v_level_am)
		{
			$all_am[] = $v_level_am->designation_code;
		}			
		
		foreach($level_dm as $v_level_dm)
		{
			$all_dm[] = $v_level_dm->designation_code;
		}	

		$reported_to = '';

		if (in_array($emp_designation, $all_bellow_bm))
		{
			$layer = 4;
			$reported_to = "Branch Manager";
		}		
		
		if (in_array($emp_designation, $all_bm))
		{
			$layer = 3;
			$reported_to = "Area Manager";
		}

		if (in_array($emp_designation, $all_am))
		{
			$layer = 2;
			$reported_to = "District Manager";
		}							
							
		if (in_array($emp_designation, $all_dm))
		{
			$layer = 1;
			$reported_to = "Program Coordinator";
		}

		$infos['reported_to'] 	= $reported_to;		
		$infos['layer'] 		= $layer;		
		
		return $infos;
	}
	
	public function emp_info($emp_id)
	{
		$today = date('Y-m-d');
		//$emp_id = 1326;
		$max_sarok = DB::table('tbl_master_tra as m')
			->where('m.emp_id', '=', $emp_id)
			->where('m.letter_date', '=', function ($query) use ($emp_id, $today) {
				$query->select(DB::raw('max(letter_date)'))
					->from('tbl_master_tra')
					->where('emp_id', $emp_id)
					->where('letter_date', '<=', $today);
			})
			->select('m.emp_id', DB::raw('max(m.sarok_no) as sarok_no'))
			->groupBy('emp_id')
			->first();
				
				
		$employee_info = DB::table('tbl_master_tra')
			->leftjoin('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'tbl_master_tra.emp_id')
			->leftjoin('tbl_department', 'tbl_department.department_id', '=', 'tbl_master_tra.department_code')
			->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_master_tra.designation_code')
			->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_master_tra.br_code')
			->leftJoin( 'tbl_area', 'tbl_area.area_code', '=', 'tbl_branch.area_code' )
			->leftjoin('tbl_grade_new', 'tbl_grade_new.grade_id', '=', 'tbl_master_tra.grade_code')
			->where('tbl_master_tra.sarok_no', $max_sarok->sarok_no)
			->where('tbl_master_tra.status', 1)
			->select('tbl_master_tra.sarok_no', 'tbl_master_tra.br_join_date', 'tbl_master_tra.next_increment_date', 'tbl_master_tra.effect_date as sa_effect_date', 'tbl_master_tra.br_code', 'tbl_master_tra.grade_code', 'tbl_master_tra.grade_effect_date', 'tbl_master_tra.grade_step', 'tbl_master_tra.department_code', 'tbl_master_tra.is_permanent', 'tbl_emp_basic_info.emp_name_eng', 'tbl_emp_basic_info.org_join_date', 'tbl_designation.designation_name', 'tbl_master_tra.basic_salary', 'tbl_master_tra.salary_br_code', 'tbl_department.department_name', 'tbl_emp_basic_info.gender', 'tbl_branch.branch_name', 'tbl_grade_new.grade_name','tbl_master_tra.designation_code','tbl_area.area_code','tbl_area.zone_code','tbl_designation.designation_group_code','tbl_designation.self_group')
			->first();
		$permanent 			= DB::table('tbl_permanent')
								->where('emp_id', $emp_id)
								->select('tbl_permanent.effect_date')
								->first();
		if($permanent)
		{
			$my_info['permanent_date'] 			= $permanent->effect_date;
		}else{
			$my_info['permanent_date'] 			= '';
		}	
		$my_info['emp_id'] 					= $emp_id;
		$my_info['sarok_no'] 				= $employee_info->sarok_no;
		$my_info['emp_name'] 				= $employee_info->emp_name_eng;
		$my_info['joining_date'] 			= $employee_info->org_join_date;
		$my_info['designation_code'] 		= $employee_info->designation_code;
		$my_info['designation_name'] 		= $employee_info->designation_name;
		$my_info['department_name'] 		= $employee_info->department_name;
		$my_info['department_code'] 		= $employee_info->department_code;
		$my_info['br_join_date'] 			= $employee_info->br_join_date;
		$my_info['effect_date'] 			= $employee_info->sa_effect_date;
		$my_info['br_code'] 				= $employee_info->br_code;
		$my_info['grade_code'] 				= $employee_info->grade_code;
		$my_info['grade_step'] 				= $employee_info->grade_step;
		$my_info['grade_effect_date'] 		= $employee_info->grade_effect_date;
		$my_info['next_increment_date'] 	= $employee_info->next_increment_date;
		$my_info['branch_name'] 			= $employee_info->branch_name;
		$my_info['grade_name'] 				= $employee_info->grade_name;
		$my_info['is_permanent'] 			= $employee_info->is_permanent;
		$my_info['salary_br_code'] 			= $employee_info->salary_br_code;
		$my_info['org_join_date'] 			= $employee_info->org_join_date;
		$my_info['basic_salary'] 			= $employee_info->basic_salary;
		$my_info['gender'] 					= $employee_info->gender;
		$my_info['area_code'] 				= $employee_info->area_code;
		$my_info['zone_code'] 				= $employee_info->zone_code;
		$my_info['designation_group_code'] 	= $employee_info->designation_group_code; 
		$my_info['self_group'] 				= $employee_info->self_group; 								
		return $my_info;
		//echo '<pre>';
		//print_r($my_info);
	}
	
	
	public function get_emp($br_code,$user_type)
	{
			$form_date = date('Y-m-d');
			if($user_type == 5) // BM 
			{
				$data_re_sult = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
							->where('m.br_code', '=', $br_code)
							->where('m.br_join_date', '<=', $form_date)
							->Where(function($query) use ($form_date) {
										$query->whereNull('r.emp_id');
										$query->orWhere('r.effect_date', '>', $form_date);								
									})
							->select('m.emp_id')
							->groupBy('m.emp_id')
							->get()->toArray();
				$assign_br_anch = DB::table('tbl_emp_assign as eas')
											->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
											->where('eas.br_code', '=', $br_code)
											->where('eas.status', '!=', 0)
											->where('eas.select_type', '=', 2)	
											->where(function($query) use ($form_date) {
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date);
											})									
											->select('eas.emp_id')
											->get()->toArray();
				$all_result3 = array_unique(array_merge($data_re_sult,$assign_br_anch), SORT_REGULAR);
				if (!empty($all_result3)) {
					foreach ($all_result3 as $result3) {	
						$emp_id = $result3->emp_id;
						$max_sa_rok = DB::table('tbl_master_tra as m')
							->where('m.emp_id', '=', $result3->emp_id)
							->where('m.br_join_date', '=', function($query) use ($emp_id,$form_date)
									{
										$query->select(DB::raw('max(br_join_date)'))
											  ->from('tbl_master_tra')
											  ->where('emp_id',$emp_id)
											  ->where('br_join_date', '<=', $form_date);
									})
							->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
							->groupBy('m.emp_id')
							->first();
							
						$re_sult_data = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
							->where('m.sarok_no', '=', $max_sa_rok->sarok_no)
							->select('e.emp_name_eng','m.br_code','m.br_join_date','m.designation_code','d.designation_name','b.branch_name')
							->first();
						if ($br_code == $re_sult_data->br_code) {	
							if ($re_sult_data->designation_code == 24 || $re_sult_data->designation_code == 215) {	
								$data = array(
									'emp_id' => $result3->emp_id,
									'emp_name_eng'      => $re_sult_data->emp_name_eng,
									'designation_name'      => $re_sult_data->designation_name
								);	
							}
						}
					}
				}
			}else if($user_type == 4) // AM 
			{
				$br_list = DB::table('tbl_branch as b')
							->leftJoin('tbl_branch as ea', function($join){
											$join->where('ea.am_br_location',1)
											->on('b.area_code', '=', 'ea.area_code');
										})
							->where('b.br_code', $br_code)
							->first();
				$data_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
							->where('m.br_code', '=', $br_list->br_code)
							->where('m.br_join_date', '<=', $form_date)
							->Where(function($query) use ($form_date) {
										$query->whereNull('r.emp_id');
										$query->orWhere('r.effect_date', '>', $form_date);								
									})
							->select('m.emp_id')
							->groupBy('m.emp_id')
							->get()->toArray();
				$assign_branch = DB::table('tbl_emp_assign as eas')
											->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
											->where('eas.br_code', '=', $br_list->br_code)
											->where('eas.status', '!=', 0)
											->where('eas.select_type', '=', 2)	
											->where(function($query) use ($form_date) {
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date);
											})									
											->select('eas.emp_id')
											->get()->toArray();
				$all_result2 = array_unique(array_merge($data_result,$assign_branch), SORT_REGULAR);
				if (!empty($all_result2)) {
					foreach ($all_result2 as $result2) {	
						$emp_id = $result2->emp_id;
						$max_sarok = DB::table('tbl_master_tra as m')
							->where('m.emp_id', '=', $result2->emp_id)
							->where('m.br_join_date', '=', function($query) use ($emp_id,$form_date)
									{
										$query->select(DB::raw('max(br_join_date)'))
											  ->from('tbl_master_tra')
											  ->where('emp_id',$emp_id)
											  ->where('br_join_date', '<=', $form_date);
									})
							->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
							->groupBy('m.emp_id')
							->first();
							
						$result_data = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
							->where('m.sarok_no', '=', $max_sarok->sarok_no)
							->select('e.emp_name_eng','m.br_code','m.br_join_date','m.designation_code','d.designation_name','b.branch_name')
							->first();
						if ($br_list->br_code == $result_data->br_code) {	
							if ($result_data->designation_code == 122 || $result_data->designation_code == 212 || $result_data->designation_code == 246) {	
								$data = array(
									'emp_id' => $result2->emp_id,
									'emp_name_eng'      => $result_data->emp_name_eng,
									'designation_name'      => $result_data->designation_name
								);	
							}
						}
					}
				}
			}else if($user_type == 3) // DM 
			{
				$ar_list = DB::table('tbl_branch as b')
								->leftJoin('tbl_branch as ea', function($join){
												$join->where('ea.dm_br_location',1)->on('b.zone_code', '=', 'ea.zone_code');
											})
								->where('b.br_code', $br_code)
								->first();
				
				$dataresult = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
							->where('m.br_code', '=', $ar_list->br_code)
							->where('m.br_join_date', '<=', $form_date)
							->Where(function($query) use ($form_date) {
										$query->whereNull('r.emp_id');
										$query->orWhere('r.effect_date', '>', $form_date);								
									})
							->select('m.emp_id')
							->groupBy('m.emp_id')
							->get()->toArray();
							
				
				
				$assignbranch = DB::table('tbl_emp_assign as eas')
											->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
											->where('eas.br_code', '=', $ar_list->br_code)
											->where('eas.status', '!=', 0)
											->where('eas.select_type', '=', 2)	
											->where(function($query) use ($form_date) {
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date);
											})									
											->select('eas.emp_id')
											->get()->toArray();
				$all_result1 = array_unique(array_merge($dataresult,$assignbranch), SORT_REGULAR);
				
				
				
				if (!empty($all_result1)) {
					foreach ($all_result1 as $result1) {	
						$emp_id = $result1->emp_id;
						$max_sarok = DB::table('tbl_master_tra as m')
							->where('m.emp_id', '=', $result1->emp_id)
							->where('m.br_join_date', '=', function($query) use ($emp_id,$form_date)
									{
										$query->select(DB::raw('max(br_join_date)'))
											  ->from('tbl_master_tra')
											  ->where('emp_id',$emp_id)
											  ->where('br_join_date', '<=', $form_date);
									})
							->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
							->groupBy('m.emp_id')
							->first();
							
						$result1_data = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
							->where('m.sarok_no', '=', $max_sarok->sarok_no)
							->select('e.emp_name_eng','m.br_code','m.br_join_date','m.designation_code','d.designation_name','b.branch_name')
							->first();
							
										
						
						
						if ($ar_list->br_code == $result1_data->br_code) {	
							if ($result1_data->designation_code == 209 || $result1_data->designation_code == 211) {	
								$data = array(
									'emp_id' 			=> $result1->emp_id,
									'emp_name_eng'      => $result1_data->emp_name_eng,
									'designation_name'  => $result1_data->designation_name
								);	
							}
						}
					}
				}	
			}
		return $data;
	}
	
	public function my_staffs_br($br_code)
    {
        $data = array();
		$form_date 	= date('Y-m-d'); 
		$status 	= 1;
		$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.br_code', '=', $br_code)
						->where('m.br_join_date', '<=', $form_date)
						->where(function($query) use ($status, $form_date) {
								if($status !=2) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);
								} else {
									$query->Where('r.effect_date', '<=', $form_date);
								}
							})
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get()->toArray();
						
		$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										->where('eas.br_code', '=', $br_code)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($status, $form_date) {
											if($status !=2) {
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date);
											} else {
												$query->Where('r.effect_date', '<=', $form_date);
											}
										})									
										->select('eas.emp_id')
										->get()->toArray();
		$all_result1 = array_unique(array_merge($all_result,$assign_branch), SORT_REGULAR);
		if (!empty($all_result1)) {
			foreach ($all_result1 as $result) {
				$max_exam = DB::table('tbl_emp_edu_info')
					->where('emp_id', '=', $result->emp_id)
					->select('emp_id', DB::raw('max(level_id) as level_id'))
					->groupBy('emp_id')
					->first();

				$emp_id = $result->emp_id;
				$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $result->emp_id)
						->where('m.br_join_date', '=', function($query) use ($emp_id,$form_date)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $form_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no')) 
						->groupBy('m.emp_id')
						->first();
				$data_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
							->leftJoin('tbl_emp_assign as ea', function($join){
											$join->where('ea.status',1)
												->on('m.emp_id', '=', 'ea.emp_id');
										})
							->where('m.sarok_no', '=', $max_sarok->sarok_no)
							->select('e.emp_name_eng','e.org_join_date','e.permanent_add','e.father_name','m.br_join_date','m.br_code','d.designation_name','b.branch_name','ea.incharge_as','d.designation_group_code','d.designation_code')
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
											->where('ea.open_date', '<=', $form_date)
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
					$result_br_code 	= $data_result->br_code;
					$asign_branch_name 	= '';
					$asign_area_name 	=  '';
					$asign_open_date 	=  '';
				}		
				if ($result_br_code == $br_code) {	
					$data[] = array(
						'emp_id' => $result->emp_id,
						'emp_name_eng'      		=> $data_result->emp_name_eng,
						'permanent_add'      		=> $data_result->permanent_add,
						'father_name'      			=> $data_result->father_name,
						'org_join_date'      		=> $data_result->org_join_date,
						'br_join_date'      		=> date('d M Y',strtotime($data_result->br_join_date)),
						'designation_name'      	=> $data_result->designation_name,
						'branch_name'      			=> $data_result->branch_name,
						'designation_group_code'    => $data_result->designation_group_code,
						'designation_code'      	=> $data_result->designation_code
					);
				}				
			}
			
		}
		return $data;
    }
	
	
	
	public function designation_staff($self_group)
	{
		$data = array();
		$emp_type 			= 1;
		$form_date 			= date('Y-m-d');
		$all_designation_code = DB::table('tbl_designation')
								->where('self_group', '=', $self_group)
								->select('designation_code')
								->get();
		foreach($all_designation_code as $all_designation) {
			$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.designation_code', $all_designation->designation_code)
						->where('m.br_join_date', '<=', $form_date)
						->whereNull('r.emp_id')
						->orWhere('r.effect_date', '>', $form_date)
						->groupBy('m.emp_id')
						->select('m.emp_id')
						->get();
						
			if(!empty($all_result)) {
				foreach($all_result as $result) {
					$emp_id = $result->emp_id;
					$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $result->emp_id)
						->where('m.br_join_date', '=', function($query) use ($emp_id,$form_date)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $form_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('m.emp_id')
						->first();
						
					$desig_nation = DB::table('tbl_master_tra')
										->where('emp_id', $result->emp_id)
										->where('sarok_no', $max_sarok->sarok_no)
										->select('emp_id','sarok_no','designation_code')
										->first();
					if($all_designation->designation_code == $desig_nation->designation_code) {
						$result_data = DB::table('tbl_master_tra as m')
											->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
											->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
											->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
											->leftJoin('tbl_area as ar', 'ar.area_code', '=', 'b.area_code')
											->where('m.emp_id', '=', $desig_nation->emp_id)
											->where('m.sarok_no', '=', $desig_nation->sarok_no)
											->select('m.emp_id','m.br_code','e.emp_name_eng','e.org_join_date','m.br_join_date','m.grade_effect_date','d.designation_name','b.branch_name','d.designation_code','d.designation_group_code','ar.area_code','ar.zone_code')
											->first();
						if($result_data->br_code !=9999) 
						{
							$data[] = array(
								'emp_id' 					=> $result_data->emp_id,
								'emp_name_eng'      		=> $result_data->emp_name_eng,
								'designation_name'  		=> $result_data->designation_name,
								'branch_name'      			=> $result_data->branch_name,
								'designation_group_code'    => $result_data->designation_group_code,
								'designation_code'      	=> $result_data->designation_code,
								'area_code'      			=> $result_data->area_code,
								'zone_code'      			=> $result_data->zone_code 
							);
						}
					}
				}
			}
		}
		return $data;
	}	
	
	public function designation_staff_zone($self_group,$zone_code)
	{
		$data = array();
		$emp_type 			= 1;
		$form_date 			= date('Y-m-d');
		$all_designation_code = DB::table('tbl_designation')
								->where('self_group', '=', $self_group)
								->select('designation_code')
								->get();
		foreach($all_designation_code as $all_designation) {
			$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.designation_code', $all_designation->designation_code)
						->where('m.br_join_date', '<=', $form_date)
						->whereNull('r.emp_id')
						->orWhere('r.effect_date', '>', $form_date)
						->groupBy('m.emp_id')
						->select('m.emp_id')
						->get();
						
			if(!empty($all_result)) {
				foreach($all_result as $result) {
					$emp_id = $result->emp_id;
					$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $result->emp_id)
						->where('m.br_join_date', '=', function($query) use ($emp_id,$form_date)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $form_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('m.emp_id')
						->first();
						
					$desig_nation = DB::table('tbl_master_tra')
										->where('emp_id', $result->emp_id)
										->where('sarok_no', $max_sarok->sarok_no)
										->select('emp_id','sarok_no','designation_code')
										->first();
					if($all_designation->designation_code == $desig_nation->designation_code) {
						$result_data = DB::table('tbl_master_tra as m')
											->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
											->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
											->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
											->leftJoin('tbl_area as ar', 'ar.area_code', '=', 'b.area_code')
											->leftJoin('tbl_zone as zn', 'zn.zone_code', '=', 'ar.zone_code')
											->where('m.emp_id', '=', $desig_nation->emp_id)
											->where('m.sarok_no', '=', $desig_nation->sarok_no)
											->select('m.emp_id','m.br_code','e.emp_name_eng','e.org_join_date','m.br_join_date','m.grade_effect_date','d.designation_name','b.branch_name','d.designation_code','d.designation_group_code','ar.area_code','ar.zone_code')
											->first();
						if($result_data->br_code !=9999 && $result_data->zone_code ==$zone_code) 
						{
							$data[] = array(
								'emp_id' 					=> $result_data->emp_id,
								'emp_name_eng'      		=> $result_data->emp_name_eng,
								'designation_name'  		=> $result_data->designation_name,
								'branch_name'      			=> $result_data->branch_name,
								'designation_group_code'    => $result_data->designation_group_code,
								'designation_code'      	=> $result_data->designation_code,
								'area_code'      			=> $result_data->area_code,
								'zone_code'      			=> $result_data->zone_code
							);
						}
					}
				}
			}
		}
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
                                    <th rowspan="2" style="text-align: center; vertical-align: middle">Installment No.</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle">Payment Date</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle">Beginning Balance</th>
                                    <th colspan="3" style="text-align: center; vertical-align: middle">Payment</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle">Ending Principal</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle">Ending Interest</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle">Payment Status</th>
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
				$loan_status = "Paid";
			} else {
				$status 	 = "class=' bg-warning'";
				$loan_status = "Not Paid";
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
                                    <td align='center'> $loan_status </td>
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
	
		public function application_location($application_id)
	{
		$recom_location 	= DB::table('loan_approval')
								->where('application_id',$application_id)
								->get();	
		$approve_location 	= DB::table('emp_loan_applications')
								->where('loan_app_id',$application_id)
								->first();								
		$data['recom_location'] 	= $recom_location;
		$data['approve_location'] 	= $approve_location;
		
		if($approve_location->loan_type_id == 1)
		{
			$author_role = 2;
		}else{
			$author_role = 1;
		}
		$data['approves_info'] 	= DB::table('loan_approval_authority')
									->where('author_role',$author_role)
									->first();		
		$data['disburs_author'] 	= DB::table('loan_approval_authority')
									->where('author_role',9)
									->first();	
		
		return view('admin.my_info.loan_application_location_tree', $data);  
	}
	
	public function loan_reports(Request $request)
	{
		if($request->input())
		{
			$date_from 		= $request->input('date_from');
			$date_to 		= $request->input('date_to');
			$loan_stage 	= $request->input('loan_stage'); 
			$action_type 	= $request->input('action_type'); 
			if($loan_stage == 10)
			{
				$infos = DB::table('emp_loan_applications as la')
					->leftJoin("loan_product as lp", 'lp.loan_product_id', '=', 'la.loan_type_id')
					->leftJoin('tbl_branch as br', 'br.br_code', '=', 'la.emp_branch')
					->leftJoin('tbl_area as ar', 'ar.area_code', '=', 'la.emp_area')
					->leftJoin('tbl_zone as zn', 'zn.zone_code', '=', 'ar.zone_code')
					->where('la.application_date', '>=', $date_from)
					->where('la.application_date', '<=', $date_to)
					//->where('la.application_stage', '=', $loan_stage)
					->where('la.is_reject', $action_type)
					->select('la.*','lp.loan_product_name','ar.area_name','zn.zone_name')	
					->orderBy('la.loan_app_id', 'Desc')
					->get();
			}else{
				$infos = DB::table('emp_loan_applications as la')
					->leftJoin("loan_product as lp", 'lp.loan_product_id', '=', 'la.loan_type_id')
					->leftJoin('tbl_branch as br', 'br.br_code', '=', 'la.emp_branch')
					->leftJoin('tbl_area as ar', 'ar.area_code', '=', 'la.emp_area')
					->leftJoin('tbl_zone as zn', 'zn.zone_code', '=', 'ar.zone_code')
					->where('la.application_date', '>=', $date_from)
					->where('la.application_date', '<=', $date_to)
					->where('la.application_stage', '=', $loan_stage)
					->where('la.is_reject', $action_type)
					->select('la.*','lp.loan_product_name','ar.area_name','zn.zone_name')	
					->orderBy('la.loan_app_id', 'Desc')
					->get();
			}
	
		}else{
			$date_from 		= date('Y-m-d');
			$date_to 		= date('Y-m-d');
			$loan_stage 	= ''; 
			$action_type 	= 0; 
			$infos = array();
		}
		$data['date_from'] 	= $date_from;
		$data['date_to'] 	= $date_to;
		$data['loan_stage'] = $loan_stage;
		$data['action_type']= $action_type;
		$data['infos'] = $infos;
		return view('admin.my_info.loan_reports', $data);  
	}
	
	public function send_mail($supervisor_mail,$emp_id,$emp_names,$designation_names,$branch_names,$application_date,$loan_type_id,$loan_amount,$loan_duration)
	{
		$emp_name_string 		= $emp_names; 
		$emp_name 				= str_replace(' ', '-', $emp_name_string);
		$designation_name_string= $designation_names;
		$designation_name 		= str_replace(' ', '-', $designation_name_string);
		$branch_name_string 	= $branch_names;
		$branch_name 			= str_replace(' ', '-', $branch_name_string);
		$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_loan/'.$supervisor_mail.'/'.$emp_id.'/'.$emp_name.'/'.$designation_name.'/'.$branch_name.'/'.$application_date.'/'.$loan_type_id.'/'.$loan_amount.'/'.$loan_duration);
		return true; 
	}
}
