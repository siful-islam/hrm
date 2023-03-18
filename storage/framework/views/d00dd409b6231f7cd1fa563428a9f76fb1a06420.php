
<?php $__env->startSection('title', 'Employee Visit Report'); ?>
<?php $__env->startSection('main_content'); ?> 
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee Visit<small>Report</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Employee Visit</a></li>
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
				<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" method="POST">
                  <?php echo e(csrf_field()); ?>  
					<div class="box-body">
						<div class="form-group">  
							<label for="from_date" class="col-sm-1 control-label">Date From:</label>
							<div class="col-sm-2"> 
								<input type="date" class="form-control"  onchange="set_date()" name="from_date" id="from_date" value="<?php echo $from_date; ?>" required/> 
							</div> 
							<label for="to_date" class="col-sm-1 control-label">Date To:</label>
							<div class="col-sm-2"> 
								<input type="date" class="form-control"  name="to_date" id="to_date" value="<?php echo $to_date; ?>" min="<?php echo $from_date; ?>" required/> 
							</div> 
							<label for="br_code" class="col-sm-1 control-label">Branch:</label>
							<div class="col-sm-2"> 
								<select name="br_code" id="br_code" class="form-control">
								 <option value="all">ALL</option>
								<?php foreach($all_branch as $v_all_branch){ ?> 
								  <option value="<?php echo $v_all_branch->br_code; ?>"><?php echo $v_all_branch->branch_name; ?></option>
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
				 <?php if(!empty($all_report)): ?>
				<div id="printme" class="box box-danger">
					<div class="box-header with-border">			
						<center>
							<h3 class="box-title">Centre for Development Innovation and Practices</h3>
							<p>CDIP Bhaban, House No#17, Road No#13, PC Culture Housing Society, Shekhertek, Adabor, Dhaka-1207</p>
							<h4><span align="center" style="font-size:16px;font-weight:bold; color:#800000; "><u>Employee  Visit information</u></span></h4> 
						</center>
						
					</div>
					<div class="box-body"> 
						<div class="row">
							<div style="overflow-y: auto;" class="col-md-12">  
						   
								 <table   class="report" border="1" cellspacing="0" style="width:100%;margin:auto;">  
										<thead>
											<tr>
												<th><div align="left" style="width:30px">SL</div></th>
												<th><div align="left" style="width:175px">Employee Name</div></th>  
												<th><div align="left" style="width:100px">Employee ID</div></th>
												<th><div align="left" style="width:100px">Designation</div></th>
												<th><div align="left" style="width:100px">Branch</div></th>  
												<th><div align="left" style="width:200px">Purpose</div></th>  
												<th><div align="left" style="width:200px">Destination</div></th>  
												<th><div align="left" style="width:110px">Departure Date</div></th>  
												<th><div align="left" style="width:110px">Departure Time</div></th>  
												<th><div align="left" style="width:110px">Return Date</div></th>  
												<th><div align="left" style="width:110px">Return Time</div></th> 
												<th><div align="left" style="width:150px">Return Date(Actual)</div></th>  
												<th><div align="left" style="width:150px">Return Time(Actual)</div></th>  
												<th><div align="center" style="width:40px">Day/s</div></th>  
												<th><div align="center" style="width:85px">Total Days</div></th>  
											</tr>
										</thead>
											<tbody>
											<?php  
												$sl = 1; 
													$pre_emp_id ='';
											foreach ($all_report as $report) { 
											if($report['total_row'] == 1){?>
												<tr>                                    
												  <td style="padding-left:2px;"><?php echo $sl++; ?></td>   
												  <td style="padding-left:2px;"><?php echo $report['emp_name']; ?></td>
												  <td style="padding-left:2px;"><?php echo $report['emp_id']; ?></td>
												  <td style="padding-left:2px;"><?php echo $report['designation_name']; ?></td> 
												  <td style="padding-left:2px;"><?php echo $report['branch_name']; ?></td> 
												  <td style="padding-left:2px;"><?php echo wordwrap($report['purpose'],130,"<br>\n"); ?></td> 
												  <td style="padding-left:2px;">
												  <?php  if($report['visit_type'] == 1){
													$destination_code = explode(',',$report['destination_code']);
													$i = 1;
													$branch_name ='';
													foreach ($branch_list as $branch){
														if (in_array($branch->br_code, $destination_code)){
															if($i == 1){
																 $branch_name .= $branch->branch_name; 
															}else{
																$branch_name .= ', '.$branch->branch_name;
															}
															$i++;
														}
													}
													echo wordwrap($branch_name,130,"<br>\n");
												}else{ 
													echo wordwrap($report['destination_code'],130,"<br>\n");
												}  
											?>
												  
												  
												  </td>
												  <td style="padding-left:2px;"><?php echo date("d-m-Y",strtotime($report['from_date'])); ?></td>
												  <td style="padding-left:2px;"><?php echo $report['leave_time']; ?></td>
												  <td style="padding-left:2px;"><?php echo date("d-m-Y",strtotime($report['to_date'])); ?></td>  
												  <td style="padding-left:2px;"><?php echo $report['arrival_time']; ?></td>
												  <td style="padding-left:2px;"><?php echo date("d-m-Y",strtotime($report['arrival_date'])); ?></td> 
												  <td style="padding-left:2px;"><?php echo $report['return_time']; ?></td>
												  <td style="padding-left:2px;"><?php echo $report['tot_day']; ?></td>
												  <td style="padding-left:2px;"><?php echo $report['tot_tot_day']; ?></td>
												</tr>
											<?php 
												}else{
													if($report['emp_id'] != $pre_emp_id){?>
														<tr     >                                    
														  <td style="padding-left:2px;" rowspan="<?php echo $report['total_row']; ?>"><?php echo $sl++; ?></td>   
														  <td style="padding-left:2px;" rowspan="<?php echo $report['total_row']; ?>"><?php echo $report['emp_name']; ?></td>
														  <td style="padding-left:2px;" rowspan="<?php echo $report['total_row']; ?>"><?php echo $report['emp_id']; ?></td>
														  <td style="padding-left:2px;" rowspan="<?php echo $report['total_row']; ?>"><?php echo $report['designation_name']; ?></td> 
														  <td style="padding-left:2px;" rowspan="<?php echo $report['total_row']; ?>"><?php echo $report['branch_name']; ?></td>
														  <td style="padding-left:2px;"><?php echo wordwrap($report['purpose'],130,"<br>\n"); ?></td>
														  <td style="padding-left:2px;"><?php  if($report['visit_type'] == 1){
																	$destination_code = explode(',',$report['destination_code']);
																	$i = 1;
																	$branch_name ='';
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
																	echo wordwrap($branch_name,130,"<br>\n");
																}else{
																	echo wordwrap($report['destination_code'],130,"<br>\n"); 
																}  
															?>
														</td>
														  <td style="padding-left:2px;"><?php echo date("d-m-Y",strtotime($report['from_date'])); ?></td>
														<td style="padding-left:2px;"><?php echo $report['leave_time']; ?></td>
														<td style="padding-left:2px;"><?php echo date("d-m-Y",strtotime($report['to_date'])); ?></td>  
														 <td style="padding-left:2px;"><?php echo $report['arrival_time']; ?></td>
														  <td style="padding-left:2px;"><?php echo date("d-m-Y",strtotime($report['arrival_date'])); ?></td>
														   <td style="padding-left:2px;"><?php echo $report['return_time']; ?></td>
														  
														  <td style="padding-left:2px;"><?php echo $report['tot_day']; ?></td>
														  <td style="padding-left:2px;" rowspan="<?php echo $report['total_row']; ?>" ><?php echo $report['tot_tot_day']; ?></td>
														</tr>	
												<?php 	}else{?>
														<tr> 
															 <td style="padding-left:2px;"><?php echo wordwrap($report['purpose'],130,"<br>\n"); ?></td>
															<td style="padding-left:2px;"><?php  if($report['visit_type'] == 1){
																	$destination_code = explode(',',$report['destination_code']);
																	$i = 1;
																	$branch_name ='';
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
																	echo wordwrap($branch_name,130,"<br>\n");
																}else{
																	echo wordwrap($report['destination_code'],130,"<br>\n"); 
																}  
															?>
															</td>
														  <td style="padding-left:2px;"><?php echo date("d-m-Y",strtotime($report['from_date'])); ?></td>
														  <td style="padding-left:2px;"><?php echo $report['leave_time']; ?></td>
														<td style="padding-left:2px;"><?php echo date("d-m-Y",strtotime($report['to_date'])); ?></td>  
														 <td style="padding-left:2px;"><?php echo $report['arrival_time']; ?></td>
														  <td style="padding-left:2px;"><?php echo date("d-m-Y",strtotime($report['arrival_date'])); ?></td>
														  <td style="padding-left:2px;"><?php echo $report['return_time']; ?></td>
														  <td style="padding-left:2px;"><?php echo $report['tot_day']; ?></td>
														   
														</tr>	
												<?php	}  
													} $pre_emp_id = $report['emp_id'];
												} ?>
											
										</tbody>
									</table> 
						</div>
					</div>
				</div> 
			</div>
				<?php endif; ?>
				
				
		</div>
	</section> 
<script>
function set_date(){
	var from_date = document.getElementById('from_date').value; 
	document.getElementById('to_date').setAttribute("min", from_date);
}

function moveScroll(){
		var scroll = $(window).scrollTop();
		var anchor_top = $("#maintable").offset().top;
		var anchor_bottom = $("#bottom_anchor").offset().top;
		if (scroll>anchor_top && scroll<anchor_bottom) {
		clone_table = $("#clone");
		if(clone_table.length == 0){
			clone_table = $("#maintable").clone();
			clone_table.attr('id', 'clone');
			clone_table.css({position:'fixed',
					 'pointer-events': 'none',
					 top:60});
			clone_table.width($("#maintable").width());
			$("#table-container").append(clone_table);
			$("#clone").css({visibility:'hidden'});
			$("#clone thead").css({visibility:'visible'});
		}
		} else {
		$("#clone").remove();
		}
	}
	$(window).scroll(moveScroll);
</script>
<script type="text/javascript"> 


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

document.getElementById("br_code").value = '<?php echo $br_code; ?>';
$(document).ready(function() {
	$('.common_date').datepicker({dateFormat: 'yy-mm-dd'});
	//$('#to_date').datepicker({dateFormat: 'yy-mm-dd'}); 
});
</script>
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee_Leave").addClass('active');
			//$("#Leave_Report")
			$("#Visit_Report").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>