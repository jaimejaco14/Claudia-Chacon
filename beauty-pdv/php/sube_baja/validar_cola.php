<?php 
session_start();
include("../../../cnx_data.php");
$salon = $_SESSION['PDVslncodigo'];

$sql = mysqli_query($conn, "SELECT * FROM btycola_atencion WHERE colhorasalida IS NULL AND tuafechai = CURDATE() AND slncodigo = $salon");

$array = mysqli_fetch_array($sql);

$ds = array_pop($array);

if ($ds < 1) {
	echo 1;
}else{
	echo 2;
}

 mysqli_close($conn);
 ?>