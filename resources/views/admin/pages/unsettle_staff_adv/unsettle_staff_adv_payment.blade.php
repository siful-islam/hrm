
	<div class="row">
		<form class="form-horizontal" action="{{URL::to('/unsettle-staff-adv-col')}}" method="post">
			{{ csrf_field() }}
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label class="col-sm-2 control-label"> Amount <span class="required">*</span></label>
							<div class="col-sm-1">
								<input type="hidden" name="transaction_type" value="<?php echo $transaction_type; ?>" class="form-control">
								<input type="hidden" name="emp_id" value="<?php echo $result_info->emp_id; ?>" class="form-control">
								<input type="hidden" name="total_amount" id="total_amount" value="<?php echo ($result_info->total_amount + $result_info->debit_amt) - ($result_info->credit_amt + $result_info->transfer_amt); ?>" class="form-control">
								<input type="hidden" name="incre_id" value="<?php echo $result_info->incre_id; ?>" class="form-control">
								<input type="text" name="amount" id="amount" value="" class="form-control" required >
							</div>
							<label class="col-sm-1 control-label">Type <span class="required">*</span></label>
							<div class="col-sm-1">
								<select name="collection_type" id="collection_type" required class="form-control">
									<option value="" >Select</option>
									<option value="2" <?php //if($type==1) echo 'selected'; ?> >Cash</option>
									<option value="3" <?php //if($type==2) echo 'selected'; ?> >Bank</option>
								</select>
							</div>
							<label class="col-sm-2 control-label"> Date <span class="required">*</span></label>
							<div class="col-sm-2">
								<input type="text" name="tran_date" value="" class="form-control month_year" required autocomplete="off" >
							</div>
							<label class="col-sm-1 control-label">Narration <span class="required">*</span></label>
							<div class="col-sm-2">
								<input type="text" name="comments" value="" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<a href="{{URL::to('/unsettle-staff-adv')}}" class="btn bg-olive" ><i class="fa fa-fw fa-long-arrow-left" ></i> Back-to-List</a>
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

</script>