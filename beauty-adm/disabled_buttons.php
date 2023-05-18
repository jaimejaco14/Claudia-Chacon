<?php 
	include '../cnx_data.php';

	$salon_turno = $_POST['salon_turno'];

	$cons = mysqli_query($conn, "SELECT colhorasalida, clbcodigo FROM btycola_atencion WHERE slncodigo = 1 AND tuafechai = CURDATE() AND colhorasalida = NULL");

	$row  = mysqli_fetch_array($cons);

	if ($row[0] == null) {
		echo 1;
	}else{
		echo 2;
	}

	
	mysqli_close($conn);
?>