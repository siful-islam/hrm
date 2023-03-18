@extends('admin.admin_master')
@section('title', 'Manage Zone')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Navs<small>All Branches</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Settings</a></li>
			<li class="active">Nav Manager</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">All Zones</h3>
						<a href="{{URL::to('/add-zone')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Zone Name</th>
									<th>Zone Code</th>
									<th>Status</th>              
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($zones as $zone)
								<tr>
									<td>{{$zone->zone_id}}</td>
									<td>{{$zone->zone_name}}</td>
									<td>{{$zone->zone_code}}</td>
									<td>{{$zone->status}}</td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('edit-zone/'.$zone->zone_id)}}"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
			$("#Zone").addClass('active');
		});
	</script>

@endsection