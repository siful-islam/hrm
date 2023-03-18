
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('main_content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		<br>
		<!-- Main row -->
		<div class="row"> 
        
				<!-- /.col -->
				<div class="col-md-3">
					<div class="box box-widget widget-user">
						<!-- Add the bg color to the header using any of the bg-* classes -->
						<div class="widget-user-header bg-aqua-active">
							<h3 class="widget-user-username"><?php echo $emp_name;?></h3>
							<h5 class="widget-user-desc"><?php //echo $designation_name;?></h5>
							<!--<h5 class="widget-user-desc"><?php //echo $department_name;?></h5>-->
						</div>
						<div class="widget-user-image">
				
							<?php if($emp_photo) { ?>
							<img class="profile-user-img img-responsive img-circle" src="<?php echo e(asset('public/employee/'.$emp_photo)); ?>" height="50" alt="User profile picture"> 
							<?php } else { ?>
								<?php if($gender == 'Male') { ?>
								<img class="profile-user-img img-responsive img-circle" src="<?php echo e(asset('public/avatars/no_photo_male.png')); ?>" alt="User profile picture">
								<?php } else{ ?>
								<img class="profile-user-img img-responsive img-circle" src="<?php echo e(asset('public/avatars/no_photo_female.jpg')); ?>" alt="User profile picture">
								<?php } ?>
							<?php } ?>
						</div>
						<br>							
						<div class="box-footer">
							<div class="row">
								<div class="col-sm-4 border-right">
									<div class="description-block">
										<h5 class="description-header">Grade</h5>
										<span class="description-text"><?php if($grade_code == 0) { echo '--';} else { echo $grade_code; }?></span>
									</div>
								</div>
								<div class="col-sm-4 border-right">
									<div class="description-block">
										<h5 class="description-header"></h5>
										<span class="description-text" style="color:blue;"><h3><?php echo $emp_id;?></h3></span>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="description-block">
										<h5 class="description-header">Step</h5>
										<span class="description-text"><?php if($grade_step == 0 ) { echo '--';} else { echo $grade_step-1; } ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="box-body">
							<div class="table-responsive">
								<table class="table no-margin">
									<tbody>
										<tr>
											<td><b>Designation:</b> </td>
											<td><?php echo $designation_name; ?></td>
										</tr>
										<tr>
											<td><b>Unit:</b></td>
											<td><?php echo e($emp_mapping->unit_name); ?></td>
										</tr>
										<tr>
											<td><b>Department:</b></td>
											<td><?php echo e($emp_mapping->department_name); ?></td>
										</tr>
										<tr>
											<td><b>Program:</b></td>
											<td><?php echo $emp_mapping->current_program_id == 1 ? 'Microfinance' : 'Special Program'; ?> 
											</td>
										</tr>
										<tr>
											<td><b>Branch:</b> </td>
											<td><?php echo $branch_name; ?></td>
										</tr>
										<tr>
											<td><b>Joining Date:</b> </td>
											<td><?php echo date('d-m-Y',strtotime($org_join_date)); ?></td>
										</tr>
										<?php if($emp_id <100000) { ?>
										<tr>
											<td><b>Permanent Date:</b> </td>
											<td><?php if($p_effect_date) { echo date('d-m-Y',strtotime($p_effect_date->effect_date)); } else { echo 'Not permanent yet';}  ?></td>
										</tr>
										
										<tr>
											<td><b>Last Promotion Date: </b></td>
											<td><?php if($promotion) { echo date('d-m-Y',strtotime($promotion->effect_date)); } else{ echo 'No Promotion'; }  ?></td>
										</tr>
										<?php } ?>
										<tr>
											<td><b>Service Length:</b> </td>
											<td>
												<?php 			
													$letter_date 	= date('Y-m-d');
													$joining_dates =   date('Y-m-d',strtotime($joining_date . "+1 days"));												
													date_default_timezone_set('Asia/Dhaka');
													$input_date = new DateTime($letter_date);
													$org_date = new DateTime($joining_dates);	
													$difference = date_diff($org_date, $input_date);
													echo $difference->y . " years, " . $difference->m." months"; 
												?>		
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				
			
				<div class="col-md-4 col-sm-6 col-xs-12">
					<a href="<?php echo e(URL::to('/basic_info')); ?>">
					<div class="info-box">
						<span class="info-box-icon bg-cadetblue" id="cv"><img src="<?php echo e(asset('public/profile/profile.png')); ?>" width="60%"></span>  
						<div class="info-box-content">
							<span class="info-box-text"><h3>My Profile</h3></span>
							<span class="info-box-number"></span>
						</div>
					</div>
					</a>
				</div>
				
				<div class="col-md-4 col-sm-6 col-xs-12"> 
					<a href="<?php echo e(URL::to('/pay_slips')); ?>">
					<div class="info-box">
						<span class="info-box-icon bg-maroon" id="pay"><img src="<?php echo e(asset('public/profile/payslip.png')); ?>" width="60%"></span>
						<div class="info-box-content">
							<span class="info-box-text"><h3>Pay Slip</h3></span>
							<span class="info-box-number"></span>
						</div>
					</div>
					</a>
				</div>
				
				<div class="col-md-4 col-sm-6 col-xs-12">
					<a href="<?php echo e(URL::to('/my_documents')); ?>"> 
					<div class="info-box">
						<span class="info-box-icon bg-red" id="document"><img src="<?php echo e(asset('public/profile/files.png')); ?>" width="60%"></span>
						<div class="info-box-content">
							<span class="info-box-text"><h3>Personal File</h3></span>
							<span class="info-box-number"><small></small></span> 
						</div>
					</div>
					</a>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<a href="<?php echo e(URL::to('/leave_visit')); ?>">      
					<div class="info-box">
						<span class="info-box-icon bg-orange" id="leave"><img src="<?php echo e(asset('public/profile/leave.png')); ?>" width="60%"></span>
						<div class="info-box-content">
							<span class="info-box-text"><h3>Leave & Visit</h3></span>
							<span class="info-box-number"><small></small></span>
						</div>
					</div>
					</a>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<a href="<?php echo e(URL::to('/my_benefit')); ?>">      
					<div class="info-box">
						<span class="info-box-icon bg-black" id="money"><img src="<?php echo e(asset('public/profile/my-benefits.png')); ?>" width="60%"></span>
						<div class="info-box-content">
							<span class="info-box-text"><h3>My Benefit</h3></span>
							<span class="info-box-number"><small></small></span>
						</div>
					</div>
					</a>
				</div>
        </div>
    </section>
	<!-- /.content -->
	

	<script>
        //To active  menu.......//
        $(document).ready(function() {
            $("#MainGroupSelf_Care").addClass('active');
            $("#My_Profile").addClass('active');
        });

    </script>

<?php $__env->stopSection(); ?>	
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>