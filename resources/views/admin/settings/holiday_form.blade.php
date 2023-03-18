@extends('admin.admin_master')
@section('title', 'Manage Holiday')
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
				
				<?php echo $action ?>
				
				<input type="hidden" id="id" name="id" value="{{$id}}" >
				
				<div class="box-body">
				
					
					<div class="form-group">
						<label for="holiday_date" class="col-sm-2 control-label">Holiday Date </label>
						<div class="col-sm-4">
							<input class="form-control" type ="date" name="holiday_date" value="{{$holiday_date}}"> 
						</div>
					</div>
					
					<div class="form-group">
						<label for="holiday_name" class="col-sm-2 control-label">Holiday Name</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="holiday_name" name="holiday_name" value="{{$holiday_name}}" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="description" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="description" name="description" value="{{$description}}">
						</div>
					</div>

					<div class="form-group">
						<label for="description_bn" class="col-sm-2 control-label">Description (Bangla)</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="description_bn" name="description_bn" value="{{$description_bn}}">
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
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupSettings").addClass('active');
			$("#Holiday").addClass('active');
		});
	</script>
@endsection