@extends('admin.admin_master')
@section('title', 'Increment Letter')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Employee<small>Increment</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Eployee</a></li>
			<li class="active">Manage Increment</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Auto Increment List</h3>
							<a href="{{URL::to('/increment-letter/create')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add </a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Sl No</th>
									<th>Letter date</th>
									<th>Next Increment Date</th>
									<th>Grade</th>                     
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>								
							{{!$i=1}} @foreach($increment_info as $increment)
								<tr>
									<td>{{$i++}}</td>
									<td>{{$increment->letter_date}}</td>
									<td>{{$increment->increment_date}}</td>
									<td>{{$increment->grade_code}}</td>								
									<td class="text-center">
										<!--<a class="btn bg-olive"  title="View" href="{{URL::to('/increment-letter/'.$increment->id)}}"><i class="fa fa-eye"></i></a>-->
										<a class="btn btn-primary" title="Edit" href="{{URL::to('/increment-letter/'.$increment->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>
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
		$("#MainGroupEmployee").addClass('active');
		$("#Increment_Letter").addClass('active');
	});
</script>
@endsection