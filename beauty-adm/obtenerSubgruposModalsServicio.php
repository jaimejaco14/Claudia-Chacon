<?php 
include '../cnx_data.php';

$grupo = $_REQUEST["grupo"];
$subgrupos = array();
$query     = "SELECT sbgcodigo AS codigo, sbgnombre AS nombre FROM btysubgrupo WHERE grucodigo = $grupo AND sbgestado = 1";
$resultado = $conn->query($query);

while($registros = $resultado->fetch_array()){

	$subgrupos[] = array("codigo" => $registros["codigo"], "nombre" => $registros["nombre"]);
}

echo json_encode(array("result" => "full", "subgrupos" => $subgrupos));

mysqli_close($conn);
?>