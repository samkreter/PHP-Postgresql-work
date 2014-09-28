	
<?php

	
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

							$result = pg_prepare($conn, "country_lookup", 'SELECT co.country_code, co.name FROM 
			                lab4.country AS co') or die("Prepare fail: ".pg_last_error());
			                $result = pg_execute($conn, "country_lookup",array()) or die("Query fail: ".pg_last_error());
							
			                while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

								echo "<option value=\"".$line['country_code']."\">".$line["name"]."</option>";
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