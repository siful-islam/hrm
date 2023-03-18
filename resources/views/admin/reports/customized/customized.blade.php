@extends('admin.admin_master')
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
				
				<form class="form-horizontal" action="" method="{{$method}}">
                {{ csrf_field() }}
				{!!$method_control!!}
				
					<div class="box-body">
						<div class="form-group">
							<div class="col-sm-2">
								<select name="emp_district" id="emp_district" class="form-control" required>							
									<option value="" hidden>-Select Category-</option>
									<option value="1">Grade</option>
									<option value="2">Scale</option>
								</select>
							</div>
							<div class="col-sm-2">
								<select name="upazila_id" id="upazila_id" class="form-control" readonly required>							
									<option value="">-SELECT-</option>
								</select>
							</div>
							<label for="date_within" class="col-sm-1 control-label">Date Within</label>
							<div class="col-sm-2">							
								<input type="date" class="form-control" id="date_within" name="diposit_amount" value="<?php echo date('Y-m-d');?>" required>
							</div>
							
							<div class="col-sm-2">
								<button type="button" class="btn btn-danger">Show Report</button>
							</div>
						</div>
					</div>
					<!-- /.box-body --->
				</form>

		</div>
	</section>
	
	
<script>
	$(document).on("change", "#emp_district", function () {
		var district_code = $(this).val();   
		//alert(district_code);
		 
		$.ajax({
			url : "{{ url::to('select-thana') }}"+"/"+district_code,
			type: "GET",
			success: function(data)
			{
				//alert(data);
				//$("#upazila_id").attr("disabled", false);
				$("#upazila_id").html(data); 
				//$("#upazi_name").html(data); 
				 
			}
		});  
	}); 
</script>	
	



@endsection