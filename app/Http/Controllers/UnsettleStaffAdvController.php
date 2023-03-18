<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class UnsettleStaffAdvController extends Controller
{
	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['Heading'] = $data['title'] = 'Unsettle Staff Entry';
		$data['emp_type']	= '';	
		$data['emp_id']		= '';	
		$data['entry_date']	= date('Y-m-d');
		$data['method_field']	= '';
		
		$data['all_branch'] = DB::table('tbl_branch')->where('status',1)->get();
		$data['all_emp_type'] = DB::table('tbl_emp_type')->where('id',1)->get();
		return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_form',$data);			
    }
	
	public function GetEmployeeInfo(Request $request) {
		$data = array();
		$data['Heading'] = $data['title'] = 'Unsettle Staff Entry';
		$data['emp_type'] 	= $emp_type = $request->input('emp_type');
		$data['emp_id'] 	= $emp_id 	= $request->input('emp_id');
		$data['entry_date'] 	= $entry_date = $request->input('entry_date');
		$data['method_field']	= '';
		$data['all_branch'] = DB::table('tbl_branch')->where('status',1)->get();
		$data['all_emp_type'] = DB::table('tbl_emp_type')->where('id',1)->get();
		if(!empty($emp_id)) {
			$data['resultinfo'] = DB::table('tbl_unsettle_staff_adv as us')
							->leftJoin('tbl_emp_basic_info as e', function($join)
											{
												$join->on('us.emp_id', '=', 'e.emp_id')
												->where('us.emp_type', '=', 1);

											})
							->leftJoin('tbl_emp_non_id as en', function($join)
											{
												$join->on('us.emp_id', '=', 'en.emp_id')
												->on('us.emp_type', '=', 'en.emp_type_code');

											})				
							->where('us.emp_id', $emp_id)
							->select('us.id','us.emp_id','us.incre_id','us.emp_type','us.entry_date','us.designation_code','us.br_code',DB::raw('sum(us.total_amount) as total_amount'),'us.comments','us.claim_description','us.claim_date','e.emp_name_eng','en.sacmo_id','en.emp_name')
							->groupBy('us.emp_id')
							->first();
			//print_r($data['resultinfo']);
			if(!empty($data['resultinfo'])) {
				$data['result_info'] = DB::table('tbl_unsettle_staff_adv as us')
							->leftJoin('tbl_emp_basic_info as e', function($join)
											{
												$join->on('us.emp_id', '=', 'e.emp_id')
												->where('us.emp_type', '=', 1);

											})
							->leftJoin('tbl_emp_non_id as en', function($join)
											{
												$join->on('us.emp_id', '=', 'en.emp_id')
												->on('us.emp_type', '=', 'en.emp_type_code');

											})				
							//->Leftjoin('tbl_unstle_staff_adv_col as usc', 'us.incre_id', '=', 'usc.incre_id')
							->leftJoin('tbl_unstle_staff_adv_col as usc', function($join){
										$join->on('us.incre_id','=','usc.incre_id')
										->on('us.emp_id','=','usc.emp_id');
							})							
							->Leftjoin('tbl_unstle_staff_adv_tra as ust', 'us.emp_id', '=', 'ust.transfer_from_emp_id')				
							->Leftjoin('tbl_designation as d', 'us.designation_code', '=', 'd.designation_code')				
							->Leftjoin('tbl_branch as b', 'us.br_code', '=', 'b.br_code')				
							->Leftjoin('tbl_branch as b1', 'us.claim_branch', '=', 'b1.br_code')				
							->Leftjoin('tbl_emp_type as et', 'us.emp_type', '=', 'et.id')				
							->where('us.emp_id', $emp_id)
							->select('us.id','us.emp_id','us.emp_type','us.entry_date','us.designation_code','us.br_code','us.comments','us.claim_description','us.claim_date','e.emp_name_eng','en.sacmo_id','en.emp_name',
								DB::raw("(SELECT sum(total_amount) FROM tbl_unsettle_staff_adv
                                WHERE emp_id = $emp_id) as total_amount"),
								DB::raw("(SELECT sum(credit_amt) FROM tbl_unstle_staff_adv_col
                                WHERE emp_id = $emp_id AND pay_status = 1) as credit_amt"),
								DB::raw("(SELECT sum(debit_amt) FROM tbl_unstle_staff_adv_col
                                WHERE emp_id = $emp_id AND pay_status = 1) as debit_amt"),
								DB::raw("(SELECT sum(transfer_amt) FROM tbl_unstle_staff_adv_tra
                                WHERE transfer_from_emp_id = $emp_id) as transfer_amt"),
								DB::raw('min(usc.tran_date) as min_month'),DB::raw('max(usc.tran_date) as max_month'),'d.designation_name','b.branch_name','b1.branch_name as claim_branch_name','et.type_name')
							->first();
				//print_r($data['result_info']); exit;
			} else {
				$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $data['emp_id'])
						->where('m.letter_date', '=', function($query) use ($emp_id,$entry_date)
							{
								$query->select(DB::raw('max(letter_date)'))
									  ->from('tbl_master_tra')
									  ->where('emp_id',$emp_id)
									  ->where('br_join_date', '<=', $entry_date);
							})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('emp_id')
						->first();
				$data['result_info'] = DB::table('tbl_master_tra as m')
									->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
									->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
									->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->select('e.emp_id','e.emp_name_eng','m.br_join_date','m.designation_code','m.br_code','d.designation_name','b.branch_name')
									->first();
			}
			$data['designation_code'] = $data['result_info']->designation_code;
			$data['br_code'] = $data['result_info']->br_code;
			$data['emp_type_name'] = DB::table('tbl_emp_type')->where('id', '=', $emp_type)->select('id','type_name')->first();
		}
				
	return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_form',$data);					
	}
	
	public function UnsettleViewLoad($transaction_type,$emp_id,$incre_id) {
		$data = array();
		$data['all_branch'] 		= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 	= DB::table('tbl_designation')->where('status',1)->get();
		$data['transaction_type']   = $transaction_type;
		if($transaction_type != 5) {
			$data['result_info'] = DB::table('tbl_unsettle_staff_adv as us')
						->leftJoin('tbl_emp_basic_info as e', function($join)
										{
											$join->on('us.emp_id', '=', 'e.emp_id')
											->where('us.emp_type', '=', 1);

										})
						->leftJoin('tbl_emp_non_id as en', function($join)
										{
											$join->on('us.emp_id', '=', 'en.emp_id')
											->on('us.emp_type', '=', 'en.emp_type_code');

										})
						->Leftjoin('tbl_unstle_staff_adv_tra as ust', 'us.emp_id', '=', 'ust.transfer_from_emp_id')
						->Leftjoin('tbl_unstle_staff_adv_col as usc', 'us.emp_id', '=', 'usc.emp_id')				
						->Leftjoin('tbl_designation as d', 'us.designation_code', '=', 'd.designation_code')				
						->Leftjoin('tbl_branch as b', 'us.br_code', '=', 'b.br_code')				
						->Leftjoin('tbl_branch as b1', 'us.claim_branch', '=', 'b1.br_code')				
						->where('us.emp_id', $emp_id)
						->where('us.incre_id', $incre_id)
						->select('us.id','us.emp_id','us.emp_type','us.entry_date','us.designation_code','us.br_code','us.incre_id',
						DB::raw("(SELECT sum(total_amount) FROM tbl_unsettle_staff_adv
                                WHERE emp_id = $emp_id) as total_amount"),
								DB::raw("(SELECT sum(credit_amt) FROM tbl_unstle_staff_adv_col
                                WHERE emp_id = $emp_id AND pay_status = 1) as credit_amt"),
								DB::raw("(SELECT sum(debit_amt) FROM tbl_unstle_staff_adv_col
                                WHERE emp_id = $emp_id AND pay_status = 1) as debit_amt"),
								DB::raw("(SELECT sum(transfer_amt) FROM tbl_unstle_staff_adv_tra
                                WHERE transfer_from_emp_id = $emp_id) as transfer_amt"),
								'us.comments','us.claim_description','us.claim_date','us.claim_branch','e.emp_name_eng','en.sacmo_id','en.emp_name',DB::raw('min(usc.tran_date) as min_month'),DB::raw('max(usc.tran_date) as max_month'),'d.designation_name','b.branch_name','b1.branch_name as claim_branch_name')
						->first();
		} else {
			$data['result_info'] = DB::table('tbl_unsettle_staff_adv as us')
							->leftJoin('tbl_emp_basic_info as e', function($join)
											{
												$join->on('us.emp_id', '=', 'e.emp_id')
												->where('us.emp_type', '=', 1);

											})
							->leftJoin('tbl_emp_non_id as en', function($join)
											{
												$join->on('us.emp_id', '=', 'en.emp_id')
												->on('us.emp_type', '=', 'en.emp_type_code');

											})				
							->Leftjoin('tbl_unstle_staff_adv_col as usc', 'us.emp_id', '=', 'usc.emp_id')				
							->where('us.emp_id', $emp_id)
							->select('us.id','us.emp_id','us.emp_type','us.entry_date','us.designation_code','us.br_code')
							->first();
		}
		if($transaction_type == 1) {
			return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_collect',$data);
		} else if ($transaction_type == 2) {
			return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_payroll',$data);
		} else if ($transaction_type == 3) {
			$data['action'] 		= '/unsettle-transfer-store';
			$data['transfer_data'] = array();
			return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_transfer',$data);
		} else if ($transaction_type == 4) {
			return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_adjustment',$data);
		} else if ($transaction_type == 5) {
			return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_add',$data);
		} else if ($transaction_type == 6) {
			return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_payment',$data);
		} else if ($transaction_type == 7) {
			return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_khudra_jhuki',$data);
		} else if ($transaction_type == 8) {
			return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_resedule',$data);
		}
	} 
	
    public function create()
    {
		$data = array();
		$data['action'] 		= '/unsettle-staff-adv';
		$data['method'] 		= 'post';
		$data['method_field'] 	= '';
		$data['id'] 			= '';
		
		$data['emp_type'] = ''; $data['emp_id'] = ''; $data['entry_date'] = date("Y-m-d"); 
		$data['emp_name'] = ''; $data['br_code'] = ''; $data['designation_code'] = ''; 		
		$data['claim_description'] = ''; $data['claim_date'] = ''; $data['claim_branch'] = '';
		$data['total_amount'] = ''; $data['comments'] = '';
		$data['nonid_emp_id'] 	= ''; 
		//
		$data['Heading'] 	 = 'Add Assign';
		$data['button_text'] = 'Save';
		//
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->get();
		
		return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_form',$data);	

    }
	
	public function GetEmpInfo($emp_id,$emp_type)
	{
		$data = array();
		if($emp_type != 1) {
			$nonid_emp = DB::table('tbl_emp_non_id as en')
							->leftjoin('tbl_nonid_official_info as noi',function($join){
								$join->on("en.emp_id","=","noi.emp_id")
									->where('noi.joining_date',DB::raw("(SELECT 
																  max(joining_date)
																  FROM tbl_nonid_official_info 
																   where en.emp_id = emp_id
																  )") 		 
											); 
										})

							->where('en.emp_type_code', '=', $emp_type)
							->where('en.sacmo_id', '=', $emp_id)
							->select('en.emp_id','en.sacmo_id','en.emp_name','noi.designation_code','noi.br_code')
							->first();
			if($nonid_emp !=NULL) {

				$data['emp_id'] 				= $nonid_emp->emp_id;
				$data['emp_name'] 				= $nonid_emp->emp_name;
				$data['designation_code'] 		= $nonid_emp->designation_code;
				$data['br_code'] 				= $nonid_emp->br_code;
				$data['error'] 					= '';
			
			} else {
				$data['error'] 					= 1;
			}
		} else {
			$max_id = DB::table('tbl_master_tra')
						->where('emp_id', $emp_id)
						->max('sarok_no');	
			//echo $max_id;		
			if($max_id !=NULL) {
				$employee_info = DB::table('tbl_master_tra as m')
							->Leftjoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
							->where('m.sarok_no', $max_id)
							->select('m.emp_id','m.designation_code','m.br_code','e.emp_name_eng') 
							->first();	

				$data['emp_id'] 				= $emp_id;
				$data['emp_name'] 				= $employee_info->emp_name_eng;
				$data['designation_code'] 		= $employee_info->designation_code;
				$data['br_code'] 				= $employee_info->br_code;
				$data['error'] 					= '';
			
			} else {
				$data['error'] 					= 1;
			}
		}
		return $data;
	}

	public function store(Request $request)
    {
		$data = request()->except(['_token','_method']);
		//print_r ($data); exit;		
		$increid = DB::table('tbl_unsettle_staff_adv')->where('emp_id', '=', $data['emp_id'])->select('incre_id')->first();
		if($increid) {
			$data['incre_id'] = $increid->incre_id;
		} else {
			$incre_id = DB::table('tbl_unsettle_staff_adv')->max('incre_id');
			$data['incre_id'] = $incre_id+1;
		}
		//print_r($data['incre_id']); exit;
		$data['transaction_type']   = 5;
		$data['created_by'] = Session::get('admin_id');
		DB::table('tbl_unsettle_staff_adv')->insert($data);
		//print_r ($data); exit;
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/unsettle-staff-adv');			

    }
	
	public function UnsettleAddClaim(Request $request)
    {
		//$data = request()->except(['_token','_method']);
		//print_r ($data); exit;
		$claim_des_name = $request->input('claim_des_name');		
		//echo $claim_des_name; exit;
		$data['created_by'] = Session::get('admin_id');
		//DB::table('tbl_unsettle_staff_adv')->insert($data);
		//print_r ($data); exit;
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/unsettle-staff-adv');			

    }
	
	public function UnsettleView($emp_id,$incre_id)
    {
        $data = array();
		$data['result_info'] = DB::table('tbl_unsettle_staff_adv as us')
						->leftJoin('tbl_emp_basic_info as e', function($join)
										{
											$join->on('us.emp_id', '=', 'e.emp_id')
											->where('us.emp_type', '=', 1);

										})
						->leftJoin('tbl_emp_non_id as en', function($join)
										{
											$join->on('us.emp_id', '=', 'en.emp_id')
											->on('us.emp_type', '=', 'en.emp_type_code');

										})				
						->Leftjoin('tbl_unstle_staff_adv_col as usc', 'us.emp_id', '=', 'usc.emp_id')				
						->Leftjoin('tbl_designation as d', 'us.designation_code', '=', 'd.designation_code')				
						->Leftjoin('tbl_branch as b', 'us.br_code', '=', 'b.br_code')				
						->Leftjoin('tbl_branch as b1', 'us.claim_branch', '=', 'b1.br_code')				
						->where('us.emp_id', $emp_id)
						->where('us.incre_id', $incre_id)
						->select('us.id','us.emp_id','us.emp_type','us.entry_date','us.designation_code','us.br_code','us.total_amount','us.comments','us.claim_description','us.claim_date','e.emp_name_eng','en.sacmo_id','en.emp_name',DB::raw('min(usc.tran_date) as min_month'),DB::raw('max(usc.tran_date) as max_month'),'d.designation_name','b.branch_name','b1.branch_name as claim_branch_name')
						->first();
		$data['unsettle_staff_view'] = DB::table('tbl_unsettle_staff_adv')
                                    ->where('emp_id',$emp_id)
                                    ->where('incre_id',$incre_id)
									->get();
		
		//
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->get();
		return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_view',$data);
    }
	
	public function UnsettleCollection($emp_id,$incre_id)
    {
        $data = array();
		$data['result_info'] = DB::table('tbl_unsettle_staff_adv as us')
						->leftJoin('tbl_emp_basic_info as e', function($join)
										{
											$join->on('us.emp_id', '=', 'e.emp_id')
											->where('us.emp_type', '=', 1);

										})
						->leftJoin('tbl_emp_non_id as en', function($join)
										{
											$join->on('us.emp_id', '=', 'en.emp_id')
											->on('us.emp_type', '=', 'en.emp_type_code');

										})				
						->Leftjoin('tbl_unstle_staff_adv_col as usc', 'us.emp_id', '=', 'usc.emp_id')				
						->Leftjoin('tbl_designation as d', 'us.designation_code', '=', 'd.designation_code')				
						->Leftjoin('tbl_branch as b', 'us.br_code', '=', 'b.br_code')				
						->Leftjoin('tbl_branch as b1', 'us.claim_branch', '=', 'b1.br_code')				
						->where('us.emp_id', $emp_id)
						->where('us.incre_id', $incre_id)
						->select('us.id','us.emp_id','us.emp_type','us.entry_date','us.designation_code','us.br_code','us.total_amount','us.comments','us.claim_description','us.claim_date','e.emp_name_eng','en.sacmo_id','en.emp_name',DB::raw('min(usc.tran_date) as min_month'),DB::raw('max(usc.tran_date) as max_month'),'d.designation_name','b.branch_name','b1.branch_name as claim_branch_name')
						->first();
		//print_r($data['result_info']);
		$data['action'] 		= '/unsettle-staff-adv-col';
		$data['method'] 		= 'post';
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->get();
		return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_collection',$data);
    }
	
	public function UnsettleCollectionStore(Request $request)
    {
		$data = request()->except(['_token','_method','tran_date','collection_type','debit_credit','amount','schdule_id']);
		$tran_date = $request->input('tran_date');
		$collection_type = $request->input('collection_type');
		$debit_credit = $request->input('debit_credit');
		$amount = $request->input('amount');
		$schdule_id = $request->input('schdule_id');
		//print_r ($data); exit;		
		$incre_id = DB::table('tbl_unstle_staff_adv_col')->max('incre_id');
		//$data['incre_id'] = $incre_id+1;
		if($data['transaction_type'] == 2){
			if($schdule_id == 1) {
				$no_of_month = intval($data['total_amount']/$data['credit_amt']);
				$month_amt = $data['credit_amt'] * $no_of_month;
				$last_month_amt = $data['total_amount'] - $month_amt;
				//echo $last_month_amt; exit;
				for($i = 1; $i <= $no_of_month; $i++) {
					$month = $i-1;
					if($i == $no_of_month) { 
					$data['credit_amt'] = $data['credit_amt'] + $last_month_amt;
					}
					$data['tran_date'] = date("Y-m-01", strtotime($tran_date . " $month month"));
					//$data['tran_date'] = $tran_date;
					$data['collection_type'] = 1;
					$data['created_by'] = Session::get('admin_id');
					DB::table('tbl_unstle_staff_adv_col')->insert($data);
					DB::table('tbl_unsettle_staff_adv_history')->insert($data);
					//print_r ($data['tran_date']);
					//echo '<br>';
				}
			} else if ($schdule_id == 2) {
				$data['tran_date'] = $tran_date;
				$data['collection_type'] = $collection_type;
				DB::table('tbl_unstle_staff_adv_col')->insert($data);
			}
			//exit;
		} else if ($data['transaction_type'] == 4) {
			$data['tran_date'] = $tran_date;
			if($debit_credit == 1) {
				$data['debit_amt'] = $amount;
			} else if ($debit_credit == 2) {
				$data['credit_amt'] = $amount;
			}
			$data['collection_type'] = $collection_type;
			$data['pay_status'] = 1;
			$data['created_by'] = Session::get('admin_id');
			DB::table('tbl_unstle_staff_adv_col')->insert($data);
		} else {
			$data['tran_date'] = $tran_date;
			$data['collection_type'] = !empty($collection_type) ? $collection_type : 0;
			!empty($amount) ? $data['debit_amt'] = $amount : 0;
			$data['pay_status'] = 1;
			$data['created_by'] = Session::get('admin_id');
			DB::table('tbl_unstle_staff_adv_col')->insert($data);
		}
		//print_r ($data); exit;
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/unsettle-staff-adv');			

    }
	
	public function UnsettleCollectionPayroll()
    {
		$data = array();		
		$data['emp_type'] = ''; $data['emp_id'] = '';
		$data['button_text'] = 'Save';
		//
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->get();
		
		return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_payroll',$data);	

    }
	
	public function GetUnsEmpInfo(Request $request)
	{
		$data = array();
		$data['emp_type'] 	= $emp_type = $request->input('emp_type');
		$data['emp_id'] 	= $emp_id = $request->input('emp_id');
		//echo $emp_type; exit;
		if($emp_type ==1) {
			$data['result_info'] = DB::table('tbl_unsettle_staff_adv as us')				
						->Leftjoin('tbl_emp_basic_info as e', 'us.emp_id', '=', 'e.emp_id')				
						->Leftjoin('tbl_unstle_staff_adv_col as usc', 'us.emp_id', '=', 'usc.emp_id')				
						->Leftjoin('tbl_designation as d', 'us.designation_code', '=', 'd.designation_code')				
						->Leftjoin('tbl_branch as b', 'us.br_code', '=', 'b.br_code')				
						->Leftjoin('tbl_branch as b1', 'us.claim_branch', '=', 'b1.br_code')				
						->where('us.emp_id', $emp_id)
						->where('us.emp_type', $emp_type)
						->select('us.id','us.emp_id','us.emp_type','us.entry_date','us.designation_code','us.br_code','us.total_amount','us.comments','us.claim_description','us.claim_date','e.emp_name_eng',DB::raw('min(usc.tran_date) as min_month'),DB::raw('max(usc.tran_date) as max_month'),'d.designation_name','b.branch_name','b1.branch_name as claim_branch_name')
						->first();
		
		} else {
			$data['result_info'] = DB::table('tbl_unsettle_staff_adv as us')				
						->Leftjoin('tbl_emp_non_id as en', 'us.emp_id', '=', 'en.emp_id')				
						->Leftjoin('tbl_unstle_staff_adv_col as usc', 'us.emp_id', '=', 'usc.emp_id')				
						->Leftjoin('tbl_designation as d', 'us.designation_code', '=', 'd.designation_code')				
						->Leftjoin('tbl_branch as b', 'us.br_code', '=', 'b.br_code')				
						->Leftjoin('tbl_branch as b1', 'us.claim_branch', '=', 'b1.br_code')				
						->where('us.emp_id', $emp_id)
						->where('us.emp_type', $emp_type)
						->select('us.id','us.emp_id','us.emp_type','us.entry_date','us.designation_code','us.br_code','us.total_amount','us.comments','us.claim_description','us.claim_date','en.sacmo_id','en.emp_name',DB::raw('min(usc.tran_date) as min_month'),DB::raw('max(usc.tran_date) as max_month'),'d.designation_name','b.branch_name','b1.branch_name as claim_branch_name')
						->first();
		}
		//print_r($data['result_info']);
		return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_payroll',$data);
	}
	
	public function UnsettleTransfer($emp_id,$incre_id)
    {
        $data = array();
		$data['result_info'] = DB::table('tbl_unsettle_staff_adv as us')
						->leftJoin('tbl_emp_basic_info as e', function($join)
										{
											$join->on('us.emp_id', '=', 'e.emp_id')
											->where('us.emp_type', '=', 1);

										})
						->leftJoin('tbl_emp_non_id as en', function($join)
										{
											$join->on('us.emp_id', '=', 'en.emp_id')
											->on('us.emp_type', '=', 'en.emp_type_code');

										})				
						->Leftjoin('tbl_unstle_staff_adv_col as usc', 'us.emp_id', '=', 'usc.emp_id')				
						->Leftjoin('tbl_designation as d', 'us.designation_code', '=', 'd.designation_code')				
						->Leftjoin('tbl_branch as b', 'us.br_code', '=', 'b.br_code')				
						->Leftjoin('tbl_branch as b1', 'us.claim_branch', '=', 'b1.br_code')				
						->where('us.emp_id', $emp_id)
						->where('us.incre_id', $incre_id)
						->select('us.*','e.emp_name_eng','en.sacmo_id','en.emp_name',DB::raw('min(usc.tran_date) as min_month'),DB::raw('max(usc.tran_date) as max_month'),'d.designation_name','b.branch_name','b1.branch_name as claim_branch_name')
						->first();
		//print_r($data['result_info']);
		$data['action'] 		= '/unsettle-transfer-store';
		$data['method'] 		= 'post';
		$data['transfer_data'] = array();
		$data['all_branch'] 		= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 	= DB::table('tbl_designation')->where('status',1)->get();
		return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_transfer',$data);
    }
	
	public function UnsettleTransferStore(Request $request)
    {
		$us_staff_ad_id = $request->us_staff_ad_id;
		$transfer_from_emp_id = $request->transfer_from_emp_id;
		$total_amount = $request->total_amount;
		$claim_description = $request->claim_description;
		$claim_date = $request->claim_date;
		$claim_branch = $request->claim_branch;
		$transaction_type = $request->transaction_type;
		$transfer_data = $request->transfer;
		//$data = request()->except(['_token']);
		//$data['created_by'] 	= Session::get('admin_id');
		//print_r($request->all());
		//print_r ($data); 
		//exit;
		//print_r ($transfer_data); exit;
		if (!empty($transfer_data)) {
			DB::beginTransaction();
			try {
				foreach ($transfer_data as $post_data) {
					$increid = DB::table('tbl_unsettle_staff_adv')->where('emp_id', '=', $post_data['transfer_emp_id'])->select('incre_id')->first();
					if($increid) {
						$usa_data['incre_id'] = $increid->incre_id;
					} else {
						$incre_id = DB::table('tbl_unsettle_staff_adv')->max('incre_id');
						$usa_data['incre_id'] = $incre_id+1;
					}
					$usa_data['emp_id']   	= $post_data['transfer_emp_id'];
					$usa_data['emp_type']   	= 1;
					$usa_data['entry_date']   	= $post_data['entry_date'];
					$usa_data['designation_code']   = $post_data['transfer_emp_desig_id'];
					$usa_data['br_code']   	= $post_data['transfer_emp_br_id'];
					$usa_data['claim_description']   	= $claim_description;
					$usa_data['claim_date']   	= $post_data['entry_date'];
					$usa_data['claim_branch']   	= $claim_branch;
					$usa_data['total_amount']   	= $post_data['transfer_amt'];
					$usa_data['comments']   	= $post_data['transfer_comment'];
					$usa_data['transaction_type']   = 3;
					$usa_data['created_by'] = Session::get('admin_id');
					DB::table('tbl_unsettle_staff_adv')->insert($usa_data);
					
					$tra_data['us_staff_ad_id']   	= $us_staff_ad_id;
					$tra_data['entry_date']   	= $post_data['entry_date'];
					$tra_data['transfer_from_emp_id']   	= $transfer_from_emp_id;
					$tra_data['total_amount']   	= $total_amount;
					$tra_data['transfer_amt']   	= $post_data['transfer_amt'];
					$tra_data['transfer_emp_id']   	= $post_data['transfer_emp_id'];
					$tra_data['transfer_emp_br_id']   	= $post_data['transfer_emp_br_id'];
					$tra_data['transfer_emp_desig_id']   	= $post_data['transfer_emp_desig_id'];
					$tra_data['transfer_comment']   	= $post_data['transfer_comment'];
					$tra_data['transaction_type']   	= $transaction_type;
					$tra_data['created_by'] = Session::get('admin_id');
					//print_r($tra_data); exit;
					DB::table('tbl_unstle_staff_adv_tra')->insert($tra_data);
				}
				DB::commit();
				//PUSH SUCCESS MESSAGE
				Session::put('message','Data Saved Successfully');
			} catch (\Exception $e) {
				//PUSH FAIL MESSAGE
				Session::put('message','Error: Unable to Save Data');
				//DB ROLLBACK
				DB::rollback();
			}
		}
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/unsettle-staff-adv');			

    }
	
	public function UnsettleStatement($emp_id)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Unsettle Statement';
		$data['all_branch'] = DB::table('tbl_branch')->where('status',1)->get();
		$data['all_emp_type'] = DB::table('tbl_emp_type')->get();
		
		$data['result_info'] = DB::table('tbl_unsettle_staff_adv as us')
						->leftJoin('tbl_emp_basic_info as e', function($join)
										{
											$join->on('us.emp_id', '=', 'e.emp_id')
											->where('us.emp_type', '=', 1);

										})
						->leftJoin('tbl_emp_non_id as en', function($join)
										{
											$join->on('us.emp_id', '=', 'en.emp_id')
											->on('us.emp_type', '=', 'en.emp_type_code');

										})				
						->Leftjoin('tbl_designation as d', 'us.designation_code', '=', 'd.designation_code')				
						->Leftjoin('tbl_branch as b', 'us.br_code', '=', 'b.br_code')				
						->Leftjoin('tbl_branch as b1', 'us.claim_branch', '=', 'b1.br_code')				
						->where('us.emp_id', $emp_id)
						->select('us.id','us.emp_id','us.emp_type',
						DB::raw("(SELECT sum(total_amount) FROM tbl_unsettle_staff_adv
                                WHERE emp_id = $emp_id) as total_amount"),
								'us.claim_date','e.emp_name_eng','en.sacmo_id','en.emp_name','d.designation_name','b.branch_name','b1.branch_name as claim_branch_name')
						->orderBy('us.id', 'ASC')
						->first();
						
		$all_result = DB::table('tbl_unsettle_staff_adv as us')
						->leftJoin('tbl_unstle_staff_adv_tra as tra', function($join)
							{
								$join->on('us.emp_id', '=', 'tra.transfer_emp_id')
								->where('us.transaction_type', 3);

							})
						->Leftjoin('tbl_emp_basic_info as e', 'tra.transfer_from_emp_id', '=', 'e.emp_id')
						->where('us.emp_id', $emp_id)
						//->where('us.incre_id', $incre_id)
						->select('us.emp_id','us.claim_date','us.comments','us.total_amount as debit_amt','us.transaction_type','tra.transfer_from_emp_id','e.emp_name_eng as emp_name')
						->get()->toArray();				
		$all_result1 = DB::table('tbl_unstle_staff_adv_col as usc')			
						->where('usc.emp_id', $emp_id)
						->where('usc.pay_status', 1)
						//->where('us.incre_id', $incre_id)
						->select('usc.emp_id as emp_id',DB::raw('sum(usc.debit_amt) as debit_amt'),DB::raw('sum(usc.credit_amt) as credit_amt'),'usc.tran_date as claim_date','usc.comments as comments','usc.transaction_type as transaction_type')
						->groupBy('usc.tran_date')
						->get()->toArray();
		$all_result2 = DB::table('tbl_unstle_staff_adv_tra as tra')			
						->Leftjoin('tbl_emp_basic_info as e', 'tra.transfer_emp_id', '=', 'e.emp_id')
						->where('tra.transfer_from_emp_id', $emp_id)
						//->where('us.incre_id', $incre_id)
						->select('tra.transfer_emp_id as emp_id','tra.transfer_emp_id','e.emp_name_eng','tra.entry_date as claim_date','tra.transfer_amt as credit_amt','tra.transfer_comment as comments','tra.transaction_type as transaction_type')
						->get()->toArray();
		$data['all_result'] = array_merge($all_result,$all_result1,$all_result2);
		//print_r($data['all_result']);//exit;
		
		usort($data['all_result'], function ($a, $b) {
			$datetime1 = strtotime($a->claim_date); 
			$datetime2 = strtotime($b->claim_date); 
			return $datetime1 - $datetime2;
		});
		//print_r($data['all_result']);				
		return view('admin.pages.unsettle_staff_adv.unsettle_statement_report',$data);
	}
	
	public function UnsettleStatementReport(Request $request)
	{
		$data = array();
		$data['Heading'] = $data['title'] = 'Unsettle Statement';
		$emp_type = $request->emp_type;	
		$data['emp_id'] = $emp_id = $request->emp_id;	
		$data['entry_date'] = $entry_date = $request->entry_date;
		
		$data['all_branch'] = DB::table('tbl_branch')->where('status',1)->get();
		$data['all_emp_type'] = DB::table('tbl_emp_type')->get();
		$all_result = DB::table('tbl_unsettle_staff_adv as us')				
						->where('us.emp_id', $emp_id)
						//->where('us.incre_id', $incre_id)
						->select('us.emp_id','us.claim_date','us.comments','us.total_amount','us.transaction_type')
						->get()->toArray();
		$all_result1 = DB::table('tbl_unstle_staff_adv_col as usc')			
						->where('usc.emp_id', $emp_id)
						//->where('us.incre_id', $incre_id)
						->select('usc.emp_id as emp_id','usc.credit_amt as total_amount','usc.tran_date as claim_date','usc.comments as comments','usc.transaction_type as transaction_type')
						->get()->toArray();
		$all_result2 = DB::table('tbl_unstle_staff_adv_tra as tra')			
						->where('tra.transfer_from_emp_id', $emp_id)
						//->where('us.incre_id', $incre_id)
						->select('tra.transfer_emp_id as emp_id','tra.entry_date as claim_date','tra.transfer_amt as total_amount','tra.transfer_comment as comments','tra.transaction_type as transaction_type')
						->get()->toArray();
		$data['all_result'] = array_merge($all_result,$all_result1,$all_result2);
		//print_r($data['all_result']);				
		return view('admin.pages.unsettle_staff_adv.unsettle_statement_report',$data);
	}
	
	public function UnsettleClaim()
    {        	
		$data = array();
		$data['Heading'] = $data['title'] = 'Unsettle Staff Advance Report';
		$data['emp_type']	= '';	
		$data['from_date']	= '';
		$data['to_date']	= '';
		
		$data['all_branch'] = DB::table('tbl_branch')->where('status',1)->get();
		$data['all_emp_type'] = DB::table('tbl_emp_type')->where('id',1)->get();
		return view('admin.pages.unsettle_staff_adv.unsettle_staff_claim_report',$data);			
    }
	
	public function UnsettleClaimReport(Request $request) {
		$data = array();
		$data['Heading'] = $data['title'] = 'Unsettle Staff Advance Report';
		$data['emp_type'] 	= $emp_type = $request->input('emp_type');
		$data['from_date'] 	= $from_date = $request->input('from_date');
		$data['to_date'] 	= $to_date = $request->input('to_date');

		$data['all_branch'] = DB::table('tbl_branch')->where('status',1)->get();
		$data['all_emp_type'] = DB::table('tbl_emp_type')->where('id',1)->get();
		if(!empty($to_date)) {
			$resultinfo = DB::table('tbl_unsettle_staff_adv as us')
							->leftJoin('tbl_emp_basic_info as e', function($join)
											{
												$join->on('us.emp_id', '=', 'e.emp_id')
												->where('us.emp_type', '=', 1);

											})
							->leftJoin('tbl_emp_non_id as en', function($join)
											{
												$join->on('us.emp_id', '=', 'en.emp_id')
												->on('us.emp_type', '=', 'en.emp_type_code');

											})				
							->where('us.claim_date', '>=', $from_date)
							->where('us.claim_date', '<=', $to_date)
							->select('us.id','us.emp_id','us.incre_id','us.emp_type',DB::raw('sum(us.total_amount) as total_amount'),'us.claim_date','e.emp_name_eng','en.sacmo_id','en.emp_name')
							->groupBy('us.emp_id')
							->get();
			//print_r	($resultinfo);
			if(!empty($resultinfo)) {
				foreach ($resultinfo as $info) {
					$result_info = DB::table('tbl_unsettle_staff_adv as us')
									->leftJoin('tbl_emp_basic_info as e', function($join)
													{
														$join->on('us.emp_id', '=', 'e.emp_id')
														->where('us.emp_type', '=', 1);

													})
									->leftJoin('tbl_emp_non_id as en', function($join)
													{
														$join->on('us.emp_id', '=', 'en.emp_id')
														->on('us.emp_type', '=', 'en.emp_type_code');

													})				
									//->Leftjoin('tbl_unstle_staff_adv_col as usc', 'us.incre_id', '=', 'usc.incre_id')
									->leftJoin('tbl_unstle_staff_adv_col as usc', function($join){
												$join->on('us.incre_id','=','usc.incre_id')
												->on('us.emp_id','=','usc.emp_id');
									})							
									->Leftjoin('tbl_unstle_staff_adv_tra as ust', 'us.emp_id', '=', 'ust.transfer_from_emp_id')				
									->where('us.emp_id', $info->emp_id)
									->select('us.id','us.emp_id',								
										DB::raw("(SELECT sum(credit_amt) FROM tbl_unstle_staff_adv_col
										WHERE emp_id = $info->emp_id AND pay_status = 1) as credit_amt"),
										DB::raw("(SELECT sum(debit_amt) FROM tbl_unstle_staff_adv_col
										WHERE emp_id = $info->emp_id AND pay_status = 1) as debit_amt"),
										DB::raw("(SELECT sum(transfer_amt) FROM tbl_unstle_staff_adv_tra
										WHERE transfer_from_emp_id = $info->emp_id) as transfer_amt"))
									->first();
					//print_r($result_info);
					$data['result_info'][] = array(
						'emp_id' => $info->emp_id,
						'emp_name' => $info->emp_name_eng,
						'debit_amt' => $info->total_amount + $result_info->debit_amt,
						'credit_amt' => ($result_info->credit_amt + $result_info->transfer_amt),
						'balance' => ($info->total_amount + $result_info->debit_amt) - ($result_info->credit_amt + $result_info->transfer_amt)
					);
				}
				//print_r($data['result_info']); //exit;
			}
			$data['emp_type_name'] = DB::table('tbl_emp_type')->where('id', '=', $emp_type)->select('id','type_name')->first();
		}
				
	return view('admin.pages.unsettle_staff_adv.unsettle_staff_claim_report',$data);					
	}
	
	public function UnsettleClaimDelete($emp_id) 
	{
		DB::table('tbl_unsettle_staff_adv')->where('emp_id',$emp_id)->delete();
		DB::table('tbl_unsettle_staff_col')->where('emp_id',$emp_id)->delete();
		DB::table('tbl_unsettle_staff_tra')->where('transfer_from_emp_id',$emp_id)->delete();
		
		Session::put('message','Data Delete Successfully');
		return Redirect::to('/unsettle-claim-report');	
	}
	
	public function UnsettleCollectionResedule(Request $request)
    {
        $data = request()->except(['_token','_method','tran_date']);
		$tran_date = $request->input('tran_date');
		//print_r ($data); exit;
		DB::beginTransaction();
		try {
			//$where = [['emp_id', '=', $data['emp_id']],['incre_id', '=', $data['incre_id']],['transaction_type', '=', 2],['collection_type', '=', 1],['pay_status','=', 0]];
			$where = array('emp_id' => $data['emp_id'],'incre_id' => $data['incre_id'],'collection_type' => 1,'pay_status' => 0);
			DB::table('tbl_unstle_staff_adv_col')->where($where)->delete();
			$no_of_month = intval($data['total_amount']/$data['credit_amt']);
			$month_amt = $data['credit_amt'] * $no_of_month;
			$last_month_amt = $data['total_amount'] - $month_amt;
			//echo $last_month_amt; exit;
			for($i = 1; $i <= $no_of_month; $i++) {
				$month = $i-1;
				if($i == $no_of_month) { 
				$data['credit_amt'] = $data['credit_amt'] + $last_month_amt;
				}
				$data['tran_date'] = date("Y-m-01", strtotime($tran_date . " $month month"));
				//$data['tran_date'] = $tran_date;
				$data['collection_type'] = 1;
				$data['created_by'] = Session::get('admin_id');
				
				DB::table('tbl_unstle_staff_adv_col')->insert($data);
				DB::table('tbl_unsettle_staff_adv_history')->insert($data);
				//$i++;
				//print_r ($data['tran_date']);
				//echo $i.'<br>';
			}
			DB::commit();
			//PUSH SUCCESS MESSAGE
			Session::put('message','Data Saved Successfully');
		} catch (\Exception $e) {
			//PUSH FAIL MESSAGE
			Session::put('message','Error: Unable to Save Data');
			//DB ROLLBACK
			DB::rollback();
		}
		//print_r ($data); 
		//exit;
		Session::put('message','Data Update Successfully');
		return Redirect::to('/unsettle-staff-adv');

    }
	
	public function UnsettleResedule($emp_id,$incre_id)
    {
        $data = array();
		$data['result_info'] = DB::table('tbl_unsettle_staff_adv as us')
						->leftJoin('tbl_emp_basic_info as e', function($join)
										{
											$join->on('us.emp_id', '=', 'e.emp_id')
											->where('us.emp_type', '=', 1);

										})
						->leftJoin('tbl_emp_non_id as en', function($join)
										{
											$join->on('us.emp_id', '=', 'en.emp_id')
											->on('us.emp_type', '=', 'en.emp_type_code');

										})				
						->Leftjoin('tbl_unstle_staff_adv_col as usc', 'us.emp_id', '=', 'usc.emp_id')				
						->Leftjoin('tbl_designation as d', 'us.designation_code', '=', 'd.designation_code')				
						->Leftjoin('tbl_branch as b', 'us.br_code', '=', 'b.br_code')				
						->Leftjoin('tbl_branch as b1', 'us.claim_branch', '=', 'b1.br_code')				
						->where('us.emp_id', $emp_id)
						->where('usc.incre_id', $incre_id)
						->select('us.*','e.emp_name_eng','en.sacmo_id','en.emp_name',DB::raw('min(usc.tran_date) as min_month'),DB::raw('max(usc.tran_date) as max_month'),'d.designation_name','b.branch_name','b1.branch_name as claim_branch_name')
						->first();
		$data['unsettle_staff_view'] = DB::table('tbl_unstle_staff_adv_col')
                                    ->where('emp_id',$emp_id)
                                    ->where('incre_id',$incre_id)
									->get();
		
		//
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->get();
		return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_resedule',$data);
    }

    public function edit($id)
    {
		$data = array();
		$result_info = DB::table('tbl_unsettle_staff_adv as us')
						->leftJoin('tbl_emp_basic_info as e', function($join)
										{
											$join->on('us.emp_id', '=', 'e.emp_id')
											->where('us.emp_type', '=', 1);

										})
						->leftJoin('tbl_emp_non_id as en', function($join)
										{
											$join->on('us.emp_id', '=', 'en.emp_id')
											->on('us.emp_type', '=', 'en.emp_type_code');

										})
						->where('us.incre_id', $id)
						->select('us.emp_id','us.emp_type','us.entry_date','us.designation_code','us.br_code','us.total_amount','us.comments','e.emp_name_eng','en.sacmo_id','en.emp_name',DB::raw('min(us.month_year) as min_month'),DB::raw('max(us.month_year) as max_month'))
						->first();
		//print_r($result_info);
		$data['id'] 				= $id;
		if($result_info->emp_type !=1){
			$data['emp_id'] = $result_info->sacmo_id;
			$data['emp_name'] = $result_info->emp_name;
			$data['nonid_emp_id'] = $result_info->emp_id;
		} else {
			$data['emp_id'] 			= $result_info->emp_id;
			$data['emp_name'] 			= $result_info->emp_name_eng;
			$data['nonid_emp_id'] 		= '';
		}
		
		$data['emp_type'] 			= $result_info->emp_type;
		$data['entry_date'] 		= $result_info->entry_date;		
		$data['designation_code'] 	= $result_info->designation_code;
		$data['br_code'] 			= $result_info->br_code;
		$data['total_amount'] 		= $result_info->total_amount;
		$data['from_month_year'] 	= date('Y-m',strtotime($result_info->min_month));
		$data['to_month_year'] 		= date('Y-m',strtotime($result_info->max_month));
		$data['comments'] 			= $result_info->comments;
		$data['button_text'] 		= 'Update';
		//print_r ($training_info);

		$data['action'] 			= '/unsettle-staff-adv/'.$id;
		$data['method'] 			= 'post';
		$data['method_field'] 		= '<input name="_method" value="PATCH" type="hidden">';
		$data['id'] 				= $id;		
		//
		$data['all_branch'] 	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] = DB::table('tbl_designation')->get();
		$data['all_deduc_type'] = DB::table('tbl_ext_deduc_config')->where('status',1)->get();
		
		return view('admin.pages.unsettle_staff_adv.unsettle_staff_adv_form',$data);	
    }
	
	public function update(Request $request, $id)
    {
        $data = request()->except(['_token','_method','search_dates','nonid_emp_id']);
		$search_dates = $request->input('search_dates');
		$search_date = explode(",",$search_dates);
		$no_of_month = count($search_date);
		$nonid_emp_id = $request->input('nonid_emp_id');
		if($data['emp_type'] !=1){
			$data['emp_id'] = $nonid_emp_id;
		}
		//print_r ($data); exit;
		//$data['month_year'] = $search_date;
		$data['monthly_pay'] = intval($data['total_amount']/$no_of_month);
		//$fraction_amt = explode('.', $data['monthly_pay']);
		//print_r($data['monthly_pay']); //exit;
		$month_amt = $data['monthly_pay'] * $no_of_month;
		$last_month_amt = $data['total_amount'] - $month_amt; //exit;
		DB::table('tbl_unsettle_staff_adv')->where('incre_id',$id)->delete();
		$data['incre_id'] = $id;
		$i = 1;
		foreach ($search_date as $val) {
			if($i == $no_of_month) { 
			$data['monthly_pay'] = $data['monthly_pay'] + $last_month_amt;
			}
			$data['month_year'] = $val;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$data['updated_by'] = Session::get('admin_id');
			//DB::table('tbl_extra_deduction')->insert($data);
			$i++;
		}
		
		
		Session::put('message','Data Update Successfully');
		return Redirect::to('/unsettle-staff-adv');

    }
	
    public function destroy($id)
    {
        echo 'Delete '.$id;
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
