<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Increment;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class IncrementController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data['increment_info'] = Increment::join('tbl_appointment_info', 'tbl_increment.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->orderBy('tbl_increment.id', 'desc')
							->select('tbl_increment.id','tbl_increment.emp_id','tbl_increment.sarok_no','tbl_increment.letter_date','tbl_increment.effect_date','tbl_increment.status','tbl_appointment_info.emp_name')
							->get();
		return view('admin.employee.manage_increment',$data);			
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
		
		$data['action'] 				= '/save-transection';
		$data['action_table'] 			= 'tbl_increment';
		$data['action_controller'] 		= 'increment';
		$data['transection_type'] 		= 3;
		$data['Heading'] 				= 'Add Increment';
		$data['button_text'] 			= 'Save';
		$data['designation_name'] 		= '';
		$data['branch_name'] 			= '';
		$data['emp_photo'] 				= 'default.png';
		//
		$data['id'] 					= '';
		$data['emp_id'] 				= '';		
		$data['emp_name'] 				= '';
		$data['joining_date'] 			= '';
		//
		$data['letter_date'] 			= date('Y-m-d');
		$data['effect_date'] 			= date('Y-m-d');
		$data['effect_date'] 			= date('Y-m-d');
		$data['br_joined_date'] 		= '';
		$data['sarok_no'] 				= 0;
		$data['br_code'] 				= '';
		$data['designation_code'] 		= '';
		$data['grade_code'] 			= '';
		$data['grade_step'] 			= '';
		$data['grade_code_old'] 		= '';
		$data['grade_effect_date'] 		= '';
		$data['department_code'] 		= '';
		$data['report_to'] 				= '' ;
		$data['is_permanent'] 			= '';
		$todate 		= date('Y-m-d');
		$tomonth 		= date('m');
		$toyear 		= date('Y');

		if($tomonth == '01' || $tomonth == '02' || $tomonth == '03' ||$tomonth == '04' ||$tomonth == '05' ||$tomonth == '06')
		{
			$next_year 		= $toyear;
		}
		else if($tomonth == '07' || $tomonth == '08' || $tomonth == '09' ||$tomonth == '10' ||$tomonth == '11' ||$tomonth == '12')
		{
			$next_year 		= $toyear+1;
		}
		$data['next_increment_date'] = $next_year.'-07-01';
		$data['status'] 				= 1;
		$data['increment_type'] 		= 'Increment';							
		$data['grades'] 		    	= DB::table('tbl_grade_new')->where('status',1)->get();
		$data['branches'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['departments'] 		    = DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		$data['reportable'] 		    = DB::table('tbl_designation')->where('status',1)->where('is_reportable',1)->get();
		return view('admin.employee.increment_form',$data);	
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
		$increment_info = DB::table('tbl_increment')->where('id', $id)->first();
		$emp_id 						= $increment_info->emp_id;
		$data['letter_date'] 			= $increment_info->letter_date;
		$data['effect_date'] 			= $increment_info->effect_date;
		$data['sarok_no'] 				= $increment_info->sarok_no;
		$data['br_code'] 				= $increment_info->br_code;
		$data['designation_code'] 		= $increment_info->designation_code;
		$data['department_code'] 		= $increment_info->department_code;
		$data['report_to'] 				= $increment_info->report_to ;
		$data['grade_code'] 			= $increment_info->grade_code;
		$data['grade_code_old'] 		= $increment_info->grade_code;
		$data['grade_step'] 			= $increment_info->grade_step;
		$data['grade_effect_date'] 		= $increment_info->grade_effect_date;
		$data['next_increment_date'] 	= $increment_info->next_increment_date;
		$data['increment_type'] 		= $increment_info->increment_type;
		$data['status'] 				= $increment_info->status;
		$data['is_permanent'] 			= '';
		//
		
		$data['action'] 				= "/update-transection";
		$data['action_table'] 			= 'tbl_increment';
		$data['action_controller'] 		= 'increment';
		$data['transection_type'] 		= 3;
		$data['Heading'] 				= 'Edit Increment';
		$data['button_text'] 			= 'Update';
		
		//
		/*$employee_info = DB::table('tbl_appointment_info')
						->join('tbl_designation', 'tbl_designation.id', '=', 'tbl_appointment_info.emp_designation')
						->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_appointment_info.joining_branch')
						->where('emp_id', $emp_id)
						->first();*/
						
						
						
		$employee_info = DB::table('tbl_appointment_info')
				->leftjoin('tbl_increment', 'tbl_increment.emp_id', '=', 'tbl_appointment_info.emp_id')
				->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_increment.designation_code')
				->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_appointment_info.joining_branch')
				->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_appointment_info.emp_id')
				->where('tbl_appointment_info.emp_id', $emp_id)
				->first();					
						
						
						
						
						
						
		$data['id'] 					= $id;
		$data['emp_id'] 				= $employee_info->emp_id;		
		$data['emp_name'] 				= $employee_info->emp_name;
		$data['joining_date'] 			= $employee_info->joining_date;
		$data['br_joined_date'] 		= $employee_info->joining_date;
		$data['designation_name'] 		= $employee_info->designation_name;
		$data['branch_name'] 			= $employee_info->branch_name;
		if(!empty($employee_info->emp_photo))
		{
			$data['emp_photo'] 			= $employee_info->emp_photo;
		}
		else
		{
			$data['emp_photo'] 			= 'default.png';
		}
		//
		$data['branches'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['grades'] 		    	= DB::table('tbl_grade_new')->where('status',1)->get();	
		$data['departments'] 		    = DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		    = DB::table('tbl_designation')->get();
		$data['reportable'] 		    = DB::table('tbl_designation')->where('status',1)->where('is_reportable',1)->get();
		return view('admin.employee.increment_form',$data);	
    }
	
	
    public function show($id)
    {
        return "Show".$id;
    }
	

    public function destroy($id)
    {
        echo 'Delete '.$id;
    }
	
	public function all_increment(Request $request)
    {       
		$columns = array( 
			0 =>'tbl_increment.emp_id',
			1 =>'tbl_appointment_info.emp_name',
			2 =>'tbl_increment.sarok_no',
			3 =>'tbl_increment.letter_date',
			4 =>'tbl_increment.effect_date',
			5 =>'tbl_increment.id',
			6 =>'tbl_increment.emp_id',
		);
  
        $totalData = Increment::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $increments = Increment::leftjoin('tbl_emp_basic_info', 'tbl_increment.emp_id', '=', 'tbl_emp_basic_info.emp_id' )
							->offset($start)
							->limit($limit)
							//->orderBy($order,$dir)
							->orderBy('tbl_increment.letter_date', 'desc')
							->select('tbl_increment.id','tbl_increment.emp_id','tbl_increment.sarok_no','tbl_increment.letter_date','tbl_increment.effect_date','tbl_increment.status','tbl_emp_basic_info.emp_name_eng')
							->get();
        }
        else {
            $search = $request->input('search.value'); 

            $increments =  Increment::leftjoin('tbl_emp_basic_info', 'tbl_increment.emp_id', '=', 'tbl_emp_basic_info.emp_id' )
							->where('tbl_increment.emp_id', $search)
                            ->offset($start)
                            ->limit($limit)
							//->orderBy($order,$dir)
							->orderBy('tbl_increment.letter_date', 'desc')
							->select('tbl_increment.id','tbl_increment.emp_id','tbl_increment.sarok_no','tbl_increment.letter_date','tbl_increment.effect_date','tbl_increment.status','tbl_emp_basic_info.emp_name_eng')
                            ->get();

            $totalFiltered = Increment::leftjoin('tbl_emp_basic_info', 'tbl_increment.emp_id', '=', 'tbl_emp_basic_info.emp_id' )
							->where('tbl_increment.emp_id', $search)
                            ->count();
        }

        $data = array();
        if(!empty($increments))
        {
            $i=1;
            foreach ($increments as $v_increments)
            {
                $nestedData['id'] 			= $i++;
                $nestedData['emp_id'] 		= $v_increments->emp_id;
                $nestedData['emp_name'] 	= $v_increments->emp_name_eng;
                $nestedData['sarok_no'] 	= $v_increments->sarok_no;
                $nestedData['letter_date'] 	= $v_increments->letter_date;
				$nestedData['effect_date'] 	= $v_increments->effect_date;
				$nestedData['status'] 		= $v_increments->status;
				//$nestedData['options'] 		= '<a class="btn btn-sm btn-danger btn-xs" title="Edit" href="increment/'.$v_increments->id.'/edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';				
				$nestedData['options'] 		= '<a class="btn btn-sm btn-danger btn-xs" title="Lock" href="#"><i class="glyphicon glyphicon-lock"></i></a>';				
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
	
	
	
	/*-----------------------*/
	
	public function generate_increment()
	{
		$data = array();
		$data['action'] 			= '/save_increment';
		$data['search_month'] 		= '07';
		$current_year 				= date('Y');
		$data['search_year'] 		= date('Y',strtotime($current_year . "+1 year")); 
		$data['type'] 				= 'Increment';
		$data['all_branches'] 		= DB::table('tbl_branch')->where('status',1)->get();
		$data['increment_employes']	= '';
		$info = array();
		$data['info'] = ''; 
		return view('admin.employee.generate_increment',$data);	
	}
	
	public function search_increment_employee(Request $request)
	{
		$data = array();
		$search_month 			= $request->input('search_month');
		$search_year 			= $request->input('search_year');
		$search_branch 			= $request->input('search_branch');
		$type 					= $request->input('type');		
		$data['search_month'] 	= $search_month;
		$data['search_year'] 	= $search_year;
		$current_year 			= date('Y');
		$next_year 				= date('Y',strtotime($current_year . "+2 year")); 
		
		$data['next_increment_date'] 	= $next_year.'-'.$search_month.'-'.'01';
		$data['increment_type'] 		= $request->input('type');
		$data['type'] 					= $type;
		
		
		$max_next_increment_date = DB::table('tbl_master_tran')
                ->select(DB::raw('MAX(tbl_master_tran.id) as id'),'tbl_master_tran.emp_id', DB::raw('MAX(tbl_master_tran.next_increment_date) as max_next_increment_date'))
				->where('tbl_master_tran.is_permanent',2)	
                ->groupBy('tbl_master_tran.emp_id')
                ->get();
				
		$info = array();
		
		$data['info'] = ''; 
				
		foreach($max_next_increment_date as $v_max_next_increment_date)
		{
			$id 		=  $v_max_next_increment_date->id;
			$emp_id 	=  $v_max_next_increment_date->emp_id;
			$max_month 	= date("m",strtotime($v_max_next_increment_date->max_next_increment_date));
			$max_year 	= date("Y",strtotime($v_max_next_increment_date->max_next_increment_date));
			
			if($max_month == $search_month && $max_year == $search_year)
			{
				//echo $emp_id.'************'.$id;
				//echo '<br>';
				$data['info']  = DB::table('tbl_master_tran')
							->join('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'tbl_master_tran.emp_id')
							->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_master_tran.br_code')
							->join('tbl_grade', 'tbl_grade.id', '=', 'tbl_master_tran.grade_code')
							->join('tbl_scale', 'tbl_scale.scale_id', '=', 'tbl_grade.scale_id')
							->where('tbl_master_tran.id',$id)										
							->select('tbl_master_tran.*','tbl_emp_basic_info.emp_name_eng','tbl_emp_basic_info.org_join_date','tbl_branch.branch_name','tbl_grade.grade_name','tbl_scale.scale_basic_1st_step','tbl_scale.increment_amount')
							->get();
							
			}
		}
		

		$data['action'] 		= '/save-increment';
		$data['all_branches'] 	= DB::table('tbl_branch')->where('status',1)->get();
		return view('admin.employee.generate_increment',$data);		
		
	}
	
	public function save_increment(Request $request)
	{
		$data = array();
		$check_id 	= $request->input('check_id');
		

		if(!empty($check_id)){ 
		foreach($check_id as $cnt) 
		{
			$sarok_id = DB::table('tbl_sarok')->max('sarok_no');
			$save_data = array();
			$save_data['letter_date'] 			= $request->input('letter_date');
			$save_data['effect_date'] 			= $request->input('effect_date');
			$designation_code 					= $request->input('designation_code');
			$br_code 							= $request->input('br_code');
			$grade_code							= $request->input('grade_code');
			$grade_step							= $request->input('grade_step');
			$department_code 					= $request->input('department_code');
			$report_to							= $request->input('report_to');
			$increment_type 					= $request->input('increment_type');
			$is_permanent 						= $request->input('is_permanent');
			$br_joined_date 					= $request->input('br_joined_date');
			$status								= $request->input('status');
			$save_data['created_by'] 			= Session::get('admin_id');
			$save_data['updated_by'] 			= Session::get('admin_id');
			$save_data['org_code'] 		  		= Session::get('admin_org_code');
			$save_data['sarok_no'] 		   		= $sarok_id+1;
			$emp_id 							= $request->input('emp_id');
			$next_increment_date 				= $request->input('next_increment_date');
			$save_data['emp_id'] 	 		 	= $emp_id[$cnt];	
			$save_data['next_increment_date']	= $next_increment_date[$cnt];
			$save_data['next_increment_date']	= $next_increment_date[$cnt];
			$save_data['br_joined_date']		= $br_joined_date[$cnt];
			$save_data['designation_code']		= $designation_code[$cnt];
			$save_data['br_code']				= $br_code[$cnt];
			$save_data['grade_code']			= $grade_code[$cnt];
			$save_data['grade_step']			= $grade_step[$cnt]+1;
			$save_data['department_code']		= $department_code[$cnt];
			$save_data['report_to']				= $report_to[$cnt];
			$save_data['increment_type']		= $increment_type[$cnt];
			$save_data['is_permanent']			= $is_permanent[$cnt];
			$save_data['status']				= $status[$cnt];

			// START SALARY

			//$scale_basic_1st_step 			= $request->input('scale_basic_1st_step');
			//$increment_amount 				= $request->input('increment_amount');
			//$salary_data['scale_basic_1st_step']= $scale_basic_1st_step[$cnt];
			//$salary_data['increment_amount']	= $increment_amount[$cnt];
			
			$basic_salary 				= $request->input('basic_salary');
			$salary_data['emp_id']		= $emp_id[$cnt];	
			$salary_data['effect_date']	= $request->input('effect_date');
			$salary_data['transection']	= 3;
			$salary_data['salary_basic']= $basic_salary[$cnt];
			if($save_data['br_code'] == 0)
			{
				$ho_bo = 0;
			}else{
				$ho_bo = 1;
			}
			
			
			//$plus_items 	= DB::table('tbl_salary_plus')->where('status',1)->where('ho_bo',$ho_bo)->get();
			//$minus_items 	= DB::table('tbl_salary_minus')->where('status',1)->where('ho_bo',$ho_bo)->get();	
			
			/*
			$plus_items 		= DB::table('tbl_salary_plus')
										->where('active_from', '<=', $save_data['effect_date'])
										->where('active_upto', '>=', $save_data['effect_date'])
										->where('status',1)
										->where('ho_bo',$ho_bo)
										->orwhere('ho_bo',2)
										->orwhere('designation_for',$save_data['designation_code'])
										->get();
										
			$minus_items		= DB::table('tbl_salary_minus')
										->where('active_from', '<=', $save_data['effect_date'])
										->where('active_upto', '>=', $save_data['effect_date'])
										->where('status',1)
										->where('ho_bo',$ho_bo)
										->orwhere('ho_bo',2)
										->orwhere('designation_for',$save_data['designation_code'])
										->get();
										
			*/
										
			$plus_items 		= DB::table('tbl_salary_plus')
											->where([
											['active_from', '<=', $save_data['effect_date']],
											['active_upto', '>=', $save_data['effect_date']],
											['status', '=', 1],
											['ho_bo', '=', $ho_bo],
											['designation_for', '=', $save_data['designation_code']],
											['epmloyee_status', '=', $is_permanent]
											])
											->orwhere([
											['active_from', '<=', $save_data['effect_date']],
											['active_upto', '>=', $save_data['effect_date']],
											['status', '=', 1],
											['ho_bo', '=', $ho_bo],
											['designation_for', '=', 0],
											['epmloyee_status', '=', 0]
											])
											->orwhere([
											['active_from', '<=', $save_data['effect_date']],
											['active_upto', '>=', $save_data['effect_date']],
											['status', '=', 1],
											['ho_bo', '=', 2],
											['designation_for', '=', $save_data['designation_code']],
											['epmloyee_status', '=', 0]
											])
											->orwhere([
											['active_from', '<=', $save_data['effect_date']],
											['active_upto', '>=', $save_data['effect_date']],
											['status', '=', 1],
											['ho_bo', '=', 2],
											['designation_for', '=', 0],
											['epmloyee_status', '=', $is_permanent]
											])
											->orwhere([
											['active_from', '<=', $save_data['effect_date']],
											['active_upto', '>=', $save_data['effect_date']],
											['status', '=', 1],
											['ho_bo', '=', 2],
											['designation_for', '=', 0],
											['epmloyee_status', '=', 0]
											])
											->get();
											
							
											
											
			$minus_items 		= DB::table('tbl_salary_minus')
											->where([
											['active_from', '<=', $save_data['effect_date']],
											['active_upto', '>=', $save_data['effect_date']],
											['status', '=', 1],
											['ho_bo', '=', $ho_bo],
											['designation_for', '=', $save_data['designation_code']],
											['epmloyee_status', '=', $is_permanent]
											])
											->orwhere([
											['active_from', '<=', $save_data['effect_date']],
											['active_upto', '>=', $save_data['effect_date']],
											['status', '=', 1],
											['ho_bo', '=', $ho_bo],
											['designation_for', '=', 0],
											['epmloyee_status', '=', 0]
											])
											->orwhere([
											['active_from', '<=', $save_data['effect_date']],
											['active_upto', '>=', $save_data['effect_date']],
											['status', '=', 1],
											['ho_bo', '=', 2],
											['designation_for', '=', $save_data['designation_code']],
											['epmloyee_status', '=', 0]
											])
											->orwhere([
											['active_from', '<=', $save_data['effect_date']],
											['active_upto', '>=', $save_data['effect_date']],
											['status', '=', 1],
											['ho_bo', '=', 2],
											['designation_for', '=', 0],
											['epmloyee_status', '=', $is_permanent]
											])
											->orwhere([
											['active_from', '<=', $save_data['effect_date']],
											['active_upto', '>=', $save_data['effect_date']],
											['status', '=', 1],
											['ho_bo', '=', 2],
											['designation_for', '=', 0],
											['epmloyee_status', '=', 0]
											])
											->get();							
										
											
											
			$total_plus      = 0;
			foreach($plus_items as $plus_item)
			{
				$plus_item_id[] = $plus_item->id;
				if($plus_item->type == 2)
				{
					$plus_taka = $plus_item->fixed_amount;
				}
				else
				{
					$plus_taka = round(($salary_data['salary_basic']*$plus_item->percentage)/100);
				}
				//$plus_taka		= round(($salary_data['salary_basic']*$plus_item->percentage)/100);
				$plus_amount[]	= $plus_taka; 
				$total_plus		= $total_plus + $plus_taka;
			}
			$total_minus      = 0;
			foreach($minus_items as $minus_item)
			{
				$minus_item_id[] 	= $minus_item->id;
				if($minus_item->type == 2)
				{
					$minus_taka = $minus_item->fixed_amount;
				}
				else
				{
					$minus_taka = round(($salary_data['salary_basic']*$minus_item->percentage)/100);
				}
				
				//$minus_taka			= round(($salary_data['salary_basic']*$minus_item->percentage)/100);
				
				$minus_amount[]		= $minus_taka; 
				$total_minus		= $total_minus + $minus_taka;
			}
			//
			
			
			
			$salary_data['plus_item_id'] = implode(",", $plus_item_id);   
			$salary_data['plus_item'] 	 = implode(",", $plus_amount);  
			$salary_data['minus_item_id']= implode(",", $minus_item_id);  
			$salary_data['minus_item'] 	 = implode(",", $minus_amount);  
			$salary_data['total_plus'] 	 = $total_plus;   
			$salary_data['payable'] 	 = ($salary_data['salary_basic'] + $total_plus);  
			$salary_data['total_minus']	 = $total_minus;   
			$salary_data['net_payable']	 = $salary_data['payable'] - $total_minus;   
			//
			$salary_data['created_by'] 	 = Session::get('admin_id');
			$salary_data['updated_by'] 	 = Session::get('admin_id');
			$salary_data['org_code'] 	 = Session::get('admin_org_code');
			//
			//END SALARY

			//SET SAROK TABLE//
			$sarok_data['sarok_no']    			= $save_data['sarok_no'];
			$sarok_data['emp_id'] 	   			= $save_data['emp_id'];
			$sarok_data['letter_date'] 			= $save_data['letter_date'];
			$sarok_data['transection_type'] 	= 3;
			
			//SET FOR MASTER Table
			$master_data['emp_id'] 				= $save_data['emp_id'];
			$master_data['sarok_no'] 			= $save_data['sarok_no'];
			$master_data['transection_type']	= 3;
			$master_data['letter_date'] 		= $request->input('letter_date');
			$master_data['effect_date'] 		= $request->input('effect_date');
			$master_data['br_joined_date'] 		= $save_data['br_joined_date'];  
			$master_data['next_increment_date'] = $save_data['next_increment_date'];
			$master_data['designation_code']	= $save_data['designation_code'];
			$master_data['br_code'] 			= $save_data['br_code'];
			$master_data['grade_code'] 			= $save_data['grade_code'];
			$master_data['grade_step'] 			= $save_data['grade_step'];
			$master_data['department_code'] 	= $save_data['department_code'];
			$master_data['report_to'] 			= $save_data['report_to'];
			$master_data['is_permanent'] 		= 1;
			$master_data['status'] 				= $save_data['status'];
			$master_data['created_by'] 			= $save_data['created_by'];
			$master_data['updated_by'] 			= $save_data['updated_by'];
			$master_data['org_code'] 			= $save_data['org_code'];
			$master_data['basic_salary'] 		= $salary_data['salary_basic'];
			
			echo '<pre>';	
			print_r($salary_data);
			exit;

			//////////////////////////////////////////////////////////////////////////////*****//////////////////////////////////////////////////////////////////////////

			//INSERT DATA USING TRANSACTION
			DB::beginTransaction();
			try {				
				//INSERT INTO TRANSACTION TABLE
				DB::table('tbl_increment')->insertGetId($save_data);
				//INSERT INTO SAROK TABLE
				DB::table('tbl_sarok')->insert($sarok_data);
				//INSERT INTO MASTER TABLE
				DB::table('tbl_master_tran')->insert($master_data);
				//INSERT INTO SALARY TABLE
				DB::table('tbl_emp_salary')->insert($salary_data);
				//COMMIT DB
				DB::commit();
				//PUSH SUCCESS MESSAGE
				Session::put('message','Data Saved Successfully');
			} catch (\Exception $e) {
				//PUSH FAIL MESSAGE
				Session::put('message','Error: Unable to Save Data');
				//DB ROLLBACK
				DB::rollback();
			}

			//echo '<pre>';
			//print_r($salary_data);
			//exit;

		}}else{
			Session::put('message','Error: No Employee Selected for Increment');
		}
		
		return Redirect::to('/increment');	
	}
	

	
	/*----------------------*/

	
	
}
