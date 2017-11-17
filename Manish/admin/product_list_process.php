<?php include "../include/db.php";
	if(isset($_REQUEST['del_prod_id'])) {
		$del_sql="DELETE FROM products WHERE prod_id='$_REQUEST[del_prod_id]'";
		mysqli_query($conn,$del_sql);
	}
	
	if(isset($_POST['up_product_submit'])) {
		//$prod_image=mysqli_real_escape_string($conn,strip_tags($_POST['prod_image']));
		$prod_title=mysqli_real_escape_string($conn,strip_tags($_POST['prod_title']));
		$prod_desc=mysqli_real_escape_string($conn,$_POST['prod_desc']);
		$prod_cat=mysqli_real_escape_string($conn,strip_tags($_POST['prod_cat']));
		$prod_qty=mysqli_real_escape_string($conn,strip_tags($_POST['prod_qty']));
		$prod_cost=mysqli_real_escape_string($conn,strip_tags($_POST['prod_cost']));
		$prod_price=mysqli_real_escape_string($conn,strip_tags($_POST['prod_price']));
		$prod_disc=mysqli_real_escape_string($conn,strip_tags($_POST['prod_disc']));
		$prod_del_chrg=mysqli_real_escape_string($conn,strip_tags($_POST['prod_del_chrg']));
		$prod_id=$_POST['prod_id'];
		/*if(isset($_FILES['prod_image']['name'])) {
			$file_name=mt_rand()."_".$_FILES['prod_image']['name'];
			$path_add="../images/product/$file_name";
			$prod_image="images/product/$file_name";
			$img_confirm=1;
			$file_type=pathinfo($_FILES['prod_image']['name'],PATHINFO_EXTENSION);
			if($_FILES['prod_image']['size']>200000) {
				$img_confirm=0;
				echo 'The size is very big';
			}
			if($file_type!='jpg' && $file_type!='png' && $file_type!='gif') {
				$img_confirm=0;
				echo 'Type is not matching';
			}
			if($img_confirm==0) {
				
			}else {
				if(move_uploaded_file($_FILES['prod_image']['tmp_name'],$path_add)) {*/
					$prod_up_sql="UPDATE products SET prod_image='$prod_image',prod_title='$prod_title',prod_desc='$prod_desc',prod_cat='$prod_cat',prod_quantity='$prod_quantity',prod_cost='$prod_cost',prod_price='$prod_price',prod_disc='$prod_disc',prod_del_chrg='$prod_del_chrg' WHERE prod_id='$prod_id' ";  
					$prod_up_run=mysqli_query($conn,$prod_up_sql);
				/*}
			}
		}
		else {
			echo "sorry";
		}*/
	}
	
 ?>

<table class="table table-bordered table-striped">
	<thead>
		<tr class="table-head">
			<th>S.no.</th>
			<th>Image</th>
			<th>Product Title</th>
			<th>Product Description</th>
			<th>Product Category</th>
			<th>Product Qty</th>
			<th>Product Cost</th>
			<th>Product Discount</th>
			<th>Product Price</th>
			<th>Product Delivery</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$c=1;
			$sel_sql="SELECT * FROM products";
			$sel_run=mysqli_query($conn,$sel_sql);
			while($rows=mysqli_fetch_assoc($sel_run)) {
				$discounted_price=$rows['prod_price']-$rows['prod_disc'];
				$edit_id=-1;
				echo "
				<tr>
					<td>$c</td>
					<td><img src='../$rows[prod_image]' style='width:60px;'></td>
					<td>".ucwords($rows['prod_title'])."</td>
					<td>".strip_tags($rows['prod_desc'])."</td>
					<td>".ucwords($rows['prod_cat'])."</td>
					<td>$rows[prod_quantity]</td>
					<td>$rows[prod_cost]</td>
					<td>$rows[prod_disc]</td>
					<td>$discounted_price($rows[prod_price])</td>
					<td>$rows[prod_del_chrg]</td>
					<td>
						<div class='dropdown'>
							<button class='btn btn-danger dropdown-toggle' data-toggle='dropdown'>Actions<span class='caret'></span></button>
							<ul class='dropdown-menu dropdown-menu-right'>
								<li><a href='#edit_modal$c' data-toggle='modal'>Edit</a></li>
														
								<li><a href='javascript:;' onclick='del_prod($rows[prod_id])'>Delete</a></li>
		
							</ul>
						</div>
					</td>
				</tr>
				<div id='edit_modal$c' class='modal fade'>
					<div class='modal-dialog'>
						<div class='modal-content'>
							<div class='modal-header'>
								<button class='close' data-dismiss='modal'>&times;</button>
								<h4 class='modal-title'>Edit Product</h4>
							</div>
							<div class='modal-body'>
								<div id='form1'>
									
									<div class='form-group'>
										<label>Product Title</label>
										<input type='text' id='prod_title' class='form-control' value=$rows[prod_title] required>
									</div>
									<div class='form-group'>
										<label>Product Description</label>"; ?>
										<textarea class='form-control' id='prod_desc' value=<?php echo $rows['prod_desc']; ?>></textarea>
									<?php
									echo "
									</div>
									<div class='form-group'>
										<label>Product Category</label>
										<select class='form-control' id='prod_cat' required>
											<option>Select a category</option>";
											$cat_sql="SELECT * FROM prod_cat";
											$cat_run=mysqli_query($conn,$cat_sql);
											while($cat_rows=mysqli_fetch_assoc($cat_run)) {
												if($cat_rows['cat_slug']==''){
													$cat_slug=$cat_rows['cat_name'];
												}
												else {
													$cat_slug=$cat_rows['cat_slug'];
												}
												if($cat_slug==$rows['prod_cat']) {
													//echo "<option selected value='$cat_slug'>".ucwords($cat_rows['cat_name'])."</option>";
													echo "<option selected value='$cat_slug'>".ucwords($cat_slug)."</option>";
												}
												else {
													//echo "<option value='$cat_slug'>".ucwords($cat_rows['cat_name'])."</option>";
													echo "<option value='$cat_slug'>".ucwords($cat_slug)."</option>";
												}
											}
											echo "
										</select>
									</div>
									<div class='form-group'>
										<label>Product Quantity</label>
										<input type='number' class='form-control' id='prod_qty' value=$rows[prod_quantity] required>
									</div>
									<div class='form-group'>
										<label>Product Cost</label>
										<input type='number' class='form-control' id='prod_cost' value=$rows[prod_cost] required>
									</div>
									<div class='form-group'>
										<label>Product Price</label>
										<input type='number' class='form-control' id='prod_price' value=$rows[prod_price] required>
									</div>
									<div class='form-group'>
										<label>Product Discount</label>
										<input type='number' class='form-control' id='prod_disc' value=$rows[prod_disc] required>
									</div>
									<div class='form-group'>
										<label>Product Delivery Charges</label>
										<input type='number' class='form-control' id='prod_del_chrg' value=$rows[prod_del_chrg]>
									</div>
									<div class='form-group'>
										<input type='hidden' id='up_prod_id'> "; ?>
										<button onclick="edit_prod($rows[prod_id]);" class='btn btn-primary btn-block' >Submit</button>
									</div>
								</div>
							</div>
							<div class='modal-footer'>
								<button class='btn btn-danger' data-dismiss='modal'>Close</button>
							</div>
						</div>
					</div>
				</div>
				<?php
				$c++;
			}
		?>	
		</tbody>
	</table>
		