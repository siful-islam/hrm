@extends('admin.admin_master')
@section('main_content')  
 <link rel="stylesheet" href="{{asset('public/admin_asset/bower_components/select2/dist/css/select2.min.css')}}">
<style>
		.select2-container--default .select2-selection--multiple .select2-selection__choice {
			background-color: #3c8dbc;
			border-color: #367fa9;
			padding: 1px 10px;
			color: #fff;
}
	.text-align{
		text-align: right; 
	}
	.middle{ 
       padding: 0px; 
	   height: 25px;
       line-height:20px !important;  
	}
	.amount{ 
      text-align: right; 
	}
</style> 
<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Movement<small>Register</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Movement</a></li>
			<li class="active">Register</li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content">
 
		<div class="box box-info"> 
			<div class="box-body">  
				<h4>Visit Information</h4>
						
						<input type="hidden" name="visit_type"   id="visit_type"  class="form-control" value="{{$visit_type}}" > 
						<input type="hidden"    id="purpose"  class="form-control" value="{{$purpose}}" > 
						<div class="row"> 
							<div class="col-md-10 col-md-offset-2"> 
							
							<table class="table" > 
								<tbody>
									<tr> 
										<td width="20%">Departure Date</td> 
										<td width="80%" >: <?php  echo date("d-m-Y",strtotime($travel_date)).' '.$leave_time; ?>
										 
										</td> 
									</tr>
									<tr> 
										<td>Return Date</td> 
										<td>: <?php  echo date("d-m-Y",strtotime($arrival_date)).' '.$return_time; ?></td>  
									</tr>
									<tr> 
										<td>Durations (Days)</td> 
										<td>: {{$tot_day}}</td> 
									</tr>
									<tr> 
										<td>Destination</td> 
										<td>: <?php if($visit_type == 1)
												{ 
												$i = 1;
												foreach($branch_list as $branch){ 
													if(in_array($branch->br_code, $destination_code))
														{  
															if($i == 1){
																echo $branch->branch_name; 
															}else{
																echo ", ".$branch->branch_name; 
															}
															$i++;
														}
													}  
												} 
												else if($visit_type == 2)
												{  
													echo $destination_code; 
												} ?></td> 
									</tr> 
									<tr> 
										<td>Purpose</td>  
										<td >: {{$purpose}}</td> 
									</tr>
									
								</tbody>
							</table>
							 
								</div>
							</div>  
					</div>  
			</div> 
			<div class="box box-info">	
				<div style="border:1px solid black;padding-top">
					<div class="box-body" >  
							<h4>Travel Allowance - Create</h4>
							<div class="row"> 
								<form class="form-horizontal" id="ajax_insert" action="" role="form" method="POST" enctype="multipart/form-data">
									{{csrf_field()}}   
									<input type="hidden" name="move_id"   id="move_id"  class="form-control" value="{{$move_id}}" > 
									<input type="hidden" name="travel_id"   id="travel_id"  class="form-control" value="" > 
								<div class="col-md-12 table-responsive" >
									<table class="table table-bordered">
										<thead>
											<tr> 
												<th style="width:20%;">Visit Date</th> 
												<th style="width:15%;">Visit From</th> 
												<th style="width:20%;">Visit To</th> 
												<th style="width:20%;">Vehicle</th> 
												<th style="width:15%;text-align:center;">Amount</th>
												<th style="width:10%;text-align:center;">Action</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td >
													<input type="date" name="travel_date" onchange="select_travel_amt()"  id="travel_date" autocomplete="off"  class="form-control middle" value="{{$travel_date}}" min="{{$travel_date}}" required  max="{{$arrival_date}}" >
												
												</td> 
												<td > 
													
													<?php if($visit_type == 1){ ?>
													<select  name="source_br_code" id="source_br_code" onchange="select_travel_amt()" required class="form-control middle"> 
														<option value="">--Select--</option>
														@foreach($branch_list as $branch)
															<option value="{{$branch->br_code}}">{{$branch->branch_name}}</option> 
														@endforeach
														</select> 
													<?php }else if($visit_type == 2){?> 
														<input type="text" name="source_br_code"  id="source_br_code"  class="form-control middle" value="Head office"> 
													<?php } ?>
													
												</td> 
												<td> 
													<?php if($visit_type == 1){ ?>
													<select  name="dest_br_code" required onchange="select_travel_amt()" id="dest_br_code" class="form-control middle"> 
														
														
														<option value="">--Select--</option>
														 
														@foreach($branch_list as $branch)
															<option value="{{$branch->br_code}}">{{$branch->branch_name}}</option> 
														@endforeach  
													</select> 
													<?php }else{ ?>
													<input type="text" name="dest_br_code"  id="dest_br_code"  class="form-control middle" value="{{$destination_code}}"> 
													<?php }  ?>
												</td> 
												<td>
													<input type="text" name="medium_trav"  id="medium_trav"  class="form-control middle" value="" required >
												</td>
												<td>
													<input type="number" name="travel_allowance"  id="travel_allowance" class="form-control middle amount" value="" onclick="this.select();" required>
												</td>
												<td align="center">
												 <button type="submit" id="btn_text_value" style="background-color:#00A8B3" class="btn btn-primary btn-xs"> + Add to Grid</button>
												</td> 
											</tr> 
										</tbody>
									</table>
									<br>
									<table class="table table-bordered table-striped" id="reload_tbl">
										 <thead style="background-color:#598787; color:white;">
											<tr> 
												<th style="width:20%;">Visit Date</th> 
												<th style="width:15%;">Visit From</th> 
												<th style="width:20%;">Visit To</th> 
												<th style="width:20%;">Vehicle</th> 
												<th style="width:15%;text-align:center;">Amount</th>
												<th style="width:10%;text-align:center;">Action</th>
											</tr>
										</thead>
										 <?php    
											$tot_travel_allowance = 0;
											$grand_tot_amnt = 0;
										 //print_r($travel_details);
										 if($travel_details) { foreach($travel_details as $v_travel_details) { 
											
											$tot_travel_allowance +=  $v_travel_details->travel_allowance;
										 
										 ?>
											<tr>
												<td width="20%" style="padding:4px;"><?php echo date("d-m-Y",strtotime($v_travel_details->travel_date)); ?></td>
												<td width="15%"  ><?php if($visit_type == 1){  echo $v_travel_details->source_branch_name; }else{ echo $v_travel_details->source_br_code;} ?></td>
												<td width="20%"  ><?php if($visit_type == 1){  echo $v_travel_details->destination_branch_name; }else{ echo $v_travel_details->dest_br_code;}   ?></td>
												<td width="20%"  ><?php echo $v_travel_details->medium_trav; ?></td>
												<td width="15%" style="text-align:right;"><?php echo $v_travel_details->travel_allowance; ?></td>
												<td width="10%"  style="text-align:center;">
													<button type="button" class="btn btn-xs btn-info"  onclick="edit('<?php echo $v_travel_details->id; ?>');"><i class="fa fa-pencil"></i></button>&nbsp; 
													<button type="button" class="btn btn-xs btn-danger"  onclick="delete_row('<?php echo $v_travel_details->id; ?>');"><i class="fa fa-times"></i></button>
												</td>
											</tr>
										 
										 
										 <?php } } ?>
										<tbody>
											<tr>
												<th colspan="4" style="text-align:right;width:75%;">Travel Allowance Sub-Total</th>
												<td style="text-align:right;width:15%;"><?php echo $tot_travel_allowance; $grand_tot_amnt += $tot_travel_allowance;?></td>
												<td style="text-align:right;"></td>
											</tr>
										</tbody>
										
									</table> 
								</div>	
								</form> 
							</div> 
						</div> 
						<div class="box-body">  	
							<h4>Food Allowance - Create</h4>
							<div class="row"> 
								<form class="form-horizontal" id="ajax_insert_bill" action="" role="form" method="POST" enctype="multipart/form-data">
									{{csrf_field()}}  
									<input type="hidden" name="grade_code"   id="grade_code"  class="form-control" value="{{$grade_code}}" >
									<input type="hidden" name="move_id_bill"   id="move_id_bill"  class="form-control" value="{{$move_id}}" > 
									<input type="hidden" name="bill_id"   id="bill_id"  class="form-control" value="" > 
									<div class="col-md-12 table-responsive">
										<table class="table table-bordered"> 
											<thead>
												<tr> 
													<th style="width:20%;">Bill for( Date )</th> 
													<th style="width:15%;text-align:center;">Breakfast</th> 
													<th style="width:20%;text-align:center;">Lunch</th> 
													<th style="width:20%;text-align:center;">Dinner</th>
													<th style="width:15%;text-align:center;">Amount</th>
													<th style="width:10%;text-align:center;" >Action</th>
												</tr>
											</thead>
											<tbody>
											<tr>
												<td>
													<input type="date" name="bill_date" onchange="get_grade_wise_allowance()"  id="bill_date" autocomplete="off"  class="form-control middle" value="{{$travel_date}}"  min="{{$travel_date}}" max="{{$arrival_date}}" required> 
												</td> 
												<td>
													<input type="number" name="breakfast" id="breakfast" onkeyup="calculate_bill_allowance()" onclick="this.select();" autocomplete="off"  class="form-control middle amount" value="{{$breakfast}}" required> 
												</td> 
												<td>
													<input type="number" name="lunch"  id="lunch" onkeyup="calculate_bill_allowance()" autocomplete="off" onclick="this.select();" class="form-control middle amount" value="{{$lunch}}" required> 
												</td> 
												<td>
													<input type="number" name="dinner"  onkeyup="calculate_bill_allowance()" id="dinner" autocomplete="off" onclick="this.select();" class="form-control middle amount" value="{{$dinner}}" required> 
												</td> 
												<td>
													<input type="number" name="tot_amt" readonly id="tot_amt" autocomplete="off" align="right" class="form-control middle amount" onclick="this.select();" value="{{$tot_amt}}" required> 
												</td>  
												<td align="center">
												 <button type="submit" id="btn_text_value_bill" style="background-color:#00A8B3" class="btn btn-primary btn-xs"> + Add to Grid</button>
												</td>
											</tr> 
										</tbody> 	 
									</table>
									</form>		
										
										<br>
										<br>
										<table id="reload_tbl_bill" class="table table-bordered table-striped">	
											<thead style="background-color:#598787; color:white;">
												<tr> 
													<th style="width:20%;">Bill for ( Date )</th> 
													<th style="width:15%;text-align:center;">Breakfast</th> 
													<th style="width:20%;text-align:center;">Lunch</th> 
													<th style="width:20%;text-align:center;">Dinner</th>
													<th style="width:15%;text-align:center;">Amount</th>
													<th style="width:10%;text-align:center;" >Action</th>
												</tr>
											</thead>
											<tbody>
												 <?php    
												$tot_tot_amt = 0;
											 //print_r($travel_details);
											 if($bill_details) { foreach($bill_details as $v_bill_details) { 
												
												$tot_tot_amt +=  $v_bill_details->tot_amt;
											 
											 ?>
												<tr>
													<td width="20%" style="padding:4px;"><?php echo date("d-m-Y",strtotime($v_bill_details->bill_date)); ?></td>
													<td width="15%" style="text-align:right;"><?php echo $v_bill_details->breakfast; ?></td>
													<td width="20%" style="text-align:right;"><?php echo $v_bill_details->lunch; ?></td>
													<td width="20%" style="text-align:right;"><?php echo $v_bill_details->dinner; ?></td>
													<td width="15%" style="text-align:right;"><?php echo $v_bill_details->tot_amt; ?></td>
													<td width="10%" style="text-align:center;">
														<button type="button" class="btn btn-xs btn-info" onclick="edit_bill('<?php echo $v_bill_details->id; ?>');"><i class="fa fa-pencil"></i></button>&nbsp;
														<button type="button" class="btn btn-xs btn-danger"  onclick="delete_row_bill('<?php echo $v_bill_details->id; ?>');"><i class="fa fa-times"></i></button>
													</td>
												</tr>
											 
											 
											 <?php } } ?>
											</tbody>
											<tbody>
												<tr>
													<th colspan="4" style="text-align:right;width:75%;">Food Allowance Sub Total</th>
													<td style="text-align:right;width:15%;"><?php echo $tot_tot_amt;$grand_tot_amnt += $tot_tot_amt;?> </td>
													 <td> </td>
												</tr> 
												<tr>
													<th colspan="6" style="text-align:right;width:75%; background-color:#E8E7E7"> &nbsp;</td>
												</tr>
												<tr>
													<th colspan="4" style="text-align:right;width:75%; color:blue;">Grand Total</th>
													<td style="text-align:right;width:15%;color:blue;"><b><?php echo $grand_tot_amnt;?></b> </td>
													 <td align="center">  
													 <button type="button" class="btn  btn-info" onclick="add_voucher(<?php echo $move_id.','.$visit_type?>);"> <i class="fa fa-money" aria-hidden="true"></i> Create Bill</button> </td>
												</tr> 
											</tbody>
										</table>  
									</div>
								
							</div> 
						</div>
					</div>  	  
			</div> 
			
			<!-- Start Voucher modal -->
	<div class="modal fade" method="post" id="modal_visit_form"  role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<h4 class="modal-title"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
				</div>	 
					<div class="box-body"> 
						<div class="row"> 
							<div id="printme"  class="box box-danger" style="width:90%;margin:auto;">
							<div class="box-header with-border">			
								<center style="text-align:justfy;text-justify: inter-word;" id="with_header" > 
								<span class="box-title" style="text-align:left;" >
								<img src="{{asset(Session::get('org_logo'))}}" style="float:left;margin-top:0%;" width="50" >
								</span>
								
									<span class="box-title" >
										<span style="font-size:18px;"> সেন্টার ফর ডেভেলপমেন্ট     ইনোভেশন এন্ড প্র্যাকটিসেস ( সিদীপ )  <br></span>
										<hr style="width:75%;">
									</span>  
								</center>
								<center>
									<h4 ><u> যাতায়াত/ ভ্রমণ ও দৈনিক ভাতার বিল </u></h4>
								</center>
								
							</div> 
								
								 
							<div class="col-md-12 table-responsive">
									 <table width="100%">
										<thead>
											<tr> 
												<th style="text-align:left;width:20%;">Name</th> 
												<td  style="text-align:left;width:30%;"><?php echo $emp_name;?></td>  
												<th  style="text-align:right;width:20%;">Bill Date</th>  
												<td  style="text-align:right;width:30%;"><?php echo date("d-m-Y");?></td>  
											</tr>
											<tr> 
												<th  style="text-align:left;width:20%;">Designation </th>  
												<td  style="text-align:left;width:30%;"><?php echo $designation_name;?></td>  
												<th  style="text-align:right;width:20%;">Branch </th> 
												<td  style="text-align:right;width:30%;"><?php echo $branch_name;?></td> 
												
											</tr>
											<tr> 
												<th  style="text-align:left;width:20%;">Purpose </th>  
												<td  style="text-align:left;width:30%;"><?php echo $purpose;?></td>  
											</tr>
										</thead> 
									</table> 
							</div>
                            <div class="col-md-12 table-responsive" >
                               
                                <table width="100%" border="1">
									<br>
									 
                                    <thead>
										<tr>
											<td colspan="5" align="left">Travel Allowance</td>
										</tr>
                                        <tr>
                                            <th style="width:20%;text-align:center;">তারিখ</th>
                                            <th style="width:20%;text-align:center;">হইতে</th>
                                            <th style="width:20%;text-align:center;">পর্যন্ত</th>
                                            <th style="width:20%;text-align:center;">যাতায়াতের মাধ্যম</th>
                                            <th style="width:20%;text-align:center;">টাকা</th>
                                        </tr>
                                    </thead>
                                    <tbody id="add_table">

                                    </tbody>
                                
                                    <thead>
										<tr>
											<td colspan="5" align="left">Food Allowance </td>
										</tr>
                                        <tr>
                                            <th style="text-align:center;">তারিখ</th>
                                            <th style="text-align:center;">সকাল</th>
                                            <th style="text-align:center;">দুপুর</th>
                                            <th style="text-align:center;">রাত</th>
                                            <th style="text-align:center;">টাকা</th>
                                        </tr>
                                    </thead>
                                    <tbody id="add_table_bill">

                                    </tbody>
									<thead>
                                        <tr>
                                            <th colspan="4" style="text-align:right;width:20%;">সর্বমোট</th>
                                            <td style="text-align:right;width:15%;padding-right: 2px;" id="grand_total_m"><b></b></td>

                                        </tr> 
										<tr>
                                            <th colspan="5"  style="text-align:left;width:10%">কথায়: <span id="tot_in_words"></span> </th> 
                                        </tr>
                                    </thead>
								 </table>
                                <br>
                            </div>  
								<div class="col-md-12 table-responsive">   
									<br>
									<table width="100%" align="center">
                                    <tbody>
                                        <tr>
                                            <td>.................................</td>
                                            <td>.................................</td>
                                            <td width="34%">.................................</td>
                                        </tr>
                                        <tr>
													<td> ভ্রমণকারীর স্বাক্ষর : </td>
													<td>
														যাচাইকারীর স্বাক্ষর : </td>.
													<td>
														অনুমোদনকারীর স্বাক্ষর :
													</td>
												</tr>
												<tr>
													<td>
														আইডি নং : </td>
													<td>
														আইডি নং : </td>
													<td>
														আইডি নং :
													</td>
												</tr>
											</tbody>
										</table> 
										<br>
								</div>
									 
							</div>		
								<br>
								<br>
								<div class="modal-footer"> 
									<span id="modal_save_btn">
									 <a class="btn btn-sm btn-success" title="Create bill"  href="{{URL::to('tra_bill_save/'.$move_id.'/'.$grade_code.'/'.$designation_code)}}">Save</a> &nbsp;&nbsp;
									</span>
									<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
								</div> 
									
						</div>
					</div>
			</div>
		</div>
	</div>
	<!-- End Voucher modal -->
			
	</section> 
	<script src="{{asset('public/admin_asset/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
