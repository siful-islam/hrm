<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class IncrementLetterController extends Controller
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
        $data['increment_info'] = DB::table('tbl_increment_letter')->get();
		return view('admin.pages.increment_letter.increment_letter_list',$data);
		//return view('admin.pages.training.training_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
		$data['action'] 		= '/increment-letter';
		$data['Heading'] 		= 'Add';
		$data['method'] 		= 'post';
		$data['method_field'] 	= '';
		
		$data['letter_date']	= '';	$data['increment_date']	= '';	$data['grade_code']		= '';	$data['old_basic']	= '';
		$data['branch_type']	= '';	$data['letter_heading']	= '';	$data['letter_body_1']	= '';
		$data['letter_body_2']	= '';	$data['letter_body_3']	= '';	$data['status']			= '';
		$data['id']	= '';
		$data['all_grade'] 	= DB::table('tbl_grade')->where('status',1)->get();
				
		return view('admin.pages.increment_letter.increment_letter_form',$data);
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
        $data_emp = array();
		//$data = request()->except(['_token']);
        //$data = request()->only(['letter_date','increment_date','emp_id','designation_code','br_code','plus_item_id','plus_item','minus_item_id','minus_item']);
		//$data['created_by'] = Session::get('admin_id');
        
		/* $plus_item_id 		= request('plus_item_id');
		$plus_item 				= request('plus_item');
		
		$minus_item_id 			= request('minus_item_id');
		$minus_item 			= request('minus_item');

		$data['plus_item_id'] 	= implode(",", $plus_item_id);   
		$data['plus_item'] 		= implode(",", $plus_item); 

		$data['minus_item_id'] 	= implode(",", $minus_item_id);   
		$data['minus_item'] 	= implode(",", $minus_item); */
		
		$letter_date 		 = $request->input('letter_date');
		$increment_date 	 = $request->input('increment_date');
		$next_increment_date = $request->input('next_increment_date');
		$grade_code 		 = $request->input('grade_code');
		$old_basic 			 = $request->input('old_basic');
		$branch_type 		 = $request->input('branch_type');
		
		$designation_code 	 = $request->input('designation_code');
		$br_code 			 = $request->input('br_code');
		$emp_id 			 = $request->input('emp_id');
		$new_basic 			 = $request->input('new_basic');
		$plus_item_id 		 = $request->input('plus_item_id');
		$plus_item 			 = $request->input('plus_item');		
		$minus_item_id 		 = $request->input('minus_item_id');
		$minus_item 		 = $request->input('minus_item');
		
		$total_pay 			 = $request->input('total_pay');
		$total_minus 		 = $request->input('total_minus');
		$net_pay 			 = $request->input('net_pay');
		
		$data['letter_date'] 		 = $request->input('letter_date');
		$data['increment_date'] 	 = $request->input('increment_date');
		$data['next_increment_date'] = $request->input('next_increment_date');
		$data['grade_code'] 		 = $request->input('grade_code');
		$data['old_basic'] 			 = $request->input('old_basic');
		$data['branch_type'] 		 = $request->input('branch_type');
		$data['letter_heading'] 	 = $request->input('letter_heading');
		$data['letter_body_1'] 		 = $request->input('letter_body_1');
		$data['letter_body_2'] 		 = $request->input('letter_body_2');
		$data['letter_body_3'] 		 = $request->input('letter_body_3');
		
		$data['created_by'] 	= Session::get('admin_id');
		$data['updated_by'] 	= Session::get('admin_id');
		
		//print_r ($data); exit;
		for ($i = 0; $i < count($emp_id); $i++) {
			$data_emp['letter_date'] 		 = $data['letter_date'];
			$data_emp['increment_date'] 	 = $data['increment_date'];
			$data_emp['next_increment_date'] = $data['next_increment_date'];
			$data_emp['emp_id'] 			 = ($emp_id[$i]);
			$data_emp['designation_code'] 	 = ($designation_code[$i]);
			$data_emp['br_code'] 			 = ($br_code[$i]);
			$data_emp['grade_code'] 		 = $grade_code;
			$data_emp['old_basic'] 			 = $old_basic;
			$data_emp['new_basic'] 			 = $new_basic;
			$data_emp['plus_item_id'] 		 = implode(",", $plus_item_id);   
			$data_emp['plus_item'] 			 = implode(",", $plus_item); 
			$data_emp['minus_item_id'] 		 = implode(",", $minus_item_id);   
			$data_emp['minus_item'] 		 = implode(",", $minus_item);
			$data_emp['total_pay'] 			 = $total_pay;
			$data_emp['total_minus'] 		 = $total_minus;
			$data_emp['net_pay'] 			 = $net_pay;
			$data_emp['branch_type'] 		 = $branch_type;
			$data_emp['created_by'] 		 = $data['created_by'];
			$data_emp['updated_by'] 		 = $data['updated_by'];
			DB::table('tbl_increment_letter_emp')->insert($data_emp);
		}

		DB::table('tbl_increment_letter')->insert($data);
		/* DB::table('tbl_increment_letter')
							->where('id',$id)
							->update($data); */

        return redirect('increment-letter');
    }
	
	public function increment_salary(Request $request)
    {
        $data =array();
		
		$data['Heading'] 		= 'Add';
		$data['action'] 		= '/increment-letter';
		$data['method'] 		= 'post';
		$data['method_field'] 	= '';
		$data['letter_date'] 	= request('letter_date');
		$data['increment_date'] = request('increment_date');
		$data['next_inc_date']	= date('Y-m-d', strtotime(date("Y-m-d", strtotime($data['increment_date'])) . " +1 year"));
		$data['grade_code']		= request('grade_code');
		$data['old_basic']    	= request('old_basic');
		$data['branch_type']    = request('branch_type');
		$data['all_grade'] 		= DB::table('tbl_grade')->where('status',1)->get();

		$all_result1 = DB::table('tbl_master_tran as m')
								->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
								->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.id')
								->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
								->where('m.next_increment_date', $data['increment_date'])
								->where('m.grade_code', $data['grade_code'])
								->where('m.basic_salary', $data['old_basic'])						
								->select('m.emp_id','e.emp_name_eng','m.next_increment_date','m.designation_code','m.br_code','d.designation_name','b.branch_name')
								->get();
		foreach ($all_result1 as $result) {
			$max_id = DB::table('tbl_master_tran')
					->where('emp_id', $result->emp_id)
					->max('id');
		
			if($max_id) {
				$employee_info = DB::table('tbl_master_tran')
							->join('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'tbl_master_tran.emp_id')
							->join('tbl_designation', 'tbl_designation.id', '=', 'tbl_master_tran.designation_code')
							->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_master_tran.br_code')
							->join('tbl_grade', 'tbl_grade.id', '=', 'tbl_master_tran.grade_code')
							->join('tbl_scale', 'tbl_scale.scale_id', '=', 'tbl_grade.scale_id')
							->leftJoin('tbl_resignation', 'tbl_resignation.emp_id', '=', 'tbl_master_tran.emp_id')
							->where('tbl_master_tran.id', $max_id)
							->select('tbl_master_tran.id','tbl_master_tran.emp_id','tbl_master_tran.sarok_no','tbl_master_tran.next_increment_date','tbl_master_tran.designation_code','tbl_master_tran.br_code','tbl_master_tran.grade_code','tbl_master_tran.grade_step','tbl_master_tran.department_code','tbl_master_tran.report_to','tbl_master_tran.is_permanent','tbl_emp_basic_info.emp_name_eng','tbl_emp_basic_info.father_name','tbl_emp_basic_info.org_join_date','tbl_designation.designation_name','tbl_branch.branch_name','tbl_grade.grade_name','tbl_scale.scale_name','tbl_scale.scale_basic_1st_step','tbl_scale.increment_amount','tbl_resignation.effect_date','tbl_master_tran.transection_type') 
							->first();	
				//print_r ($employee_info); exit;
				$data['id'] 			  = '';
				$data['emp_id'] 		  = $result->emp_id;
				$data['emp_name'] 		  = $employee_info->emp_name_eng;
				$data['joining_date'] 	  = $employee_info->org_join_date;
				$data['designation_code'] = $employee_info->designation_code;
				$data['designation_name'] = $employee_info->designation_name;
				$data['department_code']  = $employee_info->department_code;
				$data['report_to'] 		  = $employee_info->report_to;
				$data['br_code'] 		  = $employee_info->br_code;
				$data['grade_code'] 	  = $employee_info->grade_code;
				$data['grade_step'] 	  = $employee_info->grade_step;
				$data['branch_name'] 	  = $employee_info->branch_name;
				$data['grade_name'] 	  = $employee_info->grade_name;
				$data['scale_name'] 	  = $employee_info->scale_name;
				
				$scale_basic_1st_step 	  = $employee_info->scale_basic_1st_step;
				$increment_amount 		  = $employee_info->increment_amount;
				$data['basic_salary'] 	  = ($scale_basic_1st_step+$increment_amount) * ($data['grade_step']+1);
				$data['transection_type'] = $employee_info->transection_type;		
			}
			
			$data['all_result'][] = array(
				'emp_id' 			  => $result->emp_id,
				'emp_name_eng'        => $result->emp_name_eng,
				'designation_name'    => $result->designation_name,
				'branch_name'    	  => $result->branch_name,
				'designation_code'    => $result->designation_code,
				'br_code'    		  => $result->br_code,
				'next_increment_date' => $data['next_inc_date']
			);
		}

		$data['plus_items'] 	= DB::table('tbl_salary_plus')->where('status',1)->where('ho_bo',1)->get();
		$data['minus_items'] 	= DB::table('tbl_salary_minus')->where('status',1)->where('ho_bo',1)->get();
		
		$letter_body 			= DB::table('tbl_increment_letter_body')->first();
		$data['letter_heading'] = $letter_body->letter_heading;
		$data['letter_body_1'] 	= $letter_body->letter_body_1;
		$data['letter_body_2'] 	= $letter_body->letter_body_2;
		$data['letter_body_3'] 	= $letter_body->letter_body_3;
		$data['status']			= 1;
		return view('admin.pages.increment_letter.increment_letter_form',$data);
	
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
		$data['Heading'] 		= 'View';
		$data['status'] 		= 1;
		$data['action'] 		= '/increment-letter/'.$id;
		$data['method'] 		= 'post';
		$data['method_field'] 	= '<input name="_method" value="PATCH" type="hidden">';
		$data['all_grade'] 		= DB::table('tbl_grade')->where('status',1)->get();
		$increment_letter_info 	= DB::table('tbl_increment_letter')->where('id', $id)->first();
		$increment_letter_emp 	= DB::table('tbl_increment_letter_emp as i')
								->join('tbl_emp_basic_info as e', 'e.emp_id', '=', 'i.emp_id')
								->join('tbl_designation as d', 'd.id', '=', 'i.designation_code')
								->join('tbl_branch as b', 'b.br_code', '=', 'i.br_code')
								->where('i.id', $id)
								->select('i.*','e.emp_name_eng','b.branch_name','d.designation_name')
								->get();
		$data['id'] 			= $increment_letter_info->id;
		$data['letter_date'] 	= $increment_letter_info->letter_date;
		$data['increment_date'] = $increment_letter_info->increment_date;
		$data['grade_code'] 	= $increment_letter_info->grade_code;
		$data['old_basic'] 		= $increment_letter_info->old_basic;
		$data['branch_type'] 	= $increment_letter_info->branch_type;
		$data['letter_heading'] = $increment_letter_info->letter_heading;
		$data['letter_body_1'] 	= $increment_letter_info->letter_body_1;
		$data['letter_body_2'] 	= $increment_letter_info->letter_body_2;
		$data['letter_body_3'] 	= $increment_letter_info->letter_body_3;
		//print_r ($increment_letter_emp);
		foreach ($increment_letter_emp as $result) { 
			$data['idd'] 			= $result->id;
			$data['basic_salary'] 	= $result->new_basic;
			$data['plus_item_id'] 	= $result->plus_item_id;
			$data['plus_item'] 		= $result->plus_item;
			$data['minus_item_id'] 	= $result->minus_item_id;
			$data['minus_item'] 	= $result->minus_item;
			$data['total_pay'] 		= $result->total_pay;
			$data['total_minus'] 	= $result->total_minus;
			$data['net_pay'] 		= $result->net_pay;
			
			$data['all_result'][] = array(
				'emp_id' 				=> $result->emp_id,
				'emp_name_eng'      	=> $result->emp_name_eng,
				'designation_name'    	=> $result->designation_name,
				'branch_name'    		=> $result->branch_name,
				'designation_code'    	=> $result->designation_code,
				'br_code'    			=> $result->br_code,
				'next_increment_date'  	=> $result->next_increment_date
			);
		}		
		
		$data['plus_items'] 	= DB::table('tbl_salary_plus')->where('status',1)->where('ho_bo',1)->get();
		$data['minus_items']	= DB::table('tbl_salary_minus')->where('status',1)->where('ho_bo',1)->get();
		
		return view('admin.pages.increment_letter.increment_letter_view',$data);
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
		$data['Heading'] 		= 'Add';
		$data['status'] 		= 1;
		$data['action'] 		= '/increment-letter/'.$id;
		$data['method'] 		= 'post';
		$data['method_field'] 	= '<input name="_method" value="PATCH" type="hidden">';
		$data['all_grade'] 		= DB::table('tbl_grade')->where('status',1)->get();
		$increment_letter_info 	= DB::table('tbl_increment_letter')->where('id', $id)->first();
		$increment_letter_emp 	= DB::table('tbl_increment_letter_emp as i')
								->join('tbl_emp_basic_info as e', 'e.emp_id', '=', 'i.emp_id')
								->join('tbl_designation as d', 'd.id', '=', 'i.designation_code')
								->join('tbl_branch as b', 'b.br_code', '=', 'i.br_code')
								->where('i.id', $id)
								->select('i.*','e.emp_name_eng','b.branch_name','d.designation_name')
								->get();
		$data['id'] 			= $increment_letter_info->id;
		$data['letter_date'] 	= $increment_letter_info->letter_date;
		$data['increment_date'] = $increment_letter_info->increment_date;
		$data['grade_code'] 	= $increment_letter_info->grade_code;
		$data['old_basic'] 		= $increment_letter_info->old_basic;
		$data['branch_type'] 	= $increment_letter_info->branch_type;
		$data['letter_heading'] = $increment_letter_info->letter_heading;
		$data['letter_body_1'] 	= $increment_letter_info->letter_body_1;
		$data['letter_body_2'] 	= $increment_letter_info->letter_body_2;
		$data['letter_body_3'] 	= $increment_letter_info->letter_body_3;
		//print_r ($increment_letter_emp);
		foreach ($increment_letter_emp as $result) { 
			$data['idd'] 			= $result->id;
			$data['basic_salary'] 	= $result->new_basic;
			$data['plus_item_id'] 	= $result->plus_item_id;
			$data['plus_item'] 		= $result->plus_item;
			$data['minus_item_id'] 	= $result->minus_item_id;
			$data['minus_item'] 	= $result->minus_item;
			$data['total_pay'] 		= $result->total_pay;
			$data['total_minus'] 	= $result->total_minus;
			$data['net_pay'] 		= $result->net_pay;
			
			$data['all_result'][] = array(
				'emp_id' 				=> $result->emp_id,
				'emp_name_eng'      	=> $result->emp_name_eng,
				'designation_name'    	=> $result->designation_name,
				'branch_name'    		=> $result->branch_name,
				'designation_code'    	=> $result->designation_code,
				'br_code'    			=> $result->br_code,
				'next_increment_date'  	=> $result->next_increment_date
			);
		}		
		
		$data['plus_items'] 	= DB::table('tbl_salary_plus')->where('status',1)->where('ho_bo',1)->get();
		$data['minus_items']	= DB::table('tbl_salary_minus')->where('status',1)->where('ho_bo',1)->get();
		
		return view('admin.pages.increment_letter.increment_letter_form',$data);
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
        $data = request()->only(['letter_date','letter_heading','letter_body_1','letter_body_2','letter_body_3']);
		//print_r ($data); exit;
		$data['updated_by'] = Session::get('admin_id');
		$status = DB::table('tbl_increment_letter')->where('id', $id)->update($data); // its working
		return redirect('increment-letter');
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
