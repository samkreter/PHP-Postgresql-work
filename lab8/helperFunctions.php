<?php


	require_once("../secure/database.php");

	//all helper functions for all of the necessary actions

	//return a db connection
	function dbconnect(){
		return pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
			or die('Could not connect: ' . pg_last_error());
	}

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

//print information from the usering info table 
  function printUserInfo(){
		//open databse connection
		$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
			or die('Could not connect: ' . pg_last_error());


			$resultFordata = pg_prepare($conn,"gettingData",
			"SELECT registration_date, description, ip_address FROM lab8.user_info
			 INNER JOIN lab8.log ON lab8.log.username = lab8.user_info.username
			 WHERE lab8.log.username LIKE $1 AND action LIKE 'Register'")
			 or die("gettingData prepare fail: ".pg_last_error());

			$resultFordata = pg_execute($conn,"gettingData",array($_SESSION['user']))
			or die("gettingData Execute fail: ".pg_last_error());

			$line = pg_fetch_array($resultFordata, null, PGSQL_ASSOC);

			echo "<b>IP Address: </b><span class'lower'>".$line['ip_address']."</span><br>";
			echo "<b>Date of Registration: <b><span class='lower'>".$line['registration_date']."</span><br>";
			echo "<b>Description</b><br><span class='lower'>".$line['description']."</span>";

			//close necssary items
			pg_free_result($resultFordata);
			pg_close($conn);
	}

//prints the log out to the user page
	function printUserLog(){
		//db connection
		$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
			or die('Could not connect: ' . pg_last_error());

			//query the database
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


?>
