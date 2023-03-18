@extends('admin.admin_master')
@section('main_content')
<style>
.required {
    color: red;
    font-size: 14px;
}
h2 {
	margin-top: 6px;
}
</style>
<section class="content-header">
	<h1>add-extra-deduction</h1>
</section>
<section class="content">	
	<div class="row">			
		<div class="col-md-12">
			@if(Session::has('message1'))
			<h2 style="color:red">{{session('message1')}}</h2>
			@endif
			<form class="form-horizontal" action="{{URL::to($action)}}" method="POST" >
			{{ csrf_field() }}
			<div class="box box-info">
				<div class="box-body">							
					<div class="form-group">
						<label for="fp_emp_id" class="col-sm-2 control-label">Employee ID <span class="required">*</span></label>
						<div class="col-sm-2">
							<input type="number" class="form-control" id="fp_emp_id" name="fp_emp_id" value="{{$fp_emp_id}}" onChange="get_employee_info()" required autofocus>
							<input type="hidden" class="form-control" name="id_no" value="{{$id_no}}" >
							<input type="hidden" class="form-control" name="value_id" value="{{$value_id}}" >
						</div>
						<label for="entry_date" class="col-sm-2 control-label">Entry Date <span class="required">*</span></label>
						<div class="col-sm-2">
							<input type="text" class="form-control entry_date" name="entry_date" value="{{$entry_date}}" required>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label for="emp_name" class="col-sm-2 control-label">Employee Name <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="emp_name" value="{{$emp_name}}" required>							
						</div>
					</div>
					<div class="form-group">
						<label for="file_type" class="col-sm-2 control-label">Select File Type <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="file_type" name="file_type" required>						
								<option value="">-Select-</option>
								<option value="1" <?php if($file_type==1) echo 'selected'; ?> >Legal Notice</option>
								<option value="2" <?php if($file_type==2) echo 'selected'; ?> >Final Payment</option>
								<option value="3" <?php if($file_type==3) echo 'selected'; ?> >Final Payment Info</option>
								<option value="4" <?php if($file_type==4) echo 'selected'; ?> >Departmental Notice</option>
								<option value="5" <?php if($file_type==5) echo 'selected'; ?> >Final Payment Close</option>
								<option value="6" <?php if($file_type==6) echo 'selected'; ?> >Final Payment Settlement</option>
								<option value="7" <?php if($file_type==7) echo 'selected'; ?> >Litigation / Mgt. Decision</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="receiver_emp_id" class="col-sm-2 control-label">Receiver Emp ID <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="receiver_emp_id" name="receiver_emp_id" value="" required>							
						</div>
					</div>						
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<a href="{{URL::to('/fp_file_info')}}" class="btn bg-olive" >List</a>
					<button type="submit" id="submit" class="btn btn-primary" >Save</button>
				</div>
			   <!-- /.box-footer -->
			</div>
			</form>
		</div>					
	</div>
</section>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.entry_date').datepicker({dateFormat: 'yy-mm-dd'});
	
});
//--></script>
<script type="text/javascript">		
	function get_employee_info() {
		var fp_emp_id = document.getElementById("fp_emp_id").value;	
		$.ajax({
			url : "{{ url::to('get_emp_name') }}"+"/"+ fp_emp_id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				if(data.error==1) {
					alert ('This ID is not available!');
					document.getElementById("emp_name").value='';
				} else {
					document.getElementById("emp_name").value=data.emp_name;
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
@endsection