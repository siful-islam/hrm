<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use DateTime;

//session_start();

class AttendenceController extends Controller
{
	public function __construct()
	{
		$this->middleware("CheckUserSession");
	}
	

	public function index(Request $request)
	{
		$data 			= array();	
		$emp_id 		= Session::get('emp_id');
		$today 			= date('Y-m-d');
		$last_date 		= date("Y-m-t", strtotime($today));
		if($request->input())
		{
			$report_month 	= $request->input('report_month');  
			$report_year  	= $request->input('report_year');
			$from_date 		= $report_year.'-'.$report_month.'-01';		
			$to_date 		= date("Y-m-t", strtotime($from_date));
		}else{
			
			$report_month 	= date('m');
			$report_year  	= date('Y');
			$from_date 		= date('Y-m-01');		
			$to_date 		= $last_date;
		}
		$data['report_month'] 	= $report_month;
		$data['report_year'] 	= $report_year;
		$data['info'] = DB::table('tblt_timesheet')
				->where('punchingcode', '=', $emp_id)
				->select('punchingcode','date as working_date', DB::raw('max(time) as out_time'), DB::raw('min(time) as in_time'))
				->groupBy('punchingcode')
				->groupBy('date')
				->orderBy('date', 'desc')
				->get();		
		$data['leave_info'] = 	DB::table('leave_application')
							->where('stage', '=', 2)
							->where('emp_id', '=', $emp_id)
							->where('leave_from', '>=', $from_date)
							->where('leave_to', '<=', $to_date)
							->select('leave_dates','no_of_days','apply_for')
							->get();		
		$data['visit_info'] = 	DB::table('tbl_movement_register')
							->where('stage', '=', 2)
							->where('emp_id', '=', $emp_id)
							->where('from_date', '>=', $from_date)
							->where('to_date', '<=', $to_date)
							->select('emp_id','from_date','arrival_date','return_time','purpose')
							->get();
		$data['holidays'] = DB::table('tbl_holidays')
							->where('holiday_date', '>=', $from_date)
							->where('holiday_date', '<=', $to_date)
							->select('holiday_date','description')
							->get();				
		$basic = DB::table('tbl_emp_basic_info as basic')
						->leftJoin('tbl_emp_photo as photo', 'basic.emp_id', '=', 'photo.emp_id')
						->where('basic.emp_id', $emp_id)
						->select('photo.emp_photo','basic.emp_name_eng','basic.gender')
						->first();			
		if($basic->emp_photo)
		{
			$data['emp_photo'] 	= $basic->emp_photo;
		}else{
			$data['emp_photo'] 	= '';
		}
		$data['month'] 		= $report_month;		
		$data['year'] 		= $report_year;		
		$data['emp_id'] 	= $emp_id;		
		$data['emp_name'] 	= $basic->emp_name_eng;		
		$data['gender'] 	= $basic->gender;	
		return view('admin.my_info.my_attandence', $data);
	}
	
}