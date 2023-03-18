<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\NonIdCancel_br;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class NonIdbranchCancelController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	public function index()
    {        	
		$data = array(); 
		$br_code 		= Session::get('branch_code');
		$data['result'] = DB::table('tbl_emp_non_id_cancel')
							->leftjoin('tbl_emp_non_id', 'tbl_emp_non_id.emp_id', '=', 'tbl_emp_non_id_cancel.emp_id' )
							->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_emp_non_id_cancel.br_code' )
							->leftjoin('tbl_emp_type as et',function($join){
										$join->on('et.id', "=","tbl_emp_non_id_cancel.emp_type_code"); 
									})	 
							 ->where(function($query) use ($br_code)
									{
										$query->where('tbl_emp_non_id_cancel.br_code',$br_code)
												->where('tbl_emp_non_id_cancel.emp_type_code',5);
										 
									})
							->orwhere(function($query) use ($br_code)
									{
										$query->where('tbl_emp_non_id_cancel.br_code',$br_code)
												->where('tbl_emp_non_id_cancel.emp_type_code',9);
										 
									}) 
							->orderBy('tbl_emp_non_id_cancel.emp_code', 'desc')
							->select('tbl_emp_non_id_cancel.id','tbl_emp_non_id_cancel.emp_id','tbl_emp_non_id_cancel.br_code','tbl_emp_non_id_cancel.emp_code','tbl_emp_non_id_cancel.emp_type_code','tbl_emp_non_id_cancel.cancel_date','tbl_emp_non_id_cancel.cancel_by','tbl_branch.branch_name','tbl_emp_non_id.emp_name','et.type_name')
							->get();
		/* echo '<pre>';
		print_r($data);
		exit; */
		return view('admin.employee.manage_non_id_cancel_br',$data);					
    }
	
	
	public function non_id_cancel_br_create()
    {
		/* $action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		} */
		$data = array();
		$data['id'] 				= '';
		$data['emp_id'] 			= '';
		$data['emp_code'] 			= ''; 
		$data['emp_type'] 			= $emp_type = 5; 
		$data['cancel_date'] 		= date('Y-m-d');
		$data['cancel_by'] 			= 'Self';
		//
		$data['emp_name'] 			= '';
		$data['branch_name'] 		= '';
		$data['joining_date'] 		= '';
		$data['mode'] 				= '';
		//
		$data['action'] 			= '/non_id_cancel_insert_br';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ''; 
		$data['Heading'] 			= 'Add Contractual Cancel Branch';
		$data['button_text'] 		= 'Save';
		
		 
		$data['br_code'] 			= $br_code = Session::get('branch_code');
		$data['results'] 			= DB::table('tbl_emp_non_id')
									->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_emp_non_id.emp_id')
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
								  
									->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_nonid_official_info.br_code')
									->where('tbl_nonid_official_info.br_code', $br_code) 
									->where('tbl_emp_non_id.emp_type_code', $emp_type)
									->select('tbl_emp_non_id.emp_id','tbl_emp_non_id.emp_name','tbl_emp_non_id.emp_type_code','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.joining_date','tbl_nonid_official_info.br_code','tbl_emp_non_id_cancel.cancel_date','tbl_branch.branch_name') 
									->get();


			
		//
		$data['all_emp_type'] 			= DB::table('tbl_emp_type')->where('status',1)->where('for_which',2)->get();
		return view('admin.employee.non_id_cancel_form_br',$data);	
    }	
	
	
	public function get_nonid_info_br($emp_id,$emp_type) 
	{
		$data = array();
		$br_code 					= Session::get('branch_code');
		 $result = DB::table('tbl_emp_non_id')
						->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_emp_non_id.emp_id')
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
						->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_nonid_official_info.br_code')
						->where('tbl_nonid_official_info.br_code', $br_code)
						->where('tbl_emp_non_id.sacmo_id', $emp_id)
						->where('tbl_emp_non_id.emp_type_code', $emp_type)
						->select('tbl_emp_non_id.emp_id','tbl_emp_non_id.emp_name','tbl_emp_non_id.emp_type_code','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.joining_date','tbl_nonid_official_info.br_code','tbl_emp_non_id_cancel.cancel_date','tbl_branch.branch_name') 
						->first();
						
		$data['emp_name'] 		= $result->emp_name;				
		$data['br_code'] 		= $result->br_code;				
		$data['branch_name'] 	= $result->branch_name;				
		$data['emp_id'] 		= $result->emp_id;				
		$data['emp_type'] 		= $result->emp_type_code;				
		$data['sacmo_id'] 		= $result->sacmo_id;							
		$data['joining_date'] 	= date("d-m-Y",strtotime($result->joining_date)); 

		 if($result->cancel_date)
		{
			$data['cancel_date']= $result->cancel_date;	
		}
		else{
			$data['cancel_date']= '';	
		}  
		//echo '<pre>';
		//print_r($data);
		//exit;	
		//echo 'ok';
		/* $data['emp_code'] = 1;
		$data['emp_type'] = 2; */
		
		
	 return $data;			  
			
	}

	public function non_id_cancel_br_edit($id)
	{
		/* $action_id = 3;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		} */

		$data = array();
		$data['results'] = '';
		$result = DB::table('tbl_emp_non_id_cancel')
						->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_emp_non_id_cancel.br_code')
						->leftjoin('tbl_emp_non_id', 'tbl_emp_non_id.emp_id', '=', 'tbl_emp_non_id_cancel.emp_id')
						->where('tbl_emp_non_id_cancel.id', $id)
						->select('tbl_emp_non_id_cancel.*','tbl_emp_non_id.emp_name','tbl_emp_non_id.joining_date','tbl_branch.branch_name') 
						->first();  
		$data['id'] 				= $result->id;
		$data['emp_id'] 			= $result->emp_id;
		$data['emp_code'] 			= $result->emp_code;
		$data['emp_type'] 			= $result->emp_type_code;
		$data['br_code'] 			= $result->br_code;
		$data['cancel_date'] 		= $result->cancel_date;
		$data['cancel_by'] 			= $result->cancel_by;
		//
		$data['emp_name'] 			= $result->emp_name;
		$data['branch_name'] 		= $result->branch_name;
		$data['joining_date'] 		= $result->joining_date;
		//
		$data['action'] 			= "/non_id_cancel_br_update";
		$data['method'] 			= 'POST';
		$data['method_control'] 	= "<input type='hidden' name='_method' value='PUT' />"; 		
		$data['Heading'] 			= 'Edit Contractual Cancel branch';
		$data['button_text'] 		= 'Update';			
		$data['mode'] 				= 'edit';			
		//
		$data['all_emp_type'] 			= DB::table('tbl_emp_type')->where('status',1)->where('for_which',2)->get();
		return view('admin.employee.non_id_cancel_form_br',$data);		
	}
	
	
	public function validation($emp_id)
	{
		$info = DB::table('tbl_emp_non_id_cancel')
							->where('tbl_emp_non_id_cancel.emp_id', $emp_id)
							->select('tbl_emp_non_id_cancel.emp_id')
							->first();	
		if($info)
		{
			$status = 1;
		}
		else
		{
			$status = 0;
		}	
		return	$status; 	
	}
	
	public function non_id_cancel_insert_br(Request $request)
    {
		$data = request()->except(['_token','_method']);
		$emp_id = $request->input('emp_id');
		$validation_status = $this->validation($emp_id);
		if($validation_status == 1)
		{
			Session::put('message','This Employee Already Exit');
			return Redirect::to('/non-cancel/create');
		}
		
		$data['emp_type_code'] 	=  $request->emp_type;
		$data['created_by'] 	= Session::get('admin_id');
		$data['org_code'] 		= Session::get('admin_org_code');
		
		DB::beginTransaction();
		try {				
			DB::table('tbl_emp_non_id_cancel')->insert($data);
			DB::commit();
			Session::put('message','Data Saved Successfully');
		}catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		}

		return Redirect::to('/branch_staff_cancel');
    }
	

	public function non_id_cancel_br_update(Request $request)
    {	 
		$data = array();
		$id 						= $request->id;
		$data['cancel_date'] 		= $request->cancel_date;
		$data['cancel_by'] 			= $request->cancel_by;
		 
		DB::beginTransaction();
		try{				
			DB::table('tbl_emp_non_id_cancel')
				->where('id', $id)
				->update($data);
			DB::commit();
			Session::put('message','Data Updated Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Updated Data');
			DB::rollback();
		}
		return Redirect::to('/branch_staff_cancel');
    }
	public function non_id_branch_wise_staff($emp_type)
    {	 
		$br_code = Session::get('branch_code');
		$results 			= DB::table('tbl_emp_non_id')
									->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_emp_non_id.emp_id')
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
								  
									->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_nonid_official_info.br_code')
									->where('tbl_nonid_official_info.br_code', $br_code) 
									->where('tbl_emp_non_id.emp_type_code', $emp_type)
									->select('tbl_emp_non_id.emp_id','tbl_emp_non_id.emp_name','tbl_emp_non_id.emp_type_code','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.joining_date','tbl_nonid_official_info.br_code','tbl_emp_non_id_cancel.cancel_date','tbl_branch.branch_name') 
									->get();
   
	/* echo "<pre>";
	print_r($results);
	exit; */
	
	echo json_encode(array('data' => $results));
	
	}
	
	public function show($id)
	{
		echo $id;
	}
	
	
	public function non_id_cancel_br(Request $request)
    {       
		$columns = array( 
			0 =>'tbl_emp_non_id_cancel.id', 
			1 =>'tbl_emp_non_id_cancel.emp_id',
			2=> 'tbl_emp_non_id_cancel.type_name',
			3=> 'tbl_emp_non_id_cancel.br_code',
			4=> 'tbl_emp_non_id_cancel.cancel_date',
			5=> 'tbl_emp_non_id_cancel.cancel_by',
		);
		$br_code 		= Session::get('branch_code');
        $totalData 		= NonIdCancel_br::where('br_code',$br_code)->where('emp_type_code',5)->orwhere('emp_type_code',9)->count();
        $totalFiltered  = $totalData; 
        $limit 			= $request->input('length');
        $start 			= $request->input('start');
        $order 			= $columns[$request->input('order.0.column')];
        $dir 			= $request->input('order.0.dir');
          
        if(empty($request->input('search.value')))
        {            
            $results = NonIdCancel_br::leftjoin('tbl_emp_non_id', 'tbl_emp_non_id.emp_id', '=', 'tbl_emp_non_id_cancel.emp_id' )
							->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_emp_non_id_cancel.br_code' )
							->leftjoin('tbl_emp_type as et',function($join){
										$join->on('et.id', "=","tbl_emp_non_id_cancel.emp_type_code"); 
									})	
							->where('tbl_emp_non_id_cancel.br_code',13) 
							->where('tbl_emp_non_id_cancel.emp_type_code',5) 
							->orwhere('tbl_emp_non_id_cancel.emp_type_code',9) 
							->offset($start)
							->limit($limit)
							->orderBy('tbl_emp_non_id_cancel.emp_code', 'desc')
							->select('tbl_emp_non_id_cancel.id','tbl_emp_non_id_cancel.emp_id','tbl_emp_non_id_cancel.emp_code','tbl_emp_non_id_cancel.emp_type_code','tbl_emp_non_id_cancel.cancel_date','tbl_emp_non_id_cancel.cancel_by','tbl_branch.branch_name','tbl_emp_non_id.emp_name','et.type_name')
							->get();
        }
		
		else 
		{
            $search = $request->input('search.value'); 
            $results =  NonIdCancel_br::leftjoin('tbl_emp_non_id', 'tbl_emp_non_id.emp_id', '=', 'tbl_emp_non_id_cancel.emp_id' )
							->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_emp_non_id_cancel.br_code' )
							->leftjoin('tbl_emp_type as et',function($join){
										$join->on('et.id', "=","tbl_emp_non_id_cancel.emp_type_code"); 
									}) 
							->where('tbl_emp_non_id_cancel.br_code',13) 
							->where('tbl_emp_non_id_cancel.emp_code','LIKE',"%{$search}%")
							->orWhere('tbl_emp_non_id_cancel.emp_type_code', 'LIKE',"%{$search}%")
							->where('tbl_emp_non_id_cancel.emp_type_code',5) 
							->orwhere('tbl_emp_non_id_cancel.emp_type_code',9) 
                            ->offset($start)
                            ->limit($limit)
							->orderBy('tbl_emp_non_id_cancel.emp_code', 'desc')
							->select('tbl_emp_non_id_cancel.id','tbl_emp_non_id_cancel.emp_id','tbl_emp_non_id_cancel.emp_code','tbl_emp_non_id_cancel.emp_type_code','tbl_emp_non_id_cancel.cancel_date','tbl_emp_non_id_cancel.cancel_by','tbl_branch.branch_name','tbl_emp_non_id.emp_name','et.type_name')
                            ->get();
            $totalFiltered = NonIdCancel_br::where('br_code',$br_code)->where('emp_type_code',5)->orwhere('emp_type_code',9)->where('tbl_emp_non_id_cancel.emp_code','LIKE', "%{$search}%")->orWhere('tbl_emp_non_id_cancel.emp_type_code', 'LIKE',"%{$search}%")
                            ->count();
        }
       
	
        $data = array();
        if(!empty($results))
        {
            $i=1;
            foreach ($results as $result)
            {

			    $nestedData['id'] 				= $i++; 
				$nestedData['emp_id'] 		    = $result->emp_code; 
				$nestedData['emp_name'] 		= $result->emp_name; 
				$nestedData['type_name']   	 	= $result->type_name;  
                $nestedData['cancel_date'] 		= $result->cancel_date;    
				$nestedData['branch_name'] 		= $result->branch_name;
				$nestedData['cancel_by'] 		= $result->cancel_by;
				$nestedData['options'] 			= '<a class="btn btn-sm btn-success btn-xs" title="Edit" href="non_id_cancel_br_edit/'.$result->id.'"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
								
				$data[] = $nestedData;
            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                );
            
        echo json_encode($json_data); 
        
    }
	
	

	private function cheeck_action_permission($action_id)
	{
		$access_label 	= Session::get('admin_access_label');		
		$nav_name 		=  '/'.request()->segment(1);
		$nav_info		= DB::table('tbl_navbar')->where('nav_action',$nav_name)->first();	
		$nav_id 		= $nav_info->nav_id;
		$permission    	= DB::table('tbl_user_permissions')
							->where('user_role_id',$access_label)
							->where('nav_id',$nav_id)
							->where('status',1)
							->first();
		if($permission)
		{
			if(in_array($action_id,$p = explode(",", $permission->permission)))
			{
				return true;
			}
			else
			{
				return false;
			}
		}	
		else
		{
			return false;
		}
	}
}