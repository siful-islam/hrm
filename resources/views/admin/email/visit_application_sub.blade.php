<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Visit Application</title>
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
	You have a visit application for approval.
	<br>
	<hr>
	<table width="100%">
		<tr>
			<td align="center" colspan="3" style="background-color:#054A50; color: white; "><h4>Details of Application</h4></td>
		</tr>
		<tr>
			<td width="30%">Employee Name </td>
			<td>:</td>
			<td>{{ $v_mail_data['emp_name'] }}</td>
		</tr>
		<tr>
			<td>Employee ID </td>
			<td>:</td>
			<td>{{ $v_mail_data['emp_id'] }}</td> 
		</tr>
		<tr>
			<td>Departure Date & Time</td>
			<td>:</td>
			<td>{{ date('d-m-Y', strtotime($v_mail_data['from_date'])) }} at {{ $v_mail_data['leave_time'] }}</td>
		</tr>
		<tr>
			<td>Return Date & Time</td>
			<td>:</td>
			<td>{{ date('d-m-Y', strtotime($v_mail_data['to_date'])) }} at {{ $v_mail_data['arrival_time'] }}</td>
		</tr>
		<tr>
			<td>Destination</td>
			<td>:</td>
			<td>{{ $v_mail_data['destination_code'] }}</td>
		</tr>
		<tr>
			<td>Purpose </td>
			<td>:</td>
			<td valign="top">{{ $v_mail_data['purpose'] }}</td>
		</tr>
	</table>
	<br>
    <br>
    CDIP HRM-APP
    <br><br>
	<div>
        <a id="accept" href="{{ URL::to('/visit_mail_action' . '/' . $v_mail_data['move_id'] . '/' . $v_mail_data['sub_supervisors_emp_id'] . '/1' . '/2') }}"
            target="_blanck">Proceed</a>
        &nbsp;&nbsp;&nbsp;&nbsp; |
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a id="reject" href="{{ URL::to('/visit_mail_action' . '/' . $v_mail_data['move_id'] . '/' . $v_mail_data['sub_supervisors_emp_id'] . '/2' . '/2') }}"
            target="_blanck">Reject</a>
    </div>
</body>

</html>
