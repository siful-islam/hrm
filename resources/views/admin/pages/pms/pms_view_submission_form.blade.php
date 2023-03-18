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
			<p style="float:left;margin-bottom: 2px;"><b><font size="3">A: Basic Information</font></b></p>	
			<table class="table table-bordered" cellspacing="0">
				<tbody>					
					<tr>
						<td style="width:20%;">Employee's Name</td>
						<td style="width:25%;"><?php echo $employee_info->emp_name_eng; ?></td>
						<td style="width:30%;">Date of Joining</td>
						<td style="width:25%;"><?php echo date("d-m-Y", strtotime($employee_info->org_join_date)); ?></td>
					</tr>					
					<tr>
						<td>Designation</td>
						<td><?php echo $employee_info->designation_name; ?></td>
						<td>Date of joining in present position (internal) / Date of joining after Study Leave</td>
						<td><?php //echo date("d-m-Y", strtotime($employee_info->br_join_date)); ?></td>
					</tr>					
					<tr>
						<td>Grade</td>
						<td><?php echo $employee_info->grade_name; ?></td>
						<td>Appraisal period started on</td>
						<td>01-07-2020</td>
					</tr>					
					<tr>
						<td>Step</td>
						<td><?php echo $employee_info->grade_step-1; ?></td>
						<td>Appraisal period ended on</td>
						<td>30-06-2021</td>
					</tr>					
					<tr>
						<td>Department</td>
						<td><?php echo $emp_mapping->department_name; ?></td>
						
					</tr>					
					<tr>
						<td>Unit</td>
						<td><?php echo $emp_mapping->unit_name; ?></td>
						
					</tr>					
					<tr>
						<td>Place of Posting</td>
						<td><?php echo $employee_info->branch_name; ?></td>
					</tr>			
				</tbody>
			</table>
		</div>		
	</div>
	<form method="post" action="{{URL::to('/pms-final-save')}}" id="new_form" class="form-horizontal form-label-left">
	{{ csrf_field() }}
	<div class="row">
		<div class="col-md-12">
			<p style="float:left;margin-bottom: 2px;"><b><font size="3">B: Delivery of Core Responsibilities: (Weight 60)</font></b></p>	
			<table class="table table-bordered" cellspacing="0">
				<tbody>
					<tr style="background-color:lightgray;">
						<td style="font-weight: bold;padding:9px;width:3%;text-align:center;">Sl. No.</td>
						<td style="font-weight: bold;width:30%;text-align:center;">Planned/Assigned Task</td>
						<td style="font-weight: bold;width:30%;text-align:center;">Actual Performed/Delivery Tasks</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Task Weight</td>
						<td style="font-weight: bold;width:6%;text-align:center;">Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Weighted Score</td>
						<td style="font-weight: bold;width:15%;text-align:center;">Comments (justify if score is 1,4 & 5)</td>
					</tr>
					<?php $i=1; $total_score = 0; foreach ($all_result as $result) { $total_score += $result->task_weight;?>
					<tr>
						<td style="text-align:center;"><?php echo $result->sl_no; ?></td>
						<td><?php echo $result->assigned_task; ?></td>
						<td><?php echo $result->performed_task; ?></td>
						<td id="task_weight<?php echo $i;?>" style="text-align:center;"><?php echo $result->task_weight; ?></td>
						<td style="text-align:center;">
							<select class="form-control" id="ratingid<?php echo $i; ?>" name="result_item[<?php echo $result->id; ?>][score]" onchange="getid(<?php echo $i;?>)" required >						
								<option value="" >-Select-</option>
								@foreach ($all_pms_rating as $pms_rating)
								<option value="{{$pms_rating->id}}">{{$pms_rating->number}}</option>
								@endforeach
							</select>
						</td>
						<td style="text-align:center;">
						<input type="hidden" name="result_item[<?php echo $result->id; ?>][id]" value="<?php echo $result->id; ?>" class="form-control" >
						<input type="text" name="result_item[<?php echo $result->id; ?>][weight_score]" id="score<?php echo $i;?>" value="" readonly class="form-control" >
						</td>
						<td class="input_select<?php echo $i; ?>"><input type="text" name="result_item[<?php echo $result->id; ?>][comments]" id="comment<?php echo $i; ?>" class="form-control" ></td>
					</tr>
					<?php $i++; } ?>
					<input type="hidden" id="total_row" value="<?php echo $i; ?>" class="form-control" >
					<tr>
						<td colspan="3" style="font-size:14px;"><center><b>Total</b></center></td>
						<td style="text-align:center;font-size:14px;"><b><?php echo $total_score; ?></b></td>
						<td style="text-align:center;">-</td>
						<td id="total_weight_score" style="text-align:center;"><b>-</b></td>
					</tr>	
					<tr>
						<td colspan="5"><center>Total Weight</center></td>
						<td style="text-align:center;">60%</td>
					</tr>	
					<tr>
						<td colspan="5"><center>Total Score</center></td>
						<td id="total_score" style="text-align:center;">-</td>
					</tr>					
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-10">
			<p style="float:left;margin-bottom: 2px;width:100%;"><b><font size="3">C: Professional, Interpersonal, Leadership and General Conduct: (Weight 40)</font></b></p>	
			<p style="float:left;margin-bottom: 2px;margin-left: 50px;"><b><font size="2">C.1: Professional Conduct: (10)</font></b></p>	
			<table style="margin-left: 80px;" class="table table-bordered">
				<tbody>
					<tr style="background-color:lightgray;">
						<td style="font-weight: bold;padding:9px;width:3%;text-align:center;">Sl. No.</td>
						<td style="font-weight: bold;width:10%;text-align:center;">Detail</td>
						<td style="font-weight: bold;width:30%;text-align:center;">Comments</td>
						<td style="font-weight: bold;width:6%;text-align:center;">Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Weighted Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Rating</td>
					</tr>
					<input type="hidden" name="emp_id" value="<?php echo $emp_id;?>">
					<?php $j=1; foreach ($all_pms_config as $pms_config) { if($pms_config->c_no == 1) { ?>
					<tr>
						<td style="text-align:center;"><?php echo $j; ?></td>
						<td><?php echo $pms_config->c_detail; ?><input type="hidden" name="professional[<?php echo $pms_config->id; ?>][id]" value="<?php echo $pms_config->id; ?>" id="id" class="form-control" ></td>
						<td><input type="text" name="professional[<?php echo $pms_config->id; ?>][comments]" id="comments" class="form-control" ></td>
						<td style="text-align:center;">
							<select class="form-control" id="scoreid<?php echo $j; ?>" name="professional[<?php echo $pms_config->id; ?>][score]" onchange="getconeid(<?php echo $j;?>)" >						
								<option value="" >-Select-</option>
								@foreach ($all_pms_rating as $pms_rating)
								<option value="{{$pms_rating->id}}">{{$pms_rating->number}}</option>
								@endforeach
							</select></td>
						<td style="text-align:center;"><input type="text" name="professional[<?php echo $pms_config->id; ?>][weight_score]" id="single_weight_score<?php echo $j; ?>" readonly class="form-control" ></td>
						<td style="text-align:center;"><input type="text" name="professional[<?php echo $pms_config->id; ?>][rating]" id="single_rating<?php echo $j; ?>" readonly class="form-control" ></td>
					</tr>
					<?php $j++; } } ?>
					<input type="hidden" id="totalrow" value="<?php echo $j-1; ?>" class="form-control" >
					<tr>
						<td colspan="4" style="text-align:center;"><b>Total</b></td>
						<td id="total_weightscore" style="text-align:center;"></td>
						<td id="total_rating" style="text-align:center;"></td>
					</tr>
				</tbody>
			</table>
			<p style="float:left;margin-bottom: 2px;margin-left: 50px;"><b><font size="2">C.2: Interpersonal Skills: (10)</font></b></p>	
			<table style="margin-left: 80px;" class="table" cellspacing="0">
				<tbody>
					<tr style="background-color:lightgray;">
						<td style="font-weight: bold;padding:9px;width:3%;text-align:center;">Sl. No.</td>
						<td style="font-weight: bold;width:10%;text-align:center;">Detail</td>
						<td style="font-weight: bold;width:30%;text-align:center;">Comments</td>
						<td style="font-weight: bold;width:6%;text-align:center;">Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Weighted Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Rating</td>
					</tr>
					<?php $k=1; foreach ($all_pms_config as $pms_config) { if($pms_config->c_no == 2) { ?>
					<tr>
						<td style="text-align:center;"><?php echo $k; ?></td>
						<td><?php echo $pms_config->c_detail; ?><input type="hidden" name="interpersonal[<?php echo $pms_config->id; ?>][id]" value="<?php echo $pms_config->id; ?>" id="id" class="form-control" ></td>
						<td><input type="text" name="interpersonal[<?php echo $pms_config->id; ?>][comments]" id="comments" class="form-control" ></td>
						<td style="text-align:center;">
							<select class="form-control" id="cscoreid<?php echo $k; ?>" name="interpersonal[<?php echo $pms_config->id; ?>][score]" onchange="getctwoid(<?php echo $k;?>)" >						
								<option value="" >-Select-</option>
								@foreach ($all_pms_rating as $pms_rating)
								<option value="{{$pms_rating->id}}">{{$pms_rating->number}}</option>
								@endforeach
							</select></td>
						<td style="text-align:center;"><input type="text" name="interpersonal[<?php echo $pms_config->id; ?>][weight_score]" id="singleweightscore<?php echo $k; ?>" readonly class="form-control" ></td>
						<td style="text-align:center;"><input type="text" name="interpersonal[<?php echo $pms_config->id; ?>][rating]" id="singlerating<?php echo $k; ?>" readonly class="form-control" ></td>
					</tr>
					<?php $k++; } } ?>
					<input type="hidden" id="totalrow1" value="<?php echo $k-1; ?>" class="form-control" >
					<tr>
						<td colspan="4" style="text-align:center;"><b>Total</b></td>
						<td id="totalweightscore" style="text-align:center;"></td>
						<td id="totalrating" style="text-align:center;"></td>
					</tr>
				</tbody>
			</table>
			<p style="float:left;margin-bottom: 2px;margin-left: 50px;"><b><font size="2">C.3: Leadership Skills: (10)</font></b></p>	
			<table style="margin-left: 80px;" class="table" cellspacing="0">
				<tbody>
					<tr style="background-color:lightgray;">
						<td style="font-weight: bold;padding:9px;width:3%;text-align:center;">Sl. No.</td>
						<td style="font-weight: bold;width:10%;text-align:center;">Detail</td>
						<td style="font-weight: bold;width:30%;text-align:center;">Comments</td>
						<td style="font-weight: bold;width:6%;text-align:center;">Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Weighted Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Rating</td>
					</tr>
					<?php $i=1; foreach ($all_pms_config as $pms_config) { if($pms_config->c_no == 3) { ?>
					<tr>
						<td style="text-align:center;"><?php echo $i; ?></td>
						<td><?php echo $pms_config->c_detail; ?><input type="hidden" name="leadership[<?php echo $pms_config->id; ?>][id]" value="<?php echo $pms_config->id; ?>" id="id" class="form-control" ></td>
						<td><input type="text" name="leadership[<?php echo $pms_config->id; ?>][comments]" id="comments" class="form-control" ></td>
						<td style="text-align:center;">
							<select class="form-control" id="cs_coreid<?php echo $i; ?>" name="leadership[<?php echo $pms_config->id; ?>][score]" onchange="getcthreeid(<?php echo $i;?>)" >						
								<option value="" >-Select-</option>
								@foreach ($all_pms_rating as $pms_rating)
								<option value="{{$pms_rating->id}}">{{$pms_rating->number}}</option>
								@endforeach
							</select></td>
						<td style="text-align:center;"><input type="text" name="leadership[<?php echo $pms_config->id; ?>][weight_score]" id="singleweight_score<?php echo $i; ?>" readonly class="form-control" ></td>
						<td style="text-align:center;"><input type="text" name="leadership[<?php echo $pms_config->id; ?>][rating]" id="singlera_ting<?php echo $i; ?>" readonly class="form-control" ></td>
					</tr>
					<?php $i++; } } ?>
					<input type="hidden" id="totalrow2" value="<?php echo $i-1; ?>" class="form-control" >
					<tr>
						<td colspan="4" style="text-align:center;"><b>Total</b></td>
						<td id="totalweight_score" style="text-align:center;"></td>
						<td id="totalra_ting" style="text-align:center;"></td>
					</tr>
				</tbody>
			</table>
			<p style="float:left;margin-bottom: 2px;margin-left: 50px;"><b><font size="2">C.4: General Conduct: (10)</font></b></p>	
			<table style="margin-left: 80px;" class="table" cellspacing="0">
				<tbody>
					<tr style="background-color:lightgray;">
						<td style="font-weight: bold;padding:9px;width:3%;text-align:center;">Sl. No.</td>
						<td style="font-weight: bold;width:10%;text-align:center;">Detail</td>
						<td style="font-weight: bold;width:30%;text-align:center;">Comments</td>
						<td style="font-weight: bold;width:6%;text-align:center;">Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Weighted Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Rating</td>
					</tr>
					<?php $i=1; foreach ($all_pms_config as $pms_config) { if($pms_config->c_no == 4) { ?>
					<tr>
						<td style="text-align:center;"><?php echo $i; ?></td>
						<td><?php echo $pms_config->c_detail; ?><input type="hidden" name="general[<?php echo $pms_config->id; ?>][id]" value="<?php echo $pms_config->id; ?>" id="id" class="form-control" ></td>
						<td><input type="text" name="general[<?php echo $pms_config->id; ?>][comments]" id="comments" class="form-control" ></td>
						<td style="text-align:center;"><select class="form-control" id="cs_core_id<?php echo $i; ?>" name="general[<?php echo $pms_config->id; ?>][score]" onchange="getcfourid(<?php echo $i;?>)" >						
								<option value="" >-Select-</option>
								@foreach ($all_pms_rating as $pms_rating)
								<option value="{{$pms_rating->id}}">{{$pms_rating->number}}</option>
								@endforeach
							</select></td>
						<td style="text-align:center;"><input type="text" name="general[<?php echo $pms_config->id; ?>][weight_score]" id="single_wt_score<?php echo $i; ?>" readonly class="form-control" ></td>
						<td style="text-align:center;"><input type="text" name="general[<?php echo $pms_config->id; ?>][rating]" id="single_ra_ting<?php echo $i; ?>" readonly class="form-control" ></td>
					</tr>
					<?php $i++; } } ?>
					<input type="hidden" id="totalrow3" value="<?php echo $i-1; ?>" class="form-control" >
					<tr>
						<td colspan="4" style="text-align:center;"><b>Total</b></td>
						<td id="total_wt_score" style="text-align:center;"></td>
						<td id="total_ra_ting" style="text-align:center;"></td>
					</tr>
				</tbody>
				<input type="hidden" name="score_b" id="score_b" class="form-control" >
				<input type="hidden" name="score_c1" id="score_c1" class="form-control" >
				<input type="hidden" name="score_c2" id="score_c2" class="form-control" >
				<input type="hidden" name="score_c3" id="score_c3" class="form-control" >
				<input type="hidden" name="score_c4" id="score_c4" class="form-control" >
			</table>
			<?php 
				$b1 = '<span id="b1">0</span>'; 
				$c1 = '<span id="c1">0</span>';
				$c2 = '<span id="c2">0</span>';
				$c3 = '<span id="c3">0</span>';
				$c4 = '<span id="c4">0</span>';
				$totalvalue = '<span id="totalvalue">0</span>';
				//$total = $b1 + $c1 + $c2 + $c3 + $c4;
			?>
			<table style="margin-left: 80px;" class="table" cellspacing="0">
				<tbody>
					<tr>
						<td style="font-weight: bold;width:10%;text-align:center;">Total Marks</td>
						<td style="font-weight: bold;width:30%;text-align:center;"><?php echo 'B = '.$b1.', '.'C.1 = '.$c1.', '.'C.2 = '.$c2.', '.'C.3 = '.$c3.', '.'C.4 = '.$c4;?></td>
						<td style="font-weight: bold;width:4%;text-align:center;"><?php echo $totalvalue; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-md-12">
			<button type="submit" id="submit" class="btn btn-success pull-right"> Approve</button>
		</div>
	</div>
	</form>
