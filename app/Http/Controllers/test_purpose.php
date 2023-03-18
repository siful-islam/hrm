
<?php 
public function leave_check()
    {
        $data = array(); 
		$form_date ="2020-11-30";
		$status = 1;
		$date_within = date("Y-m-d");
		$data['emp_approve_list2'] = DB::table('tbl_leave_balance')
										->where('f_year_id', '=', 4) 
										->select('emp_id','emp_type','f_year_id')
										->get();
		 
		 foreach($data['emp_approve_list2'] as $v_emp_approve_list){
			 if($v_emp_approve_list->emp_type == 1){  
							$emp_info = DB::table('tbl_emp_basic_info as e')
										//->where('e.org_join_date', '<=', $form_date) 
										->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
										->where(function($query) use ($status, $date_within) {
													if($status !=2) {
														$query->whereNull('r.emp_id');
														$query->orWhere('r.effect_date', '>', $date_within);
													} else {
														$query->Where('r.effect_date', '<=', $date_within);
													}
												})
											
										->where('e.emp_id',  $v_emp_approve_list->emp_id) 
										->select('e.*')
										->first(); 
							if($emp_info){
								////////////////START SAIFUL///////////
								$leavedata = array();
								 
								
								if($emp_info->org_join_date >= '2020'.'-'.'11'.'-'.'30'){
									$leave_joining_date = date('Y-m-d',strtotime($emp_info->org_join_date));
									$join_year			  = date('Y',strtotime($leave_joining_date)); 
									$join_month 		  = date('m',strtotime($leave_joining_date));
								   if (date('m') <= 6) { 
										$f_year_start  = (date('Y')-1) ;
										$f_year_end    = date('Y');   
									}else{ 
										$f_year_start  = date('Y');  
										$f_year_end    = (date('Y') + 1); 
									}
								 
									$f_date_start   =  date('Y-m-d',strtotime(($f_year_start)."-"."06"."-"."30"));
									$join_day 		= date('d',strtotime($leave_joining_date));
									$additional_day = 0;
									$additional_day_casual = 0;
									if($leave_joining_date > $f_date_start){
										 if($join_day <= 10){
											$additional_day = 1.5;
										}else if($join_day <= 20){
											$additional_day = 1;
										}else{
											$additional_day = 0.5;
										}
										if($join_day <=15){
											$additional_day_casual = 1;
										}else{
											$additional_day_casual = 0;
										}
										$month_difference =(($f_year_end * 12 )+ 6)-(($join_year*12) + $join_month);
										$current_date = $leave_joining_date;
									}else{
										$month_difference = 12; 
										$current_date = date('Y-m-d');
									}
									if($month_difference <  12 && $month_difference >= 0){
										$total_day = ($month_difference * 1.5 ) + $additional_day;
										$total_day_casual = ($month_difference * 1 ) + $additional_day_casual;
									}else if($month_difference < 0 && $month_difference >= -12){
										$month_difference = 12 + $month_difference;
										$total_day = ($month_difference * 1.5 ) + $additional_day;
										$total_day_casual = ($month_difference * 1 ) + $additional_day_casual;
									}else{
										$total_day = 18 ;
										$total_day_casual = 12 ;
									} 
									$leavedata['casual_leave_open'] = $total_day_casual;
									 
									$leavedata['casual_leave_close'] = $total_day_casual; 
								}else{
									$leavedata['casual_leave_open'] = 7;
									 
									$leavedata['casual_leave_close'] = 7; 
								}
								
								 $leavedata['eid_earn_leave_open'] = 0;
								 $leavedata['eid_earn_leave_close'] = 0;
								 
								 DB::table('tbl_leave_balance')
									->where('emp_type', $v_emp_approve_list->emp_type)
									->where('emp_id', 	$v_emp_approve_list->emp_id)
									->where('f_year_id', $v_emp_approve_list->f_year_id)
									->update($leavedata);
								////////////////END SAIFUL///////////
							}	 
				
				}else{ 
						$emp_info = DB::table('tbl_emp_non_id as e')
										->leftJoin('tbl_emp_non_id_cancel as nc', 'e.emp_id', '=', 'nc.emp_id')
										//->where('e.org_join_date', '<=', $form_date) 
										->where('e.sacmo_id',  $v_emp_approve_list->emp_id) 
										->where('e.emp_type_code',  $v_emp_approve_list->emp_type)  
										->Where(function($query) use ($date_within) {
													$query->whereNull('nc.emp_id');
													$query->orWhere('nc.cancel_date', '>', $date_within);								
												})
										->select('e.*')
										->first(); 
					if($emp_info){
								if($emp_info->joining_date >= '2020'.'-'.'11'.'-'.'30'){
									////////////////START SAIFUL///////////
									$leavedata = array();
									$leave_joining_date = date('Y-m-d',strtotime($emp_info->joining_date));
									$join_year			  = date('Y',strtotime($leave_joining_date)); 
									$join_month 		  = date('m',strtotime($leave_joining_date));
								   if (date('m') <= 6) { 
										$f_year_start  = (date('Y')-1) ;
										$f_year_end    = date('Y');   
									}else{ 
										$f_year_start  = date('Y');  
										$f_year_end    = (date('Y') + 1); 
									}
								 
									$f_date_start   =  date('Y-m-d',strtotime(($f_year_start)."-"."06"."-"."30"));
									$join_day 		= date('d',strtotime($leave_joining_date));
									$additional_day = 0;
									$additional_day_casual = 0;
									if($leave_joining_date > $f_date_start){
										 if($join_day <= 10){
											$additional_day = 1.5;
										}else if($join_day <= 20){
											$additional_day = 1;
										}else{
											$additional_day = 0.5;
										}
										if($join_day <=15){
											$additional_day_casual = 1;
										}else{
											$additional_day_casual = 0;
										}
										$month_difference =(($f_year_end * 12 )+ 6)-(($join_year*12) + $join_month);
										$current_date = $leave_joining_date;
									}else{
										$month_difference = 12; 
										$current_date = date('Y-m-d');
									}
									if($month_difference <  12 && $month_difference >= 0){
										$total_day = ($month_difference * 1.5 ) + $additional_day;
										$total_day_casual = ($month_difference * 1 ) + $additional_day_casual;
									}else if($month_difference < 0 && $month_difference >= -12){
										$month_difference = 12 + $month_difference;
										$total_day = ($month_difference * 1.5 ) + $additional_day;
										$total_day_casual = ($month_difference * 1 ) + $additional_day_casual;
									}else{
										$total_day = 18 ;
										$total_day_casual = 12 ;
									} 
									$leavedata['eid_earn_leave_open'] = 0;
									$leavedata['eid_earn_leave_close'] = 0;
									$leavedata['casual_leave_open'] = $total_day_casual;
									 
									$leavedata['casual_leave_close'] = $total_day_casual;
								}else{
									$leavedata['eid_earn_leave_open'] = 0;
									$leavedata['eid_earn_leave_close'] = 0;
									$leavedata['casual_leave_open'] = 7;
									 
									$leavedata['casual_leave_close'] = 7;
								}
								 
								 
								DB::table('tbl_leave_balance')
									->where('emp_type', $v_emp_approve_list->emp_type)
									->where('emp_id', 	$v_emp_approve_list->emp_id)
									->where('f_year_id', $v_emp_approve_list->f_year_id)
									->update($leavedata);
								////////////////END SAIFUL///////////
							}
				}
		 }
		   
		 
    }
	public function leave_check()
    {
        $data = array(); 
        $udata1 = array(); 
        $udata = array(); 
        $udata2 = array(); 
		$form_date ="2020-11-30";
		$status = 1;
		$date_within = date("Y-m-d");
		$data['emp_approve_list2'] = DB::table('tbl_leave_balance')
										->where('f_year_id', '=', 4) 
										->select('*')
										->get();
		 
		 foreach($data['emp_approve_list2'] as $v_emp_approve_list){
			 if($v_emp_approve_list->emp_type == 1){
							$emp_info = DB::table('tbl_emp_basic_info as e')
										//->where('e.org_join_date', '<=', $form_date)
										->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
										->where(function($query) use ($status, $date_within) {
													if($status !=2) {
														$query->whereNull('r.emp_id');
														$query->orWhere('r.effect_date', '>', $date_within);
													} else {
														$query->Where('r.effect_date', '<=', $date_within);
													}
												})
											
										->where('e.emp_id',  $v_emp_approve_list->emp_id) 
										->select('e.*')
										->first(); 
							if($emp_info){
								////////////////START SAIFUL///////////
								
								 
								
								if($emp_info->org_join_date > '2020'.'-'.'06'.'-'.'30'){
									  echo "<br>";  
									  echo $emp_info->emp_id;
									  echo "<br>";
										
									 
									$leave_joining_date = date('Y-m-d',strtotime($emp_info->org_join_date));
									$join_year			  = date('Y',strtotime($leave_joining_date)); 
									$join_month 		  = date('m',strtotime($leave_joining_date));
								   if (date('m') <= 6) { 
										$f_year_start  = (date('Y')-1) ;
										$f_year_end    = date('Y');   
									}else{ 
										$f_year_start  = date('Y');  
										$f_year_end    = (date('Y') + 1); 
									}
								 
									$f_date_start   =  date('Y-m-d',strtotime(($f_year_start)."-"."06"."-"."30"));
									$join_day 		= date('d',strtotime($leave_joining_date));
									$additional_day = 0;
									 
									if($leave_joining_date > $f_date_start){
										 if($join_day <= 10){
											$additional_day = 2;
										}else if($join_day <= 20){
											$additional_day = 1.5;
										}else{
											$additional_day = 1;
										}
										 
										$month_difference =(($f_year_end * 12 )+ 6)-(($join_year*12) + $join_month);
										$current_date = $leave_joining_date;
									}else{
										$month_difference = 12; 
										$current_date = date('Y-m-d');
									}
									
									if($month_difference <  12 && $month_difference >= 0){
										$total_day = ($month_difference * 2 ) + $additional_day;
										 
									}else if($month_difference < 0 && $month_difference >= -12){
										$month_difference = 12 + $month_difference;
										$total_day = ($month_difference * 2 ) + $additional_day;
										 
									}else{
										$total_day = 24 ;
										 
									}		
									$udata['current_open_balance'] 		=   $total_day;
									$udata['current_close_balance'] 	=   $total_day	- $v_emp_approve_list->no_of_days;
									DB::table('tbl_leave_balance')
										->where('emp_type', $v_emp_approve_list->emp_type)
										->where('emp_id', $v_emp_approve_list->emp_id)
										->where('f_year_id', $v_emp_approve_list->f_year_id)
										->update($udata);
										
								}else{
									/* echo $emp_info->emp_id; 
									echo "<br>";  */
									$udata['current_open_balance'] 		=  $v_emp_approve_list->current_open_balance + 3;
									$udata['current_close_balance'] 	= $v_emp_approve_list->current_close_balance + 3;
									 DB::table('tbl_leave_balance')
										->where('emp_type', $v_emp_approve_list->emp_type)
										->where('emp_id', $v_emp_approve_list->emp_id)
										->where('f_year_id', $v_emp_approve_list->f_year_id)
										->update($udata); 
									
								}
								
								 
								////////////////END SAIFUL///////////
							}	 
				
				}else{
						
							$emp_info = DB::table('tbl_emp_non_id as e')
										//->where('e.org_join_date', '<=', $form_date) 
										->leftJoin('tbl_emp_non_id_cancel as nc', 'e.emp_id', '=', 'nc.emp_id')
										->where('e.sacmo_id',  $v_emp_approve_list->emp_id) 
										->where('e.emp_type_code',  $v_emp_approve_list->emp_type)
										 
										->Where(function($query) use ($date_within) {
													$query->whereNull('nc.emp_id');
													$query->orWhere('nc.cancel_date', '>', $date_within);								
												})
										->select('e.*')
										->first(); 
							if($emp_info){
								if($emp_info->joining_date > '2020'.'-'.'06'.'-'.'30'){
									 echo "<br>";  
									 echo $emp_info->emp_id; 
									echo "<br>"; 
									$leave_joining_date = date('Y-m-d',strtotime($emp_info->joining_date));
									$join_year			  = date('Y',strtotime($leave_joining_date)); 
									$join_month 		  = date('m',strtotime($leave_joining_date));
								   if (date('m') <= 6) { 
										$f_year_start  = (date('Y')-1) ;
										$f_year_end    = date('Y');   
									}else{ 
										$f_year_start  = date('Y');  
										$f_year_end    = (date('Y') + 1); 
									}
								 
									$f_date_start   =  date('Y-m-d',strtotime(($f_year_start)."-"."06"."-"."30"));
									$join_day 		= date('d',strtotime($leave_joining_date));
									$additional_day = 0;
									 
									if($leave_joining_date > $f_date_start){
										 if($join_day <= 10){
											$additional_day = 2;
										}else if($join_day <= 20){
											$additional_day = 1.5;
										}else{
											$additional_day = 1;
										}
										 
										$month_difference =(($f_year_end * 12 )+ 6)-(($join_year*12) + $join_month);
										$current_date = $leave_joining_date;
									}else{
										$month_difference = 12; 
										$current_date = date('Y-m-d');
									}
									if($month_difference <  12 && $month_difference >= 0){
										$total_day = ($month_difference * 2 ) + $additional_day;
										 
									}else if($month_difference < 0 && $month_difference >= -12){
										$month_difference = 12 + $month_difference;
										$total_day = ($month_difference * 2 ) + $additional_day;
										 
									}else{
										$total_day = 24 ;
										 
									}		
									 $udata1['current_open_balance'] 	=   $total_day;
									$udata1['current_close_balance'] 	= 	 $total_day	- $v_emp_approve_list->no_of_days;
									DB::table('tbl_leave_balance')
										->where('emp_type', $v_emp_approve_list->emp_type)
										->where('emp_id', $v_emp_approve_list->emp_id)
										->where('f_year_id', $v_emp_approve_list->f_year_id)
										->update($udata1); 
								
								
								}else{
									$udata1['current_open_balance'] 		=  $v_emp_approve_list->current_open_balance + 6;
									$udata1['current_close_balance'] 		= $v_emp_approve_list->current_close_balance + 6;
									DB::table('tbl_leave_balance')
										->where('emp_type', $v_emp_approve_list->emp_type)
										->where('emp_id', $v_emp_approve_list->emp_id)
										->where('f_year_id', $v_emp_approve_list->f_year_id)
										->update($udata1);
								}
								  
								////////////////END SAIFUL///////////
							}
					}
		 }
		   
		 
    }
	/////////////////////// emp_type  update //////////////
	public function leave_check()
    {
        $udata1 = array();
		 $emp_info = DB::table('tbl_emp_non_id as e') 
										->select('e.*')
										->get(); 
		 
		 
		 foreach($emp_info as $v_emp_approve_list){ 
		 
				 $udata1['emp_id'] = $v_emp_approve_list->emp_id + 100000 ; 
					 DB::table('tbl_edms_document')
						->where('emp_type', $v_emp_approve_list->emp_type_code)
						->where('emp_id', $v_emp_approve_list->sacmo_id) 
						->update($udata1); 			
		 }  
    }
	
	public function leave_check()
    {
        $udata1 = array();
		 $emp_info = DB::table('tbl_edms_document as e') 
										->where('e.emp_type','!=', 1)
										->select('e.*')
										->get(); 
		 
		 
		 foreach($emp_info as $v_emp_approve_list){ 
		 
				 $emp_id = $v_emp_approve_list->emp_id - 100000 ; 
				 $emp_id1 = $v_emp_approve_list->emp_id; 
				  
				$emo_infor =  DB::table('tbl_emp_non_id') 
								->where('emp_id', $emp_id) 
								->select('*')
								->first(); 	
					if($emo_infor){
						
						$udata1['emp_id'] = $emo_infor->sacmo_id;
						
						 DB::table('tbl_edms_document') 
						->where('emp_id', $emp_id1) 
						->update($udata1); 
					}
		 }  
    } 
	
