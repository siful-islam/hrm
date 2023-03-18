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
		$data['emp_type'] = 1; 
		$data['all_report'] = array(); 
		  
		$data['all_emp_type'] =  DB::table('tbl_emp_type') 
									->where('status',1)		 
									->get(); 
		return view('admin.employee.salary_certif',$data);
    }
	public function salary_certicate_emo_info(Request $request)
    {
		$current_date = date('Y-m-d');
		$data['emp_id'] = $emp_id 		= $request->emp_id;
		$data['emp_type'] = $emp_type 		= $request->emp_type;  
		$data['Heading'] = 'Salary Certificate';
		$data['all_emp_type'] =  DB::table('tbl_emp_type') 
									->where('status',1)		 
									->get();
		$is_branch = 1;							
		if($emp_type == 1){ 
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
																->where('sc.emp_type', '=', $emp_type)
																->select('sc.*','fy.f_year_from','fy.f_year_to','fy.id as fid')
																->first();
						
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
	}else{
		$employee_info_non  = DB::table('tbl_emp_non_id as nid')  
											->leftjoin('tbl_nonid_official_info as noi',function($join) use($current_date){
												$join->on("nid.emp_id","=","noi.emp_id") 
														->where('noi.sarok_no',DB::raw("(SELECT 
																								  max(tbl_nonid_official_info.sarok_no)
																								  FROM tbl_nonid_official_info 
																								   where nid.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
																								  max(t.joining_date)
																								  FROM tbl_nonid_official_info as t 
																								   where nid.emp_id = t.emp_id AND t.joining_date <  '$current_date')
																								  )") 		 
																			); 		
														})  
										 ->leftJoin('tbl_designation as d', 'noi.designation_code', '=', 'd.designation_code') 
										 ->leftJoin('tbl_branch as b', 'noi.br_code', '=', 'b.br_code') 
										 ->leftJoin('tbl_emp_non_id_cancel as nc', 'nid.emp_id', '=', 'nc.emp_id')
										 ->leftjoin('tbl_emp_type as et',function($join){
												$join->on('et.id', "=","nid.emp_type_code"); 
											})	 
										->Where('noi.joining_date', '<=', $current_date)
										->Where('nid.sacmo_id',$emp_id)
										->Where('nid.emp_type_code',$emp_type) 
										 ->select('nid.sacmo_id as emp_id','nid.emp_type_code as emp_type','nid.emp_name','noi.joining_date','b.br_code','noi.salary_br_code','d.designation_code','b.branch_name','d.designation_name','et.type_name')
										 ->first(); 
				$data['salary_field'] =  $salary_field =  DB::table('tbl_emp_salary_certificate as sc') 
												->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'sc.f_year')  
												->where('sc.emp_id', '=', $emp_id)
												->where('sc.emp_type', '=', $emp_type)
												->select('sc.*','fy.f_year_from','fy.f_year_to','fy.id as fid')
												->first();
				
				
				
				if(!empty($salary_field)){
					if($employee_info_non->salary_br_code != 9999){
						$is_branch = 2;
					}
					
					$data['all_report'] = array( 
							'branch_code' 			=> $employee_info_non->br_code,
							'emp_id' 				=> $employee_info_non->emp_id, 
							'type_name' 			=> $employee_info_non->type_name, 
							'designation_name' 		=> $employee_info_non->designation_name,
							'branch_name' 			=> $employee_info_non->branch_name,
							'salary_br_code' 		=> $employee_info_non->salary_br_code,
							'f_year_from' 			=> $salary_field->f_year_from,
							'f_year_to' 			=> $salary_field->f_year_to,
							'basic' 			    => $salary_field->basic,
							'tot_basic' 			=> $salary_field->tot_basic,
							'house_rent' 			=> $salary_field->house_rent,
							'medi_allow' 			=> $salary_field->medi_allow,
							'convey_allow' 			=> $salary_field->convey_allow,
							'field_allow' 			=> $salary_field->field_allow,
							'charge_allow' 			=> $salary_field->charge_allow,
							'festival_allow' 			=> $salary_field->festival_allow,
							'boisaki_allow' 			=> $salary_field->boisaki_allow,
							'provident_fund' 			=> $salary_field->provident_fund,
							'mobile_allow' 			=> $salary_field->mobile_allow,
							'car_allow' 			=> $salary_field->car_allow,
							'office_maintenance' 		=> $salary_field->office_maintenance,
							'car_main_allow' 		=> $salary_field->car_main_allow,
							'tot_salary' 			=> $salary_field->tot_salary,
							'pf_balance' 			=> $salary_field->pf_balance,
							'tax_zone' 			=> $salary_field->tax_zone,
							'tax_circle' 			=> $salary_field->tax_circle,
							'pf_interest' 			=> $salary_field->pf_interest,
							'tin_number' 			=> $salary_field->tin_number,
							'emp_name' 				=> $employee_info_non->emp_name
						);    
				}
	}
	$data['is_branch'] = $is_branch;	
	$data['challan_info'] =  DB::table('db_tax_vat.challan_info as tc')   
						->where('tc.is_branch', '=', $is_branch) 
						->select('tc.*')
						->get();
	/*   echo "<pre>";
	print_r($data['salary_field']);
	exit; */  
	return view('admin.employee.salary_certif',$data);
	}
	public function salary_certicate_depo()
    {
	
		$data = array();
		$data['Heading'] = 'Salary Certificate';
		$data['emp_id'] = ''; 
		$data['emp_type'] = ''; 
		$data['all_report'] = array(); 
		  
		$data['all_emp_type'] =  DB::table('tbl_emp_type') 
									->where('status',1)		 
									->get(); 
		return view('admin.employee.salary_certif_deposit',$data);
    }
	public function salary_certicate_emo_info_depo(Request $request)
    {
		$current_date = date('Y-m-d');
		$data['emp_id'] = $emp_id 		= $request->emp_id;
		$data['emp_type'] = $emp_type 		= $request->emp_type;  
		$data['Heading'] = 'Salary Certificate';
		$data['all_emp_type'] =  DB::table('tbl_emp_type') 
									->where('status',1)		 
									->get();
		$is_branch = 1;							
		if($emp_type == 1){ 
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
																->where('sc.emp_type', '=', $emp_type)
																->select('sc.*','fy.f_year_from','fy.f_year_to','fy.id as fid')
																->first();
						
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
														'pf_balance' 			=> $salary_field->pf_balance,
														'provident_fund' 			=> $salary_field->provident_fund,
														'work_month' 			=> $salary_field->work_month, 
														'tin_number' 			=> $salary_field->tin_number,
														'tax_zone' 			=> $salary_field->tax_zone,
														'tax_circle' 			=> $salary_field->tax_circle,
														'emp_name' 				=> $emp_info->emp_name
													);  				
						}
	}else{
		$employee_info_non  = DB::table('tbl_emp_non_id as nid')  
											->leftjoin('tbl_nonid_official_info as noi',function($join) use($current_date){
												$join->on("nid.emp_id","=","noi.emp_id") 
														->where('noi.sarok_no',DB::raw("(SELECT 
																								  max(tbl_nonid_official_info.sarok_no)
																								  FROM tbl_nonid_official_info 
																								   where nid.emp_id = tbl_nonid_official_info.emp_id and  tbl_nonid_official_info.joining_date =   (SELECT 
																								  max(t.joining_date)
																								  FROM tbl_nonid_official_info as t 
																								   where nid.emp_id = t.emp_id AND t.joining_date <  '$current_date')
																								  )") 		 
																			); 		
														})  
										 ->leftJoin('tbl_designation as d', 'noi.designation_code', '=', 'd.designation_code') 
										 ->leftJoin('tbl_branch as b', 'noi.br_code', '=', 'b.br_code') 
										 ->leftJoin('tbl_emp_non_id_cancel as nc', 'nid.emp_id', '=', 'nc.emp_id')
										 ->leftjoin('tbl_emp_type as et',function($join){
												$join->on('et.id', "=","nid.emp_type_code"); 
											})	 
										->Where('noi.joining_date', '<=', $current_date)
										 ->Where('nid.sacmo_id',$emp_id)
										->Where('nid.emp_type_code',$emp_type) 
										 ->select('nid.sacmo_id as emp_id','nid.emp_type_code as emp_type','nid.emp_name','noi.joining_date','b.br_code','noi.salary_br_code','d.designation_code','b.branch_name','d.designation_name','et.type_name')
										 ->first(); 
				$data['salary_field'] =  $salary_field =  DB::table('tbl_emp_salary_certificate as sc') 
												->leftJoin('tbl_financial_year as fy', 'fy.id', '=', 'sc.f_year')  
												->where('sc.emp_id', '=', $emp_id)
												->where('sc.emp_type', '=', $emp_type)
												->select('sc.*','fy.f_year_from','fy.f_year_to','fy.id as fid')
												->first();
				
				
				
				if(!empty($salary_field)){
					if($employee_info_non->salary_br_code != 9999){
						$is_branch = 2;
					}
					
					$data['all_report'] = array( 
							'branch_code' 			=> $employee_info_non->br_code,
							'emp_id' 				=> $employee_info_non->emp_id, 
							'type_name' 			=> $employee_info_non->type_name, 
							'designation_name' 		=> $employee_info_non->designation_name,
							'branch_name' 			=> $employee_info_non->branch_name,
							'salary_br_code' 		=> $employee_info_non->salary_br_code,
							'f_year_from' 			=> $salary_field->f_year_from,
							'f_year_to' 			=> $salary_field->f_year_to,
							'basic' 			    => $salary_field->basic, 
							'work_month' 			=> $salary_field->work_month, 
							'pf_balance' 			=> $salary_field->pf_balance, 
							'provident_fund' 			=> $salary_field->provident_fund, 
							'tin_number' 			=> $salary_field->tin_number,
							'tax_zone' 			=> $salary_field->tax_zone,
							'tax_circle' 			=> $salary_field->tax_circle,
							'emp_name' 				=> $employee_info_non->emp_name
						);    
				}
	}
	$data['is_branch'] = $is_branch;	
	$data['challan_info'] =  DB::table('db_tax_vat.challan_info as tc')   
						->where('tc.is_branch', '=', $is_branch) 
						->select('tc.*')
						->get();
	/*   echo "<pre>";
	print_r($data['salary_field']);
	exit; */  
	return view('admin.employee.salary_certif_deposit',$data);
	}
}