<!DOCTYPE html>
<html>
	<head>
		<title>My Movie Database (MyMDb)</title>
		<meta charset="utf-8" />

		<!-- Link to your CSS file that you should edit -->
		<link href="bacon.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<div id="frame">
			<div id="banner">
				<a href="index.php"><img src="mymdb.png" alt="banner logo" /></a>
				My Movie Database
			</div>

			<div id="main">
				<?php echo "<h1>Results for " . htmlspecialchars($_GET["firstname"]) . " " . htmlspecialchars($_GET["lastname"]) .  "</h1>";
				echo "<p>Films with " . htmlspecialchars($_GET["firstname"]) . " " . htmlspecialchars($_GET["lastname"]) . "</p>";
				 ?>
			</div>
		<?php
		$dbh = new PDO('mysql:host=localhost; dbname=mysql', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		//string holds mySQL query command
		
		$first_name = htmlspecialchars($_GET["firstname"]);
		$last_name = htmlspecialchars($_GET["lastname"]);
		$variable = $dbh->query("SELECT movies.name, movies.year FROM roles JOIN movies ON movies.id = roles.movie_id WHERE actor_id = (SELECT id FROM actors WHERE first_name = '$first_name' AND last_name = '$last_name') ORDER BY movies.year DESC");
		
		//if the user is not found
		$test = $variable->fetch(PDO::FETCH_ASSOC);
		if(!$test)
		{
			$first_name = substr($first_name, 0, 1);
			$variable = $dbh->query("SELECT movies.name, movies.year FROM roles JOIN movies ON movies.id = roles.movie_id JOIN actors ON roles.actor_id = actors.id WHERE actor_id = (SELECT id FROM actors WHERE first_name LIKE '%$first_name%' AND last_name = '$last_name' LIMIT 1) ORDER BY movies.year DESC, actors.film_count DESC");
			
			echo "<table> <tr> <td>#</td> <td>Title</td> <td>Year</td> </tr>";
			$count = 1;
			while($movieTable = $variable->fetch( PDO::FETCH_ASSOC )){ 
				echo "<tr> <td>" . $count . "</td> <td>" . $movieTable['name'] . "</td> <td>" . $movieTable['year'] . "</td></tr>";
     			$count++;
     		}
		}		

		else {


		//query again because one row was lost
		$variable = $dbh->query("SELECT movies.name, movies.year FROM roles JOIN movies ON movies.id = roles.movie_id WHERE actor_id = (SELECT id FROM actors WHERE first_name = '$first_name' AND last_name = '$last_name') ORDER BY movies.year DESC");

		//print out the table of results
			echo "<table> <tr> <td>#</td> <td>Title</td> <td>Year</td> </tr>";
			$count = 1;
			while($movieTable = $variable->fetch( PDO::FETCH_ASSOC )){ 
				echo "<tr> <td>" . $count . "</td> <td>" . $movieTable['name'] . "</td> <td>" . $movieTable['year'] . "</td></tr>";
     			$count++;
     		}
		}
		?>
				<!-- form to search for every movie by a given actor -->
				<form action="search-all.php" method="get">
					<fieldset>
						<legend>All movies</legend>
						<div>
							<input name="firstname" type="text" size="12" placeholder="first name" autofocus="autofocus" /> 
							<input name="lastname" type="text" size="12" placeholder="last name" /> 
							<input type="submit" value="go" />
						</div>
					</fieldset>
				</form>

				<!-- form to search for movies where a given actor was with Kevin Bacon -->
				<form action="search-kevin.php" method="get">
				<fieldset>
				<legend>Movies with Kevin Bacon</legend>
				<div>
					<input name="firstname" type="text" size="12" placeholder="first name" /> 
					<input name="lastname" type="text" size="12" placeholder="last name" /> 
					<input type="submit" value="go" />
				</div>
			</fieldset>
		</form>
	</body>
</html>