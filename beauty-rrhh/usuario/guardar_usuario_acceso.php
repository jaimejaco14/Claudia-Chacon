<?php 
	include '../../cnx_data.php';

	$cod_usuario 		= $_POST['cod_usuario'];
	$salon			= $_POST['salon'];
	$fecha_desde		= $_POST['fecha_desde'];
	$fecha_hasta		= $_POST['fecha_hasta'];
	$fecha_indefinida 	= $_POST['fecha_indefinida'];
	$hoy = date("Y-m-d");



$sql = mysqli_query($conn, "SELECT ussdesde, usshasta, ussestado FROM btyusuario_salon WHERE usucodigo = $cod_usuario AND slncodigo = '$salon' AND ussestado = 1 ")or die(mysqli_error($conn));

if (mysqli_num_rows($sql) > 0) 
{
	
	while ($row = mysqli_fetch_array($sql)) 
	{
		if ($row[1] >=$hoy || $row[1] == null) 
		{
			echo "0";
		}
		else
		{
			if ($fecha_desde <= $row[0] AND $fecha_desde <= $row[1]) 
			{
				echo "1";
			}

		}
	}
}
else
{
	if ($fecha_indefinida == null) 
	{
		$sql = mysqli_query($conn, "INSERT INTO btyusuario_salon (usucodigo, slncodigo, ussdesde, usshasta, ussestado) VALUES($cod_usuario, $salon, '$fecha_desde', '$fecha_hasta', 1)")or die(mysqli_error($conn));
			if ($sql) 
			{
				echo 2;
			}
	}
	else
	{
		$sql = mysqli_query($conn, "INSERT INTO btyusuario_salon (usucodigo, slncodigo, ussdesde, usshasta, ussestado) VALUES($cod_usuario, $salon, '$fecha_desde', null, 1)")or die(mysqli_error($conn));
		if ($sql) {
			echo 3;
		}
	}
}

	
 
		mysqli_close($conn);


	
 ?>





