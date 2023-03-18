<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\DB;
	
	use Illuminate\Support\Facades\Redirect;
	use Session;
	
	////session_start();
	
	class AdminController extends Controller
	{
		public function __construct()
		{
//			$this->middleware("CheckSession");
		}
		
		
		public function abcd()
		{
			$ams = array(16,31,40,101,162,188,189,207,211,222,272,507,655,671,725,837,906,908,958,1034,1393,1431,1433,1437,1441,1443,1482,1724,2302,2360,2477,2491,2644,3305);
			
			foreach($ams as $am)
			{
				$info = DB::table('tbl_edms_driver_license')
									->where('emp_id',$am)
									->orderby('dri_license_id','desc')
									->select('license_exp_date')
									->first();  
									
									
				$data[$am] = $info->license_exp_date;					
			}
			
			echo '<pre>';
			print_r($data);
			


		}
		
		
		public function circulars()
		{
		$data = array();
		$branch_code = 9999; 
		$data['office_order_file'] = DB::table('tbl_offfice_order')
									->where('upload_type',2)
									->where(function ($query) use($branch_code) {
										if($branch_code == 9999){
											$query->where('for_which', 1)->orwhere('for_which', 3);
										}else{
											$query->where('for_which', 2)->orwhere('for_which', 3);
										} 	 	 
									})
									->where('status',1)
									->orderby('order_date','desc')
									->select('*')
									->get();  
									
			//print_r($data['office_order_file']);						
			return view('admin.circulars',$data);
			
		}		
		
		public function index()
		{
			//return Redirect::to( "http://www.home.cdipbd.org/login?continue=".\URL::to( '/' )."&param=admin-login-check" );
			return view( 'admin.admin_login' );
		}
		
		
		public function dataMigration()
		{
//			ALTER TABLE `tbl_emp_basic_info` CHANGE `national_id` `national_id` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

//				ALTER TABLE `tbl_emp_salary` CHANGE `gross_total` `gross_total` INT(11) NULL;

//				INSERT INTO `tbl_transections` (`transaction_id`, `transaction_code`, `transaction_name`, `transection_table`, `is_effect_salary`, `transaction_status`) VALUES (NULL, '16', 'Contractual Employee', 'tbl_probation', '1', '1');
//
//ALTER TABLE `tbl_emp_basic_info` CHANGE `created_at` `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, CHANGE `updated_at` `updated_at` DATETIME on update CURRENT_TIMESTAMP NULL DEFAULT NULL;
//
//
//ALTER TABLE `tbl_master_tra` ADD `is_consolidated` SMALLINT(2) NOT NULL DEFAULT '0' COMMENT '0= no, 1= yes' AFTER `basic_salary`;
//			INSERT INTO `hrm_migration`.`tbl_transections` (`transaction_id`, `transaction_code`, `transaction_name`, `transection_table`, `is_effect_salary`, `transaction_status`) VALUES (NULL, '16', 'Contractual Employee', 'tbl_probation', '1', '1');

//			ALTER TABLE `tbl_grade_new` CHANGE `grade_name` `grade_name` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

//			INSERT INTO `hrm_migration`.`tbl_grade_new` (`grade_id`, `grade_code`, `grade_name`, `grade_name_bn`, `active_from`, `active_upto`, `step_1`, `step_2`, `step_3`, `step_4`, `step_5`, `step_6`, `step_7`, `step_8`, `step_9`, `step_10`, `step_11`, `step_12`, `step_13`, `step_14`, `step_15`, `step_16`, `step_17`, `step_18`, `step_19`, `step_20`, `is_promotionable`, `status`) VALUES (NULL, '27', 'Contractual', 'কন্ট্রাকচুয়াল', '2020-01-01', '2030-06-30', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');


//			$tbl_emp_non_ids = DB::table( "tbl_emp_non_id as emp" )
//			                     ->leftJoin( "tbl_nonid_official_info as official", "official.emp_id", "=",
//			                                 "emp.emp_id" )
//			                     ->leftJoin( "tbl_nonid_salary as salary", "salary.emp_id", "=", "emp.emp_id" )
//			                     ->groupBy( "emp.emp_id" )
//			                     ->get();
//
//			foreach ( $tbl_emp_non_ids as $key => $tbl_emp_non_id ) {
//				$tbl_sarok = DB::table( "tbl_sarok_no" )
//				               ->orderBy( "sarok_no", "DESC" )
//				               ->first();
//
//				$emp[ 'sarok_no' ]        = $tbl_sarok->sarok_no + ( $key + 1 );
//				$emp[ 'emp_id' ]          = $tbl_emp_non_id->emp_id + 100000;
//				$emp[ 'letter_date' ]     = $tbl_emp_non_id->joining_date;
//				$emp[ 'emp_type' ]        = 2;
//				$emp[ 'emp_name' ]        = $tbl_emp_non_id->emp_name;
//				$emp[ 'emp_name_bangla' ] = "";
//				$emp[ 'join_as' ]         = 1;
//				$emp[ 'org_code' ]        = 181;
//				$emp[ 'created_by' ]      = Session::get( 'admin_id' );
//
//				if ( $tbl_emp_non_id->emp_type_code == 8 ) {
//					$emp_group = 3;
//				} else {
//					$emp_group = 2;
//				}
//				$emp[ 'fathers_name' ]        = $tbl_emp_non_id->father_name;
//				$emp[ 'mother_name' ]         = $tbl_emp_non_id->mother_name;
//				$emp[ 'birth_date' ]          = $tbl_emp_non_id->birth_date;
//				$emp[ 'nationality' ]         = $tbl_emp_non_id->nationality;
//				$emp[ 'religion' ]            = $tbl_emp_non_id->religion;
//				$emp[ 'national_id' ]         = $tbl_emp_non_id->national_id;
//				$emp[ 'birth_certificate' ]   = $tbl_emp_non_id->birth_certificate;
//				$emp[ 'country_id' ]          = 1;
//				$emp[ 'contact_num' ]         = $tbl_emp_non_id->contact_num;
//				$emp[ 'maritial_status' ]     = $tbl_emp_non_id->maritial_status;
//				$emp[ 'gender' ]              = $tbl_emp_non_id->gender;
//				$emp[ 'blood_group' ]         = $tbl_emp_non_id->blood_group;
//				$emp[ 'present_add' ]         = $tbl_emp_non_id->present_add;
//				$emp[ 'permanent_add' ]       = $tbl_emp_non_id->permanent_add;
//				$emp[ 'emp_group' ]           = $emp_group;
//				$emp[ 'emp_type' ]            = $tbl_emp_non_id->emp_type_code;
//				$emp[ 'salary_br_code' ]      = $tbl_emp_non_id->salary_br_code;
//				$emp[ 'fathers_name_bangla' ] = "";
//				$emp[ 'emp_village' ]         = $tbl_emp_non_id->post_office;
//				$emp[ 'emp_village_bangla' ]  = "";
//				$emp[ 'emp_po' ]              = $tbl_emp_non_id->post_office;
//				$emp[ 'emp_po_bangla' ]       = "";
//				$emp[ 'emp_district' ]        = $tbl_emp_non_id->district_code;
//				$emp[ 'emp_thana' ]           = $tbl_emp_non_id->thana_code;
//				$emp[ 'joining_date' ]        = $tbl_emp_non_id->joining_date;
//				$emp[ 'br_join_date' ]        = $tbl_emp_non_id->joining_date;
//				$emp[ 'joining_branch' ]      = $tbl_emp_non_id->br_code;
//				$emp[ 'created_by' ]          = Session::get( 'admin_id' );
//				$emp[ 'emp_designation' ]     = $tbl_emp_non_id->designation_code;
//
//
//				$emp_basic[ 'created_by' ]      = Session::get( 'admin_id' );
//				$emp_basic[ 'emp_id' ]          = $tbl_emp_non_id->emp_id + 100000;
//				$emp_basic[ 'emp_name_eng' ]    = $tbl_emp_non_id->emp_name;
//				$emp_basic[ 'father_name' ]     = $tbl_emp_non_id->father_name;
//				$emp_basic[ 'mother_name' ]     = $tbl_emp_non_id->mother_name;
//				$emp_basic[ 'birth_date' ]      = $tbl_emp_non_id->birth_date;
//				$emp_basic[ 'nationality' ]     = $tbl_emp_non_id->nationality;
//				$emp_basic[ 'religion' ]        = $tbl_emp_non_id->religion;
//				$emp_basic[ 'country_id' ]      = 1;
//				$emp_basic[ 'contact_num' ]     = $tbl_emp_non_id->contact_num;
//				$emp_basic[ 'email' ]           = $tbl_emp_non_id->email;
//				$emp_basic[ 'national_id' ]     = $tbl_emp_non_id->national_id;
//				$emp_basic[ 'maritial_status' ] = $tbl_emp_non_id->maritial_status;
//				$emp_basic[ 'gender' ]          = $tbl_emp_non_id->gender;
//				$emp_basic[ 'blood_group' ]     = $tbl_emp_non_id->blood_group;
//				$emp_basic[ 'present_add' ]     = $tbl_emp_non_id->present_add;
//				$emp_basic[ 'vill_road' ]       = $tbl_emp_non_id->vill_road;
//				$emp_basic[ 'post_office' ]     = $tbl_emp_non_id->post_office;
//				$emp_basic[ 'district_code' ]   = $tbl_emp_non_id->district_code;
//				$emp_basic[ 'thana_code' ]      = $tbl_emp_non_id->thana_code;
//				$emp_basic[ 'permanent_add' ]   = $tbl_emp_non_id->permanent_add;
//				$emp_basic[ 'org_join_date' ]   = $tbl_emp_non_id->joining_date;
//				$emp_basic[ 'emp_group' ]       = $emp_group;
//				$emp_basic[ 'emp_type' ]        = $tbl_emp_non_id->emp_type_code;
//
//				$sarok_no[ 'sarok_no' ]    = $tbl_sarok->sarok_no + ( $key + 1 );
//				$sarok_no[ 'letter_date' ] = $tbl_emp_non_id->joining_date;
//				$sarok_no[ 'emp_id' ]      = $tbl_emp_non_id->emp_id + 100000;
//				$sarok_no[ 'created_by' ]  = Session::get( 'admin_id' );
//
////    		dd($emp_basic);
//
//				DB::beginTransaction();
//
//				try {
//
//					DB::table( "tbl_appointment_info" )
//					  ->insert( $emp );
//
//					DB::table( "tbl_emp_basic_info" )
//					  ->insert( $emp_basic );
//
//					DB::table( "tbl_sarok_no" )
//					  ->insert( $sarok_no );
//
//					DB::commit();
//					// all good
//				} catch ( \Exception $e ) {
//					DB::rollback();
//					dd( $e );
//					// something went wrong
//				}
//
////				dd( gettype( $emp[ 'emp_id' ] ) );
//
//			}
//return "OK";

//			$tbl_nonid_official_infos = DB::table( "tbl_nonid_official_info" )
//			                              ->get();
//
//			foreach ( $tbl_nonid_official_infos as $key => $tbl_nonid_official_info ) {
//
//
//			$tbl_sarok = DB::table( "tbl_sarok_no" )
//			               ->orderBy( "sarok_no", "DESC" )
//			               ->first();
//
//				$tbl_nonid_salary = DB::table( "tbl_nonid_salary" )
//				                      ->where( "emp_id", "=", $tbl_nonid_official_info->emp_id )
//				                      ->orderBy( "id", "DESC" )
//				                      ->first();
//
//				$tbl_emp_non_id = DB::table( "tbl_emp_non_id as emp" )
//				                    ->leftJoin( "tbl_nonid_official_info as official", "official.emp_id", "=",
//				                                "emp.emp_id" )
//				                    ->leftJoin( "tbl_nonid_salary as salary", "salary.emp_id", "=", "emp.emp_id" )
//				                    ->where( "emp.emp_id", "=", $tbl_nonid_official_info->emp_id )
//				                    ->first();
//
//				$master_tra[ 'created_by' ]       = Session::get( 'admin_id' );
//				$master_tra[ 'sarok_no' ]         = $tbl_sarok->sarok_no + ( $key + 1 );
//				$master_tra[ 'letter_date' ]      = $tbl_emp_non_id->joining_date;
//				$master_tra[ 'emp_id' ]           = $tbl_emp_non_id->emp_id + 100000;
//				$master_tra[ 'designation_code' ] = $tbl_emp_non_id->designation_code;
//				$master_tra[ 'br_code' ]          = $tbl_emp_non_id->br_code;
//
//				$master_tra[ 'salary_br_code' ] = $tbl_emp_non_id->salary_br_code;
//				$master_tra[ 'br_join_date' ]   = $tbl_emp_non_id->br_join_date;
//
//				if ( $tbl_nonid_salary->is_Consolidated == 1 ) {
//					$master_tra[ 'is_consolidated' ] = 0;
//					$master_tra[ 'basic_salary' ]    = $tbl_nonid_salary->basic_salary;
//				} else {
//					$master_tra[ 'is_consolidated' ] = 1;
//					$master_tra[ 'basic_salary' ]    = $tbl_nonid_salary->console_salary;
//				}
//				if(empty($master_tra[ 'basic_salary' ])){
//					$master_tra[ 'basic_salary' ] = 0;
//				}
//
//				$master_tra[ 'total_pay' ]    = $tbl_nonid_salary->gross_salary;
//				$master_tra[ 'net_pay' ]      = $tbl_nonid_salary->gross_salary;
//				$master_tra[ 'effect_date' ]  = $tbl_nonid_salary->effect_date;
//				$master_tra[ 'tran_type_no' ] = 16;
//				$master_tra[ 'is_permanent' ] = 3;
//				$master_tra[ 'grade_code' ] = 27;
//
//
//				$sarok_no[ 'sarok_no' ]    = $tbl_sarok->sarok_no + ( $key + 1 );
//				$sarok_no[ 'letter_date' ] = $tbl_emp_non_id->joining_date;
//				$sarok_no[ 'emp_id' ]      = $tbl_emp_non_id->emp_id + 100000;
//				$sarok_no[ 'created_by' ]  = Session::get( 'admin_id' );
//
//
//				DB::beginTransaction();
//
//				try {
//
//					DB::table( "tbl_master_tra" )
//					  ->insert( $master_tra );
//
//					DB::table( "tbl_sarok_no" )
//					  ->insert( $sarok_no );
//
//					DB::commit();
//					// all good
//				} catch ( \Exception $e ) {
//					DB::rollback();
//					dd( $e );
//					// something went wrong
//				}
//			}
//			return "OK";
			
			
//			$tbl_nonid_salarys = DB::table( "tbl_nonid_salary" )
//			                       ->get();
//
//			foreach ( $tbl_nonid_salarys as $tbl_nonid_salary ) {
//
//				$tbl_sarok = DB::table( "tbl_sarok_no" )
//				               ->orderBy( "sarok_no", "DESC" )
//				               ->first();
//
//
//				$tbl_emp_non_id = DB::table( "tbl_nonid_official_info" )
//				                    ->where( "emp_id", "=", $tbl_nonid_salary->emp_id )
//				                    ->orderBy( "id", "DESC" )
//				                    ->first();
//
//				$salary[ 'sarok_no' ]        = $tbl_sarok->sarok_no + 1;
//				$salary[ 'letter_date' ]     = $tbl_nonid_salary->effect_date;
//				$salary[ 'effect_date' ]     = $tbl_nonid_salary->effect_date;
//				$salary[ 'emp_id' ]          = $tbl_nonid_salary->emp_id + 100000;
//				$salary[ 'br_code' ]         = $tbl_emp_non_id->br_code;
//				$salary[ 'plus_item_id' ]    = $tbl_nonid_salary->plus_item_id;
//				$salary[ 'plus_item' ]       = $tbl_nonid_salary->item_plus_amt;
//				$salary[ 'minus_item_id' ]   = $tbl_nonid_salary->item_minus_id;
//				$salary[ 'minus_item' ]      = $tbl_nonid_salary->item_minus_amt;
//				$salary[ 'salary_basic' ]    = $tbl_nonid_salary->basic_salary;
//				$salary[ 'gross_total' ]     = $tbl_nonid_salary->gross_salary;
//				$salary[ 'created_by' ]      = $tbl_nonid_salary->created_by;
//				$salary[ 'transection' ]     = 16;
//				$salary[ 'is_consolidated' ] = $tbl_nonid_salary->is_Consolidated;
//
//				$sarok_no[ 'sarok_no' ]    = $tbl_sarok->sarok_no + 1;
//				$sarok_no[ 'letter_date' ] = $tbl_nonid_salary->effect_date;
//				$sarok_no[ 'emp_id' ]      = $tbl_nonid_salary->emp_id + 100000;
//				$sarok_no[ 'created_by' ]  = Session::get( 'admin_id' );
//
//				DB::beginTransaction();
//
//				try {
//
//					if ( !empty( $tbl_nonid_salary->gross_salary ) ) {
//						DB::table( "tbl_emp_salary" )
//						  ->insert( $salary );
//					}
//
//					DB::table( "tbl_sarok_no" )
//					  ->insert( $sarok_no );
//
//					DB::commit();
//					// all good
//				} catch ( \Exception $e ) {
//					DB::rollback();
//					dd( $e );
//					// something went wrong
//				}
//
//
//			}
//
//			return "OK";


//			$tbl_emp_non_id_cancels = DB::table( "tbl_emp_non_id_cancel" )
//			                            ->get();
//
//			foreach ( $tbl_emp_non_id_cancels as $tbl_emp_non_id_cancel ) {
//
//				$tbl_emp_non_id = DB::table( "tbl_nonid_official_info" )
//				                    ->where( "emp_id", "=", $tbl_emp_non_id_cancel->emp_id )
//				                    ->orderBy( "id", "DESC" )
//				                    ->first();
//
//				$tbl_sarok = DB::table( "tbl_sarok_no" )
//				               ->orderBy( "sarok_no", "DESC" )
//				               ->first();
//
//				$resignation[ 'sarok_no' ]         = $tbl_sarok->sarok_no + 1;
//				$resignation[ 'letter_date' ]      = $tbl_emp_non_id_cancel->cancel_date;
//				$resignation[ 'emp_id' ]           = $tbl_emp_non_id->emp_id + 100000;
//				$resignation[ 'designation_code' ] = $tbl_emp_non_id->designation_code;
//				$resignation[ 'br_code' ]          = $tbl_emp_non_id->br_code;
//				$resignation[ 'br_join_date' ]     = $tbl_emp_non_id->br_join_date;
//				$resignation[ 'effect_date' ]      = $tbl_emp_non_id_cancel->cancel_date;
//				$resignation[ 'resignation_by' ]   = "Expired";
//				$resignation[ 'created_by' ]       = Session::get( 'admin_id' );
//
//
//				$sarok_no[ 'sarok_no' ]    = $tbl_sarok->sarok_no + 1;
//				$sarok_no[ 'letter_date' ] = $tbl_emp_non_id->joining_date;
//				$sarok_no[ 'emp_id' ]      = $tbl_emp_non_id->emp_id + 100000;
//				$sarok_no[ 'created_by' ]  = Session::get( 'admin_id' );
//
//				DB::beginTransaction();
//
//				try {
//
//					DB::table( "tbl_resignation" )
//					  ->insert( $resignation );
//
//					DB::table( "tbl_sarok_no" )
//					  ->insert( $sarok_no );
//
//					DB::commit();
//					// all good
//				} catch ( \Exception $e ) {
//					DB::rollback();
//					dd( $e );
//					// something went wrong
//				}
//
//			}
//			return "OK";
			
//			$tbl_nonid_transfers = DB::table( "tbl_nonid_transfer" )
//			                         ->get();
//			foreach ( $tbl_nonid_transfers as $k => $trans ) {
//				$tbl_sarok = DB::table( "tbl_sarok_no" )
//				               ->orderBy( "sarok_no", "DESC" )
//				               ->first();
//
//
//				$tbl_emp_non_id = DB::table( "tbl_nonid_official_info" )
//				                    ->where( "emp_id", "=", $trans->emp_id )
//				                    ->where( "tran_db_id", "=", $trans->id )
//				                    ->first();
//
//				$tbl_nonid_salary = DB::table( "tbl_nonid_salary" )
//				                      ->where( "emp_id", "=", $tbl_emp_non_id->emp_id )
//				                      ->orderBy( "id", "DESC" )
//				                      ->first();
//
//				if ( $tbl_nonid_salary->is_Consolidated == 1 ) {
//					$master_tra[ 'is_consolidated' ] = 0;
//					$master_tra[ 'basic_salary' ]    = $tbl_nonid_salary->basic_salary;
//				} else {
//					$master_tra[ 'is_consolidated' ] = 1;
//					$master_tra[ 'basic_salary' ]    = $tbl_nonid_salary->console_salary;
//				}
//
//				$transfer[ 'sarok_no' ]         = $tbl_sarok->sarok_no + ( $k + 1 );
//				$transfer[ 'letter_date' ]      = $trans->effect_date;
//				$transfer[ 'emp_id' ]           = $tbl_emp_non_id->emp_id + 100000;
//				$transfer[ 'designation_code' ] = $tbl_emp_non_id->designation_code;
//				$transfer[ 'br_code' ]          = $tbl_emp_non_id->br_code;
//				$transfer[ 'salary_br_code' ]   = $tbl_emp_non_id->salary_br_code;
//				$transfer[ 'br_joined_date' ]   = $trans->effect_date;
//				$transfer[ 'effect_date' ]      = $trans->effect_date;
//				$transfer[ 'basic_salary' ]     = $master_tra[ 'basic_salary' ];
//				$transfer[ 'created_by' ]       = Session::get( 'admin_id' );
//
//
//				$sarok_no[ 'sarok_no' ]    = $tbl_sarok->sarok_no + ( $k + 1 );
//				$sarok_no[ 'letter_date' ] = $tbl_emp_non_id->joining_date;
//				$sarok_no[ 'emp_id' ]      = $tbl_emp_non_id->emp_id + 100000;
//				$sarok_no[ 'created_by' ]  = Session::get( 'admin_id' );
//
//				DB::beginTransaction();
//
//				try {
//
//					DB::table( "tbl_transfer" )
//					  ->insert( $transfer );
//
//					DB::table( "tbl_sarok_no" )
//					  ->insert( $sarok_no );
//
//					DB::commit();
//					// all good
//				} catch ( \Exception $e ) {
//					DB::rollback();
//					dd( $e );
//					// something went wrong
//				}
//			}
//
//			return "OK";
		}
		
		public function adminLoginCheck( Request $request )
		{
			$email_address  = $request->input( 'email_address' );
			$admin_password = md5( $request->input( 'admin_password' ) );
			
			$admin_info = DB::table( 'tbl_admin as ad' )
			                ->leftJoin( 'tbl_admin_user_role as aur', 'ad.access_label', '=', 'aur.id' )
			                ->leftJoin( 'tbl_ogranization as og', 'ad.org_code', '=', 'og.org_code' )
			                ->leftJoin( 'tbl_branch as b', 'ad.branch_code', '=', 'b.br_code' )
			                ->leftJoin( 'tbl_area as a', 'a.area_code', '=', 'b.area_code' )
			                ->leftJoin( 'tbl_zone as z', 'z.zone_code', '=', 'b.zone_code' )
			                ->select( 'ad.*', 'aur.admin_role_name', 'b.area_code', 'b.zone_code', 'og.org_short_name',
			                          'og.org_logo', 'og.favicon', 'aur.id as role_id', 'a.area_name', 'z.zone_name' )
			                ->where( 'ad.admin_user_name', $email_address )
			                ->where( 'ad.admin_password', $admin_password )
			                ->where( 'ad.status', 1 )
			                ->first();
			
			if ( $admin_info ) {
				Session::put( 'admin_id', $admin_info->admin_id );
				Session::put( 'branch_code', $admin_info->branch_code );
				Session::put( 'emp_id', $admin_info->emp_id );
				Session::put( 'emp_type', $admin_info->emp_type );
				Session::put( 'admin_name', $admin_info->admin_name );
				Session::put( 'admin_photo', 'public/avatars/'.$admin_info->admin_photo );
				Session::put( 'admin_access_label', $admin_info->access_label );
				Session::put( 'admin_role_name', $admin_info->admin_role_name );
				Session::put( 'user_type', $admin_info->user_type );
				Session::put( 'area_code', $admin_info->area_code );
				Session::put( 'zone_code', $admin_info->zone_code );
				Session::put( 'area_name', $admin_info->area_name );
				Session::put( 'zone_name', $admin_info->zone_name );
				Session::put( 'admin_org_code', $admin_info->org_code );
				Session::put( 'org_short_name', $admin_info->org_short_name );
				Session::put( 'org_logo', 'public/org_logo/'.$admin_info->org_logo );
				Session::put( 'favicon', 'public/org_logo/'.$admin_info->favicon );
				
				//return Redirect::to( '/dashboard' ); 
				
				if ( $admin_info->access_label == 12 ) {
					// SELF CARE
					return Redirect::to( '/profile' );
				} else {
					// Regular
					return Redirect::to( '/dashboard' );
				}
				
			} else {
				Session::put( 'exception', 'User Id Or Password Invalid !' );
				
				return Redirect::to( '/admin' );
			}
			
		}
		
		public function getadminLoginCheck( Request $request )
		{
			$emp_id     = $request->query( 'user_code' );
			$token_id     = $request->query( 'id' );
			
			$admin_info = DB::table( 'tbl_admin as ad' )
			                ->leftJoin( 'tbl_admin_user_role as aur', 'ad.access_label', '=', 'aur.id' )
			                ->leftJoin( 'tbl_ogranization as og', 'ad.org_code', '=', 'og.org_code' )
			                ->leftJoin( 'tbl_branch as b', 'ad.branch_code', '=', 'b.br_code' )
			                ->leftJoin( 'tbl_area as a', 'a.area_code', '=', 'b.area_code' )
			                ->leftJoin( 'tbl_zone as z', 'z.zone_code', '=', 'b.zone_code' )
			                ->select( 'ad.*', 'aur.admin_role_name', 'b.area_code', 'b.zone_code', 'og.org_short_name',
			                          'og.org_logo', 'og.favicon', 'aur.id as role_id', 'a.area_name', 'z.zone_name' )
			                ->where( 'ad.admin_user_name', $emp_id )
			                ->where( 'ad.status', 1 )
			                ->where( 'ad.access_label', '<',100 )
			                ->first();
//			dd($admin_info);
			
			if ( $admin_info && $token_id==1) {
				
				Session::put( 'admin_id', $admin_info->admin_id );
				Session::put( 'branch_code', $admin_info->branch_code );
				Session::put( 'emp_id', $admin_info->emp_id );
				Session::put( 'emp_type', $admin_info->emp_type );
				Session::put( 'admin_name', $admin_info->admin_name );
				Session::put( 'admin_photo', 'public/avatars/'.$admin_info->admin_photo );
				Session::put( 'admin_access_label', $admin_info->access_label );
				Session::put( 'admin_role_name', $admin_info->admin_role_name );
				Session::put( 'user_type', $admin_info->user_type );
				Session::put( 'area_code', $admin_info->area_code );
				Session::put( 'zone_code', $admin_info->zone_code );
				Session::put( 'area_name', $admin_info->area_name );
				Session::put( 'zone_name', $admin_info->zone_name );
				Session::put( 'admin_org_code', $admin_info->org_code );
				Session::put( 'org_short_name', $admin_info->org_short_name );
				Session::put( 'org_logo', 'public/org_logo/'.$admin_info->org_logo );
				Session::put( 'favicon', 'public/org_logo/'.$admin_info->favicon );
				
				//return Redirect::to( '/dashboard' );
				
				if ( $admin_info->access_label == 12 ) {
					// SELF CARE
					if($admin_info->emp_id == 1000000)
					{
						return Redirect::to( '/leave_approved' );
					}else{
						return Redirect::to( '/profile' );
					}
				} 
				
				else {
					// Regular
					return Redirect::to( '/dashboard' );
				}
				
			} else {
				
				Session::put( 'exception', 'User Id Or Password Invalid !' );
				return Redirect::to( '/admin' );
				
				//return Redirect::to( "http://www.home.cdipbd.org/login?continue=".\URL::to( '/' )."&param=admin-login-check" );
			}
			
		}
		
		
		public function update_salary()
		{
			
			
			$data['nav'] = DB::table('tbl_navbar as nav')
								->leftjoin('tbl_navbar_group as group', 'nav.nav_group_iddd', '=', 'group.nav_group_id')
								->select('group.nav_group_name','nav.nav_name' )
								->get();
			
			
			echo '<pre>';
			print_r( $data );
			exit;
			
			
			$infos = DB::table( 'tbl_emp_salary' )
			           ->select( '*' )
			           ->where( 'letter_date', '>=', '2020-02-29' )
			           ->where( 'transection', '>=', 2 )
			           ->get();
			
			
			echo '<pre>';
			print_r( $infos );
			exit;
			
			//$data['item_name'] = $info->item_name;
			//$data['type'] = $info->type;
			//$data['percentage'] = $info->percentage;
			
			//DB::table('tbl_salary_plus')->insert($data);
			
			
			foreach ( $infos as $info ) {
				
				$id           = $info->id;
				$salary_basic = $info->salary_basic;
				$pf           = round( ( $salary_basic * 20 ) / 100 );
				$death        = round( ( $salary_basic * 1 ) / 100 );
				
				$update[ 'minus_item' ]  = $pf.','.$death;
				$total_minus             = ( $pf + $death );
				$update[ 'total_minus' ] = $total_minus;
				$net_payable             = ( $info->payable - $total_minus );
				$update[ 'net_payable' ] = $net_payable;
				
				if ( $info->net_payable == $info->gross_total ) {
					$update[ 'gross_total' ] = $net_payable;
				} else {
					$update[ 'gross_total' ] = $net_payable + $info->others_total_plus;
				}
				
				$aaaa[] = $update;
				
				
				//DB::table('tbl_emp_salary')->where('id', $id)->update($update);
				
			}
			
			echo '<pre>';
			print_r( $aaaa );
			exit;
			
			
			//echo '<pre>';
			//print_r($data);
			//exit;
			
		}
		
		public function abc()
		{
			
			
			$infos = DB::table( 'tbl_appointment_info' )
			->select( 'id','emp_id','joining_date', 'next_permanent_date')
			->where( 'emp_group', '=', 1 )
			->where( 'next_permanent_date', '=', Null)
			->get();
 
			foreach($infos as $info)
			{
				$update['next_permanent_date']  = date('Y-m-d',strtotime($info->joining_date . "+6 months"));
				DB::table('tbl_appointment_info')->where('id', $info->id)->update($update);
			}
			
			echo 'updated';
			//echo '<pre>';
			//print_r($data['next_permanent_date']);
			exit;
			
			
			
			
			
			
			
			$info                        = DB::table( 'tbl_salary_plus' )
			                                 ->select( '*' )
			                                 ->where( 'id', 106 )
			                                 ->first();
			$data[ 'item_name' ]         = $info->item_name;
			$data[ 'type' ]              = $info->type;
			$data[ 'percentage' ]        = $info->percentage;
			$data[ 'percentage_bn' ]     = $info->percentage_bn;
			$data[ 'fixed_amount' ]      = 2000;
			$data[ 'ho_bo' ]             = $info->ho_bo;
			$data[ 'designation_for' ]   = 215;
			$data[ 'active_from' ]       = $info->active_from;
			$data[ 'epmloyee_status' ]   = $info->epmloyee_status;
			$data[ 'emp_department' ]    = $info->emp_department;
			$data[ 'emp_grade' ]         = $info->emp_grade;
			$data[ 'active_upto' ]       = $info->active_upto;
			$data[ 'created_by' ]        = 1;
			$data[ 'org_code' ]          = $info->org_code;
			$data[ 'transnational_use' ] = $info->transnational_use;
			$data[ 'status' ]            = $info->status;
			//DB::table('tbl_salary_plus')->insert($data);
			echo 'Saved';
			print_r( $data );
			exit;
			
			
			/*
			$br 			= 9999;
			$date 			= '2020-03-12';
			$your_url 		= 'http://45.114.85.154/hrm/branch-staff/'.$br.'/'.$date;
			$hr_data		= file_get_contents($your_url);
			$my_staffs 		= json_decode($hr_data);
	
			foreach($my_staffs as $my_staff) {
				
				$str 	= $my_staff->emp_name_eng;
				$people = (explode(" ",$str));
				$data['branch_code'] 	= $my_staff->br_code;
				$data['emp_id'] 		= $my_staff->emp_id;
				$data['emp_type'] 		= 1;
				$data['first_name'] 	= current($people) ;
				$data['last_name'] 		= end($people);
				$data['admin_name'] 	= $my_staff->emp_name_eng;
				$data['email_address'] 	= $my_staff->emp_id;
				$data['cell_no'] 		= '01313';
				$data['admin_password'] = md5('12345678');
				$data['admin_photo'] 	= $my_staff->emp_id.'.jpg';
				$data['access_label'] 	= 12;
				$data['status'] 		= 1;
				$data['user_type'] 		= 6;
				$data['org_code'] 		= 181;
			}
			
			
			print_r($data);
			exit;
			
			*/
			
		}
		
		
		public function Manual()
		{
			
			return view( 'admin.pages.manual' );
		}
	}
