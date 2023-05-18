<?php 
	include '../cnx_data.php';

	$codigo = $_POST['codigo'];
	$salon	= $_POST['salon'];

	$sql = mysqli_query($conn, "SELECT coldisponible FROM btycola_atencion WHERE clbcodigo = $codigo AND slncodigo = $salon");
	$row = mysqli_fetch_array($sql);


	if ($row['coldisponible'] == 1) {
		mysqli_query($conn, "UPDATE btycola_atencion SET coldisponible = 0 WHERE clbcodigo = $codigo AND slncodigo = $salon");	
		echo 1;	
	}else{
		mysqli_query($conn, "UPDATE btycola_atencion SET coldisponible = 1 WHERE clbcodigo = $codigo AND slncodigo = $salon");
		echo 0;
	}

	mysqli_close($conn);

 ?>