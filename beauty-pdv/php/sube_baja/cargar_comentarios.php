<?php 
	session_start();
	include("../../../cnx_data.php");

	$cod_salon   = $_SESSION['cod_salon'];

	$con = mysqli_query($conn, "SELECT tuaobservacionesi FROM btyturnos_atencion WHERE slncodigo = $cod_salon AND tuafechai = CURDATE()");

	$comentario = mysqli_fetch_array($con);

	echo utf8_encode($comentario[0]);

	mysqli_close($conn);

 ?>