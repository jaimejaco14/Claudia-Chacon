<?php 
include '../cnx_data.php';

//$citasProgramadas = $_REQUEST["citasProgramadas"];
$salon            = $_REQUEST["salon"];
$queryCitas       = "SELECT citcodigo, clbcodigo, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btycolaborador colaborador  ON tercero.trcdocumento = colaborador.trcdocumento WHERE colaborador.clbcodigo = btycita.clbcodigo) AS clbnombre, slncodigo, (SELECT slnnombre FROM btysalon WHERE slncodigo = btycita.slncodigo) AS slnnombre, (SELECT slndireccion  FROM btysalon WHERE slncodigo = btycita.slncodigo) AS slndireccion, sercodigo, (SELECT sernombre FROM btyservicio WHERE sercodigo = btycita.sercodigo) AS sernombre, (SELECT serduracion FROM btyservicio WHERE sercodigo = btycita.sercodigo) AS serduracion, clicodigo, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btycliente cliente ON tercero.trcdocumento = cliente.trcdocumento WHERE cliente.clicodigo = btycita.clicodigo) AS clinombre, usucodigo, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btyusuario usuario ON tercero.trcdocumento = usuario.trcdocumento WHERE usuario.usucodigo = btycita.usucodigo) AS usunombre, citfecha, cithora, citobservaciones, citfecharegistro, cithoraregistro FROM btycita";

if(!empty($salon)){

	$queryCitas .= " WHERE slncodigo = ".$salon;
}
	/*$queryCitas = "SELECT citcodigo AS codigo, (SELECT CONCAT(tercero.trcnombres,' ',tercero.trcapellidos)
								FROM btytercero tercero INNER JOIN btycolaborador colaborador 
								ON tercero.trcdocumento = colaborador.trcdocumento WHERE colaborador.clbcodigo = btycita.clbcodigo
							) AS colaborador, 
							(SELECT slnnombre 
								FROM btysalon WHERE slncodigo = btycita.slncodigo) AS salon, 
							(SELECT slndireccion 
								FROM btysalon WHERE slncodigo = btycita.slncodigo) AS direccionSalon, 
							(SELECT sernombre 
								FROM btyservicio WHERE sercodigo = btycita.sercodigo) AS servicio, 
							(SELECT serduracion 
								FROM btyservicio WHERE sercodigo = btycita.sercodigo) AS duracionServicio, 
							(SELECT CONCAT(tercero.trcnombres,' ',tercero.trcapellidos) 
								FROM btytercero tercero INNER JOIN btycliente cliente 
								ON tercero.trcdocumento = cliente.trcdocumento WHERE cliente.clicodigo = btycita.clicodigo
								) AS cliente, 
							(SELECT CONCAT(tercero.trcnombres,' ',tercero.trcapellidos) 
								FROM btytercero tercero INNER JOIN btyusuario usuario 
								ON tercero.trcdocumento = usuario.trcdocumento WHERE usuario.usucodigo = btycita.usucodigo
								) AS usuario, citfecha AS fecha, cithora AS hora, citobservaciones AS observaciones, citfecharegistro AS fechaRegistro, cithoraregistro AS horaRegistro 
							FROM btycita";*/
	/*$queryCitas = "SELECT citcodigo AS codigo, clbnombre AS colaborador, slnnombre AS salon, slndireccion AS direccionSalon, sernombre AS servicio, serduracion AS duracionServicio, clinombre AS cliente, usunombre AS usuario, citfecha AS fecha, cithora AS hora, citobservaciones AS observaciones, citfecharegistro AS fechaRegistro, cithoraregistro AS horaRegistro FROM bty_vw_citas_detallado";*/
	

	$resultadoQueryCitas = $conn->query($queryCitas);

	if($resultadoQueryCitas != false){

		if(mysqli_num_rows($resultadoQueryCitas) > 0){

			$citas = array();

			while($registros = $resultadoQueryCitas->fetch_array()){

				$codEstado   = 0;
				$nomEstado   = "";
				$resultQuery = $conn->query("SELECT btyestado_cita.esccodigo, btyestado_cita.escnombre FROM btynovedad_cita NATURAL JOIN btyestado_cita WHERE citcodigo = ".$registros["citcodigo"]." AND citfecha = (SELECT MAX(citfecha) FROM btynovedad_cita WHERE citcodigo = ".$registros["citcodigo"].") AND cithora = (SELECT MAX(cithora) FROM btynovedad_cita WHERE citcodigo = ".$registros["citcodigo"].")");

				while($registros2 = $resultQuery->fetch_array()){

					$codEstado = $registros2["esccodigo"];
					$nomEstado = $registros2["escnombre"];
				}

				$citas[] = array(
								"codigo"         => $registros["citcodigo"],
								"codColaborador" => $registros["clbcodigo"],
								"colaborador"    => $registros["clbnombre"],
								"codSalon"       => $registros["slncodigo"],
								"salon"          => $registros["slnnombre"],
								"direccionSalon" => $registros["slndireccion"],
								"codServicio"    => $registros["sercodigo"],
								"servicio"       => $registros["sernombre"],
								"duracion"       => $registros["serduracion"],
								"codCliente"     => $registros["clicodigo"],
								"cliente"        => $registros["clinombre"],
								"codUsuario"     => $registros["usucodigo"],
								"usuario"        => $registros["usunombre"],
								"fecha"          => $registros["citfecha"],
								"hora"           => $registros["cithora"],
								"observaciones"  => utf8_decode($registros["citobservaciones"]),
								"fechaRegistro"  => $registros["citfecharegistro"],
								"horaRegistro"   => $registros["cithoraregistro"],
								"codEstado"      => $codEstado,
								"nomEstado"      => $nomEstado);
			}

			/*print_r($citas);
			exit;*/
			echo json_encode(array("result" => "full", "citas" => $citas));
			//echo json_encode($citas);
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