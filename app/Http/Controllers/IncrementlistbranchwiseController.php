<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Middleware\Checkuser;
use DB;
use Session;
class IncrementlistbranchwiseController extends Controller
{

	 public function __construct() 
	{
		$this->middleware("CheckUserSession");
	} 
	
	
	
	
	public function get_br_employee()
	{
		/*$staffs = DB::table('pay_sheets as p')
						->leftJoin('tbl_emp_basic_info as b', 'p.emp_id', '=', 'b.emp_id') 
								->where('p.staff_type', '=', 1)
								->orderBy('p.ordering', 'ASC')
								->select('p.*', 'b.org_join_date')
								->get();
								
								
								
		foreach($staffs as $staff)
		{
			$emp_id = $staff->emp_id;
			
			$i_info = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
						->where('emp_id', '=', $emp_id)
						->where('is_auto_increment', '=', 1)
						->select('m.basic_salary', 'd.designation_name')
						->first();
			
			
			if($i_info)
			{
				$emp_basic 			= $i_info->basic_salary;
				$emp_designation    = $i_info->designation_name;
				$is_increent    	= 1;
			}else{
				$emp_basic 			= $staff->regular_basic;
				$emp_designation    = $staff->designation_name; 
				$is_increent    	= 0;
			}
			
			
			$p_info = DB::table('tbl_master_tra as m')
						->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
						->where('emp_id', '=', $emp_id)
						->where('is_auto_increment', '=', 4)
						->select('m.basic_salary', 'd.designation_name')
						->first();
			if($p_info)
			{
				$emp_basic 			= $p_info->basic_salary;
				$emp_designation    = $p_info->designation_name;
				$is_promotion    	= 1;
			}else{
				$emp_basic 			= $staff->regular_basic;
				$emp_designation    = $staff->designation_name; 
				$is_promotion    	= 0;
			}
			
			$data[] = array(
							'emp_id' 				=> $staff->emp_id,
							'emp_name'      		=> $staff->emp_name,
							'emp_designation'     	=> $emp_designation,
							'org_join_date'     	=> $staff->org_join_date,
							'emp_basic'  			=> $emp_basic,
							'is_increent'      		=> $is_increent,
							'is_promotion'      	=> $is_promotion
						);
			

		}	

		$data['infos']  = $data;	
		
		*/
		
		$data['infos']  = DB::table('finance_data')  
					->get(); 
					
		//echo '<pre>';
		//print_r($data['infos']);
						
		return view('admin.auto_increment.fin_incre_promotion_report',$data);
		
		//echo '<pre>';
		//print_r($data);
		//exit;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function bra_increment_list()
    {
        $data = array(); 
		 $data['Heading'] = "Branch Increment List";  
		$branch_code 	  = Session::get('branch_code');
		$form_date  = date("Y-m-d");  
			$all_result = DB::table('tbl_master_tra as m')
									->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
									->where('m.br_code', '=', $branch_code)
									->where('m.br_join_date', '<=', $form_date)
									->where(function($query) use ($form_date) { 
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date); 
										})
									
									->select('m.emp_id')
									->groupBy('m.emp_id')
									->get()->toArray();
						
						$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										->where('eas.br_code', '=', $branch_code)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($form_date) { 
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date); 
										})									
										->select('eas.emp_id')
										->get()->toArray();
						$select_employee = array_unique(array_merge($all_result,$assign_branch), SORT_REGULAR);
						
						foreach($select_employee as $employee){ 
						
								$emp_id1 = $employee->emp_id; 
								$max_sarok = DB::table('tbl_master_tra as m')
											->where('m.emp_id', '=', $emp_id1)
											->where('m.br_join_date', '=', function($query) use ($emp_id1,$form_date)
													{
														$query->select(DB::raw('max(br_join_date)'))
															  ->from('tbl_master_tra')
															  ->where('emp_id',$emp_id1)
															  ->where('br_join_date', '<=', $form_date);
													})
											->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
											->groupBy('emp_id')
											->first();	
								if(!empty($max_sarok)){			
									$employee_info  = DB::table('tbl_master_tra as m')  
													->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
													->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
													->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')  
													->where('m.sarok_no', '=', $max_sarok->sarok_no)
													->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','d.designation_group_code','b.branch_name','b.br_code','emp.org_join_date as joining_date','emp.emp_type as type_name')
													->first();  
									if($branch_code == $employee_info->br_code){
										$select_employee_info  = DB::table('tbl_edms_document as edm')
																 ->where('edm.is_auto_increment',1)  
																 ->where('edm.emp_id',$emp_id1) 
																 ->where('edm.effect_date','2021-07-01')  
																 ->select('edm.document_name') 
																 ->first();
											if(!empty($select_employee_info)){
												$data['all_report'][] = array(
														'emp_id_u' 				=> $employee_info->emp_id,
														'branch_code' 			=> $employee_info->br_code,
														'designation_group_code'=> $employee_info->designation_group_code,
														'emp_id' 				=> $employee->emp_id, 
														'type_name' 			=> "Regular",
														'document_name' 		=> $select_employee_info->document_name, 
														'designation_name' 		=> $employee_info->designation_name,
														'branch_name' 			=> $employee_info->branch_name,
														'emp_name' 				=> $employee_info->emp_name
													);    
											}
											
									}
								}
			 }
		 
		/* $employee_info_non  = DB::table('tbl_emp_non_id as nid')  
											->leftjoin('tbl_nonid_official_info as noi',function($join){
												$join->on("nid.emp_id","=","noi.emp_id") 
														->where('noi.sarok_no',DB::raw("(SELECT 
																								  max(tbl_nonid_official_info.sarok_no)
																								  FROM tbl_nonid_official_info 
																								   where nid.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
																								  max(t.joining_date)
																								  FROM tbl_nonid_official_info as t 
																								   where nid.emp_id = t.emp_id)
																								  )") 		 
																			); 		
														})  
										 ->leftJoin('tbl_designation as d', 'noi.designation_code', '=', 'd.designation_code') 
										 ->leftJoin('tbl_branch as b', 'noi.br_code', '=', 'b.br_code') 
										 ->leftJoin('tbl_emp_non_id_cancel as nc', 'nid.emp_id', '=', 'nc.emp_id')
										 ->leftjoin('tbl_emp_type as et',function($join){
												$join->on('et.id', "=","nid.emp_type_code"); 
											})	
											
										->where('noi.br_code', '=', $branch_code)
										->Where('noi.joining_date', '<=', $form_date)
										->Where(function($query) use ($form_date) {
												$query->whereNull('nc.emp_id');
												$query->orWhere('nc.cancel_date', '>', $form_date);								
											}) 
										 ->select('nid.emp_id as emp_id_u','nid.sacmo_id as emp_id','nid.emp_type_code as emp_type','nid.emp_name','noi.joining_date','b.br_code','d.designation_code','b.branch_name','d.designation_name','et.type_name')
										 ->get(); 
								
									if(!empty($employee_info_non)){ 
										 foreach($employee_info_non as $v_employee_info_non){
											 
										 
											if($v_employee_info_non->br_code == $branch_code ){ 
												 
											$select_non_employee_info  = DB::table('tbl_edms_document as edm')
																 ->where('edm.is_auto_increment',1)  
																 ->where('edm.emp_id',$v_employee_info_non->emp_id) 
																 ->where('edm.emp_type',$v_employee_info_non->emp_type) 
																 ->select('edm.document_name') 
																 ->first();
											if(!empty($select_non_employee_info)){
												$data['all_report'][] = array( 
														'branch_code' 			=> $v_employee_info_non->br_code,
														'emp_id' 				=> $v_employee_info_non->emp_id, 
														'type_name' 			=> $v_employee_info_non->type_name,
														'document_name' 		=> $select_non_employee_info->document_name, 
														'designation_name' 		=> $v_employee_info_non->designation_name,
														'branch_name' 			=> $v_employee_info_non->branch_name,
														'emp_name' 				=> $v_employee_info_non->emp_name
													);    
											}
											 
											
											}
											
										}		 
													 
									}  */
		/*  echo '<pre>'; 
		print_r($data['getleaveinfowithoutpay']);
		exit;  */ 
		return view('admin.reports.branch_increment_list_report',$data);
    }
	public function bra_increment_list2(Request $request)
    {

		$data = array(); 
		$data['Heading'] = "Branch Increment List";  
		$data['all_branches'] 	= DB::table('tbl_branch')->where('status',1)->get();
		
		
		$branch_code = $request->input('search_branch');
		
		if($branch_code)
		{
			$form_date  = date("Y-m-d");  
			$all_result = DB::table('tbl_master_tra as m')
									->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
									->where('m.br_code', '=', $branch_code)
									->where('m.br_join_date', '<=', $form_date)
									->where(function($query) use ($form_date) { 
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date); 
										})
									
									->select('m.emp_id')
									->groupBy('m.emp_id')
									->get()->toArray();
						
						$assign_branch = DB::table('tbl_emp_assign as eas')
										->leftJoin('tbl_resignation as r', 'eas.emp_id', '=', 'r.emp_id')
										->where('eas.br_code', '=', $branch_code)
										->where('eas.status', '!=', 0)
										->where('eas.select_type', '=', 2)	
										->where(function($query) use ($form_date) { 
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date); 
										})									
										->select('eas.emp_id')
										->get()->toArray();
						$select_employee = array_unique(array_merge($all_result,$assign_branch), SORT_REGULAR);
						
						foreach($select_employee as $employee){ 
						
								$emp_id1 = $employee->emp_id; 
								$max_sarok = DB::table('tbl_master_tra as m')
											->where('m.emp_id', '=', $emp_id1)
											->where('m.br_join_date', '=', function($query) use ($emp_id1,$form_date)
													{
														$query->select(DB::raw('max(br_join_date)'))
															  ->from('tbl_master_tra')
															  ->where('emp_id',$emp_id1)
															  ->where('br_join_date', '<=', $form_date);
													})
											->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
											->groupBy('emp_id')
											->first();	
								if(!empty($max_sarok)){			
									$employee_info  = DB::table('tbl_master_tra as m')  
													->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
													->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
													->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')  
													->where('m.sarok_no', '=', $max_sarok->sarok_no)
													->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','d.designation_group_code','b.branch_name','b.br_code','emp.org_join_date as joining_date','emp.emp_type as type_name')
													->first();  
									if($branch_code == $employee_info->br_code){
										$select_employee_info  = DB::table('tbl_edms_document as edm')
																 ->where('edm.is_auto_increment',1)  
																 ->where('edm.emp_id',$emp_id1)  
																 ->where('edm.effect_date','2021-07-01')  
																 ->select('edm.document_name') 
																 ->first();
											if(!empty($select_employee_info)){
												$data['all_report'][] = array(
														'emp_id_u' 				=> $employee_info->emp_id,
														'branch_code' 			=> $employee_info->br_code,
														'designation_group_code'=> $employee_info->designation_group_code,
														'emp_id' 				=> $employee->emp_id, 
														'type_name' 			=> "Regular",
														'document_name' 		=> $select_employee_info->document_name, 
														'designation_name' 		=> $employee_info->designation_name,
														'branch_name' 			=> $employee_info->branch_name,
														'emp_name' 				=> $employee_info->emp_name
													);    
											}
											
									}
								}
			 }
	/* 	 
		$employee_info_non  = DB::table('tbl_emp_non_id as nid')  
											->leftjoin('tbl_nonid_official_info as noi',function($join){
												$join->on("nid.emp_id","=","noi.emp_id") 
														->where('noi.sarok_no',DB::raw("(SELECT 
																								  max(tbl_nonid_official_info.sarok_no)
																								  FROM tbl_nonid_official_info 
																								   where nid.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
																								  max(t.joining_date)
																								  FROM tbl_nonid_official_info as t 
																								   where nid.emp_id = t.emp_id)
																								  )") 		 
																			); 		
														})  
										 ->leftJoin('tbl_designation as d', 'noi.designation_code', '=', 'd.designation_code') 
										 ->leftJoin('tbl_branch as b', 'noi.br_code', '=', 'b.br_code') 
										 ->leftJoin('tbl_emp_non_id_cancel as nc', 'nid.emp_id', '=', 'nc.emp_id')
										 ->leftjoin('tbl_emp_type as et',function($join){
												$join->on('et.id', "=","nid.emp_type_code"); 
											})	
											
										->where('noi.br_code', '=', $branch_code)
										->Where('noi.joining_date', '<=', $form_date)
										->Where(function($query) use ($form_date) {
												$query->whereNull('nc.emp_id');
												$query->orWhere('nc.cancel_date', '>', $form_date);								
											}) 
										 ->select('nid.emp_id as emp_id_u','nid.sacmo_id as emp_id','nid.emp_type_code as emp_type','nid.emp_name','noi.joining_date','b.br_code','d.designation_code','b.branch_name','d.designation_name','et.type_name')
										 ->get(); 
								
									if(!empty($employee_info_non)){ 
										 foreach($employee_info_non as $v_employee_info_non){
											 
										 
											if($v_employee_info_non->br_code == $branch_code ){ 
												 
											$select_non_employee_info  = DB::table('tbl_edms_document as edm')
																 ->where('edm.is_auto_increment',1)  
																 ->where('edm.emp_id',$v_employee_info_non->emp_id) 
																 ->where('edm.emp_type',$v_employee_info_non->emp_type) 
																 ->select('edm.document_name') 
																 ->first();
											if(!empty($select_non_employee_info)){
												$data['all_report'][] = array( 
														'branch_code' 			=> $v_employee_info_non->br_code,
														'emp_id' 				=> $v_employee_info_non->emp_id, 
														'type_name' 			=> $v_employee_info_non->type_name,
														'document_name' 		=> $select_non_employee_info->document_name, 
														'designation_name' 		=> $v_employee_info_non->designation_name,
														'branch_name' 			=> $v_employee_info_non->branch_name,
														'emp_name' 				=> $v_employee_info_non->emp_name
													);    
											}
											 
											
											}
											
										}		 
													 
									}  */
									
		$data['search_branch']  = $request->input('search_branch');
		}
		else{
			$data['all_report'] 	= array();
			$data['search_branch']  = '';
		}
		return view('admin.auto_increment.increment_br_wise',$data);
    }
	 
}
