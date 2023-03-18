<?php $__env->startSection('title', 'Marked Assign'); ?>
<?php $__env->startSection('main_content'); ?>
<section class="content-header">
	<h1>Marked<small>Assign</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">Marked Assign</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="<?php echo e(URL::to('/mark-assign/create')); ?>" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Open Date</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Branch</th>
								<th>Designation</th>
								<th>Marked for</th>                 
								<th>Status</th>                 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl No</th>
								<th>Open Date</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Branch</th>
								<th>Designation</th>
								<th>Marked for</th>                 
								<th>Status</th>                 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</tfoot>
						<tbody>								
							<?php echo e(!$i=1); ?> <?php $__currentLoopData = $mark_assign_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mark_assign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($i++); ?></td>
								<td><?php echo e($mark_assign->open_date); ?></td>
								<td><?php echo e($mark_assign->emp_id); ?></td>
								<td><?php echo e($mark_assign->emp_name_eng); ?></td>
								<td><?php echo e($mark_assign->branch_name); ?></td>
								<td><?php echo e($mark_assign->designation_name); ?></td>
								<td><?php echo e($mark_assign->marked_for); ?></td>
								<?php if ($mark_assign->status !=1) { ?>
								<td style="color:green;"><?php echo 'Active'; ?></td>
								<?php } else { ?>
								<td style="color:red;"><b><?php echo 'InActive'; ?></b></td>
								<?php } ?>
								<td class="text-center">
									<a class="btn bg-olive"  title="View" href="<?php echo e(URL::to('/mark-assign/'.$mark_assign->id)); ?>"><i class="fa fa-eye"></i></a>
									<a class="btn btn-primary" title="Edit" href="<?php echo e(URL::to('/mark-assign/'.$mark_assign->id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
								</td>
							</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>    
					</table>
					</div>
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
		$("#Marked_Assign").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>