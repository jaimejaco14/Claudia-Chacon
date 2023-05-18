<?php
	include '../cnx_data.php';
	$today = date("Y-m-d");
	$sql = "UPDATE `btyservicio_colaborador` SET `sechasta`='$today',`secstado`= 0 WHERE sercodigo = ".$_POST['sercodigo']." AND clbcodigo = ".$_POST['clbcodigo'];
	if ($conn->query($sql)) {
		echo "TRUE";
	}
?>