<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Models\Branch;
use Illuminate\Support\Facades\Redirect;
use Session;


class BranchController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {      
		 
		$data['branches'] = Branch::join('tbl_area', 'tbl_area.area_code', '=', 'tbl_branch.area_code')
							->join('tbl_zone', 'tbl_area.zone_code', '=', 'tbl_zone.zone_code')
							->select('tbl_branch.*','tbl_area.area_name','tbl_zone.zone_name')
							->get();
							
		return view('admin.settings.manage_branch',$data);
    }
	
    public function add_branch()
    {
		$data = array();
		$data['action'] 			= '/store-branch';
		$data['br_id'] 				= '';
		$data['br_code'] 			= '';
		$data['branch_name'] 		= '';
		$data['br_name_bangla'] 	= '';
		$data['branch_contact_no'] 	= '';
		$data['branch_email'] 		= '';
		$data['branch_address'] 	= '';
		$data['area_code'] 			= '';
		$data['start_date'] 		= '';
		$data['status'] 			= '';
		$data['Heading'] 			= 'Add Branch';
		$data['button_text'] 		= 'Save';
		$data['all_areas'] 		    = DB::table('tbl_area')->where('status',1)->get();	
		return view('admin.settings.branch_form',$data);				
    }
	
	public function edit_branch($br_id)
    {
		$data = array();
		$branch_info = DB::table('tbl_branch')->where('br_id', $br_id)->first();		
		$data['action'] 			= '/update-branch';		
		$data['br_id'] 				= $branch_info->br_id;
		$data['br_code'] 			= $branch_info->br_code;
		$data['branch_name'] 		= $branch_info->branch_name;
		$data['br_name_bangla'] 	= $branch_info->br_name_bangla;
		$data['branch_contact_no'] 	= $branch_info->branch_contact_no;
		$data['branch_email'] 		= $branch_info->branch_email;
		$data['branch_address'] 	= $branch_info->branch_address;
		$data['area_code'] 			= $branch_info->area_code;
		$data['start_date'] 		= $branch_info->start_date;
		$data['status'] 			= $branch_info->status;
		$data['button_text'] 		= 'Update';
		$data['Heading'] 			= 'Update Branch';
		$data['all_areas'] 		    = DB::table('tbl_area')->where('status',1)->get();
		return view('admin.settings.branch_form',$data);	
    }
	
	
	public function store_branch(Request $request)
    {
		$data=array();				
		$data['br_code'] 			= $request->input('br_code');
		$data['branch_name'] 		= $request->input('branch_name');
		$data['br_name_bangla'] 	= $request->input('br_name_bangla');
		$data['branch_contact_no'] 	= $request->input('branch_contact_no');
		$data['branch_email'] 		= $request->input('branch_email');
		$data['branch_address'] 	= $request->input('branch_address');
		$data['start_date'] 		= $request->input('start_date');
		$data['area_code'] 			= $request->input('area_code');
		$data['status'] 			= $request->input('status');
		$status = DB::table('tbl_branch')->insert($data);
		if($status)
		{
            Session::put('message','Data Saved Successfully');
            return Redirect::to('/manage-branch');			
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
    }
	
	public function update_branch(Request $request)
    {
		$data=array();		
		$br_id 						= $request->input('br_id');
		$data['br_code'] 			= $request->input('br_code');
		$data['branch_name'] 		= $request->input('branch_name');
		$data['br_name_bangla'] 	= $request->input('br_name_bangla');
		$data['branch_contact_no'] 	= $request->input('branch_contact_no');
		$data['branch_email'] 		= $request->input('branch_email');
		$data['branch_address'] 	= $request->input('branch_address');
		$data['start_date'] 		= $request->input('start_date');
		$data['area_code'] 			= $request->input('area_code');
		$data['status'] 			= $request->input('status');
		$status = DB::table('tbl_branch')
            ->where('br_id', $br_id)
            ->update($data);
		if($status)
		{
            Session::put('message','Data Updated Successfully');
            return Redirect::to('/manage-branch');			
		}
		else
		{
			Session::put('message','Error: Unable to Update Data');
		}		
    }

}
