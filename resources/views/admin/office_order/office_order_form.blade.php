@extends('admin.admin_master')
@section('title', 'Office Order')
@section('main_content')
<style>
.readonly{
 background-color:#eee;
}
.required{
	padding-right:3px;
	margin-top:0px;
	 
}
.control-label{
	 text-align:right !important;
}
.required:not(.required)

</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Office Order</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Office order</a></li>
			<li class="active">Add</li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content">
		<div class="box box-info"> 
			<div class="row">  
				<div class="col-sm-10 col-sm-offset-2 ">  
					<form class="form-horizontal" action="{{URL::to($action)}}" role="form" method="POST" enctype="multipart/form-data">
						{{csrf_field()}}
						{!!$method_control!!}  
						<input type="hidden" name="hidden_document_name" class="form-control" value="" readonly>
						 <div class="box-body">
							<div class="form-group">
							  <label for="title" class="col-sm-2 control-label">Upload Type</label>

							  <div class="col-sm-3">
							  <select type="text" class="form-control" required id="upload_type" name="upload_type"> 
								<option value="">--Select--</option> 
										<option value="1">Office Order</option> 
										<option value="2">Circular</option> 
										<option value="3">Download</option> 
										<option value="4">General</option> 
										<option value="5">User Manual</option> 
								</select> 
								<input type="hidden" name="title" id="title" value="" />
							  </div>
							</div>
							<div class="form-group">
							  <label for="for_which" class="col-sm-2 control-label">HO/Branch</label>

							  <div class="col-sm-3">
								<select type="text" class="form-control" required id="for_which" name="for_which">  
										<option value="3">All</option> 
										<option value="1">Head Office</option> 
										<option value="2">Branch</option> 
										 
								</select>  
							  </div>
							</div>
							<div class="form-group">
							  <label for="title" class="col-sm-2 control-label">Title</label>

							  <div class="col-sm-3">
								<input type="text" required class="form-control" id="title" name="title" value="{{$title}}">
							  </div>
							</div>
							<div class="form-group">
							  <label for="comments" class="col-sm-2 control-label">Details</label>

							  <div class="col-sm-3"> 
								<textarea cols="17" rows="5" required class="form-control" id="comments" name="comments" >{{$comments}}</textarea>
							  </div>
							</div>
							<div class="form-group">
							  <label for="order_date" class="col-sm-2 control-label">Date</label>

							  <div class="col-sm-3"> 
								<input  type="text" class="form-control common_date" required id="order_date" name="order_date" value="{{$order_date}}" >
							  </div>
							</div>
							<div class="form-group">
							  <label for="status" class="col-sm-2 control-label">Status</label>

							  <div class="col-sm-3">  
								<select type="text" class="form-control" required id="status" name="status"> 
									<option value="1">Active</option>
									<option value="2">InActive</option> 
								</select>
							  </div>
							</div>
							<div class="form-group">
							  <label for="staff_image" class="col-sm-2 control-label">PDF File</label>
							  <div class="col-sm-3"> 
									<input accept="image/*, application/pdf"  id="file-input" name="file_name" class="uploadjs form-control" data-id="3" type="file"/  > 
									<strong ><br>Select PDF file here.</strong> 
									 <span class="help-block preview">
														<img id="preview-3" alt="">
														<embed id="preview-3_1" type="application/pdf" style="width:100%;"> 
														<!--<iframe src="{{asset('storage/attachments/1_1.doc')}}"  type="application/msword" style="width:100%;height:150px;" > </iframe>-->
													</span>
										<input type="hidden" name="hidden_file_name" value="{{$file_name}}" />
							  </div>
							</div> 
							<div class="form-group">
							  <label for="staff_image" class="col-sm-2 control-label">Word File</label>
							  <div class="col-sm-3"> 
									<input accept="image/*, application/pdf"  id="file-input" name="word_file_name" class="uploadjs form-control" data-id="4" type="file"/> 
									<strong ><br>Select Word file here.</strong> 
									 <span class="help-block preview">
														<img id="preview-4" alt="">
														<embed id="preview-4_1" type="application/pdf" style="width:100%;"> 
														<!--<iframe src="{{asset('storage/attachments/1_1.doc')}}"  type="application/msword" style="width:100%;height:150px;" > </iframe>-->
													</span>
										<input type="hidden" name="hidden_word_file_name" value="{{$word_file_name}}" />
							  </div>
							</div> 
						    <div class="form-group"> 
								<div class="col-sm-4 col-sm-offset-2">
									
									<button type="submit" class="btn btn-info">{{$button}}</button>&nbsp;&nbsp;&nbsp;
									<a href="{{URL::to('office_order/')}}"  type="submit" class="btn btn-default">List</a>
								</div>
							</div> 
						</div> 
					</form>
			    </div>
			</div>
		</div> 
