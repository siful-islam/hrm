@extends('admin.admin_master')
@section('main_content')
<section class="content-header">
	<h1>File<small>Movement</small></h1>
</section>
<!-- Main content -->
<?php $login_emp_id = Session::get('emp_id'); ?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<?php if($login_emp_id == 3015) { ?>
				<div class="box-header">
					<a href="{{URL::to('/fp_file_info_create')}}" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add</a>
				</div>
				<?php } ?>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th style="width:50px;">Sl No</th>
								<th>Employee ID</th>
								<th>Employee</th>
								<th>File Type</th>
								<th>Sender Employee</th>
								<th>Receiver Employee</th>
								<th>Entry Date</th>                
								<th>Status</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl No</th>
								<th>Employee ID</th>
								<th>Employee</th>
								<th>File Type</th>
								<th>Sender Employee</th>
								<th>Receiver Employee</th>
								<th>Entry Date</th>                
								<th>Status</th>
							</tr>
						</tfoot>
						<tbody>								
							{{!$i=1}} @foreach($all_result as $result)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$result->fp_emp_id}}</td>
								<td><?php echo $result->fp_employee; ?></td>
								<td><?php 
									if($result->file_type == 1) { echo 'Legal Notice';}
									else if ($result->file_type == 2) { echo 'Final Payment';}
									else if ($result->file_type == 3) { echo 'Final Payment Info';}
									else if ($result->file_type == 4) { echo 'Departmental Notice';}
									else if ($result->file_type == 5) { echo 'Final Payment Close';}
									else if ($result->file_type == 6) { echo 'Final Payment Settlement';}
									else if ($result->file_type == 7) { echo 'Litigation / Mgt. Decision';}
									?>
								</td>
								<td>{{$result->sn_employee.' - '.$result->sender_emp_id}}</td>
								<td>{{$result->rc_employee.' - '.$result->receiver_emp_id}}</td>
								<td>{{$result->entry_date}}</td>
								<td class="text-center">
									<?php if($result->status ==0) { ?>
									<?php if($result->sender_emp_id == $login_emp_id) { ?>
									<a class="btn btn-info" >Sent</a>
									<a class="btn btn-danger" onclick="delete_data({{$result->id.','.$result->fp_emp_id}})">Cancel</a>
									<?php } else if ($result->receiver_emp_id == $login_emp_id) { ?>
									<a class="btn btn-danger" onclick="update({{$result->id}})" >Receive</a>
									<?php } ?>
									<?php } else if($result->status ==1) { 
									if($result->sender_emp_id == $login_emp_id) { ?>
									<a class="btn btn-primary" disabled >Received</a>
									<?php } else if($result->receiver_emp_id == $login_emp_id) { ?>
									<a class="btn btn-success" href="{{URL::to('/fp_file_resend/'.$result->id)}}">Resend</a>
									<?php } ?>
									<?php } else if($result->status ==2) { 
									if($result->sender_emp_id == $login_emp_id) { ?>
									<a class="btn btn-primary" disabled >Received</a>
									<?php } else if($result->receiver_emp_id == $login_emp_id) { ?>
									<a class="btn btn-success" disabled >Moved</a>
									<?php } ?>
									<?php } else if($result->status ==3) { 
									if($result->sender_emp_id == $login_emp_id) { ?>
									<a class="btn btn-danger" disabled >Settled</a>
									<?php } else if($result->receiver_emp_id == $login_emp_id) { ?>
									<a class="btn btn-danger" disabled >Settled</a>
									<?php } ?>
									<?php } ?>
								</td>
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
function update(id)
	{
	//alert(id);
	//exit;	
	$.ajax({
			url : "{{ URL::to('update_fp_status') }}"+"/"+ id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{           
				//alert('updated');
				location.reload();
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				//alert('Error');
			}
		});
	}
	
function delete_data(id,fp_emp_id)
	{
	//alert(fp_emp_id);
	$.ajax({
			url : "{{ URL::to('delete_fp_status') }}"+"/"+ id+"/"+ fp_emp_id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{           
				location.reload();
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				
			}
		});
	}
</script>
@endsection