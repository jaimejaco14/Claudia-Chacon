<?php 
	include '../../cnx_data.php';

	$QueryEliminar = mysqli_query($conn, "UPDATE btynovedades_programacion SET nvpestado = 'ELIMINADO' WHERE nvpcodigo = '".$_POST['idnovedad']."'");

	if ($QueryEliminar) 
	{
		echo 1;
	}

	mysqli_close($conn);
 ?>