</section>
<script>
$("#new_form").on("submit", function () {
    $(this).find(":submit").prop("disabled", true);
});

function getid(id) {
	var total_row = $("#total_row").val();
	var rating_id = $("#ratingid"+id).val();
	var task_weight = $("#task_weight"+id).html();
	if(rating_id ==1 || rating_id ==4 || rating_id ==5 ) {
	//$('.input_select'+id).html('<input type="text" name="comments" id="comments" required  class="form-control" >');
	//$('.input_select'+id).attr("required", true);
		$('#comment'+id).attr("required", true);
		$('#comment'+id).css('border-color', 'red');
	} else {
		$('#comment'+id).attr("required", false);
		$('#comment'+id).css('border-color', '');
	}
	$.ajax({
	url: "{{URL::to('/get-marks')}}"+ "/"+ rating_id,
	type: 'GET',
	dataType: 'json',
	success: function(values)
		{                                                                    
			console.log(values);
			var rating = values.rating;
			var single_score = (parseFloat(task_weight) / 100) * parseFloat(rating);
			$("#score"+id).val(single_score);
			var totalplus = 0;
			for (i = 1; i < total_row; i++) { 	
				
				var plus_value = parseFloat(document.getElementById("score"+i).value);
				 if( isNaN(plus_value)){
					plus_value  = 0;
				} 
				totalplus += plus_value;
			}
			$("#total_weight_score").html(totalplus);
			//$("#total_score").html(($("#total_weight_score").html() / 100) * 60);
			var abc = ($("#total_weight_score").html() / 100) * 60;
			var total_score = $("#total_score").html(abc.toFixed(2));
			$("#b1").html(abc.toFixed(2));
			$("#score_b").val(abc.toFixed(2));
			//var total_value = total_score+$("#total_rating").html()+$("#totalrating").html()+$("#totalra_ting").html()+$("#total_ra_ting").html();
			var total_value = parseFloat($("#b1").html()) + parseFloat($("#c1").html()) + parseFloat($("#c2").html()) + parseFloat($("#c3").html()) + parseFloat($("#c4").html());
			$("#totalvalue").html(Math.round(total_value).toFixed(2));
		}
	})
	
}

