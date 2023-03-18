@extends('admin.admin_master')
@section('title', 'Contractual | Designation')
@section('main_content')
<script>  
function checkDelete()
	{
	 var chk=confirm("Are you sure to delete !!!");
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
		<h1>Contractual <small>All Non ID Designation</small></h1>
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
						<h3 class="box-title">Contractual Designation</h3>
							<a href="{{URL::to('/con_designation/create')}}" id="add_new" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add New</a>
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
									<th>Effect Date</th>
									<th>Previous Designation</th>   
									<th>Current Designation</th>  
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
									<th>Effect Date</th>
									<th>Previous Designation</th>   
									<th>Current Designation</th>  
									<th>Status</th>  
									<th style="width:15%">Options</th>
								</tr>
							</tfoot>
							<tbody>
							<?php 
								$j=1;
								if(!empty($results)){
								foreach($results as $v_result){ ?>
									<tr>
									<td><?php echo $j++;?></td>
									<td><?php echo $v_result->sacmo_id;?></td> 
									<td> <?php echo $v_result->type_name;  	?>  </td> 
									<td><?php echo $v_result->emp_name;?></td>  
									<td><?php echo date("d-m-Y",strtotime($v_result->effect_date));?></td>   
									<td><?php echo $v_result->pre_designation_name;?></td>   
									<td><?php echo $v_result->c_designation_name;?></td> 
									<td><?php if($v_result->cancel_date == ''){ echo '<span style="color:green">Active</span>';}else { echo '<span style="color:red">Canceled</span>'; } ?></td> 
									<?php if($v_result->cancel_date == ''){ ?>
									<td><a class="btn btn-sm btn-success btn-xs" title="Edit" href="{{URL::to('con_designation/'.$v_result->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i> Edit</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-info btn-xs" title="view" href="{{URL::to('view_nonid_designation/'.$v_result->id)}}"><i class="fa fa-eye"></i> View</a>&nbsp;&nbsp;
										<a class="btn btn-primary" onclick="return checkDelete();"  href="{{URL::to('/del_nonid_designation/'.$v_result->id.'/'.$v_result->sarok_no)}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td> 
									<?php }else{ ?> 
										<td><a class="btn btn-sm btn-info btn-xs" title="view" href="{{URL::to('view_nonid_designation/'.$v_result->id)}}"><i class="fa fa-eye"></i> View</a></td> 
									<?php } ?>
								</tr>
							<?php
								} 
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
		$("#MainGroupContractual").addClass('active');
		$("#Designation").addClass('active');
	});
</script>
@endsection