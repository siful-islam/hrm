@extends('admin.admin_master')
@section('title', 'Training')
@section('main_content')
<style>
.required {
    color: red;
    font-size: 14px;
}
</style>
<section class="content-header">
	<h1>Add-Training</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">Add-Training</li>
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
		<form class="form-horizontal" action="{{URL::to($action)}}" method="{{$method}}" enctype="multipart/form-data">
			{{ csrf_field() }}
			{!! $method_field !!}
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">						
							<label for="training_name" class="col-sm-2 control-label">Training Name <span class="required">*</span></label>
							<div class="col-sm-3">
								<input type="hidden" name="training_no" value="{{$max_tra_no}}" >
								<input type="text" class="form-control" name="training_name" value="{{$training_name}}" required>
							</div>
							<label for="institute_name" class="col-sm-2 control-label">Institute Name <span class="required">*</span></label>
							<div class="col-sm-3">
								<select class="form-control" id="institute_name" name="institute_name" required>						
									<option value="">-Select-</option>
									<option value="1" <?php if($institute_name=="1") echo 'selected'; ?> >CDIP</option>
									<option value="2" <?php if($institute_name=="2") echo 'selected'; ?> >PKSF</option>
								</select>
							</div>						
						</div>
						<div class="form-group">						
							<label for="tr_date_from" class="col-sm-2 control-label">Training Date From <span class="required">*</span></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="start_date" name="tr_date_from" value="{{$tr_date_from}}" required>
							</div>
							<label for="tr_date_to" class="col-sm-2 control-label">Training Date To <span class="required">*</span></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="form_date" name="tr_date_to" value="{{$tr_date_to}}" required>
							</div>						
						</div>						
						<div class="form-group">						
							<label for="tr_venue" class="col-sm-2 control-label">Training Venue <span class="required">*</span></label>
							<div class="col-sm-3">
								<select class="form-control" id="tr_venue" name="tr_venue" required>						
									<option value="">-Select-</option>
									<option value="1" <?php if($tr_venue=="1") echo 'selected'; ?> >HO</option>
									<option value="2" <?php if($tr_venue=="2") echo 'selected'; ?> >Branch</option>
									<option value="3" <?php if($tr_venue=="3") echo 'selected'; ?> >Other</option>
								</select>
							</div>
							<div style="display:none;" id="other">						
							<label for="tr_venue_other" class="col-sm-2 control-label">Training Venue (Other) <span class="required">*</span></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="tr_venue_other" name="tr_venue_other" value="{{$tr_venue_other}}" >
							</div>						
							</div>
						</div>
						<hr>
						<div class="col-md-10 col-md-offset-1 table-responsive">
							<table id="training" class="table table-bordered">
								<thead>
								  <tr>
									<th>Employee ID</th>
									<th>Name</th>
									<th>Branch</th>
									<th>Designation</th>
									<th>Result</th>
								  </tr>
								</thead>
								<?php $training_row = 0; $i=1; 
								$training_array = array(); foreach ($training_data as $training) {
								$training_array[] = $training->id;
								?>
								<tbody id="training-row<?php echo $training_row; ?>">
								  <tr>
									<td>
										<input type="hidden" name="training_no" value="{{$max_tra_no}}" >
										<input type="hidden" name="training_detail_id" value="{{$training->training_detail_id}}" >
										<input type="text" name="training[<?php echo $training_row; ?>][emp_id]" value="{{$training->emp_id}}" required class="form-control" onChange="get_employee_info(this.value,{{$training_row}});" size="8">
									</td>
									<td>
										<input type="text" value="{{$training->emp_name_eng}}" style="width:180px;" class="form-control" />
									</td>
									<td>
										<select style="width:180px;" name="training[<?php echo $training_row; ?>][br_code]" id="br_code<?php echo $training_row; ?>" required class="form-control">
											<option value="">Select</option>							
											<?php foreach ($all_branch as $branch) { ?>
												<?php if($branch->br_code==$training->br_code){ ?>
													<option value="<?php echo $branch->br_code; ?>" selected="selected"><?php echo $branch->branch_name; ?></option>
													<?php } else { ?>
													<option value="<?php echo $branch->br_code; ?>"><?php echo $branch->branch_name; ?></option>
													<?php } ?>
											<?php } ?>
										</select>
									</td>
									<td>
										<select style="width:180px;" name="training[<?php echo $training_row; ?>][designation_code]" id="designation_code<?php echo $training_row; ?>" required class="form-control">
											<option value="">Select</option>							
											<?php foreach ($all_designation as $designation) { ?>
												<?php if($designation->designation_code==$training->designation_code){ ?>
													<option value="<?php echo $designation->designation_code; ?>" selected="selected"><?php echo $designation->designation_name; ?></option>
													<?php } else { ?>
													<option value="<?php echo $designation->designation_code; ?>"><?php echo $designation->designation_name; ?></option>
													<?php } ?>
											<?php } ?>
										</select>
									</td>
									<input type="hidden" name="training[<?php echo $training_row; ?>][id]" value="{{$training->id}}" />
									<td>
										<select style="width:80px;" name="training[<?php echo $training_row; ?>][tr_result]" required class="form-control">
											<option value="">Select</option>
											<option value="1" <?php if($training->tr_result=="1") echo 'selected'; ?> >A+</option>
											<option value="2" <?php if($training->tr_result=="2") echo 'selected'; ?> >A</option>
											<option value="3" <?php if($training->tr_result=="3") echo 'selected'; ?> >A-</option>
											<option value="4" <?php if($training->tr_result=="4") echo 'selected'; ?> >B+</option>
											<option value="5" <?php if($training->tr_result=="5") echo 'selected'; ?> >B</option>
											<option value="6" <?php if($training->tr_result=="6") echo 'selected'; ?> >B-</option>
											<option value="7" <?php if($training->tr_result=="7") echo 'selected'; ?> >C</option>
											<option value="8" <?php if($training->tr_result=="8") echo 'selected'; ?> >D</option>
											<option value="9" <?php if($training->tr_result=="9") echo 'selected'; ?> >F</option>
											<option value="10" <?php if($training->tr_result=="10") echo 'selected'; ?> >N/A</option>
										</select>
									</td>
									<td><a onclick="$('#training-row<?php echo $training_row; ?>').remove();" class="btn btn-danger">Remove</a></td>
								  </tr>
								</tbody>
								<?php $training_row++; ?>
								<?php } ?>
								<tfoot>
									<tr>
										<td colspan="5"></td>
										<td class="left"><a onclick="addTraining();" class="btn btn-primary">Add More</a></td>
										<input type="hidden" name="val_id" value='<?php echo serialize($training_array); ?>' />
									</tr>
								</tfoot>
							</table>								
						</div>						
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="{{URL::to('/training')}}" class="btn bg-olive" >List</a>
						<button type="submit" id="submit" class="btn btn-primary">{{$button_text}}</button>
					</div>
				   <!-- /.box-footer -->
				</div>
			</div>
		</form>
	</div>