function getconeid(id) {
	var scoreid = $("#scoreid"+id).val();
	var totalrow = $("#totalrow").val();
	$.ajax({
	url: "{{URL::to('/get-marks')}}"+ "/"+ scoreid,
	type: 'GET',
	dataType: 'json',
	success: function(values)
		{                                                                    
			console.log(values);
			var rating = values.rating;
			$("#single_weight_score"+id).val(rating);
			var plus_value1 = parseFloat(document.getElementById("single_weight_score"+id).value);
			var single_score = ((parseFloat(plus_value1) / 10) / 10);
			$("#single_rating"+id).val(single_score);
			var totalplus1 = 0;
			var totalplus2 = 0;
			for (j = 1; j <= totalrow; j++) { 	
				
				var plus_value1 = parseFloat(document.getElementById("single_weight_score"+j).value);
				 if( isNaN(plus_value1)){
					plus_value1  = 0;
				} 
				totalplus1 += plus_value1;
				
				var plus_value2 = parseFloat(document.getElementById("single_rating"+j).value);
				 if( isNaN(plus_value2)){
					plus_value2  = 0;
				} 
				totalplus2 += plus_value2;
			}
			$("#total_weightscore").html(totalplus1);
			$("#total_rating").html(Math.round(totalplus2).toFixed(2));
			$("#c1").html(totalplus2.toFixed(2));
			$("#score_c1").val(totalplus2.toFixed(2));
			var total_value = parseFloat($("#b1").html()) + parseFloat($("#c1").html()) + parseFloat($("#c2").html()) + parseFloat($("#c3").html()) + parseFloat($("#c4").html());
			$("#totalvalue").html(Math.round(total_value).toFixed(2));
		}
	})
	
}

