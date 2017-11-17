   <?php include "../include/db.php"; 
	if(isset($_POST['product_submit'])) {
		$prod_title=mysqli_real_escape_string($conn,strip_tags($_POST['prod_title']));
		$prod_desc=mysqli_real_escape_string($conn,$_POST['prod_desc']);
		$prod_cat=mysqli_real_escape_string($conn,strip_tags($_POST['prod_cat']));
		$prod_qty=mysqli_real_escape_string($conn,strip_tags($_POST['prod_qty']));
		$prod_cost=mysqli_real_escape_string($conn,strip_tags($_POST['prod_cost']));
		$prod_price=mysqli_real_escape_string($conn,strip_tags($_POST['prod_price']));
		$prod_disc=mysqli_real_escape_string($conn,strip_tags($_POST['prod_disc']));
		$prod_del_chrg=mysqli_real_escape_string($conn,strip_tags($_POST['prod_del_chrg']));
		if(isset($_FILES['prod_image']['name'])) {
			$file_name=mt_rand()."_".$_FILES['prod_image']['name'];
			$path_add="../images/product/$file_name";
			$prod_image="images/product/$file_name";
			$img_confirm=1;
			$file_type=pathinfo($_FILES['prod_image']['name'],PATHINFO_EXTENSION);
			if($_FILES['prod_image']['size']>200000) {
				$img_confirm=0;
				echo 'The size is very big';
			}
			if($file_type!='jpg' && $file_type!='jpeg' && $file_type!='png' && $file_type!='gif') {
				$img_confirm=0;
				echo 'Type is not matching';
			}
			if($img_confirm==0) {
				
			}else {
				if(move_uploaded_file($_FILES['prod_image']['tmp_name'],$path_add)) {
					$prod_ins_sql="INSERT INTO products (prod_image,prod_title,prod_desc,prod_cat,prod_quantity,prod_cost,prod_price,prod_disc,prod_del_chrg) VALUES ('$prod_image','$prod_title','$prod_desc','$prod_cat','$prod_qty','$prod_cost','$prod_price','$prod_disc','$prod_del_chrg')";
					$prod_ins_run=mysqli_query($conn,$prod_ins_sql);
				}
			}
		}
		else {
			echo "sorry";
		}
	}
?>
<!doctype html>
<html>
	<head>
		<title>Online shopping | Admin Panel</title>
		<link rel="stylesheet" href="../css/bootstrap.css">
		<link rel="stylesheet" href="../css/admin-styles.css">
		<link rel="stylesheet" href="../css/font-awesome.css">
		<link rel="stylesheet" href="../css/lightbox.css">
		<script src="../js/jquery.js"></script>
		<script src="../js/bootstrap.js"></script>
		<script src="../js/lightbox.js"></script>
		<script src="../js/tinymce.min.js"></script>
		<script>
		</script>
		<script>
			function get_product_list_data() {
				xmlhttp= new XMLHttpRequest();
				xmlhttp.onreadystatechange=function() {
					if(xmlhttp.readyState==4 && xmlhttp.status==200) {
						document.getElementById('get_product_list_data').innerHTML=xmlhttp.responseText;
					}
				}
				xmlhttp.open('GET','product_list_process.php',true);
				xmlhttp.send();
			}
			function del_prod(prod_id) {
				xmlhttp.onreadystatechange=function() {
					if(xmlhttp.readyState==4 && xmlhttp.status==200) {
						document.getElementById('get_product_list_data').innerHTML=xmlhttp.responseText;
					}
				}
				xmlhttp.open('GET','product_list_process.php?del_prod_id='+prod_id,true);
				xmlhttp.send();
			}
			
			function edit_prod(prod_id) {
				prod_id=document.getElementById('prod_id').value;
				//prod_image=document.getElementById('prod_image').value;
				prod_title=document.getElementById('prod_title').value;
				prod_desc=document.getElementById('prod_desc').value;
				prod_cat=document.getElementById('prod_cat').value;
				prod_quantity=document.getElementById('prod_quantity').value;
				prod_cost=document.getElementById('prod_cost').value;
				prod_price=document.getElementById('prod_price').value;
				prod_disc=document.getElementById('prod_disc').value;
				prod_del_chrg=document.getElementById('prod_del_chrg').value;
				alert(prod_title);
				xmlhttp.onreadystatechange=function() {
					if(xmlhttp.readyState==4 && xmlhttp.status==200) {
						document.getElementById('get_product_list_data').innerHTML=xmlhttp.responseText;
					}
				}
				xmlhttp.open('GET','product_list_process.php?prod_id='+prod_id+'&prod_title='+prod_title+'&prod_desc='+prod_desc+'&prod_cat='+prod_cat+'&prod_quantity='+prod_quantity+'&prod_cost='+prod_cost+'&prod_price='+prod_price+'&prod_disc='+prod_disc+'&prod_del_chrg='+prod_del_chrg,true);
			}	xmlhttp.send();
		</script>
	</head>
	
	<body onLoad="get_product_list_data();">
		<?php include "include/header.php"; ?>
		<div class="container">
			<button class="btn btn-danger" data-toggle="modal" data-target="#add_new_item" data-backdrop="static" data-keyboard="false">Add New Product</button>
			<div id="add_new_item" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Add New Product</h4>
						</div>
						<div class="modal-body">
							
							<form method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label>Product Image</label>
									<input type="file" name="prod_image" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Product Title</label>
									<input type="text" name="prod_title" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Product Description</label>
									<textarea class="form-control" name="prod_desc" ></textarea>
								</div>
								<div class="form-group">
									<label>Product Category</label>
									<select class="form-control" name="prod_cat" required>
										<option>Select a category</option>
										<?php 
											$cat_sql="SELECT * FROM prod_cat";
											$cat_run=mysqli_query($conn,$cat_sql);
											while($cat_rows=mysqli_fetch_assoc($cat_run)) {
												if($cat_rows['cat_slug']==''){
													$cat_slug=$cat_rows['cat_name'];
												}
												else {
													$cat_slug=$cat_rows['cat_slug'];
												}
													echo "<option value='$cat_slug'>".ucwords($cat_slug)."</option>";
											}
										?>
									</select>
								</div>
								<div class="form-group">
									<label>Product Quantity</label>
									<input type="number" class="form-control" name="prod_qty" required>
								</div>
								<div class="form-group">
									<label>Product Cost</label>
									<input type="number" class="form-control" name="prod_cost" required>
								</div>
								<div class="form-group">
									<label>Product Price</label>
									<input type="number" class="form-control" name="prod_price" required>
								</div>
								<div class="form-group">
									<label>Product Discount</label>
									<input type="number" class="form-control" name="prod_disc" required>
								</div>
								<div class="form-group">
									<label>Product Delivery Charges</label>
									<input type="number" class="form-control" name="prod_del_chrg" >
								</div>
								<div class="form-group">
									<input type="submit" name="product_submit" class="btn btn-primary btn-block" >
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button class="btn btn-danger" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			<div id="get_product_list_data">
				<!--Area to get the Processed product list data-->
			</div>
		</div>
		<br><br><br><br>
		<?php include "include/footer.php"; ?>
	</body>
</html>