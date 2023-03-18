<style>
.content {
	padding-top: 5px;
}
.table > tr > th {   
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
	font-weight: bold;
	text-align: left; 
	padding: 2px;
}
.table > tr > td {
	padding: 4px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
</style>
<?php 
$allreligions = array('Islam'=>'Islam','Hinduism'=>'Hinduism','Christianity'=>'Christianity','Buddhism'=>'Buddhism','Other'=>'Other');
$allbloods = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','O+'=>'O+','O-'=>'O-');
$all_countries = array('1'=>'Bangladesh','2'=>'India');
?>
<section class="content">
	<strong><u>General Information :</u></strong>
	<table>
		<tr>
			<td>Employee ID : <?php echo $emp_cv_basic->emp_id; ?></td>
			<td rowspan="10"><img style="height: 180px; width: 172px;" src="<?php //echo (asset('public/employee/'.$emp_cv_photo->emp_photo)); ?>" /> </td>
		</tr>
		<tr>
			<td>Employee Name (in English) : <?php echo $emp_cv_basic->emp_name_eng; ?></td>
		</tr>
		<tr>
			<td>Employee Name (in Bengali) : <?php echo $emp_cv_basic->emp_name_ban; ?></td>
		</tr>
		<tr>
			<td>Father's Name : <?php echo $emp_cv_basic->father_name; ?></td>
		</tr>
		<tr>
			<td>Mother's Name : <?php echo $emp_cv_basic->mother_name; ?></td>
		</tr>
		<tr>
			<td>Date of Birth : <?php echo $emp_cv_basic->birth_date; ?></td>
		</tr>
		<tr>
			<td>Present Age : <?php $date1 = new DateTime($emp_cv_basic->birth_date);
									$date2 = date('Y-m-d', strtotime("+1 day"));						
									$date3 = new DateTime($date2);						
									$interval = date_diff($date1, $date3);
									echo $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; ?>
			</td>
		</tr>
		<tr>
			<td>Religion : @foreach ($allreligions as $religionid => $religionname)
										@if($religionid == $emp_cv_basic->religion)
										{{$religionname}}
										@endif
										@endforeach</td>
		</tr>
		<tr>
			<td>Maritial Status : @if($emp_cv_basic->maritial_status == 'Married') {{'Married'}}
										@elseif($emp_cv_basic->maritial_status == 'Unmarried') {{'Unmarried'}}
										@else {{'N/A'}}
										@endif</td>
		</tr>
		<tr>
			<td>Nationality : <?php echo $emp_cv_basic->nationality; ?></td>
		</tr>
		<tr>
			<td>National Id : <?php echo $emp_cv_basic->national_id; ?></td>
		</tr>
		<tr>
			<td>Gender : @if($emp_cv_basic->gender == 'Male') {{'Male'}}
										@else
										{{'Female'}}
										@endif</td>
		</tr>
		<tr>
			<td>Country Name : @foreach ($all_countries as $country_id => $country_name)
										@if($country_id == $emp_cv_basic->country_id)
										{{$country_name}}
										@endif
										@endforeach</td>
		</tr>
		<tr>
			<td>Contact Number : <?php echo $emp_cv_basic->contact_num; ?></td>
		</tr>
		<tr>
			<td>Email : <?php echo $emp_cv_basic->email; ?></td>
		</tr>
		<tr>
			<td>Blood Group : <?php echo $emp_cv_basic->blood_group; ?></td>
		</tr>
		<tr>
			<td>Joining Date : <?php echo $emp_cv_basic->org_join_date; ?></td>
		</tr>
		<tr>
			<td>Present Address : <?php echo $emp_cv_basic->present_add; ?></td>
		</tr>
		<tr>
			<td>Permanent Address : <?php echo $emp_cv_basic->permanent_add; ?></td>
		</tr>
	</table>
	<br><br>
	<strong><u>Education Information :</u></strong>
	<br>
	<table class="table" width="100%" border="1" cellspacing="0"> 
		<tr>
			<th>Exam. Name</th>
			<th>Group/Subject</th>
			<th>Board/University</th>
			<th>Result</th>
			<th>Passing Year</th>
		</tr>
		@foreach($emp_cv_edu as $emp_edu)
		<tr>
			<td>{{$emp_edu->exam_name}}</td>
			<td>{{$emp_edu->subject_name}}</td>
			<td>{{$emp_edu->board_uni_name }}</td>
			<td>{{$emp_edu->result}}</td>
			<td>{{$emp_edu->pass_year}}</td>
		</tr>
		@endforeach
	</table>
	<br><br>
	<strong><u>Training Information :</u></strong>
	<br>
	<table class="table" width="100%" border="1" cellspacing="0"> 
		<tr>
			<th>Training Name</th>
			<th>Training Period</th>
			<th>Institute Name</th>
			<th>Place</th>
		</tr>
		@foreach($emp_cv_tra as $emp_tra)
		<tr>
			<td>{{$emp_tra->train_name}}</td>
			<td>{{$emp_tra->train_period}}</td>
			<td>{{$emp_tra->institute}}</td>
			<td>{{$emp_tra->palace}}</td>
		</tr>
		@endforeach
	</table>
	<br><br>
	<strong><u>Experience Information :</u></strong>
	<br>
	<table class="table" width="100%" border="1" cellspacing="0"> 
		<tr>
			<th>Designation</th>
			<th>Experience Period</th>
			<th>Organization Name</th>
		</tr>
		@foreach($emp_cv_exp as $emp_exp)
		<tr>
			<td>{{$emp_exp->designation}}</td>
			<td>{{$emp_exp->experience_period}}</td>
			<td>{{$emp_exp->organization_name}}</td>
		</tr>
		@endforeach
	</table>
	<br><br>
	<strong><u>Reference Information :</u></strong>
	<br>
	<table class="table" width="100%" border="1" cellspacing="0"> 
		<tr>
			<th>Name</th>
			<th>Occupation</th>
			<th>Address</th>
			<th>Contact</th>
			<th>Email</th>
			<th>NID</th>
		</tr>
		@foreach($emp_cv_ref as $emp_ref)
		<tr>
			<td>{{$emp_ref->rf_name}}</td>
			<td>{{$emp_ref->rf_occupation}}</td>
			<td>{{$emp_ref->rf_address}}</td>
			<td>{{$emp_ref->rf_mobile}}</td>
			<td>{{$emp_ref->rf_email}}</td>
			<td>{{$emp_ref->rf_national_id}}</td>
		</tr>
		@endforeach
	</table>
</section>