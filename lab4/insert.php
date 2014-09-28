
<?php

	function insert($name,$cCode,$district,$population){

		$result = pg_prepare($conn, "city_insert", 'INSERT INTO lab4.city VALUES(DEFAULT,$1,$2,$3,$4)')
		or die("Prepare fail: ".pg_last_error());
		$result = pg_execute($conn, "country_lookup",array($name,$cCode,$district,$population)) or die("Query fail: ".pg_last_error());
					
	}

	function remove(){
		
	}

	function edit(){

	}



?>