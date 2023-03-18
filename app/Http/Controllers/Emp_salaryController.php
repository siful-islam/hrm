<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Salary;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class Emp_salaryController extends Controller
{

    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}	
	public function index()
    {        					
		return view('admin.payroll.manage_emp_salary');					
    }
	
	public function all_salary(Request $request)
    {       
		$columns = array( 
			0 => 'tbl_emp_salary.emp_id',
			1 => 'tbl_emp_salary.emp_name_eng',
			2 => 'tbl_transections.transaction_name',
			3 => 'tbl_emp_salary.salary_basic',
			4 => 'tbl_emp_salary.gross_total', 
			5 => 'tbl_emp_salary.id', 
		); 
		
        $totalData = Salary::count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');           
        if(empty($request->input('search.value')))
        {            
            $salary = Salary:: leftjoin('tbl_emp_basic_info', 'tbl_emp_salary.emp_id', '=', 'tbl_emp_basic_info.emp_id' )
								->leftjoin('tbl_transections', 'tbl_transections.transaction_code', '=', 'tbl_emp_salary.transection')
								->select('tbl_emp_salary.id','tbl_emp_salary.emp_id','tbl_emp_salary.letter_date','tbl_emp_salary.salary_basic','tbl_emp_salary.net_payable','tbl_emp_salary.data_type','tbl_transections.transaction_name','tbl_emp_basic_info.emp_name_eng')
								->offset($start)
								->limit($limit)
								->orderBy('tbl_emp_salary.letter_date', 'desc')
								->get();
        }
        else{
            $search = $request->input('search.value'); 
             $salary =  Salary::leftjoin('tbl_emp_basic_info', 'tbl_emp_salary.emp_id', '=', 'tbl_emp_basic_info.emp_id' )
							->join('tbl_transections', 'tbl_transections.transaction_code', '=', 'tbl_emp_salary.transection')
							->where('tbl_emp_salary.emp_id',$search)
							->select('tbl_emp_salary.id','tbl_emp_salary.emp_id','tbl_emp_salary.letter_date','tbl_emp_salary.salary_basic','tbl_emp_salary.net_payable','tbl_emp_salary.data_type','tbl_transections.transaction_name','tbl_emp_basic_info.emp_name_eng')
                            ->offset($start)
                            ->limit($limit)
							->orderBy('tbl_emp_salary.letter_date', 'desc')
							->get();
            $totalFiltered = Salary::where('tbl_emp_salary.emp_id',$search)
                             ->count();
        }
        $data = array();
        if(!empty($salary))
        {
            $i=1;
            foreach ($salary as $v_salary)
            {                
				$nestedData['sl'] 				= $i++;
                $nestedData['emp_id'] 			= $v_salary->emp_id;
                $nestedData['emp_name'] 		= $v_salary->emp_name_eng;
                $nestedData['letter_date'] 		= $v_salary->letter_date;
                $nestedData['transection_id'] 	= $v_salary->transaction_name;
                $nestedData['salary_basic'] 	= $v_salary->salary_basic;
                $nestedData['net_payable'] 		= $v_salary->net_payable;
				$nestedData['options'] 			= '<a class="btn btn-sm btn-danger btn-xs"  title="Edit"><i class="fa fa-lock"></i></a>';
				/*if($v_salary->data_type ==1 ) {

				$nestedData['options'] 			= '<a class="btn btn-sm btn-danger btn-xs"  title="Edit"><i class="fa fa-lock"></i></a>';
				
				} else {
					
				//$nestedData['options'] 			= '<a class="btn btn-sm btn-primary btn-xs"  title="Edit" href="staff-salary/'.$v_salary->id.'/edit"><i class="glyphicon glyphicon-pencil"></i></a>';	
				$nestedData['options'] 			= '<a class="btn btn-sm btn-danger btn-xs"  title="Edit"><i class="fa fa-lock"></i></a>';
				}*/				
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
	
	
	
	public function create()
    {
		$action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		$data = array();
		$data['emp_id'] 			= '';
		$data['effect_date'] 		= date('Y-m-d');
		$data['emp_status'] 		= '';
		return view('admin.payroll.salary_form',$data);	
    }
	
	public function generate_salary(Request $request)
    {
        $data =array();
		$emp_id 		= request('search_emp_id');
		$effect_date    = request('search_effect_date');
		
		if($emp_id != null){
		
			$data = array();
			
			/*$max_salary = DB::table('tbl_emp_salary')
					->where('emp_id', $emp_id)
					->where('effect_date','<=', $effect_date)
					->max('extra_mobile_allowance');
			if($max_salary)
			{
				$data['extra_mobile_allowance'] = $max_salary;
			}
			else{
				$data['extra_mobile_allowance'] = 0;
			}*/


					
			$max_id = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $emp_id)
						->where('m.br_join_date', '=', function($query) use ($emp_id,$effect_date)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $effect_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('emp_id')
						->first();
						
						
						
	

						
					
			//echo 	$max_id->sarok_no;
			//exit;			

			if(!empty($max_id)) // IF Employee Has any Tran-sectional Data  
			{
				$employee_info = DB::table('tbl_master_tra')
							->leftJoin('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'tbl_master_tra.emp_id')
							->leftJoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_master_tra.designation_code')
							->leftJoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_master_tra.br_code')
							->leftJoin('tbl_grade_new', 'tbl_grade_new.grade_code', '=', 'tbl_master_tra.grade_code')
							->leftJoin('tbl_resignation', 'tbl_resignation.emp_id', '=', 'tbl_master_tra.emp_id')
							->leftJoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_master_tra.emp_id')
							->where('tbl_master_tra.sarok_no', $max_id->sarok_no)
							->select('tbl_master_tra.id','tbl_master_tra.emp_id','tbl_master_tra.sarok_no','tbl_master_tra.next_increment_date','tbl_master_tra.designation_code','tbl_master_tra.br_code','tbl_master_tra.salary_br_code','tbl_master_tra.grade_code','tbl_master_tra.grade_step','tbl_master_tra.department_code','tbl_master_tra.report_to','tbl_master_tra.is_permanent','tbl_emp_basic_info.emp_name_eng','tbl_emp_basic_info.father_name','tbl_emp_basic_info.org_join_date','tbl_emp_photo.emp_photo','tbl_designation.designation_name','tbl_branch.branch_name','tbl_grade_new.grade_name','tbl_resignation.effect_date','tbl_master_tra.tran_type_no','tbl_master_tra.basic_salary') 
							->first();	
							
							
							
				$data['id'] 					= '';
				$data['emp_id'] 				= $emp_id;
				$data['effect_date'] 			= $effect_date;
				$data['emp_name'] 				= $employee_info->emp_name_eng;
				$data['joining_date'] 			= $employee_info->org_join_date;
				$data['designation_code'] 		= $employee_info->designation_code;
				$data['designation_name'] 		= $employee_info->designation_name;
				$data['department_code'] 		= $employee_info->department_code;
				$data['report_to'] 				= $employee_info->report_to;
				$data['resign_date'] 			= $employee_info->effect_date;
				$data['br_code'] 				= $employee_info->br_code;
				$data['salary_br_code'] 		= $employee_info->salary_br_code;
				$data['grade_code'] 			= $employee_info->grade_code;
				$data['grade_step'] 			= $employee_info->grade_step;
				$data['branch_name'] 			= $employee_info->branch_name;
				$data['grade_name'] 			= $employee_info->grade_name;
				$data['basic_salary'] 			= $employee_info->basic_salary;
				$data['tran_type_no'] 			= $employee_info->tran_type_no;	
				$data['sarok_no'] 				= $employee_info->sarok_no; 
				$data['is_permanent'] 			= $employee_info->is_permanent;
				
				
				//echo '<pre>';
				//print_r($data['tran_type_no']);
				//exit;
				
				//salary_br_code

				if($employee_info->br_code == 9999)
				{
					$ho_bo = 0;
				}
				elseif($employee_info->br_code == 9997)
				{
					$ho_bo = 3;
				}
				elseif($employee_info->br_code > 0)
				{
					$ho_bo = 1;
				}
				else
				{
					$ho_bo = 2;
				}	
				
				
				if($employee_info->designation_name == 'Officer (Audit)' && $employee_info->br_code == 9999)
				{
					$ho_bo = 0;
				}
				elseif($employee_info->designation_name == 'Officer (Audit)' && $employee_info->br_code != 9999)
				{
					$ho_bo = 1;
				}

				/////*************//////
				
				
				
				
				//echo $is_permanent;
				//exit;

				////////************////////
				
				if($employee_info->emp_photo !='')
				{
					$data['emp_photo'] = $employee_info->emp_photo;
				}
				else
				{
					$data['emp_photo'] = 'default.png';
				}	

				// Probation
				if($employee_info->is_permanent == 1)
				{
					$is_permanent = 1;
				}
				// Permanent
				elseif($employee_info->is_permanent == 2)
				{
					$is_permanent = 2;
				}
				// Masterrole
				elseif($employee_info->is_permanent == 3)
				{
					$is_permanent = 3;
				}	
				
				// ALL
				else
				{
					$is_permanent = 0;
				}

				/////*********/////////
				$data['plus_items'] 	= DB::table('tbl_salary_plus as plus')
										->join('tbl_plus_items as item', 'item.item_id', '=', 'plus.item_name')
										// DESIGNATION
										->where([
										['plus.active_from', 	'<=', $effect_date],
										['plus.active_upto', 	'>=', $effect_date],
										['plus.status', 		'=', 1],
										['plus.ho_bo', 			'=', $ho_bo],
										//['plus.epmloyee_status','=', $is_permanent],
										['plus.designation_for','=', $data['designation_code']],
										])
										// GRADE
										->orwhere([
										['plus.active_from', 	'<=', $effect_date],
										['plus.active_upto', 	'>=', $effect_date],
										['plus.status', 		'=', 1],
										['plus.ho_bo', 			'=', $ho_bo],
										//['plus.epmloyee_status','=', $is_permanent],
										['plus.designation_for','=', 0],
										['plus.emp_grade', 		'=', $data['grade_code']]
										])
										// HO/ BO
										->orwhere([
										['plus.active_from', 	'<=', $effect_date],
										['plus.active_upto', 	'>=', $effect_date],
										['plus.status', 		'=', 1],
										['plus.ho_bo', 			'=', $ho_bo],
										['plus.epmloyee_status','=', $is_permanent],
										])
										->get();
												
																		
												
				$data['minus_items'] 	= DB::table('tbl_salary_minus as minus')
										->join('tbl_minus_items as item', 'item.item_id', '=', 'minus.item_name')
										->where([
										['minus.active_from', 	'<=', $effect_date],
										['minus.active_upto', 	'>=', $effect_date],
										['minus.status', 		'=', 1],
										['minus.ho_bo', 			'=', $ho_bo],
										['minus.epmloyee_status','=', $is_permanent]
										])
										->OrderBy('item.ordering','asc')
										->get();


					$data['transections'] 		= DB::table('tbl_transections')->where('transaction_status',1)->where('is_effect_salary',1)->get();
					$data['button'] 			= '<i class="fa fa-save" aria-hidden="true"></i> Save';
					$data['action'] 			= 'save-salary';	
					$data['emp_status'] 		= 'Active';	
							
								
								
			}

			else
			{			
				$data['emp_id'] 			= $emp_id;
				$data['effect_date'] 		= $effect_date;
				$data['emp_status'] 		= 'Not Active';	
			}

			$data['salary_history'] = DB::table('tbl_emp_salary')
							->leftjoin('tbl_transections', 'tbl_transections.transaction_code', '=', 'tbl_emp_salary.transection')
							->where('tbl_emp_salary.emp_id', $emp_id)
							->orderBy('tbl_emp_salary.effect_date', 'desc')
							->orderBy('tbl_emp_salary.salary_basic', 'desc')
							->get();
						

		}
		
		else{
			
			$data = array();
			$data['emp_id'] 			= '';
			$data['effect_date'] 		= date('Y-m-d');
			$data['emp_status'] 		= '';
		}
		
		
		echo '<pre>';
		print_r($data['salary_history']);
		exit;
		
		$data['branches'] 		    = DB::table('tbl_branch')->where('status',1)->get();
		
		return view('admin.payroll.salary_form', $data);
		
		
		
		
		 
			
    }
	
	
	
	
	public function edit($id)
    {
		$salary_info 				= DB::table('tbl_emp_salary')
										->where('id',$id)
										->first();
		
		$data['id'] 				= $salary_info->id;
		$emp_id  					= $salary_info->emp_id;
		$data['emp_id']  			= $emp_id;
		$effect_date				= $salary_info->effect_date;
		$data['effect_date']		= $effect_date;
		$data['tran_type_no']		= $salary_info->transection;
		$data['basic_salary']		= $salary_info->salary_basic;
		$data['total_plus']			= $salary_info->total_plus;
		$data['payable']			= $salary_info->payable;
		$data['gross_total']		= $salary_info->gross_total;
		$data['total_minus']		= $salary_info->total_minus;
		$data['plus_item']  		= $salary_info->plus_item;
		$data['minus_item'] 		= $salary_info->minus_item;
		$data['plus_item_id']  		= $salary_info->plus_item_id;
		$data['minus_item_id'] 		= $salary_info->minus_item_id;
		
					
		
			
					
					
		$max_id = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $emp_id)
						->where('m.br_join_date', '=', function($query) use ($emp_id,$effect_date)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $effect_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('emp_id')
						->first();

		$employee_info = DB::table('tbl_master_tra')
							->join('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'tbl_master_tra.emp_id')
							->join('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_master_tra.designation_code')
							->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_master_tra.br_code')
							->join('tbl_grade_new', 'tbl_grade_new.grade_code', '=', 'tbl_master_tra.grade_code')
							->leftJoin('tbl_resignation', 'tbl_resignation.emp_id', '=', 'tbl_master_tra.emp_id')
							->leftJoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_master_tra.emp_id')
							->where('tbl_master_tra.sarok_no', $max_id->sarok_no)
							->select('tbl_master_tra.id','tbl_master_tra.emp_id','tbl_master_tra.sarok_no','tbl_master_tra.next_increment_date','tbl_master_tra.designation_code','tbl_master_tra.br_code','tbl_master_tra.salary_br_code','tbl_master_tra.grade_code','tbl_master_tra.grade_step','tbl_master_tra.department_code','tbl_master_tra.report_to','tbl_master_tra.is_permanent','tbl_emp_basic_info.emp_name_eng','tbl_emp_basic_info.father_name','tbl_emp_basic_info.org_join_date','tbl_emp_photo.emp_photo','tbl_designation.designation_name','tbl_branch.branch_name','tbl_grade_new.grade_name','tbl_resignation.effect_date','tbl_master_tra.tran_type_no','tbl_master_tra.basic_salary') 
							->first();	
		
			

			$data['emp_name'] 				= $employee_info->emp_name_eng;
			$data['joining_date'] 			= $employee_info->org_join_date;
			$data['designation_code'] 		= $employee_info->designation_code;
			$data['designation_name'] 		= $employee_info->designation_name;
			$data['department_code'] 		= $employee_info->department_code;
			$data['report_to'] 				= $employee_info->report_to;
			$data['br_code'] 				= $employee_info->br_code;
			$data['salary_br_code'] 		= $employee_info->salary_br_code;
			$data['grade_code'] 			= $employee_info->grade_code;
			$data['grade_step'] 			= $employee_info->grade_step;
			$data['branch_name'] 			= $employee_info->branch_name;
			$data['grade_name'] 			= $employee_info->grade_name;
			$data['sarok_no'] 				= $employee_info->sarok_no; 
			$data['is_permanent'] 			= $employee_info->is_permanent;
			

			if($employee_info->emp_photo !='')
			{
				$data['emp_photo'] 			= $employee_info->emp_photo;
			}
			else{
				$data['emp_photo'] 			= 'default.png';
			}			
			$data['resign_date'] 			= $employee_info->effect_date;
			$data['emp_status'] 			= 'Active';			

		
		
			if($employee_info->br_code == 9999)
			{
				$ho_bo = 0;
			}
			elseif($employee_info->br_code == 9997)
			{
				$ho_bo = 3;
			}
			elseif($employee_info->br_code > 0)
			{
				$ho_bo = 1;
			}
			else
			{
				$ho_bo = 2;
			}	
			
			
			if($employee_info->designation_name == 'Officer (Audit)' && $employee_info->br_code == 9999)
			{
				$ho_bo = 0;
			}
			elseif($employee_info->designation_name == 'Officer (Audit)' && $employee_info->br_code != 9999)
			{
				$ho_bo = 1;
			}
		
			

			
			// Probation
			if($employee_info->is_permanent == 1)
			{
				$is_permanent = 1;
			}
			// Permanent
			elseif($employee_info->is_permanent == 2)
			{
				$is_permanent = 2;
			}
			// Masterrole
			elseif($employee_info->is_permanent == 3)
			{
				$is_permanent = 3;
			}	
			// ALL
			else
			{
				$is_permanent = 0;
			}

				$data['plus_items'] 	= DB::table('tbl_salary_plus as plus')
										->join('tbl_plus_items as item', 'item.item_id', '=', 'plus.item_name')
										// DESIGNATION
										->where([
										['plus.active_from', 	'<=', $effect_date],
										['plus.active_upto', 	'>=', $effect_date],
										['plus.status', 		'=', 1],
										['plus.ho_bo', 			'=', $ho_bo],
										['plus.epmloyee_status','=', $is_permanent],
										['plus.designation_for','=', $data['designation_code']],
										])
										// GRADE
										->orwhere([
										['plus.active_from', 	'<=', $effect_date],
										['plus.active_upto', 	'>=', $effect_date],
										['plus.status', 		'=', 1],
										['plus.ho_bo', 			'=', $ho_bo],
										//['plus.epmloyee_status','=', $is_permanent],
										['plus.designation_for','=', 0],
										['plus.emp_grade', 		'=', $data['grade_code']]
										])
										// HO/ BO
										->orwhere([
										['plus.active_from', 	'<=', $effect_date],
										['plus.active_upto', 	'>=', $effect_date],
										['plus.status', 		'=', 1],
										['plus.ho_bo', 			'=', $ho_bo],
										['plus.epmloyee_status','=', $is_permanent],
										])
										->get();
												
																		
												
				$data['minus_items'] 	= DB::table('tbl_salary_minus as minus')
										->join('tbl_minus_items as item', 'item.item_id', '=', 'minus.item_name')
										->where([
										['minus.active_from', 	'<=', $effect_date],
										['minus.active_upto', 	'>=', $effect_date],
										['minus.status', 		'=', 1],
										['minus.ho_bo', 			'=', $ho_bo],
										['minus.epmloyee_status','=', $is_permanent]
										])
										->get();
												
		
		$data['transections'] 		= DB::table('tbl_transections')->where('transaction_status',1)->where('is_effect_salary',1)->get();
		$data['button'] 			= '<i class="fa fa-save" aria-hidden="true"></i> Update';
		$data['action'] 			= 'update-salary';
		
		
		
		$data['salary_history'] = DB::table('tbl_emp_salary')
						->join('tbl_transections', 'tbl_transections.transaction_id', '=', 'tbl_emp_salary.transection')
						->where('tbl_emp_salary.emp_id', $emp_id)
						->orderBy('tbl_emp_salary.effect_date', 'desc')
						->get();
							
		
		
		//print_r($data);
		//exit;
		
		
		$data['branches'] 		    = DB::table('tbl_branch')->where('status',1)->get();
		return view('admin.payroll.salary_form',$data);	
	}
	
	public function show(Request $request)
    {
		
		$data =array();
		$emp_id 		= request('search_emp_id');
		$effect_date    = request('search_effect_date');
		
		if($emp_id != null){
		
			$data = array();
			$plus = array();
			$minus = array();
			
			$max_id = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $emp_id)
						->where('m.br_join_date', '=', function($query) use ($emp_id,$effect_date)
								{
									$query->select(DB::raw('max(br_join_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('br_join_date', '<=', $effect_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('emp_id')
						->first();
						
			//dd($max_id);			
						
			if(!empty($max_id))
			{
				$employee_info = DB::table('tbl_master_tra')
							->leftJoin('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'tbl_master_tra.emp_id')
							->leftJoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_master_tra.designation_code')
							->leftJoin('tbl_branch as b1', 'b1.br_code', '=', 'tbl_master_tra.br_code')
							->leftJoin('tbl_branch as b2', 'b2.br_code', '=', 'tbl_master_tra.salary_br_code')
							->leftJoin('tbl_grade_new', 'tbl_grade_new.grade_code', '=', 'tbl_master_tra.grade_code')
							->leftJoin('tbl_resignation', 'tbl_resignation.emp_id', '=', 'tbl_master_tra.emp_id')
							->leftJoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_master_tra.emp_id')
							->where('tbl_master_tra.sarok_no', $max_id->sarok_no)
							->select('tbl_master_tra.id','tbl_master_tra.emp_id','tbl_master_tra.sarok_no','tbl_master_tra.next_increment_date','tbl_master_tra.designation_code','tbl_master_tra.br_code','tbl_master_tra.salary_br_code','tbl_master_tra.grade_code','tbl_master_tra.grade_step','tbl_master_tra.department_code','tbl_master_tra.report_to','tbl_master_tra.is_permanent','tbl_emp_basic_info.emp_name_eng','tbl_emp_basic_info.father_name','tbl_emp_basic_info.org_join_date','tbl_emp_photo.emp_photo','tbl_designation.designation_name','b1.branch_name as branch_name','b2.branch_name as salary_branch_name','tbl_grade_new.grade_name','tbl_resignation.effect_date','tbl_master_tra.tran_type_no','tbl_master_tra.basic_salary') 
							->first();	
									
				if($employee_info->emp_photo !='')
				{
					$data['emp_photo'] 			= $employee_info->emp_photo;
				}
				else{
					$data['emp_photo'] 			= 'default.png';
				}			
				$data['resign_date'] 			= $employee_info->effect_date;
				$data['emp_status'] 			= 'Active';	
				

							
				$data['id'] 					= '';
				$data['emp_id'] 				= $emp_id;
				$data['effect_date'] 			= $effect_date;
				$data['emp_name'] 				= $employee_info->emp_name_eng;
				$data['joining_date'] 			= $employee_info->org_join_date;
				$data['designation_code'] 		= $employee_info->designation_code;
				$data['designation_name'] 		= $employee_info->designation_name;
				$data['department_code'] 		= $employee_info->department_code;
				$data['report_to'] 				= $employee_info->report_to;
				$data['resign_date'] 			= $employee_info->effect_date;
				$data['br_code'] 				= $employee_info->br_code;
				$data['salary_br_code'] 		= $employee_info->salary_br_code;
				$data['grade_code'] 			= $employee_info->grade_code;
				$data['grade_step'] 			= $employee_info->grade_step;
				$data['branch_name'] 			= $employee_info->branch_name;
				$data['salary_branch_name'] 	= $employee_info->salary_branch_name;
				$data['grade_name'] 			= $employee_info->grade_name;
				$data['basic_salary'] 			= $employee_info->basic_salary;
				$data['tran_type_no'] 			= $employee_info->tran_type_no;	
				$data['sarok_no'] 				= $employee_info->sarok_no; 
				$data['is_permanent'] 			= $employee_info->is_permanent;
				$max_salary_id = DB::table('tbl_emp_salary')
						->where('emp_id', $emp_id)
						->where('effect_date','<=', $effect_date)
						->max('id');
				if($max_salary_id)
				{
					$data['max_salary_id'] = $max_salary_id;
					$data['emp_id'] 			= $emp_id;
					$data['effect_date'] 		= $effect_date;
					$last_salary = DB::table('tbl_emp_salary')
									->leftjoin('tbl_transections', 'tbl_transections.transaction_code', '=', 'tbl_emp_salary.transection')
									->where('tbl_emp_salary.emp_id', $emp_id)
									->where('tbl_emp_salary.id', $max_salary_id)
									->first();
					$data['last_salary'] = $last_salary;
					$plus = explode(",",$last_salary->plus_item_id); 
					$data['plus_taka'] = explode(",",$last_salary->plus_item); 
					$minus = explode(",",$last_salary->minus_item_id); 
					$data['minus_taka'] = explode(",",$last_salary->minus_item); 
					$data['salary_history'] = DB::table('tbl_emp_salary')
									->leftjoin('tbl_transections', 'tbl_transections.transaction_code', '=', 'tbl_emp_salary.transection')
									->where('tbl_emp_salary.emp_id', $emp_id)
									->orderBy('tbl_emp_salary.effect_date', 'desc')
									->get();	
					foreach($plus as $v_plus)
					{
						if($emp_id >= 200000 && $last_salary->is_migrated == 0) { 
							
							$plus_item_name[] = DB::table('tbl_plus_items')
											->where('tbl_plus_items.item_id', $v_plus)
											->select('tbl_plus_items.items_name')
											->first();
						}
						elseif($emp_id >= 200000 && $last_salary->is_migrated == 1)
						{
							$plus_item_name[] = DB::table('tbl_non_salary_plus')
											->where('tbl_non_salary_plus.id', $v_plus)
											->select('tbl_non_salary_plus.item_name as items_name')
											->first();
						}
						else 
						{
							$plus_item_name[] = DB::table('tbl_salary_plus')
										->leftjoin('tbl_plus_items', 'tbl_plus_items.item_id', '=', 'tbl_salary_plus.item_name')
										->where('tbl_salary_plus.id', $v_plus)
											/*->where(function($query) use ($emp_id,$v_plus) {
												if($emp_id >= 200000) { 
													$query->where('tbl_plus_items.item_id', $v_plus);
												} else {
													$query->where('tbl_salary_plus.id', $v_plus);
												}
											})*/
										->select('tbl_plus_items.items_name')
										->first();
						}
					}

					//dd($plus_item_name);					
					foreach($minus as $v_minus)
					{
						if($emp_id >= 200000 && $last_salary->is_migrated == 0) { 
							
							$minus_item_name[] = DB::table('tbl_minus_items')
											->where('tbl_minus_items.item_id', $v_minus)
											->select('tbl_minus_items.items_name')
											->first();
						}
						else{
							$minus_item_name[] = DB::table('tbl_salary_minus')
										->leftjoin('tbl_minus_items', 'tbl_minus_items.item_id', '=', 'tbl_salary_minus.item_name')
										->where('tbl_salary_minus.id', $v_minus)
										->select('tbl_minus_items.items_name') 
										->first();
						}
						
						
						
					}
					$data['plus_item_name'] = $plus_item_name;
					$data['minus_item_name'] = $minus_item_name;
				}
				else{
					
					$data['max_salary_id'] = '';
					$data['emp_id'] 			= $emp_id;
					$data['effect_date'] 		= $effect_date;
					$data['last_salary'] = array();
					$plus = array();
					$data['plus_taka'] = array();
					$minus = array();
					$data['minus_taka'] = array(); 
					$data['salary_history'] = array();
					$data['plus_item_name'] = array();
					$data['minus_item_name'] = array(); 
				}
			}
			else{
				$data = array();
				$data['emp_id'] 			= $emp_id;
				$data['emp_name'] 			= '';
				$data['effect_date'] 		= $effect_date;
				$data['emp_status'] 		= '';
				$data['max_salary_id'] 		= 'No Employee Found';
			}			
		}
		else{
			$data = array();
			$data['emp_id'] 			= '';
			$data['emp_name'] 			= '';
			$data['effect_date'] 		= date('Y-m-d');
			$data['emp_status'] 		= '';
			$data['max_salary_id'] 		= 'No Employee Found';
		}
		
		//dd($plus_item_name);
		
		
		return view('admin.payroll.salary_view', $data);	
    }
	

	
	public function show_pre(Request $request)
    {
		
		$data =array();
		$emp_id 		= request('search_emp_id');
		$effect_date    = request('search_effect_date');
		
		
		
		if($emp_id != null){
		
			$data = array();
			
			$max_salary_id = DB::table('tbl_emp_salary')
					->where('emp_id', $emp_id)
					->where('effect_date','<=', $effect_date)
					->max('id');
		
		
			$data['max_salary_id'] = $max_salary_id;

			$data['emp_id'] 			= $emp_id;
			$data['effect_date'] 		= $effect_date;
			$data['emp_status'] 		= 'Not Active';	

			
			$data['salary_history'] = DB::table('tbl_emp_salary')
							->leftjoin('tbl_transections', 'tbl_transections.transaction_code', '=', 'tbl_emp_salary.transection')
							->where('tbl_emp_salary.emp_id', $emp_id)
							->orderBy('tbl_emp_salary.effect_date', 'desc')
							->get();
						

		}
		
		else{
			
			$data = array();
			$data['emp_id'] 			= '';
			$data['effect_date'] 		= date('Y-m-d');
			$data['emp_status'] 		= '';
			$data['max_salary_id'] 		= 'under Construction!!!!';
		}
		
		return view('admin.payroll.salary_view', $data);
			
    }
	
	
	public function save(Request $request)
	{
		$data = request()->except(['_token','submit','salary_br_code','plus_item','minus_item','id']);
		
		$data['created_by'] 	= Session::get('admin_id');
		$data['updated_by'] 	= Session::get('admin_id');
		$data['org_code'] 		= Session::get('admin_org_code');
		
		$data['letter_date'] 	= request('effect_date');
		
		
		$plus_item_id 			= request('plus_item_id');
		$plus_item 				= request('plus_item'); 
		
		$minus_item_id 			= request('minus_item_id');
		$minus_item 			= request('minus_item');

		if($plus_item_id)
		{
			$data['plus_item_id'] 	= implode(",", $plus_item_id);   
			$data['plus_item'] 		= implode(",", $plus_item);	
		}else{
			$data['plus_item_id'] 	= '';   
			$data['plus_item'] 		= '';
		}
		
		if($minus_item_id)
		{
			$data['minus_item_id'] 	= implode(",", $minus_item_id);   
			$data['minus_item'] 	= implode(",", $minus_item);
		}else{
			$data['minus_item_id'] 	= '';   
			$data['minus_item'] 	= '';
		}
		
		
		$emp_id 						= request('emp_id');
		$sarok_no 						= request('sarok_no');
		$master_data['salary_br_code'] 	= request('salary_br_code');
		
		
		
		
		
		//print_r($data);
		//exit;
		

		//Data Action 
		
		DB::beginTransaction();
		try {				

			DB::table('tbl_master_tra')
            ->where('sarok_no', $sarok_no)
			->where('emp_id', $emp_id)
            ->update($master_data);
			$data['status'] = DB::table('tbl_emp_salary')->insertGetId($data);
			
			DB::commit();
			Session::put('message','Data Saved Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Updated Data');
			DB::rollback();
		}
		
		return Redirect::to("/staff-salary");	


		//echo '<pre>';
		//print_r($data);
		//exit;

		/*
		$emp_id			= request('emp_id');
		
		$max_sarok = DB::table('tbl_emp_salary')
			->where('emp_id', $emp_id)
			->max('sarok_no');
		
		$up_data = array();
		
		$up_data['emp_id'] 			= request('emp_id');
		$up_data['sarok_no'] 		= $max_sarok;
		
		$up_data['salary_basic'] 	= request('salary_basic');
		$up_data['plus_item_id'] 	= $data['plus_item_id'];
		$up_data['minus_item_id']	= $data['minus_item_id'];
		
		$up_data['plus_item'] 		= $data['plus_item'];
		$up_data['minus_item'] 		= $data['minus_item'];
		
		$up_data['payable'] 		= request('payable');
		
		$up_data['total_minus'] 	= request('total_minus');
		$up_data['net_payable'] 	= request('net_payable');
		$up_data['others_total_plus'] = request('others_total_plus');
		$up_data['gross_total'] 	= request('gross_total');
		$status = DB::table('tbl_emp_salary')
				->where('sarok_no', $max_sarok)
				->update($up_data);
			
					
		echo 'Updated';	

		*/		

		
	}	
	
	public function update(Request $request)
	{
		
		/*$data = request()->except(['_token','submit','salary_br_code','plus_item','minus_item','id']);
		$plus_item_id 			= request('plus_item_id');
		$plus_item 				= request('plus_item');
		
		$minus_item_id 			= request('minus_item_id');
		$minus_item 			= request('minus_item');

		if($plus_item_id)
		{
			$data['plus_item_id'] 	= implode(",", $plus_item_id);   
			$data['plus_item'] 		= implode(",", $plus_item);	
		}else{
			$data['plus_item_id'] 	= '';   
			$data['plus_item'] 		= '';
		}
		
		if($minus_item_id)
		{
			$data['minus_item_id'] 	= implode(",", $minus_item_id);   
			$data['minus_item'] 	= implode(",", $minus_item);
		}else{
			$data['minus_item_id'] 	= '';   
			$data['minus_item'] 	= '';
		}*/

		
		$id 							= request('id');
		$emp_id 						= request('emp_id');
		$sarok_no 						= request('sarok_no');
		
		$master_data['salary_br_code'] 	= request('salary_br_code');
		$master_data['effect_date'] 	= request('effect_date');
		$master_data['letter_date'] 	= request('letter_date');	

		$salary_data['effect_date'] 	= request('effect_date');
		$salary_data['letter_date'] 	= request('letter_date');
		
	
		DB::beginTransaction();
		try {			
			DB::table('tbl_master_tra')
            ->where('sarok_no', $sarok_no)
			->where('emp_id', $emp_id)
            ->update($master_data);
			
			DB::table('tbl_emp_salary')
					->where('id', $id)
					->update($salary_data);
			DB::commit();
			Session::put('message','Data Updated Successfully');
		} catch (\Exception $e) {
			Session::put('message','Error: Unable to Updated Data');
			DB::rollback();
		}
		
		return Redirect::to("/staff-salary");
		
		
		
		
		
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
	
	//Salary Update
	
	public function salary_update(Request $request)
    {

        $all_result = DB::table('tbl_master_tra as m')
            ->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
            ->whereNull('r.emp_id')
            ->orWhere('r.effect_date', '>', date("Y-m-d"))
            ->select('m.emp_id')
            ->groupBy('m.emp_id')
            ->get();

//dd($all_result);
        $i = 0;
        $festive_amount = 0;
        if (!empty($all_result)) {
            foreach ($all_result as $result) {

                $data =array();
                $emp_id = $result->emp_id;
                $effect_date = date("Y-m-d") ;
                if($emp_id != null){

                    $data = array();

//                    $max_id = DB::table('tbl_master_tra')
//                        ->where('emp_id', "=", "425")
//                        ->where('effect_date','<=', "$effect_date")
//                        ->whereBetween('tran_type_no', '=', array("1", "4"))
//                        ->max('sarok_no');
//dd($max_id);
                    $max_sarok = DB::table('tbl_master_tra')
                        ->where('emp_id', '=', $emp_id)
                        ->where('br_join_date', '<=', $effect_date)
                        ->whereBetween('tran_type_no', ['1', '4'])
                        ->select('emp_id', DB::raw('max(br_join_date) as br_join_date'), DB::raw('max(sarok_no) as sarok_no'))
                        ->groupBy('emp_id')
                        ->first();
//dd($max_sarok);

                    if(!empty($max_sarok)) // IF Employee Has any Tran-sectional Data
                    {
                        $employee_info = DB::table('tbl_master_tra')
                            ->join('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'tbl_master_tra.emp_id')
                            ->join('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_master_tra.designation_code')
                            ->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_master_tra.br_code')
                            ->join('tbl_grade_new', 'tbl_grade_new.grade_code', '=', 'tbl_master_tra.grade_code')
                            ->leftJoin('tbl_resignation', 'tbl_resignation.emp_id', '=', 'tbl_master_tra.emp_id')
                            ->leftJoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_master_tra.emp_id')
                            ->where('tbl_master_tra.sarok_no', $max_sarok->sarok_no)
                            ->select('tbl_master_tra.id','tbl_master_tra.emp_id','tbl_master_tra.sarok_no','tbl_master_tra.next_increment_date','tbl_master_tra.designation_code','tbl_master_tra.br_code','tbl_master_tra.salary_br_code','tbl_master_tra.grade_code','tbl_master_tra.grade_step','tbl_master_tra.department_code','tbl_master_tra.report_to','tbl_master_tra.is_permanent','tbl_emp_basic_info.emp_name_eng','tbl_emp_basic_info.father_name','tbl_emp_basic_info.org_join_date','tbl_emp_photo.emp_photo','tbl_designation.designation_name','tbl_branch.branch_name','tbl_grade_new.grade_name','tbl_resignation.effect_date','tbl_master_tra.tran_type_no','tbl_master_tra.basic_salary')
                            ->first();



                        $data['id'] 					= '';
                        $data['emp_id'] 				= $emp_id;
                        $data['effect_date'] 			= $effect_date;
                        $data['emp_name'] 				= $employee_info->emp_name_eng;
                        $data['joining_date'] 			= $employee_info->org_join_date;
                        $data['designation_code'] 		= $employee_info->designation_code;
                        $data['designation_name'] 		= $employee_info->designation_name;
                        $data['department_code'] 		= $employee_info->department_code;
                        $data['report_to'] 				= $employee_info->report_to;
                        $data['resign_date'] 			= $employee_info->effect_date;
                        $data['br_code'] 				= $employee_info->br_code;
                        $data['salary_br_code'] 		= $employee_info->salary_br_code;
                        $data['grade_code'] 			= $employee_info->grade_code;
                        $data['grade_step'] 			= $employee_info->grade_step;
                        $data['branch_name'] 			= $employee_info->branch_name;
                        $data['grade_name'] 			= $employee_info->grade_name;
                        $data['basic_salary'] 			= $employee_info->basic_salary;
                        $data['tran_type_no'] 			= $employee_info->tran_type_no;
                        $data['sarok_no'] 				= $employee_info->sarok_no;
                        $data['is_permanent'] 			= $employee_info->is_permanent;


                        //echo '<pre>';
                        //print_r($data['grade_code']);
                        //exit;


                        if($employee_info->salary_br_code == 9999)
                        {
                            $ho_bo = 0;
                        }
                        elseif($employee_info->salary_br_code == 9997)
                        {
                            $ho_bo = 3;
                        }
                        elseif($employee_info->salary_br_code > 0)
                        {
                            $ho_bo = 1;
                        }
                        else
                        {
                            $ho_bo = 2;
                        }

                        /////*************//////




                        //echo $is_permanent;
                        //exit;

                        ////////************////////

                        if($employee_info->emp_photo !='')
                        {
                            $data['emp_photo'] = $employee_info->emp_photo;
                        }
                        else
                        {
                            $data['emp_photo'] = 'default.png';
                        }

                        // Probation
                        if($employee_info->is_permanent == 1)
                        {
                            $is_permanent = 1;
                        }
                        elseif($employee_info->salary_br_code == 9997)
                        {
                            $is_permanent = 1;
                        }
                        // Permanent
                        elseif($employee_info->is_permanent == 2)
                        {
                            $is_permanent = 2;
                        }
                        // Masterrole
                        elseif($employee_info->is_permanent == 3)
                        {
                            $is_permanent = 3;
                        }

                        // ALL
                        else
                        {
                            $is_permanent = 0;
                        }

                        /////*********/////////
                        $data['plus_items'] 	= DB::table('tbl_salary_plus as plus')
                            ->join('tbl_plus_items as item', 'item.item_id', '=', 'plus.item_name')
                            // DESIGNATION
                            ->where([
                                ['plus.active_from', 	'<=', $effect_date],
                                ['plus.active_upto', 	'>=', $effect_date],
                                ['plus.status', 		'=', 1],
                                ['plus.ho_bo', 			'=', $ho_bo],
                                //['plus.epmloyee_status','=', $is_permanent],
                                ['plus.designation_for','=', $data['designation_code']],
                            ])
                            // GRADE
                            ->orwhere([
                                ['plus.active_from', 	'<=', $effect_date],
                                ['plus.active_upto', 	'>=', $effect_date],
                                ['plus.status', 		'=', 1],
                                ['plus.ho_bo', 			'=', $ho_bo],
                                //['plus.epmloyee_status','=', $is_permanent],
                                ['plus.designation_for','=', 0],
                                ['plus.emp_grade', 		'=', $data['grade_code']]
                            ])
                            // HO/ BO
                            ->orwhere([
                                ['plus.active_from', 	'<=', $effect_date],
                                ['plus.active_upto', 	'>=', $effect_date],
                                ['plus.status', 		'=', 1],
                                ['plus.ho_bo', 			'=', $ho_bo],
                                ['plus.epmloyee_status','=', $is_permanent],
                            ])
                            ->get();



                        $data['minus_items'] 	= DB::table('tbl_salary_minus as minus')
                            ->join('tbl_minus_items as item', 'item.item_id', '=', 'minus.item_name')
                            ->where([
                                ['minus.active_from', 	'<=', $effect_date],
                                ['minus.active_upto', 	'>=', $effect_date],
                                ['minus.status', 		'=', 1],
                                ['minus.ho_bo', 			'=', $ho_bo],
                                ['minus.epmloyee_status','=', $is_permanent]
                            ])
                            ->get();

                        if($is_permanent === 1)
                        {
                            $basic_calculation 		= 0;
                        }
                        else
                        {
                            $basic_calculation 		= $data['basic_salary'];
                        }
                        // PLUS ITEMS
                        $plus_ids =array();
                        $plus_amounts =array();
                        foreach($data['plus_items'] as $v_plus_items) {

                            if($v_plus_items->type == 2)
                            {
                                $plus_id = $v_plus_items->id;
                                $plus_amount = $v_plus_items->fixed_amount;

                            }
                            else
                            {
                                $plus_amount = round(($basic_calculation*$v_plus_items->percentage)/100);
                                $plus_id = $v_plus_items->id;
                            }
                            $plus_ids[] = $plus_id;
                            $plus_amounts[] = $plus_amount;
                        }

                        $update['plus_item_id']=implode(",", $plus_ids);
                        $update['plus_item']=implode(",", $plus_amounts);
                        //MINUS ITEMS
                        $minus_ids =array();
                        $minus_amounts =array();
                        foreach($data['minus_items'] as $v_minus_items) {
                            if($v_minus_items->type == 2)
                            {
                                $minus_amount = $v_minus_items->fixed_amount;
                                $minus_id = $v_minus_items->id;
                            }
                            else
                            {
                                $minus_amount = round(($basic_calculation*$v_minus_items->percentage)/100);
                                $minus_id = $v_minus_items->id;
                            }
                            $minus_ids[] = $minus_id;
                            $minus_amounts[] = $minus_amount;
                        }
                        $update['minus_item_id']=implode(",", $minus_ids);
                        $update['minus_item']=implode(",", $minus_amounts);
                    }

                    if($data['tran_type_no'] != 1) {
                        DB::table('tbl_emp_salary')->where('sarok_no', '=', $max_sarok->sarok_no)->update($update);
                        $i++;
                    }
                }
            }

            dd(($i));

        }

//        return view('admin.festival.festival_form', get_defined_vars());

    }
	// End Salary Update
	
}
