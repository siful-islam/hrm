<?php $__env->startSection('title','Add License'); ?>
<?php $__env->startSection('main_content'); ?>
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
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Driver License</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Driver</a></li>
			<li class="active">License</li>
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
				<form class="form-horizontal" action="" id="search" role="form" method="POST">
                <?php echo e(csrf_field()); ?> 
				<div class="box-body"> 
						<div class="row">  
							<div class="col-md-4">
								<div class="form-group"> 
									<label class="control-label col-md-5">Employee ID</label>
										<div class="col-md-5">
											<input type="text"  id="emp_id1" class="form-control" value="<?php echo e($emp_id); ?>" required>
											<span class="help-block"></span>
										</div> 
								</div> 
							</div> 
							<div class="col-md-3">
								<div class="form-group">  
									<button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
								</div> 
							</div> 
						</div>   
				</div>
					
			</form>
			<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>"  onsubmit="return check_exist_driver_license()"  role="form" method="POST" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?> 
				<input type="hidden" name="hidden_document_name" class="form-control" value="<?php echo e($document_name); ?>" readonly>
				<input type="hidden" name="dri_license_id" id="dri_license_id" class="form-control" value="<?php echo e($dri_license_id); ?>" readonly> 
                <fieldset>
						<LEGEND class="col-md-9 col-md-offset-1" style="padding-left:0px;"><b> Employee Information</b></LEGEND>
						<div class="box-body"> 
								<div class="row"> 
									<div class="col-md-5 col-md-offset-1">
										<div class="form-group"> 
											<label class="control-label col-md-5">Employee ID<span class="required">*</span></label>
												<div class="col-md-5">
													<input type="text" name="emp_id" id="emp_id" class="form-control readonly" value="<?php echo e($emp_id); ?>"  required   >
													<span class="help-block"></span>
												</div> 
										</div> 
									</div>
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-5"><span class="required">*</span>Employee Name</label>
												<div class="col-md-5">
													<input type="text" name="emp_name" id="emp_name" class="form-control readonly" value="<?php echo e($emp_name); ?>"  required>
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
													<input type="text" name="designation_code" id="designation_code"  class="form-control readonly" value="<?php echo e($designation_code); ?>"  required>
													<span class="help-block"></span>
												</div> 
										</div> 
									</div> 
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-5">Working Station<span class="required">*</span></label>
												<div class="col-md-5">
													<input type="text" name="branch_code" id="branch_code"   class="form-control readonly" value="<?php echo e($branch_code); ?>" required>
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
											<label class="control-label col-md-5">License Number<span class="required">*</span></label>
												<div class="col-md-5">
													<input type="text" name="license_number" id="license_number"  class="form-control" value="<?php echo e($license_number); ?>" required>
													
												</div> 
										</div> 
									</div> 
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-5">expired Date<span class="required">*</span></label>
												<div class="col-md-5">
													<input type="text" name="license_exp_date" id="license_exp_date"  class="form-control common_date" value="<?php echo e($license_exp_date); ?>" required>
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
													<input <?php echo e($required); ?> name="document_name" accept="image/*, application/pdf" class="uploadjs form-control" data-id="3" type="file">
 
													<span class="help-block preview">
														<img id="preview-3" alt="">
														<embed id="preview-3_1" type="application/pdf" style="width:100%;"> 
														<!--<iframe src="<?php echo e(asset('storage/attachments/1_1.doc')); ?>"  type="application/msword" style="width:100%;height:150px;" > </iframe>-->
													</span>
												</div> 
										</div> 
									</div> 
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-5"></label>
												<div class="col-md-5">
													<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo e($button); ?></button>
												</div> 
										</div> 
									</div> 
									
								</div> 
						</div>
				</fieldset> 
			</form>
		</div>
	</section>
<script>  
function check_exist_driver_license(){    

			var emp_id  			= document.getElementById("emp_id").value;  
			var license_exp_date  	= document.getElementById("license_exp_date").value; 
			var dri_license_id  	= document.getElementById("dri_license_id").value; 
			//alert(dri_license_id);
			var succeed = false;
						$.ajax({
							type:'GET',
							async: false,
							url : "<?php echo e(URL::to('check_exist_driver_license')); ?>"+"/"+license_exp_date+"/"+emp_id+"/"+dri_license_id,  
							success:function(res){
									//alert(res);
							 if(res == 2){  
								 succeed = true;
							}else if(res == 1){ 
								alert("This Employee's Driving License is already Exist !!");
								succeed = false;
							}
						}
					}); 
				 //alert('yes');
			 
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
                $('#preview-'+id+'_1').attr('src', e.target.result);
            }else{
				$('#preview-'+id+'_1').attr('src', '');
				$('#preview-'+id).attr('style', "width:20%");
                $('#preview-'+id).attr('src',"<?php echo asset('storage/attachments/driver_license/doc.png'); ?>");
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
	$('#search').on('submit',function(e){
		e.preventDefault();
		//alert('ok');
		var emp_id = $("#emp_id1").val(); 
		//alert(emp_id);
		  $.ajax({
			type: "GET",
			url : "<?php echo e(URL::to('select_empinfo_driver')); ?>"+"/"+emp_id, 
			success: function(data)
			{
				//alert(data); 
				if(data){
					$("#emp_id").val(data.split(",")[0]);
					$("#emp_name").val(data.split(",")[3]);
					$("#branch_code").val(data.split(",")[2]);
					$("#designation_code").val(data.split(",")[5]);
				}else{
					$("#emp_id").val('');
					$("#emp_name").val('');
					$("#branch_code").val('');
					$("#designation_code").val('');
				}
			}
		});  
	});
});	
</script>
<script type="text/javascript"> 
$(document).ready(function() {
	$('.common_date').datepicker({dateFormat: 'yy-mm-dd'}); 
}); 
 var doc = '<?php echo e($document_name); ?>'; 
 //alert(doc);
 if(doc.split(".")[1] == 'pdf'){
	 $('#preview-'+3).attr('src', '');
     $('#preview-'+3+'_1').attr('src',"<?php echo asset('storage/attachments/driver_license/"+doc+"'); ?>");
 }else if(doc.split(".")[1] == 'doc'){
	$('#preview-'+3+'_1').attr('src', '');
	$('#preview-'+3).attr('style', "width:20%");
    $('#preview-'+3).attr('src',"<?php echo asset('storage/attachments/driver_license/doc.png'); ?>");
 }else{
	 $('#preview-'+3+'_1').attr('src', '');
	 $('#preview-'+3).attr('style', "width:100%;height:120px;");
    $('#preview-'+3).attr('src',"<?php echo asset('storage/attachments/driver_license/"+doc+"'); ?>");
 } 
</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupDriving_License").addClass('active');
			$("#Add_License").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>