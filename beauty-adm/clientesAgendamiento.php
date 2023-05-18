<?php 
include '../cnx_data.php';

$datoCliente = $_REQUEST["datoCliente"];

$query = "SELECT cliente.trcdocumento AS documento,
			cliente.clicodigo AS codigo,
			CONCAT(tercero.trcnombres,' ',tercero.trcapellidos) AS nombreCompleto 
			FROM btycliente AS cliente
			INNER JOIN btytercero AS tercero
			ON cliente.trcdocumento = tercero.trcdocumento
			WHERE (CONCAT(tercero.trcnombres,' ', tercero.trcapellidos) LIKE '%$datoCliente%'
			OR cliente.trcdocumento LIKE '%$datoCliente%')
			AND (cliente.cliestado = 1)
			ORDER BY tercero.trcnombres";

$resultadoQuery = $conn->query($query);

if(($resultadoQuery != false) && (mysqli_num_rows($resultadoQuery) > 0)){

	$clientes = array();

	while($registros = $resultadoQuery->fetch_array()){

		$clientes[] = array(
							"codigo"        => $registros["codigo"],
							"documento"     => $registros["documento"],
							"nombreCliente" => $registros["nombreCompleto"]
						);
	}
	echo json_encode(array("result" => "full", "data" => $clientes));
}
else{
	echo json_encode(array("result" => "error"));
}
$conn->close();
?>