function convertNumberToWords(amount) {
    var Words = ['', 'এক', 'দুই', 'তিন', 'চার', 'পাঁচ', 'ছয়', 'সাত', 'আট', 'নয়', 'দশ', 
                'এগার', 'বার', 'তের', 'চৌদ্দ', 'পনের', 'ষোল', 'সতের', 'আঠার', 'ঊনিশ', 'বিশ', 
                'একুশ', 'বাইশ', 'তেইশ', 'চব্বিশ', 'পঁচিশ', 'ছাব্বিশ', 'সাতাশ', 'আঠাশ', 'ঊনত্রিশ', 'ত্রিশ',
                'একত্রিশ', 'বত্রিশ', 'তেত্রিশ', 'চৌত্রিশ', 'পঁয়ত্রিশ', 'ছত্রিশ', 'সাঁইত্রিশ', 'আটত্রিশ', 'ঊনচল্লিশ', 'চল্লিশ', 
                'একচল্লিশ', 'বিয়াল্লিশ', 'তেতাল্লিশ', 'চুয়াল্লিশ', 'পঁয়তাল্লিশ', 'ছেচল্লিশ', 'সাতচল্লিশ', 'আটচল্লিশ', 'ঊনপঞ্চাশ', 'পঞ্চাশ',
                'একান্ন', 'বায়ান্ন', 'তিপ্পান্ন', 'চুয়ান্ন', 'পঞ্চান্ন', 'ছাপ্পান্ন', 'সাতান্ন', 'আটান্ন', 'ঊনষাট', 'ষাট',
                'একষট্টি', 'বাষট্টি', 'তেষট্টি', 'চৌষট্টি', 'পঁয়ষট্টি', 'ছেষট্টি', 'সাতষট্টি', 'আটষট্টি', 'ঊনসত্তর', 'সত্তর',
                'একাতর', 'বাহাত্তর', 'তিয়াত্তর', 'চুয়াত্তর', 'পঁচাত্তর', 'ছিয়াত্তর', 'সাতাত্তর', 'আটাত্তর', 'ঊনআশি', 'আশি',
                'একাশি', 'বিরাশি', 'তিরাশি', 'চুরাশি', 'পঁচাশি', 'ছিয়াশি', 'সাতাশি', 'আটাশি', 'ঊননব্বই', 'নব্বই', 
                'একানব্বই', 'বিরানব্বই', 'তিরানব্বই', 'চুরানব্বই', 'পঁচানব্বই', 'ছিয়ানব্বই', 'সাতানব্বই', 'আটানব্বই', 'নিরানব্বই'];

    amount = amount.toString();
    var atemp = amount.split(".");
    var before_word = "";
    var after_word = "";
    var before_number = atemp[0];
    if(before_number !== "0") {
      before_word = toWord(before_number, Words);
    } 
    if(atemp.length === 2) {
        var after_number = atemp[1];
        after_word = toWord(after_number, Words);
        if(before_word !== "") {
          before_word += ' দশমিক '+ after_word;
        } else {
            before_word += 'দশমিক '+after_word;
        }
    }
    return before_word;
}

