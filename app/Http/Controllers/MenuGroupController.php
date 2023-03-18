<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Models\MenuGroup;
use Illuminate\Support\Facades\Redirect;
use Session;


class MenuGroupController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        			
		$data['menu_groups'] = MenuGroup::get();
		return view('admin.settings.manage_menu_group',$data);
    }
	
    public function add_menu_group()
    {
		$data = array();
		$data['action'] 			= '/store-menu-group';
		$data['nav_group_id'] 		= '';
		$data['nav_group_name'] 	= '';
		$data['grpup_icon'] 		= '<i class="fa fa-dashboard"></i>';
		$data['is_sub_menu'] 		= '';
		$data['sl_order'] 			= 0;
		$data['user_access'] 		= array(1);
		$data['nav_group_status'] 	= '';
		$data['Heading'] 			= 'Add Menu Group';
		$data['button_text'] 		= 'Save';
		$data['user_role'] 			= DB::table('tbl_admin_user_role')->where('role_status',1)->get();	
		return view('admin.settings.menu-group_form',['data' => $data]);				
    }
	
	public function edit_nav_group($nav_group_id)
    {
		$data = array();
		$nav_group_info = DB::table('tbl_navbar_group')->where('nav_group_id', $nav_group_id)->first();		
		$data['action'] 			= '/update-menu-group';
		$data['nav_group_id'] 		= $nav_group_info->nav_group_id;
		$data['nav_group_name'] 	= $nav_group_info->nav_group_name;
		$data['grpup_icon'] 		= $nav_group_info->grpup_icon;
		$data['is_sub_menu'] 		= $nav_group_info->is_sub_menu;
		$data['sl_order'] 			= $nav_group_info->sl_order;
		$data['user_access'] 		= explode(",", $nav_group_info->user_access) ;
		$data['nav_group_status'] 	= $nav_group_info->nav_group_status;	
		$data['button_text'] 		= 'Update';
		$data['Heading'] 			= 'Update Menu Group';
		$data['user_role'] 			= DB::table('tbl_admin_user_role')->where('role_status',1)->get();	
		return view('admin.settings.menu-group_form',['data' => $data]);	
    }
	
	
	public function stote_menu_group(Request $request)
    {

		$data=array();		
		$data['nav_group_id'] 		= $request->input('nav_group_id');
		$data['nav_group_name'] 	= $request->input('nav_group_name');
		$data['grpup_icon'] 		= $request->input('grpup_icon');
		$data['is_sub_menu'] 		= $request->input('is_sub_menu');
		$data['sl_order'] 			= $request->input('sl_order');
		$data['user_access'] 		= implode(",", $request->input('user_access'));
		$data['nav_group_status'] 	= $request->input('nav_group_status');
		$status = DB::table('tbl_navbar_group')->insert($data);

		if($status)
		{
            Session::put('message','Data Saved Successfully');
            return Redirect::to('/manage-menu-group');			
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
    }
	
	public function update_nav_group(Request $request)
    {
		$data=array();		
		$nav_group_id 				= $request->input('nav_group_id');
		$data['nav_group_name'] 	= $request->input('nav_group_name');
		$data['grpup_icon'] 		= $request->input('grpup_icon');
		$data['is_sub_menu'] 		= $request->input('is_sub_menu');
		$data['sl_order'] 			= $request->input('sl_order');
		$data['user_access'] 		= implode(",", $request->input('user_access'));
		$data['nav_group_status'] 	= $request->input('nav_group_status');
		$status = DB::table('tbl_navbar_group')
            ->where('nav_group_id', $nav_group_id)
            ->update($data);

		if($status)
		{
            Session::put('message','Data Updated Successfully');
            return Redirect::to('/manage-menu-group');			
		}
		else
		{
			Session::put('message','Error: Unable to Update Data');
		}		
    }
  
}
