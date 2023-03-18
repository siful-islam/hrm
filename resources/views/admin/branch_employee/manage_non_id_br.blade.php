@extends('admin.admin_master')
@section('title', 'Branch Contractual | Add Information');
@section('main_content')
<?php  
	$msg = Session::get('message1'); 
	if (!empty($msg)) {  
	echo "<script>alert('Employee ID is : $msg');</script>";
	session()->forget('message1'); 
	} 
	?>
<!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Contractual <small>All Contractual</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Contractual</a></li>
			<li class="active">Manage Contractual</li>
		</ol>
    </section>


    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Contractual </h3>
							<a href="{{URL::to('/bra_contractual/create')}}" id="add_new" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add New</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">	
						<div class="table-responsive">
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Emp ID</th>
									<th>Emp Type</th>
									<th>Employee Name</th>
									<th>Org. Joining Date</th>
									<th>Present Branch</th>
									<th>Consolidated Salary</th>
									<th>Contact Number</th>
									<!--<th>Next Renew Date</th>  -->                                        
									<th>Status</th>                                          
									<th style="width:15%">Options</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>No</th>
									<th>Emp ID</th>
									<th>Emp Type</th>
									<th>Employee Name</th>
									<th>Org. Joining Date</th>
									<th>Present Branch</th>
									<th>Consolidated Salary</th>
									<th>Contact Number</th>
									<th>Status</th>                                          
									<th style="width:15%">Options</th>
								</tr>
							</tfoot>
							<tbody>
							<?php 
								$j=1;
								foreach($results as $v_result){ ?>
									<tr>
									<td><?php echo $j++;?></td>
									<td><?php echo $v_result->sacmo_id;?></td> 
									<td><?php  echo $v_result->type_name;  ?></td>
									<td><?php echo $v_result->emp_name;?></td> 
									<td><?php echo date("d-m-Y",strtotime($v_result->joining_date));?></td> 
									<td><?php if(!empty($v_result->branch_name_t)){echo $v_result->branch_name_t; } else { echo $v_result->branch_name_o;}?></td> 
									<td><?php echo $v_result->console_salary;?></td> 
									<td><?php echo $v_result->contact_num;?></td> 
									<!--<td><?php //if(!empty($v_result->next_renew_date)){ echo date("d-m-Y",strtotime($v_result->next_renew_date));}?></td> -->
									<td><?php if($v_result->cancel_date == ''){ echo '<span style="color:green">Active</span>';}else { echo '<span style="color:red">Canceled</span>'; } ?></td> 
									<?php if($v_result->cancel_date == ''){ ?>
										<td><a class="btn btn-sm btn-success btn-xs" href="{{URL::to('bra_contractual/'.$v_result->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i> Edit</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-info btn-xs" title="Edit" href="{{URL::to('bra_view_non_id/'.$v_result->id)}}"><i class="fa fa-eye"></i> View</a></td> 
									<?php }else{ ?> 
											<td><a class="btn btn-sm btn-info btn-xs" title="Edit" href="{{URL::to('bra_view_non_id/'.$v_result->id)}}"><i class="fa fa-eye"></i> View</a></td> 
									<?php } ?>
									
								</tr>
							<?php
							}
							?>
							</tbody>        
						</table>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
        </div>
	</section>
  		 
 
<!--<script src="{{asset('public/admin_asset/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/admin_asset/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>	-->	
	
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
			$("#MainGroupBranch_Contractual").addClass('active');
			$("#Add_information").addClass('active');
		});
	</script>
@endsection