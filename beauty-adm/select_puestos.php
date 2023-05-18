<?php
	include "../cnx_data.php";
	if ($_POST['codigosalon'] != "") {
		$sln = $_POST['codigosalon'];
	}
	$sql = "SELECT ptrcodigo, tptcodigo, ptrnombre, ptrubicacion, ptrimagen, ptrplanta, slncodigo, IF(ptrmultiple = 0, 'No Acepta Múltiple', 'Acepta Múltiple') AS multiple, ptrestado 
FROM btypuesto_trabajo WHERE ptrestado = 1 AND slncodigo = $sln ORDER BY ptrnombre";

    $reslut = $conn->query($sql);
    if ($reslut->num_rows > 0) {
        while ($row = $reslut->fetch_assoc()) {
            echo "<option value='".$row['ptrcodigo']."'>".$row['ptrnombre']. "</option>";
        }
    } else {
        echo "<option value=''>--No hay resultados--</option>";
    }
?>