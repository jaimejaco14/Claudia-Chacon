<?php 

	include '../cnx_data.php';

	$query = "SELECT listaPrecio.lprcodigo, listaPrecio.lprnombre, salon.slncodigo, salon.slnnombre, listaPrecioSalon.lpsobservaciones, listaPrecioSalon.lpsdesde, listaPrecioSalon.lpshasta, listaPrecio.lprtipo FROM btylista_precios listaPrecio INNER JOIN btylista_precios_salon listaPrecioSalon ON listaPrecio.lprcodigo = listaPrecioSalon.lprcodigo INNER JOIN btysalon salon ON listaPrecioSalon.slncodigo = salon.slncodigo ORDER BY salon.slncodigo";
	$resultQuery = $conn->query($query);

	if($resultQuery != false){

		if(mysqli_num_rows($resultQuery) > 0){

			$listasSalones = array();

			while($registros = $resultQuery->fetch_array()){

				$listasSalones[] = array(
										"codLista"      => $registros["lprcodigo"],
										"nomLista"      => $registros["lprnombre"],
										"codSalon"      => $registros["slncodigo"],
										"nomSalon"      => $registros["slnnombre"],
										"tipo"          => $registros["lprtipo"],
										"observaciones" => $registros["lpsobservaciones"],
										"fechaDesde"    => $registros["lpsdesde"],
										"fechaHasta"    => $registros["lpshasta"]);
			}

			echo json_encode(array("result" => "full", "listasSalones" => $listasSalones));
		}
		else{

			echo json_encode(array("result" => "vacio"));
		}
	}
	else{

		echo json_encode(array("result" => "error"));
	}

	mysqli_close($conn);
?>