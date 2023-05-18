<?php 
include '../cnx_data.php';
$p = $_POST['one'];
$cod = $_POST['tipo'];
$del = "DELETE FROM `btyprivilegioperfil` WHERE tiucodigo = $cod";
if ($conn->query($del)) {
	$count = 0;
	for ($i=0;$i<count($p);$i++){

		$sql = "INSERT INTO `btyprivilegioperfil`(`pricodigo`, `tiucodigo`) VALUES (".$p[$i].",$cod)";
		if ($conn->query($sql)) {
			$count = $count + 1;
		}
	}     
}
if (count($p) == $count) {
	echo "TRUE";
}
