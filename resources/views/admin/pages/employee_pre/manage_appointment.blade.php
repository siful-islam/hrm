@extends('admin.admin_master')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Employee Appointment<small>All Joining Employee</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Eplooyee</a></li>
			<li class="active">Manage Appointment</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Data Table</h3>
							<a href="{{URL::to('/add-appoinments')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
				
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Emp ID</th>
									<th>Letter Date</th>
									<th>Employee Name</th>
									<th>Father</th>
									<th>Village</th>
									<th>Post</th>
									<th>District</th>                      
									<th>Status</th>                      
									<th style="width:15%">ACtion</th>
								</tr>
							</thead>
							<tbody>
				
								@foreach($all_appointment_info as $v_all_appointment_info)
								<tr>
									<td>{{$v_all_appointment_info->id}}</td>
									<td>{{$v_all_appointment_info->emp_id}}</td>
									<td>{{$v_all_appointment_info->letter_date}}</td>
									<td>{{$v_all_appointment_info->emp_name}}</td>
									<td>{{$v_all_appointment_info->father_name}}</td>
									<td>{{$v_all_appointment_info->emp_village}}</td>
									<td>{{$v_all_appointment_info->emp_po}}</td>
									<td>{{$v_all_appointment_info->emp_po}}</td>
									<td>{{$v_all_appointment_info->joining_date}}</td>
									<td>
									<a class="btn btn-sm btn-danger"  title="View" href="{{URL::to('/view-appoinment/'.$v_all_appointment_info->id)}}"><i class="fa fa-eye"></i></a>
									<a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/edit-appoinment/'.$v_all_appointment_info->id)}}"><i class="glyphicon glyphicon-pencil"></i></a>		
									@if(empty($v_all_appointment_info->empid))
									<a class="btn btn-sm btn-primary" title="CV" href="{{URL::to('/emp-general/'.$v_all_appointment_info->emp_id)}}"><i class="fa fa-envelope"></i></a>
									@endif
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
		
<!-- DataTables -->
<script src="{{asset('public/admid_asset/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/admid_asset/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>	

<script>
	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
		});
	});
</script>

@endsection