<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests; 
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class NonIdTransferController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	public function index()
    {        	
		$data = array();
		$current_date = date("Y-m-d");
		$data['results'] 	= DB::table('tbl_nonid_transfer') 
							->leftjoin('tbl_emp_non_id', 'tbl_nonid_transfer.emp_id', '=', 'tbl_emp_non_id.emp_id')
							->leftjoin('tbl_branch as f', 'tbl_nonid_transfer.from_branch_code', '=', 'f.br_code')
							->leftjoin('tbl_branch as t', 'tbl_nonid_transfer.to_branch_code', '=', 't.br_code') 
							 ->leftjoin('tbl_emp_non_id_cancel',function($join) use($current_date){
												$join->on("tbl_emp_non_id_cancel.emp_id","=","tbl_nonid_transfer.emp_id")
												->where('tbl_emp_non_id_cancel.cancel_date','<',$current_date); 
														})	
							->leftjoin('tbl_emp_type as et',function($join){
										$join->on('et.id', "=","tbl_emp_non_id.emp_type_code"); 
									})
							->where('tbl_emp_non_id.for_which', 1) 
							->select('tbl_nonid_transfer.id','tbl_nonid_transfer.effect_date','f.branch_name as from_branch_name','t.branch_name as to_branch_name','tbl_emp_non_id.emp_name','tbl_emp_non_id.emp_name','tbl_emp_non_id.sacmo_id','tbl_emp_non_id_cancel.cancel_date','et.type_name') 
							->orderBy('tbl_nonid_transfer.id','desc')
							->get();
		return view('admin.employee.manage_non_id_transfer',$data);					
    }
	public function get_last_nonid_sarok()
	{
		$result = DB::table('tbl_nonid_official_info') 
				  ->max('sarok_no');
		return $result+1;
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
		$data['salary_br_code'] 		= '';
		$data['br_code'] 				= '';
		$data['from_branch_code'] 		= '';
		$data['to_branch_code'] 		= '';
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
		$data['after_trai_join_date'] 	= '';
		$data['after_trai_br_code'] 	= '';
		$data['next_renew_date'] 		= '';
		$data['end_type'] 				= 0;
		$data['tran_db_id'] 			= '';
		$data['c_end_date'] 			= '';
		$data['br_join_date'] 			= '';
		//
		$data['all_emp_type'] 		= DB::table('tbl_emp_type')->where('id','>',1)->where('status',1)->get();
		$data['branches'] 		    = DB::table('tbl_branch')->where('status',1)->orderBy('branch_name','asc')->get();
		$data['action'] 			= '/con_transfer';
		$data['method'] 			= 'POST';
		$data['mode'] 				= '';
		$data['method_control'] 	= ''; 		
		$data['Heading'] 			= 'Add Non ID transfer';
		$data['button_text'] 		= 'Save'; 
		return view('admin.employee.non_id_transfer_form',$data);	
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
		$result =  DB::table('tbl_nonid_transfer') 
							->leftjoin('tbl_emp_non_id', 'tbl_nonid_transfer.emp_id', '=', 'tbl_emp_non_id.emp_id')
							->leftjoin('tbl_branch as f', 'tbl_nonid_transfer.from_branch_code', '=', 'f.br_code')
							->leftjoin('tbl_nonid_official_info', 'tbl_nonid_official_info.tran_db_id', '=', 'tbl_nonid_transfer.id')
							->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_nonid_official_info.designation_code' )
							->leftjoin('tbl_branch as t', 'tbl_nonid_official_info.after_trai_br_code', '=', 't.br_code')
							->select('tbl_nonid_transfer.*','f.branch_name','tbl_emp_non_id.emp_name','tbl_emp_non_id.emp_name','tbl_emp_non_id.sacmo_id','tbl_designation.designation_name','tbl_emp_non_id.emp_type_code','tbl_emp_non_id.joining_date','tbl_nonid_official_info.tran_db_id','tbl_nonid_official_info.salary_br_code','tbl_nonid_official_info.br_join_date','t.branch_name as branch_name_af') 
							->where('tbl_nonid_transfer.id',$id)
							->first();
		$sdata['emp_id']				= $result->emp_id;
		$sdata['tran_db_id']			= $result->tran_db_id; 
		$sdata['sacmo_id']				= $result->sacmo_id;
		$sdata['emp_type']				= $result->emp_type_code;
		$sdata['emp_name']				= $result->emp_name;
		$sdata['designation_name']		= $result->designation_name;
		$sdata['joining_date']			= $result->joining_date;
		
		$sdata['effect_date']			= $result->effect_date; 
		$sdata['comments']				= $result->comments; 
		$sdata['from_branch_code']		= $result->from_branch_code; 
		$sdata['salary_br_code']		= $result->salary_br_code;  
		$sdata['to_branch_code']		= $result->to_branch_code; 
		$sdata['br_join_date']			= $result->br_join_date;
		if(!empty($result->branch_name_af)){
			$sdata['branch_name']			= $result->branch_name_af;
		}else{
			$sdata['branch_name']			= $result->branch_name;
		}
		$sdata['after_trai_join_date']	= '';
		$sdata['after_trai_br_code']	= '';
		$sdata['next_renew_date']		= '';
		$sdata['end_type']				= 0;
		$sdata['designation_code']		= '';
		$sdata['c_end_date']			= '';
		
		$sdata['action'] 				= "/con_transfer/$id";
		$sdata['method'] 				= 'POST';
		$sdata['mode'] 					= 'readonly';
		$sdata['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 		
		$sdata['Heading'] 				= 'Edit Transfer Non Id';
		$sdata['button_text'] 			= 'Update'; 
		$sdata['all_emp_type'] 		= DB::table('tbl_emp_type')->where('id','>',1)->where('status',1)->get();
		$sdata['branches'] 		    	= DB::table('tbl_branch')->where('status',1)->orderBy('branch_name','asc')->get();
		//
		return view('admin.employee.non_id_transfer_form',$sdata);	
	} 
	public function store(Request $request)
    { 
		$data = array();  
		$odata = array();  
		$data['emp_id']					= $request->emp_id;
		$data['effect_date']			= $request->effect_date;
		$data['from_branch_code']		= $request->from_branch_code; 
		$data['to_branch_code']			= $request->to_branch_code;
		$data['comments']				= $request->comments; 
		$data['org_code'] 				= Session::get('admin_org_code');
		$data['created_by'] 			= Session::get('admin_id');
		/// official info 
		$odata['emp_id']				= $request->emp_id; 	
		$odata['designation_code']	    = $request->designation_code;
		$odata['br_code']	   			= $request->to_branch_code;
		$odata['salary_br_code']		= $request->salary_br_code;
		$odata['joining_date']			= $request->effect_date;
		//$odata['after_trai_join_date']	= $request->after_trai_join_date;
		//$odata['after_trai_br_code']	= $request->after_trai_br_code;
		$odata['next_renew_date']		= $request->next_renew_date;
		$odata['end_type']				= $request->end_type;
		
		if($request->end_type == 1){
			$odata['c_end_date']			= $request->c_end_date;
		} 
		if($data['to_branch_code'] != $data['from_branch_code']){
			$odata['br_join_date'] = $request->effect_date;
		}else{
			$odata['br_join_date']  = $request->br_join_date;
		}
		$odata['created_by']			= Session::get('admin_id'); 
		$odata['org_code'] 			= Session::get('admin_org_code');
		
		$odata['sarok_no'] 	= $sarok_no = $this->get_last_nonid_sarok();
		$data['sarok_no'] 	= $sarok_no;
		  
		/* 
		 echo '<pre>';
		print_r($data);
		echo '<pre>';
		  */
		  
		 
		DB::beginTransaction();
		try {	 
			$tran_db_id = DB::table('tbl_nonid_transfer')->insertGetId($data);
			 $odata['tran_db_id']			= $tran_db_id; 
			DB::table('tbl_nonid_official_info')->insert($odata);
			DB::commit();
			Session::put('message','Data Saved Successfully');
		}catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		}
		 
		return Redirect::to('/con_transfer');
    } 
	
	public function update(Request $request, $id)
    {	  
		$sdata = array(); 
		$odata = array(); 
		$emp_id 					= $request->emp_id; 
		$tran_db_id 				= $request->tran_db_id; 
		$sdata['effect_date']		= $request->effect_date;
		$sdata['comments']			= $request->comments;  
		$sdata['from_branch_code']	= $request->from_branch_code;
		$sdata['to_branch_code']	= $request->to_branch_code;
		$sdata['updated_by'] 		= Session::get('admin_id'); 
		$odata['br_code']			= $request->to_branch_code;
		$odata['salary_br_code']	= $request->salary_br_code;
		$odata['joining_date']		= $request->effect_date;
		$odata['updated_at']		= date("Y-m-d");
		$odata['updated_by']		= Session::get('admin_id'); 
		if($sdata['to_branch_code'] != $request->from_branch_code){
			$odata['br_join_date'] = $request->effect_date;
		}else{
			$odata['br_join_date']  = $request->br_join_date;
		}
		 
		/*  echo '<pre>';
		print_r($id);
		 exit;    */
		//Data Update 
		DB::beginTransaction();
		try{
				/* echo '<pre>';
				print_r($sdata);
				 exit;   */
			DB::table('tbl_nonid_transfer')
				->where('id', $id)
				->update($sdata);
			DB::table('tbl_nonid_official_info')
				->where('tran_db_id', $tran_db_id)
				->update($odata);
			DB::commit();
			Session::put('message','Data Updated Successfully');
		} catch (\Exception $e) {
			
			Session::put('message','Error: Unable to Updated Data');
			DB::rollback();
		}
		return Redirect::to('/con_transfer');
    }
	
	public function view_nonid_transfer($id)
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
		
		$result =  DB::table('tbl_nonid_transfer') 
							->leftjoin('tbl_emp_non_id', 'tbl_nonid_transfer.emp_id', '=', 'tbl_emp_non_id.emp_id') 
							->leftjoin('tbl_nonid_official_info', 'tbl_nonid_official_info.tran_db_id', '=', 'tbl_nonid_transfer.id')
							->leftjoin('tbl_branch as f', 'f.br_code', '=', 'tbl_nonid_transfer.from_branch_code')
							->leftjoin('tbl_branch as t', 't.br_code', '=', 'tbl_nonid_transfer.to_branch_code')
							->leftjoin('tbl_branch as s', 's.br_code', '=', 'tbl_nonid_official_info.salary_br_code') 
							->leftjoin('tbl_branch as af', 'tbl_nonid_official_info.after_trai_br_code', '=', 'af.br_code')
							->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_nonid_official_info.designation_code' )
							->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_emp_non_id.emp_id' )
							->leftjoin('tbl_emp_type as et',function($join){
										$join->on('et.id', "=","tbl_emp_non_id.emp_type_code"); 
									})	
							->select('tbl_nonid_transfer.*','f.branch_name as f_branch_name','t.branch_name as t_branch_name','af.branch_name as branch_name_af','s.branch_name as s_branch_name','tbl_emp_non_id.emp_name','tbl_emp_non_id.sacmo_id','tbl_designation.designation_name','tbl_emp_non_id.joining_date','tbl_emp_non_id_cancel.cancel_date','tbl_nonid_official_info.salary_br_code','et.type_name') 
							->where('tbl_nonid_transfer.id',$id)
							->first();
		$sdata['emp_id']				= $result->emp_id;
		$sdata['cancel_date']			= $result->cancel_date;
		$sdata['sacmo_id']				= $result->sacmo_id;
		$sdata['type_name']				= $result->type_name;
		$sdata['emp_name']				= $result->emp_name;
		$sdata['designation_name']		= $result->designation_name;
		$sdata['joining_date']			= $result->joining_date; 
		$sdata['f_branch_name']			= $result->f_branch_name;
		$sdata['t_branch_name']			= $result->t_branch_name;
		$sdata['s_branch_name']			= $result->s_branch_name;
		if(!empty($result->branch_name_af)){
			$sdata['branch_name']			= $result->branch_name_af;
		}else{
			$sdata['branch_name']			= $result->f_branch_name;
		}
		
		$sdata['effect_date']			= $result->effect_date; 
		$sdata['comments']				= $result->comments; 
		$sdata['from_branch_code']		= $result->from_branch_code; 
		$sdata['salary_br_code']		= $result->salary_br_code; 
		$sdata['to_branch_code']		= $result->to_branch_code; 
		//
		return view('admin.employee.non_id_transfer_view',$sdata);	
	} 
	public function get_nonemployee_transfer($sacmo_id,$emp_type)
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
														 
							->leftjoin('tbl_nonid_transfer',function($join){
												$join->on("tbl_nonid_transfer.emp_id","=","tbl_emp_non_id.emp_id")
												->where('tbl_nonid_transfer.effect_date',DB::raw("(SELECT 
																				  max(tbl_nonid_transfer.effect_date)
																				  FROM tbl_nonid_transfer 
																				   where tbl_emp_non_id.emp_id = tbl_nonid_transfer.emp_id
																				  )") 		 
															); 
														})	
														
							->leftjoin('tbl_branch as br_o', 'br_o.br_code', '=', 'tbl_nonid_official_info.br_code' )
							->leftjoin('tbl_branch as br_t', 'br_t.br_code', '=', 'tbl_nonid_official_info.after_trai_br_code' )
							->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_nonid_official_info.designation_code' )
							->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_emp_non_id.emp_id' )
							->where('tbl_emp_non_id.sacmo_id', $sacmo_id)
							->where('tbl_emp_non_id.emp_type_code', $emp_type)
							->select('tbl_emp_non_id.emp_id','tbl_emp_non_id.emp_type_code','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.joining_date','tbl_emp_non_id.emp_name','br_o.branch_name','br_t.branch_name as branch_name_af','tbl_designation.designation_name','tbl_nonid_official_info.br_code','tbl_nonid_official_info.designation_code','tbl_nonid_official_info.after_trai_join_date','tbl_nonid_official_info.after_trai_br_code','tbl_nonid_official_info.next_renew_date','tbl_nonid_official_info.end_type','tbl_nonid_official_info.c_end_date','tbl_nonid_official_info.salary_br_code','tbl_nonid_transfer.emp_id as emp_id_t','tbl_nonid_official_info.br_join_date','tbl_emp_non_id_cancel.cancel_date')
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
	
	public function check_nonid_effect_date($emp_id,$effect_date)
	{
		$is_less_date = 0;
		$results = DB::table('tbl_master_tra') 
						->where('emp_id',$emp_id) 
						->where('joining_date','>=',$effect_date) 
						->select('emp_id')
						->first();
		if($results){
			  $is_less_date = 1;
		}	
		echo $is_less_date;	
	}
	public function get_nonid_transfer_info($emp_id)
	{
		$results = DB::table('tbl_nonid_transfer')
						->join('tbl_branch as br_f', 'br_f.br_code', '=', 'tbl_nonid_transfer.from_branch_code') 
						->join('tbl_branch as br_t', 'br_t.br_code', '=', 'tbl_nonid_transfer.to_branch_code') 
						->where('tbl_nonid_transfer.emp_id',$emp_id) 
						->orderBy('tbl_nonid_transfer.effect_date', 'desc')
						->select('tbl_nonid_transfer.id','tbl_nonid_transfer.effect_date','br_f.branch_name as branch_name_f','br_t.branch_name as branch_name_t')
						->get();

		echo '<tr>';
		echo "<th>Sl</th>";
		echo "<th>From Branch</th>";
		echo "<th>To Branch</th>";
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
			echo "<td>$result->branch_name_f</td>";
			echo "<td>$result->branch_name_t</td>";
			echo "<td style='color:blue;'>";
			printf($diff->format('%y Year %m Month %d Day' ));
			echo "</td>";
			echo "<td>$show_effect</td>";
			echo '</tr>';
			$next_day = $result->effect_date;
			$i++;
		}		
		
	}
	public function del_nonid_transfer($id)
	{
		DB::table('tbl_nonid_transfer')
				->where('id', $id)
				->delete();
		DB::table('tbl_nonid_official_info')
				->where('tran_db_id', $id)
				->delete();
		return Redirect::to('/con_transfer');
	}
}
