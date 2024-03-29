<?php require("indexlogic.php");

//redirect for https
  if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
    $redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("location: $redirect");
  }
  //get the current session or start a new one
  session_start();
  //redirect if logged in
  if($_SESSION['loggedin'] == true){
    header("location: home.php");
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DB LOGIN SYSTEM</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/grayscale.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- ################################## crappy in file css but it does work so ########## -->
    <style>
      .loginError{
        height: 40px;
        background-color: red;
        font-size: 20px;
      }
    </style>

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">
                    <i class="fa fa-play-circle"></i>  <span class="light">Sam</span> Kreter
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#Register">Register</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#LogIn">Log In</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Intro Header -->
    <header class="intro">
        <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="brand-heading">DB LOG IN</h1>
                        <p class="intro-text">The log in system that will change your<br><b>LIFE!!!!!!!</b></p>
                        <a href="#Register" class="btn btn-circle page-scroll">
                            <i class="fa fa-angle-double-down animated"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Register Section -->
    <section id="Register" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
              <h2>Register New User</h2>
                <form role="form" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
                    <div class="form-group">
                      <label for="InputFirstUsername">UserName</label>
                      <input type="username" class="form-control" name="FirstUsername" placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                      <label for="InputNewPassword">Enter Password</label>
                      <input type="password" class="form-control" name="FirstPassword" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Log In Section -->
    <section id="LogIn" class="content-section text-center">
        <div class="download-section">
            <div class="container">
                <div class="col-lg-8 col-lg-offset-2">
                    <h2>Log In</h2>
                      <form role="form" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
                          <div class="form-group">
                            <label for="InputUsername">UserName</label>
                            <input type="username" class="form-control" name="username" placeholder="Enter Username">
                          </div>
                          <div class="form-group">
                            <label for="InputPassword">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                          </div>
                          <button type="submit" class="btn btn-default">Submit</button>
                      </form>
                  </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p>Copyright &copy; BlackSmith 2014</p>
        </div>
    </footer>

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="js/jquery.easing.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/grayscale.js"></script>

</body>

</html>
