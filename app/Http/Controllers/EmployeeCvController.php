<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
use PDF;

class EmployeeCvController extends Controller
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
        return view('admin.pages.employee.emp_cv_form');	
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function EmpStore(Request $request)
    {
		$this->validate($request, [
			'emp_id' => 'required|unique:tbl_emp_basic_info',
		]);
		$data = request()->except(['_token']);
		$data['created_by'] = Session::get('admin_id');
		//print_r ($data); exit;
		$emp_id = $request->emp_id;
		DB::table('tbl_emp_basic_info')->insert($data);
		Session::flash('message1','Data Save Successfully');
		return Redirect::to("/emp-general/$emp_id/1");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowData($id,$tab_id)
    {
        $emp_cv=DB::table('tbl_appointment_info as ap')
				->leftJoin('tbl_emp_basic_info as em', 'ap.emp_id', '=', 'em.emp_id')
				->select('ap.emp_id as ap_emp_id','ap.emp_name','ap.emp_name_bangla','ap.fathers_name','ap.joining_date','ap.emp_village','ap.emp_po','ap.emp_district','ap.emp_thana','ap.country_id as country_name', 'em.*')
				->where('ap.emp_id',$id)
				->first();
									
		/* $users = DB::table('users')tbl_emp_basic_info
            ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*', 'contacts.phone', 'orders.price')
            ->get(); */
			
        //print_r ($emp_cv);
		$all_district=DB::table('tbl_district')->get();									
		$all_thana=DB::table('tbl_thana')->get();
		$all_functional_designation=DB::table('tbl_functional_designation')->get();
		
		//print_r ($all_thana);
		//exit;
		
		$data['emp_id'] 			= $emp_cv->ap_emp_id;
		$emp_id 					= $emp_cv->emp_id;
		$data['emp_name'] 			= $emp_cv->emp_name;
		$data['emp_name_ban'] 		= $emp_cv->emp_name_bangla;
		$data['father_name'] 		= $emp_cv->fathers_name;
		$data['mother_name'] 		= $emp_cv->mother_name;
		$data['birth_date'] 		= $emp_cv->birth_date;
		$data['religion'] 			= $emp_cv->religion;
		$data['maritial_status'] 	= $emp_cv->maritial_status;
		$data['nationality'] 		= $emp_cv->nationality;
		$data['national_id'] 		= $emp_cv->national_id;
		$data['gender'] 			= $emp_cv->gender;
		$data['country_id'] 		= $emp_cv->country_name;
		$data['contact_num'] 		= $emp_cv->contact_num;
		$data['email'] 				= $emp_cv->email;
		$data['blood_group'] 		= $emp_cv->blood_group;
		$data['org_join_date'] 		= $emp_cv->joining_date;
		$data['present_add'] 		= $emp_cv->present_add;
		$data['vill_road'] 			= $emp_cv->emp_village;
		$data['post_office'] 		= $emp_cv->emp_po;
		$data['district_code'] 		= $emp_cv->emp_district;
		$data['thana_code'] 		= $emp_cv->emp_thana;
		$data['permanent_add'] 		= $emp_cv->permanent_add;
		$data['fun_desig_id'] 		= $emp_cv->fun_desig_id;
		$data['tab_id'] 			= $tab_id;
		
		if (!empty($emp_id)) {
			$data['action'] 		= "/update-emp/$emp_id";
		} else {
			$data['action'] 		= "/emp-general";
		}
		
		$all_exam=DB::table('tbl_exam_name')->get();
		$all_group_subject=DB::table('tbl_subject')->get();
		$all_board_university=DB::table('tbl_board_university')->get();
									
		$edu_up_val=DB::table('tbl_emp_edu_info')
                                    ->where('emp_id',$data['emp_id'])
									->get();
									
		$tra_up_val=DB::table('tbl_emp_train_info')
                                    ->where('emp_id',$data['emp_id'])
									->get();
		
		$exp_up_val=DB::table('tbl_emp_exp_info')
                                    ->where('emp_id',$data['emp_id'])
									->get();
									
		$ref_up_val=DB::table('tbl_emp_ref_info')
                                    ->where('emp_id',$data['emp_id'])
									->get();
									
		$emp_photo_val=DB::table('tbl_emp_photo')
                                    ->where('emp_id',$data['emp_id'])
									->first();
									
		$neces_phone_up_val=DB::table('tbl_emp_neces_phone')
                                    ->where('emp_id',$data['emp_id'])
									->get();
									
		$other_up_val=DB::table('tbl_emp_other')
                                    ->where('emp_id',$data['emp_id'])
									->get();
        //print_r ($edu_up_val);
		$emp_cv_add=view('admin.pages.employee.emp_cv_form')
                                            ->with('all_district',$all_district)
                                            ->with('all_thana',$all_thana)
                                            ->with('all_functional_designation',$all_functional_designation)
                                            ->with('emp_cv',$data)
                                            ->with('all_exam',$all_exam)
                                            ->with('all_group_subject',$all_group_subject)
                                            ->with('all_board_university',$all_board_university)
                                            ->with('edu_up_val',$edu_up_val)
                                            ->with('tra_up_val',$tra_up_val)
                                            ->with('exp_up_val',$exp_up_val)
                                            ->with('ref_up_val',$ref_up_val)
											->with('emp_photo_val',$emp_photo_val)
											->with('neces_phone_up_val',$neces_phone_up_val)
											->with('other_up_val',$other_up_val);
        return view('admin.admin_master')
                            ->with('main_content',$emp_cv_add);
		//return view('admin.pages.employee.appoionment_form',$data);
    }
	
	public function SelectThana($district_id)
    {  
		//echo $district_id;
		$all_upzila = DB::table('tbl_thana')
					  ->select('*')
					  ->where('district_code',$district_id) 
                      ->get();
		echo "<option value=''>--Select--</option>";
		foreach($all_upzila as $upzila){
			echo "<option value='$upzila->thana_code'>$upzila->thana_name</option>";
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        /* echo $id; exit;
		$data = request()->except(['_token']);
		print_r ($data); exit;
		DB::table('tbl_emp_basic_info')
				->where('emp_id', $id)
				->update($data);
		return Redirect::back(); */
    }
	
	public function update_emp_general(Request $request, $id)
    {
        //echo $id; exit;
		$data = request()->except(['_token']);
		$data['updated_by'] = Session::get('admin_id');
		//print_r ($data); exit;
		DB::table('tbl_emp_basic_info')
				->where('emp_id', $id)
				->update($data);
		Session::flash('message1','Data Save Successfully');
		return Redirect::to("/emp-general/$id/1");
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
	
	public function EmpCvEdu(Request $request)
    {
		
		$exist_array = array();
		$postvalue = unserialize($request->val_id);
		//print_r($postvalue);
		$edu_val_data = $request->edu_val;
		$emp_id = $request->emp_id;
		//print_r ($edu_val_data); exit;
		if (!empty($edu_val_data)) {
			foreach ($edu_val_data as $edu_data) {
				if (!empty($edu_data['id'])) {			 
					$exist_array[]=$edu_data['id'];
					$id   	= $edu_data['id'];
					$data['emp_id']   	= $emp_id;
					$data['exam_code']   	= $edu_data['exam_code'];
					$data['subject_code']   	= $edu_data['subject_code'];
					$data['result']   	= $edu_data['result'];
					$data['pass_year']   	= $edu_data['pass_year'];
					$data['school_code']   	= $edu_data['school_code'];
					$data['note']   	= $edu_data['note'];
					$level=DB::table('tbl_exam_name')
                                    ->where('exam_code',$data['exam_code'])
									->select('level_id')
									->first();
					//$data['level_id'] 	= implode($level);
					$data['level_id'] 	= $level->level_id;
					$data['updated_by'] = Session::get('admin_id');
				//print_r ($data);exit;	
				DB::table('tbl_emp_edu_info')
							->where('id',$id)
							->update($data);
				} else {
					$data['emp_id']   	= $emp_id;
					$data['exam_code']   	= $edu_data['exam_code'];
					$data['subject_code']   	= $edu_data['subject_code'];
					$data['result']   	= $edu_data['result'];
					$data['pass_year']   	= $edu_data['pass_year'];
					$data['school_code']   	= $edu_data['school_code'];
					$data['note']   	= $edu_data['note'];
					$level=DB::table('tbl_exam_name')
                                    ->where('exam_code',$data['exam_code'])
									->select('level_id')
									->first();
					$data['level_id'] 	= $level->level_id;
					$data['created_by'] = Session::get('admin_id');
					
				DB::table('tbl_emp_edu_info')->insert($data);
				}
			}			
		}
		//print_r ($exist_array); exit;
		$delete_data = array_diff($postvalue,$exist_array);
		foreach($delete_data as $del_data) {

			DB::table('tbl_emp_edu_info')
			->where('id',$del_data)
			->delete();
		}
		Session::flash('message2','Data Save Successfully');
		//return back()->withInput();
		return Redirect::to("/emp-general/$emp_id/2");
    }
	
	public function EmpCvTraining(Request $request)
    {
		
		$exist_array = array();
		$postvalue = unserialize($request->val_id);
		$tra_val_data = $request->tra_val;
		$emp_id = $request->emp_id;
		//print_r ($tra_val_data); exit;
		if (!empty($tra_val_data)) {
			foreach ($tra_val_data as $tra_data) {
				if (!empty($tra_data['id'])) {			 
					$exist_array[]=$tra_data['id'];
					$id   	= $tra_data['id'];
					$data['emp_id']   	= $emp_id;
					$data['train_name']   	= $tra_data['tr_name'];
					$data['train_period']   	= $tra_data['tr_period'];
					$data['train_period_to']   = $tra_data['tr_period_to'];
					$data['institute']   	= $tra_data['tr_institute'];
					$data['palace']   	= $tra_data['tr_palace'];
					$data['remarks']   	= $tra_data['tr_remarks'];
					$data['updated_by'] = Session::get('admin_id');
					
				DB::table('tbl_emp_train_info')
							->where('id',$id)
							->update($data);
				} else {
					$data['emp_id']   	= $emp_id;
					$data['train_name']   	= $tra_data['tr_name'];
					$data['train_period']   	= $tra_data['tr_period'];
					$data['train_period_to']   = $tra_data['tr_period_to'];
					$data['institute']   	= $tra_data['tr_institute'];
					$data['palace']   	= $tra_data['tr_palace'];
					$data['remarks']   	= $tra_data['tr_remarks'];
					$data['created_by'] = Session::get('admin_id');
					
				DB::table('tbl_emp_train_info')->insert($data);
				}
			}			
		}
		
		$delete_data = array_diff($postvalue,$exist_array);
		foreach($delete_data as $del_data) {

			DB::table('tbl_emp_train_info')
			->where('id',$del_data)
			->delete();
		}
		Session::flash('message3', 'Data Save Successfully!');
		//return back()->withInput();
		return Redirect::to("/emp-general/$emp_id/3");
    }
	
	public function EmpCvExperience(Request $request)
    {
		
		$exist_array = array();
		$postvalue = unserialize($request->val_id);
		$exp_val_data = $request->exp_val;
		$emp_id = $request->emp_id;
		//print_r ($exp_val_data); exit;
		if (!empty($exp_val_data)) {
			foreach ($exp_val_data as $exp_data) {
				if (!empty($exp_data['id'])) {			 
					$exist_array[]=$exp_data['id'];
					$id   	= $exp_data['id'];
					$data['emp_id']   	= $emp_id;
					$data['designation']   	= $exp_data['designation'];
					$data['experience_period']   	= $exp_data['exp_period'];
					$data['organization_name']   	= $exp_data['org_name'];
					$data['remarks']   	= $exp_data['remarks'];
					$data['updated_by'] = Session::get('admin_id');
					
				DB::table('tbl_emp_exp_info')
							->where('id',$id)
							->update($data);
				} else {
					$data['emp_id']   	= $emp_id;
					$data['designation']   	= $exp_data['designation'];
					$data['experience_period']   	= $exp_data['exp_period'];
					$data['organization_name']   	= $exp_data['org_name'];
					$data['remarks']   	= $exp_data['remarks'];
					$data['created_by'] = Session::get('admin_id');
					
				DB::table('tbl_emp_exp_info')->insert($data);
				}
			}			
		}
		
		$delete_data = array_diff($postvalue,$exist_array);
		foreach($delete_data as $del_data) {

			DB::table('tbl_emp_exp_info')
			->where('id',$del_data)
			->delete();
		}
		Session::flash('message4', 'Data Save Successfully!');
		//return back()->withInput();
		return Redirect::to("/emp-general/$emp_id/4");
    }
	
	public function EmpCvReference(Request $request)
    {
		$exist_array = array();
		$postvalue = unserialize($request->val_id);
		$refer_val_data = $request->refer_val;
		$emp_id = $request->emp_id;
		//print_r ($refer_val_data); exit;
		if (!empty($refer_val_data)) {
			foreach ($refer_val_data as $refer_data) {
				if (!empty($refer_data['id'])) {			 
					$exist_array[]=$refer_data['id'];
					$id   	= $refer_data['id'];
					$data['emp_id']   	= $emp_id;
					$data['rf_name']   	= $refer_data['refer_name'];
					$data['rf_occupation']   	= $refer_data['occupation'];
					$data['rf_address']   	= $refer_data['address'];
					$data['rf_mobile']   	= $refer_data['contact_no'];
					$data['rf_email']   	= $refer_data['email'];
					$data['rf_national_id']   	= $refer_data['nid'];
					$data['rf_remarks']   	= $refer_data['remarks'];
					$data['updated_by'] = Session::get('admin_id');
					
				DB::table('tbl_emp_ref_info')
							->where('id',$id)
							->update($data);
				} else {
					$data['emp_id']   	= $emp_id;
					$data['rf_name']   	= $refer_data['refer_name'];
					$data['rf_occupation']   	= $refer_data['occupation'];
					$data['rf_address']   	= $refer_data['address'];
					$data['rf_mobile']   	= $refer_data['contact_no'];
					$data['rf_email']   	= $refer_data['email'];
					$data['rf_national_id']   	= $refer_data['nid'];
					$data['rf_remarks']   	= $refer_data['remarks'];
					$data['created_by'] = Session::get('admin_id');
					
				DB::table('tbl_emp_ref_info')->insert($data);
				}
			}			
		}
		
		$delete_data = array_diff($postvalue,$exist_array);
		foreach($delete_data as $del_data) {

			DB::table('tbl_emp_ref_info')
			->where('id',$del_data)
			->delete();
		}
		Session::flash('message5', 'Data Save Successfully!');
		//return back()->withInput();
		return Redirect::to("/emp-general/$emp_id/5");
    }
	
	public function EmpCvPhoto(Request $request)
    {
		
		$emp_id = $request->emp_id;
		$image = $request->file('emp_photo'); 
		
		if($image){
			$ext = strtolower($image->getClientOriginalExtension());
			$image_name = $emp_id.'.'.$ext;
			/* echo '<pre>';
			print_r($image_name);
			exit; */
			$upload_path ='public/employee/';  
			//$image_url = $upload_path.$image_name;
			$image_url = $image_name;
			
			$result=DB::table('tbl_emp_photo')
                                    ->where('emp_id',$emp_id)
									->value('emp_photo');
			
			if (!empty($result)) {
				$unlink_path = $_SERVER['DOCUMENT_ROOT'].'/hrm/'.$upload_path.$result;
				//print_r ($unlink_path); exit;
				if(is_readable($unlink_path))
				{
					unlink($unlink_path);
				}
				$success = $image->move($upload_path,$image_name);
				if($success){
					DB::table('tbl_emp_photo')
							->where('emp_id',$emp_id)
							->update(['emp_photo' => $image_url]);
				}
				
			} else {
				$success = $image->move($upload_path,$image_name);
				if($success){
					$perdata['emp_id'] = $emp_id;
					$perdata['emp_photo'] = $image_url;
					DB::table('tbl_emp_photo')->insert($perdata);
					
				}
			}									
		}
		Session::flash('message6', 'Data Save Successfully!'); 
		return Redirect::to("/emp-general/$emp_id/6");
    }
	
	public function EmpCvNecessaryPhone(Request $request)
    {
		
		$exist_array = array();
		$postvalue = unserialize($request->val_id);
		$neces_phone_val_data = $request->neces_phone_val;
		$emp_id = $request->emp_id;
		//print_r ($neces_phone_val_data); exit;
		if (!empty($neces_phone_val_data)) {
			foreach ($neces_phone_val_data as $neces_phone_data) {
				if (!empty($neces_phone_data['id'])) {			 
					$exist_array[]=$neces_phone_data['id'];
					$id   	= $neces_phone_data['id'];
					$data['emp_id']   	= $emp_id;
					$data['name']   	= $neces_phone_data['name'];
					$data['relation']   	= $neces_phone_data['relation'];
					$data['address']   	= $neces_phone_data['address'];
					$data['mobile']   	= $neces_phone_data['contact_no'];
					$data['email']   	= $neces_phone_data['email'];
					$data['national_id']   	= $neces_phone_data['nid'];
					$data['remarks']   	= $neces_phone_data['remarks'];
					$data['updated_by'] = Session::get('admin_id');
					
				DB::table('tbl_emp_neces_phone')
							->where('id',$id)
							->update($data);
				} else {
					$data['emp_id']   	= $emp_id;
					$data['name']   	= $neces_phone_data['name'];
					$data['relation']   	= $neces_phone_data['relation'];
					$data['address']   	= $neces_phone_data['address'];
					$data['mobile']   	= $neces_phone_data['contact_no'];
					$data['email']   	= $neces_phone_data['email'];
					$data['national_id']   	= $neces_phone_data['nid'];
					$data['remarks']   	= $neces_phone_data['remarks'];
					$data['created_by'] = Session::get('admin_id');
					
				DB::table('tbl_emp_neces_phone')->insert($data);
				}
			}			
		}
		
		$delete_data = array_diff($postvalue,$exist_array);
		foreach($delete_data as $del_data) {

			DB::table('tbl_emp_neces_phone')
			->where('id',$del_data)
			->delete();
		}
		Session::flash('message7', 'Data Save Successfully!');
		//return back()->withInput();
		return Redirect::to("/emp-general/$emp_id/7");
    }
	
	public function EmpCvOther(Request $request)
    {
		
		$exist_array = array();
		$postvalue = unserialize($request->val_id);
		$other_val_data = $request->other_val;
		$emp_id = $request->emp_id;
		//print_r ($other_val_data); exit;
		if (!empty($other_val_data)) {
			foreach ($other_val_data as $other_data) {
				if (!empty($other_data['id'])) {			 
					$exist_array[]=$other_data['id'];
					$id   	= $other_data['id'];
					$data['emp_id']   	= $emp_id;
					$data['op_subject']   	= $other_data['subject'];
					$data['op_details']   	= $other_data['details'];
					$data['updated_by'] = Session::get('admin_id');
					
				DB::table('tbl_emp_other')
							->where('id',$id)
							->update($data);
				} else {
					$data['emp_id']   	= $emp_id;
					$data['op_subject']   	= $other_data['subject'];
					$data['op_details']   	= $other_data['details'];
					$data['created_by'] = Session::get('admin_id');
					
				DB::table('tbl_emp_other')->insert($data);
				}
			}			
		}
		
		$delete_data = array_diff($postvalue,$exist_array);
		foreach($delete_data as $del_data) {

			DB::table('tbl_emp_other')
			->where('id',$del_data)
			->delete();
		}
		Session::flash('message8', 'Data Save Successfully!');
		//return back()->withInput();
		return Redirect::to("/emp-general/$emp_id/8");
    }
	
	public function EmpCvPdf($id)
    {
		$data['emp_cv_basic']=DB::table('tbl_emp_basic_info')
                                    ->where('emp_id',$id)
									->first();
							
		$data['emp_cv_edu']=DB::table('tbl_emp_edu_info as ed')
                                    ->leftJoin('tbl_exam_name as en', 'ed.exam_code', '=', 'en.exam_code')
                                    ->leftJoin('tbl_board_university as bu', 'ed.school_code', '=', 'bu.board_uni_code')
                                    ->leftJoin('tbl_subject as sb', 'ed.subject_code', '=', 'sb.subject_code')
									->where('ed.emp_id',$id)
									->orderBy('en.level_id', 'ASC')
									->get();
		//print_r ($emp_cv_basic);
		$data['emp_cv_tra']=DB::table('tbl_emp_train_info')
                                    ->where('emp_id',$id)
									->get();
									
		$data['emp_cv_exp']=DB::table('tbl_emp_exp_info')
                                    ->where('emp_id',$id)
									->get();
									
		$data['emp_cv_ref']=DB::table('tbl_emp_ref_info')
                                    ->where('emp_id',$id)
									->get();
									
		$data['emp_cv_photo']=DB::table('tbl_emp_photo')
                                    ->where('emp_id',$id)
									->first();
		//print_r ($emp_cv_photo);							
		/* $emp_cv_view=view('admin.pages.employee.emp_cv_view')
						->with('emp_cv_basic',$emp_cv_basic)
						->with('emp_cv_edu',$emp_cv_edu)
						->with('emp_cv_tra',$emp_cv_tra)
						->with('emp_cv_exp',$emp_cv_exp)
						->with('emp_cv_ref',$emp_cv_ref)
						->with('emp_cv_photo',$emp_cv_photo); */
		
        //return view('admin.admin_master')->with('main_content',$emp_cv_view);
		/* Pdf Generate */
		$pdf = PDF::loadView('admin.pages.employee.emp_cv_pdf',$data,[],['format' => 'A4']);
		return $pdf->download('emp_cv.pdf');
    }
	
	
}
