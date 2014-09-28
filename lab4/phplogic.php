<?php
			//including the nesesary things for the database connection 
			require("../secure/database.php");
			require("insert.php");
			
			 //create connection with database
			
			global $conn;

			$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) 
			 or die('Could not connect: ' . pg_last_error());



	function displayinsert(){
		
		$dbconn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) 
			 or die('Could not connect: ' . pg_last_error());
	
	echo	'<form method="POST" action="index.php" data-abide>
				<div class="row">
					<input type="hidden" name="action" value="save_insert">
					Enter data for the city to be added: <br>
					<table border="1">
					<div class="name-field">
						<tbody><tr><td>Name</td><td><input type="text" name="name" required></td></tr>
						<small class="error">Name is required and must be a string.</small>
					</div>
					<tr><td>Country Code</td><td><select name="country_code">';

							$sresult = pg_prepare($dbconn, "poplist", 'SELECT co.country_code, co.name FROM 
			                lab4.country AS co') or die("Prepare fail: ".pg_last_error());
			                $sresult = pg_execute($dbconn, "poplist",array()) or die("Query fail: ".pg_last_error());
							
			                while ($line = pg_fetch_array($sresult, null, PGSQL_ASSOC)) {

								echo "<option value=\"".$line['country_code']."\">".$line["name"]."</option>";
							}
				
			echo	 '	</select></td></tr>
					<div class"district-field">
						<tr><td>District</td><td><input type="text" name="district" required></td></tr>
						<small class="error">District is required and must be a string.</small>
					</div>
					<div class="population-field">
						<tr><td>Population</td><td><input type="text" name="population" required pattern="number"></td></tr>
						<small class="error">Population is required and must be a number.</small>
					</div>
					</tbody></table>
				</div>
				<div class="row left">
					<div><input type="submit" class="button"value="Save"></div>
					<a class="close-reveal-modal">&#215;</a>
				</div>
		</form>';

		pg_free_result($sresult);
				// Closing connection
				pg_close($dbconn);
	
	}


	function displayedit(){
		?>
		<form method="POST" action="">
			<input type="hidden" name="pk" value="GHA:Akan"><input type="hidden" name="tbl" value="language"><input type="hidden" name="action" value="save_edit"><table border="1">
				<tbody><tr>
					<td>country_code</td>
					<td>GHA</td>
				</tr>
				<tr>
					<td>language</td>
					<td>Akan</td>
				</tr>
				<tr>
					<td><strong>is_official</strong></td>
					<td><input type="text" name="is_official" value="f"></td>
				</tr>
				<tr>
					<td><strong>percentage</strong></td>
					<td><input type="text" name="percentage" value="52.4"></td>
				</tr>
			</tbody></table>
			<input type="submit" value="Save">
			<input type="button" value="Cancel" onclick="top.location.href='lab4.php';">
		</form>
		<?php
	}

	function displayDelete(){
		echo "<b>Delete was successful</b>";
	}

	function validation(){

		?>

				<form data-abide>
		  <div class="name-field">
		    <label>Your name <small>required</small>
		      <input type="text" required pattern="[a-zA-Z]+">
		    </label>
		    <small class="error">Name is required and must be a string.</small>
		  </div>
		  <div class="email-fie">
		    <label>Email <small>required</small>
		      <input type="email" required>
		    </label>
		    <small class="error">An email address is required.</small>
		  </div>
		  <button type="submit">Submit</button>
		</form>
	
	<?php
	}




			
			
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
