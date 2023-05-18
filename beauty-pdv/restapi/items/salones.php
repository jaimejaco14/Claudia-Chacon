<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Obtener la solicitud HTTP y la ruta
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = explode('/', $_SERVER['REQUEST_URI']);

include_once '../config/Database.php';
include_once '../class/Items.php';

$database = new Database();
$db = $database->getConnection();
 
$items = new Items($db);

$result = $items->salones();

if($result->num_rows > 0){    
    $itemRecords=array();
    $itemRecords["salon"]=array(); 
	while ($item = $result->fetch_assoc()) { 	
        extract($item); 
        $itemDetails=array(
            "nombre_salon" => $slnnombre,
            "salon_id" => $slncodigo
        ); 
       array_push($itemRecords["salon"], $itemDetails);
    }    
    http_response_code(200); 

    $values = array_values($itemRecords["salon"]);
  
    echo json_encode($values);
}else{     
    http_response_code(404);     
    echo json_encode(
        array("message" => "No item found.")
    );
} 

?>