<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use File;
use Session;

class Movement_BillcreateController extends Controller
{
	 public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
    public function index()
    {
		$data = array();
		$emp_id = Session::get('emp_id'); 
		$emp_type = Session::get('emp_type');
		$data['movement_register_list'] = DB::table('tbl_movement_register as move') 
										/* ->leftJoin("tbl_move_trav_details as move_d",function($join){
												$join->on("move.move_id","=","move_d.move_id");
										})  */
										->leftjoin('tbl_move_trav_details as move_d',function($join){
												$join->on("move.move_id","=","move_d.move_id")
													->where('move_d.travel_date',DB::raw("(SELECT 
																				  max(travel_date)
																				  FROM tbl_move_trav_details 
																				   where move.move_id = tbl_move_trav_details.move_id
																				  )") 		 
															); 
														})
										->leftJoin("tbl_emp_basic_info as emp",function($join){
												$join->on("emp.emp_id","=","move.emp_id")
												->where("move.emp_type","=",1);
										}) 
										->leftJoin("tbl_emp_non_id as nid",function($join){
												$join->on("nid.sacmo_id","=","move.emp_id")
													->on("nid.emp_type_code","=","move.emp_type");
											})
										->leftjoin('tbl_emp_type as et',function($join){
											$join->on('et.id', "=","move.emp_type"); 
										})	
										->where('move.status',3)
										->where('move.emp_id',$emp_id)
										//->where('move.emp_type',$emp_type) 
										->select('move.*','emp.emp_name_eng as emp_name','nid.emp_name as emp_name2','et.type_name')
										->get(); 
		/* echo '<pre>';
		print_r($data['movement_register_list']); 
		exit;  */
		return view('admin.movement_register.move_bill_list',$data);
    }
    public function movement_bill_create($move_id)
    {
		$data = array();  
		$data['destination_code'] 		= array();
		date_default_timezone_set('Asia/Dhaka');
		$data['breakfast'] 				=''; 
		$data['lunch'] 					=''; 
		$data['dinner'] 				=''; 
		$data['tot_amt'] 				=''; 
		$data['action'] 				= 'movement_bill/'; 
		$data['button']					= 'Save';
		$data['method_control'] 		=''; 
		$data['emp_name'] 				= ''; 
		$data['designation_name'] 		= ''; 
		$data['branch_name'] 		= ''; 
		$data['move_id'] 				= $move_id; 
		$data['emp_id'] 				= Session::get('emp_id');
		$movement_by_id 				= DB::table('tbl_movement_register as move')
											->where('move.move_id',$move_id)
											->select('move.*')
											->first();  
											
		/*  echo '<pre>';
			print_r($movement_by_id);
			exit; */									
		$emp_id 						= $movement_by_id->emp_id;  
		$data['application_date'] 		= $movement_by_id->application_date; 
		$data['purpose'] 				= $movement_by_id->purpose; 
		$data['visit_type'] 			= $visit_type = $movement_by_id->visit_type; 
        $data['leave_time'] 			= $movement_by_id->leave_time; 
        $data['arrival_date'] 			= $movement_by_id->arrival_date; 
		/*  echo '<pre>';
			print_r($data['arrival_date']);
			exit; */
        $data['return_time'] 			= $movement_by_id->return_time; 
        $data['travel_date'] 			= $movement_by_id->from_date;
		
		 
		$data['to_date'] 				= $movement_by_id->to_date; 
		
		$arrival_date =date("Y-m-d",strtotime($data['arrival_date']));
		$from_date =date("Y-m-d",strtotime($data['travel_date']));
		
		$date1=date_create($arrival_date);
		$date2=date_create($from_date);
		$diff=date_diff($date2,$date1);
		$day = $diff->format("%R%a");
		$data['tot_day'] 				= $day +1; 
		/* print_r($day) ;
		exit; */
		$data['arrival_time'] 			= $movement_by_id->arrival_time;  
		if($data['visit_type'] == 1){
			$data['destination_code'] 		= $destination_code = explode(',',$movement_by_id->destination_code);
		}else{
			$data['destination_code'] 		= $destination_code = $movement_by_id->destination_code;
		} 
		
		$current_date                   = $data['travel_date'];
		 
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
					$employee_his  = DB::table('tbl_master_tra as m')  
											->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
											->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
											->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
											->where('m.sarok_no', '=', $max_sarok->sarok_no)
											->select('emp.emp_id','m.grade_code','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','emp.org_join_date as joining_date')
											->first(); 
					$data['designation_code'] 	= $employee_his->designation_code;
					$data['grade_code'] 		= $employee_his->grade_code;
					$data['emp_name'] 			=$employee_his->emp_name;
					$data['designation_name'] 	=$employee_his->designation_name;
					$data['branch_name'] 		=$employee_his->branch_name;
					$grade_wise_allowance =  $this->get_grade_wise_allowance($data['grade_code'],$data['travel_date']);
					/* print_r($grade_wise_allowance);
					exit; */
				    $grade_wise_allowance1 = explode(',',$grade_wise_allowance);
					$data['breakfast'] 				=$grade_wise_allowance1[0]; 
					$data['lunch'] 					=$grade_wise_allowance1[1]; 
					$data['dinner'] 				=$grade_wise_allowance1[2]; 
					$data['tot_amt'] 				=$grade_wise_allowance1[3]; 
					
				}
				
			
			
		 
		 
