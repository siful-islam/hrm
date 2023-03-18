<?php

namespace App\Http\Controllers;

use App\Mail\LeaveApplication;
use App\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Leave;
use Session;
use Illuminate\Support\Facades\Redirect;

//session_start();

class LeaveController extends Controller
{
	public function __construct()
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index(Request $request)
	{
		
	}
	
	public function appliacation_modify(Request $request)
	{
		$data = array();
		$application_id 				= $request->input('m_application_id');
		$m_leave_dates 					= $request->input('m_leave_dates');
		$m_leave_from 					= $request->input('m_leave_from');
		$m_leave_to 					= $request->input('m_leave_to');
		$m_no_of_days 					= $request->input('m_no_of_days');
		$modify_remarks 				= $request->input('modify_remarks');
		$m_leave_to_actual 				= $request->input('m_leave_to_actual');
		$m_action 						= $request->input('m_action');
		$modify_cancel 					= $request->input('modify_cancel');
		// GET ALL INFORMATION
		//$info = DB::table('leave_application')->where('application_id', $application_id)->first();
		$info = DB::table('leave_application as app')
				->leftJoin('supervisors as super', 'super.supervisors_emp_id', '=', 'app.reported_to')
				->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'app.emp_id')
				->where('app.application_id', $application_id)
				->select('app.*','super.supervisors_email','basic.emp_name_eng')
				->first();
		$sub_supervisors = DB::table('supervisor_mapping_ho as mapping')
			->leftJoin('supervisors as supervisor', 'supervisor.supervisors_emp_id', '=', 'mapping.supervisor_id')
			->where('mapping.emp_id', $info->emp_id)
			->where('mapping.mapping_status', 1)
			->where('mapping.supervisor_type', 2)
			->select('supervisor.supervisors_email', 'supervisor.supervisors_emp_id')
			->first();
		if ($sub_supervisors) {
			$sub_supervisor_email 		= $sub_supervisors->supervisors_email;
			$sub_supervisors_emp_id 	= $sub_supervisors->supervisors_emp_id;
		} else {
			$sub_supervisor_email 		= '';
			$sub_supervisors_emp_id 	= '';
		}
					
		// SET DATA
		if($modify_cancel ==1)
		{
			$update['leave_dates'] 			= $m_leave_dates;
			$update['no_of_days']  			= $m_no_of_days;
		}
		if($info->sub_reported_to == '') { $update['stage'] = 1; } else { $update['stage'] = 0; }
		$update['leave_to'] 			= $m_leave_to_actual;
		$update['prev_leave_date_to'] 	= $info->leave_to;
		$update['first_super_action'] 	= 0;
		$update['super_action'] 		= 0;
		$update['prev_leave_dates']  	= $info->leave_dates;
		$update['modify_remarks']  		= $modify_remarks;
		$update['modify_cancel']  		= $modify_cancel;
		// UPDATE TABLE
		DB::table('leave_application')
			->where('application_id', $application_id)
			->update($update);

