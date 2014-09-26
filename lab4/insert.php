
<?php
	//including the nesesary things for the database connection 
	include("../secure/database.php");
			
			 //create connection with database
	$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) 
	or die('Could not connect: ' . pg_last_error());



	$result = pg_prepare($conn, "city_insert", 'INSERT INTO lab4.city VALUES(DEFAULT,$1,$2,$3,$4)')
	or die("Prepare fail: ".pg_last_error());
	$result = pg_execute($conn, "country_lookup",array($userInput)) or die("Query fail: ".pg_last_error());
					
	

?>