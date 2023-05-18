<?php
include '../cnx_data.php';
$today = date("Y-m-d");
$sql = "INSERT INTO `btyservicio_colaborador`(`sercodigo`, `clbcodigo`, `secdesde`, `sechasta`, `secstado`) VALUES ('".$_POST['sercodigo']."',".$_POST['clbcodigo'].",'$today','$today',1)";
if ($conn->query($sql)) {
	echo "TRUE";
}