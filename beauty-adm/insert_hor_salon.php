<?php
include '../cnx_data.php';
$horario = $_POST['horario'];
$fecha = date("Y-m-d");
$sln = $_POST['sln'];
$sql = "SELECT h.hordia FROM `btyhorario_salon` hs NATURAL JOIN btyhorario h INNER JOIN (SELECT subH.hordia FROM btyhorario subH WHERE subH.horcodigo = $horario) dia ON dia.hordia = h.hordia WHERE hs.slncodigo = $sln";
if ($horario != "") {
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			echo $row['hordia'];
		}
	} else {
		$sql = "INSERT INTO `btyhorario_salon`(`horcodigo`, `slncodigo`, `slhfechainicio`, `slhfechafin`) VALUES ($horario,$sln,'$fecha','$fecha')";
		if ($conn->query($sql)) {
			echo "TRUE";
		}
	}
}