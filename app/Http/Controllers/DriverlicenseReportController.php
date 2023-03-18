<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class DriverlicenseReportController extends Controller
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
		$data['Heading'] 		= 'Driving License Report';
		$data['all_result'] 	= '';
		$data['br_code']		= '';	
		$data['form_date']		= date('Y-m-d');	
		//$data['status']			= '';
		$data['all_branch'] 	= '';
		$data['area_code'] 		= '';
		$data['branches'] 		= DB::table('tbl_branch')->where('status',1)->orderBy('branch_name', 'ASC')->get();
		$data['areas'] 			= DB::table('tbl_area')->where('status',1)->get();		
		return view('admin.document.driver_license_report',$data);
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
        return view('admin.pages.reports.branch_staff_report',$data);
    }
	
	public function drivier_license_search_report(Request $request)
    {
        $data1 = array();
        $data2 = array();
        $data = array();
		//$data['all_result_driver_license'] =  array();
		$data['Heading'] 		= 'Driving License Report';
		$data['br_code'] 		= $br_code = $request->input('br_code');
		$data['form_date'] 		= $form_date = date('Y-m-d');
		//$data['status'] 		= $request->input('status');
		$data['all_result_driver_license'] 		= '';
		$data['area_code'] 		= $area_code = $request->input('area_code');
		$data['branches'] 		= DB::table('tbl_branch')->orderBy('branch_name', 'ASC')->get();
		$data['areas'] 			= DB::table('tbl_area')->where('status',1)->get();
		
		/*  echo '<pre>';
			print_r ($data['br_code']);
			exit;  */
		if($area_code == 'all'){
			$data['all_branch']     = $all_branch = DB::table('tbl_branch')
												//->where('area_code', '=', $data['area_code'])
												->orderBy('branch_name', 'asc')
												->select('br_code','branch_name')
												->get();
			foreach($all_branch as $branch){
				$all_result = DB::table('tbl_master_tra as m')
								->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
								->where('m.br_code', '=', $branch->br_code)
								->where('m.br_join_date', '<=', $form_date)
								->whereNull('r.emp_id')
								->orWhere('r.effect_date', '>', $data['form_date'])
								->select('m.emp_id')
								->groupBy('m.emp_id')
								->get();
					if (!empty($all_result)) { 
							$data['all_result_driver_license'] =  array();
							foreach ($all_result as $result) {
								
								 
												
								   $emp_id = $result->emp_id;
									$max_sarok = DB::table('tbl_master_tra as m')
													->where('m.emp_id', '=', $result->emp_id)
													->where('m.br_join_date', '=', function($query) use ($emp_id,$form_date)
															{
																$query->select(DB::raw('max(br_join_date)'))
																	  ->from('tbl_master_tra')
																	  ->where('emp_id',$emp_id)
																	  ->where('br_join_date', '<=', $form_date);
															})
													->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
													->groupBy('emp_id')
													->first();
								$emp_info = DB::table('tbl_master_tra as m') 
											->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id')   
											->leftjoin('tbl_edms_driver_license as dl',function($join){
												$join->on("m.emp_id","=","dl.emp_id") 
													->where('dl.license_exp_date',DB::raw("(SELECT 
																				  max(license_exp_date)
																				  FROM tbl_edms_driver_license 
																				   where m.emp_id = emp_id
																				  )") 		 
															); 
														})					 
											->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
											->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
											->leftJoin('tbl_area as ar', 'b.area_code', '=', 'ar.area_code') 
											->where('m.sarok_no', '=', $max_sarok->sarok_no)
											->select('emp.emp_id','dl.emp_id as emp_id1','dl.dri_license_id','emp.emp_name_eng as emp_name','b.br_code','ar.area_name','ar.area_code','d.designation_name','d.designation_code','b.branch_name','dl.license_number','dl.license_exp_date')
											->first(); 
								 if(!empty($emp_info->emp_id1)){
									 if($emp_info->br_code == $branch->br_code){
										
										 $data['all_result_driver_license'][] = array(
															'dri_license_id'     => $emp_info->dri_license_id,
															'emp_id' 			 => $result->emp_id,
															'type_name' 		 => 'Regular',
															'emp_name'       	 => $emp_info->emp_name, 
															'license_exp_date'   => $emp_info->license_exp_date,
															'license_number'     => $emp_info->license_number,
															'designation_name'   => $emp_info->designation_name,
															'br_code'        	 => $emp_info->br_code, 
															'area_code'        	 => $emp_info->area_code, 
															'area_name'        	 => $emp_info->area_name, 
															'branch_name'        => $emp_info->branch_name 
														);  
									  array_push($data1,$emp_info->br_code);
									  if($emp_info->area_code){
										  array_push($data2,$emp_info->area_code);
									  }else{
										  array_push($data2,0);
									  }
									  
									  
									}
									
								 }
								
										
							}
							 
						} 
					$data['total_in_area'] = $data2;	
					} 
			}else{
				$data['all_branch'] = $all_branch = DB::table('tbl_branch')
												->where('area_code', '=', $data['area_code'])
												->orderBy('branch_name', 'asc')
												->select('br_code','branch_name')
												->get();
			  if(!empty($br_code)){
					$all_result = DB::table('tbl_master_tra as m')
								->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
								->where('m.br_code', '=', $data['br_code'])
								->where('m.br_join_date', '<=', $form_date)
								->whereNull('r.emp_id')
								->orWhere('r.effect_date', '>', $data['form_date'])
								->select('m.emp_id')
								->groupBy('m.emp_id')
								->get(); 
				
				 if (!empty($all_result)) {
					
					$data['all_result_driver_license'] =  array();
					foreach ($all_result as $result) { 
						   $emp_id = $result->emp_id;
							$max_sarok = DB::table('tbl_master_tra as m')
													->where('m.emp_id', '=', $result->emp_id)
													->where('m.br_join_date', '=', function($query) use ($emp_id,$form_date)
															{
																$query->select(DB::raw('max(br_join_date)'))
																	  ->from('tbl_master_tra')
																	  ->where('emp_id',$emp_id)
																	  ->where('br_join_date', '<=', $form_date);
															})
													->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
													->groupBy('emp_id')
													->first();
						$emp_info = DB::table('tbl_master_tra as m') 
									->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id')  
									->leftjoin('tbl_edms_driver_license as dl',function($join){
												$join->on("m.emp_id","=","dl.emp_id") 
													->where('dl.license_exp_date',DB::raw("(SELECT 
																				  max(license_exp_date)
																				  FROM tbl_edms_driver_license 
																				   where m.emp_id = emp_id
																				  )") 		 
															); 
														})	
									->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
									->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
									->where('m.sarok_no', '=', $max_sarok->sarok_no)
									->select('emp.emp_id','dl.emp_id as emp_id1','dl.dri_license_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','dl.license_number','dl.license_exp_date')
									->first(); 
						 if(!empty($emp_info->emp_id1)){
							 if($emp_info->br_code == $data['br_code']) {
								$data['all_result_driver_license'][] = array(
									'dri_license_id' 	 => $emp_info->dri_license_id,
									'emp_id' 			 => $result->emp_id,
									'type_name' 		 => 'Regular',
									'emp_name'       	 => $emp_info->emp_name, 
									'license_exp_date'   => $emp_info->license_exp_date,
									'license_number'     => $emp_info->license_number,
									'designation_name'   => $emp_info->designation_name,
									'br_code'  			 => $emp_info->br_code,
									'branch_name'        => $emp_info->branch_name 
								);
								array_push($data1,$emp_info->br_code);
								 
							 } 
							
						 }
						
					
					}
					/* echo '<pre>';
		print_r($data['all_result_driver_license']); */
					//exit;
					
				}  		 			 
				}else{
					$data['all_branch'] = $all_branch = DB::table('tbl_branch')
												->where('area_code', '=', $data['area_code'])
												->orderBy('branch_name', 'asc')
												->select('br_code','branch_name')
												->get();
					foreach($all_branch as $branch){
								$all_result = DB::table('tbl_master_tra as m')
												->leftJoin('tbl_resignation as r', 'm.emp_id', '=', 'r.emp_id')
												->where('m.br_code', '=', $branch->br_code)
												->where('m.br_join_date', '<=', $form_date)
												->whereNull('r.emp_id')
												->orWhere('r.effect_date', '>', $data['form_date'])
												->select('m.emp_id')
												->groupBy('m.emp_id')
												->get();
									if (!empty($all_result)) { 
											foreach ($all_result as $result) {
												
												$emp_id = $result->emp_id;
												$max_sarok = DB::table('tbl_master_tra as m')
														->where('m.emp_id', '=', $result->emp_id)
														->where('m.br_join_date', '=', function($query) use ($emp_id,$form_date)
																{
																	$query->select(DB::raw('max(br_join_date)'))
																		  ->from('tbl_master_tra')
																		  ->where('emp_id',$emp_id)
																		  ->where('br_join_date', '<=', $form_date);
																})
														->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
														->groupBy('emp_id')
														->first(); 
												 
												$emp_info = DB::table('tbl_master_tra as m') 
															->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id') 
															->leftjoin('tbl_edms_driver_license as dl',function($join){
																$join->on("m.emp_id","=","dl.emp_id") 
																	->where('dl.license_exp_date',DB::raw("(SELECT 
																								  max(license_exp_date)
																								  FROM tbl_edms_driver_license 
																								   where m.emp_id = emp_id   
																								  )") 		 
																			); 
																		})	
															->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
															->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code') 
															->where('m.sarok_no', '=', $max_sarok->sarok_no) 
															->select('emp.emp_id','dl.emp_id as emp_id1','dl.dri_license_id','emp.emp_name_eng as emp_name','b.br_code','d.designation_name','d.designation_code','b.branch_name','dl.license_number','dl.license_exp_date')
															->first(); 
												 if(!empty($emp_info->emp_id1)){
													 if($emp_info->br_code == $branch->br_code) {
														 $data['all_result_driver_license'][] = array(
																			'dri_license_id'     => $emp_info->dri_license_id,
																			'emp_id' 			 => $result->emp_id,
																			'type_name' 			 => 'Regular',
																			'emp_name'       	 => $emp_info->emp_name, 
																			'license_exp_date'   => $emp_info->license_exp_date,
																			'license_number'     => $emp_info->license_number,
																			'designation_name'   => $emp_info->designation_name,
																			'br_code'        	 => $emp_info->br_code, 
																			'branch_name'        => $emp_info->branch_name 
																		);  
													  array_push($data1,$emp_info->br_code);

													}
													
												 }
												
														
											}
										} 
									}
						} 
		}
		 /*  echo '<pre>';
		print_r($data1); */
		/* echo '<pre>';
		print_r($data['all_result_driver_license']);
		exit;   */
		$data['tot_branch_in_area'] = $data1; 
		return view('admin.document.driver_license_report',$data);
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
   public function get_branch_by_area($area_code)
    {
       $data = array();
	   $all_branch = DB::table('tbl_branch')
					   ->where('area_code', $area_code)
					   ->where('status', 1)
					   ->orderBy('branch_name', 'ASC')
					   ->get();
	   	echo json_encode(array('data' => $all_branch));
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
