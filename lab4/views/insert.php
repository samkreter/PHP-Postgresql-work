<form method="POST" action="index.php">
				<div class="row">
					<input type="hidden" name="action" value="save_insert">
					Enter data for the city to be added: <br>
					<table border="1">
					<tbody><tr><td>Name</td><td><input type="text" name="name"></td></tr>
					<tr><td>Country Code</td><td><select name="country_code">
				    	<option value=$line["country_code"]?>>Bahamas</option>
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