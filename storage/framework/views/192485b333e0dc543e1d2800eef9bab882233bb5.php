<?php $__env->startSection('title', 'Employee Status Report'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.content {
	padding-top: 5px;
}
.table-bordered {
    border: 1px solid #757070;
}
.table > thead > tr > th {
    border: 1px solid #757070;
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
	font-weight: bold;
	text-align: center; 
	padding: 2px;
}
.table > tbody > tr > td {
    border: 1px solid #757070;
	padding: 4px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
.form-group {
    margin-bottom: 2px;
}

blink {
    animation: 1s linear infinite condemned_blink_effect;
	color: #900C3F;
	font-weight: bold;
	font-size: 16px;
}
@keyframes  condemned_blink_effect {
    0% {
        visibility: hidden;
    }
    50% {
        visibility: hidden;
    }
    100% {
        visibility: visible;
    }
}
</style>
<br/>
<br/>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small><?php echo e($Heading); ?></small></h1>
</section>
<?php $user_type = Session::get('user_type'); ?>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="<?php echo e(URL::to('/employee-status')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="email">Employee ID :</label>
							<input type="text" id="emp_id" class="form-control" name="emp_id" size="10" value="<?php echo e($emp_id); ?>" required>
						</div>
						<div class="form-group">
						  <label for="pwd">Date WithIn:</label>
						  <input type="text" id="form_date" class="form-control" name="form_date" size="10" value="<?php echo e($form_date); ?>" required>
						</div>						
						<button type="submit" class="btn btn-primary" >Search</button>
						<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>
					</form>
				</div>
			</div>
        </div>
	</div>
	<?php if(!empty($all_result)): ?>
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Employee Status Information</font></b></p>		
			</div>
			<form class="form-horizontal">
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-body">
							<div class="form-group">
								<label for="emp_id" class="col-sm-4 control-label">Employee ID </label>
								<div class="col-sm-7">			
									<p class="form-control-static">: <?php echo e($all_result->emp_id); ?>

										<?php if($user_type == 1 || $user_type == 2) { ?>
										<?php if (isset($increment_heldup)) { echo '<span style="color:#F70408"><b> (Redmarked)</b></span> '; } } ?>
									</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Employee Name </label>
								<div class="col-sm-7">
									<?php if($user_type == 1 || $user_type == 2) { ?>
									<?php if (isset($promotion_heldup)) { echo '<p class="form-control-static" style="font-size:16px;color:#FE9A2E;">: '; } else { echo '<p class="form-control-static" >:'; } } ?>
										<?php echo $all_result->emp_name_eng; ?>
									</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Employee Name (in Bengali)</label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php echo $all_result->emp_name_ban; ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Designation </label>
								<div class="col-sm-7">
									<?php if($user_type == 1 || $user_type == 2) { ?>
									<?php if (isset($permanent_heldup)) { echo '<p class="form-control-static" style="font-size:16px;color:#04B404;">: '; } else { echo '<p class="form-control-static" >:'; } } ?>
										<?php if((!empty($assign_designation->designation_name)) && ($assign_designation->open_date <= $form_date)) { ?>
										<?php echo $assign_designation->designation_name; } else { ?>
										<?php echo $all_result->designation_name; ?><br/>
										<?php } ?>
										<?php if($user_type == 1 || $user_type == 2) { ?>
										<?php if (!empty($assign_emp->incharge_as)) echo '<span style="color:blue;">'.':('.$assign_emp->incharge_as.')';'</span>'?>
										<?php } ?>
									</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Functional Designation</label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php echo e($all_result->fun_deg_name); ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Grade</label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php echo e($all_result->grade_name); ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Joining Date(org)</label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php echo date('d M Y',strtotime($all_result->org_join_date)); ?>
										<?php if($user_type == 1 || $user_type == 2) { ?>
										<?php if (!empty($assign_report_to->incharge_as)) echo '<span style="color:blue;">'.'('.$assign_report_to->incharge_as.')';'</span>'?>
										<?php } ?>
									</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Total Job Duration</label>
								<div class="col-sm-7">
									<p class="form-control-static">: 
										<?php 
										date_default_timezone_set('UTC');
										if(!empty($all_result->re_effect_date)) { 
											$input_date = new DateTime($all_result->re_effect_date);
										} else {
											$input_date1 = date('Y-m-d', strtotime("+1 day", strtotime($form_date)));
											$input_date = new DateTime($input_date1);
										}
										$org_date = new DateTime($all_result->org_join_date);	
										$difference = date_diff($org_date, $input_date);
										// $days = $diff12->d;
										//accesing months
										echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
										//accesing years
										// $years = $diff12->y;
										 ?>
									</p>
								</div>
							</div>
							<?php if (!empty($permanent_date->effect_date)) { ?>
							<div class="form-group">
								<label class="col-sm-4 control-label">Permanent Date </label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php echo e(date('d M Y',strtotime($permanent_date->effect_date))); ?></p>
								</div>
							</div>
							<?php } ?>
							<?php if (!empty($permanent_date->effect_date)) { ?>
							<div class="form-group">
								<label class="col-sm-4 control-label">Duration (Permanent) </label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php 
										date_default_timezone_set('UTC');
										if(!empty($all_result->re_effect_date)) { 
											$input_date = new DateTime($all_result->re_effect_date);
										} else {
											$input_date1 = date('Y-m-d', strtotime("+1 day", strtotime($form_date)));
											$input_date = new DateTime($input_date1);
										}
										$permanent_date = new DateTime($permanent_date->effect_date);	
										$difference = date_diff($permanent_date, $input_date);
										// $days = $diff12->d;
										//accesing months
										echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
										//accesing years
										// $years = $diff12->y;
										 ?>
									</p>
								</div>
							</div>
							<?php } ?>
							<div class="form-group">
								<label class="col-sm-4 control-label">Employee Photo </label>
								<div class="col-sm-7">
									<p class="form-control-static">:
										<img style="height: 80px; width: 75px;" class="img-thumbnail" src="<?php echo e(asset('public/employee/'.$all_result->emp_photo)); ?>" />
									</p>
								</div>
							</div>
						</div>
					  <!-- /.box-body -->           
					</div>
				</div>
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-body">							
							<div class="form-group">
								<label class="col-sm-4 control-label">Present Branch </label>
								<div class="col-sm-7">
									<?php if (empty($assign_branch->branch_name)) { ?>
									<p class="form-control-static">: <?php echo e($all_result->branch_name); ?> (Branch Code - <?php echo e($all_result->br_code); ?>)</p>
									<?php } else { ?>
									<p class="form-control-static">: <?php echo e($assign_branch->branch_name); ?> (Branch Code - <?php echo e($all_result->br_code); ?>)</p>
									<?php } ?>
								</div>
							</div>
							<?php if (!empty($all_result->area_name)) { ?>
							<div class="form-group">
								<label class="col-sm-4 control-label">Area Name </label>
								<div class="col-sm-7">
									<?php if (empty($assign_branch->area_name)) { ?>
									<p class="form-control-static">: <?php echo e($all_result->area_name); ?></p>
									<?php } else { ?>
									<p class="form-control-static">: <?php echo e($assign_branch->area_name); ?></p>
									<?php } ?>
								</div>
							</div>
							<?php } ?>
							<?php if (!empty($all_result->zone_name)) { ?>
							<div class="form-group">
								<label class="col-sm-4 control-label">Zone Name </label>
								<div class="col-sm-7">
									<?php if (empty($assign_branch->zone_name)) { ?>
									<p class="form-control-static">: <?php echo e($all_result->zone_name); ?></p>
									<?php } else { ?>
									<p class="form-control-static">: <?php echo e($assign_branch->zone_name); ?></p>
									<?php } ?>
								</div>
							</div>
							<?php } ?>														
							<div class="form-group">
								<label class="col-sm-4 control-label">Branch Joining Date </label>
								<div class="col-sm-7">
									<?php if (empty($assign_branch->branch_name)) { ?>
									<p class="form-control-static">: <?php echo date('d M Y',strtotime($all_result->br_join_date)); ?></p>
									<?php } else { ?>
									<p class="form-control-static">: <?php echo date('d M Y',strtotime($assign_branch->open_date)); ?></p>
									<?php } ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Duration of Present Branch </label>
								<div class="col-sm-7">
									<p class="form-control-static">: 
										<?php 
										date_default_timezone_set('UTC');
										if(!empty($all_result->re_effect_date)) { 
											$input_date = new DateTime($all_result->re_effect_date);
										} else {
											$input_date1 = date('Y-m-d', strtotime("+1 day", strtotime($form_date)));
											$input_date = new DateTime($input_date1);
										}
										if (empty($assign_branch->branch_name)) {
											$org_date = new DateTime($all_result->br_join_date);
										} else {
											$org_date = new DateTime($assign_branch->open_date);
										}
										
										$difference = date_diff($org_date, $input_date);
										// $days = $diff12->d;
										//accesing months
										echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
										//accesing years
										// $years = $diff12->y;
										 ?>
									</p>
								</div>
							</div>
							<?php if (!empty($all_result->area_name)) { ?>
							<div class="form-group">
								<label class="col-sm-4 control-label">Duration of Present Area </label>
								<div class="col-sm-7">
									<p class="form-control-static">: 
										<?php 
										date_default_timezone_set('UTC');
										if(!empty($all_result->re_effect_date)) { 
											$input_date = new DateTime($all_result->re_effect_date);
										} else {
											$input_date1 = date('Y-m-d', strtotime("+1 day", strtotime($form_date)));
											$input_date = new DateTime($input_date1);
										}
										$org_date = new DateTime($area_joindate);										
										$difference = date_diff($org_date, $input_date);
										echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
										 ?>
									</p>
								</div>
							</div>
							<?php } ?>
							<div class="form-group">
								<label class="col-sm-4 control-label">Permanent Address </label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php echo e($all_result->permanent_add); ?></p>
								</div>
							</div>
							<?php $login_emp_id = Session::get('emp_id'); if ($user_type == 1 || $user_type == 2 || $login_emp_id == 4588 || $login_emp_id == 4875 || $login_emp_id == 5178 ) { ?>
							<div class="form-group">
								<label class="col-sm-4 control-label">Personal Phone No. </label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php echo e($all_result->contact_num); ?></p>
								</div>
							</div>
							<?php } ?>
							<?php if (!empty($all_result->re_effect_date)) { ?>
							<div class="form-group">
								<label class="col-sm-4 control-label">Resignation Effect Date </label>
								<div class="col-sm-7">
									<p class="form-control-static">: <span style="color:#F70408"><?php echo date('d-m-Y',strtotime($all_result->re_effect_date)); ?> (<?php echo e($all_result->resignation_by); ?>)</span></p>
								</div>
							</div>
							<?php } ?>
							<div class="form-group">
								<label class="col-sm-4 control-label">Employee Status </label>
								<div class="col-sm-7">
									<?php 
								if(!empty($all_result->re_effect_date)) {
									if ($all_result->re_effect_date <= $form_date) {
										echo '<p class="form-control-static">: <span style="color:#F70408"><b>Cancel</b></span></p>';
									} else {
										echo '<p class="form-control-static">: <span style="color:#179708"><b>Running</b></span></p>';
									}
								} elseif (empty($all_result->re_effect_date)){
									echo '<p class="form-control-static">: <span style="color:#179708"><b>Running</b></span></p>';
								}
								
							?>
								</div>
							</div>
							
							
							
							<!--
							<div class="form-group">
								<label class="col-sm-4 control-label">Supervisor : </label>
								<div class="col-sm-7">
									<p class="form-control-static">: <span style="color:blue;"><?php //echo $reported_to; ?></span></p>
								</div>
							</div>
							-->
							
							
							
							
							
							
							
							<?php if (!empty($max_br_join_date->br_join_date)) { ?>
							<div class="form-group">
								<label class="col-sm-4 control-label"><blink>New Transfer</blink> </label>
								<div class="col-sm-7">
									<p class="form-control-static">: <span style="color:#900C3F;"><b>Branch Name: </b><?php echo $max_br_join_date->br_name; ?>,
									<b>Joining Date: </b> <?php echo date("d-m-Y", strtotime($max_br_join_date->br_join_date)); ?></span></p>
								</div>
							</div>
							<?php } ?>
							<?php if(empty($fp_status) && !empty($file_status)) { ?>
							<div class="form-group">
								<label class="col-sm-4 control-label"><span style="color:#2733d1">File Status / Location </span></label>
								<div class="col-sm-7">
									<p class="form-control-static">: <span style="color:#272f9d"><b>								
									Under Process -
									<?php 
									if($file_status->file_type == 1) { echo 'Legal Notice';}
									else if ($file_status->file_type == 2) { echo 'Final Payment';}
									else if ($file_status->file_type == 3) { echo 'Final Payment Info';}
									else if ($file_status->file_type == 4) { echo 'Departmental Notice';}
									else if ($file_status->file_type == 5) { echo 'Final Payment Close';}
									else if ($file_status->file_type == 6) { echo 'Final Payment Settlement';}
									else if ($file_status->file_type == 7) { echo 'Litigation / Mgt. Decision';}
									
									if($file_status->status !=0) { 
										echo '<br/>: '. $file_status->re_emp_name.' - '.$file_status->receiver_emp_id; 
									} else {
										echo '<br/>: '. $file_status->se_emp_name.' - '.$file_status->sender_emp_id;
									}									
									?>									
									<?php echo ' <br/> : Date : '. date("d-m-Y", strtotime($file_status->entry_date)); ?></b></span></p>
								</div>
							</div>
							<?php } ?>
							<?php if(!empty($fp_status)) { ?>
							<div class="form-group">
								<label class="col-sm-4 control-label"><span style="color:#900C3F">Final Payment </span></label>
								<div class="col-sm-7">
									<p class="form-control-static">: <span style="color:#F70408"><b>Settled</b> on <?php echo date("d-m-Y", strtotime($fp_status->effect_date)); ?></span></p>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php elseif(!empty($nonid_emp_status)): ?>
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Employee Status Information</font></b></p>		
			</div>
			<form class="form-horizontal">
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-body">
							<div class="form-group">
								<label for="vehicle_id" class="col-sm-4 control-label">Employee ID </label>
								<div class="col-sm-7">			
									<p class="form-control-static">: <?php echo e($nonid_emp_status->sacmo_id); ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Employee Name </label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php echo e($nonid_emp_status->emp_name); ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Designation </label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php echo e($nonid_emp_status->designation_name); ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Org. Join Date</label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php echo date('d M Y',strtotime($nonid_emp_status->joining_date)); ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Contract Renew Date</label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php echo empty($nonid_emp_status->next_renew_date) ? '' : date('d M Y',strtotime($nonid_emp_status->next_renew_date)); ?></p>
								</div>
							</div>
							<?php if($nonid_emp_status->end_type ==1 ) { ?>
							<div class="form-group">
								<label class="col-sm-4 control-label">Contract Ending Date</label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php echo date('d M Y',strtotime($nonid_emp_status->c_end_date)); ?></p>
								</div>
							</div>
							<?php } ?>
							<div class="form-group">
								<label class="col-sm-4 control-label"><?php echo ($emp_type ==2) ? 'Job Duration Left' : 'Job Duration'; ?></label>
								<div class="col-sm-7">
									<p class="form-control-static">: 
										<?php 
										date_default_timezone_set('Asia/Dhaka');
										/* if(!empty($nonid_emp_status->re_effect_date)) { 
											$input_date = new DateTime($nonid_emp_status->re_effect_date);
										} else {
											$input_date = new DateTime($form_date);
										} */
										if($emp_type == 2) {
											if(!empty($nonid_emp_status->cancel_date)) { 
												$input_date = new DateTime($nonid_emp_status->cancel_date);
												$org_date = new DateTime($nonid_emp_status->joining_date);
												$difference = date_diff($org_date, $input_date);
												if($nonid_emp_status->joining_date <= $form_date) {
													echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
												} else {
													echo '';
												}
											} else {
												$input_date = new DateTime($form_date);
												$org_date = new DateTime($nonid_emp_status->c_end_date);	
												$difference = date_diff($input_date, $org_date);
												if($nonid_emp_status->c_end_date < $form_date) {
													echo $difference->format('%y year, %m month, %R%d days');
												} else {
													echo $difference->format('%y year, %m month, %d days');
												}
											}											
										} else {
											if(!empty($nonid_emp_status->cancel_date)) { 
												$input_date = new DateTime($nonid_emp_status->cancel_date);
											} else {
												$input_date = new DateTime($form_date);
											}
											$org_date = new DateTime($nonid_emp_status->joining_date);	
											$difference = date_diff($org_date, $input_date);
											if($nonid_emp_status->joining_date <= $form_date) {
												echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
											} else {
												echo '';
											}
										}
										 ?>
									</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-12 control-label"><span style="color:red;">This Group is till Under Construction! if require please follow hard copy and contact to HRD!</span></label>
							</div>
						</div>
					  <!-- /.box-body -->           
					</div>
				</div>
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-body">
							<div class="form-group">
								<label class="col-sm-4 control-label">Area Name </label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php if(!empty($nonid_emp_status->after_trai_br_code)){ echo $nonid_emp_status->after_area_name; } else { echo $nonid_emp_status->area_name; } ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Present Workstation </label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php if(!empty($nonid_emp_status->after_trai_br_code)){ echo $nonid_emp_status->after_branch_name; } else { echo $nonid_emp_status->branch_name; } ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Workstation Joining Date </label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php if(!empty($nonid_emp_status->after_trai_br_code)){ echo date('d M Y',strtotime($nonid_emp_status->after_trai_join_date)); } else { if(!empty($nonid_emp_status->br_join_date)) { echo date('d M Y',strtotime($nonid_emp_status->br_join_date)); } } ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Duration of Present Workstation </label>
								<div class="col-sm-7">
									<p class="form-control-static">: 
										<?php 
										date_default_timezone_set('Asia/Dhaka');
										
										if(!empty($nonid_emp_status->cancel_date)) { 
											$input_date = new DateTime($nonid_emp_status->cancel_date);
										} else {
											$input_date = new DateTime($form_date);
										}
										if(!empty($nonid_emp_status->after_trai_br_code)){
											$org_date = new DateTime($nonid_emp_status->after_trai_join_date);
											$org_date1 = $nonid_emp_status->after_trai_join_date;
										}else{
											$org_date = new DateTime($nonid_emp_status->br_join_date);
											$org_date1 = $nonid_emp_status->br_join_date;
										}									
										if($org_date1 <= $form_date) {
											$difference = date_diff($org_date, $input_date);
											echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
										}										
										
										 ?>
									</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Permanent Address </label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php echo e($nonid_emp_status->permanent_add); ?></p>
								</div>
							</div>
							<?php if($user_type == 1 || $user_type == 2) { ?>
							<div class="form-group">
								<label class="col-sm-4 control-label"><?php if(($emp_type == 3) || ($emp_type == 4) || ($emp_type == 7)){ echo "Total"; } else echo "Consolidated";?> Salary </label>
								<div class="col-sm-7">
									<p class="form-control-static">: <?php echo e($nonid_emp_status->gross_salary); ?></p>
								</div>
							</div>
							<?php } ?>
							<?php if (!empty($nonid_emp_status->cancel_date)) { ?>
							<div class="form-group">
								<label class="col-sm-4 control-label">Resignation Effect Date </label>
								<div class="col-sm-7">
									<p class="form-control-static">: <span style="color:#F70408"><?php echo date('d-m-Y',strtotime($nonid_emp_status->cancel_date)); ?> (<?php echo e($nonid_emp_status->cancel_by); ?>)</span></p>
								</div>
							</div>
							<?php } ?>
							<div class="form-group">
								<label class="col-sm-4 control-label">Status </label>
								<div class="col-sm-7">
								<?php 
									if(!empty($nonid_emp_status->cancel_date)) {
										if ($nonid_emp_status->cancel_date <= $form_date) {
											echo '<p class="form-control-static">: <span style="color:#F70408"><b>Cancel</b></span></p>';
										} else {
											echo '<p class="form-control-static">: <span style="color:#179708"><b>Running</b></span></p>';
										}
									} elseif (empty($nonid_emp_status->cancel_date)){
										echo '<p class="form-control-static">: <span style="color:#179708"><b>Running</b></span></p>';
									}								
								?>
								</div>
							</div>
							<?php if(empty($fp_status) && !empty($file_status)) { ?>
							<div class="form-group">
								<label class="col-sm-4 control-label"><span style="color:#2733d1">File Status / Location </span></label>
								<div class="col-sm-7">
									<p class="form-control-static">: <span style="color:#272f9d"><b>								
									Under Process -
									<?php 
									if($file_status->file_type == 1) { echo 'Legal Notice';}
									else if ($file_status->file_type == 2) { echo 'Final Payment';}
									else if ($file_status->file_type == 3) { echo 'Final Payment Info';}
									else if ($file_status->file_type == 4) { echo 'Departmental Notice';}
									else if ($file_status->file_type == 5) { echo 'Final Payment Close';}
									else if ($file_status->file_type == 6) { echo 'Final Payment Settlement';}
									else if ($file_status->file_type == 7) { echo 'Litigation / Mgt. Decision';}
									
									if($file_status->status !=0) { 
										echo '<br/>: '. $file_status->re_emp_name.' - '.$file_status->receiver_emp_id; 
									} else {
										echo '<br/>: '. $file_status->se_emp_name.' - '.$file_status->sender_emp_id;
									}									
									?>									
									<?php echo ' <br/> : Date : '. date("d-m-Y", strtotime($file_status->entry_date)); ?></b></span></p>
								</div>
							</div>
							<?php } ?>
							<?php if(!empty($fp_status)) { ?>
							<div class="form-group">
								<label class="col-sm-4 control-label"><span style="color:#900C3F">Final Payment </span></label>
								<div class="col-sm-7">
									<p class="form-control-static">: <span style="color:#F70408"><b>Settled</b> on <?php echo date("d-m-Y", strtotime($fp_status->effect_date)); ?></span></p>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php endif; ?>
</section>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
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
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupBasic_Reports").addClass('active');
		$("#Employee_Status").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>