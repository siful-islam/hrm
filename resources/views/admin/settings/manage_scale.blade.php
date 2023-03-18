@extends('admin.admin_master')
@section('title', 'Manage Scale')
@section('main_content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configureation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Config</a></li>
			<li><a href="#">Employee Scale</a></li>
			<li class="active">Manage Scale</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Employee Scale Manager</h3>
							<a href="{{URL::to('/config-scale/create')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Scale</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>									
									<th>Scale Name</th>
									<th>Scale ID</th>
									<th>Basic Salary</th>               
									<th>Duration</th>               
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($scales as $scale)
								<tr>
									<td>{{$scale->id}}</td>
									<td>{{$scale->scale_name}}</td>
									<td>{{$scale->scale_id}}</td>
									<td>{{$scale->scale_basic_1st_step}}</td>
									<td>{{$scale->start_from}} <span style="color:red;">to</span> {{$scale->end_to}}</td>
									<td>{{$scale->status}}</td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/config-scale/'.$scale->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
				$("#Scale").addClass('active');
			});
	</script>
		


@endsection