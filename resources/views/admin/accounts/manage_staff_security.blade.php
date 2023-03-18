@extends('admin.admin_master')
@section('title', 'Staff Security')
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
						<h3 class="box-title">Employee Security Money</h3>
							<a href="{{URL::to('/staff-security/create')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add Staff Security</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>									
									<th>Employee ID</th>
									<th>Date</th>
									<th>Amount</th>                   
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($securities as $security)
								<tr>
									<td>{{$security->id}}</td>
									<td>{{$security->emp_id}}</td>
									<td>{{$security->diposit_date}}</td>
									<td>{{$security->diposit_amount}}</td>
									<td>{{$security->status}}</td> 
									<td>
										<a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/staff-security/'.$security->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>
										<a class="btn btn-sm btn-danger" title="Print" href="{{URL::to('/staff-security/'.$security->id)}}"><i class="glyphicon glyphicon-print"></i></a>
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
	$(document).ready(function() {
		$("#MainGroupSalary_Info").addClass('active');
		$("#Staff_Security").addClass('active');
	});
</script>
@endsection