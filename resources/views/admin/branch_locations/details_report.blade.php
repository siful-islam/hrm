@extends('admin.admin_master')
@section('main_content')
	<link rel = "stylesheet"
	      href = "{{ asset('public/admin-panel/css/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
	<div class = "box box-info">
	<br></br></br>
		<div class = "box-header">
			<div class = "col-md-12">
				<form action = "{{ URL::to('details_report') }}" method = "post" class = "form-horizontal"
				      role = "form">
					{{ csrf_field() }}
					<div class = "form-group">
						<div class = "col-md-12">
							<div class = "form-group row">
								<label for = "zone_code" class = "col-md-1 control-label">Zone</label>
								<div class = "col-md-2">
									<select name = "zone_code"
									        autocomplete = "off" id = "zone_code"
									        class = "form-control col-md-3 col-xs-12">
										<option value = "" hidden>Choose One</option>
										{{--<option value = "all">All</option>--}}
										@foreach($allZoneData as $zone)
											<option value = "{{ $zone->zone_code }}">{{ $zone->zone_name }}</option>
										@endforeach
									</select>
								</div>
								<label for = "area_code" class = "col-md-1 control-label">Area</label>
								<div class = "col-md-2" id = "area_code_div">
									<select name = "area_code"
									        autocomplete = "off" id = "area_code"
									        class = "form-control col-md-3 col-xs-12">
										<option value = "" hidden>Choose One</option>
										{{--<option value = "all">All</option>--}}
										@foreach($allAreaData as $area)
											<option value = "{{ $area->area_code }}">{{ $area->area_name }}</option>
										@endforeach
									</select>
								</div>
								<label for = "branch_code" class = "col-md-1 control-label">Branch</label>
								<div class = "col-md-2" id = "branch_code_div">
									<select name = "branch_code"
									        autocomplete = "off" id = "branch_code"
									        class = "form-control col-md-3 col-xs-12">
										<option value = "" hidden>Choose One</option>
										<option value = "all">All</option>
										@foreach($allBranchData as $branch)
											<option value = "{{ $branch->br_code }}">{{ $branch->branch_name }}</option>
										@endforeach
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
						@if(isset($zone_code))
				var zone_code = "{{ $zone_code }}";
				$.ajax({
					       type: 'POST', url: '{{ URL::to('zone_wise_area') }}', data: {
						'zone_code': zone_code, '_token': '{{ csrf_token() }}'
					}, success: function (e) {
						$("#area_code").html(e);
						document.getElementById("area_code").value = "@if(isset($area_code)){{ $area_code }}@endif";
					}
				       });
						@endif
						@if(isset($area_code))
				var area_code = "{{ $area_code }}";
				$.ajax({
					       type: 'POST', url: '{{ URL::to('area_wise_branch') }}', data: {
						'area_code': area_code, '_token': '{{ csrf_token() }}'
					}, success: function (e) {
						$("#branch_code").html(e);
						document.getElementById("branch_code").value = "@if(isset($branch_code)){{ $branch_code }}@endif";
					}
				       });
				@endif
				
				document.getElementById("zone_code").value = "@if(isset($zone_code)){{ $zone_code }}@endif";
				document.getElementById("branch_code").value = "@if(isset($branch_code)){{ $branch_code }}@endif";
				document.getElementById("area_code").value = "@if(isset($area_code)){{ $area_code }}@endif";
				
				
				$("#zone_code").change(function () {
					var zone_code = $("#zone_code").val();
					$.ajax({
						       type: 'POST', url: '{{ URL::to('zone_wise_area') }}', data: {
							'zone_code': zone_code, '_token': '{{ csrf_token() }}'
						}, success: function (e) {
							$("#area_code").html(e);
						}
					       });
				});
				$("#area_code").change(function () {
					var area_code = $("#area_code").val();
					$.ajax({
						       type: 'POST', url: '{{ URL::to('area_wise_branch') }}', data: {
							'area_code': area_code, '_token': '{{ csrf_token() }}'
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
			@foreach($allData as $data)
			  <tr <?php if ($data->branch_contract_validity < date('Y-m-d') AND $data->branch_ownership_type==1){echo 'style="background: red;color:white"';$r=$r+1;}  ?>>
				<td  style=" border: 1px solid black;">{{ $i=$i+1 }} </td>
				<td  style=" border: 1px solid black;">{{ $data->zone_name }}</td>
				<td style=" border: 1px solid black;">{{ $data->area_name }}</td>
				<td style=" border: 1px solid black;">{{ $data->branch_name }}</td>
				<td style=" border: 1px solid black;">{{ $data->main_br_code }}</td>
				<td style=" border: 1px solid black;">{{ date("d-m-Y", strtotime($data->branch_opening_date)) }}</td>
				<td style=" border: 1px solid black;">{{ $data->dis_name }}</td>
				<td style=" border: 1px solid black;">{{ $data->upa_name }}</td>
				<td style=" border: 1px solid black;">{!! $data->branch_present_address !!}, Upazila: {{$data->upa_name}}, District: {{$data->dis_name}} </td>
				<td style=" border: 1px solid black;">@if($data->branch_ownership_type == 1)
											Rent
										@else
											Owner
										@endif</td>
										<td style=" border: 1px solid black;">@if($data->branch_ownership_type == 1 && $data->contract_date !=NULL){{ date("d M, Y", strtotime($data->contract_date)) }}@endif</td>
				<td style=" border: 1px solid black;">@if($data->branch_ownership_type == 1){{ date("d M, Y", strtotime($data->branch_contract_validity)) }}@endif</td>
				<td style=" border: 1px solid black;">{{ $data->advance_amount }}</td>
				<td style=" border: 1px solid black;">@if($data->advance_adjust_monthly == 1 )
												Yes
											@else
												No
											@endif</td>
				<td style=" border: 1px solid black;">{{ $data->adjust_amount }}</td>
				<td style=" border: 1px solid black;">{{ $data->rent_amount }}</td>
				<td style=" border: 1px solid black;">{{ $data->vat_tax }}</td>
				<td style=" border: 1px solid black;">{{ $data->tax_vat }}</td>
				<td style=" border: 1px solid black;">{{ $data->rent_amount+$data->vat_tax+$data->tax_vat }}</td>
				<td style=" border: 1px solid black;">@if($data->office_type == 1)
											Multi-Storied Building
										@else
											Tin-Shade House
										@endif</td>
				<td style=" border: 1px solid black;">{{ $data->office_capacity_sq_feet }}</td>
				<td style=" border: 1px solid black;">{{ $data->office_capacity_rooms }}</td>
				<td style=" border: 1px solid black;">@if($data->residence_facility == 1)
											Yes
										@else
											No
										@endif</td>
				<td style=" border: 1px solid black;">{{ $data->number_of_staff_rooms }}</td>
				<td style=" border: 1px solid black;">{{ $data->number_of_guest_rooms }}</td>
				
				<td style=" border: 1px solid black;"><?php if(!empty($data->agreement_file)){ ?><a href="{{asset($data->agreement_file)}}" target="_blank"><i class="fa fa-file" aria-hidden="true"></i></a><?php } ?></td>
				
			  </tr>
			  @endforeach
			  
			</tbody>
		</table>
	</div>
			
		</div>
			
@endsection