<?php
	include '../../cnx_data.php';
	$opc=$_POST['operacion'];
	switch($opc){
		case 'deleteturno':
			$sql = "UPDATE `btyhorario` SET `horestado`= 0 WHERE horcodigo = ".$_POST['horario'];
			if ($conn->query($sql)) {
				echo "TRUE";
			} else {
				# code...
			}
		break;

		case 'deletets':
			$sql = "UPDATE btyhorario_salon SET slhfechafin= curdate() WHERE  slncodigo=".$_POST['salon']." and  horcodigo = ".$_POST['horario'] ;
			if ($conn->query($sql)) {
				echo "TRUE";
			} else {
				# code...
			}
		break;
	}