<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Models\Menus;
use Illuminate\Support\Facades\Redirect;
use Session;


class MenusController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        			
		$data['menus'] = Menus::join('tbl_navbar_group', 'tbl_navbar_group.nav_group_id', '=', 'tbl_navbar.nav_group_id')
							->get();
		return view('admin.settings.manage_menu',$data);
    }
	
    public function add_menu()
    {
		$data = array();
		$data['action'] 			= '/store-menu';
		$data['nav_id'] 			= '';
		$data['nav_group_id'] 		= '';
		$data['nav_name'] 			= '';
		$data['user_access'] 		= array(1);
		$data['nav_action'] 		= '/';
		$data['nav_order'] 			= 0;
		$data['nav_status'] 		= '';
		$data['Heading'] 			= 'Add Menu';
		$data['button_text'] 		= 'Save';
		$data['all_nav_group'] 		= DB::table('tbl_navbar_group')->where('nav_group_status',1)->get();	
		$data['user_role'] 			= DB::table('tbl_admin_user_role')->where('role_status',1)->get();	
		return view('admin.settings.menu_form',$data);				
    }
	
	public function edit_nav($nav_id)
    {
		$data = array();
		$nav_info = DB::table('tbl_navbar')->where('nav_id', $nav_id)->first();		
		$data['action'] 			= '/update-menu';
		$data['nav_id'] 			= $nav_info->nav_id;
		$data['nav_group_id'] 		= $nav_info->nav_group_id;
		$data['nav_name'] 			= $nav_info->nav_name;
		$data['nav_action'] 		= $nav_info->nav_action;
		$data['user_access'] 		= explode(",", $nav_info->user_access) ;
		$data['nav_order'] 			= $nav_info->nav_order;	
		$data['nav_status'] 		= $nav_info->nav_status;	
		$data['button_text'] 		= 'Update';
		$data['Heading'] 			= 'Update Menu';
		$data['all_nav_group'] 		= DB::table('tbl_navbar_group')->where('nav_group_status',1)->get();	
		$data['user_role'] 			= DB::table('tbl_admin_user_role')->where('role_status',1)->get();	
		return view('admin.settings.menu_form',$data);	
    }
	
	
	public function stote_menu(Request $request)
    {
		$data=array();
		
		$max_nav = DB::table('tbl_navbar')->max('nav_id');
		$max_nav_id =  $max_nav+1;

		$user_access 	= $request->input('user_access');
	
		
		$data['nav_id'] 		= $request->input('nav_id');
		$data['nav_group_id'] 	= $request->input('nav_group_id');
		$data['nav_name'] 		= $request->input('nav_name');
		$data['nav_action'] 	= $request->input('nav_action');
		$data['nav_order'] 		= $request->input('nav_order');
		$data['user_access'] 	= implode(",", $request->input('user_access'));
		$data['nav_status'] 	= $request->input('nav_status');
		
		$user_access 	= $request->input('user_access');	
		foreach($user_access as $v_user_access)
		{
			$permissions['user_role_id'] 	= $v_user_access;
			$permissions['nav_id'] 			= $max_nav_id;
			$permissions['permission'] 		= 1;
			DB::table('tbl_user_permissions')->insert($permissions);
		}

		$status = DB::table('tbl_navbar')->insert($data);

		if($status)
		{
            Session::put('message','Data Saved Successfully');
            return Redirect::to('/manage-menu');			
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}	
    }
	
	public function update_nav(Request $request)
    {
		$data=array();		
		$nav_id 				= $request->input('nav_id');
		$data['nav_group_id'] 	= $request->input('nav_group_id');
		$data['nav_name'] 		= $request->input('nav_name');
		$data['nav_action'] 	= $request->input('nav_action');
		$data['user_access'] 	= implode(",", $request->input('user_access'));
		$data['nav_order'] 		= $request->input('nav_order');
		$data['nav_status'] 	= $request->input('nav_status');
		
		$user_access 			= $request->input('user_access');	
		foreach($user_access as $v_user_access)
		{
			$permissions['user_role_id'] 	= $v_user_access;
			$permissions['nav_id'] 			= $request->input('nav_id');
			$permissions['permission'] 		= 1;
			
			$check_pre_data = DB::table('tbl_user_permissions')
								->where('user_role_id', $v_user_access)
								->where('nav_id', $nav_id)
								->first();
								
			if(empty($check_pre_data))
			{
				DB::table('tbl_user_permissions')->insert($permissions);
			}		
		}
		
		$status = DB::table('tbl_navbar')
            ->where('nav_id', $nav_id)
            ->update($data);

		if(isset($status))
		{
            Session::put('message','Data Updated Successfully');
            return Redirect::to('/manage-menu');			
		}
		else
		{
			Session::put('message','Error: Unable to Update Data');
		}		
    }
	public function user_manu_report()
	{ 
		$data['all_user'] = DB::table('tbl_admin')
										->join('tbl_admin_user_role', 'tbl_admin.access_label', '=', 'tbl_admin_user_role.id') 
										->where('tbl_admin.status',1)
										->where(function($query)
											{
												
													$query->where('tbl_admin.user_type','=',2)
															->orwhere('tbl_admin.user_type','=',7)->orwhere('tbl_admin.user_type','=',1);
												 
											})
										
										->select('tbl_admin.admin_name','tbl_admin_user_role.admin_role_name','tbl_admin_user_role.id')
										->orderby('tbl_admin.admin_id','dsc')
										->get();	 
		return view('admin.config.user_manu_report',$data);
	}
}
