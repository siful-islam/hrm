<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Middleware\Checkuser;
use DB;
use Session;
class RequisitiondairycalenderOrgController extends Controller
{

	 public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	public function requisition_can_dairy_org()
    {
        $data = array();
		$branch_code 			= Session::get('branch_code');
		//$branch_code 			= 1;
		$data['emp_list'] = DB::table('tbl_requisition')  
									 ->leftJoin('tbl_designation as d', 'tbl_requisition.designation_code', '=', 'd.designation_code')  
									 ->leftJoin('tbl_designation_group as dg', 'dg.desig_group_code', '=', 'd.designation_group_code')  
									->where('tbl_requisition.status',2) 
									->groupBy('dg.desig_group_code') 
									->select('dg.desig_group_name','dg.desig_group_code',DB::raw('SUM(tbl_requisition.org_num_dairy) as org_num_dairy'),DB::raw('SUM(tbl_requisition.org_num_calender) as org_num_calender'))
									->get(); 
		/* echo '<pre>';
		print_r($data['emp_list']);
		exit;  */
		return view('admin.requisition.manage_requisition_org',$data);
    }
	public function requisition_create_org()
    {
		$data = array();
		$data['desig_group_code'] = '';
		 
		$branch_code 			= Session::get('branch_code');
		$data['all_designation_group'] = DB::table('tbl_designation_group') 
										->select('*') 
										->get();
		 
		 
		return view('admin.requisition.requisition_org_form',$data);
    } 
	public function requisition_search_emp_info(Request $request)
    {
		$data = array();
		$form_date 		= date("Y-m-d");
		$branch_code 			= Session::get('branch_code');
		$data['desig_group_code'] 	= $desig_group_code = $request->input('desig_group_code');
		$data['all_designation_group'] = DB::table('tbl_designation_group') 
								->select('*') 
								->get();
		 
		$all_designation = DB::table('tbl_designation') 
									->where('designation_group_code',$desig_group_code)
									->select('*') 
									->get();
		
			if (!empty($all_designation)) {
				foreach($all_designation as $v_all_designation){
					$designation_code 	= $v_all_designation->designation_code;
					 $all_result = DB::table('tbl_master_tra as m')
							->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
							//->where('m.designation_code', '=', $designation_code)
							->where(function($query) use ($designation_code, $form_date) {
									if($designation_code !='all') {
										$query->where('m.br_join_date', '<=', $form_date);
										$query->where('m.designation_code', '=', $designation_code);
									} else {
										$query->where('m.effect_date', '<=', $form_date);
									}
								})
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
									->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
									->leftJoin('tbl_emp_assign as ea', function($join){
												//$join->where('ea.status', 1)
												$join->whereBetween('ea.status',array(1,2))
													->on('m.emp_id', '=', 'ea.emp_id');
											})
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->select('e.emp_name_eng','m.emp_id','m.grade_code','m.designation_code','d.designation_name','d.designation_code','b.branch_name','b.br_code')
									->first();
					 
					 
					
					//// employee assign ////
					$assign_designation = DB::table('tbl_emp_assign as ea')
											->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
											->where('ea.emp_id', $result->emp_id)
											->where('ea.status', '!=', 0)
											->where('ea.select_type', '=', 5)
											->select('ea.emp_id','ea.open_date','de.designation_name','de.designation_code')
											->first();
					if(!empty($assign_designation)) {
						$designation_code1 = $assign_designation->designation_code;
						$designation_name1 = $assign_designation->designation_name;
						 
					} else {
						$designation_name1 = $data_result->designation_name;
						$designation_code1 = $data_result->designation_code;
						 
					}
						if ($data_result->designation_code == $designation_code) {	
							$data['all_result'][] = array(
								'emp_id' => $data_result->emp_id, 
								'emp_name'      => $data_result->emp_name_eng,
								'designation_name'      => $designation_name1,
								'designation_code'      => $designation_code1,
								'branch_name'      => $data_result->branch_name,
								'branch_code'      => $data_result->br_code, 
								 
							);
						}			
				  }
			   }  
			   $designation_code 	= $v_all_designation->designation_code;
				  
				}
				
				
				
				
			}
		
		
		
		
		/* echo "<pre>";
		print_r($data['all_result']);
		exit;    */
		return view('admin.requisition.requisition_org_form',$data);
    } 
	public function requisition_update_org($desig_group_code)
    {
		$data = array(); 
		$data['desig_group_code'] 		= $desig_group_code;
		$branch_code 			= Session::get('branch_code');
		 
		$data['all_result'] = DB::table('tbl_requisition')  
									->leftJoin("tbl_emp_basic_info as emp",function($join){
											$join->on("emp.emp_id","=","tbl_requisition.emp_id");
									}) 
									 ->leftJoin('tbl_designation as d', 'tbl_requisition.designation_code', '=', 'd.designation_code') 
									  ->leftJoin('tbl_designation_group as dg', 'dg.desig_group_code', '=', 'd.designation_group_code')  
									->where('dg.desig_group_code',$desig_group_code) 
									->select('tbl_requisition.*','emp.emp_name_eng as emp_name','d.designation_name')
									->get();
		
		 
		return view('admin.requisition.requisition_org_update_form',$data);
    } 
	public function insert_dairy_calender_org(Request $request)
    {
		$data 					= array();
		$data1 					= array(); 
		$data['user_code']		= Session::get('admin_id'); 
		$data1['updated_at']	= date("Y-m-d"); 
		$data1['status']		= 2; 
		$data['status']		= 2; 
		 
		
		$tot_row 				= $request->tot_row; 
		 
		/* echo '<pre>';
		print_r($all_emp_id);
		exit; */ 
	 
			for($i = 1; $i < $tot_row; $i++ ){  
				$data['emp_id'] 			= $emp_id   =  $request->emp_id[$i];    
				$data['org_num_dairy'] 					=  $request->org_num_dairy[$i];  
				$data['org_num_calender'] 				=  $request->org_num_calender[$i];  
				$data['designation_code'] 				=  $request->designation_code[$i];  
				$data['branch_code'] 					=  $request->branch_code[$i];  
				
				
				$emp_info_diary = DB::table('tbl_requisition') 
									->where('emp_id', $emp_id)
									->select('org_num_dairy','org_num_calender','emp_id')
									->first();
				if(!empty($emp_info_diary)){
					$data1['org_num_dairy'] = $emp_info_diary->org_num_dairy + $data['org_num_dairy']; 
					$data1['org_num_calender'] = $emp_info_diary->org_num_calender + $data['org_num_calender']; 
					
					DB::table('tbl_requisition') 
						->where('emp_id', $emp_id)
						->update($data1);
				}else{
					DB::table('tbl_requisition') 
					->insert($data); 
				} 
				  	
			}
	 
		//exit;
		return Redirect::to('/requisition_can_dairy_org'); 
    }
	public function update_dairy_calender_org(Request $request)
    {
		$data 				= array();
		$data['user_code']	= Session::get('admin_id'); 
		$data['updated_at']	=date("Y-m-d");  
		$tot_row 		= $request->tot_row;
		$data['status']		= 2;
		/* echo '<pre>';
		print_r($all_emp_id);
		exit; */ 
	 
			for($i = 1; $i < $tot_row; $i++ ){  
				$emp_id 			=  $request->emp_id[$i];  
				$data['org_num_dairy'] 			=  $request->org_num_dairy[$i];  
				$data['org_num_calender'] 		=  $request->org_num_calender[$i]; 
				DB::table('tbl_requisition') 
					->where('emp_id', '=', $emp_id)
					->update($data);   	
			}
	 
		//exit;
		return Redirect::to('/requisition_can_dairy_org'); 
    } 
}
