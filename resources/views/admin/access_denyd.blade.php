@extends('admin.admin_master')
@section('main_content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Form Elements<small>Preview</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Forms</a></li>
			<li class="active">Access Denyd</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> -----------</h3>
			</div>
			<!-- /.box-header -->
			<center>
				<img src="{{asset('public/admin_asset/access-denied.png')}}"  alt="Access Denyed">
			</center>
		</div>
	</section>
@endsection