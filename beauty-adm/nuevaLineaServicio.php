<?php 
include '../cnx_data.php';

$nombre           = strtoupper($_REQUEST["nombre"]);
$alias            = strtoupper($_REQUEST["alias"]);
$descripcion      = strtoupper($_REQUEST["descripcion"]);
$subgrupo         = $_REQUEST["subgrupo"];
$imagen           = $_FILES["imagen"]["name"];
$maxcodigo        = 0;
$queryMaxcodLinea = "SELECT MAX(lincodigo) + 1 AS maxcodigo FROM btylinea";
$resultQueryMax   = $conn->query($queryMaxcodLinea);

while($registros = $resultQueryMax->fetch_array()){

	$maxcodigo = $registros["maxcodigo"];
}

if(!empty($imagen)){

    $ruta         = "imagenes/linea/";
    $archivo      = $_FILES["imagen"]["tmp_name"];
    $stringImagen = explode(".", $imagen);
    $extension    = end($stringImagen);
    $nombreImagen = $maxcodigo.".".$extension;
    move_uploaded_file($archivo, $ruta.$maxcodigo.".".$extension);
}
else{

    $nombreImagen = "default.jpg";
}

$queryCrearLinea = "INSERT INTO btylinea (lincodigo, sbgcodigo, linnombre, linalias, lindescripcion, linimagen, linestado) VALUES ($maxcodigo, $subgrupo, '$nombre', '$alias', '$descripcion', '$nombreImagen', 1)";

$resultQueryLinea = $conn->query($queryCrearLinea);

if($resultQueryLinea != false){

	echo json_encode(array("result" => "creado"));
}

mysqli_close($conn);
?>