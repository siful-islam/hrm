<?php $__env->startSection('title', 'Loan Application'); ?>
<?php $__env->startSection('main_content'); ?>
	<section class="content-header">
		<h1>Loan Application<small>Location</small></h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-info">
			<div class="box-header">
				<table class="table table-bordered table-striped">
					<tr>
						<td align="center" colspan="7"><h4 style="color:blue">Application for Recomendation</h4></td>
					</tr>
					<tr>
						<th>#</th>
						<th>Supervisor Name</th>
						<th>ID</th>
						<th>Designation</th>
						<th>Action Date</th>
						<th>Action</th>
						<th>Application</th>
					</tr>
					<?php $r = 1; $stp = 0; foreach($recom_location as $v_recom_location) { ?>
						<?php
						if($approve_location->application_stage == 0)
						{
							if($v_recom_location->actions ==0 && $stp == 0)
							{
								$sup 	= 'File is here';
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

				<table class="table table-bordered table-striped">
					<tr>
						<td align="center" colspan="7"><h4 style="color:blue">Application for Approval</h4></td>
					</tr>
					<tr>
						<th>#</th>
						<th>Supervisor Name</th>
						<th>ID</th>
						<th>Designation</th>
						<th>Action Date</th>
						<th>Action</th>
						<th>Application</th>
					</tr>
					<?php
						if($approve_location->application_stage == 1)
						{
							$hr = 'File is here';
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

				<table class="table table-bordered table-striped">
					<tr>
						<td align="center" colspan="7"><h4 style="color:blue">Application for Disburse</h4></td>
					</tr>
					<tr>
						<th>#</th>
						<th>Supervisor Name</th>
						<th>ID</th>
						<th>Designation</th>
						<th>Action Date</th>
						<th>Action</th>
						<th>Application</th>
					</tr>
					<?php
					if($approve_location->application_stage == 2)
					{
						$finance = 'File is here';
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
    </section>

	<script>
		$(document).ready(function() {
			//$("#MainGroupSelf_Care").addClass('active');
			//$("#Leave_Approve").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>