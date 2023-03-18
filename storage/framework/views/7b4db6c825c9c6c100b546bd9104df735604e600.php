
<?php $__env->startSection('main_content'); ?>

<style>

.image-upload > input
{
    display: none;
}

.image-upload img
{
    margin-left:20%;
	margin-top:10px;
	width: 90;
	height:110;
    cursor: pointer;	
	background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 4px;
}
</style>

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
				<h3 class="box-title">  </h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
				<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" method="post" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

				  
				<div class="box-body">
					<div class="form-group">
						<label for="first_name" class="col-sm-1	 control-label">Sn</label>
						<label for="first_name" class="col-sm-2	 control-label">branch code</label>
						<label for="first_name" class="col-sm-2 control-label">branch Name</label>
						<label for="first_name" class="col-sm-2 control-label">First Name</label>
						 
						<label for="email_address" class="col-sm-2 control-label">User Email</label>
						 
						<label for="cell_no" class="col-sm-2 control-label">Cell No</label>
						 
					</div>	
					<?php $j=1; foreach($branch_staff as $v_user_br){
						    ?>
					<div class="form-group">
						 
						<div class="col-sm-1">
							<input type="text" class="form-control"  value="<?php echo $j; ?>">
						</div> 
						<div class="col-sm-2">
							<input type="text" class="form-control" id="branch_code" name="user[<?php echo $j; ?>][branch_code]" value="<?php echo $v_user_br['br_code']; ?>" >
						</div> 
						<div class="col-sm-2">
							<input type="text" class="form-control"  value="<?php echo $v_user_br['branch_name']; ?>" >
						</div> 
						<div class="col-sm-2">
							<input type="text" class="form-control" id="first_name" name="user[<?php echo $j; ?>][first_name]"  value="<?php echo $v_user_br['first_name']; ?>">
						</div> 
						<div class="col-sm-2">
							<input type="email" class="form-control" id="email_address"  name="user[<?php echo $j; ?>][email_address]" value="<?php echo $v_user_br['email_address']; ?>"  required>
						</div>  
						<div class="col-sm-2">
							<input type="text" class="form-control" id="cell_no"  name="user[<?php echo $j; ?>][cell_no]" value="<?php echo $v_user_br['cell_no']; ?>">
						</div>
					</div>	 
					<?php  $j++;} ?>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<button type="reset" class="btn btn-default">Cancel</button>
					<button type="submit" class="btn btn-info">save</button>
				</div>
				<!-- /.box-footer -->
			</form>
		</div>
	</section>
	
	<script>
	
	</script>
	

	<script>
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('#blah')
						.attr('src', e.target.result)
						.width(90)
						.height(110);
				};

				reader.readAsDataURL(input.files[0]);
			}
		}
	</script>
	
	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>