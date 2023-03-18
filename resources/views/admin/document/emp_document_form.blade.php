@extends('admin.admin_master')
@section('title','Add Document' )
@section('main_content')
<style>
.readonly{
 background-color:#eee;
}
.required{
	padding-right:3px;
	margin-top:0px;
	 
}
.required:not(.required)

</style>
<?php 

$click_control 					= Session::get('click_control'); 
?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Document</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Document</a></li>
			<li class="active">Add</li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content"> 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
				<form class="form-horizontal" action="" id="search"   role="form" method="POST">
				{{csrf_field()}}
				<div class="box-body"> 
						<div class="row"> 
							<div class="col-md-4 col-md-offset-1">
								<div class="form-group"> 
								 
										<div class="col-md-6">
											 
										</div> 
								</div> 
							</div>
							<div class="col-md-4">
								<div class="form-group"> 
									<label class="control-label col-md-4">Employee ID</label>
										<div class="col-md-5">
											<input type="text"  id="emp_id1" class="form-control" value="{{$emp_id}}" required>
											<span class="help-block"></span>
										</div> 
								</div> 
							</div>
							<?php if($mode == 'add'){?>
							<div class="col-md-3">
								<div class="form-group">  
									<button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
								</div> 
							</div> 
							<?php }?>
						</div>   
				</div>
					
			</form>
			<form class="form-horizontal" action="{{URL::to($action)}}"  onsubmit="return duplicate_check()" role="form" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
				<input type="hidden" name="hidden_document_name" class="form-control" value="{{$document_name}}" readonly>
				<input type="hidden" name="hidden_category_id" class="form-control" value="{{$category_id}}" readonly>
				<input type="hidden" name="hidden_subcat_id" class="form-control" value="{{$subcat_id}}" readonly>
				<input type="hidden" id="document_id" name="document_id" class="form-control" value="{{$document_id}}" readonly> 
				<input type="hidden"  name="temp_row_count" class="form-control" value="<?php echo count($emp_document_list);?>" readonly> 
                <fieldset>
						<LEGEND class="col-md-9 col-md-offset-1" style="padding-left:0px;"><b> Employee Information</b></LEGEND>
						<div class="box-body"> 
								<div class="row"> 
									<div class="col-md-5 col-md-offset-1">
										<div class="form-group"> 
											<label class="control-label col-md-5">Employee ID<span class="required">*</span></label>
												<div class="col-md-5">
													<input type="text" name="emp_id" id="emp_id" class="form-control readonly" value="{{$emp_id}}"  required   >
													<span class="help-block"></span>
												</div> 
										</div> 
									</div>
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-5">Employee Name<span class="required">*</span></label>
												<div class="col-md-5">
													<input type="text" name="emp_name" id="emp_name" class="form-control readonly" value="{{$emp_name}}"  required>
													<span class="help-block"></span>
												</div> 
										</div> 
									</div> 
								</div>  
								<div class="row"> 
									<div class="col-md-5 col-md-offset-1">
										<div class="form-group"> 
											<label class="control-label col-md-5">Designation<span class="required">*</span></label>
												<div class="col-md-5">
													<input type="text" name="designation_code" id="designation_code"  class="form-control readonly" value="{{$designation_code}}<?php if (!empty($incharge_as)) { echo ": ( $incharge_as ) ";} ?>"  required>
													<span class="help-block"></span>
												</div> 
										</div> 
									</div> 
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-5">Working Station<span class="required">*</span></label>
												<div class="col-md-5">
													<input type="text" name="branch_code" id="branch_code"   class="form-control readonly" value="{{$branch_code}}" required> 
													<span class="help-block"></span>
												</div> 
										</div> 
									</div> 
								</div>
						</div>
				</fieldset>
				
				<fieldset>
						<LEGEND class="col-md-9 col-md-offset-1" style="padding-left:0px;"><b> Document Information</b></LEGEND>
						<div class="box-body"> 
								<div class="row"> 
									<div class="col-md-5 col-md-offset-1">
										<div class="form-group"> 
											<label class="control-label col-md-5">Group<span class="required">*</span></label>
												<div class="col-md-5">
													 <select  name="category_id" id="category_id" class="form-control"  required > 
														<option value="">--Select--</option>
													 @foreach($category_list as $category)
														<option value="{{$category->category_id}}">{{$category->category_name}}</option> 
													@endforeach	
													</select>
													<span class="help-block"></span>
												</div> 
										</div> 
									</div>
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-5">Category <span class="required">*</span></label>
												<div class="col-md-5"> 
												<select  name="subcat_id" id="subcat_id" onchange="set_extrafield()" required class="form-control"> 
													<option value="">--Select--</option>
													@foreach($subcategory_list as $subcategory)
														<option value="{{$subcategory->subcat_id}}">{{$subcategory->subcategory_name}}</option> 
													@endforeach
												</select>
													<span class="help-block"></span>
												</div> 
										</div> 
									</div> 
								</div>  
								<div class="row">  
									<div class="col-md-5 col-md-offset-1">
										<div class="form-group"> 
											<label class="control-label col-md-5">Document<span class="required">*</span></label>
												<div class="col-md-5">
													<input {{$required}} name="document_name" accept="image/*, application/pdf" class="uploadjs form-control" data-id="3" type="file">
 
													<span class="help-block preview">
														<img id="preview-3" alt="">
														<embed id="preview-3_1" type="application/pdf" style="width:100%;"> 
													</span>
												</div> 
										</div> 
									</div> 
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-5">Effect Date<span class="required">*</span></label>
												<div class="col-md-5">
													<input type="text" name="effect_date" id="effect_date"  class="form-control common_date" value="{{$effect_date}}" required>
													
												</div> 
												<br>
											<label class="control-label col-md-5 national_id_new" style="display:none;">National ID</label>	
											 <div class="col-md-5 national_id_new" style="padding-top:5px;display:none;" >
												<input type="text" name="national_id_new" id="national_id_new"  class="form-control" value="{{$national_id_new}}">	
											 </div> 
											 <label class="control-label col-md-5 birth_certificate" style="display:none;">Birth Certificate</label>	
											 <div class="col-md-5 birth_certificate" style="padding-top:5px;display:none;" >
												<input type="text" name="birth_certificate" id="birth_certificate"  class="form-control" value="{{$birth_certificate}}">	
											 </div> 
											 <label class="control-label col-md-5 explanation_ans_date" style="display:none;">Explanation Date</label>	
											 <div class="col-md-5 explanation_ans_date" style="padding-top:5px;display:none;" >
												<input type="text" name="explanation_ans_date" id="explanation_ans_date"  class="form-control common_date" value="{{$explanation_ans_date}}">	
											 </div>  
											 <label class="control-label col-md-5 explanation_ans_given_date" style="display:none;">Explanation Answer Date</label>	
											 <div class="col-md-5 explanation_ans_given_date" style="padding-top:5px;display:none;" >
												<input type="text" name="explanation_ans_given_date" id="explanation_ans_given_date"  class="form-control common_date" value="{{$explanation_ans_given_date}}">	
											 </div> 
											 <div class="col-md-5 col-md-offset-5" style="padding-top:15px;">
												 <?php if($is_access == 1){?>
												<span id="btn_show_hide" >
													<button type="submit" id="add_button" class="btn btn-primary">{{$button}}</button>
												</span>
												<?php } ?>
											 </div> 
													
										</div> 
									</div>  
								</div> 
						</div>
				</fieldset>  
			</form>
				<div class="box-body"> 
				<hr> 
				<div class="row">
					<div class="col-md-12">
						<div class="box box-solid">
							<!-- /.box-header -->
							<div class="box-body">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>SL No</th>
											<th>Employee ID</th>
											<th>Employee Name</th>
											<th>Group</th> 
											<th>Category</th> 
											<th>Effect Date</th>  
											<th class="text-center" style="width:15%">Action</th> 
										</tr>
									</thead>
									<tbody> 
										<?php $i=1; if(count($emp_document_list) > 0) { foreach($emp_document_list as $v_emp_document_list) { ?>
										<tr <?php if($document_id == $v_emp_document_list->document_id){ ?> style="background-color:#edf5f9;" <?php } ?>>
											<td><?php echo $v_emp_document_list->document_id;?></td>
											<td><?php echo $v_emp_document_list->emp_id;?></td>
											<td><?php echo $v_emp_document_list->emp_name;?></td>
											<td><?php echo $v_emp_document_list->category_name;?></td>
											<td><?php echo $v_emp_document_list->subcategory_name;?></td>
											<td><?php echo date("d-m-Y",strtotime($v_emp_document_list->effect_date));?></td> 
											<?php if($v_emp_document_list->is_cancel == 0){ ?>
											<td style="text-align:center;">
											<a class="btn btn-primary" title="Edit" href="{{URL::to('/edms_document_edit/'.$v_emp_document_list->document_id)}}"><i class="glyphicon glyphicon-pencil"></i></a> 
											</td>
									<?php }  ?>
										</tr> 
										<?php } ?>

										<tr>
											<td align="right"  colspan="8"> 
												<div style="margin-top:20px;">
												<a href="{{URL::to('/edms_save_flag/')}}" style="background-color:#00A8B3"  class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</a>
												</div>
											</td>
										</tr>

										<?php } else { ?>
										<tr>
											<td align="center" colspan="8">There is no Record</td>
										</tr>
										<?php } ?>
										</tr>
									</tbody> 
								</table>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
				</div>
			</div>
		</div>
	</section>
