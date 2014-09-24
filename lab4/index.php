<html>
	<head>
		<meta charset="UTF-8">
		<title>CS 3380 Lab 4</title>
		<script>
		function clickAction(form, pk, tbl, action)
		{
		  document.forms[form].elements['pk'].value = pk;
		  document.forms[form].elements['action'].value = action;
		  document.forms[form].elements['tbl'].value = tbl;
		  document.getElementById(form).submit();
		}
		</script>
	</head>
	<body>

		<form method="POST" action="/localhost/lab4/index.php">
		    Search for a :
		    <input type="radio" name="search_by" checked="true" value="country">Country 
		    <input type="radio" name="search_by" value="city">City
		    <input type="radio" name="search_by" value="language">Language <br><br>
		    That begins with: <input type="text" name="query_string" value=""> <br><br>
		    <input type="submit" name="submit" value="Submit">
		</form>
		<hr>
		Or insert a new city by clicking this <a href="exec.php?action=insert">link</a>
	</body>
</html>

		<?php
			
			//including the nesesary things for the database connection 
			include("../secure/database.php");
			
			 //create connection with database
			$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) 
			 or die('Could not connect: ' . pg_last_error());
			
			
			 if(!empty($_POST)){

				 $num = $_POST['query']; 

				 //switch statment for selecting the query for the user
				

				 /*
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
				pg_free_result($result);*/
				// Closing connection
				pg_close($conn);


			}


		?>

	</body>
</html>
