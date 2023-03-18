@extends('admin.admin_master')
@section('title', 'Approved Movement')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h4>Approved Movement</h4>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Employee</a></li>
			<li class="active">Leave</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<!-- /.box-header -->
					<div class="box-body">
						<div class="table-responsive">
						<table id="table" class="table no-border table-striped">
							<thead>
								<tr>
									<th>SL No</th>
									<th>Emp Type</th>
									<th>Emp ID</th>
									<th>Emp Name</th>
									<th>Leave Date</th> 
									<th>Leave Time</th> 
									<th>Purpose</th> 
									<th>Status</th> 
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>SL No</th>
									<th>Emp Type</th>
									<th>Emp ID</th>
									<th>Emp Name</th>
									<th>Leave Date</th> 
									<th>Leave Time</th> 
									<th>Purpose</th> 
									<th>Status</th> 
									 
								</tr>
							</tfoot>
							<tbody> 
							@php 
								$i=1
							@endphp
							@foreach($movement_register_list as $register_list)
								<tr>
									<td>{{$i++}}</td>
									<td>{{$register_list->type_name}}</td>
									<td>{{$register_list->emp_id}}</td>
									<td><?php if($register_list->emp_type == 1) { 
											echo $register_list->emp_name; 
										} else {
											echo $register_list->emp_name2; 
										} ?> </td> 
									<td>{{$register_list->from_date}}</td>
									<td>{{date("g:i A", strtotime($register_list->leave_time))}}</td> 
									<td>{{$register_list->purpose}}</td>  
									<td><span style="color:green;">@if($register_list->status == 1){{"Approved"}}</span>@elseif($register_list->status == 2)<span style="color:red;">{{"Reject"}} </span>@else <span style="color:#FF9900;">{{"Pending "}}</span>@endif</td> 
									<td class="text-center">
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/movement_approved/'.$register_list->move_id.'/'.$register_list->emp_id.'/'.$register_list->emp_type)}}"><i class="glyphicon glyphicon-pencil"></i></a>
									 
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
	
<!-- DataTables -->
<script src="{{asset('public/admin_asset/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/admin_asset/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>		
	
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
			$("#MainGroupTravel").addClass('active');
			$("#Approved_Movement").addClass('active');
		});
	</script>

@endsection