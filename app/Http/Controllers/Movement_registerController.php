<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use File;
use Session;

class Movement_registerController extends Controller
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
										->where('move.emp_id',$emp_id)
										->where('move.emp_type',$emp_type) 
										->select('move.*','emp.emp_name_eng as emp_name','nid.emp_name as emp_name2','et.type_name')
										->get(); 
		/* echo '<pre>';
		print_r($emp_type); 
		exit;  */
		return view('admin.movement_register.move_register_list',$data);
    }
    public function create()
    {
		$data = array();  
		$data['destination_code'] 		= array();
		$data['action'] 				= 'movement/'; 
		$data['button']					= 'Save';
		$data['method_control'] 		=''; 
		$data['emp_id'] 				= Session::get('emp_id');   
        $data['purpose'] 				= ''; 
        $data['leave_time'] 			= 'now'; 
        $data['from_date'] 			= '';
		$data['tot_day'] 				= ''; 
		$data['to_date'] 				= ''; 
		$data['arrival_time'] 			= ''; 
        $data['approved'] 				= 0; 
        $data['arrival_date'] 			= ''; 
        $data['visit_type'] 			= 1; 
        $data['status'] 				=0; 
		$data['mode'] 					= ""; 
		$data['common_date'] 			= "common_date";
		$data['area_list'] = DB::table('tbl_area') 
									->get();
		$data['branch_list'] = DB::table('tbl_branch')  
									->where('status',1)
									->orderby('branch_name','asc')
									->select('br_code','branch_name')
									->get();
		return   view('admin.movement_register.movement_register_form',$data);
    }
    public function store(Request $request)
    {
        $data = array();  
        $data['emp_id'] 				= Session::get('emp_id');
		$data['emp_type'] 			= Session::get('emp_type');
		$data['tot_day'] 				= $request->tot_day; 
		$data['visit_type'] 				= $request->visit_type; 
		if($data['visit_type'] == 1){
			$data['destination_code'] 		= implode(",", $request->destination_code);
		}else{
			$data['destination_code'] 		= $request->loc_destination;
		}
        
        $data['purpose'] 				= $request->purpose; 
        $data['leave_time'] 			= $request->leave_time; 
        $data['from_date'] 				= $request->from_date; 
		$data['to_date'] 				= $request->to_date; 
		 
		
        $data['status'] 				=0; 
		/* echo '<pre>';
		print_r($data);
		exit;  */
		DB::table('tbl_movement_register')->insert($data);
		return Redirect::to('/movement');
    }
    public function edit($id)
    {
        $data = array();  
		$data['button']				= 'Update';
		$data['method_control'] ="<input type='hidden' name='_method' value='PUT' />"; 
		//$emp_id = Session::get('emp_id'); 
		$data['area_list'] = DB::table('tbl_area')
									->get();
		$movement_by_id = DB::table('tbl_movement_register as move')
									->where('move.move_id',$id)
									->select('move.*')
									->first();  
        $data['emp_id'] 				= $movement_by_id->emp_id; 
        $data['destination_code'] 		= explode(',',$movement_by_id->destination_code);
        $data['purpose'] 				= $movement_by_id->purpose; 
        $data['leave_time'] 			= $movement_by_id->leave_time; 
        $data['from_date'] 				= $movement_by_id->from_date; 
		$data['arrival_time'] 			= $movement_by_id->arrival_time; 
		$data['to_date'] 				= $movement_by_id->to_date; 
		$data['tot_day'] 				= $movement_by_id->tot_day; 
        $data['arrival_date'] 			= $movement_by_id->arrival_date; 
		$data['action'] 				= "movement/$id";
		$data['approved'] 				= 0; 
		$data['mode'] 					= ""; 
		$data['common_date'] 		    = "common_date";
		if($movement_by_id->status == 1){
			$data['approved'] 			= 1; 
			$data['mode'] 				= "readonly";
			//$data['common_date'] 		= "";
		} 
		$data['branch_list'] = DB::table('tbl_branch') 
									->where('status',1)
									->orderby('branch_name','asc')
									->select('br_code','branch_name')
									->get();
		/* echo '<pre>';
		print_r($data['destination_code']);
		exit; */
		return   view('admin.movement_register.movement_register_form',$data);
    }
    public function update(Request $request, $id)
    {
        $data = array();  
        $data['destination_code'] 		= implode(',',$request->destination_code); 
        $data['purpose'] 				= $request->purpose; 
        $data['leave_time'] 			= $request->leave_time; 
        $data['from_date'] 				= $request->from_date; 
        $data['to_date'] 				= $request->to_date; 
        $data['arrival_time'] 			= $request->arrival_time; 
        $data['tot_day'] 				= $request->tot_day; 
        $data['arrival_date'] 			= $request->arrival_date; 
		/* echo '<pre>';
		print_r($data);
		exit; */
			
		DB::table('tbl_movement_register')
				->where('move_id', $id)
				->update($data);
		 
		return Redirect::to('/movement');
    }
	public function appr_movement_list()
    {
        $data = array(); 
		$emp_id = Session::get('emp_id'); 
		$emp_type = Session::get('emp_type'); 
        $data['movement_register_list'] = DB::table('tbl_movement_register as move')
									
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
										->leftjoin('tbl_reported_to as rt',function($join){
											$join->on('rt.emp_id', "=","move.emp_id")
												->on('rt.emp_type', "=","move.emp_type"); 
										})	
									->where('rt.r_emp_id',$emp_id)
									->where('rt.r_emp_type',$emp_type)
									//->where('move.status','!=',2)
									->select('move.*','emp.emp_name_eng as emp_name','nid.emp_name as emp_name2','et.type_name')
									->get(); 
		return view('admin.movement_register.move_regi_appr_list',$data);
    }
	public function selectbranch($area_id)
    {
         
          $branch_list = DB::table('tbl_branch') 
								->where('area_code',$area_id)
								->select('br_code','branch_name')
								->get();  
		echo "<option value=''>--Select--</option>";
		foreach($branch_list as $branch){
			echo "<option value='$branch->br_code'>$branch->branch_name</option>";
		}  
    }
	public function movement_approved_edit($id, $emp_id,$emp_type)
    {
        $data = array(); 
		$data['action'] 			= "movement_appr_update"; 
		$data['button']				= 'Approved';
		$data['move_id']			= $id;
		$data['method_control'] ="<input type='hidden' name='_method' value='PUT' />"; 
		$current_date = date('Y-m-d');
		$data['area_list'] = DB::table('tbl_area')
									->get();
		$movement_by_id = DB::table('tbl_movement_register as move')
									->where('move.move_id',$id)
									->select('move.*')
									->first(); 
		if($emp_type == 1){
			
				$max_sarok = DB::table('tbl_master_tra')
							->where('emp_id', '=', $emp_id)
							->where('br_join_date', '<=', $current_date)
							->select('emp_id', DB::raw('max(letter_date) as letter_date'), DB::raw('max(sarok_no) as sarok_no'))
							->groupBy('emp_id')
							->first();
				if($max_sarok){	
					$emp_info = DB::table('tbl_master_tra as m') 
									->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id') 
									->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
									->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
									->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->select('emp.emp_id','emp.emp_name_eng as emp_name','emp.org_join_date','b.br_code','d.designation_name','d.designation_code','b.branch_name','r.effect_date as cancel_date')
									->first(); 
					
				$data['emp_image'] = $emp_info->emp_id.'.jpg';
				}
				
		}else{
			$emp_info  = DB::table('tbl_emp_non_id as nid')   
										 ->leftjoin('tbl_nonid_official_info as oinf',function($join){
												$join->on("nid.emp_id","=","oinf.emp_id")
													->where('oinf.joining_date',DB::raw("(SELECT 
																				  max(tbl_nonid_official_info.joining_date)
																				  FROM tbl_nonid_official_info 
																				   where nid.emp_id = tbl_nonid_official_info.emp_id
																				  )") 		 
															); 
														})
										 ->leftJoin('tbl_emp_non_id_cancel as nidc', 'oinf.emp_id', '=', 'nid.emp_id') 
										 ->leftJoin('tbl_designation as d', 'oinf.designation_code', '=', 'd.designation_code') 
										 ->leftJoin('tbl_branch as b', 'oinf.br_code', '=', 'b.br_code')
										 ->where('nid.sacmo_id',$emp_id)  
										 ->where('nid.emp_type_code',$emp_type)  
										 ->select('nid.sacmo_id as emp_id','nidc.cancel_date','nidc.cancel_by as resignation_by','nid.emp_name','nid.joining_date as org_join_date','b.br_code','d.designation_code','b.branch_name','d.designation_name')
										 ->first(); 
				$data['emp_image'] = 'default1.jpg';
		}
		$data['emp_id'] 				= $emp_info->emp_id;
		$data['emp_name'] 				= $emp_info->emp_name;
		$data['designation_name'] 		= $emp_info->designation_name;
		$data['branch_name'] 			= $emp_info->branch_name;
		$data['org_join_date'] 			= $emp_info->org_join_date;
		$data['cancel_date'] 			= $emp_info->cancel_date;  
		$data['destination_code'] 		= explode(',',$movement_by_id->destination_code);
        $data['purpose'] 				= $movement_by_id->purpose; 
        $data['leave_time'] 			= $movement_by_id->leave_time; 
        $data['from_date'] 			= $movement_by_id->from_date; 
		$data['arrival_time'] 			= $movement_by_id->arrival_time; 
		$data['to_date'] 				= $movement_by_id->to_date; 
		$data['tot_day'] 				= $movement_by_id->tot_day; 
        $data['arrival_date'] 			= $movement_by_id->arrival_date; 
		$data['branch_list'] 		= DB::table('tbl_branch') 
										->where('status',1)
									    ->orderby('branch_name','asc')
										->select('br_code','branch_name')
				 						->get();
		
		
		return   view('admin.movement_register.movement_approved_form',$data);
    } 
	public function movementapprovedupdate(Request $request)
    {
        $data = array(); 
		$data['status'] 		= 1;
        $move_id        		= $request->move_id;
        $data['to_date']        = $request->to_date;
        $data['tot_day']        = $request->tot_day;
		/* echo '<pre>';
		print_r($data);
		exit; */
			
		DB::table('tbl_movement_register')
				->where('move_id', $move_id)
				->update($data);
		 
		return Redirect::to('/movement_approved');
    }
	public function movement_reject($status,$move_id)
    {
        $data = array(); 
		$data['status'] 		= $status;
        
		/* echo '<pre>';
		print_r($data);
		exit; */
			
		DB::table('tbl_movement_register')
				->where('move_id', $move_id)
				->update($data);
		 
		return Redirect::to('/movement_approved');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
