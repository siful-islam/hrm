
<?php $__env->startSection('title', 'Punishment'); ?>
<?php $__env->startSection('main_content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Employee<small>Punishment</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Eplooyee</a></li>
			<li class="active">Manage Punishment</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Punishment List</h3>
						<a href="<?php echo e(URL::to('/punishment/create')); ?>" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add Punishment </a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Emp ID</th>
									<th>Employee Name</th>
									<th>Designation</th>
									<th>Branch</th>
									<th>Letter Date</th>
									<th>Punishment Type</th>                                          
									<th>Sarok No</th>                                          
									<th style="width:15%">Action</th>
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
<!-- CK Editor -->
<script src="<?php echo e(asset('public/admin_asset/bower_components/ckeditor/ckeditor.js')); ?>"></script>
<script>
	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
			"processing": true,
			"serverSide": true,
			"pageLength": 25,
			"responsive": true,
			"ajax":{
					 "url": "<?php echo e(URL::to('/all-punishment')); ?>",
					 "dataType": "json",
					 "type": "POST",
					 "data":{ _token: "<?php echo e(csrf_token()); ?>"}
				   },
			"columns": [
				{ "data": "id"},
				{ "data": "emp_id"},
				{ "data": "emp_name"},
				{ "data": "designation_name"},
				{ "data": "branch_name"},
				{ "data": "letter_date"},
				{ "data": "punishment_type"},
				{ "data": "sarok_no"},
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
			$("#Punishment").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>