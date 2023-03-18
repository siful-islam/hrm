<?php $__env->startSection('title', 'Manage Branch'); ?>
<?php $__env->startSection('main_content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Navs<small>All Branches</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Settings</a></li>
			<li class="active">Nav Manager</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">All Branches</h3>
						<a href="<?php echo e(URL::to('/add-branch')); ?>" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Branch Name</th>
									<th>Branch Bangla</th>
									<th>Branch Code</th>
									<th>Area</th>
									<th>Zone</th>
									<th>Contact No</th>
									<th>Email Addresss</th>
									<th>Status</th>              
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>No</th>
									<th>Branch Name</th>
									<th>Branch Bangla</th>
									<th>Branch Code</th>
									<th>Area</th>
									<th>Zone</th>
									<th>Contact No</th>
									<th>Email Addresss</th>
									<th>Status</th>              
									<th style="width:15%">Action</th>
								</tr>
							</tfoot>
							<tbody>
								<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($branch->br_id); ?></td>
									<td><?php echo e($branch->branch_name); ?></td>
									<td><?php echo e($branch->br_name_bangla); ?></td>
									<td><?php echo e($branch->br_code); ?></td>
									<td><?php echo e($branch->area_name); ?></td>
									<td><?php echo e($branch->zone_name); ?></td>
									<td><?php echo e($branch->branch_contact_no); ?></td>
									<td><?php echo e($branch->branch_email); ?></td> 
									<td><?php echo e($branch->status); ?></td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="<?php echo e(URL::to('/edit-branch/'.$branch->br_id)); ?>"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
			$("#MainGroupSettings").addClass('active');
			$("#Branch").addClass('active');
		});
	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>