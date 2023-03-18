<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Redirect;


class ApitaxvatController extends Controller
{
	
	/* for cdip eye */
	public function vat_tax_branch_staff($emp_id,$emp_type_hr)
    {
        $data = array();
		$form_date = "Y-m-d";
		if($emp_type_hr == 1){
					 
					 
					 
						$emp_info = DB::table('tbl_emp_basic_info as e')
									->where('e.emp_id', '=', $emp_id)
														/* ->where(function($query) use ($user_type, $form_date) {
															if($user_type == 3 || $user_type == 4) {
																$query->whereNull('r.emp_id');
																$query->orWhere('r.effect_date', '>', $form_date);
															}
														}) */
								->select('e.emp_id','e.emp_name_eng')
								->first();
						  
						/* assign information */
							  
							/* $assign_designation = DB::table('tbl_emp_assign as ea')
													->leftJoin('tbl_designation as de', 'ea.designation_code', '=', 'de.designation_code')
													->where('ea.emp_id',$emp_id)
													->where('ea.status', '!=', 0)
													->where('ea.select_type', '=', 5)
													->select('ea.emp_id','ea.open_date','de.designation_name')
													->first();   */
						 /* if(!empty($assign_designation)){
							  $designation_name 	= $assign_designation->designation_name;  
						 }else{
							  $designation_name = $emp_info->designation_name;  
						 } */
						
						$data['emp_id']=  $emp_info->emp_id; 
						$data['emp_name']=  $emp_info->emp_name_eng; 
						//$data['designation_code']=  $designation_name; 
						
						 
							/* echo "<pre>";
							echo $emp_id;
							echo "<pre>";
							print_r($data['employee_info']); */
							
						 	 
				}
		return \Response::json($data);
    } 
}
