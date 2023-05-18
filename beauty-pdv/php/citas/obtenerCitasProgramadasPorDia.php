<?php 
	
	include("../../../cnx_data.php");

	$diaActual     = $_REQUEST["diaActual"];
	$codSalon      = $_REQUEST["codSalon"];
	$queryCitasDia = "SELECT * FROM bty_vw_citas_detallado WHERE slncodigo = '$codSalon' AND citfecha = '$diaActual'";
	$resultQuery   = $conn->query($queryCitasDia);

	if($resultQuery != false){

		if(mysqli_num_rows($resultQuery) > 0){

			$citas = array();

			while($registros = $resultQuery->fetch_array()){

				$estado      = "";
				$resultQuery2 = $conn->query("SELECT esccodigo, escnombre, CASE esccodigo WHEN 1 THEN '#56f930' WHEN 2 THEN '#f2e551' WHEN 3 THEN '#f93030' WHEN 4 THEN '#f25186' WHEN 5 THEN '#6a8dfb' WHEN 6 THEN '#6ae6fb' WHEN 7 THEN '#d850f6' ELSE '' END AS backgroundColor FROM btynovedad_cita NATURAL JOIN btyestado_cita WHERE citcodigo = ".$registros["citcodigo"]." AND citfecha = (SELECT MAX(citfecha) FROM btynovedad_cita WHERE citcodigo = ".$registros["citcodigo"].") AND cithora = (SELECT MAX(cithora) FROM btynovedad_cita WHERE citcodigo = ".$registros["citcodigo"].")");

				while($registros2 = $resultQuery2->fetch_array()){

					$codestado = $registros2["esccodigo"];
					$estado    = $registros2["escnombre"];
					$color     = $registros2["backgroundColor"];
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
							"estado"        => $estado,
							"bgcolor"       => $color,
							"codestado"     => $codestado
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