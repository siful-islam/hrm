
<?php $__env->startSection('title', 'Add Daily Allowance'); ?>
<?php $__env->startSection('main_content'); ?>


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Form Elements<small>Preview</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Forms</a></li>
			<li class="active">Advanced Elements</li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content">
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> <?php echo e($Heading); ?></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->				
				
				<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" method="<?php echo e($method); ?>" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

				<?php echo $method_control; ?>

				
				<input type="hidden" id="id" name="id" value="<?php echo e($id); ?>" >
				
				<div class="box-body">
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Grade</label>
						<div class="col-sm-4">
							<select  name="grade_code" id="grade_code" required class="form-control"> 
								<option value="">--Select--</option>
								<?php $__currentLoopData = $grade_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($grade->grade_code); ?>"><?php echo e($grade->grade_name); ?></option> 
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select> 
						</div>
					</div> 
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">Breakfast</label>
						<div class="col-sm-4">
							<input type="text" name="breakfast" id="breakfast" class="form-control" value="<?php echo e($breakfast); ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">Lunch</label>
						<div class="col-sm-4">
							<input type="text" name="lunch" id="lunch"  class="form-control" value="<?php echo e($lunch); ?>" required >
						</div>
					</div>
					 <div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">dinner</label>
						<div class="col-sm-4">
							<input type="text" name="dinner" id="dinner"  class="form-control" value="<?php echo e($dinner); ?>" required >
						</div>
					</div>
					 <div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">From</label>
						<div class="col-sm-4">
							<input type="text" name="from_date"  id="from_date"  class="form-control common_date" value="<?php echo e($from_date); ?>" required >
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">To</label>
						<div class="col-sm-4">
							<input type="text" name="to_date"  id="to_date"  class="form-control common_date" value="<?php echo e($to_date); ?>" required >
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-4">
							<select name="status" id="status" class="form-control" required>							
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
						</div>
					</div>
					
				</div>
				<!-- /.box-body -->
				<div class="box-footer"> 
					<button type="submit" class="btn btn-info"><?php echo e($button_text); ?></button>
				</div>
				<!-- /.box-footer -->
			</form>

		</div>
	</section>
	
	<script>
		document.getElementById("status").value = '<?php echo e($status); ?>'; 
		document.getElementById("grade_code").value = '<?php echo e($grade_code); ?>';  
	$(document).ready(function() {
			$('.common_date').datepicker({dateFormat: 'yy-mm-dd'}); 
		}); 
			
	</script>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$('#Daily_Allowance').addClass('active');
			});
	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>