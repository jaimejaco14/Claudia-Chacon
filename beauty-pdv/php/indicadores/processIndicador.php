<?php
	session_start();
	include("../../../cnx_data.php");
	include("../funciones.php");

	switch ($_POST['opcion']) 
	{
		case 'citas':
			
			$QueryCitas = mysqli_query($conn, "SELECT citcodigo, clbcodigo, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btycolaborador colaborador ON tercero.trcdocumento = colaborador.trcdocumento WHERE colaborador.clbcodigo = btycita.clbcodigo) AS clbnombre, slncodigo, (SELECT slnnombre FROM btysalon WHERE slncodigo = btycita.slncodigo) AS slnnombre, (SELECT slndireccion FROM btysalon WHERE slncodigo = btycita.slncodigo) AS slndireccion, sercodigo, (SELECT sernombre FROM btyservicio WHERE sercodigo = btycita.sercodigo) AS sernombre, (SELECT CONCAT(serduracion, ' MIN')AS serduracion FROM btyservicio WHERE sercodigo = btycita.sercodigo) AS serduracion, clicodigo,(SELECT tercero.trctelefonomovil FROM btytercero tercero INNER JOIN btycliente cliente ON tercero.trcdocumento = cliente.trcdocumento WHERE cliente.clicodigo = btycita.clicodigo) AS movil, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btycliente cliente ON tercero.trcdocumento = cliente.trcdocumento WHERE cliente.clicodigo = btycita.clicodigo) AS clinombre, usucodigo, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btyusuario usuario ON tercero.trcdocumento = usuario.trcdocumento WHERE usuario.usucodigo = btycita.usucodigo) AS usunombre, citfecha, cithora, citobservaciones, citfecharegistro, cithoraregistro FROM btycita WHERE slncodigo = '".$_SESSION['PDVslncodigo']."' AND citfecha = CURDATE() ORDER BY cithora");

			$jsonCitas = array();

			if (mysqli_num_rows($QueryCitas) > 0) 
			{				
				 while ($row = mysqli_fetch_array($QueryCitas)) 
				 {

				 	/*$Sql = mysqli_query($conn,"SELECT a.esccodigo AS estado, a.citcodigo, a.citfecha, a.cithora, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$row['citcodigo']."' ORDER BY a.cithora DESC, a.citfecha DESC LIMIT 1");*/

				 	$Sql = mysqli_query($conn,"SELECT MAX(a.esccodigo) AS codEstado, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$row['citcodigo']."' GROUP BY a.esccodigo ORDER BY a.esccodigo DESC LIMIT 1");

				 	$ncita = mysqli_fetch_array($Sql);

				 	$jsonCitas[] = array(
				 		"citcodigo"		=> $row['citcodigo'],
				 		"clbcodigo"		=> $row['clbcodigo'],
				 		"slnnombre"		=> $row['slnnombre'],
				 		"sernombre"		=> $row['sernombre'],
				 		"cliente"		=> $row['clinombre'],
				 		"usunombre"		=> $row['usunombre'],
				 		"colaborador"     => $row['clbnombre'],
				 		"cithora"		=> $row['cithora'],
				 		"fechareg"		=> $row['citfecharegistro'],
				 		"duracion" 		=> $row['serduracion'],
				 		"movil" 		=> $row['movil'],
				 		"estado"          => $ncita['escnombre']
				 	);
				 }

				 $jsonCitas = utf8_converter($jsonCitas);

				 echo json_encode(array("res" => "full", "json" => $jsonCitas));
			}
			else
			{
				echo json_encode(array("res" => "empty"));
			}

			break;

		case 'permisos':
			
			$QueryCitas = mysqli_query($conn, "SELECT a.percodigo, d.trcrazonsocial, b.slnnombre, a.perfecha_registo, a.perhora_registro, a.clbcodigo, a.perfecha_desde, a.perhora_desde, a.perfecha_hasta, a.perhora_hasta, a.perfecha_autorizacion, a.perestado_tramite FROM btypermisos_colaboradores a JOIN btysalon b ON a.slncodigo=b.slncodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero d ON d.trcdocumento=c.trcdocumento WHERE (a.perestado_tramite = 'AUTORIZADO' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.perfecha_desde = CURDATE()) OR ((CURDATE() BETWEEN a.perfecha_desde and a.perfecha_hasta) AND a.perestado_tramite = 'AUTORIZADO' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."') ");

			$jsonCitas = array();

			if (mysqli_num_rows($QueryCitas) > 0) 
			{				
				while ($row = mysqli_fetch_array($QueryCitas)) 
				{
				 	$jsonCitas[] = array(
				 		"idpermiso"		=> $row['percodigo'],
				 		"colaborador"	=> $row['trcrazonsocial'],
				 		"fechades"		=> $row['perfecha_desde'],
				 		"horades"		=> $row['perhora_desde'],
				 		"fechahas"		=> $row['perfecha_hasta'],
				 		"horahas"       => $row['perhora_hasta'],
				 		"fechaaut"		=> $row['perfecha_autorizacion'],
				 		"estado"		=> $row['perestado_tramite']
				 	);
				}

				$jsonCitas = utf8_converter($jsonCitas);

				echo json_encode(array("res" => "full", "json" => $jsonCitas));
			}
			else
			{
				echo json_encode(array("res" => "empty"));
			}

			break;

		case 'colaborador':

		
			
			$QueryCitas = mysqli_query($conn, "SELECT c.clbcodigo, ter.trcrazonsocial, cr.crgnombre, t.trnnombre, cat.ctcnombre FROM btyprogramacion_colaboradores AS p, btytipo_programacion AS tp, btyturno AS t, btycolaborador AS c, btycargo AS cr, btytercero AS ter, btycategoria_colaborador cat WHERE c.clbcodigo=p.clbcodigo AND c.crgcodigo=cr.crgcodigo AND cr.crgincluircolaturnos='1' AND t.trncodigo=p.trncodigo AND tp.tprcodigo=p.tprcodigo AND tp.tprlabora='1' AND ter.trcdocumento=c.trcdocumento AND cat.ctccodigo=c.ctccodigo AND p.slncodigo=".$_SESSION['PDVslncodigo']." AND p.prgfecha= CURDATE() AND (TIME_FORMAT(CURTIME(),'%H:%i:%s') BETWEEN t.trndesde AND t.trnhasta) AND NOT (TIME_FORMAT(CURTIME(),'%H:%i:%s') BETWEEN t.trninicioalmuerzo AND t.trnfinalmuerzo) ORDER BY ter.trcrazonsocial");

			$json = array();

			if (mysqli_num_rows($QueryCitas) > 0) 
			{				
				while ($row = mysqli_fetch_array($QueryCitas)) 
				{
				 	$valSyB = mysqli_query($conn, "SELECT a.clbcodigo as colaborador, a.coldisponible as disponible FROM btycola_atencion a WHERE a.tuafechai = CURDATE() AND a.slncodigo = ".$_SESSION['PDVslncodigo']." AND a.clbcodigo = '".$row['clbcodigo']."' ORDER BY disponible ");

				 	if (mysqli_num_rows($valSyB) > 0) 
				 	{
				 		while ($filas = mysqli_fetch_array($valSyB)) 
				 		{
				 			$cod = $filas['colaborador'];
					 		if ($filas['disponible'] == 1) 
					 		{
					 			$disponible = "DISPONIBLE";
					 		}
					 		else
					 		{
					 			$disponible = "OCUPADO";
					 		}
				 		}

				 	}
				 	else
				 	{
				 		$disponible = "SIN INCLUIR";
				 	}

					 	$json[] = array(
					 		"colaborador"	=> $row['trcrazonsocial'],
					 		"cargo"	        => $row['crgnombre'],
					 		"turno"		    => $row['trnnombre'],
					 		"categoria"		=> $row['ctcnombre'],
					 		"cod"           => $cod,
					 		"dis"           => $disponible
					 	);


				 }

				 $json = utf8_converter($json);

				 echo json_encode(array("res" => "full", "json" => $json));
			}
			else
			{
				echo json_encode(array("res" => "empty"));
			}

			break;	

		case 'cambiarEstadoCita':

			$QueryCitas = mysqli_query($conn, "INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES('".$_POST['estado']."', '".$_POST['idcita']."', CURDATE(), CURTIME(), '".$_SESSION['PDVcodigoUsuario']."', '') ");

			if ($QueryCitas) 
			{
				echo 1;
			}

			 	

			
			break;

		case 'cambiarEstadoCitaInas':

			$sql = mysqli_query($conn, "SELECT a.esccodigo AS estado, a.citcodigo, a.citfecha, a.cithora FROM btynovedad_cita a WHERE a.citcodigo = '".$_POST['idcita']."' ORDER by a.cithora DESC , a.citfecha DESC LIMIT 1");

			$row = mysqli_fetch_array($sql);

			 	switch ($row['estado']) 
			 	{
			 		case '3':
			 			echo "1";
			 			break;

			 		case '8':
			 			echo "2";
			 			break;

			 		case '9':
			 			echo "3";
			 			break;

			 		default:
			 			$QueryCitas = mysqli_query($conn, "INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES('".$_POST['estado']."', '".$_POST['idcita']."', CURDATE(), CURTIME(), '".$_SESSION['PDVcodigoUsuario']."', '') ");

					if ($QueryCitas) 
					{
						echo 5;
					}
			 			break;
			 	}

				break;

			case 'cambiarEstadoCitaCanc':

				$sql = mysqli_query($conn, "SELECT a.esccodigo AS estado, a.citcodigo, a.citfecha, a.cithora FROM btynovedad_cita a WHERE a.citcodigo = '".$_POST['idcita']."' ORDER by a.cithora DESC , a.citfecha DESC LIMIT 1");

				$row = mysqli_fetch_array($sql);

				 	switch ($row['estado']) 
				 	{
				 		case '3':
				 			echo "1";
				 			break;

				 		case '8':
				 			echo "2";
				 			break;

				 		case '9':
				 			echo "3";
				 			break;

				 		/*case '6':
				 			echo "4";
				 			break;*/
				 		
				 		default:
				 			break;
				 	}
				 			$QueryCitas = mysqli_query($conn, "INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES('".$_POST['estado']."', '".$_POST['idcita']."', CURDATE(), CURTIME(), '".$_SESSION['PDVcodigoUsuario']."', '') ");

						if ($QueryCitas) 
						{
							echo 5;
						}

				break;

			case 'cambiarEstadoCitaConfirtel':

				$sql = mysqli_query($conn, "SELECT a.esccodigo AS estado, a.citcodigo, a.citfecha, a.cithora FROM btynovedad_cita a WHERE a.citcodigo = '".$_POST['idcita']."' ORDER by a.cithora DESC , a.citfecha DESC LIMIT 1");

				$row = mysqli_fetch_array($sql);

				 	switch ($row['estado']) 
				 	{
				 		case '3':
				 			echo "1";
				 			break;

				 		case '8':
				 			echo "2";
				 			break;

				 		case '9':
				 			echo "3";
				 			break;

				 		/*case '6':
				 			echo "4";
				 			break;*/
				 		
				 		default:
				 			$QueryCitas = mysqli_query($conn, "INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES('".$_POST['estado']."', '".$_POST['idcita']."', CURDATE(), CURTIME(), '".$_SESSION['PDVcodigoUsuario']."', '') ");

						if ($QueryCitas) 
						{
							echo 5;
						}
				 			break;
				 	}

					break;

			case 'sigcitas':
				
				$QueryCitas = mysqli_query($conn, "SELECT citcodigo, clbcodigo, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btycolaborador colaborador ON tercero.trcdocumento = colaborador.trcdocumento WHERE colaborador.clbcodigo = btycita.clbcodigo) AS clbnombre, slncodigo, ( SELECT slnnombre FROM btysalon WHERE slncodigo = btycita.slncodigo) AS slnnombre, (SELECT slndireccion FROM btysalon WHERE slncodigo = btycita.slncodigo) AS slndireccion, sercodigo, (SELECT sernombre FROM btyservicio WHERE sercodigo = btycita.sercodigo) AS sernombre, (SELECT CONCAT(serduracion, ' MIN') AS serduracion FROM btyservicio WHERE sercodigo = btycita.sercodigo) AS serduracion, clicodigo, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btycliente cliente ON tercero.trcdocumento = cliente.trcdocumento WHERE cliente.clicodigo = btycita.clicodigo) AS clinombre,  usucodigo, (SELECT tercero.trctelefonomovil FROM btytercero tercero INNER JOIN btycliente cliente ON tercero.trcdocumento = cliente.trcdocumento WHERE cliente.clicodigo = btycita.clicodigo) AS movil, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btyusuario usuario ON tercero.trcdocumento = usuario.trcdocumento WHERE usuario.usucodigo = btycita.usucodigo) AS usunombre, citfecha, cithora, citobservaciones, citfecharegistro, cithoraregistro FROM btycita WHERE slncodigo = '".$_SESSION['PDVslncodigo']."' AND citfecha = DATE_ADD(CURDATE(), INTERVAL 1 DAY) ORDER BY cithora");

				$jsonCitas = array();

				if (mysqli_num_rows($QueryCitas) > 0) 
				{				
					 while ($row = mysqli_fetch_array($QueryCitas)) 
					 {

					 	$Sql = mysqli_query($conn,"SELECT a.esccodigo AS estado, a.citcodigo, a.citfecha, a.cithora, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$row['citcodigo']."' ORDER BY a.cithora DESC, a.citfecha DESC LIMIT 1");

					 	$ncita = mysqli_fetch_array($Sql);

					 	$jsonCitas[] = array(
					 		"citcodigo"		=> $row['citcodigo'],
					 		"clbcodigo"		=> $row['clbcodigo'],
					 		"slnnombre"		=> $row['slnnombre'],
					 		"sernombre"		=> $row['sernombre'],
					 		"cliente"		=> $row['clinombre'],
					 		"usunombre"		=> $row['usunombre'],
					 		"colaborador"   => $row['clbnombre'],
					 		"cithora"		=> $row['cithora'],
					 		"fechareg"		=> $row['citfecharegistro'],
					 		"duracion" 		=> $row['serduracion'],
					 		"movil" 		=> $row['movil'],
					 		"estado"        => $ncita['escnombre']
					 	);
					 }

					 $jsonCitas = utf8_converter($jsonCitas);

					 echo json_encode(array("res" => "full", "json" => $jsonCitas));
				}
				else
				{
					echo json_encode(array("res" => "empty"));
				}

				break;

			case 'cumpleclientes':
				$QueryCumpleClientes = mysqli_query($conn, "SELECT b.trcrazonsocial, a.clifechanacimiento, b.trctelefonomovil, a.cliemail FROM btycliente a JOIN btytercero b ON a.trcdocumento=b.trcdocumento WHERE MONTH(a.clifechanacimiento) = MONTH(CURDATE()) AND DAY(a.clifechanacimiento) = DAY(DATE_ADD(CURDATE(), INTERVAL 1 DAY)) ");


				$jsonCumpleClientes = array();

				if (mysqli_num_rows($QueryCumpleClientes) > 0) 
				{				
					 while ($row = mysqli_fetch_array($QueryCumpleClientes)) 
					 {

					 	$jsonCumpleClientes[] = array(
					 		"nombre"		=> $row['trcrazonsocial'],
					 		"movil"		    => $row['trctelefonomovil'],
					 		"email"		    => $row['cliemail']
					 	);
					 }

					 $jsonCumpleClientes = utf8_converter($jsonCumpleClientes);

					 echo json_encode(array("res" => "full", "json" => $jsonCumpleClientes));
				}
				else
				{
					echo json_encode(array("res" => "empty"));
				}

				break;

		case 'meta':

			$QueryMetas = mysqli_query($conn, "SELECT meta.mtatipo, crg.crgnombre, CASE WHEN meta.mtatipo = 'PORCENTAJE' THEN CONCAT('$', FORMAT(meta.mtavalor * (SELECT a.mtavalor FROM btymeta_salon_cargo a WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.mtames = MONTH(CURDATE()) AND a.mtapuntoreferencia = 1) / 100,0)) ELSE CONCAT('$', FORMAT(meta.mtavalor,0)) END as mtavalor FROM btymeta_salon_cargo meta JOIN btycargo crg ON meta.crgcodigo=crg.crgcodigo WHERE meta.slncodigo = '".$_SESSION['PDVslncodigo']."' AND meta.mtames = MONTH(CURDATE()) ORDER BY crg.crgnombre");

			$JsonMetas = array();


			if (mysqli_num_rows($QueryMetas) > 0) 
			{				
				 while ($row = mysqli_fetch_array($QueryMetas)) 
				 {				 	

				 	$JsonMetas[] = array(
				 		"cargo"		=> $row['crgnombre'],
				 		"valor"		=> $row['mtavalor']
				 	);
				 }

				 $JsonMetas = utf8_converter($JsonMetas);

				 echo json_encode(array("res" => "full", "json" => $JsonMetas));
			}
			else
			{
				echo json_encode(array("res" => "empty"));
			}


			break;



			default:
			
			break;
	}
	
 ?>