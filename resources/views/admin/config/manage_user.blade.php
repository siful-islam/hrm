@extends('admin.admin_master')
@section('title', 'Manage User')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>User Manager<small>All Users</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">User</a></li>
			<li class="active">User Manager</li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">User Manager</h3>
						<a href="{{URL::to('/add_user')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New</a>
						
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>User Name</th>
									<th>Emp Id</th>
									<th>Email</th>
									<th>User Cell No</th>
									<th>Access lavel</th>                                   
									<th>Photo</th>                                   
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>No</th>
									<th>User Name</th>
									<th>Emp Id</th>
									<th>Email</th>
									<th>User Cell No</th>
									<th>Access lavel</th>                                   
									<th>Photo</th>                                   
									<th style="width:15%">Action</th>
								</tr>
							</tfoot>
							<tbody>
								@foreach($users as $user)
								<tr>
									<td>{{$user->id}}</td>
									<td>{{$user->admin_name}}</td>
									<td>{{$user->emp_id}}</td>
									<td>{{$user->email_address}}</td>
									<td>{{$user->cell_no}}</td>
									<td>{{$user->admin_role_name}}</td>
									<td><img src="public/avatars/{{$user->admin_photo}}" alt="Logo" width="35"></td>
									<td><a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/edit-user/'.$user->admin_id)}}"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
			$("#MainGroupConfig").addClass('active');
			$("#User_Manager").addClass('active');
		});
	</script>	


@endsection