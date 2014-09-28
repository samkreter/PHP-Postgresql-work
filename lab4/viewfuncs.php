	
<?php

	
	function insert($name,$cCode,$district,$population){

		$result = pg_prepare($GLOBALS['conn'], "city_insert", 'INSERT INTO lab4.city VALUES(DEFAULT,$1,$2,$3,$4)')
		or die("Prepare fail: ".pg_last_error());
		if(pg_execute($GLOBALS['conn'], "city_insert",array($name,$cCode,$district,$population))){
			echo "als;jdkffffffffffffffffffffffffffffffffffffffffff";
		}
		else{
			echo "nonnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn";
		}

	}

	function remove($pkey, $search_by){

		if($search_by == "city"){
			$result = pg_prepare($GLOBALS['conn'], "city_delete", 'DELETE FROM lab4.city AS ci WHERE ci.id ='.$pkey)
			or die("Prepare fail: ".pg_last_error());
			if(pg_execute($GLOBALS['conn'], "city_delete",array())){
				echo "IT worked bro";
			}
			else{
				echo "it messed up bro";
			}
		}
		else if($search_by == "country"){
			$result = pg_prepare($GLOBALS['conn'], "country_delete", "DELETE FROM lab4.country AS co WHERE co.country_code ILIKE '$pkey'")
			or die("Prepare fail: ".pg_last_error());
			if(pg_execute($GLOBALS['conn'], "country_delete",array())){
				echo "it worked";
			}
			else{
				echo "not so working";
			}
		}
		else if($search_by == "language"){
			$result = pg_prepare($GLOBALS['conn'], "langauge_delete", "DELETE FROM lab4.country_language AS lang WHERE lang.country_code ILIKE '$pkey'")
			or die("Prepare fail: ".pg_last_error());
			if(pg_execute($GLOBALS['conn'], "langauge_delete",array()) or die(pg_last_error())){
				echo "it worked";
			}
			else{
				echo "not so working";
			}	
		}
		
	}

	function edit(){

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
						"code2")

		


	}



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
						<tr><td>Population</td><td><input type="text" name="population" required pattern="number"></td></tr>
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

?>