function getctwoid(id) {
	var cscoreid = $("#cscoreid"+id).val();
	var totalrow1 = $("#totalrow1").val();
	$.ajax({
	url: "{{URL::to('/get-marks')}}"+ "/"+ cscoreid,
	type: 'GET',
	dataType: 'json',
	success: function(values)
		{                                                                    
			console.log(values);
			var rating = values.rating;
			$("#singleweightscore"+id).val(rating);
			var plus_value1 = parseFloat(document.getElementById("singleweightscore"+id).value);
			var single_score = ((parseFloat(plus_value1) / 6) / 10);
			$("#singlerating"+id).val(single_score.toFixed(2));
			var totalplus1 = 0;
			var totalplus2 = 0;
			for (k = 1; k <= totalrow1; k++) { 	
				
				var plus_value1 = parseFloat(document.getElementById("singleweightscore"+k).value);
				 if( isNaN(plus_value1)){
					plus_value1  = 0;
				} 
				totalplus1 += plus_value1;
				
				var plus_value2 = parseFloat(document.getElementById("singlerating"+k).value);
				 if( isNaN(plus_value2)){
					plus_value2  = 0;
				} 
				totalplus2 += plus_value2;
			}
			$("#totalweightscore").html(totalplus1);
			$("#totalrating").html(Math.round(totalplus2).toFixed(2));
			$("#c2").html(totalplus2.toFixed(2));
			$("#score_c2").val(totalplus2.toFixed(2));
			var total_value = parseFloat($("#b1").html()) + parseFloat($("#c1").html()) + parseFloat($("#c2").html()) + parseFloat($("#c3").html()) + parseFloat($("#c4").html());
			$("#totalvalue").html(Math.round(total_value).toFixed(2));
		}
	})
	
}

