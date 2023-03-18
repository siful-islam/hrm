<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
use PDF;
use File;
use App\Mail\BookingMail;
use App\Mail;

class BrTransferController extends Controller
{
	public function __construct() 
	{
		//$this->middleware("CheckUserSession");
		date_default_timezone_set('Asia/Dhaka');
	}
	
	public function index()
    {        	
		$login_emp_id = Session::get('emp_id');
		$user_type 	= Session::get('user_type');
		$data['transfer_info'] = DB::table('tbl_br_transfer as bt')							
							->leftJoin('tbl_emp_basic_info as e', 'bt.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_branch as b', 'bt.br_code', '=', 'b.br_code')
							->leftJoin('tbl_designation as d', 'bt.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_edms_document as edm', function($join){
								$join->on('bt.emp_id','=','edm.emp_id')
								->on('bt.br_join_date','=','edm.effect_date')
								->where('edm.is_cancel', '=', 0)
								->where('edm.subcat_id', '=', 59)
								->where('edm.category_id', '=', 20);
							})
							->where(function($query) use ($user_type, $login_emp_id) {
								if($user_type == 3 || $user_type == 4) {
									$query->where('bt.created_by', '=', $login_emp_id);
								}
							})
							->orderBy('bt.status', 'ASC')
							->orderBy('bt.br_join_date', 'DESC')
							->select('bt.id','bt.emp_id','bt.br_join_date','bt.status','e.emp_name_eng','d.designation_name','b.branch_name','edm.document_name')
							->get();
		return view('admin.pages.br_transfer.br_transfer_list',$data);			
    }

