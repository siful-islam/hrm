@extends('admin.admin_master')
@section('title', 'Manage Menu')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Navs<small>All Menus</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Settings</a></li>
			<li class="active">Nav Manager</li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">All Menus</h3>
						<a href="{{URL::to('/add_menu')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Menu Group Name</th>
									<th>Nav Name</th>
									<th>Nav Action</th>
									<th>Order</th>
									<th>Status</th>              
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>No</th>
									<th>Menu Group Name</th>
									<th>Nav Name</th>
									<th>Nav Action</th>
									<th>Order</th>
									<th>Status</th>              
									<th style="width:15%">Action</th>
								</tr>
							</tfoot>
							<tbody>
								@foreach($menus as $menu)
								<tr>
									<td>{{$menu->nav_id}}</td>
									<td>{{$menu->nav_group_name}}</td>
									<td>{{$menu->nav_name}}</td>
									<td>{{$menu->nav_action}}</td>
									<td>{{$menu->nav_order}}</td>
									<td>{{$menu->nav_status}}</td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/edit-nav/'.$menu->nav_id)}}"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupConfig").addClass('active');
			$("#Manage_Menu").addClass('active');
		});
	</script>
@endsection