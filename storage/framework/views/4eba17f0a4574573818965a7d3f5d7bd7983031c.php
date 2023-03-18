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
  <h4>CV</h4>
</section>
<section class="content">
	<div class="row">			
		<!-- form start -->	
		<form class="form-horizontal" >
			<div class="col-md-8">
				<div class="box box-info">
					<div class="box-body">						
						<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						<div id="printme">
						<h4 style="text-align: center">সংক্ষিপ্ত তথ্য বিবরনী</h4>
						<div style="border: 1px solid gray; padding: 10px;">
						<table style="border-collapse: collapse; padding: 10px;" width="100%">
							<tbody>						
								<tr> 
									<td width="20%" style="padding-right: 25px;">১. নাম :</td>
									<td width="20%">বাংলা :</td>
									<td width="50%" style="border: 1px solid black; padding: 5px;"><?php echo e($result_info->name_ban); ?></td>
								</tr>
								<tr>
									<td></td>
									<td width="20%" style="padding-right: 25px;">ইংরেজি :</td>
									<td width="70%" style="border: 1px solid black; padding: 5px;"><?php echo e($result_info->name_eng); ?></td>
								</tr>	 
							</tbody>
						</table>
						<br/>
						<table style="border-collapse: collapse; padding: 10px;" width="100%">
							<tbody>						
								<tr> 
									<td width="20%" style="padding-right: 25px;">২. পিতার নাম :</td>
									<td width="20%">বাংলা :</td>
									<td width="50%" style="border: 1px solid black; padding: 5px;"><?php echo e($result_info->fathers_name_ban); ?></td>
								</tr>
								<tr>
									<td></td>
									<td width="20%" style="padding-right: 25px;">ইংরেজি :</td>
									<td width="70%" style="border: 1px solid black; padding: 5px;"><?php echo e($result_info->fathers_name_eng); ?></td>
								</tr>	 
							</tbody>
						</table>
						<br/>
						<table style="border-collapse: collapse; padding: 10px;" width="100%">
							<tbody>						
								<tr> 
									<td width="20%" style="padding-right: 25px;">৩. মাতার নাম :</td>
									<td width="20%">বাংলা :</td>
									<td width="50%" style="border: 1px solid black; padding: 5px;"><?php echo e($result_info->mothers_name_ban); ?></td>
								</tr>
								<tr>
									<td></td>
									<td width="20%" style="padding-right: 25px;">ইংরেজি :</td>
									<td width="70%" style="border: 1px solid black; padding: 5px;"><?php echo e($result_info->mothers_name_eng); ?></td>
								</tr>	 
							</tbody>
						</table>
						<br/>
						<table style="border-collapse: collapse; padding: 10px;" width="100%">
							<tbody>						
								<tr> 
									<td width="20%" style="padding-right: 25px;">৪. স্বামী/স্ত্রীর নাম :</td>
									<td width="20%">বাংলা :</td>
									<td width="50%" style="border: 1px solid black; padding: 5px;"><?php echo e($result_info->spouse_name_ban); ?></td>
								</tr>
								<tr>
									<td></td>
									<td width="20%" style="padding-right: 25px;">ইংরেজি :</td>
									<td width="70%" style="border: 1px solid black; padding: 5px;"><?php echo e($result_info->spouse_name_eng); ?></td>
								</tr>	 
							</tbody>
						</table>
						<br/>
						<table style="border-collapse: collapse; padding: 10px;" width="100%">
							<tbody>						
								<tr> 
									<td width="40%" style="padding-right: 25px;">৫. স্থায়ী ঠিকানা :</td>
									<td width="60%" style="border: 1px solid black; padding: 5px; margin-left: 20%;"><?php echo e($result_info->permanent_address); ?></td>
								</tr>	 
							</tbody>
						</table>
						<br/>
						<table style="border-collapse: collapse; padding: 10px;" width="100%">
							<tbody>						
								<tr> 
									<td width="40%" style="padding-right: 25px;">৬. বর্তমান ঠিকানা :</td>
									<td width="60%" style="border: 1px solid black; padding: 5px; margin-left: 20%;"><?php echo e($result_info->present_address); ?></td>
								</tr>	 
							</tbody>
						</table>
						<br/>
						<table style="border-collapse: collapse; padding: 10px;" width="100%">
							<tbody>						
								<tr> 
									<td width="40%" style="padding-right: 25px;">৭. বর্তমান পেশা :</td>
									<td width="60%" style="border: 1px solid black; padding: 5px; margin-left: 20%;"><?php echo e($result_info->profession); ?></td>
								</tr>
							</tbody>
						</table>
						<br/>
						<table style="border-collapse: collapse; padding: 10px;" width="100%">
							<tbody>						
								<tr> 
									<td width="40%" style="padding-right: 25px;">৮. শিক্ষাগত যোগ্যতা :</td>
									<td width="60%" style="border: 1px solid black; padding: 5px; margin-left: 20%;"><?php echo e($result_info->exam_name); ?></td>
								</tr>
							</tbody>
						</table>
						<br/>
						<table style="border-collapse: collapse; padding: 10px;" width="100%">
							<tbody>						
								<tr> 
									<td width="40%" style="padding-right: 25px;">৯. জন্ম তারিখ :</td>
									<td width="60%" style="border: 1px solid black; padding: 5px; margin-left: 20%;"><?php echo e($result_info->birth_date); ?></td>
								</tr>
							</tbody>
						</table>
						<br/>
						<table style="border-collapse: collapse; padding: 10px;" width="100%">
							<tbody>						
								<tr> 
									<td width="40%" style="padding-right: 25px;">১০. মোবাইল/ফোন নং :</td>
									<td width="60%" style="border: 1px solid black; padding: 5px; margin-left: 20%;"><?php echo e($result_info->mobile_phone); ?></td>
								</tr>
							</tbody>
						</table>
						<br/>
						<table style="border-collapse: collapse; padding: 10px;" width="100%">
							<tbody>						
								<tr> 
									<td width="40%" style="padding-right: 25px;">১১. রাজনৈতিক সংশ্লিষ্টতা :</td>
									<td width="60%" style="border: 1px solid black; padding: 5px; margin-left: 20%;"><?php echo e($result_info->political_involve == 1 ? "Yes" : "No"); ?></td>
								</tr>
							</tbody>
						</table>
						<br/>
						<table style="border-collapse: collapse; padding: 10px;" width="100%">
							<tbody>						
								<tr> 
									<td width="40%" style="padding-right: 25px;">১২. সদস্যদের মধ্যে সম্পর্ক :</td>
									<td width="60%" style="border: 1px solid black; padding: 5px; margin-left: 20%;"><?php echo e($result_info->relation_other_member); ?></td>
								</tr>
							</tbody>
						</table>
						<br/>
						<table style="border-collapse: collapse; padding: 10px;" width="100%">
							<tbody>						
								<tr> 
									<td width="40%" style="padding-right: 25px;">১৩. সমাজকল্যাণমূলক কাজের পূর্ব অভিজ্ঞতা :</td>
									<td width="60%" style="border: 1px solid black; padding: 5px; margin-left: 20%;"><?php echo e($result_info->pre_exp_social_work); ?></td>
								</tr>
							</tbody>
						</table>					
						</div>					
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</form>			
	</div>
