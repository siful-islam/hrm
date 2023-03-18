<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Middleware\Checkuser;
use DB;
use Session;
class LeaveReportbranchController extends Controller
{

	 public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
    public function index()
    {
        $data = array();
		$indata = array(0);
		$data['action'] 				= 'leave_report_branch/'; 
		$data['emp_id'] 				='';
		 
		$data['br_code'] = $br_code = Session::get('branch_code');
		if(in_array($br_code,$indata)){
		  $data['from_date'] 				=  "2020-06-30";
		}else{
		 $data['from_date'] 				= date('Y-m-d'); 
		}  
		//$data['from_date'] 				=  "2021-06-30";
		$data['all_emp_type'] = DB::table('tbl_emp_type')->where('status',1)->get();
		$data['select_fiscal_year'] 	= DB::table('tbl_financial_year') 
											->where('f_year_from','<=',$data['from_date']) 
											->where('f_year_to','>=',$data['from_date']) 
											->select('*')
											->first(); 
		return view('admin.reports.branch_leave_report_form',$data);
    }
	public function leave_report_branch(Request $request)
    {
        $data = array(); 
		$indata = array(0);
		$data['action'] 				= 'leave_report_branch/'; 
		$asigndata 						= array(1,2,5); 
		 
		$br_code 	= Session::get('branch_code');
		if(in_array($br_code,$indata)){
		  $current_date 			=  "2020-06-30";
		}else{
		 $current_date 					= date('Y-m-d');
		}
		   //$current_date 			=  "2021-06-30";
		$data['select_fiscal_year'] 	= $select_fiscal_year = DB::table('tbl_financial_year') 
																->where('f_year_from','<=',$current_date) 
																->where('f_year_to','>=',$current_date) 
																->select('*')
																->first();
		 
		$data['emp_id'] 				= $emp_id    = $request->emp_id;
		$data['from_date'] 				= $from_date = $data['select_fiscal_year']->f_year_from; 
		
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
		if(!empty($data['employee_his'])){
			if($br_code == $data['employee_his']->br_code){
			$data['is_employee'] = 1;		
					
		
			$data['fiscal_year'] = DB::table('tbl_leave_balance as lib')   
										  ->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'lib.f_year_id') 
										 ->where('lib.emp_id',$emp_id)   
										 ->where('lib.f_year_id',$select_fiscal_year->id)  
										 ->select('lib.*','fy.f_year_from','fy.f_year_to')
										 ->first(); 
			 
			/*  echo '<pre>'; 
		print_r($data['fiscal_year']);
		exit; 		 */					 
										 
		    $joining_date 		= $data['employee_his']->joining_date;
			$j_additional_day 	= 0;
			if($joining_date > $from_date){  
				 $join_day   =  date('d',strtotime($joining_date));
				  if($join_day <= 10){
						$j_additional_day = 2;
					}else if($join_day <= 20){
						$j_additional_day = 1.5;
					}else{
						$j_additional_day = 1;
					}  
					$start_day = strtotime($joining_date);
					$end_date = strtotime($current_date); 
					$year1 = date('Y', $start_day);
					$year2 = date('Y', $end_date);

					$month1 = date('m', $start_day);
					$month2 = date('m', $end_date);

					$tot_month = (($year2 - $year1) * 12) + ($month2 - $month1);
					if($tot_month == 0){
						$earn_leave =  $j_additional_day ;
					}else if($tot_month == 1){
						$earn_leave =  $j_additional_day ;
					}else {
						$earn_leave =  $j_additional_day + ( $tot_month - 1 )* 2;
					}
			}else{
				$start_day = strtotime($from_date);
				$end_date = strtotime($current_date); 
				$year1 = date('Y', $start_day);
				$year2 = date('Y', $end_date);

				$month1 = date('m', $start_day);
				$month2 = date('m', $end_date);

				$tot_month = (($year2 - $year1) * 12) + ($month2 - $month1);
				if($tot_month == 0){
					$earn_leave =  $j_additional_day ;
				}else {
					$earn_leave =  $j_additional_day + ( $tot_month)* 2;
				}
			} 
				
				
				 
				$data['extra_earn'] = $earn_leave; 
				$fiscal_end_date =  $data['select_fiscal_year']->f_year_to; 
				
				$data['getleaveinfowithpay']   = DB::table('tbl_leave_history as linf')
												->leftJoin('tbl_branch as b', 'b.br_code', '=', 'linf.branch_code')
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
												 ->orderby('linf.branch_code','asc')
												 ->orderby('linf.appr_from_date','asc')
												 ->select('linf.*','b.br_code','b.branch_name',DB::raw("(SELECT 
																				  count(id)
																				  FROM tbl_leave_history 
																				   where branch_code = linf.branch_code AND emp_id = $emp_id  AND is_pay = 1 AND type_id = 1 AND f_year_id = $select_fiscal_year->id AND leave_adjust = 1 AND is_view = 1 AND application_date <= '$fiscal_end_date' GROUP BY branch_code) as total_row")) 
												 ->get();
				
				$data['getcasualleaveinfowithpay']   = DB::table('tbl_leave_history as linf')
														->leftJoin('tbl_branch as b', 'b.br_code', '=', 'linf.branch_code')
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
														 ->orderby('linf.branch_code','asc')
														 ->orderby('linf.appr_from_date','asc')
														 ->select('linf.*','b.br_code','b.branch_name',DB::raw("(SELECT 
																						  count(id)
																						  FROM tbl_leave_history 
																						   where branch_code = linf.branch_code AND emp_id = $emp_id AND is_pay = 1 AND type_id = 5 AND f_year_id = $select_fiscal_year->id AND leave_adjust = 1 AND is_view = 1 AND application_date <= '$fiscal_end_date' GROUP BY branch_code) as total_row")) 
														 ->get();          
			/* 	 echo '<pre>'; 
		print_r($data['getleaveinfowithpay']);
		exit; */
				
				$data['getleaveprevious']   = DB::table('tbl_leave_history as linf')
												->leftJoin('tbl_branch as b', 'b.br_code', '=', 'linf.branch_code') 
												 ->where('linf.f_year_id',$select_fiscal_year->id)  
												 ->where('linf.application_date','<=',$fiscal_end_date)   
												 ->where('linf.emp_id',$emp_id)   
												 ->where('linf.is_pay',1)  
												 ->where('linf.type_id','!=',3) 
												 ->where('linf.leave_adjust',2)  
												 ->where('linf.is_view',1)  
												 ->orderby('linf.branch_code','asc')
												 ->orderby('linf.appr_from_date','asc')
												->select('linf.*','b.br_code','b.branch_name',DB::raw("(SELECT 
																				  count(id)
																				  FROM tbl_leave_history 
																				   where branch_code = linf.branch_code AND emp_id = $emp_id  AND is_pay = 1 AND type_id != 3 AND type_id != 2  AND f_year_id = $select_fiscal_year->id AND leave_adjust = 2 AND is_view = 1 AND application_date <= '$fiscal_end_date' GROUP BY branch_code) as total_row")) 
												 ->get(); 	  
			$data['getleaveinfowithoutpay']   = DB::table('tbl_leave_history as linf')
													->leftJoin('tbl_branch as b', 'b.br_code', '=', 'linf.branch_code') 
													 ->where('linf.f_year_id',$select_fiscal_year->id)  
													 ->where('linf.application_date','<=',$fiscal_end_date)   
													 ->where('linf.emp_id',$emp_id)     
													 ->where('linf.type_id','!=',3)    
													 ->where('linf.is_pay',2)    
													 ->where('linf.is_view',1) 
													->orderby('linf.branch_code','asc')													 
													 ->orderby('linf.appr_from_date','asc')
													 ->select('linf.*','b.br_code','b.branch_name',DB::raw("(SELECT 
																				  count(id)
																				  FROM tbl_leave_history 
																				   where branch_code = linf.branch_code AND emp_id = $emp_id  AND is_pay = 2 AND type_id != 3 AND f_year_id = $select_fiscal_year->id  AND is_view = 1 AND application_date <= '$fiscal_end_date' GROUP BY branch_code) as total_row"))  
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
			
				$data['getleavespecial']   = DB::table('tbl_leave_history as linf')
												 ->where('linf.f_year_id',$select_fiscal_year->id)  
												 ->where('linf.application_date','<=',$fiscal_end_date)   
												 ->where('linf.emp_id',$emp_id)    
												 ->where('linf.type_id',3)    
												 ->where('linf.is_view',1)  
												 ->orderby('linf.appr_from_date','asc')
												 ->select('linf.*') 
												 ->get(); 
			
			
			
			}else{
				/// not in this branch
				$data['is_employee'] = 2;
			}
		}
		
		$data['all_emp_type'] = DB::table('tbl_emp_type')->where('status',1)->get();
		
		/*  echo '<pre>'; 
		print_r($data['getleaveinfowithoutpay']);
		exit;  */ 
		return view('admin.reports.branch_leave_report_form',$data);
    }
	 
}
