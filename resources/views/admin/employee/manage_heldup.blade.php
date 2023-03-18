@extends('admin.admin_master')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Employee<small>Heldup</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Eplooyee</a></li>
			<li class="active">Manage Heldup</li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">heldup List</h3>
						<a href="{{URL::to('/heldup/create')}}" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add Heldup </a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Emp ID</th>
									<th>Employee Name</th>
									<th>Sarok No</th>
									<th>Letter Date</th>                    
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>No</th>
									<th>Emp ID</th>
									<th>Employee Name</th>
									<th>Sarok No</th>
									<th>Letter Date</th>                    
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</tfoot>
							<tbody>
								@foreach($heldup_info as $v_heldup_info)
								<tr>
									<td>{{$v_heldup_info->id}}</td>
									<td>{{$v_heldup_info->emp_id}}</td>
									<td>{{$v_heldup_info->emp_name}}</td>
									<td>{{$v_heldup_info->sarok_no}}</td>
									<td>{{$v_heldup_info->letter_date}}</td>
									<td>{{$v_heldup_info->status}}</td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/heldup/'.$v_heldup_info->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a></td>
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

@endsection