</section>
<script>
    function printDiv(divID) {
		var divToPrint = document.getElementById(divID);
			//document.getElementById('note').style.display = 'block';
		var htmlToPrint = '' +
			'<style type="text/css">' + '.table-bordered th {' +
			'border:1px solid #757070;padding:2px;font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + '.table-bordered td {' +
			'border:1px solid #757070;padding:2px;font: 11px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + 'table {' +
			'border-collapse: collapse;' +
			'width:100%;' +
			'}' + 'body {' +
			'margin-left: 10px;' +
			'}' +  
			'</style>';
		htmlToPrint += divToPrint.outerHTML;
		newWin = window.open("");
		newWin.document.write(htmlToPrint);
		newWin.print();
		newWin.close();
    }

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
	document.getElementById("country_id").value="";
	document.getElementById("blood_group").value="";
	document.getElementById("religion").value="";
	document.getElementById("district_code").value="";
</script>
<script type="text/javascript">
	function LoadAddress() {
        //alert ('sssss');
		var v='Vill';
		var p='Post';
		var t='Thana';
		var d='Dist';
		var text=document.getElementById('vill_road').value;
        var text1=document.getElementById('post_office').value;
		var text2=document.getElementById('upazila_id').selectedOptions[0].text;
		var text3=document.getElementById('district_code').selectedOptions[0].text;
		document.getElementById('address').value= v + ":" + " " + text + "," + " " + p + ":" + " " + text1 + "," + " " + t + ":" + " " + text2 + "," + " " + d + ":" + " " + text3;
    }
</script> 
<script type="text/javascript">

</script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#birth_date').datepicker({dateFormat: 'yy-mm-dd',changeYear: true,changeMonth: true,yearRange: "1940:2000" });
});
//--></script>
<script type="text/javascript">
$(document).ready(function() {
$('.form_date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>