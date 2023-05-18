<?php 
	include '../cnx_data.php';
	$cod_usu = $_POST['cod_usu'];
	$cod_sal = $_POST['cod_sal'];

	$sql = mysqli_query($conn, "UPDATE btyusuario_salon SET ussestado = 0 WHERE usucodigo = $cod_usu AND slncodigo = $cod_sal  ");

	if ($sql) {
		echo 1;
	}
	
	mysqli_close($conn);

 ?>