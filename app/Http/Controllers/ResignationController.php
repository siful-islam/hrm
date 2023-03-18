<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Resignation;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class ResignationController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {  
		$session_branch_code = Session::get('branch_code');
		
		$data['resignation_info'] = Resignation::join('tbl_emp_basic_info', 'tbl_resignation.emp_id', '=', 'tbl_emp_basic_info.emp_id' )
							->where(function($query) use ($session_branch_code) {
											if($session_branch_code !=9999) {
												$query->Where('tbl_resignation.br_code', $session_branch_code);
											}
										})
							->orderBy('tbl_resignation.id', 'desc')
							->select('tbl_resignation.id','tbl_resignation.designation_code','tbl_resignation.emp_id','tbl_resignation.sarok_no','tbl_resignation.letter_date','tbl_resignation.effect_date','tbl_emp_basic_info.emp_name_eng')
							->orderBy('tbl_resignation.id', 'desc')
							->get(); 
		return view('admin.employee.manage_resignation',$data);					
    }
	


    public function create()
    {
		$data = array();
		$data['action'] 				= '/resignation';
		$data['method_control'] 		= "";
		$data['method'] 				= 'post';
		$data['id'] 					= '';
		$data['emp_id'] 				= '';		
		$data['emp_name'] 				= '';
		$data['joining_date'] 			= '';
		
		$data['grade_code'] 			= '';
		$data['grade_step'] 			= '';
		$data['department_code'] 		= '';
		$data['designation_code'] 		= '';
		$data['br_code'] 				= '';
		//
		$data['letter_date'] 			= date('Y-m-d');
		$data['effect_date'] 			= date('Y-m-d');
		$data['sarok_no'] 				= 0;
		$data['resignation_by'] 		= 'Self';
		//
		$data['designation_name'] 		= '';
		$data['branch_name'] 			= '';
		$data['Heading'] 				= 'Add Resignation';
		$data['button_text'] 			= 'Save';
		//
		return view('admin.employee.resignation_form',$data);	
    }
	

    public function store(Request $request)
    {
	   $data = request()->except(['_token','_method']);
		//Validation
		$this->validate($request, [
        'emp_id' => 'required|unique:tbl_resignation',
        'letter_date' => 'required',
		]);
		
		$sarok_id = DB::table('tbl_sarok_no')->max('sarok_no');
		$data['sarok_no'] 		   = $sarok_id+1;
		$data['created_by'] 	   = Session::get('admin_id');
		$data['org_code'] 		   = Session::get('admin_org_code');
		
		//insert for Sarok Data//
		$sarok_data['sarok_no']    = $data['sarok_no'];
		$sarok_data['emp_id'] 	   = $request->input('emp_id');
		$sarok_data['letter_date'] = $request->input('letter_date');
		$sarok_data['transection_type'] = 7;

		// SAVE 
		DB::beginTransaction();
		try {				
			DB::table('tbl_resignation')->insertGetId($data);
			DB::table('tbl_sarok_no')->insert($sarok_data);
			DB::commit();
			Session::put('message','Data Saved Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Save Data');
			DB::rollback();
		}
		
		return Redirect::to('/resignation');	
		
    }

    public function edit($id)
    {
		$data = array();
		$resignation_info = DB::table('tbl_resignation')->where('id', $id)->first();
		$emp_id 						= $resignation_info->emp_id;
		$data['letter_date'] 			= $resignation_info->letter_date;
		$data['effect_date'] 			= $resignation_info->effect_date;
		$data['sarok_no'] 				= $resignation_info->sarok_no;
		$data['resignation_by'] 		= $resignation_info->resignation_by;
		$data['status'] 				= $resignation_info->status;
		$data['grade_code'] 			= $resignation_info->grade_code;
		$data['grade_step'] 			= $resignation_info->grade_step;
		$data['department_code'] 		= $resignation_info->department_code;
		$data['designation_code'] 		= $resignation_info->designation_code;
		$data['br_code'] 				= $resignation_info->br_code;
		$data['Heading'] 				= 'Edit Resignation';
		$data['button_text'] 			= 'Update';
		//
		$employee_info = DB::table('tbl_appointment_info')
						->join('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_appointment_info.emp_designation')
						->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_appointment_info.joining_branch')
						->where('emp_id', $emp_id)
						->first();
		$data['action'] 				= "/resignation/$id";
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />";
		$data['method'] 				= 'post';
		$data['id'] 					= $id;
		$data['emp_id'] 				= $employee_info->emp_id;		
		$data['emp_name'] 				= $employee_info->emp_name;
		$data['joining_date'] 			= $employee_info->joining_date;
		$data['designation_name'] 		= $employee_info->designation_name;
		$data['branch_name'] 			= $employee_info->branch_name;
		//
		/*$data['branches'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['grades'] 		    	= DB::table('tbl_grade')->where('status',1)->get();
		$data['departments'] 		    = DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		    = DB::table('tbl_designation')->where('status',1)->get();*/
		return view('admin.employee.resignation_form',$data);	
    }
	
	public function update(Request $request, $id)
	{
		$data = request()->except(['_token','_method']);
		$data['updated_by'] = Session::get('admin_id');
		$sarok_no 			= $request->input('sarok_no');
		$sarok_data['letter_date'] 	= $request->input('letter_date');
		
		
		//echo '<pre>';
		//print_r($data);
		//exit;
		
		
		
		
		DB::beginTransaction();
		try {				
			DB::table('tbl_resignation')
            ->where('id', $id)
            ->update($data);

			DB::table('tbl_sarok_no')
            ->where('sarok_no', $sarok_no)
            ->update($sarok_data);
			//
			DB::commit();
			Session::put('message','Data Updated Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Updated Data');
			DB::rollback();
		}
		
		return Redirect::to('/resignation');			

	}
	
    public function show($id)
    {
        return "Show".$id;
    }
	

    public function destroy($id)
    {
        echo 'Delete '.$id;
    }
}
