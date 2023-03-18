@extends('admin.admin_master')
@section('title', 'Employee(CV)')
@section('main_content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h4>Employee CV</h4>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Employee</a></li>
		<li class="active">CV</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
					
					<table id="tables" class="table table-bordered table-hover" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>SL No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Joining Date</th>
								<th>Contact Number</th>
								<th>NID</th>                      
								<th>Thana</th>                      
								<th>District</th>                    
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>        
					</table>
						
					</div>
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
	   table = $('#tables').DataTable({
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"ajax":{
					 "url": "{{URL::to('/all-cv')}}",
					 "dataType": "json",
					 "type": "POST",
					 "data":{ _token: "{{csrf_token()}}"}
				   },
			"columns": [
				{ "data": "id" },
				{ "data": "emp_id" },
				{ "data": "emp_name_eng" },
				{ "data": "org_join_date" },
				{ "data": "contact_num" },
				{ "data": "national_id" },
				{ "data": "thana_name" },
				{ "data": "district_name" },
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
		//$("#Employee_(CV)").addClass('active');
		$('[id^=Employee_]').addClass('active');
	});
</script>
@endsection