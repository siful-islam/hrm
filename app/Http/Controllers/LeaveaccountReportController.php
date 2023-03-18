<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Middleware\Checkuser;
use DB;
use Session;
class LeaveaccountReportController extends Controller
{

	 public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	public function acco_leave_report()
    {
        $data = array(); 
		$data['action'] 				= 'acco_leave_report/';  
		$data['from_date'] 				= $from_date 	=	date("2020-06-01"); 
		$data['to_date'] 				= $to_date 		=	date("2020-06-30"); 
		 
		 
		$month = date('m',strtotime($data['from_date']));
		$year = date('Y',strtotime($data['from_date']));
		 
		if ($month<= 6) { 
			$f_year_start  = ($year-1) ; 
		}else{ 
			$f_year_start  = $year;   
		}  
				/* $select_all_employee  = DB::table('tbl_leave_history as linf')
												 ->where(function($q) use ($from_date) {
													 $q->where('linf.appr_from_date','>=', $from_date)
													   ->orWhere('linf.appr_to_date','>=', $from_date);
												 })
												 ->where(function($q) use ($to_date) {
													 $q->where('linf.appr_from_date','<=', $to_date)
													   ->orWhere('linf.appr_to_date','<=', $to_date);
												 })
												 ->where('linf.is_view',1)
												 ->groupBy('linf.emp_id','linf.emp_type')
												 ->orderby('linf.emp_id','asc')
												 ->select('linf.emp_id','linf.emp_type',DB::raw('count(linf.id) as total_row'),DB::raw('SUM(linf.no_of_days_appr) as tot_no_of_days_appr')) 
												 ->get();    */

			$status 	= 'running';
			//$data['form_date'] = $form_date 	= date("Y-m-d");
			$data['form_date'] = $form_date 	= date("2021-06-30");
			$all_result = DB::table('tbl_emp_basic_info as e')
						->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
						->where('e.emp_type', '=', 1)
						->where('e.org_join_date', '<=', $form_date)
						
						->where(function($query) use ($status, $form_date) {
								if($status == 'running') {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);
								} else if ($status == 'cancel') {
									$query->where('r.effect_date', '<=', $form_date);
								}/*  elseif ($status == 'all') {
									$query->whereNull('r.emp_id');
									$query->whereNotNull('r.emp_id');
								} */
							})

						->orderBy('e.emp_id', 'ASC')
						->select('e.*','r.effect_date')
						->get();
		//print_r ($all_result); exit;				
		foreach ($all_result as $result) {
			 
				$bs_salary = 0;
				$emp_id = $result->emp_id;
				$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $result->emp_id)
						->where('m.effect_date', '=', function($query) use ($emp_id,$form_date)
								{
									$query->select(DB::raw('max(effect_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('effect_date', '<=', $form_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no')) 
						->groupBy('m.emp_id')
						->first();
			//print_r ($max_sarok);			
			$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->select('m.emp_id','m.br_join_date','m.tran_type_no','m.basic_salary','d.designation_name','b.branch_name','a.area_name','g.grade_name')
						->first();
			//print_r ($data_result);
			//// employee assign ////
			 
					$max_sarok_sa = DB::table('tbl_emp_salary as sa')
							->where('sa.emp_id', '=', $result->emp_id)
							->where('sa.effect_date', '=', function($query) use ($emp_id,$form_date)
								{
									$query->select(DB::raw('max(effect_date)'))
										  ->from('tbl_emp_salary')
										  ->where('emp_id',$emp_id)
										  ->where('effect_date', '<=', $form_date);
								})
							->select('sa.emp_id',DB::raw('max(sa.sarok_no) as sarok_no'))
							->groupBy('sa.emp_id')
							->first();
						if(!empty($max_sarok_sa)) {
						$salary = DB::table('tbl_emp_salary')
									->where('emp_id', '=', $max_sarok_sa->emp_id)
									->where('sarok_no', '=', $max_sarok_sa->sarok_no)
									->select('emp_id','salary_basic','total_plus','payable','net_payable','gross_total')
									->first();
						}			
						//print_r ($max_sarok_sa);//exit;
						if(!empty($salary)) {
							$bs_salary = $salary->salary_basic; 
						}
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
					->select('ea.emp_id','ea.open_date','br.branch_name','ar.area_name')
					->first();
			if(!empty($assign_branch)) {
				$asign_branch_name = $assign_branch->branch_name;
				$asign_area_name = $assign_branch->area_name;
				$asign_open_date = date('d M Y',strtotime($assign_branch->open_date));
			} else {
				$asign_branch_name = '';
				$asign_area_name =  '';
				$asign_open_date =  '';
			}
			
			 $employee_leave_balance  = DB::table('tbl_leave_balance as linf') 
												 ->where('linf.emp_id', $result->emp_id)
												 ->where('linf.emp_type', 1)
												 ->where('linf.f_year_id', 4) 
												 ->select('linf.pre_cumulative_close','linf.current_close_balance') 
												 ->first();  
			if(!empty($employee_leave_balance)){
				$pre_cumulative_close = $employee_leave_balance->pre_cumulative_close;
				$current_close_balance = $employee_leave_balance->current_close_balance;
			}else{
				$pre_cumulative_close = 0;
				$current_close_balance = 0;
			}
			
			
			////////
			$data['all_report'][] = array(
					'emp_id' => $result->emp_id,
					'emp_name'      => $result->emp_name_eng,
					'emp_name_ban'      => $result->emp_name_ban,
					'permanent_add'      => $result->permanent_add,
					'father_name'      => $result->father_name,
					'org_join_date'      => date('d M Y',strtotime($result->org_join_date)),
					'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
					'designation_name'      => $data_result->designation_name,
					'branch_name'      => $data_result->branch_name,
					'area_name'      => $data_result->area_name,
					'tran_type_no'      => $data_result->tran_type_no,
					'basic_salary'      => $bs_salary,
					'grade_name'      => $data_result->grade_name,
					're_effect_date'      => $result->effect_date,
					'assign_designation'      => $asign_desig,
					'assign_open_date'      => $desig_open_date,
					'asign_branch_name'      => $asign_branch_name,
					'asign_area_name'      => $asign_area_name,
					'pre_cumulative_close'      => $pre_cumulative_close,
					'current_close_balance'      => $current_close_balance,
					'asign_open_date'      => $asign_open_date
				);	
		}
		return view('admin.reports.account_leave_report',$data);
    } 
}
