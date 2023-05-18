<?php
include '../../cnx_data.php';
$nombre = $_POST['view_nombre'];
$apellido = $_POST['view_apellido'];
$tdi =$_POST['combo_tdi'];
$documento = $_POST['view_documento'];
$fijo = $_POST['view_fijo'];
$movil = $_POST['view_movil'];
$tiu = $_POST['combo_tiu'];
$email = $_POST['view_email'];
$dir = $_POST['view_dir'];
$brr = $_POST['combo_barrio'];

$sql = "UPDATE `btytercero` SET `trcnombres`='$nombre',`trcapellidos`='$apellido',`trcrazonsocial`='$nombre $apellido',`trcdireccion`='$dir',`trctelefonofijo`='$fijo',`trctelefonomovil`='$movil',`brrcodigo`='$brr' WHERE tdicodigo = $tdi and trcdocumento = $documento";
if ($conn->query($sql)) {
	$sql = "UPDATE `btyusuario` SET tiucodigo=$tiu, usuemail='$email' WHERE tdicodigo = $tdi and trcdocumento = $documento";
	if ($conn->query($sql)) {
		echo "TRUE";
	}
}
