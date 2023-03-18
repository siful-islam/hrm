<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class ReportBasicController extends Controller
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
	
    public function AllStaffIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'All Staff Report';
		$data['form_date']	= date('Y-m-d');	
		$data['status']		= 1;
		$data['emp_group']		= '';
		$data['emp_type']		= '';
		$data['all_emp_group'] 		= DB::table('tbl_emp_group')->get();
		$data['all_emp_type'] 		= array();		
		return view('admin.pages.reports.all_staff_report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function StaffReport(Request $request)
    {

		$data = array();
		$data['Heading'] = $data['title'] = 'All Staff Report';
		$data['form_date'] 	= $form_date = $request->input('form_date');
		$data['status'] 	= $status = $request->input('status');
		$data['emp_group'] 	= $emp_group = $request->input('emp_group');
		$data['emp_type'] 	= $emp_type = $request->input('emp_type');
		$data['all_emp_group'] 		= DB::table('tbl_emp_group')->get();
		
		if($emp_type){
			$data['all_emp_type'] = DB::table('tbl_emp_type')
					  ->where('type_id', $emp_group) 
					  ->where('status', 1) 
                      ->get();
		$all_result = DB::table('tbl_emp_basic_info as e')
						->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
						->where('e.emp_group', '=', $emp_group)
						->where('e.emp_type', '=', $emp_type)
						->where('e.org_join_date', '<=', $data['form_date'])
						
						->where(function($query) use ($status, $form_date) {
								if($status != 'all') {
									if($status == 1) {
										$query->whereNull('r.emp_id');
										$query->orWhere('r.effect_date', '>', $form_date);
									} elseif ($status == 0) {
										$query->where('r.effect_date', '<=', $form_date);
									}
								}
							})

						->orderBy('e.emp_id', 'ASC')
						->select('e.*','r.effect_date')
						->get();
		//print_r ($all_result); exit;				
		foreach ($all_result as $result) {
			$max_exam = DB::table('tbl_emp_edu_info')
				->where('emp_id', '=', $result->emp_id)
				->select('emp_id', DB::raw('max(level_id) as level_id'))
                ->groupBy('emp_id')
                ->first();
				//print_r ($max_exam);
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
			/* $max_sarok = DB::table('tbl_master_tra')
				->where('emp_id', '=', $result->emp_id)
				->where('br_join_date', '<=', $data['form_date'])
				->select('emp_id', DB::raw('max(letter_date) as letter_date'), DB::raw('max(sarok_no) as sarok_no'))
                ->groupBy('emp_id')
                ->first(); */
				
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
			if(!empty($max_sarok)) {
			$data_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
							->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
							->where('m.sarok_no', '=', $max_sarok->sarok_no)
							->select('m.basic_salary','m.emp_id','m.br_join_date','m.tran_type_no','m.next_increment_date','d.designation_name','b.branch_name','a.area_name')
							->first();
			//print_r ($data_result);
			//// employee assign ////
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
			////////
			$data['all_result'][] = array(
					'emp_id' => $result->emp_id,
					'emp_name_eng'      => $result->emp_name_eng,
					'emp_name_ban'      => $result->emp_name_ban,
					'permanent_add'      => $result->permanent_add,
					'father_name'      => $result->father_name,
					'exam_name'      => $exam_name,
					'org_join_date'      => date('d M Y',strtotime($result->org_join_date)),
					'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
					'designation_name'      => $data_result->designation_name,
					'branch_name'      => $data_result->branch_name,
					'area_name'      => $data_result->area_name,
					'tran_type_no'      => $data_result->tran_type_no,
					'c_end_date'      => (($data_result->next_increment_date != '')) ? date('d M Y',strtotime($data_result->next_increment_date)) : '-',
					're_effect_date'      => $result->effect_date,
					'assign_designation'      => $asign_desig,
					'assign_open_date'      => $desig_open_date,
					'asign_branch_name'      => $asign_branch_name,
					'asign_area_name'      => $asign_area_name,
					'asign_open_date'      => $asign_open_date
				);	
				
				/*$inc_infos  = DB::table('tbl_master_tra as m')  
						->where('m.emp_id', '=', $result->emp_id)
						->where('m.is_auto_increment', '=', 1)
						->first(); 
				if($inc_infos)
				{
					$inc_info = 1;
				}else{
					$inc_info = 0;
				}
				
				$pro_infos  = DB::table('tbl_master_tra as m')  
						->where('m.emp_id', '=', $result->emp_id)
						->where('m.is_auto_increment', '=', 4)
						->first(); 
						
				if($pro_infos)
				{
					$pro_info = 1;
				}else{
					$pro_info = 0;
				}
				
				$joining_date  = DB::table('tbl_emp_basic_info')  
						->where('emp_id', '=', $result->emp_id)
						->first(); 
				
				$inc = array(
					'emp_id' 				=> $result->emp_id,
					'emp_name'      		=> $result->emp_name_eng,
					'designatation_name'    => $data_result->designation_name,
					'branch_name'      		=> $data_result->branch_name,
					'joining_date'      	=> $joining_date->org_join_date,
					'salary_basic'      	=> $data_result->basic_salary,
					'is_incre'      		=> $inc_info,
					'in_prom'      			=> $pro_info
				);	
				
				DB::table('finance_data')->insert($inc);
				*/
		}
		}
		//print_r ($data['all_result']); exit;
		
		
		return view('admin.pages.reports.all_staff_report',$data);
    }
	
	public function BranchStaffIndex()
    {
        $data = array();
		$user_type 	= Session::get('user_type');
		$branch_code = Session::get('branch_code');
		$area_code = Session::get('area_code');
		$zone_code = Session::get('zone_code');
		$data['Heading'] = $data['title'] = 'Branch Wise Staff Report';
		
		if($user_type ==1 || $user_type ==11 || $user_type ==7 || $user_type ==6) {
			$data['br_code']	= '';	
			$data['form_date']	= date('Y-m-d');	
			$data['status']		= '';
			$data['branches'] 	= DB::table('tbl_branch')->where('status',1)->orderBy('branch_name', 'ASC')->get();
		} else if ($user_type ==5) {
			$data['br_code'] = $br_code = $branch_code;
			$data['form_date'] = $form_date = date('Y-m-d');
			$data['status'] = $status = 1;
			$data['Heading'] = '';
			$data['title'] = 'Branch Wise Staff Report';
			$data['branches'] = DB::table('tbl_branch')->orderBy('branch_name', 'ASC')->get();
			$all_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
							->where('m.br_code', '=', $data['br_code'])
							->where('m.br_join_date', '<=', $form_date)
							->where(function($query) use ($status, $form_date) {
									if($status ==1) {
										$query->whereNull('r.emp_id');
										$query->orWhere('r.effect_date', '>', $form_date);
									}
								})
							
							->select('m.emp_id')
							->groupBy('m.emp_id')
							->get()->toArray();
			//print_r($all_result);
			////////////////
			$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										->where('eas.br_code', '=', $data['br_code'])
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($status, $form_date) {
											if($status ==1) {
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date);
											}
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
					/* $max_sarok = DB::table('tbl_master_tra')
						->where('emp_id', '=', $result->emp_id)
						->where('br_join_date', '<=', $data['form_date'])
						->select('emp_id', DB::raw('max(br_join_date) as br_join_date'), DB::raw('max(sarok_no) as sarok_no'))
						->groupBy('emp_id')
						->first(); */
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
								->select('e.emp_name_eng','e.org_join_date','e.permanent_add','e.father_name','m.br_join_date','m.br_code','d.designation_name','b.branch_name','ea.incharge_as')
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
					if ($result_br_code == $data['br_code']) {	
						$data['all_result'][] = array(
							'emp_id' => $result->emp_id,
							'emp_name_eng'      => $data_result->emp_name_eng,
							'permanent_add'      => $data_result->permanent_add,
							'father_name'      => $data_result->father_name,
							'exam_name'      => $exam_name,
							'org_join_date'      => $data_result->org_join_date,
							'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
							'designation_name'      => $data_result->designation_name,
							'branch_name'      => $data_result->branch_name,
							'assign_designation'      => $asign_desig,
							'assign_open_date'      => $desig_open_date,
							'asign_branch_name'      => $asign_branch_name,
							'asign_area_name'      => $asign_area_name,
							'asign_open_date'      => $asign_open_date,
							'incharge_as'      => $data_result->incharge_as
							//'re_effect_date'      => $data_result->effect_date
						);
					}				
				}				
			}
		}
		
		return view('admin.pages.reports.branch_staff_report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function BranchStaffReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Branch Wise Staff Report';
		$data['br_code'] = $br_code = $request->input('br_code');
		$data['form_date'] = $form_date = $request->input('form_date');
		$data['status'] = $status = $request->input('status');
		$data['branches'] = DB::table('tbl_branch')->orderBy('branch_name', 'ASC')->get();
		$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.br_code', '=', $data['br_code'])
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
										->where('eas.br_code', '=', $data['br_code'])
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
		//$all_result1 = array_merge($all_result,$assign_branch);
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
				/* $max_sarok = DB::table('tbl_master_tra')
					->where('emp_id', '=', $result->emp_id)
					->where('br_join_date', '<=', $data['form_date'])
					->select('emp_id', DB::raw('max(br_join_date) as br_join_date'), DB::raw('max(sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first(); */
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
							->select('e.emp_name_eng','e.org_join_date','e.permanent_add','e.father_name','m.br_join_date','m.br_code','d.designation_name','b.branch_name','ea.incharge_as')
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
				if ($result_br_code == $data['br_code']) {	
					$data['all_result'][] = array(
						'emp_id' => $result->emp_id,
						'emp_name_eng'      => $data_result->emp_name_eng,
						'permanent_add'      => $data_result->permanent_add,
						'father_name'      => $data_result->father_name,
						'exam_name'      => $exam_name,
						'org_join_date'      => $data_result->org_join_date,
						'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
						'designation_name'      => $data_result->designation_name,
						'branch_name'      => $data_result->branch_name,
						'assign_designation'      => $asign_desig,
						'assign_open_date'      => $desig_open_date,
						'asign_branch_name'      => $asign_branch_name,
						'asign_area_name'      => $asign_area_name,
						'asign_open_date'      => $asign_open_date,
						'incharge_as'      => $data_result->incharge_as
						//'re_effect_date'      => $data_result->effect_date
					);
				}				
			}
			
		}
		//print_r ($data['all_result']);
		return view('admin.pages.reports.branch_staff_report',$data);
    }
	
	public function AreaStaffIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Area Wise Staff Report';
		$data['area_code']	= '';	
		$data['form_date']	= date('Y-m-d');
		$user_type 	= Session::get('user_type');
		$branch_code = Session::get('branch_code');
		$area_code = Session::get('area_code');
		$zone_code = Session::get('zone_code');
		if($user_type == 4) {
			$data['areas'] = DB::table('tbl_area')->where('status',1)->where('area_code', '=', $area_code)->get();
		} else if($user_type == 3) {
			$data['areas'] = DB::table('tbl_area')->where('status',1)->where('zone_code', '=', $zone_code)->get();
		} else {
			$data['areas'] = DB::table('tbl_area')->where('status',1)->get();
		}
				
		return view('admin.pages.reports.area_staff_report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function AreaStaffReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Area Wise Staff Report';
		$data['area_code'] 	= $request->input('area_code');
		$data['form_date'] 	= $form_date = $request->input('form_date');
		$user_type 	= Session::get('user_type');
		$branch_code = Session::get('branch_code');
		$area_code = Session::get('area_code');
		$zone_code = Session::get('zone_code');
		if($user_type == 4) {
			$data['areas'] = DB::table('tbl_area')->where('status',1)->where('area_code', '=', $area_code)->get();
		} else if($user_type == 3) {
			$data['areas'] = DB::table('tbl_area')->where('status',1)->where('zone_code', '=', $zone_code)->get();
		} else {
			$data['areas'] = DB::table('tbl_area')->where('status',1)->get();
		}
		$data['branches'] 	= DB::table('tbl_branch')->get();
		$all_result = DB::table('tbl_branch')
						->where('area_code', '=', $data['area_code'])
						->select('br_code')
						->get();
		//print_r ($all_result);
		foreach ($all_result as $result1) {
			$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.br_code', '=', $result1->br_code)
						->where('m.br_join_date', '<=', $data['form_date'])
						->Where(function($query) use ($form_date) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);								
								})
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get()->toArray();
						////////////////
			$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										->where('eas.br_code', '=', $result1->br_code)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($form_date) {
											$query->whereNull('r.emp_id');
											$query->orWhere('r.effect_date', '>', $form_date);
										})									
										->select('eas.emp_id')
										->get()->toArray();
			$all_result1 = array_unique(array_merge($data_result,$assign_branch), SORT_REGULAR);
			//print_r ($data_result);
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
						->groupBy('m.emp_id')
						->first();
						
					$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->select('e.emp_name_eng','e.org_join_date','e.permanent_add','m.br_code','m.br_join_date','d.designation_name','b.branch_name')
						->first();
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
								->where('ea.open_date', '<=', $data['form_date'])
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
					if ($result_br_code == $result1->br_code) {	
						$data['all_result'][] = array(
							'emp_id' => $result->emp_id,
							'emp_name_eng'      => $data_result->emp_name_eng,
							'permanent_add'      => $data_result->permanent_add,
							'exam_name'      => $exam_name,
							'org_join_date'      => $data_result->org_join_date,
							'br_code'      => $result_br_code,
							'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
							'designation_name'      => $data_result->designation_name,
							'branch_name'      => $data_result->branch_name,
							'assign_designation'      => $asign_desig,
							'assign_open_date'      => $desig_open_date,
							'asign_branch_name'      => $asign_branch_name,
							'asign_area_name'      => $asign_area_name,
							'asign_open_date'      => $asign_open_date
							//'re_effect_date'      => $data_result->effect_date
						);	
					}
				}
			}			
		}
		//print_r ($data['all_result']);
		return view('admin.pages.reports.area_staff_report',$data);
    }
	
	public function StaffTypeIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Staff Type Wise Report';
		$data['category_type']	= '';	
		$data['form_date']		= date('Y-m-d');	
		$data['status']			= '';
				
		return view('admin.pages.reports.staff_type_report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function StaffTypeReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Staff Type Wise Report';
		$data['category_type'] 	= $request->input('category_type');
		$data['form_date'] 		= $form_date = $request->input('form_date');
		$data['status'] 		= $status = $request->input('status');
		
		$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('e.emp_group', '=', 1)
						->where('m.is_permanent', '=', $data['category_type'])
						->where('m.letter_date', '<=', $form_date)
						->where(function($query) use ($status, $form_date) {
								if($status !=2) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);
								} else {
									$query->Where('r.effect_date', '<=', $form_date);
								}
							})
						->orderBy('m.emp_id', 'ASC')
						->select('m.emp_id')
						->groupBy('m.emp_id')
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
				$emp_id = $result->emp_id;				
				$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $result->emp_id)
						->where('m.letter_date', '=', function($query) use ($emp_id,$form_date)
								{
									$query->select(DB::raw('max(letter_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('letter_date', '<=', $form_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('m.emp_id')
						->first();
				//print_r($max_sarok);
				$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_probation as po', 'm.emp_id', '=', 'po.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->select('e.emp_id','e.emp_name_eng','e.org_join_date','e.permanent_add','m.br_join_date','m.br_code','m.basic_salary','m.next_increment_date','m.is_permanent','po.permanent_date','g.grade_name','d.designation_name','b.branch_name')
						->first();
				//print_r ($data_result);
				
				if($data_result->next_increment_date == '1970-01-01' || $data_result->next_increment_date == '1900-01-01') {
					$next_increment_date = '2019-07-01';
				} else {
					$next_increment_date = $data_result->next_increment_date;
				}
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
							->where('ea.open_date', '<=', $data['form_date'])
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
				////////
				if ($data_result->is_permanent == $data['category_type']) {	
					$data['all_result'][] = array(
						'emp_id' => $result->emp_id,
						'emp_name_eng'      => $data_result->emp_name_eng,
						'permanent_add'      => $data_result->permanent_add,
						'exam_name'      => $exam_name,
						'org_join_date'      => $data_result->org_join_date,
						'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
						'basic_salary'      => $data_result->basic_salary,
						'permanent_date'      => date('Y-m-d', strtotime("+6 months", strtotime($data_result->org_join_date))),
						'next_incremant_date'      => $next_increment_date,
						'is_permanent'      => $data_result->is_permanent,
						'grade_name'      => $data_result->grade_name,
						'designation_name'      => $data_result->designation_name,
						'branch_name'      => $data_result->branch_name,
						'assign_designation'      => $asign_desig,
						'assign_open_date'      => $desig_open_date,
						'asign_branch_name'      => $asign_branch_name,
						'asign_area_name'      => $asign_area_name,
						'asign_open_date'      => $asign_open_date
						//'re_effect_date'      => $data_result->effect_date
					);
				}				
			}
		}
		//print_r ($data['all_result']);
		return view('admin.pages.reports.staff_type_report',$data);
    }
	
	public function EmpStatusIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Employee Status Report';
		$data['emp_type']	= 1;	
		$data['emp_id']		= '';	
		$data['form_date']	= date('Y-m-d');
		$admin_id = Session::get('admin_id');
		$data['all_emp_type'] = DB::table('tbl_emp_type')
								->where(function($query) use ($admin_id) {
											if($admin_id == 20) {
												$query->where('id', '!=', 2);
											}
										})
								->get();
							
		return view('admin.pages.reports.employee_status_report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function EmpStatusReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Employee Status Report';
		//$data['emp_type'] 	= $emp_type = $request->input('emp_type');
		$data['emp_id'] 	= $emp_id 	= $request->input('emp_id');
		$data['form_date'] 	= $form_date = $request->input('form_date');
		$user_type 	= Session::get('user_type');
		$branch_code = Session::get('branch_code');
		$area_code = Session::get('area_code');
		$zone_code = Session::get('zone_code');
		$admin_id = Session::get('admin_id');
		$data['all_emp_type'] = DB::table('tbl_emp_type')
								->where(function($query) use ($admin_id) {
											if($admin_id == 20) {
												$query->where('id', '!=', 2);
											}
										})
								->get();
		if (!empty($emp_id)) {							
		
			$max_sarok = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $data['emp_id'])
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
			//echo $max_sarok->sarok_no;exit;
			if(!empty($max_sarok)) {
			$data['permanent_date'] = DB::table('tbl_master_tra')
					->where('emp_id', '=', $data['emp_id'])
					->where('tran_type_no', '=', 2)
					->select('effect_date')
					->first();
			$data['max_br_join_date'] = DB::table('tbl_master_tra as m')
					->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
					->where('m.emp_id', '=', $data['emp_id'])
					/* ->where('m.br_join_date', '>=', $data['form_date']) */
					->where('m.br_join_date', '>=', function($query) use ($emp_id,$form_date)
						{
							$query->select(DB::raw('max(br_join_date)'))
								  ->from('tbl_master_tra')
								  ->where('tran_type_no',8)
								  ->where('emp_id',$emp_id)
								  ->where('br_join_date', '>=', $form_date);
						})
					->select('m.emp_id','m.br_join_date','b.branch_name as br_name')
					->first();
			$get_marked = DB::table('tbl_mark_assign')
					->where('emp_id', '=', $emp_id)
					->where('open_date', '<=', $form_date)
					//->where('close_date', '=', '0000-00-00')
					//->orWhereNull('close_date')
					//->whereBetween('close_date',array('0000-00-00', 'IS NULL'))
					->where('status', 0)
					->select('marked_for')
					->get();
			if(!empty($get_marked)) {
				foreach ($get_marked as $marked) {
					if ($marked->marked_for =='Increment') {
						$data['increment_heldup'] = $marked->marked_for;
					}
					if ($marked->marked_for =='Promotion') {
						$data['promotion_heldup'] = $marked->marked_for;
					}
					if ($marked->marked_for =='Permanent') {
						$data['permanent_heldup'] = $marked->marked_for;
					}
				}
			}
			//print_r ($get_marked);		
			$all_result = DB::table('tbl_master_tra as m') 
								->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
								->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
								->leftJoin('tbl_emp_photo as ep', 'e.emp_id', '=', 'ep.emp_id')
								->leftJoin('tbl_department as dpt', 'm.department_code', '=', 'dpt.department_id')
								->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
								->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
								->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
								->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
								->leftJoin('tbl_zone as z', 'a.zone_code', '=', 'z.zone_code')
								->leftJoin('tbl_functional_designation as f', 'e.fun_desig_id', '=', 'f.id')
								->where('m.sarok_no', '=', $max_sarok->sarok_no)
								->where('m.emp_id', '=', $max_sarok->emp_id)
								->where(function($query) use ($user_type, $form_date) {
									if($user_type == 3 || $user_type == 4) {
										$query->whereNull('r.emp_id');
										$query->orWhere('r.effect_date', '>', $form_date);
									}
								})
								->select('e.emp_id','e.emp_name_eng','e.emp_name_ban','e.org_join_date','e.permanent_add','e.contact_num','ep.emp_photo','r.effect_date as re_effect_date','r.resignation_by','m.br_join_date','m.br_code','m.tran_type_no','d.designation_name','b.branch_name','g.grade_name','a.area_name','a.area_code','z.zone_code','z.zone_name','m.department_code','m.designation_code','f.fun_deg_name')
								->first();
								
			//print_r ($all_result); exit;					
								
								
								
								
				///////////// REPORTED-POLASH

				/* $br_code 		= $all_result->br_code;
				$designation_code 	= $all_result->designation_code;
				$department_code 	= $all_result->department_code;
				
				
				if($br_code ==9999)
				{
					$reported_to = DB::table('reported_to as to')
									->where('to.department', '=', $department_code)
									->select('to.*')
									->first();
									
					if($reported_to->reported_designation == $designation_code)
					{
						$dep_info = DB::table('tbl_department')
									->where('department_id', '=', $department_code)
									->select('*')
									->first();
						
						$report_to 						= $dep_info->dp_head_designation;
						$report_to_designation_code 	= $dep_info->dp_head_desig_code;
						$report_to_new 					= $dep_info->dp_head_emp_id;
						$report_to_emp_type 			= $dep_info->dp_emp_type;
						
					}
					else{
						$report_to 						= $reported_to->designation_name;
						$report_to_designation_code 	= $reported_to->reported_designation;
						$report_to_new 					= $reported_to->reported_emp_id;
						$report_to_emp_type 			= $reported_to->emp_type;
					}
									
					
					
					$data['reported_to'] = $report_to_new.'/'.$report_to_emp_type.'/'.$report_to_designation_code.'/'.$report_to ; 

				}
				else
				{
					$reported_to = DB::table('tbl_designation')
									->where('designation_code', '=', $designation_code)
									->select('*')
									->first();
					if($reported_to)
					{
						$report_to 						= $reported_to->reported_designation;
						$report_to_designation_code 	= $reported_to->to_reported;
						$report_to_new 					= 0;
						$report_to_emp_type 			= $reported_to->reported_emp_type;
					}
					else
					{
						$report_to 						= 'Branch Manager';
						$report_to_designation_code 	= 24;
						$report_to_new 					= 0;
						$report_to_emp_type 			= 1;
					}
					
					$data['reported_to'] = $report_to.'/'.$reported_to->reported_emp_type.'/'.$report_to_designation_code;
					
				} */
				
				
				
				

			////////////
								
								
								
								
								
								
								
			if($user_type == 4) {
				if($area_code == $all_result->area_code) {
					$data['all_result'] = $all_result;
				} else {
					$data['all_result'] = array();
				}
			} else if ($user_type == 3) {
				if($zone_code == $all_result->zone_code) {
					$data['all_result'] = $all_result;
				} else {
					$data['all_result'] = array();
				}
			} else if ($user_type == 5) {
				if($branch_code == $all_result->br_code) {
					$data['all_result'] = $all_result;
				} else {
					$data['all_result'] = array();
				}
			} else {
				$data['all_result'] = $all_result;
			}
			//print_r ($data['all_result']); exit;
			/* Area Duration Calculation */
			if(!empty($all_result->area_code)) {
			$area_get_date = DB::table('tbl_branch as b')
										->leftJoin('tbl_master_tra as m', 'b.br_code', '=', 'm.br_code')
										->where('m.emp_id', '=', $emp_id)
										->where('b.area_code',$all_result->area_code)
										->select('b.br_code','b.area_code',DB::raw('max(m.br_join_date) as area_max_join_date'),DB::raw('min(m.br_join_date) as area_min_join_date'))
										->first();
			$area_getdate = DB::table('tbl_branch as b')
										->leftJoin('tbl_master_tra as m', 'b.br_code', '=', 'm.br_code')
										->where('m.emp_id', '=', $emp_id)
										->where('b.area_code', '!=', $all_result->area_code)
										->where('m.br_join_date', '>', $area_get_date->area_min_join_date)
										->where('m.br_join_date', '<', $area_get_date->area_max_join_date)
										->select('b.br_code','b.area_code',DB::raw('max(m.br_join_date) as area_join_date'))
										->first();
			//print_r($area_get_date);
			//print_r($area_getdate);
				if(empty($area_getdate->area_join_date)) {
					$data['area_joindate'] = $area_get_date->area_min_join_date;
				} else {
					$data['area_joindate'] = $area_get_date->area_max_join_date;
				}
			}
			/* Area Duration Calculation */
			/* assign information */
				$data['assign_emp'] = DB::table('tbl_emp_assign as ea')
										->where('ea.emp_id',$emp_id)
										->where('ea.status', '!=', 0)
										->where('ea.select_type', '=', 1)
										->select('ea.emp_id','ea.open_date','ea.incharge_as')
										->first();
				$data['assign_branch'] = DB::table('tbl_emp_assign as ea')
										->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code')
										->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
										->leftJoin('tbl_zone as z', 'ar.zone_code', '=', 'z.zone_code')
										->where('ea.emp_id',$emp_id)
										->where('ea.open_date', '<=', $form_date)
										->where('ea.status', '!=', 0)
										->where('ea.select_type', '=', 2)
										->select('ea.emp_id','ea.open_date','ea.br_code','br.branch_name','ar.area_name','z.zone_name')
										->first();
				$data['assign_report_to'] = DB::table('tbl_emp_assign as ea')
										->where('ea.emp_id',$emp_id)
										->where('ea.status', '!=', 0)
										->where('ea.select_type', '=', 4)
										->select('ea.emp_id','ea.open_date','ea.incharge_as')
										->first();
				$data['assign_designation'] = DB::table('tbl_emp_assign as ea')
										->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
										->where('ea.emp_id',$emp_id)
										->where('ea.status', '!=', 0)
										->where('ea.select_type', '=', 5)
										->select('ea.emp_id','ea.open_date','de.designation_name')
										->first();
				/* assign information */
				/* File Status Information */
				$data['file_status'] = DB::table('tbl_fp_file_info as fp')
										->Leftjoin('tbl_emp_basic_info as sei', 'fp.sender_emp_id', '=', 'sei.emp_id')
										->Leftjoin('tbl_emp_basic_info as ei', 'fp.receiver_emp_id', '=', 'ei.emp_id')
										->where('fp.fp_emp_id',$emp_id)
										//->where('fp.emp_type', '=', $emp_type)
										//->where('fp.status', '=', 1)
										->orderBy('fp.id', 'DESC')
										->select('fp.receiver_emp_id','ei.emp_name_eng as re_emp_name','fp.sender_emp_id','sei.emp_name_eng as se_emp_name','fp.status','fp.file_type','fp.entry_date')
										->first();
				//print_r($data['file_status']);						
				$data['fp_status'] = DB::table('tbl_edms_document')
										->where('emp_id',$emp_id)
										//->where('emp_type', '=', $emp_type)
										->where('category_id', '=', 21)
										->where('subcat_id', '=', 69)
										//->count();
										->select('document_id','emp_id','emp_type','effect_date')
										->first();
				//print_r($data['file_status']);
			}
		}
		return view('admin.pages.reports.employee_status_report',$data);
    }
	
	public function StaffJoiningIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Staff Joining Report';
		$data['form_date']	= '';	
		$data['to_date']	= '';	
		$data['order_by']	= '';
				
		return view('admin.pages.reports.staff_joining_report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function StaffJoiningReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Staff Joining Report';
		$data['form_date'] 	= $request->input('form_date');
		$data['to_date'] 	= $request->input('to_date');
		$data['order_by'] 	= $request->input('order_by');
		
		$all_result = DB::table('tbl_emp_basic_info')
						//->where('emp_type', '=', 'regular')
						->where('org_join_date', '>=', $data['form_date'])
						->where('org_join_date', '<=', $data['to_date'])
						->select('emp_id')
						->groupBy('emp_id')
						->get();
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
				$max_sarok = DB::table('tbl_master_tra')
					->where('emp_id', '=', $result->emp_id)
					->where('br_join_date', '<=', $data['to_date'])
					->select('emp_id', DB::raw('max(letter_date) as letter_date'), DB::raw('max(sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
					
				$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_district as dt', 'e.district_code', '=', 'dt.district_code')
						->leftJoin('tbl_thana as t', 'e.thana_code', '=', 't.thana_code')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->where('m.sarok_no', '=', @$max_sarok->sarok_no)
						->select('e.emp_name_eng','e.org_join_date','e.permanent_add','dt.district_name','t.thana_name','m.br_join_date','m.designation_code','d.designation_name','b.branch_name','a.area_name','g.grade_name')
						->first();
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
								->where('ea.open_date', '>=', $data['form_date'])
								->where('ea.open_date', '<=', $data['to_date'])
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
				////////
				
				$data['all_result'][] = array(
					'emp_id' => $result->emp_id,
					'emp_name_eng'      => @$data_result->emp_name_eng,
					'permanent_add'      => @$data_result->permanent_add,
					'exam_name'      => $exam_name,
					'org_join_date'      => @$data_result->org_join_date,
					'district_name'      => @$data_result->district_name,
					'thana_name'      => @$data_result->thana_name,
					'br_joined_date'      => @$data_result->br_join_date,
					'designation_name'      => @$data_result->designation_name,
					'designation_code'      => @$data_result->designation_code,
					'branch_name'      => @$data_result->branch_name,
					'area_name'      => @$data_result->area_name,
					'grade_name'      => @$data_result->grade_name,
					'assign_designation'      => $asign_desig,
					'assign_open_date'      => $desig_open_date,
					'asign_branch_name'      => $asign_branch_name,
					'asign_area_name'      => $asign_area_name,
					'asign_open_date'      => $asign_open_date
					
				);	
			}
		}
		$data['all_designation'] = DB::table('tbl_designation')->get();
		//print_r ($data['all_result']);
		return view('admin.pages.reports.staff_joining_report',$data);
    }
	
	public function DistrictStaffIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'District Wise Staff Report';
		$data['district_code']	= '';	
		$data['status']			= '';
		$data['all_district'] 	= DB::table('tbl_district')->get();
				
		return view('admin.pages.reports.district_staff_report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function DistrictStaffReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'District Wise Staff Report';
		$data['district_code'] 	= $district_code = $request->input('district_code');
		$data['status'] = $status 	= $request->input('status');
		$data['all_district'] 	= DB::table('tbl_district')->get();
		$data['all_thana'] 		= DB::table('tbl_thana')->get();
		$form_date = date('Y-m-d');
		$all_result = DB::table('tbl_emp_basic_info as e')
						->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
						->leftJoin(DB::raw("(SELECT emp_id,max(letter_date) as letter_date, max(sarok_no) as sarok_no
							FROM tbl_master_tra GROUP BY emp_id) as mt"), function($join) {
							$join->on('mt.emp_id', '=', 'e.emp_id');							
							})
						->leftJoin('tbl_master_tra as mt1', function($join){
								$join->on('e.emp_id','=','mt1.emp_id')
								->on('mt.sarok_no','=','mt1.sarok_no');
							})
						->leftJoin('tbl_designation as d', 'mt1.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'mt1.br_code', '=', 'b.br_code')
						/* ->where(function($query) use ($district_code) {
								if($district_code !='all') {
									$query->where('e.district_code', $district_code);
								}
							}) */						
						//->where('e.emp_type', "regular")
						->where('e.org_join_date', '<=', $form_date)
						->where('e.district_code', $district_code)
						->where(function($query) use ($status, $form_date) {
								if($status == 1) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);
								} elseif ($status == 2) {
									$query->where('r.effect_date', '<=', $form_date);
								}/*  elseif ($status == 'all') {
									$query->whereNull('r.emp_id');
									$query->whereNotNull('r.emp_id');
								} */
							})
						->orderBy('e.emp_id', 'ASC')
						->select('e.emp_id','e.emp_name_eng','e.father_name','e.permanent_add','e.district_code','e.thana_code','e.org_join_date','mt.sarok_no','mt.letter_date','mt1.basic_salary','mt1.br_join_date','d.designation_name','b.branch_name')
						->get();
		//print_r ($all_result);
		foreach ($all_result as $result) {
			
			$data['all_result'][] = array(
				'emp_id' => $result->emp_id,
				'emp_name_eng'      => $result->emp_name_eng,
				'permanent_add'      => $result->permanent_add,
				'father_name'      => $result->father_name,
				'org_join_date'      => $result->org_join_date,
				'thana_code'      => $result->thana_code,
				'district_code'      => $result->district_code,
				'designation_name'      => $result->designation_name,
				'br_join_date'      => $result->br_join_date,
				'designation_name'      => $result->designation_name,
				'branch_name'      => $result->branch_name,
				'basic_salary'      => $result->basic_salary
			);
		}
		//print_r ($data['all_result']);
		return view('admin.pages.reports.district_staff_report',$data);
    }
	
	public function StaffJoinDropIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Staff Join & Dropout Report';
		$data['desig_group_code']	= '';	
		$data['form_date']			= '';
		$data['to_date']			= '';
		$data['date_within']		= date('Y-m-d');
		$data['designation_group'] 	= DB::table('tbl_designation_group')->where('status',1)->orderBy('desig_group_code', 'ASC')->get();
				
		return view('admin.pages.reports.staff_join_drop_report',$data);
    }
	
	public function StaffJoinDropReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Staff Join & Dropout Report';
		$data['desig_group_code'] 	= $desig_group_code = $request->input('desig_group_code');
		$data['form_date'] 			= $request->input('form_date');
		$data['to_date'] 			= $request->input('to_date');
		$data['date_within'] 		= $request->input('date_within');
		
		$data['designation_group'] 	= DB::table('tbl_designation_group')->where('status',1)->orderBy('desig_group_code', 'ASC')->get();
		$data['all_designation'] = $all_designation_code 		= DB::table('tbl_designation')->get();
		
		$all_designation_code = DB::table('tbl_designation')
						->where(function($query) use ($desig_group_code) {
								if($desig_group_code !='all') {
									$query->where('designation_group_code', $desig_group_code);
								} else {
									$query->where('status',1);
								}
							})
						->select('designation_code')
						->get();
		//print_r ($all_result);				
		if(!empty($all_designation_code)) {
			$all_join_emp = DB::table('tbl_emp_basic_info as e')
							->leftjoin('tbl_master_tra as mt',function($join){
								$join->on("e.emp_id","=","mt.emp_id") 
									->where('mt.sarok_no',DB::raw("(SELECT 
											max(tbl_master_tra.sarok_no) FROM tbl_master_tra 
											where e.emp_id = tbl_master_tra.emp_id and tbl_master_tra.letter_date = (SELECT 
											max(t.letter_date) FROM tbl_master_tra as t where e.emp_id = t.emp_id)
											)") 		 
										); 	
										
									})
									
							->where('e.org_join_date', '>=', $data['form_date'])
							->where('e.org_join_date', '<=', $data['to_date'])
							->orderBy('e.emp_id', 'ASC')
							->select('e.emp_id','mt.sarok_no','mt.letter_date','mt.designation_code')
							->get();
			foreach ($all_join_emp as $all_emp) {
				foreach ($all_designation_code as $all_des_code) {
					if ($all_emp->designation_code == $all_des_code->designation_code) {
						$data['designation_count1'][] = array($all_emp->designation_code);
					}						
				}
				
				$all_resign_emp_id = DB::table('tbl_resignation')
						->where('emp_id', '=', $all_emp->emp_id)
						->where('effect_date', '>=', $data['form_date'])
						->where('effect_date', '<=', $data['to_date'])
						->get();
				//print_r ($all_resign_emp_id);	exit;	
				if(!empty($all_resign_emp_id)) {
					foreach ($all_resign_emp_id as $all_resign_emp) {
						foreach ($all_designation_code as $all_des_code) {
							if ($all_resign_emp->designation_code == $all_des_code->designation_code) {
								$data['designation_count3'][] = array($all_resign_emp->designation_code);
							}						
						}
					}
				}
			}
			//print_r($data['designation_count3']);
			$all_re_emp_id = DB::table('tbl_resignation as r')							
							/* ->leftjoin('tbl_master_tra as mt',function($join){
								$join->on("r.emp_id","=","mt.emp_id") 
									->where('mt.sarok_no',DB::raw("(SELECT 
											max(tbl_master_tra.sarok_no) FROM tbl_master_tra 
											where r.emp_id = tbl_master_tra.emp_id and tbl_master_tra.letter_date = (SELECT 
											max(t.letter_date) FROM tbl_master_tra as t where r.emp_id = t.emp_id)
											)") 		 
										); 	
										
									}) */
								
							->where('r.effect_date', '>=', $data['form_date'])
							->where('r.effect_date', '<=', $data['to_date'])
							->orderBy('r.emp_id', 'ASC')
							->select('r.emp_id','r.designation_code')
							->get();
		
			foreach ($all_re_emp_id as $all_re_emp) {
				foreach ($all_designation_code as $all_des_code) {
					if ($all_re_emp->designation_code == $all_des_code->designation_code) {
						$data['designation_count2'][] = array($all_re_emp->designation_code);
					}						
				}
			}

			$max_sarok = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.letter_date', '<=', $data['date_within'])
						->where('m.br_join_date', '<=', $data['date_within'])
						->where('m.effect_date', '<=', $data['date_within'])
						->whereNull('r.emp_id')
						->orWhere('r.effect_date', '>', $data['date_within'])
						->select('m.emp_id', DB::raw('max(m.letter_date) as letter_date'), DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('m.emp_id')
						->get();
			foreach ($max_sarok as $as_sarok) {
				$data_result = DB::table('tbl_master_tra')
						->where('sarok_no', '=', $as_sarok->sarok_no)
						->select('designation_code')
						->first();
				foreach ($all_designation_code as $all_des_code) {
					if ($data_result->designation_code == $all_des_code->designation_code) {
						$data['designation_count'][] = array($data_result->designation_code);
					}						
				}
			}
			//print_r ($data['designation_count']);
			/* Total Strength */
			if (!empty($data['designation_count'])) {
			$data['designation_group_total'] = array_count_values(array_column($data['designation_count'], 0));
			}
			/* Total Joining (New Staff) */
			if (!empty($data['designation_count1'])) {
			$data['designation_group_total1'] = array_count_values(array_column($data['designation_count1'], 0));
			}
			/* Total Resign */
			if (!empty($data['designation_count2'])) {
			$data['designation_group_total2'] = array_count_values(array_column($data['designation_count2'], 0));
			}
			/* New Staff Resign (Who Join from date-to date) */
			if (!empty($data['designation_count3'])) {
			$data['designation_group_total3'] = array_count_values(array_column($data['designation_count3'], 0));
			}
				
		}
		//print_r ($data['designation_group_total2']); 				
		//exit;
		
		return view('admin.pages.reports.staff_join_drop_report',$data);
    }
	
	public function DesignationStaffIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Designation-Wise Staff Report';
		$data['emp_type']	= 1;
		$data['form_date']		= date('Y-m-d');
		$data['designation_code']		= '';
		$data['order_by']		= '';
		$data['all_designation'] 		= DB::table('tbl_designation')->where('status',1)->get();
		$data['all_emp_type'] 	= DB::table('tbl_emp_type')->where('status', 1)->get();
		
		return view('admin.pages.reports.designation_staff_report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function DesignationStaffReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Designation-Wise Staff Report';
		$data['emp_type'] 		= $emp_type = $request->input('emp_type');
		$data['form_date'] 		= $form_date = $request->input('form_date');
		$data['designation_code'] 	= $designation_code = $request->input('designation_code');
		$data['order_by'] 		= $request->input('order_by');
		$data['all_emp_type'] 	= DB::table('tbl_emp_type')->where('status', 1)->get();
		//$data['all_designation'] 	= DB::table('tbl_designation')->where('status',1)->get();
		$data['all_designation'] = DB::table('tbl_designation')
					  ->where(function($query) use ($emp_type) {
									if(!($emp_type == 1 || $emp_type == 2)) {
										$query->where('emp_type_designation_group',$emp_type);
										$query->where('status',1);
									} else {
										$query->where('status',1);
									}
								})
                      ->get();
					  
			$all_result1 = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
							->where('m.br_join_date', '<=', $form_date)
							->where(function($query) use ($designation_code, $form_date) {
									if($designation_code !='all') {
										$query->where('m.designation_code', '=', $designation_code);
										$query->whereNull('r.emp_id');
										$query->orWhere('r.effect_date', '>', $form_date);
									} else {
										$query->whereNull('r.emp_id');
										$query->orWhere('r.effect_date', '>', $form_date);
									}
								})
							->select('m.emp_id')
							->groupBy('m.emp_id')
							->get()->toArray();	
			$all_result2 = DB::table('tbl_emp_assign as ea')
										->leftJoin('tbl_resignation as r', 'ea.emp_id', '=', 'r.emp_id')
										->where(function($query) use ($designation_code, $form_date) {
											if($designation_code !='all') {
												$query->where('ea.designation_code', '=', $designation_code);
											}
										})
										->where('ea.status', '!=', 0)
										->where('ea.select_type', '=', 5)
										->whereNull('r.emp_id')
										->orWhere('r.effect_date', '>', $form_date)										
										->select('ea.emp_id')
										->get()->toArray();
			$all_result = array_unique(array_merge($all_result1,$all_result2), SORT_REGULAR);
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
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->leftJoin('tbl_emp_assign as ea', function($join){
									//$join->where('ea.status', 1)
									$join->whereBetween('ea.status',array(1,2))
										->on('m.emp_id', '=', 'ea.emp_id');
								})
						->where('m.sarok_no', '=', @$max_sarok->sarok_no)
						->select('e.emp_name_eng','e.org_join_date',DB::raw("(SELECT COUNT(tran_type_no) FROM tbl_promotion
									WHERE emp_id = $result->emp_id
									AND effect_date < '$form_date') as total"),'m.emp_id','m.grade_code','m.designation_code','m.basic_salary','m.total_pay','m.net_pay','m.grade_effect_date','m.next_increment_date','m.is_permanent','m.tran_type_no','g.grade_name','d.designation_name','ea.open_date','ea.incharge_as')
						->first();
						
						
					////////// print for branch information ///////////
					$max_sarok_br = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', @$result->emp_id)
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
					$data_result1 = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->leftJoin('tbl_branch as br', 'm.salary_br_code', '=', 'br.br_code')
						->where('m.sarok_no', '=', @$max_sarok_br->sarok_no)
						->select('m.br_join_date','b.branch_name','br.branch_name as salary_branch_name')
						->first();
					////////////////////
					$max_sarok_sa = DB::table('tbl_emp_salary as sa')
								->where('sa.emp_id', '=', @$result->emp_id)
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
									->where('emp_id', '=', @$max_sarok_sa->emp_id)
									->where('id', '=', @$max_sarok_sa->id_no)
									->select('emp_id','salary_basic','total_plus','payable','net_payable','gross_total')
									->first();
						}			
						//print_r ($max_sarok_sa);//exit;
						if(!empty($salary)) {
							$bs_salary = $salary->salary_basic;
							$total_salary = $salary->payable;
							$net_salary = $salary->net_payable;
							$total_plus = $salary->total_plus;
							$gross_total = $salary->gross_total;
						}

					//}
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
					
					//// employee assign ////
					$assign_designation = DB::table('tbl_emp_assign as ea')
									->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
									->where('ea.emp_id', $result->emp_id)
									->where('ea.open_date', '<=', $form_date)
									->where('ea.status', '!=', 0)
									->where('ea.select_type', '=', 5)
									->select('ea.emp_id','ea.open_date','ea.designation_code','de.designation_name')
									->first();
					//print_r($assign_designation);				
					if(!empty($assign_designation)) {
						$result_designation_code = $assign_designation->designation_code;
						$asign_desig = $assign_designation->designation_name;
						$desig_open_date = $assign_designation->open_date;
					} else {
						$result_designation_code = @$data_result->designation_code;
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
					////////
					if ($designation_code == 'all') {	
						$data['all_result'][] = array(
							'emp_id' => @$data_result->emp_id,
							'emp_name_eng'      => @$data_result->emp_name_eng,
							'exam_name'      => $exam_name,
							'org_join_date'      => date('d M Y',strtotime(@$data_result->org_join_date)),
							'basic_salary'      => $bs_salary,
							'total_pay'      => $total_salary,
							'net_pay'      => $net_salary,
							'total_plus'      => $total_plus,
							'gross_total'      => $gross_total,
							'next_designation_code'      => $result_designation_code,
							'grade_code'      => @$data_result->grade_code,
							'grade_name'      => @$data_result->grade_name,
							'br_join_date'      => date('d M Y',strtotime(@$data_result1->br_join_date)),
							'grade_effect_date'      => date('d M Y',strtotime(@$data_result->grade_effect_date)),
							'c_end_date'      => ((@$data_result->next_increment_date != '')) ? date('d M Y',strtotime(@$data_result->next_increment_date)) : '-',
							'total'      => @$data_result->total,
							'permanent_provision'      => @$data_result->is_permanent,
							'designation_name'      => @$data_result->designation_name,
							'branch_name'      => @$data_result1->branch_name,
							'incharge_as'      => @$data_result->incharge_as,
							'open_date'      => @$data_result->open_date,
							'increment_marked'    	=> $increment_mark,
							'promotion_marked'    	=> $promotion_mark,
							'permanent_marked'    	=> $permanent_mark,
							'asign_branch_name'    	=> $asign_branch_name,
							'asign_area_name'    	=> $asign_area_name,
							'asign_open_date'    	=> $asign_open_date,
							'asign_desig'    		=> $asign_desig,
							'desig_open_date'    	=> $desig_open_date,
							'salary_branch_name'    => @$data_result1->salary_branch_name,
							'tran_type_no'    => @$data_result->tran_type_no
						);
					} else {
						if ($result_designation_code == $designation_code) {	
							$data['all_result'][] = array(
								'emp_id' => $data_result->emp_id,
								'emp_name_eng'      => $data_result->emp_name_eng,
								'exam_name'      => $exam_name,
								'org_join_date'      => date('d M Y',strtotime($data_result->org_join_date)),
								'basic_salary'      => $bs_salary,
								'total_pay'      => $total_salary,
								'net_pay'      => $net_salary,
								'total_plus'      => $total_plus,
								'gross_total'      => $gross_total,
								'next_designation_code'      => $data_result->designation_code,
								'grade_code'      => $data_result->grade_code,
								'grade_name'      => $data_result->grade_name,
								'br_join_date'      => date('d M Y',strtotime($data_result1->br_join_date)),
								'grade_effect_date'      => date('d M Y',strtotime($data_result->grade_effect_date)),
								'c_end_date'      => (($data_result->next_increment_date != '')) ? date('d M Y',strtotime($data_result->next_increment_date)) : '-',
								'total'      => $data_result->total,
								'permanent_provision'      => $data_result->is_permanent,
								'designation_name'      => $data_result->designation_name,
								'branch_name'      => $data_result1->branch_name,
								'incharge_as'      => $data_result->incharge_as,
								'open_date'      => $data_result->open_date,
								'increment_marked'    	=> $increment_mark,
								'promotion_marked'    	=> $promotion_mark,
								'permanent_marked'    	=> $permanent_mark,
								'asign_branch_name'    	=> $asign_branch_name,
								'asign_area_name'    	=> $asign_area_name,
								'asign_open_date'    	=> $asign_open_date,
								'asign_desig'    		=> $asign_desig,
								'desig_open_date'    	=> $desig_open_date,
								'salary_branch_name'    => $data_result1->salary_branch_name,
								'tran_type_no'    => $data_result->tran_type_no
							);
						}
					}				
				}
			}
		//}
		//print_r ($data['all_result']); //exit;
		return view('admin.pages.reports.designation_staff_report',$data);
    }
	
	public function EmpTypeDesignation($emp_type)
    {  
		$all_designation = DB::table('tbl_designation')
					  ->where(function($query) use ($emp_type) {
									if(!($emp_type == 1 || $emp_type == 2)) {
										$query->where('emp_type_designation_group',$emp_type);
									}
								})
                      ->get();
		echo "<option value=''>--Select--</option>";
		if($emp_type == 1 || $emp_type == 2) {
		echo "<option value='all'>All</option>";
		}
		foreach($all_designation as $designation){
			echo "<option value='$designation->designation_code'>$designation->designation_name</option>";
		}
    }
	
	public function AmBmStaffIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'AM & BM Staff Report';
		$data['form_date']		= date('Y-m-d');
		$data['am_bm_code']		= '';
				
		return view('admin.pages.reports.am_bm_staff_report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function AmBmStaffReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'AM & BM Staff Report';
		$data['form_date'] 		= $form_date = $request->input('form_date');
		$data['am_bm_code'] 	= $am_bm_code = $request->input('am_bm_code');
		
		$data['all_area'] 		= DB::table('tbl_area')->get();
		$data['all_zone'] 		= DB::table('tbl_zone')->get();
		
		$all_designation_code = DB::table('tbl_designation')
								->where('designation_group_code', '=', $am_bm_code)
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
										->leftJoin('tbl_thana as t', 'e.thana_code', '=', 't.thana_code')
										->leftJoin('tbl_district as dt', 'e.district_code', '=', 'dt.district_code')
										->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
										->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
										->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
										->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
										->leftJoin('tbl_zone as z', 'a.zone_code', '=', 'z.zone_code')
										->leftJoin(DB::raw("(SELECT emp_id,max(level_id) as level_id
											FROM tbl_emp_edu_info GROUP BY emp_id) as em"),
											'em.emp_id','=','e.emp_id')
										->where('m.emp_id', '=', $desig_nation->emp_id)
										->where('m.sarok_no', '=', $desig_nation->sarok_no)
										->select('m.emp_id','m.br_code','e.emp_name_eng','e.org_join_date','m.br_join_date','m.grade_effect_date','t.thana_name','dt.district_name','em.level_id','d.designation_name','g.grade_name','b.branch_name','a.area_code','a.area_name','z.zone_code')
										->first();
						
						//print_r($result_data);
							if (!empty($result_data->level_id)) {
								$exam_result = DB::table('tbl_emp_edu_info as ed')
									->leftJoin('tbl_exam_name as en', 'ed.exam_code', '=', 'en.exam_code')
									->where('ed.emp_id', '=', $result_data->emp_id)
									->where('ed.level_id', '=', $result_data->level_id)
									->select('en.exam_name')
									->first();
									//print_r ($exam_result);
									$exam_name = $exam_result->exam_name;
							} else {
								$exam_name = '';
							}
							if(empty($result_data->zone_code) && empty($result_data->area_name)) {
								$data['am_bm_staff'][] = array(
								'emp_id' => $result_data->emp_id,
								'emp_name_eng'      => $result_data->emp_name_eng,
								'thana_name'      => $result_data->thana_name,
								'district_name'      => $result_data->district_name,
								'exam_name'      => $exam_name,
								'org_join_date'      => date('d M Y',strtotime($result_data->org_join_date)),
								'grade_name'      => $result_data->grade_name,
								'br_join_date'      => date('d M Y',strtotime($result_data->br_join_date)),
								'grade_effect_date'      => date('d M Y',strtotime($result_data->grade_effect_date)),
								'designation_name'      => $result_data->designation_name,
								'branch_name'      => $result_data->branch_name,
								'area_code'      => '',
								'zone_code'      => '',
								'area_name'      => $result_data->area_name,
								'grade_name'      => $result_data->grade_name
							);
							} else {
							$data['all_result'][] = array(
								'emp_id' => $result_data->emp_id,
								'emp_name_eng'      => $result_data->emp_name_eng,
								'thana_name'      => $result_data->thana_name,
								'district_name'      => $result_data->district_name,
								'exam_name'      => $exam_name,
								'org_join_date'      => date('d M Y',strtotime($result_data->org_join_date)),
								'grade_name'      => $result_data->grade_name,
								'br_join_date'      => date('d M Y',strtotime($result_data->br_join_date)),
								'grade_effect_date'      => date('d M Y',strtotime($result_data->grade_effect_date)),
								'designation_name'      => $result_data->designation_name,
								'branch_name'      => $result_data->branch_name,
								'area_code'      => $result_data->area_code,
								'zone_code'      => $result_data->zone_code,
								'area_name'      => $result_data->area_name,
								'grade_name'      => $result_data->grade_name
							);
							}
						}
						
					}
				
				}
			}
		
		}
				
		//print_r ($data['all_result']); exit;
		
		
		//print_r ($data['all_result']); //exit;
		return view('admin.pages.reports.am_bm_staff_report',$data);
    }
	
	public function AllTotalIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'All total Staff Report';
		$data['form_date']	= date('Y-m-d');
		$data['status']		= 1;
		$data['emp_group']		= '';
		$data['emp_type']		= '';
		$data['all_emp_group'] 		= DB::table('tbl_emp_group')->get();
		$data['all_emp_type'] 		= array();
				
		return view('admin.pages.reports.all_total_staff_report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function AllTotalReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'All Total Staff Report';
		$data['form_date'] 		= $form_date = $request->input('form_date');
		$data['status'] 		= $status = $request->input('status');
		$data['emp_group'] 	= $emp_group = $request->input('emp_group');
		$data['emp_type'] 	= $emp_type = $request->input('emp_type');
		$data['all_emp_group'] 		= DB::table('tbl_emp_group')->get();
		
		if($emp_type){
			$data['all_emp_type'] = DB::table('tbl_emp_type')
					  ->where('type_id', $emp_group)
					  ->where('status', 1) 					  
                      ->get();
			$all_result = DB::table('tbl_emp_basic_info as e')
						->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
						->where('e.emp_group', '=', $emp_group)
						->where('e.emp_type', '=', $emp_type)
						->where('e.org_join_date', '<=', $data['form_date'])
						
						->where(function($query) use ($status, $form_date) {
								if($status == 1) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);
								} elseif ($status == 0) {
									$query->where('r.effect_date', '<=', $form_date);
								}								
							})

						->orderBy('e.emp_id', 'ASC')
						->select('e.emp_id','r.effect_date')
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
					->leftJoin('tbl_subject as sb', 'ed.subject_code', '=', 'sb.subject_code')
					->where('ed.emp_id', '=', $max_exam->emp_id)
					->where('ed.level_id', '=', $max_exam->level_id)
					->select('en.exam_name','sb.subject_name')
					->first();
					//print_r ($exam_result);
					$exam_name = $exam_result->exam_name;
					$subject_name = $exam_result->subject_name;
				} else {
					$exam_name = '';
					$subject_name = '';
				}
				$emp_id = $result->emp_id;				
				$max_sarok = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $result->emp_id)
					->where('m.letter_date', '=', function($query) use ($emp_id,$form_date)
							{
								$query->select(DB::raw('max(letter_date)'))
									  ->from('tbl_master_tra')
									  ->where('emp_id',$emp_id)
									  ->where('letter_date', '<=', $form_date);
							})
					->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
					->groupBy('m.emp_id')
					->first();
				//print_r ($max_sarok); //exit;
				$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_resignation as re', 'm.emp_id', '=', 're.emp_id')
						->leftJoin('tbl_thana as th', 'e.thana_code', '=', 'th.thana_code')
						->leftJoin('tbl_district as dt', 'e.district_code', '=', 'dt.district_code')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->leftJoin('tbl_emp_assign as ea', function($join){
									//$join->where('ea.status', 1)
									$join->whereBetween('ea.status',array(1,2))
										->on('m.emp_id', '=', 'ea.emp_id');
								})
						->where('m.sarok_no', '=', @$max_sarok->sarok_no)
						->select('e.emp_name_eng','e.father_name','e.mother_name','e.org_join_date','e.birth_date','e.contact_num','e.religion','e.gender','e.maritial_status','e.blood_group','e.national_id','e.permanent_add','e.emp_group', DB::raw("(SELECT COUNT(tran_type_no) FROM tbl_promotion
									WHERE emp_id = $result->emp_id
                                AND effect_date < '$form_date') as total"), DB::raw("(SELECT COUNT(id) FROM tbl_punishment
                                WHERE emp_id = $result->emp_id AND status = 1
                                AND punishment_type = '1') as total_warning"),DB::raw("(SELECT COUNT(id) FROM tbl_punishment
                                WHERE emp_id = $result->emp_id  AND status = 1
                                AND punishment_type = '2') as total_fine"),DB::raw("(SELECT COUNT(id) FROM tbl_punishment
                                WHERE emp_id = $result->emp_id  AND status = 1
                                AND punishment_type = '4') as total_censure"),DB::raw("(SELECT COUNT(id) FROM tbl_punishment
                                WHERE emp_id = $result->emp_id  AND status = 1
                                AND punishment_type = '3') as total_strong_warning"),'m.emp_id','m.grade_code','m.designation_code','m.basic_salary','m.total_pay','m.net_pay','m.br_join_date','m.grade_effect_date','m.is_permanent','m.tran_type_no','th.thana_name','dt.district_name','g.grade_name','d.designation_name','b.branch_name','a.area_name','re.effect_date as re_effect_date','ea.open_date','ea.incharge_as')
						->first();
						
						
				/* $salary = DB::table('tbl_master_tra')
							->where('emp_id', '=', $data_result->emp_id)
							->where('basic_salary', '=', $data_result->basic_salary)
							->where('net_pay', '>', 0)
							->select('emp_id','basic_salary','total_pay','net_pay')
							->first(); */
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
				//print_r ($max_sarok_sa);//exit;
				if(!empty($max_sarok_sa)) {
				$salary = DB::table('tbl_emp_salary')
							->where('emp_id', '=', $max_sarok_sa->emp_id)
							->where('id', '=', $max_sarok_sa->id_no)
							->select('emp_id','salary_basic','total_plus','payable','net_payable','gross_total','transection')
							->first();
				}			
				if(!empty($salary)) {
					$bs_salary = $salary->salary_basic;
					$total_salary = $salary->payable;
					$net_salary = $salary->net_payable;
					$total_plus = $salary->total_plus;
					$gross_total = $salary->gross_total;
					$transection = $salary->transection;
				} else {
					$bs_salary = '';
					$total_salary = '';
					$net_salary = '';
					$total_plus = '';
					$gross_total = '';
					$transection = 1;
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
				////////
			if(!empty($data_result)){
				$data['all_result'][] = array(
					'emp_id' => @$data_result->emp_id,
					'emp_name_eng'      => @$data_result->emp_name_eng,
					'father_name'      => @$data_result->father_name,
					'mother_name'      => @$data_result->mother_name,
					'birth_date'      => @$data_result->birth_date,
					'religion'      => @$data_result->religion,
					'contact_num'      => @$data_result->contact_num,
					'national_id'      => @$data_result->national_id,
					'gender'      => @$data_result->gender,
					'blood_group'      => @$data_result->blood_group,
					'maritial_status'      => @$data_result->maritial_status,
					'permanent_add'      => @$data_result->permanent_add,
					'thana_name'      => @$data_result->thana_name,
					'district_name'      => @$data_result->district_name,
					'emp_group'      => @$data_result->emp_group,
					'exam_name'      => $exam_name,
					'subject_name'      => $subject_name,
					'org_join_date'      => date('d M Y',strtotime(@$data_result->org_join_date)),
					'basic_salary'      => $bs_salary,
					'total_pay'      => $total_salary,
					'net_pay'      => $net_salary,
					'total_plus'      => $total_plus,
					'gross_total'      => $gross_total,
					'transection'      => $transection,
					'next_designation_code'      => @$data_result->designation_code,
					'grade_code'      => @$data_result->grade_code,
					'grade_name'      => @$data_result->grade_name,
					'br_join_date'      => date('d M Y',strtotime(@$data_result->br_join_date)),
					'grade_effect_date'      => date('d M Y',strtotime(@$data_result->grade_effect_date)),
					'total'      => @$data_result->total,
					'is_permanent'      => @$data_result->is_permanent,
					'designation_name'      => @$data_result->designation_name,
					'branch_name'      => @$data_result->branch_name,
					'area_name'      => @$data_result->area_name,
					'increment_marked'    	=> $increment_mark,
					'promotion_marked'    	=> $promotion_mark,
					'permanent_marked'    	=> $permanent_mark,
					'total_warning'      => @$data_result->total_warning,
					'total_fine'      => @$data_result->total_fine,
					'total_censure'      => @$data_result->total_censure,
					'total_strong_warning'      => @$data_result->total_strong_warning,
					're_effect_date'      => @$data_result->re_effect_date,
					'tran_type_no'      => @$data_result->tran_type_no,
					'assign_designation'      => $asign_desig,
					'assign_open_date'      => $desig_open_date,
					'asign_branch_name'      => $asign_branch_name,
					'asign_area_name'      => $asign_area_name,
					'asign_open_date'      => $asign_open_date,
					'incharge_as'      => @$data_result->incharge_as,
					'open_date'      => @$data_result->open_date,
				);				
			}
			}
		}
		}
		
		//print_r ($data['all_result']); //exit;
		return view('admin.pages.reports.all_total_staff_report',$data);
    }
	
	public function BasicSalaryIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Basic Salary Wise Report';
		$data['basic_salary']	= '';	
		$data['form_date']		= date('Y-m-d');		
		return view('admin.pages.reports.basic_salary_report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function BasicSalaryReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Basic Salary Wise Report';
		$data['basic_salary'] 	= $basic_salary = $request->input('basic_salary');
		$data['form_date'] 		= $form_date = $request->input('form_date');
		
		$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->whereNull('r.emp_id')
						->orWhere('r.effect_date', '>', $form_date)
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
										  ->where('letter_date', '<=', $form_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('m.emp_id')
						->first();
				//print_r ($max_sarok);
				$data_result = DB::table('tbl_master_tra as m')
					->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
					->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
					->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
					->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
					->where('m.sarok_no', '=', $max_sarok->sarok_no)
					->select('e.emp_name_eng','e.org_join_date','m.emp_id','m.grade_code','m.designation_code','m.basic_salary','m.total_pay','m.net_pay','m.br_join_date','m.effect_date','m.grade_effect_date','g.grade_name','d.designation_name','b.branch_name')
					->first();

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
							//->where('salary_basic', '=', $data_result->basic_salary)
							//->where('net_pay', '>', 0)
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
				
				if ($basic_salary == $bs_salary) {	
					$data['all_result'][] = array(
						'emp_id' => $data_result->emp_id,
						'emp_name_eng'      => $data_result->emp_name_eng,
						'exam_name'      => $exam_name,
						'org_join_date'      => date('d M Y',strtotime($data_result->org_join_date)),
						'basic_salary'      => $bs_salary,
						'total_pay'      => $total_salary,
						'net_pay'      => $net_salary,
						'total_plus'      => $total_plus,
						'next_designation_code'      => $data_result->designation_code,
						'grade_code'      => $data_result->grade_code,
						'grade_name'      => $data_result->grade_name,
						'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
						'grade_effect_date'      => date('d M Y',strtotime($data_result->grade_effect_date)),
						'effect_date'      => date('d M Y',strtotime($data_result->effect_date)),
						'designation_name'      => $data_result->designation_name,
						'branch_name'      => $data_result->branch_name
					);
				}
								
			}
		}
		//print_r ($data['all_result']);
		return view('admin.pages.reports.basic_salary_report',$data);
    }
	
	public function TransferHistoryIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'Transfer History';
		$data['emp_id']	 = '';
				
		return view('admin.pages.reports.transfer_history_report',$data);
    }
    
	public function TransferHistoryReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Transfer History';
		$data['form_date']	= $form_date = date('Y-m-d');
		$data['emp_id']  = $emp_id = $request->input('emp_id');
		
		$max_sarok = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $emp_id)
					->where('m.letter_date', '=', function($query) use ($emp_id,$form_date)
						{
							$query->select(DB::raw('max(letter_date)'))
								  ->from('tbl_master_tra')
								  ->where('emp_id',$emp_id)
								  ->where('br_join_date', '<=', $form_date);
						})
					->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
					->groupBy('m.emp_id')
					->first();
		if(!empty($max_sarok)) {
			$data['emp_data'] = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
							->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_appointment_info as a', 'm.emp_id', '=', 'a.emp_id')
							->leftJoin('tbl_branch as b', 'a.joining_branch', '=', 'b.br_code')
							->leftJoin('tbl_area as ar', 'b.area_code', '=', 'ar.area_code')
							->leftJoin('tbl_designation as de', 'a.emp_designation', '=', 'de.designation_code')
							->where('m.emp_id', '=', $emp_id)
							->where('m.sarok_no', '=', $max_sarok->sarok_no)
							->select('e.emp_id','e.emp_name_eng','e.org_join_date','a.joining_date','b.branch_name','ar.area_name','d.designation_name','de.designation_name as app_emp_designation','r.effect_date as re_effect_date','r.resignation_by')
							->first();
		
			//print_r ($data['emp_data']);
			$data['first_transfer'] = DB::table('tbl_transfer as tr')
						->leftjoin('tbl_branch as br', 'tr.br_code', '=', 'br.br_code')
						->leftJoin('tbl_area as a', 'br.area_code', '=', 'a.area_code')
						->leftJoin('tbl_designation as d', 'tr.designation_code', '=', 'd.designation_code')
						->select('tr.id','tr.br_joined_date','br.branch_name','a.area_name','d.designation_name')
						->where('tr.emp_id',$emp_id) 
						->where('tr.br_joined_date', '<=', $form_date)
						->orderBy('tr.br_joined_date', 'asc')
						->first();
			$results = DB::table('tbl_transfer as tr')
						->leftjoin('tbl_branch as br', 'tr.br_code', '=', 'br.br_code')
						->leftJoin('tbl_area as a', 'br.area_code', '=', 'a.area_code')
						->select('tr.id','tr.br_joined_date','br.branch_name','a.area_name')
						->where('tr.emp_id',$emp_id) 
						->where('tr.br_joined_date', '<=', $form_date)
						->orderBy('tr.br_joined_date', 'asc')
						->get();
		
			foreach ($results as $result) {
			$data['results'][] = array(
					'id'      => $result->id,
					'br_joined_date' => $result->br_joined_date,
					'branch_name' => $result->branch_name,
					'area_name' => $result->area_name
				);
			}
		}
		//print_r ($data['results']); exit;
		return view('admin.pages.reports.transfer_history_report',$data);
		
	}
	
	public function DistrictTotalStaffIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'District wise no of Staff';
		$data['form_date']	 = date('Y-m-d');
		$data['status']	 = '';
				
		return view('admin.pages.reports.district_no_staff',$data);
    }
    
	public function DistrictTotalStaffReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'District wise Staff Number';
		$data['form_date']  = $form_date = $request->input('form_date');
		$data['status']  = $status = $request->input('status');
		$all_district = DB::table('tbl_district')->get();
		foreach ($all_district as $district) {
			$result = DB::table('tbl_emp_basic_info as e')
						->leftJoin('tbl_district as d', 'e.district_code', '=', 'd.district_code')
						->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
						//->where('e.emp_type', '=', 'regular')
						->where('e.org_join_date', '<=', $form_date)
						->where('e.district_code', '=', $district->district_code)
						
						->where(function($query) use ($status, $form_date) {
								if($status == 1) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);
								} elseif ($status == 2) {
									$query->where('r.effect_date', '<=', $form_date);
								}/*  elseif ($status == 'all') {
									$query->whereNull('r.emp_id');
									$query->whereNotNull('r.emp_id');
								} */
							})

						->select('e.district_code','d.district_name',DB::raw('COUNT(e.id) as total_count'))
						->first();

			$data['all_result'][] = array(
					'district_name' => $result->district_name,
					'total_count'      => $result->total_count
				);
					
		}
		//print_r($data['all_result']);
		return view('admin.pages.reports.district_no_staff',$data);
		
	}
	
	public function FinalClearenceIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'Final Clearence';
		$data['date_within'] = $date_within = date('Y-m-d');		
		
		$all_result = DB::table('tbl_resignation as r')
							->leftJoin('tbl_emp_basic_info as e', 'r.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'r.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'r.br_code', '=', 'b.br_code')
							->leftJoin('tbl_edms_document as ed', 'r.emp_id', '=', 'ed.emp_id')
							->leftJoin('tbl_edms_subcategory as eds', 'ed.subcat_id', '=', 'eds.subcat_id')
							->leftJoin('tbl_fp_file_info as ffi', 'r.emp_id', '=', 'ffi.fp_emp_id')
							->where('ed.subcat_id', '=', 64)
							->where('ed.category_id', '=', 21)
							->whereNull('ffi.fp_emp_id')
							->orderBy('r.effect_date', 'desc')
							->groupBy('ed.emp_id')
							->select('r.emp_id','r.effect_date','e.emp_name_eng','e.org_join_date','ed.effect_date as ed_effect_date','d.designation_name','b.branch_name','eds.subcategory_name')
							->get();
		//print_r($all_result);
		foreach($all_result as $result) {
			$result_emp = DB::table('tbl_edms_document')
							->where('emp_id', $result->emp_id)
							->where('subcat_id', '=', 69)
							->where('category_id', '=', 21)
							->select('emp_id')
							->first();
			if(empty($result_emp)) {
				$result_emp_id = '';
			} else {
				$result_emp_id = $result_emp->emp_id;
			}				
			//print_r($result_emp);//exit;
			if($result->emp_id != $result_emp_id) {
				$data['all_result'][] = array(
						'emp_id' => $result->emp_id,
						'emp_name_eng'      => $result->emp_name_eng,
						'ed_effect_date'      => date('d M Y',strtotime($result->ed_effect_date)),
						'effect_date'      => date('d M Y',strtotime($result->effect_date)),
						'designation_name'      => $result->designation_name,
						'branch_name'      => $result->branch_name
					);
			}				
		}
		//print_r ($data['all_result']);
		return view('admin.pages.reports.final_clearence_report',$data);
    }
    
	public function FinalClearenceReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Financial Clearence';
		$data['date_within'] = $date_within = date('Y-m-d');		
		
		$data['results'] = DB::table('tbl_resignation as r')
							->leftJoin('tbl_emp_basic_info as e', 'r.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'r.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'r.br_code', '=', 'b.br_code')
							->leftJoin('tbl_edms_document as ed', 'r.emp_id', '=', 'ed.emp_id')
							->leftJoin('tbl_edms_subcategory as eds', 'ed.subcat_id', '=', 'eds.subcat_id')
							->where('ed.subcat_id', '=', 64)
							->where('ed.category_id', '=', 21)
							->orderBy('r.effect_date', 'desc')
							->select('r.emp_id','r.effect_date','e.emp_name_eng','e.org_join_date','ed.effect_date as ed_effect_date','d.designation_name','b.branch_name','eds.subcategory_name')
							->get();
		
		//print_r ($data['results']);
		return view('admin.pages.reports.final_clearence_report',$data);
		
	}
	
	public function AreaStaffNoIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Area Wise Staff Number';
		$data['area_code']	= '';	
		$data['form_date']	= date('Y-m-d');
		$data['all_area'] 		= DB::table('tbl_area')->where('status',1)->get();
		$data['all_branch'] 	= DB::table('tbl_branch')->get();
		$data['all_emp_type'] 	= DB::table('tbl_emp_type')->where('status', 1)->get();
			
		return view('admin.pages.reports.area_wise_staff_no',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function AreaStaffNoReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Area Wise Staff Number';
		$data['area_code'] = $area_code	= $request->input('area_code');
		$data['form_date'] 	= $form_date = $request->input('form_date');
		$data['all_area'] 	= DB::table('tbl_area')->where('status',1)->get();
		$data['all_emp_type'] 	= DB::table('tbl_emp_type')->where('status', 1)->get();
		if(!empty($area_code)) {	
		$data['get_area'] 	= DB::table('tbl_area')->where('area_code', $area_code)->first();
		$all_result = $data['all_branch'] = DB::table('tbl_branch')
						//->where('area_code', '=', $data['area_code'])
						->where(function($query) use ($area_code) {
								if($area_code !='all') {
									$query->where('area_code', $area_code);
								}
							})
						->select('br_code','area_code','branch_name')
						->get();
		//print_r ($all_result);
		foreach ($all_result as $result1) {
			$data['all_result'] =  array();
			$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.br_code', '=', $result1->br_code)
						->where('m.br_join_date', '<=', $data['form_date'])
						->Where(function($query) use ($form_date) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);								
								})
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get()->toArray();
						////////////////
			$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										->where('eas.br_code', '=', $result1->br_code)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($form_date) {
											$query->whereNull('r.emp_id');
											$query->orWhere('r.effect_date', '>', $form_date);
										})									
										->select('eas.emp_id')
										->get()->toArray();
			$all_result1 = array_unique(array_merge($data_result,$assign_branch), SORT_REGULAR);
			//print_r ($data_result);
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
					//print_r($max_sarok);
					$data_result = DB::table('tbl_master_tra')
								->where('sarok_no', '=', $max_sarok->sarok_no)
								->select('emp_id','br_code')
								->first();
					//// employee assign ////
					$assign_branch = DB::table('tbl_emp_assign')
										->where('emp_id', $result->emp_id)
										->where('open_date', '<=', $form_date)
										->where('status', '!=', 0)
										->where('select_type', '=', 2)
										->select('emp_id','br_code')
										->first();
					if(!empty($assign_branch)) {
						$result_br_code = $assign_branch->br_code;
					} else {
						$result_br_code = $data_result->br_code;
					}
					////////
					if ($result1->br_code == $result_br_code) {	
						$data['all_result'][] = array(
							'emp_type' => 1,
							'br_code'      => $result_br_code
						);	
					}
				}
				
				$nonid_result = DB::table('tbl_emp_non_id as en')
							->leftjoin('tbl_nonid_official_info as noi',function($join) use($form_date){
								$join->on("en.emp_id","=","noi.emp_id") 
										->where('noi.sarok_no',DB::raw("(SELECT 
												  max(tbl_nonid_official_info.sarok_no)
												  FROM tbl_nonid_official_info 
												   where en.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
												  max(t.joining_date)
												  FROM tbl_nonid_official_info as t 
												   where en.emp_id = t.emp_id AND t.joining_date <=  '$form_date')
												  )") 		 
											); 		
										})
							->leftJoin('tbl_emp_non_id_cancel as nc', 'en.emp_id', '=', 'nc.emp_id')
							->where('noi.br_code', '=', $result1->br_code)
							->Where('noi.joining_date', '<=', $form_date)
							->Where(function($query) use ($form_date) {
									$query->whereNull('nc.emp_id');
									$query->orWhere('nc.cancel_date', '>', $form_date);								
								})
							->select('en.emp_type_code','noi.br_code')
							->get();
				
				foreach ($nonid_result as $nonid_br) {
					$data['all_result'][] = array(
							'emp_type' => $nonid_br->emp_type_code,
							'br_code'      => $nonid_br->br_code
					);
				}
				
			}
			//print_r($data['all_result']);

			if (!empty($data['all_result'])) {
				$data['all_result_total'] = array_count_values(array_column($data['all_result'], 'emp_type'));
			}
				
			foreach($data['all_result_total'] as $key => $value) {
				$data['all_result2'][] = array(
							'br_code'      => $result1->br_code,
							'emp_type'      => $key,
							'emp_type_value' => $value
				);
			}
			
		}
		}		
		//print_r ($data['all_result2']);
		return view('admin.pages.reports.area_wise_staff_no',$data);
    }
	
	public function FileMoveReportIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'File Movement Report';
		$data['form_date']	 = date('Y-m-d');
		$data['emp_id']	 = '';		
		return view('admin.pages.reports.file_movement_report',$data);
    }
    
	public function FileMoveReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'File Movement Report';
		$data['emp_id']  = $emp_id = $request->input('emp_id');
		$data['all_result'] = DB::table('tbl_fp_file_info as fp')		
								  ->leftjoin('tbl_fp_file_info as fp1',function($join) use($emp_id){
												$join->on("fp.fp_emp_id","=","fp1.fp_emp_id")
													->where('fp1.id',DB::raw("(SELECT 
																				  max(tbl_fp_file_info.id)
																				  FROM tbl_fp_file_info 
																				  where fp1.fp_emp_id = tbl_fp_file_info.fp_emp_id
																				  )") 		 
															); 
														})	
														
								->leftJoin('tbl_emp_basic_info as e', function($join)
										{
											$join->on('fp1.fp_emp_id', '=', 'e.emp_id');

										})
								->where('fp1.receiver_emp_id',$emp_id)
								->where('fp1.status', '!=', 3)
								->orderBy('fp1.emp_type', 'ASC')								
								->orderBy('fp1.fp_emp_id', 'ASC')								
								->groupBy('fp1.fp_emp_id')
								->select('fp1.receiver_emp_id','e.emp_name_eng','fp1.fp_emp_id','fp1.emp_type','fp1.status','fp1.file_type','fp1.entry_date')
								->get();
		//print_r($data['all_result']);
		return view('admin.pages.reports.file_movement_report',$data);
		
	}
	
	public function BranchDesignationIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Branch Wise Designation Report';
		$data['emp_type']	= '';
		$data['form_date']		= date('Y-m-d');
		$data['designation_code']		= '';
		$data['br_code']		= '';
		$data['all_designation'] 		= array();
		$data['branches'] 	= DB::table('tbl_branch')->where('status',1)->orderBy('branch_name', 'ASC')->get();
		$data['all_emp_type'] 	= DB::table('tbl_emp_type')->where('id', '!=', 1)->where('id', '!=', 2)->where('status', 1)->get();
		
		return view('admin.pages.reports.branch_designation_report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function BranchDesignationReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Branch Wise Designation Report';
		$data['emp_type'] 		= $emp_type = $request->input('emp_type');
		$data['form_date'] 		= $form_date = $request->input('form_date');
		$data['designation_code'] 	= $designation_code = $request->input('designation_code');
		$data['br_code'] 	= $br_code = $request->input('br_code');
		$data['all_emp_type'] 	= DB::table('tbl_emp_type')->where('id', '!=', 1)->where('id', '!=', 2)->where('status', 1)->get();
		//$data['all_designation'] 	= DB::table('tbl_designation')->where('status',1)->get();
		$data['branches'] 	= DB::table('tbl_branch')->where('status',1)->orderBy('branch_name', 'ASC')->get();
		
		if ($emp_type != 1) {
			$data['all_designation'] = DB::table('tbl_designation')
					  ->where(function($query) use ($emp_type) {
									if(!($emp_type == 1 || $emp_type == 2)) {
										$query->where('emp_type_designation_group',$emp_type);
									}
								})
                      ->get();
			$all_nonid_emp = DB::table('tbl_emp_non_id as en')
							->leftjoin('tbl_nonid_official_info as noi',function($join) use($form_date){
								$join->on("en.emp_id","=","noi.emp_id") 
										->where('noi.sarok_no',DB::raw("(SELECT 
																				  max(tbl_nonid_official_info.sarok_no)
																				  FROM tbl_nonid_official_info 
																				   where en.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
																				  max(t.joining_date)
																				  FROM tbl_nonid_official_info as t 
																				   where en.emp_id = t.emp_id AND t.joining_date <=  '$form_date')
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
							->where('en.emp_type_code', '=', $emp_type)
							->where('noi.designation_code', '=', $designation_code)
							->where('noi.br_code', '=', $br_code)
							->orderBy('en.sacmo_id', 'ASC')
							->select('en.emp_id','en.emp_name','en.sacmo_id','en.last_education','en.joining_date','noi.next_renew_date','noi.br_join_date','noi.end_type','noi.c_end_date','nos.gross_salary','d.designation_name','b.branch_name','a.area_name')
							->get();
			
			foreach ($all_nonid_emp as $nonid_emp) { 
				if($nonid_emp->end_type == 1){
					$c_end_date = date('d M Y',strtotime($nonid_emp->c_end_date));
				} else {
					$c_end_date = 'Project Running';
				}
				$data['all_result'][] = array(
					'emp_id' => $nonid_emp->emp_id,
					'emp_name_eng'      => $nonid_emp->emp_name,
					'sacmo_id'      => $nonid_emp->sacmo_id,
					'exam_name'      => $nonid_emp->last_education,
					'org_join_date'      => date('d M Y',strtotime($nonid_emp->joining_date)),
					'br_join_date'      => date('d M Y',strtotime($nonid_emp->br_join_date)),
					'c_end_date'      => $c_end_date,
					'total_pay'      => $nonid_emp->gross_salary,
					'designation_name'      => $nonid_emp->designation_name,
					'branch_name'      => $nonid_emp->branch_name
				);
			}
		}
		//print_r ($data['all_result']); //exit;
		return view('admin.pages.reports.branch_designation_report',$data);
    }
	
	public function DepartmentStaffIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Department-Wise Staff Report';
		$data['form_date']		= date('Y-m-d');
		$data['department_code']		= '';
		$data['type_id']		= 1;
		$data['all_department'] 		= DB::table('tbl_department')->where('status',1)->get();
		
		return view('admin.pages.reports.department_staff_report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function DepartmentStaffReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Department-Wise Staff Report';
		$data['form_date'] 		= $form_date = $request->input('form_date');
		$data['department_code'] 	= $department_code = $request->input('department_code');
		$data['type_id'] 	= $type_id = $request->input('type_id');
		$data['all_department'] 	= DB::table('tbl_department')->where('status',1)->get();
		
			/* $all_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
							//->where('m.department_code', '=', $designation_code)
							->where(function($query) use ($department_code, $form_date) {
										$query->where('m.br_join_date', '<=', $form_date);
										$query->where('m.department_code', '=', $department_code);
								})
							->whereNull('r.emp_id')
							->orWhere('r.effect_date', '>', $form_date)
							//->orderBy('m.designation_code', 'ASC')
							->select('m.emp_id')
							->groupBy('m.emp_id')
							->get(); */
			$all_result = DB::select(DB::raw("SELECT e.emp_id FROM tbl_emp_mapping as e left join tbl_resignation as r ON e.emp_id = r.emp_id WHERE (r.emp_id IS NULL OR r.effect_date > '$form_date') AND e.current_department_id = $department_code AND ((e.start_date <= '$form_date' AND e.end_date >= '$form_date') OR (e.start_date <= '$form_date' AND (e.end_date IS NULL OR e.end_date = '0000-00-00')))"));
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
									->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
									->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
									->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
									->leftJoin('tbl_branch as br', 'm.salary_br_code', '=', 'br.br_code')
									->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
									->leftJoin('tbl_emp_assign as ea', function($join){
												//$join->where('ea.status', 1)
												$join->whereBetween('ea.status',array(1,2))
													->on('m.emp_id', '=', 'ea.emp_id');
											})
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->where(function($query) use ($type_id) {
														if($type_id == 1) {
															$query->where('m.br_code', 9999);
														} else if($type_id == 2) {
															$query->where('m.br_code', '!=', 9999);
														}								
													})
									->select('e.emp_name_eng','e.org_join_date',DB::raw("(SELECT COUNT(tran_type_no) FROM tbl_promotion
												WHERE emp_id = $result->emp_id
												AND effect_date < '$form_date') as total"),'m.emp_id','m.grade_code','m.designation_code','m.department_code','m.basic_salary','m.total_pay','m.net_pay','m.br_join_date','m.grade_effect_date','m.is_permanent','m.tran_type_no','g.grade_name','d.designation_name','d.priority','b.branch_name','br.branch_name as salary_branch_name','ea.open_date','ea.incharge_as')
									->first();
					if(!empty($data_result)) {
					$emp_id = $result->emp_id;
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

					//}
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
					
					//// employee assign ////
					$assign_designation = DB::table('tbl_emp_assign as ea')
									->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
									->where('ea.emp_id', $result->emp_id)
									->where('ea.open_date', '<=', $form_date)
									->where('ea.status', '!=', 0)
									->where('ea.select_type', '=', 5)
									->select('ea.emp_id','ea.open_date','ea.designation_code','de.designation_name')
									->first();
					//print_r($assign_designation);				
					if(!empty($assign_designation)) {
						$result_designation_code = $assign_designation->designation_code;
						$asign_desig = $assign_designation->designation_name;
						$desig_open_date = $assign_designation->open_date;
					} else {
						$result_designation_code = $data_result->designation_code;
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
					////////
						//if ($data_result->department_code == $department_code) {	
							$data['all_result'][] = array(
								'emp_id' => $data_result->emp_id,
								'emp_name_eng'      => $data_result->emp_name_eng,
								'exam_name'      => $exam_name,
								'org_join_date'      => date('d M Y',strtotime($data_result->org_join_date)),
								'basic_salary'      => $bs_salary,
								'total_pay'      => $total_salary,
								'net_pay'      => $net_salary,
								'total_plus'      => $total_plus,
								'next_designation_code'      => $data_result->designation_code,
								'grade_code'      => $data_result->grade_code,
								'grade_name'      => $data_result->grade_name,
								'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
								'grade_effect_date'      => date('d M Y',strtotime($data_result->grade_effect_date)),
								'total'      => $data_result->total,
								'permanent_provision'      => $data_result->is_permanent,
								'designation_name'      => $data_result->designation_name,
								'designation_priority'      => $data_result->priority,
								'branch_name'      => $data_result->branch_name,
								'incharge_as'      => $data_result->incharge_as,
								'open_date'      => $data_result->open_date,
								'increment_marked'    	=> $increment_mark,
								'promotion_marked'    	=> $promotion_mark,
								'permanent_marked'    	=> $permanent_mark,
								'asign_branch_name'    	=> $asign_branch_name,
								'asign_area_name'    	=> $asign_area_name,
								'asign_open_date'    	=> $asign_open_date,
								'asign_desig'    		=> $asign_desig,
								'desig_open_date'    	=> $desig_open_date,
								'salary_branch_name'    => $data_result->salary_branch_name,
								'tran_type_no'    => $data_result->tran_type_no
							);
						//}
					}				
				}
			}
		
		//print_r ($data['all_result']); //exit;
		return view('admin.pages.reports.department_staff_report',$data);
    }
	
	public function BranchViewReport()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Branch View';
		$data['all_zone'] = $all_zone = DB::table('tbl_zone')->get();
		$data['all_area'] = $all_area = DB::table('tbl_area')->get();
		
		$all_data = DB::table('tbl_area as a')
						->leftJoin('tbl_branch as b', 'a.area_code', '=', 'b.area_code')
						->leftJoin('tbl_zone as z', 'a.zone_code', '=', 'z.zone_code')
						->where('b.br_code', '!=', 9999)
						->select('a.zone_code','a.area_code','a.area_name_bn','z.zone_name_bn',DB::raw("GROUP_CONCAT(b.br_name_bangla SEPARATOR ', ') as `br_names`"))
						->orderBy('z.zone_code')
						->groupBy('a.area_code')
						->get();
			//print_r ($all_data);
		if(!empty($all_data)) {
			foreach ($all_data as $alldata) {			
				//$br_code = $alldata->br_code;
				$am_name_branch = DB::table('tbl_admin as ad')
									->leftJoin('tbl_branch as b', 'ad.branch_code', '=', 'b.br_code')
									->leftJoin('tbl_emp_basic_info as e', 'ad.emp_id', '=', 'e.emp_id')
									//->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
									->where('b.area_code', '=', $alldata->area_code)
									->where('ad.user_type', '=', 4)
									->where('ad.status', '=', 1)
									->select('b.area_code','b.br_name_bangla as am_br_name','e.emp_id as am_emp_id','e.emp_name_ban')
									->first();
				$dm_name_branch = DB::table('tbl_admin as ad')
									->leftJoin('tbl_branch as b', 'ad.branch_code', '=', 'b.br_code')
									->leftJoin('tbl_emp_basic_info as e', 'ad.emp_id', '=', 'e.emp_id')
									//->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
									->where('b.zone_code', '=', $alldata->zone_code)
									->where('ad.user_type', '=', 3)
									->where('ad.status', '=', 1)
									->select('b.area_code','b.br_name_bangla as dm_br_name','e.emp_id as dm_emp_id','e.emp_name_ban')
									->first();
				if(!empty($am_name_branch) && !empty($dm_name_branch)) {
				//foreach ($am_name_branch as $branch) {
					//if($alldata->area_code = $branch->area_code) {
						$data['all_result'][] = array(
						'zone_code'      => $alldata->zone_code,
						'zone_name'      => $alldata->zone_name_bn,
						'area_name'      => $alldata->area_name_bn,
						'area_all_br_name'      => $alldata->br_names,
						'am_emp_id'      => $am_name_branch->am_emp_id,
						'am_emp_name'      => $am_name_branch->emp_name_ban,
						'am_br_name'      => $am_name_branch->am_br_name,
						'dm_emp_name'      => $dm_name_branch->emp_name_ban,
						'dm_br_name'      => $dm_name_branch->dm_br_name,
						'dm_emp_id'      => $dm_name_branch->dm_emp_id
					);
					//}
				//}
				}
			}
		}
		
		
		//////////////////////////////
		
		return view('admin.pages.reports.branch_view_report',$data);
    }
	
	public function ProgramStaffIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Department-Wise Staff Report';
		$data['form_date']		= date('Y-m-d');
		$data['program_id']		= '';
		$data['department_id']	= '';
		$data['unit_id']		= '';
		$data['project_id']		= '';
		$data['type_id']		= 1;
		$data['all_department'] 		= DB::table('tbl_department')->where('status',1)->get();
		$data['all_unit_name'] 		= DB::table('tbl_unit_name')->where('status',1)->get();
		$data['all_project'] 		= DB::table('tbl_project')->where('status',1)->get();
		
		return view('admin.pages.reports.program_staff_report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function ProgramStaffReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Department-Wise Staff Report';
		$data['form_date'] 		= $form_date = $request->input('form_date');
		$data['program_id'] 	= $program_id = $request->input('program_id');
		$data['department_id'] 	= $department_id = $request->input('department_id');
		$data['unit_id'] 	= $unit_id = $request->input('unit_id');
		$data['project_id'] 	= $project_id = $request->input('project_id');
		$data['type_id'] 	= $type_id = $request->input('type_id');
		$data['all_department'] 	= DB::table('tbl_department')->where('status',1)->get();
		//$data['all_unit_name'] 		= DB::table('tbl_unit_name')->where('status',1)->get();
		$data['all_project'] 		= DB::table('tbl_project')->where('status',1)->get();
		$data['all_unit_name'] = DB::table('tbl_unit_name')->where('department_code',$department_id)->get();
			/* $all_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
							//->where('m.department_code', '=', $designation_code)
							->where(function($query) use ($department_code, $form_date) {
										$query->where('m.br_join_date', '<=', $form_date);
										$query->where('m.department_code', '=', $department_code);
								})
							->whereNull('r.emp_id')
							->orWhere('r.effect_date', '>', $form_date)
							//->orderBy('m.designation_code', 'ASC')
							->select('m.emp_id')
							->groupBy('m.emp_id')
							->get(); */
							
			$cond = "";			
			if(!empty($program_id) && empty($department_id) && empty($unit_id) && empty($project_id) && !empty($type_id)){
				$cond="WHERE (r.emp_id IS NULL OR r.effect_date > '$form_date') AND e.current_program_id = $program_id AND ((e.start_date <= '$form_date' AND e.end_date >= '$form_date') OR (e.start_date <= '$form_date' AND (e.end_date IS NULL OR e.end_date = '0000-00-00')))";
			} else if(!empty($program_id) && !empty($department_id) && empty($unit_id) && empty($project_id) && !empty($type_id)) {
				$cond="WHERE (r.emp_id IS NULL OR r.effect_date > '$form_date') AND e.current_program_id = $program_id AND e.current_department_id = $department_id AND ((e.start_date <= '$form_date' AND e.end_date >= '$form_date') OR (e.start_date <= '$form_date' AND (e.end_date IS NULL OR e.end_date = '0000-00-00')))";
			} else if(!empty($program_id) && !empty($department_id) && !empty($unit_id) && empty($project_id) &&!empty($type_id)) {
				$cond="WHERE (r.emp_id IS NULL OR r.effect_date > '$form_date') AND e.current_program_id = $program_id AND e.current_department_id = $department_id AND e.unit_id = $unit_id AND ((e.start_date <= '$form_date' AND e.end_date >= '$form_date') OR (e.start_date <= '$form_date' AND (e.end_date IS NULL OR e.end_date = '0000-00-00')))";
			} else if(!empty($program_id) && !empty($department_id) && !empty($unit_id) && !empty($project_id) &&!empty($type_id)) {
				$cond="WHERE (r.emp_id IS NULL OR r.effect_date > '$form_date') AND e.current_program_id = $program_id AND e.current_department_id = $department_id AND e.unit_id = $unit_id AND e.project_id = $project_id AND ((e.start_date <= '$form_date' AND e.end_date >= '$form_date') OR (e.start_date <= '$form_date' AND (e.end_date IS NULL OR e.end_date = '0000-00-00')))";
			} else if(empty($program_id) && empty($department_id) && empty($unit_id) && empty($project_id) && !empty($type_id)) {
				$cond="WHERE (r.emp_id IS NULL OR r.effect_date > '$form_date') AND ((e.start_date <= '$form_date' AND e.end_date >= '$form_date') OR (e.start_date <= '$form_date' AND (e.end_date IS NULL OR e.end_date = '0000-00-00')))";
			}
			
			$all_result = DB::select(DB::raw("SELECT e.emp_id FROM tbl_emp_mapping as e left join tbl_resignation as r ON e.emp_id = r.emp_id $cond"));
						
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
									->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
									->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
									->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
									->leftJoin('tbl_branch as br', 'm.salary_br_code', '=', 'br.br_code')
									->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
									->leftJoin('tbl_emp_assign as ea', function($join){
												//$join->where('ea.status', 1)
												$join->whereBetween('ea.status',array(1,2))
													->on('m.emp_id', '=', 'ea.emp_id');
											})
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->where(function($query) use ($type_id) {
											if($type_id == 1) {
												$query->where('m.br_code', 9999);
											} else if($type_id == 2) {
												$query->where('m.br_code', '!=', 9999);
											}								
										})
									->select('e.emp_name_eng','e.org_join_date',DB::raw("(SELECT COUNT(tran_type_no) FROM tbl_promotion
												WHERE emp_id = $result->emp_id
												AND effect_date < '$form_date') as total"),'m.emp_id','m.grade_code','m.designation_code','m.department_code','m.basic_salary','m.total_pay','m.net_pay','m.br_join_date','m.grade_effect_date','m.is_permanent','m.tran_type_no','g.grade_name','d.designation_name','d.priority','b.branch_name','br.branch_name as salary_branch_name','ea.open_date','ea.incharge_as')
									->first();
					if(!empty($data_result)) {
						$emp_id = $result->emp_id;
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

					//}
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
					
					//// employee assign ////
					$assign_designation = DB::table('tbl_emp_assign as ea')
									->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
									->where('ea.emp_id', $result->emp_id)
									->where('ea.open_date', '<=', $form_date)
									->where('ea.status', '!=', 0)
									->where('ea.select_type', '=', 5)
									->select('ea.emp_id','ea.open_date','ea.designation_code','de.designation_name')
									->first();
					//print_r($assign_designation);				
					if(!empty($assign_designation)) {
						$result_designation_code = $assign_designation->designation_code;
						$asign_desig = $assign_designation->designation_name;
						$desig_open_date = $assign_designation->open_date;
					} else {
						$result_designation_code = $data_result->designation_code;
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
					////////
						//if ($data_result->department_code == $department_code) {	
							$data['all_result'][] = array(
								'emp_id' => $data_result->emp_id,
								'emp_name_eng'      => $data_result->emp_name_eng,
								'exam_name'      => $exam_name,
								'org_join_date'      => date('d M Y',strtotime($data_result->org_join_date)),
								'basic_salary'      => $bs_salary,
								'total_pay'      => $total_salary,
								'net_pay'      => $net_salary,
								'total_plus'      => $total_plus,
								'next_designation_code'      => $data_result->designation_code,
								'grade_code'      => $data_result->grade_code,
								'grade_name'      => $data_result->grade_name,
								'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
								'grade_effect_date'      => date('d M Y',strtotime($data_result->grade_effect_date)),
								'total'      => $data_result->total,
								'permanent_provision'      => $data_result->is_permanent,
								'designation_name'      => $data_result->designation_name,
								'designation_priority'      => $data_result->priority,
								'branch_name'      => $data_result->branch_name,
								'incharge_as'      => $data_result->incharge_as,
								'open_date'      => $data_result->open_date,
								'increment_marked'    	=> $increment_mark,
								'promotion_marked'    	=> $promotion_mark,
								'permanent_marked'    	=> $permanent_mark,
								'asign_branch_name'    	=> $asign_branch_name,
								'asign_area_name'    	=> $asign_area_name,
								'asign_open_date'    	=> $asign_open_date,
								'asign_desig'    		=> $asign_desig,
								'desig_open_date'    	=> $desig_open_date,
								'salary_branch_name'    => $data_result->salary_branch_name,
								'tran_type_no'    => $data_result->tran_type_no
							);
						//}
					}				
				}
			}
		
		//print_r ($data['all_result']); //exit;
		return view('admin.pages.reports.program_staff_report',$data);
    }
	
	public function AllTotalStaffReport(Request $request)
    {

		$data = array();
		$data['Heading'] = $data['title'] = 'All Staff Report';
		$data['form_date'] 	= $form_date = '2021-07-26';
		$data['status'] 	= $status = 1;
		$data['emp_group'] 	= $emp_group = 1;
		$data['emp_type'] 	= $emp_type = 1;
		$data['all_emp_group'] 		= DB::table('tbl_emp_group')->get();
		
		if($emp_type){
			$data['all_emp_type'] = DB::table('tbl_emp_type')
					  ->where('type_id', $emp_group) 
					  ->where('status', 1) 
                      ->get();
		$all_result = DB::table('tbl_emp_basic_info as e')
						->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
						//->where('e.emp_group', '=', $emp_group)
						//->where('e.emp_type', '=', $emp_type)
						->where('e.org_join_date', '<=', $data['form_date'])
						
						->where(function($query) use ($status, $form_date) {
								if($status != 'all') {
									if($status == 1) {
										$query->whereNull('r.emp_id');
										$query->orWhere('r.effect_date', '>', $form_date);
									} elseif ($status == 0) {
										$query->where('r.effect_date', '<=', $form_date);
									}
								}
							})

						->orderBy('e.emp_id', 'ASC')
						->select('e.*','r.effect_date')
						->get();
		//print_r ($all_result); exit;				
		foreach ($all_result as $result) {			
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
			if(!empty($max_sarok)) {
			$data_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
							->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
							->where('m.sarok_no', '=', $max_sarok->sarok_no)
							->select('m.basic_salary','m.emp_id','m.br_join_date','d.designation_name','b.branch_name','a.area_name')
							->first();
			//print_r ($data_result);
			//// employee assign ////
			}
			$program_project = DB::table('tbl_emp_mapping as m')
						->leftJoin('tbl_project as p', 'm.project_id', '=', 'p.id')
					  ->where('m.emp_id', $result->emp_id) 
					  ->orderBy('m.id', 'DESC')
                      ->select('m.*','p.project_name')
					 ->first();
			////////
			$data['all_result'][] = array(
					'emp_id' => $result->emp_id,
					'emp_name_eng'      => $result->emp_name_eng,
					'birth_date'      => $result->birth_date,
					'designation_name'      => $data_result->designation_name,
					'current_program_id'      => $program_project->current_program_id,
					'project_name'      => $program_project->project_name
				);	
				
		}
		}
		//print_r ($data['all_result']); exit;
		
		
		return view('admin.pages.reports.all_totalstaff_report',$data);
    }
	
	public function AllBloodIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Blood Group Report';
		$data['form_date']	= date('Y-m-d');	
		$data['status']		= 1;
		$data['emp_group']		= '';
		$data['emp_type']		= '';
		$data['all_emp_group'] 		= DB::table('tbl_emp_group')->get();
		$data['all_emp_type'] 		= array();		
		return view('admin.pages.reports.all_blood_report',$data);
		
    }
	
	
	
	public function BloodReport(Request $request)
    {

		$data = array();
		$data['Heading'] = $data['title'] = 'Blood Group Report';
		$data['form_date'] 	= $form_date = date('Y-m-d');
		$data['status'] 	= $status = 1;
		$data['blood_group'] 	= $blood_group = $request->input('blood_group');
		$data['emp_group'] 	= $emp_group = $request->input('emp_group');
		$data['emp_type'] 	= $emp_type = $request->input('emp_type');
		$data['branch_type'] 	= $branch_type = $request->input('branch_type');
		$data['all_emp_group'] 		= DB::table('tbl_emp_group')->get();
		
		if($emp_type){
			$data['all_emp_type'] = DB::table('tbl_emp_type')
					  ->where('type_id', $emp_group) 
					  ->where('status', 1) 
                      ->get();
		$all_result = DB::table('tbl_emp_basic_info as e')
						->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
						->where('e.emp_group', '=', $emp_group)
						->where('e.emp_type', '=', $emp_type)						
						->where('e.org_join_date', '<=', $data['form_date'])
						->where(function($query) use ($blood_group) {
								if($blood_group != 'all') {
								$query->where('e.blood_group', '=', $blood_group);	
								}
							})
						->where(function($query) use ($status, $form_date) {
								if($status != 'all') {
									if($status == 1) {
										$query->whereNull('r.emp_id');
										$query->orWhere('r.effect_date', '>', $form_date);
									} elseif ($status == 0) {
										$query->where('r.effect_date', '<=', $form_date);
									}
								}
							})

						->orderBy('e.emp_id', 'ASC')
						->select('e.*','r.effect_date')
						->get();
		//print_r ($all_result); exit;				
		foreach ($all_result as $result) {
			$max_exam = DB::table('tbl_emp_edu_info')
				->where('emp_id', '=', $result->emp_id)
				->select('emp_id', DB::raw('max(level_id) as level_id'))
                ->groupBy('emp_id')
                ->first();
				//print_r ($max_exam);
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
						->where(function($query) use ($branch_type) {
								if($branch_type != 'all') {
									if($branch_type == 9999) {
										$query->where('m.br_code', '=', 9999);
									} elseif($branch_type == 1) {
										$query->where('m.br_code', '!=', 9999);
									}
								}
							})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no')) 
						->groupBy('m.emp_id')
						->first();
			//print_r ($max_sarok);			
			if(!empty($max_sarok)) {
			$data_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
							->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
							->where('m.sarok_no', '=', $max_sarok->sarok_no)
							->select('m.basic_salary','m.emp_id','m.br_join_date','m.tran_type_no','m.next_increment_date','d.designation_name','b.branch_name','a.area_name')
							->first();
			//print_r ($data_result);
			//// employee assign ////
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
			////////
			if(!empty($max_sarok)) {
			$data['all_result'][] = array(
					'emp_id' => $result->emp_id,
					'emp_name_eng'      => $result->emp_name_eng,
					'emp_name_ban'      => $result->emp_name_ban,
					'permanent_add'      => $result->permanent_add,
					'father_name'      => $result->father_name,
					'blood_group'      => $result->blood_group,
					'birth_date'      => $result->birth_date,
					'exam_name'      => $exam_name,
					'org_join_date'      => date('d M Y',strtotime($result->org_join_date)),
					'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
					'designation_name'      => $data_result->designation_name,
					'branch_name'      => $data_result->branch_name,
					'area_name'      => $data_result->area_name,
					'tran_type_no'      => $data_result->tran_type_no,
					'c_end_date'      => (($data_result->next_increment_date != '')) ? date('d M Y',strtotime($data_result->next_increment_date)) : '-',
					're_effect_date'      => $result->effect_date,
					'assign_designation'      => $asign_desig,
					'assign_open_date'      => $desig_open_date,
					'asign_branch_name'      => $asign_branch_name,
					'asign_area_name'      => $asign_area_name,
					'asign_open_date'      => $asign_open_date
				);	
				
		}	
		}
		}
		//print_r ($data['all_result']); exit;
		
		
		return view('admin.pages.reports.all_blood_report',$data);
    }
	
	public function GetBMAMDM($br_code)
    {
        $data = array();
		
		// BM, AM, ZM
		$form_date = date('Y-m-d');
		/* District Manager */
		$ar_list = DB::table('tbl_branch as b')
							->leftJoin('tbl_branch as ea', function($join){
											$join->where('ea.dm_br_location',1)
												->on('b.zone_code', '=', 'ea.zone_code');
										})
							->where('b.br_code', $br_code)
							->first();
		
		//print_r($ar_list);exit;
			$dataresult = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.br_code', '=', $ar_list->br_code)
						->where('m.br_join_date', '<=', $form_date)
						->Where(function($query) use ($form_date) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);								
								})
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get()->toArray();
						////////////////
			$assignbranch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										->where('eas.br_code', '=', $ar_list->br_code)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($form_date) {
											$query->whereNull('r.emp_id');
											$query->orWhere('r.effect_date', '>', $form_date);
										})									
										->select('eas.emp_id')
										->get()->toArray();
			$all_result1 = array_unique(array_merge($dataresult,$assignbranch), SORT_REGULAR);
			//print_r ($data_result);
			if (!empty($all_result1)) {
				foreach ($all_result1 as $result1) {	
					$emp_id = $result1->emp_id;
					$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $result1->emp_id)
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
						
					$result1_data = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->select('e.emp_name_eng','m.br_code','m.br_join_date','m.designation_code','d.designation_name','b.branch_name')
						->first();
					//// employee assign ////
					////////
					if ($ar_list->br_code == $result1_data->br_code) {	
					if ($result1_data->designation_code == 209 || $result1_data->designation_code == 211) {	
						$data['dm_result'] = array(
							'emp_id' => $result1->emp_id,
							'emp_name_eng'      => $result1_data->emp_name_eng,
							'designation_name'      => $result1_data->designation_name
						);	
					}
					}
				}
			}			
		
		print_r($data['dm_result']);
		/* Area Manager */
		$br_list = DB::table('tbl_branch as b')
							->leftJoin('tbl_branch as ea', function($join){
											$join->where('ea.am_br_location',1)
												->on('b.area_code', '=', 'ea.area_code');
										})
							->where('b.br_code', $br_code)
							->first();
	
			$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.br_code', '=', $br_list->br_code)
						->where('m.br_join_date', '<=', $form_date)
						->Where(function($query) use ($form_date) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);								
								})
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get()->toArray();
						////////////////
			$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										->where('eas.br_code', '=', $br_list->br_code)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($form_date) {
											$query->whereNull('r.emp_id');
											$query->orWhere('r.effect_date', '>', $form_date);
										})									
										->select('eas.emp_id')
										->get()->toArray();
			$all_result2 = array_unique(array_merge($data_result,$assign_branch), SORT_REGULAR);
			//print_r ($data_result);
			if (!empty($all_result2)) {
				foreach ($all_result2 as $result2) {	
					$emp_id = $result2->emp_id;
					$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $result2->emp_id)
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
						
					$result_data = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->select('e.emp_name_eng','m.br_code','m.br_join_date','m.designation_code','d.designation_name','b.branch_name')
						->first();
					//// employee assign ////
					////////
					if ($br_list->br_code == $result_data->br_code) {	
					if ($result_data->designation_code == 122 || $result_data->designation_code == 212 || $result_data->designation_code == 246) {	
						$data['am_result'] = array(
							'emp_id' => $result2->emp_id,
							'emp_name_eng'      => $result_data->emp_name_eng,
							'designation_name'      => $result_data->designation_name
						);	
					}
					}
				}
			}			
		
		
		print_r($data['am_result']);
		
		/* Branch Manager */
		
			$data_re_sult = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.br_code', '=', $br_code)
						->where('m.br_join_date', '<=', $form_date)
						->Where(function($query) use ($form_date) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);								
								})
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get()->toArray();
						////////////////
			$assign_br_anch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										->where('eas.br_code', '=', $br_code)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($form_date) {
											$query->whereNull('r.emp_id');
											$query->orWhere('r.effect_date', '>', $form_date);
										})									
										->select('eas.emp_id')
										->get()->toArray();
			$all_result3 = array_unique(array_merge($data_re_sult,$assign_br_anch), SORT_REGULAR);
			//print_r ($data_result);
			if (!empty($all_result3)) {
				foreach ($all_result3 as $result3) {	
					$emp_id = $result3->emp_id;
					$max_sa_rok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $result3->emp_id)
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
						
					$re_sult_data = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->where('m.sarok_no', '=', $max_sa_rok->sarok_no)
						->select('e.emp_name_eng','m.br_code','m.br_join_date','m.designation_code','d.designation_name','b.branch_name')
						->first();
					//// employee assign ////
					////////
					if ($br_code == $re_sult_data->br_code) {	
					if ($re_sult_data->designation_code == 24 || $re_sult_data->designation_code == 215) {	
						$data['bm_result'] = array(
							'emp_id' => $result3->emp_id,
							'emp_name_eng'      => $re_sult_data->emp_name_eng,
							'designation_name'      => $re_sult_data->designation_name
						);	
					}
					}
				}
			}			
		
		
		print_r($data['bm_result']);
	
    }
	
	/* auto promotion 18 to 17 and 17 to 18 */
	public function grade_unnoyon_report(Request $request){
		$data=array();
		$data['current_date']=$current_date=date('Y-m-d');
		$data['emp_grade']='';
		$data['Heading'] = $data['title'] = 'Grade Unnoyon Report';
		
		if($request->all()){
			$data['current_date']=$current_date=$request->current_date;
			$data['emp_grade']=$emp_grade=$request->emp_grade;
			$data['all_result']=DB::select("
								SELECT
									tbl_master_tra.*,
									tbl_designation.designation_name,
									tbl_emp_basic_info.emp_name_eng, 
									tbl_emp_basic_info.org_join_date,
									tbl_branch.branch_name,
									TIMESTAMPDIFF(YEAR, tbl_master_tra.grade_effect_date, CURDATE()) AS year,
									(SELECT exam_name FROM tbl_exam_name WHERE exam_code=(SELECT exam_code FROM tbl_emp_edu_info WHERE emp_id=tbl_master_tra.emp_id AND level_id=(SELECT MAX(level_id)  AS level_id FROM tbl_emp_edu_info WHERE emp_id = tbl_master_tra.emp_id) GROUP BY level_id)) AS emp_exam_name,
									(SELECT MAX(tbl_emp_edu_info.level_id) AS level_id FROM tbl_emp_edu_info WHERE tbl_emp_edu_info.emp_id=tbl_master_tra.emp_id group by tbl_emp_edu_info.emp_id) AS level_id
								FROM
									tbl_master_tra
									LEFT JOIN tbl_designation ON tbl_designation.designation_code=tbl_master_tra.designation_code
									LEFT JOIN tbl_emp_basic_info ON tbl_emp_basic_info.emp_id=tbl_master_tra.emp_id
									LEFT JOIN tbl_branch ON tbl_branch.br_code=tbl_master_tra.br_code
								WHERE
									sarok_no IN(
									SELECT DISTINCT
										(main.sarok_no) AS sarok_no
									FROM
										tbl_master_tra main
									INNER JOIN(
										SELECT
											MAX(sarok_no) AS max_sarok
										FROM
											tbl_master_tra 
										GROUP BY
											emp_id
									) sub
								ON
									sub.max_sarok = main.sarok_no
								WHERE
									emp_id NOT IN(
									SELECT
										emp_id
									FROM
										tbl_resignation WHERE tbl_resignation.effect_date <= '".$current_date."'
								)
								) AND tbl_master_tra.grade_code = $emp_grade AND tbl_master_tra.br_code != '9999' ORDER BY emp_id ASC");
				//dd($data);
		}
		
		
		
		
		
		return view('admin.pages.reports.grade_unnoyon_report',compact('data'));  
	}
	
	/* Employee Turnover Report */
	public function EmployeeTurnoverIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Employee Turnover Report';
		$data['emp_group_code']	= '';	
		$data['form_date']			= '';
		$data['to_date']			= '';
		$data['all_emp_group'] 	= DB::table('tbl_emp_group')->where('status',1)->orderBy('id', 'ASC')->get();
				
		return view('admin.pages.reports.employee_turnover_report',$data);
    }
	
	public function EmployeeTurnoverReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Employee Turnover Report';
		$data['emp_group_code'] = $emp_group_code = $request->input('emp_group_code');
		$data['form_date'] = $form_date = $request->input('form_date');
		$data['to_date'] = $to_date = $request->input('to_date');
		
		$data['all_emp_group'] 	= DB::table('tbl_emp_group')->where('status',1)->orderBy('id', 'ASC')->get();		
		$data['all_designation'] = $all_designation_code = DB::table('tbl_designation_group as dg')
														->leftJoin('tbl_designation as d', 'dg.desig_group_code', '=', 'd.designation_group_code')
														->where('dg.emp_group',$emp_group_code)
														->where('dg.status',1)
														->orderBy('d.priority', 'ASC')
														->select('d.designation_code','d.designation_name')
														->get();
		//print_r ($data['all_designation']);				
		if(!empty($all_designation_code)) {
			$all_join_emp = DB::table('tbl_emp_basic_info as e')
							->leftjoin('tbl_master_tra as mt',function($join){
								$join->on("e.emp_id","=","mt.emp_id") 
									->where('mt.sarok_no',DB::raw("(SELECT 
											max(tbl_master_tra.sarok_no) FROM tbl_master_tra 
											where e.emp_id = tbl_master_tra.emp_id and tbl_master_tra.br_join_date = (SELECT 
											max(t.br_join_date) FROM tbl_master_tra as t where e.emp_id = t.emp_id)
											)") 		 
										);										
									})									
							->where('e.org_join_date', '>=', $data['form_date'])
							->where('e.org_join_date', '<=', $data['to_date'])
							->where('e.emp_group', $emp_group_code)
							->orderBy('e.emp_id', 'ASC')
							->select('e.emp_id','mt.sarok_no','mt.br_join_date','mt.designation_code')
							->get();
			foreach ($all_join_emp as $all_emp) {
				foreach ($all_designation_code as $all_des_code) {
					if ($all_emp->designation_code == $all_des_code->designation_code) {
						$data['designation_count1'][] = array($all_emp->designation_code);
					}						
				}
				
				$all_resign_emp_id = DB::table('tbl_resignation')
						->where('emp_id', '=', $all_emp->emp_id)
						->where('effect_date', '>=', $data['form_date'])
						->where('effect_date', '<=', $data['to_date'])
						->get();
				//print_r ($all_resign_emp_id);	exit;	
				if(!empty($all_resign_emp_id)) {
					foreach ($all_resign_emp_id as $all_resign_emp) {
						foreach ($all_designation_code as $all_des_code) {
							if ($all_resign_emp->designation_code == $all_des_code->designation_code) {
								$data['designation_count3'][] = array($all_resign_emp->designation_code);
							}						
						}
					}
				}
			}
			//print_r($data['designation_count3']);
			$all_re_emp_id = DB::table('tbl_resignation as r')							
							->where('r.effect_date', '>=', $data['form_date'])
							->where('r.effect_date', '<=', $data['to_date'])
							->orderBy('r.emp_id', 'ASC')
							->select('r.emp_id','r.designation_code')
							->get();
		
			foreach ($all_re_emp_id as $all_re_emp) {
				foreach ($all_designation_code as $all_des_code) {
					if ($all_re_emp->designation_code == $all_des_code->designation_code) {
						$data['designation_count2'][] = array($all_re_emp->designation_code);
					}						
				}
			}

			$max_sarok = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.letter_date', '<=', $data['to_date'])
						->where('m.br_join_date', '<=', $data['to_date'])
						->where('m.effect_date', '<=', $data['to_date'])
						->whereNull('r.emp_id')
						->orWhere('r.effect_date', '>', $data['to_date'])
						->select('m.emp_id', DB::raw('max(m.letter_date) as letter_date'), DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('m.emp_id')
						->get();
			foreach ($max_sarok as $as_sarok) {
				$data_result = DB::table('tbl_master_tra')
						->where('sarok_no', '=', $as_sarok->sarok_no)
						->select('designation_code')
						->first();
				foreach ($all_designation_code as $all_des_code) {
					if ($data_result->designation_code == $all_des_code->designation_code) {
						$data['designation_count'][] = array($data_result->designation_code);
					}						
				}
			}
			/////////////// for total ////////////////
			$all_re_emp_id = DB::table('tbl_emp_basic_info as e')
							->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')							
							->where('e.emp_group', '=', $emp_group_code)
							->where('r.effect_date', '>=', $data['form_date'])
							->where('r.effect_date', '<=', $data['to_date'])
							->orderBy('r.emp_id', 'ASC')
							->select('r.emp_id')
							->get();
			$data['regin_row_count'] = $regin_row_count = $all_re_emp_id->count();
			
			$all_begining_result = DB::table('tbl_emp_basic_info as e')
						->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
						->where('e.emp_group', '=', $emp_group_code)
						->where('e.org_join_date', '<=', $data['form_date'])
						->where(function($query) use ($form_date) {
								$query->whereNull('r.emp_id');
								$query->orWhere('r.effect_date', '>', $form_date);
							})
						->orderBy('e.emp_id', 'ASC')
						->select('e.*','r.effect_date')
						->get();
			$data['begining_row_count'] = $begining_row_count = $all_begining_result->count();
			$all_ending_result = DB::table('tbl_emp_basic_info as e')
						->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
						->where('e.emp_group', '=', $emp_group_code)
						->where('e.org_join_date', '<=', $data['to_date'])						
						->where(function($query) use ($to_date) {
								$query->whereNull('r.emp_id');
								$query->orWhere('r.effect_date', '>', $to_date);
							})
						->orderBy('e.emp_id', 'ASC')
						->select('e.*','r.effect_date')
						->get();
			$data['ending_row_count'] = $ending_row_count = $all_ending_result->count();
			/////////////// for head office ////////////////
			$all_re_ho_emp_id = DB::table('tbl_emp_basic_info as e')
							->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')							
							->where('e.emp_group', '=', $emp_group_code)
							->where('r.br_code', '=', 9999)
							->where('r.effect_date', '>=', $data['form_date'])
							->where('r.effect_date', '<=', $data['to_date'])
							->orderBy('r.emp_id', 'ASC')
							->select('r.emp_id')
							->get();
			$data['regin_ho_row_count'] = $regin_ho_row_count = $all_re_ho_emp_id->count();
			
			
			$br_code = 9999;
			$all_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
							->where('m.br_code', '=', $br_code)
							->where('m.br_join_date', '<=', $form_date)
							->where(function($query) use ($form_date) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);
								})
							
							->select('m.emp_id')
							->groupBy('m.emp_id')
							->get();
			////////////////
			if (!empty($all_result)) {
				foreach ($all_result as $result) {
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
					$data_result = DB::table('tbl_master_tra as m')->where('m.sarok_no', '=', $max_sarok->sarok_no)->select('m.emp_id','m.br_code')->first();
					////////				
					if ($data_result->br_code == $br_code) {	
						$data['all_result'][] = array(
							'emp_id' => $data_result->emp_id
						);
					}				
				}				
			}
			$data['begining_ho_row_count'] = count($data['all_result']);			
	
			$all_result1 = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
							->where('m.br_code', '=', $br_code)
							->where('m.br_join_date', '<=', $to_date)
							->where(function($query) use ($to_date) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $to_date);
								})
							
							->select('m.emp_id')
							->groupBy('m.emp_id')
							->get();
			////////////////
			if (!empty($all_result1)) {
				foreach ($all_result1 as $result1) {
					$empid = $result1->emp_id;
					$maxsarok = DB::table('tbl_master_tra as m')
							->where('m.emp_id', '=', $result1->emp_id)
							->where('m.br_join_date', '=', function($query) use ($empid,$to_date)
									{
										$query->select(DB::raw('max(br_join_date)'))
											  ->from('tbl_master_tra')
											  ->where('emp_id',$empid)
											  ->where('br_join_date', '<=', $to_date);
									})
							->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
							->groupBy('m.emp_id')
							->first();
					//print_r ($max_sarok);
					$data_result1 = DB::table('tbl_master_tra')->where('sarok_no', '=', $maxsarok->sarok_no)->select('emp_id','br_code')->first();
					////////				
					if ($data_result1->br_code == $br_code) {	
						$data['all_result1'][] = array(
							'emp_id' => $data_result1->emp_id
						);
					}				
				}				
			}
			$data['ending_ho_row_count'] = count($data['all_result1']);
			///////////////////////////
			$all_join_emp = DB::table('tbl_emp_basic_info as e')
							->leftjoin('tbl_master_tra as mt',function($join){
								$join->on("e.emp_id","=","mt.emp_id") 
									->where('mt.sarok_no',DB::raw("(SELECT 
											max(tbl_master_tra.sarok_no) FROM tbl_master_tra 
											where e.emp_id = tbl_master_tra.emp_id and tbl_master_tra.letter_date = (SELECT 
											max(t.letter_date) FROM tbl_master_tra as t where e.emp_id = t.emp_id)
											)") 		 
										);										
									})									
							->where('e.org_join_date', '>=', $data['form_date'])
							->where('e.org_join_date', '<=', $data['to_date'])
							->where('e.emp_group', $emp_group_code)
							->orderBy('e.emp_id', 'ASC')
							->select('e.emp_id','mt.sarok_no','mt.letter_date','mt.designation_code')
							->get();
			//print_r($regin_row_count.'<br/>');
			//print_r($begining_row_count.'<br/>');
			//print_r($ending_row_count);
			//print_r ($data['designation_count']);
			/* Total Strength */
			if (!empty($data['designation_count'])) {
			$data['designation_group_total'] = array_count_values(array_column($data['designation_count'], 0));
			}
			/* Total Joining (New Staff) */
			if (!empty($data['designation_count1'])) {
			$data['designation_group_total1'] = array_count_values(array_column($data['designation_count1'], 0));
			}
			/* Total Resign */
			if (!empty($data['designation_count2'])) {
			$data['designation_group_total2'] = array_count_values(array_column($data['designation_count2'], 0));
			}
			/* New Staff Resign (Who Join from date-to date) */
			if (!empty($data['designation_count3'])) {
			$data['designation_group_total3'] = array_count_values(array_column($data['designation_count3'], 0));
			}
				
		}
		//print_r ($data['designation_group_total2']); 				
		//exit;
		
		return view('admin.pages.reports.employee_turnover_report',$data);
    }
	
}
