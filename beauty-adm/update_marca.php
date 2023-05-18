<?php
//include 'conexion.php';
$nombre = strtoupper($_POST['upmarname']);
$cod = $_POST['cod'];
$sql = "UPDATE `btymarca_activo` SET `marnombre`='$nombre' WHERE marcodigo = $cod";
if ($conn->query($sql)) {
	echo "TRUE";
}