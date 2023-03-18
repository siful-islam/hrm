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
		<a href="<?php echo e(URL::to('/manual')); ?>"><button type="button" class="btn btn-success"><strong>CDIP Manual</strong></button></a>
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

							<?php } ?> </span>
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

							<?php } ?>  <small>
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
							<div class="pull-left"> 
								<a href="<?php echo e(URL::to('/paward_change')); ?>" class="btn btn-default btn-flat">Change Password</a> 
							</div>
							<div class="pull-right">
								<a href="<?php echo e(URL::to('/logout')); ?>" class="btn btn-default btn-flat">Sign out</a>
							</div>
						</li>
					</ul>
				</li>
				<!-- Control Sidebar Toggle Button -->
				<li>
					<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
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
					<p><?php  
							
							if($user_type == 3){ ?> 
								 <?php echo e(Session::get('zone_name')); ?> Zone
							<?php }else if($user_type == 4){ ?>
								<?php echo e(Session::get('area_name')); ?> Area
							<?php }else{ ?>
								 <?php echo e(Session::get('admin_name')); ?>

							<?php } ?>  </p>
					<!-- Status -->
					<a href="#"><i class="fa fa-circle text-success"></i><?php  
							if($user_type == 3){ ?>
								 District Manager User
							<?php }else if($user_type == 4){ ?>
								Area Manager User
							<?php }else if($user_type == 5){ ?>
								 Branch Manager User
							<?php }else{ ?>
								 <?php echo e(Session::get('admin_role_name')); ?>

							<?php } ?> </a>
				</div>
			</div>

			<?php 
			$access_label = Session::get('admin_access_label');
			$navbar_group = DB::table('tbl_navbar_group')->whereRaw("find_in_set($access_label,user_access)")->where('nav_group_status',1)->orderBy('sl_order','ASC')->get();	
			$navbar 	  = DB::table('tbl_navbar')->whereRaw("find_in_set($access_label,user_access)")->where('nav_status',1)->orderBy('nav_order')->get();
			?>

			<!-- Sidebar Menu -->
			<ul class="sidebar-menu" data-widget="tree">
		   
				<?php if(Session::get('admin_access_label') == 12 || Session::get('admin_access_label') == 28) { ?>
				<li>
					<a class="active" href="<?php echo e(URL::to('/profile')); ?>">
						<i class="fa fa-home"></i> <span>Home</span>
					</a>
				</li>
				<li>
					<a class="active" href="<?php echo e(URL::to('/weblinks')); ?>">
						<i class="fa fa-link"></i> <span>Web-Links</span>
					</a>
				</li>
				<?php } ?>
				
				
				
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

	<!-- Control Sidebar -->
	<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
		<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
			<li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
			<li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
		<!-- Home tab content -->
			<div class="tab-pane active" id="control-sidebar-home-tab">
				<h3 class="control-sidebar-heading">Recent Activity</h3>
				<ul class="control-sidebar-menu">
					<li>
						<a href="javascript:;">
							<i class="menu-icon fa fa-birthday-cake bg-red"></i>
							<div class="menu-info">
								<h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
								<p>Will be 23 on April 24th</p>
							</div>
						</a>
					</li>
				</ul>
				<!-- /.control-sidebar-menu -->
				<h3 class="control-sidebar-heading">Tasks Progress</h3>
				<ul class="control-sidebar-menu">
					<li>
						<a href="javascript:;">
							<h4 class="control-sidebar-subheading">
								Custom Template Design
								<span class="pull-right-container">
									<span class="label label-danger pull-right">70%</span>
								</span>
							</h4>

							<div class="progress progress-xxs">
								<div class="progress-bar progress-bar-danger" style="width: 70%"></div>
							</div>
						</a>
					</li>
				</ul>
				<!-- /.control-sidebar-menu -->
			</div>
			<!-- /.tab-pane -->
			<!-- Stats tab content -->
			<div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
			<!-- /.tab-pane -->
			<!-- Settings tab content -->
			<div class="tab-pane" id="control-sidebar-settings-tab">
				<form method="post">
					<h3 class="control-sidebar-heading">General Settings</h3>
					<div class="form-group">
						<label class="control-sidebar-subheading">
							Report panel usage
							<input type="checkbox" class="pull-right" checked>
						</label>
						<p>Some information about this general settings option</p>
					</div>
				  <!-- /.form-group -->
				</form>
			</div>
		  <!-- /.tab-pane -->
		</div>
	</aside>
	<!-- /.control-sidebar -->
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