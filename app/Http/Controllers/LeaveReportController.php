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
	function get_eid_leave($emp_id){
		$exists_eid_leave   = DB::table('tbl_leave_history as linf')
								 ->where('linf.modify_cancel',0)    
								 ->where('linf.emp_id',$emp_id)     
								 ->where('linf.remarks','Vacation For Eid Ul Adha')    
								 ->where('linf.f_year_id',4)    
								 ->where('linf.is_view',1)  
								 ->select('linf.no_of_days') 
								 ->first();  
			if($exists_eid_leave){
				$no_of_days = $exists_eid_leave->no_of_days;
			}else{
				$no_of_days = 0;
			}
			return $no_of_days;
	}
	function get_earn_leave($org_join_date,$resign_date,$emp_id){
			
			date_default_timezone_set("Asia/Dhaka"); 
			/* //$org_join_date = "19-11-2019";
			$org_join_date = '2021-07-01';
			$resign_date   =  '2021-11-05';
			 */
			$org_join_date =     date('Y-m-d',strtotime($org_join_date));
			$joinday	 =     date('d',strtotime($org_join_date));
			$total_day	 =     date('t',strtotime($org_join_date));
			$resign_date   =  date('Y-m-d',strtotime('-1 day', strtotime($resign_date)));
			$resign_day   =  date('d',strtotime($resign_date));
			$total_day_resign   =  date('t',strtotime($resign_date));
			  
			if(date('m-Y',strtotime($org_join_date)) == date('m-Y',strtotime($resign_date)) ){
				$earn_leave =  $this->resign_day_calculation($resign_date,$resign_day,$total_day_resign);
				
			}else{
				
				if($resign_date  <= '2020-07-01'){
				
				 //// resign before 20-21 fiscal Year
					  $join_additonal_day = $this->join_day_calculation($org_join_date,$joinday,$total_day);
					  $month = $this->month_difference_two_dates($org_join_date,$resign_date);
					  $resign_additonal_day  =  $this->resign_day_calculation($resign_date,$resign_day,$total_day_resign);
					  $earn_leave =  $join_additonal_day + $month * 1.5 + $resign_additonal_day  ;
				 }else if($resign_date <  '2021-06-30'){

					 /// resign between 20-21 fiscal Year  
					 if($resign_date <= '2020-12-31'){
						/// resign before 31-12-2020
						
						  $join_additonal_day = $this->join_day_calculation($org_join_date,$joinday,$total_day);
						  $month = $this->month_difference_two_dates($org_join_date,$resign_date);
						  $resign_additonal_day  = $this->resign_day_calculation($resign_date,$resign_day,$total_day_resign);
						  $earn_leave =  $join_additonal_day + $month * 1.5 + $resign_additonal_day + 3  ; /// eid leave;
						 
					 }else{
						 if($org_join_date <= '2020-07-01'){
							 //// join before 01-07-2020 and resign after 31-12-2020
							 $eid_leave = $this->get_eid_leave($emp_id);
							 $org_join_date = '2021-01-01';
							  $earn_leave 	= 9 +  $eid_leave; /// eid leave 3 days 
							  $joinday = 01;
							  $total_day = 31; 
							 
							   if(date('m-Y',strtotime($org_join_date)) == date('m-Y',strtotime($resign_date))){
								   /// join and resign same month 
									$earn_leave += $this->resign_day_calculation($resign_date,$resign_day,$total_day_resign);
							   }else{
									/// join and resign NOT same month 
									$month = $this->month_difference_two_dates($org_join_date,$resign_date);
									$join_additonal_day = $this->join_day_calculation($org_join_date,$joinday,$total_day);
									$resign_additonal_day  = $this->resign_day_calculation($resign_date,$resign_day,$total_day_resign);
									$earn_leave +=  $join_additonal_day + $month * 2 + $resign_additonal_day;
								 
							  } 
						 }else{ 
							 if($org_join_date  <= '2020-12-31'){
								 
								  ///// join after 01-07-20220 and before 31-12-2020 and resign after 31-12-2020 /// 
								   $eid_leave = $this->get_eid_leave($emp_id);
								  $join_additonal_day = $this->join_day_calculation($org_join_date,$joinday,$total_day);
								  $resign_date_create = '2020-12-31';
								  $resign_day_create   = 31;
								  $total_day_resign_create = 31;
								  $resign_additonal_day  = $this->resign_day_calculation($resign_date_create,$resign_day_create,$total_day_resign_create); 
								  $month = $this->month_difference_two_dates($org_join_date,$resign_date_create); 
								  $earn_leave =  $join_additonal_day + $month * 1.5 + $resign_additonal_day + $eid_leave;/// 3 days eid leave
								  $org_join_date_create = '2021-01-01';
								  
								  if(date('m-Y',strtotime($org_join_date_create)) == date('m-Y',strtotime($resign_date))){
									  /// join and resign same month 
										$earn_leave += $this->resign_day_calculation($resign_date,$resign_day,$total_day_resign);								  
								  }else{
										$joinday = 01;
										$total_day = 31;
									  //// join and resign NOT same month 
										$month = $this->month_difference_two_dates($org_join_date_create,$resign_date);
										$join_additonal_day = $this->join_day_calculation($org_join_date_create,$joinday,$total_day);
										$resign_additonal_day  = $this->resign_day_calculation($resign_date,$resign_day,$total_day_resign);
										$earn_leave +=  $join_additonal_day + $month * 2 + $resign_additonal_day;
								  }
							 }else{
									///// join and resign after 31-12-2020 /// 
									$month = $this->month_difference_two_dates($org_join_date,$resign_date);
									$join_additonal_day = $this->join_day_calculation($org_join_date,$joinday,$total_day);
									$resign_additonal_day  = $this->resign_day_calculation($resign_date,$resign_day,$total_day_resign);
									$earn_leave =  $join_additonal_day + $month * 2 + $resign_additonal_day;
								 
							 }
							 
						 }
						 
					 }
				 }else{
					
					 //// resign  after 20-21 fiscal Year 
						  $join_additonal_day = $this->join_day_calculation($org_join_date,$joinday,$total_day);
						  $month = $this->month_difference_two_dates($org_join_date,$resign_date);
						  $resign_additonal_day  = $this->resign_day_calculation($resign_date,$resign_day,$total_day_resign);
						 $earn_leave =  $join_additonal_day + $month * 2 + $resign_additonal_day  ; 
				 }
			}
			return $earn_leave;
		}
		
 
	function month_difference_two_dates($org_join_date,$resign_date){ 
			$org_join_date  = date('Y-m', strtotime('+1 months', strtotime( date("Y-m",strtotime($org_join_date)) ))); 	 
			$resign_date  = date('Y-m', strtotime('-1 months', strtotime( date("Y-m",strtotime($resign_date)) ))); 
			if($org_join_date < $resign_date ){ 
				$start_day = $org_join_date;	
				$end_date = $resign_date ; 
				$year1 = date('Y', strtotime($start_day));
				$year2 = date('Y', strtotime($end_date)); 
				$month1 = date('m', strtotime($start_day));
				$month2 = date('m', strtotime($end_date)); 
				$month = (($year2 - $year1) * 12) + ($month2 - $month1) + 1;
			}else if($org_join_date == $resign_date ){
				 $month = 1;
			}else{
				$month = 0;
			}
			
			return $month;
			
			 
		}
    function join_day_calculation($org_join_date,$joinday,$total_day){
			$j_additional_day = 0;
			if($org_join_date >= '2021-01-01'){
				if($joinday <= 10){
					$j_additional_day = 2;
				}else if($joinday <= 20){
					$j_additional_day = 1.5;
				}else{
					$j_additional_day = 1;
				}
			 }else{
				 if($joinday <= 10){
					$j_additional_day = 1.5;
				}else if($joinday <= 20){
					$j_additional_day = 1;
				}else{
					$j_additional_day = .5;
				} 
			 }
			 
			return $j_additional_day;			
		} 
	function resign_day_calculation($resign_date,$resign_day,$total_day_resign){
			$r_additional_day = 0;
		    if($resign_date < '2020-12-31'){
				if($resign_day <= 10){
					$r_additional_day = 0;
					
				}else if($resign_day <= 20){
					 $r_additional_day = .5;
				}else if($resign_day < $total_day_resign){
					$r_additional_day = 1;
				}else{
					$r_additional_day = 1.5;
				} 
			}else{
				if($resign_day == $total_day_resign){
					$r_additional_day = 2;
				}else if($resign_day == 30){
					$r_additional_day = 2;
				}else if($resign_day  >= 15){
					$r_additional_day = 1;
				}else {
					$r_additional_day = 0;
				}
			}
			return $r_additional_day;			
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
										 ->where('lib.modify_cancel',0)    
										 ->where('lib.emp_id',$emp_id)    
										 ->where('lib.f_year_id',$select_fiscal_year->id)  
										 ->select(DB::raw('max(tot_earn_leave) as tot_earn_leave'))
										 ->first(); 
			/*  echo '<pre>'; 
		print_r($data['fiscal_year']);
		exit; 		 */					 
										 
		    $get_date  = DB::table('tbl_leave_history as linf') 
										 ->where('linf.modify_cancel',0)    
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
			/*  echo $f_year_start;
				exit; */
			date_default_timezone_set('Asia/Dhaka');
			$joining_date = $data['employee_his']->joining_date;
				   
			  /*  echo $f_year_start;
				exit;   */	
			/* $data['from_date'] 	=  '2019-04-01';
			$joining_date 		= '2019-02-19';  */
			$j_additional_day = 0;
			$r_additional_day = 0;
			 if($data['report_type'] == 2){
				 if($joining_date > $f_year_start.'-'.'07'.'-'.'01'){ 
				     $org_join_date = $joining_date;
					$earn_leave = $this->get_earn_leave($org_join_date,$data['from_date'],$emp_id);
				 
				 }else{
					
						 $org_join_date = $f_year_start.'-'.'07'.'-'.'01'; 
						 $earn_leave = $this->get_earn_leave($org_join_date,$data['from_date'],$emp_id);
						   
				 }   		
				$data['extra_earn'] = $earn_leave;
					 
			}else{ 
			
				$j_additional_day = 0;
				
			  
				 if($joining_date > $f_year_start.'-'.'07'.'-'.'01'){ 
					 $system_time = date("Y-m-d",strtotime('+1 month', strtotime($joining_date)));
					 $join_day   =  date('d',strtotime($system_time));
					 $join_month   =  date('m',strtotime($system_time));
					 
					 
					 if($joining_date > '2020-12-31'){
						  if($join_day <= 10){
							$j_additional_day = 2;
							}else if($join_day <= 20){
								$j_additional_day = 1.5;
							}else{
								$j_additional_day = 1;
							} 
					 }else{
						  if($join_day <= 10){
							$j_additional_day = 1.5;
						}else if($join_day <= 20){
							$j_additional_day = 1;
						}else{
							$j_additional_day = .5;
						} 
					 }  
				}else{
					 $system_time = $f_year_start.'-'.'07'.'-'.'01'; 
					  
				} 
				
				/*  if($data['from_date'] > '2020-12-31'){
					if($joining_date < '2020-12-31'){
						 
						$within_date = '2020-12-31';
					}else{
						$within_date = $joining_date;	
					}
					$system_time = date('Y-m-01',strtotime($system_time)); 
						$date1=date_create($system_time);
						$date2=date_create($within_date);
						$diff=date_diff($date1,$date2);
		 
						$total_month= ($diff->format("%R%a"))/30;

						$total_month = intval($total_month); 
						 
						if(strtotime($within_date) < strtotime($system_time)){
							$data['extra_earn'] = ((-$total_month) * 1.5);
						}else{
							$data['extra_earn'] = ($total_month * 1.5);
						}
					
					
					$within_date = date('Y-m-03',strtotime($data['from_date']));	
					$system_time = '2021-01-01'; 
					$date1=date_create($system_time);
					$date2=date_create($within_date);
					$diff=date_diff($date1,$date2);
	 
					$total_month= ($diff->format("%R%a"))/30;

					$total_month = intval($total_month); 
					 
					if(strtotime($within_date) < strtotime($system_time)){
						$data['extra_earn'] += ((-$total_month) * 2);
					}else{
						$data['extra_earn'] += ($total_month * 2);
					}
					
					$data['extra_earn'] +=  $j_additional_day;
				 }else{   */
					$within_date = date('Y-m-03',strtotime($data['from_date']));	 
					$system_time = date('Y-m-01',strtotime($system_time)); 
					$date1=date_create($system_time);
					$date2=date_create($within_date);
					$diff=date_diff($date1,$date2);
	 
					$total_month= ($diff->format("%R%a"))/30;

					$total_month = intval($total_month); 
					 
					if(strtotime($within_date) < strtotime($system_time)){
						$data['extra_earn'] = ((-$total_month) * 2)+ $j_additional_day;
					}else{
						$data['extra_earn'] = ($total_month * 2) + $j_additional_day;
					}  
				// }
					/* echo $data['extra_earn'];
					exit; */
				
				
				
				} 
				$fiscal_end_year = $f_year_start + 1;
				$fiscal_end_date =  $fiscal_end_year.'-'.'06'.'-'.'30'; 
				$data['getleaveinfowithpay']   = DB::table('tbl_leave_history as linf')
												 ->where('linf.modify_cancel',0)    
												 ->where('linf.f_year_id',$select_fiscal_year->id)  
												 //->where('linf.application_date','<=',$fiscal_end_date)   
												 ->where('linf.emp_id',$emp_id)  
												->where(function($q){
													 $q->where('linf.is_pay',1)  
															->orwhere('linf.is_pay',3);
												 })
												
												 ->where('linf.type_id',1)     
												 ->where('linf.is_view',1)  
												 ->orderby('linf.appr_from_date','asc')
												 ->select('linf.*') 
												 ->get();
				$data['getcasualleaveinfowithpay']   = DB::table('tbl_leave_history as linf')
														 ->where('linf.modify_cancel',0)    
														 ->where('linf.f_year_id',$select_fiscal_year->id)  
														 //->where('linf.application_date','<=',$fiscal_end_date)   
														 ->where('linf.emp_id',$emp_id)  
														->where(function($q){
															 $q->where('linf.is_pay',1)  
																	->orwhere('linf.is_pay',3);
														 })
														
														 ->where('linf.type_id',5)    
														 ->where('linf.is_view',1)  
														 ->orderby('linf.appr_from_date','asc')
														 ->select('linf.*') 
														 ->get();   
			$data['getleavemeternity']   = DB::table('tbl_leave_history as linf')
												 ->where('linf.modify_cancel',0)    
												 ->where('linf.f_year_id',$select_fiscal_year->id)  
												 //->where('linf.application_date','<=',$fiscal_end_date)   
												 ->where('linf.emp_id',$emp_id)    
												 ->where('linf.is_pay',1)  
												 ->where('linf.type_id',2)   
												 ->where('linf.is_view',1)  
												 ->orderby('linf.appr_from_date','asc')
												 ->select('linf.*') 
												 ->get();  					 
			$data['getleavespecial']   = DB::table('tbl_leave_history as linf')
												 ->where('linf.modify_cancel',0)    
												 ->where('linf.f_year_id',$select_fiscal_year->id)  
												// ->where('linf.application_date','<=',$fiscal_end_date)   
												 ->where('linf.emp_id',$emp_id)     
												 ->where('linf.type_id',3)    
												 ->where('linf.is_view',1)  
												 ->orderby('linf.appr_from_date','asc')
												 ->select('linf.*') 
												 ->get(); 
		/* 	$data['fiscal_year_9_12']   = DB::table('tbl_leave_history as linf')
												 ->where('linf.f_year_id',$select_fiscal_year->id)  
												 ->where('linf.application_date','<=',$fiscal_end_date)   
												 ->where('linf.emp_id',$emp_id)     
												 ->where('linf.is_view',1)  
												 ->orderby('linf.appr_from_date','asc')
												 ->select('linf.*') 
												 ->get();  */
			$data['getleaveinfowithoutpay']   = DB::table('tbl_leave_history as linf')
													->where('linf.modify_cancel',0)   
													 ->where('linf.f_year_id',$select_fiscal_year->id)  
													 //->where('linf.application_date','<=',$fiscal_end_date)   
													 ->where('linf.emp_id',$emp_id)     
													 ->where('linf.type_id','!=',3)    
													 ->where('linf.is_pay',2)    
													 ->where('linf.is_view',1)  
													 ->orderby('linf.appr_from_date','asc')
													 ->select('linf.*') 
													 ->get(); 
			$data['finalwithoutpay']   = DB::table('tbl_leave_history as linf')
													 ->where('linf.modify_cancel',0)    
													 ->where('linf.emp_id',$emp_id)     
													 ->where('linf.type_id','!=',3)    
													 ->where('linf.is_pay',2)    
													 ->where('linf.is_view',1)  
													 ->orderby('linf.appr_from_date','asc')
													 ->select('linf.*') 
													 ->get();  
			$data['getleavequarantine']   = DB::table('tbl_leave_history as linf')
													 ->where('linf.modify_cancel',0)    
													 ->where('linf.f_year_id',$select_fiscal_year->id)  
													 //->where('linf.application_date','<=',$fiscal_end_date)   
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
												 ->where('linf.modify_cancel',0)    
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
												 ->where('linf.modify_cancel',0)    
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
												 ->where('linf.modify_cancel',0)    
												 ->where('linf.f_year_id',4)
												 ->where('linf.emp_id',$employee->emp_id)  
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
												'current_open_balance' 		=> @$employee_leave_blance->current_open_balance,
												'cum_balance_less_12' 		=> @$employee_leave_blance->cum_balance_less_12,
											    'cum_balance_less_close_12' => @$employee_leave_blance->cum_balance_less_close_12,
												'no_of_days' 				=> @$employee_leave_blance->no_of_days,
												'no_of_days_appr' 			=> @$employee_leave_his->no_of_days_appr 
												
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
												 ->where('linf.modify_cancel',0)    
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
																 ->where('linf.modify_cancel',0)    
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
																 ->where('linf.modify_cancel',0)    
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
																 ->where('linf.modify_cancel',0)    
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
