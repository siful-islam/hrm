@extends('admin.admin_master')
@section('title', 'Reports|Grade Unnoyon Report')
@section('main_content')
<style>
.content {
	padding-top: 5px;
}
.table-bordered {
    border: 1px solid #757070;
}
.table > thead > tr > th {
    border: 1px solid #757070;
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
	font-weight: bold;
	text-align: left; 
	padding: 2px;
}
.table > tbody > tr > td {
    border: 1px solid #757070;
	padding: 4px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
</style>
<!------export to excel file------->	
<script type="text/javascript" src="{{asset('public/scripts/jquery.table2excel.js')}}"></script>
<!------export to excel file------->
<!-- Content Header (Page header) -->
<br/>
<br/>
<section class="content-header">
	<h1><small><?php echo $data['Heading']; ?></small></h1>
	<!--<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">All Staff List</li>
	</ol>-->
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="{{URL::to('/grade_unnoyon_report')}}" method="POST">
						{{ csrf_field() }}
					
						
						<div class="form-group">
							<label for="email">Select  Grade:</label>
							<select style="width:200px;" class="form-control" id="emp_grade" name="emp_grade" required >						
								<option <?php echo $data['emp_grade']==18?"selected":""; ?> value="18">Grade 18 to 17</option>
								<option <?php echo $data['emp_grade']==17?"selected":""; ?>  value="17">Grade 17 to 16</option>
							</select>
						</div>	
						&nbsp;&nbsp;
						<div class="form-group">
							<label for="current_date">Select  Date:</label>
							<input type="date" class="form-control" id="current_date" name="current_date" value="<?php echo !empty($data['current_date'])?$data['current_date']:date('Y-m-d');?>" required>
						</div>

							
						<button type="submit" class="btn btn-primary" >Search</button>
					
						<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>
						<button type="button" id="btnExport" class="btn btn-primary">Export Excel</button>
					</form>
				</div>
			</div>
        </div>
	</div>
	<?php 
	date_default_timezone_set('Asia/Dhaka');
	if(!empty($data['all_result'])){ 
	?>
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b>
				<br/>		
				<b><font size="4">Staff List(Grade Unnoyon) - Grade-<?php echo $data['emp_grade']; ?></font></b>
				<br/>	
				<b><font size="4">Up-to <?php echo !empty($data['current_date'])?$data['current_date']:""; ?></font></b>
				</p>		
			</div>
			<div class="col-md-12">
				<table id="tblExport" class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>Employee ID</th>
							<th>Sarok No</th>
							<th>Employee Name</th>					
							<th>Designation</th>
							<th>Last Degree</th>
							<th>Joining Date(Org.)</th>
							<th>Present Work Station</th>
							<th>Present Grade </th>
							<th>Grade Effected Date</th>
							<th>Duration(Current Grade)</th>
							<th>Service Length </th>
							
						</tr>
					</thead>
						<tbody>	
							<?php 
									$i=0;
									foreach($data['all_result'] as $value){
										/* echo '<pre>';
										print_r($value);
										echo '</pre>';  */
										
										$org_join_date=new DateTime($value->org_join_date);
										$grade_effect_date=new DateTime($value->grade_effect_date);
										
										$current_date=new DateTime($data['current_date']);
										$difference = date_diff($grade_effect_date, $current_date);
										$service_length = date_diff($org_join_date, $current_date);
										/* echo '<pre>';
										print_r($difference);
										echo '</pre>'; */
										
										if($data['emp_grade']==18){
											if($value->level_id>2 || $value->year>=3){
												$i++;
												
										?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $value->emp_id; ?></td>
												<td><?php echo $value->sarok_no; ?></td>
												<td><?php echo $value->emp_name_eng; ?></td>
												<td><?php echo $value->designation_name; ?></td>
												<td><?php echo $value->emp_exam_name; ?></td>
												<td><?php echo $value->org_join_date; ?></td>
												<td><?php echo $value->branch_name; ?></td>
												<td><?php echo $value->grade_code; ?></td>
												<td><?php echo $value->grade_effect_date; ?></td>
												<td><?php echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days "; ?></td>
												<td><?php echo $service_length->y . " years, " . $service_length->m." months, ".$service_length->d." days "; ?></td>
											</tr>
										<?php 
										}
										}elseif($data['emp_grade']==17){
											if($value->level_id>3 || ($value->level_id>2 && $value->year>=2) || ($value->level_id>1 && $value->year>=3)){
												$i++;
										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $value->emp_id; ?></td>
											<td><?php echo $value->sarok_no; ?></td>
											<td><?php echo $value->emp_name_eng; ?></td>
											<td><?php echo $value->designation_name; ?></td>
											<td><?php echo $value->emp_exam_name; ?></td>
											<td><?php echo $value->org_join_date; ?></td>
											<td><?php echo $value->branch_name; ?></td>
											<td><?php echo $value->grade_code; ?></td>
											<td><?php echo $value->grade_effect_date; ?></td>
											<td><?php echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days "; ?></td>
											<td><?php echo $service_length->y . " years, " . $service_length->m." months, ".$service_length->d." days "; ?></td>
										</tr>
										<?php 
											}
										}
									}
								
								
							?>
									
						
						</tbody>	
				</table>
			</div>
		</div>
	</div>
	<?php } ?>
</section>
<script>

</script>
<!------export to excel file------->
<script>
    $(document).ready(function () {
        $("#btnExport").click(function () {
            $("#tblExport").table2excel({
                exclude:".noExl",
				name:"Staff List",
				filename:"staff_list_"+{{$data['emp_grade']}},
            });
        });
    });
</script>
<!------export to excel file------->
<script language="javascript" type="text/javascript">
    function printDiv(divID) {
		var divToPrint = document.getElementById(divID);
			//document.getElementById('note').style.display = 'block';
		var htmlToPrint = '' +
			'<style type="text/css">' + '.table-bordered th {' +
			'border:1px solid #757070;padding:2px;font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + '.table-bordered td {' +
			'border:1px solid #757070;padding:2px;font: 11px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
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
		//location.reload();
    }
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		
		$("#MainGroupBasic_Reports").addClass('active');
		$("#Grade_Unnoyon_Report").addClass('active');
		
	});
</script>
@endsection