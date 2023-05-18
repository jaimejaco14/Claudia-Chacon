<?php 
include '../cnx_data.php';

$nombre                    = strtoupper($_REQUEST["nombre"]);
$alias                     = strtoupper($_REQUEST["alias"]);
$descripcion               = strtoupper($_REQUEST["descripcion"]);
$sublinea                  = $_REQUEST["sublinea"];
$maxcodigo                 = 0;
$imagen                    = $_FILES["imagen"]["name"];
$queryMaxcodCaracteristica = "SELECT MAX(crscodigo) + 1 AS maxcodigo FROM btycaracteristica";
$resultQueryMax            = $conn->query($queryMaxcodCaracteristica);

while($registros = $resultQueryMax->fetch_array()){

	$maxcodigo = $registros["maxcodigo"];
}

if(!empty($imagen)){

    $ruta         = "imagenes/caracteristica/";
    $archivo      = $_FILES["imagen"]["tmp_name"];
    $stringImagen = explode(".", $imagen);
    $extension    = end($stringImagen);
    $nombreImagen = $maxcodigo.".".$extension;
    move_uploaded_file($archivo, $ruta.$maxcodigo.".".$extension);
}
else{

    $nombreImagen = "default.jpg";
}

$queryCrearCaracteristica = "INSERT INTO btycaracteristica (crscodigo, sblcodigo, crsnombre, crsalias, crsdescripcion, crsimagen, crsestado) VALUES ($maxcodigo, $sublinea, '$nombre', '$alias', '$descripcion', '$nombreImagen', 1)";

$resultQueryCaracteristica = $conn->query($queryCrearCaracteristica);

if($resultQueryCaracteristica != false){

	echo json_encode(array("result" => "creado"));
}

mysqli_close($conn);
?>