function getcthreeid(id) {
	var cs_coreid = $("#cs_coreid"+id).val();
	var totalrow2 = $("#totalrow2").val();
	$.ajax({
	url: "{{URL::to('/get-marks')}}"+ "/"+ cs_coreid,
	type: 'GET',
	dataType: 'json',
	success: function(values)
		{                                                                    
			console.log(values);
			var rating = values.rating;
			$("#singleweight_score"+id).val(rating);
			var plus_value1 = parseFloat(document.getElementById("singleweight_score"+id).value);
			var single_score = ((parseFloat(plus_value1) / 6) / 10);
			$("#singlera_ting"+id).val(single_score.toFixed(2));
			var totalplus1 = 0;
			var totalplus2 = 0;
			for (k = 1; k <= totalrow2; k++) { 	
				
				var plus_value1 = parseFloat(document.getElementById("singleweight_score"+k).value);
				 if( isNaN(plus_value1)){
					plus_value1  = 0;
				} 
				totalplus1 += plus_value1;
				
				var plus_value2 = parseFloat(document.getElementById("singlera_ting"+k).value);
				 if( isNaN(plus_value2)){
					plus_value2  = 0;
				} 
				totalplus2 += plus_value2;
			}
			$("#totalweight_score").html(totalplus1);
			$("#totalra_ting").html(Math.round(totalplus2).toFixed(2));
			$("#c3").html(totalplus2.toFixed(2));
			$("#score_c3").val(totalplus2.toFixed(2));
			var total_value = parseFloat($("#b1").html()) + parseFloat($("#c1").html()) + parseFloat($("#c2").html()) + parseFloat($("#c3").html()) + parseFloat($("#c4").html());
			$("#totalvalue").html(Math.round(total_value).toFixed(2));
		}
	})
	
}

