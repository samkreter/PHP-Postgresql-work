<?php
			//including the nesesary things for the database connection 
			require("../secure/database.php");
			require("insert.php");
			
			 //create connection with database
			$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) 
			 or die('Could not connect: ' . pg_last_error());


			 require("viewfuncs.php");




			
			
			 if(!empty($_POST)){

				 remove();

				if(isset($_POST['search_by'])){

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
				}
				

				 //Printing results in HTML
				echo "There where <em>" . pg_num_rows($result) . "</em> rows returned<br><br>\n";
				

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

				 if($_POST['search_by'] == "city"){
				 	$pkey = "id";
				 }
				 else {
				 	$pkey = "country_code";
				 }
				 echo '<td>';
				 echo '<form method="POST" action="<?=$_SERVER[\'PHP_SELF\']?>">';
				 echo '<input type="submit" class""name="type" value="Edit"/>';
			     echo '<input type="submit" name="type" value="Remove"/>';
				 echo '<input type="hidden" name="pkey" value="'.$line[$pkey].'"/>';
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
?>
