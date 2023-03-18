
<?php $__env->startSection('title', 'Appointment Letter'); ?>
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
						<h3 class="box-title">Appoinment letter</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Employee ID</th>                     
									<th>Employee Name</th>                     
									<th>Letter Date</th>                     
									<th>Effect Date</th>                                          
									<th style="width:15%">Actions</th>
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

</div>

<!-- DataTables -->
<script src="<?php echo e(asset('public/admin_asset/bower_components/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/admin_asset/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>

<script>

	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"ajax":{
					 "url": "<?php echo e(URL::to('/all-appointletter')); ?>",
					 "dataType": "json",
					 "type": "POST",
					 "data":{ _token: "<?php echo e(csrf_token()); ?>"}
				   },
			"columns": [
				{ "data": "id" },
				{ "data": "emp_id" },
				{ "data": "emp_name"},
				{ "data": "letter_date"},
				{ "data": "joining_date"},
				{ "data": "options"}
			]    

		});
	});

	function reload_table()
	{
		table.ajax.reload(null,false); //reload datatable ajax 
	}
	function view_letter(id)
	{
		$('#myModal').modal('show');
		$.ajax({
			url : "<?php echo e(url('view-appoint-letter')); ?>"+"/"+ id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{           
				$('[id="letter_body"]').html(data.letter_body);             
				$('#myModal').modal('show'); // show bootstrap modal when complete loaded
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error:-------------?');
			}
		});
	}
</script>

<script language="javascript" type="text/javascript">
	function printDiv(divID) {
		//Get the HTML of div
		var divElements = document.getElementById(divID).innerHTML;
		//Get the HTML of whole page
		var oldPage = document.body.innerHTML;
		//Reset the page's HTML with div's HTML only
		document.body.innerHTML = 
		  "<html><head><title></title></head><body>" + 
		  divElements + "</body>";
		//Print Page
		window.print();
		//Restore orignal HTML
		document.body.innerHTML = oldPage;
	}
</script>

	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Appoinment Letter</h4>
				</div>
				<div class="modal-body" id="letter_body">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-danger" onclick="javascript:printDiv('letter_body')" >Print</button>
				</div>
			</div>
		</div>
	</div>
</div>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee").addClass('active');
			$("#Appointment_Letter").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>