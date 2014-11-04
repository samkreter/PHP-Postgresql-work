<?php

			//file that has the main logic for the php and the webapp

			//including the nesesary things for the database connection
			require("../secure/database.php");
			//include the helper functions
			require("helperFunctions.php");

			//starting the session
			session_start();



			//restestration handling
			if(isset($_POST['FirstUsername'])){
				//create connection with database
				$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
					or die('Could not connect: ' . pg_last_error());

				//set up varibles
				$username = htmlspecialchars($_POST['FirstUsername']);
				$salt = mt_rand();
				$password = sha1($salt.$_POST['FirstPassword']);
				$description = "";
				$ipAddress = getClientIP();
				$action = "Register";

				$resultForChecking = pg_prepare($conn,"checking",'SELECT username
					FROM lab8.user_info WHERE username LIKE $1')
					or die("checking pg prepare fail: ".pg_last_error());
				$resultForChecking = pg_execute($conn,"checking",array($username))
					or die("checking execute fail: ".pg_last_error());

				if(pg_num_rows($resultForChecking)){
					echo "<div class='loginError'>Bro username already exists - Please try again</div>";
				}
				else{

					//prepare statments for the inserting
					$resultForUser_info = pg_prepare($conn, "user_infoInsert",
					'INSERT INTO lab8.user_info VALUES($1,DEFAULT,$2)')
					or die("User_infoInsert Prepare fail: ".pg_last_error());

					$resultForAuthentication = pg_prepare($conn,"authenticationInsert",
					'INSERT INTO lab8.authentication VALUES($1,$2,$3)')
					or die("AuthenticationInsert Prepare fail: ".pg_last_error());

					$reslutForLog = pg_prepare($conn,"logInsert",
					'INSERT INTO lab8.log VALUES(DEFAULT,$1,$2,DEFAULT,$3)')
					or die("logInsert Prespare Fail: ".pg_last_error());

					//execute statments
					$resultForUser_info = pg_execute($conn, "user_infoInsert",
					array($username,$description)) or die("User_infoInsert Execute Fail: ".pg_last_error());

					$resultForAuthentication = pg_execute($conn, "authenticationInsert",
					array($username,$password,$salt)) or die("AuthenticationInsert Execute Fail: ".pg_last_error());

					$resultForLog = pg_execute($conn, "logInsert",
					array($username,$ipAddress,$action)) or die("LogInsert Execute Fail: ".pg_last_error());

					$_SESSION['loggedin'] = true;
					$_SESSION['user'] = $username;


					//free necessary items
					pg_free_result($resultForChecking);
					pg_free_result($resultForUser_info);
					pg_free_result($resultForAuthentication);
					pg_free_result($resultForLog);
					pg_close($conn);

					//redirect loged in user to homepage
					header("location: home.php");
				}

				//free all the necesary items if useranem already ex
				pg_free_result($resultForChecking);
				pg_close($conn);



			}

			//login handling
			if(isset($_POST['username'])){
				//making connection with database
				$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
					or die('Could not connect: ' . pg_last_error());

				//set varibles
				$username = htmlspecialchars($_POST['username']);
				$password = htmlspecialchars($_POST['password']);



				$resultForPassLookUp = pg_prepare($conn, "passLookUp",
				'SELECT password_hash, salt FROM lab8.authentication
				 WHERE username LIKE $1')
				or die("passLookUP Prepare fail: ".pg_last_error());

				//query database to make sure user exists
				//if they don't display error message 
				$resultForPassLookUp = pg_execute($conn,"passLookUp",
				array($username)) or die("passLookUp Execute Fail: ".pg_last_error());

				if(pg_num_rows($resultForPassLookUp) == 0){
					echo "<div class='loginError'>Bro your Username or Password do not match - Please try again</div>";
				}
				else{
				$line = pg_fetch_array($resultForPassLookUp, null, PGSQL_ASSOC);
				$salt = intval($line['salt']);
				$tempPass = $line['password_hash'];

					if($tempPass == sha1($salt.$_POST['password'])){
						$_SESSION['loggedin'] = true;
						$_SESSION['user'] = $username;

						//prepare statments for adding a user
						$resultForlog = pg_prepare($conn,"logUpdate","INSERT INTO lab8.log
							VALUES(DEFAULT,$1,$2,DEFAULT,$3)") or die("logUpdate prepare fail: ".pg_last_error());

						$resultForlog = pg_execute($conn,"logUpdate",
						array($username,getClientIP(),"login"))
						or die("logupdate execute fail: ".pg_last_error());


						//redirects the user to their page
						header("location: home.php");
					}
					else{

						//addes the wrong password attemt to the log
						$resultForLogout = pg_prepare($conn,"wrongPassLog",
						'INSERT INTO lab8.log VALUES(DEFAULT,$1,$2,DEFAULT,$3)')
						or die("wrongpass log Prespare Fail: ".pg_last_error());

						$resultForLogout = pg_execute($conn, "wrongPassLog",
						array($username,getClientIP(),"Wrong Password"))
						or die("worngpass log Execute Fail: ".pg_last_error());
						echo "<div class='loginError'>Bro your Username or Password do not match - Please try again</div>";
					}
				}
				//closing connections
				pg_free_result($resultForLogout);
				pg_free_result($resultForLog);
				pg_close($conn);
			}



?>
