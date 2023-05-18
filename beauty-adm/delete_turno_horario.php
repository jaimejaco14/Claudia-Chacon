<?php
	include '../cnx_data.php';
	$sql = "UPDATE `btyhorario` SET `horestado`= 0 WHERE horcodigo = ".$_POST['horario'];
	if ($conn->query($sql)) {
		echo "TRUE";
	} else {
		# code...
	}