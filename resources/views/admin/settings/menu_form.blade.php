@extends('admin.admin_master')
@section('title', 'Manage Menu')
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
				
				
				<form class="form-horizontal" action="{{URL::to($action)}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
				
				<input type="hidden" id="nav_id" name="nav_id" value="{{$nav_id}}" >
				
				<div class="box-body">
					<div class="form-group">
						<label for="nav_group_name" class="col-sm-2 control-label">Select Nav Group </label>
						<div class="col-sm-4">
						<select class="form-control" id="nav_group_id" name="nav_group_id" required>						
							<option value="" hidden>-SELECT-</option>
							@foreach ($all_nav_group as $v_all_nav_group)
							<option value="{{$v_all_nav_group->nav_group_id}}">{{$v_all_nav_group->nav_group_name}}</option>
							@endforeach
						</select>
						</div>
					</div>
					
					<div class="form-group">
						<label for="nav_name" class="col-sm-2 control-label">Nav Name</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="nav_name" name="nav_name" value="{{$nav_name}}" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="nav_action" class="col-sm-2 control-label">Nav Action</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="nav_action" name="nav_action" value="{{$nav_action}}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="user_access" class="col-sm-2 control-label">User Access</label>
						<div class="col-sm-4">
							<?php foreach($user_role as $user_role) { ?>
								<input type="checkbox" value="<?php echo $user_role->id; ?>" name="user_access[]" <?php if(in_array($user_role->id, $user_access)) {echo 'checked';} ?>><?php echo $user_role->admin_role_name;?>
							<?php } ?>
						</div>
					</div>
					
					<div class="form-group">
						<label for="nav_action" class="col-sm-2 control-label">Display Order</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="nav_order" name="nav_order" value="{{$nav_order}}" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="nav_status" class="col-sm-2 control-label">Staus</label>
						<div class="col-sm-4">
							<select name="nav_status" id="nav_status" class="form-control" required>
								<option value="1">Yes</option>
								<option value="0">No</option>
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
	document.getElementById("nav_group_id").value={{$nav_group_id}};
	document.getElementById("nav_status").value={{$nav_status}};
	</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupConfig").addClass('active');
			$("#Manage_Menu").addClass('active');
		});
	</script>
@endsection