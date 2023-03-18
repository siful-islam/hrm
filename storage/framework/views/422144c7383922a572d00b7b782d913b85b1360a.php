
<?php $__env->startSection('title', 'Manage Board-University'); ?>
<?php $__env->startSection('main_content'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h4>Board-University</h4>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Board-University</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="<?php echo e(URL::to('/board-university/create')); ?>" class="btn bg-navy pull-right btn-xs" type="button"><i class="glyphicon glyphicon-plus" ></i> Add Board-University</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>SL No</th>                      
								<th>Board-University</th>                    
								<th>Status</th>                    
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tbody>								
							<?php echo e(!$i=1); ?> <?php $__currentLoopData = $all_board_university; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $board_university): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($i++); ?></td>
								<td><?php echo e($board_university->board_uni_name); ?></td>
								<td><?php echo e($board_university->status==1?'Active':'InActive'); ?></td>
								<td class="text-center">
									<!--<a class="btn bg-olive"  title="View" href="<?php echo e(URL::to('/board-university')); ?>"><i class="fa fa-eye"></i></a>-->
									<a class="btn btn-primary" title="Edit" href="<?php echo e(URL::to('/board-university/'.$board_university->id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
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
	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
		});
	});
</script>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$('[id^=Board_]').addClass('active');
			});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>