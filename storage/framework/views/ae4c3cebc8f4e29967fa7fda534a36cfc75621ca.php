
<?php $__env->startSection('main_content'); ?>
<style>
.content-header {
    padding-top: 5px;
}
.content-header > .breadcrumb {
	padding: 2px 7px;
}
.table-bordered {
    border: 1px solid #757070;
}
.table > thead > tr > th {
    border: 1px solid #757070;
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
	font-weight: bold;
	text-align: center; 
	padding: 2px;
}
.table > tbody > tr > td {
    border: 1px solid #757070;
	padding: 4px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small><?php echo e($Heading); ?></small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Branch Staff List</li>
	</ol>
</section>
<section class="content">
	 <div class="box-header with-border">			
						<center>
							<h3 class="box-title">Centre for Development Innovation and Practices</h3>
							<p>CDIP Bhaban, House No#17, Road No#13, PC Culture Housing Society, Shekhertek, Adabor, Dhaka-1207</p>
							<h4><span align="center" style="font-size:16px;font-weight:bold; color:#800000; "><u>Branch Wise  Increment List</u></span></h4> 
						</center>
						
					</div>
	<?php if(!empty($all_report)): ?>
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th rowspan="2">SL No.</th>
							<th rowspan="2">Staff Name</th>
							<th rowspan="2">ID No</th>
							<th rowspan="2">Designation</th>
							 
							<th rowspan="2">File</th>
						</tr> 
					</thead>
					<tbody>
						<?php echo e(!$i=1); ?> <?php $__currentLoopData = $all_report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						
						<?php 
						$user_type = Session::get( 'user_type');
						//echo $user_type; 
						$is_access = 1;
						//$destinationPath=public_path()."/2020";
						//$sourceFilePath= "attachments/attach_ment_tran/".$result['document_name'];
						//$success = \File::copy($sourceFilePath,$destinationPath);
						if($user_type == 5){ // branch manager
							if($result['designation_group_code'] == 11 || $result['designation_group_code'] == 8 ){
								$is_access = 0;
							}else{
								$is_access = 1;
							}
						}else if($user_type == 4){ // Area manager
							if($result['designation_group_code'] == 8 ){
								$is_access = 0;
							}else{
								$is_access = 1;
							}
						} 
						if($is_access == 1){ 
						?>
						

						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e($result['emp_name']); ?></td>
							<td><?php echo e($result['emp_id']); ?></td>
							<td><?php echo e($result['designation_name']); ?></td> 
							<td><a href="<?php echo e(asset('attachments/attach_ment_tran/auto_increment/'.$result['document_name'])); ?>" target="_blank"><img src="<?php echo e(asset('storage/office_order/pdf.png')); ?>" width="40" style="height:35px;" /></td> 
						</tr>
						
						<?php 
						
						}
							
						 
						?>
												
						
						
						
						
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php endif; ?>
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
		location.reload();
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>