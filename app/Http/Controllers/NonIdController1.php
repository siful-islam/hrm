<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\NonId;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class NonIdController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	public function index()
    {        	
		$data = array();
		return view('admin.employee.manage_non_id',$data);					
    }
	
	
	public function create()
    {
		$action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		$data = array();
		$data['id'] 				= '';
		$data['emp_id'] 			= $this->get_last_emp_id(); 
		$data['emp_name'] 				= '';
		$data['father_name'] 			= '';
		$data['mother_name'] 			= '';
		$data['birth_date'] 			= date('Y-m-d'); 	
		$data['nationality'] 			= 'Bangladeshi';
		$data['religion'] 				= '';
		$data['contact_num']			= '';
		$data['email'] 					= '';
		$data['national_id'] 			= '';
		$data['maritial_status'] 		= 'Married';
		$data['gender'] 				= 'male';
		$data['blood_group'] 			= '';
		$data['joining_date'] 			= date('Y-m-d'); 
		$data['present_add'] 			= '';
		$data['vill_road'] 				= '';
		$data['post_office'] 			= '';
		$data['district_code'] 			= '';
		$data['thana_code'] 			= '';
		$data['permanent_add'] 			= '';
		$data['last_education'] 		= '';
		$data['referrence_name'] 		= '';
		$data['nec_phone_num'] 			= '';
		$data['basic_salary'] 			= 0;
		$data['npa_a'] 					= 0;  
		$data['motor_a'] 				= 0;
		$data['mobile_a'] 				= 0;
		$data['gross_salary'] 			= 0;
		$data['br_code'] 				= '';
		$data['designation_code'] 		= '';
		$data['emp_type'] 				= '';
		$data['sacmo_id'] 				= '';
		$data['br_join_date'] 			= date('Y-m-d');
		$data['next_renew_date'] 		= date('Y-m-d',strtotime($data['joining_date'] . "+12 month"));   
		$data['pre_emp_id'] 			= '';
		$data['org_code'] 				= '181';
		//
		$data['action'] 			= '/non-appoinment';
		$data['method'] 			= 'POST';
		$data['method_control'] 	= ''; 		
		$data['Heading'] 			= 'Add Non ID';
		$data['button_text'] 		= 'Save';		
		//		
		$data['branches'] 		    = DB::table('tbl_branch')->where('status',1)->get();
		$data['districts'] 		    = DB::table('tbl_district')->where('status',1)->get();
		$data['thanas'] 		    = DB::table('tbl_thana')->where('status',1)->get();
		$data['departments'] 	    = DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		= DB::table('tbl_designation')->get();		
		//
		return view('admin.employee.non_id_form',$data);	
    }	
	
	
	public function get_last_emp_id()
	{
		$result = DB::table('tbl_emp_non_id')
			//->where('join_as',1)
			->max('emp_id');
		return $result+1;
	}	
	
	public function get_non_max($emp_type)
	{
		$result = DB::table('tbl_emp_non_id')
			->where('emp_type',$emp_type)
			->max('sacmo_id');
		return $result+1;
	}
	
	public function edit($id)
	{
		$action_id = 3;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}

		$data = array();
		$result = NonId::find($id);

		$data['id'] 					= $result->id;
		$data['emp_id'] 				= $result->emp_id;
		$data['emp_name'] 				= $result->emp_name;
		$data['father_name'] 			= $result->father_name;
		$data['mother_name'] 			= $result->mother_name;
		$data['birth_date'] 			= $result->birth_date;
		$data['nationality'] 			= $result->nationality;
		$data['religion'] 				= $result->religion;
		$data['contact_num']			= $result->contact_num;
		$data['email'] 					= $result->email;
		$data['national_id'] 			= $result->national_id;
		$data['maritial_status'] 		= $result->maritial_status;
		$data['gender'] 				= $result->gender;
		$data['blood_group'] 			= $result->blood_group;
		$data['joining_date'] 			= $result->joining_date;
		$data['present_add'] 			= $result->present_add;
		$data['vill_road'] 				= $result->vill_road;
		$data['post_office'] 			= $result->post_office;
		$data['district_code'] 			= $result->district_code;
		$data['thana_code'] 			= $result->thana_code;
		$data['permanent_add'] 			= $result->permanent_add;
		$data['last_education'] 		= $result->last_education;
		$data['referrence_name'] 		= $result->referrence_name;
		$data['nec_phone_num'] 			= $result->nec_phone_num;
		$data['basic_salary'] 			= $result->basic_salary;
		$data['npa_a'] 					= $result->npa_a;
		$data['motor_a'] 				= $result->motor_a;
		$data['mobile_a'] 				= $result->mobile_a;
		$data['gross_salary'] 			= $result->gross_salary;
		$data['br_code'] 				= $result->br_code;
		$data['designation_code'] 		= $result->designation_code;
		$data['emp_type'] 				= $result->emp_type;
		$data['sacmo_id'] 				= $result->sacmo_id;
		$data['pre_emp_id'] 			= $result->pre_emp_id;
		$data['br_join_date'] 			= $result->br_join_date;
		$data['next_renew_date'] 		= $result->next_renew_date;
		//
		$data['action'] 				= "/non-appoinment/$id";
		$data['method'] 				= 'POST';
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 		
		$data['Heading'] 				= 'Edit Employee Non Id';
		$data['button_text'] 			= 'Update';
		//	
		$data['branches'] 		   		= DB::table('tbl_branch')->where('status',1)->get();
		$data['districts'] 		   		= DB::table('tbl_district')->where('status',1)->get();
		$data['thanas'] 		   		= DB::table('tbl_thana')->where('status',1)->get();
		$data['departments'] 	   		= DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 			= DB::table('tbl_designation')->get();	
		//
		return view('admin.employee.non_id_form',$data);	
	}
	
	
	public function validation($emp_id)
	{
		$info = DB::table('tbl_emp_non_id')
							->where('tbl_emp_non_id.emp_id', $emp_id)
							->select('tbl_emp_non_id.emp_id')
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
	
	public function store(Request $request)
    {
		$data = request()->except(['_token','_method']);
		$emp_id = $request->input('emp_id');
		$validation_status = $this->validation($emp_id);
		if($validation_status == 1)
		{
			Session::put('message','This Employee Already Exit');
			return Redirect::to('/non-appoinment/create');
		}
		
		$data['created_by'] 	= Session::get('admin_id');
		$data['org_code'] 		 = Session::get('admin_org_code');
		
		DB::beginTransaction();
		try {				
			DB::table('tbl_emp_non_id')->insert($data);
			DB::commit();
			Session::put('message','Data Saved Successfully');
		}catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		}

		return Redirect::to('/non-appoinment');
    }
	
	
	
	
	public function update(Request $request, $id)
    {				

		$data = request()->except(['_token','_method']);		

		//Data Update 
		DB::beginTransaction();
		try{				
			DB::table('tbl_emp_non_id')
				->where('id', $id)
				->update($data);
			DB::commit();
			Session::put('message','Data Updated Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Updated Data');
			DB::rollback();
		}
		return Redirect::to('/non-appoinment');
    }
	
	public function show($id)
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
		
		$data = array();
		$result = NonId::find($id);

		$data['id'] 					= $result->id;
		$data['emp_id'] 				= $result->emp_id;
		$data['emp_name'] 				= $result->emp_name;
		$data['father_name'] 			= $result->father_name;
		$data['mother_name'] 			= $result->mother_name;
		$data['birth_date'] 			= $result->birth_date;
		$data['nationality'] 			= $result->nationality;
		$data['religion'] 				= $result->religion;
		$data['contact_num']			= $result->contact_num;
		$data['email'] 					= $result->email;
		$data['national_id'] 			= $result->national_id;
		$data['maritial_status'] 		= $result->maritial_status;
		$data['gender'] 				= $result->gender;
		$data['blood_group'] 			= $result->blood_group;
		$data['joining_date'] 			= $result->joining_date;
		$data['present_add'] 			= $result->present_add;
		$data['vill_road'] 				= $result->vill_road;
		$data['post_office'] 			= $result->post_office;
		$data['district_code'] 			= $result->district_code;
		$data['thana_code'] 			= $result->thana_code;
		$data['permanent_add'] 			= $result->permanent_add;
		$data['last_education'] 		= $result->last_education;
		$data['referrence_name'] 		= $result->referrence_name;
		$data['nec_phone_num'] 			= $result->nec_phone_num;
		$data['basic_salary'] 			= $result->basic_salary;
		$data['npa_a'] 					= $result->npa_a;
		$data['motor_a'] 				= $result->motor_a;
		$data['mobile_a'] 				= $result->mobile_a;
		$data['gross_salary'] 			= $result->gross_salary;
		$data['br_code'] 				= $result->br_code;
		$data['designation_code'] 		= $result->designation_code;
		$data['emp_type'] 				= $result->emp_type;
		$data['sacmo_id'] 				= $result->sacmo_id;
		$data['pre_emp_id'] 			= $result->pre_emp_id;
		$data['br_join_date'] 			= $result->br_join_date;
		$data['next_renew_date'] 		= $result->next_renew_date;
		//
		$data['action'] 				= "/non-appoinment/$id";
		$data['method'] 				= 'POST';
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 		
		$data['Heading'] 				= 'Edit Employee Non Id';
		$data['button_text'] 			= 'Update';
		//	
		$data['branches'] 		   		= DB::table('tbl_branch')->where('status',1)->get();
		$data['districts'] 		   		= DB::table('tbl_district')->where('status',1)->get();
		$data['thanas'] 		   		= DB::table('tbl_thana')->where('status',1)->get();
		$data['departments'] 	   		= DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 			= DB::table('tbl_designation')->where('status',1)->get();	
		//
		return view('admin.employee.non_id_form_view',$data);	
	}
	
	
	public function all_data(Request $request)
    {       
		$columns = array( 
			0 =>'tbl_emp_non_id.id', 
			1 =>'tbl_emp_non_id.sacmo_id',
			2 =>'tbl_emp_non_id.emp_type',
			3=> 'tbl_emp_non_id.joining_date',
			4=> 'tbl_emp_non_id.emp_name',
			5=> 'tbl_emp_non_id.father_name',
			6=> 'tbl_emp_non_id.designation_code',
			7=> 'tbl_emp_non_id.basic_salary',
			8=> 'tbl_emp_non_id.gross_salary',
		);
  
        $totalData 		= NonId::count();
        $totalFiltered  = $totalData; 
        $limit 			= $request->input('length');
        $start 			= $request->input('start');
        $order 			= $columns[$request->input('order.0.column')];
        $dir 			= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $results = NonId::leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_emp_non_id.br_code' )
							->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_emp_non_id.emp_id' )
							->select('tbl_emp_non_id.id','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.emp_type','tbl_emp_non_id.emp_name','tbl_emp_non_id.joining_date','tbl_branch.branch_name','tbl_emp_non_id.gross_salary','tbl_emp_non_id.contact_num','tbl_emp_non_id.next_renew_date','tbl_emp_non_id_cancel.cancel_date')
							->offset($start)
							->limit($limit)
							->orderBy('tbl_emp_non_id.sacmo_id', 'desc')
							->get();
        }
		
		else 
		{
            $search = $request->input('search.value'); 
            $results =  NonId::leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_emp_non_id.br_code' )
							->leftjoin('tbl_emp_non_id_cancel', 'tbl_emp_non_id_cancel.emp_id', '=', 'tbl_emp_non_id.emp_id' )
							->select('tbl_emp_non_id.id','tbl_emp_non_id.sacmo_id','tbl_emp_non_id.emp_type','tbl_emp_non_id.emp_name','tbl_emp_non_id.joining_date','tbl_branch.branch_name','tbl_emp_non_id.gross_salary','tbl_emp_non_id.contact_num','tbl_emp_non_id.next_renew_date','tbl_emp_non_id_cancel.cancel_date')
							->where('tbl_emp_non_id.sacmo_id','LIKE',"%{$search}%")
							->orWhere('tbl_emp_non_id.emp_type', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
							->orderBy('tbl_emp_non_id.sacmo_id', 'desc')
                            ->get();
            $totalFiltered = NonId::where('tbl_emp_non_id.sacmo_id','LIKE', "%{$search}%")->orWhere('tbl_emp_non_id.emp_type', 'LIKE',"%{$search}%")
                            ->count();
        }
       

        $data = array();
        if(!empty($results))
        {
            $i=1;
            foreach ($results as $result)
            {
				if($result->cancel_date == '')
				{
					$status = '<span style="color:green">Active</span>';
					$option = '<a class="btn btn-sm btn-success btn-xs" title="Edit" href="non-appoinment/'.$result->id.'/edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
								<a class="btn btn-sm btn-info btn-xs" title="Edit" href="view-non-id/'.$result->id.'"><i class="fa fa-eye"></i> View</a>';
				}
				else
				{
					$status = '<span style="color:red">Canceled</span>';
					$option = '<a class="btn btn-sm btn-info btn-xs" title="Edit" href="view-non-id/'.$result->id.'"><i class="fa fa-eye"></i> View</a>';
				}
				
				
				if($result->emp_type == 'non_id')
				{
					$type = 'OT';
				}
				elseif($result->emp_type == 'sacmo')
				{
					$type = 'CH';
				}
				elseif($result->emp_type == 'shs')
				{
					$type = 'SHS';
				}

			    $nestedData['id'] 				= $i++;
                $nestedData['sacmo_id'] 		= $result->sacmo_id; 
                $nestedData['emp_type'] 		= $type; 
				$nestedData['emp_name'] 		= $result->emp_name;
                $nestedData['joining_date'] 	= $result->joining_date;    
				$nestedData['br_code'] 			= $result->branch_name;
				$nestedData['gross_salary'] 	= $result->gross_salary;
                $nestedData['contact_num'] 		= $result->contact_num;             
                $nestedData['next_renew_date'] 	= $result->next_renew_date;                       
                $nestedData['status'] 			= $status;


				
				$nestedData['options'] 			= $option;			
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
