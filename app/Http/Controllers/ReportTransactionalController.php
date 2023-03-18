<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class ReportTransactionalController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}	
 	
	public function probationIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'Probation Staff List';
		$data['form_date']		= '';	
		$data['to_date']		= '';
				
		return view('admin.pages.transactional_reports.probation_report',$data);
    }
	
    
	public function probationReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Probation Staff List';
		$data['form_date'] 		= $request->input('form_date');
		$data['to_date'] 		= $request->input('to_date');
		
		$all_result = DB::table('tbl_probation as p')
							->leftJoin('tbl_emp_basic_info as e', 'p.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'p.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'p.br_code', '=', 'b.br_code')
							->where('p.effect_date', '>=', $data['form_date'])
							->where('p.effect_date', '<=', $data['to_date'])
							->where('e.emp_group', '=', 1)
							->select('p.emp_id','e.emp_name_eng','e.org_join_date','e.permanent_add','d.designation_name','b.branch_name','p.designation_code','p.letter_date','p.probation_time','p.br_joined_date')
							->get(); 
		//print_r ($all_result);
		if (!empty($all_result)) {
			foreach ($all_result as $result) {
				$max_exam = DB::table('tbl_emp_edu_info')
					->where('emp_id', '=', $result->emp_id)
					->select('emp_id', DB::raw('max(level_id) as level_id'))
					->groupBy('emp_id')
					->first();
				if (!empty($max_exam)) {
				$exam_result = DB::table('tbl_emp_edu_info as ed')
					->leftJoin('tbl_exam_name as en', 'ed.exam_code', '=', 'en.exam_code')
					->where('ed.emp_id', '=', $max_exam->emp_id)
					->where('ed.level_id', '=', $max_exam->level_id)
					->select('en.exam_name')
					->first();
					//print_r ($exam_result);
					$exam_name = $exam_result->exam_name;
				} else {
					$exam_name = '';
				}
				$data['all_result'][] = array(
						'emp_id' => $result->emp_id,
						'emp_name_eng'      => $result->emp_name_eng,
						'permanent_add'      => $result->permanent_add,
						'exam_name'      => $exam_name,
						'designation_code'      => $result->designation_code,
						'org_join_date'      => $result->org_join_date,
						'br_join_date'      => $result->br_joined_date,
						'letter_date'      => $result->letter_date,
						'probation_time'      => $result->probation_time,
						'designation_name'      => $result->designation_name,
						'branch_name'      => $result->branch_name
					);
			}
		}
		$data['all_designation'] = DB::table('tbl_designation')->get();
		//print_r ($data['all_result']);
		//return response()->json($data);
		//return response()->json($data['all_designation']);
		return view('admin.pages.transactional_reports.probation_report',$data);
		//return view('admin.pages.transactional_reports.probation_report', compact('all_result'))->render();
		
	}
	
	public function permanentIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'Permanent Staff List';
		$data['form_date']	= '';	
		$data['to_date']	= '';
				
		return view('admin.pages.transactional_reports.permanent_report',$data);
    }
	
    
	public function permanentReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Permanent Staff List';
		$data['form_date'] 	= $request->input('form_date');
		$data['to_date'] 	= $request->input('to_date');
		
		$all_result = DB::table('tbl_permanent as p')
							->leftJoin('tbl_emp_basic_info as e', 'p.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'p.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'p.br_code', '=', 'b.br_code')
							->leftJoin('tbl_grade_new as g', 'p.grade_code', '=', 'g.grade_code')
							->where('p.effect_date', '>=', $data['form_date'])
							->where('p.effect_date', '<=', $data['to_date'])
							->select('p.emp_id','e.emp_name_eng','e.org_join_date','e.permanent_add','d.designation_name','b.branch_name','g.grade_name','p.designation_code','p.letter_date','p.br_joined_date','p.next_increment_date')
							->get(); 
		//print_r ($all_result);
		if (!empty($all_result)) {
			foreach ($all_result as $result) {
				$max_exam = DB::table('tbl_emp_edu_info')
					->where('emp_id', '=', $result->emp_id)
					->select('emp_id', DB::raw('max(level_id) as level_id'))
					->groupBy('emp_id')
					->first();
				if (!empty($max_exam)) {
				$exam_result = DB::table('tbl_emp_edu_info as ed')
					->leftJoin('tbl_exam_name as en', 'ed.exam_code', '=', 'en.exam_code')
					->where('ed.emp_id', '=', $max_exam->emp_id)
					->where('ed.level_id', '=', $max_exam->level_id)
					->select('en.exam_name')
					->first();
					//print_r ($exam_result);
					$exam_name = $exam_result->exam_name;
				} else {
					$exam_name = '';
				}
				$data['all_result'][] = array(
					'emp_id' => $result->emp_id,
					'emp_name_eng'      => $result->emp_name_eng,
					'next_increment_date'      => $result->next_increment_date,
					'exam_name'      => $exam_name,
					'designation_code'      => $result->designation_code,
					'grade_name'      => $result->grade_name,
					'org_join_date'      => $result->org_join_date,
					'br_join_date'      => $result->br_joined_date,
					'letter_date'      => $result->letter_date,
					'designation_name'      => $result->designation_name,
					'branch_name'      => $result->branch_name
				);
			}
		}
		$data['all_designation'] = DB::table('tbl_designation')->get();
		//print_r ($data['all_result']);
		return view('admin.pages.transactional_reports.permanent_report',$data);
		
	}
	
	public function incrementIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'Increment Staff List';
		$data['form_date']	= '';	
		$data['to_date']	= '';
				
		return view('admin.pages.transactional_reports.increment_report',$data);
    }
	
    
	public function incrementReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Increment Staff List';
		$data['form_date'] 	= $form_date = $request->input('form_date');
		$data['to_date'] 	= $to_date = $request->input('to_date');
		$current_salary_date = "2020-07-01";
		$pre_salary_date = "2020-06-30";
		
		$all_result= DB::table('tbl_increment as i')
							->leftJoin('tbl_emp_basic_info as e', 'i.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'i.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'i.br_code', '=', 'b.br_code')
							->where('i.effect_date', '>=', $form_date)
							->where('i.effect_date', '<=', $to_date)
							->select('i.emp_id','e.emp_name_eng','e.org_join_date','e.permanent_add','d.designation_name','b.branch_name','i.basic_salary','i.total_pay','i.net_pay','i.designation_code','i.letter_date','i.effect_date','i.br_joined_date','i.next_increment_date','i.increment_type')
							->get();
		foreach ($all_result as $result) {
			$emp_id = $result->emp_id;
			/* Current Salary Info */
			$max_sarok_sa = DB::table('tbl_emp_salary as sa')
					->where('sa.emp_id', '=', $result->emp_id)
					->where('sa.effect_date', '=', function($query) use ($emp_id,$current_salary_date)
						{
							$query->select(DB::raw('max(effect_date)'))
								  ->from('tbl_emp_salary')
								  ->where('emp_id',$emp_id)
								  ->where('effect_date', '=', $current_salary_date);
						})
					->select('sa.emp_id',DB::raw('max(sa.id) as id_no'))
					->groupBy('sa.emp_id')
					->first();
					if(!empty($max_sarok_sa)){
			$current_salary = DB::table('tbl_emp_salary')
					->where('emp_id', '=', $max_sarok_sa->emp_id)
					->where('id', '=', $max_sarok_sa->id_no)
					->select('emp_id','salary_basic','payable','net_payable')
					->first();
					}	
			/* Previous Salary Info */
			$max_sarok_pre_sa = DB::table('tbl_emp_salary as sa')
					->where('sa.emp_id', '=', $result->emp_id)
					->where('sa.effect_date', '=', function($query) use ($emp_id,$pre_salary_date)
						{
							$query->select(DB::raw('max(effect_date)'))
								  ->from('tbl_emp_salary')
								  ->where('emp_id',$emp_id)
								  ->where('effect_date', '<=', $pre_salary_date);
						})
					->select('sa.emp_id',DB::raw('max(sa.id) as pre_id_no'))
					->groupBy('sa.emp_id')
					->first();
					if(!empty($max_sarok_sa)){
					if(!empty($max_sarok_pre_sa)){		
					$prebasic_salary = DB::table('tbl_emp_salary')
							->where('emp_id', '=', $max_sarok_sa->emp_id)
							->where('id', '=', $max_sarok_pre_sa->pre_id_no)
							->select('emp_id','salary_basic')
							->first();
					}
					}		
			$data['all_result'][] = array(
					'emp_id' => $result->emp_id,
					'emp_name_eng'      => $result->emp_name_eng,
					'designation_name'      => $result->designation_name,
					'pre_basic_salary'      => $prebasic_salary->salary_basic,
					'basic_salary'      => $current_salary->salary_basic,
					'total_pay'      => $current_salary->payable,
					'net_pay'      => $current_salary->net_payable,
					'branch_name'      => $result->branch_name
				);		
			
						
		}
		//print_r ($data['all_result']);
		return view('admin.pages.transactional_reports.increment_report',$data);
		
	}
	
	public function promotionIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'Promotion Staff List';
		$data['form_date']	= '';	
		$data['to_date']	= '';
				
		return view('admin.pages.transactional_reports.promotion_report',$data);
    }
	
    
	public function promotionReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Promotion Staff List';
		$data['form_date'] 	= $request->input('form_date');
		$data['to_date'] 	= $request->input('to_date');
		
		$data['all_result'] = DB::table('tbl_promotion as p')
							->leftJoin('tbl_emp_basic_info as e', 'p.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'p.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'p.br_code', '=', 'b.br_code')
							->leftJoin('tbl_grade_new as g', 'p.grade_code', '=', 'g.grade_code')
							->leftJoin('tbl_emp_salary as es', function($join)
								{
									$join->on('p.emp_id', '=', 'es.emp_id')
									->on('p.sarok_no', '=', 'es.sarok_no');

								})
							->where('p.effect_date', '>=', $data['form_date'])
							->where('p.effect_date', '<=', $data['to_date'])
							->select('p.emp_id','e.emp_name_eng','e.org_join_date','e.permanent_add','d.designation_name','b.branch_name','g.grade_name','es.salary_basic','es.payable','es.net_payable','p.designation_code','p.letter_date','p.effect_date','p.br_joined_date','p.next_increment_date','p.promotion_type')
							->get();

		//print_r ($data['all_result']);
		return view('admin.pages.transactional_reports.promotion_report',$data);
		
	}
	
	public function transferIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'Transfer Staff List';
		$data['form_date']	= '';	
		$data['to_date']	= '';
				
		return view('admin.pages.transactional_reports.transfer_report',$data);
    }
    
	public function transferReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Transfer Staff List';
		$data['form_date'] 	= $request->input('form_date');
		$data['to_date'] 	= $request->input('to_date');
		
		$all_result = DB::table('tbl_transfer as t')
					->leftJoin('tbl_emp_basic_info as e', 't.emp_id', '=', 'e.emp_id')
					->leftJoin('tbl_designation as d', 't.designation_code', '=', 'd.designation_code')
					->leftJoin('tbl_branch as b1', 't.br_code', '=', 'b1.br_code')
					->leftJoin('tbl_grade_new as g', 't.grade_code', '=', 'g.grade_code')
					->where('t.br_joined_date', '>=', $data['form_date'])
					->where('t.br_joined_date', '<=', $data['to_date'])
					->orderBy('t.emp_id', 'ASC')
					->orderBy('t.br_joined_date', 'DESC')
					->select('t.emp_id','e.emp_name_eng','e.org_join_date','e.permanent_add','d.designation_name','b1.branch_name','g.grade_name','t.designation_code','t.letter_date','t.br_joined_date','t.comments')
					->get();
		if (!empty($all_result)) {
			foreach ($all_result as $result) {
				$pre_branch = DB::table('tbl_transfer')
					->where('emp_id', '=', $result->emp_id)
					->where('br_joined_date', '<', $result->br_joined_date)
					->select('emp_id', DB::raw('max(br_joined_date) as old_br_join_date'))
					->groupBy('emp_id')
					->first();
					//$old_br_join_date = $pre_branch->old_br_join_date;
				//print_r ($pre_branch);
				if (!empty($pre_branch)) {
					$old_br_join_date = $pre_branch->old_br_join_date;
				} else {
					$old_br_join_date = $result->org_join_date;
				}
				$data['all_result'][] = array(
					'emp_id' => $result->emp_id,
					'emp_name_eng'      => $result->emp_name_eng,
					'letter_date'      => date('d M Y',strtotime($result->letter_date)),
					'br_join_date'      => date('d M Y',strtotime($result->br_joined_date)),
					'designation_name'      => $result->designation_name,
					'branch_name'      => $result->branch_name,
					//'pre_br_name'      => $result->pre_br_name,
					'comments'      => $result->comments,
					'old_br_join_date'      => $old_br_join_date
				);
			}
		}
		//print_r ($data['all_result']); exit;
		return view('admin.pages.transactional_reports.transfer_report',$data);
		
	}
	
	public function otherIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'Other Staff List';
		$data['form_date']	= '';	
		$data['to_date']	= '';
				
		return view('admin.pages.transactional_reports.other_report',$data);
    }
	
	public function otherReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Other Staff List';
		$data['form_date'] 	= $request->input('form_date');
		$data['to_date'] 	= $request->input('to_date');
		
		$data['all_result'] = DB::table('tbl_others as ot')
							->leftJoin('tbl_emp_basic_info as e', 'ot.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'ot.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'ot.br_code', '=', 'b.br_code')
							->where('ot.letter_date', '>=', $data['form_date'])
							->where('ot.letter_date', '<=', $data['to_date'])
							->select('ot.emp_id','e.emp_name_eng','e.org_join_date','d.designation_name','b.branch_name','ot.letter_date','ot.increment_review')
							->get();

		//print_r ($data['all_result']);
		return view('admin.pages.transactional_reports.other_report',$data);
		
	}
	
	public function resignationIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'Resignation Staff List';
		$data['form_date']	= '';	
		$data['to_date']	= '';
		$data['order_by']	= '';
		$data['resigned_by'] = '';
				
		return view('admin.pages.transactional_reports.resignation_report',$data);
    }
	
    
	public function resignationReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Resignation Staff List';
		$data['form_date'] 	= $request->input('form_date');
		$data['to_date'] 	= $request->input('to_date');
		$data['order_by'] 	= $request->input('order_by');
		$data['resigned_by'] = $resigned_by = $request->input('resigned_by');
		
		$all_result = DB::table('tbl_resignation as r')
							->leftJoin('tbl_emp_basic_info as e', 'r.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'r.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'r.br_code', '=', 'b.br_code')
							->leftJoin('tbl_district as dt', 'e.district_code', '=', 'dt.district_code')
							->leftJoin('tbl_thana as t', 'e.thana_code', '=', 't.thana_code')
							->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
							->where('r.effect_date', '>=', $data['form_date'])
							->where('r.effect_date', '<=', $data['to_date'])
							->where(function($query) use ($resigned_by) {
									if($resigned_by != 'All') {
										$query->where('r.resignation_by', $resigned_by);
									}
								})
							->orderBy('r.emp_id', 'ASC')
							->select('r.emp_id','e.emp_name_eng','e.org_join_date','d.designation_name','b.branch_name','a.area_name','dt.district_name','t.thana_name','r.designation_code','r.effect_date','r.resignation_by')
							->get(); 
		//print_r ($all_result);
		if (!empty($all_result)) {
			foreach ($all_result as $result) {
				$max_sarok = DB::table('tbl_master_tra')
					->where('emp_id', '=', $result->emp_id)
					->where('grade_effect_date', '<=', $data['to_date'])
					->select('emp_id', DB::raw('max(sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
				if (!empty($max_sarok)) {
				$grade = DB::table('tbl_master_tra as m')
					->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
					->where('m.sarok_no', '=', $max_sarok->sarok_no)
					->select('g.grade_name')
					->first();
					//print_r ($grade);
					$gr_name = $grade->grade_name;
				} else {
					$gr_name = '';
				}
				/* File Status Information */
				$file_status = DB::table('tbl_fp_file_info as fp')
										->where('fp.fp_emp_id',$result->emp_id)
										->where('fp.emp_type', '=', 1)
										->count();
										
				$fp_status = DB::table('tbl_edms_document')
										->where('emp_id',$result->emp_id)
										->where('category_id', '=', 21)
										->where('subcat_id', '=', 69)
										->count();
				//print_r($fp_status);	

			//$org_join_date 		= $result->org_join_date;
			//$resign_effect_date = $result->effect_date;
				$date1=date_create($result->org_join_date);
				$date2=date_create($result->effect_date);
				$diff=date_diff($date1,$date2);
				$days =  $diff->format("%a");
				if($days <180)
				{
					$staff_status = 'Probation';
				}else{
					$staff_status = 'Permanent';
				}
				
				$data['all_result'][] = array(
						'emp_id' => $result->emp_id,
						'emp_name_eng'      => $result->emp_name_eng,
						'grade_name'      		=> $gr_name,
						'designation_code'      => $result->designation_code,
						'org_join_date'      => $result->org_join_date,
						'effect_date'      => $result->effect_date,
						'terminate_by'      => $result->resignation_by,
						'designation_name'      => $result->designation_name,
						'branch_name'      => $result->branch_name,
						'district_name'      => $result->district_name,
						'thana_name'      => $result->thana_name,
						'area_name'      => $result->area_name,
						'file_status'      => $file_status,
						'days'      		=> $days,
						'staff_status'      => $staff_status,
						'fp_status'      => $fp_status
					);
			}
		}
		$data['all_designation'] = DB::table('tbl_designation')->get();
		//print_r ($data['all_result']);
		return view('admin.pages.transactional_reports.resignation_report',$data);
		
	}
	
	public function heldupIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Heldup Staff List';
		$data['form_date']	= date('Y-m-d');
				
		return view('admin.pages.transactional_reports.heldup_report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function heldupReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Heldup Staff List';
		$data['form_date'] = $form_date = $request->input('form_date');
		
		$heldup_list = DB::table('tbl_heldup as h')
						->leftJoin('tbl_resignation as r', 'h.emp_id', '=', 'r.emp_id')
						->Where('h.letter_date', '<=', $form_date)
						->whereNull('r.emp_id')
						->orWhere('r.effect_date', '>', $form_date)
						->select('h.emp_id','h.what_heldup', DB::raw('max(h.letter_date) as letter_date'))
						->groupBy('h.emp_id','h.what_heldup')
						->orderBy('h.what_heldup', 'DESC')
						->get();
		//print_r ($heldup_list); exit;
		
		if (!empty($heldup_list)) {
			foreach ($heldup_list as $heldup) {
				if ($heldup->what_heldup =='Permanent') {
					$tran_type_no = 2;
				}
				if ($heldup->what_heldup =='Increment') {
					$tran_type_no = 3;
				}
				if ($heldup->what_heldup =='Promotion') {
					$tran_type_no = 4;
				}
			
				$heldup_post = DB::table('tbl_master_tra')
						->Where('emp_id', $heldup->emp_id)
						->Where('tran_type_no', $tran_type_no)
						->whereBetween('letter_date',array($heldup->letter_date,$form_date))
						->select('emp_id')
						->first();
				//print_r($heldup_post); //exit;
				if(empty($heldup_post)) {
					//echo $heldup->emp_id.'//'.$heldup->letter_date;
					$heldup_pre = DB::table('tbl_heldup as h')
								->leftJoin('tbl_emp_basic_info as e', 'h.emp_id', '=', 'e.emp_id')
								->leftJoin('tbl_designation as d', 'h.designation_code', '=', 'd.designation_code')
								->leftJoin('tbl_branch as b', 'h.br_code', '=', 'b.br_code')
								->where('h.emp_id', $heldup->emp_id)
								->Where('h.letter_date', '=', $heldup->letter_date)
								->select('h.emp_id','h.letter_date','h.what_heldup','h.heldup_cause','h.heldup_time','h.heldup_until_date','e.emp_name_eng','e.org_join_date','d.designation_name','b.branch_name')
								->first();
					//print_r($heldup_pre); //exit;	
						$emp_id = $heldup->emp_id;
						$max_sarok = DB::table('tbl_master_tra as m')
								->where('m.emp_id', '=', $heldup->emp_id)
								->where('m.br_join_date', '=', function($query) use ($emp_id,$form_date)
										{
											$query->select(DB::raw('max(br_join_date)'))
												  ->from('tbl_master_tra')
												  ->where('emp_id',$emp_id)
												  ->where('br_join_date', '<=', $form_date);
										})
								->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
								->groupBy('emp_id')
								->first();
								
						$data_result = DB::table('tbl_master_tra as m')
									->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->select('m.emp_id','m.grade_code','m.basic_salary','m.br_join_date','g.grade_name')
									->first();
					
						$data['all_result'][] = array(
							'emp_id' => $heldup_pre->emp_id,
							'emp_name_eng'      => $heldup_pre->emp_name_eng,
							'org_join_date'      => date('d M Y',strtotime($heldup_pre->org_join_date)),
							'letter_date'      => date('d M Y',strtotime($heldup_pre->letter_date)),
							'what_heldup'      => $heldup_pre->what_heldup,
							'heldup_cause'      => $heldup_pre->heldup_cause,
							'heldup_time'      => $heldup_pre->heldup_time,
							'heldup_until_date'      => $heldup_pre->heldup_until_date,
							'basic_salary'      => $data_result->basic_salary,
							'grade_code'      => $data_result->grade_code,
							'grade_name'      => $data_result->grade_name,
							'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
							'designation_name'      => $heldup_pre->designation_name,
							'branch_name'      => $heldup_pre->branch_name
						);
					
				}
			}
		}
		
		//print_r ($data['all_result']); //exit;
		return view('admin.pages.transactional_reports.heldup_report',$data);
    }
	
	public function NextIncrementIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'Next Increment Staff';	
		$data['increment_date']	= '2021-07-01';
				
		return view('admin.pages.transactional_reports.next_increment_report',$data);
    }
	
    
	public function NextIncrementReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Next Increment Staff';
		$data['increment_date'] = $increment_date = $request->input('to_date');
		
		$all_result_increment = DB::table('tbl_heldup as h')
							->leftJoin('tbl_resignation as r', 'h.emp_id', '=', 'r.emp_id')
							->where('h.what_heldup', '=', 'Increment')
							->where('h.next_increment_date', '=', $increment_date)
							->where(function($query) use ($increment_date) {
								$query->whereNull('r.emp_id');
								$query->orWhere('r.effect_date', '>', '2021-07-31');
								
							})
							->select('h.emp_id','h.next_increment_date')
							->get()->toArray();				
		//print_r($all_result_increment);exit;
		$all_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
							->leftJoin('tbl_heldup as h', function($join) use ($increment_date) {
												$join->where('h.what_heldup', '=', 'Increment')
													//->whereNotNull('h.next_increment_date')
													->where('h.next_increment_date', '!=', $increment_date)
													->on('m.emp_id', '=', 'h.emp_id');
											})
							->where('m.next_increment_date', '=', $increment_date)
							->where('m.tran_type_no', '!=', 1)
							->where(function($query) use ($increment_date) {
								$query->whereNull('r.emp_id');
								$query->orWhere('r.effect_date', '>', '2021-07-31');
								
							})
							->where(function($query) {
								$query->whereNull('h.emp_id');
							})
							//->select('m.emp_id','e.emp_name_eng','e.org_join_date','d.designation_name','g.grade_name','b.branch_name','m.basic_salary','m.total_pay','m.net_pay','m.designation_code','m.letter_date','m.effect_date','m.br_join_date','m.next_increment_date')
							->select('m.emp_id','m.next_increment_date')
							->groupBy('m.next_increment_date')
							->groupBy('m.emp_id')
							->orderBy(DB::raw('MIN(m.grade_code)', 'ASC'))
							->orderBy(DB::raw('MAX(m.basic_salary)', 'DESC'))
							->orderBy('m.emp_id', 'ASC')
							->get()->toArray();
		
		$all_result1 = array_unique(array_merge($all_result,$all_result_increment), SORT_REGULAR);
		//print_r ($all_result1);exit;
		if (!empty($all_result1)) {
			foreach ($all_result1 as $result) {
				$emp_id = $result->emp_id;
				$increment_date = $result->next_increment_date;
				$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $emp_id)
						->where('m.br_join_date', '=', function($query) use ($emp_id,$increment_date)
							{
								$query->select(DB::raw('max(br_join_date)'))
									  ->from('tbl_master_tra')
									  ->where('emp_id',$emp_id)
									  ->where('br_join_date', '<=', $increment_date);
							})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('emp_id')
						->first();
				//print_r ($max_sarok);
				$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						//->where('m.emp_id', '=', $max_sarok->emp_id)
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->select('e.emp_name_eng','e.org_join_date','m.emp_id','m.designation_code','m.grade_code','m.grade_step','m.grade_effect_date','g.grade_name','m.basic_salary','m.letter_date','m.br_join_date','m.effect_date','d.designation_name','b.branch_name')
						->first();
				//print_r($data_result);
				/* $max_sarok_grade = DB::table('tbl_master_tra as mas')
					->where('mas.emp_id', '=', $result->emp_id)
					->where('mas.letter_date', '=', function($query) use ($emp_id,$increment_date)
						{
							$query->select(DB::raw('max(letter_date)'))
								  ->from('tbl_master_tra')
								  ->where('emp_id',$emp_id)
								  ->where('grade_effect_date', '<=', $increment_date);
						})
					->select('mas.emp_id',DB::raw('max(mas.sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
					
				$data_result_grade = DB::table('tbl_master_tra as mat')
						->leftJoin('tbl_grade_new as g', 'mat.grade_code', '=', 'g.grade_code')
						->where('mat.sarok_no', '=', $max_sarok_grade->sarok_no)
						->select('mat.emp_id','mat.grade_code','mat.grade_step','mat.grade_effect_date','g.grade_name')
						->first(); */
					
				$max_sarok_sa = DB::table('tbl_emp_salary as sa')
								->where('sa.emp_id', '=', $result->emp_id)
								->where('sa.effect_date', '<=', $increment_date)
								->where('sa.sarok_no', '=', function($query) use ($emp_id,$increment_date)
									{
										$query->select(DB::raw('max(sarok_no)'))
											  ->from('tbl_emp_salary')
											  ->where('emp_id',$emp_id)
											  ->where('effect_date', '<=', $increment_date);
									})
								->select('sa.emp_id',DB::raw('max(sa.id) as id_no'))
								->groupBy('emp_id')
								->first();

				if(!empty($max_sarok_sa)) {
				$salary = DB::table('tbl_emp_salary')
							->where('emp_id', '=', $max_sarok_sa->emp_id)
							->where('id', '=', $max_sarok_sa->id_no)
							//->where('salary_basic', '=', $data_result->basic_salary)
							//->where('net_pay', '>', 0)
							->select('emp_id','salary_basic','total_plus','payable','net_payable','gross_total','effect_date')
							->first();
				}			
				//print_r ($max_sarok_sa);//exit;
				if(!empty($salary)) {
					$bs_salary = $salary->salary_basic;
					$total_salary = $salary->payable;
					$net_salary = $salary->net_payable;
					$total_plus = $salary->total_plus;
					$effect_date = $salary->effect_date;
				}
				
				$get_marked = DB::table('tbl_mark_assign')
					->where('emp_id', '=', $data_result->emp_id)
					->where('open_date', '<=', $increment_date)
					//->where('close_date', '=', '0000-00-00')
					//->orWhereNull('close_date')
					//->whereBetween('close_date',array('0000-00-00', 'IS NULL'))
					->where('status', 0)
					->select('marked_for')
					->get();
				$increment_mark ='';
				$promotion_increment_mark ='';
				if(!empty($get_marked)) {
					foreach ($get_marked as $marked) {
						if ($marked->marked_for =='Increment') {
							$increment_mark = $marked->marked_for;
						}
						if ($marked->marked_for =='Promotion') {
							$promotion_mark = $marked->marked_for;
						}
						if ($marked->marked_for =='Permanent') {
							$permanent_mark = $marked->marked_for;
						}
						if ($marked->marked_for =='Promotion_Increment') {
							$promotion_increment_mark = $marked->marked_for;
						}
					}
				}
				$data['all_result'][] = array(
					'emp_id' => $data_result->emp_id,
					'emp_name_eng'      => $data_result->emp_name_eng,
					'next_increment_date'      => date('d M Y',strtotime($result->next_increment_date)),
					'basic_salary'      => $bs_salary,
					'total_pay'      => $total_salary,
					'net_pay'      => $net_salary,
					'total_plus'      => $total_plus,
					'next_designation_code'      => $data_result->designation_code,
					'grade_code'      => $data_result->grade_code,
					'grade_name'      => $data_result->grade_name,
					'grade_step'      => $data_result->grade_step,
					'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
					'letter_date'      => date('d M Y',strtotime($data_result->letter_date)),
					'effect_date'      => date('d M Y',strtotime($effect_date)),
					'designation_name'      => $data_result->designation_name,
					'branch_name'      => $data_result->branch_name,
					'increment_marked'    => $increment_mark,
					'promotion_increment_marked'    => $promotion_increment_mark
				);
				//$data['all_result'] = $data['all_result']->sortBy('grade_code');
				//print_r($data['all_result']);		
			}
		}
		return view('admin.pages.transactional_reports.next_increment_report',$data);
		
	}
	
	public function PunishmentIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'Punishment Report';	
		$data['form_date'] 	= '';
		$data['to_date'] 	= '';
				
		return view('admin.pages.transactional_reports.punishment_report',$data);
    }
	
	public function punishmentReport(Request $request)
	{
		//echo $category_id.'-'.$date_from.'-'.$date_to;
		$data = array();
		$data['Heading'] = $data['title'] = 'Punishment Report';
		$data['form_date'] = $form_date	= $request->input('form_date');
		$data['to_date'] = $to_date	= $request->input('to_date');
		
		$all_result = DB::table('tbl_punishment')
						->Where('letter_date', '>=', $form_date)
						->Where('letter_date', '<=', $to_date)
						->Where('status', '=', 1)
						->select('emp_id')
						->groupBy('emp_id')
						->get();
		//print_r($all_result);
		foreach ($all_result as $result) {
			$emp_id = $result->emp_id;				
			$max_sarok = DB::table('tbl_master_tra as m')
				->where('m.emp_id', '=', $result->emp_id)
				->where('m.br_join_date', '=', function($query) use ($emp_id,$to_date)
						{
							$query->select(DB::raw('max(br_join_date)'))
								  ->from('tbl_master_tra')
								  ->where('emp_id',$emp_id)
								  ->where('br_join_date', '<=', $to_date);
						})
				->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
				->groupBy('emp_id')
				->first();
			//print_r ($max_sarok);
			$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
						->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->select('e.emp_name_eng', DB::raw("(SELECT COUNT(id) FROM tbl_punishment
                                WHERE emp_id = $result->emp_id AND punishment_type = '1' AND status = 1
								AND letter_date > '$form_date' AND letter_date < '$to_date') as total_warning"),DB::raw("(SELECT COUNT(id) FROM tbl_punishment
                                WHERE emp_id = $result->emp_id AND punishment_type = '2' AND status = 1
								AND letter_date > '$form_date' AND letter_date < '$to_date') as total_fine"),DB::raw("(SELECT COUNT(id) FROM tbl_punishment
                                WHERE emp_id = $result->emp_id AND punishment_type = '4' AND status = 1
								AND letter_date > '$form_date' AND letter_date < '$to_date') as total_censure"),DB::raw("(SELECT COUNT(id) FROM tbl_punishment
                                WHERE emp_id = $result->emp_id AND punishment_type = '5' AND status = 1
								AND letter_date > '$form_date' AND letter_date < '$to_date') as total_explanation"),DB::raw("(SELECT COUNT(id) FROM tbl_punishment
                                WHERE emp_id = $result->emp_id AND punishment_type = '3' AND status = 1
								AND letter_date > '$form_date' AND letter_date < '$to_date') as total_strong_warning"),DB::raw("(SELECT SUM(fine_amount) FROM tbl_punishment
                                WHERE emp_id = $result->emp_id AND status = 1
								AND letter_date > '$form_date' AND letter_date < '$to_date' AND status = 1) as total_fine_amount"),'m.emp_id','d.designation_name','g.grade_name','b.branch_name','a.area_name','r.effect_date')
						->first();
			
			$data['all_result'][] = array(
					'emp_id' => $data_result->emp_id,
					'emp_name_eng'      => $data_result->emp_name_eng,
					'designation_name'      => $data_result->designation_name,
					'grade_name'      => $data_result->grade_name,
					'branch_name'      => $data_result->branch_name,
					'area_name'      => $data_result->area_name,
					'total_warning'      => $data_result->total_warning,
					'total_fine'      => $data_result->total_fine,
					'total_censure'      => $data_result->total_censure,
					'total_explanation'      => $data_result->total_explanation,
					'total_strong_warning'      => $data_result->total_strong_warning,
					'total_fine_amount'      => $data_result->total_fine_amount,
					're_effect_date'      => $data_result->effect_date
				);
		}
		//print_r($data['all_result']);	
		return view('admin.pages.transactional_reports.punishment_report',$data);
	
	}
	
	public function DemotionIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'Demotion Staff List';
		$data['form_date']	= date('Y-m-d');
				
		return view('admin.pages.transactional_reports.demotion_report',$data);
    }
	
    
	public function DemotionReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Demotion Staff List';
		$data['form_date'] 	= $request->input('form_date');
		$data['to_date'] 	= $request->input('to_date');
		
		$data['all_result'] = DB::table('tbl_demotion as d')
							->leftJoin('tbl_emp_basic_info as e', 'd.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as de', 'd.designation_code', '=', 'de.designation_code')
							->leftJoin('tbl_branch as b', 'd.br_code', '=', 'b.br_code')
							->leftJoin('tbl_grade_new as g', 'd.grade_code', '=', 'g.grade_code')
							->leftJoin('tbl_emp_salary as es', function($join)
								{
									$join->on('d.emp_id', '=', 'es.emp_id')
									->on('d.sarok_no', '=', 'es.sarok_no');

								})
							->where('d.effect_date', '<=', $data['form_date'])
							->select('d.emp_id','e.emp_name_eng','e.org_join_date','e.permanent_add','de.designation_name','b.branch_name','g.grade_name','es.salary_basic','es.payable','es.net_payable','d.designation_code','d.letter_date','d.effect_date','d.br_joined_date','d.next_increment_date','d.demotion_type')
							->get();

		//print_r ($data['all_result']);
		return view('admin.pages.transactional_reports.demotion_report',$data);
		
	}
	
	public function GradeDetailsReport($emp_id)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Grade Details History';
		$data['form_date']	= $form_date = date('Y-m-d');
		$data['emp_id']  = $emp_id;
		
		$max_sarok = DB::table('tbl_master_tra')
				->where('emp_id', '=', $emp_id)
				->select('emp_id', DB::raw('max(sarok_no) as sarok_no'))
                ->groupBy('emp_id')
                ->first();
		if(!empty($max_sarok)) {
		$data['emp_data'] = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
							->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_appointment_info as a', 'm.emp_id', '=', 'a.emp_id')
							->leftJoin('tbl_branch as b', 'a.joining_branch', '=', 'b.br_code')
							->where('m.sarok_no', '=', $max_sarok->sarok_no)
							->select('e.emp_id','e.emp_name_eng','e.org_join_date','a.joining_date','b.branch_name','d.designation_name','r.effect_date as re_effect_date','r.resignation_by')
							->first();
		
		//print_r ($data['emp_data']);
		$data['emp_history_grade'] = DB::table('tbl_master_tra as mt')
					->leftJoin('tbl_grade_new as g', 'mt.grade_code', '=', 'g.grade_code') 
					->where('mt.emp_id',$emp_id)
					->groupby('mt.grade_code','mt.grade_effect_date')
					->orderby('mt.letter_date','desc')  
					->select(DB::raw('min(mt.letter_date) as letter_date'),'mt.grade_code',DB::raw('max(g.grade_name) as grade_name'),DB::raw('min(mt.grade_effect_date) as grade_effect_date'),DB::raw('min(mt.br_join_date) as br_join_date'))
					->get();
		//print_r ($data['emp_history_grade']);
		/* $data['results'] = DB::table('tbl_transfer as tr')
						->leftjoin('tbl_branch as br', 'tr.br_code', '=', 'br.br_code')
						->leftJoin('tbl_area as a', 'br.area_code', '=', 'a.area_code')
						->select('tr.id','tr.br_joined_date','br.branch_name','a.area_name')
						->where('tr.emp_id',$emp_id) 
						->where('tr.br_joined_date', '<=', $form_date)
						->orderBy('tr.br_joined_date', 'desc')
						->get(); */
		
		//print_r ($data['results']);
		}
		return view('admin.pages.transactional_reports.grade_details_report',$data);
		
	}
	
	public function SalaryReviewIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'Salary review report for SACMO';
		$data['form_date']	= date('Y-m-d');
				
		return view('admin.pages.transactional_reports.sacmo_salary_review_report',$data);
    }
	
    
	public function SalaryReviewReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Salary review report for SACMO';
		$data['form_date'] = $form_date   = $request->input('form_date');
		
		$data['all_nonid_emp'] = DB::table('tbl_emp_non_id as en')
							->leftjoin('tbl_nonid_official_info as noi',function($join) use($form_date) {
								$join->on("en.emp_id","=","noi.emp_id") 
										->where('noi.sarok_no',DB::raw("(SELECT 
																				  max(tbl_nonid_official_info.sarok_no)
																				  FROM tbl_nonid_official_info 
																				  where en.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
																				  max(t.joining_date)
																				  FROM tbl_nonid_official_info as t 
																				   where en.emp_id = t.emp_id AND t.joining_date <= '$form_date')
																				  )") 		 
															); 		
										})
								->leftjoin('tbl_nonid_salary as nos',function($join){
								$join->on("en.emp_id","=","nos.emp_id")
									->where('nos.effect_date',DB::raw("(SELECT 
																  max(effect_date)
																  FROM tbl_nonid_salary 
																   where en.emp_id = emp_id
																  )") 		 
											); 
										})
							->leftJoin('tbl_designation as d', 'noi.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'noi.br_code', '=', 'b.br_code')
							->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
							->leftJoin('tbl_emp_non_id_cancel as nc', 'en.emp_id', '=', 'nc.emp_id')
							->where(function($query) use ($form_date) {
									$query->where('en.joining_date', '<=', $form_date);
									$query->whereNull('nc.emp_id');
									$query->orWhere('nc.cancel_date', '>', $form_date);
								
							})
							->where('en.emp_type_code', 3)
							->where('noi.designation_code', 173)
							->orderBy('en.sacmo_id', 'ASC')
							->select('en.emp_id','en.emp_name','en.sacmo_id','en.last_education','en.joining_date','noi.next_renew_date','noi.br_join_date','nos.gross_salary','nos.effect_date','d.designation_name','b.branch_name','a.area_name')
							->get();

		//print_r ($data['all_nonid_emp']);
		return view('admin.pages.transactional_reports.sacmo_salary_review_report',$data);
		
	}
	
	public function ContractualIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'Contractual Staff List';
		$data['form_date']		= '';	
		$data['to_date']		= '';
				
		return view('admin.pages.transactional_reports.contractual_report',$data);
    }
	
    
	public function ContractualReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Contractual Staff List';
		$data['form_date'] 		= $request->input('form_date');
		$data['to_date'] 		= $request->input('to_date');
		
		$all_result = DB::table('tbl_probation as p')
							->leftJoin('tbl_emp_basic_info as e', 'p.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'p.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'p.br_code', '=', 'b.br_code')
							->where('p.effect_date', '>=', $data['form_date'])
							->where('p.effect_date', '<=', $data['to_date'])
							->where('e.emp_group', '!=', 1)
							->select('p.emp_id','e.emp_name_eng','e.org_join_date','e.permanent_add','d.designation_name','b.branch_name','p.designation_code','p.letter_date','p.probation_time','p.br_joined_date')
							->get(); 
		//print_r ($all_result);
		if (!empty($all_result)) {
			foreach ($all_result as $result) {
				$max_exam = DB::table('tbl_emp_edu_info')
					->where('emp_id', '=', $result->emp_id)
					->select('emp_id', DB::raw('max(level_id) as level_id'))
					->groupBy('emp_id')
					->first();
				if (!empty($max_exam)) {
				$exam_result = DB::table('tbl_emp_edu_info as ed')
					->leftJoin('tbl_exam_name as en', 'ed.exam_code', '=', 'en.exam_code')
					->where('ed.emp_id', '=', $max_exam->emp_id)
					->where('ed.level_id', '=', $max_exam->level_id)
					->select('en.exam_name')
					->first();
					//print_r ($exam_result);
					$exam_name = $exam_result->exam_name;
				} else {
					$exam_name = '';
				}
				$data['all_result'][] = array(
						'emp_id' => $result->emp_id,
						'emp_name_eng'      => $result->emp_name_eng,
						'permanent_add'      => $result->permanent_add,
						'exam_name'      => $exam_name,
						'designation_code'      => $result->designation_code,
						'org_join_date'      => $result->org_join_date,
						'br_join_date'      => $result->br_joined_date,
						'letter_date'      => $result->letter_date,
						'probation_time'      => $result->probation_time,
						'designation_name'      => $result->designation_name,
						'branch_name'      => $result->branch_name
					);
			}
		}
		$data['all_designation'] = DB::table('tbl_designation')->get();
		//print_r ($data['all_result']);
		//return response()->json($data);
		//return response()->json($data['all_designation']);
		return view('admin.pages.transactional_reports.contractual_report',$data);
		//return view('admin.pages.transactional_reports.probation_report', compact('all_result'))->render();
		
	}
	
	
	

}
