<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Redirect;
use Session;
//session_start();

class MigrationController extends Controller
{

    
	 public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index_qqqqqqqq()
    {
        $allData = DB::table('tbl_emp_salary')
            ->where('ins_urance', '!=', null)
            ->Where('ins_urance', '!=', 0)
            ->get();
//        dd(count($allData));
        $plus_item_id = array();
        $plus_item = array();

        $minus_item_id = array();
        $minus_item = array();
        foreach ($allData as $all) {
            if ($all->house_rent != '') {
                $plus_item_id[] = 1;
                $plus_item[] = $all->house_rent;
            }
            if ($all->medical_a != '') {
                $plus_item_id[] = 2;
                $plus_item[] = $all->medical_a;
            }
            if ($all->convence_a != '') {
                $plus_item_id[] = 3;
                $plus_item[] = $all->convence_a;
            }
            if ($all->pf != '') {
                $plus_item_id[] = 4;
                $plus_item[] = $all->pf;
            }
            if ($all->field_a != '') {
                $plus_item_id[] = 5;
                $plus_item[] = $all->field_a;
            }
            if ($all->mobile_a != '') {
                $plus_item_id[] = 6;
                $plus_item[] = $all->mobile_a;
            }

            if ($plus_item_id) {
                $data['plus_item_id'] = implode(",", $plus_item_id);
                $data['plus_item'] = implode(",", $plus_item);
            } else {
                $data['plus_item_id'] = '';
                $data['plus_item'] = '';
            }


            if ($all->pf_minus != '') {
                $minus_item_id[] = 1;
                $minus_item[] = $all->pf_minus;
            }
            if ($all->house_minus != '') {
                $minus_item_id[] = 2;
                $minus_item[] = $all->house_minus;
            }
            if ($all->ins_urance != '') {
                $minus_item_id[] = 3;
                $minus_item[] = $all->ins_urance;
            }

            if ($minus_item_id) {
                $data['minus_item_id'] = implode(",", $minus_item_id);
                $data['minus_item'] = implode(",", $minus_item);
            } else {
                $data['minus_item_id'] = '';
                $data['minus_item'] = '';
            }


            DB::table('tbl_emp_salary')->where('id', '=', $all->id)->update($data);
            $plus_item_id = '';
            $plus_item = '';
            $minus_item_id = '';
            $minus_item = '';

        }
        dd(count($allData));
    }
	
	
	
	
	
	
	
	
	
	
	public function index_ratul()
    {

        date_default_timezone_set('Asia/Dhaka');
        $letter_date = '2018-07-01';

        $data['max_id'] = \DB::table("tbl_master_tra")
            ->where('letter_date', '>=', $letter_date)
            ->get();
			
        $desi['management'] = ['144'];

        $desi['hrd'] = ['187', '193', '196', '202', '204', '206'];

        $desi['programe'] = ['11', '16', '24', '38', '75', '97', '122', '147', '170', '192', '194', '198', '207', '209', '210', '211', '212', '213', '215'];

        $desi['finance'] = ['145', '197', '199', '203'];

        $desi['it'] = ['205', '208'];

        $desi['mis'] = ['195', '200'];

        $desi['pub'] = ['201'];

        $desi['edu'] = ['214'];

        $desi['agri'] = ['217'];

        $desi['solar'] = ['216'];

        foreach ($data['max_id'] as $max_id){

            /*if(in_array($max_id->designation_code,$desi['management'])){
                $master_data['department_code'] = '1';
            }

            if(in_array($max_id->designation_code,$desi['hrd'])){
                $master_data['department_code'] = '2';
            }

            if(in_array($max_id->designation_code,$desi['programe'])){
                if($max_id->br_code == '9999'){
                    $master_data['department_code'] = '2';
                }else {
                    $master_data['department_code'] = '3';
                }
            }

            if(in_array($max_id->designation_code,$desi['it'])){
                $master_data['department_code'] = '4';
            }

            if(in_array($max_id->designation_code,$desi['finance'])){
                $master_data['department_code'] = '5';
            }

            if(in_array($max_id->designation_code,$desi['mis'])){
                $master_data['department_code'] = '8';
            }

            if(in_array($max_id->designation_code,$desi['agri'])){
                $master_data['department_code'] = '9';
            }

            if(in_array($max_id->designation_code,$desi['edu'])){
                $master_data['department_code'] = '12';
            }

            if(in_array($max_id->designation_code,$desi['pub'])){
                $master_data['department_code'] = '13';
            }

            if(in_array($max_id->designation_code,$desi['solar'])){
                $master_data['department_code'] = '14';
            }*/


                    //INSERT DATA USING TRANSACTION
                    \DB::beginTransaction();
                    /*try {

                        //UPDATE INTO MASTER TABLE
                        DB::table('tbl_master_tra')
                            ->where('sarok_no', $max_id->sarok_no)
                            ->update($master_data);

                        //COMMIT DB
                        DB::commit();
                        $out[] = $master_data;

                    } catch (\Exception $e) {
                        //PUSH FAIL MESSAGE
                        \Session::put('message','Error: Unable to Save Data');
                        //DB ROLLBACK
                        \DB::rollback();
                    }*/
            for ($i=1; $i<=20; $i++){
                $grade = \DB::table("tbl_grade_new")
                    ->where('grade_code', '=', $max_id->grade_code)
                    ->where("step_$i", '=', $max_id->basic_salary)
                    ->first();
dd(count($grade));
                if(count($grade) != 0) {
                    $master_data['grade_step'] = $i;

                    //INSERT DATA USING TRANSACTION
                    \DB::beginTransaction();
                    try {

                        //UPDATE INTO MASTER TABLE
                        \DB::table('tbl_master_tra')
                            ->where('sarok_no', $max_id->sarok_no)
                            ->update($master_data);

                        //COMMIT DB
                        \DB::commit();
                        $out[] = $master_data;

						echo $max_id->sarok_no."<br>";
						
                    } catch (\Exception $e) {
                        //PUSH FAIL MESSAGE
                        \Session::put('message','Error: Unable to Save Data');
                        //DB ROLLBACK
                        \DB::rollback();
                    }
                }else{
					$master_data['grade_step'] = 1;

                    //INSERT DATA USING TRANSACTION
                    \DB::beginTransaction();
                    try {

                        //UPDATE INTO MASTER TABLE
                        \DB::table('tbl_master_tra')
                            ->where('sarok_no', $max_id->sarok_no)
                            ->update($master_data);

                        //COMMIT DB
                        \DB::commit();
                        $out[] = $master_data;
						echo $max_id->sarok_no."<br>";

                    } catch (\Exception $e) {
                        //PUSH FAIL MESSAGE
                        \Session::put('message','Error: Unable to Save Data');
                        //DB ROLLBACK
                        \DB::rollback();
                    }
				}

            }

        }

        $count = count($out);
		dd($count);
        return \Response::json($count);
    }
	
	
	public function index()
	{
		date_default_timezone_set('Asia/Dhaka');
		$letter_date = '2018-07-01';
		
		$infos = DB::table('tbl_master_tra as m')
					//->join('tbl_grade_new as g', 'g.grade_code', '=', 'm.grade_code','left')
					->where('m.letter_date', '>=', $letter_date)		
					->where('m.basic_salary', '>', 0)		
                   // ->select('m.id','m.br_code','m.sarok_no','m.grade_code','m.basic_salary','g.grade_id','g.grade_name')
                    ->select('m.id','m.emp_id','m.br_code','m.sarok_no','m.grade_code','m.basic_salary')
                    ->get();
					
					
		//echo '<pre>';			
		//print_r($infos);
		//exit;

		
		foreach($infos as $info){
			
			$grade = DB::table("tbl_grade_new")
					->where('grade_code', '=', $info->grade_code)
					->first();
					
			$name_of_array =  (array) $grade;
			
			$steps = array_search($info->basic_salary,$name_of_array);	
			
			
			
			/*
			if($steps !='')
			{
				$str = $steps;
				//echo $info->id.'/'.$str . "<br>";
				echo $step = trim($str,"step_");
				echo '<br>';
					
				DB::table('tbl_master_tra')
				->where('id', $info->id)
				->update(['grade_step' => $step]);

			}
			*/

					
			
			
			
			


			
		}
		
		
		
		/*
		foreach($steps as $key => $value)
		{
			echo $key . '/'. $value.'<br>';
			
			
			$str = $value;
			//echo $str . "<br>";
			echo trim($str,"step_");
			echo '<br>';
		}*/
		
			
		//echo '<pre>';			
		//print_r($steps);			
					
	}
	
	
	
	
	
	
	
	
	
