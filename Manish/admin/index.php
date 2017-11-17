<?php include "../include/db.php"; ?>

<?php
session_start();
$username = "";
	$email    = "";
	$errors = array(); 
	$_SESSION['success'] = "";

if (isset($_POST['login_user'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM admin_login WHERE username='$username' AND password='$password'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) != 1) {
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: product_list.php');
			}else {
				array_push($errors, "Wrong username/password combination");
			}
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
        <link rel="stylesheet" href="css/login.css">
	</head>
	
	<body>
		<?php include "include/header.php"; ?>
        <?php include('errors.php'); ?>
		<div class="container">
	
	<div class="wrapper">
		<form action="product_list.php" method="post" name="Login_Form" class="form-signin">       
		    <h3 class="form-signin-heading">Welcome Back! Please Sign In</h3>
			  <hr class="colorgraph"><br>
			  
			  <input type="text" class="form-control" name="Username" placeholder="Username" required="" autofocus="" /><br>
			  <input type="password" class="form-control" name="Password" placeholder="Password" required=""/>     		  
			 
			  <button class="btn btn-lg btn-primary btn-block"  name="login_user" value="Login" type="Submit">Login</button>  			
		</form>			
	</div>
</div>
            
		<?php include "include/footer.php"; ?>
	</body>
</html>