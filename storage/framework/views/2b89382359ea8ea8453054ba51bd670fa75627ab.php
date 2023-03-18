<?php $__env->startSection('title', 'Download Office Order'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.readonly{
 background-color:#eee;
}
.required{
	padding-right:3px;
	margin-top:0px;
	 
}
.control-label{
	 text-align:right !important;
}
.required:not(.required)

</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Office Order</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Office order</a></li>
			<li class="active">Add</li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content">
		<div class="box box-info"> 
			<div class="row">  
				<div class="col-sm-11">  
					<form class="form-horizontal" action="" role="form" method="POST" enctype="multipart/form-data"> 
						<table   class="table table-bordered">
							<thead>
								<tr>
									<th style="width:10%">SL No</th> 
									<th style="width:30%;text-align:center;">Title</th>
									<th style="width:30%;text-align:center;">Description </th>
									<th style="width:10%">Date</th> 
									<th style="width:20%">Download</th>  
								</tr>
							</thead>
							<tbody>
								<?php 
								$j=1;
								foreach($office_order_file as $order_file){ 
									//echo $order_file->file_name;
									?>
								<tr>
									<td><?php echo  $j++;?></td>
									<td style="text-align:center;"><?php echo  $order_file->title;?></td>
									<td style="text-align:center;"><?php echo  $order_file->comments;?></td>
									<td><?php echo  date("d-m-Y",strtotime($order_file->order_date));?></td> 
									<td>
									<?php if(!empty($order_file->file_name)){
										
										$ss= explode('.',$order_file->file_name);
										
										?>
									<a href="<?php echo e(asset('storage/office_order/'.$order_file->file_name)); ?>" target="_blank" download="<?php echo e($order_file->title); ?>.<?php echo e($ss[1]); ?>"><img src="<?php echo e(asset('storage/office_order/pdf.png')); ?>" width="40" style="height:35px;" /></a> 
									<?php }else{ ?>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<?php } ?>
									 
									<?php if(!empty($order_file->word_file_name)){
										$ss= explode('.',$order_file->word_file_name);
										
										?>
									 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo e(asset('storage/office_order/'.$order_file->word_file_name)); ?>" target="_blank" download="<?php echo e($order_file->title); ?>.<?php echo e($ss[1]); ?>"><img src="<?php echo e(asset('storage/office_order/doc.png')); ?>" width="40" style="height:35px;" /></a> 
									<?php } ?>
									  </td> 
								</tr> 
								<?php } ?>
							</tbody>    
						</table>
					</form>
			    </div>
			</div>
		</div> 
</section>
<script type="text/javascript"> 

</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupCircular_Order_Download").addClass('active');
			<?php if($submenu == 'download'){ ?>
				$("#Download").addClass('active');
			<?php } ?>
			<?php if($submenu == 'circular'){ ?>
				$("#Circular").addClass('active');
			<?php } ?>
			<?php if($submenu == 'general'){ ?>
				$("#General").addClass('active');
			<?php } ?>
			<?php if($submenu == 'office_Order'){ ?>
			$("#Office_Order").addClass('active'); 
			<?php } ?>
			<?php if($submenu == 'user_Manual'){ ?>
			$("#User_Manual").addClass('active'); 
			<?php } ?>
			
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>