
<?php $__env->startSection('title', 'Manage Organization'); ?>
<?php $__env->startSection('main_content'); ?>


    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configureation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Config</a></li>
			<li><a href="#">Organization</a></li>
			<li class="active">Manage Organization</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Organization Manager</h3>
							<a href="<?php echo e(URL::to('/org-manager/create')); ?>" id="add_new" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add Organization</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Short Name</th>
									<th>Org Code</th>
									<th>Contact</th>                     
									<th>Email</th>                     
									<th>Web</th>                     
									<th>Logo</th>                     
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $__currentLoopData = $organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($organization->org_id); ?></td>
									<td><?php echo e($organization->org_short_name); ?></td>
									<td><?php echo e($organization->org_code); ?></td>
									<td><?php echo e($organization->org_contact); ?></td>
									<td><?php echo e($organization->org_email); ?></td>
									<td><?php echo e($organization->org_web_address); ?></td>
									<td><img src="public/org_logo/<?php echo e($organization->org_logo); ?>" alt="Logo" width="35"></td> 
									<td><?php echo e($organization->org_status); ?></td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="<?php echo e(URL::to('org-manager/'.$organization->org_id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
			$("#Org_Manager").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>