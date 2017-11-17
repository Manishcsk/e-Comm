<?php include "../include/db.php";
	if(isset($_REQUEST['order_status'])) {
		$up_sql="UPDATE orders SET order_status ='$_REQUEST[order_status]' WHERE order_id='$_REQUEST[order_id]'";
		mysqli_query($conn,$up_sql);
	}
	if(isset($_REQUEST['return_status'])) {
		$up_sql="UPDATE orders SET return_status ='$_REQUEST[return_status]' WHERE order_id='$_REQUEST[order_id]'";
		mysqli_query($conn,$up_sql);
	}
 ?>
<table class="table table-bordered table-striped">
				<thead>
					<tr class="table-head">
						<th>S.No.</th>
						<th>Buyer Name</th>
						<th>Buyer Email</th>
						<th>Buyer Contact</th>
						<th>Buyer State</th>
						<th>Delivery Address</th>
						<th>Order Ref</th>
						<th class="text-right">Total payment</th>
						<th >Order Status</th>
						<th >Return Status</th>
					<tr>
				</thead>
				<tbody>
					<?php
						$sql="SELECT * FROM orders";
						$run=mysqli_query($conn,$sql);
						$c=1;
						while($rows=mysqli_fetch_assoc($run)) {
							if($rows['order_status']==0){
								$btn_class="btn-warning";
								$btn_value="Pending";
							}
							else {
								$btn_class="btn-success";
								$btn_value="Sent";
							}
							if($rows['return_status']==1){
								$ret_btn_class="btn-danger";
								$ret_btn_value="Returned";
							}
							else {
								$ret_btn_class="btn-primary";
								$ret_btn_value="No Return";
							}
							echo "
								<tr>
									<td>$c</td>
									<td>$rows[order_name]</td>
									<td>$rows[order_email]</td>
									<td>$rows[order_contact]</td>
									<td>$rows[order_state]</td>
									<td>$rows[order_delivery_address]</td>
									<td>
										<button class='btn btn-info' data-toggle='modal' data-target='#order_chk_modal$rows[order_id]'>$rows[order_checkout_ref]</button>
										<div class='modal fade' id='order_chk_modal$rows[order_id]'>
											<div class='modal-dialog'>
												<div class='modal-content'>
													<div class='modal-header'>Header</div>
													<div class='modal-body'>
														<table class='table'>
															<thead>
																<tr>
																	<th>S.No.</th>
																	<th>Product</th>
																	<th>Qty</th>
																	<th class='text-right'>Price</th>
																	<th class='text-right'>Sub Total</th>
																</tr>
															</thead>
															<tbody>";
															$chk_sql="SELECT *FROM checkout c JOIN products p ON c.chk_prod=p.prod_id  WHERE c.chk_ref='$rows[order_checkout_ref]'";
															$chk_run=mysqli_query($conn,$chk_sql);
															$del_chrg=0;
															while($chk_rows=mysqli_fetch_assoc($chk_run)) {
																$del_chrg+=$chk_rows['prod_del_chrg'];
																echo "
																<tr>
																	<td>1</td>
																	<td>$chk_rows[prod_title]</td>
																	<td class='text-right'>$chk_rows[chk_qty]</td>
																	<td class='text-right'>$chk_rows[prod_price]</td>
																	<td class='text-right'>".$chk_rows['chk_qty']*$chk_rows['prod_price']."</td>
																</tr>";
															}
															echo "
															</tbody>
														</table>
														<table class='table'>
															<thead>
																<tr>
																	<th colspan='2' class='text-center'>Order Summary</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>Delivery Charges</td>
																	<td class='text-right'>$del_chrg</td>
																</tr>
																<tr>
																	<td>Grand Total</td>
																	<td class='text-right'>$rows[order_total]</td>
																</tr>
															</tbody>
														</table>
													</div>
													<div class='modal-footer'>Footer</div>
												</div>
											</div>
										</div>
									</td>
									<td class='text-right'>$rows[order_total]/=</td>"; ?>
									<td class='text-center'><button onclick="order_status(<?php echo $rows['order_status'].','.$rows['order_id'];  ?>);" class='btn btn-block btn-sm <?php echo $btn_class; ?>'><?php echo $btn_value; ?></button></td>
									<td class='text-center'><button onclick="return_status(<?php echo $rows['return_status'].','.$rows['order_id']; ?>);" class='btn btn-block btn-sm <?php echo $ret_btn_class; ?>'><?php echo $ret_btn_value; ?></button></td>
								</tr>
							<?php 
							$c++;
						}
					?>
				</tbody>
			</table>