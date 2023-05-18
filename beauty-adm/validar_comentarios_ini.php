<?php 
include '../cnx_data.php';

	$salon_turno = $_POST['salon_turno'];

	$con = mysqli_query($conn, "SELECT tuaobservacionesi FROM btyturnos_atencion WHERE slncodigo = $salon_turno AND tuafechai = CURDATE()");

	$comentario = mysqli_fetch_array($con);

	echo utf8_encode($comentario[0]);

	mysqli_close($conn);

 ?>