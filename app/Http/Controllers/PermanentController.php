<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Permanent;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class PermanentController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		return view('admin.employee.manage_permanent');			
    }
	
	public function all_permanent(Request $request)
    {       
		$columns = array( 
			0 =>'tbl_permanent.id', 
			1 =>'tbl_permanent.emp_id',
			2 =>'tbl_appointment_info.emp_name',
			3 =>'tbl_permanent.sarok_no',
			4 =>'tbl_permanent.letter_date',
			5 =>'tbl_permanent.effect_date',
			6 =>'tbl_permanent.id',
		);
  
        $totalData = Permanent::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $permanents = Permanent::join('tbl_appointment_info', 'tbl_permanent.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->offset($start)
							->limit($limit)
							//->orderBy($order,$dir)
							->orderBy('tbl_permanent.letter_date', 'desc')
							->select('tbl_permanent.id','tbl_permanent.emp_id','tbl_permanent.sarok_no','tbl_permanent.letter_date','tbl_permanent.effect_date','tbl_permanent.status','tbl_appointment_info.emp_name')
							->get();
        }
        else {
            $search = $request->input('search.value'); 

            $permanents =  Permanent::join('tbl_appointment_info', 'tbl_permanent.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->where('tbl_permanent.emp_id', $search)
                            ->offset($start)
                            ->limit($limit)
                            //->orderBy($order,$dir)
							->orderBy('tbl_permanent.letter_date', 'desc')
							->select('tbl_permanent.id','tbl_permanent.emp_id','tbl_permanent.sarok_no','tbl_permanent.letter_date','tbl_permanent.effect_date','tbl_permanent.status','tbl_appointment_info.emp_name')
                            ->get();

            $totalFiltered = Permanent::join('tbl_appointment_info', 'tbl_permanent.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->where('tbl_permanent.emp_id', $search)
                             ->count();
        }

        $data = array();
        if(!empty($permanents))
        {
            $i=1;
            foreach ($permanents as $v_permanents)
            {
                $nestedData['id'] 			= $i++;
                $nestedData['emp_id'] 		= $v_permanents->emp_id;
                $nestedData['emp_name'] 	= $v_permanents->emp_name;
                $nestedData['sarok_no'] 	= $v_permanents->sarok_no;
                $nestedData['letter_date'] 	= $v_permanents->letter_date;
				$nestedData['effect_date'] 	= $v_permanents->effect_date;
				$nestedData['status'] 		= $v_permanents->status;
				$nestedData['options'] 		= '<a class="btn btn-sm btn-danger btn-xs" title="Edit" href="permanent/'.$v_permanents->id.'/edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';				
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

    public function create()
    {
		// SAVE = 2 
		$action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		//
		$data['action'] 				= '/save-transection';
		$data['action_table'] 			= 'tbl_permanent';
		$data['action_controller'] 		= 'permanent';
		$data['transection_type'] 		= 2;
		$data['Heading'] 				= 'Add Permanent';
		$data['button_text'] 			= 'Save';
		$data['designation_name'] 		= '';
		$data['branch_name'] 			= '';
		$data['emp_photo'] 				= 'default.png';
		$data['Heading'] 				= 'Add Permanent';
		$data['button_text'] 			= 'Save';	
		$data['is_permanent'] 			= 2;		
		//
		$data['id'] 					= '';
		$data['emp_id'] 				= '';		
		$data['emp_name'] 				= '';
		$data['joining_date'] 			= '';
		//
		$data['letter_date'] 			= date('Y-m-d');
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
		$todate 						= date('Y-m-d');
		$tomonth 						= date('m');
		$toyear 						= date('Y');
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
		//
		$data['steps'] 		    	= DB::table('tbl_steps')->where('step_status',1)->get();
		$data['branches'] 		    = DB::table('tbl_branch')->where('status',1)->get();
		$data['grades'] 		    = DB::table('tbl_grade_new')->where('status',1)->get();
		$data['departments'] 		= DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		= DB::table('tbl_designation')->where('status',1)->get();
		$data['reportable'] 		= DB::table('tbl_designation')->where('status',1)->where('is_reportable',1)->get();
		return view('admin.employee.permanent_form',$data);	

    }	

    public function edit($id)
    {
		//UPDATE = 3;
		$action_id = 3;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		$data = array();
		$permanent_info = DB::table('tbl_permanent')->where('id', $id)->first();
		$emp_id 						= $permanent_info->emp_id;
		$data['letter_date'] 			= $permanent_info->letter_date;
		$data['effect_date'] 			= $permanent_info->effect_date;
		$data['sarok_no'] 				= $permanent_info->sarok_no;
		$data['br_code'] 				= $permanent_info->br_code;
		$data['designation_code'] 		= $permanent_info->designation_code;
		$data['department_code'] 		= $permanent_info->department_code;
		$data['report_to'] 				= $permanent_info->report_to ;
		$data['grade_code'] 			= $permanent_info->grade_code;
		$data['grade_step'] 			= $permanent_info->grade_step;
		$data['grade_code_old'] 		= $permanent_info->grade_code;
		$data['grade_effect_date'] 		= $permanent_info->grade_effect_date;
		$data['next_increment_date'] 	= $permanent_info->next_increment_date;
		$data['status'] 				= $permanent_info->status;
		//
		$data['action'] 				= "/update-transection";
		$data['action_table'] 			= 'tbl_permanent';
		$data['action_controller'] 		= 'permanent';
		$data['transection_type'] 		= 2;
		$data['Heading'] 				= 'Edit Permanent';
		$data['button_text'] 			= 'Update';
		$data['is_permanent'] 			= 2;	
		$employee_info = DB::table('tbl_appointment_info')
				->leftjoin('tbl_permanent', 'tbl_permanent.emp_id', '=', 'tbl_appointment_info.emp_id')
				->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_permanent.designation_code')
				->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_appointment_info.joining_branch')
				->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_appointment_info.emp_id')
				->where('tbl_appointment_info.emp_id', $emp_id)
				->first();	
				
		$data['id'] 					= $id;
		$data['emp_id'] 				= $permanent_info->emp_id;		
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
		$data['steps'] 		    		= DB::table('tbl_steps')->where('step_status',1)->get();
		$data['branches'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['grades'] 		    	= DB::table('tbl_grade_new')->where('status',1)->get();	
		$data['departments'] 		    = DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		    = DB::table('tbl_designation')->get();
		$data['reportable'] 		    = DB::table('tbl_designation')->where('status',1)->where('is_reportable',1)->get();
		return view('admin.employee.permanent_form',$data);	
    }
	
    public function show($id)
    {
        return "Show".$id;
    }
	
    public function destroy($id)
    {
        echo 'Delete '.$id;
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
