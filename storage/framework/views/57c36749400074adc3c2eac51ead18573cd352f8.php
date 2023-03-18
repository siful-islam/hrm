
<?php $__env->startSection('title', 'Staff Salary'); ?>
<?php $__env->startSection('main_content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Manage Employee's Salary</small></h1>
    </section>
	
	<!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<a href="<?php echo e(URL::to('/con_salary/create')); ?>" class="btn btn-success pull-left"><i class="fa fa-plus"></i> Add Salary (Contractual) </a>
						<a href="<?php echo e(URL::to('/staff-salary/create')); ?>" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add Salary </a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Employee ID</th>
									<th>Employee Name</th>
									<th>Effect Date</th>
									<th>Transection</th>                   
									<th>Basic Salary</th>                                                                       
									<th>Net Payable</th>                                                                       
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							</tbody>        
						</table>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
        </div>
	</section>
		
<!-- DataTables -->
<script src="<?php echo e(asset('public/admin_asset/bower_components/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/admin_asset/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>	
<script type="text/javascript" src="<?php echo e(asset('public/admin_asset/bower_components/gritter/js/jquery.gritter.js')); ?>"></script>

<script>
	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"ajax":{
					 "url": "<?php echo e(URL::to('/all-salary')); ?>",
					 "dataType": "json",
					 "type": "POST",
					 "data":{ _token: "<?php echo e(csrf_token()); ?>"}
				   },
			"columns": [
				{ "data": "sl"},
				{ "data": "emp_id"},
				{ "data": "emp_name"},
				{ "data": "letter_date"},
				{ "data": "transection_id"},
				{ "data": "salary_basic"},
				{ "data": "net_payable"},
				{ "data": "options"}
			]    

		});
	});

</script>
	<script>
		$(document).ready(function() {
			$("#MainGroupSalary_Info").addClass('active');
			$("#Staff_Salary").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>