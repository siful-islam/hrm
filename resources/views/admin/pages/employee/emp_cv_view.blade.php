@extends('admin.admin_master')
@section('title', 'Employee(CV)')
@section('main_content')
<style>
.box-body {
    padding: 2px;
	margin-bottom:5px;

}
.box-header {
    padding: 2px 10px;
}
.h4, .h5, .h6, h4, h5, h6 {
    margin-top: 2px;
    margin-bottom: 2px;
}
hr {
    margin-top: 1px;
    margin-bottom: 1px;
}
.form-group {
    margin-bottom: 5px;
}
.form-group label {
    font-size: 12px;
}
.table {
    margin-bottom: 4px;
}
.table thead th { 
  background-color: #ECF0F5;
}
.table > thead > tr > th {
    padding: 4px;
}
.content-header > .breadcrumb {
    top: 5px;
	position: relative;
}

</style>
<?php 
$allreligions = array('Islam'=>'Islam','Hinduism'=>'Hinduism','Christianity'=>'Christianity','Buddhism'=>'Buddhism','Other'=>'Other');
$allbloods = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','O+'=>'O+','O-'=>'O-');
$all_countries = array('1'=>'Bangladesh','2'=>'India');
?>
<section class="content-header">
  <h4>Employee CV View</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Home</a></li>
	<li class="active">Employee CV</li>
	<!--<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>-->
	<button type="button" class="btn bg-navy"><i class="fa fa-file" aria-hidden="true"></i> <a href="{{URL::to('/emp-cv-pdf/'.$emp_cv_basic->emp_id)}}">Print PDF</a></button>
  </ol>
