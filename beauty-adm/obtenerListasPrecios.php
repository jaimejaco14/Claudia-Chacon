<?php 
	
	include '../cnx_data.php';

	if(isset($_REQUEST["alimentarLista"])){

		$codLista = $_REQUEST["codLista"];
		$query = "SELECT servicio.sercodigo, servicio.sernombre, preciosServicios.lpsvalor FROM btyservicio servicio INNER JOIN btylista_precios_servicios preciosServicios ON servicio.sercodigo = preciosServicios.sercodigo WHERE preciosServicios.lprcodigo = $codLista AND preciosServicios.lpsvalor <> 0 ORDER BY servicio.sernombre";

		$resultQuery = $conn->query($query);

		if($resultQuery != false){
			
			if(mysqli_num_rows($resultQuery) > 0){

				$servicios = array();

				while($registros = $resultQuery->fetch_array()){

								$servicios[] = array(
									"codigo" => $registros["sercodigo"],
									"nombre" => utf8_encode($registros["sernombre"]),
									"precio" => $registros["lpsvalor"]);
				}
				
				echo json_encode(array("result" => "full", "servicios" => $servicios));
			}
			else{

				echo json_encode(array("result" => "vacio"));
			}
		}
		else{

			echo json_encode(array("result" => "error"));
		}
	}
	else{

		$query       = "SELECT * FROM btylista_precios WHERE lprestado = 1 ORDER BY lprnombre";
		$resultQuery = $conn->query($query);

		if($resultQuery != false){

			if(mysqli_num_rows($resultQuery) > 0){

				$listas = array();
				
				while($registros = $resultQuery->fetch_array()){

					$listas[] = array(
									"codigo"        => $registros["lprcodigo"],
									"tipo"          => utf8_decode($registros["lprtipo"]),
									"nombre"        => utf8_decode($registros["lprnombre"]),
									"observaciones" => utf8_decode($registros["lprobservaciones"]));
				}

				echo json_encode(array("result" => "full", "listas" => $listas));
			}
			else{

				echo json_encode(array("result" => "vacio"));
			}
		}
		else{

			echo json_encode(array("result" => "error"));
		}
	}

	mysqli_close($conn);
?>