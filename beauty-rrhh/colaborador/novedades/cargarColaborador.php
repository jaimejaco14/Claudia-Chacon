<?php 
include("../../../cnx_data.php");
include("../../funciones.php");

$colaborador = $_POST['colaborador'];

$query = "SELECT a.clbcodigo, b.trcrazonsocial FROM btycolaborador a JOIN btytercero b ON a.trcdocumento=b.trcdocumento AND a.tdicodigo=b.tdicodigo WHERE b.trcrazonsocial LIKE '%$colaborador%' AND a.clbestado = 1 ORDER BY b.trcrazonsocial ASC";

$resultadoQuery = $conn->query($query);

if(($resultadoQuery != false) && (mysqli_num_rows($resultadoQuery) > 0)){

	$clientes = array();

	while($registros = $resultadoQuery->fetch_array()){

		$clientes[] = array(
			"codigo"        => $registros["clbcodigo"],
			"nombre"        => $registros["trcrazonsocial"]
		);
	}
	

	$clientes = utf8_converter($clientes);
	echo json_encode(array("result" => "full", "data" => $clientes));
}
else
{
	echo json_encode(array("result" => "error"));
}

?>