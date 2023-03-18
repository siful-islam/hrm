<?php $__env->startSection('main_content'); ?>
	<link rel = "stylesheet"
	      href = "<?php echo e(asset('public/admin-panel/css/datatables.net-bs/css/dataTables.bootstrap.min.css')); ?>">
	<div class = "box box-info">
	<br></br></br>
		<div class = "box-header">
			<div class = "col-md-12">
				<form action = "<?php echo e(URL::to('details_report')); ?>" method = "post" class = "form-horizontal"
				      role = "form">
					<?php echo e(csrf_field()); ?>

					<div class = "form-group">
						<div class = "col-md-12">
							<div class = "form-group row">
								<label for = "zone_code" class = "col-md-1 control-label">Zone</label>
								<div class = "col-md-2">
									<select name = "zone_code"
									        autocomplete = "off" id = "zone_code"
									        class = "form-control col-md-3 col-xs-12">
										<option value = "" hidden>Choose One</option>
										
										<?php $__currentLoopData = $allZoneData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value = "<?php echo e($zone->zone_code); ?>"><?php echo e($zone->zone_name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
								<label for = "area_code" class = "col-md-1 control-label">Area</label>
								<div class = "col-md-2" id = "area_code_div">
									<select name = "area_code"
									        autocomplete = "off" id = "area_code"
									        class = "form-control col-md-3 col-xs-12">
										<option value = "" hidden>Choose One</option>
										
										<?php $__currentLoopData = $allAreaData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value = "<?php echo e($area->area_code); ?>"><?php echo e($area->area_name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
								<label for = "branch_code" class = "col-md-1 control-label">Branch</label>
								<div class = "col-md-2" id = "branch_code_div">
									<select name = "branch_code"
									        autocomplete = "off" id = "branch_code"
									        class = "form-control col-md-3 col-xs-12">
										<option value = "" hidden>Choose One</option>
										<option value = "all">All</option>
										<?php $__currentLoopData = $allBranchData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value = "<?php echo e($branch->br_code); ?>"><?php echo e($branch->branch_name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
								<button type = "submit" class = "btn btn-primary btn-flat btn-sm">Search</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<script>
			$(function () {
						<?php if(isset($zone_code)): ?>
				var zone_code = "<?php echo e($zone_code); ?>";
				$.ajax({
					       type: 'POST', url: '<?php echo e(URL::to('zone_wise_area')); ?>', data: {
						'zone_code': zone_code, '_token': '<?php echo e(csrf_token()); ?>'
					}, success: function (e) {
						$("#area_code").html(e);
						document.getElementById("area_code").value = "<?php if(isset($area_code)): ?><?php echo e($area_code); ?><?php endif; ?>";
					}
				       });
						<?php endif; ?>
						<?php if(isset($area_code)): ?>
				var area_code = "<?php echo e($area_code); ?>";
				$.ajax({
					       type: 'POST', url: '<?php echo e(URL::to('area_wise_branch')); ?>', data: {
						'area_code': area_code, '_token': '<?php echo e(csrf_token()); ?>'
					}, success: function (e) {
						$("#branch_code").html(e);
						document.getElementById("branch_code").value = "<?php if(isset($branch_code)): ?><?php echo e($branch_code); ?><?php endif; ?>";
					}
				       });
				<?php endif; ?>
				
				document.getElementById("zone_code").value = "<?php if(isset($zone_code)): ?><?php echo e($zone_code); ?><?php endif; ?>";
				document.getElementById("branch_code").value = "<?php if(isset($branch_code)): ?><?php echo e($branch_code); ?><?php endif; ?>";
				document.getElementById("area_code").value = "<?php if(isset($area_code)): ?><?php echo e($area_code); ?><?php endif; ?>";
				
				
				$("#zone_code").change(function () {
					var zone_code = $("#zone_code").val();
					$.ajax({
						       type: 'POST', url: '<?php echo e(URL::to('zone_wise_area')); ?>', data: {
							'zone_code': zone_code, '_token': '<?php echo e(csrf_token()); ?>'
						}, success: function (e) {
							$("#area_code").html(e);
						}
					       });
				});
				$("#area_code").change(function () {
					var area_code = $("#area_code").val();
					$.ajax({
						       type: 'POST', url: '<?php echo e(URL::to('area_wise_branch')); ?>', data: {
							'area_code': area_code, '_token': '<?php echo e(csrf_token()); ?>'
						}, success: function (e) {
							$("#branch_code").html(e);
						}
					       });
				});
			})
		</script>
		<!-- /.box-header -->
		<!-- /.box-body -->
	</div>
	<style>
		.blue {
		background-color:#a3a375 !important;
	}
	.blue th {
		color:white !important;
	}
	table, th, td {
  border: 1px solid black;
}
	</style>		
		<div class = "col-md-12" id="log" >
		<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead class="blue">			
			  <tr>
			    <th style=" border: 1px solid black;">Sl</th>
				<th style=" border: 1px solid black;">Zone</th>
				<th style=" border: 1px solid black;">Area</th>
				<th style=" border: 1px solid black;">Branch</th>
				<th style=" border: 1px solid black;">Branch Code</th>
				<th style=" border: 1px solid black;">Branch Opening Date</th>
				<th style=" border: 1px solid black;">Branch District</th>
				<th style=" border: 1px solid black;">Branch Upazila</th>
				<th style=" border: 1px solid black;">Address</th>
				<th style=" border: 1px solid black;">Branch Ownership</th>
				<th style=" border: 1px solid black;">Branch Contract Date</th>
				<th style=" border: 1px solid black;">Branch Contract Validity</th>
				<th style=" border: 1px solid black;">Advance Amount</th>
				<th style=" border: 1px solid black;">Advance Adjust (Monthly)</th>
				<th style=" border: 1px solid black;">Adjust Amount</th>
				<th style=" border: 1px solid black;">Rent Amount</th>
				<th style=" border: 1px solid black;">VAT</th>
				<th style=" border: 1px solid black;">TAX</th>
				<th style=" border: 1px solid black;">Total Rent with Vat & Tax</th>
				<th style=" border: 1px solid black;">Office Type</th>
				<th style=" border: 1px solid black;">Office Capacity (sq feet)</th>
				<th style=" border: 1px solid black;">Office Capacity (rooms)</th>
				<th style=" border: 1px solid black;">Residence Facility</th>
				<th style=" border: 1px solid black;">Number of Staff Rooms</th>
				<th style=" border: 1px solid black;">Number of Guest Rooms</th>
				<th style=" border: 1px solid black;">Agreement File</th>
			  </tr>
			</thead>
			<tbody>
			<?php $i=0;$r=0 ?>
			<?php $__currentLoopData = $allData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			  <tr <?php if ($data->branch_contract_validity < date('Y-m-d') AND $data->branch_ownership_type==1){echo 'style="background: red;color:white"';$r=$r+1;}  ?>>
				<td  style=" border: 1px solid black;"><?php echo e($i=$i+1); ?> </td>
				<td  style=" border: 1px solid black;"><?php echo e($data->zone_name); ?></td>
				<td style=" border: 1px solid black;"><?php echo e($data->area_name); ?></td>
				<td style=" border: 1px solid black;"><?php echo e($data->branch_name); ?></td>
				<td style=" border: 1px solid black;"><?php echo e($data->main_br_code); ?></td>
				<td style=" border: 1px solid black;"><?php echo e(date("d-m-Y", strtotime($data->branch_opening_date))); ?></td>
				<td style=" border: 1px solid black;"><?php echo e($data->dis_name); ?></td>
				<td style=" border: 1px solid black;"><?php echo e($data->upa_name); ?></td>
				<td style=" border: 1px solid black;"><?php echo $data->branch_present_address; ?>, Upazila: <?php echo e($data->upa_name); ?>, District: <?php echo e($data->dis_name); ?> </td>
				<td style=" border: 1px solid black;"><?php if($data->branch_ownership_type == 1): ?>
											Rent
										<?php else: ?>
											Owner
										<?php endif; ?></td>
										<td style=" border: 1px solid black;"><?php if($data->branch_ownership_type == 1 && $data->contract_date !=NULL): ?><?php echo e(date("d M, Y", strtotime($data->contract_date))); ?><?php endif; ?></td>
				<td style=" border: 1px solid black;"><?php if($data->branch_ownership_type == 1): ?><?php echo e(date("d M, Y", strtotime($data->branch_contract_validity))); ?><?php endif; ?></td>
				<td style=" border: 1px solid black;"><?php echo e($data->advance_amount); ?></td>
				<td style=" border: 1px solid black;"><?php if($data->advance_adjust_monthly == 1 ): ?>
												Yes
											<?php else: ?>
												No
											<?php endif; ?></td>
				<td style=" border: 1px solid black;"><?php echo e($data->adjust_amount); ?></td>
				<td style=" border: 1px solid black;"><?php echo e($data->rent_amount); ?></td>
				<td style=" border: 1px solid black;"><?php echo e($data->vat_tax); ?></td>
				<td style=" border: 1px solid black;"><?php echo e($data->tax_vat); ?></td>
				<td style=" border: 1px solid black;"><?php echo e($data->rent_amount+$data->vat_tax+$data->tax_vat); ?></td>
				<td style=" border: 1px solid black;"><?php if($data->office_type == 1): ?>
											Multi-Storied Building
										<?php else: ?>
											Tin-Shade House
										<?php endif; ?></td>
				<td style=" border: 1px solid black;"><?php echo e($data->office_capacity_sq_feet); ?></td>
				<td style=" border: 1px solid black;"><?php echo e($data->office_capacity_rooms); ?></td>
				<td style=" border: 1px solid black;"><?php if($data->residence_facility == 1): ?>
											Yes
										<?php else: ?>
											No
										<?php endif; ?></td>
				<td style=" border: 1px solid black;"><?php echo e($data->number_of_staff_rooms); ?></td>
				<td style=" border: 1px solid black;"><?php echo e($data->number_of_guest_rooms); ?></td>
				
				<td style=" border: 1px solid black;"><?php if(!empty($data->agreement_file)){ ?><a href="<?php echo e(asset($data->agreement_file)); ?>" target="_blank"><i class="fa fa-file" aria-hidden="true"></i></a><?php } ?></td>
				
			  </tr>
			  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			  
			</tbody>
		</table>
	</div>
			
		</div>
			
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>