<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--title><?php echo isset($title) ? $title : 'CDIP | HRM' ; ?></title-->
	<title>HRM - <?php echo $__env->yieldContent('title'); ?></title>
	<link rel="shortcut icon" href="<?php echo e(asset(Session::get('favicon'))); ?>">
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/bower_components/bootstrap/dist/css/bootstrap.min.css')); ?>">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/bower_components/font-awesome/css/font-awesome.min.css')); ?>">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/bower_components/Ionicons/css/ionicons.min.css')); ?>">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')); ?>"> 
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css"> 
	<style>
		tfoot input {
		width: 100%;
		padding: 3px;
		box-sizing: border-box;
		}
			 tfoot {
			display: table-header-group;
		}
	</style>

	<!-- Gritter -->
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/admin_asset/bower_components/gritter/css/jquery.gritter.css')); ?>" />
	<link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/plugins/jQuery/jquery-ui.css')); ?>">

	<!--<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/admin_asset/bower_components/select2/dist/css/select2.min.css')); ?>" />-->

	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/dist/css/AdminLTE.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/dist/css/skins/skin-blue.min.css')); ?>">		   
	<!-- jQuery 3 -->
	<script src="<?php echo e(asset('public/admin_asset/bower_components/jquery/dist/jquery.min.js')); ?>"></script>	
</head>

