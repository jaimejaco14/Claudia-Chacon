<?php 
	
	/*Este PHP permite obtener los datos necesarios para cargar 
	los select2 que son seleccionados para editar en el modal Detalle Cita*/

	include("../../../cnx_data.php");

	if(isset($_REQUEST["salonDetalle"])){

		$query = "SELECT slncodigo,	slnnombre, slndireccion	FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre";
		$resultQuery = $conn->query($query);

		if($resultQuery != false){

			if(mysqli_num_rows($resultQuery) > 0){

				$salones = array();

				while($registros = $resultQuery->fetch_array()){

					$salones[] = array(
									"codigo"    => $registros["slncodigo"],
									"nombre"    => $registros["slnnombre"],
									"direccion" => $registros["slndireccion"]
								);
				}

				echo json_encode(array("result" => "full", "salones" => $salones));
			}
			else{

				echo json_encode(array("result" => "vacio"));	
			}
		}
		else{

			echo json_encode(array("result" => "error"));
		}
	}
	elseif(isset($_REQUEST["servicioDetalle"])){

		$query       = "SELECT sercodigo, sernombre, serduracion FROM btyservicio WHERE serstado = 1 ORDER BY sernombre";
		$resultQuery = $conn->query($query);

		if($resultQuery != false){

			if(mysqli_num_rows($resultQuery) > 0){

				$servicios = array();

				while($registros = $resultQuery->fetch_array()){

					$servicios[] = array(
									"codigo"   => $registros["sercodigo"],
									"nombre"   => $registros["sernombre"],
									"duracion" => $registros["serduracion"]
								);
				}

				function utf8_converter($array){
					array_walk_recursive($array, function(&$item, $key){
						if(!mb_detect_encoding($item, 'utf-8', true)){
							$item = utf8_encode($item);
						}
					});

					return $array;
				}

				$servicios= utf8_converter($servicios);

					//echo json_encode($array);

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
	elseif(isset($_REQUEST["clienteDetalle"])){

		$query       = "SELECT cliente.trcdocumento AS documento, cliente.clicodigo AS codigo, tercero.trcrazonsocial AS nombreCompleto  FROM btycliente AS cliente INNER JOIN btytercero AS tercero ON cliente.trcdocumento = tercero.trcdocumento ORDER BY nombreCompleto";
		$resultQuery = $conn->query($query);

		if($resultQuery != false){

			if(mysqli_num_rows($resultQuery) > 0){

				$clientes = array();

				while($registros = $resultQuery->fetch_array()){

					$clientes[] = array(
									"codigo"    => $registros["codigo"],
									"nombre"    => $registros["nombreCompleto"],
									"documento" => $registros["documento"]
								);
				}

				function utf8_converter($array){
					array_walk_recursive($array, function(&$item, $key){
						if(!mb_detect_encoding($item, 'utf-8', true)){
							$item = utf8_encode($item);
						}
					});

					return $array;
				}

				$clientes= utf8_converter($clientes);

				echo json_encode(array("result" => "full", "clientes" => $clientes));
			}
			else{

				echo json_encode(array("result" => "vacio"));	
			}
		}
		else{

			echo json_encode(array("result" => "error"));
		}
	}
	elseif(isset($_REQUEST["colaboradorDetalle"])){

		$salon    = $_REQUEST["salon"];
		$servicio = $_REQUEST["servicio"];
		$query    = "SELECT colaborador.clbcodigo AS clbcodigo, tercero.trcrazonsocial AS clbnombre FROM btycolaborador colaborador NATURAL JOIN btytercero tercero ORDER BY tercero.trcrazonsocial";
		$resultColaboradores = $conn->query($query);

		if($resultColaboradores != false){

			if(mysqli_num_rows($resultColaboradores) > 0){

				$colaboradores = array();

				while($registrosColaboradores = $resultColaboradores->fetch_array()){

					$colaboradores[] = array("codigo" => $registrosColaboradores["clbcodigo"], "nombre" => utf8_encode($registrosColaboradores["clbnombre"]));
				}

				function utf8_converter($array){
					array_walk_recursive($array, function(&$item, $key){
						if(!mb_detect_encoding($item, 'utf-8', true)){
							$item = utf8_encode($item);
						}
					});

					return $array;
				}

				$colaboradores= utf8_converter($colaboradores);

				echo json_encode(array("result" => "full", "colaboradores" => $colaboradores));
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