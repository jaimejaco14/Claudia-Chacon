<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../class/Items.php';

$database = new Database();
$db = $database->getConnection();
 
$items = new Items($db);

//$request_body = file_get_contents('php://input');

//$data = json_decode($request_body, true);

$params = array('salon_id' => $_GET['salon_id'], "fecha_id" => $_GET['fecha_id']);
$items->salon_id = $params['salon_id'];
$items->fecha_id = $params['fecha_id'];

$result = $items->disponibilidad();

if($result->num_rows > 0){    
    $itemRecords=array();
    $itemRecords["turno"]=array(); 

	while ($item = $result->fetch_assoc()) { 	
        extract($item); 

        $duracionServicio = $serduracion;

        $hora = $cithora;
        $horaFin = date("H:i",strtotime("+".$duracionServicio." minutes",strtotime($hora)));
        $itemDetails=array(
            "hora_ocupada" => $cithora,
            "salon_id" => $slncodigo,
 	    "servicio_id" => $sercodigo,
            "duracion" => $serduracion,
            "hasta" => $horaFin,
        ); 
       array_push($itemRecords["turno"], $itemDetails);
    }    
    http_response_code(200);
    $values = array_values($itemRecords["turno"]);
  
    echo json_encode($values);
}else{     
    http_response_code(200);     
    echo json_encode(
        array("message" => "No hay citas.")
    );
} 

?>
