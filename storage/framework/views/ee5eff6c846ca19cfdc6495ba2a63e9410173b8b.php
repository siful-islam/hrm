
<?php $__env->startSection('title', 'Office Order List'); ?>
<?php $__env->startSection('main_content'); ?>
    <!-- Content Header (Page header) -->
	<script type="text/javascript" language="javascript">
	function checkDelete()
	{
	 var chk=confirm("Are you sure to delete !!!");
		if(chk)
		{
		  return true;
		}
		else{
		  return false;
		}
	}
</script> 
	
    <section class="content-header">
		<h4>Office Order</h4>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Office</a></li>
			<li class="active">Order</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<!-- /.box-header -->
					<div class="box-header">
						<h3 class="box-title pull-right"> 
							
							<a href="<?php echo e(URL::to('/office_order/create')); ?>" class="btn btn-success"><i class="fa fa-plus"></i>Add</a>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="<?php echo e(URL::to('/office_order_update')); ?>" class="btn btn-danger">Update</a>
							
						</h3>
					</div>
					<div class="box-body">
						<div class="table-responsive">
						<table id="table" class="table no-border table-striped">
							<thead>
								<tr>
									<th>SL No</th>
									<th>Date</th>
									<th>Upload Type</th>
									<th>Title</th>
									<th>Comments</th> 
									<th>HO/BO</th>
									<th>Status</th>
									<th>File</th>
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>SL No</th>
									<th>Date</th>
									<th>Upload Type</th>
									<th>Title</th>
									<th>Comments</th>
									<th>HO/BO</th>
									<th>Status</th>
									<th>File</th>
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</tfoot>
							<tbody>
								
								<?php  
									$i=1
								 ?>
								<?php $__currentLoopData = $office_order_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if( $order->pre_data_show == 1){ ?>
								<tr>
									<td><?php echo e($i++); ?></td>
									<td><?php echo e($order->order_date); ?></td>
									<td><?php if($order->upload_type == 1){echo "Office Order";}else if($order->upload_type == 2){ echo "Circular"; }else if($order->upload_type == 3){ echo "Downloads"; }else if($order->upload_type == 4){ echo "General"; }else if($order->upload_type == 5){ echo "User Manual"; }?></td>
									<td><?php echo e($order->title); ?></td>
									<td><?php echo e($order->comments); ?></td> 
									<td><?php if($order->for_which == 1){echo "Head Office";}else if($order->for_which == 2){ echo "Branch Office"; }else if($order->for_which == 3){ echo "All"; } ?> </td>
									<td><?php if($order->status == 1){echo "<span style='color:green;'>Active</span>";}else if($order->status == 2){ echo "<span style='color:red;'>Inactive</span>"; } ?> </td>
									<td> 
									<?php 
										
										if(!empty($order->file_name)){ 
											$ss= explode('.',$order->file_name);
										if($ss[1] == 'pdf')
										{?>
										<a href="<?php echo e(asset('storage/office_order/'.$order->file_name)); ?>" target="_blank" download="<?php echo e($order->title); ?>.<?php echo e($ss[1]); ?>"><img src="<?php echo e(asset('storage/office_order/pdf.png')); ?>" width="40" style="height:35px;" /></a> 
									<?php }else if(($ss[1] == 'doc' )|| ($ss[1] == 'docx')){ ?>
											<a href="<?php echo e(asset('storage/office_order/'.$order->file_name)); ?>" target="_blank" download="<?php echo e($order->title); ?>.<?php echo e($ss[1]); ?>"><img src="<?php echo e(asset('storage/office_order/doc.png')); ?>" width="40" style="height:35px;" /></a> 
									<?php }else{ ?>
											<a href="<?php echo e(asset('storage/office_order/'.$order->file_name)); ?>" target="_blank" download="<?php echo e($order->title); ?>.<?php echo e($ss[1]); ?>"><img    src="<?php echo e(asset('storage/office_order/'.$order->file_name)); ?>" width="40" style="height:35px;"/></a> 
										<?php } }else{ ?>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php } ?>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<?php 
									if(!empty($order->word_file_name)){
										$ss= explode('.',$order->word_file_name);
										if($ss[1] == 'pdf')
										{?>
										<a href="<?php echo e(asset('storage/office_order/'.$order->word_file_name)); ?>" target="_blank" download="<?php echo e($order->title); ?>.<?php echo e($ss[1]); ?>"><img src="<?php echo e(asset('storage/office_order/pdf.png')); ?>" width="40" style="height:35px;" /></a> 
									<?php }else if(($ss[1] == 'doc') ||($ss[1] == 'docx')){ ?>
											<a href="<?php echo e(asset('storage/office_order/'.$order->word_file_name)); ?>" target="_blank" download="<?php echo e($order->title); ?>.<?php echo e($ss[1]); ?>"><img src="<?php echo e(asset('storage/office_order/doc.png')); ?>" width="40" style="height:35px;" /></a> 
									<?php }else{ ?>
											<a href="<?php echo e(asset('storage/office_order/'.$order->word_file_name)); ?>" target="_blank" download="<?php echo e($order->title); ?>.<?php echo e($ss[1]); ?>"><img    src="<?php echo e(asset('storage/office_order/'.$order->word_file_name)); ?>" width="40" style="height:35px;" /></a> 
									<?php }} ?>
									</td> 
									<td class="text-center"> 
									<a class="btn btn-primary" title="Edit" href="<?php echo e(URL::to('/office_order/'.$order->order_id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
									&nbsp;&nbsp;
									<a class="btn btn-primary" onclick="return checkDelete();"  href="<?php echo e(URL::to('/office_order_delete/'.$order->order_id)); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a> 
									</td>
								</tr>
								<?php } ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>    
						</table>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
        </div>
	</section> 
<!-- DataTables -->
 		
	
<script>
	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
		});
	});
</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupCircular_Order_Download").addClass('active');
			$("#Add_Update").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>