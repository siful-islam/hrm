@extends('admin.admin_master')
@section('main_content')
	<link rel = "stylesheet"
	      href = "{{ asset('public/admin-panel/css/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
	<div class = "box box-info">
		<div class = "box-header">
			<?php
				$count_data = DB::table( 'branch_locations as bl' )
						 ->where( 'bl.branch_code', Session::get( 'branch_code' ) )
			             ->get();
			?>
			<br></br>
			<?php if(count($count_data)<1){ ?>
				<a data-target = "#branch_locations" data-toggle = "modal"  class = "btn btn-flat btn-primary pull-right btn-sm">Add new</a>
			<?php } ?>
		</div>
		<!-- /.box-header -->
		<div class = "box-body table-responsive">
			
			<table id = "example1" class = "table table-bordered table-striped">
				<thead>
				<tr>
					
					<th>#</th>
					
					<th>Zone</th>
					
					<th>Area</th>
					
					<th>Branch</th>
					<th>Branch Code</th>
					<th>Branch Opening Date</th>
					
					<th>Branch Present Address</th>
					
					<!--th>Branch Latitude</th>
					
					<th>Branch Longitude</th-->
					
					<!--th>Last Update</th-->
					
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
				@foreach($allData as $data)
					<tr>
						
						<td>{{ $loop->iteration }}</td>
						
						<td>{{ $data->zone_name }}</td>
						
						<td>{{ $data->area_name }}</td>
						
						<td>{{ $data->branch_name }}</td>
						<td>{{ $data->br_code }}</td>
						<td>{{ date("d-m-Y", strtotime($data->branch_opening_date)) }}</td>
						
						<td>{{ $data->branch_present_address }}, Upazila:{{$data->upa_name}}, District:{{$data->dis_name}}</td>
						
						<!--td>{{ $data->branch_lat }}</td>
						
						<td>{{ $data->branch_long }}</td-->
						
						<!--td>
							@if(!empty($data->branch_location_updated_at))
								{{ \Carbon\Carbon::parse($data->branch_location_updated_at)->diffForhumans() }}
							@else
								{{ \Carbon\Carbon::parse($data->branch_location_created_at)->diffForhumans() }}
							@endif
						</td-->
						
						<td>
							<button type = "button" class = "btn btn-primary btn-xs button edit_button"
							        data-toggle = "modal" data-target = "#edit_branch_locations"
							        data-branch_location_id = "{{ $data->branch_location_id }}"
							        data-branch_code = "{{ $data->branch_code }}"
							        data-branch_opening_date = "{{ $data->branch_opening_date }}"
									data-dis_code = "{{ $data->dis_code }}"
									data-upa_code = "{{ $data->upa_code }}"
							        data-branch_present_address = "{{ $data->branch_present_address }}"
							        data-branch_lat = "{{ $data->branch_lat }}"
							        data-branch_long = "{{ $data->branch_long }}"
							        data-branch_ownership_type = "{{ $data->branch_ownership_type }}"
									data-contract_date = "{{ $data->contract_date }}"
							        data-branch_contract_validity = "{{ $data->branch_contract_validity }}"
							        data-advance_amount = "{{ $data->advance_amount }}"
							        data-advance_adjust_monthly = "{{ $data->advance_adjust_monthly }}"
							        data-adjust_amount = "{{ $data->adjust_amount }}"
							        data-rent_amount = "{{ $data->rent_amount }}"
							        data-vat_tax = "{{ $data->vat_tax }}"
									data-tax_vat = "{{ $data->tax_vat }}"
							        data-total_rent_amount_with_vat_tax = "{{ $data->total_rent_amount_with_vat_tax }}"
							        data-office_type = "{{ $data->office_type }}"
							        data-office_capacity_sq_feet = "{{ $data->office_capacity_sq_feet }}"
							        data-office_capacity_rooms = "{{ $data->office_capacity_rooms }}"
							        data-residence_facility = "{{ $data->residence_facility }}"
									data-number_of_staff_rooms = "{{ $data->number_of_staff_rooms }}"
							        data-number_of_guest_rooms = "{{ $data->number_of_guest_rooms }}"
							        data-branch_photo = "{{ $data->branch_photo }}"
									data-agreement_file = "{{ $data->agreement_file }}"
							        data-branch_location_status = "{{ $data->branch_location_status }}"
							        data-branch_location_created_by = "{{ $data->branch_location_created_by }}"
							        data-branch_location_created_at = "{{ $data->branch_location_created_at }}"
							        data-branch_location_updated_by = "{{ $data->branch_location_updated_by }}"
							        data-branch_location_updated_at = "{{ $data->branch_location_updated_at }}"
							>
								<i class = "fa fa-pencil"></i> Edit
							</button>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
	<style>
		.modal-dialog {
			width: 70%;
		}
		
		.remove {
			color: red;
		}
		
		.cls {
			cursor: pointer;
		}
		
		#photo {
			cursor: pointer;
		}
	</style>
	<div aria-hidden = "true" aria-labelledby = "myModalLabel" role = "dialog" tabindex = "-1" id = "branch_locations"
	     class = "modal fade">
		<div class = "modal-dialog">
			<div class = "modal-content">
				<div class = "modal-header">
					<button aria-hidden = "true" data-dismiss = "modal" class = "close" type = "button">×</button>
					<h3 class = "modal-title">Branch Location</h3>
				</div>
				<div class = "modal-body">
					<div class = "row">
						<form method = "post" action = "{{ URL::to('save_branch_locations') }}" data-parsley-validate
						      class = "form-horizontal form-label-left" enctype = "multipart/form-data">
							{{ csrf_field() }}
							
							<div class = "col-md-6">
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "branch_code">
										Branch<span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<select required name = "branch_code"
										        autocomplete = "off" id = "branch_code"
										        class = "form-control col-md-7 col-xs-12">
											<option value = "" hidden>Choose One</option>
											@foreach($allBranchData as $branch)
												<option value = "{{ $branch->br_code }}">{{ $branch->branch_name }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "branch_opening_date">
										Branch Opening Date<span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input required type = "date" name = "branch_opening_date" autocomplete = "off"
										       id = "branch_opening_date" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "branch_code">
										District<span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<select required name = "dis_code"
										        autocomplete = "off" id = "dis_code"
										        class = "form-control col-md-7 col-xs-12">
											<option value = "" hidden>Choose One</option>
											@foreach($allDistrictData as $dbranch)
												<option value = "{{ $dbranch->dis_code }}">{{ $dbranch->dis_name }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "branch_code">
										Upazila<span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<select required name = "upa_code"
										        autocomplete = "off" id = "upa_code"
										        class = "form-control col-md-7 col-xs-12">
											<option value = "" hidden>Choose One</option>
											
										</select>
									</div>
								</div>
								<script>
									$(document).on("change", "#dis_code", function () {
										var dis_code = $(this).val();   
										 
										$.ajax({
											url : "{{ url::to('select-cibupazila') }}"+"/"+dis_code,
											type: "GET",
											success: function(data)
											{												
												$("#upa_code").html(data);
												 
											}
										});  
									});
								</script>
								
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "branch_present_address">
										House/Road/Village<span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<textarea required name = "branch_present_address"
										          autocomplete = "off" id = "branch_present_address"
										          class = "form-control col-md-7 col-xs-12" style="height: 150px;"></textarea>
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "branch_lat">
										Branch Latitude <span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input required type = "text" name = "branch_lat" autocomplete = "off"
										       id = "branch_lat" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "branch_long">
										Branch Longitude <span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input required type = "text" name = "branch_long" autocomplete = "off"
										       id = "branch_long" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "branch_ownership_type">
										Branch Ownership Type <span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<select required name = "branch_ownership_type"
										        autocomplete = "off" id = "branch_ownership_type"
										        class = "form-control col-md-7 col-xs-12">
											<option value = "" hidden>Choose One</option>
											<option value = "1">Rent</option>
											<option value = "2">Own</option>
										</select>
									</div>
								</div>
								<div class = "form-group" id = "contract_date_div">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "contract_date">
										Branch Contract Date
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "date" name = "contract_date" autocomplete = "off"
										       id = "contract_date"
										       class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "branch_contract_validity_div">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "branch_contract_validity">
										Branch Contract Validity
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "date" name = "branch_contract_validity" autocomplete = "off"
										       id = "branch_contract_validity"
										       class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "advance_amount_div">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "advance_amount">
										Advance Amount
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "advance_amount" autocomplete = "off"
										       id = "advance_amount" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "advance_adjust_monthly_div">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "advance_adjust_monthly">
										Adjust From Advance (Monthly)
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<select name = "advance_adjust_monthly" autocomplete = "off"
										        id = "advance_adjust_monthly" class = "form-control col-md-7 col-xs-12">
											<option value = "" hidden>Choose One</option>
											<option value = "1">Yes</option>
											<option value = "0">No</option>
										</select>
									</div>
								</div>
								<div class = "form-group" id = "adjust_amount_div">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "adjust_amount">
										Adjust Amount
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "adjust_amount" autocomplete = "off"
										       id = "adjust_amount" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
							</div>
							<script>
								$(function () {
									$("#contract_date_div").hide();
									$("#contract_date").removeAttr('required');
									$("#branch_contract_validity_div").hide();
									$("#branch_contract_validity").removeAttr('required');
									$("#advance_amount_div").hide();
									$("#advance_amount").removeAttr('required');
									$("#advance_adjust_monthly_div").hide();
									$("#advance_adjust_monthly").removeAttr('required');
									$("#adjust_amount_div").hide();
									$("#adjust_amount").removeAttr('required');
									$("#rent_amount_div").hide();
									$("#rent_amount").removeAttr('required', 'required');
									$("#vat_tax_div").hide();
									$("#tax_vat_div").hide();
									$("#branch_ownership_type").change(function () {
										var branch_ownership_type = $(this).val();
										if ( branch_ownership_type == 1 ) {
											$("#contract_date_div").show();
											$("#contract_date").attr('required', 'required');
											$("#branch_contract_validity_div").show();
											$("#branch_contract_validity").attr('required', 'required');
											$("#advance_amount_div").show();
											$("#advance_amount").attr('required', 'required');
											$("#advance_adjust_monthly_div").show();
											$("#advance_adjust_monthly").attr('required', 'required');
											$("#advance_adjust_monthly").val('');
											$("#rent_amount_div").show();
											$("#rent_amount").attr('required', 'required');
											$("#vat_tax_div").show();
											$("#tax_vat_div").show();
										} else {
											$("#contract_date_div").hide();
											$("#contract_date").removeAttr('required');
											$("#branch_contract_validity_div").hide();
											$("#branch_contract_validity").removeAttr('required');
											$("#advance_amount_div").hide();
											$("#advance_amount").removeAttr('required');
											$("#advance_adjust_monthly_div").hide();
											$("#advance_adjust_monthly").removeAttr('required');
											$("#adjust_amount_div").hide();
											$("#adjust_amount").removeAttr('required');
											$("#rent_amount_div").hide();
											$("#rent_amount").removeAttr('required', 'required');
											$("#vat_tax_div").hide();
											$("#tax_vat_div").hide();
										}
									})
								});
								
								$(function () {
									$("#adjust_amount_div").hide();
									$("#adjust_amount").removeAttr('required');
									
									$("#advance_adjust_monthly").change(function () {
										var advance_adjust_monthly = $(this).val();
										if ( advance_adjust_monthly == 1 ) {
											$("#adjust_amount_div").show();
											$("#adjust_amount").attr('required', 'required');
										} else {
											$("#adjust_amount_div").hide();
											$("#adjust_amount").removeAttr('required');
										}
									})
								})
								
								$(function () {
									$("#pre_staff_room").hide();
									$("#number_of_staff_rooms").removeAttr('required');
									$("#pre_guest_room").hide();
									$("#number_of_guest_rooms").removeAttr('required');
									
									$("#residence_facility").change(function () {
										var residence_facility = $(this).val();
										if ( residence_facility == 1 ) {
											$("#pre_staff_room").show();
											$("#number_of_staff_rooms").attr('required', 'required');
											$("#pre_guest_room").show();
											$("#number_of_guest_rooms").attr('required', 'required');
										} else {
											$("#pre_staff_room").hide();
											$("#number_of_staff_rooms").removeAttr('required');
											$("#pre_guest_room").hide();
											$("#number_of_guest_rooms").removeAttr('required');
										}
									})
								})
							</script>
							<div class = "col-md-6">
								<div class = "form-group" id = "rent_amount_div">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "rent_amount">
										Rent Amount
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "rent_amount" autocomplete = "off"
										       id = "rent_amount" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "vat_tax_div">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "vat_tax">
										VAT (Amount)
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "vat_tax" autocomplete = "off" id = "vat_tax"
										       class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "tax_vat_div">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "vat_tax">
										TAX (Amount)
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "tax_vat" autocomplete = "off" id = "vat_tax"
										       class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "office_type">
										Office Type
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<select name = "office_type" autocomplete = "off"
										        id = "office_type" class = "form-control col-md-7 col-xs-12">
											<option value = "" hidden>Choose One</option>
											<option value = "1">Multi-Storied Building</option>
											<option value = "2">Tin-Shade House</option>
										</select>
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "office_capacity_sq_feet">
										Office Capacity (Square Feet)
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "office_capacity_sq_feet" autocomplete = "off"
										       id = "office_capacity_sq_feet" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "office_capacity_rooms">
										Office Capacity (Rooms)
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "office_capacity_rooms" autocomplete = "off"
										       id = "office_capacity_rooms" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "res_facility">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "residence_facility">
										Residence Facility
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<select name = "residence_facility" autocomplete = "off"
										        id = "residence_facility" class = "form-control col-md-7 col-xs-12">
											<option value = "" hidden>Choose One</option>
											<option value = "1">Yes</option>
											<option value = "0">No</option>
										</select>
									</div>
								</div>
								<div class = "form-group" id = "pre_staff_room">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "number_of_staff_rooms">
										Number Of Rooms (Office Staff)
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "number_of_staff_rooms" autocomplete = "off"
										       id = "number_of_guest_rooms" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "pre_guest_room">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "number_of_guest_rooms">
										Number Of Rooms (Guest)
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "number_of_guest_rooms" autocomplete = "off"
										       id = "number_of_guest_rooms" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "branch_photo">
										Branch Photo <span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<!--div id = "close" class = "remove cls">x Remove image</div-->
										<label for = "branch_photo">
											<img id = "photo" name = "photo"
											     class = "img-thumbnail media"
											     src = "https://via.placeholder.com/150" alt = "IMAGE"/>
										</label>
										<input style = "visibility: hidden" required type = "file" name = "branch_photo"
										       autocomplete = "off"
										       id = "branch_photo" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<script>
									if ( window.File && window.FileList && window.FileReader ) {
										$("#branch_photo").on("change", function (e) {
											var files = e.target.files;
											var f = files[ 0 ];
											var fileReader = new FileReader();
											fileReader.onload = function (e) {
												$('#photo').attr('src', e.target.result);
											};
											fileReader.readAsDataURL(f);
										});
									} else {
										alert("Your browser doesn't support to File API")
									}
									$(function () {
										$("#close").click(function () {
											$('#photo').attr('src', 'https://via.placeholder.com/150');
											$('#media_value').val('');
										});
									});
								</script>
								<div class = "ln_solid"></div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "branch_photo">
										Branch Rental Agreement 
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										
										<input type = "file" name = "agreement_file"
										       autocomplete = "off"
										       id = "agreement_file" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group">
									<div class = "col-md-7 col-sm-6 col-xs-12 col-md-offset-3">
										<button type = "submit" id = "button"
										        class = "btn btn-primary btn-flat pull-right">Save
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				
				</div>
			</div>
		</div>
	</div>
	
	
	{{--For edit--}}
	<div aria-hidden = "true" aria-labelledby = "myModalLabel" role = "dialog" tabindex = "-1"
	     id = "edit_branch_locations" class = "modal fade">
		<div class = "modal-dialog">
			<div class = "modal-content">
				<div class = "modal-header">
					<button aria-hidden = "true" data-dismiss = "modal" class = "close" type = "button">×</button>
					<h3 class = "modal-title">Edit Branch Location</h3>
				</div>
				<div class = "modal-body">
					<div class = "row">
						<form method = "post" action = "{{ URL::to('update_branch_locations') }}" data-parsley-validate
						      class = "form-horizontal form-label-left" enctype = "multipart/form-data">
							{{ csrf_field() }}
							{{ method_field('PATCH') }}
							<input required type = "hidden" name = "branch_location_id" id = "edit_branch_location_id"/>
							<div class = "col-md-6">
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "edit_branch_code">
										Branch <span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<select required name = "branch_code"
										        autocomplete = "off" id = "edit_branch_code"
										        class = "form-control col-md-7 col-xs-12">
											<option value = "" hidden>Choose One</option>
											@foreach($allBranchData as $branch)
												<option value = "{{ $branch->br_code }}">{{ $branch->branch_name }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "edit_branch_opening_date">
										Branch Opening Date <span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										
										<input required type = "date" name = "branch_opening_date" autocomplete = "off"
										       id = "edit_branch_opening_date"
										       class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "branch_code">
										District<span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<select required name = "dis_code"
										        autocomplete = "off" id = "edit_dis_code"
										        class = "form-control col-md-7 col-xs-12">
											<option value = "" hidden>Choose One</option>
											@foreach($allDistrictData as $dbranch)
												<option value = "{{ $dbranch->dis_code }}">{{ $dbranch->dis_name }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "branch_code">
										Upazila<span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<select required name = "upa_code"
										        autocomplete = "off" id = "edit_upa_code"
										        class = "form-control col-md-7 col-xs-12">
											<option value = "" hidden>Choose One</option>
											@foreach($allUpazilaData as $ubranch)
												<option value = "{{ $ubranch->upa_code }}">{{ $ubranch->upa_name }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<script>
									$(document).on("change", "#edit_dis_code", function () {
										var dis_code = $(this).val();   
										 
										$.ajax({
											url : "{{ url::to('select-cibupazila') }}"+"/"+dis_code,
											type: "GET",
											success: function(data)
											{												
												$("#edit_upa_code").html(data);
												 
											}
										});  
									});
								</script>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "edit_branch_present_address">
										House/Road/Village <span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<textarea required name = "branch_present_address"
										          autocomplete = "off" id = "edit_branch_present_address"
										          class = "form-control col-md-7 col-xs-12" style="height: 150px;"></textarea>
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "edit_branch_lat">
										Branch Latitude <span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input required type = "text" name = "branch_lat" autocomplete = "off"
										       id = "edit_branch_lat" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "edit_branch_long">
										Branch Longitude <span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input required type = "text" name = "branch_long" autocomplete = "off"
										       id = "edit_branch_long" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "edit_branch_ownership_type">
										Branch Ownership Type <span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<select required name = "branch_ownership_type"
										        autocomplete = "off" id = "edit_branch_ownership_type"
										        class = "form-control col-md-7 col-xs-12">
											<option value = "" hidden>Choose One</option>
											<option value = "1">Rent</option>
											<option value = "2">Own</option>
										</select>
									</div>
								</div>
								<div class = "form-group" id = "edit_contract_date_div">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "edit_contract_date">
										Branch Contract Date
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "date" name = "contract_date" autocomplete = "off"
										       id = "edit_contract_date"
										       class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "edit_branch_contract_validity_div">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "edit_branch_contract_validity">
										Branch Contract Validity
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "date" name = "branch_contract_validity" autocomplete = "off"
										       id = "edit_branch_contract_validity"
										       class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "edit_advance_amount_div">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "edit_advance_amount">
										Advance Amount
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "advance_amount" autocomplete = "off"
										       id = "edit_advance_amount" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "edit_advance_adjust_monthly_div">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "edit_advance_adjust_monthly">
										Adjust From Advance (Monthly)
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<select name = "advance_adjust_monthly" autocomplete = "off"
										        id = "edit_advance_adjust_monthly"
										        class = "form-control col-md-7 col-xs-12">
											<option value = "" hidden>Choose One</option>
											<option value = "1">Yes</option>
											<option value = "0">No</option>
										</select>
									</div>
								</div>
								<div class = "form-group" id = "edit_adjust_amount_div">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "edit_adjust_amount">
										Adjust Amount
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "adjust_amount" autocomplete = "off"
										       id = "edit_adjust_amount" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
							</div>
							<script>
								$(function () {
									$("#edit_branch_ownership_type").change(function () {
										var branch_ownership_type = $(this).val();
										if ( branch_ownership_type == 1 ) {
											$("#edit_contract_date_div").show();
											$("#edit_contract_date").attr('required', 'required');
											$("#edit_branch_contract_validity_div").show();
											$("#edit_branch_contract_validity").attr('required', 'required');
											$("#edit_advance_amount_div").show();
											$("#edit_advance_amount").attr('required', 'required');
											$("#edit_advance_adjust_monthly_div").show();
											$("#edit_advance_adjust_monthly").attr('required', 'required');
											$("#edit_advance_adjust_monthly").val('');
											$("#edit_rent_amount_div").show();
											$("#edit_rent_amount").attr('required', 'required');
											$("#edit_vat_tax_div").show();
										} else {
											$("#edit_contract_date_div").hide();
											$("#edit_contract_date").removeAttr('required');
											$("#edit_contract_date").val('');
											$("#edit_branch_contract_validity_div").hide();
											$("#edit_branch_contract_validity").removeAttr('required');
											$("#edit_branch_contract_validity").val('');
											$("#edit_advance_amount_div").hide();
											$("#edit_advance_amount").removeAttr('required');
											$("#edit_advance_amount").val('');
											$("#edit_advance_adjust_monthly_div").hide();
											$("#edit_advance_adjust_monthly").removeAttr('required');
											$("#edit_advance_adjust_monthly").val('');
											$("#edit_adjust_amount_div").hide();
											$("#edit_adjust_amount").removeAttr('required');
											$("#edit_adjust_amount").val('');
											$("#edit_rent_amount_div").hide();
											$("#edit_rent_amount").removeAttr('required', 'required');
											$("#edit_rent_amount").val('');
											$("#edit_vat_tax_div").hide();
										}
									})
								});
								
								$(function () {
									$("#edit_adjust_amount_div").hide();
									$("#edit_adjust_amount").removeAttr('required');
									
									$("#edit_advance_adjust_monthly").change(function () {
										var advance_adjust_monthly = $(this).val();
										if ( advance_adjust_monthly == 1 ) {
											$("#edit_adjust_amount_div").show();
											$("#edit_adjust_amount").attr('required', 'required');
										} else {
											$("#edit_adjust_amount_div").hide();
											$("#edit_adjust_amount").removeAttr('required');
										}
									})
								})
							</script>
							<div class = "col-md-6">
								<div class = "form-group" id = "edit_rent_amount_div">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "edit_rent_amount">
										Rent Amount
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "rent_amount" autocomplete = "off"
										       id = "edit_rent_amount" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "edit_vat_tax_div">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "edit_vat_tax">
										VAT (Amount)
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "vat_tax" autocomplete = "off" id = "edit_vat_tax"
										       class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "edit_vat_tax_div">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "edit_vat_tax">
										TAX (Amount)
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "tax_vat" autocomplete = "off" id = "edit_tax_vat"
										       class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "edit_office_type">
										Office Type
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<select name = "office_type" autocomplete = "off"
										        id = "edit_office_type" class = "form-control col-md-7 col-xs-12">
											<option value = "" hidden>Choose One</option>
											<option value = "1">Multi-Storied Building</option>
											<option value = "2">Tin-Shade House</option>
										</select>
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "edit_office_capacity_sq_feet">
										Office Capacity (Square Feet)
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "office_capacity_sq_feet" autocomplete = "off"
										       id = "edit_office_capacity_sq_feet"
										       class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "edit_office_capacity_rooms">
										Office Capacity (Rooms)
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "office_capacity_rooms" autocomplete = "off"
										       id = "edit_office_capacity_rooms"
										       class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "edit_residence_facility">
										Residence Facility
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<select name = "residence_facility" autocomplete = "off"
										        id = "edit_residence_facility"
										        class = "form-control col-md-7 col-xs-12">
											<option value = "" hidden>Choose One</option>
											<option value = "1">Yes</option>
											<option value = "0">No</option>
										</select>
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "edit_number_of_guest_rooms">
										Number Of Rooms(Office Staff)
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "number_of_staff_rooms" autocomplete = "off"
										       id = "edit_number_of_staff_rooms"
										       class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "edit_number_of_guest_rooms">
										Number Of Rooms (Guest)
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<input type = "text" name = "number_of_guest_rooms" autocomplete = "off"
										       id = "edit_number_of_guest_rooms"
										       class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12"
									       for = "edit_branch_photo">
										Branch Photo <span class = "required">*</span>
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										<!--div id = "edit_close" class = "remove cls">x Remove image</div-->
										<label for = "edit_branch_photo">
											<img id = "edit_photo" name = "photo"
											     class = "img-thumbnail media"
											     src = "https://via.placeholder.com/150" alt = "IMAGE"/>
										</label>
										<input style = "visibility: hidden" type = "file" name = "branch_photo"
										       autocomplete = "off"
										       id = "edit_branch_photo" class = "form-control col-md-7 col-xs-12">
									</div>
								</div>
								<script>
									if ( window.File && window.FileList && window.FileReader ) {
										$("#edit_branch_photo").on("change", function (e) {
											var files = e.target.files;
											var f = files[ 0 ];
											var fileReader = new FileReader();
											fileReader.onload = function (e) {
												$('#edit_photo').attr('src', e.target.result);
											};
											fileReader.readAsDataURL(f);
										});
									} else {
										alert("Your browser doesn't support to File API")
									}
									$(function () {
										$("#edit_close").click(function () {
											$('#edit_photo').attr('src', 'https://via.placeholder.com/150');
										});
									});
								</script>
								<div class = "ln_solid"></div>
								<div class = "form-group" id = "pre_vou_code1">
									<label class = "control-label col-md-4 col-sm-4 col-xs-12" for = "branch_photo">
										Branch Rental Agreement 
									</label>
									
									<div class = "col-md-6 col-sm-6 col-xs-12">
										
										<input type = "file" name = "agreement_file"
										       autocomplete = "off"
										        class = "form-control col-md-7 col-xs-12">
									</div>
									<div id = "edit_agreement_file"></div>
								</div>
								<div class = "form-group">
									<div class = "col-md-7 col-sm-6 col-xs-12 col-md-offset-3">
										<button type = "submit" id = "edit_save_button"
										        class = "btn btn-primary btn-flat pull-right">Save
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				
				</div>
			</div>
		</div>
	</div>
	
	<script>
		$(document).on("click", '.edit_button', function (e) {
			
			var branch_location_id = $(this).data('branch_location_id');
			$("#edit_branch_location_id").val(branch_location_id);
			var branch_code = $(this).data('branch_code');
			$("#edit_branch_code").val(branch_code);
			var branch_opening_date = $(this).data('branch_opening_date');
			$("#edit_branch_opening_date").val(branch_opening_date);
			var dis_code = $(this).data('dis_code');
			$("#edit_dis_code").val(dis_code);
			var upa_code = $(this).data('upa_code');
			$("#edit_upa_code").val(upa_code);
			var branch_present_address = $(this).data('branch_present_address');
			$("#edit_branch_present_address").val(branch_present_address);
			var branch_lat = $(this).data('branch_lat');
			$("#edit_branch_lat").val(branch_lat);
			var branch_long = $(this).data('branch_long');
			$("#edit_branch_long").val(branch_long);
			var branch_ownership_type = $(this).data('branch_ownership_type');
			$("#edit_branch_ownership_type").val(branch_ownership_type);
			
			if ( branch_ownership_type == 1 ) {
				$("#edit_contract_date_div").show();
				$("#edit_contract_date").attr('required', 'required');
				$("#edit_branch_contract_validity_div").show();
				$("#edit_branch_contract_validity").attr('required', 'required');
				$("#edit_advance_amount_div").show();
				$("#edit_advance_amount").attr('required', 'required');
				$("#edit_advance_adjust_monthly_div").show();
				$("#edit_advance_adjust_monthly").attr('required', 'required');
				$("#edit_advance_adjust_monthly").val('');
				$("#edit_rent_amount_div").show();
				$("#edit_rent_amount").attr('required', 'required');
				$("#edit_vat_tax_div").show();
			} else {
				$("#edit_contract_date_div").hide();
				$("#edit_contract_date").removeAttr('required');
				$("#edit_contract_date").val('');
				$("#edit_branch_contract_validity_div").hide();
				$("#edit_branch_contract_validity").removeAttr('required');
				$("#edit_branch_contract_validity").val('');
				$("#edit_advance_amount_div").hide();
				$("#edit_advance_amount").removeAttr('required');
				$("#edit_advance_amount").val('');
				$("#edit_advance_adjust_monthly_div").hide();
				$("#edit_advance_adjust_monthly").removeAttr('required');
				$("#edit_advance_adjust_monthly").val('');
				$("#edit_adjust_amount_div").hide();
				$("#edit_adjust_amount").removeAttr('required');
				$("#edit_adjust_amount").val('');
				$("#edit_rent_amount_div").hide();
				$("#edit_rent_amount").removeAttr('required', 'required');
				$("#edit_rent_amount").val('');
				$("#edit_vat_tax_div").hide();
			}
			var contract_date = $(this).data('contract_date');
			$("#edit_contract_date").val(contract_date);
			var branch_contract_validity = $(this).data('branch_contract_validity');
			$("#edit_branch_contract_validity").val(branch_contract_validity);
			var advance_amount = $(this).data('advance_amount');
			$("#edit_advance_amount").val(advance_amount);
			var advance_adjust_monthly = $(this).data('advance_adjust_monthly');
			$("#edit_advance_adjust_monthly").val(advance_adjust_monthly);
			var adjust_amount = $(this).data('adjust_amount');
			$("#edit_adjust_amount").val(adjust_amount);
			var rent_amount = $(this).data('rent_amount');
			$("#edit_rent_amount").val(rent_amount);
			var vat_tax = $(this).data('vat_tax');
			$("#edit_vat_tax").val(vat_tax);
			var tax_vat = $(this).data('tax_vat');
			$("#edit_tax_vat").val(tax_vat);
			var total_rent_amount_with_vat_tax = $(this).data('total_rent_amount_with_vat_tax');
			$("#edit_total_rent_amount_with_vat_tax").val(total_rent_amount_with_vat_tax);
			var office_type = $(this).data('office_type');
			$("#edit_office_type").val(office_type);
			var office_capacity_sq_feet = $(this).data('office_capacity_sq_feet');
			$("#edit_office_capacity_sq_feet").val(office_capacity_sq_feet);
			var office_capacity_rooms = $(this).data('office_capacity_rooms');
			$("#edit_office_capacity_rooms").val(office_capacity_rooms);
			var residence_facility = $(this).data('residence_facility');
			$("#edit_residence_facility").val(residence_facility);
			var number_of_staff_rooms = $(this).data('number_of_staff_rooms');
			$("#edit_number_of_staff_rooms").val(number_of_staff_rooms);
			var number_of_guest_rooms = $(this).data('number_of_guest_rooms');
			$("#edit_number_of_guest_rooms").val(number_of_guest_rooms);
			var branch_photo = $(this).data('branch_photo');
		
			$('#edit_photo').attr('src', branch_photo);
			
			var agreement_photo = $(this).data('agreement_file');
			$("#edit_agreement_file").html(agreement_photo);
			
			var branch_location_status = $(this).data('branch_location_status');
			$("#edit_branch_location_status").val(branch_location_status);
			var branch_location_created_by = $(this).data('branch_location_created_by');
			$("#edit_branch_location_created_by").val(branch_location_created_by);
			var branch_location_created_at = $(this).data('branch_location_created_at');
			$("#edit_branch_location_created_at").val(branch_location_created_at);
			var branch_location_updated_by = $(this).data('branch_location_updated_by');
			$("#edit_branch_location_updated_by").val(branch_location_updated_by);
			var branch_location_updated_at = $(this).data('branch_location_updated_at');
			$("#edit_branch_location_updated_at").val(branch_location_updated_at);
			
		});
	</script>
	<!-- DataTables -->
	<script src = "{{ asset('public/admin-panel/css/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src = "{{ asset('public/admin-panel/css/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
	<script>
		$(function () {
			$('#example1').DataTable()
			
		})
	</script>
@endsection