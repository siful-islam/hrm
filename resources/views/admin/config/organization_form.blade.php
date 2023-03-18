@extends('admin.admin_master')
@section('title', 'Manage Organization')
@section('main_content')

<style>

.image-upload > input
{
    display: none;
}

.image-upload img
{
    margin-left:20%;
	margin-top:10px;
	width: 90;
	height:110;
    cursor: pointer;	
	background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 4px;
}
</style>

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
				
				
				<form class="form-horizontal" action="{{URL::to($action)}}" method="{{$method}}" enctype="multipart/form-data">
                {{ csrf_field() }}
				{!!$method_control!!}
				
				<input type="hidden" id="org_id" name="org_id" value="{{$org_id}}" >
				
				<div class="box-body">
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Org Full Name</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="org_full_name" name="org_full_name" value="{{$org_full_name}}" placeholder="Org Full Name" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="org_short_name" class="col-sm-2 control-label">Org Short Name</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="org_short_name" name="org_short_name" value="{{$org_short_name}}" placeholder="Org Short Name" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="nav_group_name" class="col-sm-2 control-label">Org Code</label>
						<div class="col-sm-4">
							<input type="number" class="form-control" id="org_code" name="org_code" value="{{$org_code}}" placeholder="Org Code" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="reg_no" class="col-sm-2 control-label">Reg No</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="reg_no" name="reg_no" value="{{$reg_no}}" placeholder="Reg No" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="org_logo" class="col-sm-2 control-label">Logo</label>
						<div class="col-sm-4">
							<label for="org_logo">
							<img id="blah" class="img-thumbnail" src="{{asset($org_logo)}}" width="90" height="110"/>
							</label>
							<input type="file" onchange="readURL(this);" class="form-control" name="org_logo" id="org_logo">
							<input type="hidden" name="pre_org_logo" value="{{$pre_org_logo}}">
						</div>
					</div>
					
					<div class="form-group">
						<label for="org_address" class="col-sm-2 control-label">Address</label>
						<div class="col-sm-4">
							<textarea class="form-control" id="org_address" name="org_address" required>{{$org_address}}</textarea>
						</div>
					</div>
					
					<div class="form-group">
						<label for="org_contact" class="col-sm-2 control-label">Contact No</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="org_contact" name="org_contact" value="{{$org_contact}}" placeholder="Contact No" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="org_email" class="col-sm-2 control-label">Email Address</label>
						<div class="col-sm-4">
							<input type="email" class="form-control" id="org_email" name="org_email" value="{{$org_email}}" placeholder="Ex: abc@gmail.com" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="org_web_address" class="col-sm-2 control-label">Web Address</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="org_web_address" name="org_web_address" value="{{$org_web_address}}" placeholder="Ex: www.abc.com" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="org_start_date" class="col-sm-2 control-label">Start Date</label>
						<div class="col-sm-4">
							<input type="date" class="form-control" id="org_start_date" name="org_start_date" value="{{$org_start_date}}" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-4">
							<select name="org_status" id="org_status" class="form-control" required>							
								<option value="0">No</option>
								<option value="1">Yes</option>
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
		document.getElementById("org_status").value = '{{$org_status}}';
	</script>
	<script>
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('#blah')
						.attr('src', e.target.result)
						.width(90)
						.height(110);
				};

				reader.readAsDataURL(input.files[0]);
			}
		}
	</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupConfig").addClass('active');
			$("#Org_Manager").addClass('active');
		});
	</script>
@endsection