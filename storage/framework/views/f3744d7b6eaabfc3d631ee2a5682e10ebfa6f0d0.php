
<?php $__env->startSection('title', 'Increment Letter'); ?>
<?php $__env->startSection('main_content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Employee<small>Increment</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Eployee</a></li>
			<li class="active">Manage Increment</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Auto Increment List</h3>
							<a href="<?php echo e(URL::to('/increment-letter/create')); ?>" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add </a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Sl No</th>
									<th>Letter date</th>
									<th>Next Increment Date</th>
									<th>Grade</th>                     
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>								
							<?php echo e(!$i=1); ?> <?php $__currentLoopData = $increment_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $increment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($i++); ?></td>
									<td><?php echo e($increment->letter_date); ?></td>
									<td><?php echo e($increment->increment_date); ?></td>
									<td><?php echo e($increment->grade_code); ?></td>								
									<td class="text-center">
										<!--<a class="btn bg-olive"  title="View" href="<?php echo e(URL::to('/increment-letter/'.$increment->id)); ?>"><i class="fa fa-eye"></i></a>-->
										<a class="btn btn-primary" title="Edit" href="<?php echo e(URL::to('/increment-letter/'.$increment->id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
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
		$("#MainGroupEmployee").addClass('active');
		$("#Increment_Letter").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>