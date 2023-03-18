<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Models\Area;
use Illuminate\Support\Facades\Redirect;
use Session;


class AreaController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        			
		$data['areas'] = Area::join('tbl_zone', 'tbl_zone.zone_code', '=', 'tbl_area.zone_code')
							->get();
		return view('admin.settings.manage_area',$data);
    }
	
    public function add_area()
    {
		$data = array();
		$data['action'] 		= '/store-area';
		$data['id'] 			= '';
		$data['area_name'] 		= '';
		$data['area_code'] 		= '';
		$data['zone_code'] 		= '';
		$data['status'] 		= '';
		$data['Heading'] 		= 'Add Area';
		$data['button_text'] 	= 'Save';
		$data['all_zone'] 		= DB::table('tbl_zone')->where('status',1)->get();		
		return view('admin.settings.area_form',$data);		
    }
	
	
	public function edit_area($id)
    {
		$data = array();
		$area_info = DB::table('tbl_area')->where('id', $id)->first();		
		$data['action'] 			= '/update-area';		
		$data['id'] 				= $area_info->id;
		$data['area_name'] 			= $area_info->area_name;
		$data['area_code'] 			= $area_info->area_code;
		$data['zone_code'] 			= $area_info->zone_code;
		$data['status'] 			= $area_info->status;
		$data['button_text'] 		= 'Update';
		$data['Heading'] 			= 'Update Area';
		$data['all_zone'] 		    = DB::table('tbl_zone')->where('status',1)->get();
		return view('admin.settings.area_form',$data);	
    }
	
	
	public function store_area(Request $request)
    {
		$data=array();				
		$data['area_name'] 	= $request->input('area_name');
		$data['area_code'] 	= $request->input('area_code');
		$data['zone_code'] 	= $request->input('zone_code');
		$data['status'] 	= $request->input('status');
		$status = DB::table('tbl_area')->insert($data);
		if($status)
		{
            Session::put('message','Data Saved Successfully');
            return Redirect::to('/manage-area');			
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
    }
	
	public function update_area(Request $request)
    {
		$data=array();		
		$id 				= $request->input('id');
		$data['area_name'] 	= $request->input('area_name');
		$data['area_code'] 	= $request->input('area_code');
		$data['zone_code'] 	= $request->input('zone_code');
		$data['status'] 	= $request->input('status');
		$status = DB::table('tbl_area')
            ->where('id', $id)
            ->update($data);
		if($status)
		{
            Session::put('message','Data Updated Successfully');
            return Redirect::to('/manage-area');			
		}
		else
		{
			Session::put('message','Error: Unable to Update Data');
		}		
    }

}
