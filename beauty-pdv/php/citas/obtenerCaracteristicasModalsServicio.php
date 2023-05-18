<?php 
include("../../../cnx_data.php");

$sublinea = $_REQUEST["sublinea"];

$caracteristicas    = array();
$query     = "SELECT crscodigo AS codigo, crsnombre AS nombre FROM btycaracteristica WHERE sblcodigo = '$sublinea' AND crsestado = 1";
$resultado = $conn->query($query);

while($registros = $resultado->fetch_array()){

	$caracteristicas[] = array("codigo" => $registros["codigo"], "nombre" => $registros["nombre"]);
}

echo json_encode(array("result" => "full", "caracteristicas" => $caracteristicas));

mysqli_close($conn);
?>