function toWord(number, words) {
  var n_length = number.length;
    var words_string = "";

    if (n_length <= 9) {
        var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        var received_n_array = new Array();
        for (var i = 0; i < n_length; i++) {
            received_n_array[i] = number.substr(i, 1);
        }
        for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
            n_array[i] = received_n_array[j];
        }
        for (var i = 0, j = 1; i < 9; i++, j++) {
            if (i == 0 || i == 2 || i == 4 || i == 7) {
                if (n_array[i] == 1) {
                    n_array[j] = 10 + parseInt(n_array[j]);
                    n_array[i] = 0;
                } else if(n_array[i] == 2) {
                    n_array[j] = 20 + parseInt(n_array[j]);
                    n_array[i] = 0;
                } else if(n_array[i] == 3) {
                    n_array[j] = 30 + parseInt(n_array[j]);
                    n_array[i] = 0;
                } else if(n_array[i] == 4) {
                    n_array[j] = 40 + parseInt(n_array[j]);
                    n_array[i] = 0;
                } else if(n_array[i] == 5) {
                    n_array[j] = 50 + parseInt(n_array[j]);
                    n_array[i] = 0;
                } else if(n_array[i] == 6) {
                    n_array[j] = 60 + parseInt(n_array[j]);
                    n_array[i] = 0;
                } else if(n_array[i] == 7) {
                    n_array[j] = 70 + parseInt(n_array[j]);
                    n_array[i] = 0;
                } else if(n_array[i] == 8) {
                    n_array[j] = 80 + parseInt(n_array[j]);
                    n_array[i] = 0;
                } else if(n_array[i] == 9) {
                    n_array[j] = 90 + parseInt(n_array[j]);
                    n_array[i] = 0;
                }
            }
        }

        var value = "";
        for (var i = 0; i < 9; i++) {
            value = n_array[i];      
            if (value != 0) {
                words_string += words[value] + "";
            }
            if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                words_string += " কোটি ";
            }
            if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                words_string += " লাখ ";
            }
            if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                words_string += " হাজার ";
            } else if (i == 6 && value != 0) {
                words_string += "শত ";
            }
        }
    
        words_string = words_string.split("  ").join(" ");
        
    }
  return words_string;
}
function printDiv(divID) {
    var divToPrint = document.getElementById(divID);
    var htmlToPrint = '' +
        '<style type="text/css">'+'.with_pay_color {' +
        'background-color:none !important;color:black !important;' + 
        '}' + '.margin_left {' +
        'margin: auto;width:45%;padding-left:50px !important;' + 
        '}' +  'table {' +
        'border-collapse: collapse;' + 
        '}' + 'body {' +
        'width:95%;'+
        'text-align: justify;'+
        '}' +
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close(); 
   } 