</section>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#start_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<script type="text/javascript">
$(document).ready(function(){
	var aa = $('#tr_venue').val();	
	if (aa == '3') {
		$("#other").show();
	} else {
		$("#other").hide();
		document.getElementById("tr_venue_other").value='';
	}
    $('#tr_venue').on('change', function() {
      if (this.value == '3') {
		$("#other").show();
      } else {
		$("#other").hide();
		document.getElementById("tr_venue_other").value='';
      }
    });
});
</script>
<script type="text/javascript">
var training_row = <?php echo $training_row; ?>;
function addTraining() {
	//alert (training_row);
	html  = '<tbody id="training-row' + training_row + '">';
	html += '  <tr>'; 
    html += '    <td><input type="text" name="training[' + training_row + '][emp_id]" value="" size="8" onChange="get_employee_info(this.value,'+training_row+');" required class="form-control" /></td>';
    html += '    <td><input type="text" id="emp_name'+training_row+'" style="width:180px;" class="form-control" /></td>';
	html += '    <td><select style="width:180px;" name="training[' + training_row + '][br_code]" id="br_code'+training_row+'" required class="form-control">';
	html += '    <option value="">Select</option>';
	<?php foreach ($all_branch as $branch) { ?>
    html += '      <option value="<?php echo $branch->br_code; ?>"><?php echo addslashes($branch->branch_name); ?></option>';
    <?php } ?>
    html += '    </select></td>';
	html += '    <td><select style="width:180px;" name="training[' + training_row + '][designation_code]" id="designation_code'+training_row+'" required class="form-control">';
    html += '    <option value="">Select</option>';
	<?php foreach ($all_designation as $designation) { ?>
    html += '      <option value="<?php echo $designation->designation_code; ?>"><?php echo addslashes($designation->designation_name); ?></option>';
    <?php } ?>
    html += '    </select></td>';
	html += '    <input type="hidden" name="training[' + training_row + '][id]" value="" />';
	html += '    <td><select style="width:80px;" name="training[' + training_row + '][tr_result]" required class="form-control">';
    html += '    <option value="">Select</option>';
    html += '    <option value="1">A+</option>';
    html += '    <option value="2">A</option>';
    html += '    <option value="3">A-</option>';
    html += '    <option value="4">B+</option>';
    html += '    <option value="5">B</option>';
    html += '    <option value="6">B-</option>';
    html += '    <option value="7">C</option>';
    html += '    <option value="8">D</option>';
    html += '    <option value="9">F</option>';
    html += '    <option value="10">N/A</option>';
    html += '    </select></td>';
	html += '    <td><a onclick="$(\'#training-row' + training_row + '\').remove();" class="btn btn-danger">Remove</a></td>';
	html += '  </tr>';	
    html += '</tbody>';
	
	$('#training tfoot').before(html);
	
	training_row++;
}

function get_employee_info(emp_id,row_id) {
	//alert (emp_id);
	//alert (row_id);	
	$.ajax({
		url : "{{ url::to('get-employee-info-training') }}"+"/"+ emp_id,
		type: "GET",
		dataType: "JSON",
		success: function(data)
		{
			if(data.error==1) {
				alert ('This ID is not available!');
			} else {
				document.getElementById("emp_name"+row_id).value=data.emp_name;
				document.getElementById("br_code"+row_id).value=data.br_code;
				document.getElementById("designation_code"+row_id).value=data.designation_code;
			}
			//alert (data.designation_code);		
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			//alert('Error: To Get Info');
		}
	});
}
</script>
<script>
	//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupEmployee").addClass('active');
		$("#Training").addClass('active');
	});
</script>
@endsection