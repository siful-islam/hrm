<?php

namespace App\Http\Controllers;
use App\Mail\Notification;
use App\Mail\Force;
use App\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class SelfNotificationController extends Controller
{

	public function __construct() 
	{
		//$this->middleware("CheckUserSession");
	}
	
	public function index()
    {
		$data 			= array();
		$supervisor_id 	= Session::get('emp_id');
		$letter_date 	= date('Y-m-d');
		$category_type 	= 1;
		$form_date 		= date("Y-m-d");
		$status 		= 1;

		if($supervisor_id == 4891)
		{
			$infos = DB::table('supervisor_mapping_ho as mapping')
					->leftJoin('tbl_resignation as r', 'mapping.emp_id', '=', 'r.emp_id')	
					->where('mapping.br_id', 9999) 	
					->where(function($query) use ($status, $form_date) {
						if($status !=2) {
							$query->whereNull('r.emp_id');
							$query->orWhere('r.effect_date', '>', $form_date);
						} else {
							$query->Where('r.effect_date', '<=', $form_date);
						}
					})
					->select('mapping.emp_id','mapping.emp_name') 
					->orderBy('mapping.emp_id', 'asc')
					->get();
		}else{
			$infos = DB::table('supervisor_mapping_ho as mapping')
					->leftJoin('tbl_resignation as r', 'mapping.emp_id', '=', 'r.emp_id')	
					->where('mapping.supervisor_id', $supervisor_id) 
					->where(function($query) use ($status, $form_date) {
						if($status !=2) {
							$query->whereNull('r.emp_id');
							$query->orWhere('r.effect_date', '>', $form_date);
						} else {
							$query->Where('r.effect_date', '<=', $form_date);
						}
					})
					->select('mapping.emp_id','mapping.emp_name') 
					->orderBy('mapping.emp_id', 'asc')
					->get();
		}
		//$staffs =array();
		foreach($infos as $info)
		{
			$emp_id = $info->emp_id;
			$user_type = 1;
			$max_sarok = DB::table('tbl_master_tra as m')
				->where('m.emp_id', '=', $emp_id)
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
			$staffs[] = DB::table('tbl_master_tra as m') 
						->leftJoin('tbl_appointment_info as a', 'm.emp_id', '=', 'a.emp_id')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_resignation as r', 'a.emp_id', '=', 'r.emp_id')
						->leftJoin('tbl_department as dpt', 'm.department_code', '=', 'dpt.department_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->where('m.emp_id', '=', $max_sarok->emp_id)
						->select('a.emp_id','a.emp_name','a.emp_group','e.birth_date','a.joining_date','a.next_permanent_date','m.is_permanent','r.effect_date as re_effect_date','d.designation_name','b.branch_name','g.grade_name','m.department_code','m.designation_code')
						->first();

		}

		$data['staffs'] = $staffs;

		//print_r($data['staffs']);
		return view('admin.my_info.notification', $data);
	}	
	
	
	public function notification()
    {
		$data = array();
		$form_date 				= date('Y-m-d');
		$status 				= 1;
		$emp_group 				= 1;
		$emp_type 				= 1;
		
		$all_result = DB::table('tbl_emp_basic_info as e')
					->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id') 
					//->where('e.emp_group', '=', $emp_group)
					//->where('e.emp_type', '=', $emp_type)
					->where('e.org_join_date', '<=', $form_date)
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
						
		foreach($all_result as $result) {	
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
			if(!empty($max_sarok)) {
			$data_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_appointment_info as ap', 'm.emp_id', '=', 'ap.emp_id')
							->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
							->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
							->where('m.sarok_no', '=', $max_sarok->sarok_no)
							->select('m.basic_salary','m.emp_id','m.br_join_date','m.tran_type_no','m.next_increment_date','d.designation_name','b.branch_name','a.area_name','ap.next_permanent_date','ap.joining_date','m.is_permanent')
							->first();
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
				$asign_branch_name 	= '';
				$asign_area_name 	= '';
				$asign_open_date 	= '';
			}
			$data['staffs'][] = array(
				'emp_id' 				=> $result->emp_id,
				'emp_name'      		=> $result->emp_name_eng,
				'org_join_date'     	=> date('d M Y',strtotime($result->org_join_date)),
				'br_join_date'      	=> date('d M Y',strtotime($data_result->br_join_date)),
				'designation_name'  	=> $data_result->designation_name,
				'branch_name'      		=> $data_result->branch_name,
				'area_name'      		=> $data_result->area_name,
				'tran_type_no'      	=> $data_result->tran_type_no,
				'c_end_date'     	 	=> (($data_result->next_increment_date != '')) ? date('d M Y',strtotime($data_result->next_increment_date)) : '-',
				're_effect_date'      	=> $result->effect_date,
				'assign_designation'    => $asign_desig,
				'assign_open_date'      => $desig_open_date,
				'asign_branch_name'     => $asign_branch_name,
				'emp_group'      		=> $result->emp_group,
				'asign_area_name'      	=> $asign_area_name,
				'is_permanent'      	=> $data_result->is_permanent,
				'next_permanent_date'   => $data_result->next_permanent_date,
				'joining_date'   		=> $data_result->joining_date,
				'birth_date'   			=> $result->birth_date,
				'asign_open_date'     	=> $asign_open_date
			);	
		}
		return view('admin.my_info.upcomming_notifications', $data);
	}
	
	
	
	
	
	public function abc()
	{
		$i = 1; foreach($staffs as $staff) { 
		if($staff->emp_group == 1 && $staff->is_permanent == 1) { 
		$today = date('Y-m-d');
		$notification_start_date = date('Y-m-d',strtotime($staff->next_permanent_date . "-45 days"));
		if($today >=$notification_start_date && $today <=$staff->next_permanent_date) { 
			echo $i++; 
		} } } 
		//*************//
		$s = 1; foreach($staffs as $staff) { 
		$today 					= date('Y-m-d');
		$retirment_age  		= date('Y-m-d',strtotime($staff->birth_date . "+60 years"));
		$present_date			= date_create($today);
		$retirment_date			= date_create($retirment_age);
		$different				= date_diff($present_date,$retirment_date);  
		$days_left_to_retirment = $different->format("%a");

			if($days_left_to_retirment <=45) {
				$s++;
			} 
		} 
		//*************//
		$r = 1; foreach($staffs as $staff) {
			if($staff->emp_group == 3) { 
			$todate_date 			= date('Y-m-d');
			$contruct_renew_date 	= $staff->next_permanent_date;
			$date3 =date_create($contruct_renew_date);
			$date4 =date_create($todate_date);
			$diffeeeee=date_diff($date4,$date3);
			$contruct_days_left = $diffeeeee->format("%a");
			if($contruct_days_left <= 45 ) {

			$is_cont_renew = DB::table('tbl_contractual_renew as c')
							->where('c.emp_id', '=', $staff->emp_id)	
							->orderBy('c.id', 'DESC')														
							->first();
			if($is_cont_renew)
			{
				$max_renew_date 		= $is_cont_renew->c_end_date;
				$contruct_days_left 	= 0;
				if($is_cont_renew)
				{
					$contruct_renew_date 	= $max_renew_date;
					$date5 					= date_create($contruct_renew_date);
					$date6 					= date_create($todate_date);
					$diffeeeee				= date_diff($date6,$date5);
					$contruct_days_left 	= $diffeeeee->format("%a");
				}
			}
			if($contruct_days_left <= 45 && $contruct_days_left >0) { 
				$r++;
			} } }
		} 
		//*************//
		$permanent = $i-1;
		$retirment = $r -1;
		$contauct  = $r -1;
		$total = $permanent + $retirment + $contauct;
		echo $total;
	}
	
}
