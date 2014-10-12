<html>
	<head>
		<meta charset="UTF-8">
		<title>CS 3380 Lab 6</title>
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
						$query ='SELECT cp.country_name, lab6.city.name, cp.max_population FROM 
				(SELECT lab6.country.country_code AS country_code, lab6.country.name AS country_name, max(lab6.city.population) As max_population FROM lab6.country, lab6.city 
				WHERE lab6.country.country_code = lab6.city.country_code 
				GROUP BY lab6.country.country_code, lab6.country.name) 
				As cp JOIN lab6.city ON cp.country_code = lab6.city.country_code 
				WHERE lab6.city.population = cp.max_population ORDER BY max_population DESC';
						break;

					case 7:
						$query ='SELECT co.name, COUNT(*) FROM lab6.city AS ci 
								INNER JOIN lab6.country AS co ON ci.country_code = co.country_code 
								GROUP BY co.name
								ORDER BY COUNT DESC';
						break;
					//not a fun query to do, this one was hard :(
					case 8:
						$query ='SELECT country.name, capitals.name AS capital, cont_lang.lang_num 
				                FROM
			                    ( SELECT ci.name AS name, ci.country_code AS country_code
			                      FROM lab6.city as ci, lab6.country AS co
			                      WHERE ci.id = co.capital
			                    ) AS capitals
			                    JOIN
			                    (
			                      SELECT COUNT(*) AS lang_num, country.country_code AS country_code
			                      FROM lab6.country_language JOIN lab6.country USING 
			                      (country_code)
			                      GROUP BY country.country_code
			                      HAVING COUNT(*)>=8 AND COUNT(*) <= 12
			                    ) AS cont_lang
			                    USING(country_code)
			                    JOIN
			                    lab6.country
			                    USING(country_code)
			                    ORDER BY lang_num DESC, capitals.name DESC';
						break;
					case 9:
						$query ='SELECT country.name, tmp.city, tmp.population, tmp.running_total FROM (
				                  SELECT city.name as city, city.country_code, city.population,
				                  SUM(population) OVER (PARTITION BY city.country_code ORDER BY city.population DESC
				                    ) AS running_total
				                  FROM lab6.city
				                  ) AS tmp
				                JOIN
				                lab6.country USING (country_code)
				                ORDER BY country.name, tmp.running_total';
						break;
					case 10:
						$query ='SELECT country.name, tmp.language, tmp.rank_in_region FROM (
				                SELECT country_code, language, 
				                rank() OVER (
				                  PARTITION BY country_code 
				                  ORDER BY percentage DESC
				                  ) AS rank_in_region 
				                  FROM lab6.country_language
				                  ) AS tmp
				                  JOIN lab6.country USING (country_code)
				                  ORDER BY country.name, tmp.rank_in_region'; 
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
