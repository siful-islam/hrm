
<?php $__env->startSection('title', 'Staff Security'); ?>
<?php $__env->startSection('main_content'); ?>


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
				<h3 class="box-title"> Money Receipt</h3>
				
				<button class="btn btn-sm btn-danger" title="Print" onclick="javascript:printDiv('printme')"><i class="glyphicon glyphicon-print"></i> Print</button>
			</div>
			<!-- /.box-header -->

			<div class="box-body">
			
				<div id="printme">
				
					<?php for($i = 1; $i<4; $i++) { ?>
					
					<?php 
					if($i == 1) 
					{
						$copy = 'Office Copy';
					}elseif($i == 2)
					{
						$copy = 'Finance Copy';
					}else{
						$copy = 'Owner Copy';
					}
					
					?>
					
					<div>
						
						<table align="center">
							<tr>
								<td rowspan="3"><img src="<?php echo e(asset(Session::get('org_logo'))); ?>" class="user-image" alt="Image" width="60"> </td>
								<td align="center"><h4> Centre for Development Innovation and Practices (CDIP) </h4></td>
							</tr>
							<tr>
								<td align="center"><h5> সেন্টার ফর ডেভেলপমেন্ট ইনোভেশন এন্ড প্র্যাকটিসেস ( সিদীপ ) </h5></td>
							</tr>
							<tr>
								<td align="center"> সিদীপ ভবন, হাউস - ১৭, রোড - ১৩, পিসিকালচার হাউজিং সোসাইটি , শেখেরটেক, আদাবর, ঢাকা।  </td>
							</tr>
						</table>

						<center><h4>Money Receipt (<?php echo $copy; ?>) </h4></center>
						
						<hr style="border: 0.5px solid black;">
						
						<table width="100%" align="center">
							<tr>
								<td width="20%">Voucher No: </td>
								<td width="40%"><?php echo e($id); ?></td>
								<td width="20%">Date: </td>
								<td width="40%"><?php echo e($diposit_date); ?></td>
							</tr>
							
							<tr>
								<td>Employee Name: </td>
								<td><?php echo e($emp_name); ?></td>
								<td>Employee ID: </td>
								<td><?php echo e($emp_id); ?> </td>
							</tr>
							<tr>
								<td>Purpose: </td>
								<td>Security Deposit</td>
								<td>Amount: </td>
								<td><span id="amount"><?php echo e($diposit_amount); ?></span> Tk.</td>
							</tr>
							<tr>
								<td>Amount (In words): </td>
								<td colspan="3" id="in_Words_<?php echo $i;?>"></td>
							</tr>
						</table>
						</br></br></br></br>
						<table width="90%" align="center">
							<tr>
								<td>-------------------------------</td>
								<td>-------------------------------</td>
								<td>-------------------------------</td>

							</tr>					
							<tr>
								<td>Signature of Depositor</td>
								<td>Signature of Receiver</td>
								<td>Entry By: <?php echo e($admin_name); ?></td>
							</tr>
						</table>
						<i class="fa fa-scissors" aria-hidden="true"></i>--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
					</div>
					
					<?php } ?>
					
					
				</div>
			
			</div>
			<!-- /.box-body -->
			
			</br></br>
			
			<div class="box-footer">
				
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
	
	<script>		

function NumToWord() {

 var inputNumber = document.getElementById("amount").innerHTML ;

    var str = new String(inputNumber);
    var splt = str.split("");
    var rev = splt.reverse();
    var once = ['Zero', ' One', ' Two', ' Three', ' Four', ' Five', ' Six', ' Seven', ' Eight', ' Nine'];
    var twos = ['Ten', ' Eleven', ' Twelve', ' Thirteen', ' Fourteen', ' Fifteen', ' Sixteen', ' Seventeen', ' Eighteen', ' Nineteen'];
    var tens = ['', 'Ten', ' Twenty', ' Thirty', ' Forty', ' Fifty', ' Sixty', ' Seventy', ' Eighty', ' Ninety'];

    numLength = rev.length;
    var word = new Array();
    var j = 0;

    for (i = 0; i < numLength; i++) {
        switch (i) {

            case 0:
                if ((rev[i] == 0) || (rev[i + 1] == 1)) {
                    word[j] = '';
                }
                else {
                    word[j] = '' + once[rev[i]];
                }
                word[j] = word[j];
                break;

            case 1:
                aboveTens();
                break;

            case 2:
                if (rev[i] == 0) {
                    word[j] = '';
                }
                else if ((rev[i - 1] == 0) || (rev[i - 2] == 0)) {
                    word[j] = once[rev[i]] + " Hundred ";
                }
                else {
                    word[j] = once[rev[i]] + " Hundred and";
                }
                break;

            case 3:
                if (rev[i] == 0 || rev[i + 1] == 1) {
                    word[j] = '';
                }
                else {
                    word[j] = once[rev[i]];
                }
                if ((rev[i + 1] != 0) || (rev[i] > 0)) {
                    word[j] = word[j] + " Thousand";
                }
                break;

                
            case 4:
                aboveTens();
                break;

            case 5:
                if ((rev[i] == 0) || (rev[i + 1] == 1)) {
                    word[j] = '';
                }
                else {
                    word[j] = once[rev[i]];
                }
                if (rev[i + 1] !== '0' || rev[i] > '0') {
                    word[j] = word[j] + " Lakh";
                }
                 
                break;

            case 6:
                aboveTens();
                break;

            case 7:
                if ((rev[i] == 0) || (rev[i + 1] == 1)) {
                    word[j] = '';
                }
                else {
                    word[j] = once[rev[i]];
                }
                if (rev[i + 1] !== '0' || rev[i] > '0') {
                    word[j] = word[j] + " Crore";
                }                
                break;

            case 8:
                aboveTens();
                break;

            //            This is optional. 

            //            case 9:
            //                if ((rev[i] == 0) || (rev[i + 1] == 1)) {
            //                    word[j] = '';
            //                }
            //                else {
            //                    word[j] = once[rev[i]];
            //                }
            //                if (rev[i + 1] !== '0' || rev[i] > '0') {
            //                    word[j] = word[j] + " Arab";
            //                }
            //                break;

            //            case 10:
            //                aboveTens();
            //                break;

            default: break;
        }
        j++;
    }

    function aboveTens() {
        if (rev[i] == 0) { word[j] = ''; }
        else if (rev[i] == 1) { word[j] = twos[rev[i - 1]]; }
        else { word[j] = tens[rev[i]]; }
    }

    word.reverse();
    var finalOutput = '';
    for (i = 0; i < numLength; i++) {
        finalOutput = finalOutput + word[i];
    }
    document.getElementById('in_Words_1').innerHTML = finalOutput+' Taka Only.';
    document.getElementById('in_Words_2').innerHTML = finalOutput+' Taka Only.';
    document.getElementById('in_Words_3').innerHTML = finalOutput+' Taka Only.';

}


NumToWord();

</script>

<script>
	$(document).ready(function() {
		$("#MainGroupSalary_Info").addClass('active');
		$("#Staff_Security").addClass('active');
	});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>