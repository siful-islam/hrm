@extends('admin.admin_master')
@section('title', 'Manage Menu Group')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Menu Group<small>All Menu Group</small></h1>
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
						<h3 class="box-title">Menu Group</h3>
						<a href="{{URL::to('/add_group_menu')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Menu Group Name</th>
									<th>Group Icon</th>
									<th>Order</th>
									<th>Status</th>                  
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($menu_groups as $menu_group)
								<tr>
									<td>{{$menu_group->nav_group_id}}</td>
									<td>{{$menu_group->nav_group_name}}</td>
									<td>{{$menu_group->grpup_icon}}</td>
									<td>{{$menu_group->sl_order}}</td>
									<td>{{$menu_group->status}}</td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/edit-nav-group/'.$menu_group->nav_group_id)}}"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
			$("#Manage_Menu_Group").addClass('active');
		});
	</script>
@endsection