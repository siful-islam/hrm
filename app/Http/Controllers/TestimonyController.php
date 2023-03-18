<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Middleware\Checkuser;
use DB;
use Session;
class TestimonyController extends Controller
{

	 public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	public function index()
    {
        $data = array();
		$data['emp_testimonial_list'] = DB::table('tbl_testimonial')
									->leftJoin('tbl_emp_basic_info as emp', 'tbl_testimonial.emp_id', '=', 'emp.emp_id')
									 ->leftJoin('tbl_branch as b', 'tbl_testimonial.branch_code', '=', 'b.br_code') 
									 ->leftJoin('tbl_designation as d', 'tbl_testimonial.designation_code', '=', 'd.designation_code') 
									->where('tbl_testimonial.status', '=', 1)
									->select('tbl_testimonial.*','emp.emp_name_eng as emp_name','b.branch_name','d.designation_name') 
									->get();
	 	/* echo '<pre>';
		print_r($data['emp_testimonial_list']);
		exit; */
		return view('admin.testimony.emp_testimony_list',$data);
    } 
	public function testimonyadd()
    {  
		$data = array();
		$data['employee_his'] = ''; 
		$data['button'] = 'Save';
		 $data['all_emp_type'] 		= DB::table('tbl_emp_type')->where('status',1)->get();
	/* 	echo '<pre>';
		print_r($datahis);
		exit;  */
		return view('admin.testimony.emp_testimony_form',$data);
    } 
	public function duplicate_certificate_check($emp_id)
    {  
		$is_exist = 0;
		 $emp_info 		= DB::table('tbl_testimonial')
										->where('emp_id',$emp_id)
										->first();
		if(!empty($emp_info)){
			$is_exist = 1;
		} 
	
	 echo $is_exist;
    }  	
	public function emp_info_testimony(Request $request)
    {
		$data = array();  
		$data['button'] 	= 'Save & Print'; 
		$asigndata = array(1,2,5); 
		$form_date 			= date("Y-m-d"); 
		$data['employee_id'] 	= $employee_id = $request->employee_id;
		
				$max_sarok = DB::table('tbl_master_tra')
						->where('emp_id', '=', $employee_id)
						->where('effect_date', '<=', $form_date)
						->select('emp_id',DB::raw('max(sarok_no) as sarok_no'))
						->groupBy('emp_id')
						->first();  
						if(!empty($max_sarok)){
							$data['employee_his']  = DB::table('tbl_master_tra as m')  
											->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
											 ->leftjoin('tbl_master_tra as em',function($join) use ($employee_id){
														$join->on("m.emp_id","=","em.emp_id")
															->where('em.letter_date',DB::raw("(SELECT 
																						  min(letter_date)
																						  FROM tbl_master_tra 
																						   where m.emp_id = tbl_master_tra.emp_id
																						  )") 		 
																	); 
																})	
											->leftJoin('tbl_resignation as r', 'r.emp_id', '=', 'm.emp_id') 
											->leftJoin('tbl_designation as d', 'r.designation_code', '=', 'd.designation_code') 
											->leftJoin('tbl_designation as d1', 'em.designation_code', '=', 'd1.designation_code') 
											->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
											->join('tbl_district', 'tbl_district.district_code', '=', 'emp.district_code')
											->join('tbl_thana', 'tbl_thana.thana_code', '=', 'emp.thana_code')
											->where('m.sarok_no', '=', $max_sarok->sarok_no)
											->select('em.letter_date','emp.emp_id','emp.father_name','emp.gender','emp.vill_road','emp.post_office','tbl_thana.thana_name','tbl_district.district_name','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','r.effect_date','r.resignation_by','emp.org_join_date as joining_date','d1.designation_name as pre_designation_name','d1.designation_code as pre_designation_code')
											->first(); 
						} 
			$data['type_name'] 				= 'regular';
			 
			/* $data['assign_branch'] = DB::table('tbl_emp_assign as ea')
										->leftJoin('tbl_branch as br', 'ea.br_code', '=', 'br.br_code')
										->leftJoin('tbl_area as ar', 'br.area_code', '=', 'ar.area_code')
										->where('ea.emp_id',$emp_id)
										->where('ea.open_date', '<=', $form_date)
										->where('ea.status', '!=', 0)
										->where('ea.select_type', '=', 2)
										->select('ea.emp_id','ea.open_date','br.branch_name','ar.area_name')
										->first();
			
			
			$data['employee_his']  = DB::table('tbl_emp_assign as es')  
										->leftJoin('tbl_emp_basic_info as emp', 'es.emp_id', '=', 'emp.emp_id')
										->leftJoin('tbl_designation as d', 'es.designation_code', '=', 'd.designation_code') 
										->leftJoin('tbl_branch as b', 'es.br_code', '=', 'b.br_code') 
										->leftJoin('tbl_zone as z', 'z.zone_code', '=', 'b.zone_code') 
										->join('tbl_district', 'tbl_district.district_code', '=', 'emp.district_code')
										->join('tbl_thana', 'tbl_thana.thana_code', '=', 'emp.thana_code')
										->where('es.emp_id',$employee_id)
										->where('es.open_date', '<=', $form_date)
										->where('es.status', '!=', 0)
										->whereIn('es.select_type', $asigndata)
										->select('emp.emp_id','emp.father_name','emp.vill_road','emp.post_office','tbl_thana.thana_name','tbl_district.district_name','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','z.zone_name','emp.org_join_date as joining_date')
										->first();  */
		
		$data['emp_id'] 				= $employee_id;
		$ye_ar = date("Y");
		$max_serial_no 		= DB::table('tbl_testimonial') 
									->where('status',1) 
									->where('ye_ar',$ye_ar) 
									->max('serial_no'); 	
		
		
		$data['serial_no'] 				= $max_serial_no + 1; 
		$data['ye_ar'] 					= $ye_ar; 
		
		if(!empty($data['employee_his'])){
		$data['letter_date'] 			= $data['employee_his']->letter_date;
		$data['t_date'] 				= $data['employee_his']->effect_date;
		$data['pre_designation_code'] 	= $data['employee_his']->pre_designation_code;
		$data['branch_code'] 			= $data['employee_his']->br_code;
		$data['designation_code'] 		= $data['employee_his']->designation_code;
		$data['gender'] 				= $data['employee_his']->gender;
		$data['resignation_by'] 	    = $data['employee_his']->resignation_by;
	 	}
		 /*  echo '<pre>'; 
		print_r($data['employee_his']);
		exit;   */
		$data['all_emp_type'] 		= DB::table('tbl_emp_type')->where('status',1)->get(); 
		return view('admin.testimony.emp_testimony_form',$data);
    }
	
	
	public function insert_emp_testimony(Request $request)
    { 
		$data = array();  
        $data['emp_id'] 		       = $emp_id =  $request->emp_id; 
        $data['t_date'] 			   =  $request->t_date; 
		$data['letter_date'] 		   =  $request->letter_date; 
        $data['pre_designation_code']  =  $request->pre_designation_code; 
        $data['branch_code']  		   =  $request->branch_code; 
        $data['serial_no']  		   =  $request->serial_no; 
        $data['ye_ar']  		   	   =  $request->ye_ar; 
        $data['designation_code']  	   =  $request->designation_code; 
		$data['user_code'] 			   = Session::get('admin_id');
         
		$get_id =  DB::table('tbl_testimonial')
					->insertGetId($data);   
		// return Redirect::to('/testimony'); 
		 return Redirect::to("/testimony_print/$get_id/$emp_id"); 
    }
	public function testimonial_delete($id)
    {  
		 DB::table('tbl_testimonial')
				->where('id', '=', $id)
				->delete();   
		 return Redirect::to('/testimony'); 
    }
	public function testimony_view($id,$emp_id)
    {  
		$data = array();
		$data['employee_his'] = '';
		$data['emp_id'] = $emp_id;  
		
			$data['employee_his']  = DB::table('tbl_testimonial as t')  
											->leftJoin('tbl_emp_basic_info as emp', 't.emp_id', '=', 'emp.emp_id') 
											->leftJoin('tbl_resignation as r', 'r.emp_id', '=', 't.emp_id') 
											->leftJoin('tbl_designation as d', 't.designation_code', '=', 'd.designation_code') 
											->leftJoin('tbl_designation as d1', 't.pre_designation_code', '=', 'd1.designation_code') 
											->leftJoin('tbl_branch as b', 't.branch_code', '=', 'b.br_code') 
											->join('tbl_district', 'tbl_district.district_code', '=', 'emp.district_code')
											->join('tbl_thana', 'tbl_thana.thana_code', '=', 'emp.thana_code') 
											->where('t.emp_id', '=', $emp_id)
											->select('t.letter_date','t.created_at','t.serial_no','t.ye_ar','emp.emp_id','emp.gender','emp.father_name','emp.vill_road','emp.post_office','tbl_thana.thana_name','tbl_district.district_name','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','r.effect_date','r.resignation_by','emp.org_join_date as joining_date','d1.designation_name as pre_designation_name','d1.designation_code as pre_designation_code')
											->first();
		if(!empty($data['employee_his'])){
			$data['serial_no'] = $data['employee_his']->serial_no;
			$data['ye_ar'] = $data['employee_his']->ye_ar;
			$data['resignation_by'] = $data['employee_his']->resignation_by;
			$data['gender'] = $data['employee_his']->gender;
			$data['created_at'] = $data['employee_his']->created_at;
			 
		} 
		$data['button'] = 'Save';
		
		 
		 /* echo '<pre>';
		print_r($data);
		exit;   */ 
		return view('admin.testimony.emp_testimony_view',$data);
    } 
	public function testimony_print($id,$emp_id)
    {  
		$data = array();
		$data['employee_his'] = '';
		$data['emp_id'] = $emp_id;
		 
			$data['employee_his']  = DB::table('tbl_testimonial as t')  
											->leftJoin('tbl_emp_basic_info as emp', 't.emp_id', '=', 'emp.emp_id') 
											->leftJoin('tbl_resignation as r', 'r.emp_id', '=', 't.emp_id') 
											->leftJoin('tbl_designation as d', 't.designation_code', '=', 'd.designation_code') 
											->leftJoin('tbl_designation as d1', 't.pre_designation_code', '=', 'd1.designation_code') 
											->leftJoin('tbl_branch as b', 't.branch_code', '=', 'b.br_code') 
											->join('tbl_district', 'tbl_district.district_code', '=', 'emp.district_code')
											->join('tbl_thana', 'tbl_thana.thana_code', '=', 'emp.thana_code') 
											->where('t.emp_id', '=', $emp_id)
											->select('t.letter_date','t.serial_no','t.created_at','t.ye_ar','emp.emp_id','emp.gender','emp.father_name','emp.vill_road','emp.post_office','tbl_thana.thana_name','tbl_district.district_name','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','r.effect_date','r.resignation_by','emp.org_join_date as joining_date','d1.designation_name as pre_designation_name','d1.designation_code as pre_designation_code')
											->first(); 
		 
		if(!empty($data['employee_his'])){
			$data['serial_no'] = $data['employee_his']->serial_no;
			$data['ye_ar'] = $data['employee_his']->ye_ar;
			$data['resignation_by'] = $data['employee_his']->resignation_by;
			$data['gender'] = $data['employee_his']->gender;
			$data['created_at'] = $data['employee_his']->created_at;
			 
		} 
		$data['button'] = 'Save';
		
		 
		 /* echo '<pre>';
		print_r($data);
		exit;   */ 
		return view('admin.testimony.emp_testimony_view_print',$data);
    }
	public function certi_general()
    {
        $data = array();
		$data['emp_testimonial_list'] = DB::table('tbl_testimonial')
									->leftJoin('tbl_emp_basic_info as emp', 'tbl_testimonial.emp_id', '=', 'emp.emp_id')
									 ->leftJoin('tbl_branch as b', 'tbl_testimonial.branch_code', '=', 'b.br_code') 
									 ->leftJoin('tbl_designation as d', 'tbl_testimonial.designation_code', '=', 'd.designation_code') 
									->where('tbl_testimonial.status', '=', 0)
									->select('tbl_testimonial.*','emp.emp_name_eng as emp_name','b.branch_name','d.designation_name') 
									->get();
		return view('admin.testimony.emp_testimony_list_gen',$data);
    } 
	public function testimonyadd_gen()
    {  
		$data = array();
		$data['employee_his'] = ''; 
		$data['button'] = 'Save';
		$data['is_show'] = 0;
	/* 	echo '<pre>';
		print_r($datahis);
		exit;  */
		return view('admin.testimony.emp_testimony_form_gen',$data);
    } 
	public function emp_info_testimony_gen(Request $request)
    {
		$data = array();  
		$data['button'] 	= 'Save & Print'; 
		$form_date 			= date("Y-m-d"); 
		$data['employee_id'] 	= $employee_id = $request->employee_id;
		
				$max_sarok = DB::table('tbl_master_tra')
						->where('emp_id', '=', $employee_id)
						->where('effect_date', '<=', $form_date)
						->select('emp_id',DB::raw('max(sarok_no) as sarok_no'))
						->groupBy('emp_id')
						->first();  
						if(!empty($max_sarok)){
							$data['employee_his']  = DB::table('tbl_master_tra as m')  
											->leftJoin('tbl_emp_basic_info as emp', 'm.emp_id', '=', 'emp.emp_id')
											 ->leftjoin('tbl_master_tra as em',function($join) use ($employee_id){
														$join->on("m.emp_id","=","em.emp_id")
															->where('em.letter_date',DB::raw("(SELECT 
																						  min(letter_date)
																						  FROM tbl_master_tra 
																						   where m.emp_id = tbl_master_tra.emp_id
																						  )") 		 
																	); 
																})	
											->leftJoin('tbl_designation as d1', 'em.designation_code', '=', 'd1.designation_code') 
											->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
											->join('tbl_district', 'tbl_district.district_code', '=', 'emp.district_code')
											->join('tbl_thana', 'tbl_thana.thana_code', '=', 'emp.thana_code')
											->where('m.sarok_no', '=', $max_sarok->sarok_no)
											->select('em.letter_date','em.effect_date','emp.emp_id','emp.father_name','emp.mother_name','emp.gender','emp.vill_road','emp.post_office','tbl_thana.thana_name','tbl_district.district_name','emp.emp_name_eng as emp_name','b.br_code','b.branch_name','emp.org_join_date as joining_date','d1.designation_name as pre_designation_name','d1.designation_code as pre_designation_code')
											->first(); 
						} 
		 $emp_last_designation 		= DB::table('tbl_master_tra') 
													->where('tbl_master_tra.emp_id',$employee_id)
													 /*  ->where(function($query)
														{
															 
																$query->where('tbl_master_tra.effect_date','!=', '0000-00-00')
																->where('tbl_master_tra.effect_date','!=','1900-01-01');
														})  */
													->groupby('tbl_master_tra.designation_code','tbl_master_tra.effect_date')
													->orderby('tbl_master_tra.effect_date','desc')  
													->orderby('tbl_master_tra.id','desc')  
													->select('tbl_master_tra.designation_code')
													->first(); 
									 
	 	$emp_min_effect_date 		= DB::table('tbl_master_tra')
													->leftJoin('tbl_designation as des', 'des.designation_code', '=', 'tbl_master_tra.designation_code') 
													->where('tbl_master_tra.emp_id',$employee_id)
													->where('tbl_master_tra.designation_code',$emp_last_designation->designation_code)
													->select('des.designation_name',DB::raw('MIN(tbl_master_tra.effect_date) as min_effect_date'))
													->first(); 
		
		/* echo '<pre>';
		print_r($emp_last_designation);
		echo '<pre>';
		print_r($emp_min_effect_date);
		exit; */
		
		
		
		$ye_ar = date("Y");
		$max_serial_no 		= DB::table('tbl_testimonial')  
									->where('status',0) 
									->where('ye_ar',$ye_ar) 
									->max('serial_no'); 	
		
		
		$data['serial_no'] 				= $max_serial_no + 1; 
		$data['ye_ar'] 					= $ye_ar; 
		
		
		
		
		
		
		
		$data['emp_id'] 				= $employee_id; 
		$data['is_short'] 				= 1; 
		$data['is_show'] 				= 1;
		
		if(!empty($data['employee_his'])){
		$data['letter_date'] 			= $data['employee_his']->letter_date;
		$data['t_date'] 				= $emp_min_effect_date->min_effect_date;
		$data['pre_designation_code'] 	= $data['employee_his']->pre_designation_code;
		$data['branch_code'] 			= $data['employee_his']->br_code;
		$data['designation_code'] 		=  $emp_last_designation->designation_code;
		$data['current_designation_name'] 		=  $emp_min_effect_date->designation_name;
		$data['current_effect_date'] 		=  $emp_min_effect_date->min_effect_date;
		$data['gender'] 				= $data['employee_his']->gender; 
	 	}
		 /*  echo '<pre>'; 
		print_r($data['employee_his']);
		exit;   */
		return view('admin.testimony.emp_testimony_form_gen',$data);
    }
	public function testimony_view_gen($id,$emp_id)
    {  
		$data = array();
		$data['employee_his'] = '';
		$data['emp_id'] = $emp_id;  
		
			$data['employee_his']  = DB::table('tbl_testimonial as t')  
											->leftJoin('tbl_emp_basic_info as emp', 't.emp_id', '=', 'emp.emp_id')  
											->leftJoin('tbl_designation as d', 't.designation_code', '=', 'd.designation_code') 
											->leftJoin('tbl_designation as d1', 't.pre_designation_code', '=', 'd1.designation_code') 
											->leftJoin('tbl_branch as b', 't.branch_code', '=', 'b.br_code') 
											->join('tbl_district', 'tbl_district.district_code', '=', 'emp.district_code')
											->join('tbl_thana', 'tbl_thana.thana_code', '=', 'emp.thana_code') 
											->where('t.emp_id', '=', $emp_id)
											->select('t.letter_date','t.created_at','t.t_date','t.serial_no','t.ye_ar','emp.emp_id','emp.gender','emp.father_name','emp.mother_name','emp.vill_road','emp.post_office','tbl_thana.thana_name','tbl_district.district_name','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','emp.org_join_date as joining_date','d1.designation_name as pre_designation_name','d1.designation_code as pre_designation_code')
											->first();
		if(!empty($data['employee_his'])){
			$data['serial_no'] = $data['employee_his']->serial_no;
			$data['ye_ar'] = $data['employee_his']->ye_ar; 
			$data['current_designation_name'] = $data['employee_his']->designation_name;
			$data['current_effect_date'] = $data['employee_his']->t_date;
			$data['gender'] = $data['employee_his']->gender;
			$data['created_at'] = $data['employee_his']->created_at;
			 
		} 
		$data['button'] = 'Save';
		
		 
		 /* echo '<pre>';
		print_r($data);
		exit;   */ 
		return view('admin.testimony.emp_testimony_general_view',$data);
    }
	public function insert_emp_testimony_gen(Request $request)
    { 
		$data = array();  
        $data['emp_id'] 		       = $emp_id =  $request->emp_id; 
        $data['t_date'] 			   =  $request->t_date; 
		$data['letter_date'] 		   =  $request->letter_date; 
        $data['pre_designation_code']  =  $request->pre_designation_code; 
        $data['branch_code']  		   =  $request->branch_code; 
        $data['serial_no']  		   =  $request->serial_no; 
        $data['ye_ar']  		   	   =  $request->ye_ar; 
        $data['status']  		   	   =  0; 
        $data['designation_code']  	   =  $request->designation_code; 
		$data['user_code'] 			   = Session::get('admin_id');
        $data['is_short']  		   	   =  $request->is_short;  
		 
		/*  echo '<pre>'; 
		print_r($data);
		exit;   */
		$get_id =  DB::table('tbl_testimonial')
					->insertGetId($data);   
		// return Redirect::to('/testimony'); 
		 return Redirect::to("/testimony_print_gen/$get_id/$emp_id"); 
    }
	public function testimony_print_gen($id,$emp_id)
    {  
		$data = array();
		$data['employee_his'] = '';
		$data['emp_id'] = $emp_id;
		 
			$data['employee_his']  = DB::table('tbl_testimonial as t')  
											->leftJoin('tbl_emp_basic_info as emp', 't.emp_id', '=', 'emp.emp_id') 
											->leftJoin('tbl_designation as d', 't.designation_code', '=', 'd.designation_code') 
											->leftJoin('tbl_designation as d1', 't.pre_designation_code', '=', 'd1.designation_code') 
											->leftJoin('tbl_branch as b', 't.branch_code', '=', 'b.br_code') 
											->join('tbl_district', 'tbl_district.district_code', '=', 'emp.district_code')
											->join('tbl_thana', 'tbl_thana.thana_code', '=', 'emp.thana_code') 
											->where('t.id', '=', $id)
											->where('t.emp_id', '=', $emp_id)
											->select('t.letter_date','t.serial_no','t.is_short','t.created_at','t.ye_ar','t.t_date','emp.emp_id','emp.gender','emp.father_name','emp.mother_name','emp.vill_road','emp.post_office','tbl_thana.thana_name','tbl_district.district_name','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','emp.org_join_date as joining_date','d1.designation_name as pre_designation_name','d1.designation_code as pre_designation_code')
											->first(); 
		 
		if(!empty($data['employee_his'])){
			$data['serial_no'] = $data['employee_his']->serial_no;
			$data['is_short'] = $data['employee_his']->is_short;
			$data['ye_ar'] = $data['employee_his']->ye_ar; 
			$data['gender'] = $data['employee_his']->gender;
			$data['current_designation_name'] = $data['employee_his']->designation_name;
			$data['current_effect_date'] = $data['employee_his']->t_date;
			$data['created_at'] = $data['employee_his']->created_at;
			 
		} 
		$data['button'] = 'Save';
		
		 
		 /* echo '<pre>';
		print_r($data);
		exit;   */ 
		return view('admin.testimony.emp_testimony_view_print_gen',$data);
    }
}
