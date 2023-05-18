<?php 
	
	include '../cnx_data.php';

	$codigoLista = $_REQUEST["codLista"];
	$query = "UPDATE btylista_precios SET lprestado = 0 WHERE lprcodigo = $codigoLista";
	$conn->query($query);
	
	if(mysqli_affected_rows($conn) > 0){

		echo json_encode(array("result" => "eliminado"));
	}
	else{

		echo json_encode(array("result" => "error"));
	}

	mysqli_close($conn);
?>