function add_voucher(move_id,visit_type)
		{ 
			//alert(move_id);
			 $.ajax({
				type:'get',
				url : "{{URL::to('get_travel_bill_info')}}"+"/"+move_id+"/"+visit_type,
				dataType: "JSON",
				success:function(data){
					 
					 $('#modal_visit_form').modal('show');
					 console.log(data); 
					
					  var is_modal_save_show = 0;
					 var ta_sub_total = 0;
					 var da_sub_total = 0;
					   
						 
						   $("#add_table").empty();
						  var t_row = '';
						  var purpose = document.getElementById("purpose").value;  
						  
						  for(var x in data["data"]) {
							  //alert();
							  //console.log(data["data"][x]["id"]);
							  ta_sub_total += parseFloat(data["data"][x]["travel_allowance"]);
							  if(visit_type == 1){
								    t_row += "<tr><td style='text-align:center;'>"+data["data"][x]["travel_date"]+"</td><td style='text-align:center;'>"+data["data"][x]["source_branch_name"]+"</td><td style='text-align:center;'>"+data["data"][x]["destination_branch_name"]+"</td><td style='text-align:center;'>"+data["data"][x]["medium_trav"]+"</td><td style='text-align:right;padding-right: 2px;'>"+data["data"][x]["travel_allowance"]+"</td></tr>";
							  }else{
								    t_row += "<tr><td style='text-align:center;'>"+data["data"][x]["travel_date"]+"</td><td style='text-align:center;'>"+data["data"][x]["source_br_code"]+"</td><td style='text-align:center;'>"+data["data"][x]["dest_br_code"]+"</td><td style='text-align:center;'>"+data["data"][x]["medium_trav"]+"</td><td style='text-align:right;padding-right: 2px;'>"+data["data"][x]["travel_allowance"]+"</td></tr>";
							  }
							
							  //alert(t_row);
						   }
						   if(t_row == ''){
								t_row +=
								"<tr><th colspan='4' style='text-align:right;width:75%;padding-right: 2px;'>উপমোট</th><td style='text-align:right;width:15%;padding-right: 2px;'>" +
								0 + "</td></tr>";
							}else{
								t_row +=
								"<tr><th colspan='4' style='text-align:right;width:75%;padding-right: 2px;'>উপমোট</th><td style='text-align:right;width:15%;padding-right: 2px;'>" +
								ta_sub_total + "</td></tr>";
							}
						   
						   //alert(t_row);
						   $('#add_table').append(t_row);
						    
					      
					   
						   
						   $("#add_table_bill").empty();
						  var t_row = ''; 
						  for(var x in data["data_b"]) {
							  //alert();
							  //console.log(data["data"][x]["id"]);
							   da_sub_total += parseFloat(data["data_b"][x]["tot_amt"]);
							  t_row += "<tr><td style='text-align:center;'>"+data["data_b"][x]["bill_date"]+"</td><td style='text-align:center;'>"+data["data_b"][x]["breakfast"]+"</td><td style='text-align:center;'>"+data["data_b"][x]["lunch"]+"</td><td style='text-align:center;'>"+data["data_b"][x]["dinner"]+"</td><td style='text-align:right;padding-right: 2px;'>"+data["data_b"][x]["tot_amt"]+"</td></tr>";
							  //alert(t_row);
						   }
						   if(t_row == ''){
								 t_row +=
								"<tr><th colspan='4' style='text-align:right;width:75%;padding-right: 2px;'>উপমোট</th><td style='text-align:right;width:15%;padding-right: 2px;'>" +
								0 + "</td></tr>";
							}else{
								 t_row +=
								"<tr><th colspan='4' style='text-align:right;width:75%;padding-right: 2px;'>উপমোট</th><td style='text-align:right;width:15%;padding-right: 2px;'>" +
								da_sub_total + "</td></tr>";
							}
						   
						   $('#add_table_bill').append(t_row);
							
							 
							document.getElementById("grand_total_m").innerHTML = (ta_sub_total + da_sub_total);
							document.getElementById("tot_in_words").innerHTML = (convertNumberToWords(ta_sub_total + da_sub_total))+' টাকা মাত্র';
					    
					}	
				})   
		}


		function calculate_bill_allowance(){ 
			var breakfast_amt = parseFloat(document.getElementById("breakfast").value);
			var lunch_amt=parseFloat(document.getElementById("lunch").value);
			var dinner_amt=parseFloat(document.getElementById("dinner").value);
			if(isNaN(breakfast_amt)) {
				 breakfast_amt = 0;
			}if(isNaN(lunch_amt)) {
				 lunch_amt = 0;
			} if(isNaN(dinner_amt)) {
				 dinner_amt = 0;
			} 
			var tot_amt = ( breakfast_amt + lunch_amt + dinner_amt);
			$("#tot_amt").val(tot_amt); 
		}
