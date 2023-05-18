<?php 
include '../cnx_data.php';

$tipoUsuario = $_REQUEST["tipoUsuario"];
$resultQueryPrivilegio = $conn->query("SELECT * FROM btyprivilegioperfil WHERE pricodigo = 18 AND tiucodigo = $tipoUsuario");

if(mysqli_num_rows($resultQueryPrivilegio) > 0){

	echo json_encode(array("acceso" => "Si"));
}
else{

	echo json_encode(array("acceso" => "No"));
}

mysqli_close($conn);
?>