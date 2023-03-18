
<?php $__env->startSection('title','Shoe size'); ?>
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
				<form class="form-horizontal"  action="<?php echo e(URL::to('/update_shoesize')); ?>" role="form" method="POST" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?> 
						<table class="table no-border table-striped">
							<thead>
								<tr>
									<th>SL No</th>
									<th>Employee ID</th>
									<th>Type Name</th>
									<th>Emp Name</th>
									<th>Designation</th> 
									<th>Gender</th> 
									<th>Shoe Size</th>  
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
									<td><?php echo $emp->type_name;?> 
									<input type="hidden" name="emp_type[<?php echo $i;?>]" class="form-control" value="<?php echo $emp->emp_type;?>">
									</td>
									<td><?php if($emp->emp_type == 1) { 
											echo $emp->emp_name; 
										} else {
											echo $emp->emp_name2; 
										} ?>  </td>
									<td><?php echo $emp->designation_name;?>
									<input type="hidden" name="designation_code[<?php echo $i;?>]" class="form-control" value="<?php echo $emp->designation_code;?>">
									</td> 
									<td> 
										 
										<?php if($emp->emp_type == 1) { 
											 
											if(($emp->gender == 'Male' )|| ($emp->gender == 'male')){
												echo "Male";
											}else if(($emp->gender == 'Female')||($emp->gender == 'female')){
												echo "Female";
											}
										} else {
											 
											if(($emp->gender2 == 'Male' )|| ($emp->gender2 == 'male')){
												echo "Male";
											}else if(($emp->gender2 == 'Female')||($emp->gender2 == 'female')){
												echo "Female";
											}
										} ?>
										
										
									</td>  
									<td>  
									<select type="text"  name="size[<?php echo $i;?>]" class="form-control"> 	
										<option   value="">--Select--</option> 
									<?php    if(($emp->gender == "Male")||($emp->gender == "male")||($emp->gender2 == "male")||($emp->gender2 == "Male")){  ?>
									 
									 
									<option   value="5" <?php if($emp->size == "5") echo "selected";?> >5 </option> 
									<option   value="6" <?php if($emp->size == "6") echo "selected";?> >6 </option> 
									<option   value="7" <?php if($emp->size == "7") echo "selected";?> >7 </option> 
									<option   value="8"  <?php if($emp->size == "8") echo "selected";?> >8 </option> 
									<option   value="9"  <?php if($emp->size == "9") echo "selected";?> >9 </option> 
									<option   value="10"  <?php if($emp->size == "10") echo "selected";?> >10 </option> 
									
									<?php
									
									}else{   ?>
									
									<option   value="3"  <?php if($emp->size == "3") echo "selected";?> >3 </option> 
									<option   value="4"  <?php if($emp->size == "4") echo "selected";?> >4 </option> 
									<option   value="5"  <?php if($emp->size == "5") echo "selected";?> >5 </option> 
									<option   value="6"  <?php if($emp->size == "6") echo "selected";?> >6 </option>  
									<?php }  ?>  
										</select> 
									
									</td>  
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