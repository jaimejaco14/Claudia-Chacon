<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../class/Items.php';

$database = new Database();
$db = $database->getConnection();
 
$items = new Items($db);



$params = array('colaborador_id' => $_GET['colaborador_id'], "salon_id" => $_GET['salon_id'], "servicio_id" => $_GET['servicio_id'], "cliente_id" => $_GET['cliente_id'], "fecha_cita" => $_GET['fecha_cita'], "hora_cita" => $_GET['hora_cita'], "asunto" => $_GET['asunto']);

$items->colaborador_id = $params['colaborador_id'];
$items->salon_id = $params['salon_id'];
$items->servicio_id = $params['servicio_id'];
$items->cliente_id = $params['cliente_id'];
$items->fecha_cita = $params['fecha_cita'];
$items->hora_cita = $params['hora_cita'];
$items->asunto = $params['asunto'];

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
?>
