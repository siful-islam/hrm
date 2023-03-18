<?php $__env->startSection('title', 'Manage Travel Allowance'); ?>
<?php $__env->startSection('main_content'); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configureation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Config</a></li>
			<li><a href="#">Travel Allowance</a></li>
			<li class="active">Manage Travel Allowance</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Travel Allowance Manager</h3>
						
							<a href="<?php echo e(URL::to('/travel_allowance/create')); ?>" id="myAnchor" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Sl No</th>
									<th>Source</th>
									<th>Designation</th>                   
									<th>Amount</th>                   
									<th>From</th>                   
									<th>To</th>                   
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Sl No</th>
									<th>Source</th>
									<th>Designation</th>                   
									<th>Amount</th>                   
									<th>From</th>                   
									<th>To</th>                   
									<th>Status</th>                      
									 <th style="width:15%">Action</th>
								</tr>
							</tfoot>
							<tbody>
								<?php $__currentLoopData = $travel_allowance_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tr_all): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($tr_all->id); ?></td>
									<td><?php echo e($tr_all->source_branch_name); ?></td>
									<td><?php echo e($tr_all->destination_branch_name); ?></td>
									<td><?php echo e($tr_all->travel_amt); ?></td>
									<td><?php echo e($tr_all->from_date); ?></td>
									<td><?php echo e($tr_all->to_date); ?></td>
									<td><?php if($tr_all->status == 1): ?> <?php echo e("Running"); ?> <?php else: ?> <?php echo e("Cancel"); ?> <?php endif; ?></td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="<?php echo e(URL::to('/travel_allowance/'.$tr_all->id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
	document.getElementById("myAnchor").focus(); 
</script>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$('#Travel_allowance').addClass('active');
			});
	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>