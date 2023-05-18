<?php
include '../cnx_data.php';
	print_r($_POST);
	$sql = "UPDATE `btyturno` SET `trnestado`= 0 WHERE trncodigo = ".$_POST['turno'];
	if ($conn->query($sql)) {
		echo "TRUE";
	} else {
		# code...
	}
?>
	