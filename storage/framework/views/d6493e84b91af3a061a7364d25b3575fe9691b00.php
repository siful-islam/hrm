
<?php $__env->startSection('title','Diary or Calendar'); ?>
<?php $__env->startSection('main_content'); ?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Approved<small>leave</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Leave</a></li>
			<li class="active">Approved</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
			</div>
			<?php if(!empty($emp_list)){?>
				<br>
				<br>
				<form class="form-horizontal"  action="<?php echo e(URL::to('/update_dairy_calender')); ?>" role="form" method="POST" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?> 
						<table class="table no-border table-striped">
							<thead>
								<tr>
									<th>SL No</th>
									<th>Employee ID</th>
									<th>emp Name</th>
									<th>Designation</th> 
									<th>Diary</th> 
									<th>Calendar</th>  
								</tr>
							</thead>
							<tbody>
								
								<?php
									 
									$i=1;
									$all_emp_id = '';
								 foreach($emp_list as $emp){  
									?> 
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $emp->emp_id;?>
									<input type="hidden" name="emp_id[<?php echo $i;?>]" class="form-control" value="<?php echo $emp->emp_id;?>">
									</td>
									<td><?php  
											echo $emp->emp_name; 
										?>  </td>
									<td><?php echo $emp->designation_name;?>
									<input type="hidden" name="designation_code[<?php echo $i;?>]" class="form-control" value="<?php echo $emp->designation_code;?>">
									</td>  
									<td><input type="text" placeholder="Dairy" name="num_dairy[<?php echo $i;?>]" class="form-control" value="<?php echo $emp->num_dairy;?>"></td> 
									<td><input type="text" placeholder="Calender"  name="num_calender[<?php echo $i;?>]" class="form-control" value="<?php echo $emp->num_calender;?>" ></td> 
									 
								</tr>
								<?php 	$i++; } 
								?>
							</tbody>    
						</table> 
				
						 
							<div class="row"> 
								<div class="col-md-11">
									<input type="hidden" name="tot_row" class="form-control" value="<?php echo $i;?>">
										<div class="pull-right"> 
											<input type="submit" id="submit_btn" class="btn btn-primary" value="update"> 		 
										</div>
								</div>
							</div>  
						
					</form>
			<?php } ?>
		</div>
</section> 
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupRequisition").addClass('active');
			$("#Diary_or_Calendar").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>