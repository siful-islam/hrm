<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
use PDF;
use File;

class PmsController extends Controller
{
	public function __construct() 
	{
		$this->middleware("CheckUserSession");
		date_default_timezone_set('Asia/Dhaka');
	}
	
	public function index()
    {        	
		$data = array();
		$data['emp_id'] = $login_emp_id = Session::get('emp_id');
		$data['assessment_year'] = '';
		$user_type 	= Session::get('user_type');			
		$staff_status = DB::table('tbl_pms_staff_status')->where('emp_id',$login_emp_id)->where('year_id',2)->first();
		if(!empty($staff_status)) {
			$data['status'] = $staff_status->status;
			$data['sub_status'] = $staff_status->sub_status;
			$data['submission_status'] = $staff_status->submission_status;
			$data['complete_status'] = $staff_status->complete_status;
			$data['super_visor_id'] = $staff_status->super_visor_id;
		} else {
			$data['status'] = 0;
			$data['sub_status'] = 0;
			$data['submission_status'] = 0;
			$data['complete_status'] = 0;
			$data['super_visor_id'] = '';
		}
		$data['all_result1'] = array();
		return view('admin.pages.pms.pms_list',$data);			
    }
	
	public function PmsEmployee(Request $request)
    {
		$data = array();
		$data['assessment_year'] = $assessment_year = $request->assessment_year;
		$data['emp_id'] = $emp_id = Session::get('emp_id');
		$form_date = date('Y-m-d');
		$login_emp_id = Session::get('emp_id');
		$user_type 	= Session::get('user_type');			
		$staff_status = DB::table('tbl_pms_staff_status')->where('emp_id',$login_emp_id)->where('year_id',2)->first();
		if(!empty($staff_status)) {
			$data['status'] = $staff_status->status;
			$data['sub_status'] = $staff_status->sub_status;
			$data['submission_status'] = $staff_status->submission_status;
			$data['complete_status'] = $staff_status->complete_status;
			$data['super_visor_id'] = $staff_status->super_visor_id;
		} else {
			$data['status'] = 0;
			$data['sub_status'] = 0;
			$data['submission_status'] = 0;
			$data['complete_status'] = 0;
			$data['super_visor_id'] = '';
		}
		$supervisors_type = Session::get('supervisors_type');
		$supervisor_config = DB::table('tbl_pms_supervisor_config')->where('emp_id', Session::get('emp_id'))->first();
		if(!empty($supervisor_config)) {
		$data['super_visor_type'] = $super_visor_type = $supervisor_config->supervisor_type;
		$data['all_result'] = DB::table('tbl_pms as p')
							->leftjoin('tbl_emp_basic_info as e', 'p.emp_id', '=', 'e.emp_id')
							->leftjoin('tbl_pms_staff_status as ps', 'p.emp_id', '=', 'ps.emp_id')
							->select('p.*','ps.status','ps.sub_status','ps.super_visor_id as super_visorid','ps.sub_super_visor_id as sub_super_visorid','e.emp_name_eng')
							->where('ps.year_id', $assessment_year)
							->Where(function($query) use ($super_visor_type, $login_emp_id) {
									if($super_visor_type == 1) {
										$query->where('ps.super_visor_id',$login_emp_id);
										$query->whereIn('ps.status', [1, 2]);
										$query->whereIn('ps.sub_status', [1, 0]);										
									}else if($super_visor_type == 2) {
										$query->where('ps.sub_super_visor_id', $login_emp_id);
										$query->where('ps.status',1);
										$query->where('ps.sub_status',1);
									} else if($super_visor_type == 3) {
										$query->whereIn('ps.status', [1, 2]);
										$query->where('ps.sub_status',1);
										$query->where('ps.super_visor_id',$login_emp_id);
										$query->orWhere('ps.sub_super_visor_id',$login_emp_id);
									}							
								})
							->where('ps.complete_status', 0)
							->groupBy('p.emp_id')					  
							->get();
		}
		//print_r($data['all_result']); exit;
		$data['all_result1'] = DB::table('tbl_pms as p')
								->leftJoin('tbl_pms_staff_status as ps', function($join){
												$join->on('p.emp_id','=','ps.emp_id')
												->on('p.year_id','=','ps.year_id');
											})
								->where('p.emp_id',$data['emp_id'])
								->where('p.year_id', $assessment_year)
								->whereIn('ps.status', [1, 2, 3])
								->get();
		$data['pms_submitted'] = DB::table('tbl_pms_staff_status')
								->where('year_id', $assessment_year)
								->Where(function($query) use ($supervisors_type, $login_emp_id) {
									if($supervisors_type == 1) {
										$query->where('super_visor_id',$login_emp_id);
										$query->orWhere('sub_super_visor_id',$login_emp_id);
									}else if($supervisors_type == 2) {
										$query->where('sub_super_visor_id', $login_emp_id);
									}							
								})
								->get();
								
		
								
		$data['pms_approved'] = DB::table('tbl_pms_staff_status')
								->where('status', '!=', 1)
								->Where(function($query) use ($assessment_year, $login_emp_id) {
									if($assessment_year == 1) {
										$query->where('year_id',$assessment_year);
										$query->where('super_visor_id',$login_emp_id);
									}else if($assessment_year == 2) {
										$query->where('year_id',$assessment_year);
										$query->where('super_visor_id',$login_emp_id);
										$query->orWhere('sub_super_visor_id',$login_emp_id);
									}							
								})								
								->get();
		$data['pmsapproved'] = DB::table('tbl_pms_staff_status')->where('super_visor_id', Session::get('emp_id'))->where('status', 3)->where('year_id', $assessment_year)->get();
		$data['pms_submission'] = DB::table('tbl_pms_staff_status')->where('super_visor_id', $login_emp_id)->where('submission_status', 3)->where('year_id', $assessment_year)->get();
		$data['pms_submission_complete'] = DB::table('tbl_pms_staff_status')->where('super_visor_id', $login_emp_id)->where('submission_status', 3)->where('complete_status', 4)->where('year_id', $assessment_year)->get();
		$data['pms_final_score'] = DB::table('tbl_pms_final_score')->where('emp_id', $emp_id)->where('year_id', $assessment_year)->first();
		
		$data['all_pms_config'] = DB::table('tbl_pms_marks_entry as pe')
								->leftjoin('tbl_pms_config as pc', 'pe.c_no', '=', 'pc.id')
								->where('emp_id', $emp_id)
								->where('year_id', $assessment_year)
								->select('pe.*','pc.c_detail')
								->get();
								
		$data['pms_staff_status'] = DB::table('supervisor_mapping_ho as sm')
									->leftJoin('tbl_resignation as r', 'sm.emp_id', '=', 'r.emp_id')
									->where('sm.supervisor_id', $login_emp_id)
									->Where(function($query) use ($supervisors_type, $login_emp_id) {
									if($supervisors_type == 1) {
											$query->whereIn('sm.supervisor_type', [1, 2]);
										}else if($supervisors_type == 2) {
											$query->where('sm.supervisor_type', 2);
										}							
									})
									->where('sm.is_pms', 1)
									->Where(function($query) use ($form_date) {
										$query->whereNull('r.emp_id');
										$query->orWhere('r.effect_date', '>', $form_date);								
									})
									->select('sm.*')
									->get();
		$data['all_pms_approve'] = $all_pms_approve = DB::table('tbl_pms_approve')->where('emp_id', $emp_id)->where('year_id', $assessment_year)->first();
		//print_r($data['all_pms_config']);
		if(!empty($all_pms_approve)) {
				$c_one_item =   explode(',',$all_pms_approve->c_one);
				$c_two_item =   explode(',',$all_pms_approve->c_two);
				$c_three_item =   explode(',',$all_pms_approve->c_three);
				$c_four_item =   explode(',',$all_pms_approve->c_four);
				//print_r ($c_one_item);
				
				foreach ($c_one_item as $key => $value) {
					$c_one_row = DB::table('tbl_pms_config')
							->where('c_value', '=', $value)
							->select('c_value','c_no','c_detail')
							->first();
					$data['all_c_one_item'][] = array(
						'c_one_value'      => $value,
						'c_one_detail'      => $c_one_row->c_detail
					);
				}
				
				foreach ($c_two_item as $key2 => $value2) {
					$c_two_row = DB::table('tbl_pms_config')
							->where('c_value', '=', $value2)
							->select('c_value','c_no','c_detail')
							->first();
					$data['all_c_two_item'][] = array(
						'c_two_value'      => $value2,
						'c_two_detail'      => $c_two_row->c_detail
					);
				}
				
				foreach ($c_three_item as $key3 => $value3) {
					$c_three_row = DB::table('tbl_pms_config')
							->where('c_value', '=', $value3)
							->select('c_value','c_no','c_detail')
							->first();
					$data['all_c_three_item'][] = array(
						'c_three_value'      => $value3,
						'c_three_detail'      => $c_three_row->c_detail
					);
				}
				
				foreach ($c_four_item as $key4 => $value4) {
					$c_four_row = DB::table('tbl_pms_config')
							->where('c_value', '=', $value4)
							->select('c_value','c_no','c_detail')
							->first();
					$data['all_c_four_item'][] = array(
						'c_four_value'      => $value4,
						'c_four_detail'      => $c_four_row->c_detail
					);
				}
			}
			//print_r($data['all_c_one_item']);
		$data['emp_mapping'] = DB::table('tbl_emp_mapping as mapping')
								->leftjoin('tbl_department as dept','mapping.current_department_id','=','dept.department_id')
								->leftjoin('tbl_unit_name as unit','mapping.unit_id','=','unit.id')
								->where('mapping.emp_id', $emp_id)
								->orderBy('mapping.id', 'desc')
								->select('dept.department_name', 'unit.unit_name', 'mapping.current_program_id')
								->first();
		
		$letter_date = date('Y-m-d');
			
		$max_sarok = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $emp_id)
					->where('m.br_join_date', '=', function ($query) use ($emp_id, $letter_date) {
						$query->select(DB::raw('max(br_join_date)'))
							->from('tbl_master_tra')
							->where('emp_id', $emp_id)
							->where('br_join_date', '<=', $letter_date);
					})
					->select('m.emp_id', DB::raw('max(m.sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
				
		if(!empty($max_sarok)) {		
			$data['employee_info'] = DB::table('tbl_master_tra as m')
								->leftjoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
								->leftjoin('tbl_branch as b', 'b.br_code', '=', 'm.br_code')								
								->where('m.sarok_no', $max_sarok->sarok_no)
								->where('m.status', 1)
								->select('m.br_join_date','e.emp_name_eng','e.org_join_date','b.branch_name')
								->first();			  
		}
		
		$max_sarok_designation = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $emp_id)
					->where('m.letter_date', '=', function($query) use ($emp_id, $letter_date)
						{
							$query->select(DB::raw('max(letter_date)'))
								  ->from('tbl_master_tra')
								  ->where('emp_id',$emp_id)
								  ->where('effect_date', '<=', $letter_date);
						})
					->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
		if(!empty($max_sarok_designation)) {
		$data['employee_designation'] = DB::table('tbl_master_tra as m')
				->leftjoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
				->leftjoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_id')
				->where('m.sarok_no', $max_sarok_designation->sarok_no)
				->where('m.status', 1)
				->select('m.grade_step','d.designation_name','g.grade_name')
				->first();
		}
		//print_r($data['all_result']);
		
		return view('admin.pages.pms.pms_list',$data);	

    }

