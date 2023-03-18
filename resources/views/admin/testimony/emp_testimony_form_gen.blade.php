@extends('admin.admin_master')
@section('title', 'Add Experience Certificate')
@section('main_content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Testimonial<small>add</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Testimonial</a></li>
			<li class="active">add</li>
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
				<form   action="{{URL::to('/emp_info_testimony_gen')}}" method="post" enctype="multipart/form-data" id="form1">
					  {{csrf_field()}}  
					<div class="row">   
						<div class="col-md-3">
							<div class="form-group"> 
								<label class="control-label col-md-4">Employee ID :</label>
									<div class="col-md-6">
										<input type="text"  name="employee_id" id="employee_id"  class="form-control"  value="<?php // echo $employee_id; ?>" required  <?php // echo $mode_em_id;?>/>
										<span class="help-block"></span>
									</div> 
							</div> 
						</div> 
						<div class="col-md-2">
							<div class="form-group">   
								<input type="submit" class="btn btn-primary"  value="Search" id="search"/>
								<span class="help-block"></span> 
							</div> 
						</div>  
						<?php if($is_show == 1){?>
							<div class="col-md-offset-2 pull-left"> 
								<input type="radio" id="a" onclick="set_view_of_a_b()" name="aa" value="1" checked>
								<label for="a">Short</label>
								<input type="radio" id="b" onclick="set_view_of_a_b()"  name="aa" value="0">
								<label for="b">Broad</label> 
							</div>
						<?php } ?>	
					</div>   
				</form> 
			
			<?php if(!empty($employee_his)){?>
				<br>
				<br>
				<form class="form-horizontal" action="{{URL::to('/insert_emp_testimony_gen')}}" role="form" method="POST" enctype="multipart/form-data">
                {{csrf_field()}} 
						<div class="box-body"> 
							 <input type="hidden" name="letter_date" id="letter_date" value="{{$letter_date}}" class="form-control">  
							 <input type="hidden" name="is_short" id="is_short" value="{{$is_short}}" class="form-control"> 
							 <input type="hidden" name="emp_id" id="emp_id" value="{{$emp_id}}" class="form-control"> 
							 <input type="hidden" name="t_date" id="t_date" value="{{$t_date}}" class="form-control">  
							 <input type="hidden" name="pre_designation_code" id="pre_designation_code" value="{{$pre_designation_code}}" class="form-control"> 
							 <input type="hidden" name="branch_code" id="branch_code" value="{{$branch_code}}" class="form-control"> 
							 <input type="hidden" name="designation_code" id="designation_code" value="{{$designation_code}}" class="form-control"> 
							 <input type="hidden" name="serial_no" id="serial_no" value="{{$serial_no}}" class="form-control"> 
							 <input type="hidden" name="ye_ar" id="ye_ar" value="{{$ye_ar}}" class="form-control"> 
								<div class="row">  
									<div class="col-md-11 col-md-offset-1">
										<div class="form-group"> 
												<div class="col-md-10" style="text-align:justfy;text-justify: inter-word;">
												<br>
												<span class="pull-left"  style="font-size:16px;">
													<?php $ff = date('m/d/Y'); echo date("F d,  Y",strtotime($ff)); ?>
												</span> 
												<br>
												<br>
												<br>
												<span style="font-size:16px;">
													SL No. <?php echo $serial_no; ?>/<?php echo $ye_ar; ?>
												</span>
												<br>
												<br> 
												<h3 style="text-align:center; font-size:24px;"><u>TO WHOM IT MAY CONCERN</u></h3>
												<br>
												<br>
												<br>
												<span style="text-align: justify;text-justify: inter-word;font-size:16px;">
													 <p id="view_a"> <span style="text-justify:right;"> This is to certify that <?php if($gender == 'male' || $gender == 'Male' ){ echo 'Mr.'; } else { echo 'Ms.'; }?><b> <?php echo $employee_his->emp_name;?></b>, S/O- Mrs. <?php echo $employee_his->mother_name;?> & Mr. <?php echo $employee_his->father_name;?>, CDIP ID No. <?php  echo $employee_his->emp_id;?>, working in Centre for Development Innovation and Practices (CDIP) as <?php echo $current_designation_name;?> from <?php echo date("j\<\s\u\p\>S\<\/\s\u\p\> F Y",strtotime($employee_his->joining_date));?>  to till date.
													</span>
													</p> 
													 <p id="view_b" style="display:none;"> This is to certify that <?php if($gender == 'male' || $gender == 'Male' ){ echo 'Mr.'; } else { echo 'Ms.'; }?><b> <?php echo $employee_his->emp_name;?></b>, S/O- Mrs. <?php echo $employee_his->mother_name;?> & Mr. <?php echo $employee_his->father_name;?>,  CDIP ID No. <?php  echo $employee_his->emp_id;?>, joined the Centre for Development Innovation and Practices (CDIP) as  <?php echo $employee_his->pre_designation_name;?> on <?php echo date("j\<\s\u\p\>S\<\/\s\u\p\> F Y",strtotime($employee_his->joining_date));?> and then subsequently <?php  if($gender == 'male' || $gender == 'Male' ){ echo 'he'; } else { echo 'she'; }?> was promoted to <?php echo $current_designation_name;?> on <?php echo date("j\<\s\u\p\>S\<\/\s\u\p\> F Y",strtotime($current_effect_date));?>, which <?php  if($gender == 'male' || $gender == 'Male' ){ echo 'he'; } else { echo 'she'; }?> has been continuing till date.
													</p>
													
													<br>
													<br>
													<br>
													
													We wish  <?php if($gender == 'male' || $gender == 'Male' ){ echo 'him'; } else { echo 'her'; }?> all the success in life.
													
													<br>
													<br>
													<br>
													<br>
													<br>
													<br>
													<br>
												</span>	
												<span style="text-align: justify;text-justify: inter-word;font-size:16px;">	  
													
													<br>
													<br>
													<br>
													
													Md. Ibrahim Meah, SPHRi 
													<br>
													DGM and Head of HR & OD
												<br>
												</span>
												<span>
												<input type="submit" id="submit_btn" class="btn btn-primary" value="{{$button}}">
													<a href="{{URL::to('/certi_general')}}" class="btn btn-success" >&nbsp;&nbsp;list&nbsp;&nbsp;</a>
													</span>
												</div>  
										</div> 
									</div> 
								</div>    
						</div> 
					</form>
			<?php } ?>
		</div>
	</section>
<script>
function set_view_of_a_b(){ 
		if ($("#a").is(":checked")) {
			$("#view_a").show();
			$("#view_b").hide();
			$("#is_short").val(1);
		}else{
			$("#view_a").hide();
			$("#view_b").show();
			$("#is_short").val(0);
		}
	
} 
</script>
<script type="text/javascript">  
</script>
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupExperience_Certificate").addClass('active');
			$("#Certificate").addClass('active');
		});
	</script>

@endsection