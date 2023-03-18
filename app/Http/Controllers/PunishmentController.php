<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Punishment;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class PunishmentController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		/*$data['punishment_info'] = Punishment::join('tbl_appointment_info', 'tbl_punishment.emp_id', '=', 'tbl_appointment_info.emp_id' )
									->orderBy('tbl_punishment_type.id', 'desc')
									->join('tbl_punishment_type', 'tbl_punishment_type.id', '=', 'tbl_punishment.punishment_type' ) 
									->select('tbl_punishment.id','tbl_punishment.emp_id','tbl_punishment.sarok_no','tbl_punishment.letter_date','tbl_punishment.status','tbl_appointment_info.emp_name','tbl_punishment_type.punishment_type')
									->get();*/
		return view('admin.employee.manage_punishment');			
    }
	
	public function all_punishment(Request $request)
    {       
		$columns = array( 
			0 =>'tbl_punishment.emp_id',
			1 =>'tbl_appointment_info.emp_name',
			2=>'tbl_punishment.sarok_no',
			3=>'tbl_punishment.letter_date',
			4=>'tbl_punishment_type.punishment_type',
			5=>'tbl_punishment.status',
			6 =>'tbl_punishment.id', 
		);
  
        $totalData = Punishment::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $punishments = Punishment::join('tbl_emp_basic_info', 'tbl_punishment.emp_id', '=', 'tbl_emp_basic_info.emp_id' )
							->leftjoin('tbl_punishment_type', 'tbl_punishment_type.id', '=', 'tbl_punishment.punishment_type' )
							->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_punishment.designation_code' )
							->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_punishment.br_code' )
							->offset($start)
							->limit($limit)
							->orderBy('tbl_punishment.letter_date', 'desc')
							->select('tbl_punishment.id','tbl_punishment.emp_id','tbl_punishment.sarok_no','tbl_punishment.letter_date','tbl_punishment_type.punishment_type','tbl_punishment.status','tbl_emp_basic_info.emp_name_eng','tbl_designation.designation_name','tbl_branch.branch_name')
							->get();
        }
        else {
            $search = $request->input('search.value'); 

            $punishments =  Punishment::join('tbl_emp_basic_info', 'tbl_punishment.emp_id', '=', 'tbl_emp_basic_info.emp_id' )
							->leftjoin('tbl_punishment_type', 'tbl_punishment_type.id', '=', 'tbl_punishment.punishment_type' )
							->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_punishment.designation_code' )
							->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_punishment.br_code' )
							->where('tbl_punishment.emp_id', $search)
                            ->offset($start)
                            ->limit($limit)
							->orderBy('tbl_punishment.letter_date', 'desc')
							->select('tbl_punishment.id','tbl_punishment.emp_id','tbl_punishment.sarok_no','tbl_punishment.letter_date','tbl_punishment_type.punishment_type','tbl_punishment.status','tbl_emp_basic_info.emp_name_eng','tbl_designation.designation_name','tbl_branch.branch_name')
                            ->get();

            $totalFiltered = Punishment::join('tbl_emp_basic_info', 'tbl_punishment.emp_id', '=', 'tbl_emp_basic_info.emp_id' )
							->join('tbl_punishment_type', 'tbl_punishment_type.id', '=', 'tbl_punishment.punishment_type' )
							->where('tbl_punishment.emp_id', $search)
                             ->count();
        }

        $data = array();
        if(!empty($punishments))
        {
            $i=1;
            foreach ($punishments as $v_punishments)
            {
                $nestedData['id'] 			= $i++; 
                $nestedData['emp_id'] 		= $v_punishments->emp_id;
                $nestedData['emp_name'] 	= $v_punishments->emp_name_eng;
                $nestedData['designation_name'] 	= $v_punishments->designation_name;
                $nestedData['branch_name'] 	= $v_punishments->branch_name;
				$nestedData['letter_date'] 	= $v_punishments->letter_date;
				$nestedData['punishment_type'] 		= $v_punishments->punishment_type;
				$nestedData['sarok_no'] 		= $v_punishments->sarok_no;
				$nestedData['options'] 		= '<a class="btn btn-sm btn-danger btn-xs" title="Edit" href="punishment/'.$v_punishments->id.'/edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';				
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
		$action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		$data = array();
		$data['action'] 				= '/punishment';
		$data['method_control'] 		= '';
		$data['method'] 				= 'POST';
		$data['id'] 					= '';
		$data['emp_id'] 				= '';		
		$data['emp_name'] 				= '';
		$data['joining_date'] 			= '';
		//
		$data['letter_date'] 			= date('Y-m-d');
		$data['sarok_no'] 				= 0;		
		$data['crime_id'] 				= '';
		$data['punishment_type'] 		= '';
		$data['punishment_details'] 	= '';
		$data['punishment_by'] 			= '';
		$data['designationy'] 			= '';
		$data['fine_amount']			= 0;
		$data['status'] 				= 1;
		$data['emp_photo'] 			= 'default.png';
		
		//
		$data['designation_name'] 		= '';
		$data['branch_name'] 			= '';
		$data['Heading'] 				= 'Add Punishment';
		$data['button_text'] 			= 'Save';
		//
		
		$data['br_code'] 				= '';
		$data['designation_code'] 		= '';
		$data['grade_code'] 			= '';
		$data['grade_step'] 			= '';
		$data['department_code'] 		= '';
		//
		$data['crimes'] 		    	= DB::table('tbl_crime')->where('status',1)->get();
		//$data['reportable'] 		    = DB::table('tbl_designation')->where('is_reportable',1)->where('status',1)->get();
		$data['reportable'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		$data['punishment_types'] 		= DB::table('tbl_punishment_type')->where('status',1)->get();
		return view('admin.employee.punishment_form',$data);	
    }
	

    public function store(Request $request)
    {
		$data = request()->except(['_token','_method']);

		$sarok_id = DB::table('tbl_sarok_no')->max('sarok_no');
		$data['sarok_no'] 		   		= $sarok_id+1;
		$data['created_by'] 	   		= Session::get('admin_id');
		$data['org_code'] 		   		= Session::get('admin_org_code');

		//insert for Sarok Data//
		$sarok_data['sarok_no']    		= $data['sarok_no'];
		$sarok_data['emp_id'] 	   		= $request->input('emp_id');
		$sarok_data['letter_date'] 		= $request->input('letter_date');
		$sarok_data['transection_type'] = 9;
		
		//FOR MASTER Table
			/*-------------*/
		//
		//Data Insert in Punishment Table
		$status = DB::table('tbl_punishment')->insertGetId($data);
		if($status)
		{	//Data Insert in Sarok Table
            DB::table('tbl_sarok_no')->insert($sarok_data);
			//Data Insert in Master Table
			//DB::table('tbl_master_tran')->insert($master_data);
			Session::put('message','Data Saved Successfully');
            return Redirect::to('/punishment');			
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
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
		$punishment_info = DB::table('tbl_punishment')->where('id', $id)->first();
		
		
		
		
		$emp_id 						= $punishment_info->emp_id;
		$data['letter_date'] 			= $punishment_info->letter_date;
		$data['sarok_no'] 				= $punishment_info->sarok_no;
		$data['crime_id'] 				= $punishment_info->crime_id;
		$data['punishment_details'] 	= $punishment_info->punishment_details;
		$data['punishment_by'] 			= $punishment_info->punishment_by;
		$data['designationy'] 			= $punishment_info->designationy;
		$data['fine_amount'] 			= $punishment_info->fine_amount;
		$data['status'] 				= $punishment_info->status;
		$data['grade_code'] 			= $punishment_info->grade_code;
		$data['grade_step'] 			= $punishment_info->grade_step;
		$data['department_code'] 		= $punishment_info->department_code;
		$data['designation_code'] 		= $punishment_info->designation_code;
		$data['br_code'] 				= $punishment_info->br_code;
		$data['punishment_type'] 		= $punishment_info->punishment_type;
		$data['Heading'] 				= 'Edit Punishment';
		$data['button_text'] 			= 'Update';
		
		$employee_info = DB::table('tbl_appointment_info')
				->leftjoin('tbl_punishment', 'tbl_punishment.emp_id', '=', 'tbl_appointment_info.emp_id')
				->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_punishment.designation_code')
				->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_appointment_info.joining_branch')
				->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_appointment_info.emp_id')
				->where('tbl_appointment_info.emp_id', $emp_id)
				->first();					

		$data['action'] 				= "/punishment/$id";
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />";
		$data['method'] 				= 'post';
		$data['id'] 					= $id;
		$data['emp_id'] 				= $punishment_info->emp_id;		
		$data['emp_name'] 				= $employee_info->emp_name;
		$data['joining_date'] 			= $employee_info->joining_date;
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
		$data['crimes'] 		    	= DB::table('tbl_crime')->where('status',1)->get();
		//$data['reportable'] 		    = DB::table('tbl_designation')->where('is_reportable',1)->where('status',1)->get();
		$data['reportable'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		$data['punishment_types'] 		= DB::table('tbl_punishment_type')->where('status',1)->get();
		return view('admin.employee.punishment_form',$data);	
    }
	
	
    public function show($id)
    {
        return "Show".$id;
    }
	
    public function update(Request $request, $id)
    {		
		$data = request()->except(['_token','_method']);
		$data['updated_by'] = Session::get('admin_id');
		$sarok_no 			= $request->input('sarok_no');
		//FOR MASTER Table
		/*--------*/
		//	
		$status = DB::table('tbl_punishment')
            ->where('id', $id)
            ->update($data);
		if($status)
		{
            //Update Master
			/*DB::table('tbl_master_tran')
            ->where('sarok_no', $sarok_no) 
            ->update($master_data);*/
			//Update Sarok
			DB::table('tbl_sarok_no')
            ->where('sarok_no', $sarok_no)
			->update(['letter_date' => $request->input('letter_date')]);
			Session::put('message','Data Updated Successfully');
            return Redirect::to('/punishment');			
		}
		else
		{
			Session::put('message','Error: Unable to Update Data');
		};
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
