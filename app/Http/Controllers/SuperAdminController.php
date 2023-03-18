<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;
////session_start();

class SuperadminController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	
	
	
	public function loan_view($id)
	{
		/* $data['info'] = DB::table('emp_loan_applications')
			->where('application_id',$id)
			->first(); */
			$data['info']='';
			
			//dd($data['info']);
			return view('admin.my_info.loan_application_view',$data);
	}
	
	
	
	
	public function update_salary_non()
	{
		
		
		/*
		$staffs = DB::table('tbl_emp_salary') 
                     ->where('id',20030)
                     ->first();
		
		$data['emp_id'] = $staffs->emp_id; 
		$plus_takas = explode(",",$staffs->plus_item); 
		$minus_takas = explode(",",$staffs->minus_item); 
		
		$takass = 0;
		foreach($plus_takas as $plus_takass)
		{
			$takass +=$plus_takass;
		}
		$data['total_plus'] = $takass;

		$mtakass = 0;
		foreach($minus_takas as $minus_takass)
		{
			$mtakass +=$minus_takass;
		}
		$data['total_minus'] = $mtakass;
		
		$data['payable'] = ($staffs->salary_basic + $data['total_plus']) - $data['total_minus'];
		$data['net_payable'] = ($staffs->salary_basic + $data['total_plus']) - $data['total_minus'];
		
		
		
		print_r($data);
		exit;
		
		*/
		
		
		$staffs = DB::table('tbl_emp_salary') 
                     ->where('emp_id','>',200000)
                     ->where('net_payable',0)
                     ->get(); 
					 
		foreach($staffs as $staff)
		{
			$plus_items 	= $staff->plus_item;
			$minus_items 	= $staff->minus_item;
			$salary_basic 	= $staff->salary_basic;
			$total_plus 	= $staff->total_plus;
			$total_minus 	= $staff->total_minus;
			$payable 		= $staff->payable;
			$net_payable 	= $staff->net_payable;
			
			$data['emp_id'] = $staff->emp_id; 
  
			
			$plus_takas = explode(",",$staff->plus_item); 
			$minus_takas = explode(",",$staff->minus_item); 
			
			$takass = 0;
			foreach($plus_takas as $plus_takass)
			{
				$takass +=$plus_takass;
			}
			$data['total_plus'] = $takass;

			$mtakass = 0;
			foreach($minus_takas as $minus_takass)
			{
				$mtakass +=$minus_takass;
			}
			$data['total_minus'] = $mtakass;
			
			$data['payable'] = ($staff->salary_basic + $data['total_plus']) - $data['total_minus'];
			$data['net_payable'] = ($staff->salary_basic + $data['total_plus']) - $data['total_minus'];
			
			DB::table('tbl_emp_salary')
				->where('id', $staff->id)
				->update($data);
			
			$inf[] = $data;
		}
					 
		
		echo '<pre>';
		print_r($inf);
		//dd($staffs);
	}
	
	public function index()
    {
		$access_label = Session::get('admin_access_label');
		$data = array();
		$data['title'] = 'Dashboard';
		$to_days_date = date('Y-m-d');
				
		$data['total_employee'] = DB::table('tbl_emp_basic_info as e')
								->leftjoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
								//->where('e.emp_type', '=', 'regular')
								->where('e.org_join_date', '<=', $to_days_date)
								->whereNull('r.emp_id')
								->orWhere('r.effect_date', '>', $to_days_date)
								->count();

		$data['total_resigned_employee'] = DB::table('tbl_resignation')
								->where('effect_date', '<=', $to_days_date)
								->count();
		
		$data['todays_new_emp'] = DB::table('tbl_appointment_info')
								->where('letter_date',$to_days_date)
								->where('status',1)
								->count();
		
		$data['todays_resign_emp'] = DB::table('tbl_resignation')
								->where('letter_date',$to_days_date)
								->where('status',1)
								->count();
		
		/* file transfer info start */
		$login_emp_id = Session::get('emp_id');
		$data['all_result'] = DB::table('tbl_fp_file_info')
									->where('receiver_emp_id', $login_emp_id)
									->where('status',0)
									->get();
		//print_r ($data['all_result']);
		/* file transfer info end */		
		
		/* $admin_id = Session::get('admin_id');
		$admin_password = md5(123456);
		$admin_info = DB::table('tbl_admin') 
                     ->where('admin_id',$admin_id)
                     ->where('admin_password',$admin_password)
					 ->select('*')
                     ->first(); 
		if($admin_info){
			Session::put('menu_permission',2); // 2 for NO
		}else{
			Session::put('menu_permission',1); // 1 for YES
		}	 */ 
		return view('admin.pages.dashboard',$data);
    }
	
	public function test()
	{
		
			$data['nav'] = DB::table('tbl_navbar as nav')
								->leftjoin('tbl_navbar_group as group', 'nav.nav_group_id', '=', 'group.nav_group_id')
								->select('group.nav_group_name','nav.nav_name' )
								->orderBy('group.nav_group_name','nav.nav_name','ASC' )
								->get();
			
			
			echo '<pre>';
			print_r( $data );
			exit;
	}
	
    public function logout()
    {
        Session::put('admin_id','');
		Session::put('emp_id','');
        Session::put('admin_name','');
        Session::put('admin_photo','');
        Session::put('admin_access_label','');
        Session::put('admin_role_name','');
        Session::put('admin_org_code','');
        Session::put('org_short_name','');
        Session::put('org_logo','');
        Session::put('favicon','');
        Session::put('message','You are successfully Logout !');
        //Session::put('message','');
		return Redirect::to( "http://www.home.cdipbd.org/logout" );
		return Redirect::to('/admin');
    }
    
    
    
    
    
    public function branch_info_national_db()
    {
        
        $data['infos'] = DB::table('branch_locations as loc')
								->leftjoin('tbl_branch as br', 'loc.branch_code', '=', 'br.br_code')
								->select('loc.*','br.branch_name' )
								->get();
								
    	return view('branch_info',$data);
    }
	
	public function datapull()
	{
		
		$data = file_get_contents('http://202.4.106.3/datasend.php');
		
	
		$mydata[] = json_decode($data);	
		
		if(count($mydata)>1){
			foreach($mydata[0]->all_data as $row){
				$data=array();				
				$data['punchingcode'] 	= $row->emp_id;
				$data['date'] 	= $row->date;
				$data['time'] 	= $row->time;
				$status = DB::table('tblt_timesheet')->insert($data);
			}
		}
	}
	
	
}
