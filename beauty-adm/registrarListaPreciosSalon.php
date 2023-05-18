<?php 
	include '../cnx_data.php';

	$codLista           = $_REQUEST["lista"];
	$codSalon           = $_REQUEST["salon"];
	$desde              = str_replace("/", "-", $_REQUEST["desde"]);
	$hasta              = str_replace("/", "-", $_REQUEST["hasta"]);
	$observaciones      = $_REQUEST["observaciones"];
	$hoy 				= date('Y-m-d');
	//$camposObligatorios = strlen($codLista) * strlen($codSalon) * strlen($desde);


	$consulta = mysqli_query($conn, "SELECT * FROM btylista_precios_salon WHERE lprcodigo = $codLista AND slncodigo = $codSalon");

	if (mysqli_num_rows($consulta) > 0) {
		echo "NO";
	}else{
		$r = mysqli_fetch_array($consulta);

		if ($hasta === null || $hasta === "") {
			
			$query = mysqli_query($conn, "INSERT INTO btylista_precios_salon (lprcodigo, slncodigo, lpsobservaciones, lpsdesde, lpscreacion) VALUES ($codLista, $codSalon, '$observaciones', '$desde', CURDATE())")or die(mysqli_error($conn));

				if ($query) {
					echo 1;
				}
		}else{
			$query = mysqli_query($conn, "INSERT INTO btylista_precios_salon (lprcodigo, slncodigo, lpsobservaciones, lpsdesde, lpshasta, lpscreacion) VALUES ($codLista, $codSalon, '$observaciones', '$desde', '$hasta', CURDATE())")or die(mysqli_error($conn));

				if ($query) {
					echo 1;
				}
		
		}
	}

	mysqli_close($conn);
?>