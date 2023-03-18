
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('main_content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Dashboard<small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Dashboard</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<!-- Small boxes (Stat box) -->
		<?php $admin_access_label 			= Session::get('admin_access_label'); 
		if(($admin_access_label != 23) && ($admin_access_label != 22) && ($admin_access_label != 25)&& ($admin_access_label != 27)){
		?>
		<div class="row">
			<div class="col-lg-3 col-xs-6">
			  <!-- small box -->
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3><?php echo e($total_employee = 0); ?></h3>
						<p>Total Running Employee</p>
					</div>
					<div class="icon">
						<i class="ion ion-person"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
			  <!-- small box -->
				<div class="small-box bg-red">
					<div class="inner">
						<h3><?php echo e($total_resigned_employee = 0); ?></h3>
						<p>Total Resigned Employee</p>
					</div>
					<div class="icon">
						<i class="ion ion-person-add"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
			  <!-- small box -->
				<div class="small-box bg-green">
					<div class="inner">
						<h3><?php echo e($todays_new_emp = 0); ?></h3>
						<p>Todays New Employee</p>
					</div>
					<div class="icon">
						<i class="ion ion-person-add"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
			  <!-- small box -->
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3><?php echo e($todays_resign_emp = 0); ?></h3>
						<p>Todays Resigned Employee</p>
					</div>
					<div class="icon">
						<i class="ion ion-person"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			  </div>
			</div>
			<!-- ./col -->
		</div>
		<?php if(count($all_result)>0): ?>
		<div class="row">
			<div class="col-md-6 col-md-offset-3" style="margin-bottom:5px;">
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Employee ID</th>
								<th>Sender Employee</th>
								<th>Receiver Employee</th>
								<th>Entry Date</th>                
								<th>Status</th>
							</tr>
						</thead>
						<tbody>								
							<?php echo e(!$i=1); ?> <?php $__currentLoopData = $all_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($i++); ?></td>
								<td><?php echo e($result->fp_emp_id); ?></td>
								<td><?php echo e($result->sender_emp_id); ?></td>
								<td><?php echo e($result->receiver_emp_id); ?></td>
								<td><?php echo e($result->entry_date); ?></td>
								<td class="text-center">
									<a class="btn btn-danger" href="<?php echo e(URL::to('/fp_file_info')); ?>" >Receive</a>
								</td>
							</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>    
					</table>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<?php } ?>
		<!-- /.row -->
		<!-- Main row -->
		<div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">


        </section>
        <!-- /.Left col -->
        
		</div>
		<!-- /.row (main row) -->

    </section>
    <!-- /.content -->
	<script>
		//To active dashboard menu.......//
		$(document).ready(function() {
			$("#dashboard").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>	
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>