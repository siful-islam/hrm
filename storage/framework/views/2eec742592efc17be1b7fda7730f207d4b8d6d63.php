<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">  
	<title>HRM |Login</title>
	<link rel="shortcut icon" href="<?php echo e(asset('public/favicon.png')); ?>">
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/bower_components/bootstrap/dist/css/bootstrap.min.css')); ?>">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/bower_components/font-awesome/css/font-awesome.min.css')); ?>">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/bower_components/Ionicons/css/ionicons.min.css')); ?>">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/dist/css/AdminLTE.min.css')); ?>">
</head>
<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="#"><b>CDIP</b>HRM</a>
		</div>
	<!-- /.login-logo -->
		<div class="login-box-body">

			<?php
				$message=Session::get('message');
				$exception=Session::get('exception');
				if($message)
				{ ?>
					<p class='login-box-msg' style="color:green;"><?php echo $message; ?></p> 
			   <?php Session::put('message',''); }
				elseif($exception)
				{ ?>
					<p class='login-box-msg' style="color:red;"><?php echo $exception; ?></p>
				<?php  Session::put('exception',''); }
				else{
					echo '<p class="login-box-msg">Sign in to start your session</p>';
				}
			?>
			<?php echo Form::open(['url' => '/admin-login-check']); ?>

				<div class="form-group has-feedback">
					<center><img src="<?php echo e(asset('public/org_logo/cdip.png')); ?>"></center>
				</div>
				<div class="form-group has-feedback">
					<input type="text" name="email_address"   class="form-control" placeholder="User name" required>
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" name="admin_password" autocomplete="off" class="form-control" placeholder="Password" required>
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="row">
				<!-- /.col -->
				<div class="col-xs-4">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
				</div>
				<!-- /.col -->
				</div>

			<?php echo Form::close(); ?>

		</div>
		<!-- /.login-box-body -->
	</div>
	<!-- /.login-box -->

	<!-- jQuery 3 -->
	<script src="<?php echo e(asset('public/admin_asset/bower_components/jquery/dist/jquery.min.js')); ?>"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="<?php echo e(asset('public/admin_asset/bower_components/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>

</body>
</html>
