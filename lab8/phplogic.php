<?php

			//file that has the main logic for the php and the webapp

			//including the nesesary things for the database connection
			require("../secure/database.php");

			//starting the session
			session_start();

			 //create connection with database

			/*$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
			 or die('Could not connect: ' . pg_last_error());*/



			if(isset($_POST['FirstUsername'])){
				

			}

				/*
			 require("viewfuncs.php");

			$search_by;

				//actions for the user to search
				if(isset($_POST['search_by'])){

					$search_by = $_POST['search_by'];
					$userInput = htmlspecialchars($_POST['query_string']);
					$userInput = $userInput."%";

				 	if($_POST['search_by'] == "country"){
						$result = pg_prepare($conn, "country_lookup", 'SELECT * FROM
		                lab4.country AS co WHERE co.name  ILIKE $1') or die("Prepare fail: ".pg_last_error());
		                $result = pg_execute($conn, "country_lookup",array($userInput)) or die("Query fail: ".pg_last_error());
					}
					else if($_POST['search_by'] == "city"){
						$result = pg_prepare($conn, "city_lookup", 'SELECT * FROM
		                lab4.city AS ci WHERE ci.name ILIKE $1') or die("Prepare fail: ".pg_last_error());
		                $result = pg_execute($conn, "city_lookup",array($userInput)) or die("Query fail: ".pg_last_error());
					}
					else if($_POST['search_by'] == "language"){
						$result = pg_prepare($conn, "language_lookup", 'SELECT * FROM
		                lab4.country_language AS la WHERE la.language ILIKE $1') or die("Prepare fail: ".pg_last_error());
		                $result = pg_execute($conn, "language_lookup",array($userInput)) or die("Query fail: ".pg_last_error());
					}



				 //Printing results in HTML
				echo "<br>There where <em>" . pg_num_rows($result) . "</em> rows returned<br><br>\n";


				echo "<table border='1'>";

				//account for added form row
				echo "<tr>";
				echo "<th width=\"135\">Action</th>";

				//checking the number of fields return to populate header
				$numFields = pg_num_fields($result);
				//populating the header
				for($i = 0;$i < $numFields; $i++){
				  $fieldName = pg_field_name($result, $i);
				  echo "<th width=\"135\">" . $fieldName . "</th>\n";
				}

				echo "</tr>";

				//populating table with the results
				while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
				 echo "\t<tr>\n";

				 if($search_by == "city"){
				 	$pkey = "id";
				 }
				 else {
				 	$pkey = "country_code";
				 }

				 echo '<td>';
				 ?>
				 <form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
				 <?php
				 echo '<input type="submit" id="edit-button" name="type" value="Edit"/>';
			     echo '<input type="submit" name="type" value="Remove"/>';
				 echo '<input type="hidden" name="pkey" value="'.$line[$pkey].'"/>';
				 echo '<input type="hidden" name="table" value="'.$search_by.'"/>';
				 echo '</form>';
				 echo '</td>';



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

			//action for the user to insert into the database

			//it error checks for population by not allowing the user to continue
			//does not display error messgage
			if(isset($_POST['action'])){

				if(!is_numeric($_POST['population'])){
					echo "<strong>Population must be a numeric value</strong>";
				}
				else{

				$population = htmlspecialchars($_POST['population']);
			    $district = htmlspecialchars($_POST['district']);


				insert(htmlspecialchars($_POST['name']),$_POST['country_code'],$district,$population);
				}
			}

			if(isset($_POST['type'])){

				if($_POST['type'] == "Remove"){
					remove($_POST['pkey'],$_POST['table']);
				}
				else if($_POST['type'] == "Edit"){

					edit($_POST['pkey'],$_POST['table']);
				}
			}

			if(isset($_POST['edit_submit'])){


				if($_POST['search'] == "country"){
					$indep_year = htmlspecialchars($_POST['indep_year']);
					$population = htmlspecialchars($_POST['population']);
					$local_name = htmlspecialchars($_POST['local_name']);
					$government_form = htmlspecialchars($_POST['government_form']);
					$pkey = $_POST['edit_submit'];

					$result = pg_prepare($conn, "country_update", "UPDATE lab4.country SET indep_year = $1,
						population = $2, local_name = $3, government_form = $4
						WHERE country_code = $5") or die("Prepare fail: country update ".pg_last_error());
			        pg_execute($conn, "country_update",array(intval($indep_year),intval($population),$local_name,$government_form,$pkey)) or die("Query fail: ".pg_last_error());

			    }
			    else if($_POST['search'] == "city"){

			    	$population = htmlspecialchars($_POST['population']);
			    	$district = htmlspecialchars($_POST['district']);
			    	$pkey = htmlspecialchars($_POST['edit_submit']);


			    	$result = pg_prepare($conn, "city_update", "UPDATE lab4.city SET population = $1,
						district = $2 WHERE id = $3") or die("Prepare fail: city update ".pg_last_error());
			        pg_execute($conn, "city_update",array(intval($population),$district,intval($pkey))) or die("Query fail city exectu: update ".pg_last_error());

			    }

			    else if($_POST['search'] == "language"){
			    	$country_code = htmlspecialchars($_POST['country_code']);
					$language = htmlspecialchars($_POST['language']);
					$is_official = htmlspecialchars($_POST['is_official']);
					$percentage = htmlspecialchars($_POST['percentage']);
					$pkey = $_POST['edit_submit'];


					echo $pkey;

					$result = pg_prepare($conn, "language_update", "UPDATE lab4.country_language SET is_official = $1,
						percentage = $2 WHERE country_code = $3") or die("Prepare fail: language update ".pg_last_error());
			        pg_execute($conn, "language_update",array($is_official,intval($percentage), $pkey)) or die("Query fail city exectu: update ".pg_last_error());
			    }
			}

		*/





?>
