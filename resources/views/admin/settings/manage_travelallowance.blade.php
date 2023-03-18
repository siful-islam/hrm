@extends('admin.admin_master')
@section('title', 'Manage Travel Allowance')
@section('main_content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configureation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Config</a></li>
			<li><a href="#">Travel Allowance</a></li>
			<li class="active">Manage Travel Allowance</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Travel Allowance Manager</h3>
						
							<a href="{{URL::to('/travel_allowance/create')}}" id="myAnchor" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Sl No</th>
									<th>Source</th>
									<th>Designation</th>                   
									<th>Amount</th>                   
									<th>From</th>                   
									<th>To</th>                   
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Sl No</th>
									<th>Source</th>
									<th>Designation</th>                   
									<th>Amount</th>                   
									<th>From</th>                   
									<th>To</th>                   
									<th>Status</th>                      
									 <th style="width:15%">Action</th>
								</tr>
							</tfoot>
							<tbody>
								@foreach($travel_allowance_list as $tr_all)
								<tr>
									<td>{{$tr_all->id}}</td>
									<td>{{$tr_all->source_branch_name}}</td>
									<td>{{$tr_all->destination_branch_name}}</td>
									<td>{{$tr_all->travel_amt}}</td>
									<td>{{$tr_all->from_date}}</td>
									<td>{{$tr_all->to_date}}</td>
									<td>@if($tr_all->status == 1) {{"Running"}} @else {{"Cancel"}} @endif</td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/travel_allowance/'.$tr_all->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
	document.getElementById("myAnchor").focus(); 
</script>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$('#Travel_allowance').addClass('active');
			});
	</script>

@endsection