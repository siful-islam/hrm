
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
	<h1><small></small></h1>
</section>
<section class="content">
	<?php if(!empty($emp_history_grade)): ?>
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Grade History </font></b></p>		
			</div>
			<div class="col-md-12">
				<p align="left">
				<font size="3">Employee ID: </font><b><?php echo $emp_data->emp_id;?></b>		
				<font size="3">Employee Name: </font><b><?php echo $emp_data->emp_name_eng;?></b>		
				<font size="3">Designation: </font><?php echo $emp_data->designation_name;?>
				<font size="3">Status: </font>
				<?php if(!empty($emp_data->re_effect_date)) {
						if ($emp_data->re_effect_date <= $form_date) {
							echo '<span style="color:#F70408"><b>Cancel</b></span>';
						} else {
							echo '<span style="color:#179708"><b>Running</b></span>';
						}
					} elseif (empty($emp_data->re_effect_date)){
						echo '<span style="color:#179708"><b>Running</b></span>';
					} ?>
				</p>
				<p align="left">
				<font size="3">Org. Joining date: </font><span style="color:#179708"><?php echo date('d M Y',strtotime($emp_data->joining_date));?></span>
				<font size="3">Org. Joining Branch: </font><span style="color:#179708"><?php echo $emp_data->branch_name;?></span>
				</p>		
			</div>
			<div class="col-md-12">
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>Grade Name</th>
							<th>Date From</th>
							<th>Date To</th>
							<th>Duration of Grade</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						date_default_timezone_set('Asia/Dhaka');
						$i = 1; $next_day = date("Y-m-d"); $to_date = date("Y-m-d");
						foreach($emp_history_grade as $result) {
							if($i == 1) {
								if(!empty($emp_data->re_effect_date)) {
									$date_upto = $emp_data->re_effect_date;
								} else {
									$date_upto = $to_date;
								}
							} else {			
								$date_upto = date('Y-m-d', strtotime("-1 day", strtotime($next_day)));				
							}
							$big_date=date_create($date_upto);
							$small_date=date_create($result->grade_effect_date);
							$diff=date_diff($big_date,$small_date);
							
						$max_sarok = DB::table('tbl_master_tra')
										->where('emp_id', '=', $emp_id)
										->where('br_join_date', '>=', $result->grade_effect_date)
										->where('br_join_date', '<=', $date_upto)
										->select('emp_id',DB::raw('max(sarok_no) as sarok_no'))
										->first();
										
						$designation = DB::table('tbl_master_tra as m')
											->leftJoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
											->where('m.sarok_no', '=', $max_sarok->sarok_no)
											->select('m.emp_id','d.designation_name')
											->first();
						?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $result->grade_name; ?></td>
							<td><?php echo date('d M Y',strtotime($result->grade_effect_date)); ?></td>
							<td><?php echo date('d M Y',strtotime($date_upto)); ?></td>
							<td><?php echo $diff->format('%y Year %m Month %d Day'); ?></td>
						</tr>
						<?php $next_day = $result->grade_effect_date;
							$i++; 
						} ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>