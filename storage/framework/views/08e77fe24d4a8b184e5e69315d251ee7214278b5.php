
<?php $__env->startSection('title', 'Demotion'); ?>
<?php $__env->startSection('main_content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Employee<small>Demotion</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Eplooyee</a></li>
			<li class="active">Manage Demotion</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Demotion List</h3>
							<a href="<?php echo e(URL::to('/demotion/create')); ?>" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add Demotion </a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th style="width:5%">No</th>
									<th>Emp ID</th>
									<th>Employee Name</th>
									<th>Sarok No</th>
									<th>Letter Date</th>
									<th>Effect Date</th>                                         
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th style="width:5%">No</th>
									<th>Emp ID</th>
									<th>Employee Name</th>
									<th>Sarok No</th>
									<th>Letter Date</th>
									<th>Effect Date</th>                                           
									<th style="width:15%">Action</th>
								</tr>
							</tfoot>
							<tbody>
								<?php $i = 1; ?>
								<?php $__currentLoopData = $demotion_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_demotion_info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($i++); ?></td>
									<td><?php echo e($v_demotion_info->emp_id); ?></td>
									<td><?php echo e($v_demotion_info->emp_name); ?></td>
									<td><?php echo e($v_demotion_info->sarok_no); ?></td>
									<td><?php echo e($v_demotion_info->letter_date); ?></td>
									<td><?php echo e($v_demotion_info->effect_date); ?></td>
									<td><a class="btn btn-sm btn-primary" title="Edit" href="<?php echo e(URL::to('/demotion/'.$v_demotion_info->id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a></td>							
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
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupEmployee").addClass('active');
		$("#Demotion").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>