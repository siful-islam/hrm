	
	<div class="row">
		<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" method="post">
			<?php echo e(csrf_field()); ?>

			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-body">
						<div class="col-md-12 table-responsive">
							<table id="transfer" class="table table-bordered">
								<thead>
								  <tr>
									<th>Employee ID</th>
									<th>Name</th>
									<th>Branch</th>
									<th>Designation</th>
									<th>Transfer Amount</th>
									<th>Date</th>
									<th>Narration</th>
								  </tr>
									<td>
										<input type="hidden" name="us_staff_ad_id" value="<?php echo e($result_info->id); ?>" class="form-control">
										<input type="hidden" name="transaction_type" value="<?php echo $transaction_type; ?>" class="form-control">
										<input type="hidden" name="transfer_from_emp_id" value="<?php echo e($result_info->emp_id); ?>" class="form-control">
										<input type="hidden" name="claim_description" value="<?php echo e($result_info->claim_description); ?>" class="form-control">
										<input type="hidden" name="claim_date" value="<?php echo e($result_info->claim_date); ?>" class="form-control">
										<input type="hidden" name="claim_branch" value="<?php echo e($result_info->claim_branch); ?>" class="form-control">
										<input type="hidden" name="total_amount" id="total_amount" value="<?php echo $result_info->total_amount - ($result_info->collection_amt + $result_info->transfer_amt); ?>" class="form-control">
									</td>
								</thead>
								<?php $transfer_row = 0; $i=1; 
								$transfer_array = array(); foreach ($transfer_data as $transfer) {
								$transfer_array[] = $transfer->id;
								?>
								<tbody id="transfer-row<?php echo $transfer_row; ?>">
								  <tr>
									<td>
										<input type="text" name="transfer[<?php echo $transfer_row; ?>][emp_id]" value="<?php echo e($transfer->emp_id); ?>" required class="form-control" onChange="get_employee_info(this.value,<?php echo e($transfer_row); ?>);" size="8">
									</td>
									<td>
										<input type="text" value="<?php echo e($transfer->emp_name_eng); ?>" style="width:180px;" class="form-control" />
									</td>
									<td>
										<select style="width:180px;" name="transfer[<?php echo $transfer_row; ?>][br_code]" id="br_code<?php echo $transfer_row; ?>" required class="form-control">
											<option value="">Select</option>							
											<?php foreach ($all_branch as $branch) { ?>
												<?php if($branch->br_code==$transfer->br_code){ ?>
													<option value="<?php echo $branch->br_code; ?>" selected="selected"><?php echo $branch->branch_name; ?></option>
													<?php } else { ?>
													<option value="<?php echo $branch->br_code; ?>"><?php echo $branch->branch_name; ?></option>
													<?php } ?>
											<?php } ?>
										</select>
									</td>
									<td>
										<select style="width:180px;" name="transfer[<?php echo $transfer_row; ?>][designation_code]" id="designation_code<?php echo $transfer_row; ?>" required class="form-control">
											<option value="">Select</option>							
											<?php foreach ($all_designation as $designation) { ?>
												<?php if($designation->designation_code==$transfer->designation_code){ ?>
													<option value="<?php echo $designation->designation_code; ?>" selected="selected"><?php echo $designation->designation_name; ?></option>
													<?php } else { ?>
													<option value="<?php echo $designation->designation_code; ?>"><?php echo $designation->designation_name; ?></option>
													<?php } ?>
											<?php } ?>
										</select>
									</td>
									<td>
										<input type="text" name="collection_amt" value="" class="form-control">
									</td>
									<td>
										<input type="text" name="collection_amt" value="" class="form-control">
									</td>
									<td><a onclick="$('#transfer-row<?php echo $transfer_row; ?>').remove();" class="btn btn-danger">Remove</a></td>
								  </tr>
								</tbody>
								<?php $transfer_row++; ?>
								<?php } ?>
								<tfoot>
									<tr>
										<td colspan="7"></td>
										<td class="left"><a onclick="addtransfer();" class="btn btn-primary">Add More</a></td>
									</tr>
								</tfoot>
							</table>								
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
var transfer_row = <?php echo $transfer_row; ?>;
function addtransfer() {
	//alert (transfer_row);
	html  = '<tbody id="transfer-row' + transfer_row + '">';
	html += '  <tr>';
    html += '    <td><input type="text" name="transfer[' + transfer_row + '][transfer_emp_id]" value="" size="8" onChange="get_employee_info(this.value,'+transfer_row+');" required class="form-control" /></td>';
    html += '    <td><input type="text" id="emp_name'+transfer_row+'" style="width:180px;" readonly class="form-control" /></td>';
	html += '    <td><select style="width:180px;pointer-events:none;" name="transfer[' + transfer_row + '][transfer_emp_br_id]" id="br_code'+transfer_row+'" required readonly class="form-control">';
	html += '    <option value="">Select</option>';
	<?php foreach ($all_branch as $branch) { ?>
    html += '      <option value="<?php echo $branch->br_code; ?>"><?php echo addslashes($branch->branch_name); ?></option>';
    <?php } ?>
    html += '    </select></td>';
	html += '    <td><select style="width:180px;pointer-events:none;" name="transfer[' + transfer_row + '][transfer_emp_desig_id]" id="designation_code'+transfer_row+'" required readonly class="form-control">';
    html += '    <option value="">Select</option>';
	<?php foreach ($all_designation as $designation) { ?>
    html += '      <option value="<?php echo $designation->designation_code; ?>"><?php echo addslashes($designation->designation_name); ?></option>';
    <?php } ?>
    html += '    </select></td>';
    html += '    <td><input type="text" name="transfer[' + transfer_row + '][transfer_amt]" value="" size="8" required class="form-control transfer_amt" /></td>';
    html += '    <td><input type="text" name="transfer[' + transfer_row + '][entry_date]" value="" size="8" required class="form-control form_date" /></td>';
    html += '    <td><input type="text" name="transfer[' + transfer_row + '][transfer_comment]" value="" size="8" required class="form-control" /></td>';
	html += '    <td><a onclick="$(\'#transfer-row' + transfer_row + '\').remove();" class="btn btn-danger">Remove</a></td>';
	html += '  </tr>';	
    html += '</tbody>';
	
	$('#transfer tfoot').before(html);
	$('#transfer-row' + transfer_row + ' .form_date').datepicker({dateFormat: 'yy-mm-dd'});
	transfer_row++;
}

