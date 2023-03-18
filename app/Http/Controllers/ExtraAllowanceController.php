<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\ExtraAllowance;
use Illuminate\Support\Facades\Redirect;
use Session;


class ExtraAllowanceController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        			
		$data['allowances'] = ExtraAllowance::get();
		return view('admin.settings.manage_extra_mobile_allowances',$data);
    }
	
    public function add()
    {
		$data = array();
		$data['action'] 						= '/store-extra_mobile';
		$data['extra_allowance_id'] 			= '';
		$data['extra_allowance_emp_id'] 		= '';
		$data['extra_allowance_amount'] 		= 0;
		$data['extra_allowance_from_date'] 		= date('Y-m-d');
		$data['Heading'] 						= 'Add Extra Mobile Allowance';
		$data['button_text'] 					= 'Save';
		return view('admin.settings.extra_mobile_form',$data);		
    }
	
	
	public function edit($id)
    {
		$data = array();
		$holiday_info = DB::table('extra_allowance')->where('extra_allowance_id', $id)->first();
		$data['action'] 					= '/update-extra_mobile';		
		$data['extra_allowance_id'] 		= $holiday_info->extra_allowance_id;
		$data['extra_allowance_emp_id'] 	= $holiday_info->extra_allowance_emp_id;
		$data['extra_allowance_amount'] 	= $holiday_info->extra_allowance_amount;
		$data['extra_allowance_from_date'] 	= $holiday_info->extra_allowance_from_date;
		$data['button_text'] 				= 'Update';
		$data['Heading'] 					= 'Update Extra Mobile  Allowance';
		$data['holidays'] 		    		= DB::table('extra_allowance')->get();
		return view('admin.settings.extra_mobile_form',$data);	
    }
	
	
	public function store(Request $request)
    {
		$data=array();				
		$data['extra_allowance_emp_id'] 	= $request->input('extra_allowance_emp_id');
		$data['extra_allowance_amount'] 	= $request->input('extra_allowance_amount');
		$data['extra_allowance_from_date'] 	= $request->input('extra_allowance_from_date');
		$status = DB::table('extra_allowance')->insert($data);
		if($status)
		{
            Session::put('message','Data Saved Successfully');
            return Redirect::to('/extra_mobile_allowance');			
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
    }
	
	public function update(Request $request)
    {
		$data=array();		
		$extra_allowance_id 			= $request->input('extra_allowance_id');
		$data['extra_allowance_emp_id'] 	= $request->input('extra_allowance_emp_id');
		$data['extra_allowance_amount'] 	= $request->input('extra_allowance_amount');
		$data['extra_allowance_from_date'] 	= $request->input('extra_allowance_from_date');
		$status = DB::table('extra_allowance')
            ->where('extra_allowance_id', $extra_allowance_id)
            ->update($data);
		if($status)
		{
            Session::put('message','Data Updated Successfully');			
		}
		else
		{
			Session::put('message','Error: Unable to Update Data');
		}
		return Redirect::to('/extra_mobile_allowance');		
    }
	
	public function delete_extra_mobile($id)
	{
		$status = DB::table('extra_allowance')->where('extra_allowance_id', $id)->delete();
		if($status)
		{
            Session::put('message','Data Deleted Successfully');			
		}
		else
		{
			Session::put('message','Error: Unable to Deleted Data');
		}
		return Redirect::to('/extra_mobile_allowance');
	}

}
