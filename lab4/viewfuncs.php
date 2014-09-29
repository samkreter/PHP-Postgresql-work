	
<?php

	//all helper functions for all of the necessary actions 



	//logic for the insert page 
	function insert($name,$cCode,$district,$population){

		$result = pg_prepare($GLOBALS['conn'], "city_insert", 'INSERT INTO lab4.city VALUES(DEFAULT,$1,$2,$3,$4)')
		or die("Prepare fail: ".pg_last_error());
		if(pg_execute($GLOBALS['conn'], "city_insert",array($name,$cCode,$district,$population))){
			$GLOBALS['toggle'] = 0;
			echo "<br><strong>insert was successful</strong>";
		}
		else{
			echo "Insert did not work";
		}

	}


	//locgic for the remove action 
	function remove($pkey, $search_by){

		if($search_by == "city"){
			$result = pg_prepare($GLOBALS['conn'], "city_delete", 'DELETE FROM lab4.city AS ci WHERE ci.id ='.$pkey)
			or die("Prepare fail: ".pg_last_error());
			if(pg_execute($GLOBALS['conn'], "city_delete",array())){
				echo "Delete was successful";
			}
			else{
				echo "Delete was not successful";
			}
		}
		else if($search_by == "country"){
			$result = pg_prepare($GLOBALS['conn'], "country_delete", "DELETE FROM lab4.country AS co WHERE co.country_code ILIKE '$pkey'")
			or die("Prepare fail: ".pg_last_error());
			if(pg_execute($GLOBALS['conn'], "country_delete",array())){
				echo "<br><strong>Delete was successful</strong>";
			}
			else{
				echo "Delete was not successful";
			}
		}
		else if($search_by == "language"){
			$result = pg_prepare($GLOBALS['conn'], "langauge_delete", "DELETE FROM lab4.country_language AS lang WHERE lang.country_code ILIKE '$pkey'")
			or die("Prepare fail: ".pg_last_error());
			if(pg_execute($GLOBALS['conn'], "langauge_delete",array()) or die(pg_last_error())){
				echo "<br><strong>Delete was successful</strong>";
			}
			else{
				echo "Delete was not successful";
			}	
		}
		
	}
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
				<div class="row">
					<input type="hidden" name="action" value="save_insert">
					Enter data for the city to be added: <br>
					<table border="1">
					<div class="name-field">
						<tbody><tr><td>Name</td><td><input type="text" name="name" required></td></tr>
						<small class="error">Name is required and must be a string.</small>
					</div>
					<tr><td>Country Code</td><td><select name="country_code">
						<?php 
							$result = pg_prepare($GLOBALS['conn'], "poplist", 'SELECT co.country_code, co.name FROM 
			                lab4.country AS co') or die("Prepare fail: ".pg_last_error());
			                $result = pg_execute($GLOBALS['conn'], "poplist",array()) or die("Query fail: ".pg_last_error());
							
			                while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

								echo "<option value=\"".$line['country_code']."\">".$line["name"]."</option>\n";
							}
						?>
					</select></td></tr>
					<div class"district-field">
						<tr><td>District</td><td><input type="text" name="district" required></td></tr>
						<small class="error">District is required and must be a string.</small>
					</div>
					<div class="population-field">
						<tr><td>Population</td><td><input type="text" name="population" required pattern="[0-9]"></td></tr>
						<small class="error">Population is required and must be a number.</small>
					</div>
					</tbody></table>
				</div>
				<div class="row left">
					<div><input type="submit" class="button"value="Save"></div>
					<a class="close-reveal-modal">&#215;</a>
				</div>
		</form>
	
	<?php
	}

?>