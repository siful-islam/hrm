
<?php $__env->startSection('title', 'Transfer History'); ?>
<?php $__env->startSection('main_content'); ?>
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
.form-group {
    margin-bottom: 2px;
}

blink {
    animation: 1s linear infinite condemned_blink_effect;
	color: #900C3F;
	font-weight: bold;
	font-size: 16px;
}
@keyframes  condemned_blink_effect {
    0% {
        visibility: hidden;
    }
    50% {
        visibility: hidden;
    }
    100% {
        visibility: visible;
    }
}
</style>
<br/>
<br/>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small><?php echo e($Heading); ?></small></h1>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="<?php echo e(URL::to('/transfer-history')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="email">Employee ID :</label>
							<input type="text" id="emp_id" class="form-control" name="emp_id" size="10" value="<?php echo e($emp_id); ?>" required>
						</div>						
						<button type="submit" class="btn btn-primary">Search</button>
						<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>
					</form>
				</div>
			</div>
        </div>
	</div>
	<?php if(!empty($results)): ?>
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Transfer History </font></b></p>		
			</div>
			<div class="col-md-12">
				<table class="table table-striped" style="margin-bottom: 10px;">
					<tbody>
						<tr>
							<td style="border-style:none;padding-top:10px;">
								<p style="font-size: 16px;line-height: 1.4;">
									Employee ID : <?php echo $emp_data->emp_id; ?><br/><br/>
									Employee Name : <?php echo $emp_data->emp_name_eng; ?>
								</p>
							</td>
							<td style="border-style:none;padding-top:10px;">
								<p style="font-size: 16px;line-height: 1.4;">
									Designation : <?php echo $emp_data->designation_name; ?><br/><br/>
									Status : <?php if(!empty($emp_data->re_effect_date)) {
										if ($emp_data->re_effect_date <= $form_date) {
											echo '<span style="color:#F70408"><b>Cancel</b></span>';
										} else {
											echo '<span style="color:#179708"><b>Running</b></span>';
										}
									} elseif (empty($emp_data->re_effect_date)){
										echo '<span style="color:#179708"><b>Running</b></span>';
									} ?>									
								</p>
							</td>
						</tr>
					</tbody>
				</table>		
			</div>
			<div class="col-md-12">
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>Date From</th>
							<th>Date To</th>
							<th>Duration</th>
							<th>Branch Name</th>
							<th>Area Name</th>
							<th>Designation</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($first_transfer)) { ?>
						<tr>
							<td>Joining Branch</td>
							<td><?php echo date('d M Y',strtotime($emp_data->joining_date));?></td>
							<td><?php echo date('d M Y', strtotime("-1 day", strtotime($first_transfer->br_joined_date))); ?></td>
							<td><?php date_default_timezone_set('UTC');
								$bigdate=date_create(date("Y-m-d", strtotime("-1 day", strtotime($first_transfer->br_joined_date))));
								$smalldate=date_create($emp_data->joining_date);
								$differ=date_diff($bigdate,$smalldate);
								echo $differ->format('%y Year %m Month %d Day'); 
							?></td>
							<td><?php echo $emp_data->branch_name; ?></td>   
							<td><?php echo $emp_data->area_name; ?></td>
							<td><?php echo $emp_data->app_emp_designation; ?></td>
						</tr>
						<?php } ?>
						<?php
						$i=0; 
						foreach($results as $index => $result){
							if($index+1 == sizeof($results)){
								if(!empty($emp_data->re_effect_date)) {
									$date_to = $emp_data->re_effect_date;
								} else {
									$date_to = date("Y-m-d");
								}
							} else {		 
								$date_to = date('Y-m-d', strtotime($results[$i+1]['br_joined_date'] .' -1 day'));		
							} 
							$i++;
							$big_date=date_create($date_to);
							$small_date=date_create($result['br_joined_date']);
							$diff=date_diff($big_date,$small_date);
							$max_sarok = DB::table('tbl_master_tra')
										->where('emp_id', '=', $emp_id)
										->where('br_join_date', '>=', $result['br_joined_date'])
										->where('br_join_date', '<=', $date_to)
										->select('emp_id',DB::raw('max(sarok_no) as sarok_no'))
										->first();
							//echo $emp_id; print_r($max_sarok); exit;		
							$designation = DB::table('tbl_master_tra as m')
											->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
											->where('m.emp_id', '=', $emp_id)
											->where('m.sarok_no', '=', $max_sarok->sarok_no)
											->select('m.emp_id','d.designation_name')
											->first();
							
						  ?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo date('d M Y',strtotime($result['br_joined_date'])); ?></td>
							<td><?php echo date('d M Y',strtotime($date_to)); ?></td>
							<td><?php echo $diff->format('%y Year %m Month %d Day'); ?></td>
							<td><?php echo $result['branch_name']; ?></td>   
							<td><?php echo $result['area_name']; ?></td>
							<td><?php echo $designation->designation_name; ?></td>
						</tr>
						<?php } ?>						  
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php endif; ?>
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
		$("#MainGroupBasic_Reports").addClass('active');
		$("#Transfer_History").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>