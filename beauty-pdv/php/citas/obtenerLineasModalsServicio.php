<?php 
include '../conexion.php';

$subgrupo  = $_REQUEST["subgrupo"];
$lineas = array();
$query     = "SELECT lincodigo AS codigo, linnombre AS nombre FROM btylinea WHERE sbgcodigo = $subgrupo AND linestado = 1";
$resultado = $conn->query($query);

while($registros = $resultado->fetch_array()){

	$lineas[] = array("codigo" => $registros["codigo"], "nombre" => $registros["nombre"]);
}

echo json_encode(array("result" => "full", "lineas" => $lineas));

mysqli_close($conn);
?>