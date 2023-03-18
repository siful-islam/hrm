<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Session;


class AdminUserController extends Controller
{
	 /* public function add_user_br()
    {
		$data = array();
	 
	    $data['action'] 		= 'stote_user_br/';	

		 
		$user_br = DB::table('tbl_admin_br') 
							->orderby('first_name','asc')
							->get();
		foreach($user_br as $v_user_br){ 
			$first_name = $v_user_br->first_name;
			$email_address = $v_user_br->email_address;
			$cell_no = $v_user_br->cell_no;
			 
			$bra_code =  DB::table('tbl_branch')  
							->Where('branch_name', 'like', '%' . $first_name . '%')				
							->first();
				if($bra_code){
					$data['branch_staff'][] = array(
											'first_name'   		   => $first_name,
											'email_address' 		   => $email_address,  
											'cell_no' => $cell_no, 
											'br_code' => $bra_code->br_code  ,
											'branch_name' => $bra_code->branch_name  
										);
				}else{
					$data['branch_staff'][] = array(
											'first_name'   		   => $first_name,
											'email_address' 		   => $email_address,  
											'cell_no' => $cell_no, 
											'br_code' => ''  ,
											'branch_name' => ''  
										);
				}			
							
		}  						
		return view('admin.config.user_form_br', $data);				
    }
	public function stote_user_br(Request $request)
    {
		
		$data=array();
		$photoName 					= "avatar.png";   
		$data['admin_photo'] 		= $photoName;	

		  
		$user = $request->user;
		/* print_r($user);
		exit;  
		 if(!empty($user)){
			foreach($user as $v_user){
				  $data['first_name'] 			= $v_user['first_name'];
				  $data['admin_name'] 			= $v_user['first_name'];
				  $data['cell_no'] 				= $v_user['cell_no'];
				  $data['branch_code'] 			= $v_user['branch_code'];
				  $data['email_address'] 		= $v_user['email_address'];
				  $data['user_type'] 			= 5;
				  $data['status'] 				= 1;
				  $data['admin_password'] 		= md5(123456);
				  $data['access_label'] 		= 23;
				  DB::table('tbl_admin')->insert($data);
			}
		} 
    } */
	
	public function index()
    {        			
		$data['users'] = User::join('tbl_admin_user_role', 'tbl_admin_user_role.id', '=', 'tbl_admin.access_label')
							->where('tbl_admin.status', 1)
							->get();
		return view('admin.config.manage_user',$data);
    }
	
    public function add_user()
    {
		$data = array();
		$data['action'] 			= '/store-user';
		$data['admin_id'] 			= '';
		$data['emp_id'] 			= '';
		$data['first_name'] 		= '';
		$data['last_name'] 			= '';
		$data['admin_name'] 		= '';
		$data['email_address'] 		= '';
		$data['cell_no'] 			= '';
		$data['admin_password'] 	= '';
		$data['access_label'] 		= 2;
		$data['br_code'] 			= '';	
		$data['user_type'] 			= '';		
		$data['admin_photo'] 		= 'public/avatars/avatar.png';
		$data['pre_admin_photo'] 	= 'avatar.png';
		$data['button_text'] 		= 'Save';
		$data['Heading'] 			= 'Add User';
		$data['user_role'] = DB::table('tbl_admin_user_role')->get();
		$data['branch_info'] = DB::table('tbl_branch')->get();		
		return view('admin.config.user_form',['data' => $data]);				
    }
	
