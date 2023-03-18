@extends('admin.admin_master')
@section('main_content')
<script type="text/javascript" src="{{asset('public/scripts/jquery.table2excel.js')}}"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small>{{$Heading}}</small></h1>
</section>

<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
				
					<form class="form-inline report" action="{{URL::to('/approval_report_visit')}}" method="post">
						{{ csrf_field() }}
						
						<div class="form-group">
						  <label for="form_date">Date From:</label>
						  <input type="date" id="form_date" class="form-control" name="form_date" size="10" value="{{$form_date}}" onchange="set_date()" required>
						</div>
						<div class="form-group">
						  <label for="to_date">Date To:</label>
						  <input type="date" id="to_date" class="form-control" name="to_date" size="10" value="{{$to_date}}" required>
						</div>
						<div class="form-group">
						  <label for="emp_id">Emp ID:</label>
						  <input type="text" id="emp_id" class="form-control" name="emp_id" size="10" value="{{$emp_id}}" >
						</div>
						<div class="form-group">
							<label for="pwd">Activities:</label>
							<select id="activities" class="form-control" name="activities" required>
								<option value="0">All</option>
								<option value="1">Approved</option>
								<option value="2">Rejected</option>
								<option value="3">Recomendation</option>
								<option value="4">Reject(As Sub)</option>
							</select>
						</div>
						<button type="submit" class="btn btn-primary"> Show Report</button>
					</form>
					
				</div>
				
				<hr>
				

				<div class="row">
				
					<div class="col-md-12">
						<p align="center"><b><font size="4"> Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
						<b><font size="4">Movment Approval Reports</font></b></p>		
					</div>
					<hr>
					
					<div style="overflow-y: auto;" class="col-md-12">
						<table id="tblExport" class="table table-bordered" cellspacing="0">
							<thead>
								<tr> 
									<td rowspan="2" style="background-color:#f2eaea;"><b><div style="width:50px">Emp Id</div></b></td>
									<td rowspan="2" style="background-color:#f2eaea;"><b><div style="width:150px">Employee Name</div></b></td>
									<td rowspan="2" style="background-color:#f2eaea;"><b><div style="width:115px">Application Date</div></b></td>
									<td rowspan="2" style="background-color:#f2eaea;"><b><div style="width:115px">Departure Date</div></b></td>
									<td rowspan="2" style="background-color:#f2eaea;"><b><div style="width:115px">Arrival Date</div></b></td>
									<td rowspan="2" style="background-color:#f2eaea;"><b>Day</b></td>
									<td rowspan="2" style="background-color:#f2eaea;"><b><div style="width:250px">Destination</div></b></td>
									<td rowspan="2" style="background-color:#f2eaea;"><b><div style="width:250px">Purpouse</div></b></td>
									<td colspan="4" align="center" style="background-color:#96bbd1;"><b>Sub-Supervisor</b></td>
									<td colspan="4" align="center" style="background-color:#c0e3f7;"><b>Supervisor</b></td>
								</tr>
								<tr>
									<td style="background-color:#96bbd1;"><b><div style="width:175px">Sub Supervisor</div></b></td>
									<td style="background-color:#96bbd1;"><b><div style="width:115px">Action Date</div></b></td>
									<td style="background-color:#96bbd1;"><b>Action</b></td>
									<td style="background-color:#96bbd1;"><b>Remarks</b></td>
									<td style="background-color:#c0e3f7;"><b><div style="width:175px">Supervisor</div></b></td>
									<td style="background-color:#c0e3f7;"><b><div style="width:115px">Action Date</div></b></td>
									<td style="background-color:#c0e3f7;"><b>Actions</b></td>
									<td style="background-color:#c0e3f7;"><b>Remarks</b></td>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; if(!empty($all_result)) {
								foreach($all_result as $result) { ?>
								<tr> 
									<td><?php echo $result->emp_id; ?></td>
									<td><?php echo $result->emp_name_eng; ?></td>
									<td><?php echo  date("d-m-Y",strtotime($result->application_date)); ?></td>
									<td><?php echo  date("d-m-Y",strtotime($result->from_date)); ?></td>
									<td><?php echo  date("d-m-Y",strtotime($result->to_date)); ?></td>
									<td><?php 			
													$letter_date 	= date('Y-m-d');				
													date_default_timezone_set('Asia/Dhaka');
													$from_date = new DateTime($result->from_date);
													$to_date = new DateTime($result->to_date);	
													$difference = date_diff($to_date, $from_date);
													echo $difference->d + 1; 
												?>
									</td>
									<td>
									<?php  if($result->visit_type == 1){
											$destination_code = explode(',',$result->destination_code);
											$i = 1;
											foreach ($branch_list as $branch){
												if (in_array($branch->br_code, $destination_code)){
													if($i == 1){
														echo $branch->branch_name; 
													}else{
														echo ', '.$branch->branch_name;
													}
													$i++;
												}
											}
										}else{
											echo $result->destination_code;
										}  
									?>
									
									</td> 
									<td><?php echo wordwrap($result->purpose,100,"<br>\n"); ?></td>								
									<td><?php  if(!empty($result->visit_sub_supervisors_emp_id)) { echo $result->sub_emp_name.'  <br/>('.$result->first_super_emp_id.')'; } ?></td>	
									<td><?php if(!empty($result->visit_sub_supervisors_emp_id)) { echo  date("d-m-Y",strtotime($result->first_super_action_date)); } ?></td>	
									<td><?php  if(!empty($result->visit_sub_supervisors_emp_id)) { if($result->first_super_action == 1) { echo 'Recomended'; } else {  echo 'Rejected'; } } ?></td>	
									<td><?php echo $result->first_super_remarks; ?></td>	
									<td><?php if($result->super_action != 0 ) { echo $result->sup_emp_name.'  <br/>('.$result->super_emp_id.')'; } ?></td>	
									<td><?php if($result->super_action != 0 ) { echo  date("d-m-Y",strtotime($result->super_action_date)); }?></td>	
									<td><?php if($result->super_action == 1) { echo 'Approved'; } else if($result->super_action == 2)  {  echo 'Rejected'; } ?></td>	
									<td><?php echo $result->super_remarks; ?></td>	
								</tr>
								<?php } } else { ?>
								<tr>
									<td colspan="17" align="center" style="color:blue; "> No Results Found </td>
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
		function set_date()
		{
			var form_date = document.getElementById("form_date").value;
			  document.getElementById("to_date").value = form_date;
			document.getElementById("to_date").min = form_date;
		} 
        //To active  menu.......//
		document.getElementById("activities").value= '<?php echo $activities; ?>';
        $(document).ready(function() {
            $("#MainGroupSelf_Care").addClass('active');
            $("#Visit_Approval_Report").addClass('active'); 
        });

    </script>

@endsection

