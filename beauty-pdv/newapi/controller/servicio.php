<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../class/Items.php';

$database = new Database();
$db = $database->getConnection();

$items = new Items($db);

$token = $_GET['token'];

// Verificar si el token es válido
if (!isValidToken($token)) {
    http_response_code(403); // Código de error de acceso denegado
    echo json_encode(array("message" => "Acceso denegado. Token inválido."));
    exit;
}


$items->slncodigo = $_GET['slncodigo'];

$result = $items->servicios_colaborador();

if($result->num_rows > 0){
    $itemRecords["servicios"]=array();
        while ($item = mysqli_fetch_assoc($result)) {
        extract($item);
	$nombre_servicio = utf8_encode($sernombre);
        $itemDetails=array(
         "codigo_id" => $sercodigo,
	 "nombre_servicio" => $nombre_servicio
        );
       array_push($itemRecords["servicios"], $itemDetails);
    }
    http_response_code(200);
    $values = array_values($itemRecords["servicios"]);

   // $test = mb_convert_encoding($values, 'UTF-8', 'UTF-8');
    echo json_encode($values);
}else{
    http_response_code(404);
    echo json_encode(
        array("message" => "No item found.")
    );
}

function isValidToken($token) {
    // Comparar el token recibido con el token quemado
    // Puedes cambiar el token quemado por el que necesitas utilizar
    $burnedToken = "CludiaCh4con"; // Token quemado
    return $token == $burnedToken;
}

?>

