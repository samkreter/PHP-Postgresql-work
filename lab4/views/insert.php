<form method="POST" action="index.php">
				<input type="hidden" name="action" value="save_insert">
				Enter data for the city to be added: <br>
				<table border="1">
				<tbody><tr><td>Name</td><td><input type="text" name="name"></td></tr>
				<tr><td>Country Code</td><td><select name="country_code">
					<option value="BHS">Bahamas</option>
					<option value="BHR">Bahrain</option>
				</select></td></tr>
				<tr><td>District</td><td><input type="text" name="district"></td></tr>
				<tr><td>Population</td><td><input type="text" name="population"></td></tr>
				</tbody></table>
				<input type="submit" value="Save">
				<input type="button" value="Cancel"class="close-reveal-modal">
			</form>