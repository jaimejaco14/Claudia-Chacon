<?php 
	include '../cnx_data.php';

	$impuesto = $_POST['impuesto'];
	$alias    = $_POST['alias'];
	$tipo     = $_POST['tipo'];
	$valor    = $_POST['valor'];


	$cons = mysqli_query($conn, "SELECT MAX(imvcodigo) AS maxid FROM btyimpuesto_ventas");

	$fila = mysqli_fetch_array($cons);
	$maxid = $fila[0] + 1;

	$sql = mysqli_query($conn, "INSERT INTO btyimpuesto_ventas (imvcodigo, imvnombre, imvalias, imvporcentaje, imvalor, imvestado) VALUES ($maxid, '$impuesto', '$alias', $tipo, $valor, 1)")or die("Error " . mysqli_error($conn));

	if ($sql) {
		echo 1;
	}

	mysqli_close($conn);
 ?>