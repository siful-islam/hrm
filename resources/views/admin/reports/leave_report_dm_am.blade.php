@extends('admin.admin_master')
@section('title', 'Leave Report DM & AM')
@section('main_content')
<style>
@media print
{
  #footer {
    display: block; 
    position: fixed; 
    bottom: 0;
  } 
}
</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Leave<small>Report</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Leave</a></li>
			<li class="active">Report</li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content">
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
				<form class="form-horizontal" action="{{URL::to($action)}}" method="POST">
                  {{csrf_field()}}  
					<div class="box-body">
						<div class="form-group">  
							<label for="to_date" class="col-sm-1 control-label">Area :</label>
							<div class="col-sm-2">
								<select name="area_code" id="area_code" onchange="change_area_to_branch()" class="form-control"  required>
									<option value="all_a">All</option>
									<?php foreach($all_area as $v_area){?>
											<option value="<?php echo  $v_area->area_code;?>"><?php echo $v_area->area_name;?></option>
									<?php } ?>  
								</select>  
							</div> 
							<label for="to_date" class="col-sm-1 control-label">Branch :</label>
							<div class="col-sm-2">
								<select name="branch_code" id="branch_code"  class="form-control">  
											<option value="">--Select--</option>
											<?php 
											if($all_branch){ 
											foreach($all_branch as $v_all_branch){?>
												<option value="<?php echo $v_all_branch->br_code; ?>"><?php echo $v_all_branch->branch_name; ?></option>
											<?php }} ?>
								</select>  
							</div> 
							<label for="to_date" class="col-sm-1 control-label">Financial Year:</label>
							<div class="col-sm-2">
								<select name="f_year_id" id="f_year_id" class="form-control"  required> 
									
									<?php foreach($all_fy as $v_fy){?>
												<option value="<?php echo  $v_fy->id;?>"><?php echo  date('Y',strtotime($v_fy->f_year_from)).'-'.date('Y',strtotime($v_fy->f_year_to));?></option>
											<?php } ?>  
								</select>  
							</div> 
							<div class="col-sm-3">
								<button type="submit"  class="btn btn-danger"><i class="fa fa-search" aria-hidden="true"></i> Show Report</button>
								<button type="button" onclick="javascript:printDiv('printme')" class="btn btn-default"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
							</div>
						</div>
					</div>
					<!-- /.box-body --->
				</form>
				 @if(!empty($all_report))
				<div id="printme" class="box box-danger">
					<div class="box-header with-border">			
						<center>
							<h3 class="box-title">Center for Development Innovation and Practices</h3>
							<p>CDIP Bhaban, House No#17, Road No#13, PC Culture Housing Society, Shekhertek, Adabor, Dhaka-1207</p>
							<h4><span align="center" style="font-size:16px;font-weight:bold; color:#800000; "><u>Employee  Leave information</u></span></h4>
							
						</center>
						
					</div>
					<div class="box-body"> 
						<div style="width:95%;margin:auto;" >
							<table    style="width:100%;">
								<thead> 
									<tr>
										<th style="width:25%;text-align:right;">Fiscal Year : <?php foreach($all_fy as $v_fy){?>
										<?php if($v_fy->id == $f_year_id)  { echo  date('Y',strtotime($v_fy->f_year_from)).'-'.date('Y',strtotime($v_fy->f_year_to)); } }?> 
											 </th>
									</tr>
								</thead>
							</table>
						</div>
						<?php if($area_code != 'all_a'){ ?>
									<table id="footer" class="report" cellspacing="0" style="width:95%;margin:auto;">  
										<tbody>
											<tr>
												<th rowspan="2" style="border:1px solid black;"><div align="center">SL No.</div></th>
												<th rowspan="2" style="border:1px solid black;"><div align="center">Branch name</div></th>
												<th rowspan="2" style="border:1px solid black;"><div align="center">Employee name</div></th>
												<th rowspan="2" style="border:1px solid black;"><div align="center">Designation</div></th>
												<th rowspan="2" style="border:1px solid black;"><div align="center">Emp ID</div></th> 
												<th colspan="2" style="border:1px solid black;"><div align="center">Leave Date</div></th> 
												<th rowspan="2" style="border:1px solid black;"><div align="center">Days</div></th>
												<th rowspan="2" style="border:1px solid black;"><div align="center">Serial No</div></th>   
												<th rowspan="2" style="border:1px solid black;"><div align="center">Adjustment</div></th>   
												<th rowspan="2" style="border:1px solid black;"><div align="center">Remarks</div></th> 
											</tr>
											<tr>
												<th style="border:1px solid black;">From</th>
												<th style="border:1px solid black;">To</th>
											</tr>
											<?php 
											$total_leave = 0;  
											$sl = 1;  
											
											 /*  echo '<pre>'; 
												print_r($all_report);
												exit;  */
											if(!empty($all_report)){ 
											
											$count_array_branch = array_map('next',$all_report); 
											$count_array = array_map('current',$all_report) ;
											
											$count_value = array_count_values($count_array);
											$count_value_branch = array_count_values($count_array_branch); 
												$pre_emp_id_u = '';
												$pre_branch_code = '';
												foreach ($all_report as $leaveinfo) {
													if($leaveinfo['branch_code'] != $pre_branch_code){ ?>
											<?php		$total_leave += $leaveinfo['no_of_days_appr'];
													//print_r($dd[$leaveinfo['emp_id_u']]);
													if($leaveinfo['emp_id_u'] != $pre_emp_id_u){
														?>
														<tr style="text-align:center;">                                    
														  <td style="width:5%;border:1px solid black;"><?php echo $sl++; ?></td>   
														  <td style="width:10%;border:1px solid black;" rowspan="<?php echo $count_value_branch[$leaveinfo['branch_code']];?>"  ><?php echo $leaveinfo['branch_name']; ?></td>
														  <td style="width:10%;border:1px solid black;" rowspan="<?php echo $count_value[$leaveinfo['emp_id_u']];?>" ><?php echo $leaveinfo['emp_name']; ?></td>
														  <td style="width:10%;border:1px solid black;" rowspan="<?php echo $count_value[$leaveinfo['emp_id_u']];?>" ><?php echo $leaveinfo['designation_name']; ?></td>
														  <td style="width:5%;border:1px solid black;" rowspan="<?php echo $count_value[$leaveinfo['emp_id_u']];?>"><?php echo $leaveinfo['emp_id']; ?></td> 
														  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo['appr_from_date'])); ?></td>
														  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo['appr_to_date'])); ?></td> 
														  <td style="width:5%;border:1px solid black;"><?php echo $leaveinfo['no_of_days_appr']; ?></td>
														  <td style="width:5%;border:1px solid black;"><?php echo $leaveinfo['serial_no']; ?></td>
														  <td style="width:5%;border:1px solid black;"><?php if($leaveinfo['leave_adjust'] == 1) echo "Current"; else if($leaveinfo['leave_adjust'] == 2) echo  "Previous"; ?></td>
														  <td style="width:20%;text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo['remarks']; ?>  </td>
														</tr>
												<?php  }else{ ?>
															<tr style="text-align:center;">                                    
															  <td style="width:5%;border:1px solid black;"><?php echo $sl++; ?></td>    
															  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo['appr_from_date'])); ?></td>
															  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo['appr_to_date'])); ?></td> 
															  <td style="width:5%;border:1px solid black;"><?php echo $leaveinfo['no_of_days_appr']; ?></td>
															  <td style="width:5%;border:1px solid black;"><?php echo $leaveinfo['serial_no']; ?></td>
															  <td style="width:5%;border:1px solid black;"><?php if($leaveinfo['leave_adjust'] == 1) echo "Current"; else if($leaveinfo['leave_adjust'] == 2) echo  "Previous"; ?></td>
															  <td style="width:20%;text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo['remarks']; ?>  </td>
															</tr>
												<?php   }   $pre_emp_id_u = $leaveinfo['emp_id_u'];?>
									
												<?php 	}else{ ?>
														
											<?php		$total_leave += $leaveinfo['no_of_days_appr'];
													//print_r($dd[$leaveinfo['emp_id_u']]);
													if($leaveinfo['emp_id_u'] != $pre_emp_id_u){
														?>
													<tr style="text-align:center;">                                    
													  <td style="width:5%;border:1px solid black;"><?php echo $sl++; ?></td>    
													  <td style="width:10%;border:1px solid black;" rowspan="<?php echo $count_value[$leaveinfo['emp_id_u']];?>" ><?php echo $leaveinfo['emp_name']; ?></td>
													  <td style="width:10%;border:1px solid black;" rowspan="<?php echo $count_value[$leaveinfo['emp_id_u']];?>" ><?php echo $leaveinfo['designation_name']; ?></td>
													  <td style="width:5%;border:1px solid black;" rowspan="<?php echo $count_value[$leaveinfo['emp_id_u']];?>"><?php echo $leaveinfo['emp_id']; ?></td> 
													  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo['appr_from_date'])); ?></td>
													  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo['appr_to_date'])); ?></td> 
													  <td style="width:5%;border:1px solid black;"><?php echo $leaveinfo['no_of_days_appr']; ?></td>
													  <td style="width:5%;border:1px solid black;"><?php echo $leaveinfo['serial_no']; ?></td>
													  <td style="width:5%;border:1px solid black;"><?php if($leaveinfo['leave_adjust'] == 1) echo "Current"; else if($leaveinfo['leave_adjust'] == 2) echo  "Previous"; ?></td>
													  <td style="width:20%;text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo['remarks']; ?>  </td>
													</tr>
											<?php  }else{ ?>
														<tr style="text-align:center;">                                    
														  <td style="width:5%;border:1px solid black;"><?php echo $sl++; ?></td>    
														  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo['appr_from_date'])); ?></td>
														  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo['appr_to_date'])); ?></td> 
														  <td style="width:5%;border:1px solid black;"><?php echo $leaveinfo['no_of_days_appr']; ?></td>
														  <td style="width:5%;border:1px solid black;"><?php echo $leaveinfo['serial_no']; ?></td>
														  <td style="width:5%;border:1px solid black;"><?php if($leaveinfo['leave_adjust'] == 1) echo "Current"; else if($leaveinfo['leave_adjust'] == 2) echo  "Previous"; ?></td>
														  <td style="width:20%;text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo['remarks']; ?>  </td>
														</tr>
											<?php   }   $pre_emp_id_u = $leaveinfo['emp_id_u'];?>
									
														
														
											<?php 	}  $pre_branch_code = $leaveinfo['branch_code']; ?>
											
									
									<?php }  } ?>
										</tbody>
									</table>
									
								<?php }else{ 
								
									foreach($all_area as $v_all_area){ 
									
										 
									?>
										<table id="footer" class="report" cellspacing="0" style="width:95%;margin:auto;"> 
										<?php  
								
									 
									
										echo "<p style='padding-left:2%;font-weight:bold;'>Area Name: ".$v_all_area->area_name."</p>";
									?>
												<tbody>
													<tr>
														<th rowspan="2" style="border:1px solid black;"><div align="center">SL No.</div></th>
														<th rowspan="2" style="border:1px solid black;"><div align="center">Branch name</div></th>
														<th rowspan="2" style="border:1px solid black;"><div align="center">Employee name</div></th>
														<th rowspan="2" style="border:1px solid black;"><div align="center">Designation</div></th>
														<th rowspan="2" style="border:1px solid black;"><div align="center">Emp ID</div></th> 
														<th colspan="2" style="border:1px solid black;"><div align="center">Leave Date</div></th> 
														<th rowspan="2" style="border:1px solid black;"><div align="center">Days</div></th>
														<th rowspan="2" style="border:1px solid black;"><div align="center">Serial No</div></th>   
														<th rowspan="2" style="border:1px solid black;"><div align="center">Adjustment</div></th>   
														<th rowspan="2" style="border:1px solid black;"><div align="center">Remarks</div></th> 
													</tr>
													<tr>
														<th style="border:1px solid black;">From</th>
														<th style="border:1px solid black;">To</th>
													</tr>
													<?php 
													$total_leave = 0;  
													$sl = 1;  
													
													 /*  echo '<pre>'; 
														print_r($all_report);
														exit;  */
													if(!empty($all_report)){ 
													
													$count_array_branch = array_map('next',$all_report); 
													$count_array = array_map('current',$all_report) ;
													
													$count_value = array_count_values($count_array);
													$count_value_branch = array_count_values($count_array_branch); 
														$pre_emp_id_u = '';
														$pre_branch_code = '';
														foreach ($all_report as $leaveinfo) {
															if($leaveinfo['area_code'] == $v_all_area->area_code){
															if($leaveinfo['branch_code'] != $pre_branch_code){ ?>
													<?php		$total_leave += $leaveinfo['no_of_days_appr'];
															//print_r($dd[$leaveinfo['emp_id_u']]);
															if($leaveinfo['emp_id_u'] != $pre_emp_id_u){
																?>
																<tr style="text-align:center;">                                    
																  <td style="width:5%;border:1px solid black;"><?php echo $sl++; ?></td>   
																  <td style="width:10%;border:1px solid black;" rowspan="<?php echo $count_value_branch[$leaveinfo['branch_code']];?>"  ><?php echo $leaveinfo['branch_name']; ?></td>
																  <td style="width:10%;border:1px solid black;" rowspan="<?php echo $count_value[$leaveinfo['emp_id_u']];?>" ><?php echo $leaveinfo['emp_name']; ?></td>
																  <td style="width:10%;border:1px solid black;" rowspan="<?php echo $count_value[$leaveinfo['emp_id_u']];?>" ><?php echo $leaveinfo['designation_name']; ?></td>
																  <td style="width:5%;border:1px solid black;" rowspan="<?php echo $count_value[$leaveinfo['emp_id_u']];?>"><?php echo $leaveinfo['emp_id']; ?></td> 
																  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo['appr_from_date'])); ?></td>
																  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo['appr_to_date'])); ?></td> 
																  <td style="width:5%;border:1px solid black;"><?php echo $leaveinfo['no_of_days_appr']; ?></td>
																  <td style="width:5%;border:1px solid black;"><?php echo $leaveinfo['serial_no']; ?></td>
																  <td style="width:5%;border:1px solid black;"><?php if($leaveinfo['leave_adjust'] == 1) echo "Current"; else if($leaveinfo['leave_adjust'] == 2) echo  "Previous"; ?></td>
																  <td style="width:20%;text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo['remarks']; ?>  </td>
																</tr>
														<?php  }else{ ?>
																	<tr style="text-align:center;">                                    
																	  <td style="width:5%;border:1px solid black;"><?php echo $sl++; ?></td>    
																	  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo['appr_from_date'])); ?></td>
																	  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo['appr_to_date'])); ?></td> 
																	  <td style="width:5%;border:1px solid black;"><?php echo $leaveinfo['no_of_days_appr']; ?></td>
																	  <td style="width:5%;border:1px solid black;"><?php echo $leaveinfo['serial_no']; ?></td>
																	  <td style="width:5%;border:1px solid black;"><?php if($leaveinfo['leave_adjust'] == 1) echo "Current"; else if($leaveinfo['leave_adjust'] == 2) echo  "Previous"; ?></td>
																	  <td style="width:20%;text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo['remarks']; ?>  </td>
																	</tr>
														<?php   }   $pre_emp_id_u = $leaveinfo['emp_id_u'];?>
											
														<?php 	}else{ ?>
																
													<?php		$total_leave += $leaveinfo['no_of_days_appr'];
															//print_r($dd[$leaveinfo['emp_id_u']]);
															if($leaveinfo['emp_id_u'] != $pre_emp_id_u){
																?>
															<tr style="text-align:center;">                                    
															  <td style="width:5%;border:1px solid black;"><?php echo $sl++; ?></td>    
															  <td style="width:10%;border:1px solid black;" rowspan="<?php echo $count_value[$leaveinfo['emp_id_u']];?>" ><?php echo $leaveinfo['emp_name']; ?></td>
															  <td style="width:10%;border:1px solid black;" rowspan="<?php echo $count_value[$leaveinfo['emp_id_u']];?>" ><?php echo $leaveinfo['designation_name']; ?></td>
															  <td style="width:5%;border:1px solid black;" rowspan="<?php echo $count_value[$leaveinfo['emp_id_u']];?>"><?php echo $leaveinfo['emp_id']; ?></td> 
															  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo['appr_from_date'])); ?></td>
															  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo['appr_to_date'])); ?></td> 
															  <td style="width:5%;border:1px solid black;"><?php echo $leaveinfo['no_of_days_appr']; ?></td>
															  <td style="width:5%;border:1px solid black;"><?php echo $leaveinfo['serial_no']; ?></td>
															  <td style="width:5%;border:1px solid black;"><?php if($leaveinfo['leave_adjust'] == 1) echo "Current"; else if($leaveinfo['leave_adjust'] == 2) echo  "Previous"; ?></td>
															  <td style="width:20%;text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo['remarks']; ?>  </td>
															</tr>
													<?php  }else{ ?>
																<tr style="text-align:center;">                                    
																  <td style="width:5%;border:1px solid black;"><?php echo $sl++; ?></td>    
																  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo['appr_from_date'])); ?></td>
																  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo['appr_to_date'])); ?></td> 
																  <td style="width:5%;border:1px solid black;"><?php echo $leaveinfo['no_of_days_appr']; ?></td>
																  <td style="width:5%;border:1px solid black;"><?php echo $leaveinfo['serial_no']; ?></td>
																  <td style="width:5%;border:1px solid black;"><?php if($leaveinfo['leave_adjust'] == 1) echo "Current"; else if($leaveinfo['leave_adjust'] == 2) echo  "Previous"; ?></td>
																  <td style="width:20%;text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo['remarks']; ?>  </td>
																</tr>
													<?php   }   $pre_emp_id_u = $leaveinfo['emp_id_u'];?>
											
																
																
													<?php 	}  $pre_branch_code = $leaveinfo['branch_code']; ?>
													
											
											<?php } } } ?>
												</tbody>
											</table>
											<br>
									<br>
								<?php	
									}
								?>
											
											
								<?php  } ?>
						
						
						<br>
						<br>  
				  </div> 
				</div>
				@endif
				
				
		</div>
	</section> 