<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

	<!-- Main Header -->
    <header class="main-header">
		<!-- Logo -->
		<a href="#" class="logo">
			<!-- mini logo for sidebar mini 50x50 pixels -->
			<span class="logo-mini"><img src="<?php echo e(asset(Session::get('org_logo'))); ?>" width="32"></span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg"><img src="<?php echo e(asset(Session::get('org_logo'))); ?>" width="32"> <b><?php echo e(Session::get('org_short_name')); ?></b>HRM</span>
		</a>
		<!-- Header Navbar: style can be found in header.less -->
		<nav class="navbar navbar-fixed-top">
		 <a href="http://202.4.106.3/cdiphr/public/CDIP_Manual.pdf" target="_BLANK"><button type="button" class="btn btn-primary"><strong>CDIP Manual</strong></button></a>
		  <!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<div class="navbar-custom-menu">
			
			<ul class="nav navbar-nav">
			  <!-- Messages: style can be found in dropdown.less
			  <li class="dropdown messages-menu">
					 <a href="<?php echo e(URL::to('/br_download')); ?>"class="pull-right" style="color:white;">Download</a>
				</li>-->
			<!--	<li class="dropdown messages-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-envelope-o"></i> <span class="label label-success">1</span>
					</a>
				 	<ul class="dropdown-menu">
						<li class="header">You have 1 messages</li>
						<li>
						 
							<ul class="menu">
								<li> 
									<a href="#">
										<div class="pull-left">
											<img src="<?php echo e(asset('public/admin_asset/dist/img/user2-160x160.jpg')); ?>" class="img-circle" alt="User Image">
										</div>
										<h4>Support Team<small><i class="fa fa-clock-o"></i> 5 mins</small></h4>
									  <p>Why not buy a new awesome theme?</p>
									</a>
								</li>
							 
							</ul>
						</li>
						<li class="footer"><a href="#">See All Messages</a></li>
					</ul>
				</li> -->
				<!-- Notifications: style can be found in dropdown.less -->
				<?php 
					$transfer_info = DB::table('tbl_br_transfer')
							->where('status', 0)
							->select(DB::raw('COUNT(id) as total_id'))
							->first();
					//echo $transfer_info->total_id;		
				?>
				<?php $admin_id = Session::get('admin_id'); if($admin_id == 7 || $admin_id == 16) { ?>
				<li class="dropdown notifications-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-bell-o"></i>
						<span class="label label-warning"><?php echo $transfer_info->total_id; ?></span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have <?php echo $transfer_info->total_id; ?> notifications</li>
						<li class="footer"><a href="<?php echo e(URL::to('/br_transfer')); ?>">View all</a></li>
					</ul>
				</li>
				<?php } ?>
				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo e(asset(Session::get('admin_photo'))); ?>" class="user-image" alt="User Image">
						<span class="hidden-xs"><?php  
							$user_type = Session::get('user_type');
							if($user_type == 3){ ?> 
								 <?php echo e(Session::get('zone_name')); ?> Zone
							<?php }else if($user_type == 4){ ?>
								<?php echo e(Session::get('area_name')); ?> Area
							<?php }else{ ?>
								 <?php echo e(Session::get('admin_name')); ?>

							<?php } ?>  </span>
					</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header">
							<img src="<?php echo e(asset(Session::get('admin_photo'))); ?>" class="img-circle" alt="User Image">
							<p><?php  
							
							if($user_type == 3){ ?> 
								 <?php echo e(Session::get('zone_name')); ?> Zone
							<?php }else if($user_type == 4){ ?>
								<?php echo e(Session::get('area_name')); ?> Area
							<?php }else{ ?>
								 <?php echo e(Session::get('admin_name')); ?>

							<?php } ?> <small>
							<?php 
							  
							
							
							if($user_type == 3){ ?>
								 District Manager User
							<?php }else if($user_type == 4){ ?>
								Area Manager User
							<?php }else if($user_type == 5){ ?>
								 Branch Manager User
							<?php }else{ ?>
								 <?php echo e(Session::get('admin_role_name')); ?>

							<?php } ?>
							</small></p>
						</li>
						<!-- Menu Body -->
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-right">
								<a href="<?php echo e(URL::to('/logout')); ?>" class="btn btn-default btn-flat">Sign out</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
			</div>
		</nav>
	</header>
	<!-- Left side column. contains the logo and sidebar -->
	
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">

			<!-- Sidebar user panel (optional) --> 
			<div class="user-panel">
				<div class="pull-left image">
					<img src="<?php echo e(asset(Session::get('admin_photo'))); ?>" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
					<p>
					<?php 
							$emp_id = Session::get('emp_id');
							if($user_type == 3){ ?> 
								 <?php echo e(Session::get('zone_name')); ?> Zone
							<?php }else if($user_type == 4){ ?>
								<?php echo e(Session::get('area_name')); ?> Area
							<?php }else{ ?>
								 <?php echo e(Session::get('admin_name')); ?>

							<?php } ?>  
					 </p>
					<!-- Status -->
					<a href="#"><i class="fa fa-circle text-success"></i>
					<?php  
					if($user_type == 3){ ?>
						District Manager User
					<?php }else if($user_type == 4){ ?>
						Area Manager User
					<?php }else if($user_type == 5){ ?>
						Branch Manager User
					<?php } else if($emp_id == 1000000) { ?>
						Chairman
					<?php }else{ ?>
						<?php echo e(Session::get('admin_role_name')); ?>

					<?php } ?> 
				</div>
			</div>

			<?php 
			$access_label = Session::get('admin_access_label');
			$navbar_group = DB::table('tbl_navbar_group')->whereRaw("find_in_set($access_label,user_access)")->where('nav_group_status',1)->orderBy('sl_order','ASC')->get();	
			$navbar 	  = DB::table('tbl_navbar')->whereRaw("find_in_set($access_label,user_access)")->where('nav_status',1)->orderBy('nav_order')->get();
			?>

			<!-- Sidebar Menu -->
			<ul class="sidebar-menu" data-widget="tree" id="left_menu"> 

				<?php if(Session::get('branch_code') == 9999) { ?>
				
				
					<?php
					
					$emp_id = Session::get('emp_id'); 
					$is_supervisor = DB::table('supervisors as super')
							->where('super.supervisors_emp_id', $emp_id) 
							->where('super.active_status', 1)
							->select('super.supervisors_id','super.supervisors_type')
							->first();										
					$leave_pending = DB::table('supervisor_mapping_ho as staff')
					->leftJoin("leave_application as app", 'app.emp_id', '=', 'staff.emp_id')
					->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'staff.emp_id')
					->where('staff.supervisor_id', $emp_id)
					->where(function ($query) {

						$query->where('app.stage', '=', 0)->Where('staff.supervisor_type', 2);
						$query->orwhere('app.stage', '=', 1)->Where('staff.supervisor_type', 1);
					})
					->where('app.first_super_action', '<', 2)
					->orderBy('staff.emp_id', 'ASC')
					->orderBy('app.application_id', 'ASC')
					->select('staff.*','app.*','tbl_emp_photo.*','app.emp_id')
					->get();
					
					$visit_pending = DB::table('supervisor_mapping_ho as staff')
							->leftJoin("tbl_movement_register as app", 'app.emp_id', '=', 'staff.emp_id')
							->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'staff.emp_id')
							->where('staff.supervisor_id', $emp_id)
							->where(function ($query) {
								$query->where('app.stage', '=', 0)->Where('staff.supervisor_type', 2);
								$query->orwhere('app.stage', '=', 1)->Where('staff.supervisor_type', 1);
							}) 
							->where('app.first_super_action', '<', 2)
							->select('staff.*','app.*','tbl_emp_photo.*','staff.emp_id')
							->orderBy('staff.emp_id', 'ASC')
							->get(); 
							
						$notification_number = 	count($leave_pending) + count($visit_pending);	
							
					?>
				<li class="treeview" id="MainGroupSelf_Care">
				  <a href="#">
					<i class="fa fa-user"></i>
					<span>Self Care</span>
					<span class="pull-right-container">
						<?php if($notification_number > 0) { ?>
						<span class="label label-danger pull-right"><i class="fa fa-bell" aria-hidden="true"></i></span>
						<?php } else { ?>
						<i class="fa fa-angle-left pull-right"></i>
						<?php } ?>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<?php if($emp_id < 1000000) { ?>
					<li id="My_Profile"><a href="<?php echo e(URL::to('/profile')); ?>"><i class="fa fa-dashboard"></i> My Dashboard</a></li>
					<li id="My_Basic"><a href="<?php echo e(URL::to('/basic_info')); ?>"><i class="fa fa-user"></i> My Profile</a></li>
					<li id="Pay_Slip"><a href="<?php echo e(URL::to('/pay_slips')); ?>"><i class="fa fa-money"></i> Pay Slip</a></li>
					<li id="My_Benefits"><a href="<?php echo e(URL::to('/my_benefit')); ?>"><i class="fa fa-bar-chart"></i> My Benefit</a></li>
					<li id="Leave_and_Visit"><a href="<?php echo e(URL::to('/leave_visit')); ?>"><i class="fa fa-calendar-o"></i> Leave & Visit</a></li>
					<li id="Personal_File"><a href="<?php echo e(URL::to('/my_documents')); ?>"><i class="fa fa-files-o"></i> Personal File</a></li>
					<?php } ?>
					<?php if($is_supervisor) {  ?>
					<li id="Leave_Approve">
					<a href="<?php echo e(URL::to('/leave_approved')); ?>"><i class="fa fa-check-circle"></i> Leave Approve <span class="pull-right-container">
					<span class="label label-warning pull-right" id="leave_approve_pending"><?php echo count($leave_pending); ?></span>
					</span></a>
					</li>
					<li id="Visit_Approval"><a href="<?php echo e(URL::to('/movement_approve')); ?>"><i class="fa fa-check-circle"></i> Visit Approve<span class="pull-right-container">
					<span class="label label-danger pull-right" id="visit_approve_pending"><?php echo count($visit_pending); ?></span>
					</span> </a></li>
					<?php } ?>
					
				  </ul>
				</li>
				
				<li class="treeview" id="MainGroupPms">
				  <a href="#">
					<i class="fa fa-user"></i>
					<span>PMS</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li id="own_pms"><a href="<?php echo e(URL::to('/pms')); ?>"><i class="fa fa-circle-o"></i>Own PMS</a></li>
					<?php if(!empty($is_supervisor) && ($is_supervisor->supervisors_type == 1)) { ?>
					<li id="team_pms"><a href="<?php echo e(URL::to('/pms-supervisor')); ?>"><i class="fa fa-circle-o"></i><span>Team PMS</span></a></li>
					<li id="team_pms"><a href="<?php echo e(URL::to('/pms-assessment-report')); ?>"><i class="fa fa-user"></i><span>Assessment Report</span></a></li>
					<?php } ?>
					<?php if($emp_id == 2692 || $emp_id == 4646 || $emp_id == 4188 || $emp_id == 4664) { ?>
					<li id="report_pms"><a href="<?php echo e(URL::to('/pms-report')); ?>"><i class="fa fa-circle-o"></i><span>PMS Report</span></a></li>
					<?php } ?>
				  </ul>
				</li>
					<?php 
					
					
					if($emp_id == 1230){?>
							<li class="treeview" id="MainGroupperedms">
							  <a href="#">
								<i class="fa fa-book"></i>
								<span>Edms</span> 
							  </a>
							  <ul class="treeview-menu">
								 
								<li id="personal_edms"><a href="<?php echo e(URL::to('/per_document')); ?>"><i class="fa fa-user"></i> Personal Documents</a></li> 
							  </ul>
							</li>
					<?php }?>
				
				
				
				<?php } ?>
				
				<?php   
				$emp_id_head = Session::get('emp_id');
				$head_department = DB::table('department_head_mapping') 
									->where('dept_head_emp_id',$emp_id_head) 
									->where('status',1) 
									->first();
				if(count($navbar_group)<1  && $head_department ){  ?>
					<li class="treeview" id="MainGrouphead_edms">
						  <a href="#">
							<i class="fa fa-book"></i>
							<span>EDMS</span> 
						  </a>
						  <ul class="treeview-menu">
							<li id="My_Profile"><a href="<?php echo e(URL::to('/edms_document_hlist_index')); ?>"><i class="fa fa-book"></i> Document list</a></li>
							 
						  </ul>
						
					</li>
					<?php	}  ?>
				
				
				<?php foreach($navbar_group as $v_navbar_group) { ?>
					<?php if($v_navbar_group->is_sub_menu == 1) { ?>
					<li class="treeview" id="MainGroup<?php echo preg_replace('/\s+/', '_',  $v_navbar_group->nav_group_name); ?>">
						<a href="#">
							<?php echo $v_navbar_group->grpup_icon; ?> <span><?php echo $v_navbar_group->nav_group_name; ?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>										
						<ul class="treeview-menu">
						<?php $__currentLoopData = $navbar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_navbar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php if($v_navbar_group->nav_group_id ==  $v_navbar->nav_group_id): ?>
						<li class="" id="<?php echo preg_replace('/\s+/', '_',  $v_navbar->nav_name); ?>"><a href="<?php echo e(URL::to($v_navbar->nav_action)); ?>"><i class="fa fa-circle-o"></i> <?php echo e($v_navbar->nav_name); ?></a></li>
						<?php endif; ?>
						<?php 
						if (($v_navbar_group->nav_group_id ==  $v_navbar->nav_group_id) && ( $v_navbar_group->nav_group_id ==8 && $head_department && $emp_id_head != 4646)){ 
							 
						?>
						<li id="My_Profile"><a href="<?php echo e(URL::to('/edms_document_hlist_index')); ?>"><i class="fa fa-book"></i> Document list</a></li>
						
						<?php } ?>
						
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>							
					</li>				
					<?php } else { ?>
					<li id="dashboard">
						<a href="<?php echo e(URL::to('/dashboard')); ?>">
							<?php echo $v_navbar_group->grpup_icon; ?> <span><?php echo $v_navbar_group->nav_group_name; ?></span>
						</a>
					</li>					
					<?php } ?>				
				<?php } ?>	
				
				
			</ul>
			<!-- /.sidebar-menu -->
		</section>
		<!-- /.sidebar -->
	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">

	
	<!-- .Dynamic content -->
		   
	   <?php echo $__env->yieldContent('main_content'); ?>

    <!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- Main Footer -->
	<footer class="main-footer fixed">
		<!-- To the right -->
		<div class="pull-right hidden-xs">
			page took <?php echo e((microtime(true) - LARAVEL_START)); ?> seconds to render
		</div>
		<!-- Default to the left -->
		<strong>Copyright &copy; <?php echo date('Y'); ?> <a href="#">cdipbd.org</a></strong> All rights reserved.
	</footer>

	<!-- Add the sidebar's background. This div must be placed
	immediately after the control sidebar -->
	<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



