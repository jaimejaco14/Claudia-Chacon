<?php
//header( 'Content-Type: application/json' );
include '../cnx_data.php';

	$codigo = $_POST['codigo'];
	$nombre = $_POST['nombre'];
	$tipo = $_POST['tipo'];
	$obser = $_POST['observaciones'];

	$date = date('Y-m-d');

	$sql = "UPDATE btylista_precios SET lprnombre = '$nombre', lprtipo = '$tipo', lprobservaciones = '$obser', lprcreacion = '$date' WHERE lprcodigo = $codigo";
		
		if ($conn->query($sql)) {
			echo $sql;
		} else {
			echo mysqli_error($conn);
			echo "<br>";
			echo $sql;
		}
mysqli_close($conn);