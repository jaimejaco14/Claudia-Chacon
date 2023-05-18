<?php
include '../../cnx_data.php';
$documento = $_POST["no_documento"];

//$sql = "SELECT brrnombre FROM btybarrio";
if($documento != NULL) {

$sql = "SELECT `clbcodigo`, `trcdocumento`, `tdicodigo`, `clbsexo`, `crgcodigo`, `ctccodigo`, `clbemail`, `clbfechanacimiento`, `clbnotificacionemail`, `clbnotificacionmovil`, `clbfechaingreso`, `cblimagen`, `clbestado` FROM `btycolaborador` WHERE trcdocumento = $documento";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
        echo 'TRUE';
} else {
    //echo '<div id="Success">Well</div>';
    $sql= "SELECT `tdicodigo`, `trcdocumento`, `trcdigitoverificacion`, `trcnombres`, `trcapellidos`, `trcrazonsocial`, `trcdireccion`, `trctelefonofijo`, `trctelefonomovil`, `brrcodigo`, `trcestado` FROM `btytercero` WHERE trcdocumento = $documento";
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
$conn->close();
}