		$data['branch_list'] = DB::table('tbl_branch')  
									->where('status',1)
									->where(function ($query) use($visit_type,$destination_code) {
										if($visit_type == 1){
											$query->whereIn('br_code', $destination_code)->orwhere('br_code', 9999);
										} 	 	 
									})  
									->orderby('branch_name','asc')
									->select('br_code','branch_name')
									->get();
		/* echo "<pre>";
		 print_r($data['branch_list']) ;
		exit; */
		
		if($visit_type == 1){
			$data['travel_details'] = DB::table('tbl_move_trav_details as td')
									->leftJoin('tbl_branch as bs', 'td.source_br_code', '=', 'bs.br_code') 
									->leftJoin('tbl_branch as bt', 'td.dest_br_code', '=', 'bt.br_code') 
									->where('td.move_id',$move_id)
									->orderby('td.travel_date','asc')
									->select('td.*','bs.branch_name as source_branch_name','bt.branch_name as destination_branch_name')
									->get();
		}else{
			$data['travel_details'] = DB::table('tbl_move_trav_details as td') 
									->where('td.move_id',$move_id)
									->orderby('td.travel_date','asc')
									->select('td.*')
									->get();
		}
		$data['bill_details'] = DB::table('tbl_move_bill_details as bd') 
									->where('bd.move_id',$move_id)
									->orderby('bd.bill_date','asc')
									->select('bd.*')
									->get();
		
		
		return   view('admin.movement_register.movement_bill_form',$data);
    }
    public function travel_insert(Request $request)
    { 
        $tdata = array();  
        $bdata = array();  
		$bdata['created_by'] = $tdata['created_by'] = Session::get('admin_id');   
		 
		$bdata['move_id'] = $tdata['move_id'] = $move_id = $request->move_id;
		 
		$tdata['travel_date'] 			= $travel_date    = $request->travel_date;
		$tdata['source_br_code'] 		= $source_br_code = $request->source_br_code;
		$tdata['dest_br_code'] 			= $dest_br_code   = $request->dest_br_code;
		$tdata['medium_trav'] 			= $request->medium_trav;
		$tdata['travel_allowance'] 		= $request->travel_allowance; 
		$travel_id 						= $request->travel_id; 
		
		
		
		if($travel_id > 0){
				$tdata['updated_at'] 			= date("Y-m-d");
				$tdata['updated_by'] 			= Session::get('admin_id');
				$travel_date_exist				= DB::table('tbl_move_trav_details')
												->where('move_id',$move_id)
												->where('source_br_code',$source_br_code) 
												->where('dest_br_code',$dest_br_code) 
												->where('id','!=',$travel_id)
												->where('travel_date',$travel_date) 
												->first();
				if($travel_date_exist){
					$status =1;
					
				}else{
					 DB::table('tbl_move_trav_details')
							->where('id', $travel_id)
							->update($tdata); 
					$status =0;
				}							
				 
		}else{
			$travel_date_exist				= DB::table('tbl_move_trav_details')
												->where('move_id',$move_id) 
												->where('travel_date',$travel_date) 
												->where('source_br_code',$source_br_code) 
												->where('dest_br_code',$dest_br_code) 
												->first();
				if($travel_date_exist){
					$status =1;
				}else{
					DB::table('tbl_move_trav_details')->insert($tdata);
					$status =0;
				}
		} 
		
		
		
		return response()->json(['data' => $status]);	
    }
	public function bill_insert(Request $request)
    {
        $udata = array();  
        $tdata = array();  
        $bdata = array();  
		$bdata['created_by'] = Session::get('admin_id');  
		$bdata['move_id'] = $move_id = $request->move_id_bill;
		 
		$bdata['bill_date'] 			= $bill_date = $request->bill_date;
		$bdata['breakfast'] 			= $request->breakfast;
		$bdata['lunch'] 				= $request->lunch;
		$bdata['dinner'] 				= $request->dinner;
		$bdata['tot_amt'] 				= $request->tot_amt; 
		$bill_id 						= $request->bill_id; 
		
		
		if($bill_id > 0){
				$bdata['updated_at'] 			= date("Y-m-d");
				$bdata['updated_by'] 			= Session::get('admin_id');
				$bill_date_exist				= DB::table('tbl_move_bill_details')
													->where('move_id',$move_id)
													->where('id','!=',$bill_id)
													->where('bill_date',$bill_date) 
													->first();
				if($bill_date_exist	){
					$status = 1;
				}else{
					   DB::table('tbl_move_bill_details')
							->where('id', $bill_id)
							->update($bdata); 
					$status = 0;		
				}
				
			}else{
				$bill_date_exist				= DB::table('tbl_move_bill_details')
													->where('move_id',$move_id)
													->where('bill_date',$bill_date) 
													->first();
				if($bill_date_exist	){
					$status = 1;
				}else{
					  DB::table('tbl_move_bill_details')->insert($bdata);
						$status = 0;		
				}
				
			} 
		
		return response()->json(['data' => $status]);	
    }
	
	public function travel_edit($id)
    {
		/* echo "ll";
		exit; */
		$data = array();
		
		
		$info_edit = DB::table('tbl_move_trav_details')->where('id', $id)->first();		
		 
		
		return response()->json(['data' => $info_edit]);	  
		 
		 
    }
	public function movement_delete($table_name,$id)
    {
		$status = DB::table($table_name)
					->where('id', $id)
					->delete(); 
		return response()->json(['data' => $status]);	  
    } 
    public function edit($move_id)
    {
        $data = array();  
		$data['button']				= 'Update';
		$data['method_control'] ="<input type='hidden' name='_method' value='PUT' />"; 
		//$emp_id = Session::get('emp_id'); 
		 
		$movement_by_id 				= DB::table('tbl_movement_register as move')
											->where('move.move_id',$move_id)
											->select('move.*')
											->first();  
		$emp_id 						= $movement_by_id->emp_id;  
		$data['visit_type'] 				= $movement_by_id->visit_type; 
		$data['purpose'] 				= $movement_by_id->purpose; 
        $data['leave_time'] 			= $movement_by_id->leave_time; 
        $data['travel_date'] 			= $movement_by_id->from_date;
		$data['tot_day'] 				= $movement_by_id->tot_day; 
		$data['to_date'] 				= $movement_by_id->to_date; 
		$data['arrival_time'] 			= $movement_by_id->arrival_time;  
		$data['grade_code'] 			= $movement_by_id->grade_code; 
		if($data['visit_type'] == 1){
			$data['destination_code'] 		= explode(',',$movement_by_id->destination_code);
		}else{
			$data['destination_code'] 		= $movement_by_id->destination_code;
		}
		 
		$data['move_id'] 				= $move_id;  
		$data['action'] 				= "movement_bill_update";
		
		$data['travel_details'] 		= DB::table('tbl_move_trav_details')
											->where('move_id',$move_id)
											->select('*')
											->get(); 
		$data['bill_details'] 		= DB::table('tbl_move_bill_details')
											->where('move_id',$move_id)
											->select('*')
											->get(); 
		
		 
		$data['mode'] 					= ""; 
		$data['common_date'] 		    = "common_date";
		 
		$data['branch_list'] = DB::table('tbl_branch')
									->where('status',1)
									->orderby('branch_name','asc')
									->select('br_code','branch_name')
									->get();
		/* echo '<pre>';
		print_r($data['destination_code']);
		exit; */
		return   view('admin.movement_register.movement_bill_form_edit',$data);
    }
	public function bill_edit($id)
    {
		/* echo "ll";
		exit; */
		$data = array();
		
		
		$info_edit = DB::table('tbl_move_bill_details')->where('id', $id)->first();		
		 
		
		return response()->json(['data' => $info_edit]);	  
		 
		 
    }
	public function tra_bill_save($move_id,$grade_code,$designation_code)
    {
        $udata = array();  
		$udata['grade_code'] = $grade_code;
		$udata['designation_code'] = $designation_code;
		$udata['is_create_bill'] = 2;
        DB::table('tbl_movement_register')
				->where('move_id', $move_id)
				->update($udata); 
		return Redirect::to('/leave_visit');
    }  
	public function get_grade_wise_allowance($grade_code,$bill_date)
    {
          $bill_allowance = DB::table('tbl_move_bill_allow_con') 
								->where('grade_code',$grade_code) 
								->where('from_date','<=',$bill_date)
								->where('to_date','>=',$bill_date)
								->select('breakfast','lunch','dinner')
								->first();  
		$breakfast = 0;
		$lunch = 0;
		$dinner = 0; 
		 if($bill_allowance){
			$breakfast =  $bill_allowance->breakfast;
			$lunch =  $bill_allowance->lunch;
			$dinner =  $bill_allowance->dinner;
			 
		  }
		  $sum = $breakfast + $lunch + $dinner;
		  return $breakfast.','.$lunch.','.$dinner.','.$sum;
    } 
	public function select_travel_amt($source_br_code,$dest_br_code,$travel_date)
    {
         
          $travel_allowance_list = DB::table('tbl_move_tra_allow_con') 
									->where('source_br_code',$source_br_code)
									->where('dest_br_code',$dest_br_code)
									->where('from_date','<=',$travel_date)
									->where('to_date','>=',$travel_date)
									->select('travel_amt')
									->first();  
		$travel_amt = 0;
		 if($travel_allowance_list){
			$travel_amt =  $travel_allowance_list->travel_amt;
		  }
		  echo $travel_amt;
    }  
	public function get_travel_bill_info($move_id,$visit_type)
    {
		 
		if($visit_type == 1){
			$travel_details = DB::table('tbl_move_trav_details as td')
									->leftJoin('tbl_movement_register as r', 'r.move_id', '=', 'td.move_id') 
									->leftJoin('tbl_branch as bs', 'td.source_br_code', '=', 'bs.br_code') 
									->leftJoin('tbl_branch as bt', 'td.dest_br_code', '=', 'bt.br_code') 
									->where('td.move_id',$move_id)
									->orderby('td.travel_date','asc') 
									 ->select('td.medium_trav','td.travel_allowance','td.source_br_code','td.dest_br_code',DB::raw('DATE_FORMAT(td.travel_date, "%d-%m-%Y") as travel_date'),'bs.branch_name as source_branch_name','bt.branch_name as destination_branch_name','r.purpose') 
									->get();
			 					
		}else{
			$travel_details = DB::table('tbl_move_trav_details as td')
									->leftJoin('tbl_movement_register as r', 'r.move_id', '=', 'td.move_id') 
									->where('td.move_id',$move_id)
									->orderby('td.travel_date','asc')
									->select('td.medium_trav','td.travel_allowance','td.source_br_code','td.dest_br_code',DB::raw('DATE_FORMAT(td.travel_date, "%d-%m-%Y") as travel_date'),'r.purpose')
									->get();
		}
		$bill_details = DB::table('tbl_move_bill_details as bd') 
									->where('bd.move_id',$move_id)
									->orderby('bd.bill_date','asc')
									->select('bd.tot_amt','bd.breakfast','bd.lunch','bd.dinner',DB::raw('DATE_FORMAT(bd.bill_date, "%d-%m-%Y") as bill_date'))
									->get();
		
		$visit_detail = DB::table('tbl_movement_register as r') 
									->leftJoin('tbl_designation as d', 'r.designation_code', '=', 'd.designation_code') 
									->where('r.move_id',$move_id)
									->select('r.purpose','d.designation_name')
									->first();
		return response()->json(['data' => $travel_details,'data_b' => $bill_details,'visit_detail' => $visit_detail]);
    }
	
	
	
	public function create_bill_list()
    {
		$data = array();
		$emp_id = Session::get('emp_id');  
		$data['movement_register_list'] = DB::table('tbl_movement_register as move') 
										/* ->leftJoin("tbl_move_trav_details as move_d",function($join){
												$join->on("move.move_id","=","move_d.move_id");
										})  */
										->leftjoin('tbl_move_trav_details as move_d',function($join){
												$join->on("move.move_id","=","move_d.move_id")
													->where('move_d.travel_date',DB::raw("(SELECT 
																				  max(travel_date)
																				  FROM tbl_move_trav_details 
																				   where move.move_id = tbl_move_trav_details.move_id
																				  )") 		 
															); 
														})
										->leftJoin("tbl_emp_basic_info as emp",function($join){
												$join->on("emp.emp_id","=","move.emp_id")
												->where("move.emp_id","<",100000);
										}) 
										->leftJoin("tbl_emp_non_id as nid",function($join){
												$join->on("nid.emp_id","=","move.emp_id")
													->on("nid.move",">",100000);
											}) 
										->where('move.is_create_bill',2)
										->where('move.emp_id',$emp_id)
										//->where('move.emp_type',$emp_type) 
										->select('move.*','emp.emp_name_eng as emp_name','nid.emp_name as emp_name2')
										->get(); 
		/* echo '<pre>';
		print_r($data['movement_register_list']); 
		exit;  */
		return view('admin.movement_register.move_bill_list',$data);
    }
}
