<?php

namespace App\Http\Controllers;
use App\Mail\Notification;
use App\Mail\Force;
use App\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct() 
	{
		//$this->middleware("CheckUserSession");
	}
	
	public function probationRemainder()
    {
		
		$data = array();
		
		$category_type 	= 1;
		$form_date = date("Y-m-d");
		$status = 1;
		
		$all_result = DB::table('tbl_master_tra as m')						
					->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')						
					->where('m.is_permanent', '=', $category_type)
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
		
		if (!empty($all_result)) {
			foreach ($all_result as $result) {
				
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
				
				$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_probation as po', 'm.emp_id', '=', 'po.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->select('e.gender','e.birth_date','e.emp_id','e.emp_name_eng','e.org_join_date','e.permanent_add','m.br_join_date','m.br_code','m.basic_salary','m.next_increment_date','m.is_permanent','po.permanent_date','g.grade_name','d.designation_name','d.designation_code','b.branch_name')
						->first();				
				
				if ($data_result->is_permanent == $category_type) {	
					$data['all_result'][] = array(
						'emp_id' 				=> $result->emp_id,
						'emp_name_eng'      	=> $data_result->emp_name_eng,
						'permanent_add'      	=> $data_result->permanent_add,					
						'org_join_date'      	=> $data_result->org_join_date,
						'br_join_date'      	=> date('d M Y',strtotime($data_result->br_join_date)),
						'permanent_date'      	=> $data_result->permanent_date,
						'is_permanent'      	=> $data_result->is_permanent,
						'grade_name'      		=> $data_result->grade_name,
						'designation_name'  	=> $data_result->designation_name,
						'designation_code'  	=> $data_result->designation_code,
						'branch_code'      		=> $data_result->br_code,	
						'date_of_birth'      	=> $data_result->birth_date,	
						'gender'      			=> $data_result->gender,
					);
				}				
			}
		}
		foreach($data['all_result'] as $row){			
			$org_join_date = $row['org_join_date'];
			
			$probition_date=date('Y-m-d', strtotime($org_join_date. ' + 75 days'));
			if($probition_date==date('Y-m-d'))	{
				
				if ($row['branch_code']==9999){
					
					$supervisor = DB::table('supervisor_mapping_ho as m')
								  ->select('*')
								  ->where('m.mapping_status', '=', 1)	
								  ->where('m.emp_id', '=', $row['emp_id'])		
								  ->first();
					$supervisor_email = DB::table('supervisors as m')
										->select('*')
										->where('m.active_status', '=', 1)	
										->where('m.supervisors_emp_id', '=', $supervisor->supervisor_id)		
										->first();		  
					/*
					$mail_data['view'] 				= "probition";
					$mail_data['email'] 			= $supervisor_email->supervisors_email;
					$mail_data['emp_id'] 			= $row['emp_id'];
					$mail_data['emp_name'] 			= $row['emp_name_eng'];
					$mail_data['designation'] 		= $row['designation_name'];		
					$mail_data['org_join_date'] 	= date('d-m-Y',strtotime($row['org_join_date']));	
					$mail_data['three_month_date'] 	= date('Y-m-d', strtotime($org_join_date. ' + 90 days'));
					$mail_data['gender'] 			= $row['gender']; */
					
					// Mail fire
					
					$view 				= "probition";
					$email 				= $supervisor_email->supervisors_email;
					$emp_id 			= $row['emp_id'];
					$emp_name 			= str_replace(' ', '_', $row['emp_name_eng']);
					$designation 		= str_replace(' ', '_', $row['designation_name']);		
					$org_join_date 		= date('d-m-Y',strtotime($row['org_join_date']));	
					$permanent_date 	= date('Y-m-d', strtotime($org_join_date. ' + 90 days'));
					$gender 			= $row['gender'];
					
					$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_notification/'.$view.'/'.$email.'/'.$emp_id.'/'.$emp_name.'/'.$designation.'/'.$gender.'/'.$org_join_date.'/'.$permanent_date);
					
					//\Mail::send(new Notification($mail_data));					
					
				} else {
					
					if ($row['designation_code']==11 || $row['designation_code']==16 || $row['designation_code']==170 || $row['designation_code']==190 || $row['designation_code']==192 || $row['designation_code']==75){
					//BM
					$supervisor_email = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])	
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->branch_email;
					} else if($row['designation_code']==24 || $row['designation_code']==97 || $row['designation_code']==215){
					//AM
					$area_code = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])
										->where('m.status', '=', 1)			
										->first();
					$supervisor_email = DB::table('tbl_area as m')
										->select('*')
										->where('m.area_code', '=', $area_code->area_code)
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->area_email;
					} else if($row['designation_code']==122 || $row['designation_code']==212){
					//DM
					$zone_code = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])
										->where('m.status', '=', 1)			
										->first();
					$supervisor_email = DB::table('tbl_zone as m')
										->select('*')
										->where('m.zone_code', '=', $zone_code->zone_code)
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->zone_email;
					} else if($row['designation_code']==209 || $row['designation_code']==211){
					//Program
					$sub_email = 'cdipprogram@cdipbd.org';
					} else{
					//
					}
					/*
					$mail_data['view'] 				= "probition";
					$mail_data['email'] 			= $sub_email;
					$mail_data['emp_id'] 			= $row['emp_id'];
					$mail_data['emp_name'] 			= $row['emp_name_eng'];
					$mail_data['designation'] 		= $row['designation_name'];	
					$mail_data['org_join_date'] 	= date('d-m-Y',strtotime($row['org_join_date']));		
					$mail_data['three_month_date'] 	= date('Y-m-d', strtotime($org_join_date. ' + 90 days'));
					$mail_data['gender'] 			= $row['gender'];
					*/
					// Mail fire
					$view 				= "probition";
					$email 				= $sub_email;
					$emp_id 			= $row['emp_id'];
					$emp_name 			= str_replace(' ', '_', $row['emp_name_eng']);
					$designation 		= str_replace(' ', '_', $row['designation_name']);		
					$org_join_date 		= date('d-m-Y',strtotime($row['org_join_date']));	
					$permanent_date 	= date('Y-m-d', strtotime($org_join_date. ' + 90 days'));
					$gender 			= $row['gender'];
					
					$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_notification/'.$view.'/'.$email.'/'.$emp_id.'/'.$emp_name.'/'.$designation.'/'.$gender.'/'.$org_join_date.'/'.$permanent_date);
					//\Mail::send(new Notification($mail_data));
					
				}
			} 
		}
		
    }
	
	public function confirmationRemainder()
    {
		$data = array();
		
		$category_type 	= 1;
		$form_date = date("Y-m-d");
		$status = 1;
		
		$all_result = DB::table('tbl_master_tra as m')						
					->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')						
					->where('m.is_permanent', '=', $category_type)
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
		
		if (!empty($all_result)) {
			foreach ($all_result as $result) {
				
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
				
				$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_probation as po', 'm.emp_id', '=', 'po.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->select('e.gender','e.birth_date','e.emp_id','e.emp_name_eng','e.org_join_date','e.permanent_add','m.br_join_date','m.br_code','m.basic_salary','m.next_increment_date','m.is_permanent','po.permanent_date','g.grade_name','d.designation_name','d.designation_code','b.branch_name')
						->first();				
				
				if ($data_result->is_permanent == $category_type) {	
					$data['all_result'][] = array(
						'emp_id' 				=> $result->emp_id,
						'emp_name_eng'      	=> $data_result->emp_name_eng,
						'permanent_add'      	=> $data_result->permanent_add,					
						'org_join_date'      	=> $data_result->org_join_date,
						'br_join_date'      	=> date('d M Y',strtotime($data_result->br_join_date)),
						'permanent_date'      	=> $data_result->permanent_date,
						'is_permanent'      	=> $data_result->is_permanent,
						'grade_name'      		=> $data_result->grade_name,
						'designation_name'  	=> $data_result->designation_name,
						'designation_code'  	=> $data_result->designation_code,
						'branch_code'      		=> $data_result->br_code,	
						'date_of_birth'      	=> $data_result->birth_date,
						'gender'      			=> $data_result->gender,	
					);
				}				
			}
		}
		foreach($data['all_result'] as $row){			
			$permanent_date = $row['permanent_date'];
			
			$probition_date=date('Y-m-d', strtotime($permanent_date. ' - 45 days'));
		
			if($probition_date==date('Y-m-d'))	{
				
				if ($row['branch_code']==9999){
					
					$supervisor = DB::table('supervisor_mapping_ho as m')
								  ->select('*')
								  ->where('m.mapping_status', '=', 1)	
								  ->where('m.emp_id', '=', $row['emp_id'])		
								  ->first();
					$supervisor_email = DB::table('supervisors as m')
										->select('*')
										->where('m.active_status', '=', 1)	
										->where('m.supervisors_emp_id', '=', $supervisor->supervisor_id)		
										->first();		  
					/*
					$mail_data['view'] 				= "confirmation";
					$mail_data['email'] 			= $supervisor_email->supervisors_email;
					$mail_data['emp_id'] 			= $row['emp_id'];
					$mail_data['emp_name'] 			= $row['emp_name_eng'];
					$mail_data['designation'] 		= $row['designation_name'];	
					$mail_data['org_join_date'] 	= date('d-m-Y',strtotime($row['org_join_date']));
					$mail_data['permanent_date'] 	= date('d-m-Y',strtotime($row['permanent_date']));	
					$mail_data['gender'] 			= $row['gender'];
					*/
					// Mail fire
					$view 				= "confirmation";
					$email 				= $supervisor_email->supervisors_email;
					$emp_id 			= $row['emp_id'];
					$emp_name 			= str_replace(' ', '_', $row['emp_name_eng']);
					$designation 		= str_replace(' ', '_', $row['designation_name']);		
					$org_join_date 		= date('d-m-Y',strtotime($row['org_join_date']));	
					$permanent_date 	= date('d-m-Y',strtotime($row['permanent_date']));
					$gender 			= $row['gender'];
					
					$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_notification/'.$view.'/'.$email.'/'.$emp_id.'/'.$emp_name.'/'.$designation.'/'.$gender.'/'.$org_join_date.'/'.$permanent_date);
					//\Mail::send(new Notification($mail_data));
					
					
				} else {
										
					if ($row['designation_code']==11 || $row['designation_code']==16 || $row['designation_code']==170 || $row['designation_code']==190 || $row['designation_code']==192 || $row['designation_code']==75){
					//BM
					$supervisor_email = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])	
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->branch_email;
					} else if($row['designation_code']==24 || $row['designation_code']==97 || $row['designation_code']==215){
					//AM
					$area_code = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])
										->where('m.status', '=', 1)			
										->first();
					$supervisor_email = DB::table('tbl_area as m')
										->select('*')
										->where('m.area_code', '=', $area_code->area_code)
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->area_email;
					} else if($row['designation_code']==122 || $row['designation_code']==212){
					//DM
					$zone_code = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])
										->where('m.status', '=', 1)			
										->first();
					$supervisor_email = DB::table('tbl_zone as m')
										->select('*')
										->where('m.zone_code', '=', $zone_code->zone_code)
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->zone_email;
					} else if($row['designation_code']==209 || $row['designation_code']==211){
					//Program
					$sub_email = 'cdipprogram@cdipbd.org';
					} else if($row['designation_code']==234  || $row['designation_code']==216 || $row['designation_code']==219 || $row['designation_code']==255 || $row['designation_code']==179 || $row['designation_code']==178 || $row['designation_code']==182 || $row['designation_code']==235 || $row['designation_code']==260 || $row['designation_code']==130 || $row['designation_code']==256 || $row['designation_code']==188 || $row['designation_code']==173 || $row['designation_code']==189 ||  $row['designation_code']==258 ){
					//Special Program
					//|| $row['designation_code']==242 (Shishok Teacher notification stop)
					$sub_email = 'kadir@cdipbd.org';
					}
					/*
					$mail_data['view'] 				= "confirmation";
					$mail_data['email'] 			= $sub_email;
					$mail_data['emp_id'] 			= $row['emp_id'];
					$mail_data['emp_name'] 			= $row['emp_name_eng'];
					$mail_data['designation'] 		= $row['designation_name'];	
					$mail_data['org_join_date'] 	= date('d-m-Y',strtotime($row['org_join_date']));
					$mail_data['permanent_date'] 	= date('d-m-Y',strtotime($row['permanent_date']));
					$mail_data['gender'] 			= $row['gender'];
					*/
					// Mail fire
					$view 				= "confirmation";
					$email 				= $sub_email;
					$emp_id 			= $row['emp_id'];
					$emp_name 			= str_replace(' ', '_', $row['emp_name_eng']);
					$designation 		= str_replace(' ', '_', $row['designation_name']);		
					$org_join_date 		= date('d-m-Y',strtotime($row['org_join_date']));	
					$permanent_date 	= date('d-m-Y',strtotime($row['permanent_date']));
					$gender 			= $row['gender'];
					
					$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_notification/'.$view.'/'.$email.'/'.$emp_id.'/'.$emp_name.'/'.$designation.'/'.$gender.'/'.$org_join_date.'/'.$permanent_date);
					//\Mail::send(new Notification($mail_data));
					
				}
				
				
			}
    }
	}
	
	public function retirementRemainder()
    {
		$data = array();
		
		$category_type 	= 2;
		$form_date = date("Y-m-d");
		$status = 1;
		
		$all_result = DB::table('tbl_master_tra as m')						
					->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')						
					->where('m.is_permanent', '=', $category_type)
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
		
		if (!empty($all_result)) {
			foreach ($all_result as $result) {
				
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
				
				$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_probation as po', 'm.emp_id', '=', 'po.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->select('e.gender','e.birth_date','e.emp_id','e.emp_name_eng','e.org_join_date','e.permanent_add','m.br_join_date','m.br_code','m.basic_salary','m.next_increment_date','m.is_permanent','po.permanent_date','g.grade_name','d.designation_name','d.designation_code','b.branch_name')
						->first();			
				
				if ($data_result->is_permanent == $category_type) {	
					$data['all_result'][] = array(
						'emp_id' => $result->emp_id,
						'emp_name_eng'      => $data_result->emp_name_eng,
						'permanent_add'      => $data_result->permanent_add,					
						'org_join_date'      => $data_result->org_join_date,
						'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
						'permanent_date'      => $data_result->permanent_date,
						'is_permanent'      => $data_result->is_permanent,
						'grade_name'      => $data_result->grade_name,
						'designation_name'      => $data_result->designation_name,
						'designation_code'  	=> $data_result->designation_code,
						'branch_code'      => $data_result->br_code,	
						'date_of_birth'      => $data_result->birth_date,
						'gender'      			=> $data_result->gender,	
					);
				}				
			}
		}
		foreach($data['all_result'] as $row){	
		if ($row['emp_id']<200000){
			$sixty_date = date('d-m-Y', strtotime('+60 year', strtotime($row['date_of_birth']))); 
			$remaider_date = date('Y-m-d', strtotime($sixty_date. ' - 46 days'));
			//echo $row['emp_id'].'///'.$row['date_of_birth'].'///'.$sixty_date.'///'.$remaider_date.'</br>';
			
			if($remaider_date==date('Y-m-d'))	{
				if ($row['branch_code']==9999){
					
					$supervisor = DB::table('supervisor_mapping_ho as m')
								  ->select('*')
								  ->where('m.mapping_status', '=', 1)	
								  ->where('m.emp_id', '=', $row['emp_id'])		
								  ->first();
					$supervisor_email = DB::table('supervisors as m')
										->select('*')
										->where('m.active_status', '=', 1)	
										->where('m.supervisors_emp_id', '=', $supervisor->supervisor_id)		
										->first();		  
					/*
					$mail_data['view'] 				= "retirement";
					$mail_data['email'] 			= $supervisor_email->supervisors_email;
					$mail_data['emp_id'] 			= $row['emp_id'];
					$mail_data['emp_name'] 			= $row['emp_name_eng'];
					$mail_data['designation'] 		= $row['designation_name'];	
					$mail_data['org_join_date'] 	= date('d-m-Y',strtotime($row['org_join_date']));
					$mail_data['retire_date'] 		= date('d-m-Y',strtotime($sixty_date));	
					$mail_data['gender'] 			= $row['gender'];
					*/
					// Mail fire
					$view 				= "retirement";
					$email 				= $supervisor_email->supervisors_email;
					$emp_id 			= $row['emp_id'];
					$emp_name 			= str_replace(' ', '_', $row['emp_name_eng']);
					$designation 		= str_replace(' ', '_', $row['designation_name']);		
					$org_join_date 		= date('d-m-Y',strtotime($row['org_join_date']));	
					$permanent_date 	= date('d-m-Y',strtotime($sixty_date));
					$gender 			= $row['gender'];
					
					$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_notification/'.$view.'/'.$email.'/'.$emp_id.'/'.$emp_name.'/'.$designation.'/'.$gender.'/'.$org_join_date.'/'.$permanent_date);
						
					//\Mail::send(new Notification($mail_data));					
					
				} else {
					
										
					if ($row['designation_code']==11 || $row['designation_code']==16 || $row['designation_code']==170 || $row['designation_code']==190 || $row['designation_code']==192 || $row['designation_code']==75 || $row['designation_code']==74){
					//BM
					$supervisor_email = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])	
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->branch_email;
					} else if($row['designation_code']==24 || $row['designation_code']==97 || $row['designation_code']==215){
					//AM
					$area_code = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])
										->where('m.status', '=', 1)			
										->first();
					$supervisor_email = DB::table('tbl_area as m')
										->select('*')
										->where('m.area_code', '=', $area_code->area_code)
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->area_email;
					} else if($row['designation_code']==122 || $row['designation_code']==212){
					//DM
					$zone_code = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])
										->where('m.status', '=', 1)			
										->first();
					$supervisor_email = DB::table('tbl_zone as m')
										->select('*')
										->where('m.zone_code', '=', $zone_code->zone_code)
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->zone_email;
					} else if($row['designation_code']==209 || $row['designation_code']==211){
					//Program
					$sub_email = 'cdipprogram@cdipbd.org';
					}else if($row['designation_code']==234  || $row['designation_code']==216 || $row['designation_code']==219 || $row['designation_code']==255 || $row['designation_code']==179 || $row['designation_code']==178 || $row['designation_code']==182 || $row['designation_code']==235 || $row['designation_code']==260 || $row['designation_code']==130 || $row['designation_code']==256 || $row['designation_code']==188 || $row['designation_code']==173 || $row['designation_code']==189 || $row['designation_code']==258 ){
					//Special Program
					//||  $row['designation_code']==242 NOtification off
					$sub_email = 'kadir@cdipbd.org';
					}
					/*
					$mail_data['view'] 				= "retirement";
					$mail_data['email'] 			= $sub_email;
					$mail_data['emp_id'] 			= $row['emp_id'];
					$mail_data['emp_name'] 			= $row['emp_name_eng'];
					$mail_data['designation'] 		= $row['designation_name'];	
					$mail_data['org_join_date'] 	= date('d-m-Y',strtotime($row['org_join_date']));
					$mail_data['retire_date'] 		= date('d-m-Y',strtotime($sixty_date));
					$mail_data['gender'] 			= $row['gender'];
					*/
					// Mail fire	
					$view 				= "retirement";
					$email 				= $sub_email;
					$emp_id 			= $row['emp_id'];
					$emp_name 			= str_replace(' ', '_', $row['emp_name_eng']);
					$designation 		= str_replace(' ', '_', $row['designation_name']);		
					$org_join_date 		= date('d-m-Y',strtotime($row['org_join_date']));	
					$permanent_date 	= date('d-m-Y',strtotime($sixty_date));
					$gender 			= $row['gender'];
					
					$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_notification/'.$view.'/'.$email.'/'.$emp_id.'/'.$emp_name.'/'.$designation.'/'.$gender.'/'.$org_join_date.'/'.$permanent_date);
					
					//\Mail::send(new Notification($mail_data));
				
				}
			}
			
		}
		}
    }
	
	public function contractRemainder()
    {
		
		$data = array();
		
		$form_date = date("Y-m-d");
		$status = 1;
		
		$all_result = DB::table('tbl_master_tra as m')						
					->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')						
					->where('m.is_permanent', '!=', 1)
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
		
		if (!empty($all_result)) {
			foreach ($all_result as $result) {
				
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
				
				$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_probation as po', 'm.emp_id', '=', 'po.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->select('m.next_increment_date','e.gender','e.birth_date','e.emp_id','e.emp_name_eng','e.org_join_date','e.permanent_add','m.br_join_date','m.br_code','m.basic_salary','m.next_increment_date','m.is_permanent','po.permanent_date','g.grade_name','d.designation_name','d.designation_code','b.branch_name')
						->first();			
				
				if ($data_result->is_permanent != 1) {	
					$data['all_result'][] = array(
						'emp_id' => $result->emp_id,
						'emp_name_eng'      => $data_result->emp_name_eng,
						'permanent_add'      => $data_result->permanent_add,					
						'org_join_date'      => $data_result->org_join_date,
						'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
						'permanent_date'      => $data_result->permanent_date,
						'is_permanent'      => $data_result->is_permanent,
						'grade_name'      => $data_result->grade_name,
						'designation_name'      => $data_result->designation_name,
						'designation_code'  	=> $data_result->designation_code,
						'branch_code'      => $data_result->br_code,	
						'date_of_birth'      => $data_result->birth_date,
						'gender'      			=> $data_result->gender,
						'contract_ending_date'  => $data_result->next_increment_date,						
					);
				}				
			}
		}
		foreach($data['all_result'] as $row){	
			/*if ($row['emp_id']>200000){
			echo $row['emp_id'].'---->'.$row['emp_name_eng'].'---->'.$row['contract_ending_date'].'</br>';
			} */
			if ($row['emp_id']>200000 && !empty($row['contract_ending_date']) && date('Y', strtotime($row['contract_ending_date']))>2019){
				$remaider_date = date('Y-m-d', strtotime($row['contract_ending_date']. ' - 45 days'));
				
				if ($remaider_date==date('Y-m-d')){
					if ($row['branch_code']==9999){
						$supervisor = DB::table('supervisor_mapping_ho as m')
								  ->select('*')
								  ->where('m.mapping_status', '=', 1)	
								  ->where('m.emp_id', '=', $row['emp_id'])		
									  ->first();
						$supervisor_email = DB::table('supervisors as m')
											->select('*')
											->where('m.active_status', '=', 1)	
											->where('m.supervisors_emp_id', '=', $supervisor->supervisor_id)		
											->first();		  
						/*
						$mail_data['view'] 				= "contract";
						$mail_data['email'] 			= $supervisor_email->supervisors_email;
						$mail_data['emp_id'] 			= $row['emp_id'];
						$mail_data['emp_name'] 			= $row['emp_name_eng'];
						$mail_data['designation'] 		= $row['designation_name'];	
						$mail_data['org_join_date'] 	= date('d-m-Y',strtotime($row['org_join_date']));
						$mail_data['permanent_date'] 	= date('d-m-Y',strtotime($row['contract_ending_date']));	
						$mail_data['gender'] 			= $row['gender'];
						*/	
						// Mail fire	
						$view 				= "contract";
						$email 				= $supervisor_email->supervisors_email;
						$emp_id 			= $row['emp_id'];
						$emp_name 			= str_replace(' ', '_', $row['emp_name_eng']);
						$designation 		= str_replace(' ', '_', $row['designation_name']);		
						$org_join_date 		= date('d-m-Y',strtotime($row['org_join_date']));	
						$permanent_date 	= date('d-m-Y',strtotime($row['contract_ending_date']));
						$gender 			= $row['gender'];
						
						$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_notification/'.$view.'/'.$email.'/'.$emp_id.'/'.$emp_name.'/'.$designation.'/'.$gender.'/'.$org_join_date.'/'.$permanent_date);
					
						//\Mail::send(new Notification($mail_data));
					} else {
						
										
					if ($row['designation_code']==11 || $row['designation_code']==16 || $row['designation_code']==170 || $row['designation_code']==190 || $row['designation_code']==192 || $row['designation_code']==75 || $row['designation_code']==74){
					//BM
					$supervisor_email = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])	
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->branch_email;
					} else if($row['designation_code']==24 || $row['designation_code']==97 || $row['designation_code']==215){
					//AM
					$area_code = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])
										->where('m.status', '=', 1)			
										->first();
					$supervisor_email = DB::table('tbl_area as m')
										->select('*')
										->where('m.area_code', '=', $area_code->area_code)
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->area_email;
					} else if($row['designation_code']==122 || $row['designation_code']==212){
					//DM
					$zone_code = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])
										->where('m.status', '=', 1)			
										->first();
					$supervisor_email = DB::table('tbl_zone as m')
										->select('*')
										->where('m.zone_code', '=', $zone_code->zone_code)
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->zone_email;
					} else if($row['designation_code']==209 || $row['designation_code']==211){
					//Program
					$sub_email = 'cdipprogram@cdipbd.org';
					}else if($row['designation_code']==234  || $row['designation_code']==216 || $row['designation_code']==219 || $row['designation_code']==255 || $row['designation_code']==179 || $row['designation_code']==178 || $row['designation_code']==182 || $row['designation_code']==235 || $row['designation_code']==260 || $row['designation_code']==130 || $row['designation_code']==256 || $row['designation_code']==188 || $row['designation_code']==173 || $row['designation_code']==189 ||  $row['designation_code']==258 ){
					//Special Program
					//||  $row['designation_code']==242 Notification Off
					$sub_email = 'kadir@cdipbd.org';
					}
					/*
					$mail_data['view'] 				= "contract";
					$mail_data['email'] 			= $sub_email;
					$mail_data['emp_id'] 			= $row['emp_id'];
					$mail_data['emp_name'] 			= $row['emp_name_eng'];
					$mail_data['designation'] 		= $row['designation_name'];	
					$mail_data['org_join_date'] 	= date('d-m-Y',strtotime($row['org_join_date']));
					$mail_data['permanent_date'] 	= date('d-m-Y',strtotime($row['contract_ending_date']));
					$mail_data['gender'] 			= $row['gender'];
					*/
				
					// Mail fire	
					$view 				= "contract";
					$email 				= $sub_email;
					$emp_id 			= $row['emp_id'];
					$emp_name 			= str_replace(' ', '_', $row['emp_name_eng']);
					$designation 		= str_replace(' ', '_', $row['designation_name']);		
					$org_join_date 		= date('d-m-Y',strtotime($row['org_join_date']));	
					$permanent_date 	= date('d-m-Y',strtotime($row['contract_ending_date']));
					$gender 			= $row['gender'];
					
					$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_notification/'.$view.'/'.$email.'/'.$emp_id.'/'.$emp_name.'/'.$designation.'/'.$gender.'/'.$org_join_date.'/'.$permanent_date);
					
					//\Mail::send(new Notification($mail_data));
					
					}
					
				}
			}
			
		
		}
        
    }
	
	
	public function forceRemainder()
    {
		$data = array();
		
		$category_type 	= 1;
		$form_date = date("Y-m-d");
		$status = 1;
		
		$all_result = DB::table('tbl_master_tra as m')						
					->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')						
					->where('m.is_permanent', '=', $category_type)
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
		
		if (!empty($all_result)) {
			foreach ($all_result as $result) {
				
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
				
				$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_probation as po', 'm.emp_id', '=', 'po.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->select('e.gender','e.birth_date','e.emp_id','e.emp_name_eng','e.org_join_date','e.permanent_add','m.br_join_date','m.br_code','m.basic_salary','m.next_increment_date','m.is_permanent','po.permanent_date','g.grade_name','d.designation_name','d.designation_code','b.branch_name')
						->first();				
				
				if ($data_result->is_permanent == $category_type) {	
					$data['all_result'][] = array(
						'emp_id' 				=> $result->emp_id,
						'emp_name_eng'      	=> $data_result->emp_name_eng,
						'permanent_add'      	=> $data_result->permanent_add,					
						'org_join_date'      	=> $data_result->org_join_date,
						'br_join_date'      	=> date('d M Y',strtotime($data_result->br_join_date)),
						'permanent_date'      	=> $data_result->permanent_date,
						'is_permanent'      	=> $data_result->is_permanent,
						'grade_name'      		=> $data_result->grade_name,
						'designation_name'  	=> $data_result->designation_name,
						'designation_code'  	=> $data_result->designation_code,
						'branch_code'      		=> $data_result->br_code,	
						'date_of_birth'      	=> $data_result->birth_date,
						'gender'      			=> $data_result->gender,	
					);
				}				
			}
		}
		foreach($data['all_result'] as $row){
			if($row['emp_id'] !=4261 && $row['emp_id'] !=4492 && $row['emp_id'] !=4630 && $row['emp_id'] !=4631 && $row['emp_id'] !=4634 && $row['emp_id'] !=4643 && $row['emp_id'] !=4644 && $row['emp_id'] !=4645 && $row['emp_id'] !=4647 && $row['emp_id'] !=4652){
				
			$permanent_date = $row['permanent_date'];
			if (empty($permanent_date)){
				$permanent_date = date('Y-m-d', strtotime("+6 months", strtotime($row['org_join_date'])));
			}
			$probition_date=date('Y-m-d', strtotime($permanent_date. ' - 45 days'));
		
			if($probition_date<=date('Y-m-d'))	{
				if ($row['branch_code']==9999){
					
					$supervisor = DB::table('supervisor_mapping_ho as m')
								  ->select('*')
								  ->where('m.mapping_status', '=', 1)	
								  ->where('m.emp_id', '=', $row['emp_id'])		
								  ->first();
					$supervisor_email = DB::table('supervisors as m')
										->select('*')
										->where('m.active_status', '=', 1)	
										->where('m.supervisors_emp_id', '=', $supervisor->supervisor_id)		
										->first();		  
	
					$mail_data['view'] 				= "confirmation";
					$mail_data['email'] 			= $supervisor_email->supervisors_email;
					$mail_data['emp_id'] 			= $row['emp_id'];
					$mail_data['emp_name'] 			= $row['emp_name_eng'];
					$mail_data['designation'] 		= $row['designation_name'];	
					$mail_data['org_join_date'] 	= date('d-m-Y',strtotime($row['org_join_date']));
					$mail_data['permanent_date'] 	= date('d-m-Y',strtotime($row['permanent_date']));	
					$mail_data['gender'] 			= $row['gender'];	
					\Mail::send(new Force($mail_data));
					//echo $permanent_date.'//'.$probition_date.'//'.$mail_data['emp_name'].'//'.$mail_data['emp_id'].'//'.$supervisor_email->supervisors_email.'</br>';
					
				} else {
										
					if ($row['designation_code']==11 || $row['designation_code']==16 || $row['designation_code']==170 || $row['designation_code']==190 || $row['designation_code']==192 || $row['designation_code']==75 || $row['designation_code']==74){
					//BM
					$supervisor_email = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])	
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->branch_email;
					} else if($row['designation_code']==24 || $row['designation_code']==97 || $row['designation_code']==215){
					//AM
					$area_code = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])
										->where('m.status', '=', 1)			
										->first();
					$supervisor_email = DB::table('tbl_area as m')
										->select('*')
										->where('m.area_code', '=', $area_code->area_code)
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->area_email;
					} else if($row['designation_code']==122 || $row['designation_code']==212){
					//DM
					$zone_code = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])
										->where('m.status', '=', 1)			
										->first();
					$supervisor_email = DB::table('tbl_zone as m')
										->select('*')
										->where('m.zone_code', '=', $zone_code->zone_code)
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->zone_email;
					} else if($row['designation_code']==209 || $row['designation_code']==211){
					//Program
					$sub_email = 'cdipprogram@cdipbd.org';
					}else if($row['designation_code']==234  || $row['designation_code']==216 || $row['designation_code']==219 || $row['designation_code']==255 || $row['designation_code']==179 || $row['designation_code']==178 || $row['designation_code']==182 || $row['designation_code']==235 || $row['designation_code']==260 || $row['designation_code']==130 || $row['designation_code']==256 || $row['designation_code']==188 || $row['designation_code']==173 || $row['designation_code']==189 || $row['designation_code']==258 ){
					//Special Program
					//||  $row['designation_code']==242 notification off
					$sub_email = 'kadir@cdipbd.org';
					}
					
					$mail_data['view'] 				= "confirmation";
					$mail_data['email'] 			= $sub_email;
					$mail_data['emp_id'] 			= $row['emp_id'];
					$mail_data['emp_name'] 			= $row['emp_name_eng'];
					$mail_data['designation'] 		= $row['designation_name'];	
					$mail_data['org_join_date'] 	= date('d-m-Y',strtotime($row['org_join_date']));
					$mail_data['permanent_date'] 	= date('d-m-Y',strtotime($row['permanent_date']));
					$mail_data['gender'] 			= $row['gender'];	
					\Mail::send(new Force($mail_data));
					//echo $permanent_date.'//'.$mail_data['emp_name'].'//'.$mail_data['emp_id'].'//'.$sub_email.'</br>';
					//{view}/{email}/{emp_id}/{designation}/{org_join_date}/{permanent_date}/{gender}
					
					$file = file_get_contents('http://202.4.106.3/cdiphr_old/mail_fire_notification/'.$view.'/'.$email.'/'.$emp_id.'/'.$emp_name.'/'.$designation.'/'.$org_join_date.'/'.$permanent_date.'/'.$gender);
				}
				
			} 
			}
    }
    }
	
	public function forceretRemainder()
    {
		$data = array();
		
		//$category_type 	= 2;
		$form_date = date("Y-m-d");
		$status = 1;
		
		$all_result = DB::table('tbl_master_tra as m')						
					->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')						
					->where('m.is_permanent', '!=', 1)
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
		
		if (!empty($all_result)) {
			foreach ($all_result as $result) {
				
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
				
				$data_result = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->leftJoin('tbl_probation as po', 'm.emp_id', '=', 'po.emp_id')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
						->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
						->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
						->where('m.sarok_no', '=', $max_sarok->sarok_no)
						->select('m.next_increment_date','e.gender','e.birth_date','e.emp_id','e.emp_name_eng','e.org_join_date','e.permanent_add','m.br_join_date','m.br_code','m.basic_salary','m.next_increment_date','m.is_permanent','po.permanent_date','g.grade_name','d.designation_name','d.designation_code','b.branch_name')
						->first();			
				
				if ($data_result->is_permanent != 1) {	
					$data['all_result'][] = array(
						'emp_id' => $result->emp_id,
						'emp_name_eng'      => $data_result->emp_name_eng,
						'permanent_add'      => $data_result->permanent_add,					
						'org_join_date'      => $data_result->org_join_date,
						'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
						'permanent_date'      => $data_result->permanent_date,
						'is_permanent'      => $data_result->is_permanent,
						'grade_name'      => $data_result->grade_name,
						'designation_name'      => $data_result->designation_name,
						'designation_code'  	=> $data_result->designation_code,
						'branch_code'      => $data_result->br_code,	
						'date_of_birth'      => $data_result->birth_date,
						'gender'      			=> $data_result->gender,
						'contract_ending_date'  => $data_result->next_increment_date,						
					);
				}				
			}
		}
		foreach($data['all_result'] as $row){	
		if($row['emp_id'] ==200667 || $row['emp_id'] ==202342 || $row['emp_id'] ==203360 || $row['emp_id'] ==203372 || $row['emp_id'] ==203385){
			
			$sixty_date = date('d-m-Y', strtotime('+60 year', strtotime($row['date_of_birth']))); 
			$remaider_date = date('Y-m-d', strtotime($sixty_date. ' - 46 days'));
			
			if ($row['emp_id']>200000 && !empty($row['contract_ending_date']) && date('Y', strtotime($row['contract_ending_date']))>2019){
				$remaider_date = date('Y-m-d', strtotime($row['contract_ending_date']. ' - 45 days'));
				
				if ($remaider_date<=date('Y-m-d')){
					if ($row['branch_code']==9999){
						$supervisor = DB::table('supervisor_mapping_ho as m')
								  ->select('*')
								  ->where('m.mapping_status', '=', 1)	
								  ->where('m.emp_id', '=', $row['emp_id'])		
									  ->first();
						$supervisor_email = DB::table('supervisors as m')
											->select('*')
											->where('m.active_status', '=', 1)	
											->where('m.supervisors_emp_id', '=', $supervisor->supervisor_id)		
											->first();		  
		
						$mail_data['view'] 				= "contract";
						$mail_data['email'] 			= $supervisor_email->supervisors_email;
						$mail_data['emp_id'] 			= $row['emp_id'];
						$mail_data['emp_name'] 			= $row['emp_name_eng'];
						$mail_data['designation'] 		= $row['designation_name'];	
						$mail_data['org_join_date'] 	= date('d-m-Y',strtotime($row['org_join_date']));
						$mail_data['permanent_date'] 	= date('d-m-Y',strtotime($row['contract_ending_date']));	
						$mail_data['gender'] 			= $row['gender'];	
						\Mail::send(new Force($mail_data));
						//echo $mail_data['emp_name'].'//'.$mail_data['emp_id'].'//'.$supervisor_email->supervisors_email.'</br>';
					} else {
						
										
					if ($row['designation_code']==11 || $row['designation_code']==16 || $row['designation_code']==170 || $row['designation_code']==190 || $row['designation_code']==192 || $row['designation_code']==75 || $row['designation_code']==74){
					//BM
					$supervisor_email = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])	
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->branch_email;
					} else if($row['designation_code']==24 || $row['designation_code']==97 || $row['designation_code']==215){
					//AM
					$area_code = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])
										->where('m.status', '=', 1)			
										->first();
					$supervisor_email = DB::table('tbl_area as m')
										->select('*')
										->where('m.area_code', '=', $area_code->area_code)
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->area_email;
					} else if($row['designation_code']==122 || $row['designation_code']==212){
					//DM
					$zone_code = DB::table('tbl_branch as m')
										->select('*')
										->where('m.br_code', '=', $row['branch_code'])
										->where('m.status', '=', 1)			
										->first();
					$supervisor_email = DB::table('tbl_zone as m')
										->select('*')
										->where('m.zone_code', '=', $zone_code->zone_code)
										->where('m.status', '=', 1)			
										->first();
					$sub_email = $supervisor_email->zone_email;
					} else if($row['designation_code']==209 || $row['designation_code']==211){
					//Program
					$sub_email = 'cdipprogram@cdipbd.org';
					} else if($row['designation_code']==234 ||  $row['designation_code']==216 || $row['designation_code']==219 || $row['designation_code']==255 || $row['designation_code']==179 || $row['designation_code']==178 || $row['designation_code']==182 || $row['designation_code']==235 || $row['designation_code']==260 || $row['designation_code']==130 || $row['designation_code']==256 || $row['designation_code']==188 || $row['designation_code']==173 || $row['designation_code']==189 ||  $row['designation_code']==258 ){
					//Special Program
					//|| $row['designation_code']==242 Nofification off
					$sub_email = 'kadir@cdipbd.org';
					}
					
					$mail_data['view'] 				= "contract";
					$mail_data['email'] 			= $sub_email;
					$mail_data['emp_id'] 			= $row['emp_id'];
					$mail_data['emp_name'] 			= $row['emp_name_eng'];
					$mail_data['designation'] 		= $row['designation_name'];	
					$mail_data['org_join_date'] 	= date('d-m-Y',strtotime($row['org_join_date']));
					$mail_data['permanent_date'] 	= date('d-m-Y',strtotime($row['contract_ending_date']));
					$mail_data['gender'] 			= $row['gender'];	
					\Mail::send(new Force($mail_data));
					//echo $mail_data['emp_name'].'//'.$mail_data['emp_id'].'//'.$sub_email.'</br>';
					}
					
				}
			}
			
		}
		}
    }
	
	
}
