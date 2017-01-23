<?php

	/* Connect to a MySQL database using PHP and PDO */
	$dsn = 'mysql:dbname=CIT480;host=localhost;port=3306';
	$user = 'root';
	$password = 'root';

	try {
		$dbh = new PDO($dsn, $user, $password);
		echo 'Database connection sucessful!';
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	} 
  
?>
