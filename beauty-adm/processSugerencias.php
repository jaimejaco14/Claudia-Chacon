<?php 
include '../cnx_data.php';

	$Query = mysqli_query($conn, "SELECT MAX(pgrfcodigo) FROM btypqrf");

	$fetch = mysqli_fetch_array($Query);


	$maxCod = $fetch[0] + 1;

	$r = "INSERT INTO btypqrf (pgrfcodigo, pqrftipo, pqrffecha, slncodigo, pgrdescripcion, pgrfnombre_contacto, pgrftelefonofijo_contacto, pgrftelefonomovil_contacto, pgrfemail_contacto) VALUES($maxCod, '".$_POST['tipo']."', CURDATE(), '".$_POST['sln']."', '".utf8_decode($_POST['comentario'])."', '".$_POST['nombre']."', '".$_POST['fijo']."', '".$_POST['movil']."', '".$_POST['email']."')";

	$QueryInsert = mysqli_query($conn, $r)or die(mysqli_error($conn));

	if ($QueryInsert) 
	{
		echo json_encode(array("codigo" => $maxCod, "res" => 1));
	}


	mysqli_close($conn);
 ?>






