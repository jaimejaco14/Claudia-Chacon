<?php 
include '../cnx_data.php';

	$listaSeleccionada = $_REQUEST["codLista"];
	$grupo             = $_REQUEST["codGrupo"];
	$subgrupo          = $_REQUEST["codSubgrupo"];
	$linea             = $_REQUEST["codLinea"];
	$sublinea          = $_REQUEST["codSublinea"];
	$caracteristica    = $_REQUEST["codCaracteristica"];
	$preciosNulos      = $_REQUEST["preciosNulos"];
	$query = "SELECT servicio.sercodigo, servicio.sernombre, preciosServicios.lpsvalor FROM btyservicio servicio INNER JOIN btylista_precios_servicios preciosServicios ON servicio.sercodigo = preciosServicios.sercodigo INNER JOIN bty_vw_servicios_categorias categoria ON servicio.sercodigo = categoria.sercodigo WHERE preciosServicios.lprcodigo = $listaSeleccionada";

	if($grupo != null){

		$query .=" AND categoria.grucodigo = $grupo";

		if($subgrupo != null){

			$query .= " AND categoria.sbgcodigo = $subgrupo";

			if($linea != null){

				$query .= " AND categoria.lincodigo = $linea";

				if($sublinea != null){

					$query .= " AND categoria.sblcodigo = $sublinea";

					if($caracteristica != null){

						$query .= " AND categoria.crscodigo = $caracteristica";
					}
				}
			}
		}
	}

	if($preciosNulos != 0){

		$query .= " AND preciosServicios.lpsvalor = 0";
	}/*
	else{

		$query .= " AND preciosServicios.lpsvalor = 0";
	}*/

	$query .= " ORDER BY servicio.sernombre";

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

	mysqli_close($conn);
?>