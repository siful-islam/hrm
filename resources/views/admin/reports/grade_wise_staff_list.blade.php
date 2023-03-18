
<?php //echo $date_within; ?>
<table border="1" width="100%">
	<tr>	
		<td>No</td>
		<td>Employee ID</td>
		<td>Employee Name</td>
		<td>Joining Date</td>
		<td>Grade</td>
		<td>Scale</td>
		<td>Basic Salary</td>
		<td>Designation</td>
		<td>Branch</td>
	</tr>
	<?php if(!empty(count($result))) { ?>
	<?php $i = 1; foreach($result as $v_result) { ?>
	<tr>	
		<td><?php echo $i++; ?></td>
		<td><?php echo $v_result->emp_id; ?></td>
		<td><?php echo $v_result->emp_name_eng; ?></td>
		<td><?php echo $v_result->org_join_date; ?></td>
		<td><?php echo $v_result->grade_name; ?></td>
		<td><?php echo $v_result->scale_name; ?></td>
		<td><?php echo $v_result->basic_salary; ?></td>
		<td><?php echo $v_result->designation_name; ?></td>
		<td><?php echo $v_result->branch_name; ?></td>
	</tr>
	<?php } } else { ?>
	<tr>	
		<td align="center" colspan="9">No Employee Found</td>
	</tr>
	<?php } ?>
	
</table>