	public function index_2()
    {
		$infos = DB::table('tbl_emp_basic_info')                    
					->join('tbl_master_tra', 'tbl_master_tra.emp_id', '=', 'tbl_emp_basic_info.emp_id','left')
                   // ->where('tbl_master_tra.tran_type_no',1)
                    ->where('tbl_master_tra.tran_type_no',6)
                    ->orderby('tbl_emp_basic_info.emp_id','asc')
                    ->get();
					
		echo '<pre>';
		print_r($infos);
		exit;		

		
		foreach($infos as $info)
		{
			$data['sarok_no'] = $info->sarok_no;
			$data['emp_id'] = $info->emp_id;
			$data['letter_date'] = $info->letter_date;
			$data['emp_name'] = $info->emp_name_eng;
			$data['emp_name_bangla'] = '';
			$data['fathers_name'] = $info->father_name;
			$data['fathers_name_bangla'] = '';
			$data['emp_village'] = $info->vill_road;
			$data['emp_village_bangla'] = '';
			$data['emp_po'] = $info->post_office;
			$data['emp_po_bangla'] = '';
			$data['emp_district'] = $info->district_code;
			$data['emp_thana'] = $info->thana_code;
			$data['joining_date'] = $info->org_join_date;
			$data['joining_branch'] = $info->br_code;
			$data['join_as'] = 1;
			$data['period'] = 6;
			$data['gross_salary'] = $info->net_pay;
			$data['diposit_money'] = 5000;
			$data['emp_designation'] = $info->designation_code;
			$data['emp_department'] = 3;
			$data['grade_code'] = $info->grade_code;
			$data['grade_step'] = 1; 
			//$data['next_permanent_date'] = $info->next_increment_date;
			
			if($info->next_increment_date == '0000-00-00')
			{
				$data['next_permanent_date'] = date('Y-m-d');
			}else{
				$data['next_permanent_date'] = $info->next_increment_date;
			}

			$data['reported_to'] = '';
			$data['br_join_date'] = $info->br_join_date;
			$data['org_code'] = 180;
			DB::table('tbl_appointment_info')->insert($data);
		}
		
		//echo '<pre>';
		//print_r($data);
		
		
		
		//echo 'Saved';


    }
	
	
	/*
	
	for ($x = 1; $x <= 3985; $x++) {

			$data['emp_id'] = $x;
			$data['emp_photo'] = $x.'.jpg';
			$data['org_code'] = 181;
			DB::table('tbl_emp_photo')->insert($data);
		} 
	*/
	
