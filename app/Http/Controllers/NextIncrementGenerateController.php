<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
use PDF;
use File;

class NextIncrementGenerateController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}	
 	

	
	public function NextIncrementIndex()
    {
		/*$designation_code = 4444;
		$hobe_na = array(209,211,122,212,75);
		$is_in  = in_array($designation_code, $hobe_na);
		
		if($is_in == '')
		{
			echo 'hello';
		}

		exit;
		*/
		
		
		$data = array();
		$data['Heading'] = $data['title'] = 'Next Increment Staff';	
		
		
		//increment_date
		$data['increment_date']	= '2019-07-01';
		
		$data['search_branch']	= '';
		$data['no_increment']	= 1;
		$data['branch_code']	= '';
		$data['search_month']	= '07';
		$data['search_year']	= date('Y');
		$data['all_branches'] 	= DB::table('tbl_branch')->where('status',1)->where('auto_increment_status',0)->get();
		return view('admin.auto_increment.generate_auto_increment',$data);
    }
	
	public function NextIncrementReport(Request $request)
	{
		$data = array();
		$data['all_branches'] 		= DB::table('tbl_branch')->where('status',1)->where('auto_increment_status',0)->get();
		$data['Heading'] = $data['title'] = 'Next Increment Staff';
		
		
		
		$search_branch = $request->input('search_branch');
		$search_month = $request->input('search_month');
		$search_year = $request->input('search_year');

		
		
		$increment_date = $search_year.'-'.$search_month.'-01';
		
		$data['increment_date'] = $increment_date;
		$data['search_month'] 	= $search_month;
		$data['search_year'] 	= $search_year;
		$data['search_branch'] 	= $search_branch;
		$data['branch_code'] 	= $search_branch;
		

		$data['br_code'] = $br_code = $search_branch;
		$data['form_date'] = $form_date = $increment_date;
		$data['status'] = $status = 1;
		$data['no_increment '] = 1;
		
		$today = date('Y-m-d');


		/*$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
						->where('m.br_code', '=', $data['br_code'])
						->where('m.is_permanent', '=', 2)
						//->where('m.br_join_date', '<=', $form_date)
						//->where('m.br_join_date', '<=', $today)
						->where('m.br_join_date', '<=', '2020-07-01')
						->where(function($query) use ($status, $form_date) {
								$query->whereNull('r.emp_id');
								$query->orWhere('r.effect_date', '>', '2020-08-01');
							})
						
						->select('m.emp_id')
						->groupBy('m.emp_id')
						->get()->toArray();	
*/

				$all_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
							->leftJoin('tbl_heldup as h', function($join) use ($increment_date) {
												$join->where('h.what_heldup', '=', 'Increment')
													->where('h.next_increment_date', '!=', $increment_date)
													->on('m.emp_id', '=', 'h.emp_id');
											})
							->where('m.br_code', '=', $data['br_code'])
							->where('m.next_increment_date', '=', $increment_date)
							->where('m.is_permanent', '=', 2)
								//->where('m.br_join_date', '<=', $form_date)
								//->where('m.br_join_date', '<=', $today)
								//->where('m.br_join_date', '<=', '2020-07-01')
								//->where('m.tran_type_no', '!=', 1)
								->where(function($query) use ($increment_date) {
								$query->whereNull('r.emp_id');
								$query->orWhere('r.effect_date', '>=', '2021-08-01'); 
							})
							->where(function($query) {
								$query->whereNull('h.emp_id');
							})
							//->select('m.emp_id','m.next_increment_date')
							//->groupBy('m.next_increment_date')
							//->groupBy('m.emp_id')
							->select('m.emp_id')
							->groupBy('m.emp_id')
							->orderBy('m.emp_id', 'ASC')
							->get()->toArray();			
							//effect_date br_join_date



						
						
	
		//print_r($all_result);
		////////////////
		/* $assign_branch = DB::table('tbl_emp_assign')
										->where('br_code', '=', $data['br_code'])
										->where('status', '!=', 0)
										->where('select_type', '=', 2)
										->select('emp_id')
										->get()->toArray(); */
										
		$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										//->where('eas.br_code', '=', $data['br_code'])
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($status, $form_date) {
											$query->whereNull('r.emp_id');
											$query->orWhere('r.effect_date', '>', '2021-08-01');
										})									
										->select('eas.emp_id')
										->get()->toArray();								
		//print_r($assign_branch);
		//exit;
			
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
				
					
					
				$emp_id = $result->emp_id;
				$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $result->emp_id)
						->where('m.br_join_date', '=', function($query) use ($emp_id,$today)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $today);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('emp_id')
						->first();	
					
					
					
					
					
				//print_r ($max_sarok);
				
				
				/*$data_result = DB::table('tbl_master_tra as m')
					->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
					->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
					->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
					->where('m.sarok_no', '=', $max_sarok->sarok_no)
					->select('e.emp_name_eng','e.org_join_date','e.permanent_add','m.br_join_date','m.br_code','d.designation_name','b.branch_name')
					->first();
					*/
					
					
				$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->leftJoin('tbl_area as ar', 'ar.area_code', '=', 'b.area_code')
						->leftJoin('tbl_zone as zn', 'zn.zone_code', '=', 'ar.zone_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->where('m.emp_id', '=', $max_sarok->emp_id)
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->select('e.emp_name_eng','e.org_join_date','d.designation_bangla','b.br_name_bangla','e.emp_name_ban','m.emp_id','m.grade_code','m.grade_step','m.designation_code','m.basic_salary','m.total_pay','m.net_pay','m.letter_date','m.br_join_date','m.br_code','m.effect_date','m.grade_effect_date','g.grade_name','d.designation_name','b.branch_name','m.report_to','m.department_code','m.salary_br_code','ar.area_name_bn','zn.zone_name_bn')
						->first();	
						
				/*$get_marked = DB::table('tbl_mark_assign')
					->where('emp_id', '=', $data_result->emp_id)
					//->where('open_date', '<=', $increment_date)
					->where('open_date', '<=', '2020-06-30')
					->where('status', 0)
					->select('marked_for')
					->get();
				$increment_mark ='';
				$promotion_mark ='';
				$permanent_mark ='';
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
				}	*/
				
				
				$get_marked = DB::table('tbl_mark_assign')
							->where('emp_id', '=', $result->emp_id)
							->where('open_date', '<=', '2021-07-31')
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
					
					$promotion_mark = '';
					$permanent_mark = '';
				//print_r ($data_result);

				$assign_branch = DB::table('tbl_emp_assign as ea')
											->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code')
											->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
											->where('ea.emp_id', $result->emp_id)
											->where('ea.open_date', '<=', $form_date)
											->where('ea.status', '!=', 0)
											->where('ea.select_type', '=', 2)
											->select('ea.emp_id','ea.open_date','ea.br_code','br.branch_name','br.br_name_bangla','ar.area_name')
											->first();
				if(!empty($assign_branch)){
					$result_br_code 	= $assign_branch->br_code;
					$asign_branch_name 	= $assign_branch->branch_name;
					$branch_name_bn 	= $assign_branch->br_name_bangla;
					$asign_area_name 	= $assign_branch->area_name;
					$asign_open_date 	= date('d M Y',strtotime($assign_branch->open_date));
				}
				else
				{
					$result_br_code 	= $data_result->br_code;
					$asign_branch_name 	= $data_result->branch_name;
					$branch_name_bn 	= $data_result->br_name_bangla;
					$asign_area_name 	=  '';
					$asign_open_date 	=  '';
				}
				
				
				
				
				$assign_designation = DB::table('tbl_emp_assign as ea')
											->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
											->where('ea.emp_id', $result->emp_id)
											->where('ea.open_date', '<=', $form_date)
											->where('ea.status', '!=', 0)
											->where('ea.select_type', '=', 5)
											->select('ea.emp_id','ea.open_date','de.designation_name','de.designation_bangla','de.designation_code')
											->first();
				if(!empty($assign_designation))
				{
					$designation_name	 	= $assign_designation->designation_name;
					$designation_bangla 	= $assign_designation->designation_bangla;
					$designation_code 		= $assign_designation->designation_code;
				}
				else 
				{
					$designation_name	 	= $data_result->designation_name;
					$designation_bangla 	= $data_result->designation_bangla;
					$designation_code 		= $data_result->designation_code;
				}
				
				
				
				if($data_result->emp_name_ban){
					$emp_name = $data_result->emp_name_ban;
				}
				else
				{
					$emp_name = $data_result->emp_name_eng;
				}
				
				
				
				
				////////				
				if ($result_br_code == $data['br_code']) {	
					$data['all_result'][] = array(
					
						'emp_id' 					=> $data_result->emp_id,
						'emp_name_eng'      		=> $data_result->emp_name_eng,
						'next_designation_code'     => $designation_code,
						'br_code'      				=> $result_br_code,
						'grade_code'     			=> $data_result->grade_code,
						'grade_name'      			=> $data_result->grade_name,
						'grade_step'      			=> $data_result->grade_step,
						'br_join_date'      		=> $data_result->br_join_date,
						'letter_date'      			=> $data_result->letter_date,
						'effect_date'      			=> $data_result->effect_date,
						'grade_effect_date'      	=> $data_result->grade_effect_date,
						'designation_name'      	=> $designation_name,
						'branch_name'      			=> $asign_branch_name,
						'increment_marked'    		=> $increment_mark,
						'promotion_increment_mark'  => $promotion_mark,
						'report_to'    				=> $data_result->report_to,
						'department_code'    		=> $data_result->department_code,
						'salary_br_code'    		=> $data_result->salary_br_code,
						'designation_bangla'    	=> $designation_bangla,
						'br_name_bangla'    		=> $branch_name_bn,
						
						'emp_name_ban'    			=> $emp_name,
						
						'zone_name_bn'    			=> $data_result->zone_name_bn,
						'area_name_bn'    			=> $data_result->area_name_bn,
						'no_increment'    			=> 1
						
					);
				}				
			}				
			
		}
		
		return view('admin.auto_increment.generate_auto_increment',$data);
	}
	
	public function NextIncrementGenerate(Request $request)
	{
		$data = array();
		$branch_code 		= $request->input('branch_code');
		$effect_date 		= $request->input('effect_date');
		$grade_code 		= $request->input('grade_code');
		$grade_step 		= $request->input('grade_step');
		$br_code 			= $request->input('br_code');
		$designation_name 	= $request->input('designation_name');
		
		$designation_bangla = $request->input('designation_bangla');
		$br_name_bangla 	= $request->input('br_name_bangla');
		$emp_name_ban 		= $request->input('emp_name_ban');
		
		$designation_code 	= $request->input('designation_code');
		//$report_to 			= $request->input('report_to');
		$department_code 	= $request->input('department_code');
		$salary_br_code 	= $request->input('salary_br_code');
		$br_join_date 		= $request->input('br_join_date');
		$grade_effect_date 	= $request->input('grade_effect_date');
		$flags 				= $request->input('flag');
		$emp_ids 			= $request->input('emp_id');
		$no_increment 		= $request->input('no_increment');
		
		$area_name_bn 		= $request->input('area_name_bn');
		$zone_name_bn 		= $request->input('zone_name_bn');
		
		
		
		
		//print_r($emp_ids);
		//exit;
		
		
		
		
		$i = 0;
		
		$plus_item_id 					= array();
		$plus_item_amount 				= array();	  
		$plus_item_amount_bn 			= array();	  
		$secondary_plus_item_amount 	= array();	 
		
		$minus_item_id 		= array();
		$minus_item_amount 	= array();	
		
		
		$pdf = '';
		$image_full_name = '';
		$data['document_name'] = '';
		
		
		foreach($emp_ids as $cnt => $emp_id) {
			
			//$data['emp'][]	 =	$emp_id;

			if (in_array($emp_id, $flags)) 
			{

				$sarok_id = DB::table('tbl_sarok_no')->max('sarok_no');
				$data['sarok_no'] 		   	= $sarok_id+1;
			
				$data['effect_date'] 		= $effect_date;
				$data['letter_date'] 		= $effect_date;
				$data['emp_id'] 			= $emp_id;
				$data['grade_code'] 		= $grade_code[$cnt];
				$data['grade_step'] 		= $grade_step[$cnt];
				$data['br_code'] 			= $br_code[$cnt];
				$data['designation_name'] 	= $designation_name[$cnt];
				$data['designation_code'] 	= $designation_code[$cnt]; 
				$data['department_code'] 	= $department_code[$cnt];
				$data['salary_br_code'] 	= $salary_br_code[$cnt];
				$data['br_join_date'] 		= $br_join_date[$cnt];
				$data['grade_effect_date'] 	= $grade_effect_date[$cnt];
				//$data['report_to'] 			= $report_to[$cnt];
				$data['designation_bangla'] = $designation_bangla[$cnt];
				$data['br_name_bangla'] 	= $br_name_bangla[$cnt];
				$data['emp_name_ban'] 		= $emp_name_ban[$cnt];
				$data['no_increment'] 		= $no_increment[$cnt];
				
				$data['area_name_bn'] 		= $area_name_bn[$cnt];
				$data['zone_name_bn'] 		= $zone_name_bn[$cnt];
				 
				$step = $data['grade_step'] - 1; 
				
				if($data['grade_code'] == 21)
				{
					$data['grade_name_ban'] 	= 'নন গ্রেড-১';  
				}
				elseif($data['grade_code'] == 22)
				{
					$data['grade_name_ban'] 	= 'নন গ্রেড-২';  
				}
				else
				{
					$data['grade_name_ban'] 	= $this->NumberToBanglaNumber($data['grade_code']);  
				}
				
				if($step >9){
				$data['grade_step_ban'] 	= $this->NumberToBanglaNumber($step);   
				}else{
				$data['grade_step_ban'] 	= '০'.$this->NumberToBanglaNumber($step); 	
				}
				$i++; 
				
				
				
				if($data['no_increment'] == 2)
				{
					$data['incre_bn']  = '০২ (দুই)'; 
				}
				elseif($data['no_increment'] == 3)
				{
					$data['incre_bn']  = '০৩(তিন)'; 
				}
				else
				{
					$data['incre_bn']  = '০১ (এক)';
				}
				
				
				
				
				// Basic Salary
				$aaa = $data['grade_step'] - 1;
				$bbb = $aaa+$data['no_increment'];
				$grade_steps = 'step_'.$bbb;
				$basic_info = DB::table('tbl_grade_new')
									->where('grade_code', $data['grade_code'])
									->select($grade_steps,'grade_id')
									->first();
									
									
				$salary_basic = $basic_info->$grade_steps;
				$data['salary_basic'] = $salary_basic;
				//

				
				if($data['br_code'] == 9999)
				{
					$ho_bo = 0;
				}
				elseif($data['br_code'] == 9997)
				{
					$ho_bo = 3;
				}
				elseif($data['br_code'] > 0)
				{
					$ho_bo = 1;
				}
				else
				{
					$ho_bo = 2;
				}			
				//
				if($designation_name === 'Officer (Audit)' && $data['br_code'] == 9999)
				{
					$ho_bo = 0;
				}
				elseif($designation_name === 'Officer (Audit)' && $data['br_code'] != 9999)
				{
					$ho_bo = 1;
				}
				
				$data['ho_bo'] = $ho_bo;
				

				/*$plus_items 	= DB::table('tbl_salary_plus as plus')
					->join('tbl_plus_items as item', 'item.item_id', '=', 'plus.item_name')
					// DESIGNATION
					->where([
					['plus.active_from', 	'<=', $effect_date],
					['plus.active_upto', 	'>=', $effect_date],
					['plus.status', 		'=', 1],
					['plus.ho_bo', 			'=', $ho_bo],
					['plus.designation_for','=', $data['designation_code']],
					])
					// GRADE
					->orwhere([
					['plus.active_from', 	'<=', $effect_date],
					['plus.active_upto', 	'>=', $effect_date],
					['plus.status', 		'=', 1],
					['plus.ho_bo', 			'=', $ho_bo],
					['plus.designation_for','=', 0],
					['plus.emp_grade', 		'=', $data['grade_code']]
					])
					
					// HO/ BO
					->orwhere([
					['plus.active_from', 	'<=', $effect_date],
					['plus.active_upto', 	'>=', $effect_date],
					['plus.status', 		'=', 1],
					['plus.ho_bo', 			'=', $ho_bo],
					['plus.epmloyee_status','=', 2],
					])
					->get();
				*/						
										
				$plus_items 	= DB::table('tbl_salary_plus as plus')
									->join('tbl_plus_items as item', 'item.item_id', '=', 'plus.item_name')
									// DESIGNATION
									->where([
									['plus.active_from', 	'<=', $effect_date],
									['plus.active_upto', 	'>=', $effect_date],
									['plus.status', 		'=', 1],
									['plus.ho_bo', 			'=', $ho_bo],
									//['plus.epmloyee_status','=', $is_permanent],
									['plus.designation_for','=', $data['designation_code']],
									])
									// GRADE
									->orwhere([
									['plus.active_from', 	'<=', $effect_date],
									['plus.active_upto', 	'>=', $effect_date],
									['plus.status', 		'=', 1],
									['plus.ho_bo', 			'=', $ho_bo],
									//['plus.epmloyee_status','=', $is_permanent],
									['plus.designation_for','=', 0],
									['plus.emp_grade', 		'=', $data['grade_code']]
									])
									// HO/ BO
									->orwhere([
									['plus.active_from', 	'<=', $effect_date],
									['plus.active_upto', 	'>=', $effect_date],
									['plus.status', 		'=', 1],
									['plus.ho_bo', 			'=', $ho_bo],
									['plus.epmloyee_status','=', 2],
									])
									->OrderBy('item.ordering','asc')
									->get();							
									
												
				//print_r($plus_items);
				//exit;
													
				$minus_items 	= DB::table('tbl_salary_minus as minus')
										->join('tbl_minus_items as item', 'item.item_id', '=', 'minus.item_name')
										->where([
										['minus.active_from', 	'<=', $effect_date],
										['minus.active_upto', 	'>=', $effect_date],
										['minus.status', 		'=', 1],
										['minus.ho_bo', 			'=', $ho_bo]
										])
										->OrderBy('item.ordering','asc')
										->get();
	
				$data['plus_items'] = $plus_items;			
				$data['minus_items'] = $minus_items;			
					
				$plus_item_id 					= array();
				$plus_item_amount 				= array();		
				$plus_item_amount_bn 			= array();		
				$secondary_plus_item_amount 	= array();	
				$secondary_plus_item_amount_en 	= array();			

				foreach($plus_items as $plus_item)
				{
					$percentage 	= $plus_item->percentage;
					$fixed_amount 	= $plus_item->fixed_amount;
					
					if($plus_item->type == 2)
					{
						$plus_amount 	= $plus_item->fixed_amount;
					}
					else
					{
						$plus_amount = round(($salary_basic*$plus_item->percentage)/100);
					}
					
					if($plus_item->item_type == 0)
					{
						$plus_amount_bn = $this->NumberToBanglaNumber($plus_amount);
						$plus_item_amount_bn[] 	= $plus_amount_bn;
					}
					

					$plus_item_id[] 		= $plus_item->id;
					$plus_item_amount[] 	= $plus_amount;
					
					
					if($plus_item->item_type == 1)
					{
						$secondary_plus_items_amount 	= $plus_amount;
						$secondary_plus_item_amount[] 	= $this->NumberToBanglaNumber($secondary_plus_items_amount);
						$secondary_plus_item_amount_en[]= $secondary_plus_items_amount;
					}  
				}	

				$data['plus_item_id'] 			= $plus_item_id;
				$data['plus_item_amount'] 		= $plus_item_amount;
				$data['plus_item_amount_bn'] 	= $plus_item_amount_bn;
				$data['secondary_plus_amount'] 	= $secondary_plus_item_amount;
				$data['secondary_plus_amount_en']= $secondary_plus_item_amount_en;
				
				
				
				$minus_item_id 			= array();
				$minus_item_amount 		= array();		
				$minus_item_amount_bn 	= array();		

				foreach($minus_items as $minus_item)
				{
					$percentage 	= $minus_item->percentage;
					$fixed_amount 	= $minus_item->fixed_amount;
					
					if($minus_item->type == 2)
					{
						$minus_amount 	= $minus_item->fixed_amount;
					}
					else
					{
						$minus_amount = round(($salary_basic*$minus_item->percentage)/100);
					}
					
					
					$minus_amount_bn = $this->NumberToBanglaNumber($minus_amount);
					

					$minus_item_id[] 		= $minus_item->id;
					$minus_item_amount[] 	= $minus_amount;
					$minus_item_amount_bn[] = $minus_amount_bn;
				}
				
				$data['minus_item_id'] 			= $minus_item_id;
				$data['minus_item_amount'] 		= $minus_item_amount;
				$data['minus_item_amount_bn']	= $minus_item_amount_bn;
				
				
				// Dynamic Reported to 				
				
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
				}
				
				
			
				
				// ENd Dynamic Reported to 

				
				// SALARY 
		
				$salary['effect_date']		= $data['effect_date'];
				$salary['transection']		= 3;
				$salary['sarok_no']			= $data['sarok_no'];
				$salary['letter_date']		= $data['effect_date'];
				$salary['emp_id']			= $data['emp_id']; 
				$salary['br_code']			= $data['br_code'];
				$salary['plus_item_id'] 	= implode(",", $data['plus_item_id']);   
				$salary['plus_item'] 		= implode(",", $data['plus_item_amount']);	
				$salary['minus_item_id'] 	= implode(",", $data['minus_item_id']);   
				$salary['minus_item'] 		= implode(",", $data['minus_item_amount']);
				$salary['salary_basic']		= $data['salary_basic'];
				$salary['total_plus']		= array_sum($data['plus_item_amount']);
				$salary['total_minus']		= array_sum($data['minus_item_amount']);
				$salary['others_total_plus']= array_sum($data['secondary_plus_amount']);
				$secondary_plus_amount_en	= array_sum($data['secondary_plus_amount_en']);
				$salary['payable']			= $salary['salary_basic'] + $salary['total_plus'] - $secondary_plus_amount_en;
				$net_payable				= $salary['payable'] - $salary['total_minus'];
				//$salary['net_payable']	= $net_payable - $salary['others_total_plus'] - $secondary_plus_amount_en ;
				$salary['net_payable']		= $net_payable - $salary['others_total_plus'] ;
				$salary['gross_total']		= $salary['net_payable'] + $salary['others_total_plus'];
				$salary['created_by']		= Session::get('admin_id');
				//$salary['extra_mobile_allowance'] = 0;
				//$salary['extra_fuel_allowance'] 	= 0;
				//$salary['data_type'] 				= 0;

				
				
				//SET SAROK TABLE//
				$sarok_data['sarok_no']    			= $data['sarok_no'];
				$sarok_data['emp_id'] 	   			= $data['emp_id'];
				$sarok_data['letter_date'] 			= $data['effect_date'];
				$sarok_data['transection_type'] 	= 3;
				$sarok_data['created_by']  			= Session::get('admin_id'); 
				$sarok_data['org_code']  			= 181;
				
				// Increment 
				$increment['sarok_no'] 				= $data['sarok_no'];
				$increment['letter_date'] 			= $data['effect_date'];
				$increment['emp_id'] 				= $data['emp_id'];
				$increment['designation_code'] 		= $data['designation_code'];
				$increment['department_code'] 		= $data['department_code'];
				$increment['br_code'] 				= $data['br_code'];
				$increment['grade_code'] 			= $data['grade_code'];
				$increment['grade_step'] 			= $data['grade_step'];
				$increment['next_increment_date'] 	= date('Y-m-d',strtotime($data['effect_date'] . "+1 year"));			   
				$increment['report_to'] 			= $report_to; 
				$increment['effect_date'] 			= $data['effect_date'];
				$increment['tran_type_no'] 			= 3;
				$increment['is_auto_generated'] 	= 1;
				$increment['increment_type'] 		= 'Increment';
				$increment['grade_effect_date'] 	= $data['grade_effect_date'];
				$increment['br_joined_date']  		= $data['br_join_date'];
				$increment['org_code']  			= 181;
				$increment['status']  				= 1;
				$increment['created_by']  			= Session::get('admin_id'); 
				
				
				// MASTER
				$master['sarok_no'] 				= $data['sarok_no'];
				$master['letter_date'] 				= $data['effect_date'];
				$master['effect_date'] 				= $data['effect_date'];
				$master['emp_id'] 					= $data['emp_id'];
				$master['designation_code'] 		= $data['designation_code'];
				$master['department_code'] 			= $data['department_code'];
				$master['br_code'] 					= $data['br_code'];
				$master['salary_br_code'] 			= $data['salary_br_code'];
				$master['br_join_date'] 			= $data['br_join_date']; 
				$master['grade_code'] 				= $data['grade_code'];
				$master['grade_step'] 				= $data['grade_step'];
				$master['basic_salary'] 			= $data['salary_basic'];
				$master['is_permanent'] 			= 2;
				$master['grade_effect_date'] 		= $data['grade_effect_date'];
				
				$master['tran_type_no'] 			= 3;
				$master['status'] 					= 1;
				$master['next_increment_date'] 		= date('Y-m-d',strtotime($data['effect_date'] . "+1 year"));
				
				$master['report_to'] 					= $report_to;
				$master['report_to_designation_code']	= $report_to_designation_code;
				$master['report_to_new'] 				= $report_to_new;
				$master['report_to_emp_type'] 			= $report_to_emp_type;
				$master['is_auto_increment'] 			= 1;
				$master['increment_review'] 			= 'Increment';
			
				$data['emp_type'] 				= 1;
				$data['category_id'] 			= 23;
				$data['subcat_id'] 				= 24; 
				$data['status'] 				= 1;
				$data['id_bangla'] 				= $this->getEnglishToBangla($data['emp_id']);
				$data['letter_date_bangla'] 	= $this->getBanglaDate($data['letter_date']);
				$data['year_bangla'] 			= $this->getBanglaDate(date('Y'));
				$data['basic_bangla'] 			= $this->NumberToBanglaNumber($salary_basic);
				$data['net_payable_bangla'] 	= $this->NumberToBanglaNumber($salary['net_payable']);
				$data['total_minus_bangla'] 	= $this->NumberToBanglaNumber($salary['total_minus']);
				$data['payable_bangla'] 		= $this->NumberToBanglaNumber($salary['payable']);

				$pdf = PDF::loadView('admin.document.emp_increment_view_pdf',$data,[],['format' => 'A4']);
				$image_full_name = $data['emp_id'].'_'.$data['category_id'].'_'.$data['subcat_id'].'_'.$data['effect_date'].".pdf";
				
				$pdf->save("attachments/attach_ment_tran/auto_increment/2021/".$image_full_name); 
				
				//$pdf->save("attachments/attach_ment_tran/".$image_full_name); 
				//$file_name = $data['emp_id'].'_'.$data['effect_date'].".pdf";
				//$pdf->save("attachments/attach_ment_tran/".$data['br_code'].'/'.$file_name);  

				$data['document_name'] = $image_full_name;
				
				$edms['subcat_id']			= $data['subcat_id'] ;
				$edms['category_id']		= $data['category_id'] ;
				$edms['emp_id']				= $data['emp_id'] ;
				$edms['emp_type']			= $data['emp_type'] ;
				$edms['document_name']		= $data['document_name'] ;
				$edms['effect_date']		= $data['effect_date'] ;
				$edms['user_id']			= Session::get('admin_id'); 
				$edms['status']				= 1 ;
				$edms['is_auto_increment']	= 1 ;

				DB::beginTransaction();
				try {				
					DB::table('tbl_increment')->insert($increment);
					DB::table('tbl_sarok_no')->insert($sarok_data);
					DB::table('tbl_master_tra')->insert($master);
					DB::table('tbl_emp_salary')->insert($salary);
					DB::table('tbl_edms_document')->insert($edms);

					DB::commit();
					Session::put('message','Data Saved Successfully');
				} catch (\Exception $e) {
					Session::put('message','Error: Unable to Save Data');
					DB::rollback();
				}
				
	
				$pdf = '';
				$image_full_name = '';
				$data['document_name'] = '';
				
				$data['increment'][] = $emp_id;
			}
			else
			{
				$data['no_increment'] = $emp_id;
			}
		}
		//DB::table('tbl_branch')->where('br_code', $branch_code)->update(['auto_increment_status' => 1]);
		return redirect('next-incre-auto');
	}
	
	
	public function remove_increment($emp_id)
	{
		
	//$emp_id = 2333;
		
		$max_sarok = DB::table('tbl_master_tra as m')
							->where('m.emp_id', $emp_id)
							->where('m.tran_type_no', 3)
							->max('m.sarok_no');

		 $sarok_no = $max_sarok;
		//exit;
		
		if($sarok_no)
		{
			DB::beginTransaction();
				try {				
					DB::table('tbl_master_tra')
						->where('sarok_no',$sarok_no)
						->where('emp_id',$emp_id)
						->delete();
						
						DB::table('tbl_emp_salary')
						->where('sarok_no',$sarok_no)
						->where('emp_id',$emp_id)
						->delete();
						
						DB::table('tbl_sarok_no')
						->where('sarok_no',$sarok_no)
						->where('emp_id',$emp_id)
						->delete();
						
						DB::table('tbl_increment')
						->where('sarok_no',$sarok_no)
						->where('emp_id',$emp_id)
						->delete();	

						DB::table('tbl_edms_document')
							->where('is_auto_increment',1)
							->where('emp_id',$emp_id)
							->delete();	

					DB::commit();
					//Session::put('message','Data Saved Successfully');
				} catch (\Exception $e) {
					//Session::put('message','Error: Unable to Save Data');
					DB::rollback();
				}
		}

		echo '<h1>Deleted</h1>';
		exit;
	}
	
	
	
	

	
	public function NumberToBanglaNumber($num) {
		$numbers = str_split($num);
		$final='';
		$length= count($numbers);
		$comma="";
		foreach ($numbers as $number) {
			if ($number == 1) {
				$number = '১';
			} else if ($number == 2) {
				$number = '২';
			} else if ($number == 3) {
				$number = '৩';
			} else if ($number == 4) {
				$number = '৪';
			} else if ($number == 5) {
				$number = '৫';
			} else if ($number == 6) {
				$number = '৬';
			} else if ($number == 7) {
				$number = '৭';
			} else if ($number == 8) {
				$number = '৮';
			} else if ($number == 9) {
				$number = '৯';
			} else if ($number == 0) {
				$number = '০';
			}

			if($length==4) {
				if ($comma == 1) {
					$number = "," . $number;
				}
			}else if($length==5){

				if ($comma == 2) {
					$number = "," . $number;
				}
			}else if($length==6){

				if ($comma == 1) {
					$number = "," . $number;
				}
				if ($comma == 3) {
					$number = "," . $number;
				}
			}else if($length==7){

				if ($comma == 2) {
					$number = "," . $number;
				}
				if ($comma == 4) {
					$number = "," . $number;
				}
			}else if($length==8){

				if ($comma == 1) {
					$number = "," . $number;
				}
				if ($comma == 3) {
					$number = "," . $number;
				}
				if ($comma == 5) {
					$number = "," . $number;
				}
			}

			$final.=$number;

			$comma++;
		}
		return $final;
		exit;
	}

	public function getBanglaDate($date){
		$engArray = array(1,2,3,4,5,6,7,8,9,0);
		$bangArray = array('১','২','৩','৪','৫','৬','৭','৮','৯','০');
		$convert = str_replace($engArray, $bangArray, $date);
		return $convert;
	}
	
	public function getEnglishToBangla($data){
		$english = array(1,2,3,4,5,6,7,8,9,0,'-','%','B');
		$bangla = array('১','২','৩','৪','৫','৬','৭','৮','৯','০','-','%','বি');
		$converted = str_replace($english, $bangla, $data);
		return $converted;
	}
	
	
	public function edms_file() 
    {	
		$data = array();  
        $data['emp_id'] 				= 2999;
        $data['emp_type'] 				= 1;
        $data['category_id'] 			= 23;
        $data['subcat_id'] 				= 24; 
        $data['effect_date'] 			= '2019-07-01';
        $effect_date 					= '2019-07-01';
        $data['status'] 				= 1;
        $data['user_id'] 				= Session::get('admin_id'); 
		
		$ho_bo = 1;
		$data['ho_bo'] = 1;
		$designation_code = 205;
		$grade_code = 13;
		
				$data['plus_items'] 	= DB::table('tbl_salary_plus as plus')
										->join('tbl_plus_items as item', 'item.item_id', '=', 'plus.item_name')
										// DESIGNATION
										->where([
										['plus.active_from', 	'<=', $effect_date],
										['plus.active_upto', 	'>=', $effect_date],
										['plus.status', 		'=', 1],
										['plus.ho_bo', 			'=', $ho_bo],
										['plus.designation_for','=', $designation_code],
										])
										// GRADE
										->orwhere([
										['plus.active_from', 	'<=', $effect_date],
										['plus.active_upto', 	'>=', $effect_date],
										['plus.status', 		'=', 1],
										['plus.ho_bo', 			'=', $ho_bo],
										['plus.designation_for','=', 0],
										['plus.emp_grade', 		'=', $grade_code]
										])
										
										// HO/ BO
										->orwhere([
										['plus.active_from', 	'<=', $effect_date],
										['plus.active_upto', 	'>=', $effect_date],
										['plus.status', 		'=', 1],
										['plus.ho_bo', 			'=', $ho_bo],
										['plus.epmloyee_status','=', 2],
										])
										->get();
																			
													
				$data['minus_items'] 	= DB::table('tbl_salary_minus as minus')
										->join('tbl_minus_items as item', 'item.item_id', '=', 'minus.item_name')
										->where([
										['minus.active_from', 	'<=', $effect_date],
										['minus.active_upto', 	'>=', $effect_date],
										['minus.status', 		'=', 1],
										['minus.ho_bo', 			'=', $ho_bo]
										])
										->get();
		
		return view('admin.document.emp_increment_view_pdf',$data);
    
    }
	
	
	public function increment_statement()
	{
		

		
		
		
		
		$infos = DB::table('tbl_increment as inc')
				->leftJoin('tbl_master_tra as m', 'm.sarok_no', '=', 'inc.sarok_no')
				->leftJoin('tbl_branch as br', 'br.br_code', '=', 'm.br_code')
				->leftJoin('tbl_designation as d', 'd.designation_code', '=', 'm.designation_code')
				->where('inc.tran_type_no', '=', 3)
				->where('inc.is_auto_generated', '=', 1)
				->where('inc.next_increment_date', '=', '2021-07-01')
				->select('inc.sarok_no','m.emp_id','m.br_code','m.designation_code','m.grade_code','m.grade_step','m.basic_salary','br.branch_name','d.designation_name')
				->orderBy('inc.br_code', 'asc')
				->get();
				
				
				foreach($infos as $info) { 
				$emp_id = $info->emp_id;
				$update['post_br'] = $info->branch_name;
				$update['post_grade'] = $info->grade_code;
				$update['post_step'] = $info->grade_step;
				$update['post_basic'] = $info->basic_salary;
				$update['post_dsg'] = $info->designation_name;
						
				$status = DB::table('check_increment')
							->where('emp_id', $emp_id)
							->update($update);		
				
				}
				
				
				$results = DB::table('check_increment')
						->get();
				
			$data['infos'] = $results;
					
			return view('admin.auto_increment.check',$data);		
			exit;
				
				
				
				
				
				
		//$data['infos'] = $infos;
		//return view('admin.auto_increment.generated_increment',$data);	
			
	}
	
	public function set_extra_mobile()
	{
		$emp_allawance = array('4'=>450,'7'=>0,'10'=>600,'13'=>600,'16'=>300,'23'=>0,'31'=>300,'34'=>0,'47'=>300,'49'=>300,'57'=>300,'101'=>300,'120'=>300,'126'=>0,'138'=>450,'152'=>0,'146'=>600,'162'=>300,'165'=>600,'188'=>300,'189'=>300,'208'=>450,'324'=>750,'325'=>500,'371'=>300,'721'=>0,'725'=>300,'734'=>300,'785'=>0,'792'=>300,'958'=>300,'1034'=>300,'1131'=>0,'4'=>450,'1222'=>300,'1328'=>300,'1393'=>300,'1431'=>300,'1433'=>300,'1433'=>300,'1441'=>300,'1443'=>300,'1746'=>500,'1822'=>300,'2017'=>0,'2029'=>300,'2031'=>0,'2083'=>0,'2155'=>0,'2290'=>500,'2321'=>0,'2360'=>300,'3305'=>300,'3396'=>500,'3747'=>450,'3794'=>300,'3824'=>300,'4102'=>0,'4104'=>0,'4105'=>0,'4228'=>-250,'4229'=>-250,'4230'=>-250,'4231'=>-250);
		
		
		//echo count($emp_allawance);
		//exit;
		//echo '<pre>';
		//print_r($emp_allawance);
		
		
		foreach ($emp_allawance as $key => $value) {
			
			//echo $key.'/'.$value.'<br>';
			
			/*DB::table('tbl_emp_salary')
			->where('emp_id', $key)
			->where('emp_id', $key)
			->update(['extra_mobile_allowance' => $value]);
			*/
		}
		
		echo 'Updated';
		

		
		
	}
	
	
	public function increment_basic_report()
	{
		/*$inre_infos  = DB::table('tbl_master_tra as m')  
					->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
					->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
					->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')  
					->where('m.salary_br_code', '=', 9999)
					->where('m.is_auto_increment', '=', 1)
					->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','d.designation_group_code','b.branch_name','b.br_code','emp.org_join_date as joining_date','emp.emp_type as type_name','m.grade_code','m.grade_step')
					->get(); 
		$p_info =array();			
		foreach($inre_infos as $inre_info)
		{
			$emp_id = $inre_info->emp_id;
			$promotion_infos  = DB::table('tbl_master_tra as m')  
					->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
					->where('m.emp_id', '=', $emp_id)
					->where('m.is_auto_increment', '=', 4)
					->select('m.emp_id','d.designation_name','m.basic_salary','m.grade_code','m.grade_step')
					->first(); 
			
			if($promotion_infos)
			{
				$p_info[] = $promotion_infos->emp_id;
			}
			
		}
		
		$promotion_infos  = DB::table('tbl_master_tra as m')  
					->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
					->where('m.is_auto_increment', '=', 4)
					->select('m.emp_id','d.designation_name','m.basic_salary','m.grade_code','m.grade_step')
					->get(); 	
*/					

	}
	
	
	
	

}
