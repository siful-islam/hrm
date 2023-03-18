<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class BranchwiseregisterreportController extends Controller
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
		$data['Heading'] = $data['title'] = 'Branchwise Register Report';
		$data['form_date']	= date('Y-m-d');	
		$data['status']		= '';
		/* print_r($data);
		exit;	 */	
		return view('admin.pages.reports.branchwiseregister',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function branch_wise_register_post(Request $request)
    { 
	    $data = array();
		$data['Heading'] = $data['title'] = 'Branchwise Register Report';
		$data['form_date'] 	= $form_date = $request->input('form_date');
		$form_date              = date("Y-m-t",strtotime($form_date));
		 
		 
		
		$all_result=DB::select(DB::raw("SELECT
											  `main_br_code`,
											  `br_id`,
											  `branch_name`,
											  sum(IF(`designation_code` = '11', `total`, 0)) AS `FO`,
											  sum(IF(`designation_code` = '192', `total`, 0)) AS `JFO`,
											  sum(IF(`designation_code` = '16', `total`, 0)) AS `Acc`,
											  sum(IF(`designation_code` = '170', `total`, 0)) AS `Medo`
										FROM (
											SELECT
												tbl_branch.main_br_code,
												tbl_branch.br_id,
												tbl_branch.branch_name,
												tbl_designation.designation_name,
												tbl_br_fo_register.designation_code,
												COUNT(distinct(tbl_br_fo_register.emp_id)) AS total
											FROM
												`tbl_br_fo_register`
											LEFT JOIN tbl_branch ON tbl_branch.br_code=tbl_br_fo_register.br_code
											LEFT JOIN tbl_designation ON tbl_designation.designation_code=tbl_br_fo_register.designation_code
												where tbl_br_fo_register.month =  '".$form_date."' AND tbl_br_fo_register.is_register =  1 AND tbl_br_fo_register.emp_id NOT IN(SELECT 
											emp_id 
										FROM 
											`tbl_br_fo_register` 
										where 
											emp_id in (
												SELECT 
													emp_id 
												FROM 
													`tbl_resignation` 
												WHERE 
													effect_date <= '".$form_date."'
											))
												GROUP BY
												tbl_branch.main_br_code,
												tbl_br_fo_register.designation_code
										) as main
										GROUP BY `main_br_code`
										ORDER BY `br_id` ASC")); 
 		/*  echo "<pre>";
		 print_r($all_result);
		 exit; 
		  */
			$data['all_result'] = $all_result;
		 
		//print_r ($data['all_result']); exit;
		return view('admin.pages.reports.branchwiseregister',$data);
    } 	
}
