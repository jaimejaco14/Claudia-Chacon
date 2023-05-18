<?php 
	include("../../../cnx_data.php");

	$sln = $_POST['sln'];

	$sql = mysqli_query($conn, "DELETE FROM btyturnos_atencion WHERE slncodigo = $sln AND tuafechai = CURDATE()");
	if ($sql) {
		echo 1;
	}
 ?>