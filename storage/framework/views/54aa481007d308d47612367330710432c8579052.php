<?php $__env->startSection('title', 'Manage Menu Group'); ?>
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
				<h3 class="box-title"> <?php echo e($data['Heading']); ?></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
				
				
				<form class="form-horizontal" action="<?php echo e(URL::to($data['action'])); ?>" method="post" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

				
				<input type="hidden" id="nav_group_id" name="nav_group_id" value="<?php echo e($data['nav_group_id']); ?>" >
				
				<div class="box-body">
					<div class="form-group">
						<label for="nav_group_name" class="col-sm-2 control-label">Nav Group Name</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="first_name" name="nav_group_name" value="<?php echo e($data['nav_group_name']); ?>" placeholder="Group Name" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="grpup_icon" class="col-sm-2 control-label">Grpup Icon</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="grpup_icon" name="grpup_icon" value="<?php echo e($data['grpup_icon']); ?>" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="admin_name" class="col-sm-2 control-label">Sub Menu</label>
						<div class="col-sm-4">
							<select name="is_sub_menu" id="is_sub_menu" class="form-control" required>
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label for="admin_name" class="col-sm-2 control-label">Serial Order</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="sl_order" name="sl_order" value="<?php echo e($data['sl_order']); ?>" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="admin_name" class="col-sm-2 control-label">User Access</label>
						<div class="col-sm-4">
							<?php foreach($data['user_role'] as $user_role) { ?>
								<input type="checkbox" value="<?php echo $user_role->id; ?>" name="user_access[]" <?php if(in_array($user_role->id, $data['user_access'])) {echo 'checked';} ?>><?php echo $user_role->admin_role_name;?>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label for="admin_name" class="col-sm-2 control-label">Staus</label>
						<div class="col-sm-4">
							<select name="nav_group_status" id="nav_group_status" class="form-control" required>
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</div>
					</div>
					
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<button type="reset" class="btn btn-default">Cancel</button>
					<button type="submit" class="btn btn-info"><?php echo e($data['button_text']); ?></button>
				</div>
				<!-- /.box-footer -->
			</form>

		</div>
	</section>
	
	<script>
		document.getElementById("is_sub_menu").value=<?php echo e($data['is_sub_menu']); ?>;
		document.getElementById("nav_group_status").value=<?php echo e($data['nav_group_status']); ?>;
	</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupConfig").addClass('active');
			$("#Manage_Menu_Group").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>