</section>
<section class="content">	
	<div id="printme">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<form class="form-horizontal">
						<div class="box-header"><h4>General Information:</h4></div>
						<hr>
						<div class="box-body">
							<div style="padding-left:2px;" class="col-md-8 col-xs-6">
								<div class="form-group">
									<label class="col-sm-4">Employee ID</label>
									<div class="col-sm-6">: {{$emp_cv_basic->emp_id}}</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Employee Name (in English)</label>
									<div class="col-sm-6">: {{$emp_cv_basic->emp_name_eng}}</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Employee Name (in Bengali)</label>
									<div class="col-sm-6">: {{$emp_cv_basic->emp_name_ban}}</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Father's Name</label>
									<div class="col-sm-6">: {{$emp_cv_basic->father_name}}</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Mother's Name</label>
									<div class="col-sm-6">: {{$emp_cv_basic->mother_name}}</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Date of Birth</label>
									<div class="col-sm-6">: {{$emp_cv_basic->birth_date}}</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Present Age</label>
									<div class="col-sm-6">: 
									<?php $date1 = new DateTime($emp_cv_basic->birth_date);
									$date2 = date('Y-m-d', strtotime("+1 day"));						
									$date3 = new DateTime($date2);						
									$interval = date_diff($date1, $date3);
									// $days = $diff12->d;
									//accesing months
									echo $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Religion</label>
									<div class="col-sm-6">: 
										@foreach ($allreligions as $religionid => $religionname)
										@if($religionid == $emp_cv_basic->religion)
										{{$religionname}}
										@endif
										@endforeach
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Maritial Status</label>
									<div class="col-sm-6">: 
										@if($emp_cv_basic->maritial_status == 'Married') {{'Married'}}
										@elseif($emp_cv_basic->maritial_status == 'Unmarried') {{'Unmarried'}}
										@else {{'N/A'}}
										@endif
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Nationality</label>
									<div class="col-sm-6">: {{$emp_cv_basic->nationality}}</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">National Id</label>
									<div class="col-sm-6">: {{$emp_cv_basic->national_id}}</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Gender</label>
									<div class="col-sm-6">:
										@if($emp_cv_basic->gender == 'Male') {{'Male'}}
										@else
										{{'Female'}}
										@endif
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Country Name</label>
									<div class="col-sm-6">:
										@foreach ($all_countries as $country_id => $country_name)
										@if($country_id == $emp_cv_basic->country_id)
										{{$country_name}}
										@endif
										@endforeach
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Contact Number</label>
									<div class="col-sm-6">: {{$emp_cv_basic->contact_num}}</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Email</label>
									<div class="col-sm-6">: {{$emp_cv_basic->email}}</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Blood Group</label>
									<div class="col-sm-6">: {{$emp_cv_basic->blood_group}}</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Joining Date</label>
									<div class="col-sm-6">: {{$emp_cv_basic->org_join_date}}</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Present Address</label>
									<div class="col-sm-6">: {{$emp_cv_basic->present_add}}</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Permanent Address</label>
									<div class="col-sm-6">: {{$emp_cv_basic->permanent_add}}</div>
								</div>
							</div>
							<div class="col-md-4 col-xs-6">
								<div class="form-group"><div style="padding-left:15px;" class="text-left" >ID : {{$emp_cv_basic->emp_id}}</div></div>
								@if($emp_cv_photo)
								<img style="height: 180px; width: 172px;" class="img-thumbnail" src="{{asset('public/employee/'.$emp_cv_photo->emp_photo)}}" />
								@else
								<img style="height: 180px; width: 172px;" class="img-thumbnail" src="{{asset('public/employee/placeholder.png')}}" /> 
								@endif
								<div class="form-group"><div style="padding-left:15px;" class="text-left" >Name : {{$emp_cv_basic->emp_name_eng}}</div></div>
							</div>
						</div>
						<div class="box-header"><h4>Education Information:</h4></div>					
						<hr>
						<div class="box-body">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Exam. Name</th>
											<th>Group/Subject</th>
											<th>Board/University</th>
											<th>Result</th>
											<th>Passing Year</th>
										</tr>
									</thead>
									<tbody>
										@foreach($emp_cv_edu as $emp_edu)
										<tr>
											<td>{{$emp_edu->exam_name}}</td>
											<td>{{$emp_edu->subject_name}}</td>
											<td>{{$emp_edu->board_uni_name }}</td>
											<td>{{$emp_edu->result}}</td>
											<td>{{$emp_edu->pass_year}}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						<div class="box-header"><h4>Training Information:</h4></div>					
						<hr>
						<div class="box-body">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Training Name</th>
										<th>Training Period From</th>
										<th>Training Period To</th>
										<th>Institute Name</th>
										<th>Place</th>
									</tr>
								</thead>
								<tbody>
									@foreach($emp_cv_tra as $emp_tra)
									<tr>
										<td>{{$emp_tra->train_name}}</td>
										<td>{{$emp_tra->train_period}}</td>
										<td>{{$emp_tra->train_period_to}}</td>
										<td>{{$emp_tra->institute}}</td>
										<td>{{$emp_tra->palace}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="box-header"><h4>Experience Information:</h4></div>					
						<hr>
						<div class="box-body">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Designation</th>
										<th>Experience Period</th>
										<th>Organization Name</th>
									</tr>
								</thead>
								<tbody>
									@foreach($emp_cv_exp as $emp_exp)
									<tr>
										<td>{{$emp_exp->designation}}</td>
										<td>{{$emp_exp->experience_period}}</td>
										<td>{{$emp_exp->organization_name}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="box-header"><h4>Reference Information:</h4></div>					
						<hr>
						<div class="box-body">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Name</th>
											<th>Occupation</th>
											<th>Address</th>
											<th>Contact</th>
											<th>Email</th>
											<th>NID</th>
										</tr>
									</thead>
									<tbody>
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
									</tbody>
								</table>
							</div>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
</section>
<script language="javascript" type="text/javascript">
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML = 
          "<html><head><title></title></head><body>" + 
          divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;
    }
</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee").addClass('active');
			$('[id^=Employee_]').addClass('active');
		});
	</script>
@endsection