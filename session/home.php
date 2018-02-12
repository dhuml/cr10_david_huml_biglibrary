<?php 
	ob_start();
	session_start();
	require_once 'dbconnect.php';

	//if session is not set this will redirect to login page

	if( !isset($_SESSION['user'])) {
		header("Location: index.php");
		exit;
	}

	// select logged-in users detail
	$res = mysqli_query($conn, "SELECT * FROM users WHERE user_id=" .$_SESSION['user']);
	$userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);
 ?>

<!DOCTYPE html>
<html>
<head>

	<title>Welcome - <?php echo $userRow['user_email']; ?></title>
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
<div class="jumbotron d-flex flex-column border align-items-center bg-custom">

	
		<h1 class="display-2">Big Library</h1>	

		<br >
		<br >

		<p class="lead">Hi' <?php echo $userRow['user_email']; ?>
		</p>
 
		
		<hr class="my-4">

		<a class="btn btn-primary btn-lg" href="logout.php?logout">Log Out</a>
	
</div>

</header>
	
<main>
	
	<?php 
	echo "<div class='container'>";
		$mysqli = new mysqli('localhost', 'root', '', 'cr10_david_huml_biglibrary');

		if (!$mysqli) {
			print "<h1>Unable to connect to MySQL</h1>";
		}

		// sql statement alle alle median anzeigen

		$sql_statement = "SELECT title, img_link, res_status, first_name, last_name, publisher_name ";
		$sql_statement .= "FROM media ";
		$sql_statement .= "INNER JOIN media_creators on media.fk_media_creator = media_creators.creator_id ";
		$sql_statement .= "INNER JOIN publisher on media.fk_publisher = publisher.publisher_id ";
		if ( $_GET['category'] ) {
			$sql_statement .= "WHERE publisher.publisher_name ='" . $_GET['category'] .  "'";}
		
		$result = $mysqli->query($sql_statement);

		// sql statement für publisher liste

		$sql_statement2 = "SELECT publisher_name ";
		$sql_statement2 .= "FROM media ";
		$sql_statement2 .= "RIGHT JOIN publisher on media.fk_publisher = publisher.publisher_id";
		$result2 = $mysqli->query($sql_statement2);


		if (!$result) {
			$outputDisplay = "<p>MySQL No: " . $mysqli->errno . "</p>";
			$outputDisplay .= "<p>MySQL Error: " . $mysqli->error . "</p>";
			$outputDisplay .= "<p>SQL Statement: " . $sql_statement . "</p>";
			$outputDisplay .= "<p>MySQL Affected Rows: " . $mysqli->affected_rows . "</p>";
			echo $outputDisplay;

			} else {
			$outputDisplay = "query succesfull";
			};

		if (!$result2) {
			$outputDisplay = "<p>MySQL No: " . $mysqli->errno . "</p>";
			$outputDisplay .= "<p>MySQL Error: " . $mysqli->error . "</p>";
			$outputDisplay .= "<p>SQL Statement: " . $sql_statement2 . "</p>";
			$outputDisplay .= "<p>MySQL Affected Rows: " . $mysqli->affected_rows . "</p>";
			echo $outputDisplay;

			} else {
			$outputDisplay = "query succesfull";
			};

		// rows1 = liste alle media elemente

		$rows = $result->fetch_all(MYSQLI_ASSOC);
		
		// rows2 = liste alle publisher

		$rows2 = $result2->fetch_all(MYSQLI_ASSOC);
		
		// dropdown filter auswahl

			echo "<ul class='nav nav-pills'>
						<li class='nav-item dropdown'>
							<a class='nav-link dropdown-toggle' data-toggle='dropdown' href='#'' role='button' aria-haspopup='true' aria-expanded='false'>Publisher</a>
						
					    		<div class='dropdown-menu'>";
					echo "<a class='dropdown-item' href='home.php'>All</a>";
					    	
					    foreach ($rows2 as $row2) {
					    		echo "<a class='dropdown-item' href='?category=" . $row2['publisher_name'] . "'>" . $row2['publisher_name'] . "</a>";
					    	}
					    
			echo "		</div>
						</li>";
			echo "</ul>";

			echo "<div class='row'>";


			foreach ($rows as $row) {

				echo "<div class='col-12 col-md-6 col-lg-6 col-xl-6 columns d-flex align-items-center'>";
				echo "	<div class='row'>";
				echo "		<div class='col-6 col-md-6'>";
				echo "			<img class='img-thumbnail ' src='" . $row['img_link'] . "'>";
				echo "		</div>";
				echo "		<div class='col-6 col-md-6'>";
				echo "			<h3>" . $row['title'] . "</h3>";
				echo "			<span>" . $row['first_name'] . "</span>";
				echo "			<span>" . $row['last_name'] . "</span>";
				echo "			<p>" . $row['res_status'] . "</p>";
				echo "		</div>";
				echo "	</div>";
				echo "</div>";
			}

			echo "</div>";
			echo "</div>";

	 ?>

</main>



	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>

<?php ob_end_flush(); ?>