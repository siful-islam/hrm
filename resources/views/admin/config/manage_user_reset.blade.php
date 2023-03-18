@extends('admin.admin_master')
@section('title', 'Manage Password Reset')
@section('main_content')
<script>  
function checkDelete()
	{
	 var chk=confirm("Are you sure to Set Password 123456 ?");
		if(chk)
		{
		  return true;
		}
		else{
		  return false;
		}
	}
</script>
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>User Manager<small>All Users</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">User</a></li>
			<li class="active">User Manager</li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">User Manager</h3> 
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="table-responsive">
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>User Name</th>
									<th>Branch Name</th>
									<th>Email</th> 
									<th>Access lavel</th>                                   
									<th>Photo</th>                                   
									<th>Status</th>                                   
									<th style="width:15%">Reset Password</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>No</th>
									<th>User Name</th>
									<th>Branch Name</th>
									<th>Email</th> 
									<th>Access lavel</th>                                   
									<th>Photo</th>                                   
									<th>Status</th>                                   
									<th style="width:15%">Reset Password</th>
								</tr>
							</tfoot>
							<tbody>
								@foreach($users as $user)
								<tr>
									<td>{{$user->id}}</td>
									<td>{{$user->admin_name}}</td>
									<td>{{$user->branch_name}}</td>
									<td>{{$user->email_address}}</td> 
									<td>{{$user->admin_role_name}}</td>
									<td><img src="public/avatars/{{$user->admin_photo}}" alt="Logo" width="35"></td>
									<td><?php if($user->status ==1) { echo "Active"; }else { echo "Cancel"; }?></td>
									<td>
									<?php if($user->admin_password == 'e10adc3949ba59abbe56e057f20f883e'){ ?>
										<a onclick="return checkDelete();" class="btn btn-sm btn-danger" title="Not Changed" href="{{URL::to('/update_reset_password/'.$user->admin_id)}}">  Reset </a></td>
									<?php }else{ ?>
										<a   onclick="return checkDelete();" class="btn btn-sm btn-primary" title="Changed" href="{{URL::to('/update_reset_password/'.$user->admin_id)}}">  Reset </a></td>
										
									<?php }	?>
									
									
								</tr>
								@endforeach
							</tbody>       
						</table>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
        </div>
	</section>
	
	<script>
	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({

		});
	});
	</script>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$('#Password_Reset').addClass('active');
			});
	</script>
		


@endsection