<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class Recruitment_reportsController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}	
	
	public function index()
    {
		$data = array();
		$data['Heading'] 		= '';
		$data['action'] 		= '/recruitment_show_report'; 
		$data['result'] 		= '';
		$data['district_code']  = 'All';
		$data['post_id']   		= 'All';
		$data['zone_id']   		= 'All';
		$data['all_zone'] = DB::table('tbl_recruitment_division')
					  ->select('*')
					  ->where('status',1) 
                      ->get();
		$data['all_districts'] = DB::table('tbl_district')
					  ->select('*')
					  ->where('status',1) 
                      ->get();
		$data['all_post'] = DB::table('tbl_recruit_circular_post')
					  ->select('*')
					  ->where('status',1) 
                      ->get();
		return view('admin.reports.recruitment.recruitment_staff',$data);
    }
	

	public function recruitment_show_report(Request $request)
	{
		$data = array();
		$data['action'] 		= '/recruitment_show_report'; 
		$data['all_zone'] = DB::table('tbl_recruitment_division')
					  ->select('*')
					  ->where('status',1) 
                      ->get();
		$data['all_districts'] = DB::table('tbl_district')
					  ->select('*')
					  ->where('status',1) 
                      ->get();
		$data['all_post'] = DB::table('tbl_recruit_circular_post')
					  ->select('*')
					  ->where('status',1) 
                      ->get();
		$data['district_code'] 	= $district_code 	= $request->district_code;
		$data['post_id'] 		= $post_id 		= $request->post_id;
		$data['zone_id'] 		= $zone_id 		= $request->zone_id;
		/* echo '<pre>';
		print_r($district_code);
		exit;  */
		$status = 1;
		$data['all_divisions'] = DB::table('tbl_recruitment_division')
					 ->where('tbl_recruitment_division.status',1)
								->whereIn('tbl_recruitment_division.id', function($query)  use ($status,$district_code,$post_id,$zone_id){
								  $query->select('d.division_code')
								  ->from('tbl_recruitment_basic')
								  ->leftJoin('tbl_district as d', 'tbl_recruitment_basic.district_code', '=', 'd.district_code') 
								   ->where(function($query1) use ($district_code)
									{
										if ($district_code != 'All') {
											$query1->where('tbl_recruitment_basic.district_code',  $district_code);
										}  
									})    
									->where(function($query2) use ($post_id)
									{
										if ($post_id != 'All') {
											$query2->where('tbl_recruitment_basic.post_id',  $post_id);
										}  
									}) 
									 ->where(function($query) use ($zone_id)
										{
											if ($zone_id != 'All') {
												$query->where('d.division_code',  $zone_id);
											}  
										})									
								  ->where('d.status',$status);
								})
								->select('tbl_recruitment_division.*') 
								->get(); 
		
		$result = DB::table('tbl_recruitment_basic as rb')
				->leftJoin('tbl_recruitment_circular as rc', 'rb.circular_id', '=', 'rc.id') 
				->leftJoin('tbl_recruit_circular_post as cp', 'rb.post_id', '=', 'cp.id') 
				->leftJoin('tbl_district as d', 'rb.district_code', '=', 'd.district_code') 
				->leftJoin('tbl_recruitment_division as rd', 'rd.id', '=', 'd.division_code') 
				->where(function($query) use ($district_code)
					{
						if ($district_code != 'All') {
							$query->where('rb.district_code',  $district_code);
						}  
					})
				->where(function($query) use ($post_id)
					{
						if ($post_id != 'All') {
							$query->where('rb.post_id',  $post_id);
						}  
					})
			   ->where(function($query) use ($zone_id)
					{
						if ($zone_id != 'All') {
							$query->where('d.division_code',  $zone_id);
						}  
					})
				->orderby('rb.new_recruitment_id','asc')
				->select('rb.*','d.division_code','d.district_name','rc.end_date','cp.post_name')
				->get(); 
				/*     echo '<pre>';
				print_r($result); */
//exit;				 
				 
			foreach($result as $result1){
				$id = $result1->id;
				
				$result_edu =  DB::select("SELECT ex.exam_name,edu.cgpa,edu.result,bu.board_uni_name
				FROM tbl_recruitment_basic rb  
				LEFT JOIN	tbl_recruitment_edu as edu on rb.id = edu.recruitment_id  
				LEFT JOIN	tbl_exam_name as ex on edu.exam_code = ex.exam_code 
				LEFT JOIN	tbl_board_university as bu on edu.school_code = bu.board_uni_code  
					where edu.id = (SELECT MAX(id) FROM tbl_recruitment_edu WHERE recruitment_id = rb.id) AND edu.recruitment_id = $id"); 
				/* echo '<pre>';
				print_r($result_edu);
				exit;  */
				$result_exp =  DB::select("SELECT exp.designation,exp.experience_period,exp.remarks,exp.organization_name
				FROM tbl_recruitment_basic rb  
				LEFT JOIN	tbl_recruitment_exp as exp on rb.id = exp.recruitment_id 
				where exp.id = (SELECT MAX(id) FROM tbl_recruitment_exp WHERE recruitment_id = rb.id) AND exp.recruitment_id = $id");
			  $exam_name = '';
				$cgpa = '';
				$result = '';
				$board_uni_name = '';
			foreach($result_edu as $v_result_edu){
				$exam_name = $v_result_edu->exam_name;
				$cgpa = $v_result_edu->cgpa;
				$result = $v_result_edu->result;
				$board_uni_name = $v_result_edu->board_uni_name;
			}
			    $designation = '';
				$experience_period = '';
				$remarks = ''; 
				$organization_name = ''; 
			foreach($result_exp as $v_result_exp){
				$designation = $v_result_exp->designation;
				$experience_period = $v_result_exp->experience_period;
				$remarks = $v_result_exp->remarks; 
				$organization_name = $v_result_exp->organization_name; 
				 
			} 
		 
				$data['total_result'][] =array( 
						'new_recruitment_id' => $result1->new_recruitment_id, 
						'full_name' => $result1->full_name, 
						'father_name' => $result1->father_name, 
						'birth_date' => $result1->birth_date, 
						'district_name' => $result1->district_name, 
						'division_code' => $result1->division_code, 
						'post_name' => $result1->post_name, 
						'cgpa' => $cgpa, 
						'exam_name' => $exam_name, 
						'result' => $result, 
						'board_uni_name' => $board_uni_name, 
						'designation' => $designation, 
						'organization_name' => $organization_name, 
						'experience_period' => $experience_period, 
						'contact_num' => $result1->contact_num, 
						'remarks' => $remarks, 
						'end_date' => $result1->end_date
					);
			}
		/*  echo '<pre>';
				print_r($data['total_result']);
exit;		 */			
		return view('admin.reports.recruitment.recruitment_staff',$data);
		
		

	}	

}
