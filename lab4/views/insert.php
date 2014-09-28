	
<?php

	function displayinsert(){
		
	?>
		<form method="POST" action="index.php">
				<div class="row">
					<input type="hidden" name="action" value="save_insert">
					Enter data for the city to be added: <br>
					<table border="1">
					<tbody><tr><td>Name</td><td><input type="text" name="name"></td></tr>
					<tr><td>Country Code</td><td><select name="country_code">
						<option value="BHR">Bahrain</option>
					</select></td></tr>
					<tr><td>District</td><td><input type="text" name="district"></td></tr>
					<tr><td>Population</td><td><input type="text" name="population"></td></tr>
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

?>