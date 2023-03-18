@extends('admin.admin_master')
@section('main_content')
<style>
.content-header {
    padding-top: 5px;
}
.content-header > .breadcrumb {
	padding: 2px 7px;
}
.table-bordered {
    border: 1px solid #757070;
}
.table > thead > tr > th {
    border: 1px solid #757070;
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
	font-weight: bold;
	text-align: left; 
	padding: 2px 5px;
}
.table > tbody > tr > td {
    border: 1px solid #757070;
	padding: 4px 5px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
h4 {
	font: 16px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
</style>
<?php
function getBanglaDate($date){
 $engArray = array(1,2,3,4,5,6,7,8,9,0);
 $bangArray = array('১','২','৩','৪','৫','৬','৭','৮','৯','০');
 
 $convert = str_replace($engArray, $bangArray, $date);
 return $convert;
}
 
$date = date('d-m-Y',strtotime($form_date));

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small>{{$Heading}}</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Final Payment</li>
	</ol>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="{{URL::to('/final-payment')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
						  <label for="pwd">Employee ID:</label>
						  <input type="text" class="form-control" name="emp_id" size="10" value="{{$emp_id}}" required>
						</div>
						<div class="form-group">
						  <label for="pwd">Payment Type:</label>
						  <select class="form-control" id="payment_type" name="payment_type" required>						
							<option value="" >-Select-</option>
							<option value="1" >Final Payment</option>
							<option value="2" >PF Payment</option>
							<option value="3" >Gratuity Payment</option>
						  </select>	
						</div>
						<div class="form-group">
						  <label for="pwd">Date:</label>
						  <input type="text" id="form_date" class="form-control" name="form_date" size="10" value="{{$form_date}}" required>
						</div>					
						<button type="submit" class="btn btn-primary" >Search</button>
						<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>
					</form>
				</div>
			</div>
        </div>
	</div>
	@if (!empty($all_result))
		@if ($payment_type ==1)
	<div class="row">
		<div id="printme">
			<div class="col-md-10 col-md-offset-1">
				<div style="text-align:center;">
					<h4 style="margin-top:4px;">(নোট শীট)</h4>
				</div>
				<table class="table table-striped" style="margin-bottom: 10px;">
					<tbody>
						<tr>
							<td style="text-align:right;border-style:none;">তারিখ : <?php echo getBanglaDate($date);?></td>
						</tr>
						<tr>
							<td style="border-style:none;padding-top:10px;">
								<p style="font-size: 14px;line-height: 1.6;">কর্মী/কর্মকর্তার নাম: {{$all_result->emp_name_eng}}, 
								আইডি নং- {{getBanglaDate($all_result->emp_id)}}, পদবী: {{$all_result->designation_name}}, 
								ব্রাঞ্চের নাম: {{$all_result->branch_name}}, সংস্থায় যোগদানের তারিখ:{{date('d-m-Y',strtotime($all_result->org_join_date))}}, 
								স্থায়ীকরণের তারিখ:{{date('d-m-Y',strtotime($permanent_date))}},
								 অব্যহতির তারিখ:{{date('d-m-Y',strtotime($all_result->re_effect_date))}},
								এর চুড়ান্ত দেনা-পাওনার হিসাব নিম্নরূপ : 
								</p>
							</td>
						</tr>
					</tbody>
				</table>
				<form class="form-horizontal" action="{{URL::to('/final-payment-insert')}}" method="post">
				{{ csrf_field() }}
				<div class="table-responsive">
					<input type="hidden" name="emp_id" value="<?php echo $all_result->emp_id; ?>">
					<input type="hidden" name="br_code" value="<?php echo $all_result->br_code; ?>">
					<input type="hidden" name="designation_code" value="<?php echo $all_result->designation_code; ?>">
					<input type="hidden" name="fp_date" value="<?php echo $form_date; ?>">
					<table class="table table-bordered table-striped" style="width:100%">						
						<tr>
							<td>
								<table class="table">									
									<tr>
										<td><b>ক) &nbsp;&nbsp;কর্মীর পাওনা :</b></td>
										<td><b><center>টাকা</center></b></td>
									</tr>
									<?php $i=1; foreach($all_plus_item as $plus_item) { ?>
									<tr>
										<td><?php echo getBanglaDate($i).'.'.$plus_item->item_name; ?></td>
										<td>
											<input type="text" name="plus_item_amt[]" value="0" id="plus_item{{$i}}" onkeyup="plus_calculate(<?php echo count($all_plus_item);?>);" onClick="this.select();">
											<input type="hidden" name="plus_item_id[]" value="<?php echo $plus_item->item_id; ?>">
										</td>
									</tr>
									<?php $i++; } ?>
									<tr>
										<td><b><center>মোট পাওনা :</center></b></td>
										<td><b><input type="text" name="total_plus_amt" id="total_plus" readonly style="height:25px;background:#eee;" ></b></td>
									</tr>
								</table>
							</td>
							<td>
								<table class="table">									
									<tr>
										<td><b>খ) &nbsp;&nbsp;কর্মীর দেনা :</b></td>
										<td><b><center>টাকা</center></b></td>
									</tr>
									<?php $i=1; foreach($all_minus_item as $minus_item) { ?>
									<tr>
										<td><?php echo getBanglaDate($i).'.'.$minus_item->item_name; ?></td>
										<td>
											<input type="text" name="minus_item_amt[]" value="0" id="minus_item{{$i}}" onkeyup="minus_calculate(<?php echo count($all_minus_item);?>);" onClick="this.select();">
											<input type="hidden" name="minus_item_id[]" value="<?php echo $minus_item->item_id; ?>">
										</td>
									</tr>
									<?php $i++; } ?>
									<tr>
										<td><b><center>মোট দেনা :</center></b></td>
										<td><b><input type="text" name="total_minus_amt" id="total_minus" readonly style="height:25px;background:#eee;" ></b></td>
									</tr>
								</table>
							</td>
						</tr>	
					</table>
					<?php 
					$total_plus1 = '<span id="total_plus1"></span>'; 
					$total_minus1 = '<span id="total_minus1"></span>';
					$gross_total = '<span id="gross_total"></span>';
					$in_word = '<span id="in_word"></span>';
					?>
					<button type="submit" class="btn btn-primary pull-right" >Save</button>
					<p>কর্মীর চুড়ান্ত পাওনা বাবদ =  (<?php echo $total_plus1.'-'.$total_minus1;?>) = <?php echo $gross_total; ?>/-(<?php echo $in_word; ?>)টাকার হিসাবটি উপস্থাপন করা হল।</p>
					
					<p style="padding-top:50px;">প্রস্তুতকারক</p>
				</div>
				</form>
			</div>
		</div>
	</div>
	@endif
	@if ($payment_type ==2)
	<div class="row">
		<div id="printme">
			<div class="col-md-10 col-md-offset-1">
				<div style="text-align:center;">
					<h4 style="margin-top:4px;">(নোট শীট)</h4>
				</div>
				<table class="table table-striped" style="margin-bottom: 10px;">
					<tbody>
						<tr>
							<td style="text-align:right;border-style:none;">তারিখ : <?php echo getBanglaDate($date);?></td>
						</tr>
						<tr>
							<td style="border-style:none;padding-top:10px;">
								<p style="font-size: 14px;line-height: 1.6;">কর্মী/কর্মকর্তার নাম: {{$all_result->emp_name_eng}}, 
								আইডি নং- {{getBanglaDate($all_result->emp_id)}}, পদবী: {{$all_result->designation_name}}, 
								ব্রাঞ্চের নাম: {{$all_result->branch_name}}, সংস্থায় যোগদানের তারিখ:{{date('d-m-Y',strtotime($all_result->org_join_date))}}, 
								স্থায়ীকরণের তারিখ:{{date('d-m-Y',strtotime($permanent_date))}},
								 অব্যহতির তারিখ:{{date('d-m-Y',strtotime($all_result->re_effect_date))}}, 
								এর ভবিষ্য তহবিলের হিসাব নিম্নরূপ : <br/> ( নীতিমালার ২৪.১ অনুচ্ছেদ অনুসারে )
								</p>
							</td>
						</tr>
					</tbody>
				</table>
				<form class="form-horizontal" action="{{URL::to('/final-payment-pf')}}" method="post">
				{{ csrf_field() }}
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>ক) &nbsp;&nbsp;কর্মীর পাওনা :</th>
								<th><center>টাকা</center></th>
								<th>খ) &nbsp;&nbsp;কর্মীর দেনা ও অ-প্রাপ্য অংশ :</th>
								<th><center>টাকা</center></th>
							<tr>
						</thead>
						<tbody>
							<tr>
								<td><b>ভবিষ্য তহবিলের জমা :</b></td>
								<td><center>-</center></td>
								<td>-</td>
								<td>-</td>
							</tr>
							<tr>
								<td>নিজস্ব অংশ (১০০%)</td>
								<td><input type="text" name="pf_own" value="<?php echo empty($pf->closing_balance_staff) ? '' : round($pf->closing_balance_staff);?>" class="form-control" size="2"></td>
								<td>পি,এফ ঋণের কিস্তি </td>
								<td><input type="text" name="pf_loan_deduc" value="<?php echo empty($pfl_loan_amt->total_pfl_amt) ? '' : round($pfl_loan_amt->total_pfl_amt);?>" class="form-control" size="2"></td>
							</tr>
							<tr>
								<td>সংস্থার অংশ (১০০%)</td>
								<td><input type="text" name="pf_org" value="<?php echo empty($pf->closing_balance_org) ? '' : round($pf->closing_balance_org);?>" class="form-control" size="2"></td>
								<td>অ-প্রাপ্য অংশ</td>
								<td><input type="text" name="unrevealed_part" class="form-control" size="2"></td>
							</tr>
							<tr>
								<td>দাবিদারহীন হিসাব</td>
								<td><input type="text" name="unreasonable_amt" class="form-control" size="2"></td>
								<td>সিদীপের প্রাপ্য (কর্মীর দেনা)</td>
								<td><input type="text" name="org_deserve_own" class="form-control" size="2"></td>
							</tr>
							<tr>
								<td><center>মোট :</center></td>
								<td><input type="text" name="total_pay" value="<?php echo empty($pf->closing_balance_staff) ? '' : round($pf->closing_balance_staff + $pf->closing_balance_org);?>" class="form-control" size="2"></td>
								<td><center>মোট :</center></td>
								<td><input type="text" name="total_due" class="form-control" size="2"></td>
							</tr>
						</tbody>	
					</table>
					<button type="submit" class="btn btn-primary pull-right" >Save</button>
					<p>কর্মীর ভবিষ্য তহবিলের <b>দেনা-পাওনা</b> বাবদ = /- () টাকার হিসাবটি উপস্থাপন করা হল।</p>
					<p style="padding-top:50px;">প্রস্তুতকারক</p>
				</div>
				</form>
			</div>
		</div>
	</div>	
	@endif
	@if ($payment_type ==3)
	<div class="row">
		<div id="printme">
			<div class="col-md-10 col-md-offset-1">
				<div style="text-align:center;">
					<h4 style="margin-top:4px;">(নোট শীট)</h4>
				</div>
				<table class="table table-striped" style="margin-bottom: 10px;">
					<tbody>
						<tr>
							<td style="text-align:right;border-style:none;">তারিখ : <?php echo getBanglaDate($date);?></td>
						</tr>
						<tr>
							<td style="border-style:none;padding-top:10px;">
								<p style="font-size: 14px;line-height: 1.6;">কর্মী/কর্মকর্তার নাম: {{$all_result->emp_name_eng}}, 
								আইডি নং- {{getBanglaDate($all_result->emp_id)}}, পদবী: {{$all_result->designation_name}}, 
								ব্রাঞ্চের নাম: {{$all_result->branch_name}}, সংস্থায় যোগদানের তারিখ:{{date('d-m-Y',strtotime($all_result->org_join_date))}}, 
								স্থায়ীকরণের তারিখ:{{date('d-m-Y',strtotime($permanent_date))}},
								 অব্যহতির তারিখ:{{date('d-m-Y',strtotime($all_result->re_effect_date))}}, {{$all_result->br_name_bangla}} 
								এর গ্র্যাচুইটি তহবিলের হিসাব নিম্নরূপ : <br/> ( নীতিমালার ২১.৪ অনুচ্ছেদ অনুসারে )
								</p>
							</td>
						</tr>
					</tbody>
				</table>
				<form class="form-horizontal" action="{{URL::to('/final-payment-gra')}}" method="post">
				{{ csrf_field() }}
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>ক) &nbsp;&nbsp;কর্মীর পাওনা :</th>
								<th><center>টাকা</center></th>
								<th>খ) &nbsp;&nbsp;কর্মীর দেনা ও অ-প্রাপ্য অংশ :</th>
								<th><center>টাকা</center></th>
							<tr>
						</thead>
						<tbody>
							<tr>
								<td><b>চাকুরীর মেয়াদ কাল : {{$service_length}} </b></td>
								<td><center>-</center></td>
								<td><?php 
										
									?>
								</td>
								<td><center>-</center></td>
							</tr>
							<tr>
								<td>{{$year . ' Years'}} ( {{$salary->salary_basic.'*'.$gratuity->point.'*'.$year}} )</td>
								<td><input type="text" name="year_amt" value="{{$gra_amt_year}}" class="form-control" size="2"></td>
								<td>গ্র্যাচুইটি ঋণের কিস্তি</td>
								<td><input type="text" name="gratuity_loan" value="<?php echo empty($grl_loan_amt->total_grl_amt) ? '' : round($grl_loan_amt->total_grl_amt);?>" class="form-control" size="2"></td>
							</tr>
							<tr>
								<td>{{$month . ' Months'}} ( {{$salary->salary_basic.'*'.$gratuity->point.'*'.$month}} )/12</td>
								<td><input type="text" name="month_amt" value="{{round($gra_amt_month)}}" class="form-control" size="2"></td>
								<td>সিদীপের প্রাপ্য (কর্মীর দেনা)</td>
								<td><input type="text" name="org_deserve_own" value="" class="form-control" size="2"></td>
							</tr>
							<tr>
								<td>সর্ব-মোট গ্র্যাচুইটি</td>
								<td><input type="text" name="total_pay" value="{{round($gra_amt_year+$gra_amt_month)}}" class="form-control" size="2"></td>
								<td>সর্ব-মোট দেনা</td>
								<td><input type="text" name="total_due" value="" class="form-control" size="2"></td>
							</tr>
						</tbody>	
					</table>
					<button type="submit" class="btn btn-primary pull-right" >Save</button>
					<p>কর্মীর গ্র্যাচুইটি তহবিলের <b>পাওনা</b> বাবদ = /- () টাকার হিসাবটি উপস্থাপন করা হল।</p>
					<p style="padding-top:50px;">প্রস্তুতকারক</p>
				</div>
				</form>
			</div>
		</div>
	</div>	
	@endif
	@endif
