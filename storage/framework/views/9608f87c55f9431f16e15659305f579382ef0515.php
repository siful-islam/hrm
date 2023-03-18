
<?php $__env->startSection('title', 'Contractual Transfer'); ?>
<?php $__env->startSection('main_content'); ?>


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Contractual <small>Transfer</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> HRM</a></li>
			<li><a href="#">Contractual</a></li>
			<li class="active">Transfer</li>
		</ol>
	</section>

	<!-- Main content -->
	
	<?php
	$allreligions = array('Islam'=>'Islam','Hinduism'=>'Hinduism','Christianity'=>'Christianity','Buddhism'=>'Buddhism','Other'=>'Other');
	$allbloods = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','7'=>'O+','O-'=>'O-');
	?>

	<section class="content">
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> Transfer Information </h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			
				<form name="employee_nonid" class="form-horizontal"  role="form" method="POST" id="employee_nonid" enctype="multipart/form-data">
				<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo e($emp_id); ?>"> 
				<div class="box-body col-md-7">					
					<div class="form-group">
						<label for="emp_type" class="col-sm-3 control-label">Emp Type:</label>
						<div class="col-sm-3">
							<span class="form-control"> <?php echo  $type_name; ?></span>
						</div>
						
						<label for="sacmo_id" class="col-sm-3 control-label">Employee ID </label>
						<div class="col-sm-3"> 
							<span class="form-control"> <?php  echo  $sacmo_id;  ?></span>
						</div>
						
					</div>
					<hr>  
					<div class="form-group">
						<label for="effect_date" class="col-sm-3 control-label"> Effect Date:</label>
						<div class="col-sm-3"> 
							<span class="form-control"> <?php  echo  date("d-m-Y",strtotime($effect_date));  ?></span>
						</div>
						
						<label for="Console_salary" class="col-sm-3 control-label">From Branch:</label>
						<div class="col-sm-3"> 
							<span class="form-control"> <?php  echo  $f_branch_name;  ?></span>
						</div>
					</div> 
					<div class="form-group"> 
						<label for="Console_salary" class="col-sm-3 control-label">To Branch: </label>
						<div class="col-sm-3"> 
							<span class="form-control"> <?php  echo  $t_branch_name;  ?></span>
						</div>
						<label for="comments" class="col-sm-3 control-label"> Comments : </label>
						<div class="col-sm-3">
							 
							<span class="form-control"> <?php  if($comments == 1) {echo "Official";} else { echo  "Personal";}  ?></span>
						</div>
					</div> 
					<div class="form-group"> 
					<label class="control-label col-md-3">Salary Branch: </label>
						<div class="col-md-3">
							 
							<span class="form-control"> <?php  echo  $s_branch_name;  ?></span>
						</div>  
					</div>  
					<hr> 
				</div>
				<div class="col-md-5">
					<!-- Profile Image -->
					<div class="box box-primary">
						<div class="box-body box-profile">
							<img id="emp_photo" class="profile-user-img img-responsive img-circle" src="" alt="Employee Photo"/>
							<h3 class="profile-username text-center" id="emp_name" ><?php echo e($emp_name); ?></h3>
							<p class="text-muted text-center" id="designation_name"><?php echo e($designation_name); ?></p>
							<ul class="list-group list-group-unbordered">
								<li class="list-group-item">
									<b>Org Joining Date : </b><span id="joining_date">  <?php if($joining_date): ?> <?php echo e(date("d-m-Y",strtotime($joining_date))); ?> <?php endif; ?></span>
								</li>
								<li class="list-group-item">
									<b>Present Working Station : </b><span id="branch_name"> <?php echo e($branch_name); ?> </span>
								</li>
							</ul>
								<a href="#" <?php if($cancel_date == ''){  ?> class="btn btn-primary btn-block"; <?php }else { ?> class="btn btn-danger btn-block" <?php }?>  id="employee_status"><b><?php if($cancel_date == ''){ echo "Active Employee"; }else { echo "This Employee Terminated"; }?></b></a>
						</div>
						<!-- /.box-body --> 
						<div>
							<center>
								<button type="button" class="btn btn-warning" id="all" onclick="get_salary();">Show Contractual Transfer History</button>
							</center>
							<br>
							<div>
							<table class="table table-bordered table-striped" id="transfer_history" border="1">
								
							</table>
							</div>
						</div>	
					</div>
					<!-- /.box -->
				</div>
				<div class="box-footer">

				</div>
			</form>

		</div>
	</section>  
<script>
	function get_salary()
	{
		var emp_id = document.getElementById("emp_id").value; 
		//alert(emp_id);
		$.ajax({
			url : "<?php echo e(URL::to('get_nonid_transfer_info')); ?>"+"/"+ emp_id,
			type: "GET",
			success: function(data)
			{
				//alert(data);
				//$("#upazila_id").attr("disabled", false);
				$("#transfer_history").html(data); 
				//$("#upazi_name").html(data); 
			}
		}); 
	}
</script>
	
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupContractual").addClass('active');
		//$("#Transfer_(Contractual)").addClass('active');
		$('[id^=Transfer_]').addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>