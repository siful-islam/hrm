<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class AutopromotionController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	

	
	public function Index()
    {
		/*
		$emp_id 		= 2397;
		$present_grade 	= 12;
        $present_step 	= 5;
        $present_basic 	= 22980;
		$next_grade  	= ($present_grade - 1);	
		$next_infos 	= DB::table('tbl_grade_new')
							->where('grade_code', '=', $next_grade)
							->select('step_1','step_2','step_3','step_4','step_5','step_6','step_7','step_8','step_9','step_10','step_11','step_12','step_13','step_14','step_15','step_16','step_17','step_18','step_19','step_20' )
							->first();	
		$i = 1;					
		foreach($next_infos as $next_info)
		{
			$steps = 'step_'.$i;
			$next_info;
			if($next_info >$present_basic)
			{
				$next_basic[] = $next_info;
				$next_step[]  = $steps;
			}
			$i++;
		}
		
		echo $next_grade;
		echo '<br>';
		echo $next_basic[1];
		echo '<br>';
		echo $next_step[0];
		exit;
		*/
		
		
		
		$data = array();
		$data['Heading'] 		= $data['title'] = 'Next Promotion Report'; 
		$data['form_date']		= date('Y-m-d');
		$data['grade_code']		= '';
		$data['order_by']		= '';
		$data['all_grade'] 		= DB::table('tbl_grade_new')->where('status',1)->where('is_promotionable',1)->get();	
		//return view('admin.pages.service_length_reports.grade_service_length',$data);
		return view('admin.auto_increment.generate_auto_promotion',$data);
    }


	public function Report(Request $request)
    {
        $data = array();
		$data['Heading'] 		= $data['title'] = 'Basic Analysis';
		$data['form_date'] 		= $form_date = $request->input('form_date');
		$data['grade_code'] 	= $grade_code = $request->input('grade_code');
		$data['order_by'] 		= $request->input('order_by');
		$data['all_grade'] 		= DB::table('tbl_grade_new')->where('status',1)->where('is_promotionable',1)->get();	
		$all_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
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
				
				//Max Edu Level
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
					$exam_name = $exam_result->exam_name;
				}
				else
				{
					$exam_name = '';
				}
				// END Max Edu Level
				
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
				
				$date_from  = "2017-01-01";
				$date_to    = "2020-12-31";
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
								'm.emp_id','m.grade_code','m.basic_salary','m.grade_effect_date','m.is_permanent','m.tran_type_no','m.br_code','g.grade_name','d.designation_name','b.branch_name','ea.open_date','ea.incharge_as','m.grade_step')
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
				
					
					

				


					if ($data_result->grade_code == $grade_code) {
					///////////////
					$api_url 		= 'http://202.4.106.3/spms/spms_marks/'.$data_result->emp_id;
					$hrm_data		= file_get_contents($api_url);
					$total_result 	= json_decode($hrm_data);
					//print_r ($total_result);					
					if(empty($total_result->total_marks)) {
						$ka_marks = '-';
						$kha_marks = '-';
						$ga_marks = '-';
						$gha_marks = '-';
						$umo_marks = '-';
						$total_marks = '-';
						$first_comments = '-';
						$second_comments = '-';
					} else {
						$ka_marks = $total_result->ka_marks;
						$kha_marks = $total_result->kha_marks;
						$ga_marks = $total_result->ga_marks;
						$gha_marks = $total_result->gha_marks;
						$umo_marks = $total_result->umo_marks;
						$total_marks = $total_result->total_marks;
						$first_comments = $total_result->first_comments;
						$second_comments = $total_result->second_comments;
					}
					////////////////
					$present_grade 	= $data_result->grade_code;
					$present_step 	= $data_result->grade_step;
					$next_grade  	= ($present_grade - 1);	
					$next_infos 	= DB::table('tbl_grade_new')
										->where('grade_code', '=', $next_grade)
										->select('step_1','step_2','step_3','step_4','step_5','step_6','step_7','step_8','step_9','step_10','step_11','step_12','step_13','step_14','step_15','step_16','step_17','step_18','step_19','step_20' )
										->first();	
					
						$x 					= 0;					
						$next_basic_salary 	= 0;
						$next_steps 		= '';
						$next_basic 		= array();
						$next_step 			= array();
						foreach($next_infos as $next_info)
						{
							$steps = 'Step - '.$x;
							$next_info;
							if($next_info >$bs_salary)
							{
								$next_basic[] = $next_info;
								$next_step[]  = $steps;
							}
							$x++;
						}

						$next_basic_salary 	= $next_basic[0];
						$next_steps 		= $next_step[0];
						
						$grade_step = $data_result->grade_step - 1;
						
						$data['all_result'][] = array(
							'emp_id' 				=> $data_result->emp_id,
							'emp_name_eng'      	=> $data_result->emp_name_eng,
							'exam_name'      		=> $exam_name,
							'org_join_date'      	=> date('d M Y',strtotime($data_result->org_join_date)),
							'basic_salary'      	=> $bs_salary,
							'total_salary'      	=> $total_salary,
							'net_salary'      		=> $net_salary,
							'grade_code'      		=> $data_result->grade_code,
							'grade_name'      		=> $data_result->grade_name,
							'grade_effect_date'     => date('d M Y',strtotime($data_result->grade_effect_date)),
							'total'      			=> $data_result->total,
							'is_permanent'      	=> $data_result->is_permanent,
							'designation_name'      => $data_result->designation_name,
							'branch_name'      		=> $data_result->branch_name,
							'tran_type_no'      	=> $data_result->tran_type_no,
							'assign_designation'    => $asign_desig,
							'assign_open_date'      => $desig_open_date,
							'increment_marked'    	=> $increment_mark,
							'promotion_marked'    	=> $promotion_mark,
							'permanent_marked'    	=> $permanent_mark,
							'incharge_as'      		=> $data_result->incharge_as,
							'open_date'      		=> $data_result->open_date,
							'total_warning'      	=> $data_result->total_warning,
							'total_censure'      	=> $data_result->total_censure,
							'total_strong_warning'  => $data_result->total_strong_warning,
							'total_fine'      		=> $data_result->total_fine,
							'total_explanation'     => $data_result->total_explanation,
							'total_fine_amount'     => $data_result->total_fine_amount,
							'next_grade'      		=> $next_grade,
							'next_steps'      		=> $next_steps,
							'next_basic_salary'     => $next_basic_salary,
							'present_step'      	=> $grade_step,
							'ka_marks'      		=> $ka_marks,
							'kha_marks'      		=> $kha_marks,
							'ga_marks'      		=> $ga_marks,
							'gha_marks'      		=> $gha_marks,
							'umo_marks'      		=> $umo_marks,
							'total_marks'      		=> $total_marks,
							'first_comments'      		=> $first_comments,
							'second_comments'      		=> $second_comments
						);
					}
 
			}
		}

		return view('admin.auto_increment.generate_auto_promotion',$data);
    }
	
	

	
}
