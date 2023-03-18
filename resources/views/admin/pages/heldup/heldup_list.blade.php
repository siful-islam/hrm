@extends('admin.admin_master')
@section('title', 'Held Up')
@section('main_content')
<section class="content-header">
	<h1>Employee<small>Heldup</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">Manage Heldup</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{URL::to('/heldup/create')}}" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add Heldup</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Letter Date</th>
								<th>Branch Name</th>
								<th>Designation</th>
								<th>HeldUp Type</th>                 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tbody>								
							{{!$i=1}} @foreach($heldup_info as $heldup)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$heldup->emp_id}}</td>
								<td>{{$heldup->emp_name_eng}}</td>
								<td>{{$heldup->letter_date}}</td>
								<td>{{$heldup->branch_name}}</td>
								<td>{{$heldup->designation_name}}</td>
								<td>{{$heldup->what_heldup}}</td>
								<td class="text-center">
									<a class="btn bg-olive"  title="View" href="{{URL::to('/heldup/'.$heldup->id)}}"><i class="fa fa-eye"></i></a>
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/heldup/'.$heldup->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>
								</td>
							</tr>
							@endforeach
						</tbody>    
					</table>
					</div>
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
		$("#MainGroupEmployee").addClass('active');
		$("#Held_up").addClass('active');
	});
</script>
@endsection