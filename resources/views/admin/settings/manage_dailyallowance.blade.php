@extends('admin.admin_master')
@section('title', 'Manage Daily Allowance')
@section('main_content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configureation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Config</a></li>
			<li><a href="#">Daily Allowance</a></li>
			<li class="active">Manage Daily Allowance</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Daily Allowance Manager</h3>
						
							<a href="{{URL::to('/daily_allowance/create')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Sl No</th>
									<th>Grade Name</th>
									<th>Breakfast</th>                   
									<th>Lunch</th>                   
									<th>Dinner</th>                   
									<th>From</th>                   
									<th>To</th>                   
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Sl No</th>
									<th>Grade Name</th>
									<th>Breakfast</th>                   
									<th>Lunch</th>                   
									<th>Dinner</th>                   
									<th>From</th>                   
									<th>To</th>                   
									<th>Status</th> 
									<th style="width:15%">Action</th>									
								</tr>
							</tfoot>
							<tbody>
								@foreach($daily_allowance_list as $tr_all)
								<tr>
									<td>{{$tr_all->id}}</td>
									<td>{{$tr_all->grade_name}}</td>
									<td>{{$tr_all->breakfast}}</td>
									<td>{{$tr_all->lunch}}</td>
									<td>{{$tr_all->dinner}}</td>
									<td>{{$tr_all->from_date}}</td>
									<td>{{$tr_all->to_date}}</td>
									<td>@if($tr_all->status == 1) {{"Running"}} @else {{"Cancel"}} @endif</td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/daily_allowance/'.$tr_all->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
				$('#Daily_Allowance').addClass('active');
			});
	</script>


@endsection