    public function BrTransferCreate()
    {
		$data = array();
		$data['id'] 		= '';
		$data['emp_type'] 	= '';		
		$data['emp_id'] 	= ''; 		
		$data['value_id']   = '';   

		$data['button_text'] = 'Save';

		$data['all_branch'] 	 = DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] = DB::table('tbl_designation')->where('status',1)->get();
		return view('admin.pages.br_transfer.br_transfer_form',$data);	

    }
	
	public function BrTransferEmp(Request $request)
    {
        $data = array();
		$data['Heading'] = $data['title'] = 'Branch Transfer';
		$data['emp_type'] 	= $emp_type = $request->input('emp_type');
		$data['emp_id'] 	= $emp_id 	= $request->input('emp_id');
		$data['form_date'] 	= $form_date = date('Y-m-d');
		$data['action'] 	= '/br_transfer';
		$data['method'] 	= 'post';
		$data['method_field'] 	= '';
		$data['button_text'] = 'Save';
		$data['br_join_date'] = '';
		$data['br_handover_date'] = '';
		
		$user_type 	= Session::get('user_type');
		$branch_code = Session::get('branch_code');
		$area_code = Session::get('area_code');
		$zone_code = Session::get('zone_code');
		
		if ($emp_type == 2 || $emp_type == 3 || $emp_type == 4) {
			$data['nonid_emp_status'] = DB::table('tbl_emp_non_id as en')
							->leftjoin('tbl_nonid_official_info as noi',function($join){
								$join->on("en.emp_id","=","noi.emp_id")
									->where('noi.joining_date',DB::raw("(SELECT 
																  max(joining_date)
																  FROM tbl_nonid_official_info 
																   where en.emp_id = emp_id
																  )") 		 
											); 
										})
								->leftjoin('tbl_nonid_salary as nos',function($join){
								$join->on("en.emp_id","=","nos.emp_id")
									->where('nos.effect_date',DB::raw("(SELECT 
																  max(effect_date)
																  FROM tbl_nonid_salary 
																   where en.emp_id = emp_id
																  )") 		 
											); 
										})
							->leftJoin('tbl_designation as d', 'noi.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'noi.br_code', '=', 'b.br_code')
							->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
							->leftJoin('tbl_emp_non_id_cancel as nc', 'en.emp_id', '=', 'nc.emp_id')

							->where('en.emp_type_code', '=', $emp_type)
							->where('en.sacmo_id', '=', $emp_id)
							->select('en.*','noi.next_renew_date','noi.br_join_date','noi.c_end_date','noi.end_type','nos.gross_salary','nc.cancel_date','nc.cancel_by','d.designation_name','b.branch_name','a.area_name')
							->first();
		} else {
			$max_sarok = DB::table('tbl_master_tra as m')
					->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
					->where('m.emp_id', '=', $data['emp_id'])
					->Where(function($query) use ($form_date) {
									$query->whereNull('r.emp_id');
									$query->orWhere('r.effect_date', '>', $form_date);								
								})
					->where('m.letter_date', '=', function($query) use ($emp_id,$form_date)
						{
							$query->select(DB::raw('max(letter_date)'))
								  ->from('tbl_master_tra')
								  ->where('emp_id',$emp_id)
								  ->where('br_join_date', '<=', $form_date);
						})
					->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
					->groupBy('m.emp_id')
					->first();
			//print_r ($max_sarok); exit;
			if(!empty($max_sarok)) {
				$all_result = DB::table('tbl_master_tra as m')
								->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
								->leftJoin('tbl_emp_photo as ep', 'e.emp_id', '=', 'ep.emp_id')
								->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
								->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
								->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
								->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
								->leftJoin('tbl_zone as z', 'a.zone_code', '=', 'z.zone_code')
								->leftJoin('tbl_appointment_info as ap', 'm.emp_id', '=', 'ap.emp_id')
								->leftJoin('tbl_branch as br', 'ap.joining_branch', '=', 'br.br_code')
								->where('m.sarok_no', '=', $max_sarok->sarok_no)
								->select('e.emp_id','e.emp_name_eng','e.org_join_date','m.br_join_date','m.designation_code','m.br_code','m.grade_code','m.grade_step','m.basic_salary','m.salary_br_code','m.next_increment_date','m.effect_date','m.grade_effect_date','m.is_permanent','m.report_to','ep.emp_photo','d.designation_name','d.designation_bangla','br.branch_name as org_branch_name','b.branch_name','b.br_name_bangla','g.grade_name','a.area_code','a.area_name','a.area_name_bn','z.zone_code','z.zone_name','z.zone_name_bn')
								->first();
				//print_r ($all_result);
				if($user_type == 4) {
					if(($area_code == $all_result->area_code) && ($all_result->designation_code == 11 || $all_result->designation_code == 16 || $all_result->designation_code == 170 || $all_result->designation_code == 192 || $all_result->designation_code == 75)) {
						$data['all_result'] = $all_result;
						$data['value_id'] = 1;
					} else {
						$data['all_result'] = array();
						$data['value_id'] = 2;
					}
				} else if ($user_type == 3) {
					if(($zone_code == $all_result->zone_code) && ($all_result->designation_code == 11 || $all_result->designation_code == 16 || $all_result->designation_code == 170 || $all_result->designation_code == 192 || $all_result->designation_code == 24 || $all_result->designation_code == 97 || $all_result->designation_code == 215 || $all_result->designation_code == 75)) {
						$data['all_result'] = $all_result;
						$data['value_id'] = 1;
					} else {
						$data['all_result'] = array();
						$data['value_id'] = 2;
					}
				}
			} else {
				$data['value_id'] = 3;
			}
		}

		if($user_type == 4) {
			$data['all_branch'] = DB::table('tbl_branch as b')						
									->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
									->leftJoin('tbl_branch as b1', 'a.area_code', '=', 'b1.area_code')
									->where('b.br_code', '=', $branch_code)
									->select('b1.area_code','b1.br_code','b1.branch_name')
									->get(); 
		} else if($user_type == 3) {
			$data['result_area'] = DB::table('tbl_branch as b')						
									->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
									->leftJoin('tbl_zone as z', 'a.zone_code', '=', 'z.zone_code')
									->leftJoin('tbl_area as a1', 'z.zone_code', '=', 'a1.zone_code')
									->where('b.br_code', '=', $branch_code)
									->select('a1.zone_code','a1.area_code','a1.area_name')
									->get(); 
		//print_r($data['result_area']);
			foreach ($data['result_area'] as $result_area) {
				$all_branch = DB::table('tbl_branch')
									->where('area_code', '=', $result_area->area_code)
									->select('area_code','br_code','branch_name')
									->get(); 
			//print_r($all_branch);
			foreach($all_branch as $branch) {
				if($result_area->area_code == $branch->area_code)
					$data['all_branch'][] = array(
							'area_code' => $branch->area_code,
							'br_code'      => $branch->br_code,
							'branch_name'      => $branch->branch_name
						);
				}
			}
		}
		
		$data['results'] = DB::table('tbl_transfer as tr')
						->leftjoin('tbl_branch as br', 'tr.br_code', '=', 'br.br_code')
						->select('tr.id','tr.br_joined_date','br.branch_name')
						->where('tr.emp_id',$emp_id) 
						->where('tr.br_joined_date', '<=', $form_date)
						->orderBy('tr.br_joined_date', 'desc')
						->get();
						
		return view('admin.pages.br_transfer.br_transfer_form',$data);
    }
	
	public function SelectBranch($area_code)
    {  
		$all_branch = DB::table('tbl_branch')
					  ->select('*')
					  ->where('area_code',$area_code) 
                      ->get();
		echo "<option value=''>--Select--</option>";
		foreach($all_branch as $branch){
			echo "<option value='$branch->br_code'>$branch->branch_name</option>";
		}
    }

	public function store(Request $request)
    {
		$post_data = request()->except(['_token','_method','pre_br_join_date']);
		$post_data['letter_date'] = date('Y-m-d');
		$post_data['salary_br_code'] = $request->input('br_code');				
		$pre_br_join_date = $request->input('pre_br_join_date');				
		
		$post_data['login_emp_id'] = Session::get('emp_id');
		$post_data['login_emp_name'] = Session::get('admin_name');
		$post_data['login_emp_user_type'] = Session::get('user_type');
		$post_data['login_br_code'] = Session::get('branch_code');
		$area_code = Session::get('area_code');
		
		$post_data['area_code'] = ($post_data['login_emp_user_type'] ==3) ? $post_data['area_code'] : $area_code;
		$post_data['created_by']	= Session::get('emp_id');
		//print_r ($post_data); exit;
		if(!($pre_br_join_date == $post_data['br_join_date'] && $post_data['pre_br_code'] == $post_data['br_code'])) {
			DB::table('tbl_br_transfer')->insert($post_data);
			Session::put('message','Data Saved Successfully');
			return Redirect::to('/br_transfer');
		} else {
			Session::put('message','Error: This Transfer information aleady insert !');
			return Redirect::to('/br_transfer_emp');		
		}			

    }	

    public function BrTransferEdit($emp_id,$id)
    {
		//UPDATE = 3;
		/* $action_id = 3;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		} */
		$data = array();
		$data['emp_id'] 	= $emp_id;
		$data['form_date'] 	= $form_date = date('Y-m-d');
		$data['emp_type'] 	= '';
		$data['action'] 	= '/br_transfer_edit/'.$emp_id.'/'.$id;
		$data['button_text'] = 'Update';
		
		$user_type 	= Session::get('user_type');
		$branch_code = Session::get('branch_code');
		
		$max_sarok = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $emp_id)
					->where('m.letter_date', '=', function($query) use ($emp_id,$form_date)
						{
							$query->select(DB::raw('max(letter_date)'))
								  ->from('tbl_master_tra')
								  ->where('emp_id',$emp_id)
								  ->where('br_join_date', '<=', $form_date);
						})
					->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
			//echo $max_sarok->sarok_no;exit;

			$data['all_result'] = DB::table('tbl_master_tra as m')
								->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
								->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
								->leftJoin('tbl_emp_photo as ep', 'e.emp_id', '=', 'ep.emp_id')
								->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
								->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
								->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
								->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
								->leftJoin('tbl_zone as z', 'a.zone_code', '=', 'z.zone_code')
								->leftJoin('tbl_appointment_info as ap', 'm.emp_id', '=', 'ap.emp_id')
								->leftJoin('tbl_branch as br', 'ap.joining_branch', '=', 'br.br_code')
								->where('m.sarok_no', '=', $max_sarok->sarok_no)
								->select('e.emp_id','e.emp_name_eng','e.org_join_date','r.effect_date as re_effect_date','m.br_join_date','m.next_increment_date','m.effect_date','m.designation_code','m.br_code','m.grade_code','m.grade_effect_date','m.grade_step','m.department_code','m.report_to','m.is_permanent','m.basic_salary','m.salary_br_code','ep.emp_photo','d.designation_name','d.designation_bangla','br.branch_name as org_branch_name','b.branch_name','b.br_name_bangla','g.grade_name','a.area_name','a.area_name_bn','z.zone_name','z.zone_name_bn')
								->first();
			//print_r ($data['all_result']);
			
		$transfer_info = DB::table('tbl_br_transfer as bt')							
							->where('id', $id)
							->select('*')
							->first();
		
		if($user_type == 3) {
			$data['result_area'] = DB::table('tbl_branch as b')						
								->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
								->leftJoin('tbl_zone as z', 'a.zone_code', '=', 'z.zone_code')
								->leftJoin('tbl_area as a1', 'z.zone_code', '=', 'a1.zone_code')
								->where('b.br_code', '=', $branch_code)
								->select('a1.zone_code','a1.area_code','a1.area_name')
								->get();									
		}
		
		$data['all_branch'] = DB::table('tbl_branch')
								->where('area_code', '=', $transfer_info->area_code)
								->select('area_code','br_code','branch_name')
								->get(); 
		
		$data['br_code'] = $transfer_info->br_code;
		$data['br_join_date'] = $transfer_info->br_join_date;
		$data['br_handover_date'] = $transfer_info->br_handover_date;
		$data['tr_purpose'] = $transfer_info->tr_purpose;
		$data['comments'] = $transfer_info->comments;
		$data['area_code'] = $transfer_info->area_code;
		
		$data['results'] = DB::table('tbl_transfer as tr')
						->leftjoin('tbl_branch as br', 'tr.br_code', '=', 'br.br_code')
						->select('tr.id','tr.br_joined_date','br.branch_name')
						->where('tr.emp_id',$emp_id) 
						->where('tr.br_joined_date', '<=', $form_date)
						->orderBy('tr.br_joined_date', 'desc')
						->get();

		return view('admin.pages.br_transfer.br_transfer_edit_form',$data);	
    }
	
	public function BrTransferView($emp_id,$id)
    {
		$data = array();
		$data['id'] 	= $id;
		$data['emp_id'] 	= $emp_id;
		$data['form_date'] 	= $form_date = date('Y-m-d');
		$data['emp_type'] 	= '';
		$data['action'] 	= '';
		$data['button_text'] 	= 'Update';
		$max_sarok = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $emp_id)
					->where('m.letter_date', '=', function($query) use ($emp_id,$form_date)
						{
							$query->select(DB::raw('max(letter_date)'))
								  ->from('tbl_master_tra')
								  ->where('emp_id',$emp_id)
								  ->where('br_join_date', '<=', $form_date);
						})
					->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
			//echo $max_sarok->sarok_no;exit;

			$data['all_result'] = DB::table('tbl_master_tra as m')
								->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
								->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
								->leftJoin('tbl_emp_photo as ep', 'e.emp_id', '=', 'ep.emp_id')
								->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
								->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
								->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
								->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
								->leftJoin('tbl_zone as z', 'a.zone_code', '=', 'z.zone_code')
								->leftJoin('tbl_appointment_info as ap', 'm.emp_id', '=', 'ap.emp_id')
								->leftJoin('tbl_branch as br', 'ap.joining_branch', '=', 'br.br_code')
								->where('m.sarok_no', '=', $max_sarok->sarok_no)
								->select('e.emp_id','e.emp_name_eng','e.org_join_date','r.effect_date as re_effect_date','m.br_join_date','m.next_increment_date','m.effect_date','m.designation_code','m.br_code','m.grade_code','m.grade_effect_date','m.grade_step','m.department_code','m.report_to','m.is_permanent','m.basic_salary','m.salary_br_code','ep.emp_photo','d.designation_name','d.designation_bangla','br.branch_name as org_branch_name','b.branch_name','b.br_name_bangla','g.grade_name','a.area_name','a.area_name_bn','z.zone_name','z.zone_name_bn')
								->first();
			//print_r ($data['all_result']);
			
		$transfer_info = DB::table('tbl_br_transfer as bt')							
							->leftJoin('tbl_branch as b', 'bt.br_code', '=', 'b.br_code')
							->leftJoin('tbl_area as a', 'bt.area_code', '=', 'a.area_code')
							->leftJoin('tbl_zone as z', 'a.zone_code', '=', 'z.zone_code')
							->where('bt.id', $id)
							->select('bt.id','bt.br_code','bt.br_join_date','bt.br_handover_date','bt.tr_purpose','bt.comments','bt.status','bt.login_emp_id','bt.login_emp_name','bt.login_emp_user_type','bt.created_at','b.branch_name','a.area_name','z.zone_code','z.zone_name','z.program_supervisor_id','z.program_supervisor_mail')
							->first();

		$data['br_code'] = $transfer_info->br_code;
		$data['branch_name'] = $transfer_info->branch_name;
		$data['br_join_date'] = $transfer_info->br_join_date;
		$data['br_handover_date'] = $transfer_info->br_handover_date;
		$data['tr_purpose'] = $transfer_info->tr_purpose;
		$data['comments'] = $transfer_info->comments;
		$data['status'] = $transfer_info->status;
		$data['area_name'] = $transfer_info->area_name;
		$data['zone_name'] = $transfer_info->zone_name;
		$data['area_manager_id'] = $transfer_info->login_emp_id;
		$data['area_manager_name'] = $transfer_info->login_emp_name;
		$data['entry_user_type'] = $transfer_info->login_emp_user_type;
		$data['created_at'] = $transfer_info->created_at;
		$data['program_supervisor_mail'] = $transfer_info->program_supervisor_mail;
		
		$data['results'] = DB::table('tbl_transfer as tr')
						->leftjoin('tbl_branch as br', 'tr.br_code', '=', 'br.br_code')
						->select('tr.id','tr.br_joined_date','br.branch_name')
						->where('tr.emp_id',$emp_id) 
						->where('tr.br_joined_date', '<=', $form_date)
						->orderBy('tr.br_joined_date', 'desc')
						->get();
		//
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->get();
		return view('admin.pages.br_transfer.br_transfer_view',$data);	
    }
	
	public function BrTransferApprove($id,$emp_id)
    {
				
		$data = array();
		$data['id'] 	= $id;
		$data['emp_id'] = $emp_id;
			
		$sarok_id = DB::table('tbl_sarok_no')->max('sarok_no');
		
		$transfer_info = DB::table('tbl_br_transfer as bt')
							->leftJoin('tbl_emp_basic_info as e', 'bt.emp_id', '=', 'e.emp_id')
							->leftJoin('tbl_designation as d', 'bt.designation_code', '=', 'd.designation_code')
							->leftJoin('tbl_branch as b', 'bt.br_code', '=', 'b.br_code')
							->leftJoin('tbl_area as a', 'bt.area_code', '=', 'a.area_code')
							->leftJoin('tbl_zone as z', 'a.zone_code', '=', 'z.zone_code')
							->leftJoin('tbl_branch as br', 'bt.pre_br_code', '=', 'br.br_code')
							->where('bt.id', $id)
							->where('bt.emp_id', $emp_id)
							->select('bt.*','e.emp_name_eng','d.designation_name','d.designation_bangla','b.branch_name','b.br_name_bangla','br.br_name_bangla as pre_br_name_bn','br.branch_name as pre_branch_name','a.area_name','a.area_name_bn','z.zone_name','z.zone_name_bn','z.zone_code','z.program_supervisor_id','z.program_supervisor_mail')
							->first();
		//print_r($transfer_info);exit;
		
		/* Pdf Generate Start */
		$pdf_data = array();
		$month =  date("m", strtotime($transfer_info->letter_date));
		$year =  date("Y", strtotime($transfer_info->letter_date));
		$day =  date("d", strtotime($transfer_info->letter_date));
		
		$br_month =  date("m", strtotime($transfer_info->br_join_date));
		$br_year =  date("Y", strtotime($transfer_info->br_join_date));
		$br_day =  date("d", strtotime($transfer_info->br_join_date));
		
		$br_ha_month =  date("m", strtotime($transfer_info->br_handover_date));
		$br_ha_year =  date("Y", strtotime($transfer_info->br_handover_date));
		$br_ha_day =  date("d", strtotime($transfer_info->br_handover_date));
		
		$months = array('01'=>'জানুয়ারি','02'=>'ফেব্রয়ারি','03'=>'মার্চ','04'=>'এপ্রিল','05'=>'মে','06'=>'জুন','07'=>'জুলাই','08'=>'আগস্ট','09'=>'সেপ্টেম্বর','10'=>'অক্টোবর','11'=>'নভেম্বর','12'=>'ডিসেম্বর');
		
		$month_bangla = $months[$month];		
		$year_bangla = $this->getEnglishToBangla($year);
		$day_bangla = $this->getEnglishToBangla($day);
		$data['date_bangla'] = $month_bangla.' '.$day_bangla.', '.$year_bangla;
			
		$br_day_bangla = $this->getEnglishToBangla($br_day);
		$br_month_bangla = $this->getEnglishToBangla($br_month);
		$br_year_bangla = $this->getEnglishToBangla($br_year);
		$data['br_date_bangla'] = $br_day_bangla.'/'.$br_month_bangla.'/'.$br_year_bangla;
		
		$br_ha_day_bangla = $this->getEnglishToBangla($br_ha_day);
		$br_ha_month_bangla = $this->getEnglishToBangla($br_ha_month);
		$br_ha_year_bangla = $this->getEnglishToBangla($br_ha_year);
		$data['br_ha_date_bangla'] = $br_ha_day_bangla.'/'.$br_ha_month_bangla.'/'.$br_ha_year_bangla;
		$data['id_bangla'] = $this->getEnglishToBangla($transfer_info->emp_id);
		
		$data['emp_name_eng'] = $transfer_info->emp_name_eng;
		$data['designation_bangla'] = $transfer_info->designation_bangla;
		$data['br_name_bangla'] = $transfer_info->br_name_bangla;
		$data['pre_br_name_bn'] = $transfer_info->pre_br_name_bn;
		$data['area_name_bn'] = $transfer_info->area_name_bn;
		$data['zone_name_bn'] = $transfer_info->zone_name_bn;
		
		$data['login_emp_id'] = $this->getEnglishToBangla($transfer_info->login_emp_id);
		$data['login_emp_name'] = $transfer_info->login_emp_name;
		$data['login_emp_user_type'] = $transfer_info->login_emp_user_type;
		$login_br_code = $transfer_info->login_br_code;
		$data['login_br_ar_zo'] = DB::table('tbl_branch as b')						
									->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
									->leftJoin('tbl_zone as z', 'a.zone_code', '=', 'z.zone_code')
									->where('b.br_code', '=', $login_br_code)
									->select('b.branch_name','b.br_name_bangla','a.area_code','a.area_name','a.area_name_bn','z.zone_name','z.zone_name_bn')
									->first();
		/* Pdf Generate */
		$pdf = PDF::loadView('admin.document.br_transfer_view_pdf',$data,[],['format' => 'A4']);
		$image_full_name = $emp_id.'_20_59_'.$transfer_info->br_join_date.".pdf";
		$pdf->save("attachments/attach_ment_tran/".$image_full_name);
		
		/* mail start */
		/* $mail_data = array();
		$mail_data['mail_to'] 				= $transfer_info->program_supervisor_mail;
		$mail_data['mail_subject'] 			= $emp_id.' Transfer Letter'; 
		$mail_data['mail_body'] 			= 'Please see the attchment.';
		$mail_data['attachment'] 			= $image_full_name;; */
		//\Mail::send(new BookingMail($mail_data));
		//print_r($mail_data);
		/* mail end */
		$emp_id 						= $emp_id;
		$str 							= $transfer_info->emp_name_eng;
		$emp_name_eng 					= str_replace(' ', '-', $str);
		$supervisor_email 				= $transfer_info->program_supervisor_mail;
		$branchname 					= $transfer_info->branch_name;
		$branch_name 					= str_replace(' ', '-', $branchname);
		$pre_branchname 				= $transfer_info->pre_branch_name;
		$pre_branch_name 				= str_replace(' ', '-', $pre_branchname);
		$branch_join_date 				= $transfer_info->br_join_date;
		$file = file_get_contents('http://202.4.106.3/cdiphr_old/transfer_notification/'.$emp_id.'/'.$supervisor_email.'/'.$emp_name_eng.'/'.$branch_name.'/'.$branch_join_date.'/'.$pre_branch_name);
		
		
		
		
		
		$edms['subcat_id']			= 59;
		$edms['category_id']		= 20;
		$edms['emp_id']				= $emp_id;
		$edms['emp_type']			= 1;
		$edms['document_name']		= $image_full_name;
		$edms['effect_date']		= $transfer_info->br_join_date;
		$edms['user_id']			= Session::get('admin_id'); 
		$edms['status']				= 1;
		//DB::table('tbl_edms_document')->insert($edms);
		/* Pdf Generate */
		/* Pdf Generate End */
		
		/* tbl_transfer */
		$tdata['sarok_no'] 	= $sarok_id+1;
		$tdata['letter_date'] = $transfer_info->letter_date;
		$tdata['emp_id'] = $transfer_info->emp_id;
		$tdata['designation_code'] = $transfer_info->designation_code;
		$tdata['department_code'] = 3;
		$tdata['br_code'] = $transfer_info->br_code;
		$tdata['br_joined_date'] = $transfer_info->br_join_date;
		$tdata['effect_date'] = $transfer_info->effect_date;
		$tdata['grade_code'] = $transfer_info->grade_code;
		$tdata['grade_step'] = $transfer_info->grade_step;
		$tdata['comments'] = $transfer_info->comments;
		$tdata['next_increment_date'] = $transfer_info->next_increment_date;
		$tdata['report_to'] = empty($transfer_info->report_to) ? 'Branch Manager' : $transfer_info->report_to;
		$tdata['tran_type_no'] = 8;
		$tdata['grade_effect_date'] = $transfer_info->grade_effect_date;
		$tdata['status'] = 1;
		$tdata['created_by'] = Session::get('admin_id');
		/* tbl_sarok_no */
		$sdata['sarok_no'] 	= $tdata['sarok_no'];
		$sdata['letter_date'] = $transfer_info->letter_date;
		$sdata['emp_id'] = $transfer_info->emp_id;
		$sdata['transection_type'] = 8;
		$sdata['created_by'] = Session::get('admin_id');
		/* tbl_master_tra */
		$mdata['sarok_no'] 	= $tdata['sarok_no'];
		$mdata['letter_date'] = $transfer_info->letter_date;
		$mdata['emp_id'] = $transfer_info->emp_id;
		$mdata['designation_code'] = $transfer_info->designation_code;
		$mdata['department_code'] = 3;
		$mdata['br_code'] = $transfer_info->br_code;
		$mdata['salary_br_code'] = $transfer_info->salary_br_code;
		$mdata['br_join_date'] = $transfer_info->br_join_date;
		$mdata['grade_code'] = $transfer_info->grade_code;
		$mdata['grade_step'] = $transfer_info->grade_step;
		$mdata['basic_salary'] = $transfer_info->basic_salary;
		$mdata['next_increment_date'] = $transfer_info->next_increment_date;
		$mdata['effect_date'] = $transfer_info->effect_date;
		$mdata['tran_type_no'] = 8;
		$mdata['is_permanent'] = $transfer_info->is_permanent;
		$mdata['grade_effect_date'] = $transfer_info->grade_effect_date;
		$mdata['report_to'] = $transfer_info->report_to;
		$mdata['status'] = 1;
		$mdata['created_by'] = Session::get('admin_id');
		//print_r($mdata);exit;
		//DB::table('tbl_transfer')->insertGetId($tdata);
		DB::beginTransaction();
		try {				
			//Insert into Transfer Table
			DB::table('tbl_transfer')->insertGetId($tdata);
			//Insert into Sarok Table
			DB::table('tbl_sarok_no')->insert($sdata);
			//Insert into Master Table
			DB::table('tbl_master_tra')->insert($mdata);
			//Insert into Edms Table
			DB::table('tbl_edms_document')->insert($edms);
			//Update into Br.Transfer Table
			DB::table('tbl_br_transfer')->where('id', $id)->update(['status' => 1]);
			//COMMIT DB
			DB::commit();
			//PUSH SUCCESS MESSAGE
			Session::put('message','Data Approved Successfully');
		} catch (\Exception $e) {
			//PUSH FAIL MESSAGE
			Session::put('message','Error: Unable to Save Data');
			//DB ROLLBACK
			DB::rollback();
		}
			
		return response()->json();	
    }
	
	public function BrTransferUpdate(Request $request, $emp_id, $id)
    {
		$post_data = request()->except(['_token','_method']);
		$post_data['salary_br_code'] = $request->input('br_code');
		$area_code = Session::get('area_code');
		$login_emp_user_type = Session::get('user_type');
		
		$post_data['area_code'] = ($login_emp_user_type ==3) ? $post_data['area_code'] : $area_code;
							
		$post_data['updated_by'] = Session::get('emp_id');
		$post_data['updated_at'] = date("Y-m-d H:i:s");
		//print_r ($post_data); exit;
		DB::table('tbl_br_transfer')->where('id', $id)->update($post_data);

		Session::put('message','Data Saved Successfully');
		return Redirect::to('/br_transfer');
    }
	
	public function getEnglishToBangla($data){
		$english = array(1,2,3,4,5,6,7,8,9,0,'-','%','B');
		$bangla = array('১','২','৩','৪','৫','৬','৭','৮','৯','০','-','%','বি');
		$converted = str_replace($english, $bangla, $data);
		return $converted;
	}
	
	private function cheeck_action_permission($action_id)
	{
		$access_label 	= Session::get('admin_access_label');		
		$nav_name 		=  '/'.request()->segment(1);
		$nav_info		= DB::table('tbl_navbar')->where('nav_action',$nav_name)->first();	
		$nav_id 		= $nav_info->nav_id;
		$permission    	= DB::table('tbl_user_permissions')
							->where('user_role_id',$access_label)
							->where('nav_id',$nav_id)
							->where('status',1)
							->first();
		if($permission)
		{
			if(in_array($action_id,$p = explode(",", $permission->permission)))
			{
				return true;
			}
			else
			{
				return false;
			}
		}	
		else
		{
			return false;
		}
	}
	

   
}
