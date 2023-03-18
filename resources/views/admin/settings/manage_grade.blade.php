@extends('admin.admin_master')
@section('title', 'Manage Grade')
@section('main_content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configureation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Config</a></li>
			<li><a href="#">Employee Grade</a></li>
			<li class="active">Manage Grade</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Employee Grade Manager</h3>
							<a href="{{URL::to('/config-grade/create')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Grade</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Grade Name</th>
									<th>Scale</th>                   
									<th>Duration</th>                   
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($grades as $grade)
								<tr>
									<td>{{$grade->id}}</td>
									<td>{{$grade->grade_name}}</td>
									<td>{{$grade->scale_name}}</td>
									<td>{{$grade->start_from}} <span style="color:red;">to</span> {{$grade->end_to}}</td>
									<td>{{$grade->status}}</td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/config-grade/'.$grade->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
			$("#Grade").addClass('active');
		});
	</script>	



@endsection