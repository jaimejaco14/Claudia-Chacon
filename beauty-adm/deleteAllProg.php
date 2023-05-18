<?php 
	//session_start();
	include '../cnx_data.php';


	$QueryDelete = mysqli_query($conn, "DELETE FROM btyprogramacion_colaboradores WHERE trncodigo = '".$_POST['turno']."' AND slncodigo = '".$_POST['salon']."' AND prgfecha = '".$_POST['fecha']."'");

	if ($QueryDelete) 
	{
		echo 1;
	}

	mysqli_close($conn);
 ?>