<?php
include '../cnx_data.php';
$salon = $_POST['txthide_salon'];
$horario = $_POST['horario'];
$turno = $_POST['turno'];
if ($_POST['codigo'] != "") {
	$desde = $_POST['updesde'];
	$hasta = $_POST['uphasta'];
	$color = $_POST['upcolor'];
	$nombre = $_POST['upturno_name'];
	$codigo = $_POST['codigo'];
	$sql = "UPDATE `btyturno` SET `trnnombre`='$nombre',`trndesde`='$desde',`trnhasta`='$hasta',`trncolor`='$color' WHERE trncodigo = $codigo";

} else {
$sqlmax = "SELECT `trncodigo`, `horcodigo`, `slncodigo` FROM `btyturno_salon` WHERE trncodigo = '$turno' and horcodigo = '$horario' and slncodigo = '$salon'";
$result = $conn->query($sqlmax);
if ($result->num_rows > 0) {
	echo "FALSE";
} else {
	$sql = "INSERT INTO `btyturno_salon`(`trncodigo`, `horcodigo`, `slncodigo`) VALUES ($turno,$horario,$salon)";
if ($conn->query($sql)) {
	# code...
	echo "TRUE";
}
}
}
