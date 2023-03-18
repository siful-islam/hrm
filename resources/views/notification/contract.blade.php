<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notification</title>
	
</head>

	
<body>

    <b>Dear Concern,</b>
	<br><br />
	This is for your kind information, <b>{{$mail_data['emp_name'] }}</b> has joined CDIP on {{date('d-m-Y',strtotime($mail_data['org_join_date']))}} as contractual staff. @if($mail_data['gender']=='Male')His @else Her @endif contract ending date is {{date('d-m-Y',strtotime($mail_data['permanent_date']))}}. Please take necessary step.
	<br><br>
	
	<table width="100%">
		<tr>
			<td align="center" colspan="3" style="background-color:#054A50; color: white; "><h4>Employee Details</h4></td>
			</br>
		</tr>
		<tr>
			<td width="30%">Employee Name </td>
			<td>:</td>
			<td><b>{{$mail_data['emp_name'] }}</b></td>
		</tr>
		<tr>
			<td>Employee ID </td>
			<td>:</td>
			<td><b>{{$mail_data['emp_id']}}</b></td>
		</tr>
		<tr>
			<td>Designation </td>
			<td>:</td>
			<td><b>{{$mail_data['designation']}}</b></td>
		</tr>		
	</table>
	<br><br>
    CDIP HRM-APP
    <br><br>
	
</body>

</html>
