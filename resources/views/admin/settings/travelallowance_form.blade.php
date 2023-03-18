@extends('admin.admin_master')
@section('title', 'Add Travel Allowance')
@section('main_content')

<link rel="stylesheet" href="{{asset('public/css/select2.min.css')}}"> 
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
				
				<input type="hidden" id="id" name="id" value="{{$id}}" >
				
				<div class="box-body">
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Source</label>
						<div class="col-sm-4">
							<select  name="source_br_code" id="source_br_code" autofocus required class="form-control mobile_branch_list"> 
								<option value="">--Select--</option>
								@foreach($branch_list as $branch)
									<option value="{{$branch->br_code}}">{{$branch->branch_name}}</option> 
								@endforeach
							</select> 
						</div>
					</div>
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Destination</label>
						<div class="col-sm-4">
							<select  name="dest_br_code" id="dest_br_code" required class="form-control mobile_branch_list"> 
								<option value="">--Select--</option>
								@foreach($branch_list as $branch)
									<option value="{{$branch->br_code}}">{{$branch->branch_name}}</option> 
								@endforeach
							</select> 
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">Amount</label>
						<div class="col-sm-4">
							<input type="text" name="travel_amt" id="travel_amt" class="form-control" value="{{$travel_amt}}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">From</label>
						<div class="col-sm-4">
							<input type="text" name="from_date"  id="from_date"  class="form-control common_date" value="{{$from_date}}" required >
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">To</label>
						<div class="col-sm-4">
							<input type="text" name="to_date"  id="to_date"  class="form-control common_date" value="{{$to_date}}" required >
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-4">
							<select name="status" id="status" class="form-control" required>							
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
						</div>
					</div>
					
				</div>
				<!-- /.box-body -->
				<div class="box-footer"> 
					<button type="submit" class="btn btn-info">{{$button_text}}</button>
				</div>
				<!-- /.box-footer -->
			</form>

		</div>
	</section>
<script src="{{asset('public/js/select2.min.js')}}"></script>		
	<script>
	  
	 $(document).ready(function() {
		  document.getElementById('source_br_code').click();
			$('.mobile_branch_list').select2( 
			{placeholder: "Select Branch",
			allowClear: true}
		  );
		});
		document.getElementById("status").value = '{{$status}}'; 
		document.getElementById("source_br_code").value = '{{$source_br_code}}'; 
		document.getElementById("dest_br_code").value = '{{$dest_br_code}}'; 
	$(document).ready(function() {
			$('.common_date').datepicker({dateFormat: 'yy-mm-dd'}); 
		}); 
			
	</script>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$('#Travel_allowance').addClass('active');
			});
	</script>

@endsection