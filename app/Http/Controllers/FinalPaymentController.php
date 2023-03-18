<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
use DateTime;

class FinalPaymentController extends Controller
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
		$data['action'] 		= '/final-payment';
		$data['Heading'] 		= 'Final Payment';
		$data['method'] 		= 'post';
		$data['method_field'] 	= '';
		$data['all_result'] 	= '';
		$data['emp_id']			= '';
		$data['form_date']		= '';
		$data['payment_type']	= '';
		$data['final_payment_info'] = DB::table('tbl_final_payment as fp')
									->Leftjoin('tbl_emp_basic_info as e', 'fp.emp_id', '=', 'e.emp_id')
									->select('e.emp_name_eng','fp.id','fp.emp_id')
									->get();		
		return view('admin.pages.final_payment.final_payment_list',$data);
		//return view('admin.pages.final_payment.final_payment_report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
		$data['action'] 		= '/final-payment';
		$data['Heading'] 		= 'Final Payment';
		$data['method'] 		= 'post';
		$data['method_field'] 	= '';
		$data['all_result'] 	= '';
		$data['emp_id']			= '';
		$data['form_date']		= date('Y-m-d');
		$data['payment_type']	= '';
		return view('admin.pages.final_payment.final_payment_report',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return view('admin.pages.final_payment.final_payment_report',$data);
    }
	
	public function FinalPaymentReport(Request $request)
    {
        $data = array();
		$data['Heading'] 	  = 'Final Payment';
		$data['emp_id'] 	  = $emp_id = $request->input('emp_id');
		$data['form_date'] 	  = $form_date = $request->input('form_date');
		$data['payment_type'] = $payment_type = $request->input('payment_type');
		
		$max_sarok = DB::table('tbl_master_tra as m')
					->where('m.emp_id', '=', $data['emp_id'])
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
		$permanent_date = DB::table('tbl_master_tra')
				->where('emp_id', '=', $data['emp_id'])
				->where('tran_type_no', '=', 2)
				->select('effect_date')
                ->first();
		if(!empty($permanent_date)) {
			$data['permanent_date'] = $permanent_date->effect_date;
		} else {
			$data['permanent_date'] = '';
		}
		
		$data['all_result'] = DB::table('tbl_master_tra as m')
				->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
				->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
				->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
				->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
				->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
				->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
				->where('m.sarok_no', '=', $max_sarok->sarok_no)
				->select('e.emp_id','e.emp_name_eng','e.emp_name_ban','e.org_join_date','e.permanent_add','r.effect_date as re_effect_date','m.br_code','m.designation_code','m.br_join_date','d.designation_name','d.designation_bangla','b.branch_name','b.br_name_bangla','g.grade_name','area_name')
                ->first();
				
		$data['all_plus_item'] = DB::table('tbl_fp_plus_item')
					->where('status', '=', 1)
					->orderBy('item_id', 'ASC')
					->get();
					
		$data['all_minus_item'] = DB::table('tbl_fp_minus_item')
					->where('status', '=', 1)
					->orderBy('item_id', 'ASC')
					->get();		
				
		if($payment_type ==1) {
			
			////////////////////////
			($data['all_result']->br_code == 9999) ? $ho_bo = 0 : $ho_bo = 1;
			$max_sarok_sa = DB::table('tbl_emp_salary as sa')
							->where('sa.emp_id', '=', $emp_id)
							->where('sa.effect_date', '=', function($query) use ($emp_id,$form_date)
								{
									$query->select(DB::raw('max(effect_date)'))
										  ->from('tbl_emp_salary')
										  ->where('emp_id',$emp_id)
										  ->where('effect_date', '<=', $form_date);
								})
							->select('sa.emp_id',DB::raw('max(sa.sarok_no) as sarok_no'))
							->groupBy('sa.emp_id')
							->first();
			$salary = DB::table('tbl_emp_salary')
						->where('emp_id', '=', $max_sarok_sa->emp_id)
						->where('sarok_no', '=', $max_sarok_sa->sarok_no)
						->select('emp_id','salary_basic','total_plus','payable','net_payable','gross_total')
						->first();
			//$where = array(array('pi.for_final_pay_plus',1), array('sp.active_from', '<=', $form_date), array('sp.active_upto', '>=', $form_date), array('sp.status', 1), array('sp.ho_bo', $ho_bo));
			$where = [['pi.for_final_pay_plus', 1],['sp.active_from', '<=', $form_date],['sp.active_upto', 	'>=', $form_date],['sp.status', 1],['sp.ho_bo', $ho_bo]];
			$select = array('pi.item_id','pi.items_name','sp.percentage');									
			$all_plus_items = DB::table('tbl_plus_items as pi')
					->leftJoin('tbl_salary_plus as sp', 'pi.item_id', '=', 'sp.item_name')
					->where($where)
					->select($select)
					->get();
			$total_plus = 0;
			$days= intval(date('t', strtotime($form_date)));
			foreach ($all_plus_items as $plus_items) {
				$plus_amount = round(($salary->salary_basic*$plus_items->percentage)/100);
				$total_plus += $plus_amount;
			}
			//print_r($all_plus_items);
			$total_salary = $salary->salary_basic+$total_plus;
			$one_day_salary = $total_salary / $days;
			$salary_pay = $one_day_salary * 7;
			
			////////////////////////
			
			$data['security_balance'] = DB::table('security_register')
					->where('emp_id', '=', $emp_id)
					->orderBy('security_paid_month', 'DESC')
					->select('security_ending_balance as se_balance')
					->first();
			$data['death_cvg'] = DB::table('death_coverage_register')
					->where('emp_id', '=', $emp_id)
					->orderBy('for_month', 'DESC')
					->select('closing_balance')
					->first();
			$data['salary'] = DB::table('pay_roll as py')
					->leftJoin('pay_roll_details as pyd', 'py.pay_roll_id', '=', 'pyd.pay_roll_id')
					->where('pyd.emp_id', '=', $emp_id)
					->orderBy('py.salary_month', 'DESC')
					->select('pyd.basic_salary')
					->first();
			$data['bcl_loan_amt'] = DB::table('loan as ln')
					->leftJoin('loan_schedule as lns', 'ln.loan_id', '=', 'lns.loan_id')
					->select(DB::raw('sum(lns.installment_amount) AS total_bcl_amt'))
					->where('ln.emp_id', $emp_id)
					->where('ln.loan_product_code', 5)
					->where('lns.status', '=', 'Not Paid')
					->first();
			$data['mcl_loan_amt'] = DB::table('loan as ln')
					->leftJoin('loan_schedule as lns', 'ln.loan_id', '=', 'lns.loan_id')
					->select(DB::raw('sum(lns.installment_amount) AS total_mcl_amt'))
					->where('ln.emp_id', $emp_id)
					->where('ln.loan_product_code', 4)
					->where('lns.status', '=', 'Not Paid')
					->first();
			$data['gel_loan_amt'] = DB::table('loan as ln')
					->leftJoin('loan_schedule as lns', 'ln.loan_id', '=', 'lns.loan_id')
					->select(DB::raw('sum(lns.installment_amount) AS total_gel_amt'))
					->where('ln.emp_id', $emp_id)
					->where('ln.loan_product_code', 3)
					->where('lns.status', '=', 'Not Paid')
					->first();
			//print_r ($data['gel_loan_amt']);
		} elseif($payment_type ==2) {
			$data['pf'] = DB::table('pf_register')
					->where('emp_id', '=', $emp_id)
					->orderBy('for_month', 'DESC')
					->select('closing_balance_staff','closing_balance_org')
					->first();
			$data['pfl_loan_amt'] = DB::table('loan as ln')
					->leftJoin('loan_schedule as lns', 'ln.loan_id', '=', 'lns.loan_id')
					->select(DB::raw('sum(lns.installment_amount) AS total_pfl_amt'))
					->where('ln.emp_id', $emp_id)
					->where('ln.loan_product_code', 1)
					->where('lns.status', '=', 'Not Paid')
					->first();
		} elseif($payment_type ==3) {
			date_default_timezone_set('Asia/Dhaka');
			$input_date = new DateTime($data['all_result']->re_effect_date);
			//$input_date = new DateTime(date('Y-m-d'));
			$org_date = new DateTime($data['all_result']->org_join_date);	
			$difference = date_diff($org_date, $input_date);
			$data['service_length'] = $difference->y . " years, " . $difference->m." months";
			$data['year'] = $year = $difference->y;
			$data['month'] = $month = $difference->m;
			$year >= 20 ? $year = 20: $year = $year;
			
			$data['gratuity'] = DB::table('gratuity_conf')
					->where('start_year', '<=', $year)
					->where('end_year', '>=', $year)
					->first();	
			//print_r($data['gratuity']);
			$data['salary'] = DB::table('tbl_emp_salary')
					->where('emp_id', '=', $emp_id)
					->orderBy('sarok_no', 'DESC')
					->select('salary_basic')
					->first();
			$data['gra_amt_year'] = $data['salary']->salary_basic*$data['gratuity']->point*$year;
			$data['gra_amt_month'] = ($data['salary']->salary_basic*$data['gratuity']->point*$month)/12;
			
			$data['grl_loan_amt'] = DB::table('loan as ln')
					->leftJoin('loan_schedule as lns', 'ln.loan_id', '=', 'lns.loan_id')
					->select(DB::raw('sum(lns.installment_amount) AS total_grl_amt'))
					->where('ln.emp_id', $emp_id)
					->where('ln.loan_product_code', 2)
					->where('lns.status', '=', 'Not Paid')
					->first();
		}
			
		//print_r ($data['security_balance']); exit;
		return view('admin.pages.final_payment.final_payment_report',$data);
    }
	
	public function FinalPaymentInsert(Request $request)
    {
		
		$data = request()->except(['_token','plus_item_id','plus_item_amt','minus_item_id','minus_item_amt']);
		$plus_item_id 			= request('plus_item_id');
		$plus_item_amt 				= request('plus_item_amt'); 
		
		$minus_item_id 			= request('minus_item_id');
		$minus_item_amt 			= request('minus_item_amt');
		
		$data['plus_item_id'] 	= implode(",", $plus_item_id);   
		$data['plus_item_amt'] 		= implode(",", $plus_item_amt);
		$data['minus_item_id'] 	= implode(",", $minus_item_id);   
		$data['minus_item_amt'] 	= implode(",", $minus_item_amt);
		$data['net_total'] = $data['total_plus_amt'] - $data['total_minus_amt'];
		$data['created_by'] = Session::get('admin_id');
		//print_r($data); exit;
		$last_insert_id = DB::table('tbl_final_pay')->insertGetId($data);
		//print_r ($result_item); exit;

		//Session::flash('message1','Data Save Successfully');
		//return back()->withInput();
		return Redirect::to("/final-payment");
    }
	
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array();
		$data['Heading'] 		= 'Final Payment';
		
		$result = $data['all_result'] = DB::table('tbl_final_pay as fp')
				->leftJoin('tbl_emp_basic_info as e', 'fp.emp_id', '=', 'e.emp_id')
				->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
				->leftJoin('tbl_designation as d', 'fp.designation_code', '=', 'd.designation_code')
				->leftJoin('tbl_branch as b', 'fp.br_code', '=', 'b.br_code')
				->leftJoin('tbl_area as a', 'b.area_code', '=', 'a.area_code')
				->where('fp.id', '=', $id)
				->select('fp.*','e.emp_id','e.emp_name_eng','e.emp_name_ban','e.org_join_date','e.permanent_add','r.effect_date as re_effect_date','d.designation_name','d.designation_bangla','b.branch_name','b.br_name_bangla','a.area_name')
                ->first();
		$data['emp_id'] 		= $result->emp_id;
		$data['form_date'] 		= $result->fp_date;
		$data['total_plus_amt'] 		= $result->total_plus_amt;
		$data['total_minus_amt'] 		= $result->total_minus_amt;
		$data['net_total'] 		= $result->net_total;
		$data['payment_type'] 	= '1';
		
		if(!empty($result->plus_item_amt)) {
			$plus_item_id1 =   explode(',',$result->plus_item_id);
			$plus_item_amt1 =   explode(',',$result->plus_item_amt);
			//print_r ($plus_item_id1);
			
			foreach ($plus_item_id1 as $key => $value) {
				$plus_item = DB::table('tbl_fp_plus_item')
					->where('item_id', '=', $value)
					->where('status', '=', 1)
					->select('item_name')
					->first();
				$data['all_plus_item'][] = array(
						'item_id'      => $value,
						'item_name'      => $plus_item->item_name,
						'item_amt'      => $plus_item_amt1[$key]
				);
			}
		}
		///////////////////////////
		$all_plus_items = DB::table('tbl_plus_items')
				->where('for_final_pay_plus', 1)
				->select('item_id')
				->get()->toArray();
		$array =  array_column($all_plus_items, "item_id");		
		//$array = array(1,3,4);
		$item_amt = 0; foreach ($data['all_plus_item'] as $data_plus_item) {
			if (in_array($data_plus_item['item_id'], $array)) {
				$item_amt += $data_plus_item['item_amt'];
			}
		}
		/////////////////////////
		
		if(!empty($result->minus_item_amt)) {
			$minus_item_id1 =   explode(',',$result->minus_item_id);
			$minus_item_amt1 =   explode(',',$result->minus_item_amt);
			//print_r ($minus_item_id1);
			
			foreach ($minus_item_id1 as $key => $value) {
				$minus_item = DB::table('tbl_fp_minus_item')
					->where('item_id', '=', $value)
					->where('status', '=', 1)
					->select('item_name')
					->first();
				$data['all_minus_item'][] = array(
						'item_id'      => $value,
						'item_name'      => $minus_item->item_name,
						'item_amt'      => $minus_item_amt1[$key]
				);
			}
		}		
		//print_r ($data['all_plus_item']);
		//exit;

		//return view('admin.pages.final_payment.final_payment_report_view',$data);
		return view('admin.pages.final_payment.final_payment_report_views',$data);
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
		$data['Heading'] 		= 'Final Payment';
		$data['emp_id'] 		= '';
		$data['form_date'] 		= '';
		$data['payment_type'] 	= '';
		return view('admin.pages.final_payment.final_payment_report_edit',$data);
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
	
	public function fpfileInfo()
    {
        $data = array();
		$login_emp_id = Session::get('emp_id');
		$data['Heading'] 	= 'Final Payment File Info';
		$data['all_result'] = DB::table('tbl_fp_file_info as fp')
									->Leftjoin('tbl_emp_basic_info as e', 'fp.fp_emp_id', '=', 'e.emp_id')
									->Leftjoin('tbl_emp_basic_info as eb', 'fp.receiver_emp_id', '=', 'eb.emp_id')
									->Leftjoin('tbl_emp_basic_info as ebi', 'fp.sender_emp_id', '=', 'ebi.emp_id')
									->where(function($query) use ($login_emp_id) {
											if(!(($login_emp_id == 4891) || ($login_emp_id == 3015))) {
												$query->where('fp.sender_emp_id', $login_emp_id);
												$query->orWhere('fp.receiver_emp_id', $login_emp_id);
											}
										})
									->orderBy('fp.id', 'DESC')
									->select('fp.sender_emp_id','fp.receiver_emp_id','e.emp_name_eng as fp_employee','eb.emp_name_eng as rc_employee','ebi.emp_name_eng as sn_employee','fp.emp_type','fp.id','fp.fp_emp_id','fp.file_type','fp.entry_date','fp.status')
									->get();
		//print_r($data['all_result']);exit;
		if(count($data['all_result']) > 0) {
			return view('admin.pages.final_payment.fp_file_info_list',$data);
		} else {
			return view('admin.access_denyd',$data);
		}		
    }
	
	public function fpfileInfoCreate()
    {
        $data = array();
		$data['action'] 		= '/fp_file_info_insert';
		$data['Heading'] 		= 'File Info';
		$data['fp_emp_id']		= '';
		$data['id_no']			= '';
		$data['value_id']		= '';
		$data['entry_date']		= date('Y-m-d');
		$data['emp_name']		= '';
		$data['file_type']		= '';
		$data['receiver_emp_id'] = '';
		$data['all_result'] = DB::table('tbl_fp_file_info as fp')
									->Leftjoin('tbl_emp_basic_info as e', 'fp.fp_emp_id', '=', 'e.emp_id')
									->select('e.emp_name_eng','fp.id','fp.fp_emp_id')
									->get();
		return view('admin.pages.final_payment.fp_file_info_form',$data);
    }
	
	public function fpfileInfoInsert(Request $request)
    {
		
		$data = request()->except(['_token','id_no','value_id']);
		$data['sender_emp_id'] = Session::get('emp_id');
		$value_id = $request->value_id;
		$id_no = $request->id_no;
		//print_r($data); exit;
		if($value_id != 1) {
			
			$total_count = DB::table('tbl_fp_file_info')
									->where('fp_emp_id', $data['fp_emp_id'])
									//->where('file_type', $data['file_type'])
									->count();
									
			if($total_count > 0) {
				Session::flash('message1','This Employee Already Inserted!');
				return Redirect::to("/fp_file_info_create");
			} else {
				DB::table('tbl_fp_file_info')->insert($data);		
				Session::flash('message','Data Save Successfully');
				return Redirect::to("/fp_file_info");
			}
		} else {
			DB::table('tbl_fp_file_info')->where('id', $id_no)->update(['status' => 2]);
			DB::table('tbl_fp_file_info')->insert($data);		
			Session::flash('message','Data Save Successfully');
			return Redirect::to("/fp_file_info");
		}
		
    }
	
	public function fpfileStatus($id)
    {
		
		$result = DB::table('tbl_fp_file_info')->where('id', $id)->update(['status' => 1]);	
		return response()->json();
		//Session::flash('message1','Data Save Successfully');
		//return Redirect::to("/fp_file_info");
    }
	
	public function fpfileDelete($id,$fp_emp_id)
    {
		
		$result = DB::table('tbl_fp_file_info')->where('id', $id)->delete();
		$result_info = DB::table('tbl_fp_file_info')
									->where('fp_emp_id', $fp_emp_id)
									->where('status', 2)
									->orderBy('id', 'DESC')
									->select('id','fp_emp_id')
									->first();
		//print_r($result_info);exit;
		if(!empty($result_info)) {
			DB::table('tbl_fp_file_info')->where('id', $result_info->id)->update(['status' => 1]);
		}
		return response()->json();
		//Session::flash('message1','Data Save Successfully');
		//return Redirect::to("/fp_file_info");
    }
	
	public function fpfileResend($id)
    {
		
		$data = array();
		$data['action'] 		= '/fp_file_info_insert';
		$data['Heading'] 		= 'File Info';
		
		$result_info = DB::table('tbl_fp_file_info as fp')
									->Leftjoin('tbl_emp_basic_info as e', 'fp.fp_emp_id', '=', 'e.emp_id')
									->where('fp.id', $id)
									->select('fp.*','e.emp_name_eng')
									->first();									
							
		$data['id_no']			= $id;
		$data['fp_emp_id']		= $result_info->fp_emp_id;
		$data['entry_date']		= date('Y-m-d');
		$data['value_id']		= 1;
		
		if(!empty($result_info->emp_name_eng)) {
			$data['emp_name'] = $result_info->emp_name_eng;
		}
		
		$data['file_type']		= $result_info->file_type;
		$data['receiver_emp_id'] = '';
		
		return view('admin.pages.final_payment.fp_file_info_form',$data);
    }
	
	public function get_employee_name($fp_emp_id)
	{
		$data = array();
		$max_id = DB::table('tbl_master_tra')
					->where('emp_id', $fp_emp_id)
					->max('sarok_no');	
		//echo $max_id;		
		if($max_id !=NULL) {
			$employee_info = DB::table('tbl_master_tra as m')
						->Leftjoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->where('m.sarok_no', $max_id)
						->select('m.emp_id','m.designation_code','m.br_code','e.emp_name_eng') 
						->first();	

			$data['emp_id'] 				= $fp_emp_id;
			$data['emp_name'] 				= $employee_info->emp_name_eng;
			$data['error'] 					= '';
		
		} else {
			$data['error'] 					= 1;
		}
		
		return $data;
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
