@extends('admin.admin_master')
@section('main_content')
<style>
.required {
    color: red;
    font-size: 14px;
}
.form-horizontal .control-label {
    text-align: left;
}
.form-group {
    margin-bottom: 4px;
}
h3 {
    margin-top: 1px;
    margin-bottom: 2px;
}
</style>
<section class="content-header">
	<h1>add-assign</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">add-assign</li>
	</ol>
</section>
<?php $user_type = Session::get('user_type');?>
<section class="content">	
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="{{URL::to('/br_transfer_emp')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="email">Employee Type :</label>
							<select name="emp_type" id="emp_type" required readonly style="pointer-events:none;" class="form-control">
								<option value="1" <?php if($emp_type==1) echo 'selected'; ?> >Regular</option>
								<option value="2" <?php if($emp_type==2) echo 'selected'; ?> >OT</option>
								<option value="3" <?php if($emp_type==3) echo 'selected'; ?> >CH</option>
								<option value="4" <?php if($emp_type==4) echo 'selected'; ?> >SHS</option>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Employee ID :</label>
							<input type="text" id="emp_id" class="form-control" name="emp_id" size="10" value="{{$emp_id}}" readonly required>
						</div>
					</form>
				</div>
			</div>
        </div>
	</div>
	@if (!empty($all_result))
	<div class="row">
		<div class="col-md-12">			
			<div class="col-md-5">
				<div class="box box-info">
					<div class="box-body">
						<h3><center><u>Existing Information</u></center></h3>
						<div class="form-group">
							<label for="emp_id" class="col-sm-6 control-label">Employee ID </label>
							<div class="col-sm-6">			
								<p class="form-control-static">: {{$all_result->emp_id}}</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Employee Name </label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php echo $all_result->emp_name_eng; ?>
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Designation </label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php echo $all_result->designation_name; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Joining Date(org)</label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php echo date('d M Y',strtotime($all_result->org_join_date)); ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Org. Joining Branch </label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php echo $all_result->org_branch_name; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Org. Job Duration</label>
							<div class="col-sm-6">
								<p class="form-control-static">: 
									<?php 
									date_default_timezone_set('Asia/Dhaka');
									if(!empty($all_result->re_effect_date)) { 
										$input_date = new DateTime($all_result->re_effect_date);
									} else {
										$input_date = new DateTime($form_date);
									}
									$org_date = new DateTime($all_result->org_join_date);	
									$difference = date_diff($org_date, $input_date);

									echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
									 ?>
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Current Branch</label>
							<div class="col-sm-6">
								<p class="form-control-static">: {{$all_result->branch_name}}</p>
							</div>
						</div>							
						<div class="form-group">
							<label class="col-sm-6 control-label">Branch Joining Date</label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php echo date('d M Y',strtotime($all_result->br_join_date)); ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Duration of Current Branch </label>
							<div class="col-sm-6">
								<p class="form-control-static">: 
									<?php 
									date_default_timezone_set('Asia/Dhaka');
									if(!empty($all_result->re_effect_date)) { 
										$input_date = new DateTime($all_result->re_effect_date);
									} else {
										$input_date = new DateTime($form_date);
									}
									
									$org_date = new DateTime($all_result->br_join_date);
									
									$difference = date_diff($org_date, $input_date);
									echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
									 ?>
								</p>
							</div>
						</div>
					</div>          
				</div>
			</div>
			<form class="form-horizontal" action="{{URL::to($action)}}" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="col-md-7">
					<div class="box box-info">
						<div class="box-body">
							<h3><center><u>Transfer Information</u></center></h3>
							<br>
							<?php if($user_type == 3) { ?>
							<div class="form-group">
								<label for="area_code" class="col-sm-4 control-label">Transfer Area :</label>
								<div class="col-sm-4">			
									<select class="form-control" name="area_code" id="area_code" >						
										<option value="" >-Select-</option>
										@foreach ($result_area as $area)
										<option value="{{$area->area_code}}">{{$area->area_name}}</option>	
										@endforeach
									</select>
								</div>
							</div>
							<?php } ?>
							<div class="form-group">
								<label for="br_code" class="col-sm-4 control-label">Transfer Branch :</label>
								<div class="col-sm-4">			
									<select class="form-control" id="br_code" name="br_code" required >						
										<option value="" >-Select-</option>
										@foreach ($all_branch as $branch)
										<option value="{{$branch->br_code}}">{{$branch->branch_name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Transfer Effect Date :</label><span style="color:#C70039;">(Transfer Branch এর Join date)</span>
								<div class="col-sm-4">
									<input type="text" class="form-control form_date" id="br_join_date" name="br_join_date" value="{{$br_join_date}}" required onchange="Checkdate()">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Transfer Handover Date :</label>
								<div class="col-sm-4">
									<input type="text" class="form-control form_date" id="br_handover_date" name="br_handover_date" value="{{$br_handover_date}}" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Purpose of Transfer :</label>
								<div class="col-sm-4">
									<select name="tr_purpose" id="tr_purpose" required class="form-control">
										<option value="official" <?php if($tr_purpose=='official') echo 'selected'; ?> >Official</option>
										<option value="personal" <?php if($tr_purpose=='personal') echo 'selected'; ?> >Personal</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Comments :</label>
								<div class="col-sm-6">
									<textarea class="form-control" name="comments" rows="2" >{{$comments}}</textarea>
								</div>
							</div>
						</div>
						<div class="box-footer">
							<a href="{{URL::to('/br_transfer')}}" class="btn bg-olive" >List</a>
							<button type="submit" id="submit" class="btn btn-primary">{{$button_text}}</button>
						</div>
					</div>
				</div>
			</form>
		</div>					
	</div>
	<div class="row">
		<div class="col-md-12">
			<form class="form-horizontal" >
				<div class="col-md-5">
					<div class="box box-info">
						<div class="box-body">
							<h3><center><u>Transfer History</u></center></h3>
							<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>Branch Name</th>
							<th>Date From</th>
							<th>Date To</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$i = 1; $next_day = date("Y-m-d"); $to_date = date("Y-m-d");
						foreach($results as $result) {
							if($i == 1) {
								if(!empty($all_result->re_effect_date)) {
									$date_upto = $all_result->re_effect_date;
								} else {
									$date_upto = $to_date;
								}
							} else {			
								$date_upto = date('Y-m-d', strtotime("-1 day", strtotime($next_day)));				
							}
							$big_date=date_create($date_upto);
							$small_date=date_create($result->br_joined_date);
							$diff=date_diff($big_date,$small_date);
						?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $result->branch_name; ?></td>
							<td><?php echo date('d M Y',strtotime($result->br_joined_date)); ?></td>
							<td><?php echo date('d M Y',strtotime($date_upto)); ?></td>
						</tr>
						<?php $next_day = $result->br_joined_date;
							$i++; 
						} ?>
					</tbody>
				</table>
						</div>          
					</div>
				</div>
			</form>
		</div>					
	</div>
	@endif
</section>
<script>
$(document).ready(function() {
	$('.form_date').datepicker({dateFormat: 'yy-mm-dd'});
	document.getElementById("br_code").value = "<?php echo $br_code;?>";
	document.getElementById("area_code").value = "<?php echo $area_code;?>";
});

function Checkdate() {
  var x = document.getElementById("br_join_date").value;
  var y = '<?php echo isset($all_result->br_join_date) ? date('Y-m-d',strtotime($all_result->br_join_date)):""; ?>';
  if (x < y) {
		alert("Transfer effect date অবশ্যই  previous branch date এর থেকে বড় হতে হবে!");
		$("#submit").attr("disabled", true);
	} else {
		$("#submit").attr("disabled", false);
	}
}
</script>
<script>
	$(document).on("change", "#area_code", function () {
		var area_code = $(this).val();   
		//alert(area_code);		 
		$.ajax({
			url : "{{ url::to('select-branch') }}"+"/"+area_code,
			type: "GET",
			success: function(data)
			{
				//alert(data);
				$("#br_code").attr("disabled", false);
				$("#br_code").html(data);
				 
			}
		});  
	}); 
</script>
<script>
	function validateForm() {   
		var br_join_date  = document.getElementById("br_join_date").value;
		var br_handover_date  = document.getElementById("br_handover_date").value; 
		var succeed = false;
		if(br_join_date >= br_handover_date){ 
			succeed = true;
		} else {
			alert("Transfer effect date অবশ্যই  সর্বশেষ branch join date এর পরের তারিখ হতে হবে!");
			succeed = false;
			document.getElementById("br_handover_date").focus();
		}
		return succeed;
		 
	} 
</script>
@endsection