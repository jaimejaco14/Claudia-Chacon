<?php
	include '../../cnx_data.php';

	$fecha = $_POST['fecha'];
	$col = $_POST['col'];
	
	$sql="DELETE FROM `btyprogramacion_colaboradores` WHERE prgfecha = '$fecha' and clbcodigo = '$col'";

	if ($conn->query($sql)) 
	{
		echo "TRUE";
	}

	mysqli_close($conn);

?>