<?php 

	ob_start();
	session_start(); //start a new session or continue the previous
	if ( isset($_SESSION['user']) !="") {
		header("Location: home.php"); // redirects to home.php
	}

	include_once 'dbconnect.php';

	$error = false;

	if ( isset($_POST['btn-signup']) ) {
		$name = trim($_POST['name']);
		$name = strip_tags($name);
		$name = htmlspecialchars($name);

		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);

		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);

		//basic name validation

		if (empty($name)) {
			$error = true;
			$nameError = "Please enter your full name.";
		} elseif (strlen($name) < 3 ) {
			$error = true;
			$nameError = "Name must have atleasr 3 characters.";
		} elseif (!preg_match("/^[a-zA-Z ]+$/",$name)) {
			$error = true;
			$nameError = "Name must contain alphabets and space.";
		}

		//basic email validation 

		if ( !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = true;
			$emailError = "Please enter valid email address.";
		} else {
			// check wether the email exist or not

			$query = "SELECT user_email FROM users WHERE user_email='$email'";
			$result = mysqli_query($conn, $query);
			$count = mysqli_num_rows($result);
			if ($count!= 0) {
				$error = true;
				$emailError = "Provided Email is already in use.";
			}
		}

		// password validation

		if (empty($pass)) {
			$error = true;
			$passError ="Please enter password.";
		} elseif (strlen($pass) < 6) {
			$error = true;
			$passError = "Password must have atleast 6 characters.";
		}

		// password encrypt using SHA256();
		$password = hash('sha256', $pass);

		// if there's no error, continue to signup
		if( !$error ) {
			$query = "INSERT INTO users(user_name,user_email,user_pass) VALUES ('$name', '$email', '$password')";
			$res = mysqli_query($conn, $query);

			if($res) {
				$errTyp = "success";
				$errMSG = "Successfully registered, you may login now";
				unset($name);
				unset($email);
				unset($pass);
			}  else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";
			}
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>login & registration system</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


	<style>
		.bg-custom {
			background-image: url('img/library.jpg');
			opacity: 0.7;
		}
	</style>
</head>
<body>
<header>


<div class="jumbotron d-flex flex-column border align-items-center bg-custom">

	
		<h1 class="display-2">Big Library</h1>	

		

		<hr class="my-4">


		<a class="btn btn-primary btn-lg" href="index.php" role="button">Log In</a>
		</p>
	
</div>	

</header>

<main>
	
	<div class="container">
		
		
		<form class="d-flex flex-column border rounded p-3" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
			
			<h2 class="text-center">Sign Up</h2>
			<hr/>
			
			<?php 
				if(isset($errMSG)) {

			 ?>
			
			<div class="alert"><?php echo $errMSG; ?></div>

			<?php 
				}
			 ?>

		<div class="form-group">
			
			<label for="regname">Username</label>
			
			<input type="text" name="name" class ="form-control" placeholder="Enter Name" maxlength="50" value="<?php echo $name ?>" id="regname">
			<span class="danger">
				<?php echo $nameError; ?>
			</span>
		</div>

			<div class="form-group">
				<label for="regname">Email</label>
				<input type="email" name="email" class ="form-control" placeholder="Enter Email-Adress" maxlength="50" value="<?php echo $email ?>">
				<span class="danger" id="regemail">
					<?php echo $emailError; ?>
				</span>
			</div>

			<div class="form-group">
				
				<label for="regpass">Password</label>
				<input type="password" name="pass" class ="form-control" placeholder="Enter Password" maxlength="15" />
				<span class="danger" id="regpass">
					<?php echo $passError; ?>
				</span>
			
			</div>

			<hr>

			<button type="submit" class="btn btn-block btn-primary" name="btn-signup">
				Sign Up
			</button>


			<hr>

			<a href="index.php">Sign in Here...</a>
		</form>
		
	</div>

</main>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

<?php ob_end_flush() ?>