@extends('admin.admin_master')
@section('title', 'Manage Supervisor')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Supervisor Mapping<small>All Supervisor for Head-Office</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Settings</a></li>
			<li class="active">Manage Supervisor</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Supervisor Mapping</h3>
						<button onclick="add();" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add New</button>
					</div>
					<!-- /.box-header -->
					<div class="box-body">					
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Emp ID</th>
									<th>Employee Name</th>
									<th>Supervisor</th>
									<th>Role</th>
									<th>Active from</th>                    
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
<script src="{{asset('public/admin_asset/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/admin_asset/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>	
<script type="text/javascript" src="{{asset('public/admin_asset/bower_components/gritter/js/jquery.gritter.js')}}"></script>

<script>
	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
				"processing": true,
				"serverSide": true,
				"responsive": true,
				"ajax":{
					"url": "{{URL::to('/all-supervisor')}}",
					"dataType": "json",
					"type": "POST",
					"data":{ _token: "{{csrf_token()}}"}
				},
				"columns": [
					{ "data": "sl" },
					{ "data": "emp_id" },
					{ "data": "emp_name" },
					{ "data": "supervisor_id" },
					{ "data": "supervisor_type" },
					{ "data": "active_from" },
					{ "data": "options" }
				]    
		});
	});

	function reload_table()
	{
		table.ajax.reload(null,false); //reload datatable ajax 
	}
	
	function add()
	{
		save_method = 'add';
		document.getElementById("post_method").innerHTML = "";
		$('#new_form')[0].reset(); // reset form on modals
		$('.form-group').removeClass('has-error'); // clear error class
		$('.help-block').empty(); // clear error string
		$('#modal_form').modal('show'); // show bootstrap modal
		$('.modal-title').text('Add: Supervisor Mapping'); // Set Title to Bootstrap modal title
	}
	
	function edit(id)
	{
		var segment = '<?php echo Request::segment(1) ?>';
		var url = "{{ url('') }}"+"/"+segment+"/"+ id+"/edit";
		document.getElementById("post_method").innerHTML = "<input type='hidden' name='_method' value='PUT' />";		
		save_method = 'update';
		$('#new_form')[0].reset(); // reset form on modals
		$('.form-group').removeClass('has-error'); // clear error class
		$('.help-block').empty(); // clear error string
		$.ajax({
			url : url,			
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				$('[name="mapping_id"]').val(data.mapping_id);             
				$('[name="emp_name"]').val(data.emp_name);                   
				$('[name="emp_id"]').val(data.emp_id);    
				$('[name="supervisor_id"]').val(data.supervisor_id);                   
				$('[name="supervisor_type"]').val(data.supervisor_type);                   
				$('[name="active_from"]').val(data.active_from);                     
				$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
				$('.modal-title').text('Edit: Supervisor Mapping'); // Set title to Bootstrap modal title
			}
		});
	}
	
	function save()
	{
		
		var segment = '<?php echo Request::segment(1) ?>';
		$('#btnSave').text('Saving...'); //change button text
		$('#btnSave').attr('disabled',true); //set button disable 
		var mapping_id = $('#mapping_id').val();
		if(mapping_id === '') {
			url = "{{URL::to('/')}}"+"/"+segment;
			message='Data Saved Successfully';
		} else {
			url = "{{ URL::to('/')}}"+"/"+segment+"/"+ mapping_id;
			message='Data Updated Successfully';
		}
		
		$.ajax({
			url : url,
			type: "POST",
			data: $('#new_form').serialize(),			
			dataType: "JSON",
			success: function(data)
			{
				$('#mapping_id').val(''); //clear ID value
				$('#btnSave').text('Save'); //change button text
				$('#btnSave').attr('disabled',false); //set button enable 
				reload_table(); // List table reloaded
				$('#modal_form').modal('hide'); // Modal form hide				
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				// Show Error Message
				alert(textStatus);
				$('#btnSave').text('Save'); //change button text
				$('#btnSave').attr('disabled',false); //set button enable 
			}
		});
	}
		
		
</script>
<script>
//To active  menu.......//
	//$(document).ready(function() {
		//$("#MainGroupEmployee").addClass('active');
		//$("#Appointment").addClass('active');
	//});
</script>
	
	
	
	
	
	
	<!-- Start Bootstrap modal -->
	<div class="modal fade" id="modal_form" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<h4 class="modal-title"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>				
				<br>
				<form class="form-horizontal" role="form" method="POST" id="new_form">
					{{ csrf_field() }}
					<span id="post_method"></span>
					<input type="hidden" class="form-control" value="" name="mapping_id" id="mapping_id">
					<div class="form-group">
						<label class="control-label col-md-4">Employee ID :</label>
						<div class="col-md-6">
							<input type="text" name="emp_id" id="emp_id" class="form-control" placeholder="Employee ID">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4">Supervisor :</label>
						<div class="col-md-6">
							<select name="supervisor_id" id="supervisor_id" class="form-control">
								<option value="" hidden>-SELECT-</option>
								<?php foreach($supervisors as $supervisor) {  ?>
								<option value="<?php echo $supervisor->supervisors_emp_id; ?>"><?php echo   $supervisor->designation_name.' [ '.$supervisor->supervisors_emp_id.' ('.$supervisor->supervisors_name.') '.' ]'; ?></option>
								<?php } ?>
							</select>
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4">Supervisor Role:</label>
						<div class="col-md-6">
							<select name="supervisor_type" id="supervisor_type" class="form-control">
								<option value="1">Supervisors ( Main )</option>
								<option value="2">Supervisors ( Sub )</option>
							</select>
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4">Active From :</label>
						<div class="col-md-6">
							<input type="date" name="active_from" id="active_from" value="<?php echo date('Y-m-d'); ?>" class="form-control">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" id="btnSave"  onclick="save()"  class="btn btn-primary">Save</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- End Bootstrap modal -->
	
	
	
@endsection