$('.select2').select2(); 
function select_travel_amt(){
	
	var travel_date = $('#travel_date').val();
	var source_br_code = $('#source_br_code').val(); 
	var dest_br_code = $('#dest_br_code').val(); 
		$.ajax({
				type:'get',
				url : "{{URL::to('select_travel_amt')}}"+"/"+source_br_code+"/"+dest_br_code+"/"+travel_date,
				success:function(res){
					 
					 
					// alert(res);
					 $('#travel_allowance').val(res);
					 if(res == 0){ 
						 $('#travel_allowance').removeAttr("readonly");
					 }else{
						$('#travel_allowance').attr("readonly","readonly"); 
					 } 
					 check_destination();
			}
		})  
}
function get_grade_wise_allowance(){
	
	var bill_date = $('#bill_date').val();
	var grade_code = $('#grade_code').val();  
		$.ajax({
				type:'get',
				url : "{{URL::to('get_grade_wise_allowance')}}"+"/"+grade_code+"/"+bill_date,
				success:function(res){ 
					console.log(res);
					document.getElementById("breakfast").value = res.split(",")[0];
					document.getElementById("lunch").value = res.split(",")[1];
					document.getElementById("dinner").value = res.split(",")[2]; 
					document.getElementById("tot_amt").value = res.split(",")[3];  
			}
		})  
}
 function check_destination(){
	 var source_br_code = document.getElementById("source_br_code").value;
					var dest_br_code = document.getElementById("dest_br_code").value; 
					if(source_br_code != dest_br_code){
						$('#btn_text_value').attr("disabled",false); 
					}else{
						$('#btn_text_value').attr("disabled",true); 
						alert("Visit from and Visit to are same ?!!!");
					}
 }

		$('#ajax_insert').on('submit',function(e){ 
				e.preventDefault();
					$.ajaxSetup({
						header:$('meta[name="_token"]').attr('content')
					})  
					var visit_type = document.getElementById("visit_type").value; 
					//alert('ok');
					
						$.ajax({ 
							url : "{{URL::to('travel_insert')}}", 
							type : "POST", // type of action POST || GET 
							data : $("#ajax_insert").serialize(), // post data || get data 
							success : function(data) {
									console.log(data);
									if(data["data"] == 1){
										alert("This Date already exist !!");
									}else{
										$('#ajax_insert').trigger("reset");
										document.getElementById("travel_id").value = '';
										$('#ajax_insert').trigger("reset");
										  
										if(visit_type == 2){
											
											
											document.getElementById("source_br_code").value = '';
											document.getElementById("dest_br_code").value = '';
											document.getElementById("medium_trav").value = '';
											document.getElementById("travel_allowance").value = '';
										}
										$("#reload_tbl").load(location.href + " #reload_tbl"); 
										document.getElementById('btn_text_value').innerText = 'Add to Grid';
									}
									
										
									
							},
						error: function(xhr, resp, text) {
							console.log(xhr, resp, text);
						}
						})   
		})
		function edit(id)
		{
			document.getElementById("travel_id").value = id; 	 
			$.ajax({
				url : "{{URL::to('travel_edit')}}"+"/"+id,		
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{
					 console.log(data);
					 $("#travel_date").val(data["data"]["travel_date"]);
					 $("#source_br_code").val(data["data"]["source_br_code"]);
					 $("#dest_br_code").val(data["data"]["dest_br_code"]);
					 $("#medium_trav").val(data["data"]["medium_trav"]);
					 $("#travel_allowance").val(data["data"]["travel_allowance"]);
					 $('#btn_text_value').text('Update');
					 check_destination();
				}
			});
		}
	function delete_row(id)
		{
			var chk=confirm("Are you sure to delete !!!");
			if(chk)
			{  
				var table = "tbl_move_trav_details";
				$.ajax({ 
				url : "{{URL::to('movement_delete')}}"+"/"+ table +"/"+ id,
				type : "get", 
				success : function(data) {  
					$("#reload_tbl").load(location.href + " #reload_tbl"); 
						console.log(data);
					},
					error: function(xhr, resp, text) {
						console.log(xhr, resp, text);
					}
				})  
			}
			else{
				return false;
			
			}
		
		}
		$('#ajax_insert_bill').on('submit',function(e){
				e.preventDefault();
					$.ajaxSetup({
						header:$('meta[name="_token"]').attr('content')
					})  
					//alert('ok');
				$.ajax({ 
					url : "{{URL::to('bill_insert')}}", 
					type : "POST", // type of action POST || GET 
					data : $("#ajax_insert_bill").serialize(), // post data || get data 
					success : function(data) {
							console.log(data);	
							if(data["data"] == 1){
								alert("This Date already exist !!");
							}else{
								document.getElementById("bill_id").value = '';
								$('#ajax_insert_bill').trigger("reset");
								
								
								document.getElementById("breakfast").value = '';
								document.getElementById("lunch").value = '';
								document.getElementById("dinner").value = '';
								document.getElementById("tot_amt").value = '';
								
								$("#reload_tbl_bill").load(location.href + " #reload_tbl_bill");
								$("#reload_tbl_bill_modal").load(location.href + " #reload_tbl_bill_modal");
								document.getElementById('btn_text_value_bill').innerText = 'Add to Grid';
							}
								
							
								
							
					},
				error: function(xhr, resp, text) {
					console.log(xhr, resp, text);
				}
				}) 
		})
		function edit_bill(id)
		{
			document.getElementById("bill_id").value = id; 	 
			$.ajax({
				url : "{{URL::to('bill_edit')}}"+"/"+id,		
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{
					 console.log(data);
					 $("#bill_date").val(data["data"]["bill_date"]);
					 $("#breakfast").val(data["data"]["breakfast"]);
					 $("#lunch").val(data["data"]["lunch"]);
					 $("#dinner").val(data["data"]["dinner"]);
					 $("#tot_amt").val(data["data"]["tot_amt"]);
					 $('#btn_text_value_bill').text('Update');
				}
			});
		}
		function delete_row_bill(id)
		{
			var chk=confirm("Are you sure to delete !!!");
			if(chk)
			{  
				var table = "tbl_move_bill_details";
				$.ajax({ 
				url : "{{URL::to('movement_delete')}}"+"/"+ table +"/"+ id,
				type : "get", 
				success : function(data) {  
					$("#reload_tbl_bill").load(location.href + " #reload_tbl_bill");
					$("#reload_tbl_bill_modal").load(location.href + " #reload_tbl_bill_modal");
						console.log(data);
					},
					error: function(xhr, resp, text) {
						console.log(xhr, resp, text);
					}
				})  
			}
			else{
				return false;
			
			}
		
		} 
</script> 
@endsection