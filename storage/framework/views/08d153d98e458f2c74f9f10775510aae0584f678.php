
<?php $__env->startSection('title', 'View Experience Certificate'); ?>
<?php $__env->startSection('main_content'); ?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Approved<small>leave</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Leave</a></li>
			<li class="active">Approved</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
						<div class="form-group"> 
							 
							<div class="pull-right"> 
							 <input type="checkbox" name="is_pad" onclick="check_is_pad()" id="is_pad" value="1"> Use Pad ? &nbsp;&nbsp;&nbsp;
								<button type="button" onclick="javascript:printDiv('printme')" class="btn btn-default"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
							</div>
						</div>
			</div> 
			<?php if(!empty($employee_his)){?> 
				<div id="printme"  class="box box-danger" style="width:90%;margin:auto;">
					<div class="box-header with-border">			
						<center style="text-align:justfy;text-justify: inter-word;" id="with_header" > 
						<span class="box-title" style="text-align:left;" >
						<img src="<?php echo e(asset(Session::get('org_logo'))); ?>" style="float:left;margin-top:0%;" width="78" >
						</span>
						
							<span class="box-title" style="text-align:justify; text-justify: inter-word;" >
								<span style="font-size:20px;"> সেন্টার ফর ডেভেলপমেন্ট     ইনোভেশন এন্ড প্র্যাকটিসেস ( সিদীপ )  <br></span><span  style="font-size:24px;">Centre for Development Innovation and Practices (CDIP)</span><br>
								<span style="font-size:12px;">সিদীপ ভবন, হাউজ # ১৭, রোড # ১৩, পিসিকালচার হাউজিং সোসাইটি, সেখেরটেক, আদাবর, ঢাকা</span><br>
								<span style="font-size:14px;font-weight:bold; color:#800000; ">web:www.cdipbd.org, Email:info@cdipbd.org, Phone:02-48118633,02-48118634</span>
							</span>  
						</center>
						<hr>
					</div>
						<div  class="box-body"> 
						
							<div class="row"> 
									<div class="col-md-11 col-md-offset-1">
										<div class="form-group"> 
												<div class="col-md-10" style="text-align:justfy;text-justify: inter-word;">
												<br>
												<span class="pull-left"  style="font-size:20px;">
													<?php $ff = date('m/d/Y'); echo date("F d,  Y",strtotime($ff));?>
												</span> 
												<br>
												<br>
												<br>
												<span style="font-size:20px;">
													SL No. <?php echo $serial_no; ?>/<?php echo $ye_ar; ?>
												</span>
												<br>
												<br> 
												<h3 style="text-align:center; font-size:24px;"><u>TO WHOM IT MAY CONCERN</u></h3>
												<br>
												<br>
												<br>
												<span style="text-align: justify;text-justify: inter-word;font-size:20px;">
													This is to certify that <?php if($gender == 'male' || $gender == 'Male' ){ echo 'Mr.'; } else { echo 'Ms.'; }?><b> <?php echo $employee_his->emp_name;?></b>, ID No. <b><?php  echo $employee_his->emp_id;?></b>,  Father's Name: <b><?php echo 'Mr. ';?><?php echo $employee_his->father_name;?></b>, Village-  <b><?php echo $employee_his->vill_road;?></b>, Post-<b><?php echo $employee_his->post_office;?></b>, P.S- <b><?php echo $employee_his->thana_name;?></b>, Dist- <b><?php echo $employee_his->district_name;?></b> joined the organization on <b> <?php echo date("j\<\s\u\p\>S\<\/\s\u\p\> F Y",strtotime($employee_his->joining_date));?> </b> as <b><?php echo $employee_his->pre_designation_name;?></b>
													
													<?php if($employee_his->designation_code == $employee_his->pre_designation_code){?>
														and continued till  <b> <?php echo date("j\<\s\u\p\>S\<\/\s\u\p\> F Y",strtotime('-1 day', strtotime($employee_his->effect_date)));?></b> in the same position.
														<br>
														<br>
														<?php if(($resignation_by =="Self")||($resignation_by =="Organization")) {  if($gender == 'male' || $gender == 'Male' ){ echo 'He'; } else { echo 'She'; } echo " left the organization on "; if($gender == 'male' || $gender == 'Male' ){ echo 'his'; } else { echo 'her'; } echo " own accord." ; }else { if($gender == 'male' || $gender == 'Male' ){ echo 'He'; } else { echo 'She'; } echo " left the organization on "; if($gender == 'male' || $gender == 'Male' ){ echo 'his'; } else { echo 'her'; } echo " own accord." ;} ?>
														
													<?php }else{ ?>
														. Subsequently  <?php if($gender == 'male' || $gender == 'Male' ){ echo 'he'; } else { echo 'She'; }?>  was promoted and lastly worked as <b><?php echo $employee_his->designation_name;?></b>  till  <b> <?php echo date("j\<\s\u\p\>S\<\/\s\u\p\> F Y",strtotime('-1 day', strtotime($employee_his->effect_date)));?></b>.
														<br>
														<br>
														<?php if(($resignation_by =="Self")||($resignation_by =="Organization")) {  if($gender == 'male' || $gender == 'Male' ){ echo 'He'; } else { echo 'She'; } echo " left the organization on "; if($gender == 'male' || $gender == 'Male' ){ echo 'his'; } else { echo 'her'; } echo " own accord." ; }else { if($gender == 'male' || $gender == 'Male' ){ echo 'He'; } else { echo 'She'; } echo " left the organization on "; if($gender == 'male' || $gender == 'Male' ){ echo 'his'; } else { echo 'her'; } echo " own accord." ;} ?>
													<?php } ?>
													
													
													
													<br>
													<br>
													<br>
													<?php if(($resignation_by == "Self")||($resignation_by =="Organization")){?>
													We wish  <?php if($gender == 'male' || $gender == 'Male' ){ echo 'him'; } else { echo 'her'; }?> all the success in life.
													<?php } ?>
													<br>
													<br>
													<br>
													<br>
													<br>
													<br>
													<br>
												</span>	
												<span>	
													<h3>Authorized signature</h3>
													<br> 
												<br>
												<br>
												</span>
												</div>  
										</div> 
									</div> 
								</div>    
						</div> 
					</div> 
					 
			<?php } ?>
		</div>
	</section>
