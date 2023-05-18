<?php
include("../../cnx_data.php");
$usu = $_POST['usu'];
$pet = $_POST['cod_peti'];


$sql = "SELECT usucodigo FROM btyusuario u INNER JOIN btyprivilegioperfil p ON u.tiucodigo = p.tiucodigo AND p.pricodigo = $usu WHERE u.trcdocumento = $pet";

$result =$conn->query($sql);
if ($result->num_rows > 0) {
	echo "TRUE";
}

?>