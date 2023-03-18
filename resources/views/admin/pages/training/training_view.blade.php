@extends('admin.admin_master')
@section('title', 'Training')
@section('main_content')
<section class="content-header">
	<h1>View-Training</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">View-Training</li>
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
		<form class="form-horizontal" enctype="multipart/form-data">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">						
							<label for="training_name" class="col-sm-2 control-label">Training Name</label><span class="required">*</span>
							<div class="col-sm-3">
								<input type="hidden" name="training_no" value="{{$max_tra_no}}" >
								<input type="text" class="form-control" name="training_name" value="{{$training_name}}" required>
							</div>
							<label for="institute_name" class="col-sm-2 control-label">Institute Name</label><span class="required">*</span>
							<div class="col-sm-3">
								<select class="form-control" id="institute_name" name="institute_name" required>						
									<option value="">-Select-</option>
									<option value="1" <?php if($institute_name=="1") echo 'selected'; ?> >CDIP</option>
									<option value="2" <?php if($institute_name=="2") echo 'selected'; ?> >PKSF</option>
								</select>
							</div>						
						</div>
						<div class="form-group">						
							<label for="tr_date_from" class="col-sm-2 control-label">Training Date From</label><span class="required">*</span>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="start_date" name="tr_date_from" value="{{$tr_date_from}}" required>
							</div>
							<label for="tr_date_to" class="col-sm-2 control-label">Training Date To</label><span class="required">*</span>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="form_date" name="tr_date_to" value="{{$tr_date_to}}" required>
							</div>						
						</div>						
						<div class="form-group">						
							<label for="tr_venue" class="col-sm-2 control-label">Training Venue</label><span class="required">*</span>
							<div class="col-sm-3">
								<select class="form-control" id="tr_venue" name="tr_venue" required>						
									<option value="">-Select-</option>
									<option value="1" <?php if($tr_venue=="1") echo 'selected'; ?> >HO</option>
									<option value="2" <?php if($tr_venue=="2") echo 'selected'; ?> >Branch</option>
									<option value="3" <?php if($tr_venue=="3") echo 'selected'; ?> >Other</option>
								</select>
							</div>
							<div style="display:none;" id="other">						
							<label for="tr_venue_other" class="col-sm-2 control-label">Training Venue (Other)</label><span class="required">*</span>
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
										<input type="text" value="{{$training->emp_id}}" class="form-control" size="8" />
									</td>
									<td>
										<input type="text" value="{{$training->emp_name_eng}}" class="form-control" />
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
									<td>
										<select style="width:180px;" name="training[<?php echo $training_row; ?>][tr_result]" required class="form-control">
											<option value="">Select</option>
											<option value="1" <?php if($training->tr_result=="1") echo 'selected="selected"'; ?> >A+</option>
											<option value="2" <?php if($training->tr_result=="2") echo 'selected="selected"'; ?> >A</option>
											<option value="3" <?php if($training->tr_result=="3") echo 'selected="selected"'; ?> >A-</option>
											<option value="4" <?php if($training->tr_result=="4") echo 'selected="selected"'; ?> >B+</option>
											<option value="5" <?php if($training->tr_result=="5") echo 'selected="selected"'; ?> >B</option>
											<option value="6" <?php if($training->tr_result=="6") echo 'selected="selected"'; ?> >B-</option>
											<option value="7" <?php if($training->tr_result=="7") echo 'selected="selected"'; ?> >C</option>
											<option value="8" <?php if($training->tr_result=="8") echo 'selected="selected"'; ?> >D</option>
											<option value="9" <?php if($training->tr_result=="9") echo 'selected="selected"'; ?> >F</option>
											<option value="10" <?php if($training->tr_result=="10") echo 'selected="selected"'; ?> >N/A</option>
										</select>
									</td>
								  </tr>
								</tbody>
								<?php } ?>
							</table>								
						</div>						
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="{{URL::to('/training')}}" class="btn bg-olive" ><i class="fa fa-fw fa-long-arrow-left" ></i> Back-to-List</a>
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
<script>
	//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupEmployee").addClass('active');
		$("#Training").addClass('active');
	});
</script>
@endsection