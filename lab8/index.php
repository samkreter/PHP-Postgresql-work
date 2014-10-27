<html></<html>
  <head>
    <title>lab8</title>
  </head>
  <body>
    <b>testing connection</b>

<?php

			//including the nesesary things for the database connection
			require("../secure/database.php");

			 //create connection with database
			$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
			 or die('Could not connect: ' . pg_last_error());
?>

</body>
</html>
