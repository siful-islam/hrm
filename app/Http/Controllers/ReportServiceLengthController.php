<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class ReportServiceLengthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
    public function orgServicesIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Org. Service Length';
		$data['form_date']		= date('Y-m-d');
		$data['year_as']		= '';
				
		return view('admin.pages.service_length_reports.org_service_length',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function orgServicesReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Org. Service Length';
		$data['form_date'] 		= $form_date = $request->input('form_date');
		$data['year_as'] 		= $request->input('year_as');
		$data['all_grade'] 		= DB::table('tbl_grade_new')->get();
		
		if(!empty($data['form_date'])) {			
			$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('e.org_join_date', '<=', $form_date)
						->where('m.grade_effect_date', '<=', $form_date)
						->Where(function($query) use ($form_date) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);								
								})
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get();
						
			foreach ($data_result as $result) {
				$emp_id = $result->emp_id;
				$max_sarok = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $result->emp_id)
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
				$all_data = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin(DB::raw("(SELECT emp_id,max(level_id) as level_id
								FROM tbl_emp_edu_info GROUP BY emp_id) as em"),
								'em.emp_id','=','m.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->where('m.emp_id', '=', $max_sarok->emp_id)
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->select('e.emp_id','e.emp_name_eng','e.org_join_date','em.level_id',
						        DB::raw("(SELECT COUNT(tran_type_no) FROM tbl_promotion
                                WHERE emp_id = $max_sarok->emp_id
                                AND effect_date < '$form_date') as total"),'m.basic_salary','m.grade_code','m.is_permanent','m.tran_type_no','d.designation_name','b.branch_name','g.grade_name')
						->first();
				//print_r ($all_data);
				$emp_id = $all_data->emp_id;
				$max_sarok_sa = DB::table('tbl_emp_salary as sa')
								->where('sa.emp_id', '=', $all_data->emp_id)
								->where('sa.effect_date', '<=', $form_date)
								->where('sa.sarok_no', '=', function($query) use ($emp_id,$form_date)
									{
										$query->select(DB::raw('max(sarok_no)'))
											  ->from('tbl_emp_salary')
											  ->where('emp_id',$emp_id)
											  ->where('effect_date', '<=', $form_date);
									})
								->select('sa.emp_id',DB::raw('max(sa.id) as id_no'))
								->groupBy('emp_id')
								->first();
				if(!empty($max_sarok_sa)) {
				$salary = DB::table('tbl_emp_salary')
							->where('emp_id', '=', $max_sarok_sa->emp_id)
							->where('id', '=', $max_sarok_sa->id_no)
							->select('emp_id','salary_basic','total_plus','payable','net_payable','gross_total')
							->first();
				}
				if(!empty($salary)) {
					$bs_salary = $salary->salary_basic;
					$total_salary = $salary->payable;
					$net_salary = $salary->net_payable;
					$total_plus = $salary->total_plus;
				}
				if (!empty($all_data->level_id)) {
				$exam_result = DB::table('tbl_emp_edu_info as ed')
					->leftJoin('tbl_exam_name as en', 'ed.exam_code', '=', 'en.exam_code')
					->where('ed.emp_id', '=', $all_data->emp_id)
					->where('ed.level_id', '=', $all_data->level_id)
					->select('en.exam_name')
					->first();
					//print_r ($exam_result);
					$exam_name = $exam_result->exam_name;
				} else {
					$exam_name = '';
				}
				
				$get_marked = DB::table('tbl_redmark')
						->where('emp_id', '=', $all_data->emp_id)
						->where('open_date', '<=', $form_date)
						->where('close_date', '=', '0000-00-00')
						->where('status', 0)
						->select('redmark_for')
						->get();
				$increment_mark ='';
				$promotion_mark ='';
				$permanent_mark ='';
				if(!empty($get_marked)) {
					foreach ($get_marked as $marked) {
						if ($marked->redmark_for =='Increment') {
							$increment_mark = $marked->redmark_for;
						}
						if ($marked->redmark_for =='Promotion') {
							$promotion_mark = $marked->redmark_for;
						}
						if ($marked->redmark_for =='Permanent') {
							$permanent_mark = $marked->redmark_for;
						}
					}
				}
				
				$data['all_result'][] = array(
					'emp_id' => $all_data->emp_id,
					'emp_name_eng'      => $all_data->emp_name_eng,
					'exam_name'      => $exam_name,
					'org_join_date'      => date('d M Y',strtotime($all_data->org_join_date)),
					'basic_salary'      => $bs_salary,
					'grade_code'      => $all_data->grade_code,
					'grade_name'      => $all_data->grade_name,
					'total'      => $all_data->total,
					'is_permanent'      => $all_data->is_permanent,
					'designation_name'      => $all_data->designation_name,
					'branch_name'      => $all_data->branch_name,
					'tran_type_no'      => $all_data->tran_type_no,
					'increment_marked'    	=> $increment_mark,
					'promotion_marked'    	=> $promotion_mark,
					'permanent_marked'    	=> $permanent_mark
				);
			}
		}
		//print_r ($all_result); //exit;
		return view('admin.pages.service_length_reports.org_service_length',$data);
    }
	
	public function gradeServicesIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Grade-Wise Service Length';
		$data['form_date']		= date('Y-m-d');
		$data['grade_code']		= '';
		$data['order_by']		= '';
		$data['all_grade'] 		= DB::table('tbl_grade_new')->where('status',1)->get();
				
		return view('admin.pages.service_length_reports.grade_service_length',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function gradeServicesReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Grade-Wise Service Length';
		$data['form_date'] 		= $form_date = $request->input('form_date');
		$data['grade_code'] 	= $grade_code = $request->input('grade_code');
		$data['order_by'] 		= $request->input('order_by');
		$data['all_grade'] 		= DB::table('tbl_grade_new')->get();
		
		$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						//->where('m.grade_code', '=', $grade_code)
						->where('e.org_join_date', '<=', $form_date)
						->where('m.grade_effect_date', '<=', $form_date)
						->Where(function($query) use ($form_date) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);								
								})
						->where(function($query) use ($grade_code) {
								if($grade_code !='all') {
									$query->where('m.grade_code', $grade_code);
								}
							})
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get();
		//print_r ($all_result); exit;
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
				$emp_id = $result->emp_id;
				$max_sarok = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $result->emp_id)
					->where('m.letter_date', '=', function($query) use ($emp_id,$form_date)
						{
							$query->select(DB::raw('max(letter_date)'))
								  ->from('tbl_master_tra')
								  ->where('emp_id',$emp_id)
								  ->where('grade_effect_date', '<=', $form_date);
						})
					->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
				//print_r ($max_sarok); //exit;
				$date_from = "2017-01-01";
				$date_to = "2020-12-31";
				$data_result = DB::table('tbl_master_tra as m')
					->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
					->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
					->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
					->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
					->leftJoin('tbl_emp_assign as ea', function($join){
									//$join->where('ea.status', 1)
									$join->whereBetween('ea.status',array(1,2))
										->on('m.emp_id', '=', 'ea.emp_id');
								})
					->where('m.sarok_no', '=', $max_sarok->sarok_no)
					->select('e.emp_name_eng','e.org_join_date',DB::raw("(SELECT COUNT(tran_type_no) FROM tbl_promotion
                                WHERE emp_id = $result->emp_id
                                AND effect_date < '$form_date') as total"),
								DB::raw("(SELECT COUNT(id) FROM tbl_punishment
                                WHERE emp_id = $result->emp_id AND punishment_type = '1' 
								AND letter_date > '$date_from' AND letter_date < '$date_to') as total_warning"),DB::raw("(SELECT COUNT(id) FROM tbl_punishment
                                WHERE emp_id = $result->emp_id AND punishment_type = '2' 
								AND letter_date > '$date_from' AND letter_date < '$date_to') as total_fine"),DB::raw("(SELECT COUNT(id) FROM tbl_punishment
                                WHERE emp_id = $result->emp_id AND punishment_type = '4' 
								AND letter_date > '$date_from' AND letter_date < '$date_to') as total_censure"),DB::raw("(SELECT COUNT(id) FROM tbl_punishment
                                WHERE emp_id = $result->emp_id AND punishment_type = '5' 
								AND letter_date > '$date_from' AND letter_date < '$date_to') as total_explanation"),DB::raw("(SELECT COUNT(id) FROM tbl_punishment
                                WHERE emp_id = $result->emp_id AND punishment_type = '3' 
								AND letter_date > '$date_from' AND letter_date < '$date_to') as total_strong_warning"),DB::raw("(SELECT SUM(fine_amount) FROM tbl_punishment
                                WHERE emp_id = $result->emp_id 
								AND letter_date > '$date_from' AND letter_date < '$date_to') as total_fine_amount"),
								'm.emp_id','m.grade_code','m.basic_salary','m.grade_effect_date','m.is_permanent','m.br_code','m.tran_type_no','g.grade_name','d.designation_name','b.branch_name','ea.open_date','ea.incharge_as')
					->first();
				//print_r($data_result);	
				$max_sarok_sa = DB::table('tbl_emp_salary as sa')
					->where('sa.emp_id', '=', $result->emp_id)
					->where('sa.effect_date', '<=', $form_date)
					->where('sa.sarok_no', '=', function($query) use ($emp_id,$form_date)
						{
							$query->select(DB::raw('max(sarok_no)'))
								  ->from('tbl_emp_salary')
								  ->where('emp_id',$emp_id)
								  ->where('effect_date', '<=', $form_date);
						})
					->select('sa.emp_id',DB::raw('max(sa.id) as id_no'))
					->groupBy('emp_id')
					->first();
				if(!empty($max_sarok_sa)) {
				$salary = DB::table('tbl_emp_salary')
							->where('emp_id', '=', $max_sarok_sa->emp_id)
							->where('id', '=', $max_sarok_sa->id_no)
							->select('emp_id','salary_basic','total_plus','payable','net_payable','gross_total')
							->first();
				}			
				//print_r ($max_sarok_sa);//exit;
				if(!empty($salary)) {
					$bs_salary = $salary->salary_basic;
					$total_salary = $salary->payable;
					$net_salary = $salary->net_payable;
					$total_plus = $salary->total_plus;
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
				//print_r ($data_result);
				$get_marked = DB::table('tbl_mark_assign')
						->where('emp_id', '=', $result->emp_id)
						->where('open_date', '<=', $form_date)
						//->where('close_date', '=', '0000-00-00')
						->where('status', 0)
						->select('marked_for')
						->get();
				$increment_mark ='';
				$promotion_mark ='';
				$permanent_mark ='';
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
					}
				}				
				if ($grade_code == 'all') {
					$data['all_result'][] = array(
						'emp_id' => $data_result->emp_id,
						'emp_name_eng'      => $data_result->emp_name_eng,
						'exam_name'      => $exam_name,
						'org_join_date'      => date('d M Y',strtotime($data_result->org_join_date)),
						'basic_salary'      => $bs_salary,
						'total_salary'      => $total_salary,
						'net_salary'      => $net_salary,
						'grade_code'      => $data_result->grade_code,
						'grade_name'      => $data_result->grade_name,
						'grade_effect_date'      => date('d M Y',strtotime($data_result->grade_effect_date)),
						'total'      => $data_result->total,
						'is_permanent'      => $data_result->is_permanent,
						'designation_name'      => $data_result->designation_name,
						'branch_name'      => $data_result->branch_name,
						'tran_type_no'      => $data_result->tran_type_no,
						'assign_designation'      => $asign_desig,
						'assign_open_date'      => $desig_open_date,
						'increment_marked'    	=> $increment_mark,
						'promotion_marked'    	=> $promotion_mark,
						'permanent_marked'    	=> $permanent_mark,
						'incharge_as'      => $data_result->incharge_as,
						'open_date'      => $data_result->open_date,
					);
				} else {
					if ($data_result->grade_code == $grade_code) {	
						///////////////////
						/* if($data_result->br_code != 9999) {
						$api_url 		= 'http://202.4.106.3/spms/spms_marks/'.$data_result->emp_id;
						$hrm_data		= file_get_contents($api_url);
						$total_result 	= json_decode($hrm_data);
						print_r($total_result);
						} */
						//exit;
						
						//////////////////
						
						$data['all_result'][] = array(
							'emp_id' => $data_result->emp_id,
							'emp_name_eng'      => $data_result->emp_name_eng,
							'exam_name'      => $exam_name,
							'org_join_date'      => date('d M Y',strtotime($data_result->org_join_date)),
							'basic_salary'      => $bs_salary,
							'total_salary'      => $total_salary,
							'net_salary'      => $net_salary,
							'grade_code'      => $data_result->grade_code,
							'grade_name'      => $data_result->grade_name,
							'grade_effect_date'      => date('d M Y',strtotime($data_result->grade_effect_date)),
							'total'      => $data_result->total,
							'is_permanent'      => $data_result->is_permanent,
							'designation_name'      => $data_result->designation_name,
							'branch_name'      => $data_result->branch_name,
							'tran_type_no'      => $data_result->tran_type_no,
							'assign_designation'      => $asign_desig,
							'assign_open_date'      => $desig_open_date,
							'increment_marked'    	=> $increment_mark,
							'promotion_marked'    	=> $promotion_mark,
							'permanent_marked'    	=> $permanent_mark,
							'incharge_as'      => $data_result->incharge_as,
							'open_date'      => $data_result->open_date,
							'total_warning'      => $data_result->total_warning,
							'total_censure'      => $data_result->total_censure,
							'total_strong_warning'      => $data_result->total_strong_warning,
							'total_fine'      => $data_result->total_fine,
							'total_explanation'      => $data_result->total_explanation,
							'total_fine_amount'      => $data_result->total_fine_amount
						);
					}
				}
			}
		}
		
		//print_r ($all_result); //exit;
		return view('admin.pages.service_length_reports.grade_service_length',$data);
    }
	
	public function StaffInfoGlanceIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Staff Strength-Org. Report';
		$data['emp_group']	= '';
		$data['desig_group_code']	= '';
		$data['date_within']		= date('Y-m-d');
		$data['designation_group'] 	= array();
		$data['all_emp_group'] 		= DB::table('tbl_emp_group')->get();
		
		return view('admin.pages.service_length_reports.staff_info_glance_report',$data);
    }
	
	public function EmpTypeDesignationGroup($emp_group)
    {  
		$all_designation_group = DB::table('tbl_designation_group')
					  /* ->where(function($query) use ($emp_group) {
									if($emp_group == 1) {
										$query->where('emp_group',$emp_group);
									} else if ($emp_group == 2) {
										$query->where('emp_group', '!=', 1);
									}	
								}) */
                      ->where('emp_group',$emp_group)
                      ->where('status',1)
					  ->orderBy('desig_group_code', 'ASC')
					  ->get();
		//print_r($all_designation_group);
		echo "<option value=''>--Select--</option>";
		echo "<option value='all'>All</option>";
		foreach($all_designation_group as $designation_group){
			echo "<option value='$designation_group->desig_group_code'>$designation_group->desig_group_name</option>";
		}
    }
	
	public function StaffInfoGlanceReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Staff Strength-Org. Report';
		$data['emp_group'] 	= $emp_group = $request->input('emp_group');
		$data['desig_group_code'] 	= $desig_group_code = $request->input('desig_group_code');
		$data['date_within'] = $date_within = $request->input('date_within');
		$data['all_emp_group'] 		= DB::table('tbl_emp_group')->get();
		
		//$data['designation_group'] 	= DB::table('tbl_designation_group')->where('status',1)->get();
		if(!empty($desig_group_code)) {
			$data['designation_group'] = DB::table('tbl_designation_group')
					  ->where('emp_group',$emp_group)
                      ->where('status',1)
                      ->orderBy('desig_group_code', 'ASC')
					  ->get();
		}
		$data['all_designation'] = $all_designation_code 		= DB::table('tbl_designation')->get();
		
		$all_designation_code = DB::table('tbl_designation')
						->where(function($query) use ($desig_group_code, $emp_group ) {
								if($desig_group_code !='all') {
									if($emp_group != 1) {
										$query->where('contractual_designation_group', $desig_group_code);
									} else {
										$query->where('designation_group_code', $desig_group_code);
									}
								} else {
									$query->where('status',1);
								}
							})
						->select('designation_code','designation_group_code')
						->get();
		//print_r ($all_designation_code); exit;				
		if(!empty($all_designation_code)) {
			
				$all_result = DB::table('tbl_emp_basic_info as e')
						->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
						->where('e.emp_group', '=', $emp_group)
						->where('e.org_join_date', '<=', $date_within)
						->where(function($query) use ($date_within) {								
								$query->whereNull('r.emp_id');
								$query->orWhere('r.effect_date', '>', $date_within);								
							})
						->orderBy('e.emp_id', 'ASC')
						->select('e.emp_id')
						->get();
				foreach ($all_result as $result) {
					$emp_id = $result->emp_id;
					$max_sarok = DB::table('tbl_master_tra as m')
									->where('m.emp_id', '=', $result->emp_id)
									->where('m.br_join_date', '=', function($query) use ($emp_id,$date_within)
											{
												$query->select(DB::raw('max(br_join_date)'))
													  ->from('tbl_master_tra')
													  ->where('emp_id',$emp_id)
													  ->where('br_join_date', '<=', $date_within);
											})
									->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no')) 
									->groupBy('m.emp_id')
									->first();
					
					
					
					/* if(empty($max_sarok))
					{
						$abc[] = $emp_id;
								
					}  */
					if(!empty($max_sarok)) {
					$data_result = DB::table('tbl_master_tra')
							->where('emp_id', '=', $max_sarok->emp_id)
							->where('sarok_no', '=', $max_sarok->sarok_no)
							->select('designation_code')
							->first();
					foreach ($all_designation_code as $all_des_code) {
						if ($data_result->designation_code == $all_des_code->designation_code) {
							$data['designation_count'][] = array($data_result->designation_code);
						}						
					}
					}
				}
				/* echo '<pre/>';
				print_r($abc); */
				
				//print_r ($max_sarok);
				/* Total Strength */
				if (!empty($data['designation_count'])) {
				$data['designation_group_total'] = array_count_values(array_column($data['designation_count'], 0));
				}
				
				foreach($data['designation_group_total'] as $key => $value) {
					if($emp_group != 1) {
						$designation_groupcode = DB::table('tbl_designation')
							->where('designation_code', '=', $key)
							->select('designation_name','contractual_designation_group as designation_group_code')
							->first();
					} else {
						$designation_groupcode = DB::table('tbl_designation')
							->where('designation_code', '=', $key)
							->select('designation_name','designation_group_code as designation_group_code')
							->first();
					}
					$data['all_result'][] = array(
								'designation_name'      => $designation_groupcode->designation_name,
								'designationgroup_code'      => $designation_groupcode->designation_group_code,
								'designation_code'      => $key,
								'designation_value'      => $value
						);
				}
			
			
		}
		//print_r ($data['all_result']); 				
		//exit;
		
		return view('admin.pages.service_length_reports.staff_info_glance_report',$data);
    }
	
	public function pomis_getno_branch($date_within)
    {
		$year = date("Y",strtotime($date_within));
		$month = date("m",strtotime($date_within));
		$entry_branch = DB::table('tbl_br_fo_register as r')
						 ->Where(function($query) use ($year ,$month ) {
								$query->whereYear('r.month', '=', $year)
									   ->whereMonth('r.month', '=', $month);
							})
						->groupBy('r.br_code')
						->select('r.br_code')
						->get();
		
		/* echo "<pre>";
		print_r($entry_branch);
		exit; */
		
		$array = json_decode(json_encode($entry_branch), true);
		$array1 = array_column($array, 'br_code');
		
		$no_enrty_branch = DB::table('tbl_branch as b')
						->whereNotIn('b.br_code', $array1)
						->where('b.br_code', '!=', 9999)
						->where('b.br_code', '!=', 9997)
						->where('b.status', 1)
						->orderBy('b.branch_name', 'asc')
						->select('b.br_code','b.branch_name','b.main_br_code')
						->get();
		
		
		return response()->json(['data' => $no_enrty_branch]); 
		 
    }
	public function PomisThreeIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'POMIS-3 Report';
		$data['emp_type']	= '';
		$data['desig_group_code']	= '';
		$data['is_register_form']		= 1;
		$data['date_within']		= date('Y-m-d');
		$data['designation_group'] 	= array();
				
		return view('admin.pages.service_length_reports.pomis_three_report',$data);
    }
	
	public function PomisThreeReport(Request $request)
    {
        $data = array();
        $data1 = array();
		$data['Heading'] = $data['title'] = 'POMIS-3 Report';
		$data['date_within'] = $date_within = $request->input('date_within');
		$year = date("Y",strtotime($date_within));
		$month = date("m",strtotime($date_within));
		$data['is_register_form'] = $is_register_form = $request->input('is_register_form');
		$data['special_program'] 	= DB::table('tbl_emp_mapping')->where('current_program_id',2)->get();
		$data['all_project'] 	= DB::table('tbl_project')->where('status',1)->get();
		
		/* $pomis_designation 	= DB::table('tbl_pomis_group as pg')
									->leftJoin('tbl_designation as d', 'pg.id', '=', 'd.pomis_designation_group')
									->where('pg.project_id',1)
									->select('pg.id','d.designation_code','d.pomis_designation_group')
									//->groupBy('pg.project_id')
									->get(); */
		$all_result = DB::table('tbl_emp_basic_info as e')
						->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
						->where('e.org_join_date', '<=', $date_within)
						
						->where(function($query) use ($date_within) {								
								$query->whereNull('r.emp_id');
								$query->orWhere('r.effect_date', '>', $date_within);								
							})
						->orderBy('e.emp_id', 'ASC')
						//->limit(300)
						->select('e.emp_id')
						->get();
			foreach ($all_result as $result) {
				$emp_id = $result->emp_id;
				$max_sarok = DB::table('tbl_master_tra as m')
								->where('m.emp_id', '=', $result->emp_id)
								->where('m.br_join_date', '=', function($query) use ($emp_id,$date_within)
										{
											$query->select(DB::raw('max(br_join_date)'))
												  ->from('tbl_master_tra')
												  ->where('emp_id',$emp_id)
												  ->where('br_join_date', '<=', $date_within);
										})
								->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no')) 
								->groupBy('m.emp_id')
								->first();
				if(!empty($max_sarok)) {
				$data_result = DB::table('tbl_master_tra as m')
								->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
								->leftJoin('tbl_pomis_group as pg', 'pg.id', '=', 'd.pomis_designation_group')
								->leftJoin('tbl_project as p', 'p.id', '=', 'pg.project_id')
								->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
								//->leftJoin('tbl_br_fo_register as br', 'm.emp_id', '=', 'br.emp_id')
								->leftjoin('tbl_br_fo_register as br',function($join) use ($year,$month){
												$join->on("br.emp_id","=","m.emp_id")
												->whereYear('br.month', $year)->whereMonth('br.month', $month); 
								})	
								->where('m.emp_id', '=', $max_sarok->emp_id)
								->where('m.sarok_no', '=', $max_sarok->sarok_no)
								->select('m.designation_code','m.emp_id','m.br_code','e.gender','d.pomis_designation_group','pg.project_id','br.is_register','p.project_name')
								->first();
						 
						
						/* $data['all_result_bo'][] =  array(
													'designation_code'      => $data_result->designation_code,
													'gender'      => $data_result->gender,
												);	  */
						if($data_result->br_code != 9999){
							$data['designation_count'][] = array(
									 "designation_code" => $data_result->designation_code,
									"pomis_designation_group" => $data_result->pomis_designation_group,
									"project_id" => $data_result->project_id,
									"is_register" => $data_result->is_register, 
									"emp_id" => $data_result->emp_id,
									"gender" => $data_result->gender
									
									);
							 //if(!in_array($data_result->designation_code,$data1) ){
									$data1[$data_result->project_name][] =$data_result->emp_id;
								//}
							 
						}
					 
							
						 					
					 
				} 
			} 
			 
	/* 	$data['designation_count'][] = array(
									 "designation_code" => 256,
									"pomis_designation_group" => 21,
									"project_id" => 6,
									"is_register" => 2, 
									"emp_id" => 4666,
									"gender" => 'Male'
									
									); */
			 
		/* start for head office */
		$allresult = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.br_code', '=', 9999)
						->where('m.br_join_date', '<=', $date_within)
						->where(function($query) use ($date_within) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $date_within);
								
							})						
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get();
		if (!empty($allresult)) {
			foreach ($allresult as $result1) {
				$emp_id = $result1->emp_id;
				$maxsarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $result1->emp_id)
						->where('m.br_join_date', '=', function($query) use ($emp_id,$date_within)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $date_within);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('m.emp_id')
						->first();
				//print_r ($max_sarok);
				if(!empty($maxsarok)) {
				$data_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_pomis_group as pg', 'pg.id', '=', 'd.pomis_designation_group')
							->leftJoin('tbl_project as p', 'p.id', '=', 'pg.project_id')
							->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
							->where('m.sarok_no', '=', $maxsarok->sarok_no)
							->select('m.br_code','m.emp_id','m.designation_code','e.gender','pg.project_id','p.project_name')
							->first();
				}			
				if ($data_result->br_code == 9999) {
					//if($data_result->emp_id != 4666 ){
						 
					 $data['all_result'][] = array(
						 'designation_code'      => $data_result->designation_code, 
						'gender'      => $data_result->gender, 
						'emp_id'      => $data_result->emp_id,
					); 
				//}
					 //if(!in_array($data_result->designation_code,$data1) ){
									$data1[$data_result->project_name][] =$data_result->emp_id;
								//} 
				
				 
				} 
				if (!empty($data['all_result'])) {
				$data['designation_group_total'] = array_count_values(array_column($data['all_result'], 'gender'));
				}
			}
		} 
		 /*  echo "<pre>";
				print_r($data1); 
				exit; */
 /* foreach($data1 as $vdata1){
	echo $vdata1;
	echo "<br>"; 
}			
	exit; */			
		/*  echo "<pre>";
				print_r($data);   */
				//exit;   
		/* echo "<pre>";
				print_r($data['all_result']);
				
		/* end for head office  
		echo "<pre>";
		print_r($data['designation_group_total']);
		exit; */
		
		return view('admin.pages.service_length_reports.pomis_three_report',$data);
    }
	public function PomisThreeIndexprojectwise()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'POMIS-3 Report';
		$data['emp_type']	= '';
		$data['desig_group_code']	= '';
		$data['all_result']	= '';
		$data['is_register_form']		= 1;
		$data['date_within']		= date('Y-m-d');
		$data['designation_group'] 	= array();
				
		return view('admin.pages.service_length_reports.pomis_three_report_projectwise',$data);
    }
	
	public function PomisThreeReportprojectwise(Request $request)
    {
        $data = array();
        $data1 = array();
		$data['Heading'] = $data['title'] = 'POMIS-3 Report';
		$data['date_within'] = $date_within = $request->input('date_within');
		$year = date("Y",strtotime($date_within));
		$month = date("m",strtotime($date_within));  
		$all_result = DB::table('tbl_emp_basic_info as e')
						->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
						->where('e.org_join_date', '<=', $date_within)
						
						->where(function($query) use ($date_within) {								
								$query->whereNull('r.emp_id');
								$query->orWhere('r.effect_date', '>', $date_within);								
							})
						->orderBy('e.emp_id', 'ASC')
						//->limit(300)
						->select('e.emp_id')
						->get();
			foreach ($all_result as $result) {
				$emp_id = $result->emp_id;
				$max_sarok = DB::table('tbl_master_tra as m')
								->where('m.emp_id', '=', $result->emp_id)
								->where('m.br_join_date', '=', function($query) use ($emp_id,$date_within)
										{
											$query->select(DB::raw('max(br_join_date)'))
												  ->from('tbl_master_tra')
												  ->where('emp_id',$emp_id)
												  ->where('br_join_date', '<=', $date_within);
										})
								->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no')) 
								->groupBy('m.emp_id')
								->first();
				if(!empty($max_sarok)) {
				$data_result = DB::table('tbl_master_tra as m')
								->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
								->leftJoin('tbl_pomis_group as pg', 'pg.id', '=', 'd.pomis_designation_group')
								->leftJoin('tbl_project as p', 'p.id', '=', 'pg.project_id')
								->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
								->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
								//->leftJoin('tbl_br_fo_register as br', 'm.emp_id', '=', 'br.emp_id')
								/* ->leftjoin('tbl_br_fo_register as br',function($join) use ($year,$month){
												$join->on("br.emp_id","=","m.emp_id")
												->whereYear('br.month', $year)->whereMonth('br.month', $month); 
								})	 */
								->where('m.emp_id', '=', $max_sarok->emp_id)
								->where('m.sarok_no', '=', $max_sarok->sarok_no)
								->select('m.designation_code','m.emp_id','m.br_code','e.gender','d.pomis_designation_group','d.designation_name','pg.project_id','p.project_name','e.emp_name_eng','b.branch_name')
								->first();
						 
						
						/* $data['all_result_bo'][] =  array(
													'designation_code'      => $data_result->designation_code,
													'gender'      => $data_result->gender,
												);	  */
						if($data_result->br_code != 9999){
							$data['all_result'][] = array(
									 "designation_code" => $data_result->designation_code,
									"designation_name" => $data_result->designation_name,
									"project_id" => $data_result->project_id,
									"emp_id" => $data_result->emp_id,
									'gender'      => $data_result->gender,
									'branch_name'      => $data_result->branch_name,
									"project_name" => $data_result->project_name,
									"emp_name" => $data_result->emp_name_eng
									
									);
							 //if(!in_array($data_result->designation_code,$data1) ){
									$data1[$data_result->project_name][] =$data_result->emp_id;
								//}
							 
						}
					 
							
						 					
					 
				} 
			} 
			 
		
			 
		/* start for head office */
		$allresult = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.br_code', '=', 9999)
						->where('m.br_join_date', '<=', $date_within)
						->where(function($query) use ($date_within) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $date_within);
								
							})						
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get();
		if (!empty($allresult)) {
			foreach ($allresult as $result1) {
				$emp_id = $result1->emp_id;
				$maxsarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $result1->emp_id)
						->where('m.br_join_date', '=', function($query) use ($emp_id,$date_within)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $date_within);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('m.emp_id')
						->first();
				//print_r ($max_sarok);
				if(!empty($maxsarok)) {
				$data_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
							->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
							->where('m.sarok_no', '=', $maxsarok->sarok_no)
							->select('m.br_code','m.emp_id','m.designation_code','d.designation_name','e.emp_name_eng','e.gender','b.branch_name')
							->first();
				}			
				if ($data_result->br_code == 9999) {
					
					
					$project_info  = DB::table('tbl_emp_mapping as e')
												 ->leftJoin('tbl_project as p', 'p.id', '=', 'e.project_id')
												 ->where('e.emp_id', $data_result->emp_id)
												 ->where(function($q) use ($date_within) {
													 $q->where('e.start_date','<=', $date_within)->where('e.end_date','>=', $date_within)->orWhere('e.start_date','<=', $date_within)->whereNull('e.end_date')->orwhere('e.end_date','=','0000-00-00');
												 })  
												 ->select('e.emp_id','p.project_name') 
												 ->first(); 
					
					
					 $data['all_result'][] = array(
						 'designation_code'      => $data_result->designation_code, 
						'designation_name'      => $data_result->designation_name, 
						'emp_id'      => $data_result->emp_id,
						'gender'      => $data_result->gender,
						'branch_name'      => $data_result->branch_name,
						'emp_name'      => $data_result->emp_name_eng,
						'project_name'      => $project_info->project_name,
					); 
					 //if(!in_array($data_result->designation_code,$data1) ){
									$data1[$project_info->project_name][] =$data_result->emp_id;
								//} 
				
				 
				}  
			}
		} 
		 /*  echo "<pre>";
				print_r($data1); 
				exit; */
 /* foreach($data1 as $vdata1){
	echo $vdata1;
	echo "<br>"; 
}			
	exit; */			
		/*  echo "<pre>";
				print_r($data);   */
				//exit;   
		/* echo "<pre>";
				print_r($data['all_result']);
				
		/* end for head office  
		echo "<pre>";
		print_r($data['designation_group_total']);
		exit; */
		
		return view('admin.pages.service_length_reports.pomis_three_report_projectwise',$data);
    }
	
	public function ProjectBranchStaffIndex()
    {
        $data = array();
		$data['br_code']	= '';	
		$data['year']	= '';
		$data['month']	= date('m');
		$data['Heading'] = $data['title'] = 'Project Wise Staff Report';
		$data['branches'] 	= DB::table('tbl_branch')->where('status',1)->where('br_code','!=',9997)->where('branch_name', 'NOT LIKE', '%-%')->orderBy('branch_name', 'ASC')->get();	
		return view('admin.pages.service_length_reports.project_staff_report',$data);
    }
	
	public function ProjectBranchStaffReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Project Wise Staff Report';
		$data['br_code'] = $br_code = $request->input('br_code');
		$data['year'] = $year = $request->input('year');
		$data['month'] = $month = $request->input('month');
		$data['branches'] = DB::table('tbl_branch')->where('status',1)->where('br_code','!=',9997)->where('branch_name', 'NOT LIKE', '%-%')->orderBy('branch_name', 'ASC')->get();	
		$allbranches = DB::table('tbl_branch')->where('main_br_code', '=', $br_code)->orderBy('branch_name', 'ASC')->get();
		//echo $month; echo date('m'); //exit;
		if($month == date('m')) {
			$data['form_date'] = $form_date = date('Y-m-d');
		} else {
			$year_month = $year.'-'.$month;
			$lastday = date('t',strtotime($year_month));
			$data['form_date'] = $form_date = $year_month.'-'.$lastday;
		}		
		
		$array = json_decode(json_encode($allbranches), true);
		$imploded= implode(',', array_column($array, 'br_code'));
		$str_arr = explode (",", $imploded);
		$data['first_br_code'] = $str_arr['0'];
		$data['second_br_code'] = !empty($str_arr['1']) ? $str_arr['1'] : 0;
		//print_r(array($str_arr));
		//print_r(array(63,144));
		$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->whereIn('m.br_code', $str_arr)
						->where('m.br_join_date', '<=', $form_date)
						->where(function($query) use ($form_date) {
								$query->whereNull('r.emp_id');
								$query->orWhere('r.effect_date', '>', $form_date);							
							})
						
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get()->toArray();
		//print_r($all_result);
		////////////////
		$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										//->where('eas.br_code', '=', $data['br_code'])
										->whereIn('eas.br_code', $str_arr)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($form_date) {
											$query->whereNull('r.emp_id');
											$query->orWhere('r.effect_date', '>', $form_date);											
										})									
										->select('eas.emp_id')
										->get()->toArray();
		//print_r ($assign_branch);
		//$all_result1 = array_merge($all_result,$assign_branch);
		$all_result1 = array_unique(array_merge($all_result,$assign_branch), SORT_REGULAR);
		//print_r ($all_result1);
		////////////////
		if (!empty($all_result1)) {
			foreach ($all_result1 as $result) {
				$emp_id = $result->emp_id;
				$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $result->emp_id)
						->where('m.br_join_date', '=', function($query) use ($emp_id,$form_date)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $form_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('m.emp_id')
						->first();
				//print_r ($max_sarok);
				$data_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
							->leftJoin('tbl_emp_assign as ea', function($join){
											$join->where('ea.status',1)
												->on('m.emp_id', '=', 'ea.emp_id');
										})
							->where('m.sarok_no', '=', $max_sarok->sarok_no)
							->select('e.emp_name_eng','e.org_join_date','e.permanent_add','e.father_name','m.br_join_date','m.br_code','m.designation_code','d.priority','d.pomis_priority','d.designation_name','b.branch_name','ea.incharge_as')
							->first();
				//print_r ($data_result);
				//// employee assign ////
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
											->select('ea.emp_id','ea.open_date','ea.br_code','br.branch_name','ar.area_name')
											->first();
				if(!empty($assign_branch)) {
					$result_br_code = $assign_branch->br_code;
					$asign_branch_name = $assign_branch->branch_name;
					$asign_area_name = $assign_branch->area_name;
					$asign_open_date = date('d M Y',strtotime($assign_branch->open_date));
				} else {
					$result_br_code = $data_result->br_code;
					$asign_branch_name = '';
					$asign_area_name =  '';
					$asign_open_date =  '';
				}
				////////			
				
				if ($result_br_code == $data['first_br_code'] || $result_br_code == $data['second_br_code']) {	
					$emp_mapping = DB::table('tbl_emp_mapping as em')
											->leftJoin('tbl_project as pr', 'em.project_id', '=', 'pr.id')
											->where('em.emp_id', $result->emp_id)
											->orderBy('em.id', 'DESC')
											//->orderBy('em.current_program_id', 'ASC')
											->select('em.current_program_id','em.project_id','pr.project_name')
											->first();
					//print_r($emp_mapping);
					//echo $program_id = $emp_mapping->current_program_id;
					$isregister = DB::table('tbl_br_fo_register')
										->where('emp_id', '=', $result->emp_id)
										 ->Where(function($query) use ($year ,$month ) {
											$query->whereYear('month', '=', $year)
												   ->whereMonth('month', '=', $month);
										})
										//->where('br_code', '=', $br_code)
										->select('is_register')
										->first();
					if (empty($isregister)) {
						$is_register = '';
					} else {
						$is_register = $isregister->is_register;
					}
					
					if($result->emp_id==200009){
							$data_result->pomis_priority = 4;
					}
					
					$data['all_result'][] = array(
						
						'emp_id' => $result->emp_id,
						'emp_name_eng'      => $data_result->emp_name_eng,
						'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
						'designation_name'      => $data_result->designation_name,
						'branch_name'      => $data_result->branch_name,
						'assign_designation'      => $asign_desig,
						'assign_open_date'      => $desig_open_date,
						'designation_code'      => $data_result->designation_code,
						'priority'      => $data_result->pomis_priority,
						'is_register'      => $is_register,
						'program_id'      => !empty($emp_mapping->current_program_id) ? $emp_mapping->current_program_id:'0',
						'project_id'      => !empty($emp_mapping->project_id) ? $emp_mapping->project_id:'0',
						'project_name'      => !empty($emp_mapping->project_name) ? $emp_mapping->project_name:''
					);
				}				
			}
			
		}
		/* echo "<pre>";
		print_r ($data['all_result']);
		exit; */
		return view('admin.pages.service_length_reports.project_staff_report',$data);
    }
	
	public function ProjectBranchIndex()
    {
        $data = array();
		$user_type 	= Session::get('user_type');
		$branch_code = Session::get('branch_code');
		$data['Heading'] = $data['title'] = 'Branch Wise Staff Report';
		$data['br_code'] = $br_code = $branch_code;
		$data['form_date'] = $form_date = date('Y-m-d');		
		$data['month'] = '';
		$data['year'] = $year = date('Y');
		
		return view('admin.pages.service_length_reports.project_branch_staff_report',$data);
    }
	
	public function ProjectBranchReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Branch Wise Staff Report';
		$data['br_code'] = $br_code = Session::get('branch_code');
		$data['year'] = $year = $request->input('year');
		$data['month'] = $month = $request->input('month');
		
		if($month == date('m') && $year == date('Y')) {
			$data['form_date'] = $form_date = date('Y-m-d');
			$data['count_no'] = DB::table('tbl_br_fo_register')->where('br_code', $br_code)->whereYear('month', $year)->whereMonth('month', $month)->count();
			//print_r($data['count_no']);
		} else if($month > date('m') && $year == date('Y')) {
			$data['count_no'] = 1;
			$year_month = $year.'-'.$month;
			$lastday = date('t',strtotime($year_month));
			$data['form_date'] = $form_date = $year_month.'-'.$lastday;
		} else {
			$data['count_no'] = DB::table('tbl_br_fo_register')->where('br_code', $br_code)->whereYear('month', $year)->whereMonth('month', $month)->count();
			//$data['count_no'] = 1;
			$year_month = $year.'-'.$month;
			$lastday = date('t',strtotime($year_month));
			$data['form_date'] = $form_date = $year_month.'-'.$lastday;
		}		
		
		$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.br_code', $br_code)
						->where('m.br_join_date', '<=', $form_date)
						->where(function($query) use ($form_date) {
								$query->whereNull('r.emp_id');
								$query->orWhere('r.effect_date', '>', $form_date);							
							})
						
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get()->toArray();
		//print_r($all_result);
		////////////////
		$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										//->where('eas.br_code', '=', $data['br_code'])
										->where('eas.br_code', $br_code)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($form_date) {
											$query->whereNull('r.emp_id');
											$query->orWhere('r.effect_date', '>', $form_date);											
										})									
										->select('eas.emp_id')
										->get()->toArray();
		//print_r ($assign_branch);
		//$all_result1 = array_merge($all_result,$assign_branch);
		$all_result1 = array_unique(array_merge($all_result,$assign_branch), SORT_REGULAR);
		//print_r ($all_result1);
		////////////////
		if (!empty($all_result1)) {
			foreach ($all_result1 as $result) {
				$emp_id = $result->emp_id;
				$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $result->emp_id)
						->where('m.br_join_date', '=', function($query) use ($emp_id,$form_date)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $form_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('m.emp_id')
						->first();
				//print_r ($max_sarok);
				$data_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
							->leftJoin('tbl_emp_assign as ea', function($join){
											$join->where('ea.status',1)
												->on('m.emp_id', '=', 'ea.emp_id');
										})
							->where('m.sarok_no', '=', $max_sarok->sarok_no)
							->select('e.emp_name_eng','e.org_join_date','e.permanent_add','e.father_name','m.br_join_date','m.br_code','m.designation_code','d.priority','d.pomis_priority','d.designation_name','b.branch_name','ea.incharge_as')
							->first();
				//print_r ($data_result);
				//// employee assign ////
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
											->select('ea.emp_id','ea.open_date','ea.br_code','br.branch_name','ar.area_name')
											->first();
				if(!empty($assign_branch)) {
					$result_br_code = $assign_branch->br_code;
					$asign_branch_name = $assign_branch->branch_name;
					$asign_area_name = $assign_branch->area_name;
					$asign_open_date = date('d M Y',strtotime($assign_branch->open_date));
				} else {
					$result_br_code = $data_result->br_code;
					$asign_branch_name = '';
					$asign_area_name =  '';
					$asign_open_date =  '';
				}
				////////			
				
				if ($result_br_code == $br_code) {	
					$emp_mapping = DB::table('tbl_emp_mapping as em')
											->leftJoin('tbl_project as pr', 'em.project_id', '=', 'pr.id')
											->where('em.emp_id', $result->emp_id)
											->orderBy('em.id', 'DESC')
											//->orderBy('em.current_program_id', 'ASC')
											->select('em.current_program_id','em.project_id','pr.project_name')
											->first();
					//print_r($emp_mapping);
					//echo $program_id = $emp_mapping->current_program_id;
					$isregister = DB::table('tbl_br_fo_register')
										->where('emp_id', '=', $result->emp_id)
										->where('br_code', '=', $br_code)
										->whereYear('month', $year)
										->whereMonth('month', $month)
										->select('is_register')
										->first();
					if (empty($isregister)) {
						$is_register = '';
					} else {
						$is_register = $isregister->is_register;
					}
					
					$data['all_result'][] = array(
						
						'emp_id' => $result->emp_id,
						'emp_name_eng'      => $data_result->emp_name_eng,
						'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
						'designation_name'      => $data_result->designation_name,
						'branch_name'      => $data_result->branch_name,
						'assign_designation'      => $asign_desig,
						'assign_open_date'      => $desig_open_date,
						'designation_code'      => $data_result->designation_code,
						'priority'      => $data_result->pomis_priority,
						'is_register'      => $is_register,
						'program_id'      => !empty($emp_mapping->current_program_id) ? $emp_mapping->current_program_id:'0',
						'project_id'      => !empty($emp_mapping->project_id) ? $emp_mapping->project_id:'0',
						'project_name'      => !empty($emp_mapping->project_name) ? $emp_mapping->project_name:''
					);
				}				
			}
			
		}
		//print_r ($data['all_result']);
		return view('admin.pages.service_length_reports.project_branch_staff_report',$data);
    }
	
	public function ProjectStaffSave(Request $request)
    {
		
		//$data = request()->except(['_token']);
		//print_r($data); exit;
		$result_item = $request->input('result_item');
		$br_code = $request->input('br_code');
		$year = $request->input('year');
		$month = $request->input('month');
		$year_month = $year.'-'.$month;
		$lastday = date('t',strtotime($year_month));
		$form_date = $year_month.'-'.$lastday;
		//print_r ($result_item); exit;
		if (!empty($result_item)) {
			foreach ($result_item as $post_data) {
				if(!empty($post_data['is_register'])) {
					$result_data['br_code']   	= $br_code;
					$result_data['designation_code']   	= $post_data['designation_code'];
					$result_data['emp_id']   	= $post_data['emp_id'];
					$result_data['is_register']   	= $post_data['is_register'];
					$result_data['month']   	= $form_date;
					$result_data['created_by'] 	= Session::get('admin_id');
					DB::table('tbl_br_fo_register')->insert($result_data);
				}				
			}
		}
		Session::flash('message','Data Save Successfully');
		//return back()->withInput();
		return Redirect::to("/project_branch_staff");
    }
	

	
}
