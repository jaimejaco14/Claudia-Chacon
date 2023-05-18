<?php 
	include("../../../cnx_data.php");

	$cod_salon = $_POST['cod_salon'];

	$sql = mysqli_query($conn, "SELECT * FROM btycola_atencion WHERE slncodigo = $cod_salon AND tuafechai = CURDATE() AND colhorasalida IS NULL");

	if (mysqli_num_rows($sql) > 0) {
		echo 1;
	}

	mysqli_close($conn);
 ?>