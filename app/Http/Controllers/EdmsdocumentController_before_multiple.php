<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use File;
use Session;
class EdmsdocumentController extends Controller
{
	 public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
   /*  public function saiful_edms_method(){
		
		$DOCU_list = DB::table('tbl_edms_document_sl') 
									->get();
		foreach($DOCU_list as $v_DOCU_list){
			$data = array();   
			$data['subcat_id'] = $v_DOCU_list->subcat_id;
			$data['category_id'] =$v_DOCU_list->category_id;
			$data['emp_id'] = $v_DOCU_list->emp_id;
			$data['document_name'] = $v_DOCU_list->document_name;
			$data['effect_date'] =  $v_DOCU_list->effect_date;
			$data['user_id'] =  $v_DOCU_list->user_id;
			$data['status'] =  $v_DOCU_list->status;
			DB::table('tbl_edms_document')->insertGetId($data);
		}			
		exit;
	} */
    public function index()
    { 
		$data = array(); 
		$user_emp_id 			= Session::get('emp_id');
		$data['Heading'] = $data['title'] = 'Add Document';
		$data['type_list'] = DB::table('tbl_emp_type') 
									->where('status',1) 
									->get();
		$data['emp_document_list'] = DB::table('tbl_edms_document as docu') 
									->leftJoin("tbl_emp_basic_info as emp",function($join){
											$join->on("emp.emp_id","=","docu.emp_id");
										}) 
									->leftJoin('tbl_edms_category as cat', 'docu.category_id', '=', 'cat.category_id')
									->leftJoin('tbl_edms_subcategory as subcat', 'docu.subcat_id', '=', 'subcat.subcat_id')
									/* ->where(function($query) use ($user_emp_id)
											{
												if ($user_emp_id != 3015 && $user_emp_id != 3627) {
													$query->where('docu.is_auto_increment','!=',1); 
												}  
											}) */		
									->where('docu.is_cancel',0) 
									->select('docu.*','emp.emp_name_eng as emp_name','cat.category_name','subcat.subcategory_name')
									->orderby('docu.document_id','desc')
									//->orderby('docu.effect_date','desc')
									->limit(300)
									->get();  
/*  echo '<pre>';
		print_r($data['emp_document_list']); 
		exit;   */ 
		return view('admin.document.emp_document_list',$data);
    }
	public function edms_document_hlist_index()
    {      
		
		return view('admin.document.emp_document_list_head');			
    }
	public function edms_document_hlist(Request $request)
    { 
		$emp_id_head = Session::get('emp_id');
		$user_emp_id 			= Session::get('emp_id'); 
		/* $emp_id_head = 4891;
		$user_emp_id 			= 4891; */
		$head_department = DB::table('department_head_mapping') 
									->where('dept_head_emp_id',$emp_id_head) 
									->where('status',1) 
									->first();
		$department_code    = $head_department->department_id; 
		
		$form_date = date("Y-m-d");
		//$department_code    = 26; 
			 $all_result  = DB::table('tbl_emp_mapping as e') 
							 ->where('e.current_department_id', $department_code)
							 ->where(function($q) use ($form_date) {
								 $q->where('e.start_date','<=', $form_date)->where('e.end_date','>=', $form_date)->orWhere('e.start_date','<=', $form_date)->whereNull('e.end_date')->orwhere('e.end_date','=','0000-00-00');
							 })  
							 ->select('e.emp_id') 
							 ->get()->toArray();  
		/*  echo "<pre>";
		 print_r($all_result);
		exit; */
		 $all_user = DB::table('tbl_edms_document as docu') 
						->leftJoin('tbl_admin as a', 'docu.user_id', '=', 'a.admin_id') 
						//->where('docu.user_id',17)
						->groupBy('docu.user_id')
						->pluck('a.emp_id')
						->toArray();  
		 $all_result = array_map('current',$all_result);
		 $common_emp_id = array_intersect($all_user,$all_result);	  
		 
		
		$columns = array( 
			0 =>'id', 
			1 =>'emp_id',
			2 =>'emp_name',
			3 =>'category_name',
			4 =>'subcategory_name',
			5 =>'effect_date',
			6 =>'status',
			6 =>'options',
		);
  
        $totalData = DB::table('tbl_edms_document as docu')
							 ->leftJoin('tbl_admin as a', 'docu.user_id', '=', 'a.admin_id')
							->whereIn('a.emp_id', $common_emp_id)
							->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {
			$emp_history = DB::table('tbl_edms_document as docu') 
									->leftJoin("tbl_emp_basic_info as emp",function($join){
											$join->on("emp.emp_id","=","docu.emp_id");
										}) 
									->leftJoin('tbl_edms_category as cat', 'docu.category_id', '=', 'cat.category_id')
									->leftJoin('tbl_edms_subcategory as subcat', 'docu.subcat_id', '=', 'subcat.subcat_id') 
									->leftJoin('tbl_admin as a', 'docu.user_id', '=', 'a.admin_id')
									/* ->where(function($query) use ($user_emp_id)
											{
												if ($user_emp_id != 3015 && $user_emp_id != 3627) {
													$query->where('docu.is_auto_increment','!=',1); 
												}  
											}) */
									->whereIn('a.emp_id', $common_emp_id)   
									->select('docu.*','emp.emp_name_eng as emp_name','cat.category_name','subcat.subcategory_name')
									->orderby('docu.document_id','desc')
									->orderby('docu.effect_date','desc')
									->offset($start)
									->limit($limit)
									->get();
									
        }
        else {
            $search = $request->input('search.value'); 
			
			$emp_history = DB::table('tbl_edms_document as docu') 
									->leftJoin("tbl_emp_basic_info as emp",function($join){
											$join->on("emp.emp_id","=","docu.emp_id");
										}) 
									->leftJoin('tbl_edms_category as cat', 'docu.category_id', '=', 'cat.category_id')
									->leftJoin('tbl_edms_subcategory as subcat', 'docu.subcat_id', '=', 'subcat.subcat_id') 
									  ->leftJoin('tbl_admin as a', 'docu.user_id', '=', 'a.admin_id')
									->select('docu.*','emp.emp_name_eng as emp_name','cat.category_name','subcat.subcategory_name')
									/* ->where(function($query) use ($user_emp_id)
											{
												if ($user_emp_id != 3015 && $user_emp_id != 3627) {
													$query->where('docu.is_auto_increment','!=',1); 
												}  
											}) */
									->whereIn('a.emp_id', $common_emp_id)
									->where('docu.emp_id', $search)
									->orderby('docu.document_id','desc')
									->orderby('docu.effect_date','desc')
									->offset($start)
									->limit($limit)
									->get();   
            $totalFiltered =  DB::table('tbl_edms_document as docu')
									->leftJoin('tbl_admin as a', 'docu.user_id', '=', 'a.admin_id') 
									->join('tbl_emp_basic_info', 'docu.emp_id', '=', 'tbl_emp_basic_info.emp_id' )
									->whereIn('a.emp_id', $common_emp_id)
									->where('tbl_emp_basic_info.emp_id', $search)
									->count();
        }

        $data = array();
        if(!empty($emp_history))
        {
            foreach ($emp_history as $v_emp_history)
            {
                $nestedData['id'] 					= $v_emp_history->document_id;
                $nestedData['emp_id'] 				= $v_emp_history->emp_id;
                $nestedData['emp_name'] 			= $v_emp_history->emp_name;
                $nestedData['category_name'] 		= $v_emp_history->category_name;
                $nestedData['subcategory_name'] 	= $v_emp_history->subcategory_name;
				$nestedData['effect_date'] 			= $v_emp_history->effect_date; 
				$status = '';
				$option = '';
				
				$ddd = explode('.', $v_emp_history->document_name);
				if ($ddd[1] == 'pdf' || $ddd[1] == 'PDF') {
						$ext = 1;
				} elseif ($ddd[1] == 'doc' || $ddd[1] == 'DOC') {
						$ext = 2;
				} else {
						$ext = 3;
				}
				if ($v_emp_history->category_id == 13) {
							$folder_name = 'c_v';
				} elseif ($v_emp_history->category_id == 5) {
							$folder_name = 'edu_cation';
				} elseif ($v_emp_history->category_id == 11) {
							$folder_name = 'miscell_aneous';
				} elseif ($v_emp_history->category_id == 24) {
							$folder_name = 'train_ing_info';
				} elseif ($v_emp_history->category_id == 2) {
							$folder_name = 'assessment';
				} else {
						if ($v_emp_history->effect_date == '2019-07-01' && $v_emp_history->category_id == 23 &&
						$v_emp_history->subcat_id == 24) {
						$folder_name = 'attach_ment_tran/auto_increment';
						} else {
						$folder_name = 'attach_ment_tran';
						}
				}
				$filename = "attachments/$folder_name/$v_emp_history->document_name";
				if($v_emp_history->is_cancel == 0){ 
						$status = "<span style='color:green';>Active</span>"; 
						$option = '<a class="btn bg-olive" target="_blank" href="'.$filename.'"><i class="fa fa-eye"></i></a> &nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-primary" onclick="return checkDelete();" title="Delete" href="edms_document_delete/'.$v_emp_history->document_id.'/'.$v_emp_history->category_id.'/'.$v_emp_history->document_name.'"> <i class="fa fa-trash-o" aria-hidden="true"></i></a>';
				}else {  
						$status = "<span style='color:red';>Inactive</span>";
						$option = '';
				}
				$nestedData['status'] 				= $status; 
				$nestedData['options'] 				= $option; 
				$data[] = $nestedData; 
            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
    }
	public function edms_search(Request $request)
    {
		$data = array();  
		$emp_id 				= $request->emp_id;  
		$user_emp_id 			= Session::get('emp_id');  
	    $data['emp_document_list'] = DB::table('tbl_edms_document as docu') 
									->leftJoin("tbl_emp_basic_info as emp",function($join){
											$join->on("emp.emp_id","=","docu.emp_id");
										}) 
									->leftJoin('tbl_edms_category as cat', 'docu.category_id', '=', 'cat.category_id')
									->leftJoin('tbl_edms_subcategory as subcat', 'docu.subcat_id', '=', 'subcat.subcat_id') 
									->where(function($query) use ($emp_id)
									{
										if (!empty($emp_id)) {
											$query->where('docu.emp_id',$emp_id);
											
										}  
									})
									/* ->where(function($query) use ($user_emp_id)
											{
												if ($user_emp_id != 3015 && $user_emp_id != 3627) {
													$query->where('docu.is_auto_increment','!=',1); 
												}  
											}) */
									->where('docu.is_cancel',0)
									->select('docu.*','emp.emp_name_eng as  emp_name','cat.category_name','subcat.subcategory_name')
									->orderby('docu.document_id','desc')
									->orderby('docu.effect_date','desc')
									->limit(300)
									->get();  
		
		/* echo '<pre>';
		print_r($data['emp_document_list']); 
		exit;  */
		return view('admin.document.emp_document_list',$data); 
   } 
    public function create()
    { 
		$data = array(); 
		$data['method_control'] 	= '';
		$data['Heading'] = $data['title'] = 'Add Document';
		$data['action'] 			= 'edms-document/'; 
		$data['button']				= 'Save';
		$data['mode']				= 'add';
		$data['required']			= 'required';
		$data['emp_name']		= '';
		$data['emp_image']		= '';
		$data['designation_code']	= '';
		$data['branch_code']		= '';
		$data['br_code']		= '';
		$data['category_id']		= '';
		$data['subcat_id']			= ''; 
		$data['effect_date']		= '';
		$data['document_name']		= ''; 
		$data['document_id']		= ''; 
		$data['emp_id'] 			= ''; 
		$data['category_list'] = DB::table('tbl_edms_category') 
									->where('status',1)
									->orderby('category_name','asc')
									->get();
		$data['type_list'] = DB::table('tbl_emp_type') 
									->where('status',1) 
									->get();
		$data['subcategory_list'] = DB::table('tbl_edms_subcategory') 
									->where('status',1)
									->orderby('subcategory_name','asc')
									->get();
		return   view('admin.document.emp_document_form',$data);
	/* 	echo 'ok';
		exit; */
    } 
	public function selectempinfo($emp_id)
    {  
		$asigndata = array(1,2,5); 
		$current_date = date('Y-m-d');
		$assign_emp = '';
		$assign_branch = '';
		$assign_designation = ''; 
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
				if($max_sarok){	
					$emp_info = DB::table('tbl_master_tra as m') 
									->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id') 
									->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
									->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name')
									->first(); 
					
					$assign_emp = DB::table('tbl_emp_assign as ea')
									->where('ea.emp_id',$emp_id)
									->where('ea.status', '!=', 0)
									->where('ea.select_type', '=', 1)
									->select('ea.emp_id','ea.open_date','ea.incharge_as')
									->first();
					$assign_branch = DB::table('tbl_emp_assign as ea')
												->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code')
												->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
												->where('ea.emp_id',$emp_id)
												->where('ea.open_date', '<=', $current_date)
												->where('ea.status', '!=', 0)
												->where('ea.select_type', '=', 2)
												->select('ea.emp_id','ea.open_date','br.branch_name','br.br_code','ar.area_name')
												->first();
					$assign_designation = DB::table('tbl_emp_assign as ea')
												->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
												->where('ea.emp_id',$emp_id)
												->where('ea.status', '!=', 0)
												->where('ea.select_type', '=', 5)
												->select('ea.emp_id','ea.open_date','de.designation_name','de.designation_code')
												->first(); 
					
					} 
		 if(!empty($emp_info)){
			  if(!empty($assign_emp)){
				 $incharge_as = $assign_emp->incharge_as; 
			 }else{
				 $incharge_as = ''; 
			 } 
			 if(!empty($assign_branch)){
				 $branch_name = $assign_branch->branch_name; 
				 $br_code = $assign_branch->br_code; 
			 }else{
				  $branch_name = $emp_info->branch_name; 
				 $br_code = $emp_info->br_code;
			 } 
			 if(!empty($assign_designation)){
				  $designation_name 	= $assign_designation->designation_name; 
				 $designation_code 		= $assign_designation->designation_code;
			 }else{
				  $designation_name = $emp_info->designation_name; 
				 $designation_code = $emp_info->designation_code;
			 }
			echo json_encode(
				array(
					'emp_id' 				=> $emp_info->emp_id, 
					'br_code' 				=> $br_code,
					'branch_name' 			=> $branch_name,
					'emp_name' 				=> $emp_info->emp_name,
					'designation_code' 		=> $designation_code,
					'designation_name' 		=> $designation_name,
					'incharge_as' 			=> $incharge_as
					)); 
		}else{
			 echo json_encode(
							array(
								'emp_id' => '', 
								'br_code' => '',
								'branch_name' => '',
								'emp_name' => '',
								'designation_code' => '',
								'designation_name' => '',
								'incharge_as' => ''
								)
							); 
		} 
	}
	public function selectsubcategory($category_id)
    {  
		$current_date = date('Y-m-d');
	 	$subcategory_list = DB::table('tbl_edms_subcategory')  
									->where('status',1)
									->where('category_id',$category_id) 
									->orderby('priority','asc')
									->orderby('subcategory_name','asc')
									->get();
		echo "<option value=''>--Select--</option>";
		foreach($subcategory_list as $subcategory){
			echo "<option value='$subcategory->subcat_id'>$subcategory->subcategory_name( $subcategory->subcat_id )</option>";
		} 
	} 
    public function store(Request $request)
    {	
		$data = array();  
        $data['emp_id'] 				= $emp_id = $request->emp_id; 
        $data['category_id'] 			= $request->category_id;
        $data['subcat_id'] 				= $request->subcat_id; 
        $data['effect_date'] 			= $request->effect_date;
        $data['status'] 				= 1;
        $data['user_id'] 				= Session::get('admin_id'); 
		$images = $request->file('document_name'); 
		$ext = strtolower($images->getClientOriginalExtension());
		$image_full_name = $data['emp_id'].'_'.$data['category_id'].'_'.$data['subcat_id'].'_'.$data['effect_date'].'.'.$ext;
		
		
		if($data['category_id'] == 13){
			$folder_name = "c_v/";
		}else if($data['category_id'] == 5){
			$folder_name = "edu_cation/";
		}else if($data['category_id'] == 11){
			$folder_name = "miscell_aneous/";
		}else if($data['category_id'] == 24){
			$folder_name = "train_ing_info/";
		}else if($data['category_id'] == 2){
			$folder_name = "assessment/";
		}else {
			$folder_name = "attach_ment_tran/";
		} 
		$upload_path ="attachments/$folder_name";  
		//$image_url = $upload_path.$image_full_name;
		$success = $images->move($upload_path,$image_full_name);
		/*  echo '<pre>';
		print_r($success);
		exit;   */
		if(($data['category_id'] == 21) && ($data['subcat_id'] == 69)){
			$result_info = DB::table('tbl_fp_file_info')
									->where('fp_emp_id', $emp_id) 
									->orderBy('id', 'DESC')
									->select('id','fp_emp_id')
									->first();
		}
		
		//print_r($result_info);exit; 
		if($success){
			$data['document_name'] = $image_full_name;
			DB::table('tbl_edms_document')->insertGetId($data); 
			 if(!empty($result_info)) {
				DB::table('tbl_fp_file_info')->where('id', $result_info->id)->update(['status' => 3]);
			}
			if(($data['category_id'] == 1) && ($data['subcat_id'] == 1)){
				$data['category_id'] = 23;
				$data['subcat_id']   = 46;
				DB::table('tbl_edms_document')->insertGetId($data); 
			}else if(($data['category_id'] == 23 ) && ($data['subcat_id'] == 46)){
				$data['category_id'] = 1;
				$data['subcat_id']   = 1;
				DB::table('tbl_edms_document')->insertGetId($data); 
			}
		} 
		Session::put('message','Data Saved Successfully.');
		return Redirect::to('/edms-document');
    }
    public function edms_document_edit($id)
    { 
		$data = array(); 
		$asigndata = array(1,2,5); 
		$data['Heading'] = $data['title'] = 'Edit Document';
		$data['action'] 			= "edms-document/$id";  
		$data['button']				= 'Update';
		$data['mode']				= 'edit';
		$data['required']			= '';
		$assign_emp = '';
		$assign_branch = '';
		$assign_designation = '';
		$data['method_control'] ="<input type='hidden' name='_method' value='PUT' />"; 
		 
			$document_by_id 			= DB::table('tbl_edms_document as docu')
										->join('tbl_emp_basic_info as emp',function($join){
												$join->on("emp.emp_id","=","docu.emp_id"); 
														})	
										->where('docu.document_id',$id)
										->select('docu.*','emp.emp_name_eng as emp_name')
										->first();
			$data['emp_id']				= $emp_id	= $document_by_id->emp_id;
			
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
				$emp_info = DB::table('tbl_master_tra as m') 
									->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id') 
									->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
									->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
									->leftJoin('tbl_department as dp', 'm.department_code', '=', 'dp.department_id')
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','dp.department_name')
									->first(); 
				$assign_emp = DB::table('tbl_emp_assign as ea')
									->where('ea.emp_id',$emp_id)
									->where('ea.status', '!=', 0)
									->where('ea.select_type', '=', 1)
									->select('ea.emp_id','ea.open_date','ea.incharge_as')
									->first();
				$assign_branch = DB::table('tbl_emp_assign as ea')
											->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code')
											->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
											->where('ea.emp_id',$emp_id)
											->where('ea.open_date', '<=', $current_date)
											->where('ea.status', '!=', 0)
											->where('ea.select_type', '=', 2)
											->select('ea.emp_id','ea.open_date','br.branch_name','br.br_code','ar.area_name')
											->first();
				$assign_designation = DB::table('tbl_emp_assign as ea')
											->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
											->where('ea.emp_id',$emp_id)
											->where('ea.status', '!=', 0)
											->where('ea.select_type', '=', 5)
											->select('ea.emp_id','ea.open_date','de.designation_name','de.designation_code')
											->first(); 
				if(!empty($assign_emp)){
					 $incharge_as = $assign_emp->incharge_as; 
				 }else{
					 $incharge_as = ''; 
				 } 
				 if(!empty($assign_branch)){
					 $branch_name = $assign_branch->branch_name; 
					 $br_code = $assign_branch->br_code; 
				 }else{
					  $branch_name = $emp_info->branch_name; 
					 $br_code = $emp_info->br_code;
				 } 
				 if(!empty($assign_designation)){
					  $designation_name 	= $assign_designation->designation_name; 
					 $designation_code 		= $assign_designation->designation_code;
				 }else{
					  $designation_name = $emp_info->designation_name; 
					 $designation_code = $emp_info->designation_code;
				 }
			
			
			$data['department_name']	= $emp_info->department_name;
			$data['emp_name']			= $emp_info->emp_name;
			$data['designation_code']	= $emp_info->designation_name;
			$data['branch_code']		= $emp_info->branch_name;
			$data['br_code']			= $br_code;
			$data['incharge_as']		= $incharge_as;
			  
		
		$data['category_id']		= $document_by_id->category_id;
		$data['subcat_id']			= $document_by_id->subcat_id; 
		$data['effect_date']		= $document_by_id->effect_date;
		$data['document_name']		= $document_by_id->document_name; 
		$data['document_id']		= $document_by_id->document_id; 
		$data['category_list']  	= DB::table('tbl_edms_category') 
											->where('status',1)
											->orderby('category_name','asc')
											->get();
		$data['subcategory_list']	 = DB::table('tbl_edms_subcategory')
											->where('status',1)
											->where('category_id',$data['category_id'])
											->orderby('subcategory_name','asc')
											->get();
		
		//echo $data['category_id'];
		$data['type_list'] = DB::table('tbl_emp_type') 
									->where('status',1) 
									->get();
		return   view('admin.document.emp_document_form',$data);
    }
    public function update(Request $request, $id)
    {
		$data = array();  
	    $emp_id 						= $data['emp_id'] 				= $request->emp_id;
        $category_id 					= $data['category_id']				= $request->category_id;
        $subcat_id 						= $data['subcat_id'] 				= $request->subcat_id; 
        $data['effect_date'] 			= $request->effect_date;
        $hidden_category_id			= $request->hidden_category_id;
        $hidden_document_name			= $request->hidden_document_name;
        $data['user_id'] 				= Session::get('admin_id');; 
		$images 						= $request->file('document_name'); 
		$data['updated_at'] 			= date("Y-m-d");
		if($images){
			$ext = strtolower($images->getClientOriginalExtension());
			$image_full_name = $data['emp_id'].'_'.$data['category_id'].'_'.$data['subcat_id'].'_'.$data['effect_date'].'.'.$ext;
			/* echo '<pre>';
			print_r($image_full_name);
			exit;  */
		   if($hidden_category_id == 13){
				$folder_name_hidden = "c_v";
			}else if($hidden_category_id == 5){
				$folder_name_hidden = "edu_cation";
			}else if($hidden_category_id == 11){
				$folder_name_hidden = "miscell_aneous";
			}else if($hidden_category_id == 24){
				$folder_name_hidden = "train_ing_info";
			}else if($hidden_category_id == 2){
				$folder_name_hidden = "assessment";
			}else {
				$folder_name_hidden = "attach_ment_tran";
			} 
			if($hidden_document_name){
				$file_name = "attachments/$folder_name_hidden/$hidden_document_name";
				File::delete($file_name);
			} 
			if($category_id == 13){
				$folder_name = "c_v";
			}else if($category_id == 5){
				$folder_name = "edu_cation";
			}else if($category_id == 11){
				$folder_name = "miscell_aneous";
			}else if($category_id == 24){
				$folder_name = "train_ing_info";
			}else if($category_id == 2){
				$folder_name = "assessment";
			}else {
				$folder_name = "attach_ment_tran";
			} 
			
			$upload_path ="attachments/$folder_name/";  
			//$image_url = $upload_path.$image_full_name;
			$success = $images->move($upload_path,$image_full_name);
			if(($category_id == 21) && ($subcat_id == 69)){
				$result_info = DB::table('tbl_fp_file_info')
									->where('fp_emp_id', $emp_id) 
									->orderBy('id', 'DESC')
									->select('id','fp_emp_id')
									->first();
			}
			
			if($success){
				$data['document_name'] = $image_full_name;
				DB::table('tbl_edms_document')
				->where('document_id', $id)
				->update($data);
				 if(!empty($result_info)) {
						DB::table('tbl_fp_file_info')->where('id', $result_info->id)->update(['status' => 3]);
					}
				if(($category_id == 1) && ($subcat_id == 1)){ 
					$data['category_id'] = 23;
					$data['subcat_id'] = 46;
					DB::table('tbl_edms_document')
						->where('is_cancel',0)
						->where('emp_id', $emp_id)
						->where('category_id', 23)
						->where('subcat_id', 46)
						->update($data);
				}else if(($category_id == 23) && ($subcat_id == 46)){
					$data['category_id'] = 1;
					$data['subcat_id'] = 1;
					DB::table('tbl_edms_document')
						->where('is_cancel',0)
						->where('emp_id', $emp_id)
						->where('category_id', 1)
						->where('subcat_id', 1)
						->update($data);
				}
			} 
		}else{
			
			if($category_id != $hidden_category_id){
				if($category_id == 13){
					$folder_name = "c_v";
				}else if($category_id == 5){
					$folder_name = "edu_cation";
				}else if($category_id == 11){
					$folder_name = "miscell_aneous";
				}else if($category_id == 24){
					$folder_name = "train_ing_info";
				}else if($category_id == 2){
					$folder_name = "assessment";
				}else {
					$folder_name = "attach_ment_tran";
				} 
				if($hidden_category_id == 13){
					$folder_name_hidden = "c_v";
				}else if($hidden_category_id == 5){
					$folder_name_hidden = "edu_cation";
				}else if($hidden_category_id == 11){
					$folder_name_hidden = "miscell_aneous";
				}else if($hidden_category_id == 24){
					$folder_name_hidden = "train_ing_info";
				}else if($hidden_category_id == 2){
					$folder_name_hidden = "assessment";
				}else {
					$folder_name_hidden = "attach_ment_tran";
				}
				$filePath = "attachments/$folder_name_hidden/$hidden_document_name";
				$destinationFilePath = "attachments/$folder_name/$hidden_document_name";
				rename($filePath, $destinationFilePath);
			}
			DB::table('tbl_edms_document')
				->where('document_id', $id)
				->update($data);
			if(($category_id == 1) && ($subcat_id == 1)){
					$data['category_id'] = 23;
					$data['subcat_id'] = 46; 
					DB::table('tbl_edms_document')
						->where('is_cancel',0)
						->where('emp_id', $emp_id)
						->where('category_id', 23)
						->where('subcat_id', 46)
						->update($data);
				}else if(($category_id == 23) && ($subcat_id == 46)){
					$data['category_id'] = 1;
					$data['subcat_id'] = 1;
					DB::table('tbl_edms_document')
						->where('is_cancel',0)
						->where('emp_id', $emp_id)
						->where('category_id', 1)
						->where('subcat_id', 1)
						->update($data);
				}	
		} 
		return Redirect::to('/edms-document');
	   
    }
	public function viewattachment($emp_id,$category_id,$subcat_id)
    {
		$data = array(); 
		
		$user_emp_id 			= Session::get('emp_id'); 
		$data['Heading'] = $data['title'] = 'View Document';
		$in_subcategory = [50,49,46];	 
		$pro_subcategory = [24,49,46];	 
		$tran_subcategory = [24,50,46];	 
		$prob_subcategory = [24,50,49];	
		$asigndata = array(1,2,5); 
		$assign_emp = '';
		$assign_branch = '';
		$assign_designation = '';
		$data['action'] = "/emp-attachment";
		$data['emp_id']				= $emp_id;			
		$data['department_name']	= '';					
		$data['category_id']		= $category_id;	
		$exam_name			= ''; 
		if($subcat_id == 0){
			$data['subcat_id']			='';
		}else{
			$data['subcat_id']			= $subcat_id;
		}	 
		$data['category_list'] = DB::table('tbl_edms_category') 
									->orderby('category_name','asc')
									->where('status',1)
									->get();
		$data['subcategory_list'] = DB::table('tbl_edms_subcategory') 
									->where('status',1)
									->orderby('subcategory_name','asc')
									->get();
		$data['type_list'] = DB::table('tbl_emp_type') 
									->where('status',1) 
									->get();
		
		if($category_id == 9){
			$data['emp_document_list'] = DB::table('tbl_edms_document as docu')
							->leftJoin('tbl_edms_category as cat', 'docu.category_id', '=', 'cat.category_id')
							->leftJoin('tbl_edms_subcategory as subcat', 'docu.subcat_id', '=', 'subcat.subcat_id')
							->where('docu.emp_id',$emp_id) 
							->where('docu.is_cancel',0)
							->where(function($query) use ($category_id, $subcat_id,$in_subcategory)
								{
									if (!empty($category_id)) {
										$query->whereIn('docu.category_id',[23,17]);
									}  
									if ($subcat_id != 0 ) {
										$query->where('docu.subcat_id',$subcat_id);
									}else{
										$query->whereNotIn('docu.subcat_id',$in_subcategory);
									}
								})
								/* ->where(function($query) use ($user_emp_id)
											{
												if ($user_emp_id != 3015 && $user_emp_id != 3627) {
													$query->where('docu.is_auto_increment','!=',1); 
												}  
											}) */
							->orderby('docu.effect_date','desc')
							->select('docu.*','cat.category_name','subcat.subcategory_name')
							->get(); 
		}else if($category_id == 17){
			$data['emp_document_list'] = DB::table('tbl_edms_document as docu')
							->leftJoin('tbl_edms_category as cat', 'docu.category_id', '=', 'cat.category_id')
							->leftJoin('tbl_edms_subcategory as subcat', 'docu.subcat_id', '=', 'subcat.subcat_id')
							->where('docu.emp_id',$emp_id) 
							->where('docu.is_cancel',0)
							->where(function($query) use ($category_id, $subcat_id,$pro_subcategory)
								{
									if (!empty($category_id)) {
										$query->whereIn('docu.category_id',[23,17]);
									}  
									if ($subcat_id != 0 ) {
										$query->where('docu.subcat_id',$subcat_id);
									}else{ 
										$query->whereNotIn('docu.subcat_id',$pro_subcategory);
									}  
								})
								/* ->where(function($query) use ($user_emp_id)
											{
												if ($user_emp_id != 3015 && $user_emp_id != 3627) {
													$query->where('docu.is_auto_increment','!=',1); 
												}  
											}) */
							->orderby('docu.effect_date','desc')
							->select('docu.*','cat.category_name','subcat.subcategory_name')
							->get(); 
		}else if($category_id == 16){
			$data['emp_document_list'] = DB::table('tbl_edms_document as docu')
							->leftJoin('tbl_edms_category as cat', 'docu.category_id', '=', 'cat.category_id')
							->leftJoin('tbl_edms_subcategory as subcat', 'docu.subcat_id', '=', 'subcat.subcat_id')
							->where('docu.emp_id',$emp_id) 
							->where('docu.is_cancel',0)
							->where(function($query) use ($category_id, $subcat_id,$tran_subcategory)
								{
									if (!empty($category_id)) {
										$query->whereIn('docu.category_id',[23,16]);
									}  
									if ($subcat_id != 0 ) {
										$query->where('docu.subcat_id',$subcat_id);
									}else{ 
										$query->whereNotIn('docu.subcat_id',$tran_subcategory);
									}  
								})
								/* ->where(function($query) use ($user_emp_id)
											{
												if ($user_emp_id != 3015 && $user_emp_id != 3627) {
													$query->where('docu.is_auto_increment','!=',1); 
												}  
											}) */
							->orderby('docu.effect_date','desc')
							->select('docu.*','cat.category_name','subcat.subcategory_name')
							->get(); 
			
		}else if($category_id == 15){
			$data['emp_document_list'] = DB::table('tbl_edms_document as docu')
							->leftJoin('tbl_edms_category as cat', 'docu.category_id', '=', 'cat.category_id')
							->leftJoin('tbl_edms_subcategory as subcat', 'docu.subcat_id', '=', 'subcat.subcat_id')
							->where('docu.emp_id',$emp_id) 
							->where('docu.is_cancel',0)
							->where(function($query) use ($category_id, $subcat_id,$prob_subcategory)
								{
									if (!empty($category_id)) {
										$query->whereIn('docu.category_id',[23,15]);
									}  
									if ($subcat_id != 0 ) {
										$query->where('docu.subcat_id',$subcat_id);
									}else{ 
										$query->whereNotIn('docu.subcat_id',$prob_subcategory);
									}  
								})
								/* ->where(function($query) use ($user_emp_id)
											{
												if ($user_emp_id != 3015 && $user_emp_id != 3627) {
													$query->where('docu.is_auto_increment','!=',1); 
												}  
											}) */
							->orderby('docu.effect_date','desc')
							->select('docu.*','cat.category_name','subcat.subcategory_name')
							->get(); 
		}else{
		
		
		$data['emp_document_list'] = DB::table('tbl_edms_document as docu')
							->leftJoin('tbl_edms_category as cat', 'docu.category_id', '=', 'cat.category_id')
							->leftJoin('tbl_edms_subcategory as subcat', 'docu.subcat_id', '=', 'subcat.subcat_id')
							->where('docu.emp_id',$emp_id) 
							->where('docu.is_cancel',0)
							->where(function($query) use ($category_id, $subcat_id)
								{
									if (!empty($category_id)) {
										$query->where('docu.category_id',$category_id);
									}  
									if ($subcat_id != 0 ) {
										$query->where('docu.subcat_id',$subcat_id);
									}  
								})
								/* ->where(function($query) use ($user_emp_id)
											{
												if ($user_emp_id != 3015 && $user_emp_id != 3627) {
													$query->where('docu.is_auto_increment','!=',1); 
												}  
											}) */
							->orderby('docu.effect_date','desc')
							->select('docu.*','cat.category_name','subcat.subcategory_name')
							->get(); 
		}
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
						
					$emp_info = DB::table('tbl_master_tra as m') 
									->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id')
									->leftJoin('tbl_grade_new as g', 'g.grade_code', '=', 'm.grade_code')
									->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
									->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
									->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
									->leftJoin('tbl_department as dp', 'm.department_code', '=', 'dp.department_id')
									->leftJoin(DB::raw("(SELECT exf.emp_id,max(exf.level_id) as level_id
											FROM tbl_emp_edu_info as exf GROUP BY exf.emp_id) as em"),
											'em.emp_id','=','emp.emp_id')
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','g.grade_name','dp.department_name','r.effect_date as c_effect_date','em.level_id')
									->first(); 
					if (!empty($emp_info->level_id)) {
								$exam_result = DB::table('tbl_emp_edu_info as ed')
									->leftJoin('tbl_exam_name as en', 'ed.exam_code', '=', 'en.exam_code')
									->where('ed.emp_id', '=', $emp_id)
									->where('ed.level_id', '=', $emp_info->level_id)
									->select('en.exam_name')
									->first();
									//print_r ($exam_result);
									$exam_name = $exam_result->exam_name;
							}	
					$assign_emp = DB::table('tbl_emp_assign as ea')
									->where('ea.emp_id',$emp_id)
									->where('ea.status', '!=', 0)
									->where('ea.select_type', '=', 1)
									->select('ea.emp_id','ea.open_date','ea.incharge_as')
									->first();
					$assign_branch = DB::table('tbl_emp_assign as ea')
												->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code')
												->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
												->where('ea.emp_id',$emp_id)
												->where('ea.open_date', '<=', $current_date)
												->where('ea.status', '!=', 0)
												->where('ea.select_type', '=', 2)
												->select('ea.emp_id','ea.open_date','br.branch_name','br.br_code','ar.area_name')
												->first();
					$assign_designation = DB::table('tbl_emp_assign as ea')
												->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
												->where('ea.emp_id',$emp_id)
												->where('ea.status', '!=', 0)
												->where('ea.select_type', '=', 5)
												->select('ea.emp_id','ea.open_date','de.designation_name','de.designation_code')
												->first();  
					 $department_name			= $emp_info->department_name;
					 $data['grade_name']			= $emp_info->grade_name;
		
	 	
		$data['emp_history_promotion'] = DB::table('tbl_promotion')
										->where('tbl_promotion.emp_id',$emp_id)   
										->select('tbl_promotion.emp_id','tbl_promotion.effect_date','tbl_promotion.letter_date','tbl_promotion.grade_code')
										->get(); 	
		$data['emp_history_transfer'] = DB::table('tbl_transfer')
										->leftJoin('tbl_branch as br', 'br.br_code', '=', 'tbl_transfer.br_code')
										->where('tbl_transfer.emp_id',$emp_id)   
										->select('tbl_transfer.emp_id','tbl_transfer.br_joined_date','tbl_transfer.letter_date','br.branch_name')
										->get(); 
		
		
			if(!empty($assign_emp)){
				 $incharge_as = $assign_emp->incharge_as; 
			 }else{
				 $incharge_as = ''; 
			 } 
			 if(!empty($assign_branch)){
				 $branch_name = $assign_branch->branch_name; 
				 $br_code = $assign_branch->br_code; 
			 }else{
				  $branch_name = $emp_info->branch_name; 
				 $br_code = $emp_info->br_code;
			 } 
			 if(!empty($assign_designation)){
				  $designation_name 	= $assign_designation->designation_name; 
				 $designation_code 		= $assign_designation->designation_code;
			 }else{
				  $designation_name = $emp_info->designation_name; 
				 $designation_code = $emp_info->designation_code;
			 }
		
		$data['exam_name']			= $exam_name;
		$data['emp_name']			= $emp_info->emp_name;
		$data['c_effect_date']		= $emp_info->c_effect_date;
		$data['emp_image']			= $emp_info->emp_id.'.'.'jpg';
		$data['designation_code']	= $designation_name;
		$data['department_name']		= $department_name;			
		$data['branch_code']		= $branch_name;			
		$data['br_code']			= $br_code;			
		$data['category_id']		= $category_id;			
		$data['subcat_id']			= $subcat_id;
		$data['incharge_as']		= $incharge_as;		
		
		return view('admin.document.emp_view_record',$data);
    }
	public function viewattachment1()
    {
		$data = array(); 
		$data['Heading'] = $data['title'] = 'View Document';
		$data['action'] = "/emp-attachment";
		$data['category_list'] = DB::table('tbl_edms_category') 
									->orderby('category_name','asc')
									->where('status',1)
									->get();
		$data['subcategory_list'] = DB::table('tbl_edms_subcategory') 
									->orderby('subcategory_name','asc')
									->get(); 
		$data['emp_name']		= 1;
		$data['emp_image']		= 'h.jpg';
		$data['designation_code']	= '';
		$data['branch_code']		= '';	
		$data['br_code']		= '';	
		$data['category_id']		= '';			
		$data['subcat_id']			= '';
		$data['emp_id']				= '';	 		
		$data['c_effect_date']			= 1; 
		
		/* echo '<pre>';
		print_r($data['emp_document_list']);
		exit; */
		return view('admin.document.emp_view_record',$data);
    }
	public function empattachment(Request $request)
    {
		$data = array();   
		$user_emp_id 			= Session::get('emp_id'); 
		$data['Heading'] = $data['title'] = 'View Document';
		$in_subcategory = [50,49,46];	 
		$pro_subcategory = [24,49,46];	 
		$tran_subcategory = [24,50,46];	 
		$prob_subcategory = [24,50,49];	
		$asigndata = array(1,2,5);
		$assign_emp = '';
		$assign_branch = '';
		$assign_designation = '';
		$department_name = '';
		$exam_name			= '';  
		if(isset($request->emp_id1)){
			$emp_id 		= $request->emp_id1;
		}else{
			$emp_id 		= '';
		}
		if(isset($request->category_id)){
			$category_id 		= $request->category_id;
		}else{
			$category_id 		= '';
		}
		if(isset($request->subcat_id)){
			$subcat_id 		= $request->subcat_id;
		}else{
			$subcat_id 		= '';
		} 
		$data['emp_id']				= $emp_id;		 			
		$data['category_id']		= $category_id;			
		$data['subcat_id']			= $subcat_id;
		$data['action'] = "/emp-attachment";
		$data['type_list'] = DB::table('tbl_emp_type') 
									->where('status',1) 
									->get();
		$data['category_list'] = DB::table('tbl_edms_category') 
									->where('status',1)
									->orderby('category_name','asc')
									->get();
		$data['subcategory_list'] = DB::table('tbl_edms_subcategory') 
									->where(function($query) use ($category_id)
										{
											if (!empty($category_id)) {
												$query->where('category_id',$category_id);
											}  
										})
									->orderby('subcategory_name','asc')
									->where('status',1)
									->get();
		// Multiple ID's File							
		$sql = 'SELECT * FROM tbl_appointment_info WHERE emp_id IN( SELECT DISTINCT (emp_id) as emp_id FROM ((SELECT emp_id FROM tbl_appointment_info WHERE emp_id IN(SELECT emp_id FROM ((SELECT emp_id FROM tbl_appointment_info WHERE emp_id = '.$emp_id.' ) UNION ALL(SELECT reference_id as emp_id FROM tbl_appointment_info	WHERE emp_id = '.$emp_id.' )	) main)) UNION ALL ( SELECT emp_id FROM tbl_appointment_info  WHERE emp_id IN( SELECT reference_id FROM tbl_appointment_info WHERE emp_id IN(	SELECT emp_id FROM ((SELECT emp_id FROM tbl_appointment_info WHERE emp_id = '.$emp_id.') UNION ALL ( SELECT reference_id as emp_id FROM tbl_appointment_info WHERE emp_id = '.$emp_id.')) main))))all_data)';
		$results = DB::select($sql);
		$emp = array();
		foreach($results as $row){
			$emp[] = $row->emp_id;
		}		
		
		if($category_id == 9){
			$data['emp_document_list'] = DB::table('tbl_edms_document as docu')
							->leftJoin('tbl_edms_category as cat', 'docu.category_id', '=', 'cat.category_id')
							->leftJoin('tbl_edms_subcategory as subcat', 'docu.subcat_id', '=', 'subcat.subcat_id')
							->whereIn('docu.emp_id',$emp) 
							->where('docu.is_cancel',0)
							->where(function($query) use ($category_id, $subcat_id,$in_subcategory)
								{
									if (!empty($category_id)) {
										$query->whereIn('docu.category_id',[23,9]);
										
									}  
									if (!empty($subcat_id)) {
										$query->where('docu.subcat_id',$subcat_id);
									}else{
										$query->whereNotIn('docu.subcat_id',$in_subcategory);
									}
								})
								/* ->where(function($query) use ($user_emp_id)
											{
												if ($user_emp_id != 3015 && $user_emp_id != 3627) {
													$query->where('docu.is_auto_increment','!=',1); 
												}  
											}) */
							->orderby('docu.effect_date','desc')
							->select('docu.*','cat.category_name','subcat.subcategory_name')
							->get(); 
		}else if($category_id == 17){
			$data['emp_document_list'] = DB::table('tbl_edms_document as docu')
							->leftJoin('tbl_edms_category as cat', 'docu.category_id', '=', 'cat.category_id')
							->leftJoin('tbl_edms_subcategory as subcat', 'docu.subcat_id', '=', 'subcat.subcat_id')
							->whereIn('docu.emp_id',$emp)  
							->where('docu.is_cancel',0)
							->where(function($query) use ($category_id, $subcat_id,$pro_subcategory)
								{
									if (!empty($category_id)) {
										$query->whereIn('docu.category_id',[23,17]);
										  
									}  
									if (!empty($subcat_id) ) {
										$query->where('docu.subcat_id',$subcat_id);
									}else{ 
										$query->whereNotIn('docu.subcat_id',$pro_subcategory);
									}  
								})
								/* ->where(function($query) use ($user_emp_id)
											{
												if ($user_emp_id != 3015 && $user_emp_id != 3627) {
													$query->where('docu.is_auto_increment','!=',1); 
												}  
											}) */
							->orderby('docu.effect_date','desc')
							->select('docu.*','cat.category_name','subcat.subcategory_name')
							->get(); 
		
			/* echo '<pre>'; 
	  print_r($data['emp_document_list']);
	exit; */
		}else if($category_id == 16){
			$data['emp_document_list'] = DB::table('tbl_edms_document as docu')
							->leftJoin('tbl_edms_category as cat', 'docu.category_id', '=', 'cat.category_id')
							->leftJoin('tbl_edms_subcategory as subcat', 'docu.subcat_id', '=', 'subcat.subcat_id')
							->whereIn('docu.emp_id',$emp)  
							->where('docu.is_cancel',0)
							->where(function($query) use ($category_id, $subcat_id,$tran_subcategory)
								{
									if (!empty($category_id)) {
										$query->whereIn('docu.category_id',[23,16]); 
									}  
									if (!empty($subcat_id)) {
										$query->where('docu.subcat_id',$subcat_id);
									}else{ 
										$query->whereNotIn('docu.subcat_id',$tran_subcategory);
									}  
								})
								/* ->where(function($query) use ($user_emp_id)
											{
												if ($user_emp_id != 3015 && $user_emp_id != 3627) {
													$query->where('docu.is_auto_increment','!=',1); 
												}  
											}) */
							->orderby('docu.effect_date','desc')
							->select('docu.*','cat.category_name','subcat.subcategory_name')
							->get(); 
	/* 	echo '<pre>';
			print_r($data['emp_document_list']);
			exit; */
		}else if($category_id == 15){
			$data['emp_document_list'] = DB::table('tbl_edms_document as docu')
							->leftJoin('tbl_edms_category as cat', 'docu.category_id', '=', 'cat.category_id')
							->leftJoin('tbl_edms_subcategory as subcat', 'docu.subcat_id', '=', 'subcat.subcat_id')
							->whereIn('docu.emp_id',$emp)   
							->where('docu.is_cancel',0)
							->where(function($query) use ($category_id, $subcat_id,$prob_subcategory)
								{
									if (!empty($category_id)) {
										$query->whereIn('docu.category_id',[23,15]); 
									}  
									if (!empty($subcat_id) ) {
										$query->where('docu.subcat_id',$subcat_id);
									}else{ 
										$query->whereNotIn('docu.subcat_id',$prob_subcategory);
									}  
								})
								/* ->where(function($query) use ($user_emp_id)
											{
												if ($user_emp_id != 3015 && $user_emp_id != 3627) {
													$query->where('docu.is_auto_increment','!=',1); 
												}  
											}) */
							->orderby('docu.effect_date','desc')
							->select('docu.*','cat.category_name','subcat.subcategory_name')
							->get(); 
		}else{
		$data['emp_document_list'] = DB::table('tbl_edms_document as docu')
										->leftJoin('tbl_edms_category as cat', 'docu.category_id', '=', 'cat.category_id')
										->leftJoin('tbl_edms_subcategory as subcat', 'docu.subcat_id', '=', 'subcat.subcat_id')
										->whereIn('docu.emp_id',$emp) 
										->where('docu.is_cancel',0)
										->where(function($query) use ($category_id, $subcat_id)
											{
												if (!empty($category_id)) {
													$query->where('docu.category_id',$category_id);
												}  
												if (!empty($subcat_id)) {
													$query->where('docu.subcat_id',$subcat_id);
												}  
											})
											/* ->where(function($query) use ($user_emp_id)
											{
												if ($user_emp_id != 3015 && $user_emp_id != 3627) {
													$query->where('docu.is_auto_increment','!=',1); 
												}  
											}) */
										->orderby('docu.effect_date','desc')
										->select('docu.*','cat.category_name','subcat.subcategory_name')
										->get();  
		}
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
						if(!empty($max_sarok)){
							$emp_info = DB::table('tbl_master_tra as m') 
											->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id') 
											->leftJoin('tbl_grade_new as g', 'g.grade_code', '=', 'm.grade_code')
											->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
											->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
											->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
											->leftJoin('tbl_department as dp', 'm.department_code', '=', 'dp.department_id') 
											->leftJoin(DB::raw("(SELECT exf.emp_id,max(exf.level_id) as level_id
											FROM tbl_emp_edu_info as exf GROUP BY exf.emp_id) as em"),
											'em.emp_id','=','emp.emp_id')
											->where('m.sarok_no', '=', $max_sarok->sarok_no)
											->select('emp.emp_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','r.effect_date as c_effect_date','d.designation_code','b.branch_name','g.grade_name','dp.department_name','em.level_id')
											->first(); 
							
						if (!empty($emp_info->level_id)) {
								$exam_result = DB::table('tbl_emp_edu_info as ed')
									->leftJoin('tbl_exam_name as en', 'ed.exam_code', '=', 'en.exam_code')
									->where('ed.emp_id', '=', $emp_id)
									->where('ed.level_id', '=', $emp_info->level_id)
									->select('en.exam_name')
									->first();
									//print_r ($exam_result);
									$exam_name = $exam_result->exam_name;
							}	
							
							
							$department_name			= $emp_info->department_name;
							$data['grade_name']			= $emp_info->grade_name;
						}else{
							$emp_info 					='';
							$data['grade_name']			= '';
							$department_name			= '';
						}		
						
					 
					$assign_emp = DB::table('tbl_emp_assign as ea')
									->where('ea.emp_id',$emp_id)
									->where('ea.status', '!=', 0)
									->where('ea.select_type', '=', 1)
									->select('ea.emp_id','ea.open_date','ea.incharge_as')
									->first();
					$assign_branch = DB::table('tbl_emp_assign as ea')
												->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code')
												->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
												->where('ea.emp_id',$emp_id)
												->where('ea.open_date', '<=', $current_date)
												->where('ea.status', '!=', 0)
												->where('ea.select_type', '=', 2)
												->select('ea.emp_id','ea.open_date','br.branch_name','br.br_code','ar.area_name')
												->first();
					$assign_designation = DB::table('tbl_emp_assign as ea')
												->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
												->where('ea.emp_id',$emp_id)
												->where('ea.status', '!=', 0)
												->where('ea.select_type', '=', 5)
												->select('ea.emp_id','ea.open_date','de.designation_name','de.designation_code')
												->first(); 
					$data['emp_history_permanent'] = DB::table('tbl_permanent')
											->where('tbl_permanent.emp_id',$emp_id)   
											->select('tbl_permanent.emp_id','tbl_permanent.effect_date','tbl_permanent.letter_date')
											->first();			
					$data['emp_history_probition'] = DB::table('tbl_probation')
											
													->leftJoin('tbl_emp_basic_info as em', 'em.emp_id', '=', 'tbl_probation.emp_id')
													->where('tbl_probation.emp_id',$emp_id)   
													->select('tbl_probation.emp_id','em.org_join_date as br_joined_date','tbl_probation.effect_date','tbl_probation.letter_date')
													->first();  
					$data['emp_history_promotion'] = DB::table('tbl_promotion')
													->where('tbl_promotion.emp_id',$emp_id)   
													->orderby('tbl_promotion.effect_date','desc')   
													->select('tbl_promotion.emp_id','tbl_promotion.effect_date','tbl_promotion.letter_date','tbl_promotion.grade_code')
													->get(); 
					$data['emp_history_transfer'] = DB::table('tbl_transfer')
													->leftJoin('tbl_branch as br', 'br.br_code', '=', 'tbl_transfer.br_code')
													->where('tbl_transfer.emp_id',$emp_id)   
													 ->orderby('tbl_transfer.br_joined_date','desc') 
													->select('tbl_transfer.emp_id','tbl_transfer.br_joined_date','tbl_transfer.letter_date','br.branch_name')
													->get(); 
					$emp_history_designation 		= DB::table('tbl_master_tra')
													->leftJoin('tbl_designation as des', 'des.designation_code', '=', 'tbl_master_tra.designation_code') 
													->where('tbl_master_tra.emp_id',$emp_id)
													 /*  ->where(function($query)
														{
															 
																$query->where('tbl_master_tra.effect_date','!=', '0000-00-00')
																->where('tbl_master_tra.effect_date','!=','1900-01-01');
														})  */
													->groupby('tbl_master_tra.designation_code','tbl_master_tra.effect_date')
													->orderby('tbl_master_tra.letter_date','asc')  
													->select(DB::raw('min(tbl_master_tra.letter_date) as letter_date'),'tbl_master_tra.designation_code',DB::raw('max(des.designation_name) as designation_name'),DB::raw('min(tbl_master_tra.effect_date) as effect_date'),DB::raw('min(tbl_master_tra.br_join_date) as br_join_date'))
													->get();  
				
			/* 	echo '<pre>';
				print_r($emp_history_designation);
				exit; */
				$pre_designation_code = '';	
				//$data['emp_history_designation'] = '';
				
			
				 			
				foreach($emp_history_designation as $v_emp_history_designation){
						if($v_emp_history_designation->designation_code != $pre_designation_code ){
							if(($v_emp_history_designation->effect_date == '0000-00-00' ) || ($v_emp_history_designation->effect_date == '1900-01-01')){
								$data['emp_history_designation'][] = array( 
									'designation_name'      => $v_emp_history_designation->designation_name,
									'effect_date'      => $v_emp_history_designation->br_join_date,
									'letter_date'      => $v_emp_history_designation->letter_date
								);
								
							}else{
								$data['emp_history_designation'][] = array( 
									'designation_name'      => $v_emp_history_designation->designation_name,
									'effect_date'      => $v_emp_history_designation->effect_date,
									'letter_date'      => $v_emp_history_designation->letter_date
								);
							}
						}
					$pre_designation_code = $v_emp_history_designation->designation_code;	
			
				}
				if(!empty($data['emp_history_designation'])){
				$keys = array_column($data['emp_history_designation'], 'effect_date');
				array_multisort($keys, SORT_DESC, $data['emp_history_designation']);
				} 					
	/*  echo '<pre>'; 
	  print_r($emp_info);
	exit;  */
	if(!empty($emp_info)){
		if(!empty($assign_emp)){
				 $incharge_as = $assign_emp->incharge_as; 
			 }else{
				 $incharge_as = ''; 
			 } 
			 if(!empty($assign_branch)){
				 $branch_name = $assign_branch->branch_name; 
				 $br_code = $assign_branch->br_code; 
			 }else{
				  $branch_name = $emp_info->branch_name; 
				 $br_code = $emp_info->br_code;
			 } 
			 if(!empty($assign_designation)){
				  $designation_name 	= $assign_designation->designation_name; 
				 $designation_code 		= $assign_designation->designation_code;
			 }else{
				  $designation_name = $emp_info->designation_name; 
				 $designation_code = $emp_info->designation_code;
			 }
			 if($emp_id <= 200000){
				 $data['emp_image']			= $emp_info->emp_id.'.'."jpg";
			 }else{
				 $data['emp_image']			= 'hh.jpg';
			 }
		$data['exam_name']			= $exam_name;
		$data['emp_name']			= $emp_info->emp_name;
		$data['c_effect_date']		= $emp_info->c_effect_date;
		$data['designation_code']	= $designation_name;
		$data['department_name']	= $department_name;	
		$data['branch_code']		= $branch_name;	
		$data['br_code']			= $br_code;	
		$data['incharge_as']		= $incharge_as;  
	}else{
		$data['exam_name']			= '';
		$data['emp_image']			= 'hh.jpg';
		$data['emp_name']			= '';
		$data['designation_code']	= '';
		$data['branch_code']		= '';
		$data['br_code']			= '';
		$data['c_effect_date']	    = 2;
		$data['department_name']	= '';
		$data['incharge_as']		= '';
	}
	return view('admin.document.emp_view_record',$data);
   }
  public function edms_document_delete($document_id,$category_id,$document_name){
			 $data = array();
			  $edms_info = DB::table('tbl_edms_document')
								->where('document_id',$document_id)   
								->select('document_name','emp_id','category_id','subcat_id')
								->first();  
			if($category_id == 13){
				$folder_name = "c_v";
			}else if($category_id == 5){
				$folder_name = "edu_cation";
			}else if($category_id == 11){
				$folder_name = "miscell_aneous";
			}else if($category_id == 24){
				$folder_name = "train_ing_info";
			}else if($category_id == 2){
				$folder_name = "assessment";
			}else {
				$folder_name = "attach_ment_tran";
			} 
			$document_name =  $edms_info->document_name;
			$document_array = explode(".",$document_name);
			$new_document_name = $document_array[0]."_$document_id.".$document_array[1];
			$filePath = "attachments/$folder_name/$document_name";
			$destinationFilePath = "attachments/$folder_name/$new_document_name";
			rename($filePath, $destinationFilePath);
			$data['document_name'] 		= $new_document_name; 
			$data['is_cancel'] 			= 1; 
			$data['cancel_by'] 			= Session::get('admin_id'); 
			$data['cancel_date'] 		= date("Y-m-d"); 		
			/* $file_name = "attachments/$folder_name/$document_name";
			File::delete($file_name); */
			$subcat_id = $edms_info->subcat_id;
			$emp_id = $edms_info->emp_id;
			  DB::table('tbl_edms_document')
				->where('document_id',$document_id)  
						->update($data); 
			if(($category_id == 1) && ($subcat_id == 1)){
				DB::table('tbl_edms_document')
						->where('emp_id', $emp_id)
						->where('is_cancel',0)
						->where('category_id', 23)
						->where('subcat_id', 46)
						->update($data); 
			}else if(($category_id == 23) && ($subcat_id == 46)){
				 
				 DB::table('tbl_edms_document')
						->where('emp_id', $emp_id)
						->where('is_cancel',0)
						->where('category_id', 1)
						->where('subcat_id', 1)
						->update($data);  
			}
			if(($category_id == 21) && ($subcat_id == 69)){
				$result_info = DB::table('tbl_fp_file_info')
									->where('fp_emp_id', $emp_id)
									->orderBy('id', 'DESC')
									->select('id','fp_emp_id')
									->first();
			
					if(!empty($result_info)) {
						DB::table('tbl_fp_file_info')->where('id', $result_info->id)->update(['status' => 1]);
					}
			}		
			
			Session::put('message','Data Deleted Successfully.');
		return Redirect::to('/edms_document_hlist_index'); 
	 }   
	 function duplicate_check($emp_id,$category_id,$subcat_id,$effect_date,$document_id){
		
			$emp_info = DB::table('tbl_edms_document as emp') 
						->where(function($query) use ($document_id)
								{
									if ($document_id != 0) {
										$query->where('emp.document_id','!=',$document_id);
									}   
								})
						->where('emp.is_cancel',0)
						->where('emp.emp_id',$emp_id)
						->where('emp.subcat_id',$subcat_id)
						->where('emp.category_id',$category_id) 
						->where('emp.effect_date',$effect_date) 
						->select('emp.*')
						->first();  
			if(!empty($emp_info)){
				echo 1;
			}else{
				echo 0;
			} 
	 }
	 
	 public function edms_document_not_exist_delete(){
		$emdata = array();
		$mtdata = array();
		$emp_info1 = DB::table('tbl_edms_document as emp')  
					->select('*')
					->get();  
		
		foreach($emp_info1 as $emp_info){
			
			if($emp_info->category_id == 13){
			$folder_name = "c_v/";
			}else if($emp_info->category_id == 5){
				$folder_name = "edu_cation/";
			}else if($emp_info->category_id == 11){
				$folder_name = "miscell_aneous/";
			}else if($emp_info->category_id == 24){
				$folder_name = "train_ing_info/";
			}else if($emp_info->category_id == 2){
				$folder_name = "assessment/";
			}else {
				$folder_name = "attach_ment_tran/";
			} 
			$document_id = $emp_info->document_id; 
			$filename = "attachments/$folder_name/$emp_info->document_name";
			if (file_exists($filename)) {
				
			}else{
				 DB::table('tbl_edms_document')
				->where('document_id',$document_id)  
				->delete(); 
			}
		}
		
		
		
		
		 
	 }
}
