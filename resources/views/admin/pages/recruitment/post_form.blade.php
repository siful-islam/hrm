@extends('admin.admin_master')
@section('title', 'Post Name')
@section('main_content')
<section class="content-header">
  <h4>add-post</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Home</a></li>
	<li class="active">add-post</li>
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
						<div class="form-group{{ $errors->has('circular_id') ? ' has-error' : '' }}">
							<label for="circular_id" class="col-sm-4 control-label">Circular Name</label><span class="required">*</span>
							<div class="col-sm-6">
								<select name="circular_id" id="circular_id" required class="form-control">
									<option value="">Select</option>								
									@foreach($all_circular as $circular)
									<option value="{{$circular->id}}">{{$circular->circular_name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group{{ $errors->has('post_name') ? ' has-error' : '' }}">
							<label for="post_name" class="col-sm-4 control-label">Post Name </label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="post_name" id="post_name" value="{{$post_name}}" required class="form-control">
								@if ($errors->has('post_name'))
								<span class="help-block">
									<strong>{{ $errors->first('post_name') }}</strong>
								</span>
								@endif
							</div>
						</div>
						<div class="form-group{{ $errors->has('normal_age') ? ' has-error' : '' }}">
							<label for="normal_age" class="col-sm-4 control-label">Normal Age </label>
							<div class="col-sm-6">
								<input type="text" name="normal_age" id="normal_age" value="{{$normal_age}}"  class="form-control">
								@if ($errors->has('normal_age'))
								<span class="help-block">
									<strong>{{ $errors->first('normal_age') }}</strong>
								</span>
								@endif
							</div>
						</div>
						<div class="form-group{{ $errors->has('experience_age') ? ' has-error' : '' }}">
							<label for="experience_age" class="col-sm-4 control-label">Experience Age </label>
							<div class="col-sm-6">
								<input type="text" name="experience_age" id="experience_age" value="{{$experience_age}}"  class="form-control">
								@if ($errors->has('experience_age'))
								<span class="help-block">
									<strong>{{ $errors->first('experience_age') }}</strong>
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
						<a href="{{URL::to('/circular-post')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
						<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
					</div>
				   <!-- /.box-footer -->
				</div>
			</div>
		</form>
	</div>
</section>
<script type="text/javascript">
document.getElementById("circular_id").value="{{$circular_id}}";
$(document).ready(function() {
$('.form_date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<script>
	$(document).ready(function() {
		$("#MainGroupRecruitment").addClass('active');
		$("#Post_Name").addClass('active');
	});
</script>
@endsection