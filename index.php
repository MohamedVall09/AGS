<?php
	include './Public/config.php';
	session_start();
	if ($_SERVER['REQUEST_METHOD'] == "POST") {

		if (!empty($_POST['name'])) {
			# code...
			$name = $_POST["name"];
			$email = $_POST["email"];
			$number = $_POST["number"];
			$password = $_POST["password"];
			$statement =$con->prepare("INSERT INTO clients(name,email,number,password)
			VALUES(:name,:email,:number,:password)");
			$statement->execute(array(
				'name' => $name,
				'email' => $email,
				'number' => $number,
				'password' => $password
    	));			
		}
		if (!empty($_POST["Vemail"])){
			$Vemail = $_POST["Vemail"];
			$Vpassword = $_POST["Vpassword"];
			$statement =$con->prepare("SELECT name, email,password FROM clients WHERE email = ? AND password = ?");
			$statement->execute(array($Vemail,$Vpassword));
			$counter = $statement->rowCount();
			// echo $counter;
			if($counter > 0){
				// echo '<div class="green">This customer exists</div>';
				$_SESSION['user_email'] = $Vemail;
				header('Location:./Public/public.php');
			}else{
				echo '<div class="red">This customer not exists</div>';
			}
		}
	};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="./Public/icon/icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./style_login.css">
    <title>login | signIn</title>
</head>
<body>
<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
			<div class="logo"><img src="./logo.png" alt=""></div>
            <h2>Create Account</h2>
			<input type="text" name="name" placeholder="Name" />
			<input type="email" name="email" placeholder="Email" />
			<input type="tel" name="number" placeholder="Number" />
			<input type="password" name="password" placeholder="Password" />
			<input class="button" type="submit" value="Sign Up">
		</form>
	</div>

	<div class="form-container sign-in-container">
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <div class="logo">
                <img src="./logo.png" alt="">
			</div>
			<h2>Sign in</h2>
			<input type="email" name="Vemail" placeholder="Email" />
			<input type="password" name="Vpassword" placeholder="Password" />
			<a href="#">Forgot your password?</a>
			<input class="button" type="submit" value="Sign In">

			<!-- <button>Sign In</button> -->
		</form>
	</div>

	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<input class="button ghost" id="signIn" type="submit" value="Sign Up">

				<!-- <button class="ghost" id="signIn">Sign In</button> -->
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Hello, Friend!</h1>
				<p>Enter your personal details and start journey with us</p>
				<input class="button ghost" id="signUp" type="submit" value="Sign Up">
				<!-- <button class="ghost" >Sign Up</button> -->
			</div>
		</div>
	</div>
</div>

<script src="./script.js"></script>
</body>
</html>