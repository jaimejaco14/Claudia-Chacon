<?php 
include '../../cnx_data.php';
$desde = $_POST['up_desde'];
$hasta = $_POST['up_hasta'];
$dia = $_POST['up_dia'];
$cod = $_POST['hor_cod'];
$sql = "UPDATE `btyhorario` SET `hordesde`='$desde',`horhasta`='$hasta' WHERE horcodigo = '$cod'";	
if ($conn->query($sql)) {
	echo "TRUE";
} 