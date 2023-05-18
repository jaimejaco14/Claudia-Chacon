<?php 
include("../../../cnx_data.php");

$caracteristica = $_REQUEST["caracteristica"];

$servicios = array();
$query           = "SELECT sercodigo AS codigo, sernombre AS nombre, serduracion AS duracion FROM btyservicio WHERE crscodigo = '$caracteristica' AND serstado = 1";
$resultado       = $conn->query($query);

while($registros = $resultado->fetch_array()){

	$servicios[] = array("codigo" => $registros["codigo"], "nombre" => $registros["nombre"], "duracion" => $registros["duracion"]);
}

echo json_encode(array("result" => "full", "servicios" => $servicios));

mysqli_close($conn);
?>