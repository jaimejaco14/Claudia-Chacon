<?php 
	include '../cnx_data.php';

	$nombre = $_POST['nombre'];

	$sql = mysqli_query($conn, "SELECT bodnombre FROM btybodega WHERE bodnombre = '$nombre'");

	if (mysqli_num_rows($sql) > 0) {
		 echo 1;
	}

	mysqli_close($conn);
 ?>