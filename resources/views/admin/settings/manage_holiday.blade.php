@extends('admin.admin_master')
@section('title', 'Manage Holiday')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Navs<small>Holidays</small></h1>
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
						<h3 class="box-title">All Holidays</h3>
						<a href="{{URL::to('/add-holiday')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>Holiday Date</th>
									<th>Holidays Name</th>
									<th>Description</th>
									<th>Description (Bangla)</th>           
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($holidays as $holiday)
								<tr>
									<td>{{$holiday->holiday_id}}</td>
									<td>{{$holiday->holiday_date}}</td>
									<td>{{$holiday->holiday_name}}</td>
									<td>{{$holiday->description}}</td>
									<td>{{$holiday->description_bn}}</td>
									<td>
									<a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/edit-holiday/'.$holiday->holiday_id)}}"><i class="glyphicon glyphicon-pencil"></i></a>
									<a class="btn btn-sm btn-danger" title="Delete" href="{{URL::to('/delete-holiday/'.$holiday->holiday_id)}}" onclick="return confirm('Are you sure?')"><i class="glyphicon glyphicon-trash"></i></a>
									</td>
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
			$("#Holidays").addClass('active');
		});
	</script>

@endsection