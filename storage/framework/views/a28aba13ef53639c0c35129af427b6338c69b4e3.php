<?php $__env->startSection('main_content'); ?>
<style>
.content {
	padding-top: 5px;
}
.table-bordered {
    border: none;
}
.table > thead > tr > th {
    border: none;
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
	font-weight: bold;
	text-align: center; 
	padding: 2px;
}
.table > tbody > tr  > th > td {
    border: none;
	padding: 4px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
.form-group {
    margin-bottom: 2px;
}
body {
    font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
.required {
    color: red;
    font-size: 14px;
}
</style>
<br/>
<br/>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small><?php echo e($Heading); ?></small></h1>
</section>
<?php $user_type = Session::get('user_type'); ?>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="<?php echo e(URL::to('/unsettle-staff-adv')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="email">Employee Type :</label>
							<select name="emp_type" id="emp_type" required class="form-control">
								<?php $__currentLoopData = $all_emp_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_type1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($emp_type1->id); ?>"><?php echo e($emp_type1->type_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Employee ID :</label>
							<input type="text" id="emp_id" class="form-control" name="emp_id" size="10" value="<?php echo e($emp_id); ?>" required>
						</div>
						<div class="form-group">
						  <label for="pwd">Entry Date :</label>
						  <input type="text" id="entry_date" class="form-control entry_date" name="entry_date" size="10" value="<?php echo e($entry_date); ?>" required>
						</div>						
						<button type="submit" class="btn btn-primary" >Search</button>
						<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>
					</form>
				</div>
			</div>
        </div>
	</div>
	<?php if(!empty($result_info)): ?>	
	<div class="row">
		<form class="form-horizontal">
			<div class="col-md-12">
				<div class="box box-info" style="margin-bottom:10px;">
					<div class="box-body">							
						<div class="form-group">
							<label class="col-sm-2 control-label">Employee Type </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo $emp_type_name->type_name; ?></p>
							</div>
							<label class="col-sm-2 control-label">Employee ID </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo $emp_id; ?></p>
							</div>
							<label class="col-sm-2 control-label">Entry Date </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo $entry_date; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Employee Name </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo empty($result_info->emp_name) ? $result_info->emp_name_eng : $result_info->emp_name; ?></p>							
							</div>
							<label class="col-sm-2 control-label">Designation </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo $result_info->designation_name; ?></p>
							</div>
							<label class="col-sm-2 control-label">Branch </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo $result_info->branch_name; ?></p>
							</div>
						</div>
						<?php if(!empty($resultinfo)) { ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Claim Description </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php if($result_info->claim_description==1) echo 'Audit Report'; ?>
								<?php if($result_info->claim_description==2) echo 'Branch Findings'; ?></p>
							</div>
							<label class="col-sm-2 control-label">Claim Date </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo $result_info->claim_date; ?></p>
							</div>
							<label class="col-sm-2 control-label">Claim Branch </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo $result_info->claim_branch_name; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Total Amount </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo $result_info->total_amount; ?></p>							
							</div>
							<label class="col-sm-2 control-label">Narration </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo $result_info->comments; ?></p>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</form>
	</div>
	<?php if(!empty($resultinfo)) { ?>
	<div class="row">
		<form class="form-horizontal">
			<div class="col-md-12">
				<div class="box box-info" style="margin-bottom:10px;">
					<div class="box-body">							
						<div class="form-group">
							<label class="col-sm-2 control-label">Debit </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo $result_info->total_amount + $result_info->debit_amt; ?></p>
							</div>
							<label class="col-sm-2 control-label">Credit </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo $result_info->credit_amt + $result_info->transfer_amt; ?></p>
							</div>
							<label class="col-sm-2 control-label">Balance </label>
							<div class="col-sm-1">
								<p class="form-control-static">: <?php echo $balance = ($result_info->total_amount + $result_info->debit_amt) - ($result_info->credit_amt + $result_info->transfer_amt); ?></p>
							</div>
							<div class="col-sm-1">
								<p class="form-control-static"> <a href="<?php echo e(URL::to('/unsettle-statement/'.$emp_id)); ?>" target="_blank">Details</a></p>
							</div>
						</div>						
					</div>
				</div>
			</div>
		</form>
	</div>
	<?php } ?>
	<?php endif; ?>
	<?php if(!empty($emp_id)) { ?>
	<?php if(empty($resultinfo)) { ?>
	<div class="row">
		<div class="col-md-12">
			<form class="form-horizontal" action="<?php echo e(URL::to('/unsettle-staff-adv-add')); ?>" method="post" >
			<?php echo e(csrf_field()); ?>

			<div class="box box-info">
				<div class="box-body">							
					<div class="form-group">
						<label class="col-sm-2 control-label">Claim Description <span class="required">*</span></label>
						<div class="col-sm-2">
							<input type="hidden" class="form-control" name="emp_type" value="<?php echo $emp_type; ?>" >
							<input type="hidden" class="form-control" name="emp_id" value="<?php echo $emp_id; ?>" >
							<input type="hidden" class="form-control" name="entry_date" value="<?php echo $entry_date; ?>" >
							<input type="hidden" class="form-control" name="designation_code" value="<?php echo $designation_code; ?>" >
							<input type="hidden" class="form-control" name="br_code" value="<?php echo $br_code; ?>" >
							<select name="claim_description" id="claim_description" required class="form-control">
								<option value="1" <?php //if($claim_description==1) echo 'selected'; ?> >Audit Report</option>
								<option value="2" <?php //if($claim_description==2) echo 'selected'; ?> >Branch Findings</option>
							</select>
							<!--<a href="#addModal" data-toggle="modal" data-target=".bd-example-modal-sm" class="btn btn-primary" >Add</a>-->
						</div>
						<label class="col-sm-2 control-label">Claim Date <span class="required">*</span></label>
						<div class="col-sm-2">
							<input type="text" class="form-control entry_date" name="claim_date" value="" autocomplete="off" required>
						</div>
						<label class="col-sm-2 control-label">Claim Branch <span class="required">*</span></label>
						<div class="col-sm-2">
							<select class="form-control" id="claim_branch" name="claim_branch" required >						
								<option value="" >-Select-</option>
								<?php $__currentLoopData = $all_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($branch->br_code); ?>"><?php echo e($branch->branch_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label class="col-sm-2 control-label">Total Amount <span class="required">*</span></label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="total_amount" name="total_amount" value="" required>
						</div>
						<label class="col-sm-2 control-label">Narration <span class="required">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="comments" name="comments" value="" required >
						</div>
					</div>						
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<a href="<?php echo e(URL::to('/unsettle-staff-adv')); ?>" class="btn bg-olive" >List</a>
					<button type="submit" id="submit" class="btn btn-primary" >Save</button>
				</div>
			   <!-- /.box-footer -->
			</div>
			</form>
		</div>					
	</div>
	<?php } } ?>
	<?php if(!empty($resultinfo)) { 
	$transaction = array('1' => "Receive", '2' => "Payroll", '3' => "Transfer", '4' => "Adjustment", '5' => "Add Unsettle Claim", '6' => "Payment", '7' => "Khudra jhuki & Member Welfare Fund", '8' => "Resedule");	
	?>
	<div class="row">
		<div class="col-md-12">
			<form class="form-horizontal" action="<?php echo e(URL::to('/unsettle-staff-adv')); ?>" method="post" >
			<?php echo e(csrf_field()); ?>

			<div class="box box-info">
				<div class="box-body">							
					<div class="form-group">
						<label class="col-sm-2 control-label">Transaction Type <span class="required">*</span></label>
						<div class="col-sm-2">
							<input type="hidden" class="form-control" name="incre_id" id="incre_id" value="<?php echo $resultinfo->incre_id; ?>" >
							<select name="transaction_type" id="transaction_type" required class="form-control" onchange="LoadPage()">
								<option value="0" >Select</option>
								<?php foreach ($transaction as $id => $val) { ?>
								<option value="<?php echo $id; ?>"><?php echo $val; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-primary" >Search</button>
						</div>
					</div>					
				</div>
				<!-- /.box-body -->
			</div>
			</form>
		</div>					
	</div>
	<?php } ?>
	<div id="content_load"></div>
	
	<!--<div class="modal fade bd-example-modal-sm" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm" role="document">
		<div class="modal-content" style="top: 200px;">
		<form method="post" action="<?php echo e(URL::to('/unsettle-add-claim')); ?>">
		  <?php echo e(csrf_field()); ?>

		  <div class="modal-body">
			  <div class="form-group">
				<label for="recipient-name" class="col-form-label">Add Claim Description:</label>
				<input type="text" name="claim_des_name" class="form-control" id="recipient-name">
			  </div>			
		  </div>
		  <div class="modal-footer" style="padding: 6px;">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Save</button>
		  </div>
		</form>
		</div>
	  </div>
	</div>-->
	
</section>
<script>
$(document).ready(function() {
	$('.entry_date').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
<script>
	function LoadPage() {
		var transaction_type = document.getElementById("transaction_type").value;
		var emp_id = document.getElementById("emp_id").value;
		var incre_id = document.getElementById("incre_id").value;
		//alert(transaction_type);		
			$.ajax({
			url : "<?php echo e(url::to('get-page-info')); ?>"+"/"+ transaction_type+"/"+ emp_id+"/"+ incre_id,
			type: "GET",
			success: function(data)
			{
				//alert (data);
				$("#content_load").html(data);				
			}
		});
		
	}
</script>
<script>
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