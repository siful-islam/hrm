<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Holiday;
use Illuminate\Support\Facades\Redirect;
use Session;


class HolidayController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        			
		$data['holidays']  = DB::table('tbl_holidays')
								->orderBy('holiday_date', 'Desc')
								->get();  
		return view('admin.settings.manage_holiday',$data);
    }
	
    public function add_holiday()
    {
		$data = array();
		$data['action'] 			= '/store-holiday';
		$data['id'] 				= '';
		$data['holiday_name'] 		= '';
		$data['description'] 		= '';
		$data['description_bn'] 	= '';
		$data['holiday_date'] 		= date('Y-m-d');
		$data['Heading'] 			= 'Add Holiday';
		$data['button_text'] 		= 'Save';
		return view('admin.settings.holiday_form',$data);		
    }
	
	
	public function edit_holiday($id)
    {
		$data = array();
		$holiday_info = DB::table('tbl_holidays')->where('holiday_id', $id)->first();
		$data['action'] 			= '/update-holiday';		
		$data['id'] 				= $holiday_info->holiday_id;
		$data['holiday_name'] 		= $holiday_info->holiday_name;
		$data['description'] 		= $holiday_info->description;
		$data['description_bn'] 	= $holiday_info->description_bn;
		$data['holiday_date'] 		= $holiday_info->holiday_date;
		$data['button_text'] 		= 'Update';
		$data['Heading'] 			= 'Update Holiday';
		$data['holidays'] 		    = DB::table('tbl_holidays')->get();
		return view('admin.settings.holiday_form',$data);	
    }
	
	
	public function store_holiday(Request $request)
    {
		$data=array();				
		$data['holiday_name'] 	= $request->input('holiday_name');
		$data['description'] 	= $request->input('description');
		$data['description_bn'] = $request->input('description_bn');
		$data['holiday_date'] 	= $request->input('holiday_date');
		$status = DB::table('tbl_holidays')->insert($data);
		if($status)
		{
            Session::put('message','Data Saved Successfully');
            return Redirect::to('/manage-holiday');			
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
    }
	
	public function update_holiday(Request $request)
    {
		$data=array();		
		$holiday_id 			= $request->input('id');
		$data['holiday_name'] 	= $request->input('holiday_name');
		$data['description'] 	= $request->input('description');
		$data['description_bn'] = $request->input('description_bn');
		$data['holiday_date'] 	= $request->input('holiday_date');
		$status = DB::table('tbl_holidays')
            ->where('holiday_id', $holiday_id)
            ->update($data);
		if($status)
		{
            Session::put('message','Data Updated Successfully');			
		}
		else
		{
			Session::put('message','Error: Unable to Update Data');
		}
		return Redirect::to('/manage-holiday');		
    }
	
	public function delete_holiday($id)
	{
		$status = DB::table('tbl_holidays')->where('holiday_id', $id)->delete();
		if($status)
		{
            Session::put('message','Data Deleted Successfully');			
		}
		else
		{
			Session::put('message','Error: Unable to Deleted Data');
		}
		return Redirect::to('/manage-holiday');
	}

}
