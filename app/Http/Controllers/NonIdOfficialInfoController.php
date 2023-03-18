<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests; 
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class NonIdOfficialInfoController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	public function index()
    {        	
		$data = array();
		$current_date = date("Y-m-d");
		$data['results'] 	= DB::table('tbl_nonid_official_info') 
							->leftjoin('tbl_emp_non_id', 'tbl_nonid_official_info.emp_id', '=', 'tbl_emp_non_id.emp_id')
							//->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_nonid_official_info.emp_id' )
							->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_nonid_official_info.br_code' )
							->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_nonid_official_info.designation_code' )
							->leftjoin('tbl_emp_type as et',function($join){
										$join->on('et.id', "=","tbl_emp_non_id.emp_type_code"); 
									})
							  ->leftjoin('tbl_emp_non_id_cancel',function($join) use($current_date){
												$join->on("tbl_emp_non_id_cancel.emp_id","=","tbl_nonid_official_info.emp_id")
												->where('tbl_emp_non_id_cancel.cancel_date','<',$current_date); 
														})	
							->where('tbl_emp_non_id.for_which', 1) 
							->whereNull('tbl_nonid_official_info.tran_db_id')
							//->where('tbl_nonid_official_info.sarok_no',0)
							->where('tbl_nonid_official_info.is_first_entry','!=',1)
							->orderBy('tbl_nonid_official_info.id','desc')
							->select('tbl_nonid_official_info.*','tbl_branch.branch_name','tbl_designation.designation_name','tbl_emp_non_id.emp_name','tbl_emp_non_id.emp_name','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.emp_type','tbl_emp_non_id_cancel.cancel_date','et.type_name')  
							->get();
		return view('admin.employee.manage_non_id_official_info',$data);					
    }
	

	public function create()
    {
		/* $action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id); */
		/* echo '<pre>';
		print_r($get_permission);
		exit; */
		/* if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		} */
		$data = array();
		$data['id'] 					= ''; 
		$data['emp_id'] 				= '';  
		$data['br_code'] 				= '';
		$data['salary_br_code'] 		= '';
		$data['emp_name'] 				= '';
		$data['designation_code'] 		= '';
		$data['emp_type'] 				= '';
		$data['sacmo_id'] 				= '';   
		//$data['after_trai_br_code'] 	= '';   
		$data['after_trai_join_date'] 	= '';   
		$data['next_renew_date'] 		= '';   
		$data['end_type'] 				= 0;   
		$data['c_end_date'] 			= '';   
		$data['effect_date'] 			= ''; 
		$data['designation_name']		='';
		$data['joining_date']			= '';
		$data['branch_name']			= '';
		$data['org_code'] 				= '181';
		$data['mode'] 					= '';
		//
		$data['action'] 			= '/con_official_info';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ''; 		
		$data['Heading'] 			= 'Add Non ID Salary';
		$data['button_text'] 		= 'Save'; 
		$data['all_emp_type'] 		= DB::table('tbl_emp_type')->where('id','>',1)->where('status',1)->get();
		$data['designation'] 			= DB::table('tbl_designation')->where('status',1)->orderBy('designation_name','asc')->get();	
		$data['branches'] 		   		= DB::table('tbl_branch')->where('status',1)->orderBy('branch_name','asc')->get();
		return view('admin.employee.non_id_official_info_form',$data);	
    }	 
	public function edit($id)
	{
		/* $action_id = 3;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		} */

		$sdata = array();
		$result = DB::table('tbl_nonid_official_info')
						->leftjoin('tbl_emp_non_id', 'tbl_emp_non_id.emp_id', '=', 'tbl_nonid_official_info.emp_id')	 
						->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_nonid_official_info.br_code' )
						->leftjoin('tbl_branch as atf', 'atf.br_code', '=', 'tbl_nonid_official_info.after_trai_br_code' )
						->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_nonid_official_info.designation_code' )
						->where('tbl_nonid_official_info.id',$id)
						->select('tbl_nonid_official_info.emp_id','tbl_nonid_official_info.end_type','tbl_nonid_official_info.c_end_date','tbl_nonid_official_info.next_renew_date','tbl_nonid_official_info.designation_code','tbl_nonid_official_info.br_code','tbl_nonid_official_info.salary_br_code','tbl_emp_non_id.joining_date','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.emp_name','tbl_emp_non_id.emp_type_code','tbl_designation.designation_name','tbl_branch.branch_name','atf.branch_name as branch_name_af')
						->first(); 
		
		$sdata['emp_id']			= $result->emp_id;
		$sdata['sacmo_id']			= $result->sacmo_id;
		$sdata['emp_type']			= $result->emp_type_code;
		$sdata['emp_name']			= $result->emp_name;
		$sdata['designation_name']	= $result->designation_name;
		$sdata['joining_date']		= $result->joining_date;
		if(!empty($result->branch_name_af)){
			$sdata['branch_name']		= $result->branch_name_af;
		}else{
			$sdata['branch_name']		= $result->branch_name;
		} 
		$sdata['br_code']			= $result->br_code;
		$sdata['salary_br_code']	= $result->salary_br_code;
		$sdata['designation_code']	= $result->designation_code;
		//$sdata['after_trai_join_date']	= $result->after_trai_join_date;
		$sdata['next_renew_date']		= $result->next_renew_date;
		//$sdata['after_trai_br_code']	= $result->after_trai_br_code;
		$sdata['c_end_date']			= $result->c_end_date;
		$sdata['end_type']				= $result->end_type ;
		$sdata['mode']				= 'edit' ;
		 /*  echo '<pre>';
		print_r($sdata);
		exit; */
		// 
		$sdata['action'] 				= "/con_official_info/$id";
		$sdata['method'] 				= 'POST';
		$sdata['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 		
		$sdata['Heading'] 				= 'Edit Employee Non Id';
		$sdata['button_text'] 			= 'Update'; 
		$sdata['all_emp_type'] 			= DB::table('tbl_emp_type')->where('id','>',1)->where('status',1)->get();
		$sdata['designation'] 			= DB::table('tbl_designation')->where('status',1)->orderBy('designation_name','asc')->get();	
		$sdata['branches'] 		   		= DB::table('tbl_branch')->where('status',1)->orderBy('branch_name','asc')->get();
		//
		
		return view('admin.employee.non_id_official_info_form',$sdata);	
	} 
	public function get_nonemployee_official_info($sacmo_id,$emp_type)
	{
		$data = array();
		 
		 $employee_info = DB::table('tbl_emp_non_id') 
							  ->leftjoin('tbl_nonid_official_info',function($join){
												$join->on("tbl_emp_non_id.emp_id","=","tbl_nonid_official_info.emp_id")
												->where('tbl_nonid_official_info.sarok_no',DB::raw("(SELECT 
																				  max(tbl_nonid_official_info.sarok_no)
																				  FROM tbl_nonid_official_info 
																				   where tbl_emp_non_id.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
																				  max(t.joining_date)
																				  FROM tbl_nonid_official_info as t 
																				   where tbl_emp_non_id.emp_id = t.emp_id)
																				  )") 		 
															); 
														})	
							->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_emp_non_id.emp_id' )
							->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_nonid_official_info.br_code' )
							->leftjoin('tbl_branch as ft', 'ft.br_code', '=', 'tbl_nonid_official_info.after_trai_br_code' )
							->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_nonid_official_info.designation_code' )
							->where('tbl_emp_non_id.sacmo_id', $sacmo_id)
							->where('tbl_emp_non_id.emp_type_code', $emp_type)
							->select('tbl_nonid_official_info.br_join_date','tbl_nonid_official_info.designation_code','tbl_nonid_official_info.br_code','tbl_nonid_official_info.after_trai_join_date','tbl_nonid_official_info.after_trai_br_code','tbl_nonid_official_info.salary_br_code','tbl_emp_non_id.emp_id','tbl_emp_non_id.emp_type_code','tbl_emp_non_id.sacmo_id', 'tbl_emp_non_id.emp_name','tbl_emp_non_id.joining_date','tbl_branch.branch_name','ft.branch_name as branch_name_af','tbl_designation.designation_name','tbl_emp_non_id_cancel.cancel_date')
							->first();	
		if(!empty( $employee_info )){
			$data['emp_id'] 				=  $employee_info->emp_id;
			$data['sacmo_id'] 				=  $employee_info->sacmo_id;
			$data['emp_type'] 				=  $employee_info->emp_type_code;
			$data['designation_code'] 		=  $employee_info->designation_code;
			if(!empty($employee_info->after_trai_br_code)){
				$data['br_code'] 				=  $employee_info->after_trai_br_code;
				$data['salary_br_code'] 		=  $employee_info->after_trai_br_code;
				$data['after_trai_join_date'] 		=  $employee_info->after_trai_join_date;
				$data['branch_name'] 			=  $employee_info->branch_name_af;
			}else{
				$data['br_code'] 				=  $employee_info->br_code;
				$data['salary_br_code'] 		=  $employee_info->salary_br_code;
				$data['after_trai_join_date'] 	=  $employee_info->after_trai_join_date;
				$data['branch_name'] 			=  $employee_info->branch_name;
			}
			
			
			$data['joining_date'] 			=  date("d-m-Y",strtotime($employee_info->joining_date));
			$data['br_join_date'] 			=  $employee_info->br_join_date;
			$data['emp_name'] 				=  $employee_info->emp_name; 
			$data['designation_name'] 		=  $employee_info->designation_name;
			$data['cancel_date'] 			=  $employee_info->cancel_date;
			  
		}else{
			$data['emp_id'] 				=  '';
			$data['sacmo_id'] 				=  $sacmo_id;
			$data['emp_type'] 				=  $emp_type;
			$data['joining_date'] 			=  '';
			$data['emp_name'] 				=  '';
			$data['branch_name'] 			=  '';
			$data['designation_name'] 		=  '';
			$data['cancel_date'] 			=  '';
			$data['after_trai_join_date'] 	=  '';
			$data['br_join_date'] 			=  '';
			$data['designation_code'] 		= '';
			$data['br_code'] 				=  '';
			$data['salary_br_code'] 		=  '';
		}
		return $data;
		// echo $emp_type;
	}
	public function get_last_nonid_sarok()
	{
		$result = DB::table('tbl_nonid_official_info') 
				  ->max('sarok_no');
		return $result+1;
	}	
	public function del_nonid_official_info($id)
	{
		DB::table('tbl_nonid_official_info')
				->where('id', $id)
				->delete();
		return Redirect::to('/con_official_info');
	}
	public function store(Request $request)
    { 
		$odata = array();  
		$odata['emp_id']			= $request->emp_id;
		$odata['designation_code']	= $request->designation_code;
		$odata['br_code'] 			= $request->br_code;
		$odata['salary_br_code'] 	= $request->salary_br_code;
		$odata['joining_date'] 		= $request->next_renew_date;
		$odata['br_join_date'] 		= $request->br_join_date;
		$odata['after_trai_join_date'] = $request->after_trai_join_date;
		$odata['next_renew_date'] 	= $request->next_renew_date;
		$odata['sarok_no'] 			= $this->get_last_nonid_sarok();
		
		if(isset($request->end_type)){
			$odata['end_type'] 			= 0;
		}else{
			$odata['end_type'] 			= 1;
			$odata['c_end_date'] 		= $request->c_end_date;
		}
		
		
		//$odata['after_trai_br_code']= $request->after_trai_br_code;
		$odata['org_code'] 			= Session::get('admin_org_code');
		$odata['created_by'] 		= Session::get('admin_id');
		 /* echo '<pre>';
		print_r($data);
		echo '<pre>';
		print_r($odata);
		echo '<pre>';
		print_r($sdata);
		exit;  */ 
		 
		 
		DB::beginTransaction();
		try {	 
			DB::table('tbl_nonid_official_info')->insert($odata);
			DB::commit();
			Session::put('message','Data Saved Successfully');
		}catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		}

		return Redirect::to('/con_official_info');
    } 
	
	public function update(Request $request, $id)
    {	  
		$odata = array(); 
		$odata['designation_code']	= $request->designation_code;
		$odata['br_code']			= $request->br_code;
		$odata['salary_br_code']	= $request->salary_br_code;
		$odata['joining_date']		= $request->next_renew_date;
		//$odata['after_trai_join_date']= $request->after_trai_join_date;
		$odata['next_renew_date']	= $request->next_renew_date;
		//$odata['after_trai_br_code']= $request->after_trai_br_code; 
		if(isset($request->end_type)){
			$odata['c_end_date'] 		=null;		
			$odata['end_type'] 			= 0;
		}else{
			$odata['end_type'] 			= 1;
			$odata['c_end_date'] 		= $request->c_end_date;
		} 
		$odata['created_by'] 		= Session::get('admin_id');
		 
		 
		 /*  echo '<pre>';
		print_r($odata);
		 exit;    */ 
		//Data Update 
		DB::beginTransaction();
		try{
				/* echo '<pre>';
				print_r($odata);
				 exit;   */
			DB::table('tbl_nonid_official_info')
				->where('id', $id)
				->update($odata);
			DB::commit();
			Session::put('message','Data Updated Successfully');
		} catch (\Exception $e) {
			
			Session::put('message','Error: Unable to Updated Data');
			DB::rollback();
		}
		return Redirect::to('/con_official_info');
    }
	
	public function view_nonid_official_info($id)
	{
		/*
		$action_id = 3;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		*/
		 
		$result = DB::table('tbl_nonid_official_info')
						->leftjoin('tbl_emp_non_id', 'tbl_emp_non_id.emp_id', '=', 'tbl_nonid_official_info.emp_id')	 
						->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_nonid_official_info.br_code' )
						->leftjoin('tbl_branch as aft', 'aft.br_code', '=', 'tbl_nonid_official_info.after_trai_br_code' )
						->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_nonid_official_info.designation_code' )
						->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_emp_non_id.emp_id' )
						->leftjoin('tbl_emp_type as et',function($join){
										$join->on('et.id', "=","tbl_emp_non_id.emp_type_code"); 
									})	
						->where('tbl_nonid_official_info.id',$id)
						->select('tbl_nonid_official_info.c_end_date','tbl_nonid_official_info.end_type','tbl_nonid_official_info.next_renew_date','tbl_nonid_official_info.designation_code','tbl_nonid_official_info.br_code','tbl_nonid_official_info.salary_br_code','tbl_nonid_official_info.emp_id','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.joining_date','tbl_emp_non_id.emp_name','tbl_emp_non_id.emp_type','tbl_designation.designation_name','tbl_branch.branch_name','aft.branch_name as branch_name_af','tbl_emp_non_id_cancel.cancel_date','et.type_name')
						->first(); 				
		
		$sdata['emp_id']			= $result->emp_id;
		$sdata['cancel_date']		= $result->cancel_date;
		$sdata['sacmo_id']			= $result->sacmo_id;
		$sdata['type_name']			= $result->type_name;
		$sdata['emp_name']			= $result->emp_name;
		$sdata['designation_name']	= $result->designation_name;
		$sdata['joining_date']		= $result->joining_date;
		$sdata['br_code']			= $result->br_code;
		$sdata['salary_br_code']	= $result->salary_br_code;
		if(!empty($result->branch_name_af)){
			$sdata['branch_name']		= $result->branch_name_af;
		}else{
			$sdata['branch_name']		= $result->branch_name;
		}
		
		$sdata['designation_code']	= $result->designation_code;
		//$sdata['after_trai_join_date']	= $result->after_trai_join_date;
		$sdata['next_renew_date']		= $result->next_renew_date;
		//$sdata['after_trai_br_code']	= $result->after_trai_br_code;
		$sdata['c_end_date']			= $result->c_end_date;
		$sdata['end_type']				= $result->end_type ;
		/* echo '<pre>';
		print_r($sdata);
		 exit;  */ 
		$sdata['action'] 				= "/con_official_info/$id";
		$sdata['method'] 				= 'POST';
		$sdata['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 		
		$sdata['Heading'] 				= 'Edit Employee Non Id';
		$sdata['button_text'] 			= 'Update'; 
		//
		$data['all_emp_type'] 		= DB::table('tbl_emp_type')->where('id','>',1)->where('status',1)->get();
		$sdata['designation'] 			= DB::table('tbl_designation')->where('status',1)->orderBy('designation_name','asc')->get();	
		$sdata['branches'] 		   		= DB::table('tbl_branch')->where('status',1)->orderBy('branch_name','asc')->get();
		return view('admin.employee.non_id_form_official_info_view',$sdata);	
	} 
	public function get_nonid_official_info($emp_id)
	{
		$results = DB::table('tbl_nonid_official_info')  
						->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_nonid_official_info.br_code' )
						->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_nonid_official_info.designation_code' )
						->where('tbl_nonid_official_info.emp_id',$emp_id) 
						->orderBy('tbl_nonid_official_info.joining_date', 'desc')
						->select('tbl_nonid_official_info.joining_date','tbl_designation.designation_name','tbl_branch.branch_name')
						->get();

		echo '<tr>';
		echo "<th>Sl</th>";
		echo "<th>Designation</th>";
		echo "<th>Branch</th>";
		echo "<th>Duration</th>";
		echo "<th>Joining Date</th>";
		echo '</tr>';
		$i = 1; 
		$next_day = date("Y-m-d");
		$to_date = date("Y-m-d");
		foreach($results as $result){
			$show_joining = date('d-m-Y',strtotime($result->joining_date));
			if($i == 1)
			{
				$date_upto = $to_date;
			}
			else
			{
				$date_upto = $next_day;
			}
			$big_date=date_create($date_upto);
			$small_date=date_create($result->joining_date);
			$diff=date_diff($big_date,$small_date);
			echo '<tr>';
			echo "<td>$i</td>";
			echo "<td>$result->designation_name</td>";
			echo "<td>$result->branch_name</td>";
			echo "<td style='color:blue;'>";
			printf($diff->format('%y Year %m Month %d Day' ));
			echo "</td>";
			echo "<td>$show_joining</td>";
			echo '</tr>';
			$next_day = $result->joining_date;
			$i++;
		}		
		
	}
}
