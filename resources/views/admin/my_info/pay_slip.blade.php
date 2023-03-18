        <!-- Main content -->
		<style>
			.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
				padding: 3px !important;
			}
		</style>
        <!-- title row -->
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
               <table align="center" border="0">
					<tr>
						<td style="vertical-align: bottom;"><img style="width: 40px; height: 40px;" src="{{ asset('public/org_logo/cdip.png') }}"> </td>
						<td>&nbsp;</td>
						<td style="vertical-align: middle;" valign="baseline"><h4>Centre for  Development Innovation and Practices (CDIP)</h4></td>
					<tr>
					<tr>
						<td colspan="3" align="center"><h5>Pay Slip</h5></td>
					</tr>
				</table>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
		<hr>
        <div class="row invoice-info">
            <div class="col-md-6 col-md-offset-3">
				<table width="100%">
					<tr>
						<td>Employee ID </td>
						<td>: </td>
						<td>&nbsp;&nbsp;{{ $emp_id }}</td>
					</tr>
					<tr>
						<td>Name</td>
						<td>: </td>
						<td>&nbsp;&nbsp;{{ $emp_name }}</td>
					</tr>
					<tr>
						<td>Designation</td>
						<td>: </td>
						<td>&nbsp;&nbsp;{{ $designation_name }}</td>
					</tr>
					<tr>
						<td>Grade</td>
						<td>: </td>
						<td>&nbsp;&nbsp;{{ $grade_name }}</td>
					</tr>
					<tr>
						<td>Unit</td>
						<td>: </td>
						<td>&nbsp;&nbsp;{{ $emp_mapping->unit_name }}</td>
					</tr>
					<tr>
						<td>Department</td>
						<td>: </td>
						<td>&nbsp;&nbsp;{{ $emp_mapping->department_name }}</td>
					</tr>
					<tr>
						<td>Program</td>
						<td>: </td>
						<td>&nbsp;&nbsp;<?php echo $emp_mapping->current_program_id == 1 ? 'Microfinance' : 'Special Program'; ?> 
						</td>
					</tr>
					<tr>
						<td>Branch</td>
						<td>: </td>
						<td>&nbsp;&nbsp;{{ $branch_name }}</td>
					</tr>
					<tr>
						<td>Pay Slip for Month</td>
						<td>: </td>
						<td>&nbsp;&nbsp;{{ $salary_month }}</td>
					</tr>
				</table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
       <br><br>
		
        <!-- Table row -->
        <div class="row">
            <div class="col-md-6 col-md-offset-3" style="border: 1px solid black;">
					<table class="table">
					<?php 
						/* echo '<pre>';
						print_r($extraAllowance);
						echo '</pre>'; */
					?>
						<tbody>
							<tr>
								<th colspan="2" style="border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;Salary and Allowance</th>
								<th style="border-right: 1px solid black;  border-bottom:1px solid white;">&nbsp;</th>
								<td style="border-right: 1px solid white;  border-bottom:1px solid white;">&nbsp;</td>
							</tr>
							<tr>
								<td style="border: 1px solid white;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td  style="border-right: 1px solid black; border-bottom:1px solid white; padding-right:3px !important; " >Basic Salary</td>
								<td class="text-right" style="border-right: 1px solid black; border-bottom:1px solid white;"><?php echo number_format($basic_salary); ?></td>
								<td style="border: 1px solid white;">&nbsp;</td>
							</tr>
							<?php  $totalEarnings = 0; $totalDeduction = 0;
								foreach($salary_allowance as $key=>$salary_plus){
								if($salary_plus>0){
							?>
							<tr>
								<td style="border: 1px solid white;">&nbsp;</td>
								<td  style="border-right: 1px solid black; border-bottom:1px solid white;" ><?php echo $key; ?></td>
								<td class="text-right" style="border-right: 1px solid black; border-bottom:1px solid white;"><?php echo number_format($salary_plus); ?></td>
								<td style="border: 1px solid white;">&nbsp;</td>
							</tr>
							<?php } } ?>
							<tr>
								<td style="border: 1px solid white;">&nbsp;</td>
								<th colspan="" style="border-right: 1px solid black; border-bottom:1px solid white;">Total Salary</th>
								<td style="border-right: 1px solid black; border-bottom:1px solid white;">&nbsp;</td>
								<th class="text-right" style="border: 1px solid white;"><?php echo number_format($totalEarnings=(array_sum($salary_allowance)+$basic_salary));?> </th>
							</tr>
							
							<tr>
								
								<th colspan="2" style="border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;Deduction</th>
								<th style="border-right: 1px solid black;  border-bottom:1px solid white;">&nbsp;</th>
								<td style="border-right: 1px solid white;  border-bottom:1px solid white;">&nbsp;</td>
								
							</tr>
							<?php foreach($diductions as $key=>$salary_minus){
							if($salary_minus>0){ ?>
							<tr>
								<td style="border: 1px solid white;">&nbsp;</td>
								<td style="border-right: 1px solid black; border-bottom:1px solid white;"><?php echo $key; ?></td>
								<td class="text-right" style="border-right: 1px solid black; border-bottom:1px solid white;"><?php echo number_format($salary_minus); ?></td>
								<td style="border: 1px solid white;">&nbsp;</td>
							</tr>
							<?php } } ?>
							<tr>
								<td style="border-right: 1px solid white; border-bottom:2px solid black;">&nbsp;</td>
								<th colspan="" style="border-right: 1px solid black; border-bottom:2px solid black;">Total Deduction</th>
								<th colspan="" style="border-right: 1px solid black; border-bottom:2px solid black;">&nbsp;</th>
								<th class="text-right" style="border-bottom:2px solid black;"><?php  echo number_format($totalDeduction= array_sum($diductions));?></th>
							</tr>
							<tr>
								<th colspan="3" class="text-left">Net Salary</th>
								<th class="text-right"><?php echo number_format($net_salary = $totalEarnings - $totalDeduction);?></th>
							</tr>
							<tr>
								<input type="hidden" id="number"
                                value="<?php echo $net_salary; ?>">
								<td colspan="4" class="text-left"><b>Taka in Words : </b><span id="words">---<span></td>
							</tr>
						</tbody> 
					</table>
            </div>

			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<p class="text-muted well well-sm no-shadow" style="margin-top: 10px; text-align:center;">
						This is computer generated statement.
					</p>
					
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<table class="table">
						<tr>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;Print Date : <?php echo date('m/d/Y'); ?></td>
						</tr>
					<table>
				</div>
			</div>
			<div class="row no-print">
				<div class="col-md-6 col-md-offset-3">
					<button type="button" class="btn btn-default pull-right" style="margin-right: 5px;"
						onClick="printDiv('dynamic_content');">
						<i class="fa fa-print"></i> Print
					</button>
				</div>
			</div>
        </div>
  
        <script>
            var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ',
                'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ',
                'nineteen '
            ];
            var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

            function inWords(num) {
                if ((num = num.toString()).length > 9) return 'overflow';
                n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/); 
                if (!n) return;
                var str = '';
                str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
                str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
                str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
                str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
                str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) +
                    'taka only. ' : '';
                //return str;
				const capitalized = str.charAt(0).toUpperCase() + str.slice(1);
				return capitalized;
            }
			
			
	
            document.getElementById('words').innerHTML = inWords(document.getElementById('number').value);

        </script>
