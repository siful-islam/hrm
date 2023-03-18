	<div class="row">
		<div class="col-md-12">
			<form class="form-horizontal" action="{{URL::to('/unsettle-staff-adv-add')}}" method="post" >
			{{ csrf_field() }}
			<div class="box box-info">
				<div class="box-body">							
					<div class="form-group">
						<label class="col-sm-2 control-label">Claim Description <span class="required">*</span></label>
						<div class="col-sm-2">
							<input type="hidden" class="form-control" name="emp_type" value="<?php echo $result_info->emp_type; ?>" >
							<input type="hidden" class="form-control" name="emp_id" value="<?php echo $result_info->emp_id; ?>" >
							<input type="hidden" class="form-control" name="entry_date" value="<?php echo $result_info->entry_date; ?>" >
							<input type="hidden" class="form-control" name="designation_code" value="<?php echo $result_info->designation_code; ?>" >
							<input type="hidden" class="form-control" name="br_code" value="<?php echo $result_info->br_code; ?>" >
							<select name="claim_description" id="claim_description" required class="form-control">
								<option value="1" <?php //if($claim_description==1) echo 'selected'; ?> >Audit Report</option>
								<option value="2" <?php //if($claim_description==2) echo 'selected'; ?> >Branch Findings</option>
							</select>
						</div>
						<label class="col-sm-2 control-label">Claim Date <span class="required">*</span></label>
						<div class="col-sm-2">
							<input type="text" class="form-control entry_date" name="claim_date" value="" autocomplete="off" required>
						</div>
						<label class="col-sm-2 control-label">Claim Branch <span class="required">*</span></label>
						<div class="col-sm-2">
							<select class="form-control" id="claim_branch" name="claim_branch" required >						
								<option value="" >-Select-</option>
								@foreach ($all_branch as $branch)
								<option value="{{$branch->br_code}}">{{$branch->branch_name}}</option>
								@endforeach
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
							<input type="text" class="form-control" id="comments" name="comments" value="" required>
						</div>
					</div>						
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<a href="{{URL::to('/unsettle-staff-adv')}}" class="btn bg-olive" >List</a>
					<button type="submit" id="submit" class="btn btn-primary" >Save</button>
				</div>
			   <!-- /.box-footer -->
			</div>
			</form>
		</div>					
	</div>
<script>
$(document).ready(function() {
	$('.entry_date').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>