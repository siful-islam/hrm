@extends('admin.admin_master')
@section('main_content')

<!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Employee <small>All Non ID Employee</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Eplooyee</a></li>
			<li class="active">Manage Non ID</li>
		</ol>
    </section>


    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Non ID Employee</h3>
							<a href="{{URL::to('/non-appoinment/create')}}" id="add_new" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add New</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">					
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Emp ID</th>
									<th>Emp Type</th>
									<th>Employee Name</th>
									<th>Org. Joining Date</th>
									<th>Branch name</th>
									<th>Consolidated Salary</th>
									<th>Contact Number</th>
									<th>Next Renew Date</th>                                          
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
					 "url": "{{URL::to('/all-non-id')}}",
					 "dataType": "json",
					 "type": "POST",
					 "data":{ _token: "{{csrf_token()}}"}
				   },
			"columns": [
				{ "data": "id" },
				{ "data": "sacmo_id" },
				{ "data": "emp_type" },
				{ "data": "emp_name" },
				{ "data": "joining_date" },
				{ "data": "br_code" },
				{ "data": "gross_salary" },
				{ "data": "contact_num" },
				{ "data": "next_renew_date" },
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

@endsection