<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class Grade_staffController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}	
	
	public function index()
    {
		$data = array();
		$data['Heading'] 		= '';
		$data['action'] 		= '/grade-staff-list';
		$data['method'] 		= '';
		$data['method_control'] = '';
		
		$data['grades'] = DB::table('tbl_grade')
					  ->select('*')
					  ->where('status',1) 
                      ->get();
		return view('admin.reports.grade_wise_staff',$data);
    }
	

	public function show_report($grade,$date_within)
	{
		$data = array();
		$data['grade'] 					= $grade;
		$data['date_within'] 			= $date_within;
		
		$m_sarok = DB::table('tbl_master_tran as mt')
					//->where('mt.grade_code', '=', $grade)
					->where('mt.letter_date', '<=', $date_within)
					->where('mt.letter_date', '<=', $date_within)
					->select('mt.emp_id', DB::raw('max(sarok_no) as sarok_no'))
					->groupBy('mt.emp_id')
					->get();
					
		foreach($m_sarok as $v_m_sarok)
		{
			//echo $v_m_sarok->emp_id;
			//echo $v_m_sarok->sarok_no;
			
			if($grade == 'All')
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
									->where('mt.grade_code', '=', $grade)
									->select('mt.id','mt.emp_id','mt.sarok_no','mt.next_increment_date','mt.designation_code','mt.br_code','mt.grade_code','mt.grade_step','mt.department_code','mt.report_to','mt.is_permanent','mt.basic_salary','e.emp_name_eng','e.father_name','e.org_join_date','g.grade_name','s.scale_name','r.effect_date','d.designation_name','b.branch_name') 
									->get();
			}
									
		}
					
		
		//print_r($data['result']);
		//exit;	
	
		return view('admin.reports.grade_wise_staff_list',$data);
		
		

	}	

}
