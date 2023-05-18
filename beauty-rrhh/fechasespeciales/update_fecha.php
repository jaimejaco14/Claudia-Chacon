<?php 
	include '../../cnx_data.php';

	$id 	= $_POST['cod'];
	$tipo 	= $_POST['tipo'];
	$fecha 	= $_POST['fecha'];
	$obse 	= utf8_decode($_POST['obse']);

	$sql = mysqli_query($conn, "UPDATE btyfechas_especiales SET festipo = '$tipo', fesfecha = '$fecha', fesobservacion = '$obse' WHERE fescodigo = $id");

	if ($sql) {
		echo 1;
	}

	mysqli_close($conn);
 ?>