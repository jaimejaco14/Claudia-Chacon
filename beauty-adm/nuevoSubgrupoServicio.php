<?php 
include '../cnx_data.php';

$nombre              = strtoupper($_REQUEST["nombre"]);
$alias               = strtoupper($_REQUEST["alias"]);
$descripcion         = strtoupper($_REQUEST["descripcion"]);
$grupo               = $_REQUEST["grupo"];
$imagen              = $_FILES["imagen"]["name"];
$maxcodigo           = 0;
$queryMaxcodSubgrupo = "SELECT MAX(sbgcodigo) + 1 AS maxcodigo FROM btysubgrupo";
$resultQueryMax      = $conn->query($queryMaxcodSubgrupo);

while($registros = $resultQueryMax->fetch_array()){

	$maxcodigo = $registros["maxcodigo"];
}

if(!empty($imagen)){

    $ruta         = "imagenes/subgrupo/";
    $archivo      = $_FILES["imagen"]["tmp_name"];
    $stringImagen = explode(".", $imagen);
    $extension    = end($stringImagen);
    $nombreImagen = $maxcodigo.".".$extension;
    move_uploaded_file($archivo, $ruta.$maxcodigo.".".$extension);
}
else{

    $nombreImagen = "default.jpg";
}

$queryCrearSubgrupo = "INSERT INTO btysubgrupo (sbgcodigo, grucodigo, sbgnombre, sbgalias, sbgdescripcion, sbgimagen, sbgestado) VALUES ($maxcodigo, $grupo, '$nombre', '$alias', '$descripcion', '$nombreImagen', 1)";

$resultQuerySubgrupo = $conn->query($queryCrearSubgrupo);

if($resultQuerySubgrupo != false){

	echo json_encode(array("result" => "creado"));
}

mysqli_close($conn);
?>