//	ratul vai


public function leave_check()
    {
        $data = array(); 
        $udata1 = array(); 
        $udata = array(); 
        $udata2 = array(); 
		$form_date ="2020-11-30";
		$status = 1;
		$date_within = date("Y-m-d");
		$data['emp_approve_list2'] = DB::table('tbl_leave_balance')
										->where('f_year_id', '=', 4) 
										->select('*')
										->get();
		 
		 foreach($data['emp_approve_list2'] as $v_emp_approve_list){
			 if($v_emp_approve_list->emp_type == 1){
							$emp_info = DB::table('tbl_emp_basic_info as e')
										//->where('e.org_join_date', '<=', $form_date)
										->leftJoin('tbl_resignation as r', 'e.emp_id', '=', 'r.emp_id')
										->where(function($query) use ($status, $date_within) {
													if($status !=2) {
														$query->whereNull('r.emp_id');
														$query->orWhere('r.effect_date', '>', $date_within);
													} else {
														$query->Where('r.effect_date', '<=', $date_within);
													}
												})
											
										->where('e.emp_id',  $v_emp_approve_list->emp_id) 
										->select('e.*')
										->first(); 
							if($emp_info){
								////////////////START SAIFUL///////////
								
								 
								
								if($emp_info->org_join_date > '2020'.'-'.'06'.'-'.'30'){
									  echo "<br>";  
									  echo $emp_info->emp_id;
									  echo "<br>";
										
									 
									$leave_joining_date = date('Y-m-d',strtotime($emp_info->org_join_date));
									$join_year			  = date('Y',strtotime($leave_joining_date)); 
									$join_month 		  = date('m',strtotime($leave_joining_date));
								   if (date('m') <= 6) { 
										$f_year_start  = (date('Y')-1) ;
										$f_year_end    = date('Y');   
									}else{ 
										$f_year_start  = date('Y');  
										$f_year_end    = (date('Y') + 1); 
									}
								 
									$f_date_start   =  date('Y-m-d',strtotime(($f_year_start)."-"."06"."-"."30"));
									$join_day 		= date('d',strtotime($leave_joining_date));
									$additional_day = 0;
									 
									if($leave_joining_date > $f_date_start){
										 if($join_day <= 10){
											$additional_day = 1.5;
										}else if($join_day <= 20){
											$additional_day = 1;
										}else{
											$additional_day = .5;
										}  
									} 
									if($emp_info->org_join_date <= '2020-11-30'){
									 $additional_day += ((12 - date("m", strtotime($emp_info->org_join_date))) * 1.5); 
									
									} 
									 $additional_day += 12;
									$udata['current_open_balance'] 		=   $additional_day;
									$udata['current_close_balance'] 	=   $additional_day	- $v_emp_approve_list->no_of_days;
									 DB::table('tbl_leave_balance')
										->where('emp_type', $v_emp_approve_list->emp_type)
										->where('emp_id', $v_emp_approve_list->emp_id)
										->where('f_year_id', $v_emp_approve_list->f_year_id)
										->update($udata); 
										
								}else{
									/* echo $emp_info->emp_id; 
									echo "<br>";  */
									$udata['current_open_balance'] 		=  $v_emp_approve_list->current_open_balance + 3;
									$udata['current_close_balance'] 	= $v_emp_approve_list->current_close_balance + 3;
									  DB::table('tbl_leave_balance')
										->where('emp_type', $v_emp_approve_list->emp_type)
										->where('emp_id', $v_emp_approve_list->emp_id)
										->where('f_year_id', $v_emp_approve_list->f_year_id)
										->update($udata); 
									
								}
								
								 
								////////////////END SAIFUL///////////
							}	 
				
				}else{
						
							$emp_info = DB::table('tbl_emp_non_id as e')
										//->where('e.org_join_date', '<=', $form_date) 
										->leftJoin('tbl_emp_non_id_cancel as nc', 'e.emp_id', '=', 'nc.emp_id')
										->where('e.sacmo_id',  $v_emp_approve_list->emp_id) 
										->where('e.emp_type_code',  $v_emp_approve_list->emp_type)
										 
										->Where(function($query) use ($date_within) {
													$query->whereNull('nc.emp_id');
													$query->orWhere('nc.cancel_date', '>', $date_within);								
												})
										->select('e.*')
										->first(); 
							if($emp_info){
								if($emp_info->joining_date > '2020'.'-'.'06'.'-'.'30'){
									 echo "<br>";  
									 echo $emp_info->emp_id; 
									echo "<br>"; 
									$leave_joining_date = date('Y-m-d',strtotime($emp_info->joining_date));
									$join_year			  = date('Y',strtotime($leave_joining_date)); 
									$join_month 		  = date('m',strtotime($leave_joining_date));
								   if (date('m') <= 6) { 
										$f_year_start  = (date('Y')-1) ;
										$f_year_end    = date('Y');   
									}else{ 
										$f_year_start  = date('Y');  
										$f_year_end    = (date('Y') + 1); 
									}
								 
									$f_date_start   =  date('Y-m-d',strtotime(($f_year_start)."-"."06"."-"."30"));
									$join_day 		= date('d',strtotime($leave_joining_date));
									$additional_day = 0;
									  
									if($leave_joining_date > $f_date_start){
										 if($join_day <= 10){
											$additional_day = 1.5;
										}else if($join_day <= 20){
											$additional_day = 1;
										}else{
											$additional_day = .5;
										}  
									} 
									if($emp_info->org_join_date <= '2020-11-30'){
									 $additional_day += ((12 - date("m", strtotime($emp_info->org_join_date))) * 1.5); 
									
									} 
									$additional_day += 12;	
									$udata1['current_open_balance'] 	=   $additional_day;
									$udata1['current_close_balance'] 	= 	 $additional_day	- $v_emp_approve_list->no_of_days;
									 DB::table('tbl_leave_balance')
										->where('emp_type', $v_emp_approve_list->emp_type)
										->where('emp_id', $v_emp_approve_list->emp_id)
										->where('f_year_id', $v_emp_approve_list->f_year_id)
										->update($udata1); 
								
								
								}else{
									$udata1['current_open_balance'] 		=  $v_emp_approve_list->current_open_balance + 3;
									$udata1['current_close_balance'] 		= $v_emp_approve_list->current_close_balance + 3;
									 DB::table('tbl_leave_balance')
										->where('emp_type', $v_emp_approve_list->emp_type)
										->where('emp_id', $v_emp_approve_list->emp_id)
										->where('f_year_id', $v_emp_approve_list->f_year_id)
										->update($udata1); 
								}
								  
								////////////////END SAIFUL///////////
							}
					}
		 }
		   
		 
    }
?>