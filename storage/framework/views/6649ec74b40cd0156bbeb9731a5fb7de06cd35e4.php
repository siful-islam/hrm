
<?php $__env->startSection('title', 'Reports|Branch Staff Report'); ?>
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
</style>
<br/>
<br/>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
	<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
	</h1>				
</section>
<?php
function getBanglaNo($number){
 $engArray = array(1,2,3,4,5,6,7,8,9,0);
 $bangArray = array('১','২','৩','৪','৫','৬','৭','৮','৯','০');
 
 $convert = str_replace($engArray, $bangArray, $number);
 return $convert;
}
$date = date('d-m-Y');

?>
<?php $user_type = Session::get('user_type'); ?>
<section class="content">
	
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="3"><u>সিদীপ-এর মাঠ পর্যায়ের কাঠামো ও দায়িত্ব বন্টন সংক্রান্ত</u></font></b><span style="float:right">তারিখ : <?php echo getBanglaNo($date);?></span></p>	
			</div>
			<div class="col-md-12">
				<table class="table table-bordered" cellspacing="0">
					<tbody>
						<tr>
							<td style="font-weight: bold;">#</td>
							<td style="font-weight: bold;">জোনের নাম</td>
							<td style="font-weight: bold;">জোনের আওতাধীন এরিয়াসমূহ</td>
							<td style="font-weight: bold;">এরিয়ার আওতাধীন ব্রাঞ্চ সমূহ</td>
							<td style="font-weight: bold;">এরিয়া ম্যানেজার</td>
							<td style="font-weight: bold;">এএম-এর অবস্থান</td>
							<td style="font-weight: bold;">ডিসট্রিক্ট ম্যানেজার ও অবস্থান</td>
						</tr>
						<?php $j=1; foreach($all_zone as $zone) { ?> 				
					<?php if(!empty($all_result)){ 
						$i=1;$k=1;
						$array = json_decode(json_encode($all_result), true);
						foreach($all_result as $result){
							if($result['zone_code'] == $zone->zone_code){
								if($i==1) {
									$k=1;
									$count_array = array_count_values(array_column($array,'zone_code'))[$result['zone_code']];									
									?>
								<tr> 
									<td rowspan="<?php echo $count_array; ?>" style="vertical-align: middle;border-top: 2px solid gray;"><?php echo getBanglaNo($j).'.';?></td>
									<td rowspan="<?php echo $count_array; ?>" style="vertical-align: middle;border-top: 2px solid gray;"><?php echo $result['zone_name']; ?></td>
									<td style="border-top: 2px solid gray;"><?php echo $result['area_name']; ?></td>
									<td style="border-top: 2px solid gray;"><?php echo $result['area_all_br_name']; ?></td>
									<td style="border-top: 2px solid gray;"><?php echo $result['am_emp_name'].' ('.getBanglaNo($result['am_emp_id']).')'; ?></td>
									<td style="border-top: 2px solid gray;"><?php echo $result['am_br_name']; ?></td>
									<?php if($result['dm_emp_id'] == 425) { $result['dm_br_name'] = 'প্রধান কার্যালয়';}?>
									<td rowspan="<?php echo $count_array; ?>" style="vertical-align: middle;border-top: 2px solid gray;"><?php echo $result['dm_emp_name'].' ('.getBanglaNo($result['dm_emp_id']).')'.'<br/>'.$result['dm_br_name']; ?></td>
								</tr>
								<?php $i++; } else { ?>
								<tr> 
									<td><?php echo $result['area_name']; ?></td>
									<td><?php echo $result['area_all_br_name']; ?></td>
									<td><?php echo $result['am_emp_name'].' ('.getBanglaNo($result['am_emp_id']).')'; ?></td>
									<td><?php echo $result['am_br_name']; ?></td>
								</tr>
								<?php } ?>
							<?php $k++; } } } ?>
					
					<?php $j++; } ?>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
</section>
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
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>