<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
//session_start();

class SalarycertificateController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
    
	public function salary_certicate()
    {
	
		$data = array();
		$data['Heading'] = 'Salary Certificate';
		$data['emp_id'] = ''; 
		$data['is_access'] = 1;  
		$data['all_report'] = array(); 
		  
		$data['all_emp_type'] =  DB::table('tbl_emp_type') 
									->where('status',1)		 
									->get(); 
		return view('admin.employee.salary_certif',$data);
    }
	public function salary_certicate_emo_info(Request $request)
    {
		$u_user_type 	= Session::get('user_type'); // 3=dm,4=am,5=bm
		$current_date = date('Y-m-d');
		$data['emp_id'] = $emp_id 		= $request->emp_id;   
		$data['Heading'] = 'Salary Certificate';
		$data['all_emp_type'] =  DB::table('tbl_emp_type') 
									->where('status',1)		 
									->get();
									
							
									
		$designation_group_code = '';	
		$area_code = '';	
		$zone_code = '';							
		$is_branch = 1;		 
						$max_sarok = DB::table('tbl_master_tra as m')
										->where('m.emp_id', '=', $emp_id)
										->where('m.br_join_date', '=', function($query) use ($emp_id,$current_date)
												{
													$query->select(DB::raw('max(br_join_date)'))
														  ->from('tbl_master_tra')
														  ->where('emp_id',$emp_id)
														  ->where('br_join_date', '<=', $current_date);
												})
										->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
										->groupBy('emp_id')
										->first();
						if(!empty($max_sarok)){
						$emp_info = DB::table('tbl_master_tra as m') 
											->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id') 
											->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
											->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
											->leftJoin('tbl_area as ar', 'b.area_code', '=', 'ar.area_code')
											->leftJoin('tbl_zone as zb', 'ar.zone_code', '=', 'zb.zone_code') 
											->where('m.sarok_no', '=', $max_sarok->sarok_no)
											->select('emp.emp_id','emp.emp_name_eng as emp_name','zb.zone_code','b.br_code','m.salary_br_code','ar.area_code','d.designation_name','d.designation_code','d.designation_group_code','b.branch_name')
											->first(); 
						$data['salary_field'] = $salary_field =  DB::table('tbl_emp_salary_certificate as sc') 
																->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'sc.f_year')  
																->where('sc.emp_id', '=', $emp_id) 
																->where('sc.f_year', '=', 4) 
																->select('sc.*','fy.f_year_from','fy.f_year_to','fy.id as fid')
																->first();
						/* echo "<pre>";
						print_r($salary_field);
						exit; */
						
						$designation_code = $emp_info->designation_code;	
							$designation_group_code = $emp_info->designation_group_code;	
							$area_code = $emp_info->area_code;	
							$zone_code = $emp_info->zone_code;	
						if(!empty($salary_field)){
							if($emp_info->salary_br_code != 9999){
									$is_branch = 2;
								}
							
							$data['all_report'] = array( 
														'branch_code' 			=> $emp_info->br_code,
														'emp_id' 				=> $emp_info->emp_id, 
														'type_name' 			=> "Regular", 
														'designation_name' 		=> $emp_info->designation_name,
														'salary_br_code' 			=> $emp_info->salary_br_code,
														'branch_name' 			=> $emp_info->branch_name,
														'f_year_from' 			=> $salary_field->f_year_from,
														'f_year_to' 			=> $salary_field->f_year_to,
														'basic' 			=> $salary_field->basic,
														'tot_basic' 			=> $salary_field->tot_basic,
														'house_rent' 			=> $salary_field->house_rent,
														'medi_allow' 			=> $salary_field->medi_allow,
														'convey_allow' 			=> $salary_field->convey_allow,
														'field_allow' 			=> $salary_field->field_allow,
														'charge_allow' 			=> $salary_field->charge_allow,
														'festival_allow' 			=> $salary_field->festival_allow,
														'boisaki_allow' 			=> $salary_field->boisaki_allow,
														'welfare_allow' 			=> $salary_field->welfare_allow,
														'provident_fund' 			=> $salary_field->provident_fund,
														'mobile_allow' 			=> $salary_field->mobile_allow,
														'car_main_allow' 			=> $salary_field->car_main_allow,
														'office_maintenance' 			=> $salary_field->office_maintenance,
														'car_allow' 			=> $salary_field->car_allow,
														'tot_salary' 			=> $salary_field->tot_salary,
														'tax_zone' 			=> $salary_field->tax_zone,
														'tax_circle' 			=> $salary_field->tax_circle,
														'pf_balance' 			=> $salary_field->pf_balance,
														'pf_interest' 			=> $salary_field->pf_interest,
														'tin_number' 			=> $salary_field->tin_number,
														'emp_name' 				=> $emp_info->emp_name
													);  				
						}
						}
	 
		$data['is_branch'] = $is_branch;	
		$data['challan_info'] =  DB::table('microfineye_taxvat.challan_info as tc')   
							->where('tc.is_branch', '=', $is_branch) 
							->select('tc.*')
							->get();
		
		$u_branch_code 	= Session::get('branch_code');
		$u_emp_id 		= Session::get('emp_id'); 
		$u_area_code	= Session::get('area_code'); 
		$u_zone_code 	= Session::get('zone_code');

		/* print_r($zone_code);
		exit; */
		$data['is_access'] = 1;
		 
		 if($u_user_type == 1){
			 $data['is_access']			= 1; 
		 }else if($u_user_type == 4){
			if($u_area_code == $area_code){ 
				if(($designation_group_code == 16)||($designation_group_code == 12)||($designation_group_code == 19)||($designation_group_code == 15)||($designation_group_code == 18)||($designation_code == 246)){ 
					$data['is_access']			= 1; 		 
				 }else{
					 $data['is_access']			= 0;
				 }  
				}else{
					$data['is_access']		= 0;
				}
		}else if($u_user_type == 3){
			if($u_zone_code == $zone_code){ 
			
						if(($designation_group_code == 16)||($designation_group_code == 12)||($designation_group_code == 15)||($designation_group_code == 11)||($designation_group_code == 19)||($designation_group_code == 18)||($designation_code == 186)||($designation_code == 217)){
					 
							$data['is_access']			= 1;  
						}else{
							$data['is_access']			= 0;
						} 	 
				}else{
					$data['is_access']		= 0;
				}
		}  		
	
	
  /*  echo "<pre>";
	print_r($data['is_access']);
	exit;   */
	return view('admin.employee.salary_certif',$data);
	}
	public function salary_certicate_depo()
    {
	
		$data = array();
		$data['Heading'] = 'Salary Certificate';
		$data['emp_id'] = '';   
		$data['all_report'] = array(); 
		  $data['is_access'] = 1; 
		$data['all_emp_type'] =  DB::table('tbl_emp_type') 
									->where('status',1)		 
									->get(); 
		return view('admin.employee.salary_certif_deposit',$data);
    }
	public function salary_certicate_emo_info_depo(Request $request)
    {
		$u_user_type 	= Session::get('user_type'); // 3=dm,4=am,5=bm
		$current_date = date('Y-m-d');
		$data['emp_id'] = $emp_id 		= $request->emp_id;   
		$data['Heading'] = 'Salary Certificate';
	 
		$is_branch = 1;							
		 
						$max_sarok = DB::table('tbl_master_tra as m')
										->where('m.emp_id', '=', $emp_id)
										->where('m.br_join_date', '=', function($query) use ($emp_id,$current_date)
												{
													$query->select(DB::raw('max(br_join_date)'))
														  ->from('tbl_master_tra')
														  ->where('emp_id',$emp_id)
														  ->where('br_join_date', '<=', $current_date);
												})
										->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
										->groupBy('emp_id')
										->first();
						if(!empty($max_sarok)){
						$emp_info = DB::table('tbl_master_tra as m') 
											->leftJoin('tbl_emp_basic_info as emp', 'emp.emp_id', '=', 'm.emp_id') 
											->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code') 
											->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
											->leftJoin('tbl_area as ar', 'b.area_code', '=', 'ar.area_code')
											->leftJoin('tbl_zone as zb', 'ar.zone_code', '=', 'zb.zone_code') 
											->where('m.sarok_no', '=', $max_sarok->sarok_no)
											->select('emp.emp_id','emp.emp_name_eng as emp_name','zb.zone_code','b.br_code','m.salary_br_code','ar.area_code','d.designation_name','d.designation_code','d.designation_group_code','b.branch_name')
											->first(); 
						$data['salary_field'] = $salary_field =  DB::table('tbl_emp_salary_certificate as sc') 
																->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'sc.f_year')  
																->where('sc.emp_id', '=', $emp_id) 
																->where('sc.f_year', '=', 4) 
																->select('sc.*','fy.f_year_from','fy.f_year_to','fy.id as fid')
																->first();
						
						$designation_code = $emp_info->designation_code;	
							$designation_group_code = $emp_info->designation_group_code;	
							$area_code = $emp_info->area_code;	
							$zone_code = $emp_info->zone_code;	
						if(!empty($salary_field)){
							if($emp_info->salary_br_code != 9999){
									$is_branch = 2;
								}
								
							$data['all_report'] = array( 
														'branch_code' 			=> $emp_info->br_code,
														'emp_id' 				=> $emp_info->emp_id, 
														'type_name' 			=> "Regular", 
														'designation_name' 		=> $emp_info->designation_name,
														'sdcf_balance' 			=> $salary_field->sdcf_balance,
														'salary_br_code' 			=> $emp_info->salary_br_code,
														'branch_name' 			=> $emp_info->branch_name,
														'f_year_from' 			=> $salary_field->f_year_from,
														'f_year_to' 			=> $salary_field->f_year_to,
														'basic' 			=> $salary_field->basic,
														'pf_balance' 			=> $salary_field->pf_balance,
														'provident_fund' 			=> $salary_field->provident_fund,
														'work_month' 			=> $salary_field->work_month, 
														'tin_number' 			=> $salary_field->tin_number,
														'tax_zone' 			=> $salary_field->tax_zone,
														'tax_circle' 			=> $salary_field->tax_circle,
														'emp_name' 				=> $emp_info->emp_name
													);  				
						}
						} 
	$u_branch_code 	= Session::get('branch_code');
		$u_emp_id 		= Session::get('emp_id'); 
		$u_area_code	= Session::get('area_code'); 
		$u_zone_code 	= Session::get('zone_code');

		/* print_r($zone_code);
		exit; */
		$data['is_access'] = 1;
		 
		 if($u_user_type == 1){
			 $data['is_access']			= 1; 
		 }else if($u_user_type == 4){
			if($u_area_code == $area_code){ 
				if(($designation_group_code == 16)||($designation_group_code == 12)||($designation_group_code == 19)||($designation_group_code == 15)||($designation_group_code == 18)||($designation_code == 246)){ 
					$data['is_access']			= 1; 		 
				 }else{
					 $data['is_access']			= 0;
				 }  
				}else{
					$data['is_access']		= 0;
				}
		}else if($u_user_type == 3){
			if($u_zone_code == $zone_code){ 
			
						if(($designation_group_code == 16)||($designation_group_code == 12)||($designation_group_code == 15)||($designation_group_code == 11)||($designation_group_code == 19)||($designation_group_code == 18)||($designation_code == 186)||($designation_code == 217)){
					 
							$data['is_access']			= 1;  
						}else{
							$data['is_access']			= 0;
						} 	 
				}else{
					$data['is_access']		= 0;
				}
		}  	
	$data['is_branch'] = $is_branch;	
	$data['challan_info'] =  DB::table('microfineye_taxvat.challan_info as tc')   
						->where('tc.is_branch', '=', $is_branch) 
						->select('tc.*')
						->get();
	/*   echo "<pre>";
	print_r($data['salary_field']);
	exit; */  
	return view('admin.employee.salary_certif_deposit',$data);
	}
}