<script> 

function set_extrafield(){
	var subcat_id = document.getElementById("subcat_id").value;
	if(subcat_id == 40){
		$(".national_id_new").show();
	}else{
		$(".national_id_new").hide();
	}
	if(subcat_id == 154){
		$(".birth_certificate").show();
	}else{
		$(".birth_certificate").hide();
	}
	if(subcat_id == 71){
		$(".explanation_ans_date").show();
	}else{
		$(".explanation_ans_date").hide();
	}
	if(subcat_id == 143){
		$(".explanation_ans_given_date").show();
	}else{
		$(".explanation_ans_given_date").hide();
	}
	//alert('ok');
}


<?php if($click_control == 1){?>
		get_emp_info();
<?php } ?>
$(document).ready(function() {
	$('#search').on('submit',function(e){
		e.preventDefault();
		get_emp_info();
		});
});	
function duplicate_check() {  
	var document_id = document.getElementById("document_id").value;
	//alert(document_id);
	if(document_id == ''){
		document_id = 0;
	}  
	var emp_id = document.getElementById("emp_id").value;
	var category_id = document.getElementById("category_id").value;
	var subcat_id = document.getElementById("subcat_id").value;
	var effect_date = document.getElementById("effect_date").value;
	var succeed = false;
		$.ajax({
				url : "{{ url::to('duplicate_check') }}"+"/"+emp_id+"/"+category_id+"/"+subcat_id+"/"+effect_date+"/"+document_id,
				type: "GET",
				async: false,
				success: function(data)
				{
					if(data == 1){
						alert("already exist!!!");
						succeed = false;
					}else{
						succeed = true;
					}  
				}
			});  
	return succeed;
}

    $(".readonly").keydown(function(e){
        e.preventDefault();
    });
 
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
				$('#preview-'+id).hide('');
                $('#preview-'+id+'_1').attr('src', e.target.result);
            }else{
				$('#preview-'+id+'_1').attr('src', '');
				$('#preview-'+id).attr('style', "width:20%");
                $('#preview-'+id).attr('src',"{!!asset('storage/attachments/doc.png')!!}");
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
 function get_emp_info(){
	var emp_id = $("#emp_id1").val();
		//alert(emp_id);
		  $.ajax({
			type: "GET",
			dataType: 'json',
			url : "{{URL::to('select-empinfo')}}"+"/"+emp_id, 
			success: function(data)
			{
			console.log(data); 
				
				if(data["emp_id"]){
					if(data["is_access"] == 1 ){ 
						$("#emp_id").val(data["emp_id"]);
						$("#emp_name").val(data["emp_name"]);
						$("#branch_code").val(data["branch_name"]);  
						if((data["incharge_as"]) !=''){
							$("#designation_code").val(data["designation_name"]+"( "+data["incharge_as"]+" )");
						}else{
							$("#designation_code").val(data["designation_name"]);
						}
						$("#add_button").removeAttr("disabled");
						
					}else{
						alert("Access Denied ");
						$("#emp_id").val('');
						$("#emp_name").val(''); 
						$("#branch_code").val('');
						$("#designation_code").val('');
						 $("#add_button").attr("disabled", true);
						  
					}
				}else{
					$("#emp_id").val('');
					$("#emp_name").val(''); 
					$("#branch_code").val('');
					$("#designation_code").val('');
					$("#add_button").removeAttr("disabled");
				}
				//$("#yearly_leave").val(data); 
			}
		});  
  
 }
	 
		
$('#category_id').on('change',function(e){
		e.preventDefault(); 
		var category_id = $(this).val();
		var access_type = 1;
		//alert(category_id);
		   $.ajax({
			type: "GET",
			url : "{{URL::to('select-subcategory')}}"+"/"+category_id, 
			success: function(data)
			{
				//alert(data); 
				 $("#subcat_id").html(data);
				/*$("#emp_name").val(data.split("/")[3]);
				$("#branch_code").val(data.split("/")[2]);
				$("#designation_code").val(data.split("/")[5]); */
			}
		}); 
	});
</script>
<script type="text/javascript"> 
$(document).ready(function() {
	$('.common_date').datepicker({dateFormat: 'yy-mm-dd'}); 
});
  var category_id = document.getElementById("category_id").value = '{{$category_id}}';
 var subcat_id = document.getElementById("subcat_id").value = '{{$subcat_id}}';
 //alert('{{$subcat_id}}');
	var doc = '{{$document_name}}';  
		if(category_id == 13){
			var folder_name = "c_v/";
		}else if(category_id == 5){
			var folder_name = "edu_cation/";
		}else if(category_id == 11){
			var folder_name = "miscell_aneous/";
		}else if(category_id == 24){
			var folder_name = "train_ing_info/";
		}else if(category_id == 2){
			var folder_name = "assessment/";
		}else {
			var folder_name = "attach_ment_tran/";
		} 
 //alert(doc);
 if(doc.split(".")[1] == 'pdf'){
	 $('#preview-'+3).attr('src', '');
     $('#preview-'+3+'_1').attr('src',"{!!asset('attachments/"+folder_name+doc+"')!!}");
 }else if(doc.split(".")[1] == 'doc'){
	$('#preview-'+3+'_1').attr('src', '');
	$('#preview-'+3).attr('style', "width:20%");
    $('#preview-'+3).attr('src',"{!!asset('attachments/doc.png')!!}");
 }else{
	 if(subcat_id == 190){
		    $('#preview-'+3+'_1').attr('src', '');
			$('#preview-'+3).attr('style', "width:100%;height:120px;");
			$('#preview-'+3).attr('src',"{!!asset('public/employee/"+doc+"')!!}");
	 }else{
			$('#preview-'+3+'_1').attr('src', '');
			$('#preview-'+3).attr('style', "width:100%;height:120px;");
			$('#preview-'+3).attr('src',"{!!asset('attachments/"+folder_name+doc+"')!!}");
	 }
	
 } 
 set_extrafield(); 
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupEDMS").addClass('active');
		$("#Add_Document").addClass('active');
	});
</script>
@endsection