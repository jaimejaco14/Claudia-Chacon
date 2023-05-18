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

$items->documento = $_GET['documento'];

$result = $items->cliente();

if($result->num_rows > 0){    
    $itemRecords=array();
    $itemRecords["cliente"]=array(); 
	while ($item = $result->fetch_assoc()) { 	
        extract($item); 
        $itemDetails=array(
            "num_documento" => $trcdocumento,
            "cliente_id" => $clicodigo,
            "razonsocial" => $trcrazonsocial,
        ); 
       array_push($itemRecords["cliente"], $itemDetails);
    }    
    http_response_code(200);   
    

    $values = array_values($itemRecords["cliente"]);
  
    echo json_encode($values);
}else{     
    http_response_code(200);     
    echo json_encode(
        array("message" => "Cliente no registrado")
    );
} 

function isValidToken($token) {
    // Comparar el token recibido con el token quemado
    // Puedes cambiar el token quemado por el que necesitas utilizar
    $burnedToken = "CludiaCh4con"; // Token quemado
    return $token == $burnedToken;
}

?>

