@extends('admin.admin_master')
@section('title', 'Add Thana')
@section('main_content')
<section class="content-header">
  <h4>add-thana</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Home</a></li>
	<li class="active">add-thana</li>
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
							<div class="form-group{{ $errors->has('district_name') ? ' has-error' : '' }}">
								<label for="district_name" class="col-sm-4 control-label">District Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<select name="district_code" id="district_code" required class="form-control">
										<option value="">Select</option>								
										@foreach($all_district as $district)
										<option value="{{$district->district_code}}">{{$district->district_name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group{{ $errors->has('thana_name') ? ' has-error' : '' }}">
								<label for="thana_name" class="col-sm-4 control-label">Thana Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="thana_name" id="thana_name" value="{{$thana_name}}" required autofocus class="form-control">
									@if ($errors->has('thana_name'))
									<span class="help-block">
										<strong>{{ $errors->first('thana_name') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('thana_bangla') ? ' has-error' : '' }}">
								<label for="thana_bangla" class="col-sm-4 control-label">Thana Name (Bangla)</label>
								<div class="col-sm-6">
									<input type="text" name="thana_bangla" id="thana_bangla" value="{{$thana_bangla}}" class="form-control">
									@if ($errors->has('thana_bangla'))
									<span class="help-block">
										<strong>{{ $errors->first('thana_bangla') }}</strong>
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
							<a href="{{URL::to('/thana')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
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
	document.getElementById("district_code").value="{{$district_code}}";
</script>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$("#Thana").addClass('active');
			});
	</script>

@endsection