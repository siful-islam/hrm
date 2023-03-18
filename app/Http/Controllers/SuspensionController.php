<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class SuspensionController extends Controller
{
	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data['all_result'] = DB::table('suspension as sus')
							->leftJoin('tbl_emp_basic_info as e', 'sus.emp_id', '=', 'e.emp_id')
							/* ->select(DB::raw('max(e.emp_name_eng) as emp_name_eng'),DB::raw('MIN(sus.from_date) as from_date'),DB::raw('MAX(sus.to_date) as to_date'),DB::raw('SUM(sus.total_days) as total_days'),'sus.emp_id','sus.id')
							->groupBy('sus.emp_id') */
							->select('sus.*','e.emp_name_eng')
							->get();
		return view('admin.pages.suspension.suspension_list',$data);		
    }

    public function create()
    {
		$data = array();
		$data['action'] 		= '/suspension';
		$data['method'] 		= 'post';
		$data['method_field'] 	= '';
		$data['id'] 			= '';
		
		$data['emp_id'] 			= ''; 
		$data['from_date'] 			= ''; 
		$data['to_date'] 			= ''; 
		$data['emp_name'] 			= ''; 
		$data['total_days'] 		= '';  
		$data['comments'] 			= '';
		 
		//
		$data['Heading'] 	 = 'Add Assign';
		$data['button_text'] = 'Save';
		//
		return view('admin.pages.suspension.suspension_form',$data);	

    } 
	public function edit($id)
    {
		$data = array();
		$data['action'] 		= "/suspension_update/$id";
		$data['method'] 		= 'post';
		$data['method_field'] 	= '';
		$data['id'] 			= '';
		$sus_info = DB::table('suspension as  s') 
						->leftJoin('tbl_emp_basic_info as e', 'e.emp_id', '=', 's.emp_id')
						->where('s.id', $id)
						->select('s.*','e.emp_name_eng as emp_name') 
						->first();
		$data['emp_id'] 			= $sus_info->emp_id; 
		$data['from_date'] 			= $sus_info->from_date; 
		$data['to_date'] 			= $sus_info->to_date; 
		$data['emp_name'] 			= $sus_info->emp_name; 
		$data['total_days'] 		= $sus_info->total_days;  
		$data['comments'] 			= $sus_info->comments; 
		 
		$data['button_text'] = 'Update';
		//
		return view('admin.pages.suspension.suspension_form',$data);	
		
    }  
	public function  suspension_update(Request $request,$id)
    {
		$data = array(); 
		$data['from_date'] 				= $request->input('from_date');
		$data['to_date'] 				= $request->input('to_date');
		$data['total_days'] 		    = $request->input('total_days');
		$data['comments'] 		    	= $request->input('comments');
		$data['updated_by'] 		    = Session::get('admin_id'); 
		$data['salary_month'] 			= date("Y-m-t",strtotime($data['from_date']));
		$status = DB::table('suspension')
				->where('id', $id)
				->update($data);
		Session::put('message','Data Update Successfully');
		return Redirect::to('/suspension'); 
	}
	public function store(Request $request)
    { 
		$data = array(); 
		$r_from_date = array(); 
		$r_to_date = array(); 
		
		$from_date = $request->input('from_date');
		$to_date = $request->input('to_date');
		$data['emp_id'] = $request->input('emp_id'); 
		$data['comments'] = $request->input('comments');
		$data['created_by'] = Session::get('admin_id'); 
		$month_from = date("m",strtotime($from_date));
		$year_from = date("Y",strtotime($from_date));
		$month_year_from = date("m-Y",strtotime($from_date));
		
		$month_to = date("m",strtotime($to_date));
		$year_to = date("Y",strtotime($to_date));
		$month_year_to = date("m-Y",strtotime($to_date));
		 
		$total_month = (($year_to - $year_from) * 12) + ($month_to - $month_from);
		if(( $month_year_to != $month_year_from ) ){	
			$dates = array(); 
			$dates[] = $from_date;
			for($i=0; $i < $total_month - 1; $i++){ 
				$from_date = date('Y-m-01',  strtotime("+1 month", strtotime($from_date))); 
				$dates[] 	= $from_date;
			}
			$dates[] 		= $to_date;
			$last_row 		= count($dates);
			$i = 1;  
			foreach($dates as $v_dates){
				 $first_day = date("d",strtotime($v_dates));
				 
				 if($last_row == $i){
					 $data['from_date'] = date("Y-m-01",strtotime($v_dates));
					 $data['to_date'] = date("Y-m-d",strtotime($v_dates));
					 $data['salary_month'] = date("Y-m-t",strtotime($v_dates)); 
				 }else if($first_day == 01){ 
					 $data['from_date'] = date("Y-m-01",strtotime($v_dates));
					 $data['to_date'] = date("Y-m-t",strtotime($v_dates));
					 $data['salary_month'] = date("Y-m-t",strtotime($v_dates));					 
				 }else{
					  $data['from_date'] = date("Y-m-d",strtotime($v_dates));
					  $data['to_date'] = date("Y-m-t",strtotime($v_dates)); 
					  $data['salary_month'] = date("Y-m-t",strtotime($v_dates));
				 } 
				 $data['total_days'] = $this->day_calculation($data['from_date'],$data['to_date']);
				$i++;
				DB::beginTransaction();
				try { 
					DB::table('suspension')->insert($data); 		
					DB::commit(); 
				}catch (\Exception $e) { 
					DB::rollback();
				}
			} 
		}else{ 
			  $data['from_date'] = $from_date;
			  $data['to_date'] = $to_date;
			  $data['total_days'] = $request->input('total_days');
			  $data['salary_month'] = date("Y-m-t",strtotime($to_date));			  
			  DB::table('suspension')->insert($data); 
		}  
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/suspension');			

    }
	public function day_calculation($from_date,$to_date)
	{
		$date1=date_create($from_date);
		$date2=date_create($to_date);
		$diff=date_diff($date1,$date2); 
		$day_difference = ($diff->format("%R%a")); 
		return $day_difference + 1;
	}   
	public function get_emp_info_sus($emp_id)
	{
		$data = array();
		$effect_date = date("Y-m-d");
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
		
		if(!empty($max_id))
		{
			$emp_info = DB::table('tbl_master_tra as  m')
						->leftJoin('tbl_emp_basic_info as e', 'e.emp_id', '=', 'm.emp_id')
						->where('m.sarok_no', $max_id->sarok_no)
						->select('m.basic_salary','e.emp_name_eng') 
						->first();
			
		
		} 
		//echo $max_id;		
		if(!empty($emp_info)) { 
			$data['emp_id'] 				= $emp_id;
			$data['emp_name'] 				= $emp_info->emp_name_eng; 
			$data['basic_salary'] 			= $emp_info->basic_salary; 
			$data['error'] 					= '';
		
		} else {
			$data['emp_id'] 				= '';
			$data['emp_name'] 				= ''; 
			$data['basic_salary'] 			= 0;
			$data['error'] 					= 1;
		}
		
		return $data;
	}   
}
