<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include_once '../config/Database.php';
include_once '../class/Items.php';

$database = new Database();
$db = $database->getConnection();
 
$items = new Items($db);

$items->colaborador_id = (isset($_GET['colaborador_id']) && $_GET['colaborador_id']) ? $_GET['colaborador_id'] : '1';

$result = $items->servicios_colaboradores();


if($result->num_rows > 0){    
    $itemRecords=array();
    $itemRecords["servicios"]=array(); 
	while ($item = $result->fetch_assoc()) { 	
        extract($item); 
        $itemDetails=array(
 	    "colaborador_id" => $clbcodigo,
            "servicio_id" => $sercodigo,
            "nombre_servicio" => $sernombre,
            "nombre_colaborador" => $trcrazonsocial,
        ); 
       array_push($itemRecords["servicios"], $itemDetails);
    }
    http_response_code(200);
   $values = array_values($itemRecords["servicios"]);
  echo json_encode($values);
}else{     
    http_response_code(404);     
    echo json_encode(
        array("message" => "No item found.")
    );
} 

?>
