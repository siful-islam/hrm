
<?php $__env->startSection('title','Add Document' ); ?>
<?php $__env->startSection('main_content'); ?>
 <script type="text/javascript" language="javascript">
	function checkDelete()
	{
	 var chk=confirm("Are you sure to delete ?");
		if(chk)
		{
		  return true;
		}
		else{
		  return false;
		}
	}
</script> 
<?php 

$msg = Session::get('message');

if (!empty($msg)) {  
echo "<script>alert('$msg');</script>";
  session()->forget('message'); } ?>  

   <!-- Content Header (Page header) -->
    <section class="content-header">
		<h4>Document</h4>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Employee</a></li>
			<li class="active">Document</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<!-- /.box-header -->
					<div class="box-header">
						
							<form class="form-horizontal" action="<?php echo e(URL::to('edms_search/')); ?>"   role="form" method="POST">
								<?php echo e(csrf_field()); ?>   
								<div class="col-md-3"> 
									<div class="form-group"> 
										<label class="control-label col-md-5">Employee ID</label>
											<div class="col-md-7">
												<input type="text"  id="emp_id" name="emp_id" class="form-control">
												<span class="help-block"></span>
											</div> 
									</div> 
								</div>
								
								<div class="col-md-3">
									<div class="form-group">  
										<button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
									</div> 
								</div>  	 
							</form>
						
							<a href="<?php echo e(URL::to('/edms-document/create')); ?>" class="btn btn-success pull-right"><i class="fa fa-plus"></i>Add</a>
						
						
					</div>
					<div class="box-body">
						<div class="table-responsive">
						<table id="table_docu" class="table no-border table-striped">
							<thead>
								<tr>
									<th>SL No</th>
									<th>Employee ID</th>
									<th>Employee Name</th>
									<th>Group</th> 
									<th>Category</th> 
									<th>Effect Date</th>  
									<th class="text-center" style="width:15%">Action</th>
								</tr>
							</thead> 
							<tbody>
								
								<?php  
									$i=1
								 ?>
								<?php $__currentLoopData = $emp_document_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php 
									if($emp_leave->category_id == 13){
										$folder_name = "c_v/";
									}else if($emp_leave->category_id == 5){
										$folder_name = "edu_cation/";
									}else if($emp_leave->category_id == 11){
										$folder_name = "miscell_aneous/";
									}else if($emp_leave->category_id == 24){
										$folder_name = "train_ing_info/";
									}else if($emp_leave->category_id == 2){
										$folder_name = "assessment/";
									}else {
										$folder_name = "attach_ment_tran/";
									}
									$filename = "attachments/$folder_name/$emp_leave->document_name";
									if (file_exists($filename)) {
								
								?>
								<tr>
									<td><?php echo e($emp_leave->document_id); ?></td>
									<td><?php echo e($emp_leave->emp_id); ?></td>
									<td><?php 
											echo $emp_leave->emp_name; 
										?> </td>  
									<td><?php echo e($emp_leave->category_name); ?></td> 
									<td><?php echo e($emp_leave->subcategory_name); ?></td> 
									<td><?php echo e($emp_leave->effect_date); ?></td>  
									<td class="text-center">
									<?php if($emp_leave->subcat_id){ 
									$subcat_id = $emp_leave->subcat_id;
									}else{ $subcat_id = 0; }?>
									<?php if($emp_leave->is_cancel == 0){ ?>
									<a class="btn bg-olive"  title="View" href="<?php echo e(URL::to('/document-view/'.$emp_leave->emp_id.'/'.$emp_leave->category_id.'/'.$subcat_id)); ?>"><i class="fa fa-eye"></i></a>
									<a class="btn btn-primary" title="Edit" href="<?php echo e(URL::to('/edms_document_edit/'.$emp_leave->document_id)); ?>"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;  
									<?php }  ?>
									</td>
								</tr>
												<?php 
												} 
												
												?>
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
<script> 
	$(document).ready(function() {
    $('#table_docu').DataTable( {
        "order": [[ 0, "desc" ]]
    } );
} );
</script> 
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupEDMS").addClass('active');
		$("#Add_Document").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>