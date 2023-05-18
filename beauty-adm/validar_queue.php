<?php 
	include '../cnx_data.php';

	$cod_salon = $_POST['salon_turno'];
	//print_r($_POST);

	$sql = "SELECT * FROM btycola_atencion WHERE tuafechai = CURDATE() AND slncodigo = $cod_salon AND colhorasalida IS NULL";

	$result = $conn->query($sql);
        if ($result->num_rows > 0) {
        	echo 1;
		}else{
			echo 0;
		}

	
	
	/*if ($count >= 1) {
		echo 1;
	}else{
		echo 0;
	}*/

	mysqli_close($conn);
?>