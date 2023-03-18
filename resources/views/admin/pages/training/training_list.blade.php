@extends('admin.admin_master')
@section('title', 'Training')
@section('main_content')
<section class="content-header">
	<h1>Employee<small>Training</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">Manage Training</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{URL::to('/training/create')}}" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add Training</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Training No</th>
								<th>Training Name</th>
								<th>Institute Name</th>
								<th>Date from</th>
								<th>Date to</th>                    
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tbody>								
							{{!$i=1}} @foreach($training_info as $training)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$training->training_no}}</td>
								<td>{{$training->training_name}}</td>
								<td>@if ($training->institute_name == 1) {{'CDIP'}} @endif</td>
								<td>{{$training->tr_date_from}}</td>								
								<td>{{$training->tr_date_to}}</td>								
								<td class="text-center">
									<a class="btn bg-olive"  title="View" href="{{URL::to('/training/'.$training->training_no)}}"><i class="fa fa-eye"></i></a>
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/training/'.$training->training_no.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>
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
			$("#Training").addClass('active');
		});
	</script>
@endsection