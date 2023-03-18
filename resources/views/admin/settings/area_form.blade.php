@extends('admin.admin_master')
@section('title', 'Manage Area')
@section('main_content')


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Form Elements<small>Preview</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Forms</a></li>
			<li class="active">Advanced Elements</li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content">
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> {{$Heading}}</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			
				<?php 
				/*$access_label 	= Session::get('admin_access_label');
				$permission    	= DB::table('tbl_user_permissions')
									->where('user_role_id',$access_label)
									->where('nav_id',7)
									->where('status',1)
									->get();
									
									
				print_r($permission);*/
				?>
			
			
			
				<form class="form-horizontal" action="{{URL::to($action)}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
				
				<input type="hidden" id="id" name="id" value="{{$id}}" >
				
				<div class="box-body">
					
					<div class="form-group">
						<label for="zone_code" class="col-sm-2 control-label">Select Zone </label>
						<div class="col-sm-4">
						<select class="form-control" id="zone_code" name="zone_code" required>						
							<option value="" hidden>-SELECT-</option>
							@foreach ($all_zone as $v_all_zone)
							<option value="{{$v_all_zone->zone_code}}">{{$v_all_zone->zone_name}}</option>
							@endforeach
						</select>
						</div>
					</div>
					
					<div class="form-group">
						<label for="area_name" class="col-sm-2 control-label">Area Name</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="area_name" name="area_name" value="{{$area_name}}" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="area_code" class="col-sm-2 control-label">Area Code </label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="area_code" name="area_code" value="{{$area_code}}" required>
						</div>
					</div>

					<div class="form-group">
						<label for="status" class="col-sm-2 control-label">Staus</label>
						<div class="col-sm-4">
							<select name="status" id="status" class="form-control" required>
								<option value="1">Active</option>
								<option value="0">Drop</option>
							</select>
						</div>
					</div>
					
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<button type="reset" class="btn btn-default">Cancel</button>
					<button type="submit" class="btn btn-info">{{$button_text}}</button>
				</div>
				<!-- /.box-footer -->
			</form>

		</div>
	</section>
	
	<script>
	document.getElementById("zone_code").value={{$zone_code}};
	document.getElementById("status").value={{$status}};
	</script>
	
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupSettings").addClass('active');
			$("#Area").addClass('active');
		});
	</script>
@endsection