</section>
<script type="text/javascript"> 

document.getElementById("upload_type").value = "{{$upload_type}}"; 
document.getElementById("for_which").value = "{{$for_which}}"; 
function readURL(input, id) 
{
    var mime= input.files[0].type;
	//alert(mime);
    
    if (input.files && input.files[0]) 
    {
        var reader = new FileReader();
        
        reader.onload = function (e) 
        {
            if(mime.split("/")[0]=="image")
            {
                $('#preview-'+id+'_1').attr('src', '');
				$('#preview-'+id).attr('style', "width:100%;height:120px;");
                $('#preview-'+id).attr('src', e.target.result);

            }
            else if(mime.split("/")[1]=="pdf")
            {
                $('#preview-'+id).attr('src', '');
                $('#preview-'+id+'_1').attr('src', e.target.result);
            }else{
				$('#preview-'+id+'_1').attr('src', '');
				$('#preview-'+id).attr('style', "width:20%");
                $('#preview-'+id).attr('src',"{!!asset('storage/office_order/doc.png')!!}");
			}
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
    
$(function()
{
    $(".uploadjs").change(function()
    {
        var id = $(this).data('id')
        readURL(this, id);
    });
}) 
$(document).ready(function() {
	$('.common_date').datepicker({dateFormat: 'yy-mm-dd'}); 
});

 var doc = '{{$file_name}}'; 
 var doc1 = '{{$word_file_name}}'; 
 //alert(doc);
 if(doc.split(".")[1] == 'pdf'){
	 $('#preview-'+3).attr('src', '');
     $('#preview-'+3+'_1').attr('src',"{!!asset('storage/office_order/"+doc+"')!!}");
 }else if((doc.split(".")[1] == 'doc')||(doc.split(".")[1] == 'docx')){
	$('#preview-'+3+'_1').attr('src', '');
	$('#preview-'+3).attr('style', "width:20%");
    $('#preview-'+3).attr('src',"{!!asset('storage/office_order/doc.png')!!}");
 }else{
	 $('#preview-'+3+'_1').attr('src', '');
	 $('#preview-'+3).attr('style', "width:100%;height:120px;");
    $('#preview-'+3).attr('src',"{!!asset('storage/office_order/"+doc+"')!!}");
 }
 if(doc1.split(".")[1] == 'pdf'){
	 $('#preview-'+4).attr('src', '');
     $('#preview-'+4+'_1').attr('src',"{!!asset('storage/office_order/"+doc1+"')!!}");
 }else if((doc1.split(".")[1] == 'doc') || (doc1.split(".")[1] == 'docx')){
	$('#preview-'+4+'_1').attr('src', '');
	$('#preview-'+4).attr('style', "width:20%");
    $('#preview-'+4).attr('src',"{!!asset('storage/office_order/doc.png')!!}");
 }else{
	 $('#preview-'+4+'_1').attr('src', '');
	 $('#preview-'+4).attr('style', "width:100%;height:120px;");
    $('#preview-'+4).attr('src',"{!!asset('storage/office_order/"+doc1+"')!!}");
 } 

</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupCircular_Order_Download").addClass('active');
			$("#Add_Update").addClass('active');
		});
	</script>
@endsection