	/*
	
	foreach($infos as $info)
		{
			$data['sarok_no'] = $info->sarok_no;
			$data['emp_id'] = $info->emp_id;
			$data['letter_date'] = $info->L_date;
			$data['emp_name'] = $info->emp_name_eng;
			$data['emp_name_bangla'] = '';
			$data['fathers_name'] = $info->father_name;
			$data['fathers_name_bangla'] = '';
			$data['emp_village'] = $info->vill_road;
			$data['emp_village_bangla'] = '';
			$data['emp_po'] = $info->post_office;
			$data['emp_po_bangla'] = '';
			$data['emp_district'] = $info->district_code;
			$data['emp_thana'] = $info->thana_code;
			$data['joining_date'] = $info->org_join_date;
			$data['joining_branch'] = $info->next_br_code;
			$data['join_as'] = 1;
			$data['period'] = 6;
			$data['gross_salary'] = $info->net_pay;
			$data['diposit_money'] = 5000;
			$data['emp_designation'] = $info->next_designation_code;
			$data['emp_department'] = 3;
			$data['grade_code'] = $info->grade_code;
			$data['grade_step'] = 1; 
			
			if($info->next_incremant_date == '0000-00-00')
			{
				$data['next_permanent_date'] = date('Y-m-d');
			}else{
				$data['next_permanent_date'] = $info->next_incremant_date;
			}

			$data['reported_to'] = '';
			$data['joined_date'] = $info->org_join_date;
			$data['org_code'] = 180;
			//DB::table('tbl_appointment_info')->insert($data);
		}
		*/
		
