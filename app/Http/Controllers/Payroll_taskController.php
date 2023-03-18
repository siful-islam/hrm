<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class Payroll_taskController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {
		$access_label 			= Session::get('admin_access_label');
		$data 					= array();
		$assign_employee		= DB::table('payroll_task_assign_employee')
										->where('task_assign_id','=',1)
										->first(); 							
		$data['assign_employee']		= $assign_employee->assign_emp_id;
		$data['assign_employee_name']	= $assign_employee->assign_employee_name; 
		$month 							= date('m');
		$year 							= date('Y');
		$number_of_days 				= cal_days_in_month(CAL_GREGORIAN, $month, $year);	
		$for_months						= $year.'-'.$month.'-'.$number_of_days; 
		$data['month']					= $month;
		$data['year']					= $year;
		$data['for_months']				= date('Y-m-t');
		$data['all_task'] 				= DB::table( 'payroll_tasks' ) 
											->get();
		$data['tasks'] 					= DB::table( 'payroll_task' )
											->where( 'task_for', '=', 1 )
											->where( 'active_status', '=', 1 )
											->get();								
		$infos 							= DB::table('payroll_tasks')
											->where('tsk_month', '=', $for_months)  
											->first();
		if($infos)
		{
			$data['infos'] = $infos;
		}else{
			$data['infos'] = array();
		}

		//print_r($data);
		return view('admin.pages.payroll_task',$data);
    }
	
	public function save_task_hr(Request $request)
	{ 
		$month 					= $request->input('month');
		$year 					= $request->input('year');
		$number_of_days 		= cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$data['tsk_month'] 					= $year.'-'.$month.'-'.$number_of_days;
		$tasks 								= $request->input('tasks');
		$data['hr_tasks'] 					= implode(',',$tasks);
		$data['hr_action_date'] 			= date("Y-m-d");
		$data['hr_action_by'] 				= $request->input('hr_action_by');
		$data['hr_assign_employee_name'] 	= $request->input('hr_assign_employee_name');
		
		$actionss = $request->input('actions');
		if($actionss)
		{
			$number = count($request->input('tasks'));
			for($i=0; $number>$i; $i++){
				$actions[]=in_array($request->input('task_name')[$i], $request->input('actions'))?1:0;
			}  
			$data['hr_tasks_status'] 		= implode(',',$actions);
				$exists 						= DB::table('payroll_tasks')
											->where('tsk_month', '=', $data['tsk_month'])  
											->select('tsk_id')
											->first();	
			if(empty($exists))
			{ 
				$status = DB::table('payroll_tasks')->insertGetId($data);
				Session::put('message','Data Saved Successfully');
				 
			}else{
				DB::table('payroll_tasks')
					->where('tsk_id', $exists->tsk_id)
					->update($data); 
				Session::put('message','Data Updated Successfully');
			}
		}else{
			Session::put('message','You must select your Task'); 
		}
		return Redirect::to('/payrol_task');
	}
}