    public function PmsObjectiveList()
    {
		$data = array();
		$data['emp_id'] = $emp_id = Session::get('emp_id');
		$data['all_result'] = DB::table('tbl_pms')->where('emp_id',$emp_id)->where('year_id',2)->get();
		$data['staff_status'] = DB::table('tbl_pms_staff_status')->where('emp_id',$emp_id)->where('year_id',2)->first();
		$data['balance'] = DB::table('tbl_pms')->where('emp_id', $emp_id)->where('year_id',2)->sum('task_weight');			  
		$sl_no = DB::table('tbl_pms')->where('emp_id', $emp_id)->where('year_id',2)->max('sl_no');			  
		$data['sl_no'] = $sl_no+1;		  
		//print_r ($data['staff_status']);
		return view('admin.pages.pms.pms_objective_list',$data);	

    }
	
	public function PmsObjectiveSave(Request $request)
    {
        $data = request()->except(['_token']);

		$data['emp_id'] = Session::get('emp_id'); 
		
		$supervisor = DB::table('supervisor_mapping_ho as mapping')
					->leftJoin('supervisors as supervisor', 'supervisor.supervisors_emp_id', '=', 'mapping.supervisor_id')
					->leftJoin('tbl_designation as designation', 'designation.designation_code', '=', 'supervisor.designation_code')
					->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'mapping.emp_id')
					->where('mapping.emp_id', $data['emp_id'])
					->where('mapping.supervisor_type', 1)
					->select('supervisor.supervisors_name', 'mapping.supervisor_id', 'designation.designation_name', 'basic.emp_name_eng', 'supervisor.supervisors_email')
					->orderBy('mapping.mapping_id', 'desc')
					->first();
		
		$sub_supervisor = DB::table('supervisor_mapping_ho as mapping')
					->leftJoin('supervisors as supervisor', 'supervisor.supervisors_emp_id', '=', 'mapping.supervisor_id')
					->where('mapping.emp_id', $data['emp_id'])
					->where('mapping.supervisor_type', 2)
					->select('supervisor.supervisors_name','mapping.supervisor_id','supervisor.supervisors_email')
					->orderBy('mapping.mapping_id', 'desc')
					->first();
		
		if(!empty($supervisor->supervisor_id)){
			$data['super_visor_id'] = $supervisor->supervisor_id;
		} else {
			$data['super_visor_id'] = '';
		}
		
		if(!empty($sub_supervisor->supervisor_id)){
			$data['sub_super_visor_id'] = $sub_supervisor->supervisor_id;
		} else {
			$data['sub_super_visor_id'] = '';
			//$data['sub_status'] = 1;
		}
		//$data['super_visor_id'] = $supervisor->supervisor_id;
		//$data['sub_super_visor_id'] = $sub_supervisor->supervisor_id;
		$data['year_id'] = 2;
		//print_r ($data); exit;
		
