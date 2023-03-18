<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use File;
use Session;
class EdmsdocumentpersonalController extends Controller
{
	 public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
     
	public function testtt()
    { 
		/* $u_emp_id 		= 4767; 
		$form_date = date("Y-m-d");
		$department_info_head  = DB::table('tbl_emp_mapping as e')
												 ->where('e.emp_id',$u_emp_id)
												 ->where(function($q) use ($form_date) {
													 $q->where('e.start_date','<=', $form_date)->where('e.end_date','>=', $form_date)->orWhere('e.start_date','<=', $form_date)->whereNull('e.end_date')->orwhere('e.end_date','=','0000-00-00');
												 })  
												 ->select('e.emp_id','e.current_department_id') 
												 ->first(); 
	 echo "";
	 print_r($department_info_head);
	 exit; */
	}
	public function per_document()
    { 
		$data = array(); 
		
		$user_emp_id 			= Session::get('emp_id');
		$data['Heading'] = $data['title'] = 'View Document';
		$data['action'] = "/per_emp_attachment";
		$u_user_type 	= Session::get('user_type'); // 3=dm,4=am,5=bm
		$data['category_list'] = DB::table('tbl_edms_category') 
									
									->where(function($query) use($u_user_type)
												{
													if($u_user_type == 7 || $u_user_type == 12){
														$query->where('category_id',23)
														   ->orwhere('category_id',35)
														   ->orwhere('category_id',20)
														   ->orwhere('category_id',11)
														   ->orwhere('category_id',16)
														   ->orwhere('category_id',9)
														   ->orwhere('category_id',17)
														   ->orwhere('category_id',8)
														   ->orwhere('category_id',26);
													}else if($u_user_type == 11 || $u_user_type == 13){
														
													}else{
														$query->where('category_id',23)
														   ->orwhere('category_id',35)
														   ->orwhere('category_id',20)
														   ->orwhere('category_id',11) 
														   ->orwhere('category_id',8)
														   ->orwhere('category_id',26);
													}
													
												}) 
									->orderby('category_name','asc') 
									->where('status',1)
									->get();
		$data['subcategory_list'] = DB::table('tbl_edms_subcategory') 
									->where('status',1)
									->orderby('subcategory_name','asc')
									->get();
		$data['type_list'] = DB::table('tbl_emp_type') 
									->where('status',1) 
									->get();
		$data['emp_name']		= 1;
		$data['emp_image']		= 'h.jpg';
		$data['designation_code']	= '';
		$data['branch_code']		= '';	
		$data['br_code']		= '';	
		$data['category_id']		= '';			
		$data['subcat_id']			= '';
		$data['emp_id']				= '';			
		$data['c_effect_date']			= 1; 
		$data['is_access'] = 1;
		/* echo '<pre>';
		print_r($data['emp_document_list']);
		exit; */
		return view('admin.personal_document.emp_view_record_personal',$data);
    }
	public function per_emp_attachment(Request $request)
    {
		$data = array(); 

		$admin_access_label 			= Session::get('admin_access_label');		
		$user_emp_id 			= Session::get('emp_id');		
		$data['Heading'] = $data['title'] = 'View Document';
		$in_subcategory = [50,49,46];	 
		$pro_subcategory = [24,49,46];	 
		$tran_subcategory = [24,50,46];	 
		$prob_subcategory = [24,50,49];	
		$asigndata = array(1,2,5);
		$assign_emp = '';
		$assign_branch = '';
		$assign_designation = '';
		$department_name = '';
		$exam_name			= ''; 
		$u_user_type 	= Session::get('user_type'); // 3=dm,4=am,5=bm
		
		if(isset($request->emp_id1)){
			$emp_id 		= $request->emp_id1;
		}else{
			$emp_id 		= '';
		}
		if(isset($request->category_id)){
			$category_id 		= $request->category_id;
		}else{
			$category_id 		= '';
		}
		if(isset($request->subcat_id)){
			$subcat_id 		= $request->subcat_id;
		}else{
			$subcat_id 		= '';
		} 
		$data['category_id']		= $category_id;			
		$data['subcat_id']			= $subcat_id;
		
		$data['emp_id']				= $emp_id;			 
		$data['action'] = "/per_emp_attachment";
		$data['type_list'] = DB::table('tbl_emp_type') 
									->where('status',1)  
									->get(); 
		 
		 $data['category_list'] = DB::table('tbl_edms_category')  
									->where(function($query) use($u_user_type)
												{
													if($u_user_type == 7 || $u_user_type == 12){
														$query->where('category_id',23)
															   ->orwhere('category_id',35)
															   ->orwhere('category_id',20)
															   ->orwhere('category_id',11)
															   ->orwhere('category_id',16)
															   ->orwhere('category_id',9)
															   ->orwhere('category_id',17)
															   ->orwhere('category_id',8)
															   ->orwhere('category_id',26);
													}else if($u_user_type == 11 || $u_user_type == 13){
														
													}else{
														$query->where('category_id',23)
														   ->orwhere('category_id',35)
														   ->orwhere('category_id',20)
														   ->orwhere('category_id',11) 
														   ->orwhere('category_id',8)
														   ->orwhere('category_id',26);
													}
													
												})
									->where('status',1)
									->orderby('category_name','asc') 
									->get();
		$data['subcategory_list'] = DB::table('tbl_edms_subcategory') 
									
									->where(function($query) use($u_user_type,$category_id)
												{  
												  if($u_user_type == 7 || $u_user_type == 12 ){
															$query->where('category_id',$category_id)
															      ->whereIn('for_which',[2,4]); 
													}else if($u_user_type == 11 || $u_user_type == 13){
														
													}else{
															$query->where('category_id',$category_id)
															  ->whereIn('for_which',[3,4]);
														}
													 
													
												})
									->where('status',1)
									->orderby('subcategory_name','asc')
									->get();
		 
		 
		 
		 
		$current_date = date('Y-m-d');
						$max_sarok = DB::table('tbl_master_tra as m')
										->where('m.emp_id', '=', $emp_id)
										->where('m.br_join_date', '=', function($query) use ($emp_id,$current_date)
												{
													$query->select(DB::raw('max(br_join_date)'))
														  ->from('tbl_master_tra')
														  ->where('emp_id',$emp_id)
														  ->where('br_join_date', '<=', $current_date);
												})
										->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
										->groupBy('emp_id')
										->first();	
						if(!empty($max_sarok)){
							$emp_info = DB::table('tbl_master_tra as m') 
											->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id') 
											->leftJoin('tbl_grade_new as g', 'g.grade_code', '=', 'm.grade_code')
											->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
											->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
											->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
											->leftJoin('tbl_area as ar', 'b.area_code', '=', 'ar.area_code')
											->leftJoin('tbl_zone as zb', 'ar.zone_code', '=', 'zb.zone_code')
											->leftJoin('tbl_department as dp', 'm.department_code', '=', 'dp.department_id') 
											->leftJoin(DB::raw("(SELECT exf.emp_id,max(exf.level_id) as level_id
											FROM tbl_emp_edu_info as exf GROUP BY exf.emp_id) as em"),
											'em.emp_id','=','emp.emp_id')
											->where('m.sarok_no', '=', $max_sarok->sarok_no)
											->select('emp.emp_id','emp.emp_name_eng as emp_name','zb.zone_code','b.br_code','ar.area_code','d.designation_name','r.effect_date as c_effect_date','d.designation_code','d.designation_group_code','b.branch_name','g.grade_name','dp.department_name','m.department_code','em.level_id','m.report_to_new','m.report_to_emp_type')
											->first(); 
							
						if (!empty($emp_info->level_id)) {
								$exam_result = DB::table('tbl_emp_edu_info as ed')
									->leftJoin('tbl_exam_name as en', 'ed.exam_code', '=', 'en.exam_code')
									->where('ed.emp_id', '=', $emp_id)
									->where('ed.level_id', '=', $emp_info->level_id)
									->select('en.exam_name')
									->first();
									//print_r ($exam_result);
									$exam_name = $exam_result->exam_name;
							}	
							
							
							$department_name			= $emp_info->department_name; 
							$department_code			= $emp_info->department_code; 
							$report_to_emp_type			= $emp_info->report_to_emp_type;
							$report_to_new				= $emp_info->report_to_new;
							$data['grade_name']			= $emp_info->grade_name;
						}else{
							$emp_info 					='';
							$data['grade_name']			= '';
							$department_name			= ''; 
							$report_to_emp_type			= '';
							$report_to_new				= '';
							$department_code				= '';
						}		
						
					 
					$assign_emp = DB::table('tbl_emp_assign as ea')
									->where('ea.emp_id',$emp_id)
									->where('ea.status', '!=', 0)
									->where('ea.select_type', '=', 1)
									->select('ea.emp_id','ea.open_date','ea.incharge_as')
									->first();
					$assign_branch = DB::table('tbl_emp_assign as ea')
												->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code')
												->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
												->leftJoin('tbl_zone as zb', 'ar.zone_code', '=', 'zb.zone_code')
												->where('ea.emp_id',$emp_id)
												->where('ea.open_date', '<=', $current_date)
												->where('ea.status', '!=', 0)
												->where('ea.select_type', '=', 2)
												->select('ea.emp_id','ea.open_date','zb.zone_code','br.branch_name','br.br_code','ar.area_name','ar.area_code')
												->first();
					$assign_designation = DB::table('tbl_emp_assign as ea')
												->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
												->where('ea.emp_id',$emp_id)
												->where('ea.status', '!=', 0)
												->where('ea.select_type', '=', 5)
												->select('ea.emp_id','ea.open_date','de.designation_name','de.designation_code','de.designation_group_code')
												->first();  
		
					$data['emp_history_permanent'] = DB::table('tbl_permanent')
											->where('tbl_permanent.emp_id',$emp_id)   
											->select('tbl_permanent.emp_id','tbl_permanent.effect_date','tbl_permanent.letter_date')
											->first();			
					$data['emp_history_probition'] = DB::table('tbl_probation')
											
													->leftJoin('tbl_emp_basic_info as em', 'em.emp_id', '=', 'tbl_probation.emp_id')
													->where('tbl_probation.emp_id',$emp_id)   
													->select('tbl_probation.emp_id','em.org_join_date as br_joined_date','tbl_probation.effect_date','tbl_probation.letter_date')
													->first();  
					$data['emp_history_promotion'] = DB::table('tbl_promotion')
													->where('tbl_promotion.emp_id',$emp_id)   
													->orderby('tbl_promotion.effect_date','desc')   
													->select('tbl_promotion.emp_id','tbl_promotion.effect_date','tbl_promotion.letter_date','tbl_promotion.grade_code')
													->get(); 
					$data['emp_history_transfer'] = DB::table('tbl_transfer')
													->leftJoin('tbl_branch as br', 'br.br_code', '=', 'tbl_transfer.br_code')
													->where('tbl_transfer.emp_id',$emp_id)   
													 ->orderby('tbl_transfer.br_joined_date','desc') 
													->select('tbl_transfer.emp_id','tbl_transfer.br_joined_date','tbl_transfer.letter_date','br.branch_name')
													->get(); 
					$emp_history_designation 		= DB::table('tbl_master_tra')
													->leftJoin('tbl_designation as des', 'des.designation_code', '=', 'tbl_master_tra.designation_code') 
													->where('tbl_master_tra.emp_id',$emp_id)
													 /*  ->where(function($query)
														{
															 
																$query->where('tbl_master_tra.effect_date','!=', '0000-00-00')
																->where('tbl_master_tra.effect_date','!=','1900-01-01');
														})  */
													->groupby('tbl_master_tra.designation_code','tbl_master_tra.effect_date')
													->orderby('tbl_master_tra.letter_date','asc')  
													->select(DB::raw('min(tbl_master_tra.letter_date) as letter_date'),'tbl_master_tra.designation_code',DB::raw('max(des.designation_name) as designation_name'),DB::raw('min(tbl_master_tra.effect_date) as effect_date'),DB::raw('min(tbl_master_tra.br_join_date) as br_join_date'))
													->get();  
				
			/* 	echo '<pre>';
				print_r($emp_history_designation);
				exit; */
				$pre_designation_code = '';	
				//$data['emp_history_designation'] = '';
				
			
				 			
				foreach($emp_history_designation as $v_emp_history_designation){
						if($v_emp_history_designation->designation_code != $pre_designation_code ){
							if(($v_emp_history_designation->effect_date == '0000-00-00' ) || ($v_emp_history_designation->effect_date == '1900-01-01')){
								$data['emp_history_designation'][] = array( 
									'designation_name'      => $v_emp_history_designation->designation_name,
									'effect_date'      => $v_emp_history_designation->br_join_date,
									'letter_date'      => $v_emp_history_designation->letter_date
								);
								
							}else{
								$data['emp_history_designation'][] = array( 
									'designation_name'      => $v_emp_history_designation->designation_name,
									'effect_date'      => $v_emp_history_designation->effect_date,
									'letter_date'      => $v_emp_history_designation->letter_date
								);
							}
						}
					$pre_designation_code = $v_emp_history_designation->designation_code;	
			
				}
				if(!empty($data['emp_history_designation'])){
				$keys = array_column($data['emp_history_designation'], 'effect_date');
				array_multisort($keys, SORT_DESC, $data['emp_history_designation']);
				}
		
								
	/*  echo '<pre>'; 
	  print_r($emp_info);
	exit;  */
	if(!empty($emp_info)){
		if(!empty($assign_emp)){
				 $incharge_as = $assign_emp->incharge_as; 
			 }else{
				 $incharge_as = ''; 
			 } 
			 if(!empty($assign_branch)){
				 $branch_name = $assign_branch->branch_name; 
				 $zone_code = $assign_branch->zone_code; 
				 $br_code = $assign_branch->br_code; 
				 $area_code = $assign_branch->area_code; 
			 }else{
				  $branch_name = $emp_info->branch_name; 
				 $br_code = $emp_info->br_code;
				 $area_code = $emp_info->area_code;
				 $zone_code = $emp_info->zone_code;
			 } 
			 if(!empty($assign_designation)){
				  $designation_name 			= $assign_designation->designation_name; 
				 $designation_code 				= $assign_designation->designation_code;
				 $designation_group_code 		= $assign_designation->designation_group_code;
			 }else{
				  $designation_name 			= $emp_info->designation_name; 
				 $designation_code 				= $emp_info->designation_code;
				 $designation_group_code 		= $emp_info->designation_group_code;
			 }
			 if($emp_id <= 200000){
				 $data['emp_image']			= $emp_info->emp_id.'.'."jpg";
			 }else{
				 $data['emp_image']			= 'hh.jpg';
			 }
		$data['exam_name']			= $exam_name;
		$data['emp_name']			= $emp_info->emp_name;
		$data['c_effect_date']		= $c_effect_date = $emp_info->c_effect_date;
		$data['designation_code']	= $designation_name;
		$data['department_name']	= $department_name;	 
		$data['branch_code']		= $branch_name;	
		$data['br_code']			= $br_code;	
		$data['incharge_as']		= $incharge_as;
		 
		
		$u_branch_code 	= Session::get('branch_code');
		$u_emp_id 		= Session::get('emp_id'); 
		$u_area_code	= Session::get('area_code');
		$u_department_code 	= Session::get('department_code');
		$u_zone_code 	= Session::get('zone_code');
		$form_date = date("Y-m-d");
		$data['is_access'] = 0;
		 
		 
		if($u_user_type == 5){
				if($u_branch_code == $data['br_code']){
					 if(($designation_group_code == 16)||($designation_group_code == 19)){
						 if($designation_code == 226){
							$data['is_access']			= 0; 
						 }else{
							 if(!empty($c_effect_date)){
								 if(date("Y-m-d", strtotime($c_effect_date)) > date("Y-m-d")){
									 $data['is_access']			= 1;
								 }else{
									 $data['is_access']			= 0;
								 }
							 }else{
								 $data['is_access']			= 1;
							 }
							 
						 }
						 
					 }else{
						 $data['is_access']			= 0;
					 } 
				}else{
					$data['is_access']		= 0;
				}
		}else if($u_user_type == 4){
			if($u_area_code == $area_code){ 
				if(($designation_group_code == 16)||($designation_group_code == 12)||($designation_group_code == 19)){
					
					if(!empty($c_effect_date)){
								 if(date("Y-m-d", strtotime($c_effect_date)) > date("Y-m-d")){
										 $data['is_access']			= 1;
									 }else{
										 $data['is_access']			= 0;
									 }
								 }else{
									 $data['is_access']			= 1;
								 } 
				 }else{
					 $data['is_access']			= 0;
				 }  
				}else{
					$data['is_access']		= 0;
				}
		}else if($u_user_type == 3){
			if($u_zone_code == $zone_code){ 
			
				if(($designation_group_code == 16)||($designation_group_code == 12)||($designation_group_code == 11)||($designation_group_code == 19)||($designation_group_code == 18)||($designation_code == 186)||($designation_code == 217)){
					if(!empty($c_effect_date)){
								 if(date("Y-m-d", strtotime($c_effect_date)) > date("Y-m-d")){
										 $data['is_access']			= 1;
									 }else{
										 $data['is_access']			= 0;
									 }
								 }else{
									$data['is_access']			= 1; 
								 } 
				 }else{
					 $data['is_access']			= 0;
				 } 	 
				}else{
					$data['is_access']		= 0;
				}
		}/* else if($u_user_type == 7){
			 
			if($br_code != 9999){
				if(!empty($u_department_code)){
					$desig_array = explode(",",$u_department_code);
					if(in_array($department_code,$desig_array)){
						$data['is_access']			= 1;
					}else{
						$data['is_access']			= 0;
					}
				}else{ 
						$data['is_access']			= 0; 
				} 
			}else{
				if(($u_emp_id == $report_to_new) && ($u_emp_type == $report_to_emp_type)){
					
					$data['is_access']			= 1;
				}else{
					$data['is_access']		= 0;
				}
			} 
			
		} */
		else if($u_user_type == 7 || $u_user_type == 13){
			 //// azad sir , sumon sir 
			 
		 $department_info_head  = DB::table('tbl_emp_mapping as e')
												 ->where('e.emp_id',$u_emp_id)
												 ->where(function($q) use ($form_date) {
													 $q->where('e.start_date','<=', $form_date)->where('e.end_date','>=', $form_date)->orWhere('e.start_date','<=', $form_date)->whereNull('e.end_date')->orwhere('e.end_date','=','0000-00-00');
												 })  
												 ->select('e.emp_id','e.current_department_id') 
												 ->first(); 
			    $department_info_emp  = DB::table('tbl_emp_mapping as e')
												 ->where('e.emp_id',$emp_id)
												 ->where(function($q) use ($form_date) {
													 $q->where('e.start_date','<=', $form_date)->where('e.end_date','>=', $form_date)->orWhere('e.start_date','<=', $form_date)->whereNull('e.end_date')->orwhere('e.end_date','=','0000-00-00');
												 })  
												 ->select('e.emp_id','e.current_department_id') 
												 ->first();  
				
					/* print_r($data['is_access']	); 
				exit; */
				/* print_r($department_info_head );
				print_r($department_info_emp );
				exit; */
				
				if($department_info_emp){
					if($department_info_emp->current_department_id == $department_info_head->current_department_id){
						$data['is_access']			= 1; 
					}else{
						$data['is_access']			= 0; 
					}
				}else{
					if($br_code != 9999 ){
						$data['is_access']			= 1; 
					}else{
						$data['is_access']			= 0; 
					}
					
				} 
			
				if($u_emp_id == $emp_id){
					$data['is_access']			= 0; 
				}
		}else if($u_user_type == 12){
			 /// kadir sir
			 //exit;
			  $department_info_head  = DB::table('tbl_emp_mapping as e')
												 ->where('e.emp_id',$u_emp_id)
												 ->where(function($q) use ($form_date) {
													 $q->where('e.start_date','<=', $form_date)->where('e.end_date','>=', $form_date)->orWhere('e.start_date','<=', $form_date)->whereNull('e.end_date')->orwhere('e.end_date','=','0000-00-00');
												 })  
												 ->select('e.current_program_id') 
												 ->first();
			    $department_info_emp  = DB::table('tbl_emp_mapping as e')
												 ->where('e.emp_id',$emp_id)
												 ->where(function($q) use ($form_date) {
													 $q->where('e.start_date','<=', $form_date)->where('e.end_date','>=', $form_date)->orWhere('e.start_date','<=', $form_date)->whereNull('e.end_date')->orwhere('e.end_date','=','0000-00-00');
												 })  
												 ->select('e.current_program_id') 
												 ->first();  
				/* echo "<pre>";
				print_r($department_info_head);
				echo "<pre>";
				print_r($department_info_emp);
				
				exit; */
				if($department_info_emp){
					if($department_info_emp->current_program_id == $department_info_head->current_program_id){
						$data['is_access']			= 1; 
					}else{
						$data['is_access']			= 0; 
					}
				}else{
					$data['is_access']			= 0; 
				} 
		}else if($u_user_type == 6 || $u_user_type == 1){
			if($admin_access_label == 50){
				 $data['is_access']			= 0; 
				 if($u_emp_id == 613){
					 if($zone_code == 3 || $zone_code == 5 || $zone_code == 9){
						$data['is_access']			= 1;
					}
				 }else if($u_emp_id == 5133){
					 if($zone_code == 1 || $zone_code == 2 || $zone_code == 4){
						$data['is_access']			= 1;
					}
				 }else if($u_emp_id == 3649){
					 if($zone_code == 6 || $zone_code == 7){
						$data['is_access']			= 1;
					}
				 }else if($u_emp_id == 563){
					 if($zone_code == 8 || $zone_code == 10){
						$data['is_access']			= 1;
					}
				 }
				 if($br_code == 9999){  
						$data['is_access']			= 0; 
				}
			}else{
				$data['is_access']			= 0; 
				/* if($br_code != 9999 && $u_user_type == 6){  
						$data['is_access']			= 1; 
				} */
			} 
		
		}else if($u_user_type == 11){
			 
			if($br_code != 9999){  
				if($zone_code == 6 || $zone_code == 7){
					$data['is_access']			= 1;
				}else{
					$data['is_access']			= 0;
				}
					  
			}  
		}else if($u_user_type == 8){
			 
			if($br_code != 9999){ 
				$data['is_access']			= 1; 
			}else{
				$data['is_access']			= 0;
			}
			
		} 
		if($data['is_access'] == 1){
			$data['emp_document_list'] = DB::table('tbl_edms_document as docu')
												->leftJoin('tbl_edms_category as cat', 'docu.category_id', '=', 'cat.category_id')
												->leftJoin('tbl_edms_subcategory as subcat', 'docu.subcat_id', '=', 'subcat.subcat_id')
												->where(function($query) use( $category_id,$u_user_type)
												{
													if(!empty($category_id)){
														$query->where('cat.category_id', $category_id);
													}else{
														if($u_user_type == 7 || $u_user_type == 12){
															$query->where('cat.category_id',23)
															   ->orwhere('cat.category_id',35)
															   ->orwhere('cat.category_id',20)
															   ->orwhere('cat.category_id',11)
															   ->orwhere('cat.category_id',8)
															   ->orwhere('cat.category_id',9)
															   ->orwhere('cat.category_id',17)
															   ->orwhere('cat.category_id',16)
															   ->orwhere('cat.category_id',26); 
														}else if($u_user_type == 11 || $u_user_type == 13){
														
														}else{
															$query->where('cat.category_id',23)
															   ->orwhere('cat.category_id',35)
															   ->orwhere('cat.category_id',20)
															   ->orwhere('cat.category_id',11) 
															   ->orwhere('cat.category_id',8)
															   ->orwhere('cat.category_id',26);
														}
													}
													
												})
												->where(function($query) use( $subcat_id,$u_user_type)
												{
													if(!empty($subcat_id)){
														$query->where('subcat.subcat_id', $subcat_id);
													}else{ 
															if($u_user_type == 7 || $u_user_type == 12){
																$query->whereIn('subcat.for_which',[2,4]);
															}else if($u_user_type == 11 || $u_user_type == 13){
														
															}else{
																$query->whereIn('subcat.for_which',[3,4]);
															} 
													} 
												})
												/* ->where(function($query) use ($user_emp_id)
												{
													if ($user_emp_id != 3015 && $user_emp_id != 3627) {
														$query->where('docu.is_auto_increment','!=',1); 
													}  
												}) */
												->where('docu.is_cancel',0) 
												->where('docu.emp_id',$emp_id) 
												->orderby('docu.effect_date','desc')
												->select('docu.*','cat.category_name','subcat.subcategory_name')
												->get(); 
		}
		
		
	}else{
		$data['exam_name']			= '';
		$data['emp_image']			= 'hh.jpg';
		$data['emp_name']			= '';
		$data['designation_code']	= '';
		$data['branch_code']		= '';
		$data['br_code']			= '';
		$data['c_effect_date']	    = 2;
		$data['department_name']	= ''; 
		$data['incharge_as']		= '';
		$data['is_access']		= 1;
		 
	}
	
	
	
	return view('admin.personal_document.emp_view_record_personal',$data);
   }
    public function selectsubcategory($category_id)
    {  
		$current_date = date('Y-m-d');
		$u_user_type 	= Session::get('user_type'); // 3=dm,4=am,5=bm
	 	$subcategory_list = DB::table('tbl_edms_subcategory')   
									->where(function($query) use($u_user_type,$category_id)
												{  
												  if($u_user_type == 7 || $u_user_type == 12 ){
													  
															$query->where('category_id',$category_id) 
															 ->whereIn('for_which',[2,4]); 
													}else if($u_user_type == 11 || $u_user_type == 13){
														
													}else{
															$query->where('category_id',$category_id)
															->whereIn('for_which',[3,4]);
														}
													 
													
												})
									->where('status',1)
									->orderby('priority','asc')
									->orderby('subcategory_name','asc')
									->get();
		echo "<option value=''>--Select--</option>";
		foreach($subcategory_list as $subcategory){
			echo "<option value='$subcategory->subcat_id'>$subcategory->subcategory_name</option>";
		} 
} 
}
