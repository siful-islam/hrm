
<?php $__env->startSection('title', 'Post Name'); ?>
<?php $__env->startSection('main_content'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h4>Post</h4>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Post</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="<?php echo e(URL::to('/post-add')); ?>" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add Post</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>SL No</th>                      
								<th>Post Name</th>                    
								<th>Circular Name</th>                    
								<th>Circular Date</th>                    
								<th>Status</th>                    
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tbody>								
							<?php echo e(!$i=1); ?> <?php $__currentLoopData = $post_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($i++); ?></td>
								<td><?php echo e($post->post_name); ?></td>
								<td><?php echo e($post->start_date); ?></td>
								<td><?php echo e($post->start_date); ?></td>
								<td><?php echo e($post->status==1?'Active':'InActive'); ?></td>
								<td class="text-center">
									<!--<a class="btn bg-olive"  title="View" href="<?php echo e(URL::to('/view-post')); ?>"><i class="fa fa-eye"></i></a>-->
									<a class="btn btn-primary" title="Edit" href="<?php echo e(URL::to('/edit-post/'.$post->id)); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
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
	$(document).ready(function() {
		$("#MainGroupRecruitment").addClass('active');
		$("#Post_Name").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>