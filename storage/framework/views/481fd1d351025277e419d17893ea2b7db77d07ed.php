
<?php $__env->startSection('title', 'Manage User Role'); ?>
<?php $__env->startSection('main_content'); ?>


    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configureation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Config</a></li>
			<li><a href="#">User Role</a></li>
			<li class="active">Manage User Role</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">User Role Manager</h3>
							<a href="<?php echo e(URL::to('/user-role/create')); ?>" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add New Role</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Role Name</th>
									<th>Role Description</th>                     
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($role->id); ?></td>
									<td><?php echo e($role->admin_role_name); ?></td>
									<td><?php echo e($role->role_description); ?></td>
									<td><?php echo e($role->role_status); ?></td> 
									<td>
										<a class="btn btn-sm btn-primary" title="Edit" href="<?php echo e(URL::to('/user-role/'.$role->id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
										<a class="btn btn-sm btn-danger" title="Permission" href="<?php echo e(URL::to('/set-permission/'.$role->id)); ?>"><i class="glyphicon glyphicon-flag"></i></a>
									</td>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>       
						</table>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
        </div>
	</section>
		
<script>
	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({

		});
	});
</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupConfig").addClass('active');
			$("#Manage_User_Role").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>