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
		<a onclick="javascript:printDiv('printme');" title="print" href="#"><img src="http://202.4.106.3/phonebook/storage/others/print.png" /></a>&nbsp;&nbsp;&nbsp;
		<a onclick="javascript:printDiv('printme');" title="Download" href="#"><img src="http://202.4.106.3/hrm__/storage/attachments/download.png" height="20px" width="20px"/></a>
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
	<p>তারিখঃ <?php echo date('d-m-Y', strtotime($info->application_date)); ?></br></br>
	বরাবর, </br>
	বিভাগীয় প্রধান, মানবসম্পদ বিভাগ, সিদীপ।</br></br> 
	বিষয়ঃ ইকুপমেন্ট ঋণের জন্য আবেদন। </br>  </br> 
	জনাব, </br> </br> 
	আমি নিম্নে স্বাক্ষরকারী সিদীপ হতে ইকুইপমেন্ট ক্রয়ের জন্য  <?php echo $info->loan_amount ;?> টাকা ঋণ নিতে ইচ্ছুক। নিম্নে বিস্তারিত বিবরণ দেয়া হলোঃ  </br></br> 
	১. সিদীপ-এ যোগদানের তারিখ:  <?php echo date('d-m-Y', strtotime($info->br_joined_date)); ?></br>
	২. স্থায়ীকরণের তারিখ:   <?php echo date('d-m-Y', strtotime($info->effect_date)); ?></br>
	৩. ইকুইপমেন্ট এর বিবরণ:  <?php echo $info->loan_purpose;?></br>
	৪. ঋণ আবেদনের পরিমাণ :  <?php echo $info->loan_amount;?></br>
	৫. ব্যাংক হিসাবের বিবরণ : (ইংরেজীতে) : </br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A) Name (Account Holder):  <?php echo $info->accounts_holder;?></br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B) Bank Name: <?php echo $info->bank_name;?></br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C) Account Number: <?php echo $info->accounts_number;?></br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D) Branch: <?php echo $info->bank_branch_name;?></br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E) Routing Number: <?php echo $info->routing_number;?></br></br>
		আমি অঙ্গীকার করছি যে, আমি ইকুইপমেন্ট ক্রয়ের জন্য গৃহিত মোট ঋণের দ্বারা ইকুইপমেন্ট ক্রয় করব এবং  সম্পূর্ন ঋণের টাকা নীতিমালা মোতাবেক পে-রোলের মাধ্যমে পরিশোধ করবো। 
		এছাড়া এই ঋণের কিস্তি চলমান থাকাকালীন সময়ে আমি চাকুরী থেকে অব্যাহতি নিলে অথবা আমাকে চাকুরী থেকে >অব্যাহতি প্রদান করা হলে সেক্ষেত্রে ঋণের অবশিষ্ট টাকা  
		আমার চূড়ান্ত দেনা-পাওনা হতে স্বয়ংক্রিয় ভাবে পরিশোধযোগ্য হবে বা আমি পরিশোধ করবো। এছাড়া ভবিষ্যতে ইকুইপমেন্ট ঋণ সংক্রান্ত যে কোন সিদ্ধান্ত নেয়া হলে আমি সেসব সিদ্ধান্ত মেনে চলতে বাধ্য থাকবো। 
		<style>
			.footer {
			  max-width: 200px;
			  min-width:200px;
			  display:inline-block;
			  vertical-align: top;
			}
		</style>
		<br>
		<br>
		<br>
		<br>
		<br>
		<div class="footer">
			<p> 
				আবেদনকারীর স্বাক্ষর :  <br>
				নাম :  <br>
				আইডি নং :  <br>
			</p>
		</div>
		<div class="footer" style="float: right; margin-right:50px;">
			<p> 
				সুপারিশকারীর স্বাক্ষর:  <br>
				নাম :  <br>
				আইডি নং :  <br>
			</p>
		</div>
	</div>
	
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




