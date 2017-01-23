<?php

	/* Connect to a MySQL database using PHP and PDO */
	$dsn = 'mysql:dbname=CIT480;host=localhost;port=3306';
	$user = 'root';
	$password = 'root';

	try {
		$dbh = new PDO($dsn, $user, $password);
		/* add a message at the top of the page noting connection successful. */
		echo 'Database connection sucessful!';
	} catch (PDOException $e) {
		/* add a message at the top of the page noting connection to database failed. */
		echo 'Connection failed: ' . $e->getMessage();
	} 
  
?>
