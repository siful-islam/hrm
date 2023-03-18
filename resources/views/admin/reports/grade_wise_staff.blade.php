@extends('admin.admin_master')
@section('main_content')


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
								<select name="grade" id="grade" required class="form-control">
										<option value="All">All Grade</option>
										<?php foreach($grades as $grade) { ?>
										<option value="<?php echo $grade->id; ?>"><?php echo $grade->grade_name; ?></option>
										<?php } ?>
								</select>
							</div>
							<label for="date_within" class="col-sm-1 control-label">Date Within</label>
							<div class="col-sm-2">							
								<input type="date" class="form-control" id="date_within" id="date_within" name="diposit_amount" value="<?php echo date('Y-m-d');?>" required>
							</div>
							
							<div class="col-sm-2">
								<button type="button" onclick="show_report();" class="btn btn-danger"><i class="fa fa-eye" aria-hidden="true"></i> Show Report</button>
								<button type="button" onclick="javascript:printDiv('printme')" class="btn btn-default"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
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
					<h4>Grade wise Staff List</h4>
				</center>
				
			</div>
			<div class="box-body" id="report_show">
			
			</div>

		</div>
		
		<?php //} ?>
		
	</section>
	
	
<script>
	function show_report()
	{
		var grade 		= document.getElementById("grade").value;   
		var date_within = document.getElementById("date_within").value;  
		
		
		//alert(date_within);
		
		$.ajax({
			url : "{{ url::to('show-grade-report') }}"+"/"+grade+"/"+date_within,
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