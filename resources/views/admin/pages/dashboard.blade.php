@extends('admin.admin_master')
@section('title', 'Dashboard')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Dashboard<small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Dashboard</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<!-- Small boxes (Stat box) -->
		<?php $admin_access_label 			= Session::get('admin_access_label'); 
		if(($admin_access_label != 23) && ($admin_access_label != 22) && ($admin_access_label != 25)&& ($admin_access_label != 27)){
		?>
		<div class="row">
			<div class="col-lg-3 col-xs-6">
			  <!-- small box -->
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3>{{$total_employee = 0 }}</h3>
						<p>Total Running Employee</p>
					</div>
					<div class="icon">
						<i class="ion ion-person"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
			  <!-- small box -->
				<div class="small-box bg-red">
					<div class="inner">
						<h3>{{$total_resigned_employee = 0}}</h3>
						<p>Total Resigned Employee</p>
					</div>
					<div class="icon">
						<i class="ion ion-person-add"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
			  <!-- small box -->
				<div class="small-box bg-green">
					<div class="inner">
						<h3>{{$todays_new_emp = 0}}</h3>
						<p>Todays New Employee</p>
					</div>
					<div class="icon">
						<i class="ion ion-person-add"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
			  <!-- small box -->
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3>{{$todays_resign_emp = 0}}</h3>
						<p>Todays Resigned Employee</p>
					</div>
					<div class="icon">
						<i class="ion ion-person"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
			<!-- ./col -->
		</div>
		@if(count($all_result)>0)
		<div class="row">
			<div class="col-md-6 col-md-offset-3" style="margin-bottom:5px;">
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Employee ID</th>
								<th>Sender Employee</th>
								<th>Receiver Employee</th>
								<th>Entry Date</th>                
								<th>Status</th>
							</tr>
						</thead>
						<tbody>								
							{{!$i=1}} @foreach($all_result as $result)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$result->fp_emp_id}}</td>
								<td>{{$result->sender_emp_id}}</td>
								<td>{{$result->receiver_emp_id}}</td>
								<td>{{$result->entry_date}}</td>
								<td class="text-center">
									<a class="btn btn-danger" href="{{URL::to('/fp_file_info')}}" >Receive</a>
								</td>
							</tr>
							@endforeach
						</tbody>    
					</table>
				</div>
			</div>
		</div>
		@endif
		<?php } ?>
		<!-- /.row -->
		<!-- Main row -->
		<div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">


        </section>
        <!-- /.Left col -->
        
		</div>
		<!-- /.row (main row) -->

    </section>
    <!-- /.content -->

						<?php
						
						function upcomming_notification_count()
						{
							$data 			= array();
							$supervisor_id 	= Session::get('emp_id');
							$letter_date 	= date('Y-m-d');
							$category_type 	= 1;
							$form_date 		= date("Y-m-d");
							$status 		= 1;
							$infos = DB::table('supervisor_mapping_ho as mapping')
										->leftJoin('tbl_resignation as r', 'mapping.emp_id', '=', 'r.emp_id')	
										->where('mapping.supervisor_id', $supervisor_id) 
										->where(function($query) use ($status, $form_date) {
											if($status !=2) {
												$query->whereNull('r.emp_id');
												$query->orWhere('r.effect_date', '>', $form_date);
											} else {
												$query->Where('r.effect_date', '<=', $form_date);
											}
										})
										->select('mapping.emp_id','mapping.emp_name') 
										->orderBy('mapping.emp_id', 'asc')
										->get();	

							foreach($infos as $info)
							{
								$emp_id = $info->emp_id;
								$user_type = 1;
								$max_sarok = DB::table('tbl_master_tra as m')
									->where('m.emp_id', '=', $emp_id)
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
								$staffs[] = DB::table('tbl_master_tra as m') 
											->leftJoin('tbl_appointment_info as a', 'm.emp_id', '=', 'a.emp_id')
											->leftJoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
											->leftJoin('tbl_resignation as r', 'a.emp_id', '=', 'r.emp_id')
											->leftJoin('tbl_department as dpt', 'm.department_code', '=', 'dpt.department_id')
											->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
											->leftJoin('tbl_grade_new as g', 'm.grade_code', '=', 'g.grade_code')
											->leftJoin('tbl_branch as b', 'm.br_code', '=', 'b.br_code')
											->where('m.sarok_no', '=', $max_sarok->sarok_no)
											->where('m.emp_id', '=', $max_sarok->emp_id)
											->select('a.emp_id','a.emp_name','a.emp_group','e.birth_date','a.joining_date','a.next_permanent_date','m.is_permanent','r.effect_date as re_effect_date','d.designation_name','b.branch_name','g.grade_name','m.department_code','m.designation_code')
											->first();

							}
							
							
							
							$i = 1; foreach($staffs as $staff) { 
							if($staff->emp_group == 1 && $staff->is_permanent == 1) { 
							$today = date('Y-m-d');
							$notification_start_date = date('Y-m-d',strtotime($staff->next_permanent_date . "-45 days"));
							if($today >=$notification_start_date && $today <=$staff->next_permanent_date) { 
								$i++; 
							} } } 
							//*************//
							$s = 1; foreach($staffs as $staff) { 
							$today 					= date('Y-m-d');
							$retirment_age  		= date('Y-m-d',strtotime($staff->birth_date . "+60 years"));
							$present_date			= date_create($today);
							$retirment_date			= date_create($retirment_age);
							$different				= date_diff($present_date,$retirment_date);  
							$days_left_to_retirment = $different->format("%a");

								if($days_left_to_retirment <=45) {
									$s++;
								} 
							} 
							//*************//
							$r = 1; foreach($staffs as $staff) {
								if($staff->emp_group == 3) { 
								$todate_date 			= date('Y-m-d');
								$contruct_renew_date 	= $staff->next_permanent_date;
								$date3 =date_create($contruct_renew_date);
								$date4 =date_create($todate_date);
								$diffeeeee=date_diff($date4,$date3);
								$contruct_days_left = $diffeeeee->format("%a");
								if($contruct_days_left <= 45 ) {

								$is_cont_renew = DB::table('tbl_contractual_renew as c')
												->where('c.emp_id', '=', $staff->emp_id)	
												->orderBy('c.id', 'DESC')														
												->first();
								if($is_cont_renew)
								{
									$max_renew_date 		= $is_cont_renew->c_end_date;
									$contruct_days_left 	= 0;
									if($is_cont_renew)
									{
										$contruct_renew_date 	= $max_renew_date;
										$date5 					= date_create($contruct_renew_date);
										$date6 					= date_create($todate_date);
										$diffeeeee				= date_diff($date6,$date5);
										$contruct_days_left 	= $diffeeeee->format("%a");
									}
								}
								if($contruct_days_left <= 45 && $contruct_days_left >0) { 
									$r++;
								} } }
							} 
							//*************//
							$permanent = $i	-1;
							$retirment = $r -1;
							$contauct  = $r -1;
							$total = $permanent + $retirment + $contauct;
							return $total;
							
						}

						?>









	<script>
		//To active dashboard menu.......//
		$(document).ready(function() {
			$("#dashboard").addClass('active');
		});
	</script>
@endsection	