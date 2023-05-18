<?php

include '../cnx_data.php';
if ($_POST['user_cod'] != "") {
	$cod = $_POST["user_cod"];
	$sql = "SELECT trcdocumento FROM  btyusuario where trcdocumento = '$cod'";	
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    echo 'TRUE';
	} else {
		$sql = "SELECT `tdicodigo`, `trcdocumento`, `trcdigitoverificacion`, `trcnombres`, `trcapellidos`, `trcrazonsocial`, `trcdireccion`, `trctelefonofijo`, `trctelefonomovil`, `brrcodigo` FROM `btytercero` WHERE trcdocumento = $cod";
	   	$result = $conn->query($sql);
	   	if ($result->num_rows > 0) {
	   		while($row = $result->fetch_assoc()) {
	   			echo $row['tdicodigo'].",";  			// 0
	   			echo $row['trcdocumento'].","; 			// 1
	   			echo $row['trcdigitoverificacion'].",";	// 2
	   			echo $row['trcnombres'].","; 			// 3
	   			echo $row['trcapellidos'].",";			// 4
	   			echo $row['trcrazonsocial'].","; 		// 5
	   			echo $row['trcdireccion'].","; 			// 6
	   			echo $row['trctelefonofijo'].","; 		// 7
	   			echo $row['trctelefonomovil'].",";		// 8
	   			echo $row['brrcodigo'].",";				// 9
	   		}	
	   	} else {
	   		echo "FALSE";
	   	}
	}
} else if ($_POST['usulogin'] != "") {
	$cod = $_POST["usulogin"];
	$sql = "SELECT usulogin FROM  btyusuario where usulogin = '$cod'";	
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    echo '<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Este nombre de usuario no esta disponible</font></div>';
	}
}



