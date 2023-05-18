<?php 
	include '../../cnx_data.php';


	$sql = mysqli_query($conn, "SELECT COUNT(*) FROM btypermisos_colaboradores a WHERE a.perestado_tramite = 'REGISTRADO' AND a.perestado = 1");

	$conteo = mysqli_fetch_array($sql);



	echo $conteo[0];

	//mysqli_close($conn);
 ?>