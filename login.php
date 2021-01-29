<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){

include_once 'connection.php';
include_once 'user.php';

$database = new DB();
$db = $database->getConnection();

//passing $db to user
$user = new User($db);

//Set ID property of user to be deleted these values can be passed using any device
$user->email = isset($_POST['email']) ? $_POST['email'] : 'die()';
$user->password = isset($_POST['password']) ? $_POST['password'] : 'die()';

//read the details of user to be edited
$statement = $user->login();

if($statement->rowCount() > 0){
	//get retrived row
	$row = $statement->fetch(PDO::FETCH_ASSOC);

	// Storing session data
	session_start();
	session_regenerate_id();
	$_SESSION['loggedin'] = TRUE;
	$_SESSION['name'] = $row["user_nicename"];
	$_SESSION['id'] = $row["ID"];
	header('Location: dashboard.php');
	// print_r($row);exit;
}
else{
	$auth_invalid =array(
		"status"	=> false,
		"message"	=> "Invalid email/password!"
	);
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login | Cotton</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST" action="">
					<span class="login100-form-title p-b-26">
						Welcome
					</span>
					<span class="login100-form-title p-b-48">
						<i class="zmdi zmdi-font"></i>
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
						<input class="input100" type="email" name="email" required="">
						<span class="focus-input100" data-placeholder="Email"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="password" required="">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>
					<?php if(isset($auth_invalid) && !empty($auth_invalid)): ?>
						<div class="alert alert-danger" role="alert">
							Invalid email/password. Please try again!
						</div>
					<?php endif; ?>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<input type="submit" class="login100-form-btn" value="Login">
						</div>
					</div>
					
					<div class="text-center p-t-115">
						<a class="txt2" href="#">
							Forgot Password?
						</a>
					</div>

				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>