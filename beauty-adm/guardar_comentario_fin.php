<?php 
	include '../cnx_data.php';

	$comentario_final 	= $_POST['comentario_final'];
	$salon_turno		= $_POST['salon_turno'];
	$usuario			= $_SESSION['codigoUsuario'];
	

	$cons = mysqli_query($conn, "SELECT colhorasalida, clbcodigo FROM btycola_atencion WHERE slncodigo = $salon_turno AND tuafechai = CURDATE()")or die(mysqli_error($conn));

	while ($row = mysqli_fetch_array($cons)) {
		if ($row[0] == null) {
			$r = mysqli_query($conn, "UPDATE btycola_atencion SET colhorasalida = CURTIME() WHERE colhorasalida IS NULL AND slncodigo = $salon_turno ")or die(mysqli_error($conn));
		}
	}

	$sql = mysqli_query($conn, "UPDATE btyturnos_atencion SET tuaobservacionesf = '".utf8_decode($comentario_final)."', usucodigof = $usuario, tuahoraf = CURTIME()  WHERE slncodigo = $salon_turno AND tuafechai = CURDATE()")or die(mysqli_error($conn));

	if ($sql) {
		echo 1;
	}

	mysqli_close($conn);
 ?>