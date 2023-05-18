<?php 
	include '../cnx_data.php';

	$cod_usuario  	= $_POST['usu'];
	$cod_salon		= $_POST['cod'];

	$sql = mysqli_query($conn, "UPDATE btyusuario_salon SET usshasta = CURDATE() WHERE usucodigo = $cod_usuario AND slncodigo = $cod_salon" );

	if ($sql) {
		echo 1;
	}

	mysqli_close($conn);
 ?>