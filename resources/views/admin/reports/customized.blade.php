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
				
				<form class="form-horizontal" action="{{URL::to($action)}}" method="{{$method}}">
                {{ csrf_field() }}
				{!!$method_control!!}
				
					<div class="box-body">
						<div class="form-group">
							<div class="col-sm-2">
								<select name="report_category" id="report_category" required class="form-control">
									<option value="" hidden>-Report Type-</option>
										<option value="1">Grade</option>
										<option value="2">Scale</option>
										<option value="3">Designation</option>
										<option value="4">Department</option>
										<option value="5">District</option>
								</select>
							</div>
							<div class="col-md-2">
							<select name="emp_sub_category" disabled="disabled" id="emp_sub_category" required class="form-control">
								<option value="All">-- All --</option>
							</select>
							</div>
							<label for="date_within" class="col-sm-1 control-label">Date Within</label>
							<div class="col-sm-2">							
								<input type="date" class="form-control" id="date_within" id="date_within" name="diposit_amount" value="<?php echo date('Y-m-d');?>" required>
							</div>
							
							<div class="col-sm-2">
								<button type="button" onclick="show_report();" class="btn btn-danger">Show Report</button>
								<button type="button" class="btn btn-default">Print</button>
							</div>
						</div>
					</div>
					<!-- /.box-body --->
				</form>
		</div>
		
		<?php //if(2==2) { ?>
		
		<div class="box box-danger">
			<div class="box-header with-border">			
				<center>
					<h3 class="box-title">Center for Development Innovation and Practices</h3>
					<p>CDIP Bhaban, House No#17, Road No#13, PC Culture Housing Society, Shekhertek, Adabor, Dhaka-1207</p>
					<h4>Staff List</h4>
				</center>
				
			</div>
			<div class="box-body" id="report_show">
			
			</div>

		</div>
		
		<?php //} ?>
		
	</section>
	
	
<script>
	$(document).on("change", "#report_category", function () {
		var report_category = $(this).val();   
		//alert(district_code);
		 
		$.ajax({
			url : "{{ url::to('select-report-category') }}"+"/"+report_category,
			type: "GET",
			success: function(data)
			{
				//alert(data);
				$("#emp_sub_category").attr("disabled", false);
				$("#emp_sub_category").html(data); 
				//$("#upazi_name").html(data); 				 
			}
		});  
	}); 
	
	function show_report()
	{
		var report_category = document.getElementById("report_category").value;   
		var emp_sub_category = document.getElementById("emp_sub_category").value;  
		var date_within = document.getElementById("date_within").value;  
		
		$.ajax({
			url : "{{ url::to('show-report-customized') }}"+"/"+report_category+"/"+emp_sub_category+"/"+date_within,
			type: "GET",
			success: function(data)
			{
				//alert(data);
				$("#report_show").html(data); 
						 
			}
		}); 
		
	}
</script>	
	



@endsection