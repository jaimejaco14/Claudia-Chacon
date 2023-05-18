<?php 
	include '../cnx_data.php';

	$salon_turno   = $_POST['salon_turno'];
	$comentario_ini = $_POST['comentario_ini'];

	$sql = mysqli_query($conn, "UPDATE btyturnos_atencion SET tuaobservacionesi = '".utf8_decode($comentario_ini)."' WHERE slncodigo = $salon_turno AND tuafechai = CURDATE(); ");

	if ($sql) {
		echo 1;
	}
 ?>