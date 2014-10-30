<?php

      //file that has the main logic for the php and the webapp

      //including the nesesary things for the database connection
      require_once("../secure/database.php");
      //include the helper functions
      require_once("helperFunctions.php");

      //starting the session
      session_start();
  

      if(isset($_POST['HomeDescription'])){

        //create connection with database
        $conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
          or die('Could not connect: ' . pg_last_error());

        //set up varibles
        $description = htmlspecialchars($_POST['HomeDescription']);
        $username = $_SESSION['user'];

        //updateprepare stamtnet
        $resultForUpdating = pg_prepare($conn,"updating",'UPDATE lab8.user_info
        SET description = $1 WHERE username LIKE $2') or die("Updating prepare Fail: ".pg_last_error());

        //update execute stamtnet
        $resultForUpdating = pg_execute($conn,"updating", array($description, $username))
        or die("Updating Execute fail: ".pg_last_error());



        pg_close($conn);
      }
