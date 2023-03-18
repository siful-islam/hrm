<div class="col-md-12">
						<div class="box box-solid">
							<div class="box-header with-border">
								<h3 class="box-title">Salary History of {{$emp_name}} from <select><option>Last</option><option>First</option></select></h3>
							</div>
							<!-- /.box-header -->
							<div class="box-body">
								<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
									<ol class="carousel-indicators">
										<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
										<li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
										<li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
									</ol>
									<div class="carousel-inner">
										
										<?php $i = 1;  foreach ($salary_history as $v_salary_history) { ?>
										
										<?php 
											if($i ==1 )
											{
												$class='item active';
											}
											else
											{
												$class='item';
											}
										?>
								
										<div class="<?php echo $class?>">
												<br>
												<br>
												<hr>
												<div class="col-sm-4">
													<div class="form-group">
														<label class="col-sm-6 control-label">Letter Date</label>
														<?php echo $v_salary_history->effect_date; ?>
													</div>
													<div class="form-group">
														<label class="col-sm-6 control-label">Trans sections</label>
														<?php echo $v_salary_history->transaction_name; ?>
													</div>
													<div class="form-group">
														<label class="col-sm-6 control-label">Basic Salary</label>
														<input type="text" readonly value="<?php echo $v_salary_history->salary_basic; ?>" style="text-align:right;">
													</div>
													<div class="form-group">
														<label class="col-sm-6 control-label">Plus Total</label>
														<input type="text" readonly value="<?php echo $v_salary_history->total_plus; ?>" style="text-align:right;">
													</div>
													<div class="form-group">
														<label class="col-sm-6 control-label">Payable</label>
														<input type="text" readonly value="<?php echo $v_salary_history->payable; ?>" style="text-align:right;">
													</div>
													<div class="form-group">
														<label class="col-sm-6 control-label">Minus Total</label>
														<input type="text" readonly value="<?php echo $v_salary_history->total_minus; ?>" style="text-align:right;">
													</div>
													<div class="form-group">
														<label class="col-sm-6 control-label">Net Payable</label>
														<input type="text" readonly value="<?php echo $v_salary_history->nit_payable; ?>" style="text-align:right;">
													</div>
												</div>												
												<div class="col-sm-4">
													<?php $plus_amount = explode(",",$v_salary_history->plus_item); $plus_items_id = 1; $total_plus = 0; foreach($plus_items as $v_plus_items) { ?>
													<div class="form-group">
														<label class="col-sm-6 control-label"><?php echo $v_plus_items->item_name; ?> (+):</label>
														<input type="text" readonly value="<?php echo $amount_plus = $plus_amount[$plus_items_id-1];  ?>" style="text-align:right;">
													</div>
													<?php 
													$plus_items_id++;
													$total_plus += $amount_plus;
													} ?>
												</div>
												<div class="col-sm-4">
													<?php $minus_amount = explode(",",$v_salary_history->minus_item); $minus_items_id = 1; $total_minus = 0; foreach($minus_items as $v_minus_items) { ?>
													<div class="form-group">
														<label class="col-sm-6 control-label"><?php echo $v_minus_items->item_name; ?> (-):</label>
														<input type="text" readonly value="<?php echo $amount_minus = $minus_amount[$minus_items_id-1];  ?>" style="text-align:right;">
													</div>
													<?php 
													$minus_items_id++;
													$total_minus += $amount_minus;
													} ?>
												</div>
												<div style="color:red;">Record : <?php echo $i. ' of '. count($salary_history); ?></div>
										</div>
										
										
										
										<?php $i++; } ?>
									</div>
									<a style="color:red;" class="left carousel-control" href="#carousel-example-generic" data-slide="prev">Prev</a>
									<a style="color:red;" class="right carousel-control" href="#carousel-example-generic" data-slide="next">Next </a>
								</div>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>