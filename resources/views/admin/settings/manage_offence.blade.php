@extends('admin.admin_master')
@section('title', 'Manage Offense')
@section('main_content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configureation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Settings</a></li>
			<li><a href="#">Employee Offense</a></li>
			<li class="active">Manage Offense</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Employee Offense Manager</h3>
							<a href="{{URL::to('/settings-offense/create')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Offense</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>									
									<th>Subject</th>
									<th>Details</th>
									<th>Punishment</th>                   
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($offenses as $offense)
								<tr>
									<td>{{$offense->id}}</td>
									<td>{{$offense->crime_subject}}</td>
									<td>{{$offense->crime_detail}}</td>
									<td>{{$offense->punishment}}</td>
									<td>{{$offense->status}}</td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/settings-offense/'.$offense->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
				$("#Offence").addClass('active');
			});
	</script>

@endsection