@extends('admin.admin_master')
@section('title', 'My Attendance')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Self<small>Care</small></h1>
    </section>
    <section class="content-header">
        <a href="{{ URL::to('/profile') }}">
            <h5><i class="fa fa-arrow-left" aria-hidden="true"></i> Self Care</h5>
        </a>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="nav-tabs-custom">
            <div class="tab-content">
                <div class="post">
					<h2 class="page-header">My Attendance</h2>
					<div class="row">
						<?php
						foreach($holidays as $v_holidays)
						{
							$all_holidays[$v_holidays->holiday_date]= $v_holidays->description;
						}
						$all_leaves=array();
						foreach($leave_info as $v_leave_info)
						{
							foreach(explode(',',$v_leave_info->leave_dates) as $val){
								if($v_leave_info->no_of_days == '0.5')
								{
									if($v_leave_info->apply_for == 2)
									{
										$slot = 'Mornig';
									}else{
										$slot = 'Evening';
									}
									$no_of_days = $v_leave_info->no_of_days.' ('.$slot.' )';
								}else{
									$no_of_days = 1;
								}
								$all_leaves[$val]= $no_of_days;
							}
						}
						$visit_dates = array();
						foreach($visit_info as $v_visit_info)
						{
							
							$from_date = $v_visit_info->from_date;
							$to_date = $v_visit_info->arrival_date;
							for($from_date; $from_date <= $v_visit_info->arrival_date; $from_date = date('Y-m-d', strtotime($from_date .' +1 day')))
							{
								$visit_dates[] = $from_date;
							}
						}
						?>
						<div class="col-md-8 col-md-offset-2">
							<div class="box box-widget widget-user-2">
								<div class="widget-user-header bg-blue">
									<div class="widget-user-image">
										<?php 
										if($emp_photo) { ?>
										<img class="img-circle" src="{{asset('public/employee/'.$emp_photo)}}" alt="User profile picture"> 
										<?php } else { ?>
											<?php if($gender == 'Male') { ?>
											<img class="img-circle" src="{{asset('public/avatars/no_photo_male.png')}}" alt="User profile picture">
											<?php } else{ ?>
											<img class="img-circle" src="{{asset('public/avatars/no_photo_female.jpg')}}" alt="User profile picture">
											<?php } ?>
										<?php } ?>
									</div>
									<h3 class="widget-user-username"><?php echo $emp_name ?> (<?php echo $emp_id ?>)</h3>
								</div>
								<div class="box-footer no-padding">
									<form action="{{URL::to('/attendence')}}" method="post">
									{{ csrf_field() }}	
										<table>
											<tr>
												<td>
													<select name="report_month" id="report_month" class="form-control">
														<option value="01">January</option>
														<option value="02">February</option>
														<option value="03">March</option>
														<option value="04">April</option>
														<option value="05">May</option>
														<option value="06">June</option>
														<option value="07">July</option>
														<option value="08">August</option>
														<option value="09">September</option>
														<option value="10">October</option>
														<option value="11">November</option>
														<option value="12">December</option>
													</select>
												</td>
												<td>
													<select name="report_year" id="report_year" class="form-control">
														<option value="2022">2022</option>
													</select>
												</td>
												<td>
													<button type="submit" class="btn btn-info"> <i class="fa fa-play" aria-hidden="true"></i> Show</button>
												</td>
												<td>
													<button type="button" class="btn btn-default pull-right" onClick="printDiv('print_content');"> <i class="fa fa-print"></i> Print </button>
												</td>
											</tr>
										</table>
									</form>
									<br>
									<div id="print_content">
										<table class="table table-bordered table-striped" align="center">
											<tr>
												<th>Sl</th>
												<th>Date</th>
												<th>In Time</th>
												<th>Out Time</th>
												<th>Leave Info</th>
												<th>Visit Info</th>
												<th>Status</th>
											</tr>
											<?php 
											$dataArray=array();
											foreach($info as $myinfo){
												$dataArray[$myinfo->working_date]['working_date']=$myinfo->working_date;
												$dataArray[$myinfo->working_date]['punchingcode']=$myinfo->punchingcode;
												$dataArray[$myinfo->working_date]['out_time']=$myinfo->out_time;
												$dataArray[$myinfo->working_date]['in_time']=$myinfo->in_time;
											}
											$i = 1; foreach($info as $v_info) {
											} ?>
											<?php
											$days = cal_days_in_month(CAL_GREGORIAN,$month,$year);
											for ($dd = 1; $dd <= $days; $dd++) {
												if($dd < 10)
												{
													$dd = '0'.$dd;
												}
												$dates = $year.'-'.$month.'-'.$dd; 
												$today = date('Y-m-d');
												if($dates > $today)
												{
													$status = '-';	
												}else{
													$status = 'Present';
												}
											?>
											<tr>
												<td>{{$i++}}</td>
												<td><?php echo $dates; ?></td>
												<td align="center">
													<?php 
														if(!empty($dataArray[$dates])){
															echo $in_time = ($dataArray[$dates]['in_time']);
														}else{
															echo '-';
														}
													?>
												</td>
												<td align="center">
													<?php 
														if(!empty($dataArray[$dates])){
															if($dataArray[$dates]['in_time'] == $dataArray[$dates]['out_time'])
															{
																$out_time = '-';
															}
															else{
																$out_time = $v_info->out_time;
															}
															echo $out_time;
														}else{
															echo $out_time = '-';
														}
													?>
												</td>
												<td align="center">
												<?php 
												if(!empty($all_leaves[$dates])){
													if($all_leaves[$dates] == 1)
													{
														echo 'Leave';
													}
													else{
														echo 'Leave ('. $all_leaves[$dates].')';
													}
												}else{
													echo '-';
												}
												?>
												</td>
												<td align="center">
												<?php
												if (in_array($dates, $visit_dates))
												{
													echo $visit_status = 'in Visit';
												}else{
													echo $visit_status = '-';
												}?>
												</td>
												<?php 
												if(!empty($dataArray[$dates])){
														$status = $status;
													}else{
														if(!empty($all_leaves[$dates])){
															$status = 'Leave';
															$color = 'black';
														}else{
															$status = 'Absent';
															$color = 'red';
														}
													}
												?>
												<?php 
												$color = 'green';
												$timestamp = strtotime($dates);
												$day = date('D', $timestamp);
												if($day == 'Fri' || $day == 'Sat')
												{
													$status = 'Holi Day (Weekend)';
													$color = 'blue';
												}
												if(!empty($all_holidays[$dates]))
												{
													$status = $all_holidays[$dates];
													$color = '#FF5733';
												}
												?>
												
												<td style="color:<?php echo $color; ?>" align="center"><?php echo $status; ?></td>
											</tr>
											<?php } ?>									
										</table>
									</div>
								</div>
							</div>
						</div>
                    </div>           
                </div>
            </div>
        </div>
    </section>
	
	<script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;
            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
                "<html><head><title></title></head><body>" +
                divElements + "</body>";
            //Print Page
            window.print();
            //Restore orignal HTML
            document.body.innerHTML = oldPage;
        }
    </script>
    <script>
	document.getElementById("report_month").value = '<?php echo $report_month ?>';
	document.getElementById("report_year").value = '<?php echo $report_year ?>';
	//MENU ACTIVE
	$(document).ready(function() {
		$("#MainGroupSelf_Care").addClass('active');
		$("#My_Attendence").addClass('active');
	});
    </script>
@endsection
