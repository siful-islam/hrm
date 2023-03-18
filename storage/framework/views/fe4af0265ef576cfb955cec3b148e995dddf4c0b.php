<?php $__env->startSection('title', 'Branch Transfer'); ?>
<?php $__env->startSection('main_content'); ?>
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
					<form class="form-inline report">
						<div class="form-group">
							<label for="email">Employee Type :</label>
							<select name="emp_type" id="emp_type" required class="form-control">
								<option value="regular" <?php if($emp_type=="regular") echo 'selected'; ?> >Regular</option>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Employee ID :</label>
							<input type="text" id="emp_id" class="form-control" name="emp_id" size="10" value="<?php echo e($emp_id); ?>" required>
						</div>
					</form>
				</div>
			</div>
        </div>
	</div>
	<?php if(!empty($all_result)): ?>
	<div class="row">
		<div class="col-md-12">			
			<div class="col-md-6">
				<div class="box box-info">
					<div class="box-body">
						<h3><center><u>Existing Information</u></center></h3>
						<div class="form-group">
							<label for="emp_id" class="col-sm-6 control-label">Employee ID </label>
							<div class="col-sm-6">			
								<p class="form-control-static">: <?php echo e($all_result->emp_id); ?></p>
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
								<p class="form-control-static">: <?php echo e($all_result->branch_name); ?></p>
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
			<form class="form-horizontal">
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-body">
							<h3><center><u>Transfer Information</u></center></h3>
							<br>
							<?php if($user_type == 3) { ?>
							<div class="form-group">
								<label for="area_code" class="col-sm-4 control-label">Transfer Area :</label>
								<div class="col-sm-4">			
									<p class="form-control-static">: <?php echo e($area_name); ?></p>
								</div>
							</div>
							<?php } ?>
							<div class="form-group">
								<label for="br_code" class="col-sm-4 control-label">Transfer Branch :</label>
								<div class="col-sm-4">			
									<p class="form-control-static">: <?php echo e($branch_name); ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Transfer Effect Date :</label>
								<div class="col-sm-4">
									<p class="form-control-static">: <?php echo date('d-m-Y',strtotime($br_join_date)); ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Transfer Handover Date :</label>
								<div class="col-sm-4">
									<p class="form-control-static">: <?php echo date('d-m-Y',strtotime($br_handover_date)); ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Purpose of Transfer :</label>
								<div class="col-sm-4">
									<p class="form-control-static">: <?php echo e(ucwords($tr_purpose)); ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Comments :</label>
								<div class="col-sm-6">
									<p class="form-control-static">: <?php echo e($comments); ?></p>
								</div>
							</div>
						</div>
						<div class="box-footer">
							<a href="<?php echo e(URL::to('/br_transfer')); ?>" class="btn bg-olive" >List</a>
							<?php if($status !=1) { if ($user_type ==1) { ?>
							<a class="btn btn-primary" id="newform" onclick="approve(<?php echo e($id); ?>,<?php echo e($emp_id); ?>)" >Approved</a>
							<?php } } ?>
						</div>
					</div>
				</div>
			</form>
		</div>					
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-6">
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
			<div class="col-md-6">
				<div class="box box-info">
					<div class="box-body">
						<h3><center><u>Transfer Added By</u></center></h3>						
						<div class="form-group">
							<label class="col-sm-6 control-label"><?php echo ($entry_user_type !=3) ? "Area" : "District"; ?> Manager Name </label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php echo $area_manager_name; ?>
								</p>
							</div>
						</div>
						<div class="form-group">
							<label for="emp_id" class="col-sm-6 control-label"><?php echo ($entry_user_type !=3) ? "Area" : "District"; ?> Manager ID </label>
							<div class="col-sm-6">			
								<p class="form-control-static">: <?php echo e($area_manager_id); ?></p>
							</div>
						</div>
						<div class="form-group">
							<label for="emp_id" class="col-sm-6 control-label"><?php echo ($entry_user_type !=3) ? "Area" : "Zone"; ?> Name </label>
							<div class="col-sm-6">			
								<p class="form-control-static">: <?php echo ($entry_user_type !=3) ? $area_name : $zone_name; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Entry Date </label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php echo date("d-m-Y",strtotime($created_at)); ?></p>
							</div>
						</div>
					</div>          
				</div>
			</div>
		</div>					
	</div>
	<?php endif; ?>
</section>
<script>
function approve(id,emp_id)
	{
	//alert(emp_id);
	//exit;
	//document.getElementById('newform').style['display']='none';
	$("#newform").attr("disabled", "disabled");
	$.ajax({
			url : "<?php echo e(url::to('approve_br_transfer')); ?>"+"/"+ id +"/"+emp_id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{           
				//alert('data');
				location.reload();
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				//alert('Error');
			}
		});
	}
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupEmployee").addClass('active');
		$("#Branch_Transfer").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>