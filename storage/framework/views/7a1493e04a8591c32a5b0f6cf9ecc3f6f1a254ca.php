
	<div class="row">
		<form class="form-horizontal" action="<?php echo e(URL::to('/unsettle-staff-adv-col')); ?>" method="post">
			<?php echo e(csrf_field()); ?>

			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label class="col-sm-2 control-label">Collection Amount <span class="required">*</span></label>
							<div class="col-sm-2">
								<input type="hidden" name="us_staff_ad_id" value="" class="form-control">
								<input type="hidden" name="transaction_type" value="<?php echo $transaction_type; ?>" class="form-control">
								<input type="hidden" name="emp_id" value="<?php echo $result_info->emp_id; ?>" class="form-control">
								<input type="hidden" name="total_amount" id="total_amount" value="<?php echo $result_info->total_amount - ($result_info->collection_amt + $result_info->transfer_amt); ?>" class="form-control">
								<input type="hidden" name="incre_id" value="<?php echo $result_info->incre_id; ?>" class="form-control">
								<input type="text" name="collection_amt" id="collection_amt" value="" class="form-control" required >
							</div>
							<label class="col-sm-2 control-label">Collection Date <span class="required">*</span></label>
							<div class="col-sm-2">
								<input type="text" name="collection_date" value="" class="form-control month_year" required>
							</div>
							<label class="col-sm-2 control-label">Narration <span class="required">*</span></label>
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

$('#collection_amt').on('input',function() {
    var total_amount = parseInt($('#total_amount').val());
    var collection_amt = parseInt($('#collection_amt').val());
	if (total_amount < collection_amt) {
		alert ('Collection Amount is greater than Balance!')
		$("#submit").attr("disabled", true);
	} else {
		$("#submit").attr("disabled", false);
	}
    //var total_amount = parseFloat($('#total_amount').val());
    //$('#total').val((qty * price ? qty * price : 0).toFixed(2));
});
</script>