<?php 
	include '../cnx_data.php';


	$sql = mysqli_query($conn, "UPDATE btypermisos_colaboradores SET perestado = 0 WHERE percodigo = '".$_POST['cod']."' ");

	if ($sql) 
	{
		echo 1;
	}
?>