<script>
function check_is_pad(){
	var is_pad = $('#is_pad').prop('checked');
	if(is_pad){ 
		 $("#with_header").html("<br><br><br><br><br>"); 
	}else{
		 $("#with_header").html("<span class='box-title' style='text-align:left;'><img src='<?php echo e(asset(Session::get('org_logo'))); ?>' style='float:left;margin-top:0%;' width='70' ></span><span class='box-title' style='text-align:left;'><span style='font-size:20px;'> সেন্টার ফর ডেভেলপমেন্ট     ইনোভেশন এন্ড প্র্যাকটিসেস ( সিদীপ )  <br></span><span  style='font-size:24px;'>Centre for Development Innovation and Practices(CDIP)</span><br><span style='font-size:12px;'>সিদীপ ভবন, হাউজ # ১৭, রোড # ১৩, পিসিকালচার হাউজিং সোসাইটি, সেখেরটেক, আদাবর, ঢাকা</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size:14px;font-weight:bold; color:#800000;'>web:www.cdipbd.org, Email:info@cdipbd.org, Phone:02-9141891,02-9141893</span></span></center>");
	}  
}
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
        'width:95%;'+
        'text-align: justify;'+
        '}' +
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close(); 
   } 

</script>
<script type="text/javascript"> 
$(document).ready(function() {
	$('#application_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('#from_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('#to_date').datepicker({dateFormat: 'yy-mm-dd'}); 
});
</script>
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupExperience_Certificate").addClass('active');
			$("#Certificate").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>