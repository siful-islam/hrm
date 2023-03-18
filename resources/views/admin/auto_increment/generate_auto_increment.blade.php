@extends('admin.admin_master')
@section('main_content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small>{{$Heading}}</small></h1>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
				
					<form class="form-horizontal" action="{{URL::to('next-incre-auto')}}" method="post">
						{{ csrf_field() }}		
						<div class="form-group">
							<div class="col-sm-2">
								<select name="search_month" id="search_month" class="form-control">
									<option value="07">JULY</option>
								</select>
							</div>
							<div class="col-sm-2">
								<select name="search_year" class="form-control">
									<?php for($year = 2019;$year<=$search_year;$year++){ ?>
									<option value="<?php echo $year; ?>" <?php if($year == $search_year) {echo 'selected';}?>><?php echo $year; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-2">
								<select name="search_branch" id="search_branch" class="form-control" required>
									<option value="" hidden>-Select Branch-</option>
									<?php foreach($all_branches as $all_branch) { ?>
									<option value="<?php echo $all_branch->br_code?>"><?php echo $all_branch->branch_name.' ('.$all_branch->br_code.')'?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-1">
								<button type="submit" class="btn btn-danger"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
							</div>
						</div>
					</form>
					
				</div>
				
				
						@if (!empty($all_result))
							
						<form action="{{URL::to('next-incre-auto-generate')}}" method="post">
							{{ csrf_field() }}	
							
							<input type="hidden" name="effect_date" id="" value="{{$increment_date}}">
							<input type="hidden" name="branch_code" id="" value="{{$branch_code}}">
							
							<div class="row">
								<div class="col-md-12">
									<table class="table table-bordered" cellspacing="0">
										<thead>
											<tr>
												<th>SL No.</th>
												<th>Employee ID</th>
												<th>Staff Name</th>
												<th>Designation</th>
												<th>Workstation</th>
												<th>Grade</th>
												<th>Step</th>
												<th>No of Increment</th>
												<th><input type="checkbox" id="selectall" onClick="selectAll(this);" /></th>
											</tr>
										</thead>
										<tbody>
											{{!$i=1}} @foreach($all_result as $result)

											<input type="hidden" name="emp_id[]" id="" value="{{$result['emp_id']}}">
											<input type="hidden" name="grade_code[]" id="" value="{{$result['grade_code']}}">
											<input type="hidden" name="grade_step[]" id="" value="{{$result['grade_step'] +1}}">
											<input type="hidden" name="designation_code[]" id="" value="{{$result['next_designation_code']}}">
											<input type="hidden" name="br_code[]" id="" value="{{$result['br_code']}}">
											<input type="hidden" name="designation_name[]" id="" value="{{$result['designation_name']}}">
											<input type="hidden" name="report_to[]" id="" value="{{$result['report_to']}}">
											<input type="hidden" name="department_code[]" id="" value="{{$result['department_code']}}">
											<input type="hidden" name="salary_br_code[]" id="" value="{{$result['salary_br_code']}}">
											<input type="hidden" name="designation_bangla[]" id="" value="{{$result['designation_bangla']}}">
											<input type="hidden" name="br_name_bangla[]" id="" value="{{$result['br_name_bangla']}}">
											<input type="hidden" name="emp_name_ban[]" id="" value="{{$result['emp_name_ban']}}">
											<input type="hidden" name="br_join_date[]" id="" value="{{$result['br_join_date']}}">
											<input type="hidden" name="grade_effect_date[]" id="" value="{{$result['grade_effect_date']}}">
											
											<input type="hidden" name="area_name_bn[]" id="" value="{{$result['area_name_bn']}}">
											<input type="hidden" name="zone_name_bn[]" id="" value="{{$result['zone_name_bn']}}">
											<?php if(!empty($result['increment_marked'])) { 
											$style 	= 'background:#ED2225;color:#fff;';
											$checked = '';
											}else{
											$style 	= '';
											$checked = 'checked';
											}
											$styles 	= '';
											if(!empty($result['promotion_increment_mark'])) { 
											$styles 	= 'background:#238208;color:#fff;';
											$checked = '';
											}
			
											//echo $result['promotion_increment_mark'];
			
											?>
											<tr>
												<td>{{$i++}}</td>
												<td style="<?php echo $style;?>"><?php echo $result['emp_id']; ?></td>
												<td style="<?php echo $styles;?>">{{$result['emp_name_eng']}}</td>
												<td>{{$result['designation_name']}}</td>
												<td>{{$result['branch_name']}}</td>
												<td>{{$result['grade_name']}}</td>
												<td>{{$result['grade_step']}}</td>
												<td>
													<select name="no_increment[]" id="no_increment">
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
													</select>
												</td>
												<td><input type="checkbox" name="flag[]" value="{{$result['emp_id']}}" <?php echo $checked;?>></td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
							
			
							<button type="submit" name="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i> Generate Increment</button>
							<br>
							<hr>
							
						</form>
						
						
						@endif
						
			</div>
        </div>
	</div>
	
</section>

<script language="JavaScript">
	function selectAll(source) {
		checkboxes = document.getElementsByName('flag[]');
		for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
	}
</script>

<script>
	document.getElementById("search_branch").value = '<?php echo $search_branch?>';
</script>
	

@endsection

