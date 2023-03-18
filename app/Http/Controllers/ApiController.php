<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Redirect;
use PDF;
use File;

class ApiController extends Controller
{
	
	/* for cdip eye */
	public function BranchStaff($br_code, $form_date)
    {
        $data = array();
		//$data['branches'] = DB::table('tbl_branch')->orderBy('branch_name', 'ASC')->get();
		$status = 1;
		$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.br_code', '=', $br_code)
						->where('m.br_join_date', '<=', $form_date)
						->where(function($query) use ($status, $form_date) {
								if($status !=2) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);
								} else {
									$query->Where('r.effect_date', '<=', $form_date);
								}
							})
						
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get()->toArray();
		//print_r($all_result);
		////////////////
		$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										->where('eas.br_code', '=', $br_code)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($status, $form_date) {
											if($status !=2) {
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date);
											} else {
												$query->Where('r.effect_date', '<=', $form_date);
											}
										})									
										->select('eas.emp_id')
										->get()->toArray();
		//print_r ($assign_branch);
		$all_result1 = array_unique(array_merge($all_result,$assign_branch), SORT_REGULAR);
		//print_r ($all_result1);
		////////////////
		if (!empty($all_result1)) {
			foreach ($all_result1 as $result) {
				//$register_form_date =date("Y-m-t",strtotime($form_date));
				$register_form_date =date("Y-m-t");
				$register_info =DB::select(DB::raw("SELECT
													tbl_br_fo_register.is_register
												FROM
													`tbl_br_fo_register`
												WHERE
													`tbl_br_fo_register`.`emp_id` = $result->emp_id AND `tbl_br_fo_register`.`br_code` = $br_code AND tbl_br_fo_register.month <= '".$register_form_date."'
												ORDER BY
													tbl_br_fo_register.id
												DESC
												LIMIT 1")); 
				
				 
				
				if (!empty($register_info)) { 
					 
				$is_register = $register_info[0]->is_register;
						 
					} else {
						$is_register = 2;
					}	
				
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
				//print_r ($max_sarok);
				$data_result = DB::table('tbl_master_tra as m')
					->leftJoin('tbl_appointment_info as e', 'm.emp_id', '=', 'e.emp_id')
					->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
					->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
					->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
					->leftJoin('tbl_zone as z', 'a.zone_code', '=', 'z.zone_code')
					->where('m.sarok_no', '=', $max_sarok->sarok_no)
					->select('e.emp_name','d.designation_group_code','e.joining_date','m.br_join_date','m.br_code','a.area_code','z.zone_code','m.designation_code','d.designation_name','b.branch_name')
					->first();
				//print_r ($data_result);
				//// employee assign ////
				$assign_designation = DB::table('tbl_emp_assign as ea')
											->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
											->where('ea.emp_id', $result->emp_id)
											->where('ea.status', '!=', 0)
											->where('ea.select_type', '=', 5)
											->select('ea.emp_id','ea.open_date','de.designation_name','de.designation_group_code')
											->first();
				if(!empty($assign_designation)) {
					$asign_desig = $assign_designation->designation_name;
					$designation_group_code = $assign_designation->designation_group_code;
					$desig_open_date = $assign_designation->open_date;
				} else {
					$asign_desig = '';
					$desig_open_date =  '';
					$designation_group_code =  $data_result->designation_group_code;
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
					$data[] = array(
						'emp_id' => $result->emp_id,
						'emp_name_eng'      => $data_result->emp_name,
						'exam_name'      => $exam_name,
						'org_join_date'      => $data_result->joining_date,
						'br_join_date'      => $data_result->br_join_date,
						'designation_name'      => $data_result->designation_name,
						'branch_name'      => $data_result->branch_name,
						'br_code'      => $result_br_code,
						'is_register'      => $is_register,
						'area_code'      => $data_result->area_code,
						'zone_code'      => $data_result->zone_code,
						'designation_code'      => $data_result->designation_code,
						'designation_group_code'      => $designation_group_code,
						'assign_designation'      => $asign_desig,
						'assign_open_date'      => $desig_open_date,
						'asign_branch_name'      => $asign_branch_name,
						'asign_area_name'      => $asign_area_name,
						'asign_open_date'      => $asign_open_date
					);
				}				
			}
			if($br_code == 66) {
				$data[] = array(
				'emp_id' => 100216,
				'emp_name_eng'      => 'Mohammad Mojibor Rahman',
				'br_join_date'      => '2019-01-01',
				'designation_name'      => 'Br Accountant',
				'designation_group_code'      => 16,
				'is_register'      => 2,
				'br_code'      => 66
				);
			}				
		}
		return \Response::json($data);
    }
	
	/* for spms */
	public function Branch_Staff($br_code, $form_date)
    {
        $data = array();
		//$data['branches'] = DB::table('tbl_branch')->orderBy('branch_name', 'ASC')->get();
		$status = 1;
		$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.br_code', '=', $br_code)
						->where('m.br_join_date', '<=', $form_date)
						->where(function($query) use ($status, $form_date) {
								if($status !=2) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);
								} else {
									$query->Where('r.effect_date', '<=', $form_date);
								}
							})
						
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get()->toArray();
		//print_r($all_result);
		////////////////
		$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										->where('eas.br_code', '=', $br_code)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($status, $form_date) {
											if($status !=2) {
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date);
											} else {
												$query->Where('r.effect_date', '<=', $form_date);
											}
										})									
										->select('eas.emp_id')
										->get()->toArray();
		//print_r ($assign_branch);
		$all_result1 = array_unique(array_merge($all_result,$assign_branch), SORT_REGULAR);
		//print_r ($all_result1);
		////////////////
		if (!empty($all_result1)) {
			foreach ($all_result1 as $result) {
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
				//print_r ($max_sarok);
				$data_result = DB::table('tbl_master_tra as m')
					->leftJoin('tbl_appointment_info as e', 'm.emp_id', '=', 'e.emp_id')
					->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
					->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
					->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
					->leftJoin('tbl_zone as z', 'a.zone_code', '=', 'z.zone_code')
					->where('m.sarok_no', '=', $max_sarok->sarok_no)
					->select('e.emp_name','e.joining_date','m.br_join_date','m.br_code','a.area_code','z.zone_code','m.designation_code','d.designation_name','b.branch_name')
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
					$data[] = array(
						'emp_id' => $result->emp_id,
						'emp_name_eng'      => $data_result->emp_name,
						'exam_name'      => $exam_name,
						'org_join_date'      => $data_result->joining_date,
						'br_join_date'      => $data_result->br_join_date,
						'designation_name'      => $data_result->designation_name,
						'branch_name'      => $data_result->branch_name,
						'br_code'      => $result_br_code,
						'area_code'      => $data_result->area_code,
						'zone_code'      => $data_result->zone_code,
						'designation_code'      => $data_result->designation_code,
						'assign_designation'      => $asign_desig,
						'assign_open_date'      => $desig_open_date,
						'asign_branch_name'      => $asign_branch_name,
						'asign_area_name'      => $asign_area_name,
						'asign_open_date'      => $asign_open_date
					);
				}				
			}				
		}
		return \Response::json($data);
    }
	
	public function AmBmStaff($ambmcode, $form_date)
    {
        $data = array();
		$form_date = date('Y-m-d');
		
		$all_designation_code = DB::table('tbl_designation')
								->where('designation_group_code', '=', $ambmcode)
								->select('designation_code')
								->get();
		//print_r ($all_designation_code);exit;
		if($all_designation_code) {
			$all_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
							->where('m.letter_date', '<=', $form_date)
							->where('m.br_join_date', '<=', $form_date)
							->where('m.effect_date', '<=', $form_date)
							->whereNull('r.emp_id')
							->orWhere('r.effect_date', '>', $form_date)
							->groupBy('m.emp_id')
							->select('m.emp_id',DB::raw('max(m.letter_date) as letter_date'))
							->get();
			
			if(!empty($all_result)) {
				foreach($all_result as $result) {
					$max_sarok = DB::table('tbl_master_tra')
								->where('emp_id', $result->emp_id)
								->where('letter_date', $result->letter_date)
								->select(DB::raw('MAX(sarok_no) AS sarok_no'))
								->first();
					//print_r($max_sarok); //exit;
					$desig_nation = DB::table('tbl_master_tra')
								->where('emp_id', $result->emp_id)
								->where('sarok_no', $max_sarok->sarok_no)
								->select('emp_id','sarok_no','designation_code')
								->first();
					foreach($all_designation_code as $all_designation) {
						if($all_designation->designation_code == $desig_nation->designation_code) {
							$result_data = DB::table('tbl_master_tra as m')
										->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
										->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
										->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
										->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
										->where('m.emp_id', '=', $desig_nation->emp_id)
										->where('m.sarok_no', '=', $desig_nation->sarok_no)
										->select('m.emp_id','m.br_code','e.emp_name_eng','m.br_join_date','b.branch_name','a.area_code','a.area_name')
										->first();
						
						//print_r($result_data);
							$data[] = array(
								'emp_id' => $result_data->emp_id,
								'br_code'      => $result_data->br_code,
								'branch_name'      => $result_data->branch_name
							);
							
						}
						
					}
				
				}
			}
		
		}
		return \Response::json($data);
		
		/* $all_result = DB::table('tbl_admin')
								->where('access_label', '=', 22)
								->where('user_type', '=', 4)
								->where('status', '=', 1)
								->select('branch_code','email_address')
								->get();
		foreach($all_result as $result) {
			$data[] = array(
				'br_code'      => $result->branch_code,
				'email_address'      => $result->email_address
			);
		}
		return \Response::json($data); */		
    }
	
	public function HrmGhaMarks($emp_id)
    {
        $data = array();
		$fiscal_year_from = '2020-07-01';
		$fiscal_year_to = '2021-06-30';
		
		////////////////
		$data = DB::table('tbl_punishment')
									->where('emp_id', $emp_id)
									->where('letter_date', '>=', $fiscal_year_from)
									->where('letter_date', '<=', $fiscal_year_to)
									->select(DB::raw('COUNT(id) as total_no'))
									->first();			
			
		return \Response::json($data);
    }
	
	public function SpmsGrade($emp_id)
    {
        $data = array();
		$form_date = "2020-10-01";
		$max_sarok = DB::table('tbl_master_tra as m')
				->where('m.emp_id', '=', $emp_id)
				->where('m.grade_effect_date', '=', function($query) use ($emp_id,$form_date)
						{
							$query->select(DB::raw('max(grade_effect_date)'))
								  ->from('tbl_master_tra')
								  ->where('emp_id',$emp_id)
								  ->where('grade_effect_date', '<=', $form_date);
						})
				->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
				->groupBy('m.emp_id')
				->first();
		//print_r($max_sarok);
		$data = DB::table('tbl_master_tra as m')
				->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
				->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
				->where('m.sarok_no', '=', $max_sarok->sarok_no)
				->select('e.emp_id','e.emp_name_eng','g.grade_name')
				->first();			
			
		return \Response::json($data);
    }
	
	/* for duplicate data delete */
	public function PerformanceReportStaffCheck()
    {
        $data = array();
		$data['desig_type_id'] = $desig_type_id = 1;
		$data['mark_search'] = $mark_search = 100;
		$data['all_result'] = DB::table('tbl_final_report as fp')
										->leftJoin('tbl_designation as d', 'fp.designation_id', '=', 'd.designation_code')
										->leftJoin('tbl_branch as b', 'fp.br_code', '=', 'b.br_code')
										->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
										->leftJoin('tbl_zone as z', 'a.zone_code', '=', 'z.zone_code')
										->where('fp.desig_type_id', '=', $desig_type_id)
										->where('fp.total_marks', '<', $mark_search)
										->where('fp.status', '=', 1)
										->where('fp.year_id', '=', 2)
										->orderBy('fp.total_marks', 'desc')
										->select('fp.*','d.designation_name','b.branch_name','a.area_name','z.zone_name')
										->get();
		//print_r($data['all_result']);
		//exit;
		foreach($data['all_result'] as $result) {
			$effect_date = '2021-06-30'; 
			$hrm_edms = DB::table('tbl_edms_document')
										->where('subcat_id', '=', 4)
										->where('category_id', '=', 2)
										->where('emp_id', '=', $result->emp_id)
										->where('effect_date', '=', $effect_date)
										->select('document_id')
										->get()->toArray(); 
			//echo '<pre/>';
			$removed = array_pop($hrm_edms);
			foreach($hrm_edms as $key => $value) {				
			//print_r($result); exit;
			//echo $value->document_id;  
			//DB::table('tbl_edms_document')->where('document_id', $value->document_id)->delete();  
			}   
			//print_r($hrm_edms); 
			//exit;							
		}
    }
	
	/* for edms at spms script */
	public function PerformanceReportStaff()
    {
        $data = array();
		$data['desig_type_id'] = $desig_type_id = 10;
		$data['mark_search'] = $mark_search = 100;
		$data['all_result'] = DB::table('tbl_final_report as fp')
										->leftJoin('tbl_designation as d', 'fp.designation_id', '=', 'd.designation_code')
										->leftJoin('tbl_branch as b', 'fp.br_code', '=', 'b.br_code')
										->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
										->leftJoin('tbl_zone as z', 'a.zone_code', '=', 'z.zone_code')
										->where('fp.desig_type_id', '=', $desig_type_id)
										->where('fp.total_marks', '<', $mark_search)
										->where('fp.status', '=', 1)
										->where('fp.year_id', '=', 2)
										->orderBy('fp.total_marks', 'desc')
										->select('fp.*','d.designation_name','b.branch_name','a.area_name','z.zone_name')
										->get();
		/* echo '<pre/>';
		print_r($data['all_result']);
		exit;  */
		/* Pdf save to EDMS Start */ 
		foreach($data['all_result'] as $result) {
			
			/* $hrm_edms = DB::table('tbl_edms_document')
										->where('subcat_id', '=', 4)
										->where('category_id', '=', 2)
										->where('emp_id', '=', $result->emp_id)
										->where('effect_date', '=', $effect_date)
										->count(); */
										
										
		$data['emp_id'] = $emp_id = $result->emp_id;	
		$data['desig_type_id'] = $desig_type_id = $result->desig_type_id;
		if($emp_id) {
			
			$data['emp_result'] = $emp_result = DB::table('tbl_eval_emp_assign as eea')
						->leftJoin('tbl_designation as d', 'eea.designation_id', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'eea.br_code', '=', 'b.br_code')
						->leftJoin('tbl_area as a', 'eea.area_code', '=', 'a.area_code')
						->leftJoin('tbl_zone as z', 'eea.zone_code', '=', 'z.zone_code')
						->where('eea.emp_id', '=', $emp_id)
						->where('eea.year_id', '=', 2)
						->select('eea.eval_id','eea.emp_id','eea.emp_name','eea.br_join_date','eea.br_code','eea.designation_id','eea.desig_type_id','eea.education','d.designation_name','b.branch_name','a.area_name','z.zone_name')
						->first();
			$data['designation_type'] = DB::table('tbl_designation_type')
							->where('id', '=', $desig_type_id)
							->first();
			
			$evaluation_type = DB::table('tbl_evaluation_type')
							->where('desig_type_id', '=', $desig_type_id)
							->select('id','eval_type_name','eval_type_no')
							->get();
							
			foreach ($evaluation_type as $evaluation) {
				if ($evaluation->eval_type_no ==1) {
					$data['eval_type_ka'] = $evaluation->eval_type_name;
				}
				if ($evaluation->eval_type_no ==2) {
					$data['eval_type_kha'] = $evaluation->eval_type_name;
				}
				if ($evaluation->eval_type_no ==3) {
					$data['eval_type_ga'] = $evaluation->eval_type_name;
				}
				if ($evaluation->eval_type_no ==4) {
					$data['eval_type_gha'] = $evaluation->eval_type_name;
				}
				if ($evaluation->eval_type_no ==5) {
					$data['eval_type_umo'] = $evaluation->eval_type_name;
				}
			}
			//print_r($evaluation_type);
			
			/// Start Final Report for staff
			$data['final_report'] = DB::table('tbl_final_report as fp')
										->where('fp.emp_id', '=', $emp_id)
										->where('fp.desig_type_id', '=', $desig_type_id)
										->where('fp.year_id', '=', 2)
										->first();
			
			/// End Final Report for staff							
		} 		
										
		$date = '2021-07-01';
		$effect_date = '2021-06-30';
		
		/* $hrm_edms = DB::table('tbl_edms_document')
										->where('subcat_id', '=', 4)
										->where('category_id', '=', 2)
										->where('emp_id', '=', $emp_id)
										->where('effect_date', '=', $effect_date)
										->get(); */
		//print_r(count($hrm_edms)); exit;
		//if(!empty($hrm_edms)) {								
		$pdf = PDF::loadView('admin.pages.spms_edms.performance_final_report_pdf',$data,[],['format' => 'A4']);
		$image_full_name = $emp_id.'_2_4_'.$date.".pdf";
		//$path = '/home/microfineye/public_html/hrm/attachments/pdf_spms/';
		//$pdf->save($path.$image_full_name, 'F');
		//////////////////
		$edms['subcat_id']			= 4;
		$edms['category_id']		= 2;
		$edms['emp_id']				= $emp_id;
		$edms['document_name']		= $image_full_name;
		$edms['effect_date']		= $effect_date;
		$edms['user_id']			= 4; 
		$edms['status']				= 1;
		//DB::table('tbl_edms_document')->insert($edms);
		//echo count($hrm_edms);
		/////////////////
		//}
		}
		
		/* Pdf save to EDMS end */

		$data['all_designation_type'] = DB::table('tbl_designation_type')->get();
		//return view('admin.pages.spms_edms.performance_final_report_pdf',$data);
    }
	

}
