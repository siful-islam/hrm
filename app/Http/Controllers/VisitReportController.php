<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Middleware\Checkuser;
use DB;
use Session; 
class VisitReportController extends Controller
{

	 public function __construct() 
	{
		$this->middleware("CheckUserSession");
	} 
	public function emp_visit_report()
	{
		 
		 $emp_id = 3628;
		 $db_id = 0;
		 /* $date_exist =  DB::table('tbl_movement_register')
							->where('emp_id', $emp_id) 
							->where('first_super_action','!=',2) 
							->where('super_action','!=',2)  
							->select(DB::raw('MIN(from_date) as db_from_date'),DB::raw('MAX(arrival_date) as db_arrival_date')) 
							->first();
		 
		 
		 
		 $from_date = $date_exist->db_from_date;
		 $to_date = $date_exist->db_arrival_date; */
		 /*  $from_date = "2021-02-01";
		  $to_date = "2021-02-20";
		  $leave_time_form = "7:00 AM";
		 //$to_date = "2021-02-12";
		  
			  $dates = array();
			  $current = strtotime($from_date);
			  $to_date = strtotime($to_date);
			  $stepVal = '+1 day';
			  while( $current <= $to_date ) {
				 $dates[] = date("Y-m-d", $current);
				 $current = strtotime($stepVal, $current);
				 
				 
			  }  
			  $permission = 1;
			   foreach($dates as $v_dates){
				 
				$date_exist =  DB::table('tbl_movement_register')
								->where('emp_id', $emp_id) 
								->where('first_super_action','!=',2) 
								->where('super_action','!=',2) 
								->where('arrival_date', '>=', $v_dates) 
								->where('from_date', '<=', $v_dates) 
								->select('move_id','from_date','arrival_date') 
								->first(); 
			  
			  if($date_exist){
				  
				  
			  }
			  
			  echo "<pre>";
			  print_r($date_exist);
			  }

		 
		  
		  if($db_from_date == $db_arrival_date){
							if($from_date == $to_date){
									$leave_time = strtotime($check_exist->leave_time); 
									$return_time = strtotime($check_exist->return_time); 
									$leave_time_form = strtotime($leave_time_form);  
									if(( $leave_time <=  $leave_time_form ) && ($leave_time_form <=  $return_time ) ){
										$permission  = 2;
									}else{
										$permission  = 1;
									}
								}else{
									$permission  = 2;
								}
						}
		  
		  //print_r($dates);
			 exit;  
		 	   */
			//$date_sequence date("Y-m-d",strtotime($from_date));
		  
		 
		 
			$data = array();
			$data['branch_list'] = DB::table('tbl_branch')   
									->orderby('branch_name','asc')
									->select('br_code','branch_name')
									->get();
			$data['action'] = 'emp_visit_reprt/';  
			$data['br_code'] = 'all';  
			$data['all_branch']   = DB::table('tbl_branch')   
									 ->orderby('branch_name','asc') 
									 ->where('status',1) 
									 ->get();  
			$data['from_date'] =date('Y-m-d');
			$data['to_date'] =date('Y-m-d'); 
			 
			return view('admin.reports.emp_visit_report',$data);
	}  
	public function emp_visit_reprt(Request $request)
    {
        $data = array(); 
		$data['branch_list'] = DB::table('tbl_branch')   
									->orderby('branch_name','asc')
									->select('br_code','branch_name')
									->get();
		$data['action'] 				= 'emp_visit_reprt/';  
		$data['from_date'] 				= $from_date =$request->from_date; 
		$data['to_date'] 				= $to_date =$request->to_date; 
		$data['br_code'] 				= $br_code =$request->br_code; 
		 $data['all_branch']   = DB::table('tbl_branch')
									->orderby('branch_name','asc') 		 
									 ->where('status',1) 
									 ->get();   
				$select_all_employee  = DB::table('tbl_movement_register as mr')
												 ->where(function($q) use ($from_date) {
													 $q->where('mr.from_date','>=', $from_date)
													   ->orWhere('mr.arrival_date','>=', $from_date);
												 })
												 ->where(function($q) use ($to_date) {
													 $q->where('mr.from_date','<=', $to_date)
													   ->orWhere('mr.arrival_date','<=', $to_date);
												 })
												 ->where('mr.super_action',1)
												 ->groupBy('mr.emp_id')
												 ->orderby('mr.emp_id','asc')
												 ->select('mr.emp_id',DB::raw('count(mr.move_id) as total_row'),DB::raw('SUM(mr.tot_day) as tot_tot_day')) 
												 ->get();  
			 
			 
			 foreach($select_all_employee as $employee){
				 
				 
				 
				 
				 $select_employee_leave  = DB::table('tbl_movement_register as mr')
												 ->where('mr.emp_id',$employee->emp_id)
												 ->where(function($q) use ($from_date) {
													 $q->where('mr.from_date','>=', $from_date)
													   ->orWhere('mr.arrival_date','>=', $from_date);
												 })
												 ->where(function($q) use ($to_date) {
													 $q->where('mr.from_date','<=', $to_date)
													   ->orWhere('mr.arrival_date','<=', $to_date);
												 })
												 ->where('mr.super_action',1) 
												 ->select('mr.*') 
												 ->get();  
						$emp_id1 = $employee->emp_id;
							$max_sarok = DB::table('tbl_master_tra as m')
										->where('m.emp_id', '=', $emp_id1)
										->where('m.br_join_date', '=', function($query) use ($emp_id1,$to_date)
												{
													$query->select(DB::raw('max(br_join_date)'))
														  ->from('tbl_master_tra')
														  ->where('emp_id',$emp_id1)
														  ->where('br_join_date', '<=', $to_date);
												})
										->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
										->groupBy('emp_id')
										->first();				
							$employee_info  = DB::table('tbl_master_tra as m')  
												->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
												->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
												->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')  
												->where('m.sarok_no', '=', $max_sarok->sarok_no)
												->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','emp.org_join_date as joining_date')
												->first();  
					 
					
					  /* echo '<pre>'; 
						print_r($employee_info);
						exit;  */
					foreach($select_employee_leave as $v_employee_leave){ 
							if($br_code == 'all'){
								$data['all_report'][] = array(
									'emp_id' 				=> $employee->emp_id,
									'tot_tot_day' 				=> $employee->tot_tot_day,
									'designation_name' 		=> $employee_info->designation_name,
									'branch_name' 			=> $employee_info->branch_name,
									'visit_type' 			=> $v_employee_leave->visit_type,
									'purpose' 					=> $v_employee_leave->purpose,
									'destination_code' 			=> $v_employee_leave->destination_code,
									'emp_name' 				=> $employee_info->emp_name,
									'from_date' 			=> $v_employee_leave->from_date,
									'leave_time' 			=> $v_employee_leave->leave_time,
									'total_row' 			=> $employee->total_row,
									'tot_day' 				=> $v_employee_leave->tot_day,
									'to_date' 				=> $v_employee_leave->to_date,
									'arrival_time' 			=> $v_employee_leave->arrival_time,
									'arrival_date' 			=> $v_employee_leave->arrival_date,
									'return_time' 			=> $v_employee_leave->return_time
								); 
							}else{
								if($br_code == $employee_info->br_code){
									$data['all_report'][] = array(
										'emp_id' 				=> $employee->emp_id,
										'tot_tot_day' 			=> $employee->tot_tot_day,
										'designation_name' 		=> $employee_info->designation_name,
										'branch_name' 			=> $employee_info->branch_name,
										'emp_name' 				=> $employee_info->emp_name,
										'visit_type' 			=> $v_employee_leave->visit_type,
										'destination_code' 		=> $v_employee_leave->destination_code,
										'purpose' 				=> $v_employee_leave->purpose,
										'from_date' 			=> $v_employee_leave->from_date,
										'leave_time' 			=> $v_employee_leave->leave_time,
										'to_date' 				=> $v_employee_leave->to_date,
										'arrival_time' 			=> $v_employee_leave->arrival_time,
										'total_row' 			=> $employee->total_row,
										'tot_day' 				=> $v_employee_leave->tot_day,
										'return_time' 			=> $v_employee_leave->return_time,
										'arrival_date' 			=> $v_employee_leave->arrival_date,
									);
								}
								 
							} 
					}
				  
			  } 
	   
		return view('admin.reports.emp_visit_report',$data);
    }  
}
