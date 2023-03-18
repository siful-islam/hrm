
<?php $__env->startSection('title', 'Foreign Travel'); ?>
<?php $__env->startSection('main_content'); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configureation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Employee</a></li>
			<li><a href="#">Travels</a></li>
			<li class="active">Manage Travels</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Employee Travels Manager</h3>
							<button onclick="add_new()" id="add_new" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add New </button>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Emp Id</th>
									<th>Emp Name</th>
									<th>Date From</th>                   
									<th>Date To</th>                   
									<th>Country</th>                                       
									<th>Purpouse</th>                                       
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
<script type="text/javascript" src="<?php echo e(asset('public/admin_asset/bower_components/gritter/js/jquery.gritter.js')); ?>"></script>

<!-- CK Editor -->
<script src="<?php echo e(asset('public/admin_asset/bower_components/ckeditor/ckeditor.js')); ?>"></script>
<script>
	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"ajax":{
					 "url": "<?php echo e(URL::to('/all-travels')); ?>",
					 "dataType": "json",
					 "type": "POST",
					 "data":{ _token: "<?php echo e(csrf_token()); ?>"}
				   },
			"columns": [
				{ "data": "sl" },
				{ "data": "emp_id"},
				{ "data": "emp_name"},
				{ "data": "departure_date" },
				{ "data": "return_date" },
				{ "data": "travel_country" },
				{ "data": "purpose" },
				{ "data": "options" }
			]    

		});
	});

	function reload_table()
	{
		table.ajax.reload(null,false); //reload datatable ajax 
	}

	function add_new()
	{
		save_method = 'add';
		document.getElementById("post_method").innerHTML = "";
		$('#new_form')[0].reset(); // reset form on modals
		$('.form-group').removeClass('has-error'); // clear error class
		$('.help-block').empty(); // clear error string
		$('#modal_form').modal('show'); // show bootstrap modal
		$('.modal-title').text('Add Travel'); // Set Title to Bootstrap modal title
	}

	function edit(id)
	{
		document.getElementById("post_method").innerHTML = "<input type='hidden' name='_method' value='PUT' />";		
		save_method = 'update';
		$('#new_form')[0].reset(); // reset form on modals
		$('.form-group').removeClass('has-error'); // clear error class
		$('.help-block').empty(); // clear error string
		$.ajax({
			url : "<?php echo e(url('travel')); ?>"+"/"+ id+"/edit",			
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				$('[name="id"]').val(data.id);             
				$('[name="emp_id"]').val(data.emp_id);                        
				$('[name="travel_country"]').val(data.travel_country);             
				$('[name="departure_date"]').val(data.departure_date );             
				$('[name="return_date"]').val(data.return_date );             
				$('[name="purpose_id"]').val(data.purpose_id );             
				$('[name="sponsor_by"]').val(data.sponsor_by );             
				$('[name="description"]').html(data.description);             
				$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
				$('.modal-title').text('Edit Travel'); // Set title to Bootstrap modal title
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				$.gritter.add({
					title: 'Error !',
					text: 'Unable Request',
					sticky: false,
					class_name: 'gritter-dark'
				});
			}
		});
	}

	function save()
	{
		$('#btnSave').text('saving...'); //change button text
		$('#btnSave').attr('disabled',true); //set button disable 
		var id = $('#id').val();
		
		if(save_method == 'add') {
			url = "<?php echo e(URL::to('/travel')); ?>";
			message='Data Saved Successfully';
		} else {
			url = "<?php echo e(URL::to('/travel')); ?>"+"/"+ id;
			message='Data Updated Successfully';
		}

		$.ajax({
			url : url,
			type: "POST",
			data: $('#new_form').serialize(),
			dataType: "JSON",
			success: function(data)
			{
				if(data.insert_status)
				{
					$.gritter.add({
						title: 'Success!',
						text: message,
						sticky: false,
						class_name: 'gritter-light'
					});
				}
				
				$('#btnSave').text('Save'); //change button text
				$('#btnSave').attr('disabled',false); //set button enable 
				
				reload_table();
				
				$('#modal_form').modal('hide');				
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				$.gritter.add({
					title: 'Error!',
					text: 'Error to Save Data'
				});
				
				$('#btnSave').text('Save'); //change button text
				$('#btnSave').attr('disabled',false); //set button enable 
			}
		});
	}
	
</script>


<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>   
            <br>
            <form class="form-horizontal" role="form" method="POST" id="new_form">
                <?php echo e(csrf_field()); ?>

				<span id="post_method"></span>
                
				<input type="hidden" class="form-control" value="" name="id" id="id">

				<div class="form-group">
                    <label class="control-label col-md-4">Employee ID :</label>
                    <div class="col-md-6">
                        <input type="text" name="emp_id" id="emp_id" class="form-control" placeholder="Employee ID">
                        <span class="help-block"></span>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="control-label col-md-4">Travel Country :</label>
                    <div class="col-md-6">
						<select name="travel_country" id="travel_country" class="form-control">
							<?php foreach($countries as $country) { ?>
							<option value="<?php echo $country->id; ?>"><?php echo $country->country_name; ?></option>
							<?php } ?>
						<select>
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-4">Departure Date:</label>
                    <div class="col-md-6">
						<input type="date" name="departure_date" id="departure_date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-4">Return Date:</label>
                    <div class="col-md-6">
						<input type="date" name="return_date" id="return_date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-4">Purpose Id:</label>
                    <div class="col-md-6">
						<select name="purpose_id" id="purpose_id" class="form-control">
							<?php foreach($purposes as $purpose) { ?>
							<option value="<?php echo $purpose->purpose_id; ?>"><?php echo $purpose->purpose_name; ?></option>
							<?php } ?>
						<select>
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-4">Description:</label>
                    <div class="col-md-6">
						<textarea name="description" id="description" class="form-control"></textarea>
                        <span class="help-block"></span>
                    </div>
                </div>			
				<div class="form-group">
                    <label class="control-label col-md-4">Sponsor By:</label>
                    <div class="col-md-6">
                        <select name="sponsor_by" id="sponsor_by" class="form-control">
							<option value="1">CDIP</option>
							<option value="2">Singer</option>
						<select>
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="box-footer">
					<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
<script>
	//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupEmployee").addClass('active');
		$("#Foreign_Travel").addClass('active');
	});
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>