function getcfourid(id) {
	var cs_core_id = $("#cs_core_id"+id).val();
	var totalrow3 = $("#totalrow3").val();
	$.ajax({
	url: "{{URL::to('/get-marks')}}"+ "/"+ cs_core_id,
	type: 'GET',
	dataType: 'json',
	success: function(values)
		{                                                                    
			console.log(values);
			var rating = values.rating;
			$("#single_wt_score"+id).val(rating);
			var plus_value1 = parseFloat(document.getElementById("single_wt_score"+id).value);
			var single_score = ((parseFloat(plus_value1) / 6) / 10);
			$("#single_ra_ting"+id).val(single_score.toFixed(2));
			var totalplus1 = 0;
			var totalplus2 = 0;
			for (k = 1; k <= totalrow3; k++) { 	
				
				var plus_value1 = parseFloat(document.getElementById("single_wt_score"+k).value);
				 if( isNaN(plus_value1)){
					plus_value1  = 0;
				} 
				totalplus1 += plus_value1;
				var plus_value2 = parseFloat(document.getElementById("single_ra_ting"+k).value);
				 if( isNaN(plus_value2)){
					plus_value2  = 0;
				} 
				totalplus2 += plus_value2;
			}
			$("#total_wt_score").html(totalplus1);
			$("#total_ra_ting").html(Math.round(totalplus2).toFixed(2));
			$("#c4").html(totalplus2.toFixed(2));
			$("#score_c4").val(totalplus2.toFixed(2));
			var total_value = parseFloat($("#b1").html()) + parseFloat($("#c1").html()) + parseFloat($("#c2").html()) + parseFloat($("#c3").html()) + parseFloat($("#c4").html());
			$("#totalvalue").html(Math.round(total_value).toFixed(2));
		}
	})
	
}
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupPms").addClass('active');
		$("#team_pms").addClass('active');
	});
</script>
@endsection