<?php 
	include("../../../cnx_data.php");

	$sql = mysqli_query($conn, "UPDATE btypermisos_colaboradores SET perobservacion_registro = '".strtoupper($_POST['ob'])."', perfecha_desde = '".$_POST['fd']."', perhora_desde = '".$_POST['hd']."', perfecha_hasta = '".$_POST['fh']."', perhora_hasta = '".$_POST['hh']."' WHERE percodigo = '".$_POST['id']."' ")or die(mysqli_error($conn));

	if ($sql) 
	{
		echo 1;
	}

	mysqli_close($conn);
?>