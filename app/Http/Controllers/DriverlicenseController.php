<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use File;
use Session;
class DriverlicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	  public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
    public function index()
    {
		$data = array();
		
		$data['emp_document_list'] = DB::table('tbl_edms_driver_license as docu')
									 //->leftJoin('tbl_emp_basic_info as emp', 'docu.emp_id', '=', 'emp.emp_id') 
									 ->leftJoin('tbl_emp_basic_info as emp',function($join){
											$join->on("emp.emp_id","=","docu.emp_id");
										}) 
									
									 //->leftJoin('tbl_emp_non_id as nid', 'docu.emp_id', '=', 'nid.emp_id' 'and' 'docu.emp_id', '=', 'nid.emp_id') 
									->orderby('docu.dri_license_id','desc')
									->select('docu.*','emp.emp_name_eng as emp_name')
									->get();  
		 /*   echo '<pre>';
		print_r($data['emp_document_list']); 
		exit;   */
		return view('admin.document.emp_driver_license_list',$data);
    } 
    public function add_create()
    { 
		$data = array(); 
		$data['method_control'] 	= '';
		$data['action'] 			= 'insert_license/'; 
		$data['button']				= 'Save';
		$data['required']			= 'required';
		$data['emp_name']		= '';
		$data['designation_code']	= '';
		$data['branch_code']		= ''; 
		$data['license_exp_date']		= '';
		$data['license_number']		= '';
		$data['document_name']		= ''; 
		$data['dri_license_id'] 	= 0; 
		$data['emp_id'] 			= '';   
		$data['emp_type_list'] = DB::table('tbl_emp_type') 
									->where('status',1) 
									->get();
		return   view('admin.document.emp_driver_license_form',$data);
	/* 	echo 'ok';
		exit; */
    } 
	public function select_empinfo_driver($emp_id)
    {  
		
			$current_date = date('Y-m-d');
			
			$max_sarok = DB::table('tbl_master_tra as m')
							->where('m.emp_id', '=', $emp_id)
							->where('m.br_join_date', '=', function($query) use ($emp_id,$current_date)
									{
										$query->select(DB::raw('max(br_join_date)'))
											  ->from('tbl_master_tra')
											  ->where('emp_id',$emp_id)
											  ->where('br_join_date', '<=', $current_date);
									})
							->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
							->groupBy('emp_id')
							->first();	 
			//print_r ($data['max_br_join_date']);		
			$emp_info = DB::table('tbl_master_tra as m') 
								->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id')  
								->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
								->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
								->where('m.sarok_no', '=', $max_sarok->sarok_no)
								->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name')
								->first();	
		
		//echo 'ok';
		
		 if(!empty($emp_info)){
			echo $emp_info->emp_id.','.$emp_info->br_code.','.$emp_info->branch_name.','.$emp_info->emp_name.','.$emp_info->designation_code.','.$emp_info->designation_name;  
		}else{
			echo '';
		} 
	}  
    public function insert_license(Request $request)
    {	
		$data = array();  
        $data['emp_id'] 				= $request->emp_id;  
        $data['license_exp_date'] 		= $request->license_exp_date;
        $data['license_number'] 		= $request->license_number;
        $data['status'] 				= 1;
        $data['user_id'] 				= Session::get('admin_id'); 
		$images = $request->file('document_name'); 
		$ext = strtolower($images->getClientOriginalExtension());
		
		$image_full_name = $data['license_exp_date'].'-'.$data['emp_id'].'.'.$ext; 
		$upload_path ='storage/attachments/driver_license/';  
		$image_url = $upload_path.$image_full_name;
		
		$success = $images->move($upload_path,$image_full_name);
		/*  echo '<pre>';
		print_r($success);
		exit;   */
		if($success){
			$data['document_name'] = $image_full_name;
			$insert_id = DB::table('tbl_edms_driver_license')->insertGetId($data); 
			Session::put('msg_serial',$insert_id);
			
		} 
		return Redirect::to('/add_license');
    } 
    public function edit_license($id)
    { 
		$data = array(); 
		$data['action'] 			= "update_license/";  
		$data['button']				= 'Update';
		$data['required']			= '';
		$data['method_control'] 	="<input type='hidden' name='_method' value='PUT' />"; 
		$document_by_id 			= DB::table('tbl_edms_driver_license as docu')
										->leftJoin('tbl_appointment_info as emp', 'docu.emp_id', '=', 'emp.emp_id')
										->where('docu.dri_license_id',$id)
										->select('docu.*','emp.emp_name')
										->first();
		$emp_id = $data['emp_id']				= $document_by_id->emp_id; 
	 
			$current_date = date('Y-m-d'); 
			$max_sarok = DB::table('tbl_master_tra as m')
							->where('m.emp_id', '=', $emp_id)
							->where('m.br_join_date', '=', function($query) use ($emp_id,$current_date)
									{
										$query->select(DB::raw('max(br_join_date)'))
											  ->from('tbl_master_tra')
											  ->where('emp_id',$emp_id)
											  ->where('br_join_date', '<=', $current_date);
									})
							->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
							->groupBy('emp_id')
							->first();			
			$data['emp_info']= $emp_info = DB::table('tbl_master_tra as m') 
								->leftJoin('tbl_appointment_info as emp', 'emp.emp_id', '=', 'm.emp_id')  
								->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
								->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
								->where('m.sarok_no', '=', $max_sarok->sarok_no)
								->select('emp.emp_id','emp.emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name')
								->first();  
		 
		
		$data['emp_name']			= $emp_info->emp_name;
		$data['dri_license_id']		= $id;
		$data['designation_code']	= $emp_info->designation_name;
		$data['branch_code']		= $emp_info->branch_name; 
		$data['license_exp_date']		= $document_by_id->license_exp_date;
		$data['license_number']		= $document_by_id->license_number;
		$data['document_name']		= $document_by_id->document_name;  
		return   view('admin.document.emp_driver_license_form',$data);
    } 
    public function update_license(Request $request)
    {
		$data = array(); 
	    $data['emp_id'] 				= $request->emp_id;   
	    $dri_license_id 				= $request->dri_license_id; 
        $data['license_exp_date'] 		= $request->license_exp_date;
        $data['license_number'] 		= $request->license_number;
        $hidden_document_name			= $request->hidden_document_name;
        $data['user_id'] 				= Session::get('admin_id');; 
		$images 						= $request->file('document_name'); 
		if($images){
			$ext = strtolower($images->getClientOriginalExtension());
			 
		    $image_full_name = $data['license_exp_date'].'-'.$data['emp_id'].'.'.$ext;
			 
			/*  echo '<pre>';
			print_r($image_full_name);
			exit;  */ 
			if($hidden_document_name){
				$file_name = "storage/attachments/driver_license/$hidden_document_name";
				File::delete($file_name);
			} 
			$upload_path ='storage/attachments/driver_license/';  
			$image_url = $upload_path.$image_full_name;
			$success = $images->move($upload_path,$image_full_name);
			if($success){
				$data['document_name'] = $image_full_name;
				DB::table('tbl_edms_driver_license')
				->where('dri_license_id', $dri_license_id)
				->update($data);
			} 
		}else{
			DB::table('tbl_edms_driver_license')
				->where('dri_license_id', $dri_license_id)
				->update($data);
		} 
		return Redirect::to('/add_license');
	   
    }
	public function license_view($emp_id,$dri_license_id)
    {
		$data = array(); 
		$data['action'] = "/license_attachment"; 
		$data['license_exp_date']	='';
		$data['license_number']		='';  
		$data['emp_document_list'] = DB::table('tbl_edms_driver_license as docu')
									->where('docu.dri_license_id',$dri_license_id)   
									->where('docu.emp_id',$emp_id)  
									->select('docu.*')
									->first(); 
		 
			$current_date = date('Y-m-d');
			$max_sarok = DB::table('tbl_master_tra as m')
							->where('m.emp_id', '=', $emp_id)
							->where('m.br_join_date', '=', function($query) use ($emp_id,$current_date)
									{
										$query->select(DB::raw('max(br_join_date)'))
											  ->from('tbl_master_tra')
											  ->where('emp_id',$emp_id)
											  ->where('br_join_date', '<=', $current_date);
									})
							->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
							->groupBy('emp_id')
							->first();	
			$data['emp_info']= $emp_info = DB::table('tbl_master_tra as m') 
										->leftJoin('tbl_appointment_info as emp', 'emp.emp_id', '=', 'm.emp_id')  
										->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
										->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
										->where('m.sarok_no', '=', $max_sarok->sarok_no)
										->select('emp.emp_id','emp.emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name')
										->first();	  
		  
		  
		    $data['emp_id']					= $emp_id; 
			$data['emp_name']				= $emp_info->emp_name;
			$data['designation_code']	  	= $emp_info->designation_name;
			$data['branch_code']			= $emp_info->branch_name;	
			
		 if(!empty($data['emp_document_list'])){
		    $data['license_exp_date']		= $data['emp_document_list']->license_exp_date;
		    $data['license_number']		= $data['emp_document_list']->license_number;
		    $data['created_at']		= $data['emp_document_list']->created_at;
	    }		
		
		return view('admin.document.emp_license_view_record',$data);
    }
	public function license_view1()
    {
		$data = array(); 
		$data['action'] = "/license_attachment"; 
		$data['emp_name']		= '';
		$data['designation_code']	= '';
		$data['branch_code']		= '';	 
		$data['emp_id']				= '';	
		$data['license_exp_date']		='';			
		$data['license_number']		=''; 	
		$data['emp_type_list'] = DB::table('tbl_emp_type') 
									->where('status',1) 
									->get();
		return view('admin.document.emp_license_view_record',$data);
    }
	public function license_attachment(Request $request)
    {
		$data = array();  
		$data['license_exp_date']		='';	
		$data['license_number']		='';	
		$data['emp_type_list'] = DB::table('tbl_emp_type') 
									->where('status',1) 
									->get();
		if(isset($request->emp_id1)){
			$emp_id 		= $request->emp_id1;
		}else{
			$emp_id 		= '';
		} 
		$data['emp_id']				= $emp_id;	 	
		$data['action'] = "/license_attachment"; 
		$data['emp_document_list'] = DB::table('tbl_edms_driver_license as docu')  
							->where('docu.emp_id',$emp_id) 
							->select('docu.*')
							->first();  
		 
			 $current_date = date('Y-m-d'); 
					$max_sarok = DB::table('tbl_master_tra as m')
							->where('m.emp_id', '=', $emp_id)
							->where('m.br_join_date', '=', function($query) use ($emp_id,$current_date)
									{
										$query->select(DB::raw('max(br_join_date)'))
											  ->from('tbl_master_tra')
											  ->where('emp_id',$emp_id)
											  ->where('br_join_date', '<=', $current_date);
									})
							->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
							->groupBy('emp_id')
							->first();	
				$data['emp_info']= $emp_info = DB::table('tbl_master_tra as m') 
								->leftJoin('tbl_appointment_info as emp', 'emp.emp_id', '=', 'm.emp_id')  
								->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
								->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
								->where('m.sarok_no', '=', $max_sarok->sarok_no)
								->select('emp.emp_id','emp.emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name')
								->first();	
		  
		 	
				 
	/* print_r($data['subcategory_list']);
	exit;  */
	if(!empty($data['emp_document_list'])){
		    $data['license_exp_date']		= $data['emp_document_list']->license_exp_date;
		    $data['created_at']			= $data['emp_document_list']->created_at;
		    $data['license_number']		= $data['emp_document_list']->license_number;
	    }	
	if(!empty($emp_info)){
		$data['emp_name']		= $emp_info->emp_name;
		$data['designation_code']	= $emp_info->designation_name;
		$data['branch_code']		= $emp_info->branch_name;	
	}else{
		$data['emp_name']		= '';
		$data['designation_code']	= '';
		$data['branch_code']		= '';
	}
	return view('admin.document.emp_license_view_record',$data);
   }
	 public function delete_license($emp_id,$dri_license_id){
	   
	  $emp_document = DB::table('tbl_edms_driver_license as docu') 
							->where('docu.emp_id',$emp_id) 
							->where('docu.dri_license_id',$dri_license_id) 
							->select('docu.document_name') 
							->first();  
		$hidden_document_name = $emp_document->document_name;
							
		$file_name = "storage/attachments/driver_license/$hidden_document_name";
		
		File::delete($file_name);  
		 
		DB::table('tbl_edms_driver_license')
			->where('emp_id',$emp_id) 
			->where('dri_license_id',$dri_license_id) 
			->delete();
		return Redirect::to('/add_license');
   }
    public function check_exist_driver_license($license_exp_date,$emp_id,$dri_license_id){
	  if($dri_license_id == 0){
		   $emp_document = DB::table('tbl_edms_driver_license as docu') 
							->where('docu.license_exp_date',$license_exp_date)
							->where('docu.emp_id',$emp_id) 
							->select('docu.emp_id') 
							->first();  
	  }else{
		   $emp_document = DB::table('tbl_edms_driver_license as docu') 
							->where('docu.license_exp_date',$license_exp_date) 
							->where('docu.emp_id',$emp_id) 
							->where('docu.dri_license_id','!=',$dri_license_id) 
							->select('docu.emp_id') 
							->first();  
	  }
	 
		if(!empty($emp_document)){
			echo 1;
		}else{
			echo 2;
		}
   }
}
