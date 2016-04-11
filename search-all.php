<!DOCTYPE html>
<html>
	<head>
		<title>My Movie Database (MyMDb)</title>
		<meta charset="utf-8" />

		<!-- Link to your CSS file that you should edit -->
		<link href="bacon.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<?php
		$dbh = new PDO('mysql:host=localhost; dbname=mysql', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		//string holds mySQL query command
		$variable = $dbh->query(query string);
		//varNext has associative array of data from mySQL query
		$varNext = $variable->fetchAll(PDO::FETCH_ASSOC);
		?>
	</body>
</html>