<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class Customized_reportController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}	
	
	public function index()
    {
		$data = array();
		$data['Heading'] 		= '';
		$data['action'] 		= '/employee-appointment';
		$data['method'] 		= '';
		$data['method_control'] = '';
		return view('admin.reports.customized',$data);
    }
	
    public function report_category($report_category) 
    {
		if($report_category == 1)
		{
			$table 	= 'tbl_grade';
			$select = array('id as id','grade_name as name');			
		}
		elseif($report_category == 2)
		{
			$table = 'tbl_scale';
			$select = array('id as id','scale_name as name');
		}
		elseif($report_category == 3)
		{
			$table = 'tbl_designation';
			$select = array('id as id','designation_name as name');
		}
		elseif($report_category == 4)
		{
			$table = 'tbl_department';
			$select = array('id as id','department_name as name');
		}
		elseif($report_category == 5)
		{
			$table = 'tbl_district';
			$select = array('district_code as id','district_name as name');
		}	

		
		
		$results = DB::table($table)
					  ->select($select)
					  //->where('district_code',$district_id) 
                      ->get();
					  	  
		echo "<option value=''>-- All --</option>";
		foreach($results as $result){
			echo "<option value='$result->id'>$result->name</option>";
		}
    }

	public function show_report_customized($report_category,$emp_sub_category,$date_within)
	{
		if($report_category == 1)
		{
			$table 			= 'tbl_grade';
			$where_column 	= 'mt.grade_code';
		}
		elseif($report_category == 2)
		{
			$table 			= 'tbl_scale';
			$where_column 	= 's.id';
		}
		elseif($report_category == 3)
		{
			$table 			= 'tbl_designation';
			$where_column 	= 'mt.designation_code';
		}
		elseif($report_category == 4)
		{
			$table 			= 'tbl_department';
			$where_column 	= 'mt.department_code';
		}
		elseif($report_category == 5)
		{
			$table 			= 'tbl_district';
			$where_column 	= 'e.district_code';
		}
		
		
		$data = array();
		$data['emp_sub_category'] 		= $emp_sub_category;
		$data['date_within'] 			= $date_within;
		
		$m_sarok = DB::table('tbl_master_tran as mt')
					->where('mt.letter_date', '<=', $date_within)
					->where('mt.letter_date', '<=', $date_within)
					->select('mt.emp_id', DB::raw('max(sarok_no) as sarok_no'))
					->groupBy('mt.emp_id')
					->get();
					
		foreach($m_sarok as $v_m_sarok)
		{
			//echo $v_m_sarok->emp_id;
			//echo $v_m_sarok->sarok_no;
			
			if($emp_sub_category == 'All')
			{
				$data['result'] = DB::table('tbl_master_tran as mt')
									->join('tbl_emp_basic_info as e', 'e.emp_id', '=', 'mt.emp_id')
									->join('tbl_grade as g', 'g.id', '=', 'mt.grade_code')
									->join('tbl_scale as s', 's.scale_id', '=', 'g.scale_id')
									->join('tbl_designation as d', 'd.id', '=', 'mt.designation_code')
									->join('tbl_branch as b', 'b.br_code', '=', 'mt.br_code')
									->leftjoin('tbl_resignation as r', 'r.emp_id', '=', 'mt.emp_id')
									->where('mt.sarok_no', '=', $v_m_sarok->sarok_no)
									->select('mt.id','mt.emp_id','mt.sarok_no','mt.next_increment_date','mt.designation_code','mt.br_code','mt.grade_code','mt.grade_step','mt.department_code','mt.report_to','mt.is_permanent','mt.basic_salary','e.emp_name_eng','e.father_name','e.org_join_date','g.grade_name','s.scale_name','r.effect_date','d.designation_name','b.branch_name') 
									->get();
			}
			else
			{
				$data['result'] = DB::table('tbl_master_tran as mt')
									->join('tbl_emp_basic_info as e', 'e.emp_id', '=', 'mt.emp_id')
									->join('tbl_grade as g', 'g.id', '=', 'mt.grade_code')
									->join('tbl_scale as s', 's.scale_id', '=', 'g.scale_id')
									->join('tbl_designation as d', 'd.id', '=', 'mt.designation_code')
									->join('tbl_branch as b', 'b.br_code', '=', 'mt.br_code')
									->leftjoin('tbl_resignation as r', 'r.emp_id', '=', 'mt.emp_id')
									->where('mt.sarok_no', '=', $v_m_sarok->sarok_no)
									->where($where_column, '=', $emp_sub_category)
									->select('mt.id','mt.emp_id','mt.sarok_no','mt.next_increment_date','mt.designation_code','mt.br_code','mt.grade_code','mt.grade_step','mt.department_code','mt.report_to','mt.is_permanent','mt.basic_salary','e.emp_name_eng','e.father_name','e.org_join_date','g.grade_name','s.scale_name','r.effect_date','d.designation_name','b.branch_name') 
									->get();
			}
									
		}			
			
		return view('admin.reports.grade_wise_staff_list',$data);			
					
		//echo '<pre>';
		//print_r($m_sarok);		
		
		

		
		//echo $table;
		//echo '<br>';
		//echo $emp_sub_category;
		//echo '<br>';
		//echo $date_within;
		
		/*$results = DB::table('tbl_master_tran')
					  ->select('*')
					  ->where($where_column,$emp_sub_category) 
                      ->get();*/
					  
		/*$results =		 DB::table('tbl_master_tran')
						->join('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'tbl_master_tran.emp_id')
						->join('tbl_designation', 'tbl_designation.id', '=', 'tbl_master_tran.designation_code')
						->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_master_tran.br_code')
						->join('tbl_grade', 'tbl_grade.id', '=', 'tbl_master_tran.grade_code')
						->join('tbl_scale', 'tbl_scale.scale_id', '=', 'tbl_grade.scale_id')
						->join('tbl_district', 'tbl_district.district_code', '=', 'tbl_emp_basic_info.district_code')
						->leftjoin('tbl_resignation', 'tbl_resignation.emp_id', '=', 'tbl_master_tran.emp_id')
						->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_master_tran.emp_id')
						 ->where($where_column,$emp_sub_category) 
						 //->where('tbl_master_tran.effect_date',$date_within) 
						->select('tbl_master_tran.id','tbl_master_tran.emp_id','tbl_master_tran.sarok_no','tbl_master_tran.next_increment_date','tbl_master_tran.designation_code','tbl_master_tran.br_code','tbl_master_tran.grade_code','tbl_master_tran.grade_step','tbl_master_tran.department_code','tbl_master_tran.report_to','tbl_master_tran.is_permanent','tbl_emp_basic_info.emp_name_eng','tbl_emp_basic_info.father_name','tbl_emp_basic_info.org_join_date','tbl_emp_photo.emp_photo','tbl_designation.designation_name','tbl_branch.branch_name','tbl_grade.grade_name','tbl_scale.scale_name','tbl_scale.scale_basic_1st_step','tbl_scale.increment_amount','tbl_resignation.effect_date','tbl_district.district_code','tbl_district.district_name') 
						->get();
				
						
					  
		echo "<table width='100%' border='1'><tr><th>No</th><th>Employee Id</th><th>Employee Name</th><th>Joined Date</th><th>Branch</th><th>Designation</th></tr>";
		echo "<tr>";
		if(!empty(count($results))){
			foreach($results as $result)
			{				
				echo "<td>No</td>";
				echo "<td>$result->emp_id</td>";
				echo "<td>$result->emp_name_eng</td>";
				echo "<td>$result->org_join_date</td>";
				echo "<td>$result->branch_name</td>";
				echo "<td>$result->designation_name</td>";
			}
		}
		else
		{
			echo "<td colspan='6' align='center'>No Employee Found</td>";
		}
		echo "<tr>";
		echo "</table>";

		//print_r($results);*/
		
	}	

}