	public function edit_user($admin_id)
    {
		$data = array();
		$user_info = DB::table('tbl_admin')->where('admin_id', $admin_id)->first();		
		$data['action'] 			= '/update-user';
		$data['admin_id'] 			= $user_info->admin_id;
		$data['emp_id'] 			= $user_info->emp_id;
		$data['first_name'] 		= '';
		$data['last_name'] 			= '';
		$data['admin_name'] 		= $user_info->admin_name;
		$data['email_address'] 		= $user_info->email_address;
		$data['cell_no'] 			= $user_info->cell_no;
		$data['admin_password'] 	= $user_info->admin_password;
		$data['access_label'] 		= $user_info->access_label;
		$data['br_code'] 			= $user_info->branch_code;	
		$data['user_type'] 			= $user_info->user_type;
		$data['admin_photo'] 		= 'public/avatars/'.$user_info->admin_photo;	
		$data['pre_admin_photo'] 	= $user_info->admin_photo;	
		$data['button_text'] 		= 'Update';
		$data['Heading'] 			= 'Update User';
		$data['user_role'] = DB::table('tbl_admin_user_role')->get();
		$data['branch_info'] = DB::table('tbl_branch')->get();
		return view('admin.config.user_form',['data' => $data]);
    }
	
	
	public function stote_user(Request $request)
    {
		
		if($request->file('admin_photo'))
		{
			$photoName = time().'.'.$request->admin_photo->getClientOriginalExtension();
			$request->admin_photo->move(public_path('avatars'), $photoName);
		}
		else
		{
			$photoName = "avatar.png";
		}
		
		$data=array();		
		$data['admin_id'] 			= $request->input('admin_id');
		$data['emp_id'] 			= $request->input('emp_id');
		$data['first_name'] 		= $request->input('first_name');
		$data['last_name'] 			= $request->input('last_name');
		$data['admin_name'] 		= $request->input('admin_name');
		$data['email_address'] 		= $request->input('email_address');
		$data['cell_no'] 			= $request->input('cell_no');
		$data['admin_password'] 	= md5($request->input('admin_password'));
		$data['access_label'] 		= $request->input('access_label');
		$data['branch_code'] 		= $request->input('br_code');	
		$data['user_type'] 			= $request->input('user_type');
		$data['admin_photo'] 		= $photoName;	

		$status = DB::table('tbl_admin')->insert($data);

		if($status)
		{
            Session::put('message','Data Saved Successfully');
            return Redirect::to('/manage-user');			
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
    }
	
	public function update_user(Request $request)
    {
        
		if($request->file('admin_photo'))
		{
			$photoName = time().'.'.$request->admin_photo->getClientOriginalExtension();
			$request->admin_photo->move(public_path('avatars'), $photoName);
		}
		else
		{
			$photoName = $request->input('pre_admin_photo');
		}
		
		$data=array();		
		$admin_id 					= $request->input('admin_id');
		$data['emp_id']				= $request->input('emp_id');
		$data['first_name'] 		= $request->input('first_name');
		$data['last_name'] 			= $request->input('last_name');
		$data['admin_name'] 		= $request->input('admin_name');
		$data['email_address'] 		= $request->input('email_address');
		$data['cell_no'] 			= $request->input('cell_no');		
		$data['admin_password'] 	= $request->input('admin_password');
		$data['access_label'] 		= $request->input('access_label');	
		$data['branch_code'] 		= $request->input('br_code');	
		$data['user_type'] 			= $request->input('user_type');	
		$data['admin_photo'] 		= $photoName;	

		$status = DB::table('tbl_admin')
            ->where('admin_id', $admin_id)
            ->update($data);

		if($status)
		{
            Session::put('message','Data Updated Successfully');
            return Redirect::to('/manage-user');			
		}
		else
		{
			Session::put('message','Error: Unable to Update Data');
		}
		
    }
	
	
    public function destroy_user($admin_id)
    {
		$data['status'] =  DB::table('tbl_admin')->where('admin_id', '=', $admin_id)->delete();
        echo json_encode($data);
    }	
	public function paward_change()
    {
        $data = array();  
		$data['action'] 			= 'new_password_insert/';
	    
		return  view('admin.config.password_change_form',$data);  
    }
	public function check_password_old($old_password)
    {
         
		 $admin_id = Session::get('admin_id');
		  $old_password = md5($old_password);
		$user_info = DB::table('tbl_admin') 
					  ->where('admin_id',$admin_id)  
					  ->where('admin_password',$old_password)  
					  ->select('admin_id')
                      ->first();
 	     if(!empty($user_info)){
			echo 1; 
		 }else{
			 echo 0;
		 }  
 		 
    }
    public function new_password_insert(Request $request)
    {
		$data = array(); 
		$admin_id = Session::get('admin_id');
        $old_password 			= $request->old_password; 
        $new_password 			= $request->new_password; 
        $confirm_password 		= $request->confirm_password; 
        
		if($new_password == $confirm_password){
			$data['admin_password']  = md5($new_password);
			 DB::table('tbl_admin')
				->where('admin_id', $admin_id)
				->update($data); 
				Session::put('message','Your Password is Changed successfully'); 				
		} 
		 return Redirect::to('/logout');
    }
	public function admin_reset_password()
    {        			
		$data['users'] = User::join('tbl_admin_user_role', 'tbl_admin_user_role.id', '=', 'tbl_admin.access_label') 
							->leftJoin('tbl_branch as b', 'tbl_admin.branch_code', '=', 'b.br_code')
							->where('tbl_admin.access_label', 23)
							->orwhere('tbl_admin.access_label', 22)
							 ->select('tbl_admin.*','tbl_admin_user_role.admin_role_name','b.branch_name')
							->get();
		return view('admin.config.manage_user_reset',$data);
    }
	public function update_reset_password($admin_id)
    {   
		$data = array();
		$data['admin_password']  = md5(123456);
			 DB::table('tbl_admin')
				->where('admin_id', $admin_id)
				->update($data); 
		Session::put('message','Now this User Password is 123456');
		return Redirect::to('/ad_reset_pw');
		 
    }
}
