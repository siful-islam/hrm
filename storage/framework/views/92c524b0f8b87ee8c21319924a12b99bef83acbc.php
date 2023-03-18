<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
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
	<p>
		<a onclick="javascript:printDiv('printme');" title="print"><img src="http://202.4.106.3/phonebook/storage/others/print.png" /></a>
		<a onclick="javascript:printDiv('printme');" title="print"><img src="http://202.4.106.3/hrm/storage/attachments/download.png" height="20px" width="20px"/></a>
	</p>
	</center>
	<div class="screen screen1">
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
	
	
	<p>তারিখঃ 2021-06-10</p>
	<p>বরাবর, </p>
	<p>বিভাগীয় প্রধান, মানবসম্পদ বিভাগ, সিদীপ।</p> 
	<p>বিষয়ঃ ইকুপমেন্ট ঋণের জন্য আবেদন। </p> 
	<p>জনাব, </p> 
	<p>আমি নিম্নে স্বাক্ষরকারী সিদীপ হতে ইকুইপমেন্ট ক্রয়ের জন্য  ...............টাকা ঋণ নিতে ইচ্ছুক। নিম্নে বিস্তারিত বিবরণ দেয়া হলোঃ  </p> 
	<br>
	
	<p>১. সিদীপ-এ যোগদানের তারিখ:  ..................................... ২. স্থায়ীকরণের তারিখ: .............................................. </p>
	<p>৩. ইকুইপমেন্ট এর বিবরণ:  <?php //echo $info->loan_purpose;?></p>
	<p>৪. ঋণ আবেদনের পরিমাণ :  <?php echo $info->loan_amount;?></p>
	<p>৫. ব্যাংক হিসাবের বিবরণ : (ইংরেজীতে) : </p>
	<br>
	<p>A) Name (Account Holder):  <?php echo $info->accounts_holder;?></p>
	<p>B) Bank Name: <?php echo $info->bank_id;?></p>
	<p>C) Account Number: <?php echo $info->bank_branch_id;?></p>
	<p>D) Branch: <?php echo $info->accounts_number;?></p>
	<p>E) Routing Number: <?php echo $info->routing_number;?></p>
	
	<p>
		আমি অঙ্গীকার করছি যে, আমি ইকুইপমেন্ট ক্রয়ের জন্য গৃহিত মোট ঋণের দ্বারা ইকুইপমেন্ট ক্রয় করব এবং  সম্পূর্ন ঋণের টাকা নীতিমালা মোতাবেক পে-রোলের মাধ্যমে পরিশোধ করবো। 
		এছাড়া এই ঋণের কিস্তি চলমান থাকাকালীন সময়ে আমি চাকুরী থেকে অব্যাহতি নিলে অথবা আমাকে চাকুরী থেকে >অব্যাহতি প্রদান করা হলে সেক্ষেত্রে ঋণের অবশিষ্ট টাকা  
		আমার চূড়ান্ত দেনা-পাওনা হতে স্বয়ংক্রিয় ভাবে পরিশোধযোগ্য হবে বা আমি পরিশোধ করবো। এছাড়া ভবিষ্যতে ইকুইপমেন্ট ঋণ সংক্রান্ত যে কোন সিদ্ধান্ত নেয়া হলে আমি সেসব সিদ্ধান্ত মেনে চলতে বাধ্য থাকবো। 
	</p>
	<br>
	
	<p>
		<table>
			<tr>
				<td width="20%">আবেদনকারীর স্বাক্ষর :  </td>
				<td width="20%"> </td>
				<td width="20%" align="right">সুপারিশকারীর স্বাক্ষর:</td>
				<td width="30%"></td>
			</tr>
			
			<tr>
				<td width="10%" align="right">নাম:</td>
				<td width="50%"></td>
				<td width="20%" align="right"> নাম:</td>
				<td width="30%"></td>
				
			</tr>
			<tr>
				<td width="10%" align="right">আইডি নং :</td>
				<td width="50%"></td>
				<td width="20%" align="right"> আইডি নং :</td>
				<td width="30%"></td>
				
			</tr>
			<tr>
				<td width="10%" align="right">পদবী :</td>
				<td width="50%"></td>
				<td width="20%" align="right"> পদবী :</td> 
				<td width="30%"></td>
				
			</tr>
			
		</table>
	</p>
	
	
	</div>
</body>
</html>




