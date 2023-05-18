<?php 
include '../cnx_data.php';

$nombre              = strtoupper($_REQUEST["nombre"]);
$alias               = strtoupper($_REQUEST["alias"]);
$descripcion         = strtoupper($_REQUEST["descripcion"]);
$linea               = $_REQUEST["linea"];
$maxcodigo           = 0;
$imagen              = $_FILES["imagen"]["name"];
$queryMaxcodSublinea = "SELECT MAX(sblcodigo) + 1 AS maxcodigo FROM btysublinea";
$resultQueryMax      = $conn->query($queryMaxcodSublinea);

while($registros = $resultQueryMax->fetch_array()){

	$maxcodigo = $registros["maxcodigo"];
}

if(!empty($imagen)){

    $ruta         = "imagenes/sublinea/";
    $archivo      = $_FILES["imagen"]["tmp_name"];
    $stringImagen = explode(".", $imagen);
    $extension    = end($stringImagen);
    $nombreImagen = $maxcodigo.".".$extension;
    move_uploaded_file($archivo, $ruta.$maxcodigo.".".$extension);
}
else{

    $nombreImagen = "default.jpg";
}

$queryCrearSublinea = "INSERT INTO btysublinea (sblcodigo, lincodigo, sblnombre, sblalias, sbldescripcion, sblimagen, sblestado) VALUES ($maxcodigo, $linea, '$nombre', '$alias', '$descripcion', '$nombreImagen', 1)";

$resultQuerySublinea = $conn->query($queryCrearSublinea);

if($resultQuerySublinea != false){

	echo json_encode(array("result" => "creado"));
}

mysqli_close($conn);
?>