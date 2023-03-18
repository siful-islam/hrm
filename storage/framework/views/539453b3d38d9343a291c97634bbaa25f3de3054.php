
	<div class="row">
		<form class="form-horizontal" action="<?php echo e(URL::to('/unsettle-staff-adv-resedule')); ?>" method="post">
			<?php echo e(csrf_field()); ?>

			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label class="col-sm-2 control-label">Installment Amount: <span class="required">*</span></label>
							<div class="col-sm-2">
								<input type="hidden" name="transaction_type" value="<?php echo $transaction_type; ?>" class="form-control">
								<input type="hidden" name="emp_id" value="<?php echo $result_info->emp_id; ?>" class="form-control">
								<input type="hidden" name="total_amount" id="total_amount" value="<?php echo ($result_info->total_amount + $result_info->debit_amt) - ($result_info->credit_amt + $result_info->transfer_amt); ?>" class="form-control">
								<input type="hidden" name="incre_id" value="<?php echo $result_info->incre_id; ?>" class="form-control">
								<input type="hidden" name="collection_type" value="1" class="form-control">
								<input type="text" name="credit_amt" id="credit_amt" value="" class="form-control" required>
							</div>
							<label class="col-sm-2 control-label">Start Date: <span class="required">*</span></label>
							<div class="col-sm-2">
								<input type="text" name="tran_date" value="" class="form-control month_year" required autocomplete="off">
							</div>
							<label class="col-sm-2 control-label">Narration: <span class="required">*</span></label>
							<div class="col-sm-2">
								<input type="text" name="comments" value="" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<a href="<?php echo e(URL::to('/unsettle-staff-adv')); ?>" class="btn bg-olive" ><i class="fa fa-fw fa-long-arrow-left" ></i> Back-to-List</a>
						<button type="submit" id="submit" class="btn btn-primary" >Save</button>
					</div>
				</div>
			</div>
		</form>
	</div>
<script>
$(document).ready(function() {
	$('.month_year').datepicker({dateFormat: 'yy-mm-dd'});
});

$('#credit_amt').on('input',function() {
    var total_amount = parseInt($('#total_amount').val());
    var credit_amt = parseInt($('#credit_amt').val());
	if (total_amount < credit_amt) {
		alert ('Collection Amount is greater than Balance!')
		$("#submit").prop("disabled", true);
	} else {
		$("#submit").prop("disabled", false);
	}
    //var total_amount = parseFloat($('#total_amount').val());
    //$('#total').val((qty * price ? qty * price : 0).toFixed(2));
});
</script>