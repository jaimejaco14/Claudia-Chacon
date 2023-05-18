<?php 
	include "../cnx_data.php";

	$cod_colaborador 	= $_POST['cod_colaborador'];
	$cod_salon			= $_POST['cod_salon'];

	$con = mysqli_query($conn,  "SELECT colhorasalida, coldisponible,clbcodigo FROM btycola_atencion WHERE clbcodigo = $cod_colaborador AND slncodigo = $cod_salon");

	if (mysqli_num_rows($con) > 0) {
		
		while ($row = mysqli_fetch_array($con)) {
			if ($row['coldisponible'] == 0) {
				echo 1;
			}else{
				if ($row[0] == null || $row[0] == "null") {	

					$sql = mysqli_query($conn, "UPDATE btycola_atencion SET colhorasalida = CURTIME() WHERE clbcodigo = $cod_colaborador AND slncodigo = $cod_salon ");
							if ($sql) {
								echo 2;
							}			
				}
			}
		}
	}else{
		echo 0;
	}

		
		
	mysqli_close($conn);	

?>