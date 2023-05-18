<?php
if ($_POST['ser'] != "") {
$ser = $_POST['ser'];
$col = $_POST['id_colaborador'];
include '../../cnx_data.php';
$today = date("Y-m-d");
$c = 0;
for ($i=0;$i<count($ser);$i++){ 
	$codigo = $ser[$i];  
  	$sql = "INSERT INTO `btyservicio_colaborador`(`sercodigo`, `clbcodigo`, `secdesde`, `sechasta`, `secstado`) VALUES ($codigo,$col,'$today','$today',1)";
  	if ($conn->query($sql)) {
  		$c = $c + 1;
  	}
  
}
if (count($ser) == $c) {
	echo "TRUE";
}
}