<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UserPermissionController extends Controller
{

	 public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
    public function index()
    {
        //
    }

	
	public function set_permission($id)
	{
		$data['admin_role_name'] = DB::table('tbl_admin_user_role')->where('id', $id)->first();
		$access_label = $id;
		$data['exist_permission_info'] = DB::table('tbl_user_permissions')
										->join('tbl_navbar', 'tbl_navbar.nav_id', '=', 'tbl_user_permissions.nav_id')
										->where('user_role_id', $id)->get();	
		$data['user_role'] 		= $id;
		$data['navbar_group'] 	= DB::table('tbl_navbar_group')->orderBy('sl_order','ASC')->get();	
		$data['navbar'] 		= DB::table('tbl_navbar')->whereRaw("find_in_set($access_label,user_access)")->where('nav_status',1)->get();	
		$data['actions'] 		= DB::table('tbl_actions')->where('action_status',1)->get();	
		return view('admin.config.user_permission',$data);
	}

    public function create()
    {
        //
    }
	 
    public function store(Request $request)
    {	
		$data=array();		
		$user_role = $request->input('user_role');		
		$role_permission = $request->input('role_permission');	
		
		$exist = DB::table('tbl_user_permissions')->where('user_role_id', $user_role)->get();
		if(count($exist))
		{
			DB::table('tbl_user_permissions')->where('user_role_id', $user_role)->delete();
		}
		
		$i = 0; 
		foreach($role_permission as $v_role_permission)
		{			
			
			$save['user_role_id'] 	= $user_role;
			$save['nav_id'] 		= array_keys($role_permission)[$i];
			$save['permission'] 	= implode(",", $v_role_permission);
			//Data Save into Database
			$status = DB::table('tbl_user_permissions')->insert($save);
			$i++;
		}
		
		return Redirect::to('/set-permission/'.$user_role);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
