<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Middleware\Checkuser;
use DB;
use Session;
class LeaveReportController extends Controller
{

	 public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	
    public function index()
    {
        $data = array();
		$data['action'] = 'leave_reprt/'; 
		$data['emp_id'] ='';
		$data['from_date'] =date('Y-m-d');
		//$data['from_date'] =date('2020-06-30');
		$data['report_type'] = 1; 
		$data['resign_date'] 			='' ; 
		$data['join_date'] 			 	='' ; 
		$data['all_emp_type'] = DB::table('tbl_emp_type')->where('status',1)->get();
		return view('admin.reports.leave_report_form',$data);
    }
	public function leave_reprt(Request $request)
    {
        $data = array(); 
		$data['action'] 				= 'leave_reprt/'; 
		$asigndata = array(1,2,5);  
		$data['report_type'] 			=$request->report_type;
		
		$data['resign_date'] 			='' ; 
		$data['join_date'] 			 	='' ; 
		
		if($data['report_type'] == 2){
			$data['resign_date'] 			= $request->resign_date; 
			$data['join_date'] 				= $request->join_date; 
		}
		$data['emp_id'] 				= $emp_id =$request->emp_id;
		$data['from_date'] 				= $from_date =$request->from_date; 
		
		$current_date 					= date('Y-m-d'); 
		 
		
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
							
					if(!empty($max_sarok)){
						$data['employee_his']  = DB::table('tbl_master_tra as m')  
										->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
										->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
										->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
										->leftJoin('tbl_zone as z', 'z.zone_code', '=', 'b.zone_code') 
										->where('m.sarok_no', '=', $max_sarok->sarok_no)
										->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','z.zone_name','emp.org_join_date as joining_date')
										->first(); 
						
								$assign_designation = DB::table('tbl_emp_assign as ea')
																->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
																->where('ea.emp_id', $emp_id)
																->where('ea.status', '!=', 0)
																->where('ea.select_type', '=', 5)
																->select('ea.emp_id','ea.open_date','de.designation_name','de.designation_code')
																->first();
									if(!empty($assign_designation)) {
										$designation_name = $assign_designation->designation_name;
									}else{
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
																->select('ea.emp_id','ea.open_date','ea.br_code','br.branch_name','ar.area_name','z.zone_name')
																->first();
									if(!empty($assign_branch)) {  
										$branch_name = $assign_branch->branch_name;
										$zone_name = $assign_branch->zone_name;
										 
									}else{
										$branch_name = $data['employee_his']->branch_name;
										$zone_name 	 = $data['employee_his']->zone_name;
									}  
								$data['emp_id'] 			= $data['employee_his']->emp_id;
								$data['branch_name'] 		= $branch_name;
								$data['designation_name'] 	= $designation_name;
								$data['emp_name'] 			= $data['employee_his']->emp_name;
								$data['zone_name'] 			= $zone_name;
						
						}else{
							$data['emp_id'] 			= ''; 
							}    
		$select_fiscal_year 	= DB::table('tbl_financial_year') 
									->where('f_year_from','<=',$data['from_date']) 
									->where('f_year_to','>=',$data['from_date']) 
									->select('id')
									->first(); 
		/* $month = date('m',strtotime($data['from_date']));
		$year = date('Y',strtotime($data['from_date']));
		 
		if ($month<= 6) { 
			$f_year_start  = ($year-1) ; 
		}else{ 
			$f_year_start  = $year;   
		}   */
	 
		if(!empty($data['employee_his'])){ 
		
			$data['fiscal_year'] = DB::table('tbl_leave_balance as lib')   
										  ->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'lib.f_year_id') 
										 ->where('lib.emp_id',$emp_id)    
										 ->where('lib.f_year_id',$select_fiscal_year->id)  
										 ->select('lib.*','fy.f_year_from','fy.f_year_to')
										 ->first(); 
			if(!empty($data['fiscal_year'])){
				
 
			$data['fiscal_year1'] = DB::table('tbl_leave_history as lib')   
										 ->where('lib.emp_id',$emp_id)    
										 ->where('lib.f_year_id',$select_fiscal_year->id)  
										 ->select(DB::raw('max(tot_earn_leave) as tot_earn_leave'))
										 ->first(); 
			/*  echo '<pre>'; 
		print_r($data['fiscal_year']);
		exit; 		 */					 
										 
		    $get_date  = DB::table('tbl_leave_history as linf')   
										 ->where('linf.emp_id',$emp_id)    
										 ->where('linf.f_year_id',$select_fiscal_year->id)  
										 ->select(DB::raw('max(application_date) as sys_date_time'))
										 ->first(); 
			
			 $month = date('m',strtotime($data['from_date']));
				$year = date('Y',strtotime($data['from_date']));
				 
				 
				if ($month<= 6) { 
					$f_year_start  = ($year-1) ; 
				}else{ 
					$f_year_start  = $year;   
				}   
			 
			date_default_timezone_set('Asia/Dhaka');
			$joining_date = $data['employee_his']->joining_date;
				
						 
			/* $data['from_date'] 	=  '2019-04-01';
			$joining_date 		= '2019-02-19';  */
			$j_additional_day = 0;
			$r_additional_day = 0;
			if($data['report_type'] == 2){
				 if($joining_date > $f_year_start.'-'.'07'.'-'.'01'){ 
					$system_time = date("Y-m-d",strtotime($joining_date));
					 $join_day   =  date('d',strtotime($system_time));
					  if($join_day <= 10){
							$j_additional_day = 1.5;
						}else if($join_day <= 20){
							$j_additional_day = 1;
						}else{
							$j_additional_day = .5;
						} 
						$r_day   =  date('d',strtotime('-1 day', strtotime($data['from_date'])));
						$r_month   =  date('m',strtotime('-1 day', strtotime($data['from_date'])));
						$r_year   =  date('Y',strtotime('-1 day', strtotime($data['from_date'])));
						$total_day = cal_days_in_month(CAL_GREGORIAN,$r_month,$r_year);
						
							if($r_day <= 9){
									$r_additional_day = 0;
								}else if($r_day <= 19){
									 $r_additional_day = .5;
								}else if($r_day < $total_day){
									$r_additional_day = 1;
								}else{
									$r_additional_day = 1.5;
								} 
								//echo $r_month;
							$start_day = strtotime($joining_date);
							$end_date = strtotime('-1 day', strtotime($data['from_date']));

							$year1 = date('Y', $start_day);
							$year2 = date('Y', $end_date);

							$month1 = date('m', $start_day);
							$month2 = date('m', $end_date);

							$tot_month = (($year2 - $year1) * 12) + ($month2 - $month1);
							// echo $tot_month;
							$earn_leave = 0;
							if($tot_month == 0){
								/* $earn_leave =  ($r_day - $join_day)* (1.5 / 30) ;
								if($earn_leave <= 0.5){
									$earn_leave = 0.5;
								}else if($earn_leave <= 1){
									$earn_leave = 1;
								}else if($earn_leave <= 1.5){
									$earn_leave = 1.5;
								} */
								$day_deff =  ($r_day - $join_day);
								if($day_deff == $total_day){
									$earn_leave = 1.5;
								}else if($day_deff >= 20){
									$earn_leave = 1;
								}else if($day_deff >= 10){
									$earn_leave = .5;
								}
								
								//$earn_leave =  $j_additional_day ;
							}else if($tot_month == 1){
								$earn_leave =  $r_additional_day + $j_additional_day ;
							}else {
								$earn_leave =  $r_additional_day + $j_additional_day + ( $tot_month - 1 )* 1.5;
							}
							
							// echo $earn_leave;
				 }else{
						 $joining_date = $f_year_start.'-'.'07'.'-'.'01';  
						 $join_day   =  date('d',strtotime($joining_date));
						  if($join_day <= 10){
								$j_additional_day = 1.5;
							}else if($join_day <= 20){
								$j_additional_day = 1;
							}else{
								$j_additional_day = .5;
							} 
						$r_day   =  date('d',strtotime('-1 day', strtotime($data['from_date'])));
						$r_month   =  date('m',strtotime('-1 day', strtotime($data['from_date'])));
						$r_year   =  date('Y',strtotime('-1 day', strtotime($data['from_date'])));
						$total_day = cal_days_in_month(CAL_GREGORIAN,$r_month,$r_year);
						
							if($r_day <= 9){
									$r_additional_day = 0;
									
								}else if($r_day <= 19){
									 $r_additional_day = .5;
								}else if($r_day < $total_day){
									$r_additional_day = 1;
								}else{
									$r_additional_day = 1.5;
								} 
							$start_day = strtotime($joining_date);
							$end_date = strtotime('-1 day', strtotime($data['from_date']));

							$year1 = date('Y', $start_day);
							$year2 = date('Y', $end_date);

							$month1 = date('m', $start_day);
							$month2 = date('m', $end_date);

							$tot_month = (($year2 - $year1) * 12) + ($month2 - $month1);
							//echo $tot_month;
							$earn_leave = 0;
							if($tot_month == 0){
								/* $earn_leave =  ($r_day - $join_day)* (1.5 / 30) ;
								if($earn_leave <= 0.5){
									$earn_leave = 0.5;
								}else if($earn_leave <= 1){
									$earn_leave = 1;
								}else if($earn_leave <= 1.5){
									$earn_leave = 1.5;
								}*/
								$day_deff =  ($r_day - $join_day);
								if($day_deff == $total_day){
									$earn_leave = 1.5;
								}else if($day_deff >= 20){
									$earn_leave = 1;
								}else if($day_deff >= 10){
									$earn_leave = .5;
								}
								//$earn_leave =  $j_additional_day ;
							}else if($tot_month == 1){
								$earn_leave =  $r_additional_day + $j_additional_day ;
							}else {
								$earn_leave =  $r_additional_day + $j_additional_day + ( $tot_month - 1 )* 1.5;
							}
				 }
				 if($data['from_date'] > '2020-06-30'){
					  if($joining_date < '2020-08-04'){
								$earn_leave += 3;
							}
				 }
				
							
					$data['extra_earn'] = $earn_leave;
					 
			}else{ 
			
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
							$j_additional_day = .5;
						} 
					
					 
				}else{
					 $system_time = $f_year_start.'-'.'07'.'-'.'01'; 
					  
				} 
			
			 
				 
				$within_date = date('Y-m-03',strtotime($data['from_date']));	
				 
				 
				$system_time = date('Y-m-01',strtotime($system_time)); 
				$date1=date_create($system_time);
				$date2=date_create($within_date);
				$diff=date_diff($date1,$date2);
 
			    $total_month= ($diff->format("%R%a"))/30;

				$total_month = intval($total_month); 
				 
				if(strtotime($within_date) < strtotime($system_time)){
					$data['extra_earn'] = ((-$total_month) * 1.5)+ $j_additional_day;
				}else{
					$data['extra_earn'] = ($total_month * 1.5) + $j_additional_day;
				}   
				
				} 
				$fiscal_end_year = $f_year_start + 1;
				$fiscal_end_date =  $fiscal_end_year.'-'.'06'.'-'.'30'; 
				$data['getleaveinfowithpay']   = DB::table('tbl_leave_history as linf')
												 ->where('linf.f_year_id',$select_fiscal_year->id)  
												 ->where('linf.application_date','<=',$fiscal_end_date)   
												 ->where('linf.emp_id',$emp_id)  
												->where(function($q){
													 $q->where('linf.is_pay',1)  
															->orwhere('linf.is_pay',3);
												 })
												
												 ->where('linf.type_id',1)   
												 ->where('linf.leave_adjust',1)  
												 ->where('linf.is_view',1)  
												 ->orderby('linf.appr_from_date','asc')
												 ->select('linf.*') 
												 ->get();
				$data['getcasualleaveinfowithpay']   = DB::table('tbl_leave_history as linf')
														 ->where('linf.f_year_id',$select_fiscal_year->id)  
														 ->where('linf.application_date','<=',$fiscal_end_date)   
														 ->where('linf.emp_id',$emp_id)  
														->where(function($q){
															 $q->where('linf.is_pay',1)  
																	->orwhere('linf.is_pay',3);
														 })
														
														 ->where('linf.type_id',5)  
														 ->where('linf.leave_adjust',1)  
														 ->where('linf.is_view',1)  
														 ->orderby('linf.appr_from_date','asc')
														 ->select('linf.*') 
														 ->get();  
				$data['getleaveprevious']   = DB::table('tbl_leave_history as linf')
												 ->where('linf.f_year_id',$select_fiscal_year->id)  
												 ->where('linf.application_date','<=',$fiscal_end_date)   
												 ->where('linf.emp_id',$emp_id)   
												 ->where('linf.is_pay',1)  
												 ->where('linf.type_id','!=',3) 
												 ->where('linf.leave_adjust',2)  
												 ->where('linf.is_view',1)  
												 ->orderby('linf.appr_from_date','asc')
												 ->select('linf.*') 
												 ->get(); 	
			$data['getleavemeternity']   = DB::table('tbl_leave_history as linf')
												 ->where('linf.f_year_id',$select_fiscal_year->id)  
												 ->where('linf.application_date','<=',$fiscal_end_date)   
												 ->where('linf.emp_id',$emp_id)    
												 ->where('linf.is_pay',1)  
												 ->where('linf.type_id',2) 
												 ->where('linf.leave_adjust',1)  
												 ->where('linf.is_view',1)  
												 ->orderby('linf.appr_from_date','asc')
												 ->select('linf.*') 
												 ->get();  					 
			$data['getleavespecial']   = DB::table('tbl_leave_history as linf')
												 ->where('linf.f_year_id',$select_fiscal_year->id)  
												 ->where('linf.application_date','<=',$fiscal_end_date)   
												 ->where('linf.emp_id',$emp_id)     
												 ->where('linf.type_id',3)    
												 ->where('linf.is_view',1)  
												 ->orderby('linf.appr_from_date','asc')
												 ->select('linf.*') 
												 ->get(); 
			$data['fiscal_year_9_12']   = DB::table('tbl_leave_history as linf')
												 ->where('linf.f_year_id',$select_fiscal_year->id)  
												 ->where('linf.application_date','<=',$fiscal_end_date)   
												 ->where('linf.emp_id',$emp_id)    
												 ->where('linf.leave_adjust',3)    
												 ->where('linf.is_view',1)  
												 ->orderby('linf.appr_from_date','asc')
												 ->select('linf.*') 
												 ->get(); 
			$data['getleaveinfowithoutpay']   = DB::table('tbl_leave_history as linf')
													 ->where('linf.f_year_id',$select_fiscal_year->id)  
													 ->where('linf.application_date','<=',$fiscal_end_date)   
													 ->where('linf.emp_id',$emp_id)     
													 ->where('linf.type_id','!=',3)    
													 ->where('linf.is_pay',2)    
													 ->where('linf.is_view',1)  
													 ->orderby('linf.appr_from_date','asc')
													 ->select('linf.*') 
													 ->get(); 
			$data['finalwithoutpay']   = DB::table('tbl_leave_history as linf')   
													 ->where('linf.emp_id',$emp_id)     
													 ->where('linf.type_id','!=',3)    
													 ->where('linf.is_pay',2)    
													 ->where('linf.is_view',1)  
													 ->orderby('linf.appr_from_date','asc')
													 ->select('linf.*') 
													 ->get();  
			$data['getleavequarantine']   = DB::table('tbl_leave_history as linf')
													 ->where('linf.f_year_id',$select_fiscal_year->id)  
													 ->where('linf.application_date','<=',$fiscal_end_date)   
													 ->where('linf.emp_id',$emp_id)     
													 ->where('linf.type_id',4)    
													 ->where('linf.is_view',1)  
													 ->orderby('linf.appr_from_date','asc')
													 ->select('linf.*') 
													 ->get(); 	
			 
		 }	
		}
		 
	 /*  echo '<pre>'; 
		print_r($data['fiscal_year']);
		exit;   */
		return view('admin.reports.leave_report_form',$data);
    }
	public function emp_leave_report()
	{
			$data = array();
			$data['action'] = 'emp_leave_reprt/';  
			$data['br_code'] = 'all';  
			$data['all_branch']   = DB::table('tbl_branch')   
									 ->orderby('branch_name','asc') 
									 ->where('status',1) 
									 ->get();  
			$data['from_date'] =date('Y-m-d');
			$data['to_date'] =date('Y-m-d'); 
			 
			return view('admin.reports.emp_leave_report',$data);
	}  
	public function emp_leave_reprt(Request $request)
    {
        $data = array(); 
		$data['action'] 				= 'emp_leave_reprt/';  
		$data['from_date'] 				= $from_date =$request->from_date; 
		$data['to_date'] 				= $to_date =$request->to_date; 
		$data['br_code'] 				= $br_code =$request->br_code; 
		 $data['all_branch']   = DB::table('tbl_branch')
									->orderby('branch_name','asc') 		 
									 ->where('status',1) 
									 ->get();  
		 
		$month = date('m',strtotime($data['from_date']));
		$year = date('Y',strtotime($data['from_date']));
		 
		if ($month<= 6) { 
			$f_year_start  = ($year-1) ; 
		}else{ 
			$f_year_start  = $year;   
		}  
				$select_all_employee  = DB::table('tbl_leave_history as linf')
												 ->where(function($q) use ($from_date) {
													 $q->where('linf.appr_from_date','>=', $from_date)
													   ->orWhere('linf.appr_to_date','>=', $from_date);
												 })
												 ->where(function($q) use ($to_date) {
													 $q->where('linf.appr_from_date','<=', $to_date)
													   ->orWhere('linf.appr_to_date','<=', $to_date);
												 })
												 ->where('linf.is_view',1)
												 ->groupBy('linf.emp_id')
												 ->orderby('linf.emp_id','asc')
												 ->select('linf.emp_id',DB::raw('count(linf.id) as total_row'),DB::raw('SUM(linf.no_of_days_appr) as tot_no_of_days_appr')) 
												 ->get();  
			 
			 
			 foreach($select_all_employee as $employee){
				 
				 
				 
				 
				 $select_employee_leave  = DB::table('tbl_leave_history as linf')
												 ->where('linf.emp_id',$employee->emp_id)
												 ->where(function($q) use ($from_date) {
													 $q->where('linf.appr_from_date','>=', $from_date)
													   ->orWhere('linf.appr_to_date','>=', $from_date);
												 })
												 ->where(function($q) use ($to_date) {
													 $q->where('linf.appr_from_date','<=', $to_date)
													   ->orWhere('linf.appr_to_date','<=', $to_date);
												 })
												 ->where('linf.is_view',1) 
												 ->select('linf.*') 
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
									'tot_no_of_days_appr' 	=> $employee->tot_no_of_days_appr,
									'designation_name' 		=> $employee_info->designation_name,
									'branch_name' 			=> $employee_info->branch_name,
									'emp_name' 				=> $employee_info->emp_name,
									'appr_from_date' 		=> $v_employee_leave->appr_from_date,
									'total_row' 			=> $employee->total_row,
									'no_of_days_appr' 		=> $v_employee_leave->no_of_days_appr,
									'appr_to_date' 			=> $v_employee_leave->appr_to_date
								); 
							}else{
								if($br_code == $employee_info->br_code){
									$data['all_report'][] = array(
										'emp_id' 				=> $employee->emp_id,
										'tot_no_of_days_appr' 	=> $employee->tot_no_of_days_appr,
										'designation_name' 		=> $employee_info->designation_name,
										'branch_name' 			=> $employee_info->branch_name,
										'emp_name' 				=> $employee_info->emp_name,
										'appr_from_date' 		=> $v_employee_leave->appr_from_date,
										'total_row' 			=> $employee->total_row,
										'no_of_days_appr' 		=> $v_employee_leave->no_of_days_appr,
										'appr_to_date' 			=> $v_employee_leave->appr_to_date
									);
								}
								 
							} 
					}
				  
			  } 
	   
		return view('admin.reports.emp_leave_report',$data);
    }
    public function ho_leave_rpt()
	{
			$data = array();
			$current_date = date("Y-m-d");
			 $to_date = date("Y-m-d");
				  $select_all_employee = DB::table('tbl_master_tra as m')
											->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
											->where('m.br_code', '=', 9999)
											->where('m.br_join_date', '<=', $to_date)
											->Where(function($query) use ($to_date) {
														$query->whereNull('r.emp_id');
														$query->orWhere('r.effect_date', '>', $to_date);								
													})
											->select('m.emp_id')
											->groupBy('m.emp_id')
											->get(); 
			 foreach($select_all_employee as $employee){ 
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
											->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
											->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
											->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')  
											->where('m.sarok_no', '=', $max_sarok->sarok_no)
											->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','emp.org_join_date as joining_date','r.effect_date')
											->first();  
						 
						 
						$employee_leave_blance  = DB::table('tbl_leave_balance as linf')  
												 ->where('linf.f_year_id',4)
												 ->where('linf.emp_id',$employee->emp_id)  
												 ->select('linf.no_of_days','linf.current_open_balance','linf.cum_balance_less_12','linf.cum_balance_less_close_12') 
												 ->first(); 
						$employee_leave_his  = DB::table('tbl_leave_history as linf')  
												 ->where('linf.f_year_id',4)
												 ->where('linf.emp_id',$employee->emp_id) 
												 ->where('linf.leave_adjust',3)  
												 ->where('linf.appr_to_date','<=',$current_date)  
												 ->select(DB::raw('Sum(linf.no_of_days_appr) as no_of_days_appr')) 
												 //->groupBy('linf.emp_id','linf.f_year_id')
												 ->first();    
						/* print_r($employee_leave_blance);
						echo '<pre>';
						print_r($employee_leave_his);  */
						
						
						if(!empty($employee_info)){ 
							if($employee_info->br_code == 9999 ){ 
								if(!empty($employee_info->effect_date)){
									if($employee_info->effect_date >= $to_date){
										$data['all_report'][] = array(
											'emp_id' 					=> $employee->emp_id,
											'designation_name' 			=> $employee_info->designation_name,
											'branch_name' 				=> $employee_info->branch_name,
											'emp_name' 					=> $employee_info->emp_name,
											'current_open_balance' 		=> $employee_leave_blance->current_open_balance,
											'cum_balance_less_12' 		=> $employee_leave_blance->cum_balance_less_12,
											'cum_balance_less_close_12' => $employee_leave_blance->cum_balance_less_close_12,
											'no_of_days' 				=> $employee_leave_blance->no_of_days,
											'no_of_days_appr' 			=> $employee_leave_his->no_of_days_appr 
										); 
										 
									}
										
									}else{ 
											$data['all_report'][] = array(
												'emp_id' 					=> $employee->emp_id,
												'designation_name' 			=> $employee_info->designation_name,
												'branch_name' 				=> $employee_info->branch_name,
												'emp_name' 					=> $employee_info->emp_name,
												'current_open_balance' 		=> $employee_leave_blance->current_open_balance,
												'cum_balance_less_12' 		=> $employee_leave_blance->cum_balance_less_12,
											    'cum_balance_less_close_12' => $employee_leave_blance->cum_balance_less_close_12,
												'no_of_days' 				=> $employee_leave_blance->no_of_days,
												'no_of_days_appr' 			=> $employee_leave_his->no_of_days_appr 
											); 
										}
									}    
						}
						
						 
			 } 
			 $data['fiscal_year'] 	= DB::table('tbl_financial_year') 
										->where('f_year_from','<=',$to_date) 
										->where('f_year_to','>=',$to_date) 
										->select('id','f_year_from','f_year_to')
										->first(); 
			 
			/*   echo '<pre>';
		print_r($data['all_report']);
		exit; */
		return view('admin.reports.leave_report_ho',$data); 
	} 
	public function change_report_type($report_type,$emp_id)
    {
         $data = array(); 
        $emp_info = ''; 
		$join_date = date("Y-m-d"); 
		$resign_date = date("Y-m-d");
		if($report_type == 2){
			 
			 	$emp_info = DB::table('tbl_emp_basic_info as emp')   
								->leftJoin('tbl_resignation as r', 'r.emp_id', '=', 'emp.emp_id') 
								 ->where('emp.emp_id',$emp_id)  
								 ->select('r.effect_date as resign_date','emp.org_join_date as joining_date')
								 ->first(); 
			 
		}
		if(!empty($emp_info)){
			$join_date = $emp_info->joining_date;
			if(!empty($emp_info->resign_date)){
				$resign_date = $emp_info->resign_date;
			}
			
		}
		
		echo json_encode(array('join_date' => $join_date,'resign_date' => $resign_date));	
	}
	 public function leave_check()
    {
        $data = array();
		$data['action'] = 'leave_reprt1/'; 
		$data['emp_id'] ='';
		$data['from_date'] =date('Y-m-d');
		$data['report_type'] = 1;
		$data['resign_date'] 			='' ; 
		$data['join_date'] 			 	='' ; 
		$data['all_emp_type'] = DB::table('tbl_emp_type')->where('status',1)->get();
		return view('admin.reports.leave_report_form',$data);
    }
	
	/* public function leave_reprt1(Request $request)
    {
        $data = array(); 
		$data['action'] 				= 'leave_reprt1/'; 
		$asigndata = array(1,2,5); 
		$data['report_type'] 			=$request->report_type;
		
		$data['resign_date'] 			='' ; 
		$data['join_date'] 			 	='' ; 
		
		if($data['report_type'] == 2){
			$data['resign_date'] 			= $request->resign_date; 
			$data['join_date'] 				= $request->join_date; 
		}
		$data['emp_id'] 				= $emp_id =$request->emp_id;
		$data['from_date'] 				= $from_date =$request->from_date; 
		  
		$current_date 					= date('Y-m-d'); 
		if($emp_type == 1){
			
			$data['employee_his']  = DB::table('tbl_emp_assign as es')  
										->leftJoin('tbl_emp_basic_info as emp', 'es.emp_id', '=', 'emp.emp_id')
										->leftJoin('tbl_designation as d', 'es.designation_code', '=', 'd.designation_code') 
										->leftJoin('tbl_branch as b', 'es.br_code', '=', 'b.br_code') 
										->leftJoin('tbl_zone as z', 'z.zone_code', '=', 'b.zone_code') 
										->where('es.emp_id',$emp_id)
										->where('es.open_date', '<=', $from_date)
										->where('es.status', '!=', 0)
										->whereIn('es.select_type', $asigndata)
										->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','z.zone_name','emp.org_join_date as joining_date')
										->first(); 
			if(empty($data['employee_his'])){ 
				$max_sarok = DB::table('tbl_master_tra')
							->where('emp_id', '=', $emp_id)
							->where('effect_date', '<=', $current_date)
							->select('emp_id',DB::raw('max(sarok_no) as sarok_no'))
							->groupBy('emp_id')
							->first();
					if(!empty($max_sarok)){
						$data['employee_his']  = DB::table('tbl_master_tra as m')  
										->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
										->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
										->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
										->leftJoin('tbl_zone as z', 'z.zone_code', '=', 'b.zone_code') 
										->where('m.sarok_no', '=', $max_sarok->sarok_no)
										->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','z.zone_name','emp.org_join_date as joining_date')
										->first(); 
						}
			
					}
			    
			
		}else{
			$data['employee_his']  = DB::table('tbl_emp_non_id as nid')  
										 ->leftjoin('tbl_nonid_official_info',function($join){
											$join->on("nid.emp_id","=","tbl_nonid_official_info.emp_id")
												->where('tbl_nonid_official_info.joining_date',DB::raw("(SELECT 
																			  max(tbl_nonid_official_info.joining_date)
																			  FROM tbl_nonid_official_info 
																			   where nid.emp_id = tbl_nonid_official_info.emp_id
																			  )") 		 
														); 
													})	
										 ->leftJoin('tbl_designation as d', 'tbl_nonid_official_info.designation_code', '=', 'd.designation_code') 
										 ->leftJoin('tbl_branch as b', 'tbl_nonid_official_info.br_code', '=', 'b.br_code')
										 ->leftJoin('tbl_zone as z', 'z.zone_code', '=', 'b.zone_code') 
										 ->where('nid.sacmo_id',$emp_id)  
										 ->where('nid.emp_type_code',$emp_type)  
										 ->select('nid.sacmo_id as emp_id','nid.emp_name','tbl_nonid_official_info.joining_date','b.br_code','d.designation_code','b.branch_name','z.zone_name','d.designation_name')
										 ->first(); 
		}
		$select_fiscal_year 	= DB::table('tbl_financial_year') 
									->where('f_year_from','<=',$data['from_date']) 
									->where('f_year_to','>=',$data['from_date']) 
									->select('id')
									->first(); 
		 
	 
		if(!empty($data['employee_his'])){ 
		
			$data['fiscal_year'] = DB::table('tbl_leave_balance as lib')   
										  ->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'lib.f_year_id') 
										 ->where('lib.emp_id',$emp_id)  
										 ->where('lib.emp_type',$emp_type)  
										 ->where('lib.f_year_id',$select_fiscal_year->id)  
										 ->select('lib.*','fy.f_year_from')
										 ->first(); 
			$data['fiscal_year1'] = DB::table('tbl_leave_history as lib')   
										 ->where('lib.emp_id',$emp_id)  
										 ->where('lib.emp_type',$emp_type)  
										 ->where('lib.f_year_id',$select_fiscal_year->id)  
										 ->select(DB::raw('max(tot_earn_leave) as tot_earn_leave'))
										 ->first(); 
			 			 
										 
		    $get_date  = DB::table('tbl_leave_history as linf')   
										 ->where('linf.emp_id',$emp_id)  
										 ->where('linf.emp_type',$emp_type)  
										 ->where('linf.f_year_id',$select_fiscal_year->id)  
										 ->select(DB::raw('max(application_date) as sys_date_time'))
										 ->first(); 
			
			 $month = date('m',strtotime($data['from_date']));
				$year = date('Y',strtotime($data['from_date']));
				 
				 
				if ($month<= 6) { 
					$f_year_start  = ($year-1) ; 
				}else{ 
					$f_year_start  = $year;   
				}   
			 
			date_default_timezone_set('Asia/Dhaka');
			$joining_date = $data['employee_his']->joining_date;
			$j_additional_day = 0;
			
			if(empty($get_date->sys_date_time)){  
			     
				 
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
			} else{
				$system_time = $get_date->sys_date_time;  
			} 
				if($data['report_type'] == 2){
				$within_date = date('Y-m-03',strtotime('-1 day', strtotime($data['from_date'])));
				}else{
				$within_date = date('Y-m-03',strtotime($data['from_date']));	
				}
				
				 
				$system_time = date('Y-m-01',strtotime($system_time)); 
				$date1=date_create($system_time);
				$date2=date_create($within_date);
				$diff=date_diff($date1,$date2);
 
			    $total_month= ($diff->format("%R%a"))/30;

				$total_month = intval($total_month); 
				//echo  $total_month;
				$additional_day = 0;
				if($data['report_type'] == 2){
					//$total_month = $total_month - 1;
					//echo $total_month; 				
						$f_day   =  date('d',strtotime('-1 day', strtotime($data['from_date'])));
						$f_month   =  date('m',strtotime('-1 day', strtotime($data['from_date'])));
						$f_year   =  date('Y',strtotime('-1 day', strtotime($data['from_date'])));
						$total_day = cal_days_in_month(CAL_GREGORIAN,$f_month,$f_year);
							if($f_day <= 9){
									$additional_day = 0;
								}else if($f_day <= 19){
									 $additional_day = 0.5;
								}else if($f_day < $total_day){
									$additional_day = 1;
								}else{
									$additional_day = 1.5;
								} 
				 		
				}
				
				//exit; 
				if(strtotime($within_date) < strtotime($system_time)){
					$data['extra_earn'] = ((-$total_month) * 1.5)+ $additional_day + $j_additional_day;
				}else{
					$data['extra_earn'] = ($total_month * 1.5) + $additional_day + $j_additional_day;
				}  
				$fiscal_end_year = $f_year_start + 1;
				$fiscal_end_date =  $fiscal_end_year.'-'.'06'.'-'.'30'; 
				$data['getleaveinfowithpay']   = DB::table('tbl_leave_history as linf')
												 ->where('linf.f_year_id',$select_fiscal_year->id)  
												 ->where('linf.application_date','<=',$fiscal_end_date)   
												 ->where('linf.emp_id',$emp_id)  
												 ->where('linf.emp_type',$emp_type)  
												 ->where('linf.is_pay',1)  
												 ->where('linf.type_id','!=',3)  
												 ->where('linf.type_id','!=',2)  
												 ->where('linf.leave_adjust',1)  
												 ->where('linf.is_view',1)  
												 ->orderby('linf.appr_from_date','asc')
												 ->select('linf.*') 
												 ->get();  
				$data['getleaveprevious']   = DB::table('tbl_leave_history as linf')
												 ->where('linf.f_year_id',$select_fiscal_year->id)  
												 ->where('linf.application_date','<=',$fiscal_end_date)   
												 ->where('linf.emp_id',$emp_id)  
												 ->where('linf.emp_type',$emp_type)  
												 ->where('linf.is_pay',1)  
												 ->where('linf.type_id','!=',3) 
												 ->where('linf.leave_adjust',2)  
												 ->where('linf.is_view',1)  
												 ->orderby('linf.appr_from_date','asc')
												 ->select('linf.*') 
												 ->get(); 	
			$data['getleavemeternity']   = DB::table('tbl_leave_history as linf')
												 ->where('linf.f_year_id',$select_fiscal_year->id)  
												 ->where('linf.application_date','<=',$fiscal_end_date)   
												 ->where('linf.emp_id',$emp_id)  
												 ->where('linf.emp_type',$emp_type)  
												 ->where('linf.is_pay',1)  
												 ->where('linf.type_id',2) 
												 ->where('linf.leave_adjust',1)  
												 ->where('linf.is_view',1)  
												 ->orderby('linf.appr_from_date','asc')
												 ->select('linf.*') 
												 ->get();  					 
			$data['getleavespecial']   = DB::table('tbl_leave_history as linf')
												 ->where('linf.f_year_id',$select_fiscal_year->id)  
												 ->where('linf.application_date','<=',$fiscal_end_date)   
												 ->where('linf.emp_id',$emp_id)  
												 ->where('linf.emp_type',$emp_type)   
												 ->where('linf.type_id',3)    
												 ->where('linf.is_view',1)  
												 ->orderby('linf.appr_from_date','asc')
												 ->select('linf.*') 
												 ->get(); 
			$data['fiscal_year_9_12']   = DB::table('tbl_leave_history as linf')
												 ->where('linf.f_year_id',$select_fiscal_year->id)  
												 ->where('linf.application_date','<=',$fiscal_end_date)   
												 ->where('linf.emp_id',$emp_id)  
												 ->where('linf.emp_type',$emp_type)   
												 ->where('linf.leave_adjust',3)    
												 ->where('linf.is_view',1)  
												 ->orderby('linf.appr_from_date','asc')
												 ->select('linf.*') 
												 ->get(); 
			$data['getleaveinfowithoutpay']   = DB::table('tbl_leave_history as linf')
													 ->where('linf.f_year_id',$select_fiscal_year->id)  
													 ->where('linf.application_date','<=',$fiscal_end_date)   
													 ->where('linf.emp_id',$emp_id)  
													 ->where('linf.emp_type',$emp_type)   
													 ->where('linf.type_id','!=',3)    
													 ->where('linf.is_pay',2)    
													 ->where('linf.is_view',1)  
													 ->orderby('linf.appr_from_date','asc')
													 ->select('linf.*') 
													 ->get();  
			$data['getleavequarantine']   = DB::table('tbl_leave_history as linf')
													 ->where('linf.f_year_id',$select_fiscal_year->id)  
													 ->where('linf.application_date','<=',$fiscal_end_date)   
													 ->where('linf.emp_id',$emp_id)  
													 ->where('linf.emp_type',$emp_type)   
													 ->where('linf.type_id',4)    
													 ->where('linf.is_view',1)  
													 ->orderby('linf.appr_from_date','asc')
													 ->select('linf.*') 
													 ->get(); 	
			 
			
		}
		$data['all_emp_type'] = DB::table('tbl_emp_type')->where('status',1)->get(); 
		 
		return view('admin.reports.leave_report_form',$data);
    } */ 
	
	public function previous_leave_reprt()
    {
        $data = array(); 
        $ddata = array(122,212,209,211,210,213,227,147,228,226,207,214,168); 
		$data['action'] 				= 'emp_leave_reprt/';  
		//$data['from_date'] 				= $from_date 	=	$request->from_date; 
		$data['to_date'] 				= $to_date 		=	date("Y-m-d"); 
		 
		 
		/* $month = date('m',strtotime($data['from_date']));
		$year = date('Y',strtotime($data['from_date']));
		 
		if ($month<= 6) { 
			$f_year_start  = ($year-1) ; 
		}else{ 
			$f_year_start  = $year; 			
		}   */
		/* $data['all_report'][] = array(
							'emp_id' 				=> 1, 
							'joining_date' 			=> "1995-05-28",
							'emp_type' 				=> 1,
							'pre_cumulative_close' 	=> 18,
							'tot_without_pay' 		=> '',
							'designation_name' 		=> "Executive Director",
							'branch_name' 			=> "Head Office",
							'emp_name' 				=> "Muhammad Yahiya"
						);  */
				$select_all_employee  = DB::table('tbl_leave_balance as linf')
												 /* ->where(function($q) use ($to_date) {
													 $q->where('linf.appr_from_date','<=', $to_date)
													   ->orWhere('linf.appr_to_date','<=', $to_date);
												 }) */
												 ->where('linf.f_year_id',3)
												// ->where('linf.is_view',1)
												 ->groupBy('linf.emp_id')
												 ->orderby('linf.emp_id','asc')
												 ->select('linf.emp_id') 
												 ->get();  
			 
			 
			 foreach($select_all_employee as $employee){
				 
					
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
												->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
												->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
												->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')  
												->where('m.sarok_no', '=', $max_sarok->sarok_no)
												->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','emp.org_join_date as joining_date','r.effect_date as cancel_date')
												->first();   
					 
					  /* echo '<pre>'; 
						print_r($employee_info);
						exit;  */
						
					 $employee_leave_blance  = DB::table('tbl_leave_balance as linf')  
												 ->where('linf.f_year_id',4)
												 ->where('linf.emp_id',$employee->emp_id)  
												 ->select('linf.no_of_days','linf.current_open_balance','linf.cum_close_balance','linf.pre_cumulative_close') 
												 ->first();
					$employee_leave_blance_his  = DB::table('tbl_leave_history as linf')
												 ->where('linf.is_view',1)
												 ->where('linf.f_year_id',3)
												 ->where('linf.emp_id',$employee->emp_id)  
												 ->where('linf.is_pay',2)
												 ->select('linf.emp_id',DB::raw('SUM(linf.no_of_days_appr) as tot_without_pay')) 
												 ->first();  								
					if(empty($employee_info->cancel_date)){
							if( $employee_info->br_code == 9999){
								$data['all_report'][] = array(
									'emp_id' 				=> $employee->emp_id,
									'joining_date' 			=> $employee_info->joining_date,
									'pre_cumulative_close' 	=> $employee_leave_blance->pre_cumulative_close,
									'tot_without_pay' 		=> $employee_leave_blance_his->tot_without_pay,
									'designation_name' 		=> $employee_info->designation_name,
									'branch_name' 			=> $employee_info->branch_name,
									'emp_name' 				=> $employee_info->emp_name
								); 
							}else  {
								if(in_array($employee_info->designation_code,$ddata)){
									$data['all_report'][] = array(
									'emp_id' 				=> $employee->emp_id,
									'joining_date' 			=> $employee_info->joining_date,
									'pre_cumulative_close' 	=> $employee_leave_blance->pre_cumulative_close,
									'tot_without_pay' 		=> $employee_leave_blance_his->tot_without_pay,
									'designation_name' 		=> $employee_info->designation_name,
									'branch_name' 			=> $employee_info->branch_name,
									'emp_name' 				=> $employee_info->emp_name
								); 
								}
							} 
							  	
					}
				
			  
			}
		return view('admin.reports.previous_leave_report',$data);
    }
	public function emp_leave_reprt_pre()
    {
        $data = array(); 
		$data['action'] 				= 'emp_leave_reprt_pre/';   
	 
		 $to_date =date("Y-m-d");
	 
				 $select_employee_leave  = DB::table('tbl_leave_balance as linf')
												 ->where('linf.f_year_id',4) 
												 ->select('linf.*') 
												 ->get();  
			/*   echo '<pre>'; 
						print_r($select_employee_leave);
						exit; */
			
			foreach($select_employee_leave as $employee){
				 
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
							if(!empty($max_sarok)){			
							$employee_info  = DB::table('tbl_master_tra as m')  
												->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
												->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
												->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')  
												->where('m.sarok_no', '=', $max_sarok->sarok_no)
												->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','emp.org_join_date as joining_date')
												->first();  
							}
					 
					
					 /*  echo '<pre>'; 
						print_r($employee_info);
						exit;   */ 
						if($employee_info){
							if($employee_info->br_code != 9999 ){
								$data['all_report'][] = array(
									'emp_id' 				=> $employee->emp_id,
									'pre_cumulative_open' 	=> $employee->pre_cumulative_open,
									'designation_name' 		=> $employee_info->designation_name,
									'branch_name' 			=> $employee_info->branch_name,
									'emp_name' 				=> $employee_info->emp_name
								);   
							}
							
						}
						
			  } 
	 /*   echo '<pre>'; 
						print_r($data['all_report']);
						exit; */
		return view('admin.reports.emp_leave_report_pre',$data);
    }
	public function leave_reprt_dm(Request $request)
    {
        $data = array(); 
		$data['action'] 	= 'leave_reprt_dm/'; 
		
		$user_type 			= Session::get('user_type');
		$area_code 			= Session::get('area_code');
		
		
		
		$zone_code 			= Session::get('zone_code');
		$data['user_type'] 	= $user_type;
		$data['all_report'] = '';
		if($user_type == 3){
			$data['all_area'] 	= DB::table('tbl_area')->where('zone_code',$zone_code)->where('status',1)->get();
		}else if($user_type == 1){
			$data['all_area'] 	= DB::table('tbl_area')->where('status',1)->get();
		}else{
			$data['all_area'] 	= DB::table('tbl_area')->where('area_code',$area_code)->where('status',1)->get();
		}
		
		$data['area_code']		= $area_code1	= $request->area_code;
		$data['all_branch'] 	= DB::table('tbl_branch')
									->where('area_code',$area_code1)
									->where('status',1)
									->get();
		$data['all_fy'] 		= DB::table('tbl_financial_year')->get();
		
				
		$data['branch_code']	= $branch_code		= $request->branch_code;		
		$data['f_year_id']	= $f_year_id		= $request->f_year_id;		
		 //$to_date =date("Y-m-d");
		$data['y']	= $y = $request->f_year_id + 2017;
		//echo  $branch_code ;
		 //$to_date =date("$y-06-30");
		 $to_date =date("Y-m-d");
		  $form_date = date("Y-m-d");
		if($area_code1 != 'all_a'){
			if(!empty($branch_code)){ 
			
			
						$all_result = DB::table('tbl_master_tra as m')
									->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
									->where('m.br_code', '=', $branch_code)
									->where('m.br_join_date', '<=', $form_date)
									->where(function($query) use ($form_date) { 
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date); 
										})
									
									->select('m.emp_id')
									->groupBy('m.emp_id')
									->get()->toArray();
						
						$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										->where('eas.br_code', '=', $branch_code)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($form_date) { 
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date); 
										})									
										->select('eas.emp_id')
										->get()->toArray();
						$select_employee = array_unique(array_merge($all_result,$assign_branch), SORT_REGULAR);
						
						foreach($select_employee as $employee){ 
						
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
								if(!empty($max_sarok)){			
									$employee_info  = DB::table('tbl_master_tra as m')  
													->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
													->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
													->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')  
													->where('m.sarok_no', '=', $max_sarok->sarok_no)
													->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','b.br_code','emp.org_join_date as joining_date')
													->first();  
									if($branch_code == $employee_info->br_code){
										$select_employee_info  = DB::table('tbl_leave_history as linf')
																 ->where('linf.is_view',1)  
																 ->where('linf.f_year_id',$f_year_id) 
																 ->where('linf.emp_id',$emp_id1)
																 ->select('linf.f_year_id','linf.emp_id','linf.appr_from_date','linf.appr_to_date','linf.no_of_days_appr','linf.serial_no','linf.leave_adjust','linf.remarks') 
																 ->get();
										foreach($select_employee_info  as $v_select_employee_info ){
											$data['all_report'][] = array(
												'emp_id_u' 				=> $employee_info->emp_id,
												'branch_code' 			=> $employee_info->br_code,
												'emp_id' 				=> $employee->emp_id,  
												'appr_from_date' 		=> $v_select_employee_info->appr_from_date,
												'appr_to_date' 			=> $v_select_employee_info->appr_to_date,
												'no_of_days_appr' 		=> $v_select_employee_info->no_of_days_appr,
												'serial_no' 			=> $v_select_employee_info->serial_no,
												'leave_adjust' 			=> $v_select_employee_info->leave_adjust,
												'remarks' 				=> $v_select_employee_info->remarks,
												'designation_name' 		=> $employee_info->designation_name,
												'branch_name' 			=> $employee_info->branch_name,
												'emp_name' 				=> $employee_info->emp_name
											);   
										}
										
									}
								}
			 } 
			}else{
				
				$all_branch = DB::table('tbl_branch')->where('area_code',$area_code1)->where('status',1)->get();
				 /*  echo '<pre>'; 
				print_r($all_branch);
				exit; */
				foreach($all_branch as $v_all_branch){
					 
					$all_result = DB::table('tbl_master_tra as m')
									->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
									->where('m.br_code', '=', $v_all_branch->br_code)
									->where('m.br_join_date', '<=', $form_date)
									->where(function($query) use ($form_date) { 
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date); 
										})
									
									->select('m.emp_id')
									->groupBy('m.emp_id')
									->get()->toArray();
						
						$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										->where('eas.br_code', '=', $v_all_branch->br_code)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($form_date) { 
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date); 
										})									
										->select('eas.emp_id')
										->get()->toArray();
						$select_employee = array_unique(array_merge($all_result,$assign_branch), SORT_REGULAR);
					
					
					
					
					foreach($select_employee as $employee){ 
						
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
								if(!empty($max_sarok)){			
									$employee_info  = DB::table('tbl_master_tra as m')  
													->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
													->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
													->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')  
													->where('m.sarok_no', '=', $max_sarok->sarok_no)
													->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','b.br_code','emp.org_join_date as joining_date')
													->first();  
									if($v_all_branch->br_code == $employee_info->br_code){
										$select_employee_info  = DB::table('tbl_leave_history as linf')
																 ->where('linf.is_view',1)  
																 ->where('linf.f_year_id',$f_year_id) 
																 ->where('linf.emp_id',$emp_id1)  
																 ->select('linf.f_year_id','linf.emp_id','linf.appr_from_date','linf.appr_to_date','linf.no_of_days_appr','linf.serial_no','linf.leave_adjust','linf.remarks') 
																 ->get();
										foreach($select_employee_info  as $v_select_employee_info ){
											$data['all_report'][] = array(
												'emp_id_u' 				=> $employee_info->emp_id,
												'branch_code' 			=> $employee_info->br_code,
												'emp_id' 				=> $employee->emp_id,  
												'appr_from_date' 		=> $v_select_employee_info->appr_from_date,
												'appr_to_date' 			=> $v_select_employee_info->appr_to_date,
												'no_of_days_appr' 		=> $v_select_employee_info->no_of_days_appr,
												'serial_no' 			=> $v_select_employee_info->serial_no,
												'leave_adjust' 			=> $v_select_employee_info->leave_adjust,
												'remarks' 				=> $v_select_employee_info->remarks,
												'designation_name' 		=> $employee_info->designation_name,
												'branch_name' 			=> $employee_info->branch_name,
												'emp_name' 				=> $employee_info->emp_name
											);   
										}
										
									}
								}
						} 				  
				
				}
				
			} 
		}else{ 
				$all_branch = DB::table('tbl_branch')
								->leftJoin('tbl_area as ar', 'ar.area_code', '=', 'tbl_branch.area_code') 
								->leftJoin('tbl_zone as z', 'z.zone_code', '=', 'ar.zone_code') 
								->where('z.zone_code',$zone_code)
								->where('tbl_branch.status',1)
								->get();
				 /* echo '<pre>'; 
				print_r($all_branch); */
				foreach($all_branch as $v_all_branch){
					
					
					
					
					
					$all_result = DB::table('tbl_master_tra as m')
									->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
									->where('m.br_code', '=', $v_all_branch->br_code)
									->where('m.br_join_date', '<=', $form_date)
									->where(function($query) use ($form_date) { 
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date); 
										})
									
									->select('m.emp_id')
									->groupBy('m.emp_id')
									->get()->toArray();
						
						$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										->where('eas.br_code', '=', $v_all_branch->br_code)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($form_date) { 
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date); 
										})									
										->select('eas.emp_id')
										->get()->toArray();
						$select_employee = array_unique(array_merge($all_result,$assign_branch), SORT_REGULAR);
					
					
					
					
					foreach($select_employee as $employee){ 
						
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
								if(!empty($max_sarok)){			
									$employee_info  = DB::table('tbl_master_tra as m')  
													->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
													->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
													->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
													->leftJoin('tbl_area as ar', 'ar.area_code', '=', 'b.area_code')
													->where('m.sarok_no', '=', $max_sarok->sarok_no)
													->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','ar.area_code','d.designation_code','b.branch_name','b.br_code','emp.org_join_date as joining_date')
													->first();  
									if($v_all_branch->br_code == $employee_info->br_code){
										$select_employee_info  = DB::table('tbl_leave_history as linf')
																 ->where('linf.is_view',1)  
																 ->where('linf.f_year_id',$f_year_id) 
																 ->where('linf.emp_id',$emp_id1)
																 ->select('linf.f_year_id','linf.emp_id','linf.appr_from_date','linf.appr_to_date','linf.no_of_days_appr','linf.serial_no','linf.leave_adjust','linf.remarks') 
																 ->get();
										foreach($select_employee_info  as $v_select_employee_info ){
											$data['all_report'][] = array(
												'emp_id_u' 				=> $employee_info->emp_id,
												'branch_code' 			=> $employee_info->br_code,
												'area_code' 			=> $employee_info->area_code,
												'emp_id' 				=> $employee->emp_id,  
												'appr_from_date' 		=> $v_select_employee_info->appr_from_date,
												'appr_to_date' 			=> $v_select_employee_info->appr_to_date,
												'no_of_days_appr' 		=> $v_select_employee_info->no_of_days_appr,
												'serial_no' 			=> $v_select_employee_info->serial_no,
												'leave_adjust' 			=> $v_select_employee_info->leave_adjust,
												'remarks' 				=> $v_select_employee_info->remarks,
												'designation_name' 		=> $employee_info->designation_name,
												'branch_name' 			=> $employee_info->branch_name,
												'emp_name' 				=> $employee_info->emp_name
											);   
										}
										
									}
								}
					} 
						
				}
		}
				
	   /*  echo '<pre>'; 
		print_r($data['all_report']);
		exit;   */
		return view('admin.reports.leave_report_dm_am',$data);
    }
	
	public function leave_report_dm_am()
    {
        $data = array();
		$data['action'] = 'leave_reprt_dm/';  
		$user_type 			= Session::get('user_type');
		$area_code 			= Session::get('area_code');
		$zone_code 			= Session::get('zone_code');
		$data['branch_code'] 	= '';
		$data['all_branch'] 	= '';
		$data['f_year_id'] 		= 3;
		$data['user_type'] 		= $user_type;
		if($user_type == 3){
			$data['all_area'] 	= DB::table('tbl_area')->where('zone_code',$zone_code)->where('status',1)->get();
		}else if($user_type == 1){
			$data['all_area'] 	= DB::table('tbl_area')->where('status',1)->get();
		}else{
			$data['all_area'] 	= DB::table('tbl_area')->where('area_code',$area_code)->where('status',1)->get();
		}
		
		$data['area_code'] = 'all_a';
		//$data['all_br'] = DB::table('tbl_branch')->where('status',1)->get();
		$data['all_fy'] = DB::table('tbl_financial_year')->get();
		return view('admin.reports.leave_report_dm_am',$data);
    } 
	public function change_area_to_branch($area_code)
    {
		$zone_code 			= Session::get('zone_code');
		//$all_branch =  'ok'; 
		$all_branch	= DB::table('tbl_branch')->where('area_code',$area_code)->where('status',1)->get();
		echo json_encode(array('data' => $all_branch));	 
    }
}