</section>
<script>
	function plus_calculate(val) 
	{
		var val = val+1;
		var totalplus = 0;
		for (i = 1; i < val; i++) { 
		
			var plus_value = parseFloat(document.getElementById("plus_item"+i).value);
			if(isNaN(plus_value)) {
				var plus_value = 0;
				document.getElementById("plus_item"+i).value = 0;
			}
			var totalplus = totalplus+plus_value;
		}
		var aa = document.getElementById("total_plus").value = totalplus;
		document.getElementById("total_plus1").innerHTML = new Number(totalplus).toLocaleString("bn-BD");
		var total_minus = parseFloat(document.getElementById("total_minus").value);
		if(isNaN(total_minus)) {
				var total_minus = 0;
			}
		var gross_total = (totalplus-total_minus);
		document.getElementById("gross_total").innerHTML = new Number(gross_total).toLocaleString("bn-BD");
		document.getElementById("in_word").innerHTML = convertNumberToWords(gross_total);
		
	}
	
	function minus_calculate(val) 
	{
		var val = val+1;
		var totalminus = 0;
		for (i = 1; i < val; i++) { 
		
			var minus_value = parseFloat(document.getElementById("minus_item"+i).value);
			if(isNaN(minus_value)) {
				var minus_value = 0;
				document.getElementById("minus_item"+i).value = 0;
			}
			var totalminus = totalminus+minus_value;
		}
		document.getElementById("total_minus").value = totalminus;
		document.getElementById("total_minus1").innerHTML = new Number(totalminus).toLocaleString("bn-BD");
		var totalplus = parseFloat(document.getElementById("total_plus").value);
		var gross_total = (totalplus-totalminus);
		document.getElementById("gross_total").innerHTML = new Number(gross_total).toLocaleString("bn-BD");
		document.getElementById("in_word").innerHTML = convertNumberToWords(gross_total);
		
	}
</script>
<script>
$(document).ready(function() {
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
	document.getElementById("payment_type").value="{{$payment_type}}";
});

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
                words_string += "শ ";
            }
        }
    
        words_string = words_string.split("  ").join(" ");
        
    }
  return words_string;
}
</script>
<script>
    function printDiv(divID) {
		var divToPrint = document.getElementById(divID);
			//document.getElementById('note').style.display = 'block';
		var htmlToPrint = '' +
			'<style type="text/css">' + '.table-striped p {' +
			'font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + '.table-bordered th {' +
			'border:1px solid #757070;padding:4px;font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + '.table-bordered td {' +
			'border:1px solid #757070;padding:4px;font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
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
		location.reload();
    }
</script>
@endsection