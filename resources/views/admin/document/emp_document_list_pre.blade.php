@extends('admin.admin_master')
@section('title','Add Document' )
@section('main_content')
 <script type="text/javascript" language="javascript">
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
					<div class="box-header">
						
							<form class="form-horizontal" action="{{URL::to('edms_search/')}}"   role="form" method="POST">
								{{csrf_field()}}   
								<div class="col-md-3"> 
									<div class="form-group"> 
										<label class="control-label col-md-5">Employee ID</label>
											<div class="col-md-7">
												<input type="text"  id="emp_id" name="emp_id" class="form-control">
												<span class="help-block"></span>
											</div> 
									</div> 
								</div>
								
								<div class="col-md-3">
									<div class="form-group">  
										<button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
									</div> 
								</div>  	 
							</form>
						
							<a href="{{URL::to('/edms-document/create')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i>Add</a>
						
						
					</div>
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
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>SL No</th>
									<th>Employee ID</th>
									<th>Employee Name</th>  
									<th>Group</th> 
									<th>Category</th> 
									<th>Effect Date</th> 
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</tfoot>
							<tbody>
								
								@php 
									$i=1
								@endphp
								@foreach($emp_document_list as $emp_leave)
								<?php 
									if($emp_leave->category_id == 13){
										$folder_name = "c_v/";
									}else if($emp_leave->category_id == 5){
										$folder_name = "edu_cation/";
									}else if($emp_leave->category_id == 11){
										$folder_name = "miscell_aneous/";
									}else if($emp_leave->category_id == 24){
										$folder_name = "train_ing_info/";
									}else {
										$folder_name = "attach_ment_tran/";
									}
									$filename = "attachments/$folder_name/$emp_leave->document_name";
									if (file_exists($filename)) {
								
								?>
								<tr>
									<td>{{$i++}}</td>
									<td>{{$emp_leave->emp_id}}</td>
									<td><?php 
											echo $emp_leave->emp_name; 
										?> </td>  
									<td>{{$emp_leave->category_name}}</td> 
									<td>{{$emp_leave->subcategory_name}}</td> 
									<td>{{$emp_leave->effect_date}}</td> 
									<td class="text-center">
									<?php if($emp_leave->subcat_id){ 
									$subcat_id = $emp_leave->subcat_id;
									}else{ $subcat_id = 0; }?>
									<a class="btn bg-olive"  title="View" href="{{URL::to('/document-view/'.$emp_leave->emp_id.'/'.$emp_leave->category_id.'/'.$subcat_id)}}"><i class="fa fa-eye"></i></a>
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/edms_document_edit/'.$emp_leave->document_id)}}"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp; 
										<a class="btn btn-primary" onclick="return checkDelete();"  href="{{URL::to('/edms_document_delete/'.$emp_leave->document_id.'/'.$emp_leave->category_id.'/'.$emp_leave->document_name)}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a> 
									</td>
								</tr>
												<?php 
												} 
												
												?>
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
</script> 
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupDocument").addClass('active');
		$("#Add_Document").addClass('active');
	});
</script>
@endsection