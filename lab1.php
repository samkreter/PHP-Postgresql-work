<html>
<head/>
<body>
<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
  <table border="1">
     <tr><td>Number of Rows:</td><td><input type="text" name="rows" /></td></tr>
     <tr><td>Number of Columns:</td><td><select name="columns">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="4">4</option>
    <option value="8">8</option>
    <option value="16">16</option>

  </select>
</td></tr>
   <tr><td>Operation:</td><td><input type="radio" name="operation" value="multiplication" checked="yes">Multiplication</input><br/>
  <input type="radio" name="operation" value="addition">Addition</input>
  </td></tr>
  </tr><td colspan="2" align="center"><input type="submit" name="submit" value="Generate" /></td></tr>
</table>
</form>






<?php
   
	
  	
  	if(!empty($_POST)){

  		$rows = htmlspecialchars($_POST['rows']);
        $columns = htmlspecialchars($_POST['columns']);
        $operation = htmlspecialchars($_POST['operation']);

        echo "The $rows x $columns $operation table.";

 		echo '<table border="1">';
 		for($i=0;$i<=$_POST['rows'];$i++){
 			
 			if($i == 0){
 				echo "<tr>";
 				for($j=0;$j<$_POST['columns']+1;$j++){
 					echo '<td align="center"><strong>' . $j . "</strong></td>";
 				}
 				echo "</tr>";
 			}
 			else{
	 			echo "<tr>";
	 			echo '<td align="center"><strong>' . $i . '</strong></td>'; 		
	 			if($_POST['operation'] === 'multiplication'){
	 				
		 			for($j=1;$j<=$_POST['columns'];$j++){
		 				if($j == 0){

		 				}
		 				echo '<td align="center">' . ($i * $j) . "</td>"; 
		 			}
		 		}
		 		else if($_POST['operation'] === 'addition'){
		 			for($j=1;$j<=$_POST['columns'];$j++){

		 				echo '<td align="center">' . ($i + $j) . "</td>";  
		 			}
		 		}
	 			echo "</tr>";	
	 		}
 		}
 		echo "</table>";
  	};
  
  
  

?>
</body>
</html>
