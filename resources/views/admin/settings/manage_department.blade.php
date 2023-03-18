@extends('admin.admin_master')
@section('title', 'Manage Department')
@section('main_content')



    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configureation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Config</a></li>
			<li><a href="#">Employee Department</a></li>
			<li class="active">Manage Department</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Employee Department Manager</h3>
							<a href="{{URL::to('/config-department/create')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Department</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>									
									<th>Department Name</th>
									<th>Department Id</th>
									<th>Name in Bangla</th>                   
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($departments as $department)
								<tr>
									<td>{{$department->id}}</td>
									<td>{{$department->department_name}}</td>
									<td>{{$department->department_id}}</td>
									<td>{{$department->department_bangla}}</td>
									<td>{{$department->status}}</td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/config-department/'.$department->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
				$("#Department").addClass('active');
			});
	</script>
@endsection