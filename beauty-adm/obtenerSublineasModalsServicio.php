<?php 
include '../cnx_data.php';

$linea     = $_REQUEST["linea"];
$sublineas = array();
$query     = "SELECT sblcodigo AS codigo, sblnombre AS nombre FROM btysublinea WHERE lincodigo = $linea AND sblestado = 1";
$resultado = $conn->query($query);

while($registros = $resultado->fetch_array()){

	$sublineas[] = array("codigo" => $registros["codigo"], "nombre" => $registros["nombre"]);
}

echo json_encode(array("result" => "full", "sublineas" => $sublineas));

mysqli_close($conn);
?>