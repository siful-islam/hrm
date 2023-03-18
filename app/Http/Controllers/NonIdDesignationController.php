<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests; 
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class NonidDesignationController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	public function index()
    {        	
		$data = array();
		$current_date = date("Y-m-d");
		$data['results'] 	= DB::table('tbl_nonid_designation') 
							->leftjoin('tbl_emp_non_id', 'tbl_nonid_designation.emp_id', '=', 'tbl_emp_non_id.emp_id')
							->leftjoin('tbl_nonid_official_info', 'tbl_nonid_designation.sarok_no', '=', 'tbl_nonid_official_info.sarok_no')
							->leftjoin('tbl_branch', 'tbl_nonid_official_info.br_code', '=', 'tbl_branch.br_code')
							->leftjoin('tbl_designation as p', 'tbl_nonid_designation.pre_designation', '=', 'p.designation_code')
							->leftjoin('tbl_designation as c', 'tbl_nonid_designation.current_designation', '=', 'c.designation_code') 
							->leftjoin('tbl_emp_non_id_cancel',function($join) use($current_date){
												$join->on("tbl_emp_non_id_cancel.emp_id","=","tbl_nonid_designation.emp_id")
												->where('tbl_emp_non_id_cancel.cancel_date','<',$current_date); 
														})	
							->leftjoin('tbl_emp_type as et',function($join){
										$join->on('et.id', "=","tbl_emp_non_id.emp_type_code"); 
									})
							->where('tbl_emp_non_id.for_which', 1) 		
							->select('tbl_nonid_designation.id','tbl_nonid_designation.sarok_no','tbl_nonid_designation.effect_date','tbl_branch.branch_name','p.designation_name as pre_designation_name','c.designation_name as c_designation_name','tbl_emp_non_id.emp_name','tbl_emp_non_id.emp_name','tbl_emp_non_id.sacmo_id','tbl_emp_non_id_cancel.cancel_date','et.type_name') 
							->orderBy('tbl_nonid_designation.id','desc')
							->get();
		/* echo '<pre>';
		print_r($data['results']);
		exit; */
		return view('admin.employee.manage_non_id_designation',$data);					
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
		$data['branch_code'] 				= '';
		$data['pre_designation'] 		= '';
		$data['current_designation'] 		= '';
		$data['emp_name'] 				= ''; 
		$data['emp_type'] 				= '';
		$data['sacmo_id'] 				= '';   
		$data['comments'] 				= ''; 
		$data['effect_date'] 			= ''; 
		$data['designation_name']		='';
		$data['joining_date']			= '';
		$data['branch_name']			= '';
		$data['org_code'] 				= '181';
		$data['designation_code'] 		= '';
		$data['sarok_no'] 				= ''; 
		$data['end_type'] 				= 0; 
		$data['c_end_date'] 			= '';
		$data['next_renew_date'] 			= '';
		$data['br_join_date'] 			= '';
		//
		$data['all_emp_type'] 		= DB::table('tbl_emp_type')->where('id','>',1)->where('status',1)->get();
		$data['designations'] 		= DB::table('tbl_designation')->where('status',1)->orderBy('designation_name','asc')->get();
		$data['action'] 			= '/con_designation';
		$data['method'] 			= 'POST';
		$data['mode'] 				= '';
		$data['method_control'] 	= ''; 		
		$data['Heading'] 			= 'Add Non ID transfer';
		$data['button_text'] 		= 'Save'; 
		return view('admin.employee.non_id_designation_form',$data);	
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
		$result =  DB::table('tbl_nonid_designation') 
							->leftjoin('tbl_emp_non_id', 'tbl_nonid_designation.emp_id', '=', 'tbl_emp_non_id.emp_id')
						    ->leftjoin('tbl_nonid_official_info', 'tbl_nonid_designation.sarok_no', '=', 'tbl_nonid_official_info.sarok_no')
							->leftjoin('tbl_branch', 'tbl_nonid_official_info.br_code', '=', 'tbl_branch.br_code')
							->leftjoin('tbl_designation as p', 'tbl_nonid_designation.pre_designation', '=', 'p.designation_code')
							//->leftjoin('tbl_designation as c', 'tbl_nonid_designation.current_designation', '=', 'c.designation_code')
							->select('tbl_nonid_designation.*','tbl_branch.branch_name','tbl_emp_non_id.emp_name','tbl_emp_non_id.emp_name','tbl_emp_non_id.sacmo_id','p.designation_name','tbl_emp_non_id.emp_type_code','tbl_emp_non_id.joining_date','tbl_nonid_official_info.br_code','tbl_nonid_official_info.end_type','tbl_nonid_official_info.c_end_date','tbl_nonid_official_info.next_renew_date','tbl_nonid_official_info.br_join_date') 
							->where('tbl_nonid_designation.id',$id)
							->first();
		$sdata['emp_id']				= $result->emp_id; 
		$sdata['sacmo_id']				= $result->sacmo_id;
		$sdata['emp_type']				= $result->emp_type_code;
		$sdata['emp_name']				= $result->emp_name;
		$sdata['designation_name']		= $result->designation_name;
		$sdata['pre_designation']		= $result->pre_designation;
		$sdata['current_designation']	= $result->current_designation;
		$sdata['sarok_no']				= $result->sarok_no;
		$sdata['joining_date']			= $result->joining_date;
		 
		
		$sdata['effect_date']			= $result->effect_date; 
		$sdata['comments']				= $result->comments;  
		$sdata['branch_code']			= $result->br_code; 
		$sdata['br_join_date']			= $result->br_join_date;
		$sdata['branch_name']			= $result->branch_name;
		$sdata['end_type']				= $result->end_type;
		$sdata['c_end_date']			= $result->c_end_date;
		$sdata['next_renew_date']		= $result->next_renew_date;
		
		$sdata['action'] 				= "/con_designation/$id";
		$sdata['method'] 				= 'POST';
		$sdata['mode'] 					= 'readonly';
		$sdata['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 		
		$sdata['Heading'] 				= 'Edit Transfer Non Id';
		$sdata['button_text'] 			= 'Update'; 
		$sdata['all_emp_type'] 		= DB::table('tbl_emp_type')->where('id','>',1)->where('status',1)->get();
		$sdata['designations'] 		= DB::table('tbl_designation')->where('status',1)->orderBy('designation_name','asc')->get();
		//
		return view('admin.employee.non_id_designation_form',$sdata);	
	} 
	public function store(Request $request)
    { 
		$data = array();  
		$odata = array();  
		$data['emp_id']					= $request->emp_id;
		$data['effect_date']			= $request->effect_date;
		$data['pre_designation']		= $request->pre_designation; 
		$data['current_designation']	= $request->current_designation;
		$data['comments']				= $request->comments; 
		$data['org_code'] 				= Session::get('admin_org_code');
		$data['created_by'] 			= Session::get('admin_id');
		/// official info 
		$odata['emp_id']				= $request->emp_id; 	
		$odata['designation_code']	    = $request->current_designation;
		$odata['br_code']	   			= $request->branch_code;
		$odata['salary_br_code']		= $request->branch_code;
		$odata['joining_date']			= $request->effect_date;
		$odata['end_type']				= $request->end_type; 
		if($request->end_type == 1){
			$odata['c_end_date']		= $request->c_end_date;
			$odata['next_renew_date']	= $request->next_renew_date;
		} 
		$odata['br_join_date']  		= $request->br_join_date;
		$odata['created_by']			= Session::get('admin_id'); 
		$odata['org_code'] 				= Session::get('admin_org_code');
		 
		$non_sarok_no 				= $this->get_last_nonid_sarok();  
		$data['sarok_no'] 			= $non_sarok_no;  
		$odata['sarok_no'] 			= $non_sarok_no;  
		 
		/* echo '<pre>';
		print_r($data);
		echo '<pre>';
		print_r($odata);
		exit;  */
		 
		DB::beginTransaction();
		try {	 
			DB::table('tbl_nonid_designation')->insertGetId($data);
			DB::table('tbl_nonid_official_info')->insert($odata);
			DB::commit();
			Session::put('message','Data Saved Successfully');
		}catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		}
		 
		return Redirect::to('/con_designation');
    } 
	public function get_last_nonid_sarok()
	{
		$result = DB::table('tbl_nonid_official_info') 
				  ->max('sarok_no');
		return $result+1;
	}	
	public function update(Request $request, $id)
    {	  
		$sdata = array(); 
		$odata = array(); 
		$emp_id 						= $request->emp_id; 
		$sarok_no 						= $request->sarok_no; 
		$sdata['effect_date']			= $request->effect_date;
		$sdata['comments']				= $request->comments;  
		$sdata['pre_designation']		= $request->pre_designation;
		$sdata['current_designation']	= $request->current_designation;
		$sdata['updated_by'] 			= Session::get('admin_id'); 
		$odata['designation_code']		= $request->current_designation; 
		$odata['br_code']				= $request->branch_code; 
		$odata['salary_br_code']		= $request->branch_code; 
		$odata['joining_date']			= $request->effect_date;
		$odata['updated_at']			= date("Y-m-d");
		$odata['updated_by']			= Session::get('admin_id'); 
		 
		/* echo '<pre>';
		print_r($id);echo '<pre>';
		print_r($odata);
		echo '<pre>';
		print_r($sdata);
		 exit;  */
		//Data Update 
		DB::beginTransaction();
		try{
				/* echo '<pre>';
				print_r($sdata);
				 exit;   */
			DB::table('tbl_nonid_designation')
				->where('id', $id)
				->update($sdata);
			DB::table('tbl_nonid_official_info')
				->where('sarok_no', $sarok_no)
				->update($odata);
			DB::commit();
			Session::put('message','Data Updated Successfully');
		} catch (\Exception $e) {
			
			Session::put('message','Error: Unable to Updated Data');
			DB::rollback();
		}
		return Redirect::to('/con_designation');
    }
	
	public function view_nonid_designation($id)
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
		
		$data['results'] 	= DB::table('tbl_nonid_designation') 
							->leftjoin('tbl_emp_non_id', 'tbl_nonid_designation.emp_id', '=', 'tbl_emp_non_id.emp_id')
							->leftjoin('tbl_nonid_official_info', 'tbl_nonid_designation.sarok_no', '=', 'tbl_nonid_official_info.sarok_no')
							->leftjoin('tbl_branch', 'tbl_nonid_official_info.br_code', '=', 'tbl_branch.br_code')
							->leftjoin('tbl_designation as p', 'tbl_nonid_designation.pre_designation', '=', 'p.designation_code')
							->leftjoin('tbl_designation as c', 'tbl_nonid_designation.current_designation', '=', 'c.designation_code')
							->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_nonid_designation.emp_id' )
							->leftjoin('tbl_emp_type as et',function($join){
										$join->on('et.id', "=","tbl_emp_non_id.emp_type_code"); 
									})
							->select('tbl_nonid_designation.id','tbl_nonid_designation.sarok_no','tbl_nonid_designation.effect_date','tbl_branch.branch_name','p.designation_name as pre_designation_name','c.designation_name as c_designation_name','tbl_emp_non_id.emp_name','tbl_emp_non_id.emp_name','tbl_emp_non_id.sacmo_id','tbl_emp_non_id_cancel.cancel_date','et.type_name') 
							->orderBy('tbl_nonid_designation.id','desc')
							->get();
		
		$result =  DB::table('tbl_nonid_designation') 
							->leftjoin('tbl_emp_non_id', 'tbl_nonid_designation.emp_id', '=', 'tbl_emp_non_id.emp_id') 
							->leftjoin('tbl_nonid_official_info', 'tbl_nonid_official_info.sarok_no', '=', 'tbl_nonid_designation.sarok_no')
							->leftjoin('tbl_branch', 'tbl_nonid_official_info.br_code', '=', 'tbl_branch.br_code')
							->leftjoin('tbl_designation as p', 'tbl_nonid_designation.pre_designation', '=', 'p.designation_code')
							->leftjoin('tbl_designation as c', 'tbl_nonid_designation.current_designation', '=', 'c.designation_code')
							->leftjoin('tbl_designation', 'tbl_nonid_official_info.designation_code', '=', 'tbl_designation.designation_code')
							->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_emp_non_id.emp_id' )
							->leftjoin('tbl_emp_type as et',function($join){
										$join->on('et.id', "=","tbl_emp_non_id.emp_type_code"); 
									})	
							->select('tbl_nonid_designation.*','tbl_branch.branch_name','p.designation_name as pre_designation_name','c.designation_name as c_designation_name','tbl_emp_non_id.emp_name','tbl_emp_non_id.sacmo_id','tbl_designation.designation_name','tbl_emp_non_id.joining_date','tbl_emp_non_id_cancel.cancel_date','tbl_nonid_official_info.salary_br_code','et.type_name') 
							->where('tbl_nonid_designation.id',$id)
							->first();
		$sdata['emp_id']				= $result->emp_id;
		$sdata['cancel_date']			= $result->cancel_date;
		$sdata['sacmo_id']				= $result->sacmo_id;
		$sdata['type_name']				= $result->type_name;
		$sdata['emp_name']				= $result->emp_name;
		$sdata['designation_name']		= $result->designation_name;
		$sdata['joining_date']			= $result->joining_date; 
		$sdata['branch_name']			= $result->branch_name;
		$sdata['pre_designation_name']	= $result->pre_designation_name;
		$sdata['c_designation_name']	= $result->c_designation_name;
		  
		$sdata['effect_date']			= $result->effect_date; 
		$sdata['comments']				= $result->comments; 
		 
		//
		return view('admin.employee.non_id_designation_view',$sdata);	
	} 
	public function get_nonemployee_designation($sacmo_id,$emp_type)
	{
		$data = array();
		  
		 $employee_info = DB::table('tbl_emp_non_id')  
							 ->leftjoin('tbl_nonid_official_info',function($join){
												$join->on("tbl_nonid_official_info.emp_id","=","tbl_emp_non_id.emp_id")
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
							->leftjoin('tbl_branch as br_o', 'br_o.br_code', '=', 'tbl_nonid_official_info.br_code' )
							->leftjoin('tbl_branch as br_t', 'br_t.br_code', '=', 'tbl_nonid_official_info.after_trai_br_code' )
							->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_nonid_official_info.designation_code' )
							->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_emp_non_id.emp_id' )
							->where('tbl_emp_non_id.sacmo_id', $sacmo_id)
							->where('tbl_emp_non_id.emp_type_code', $emp_type)
							->select('tbl_emp_non_id.emp_id','tbl_emp_non_id.emp_type_code','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.joining_date','tbl_emp_non_id.emp_name','br_o.branch_name','br_t.branch_name as branch_name_af','tbl_designation.designation_name','tbl_nonid_official_info.br_code','tbl_nonid_official_info.designation_code','tbl_nonid_official_info.after_trai_join_date','tbl_nonid_official_info.after_trai_br_code','tbl_nonid_official_info.next_renew_date','tbl_nonid_official_info.end_type','tbl_nonid_official_info.c_end_date','tbl_nonid_official_info.salary_br_code','tbl_nonid_official_info.br_join_date','tbl_emp_non_id_cancel.cancel_date')
							->first();
		
		if(!empty( $employee_info )){
			$data['emp_id'] 				=  $employee_info->emp_id;
			$data['sacmo_id'] 				=  $employee_info->sacmo_id;
			$data['emp_type'] 				=  $employee_info->emp_type_code;
			$data['joining_date'] 			=  date("d-m-Y",strtotime($employee_info->joining_date));
			$data['emp_name'] 				=  $employee_info->emp_name;
			 if(!empty($employee_info->after_trai_br_code)){
				$data['branch_name'] 			=  $employee_info->branch_name_af;
				$data['branch_code'] 			=  $employee_info->after_trai_br_code; 
			}else{
				$data['branch_name'] 			=  $employee_info->branch_name;
				$data['branch_code'] 			=  $employee_info->br_code; 
			} 
			
			$data['designation_name'] 		=  $employee_info->designation_name;
			$data['cancel_date'] 			=  $employee_info->cancel_date;
			$data['salary_br_code'] 		=  $employee_info->salary_br_code;
			$data['designation_code'] 		=  $employee_info->designation_code;
			$data['after_trai_join_date'] 	=  $employee_info->after_trai_join_date;
			$data['after_trai_br_code'] 	=  $employee_info->after_trai_br_code;
			$data['next_renew_date'] 		=  $employee_info->next_renew_date;
			$data['end_type'] 				=  $employee_info->end_type;
			$data['c_end_date'] 			=  $employee_info->c_end_date;
			$data['br_join_date'] 			=  $employee_info->br_join_date;
			  
		}else{
			$data['emp_id'] 				=  '';
			$data['branch_code'] 			=  '';
			$data['sacmo_id'] 				=  $sacmo_id;
			$data['emp_type'] 				=  $emp_type;
			$data['joining_date'] 			=  '';
			$data['emp_name'] 				=  '';
			$data['branch_name'] 			=  '';
			$data['designation_name'] 		=  '';
			$data['cancel_date'] 			=  '';
			$data['salary_br_code'] 		=  '';
			$data['designation_code'] 		=  '';
			$data['after_trai_join_date'] 	=  '';
			$data['after_trai_br_code'] 	=  '';
			$data['next_renew_date'] 		=  '';
			$data['end_type'] 				=  0;
			$data['c_end_date'] 			=  '';
			$data['br_join_date'] 			=  '';
		}
		
	/* 	echo '<pre>';
		print_r($data);
		exit; */
		
		
		return $data;
		// echo $emp_type;
	}
	public function get_nonid_designation_info($emp_id)
	{
		$results = DB::table('tbl_nonid_designation')
						->join('tbl_designation as p', 'p.designation_code', '=', 'tbl_nonid_designation.pre_designation') 
						->join('tbl_designation as c', 'c.designation_code', '=', 'tbl_nonid_designation.current_designation') 
						->where('tbl_nonid_designation.emp_id',$emp_id) 
						->orderBy('tbl_nonid_designation.effect_date', 'desc')
						->select('tbl_nonid_designation.id','tbl_nonid_designation.effect_date','p.designation_name as pre_designation_name','c.designation_name as current_designation_name')
						->get();

		echo '<tr>';
		echo "<th>Sl</th>";
		echo "<th>Present designation</th>";
		echo "<th>New Designation</th>";
		echo "<th>Duration</th>";
		echo "<th>Effect Date</th>";
		echo '</tr>';
		$i = 1; 
		$next_day = date("Y-m-d");
		$to_date = date("Y-m-d");
		foreach($results as $result){
			$show_effect = date("d-m-Y",strtotime($result->effect_date));
			if($i == 1)
			{
				$date_upto = $to_date;
			}
			else
			{
				$date_upto = $next_day;
			}
			$big_date=date_create($date_upto);
			$small_date=date_create($result->effect_date);
			$diff=date_diff($big_date,$small_date);
			echo '<tr>';
			echo "<td>$i</td>";
			echo "<td>$result->pre_designation_name</td>";
			echo "<td>$result->current_designation_name</td>";
			echo "<td style='color:blue;'>";
			printf($diff->format('%y Year %m Month %d Day' ));
			echo "</td>";
			echo "<td>$show_effect</td>";
			echo '</tr>';
			$next_day = $result->effect_date;
			$i++;
		}		
		
	}
	public function del_nonid_designation($id,$sarok_no)
	{
		DB::table('tbl_nonid_designation')
				->where('id', $id)
				->delete();
		DB::table('tbl_nonid_official_info')
				->where('sarok_no', $sarok_no)
				->delete();
		return Redirect::to('/con_designation');
	}
}
