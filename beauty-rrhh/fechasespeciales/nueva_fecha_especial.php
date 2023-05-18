<?php 
	include '../../cnx_data.php';
	
	$tipo	= $_POST['tipo'];
	$fecha  = $_POST['fecha']; 
	$obser  = $_POST['obser'];

	$sql = mysqli_query($conn, "SELECT MAX(fescodigo) AS maxid FROM btyfechas_especiales");
	$de = mysqli_fetch_array($sql);

	$maxid = $de['maxid'] + 1;

	$cons = mysqli_query($conn, "INSERT INTO btyfechas_especiales (fescodigo, festipo, fesfecha, fesobservacion, fesestado) VALUES ($maxid, '$tipo', '$fecha', '".utf8_decode($obser)."', 1)");

	if ($cons) {
		echo 1;
	}

	mysqli_close($conn);
 ?>