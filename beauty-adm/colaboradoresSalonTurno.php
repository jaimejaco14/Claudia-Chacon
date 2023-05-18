<?php 
	
	include '../cnx_data.php';

	$codSalon           = $_REQUEST["codSalon"];
	$queryColaboradores = "SELECT btycola_atencion.*, tercero.trcrazonsocial, colaborador.cblimagen, cargo.crgnombre, categoria.ctcnombre FROM btycola_atencion NATURAL JOIN btytercero tercero NATURAL JOIN btycolaborador colaborador INNER JOIN btycargo cargo ON cargo.crgcodigo = colaborador.crgcodigo INNER JOIN btycategoria_colaborador categoria ON colaborador.ctccodigo = categoria.ctccodigo WHERE btycola_atencion.slncodigo = $codSalon AND btycola_atencion.colhorasalida is NULL ORDER BY btycola_atencion.colposicion";
	$resultQuery        = $conn->query($queryColaboradores);
	$colaboradores      = array();

	if($resultQuery != false){

		if(mysqli_num_rows($resultQuery) > 0){

			while($registros = $resultQuery->fetch_array()){

				$colaboradores[] = array(
									"codigo"    => $registros["clbcodigo"],
									"posicion"  => $registros["colposicion"],
									"estado"    => $registros["coldisponible"],
									"nombre"    => utf8_encode($registros["trcrazonsocial"]),
									"imagen"    => $registros["cblimagen"],
									"cargo"     => $registros["crgnombre"],
									"categoria" => $registros["ctcnombre"]);
			}

			echo json_encode(array("result" => "full", "colaboradores" => $colaboradores));
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