		//Mail
		$mail_data['application_id'] 				= $info->application_id;
		$mail_data['application_date'] 				= $info->application_date;
		$mail_data['emp_name'] 						= $info->emp_name_eng;
		$mail_data['emp_id'] 						= $info->emp_id;
		$mail_data['leave_from'] 					= $info->leave_from;
		$mail_data['leave_to'] 						= $info->leave_to;
		$mail_data['no_of_days'] 					= $info->no_of_days;
		$mail_data['remarks'] 						= $info->remarks;
		$mail_data['supervisor_email'] 				= $info->supervisors_email;
		$mail_data['supervisors_emp_id'] 			= $info->reported_to;
		$mail_data['sub_supervisor_email'] 			= $sub_supervisor_email;
		$mail_data['sub_supervisors_emp_id'] 		= $sub_supervisors_emp_id;
		$mail_data['modify_cancel'] 				= $modify_cancel;
		$mail_data['modify_remarks'] 				= $modify_remarks;
		\Mail::send(new LeaveApplication($mail_data));
		$success['status'] = true;
		return $success;
		//$update['prev_sup_actions']  	= $info->super_emp_id.','.$info->super_action_date.','.$info->super_action.','.$info->super_remarks;
		//$update['prev_sub_actions']  	= '';
		//$update['prev_sub_actions']  		= $info->first_super_emp_id.','.$info->first_super_action_date.','.$info->first_super_action.','.$info->first_super_remarks;
		//$update['first_super_emp_id'] 	= '';
		//$update['first_super_action_date']= '';
		//$update['first_super_remarks'] 	= '';  
		//$update['super_emp_id'] 			= '';
		//$update['super_action_date'] 		= '';
		//$update['super_remarks'] 			= '';
	}
	
	public function store(Request $request)
	{
		$data = array();
		$id = $request->input('application_id');

		if ($request->file('attachments')) {
			$photoName = time() . '.' . $request->attachments->getClientOriginalExtension();
			$request->attachments->move(public_path('leaves/'), $photoName);
		} else {
			$photoName = '';
		}
		$data['attachments'] 		= $photoName;
		$data['emp_id'] 			= $request->input('emp_id');
		$data['reported_to'] 		= $request->input('reported_to');
		$data['application_date'] 	= $request->input('application_date');
		$data['apply_for'] 			= $request->input('apply_for');
		$data['leave_type'] 		= $request->input('leave_type');
		$data['leave_from'] 		= $request->input('leave_from');
		$data['leave_to'] 			= $request->input('leave_to');
		$data['no_of_days'] 		= $request->input('no_of_days');
		$data['leave_dates'] 		= $request->input('leave_dates');
		$data['remarks'] 			= $request->input('remarks');
		$sub_supervisors_emp_id   	= $request->input('sub_supervisors_emp_id');
		$data['sub_reported_to']    = $sub_supervisors_emp_id;
		if ($sub_supervisors_emp_id == '') {
			$data['stage'] 			= 1;
		} else {
			$data['stage'] 			= 0;
		}
		
		$max_id = DB::table('leave_application')
			->where('emp_id', $data['emp_id'])
			->max('emp_app_serial');
		$data['emp_app_serial'] 	= $max_id + 1;
		// Update Last for Lock
		if($max_id)
		{
			$up_data['is_lock'] 		= 1;
			DB::table('leave_application')
			->where('emp_app_serial', $max_id)
			->where('emp_id', $data['emp_id'])
			->update($up_data);
		}
		// insert 
		$application_id 			= Leave::insertGetId($data); 
		//Mail
		$mail_data['application_id'] 				= $application_id;
		$mail_data['application_date'] 				= $request->input('application_date');
		$mail_data['emp_name'] 						= $request->input('emp_name');
		$mail_data['emp_id'] 						= $request->input('emp_id');
		$mail_data['leave_from'] 					= $request->input('leave_from');
		$mail_data['leave_to'] 						= $request->input('leave_to');
		$mail_data['no_of_days'] 					= $request->input('no_of_days');
		$mail_data['remarks'] 						= $request->input('remarks');
		$mail_data['supervisor_email'] 				= $request->input('supervisor_email');
		$mail_data['supervisors_emp_id'] 			= $request->input('reported_to');
		$mail_data['sub_supervisor_email'] 			= $request->input('sub_supervisor_email');
		$mail_data['sub_supervisors_emp_id'] 		= $request->input('sub_supervisors_emp_id');
		$mail_data['modify_cancel'] 				= 0;
		$mail_data['modify_remarks'] 				= '';
		if(!empty($mail_data['sub_supervisor_email'])){
			\Mail::send(new LeaveApplication($mail_data));
		}else{
			\Mail::send(new LeaveApplication($mail_data));
		}
		$action['status'] = true;
		echo json_encode($action);
	}

	public function validation($leave_type, $form_date, $to_date, $leave_balance,$apply_for)
	{
		$emp_id 		= Session::get('emp_id');
		// Check previous Entry
		$check_exist = DB::table('leave_application')
			->where('emp_id', $emp_id)
			->where(function ($q) use ($form_date) {
				$q->where('leave_from', '>=', $form_date)
					->orWhere('leave_to', '>=', $form_date);
			})
			->where(function ($q) use ($to_date) {
				$q->where('leave_from', '<=', $to_date)
					->orWhere('leave_to', '<=', $to_date);
			})
			->select('*')
			->orderBy('application_id', 'DESC')
			->first();
		if ($check_exist) {
			if ($check_exist->first_super_action == 2 || $check_exist->super_action == 2) {

				if($check_exist->modify_cancel == 2)
				{
					$permission  = 2;
				}
				else{
					$permission  = 1;
				}
			}
			else{
				
				if($check_exist->modify_cancel == 2)
				{
					$permission  = 1;
				}
				else{
					$permission  = 2;
				}
			}
		} else {
			$permission  = 1;
		}

		if ($permission == 1) { // if not Exist
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

			if($apply_for == 1)
			{
				$leave_days = count($actual_dates);
			}
			else{
				$leave_days = 0.5;
			}
			
			if ($leave_days == 0) {
				$flag = 0;
				$leave_days = 0;
				$message = 'There is no date for Leave Application'; 
				$leave_dates = '';
			}elseif ($leave_days == 0.5 && count($actual_dates) == 0) {
				$flag = 0;
				$leave_days = 0;
				$message = 'There is no date for Leave Application'; 
				$leave_dates = '';
			} // HOLIDAY : HALF
			elseif ($leave_days <= $leave_balance) {
				$flag = 1;
				$message = '';
				$leave_dates =	implode(",", $actual_dates);
			} elseif ($leave_days > $leave_balance) {
				$flag = 0;
				$leave_days = $leave_days;
				$message = 'You do not have enough leave balance!';
				$leave_dates = '';
			}
		} else {
			$flag = 0;
			$leave_days = 0;
			$message = 'You have existing leave dates during this period';
			$leave_dates = '';
		}

		$data['flag'] = $flag;
		$data['message'] = $message;
		$data['days'] = $leave_days;
		$data['leave_dates'] = $leave_dates;
		return $data;
	}	
	
	
	public function modify_validation($leave_type, $form_date, $to_date, $leave_balance,$apply_for)
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

			if($apply_for == 1)
			{
				$leave_days = count($actual_dates);
			}
			else{
				$leave_days = 0.5;
			}
			
			if ($leave_days == 0) {
				$flag = 0;
				$leave_days = 0;
				$message = 'There is no date for Leave Application'; 
				$leave_dates = '';
			} elseif ($leave_days <= $leave_balance) {
				$flag = 1;
				$message = '';
				$leave_dates =	implode(",", $actual_dates);
			} elseif ($leave_days > $leave_balance) {
				$flag = 0;
				$leave_days = $leave_days;
				$message = 'You do not have enough leave balance!';
				$leave_dates = '';
			}
		
		$data['flag'] = $flag;
		$data['message'] = $message;
		$data['days'] = $leave_days;
		$data['leave_dates'] = $leave_dates;
		return $data;
	}






	public function edit($id)
	{
		//return $data = Leave::find($id);
		$info = DB::table('leave_application')->where('application_id', $id)->first();
		$data['application_id'] 		= $info->application_id;
		$data['emp_id'] 				= $info->emp_id;
		$data['application_date'] 		= $info->application_date;
		$data['leave_from'] 			= $info->leave_from;
		$data['leave_to'] 				= $info->leave_to;
		$data['leave_type'] 			= $info->leave_type;
		$data['remarks'] 				= $info->remarks;
		$data['reported_to'] 			= $info->reported_to;
		$data['attachments'] 			= $info->attachments;
		return $data;
	}

	public function update(Request $request, $id)
	{
	}

	public function all_leave_application(Request $request)
	{
		$emp_id 	= Session::get('emp_id');
		$columns = array(
			0 => 'emp_app_serial',
			1 => 'application_date',
			2 => 'leave_type',
			3 => 'leave_from',
			4 => 'leave_to',
			5 => 'remarks',
			6 => 'stage',
			7 => 'attachments',
			8 => 'stage',
		);
		$totalData 		= Leave::where('emp_id', $emp_id)->count();
		$totalFiltered 	= $totalData;
		$limit 			= $request->input('length');
		$start 			= $request->input('start');
		$order 			= $columns[$request->input('order.0.column')];
		$dir 			= $request->input('order.0.dir');

		if (empty($request->input('search.value'))) {
			$infos = Leave::leftjoin('tbl_leave_type', 'tbl_leave_type.id', '=', 'leave_application.leave_type')
				->offset($start)
				->where('emp_id', $emp_id)
				->select('leave_application.*','tbl_leave_type.type_name')
				->limit($limit)
				//->orderBy($order, $dir)
				->orderBy('application_id', $dir)
				->get();
		} else {
			$search = $request->input('search.value');
			$infos =  Leave::leftjoin('tbl_leave_type', 'tbl_leave_type.id', '=', 'leave_application.leave_type')
				->where('emp_id', $emp_id)
				->where(function ($q) use ($search) {
					$q->where('leave_application.application_date', 'LIKE', "%{$search}%")
						->orWhere('tbl_leave_type.type_name', 'LIKE', "%{$search}%")
						->orWhere('leave_application.remarks', 'LIKE', "%{$search}%");
				})
				->select('leave_application.*','tbl_leave_type.type_name')
				->offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();
			$totalFiltered = Leave::leftjoin('tbl_leave_type', 'tbl_leave_type.id', '=', 'leave_application.leave_type')
				->where('emp_id', $emp_id)
				->where(function ($q) use ($search) {
					$q->where('leave_application.application_date', 'LIKE', "%{$search}%")
						->orWhere('tbl_leave_type.type_name', 'LIKE', "%{$search}%")
						->orWhere('leave_application.remarks', 'LIKE', "%{$search}%");
				})
				->count();
		}
		$data = array();
		if (!empty($infos)) {
			$i = 1;
			foreach ($infos as $info) {
				///$nestedData['sl'] 					= $i++;
				$days = $info->no_of_days > 1 ? 'Days' : 'Day';

				$nestedData['sl'] 						= $info->emp_app_serial;
				$nestedData['application_date'] 		= date("d-m-Y", strtotime($info->application_date));
				$nestedData['leave_type'] 				= $info->type_name;
				$nestedData['leave_from'] 				= date("d-m-Y", strtotime($info->leave_from));
				$nestedData['leave_to']					= date("d-m-Y", strtotime($info->leave_to));
				$nestedData['no_of_days']				= $info->no_of_days.' '.$days;
				$nestedData['remarks']					= $info->remarks;

				if ($info->stage == 0 && $info->modify_cancel ==0) {
					$status = 'Pending..';
					$class = 'label label-default';
				} else if ($info->stage == 0 && $info->modify_cancel ==1) {
					$status = 'Pending(Modified)';
					$class = 'label label-default';
				} else if ($info->stage == 0 && $info->modify_cancel ==2) {
					$status = 'Pending(Cancellation)';
					$class = 'label label-default';
				} else if ($info->stage == 1 && $info->first_super_action == 1 && $info->modify_cancel ==0) {
					$status = 'Recommended for leave';
					$class = 'label label-info';
				} else if ($info->stage == 1 && $info->first_super_action == 1 && $info->modify_cancel ==1) {
					$status = 'Recommended (Modified)';
					$class = 'label label-info';
				}else if ($info->stage == 1 && $info->first_super_action == 1 && $info->modify_cancel ==2) {
					$status = 'Recommended (Cancellation)';
					$class = 'label label-info';
				} else if ($info->stage == 1 && $info->first_super_action == 2 && $info->modify_cancel ==0) {
					$status = 'Rejected by Sub Supervisor';
					$class = 'label label-warning';
				}else if ($info->stage == 1 && $info->first_super_action == 2 && $info->modify_cancel ==1) {
					$status = 'Rejected by Sub Supervisor (Modified)';
					$class = 'label label-warning';
				}else if ($info->stage == 1 && $info->first_super_action == 2 && $info->modify_cancel ==2) {
					$status = 'Rejected by Sub Supervisor (Cancellation)';
					$class = 'label label-warning';
				} else if ($info->stage == 1 && $info->first_super_action == 0 && $info->modify_cancel ==0) {
					$status = 'Pending..';
					$class = 'label label-default';
				}else if ($info->stage == 1 && $info->first_super_action == 0 && $info->modify_cancel ==1) {
					$status = 'Pending(Modified)';
					$class = 'label label-default';
				}else if ($info->stage == 1 && $info->first_super_action == 0 && $info->modify_cancel ==2) {
					$status = 'Pending(Cancellation)';
					$class = 'label label-default';
				} elseif ($info->stage == 2 && $info->super_action == 1 && $info->modify_cancel ==0) {
					$status = 'Approved';
					$class = 'label label-success';
				}elseif ($info->stage == 2 && $info->super_action == 1 && $info->modify_cancel ==1) {
					$status = 'Approved (Modified)';
					$class = 'label label-success';
				}elseif ($info->stage == 2 && $info->super_action == 1 && $info->modify_cancel ==2) {
					$status = 'Approved (Cancellation)';
					$class = 'label label-success';
				} elseif ($info->stage == 2 && $info->super_action == 2 && $info->modify_cancel ==0) {
					$status = 'Rejected by supervisor';
					$class = 'label label-danger';
				}elseif ($info->stage == 2 && $info->super_action == 2 && $info->modify_cancel ==1) {
					$status = 'Rejected by supervisor (Modified)';
					$class = 'label label-danger';
				}elseif ($info->stage == 2 && $info->super_action == 2 && $info->modify_cancel ==2) {
					$status = 'Rejected by supervisor (Cancellation)';
					$class = 'label label-danger';
				} elseif ($info->stage == 3) {
					$status = 'Executed by HRD';
					$class = 'label label-success';
				}

				$nestedData['status']					= '<span class="' . $class . '">' . $status . '<span>';

				if ($info->attachments) {
					$nestedData['view'] = '<button class="btn btn-sm btn-success btn-xs"  title="View" onclick="view_leave_info(' . $info->application_id . ')"> View </button>
					<a class="btn btn-sm btn-warning btn-xs" target="_blank" href="/demo_hrm/public/leaves/' . $info->attachments . '"><i class="fa fa-picture-o" aria-hidden="true"></i></a>';
				} else {
					$nestedData['view'] = '<button class="btn btn-sm btn-success btn-xs"  title="View" onclick="view_leave_info(' . $info->application_id . ')"> View</button>';
				}
				
				
				if($info->super_action == 1 && $info->apply_for == 1 && $info->modify_cancel == 0 && $info->is_lock == 0)
				{
					$actions = '<button class="btn btn-sm btn-warning btn-xs"  title="Modify" onclick="modify_leave(' . $info->application_id . ',1)"><i class="fa fa-pencil" aria-hidden="true"></i> Modify</button>
								<button class="btn btn-sm btn-danger btn-xs"  title="Cancel" onclick="modify_leave(' . $info->application_id . ',2)"><i class="fa fa-times" aria-hidden="true"></i> Cance</button>';
				}
				else if($info->super_action == 1 && $info->apply_for != 1 && $info->modify_cancel == 0 && $info->is_lock == 0)
				{
					$actions = '<button class="btn btn-sm btn-danger btn-xs"  title="Cancel" onclick="modify_leave(' . $info->application_id . ',2)"><i class="fa fa-times" aria-hidden="true"></i> Cance</button>';
				}
				else{
					$actions = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';
				}
				$nestedData['options'] 					= $actions;
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





/* BEFORE VALIDATION

	public function store(Request $request)
	{
		$data = array();
		$id = $request->input('application_id');

			if ($request->file('attachments')) {
				$photoName = time() . '.' . $request->attachments->getClientOriginalExtension();
				$request->attachments->move(public_path('leaves/'), $photoName);
			} else {
				$photoName = '';
			}
			$data['attachments'] 		= $photoName;
			$data['emp_id'] 			= $request->input('emp_id');
			$data['reported_to'] 		= $request->input('reported_to');
			$data['application_date'] 	= $request->input('application_date');
			$data['apply_for'] 			= $request->input('apply_for');
			$data['leave_type'] 		= $request->input('leave_type');
			$data['leave_from'] 		= $request->input('leave_from');
			$data['leave_to'] 			= $request->input('leave_to');
			$data['no_of_days'] 		= $request->input('no_of_days');
			$data['leave_dates'] 		= $request->input('leave_dates');
			$data['remarks'] 			= ucfirst($request->input('remarks'));
			$sub_supervisors_emp_id   	= $request->input('sub_supervisors_emp_id');
			$data['sub_reported_to']    = $sub_supervisors_emp_id;
			if ($sub_supervisors_emp_id == '') {
				$data['stage'] 			= 1;
			} else {
				$data['stage'] 			= 0;
			}
			$max_id = DB::table('leave_application')
				->where('emp_id', $data['emp_id'])
				->max('emp_app_serial');

			$data['emp_app_serial'] 	= $max_id + 1;
			// insert 
			$application_id 			= Leave::insertGetId($data);

			//Mail
			$mail_data['application_id'] 				= $application_id;
			$mail_data['application_date'] 				= $request->input('application_date');
			$mail_data['emp_name'] 						= $request->input('emp_name');
			$mail_data['emp_id'] 						= $request->input('emp_id');
			$mail_data['leave_from'] 					= $request->input('leave_from');
			$mail_data['leave_to'] 						= $request->input('leave_to');
			$mail_data['no_of_days'] 					= $request->input('no_of_days');
			$mail_data['remarks'] 						= $request->input('remarks');
			$mail_data['supervisor_email'] 				= $request->input('supervisor_email');
			$mail_data['supervisors_emp_id'] 			= $request->input('reported_to');
			$mail_data['sub_supervisor_email'] 			= $request->input('sub_supervisor_email');
			$mail_data['sub_supervisors_emp_id'] 		= $request->input('sub_supervisors_emp_id');
			if(!empty($mail_data['sub_supervisor_email'])){
				\Mail::send(new LeaveApplication($mail_data));
			}else{
				\Mail::send(new LeaveApplication($mail_data));
			}
			$action['status'] = true;
			echo json_encode($action);
	}

	public function validation($leave_type, $form_date, $to_date, $leave_balance,$apply_for)
	{

		$emp_id 		= Session::get('emp_id');
		// Check previous Entry
		$check_exist = DB::table('leave_application')
			->where('emp_id', $emp_id)
			->where(function ($q) use ($form_date) {
				$q->where('leave_from', '>=', $form_date)
					->orWhere('leave_to', '>=', $form_date);
			})
			->where(function ($q) use ($to_date) {
				$q->where('leave_from', '<=', $to_date)
					->orWhere('leave_to', '<=', $to_date);
			})
			->select('*')
			->orderBy('application_id', 'DESC')
			->first();
		if ($check_exist) {
			if ($check_exist->first_super_action == 2 || $check_exist->super_action == 2) {
				$permission  = 1;
			} else {
				$permission  = 2;
			}
		} else {
			$permission  = 1;
		}


		if ($permission == 1) { // if not Exist
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

			if($apply_for == 1)
			{
				$leave_days = count($actual_dates);
			}
			else{
				$leave_days = 0.5;
			}
			
			if ($leave_days == 0) {
				$flag = 0;
				$leave_days = 0;
				$message = 'There is no date for Leave Application'; 
				$leave_dates = '';
			}elseif ($leave_days == 0.5 && count($actual_dates) == 0) {
				$flag = 0;
				$leave_days = 0;
				$message = 'There is no date for Leave Application'; 
				$leave_dates = '';
			} 
			elseif ($leave_days <= $leave_balance) {
				$flag = 1;
				$message = '';
				$leave_dates =	implode(",", $actual_dates);
			}
			elseif ($leave_days > $leave_balance) {
				$flag = 0;
				$leave_days = $leave_days;
				$message = 'You do not have enough leave balance!';
				$leave_dates = '';
			}
		} else {
			$flag = 0;
			$leave_days = 0;
			$message = 'You have existing leave dates during this period';
			$leave_dates = '';
		}

		$data['flag'] = $flag;
		$data['message'] = $message;
		$data['days'] = $leave_days;
		$data['leave_dates'] = $leave_dates;
		return $data;
	} */






	public function edit($id)
	{
		//return $data = Leave::find($id);
		$info = DB::table('leave_application')->where('application_id', $id)->first();
		$data['application_id'] 		= $info->application_id;
		$data['emp_id'] 				= $info->emp_id;
		$data['application_date'] 		= $info->application_date;
		$data['leave_from'] 			= $info->leave_from;
		$data['leave_to'] 				= $info->leave_to;
		$data['leave_type'] 			= $info->leave_type;
		$data['remarks'] 				= $info->remarks;
		$data['reported_to'] 			= $info->reported_to;
		$data['attachments'] 			= $info->attachments;
		return $data;
	}

	public function update(Request $request, $id)
	{
	}

/* BEFORE ROLLBACK

	public function all_leave_application(Request $request)
	{
		$emp_id 	= Session::get('emp_id');
		$columns = array(
			0 => 'emp_app_serial',
			1 => 'application_date',
			2 => 'leave_type',
			3 => 'leave_from',
			4 => 'leave_to',
			5 => 'remarks',
			6 => 'stage',
			7 => 'attachments',
			8 => 'stage',
		);
		$totalData 		= Leave::where('emp_id', $emp_id)->count();
		$totalFiltered 	= $totalData;
		$limit 			= $request->input('length');
		$start 			= $request->input('start');
		$order 			= $columns[$request->input('order.0.column')];
		$dir 			= $request->input('order.0.dir');

		if (empty($request->input('search.value'))) {
			$infos = Leave::leftjoin('tbl_leave_type', 'tbl_leave_type.id', '=', 'leave_application.leave_type')
				->offset($start)
				->where('emp_id', $emp_id)
				->select('leave_application.*','tbl_leave_type.type_name')
				->limit($limit)
				//->orderBy($order, $dir)
				->orderBy('application_id', $dir)
				->get();
		} else {
			$search = $request->input('search.value');
			$infos =  Leave::leftjoin('tbl_leave_type', 'tbl_leave_type.id', '=', 'leave_application.leave_type')
				->where('emp_id', $emp_id)
				->where(function ($q) use ($search) {
					$q->where('leave_application.application_date', 'LIKE', "%{$search}%")
						->orWhere('tbl_leave_type.type_name', 'LIKE', "%{$search}%")
						->orWhere('leave_application.remarks', 'LIKE', "%{$search}%");
				})
				->select('leave_application.*','tbl_leave_type.type_name')
				->offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();
			$totalFiltered = Leave::leftjoin('tbl_leave_type', 'tbl_leave_type.id', '=', 'leave_application.leave_type')
				->where('emp_id', $emp_id)
				->where(function ($q) use ($search) {
					$q->where('leave_application.application_date', 'LIKE', "%{$search}%")
						->orWhere('tbl_leave_type.type_name', 'LIKE', "%{$search}%")
						->orWhere('leave_application.remarks', 'LIKE', "%{$search}%");
				})
				->count();
		}
		$data = array();
		if (!empty($infos)) {
			$i = 1;
			foreach ($infos as $info) {
				///$nestedData['sl'] 					= $i++;
				$days = $info->no_of_days > 1 ? 'Days' : 'Day';

				$nestedData['sl'] 						= $info->emp_app_serial;
				$nestedData['application_date'] 		= date("d-m-Y", strtotime($info->application_date)); 
				$nestedData['leave_type'] 				= $info->type_name;
				$nestedData['leave_from'] 				= date("d-m-Y", strtotime($info->leave_from)); 
				$nestedData['leave_to']					= date("d-m-Y", strtotime($info->leave_to)); 
				$nestedData['no_of_days']				= $info->no_of_days.' '.$days;
				$nestedData['remarks']					= $info->remarks;

				if ($info->stage == 0) {
					$status = 'Pending..';
					$class = 'label label-default';
					$actions = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';
				} else if ($info->stage == 1 && $info->first_super_action == 1) {
					$status = 'Recommended for leave';
					$class = 'label label-info';
					$actions = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';
				} else if ($info->stage == 1 && $info->first_super_action == 2) {
					$status = 'Rejected by Sub Supervisor';
					$class = 'label label-warning';
					$actions = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';
				} else if ($info->stage == 1 && $info->first_super_action == 0) {
					$status = 'Pending..';
					$class = 'label label-default';
					$actions = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';
				} elseif ($info->stage == 2 && $info->super_action == 1) {
					$status = 'Approved';
					$class = 'label label-success';
					$actions = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';
				} elseif ($info->stage == 2 && $info->super_action == 2) {
					$status = 'Rejected by supervisor';
					$class = 'label label-danger';
					$actions = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';
				} elseif ($info->stage == 3) {
					$status = 'Executed by HRD';
					$class = 'label label-success';
					$actions = '<button class="btn btn-sm btn-default btn-xs"  title="Lock"><i class="fa fa-lock" aria-hidden="true"></i></button>';
				}

				$nestedData['status']					= '<span class="' . $class . '">' . $status . '<span>';

				if ($info->attachments) {
					$nestedData['view'] = '<button class="btn btn-sm btn-success btn-xs"  title="View" onclick="view_leave_info(' . $info->application_id . ')"> View </button>
					<a class="btn btn-sm btn-warning btn-xs" target="_blank" href="/hrm/public/leaves/' . $info->attachments . '"><i class="fa fa-picture-o" aria-hidden="true"></i></a>';
				} else {
					$nestedData['view'] = '<button class="btn btn-sm btn-success btn-xs"  title="View" onclick="view_leave_info(' . $info->application_id . ')"> View</button>';
				}
				$nestedData['options'] 					= $actions;
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
	} */






	public function approval_report_2(Request $request)
	{

		/*$data = array();
		$data['Heading'] 		= $data['title'] = 'Approval Status';
		$data['form_date']		= date('Y-m-d');
		$data['to_date']		= date('Y-m-d');
		$data['emp_id']			= '';
		$data['activities']		= 1;
		$data['all_result'] = array();
		return view('admin.my_info.report_approval', $data);
		*/



		$emp_id 		= 2397;
		$form_date 		= '2020-12-08';
		$to_date 		= '2020-12-08';
	}
	
	
	public function approval_report(Request $request)
	{
		/*$leave_dates = DB::table('leave_application')
				->where('application_id', 1)
				->first();
		$dates = (explode(",",$leave_dates->leave_dates));	
		$max_no_leave = $leave_dates->no_of_days;
		
		$check_old_balance 		= 1.5;
		$check_pre_balance 		= 1;
		$check_current_balance  = 15;
		
		if($check_old_balance > 0)
		{
			$for_old_dates 			= array_slice($dates, 0, $check_old_balance); 
			$rest_dates_from_old 	= array_slice($dates,$check_old_balance);
			$old_days 				= count($for_old_dates);
			$rest_old_days 			= count($rest_dates_from_old);
			if($max_no_leave >= $check_old_balance)
			{
				$old_leave_date_from = $dates[0];
				$old_leave_date_to = $dates[$check_old_balance - 1];
				$leave_dates = array();
				$old_flag = 2;
			}
			else{
				$old_leave_date_from = $dates[0];
				$old_leave_date_to = $dates[$max_no_leave - 1];
				$leave_dates = array();
				$old_flag = 1;
			}
		}
		else
		{
			$old_flag = 3;
		}
		
		echo $old_flag;
		echo $old_days ;
		echo '<br>';
		echo $rest_old_days ;
		exit;
		
		*/

		$data = array();
		$data['Heading'] 		= $data['title'] = 'Approval Status';
		$data['form_date']		= date('Y-m-d');
		$data['to_date']		= date('Y-m-d');
		$data['emp_id']			= '';
		$data['activities']		= 0;
		$data['all_result'] = array();
		return view('admin.my_info.report_approval', $data);
	}


	public function approval_reports(Request $request)
	{
		$form_date 		= $request->input('form_date');
		 
		$to_date 		= $request->input('to_date');
		$emp_id 		= $request->input('emp_id');
		$activities 	= $request->input('activities');
		$emp_id_sup 		= Session::get('emp_id'); 
		 $all_result = DB::table('leave_application as app')
			->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'app.emp_id')
			->leftJoin('tbl_emp_basic_info as sub_basic', 'app.first_super_emp_id', '=', 'sub_basic.emp_id')
			->leftJoin('tbl_emp_basic_info as sup_basic', 'app.super_emp_id', '=', 'sup_basic.emp_id')
			->leftJoin('tbl_leave_type as type', 'app.leave_type', '=', 'type.id')
			->where(function ($query) use ($emp_id, $activities, $form_date, $to_date, $emp_id_sup) {
				if ($emp_id != '') {
					$query->where('app.emp_id', $emp_id);
				}
				if($activities == 0){
					if($emp_id != '' && $activities > 0){
						$query->where('app.emp_id', '=', $emp_id)->where('app.super_action', '=', $activities)->where('app.super_emp_id', '=', $emp_id_sup)->whereBetween('app.super_action_date', [$form_date, $to_date]);
						$query->orwhere('app.first_super_emp_id', '=', $emp_id_sup)->where('app.first_super_action', '=', $activities)->where('app.emp_id', '=', $emp_id)->whereBetween('app.first_super_action_date', [$form_date, $to_date]);
					}if($emp_id != '' && $activities == 0){
						$query->where('app.emp_id', '=', $emp_id)->where('app.super_emp_id', '=', $emp_id_sup)->whereBetween('app.super_action_date', [$form_date, $to_date]);
						$query->orwhere('app.first_super_emp_id', '=', $emp_id_sup)->where('app.emp_id', '=', $emp_id)->whereBetween('app.first_super_action_date', [$form_date, $to_date]);
					}else{
						$query->where('app.super_emp_id', '=', $emp_id_sup)->whereBetween('app.super_action_date', [$form_date, $to_date]);
						$query->orwhere('app.first_super_emp_id', '=', $emp_id_sup)->whereBetween('app.first_super_action_date', [$form_date, $to_date]);
					}
					
				}else if ($activities == 3) {
					$query->where('app.first_super_emp_id', '=', $emp_id_sup)
						->where('app.first_super_action', '=', 1)
						->whereBetween('app.first_super_action_date', [$form_date, $to_date]);
				} else if ($activities == 4) {
					$query->where('app.first_super_emp_id', '=', $emp_id_sup)
						->where('app.first_super_action', '=', 2)
						->whereBetween('app.first_super_action_date', [$form_date, $to_date]);
				} else {
					$query->where('app.super_emp_id', '=', $emp_id_sup)
						->where('app.super_action', '=', $activities)
						->whereBetween('app.super_action_date', [$form_date, $to_date]);
				}
			})
			->select('app.*', 'type.type_name', 'basic.emp_name_eng', 'sub_basic.emp_name_eng as sub_emp_name', 'sup_basic.emp_name_eng as sup_emp_name',DB::raw('DATE_FORMAT(app.leave_from, "%d-%m-%Y") as leave_from'),DB::raw('DATE_FORMAT(app.leave_to, "%d-%m-%Y") as leave_to'),DB::raw('DATE_FORMAT(app.application_date, "%d-%m-%Y") as application_date'),DB::raw('DATE_FORMAT(app.super_action_date, "%d-%m-%Y") as super_action_date'),DB::raw('DATE_FORMAT(app.first_super_action_date, "%d-%m-%Y") as first_super_action_date'))
			->get();

		$data['Heading'] 		= $data['title'] = 'Approval Status';
		$data['form_date']		= $form_date;
		$data['to_date']		= $to_date;
		$data['emp_id']			= $emp_id;
		$data['activities']		= $activities; 
		//echo json_encode(array('data' => $all_result,'single_item' => $single_item,'total_row' => 4));
		echo json_encode(array('all_result' => $all_result,'form_date' => $form_date));
		//return $data;
		//return view('admin.my_info.report_approval', $data); 
	}





	public function leave_rejection(Request $request)
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

		echo json_encode($action);
	}
}
