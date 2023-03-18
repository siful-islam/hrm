<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Middleware\Checkuser;
use DB;
use Session;
class RequisitiondairycalenderController extends Controller
{

	 public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	public function requisition_can_dairy()
    {
        $data = array();
		$branch_code 			= Session::get('branch_code');
		//$branch_code 			= 1;
		$data['emp_list'] = DB::table('tbl_requisition') 
									->leftJoin("tbl_emp_basic_info as emp",function($join){
											$join->on("emp.emp_id","=","tbl_requisition.emp_id");
									})
									 ->leftJoin('tbl_branch as b', 'tbl_requisition.branch_code', '=', 'b.br_code') 
									 ->leftJoin('tbl_designation as d', 'tbl_requisition.designation_code', '=', 'd.designation_code') 
									->where('tbl_requisition.branch_code',$branch_code) 
									->select('tbl_requisition.*','emp.emp_name_eng as emp_name','b.branch_name','d.designation_name')
									->get();
		
		$tot_value = count($data['emp_list']);
		$data['tot_value'] =$tot_value;
		/* echo '<pre>';
		print_r($tot_value );
		exit;  */
		return view('admin.requisition.manage_requisition',$data);
    }
	public function requisition_create()
    {
		$data = array();
		$form_date 		= date("Y-m-d");
		$branch_code 			= Session::get('branch_code');
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
		/* echo "<pre>";
		print_r($all_result);
		exit; */
		////////////////
		$assign_branch = DB::table('tbl_emp_assign')
										->where('br_code', '=', $branch_code)
										->where('status', '!=', 0)
										->where('select_type', '=', 2)
										->select('emp_id')
										->get()->toArray();
		//print_r ($assign_branch);
		//$all_result1 = array_merge($all_result,$assign_branch);
		$all_result1 = array_unique(array_merge($all_result,$assign_branch), SORT_REGULAR);
		//print_r ($all_result1);
		////////////////
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
				$data_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
							->leftJoin('tbl_emp_assign as ea', function($join){
											$join->where('ea.status',1)
												->on('m.emp_id', '=', 'ea.emp_id');
										})
							->where('m.sarok_no', '=', $max_sarok->sarok_no)
							->select('e.emp_name_eng','e.org_join_date','e.permanent_add','m.br_join_date','m.br_code','m.designation_code','d.designation_name','b.branch_name','ea.incharge_as')
							->first();
				//print_r ($data_result);
				//// employee assign ////
				$assign_designation = DB::table('tbl_emp_assign as ea')
											->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
											->where('ea.emp_id', $result->emp_id)
											->where('ea.status', '!=', 0)
											->where('ea.select_type', '=', 5)
											->select('ea.emp_id','ea.open_date','de.designation_name','de.designation_code')
											->first();
				if(!empty($assign_designation)) {
					$asign_desig = $assign_designation->designation_name;
					$desig_open_date = $assign_designation->open_date;
					$designation_code = $assign_designation->designation_code;
				} else {
					$asign_desig = '';
					$desig_open_date =  '';
					$designation_code = $data_result->designation_code;
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
				if ($result_br_code == $branch_code) {	
					$data['all_result'][] = array(
						'emp_id' => $result->emp_id,
						'emp_name'      => $data_result->emp_name_eng,
						'org_join_date'      => $data_result->org_join_date,
						'br_join_date'      => date('d M Y',strtotime($data_result->br_join_date)),
						'designation_code'      => $designation_code,
						'designation_name'      => $data_result->designation_name,
						'branch_name'      => $data_result->branch_name,
						'assign_designation'      => $asign_desig,
						'asign_branch_name'      => $asign_branch_name,
						'incharge_as'      => $data_result->incharge_as
					);
				}				
			}  
		} 
		return view('admin.requisition.requisition_form',$data);
    } 
	public function requisition_update()
    {
		$data = array();
		$form_date 		= date("Y-m-d");
		$branch_code 			= Session::get('branch_code');
		
		
		
		$data['emp_list'] = DB::table('tbl_requisition') 
									->leftJoin("tbl_emp_basic_info as emp",function($join){
											$join->on("emp.emp_id","=","tbl_requisition.emp_id");
									})
									 ->leftJoin('tbl_branch as b', 'tbl_requisition.branch_code', '=', 'b.br_code') 
									 ->leftJoin('tbl_designation as d', 'tbl_requisition.designation_code', '=', 'd.designation_code') 
									->where('tbl_requisition.branch_code',$branch_code) 
									->select('tbl_requisition.*','emp.emp_name_eng as emp_name','b.branch_name','d.designation_name')
									->get();
		
		 
		return view('admin.requisition.requisition_form_update',$data);
    } 
	public function insert_dairy_calender(Request $request)
    {
		$data 				= array();
		$data1 				= array();
		$data['branch_code']	= Session::get('branch_code'); 
		$data['user_code']	= Session::get('admin_id'); 
		$year_id 			= 2;
		$tot_row 		= $request->tot_row; 
		 
		/* echo '<pre>';
		print_r($all_emp_id);
		exit; */ 
	 
			for($i = 1; $i < $tot_row; $i++ ){  
				$data['emp_id'] 			=  $request->emp_id[$i];    
				$data['num_dairy'] 			=  $request->num_dairy[$i];  
				$data['num_calender'] 		=  $request->num_calender[$i];  
				$data['designation_code'] 	=  $request->designation_code[$i];  
				 
				 
				DB::table('tbl_requisition') 
					->insert($data);   	
			}
	 
		//exit;
		return Redirect::to('/requisition_can_dairy'); 
    }
	public function update_dairy_calender(Request $request)
    {
		$data 				= array();
		$data1 				= array(); 
		$data['user_code']	= Session::get('admin_id'); 
		$data['updated_at']	=date("Y-m-d"); 
		$year_id 			= 2;
		$tot_row 		= $request->tot_row; 
		 
		/* echo '<pre>';
		print_r($all_emp_id);
		exit; */ 
	 
			for($i = 1; $i < $tot_row; $i++ ){  
				$emp_id 			=  $request->emp_id[$i];   
				$data['num_dairy'] 			=  $request->num_dairy[$i];  
				$data['num_calender'] 		=  $request->num_calender[$i]; 
				DB::table('tbl_requisition') 
					->where('emp_id', '=', $emp_id)
					->update($data);   	
			}
	 
		//exit;
		return Redirect::to('/requisition_can_dairy'); 
    }
	public function rpt_dairy_calender()
    {
		$data = array();
		
		$data['all_result'] 	= '';
		$data['br_code']		= '';	
		$data['form_date']		= date('Y-m-d');	
		//$data['status']			= '';
		$data['all_branch'] 	= '';
		$data['area_code'] 		= '';
		$data['branches'] 		= DB::table('tbl_branch')->where('status',1)->orderBy('branch_name', 'ASC')->get();
		$data['areas'] 			= DB::table('tbl_area')->where('status',1)->get();
		return view('admin.requisition.requisition_report',$data);
		 
		
    } 
	public function rpt_dairy_calender_post(Request $request)
    {
		$data = array();
		
		$form_date 		= date("Y-m-d"); 
		$data['br_code'] 		= $br_code = $request->input('br_code');
		$data['area_code'] 		= $area_code = $request->input('area_code');
		$data['branches'] 		= DB::table('tbl_branch')->where('status',1)->orderBy('branch_name', 'ASC')->get();
		$data['areas'] 			= DB::table('tbl_area')->where('status',1)->get();
		$data['area_name'] 		= DB::table('tbl_area')->where('area_code',$area_code)->first();
		
		/*  echo '<pre>';
		print_r($area_code);
		exit;
	 */
	 if(($area_code == 'all') || ($area_code == 'all_a')){
		 $emp_list = DB::table('tbl_requisition') 
					->select('tbl_requisition.*')
					->get();
			foreach($emp_list as $v_emp_list){
			
			 $emp_id = $v_emp_list->emp_id;
			$branch_code = $v_emp_list->branch_code;
			$org_num_dairy = $v_emp_list->org_num_dairy;
			$num_dairy = $v_emp_list->num_dairy;
			$num_calender = $v_emp_list->num_calender;
			$org_num_calender = $v_emp_list->org_num_calender;
			 
					$all_result = DB::table('tbl_master_tra as m')
											->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
											->where('m.emp_id', '=', $emp_id)
											->where('m.br_join_date', '<=', $form_date)
											->where(function($query) use ($form_date) {
													
														$query->whereNull('r.emp_id');
														$query->orWhere('r.effect_date', '>', $form_date);
													
												})
											
											->select('m.emp_id')
											->groupBy('m.emp_id')
											->first(); 
			 if (!empty($all_result)) {
					$max_sarok = DB::table('tbl_master_tra as m')
														->where('m.emp_id', '=', $all_result->emp_id)
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
				 
							
			/*  echo '<pre>';
			print_r($max_sarok);
			exit;   */
				 if(!empty($max_sarok)){
					 
					 $data_result = DB::table('tbl_master_tra as m')
								->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
								->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
								->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
								->leftJoin('tbl_area as ar', 'b.area_code', '=', 'ar.area_code')
								 
								->where('m.sarok_no', '=', $max_sarok->sarok_no)
								->select('m.br_code','b.branch_name','e.emp_name_eng as emp_name','d.designation_name','ar.area_code')
								->first();
					 
					 $assign_branch = DB::table('tbl_emp_assign as ea')
												->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code') 
												->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
												->where('ea.emp_id', $emp_id)
												->where('ea.open_date', '<=', $form_date)
												->where('ea.status', '!=', 0)
												->where('ea.select_type', '=', 2)
												->select('ea.br_code','br.branch_name','ar.area_code')
												->first();
					if(!empty($assign_branch)) { 
						$data['all_result'][] = array( 
							'emp_name'      	=> $data_result->emp_name,    
							'emp_id'      		=> $max_sarok->emp_id,    
							'type_name'      	=> 'Regular',    
							'designation_name' 	=> $data_result->designation_name,    
							'branch_code'      	=> $assign_branch->br_code,    
							'branch_name'      	=> $assign_branch->branch_name,    
							'area_code'      	=> $assign_branch->area_code,    
							'org_num_dairy'     => $org_num_dairy,    
							'num_dairy'      	=> $num_dairy,    
							'org_num_calender'  => $org_num_calender,    
							'num_calender'      => $num_calender    
						); 
					} else {
						$data['all_result'][] = array( 
							'emp_name'      	=> $data_result->emp_name,
							'emp_id'      		=> $max_sarok->emp_id,
							'type_name'      	=> 'Regular',
							'designation_name' 	=> $data_result->designation_name,						
							'area_code'      	=> $data_result->area_code,    
							'branch_code'      	=> $data_result->br_code,    
							'branch_name'      	=> $data_result->branch_name,    
							'num_dairy'      	=> $num_dairy,    
							'org_num_dairy'     => $org_num_dairy,    
							'num_calender'      => $num_calender,    
							'org_num_calender'  => $org_num_calender,    
						); 
					}
					
					}
				}
					
			 
			
			
			
		}  
		 
			$keys = array_column($data['all_result'], 'branch_code');
			array_multisort($keys, SORT_ASC, $data['all_result']); 

		}else{
		 $data['all_branch'] = $all_branch = DB::table('tbl_branch')
												->where('area_code', '=', $data['area_code'])
												->orderBy('branch_name', 'asc')
												->select('br_code','branch_name')
												->get();
			/* echo '<pre>';
		print_r($data['all_branch']);  */
					//exit; 
			 if(!empty($br_code)){
					$all_result = DB::table('tbl_master_tra as m')
								->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
								->where('m.br_code', '=', $data['br_code'])
								->where('m.br_join_date', '<=', $form_date)
								->whereNull('r.emp_id')
								->orWhere('r.effect_date', '>', $form_date)
								->select('m.emp_id')
								->groupBy('m.emp_id')
								->get(); 
				
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
													->groupBy('emp_id')
													->first();
						$emp_info = DB::table('tbl_master_tra as m') 
									->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id')  
									->leftjoin('tbl_requisition as dl',function($join){
												$join->on("m.emp_id","=","dl.emp_id");
														})	
									->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
									->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
									->leftJoin('tbl_area as ar', 'b.area_code', '=', 'ar.area_code')
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->select('emp.emp_id','dl.emp_id as emp_id1','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','dl.num_calender','dl.org_num_calender','dl.num_dairy','dl.org_num_dairy','ar.area_code')
									->first(); 
						 if(!empty($emp_info->emp_id1)){
							 if($emp_info->br_code == $data['br_code']) {
								$data['all_result'][] = array( 
									'emp_id' 			 => $result->emp_id,
									'type_name' 		 => 'Regular',
									'emp_name'       	 => $emp_info->emp_name, 
									'org_num_dairy'   		 => $emp_info->org_num_dairy,
									'num_dairy'   		 => $emp_info->num_dairy,
									'org_num_calender'       => $emp_info->org_num_calender,
									'num_calender'       => $emp_info->num_calender,
									'designation_name'   => $emp_info->designation_name,
									'area_code'  		 => $emp_info->area_code,
									'branch_code'  			 => $emp_info->br_code,
									'branch_name'        => $emp_info->branch_name 
								);  
							 } 
						 }
						
					
					}
					/* echo '<pre>';
		print_r($data['all_result']); 
				exit;
					 */				 
						} 
							  
									if(!empty($data['all_result'])){
										$keys = array_column($data['all_result'], 'branch_code');
									array_multisort($keys, SORT_ASC, $data['all_result']);
									}		
				}else{
					foreach($all_branch as $branch){
						
							$all_result = DB::table('tbl_master_tra as m')
											->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
											->where('m.br_code', '=', $branch->br_code)
											->where('m.br_join_date', '<=', $form_date)
											->where(function($query) use ($form_date) {
													
														$query->whereNull('r.emp_id');
														$query->orWhere('r.effect_date', '>', $form_date);
													
												})
											
											->select('m.emp_id')
											->groupBy('m.emp_id')
											->get()->toArray(); 
						
								/* $all_result = DB::table('tbl_master_tra as m')
												->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
												->where('m.br_code', '=', $branch->br_code)
												->where('m.br_join_date', '<=', $form_date)
												->whereNull('r.emp_id')
												->orWhere('r.effect_date', '>', $form_date)
												->select('m.emp_id')
												->groupBy('m.emp_id')
												->get()->toArray(); */
								$assign_branch = DB::table('tbl_emp_assign')
												->where('br_code', '=', $branch->br_code)
												->where('status', '!=', 0)
												->where('select_type', '=', 2)
												->select('emp_id')
												->get()->toArray();
								$all_result1 = array_unique(array_merge($all_result,$assign_branch), SORT_REGULAR);
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
										
										if(!empty($max_sarok)){		 
										
										$emp_info = DB::table('tbl_master_tra as m') 
															->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id') 
															->leftjoin('tbl_requisition as dl',function($join){
																$join->on("m.emp_id","=","dl.emp_id"); 
																		})	
															->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
															->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
															->leftJoin('tbl_area as ar', 'b.area_code', '=', 'ar.area_code')
															->where('m.sarok_no', '=', $max_sarok->sarok_no) 
															->select('emp.emp_id','dl.emp_id as emp_id1','dl.num_dairy','dl.org_num_dairy','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','dl.num_calender','dl.org_num_calender','ar.area_code')
															->first(); 
													/* echo '<pre>';
													print_r($emp_info); */
												 if(!empty($emp_info->emp_id1)){
													 if($emp_info->br_code == $branch->br_code) {
														 $data['all_result'][] = array( 
																			'emp_id' 			 	=> $result->emp_id,
																			'type_name' 			=> 'Regular',
																			'emp_name'       	 	=> $emp_info->emp_name, 
																			'org_num_dairy'   			=> $emp_info->org_num_dairy,
																			'num_dairy'   			=> $emp_info->num_dairy,
																			'num_calender'    		=> $emp_info->num_calender,
																			'org_num_calender'    		=> $emp_info->org_num_calender,
																			'designation_name'   	=> $emp_info->designation_name,
																			'branch_code'        	=> $emp_info->br_code, 
																			'area_code'        	 	=> $emp_info->area_code, 
																			'branch_name'        	=> $emp_info->branch_name 
																		);  
													  

														
														}
													
													}
												}		
											}
												
													//exit;  
										}
										
								//echo '<pre>';
						//print_r($data['all_result']);
									}
									if(!empty($data['all_result'])){
										$keys = array_column($data['all_result'], 'branch_code');
									array_multisort($keys, SORT_ASC, $data['all_result']);
									}
									
						}
		 
	 } 
	//exit;
		return view('admin.requisition.requisition_report',$data);
		 
		
    }
	public function rpt_dairy_calender_ind()
    {
		$data = array();
		
		$data['all_result'] 	= '';
		$data['br_code']		= '';	
		$data['form_date']		= date('Y-m-d');	
		//$data['status']			= '';
		$data['all_branch'] 	= '';
		$data['emp_id'] 		= ''; 
		return view('admin.requisition.requisition_report_individual',$data);
		 
		
    } 
	public function rpt_dairy_calender_ind_post(Request $request)
    {
		$data = array();
		
		$form_date 		= date("Y-m-d"); 
		$data['emp_id'] 		= $emp_id = $request->input('emp_id');
		/*  echo '<pre>';
		print_r($area_code);
		exit;
	 */
		 $emp_diarry_calender = DB::table('tbl_requisition')  
								->where('emp_id',$emp_id)
								->select('*')
								->first();
		if($emp_diarry_calender){
							$org_num_dairy      = $emp_diarry_calender->org_num_dairy;   
							$num_dairy      	= $emp_diarry_calender->num_dairy;    
							$num_calender      	= $emp_diarry_calender->num_calender;    
							$org_num_calender   = $emp_diarry_calender->org_num_calender;   
		}else{
							$org_num_dairy      = 0;   
							$num_dairy      	= 0;    
							$num_calender      	= 0;    
							$org_num_calender   = 0; 
		}
		 
			
					$all_result = DB::table('tbl_master_tra as m')
											->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
											->where('m.emp_id', '=', $emp_id)
											->where('m.br_join_date', '<=', $form_date)
											 ->where(function($query) use ($form_date) {
													
														//$query->whereNull('r.emp_id');
														//$query->orWhere('r.effect_date', '>', $form_date);
													
												}) 
											
											->select('m.emp_id')
											->groupBy('m.emp_id')
											->first(); 
			
			/* echo '<pre>';
			print_r($all_result);
			exit;  */ 
			if (!empty($all_result)) {
					$max_sarok = DB::table('tbl_master_tra as m')
									->where('m.emp_id', '=', $all_result->emp_id)
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
				 
							
			/*  echo '<pre>';
			print_r($max_sarok);
			exit;   */
				 if(!empty($max_sarok)){
					 
					 $data_result = DB::table('tbl_master_tra as m')
								->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
								->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
								->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
								->leftJoin('tbl_area as ar', 'b.area_code', '=', 'ar.area_code')
								 
								->where('m.sarok_no', '=', $max_sarok->sarok_no)
								->select('m.br_code','b.branch_name','e.emp_name_eng as emp_name','d.designation_name','ar.area_code')
								->first();
					 
					 $assign_branch = DB::table('tbl_emp_assign as ea')
												->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code') 
												->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
												->where('ea.emp_id', $emp_id)
												->where('ea.open_date', '<=', $form_date)
												->where('ea.status', '!=', 0)
												->where('ea.select_type', '=', 2)
												->select('ea.br_code','br.branch_name','ar.area_code')
												->first();
					if(!empty($assign_branch)) { 
						$data['all_result'] = array( 
							'emp_name'      	=> $data_result->emp_name,    
							'emp_id'      		=> $max_sarok->emp_id,
							'designation_name' 	=> $data_result->designation_name,    
							'branch_code'      	=> $assign_branch->br_code,    
							'branch_name'      	=> $assign_branch->branch_name,    
							'area_code'      	=> $assign_branch->area_code,    
							'org_num_dairy'     => $org_num_dairy,    
							'num_dairy'      	=> $num_dairy,    
							'org_num_calender'  => $org_num_calender,    
							'num_calender'      => $num_calender    
						); 
					} else {
						$data['all_result'] = array( 
							'emp_name'      	=> $data_result->emp_name,
							'emp_id'      		=> $max_sarok->emp_id,
							'designation_name' 	=> $data_result->designation_name,						
							'area_code'      	=> $data_result->area_code,    
							'branch_code'      	=> $data_result->br_code,    
							'branch_name'      	=> $data_result->branch_name,    
							'num_dairy'      	=> $num_dairy,    
							'org_num_dairy'     => $org_num_dairy,    
							'num_calender'      => $num_calender,    
							'org_num_calender'  => $org_num_calender,    
						); 
					}
					
					}
				}
					
			
			
			
	/* echo '<pre>';
	print_r($data['all_result']);	
	exit; */
		return view('admin.requisition.requisition_report_individual',$data);
		 
		
    }
}
