<?php 
	include '../cnx_data.php';

	$medida = $_POST['medida'];
	$alias  = $_POST['alias'];

	$cons = mysqli_query($conn, "SELECT MAX(umecodigo) AS maxid FROM btyunidad_medida");

	$fila = mysqli_fetch_array($cons);
	$maxid = $fila[0] + 1;

	$sql = mysqli_query($conn, "INSERT INTO btyunidad_medida (umecodigo, umenombre, umealias, umeestado) VALUES ($maxid, '$medida', '$alias', 1)");

	if ($sql) {
		echo 1;
	}

	mysqli_close($conn);
 ?>