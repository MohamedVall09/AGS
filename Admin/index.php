<?php
	include './config.php';
	session_start();
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$email = $_POST["email"];
			$password = $_POST["password"];
			$statement =$con->prepare("SELECT email,password ,admin FROM clients WHERE email = ? AND password = ? AND admin = ?");
			$statement->execute(array($email,$password,1));
			$counter = $statement->rowCount();
			// echo $counter;
			if($counter > 0){
				// echo '<div class="green">This customer exists</div>';
				$_SESSION['admin_email'] = $email;
				header('Location:./dashboard.php');
			}else{
				echo '<div class="red">This customer not exists</div>';
			};
	};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style_login.css">
    <title>Admin | Login</title>
</head>
<body>
<div class="container" id="container">
	<div class="form-container sign-in-container">
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <div class="logo">
			<img src="../logo.png" alt="">
			</div>
			<h2>Sign in</h2>
			<input type="email" name="email" placeholder="Email"/>
			<input type="password" name="password" placeholder="Password" />
			<a href="#">Forgot your password?</a>
			<input class="button" type="submit" value="Sign In">
		</form>
	</div>

	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-right">
				<h1>Hello, Admin!</h1>
				<p>You ...</p>
			</div>
		</div>
	</div>
</div>

</body>
</html>