		/*foreach($infos as $info)
		{
			$data['sarok_no'] = $info->sarok_no;
			$data['emp_id'] = $info->emp_id;
			$data['letter_date'] = $info->L_date;
			$data['effect_date'] = $info->effect_date;
			$data['br_joined_date'] = $info->br_join_date;			
			$data['designation_code'] = $info->next_designation_code;
			$data['br_code'] = $info->next_br_code;
			$data['grade_code'] = $info->grade_code;
			$data['grade_step'] = 1;
			$data['department_code'] = 3;
			$data['report_to'] = '';
			$data['probation_time'] = 6;
			if($info->next_incremant_date == '0000-00-00')
			{
				$data['next_permanent_date'] = date('Y-m-d');
			}else{
				$data['next_permanent_date'] = $info->next_incremant_date;
			}
			
			$data['org_code'] = 180;
			
			
			DB::table('tbl_probation')->insert($data);
			

		}*/
		
		
		
		public function index_qqq()
		{
			$infos = DB::table('tbl_master_tra')                    
                    ->where('br_join_date','>=','2018-07-01')
                    ->where('tran_type_no',8)
                    ->select('emp_id', DB::raw('max(sarok_no) as sarok_no'))
                    ->groupBy('emp_id')
                    ->get();
					
			//echo '<pre>';
			//print_r($infos);
			//exit;

			$i = 1; 
			foreach($infos as $info)
			{
				
				$basic = DB::table('tbl_master_tra')                    
						->where('emp_id',$info->emp_id)
						->whereNotIn('tran_type_no',[1,8])
						->max('basic_salary');
	
						
				echo $info->emp_id.'/'.$basic.'<br>';
				
				$date_time = date('Y-m-d H:i:s');
				
				/*DB::table('tbl_master_tra')
					->where('emp_id', $info->emp_id)
					->where('sarok_no', $info->sarok_no)
					->update(['basic_salary' => $basic, 'updated_at' =>$date_time]);
				*/	
				
				
			}		
					
					
					
			
		}
		
		
		public function index_eee()
		{
			$infos = DB::table('tbl_master_tra')                    
                    ->select('id','br_code')
                    ->get();
					
					
					
			//echo '<pre>';
			//print_r($infos);		
					
					
			$data = array();	
					
			//foreach($infos as $info)
			//{
				//echo $info->id.'-'.$info->br_code.'<br>';
				//DB::table('tbl_master_tra')
				//->where('id', $info->id)
				//->update(['salary_br_code' => $info->br_code]);
				
				
				
				//$data['salary_br_code'] = $info->br_code;
				
				//DB::table('tbl_master_tra')
					//->where('id', $info->id)
					//->update($data);
			//}
			
		
		}
		
		
		// NON ID
		public function index_non()
		{
			$infos = DB::table('tbl_emp_non_id')                    
                    ->get();
					
			//echo '<pre>';
			//print_r($infos);
			
			
			
		
			foreach($infos as $info) 
			{
				$data['emp_id']			 		= $info->emp_id;
				$data['emp_name_eng'] 			= $info->emp_name;
				$data['emp_name_ban'] 			= $info->emp_name;
				$data['father_name'] 			= $info->father_name;
				$data['mother_name'] 			= $info->mother_name;
				$data['birth_date'] 			= $info->birth_date;
				$data['nationality'] 			= $info->nationality;
				$data['religion'] 				= $info->religion;
				$data['country_id'] 			= 1;
				$data['contact_num'] 			= $info->contact_num;
				$data['email'] 					= $info->email;
				$data['national_id'] 			= $info->national_id;
				$data['maritial_status'] 		= $info->maritial_status;
				$data['gender'] 				= $info->gender;
				$data['blood_group'] 			= $info->blood_group;
				$data['present_add'] 			= $info->present_add;
				$data['vill_road'] 				= $info->vill_road;
				$data['post_office'] 			= $info->post_office;
				$data['district_code'] 			= $info->district_code;
				$data['thana_code'] 			= $info->thana_code;
				$data['permanent_add'] 			= $info->permanent_add;
				$data['org_join_date'] 			= $info->br_join_date;
				$data['emp_type'] 				= $info->emp_type;
				$data['org_code'] 				= 180;
				
				
				DB::table('tbl_emp_basic_info')->insert($data);
				
				
			}
			
			/*
	
			foreach($infos as $info)
			{
				
				
				
				$data['sarok_no'] 				= 0;
				$data['emp_id']			 		= $info->emp_id;
				$data['letter_date'] 			= $info->br_join_date;
				$data['emp_name'] 				= $info->emp_name;
				$data['emp_name_bangla'] 		= '';
				$data['fathers_name'] 			= $info->father_name;
				$data['fathers_name_bangla'] 	= '';
				$data['emp_village'] 			= $info->vill_road;
				$data['emp_village_bangla'] 	= '';
				$data['emp_po'] 				= $info->post_office;
				$data['emp_po_bangla'] 			= '';
				$data['emp_district'] 			= $info->district_code;
				$data['emp_thana'] 				= $info->thana_code;
				$data['joining_date'] 			= $info->br_join_date;
				$data['br_join_date'] 			= $info->br_join_date;
				$data['joining_branch'] 		= $info->br_code;
				
				if($info->emp_type == 'sacmo')
				{
					$data['join_as'] 			= 5;
				}
				else if($info->emp_type == 'non_id')
				{
					$data['join_as'] 			= 4;
				}
				else if($info->emp_type == 'shs')
				{
					$data['join_as'] 			= 6;
				}
				

				$data['period'] 				= 6;
				$data['gross_salary'] 			= $info->gross_salary;
				$data['diposit_money'] 			= 0;
				$data['emp_designation']		= $info->designation_code;
				$data['emp_department']			= 6;
				//$data['grade_code']				= '';
				//$data['grade_step'] 			= ''; 
				
				if($info->next_renew_date == '0000-00-00')
				{
					$data['next_permanent_date'] = date('Y-m-d');
				}
				else
				{
					$data['next_permanent_date'] = $info->next_renew_date;
				}

				$data['reported_to'] 			= '';
				$data['org_code'] 				= 180;
				DB::table('tbl_appointment_info')->insert($data);
				
				
				//echo '<pre>';
				//print_r($data);
				
			}
		*/
			
			
			

		
		
		}
		
