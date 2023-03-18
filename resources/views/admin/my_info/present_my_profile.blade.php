@extends('admin.admin_master')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		<!-- Main row -->
		<div class="row"> 
        
				<!-- /.col -->
				<div class="col-md-4">
					<div class="box box-widget widget-user">
						<!-- Add the bg color to the header using any of the bg-* classes -->
						<div class="widget-user-header bg-aqua-active">
							<h3 class="widget-user-username"><?php echo $emp_name;?></h3>
							<h5 class="widget-user-desc"><?php echo $designation_name;?></h5>
							<h3 class="widget-user-username"><?php echo $emp_id;?></h3>
						</div>
						<div class="widget-user-image">
							<!--<img class="img-circle" src="{{asset('public/avatars/1505034887.jpg')}}" alt="User Avatar">-->
							@if($emp_cv_photo)
							<img class="img-circle" src="{{asset('public/avatars/1505034887.jpg')}}" width="50"  alt="User profile picture"> 
							@else
							<img class="img-circle" src="{{asset('public/avatars/no_image.jpg')}}" alt="User profile picture">
							@endif
						</div>
						
						
					
						<div class="box-footer">
							<div class="row">
								<div class="col-sm-4 border-right">
									<div class="description-block">
										<h5 class="description-header">Grade</h5>
										<span class="description-text"><?php echo $grade_code;?></span>
									</div>
								</div>
								<div class="col-sm-4 border-right">
									<div class="description-block">
										<h5 class="description-header">Department</h5>
										<span class="description-text"><?php echo $department_name;?></span>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="description-block">
										<h5 class="description-header">Working Station</h5>
										<span class="description-text"><?php echo $branch_name;?></span>
									</div>
								</div>
							</div>
						</div>
						
						<div class="box-body">
							<div class="table-responsive">
								<table class="table no-margin">
									<thead>
										<tr>
											<th>Joining Date</th>
											<th>Permanent Date</th>
											<th>Last Promotion Date</th>
											<th>Service Length</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><?php echo date('d-m-Y',strtotime($emp_cv_basic->org_join_date)); ?></td>
											<td><?php if($p_effect_date) { echo date('d-m-Y',strtotime($p_effect_date->effect_date)); } else { echo '--';}  ?></td>
											<td><?php if($promotion) { echo date('d-m-Y',strtotime($promotion->effect_date)); } else{ echo 'No Promotion'; }  ?></td>
											<td><?php 			
											$letter_date 	= date('Y-m-d');				
											date_default_timezone_set('Asia/Dhaka');
											$input_date = new DateTime($letter_date);
											$org_date = new DateTime($joining_date);	
											$difference = date_diff($org_date, $input_date);
											echo $difference->y . " years, " . $difference->m." months."; ?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						
					</div>
				</div>
		
		
	
		
		 
		

			<div class="col-md-2 col-sm-6 col-xs-12" onclick="change_class('cv');">
				<a href="#tab_1-1" data-toggle="tab">
				<div class="info-box">
					<span class="info-box-icon bg-aqua" id="cv"><img src="{{asset('public/profile/cv.png')}}" width="60%"></span>  
					<div class="info-box-content">
						<span class="info-box-text">Basic Info</span>
						<span class="info-box-number">C.V</span>
					</div>
				</div>
				</a>
			</div>
			
			
			<div class="col-md-2 col-sm-6 col-xs-12" onclick="change_class('pay');">
				<a href="#tab_2-2" data-toggle="tab">
				<div class="info-box">
					<span class="info-box-icon bg-aqua" id="pay"><i class="fa fa-usd" aria-hidden="true"></i></span>
					<div class="info-box-content">
						<span class="info-box-text"><h3>Pay Slip</h3></span>
						<span class="info-box-number"></span>
					</div>
				</div>
				</a>
			</div>
			
			<div class="col-md-2 col-sm-6 col-xs-12" onclick="change_class('document');">
				<a href="#tab_3-2" data-toggle="tab">
				<div class="info-box">
					<span class="info-box-icon bg-aqua" id="document"><i class="fa fa-book" aria-hidden="true"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">My Document</span>
						<span class="info-box-number"><?php echo count($emp_document_list); ?><small> files available</small></span> 
					</div>
				</div>
				</a>
			</div>
			
			<div class="col-md-2 col-sm-6 col-xs-12" onclick="change_class('leave');">
				<a href="#tab_LEAVE" data-toggle="tab">
				<div class="info-box">
					<span class="info-box-icon bg-aqua" id="leave"><img src="{{asset('public/profile/check-out.png')}}" width="60%"></span>
					<div class="info-box-content">
						<span class="info-box-text">Leave</span>
						<span class="info-box-number">14 <small> days remain</small></span>
					</div>
				</div>
				</a>
			</div>
			
			<div class="col-md-2 col-sm-6 col-xs-12" onclick="change_class('money');">
				<a href="#tab_MONEY" data-toggle="tab">
				<div class="info-box">
					<span class="info-box-icon bg-aqua" id="money"><img src="{{asset('public/profile/money-sack.png')}}" width="60%"></span>
					<div class="info-box-content">
						<span class="info-box-text">Security Money</span>
						<span class="info-box-number"><small>Under Construction</small></span>
					</div>
				</div>
				</a>
			</div>
			
			<div class="col-md-2 col-sm-6 col-xs-12" onclick="change_class('pf');">
				<a href="#tab_pf" data-toggle="tab">
				<div class="info-box">
					<span class="info-box-icon bg-aqua" id="pf"><img src="{{asset('public/profile/fundraiser.png')}}" width="60%"></span>
					<div class="info-box-content">
						<span class="info-box-text">P.F</span>
						<span class="info-box-number"><small>Balance</small></span> 
					</div>
				</div>
				</a>
			</div>
			
			<div class="col-md-2 col-sm-6 col-xs-12" onclick="change_class('loan');">
				<a href="#tab_LOAN" data-toggle="tab">
				<div class="info-box">
					<span class="info-box-icon bg-aqua" id="loan"><img src="{{asset('public/profile/pay.png')}}" width="60%"></span> 
					<div class="info-box-content">
						<span class="info-box-number">Loan Info.</span>
						<span class="info-box-text">Running Cycle: <small>1</small></span>
					</div>
				</div>
				</a>
			</div>
			
			<div class="col-md-2 col-sm-6 col-xs-12" onclick="change_class('timeline');">
				<a href="#tab_TIMELINE" data-toggle="tab">
				<div class="info-box">
					<span class="info-box-icon bg-aqua" id="timeline"><i class="fa fa-calendar" aria-hidden="true"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Timeline</span>
						<span class="info-box-number"><?php echo count($all_sarok); ?> <small> Records</small></span>
					</div>
				</div>
				</a>
			</div>
			
			<div class="col-md-2 col-sm-6 col-xs-12" onclick="change_class('noc');">
				<div class="info-box">
					<span class="info-box-icon bg-aqua" id="noc"><img src="{{asset('public/profile/diploma.png')}}" width="60%" ></span> 
					<div class="info-box-content">
						<span class="info-box-text">NOC</span>
						<span class="info-box-number"><small>Under Construction</small></span>
					</div>
				</div>
			</div>
			
			<div class="col-md-2 col-sm-6 col-xs-12" onclick="change_class('application');">
				<div class="info-box">
					<span class="info-box-icon bg-aqua" id="application"><img src="{{asset('public/profile/loan.png')}}" width="60%"></span>  
					<div class="info-box-content">
						<span class="info-box-text">Loan Application</span>
						<span class="info-box-number"><small>Under Construction</small></span>
					</div>
				</div>
			</div>
			
			<div class="col-md-2 col-sm-6 col-xs-12" onclick="change_class('emi');">
				<a href="#tab_EMI" data-toggle="tab">
				<div class="info-box">
					<span class="info-box-icon bg-aqua" id="emi"><i class="fa fa-calculator"></i></span> 
					<div class="info-box-content">
						<span class="info-box-text">EMI</span>
						<span class="info-box-number"><small>Loan Calculator</small></span>
					</div>
				</div>
				</a>
			</div>
			
			<div class="col-md-2 col-sm-6 col-xs-12" onclick="change_class('fine');"> 
				<a href="#tab_PUNISHMENT" data-toggle="tab">
				<div class="info-box">
					<span class="info-box-icon bg-aqua" id="fine"><img src="{{asset('public/profile/hammer.png')}}" width="60%"></span> 
					<div class="info-box-content">
						<span class="info-box-text">PUNISHMENT</span>
						<span class="info-box-number"><small>Warning, fine, Advice</small></span>
					</div>
				</div>
				</a>
			</div>
				
        </div>
		
		<div class="row"> 
			<div class="col-md-4">
				<div class="box box-info collapsed-box">
					<div class="box-header with-border">
						<h3 class="box-title">Web Links..</h3> 
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							
							<table class="table table-bordered">
										<tr>
											<td>1.</td>
											<td>Service Rules</td>
											<!--<td>Publish Date</td>-->
										</tr>
										<?php $i=1; foreach($offfice_orders as $offfice_order) { ?>
										<tr>
											<td><?php echo $i++; ?></th>
											<td><a href="{{asset('storage/office_order/'.$offfice_order->file_name)}}" target="_blank"><span class="label label-success"><?php echo $offfice_order->title ?></span></a></td>
											<!--<td><?php //echo date('d-m-Y',strtotime($offfice_order->order_date)) ;?></td>-->
										</tr>
										<?php } ?>									
									</table>
							
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-8">
				<div class="nav-tabs-custom">
					<div class="tab-content">

						<!-- tab-pane -->
						<div class="tab-pane" id="tab_1-1">
						
							<div class="box-header with-border">
								<h3 class="box-title">My:) C.V</h3> 
							</div>
							
							<div class="table-responsive">
							
											<table class="table table-bordered">
												<tr>
													<td>@if($emp_cv_photo)
													<img style="height: 180px; width: 172px;" class="img-thumbnail" src="{{asset('public/employee/'.$emp_cv_photo->emp_photo)}}" />
														@else
													<img style="height: 180px; width: 172px;" class="img-thumbnail" src="{{asset('public/employee/placeholder.png')}}" /> 
													@endif
													</td>
												</tr>
												<tr>
													<td width="30%">Employee ID</td>
													<td>{{$emp_cv_basic->emp_id}}</td>
												</tr>
												<tr>
													<td width="30%">Employee Name (ENG)</td>
													<td>{{$emp_cv_basic->emp_name_eng}}</td>
												</tr>
												<tr>
													<td width="30%">Employee Name (Bang)</td>
													<td>{{$emp_cv_basic->emp_name_ban}}</td>
												</tr>
												<tr>
													<td width="30%">Father's Name</td>
													<td>{{$emp_cv_basic->father_name}}</td>
												</tr>
												<tr>
													<td width="30%">Mother's Name</td>
													<td>{{$emp_cv_basic->mother_name}}</td>
												</tr>
												<tr>
													<td width="30%">Date of Birth</td>
													<td><?php echo date('d-m-Y',strtotime($emp_cv_basic->birth_date)); ?></td>
												</tr>
												<tr>
													<td width="30%">Present Age</td>
													<td><?php $date1 = new DateTime($emp_cv_basic->birth_date);
													$date2 = date('Y-m-d');						
													$date3 = new DateTime($date2);						
													$interval = date_diff($date1, $date3);
													echo $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; ?>
													</td>
													
												</tr>
												<tr>
													<td width="30%">Religion</td>
													<td>{{$emp_cv_basic->religion}}</td>
												</tr>
												<tr>
													<td width="30%">Maritial Status</td>
													<td>
														@if($emp_cv_basic->maritial_status == 'Married') {{'Married'}}
														@elseif($emp_cv_basic->maritial_status == 'Unmarried') {{'Unmarried'}}
														@else {{'N/A'}}
														@endif
													</td>
													
												</tr>
												<tr>
													<td width="30%">Nationality</td>
													<td>{{$emp_cv_basic->nationality}}</td>
													
												</tr>
												<tr>
													<td width="30%">National Id</td>
													<td>{{$emp_cv_basic->national_id}}</td>
												</tr>
												<tr>
													<td width="30%">Gender</td>
													
													<td>
													@if($emp_cv_basic->gender == 'Male') {{'Male'}}
													@else
													{{'Female'}}
													@endif
													</td>
												</tr>
												<tr>
													<td width="30%">Country Name</td>
													<td>Bangladesh</td>
												</tr>
												<tr>
													<td width="30%">Contact Number</td>
													<td>{{$emp_cv_basic->contact_num}}</td>
												</tr>
												<tr>
													<td width="30%">Email</td>
													<td>{{$emp_cv_basic->email}}</td>
												</tr>
												<tr>
													<td width="30%">Blood Group</td>
													<td>{{$emp_cv_basic->blood_group}}</td>
												</tr>
												<tr>
													<td width="30%">Joining Date</td>
													<td><?php echo date('d-m-Y',strtotime($emp_cv_basic->org_join_date)); ?></td>
												</tr>
												<tr>
													<td width="30%">Present Address</td>
													<td>{{$emp_cv_basic->present_add}}</td>
												</tr>
												<tr>
													<td width="30%">Permanent Address</td>
													<td>{{$emp_cv_basic->permanent_add}}</td>
												</tr>
											</table>
								
							</div>
						</div>
						<!-- /.tab-pane -->
						
						
						<!-- tab-pane -->
						<div class="tab-pane" id="tab_2-2">
							
							<div class="box-header with-border">
								
									<table>
										<tr>
											<td><h3 class="box-title">Pay Slip..</h3> </td>
											<td><input type="date" name="salary_month" id="salary_month" value="<?php echo date('Y-m-d', strtotime('last day of previous month')); ?>"></td>
											<td><button type="button" onClick="get_pay_slip();">Search</button></td>
											<td><button type="button" onclick="javascript:printDiv('printable_div')">Print</button></td>
										</tr>
									</table>
							</div>
							
							<hr>
							
									<div class="table-responsive" id="printable_div">
										
										<table border="0" cellspacing="0" width="100%" align="center">
											<tbody>
												<tr>
													<td rowspan="4" align="right"><img style="width: 80px; height: 80px;" src="{{ asset('public/org_logo/cdip.png') }}"></td>
													<td align="center"><b><font size="4">
														Centre for Development Innovation and Practices (CDIP)</font></b>
													</td>
												</tr>
												<tr>
													<td align="center">
													<font size="4"><b> সেন্টার ফর ডেভেলপমেন্ট ইনোভেশন এন্ড প্র্যাকটিসেস  (  সিদীপ ) </font></b>
													</td>
												</tr>
												<tr>
													<td align="center">
														<b><font size="2"> সিদীপ ভবন, হাউজ # ১৭, রোড # ১৩, পিসিকালচার হাউজিং সোসাইটি , শেখেরটেক, আদাবর, ঢাকা।</font></b>
													</td>
												</tr>
												<tr>
													<td align="center">
														<b><font size="2">Web: www.cdipbd.org, Phone: 02-48118633 & 02-48118634</font></b>
													</td>
												</tr>
											</tbody>
										</table>
										<hr>
										<center><h3><u>Monthly Pay Slip</u></h3></center>
										<br>
										<table width="100%" border="0">
											<tr>
												<td>Name </td>
												<td align="right"> : </td>
												<td align="left" width="60%">{{$emp_cv_basic->emp_name_eng}}</td>
												<td align="right">Month of Salary</td>
												<td align="right"> : </td>
												<td align="right" id="formatted_date">--</td>
											</tr>
											<tr>
												<td>ID</td>
												<td align="right"> :</td>
												<td><?php echo $emp_id;?></td>
											</tr>
											<tr>
												<td>Designation</td>
												<td align="right"> :</td>
												<td><?php echo $designation_name;?></td>
											</tr>
											<tr>
												<td>Program/Dept.</td>
												<td align="right"> :</td>
												<td><?php echo $department_name ; ?></td>
											</tr>
										</table>
										<br><br>
										<div id="dynamic_content">
										
										
										
										</div>
										<hr>
										<p>Note: This statement generated following payroll applications</p>
										
									</div>
							
							
						</div>
						<!-- /.tab-pane -->
						
						<!-- tab-pane -->
						<div class="tab-pane" id="tab_3-2">
						  <div class="box-header with-border">
								<h3 class="box-title">My :) Documents... </h3> 
							</div>
							<div class="table-responsive">
		
									<table class="table table-bordered">
										<tr>
											<th>Sl</th>
											<th>Subject</th>
											<th>Date</th>
											<th>Link</th>
										</tr>
										<?php $dc = 1; foreach($emp_document_list as $emp_document) { ?>
										<tr>
											<td><?php echo $dc++; ?></td>
											<td><span class="label label-info"><?php echo $emp_document->subcategory_name; ?></span></td>
											<td><?php echo date('d-m-Y',strtotime($emp_document->effect_date)); ?></td>
											<?php  
												$ddd = explode('.',$emp_document->document_name);
													if($ddd[1] == 'pdf' || $ddd[1] == 'PDF'){
														$ext = 1;
													}else if($ddd[1] == 'doc' || $ddd[1] == 'DOC' ){
														$ext = 2;
													}else{
														$ext = 3;
													}
													if($emp_document->category_id == 13){
														$folder_name = "c_v/";
													}else if($emp_document->category_id == 5){
														$folder_name = "edu_cation/";
													}else if($emp_document->category_id == 11){
														$folder_name = "miscell_aneous/";
													}else if($emp_document->category_id == 24){
														$folder_name = "train_ing_info/";
													}else {
														if(($emp_document->effect_date == '2019-07-01') && ($emp_document->category_id == 23) && ($emp_document->subcat_id == 24)){
															$folder_name = "attach_ment_tran/auto_increment/";
														}else{
															$folder_name = "attach_ment_tran/";
														}
													}
													$filename = "attachments/$folder_name/$emp_document->document_name";
												?> 
											<td><a href="{{asset($filename)}}" target="_blank" ><img src="{{asset('storage/office_order/pdf.png')}}" width="30"></a></td>
										</tr>
										<?php } ?>
									</table>
								
								
								
								
								
							</div>
						</div>
						<!-- /.tab-pane -->
						
						
						<!-- tab-pane TIMELINE -->
						<div class="tab-pane" id="tab_LOAN">
							<div class="box-header with-border">
								<h3 class="box-title">My :) Loan </h3> 
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Sl</th>
											<th>Loan Id</th>
											<th>Application Date</th>
											<th>Loan Code</th>
											<th>Loan Product</th>
											<th>Disbursement Date</th>
											<th>Loan Amount</th>
											<th>First repayment date</th>
											<th>View</th>
										</tr>
									</thead>
									<tbody>
											<?php $l=1; if(!empty($loanData[0])) { foreach($loanData as $loan) {  ?>
										<tr>
											<td><?php echo $l; ?></td>
											<td><?php echo $loan->loan_id; ?></td>
											<td><?php echo date('d-m-Y',strtotime($loan->application_date)); ?></td>
											<td><?php echo $loan->loan_code; ?></td>
											<td><?php echo $loan->loan_product_name; ?></td>
											<td><?php echo date('d-m-Y',strtotime($loan->disbursement_date)); ?></td>
											<td><?php echo $loan->loan_amount; ?></td>
											<td><?php echo date('d-m-Y',strtotime($loan->first_repayment_date)); ?></td>
											<td>
											<button type="button" class="btn btn-primary btn-xs button view_button"
													data-toggle="modal" data-target="#view_loan_details"
													data-id="{{ $loan->loan_id }}"
													data-loan_code="{{ $loan->loan_code }}"
													data-loan_product_name="{{ $loan->loan_product_name }}"
													data-first_repayment_date="{{ date("M-Y", strtotime($loan->first_repayment_date)) }}"
													data-emp_id="{{ $loan->emp_id }}"
													data-emp_name="{{ $loan->emp_name_eng }}">
												<i class="fa fa-search"></i>
											</button>
											</td>
										</tr>
										<?php $l++; } } else { ?>
										<tr>
											<td align="center" colspan="9">There is no loan informarion</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- /.tab-pane LOAN-->
						
						
						
						<!-- tab-pane TIMELINE -->
						<div class="tab-pane" id="tab_TIMELINE">
							<div class="box-header with-border">
								<h3 class="box-title">My :) Time Line</h3> 
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>#</th>
											<th>Transection</th>
											<th>Sarok No</th>
											<th>Letter Date</th>
											<th>Effect Date</th>
											<th>Working Station</th>
											<th>Designation</th>
											<th>Grade</th>
											<th>Step</th>
											<th>Basic Salary</th>
										</tr>
									</thead>
									
									
									<tbody>
										<?php $ti = count($all_sarok); foreach($all_sarok as $v_all_sarok) { ?>
									
										<tr>
											<td><?php echo $ti --;?></td>
											<td><span class="label label-info"><?php echo $v_all_sarok->transaction_name; ?></span></td>
											<td><?php echo $v_all_sarok->sarok_no;?></td>
											<td><?php echo date('d-m-Y',strtotime($v_all_sarok->letter_date)); ?></td>
											<td><?php if($v_all_sarok->transaction_code == 8) { echo date('d-m-Y',strtotime($v_all_sarok->br_join_date)); } else { echo date('d-m-Y',strtotime($v_all_sarok->effect_date)); }  ?></td>
											<td><?php echo @$v_all_sarok->branch_name;?></td>
											<td><?php echo $v_all_sarok->designation_name;?></td>
											<td><?php echo $v_all_sarok->grade_code;?></td>
											<td><?php if($v_all_sarok->grade_step == 0 || $v_all_sarok->grade_step == 1 || $v_all_sarok->grade_step == '' ) { echo 'N/A'; } else {  echo $v_all_sarok->grade_step -1; }  ?></td>
											<td><?php echo $v_all_sarok->basic_salary;?></td>
										</tr>
										<?php } ?>
										
										
									</tbody>
								</table>
							</div>
						</div>
						<!-- /.tab-pane TIMELINE--> 
						
						<!-- tab-pane TIMELINE -->
						<div class="tab-pane" id="tab_LOAN">
							<div class="box-header with-border">
								<h3 class="box-title">My :) Loan </h3> 
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Sl</th>
											<th>Loan Id</th>
											<th>Application Date</th>
											<th>Loan Code</th>
											<th>Loan Product</th>
											<th>Disbursement Date</th>
											<th>Loan Amount</th>
											<th>First repayment date</th>
											<th>View</th>
										</tr>
									</thead>
									<tbody>
											<?php $l=1; if(!empty($loanData[0])) { foreach($loanData as $loan) {  ?>
										<tr>
											<td><?php echo $l; ?></td>
											<td><?php echo $loan->loan_id; ?></td>
											<td><?php echo date('d-m-Y',strtotime($loan->application_date)); ?></td>
											<td><?php echo $loan->loan_code; ?></td>
											<td><?php echo $loan->loan_product_name; ?></td>
											<td><?php echo date('d-m-Y',strtotime($loan->disbursement_date)); ?></td>
											<td><?php echo $loan->loan_amount; ?></td>
											<td><?php echo date('d-m-Y',strtotime($loan->first_repayment_date)); ?></td>
											<td>
											<button type="button" class="btn btn-primary btn-xs button view_button"
													data-toggle="modal" data-target="#view_loan_details"
													data-id="{{ $loan->loan_id }}"
													data-loan_code="{{ $loan->loan_code }}"
													data-loan_product_name="{{ $loan->loan_product_name }}"
													data-first_repayment_date="{{ date("M-Y", strtotime($loan->first_repayment_date)) }}"
													data-emp_id="{{ $loan->emp_id }}"
													data-emp_name="{{ $loan->emp_name_eng }}">
												<i class="fa fa-search"></i>
											</button>
											</td>
										</tr>
										<?php $l++; } } else { ?>
										<tr>
											<td align="center" colspan="9">There is no loan informarion</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- /.tab-pane LOAN-->
						
						
						
						<!-- tab-pane PUNISHMENT -->
						<div class="tab-pane" id="tab_PUNISHMENT">
							<div class="box-header with-border">
								<h3 class="box-title">My :) PUNISHMENT </h3> 
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>#</th>
											<th>Transection</th>
											<th>Sarok No</th>
											<th>Letter Date</th>
											<th>Punishment Details</th>
											<th>Fine Amount</th>
											<th>Punishment By</th>
										</tr>
									</thead>

									<tbody>
									<?php if($all_punishment) { $pun = 1; foreach($all_punishment as $punishment) { ?>
										<tr>
											<td><?php echo $pun++; ?></td>
											<td><span class="label label-warning"><?php echo $punishment->crime_subject; ?></span></td>
											<td><?php echo $punishment->sarok_no; ?></td>
											<td><?php echo $punishment->letter_date; ?></td>
											<td><?php echo $punishment->punishment_details; ?></td>
											<td><?php if($punishment->fine_amount == '') { echo 0; } else { echo $punishment->fine_amount; } ?></td>
											<td><?php echo $punishment->punishment_by; ?></td>
										</tr>
									<?php } } else { ?>
										<tr>
											<td align="center">No Records.</td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- /.tab-pane PUNISHMENT-->
						
						<!-- tab-pane SECURITY MONEY -->
						<div class="tab-pane" id="tab_MONEY">
							<div class="box-header with-border">
								<h3 class="box-title">My :) SECURITY MONEY</h3> 
							</div>
							<div class="table-responsive">
								
								<table class="table table-bordered">
									<tr>
										<td>Deposit Amount</td>
										<td>Interest Amount</td>
										<td>Total Amount</td>
									</tr>
									<?php if($staff_security) { ?>
									<tr>
										<td><?php echo $my_diposit = $staff_security->diposit_amount;   ?></td>
										<td><?php echo $interest = 0; ?></td>
										<td><?php echo $total_amount = $my_diposit + $interest; ?></td>
									</tr>
									<?php } else { ?>
									<tr>
										<td colspan="3" align="center">No Record Found</td>
									</tr>
									<?php }  ?>
								</table>
								
							</div>
						</div>
						<!-- /.tab-pane SECURITY MONEY-->
						
						
										
						
						
						
						
						
						<!-- tab-pane PF -->
						<div class="tab-pane" id="tab_pf">
							<div class="box-header with-border">
								<h3 class="box-title">My :) P.F Balance</h3> 
							</div>
							<div class="table-responsive">
							
							
								<table border="0" cellspacing="0" width="80%" align="center">
									<tbody>
										<tr>
											<td rowspan="4" align="right"><img style="width: 50px; height: 50px;" src="{{ asset('public/org_logo/cdip.png') }}"></td>
											<td align="center"><b><font size="5">
												Centre for Development Innovation and Practices (CDIP)</font></b>
											</td>
										</tr>
										<tr>
											<td align="center">
											<font size="4"><b> সেন্টার ফর ডেভেলপমেন্ট ইনোভেশন এন্ড প্র্যাকটিসেস  (  সিদীপ ) </font></b>
											</td>
										</tr>
										<tr>
											<td align="center">
												<b><font size="2"> সিদীপ ভবন, হাউজ # ১৭, রোড # ১৩, পিসিকালচার হাউজিং সোসাইটি , শেখেরটেক, আদাবর, ঢাকা।</font></b>
											</td>
										</tr>
										<tr>
											<td align="center">
												<b><font size="2">Web: www.cdipbd.org, Phone: 02-48118633 , 02-48118634</font></b>
											</td>
										</tr>
									</tbody>
								</table>
								
								<hr>
								
								
								
								
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<td rowspan="2" style="text-align: center;">Emp ID</td>
											<td rowspan="2" style="text-align: center;">Emp Name</td>
											<td rowspan="2" style="text-align: center;">SL No.</td>
											<td rowspan="2" style="text-align: center;">Date</td>
											<td colspan="2" style="text-align: center;">
												Opening Balance
											</td>
											<td colspan="2" style="text-align: center;">
												Collection
											</td>
											<td colspan="2" style="text-align: center;">
												Interest
											</td>
											<td rowspan="2" style="text-align: center;">
												Total
											</td>
											<td colspan="2" style="text-align: center;">
												Final Payment
											</td>
											<td colspan="2" style="text-align: center;">
												Closing Balance
											</td>
										</tr>
										<tr>
											<td style="text-align: center;">Staff</td>
											<td style="text-align: center;">Org</td>
											<td style="text-align: center;">Staff</td>
											<td style="text-align: center;">Org</td>
											<td style="text-align: center;">Staff</td>
											<td style="text-align: center;">Org</td>
											<td style="text-align: center;">Staff</td>
											<td style="text-align: center;">Org</td>
											<td style="text-align: center;">Staff</td>
											<td style="text-align: center;">Org</td>
										</tr>

									</thead>
									<tbody>
										
										<?php if($pf_info) { ?>
										<tr>
											<td>{{$emp_cv_basic->emp_id}}</td>
											<td>{{$emp_cv_basic->emp_name_eng}}</td>
											<td>{{ $i++ }}</td>
											<td>{{ date("d-m-Y", strtotime($pf_info->for_month)) }}</td>
											<td class="text-right">{{ $pf_info->opening_balance_staff }}</td>
											<td class="text-right">{{ $pf_info->opening_balance_org }}</td>
											<td class="text-right">{{ $pf_info->self_fund }}</td>
											<td class="text-right">{{ $pf_info->org_fund }}</td>
											<td class="text-right">{{ $pf_info->interest_amount_stuff }}</td>
											<td class="text-right">{{ $pf_info->interest_amount_org }}</td>
											<td class="text-right">{{ $pf_info->self_fund + $pf_info->org_fund }}</td>
											<td class="text-right">{{ $pf_info->final_payment_staff }}</td>
											<td class="text-right">{{ $pf_info->final_payment_org }}</td>
											<td class="text-right">{{ $pf_info->closing_balance_staff }}</td>
											<td class="text-right">{{ $pf_info->closing_balance_org }}</td>
										</tr>
										
										<?php } else { ?>
										<td colspan="15" align="center">No PF Information</td>
										<?php } ?>
									</tbody>
								</table>
								
							</div>
						</div>
						<!-- /.tab-pane PF-->
						
						
						
						
						
						
						
						
						
						<!-- tab-pane LEAVE -->
						<div class="tab-pane" id="tab_LEAVE">
							<div class="post">
								<div class="user-block">
								
									<div class="col-sm-6">
										<form class="form-horizontal" role="form" method="POST" id="leave_form"> 
											{{ csrf_field() }}
											<input type="hidden" name="emp_id" value="<?php echo $emp_id;?>">
											<input type="hidden" name="id" id="id" value="">
											<input type="hidden" name="reported_to" id="reported_to" value="<?php echo $report_to_new; ?>">
											
											<div class="form-group">
												<label for="leave_type" class="col-sm-4 control-label">Leave Source</label>
												<div class="col-sm-8">
												   <select class="form-control" name="leave_type" id="leave_type">
														<option value="1">Earn</option>
														<option value="2">Meternity</option>
														<option value="3">Special</option>
														<option value="4">Quarantine</option>
												   </select>
												</div>
											</div>
											
											<div class="form-group">
												<label for="leave_adjust" class="col-sm-4 control-label">Leave Adjustment</label>
												<div class="col-sm-8">
												   <select class="form-control" name="leave_adjust" id="leave_adjust">
														<option value="1">Current</option>
														<option value="2">Cumulative</option>
														<option value="3">FY Cummulative</option>
												   </select>
												</div>
											</div>
											
											<div class="form-group">
												<label for="application_date" class="col-sm-4 control-label">Application Date</label>
												<div class="col-sm-8">
												   <input type="date" class="form-control" id="application_date" name="application_date" value="<?php echo date('Y-m-d')?>">
												</div>
											</div>
											
											<div class="form-group">
												<label for="leave_from" class="col-sm-4 control-label">Date From</label>
												<div class="col-sm-8">
												   <input type="date" class="form-control" id="leave_from" name="leave_from" value="<?php echo date('Y-m-d')?>">
												</div>
											</div>
											
											<div class="form-group">
												<label for="leave_to" class="col-sm-4 control-label">Date To</label>
												<div class="col-sm-8">
												   <input type="date" class="form-control" id="leave_to" name="leave_to" value="<?php echo date('Y-m-d')?>">
												</div>
											</div>
											<div class="form-group">
												<label for="pay_type" class="col-sm-4 control-label">Pay Type of Leave</label>
												<div class="col-sm-8">
												   <select class="form-control" name="pay_type" id="pay_type">
														<option value="1">With Pay</option>
														<option value="2">Without Pay</option>
												   </select>
												</div>
											</div>
											<div class="form-group">
												<label for="remarks" class="col-sm-4 control-label">Remarks</label>
												<div class="col-sm-8">
												   <input type="text" class="form-control" id="remarks" name="remarks"  placeholder="Cause of Leave">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-offset-2 col-sm-10">
													<button type="button" class="btn btn-danger" id="btnSave" onclick="save_leave_application();">Submit for Approve</button>
												</div>
											</div>
										</form>
									</div>
									
									<div class="col-sm-6">
										<a href="#" class="btn btn-success btn-block"><b>Earn Leave :  <?php echo $leave_balance->current_open_balance ;?></b></a>
										<a href="#" class="btn btn-warning btn-block"><b>Enjoyed : <?php echo $leave_balance->no_of_days ;?></b></a>
										<a href="#" class="btn btn-danger btn-block"><b>Balance : <?php echo $leave_balance->current_close_balance ;?></b></a>
										<a class="btn btn-info btn-block" target="_BLANCK" href="leave_report_profile/<?php echo $emp_id; ?>">Detail...</a>
										<table class="table table-bordered" id="list_leave">
											<tr>
												<th>Sl</th>
												<th>Date From</th>
												<th>Date To</th>
												<th>Duration</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
											<?php $l= 1; if($leave_infos) { foreach($leave_infos as $leave_info) { ?>
											<tr>
												<td><?php echo $l++; ?></td>
												<td><?php echo date('d-m-Y',strtotime($leave_info->leave_from)); ?></td>
												<td><?php echo date('d-m-Y',strtotime($leave_info->leave_to)); ?></td>
												<td>
												<?php 
													$dStart = new DateTime($leave_info->leave_from);
													$dEnd  = new DateTime($leave_info->leave_to);
													$dDiff = $dStart->diff($dEnd);
													echo $dDiff->format('%r%a')+1;
												?>
												Day.
												</td>
												<?php if($leave_info->is_approve == 0 ) { ?> 
												<td>Pending..</td>
												<td>
													<button onclick="get_leave_info('<?php echo $leave_info->id; ?>')" class="btn btn-primary btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></button>
													<button onclick="delete_application('<?php echo $leave_info->id; ?>')" class="btn btn-danger btn-xs"><i class="fa fa-times" aria-hidden="true"></i></button>
												</td>
												<?php } else { ?>
												<td>Approved..</td>
												<td>--</td>
												<?php } ?>
											</tr>
											<?php } } else { ?>
											<tr>
												<td colspan="6" align="center">No Record's Found </td>
											</tr>
											<?php } ?>
										</table>
										
									</div>
									
									<br>
								
									
								
								</div>
							</div>
						</div>
						
						
						<!-- /.tab-pane LEAVE-->
						
						
						<!-- tab-pane LEAVE -->
						<div class="tab-pane" id="tab_EMI">
							<div class="box-header with-border">
								<h3 class="box-title"> EMI Loan Calculator </h3> 
							</div>
							<div class="calc">
								<div class="table-responsive">
									<form>
										<table class="table table-bordered">
											<tbody>
												<tr>
													<td width="20%">Loan Amount: </td>
													<td><input type="number" id="amount" name="amount" placeholder="Loan Amount"></td>
												</tr>
												<tr>
													<td>Period in Months: </td>
													<td><input type="number" id="months" placeholder="Months"></td>
												</tr>
												<tr>
													<td>Period in Years: </td>
													<td><input type="number" id="years" placeholder="Years"></td>
												</tr>
												<tr>
													<td>Interest Rate: </td>
													<td><input type="number" id="interest" placeholder="Interest Rate"></td>
												</tr>											
												<tr>
													<td>EMI: </td>
													<td><input type="text" id="output" readonly></td>
												</tr>
												<tr>
													<td></td>
													<td>
														<button type="button" class="btn btn-primary" onclick="myFunction()"><i class="fa fa-calculator"></i> Calculate</button>
														<button type="reset" class="btn btn-default">Reset</button>
													</td>
												</tr>
											</tbody>	
										</table>
									</form>
								</div>
							</div>
						</div>
						<!-- /.tab-pane LEAVE-->
				</div>
			</div>
		
		</div>	
		


    </section>
    <!-- /.content -->
	
	
	
	
	<style>
        .modal-dialog {
            width: 80%;
            /*height: 100%;*/
            margin: 0 auto;
            padding: 1%;
        }

        .modal-content {
            height: auto;
            min-height: 100%;
            border-radius: 0;
        }
    </style>

    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="view_loan_details"
         class="modal fade bd-example-modal-md">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    
					<div id="printme">
                        <div class="text-center">
                            <table border="0" cellspacing="0" width="100%">
                                <tbody>
									<tr>
										<td align="center"><b><font size="4"> <img style="width: 40px" src="{{ asset('public/org_logo/cdip.png') }}">
											Centre for Development Innovation and Practices (CDIP)</font></b>
										</td>
									</tr>
									<tr>
										<td align="center">
											<b><font size="2"> সিদীপ ভবন, হাউজ # ১৭, রোড # ১৩, পিসিকালচার হাউজিং সোসাইটি , শেখেরটেক, আদাবর, ঢাকা।</font></b>
										</td>
									</tr>
									<tr>
										<td align="center">
											<b><font size="2">Web: www.cdipbd.org, Phone: 02-9141891 & 9141893</font></b>
										</td>
									</tr>
                                </tbody>
                            </table>
                        </div>
                        <table style="margin-bottom: 10px" border="0" cellspacing="0" width="100%">
                            <tbody>
                            <tr>
                                <td align="left"><b><font size="4">Name: <span id="loan_schedule_for"></span></font></b>
                                </td>
                                <td align="center">
                                    <b><font size="4"><span id="for_loan_code"></span></font></b>
                                </td>
                            </tr>
                            <tr>
                                <td align="left">
                                    <b><font size="2"><span id="first_repayment_date"></span></font></b>
                                </td>
                                <td align="center">
                                    <b><font size="2">Print Date: {{ date("d-m-Y") }}</font></b>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="modal-body">
                            <div id="view_loan_details_list" class="row">
                                <div id="loan_table" class="box-body table-responsive">

                                </div>

                            </div>
                            <div id="note" style="display: none !important; position: fixed; bottom: 0;">
                                <small style="float:left">** (Report Generated From : CDIP Payroll)</small>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
	</div>
	
	
	
	
	
	
	
	
	<script>
	
		function get_pay_slip()
		{
			var salary_month = document.getElementById("salary_month").value;
			const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
			let current_datetime = new Date(salary_month)
			let formatted_date =  months[current_datetime.getMonth()] + "-" + current_datetime.getFullYear()
			var url = "{{ URL::to('/get-pay-slip') }}";
			$.ajax({
				type: "GET",
				url: url + "/" + salary_month,
				success: function (res) {
					document.getElementById("formatted_date").innerHTML = formatted_date;
					$("#dynamic_content").html(res); 
				}
			})
		}
		
		
	
		$(document).on("click", '.view_button', function (e) {

			var id = $(this).data('id');
			var for_loan_code = $(this).data('loan_code');
			var loan_schedule_for = $(this).data('emp_name');
			var emp_id = $(this).data('emp_id');
			var loan_product_name = $(this).data('loan_product_name');
			var first_repayment_date = $(this).data('first_repayment_date');
			var url = "{{ URL::to('/get_loan_details_by_id') }}";
			$.ajax({
				type: "GET",
//                data: {id: id},
				url: url + "/" + id,
				success: function (res) {
//                    console.log(res);
					$("#loan_table").html(res);
					$("#loan_schedule_for").text(loan_schedule_for + " (" + emp_id + ")");
					$("#for_loan_code").text('Loan code: ' + loan_product_name + ' (' + for_loan_code + ')');
					$("#first_repayment_date").text('Repayment Date: ' + first_repayment_date);
				}
			})

		});
    
        function myFunction() {
            var loan = $('#amount').val(),
                month = $('#months').val(),
                int = $('#interest').val(),
                years = $('#years').val(),
                //down = $('#down').val(),
                down = 0,
                amount = parseInt(loan),
                months = parseInt(month),
                down = parseInt(down),
                annInterest = parseFloat(int),
                monInt = annInterest / 1200,
                calculation = ((monInt + (monInt / (Math.pow((1 + monInt), months) -1))) * (amount - (down || 0))).toFixed(2);
        
            document.getElementById("output").value = calculation;
        }


    $(function(){
        var month = $(this).val(),
        doneTypingInterval = 500,
        months = parseInt(month),
        typingTimer;

		$('#months').keyup(function(){
			month = $(this).val();
			months = parseInt(month);
		
			clearTimeout(typingTimer);
			if (month) {
				typingTimer = setTimeout(doneTyping, doneTypingInterval);
			}
		});

		function doneTyping () {
			$('#years').val(months/12);  
		}
    })

    $(function(){
        var month = $(this).val(),
        doneTypingInterval = 500,
        months = parseInt(month),
        typingTimer;
		$('#months').keyup(function(){
			month = $(this).val();
			months = parseInt(month);
			clearTimeout(typingTimer);
			if (month) {
				typingTimer = setTimeout(doneTyping, doneTypingInterval);
			}
		});

		function doneTyping () {
			$('#years').val(months/12);  
		}
    })

    $(function(){
        var year = $(this).val(),
        doneTypingInterval = 500,
        years = parseInt(year),
        typingTimer;

		$('#years').keyup(function(){
			year = $(this).val();
			myears = parseInt(year);
		
			clearTimeout(typingTimer);
			if (year) {
				typingTimer = setTimeout(doneTyping, doneTypingInterval);
			}
		});

		function doneTyping () {
			$('#months').val(year * 12);  
		}
    })
	
	
	function change_class(val)
	{
		document.getElementById('cv').className = "info-box-icon bg-aqua";
		document.getElementById('pay').className = "info-box-icon bg-aqua";
		document.getElementById('document').className = "info-box-icon bg-aqua";
		document.getElementById('leave').className = "info-box-icon bg-aqua";
		document.getElementById('money').className = "info-box-icon bg-aqua";
		document.getElementById('pf').className = "info-box-icon bg-aqua";
		document.getElementById('loan').className = "info-box-icon bg-aqua";
		document.getElementById('timeline').className = "info-box-icon bg-aqua";
		document.getElementById('noc').className = "info-box-icon bg-aqua";
		document.getElementById('application').className = "info-box-icon bg-aqua";
		document.getElementById('emi').className = "info-box-icon bg-aqua";
		document.getElementById('fine').className = "info-box-icon bg-aqua";
		
		
		//alert(val);
		
		document.getElementById(val).className = "info-box-icon bg-red";
	}
	
	function printDiv(divID) {
		//Get the HTML of div
		var divElements = document.getElementById(divID).innerHTML;
		//Get the HTML of whole page
		var oldPage = document.body.innerHTML;
		//Reset the page's HTML with div's HTML only
		document.body.innerHTML = 
		  "<html><head><title></title></head><body>" + 
		  divElements + "</body>";

		//Print Page
		window.print();

		//Restore orignal HTML
		document.body.innerHTML = oldPage;
	}

    </script>
	
	
@endsection	