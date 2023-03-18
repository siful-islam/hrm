<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Leave Application</title>
	<style>
	#reject:link, #reject:visited {
	  background-color: #F14444;
	  color: white;
	  padding: 14px 25px;
	  text-align: center;
	  text-decoration: none;
	  display: inline-block;
	}

	#reject:hover, #reject:active {
	  background-color: red;
	}

	#accept:link, #accept:visited {
	  background-color: #4CCF0B;
	  color: white;
	  padding: 14px 25px;
	  text-align: center;
	  text-decoration: none;
	  display: inline-block;
	}

	#accept:hover, #accept:active {
	  background-color: green;
	}
	</style>
</head>

<body>

    <b>Dear Sir,</b>
	<br />
	You have a leave application for approval.
	<br>
	<hr>
	<table width="100%">
		<tr>
			<td align="center" colspan="3" style="background-color:#054A50; color: white; "><h4>Details of Application</h4></td>
		</tr>
		<tr>
			<td width="30%">Employee Name </td>
			<td>:</td>
			<td><?php echo e($mail_data['emp_name']); ?></td>
		</tr>
		<tr>
			<td>Employee ID </td>
			<td>:</td>
			<td><?php echo e($mail_data['emp_id']); ?></td>
		</tr>
		<tr>
			<td>Leave Period</td>
			<td>:</td>
			<td><?php echo e(date('d-m-Y', strtotime($mail_data['leave_from']))); ?> to <?php echo e(date('d-m-Y', strtotime($mail_data['leave_to']))); ?></td>
		</tr>
		<tr>
			<td>Duration</td>
			<td>:</td>
			<td><?php echo e($mail_data['no_of_days']); ?> <?php if($mail_data['no_of_days'] < 2 ) { echo 'day'; }else { echo 'days'; }?></td>
		</tr>
		<tr>
			<td>Purpose </td>
			<td>:</td>
			<td valign="top"><?php echo e($mail_data['remarks']); ?></td>
		</tr>
		<?php
		if($mail_data['modify_cancel'] == 0)
		{
			$application_type = "Regular Application";
			$modify_remarks_lebel = "Remarks";
		}else if($mail_data['modify_cancel'] == 1)
		{
			$application_type = "Modified Application";
			$modify_remarks_lebel = "Cause of Modification";
		}
		else if($mail_data['modify_cancel'] == 2)
		{
			$application_type = "Cancelation Application";
			$modify_remarks_lebel = "Cause of Cancelation";
		}
		?>
		<tr>
			<td>Application Type </td>
			<td>:</td>
			<td valign="top"><?php echo e($application_type); ?></td>
		</tr>
		<?php
		if($mail_data['modify_cancel'] > 0) { ?>
		<tr>
			<td style="color:red;"><?php echo $modify_remarks_lebel; ?></td>
			<td>:</td>
			<td valign="top"><?php echo e($mail_data['modify_remarks']); ?></td>
		</tr>
		<?php } ?>
	</table>
	<br>
    <br>
    CDIP HRM-APP
    <br><br>
	<div>
        <a id="accept" href="<?php echo e(URL::to('/leave_mail_action' . '/' . $mail_data['application_id'] . '/' . $mail_data['sub_supervisors_emp_id'] . '/1' . '/2')); ?>"
            target="_blanck">Proceed</a>
        &nbsp;&nbsp;&nbsp;&nbsp; |
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a id="reject" href="<?php echo e(URL::to('/leave_mail_action' . '/' . $mail_data['application_id'] . '/' . $mail_data['sub_supervisors_emp_id'] . '/2' . '/2')); ?>"
            target="_blanck">Reject</a>
    </div>
</body>

</html>
