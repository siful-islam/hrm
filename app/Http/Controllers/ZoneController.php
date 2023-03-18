<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Models\Zone;
use Illuminate\Support\Facades\Redirect;
use Session;


class ZoneController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        			
		$data['zones'] = Zone::get();
		return view('admin.settings.manage_zone',$data);
    }
	
    public function add_zone()
    {
		$data = array();
		$data['action'] 			= '/store-zone';
		$data['zone_id'] 		= '';
		$data['zone_name'] 			= '';
		$data['zone_code'] 			= '';
		$data['status'] 			= '';
		$data['Heading'] 			= 'Add Zone';
		$data['button_text'] 		= 'Save';
		return view('admin.settings.zone_form',$data);				
    }
	
	public function edit_zone($zone_id)
    {
		$data = array();
		$zone_info = DB::table('tbl_zone')->where('zone_id', $zone_id)->first();		
		$data['action'] 			= '/update-zone';		
		$data['zone_id'] 			= $zone_info->zone_id;
		$data['zone_name'] 			= $zone_info->zone_name;
		$data['zone_code'] 			= $zone_info->zone_code;
		$data['status'] 			= $zone_info->status;
		$data['button_text'] 		= 'Update';
		$data['Heading'] 			= 'Update Zone';
		return view('admin.settings.zone_form',$data);	
    }
	
	
	public function store_zone(Request $request)
    {
		$data=array();				
		$data['zone_name'] 	= $request->input('zone_name');
		$data['zone_code'] 	= $request->input('zone_code');
		$data['status'] 	= $request->input('status');
		$status = DB::table('tbl_zone')->insert($data);
		if($status)
		{
            Session::put('message','Data Saved Successfully');
            return Redirect::to('/manage-zone');			
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
    }
	
	public function update_zone(Request $request)
    {
		$data=array();		
		$zone_id 				= $request->input('zone_id');
		$data['zone_name'] 	= $request->input('zone_name');
		$data['zone_code'] 	= $request->input('zone_code');
		$data['status'] 	= $request->input('status');
		$status = DB::table('tbl_zone')
            ->where('zone_id', $zone_id)
            ->update($data);
		if($status)
		{
            Session::put('message','Data Updated Successfully');
            return Redirect::to('/manage-zone');			
		}
		else
		{
			Session::put('message','Error: Unable to Update Data');
		}		
    }

}
