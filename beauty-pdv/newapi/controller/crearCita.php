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

$params = array('clbcodigo' => $_GET['clbcodigo'], "slncodigo" => $_GET['slncodigo'], "sercodigo" => $_GET['sercodigo'], "clicodigo" => $_GET['clicodigo'], "citfecha" => $_GET['citfecha'], "cithora" => $_GET['cithora'], "citobservaciones" => $_GET['citobservaciones']);

$items->clbcodigo = $params['clbcodigo'];
$items->slncodigo = $params['slncodigo'];
$items->sercodigo = $params['sercodigo'];
$items->clicodigo = $params['clicodigo'];
$items->citfecha = $params['citfecha'];
$items->cithora = $params['cithora'];
$items->citobservaciones = $params['citobservaciones'];

$result = $items->crearCita();


if($result == 1){    
    $itemRecords["cita"]=array(); 
        $itemDetails=array(
            "res" => "OK",
            "message" => "Cita Agendada",
        ); 
       array_push($itemRecords["cita"], $itemDetails);
     
    http_response_code(200);   
    

    $values = array_values($itemRecords["cita"]);
  
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

