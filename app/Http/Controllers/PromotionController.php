<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Promotion;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class PromotionController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		return view('admin.employee.manage_promotion');	
    }
	
	public function all_promotion(Request $request)
    {       
		$columns = array( 
			0 =>'tbl_promotion.id', 
			1 =>'tbl_promotion.emp_id',
			2 =>'tbl_appointment_info.emp_name',
			3=>'tbl_promotion.sarok_no',
			4=>'tbl_promotion.letter_date',
			5=>'tbl_promotion.effect_date',
			6=>'tbl_promotion.designation_code',
			7=>'tbl_promotion.br_code',
			8=>'tbl_promotion.grade_code',
			9=>'tbl_promotion.department_code',
			10=>'tbl_promotion.report_to',
			11=>'tbl_promotion.next_increment_date',
			12=>'tbl_promotion.id',
		);
  
        $totalData = Promotion::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $promotions = Promotion::leftjoin('tbl_emp_basic_info', 'tbl_promotion.emp_id', '=', 'tbl_emp_basic_info.emp_id' )
							->offset($start)
							->limit($limit)
							//->orderBy($order,$dir)
							->orderBy('tbl_promotion.letter_date', 'desc')
							->select('tbl_promotion.id','tbl_promotion.emp_id','tbl_promotion.sarok_no','tbl_promotion.letter_date','tbl_promotion.effect_date','tbl_promotion.status','tbl_emp_basic_info.emp_name_eng')
							->get();
        }
        else {
            $search = $request->input('search.value'); 

            $promotions =  Promotion::leftjoin('tbl_emp_basic_info', 'tbl_promotion.emp_id', '=', 'tbl_emp_basic_info.emp_id' )
							->where('tbl_promotion.emp_id', $search)
                            ->offset($start)
                            ->limit($limit)
                            //->orderBy($order,$dir)
							->orderBy('tbl_promotion.letter_date', 'desc')
							->select('tbl_promotion.id','tbl_promotion.emp_id','tbl_promotion.sarok_no','tbl_promotion.letter_date','tbl_promotion.effect_date','tbl_promotion.status','tbl_emp_basic_info.emp_name_eng')
                            ->get();

            $totalFiltered = Promotion::leftjoin('tbl_emp_basic_info', 'tbl_promotion.emp_id', '=', 'tbl_emp_basic_info.emp_id' )
							->where('tbl_promotion.emp_id', $search)
                             ->count();
        }

        $data = array();
        if(!empty($promotions))
        {
            $i=1;
            foreach ($promotions as $v_promotions)
            {
                $nestedData['id'] 			= $i++;
                $nestedData['emp_id'] 		= $v_promotions->emp_id;
                $nestedData['emp_name'] 	= $v_promotions->emp_name_eng;
                $nestedData['sarok_no'] 	= $v_promotions->sarok_no;
                $nestedData['letter_date'] 	= $v_promotions->letter_date;
				$nestedData['effect_date'] 	= $v_promotions->effect_date;
				$nestedData['status'] 		= $v_promotions->status;
				$nestedData['options'] 		= '<a class="btn btn-sm btn-danger btn-xs" title="Edit" href="promotion/'.$v_promotions->id.'/edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';				
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
	
	public function get_employee_info($emp_id)
	{
		$employee_info = DB::table('tbl_appointment_info')
						->join('tbl_designation', 'tbl_designation.id', '=', 'tbl_appointment_info.emp_designation')
						->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_appointment_info.joining_branch')
						->where('emp_id', $emp_id)
						->first();
		$data = array();
		if($employee_info)
		{
			$data['emp_id'] 				= $emp_id;
			$data['emp_name'] 				= $employee_info->emp_name;
			$data['joining_date'] 			= $employee_info->joined_date;
			$data['designation_code'] 		= $employee_info->emp_designation;
			$data['designation_name'] 		= $employee_info->designation_name;
			$data['department_code'] 		= $employee_info->emp_department;
			$data['report_to'] 				= $employee_info->reported_to;
			$data['br_code'] 				= $employee_info->joining_branch;
			$data['branch_name'] 			= $employee_info->branch_name;
		}else{
			$data['emp_id'] 				= $emp_id;
			$data['emp_name'] 				= '';
			$data['joining_date'] 			= '';
			$data['designation_code'] 		= '';
			$data['designation_name'] 		= '';
			$data['department_code'] 		= '';
			$data['report_to'] 				= '';
			$data['br_code'] 				= '';
			$data['branch_name'] 			= '';
		}
		return $data;
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
		$data['action_table'] 			= 'tbl_promotion';
		$data['action_controller'] 		= 'promotion';
		$data['transection_type'] 		= 4;
		$data['Heading'] 				= 'Add Promotion';
		$data['button_text'] 			= 'Save';
		$data['designation_name'] 		= '';
		$data['branch_name'] 			= '';
		//
		$data['id'] 					= '';
		$data['emp_id'] 				= '';		
		$data['emp_name'] 				= '';
		$data['joining_date'] 			= '';
		$data['is_permanent'] 			= '';
		//
		$data['letter_date'] 			= date('Y-m-d');
		$data['effect_date'] 			= date('Y-m-d');
		$data['br_joined_date'] 		= date('Y-m-d');
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
		$data['emp_photo'] 				= 'default.png';
		$data['promotion_type'] 		= 'Promotion';
		//
		$data['designation_name'] 		= '';
		$data['branch_name'] 			= '';
		$data['Heading'] 				= 'Add Promotion';
		$data['button_text'] 			= 'Save';
		//
		$data['steps'] 		    		= DB::table('tbl_steps')->where('step_status',1)->get();
		$data['branches'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['grades'] 		    	= DB::table('tbl_grade_new')->where('status',1)->get();
		$data['departments'] 		    = DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		//
		$data['reportable'] 		    = DB::table('tbl_designation')->where('status',1)->where('is_reportable',1)->get();
		return view('admin.employee.promotion_form',$data);	
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
		$promotion_info = DB::table('tbl_promotion')->where('id', $id)->first();
		$emp_id 						= $promotion_info->emp_id;
		$data['letter_date'] 			= $promotion_info->letter_date;
		$data['effect_date'] 			= $promotion_info->effect_date;
		$data['sarok_no'] 				= $promotion_info->sarok_no;
		$data['br_code'] 				= $promotion_info->br_code;
		$data['designation_code'] 		= $promotion_info->designation_code;
		$data['department_code'] 		= $promotion_info->department_code;
		$data['report_to'] 				= $promotion_info->report_to ;
		$data['grade_code'] 			= $promotion_info->grade_code;
		$data['grade_step'] 			= $promotion_info->grade_step;
		$data['grade_code_old'] 		= $promotion_info->grade_code;
		$data['grade_effect_date'] 		= $promotion_info->grade_effect_date;
		$data['next_increment_date'] 	= $promotion_info->next_increment_date;
		$data['promotion_type'] 		= $promotion_info->promotion_type;
		$data['status'] 				= $promotion_info->status;		
		//
		$data['action'] 				= "/update-transection";
		$data['action_table'] 			= 'tbl_promotion';
		$data['action_controller'] 		= 'promotion';
		$data['transection_type'] 		= 1;
		$data['Heading'] 				= 'Edit Promotion';
		$data['button_text'] 			= 'Update';
		//
		$employee_info = DB::table('tbl_appointment_info')
				->leftjoin('tbl_promotion', 'tbl_promotion.emp_id', '=', 'tbl_appointment_info.emp_id')
				->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_promotion.designation_code')
				->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_appointment_info.joining_branch')
				->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_appointment_info.emp_id')
				->where('tbl_appointment_info.emp_id', $emp_id)
				->first();	
		if(!empty($employee_info->emp_photo))
		{
			$data['emp_photo'] 			= $employee_info->emp_photo;
		}
		else
		{
			$data['emp_photo'] 			= 'default.png';
		}
		$data['id'] 					= $id;
		$data['emp_id'] 				= $employee_info->emp_id;		
		$data['emp_name'] 				= $employee_info->emp_name;
		$data['joining_date'] 			= $employee_info->joining_date;
		
		$data['br_joined_date'] 		= $promotion_info->br_joined_date;	
		
		$data['designation_name'] 		= $employee_info->designation_name;
		$data['branch_name'] 			= $employee_info->branch_name;
		$data['is_permanent'] 			= '';
		$data['steps'] 		    		= DB::table('tbl_steps')->where('step_status',1)->get();
		$data['branches'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['grades'] 		    	= DB::table('tbl_grade_new')->where('status',1)->get();	
		$data['departments'] 		    = DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		    = DB::table('tbl_designation')->get();
		$data['reportable'] 		    = DB::table('tbl_designation')->where('status',1)->where('is_reportable',1)->get();
		return view('admin.employee.promotion_form',$data);	
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
