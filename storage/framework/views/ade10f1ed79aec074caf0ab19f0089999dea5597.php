
<?php $__env->startSection('main_content'); ?>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				
				<div class="box-body">
				Report
				</div>
				
		
				
				<table class="table table-bordered">
					<tr>
						<th>SL</th>
						<th>Emp ID</th>
						<th>Emp Name</th>
						<th>Branch</th>
						<th>Designation</th>
						<th>Joining Date</th>
						<th>Basic Salary</th>
						<th>Is Increment</th>
						<th>Is Promotion</th>
					</tr>
					<?php $i=1; foreach($infos as $info) { 
					
					if($info->is_incre ==1)
					{
						$is_increent = 'Yes';	
					}else{
						$is_increent = 'No';
					}
					
					if($info->in_prom ==1)
					{
						$is_promotion = 'Yes';	
					}else{
						$is_promotion = 'No';
					}
					
					?>
					<tr>
						<td><?php echo $i++; ?></td>
						<td><?php echo $info->emp_id; ?></td>
						<td><?php echo $info->emp_name; ?></td>
						<td><?php echo $info->branch_name; ?></td>
						<td><?php echo $info->designatation_name; ?></td>
						<td><?php echo $info->joining_date; ?></td>
						<td><?php echo $info->salary_basic; ?></td>
						<td><?php echo $is_increent; ?></td>
						<td><?php echo $is_promotion; ?></td>
					</tr>
					<?php } ?>
				</table>
				
				

						
			</div>
        </div>
	</div>
	
</section>


	

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>