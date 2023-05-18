<?php 
	include '../../cnx_data.php';

	$id    = $_POST['id'];
	$fecha = $_POST['fecha'];

	$sql = mysqli_query($conn, "UPDATE btyestado_colaborador SET cleestado = 0 WHERE clbcodigo = $id AND clefecha = '$fecha'");

	if ($sql) {
		echo 1;
	}

	mysqli_close($conn);
 ?>