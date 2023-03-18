@extends('admin.admin_master')
@section('title', 'Circular')
@section('main_content')
<section class="content-header">
  <h4>add-circular</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Home</a></li>
	<li class="active">add-circular</li>
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
			<div class="col-md-6">
				<div class="box box-info">
					<div class="box-body">							
						<div class="form-group{{ $errors->has('circular_name') ? ' has-error' : '' }}">
							<label for="circular_name" class="col-sm-4 control-label">Circular Name</label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="circular_name" id="circular_name" value="{{$circular_name}}" required autofocus class="form-control">
								@if ($errors->has('circular_name'))
								<span class="help-block">
									<strong>{{ $errors->first('circular_name') }}</strong>
								</span>
								@endif
							</div>
						</div>
						<div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
							<label for="start_date" class="col-sm-4 control-label">Circular Date </label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="start_date" id="start_date" value="{{$start_date}}" required class="form_date form-control">
								@if ($errors->has('start_date'))
								<span class="help-block">
									<strong>{{ $errors->first('start_date') }}</strong>
								</span>
								@endif
							</div>
						</div>
						<div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
							<label for="end_date" class="col-sm-4 control-label">End Date </label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="end_date" id="end_date" value="{{$end_date}}" required class="form_date form-control">
								@if ($errors->has('end_date'))
								<span class="help-block">
									<strong>{{ $errors->first('end_date') }}</strong>
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
						<a href="{{URL::to('/circular')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
						<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
					</div>
				   <!-- /.box-footer -->
				</div>
			</div>
		</form>
	</div>
</section>
<script type="text/javascript">
$(document).ready(function() {
$('.form_date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<script>
	$(document).ready(function() {
		$("#MainGroupRecruitment").addClass('active');
		$("#Circular").addClass('active');
	});
</script>
@endsection