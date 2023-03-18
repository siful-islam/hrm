<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class BranchStaffController extends Controller
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
		$data['action'] 		= '/branch-staff-report';
		$data['Heading'] 		= 'Branch Staff List';
		$data['method'] 		= 'post';
		$data['method_field'] 	= '';
		$data['all_result'] 	= '';
		$data['br_code']		= '';	
		$data['form_date']		= '';	
		$data['status']			= '';
		$data['branches'] 		= DB::table('tbl_branch')->where('status',1)->get();
				
		return view('admin.reports.branch_staff_report',$data);
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
    public function store(Request $request)
    {
        return view('admin.reports.branch_staff_report',$data);
    }
	
	public function BranchStaffReport(Request $request)
    {
        $data = array();
		$data['Heading'] 		= 'Branch Staff List';
		$data['br_code'] 		= $request->input('br_code');
		$data['form_date'] 		= $request->input('form_date');
		$data['status'] 		= $request->input('status');
		$data['branches'] 		= DB::table('tbl_branch')->where('status',1)->get();
		$all_result = DB::table('tbl_master_tran')
						->where('br_code', '=', $data['br_code'])
						->select('emp_id')
						->groupBy('emp_id')
						->get();
		if (!empty($all_result)) {
			foreach ($all_result as $result) {
				$max_exam = DB::table('tbl_emp_edu_info')
					->where('emp_id', '=', $result->emp_id)
					->select('emp_id', DB::raw('max(level_id) as level_id'))
					->groupBy('emp_id')
					->first();
				if (!empty($max_exam)) {
				$exam_result = DB::table('tbl_emp_edu_info as ed')
					->leftJoin('tbl_exam_name as en', 'ed.exam_code', '=', 'en.exam_code')
					->where('ed.emp_id', '=', $max_exam->emp_id)
					->where('ed.level_id', '=', $max_exam->level_id)
					->select('en.exam_name')
					->first();
					//print_r ($exam_result);
					$exam_name = $exam_result->exam_name;
				} else {
					$exam_name = '';
				}	
				$max_sarok = DB::table('tbl_master_tran')
					->where('emp_id', '=', $result->emp_id)
					->where('letter_date', '<=', $data['form_date'])
					->select('emp_id', DB::raw('max(letter_date) as letter_date'), DB::raw('max(sarok_no) as sarok_no'))
					->groupBy('emp_id')
					->first();
					
				$data_result = DB::table('tbl_master_tran as m')
					->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
					->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.id')
					->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
					->where('m.sarok_no', '=', $max_sarok->sarok_no)
					->select('e.emp_name_eng','e.org_join_date','e.permanent_add','m.br_joined_date','d.designation_name','b.branch_name')
					->first();
					
				$data['all_result'][] = array(
						'emp_id' => $result->emp_id,
						'emp_name_eng'      => $data_result->emp_name_eng,
						'permanent_add'      => $data_result->permanent_add,
						'exam_name'      => $exam_name,
						'org_join_date'      => $data_result->org_join_date,
						'br_joined_date'      => $data_result->br_joined_date,
						'designation_name'      => $data_result->designation_name,
						'branch_name'      => $data_result->branch_name
						//'re_effect_date'      => $data_result->effect_date
					);	
			}
		}
		//print_r ($data['all_result']);
		return view('admin.reports.branch_staff_report',$data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
