<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Middleware\CheckUserSession;
use DB;
use Session;

class MovementsupervisorController extends Controller
{

	public function __construct()
	{
	 
		$this->middleware('CheckUserSession'); 
	}    
	public function index(Request $request)
	{
		$emp_id 		= Session::get('emp_id');
		/* echo $emp_id;
		exit; */
		$letter_date 	= date('Y-m-d');
		$data = array();
		$data['form_date'] = date("Y-m-d");
		$data['to_date'] = date("Y-m-d");
		$data['my_stafs'] = DB::table('supervisor_mapping_ho as staff')
							->leftJoin("tbl_movement_register as app", 'app.emp_id', '=', 'staff.emp_id')
							->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'staff.emp_id')
							->where('staff.supervisor_id', $emp_id)
							->where(function ($query) {
								
								$query->where('app.stage', '=', 0)->Where('staff.supervisor_type', 2);
								$query->orwhere('app.stage', '=', 1)->Where('staff.supervisor_type', 1);
							}) 
							->select('staff.*','app.*','tbl_emp_photo.*','staff.emp_id')
							->orderBy('staff.emp_id', 'ASC')
							->get(); 
		/*  echo "<pre>";
		print_r($data['my_stafs']);
		exit;   */
		
		$data['branch_list'] = DB::table('tbl_branch')  
									->where('status',1)
									->orderby('branch_name','asc')
									->select('br_code','branch_name')
									->get();
		/* print_r($data['my_stafs']);
		exit; */
		return view('admin.movement_register.movement_approval', $data);
	}
	public function move_appliacation_approve(Request $request)
	{
		$move_id = $request->move_id;
		$supervisor_type = $request->supervisor_type;
		$supervisor_id 	= $request->supervisor_id;
		$action 		= $request->action;
		$remarks 		= $request->remarks;
		$data = array();
		if ($supervisor_type == 2) {
			$data['stage'] = 1;
			$data['first_super_emp_id'] = $supervisor_id;
			$data['first_super_action_date'] = date('Y-m-d');
			$data['first_super_action'] = $action;
			$data['first_super_remarks'] = $remarks;
		} elseif ($supervisor_type == 1) {

			$data['stage'] 				= 2;
			$data['super_emp_id'] 		= $supervisor_id;
			$data['super_action_date'] 	= date('Y-m-d');
			$data['super_action'] 		= $action;
			$data['super_remarks'] 		= $remarks;
		}
		DB::table('tbl_movement_register')
			->where('move_id', $move_id)
			->update($data);

		$status = true;
		echo json_encode($status);
	}
	
	public function movement_approval(Request $request)
	{

		$data = array();

		$move_id = $request->move_id;
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

		$action['status'] = DB::table('tbl_movement_register')
			->where('move_id', $move_id)
			->update($data);

		echo json_encode($action);
	}
	public function move_bulk_action(Request $request)
	{
		$move_id 			= $request->move_id;
		$supervisor_type 			= $request->supervisor_type;
		$supervisor_id 				= $request->supervisor_id;
		$flag 						= $request->flag;
		if ($flag) {
			$accept 			= $flag;
		} else {
			$accept 			= array();
		}
		$result = array_intersect($move_id, $accept);
		$applications = array_combine($move_id, $supervisor_type);

		foreach ($applications as $key => $sup_type) {
			if (in_array($key, $result)) {
				$action = 1;
			} else {
				$action = 2;
			}
			if ($sup_type == 2) {
				$sub_data = array();
				$sub_data['stage'] = 1;
				$sub_data['first_super_emp_id'] = $supervisor_id[0];
				$sub_data['first_super_action_date'] = date('Y-m-d');
				$sub_data['first_super_action'] = $action;
				DB::table('tbl_movement_register')
					->where('move_id', $key)
					->update($sub_data);
			} elseif ($sup_type == 1) {
				$main_data = array();
				$main_data['stage'] = 2;
				$main_data['super_emp_id'] = $supervisor_id[0];
				$main_data['super_action_date'] = date('Y-m-d');
				$main_data['super_action'] = $action;
				DB::table('tbl_movement_register')
					->where('move_id', $key)
					->update($main_data);
			}
		}
		return Redirect::to('/movement_approve');
	}
	
	public function approval_report_visit(Request $request)
	{

		$data = array();
		$data['Heading'] 		= $data['title'] = 'Approval Status';
		$data['form_date']		= date('Y-m-d');
		$data['to_date']		= date('Y-m-d');
		$data['emp_id']			= '';
		$data['activities']		= 0;
		$data['all_result'] = array();
		$data['branch_list'] = DB::table('tbl_branch') 
									->orderby('branch_name','asc')
									->select('br_code','branch_name')
									->get();
		return view('admin.movement_register.report_approval_visit', $data);
	}
	public function approval_reports_visit(Request $request)
	{
		$form_date 		= $request->input('form_date');
		$to_date 		= $request->input('to_date');
		$emp_id 		= $request->input('emp_id');
		$activities 	= $request->input('activities');
		$emp_id_sup 		= Session::get('emp_id');
		

		$all_result = DB::table('tbl_movement_register as app')
								->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'app.emp_id')
								->leftJoin('tbl_emp_basic_info as sub_basic', 'app.first_super_emp_id', '=', 'sub_basic.emp_id')
								->leftJoin('tbl_emp_basic_info as sup_basic', 'app.super_emp_id', '=', 'sup_basic.emp_id')
								 
								->where(function ($query) use ($emp_id, $activities,$form_date,$to_date,$emp_id_sup) {
									 if ($emp_id != '' && $activities > 0) {
										$query->where('app.emp_id', $emp_id);
									}
									if($activities == 0){
										
										if($emp_id != '' && $activities > 0){
											$query->where('app.emp_id', '=', $emp_id)->where('app.super_action', '=', $activities)->where('app.super_emp_id', '=', $emp_id_sup)->whereBetween('app.super_action_date', [$form_date, $to_date]);
											$query->orwhere('app.first_super_emp_id', '=', $emp_id_sup)->where('app.first_super_action', '=', $activities)->where('app.emp_id', '=', $emp_id)->whereBetween('app.first_super_action_date', [$form_date, $to_date]);
										}if($emp_id != '' && $activities == 0){
											$query->where('app.emp_id', '=', $emp_id)->where('app.super_emp_id', '=', $emp_id_sup)->where('app.super_action', '!=', 0)->whereBetween('app.super_action_date', [$form_date, $to_date]);
											$query->orwhere('app.first_super_emp_id', '=', $emp_id_sup)->where('app.first_super_action', '!=', 0)->where('app.emp_id', '=', $emp_id)->whereBetween('app.first_super_action_date', [$form_date, $to_date]);
										}else{
											$query->where('app.super_emp_id', '=', $emp_id_sup)->where('app.super_action', '!=', 0)->whereBetween('app.super_action_date', [$form_date, $to_date]);
											$query->orwhere('app.first_super_emp_id', '=', $emp_id_sup)->where('app.first_super_action', '!=', 0)->whereBetween('app.first_super_action_date', [$form_date, $to_date]);
										}   
									}else if ($activities == 3) {
										$query->where('app.first_super_emp_id', '=', $emp_id_sup)
												->where('app.first_super_action', '=', 1)
												->whereBetween('app.first_super_action_date', [$form_date,$to_date]);
									} 
									else if ($activities == 4) {
										$query->where('app.first_super_emp_id', '=', $emp_id_sup)
												->where('app.first_super_action', '=', 2) 
												->whereBetween('app.first_super_action_date', [$form_date,$to_date]);
									}else {
										$query->where('app.super_emp_id', '=', $emp_id_sup)
												->where('app.super_action', '=', $activities)
												->whereBetween('app.super_action_date', [$form_date,$to_date]);
												
									}
								})
								
								->select('app.*','basic.emp_name_eng', 'sub_basic.emp_name_eng as sub_emp_name', 'sup_basic.emp_name_eng as sup_emp_name',DB::raw('DATE_FORMAT(app.super_action_date, "%d-%m-%Y") as super_action_date'),DB::raw('DATE_FORMAT(app.first_super_action_date, "%d-%m-%Y") as first_super_action_date'),DB::raw('DATE_FORMAT(app.application_date, "%d-%m-%Y") as application_date'),DB::raw('DATE_FORMAT(app.from_date, "%d-%m-%Y") as from_date'),DB::raw('DATE_FORMAT(app.to_date, "%d-%m-%Y") as to_date'))
								->get();
		$branch_list = DB::table('tbl_branch') 
									->orderby('branch_name','asc')
									->select('br_code','branch_name')
									->get();
	
		$data['Heading'] 		= $data['title'] = 'Approval Status';
		$data['form_date']		= $form_date;
		$data['to_date']		= $to_date;
		$data['emp_id']			= $emp_id;
		$data['activities']		= $activities;
		echo json_encode(array('all_result' => $all_result,'branch_list' => $branch_list));
		//return view('admin.movement_register.report_approval_visit', $data);
	}
}
