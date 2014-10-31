<?php


	require_once("../secure/database.php");

	//all helper functions for all of the necessary actions
	// Function to get the client IP address
	function getClientIP() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}

/*	function printUserInfo(){
		//open databse connection
		$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
			or die('Could not connect: ' . pg_last_error());

			$username = $_SESSION['user'];

			$resultFordata = pg_prepare($conn,"gettingData","SELECT ")

			//close db connection
			pg_close($conn);
	}*/

	function printUserLog(){

		$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
			or die('Could not connect: ' . pg_last_error());


			$result = pg_prepare($conn,"getLog","SELECT * FROM lab8.log
			WHERE username LIKE $1")
			or die("getLog prepare fail: ".pg_last_error());

			$result = pg_execute($conn,"getLog",array($_SESSION['user']))
			or die("getLog execute fail: ".pg_last_error());



			//Printing results in HTML
			echo "<br>There where <em>" . pg_num_rows($result) . "</em> rows returned<br><br>\n";


			echo "<table class='tablestuff' border='1'>";

			//account for added form row
			echo "<tr>";

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



				foreach ($line as $col_value) {

					echo "\t\t<td>$col_value</td>\n";
				}
				echo "\t</tr>\n";
			}
			echo "</table>\n";


			// Free resultset
			pg_free_result($result);
			//close connection
			pg_close($conn);
	}

	/*



	//logic for all the editing
	function edit($pkey, $search_by){

		if($search_by == "country"){
			$fields = array("country_code",
							"name",
							"continent",
							"region",
						    "surface_area",
						    "indep_year",
							"population",
							"life_expectancy",
							"gnp",
							"gnp_old",
							"local_name",
							"government_form",
							"head_of_state",
							"capital",
							"code2");

			$result = pg_prepare($GLOBALS['conn'], "country_edit", "SELECT * FROM lab4.country AS co WHERE co.country_code ILIKE $1")
				or die("Prepare fail: country edit selet ".pg_last_error());
			$result = pg_execute($GLOBALS['conn'], "country_edit",array($pkey)) or die("error in execut coutry_edit selt".pg_last_error());
		}
		else if($search_by == "city"){
			$fields = array("id",
							"name",
							"country_code",
							"district",
							"population",);

			$result = pg_prepare($GLOBALS['conn'], "city_edit", "SELECT * FROM lab4.city AS ci WHERE ci.id = $1")
				or die("Prepare fail: city ".pg_last_error());
			$result = pg_execute($GLOBALS['conn'], "city_edit",array(intval($pkey))) or die("Error in Exection of city_edit selet".pg_last_error());
		}

		else if($search_by == "language"){
			$fields = array("country_code",
							"language",
							"is_official",
							"percentage");

			$result = pg_prepare($GLOBALS['conn'], "language_edit", "SELECT * FROM lab4.country_language AS la WHERE la.country_code ILIKE $1")
				or die("Prepare fail: language ".pg_last_error());
			$result = pg_execute($GLOBALS['conn'], "language_edit",array($pkey)) or die("Error in Exection of language_edit selet".pg_last_error());


		}


		$line = pg_fetch_array($result, null, PGSQL_ASSOC);
			?>
			<form method="POST" action="index.php">'
			<?php
			echo '<input type="hidden" name="edit_submit" value="'.$pkey.'"/>';
			echo '<input type="hidden" name="search" value="'.$search_by.'"/>';
			echo "<table border=\"1\">\n";
			for($i=0;$i<count($fields);$i++){

				if($fields[$i] == "indep_year" || $fields[$i] == "population" || $fields[$i] == "local_name"
				 || $fields[$i] == "government_form" || $fields[$i] == "district" || $fields[$i] == "is_official" || $fields[$i] == "percentage"){
					echo "<tr>";
					echo "<td width=\"135\"><strong>$fields[$i]</strong></td>";
					echo "<td width=\"135\"><input type=\"text\" name=\"".$fields[$i]."\" value=\"".$line[$fields[$i]]."\"></td>";
					echo "</tr>";
				}
				else{
					echo "<tr>";
					echo "<td width=\"135\">$fields[$i]</td>";
					echo "<td width=\"135\">".$line[$fields[$i]]."</td>";
					echo "</tr>";
				}

			}

			echo "</table>";
		    echo '<input type="submit" value="Save">';
			echo '<input type="button" value="Cancel" onclick="window.location=\'index.php\'">';
			echo "</form>";


	}


	//displays the insert page for the webapp
	function displayinsert(){

	?>
		<form method="POST" action="index.php" data-abide>
					<input type="hidden" name="action" value="save_insert">
					Enter data for the city to be added: <br>
					<div class="name-field">
						<label>Name
							<input type="text" name="name" required>
						</label>
						<small class="error">Name is required and must be a string.</small>
					</div>
					<div class="country-field">
						<label>Country Code
							<select name="country_code">
								<?php
									$result = pg_prepare($GLOBALS['conn'], "poplist", 'SELECT co.country_code, co.name FROM
					                lab4.country AS co') or die("Prepare fail: ".pg_last_error());
					                $result = pg_execute($GLOBALS['conn'], "poplist",array()) or die("Query fail: ".pg_last_error());

					                while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

										echo "<option value=\"".$line['country_code']."\">".$line["name"]."</option>\n";
									}
								?>
							</select>
						</label>
					</div>
					<div class"district-field">
						<label>District
							<input type="text" name="district" required></td></tr>
						</label>
						<small class="error">District is required and must be a string.</small>
					</div>
					<div class="population-field">
						<label>Population
							<input type="text" name="population" required pattern="[0-9]"></td></tr>
						</label>
						<small class="error">Population is required and must be a number.</small>
					</div>
					<div><input type="submit" class="button"value="Save"></div>
					<a class="close-reveal-modal">&#215;</a>
		</form>

	<?php
	}
	*/
?>
