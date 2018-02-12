<?php 
	
	// this will avoid mysql_connect() deprecatoin error.

	error_reporting( ~E_DEPRECATED & ~E_NOTICE );


	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBNAME', 'cr10_david_huml_biglibrary');

	$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

	if (!$conn) {

		die("Connection failed: " . mysqli_error());
	}
 ?>