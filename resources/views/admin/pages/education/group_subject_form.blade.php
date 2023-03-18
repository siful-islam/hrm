@extends('admin.admin_master')
@section('title', 'Add Group-Subject')
@section('main_content')
<section class="content-header">
  <h4>Group-Subject</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Home</a></li>
	<li class="active">Group-Subject</li>
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
		<div class="tab-content">
			<form action="{{URL::to($action)}}" method="post" class="form-horizontal" >
				{{ csrf_field() }}
				{!! $method_field !!}
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-body">							
							<div class="form-group{{ $errors->has('subject_name') ? ' has-error' : '' }}">
								<label for="subject_name" class="col-sm-4 control-label">Subject Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="subject_name" id="subject_name" value="{{$subject_name}}" required autofocus class="form-control">
									@if ($errors->has('subject_name'))
									<span class="help-block">
										<strong>{{ $errors->first('subject_name') }}</strong>
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
							<a href="{{URL::to('/group-subject')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
			</form>			
		</div>
	</div>
</section>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$('#Group_Subject').addClass('active');
			});
	</script>
@endsection