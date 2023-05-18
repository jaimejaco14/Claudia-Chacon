<?php 
	include '../../cnx_data.php';

	$bodega 		= $_POST['bodega'];
	$tipo 	        = $_POST['tipo'];
	$cod_sln		= $_POST['cod_sln'];

	$sql = mysqli_query($conn, "UPDATE btybodega_salon SET bostipo = '$tipo' WHERE slncodigo = $cod_sln AND bodcodigo = $bodega ");

	if ($sql) {
		echo 1;
	}

	mysqli_close($conn);


 ?>