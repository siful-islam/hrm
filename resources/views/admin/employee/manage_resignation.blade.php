@extends('admin.admin_master')
@section('title', 'Resignation')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Employee<small>Resignation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Eplooyee</a></li>
			<li class="active">Manage Resignation</li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Resignation List</h3>
							<a href="{{URL::to('/resignation/create')}}" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add Resignation </a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th style="width:5%">No</th>
									<th>Emp ID</th>
									<th>Employee Name</th>
									<th>Sarok No</th>
									<th>Letter Date</th>
									<th>Effect Date</th>                                          
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th style="width:5%">No</th>
									<th>Emp ID</th>
									<th>Employee Name</th>
									<th>Sarok No</th>
									<th>Letter Date</th>
									<th>Effect Date</th>                                          
									<th style="width:15%">Action</th>
								</tr>
							</tfoot>
							<tbody>
									<?php $i = 1;
									$session_branch_code = Session::get('branch_code');
									if($session_branch_code != 9999){
										foreach($resignation_info as $v_resignation_info){

											if($v_resignation_info->designation_code == 74 || $v_resignation_info->designation_code == 242 ){
												
											 
											?>
								 
										<tr>
											<td>{{$i++}}</td>
											<td>{{$v_resignation_info->emp_id}}</td>
											<td>{{$v_resignation_info->emp_name_eng}}</td>
											<td>{{$v_resignation_info->sarok_no}}</td>
											<td>{{$v_resignation_info->letter_date}}</td>
											<td>{{$v_resignation_info->effect_date}}</td>
											<td></td>							
										</tr>
										 
								<?php	
										} } }else{ ?>
										@foreach($resignation_info as $v_resignation_info)
								 
										<tr>
											<td>{{$i++}}</td>
											<td>{{$v_resignation_info->emp_id}}</td>
											<td>{{$v_resignation_info->emp_name_eng}}</td>
											<td>{{$v_resignation_info->sarok_no}}</td>
											<td>{{$v_resignation_info->letter_date}}</td>
											<td>{{$v_resignation_info->effect_date}}</td>
											<td><a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/resignation/'.$v_resignation_info->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a></td>							
										</tr>
										@endforeach
										 
								<?php 
									}
								?>
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
			$("#MainGroupEmployee").addClass('active');
			$("#Resignation").addClass('active');
		});
	</script>
@endsection