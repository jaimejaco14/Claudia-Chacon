<?php 
	
	include '../cnx_data.php';

	$diaActual     = $_REQUEST["diaActual"];
	$codSalon      = $_REQUEST["codSalon"];
	$queryCitasDia = "SELECT * FROM bty_vw_citas_detallado WHERE slncodigo = '$codSalon' AND citfecha = '$diaActual'";
	$resultQuery   = $conn->query($queryCitasDia);

	if($resultQuery != false){

		if(mysqli_num_rows($resultQuery) > 0){

			$citas = array();

			while($registros = $resultQuery->fetch_array()){

				$estado      = "";
				$resultQuery2 = $conn->query("SELECT btyestado_cita.esccodigo, btyestado_cita.escnombre FROM btynovedad_cita NATURAL JOIN btyestado_cita WHERE citcodigo = ".$registros["citcodigo"]." AND citfecha = (SELECT MAX(citfecha) FROM btynovedad_cita WHERE citcodigo = ".$registros["citcodigo"].") AND cithora = (SELECT MAX(cithora) FROM btynovedad_cita WHERE citcodigo = ".$registros["citcodigo"].")");

				while($registros2 = $resultQuery2->fetch_array()){

					$estado = $registros2["escnombre"];
				}

				$citas[] = array(
							"codigo"        => $registros["citcodigo"],
							"colaborador"   => $registros["clbnombre"],
							"salon"         => $registros["slnnombre"],
							"servicio"      => $registros["sernombre"],
							"duracion"      => $registros["serduracion"],
							"cliente"       => $registros["clinombre"],
							"usuario"       => $registros["usnombre"],
							"fecha"         => $registros["citfecha"],
							"hora"          => $registros["cithora"],
							"observaciones" => $registros["citobservaciones"],
							"fechaRegistro" => $registros["citfecharegistro"],
							"horaRegistro"  => $registros["cithoraregistro"],
							"estado"        => $estado
						);
			}

			echo json_encode(array("result" => "full", "citas" => $citas));
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