<?php 
include '../cnx_data.php';

$grupos    = array();
$query     = "SELECT grucodigo AS codigo, grunombre AS nombre FROM btygrupo WHERE tpocodigo = 2 AND gruestado = 1";
$resultado = $conn->query($query);

while($registros = $resultado->fetch_array()){

	$grupos[] = array("codigo" => $registros["codigo"], "nombre" => $registros["nombre"]);
}

echo json_encode(array("result" => "full", "grupos" => $grupos));

mysqli_close($conn);
?>