
<?php $__env->startSection('title', 'Add EDMS Group'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.readonly{
 background-color:#eee;
}
.required{
	padding-right:3px;
	margin-top:0px;
	 
}
.required:not(.required)

</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Category</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Category</a></li>
			<li class="active">Add</li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content">
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>"  role="form" method="POST">
                <?php echo e(csrf_field()); ?> 
				<?php echo $method_control; ?> 
				<div class="box-body"> 
						<div class="row"> 
							<div class="col-md-5 col-md-offset-1">
								<div class="form-group"> 
									<label class="control-label col-md-5">Group</label>
										<div class="col-md-5">
											<input type="text"  id="category_name" name="category_name" class="form-control" value="<?php echo e($category_name); ?>" required>
											<span class="help-block"></span>
										</div> 
									<label class="control-label col-md-5">Status</label>
										<div class="col-md-5">
											<select name="status" id="status" class="form-control">
												<option value="1">Active</option>
												<option value="2">Inactive</option>
											</select>
											<br> 
										</div> 
										
									<label class="control-label col-md-5"></label>
										<div class="col-md-5">
											<button type="submit" class="btn btn-primary"><?php echo e($button); ?></button>
										</div> 
								</div>  
							</div> 
						</div>   
				</div>
			</form>
		</div>
	</section>
<script> 
document.getElementById("status").value = "<?php echo e($status); ?>";
</script>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$('#Edms_Group').addClass('active');
			});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>