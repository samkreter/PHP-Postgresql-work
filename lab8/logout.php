<?php

  //catch the current session
  session_start();
  //including the nesesary things for the database connection
  require("../secure/database.php");
  //include the helper functions
  require("helperFunctions.php");

  //create connection with database
  $conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
    or die('Could not connect: ' . pg_last_error());

  $resultForLog = pg_prepare($conn,"logoutLog",
  'INSERT INTO lab8.log VALUES(DEFAULT,$1,$2,DEFAULT,$3)')
  or die("logout log Prespare Fail: ".pg_last_error());

  $resultForLog = pg_execute($conn, "logoutLog",
  array($_SESSION['user'],getClientIP(),"logout"))
  or die("Logout log Execute Fail: ".pg_last_error());

  session_destroy();
  header('Location: index.php');

?>