		public function department () {
			
			
			/* $hr_emp_id = [18,56,527,1023,1294,1298,1299,1318,1662,2138,2272,2333,2540,2556,2818,3009,3015,3400,3481,3514,3589,3627,3963,3964,3993,4118,4188,4235,4236,4239,4317,4588,4664];
			$digitisation_emp_id = [193,1802,2247,2397,2692,2962,2999,3304,3628,4226,4227,4359,4360,4646,4656];
			$microfinance_emp_id = [12,425,563,613,1230,3649,4564];
			$finance_emp_id = [39,298,530,1106,2191,2192,2458,3204,3512,3823,3979,4085,4623,4638,4660];
			$special_emp_id = [361,1061,1584,2069,2722,3154,4666];
			$audit_emp_id = [2028,3113,4230];
			$all_result = DB::table('tbl_emp_mapping')
						//->where('current_department_id', '=', 2)
						->whereIn('emp_id', $hr_emp_id)
						->orderBy('emp_id', 'ASC')
						->get(); */
			
			//print_r ($all_result);
			//exit;
			/* foreach($all_result as $result) {
				$insert_data['emp_id'] = $result->emp_id;
				$insert_data['mother_program_id'] = 1;
				$insert_data['current_program_id'] = 1;
				$insert_data['mother_department_id'] = 26;
				$insert_data['current_department_id'] = 26;
				$insert_data['start_date'] = '2020-12-09';
				//$insert_data['end_date'] = '2020-12-08';
				
				//DB::table('tbl_emp_mapping')->insert($insert_data);
				//DB::table('tbl_emp_mapping')->where('emp_id', $result->emp_id)->update($insert_data);
			} */
			//exit;
			/* $form_date = date('Y-m-d');
			$all_result = DB::table('tbl_emp_basic_info as e')
						->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
						->where('e.emp_type', '=', 'regular')
						->where('e.org_join_date', '<=', $form_date)
						
						->where(function($query) use ($form_date) {								
								$query->whereNull('r.emp_id');
								$query->orWhere('r.effect_date', '>', $form_date);								
							})

						->orderBy('e.emp_id', 'ASC')
						->select('e.emp_id')
						->get();
						
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
						->groupBy('m.emp_id')
						->first();
						
				$data_result = DB::table('tbl_master_tra')
					->where('emp_id', '=', $max_sarok->emp_id)
					->where('sarok_no', '=', $max_sarok->sarok_no)
					->select('emp_id','department_code')
					->first();
				//print_r ($data_result);
				$insert_data['emp_id'] = $data_result->emp_id;
				$insert_data['mother_department_id'] = $data_result->department_code;
				$insert_data['current_department_id'] = $data_result->department_code;
				$insert_data['start_date'] = '2020-02-17';
				
				DB::table('tbl_emp_mapping')->insert($insert_data);
			} */
			
			
		}
		
		
		
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	

}
