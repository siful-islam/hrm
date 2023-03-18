@extends('admin.admin_master')
@section('title', 'Manage Extra Deduction Type')
@section('main_content')
<section class="content-header">
  <h4>add-district</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Home</a></li>
	<li class="active">add-district</li>
  </ol>
</section>
<section class="content">	
	<div class="row">			
		<!-- form start -->
		<!--<h3 style="color:green">
			@if(Session::has('message'))
			{{session('message')}}
			@endif
		</h3>-->
		<form action="{{URL::to($action)}}" method="post" class="form-horizontal" >
			{{ csrf_field() }}
			{!! $method_field !!}
			<div class="col-md-6">
				<div class="box box-info">
					<div class="box-body">							
						<div class="form-group{{ $errors->has('type_name') ? ' has-error' : '' }}">
							<label for="type_name" class="col-sm-4 control-label">Type Name</label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="type_name" id="type_name" value="{{$type_name}}" required autofocus class="form-control">
								@if ($errors->has('type_name'))
								<span class="help-block">
									<strong>{{ $errors->first('type_name') }}</strong>
								</span>
								@endif
							</div>
						</div>
						<div class="form-group">
							<label for="status" class="col-sm-4 control-label">Status</label><span class="required">*</span>
							<div class="col-sm-6">
								<select class="form-control" id="status" name="status" required>						
									<option value="1" <?php if($status=="1") echo 'selected="selected"'; ?> >Active</option>
									<option value="0" <?php if($status=="0") echo 'selected="selected"'; ?> >InActive</option>
								</select>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="{{URL::to('/extra_deduc_type')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
						<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
					</div>
				   <!-- /.box-footer -->
				</div>
			</div>
		</form>
	</div>
</section>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$("#Extra_Deduction_Type").addClass('active');
			});
	</script>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$("#Extra_Deduction_Type").addClass('active');
			});
	</script>
@endsection