<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use File;
use Session;
class OfficeorderController extends Controller
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
		$data['office_order_list'] = DB::table('tbl_offfice_order')
									//->where('status', 1)
									->select('*')
									->get(); 
		/* echo '<pre>';
		print_r($data['movement_register_list']); 
		exit;  */
		return view('admin.office_order.office_order_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$data = array();  
		$data['action'] 			= 'office_order/'; 
		$data['button']				= 'Save';
		$data['mode']				= 'add';
		$data['method_control'] 	=''; 
		$data['title'] 				= '';
		$data['upload_type'] 		= '';
		$data['for_which'] 			= 3;
        $data['comments'] 			= '';
        $data['order_date'] 		= '';
        $data['status'] 			= '';
        $data['file_name'] 			= '';  
        $data['word_file_name'] 	= '';  
		return   view('admin.office_order.office_order_form',$data);
    }
	public function office_order_update()
    {
		$data = array();  
		$data['action'] 			= 'order_update_add/'; 
		$data['button']				= 'Save';
		$data['mode']				= 'add';
		$data['method_control'] 	=''; 
		$data['all_title'] 			= DB::table('tbl_offfice_order')
											->where('status', 1)
											->select('*')
											->get();
        $data['comments'] 			= '';
        $data['order_date'] 		= '';
        $data['status'] 			= '';
        $data['file_name'] 			= '';  
        $data['word_file_name'] 	= '';  
		return   view('admin.office_order.office_order_form_update',$data);
    }
	 public function order_update_add(Request $request)
    {
        $data = array();
		 $udata = array();   
		$udata['status'] 			= 2;
		$order_id 					= $request->order_id;
		$data['title'] 				= $title = $request->title;
		$data['upload_type'] 		= $request->upload_type;
		$data['for_which'] 			= $request->for_which;
        $data['comments'] 			= $request->comments;
        $data['order_date'] 		= $request->order_date;
        $data['status'] 			= $request->status; 
		$word_file_name 			= $request->file('word_file_name');
		$images 					= $request->file('file_name');
	/*  echo '<pre>';
	print_r($data);
	exit; */ 
       if($images){
			$image_name = str_random(20); 
			$upload_path ='storage/office_order';
			$ext = strtolower($images->getClientOriginalExtension());
			//$image_full_name = $title.'.'.$ext;
			$image_full_name = $image_name.'.'.$ext;
			$image_url = $image_full_name;
			$success = $images->move($upload_path,$image_full_name);
			if($word_file_name){
				$image_name_w = str_random(20);
				$ext_w = strtolower($word_file_name->getClientOriginalExtension());
				//$image_full_name_w = $title.'.'.$ext_w;
				$image_full_name_w = $image_name_w.'.'.$ext_w;
				$success_w = $word_file_name->move($upload_path,$image_full_name_w);
				if($success_w){
					$data['word_file_name'] = $image_full_name_w;
				}
				
			}
			if($success){
				
				$data['file_name'] = $image_url;
				
				DB::table('tbl_offfice_order')
					->where('order_id', $order_id)
					->update($udata);
				
				DB::table('tbl_offfice_order')->insertGetId($data); 
			} 
		}else{ 
		    $upload_path ='storage/office_order';
			if($word_file_name){ 
				$image_name_w = str_random(20);
				$ext_w = strtolower($word_file_name->getClientOriginalExtension());
				//$image_full_name_w = $title.'.'.$ext_w;
				$image_full_name_w = $image_name_w.'.'.$ext_w;
				$success_w = $word_file_name->move($upload_path,$image_full_name_w);
				if($success_w){
					$data['word_file_name'] = $image_full_name_w;
				}
				
			}
			
			DB::table('tbl_offfice_order')
					->where('order_id', $order_id)
					->update($udata);
			DB::table('tbl_offfice_order')->insertGetId($data); 
		}
		/* echo '<pre>';
		print_r($data);
		exit; 
			 */
		
		 
		return Redirect::to('/office_order');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array();   
		$data['title'] 				= $title= $request->title;
		$data['upload_type'] 		= $request->upload_type;
		$data['for_which'] 		    = $request->for_which;
        $data['comments'] 			= $request->comments;
        $data['order_date'] 		= $request->order_date;
        $data['status'] 			= $request->status; 
		$word_file_name 			= $request->file('word_file_name');
		$images 					= $request->file('file_name');
	/*  echo '<pre>';
	print_r($data);
	exit; */ 
       if($images){
			$image_name = str_random(20); 
			$upload_path ='storage/office_order';
			$ext = strtolower($images->getClientOriginalExtension());
			//$image_full_name = $title.'.'.$ext;
			$image_full_name = $image_name.'.'.$ext;
			$image_url = $image_full_name;
			$success = $images->move($upload_path,$image_full_name);
			if($word_file_name){
				$image_name_w = str_random(20);
				$ext_w = strtolower($word_file_name->getClientOriginalExtension());
				//$image_full_name_w = $title.'.'.$ext_w;
				$image_full_name_w = $image_name_w.'.'.$ext_w;
				$success_w = $word_file_name->move($upload_path,$image_full_name_w);
				if($success_w){
					$data['word_file_name'] = $image_full_name_w;
				}
				
			}
			if($success){
				
				$data['file_name'] = $image_url;
				
				DB::table('tbl_offfice_order')->insertGetId($data); 
			} 
		}else{ 
		    $upload_path ='storage/office_order';
			if($word_file_name){ 
				$image_name_w = str_random(20);
				$ext_w = strtolower($word_file_name->getClientOriginalExtension());
				//$image_full_name_w = $title.'.'.$ext_w;
				$image_full_name_w = $image_name_w.'.'.$ext_w;
				$success_w = $word_file_name->move($upload_path,$image_full_name_w);
				if($success_w){
					$data['word_file_name'] = $image_full_name_w;
				}
				
			}
		
		
			DB::table('tbl_offfice_order')->insertGetId($data); 
		}
		/* echo '<pre>';
		print_r($data);
		exit; 
			 */
		
		 
		return Redirect::to('/office_order');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) 
    {
        $data = array();  
		$data['button']				= 'Update';
		$data['mode']				= 'edit';
		$data['method_control'] ="<input type='hidden' name='_method' value='PUT' />"; 
		//$emp_id = Session::get('emp_id'); 
		 
		$office_order_by_id = DB::table('tbl_offfice_order')
									->where('order_id',$id)
									->select('*')
									->first();  
		$data['title'] 				= $office_order_by_id->title;
		$data['upload_type'] 		= $office_order_by_id->upload_type;
		$data['for_which'] 		= $office_order_by_id->for_which;
        $data['comments'] 			= $office_order_by_id->comments;
        $data['order_date'] 		= $office_order_by_id->order_date;
        $data['status'] 			= $office_order_by_id->status;
		$data['word_file_name'] 	= $office_order_by_id->word_file_name;
		$data['file_name'] 			= $office_order_by_id->file_name;
		$data['action'] 			= "office_order/$id"; 
		   
		return   view('admin.office_order.office_order_form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = array(); 
       $data['title'] 				= $title = $request->title;
       $data['upload_type'] 		= $request->upload_type;
       $data['for_which'] 		= $request->for_which;
        $data['comments'] 			= $request->comments;
        $data['order_date'] 		= $request->order_date;
        $data['status'] 			= $request->status;
        $hidden_word_file_name 		= $request->hidden_word_file_name;  
        $hidden_file_name 			= $request->hidden_file_name;  
		$word_file_name 			= $request->file('word_file_name');
		$images = $request->file('file_name');
	/*  echo '<pre>';
	print_r($data);
	exit; */ 
       if($images){  
			if(!empty($hidden_file_name)){
				$file_name ="storage/office_order/$hidden_file_name"; 
				File::delete($file_name); 
			} 
			$upload_path ='storage/office_order';
			$image_name = str_random(20);
			$ext = strtolower($images->getClientOriginalExtension());
			//$image_full_name = $title.'.'.$ext; 
			$image_full_name = $image_name.'.'.$ext; 
			  
			$success = $images->move($upload_path,$image_full_name);
			
			
			if($word_file_name){
				
				if(!empty($hidden_word_file_name)){
					$file_name_w ="storage/office_order/$hidden_word_file_name"; 
					File::delete($file_name_w); 
				} 
				
			    $image_name_w = str_random(20);
				$ext_w = strtolower($word_file_name->getClientOriginalExtension());
				//$image_full_name_w = $title.'.'.$ext_w;  
				$image_full_name_w = $image_name_w.'.'.$ext_w;  
				$success_w = $word_file_name->move($upload_path,$image_full_name_w);
				if($success_w){
				$data['word_file_name'] = $image_full_name_w; 
				} 
			}
			
			
			if($success){
				$data['file_name'] = $image_full_name;
				DB::table('tbl_offfice_order')
				->where('order_id', $id)
				->update($data); 
			} 
		}else{
			
			
			if($word_file_name){
				if(!empty($hidden_word_file_name)){
					$file_name_w ="storage/office_order/$hidden_word_file_name"; 
					File::delete($file_name_w); 
				} 
				$upload_path ='storage/office_order';
				$image_name_w = str_random(20);
				$ext_w = strtolower($word_file_name->getClientOriginalExtension());
				//$image_full_name_w = $title.'.'.$ext_w;  
				$image_full_name_w = $image_name_w.'.'.$ext_w;  
				$success_w = $word_file_name->move($upload_path,$image_full_name_w);
				if($success_w){
				$data['word_file_name'] = $image_full_name_w; 
				} 
			}
			DB::table('tbl_offfice_order')
				->where('order_id', $id)
				->update($data); 
		} 
		return Redirect::to('/office_order');
    } 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function br_download_office_order()
    {
		$data = array();   
		$branch_code = Session::get('branch_code'); 
		$data['office_order_file'] = DB::table('tbl_offfice_order')
									->where(function ($query) use($branch_code) {
										if($branch_code == 9999){
											$query->where('for_which', 1)->orwhere('for_which', 3);
										}else{
											$query->where('for_which', 2)->orwhere('for_which', 3);
										} 	 	 
									})
									->where('upload_type',1)
									->where('status',1)
									->orderby('order_date','desc')
									->select('*')
									->get();  
		$data['title']  = ''; 
		$data['submenu']  = 'office_Order';
		return   view('admin.office_order.download_office_file',$data);
    }
	public function br_download_circular()
    {
		
		$data = array();
		$branch_code = Session::get('branch_code'); 
		$data['office_order_file'] = DB::table('tbl_offfice_order')
									->where('upload_type',2)
									->where(function ($query) use($branch_code) {
										if($branch_code == 9999){
											$query->where('for_which', 1)->orwhere('for_which', 3);
										}else{
											$query->where('for_which', 2)->orwhere('for_which', 3);
										} 	 	 
									})
									->where('status',1)
									->orderby('order_date','desc')
									->select('*')
									->get();  
		$data['title']  = ''; 
		$data['submenu']  = 'circular';
		/* print_r($data['office_order_file']);
		exit; */
		return   view('admin.office_order.download_office_file',$data);
    }
	public function br_download()
    {
		$data = array(); 
		$branch_code = Session::get('branch_code'); 
		$data['office_order_file'] = DB::table('tbl_offfice_order')
									->where(function ($query) use($branch_code) {
										if($branch_code == 9999){
											$query->where('for_which', 1)->orwhere('for_which', 3);
										}else{
											$query->where('for_which', 2)->orwhere('for_which', 3);
										} 	 	 
									})
									->where('upload_type',3)
									->where('status',1)
									->orderby('order_date','desc')
									->select('*')
									->get();  
		$data['title']  = ''; 
		$data['submenu']  = 'download';
		return   view('admin.office_order.download_office_file',$data);
    }
	public function br_download_general()
    {
		$data = array(); 
		$branch_code = Session::get('branch_code'); 
		$data['office_order_file'] = DB::table('tbl_offfice_order')
									->where(function ($query) use($branch_code) {
										if($branch_code == 9999){
											$query->where('for_which', 1)->orwhere('for_which', 3);
										}else{
											$query->where('for_which', 2)->orwhere('for_which', 3);
										} 	 	 
									})
									->where('upload_type',4)
									->where('status',1)
									->orderby('order_date','desc')
									->select('*')
									->get();  
		$data['title']  = '';
		$data['submenu']  = 'general';	
		return   view('admin.office_order.download_office_file',$data);
    }
	public function br_user_manual()
    {
		$data = array(); 
			$branch_code = Session::get('branch_code'); 
		$data['office_order_file'] = DB::table('tbl_offfice_order')
									->where(function ($query) use($branch_code) {
										if($branch_code == 9999){
											$query->where('for_which', 1)->orwhere('for_which', 3);
										}else{
											$query->where('for_which', 2)->orwhere('for_which', 3);
										} 	 	 
									}) 
									->where('upload_type',5)
									->where('status',1)
									->orderby('order_date','desc')
									->select('*')
									->get();  
		$data['title']  = ''; 
		$data['submenu']  = 'user_Manual';
		return   view('admin.office_order.download_office_file',$data);
    } 
	public function office_order_delete($document_id){
			 
			  $document_info = DB::table('tbl_offfice_order')
								->where('order_id',$document_id)   
								->first();  
			if(!empty($document_info->file_name)){
				$document_name = $document_info->file_name;
				$file_name = "storage/office_order/$document_name";
				File::delete($file_name);
			} 
			if(!empty($document_info->word_file_name)){
				$document_name_word = $document_info->word_file_name;
				$file_name_w = "storage/office_order/$document_name_word";
				File::delete($file_name_w);
			} 
			
			
			  DB::table('tbl_offfice_order')
				->where('order_id',$document_id)   
				->delete(); 
			Session::put('message','Data Deleted Successfully'); 
		return Redirect::to('/office_order'); 
	 }  
}
