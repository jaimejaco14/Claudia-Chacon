<?php
include "../../cnx_data.php";
$codigo = $_POST['codigo'];
$sw = $_POST['sw'];
$sql = "UPDATE `btyusuario` SET `usuestado`= $sw WHERE usucodigo = $codigo";
if ($conn->query($sql)) {
	echo "TRUE";
} else {
	echo "FALSE";
} 