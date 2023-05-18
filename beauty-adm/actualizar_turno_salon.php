<?php
include '../cnx_data.php';
$salon = $_POST['uptxthide_salon'];
$old_horario = $_POST['txthide_horario'];
$old_turno = $_POST['txthide_turno'];
if ($_POST['upturno'] != "" and $_POST['uphorario'] != "" ) {
	$horario = $_POST['uphorario'];
	$turno = $_POST['upturno'];
	$sql = "UPDATE `btyturno_salon` SET `trncodigo`= $turno, `horcodigo`= $horario WHERE horcodigo = $old_horario and trncodigo = $old_turno and slncodigo = $salon";
	echo $sql;
	if ($conn->query($sql)) {
		echo "TRUE";
	} else {
		//echo "FALSE";
	}
}


