<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class ArrearAlowanceSetupController extends Controller
{
	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data['all_result'] = DB::table('arrear_allowance_salary as ars')
							->leftJoin('tbl_emp_basic_info as e', 'ars.arrear_emp_id', '=', 'e.emp_id')
							->select('ars.*','e.emp_name_eng')
							->get();
		return view('admin.pages.arrear.arrear_alowance_setup_list',$data);		
    }

    public function create()
    {
		$data = array();
		$data['action'] 		        = '/arrear_allow_setup';
		$data['method'] 		        = 'post';
		$data['method_field'] 	        = '';
		$data['id'] 			        = '';
		$data['arrear_emp_id']          = ''; 
		$data['arrear_from']            = date('Y-m-d'); 
		$data['arrear_to']              = date('Y-m-d'); 
		$data['arrear_pay_month']       = ''; 
		$data['alowance_head_code']     = ''; 
		$data['comments']               = ''; 
		$data['emp_name']               = ''; 
		$data['array_allowance_amount'] = array(); 
		$data['Heading'] 	            = 'Add Assign';
		$data['button_text']            = 'Save';
		$data['allowance_head']         = DB::table( 'payroll_head' )
										    ->where( 'head_type', '=', 3 )
										    ->get();
		return view('admin.pages.arrear.arrear_alowance_setup_form',$data);	

    } 
	public function store(Request $request)
    {
		$data = array();
		$data['arrear_emp_id'] 			=  $request->input('arrear_emp_id');  
		$data['arrear_from'] 			=  $request->input('arrear_from');  
		$data['arrear_to'] 				=  $request->input('arrear_to');  
		$data['arrear_pay_month'] 		=  $request->input('arrear_pay_month');  
		$data['alowance_head_code'] 	=  implode(',',$request->input('alowance_head_code'));  
		$data['alowance_amount'] 		=  implode(',',$request->input('alowance_amount'));  
		$data['created_by'] = Session::get('admin_id');
		DB::table('arrear_allowance_salary')->insert($data);
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/arrear_allow_setup');			
    }
    
	public function edit($id)
    {
		$data = array();
		$data['action'] 		= "/arrear_allow_setup_update";
		$data['method'] 		= 'post';
		$data['method_field'] 	= '';
		
		$alowance_info = DB::table('arrear_allowance_salary as ars')
							->leftJoin('tbl_emp_basic_info as e', 'ars.arrear_emp_id', '=', 'e.emp_id')
							->where('ars.arrear_alowance_id', '=', $id )
							->select('ars.*','e.emp_name_eng')
							->first(); 
		$data['id'] 					= $alowance_info->arrear_alowance_id; 
		$data['emp_name'] 				= $alowance_info->emp_name_eng; 
		$data['arrear_emp_id'] 			= $alowance_info->arrear_emp_id; 
		$data['arrear_from']            = $alowance_info->arrear_from; 
		$data['arrear_to']              = $alowance_info->arrear_to; 
		$data['arrear_pay_month'] 		= $alowance_info->arrear_pay_month; 
		$alowance_head_code	 			= explode(',',$alowance_info->alowance_head_code); 
		$alowance_amount	 			= explode(',',$alowance_info->alowance_amount); 
		$data['comments'] 				= $alowance_info->comments; 
		$array_allowance_amount = array();
		$i=0;
		foreach($alowance_head_code as $value){
			$array_allowance_amount[$value]=$alowance_amount[$i];
			$i++;
		} 
		$data['array_allowance_amount'] 	 = $array_allowance_amount;
		$data['Heading'] 	 = 'Add Assign';
		$data['button_text'] = 'Update';
		$data['allowance_head'] = DB::table( 'payroll_head' )
										 ->where( 'head_type', '=', 3 )
										 ->get();
		return view('admin.pages.arrear.arrear_alowance_setup_form',$data);	

    } 
	public function arrear_allow_setup_update(Request $request)
    {
		$data = array();
		$id 							=  $request->input('id');  
		$data['arrear_emp_id'] 			=  $request->input('arrear_emp_id');  
		$data['arrear_from'] 			=  $request->input('arrear_from');  
		$data['arrear_to'] 			    =  $request->input('arrear_to');  
		$data['comments'] 			    =  $request->input('comments');  
		$data['arrear_pay_month'] 		=  $request->input('arrear_pay_month');  
		$data['alowance_head_code'] 	=  implode(',',$request->input('alowance_head_code'));  
		$data['alowance_amount'] 		=  implode(',',$request->input('alowance_amount'));  
		$data['updated_by'] = Session::get('admin_id');
					DB::table('arrear_allowance_salary')
						->where('arrear_alowance_id', $id) 
						->update($data);	
		Session::put('message','Data Update Successfully');
		return Redirect::to('/arrear_allow_setup');			

    }
	public function get_emp_info_arr_alowance($arrear_emp_id)
	{
		$data = array();
		$effect_date = date("Y-m-d");
		$max_id = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $arrear_emp_id)
						->where('m.br_join_date', '=', function($query) use ($arrear_emp_id,$effect_date)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$arrear_emp_id)
										  ->where('br_join_date', '<=', $effect_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('emp_id')
						->first();
		
		if(!empty($max_id))
		{
			$emp_info = DB::table('tbl_master_tra as  m')
						->leftJoin('tbl_emp_basic_info as e', 'e.emp_id', '=', 'm.emp_id')
						->where('m.sarok_no', $max_id->sarok_no)
						->select('e.emp_name_eng') 
						->first();
			
		
		} 
		if(!empty($emp_info)) { 
			$data['arrear_emp_id'] 				= $arrear_emp_id;
			$data['emp_name'] 				= $emp_info->emp_name_eng; 
			$data['error'] 					= '';
		
		} else {
			$data['arrear_emp_id'] 				= '';
			$data['emp_name'] 				= ''; 
			$data['error'] 					= 1;
		}
		return $data;
	}
}
