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

$params = array('trcdocumento' => $_GET['trcdocumento'], "trcnombres" => 
                                    $_GET['trcnombres'], "trcapellidos" => $_GET['trcapellidos'], "trcemail" => 
                                    $_GET['trcemail'], "trctelefono" => $_GET['trctelefono'], 
                                    "dia_nacimiento" => $_GET['dia_nacimiento'], "mes_nacimiento" => $_GET['mes_nacimiento'],
                                    "tdicodigo" => $_GET['tdicodigo']
                                );


$items->tdicodigo = $params['tdicodigo'];
$items->trcdocumento = $params['trcdocumento'];
$items->trcnombres = $params['trcnombres'];
$items->trcapellidos = $params['trcapellidos'];
$items->trcemail = $params['trcemail'];
$items->trctelefono = $params['trctelefono'];
$items->dia_nacimiento = $params['dia_nacimiento'];
$items->mes_nacimiento = $params['mes_nacimiento'];

$result = $items->crearCliente();

if($result == 1){    
    $itemRecords["cliente"]=array(); 
        $itemDetails=array(
            "res" => "OK",
            "message" => "cliente creado",
        ); 
       array_push($itemRecords["cliente"], $itemDetails);
     
    http_response_code(200);   
    

    $values = array_values($itemRecords["cliente"]);
  
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

