<?php
include '../cnx_data.php';
$nombre 	= $_POST['view_nombre'];
$apellido 	= $_POST['view_apellido'];
$tdi 		= $_POST['combo_tdi'];
$documento 	= $_POST['view_documento'];
$fijo 	= $_POST['view_fijo'];
$movil 	= $_POST['view_movil'];
$tiu 		= $_POST['combo_tiu'];
$email 	= $_POST['view_email'];
$dir 		= $_POST['view_dir'];
$brr 		= $_POST['combo_barrio'];


//print_r($_POST);

$sql = "UPDATE `btytercero` SET `trcnombres`='$nombre',`trcapellidos`='$apellido',`trcrazonsocial`='".utf8_decode($_POST['view_nombre'] . " " . $_POST['view_apellido'])."',`trcdireccion`='$dir',`trctelefonofijo`='$fijo',`trctelefonomovil`='$movil',`brrcodigo`='$brr' WHERE tdicodigo = $tdi and trcdocumento = '$documento'";

//echo $sql;

$query = mysqli_query($conn, $sql);

if ($conn->query($sql)) 
{
	$f = "UPDATE `btyusuario` SET `tiucodigo`=$tiu,`usuemail`='$email', usulogin = '".$_POST['view_usu']."' WHERE tdicodigo = $tdi and trcdocumento = '$documento'";

	//echo $f;
	$sql2 = mysqli_query($conn, $f)or die("Error 2 " . mysqli_error($conn));

	if ($sql2)
	{
		echo "TRUE";
	}
}

?>