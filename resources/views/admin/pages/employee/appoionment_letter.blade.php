@extends('admin.admin_master')
@section('main_content')


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Form Elements<small>Preview</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Forms</a></li>
			<li class="active">Advanced Elements</li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content">
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> {{$Heading}}</h3>
				<button type="button" onclick="javascript:printDiv('appoint_letter')" class="btn btn-danger pull-right"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			
				
			<div id="appoint_letter" style="width: 800px; margin: auto;  font-size:12px">
				<table align="center">
					<tr>
						<td rowspan="4"><img src="{{asset('public/cdip.png')}}" width="60"></td>
						<td align="center"><h4>Center for Development innovation and Practices (CDIP)</h4></td>
					</tr>
					<tr>
						<td align="center"><h4>সেন্টার ফর ডেভেলপমেন্ট ইনভেশন এন্ড প্রাকটিসেস ( সিদীপ ) </h4></td>
					</tr>
					<tr>
						<td align="center">সিদীপ ভবন, হাউস # ১৭, রোড # ১৩, পিসিকালচার হাউজিং সোসাইটি , সেখেরটেক, আদাবর, ঢাকা। </td>
					</tr>
					<tr>
						<td align="center">Web: www.cdipbd.org, Email: cdipbd@gmail.com, Phone: 9141891, 9141893</td>
					</tr>
				</table>				
				<h4 align="center"><u>নিয়োগপত্র</u></h4>
				<h4 style="-webkit-transform:rotate(-30deg);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				আইডি নং: {{$emp_id}}</h4>
				তারিখঃ <span id="appoinment_letter_date">{{$letter_date}}</span><br>
				প্রতি,
				<br>
				<span id="appoinment_emp_name">{{$emp_name}}</span>
				<br>
				পিতা - <span id="appoinment_father_name">{{$father_name}}</span>
				<br>
				গ্রাম -   <span id="appoinment_emp_village">{{$emp_village}}</span>
				<br>
				পোঃ -   <span id="appoinment_emp_po">{{$emp_po}}</span>
				<br>
				উপজেলা - <span id="appoinment_emp_thana">{{$emp_thana}}</span>
				<br>
				জেলা -  <span id="appoinment_emp_district">{{$emp_district}}</span>
				<br>
				<br>
				<br>
				জনাব,
				<br><br>
				আপনার আবেদন ও সাক্ষাতের ভিত্তিতে আপনাকে ' <span id="appoinment_emp_designation">{{$emp_designation}}</span> ' পদে নিম্নলিখিত শর্তে অস্থায়ীভাবে নিয়োগ দেয়া হলো। 
				<br>
				<br>
				<br>
				<ol>
					<li> আপনাকে সংস্থায় ০৬ মাস শিক্ষানবিসকালিন (Probation Period)দায়িত্ব পালন করতে হবে।  </li> 
					<li>  শিক্ষানবিস সময়ে (Probation Period) আপনাকে  মাসিক সর্বসাকুল্যে <span id="appoinment_gross_salary">{{$gross_salary}}</span> /- টাকা বেতন দেয়া হবে।
						<span id="appoinment_period">{{$period}}</span>  মাস শিক্ষানবিসকাল (Probation Period) শেষে স্থায়ীকরনের জন্য আপনাকে আবেদন করতে হবে।
						আপনার কাজের মান কতৃপক্ষের নিকত সন্তসজনক বিবেচিত হলে তাদের সুপারিশের ভিত্তিতে আপনাকে  
						স্থায়ী করা হবে এবং সংস্থার নিয়ম অনুযায়ী নির্ধারিত বেতন স্কেলে বেতন-ভাতা প্রদান করা হবে। </li> 
					<li> আপনি সংস্থার নিয়ম অনুযায়ী ' উৎসব ভাতা ' পাবেন। </li> 
					<li>  সংস্থার নিয়ম অনুসারে ছুটি ভোগ করতে পারবেন। </li> 
					<li> আপনাকে সংস্থার সর্ব প্রকার নিয়ম-নিতি মেনে চলতে হবে। </li> 
					<li> শিক্ষানবিসকালিন সময়ে (Probation Period) আপনাকে বিনা ক্ষতিপূরণে, বিনা নোটিশে চাকরি হতে অব্যাহতি দেয়া যাবে। </li> 
					<li>  চাকরি হতে পদত্যাগ চাইলে একমাস পূর্বে লিখিত ভাবে জানাতে হবে অন্যথায় একমাসের মূল বেতনের সমপরিমাণ 
						টাকা নোটিশ -পে হিসেবে কর্তন হবে অথবা সংস্থা ইচ্ছা করলে আপনাকে একমাসের বেতনের সমপরিমাণ টাকা 
						নোটিশ -পে দিয়ে চাকরি হতে অব্যাহতি প্রদান করতে পারবে। </li> 
					<li> ভবিষ্যতে সংস্থা কত্রিক নিয়োগ সংক্রান্ত বিষয়ে কোন পরিবর্তন আনা হলে তা মেনে নিয়ে সংস্থার চাহিদা মোতাবেক 
						প্রয়োজনীয় ডকুমেন্ট সরবরাহ করতে বাধ্য থাকবেন। ডকুমেন্টস সরবরাহে ব্যথতার কারনে আপনার নিয়োগ 
						সংস্থা কত্রিক বাতিল করার প্রয়োজনীয়তা দেখা দিলে সেক্ষেত্রে আপনার কোন ওজর আপত্তি গ্রহণযোগ্য হবে না। </li> 
					<li> আপনি আপনার কাজের জন্য <span id="appoinment_reported_to">{{$reported_to}}</span> এর নিকট দায়বদ্ধ থাকবেন। </li> 
					<li><span id="appoinment_letter_body">{{$letter_body}}</span></li>
				</ol>					
				<br>
				<br>
				ধন্যবাদান্তে,
				<br>
				<br>
				<br>
				<b>মোহাম্মাদ ইয়াহিয়া</b>
				<br>
				নির্বাহী পরিচালক
				<br>
				<br>
				<br>
				উপরক্ত শর্তাবলী আপনার নিকট গ্রহণযোগ্য হলে '<span id="appoinment_emp_designation2">{{$emp_id}}</span>' পদে অদ্য <span id="appoinment_joining_date">{{$emp_id}}</span> তারিখে সংস্থার <span id="appoinment_joining_branch">{{$emp_id}}</span>
				ব্রাঞ্ছের <span id="appoinment_emp_department">{{$emp_id}}</span>  যোগদান করবেন। 
				<br><br>
				<u><b>অনুলিপিঃ</b></u>
				<br><br>
				১. পরিচালক (প্রোগ্রাম)।
				<br>
				২.<span id="appoinment_emp_department2">{{$emp_id}}</span>
				<br>
				৩. হিসাব বিভাগ।
				<br>
				৪. ব্যক্তিগত ফাইল। 
				<br>
				<br>
				<br>
			</div>

		</div>
	</section>

	
<script language="javascript" type="text/javascript">
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