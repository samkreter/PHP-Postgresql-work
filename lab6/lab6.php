<html>
	<head>
		<meta charset="UTF-8">
		<title>CS 3380 Lab 2</title>
	</head>
	<body>
		<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
			<select name="query">
				<option value="1">Query 1</option>
				<option value="2">Query 2</option>
				<option value="3">Query 3</option>
				<option value="4">Query 4</option>
				<option value="5">Query 5</option>
				<option value="6">Query 6</option>
				<option value="7">Query 7</option>
				<option value="8">Query 8</option>
				<option value="9">Query 9</option>
				<option value="10">Query 10</option>
				<option value="11">Query 11</option>
				<option value="12">Query 12</option>
			</select>
			<input type="submit" name="submit" value="Execute">
		</form>

		<br>
		<hr>
		<br>
		<?php
		//clearing if there was a post made 
		if(empty($_POST)){ ?>
		<strong>Select a query from the above list</strong>
		<?php
		}?>	

		<?php
			
			//including the nesesary things for the database connection 
<<<<<<< HEAD
			include("../../secure/database.php");
			
			 //create connection with database
			$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) 
			 or die('Could not connect: ' . pg_last_error());
			
			//checking if the post varible is empty 
			 if(!empty($_POST)){

				 $num = $_POST['query']; 

				 //switch statment for selecting the query for the user
				switch($num){
					case 1:
<<<<<<< HEAD
						$query = "SELECT MIN(surface_area),MAX(surface_area),AVG(surface_area) 
								 FROM lab6.country";
						break;
					case 2:
						$query ="SELECT region, SUM(population) AS total_population, SUM(surface_area) 
								AS total_surface_area, SUM(gnp) AS total_gnp FROM lab6.country
								GROUP BY region
								ORDER BY total_gnp DESC";
						break;
					case 3:
						$query ='SELECT government_form, COUNT(government_form), MAX(indep_year) AS most_recent_indep_year 
								FROM lab6.country
								WHERE indep_year != 0
								GROUP BY government_form 
								ORDER BY COUNT DESC, most_recent_indep_year DESC';
						break;
					case 4:
						$query ='SELECT co.name, COUNT(*) FROM lab6.city AS ci 
								INNER JOIN lab6.country AS co ON ci.country_code = co.country_code 
								GROUP BY co.name
								HAVING COUNT(*) > 100
								ORDER BY COUNT ASC';
						break;
					case 5:
						$query ='SELECT co.name, co.population, SUM(ci.population) AS urban_population, (SUM(ci.population)::numeric/co.population::numeric) AS urban_pct FROM lab6.city AS ci 
								INNER JOIN lab6.country AS co ON ci.country_code = co.country_code 
								GROUP BY co.country_code
								ORDER BY urban_pct ASC';
						break;
					case 6:
						$query ='SELECT co.name AS country, ci.name AS largest_city, MAX(ci.population) OVER (PARTITION BY co.name) FROM lab6.city AS ci 
								INNER JOIN lab6.country AS co ON ci.country_code = co.country_code 
							     ORDER BY ci.population DESC';

					case 7:
						$query ='SELECT c.name, country.name AS country, c.population 
								FROM lab2.city AS c INNER JOIN lab2.country 
								ON (country.country_code=c.country_code)
								WHERE (c.population > 6000000)
								ORDER BY c.population DESC';
						break;
					case 8:
						$query ='SELECT co.name, cl.language, cl.percentage FROM lab2.country_language AS cl, lab2.country AS co
								WHERE (c.country_code=co.country_code) AND (co.population > 50000000) AND (cl.is_official = false)
								ORDER BY cl.percentage DESC';
						break;
					case 9:
						$query ="SELECT co.name, co.indep_year, co.region FROM lab2.country AS co , lab2.country_language AS cl 
								WHERE (co.country_code=cl.country_code) AND (cl.language LIKE 'English') AND (cl.is_official = true)
								ORDER BY co.region ASC, co.name ASC";
						break;
					case 10:
						$query ='SELECT ci.name AS capital_name, co.name AS country_name, FLOOR(cast(cast(ci.population AS float)/cast(co.population AS float)*100 AS numeric)) AS Urban_pct
						FROM lab2.city AS ci,lab2.country AS co where co.capital=ci.id
						ORDER BY Urban_pct DESC'; 
						break;	
					case 11:
						$query ='SELECT co.name, cl.language,((percentage*co.population)/100) AS speakers 
				                FROM lab2.country AS co, lab2.country_language AS cl
				                WHERE (cl.is_official=true) AND (cl.country_code=co.country_code)
				                ORDER BY speakers DESC ';
						break;
					case 12:
						$query ='SELECT name, region, gnp, gnp_old, ((gnp-gnp_old)/gnp_old) AS real_change FROM lab2.country
								 WHERE (gnp IS NOT NULL) AND (gnp_old IS NOT NULL)
								 ORDER BY  real_change DESC';
						break;
				}


				//getting the query results
				$result = pg_query($query) or die('Query failed: ' . pg_last_error());
				 //Printing results in HTML
				echo "There where <em>" . pg_num_rows($result) . "</em> rows returned<br><br>\n";
				echo "<table border='1'>\n";
				
				echo "<tr>";
				//checking the number of fields return to populate header 
				$numFields = pg_num_fields($result);
				//populating the header 
				for($i = 0;$i < $numFields; $i++){
				  $fieldName = pg_field_name($result, $i);
				  echo "\t\t<th>" . $fieldName . "</th>\n";
				}
				echo "</tr>";
				//populating table with the results 
				while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
				 echo "\t<tr>\n";
				 foreach ($line as $col_value) {
				 echo "\t\t<td>$col_value</td>\n";
				 }
				 echo "\t</tr>\n";
				}
				echo "</table>\n";
				// Free resultset
				pg_free_result($result);
				// Closing connection
				pg_close($conn);

			}


		?>

	</body>
</html>
