@extends('admin.admin_master')
@section('title','Recruitment Reports')
@section('main_content')
<style>
@media print {
   thead {display: table-header-group;}
}
</style>

	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->				
				
				<form class="form-horizontal" action="{{URL::to($action)}}" method="POST">
                {{ csrf_field() }} 
					<div class="box-body">
						<div class="form-group">
						<label for="post_id" class="col-sm-1 control-label">Zone</label> 
							<div class="col-sm-2">
								<select name="zone_id" id="zone_id" required class="form-control">
										<option value="All">All</option>
										<?php foreach($all_zone as $zone) { ?>
										<option value="<?php echo $zone->id; ?>"><?php echo $zone->division_name; ?></option>
										<?php } ?>
								</select>
							</div>
						<label for="post_id" class="col-sm-1 control-label">Post</label> 
							<div class="col-sm-2">
								<select name="post_id" id="post_id" required class="form-control">
										<option value="All">All</option>
										<?php foreach($all_post as $post) { ?>
										<option value="<?php echo $post->id; ?>"><?php echo $post->post_name; ?></option>
										<?php } ?>
								</select>
							</div> 
							<label for="district_code" class="col-sm-1 control-label">District</label> 
							<div class="col-sm-2">
							
								<select name="district_code" id="district_code" required class="form-control">
										<option value="All">All</option>
										<?php foreach($all_districts as $districts) { ?>
										<option value="<?php echo $districts->district_code; ?>"><?php echo $districts->district_name; ?></option>
										<?php } ?>
								</select>
							</div> 
							<div class="col-sm-2">
								<button type="submit"   class="btn btn-danger"><i class="fa fa-eye" aria-hidden="true"></i> Show Report</button>
								<button type="button" onclick="javascript:printDiv('printme')" class="btn btn-default"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
							</div>
						</div>
					</div>
					<!-- /.box-body --->
				</form>
		</div> 
		<?php if(!empty($total_result)){ ?>
		<div id="printme">
		<div class="box box-danger">
			<div class="box-header with-border">			
				<center>
					<h3 class="box-title">Center for Development Innovation and Practices</h3>
					<p>CDIP Bhaban, House No#17, Road No#13, PC Culture Housing Society, Shekhertek, Adabor, Dhaka-1207</p>
					<h4>Recruitment List</h4>
				</center>
				
			</div>
			<?php // foreach ($all_divisions as $divisions){ 
			
				//echo "<p style='padding-left:5px;'><span style='font-weight:bold;'>Exam center:</span> $divisions->division_name</p>";
				echo "<p style='padding-left:5px;'><span style='font-weight:bold;'>Exam center:</span> Head Office</p>";
			?>
			
			<div class="box-body">
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th rowspan="2">SL No.</th>
							<th rowspan="2">Post Name</th>
							<th rowspan="2">Recruitment ID</th> 
							<th rowspan="2">Name</th>
							<th rowspan="2">Father Name</th>
							<th rowspan="2">Age</th>
							<th colspan="3">Last Degree</th>
							<th colspan="3">Experience</th>
							<th rowspan="2">Home District</th>
							<th rowspan="2">Mobile No</th>
							<th rowspan="2">Remarks</th>
						</tr>
						<tr>
							<th>Degree</th>
							<th>CGPA/Div</th>
							<th>Institution</th>
							<th>Position</th>
							<th>Org.</th>
							<th>No. of Years</th>
						</tr>
					</thead>
					<tbody> 
						<?php 
						 $i=1; 
							//foreach ($all_divisions as $divisions){ 
						
						 foreach($total_result as $v_result){
						 // if($v_result['division_code'] == $divisions->id){
						?>
						<tr>
							<td>{{$i++}}</td>
							<td>{{$v_result['post_name']}}</td>
							<td>{{$v_result['new_recruitment_id']}}</td>
							<td>{{$v_result['full_name']}}</td>
							<td>{{$v_result['father_name']}}</td>
							<td>
							<?php //date_default_timezone_set('Asia/Dhaka');
								 date_default_timezone_set('UTC');
								$date1 = new DateTime($v_result['birth_date']); 
								$date3 = new DateTime($v_result['end_date']);						
								$interval = date_diff($date1, $date3); 
								echo $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
								?> 							
							</td> 
							<td>{{$v_result['exam_name']}} </td> 
							<td><?php if($v_result['result'] == 1) echo "1st class"; else if($v_result['result'] == 2) echo "2nd class"; else if($v_result['result'] == 3) echo "3rd class";else if($v_result['result'] == 10) echo $v_result['cgpa'];?></td> 
							<td>{{$v_result['board_uni_name']}} </td>
							<td>{{$v_result['designation']}} </td>
							<td>{{$v_result['organization_name']}} </td> 
							<td>{{$v_result['experience_period']}} </td>  
							<td>{{$v_result['district_name']}} </td>   
							<td>{{$v_result['contact_num']}} </td>   
							<td>{{$v_result['remarks']}} </td>    
						</tr>
						 <?php }
						 //} 
						 ?>
						 <?php //}  ?>
					</tbody>
				</table>
			</div> 
				
		</div>
		</div>
		
		<?php } ?>
		
	</section>
<script language="javascript" type="text/javascript">
$("#district_code").val('<?php echo $district_code;?>');
$("#post_id").val('<?php echo $post_id;?>');
    function printDiv(divID) {
		var divToPrint = document.getElementById(divID);
			//document.getElementById('note').style.display = 'block';
		var htmlToPrint = '' +
			'<style type="text/css">' + '.table-bordered th {' +
			'border:1px solid #757070;padding:2px;font: 16px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + '.table-bordered td {' +
			'border:1px solid #757070;padding:2px;font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + 'table {' +
			'border-collapse: collapse;' +
			'width:100%;' +
			'}' + 'body {' +
			'margin-left: 10px;' +
			'}' +  
			'</style>';
		htmlToPrint += divToPrint.outerHTML;
		newWin = window.open("");
		newWin.document.write(htmlToPrint);
		newWin.print();
		newWin.close(); 
    }
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupBasic_Reports").addClass('active');
		$("#Recruitment_Reports").addClass('active');
	});
</script>
@endsection