<!-- REQUIRED JS SCRIPTS -->
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo e(asset('public/admin_asset/bower_components/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(asset('public/admin_asset/dist/js/adminlte.min.js')); ?>"></script>
<!-- FastClick -->
<script src="<?php echo e(asset('public/admin_asset/bower_components/fastclick/lib/fastclick.js')); ?>"></script> 
<script type="text/javascript" src="<?php echo e(asset('public/admin_asset/bower_components/gritter/js/jquery.gritter.js')); ?>"></script>
<!-- DataTables -->
<script src="<?php echo e(asset('public/admin_asset/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/admin_asset/plugins/datatables/dataTables.bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/admin_asset/plugins/jQuery/jquery-ui.min.js')); ?>"></script>	

<?php
	$message=Session::get('message');
	if($message)
	{ ?>

	<script>
	$.gritter.add({
		title: '',
		text: '<?php echo $message; Session::put('message',''); ?>',
		sticky: false,
	});
	
	</script>
<?php } ?>

<script>
	$(document).ready(function() {
			// Setup - add a text input to each footer cell
			 $('#table tfoot th').each( function () {
				 var title = $(this).text();
				 $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
			 } );
			// DataTable
			 var otable = $('#table').DataTable();

			 // Apply the search
			 otable.columns().every( function () {
				var that = this;
				$( 'input', this.footer() ).on( 'keyup change', function () {
					if ( that.search() !== this.value ) {
						that
						.search( this.value )
						.draw();
					}
				} );
			} );
	} );
</script>



</body>
</html>