		if($data['id'] == 0) {
			DB::table('tbl_pms')->insert($data);
		} else {
			$adata['assigned_task'] = $data['assigned_task'];
			$adata['task_weight'] = $data['task_weight'];
			//$adata['performed_task'] = $data['performed_task'];
			DB::table('tbl_pms')->where('id', $data['id'])->update($adata);
		}
		
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/pms-objective');

    }
	
	public function PmsObjectiveDelete($id)
    {
		DB::table('tbl_pms')->where('id', $id)->delete();
		Session::put('message','Data Deleted Successfully');
		return Redirect::to('/pms-objective');

    }
	
	public function PmsObjectiveEdit($id)
    {
		$result=DB::table('tbl_pms')
                                    ->where('id',$id)
									->first();
		echo json_encode($result);

    }
	
	public function PmsSupervisor()
    {
		$data = array();
		$emp_id = Session::get('emp_id');
		$supervisors_type = Session::get('supervisors_type');
		$data['emp_id'] = '';
		$data['assessment_year'] = 2;
		$form_date = date('Y-m-d');
		$supervisor_config = DB::table('tbl_pms_supervisor_config')->where('emp_id', Session::get('emp_id'))->first();
		$data['super_visor_type'] = $super_visor_type = $supervisor_config->supervisor_type;
		$data['all_result'] = DB::table('tbl_pms as p')
							->leftjoin('tbl_emp_basic_info as e', 'p.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_pms_staff_status as ps', function($join){
												$join->where('ps.year_id',2)
													->on('p.emp_id', '=', 'ps.emp_id');
											})
							->select('p.*','ps.status','ps.sub_status','ps.super_visor_id as super_visorid','ps.sub_super_visor_id as sub_super_visorid','e.emp_name_eng')
							->where('ps.year_id',2)
							/* start for Objective Setup & Supervisor Approval */
							/* ->Where(function($query) use ($super_visor_type, $emp_id) {
								if($super_visor_type == 1) {
									$query->where('ps.super_visor_id',$emp_id);
									$query->whereIn('ps.status', [1, 2]);
									$query->whereIn('ps.sub_status', [1, 0]);										
								}else if($super_visor_type == 2) {
									$query->where('ps.sub_super_visor_id', $emp_id);
									$query->where('ps.status',1);
									$query->where('ps.sub_status',1);
								} else if($super_visor_type == 3) {
									$query->whereIn('ps.status', [1, 2]);
									$query->where('ps.sub_status',1);
									$query->where('ps.super_visor_id',$emp_id);
									$query->orWhere('ps.sub_super_visor_id',$emp_id);
								}							
							}) */
							/* end for Objective Setup & Supervisor Approval */
							/* start for End Year Submission */
							->Where(function($query) use ($super_visor_type, $emp_id) {
								if($super_visor_type == 1) {
									$query->where('ps.super_visor_id',$emp_id);
									$query->where('ps.submission_status',3);										
								}else if($super_visor_type == 2) {
									$query->where('ps.sub_super_visor_id', $emp_id);
									$query->where('ps.submission_status',3);
								} else if($super_visor_type == 3) {
									$query->where('ps.submission_status',3);
									$query->where('ps.super_visor_id',$emp_id);
									//$query->orWhere('ps.sub_super_visor_id',$emp_id);
								}							
							})
							/* end for End Year Submission */
							//->where('p.super_visor_id',$emp_id)							
							//->where('ps.submission_status',3)
							->where('ps.complete_status', 0)
							->groupBy('p.emp_id')					  
							->get();
		//echo "<pre/>";
		//print_r($data['all_result']);
		$data['pms_staff_status'] = DB::table('supervisor_mapping_ho as sm')
									->leftJoin('tbl_resignation as r', 'sm.emp_id', '=', 'r.emp_id')
									->Where(function($query) use ($form_date) {
										$query->whereNull('r.emp_id');
										$query->orWhere('r.effect_date', '>', $form_date);								
									})
									->where('sm.supervisor_id', $emp_id)
									->Where(function($query) use ($supervisors_type, $emp_id) {
									if($supervisors_type == 1) {
											$query->whereIn('sm.supervisor_type', [1, 2]);
										}else if($supervisors_type == 2) {
											$query->where('sm.supervisor_type', 2);
										}							
									})
									->where('sm.is_pms', 1)									
									->select('sm.*')
									->get();
		$data['pms_submitted'] = DB::table('tbl_pms_staff_status')
								->where('year_id', 2)
								->Where(function($query) use ($supervisors_type, $emp_id) {
									if($supervisors_type == 1) {
										$query->where('super_visor_id',$emp_id);
										$query->orWhere('sub_super_visor_id',$emp_id);
									}else if($supervisors_type == 2) {
										$query->where('sub_super_visor_id', $emp_id);
									}							
								})
								->get();
		$data['pms_approved'] = DB::table('tbl_pms_staff_status')
								->where('status', '!=', 1)
								->where('year_id', 2)
								->Where(function($query) use ($supervisors_type, $emp_id) {
									if($supervisors_type == 1) {
										$query->where('super_visor_id',$emp_id);
										$query->orWhere('sub_super_visor_id',$emp_id);
									}else if($supervisors_type == 2) {
										$query->where('sub_super_visor_id', $emp_id);
									}							
								})								
								->get();
		$data['pmsapproved'] = DB::table('tbl_pms_staff_status')
								->where('status', 3)
								->where('year_id', 2)
								->Where(function($query) use ($supervisors_type, $emp_id) {
									if($supervisors_type == 1) {
										$query->where('super_visor_id',$emp_id);
									}else if($supervisors_type == 2) {
										$query->where('sub_super_visor_id', $emp_id);
									}							
								})
								->get();
		$data['pms_submission'] = DB::table('tbl_pms_staff_status')
								->where('year_id', 2)
								->Where(function($query) use ($supervisors_type, $emp_id) {
									if($supervisors_type == 1) {
										$query->where('super_visor_id',$emp_id);
									}else if($supervisors_type == 2) {
										$query->where('sub_super_visor_id', $emp_id);
									}							
								})
								->where('submission_status', 3)
								->get();
		$data['pms_submission_complete'] = DB::table('tbl_pms_staff_status')
								->where('year_id', 2)
								->Where(function($query) use ($supervisors_type, $emp_id) {
									if($supervisors_type == 1) {
										$query->where('super_visor_id',$emp_id);
									}else if($supervisors_type == 2) {
										$query->where('sub_super_visor_id', $emp_id);
									}							
								})
								->where('submission_status', 3)
								->where('complete_status', 4)
								->get();
		
		$data['all_result1'] = array();
		$data['count_id'] = 0;
		return view('admin.pages.pms.pms_supervisor_list',$data);
		
    }
	
	public function PmsView($emp_id,$id)
    {
		$data = array();
		$supervisors_type = Session::get('supervisors_type');
		$login_emp_id = Session::get('emp_id');
		$data['emp_id'] = $emp_id;
		$data['all_result'] = DB::table('tbl_pms as p')
							->leftJoin('tbl_pms_staff_status as ps', function($join){
												$join->on('p.emp_id','=','ps.emp_id')
												->on('p.year_id','=','ps.year_id');
											})
							->where('p.emp_id',$emp_id)->where('p.year_id',2)
							->select('p.*', 'ps.status')
							->get();
		$data['all_pms_rating'] = DB::table('tbl_pms_rating')->get();
					  
		$data['emp_mapping'] = DB::table('tbl_emp_mapping as mapping')
							->leftjoin('tbl_department as dept','mapping.current_department_id','=','dept.department_id')
							->leftjoin('tbl_unit_name as unit','mapping.unit_id','=','unit.id')
							->where('mapping.emp_id', $emp_id)
							->orderBy('mapping.id', 'desc')
							->select('dept.department_name', 'unit.unit_name', 'mapping.current_program_id')
							->first();
		
		$letter_date = date('Y-m-d');
		//print_r($data['all_result']);
		$data['employee_info'] = $employee_info = DB::table('tbl_pms_staff_status as pms')
								->leftjoin('tbl_emp_basic_info as e', 'pms.emp_id', '=', 'e.emp_id')
								->leftjoin('tbl_branch as b', 'pms.br_code', '=', 'b.br_code')
								->leftjoin('tbl_designation as d', 'pms.designation_code', '=', 'd.designation_code')
								->leftjoin('tbl_grade_new as g', 'pms.grade_code', '=', 'g.grade_id')
								->where('pms.emp_id', $emp_id)
								->where('pms.year_id', 2)
								->select('pms.*','e.emp_name_eng','e.org_join_date','b.branch_name','d.designation_name','g.grade_name')
								->first();
				
		$data['all_pms_approve'] = DB::table('tbl_pms_approve')->where('emp_id', $emp_id)->where('year_id',2)->first();
		$data['all_pms_config'] = DB::table('tbl_pms_config')->orderBy('id')->get();
		//echo '<pre/>';
		$pms_status = DB::table('tbl_pms_staff_status')->where('emp_id', $emp_id)->where('year_id',2)->first();
		//print_r($data['employee_info']);
		if($id == 2) {
			if($pms_status->status == 2) {			
				return view('admin.pages.pms.pms_supervisorlist',$data);
			} else {
				//return view('admin.pages.pms.pms_view_entry_form',$data); // for 1st approval
				return view('admin.pages.pms.pms_view_submission_form',$data);// for Submission approval
			}				
		} else {
			return view('admin.pages.pms.pms_view_form',$data);	
		}

    }
	
	public function PmsEmployeeSearch(Request $request)
    {
		$data = array();
		$data['assessment_year'] = $assessment_year = $request->assessment_year;
		$data['emp_id'] = $emp_id = $request->emp_id;
		$form_date = date('Y-m-d');
		$login_emp_id = Session::get('emp_id');
		$supervisors_type = Session::get('supervisors_type');
		$data['count_id'] = 1;
		$supervisor_config = DB::table('tbl_pms_supervisor_config')->where('emp_id', Session::get('emp_id'))->first();
		$data['super_visor_type'] = $super_visor_type = $supervisor_config->supervisor_type;
		$data['all_result'] = DB::table('tbl_pms as p')
							->leftjoin('tbl_emp_basic_info as e', 'p.emp_id', '=', 'e.emp_id')
							->leftjoin('tbl_pms_staff_status as ps', 'p.emp_id', '=', 'ps.emp_id')
							->select('p.*','ps.status','ps.sub_status','ps.super_visor_id as super_visorid','ps.sub_super_visor_id as sub_super_visorid','e.emp_name_eng')
							->where('ps.year_id', $assessment_year)
							->Where(function($query) use ($super_visor_type, $login_emp_id) {
									if($super_visor_type == 1) {
										$query->where('ps.super_visor_id',$login_emp_id);
										$query->whereIn('ps.status', [1, 2]);
										$query->whereIn('ps.sub_status', [1, 0]);										
									}else if($super_visor_type == 2) {
										$query->where('ps.sub_super_visor_id', $login_emp_id);
										$query->where('ps.status',1);
										$query->where('ps.sub_status',1);
									} else if($super_visor_type == 3) {
										$query->whereIn('ps.status', [1, 2]);
										$query->where('ps.sub_status',1);
										$query->where('ps.super_visor_id',$login_emp_id);
										$query->orWhere('ps.sub_super_visor_id',$login_emp_id);
									}							
								})
							->where('ps.complete_status', 0)
							->groupBy('p.emp_id')					  
							->get();
		//print_r($data['all_result']); exit;
		$data['all_result1'] = DB::table('tbl_pms as p')
								->leftJoin('tbl_pms_staff_status as ps', function($join){
												$join->on('p.emp_id','=','ps.emp_id')
												->on('p.year_id','=','ps.year_id');
											})
								->where('p.emp_id',$data['emp_id'])
								->where('p.year_id', $assessment_year)
								->whereIn('ps.status', [1, 2, 3])
								->Where(function($query) use ($super_visor_type, $login_emp_id) {
									if($super_visor_type == 1) {
										$query->where('ps.super_visor_id',$login_emp_id);										
									}else if($super_visor_type == 2) {
										$query->where('ps.sub_super_visor_id', $login_emp_id);
									} else if($super_visor_type == 3) {
										$query->where('ps.super_visor_id',$login_emp_id);
										$query->orWhere('ps.sub_super_visor_id',$login_emp_id);
									}							
								})
								->get();
		//print_r($data['all_result1']); exit;						
		$data['pms_submitted'] = DB::table('tbl_pms_staff_status')
								->where('year_id', $assessment_year)
								->Where(function($query) use ($supervisors_type, $login_emp_id) {
									if($supervisors_type == 1) {
										$query->where('super_visor_id',$login_emp_id);
										$query->orWhere('sub_super_visor_id',$login_emp_id);
									}else if($supervisors_type == 2) {
										$query->where('sub_super_visor_id', $login_emp_id);
									}							
								})
								->get();
								
		
								
		$data['pms_approved'] = DB::table('tbl_pms_staff_status')
								->where('status', '!=', 1)
								->Where(function($query) use ($assessment_year, $login_emp_id) {
									if($assessment_year == 1) {
										$query->where('year_id',$assessment_year);
										$query->where('super_visor_id',$login_emp_id);
									}else if($assessment_year == 2) {
										$query->where('year_id',$assessment_year);
										$query->where('super_visor_id',$login_emp_id);
										$query->orWhere('sub_super_visor_id',$login_emp_id);
									}							
								})								
								->get();
		$data['pmsapproved'] = DB::table('tbl_pms_staff_status')->where('super_visor_id', Session::get('emp_id'))->where('status', 3)->where('year_id', $assessment_year)->get();
		$data['pms_submission'] = DB::table('tbl_pms_staff_status')->where('super_visor_id', $login_emp_id)->where('submission_status', 3)->where('year_id', $assessment_year)->get();
		$data['pms_submission_complete'] = DB::table('tbl_pms_staff_status')->where('super_visor_id', $login_emp_id)->where('submission_status', 3)->where('complete_status', 4)->where('year_id', $assessment_year)->get();
		$data['pms_final_score'] = DB::table('tbl_pms_final_score')->where('emp_id', $emp_id)->where('year_id', $assessment_year)->first();
		
		$data['all_pms_config'] = DB::table('tbl_pms_marks_entry as pe')
								->leftjoin('tbl_pms_config as pc', 'pe.c_no', '=', 'pc.id')
								->where('emp_id', $emp_id)
								->where('year_id', $assessment_year)
								->select('pe.*','pc.c_detail')
								->get();
								
		$data['pms_staff_status'] = DB::table('supervisor_mapping_ho as sm')
									->leftJoin('tbl_resignation as r', 'sm.emp_id', '=', 'r.emp_id')
									->where('sm.supervisor_id', $login_emp_id)
									->Where(function($query) use ($supervisors_type, $login_emp_id) {
									if($supervisors_type == 1) {
											$query->whereIn('sm.supervisor_type', [1, 2]);
										}else if($supervisors_type == 2) {
											$query->where('sm.supervisor_type', 2);
										}							
									})
									->where('sm.is_pms', 1)
									->Where(function($query) use ($form_date) {
										$query->whereNull('r.emp_id');
										$query->orWhere('r.effect_date', '>', $form_date);								
									})
									->select('sm.*')
									->get();
		$data['all_pms_approve'] = $all_pms_approve = DB::table('tbl_pms_approve')->where('emp_id', $emp_id)->where('year_id', $assessment_year)->first();
		//print_r($data['all_pms_config']);
		if(!empty($all_pms_approve)) {
				$c_one_item =   explode(',',$all_pms_approve->c_one);
				$c_two_item =   explode(',',$all_pms_approve->c_two);
				$c_three_item =   explode(',',$all_pms_approve->c_three);
				$c_four_item =   explode(',',$all_pms_approve->c_four);
				//print_r ($c_one_item);
				
				foreach ($c_one_item as $key => $value) {
					$c_one_row = DB::table('tbl_pms_config')
							->where('c_value', '=', $value)
							->select('c_value','c_no','c_detail')
							->first();
					$data['all_c_one_item'][] = array(
						'c_one_value'      => $value,
						'c_one_detail'      => $c_one_row->c_detail
					);
				}
				
				foreach ($c_two_item as $key2 => $value2) {
					$c_two_row = DB::table('tbl_pms_config')
							->where('c_value', '=', $value2)
							->select('c_value','c_no','c_detail')
							->first();
					$data['all_c_two_item'][] = array(
						'c_two_value'      => $value2,
						'c_two_detail'      => $c_two_row->c_detail
					);
				}
				
				foreach ($c_three_item as $key3 => $value3) {
					$c_three_row = DB::table('tbl_pms_config')
							->where('c_value', '=', $value3)
							->select('c_value','c_no','c_detail')
							->first();
					$data['all_c_three_item'][] = array(
						'c_three_value'      => $value3,
						'c_three_detail'      => $c_three_row->c_detail
					);
				}
				
				foreach ($c_four_item as $key4 => $value4) {
					$c_four_row = DB::table('tbl_pms_config')
							->where('c_value', '=', $value4)
							->select('c_value','c_no','c_detail')
							->first();
					$data['all_c_four_item'][] = array(
						'c_four_value'      => $value4,
						'c_four_detail'      => $c_four_row->c_detail
					);
				}
			}
			//print_r($data['all_c_one_item']);
		$data['emp_mapping'] = DB::table('tbl_emp_mapping as mapping')
								->leftjoin('tbl_department as dept','mapping.current_department_id','=','dept.department_id')
								->leftjoin('tbl_unit_name as unit','mapping.unit_id','=','unit.id')
								->where('mapping.emp_id', $emp_id)
								->orderBy('mapping.id', 'desc')
								->select('dept.department_name', 'unit.unit_name', 'mapping.current_program_id')
								->first();
		
		$letter_date = date('Y-m-d');
			
		$max_sarok = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $emp_id)
					->where('m.br_join_date', '=', function ($query) use ($emp_id, $letter_date) {
						$query->select(DB::raw('max(br_join_date)'))
							->from('tbl_master_tra')
							->where('emp_id', $emp_id)
							->where('br_join_date', '<=', $letter_date);
					})
					->select('m.emp_id', DB::raw('max(m.sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
				
		if(!empty($max_sarok)) {		
			$data['employee_info'] = DB::table('tbl_master_tra as m')
								->leftjoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
								->leftjoin('tbl_branch as b', 'b.br_code', '=', 'm.br_code')								
								->where('m.sarok_no', $max_sarok->sarok_no)
								->where('m.status', 1)
								->select('m.br_join_date','e.emp_name_eng','e.org_join_date','b.branch_name')
								->first();			  
		}
		
		$max_sarok_designation = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $emp_id)
					->where('m.letter_date', '=', function($query) use ($emp_id, $letter_date)
						{
							$query->select(DB::raw('max(letter_date)'))
								  ->from('tbl_master_tra')
								  ->where('emp_id',$emp_id)
								  ->where('effect_date', '<=', $letter_date);
						})
					->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
		if(!empty($max_sarok_designation)) {
		$data['employee_designation'] = DB::table('tbl_master_tra as m')
				->leftjoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
				->leftjoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_id')
				->where('m.sarok_no', $max_sarok_designation->sarok_no)
				->where('m.status', 1)
				->select('m.grade_step','d.designation_name','g.grade_name')
				->first();
		}
		//print_r($data['all_result']);
		
		return view('admin.pages.pms.pms_supervisor_list',$data);	

    }
	
	public function PmsSubmitSupervisor($id)
    {
		$data['emp_id'] = $emp_id = Session::get('emp_id');
		$result=DB::table('tbl_pms')->where('emp_id',$data['emp_id'])->where('year_id',2)->first();
		$data['status'] = 1;
		$data['year_id'] = 2;
		$data['super_visor_id'] = $result->super_visor_id;
		$data['sub_super_visor_id'] = $result->sub_super_visor_id;
		if($result->sub_super_visor_id == 0) {
			$data['sub_status'] = 0;
		} else {
			$data['sub_status'] = 1;
		}
		
		/////////////////
		$letter_date = date('Y-m-d');			
		$max_sarok = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $emp_id)
					->where('m.br_join_date', '=', function ($query) use ($emp_id, $letter_date) {
						$query->select(DB::raw('max(br_join_date)'))
							->from('tbl_master_tra')
							->where('emp_id', $emp_id)
							->where('br_join_date', '<=', $letter_date);
					})
					->select('m.emp_id', DB::raw('max(m.sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
				
		if(!empty($max_sarok)) {		
			$employee_info = DB::table('tbl_master_tra as m')								
								->where('m.sarok_no', $max_sarok->sarok_no)
								->where('m.status', 1)
								->select('m.br_code','m.designation_code','m.grade_code','m.grade_step')
								->first();			  
		$data['br_code'] = $employee_info->br_code;
		$data['designation_code'] = $employee_info->designation_code;
		$data['grade_code'] = $employee_info->grade_code;
		$data['grade_step'] = $employee_info->grade_step;
		}
		/////////////////
		DB::table('tbl_pms_staff_status')->insert($data);
		Session::put('message','Data Submitted Successfully');
		return Redirect::to('/pms-objective');

    }
	
	public function PmsApproveSave(Request $request)
    {
        $data = request()->except(['_token','professional','interpersonal','leadership','general']);
		$professional = $request->professional;
		$interpersonal = $request->interpersonal;
		$leadership = $request->leadership;
		$general = $request->general;
		if(empty($professional) || empty($interpersonal) || empty($leadership) || empty($general)) {
			return Redirect::to('pms-view/'.$data['emp_id'].'/2')->with('message', 'Please select at least one item from each component of section C!');			
		}
		$data['c_one'] = implode(', ', $professional);
		$data['c_two'] = implode(', ', $interpersonal);
		$data['c_three'] = implode(', ', $leadership);
		$data['c_four'] = implode(', ', $general);
		$data['super_visor_id'] = Session::get('emp_id');
		$data['year_id'] = 2;
		//print_r ($data); exit;
		$supervisors_type = Session::get('supervisors_type');
		//print_r ($data); exit;
		//$supervisor_config = DB::table('tbl_pms_supervisor_config')->where('emp_id', Session::get('emp_id'))->first();
		//$super_visor_type = $supervisor_config->supervisor_type;
		DB::beginTransaction();
		try {
			$pms_status = DB::table('tbl_pms_staff_status')->where('emp_id', $data['emp_id'])->where('year_id', 2)->first();
			DB::table('tbl_pms_approve')->insert($data);
			$adata['sub_super_visor_id'] = Session::get('emp_id');
			if($pms_status->status ==1 && $pms_status->sub_status ==1) {
				$adata['status'] = 2;
			} else {
				$adata['status'] = 3;
			}
			DB::table('tbl_pms_staff_status')->where('emp_id', $data['emp_id'])->where('year_id', 2)->update($adata);
			DB::commit();
			Session::put('message','Data Saved Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		}
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/pms-supervisor');

    }
	
	public function PmsApproveSupervisor(Request $request)
    {
        $data = request()->except(['_token','professional','interpersonal','leadership','general']);
		$professional = $request->professional;
		$interpersonal = $request->interpersonal;
		$leadership = $request->leadership;
		$general = $request->general;
		if(empty($professional) || empty($interpersonal) || empty($leadership) || empty($general)) {
			return Redirect::to('pms-view/'.$data['emp_id'].'/2')->with('message', 'Please select at least one item from each component of section C!');			
		}
		$data['c_one'] = implode(', ', $professional);
		$data['c_two'] = implode(', ', $interpersonal);
		$data['c_three'] = implode(', ', $leadership);
		$data['c_four'] = implode(', ', $general);
		$data['super_visor_id'] = Session::get('emp_id');
		$data['year_id'] = 2;
		//print_r ($data); exit;
		$supervisors_type = Session::get('supervisors_type');
		//print_r ($data); exit;
		DB::beginTransaction();
		try {
			DB::table('tbl_pms_approve')->where('emp_id', $data['emp_id'])->where('year_id', 2)->update($data);
			$adata['status'] = 3;
			DB::table('tbl_pms_staff_status')->where('emp_id', $data['emp_id'])->where('year_id', 2)->update($adata);
			DB::commit();
			Session::put('message','Data Saved Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		}
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/pms-supervisor');

    }
	
	public function PmsReport()
    {
        $data = array();
		$form_date = date('Y-m-d');
		$all_result1 = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.br_code', '=', 9999)
						->where('m.br_join_date', '<=', $form_date)
						->where(function($query) use ($form_date) {
								$query->whereNull('r.emp_id');
								$query->orWhere('r.effect_date', '>', $form_date);								
							})
						->whereNotIn('m.designation_code', [52, 75])
						->whereNotIn('m.emp_id', [2489, 3481, 1298])
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get();
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
							->leftJoin('tbl_pms as p', function($join){
												$join->where('p.year_id',2)
													->on('m.emp_id', '=', 'p.emp_id');
											})
							->leftJoin('tbl_pms_staff_status as ps', function($join){
												$join->where('ps.year_id',2)
													->on('m.emp_id', '=', 'ps.emp_id');
											})
							->where('m.sarok_no', '=', $max_sarok->sarok_no)
							->select('e.emp_name_eng','e.org_join_date','m.br_code','ps.status','ps.sub_status','ps.super_visor_id','ps.sub_super_visor_id')
							->first();
				
				$max_sarok_designation = DB::table('tbl_master_tra as m')
										->where('m.emp_id', '=', $emp_id)
										->where('m.letter_date', '=', function($query) use ($emp_id, $form_date)
											{
												$query->select(DB::raw('max(letter_date)'))
													  ->from('tbl_master_tra')
													  ->where('emp_id',$emp_id)
													  ->where('effect_date', '<=', $form_date);
											})
										->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
										->groupBy('emp_id')
										->first();
				if(!empty($max_sarok_designation)) {
					$employee_designation = DB::table('tbl_master_tra as m')
										->leftjoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
										->where('m.sarok_no', $max_sarok_designation->sarok_no)
										->where('m.status', 1)
										->select('d.designation_name')
										->first();
				}
				if ($data_result->br_code == 9999) {
							
					$data['all_result'][] = array(
						'emp_id' => $result->emp_id,
						'emp_name_eng'      => $data_result->emp_name_eng,
						'org_join_date'      => $data_result->org_join_date,
						'designation_name'      => $employee_designation->designation_name,
						'status'      => $data_result->status,
						'sub_status'      => $data_result->sub_status,
						'super_visor_id'      => $data_result->super_visor_id,
						'sub_super_visor_id'      => $data_result->sub_super_visor_id
					);
				}				
			}
		}
		$data['start_date'] = "2021-07-31";
		//echo '<pre>';
		//print_r($data['all_result']);
		return view('admin.pages.pms.pms_report',$data);
    }
	
	public function PmsSubmissionList()
    {
		$data = array();
		$data['emp_id'] = $emp_id = Session::get('emp_id');
		$data['all_result'] = DB::table('tbl_pms')->where('emp_id',$emp_id)->where('year_id',2)->get();
		$data['staff_status'] = DB::table('tbl_pms_staff_status')->where('emp_id',$emp_id)->where('year_id',2)->first();
		$data['balance'] = DB::table('tbl_pms')->where('emp_id', $emp_id)->where('year_id',2)->sum('task_weight');			  		  
		//print_r ($data['staff_status']);
		return view('admin.pages.pms.pms_submision_list',$data);	

    }
	
	public function PmsSubmissionSave(Request $request)
    {
        $data = request()->except(['_token']);

		$data['emp_id'] = Session::get('emp_id');
		
		$supervisor = DB::table('supervisor_mapping_ho as mapping')
					->leftJoin('supervisors as supervisor', 'supervisor.supervisors_emp_id', '=', 'mapping.supervisor_id')
					->leftJoin('tbl_designation as designation', 'designation.designation_code', '=', 'supervisor.designation_code')
					->leftJoin('tbl_emp_basic_info as basic', 'basic.emp_id', '=', 'mapping.emp_id')
					->where('mapping.emp_id', $data['emp_id'])
					->where('mapping.supervisor_type', 1)
					->select('supervisor.supervisors_name', 'mapping.supervisor_id', 'designation.designation_name', 'basic.emp_name_eng', 'supervisor.supervisors_email')
					->orderBy('mapping.mapping_id', 'desc')
					->first();
		
		$data['super_visor_id'] = $supervisor->supervisor_id;
		//print_r ($data); exit;
		if($data['id'] == 0) {
			DB::table('tbl_pms')->insert($data);
		} else {
			$adata['performed_task'] = $data['performed_task'];
			DB::table('tbl_pms')->where('id', $data['id'])->update($adata);
		}
		
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/pms-submission');

    }
	
	public function PmsSubmissionSupervisor($id)
    {
		$data['emp_id'] = Session::get('emp_id');
		$result=DB::table('tbl_pms')->where('emp_id',$data['emp_id'])->where('year_id',2)->first();
		$adata['submission_status'] = 3;
		DB::table('tbl_pms_staff_status')->where('emp_id', $data['emp_id'])->where('year_id',2)->update($adata);
		Session::put('message','Data Submitted Successfully');
		return Redirect::to('/pms-submission');

    }
	
	public function GetMarks($id)
    {
		$result=DB::table('tbl_pms_rating')->where('id',$id)->first();
		echo json_encode($result);

    }
	
	public function PmsFinalApproveSave(Request $request)
    {
        $data = request()->except(['_token','professional','interpersonal','leadership','general']);
		$result_item = $request->input('result_item');
		$profe_ssional = $request->input('professional');
		$inter_personal = $request->input('interpersonal');
		$leader_ship = $request->input('leadership');
		$gene_ral = $request->input('general');
		//print_r ($profe_ssional); exit;
		DB::beginTransaction();
		try {
			if (!empty($result_item)) {
				foreach ($result_item as $dataa) {
					$adata['score'] = $dataa['score'];
					$adata['weight_score'] = $dataa['weight_score'];
					$adata['comments'] = $dataa['comments'];
					DB::table('tbl_pms')->where('id', $dataa['id'])->update($adata);
				}
			}
			if (!empty($profe_ssional)) {
				foreach ($profe_ssional as $professional) {
					$pdata['emp_id'] = $data['emp_id'];
					$pdata['super_visor_id'] = Session::get('emp_id');
					$pdata['c_type'] = 1;
					$pdata['c_no'] = $professional['id'];
					$pdata['comments'] = $professional['comments'];
					$pdata['score'] = $professional['score'];
					$pdata['weight_score'] = $professional['weight_score'];
					$pdata['rating'] = $professional['rating'];
					$pdata['created_by'] = Session::get('emp_id');
					$pdata['year_id'] = 2;
					DB::table('tbl_pms_marks_entry')->insert($pdata);
				}
			}
			if (!empty($inter_personal)) {
				foreach ($inter_personal as $interpersonal) {
					$idata['emp_id'] = $data['emp_id'];
					$idata['super_visor_id'] = Session::get('emp_id');
					$idata['c_type'] = 2;
					$idata['c_no'] = $interpersonal['id'];
					$idata['comments'] = $interpersonal['comments'];
					$idata['score'] = $interpersonal['score'];
					$idata['weight_score'] = $interpersonal['weight_score'];
					$idata['rating'] = $interpersonal['rating'];
					$idata['created_by'] = Session::get('emp_id');
					$idata['year_id'] = 2;
					DB::table('tbl_pms_marks_entry')->insert($idata);
				}
			}
			if (!empty($leader_ship)) {
				foreach ($leader_ship as $leadership) {
					$ldata['emp_id'] = $data['emp_id'];
					$ldata['super_visor_id'] = Session::get('emp_id');
					$ldata['c_type'] = 3;
					$ldata['c_no'] = $leadership['id'];
					$ldata['comments'] = $leadership['comments'];
					$ldata['score'] = $leadership['score'];
					$ldata['weight_score'] = $leadership['weight_score'];
					$ldata['rating'] = $leadership['rating'];
					$ldata['created_by'] = Session::get('emp_id');
					$ldata['year_id'] = 2;
					DB::table('tbl_pms_marks_entry')->insert($ldata);
				}
			}
			if (!empty($gene_ral)) {
				foreach ($gene_ral as $general) {
					$gdata['emp_id'] = $data['emp_id'];
					$gdata['super_visor_id'] = Session::get('emp_id');
					$gdata['c_type'] = 4;
					$gdata['c_no'] = $general['id'];
					$gdata['comments'] = $general['comments'];
					$gdata['score'] = $general['score'];
					$gdata['weight_score'] = $general['weight_score'];
					$gdata['rating'] = $general['rating'];
					$gdata['created_by'] = Session::get('emp_id');
					$gdata['year_id'] = 2;
					DB::table('tbl_pms_marks_entry')->insert($gdata);
				}
			}
			$sdata['emp_id'] = $data['emp_id'];
			$sdata['super_visor_id'] = Session::get('emp_id');
			$sdata['year_id'] = 2;
			$sdata['score_b'] = $data['score_b'];
			$sdata['score_c1'] = $data['score_c1'];
			$sdata['score_c2'] = $data['score_c2'];
			$sdata['score_c3'] = $data['score_c3'];
			$sdata['score_c4'] = $data['score_c4'];
			$sdata['created_by'] = Session::get('emp_id');
			DB::table('tbl_pms_final_score')->insert($sdata);		
			$mdata['complete_status'] = 4;
			DB::table('tbl_pms_staff_status')->where('emp_id', $data['emp_id'])->where('year_id', 2)->update($mdata);
		
			DB::commit();
			Session::put('message','Data Saved Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		}	
		
		//Session::put('message','Data Saved Successfully');
		return Redirect::to('/pms-assessment-report');

    }
	
	public function PmsAssessmentReport()
    {
        $data = array();
		$login_emp_id = Session::get('emp_id');
		$form_date = date('Y-m-d');
		$data['assessment_year'] = 1;
		$data['department_id'] = '';
		$data['all_department'] = DB::table('tbl_department')->where('status', 1)->get();
		$data['all_result'] = DB::table('tbl_pms_staff_status as ps')
							->leftJoin('tbl_emp_basic_info as e', 'ps.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_pms_final_score as pfs', function($join){
								$join->on('ps.emp_id','=','pfs.emp_id')
								->on('ps.year_id','=','pfs.year_id');
							})
							//->leftJoin('tbl_pms_final_score as pfs', 'ps.emp_id', '=', 'pfs.emp_id')
							->leftjoin('tbl_designation as d', 'ps.designation_code', '=', 'd.designation_code')
							->leftjoin('tbl_department as dept','ps.department_code','=','dept.department_id')
							->where('ps.year_id', '=', 1)
							/* ->where(function($query) use ($department_id) {
								if(!empty($department_id)) {
									$query->where('ps.department_code', '=', $department_id);
								}
							}) */
							->select('pfs.*','ps.status','ps.emp_id as empid','ps.sub_status','ps.super_visor_id','ps.sub_super_visor_id','e.emp_name_eng','e.org_join_date','d.designation_name','dept.department_name')
							->get();
		//echo '<pre>';
		//print_r($data['all_result']);
		return view('admin.pages.pms.pms_assessment_report',$data);
    }
	
	public function PmsAssessmentReportSearch(Request $request)
    {
        $data = array();
		$login_emp_id = Session::get('emp_id');
		$data['assessment_year'] = $assessment_year = $request->assessment_year;
		$data['department_id'] = $department_id = $request->department_id;
		$data['all_department'] = DB::table('tbl_department')->where('status', 1)->get();
		$data['all_result'] = DB::table('tbl_pms_staff_status as ps')
							->leftJoin('tbl_emp_basic_info as e', 'ps.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_pms_final_score as pfs', function($join){
								$join->on('ps.emp_id','=','pfs.emp_id')
								->on('ps.year_id','=','pfs.year_id');
							})
							//->leftJoin('tbl_pms_final_score as pfs', 'ps.emp_id', '=', 'pfs.emp_id')
							->leftjoin('tbl_designation as d', 'ps.designation_code', '=', 'd.designation_code')
							->leftjoin('tbl_department as dept','ps.department_code','=','dept.department_id')
							->where('ps.year_id', '=', $assessment_year)
							->where(function($query) use ($department_id) {
								if(!empty($department_id)) {
									$query->where('ps.department_code', '=', $department_id);
								}
							})
							->select('pfs.*','ps.status','ps.emp_id as empid','ps.sub_status','ps.super_visor_id','ps.sub_super_visor_id','e.emp_name_eng','e.org_join_date','d.designation_name','dept.department_name')
							->get();
		
		return view('admin.pages.pms.pms_assessment_report',$data);
    }
	
	public function PmsAssessment()
    {
        $data = array();
		$login_emp_id = Session::get('emp_id');
		$data['assessment_year'] = '';
		$data['department_id'] = '';
		$data['all_department'] = DB::table('tbl_department')->where('status', 1)->get();
		return view('admin.pages.pms.pms_assessment',$data);
    }
	
	public function PmsAsesmentView()
    {
        $data = array();
		$login_emp_id = Session::get('emp_id');
		$data['assessment_year'] = '';
		$data['department_id'] = '';
		$data['all_department'] = DB::table('tbl_department')->where('status', 1)->get();
		return view('admin.pages.pms.pms_assessment',$data);
    }
	
	public function PmsAssessmentDetail(Request $request)
    {
		$data = array();
		$data['assessment_year'] = $assessment_year = $request->assessment_year;
		$data['department_id'] = $department_id = $request->department_id;
		$data['emp_id'] = $emp_id = $request->emp_id;
		$data['all_result1'] = DB::table('tbl_pms')->where('emp_id',$emp_id)->where('year_id',$assessment_year)->get();
		$data['all_pms_rating'] = DB::table('tbl_pms_rating')->get();
		$data['all_department'] = DB::table('tbl_department')->where('status', 1)->get();
					  
		
		$data['all_result'] = DB::table('tbl_pms_staff_status as ps')
							->leftJoin('tbl_emp_basic_info as e', 'ps.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_pms_final_score as pfs', function($join){
								$join->on('ps.emp_id','=','pfs.emp_id')
								->on('ps.year_id','=','pfs.year_id');
							})
							//->leftJoin('tbl_pms_final_score as pfs', 'ps.emp_id', '=', 'pfs.emp_id')
							->leftjoin('tbl_designation as d', 'ps.designation_code', '=', 'd.designation_code')
							->leftjoin('tbl_department as dept','ps.department_code','=','dept.department_id')
							->where('ps.year_id', '=', $assessment_year)
							->where(function($query) use ($department_id) {
								if(!empty($department_id)) {
									$query->where('ps.department_code', '=', $department_id);
								}
							})
							->select('pfs.*','ps.status','ps.emp_id as empid','ps.sub_status','ps.super_visor_id','ps.sub_super_visor_id','e.emp_name_eng','e.org_join_date','d.designation_name','dept.department_name')
							->get();
				
		
		$data['emp_mapping'] = DB::table('tbl_emp_mapping as mapping')
								->leftjoin('tbl_department as dept','mapping.current_department_id','=','dept.department_id')
								->leftjoin('tbl_unit_name as unit','mapping.unit_id','=','unit.id')
								->where('mapping.emp_id', $emp_id)
								->orderBy('mapping.id', 'desc')
								->select('dept.department_name', 'unit.unit_name', 'mapping.current_program_id')
								->first();
		
		$letter_date = date('Y-m-d');
			
		$max_sarok = DB::table('tbl_master_tra as m')
							->where('m.emp_id', '=', $emp_id)
							->where('m.br_join_date', '=', function ($query) use ($emp_id, $letter_date) {
								$query->select(DB::raw('max(br_join_date)'))
									->from('tbl_master_tra')
									->where('emp_id', $emp_id)
									->where('br_join_date', '<=', $letter_date);
							})
							->select('m.emp_id', DB::raw('max(m.sarok_no) as sarok_no'))
							->groupBy('emp_id')
							->first();
				
		if(!empty($max_sarok)) {		
		$data['employee_info'] = DB::table('tbl_master_tra as m')
							->leftjoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
							->leftjoin('tbl_branch as b', 'b.br_code', '=', 'm.br_code')				
							->where('m.sarok_no', $max_sarok->sarok_no)
							->where('m.status', 1)
							->select('m.br_join_date','e.emp_name_eng','e.org_join_date','b.branch_name')
							->first();
		}
		$data['employee_designation'] = DB::table('tbl_pms_staff_status as p')
							->leftjoin('tbl_designation as d', 'p.designation_code', '=', 'd.designation_code')
							->leftjoin('tbl_grade_new as g', 'p.grade_code', '=', 'g.grade_id')
							->where('p.emp_id', $emp_id)
							->where('p.year_id', $assessment_year)
							->select('p.grade_step','d.designation_name','g.grade_name')
							->first();
				
		$data['pms_final_score'] = DB::table('tbl_pms_final_score')->where('emp_id', $emp_id)->where('year_id', $assessment_year)->first();
		$data['all_pms_approve'] = DB::table('tbl_pms_approve')->where('emp_id', $emp_id)->where('year_id', $assessment_year)->first();
		$data['all_pms_config'] = DB::table('tbl_pms_marks_entry as pe')
							->leftjoin('tbl_pms_config as pc', 'pe.c_no', '=', 'pc.id')
							->where('pe.emp_id', $emp_id)
							->where('pe.year_id', $assessment_year)
							->select('pe.*','pc.c_detail')
							->get();
		//echo '<pre/>';
		//print_r($data['all_pms_config']);
		//$data['all_pms_config'] = DB::table('tbl_pms_config')->orderBy('id')->get();
		if(empty($emp_id)) {
			return view('admin.pages.pms.pms_assessment',$data);
		} else {
			return view('admin.pages.pms.pms_assessment_detail',$data);
		}		

    }
	
	public function PmsAssessmentView($emp_id,$year_id)
    {
		$data = array();
		$data['emp_id'] = $emp_id;
		$data['all_result'] = DB::table('tbl_pms')->where('emp_id',$emp_id)->where('year_id',$year_id)->get();
		$data['all_pms_rating'] = DB::table('tbl_pms_rating')->get();
					  
		$data['emp_mapping'] = DB::table('tbl_emp_mapping as mapping')
			->leftjoin('tbl_department as dept','mapping.current_department_id','=','dept.department_id')
			->leftjoin('tbl_unit_name as unit','mapping.unit_id','=','unit.id')
			->where('mapping.emp_id', $emp_id)
			->orderBy('mapping.id', 'desc')
			->select('dept.department_name', 'unit.unit_name', 'mapping.current_program_id')
			->first();
		
		$letter_date = date('Y-m-d');
			
		$max_sarok = DB::table('tbl_master_tra as m')
							->where('m.emp_id', '=', $emp_id)
							->where('m.br_join_date', '=', function ($query) use ($emp_id, $letter_date) {
								$query->select(DB::raw('max(br_join_date)'))
									->from('tbl_master_tra')
									->where('emp_id', $emp_id)
									->where('br_join_date', '<=', $letter_date);
							})
							->select('m.emp_id', DB::raw('max(m.sarok_no) as sarok_no'))
							->groupBy('emp_id')
							->first();
				
				
		$data['employee_info'] = DB::table('tbl_master_tra as m')
							->leftjoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
							->leftjoin('tbl_branch as b', 'b.br_code', '=', 'm.br_code')				
							->where('m.sarok_no', $max_sarok->sarok_no)
							->where('m.status', 1)
							->select('m.br_join_date','e.emp_name_eng','e.org_join_date','b.branch_name')
							->first();
		
		$data['employee_designation'] = DB::table('tbl_pms_staff_status as p')
							->leftjoin('tbl_designation as d', 'p.designation_code', '=', 'd.designation_code')
							->leftjoin('tbl_grade_new as g', 'p.grade_code', '=', 'g.grade_id')
							->where('p.emp_id',$emp_id)
							->where('p.year_id',$year_id)
							->select('p.grade_step','d.designation_name','g.grade_name')
							->first();
				
		$data['pms_final_score'] = DB::table('tbl_pms_final_score')->where('emp_id', $emp_id)->where('year_id',$year_id)->first();
		$data['all_pms_approve'] = DB::table('tbl_pms_approve')->where('emp_id', $emp_id)->where('year_id',$year_id)->first();
		$data['all_pms_config'] = DB::table('tbl_pms_marks_entry as pe')
							->leftjoin('tbl_pms_config as pc', 'pe.c_no', '=', 'pc.id')
							->where('pe.emp_id', $emp_id)
							->where('pe.year_id',$year_id)
							->select('pe.*','pc.c_detail')
							->get();
		//echo '<pre/>';
		//print_r($data['all_pms_config']);
		//$data['all_pms_config'] = DB::table('tbl_pms_config')->orderBy('id')->get();
		
		return view('admin.pages.pms.pms_assessment_view',$data);		

    }
	
	private function cheeck_action_permission($action_id)
	{
		$access_label 	= Session::get('admin_access_label');		
		$nav_name 		=  '/'.request()->segment(1);
		$nav_info		= DB::table('tbl_navbar')->where('nav_action',$nav_name)->first();	
		$nav_id 		= $nav_info->nav_id;
		$permission    	= DB::table('tbl_user_permissions')
							->where('user_role_id',$access_label)
							->where('nav_id',$nav_id)
							->where('status',1)
							->first();
		if($permission)
		{
			if(in_array($action_id,$p = explode(",", $permission->permission)))
			{
				return true;
			}
			else
			{
				return false;
			}
		}	
		else
		{
			return false;
		}
	}
   
}
