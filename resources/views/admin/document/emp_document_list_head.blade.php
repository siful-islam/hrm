@extends('admin.admin_master')
@section('title','Add Document' )
@section('main_content')
 <script type="text/javascript" language="javascript">
	function checkDelete()
	{
	 var chk=confirm("Are you sure to delete ?");
		if(chk)
		{
		  return true;
		}
		else{
		  return false;
		}
	}
</script> 
<?php 

$msg = Session::get('message');

if (!empty($msg)) {  
echo "<script>alert('$msg');</script>";
  session()->forget('message'); } ?>  

   <!-- Content Header (Page header) -->
    <section class="content-header">
		<h4>Document</h4>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Employee</a></li>
			<li class="active">Document</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<!-- /.box-header --> 
					<div class="box-body">
						<div class="table-responsive">
						<table id="table" class="table no-border table-striped">
							<thead>
								<tr>
									<th>SL No</th>
									<th>Employee ID</th>
									<th>Employee Name</th>
									<th>Group</th> 
									<th>Category</th> 
									<th>Effect Date</th> 
									<th>Status</th> 
									<th class="text-center" style="width:15%">Action</th>
								</tr>
							</thead>
							 
							
						</table>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
        </div>
	</section> 
<!-- DataTables --> 
 
<script> 
	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"ajax":{
					 "url": "{{URL::to('/edms_document_hlist')}}",
					 "dataType": "json",
					 "type": "POST",
					 "data":{ _token: "{{csrf_token()}}"}
				   },
			"columns": [
				{ "data": "id"},
				{ "data": "emp_id"},
				{ "data": "emp_name"},
				{ "data": "category_name"},
				{ "data": "subcategory_name"},
				{ "data": "effect_date"},
				{ "data": "status"},
				{ "data": "options" }
			]    

		});
	});

	function reload_table()
	{
		table.ajax.reload(null,false); //reload datatable ajax 
	}

</script> 
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupEDMS").addClass('active');
		$("#deldocu_head").addClass('active');
	});
</script>
@endsection