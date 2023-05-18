<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../class/Items.php';

$database = new Database();
$db = $database->getConnection();
 
$items = new Items($db);

$items->salon_id = (isset($_GET['salon_id']) && $_GET['salon_id']) ? $_GET['salon_id'] : '1';

$result = $items->turno_salon();

if($result->num_rows > 0){    
    $itemRecords=array();
    $itemRecords["turno"]=array(); 
	while ($item = $result->fetch_assoc()) { 	
        extract($item); 
        $itemDetails=array(
            "dia" => $hordia,
            "desde" => $hordesde,
            "hasta" => $horhasta,
        ); 
       array_push($itemRecords["turno"], $itemDetails);
    }    
    http_response_code(200);
    $values = array_values($itemRecords["turno"]);
  
    echo json_encode($values);
}else{     
    http_response_code(404);     
    echo json_encode(
        array("message" => "No item found.")
    );
} 

?>