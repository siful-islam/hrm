<?php $__env->startSection('title', 'Loan Application'); ?>
<?php $__env->startSection('main_content'); ?>
	<section class="content-header">
		<h1>Loan Application<small>Location</small></h1>
	</section>
	<!-- Main content -->
	<section class="content">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
		<div class="row">

				<div class="col-md-10">
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#timeline" data-toggle="tab">Loan Application</a></li>
						</ul>
						<div class="tab-content">
							<div class="active tab-pane" id="activity">
								
								<?php
								if($approve_location->application_stage == 0)
								{
									$color = 'green';
									$icon = 'file bg-purple';
								}elseif($approve_location->application_stage == 1)
								{
									$color = 'green';
									$icon = 'file bg-purple';
								}elseif($approve_location->application_stage == 2)
								{
									$color = 'green';
									$icon = 'file bg-purple';
								}elseif($approve_location->application_stage == 3)
								{
									$color = 'green';
									$icon = 'file bg-purple';
								}else{
									$color = 'red';
									$icon = 'clock-o bg-blue';
								}
								?>
							
							
							
								<ul class="timeline timeline-inverse">
									<li class="time-label">
									<?php
									if($approve_location->application_stage == 0)
									{
										$colors = 'green';
										$icon = 'file bg-purple';
									}else{
										$colors = 'green';
										$icon = 'file bg-purple';
									}?>
										<span class="bg-<?php echo $colors; ?>">Recomendations</span>
									</li>
									<li>
										<i class="fa fa-<?php echo $icon; ?>"></i>
										<div class="timeline-item">
											<h3 class="timeline-header"><a href="#">Application for Recomendation</a></h3>
											
											<div class="timeline-body">
													<table class="table table-bordered table-striped">
														<tr>
															<th>#</th>
															<th>Supervisor Name</th>
															<th>ID</th>
															<th>Designation</th>
															<th>Action Date</th>
															<th>Action</th>
															<th>Location</th>
														</tr>
														<?php $r = 1; $reject = 0; $stp = 0; foreach($recom_location as $v_recom_location) { ?>
															<?php
															if($approve_location->application_stage == 0)
															{
																if($v_recom_location->actions ==0 && $stp == 0 && $reject == 0)
																{
																	$sup 	= 'Application is here';
																	$stp 	= 1;
																	$color 	= 'red';
																}else{
																	$sup 	= '-';
																	$color 	= 'black';
																}
															}else{
																$sup = '-';
																$color 	= 'black';
															}
															if($v_recom_location->actions == 0)
															{
																$rec_action = 'Pending';
															}elseif($v_recom_location->actions == 1)
															{
																$rec_action = 'Recomended';
															}else{
																$rec_action = 'Rejected';
															}
															
															if($rec_action == 'Rejected')
															{
																$stp 	= 0;
																$sup 	= 'Application is here';
																$color 	= 'red';
																$reject = 1;
															}
															
															
															
															
															?>
														
														<tr>
															<td><?php echo $r++?></td>
															<td><?php echo $v_recom_location->supervisors_name?></td>
															<td><?php echo $v_recom_location->supervisors_id?></td>
															<td><?php echo $v_recom_location->supervisor_designation?></td>
															<td><?php echo $v_recom_location->action_date?></td>
															<td><?php echo $rec_action?></td>
															<td style="color:<?php echo $color?>"><?php echo $sup; ?></td>
														</tr>
														<?php } ?>
													</table>
											</div>
			
										</div>
									</li>
									<?php
									if($approve_location->application_stage == 1)
									{
										$app_colors = 'green';
										$app_icon = 'file bg-purple';
									}else{
										$app_colors = 'red';
										$app_icon = 'clock-o bg-gray';
									}?>
									<li class="time-label">
										<span class="bg-<?php echo $app_colors; ?>">Approval</span>
									</li>
									<li>
										<i class="fa fa-<?php echo $app_icon; ?>"></i>
										<div class="timeline-item">
											<h3 class="timeline-header"><a href="#">Application for Approval</a></h3>
											<div class="timeline-body">

												<table class="table table-bordered table-striped">
													<tr>
														<th>#</th>
														<th>Approvers Name</th>
														<th>ID</th>
														<th>Designation</th>
														<th>Action Date</th>
														<th>Action</th>
														<th>Application</th>
													</tr>
													<?php
														if($approve_location->application_stage == 1)
														{
															$hr = 'Application is here';
															$hr_color = 'red';
														}else{
															$hr = '-';
															$hr_color = 'black';
														}
														if($approve_location->approve_action == 0)
														{
															$hr_action = 'Pending';
														}elseif($v_recom_location->actions == 1)
														{
															$hr_action = 'Recomended';
														}else{
															$hr_action = 'Rejected';
														}
													?>
													<tr>
														<td>1</td>
														<td><?php echo $approves_info->author_name?></td>
														<td><?php echo $approves_info->author_emp_id?></td>
														<td><?php echo $approves_info->author_designation?></td>
														<td><?php echo $approve_location->approve_date?></td>
														<td><?php echo $hr_action?></td>
														<td style="color:<?php echo $hr_color?>"><?php echo $hr; ?></td>
													</tr>
												</table>
											</div>
										</div>
									</li>
									<?php
									if($approve_location->application_stage == 2)
									{
										$dis_colors = 'green';
										$dis_icon = 'file bg-purple';
									}else{
										$dis_colors = 'red';
										$dis_icon = 'clock-o bg-gray';
									}?>
									<li class="time-label">
										<span class="bg-<?php echo $dis_colors; ?>">Disburse</span>
									</li>
									<li>
										<i class="fa fa-<?php echo $dis_icon;?>"></i>
										<div class="timeline-item">
											<h3 class="timeline-header"><a href="#">Application for Disburse</a></h3>
											<div class="timeline-body">
												<table class="table table-bordered table-striped">
													<tr>
														<th>#</th>
														<th>Disburse Officer</th>
														<th>ID</th>
														<th>Designation</th>
														<th>Action Date</th>
														<th>Action</th>
														<th>Application</th>
													</tr>
													<?php
													if($approve_location->application_stage == 2)
													{
														$finance = 'Application is here';
														$fin_color = 'red';
													}else{
														$finance = '-';
														$fin_color = 'black';
													}
													if($approve_location->approve_action == 0)
													{
														$fin_action = 'Pending';
													}elseif($v_recom_location->actions == 1)
													{
														$fin_action = 'Recomended';
													}else{
														$fin_action = 'Rejected';
													}
													?>
													<tr>
														<td>1</td>
														<td><?php echo $disburs_author->author_name?></td>
														<td><?php echo $disburs_author->author_emp_id?></td>
														<td><?php echo $disburs_author->author_designation?></td>
														<td><?php echo $approve_location->approve_date?></td>
														<td><?php echo $fin_action?></td>						
														<td style="color:<?php echo $fin_color?>"><?php echo $finance; ?></td>
													</tr>
												</table>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
		</div>

    </section>

	<script>
		$(document).ready(function() {
			//$("#MainGroupSelf_Care").addClass('active');
			//$("#Leave_Approve").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>