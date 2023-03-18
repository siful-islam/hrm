@extends('admin.admin_master')
@section('main_content')
<style>
.content {
	padding-top: 5px;
}
.table-bordered {
    border: 1px solid #757070;
}
.table > thead > tr > th {
    border: 1px solid #757070;
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
	font-weight: bold;
	text-align: left; 
	padding: 2px;
}
.table > tbody > tr > td {
    border: 1px solid #757070;
	padding: 4px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
.modal-content {
    border-radius: 6px;
}
.modal-header {
    background: #00A8B3;
    color: #fff;
}
.form-control {
	border-radius: 3px;
}
.required {
    color: red;
    font-size: 14px;
}
</style>
<br/>
<br/>
<br/>
<?php $user_type = Session::get('user_type'); ?>
<section class="content">	
	<div class="row">
		<div class="col-md-12">
			<p style="float:left;margin-bottom:10px;background-color:#658907;color:#fff;font-size:16px;">Objective Setup</p>
		</div>
		<div class="col-md-12">
			<p style="float:left;margin-bottom: 2px;"><b><font size="3">B: Delivery of Core Responsibilities:</font></b></p>	
			<table class="table table-bordered" cellspacing="0">
				<tbody>
					<tr style="background-color:lightgray;">
						<td style="font-weight: bold;padding:9px;width:3%;text-align:center;">Sl. No.</td>
						<td style="font-weight: bold;width:30%;text-align:center;">Planned/Assigned Task</td>
						<td style="font-weight: bold;width:30%;text-align:center;">Actual Performed/Delivery Tasks</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Task Weight</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Weighted Score</td>
						<td style="font-weight: bold;width:17%;text-align:center;">Comments (justify if score is 1,4 & 5)</td>
						<?php if ($staff_status->submission_status != 3) { ?>
						<td style="font-weight: bold;width:8%;text-align:center;">Action</td>
						<?php } ?>
					</tr>
					<?php $total_score = 0; $i = 1; foreach ($all_result as $result) { $total_score += $result->task_weight;?>
					<tr>
						<td style="text-align:center;"><?php echo $i; ?></td>
						<td><?php echo $result->assigned_task; ?></td>
						<td><?php echo $result->performed_task; ?></td>
						<td style="text-align:center;"><?php echo $result->task_weight; ?></td>
						<td style="text-align:center;">-</td>
						<td style="text-align:center;">-</td>
						<td>-</td>
						<?php if ($staff_status->submission_status != 3) { ?>
						<td style="text-align:center;"><a class="btn btn-primary btn-sm" id="Edit" title="Edit" onclick="edit(<?php echo $result->id.','.$i; ?>)" >Update Achievement</a></td>
						<?php } ?>
					</tr>
					<?php $i++; } ?>
					<tr>
						<td colspan="3" style="font-size:14px;"><center><b>Total</b></center></td>
						<td style="text-align:center;font-size:14px;"><b><?php echo $total_score; ?></b></td>
						<td style="text-align:center;">-</td>
						<td style="text-align:center;"><b>-</b></td>
					</tr>	
					<tr>
						<td colspan="5"><center>Total Weight</center></td>
						<td style="text-align:center;">60%</td>
					</tr>	
					<tr>
						<td colspan="5"><center>Total Score</center></td>
						<td style="text-align:center;">-</td>
					</tr>					
				</tbody>
			</table>
		</div>
		<?php if ($staff_status->submission_status != 3) { ?>
		<div class="col-md-12">
			<p style="float:right;margin-bottom: 10px;"><a href="{{URL::to('/pms-submission-supervisor/'.$emp_id)}}" class="btn btn-success pull-right" onclick="return checkSubmit()" ><i class="glyphicon glyphicon-plus" ></i> Submit to Supervisor</a></p>
		</div>
		<?php } else { ?>
		<div class="col-md-12">
			<!--<p style="float:right;margin-bottom: 10px;"><button class="btn btn-primary pull-right ">Submitted</button></p>-->
			<p style="background-color:#757070;color:#fff;font-size:16px;padding:6px;" class="pull-right ">Submitted</p>
		</div>
		<?php } ?>
	</div>
	<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_form" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 10px;">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title" style="font-size: 20px;">B: Delivery of Core Responsibilities:</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
						<form method="post" action="{{URL::to('/pms-submission-save')}}" id="new_form" class="form-horizontal form-label-left">
						{{ csrf_field() }}
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Sl. No.</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="hidden" name="id" id="id" value="0" readonly class="form-control col-md-7 col-xs-12">
									<input type="text" name="sl_no" id="sl_no" value="<?php echo $i; ?>" readonly class="form-control col-md-7 col-xs-12">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Planned/Assigned Task<span class="required"> *</span></label>
								<div class="col-md-9 col-sm-6 col-xs-12">
									<textarea id="assigned_task" name="assigned_task" readonly rows="7" class="form-control col-md-7 col-xs-12"></textarea>
								</div>
							</div>							
							<div class="form-group" id="total_payment">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Task Weight<span class="required"> *</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name="task_weight" id="task_weight" readonly required autocomplete="off" class="form-control col-md-7 col-xs-12">
									<input type="hidden" id="old_task_weight" value="0" class="form-control col-md-7 col-xs-12">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Actual Performed / Delivery Tasks<span class="required"> *</span></label>
								<div class="col-md-9 col-sm-6 col-xs-12">
									<textarea id="performed_task" name="performed_task" required rows="7" class="form-control col-md-7 col-xs-12"></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
									<button type="submit" id="button" class="btn btn-primary">Save<?php //echo $button;?></button>
								</div>
							</div>
						</form>                       
                    </div>
                </div>
            </div>
        </div>
    </div>
	</div>
</section>
<script>
function edit(id,i) {
	$('#new_form')[0].reset(); // reset form on modals
	$.ajax({
	url: "{{URL::to('/edit-pms')}}"+ "/"+ id,
	type: 'GET',
	dataType: 'json',
	success: function(values)
		{                                                                    
			console.log(values);
			$('#id').val(values.id);
			$('#sl_no').val(i);
			$('#assigned_task').val(values.assigned_task);
			$('#task_weight').val(values.task_weight);
			$('#old_task_weight').val(values.task_weight);
			$('#performed_task').val(values.performed_task);
			$('#modal_form').modal('show');
		}
	})
}

$("#new_form").on("submit", function () {
    $(this).find(":submit").prop("disabled", true);
});
 
</script>
<script>
function checkDelete() {
	var chk=confirm("Are you sure you want to delete!");
	if(chk) {
		return true;
	} else {
		return false;				
	}
}
function checkSubmit() {
	var chk=confirm("You want to submit form to supervisor!");
	if(chk) {
		return true;
	} else {
		return false;				
	}
}			
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupPms").addClass('active');
		$("#own_pms").addClass('active');
	});
</script>
@endsection