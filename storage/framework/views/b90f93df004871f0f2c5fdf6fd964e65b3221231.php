<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="shortcut icon" href="<?php echo e(asset(Session::get('favicon'))); ?>">
	<title>Loan Application</title>
	<style>
		.screen{
		   padding: 10px;
		   margin: 10px auto;
		   color: black;
		   border-radius: 0 0 50px 50px;
		   border: 1px solid #000;
		}
		.screen1 {
		   width: 50%;
		}
	</style>
</head>
<body style="font-size: 14px;">
	<center style="text-align:justfy;text-justify: inter-word;"> 
		<a onclick="javascript:printDiv('printme');" title="print" href="#"><img src="http://202.4.106.3/hrm_live/public/print.png" /></a>
	</center>
	<div class="screen screen1" id="printme">
		<div class="box-header with-border">			
			<center style="text-align:justfy;text-justify: inter-word;" id="with_header"> 
				<span class="box-title" style="text-align:justify; text-justify: inter-word;">
					<span style="font-size:20px;"> সেন্টার ফর ডেভেলপমেন্ট     ইনোভেশন এন্ড প্র্যাকটিসেস ( সিদীপ )  <br></span><span style="font-size:24px;">Centre for Development Innovation and Practices (CDIP)</span><br>
					<span style="font-size:12px;">সিদীপ ভবন, হাউজ # ১৭, রোড # ১৩, পিসিকালচার হাউজিং সোসাইটি, সেখেরটেক, আদাবর, ঢাকা</span><br>
					<span style="font-size:14px;font-weight:bold; color:#800000; ">web:www.cdipbd.org, Email:info@cdipbd.org, Phone:02-48118633,02-48118634</span>
				</span>  
			</center>
			<hr>
		</div>
	<br>
	
	<center><h3>কর্মী ঋণ আবেদনপত্র </h3></center>
	
	<table width="100%">
		<tr>
			<td width="80%">বরাবর</td>
			<td>তারিখঃ <?php echo date('d-m-Y', strtotime($info->application_date)); ?></td>
		</tr>
		<?php 
		if($info->loan_type_id == 1 )
		{
			$to = 'সচিব, ভবিষ্য তহবিল'; 
		}else{
			$to = 'বিভাগীয় প্রধান, মানবসম্পদ বিভাগ';
		}
		?>
		<tr>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="2"><?php echo $to ?> </td>
		</tr>
		<tr>
			<td colspan="2">প্রধান কার্যালয়, সিদীপ।</td>
		</tr>
	</table>
	</br> 
	</br> 
	বিষয়ঃ  <b>"<?php echo $info->product_name_bangla ?>"</b> ঋণের জন্য আবেদন। </br></br> 
	
	জনাব, </br> </br> 
	
	<b>আমি নিম্নস্বাক্ষরকারী সংস্থার নিয়মাবলী মেনে নিম্নে উল্লিখিত বিষয়ে ঋণ গ্রহন করতে ইচ্ছুক। </b>
	</br> 
	</br> 
	
	<table width="100%">
		<tr>
			<th width="32%" align="left">কর্মী ঋণ আবেদনের কারণঃ</th> 
			<td width="2%">:</td>
			<td width="60%"> <?php echo $info->loan_purpose.' '.$info->equipments; ?></td>
		</tr>
	</table>
	</br> 
	<table width="100%">
		<tr>
			<td width="2%">১.</td> 
			<td width="30%">নাম ও আইডি নং </td> 
			<td width="2%">:</td>
			<td width="60%"><?php echo $info->emp_name_eng.' ( '.$info->emp_id.' )'?></td>
		</tr>
		<tr>
			<td width="2%">২.</td>  
			<td width="30%">পিতার নাম</td>  
			<td width="2%">:</td>
			<td width="60%"><?php echo $info->father_name; ?></td>
		</tr>
		<tr>
			<td width="2%">৩.</td>   
			<td width="30%">পদবি</td>   
			<td width="2%">:</td>
			<td width="60%"><?php echo $info->designation_name; ?></td>
		</tr>
		<tr>
			<td width="2%">৪.</td>    
			<td width="30%">বর্তমান ঠিকানা (কর্মস্থল)</td>   
			<td width="2%">:</td>
			<td width="60%"><?php echo $info->branch_name.' ( '.$info->emp_branch.' )'; ?></td>
		</tr>
		<tr> 
			<td width="2%">৫.</td>   
			<td width="30%">স্থায়ী ঠিকানা</td>   
			<td width="2%">:</td>
			<td width="60%"><?php echo $info->permanent_add; ?></td>
		</tr>
		<tr>
			<td width="2%">৬.</td>   
			<td width="30%">'সিদীপ' - এ যোগদানের তারিখ</td>    
			<td width="2%">:</td>
			<td width="60%"><?php echo $info->org_join_date; ?></td>
		</tr>
		<tr>
			<td width="2%">৭.</td>    
			<td width="30%">সর্বসাকুল্যে বেতন  </td>    
			<td width="2%">:</td>
			<td width="60%"><?php echo number_format($salary_info->gross_total,2); ?></td>
		</tr>
		

		
		<tr>
			<td width="2%">৮.</td>     
			<td width="30%"> সংস্থার অন্য কোন ঋণ থাকলে তার বিবরন  </td>    
			<td width="2%"></td>
			<td width="60%"></td>
		</tr>
		<?php foreach($previous_loan_info as $v_previous_loan_info) { ?>
		<?php
		$loan_info = DB::table('loan_schedule')	
				->where('loan_id',$v_previous_loan_info->loan_id)
				->where('status','Paid')
				->orderBy('loan_schedule_id', 'desc')
				->select('ending_balance')
				->first();
		if($loan_info)
		{	
		?>
		<tr>
			<td width="2%"></td>    
			<td width="30%">ক )  ঋণের ধরন </td>    
			<td width="2%">:</td>
			<td width="60%"><?php echo $v_previous_loan_info->loan_product_name; ?></td>
		</tr>
		<tr>
			<td width="2%"></td>    
			<td width="30%"> খ) ঋণের স্থিতি  </td>     
			<td width="2%">:</td>
			<td width="60%"><?php echo number_format($loan_info->ending_balance,2); ?></td>
		</tr>
		<?php } }  ?>

		<tr>
			<td width="2%">৯.</td>    
			<td width="30%"> ঋণ আবেদনের পরিমান (টাকা)  </td>    
			<td width="2%">:</td>
			<td width="60%"><?php echo number_format($info->loan_amount,2); ?></td>
		</tr>
		<tr>
			<td width="2%">১০.</td>     
			<td width="30%"> ব্যাংক হিসাবের বিবরনঃ (ইংরেজীতে) </td>     
			<td width="2%"></td>
			<td width="60%"></td>
		</tr>
		<tr>
			<td width="2%"></td>     
			<td width="30%">Name (Account Holder)</td>    
			<td width="2%">:</td>
			<td width="60%"><?php echo $info->accounts_holder;?></td>
		</tr>
		<tr>
			<td width="2%"></td>     
			<td width="30%">Bank Name</td>    
			<td width="2%">:</td>
			<td width="60%"><?php echo $info->bank_name;?></td>
		</tr>
		<tr>
			<td width="2%"></td>     
			<td width="30%">Account Number</td>    
			<td width="2%">:</td>
			<td width="60%"><?php echo $info->accounts_number;?></td>
		</tr>
		<tr>
			<td width="2%"></td>     
			<td width="30%">Branch</td>    
			<td width="2%">:</td>
			<td width="60%"><?php echo $info->bank_branch_name;?></td>
		</tr>
		<tr>
			<td width="2%"></td>     
			<td width="30%">Routing Number</td>    
			<td width="2%">:</td>
			<td width="60%"><?php echo $info->routing_number;?></td>
		</tr>
	</table>
	</br>
	</br>
	
	<?php if($info->application_stage == 3 && $info->loan_type_id == 4 ) { 	

	if($info->motorcycle_registration == 1) 
	{ 
		$motorcycle_registration = 'মোটর সাইকেল নিজের নামে রেজিস্ট্রেশন করবেন। ';
	}else{
		$motorcycle_registration = 'মোটর সাইকেল প্রতিষ্ঠানের  নামে রেজিস্ট্রেশন করবেন। ';
	}
	?>
	<table border="0">
		<tr>  
			<th style="color:blue">Registration</th>    
			<th>:</th>
			<th><?php echo $motorcycle_registration;?></th>
		</tr>
	</table>
	<?php } ?>
	
	<?php if($info->application_stage == 3) { ?>	
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	</br> 
	<hr>
	</br> 
	</br>
	<table width="80%" style="border: 1px solid black; border-collapse: collapse;" align="center">
		<thead style="border: 1px solid black; border-collapse: collapse;">
			<tr>
				<th colspan="8" style="background-color: #074756; color:white;"><h2>Loan Schedule</h2></th>
			</tr>
			<tr style="background-color: #CDD3D5;">
				<th style="border: 1px solid black; border-collapse: collapse;" rowspan="2">Installment No.</th>
				<th style="border: 1px solid black; border-collapse: collapse;" rowspan="2">Payment Date</th>
				<th style="border: 1px solid black; border-collapse: collapse;" rowspan="2">Beginning Balance</th>
				<th style="border: 1px solid black; border-collapse: collapse;" colspan="3">Payment</th>
				<th style="border: 1px solid black; border-collapse: collapse;" rowspan="2">Ending Principal</th>
				<th style="border: 1px solid black; border-collapse: collapse;" rowspan="2">Ending Interest</th>
			</tr>
			<tr style="background-color: #CDD3D5;">
				<th style="border: 1px solid black; border-collapse: collapse; text-align: center; vertical-align: middle">Principal</th>
				<th style="border: 1px solid black; border-collapse: collapse; text-align: center; vertical-align: middle">Interest</th>
				<th style="border: 1px solid black; border-collapse: collapse; text-align: center; vertical-align: middle">Total amount</th>
			</tr>
		</thead>

		<tbody style="border: 1px solid black; border-collapse: collapse;">
			<?php
			$loan_id 	= $info->loan_app_id;
			$LoanAllData = DB::table('loan_schedule')  
				->where('application_id', $info->loan_app_id)
				->orderBy('loan_schedule_id', 'ASC')
				->get();
			$i = 1;
			$total_interest = 0;
			$total_principal = 0;
			$lastLoanAllData = count($LoanAllData);
			$ending_interest = $LoanAllData[$lastLoanAllData - 1]->cumulative_interest;
			foreach($LoanAllData as $loan_schedule) { 
			$total_interest += $loan_schedule->interest_payable;
			$ending_interest = $ending_interest - $loan_schedule->interest_payable;
			?> 
			<?php 			
			$repayment_date = $loan_schedule->repayment_date;
			$timestamp = strtotime($repayment_date);
			$new_repayment_date = date("d-m-Y", $timestamp);
			?>
			<tr>
				<td style="background-color: #CDD3D5; border: 1px solid black; border-collapse: collapse;" align="center"><?php echo $i++; ?></td>
				<td style="border: 1px solid black; border-collapse: collapse;" align="center"><?php echo $new_repayment_date; ?></td>
				<td style="border: 1px solid black; border-collapse: collapse;" align="right"><?php echo number_format($loan_schedule->beginning_balance, 2, '.', ','); ?></td>
				<td style="border: 1px solid black; border-collapse: collapse;" align="right"><?php echo number_format($loan_schedule->principal_payable, 2, '.', ','); ?></td>
				<td style="border: 1px solid black; border-collapse: collapse;" align="right"><?php echo number_format($loan_schedule->interest_payable, 2, '.', ','); ?></td>
				<td style="border: 1px solid black; border-collapse: collapse;" align="right"><?php echo number_format($loan_schedule->installment_amount, 2, '.', ','); ?></td>
				<td style="border: 1px solid black; border-collapse: collapse;" align="right"><?php echo number_format($loan_schedule->ending_balance, 2, '.', ','); ?></td>
				<td style="border: 1px solid black; border-collapse: collapse;" align="right"><?php echo number_format($ending_interest, 2, '.', ','); ?></td>
			</tr>
			<?php } ?>
		</tbody>

	</table>
	</br> 
	</br> 
	</br> 
	</br>
	<?php } ?>	
	</br> 
	</br> 


<script language="javascript" type="text/javascript">
	
    var isCtrl = false;     
    document.onkeyup=function()
    {
        var e = window.event;
        if(e.keyCode == 17)
        {
            isCtrl=false;
        }
    }
    
    document.onkeydown=function()
    {
        var e = window.event;
        
        if(e.keyCode == 17)
        {
            isCtrl=true;
        }
        if(e.keyCode == 80 && isCtrl == true) // Ctrl + P
        {
            printDiv("printme") // write ur stuff here...
        }
    }
   



    function printDiv(divID) {
    var divToPrint = document.getElementById(divID);
    var htmlToPrint = '' +
        '<style type="text/css">'+'.no-border th, .no-border td {' +
        'border:none;' + 
        '}' + '.table-bordered th, .table-bordered td {' +
        'border:1px solid #000 !important;' + 'font-size:13px !important;' + 
        '}'+ '.custom th, .custom td {' 
         + 'font-size:11px !important;' + 
        '}' + 'table {' +
        'border-collapse: collapse;' + 
        '}' + 'body {' +
        '-webkit-print-color-adjust: exact;' +
        'color-adjust: exact;'+
        '}' +
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close(); 
    }
</script>
</body>
</html>