function get_employee_info(emp_id,row_id) {
	//alert (emp_id);
	//alert (row_id);	
	$.ajax({
		url : "<?php echo e(url::to('get-employee-info-training')); ?>"+"/"+ emp_id,
		type: "GET",
		dataType: "JSON",
		success: function(data)
		{
			if(data.error==1) {
				alert ('This ID is not available!');
			} else {
				document.getElementById("emp_name"+row_id).value=data.emp_name;
				document.getElementById("br_code"+row_id).value=data.br_code;
				document.getElementById("designation_code"+row_id).value=data.designation_code;
			}
			//alert (data.designation_code);		
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			//alert('Error: To Get Info');
		}
	});
}

$("table").on("keyup", ".transfer_amt", function () {
    calculateSum();
});

function calculateSum() {
	var sum = 0;
    //iterate through each textboxes and add the values
    $(".transfer_amt").each(function () {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseInt(this.value);
        }

    });
    //.toFixed() method will roundoff the final sum to 2 decimal places
    //$("#sum").html(sum.toFixed(2));
	var total_amount = parseInt($('#total_amount').val());
    var collection_amt = sum;
	if (total_amount < collection_amt) {
		alert ('Collection Amount is greater than Balance!')
		$("#submit").prop("disabled", true);
	} else {
		$("#submit").prop("disabled", false);
	}
}

</script>