<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../class/Items.php';

$database = new Database();
$db = $database->getConnection();
 
$items = new Items($db);

$items->documento = (isset($_GET['documento']) && $_GET['documento']) ? $_GET['documento'] : '0';

$result = $items->cliente();

if($result->num_rows > 0){    
    $itemRecords=array();
    $itemRecords["cliente"]=array(); 
	while ($item = $result->fetch_assoc()) { 	
        extract($item); 
        $itemDetails=array(
	    "documento" => $trcdocumento,
            "cliente_id" => $clicodigo,
            "razonsocial" => $trcrazonsocial,
        ); 
       array_push($itemRecords["cliente"], $itemDetails);
    }    
    http_response_code(200);   
    

    $values = array_values($itemRecords["cliente"]);
  
    echo json_encode($values);
}else{     
    http_response_code(404);     
    echo json_encode(
        array("message" => "No item found.")
    );
} 
?>
