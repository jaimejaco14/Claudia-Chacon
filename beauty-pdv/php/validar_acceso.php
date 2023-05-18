<?php
include("../../cnx_data.php");
$usu = $_POST['user'];
$pet = $_POST['peticion'];

$sql = mysqli_query($conn, "SELECT COUNT(usucodigo) as reg FROM btyusuario u INNER JOIN btyprivilegioperfil p ON u.tiucodigo = p.tiucodigo AND p.pricodigo = $pet WHERE u.trcdocumento = $usu")or die(mysqli_error($conn));

$s = mysqli_fetch_array($sql);

if ($s[0] > 0) {
 	echo 1;
 } else{
 	echo 2;
 }


mysqli_close($conn);

?>