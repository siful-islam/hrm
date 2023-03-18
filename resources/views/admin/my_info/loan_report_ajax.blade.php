	<table class="table table-bordered table-striped">
		<tr>
			<th>#</th>
			<th>Employee Name</th>
			<th>ID</th>
			<th>Designation</th>
			<th>Branch</th>
			<th>Apply Date</th>
			<th>Loan Type</th>
			<th>loan Amount</th>
			<th>Status</th>
		</tr>
		<?php $i = 1; foreach($results as $result) { 
		
		if($result->application_stage == 0){
			$status = 'Pending';
		}elseif($result->application_stage == 1)
		{
			$status = 'Recomended';
		}elseif($result->application_stage == 2)
		{
			$status = 'Approved';
		}elseif($result->application_stage == 3)
		{
			$status = 'Disbursed';
		}
		
		if($result->is_reject == 1)
		{
			$status = 'Rejected';
		}
		?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $result->emp_name; ?></td> 
			<td><?php echo $result->emp_id; ?></td> 
			<td><?php echo $result->designation_name; ?></td> 
			<td><?php echo $result->branch_name; ?></td> 
			<td><?php echo $result->application_date; ?></td> 
			<td><?php echo $result->loan_product_name; ?></td> 
			<td><?php echo $result->loan_amount; ?></td> 
			<td><a target="_BLANCK" href='{{URL::to("/application_location/$result->loan_app_id")}}'><?php echo $status; ?></a></td> 
		</tr>
		<?php } ?>
	</table>