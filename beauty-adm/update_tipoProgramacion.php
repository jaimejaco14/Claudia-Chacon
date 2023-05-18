<?php 
include '../cnx_data.php';
if ($_POST['fecha'] != "" and $_POST['colaborador'] != ""){
$fecha = $_POST['fecha'];
$cola =  $_POST['colaborador'];
$new = $_POST['nuevo'];
	$sql = "UPDATE `btyprogramacion_colaboradores` SET `tprcodigo`='$new' WHERE clbcodigo = $cola AND prgfecha = '$fecha'";
	if ($conn->query($sql)) {
		echo "TRUE";
	} else {
		echo "FALSE";
	}
}