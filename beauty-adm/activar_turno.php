<?php
	include '../cnx_data.php';

	$nombre = $_POST['nombre'];
	$desde = $_POST['desde'];
	$hasta = $_POST['hasta'];
	$ini_almuerzo = $_POST['start'];
	$fin_almuerzo = $_POST['end'];
	$color = $_POST['color'];

	$query = mysqli_query($conn, "SELECT * FROM btyturno WHERE trndesde = '".$desde."' AND trnhasta = '".$hasta."' AND trninicioalmuerzo = '".$ini_almuerzo."' AND trnfinalmuerzo = '".$fin_almuerzo."' AND trnestado = 0 ");


	if (mysqli_num_rows($query) > 0) {
		$fd = mysqli_fetch_array($query);

		$sql = mysqli_query($conn, "UPDATE btyturno SET trnestado = 1 WHERE trndesde = '".$desde."' AND trnhasta = '".$hasta."' AND trninicioalmuerzo = '".$ini_almuerzo."' AND trnfinalmuerzo = '".$fin_almuerzo."' AND trnestado = 0 ");

		if ($sql){
			echo "TRUE";
		}

	}

?>


	
			
