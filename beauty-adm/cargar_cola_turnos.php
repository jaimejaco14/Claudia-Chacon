<?php 
	include '../cnx_data.php';
	$cod_colaborador = $_POST['cod_colaborador'];
	$cod_salon = $_POST['cod_salon'];


    $query_exist = mysqli_query($conn, "SELECT * FROM btycola_atencion WHERE slncodigo = $cod_salon AND clbcodigo = $cod_colaborador AND tuafechai = CURDATE() AND colhorasalida IS NULL");

    if (mysqli_num_rows($query_exist) > 0) {

    	echo 2;
    	

    }else{
    	$conteo = $conn->query("SELECT count(*) AS maximo_val FROM btycola_atencion WHERE tuafechai = CURDATE() AND slncodigo = $cod_salon ");

		while ($max = $conteo->fetch_assoc()) {
			$res = $max['maximo_val'];
		}
    
		$consulta = mysqli_query($conn, "INSERT INTO btycola_atencion (slncodigo, tuafechai, clbcodigo, colposicion, colhoraingreso, colhorasalida, coldisponible) VALUES ('$cod_salon', CURDATE(), '$cod_colaborador', $res + 1, CURTIME(), null, '1') ")or die(mysqli_error($conn));

		if ($consulta) {
			echo 1;
		}else{
			echo "No se guardo";
		} 	           
         
    }


	/*$cod_ex = mysqli_query($conn, "SELECT DISTINCT slncodigo FROM btycola_atencion");
	while ($d = mysqli_fetch_array($cod_ex)) {
		if ($d[0] == $cod_salon) {
			echo "Ya existe el codigo";
		}else{
			$conteo = $conn->query("SELECT * FROM btycola_atencion WHERE tuafechai = CURDATE() AND slncodigo = $cod_salon");

			if (mysqli_num_rows($conteo) > 0) {

				echo "ya existe este cod nnnnnn";

			}else{
				while ($fila = mysqli_fetch_array($conteo) {
					  if ($fila[0] == $cod_salon) {
					  	  echo 33333;
					  }
				}

	            $sql = mysqli_query($conn, "SELECT * FROM btycola_atencion WHERE tuafechai = CURDATE() AND slncodigo = '$cod_salon' AND clbcodigo = '$cod_colaborador' AND colhorasalida IS NULL");

	            if (mysqli_num_rows($sql) > 0) {
	            	echo "Ya existe";
	            }else{
	            	$consulta = mysqli_query($conn, "INSERT INTO btycola_atencion (slncodigo, tuafechai, clbcodigo, colposicion, colhoraingreso, colhorasalida, coldisponible) VALUES ('$cod_salon', CURDATE(), '$cod_colaborador', '$res' +1, CURTIME(), null, '1') ");
						if ($consulta) {
							echo 1;
						}
	            }
	        }
	    }
	}
*/

	//mysqli_close($conn);

 ?>