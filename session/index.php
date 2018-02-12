<?php 
	ob_start();
	session_start();
	require_once 'dbconnect.php';

	//it will never let you open index(login) page if session is set

	if ( isset($_SESSION['user']) !="" ) {
		header("Location: home.php");
		exit;
	}

	$error = false;

	//prevent sql injections/ clear user invalid inputs

	$email = trim($_POST['email']);
	$email = strip_tags($email);
	$email = htmlspecialchars($email);

	$pass = trim($_POST['pass']);
	$pass = strip_tags($pass);
	$pass = htmlspecialchars($pass);

	// prevent sql injections / clear user invalid inputs

	if (empty($email)) {
		$error = true;
		$emailError = "Please enter your email address.";
	} else if ( !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error = true;
		$emailError = "Please enter valid email address.";
	}

	if (empty($pass)) {
		$error = true;
		$passError = "Please enter your password.";
	}

	//if there#s no error continue to login

	if (!$error) {
		$password = hash('sha256', $pass); //password hashing using SHA256

		$res = mysqli_query($conn, "SELECT user_id, user_name, user_pass FROM users WHERE user_email = '$email'");
		$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
		$count = mysqli_num_rows($res); // if user_name/pass correct it returns must be  1 row

		if ($count == 1 && $row['user_pass'] == $password) {
			$_SESSION['user'] = $row['user_id'];
			header("Location: home.php");
		} else {
			$errMSG = "Incorrect Credentials, Try again...";
		}
	}
 ?>

<!DOCTYPE html>
<html>
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


		<a class="btn btn-primary btn-lg" href="register.php" role="button">Registrate new user</a>
		</p>
	
</div>
	
	

</header>

<main>

	
	<div class="container">
		

	<form class="d-flex flex-column border rounded p-3" method="post" action="<?php echo htmlspecialchars($SERVER['PHP_SELF']); ?>" autocomplete="off" >


		<h2 class="text-center">User Login</h2>
		<hr />

		<?php 
			if ( isset($errMSG) ) {
				echo $errMSG; ?>
		<?php }
		 ?>

		<div class="form-group">
			<label for="emailinput">Email adress</label>
			<input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" id="emailinput">
			<span class="text-danger"><?php echo $emailError; ?></span>
		</div>

		<div class="form-group">
			<label for="passinput">Password</label>
			<input type="pass" name="pass" class="form-control" placeholder="Your password" value="<?php echo $pass; ?>" maxlength="15" id="passinput">

			<span class="text-danger"><?php echo $passError; ?></span>
		</div>

		<hr />

		<button type="submit" name="btn btn-primary btn-lg">Sign In</button>




	</form>
	
	<a href="register.php">Sign Up Here...</a>
	
	</div>
</main>




	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

<?php ob_end_flush(); ?>