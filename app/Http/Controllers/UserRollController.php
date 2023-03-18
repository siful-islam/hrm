<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Role;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class UserRollController extends Controller
{

    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data['roles'] = Role::join('tbl_status', 'tbl_status.status_id', '=', 'tbl_admin_user_role.role_status')
							->select('tbl_admin_user_role.*','tbl_status.status_name')
							->get();
							
		return view('admin.config.manage_user_role',$data);					
    }

    public function create()
    {
        $data =array();
        $data['Heading'] 			= 'User Role';
        $data['action'] 			= '/user-role';
        $data['button_text'] 		= 'Save';
        $data['method'] 			= 'POST';
        $data['method_control'] 	= '';		
        $data['admin_role_name']	= '';
        $data['role_description'] 	= '';
        $data['role_status'] 		= 1;
		return view('admin.config.user_role_form',$data);	
    }

    public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token']);
		$data['status'] = Role::insertGetId($data);
		echo json_encode($data);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $info = Role::find($id);
		$data =array();
        $data['Heading'] 			= 'User Role Edit';
        $data['button_text'] 		= 'Update';
		$data['action'] 			= "/user-role/$id";
		$data['method'] 			= 'POST';
		$data['method_control'] 	= "<input type='hidden' name='_method' value='PUT' />"; 	
        $data['admin_role_name']	= $info->admin_role_name;
        $data['role_description'] 	= $info->role_description;
        $data['role_status'] 		= $info->role_status;
		return view('admin.config.user_role_form',$data);	
    }
	
    public function update(Request $request)
    {
		$data = request()->except(['_token']);
		$id =  $request->input('id');
		$data['status']         = DB::table('tbl_admin_user_role')
            ->where('id', $id)
            ->update($data);			
		echo json_encode($data);
    }   

	public function role_status_update($id,$val)
    {
		$data['status']         = DB::table('tbl_admin_user_role')
            ->where('id', $id)
            ->update(['role_status' => $val]);
		echo json_encode($data);
    }

    public function destroy($id)
    {
        //
    }

}
