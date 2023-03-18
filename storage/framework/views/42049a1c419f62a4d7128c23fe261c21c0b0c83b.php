<?php $__env->startSection('title', 'My Files'); ?>
<?php $__env->startSection('main_content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Self<small>Care</small></h1>
    </section>
    
	<section class="content-header">
        <a href="<?php echo e(URL::to('/profile')); ?>">
            <h5><i class="fa fa-arrow-left" aria-hidden="true"></i> Self Care</h5>
        </a>
    </section>
    <!-- Main content -->
	

		
	<section class="content">
		<div class="row">
			<div class="col-xs-6">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Personal Files </h3>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table id="table_doc" class="table table-bordered table-striped">
								<thead>
									<tr>
									<th>Date</th>
									<th>Subject</th>
									<th>Document</th>
									</tr>
								</thead>
								<tbody>
									<?php  $dc = 1;$i = 1;
									foreach ($emp_document_list as $emp_document) { ?>
									<tr>
										<td><?php echo date('d-m-Y', strtotime($emp_document->effect_date)); ?></td>
										<td><?php echo $emp_document->subcategory_name; ?></td>
										<?php
										$ddd = explode('.', $emp_document->document_name);
										if ($ddd[1] == 'pdf' || $ddd[1] == 'PDF') {
										$ext = 1;
										} elseif ($ddd[1] == 'doc' || $ddd[1] == 'DOC') {
										$ext = 2;
										} else {
										$ext = 3;
										}
										if ($emp_document->category_id == 13) {
										$folder_name = 'c_v';
										} elseif ($emp_document->category_id == 5) {
										$folder_name = 'edu_cation';
										} elseif ($emp_document->category_id == 11) {
										$folder_name = 'miscell_aneous';
										} elseif ($emp_document->category_id == 24) {
										$folder_name = 'train_ing_info';
										} else {
										if (($emp_document->effect_date == '2019-07-01' || $emp_document->effect_date == '2021-07-01') && $emp_document->category_id == 23 &&
										$emp_document->subcat_id == 24) {
										$folder_name = 'attach_ment_tran/auto_increment';
										} else {
										$folder_name = 'attach_ment_tran';
										}
										}
										$filename = "attachments/$folder_name/$emp_document->document_name";
										?>
										<td><a target="_blank" href="<?php echo $filename; ?>"><img src="<?php echo e(asset('storage/office_order/pdf.png')); ?>" width="30"></a></td>
									</tr>
									<?php } ?> 
								</tbody>  				
							</table>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-xs-6">
			
				<div class="box-body" id="html_remove">

				 				
				</div>
			
			</div>
		</div>
	</section>
	

    <script>
	
		function show_image(val,ext,category_id,subcat_id,effect_date){
			//alert(effect_date);
			var file_name = $("#file_name"+val).val(); 
			$("#html_remove").html(''); 
			var view_image = "<a  id='htm_image_show' download></a>";
			$("#html_remove").html(view_image); 
			//alert(file_name);
			if(category_id == 13){
				var folder_name = "c_v/";
			}else if(category_id == 5){
				var folder_name = "edu_cation/";
			}else if(category_id == 11){
				var folder_name = "miscell_aneous/";
			}else if(category_id == 24){
				var folder_name = "train_ing_info/";
			}else {
				if((effect_date == '2019-07-01' || effect_date == '2021-07-01') && (category_id == 23) && (subcat_id == 24))
				{
					var folder_name = "attach_ment_tran/auto_increment/";
				}else{
					var folder_name = "attach_ment_tran/";
				}
				
			} 
		  if(ext == 1){ ///for pdf
				//var dd="<embed src='<?php echo asset('storage/attachments/"+folder_name+file_name+"'); ?>' type='application/pdf'  width='100%'  height='700'>";
				var dd="<embed src='<?php echo asset('attachments/"+folder_name+file_name+"'); ?>' type='application/pdf'  width='100%'  height='700'>";
				//$("#htm_image_show").attr('href',"<?php echo asset('storage/attachments/"+folder_name+file_name+"'); ?>"); 
				$("#htm_image_show").attr('href',"<?php echo asset('attachments/"+folder_name+file_name+"'); ?>"); 
				$("#htm_image_show").html(dd); 
				document.getElementById("htm_image_show").focus();
			}else if(ext == 3){ /// for image
			 ///alert('not ok');
		
				var dd="<img src='<?php echo asset('attachments/"+folder_name+file_name+"'); ?>'  width='100%'  height='100%'>";
				$("#htm_image_show").attr('href',"<?php echo asset('attachments/"+folder_name+file_name+"'); ?>"); 
				$("#htm_image_show").html(dd); 
			}else if(ext == 2){ // for doc 
			 var dd="<iframe  src='<?php echo asset('attachments/"+folder_name+file_name+"'); ?>'  width='100%'  height='100%'></iframe>";
				$("#htm_image_show").attr('href',"<?php echo asset('attachments/"+folder_name+file_name+"'); ?>");  
				$("#htm_image_show").html(dd);  
				/* var dd="<iframe src='storage/attachments/"+file_name+"'  width='100%'  height='400'></iframe>";
				$("#htm_image_show").attr('href',"storage/attachments/"+file_name);  
				$("#htm_image_show").html(dd);   */
				 
			}  
			//alert(ext);
		}
        //To active  menu.......//
        $(document).ready(function() {
            $("#MainGroupSelf_Care").addClass('active');
            $("#Personal_File").addClass('active');
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>