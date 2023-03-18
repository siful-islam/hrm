<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class RecruitmentController extends Controller
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
		$data['all_data'] = DB::table('tbl_recruitment_basic as rb')
								->leftJoin('tbl_district as d', 'rb.district_code', '=', 'd.district_code')
								->leftJoin('tbl_thana as t', 'rb.thana_code', '=', 't.thana_code')
								->leftJoin('tbl_recruit_circular_post as p', 'rb.post_id', '=', 'p.id')
								->leftJoin('tbl_recruitment_circular as c', 'rb.circular_id', '=', 'c.id')
								->select('rb.*','d.district_name','t.thana_name','c.circular_name','p.post_name')
								->get();
		//print_r ($data['all_data']);
		return view('admin.pages.recruitment.recruitment_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AddRecruit()
    {
        $data = array();
		$data['full_name'] 			= "";
		$data['father_name'] 		= "";
		$data['mother_name'] 		= "";
		$data['birth_date'] 		= "";
		$data['religion'] 			= "";
		$data['maritial_status'] 	= "";
		$data['nationality'] 		= "";
		$data['national_id'] 		= "";
		$data['gender'] 			= "Female";
		$data['contact_num'] 		= "";
		$data['email'] 				= "";
		$data['present_add'] 		= "";
		$data['vill_road'] 			= "";
		$data['post_office'] 		= "";
		$data['district_code'] 		= "";
		$data['thana_code'] 		= "";
		$data['post_id'] 		    = "";
		$data['circular_id'] 		= 2;
		$data['permanent_add'] 		= "";
		$data['is_same_present_address'] = "";
		$data['is_education_certif']= 1;
		$data['is_nid'] 			= 1;
		$data['is_photo'] 			= 1;
		$data['tab_id'] 			= 1;
		$data['recruitment_id'] 	= "";
		$data['relevent_year'] 		= "";
		$data['relevent_month'] 	= "";
		$data['end_date'] 			="";
		$data['normal_age'] 		="";
		$data['experience_age'] 	="";
		$data['new_recruitment_id'] ="";
		$data['action'] 			= "/store-recruit";
		
		$all_district=DB::table('tbl_district')
							->orderby('district_name','asc')
							->get();									
		$all_thana=DB::table('tbl_thana')->get();		
		$all_exam=DB::table('tbl_exam_name')->get();
		$all_group_subject=DB::table('tbl_subject')->get();
		$all_board_university=DB::table('tbl_board_university')->get();
									
		$recruit_edu=DB::table('tbl_recruitment_edu')
                                    ->where('recruitment_id',$data['recruitment_id'])
									->get();
									
		$recruit_exp=DB::table('tbl_recruitment_exp')
                                    ->where('recruitment_id',$data['recruitment_id'])
									->get();
		
		$recruit_train=DB::table('tbl_recruitment_train')
                                    ->where('recruitment_id',$data['recruitment_id'])
									->get();
		$recruit_circular=DB::table('tbl_recruitment_circular')
                                    ->where('status',1)
									->get(); 
		//print_r($data);
		$all_post =  DB::table('tbl_recruit_circular_post')
						->where('circular_id',2)
						->get();
		 
		$recruitment_add = view('admin.pages.recruitment.recruitment_form')
									->with('all_district',$all_district)
                                    ->with('all_thana',$all_thana)
									->with('recruit_data',$data)
									->with('all_exam',$all_exam)
									->with('all_post',$all_post)
									->with('all_group_subject',$all_group_subject)
									->with('all_board_university',$all_board_university)
									->with('recruit_edu',$recruit_edu)
									->with('recruit_exp',$recruit_exp)
									->with('recruit_train',$recruit_train)
									->with('recruit_circular',$recruit_circular);
		return view('admin.admin_master')
                            ->with('main_content',$recruitment_add);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function StoreRecruit(Request $request)
    {
       // $data = request()->except(['_token']);
	   
	  
		$data['full_name'] 			= $request->full_name;
		$data['father_name'] 		= $request->father_name;
		$data['mother_name'] 		= $request->mother_name;
		$data['birth_date'] 		= $request->birth_date;
		$data['religion'] 			= $request->religion;
		$data['maritial_status'] 	= $request->maritial_status;
		$data['nationality'] 		= $request->nationality;
		$data['national_id'] 		= $request->national_id;
		$data['gender'] 			= $request->gender;
		$data['contact_num'] 		= $request->contact_num;
		$data['email'] 				= $request->email; 
		$data['vill_road'] 			= $request->vill_road;
		$data['post_office'] 		= $request->post_office;
		$data['district_code'] 		= $request->district_code;
		$data['thana_code'] 		= $request->thana_code;
		$data['permanent_add'] 		= $request->permanent_add;
		$data['circular_id'] 		= $request->circular_id;
		$data['post_id'] 			= $request->post_id;  
		
		
		
		if(isset($request->is_same_present_address)){
			$data['present_add'] 			= $data['permanent_add'];
			$data['is_same_present_address']= $request->is_same_present_address;
		}else{
			$data['present_add'] 		= $request->present_add;
		}
		if(isset($request->is_education_certif)){
			$data['is_education_certif']= $request->is_education_certif;
		}
		if(isset($request->is_nid)){
			$data['is_nid']= $request->is_nid;
		}
		if(isset($request->is_photo)){
			$data['is_photo']= $request->is_photo;
		}
		$tab_id = 1; 						
		$data_upd = array();
		$data['created_by'] = Session::get('admin_id');
		$last_insert_id = DB::table('tbl_recruitment_basic')->insertGetId($data);
		$max_recruitment_id=DB::table('tbl_recruitment_basic')
                                    ->where('circular_id',$data['circular_id'])
                                    ->where('post_id',$data['post_id'])
									->max('new_recruitment_id');
		$data_upd['new_recruitment_id'] = $new_recruitment_id = $max_recruitment_id+1;							
		 DB::table('tbl_recruitment_basic')
							->where('id',$last_insert_id)
							->update($data_upd);
		
	 
		//echo '<pre>';print_r ($data); exit;
		
		Session::flash('message1',"Data Save Successfully Your recruitment Id =  $new_recruitment_id");
		
		//// add Education 
		
		$exist_array = array();
		$data_edu = array();
		$postvalue = unserialize($request->val_id);
		//print_r($postvalue);
		$edu_val_data = $request->edu_val; 
		//print_r ($edu_val_data); exit;
		if (!empty($edu_val_data)) {
			foreach ($edu_val_data as $edu_data) { 
					$data_edu['recruitment_id'] = $last_insert_id;
					$data_edu['exam_code']   	= $edu_data['exam_code'];
					$data_edu['subject_code']   = $edu_data['subject_code'];
					$data_edu['result']   		= $edu_data['result'];
					if(!empty($edu_data['cgpa'])){
						$data_edu['cgpa']   	= $edu_data['cgpa'];
					}else{
						$data_edu['cgpa']   	= 0;
					}
					$data_edu['out_of_range']   = $edu_data['out_of_range'];
					$data_edu['pass_year']   	= $edu_data['pass_year'];
					$data_edu['school_code']   	= $edu_data['school_code'];
					$level=DB::table('tbl_exam_name')
                                    ->where('exam_code',$data_edu['exam_code'])
									->select('level_id')
									->first();
					$data_edu['level_id'] 	= $level->level_id;
					$data_edu['created_by'] = Session::get('admin_id');
				/* echo '<pre>';
				print_r ($data_edu); */
				DB::table('tbl_recruitment_edu')->insert($data_edu);  
			}			
		} 
	/// end education 
		
		/// start experience
		
		$exist_array_exp = array();
		$data_exp = array();
		$postvalue = unserialize($request->val_id);
		$exp_val_data = $request->exp_val; 
		//print_r ($exp_val_data); exit;
		if (!empty($exp_val_data)) {
			foreach ($exp_val_data as $exp_data) { 
					$data_exp['recruitment_id']   	= $last_insert_id;
					$data_exp['designation']   	= $exp_data['designation'];
					$data_exp['experience_period']   	= $exp_data['exp_period'];
					$data_exp['exp_from']   	= $exp_data['exp_from'];
					$data_exp['exp_to']   	= $exp_data['exp_to'];
					$data_exp['organization_name']   	= $exp_data['org_name'];
					$data_exp['remarks']   	= $exp_data['remarks'];
					$data_exp['created_by'] = Session::get('admin_id'); 
					DB::table('tbl_recruitment_exp')->insert($data_exp);
				 
			}	
				$data1['relevent_year'] = $request->relevent_year;
				$data1['relevent_month'] = $request->relevent_month; 
				DB::table('tbl_recruitment_basic')
							->where('id',$last_insert_id)
							->update($data1);
				
		} 
		/// end experience
		return Redirect::to("/edit-recruit/$last_insert_id/$tab_id");
    }
	
	public function EditRecruit($id,$tab_id)
    {
        $result_data=DB::table('tbl_recruitment_basic')
									->leftJoin('tbl_recruitment_circular as rc', 'rc.id', '=', 'tbl_recruitment_basic.circular_id') 
									->leftJoin('tbl_recruit_circular_post as cp', 'cp.id', '=', 'tbl_recruitment_basic.post_id') 
									->where('tbl_recruitment_basic.id',$id)
									->select('tbl_recruitment_basic.*','rc.end_date','cp.normal_age','cp.experience_age')
									->first(); 
		/* $users = DB::table('users')tbl_emp_basic_info
            ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*', 'contacts.phone', 'orders.price')
            ->get(); */
			
        //print_r ($result_data);
		$all_district=DB::table('tbl_district')
		->orderby('district_name','asc')
		->get();									
		$all_thana=DB::table('tbl_thana')->get();
		
		//print_r ($all_thana);
		//exit;
		
		$data['recruitment_id'] 	= $result_data->id;
		$data['end_date'] 			= $result_data->end_date;
		$data['normal_age'] 		= $result_data->normal_age;
		$data['new_recruitment_id'] = $result_data->new_recruitment_id;
		$data['experience_age']     = $result_data->experience_age;
		$data['full_name'] 			= $result_data->full_name;
		$data['father_name'] 		= $result_data->father_name;
		$data['mother_name'] 		= $result_data->mother_name;
		$data['birth_date'] 		= $result_data->birth_date;
		$data['religion'] 			= $result_data->religion;
		$data['maritial_status'] 	= $result_data->maritial_status;
		$data['nationality'] 		= $result_data->nationality;
		$data['national_id'] 		= $result_data->national_id;
		$data['gender'] 			= $result_data->gender;
		$data['contact_num'] 		= $result_data->contact_num;
		$data['email'] 				= $result_data->email;
		$data['present_add'] 		= $result_data->present_add;
		$data['vill_road'] 			= $result_data->vill_road;
		$data['post_office'] 		= $result_data->post_office;
		$data['district_code'] 		= $result_data->district_code;
		$data['thana_code'] 		= $result_data->thana_code;
		$data['permanent_add'] 		= $result_data->permanent_add;
		$data['circular_id'] 		= $result_data->circular_id;
		$data['post_id'] 			= $result_data->post_id;
		$data['is_education_certif']= $result_data->is_education_certif;
		$data['is_nid'] 			= $result_data->is_nid;
		$data['is_photo'] 			= $result_data->is_photo;
		$data['relevent_year'] 			= $result_data->relevent_year;
		$data['relevent_month'] 			= $result_data->relevent_month;
		$data['is_same_present_address'] = $result_data->is_same_present_address;
		$data['tab_id'] 		= $tab_id;
		
		$data['action'] 		= "/update-recruit/$id";

		
		$all_exam=DB::table('tbl_exam_name')->get();
		$all_group_subject=DB::table('tbl_subject')->get();
		$all_board_university=DB::table('tbl_board_university')->get();
									
		$recruit_edu=DB::table('tbl_recruitment_edu') 
                                    ->where('recruitment_id',$data['recruitment_id'])
									->get();
									
		$recruit_exp=DB::table('tbl_recruitment_exp')
                                    ->where('recruitment_id',$data['recruitment_id'])
									->get();
		
		$recruit_train=DB::table('tbl_recruitment_train')
                                    ->where('recruitment_id',$data['recruitment_id'])
									->get();
		$recruit_circular=DB::table('tbl_recruitment_circular')
                                    ->where('status',1)
									->get();
		$all_post =  DB::table('tbl_recruit_circular_post')
						->where('circular_id',$data['circular_id'])
						->get();
		$recruitment_add = view('admin.pages.recruitment.recruitment_form')
									->with('all_district',$all_district)
                                    ->with('all_thana',$all_thana)
									->with('recruit_data',$data)
									->with('all_exam',$all_exam)
									->with('all_post',$all_post)
									->with('all_group_subject',$all_group_subject)
									->with('all_board_university',$all_board_university)
									->with('recruit_edu',$recruit_edu)
									->with('recruit_exp',$recruit_exp)
									->with('recruit_train',$recruit_train)
									->with('recruit_circular',$recruit_circular);
		return view('admin.admin_master')
                            ->with('main_content',$recruitment_add);
    }
	
	public function UpdateRecruit(Request $request, $last_insert_id)
    {
        //echo $id; exit;
		//$data = request()->except(['_token']);
		$new_recruitment_id 		= $request->new_recruitment_id;
		$data['full_name'] 			= $request->full_name;
		$data['father_name'] 		= $request->father_name;
		$data['mother_name'] 		= $request->mother_name;
		$data['birth_date'] 		= $request->birth_date;
		$data['religion'] 			= $request->religion;
		$data['maritial_status'] 	= $request->maritial_status;
		$data['nationality'] 		= $request->nationality;
		$data['national_id'] 		= $request->national_id;
		$data['gender'] 			= $request->gender;
		$data['contact_num'] 		= $request->contact_num;
		$data['email'] 				= $request->email; 
		$data['vill_road'] 			= $request->vill_road;
		$data['post_office'] 		= $request->post_office;
		$data['district_code'] 		= $request->district_code;
		$data['thana_code'] 		= $request->thana_code;
		$data['permanent_add'] 		= $request->permanent_add;
		$data['circular_id'] 		= $request->circular_id;
		$data['post_id'] 			= $request->post_id; 
		
		if(isset($request->is_same_present_address)){
			$data['present_add'] 			= $data['permanent_add'];
			$data['is_same_present_address']= $request->is_same_present_address;
		}else{
			$data['present_add'] 		= $request->present_add;
			$data['is_same_present_address']= 0;
		}

		
		if(isset($request->is_education_certif)){
			$data['is_education_certif']= $request->is_education_certif;
		}else{
			$data['is_education_certif']= 0;
		}
		if(isset($request->is_nid)){
			$data['is_nid']= $request->is_nid;
		}else{
			$data['is_nid']= 0;
		}
		if(isset($request->is_photo)){
			$data['is_photo']= $request->is_photo;
		}else{
			$data['is_photo']= 0;
		}
		
		$data['updated_by'] = Session::get('admin_id');
		//print_r ($data); exit;
		DB::table('tbl_recruitment_basic')
				->where('id', $last_insert_id)
				->update($data);
		Session::flash('message1',"Data Save Successfully ID = $new_recruitment_id");
		
		//// education //// 
		$exist_array = array();
		$data_edu = array();
		$postvalue = unserialize($request->val_id_edu);
		//print_r($postvalue);
		$edu_val_data = $request->edu_val; 
		//print_r ($edu_val_data); exit;
		if (!empty($edu_val_data)) {
			foreach ($edu_val_data as $edu_data) {
				if (!empty($edu_data['id'])) {			 
					$exist_array[]=$edu_data['id'];
					$id   	= $edu_data['id'];
					$data_edu['recruitment_id'] = $last_insert_id;
					$data_edu['exam_code']   	= $edu_data['exam_code'];
					$data_edu['subject_code']   = $edu_data['subject_code'];
					$data_edu['result']   		= $edu_data['result']; 
					if(!empty($edu_data['cgpa'])){
						$data_edu['cgpa']   	= $edu_data['cgpa'];
					}else{
						$data_edu['cgpa']   	= 0;
					}
					$data_edu['out_of_range']   		= $edu_data['out_of_range'];
					$data_edu['pass_year']   	= $edu_data['pass_year'];
					$data_edu['school_code']   	= $edu_data['school_code'];
					$level=DB::table('tbl_exam_name')
                                    ->where('exam_code',$data_edu['exam_code'])
									->select('level_id')
									->first();
					//$data_edu['level_id'] 	= implode($level);
					$data_edu['level_id'] 	= $level->level_id;
					$data_edu['updated_by'] = Session::get('admin_id');
				/* echo '<pre>';
				print_r ($data_edu);	 */
				 DB::table('tbl_recruitment_edu')
							->where('id',$id)
							->update($data_edu);
				} else {
					$data_edu['recruitment_id'] = $last_insert_id;
					$data_edu['exam_code']   	= $edu_data['exam_code'];
					$data_edu['subject_code']   = $edu_data['subject_code'];
					$data_edu['result']   		= $edu_data['result'];
					if(!empty($edu_data['cgpa'])){
						$data_edu['cgpa']   	= $edu_data['cgpa'];
					}else{
						$data_edu['cgpa']   	= 0;
					}
					$data_edu['out_of_range']   = $edu_data['out_of_range'];
					$data_edu['pass_year']   	= $edu_data['pass_year'];
					$data_edu['school_code']   	= $edu_data['school_code'];
					$level=DB::table('tbl_exam_name')
                                    ->where('exam_code',$data_edu['exam_code'])
									->select('level_id')
									->first();
					$data_edu['level_id'] 	= $level->level_id;
					$data_edu['created_by'] = Session::get('admin_id');
				/* echo '<pre>';
				print_r ($data_edu); */
				DB::table('tbl_recruitment_edu')->insert($data_edu);
				}
			}			
		}
		
		$delete_data = array_diff($postvalue,$exist_array);
		/* print_r ($postvalue); exit;
		  */
		foreach($delete_data as $del_data) {

			DB::table('tbl_recruitment_edu')
			->where('id',$del_data)
			->delete();
		} 
		
		/// start experience
		
		$exist_array_exp = array();
		$data_exp = array();
		$postvalue = unserialize($request->val_id_exp);
		$exp_val_data = $request->exp_val; 
		//print_r ($exp_val_data); exit;
		if (!empty($exp_val_data)) {
			foreach ($exp_val_data as $exp_data) {
				if (!empty($exp_data['id'])) {			 
					$exist_array_exp[]=$exp_data['id'];
					$id   	= $exp_data['id'];
					$data_exp['recruitment_id']   	= $last_insert_id;
					$data_exp['designation']   	= $exp_data['designation'];
					$data_exp['experience_period']   	= $exp_data['exp_period'];
					$data_exp['exp_from']   	= $exp_data['exp_from'];
					$data_exp['exp_to']   	= $exp_data['exp_to'];
					$data_exp['organization_name']   	= $exp_data['org_name'];
					$data_exp['remarks']   	= $exp_data['remarks'];
					$data_exp['updated_by'] = Session::get('admin_id');
					
				DB::table('tbl_recruitment_exp')
							->where('id',$id)
							->update($data_exp);
				} else {
					$data_exp['recruitment_id']   	= $last_insert_id;
					$data_exp['designation']   	= $exp_data['designation'];
					$data_exp['experience_period']   	= $exp_data['exp_period'];
					$data_exp['exp_from']   	= $exp_data['exp_from'];
					$data_exp['exp_to']   	= $exp_data['exp_to'];
					$data_exp['organization_name']   	= $exp_data['org_name'];
					$data_exp['remarks']   	= $exp_data['remarks'];
					$data_exp['created_by'] = Session::get('admin_id');
					
				DB::table('tbl_recruitment_exp')->insert($data_exp);
				}
			}	
				$data1['relevent_year'] = $request->relevent_year;
				$data1['relevent_month'] = $request->relevent_month; 
				DB::table('tbl_recruitment_basic')
							->where('id',$last_insert_id)
							->update($data1);
				
		}
		
		$delete_data_exp = array_diff($postvalue,$exist_array_exp);
		foreach($delete_data_exp as $del_data) {

			DB::table('tbl_recruitment_exp')
			->where('id',$del_data)
			->delete();
		}
		/// end experience
		
		return Redirect::to("/edit-recruit/$last_insert_id/1");
    }
	
	/* public function RecruitEdu(Request $request)
    {
		
		$exist_array = array();
		$postvalue = unserialize($request->val_id);
		//print_r($postvalue);
		$edu_val_data = $request->edu_val;
		$recruitment_id = $request->recruitment_id;
		//print_r ($edu_val_data); exit;
		if (!empty($edu_val_data)) {
			foreach ($edu_val_data as $edu_data) {
				if (!empty($edu_data['id'])) {			 
					$exist_array[]=$edu_data['id'];
					$id   	= $edu_data['id'];
					$data['recruitment_id'] = $recruitment_id;
					$data['exam_code']   	= $edu_data['exam_code'];
					$data['subject_code']   = $edu_data['subject_code'];
					$data['result']   		= $edu_data['result']; 
					if(!empty($edu_data['cgpa'])){
						$data['cgpa']   	= $edu_data['cgpa'];
					}else{
						$data['cgpa']   	= 0;
					}
					$data['out_of_range']   		= $edu_data['out_of_range'];
					$data['pass_year']   	= $edu_data['pass_year'];
					$data['school_code']   	= $edu_data['school_code'];
					$level=DB::table('tbl_exam_name')
                                    ->where('exam_code',$data['exam_code'])
									->select('level_id')
									->first();
					//$data['level_id'] 	= implode($level);
					$data['level_id'] 	= $level->level_id;
					$data['updated_by'] = Session::get('admin_id');
				/* echo '<pre>';
				print_r ($data);	  
				 DB::table('tbl_recruitment_edu')
							->where('id',$id)
							->update($data);
				} else {
					$data['recruitment_id'] = $recruitment_id;
					$data['exam_code']   	= $edu_data['exam_code'];
					$data['subject_code']   = $edu_data['subject_code'];
					$data['result']   		= $edu_data['result'];
					if(!empty($edu_data['cgpa'])){
						$data['cgpa']   	= $edu_data['cgpa'];
					}else{
						$data['cgpa']   	= 0;
					}
					$data['out_of_range']   = $edu_data['out_of_range'];
					$data['pass_year']   	= $edu_data['pass_year'];
					$data['school_code']   	= $edu_data['school_code'];
					$level=DB::table('tbl_exam_name')
                                    ->where('exam_code',$data['exam_code'])
									->select('level_id')
									->first();
					$data['level_id'] 	= $level->level_id;
					$data['created_by'] = Session::get('admin_id');
				/* echo '<pre>';
				print_r ($data);  
				DB::table('tbl_recruitment_edu')->insert($data);
				}
			}			
		}
		//print_r ($exist_array); exit;
		 //exit;
		$delete_data = array_diff($postvalue,$exist_array);
		foreach($delete_data as $del_data) {

			DB::table('tbl_recruitment_edu')
			->where('id',$del_data)
			->delete();
		}
		Session::flash('message2','Data Save Successfully');
		//return back()->withInput();
		return Redirect::to("/edit-recruit/$recruitment_id/2");
		//return Redirect::to("/emp-general/$emp_id/2");
    } */
	
	public function RecruitTraining(Request $request)
    {
		
		$exist_array = array();
		$postvalue = unserialize($request->val_id);
		$tra_val_data = $request->tra_val;
		$recruitment_id = $request->recruitment_id;
		//print_r ($tra_val_data); exit;
		if (!empty($tra_val_data)) {
			foreach ($tra_val_data as $tra_data) {
				if (!empty($tra_data['id'])) {			 
					$exist_array[]=$tra_data['id'];
					$id   	= $tra_data['id'];
					$data['recruitment_id']   	= $recruitment_id;
					$data['train_name']   	= $tra_data['tr_name'];
					$data['train_period']   	= $tra_data['tr_period'];
					$data['train_period_to']   = $tra_data['tr_period_to'];
					$data['institute']   	= $tra_data['tr_institute'];
					$data['palace']   	= $tra_data['tr_palace'];
					$data['remarks']   	= $tra_data['tr_remarks'];
					$data['updated_by'] = Session::get('admin_id');
					
				DB::table('tbl_recruitment_train')
							->where('id',$id)
							->update($data);
				} else {
					$data['recruitment_id']   	= $recruitment_id;
					$data['train_name']   	= $tra_data['tr_name'];
					$data['train_period']   	= $tra_data['tr_period'];
					$data['train_period_to']   = $tra_data['tr_period_to'];
					$data['institute']   	= $tra_data['tr_institute'];
					$data['palace']   	= $tra_data['tr_palace'];
					$data['remarks']   	= $tra_data['tr_remarks'];
					$data['created_by'] = Session::get('admin_id');
					
				DB::table('tbl_recruitment_train')->insert($data);
				}
			}			
		}
		
		$delete_data = array_diff($postvalue,$exist_array);
		foreach($delete_data as $del_data) {

			DB::table('tbl_recruitment_train')
			->where('id',$del_data)
			->delete();
		}
		Session::flash('message3', 'Data Save Successfully!');
		//return back()->withInput();
		return Redirect::to("/edit-recruit/$recruitment_id/3");
    }
	
	/* public function RecruitExperience(Request $request)
    { 
		$exist_array = array();
		$postvalue = unserialize($request->val_id);
		$exp_val_data = $request->exp_val;
		$recruitment_id = $request->recruitment_id;
		//print_r ($exp_val_data); exit;
		if (!empty($exp_val_data)) {
			foreach ($exp_val_data as $exp_data) {
				if (!empty($exp_data['id'])) {			 
					$exist_array[]=$exp_data['id'];
					$id   	= $exp_data['id'];
					$data['recruitment_id']   	= $recruitment_id;
					$data['designation']   	= $exp_data['designation'];
					$data['experience_period']   	= $exp_data['exp_period'];
					$data['exp_from']   	= $exp_data['exp_from'];
					$data['exp_to']   	= $exp_data['exp_to'];
					$data['organization_name']   	= $exp_data['org_name'];
					$data['remarks']   	= $exp_data['remarks'];
					$data['updated_by'] = Session::get('admin_id');
					
				DB::table('tbl_recruitment_exp')
							->where('id',$id)
							->update($data);
				} else {
					$data['recruitment_id']   	= $recruitment_id;
					$data['designation']   	= $exp_data['designation'];
					$data['experience_period']   	= $exp_data['exp_period'];
					$data['exp_from']   	= $exp_data['exp_from'];
					$data['exp_to']   	= $exp_data['exp_to'];
					$data['organization_name']   	= $exp_data['org_name'];
					$data['remarks']   	= $exp_data['remarks'];
					$data['created_by'] = Session::get('admin_id');
					
				DB::table('tbl_recruitment_exp')->insert($data);
				}
			}	
				$data1['relevent_year'] = $request->relevent_year;
				$data1['relevent_month'] = $request->relevent_month; 
				DB::table('tbl_recruitment_basic')
							->where('id',$recruitment_id)
							->update($data1);
				
		}
		
		$delete_data = array_diff($postvalue,$exist_array);
		foreach($delete_data as $del_data) {

			DB::table('tbl_recruitment_exp')
			->where('id',$del_data)
			->delete();
		}
		Session::flash('message4', 'Data Save Successfully!');
		//return back()->withInput();
		return Redirect::to("/edit-recruit/$recruitment_id/4");
    } */
    public function select_circular_post($circular_id)
    {
       $all_post =  DB::table('tbl_recruit_circular_post')
						->where('circular_id',$circular_id)
						->get();
		//print_r($all_post);			
		 echo "<option value=''>--Select--</option>";
		foreach($all_post as $post){
			echo "<option value='$post->id'>$post->post_name</option>";
		} 
    }
	public function select_circular_date($circular_id,$post_id)
    {
        $circular_date =  DB::table('tbl_recruit_circular_post') 
						->leftJoin('tbl_recruitment_circular as rc', 'tbl_recruit_circular_post.circular_id', '=', 'rc.id')
						->where('tbl_recruit_circular_post.id',$post_id)
						->where('tbl_recruit_circular_post.circular_id',$circular_id)
						->select('tbl_recruit_circular_post.normal_age','tbl_recruit_circular_post.experience_age','rc.end_date')
						->first();
		$end_date = $circular_date->end_date;
		$normal_age = $circular_date->normal_age;
		$experience_age = $circular_date->experience_age;
		 echo json_encode(array('end_date' => $end_date,'normal_age' => $normal_age,'experience_age' => $experience_age));		
		 
    }
	 
	public function recruitment_view($id)
    { 
		$data = array();
		$data['recruitment_cv_basic'] =DB::table('tbl_recruitment_basic')
											->where('id',$id)
											->first();
		$data['emp_cv_basic'] =DB::table('tbl_emp_basic_info')
                                    ->where('emp_id',$id)
									->first();
		$data['recruitment_cv_edu'] =DB::table('tbl_recruitment_edu')
                                    ->join('tbl_exam_name', 'tbl_exam_name.exam_code', '=', 'tbl_recruitment_edu.exam_code')
                                    ->join('tbl_board_university', 'tbl_board_university.board_uni_code', '=', 'tbl_recruitment_edu.school_code')
                                    ->join('tbl_subject', 'tbl_subject.subject_code', '=', 'tbl_recruitment_edu.subject_code')
									->where('tbl_recruitment_edu.recruitment_id',$id)
									->get();
		//print_r ($emp_cv_basic);
		$data['recruitment_cv_tra'] =DB::table('tbl_recruitment_train')
                                    ->where('recruitment_id',$id)
									->get();
									
		$data['recruitment_cv_exp'] =DB::table('tbl_recruitment_exp')
                                    ->where('recruitment_id',$id)
									->get();  
        return view('admin.pages.recruitment.recruitment_cv_view' , $data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
    public function delete_recruit($id)
    {
        DB::table('tbl_recruitment_basic')
			->where('id',$id)
			->delete();
		DB::table('tbl_recruitment_edu')
			->where('recruitment_id',$id)
			->delete();
		DB::table('tbl_recruitment_exp')
			->where('recruitment_id',$id)
			->delete();
		Session::flash('message11', 'Data Delete Successfully!');
		//return back()->withInput();
		return Redirect::to("/recruitment");	
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
