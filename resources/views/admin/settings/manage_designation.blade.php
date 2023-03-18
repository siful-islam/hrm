@extends('admin.admin_master')
@section('title', 'Manage Designation')
@section('main_content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configureation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Config</a></li>
			<li><a href="#">Employee Designation</a></li>
			<li class="active">Manage Designation</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Employee Designation / Unit Manager</h3>
						
							<a href="{{URL::to('/config-designation/create')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Designation</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Designation Name</th>
									<th>Name in Bangla</th>                   
									<th>Is Reportable</th>                   
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($designations as $designation)
								<tr>
									<td>{{$designation->id}}</td>
									<td>{{$designation->designation_name}}</td>
									<td>{{$designation->designation_bangla}}</td>
									<td>{{$designation->is_reportable}}</td>
									<td>{{$designation->status}}</td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/config-designation/'.$designation->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a></td>
								</tr>
								@endforeach
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
			$("#Employee_Designation").addClass('active');
		});
	</script>


@endsection