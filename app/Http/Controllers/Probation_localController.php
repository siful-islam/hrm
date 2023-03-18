<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Probation;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class ProbationController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		return view('admin.employee.manage_probation');		
    }
	public function all_probation(Request $request)
    {       
		$columns = array( 
			0 =>'tbl_probation.id', 
			1 =>'tbl_probation.emp_id',
			2 =>'tbl_appointment_info.emp_name',
			3 =>'tbl_probation.sarok_no',
			4 =>'tbl_probation.letter_date',
			5 =>'tbl_probation.effect_date',
			6 =>'tbl_probation.id',
		);
  
        $totalData = Probation::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $probations = Probation::join('tbl_appointment_info', 'tbl_probation.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->offset($start)
							->limit($limit)
							->orderBy('tbl_probation.letter_date', 'desc')
							->select('tbl_probation.id','tbl_probation.emp_id','tbl_probation.sarok_no','tbl_probation.letter_date','tbl_probation.effect_date','tbl_probation.status','tbl_appointment_info.emp_name')
							->get();
        }
        else {
            $search = $request->input('search.value'); 
            $probations =  Probation::join('tbl_appointment_info', 'tbl_probation.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->where('tbl_probation.emp_id', $search)
                            ->offset($start)
                            ->limit($limit)
							->orderBy('tbl_probation.letter_date', 'desc')
							->select('tbl_probation.id','tbl_probation.emp_id','tbl_probation.sarok_no','tbl_probation.letter_date','tbl_probation.effect_date','tbl_probation.status','tbl_appointment_info.emp_name')
                            ->get();

            $totalFiltered = Probation::join('tbl_appointment_info', 'tbl_probation.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->where('tbl_probation.emp_id', $search)
                             ->count();
        }

        $data = array();
        if(!empty($probations))
        {
            $i=1;
            foreach ($probations as $v_probations)
            {
                $nestedData['id'] 			= $i++;
                $nestedData['emp_id'] 		= $v_probations->emp_id;
                $nestedData['emp_name'] 	= $v_probations->emp_name;
                $nestedData['sarok_no'] 	= $v_probations->sarok_no;
                $nestedData['letter_date'] 	= $v_probations->letter_date;
				$nestedData['effect_date'] 	= $v_probations->effect_date;
				$nestedData['status'] 		= $v_probations->status;
				$nestedData['options'] 		= '<a class="btn btn-sm btn-danger btn-xs" title="Edit" href="probation/'.$v_probations->id.'/edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';				
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
		// SAVE =2 
		$action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		$data = array();
		$data['action'] 				= '/save-transection';
		$data['action_table'] 			= 'tbl_probation';
		$data['action_controller'] 		= 'probation';
		$data['transection_type'] 		= 1;
		$data['Heading'] 				= 'Add Probation';
		$data['button_text'] 			= 'Save';
		$data['designation_name'] 		= '';
		$data['branch_name'] 			= '';		
		$data['id'] 					= '';
		$data['emp_id'] 				= '';		
		$data['emp_name'] 				= '';
		$data['joining_date'] 			= '';
		$data['emp_photo'] 				= 'default.png';
		//
		$data['letter_date'] 			= date('Y-m-d');
		$data['effect_date'] 			= date('Y-m-d');
		$data['br_joined_date'] 		= '';
		$data['sarok_no'] 				= 0;
		$data['br_code'] 				= '';
		$data['designation_code'] 		= '';
		$data['grade_code'] 			= '';
		$data['grade_step'] 			= '';
		$data['probation_time'] 		= 6;
		$data['department_code'] 		= '';
		$data['report_to'] 				= '' ;
		$data['next_permanent_date'] 	= date('Y-m-d',strtotime($data['effect_date'] . "+6 month"));
		$data['status'] 				= 1;
		//
		$data['steps'] 		    		= DB::table('tbl_steps')->where('step_status',1)->get();
		$data['branches'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['grades'] 		    	= DB::table('tbl_grade_new')->where('status',1)->get();								
		$data['departments'] 		    = DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		$data['reportable'] 		    = DB::table('tbl_designation')->where('status',1)->where('is_reportable',1)->get();
		return view('admin.employee.probation_form',$data);	
    }
	
    public function edit($id)
    {
		// UPDATE = 3
		$action_id = 3;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		$data = array();
		$probation_info = DB::table('tbl_probation')->where('id', $id)->first();
		$emp_id 						= $probation_info->emp_id;
		$data['letter_date'] 			= $probation_info->letter_date;
		$data['effect_date'] 			= $probation_info->effect_date;
		$data['sarok_no'] 				= $probation_info->sarok_no;
		$data['br_code'] 				= $probation_info->br_code;
		$data['designation_code'] 		= $probation_info->designation_code;
		$data['department_code'] 		= $probation_info->department_code;
		$data['report_to'] 				= $probation_info->report_to ;
		$data['grade_code'] 			= $probation_info->grade_code;
		$data['grade_step'] 			= $probation_info->grade_step;
		$data['probation_time'] 		= $probation_info->probation_time;
		$data['next_permanent_date'] 	= $probation_info->next_permanent_date;
		$data['status'] 				= $probation_info->status;
		$data['is_permanent'] 			= '';
		//
		$data['action'] 				= "/update-transection";
		$data['action_table'] 			= 'tbl_probation';
		$data['action_controller'] 		= 'probation';
		$data['transection_type'] 		= 1;
		$data['Heading'] 				= 'Edit Probation';
		$data['button_text'] 			= 'Update';
		$employee_info = DB::table('tbl_appointment_info')
				->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_appointment_info.emp_designation')
				->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_appointment_info.joining_branch')
				->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_appointment_info.emp_id')
				->where('tbl_appointment_info.emp_id', $emp_id)
				->first();				
				
		$data['id'] 					= $id;
		$data['emp_id'] 				= $emp_id;		
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
		return view('admin.employee.probation_form',$data);	
    }

	Private function cheeck_action_permission($action_id)
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
