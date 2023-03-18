
<?php $__env->startSection('main_content'); ?>
<script type="text/javascript" src="<?php echo e(asset('public/scripts/jquery.table2excel.js')); ?>"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small><?php echo e($Heading); ?></small></h1>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
				
					<form class="form-inline report" action="<?php echo e(URL::to('/auto-promotion')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="email">Grade Name :</label> <?php $grade_code;?>
							<select class="form-control" id="grade_code" name="grade_code" required>						
								<option value="" >-Select-</option>
								<?php $__currentLoopData = $all_grade; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($grade->grade_code); ?>"><?php echo e($grade->grade_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div class="form-group">
						  <label for="pwd">Date Upto:</label>
						  <input type="date" id="form_date" class="form-control" name="form_date" size="10" value="<?php echo e($form_date); ?>" required>
						</div>
						<div class="form-group">
							<label for="email">Order By :</label>
							<select name="order_by" id="order_by" class="form-control">
								<option value="emp_id" <?php if($order_by=="emp_id") echo 'selected'; ?> >Employee ID</option>
							</select>
						</div>
						<button type="submit" class="btn btn-primary" onclick="dateRange();">Search</button>
						<button type="button" id="btnExport" class="btn btn-primary" >Export Excel</button>
						<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>
					</form>
					
				</div>
				
				<hr>
			
				<div class="row">
				
					<div class="col-md-12">
						<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
						<b><font size="4">Next Promotion Status</font></b></p>		
					</div>
					<hr>
					<div style="overflow-y: auto; height: 600px;" class="col-md-12">
						<table id="tblExport" class="table table-bordered" cellspacing="0" style="font-size:11px;">
							<thead>
								<tr>
									<th>SL No.</th>
									<th>ID No</th>
									<th>Staff Name</td>
									<th>Designation</th>
									<th>Work Station</th>
									<th>Joining Date (Org.)</th>
									<th>Grade (effect date)</th>
									<th>Service Length</th>
									<th>Last Degree</th>
									<th>Staff type</th>
									<th>Censure</th>
									<th>Strong Warning</th>
									<th>Warning</th>
									<th>Fine</th>
									<th>Explanation</th>
									<th>Fine Amount</th>
									<th>Present Grade</th>
									<th>Present Step</td>									
									<th>Present Basic(Tk)</th>
									<th>Total (Tk)</th>							
									<th>Net Pay (Tk)</th>
									<th>Next Grade</th>
									<th>Next Step</th>									
									<th>Next Basic(Tk)</th>	
									<th>Incresed Basic(Tk)</th>	
									<th>Ka No.</th>	
									<th>Kha No. </th>	
									<th>Ga No.</th>	
									<th>Gha No.</th>	
									<th>Umo No. </th>	
									<th>Total</th>	
									<th>Remarks (1st)</th>	
									<th>Remarks (2nd)</th>	
								</tr>
							</thead>
							<tbody>
								<?php $i=1; if(!empty($all_result)) {
								foreach($all_result as $result) { ?>
								
								<tr>
									<td><?php echo e($i++); ?></td>
									<?php if(!empty($result['increment_marked'])) { ?>
									<td style="background:#ED2225;color:#fff;"><?php echo $result['emp_id']; ?><br>(Redmarked)</td>
									<?php } else { ?>
									<td><?php echo $result['emp_id']; ?></td>
									<?php } ?>
									<?php if(!empty($result['promotion_marked'])) { ?>
									<td style="background:#FE9A2E;color:white;"><?php echo $result['emp_name_eng']; ?><br>(Yellowmarked)</td>
									<?php } else { ?>
									<td><?php echo $result['emp_name_eng']; ?></td>
									<?php } ?>
									<?php if(!empty($result['permanent_marked'])) { ?>
									<td style="background:#008000;color:white;"><?php if((!empty($result['assign_designation'])) && ($result['assign_open_date'] <= $form_date)) {
											echo $result['assign_designation']; } else {
											echo $result['designation_name']; 
											} ?>
									</td>
									<?php } else { ?>
									<td><?php if((!empty($result['assign_designation'])) && ($result['assign_open_date'] <= $form_date)) {
											echo $result['assign_designation']; } else {
											echo $result['designation_name']; 
											} ?>
									</td>
									<?php } ?>
									<td><?php echo e($result['branch_name']); ?></td>
									<td><?php echo e($result['org_join_date']); ?></td>
									<td><?php echo e($result['grade_effect_date']); ?><?php if(!empty($result['incharge_as'])) { echo '<span style="color:#F70408"><b> ('.$result['incharge_as'].')</b></span> '; } ?></td>
									<td><?php 
										date_default_timezone_set('UTC');
										$input_date1 = date('Y-m-d', strtotime("+1 day", strtotime($form_date)));
										$input_date = new DateTime($input_date1);
										$org_date = new DateTime($result['grade_effect_date']);	
										$difference = date_diff($org_date, $input_date);
										echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
										 ?></td>
									<td><?php echo e($result['exam_name']); ?></td>
									<td><?php if($result['is_permanent'] == '1') {
										echo 'Probation'; } else {
										echo 'Permanent'; } ?>
									</td>
									<td><?php echo e($result['total_censure']); ?></td>
									<td><?php echo e($result['total_strong_warning']); ?></td>
									<td><?php echo e($result['total_warning']); ?></td>
									<td><?php echo e($result['total_fine']); ?></td>
									<td><?php echo e($result['total_explanation']); ?></td>
									<td><?php echo e($result['total_fine_amount']); ?></td>
									<td><?php echo e($result['grade_name']); ?></td>
									<td>Step - <?php echo $result['present_step']; ?></td>										
									<td><?php echo $result['basic_salary']; ?></td>	
									<td><?php echo e($result['total_salary']); ?></td>							
									<td><?php echo e($result['net_salary']); ?></td>										
									<td><?php echo 'Grade - '.$result['next_grade']; ?></td>
									<td><?php echo $result['next_steps']; ?></td>	
									<td><?php echo $result['next_basic_salary']; ?></td>	
									<td><?php echo $result['next_basic_salary'] - $result['basic_salary'] ; ?></td>	
									<td><?php echo $result['ka_marks']; ?></td>	
									<td><?php echo $result['kha_marks']; ?></td>	
									<td><?php echo $result['ga_marks']; ?></td>	
									<td><?php echo $result['gha_marks']; ?></td>	
									<td><?php echo $result['umo_marks']; ?></td>	
									<td><?php echo $result['total_marks']; ?></td>	
									<td><?php echo $result['first_comments']; ?></td>	
									<td><?php echo $result['second_comments']; ?></td>	
								</tr>
								<?php } } else { ?>
								<tr>
									<td colspan="33" align="center" style="color:red; "> No Employee Found </td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>

				<hr>
								
			</div>
        </div>
	</div>
	
</section>

<script>
    $(document).ready(function () {
        $("#btnExport").click(function () {
            $("#tblExport").table2excel({
                exclude:".noExl",
				name:"All Staff List",
				filename:"all_staff_list",
            });
        });
    });
</script>
<script>
document.getElementById("grade_code").value = '<?php echo $grade_code; ?>';
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>