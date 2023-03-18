@extends('admin.admin_master')
@section('main_content')
	<link rel = "stylesheet"
	      href = "{{ asset('public/admin-panel/css/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
	<div class = "box box-info">
	<br></br></br>
		<div class = "box-header">
			<div class = "col-md-12">
				<form action = "{{ URL::to('branch_locations_report') }}" method = "post" class = "form-horizontal"
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
		.strong {
			font-size: 16px;
		}
	</style>
	@if(isset($allData))
		@foreach($allData as $data)
			<div class = "box">
				<div class = "box-body">
					<div class = "row">
						<div class = "col-md-3">
							<div style = "font-size: 18px; text-align: center; margin-top: 15%; font-weight: bold; padding: 20px; border: 1px dashed black; background: lightgrey;">
								Zone: {{ $data->zone_name }}
							</div>
							<div style = "font-size: 18px; text-align: center; font-weight: bold; padding: 20px; border: 1px dashed black; background: lightgrey;">
								Area: {{ $data->area_name }}
							</div>
							<div style = "font-size: 18px; text-align: center; font-weight: bold; padding: 20px; border: 1px dashed black; background: lightgrey;">
								Branch: {{ $data->branch_name }}
							</div>
						</div>
						<div class = "col-md-4">
							<table id = "example1" class = "table table-bordered table-striped">
								<tr>
									<td class = "strong">Branch opening date</td>
									<td class = "strong">{{ date("d-m-Y", strtotime($data->branch_opening_date)) }}</td>
								</tr>
								<tr>
									<td class = "strong">Branch Address</td>
									<td class = "strong">{!! $data->branch_present_address !!}</td>
								</tr>
								<tr>
									<td class = "strong">Branch Lat</td>
									<td class = "strong">{{ $data->branch_lat }}</td>
								</tr>
								<tr>
									<td class = "strong">Branch Long</td>
									<td class = "strong">{{ $data->branch_long }}</td>
								</tr>
								<tr>
									<td class = "strong">Branch ownership</td>
									<td class = "strong">
										@if($data->branch_ownership_type == 1)
											Rent
										@else
											Owner
										@endif
									</td>
								</tr>
								@if($data->branch_ownership_type == 1)
									<tr>
										<td class = "strong">
											Branch contract validity
										</td>
										<td class = "strong">
											@if($data->branch_ownership_type == 1){{ date("d M, Y", strtotime($data->branch_contract_validity)) }}@endif
										</td>
									</tr>
									<tr>
										<td class = "strong">
											Advance amount
										</td>
										<td class = "strong">
											{{ $data->advance_amount }}
										</td>
									</tr>
									<tr>
										<td class = "strong">
											Advance adjust (Monthly)
										</td>
										<td class = "strong">
											@if($data->advance_adjust_monthly == 1 )
												Yes
											@else
												No
											@endif
										</td>
									</tr>
									<tr>
										<td class = "strong">
											Adjust amount
										</td>
										<td class = "strong">
											{{ $data->adjust_amount }}
										</td>
									</tr>
									<tr>
										<td class = "strong">
											Rent amount
										</td>
										<td class = "strong">
											{{ $data->rent_amount }}
										</td>
									</tr>
									<tr>
										<td class = "strong">
											Vat & Tax
										</td>
										<td class = "strong">
											{{ $data->vat_tax }}
										</td>
									</tr>
									<tr>
										<td class = "strong">
											Total Rent with Vat & Tax
										</td>
										<td class = "strong">
											{{ $data->total_rent_amount_with_vat_tax }}
										</td>
									</tr>
								@endif
								<tr>
									<td class = "strong">
										Office type
									</td>
									<td class = "strong">
										@if($data->office_type == 1)
											Multi-Storied Building
										@else
											Tin-Shade House
										@endif
									</td>
								</tr>
								<tr>
									<td class = "strong">
										Office capacity (sq feet)
									</td>
									<td class = "strong">
										{{ $data->office_capacity_sq_feet }}
									</td>
								</tr>
								<tr>
									<td class = "strong">
										Office capacity (rooms)
									</td>
									<td class = "strong">
										{{ $data->office_capacity_rooms }}
									</td>
								</tr>
								<tr>
									<td class = "strong">
										Residence facility
									</td>
									<td class = "strong">
										@if($data->residence_facility == 1)
											Yes
										@else
											No
										@endif
									</td>
								</tr>
								<tr>
									<td class = "strong">
										Number of guest rooms
									</td>
									<td class = "strong">
										{{ $data->number_of_guest_rooms }}
									</td>
								</tr>
								<tr>
									<td class = "strong">
										Last Update
									</td>
									<td class = "strong">
										@if(!empty($data->branch_location_updated_at))
											{{ \Carbon\Carbon::parse($data->branch_location_updated_at)->diffForhumans() }}
										@else
											{{ \Carbon\Carbon::parse($data->branch_location_created_at)->diffForhumans() }}
										@endif
									</td>
								</tr>
								<tr>
									<td colspan="2" class = "strong">
										<h3 class="text-center">
											<a href="http://www.google.com/maps/place/{{ $data->branch_lat }},{{ $data->branch_long }}" rel="nofollow noreferrer" target="_blank">Location</a>
											{{--<a href="http://www.google.com/maps/{{ '@'.$data->branch_lat }},{{ $data->branch_long }},17z" rel="nofollow noreferrer" target="_blank">Location</a>--}}
										</h3>
									</td>
								</tr>
							</table>
						</div>
						<div class = "col-md-4">
							<img style = "max-height: 500px" class = "img-thumbnail"
							     src = "{{ asset($data->branch_photo) }}" alt = "IMAGE"/>
						</div>
					</div>
				</div>
			</div>
			<!-- /.box -->
		@endforeach
	@endif
@endsection