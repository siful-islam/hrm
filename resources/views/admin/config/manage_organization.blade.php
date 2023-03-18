@extends('admin.admin_master')
@section('title', 'Manage Organization')
@section('main_content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configureation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Config</a></li>
			<li><a href="#">Organization</a></li>
			<li class="active">Manage Organization</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Organization Manager</h3>
							<a href="{{URL::to('/org-manager/create')}}" id="add_new" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add Organization</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Short Name</th>
									<th>Org Code</th>
									<th>Contact</th>                     
									<th>Email</th>                     
									<th>Web</th>                     
									<th>Logo</th>                     
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($organizations as $organization)
								<tr>
									<td>{{$organization->org_id}}</td>
									<td>{{$organization->org_short_name}}</td>
									<td>{{$organization->org_code}}</td>
									<td>{{$organization->org_contact}}</td>
									<td>{{$organization->org_email}}</td>
									<td>{{$organization->org_web_address}}</td>
									<td><img src="public/org_logo/{{$organization->org_logo}}" alt="Logo" width="35"></td> 
									<td>{{$organization->org_status}}</td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('org-manager/'.$organization->org_id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
			$("#Org_Manager").addClass('active');
		});
	</script>
@endsection