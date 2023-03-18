@extends('admin.admin_master')
@section('main_content')

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>Increment</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Employee</a></li>
			<li class="active">Generate Increment</li>
		</ol>
	</section>

	<!-- Main content -->

	
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<!-- Horizontal Form -->
				<div class="box box-info">
					<div class="box-header with-border">
					   <h3 class="box-title">Increment Generator</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					
						<div class="box-body">
							<form class="form-horizontal" action="{{URL::to('search-increment-employee')}}" method="post">
								{{ csrf_field() }}		
								<div class="form-group">
									<div class="col-sm-2">
										<select name="search_month" id="search_month" class="form-control">
											<option value="07">JULY</option>
											<option value="01">JANUARY</option>
										</select>
									</div>
									<div class="col-sm-2">
										<select name="search_year" class="form-control">
											<?php for($year = 2010;$year<=$search_year;$year++){ ?>
											<option value="<?php echo $year; ?>" <?php if($year == $search_year) {echo 'selected';}?>><?php echo $year; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-2">
										<select name="search_branch" class="form-control">
											<option value="all">All Branch</option>
											<?php foreach($all_branches as $all_branch) { ?>
											<option value="<?php echo $all_branch->br_code?>"><?php echo $all_branch->branch_name?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-2">
										<select name="type" id="type" class="form-control">
											<option value="Increment">Increment</option>
											<option value="Review">Review</option>
										</select>
									</div>
									<div class="col-sm-1">
										<button type="submit" class="btn btn-danger"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
									</div>
								</div>
							</form>
							<hr>
							
						<?php if($info !='') { ?>	
						
						<?php if(count($info)) { ?>	
							
							<div class="row">
								<div class="col-xs-12">
									<div class="box">
										<div class="box-header">
											<h3 class="box-title">Eligible Employee for Increment or Review</h3>
											<div class="box-tools">
												<div class="input-group input-group-sm" style="width: 150px;">
													<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
													<div class="input-group-btn">
														<button type="button" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
													</div>
												</div>
											</div>
										</div>
										<!-- /.box-header -->
										<form class="form-horizontal" action="{{URL::to($action)}}" method="post">	
										{{ csrf_field() }}	
											<hr>
											<div class="form-group">
												<label class="col-sm-1 control-label">Letter Date</label>
												<div class="col-sm-2">
													<input type="date" name="letter_date" class="form-control" value="<?php echo $letter_date = date('Y-m-d');?>">
												</div>
												<label class="col-sm-1 control-label">Effect Date</label>
												<div class="col-sm-2">
													<input type="date" name="effect_date" class="form-control" value="<?php echo $effect_date = date('Y-m-d');?>">
												</div>
											</div>
																					
											<div class="box-body table-responsive no-padding">
												
												<table class="table table-bordered table-hover">
													<tr>
													   <th>#</th>
													   <th>No</th>
													   <th>Employee ID</th>
													   <th>Employee Name</th>
													   <th>Joining Date</th>
													   <th>Working Station</th>
													   <th>Grade</th>
													   <th>Grade Step</th>
													   <th>Next Increment</th>
													</tr>
													
													<?php $sl = 1; $i= 0; foreach($info as $increment_employe) { ?>
													
													<input type="hidden" value="<?php echo $increment_employe->designation_code;?>" name="designation_code[]">
													<input type="hidden" value="<?php echo $increment_employe->br_code;?>" name="br_code[]">
													<input type="hidden" value="<?php echo $increment_employe->grade_code;?>" name="grade_code[]">
													<input type="hidden" value="<?php echo $increment_employe->grade_step;?>" name="grade_step[]">
													<input type="hidden" value="<?php echo $increment_employe->department_code;?>" name="department_code[]">
													<input type="hidden" value="<?php echo $increment_employe->br_joined_date;?>" name="br_joined_date[]">
													<input type="hidden" value="<?php echo $increment_employe->report_to;?>" name="report_to[]">
													<input type="hidden" value="<?php echo $increment_type;?>" name="increment_type[]">
													<input type="hidden" value="<?php echo $increment_employe->is_permanent;?>" name="is_permanent[]">
													
													<input type="hidden" value="<?php echo $increment_employe->scale_basic_1st_step;?>" name="scale_basic_1st_step[]">
													<input type="hidden" value="<?php echo $increment_employe->increment_amount;?>" name="increment_amount[]">
													<input type="text" value="<?php echo $increment_employe->basic_salary;?>" name="basic_salary[]">

													<input type="hidden" value="1" name="status[]">
													
													<tr>
														<td><input type="checkbox" name="check_id[]" value="<?php echo $i;?>" checked></td>
														<td><?php echo $sl++;?>.</td>
														<td><input type="text" value="<?php echo $increment_employe->emp_id;?>" name="emp_id[]" readonly></td>
														<td><?php echo $increment_employe->emp_name_eng;?></td>
														<td><?php echo $increment_employe->org_join_date;?></td>
														<td><?php echo $increment_employe->branch_name;?></td>
														<td><?php echo $increment_employe->grade_name;?></td>
														<td><span class="label label-success">Step : <?php echo $increment_employe->grade_step;?></span></td>
														<td><input type="date" name="next_increment_date[]" value="<?php echo $next_increment_date;?>"></td>
													</tr>  
													<?php $i++; } ?>
													
												</table>
												<!-- /.box-body -->
												<div class="box-footer">
													<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save" aria-hidden="true"></i> Generate Increment</button>
												</div>
												<!-- /.box-footer -->
											</div>
											<!-- /.box-body -->
										</form>
									</div>
									<!-- /.box -->
								</div>
							</div>

						</div>
						
						
						<?php } else {  ?>
						
						<table class="table table-bordered table-hover">
							<tr>
							   <td align="center">No Employee Found</td>
							</tr>
						</table>
						<?php } ?>
						
						<?php } ?>
				</div>
				<!-- /.box -->
			</div>
		</div>
	</section>
	
	<script>
	document.getElementById("search_month").value = '<?php echo $search_month?>';
	document.getElementById("type").value = '<?php echo $type?>';
	</script>
	
	
	
	
	
	

	

@endsection