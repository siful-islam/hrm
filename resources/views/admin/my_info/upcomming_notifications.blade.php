@extends('admin.admin_master')
@section('title', 'Upcomming Actiities')
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
                    <div class="user-block">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="table-responsive">
								<h4 align="center" style="color:#950106"> My Staff : Upcoming Activities</h4>
								<hr>
								<table class="table table-bordered table-striped">
                                    <tr>
                                        <td style="background-color: #323131; color: white;" align="center" colspan="8">Upcoming Confirmation/Permanent</td>
                                    </tr>
									<tr>
                                        <th>SL</th>
                                        <th>Employee Name</th>
                                        <th>Employee ID</th>
                                        <th>Branch</th>
                                        <th>Designation</th>
                                        <th>Joining Date</th>
                                        <th>Permanent Date</th>
                                        <th>Days Left</th>
                                    </tr> 
									<?php $i = 1; foreach($staffs as $staff) { ?>
									<?php if($staff['emp_group'] == 1 && $staff['is_permanent'] == 1) { ?>
									<tr>
									<?php $today = date('Y-m-d');
									$notification_start_date = date('Y-m-d',strtotime($staff['next_permanent_date'] . "-45 days"));
									if($today >=$notification_start_date && $today <=$staff['next_permanent_date']) { ?>
										<td><?php echo $i++; ?></td>
										<td><?php echo $staff['emp_name']; ?></td>
										<td><?php echo $staff['emp_id']; ?></td>
										<td><?php echo $staff['branch_name']; ?></td>
										<td><?php echo $staff['designation_name']; ?></td>
										<td><?php echo $staff['joining_date']; ?></td>
										<td><?php echo $staff['next_permanent_date']; ?></td>
										<td align="center" style="color:red">	
											<?php 			
												$letter_date 	= date('Y-m-d');
												$letter_date			= date_create($letter_date);
												$next_permanent_date	= date_create($staff['next_permanent_date']);
												$different_permanent	= date_diff($letter_date,$next_permanent_date);  
												echo $days_left_to_permanent = $different_permanent->format("%a");
											?>
										</td>
									<?php } ?>
									<?php } ?>
									</tr>
									<?php } ?>
                                </table>
								<table class="table table-bordered table-striped">
                                    <tr>
                                        <td style="background-color: #323131; color: white;" align="center" colspan="9">Upcoming Retirement</th>
                                    </tr>
									<tr>
                                        <th>SL</th>
                                        <th>Employee Name</th>
                                        <th>Employee ID</th>
										 <th>Branch</th>
                                        <th>Designation</th>
                                        <th>Joining Date</th>
                                        <th>Birth Date</th>
                                        <th>Present Age</th>
                                        <th>Retirement Left in days</th>
                                    </tr> 
									<?php $s = 1; foreach($staffs as $staff) { ?>
									<tr>
									<?php 
									date_default_timezone_set('Asia/Dhaka');
									$today 					= date('Y-m-d');
									$todates				= date_create($today);
									$birth_date				= date_create($staff['birth_date']);
									$difference 			= date_diff($birth_date, $todates);
									$current_age 			= $difference->y . " years, " . $difference->m." months, ". $difference->d." days"; 
									$retirment_age  		= date('Y-m-d',strtotime($staff['birth_date'] . "+60 years"));
									$present_date			= date_create($today);
									$retirment_date			= date_create($retirment_age);
									$different				= date_diff($present_date,$retirment_date);  
									$days_left_to_retirment = $different->format("%a");
									
									if($days_left_to_retirment <=45) { ?>
										<td><?php echo $s++; ?></td>
										<td><?php echo $staff['emp_name']; ?></td>
										<td><?php echo $staff['emp_id']; ?></td>
										<td><?php echo $staff['branch_name']; ?></td>
										<td><?php echo $staff['designation_name']; ?></td>
										<td><?php echo $staff['joining_date']; ?></td>
										<td><?php echo $staff['birth_date']; ?></td>
										<td><?php echo $current_age; ?></td>
										<td align="center" style="color:red"><?php echo $days_left_to_retirment ?> days</td>
									<?php } ?>
									</tr>
									<?php } ?>
                                </table>
								<table class="table table-bordered table-striped">
                                    <tr>
                                        <td style="background-color: #323131; color: white;" align="center" colspan="8">Upcoming Contract End</th>
                                    </tr>
									<tr>
                                        <th>SL</th>
                                        <th>Employee Name</th>
                                        <th>Employee ID</th>
										 <th>Branch</th>
                                        <th>Designation</th>
                                        <th>Joining Date</th>
                                        <th>Contract End Date</th>
                                        <th>Days Left</th>
                                    </tr> 
									<?php $r = 1; foreach($staffs as $staff) { $emp_id = $staff['emp_id']?>
									<tr>
										<?php if($staff['emp_group'] == 2 ) { 
										$todate_date 			= date('Y-m-d');
										$contruct_renew_date 	= $staff['next_permanent_date'];
										$date3 =date_create($contruct_renew_date);
										$date4 =date_create($todate_date);
										$diffeeeee=date_diff($date4,$date3);
										$contruct_days_left = $diffeeeee->format("%a");
										?>
										<?php if($contruct_days_left <= 45 ) { ?>
										<?php 
										$is_cont_renew = DB::table('tbl_contractual_renew as c')
														->where('c.emp_id', '=', $staff['emp_id'])	
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
										if($contruct_days_left <= 45 && $contruct_days_left >0) { ?>
											<td><?php echo $r++; ?></td>
											<td><?php echo $staff['emp_name']; ?></td>
											<td><?php echo $staff['emp_id']; ?></td>
											<td><?php echo $staff['branch_name']; ?></td>
											<td><?php echo $staff['designation_name']; ?></td>
											<td><?php echo $todate_date; ?></td>
											<td><?php echo $contruct_renew_date; ?></td>
											<td align="center" style="color:red"><?php echo $contruct_days_left; ?> days</td>
										<?php } } ?>

										<?php } ?>
									</tr>
									<?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        //To active  menu.......//
        $(document).ready(function() {
            $("#MainGroupSelf_Care").addClass('active');
            $("#My_Benefits").addClass('active');
        });

    </script>
@endsection
