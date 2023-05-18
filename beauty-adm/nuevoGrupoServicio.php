<?php 
include '../cnx_data.php';

$nombre           = strtoupper($_REQUEST["nombre"]);
$alias            = strtoupper($_REQUEST["alias"]);
$descripcion      = strtoupper($_REQUEST["descripcion"]);
$imagen           = $_FILES["imagen"]["name"];
$maxcodigo        = 0;
$queryMaxcodGrupo = "SELECT MAX(grucodigo) + 1 AS maxcodigo FROM btygrupo";
$resultQueryMax   = $conn->query($queryMaxcodGrupo);

while($registros = $resultQueryMax->fetch_array()){

	$maxcodigo = $registros["maxcodigo"];
}

if(!empty($imagen)){

    $ruta         = "imagenes/grupo/";
    $archivo      = $_FILES["imagen"]["tmp_name"];
    $stringImagen = explode(".", $imagen);
    $extension    = end($stringImagen);
    $nombreImagen = $maxcodigo.".".$extension;
    move_uploaded_file($archivo, $ruta.$maxcodigo.".".$extension);
}
else{

    $nombreImagen = "default.jpg";
}

$queryCrearGrupo = "INSERT INTO btygrupo (grucodigo, tpocodigo, grunombre, grualias, grudescripcion, gruimagen, gruestado) VALUES ($maxcodigo, 2, '$nombre', '$alias', '$descripcion', '$nombreImagen', 1)";

$resultQueryGrupo = $conn->query($queryCrearGrupo);

if($resultQueryGrupo != false){

	echo json_encode(array("result" => "creado"));
}

mysqli_close($conn);
?>