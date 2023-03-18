@extends('admin.admin_master')
@section('main_content')
<style>
.required {
    color: red;
    font-size: 14px;
}
.col-sm-2, .col-sm-1 {
	padding-left: 6px;
}
</style>
<section class="content-header">
	<h1>add-extra-deduction</h1>
</section>
<section class="content">	
	<div class="row">			
		<!-- form start -->
		<!--<h3 style="color:green">
			@if(Session::has('message'))
			{{session('message')}}
			@endif
		</h3>-->
		<div class="col-md-12">
			<form class="form-horizontal" action="{{URL::to($action)}}" method="{{$method}}" enctype="multipart/form-data">
			{{ csrf_field() }}
			{!! $method_field !!}
			<div class="box box-info">
				<div class="box-body">							
					<div class="form-group">
						<label for="entry_date" class="col-sm-2 control-label">Employee Type <span class="required">*</span></label>
						<div class="col-sm-2">
							<select name="emp_type" id="emp_type" onChange="get_employee_info();" required class="form-control">
								<option value="1" <?php if($emp_type==1) echo 'selected'; ?> >Regular</option>
								<option value="2" <?php if($emp_type==2) echo 'selected'; ?> >OT</option>
								<option value="3" <?php if($emp_type==3) echo 'selected'; ?> >CH</option>
								<option value="4" <?php if($emp_type==4) echo 'selected'; ?> >SHS</option>
							</select>
						</div>
						<label for="emp_id" class="col-sm-2 control-label">Employee ID <span class="required">*</span></label>
						<div class="col-sm-2 {{ $errors->has('emp_id') ? ' has-error' : '' }}">
							<input type="number" class="form-control" id="emp_id" name="emp_id" value="{{$emp_id}}" onChange="get_employee_info();" required>
							@if ($errors->has('emp_id'))
								<span class="help-block">
									<strong>{{ $errors->first('emp_id') }}</strong>
								</span>
							@endif
						</div>
						<label for="entry_date" class="col-sm-2 control-label">Entry Date <span class="required">*</span></label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="entry_date" name="entry_date" value="{{$entry_date}}" required>
						</div>
						<!--<button type="submit" class="btn btn-primary" >Search</button>-->
					</div>
					<hr>
					<div class="form-group">
						<label for="emp_name" class="col-sm-2 control-label">Employee Name <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="emp_name" value="{{$emp_name}}" required>							
							<input type="hidden" class="form-control" name="nonid_emp_id" id="nonid_emp_id" value="{{$nonid_emp_id}}" required>							
						</div>
						<label for="designation_code" class="col-sm-2 control-label">Designation <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="designation_code" name="designation_code" required>						
								<option value="" >-Select-</option>
								@foreach ($all_designation as $designation)
								<option value="{{$designation->designation_code}}">{{$designation->designation_name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="type_id" class="col-sm-2 control-label">Select Type <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="type_id" name="type_id" required>						
								<option value="1">Unsettled Staff Advance</option>
							</select>
						</div>
						<label for="br_code" class="col-sm-2 control-label">Branch <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="br_code" name="br_code" >						
								<option value="" >-Select-</option>
								@foreach ($all_branch as $branch)
								<option value="{{$branch->br_code}}">{{$branch->branch_name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="total_amount" class="col-sm-2 control-label">Total Amount <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="total_amount" name="total_amount" value="{{$total_amount}}" required>
							<input type="checkbox" id="is_payroll" name="is_payroll" value="1"> Payroll Effect
						</div>
						<label for="comments" class="col-sm-2 control-label">Comments <span class="required">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="comments" name="comments" value="{{$comments}}" required>
						</div>
					</div>
					<div class="form-group" id="installment" style="display:none;">		
						<label for="month_year" class="col-sm-2 control-label">Installment Amount <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" name="monthly_pay" class="form-control" id="monthly_pay" value="" >
						</div>						
					</div>						
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<a href="{{URL::to('/unsettle-staff-adv')}}" class="btn bg-olive" >List</a>
					<button type="submit" id="submit" class="btn btn-primary" >{{$button_text}}</button>
				</div>
			   <!-- /.box-footer -->
			</div>
			</form>
		</div>					
	</div>
</section>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.month_year').datepicker({dateFormat: 'yy-mm'});
	$('#entry_date').datepicker({dateFormat: 'yy-mm-dd'});
	
	document.getElementById("designation_code").value="{{$designation_code}}";
	document.getElementById("br_code").value="{{$br_code}}";
	document.getElementById("type_id").value="{{$type_id}}";
	
});
</script>
<script>
$("#is_payroll").click(function() {
    if($(this).is(":checked")) {
		$("#installment").show();
		$('#monthly_pay').attr('required', 'required');
    } else {
		$("#installment").hide();
		$('#monthly_pay').removeAttr("required");
		document.getElementById("monthly_pay").value='';
    }
	//this.checked?$('#installment').show():$('#installment').hide();
});
</script>
<script type="text/javascript">		
	function get_employee_info() {
		var emp_id = $("#emp_id").val();	
		var emp_type = $("#emp_type").val();	
		//alert (emp_id);
		$.ajax({
			url : "{{ url::to('get-emp-info') }}"+"/"+ emp_id +"/"+ emp_type,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				if(data.error==1) {
					alert ('This ID is not available!');
				} else {
					document.getElementById("nonid_emp_id").value=data.emp_id;
					document.getElementById("emp_name").value=data.emp_name;
					document.getElementById("br_code").value=data.br_code;
					document.getElementById("designation_code").value=data.designation_code;
				}
				//alert (data.br_code);		
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				//alert('Error: To Get Info');
			}
		});
	}	
</script>
<script type="text/javascript">
function dateRange() {
  //alert (1);
  var startDate = $("#month_year").val();
  var endDate = $("#to_month").val();
  var start      = startDate.split('-');
  var end        = endDate.split('-');
  var startYear  = parseInt(start[0]);
  var endYear    = parseInt(end[0]);
  var dates      = [];
//alert (endYear)
  for(var i = startYear; i <= endYear; i++) {
   
    var endMonth = i != endYear ? 11 : parseInt(end[1]) - 1;
    var startMon = i === startYear ? parseInt(start[1])-1 : 0;
    //alert (startMon);
	for(var j = startMon; j <= endMonth; j = j > 12 ? j % 12 || 11 : j+1) {
      var month = j+1;
      var displayMonth = month < 10 ? '0'+month : month;
      dates.push([i, displayMonth, '01'].join('-'));
    }
  }
  //return dates;
  document.getElementById("search_dates").value=dates;
}
</script>
@endsection