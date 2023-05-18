<?php 
	session_start();
	//header("Content-Type: Application/Json");'".$_SESSION['PDVslncodigo']."'
	include("../../../cnx_data.php");


$queryCitas = "SELECT citcodigo, clbcodigo, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btycolaborador colaborador  ON tercero.trcdocumento = colaborador.trcdocumento WHERE colaborador.clbcodigo = btycita.clbcodigo) AS clbnombre, slncodigo, (SELECT slnnombre FROM btysalon WHERE slncodigo = btycita.slncodigo) AS slnnombre, (SELECT slndireccion  FROM btysalon WHERE slncodigo = btycita.slncodigo) AS slndireccion, sercodigo, (SELECT sernombre FROM btyservicio WHERE sercodigo = btycita.sercodigo) AS sernombre, (SELECT serduracion FROM btyservicio WHERE sercodigo = btycita.sercodigo) AS serduracion, clicodigo, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btycliente cliente ON tercero.trcdocumento = cliente.trcdocumento WHERE cliente.clicodigo = btycita.clicodigo) AS clinombre, usucodigo, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btyusuario usuario ON tercero.trcdocumento = usuario.trcdocumento WHERE usuario.usucodigo = btycita.usucodigo) AS usunombre, citfecha, cithora, citobservaciones, citfecharegistro, cithoraregistro FROM btycita WHERE slncodigo = '".$_SESSION['PDVslncodigo']."'";

	/*echo "<script>console.log(".$queryCitas.")</script><br>";*/
	

	$resultadoQueryCitas = $conn->query($queryCitas);

	if($resultadoQueryCitas != false)
	{

		if(mysqli_num_rows($resultadoQueryCitas) > 0)
		{

			$citas = array();

			while($registros = $resultadoQueryCitas->fetch_array())
			{
                /*echo "<script>console.log(".$registros["citcodigo"].")</script><br>";*/

				$codEstado   = 0;
				$nomEstado   = "";

				$Fetch = "SELECT esccodigo, CASE esccodigo WHEN 1 THEN '#56f930' WHEN 2 THEN '#62cb31' WHEN 3 THEN '#f93030' WHEN 4 THEN '#f25186' WHEN 5 THEN '#6a8dfb' WHEN 6 THEN '#6ae6fb' WHEN 7 THEN '#d850f6' WHEN 8 THEN '#34495e' WHEN 9 THEN '#50c0c1' ELSE '' END AS backgroundColor, CASE  esccodigo WHEN 1 THEN 'AGENDADA POR FUNCIONARIO' WHEN 2 THEN 'AGENDADA POR CLIENTE' WHEN 3 THEN 'CANCELADA' WHEN 4 THEN 'RECORDADA VIA SMS' WHEN 5 THEN 'RECORDADA VIA EMAIL' WHEN 6 THEN 'CONFIRMADA TELEFONICAMENTE' WHEN 7 THEN 'REPROGRAMADA' WHEN 8 THEN 'ATENDIDA' WHEN 9 THEN 'INASISTENCIA' ELSE '' END AS estado FROM btynovedad_cita NATURAL JOIN btyestado_cita WHERE citcodigo = ".$registros["citcodigo"]." AND citfecha = (SELECT MAX(citfecha) FROM btynovedad_cita WHERE citcodigo = ".$registros["citcodigo"].") AND cithora = (SELECT MAX(cithora) FROM btynovedad_cita WHERE citcodigo = ".$registros["citcodigo"]." AND citfecha = (SELECT MAX(citfecha) FROM btynovedad_cita WHERE citcodigo =  ".$registros["citcodigo"]."))";



	

				$resultQuery = mysqli_query($conn, $Fetch);


				while($registros2 = $resultQuery->fetch_array())
				{

					$codEstado 			= $registros2["esccodigo"];
					$nomEstado 			= $registros2["escnombre"];
					$backgroundColor 	= $registros2['backgroundColor'];
					$estado 			= $registros2['estado'];
				}


				$citas[] = array(
								"codigo"         => $registros["citcodigo"],
								"codColaborador" => $registros["clbcodigo"],
								"colaborador"    => utf8_encode($registros["clbnombre"]),
								"codSalon"       => $registros["slncodigo"],
								"salon"          => $registros["slnnombre"],
								"direccionSalon" => utf8_encode($registros["slndireccion"]),
								"codServicio"    => $registros["sercodigo"],
								"servicio"       => utf8_encode($registros["sernombre"]),
								"duracion"       => $registros["serduracion"],
								"codCliente"     => $registros["clicodigo"],
								"cliente"        => utf8_encode($registros["clinombre"]),
								"codUsuario"     => $registros["usucodigo"],
								"usuario"        => utf8_encode($registros["usunombre"]),
								"fecha"          => $registros["citfecha"],
								"hora"           => $registros["cithora"],
								"observaciones"  => utf8_encode($registros["citobservaciones"]),
								"fechaRegistro"  => $registros["citfecharegistro"],
								"horaRegistro"   => $registros["cithoraregistro"],
								"codEstado"      => $codEstado,
								"nomEstado"      => $nomEstado,
								"estado"         => $estado,
								"backgroundColor" => $backgroundColor);

			
			}

			echo json_encode(array("result" => "full", "citas" => $citas));
			//echo json_encode(array("el query llego aqui?" => "si"));
		}
		else
		{
			echo json_encode(array("result" => "vacio"));
		}
	}
	else
	{
		echo json_encode(array("result" => "error"));
	}

	mysqli_close($conn);
?>