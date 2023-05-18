<?php
	
	include '../cnx_data.php';

	$codServicio = $_REQUEST["codServicio"];
	$nuevoPrecio = $_REQUEST["nuevoPrecio"];
	$query = "UPDATE btylista_precios_servicios SET lpsvalor = $nuevoPrecio WHERE sercodigo = $codServicio";
	$conn->query($query);

	if(mysqli_affected_rows($conn) > 0){

		echo json_encode(array("result" => "actualizado"));
	}
	else{

		echo json_encode(array("result" => "error"));
	}

	mysqli_close($conn);
?>