<script type="text/javascript"> 
function change_area_to_branch(){  
	var area_code = document.getElementById("area_code").value; 
	//alert(area_code); 
	 if(area_code != 'all_a'){
		$.ajax({
			type: "GET",
			dataType: 'json',
			url : "{{URL::to('change_area_to_branch')}}"+"/"+area_code, 
			success: function(data)
			{
				 var t_row = "<option value=''>--Select--</option>";
				 for(var x in data["data"]) {
						  t_row += "<option value="+data["data"][x]["br_code"]+">"+data["data"][x]["branch_name"]+"</option>";
						
						//alert(data["data"][x]["branch_name"]);
					} 
					  $('#branch_code').html(t_row); 
				//alert(t_row);
				console.log(data);
				
			}
		});
	}else{
		 $('#branch_code').html("<option value=''>--Select--</option>"); 
	}
	
		   
}
document.getElementById("area_code").value = '<?php echo $area_code; ?>';
document.getElementById("branch_code").value = '<?php echo $branch_code; ?>';
document.getElementById("f_year_id").value = '<?php echo $f_year_id; ?>';
function printDiv(divID) {
    var divToPrint = document.getElementById(divID);
    var htmlToPrint = '' +
        '<style type="text/css">'+'.with_pay_color {' +
        'background-color:none !important;color:black !important;' + 
        '}' + '.margin_left {' +
        'margin: auto;width:45%;padding-left:50px !important;' + 
        '}' +  'table {' +
        'border-collapse: collapse;' + 
        '}' + 'body {' +
        'width:100%;'+
        '}' +
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close(); 
   } 
$(document).ready(function() {
	$('.common_date').datepicker({dateFormat: 'yy-mm-dd'});
	//$('#to_date').datepicker({dateFormat: 'yy-mm-dd'}); 
});
</script>
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee_Leave").addClass('active');
			//$("#Add_Leave").addClass('active');
			$('[id^=Leave_Report_DM_]').addClass('active');
		});
	</script>
@endsection