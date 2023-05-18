<?php
include '../../cnx_data.php';
$trn=$_POST['turno'];
$sln=$_POST['salon'];
$hr=$_POST['horario'];
	//print_r($_POST);
	//$sql = "UPDATE `btyturno` SET `trnestado`= 0 WHERE trncodigo = ".$_POST['turno'];
	$sql="DELETE FROM btyturno_salon WHERE trncodigo=$trn AND horcodigo=$hr AND slncodigo=$sln";
	if ($conn->query($sql)) {
		echo "TRUE";
	} else {
		# code...
	}
?>
	