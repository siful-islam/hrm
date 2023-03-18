<?php $__env->startSection('title', 'My Benefit'); ?>
<?php $__env->startSection('main_content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Self<small>Care</small></h1>
    </section>
    <section class="content-header">
        <a href="<?php echo e(URL::to('/profile')); ?>">
            <h5><i class="fa fa-arrow-left" aria-hidden="true"></i> Self Care</h5>
        </a>
    </section>
    <style>
        #status_table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        #status_table td,
        #status_table tr:hover {
            background-color: rgb(255, 254, 254);
        }
        #status_table th {
            padding-top: 6px;
            padding-bottom: 6px;
            text-align: center;
            background-color: #3c8dbc;
            color: white;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="nav-tabs-custom">
            <div class="tab-content">
                <div class="post">
                    <div class="user-block">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="table-responsive">
								<table align="center" border="0" style="font-family: 'Source Sans Pro',sans-serif;">
									<tr>
										<td style="vertical-align: bottom;"><img style="width: 40px; height: 40px;" src="<?php echo e(asset('public/org_logo/cdip.png')); ?>"> </td>
										<td>&nbsp;</td>
										<td style="vertical-align: middle;" valign="baseline"><h4>Centre for  Development Innovation and Practices (CDIP)</h4></td>
									<tr>
								</table>
                                <hr>
                                <table width="100%" border="0">
                                    <tr>
                                        <td>Employee ID </td>
                                        <td>: </td>
                                        <td>&nbsp;&nbsp;<?php echo e($emp_id); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Name</td>
                                        <td>: </td>
                                        <td>&nbsp;&nbsp;<?php echo e($emp_name); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Designation</td>
                                        <td>: </td>
                                        <td>&nbsp;&nbsp;<?php echo e($designation_name); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Grade</td>
                                        <td>: </td>
                                        <td>&nbsp;&nbsp;<?php echo e($grade_name); ?></td>
                                    </tr>
									<tr>
                                        <td>Unit</td>
                                        <td>: </td>
                                        <td>&nbsp;&nbsp;<?php echo e($emp_mapping->unit_name); ?></td>
                                    </tr>
									<tr>
                                        <td>Department</td>
                                        <td>: </td>
                                        <td>&nbsp;&nbsp;<?php echo e($emp_mapping->department_name); ?></td>
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
                                        <td>&nbsp;&nbsp;<?php echo e($branch_name); ?></td>
                                    </tr>
									<?php if($emp_id < 200000)  { ?>
                                    <tr>
                                        <td>PF Number</td>
                                        <td>: </td>
                                        <td>&nbsp;&nbsp;<?php echo e($emp_id); ?></td>
                                    </tr>
									<?php } ?>
                                </table>
								<?php if($emp_id < 200000)  { ?>
                                <center>
                                    <h4><b>Provident Fund Status</b></h4>
                                </center>
                                <hr>
								<?php 
								
								if($pf_opening_infos) 
								{ 
									$opening_balance_staff = $pf_opening_infos->opening_balance_staff;
									$opening_balance_org = $pf_opening_infos->opening_balance_org;
									
									$opening_balance_interest_staff = $pf_opening_infos->interest_amount_stuff;
									$opening_balance_interest_org = $pf_opening_infos->interest_amount_org;
								}
								else
								{
									$opening_balance_staff = 0;
									$opening_balance_org = 0;
								} 
								
								?>
                               <table class="table table-bordered">
                                    <tr style="background-color: #3c8dbc; color: white;">
                                        <th>Particulars</th>
                                        <th>Opening (Year-July'2021)</th>
                                        <th>Current Year Contribution</th>
                                        <th>Balance as of <?php if($pf_info->for_month != '') { echo date("M-Y", strtotime($pf_info->for_month));  } ?></th>
                                    </tr>
                                    <tr>
                                        <td>Own Contribution</th>
                                        <td class="text-right"><?php echo e(number_format($opening_balance_staff)); ?></td>
                                        <td class="text-right"><?php echo e(number_format($pf_info->total_self_fund)); ?></td>
                                        <td class="text-right">
                                            <?php echo e(number_format($my_principal_total = $opening_balance_staff + $pf_info->total_self_fund)); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Own Interest</th>
                                        <td class="text-right"><?php echo e(number_format(@$opening_balance_interest_staff)); ?></td>
                                        <td class="text-right"> <?php echo e(number_format(@$pf_info->total_interest_amount_stuff)); ?>

                                        </td>
                                        <td class="text-right">
                                            <?php echo e(number_format($my_interst_total = @$opening_balance_interest_staff + @$pf_info->interest_amount_stuff)); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th>My Total</th>
                                        <th class="text-right">
                                            <?php echo e(number_format($my_total_opening = @$opening_balance_staff + @$opening_balance_interest_staff)); ?>

                                        </th>
                                        <th class="text-right">
                                            <?php echo e(number_format($my_total_curent_year = @$pf_info->total_self_fund + @$pf_info->total_interest_amount_stuff)); ?>

                                        </th>
                                        <th class="text-right">
                                            <?php echo e(number_format($my_total_as_off = @$my_principal_total + @$my_interst_total)); ?>

                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Organization Contribution</td>
                                        <td class="text-right"><?php echo e(number_format($opening_balance_org)); ?></td>
                                        <td class="text-right"><?php echo e(number_format(@$pf_info->total_org_fund)); ?></td>
                                        <td class="text-right">
                                            <?php echo e(number_format($org_contribition_total_opening = @$opening_balance_org + @$pf_info->total_org_fund)); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Organization Interest</td>
                                        <td class="text-right"><?php echo e(number_format(@$opening_balance_interest_org)); ?></td>
                                        <td class="text-right"><?php echo e(number_format(@$pf_info->total_interest_amount_org)); ?></td>
                                        <td class="text-right">
                                            <?php echo e(number_format($org_total_interest = @$opening_balance_interest_org + @$pf_info->total_interest_amount_org)); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Undistributed Contribution <br> + interest</td>
                                        <td class="text-right"><?php echo e(number_format($undistribute_org_contribute_opening = 0)); ?>

                                        </td>
                                        <td class="text-right">
                                            <?php echo e(number_format($undistribute_org_contribute_curent_year = $undistribute->undistributed_staff+$undistribute->undistributed_org)); ?>

                                        </td>
                                        <td class="text-right">
                                            <?php echo e(number_format($undistribute_total = @$undistribute_org_contribute_opening + @$undistribute_org_contribute_curent_year)); ?>

                                        </td>
                                    </tr>
									<tr>
                                        <th>CDIP Total</th>
                                        <th class="text-right">
                                            <?php echo e(number_format($org_total_opening = $opening_balance_org + @$opening_balance_interest_org + $undistribute_org_contribute_opening)); ?>

                                        </th>
                                        <th class="text-right">
                                            <?php echo e(number_format($org_total_curent_year = @$pf_info->total_org_fund + @$pf_info->total_interest_amount_org + $undistribute_org_contribute_curent_year)); ?>

                                        </th>
                                        <th class="text-right">
                                            <?php echo e(number_format($org_total_as_off = $org_contribition_total_opening + $org_total_interest + $undistribute_total)); ?>

                                        </th>
                                    </tr>
									
                                    <tr style="color:blue;">
                                        <th>Grand Total</th>
                                        <th class="text-right">
                                            <?php echo e(number_format($grand_total_opening = $my_total_opening + $org_total_opening)); ?>

                                        </th>
                                        <th class="text-right">
                                            <?php echo e(number_format($grand_total_curent_year = $my_total_curent_year + $org_total_curent_year)); ?>

                                        </th>
                                        <th class="text-right">
                                            <?php echo e(number_format($grand_total_as_off = $my_total_as_off + $org_total_as_off)); ?>

                                        </th>
                                    </tr>
                                </table>
		
                                <center>
                                    <h4><b>Gratuity Status</b></h4>
                                </center>
                                <hr>
                                <table class="table table-bordered">
                                    <tr style="background-color: #3c8dbc; color: white;">
                                        <th>Service Length</th>
                                        <th>Gratuity Amount</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo e($service_length); ?></th>
                                        <th class="text-right"><?php echo e(number_format($gratuity)); ?></th>
                                    </tr>
                                </table>

                                <center>
                                    <h4><b>Others</b></h4>
                                </center>
                                <hr>
                                <table class="table table-bordered">
                                    <tr style="background-color: #3c8dbc; color: white;">
                                        <th class="text-center">Death Coverage Amount</th>
                                        <th class="text-center">Security Deposit with interest</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center"> 
											<?php if (isset($death_coverage)) {
                                            $death_coverage = $death_coverage->closing_balance;
                                            } else {
                                            $death_coverage = 0;
                                            } ?>
											<?php if (isset($security)) {
                                            $security = $security->security_ending_balance;
                                            } else {
                                            $security = 0;
                                            } ?>
											<?php echo e(number_format($death_coverage)); ?> </th>
                                        <th class="text-center"><?php echo e(number_format($security)); ?>

                                        </th>
                                    </tr>
                                </table>
								
								<?php } else { ?>
								<hr>
								<center>
                                    <h4>No Data Available</h4>
                                </center>
								
								<?php } ?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
	
    <script>
        //To active  menu.......//
        $(document).ready(function() {
            $("#MainGroupSelf_Care").addClass('active');
            $("#My_Benefits").addClass('active');
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>