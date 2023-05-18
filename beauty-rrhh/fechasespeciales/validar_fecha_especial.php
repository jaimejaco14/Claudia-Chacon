<?php 
	include '../../cnx_data.php';

	$fecha = $_POST['fecha'];

	$sql = mysqli_query($conn, "SELECT fesfecha FROM btyfechas_especiales WHERE fesfecha = '$fecha'");

	if (mysqli_num_rows($sql) > 0) {
		echo 1;
	}else{
		echo 2;
	}

	mysqli_close($conn);
 ?>