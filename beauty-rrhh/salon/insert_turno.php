<?php
include '../../cnx_data.php';
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$color = $_POST['color'];
$nombre = $_POST['turno_name'];
$start = $_POST['start'];
$end = $_POST['end'];
if ($_POST['codigo'] != "") {
	$start = $_POST['upstart'];
	$end = $_POST['upend'];
	$desde = $_POST['updesde'];
	$hasta = $_POST['uphasta'];
	$color = $_POST['upcolor'];
	$nombre = $_POST['upturno_name'];
	$codigo = $_POST['codigo'];
	$sql = "UPDATE `btyturno` SET `trnnombre`='$nombre',`trndesde`='$desde',`trnhasta`='$hasta',`trncolor`='$color',`trninicioalmuerzo`='$start',`trnfinalmuerzo`='$end' WHERE trncodigo = $codigo";

} else {
$sqlmax = "SELECT max(`trncodigo`) m FROM `btyturno`";
$result = $conn->query($sqlmax);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		# code...
		$codigo = $row['m'];
	}
} else {
	$codigo = 0;
}
$codigo = $codigo + 1;
$sql = "INSERT INTO `btyturno`(`trncodigo`, `trnnombre`, `trndesde`, `trnhasta`, `trncolor`, `trninicioalmuerzo`, `trnfinalmuerzo`, `trnestado`) VALUES ($codigo,'$nombre','$desde','$hasta','$color', '$start', '$end', 1)";
}
if ($conn->query($sql)) {
	# code...
	echo "TRUE";
}


