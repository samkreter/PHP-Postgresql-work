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
			include("../secure/database.php");
			
			echo HOST;
			 //create connection with database
			$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) 
			 or die('Could not connect: ' . pg_last_error($conn));
			
			//checking if the post varible is empty 
			 if(!empty($_POST)){

				 $num = $_POST['query']; 

				 //switch statment for selecting the query for the user
				switch($num){
					case 1:
						$query = "SELECT district, population FROM lab2.city 
						WHERE name LIKE 'Springfield'
						ORDER BY population DESC";
						break;
					case 2:
						$query ="SELECT name, district, population FROM lab2.city
								WHERE country_code LIKE 'BRA'
								ORDER BY name ASC";
						break;
					case 3:
						$query ='SELECT name, continent, surface_area FROM lab2.country 
								ORDER BY surface_area ASC
								LIMIT 20';
						break;
					case 4:
						$query ='SELECT name, continent, government_form, gnp FROM lab2.country
								WHERE (gnp > 200000)
								ORDER BY name ASC';
						break;
					case 5:
						$query ='SELECT name, life_expectancy FROM lab2.country
								WHERE (life_expectancy IS NOT NULL)
								ORDER BY life_expectancy DESC LIMIT 10 OFFSET 10';
						break;
					case 6:
						$query ="SELECT ci.name FROM lab2.city AS ci
								WHERE (LEFT(ci.name,1)='B') AND (RIGHT(ci.name,1)='s')
								ORDER BY ci.population DESC";
						break;
					case 7:
						$query ='SELECT c.name, country.name AS country, c.population 
								FROM lab2.city AS c INNER JOIN lab2.country 
								ON (country.country_code=c.country_code)
								WHERE (c.population > 6000000)
								ORDER BY c.population DESC';
						break;
					case 8:
						$query ='SELECT co.name, cl.language, cl.percentage FROM lab2.country_language AS cl, lab2.country AS co
								WHERE (cl.country_code=co.country_code) AND (co.population > 50000000) AND (cl.is_official = false)
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
