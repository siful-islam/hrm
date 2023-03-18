
<?php $__env->startSection('title', 'Appointment'); ?>
<?php $__env->startSection('main_content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Employee Appointment<small>All Joining Employee</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Eplooyee</a></li>
			<li class="active">Manage Appointment</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Appointment Manager</h3>
							<!--<a href="<?php echo e(URL::to('/employee-appointment/create')); ?>" id="add_new" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add New</a>-->
					</div>
					<!-- /.box-header -->
					<div class="box-body">					
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Emp ID</th>
									<th>Letter Date</th>
									<th>Employee Name</th>
									<th>Father</th>
									<th>Village</th>
									<th>Post</th>
									<th>District</th>                      
									<th>Status</th>                      
									<th style="width:15%">Options</th>
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
					 "url": "<?php echo e(URL::to('/all-appoinments')); ?>",
					 "dataType": "json",
					 "type": "POST",
					 "data":{ _token: "<?php echo e(csrf_token()); ?>"}
				   },
			"columns": [
				{ "data": "id" },
				{ "data": "emp_id" },
				{ "data": "letter_date" },
				{ "data": "emp_name" },
				{ "data": "fathers_name" },
				{ "data": "emp_village" },
				{ "data": "emp_po" },
				{ "data": "emp_district" },
				{ "data": "status" },
				{ "data": "options" }
			]    
		});
	});

	function reload_table()
	{
		table.ajax.reload(null,false); //reload datatable ajax 
	}
</script>
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee").addClass('active');
			$("#Appointment").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>