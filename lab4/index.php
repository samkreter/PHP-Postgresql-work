<html>
	<?php //require("viewfuncs.php"); ?>
	<head>
		<meta charset="UTF-8">
		<title>CS 3380 Lab 4</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<link rel="stylesheet" href="foundation-5.4.0/css/foundation.css" />
    	<script src="foundation-5.4.0/js/vendor/modernizr.js"></script>
	</head>
	<body>

		<form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
		    Search for a :
		    <input type="radio" name="search_by" checked="true" value="country">Country 
		    <input type="radio" name="search_by" value="city">City
		    <input type="radio" name="search_by" value="language">Language <br><br>
		    <div class="row left">
			    <div>
			    	<label for="left-label" class="left inline">That begins with:</label>
			    </div>
			    <div class="large-4 columns">
			    	<input type="text" name="query_string" value="">
			    </div>
			</div>
			<div class="row left">
		    	<div class="large-2"><input type="submit" class="left" name="submit" value="Submit"></div>
		    </div>
		</form>
		<hr>
		Or insert a new city by clicking this <a href="#" data-reveal-id="insert-modal">link</a>



		<?php
			
			include("phplogic.php");

   			

		?>
		<div id="insert-modal" class="reveal-modal" data-reveal>
			<?php //echo file_get_contents("views/insert.php")
				displayinsert($conn);
			?>
		</div>


		<script src="foundation-5.4.0/js/vendor/jquery.js"></script>
	    <script src="foundation-5.4.0/js/foundation.min.js"></script>
	    <script>
	      $(document).foundation();
	    </script>
	</body>
</html>
