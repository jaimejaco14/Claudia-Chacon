<?php 
	include '../cnx_data.php';

	$id_producto = $_POST['id_producto'];

	$sql = mysqli_query($conn, "UPDATE btyproducto SET proestado = 0 WHERE procodigo = $id_producto ");

	if ($sql) {
		echo 1;
	}

	mysqli_close($conn);
 ?>