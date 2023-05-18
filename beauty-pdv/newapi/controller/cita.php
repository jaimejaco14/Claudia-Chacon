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

$params = array('sercodigo' => $_GET['sercodigo'], "slncodigo" => $_GET['slncodigo'], "citfecha" => $_GET['citfecha'], "cithora" => $_GET['cithora']);
$items->sercodigo = $params['sercodigo'];
$items->slncodigo = $params['slncodigo'];
$items->citfecha = $params['citfecha'];
$items->cithora = $params['cithora'];


$result = $items->disponibilidad();

if($result->num_rows > 0){    
    $itemRecords=array();
    $itemRecords["cita"]=array(); 
	while ($item = $result->fetch_assoc()) { 	
        extract($item); 
        $itemDetails=array(
            "salon_id" => $slncodigo,
            "colaborador_id" => $clbcodigo,
            "servicio_id" => $sercodigo,
        ); 
       array_push($itemRecords["cita"], $itemDetails);
    }    
    http_response_code(200);
    $values = array_values($itemRecords["cita"]);
  
   
    echo json_encode($values);
}else{     
    http_response_code(404);     
    echo json_encode(
        array("message" => "No hay citas.")
    );
} 

function isValidToken($token) {
    // Comparar el token recibido con el token quemado
    // Puedes cambiar el token quemado por el que necesitas utilizar
    $burnedToken = "CludiaCh4con"; // Token quemado
    return $token == $burnedToken;
}

?>

