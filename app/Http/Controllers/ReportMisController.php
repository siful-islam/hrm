<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class ReportMisController extends Controller
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
	
    public function BranchWiseMisIndex()
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'All MIS Staff Report';
		$data['form_date']	= '2019-06-30';	
		$data['status']		= '';
		$data['all_designation'] = $all_designation = DB::table('tbl_designation')->where('status',1)->select('designation_code','designation_name')->get();
		$data['all_branch'] = $all_branch = DB::table('tbl_branch')->where('br_code',1)->select('br_code','branch_name')->get();
		
		return view('admin.pages.service_length_reports.branch_wise_mis_staff',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function BranchWiseMisReport(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'All MIS Staff Report';
		$data['form_date'] 	= $form_date = $request->input('form_date');
		$data['status'] 	= $status = $request->input('status');
		$data['all_designation'] = $all_designation = DB::table('tbl_designation')->where('status',1)->select('designation_code','designation_name')->get();
		$data['all_branch'] = $all_branch = DB::table('tbl_branch')->where('status', '=', 1)->select('br_code','branch_name')->get();
		foreach ($all_branch as $branch) {
			$data['all_result'] =  array();
			
			$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.br_code', '=', $branch->br_code)
						//->where('m.br_code', '=', 1)
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
			$assign_branch = DB::table('tbl_emp_assign')
											->where('br_code', '=', $branch->br_code)
											//->where('br_code', '=', 1)
											->where('status', '!=', 0)
											->where('select_type', '=', 2)
											->select('emp_id')
											->get()->toArray();
			$all_result1 = array_unique(array_merge($all_result,$assign_branch), SORT_REGULAR);
			//print_r ($all_result1); exit;
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
							->groupBy('emp_id')
							->first();
					//print_r ($max_sarok);
					$data_result = DB::table('tbl_master_tra')
								->where('sarok_no', '=', $max_sarok->sarok_no)
								->select('emp_id','br_code','designation_code')
								->first();
					//print_r ($data_result);
					//// employee assign ////
					$assign_designation = DB::table('tbl_emp_assign')
												->where('emp_id', $result->emp_id)
												->where('status', '!=', 0)
												->where('select_type', '=', 5)
												->select('emp_id','designation_code')
												->first();
					if(empty($assign_designation)) {
						$designation_code = $data_result->designation_code;
					} else {
						$designation_code = $assign_designation->designation_code;
					}
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
					if ($branch->br_code == $result_br_code) {	
						$data['all_result'][] = array(
									'emp_id' => $data_result->emp_id,
									'br_code'      => $result_br_code,
									'designation_code'      => $designation_code
						);
					}				
				}
				
				
				//print_r ($data['all_result2']);
				$nonid_result = DB::table('tbl_emp_non_id as en')
								->leftjoin('tbl_nonid_official_info as noi',function($join){
									$join->on("en.emp_id","=","noi.emp_id")
										->where('noi.joining_date',DB::raw("(SELECT 
																	  max(joining_date)
																	  FROM tbl_nonid_official_info 
																	   where en.emp_id = emp_id
																	  )") 		 
												); 
											})
								->leftJoin('tbl_emp_non_id_cancel as nc', 'en.emp_id', '=', 'nc.emp_id')
								->where('noi.br_code', '=', $branch->br_code)
								//->where('noi.br_code', '=', 1)
								->Where('noi.joining_date', '<=', $form_date)
								->Where(function($query) use ($form_date) {
										$query->whereNull('nc.emp_id');
										$query->orWhere('nc.cancel_date', '>', $form_date);								
									})
								->select('en.emp_id','en.sacmo_id','noi.br_code','noi.designation_code')
								->get();
								
				foreach ($nonid_result as $nonid_br) {
					$data['all_result'][] = array(
								'emp_id' => $nonid_br->emp_id,
								'non_id' => $nonid_br->sacmo_id,
								'br_code' => $nonid_br->br_code,
								'designation_code' => $nonid_br->designation_code
					);
				}

			}
			if (!empty($data['all_result'])) {
				$data['designation_group_total'] = array_count_values(array_column($data['all_result'], 'designation_code'));
			}
				
			foreach($data['designation_group_total'] as $key => $value) {
				$data['all_result2'][] = array(
								'br_code'      => $branch->br_code,
								'designation_code'      => $key,
								'designation_value'      => $value
					);
			}
		
		}
		//print_r ($data['all_result2']); //exit;
		return view('admin.pages.service_length_reports.branch_wise_mis_staff',$data);
    }
	
	public function AutoIncrementIndex()
    {
		$data = array();
		$data['Heading'] = $data['title'] = 'Auto Increment Check';
		$data['effect_date']	= '';
				
		return view('admin.pages.service_length_reports.auto_increment_check',$data);
    }
	
    
	public function AutoIncrementReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Auto Increment Check';
		$data['effect_date'] = $form_date = $request->input('effect_date');
		$effect_date = '2019-06-30';
		$all_result = DB::table('tbl_increment as i')
							->where('i.effect_date', '=', $form_date)
							->select('i.emp_id')
							->OrderBy('i.emp_id')
							->get();

		if (!empty($all_result)) {
			foreach ($all_result as $result) {
				$emp_id = $result->emp_id;				
				$max_sarok = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $result->emp_id)
					->where('m.letter_date', '=', function($query) use ($emp_id,$effect_date)
							{
								$query->select(DB::raw('max(letter_date)'))
									  ->from('tbl_master_tra')
									  ->where('emp_id',$emp_id)
									  ->where('letter_date', '<=', $effect_date);
							})
					->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
			
			$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->select('m.emp_id','e.emp_name_eng','m.grade_code','m.grade_step','m.designation_code','m.basic_salary','g.grade_name','d.designation_name','b.branch_name')
						->first();
			
			
			//// employee assign ////
			$assign_designation = DB::table('tbl_emp_assign as ea')
							->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
							->where('ea.emp_id', $result->emp_id)
							->where('ea.open_date', '<=', $effect_date)
							->where('ea.status', '!=', 0)
							->where('ea.select_type', '=', 5)
							->select('ea.emp_id','ea.open_date','de.designation_name')
							->first();
			if(!empty($assign_designation)) {
				$designation_name = $assign_designation->designation_name;
			} else {
				$designation_name = $data_result->designation_name;
			}
			$assign_branch = DB::table('tbl_emp_assign as ea')
							->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code')
							->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
							->where('ea.emp_id', $result->emp_id)
							->where('ea.open_date', '<=', $effect_date)
							->where('ea.status', '!=', 0)
							->where('ea.select_type', '=', 2)
							->select('ea.emp_id','ea.open_date','br.branch_name','ar.area_name')
							->first();
			if(!empty($assign_branch)) {
				$branch_name = $assign_branch->branch_name;
			} else {
				$branch_name = $data_result->branch_name;
			}
			////////
			$data['all_result'][] = array(
					'emp_id' => $data_result->emp_id,
					'emp_name_eng'      => $data_result->emp_name_eng,
					'grade_code'      => $data_result->grade_code,
					'grade_name'      => $data_result->grade_name,
					'grade_step'      => $data_result->grade_step,
					'basic_salary'      => $data_result->basic_salary,
					'designation_name'      => $designation_name,
					'branch_name'      => $branch_name
				);
			}	
		}
		
		//print_r ($data['all_result']);
		return view('admin.pages.service_length_reports.auto_increment_check',$data);
		
	}
	
	

	
}
