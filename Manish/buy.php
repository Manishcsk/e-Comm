<?php 
	session_start();
	include "include/db.php"; 
	if(isset($_GET['chk_prod_id'])){
		$date=date('Y-m-d h:i:s');
		$rand_num=mt_rand();
		if(isset($_SESSION['ref'])){
			
		}
		else {
			$_SESSION['ref']=$date.'_'.$rand_num;
		}
		$chk_sql="INSERT INTO checkout (chk_prod,chk_ref,chk_timing,chk_qty) VALUES ('$_GET[chk_prod_id]','$_SESSION[ref]','$date',1)";
		if(mysqli_query($conn,$chk_sql)) {
			?> <script>window.location='buy.php'</script> <?php
		}
	}
	
	if(isset($_POST['order_submit'])) {
		$name=mysqli_real_escape_string($conn,strip_tags($_POST['name']));
		$email=mysqli_real_escape_string($conn,strip_tags($_POST['email']));
		$contact=mysqli_real_escape_string($conn,strip_tags($_POST['contact']));
		$state=mysqli_real_escape_string($conn,strip_tags($_POST['state']));
		$delivery_address=mysqli_real_escape_string($conn,strip_tags($_POST['delivery_address']));
		
		$order_ins_sql="INSERT INTO orders (order_name,order_email,order_contact,order_state,order_delivery_address,order_checkout_ref) VALUES ('$name','$email','$contact','$state','$delivery_address','$_SESSION[ref]') ";
		mysqli_query($conn,$order_ins_sql);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Shopping Cart</title>
		<link rel="stylesheet" href="css/bootstrap.css">
		
		<link rel="stylesheet" href="css/font-awesome.css">
		<link rel="stylesheet" href="css/lightbox.css">
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/lightbox.js"></script>
		<script>
			function ajax_func() {
				xmlhttp=new XMLHttpRequest();
				
				xmlhttp.onreadystatechange=function() {
					if(xmlhttp.readyState==4 && xmlhttp.status==200) {
						document.getElementById('get_processed_data').innerHTML = xmlhttp.responseText;
					}
				}
				xmlhttp.open('GET','buy_process.php',true);
				xmlhttp.send();
			}
			
			function del_func(chk_id) {
					xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState==4 && xmlhttp.status==200){
						document.getElementById('get_processed_data').innerHTML = xmlhttp.responseText;
					}
				}
				xmlhttp.open('GET','buy_process.php?chk_del_id='+chk_id,true);
				xmlhttp.send();
			}
			
			function up_chk_qty(chk_qty,chk_id) {
				xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState==4 && xmlhttp.status==200){
						document.getElementById('get_processed_data').innerHTML = xmlhttp.responseText;
					}
				}
				if(chk_qty==0)
					chk_qty=1;
				chk_qty=Math.abs(chk_qty);
				xmlhttp.open('GET','buy_process.php?up_chk_qty='+chk_qty+'&up_chk_id='+chk_id,true);
				xmlhttp.send();
			}
		</script>
	</head>
	<body onLoad="ajax_func();">
		<?php include 'include/header.php'; ?>
		<div class="container">
			<div class="page-header">
				<h2 class="pull-left">Checkout</h2>
				<div class="pull-right"><button class="btn btn-success" data-toggle="modal" data-target="#proceed_modal" data-backdrop="static" data-keyboard="false">Proceed</button></div>
				<!-- The Proceed Form Modal-->
				<div id="proceed_modal" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
								<form method="post">
									<div class="form-group">
										<label for="name">Name</label>
										<input type="text" id="name" name="name" class="form-control" placeholder="Full Name">
									</div>
									<div class="form-group">
										<label for="email">Email address</label>
										<input type="email" id="email" name="email" class="form-control" placeholder="Email">
									</div>
									<div class="form-group">
										<label for="contact">Contact Number</label>
										<input type="text" id="contact" name="contact" class="form-control" placeholder="Contact Number">
									</div>
									<div class="form-group">
										<label for="state">State</label>
										<input list="states" name="state" id="state" class="form-control">
										<datalist id="states" >
											<option>Washington</option>
											<option>New York</option>
											<option>Florida</option>
											<option>Kansas<option>
											<option>Nebraska<option>
											<option>Origon<option>
											<option>Indiana<option>
											<option>Ohio<option>
										</datalist>
									</div>
									<div class="form-group">
										<label for="address">Delivery Address</label>
										<textarea class="form-control" name="delivery_address" ></textarea> 
									</div>
									<div class="form-group">
										<input type="submit" name="order_submit" class="btn btn-danger btn-block" >
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
							
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Order Details</div>
				<div class="panel-body" id="get_processed_data">
						
							<!-- The BUy Process-->
					
				</div>
			</div>
		</div>
		<br><br><br><br>
		<?php include 'include/footer.php'; ?>
	</body>
</html>