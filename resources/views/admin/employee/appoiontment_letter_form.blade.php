@extends('admin.admin_master')
@section('title', 'Appointment Letter')
@section('main_content')
<script src="{{asset('public/admin_asset/plugins/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>Appointment</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Employee</a></li>
			<li><a href="#">Appointment Letter</a></li>
			<li class="active">--</li>
		</ol>
	</section>
	<section>
		<!-- Main content -->
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> Appointnemt Letter </h3>
			</div>
			<!-- form start -->
			<form class="form-horizontal" action="{{URL::to($action)}}" role="form" method="POST" id="new_form" enctype="multipart/form-data">
                {{ csrf_field() }}
				{!!$method_control!!}

                <input type="hidden" value="{{$id}}" name="id" id="id">
				<input type="hidden" value="{{$emp_id}}" name="emp_id" id="emp_id">

				<div class="form-group">
					<div class="col-md-12" style="min-height: 500px;">
					   <textarea id="letter_body" name="letter_body" rows="100">{{$letter_body}}</textarea>
						<span class="help-block"></span>
					</div>
				</div>
  
				<div class="box-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Reset</button>
					<button type="sublit" id="btnSave" class="btn btn-primary">Save</button>
				</div>
			</form>

		</div>
	</section>
	<!-- CK Editor -->
	<script type="text/javascript"><!--
		CKEDITOR.replace('letter_body');
		CKEDITOR.add 
//--></script>	
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee").addClass('active');
			$("#Appointment").addClass('active');
		});
	</script>
@endsection