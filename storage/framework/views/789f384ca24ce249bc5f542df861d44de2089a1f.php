<?php $__env->startSection('main_content'); ?>
<style>
.image-upload > input
{
    display: none;
}
.image-upload img
{
	margin-right:0;
	width:120px;
	height:130px;
    cursor: pointer;	
	background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px; 
}
.content {
font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
.required {
    color: red;
}
</style>
<section class="content-header">
  <h4>Add-CV</h4>
</section>
<section class="content">
	<div class="row">			
		<!-- form start -->	
		<form action="<?php echo e(URL::to($action)); ?>" method="<?php echo e($method); ?>" class="form-horizontal" enctype="multipart/form-data">
			<?php echo e(csrf_field()); ?>

			<?php echo $method_field; ?>

			<div class="col-md-6">
				<?php if(Session::has('message1')): ?>
				<h5 style="color:green">
				<?php echo e(session('message1')); ?>

				</h5>
				<?php endif; ?>
				<div class="box box-info">
					<div class="box-body">							
						<div class="form-group">
							<label class="col-sm-4 control-label">Body Name</label><span class="required">*</span>
							<div class="col-sm-6">
								<select name="body_name" id="body_name" class="form-control">
									<option value="">Select</option>
									<option value="1">General</option>
									<option value="2">Governing </option>
								</select>
							</div>
						</div>
						<div id="board_serial" style="display: none;">
						<div class="form-group">
							<label class="col-sm-4 control-label">Board Serial No.</label><span class="required">*</span>
							<div class="col-sm-6">
								<select name="board_serial_no" id="board_serial_no" required class="form-control">
									<option value="">Select</option>
									<?php foreach ($all_board_no as $board) { ?>
									<option value="<?php echo $board->board_no; ?>"><?php echo $board->board_name.' ('. date("d-m-Y", strtotime($board->effect_date_from)).' to '. date("d-m-Y", strtotime($board->effect_date_to)).')'; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Name (Eng)</label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="name_eng" id="name_eng" value="<?php echo e($name_eng); ?>" required autofocus class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Name (Bang)</label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="name_ban" id="name_ban " value="<?php echo e($name_ban); ?>" required class="form-control">		
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Father's Name (Eng)</label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="fathers_name_eng" id="fathers_name_eng" value="<?php echo e($fathers_name_eng); ?>" required class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Father's Name (Bang)</label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="fathers_name_ban" id="fathers_name_ban" value="<?php echo e($fathers_name_ban); ?>" required class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Mother's Name (Eng)</label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="mothers_name_eng" id="mothers_name_eng" value="<?php echo e($mothers_name_eng); ?>" required class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Mother's Name (Bang)</label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="mothers_name_ban" id="mothers_name_ban" value="<?php echo e($mothers_name_ban); ?>" required class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Spouse Name (Eng)</label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="spouse_name_eng" id="spouse_name_eng" value="<?php echo e($spouse_name_eng); ?>" required class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Spouse Name (Bang)</label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="spouse_name_ban" id="spouse_name_ban" value="<?php echo e($spouse_name_ban); ?>" required class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Permanent Address</label>
							<div class="col-sm-6">
								<textarea name="permanent_address" id="permanent_add" class="form-control" ><?php echo e($permanent_address); ?></textarea>
								<input type="checkbox" id="checkbox" class="form-check-input" /> Same as above
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Present Address</label>
							<div class="col-sm-6">
								<textarea name="present_address" id="present_add" class="form-control" ><?php echo e($present_address); ?></textarea>
							</div>
						</div>						
						<div class="form-group">
							<label class="col-sm-4 control-label">Date of Birth</label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="birth_date" id="birth_date" value="<?php echo e($birth_date); ?>" required class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">National ID</label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="national_id" id="national_id" value="<?php echo e($national_id); ?>" required class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Education</label>
							<div class="col-sm-6">
								<select name="education" id="education" required class="form-control">
									<option value="">Select</option>
									<?php foreach ($all_exam as $exam) { ?>
									<option value="<?php echo $exam->exam_code; ?>"><?php echo $exam->exam_name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Profession</label>
							<div class="col-sm-6">
								<input type="text" name="profession" value="<?php echo e($profession); ?>" required class="form-control">
							</div>
						</div>						
					</div>
					<!-- /.box-body -->
				</div>
			</div>
			<div class="col-md-6">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label class="col-sm-4 control-label">Mobile/Phone</label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="mobile_phone" id="mobile_phone" value="<?php echo e($mobile_phone); ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">TIN No.</label>
							<div class="col-sm-6">
								<input type="text" name="tin_no" id="tin_no" value="<?php echo e($tin_no); ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Email</label>
							<div class="col-sm-6">
								<input type="text" name="email" id="email" value="<?php echo e($email); ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Nationality</label><span class="required">*</span>
							<div class="col-sm-6">
								<select name="nationality" id="nationality" class="form-control">
									<option value="1">Bangladeshi</option>
									<option value="2">Others</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Designation</label><span class="required">*</span>
							<div class="col-sm-6">
								<select name="designation" id="designation" required class="form-control">
									<option value="">Select</option>
									<option value="1">Chairman</option>
									<option value="2">Vice Chairman</option>
									<option value="3">Secretary</option>
									<option value="4">Member</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Effect date</label>
							<div class="col-sm-6">
								<input type="text" name="effect_date" id="effect_date" value="<?php echo e($effect_date); ?>" class="form-control form_date">
							</div>
						</div>						
						<div class="form-group">
							<label class="col-sm-4 control-label"> AGM Serial No. </label>
							<div class="col-sm-6">
								<input type="text" name="agm_serial_no" id="agm_serial_no" value="<?php echo e($agm_serial_no); ?>" required class="form-control" placeholder="Only Number" onkeypress="return IsNumeric(event,'error1');" onpaste="return false;" ondrop = "return false;"><span id="error1" style="color: Red; display: none">Only Numbers</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">AGM Date </label>
							<div class="col-sm-6">
								<input type="text" name="agm_date" id="agm_date" value="<?php echo e($agm_date); ?>" class="form-control form_date">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Remarks</label><span class="required">*</span>
							<div class="col-sm-6">
								<textarea name="remarks" class="form-control" ><?php echo e($remarks); ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Political Involvement</label>
							<div class="col-sm-6">
								<select name="political_involve" id="political_involve" class="form-control">
									<option value="">Select</option>
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Relation Other Member</label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="relation_other_member" id="relation_other_member" value="<?php echo e($relation_other_member); ?>" required class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Previous Experience Social Work</label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="pre_exp_social_work" id="pre_exp_social_work" value="<?php echo e($pre_exp_social_work); ?>" required class="form-control">
							</div>
						</div>					
						<div class="form-group">
							<label class="col-sm-4 control-label">Status</label><span class="required">*</span>
							<div class="col-sm-6">
								<select name="status" id="status" required class="form-control">
									<option value="">Select</option>
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">End Date</label>
							<div class="col-sm-6">
								<input type="text" name="close_date" id="close_date" value="<?php echo e($close_date); ?>" class="form-control form_date">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Photo</label>
							<div class="col-sm-6">
								<div class="image-upload">
									<label for="file-input">
										<img id="blah" class="img-thumbnail" src="<?php echo e(asset('public/board_member/'.$photo)); ?>" width="100"/> 
									</label>
									<input onchange="readURL(this);" id="file-input" name="emp_photo" type="file"/> 
									<strong><br>Photo Upload</strong>
								</div>
							</div>
						</div>	
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="<?php echo e(URL::to('/board-member')); ?>" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
						<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
					</div>
				   <!-- /.box-footer -->
				</div>
			</div>
		</form>			
	</div>
</section>
<script>
$(document).ready(function() {	
	var body_name = $('#body_name').val();	
	if (body_name == 2) {
		$("#board_serial").show();
	} else {
		$("#board_serial").hide();
	}
});
</script>
<script>
$("#body_name").click(function(){
  var body_name = $('#body_name').val();
  if (body_name == 2) {
		$("#board_serial").show();
		$('#board_serial_no').attr('required', 'required');
	} else {
		$("#board_serial").hide();
		$('#board_serial_no').removeAttr("required");
		document.getElementById("board_serial_no").value='';
	}
  
  /* if (body_name == 1) {
      $('#board_serial_no').val(1).attr('readonly','readonly');
    } else {
	  $('#board_serial_no').val('').removeAttr('readonly');
	} */
	
});

$("#checkbox").click(function(){
  if ($(this).is(':checked')) {
      //var abc = $('#permanent_add').val();
	  $("#present_add").val($('#permanent_add').val());
    } else {
		$("#present_add").val('');
	}
});

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('#blah')
				.attr('src', e.target.result)
				.css({'width' : '120px' , 'height' : '130px'});
		}; 
		reader.readAsDataURL(input.files[0]);
    }
}	
</script>
<script>
var specialKeys = new Array();
specialKeys.push(9); //Tab
var specialKeysb = new Array();
specialKeysb.push(8); //backspace 
function IsNumeric(e,id) {
	var keyCode = e.which ? e.which : e.keyCode;
	var ret = ((keyCode >= 48 && keyCode <= 57)|| keyCode == 46 || specialKeys.indexOf(keyCode) != -1 || specialKeysb.indexOf(keyCode) != -1);
	document.getElementById(id).style.display = ret ? "none" : "inline";
	return ret;
}
</script>
<script>
document.getElementById("body_name").value="<?php echo $body_name;?>";
document.getElementById("board_serial_no").value="<?php echo $board_serial_no;?>";
document.getElementById("education").value="<?php echo $education;?>";
document.getElementById("status").value="<?php echo $status;?>";
document.getElementById("nationality").value="<?php echo $nationality;?>";
document.getElementById("designation").value="<?php echo $designation_code;?>";
document.getElementById("political_involve").value="<?php echo $political_involve;?>";
</script>
<script type="text/javascript">

</script>
<script type="text/javascript">
$(document).ready(function() {
	$('#birth_date').datepicker({dateFormat: 'yy-mm-dd',changeYear: true,changeMonth: true,yearRange: "1940:2000" });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
$('.form_date').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>