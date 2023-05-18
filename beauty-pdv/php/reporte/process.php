<?php 
	include("../../../cnx_data.php"); 
	include("../funciones.php");


	switch ($_POST['opcion']) 
	{
		case 'selCargos':
			
			if ($_POST['tipo'] == 1) 
			{
				$result = $conn->query("SELECT crgcodigo, crgnombre FROM btycargo WHERE crgestado = 1 AND crgcodigo NOT IN  (4,5,6) ORDER BY crgnombre");
                            if ($result->num_rows > 0) {
                            		echo '<option value="0">TODOS LOS CARGOS</option>';
                                while ($row = $result->fetch_assoc()) {                
                                    echo '<option value="'.$row['crgcodigo'].'">'.$row['crgnombre'].'</option>';
                                }
                            }
			}
			else
			{
				$result = $conn->query("SELECT crgcodigo, crgnombre FROM btycargo WHERE crgestado = 1 ORDER BY crgnombre");
                            if ($result->num_rows > 0) {
                            		echo '<option value="0">TODOS LOS CARGOS</option>';
                                while ($row = $result->fetch_assoc()) {                
                                    echo '<option value="'.$row['crgcodigo'].'">'.$row['crgnombre'].'</option>';
                                }
                            }
			}


			break;


		case 'colaborador':
			
			$query = "SELECT a.trcdocumento, a.clbcodigo, b.trcrazonsocial FROM btycolaborador a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento WHERE (CONCAT(b.trcnombres,' ', b.trcapellidos) LIKE '%".$_POST['colaborador']."%' OR a.trcdocumento LIKE '%".$_POST['colaborador']."%') AND (a.clbestado = 1) ORDER BY b.trcrazonsocial";

			//echo $query;

				$resultadoQuery = $conn->query($query);

				if(($resultadoQuery != false) && (mysqli_num_rows($resultadoQuery) > 0)){

					$colaborador = array();

					while($registros = $resultadoQuery->fetch_array()){

						$colaborador[] = array(
											"codigo"        => $registros["clbcodigo"],
											"documento"     => $registros["trcdocumento"],
											"nombreCol"     => $registros["trcrazonsocial"]
										);
					}

					$colaborador = utf8_converter($colaborador);
					echo json_encode(array("result" => "full", "data" => $colaborador));
				}
				else{
					echo json_encode(array("result" => "error"));
				}


			break;



		case 'reporteAgenda':

			
			$detalles  = json_decode($_POST['colaborador'],true);

			$array = array();

			if ($_POST['cargos'] != 0) 
			{

				if ($_POST['col'] == "") 
				{
					
				

					if (is_array($detalles) || is_object($detalles))
					{

					       foreach($detalles as $obj)
					       {

					            $codigo = $obj['codigo'];


							         $Query = mysqli_query($conn, "SELECT DISTINCT(e.trcrazonsocial), a.clbcodigo, crg.crgnombre,
								(
									SELECT COUNT(*) FROM btycita a JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo JOIN btyestado_cita c ON c.esccodigo=b.esccodigo WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = $codigo AND b.esccodigo = 1 )AS agendadasFuncionario,

								(
									SELECT COUNT(*) FROM btycita a JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo JOIN btyestado_cita c ON c.esccodigo=b.esccodigo WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = $codigo AND b.esccodigo = 2 )AS agendadaCliente,

								(
									SELECT COUNT(*) FROM btycita a JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo JOIN btyestado_cita c ON c.esccodigo=b.esccodigo WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = $codigo AND b.esccodigo = 3 )AS canceladas,

								(
									SELECT COUNT(*) FROM btycita a JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo JOIN btyestado_cita c ON c.esccodigo=b.esccodigo WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = $codigo AND b.esccodigo = 8 )AS atendidas,

								(
									SELECT COUNT(*) FROM btycita a JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo JOIN btyestado_cita c ON c.esccodigo=b.esccodigo WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = $codigo AND b.esccodigo = '".$_SESSION['PDVslncodigo']."' )AS inasistencias,

								(
									SELECT COUNT(*) FROM btycita a JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo JOIN btyestado_cita c ON c.esccodigo=b.esccodigo WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = $codigo AND b.esccodigo = 7)AS reprogramadas


									FROM btycita a JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo JOIN btyestado_cita c ON c.esccodigo=b.esccodigo JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btycargo crg ON crg.crgcodigo=d.crgcodigo WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = $codigo  ");

							         $row = mysqli_fetch_array($Query);

							            $array[] = array(
							             	'nombre' 		=> $row[0], 
							            	'clbcodigo' 	=> $row[1],
							            	'cargo' 		=> $row[2],
							             	'agendaFuncio' 	=> $row[3], 
							             	'agendaClie'	=> $row[4], 
							             	'canceladas' 	=> $row[5], 
							             	'atendidas' 	=> $row[6], 
							             	'inasistencias' 	=> $row[7], 
							             	'reprogramadas' 	=> $row[8],
							             	'desde'           => $_POST['desde'],
							                  'hasta'           => $_POST['hasta']);
					      }

						      $array = utf8_converter($array);
						      echo json_encode(array("res" => "full", "json" => $array));			      	
					     

					}
				}
				else
				{
					 $Query = mysqli_query($conn, "SELECT DISTINCT(e.trcrazonsocial), a.clbcodigo, crg.crgnombre,
						(
							SELECT COUNT(*) FROM btycita a JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo JOIN btyestado_cita c ON c.esccodigo=b.esccodigo WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$_POST['col']."' AND b.esccodigo = 1 )AS agendadasFuncionario,

						(
							SELECT COUNT(*) FROM btycita a JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo JOIN btyestado_cita c ON c.esccodigo=b.esccodigo WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."'  AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$_POST['col']."' AND b.esccodigo = 2 )AS agendadaCliente,

						(
							SELECT COUNT(*) FROM btycita a JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo JOIN btyestado_cita c ON c.esccodigo=b.esccodigo WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."'  AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$_POST['col']."' AND b.esccodigo = 3 )AS canceladas,

						(
							SELECT COUNT(*) FROM btycita a JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo JOIN btyestado_cita c ON c.esccodigo=b.esccodigo WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."'  AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$_POST['col']."' AND b.esccodigo = 8 )AS atendidas,

						(
							SELECT COUNT(*) FROM btycita a JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo JOIN btyestado_cita c ON c.esccodigo=b.esccodigo WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."'  AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$_POST['col']."' AND b.esccodigo = '".$_SESSION['PDVslncodigo']."' )AS inasistencias,

						(
							SELECT COUNT(*) FROM btycita a JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo JOIN btyestado_cita c ON c.esccodigo=b.esccodigo WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."'  AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$_POST['col']."' AND b.esccodigo = 7)AS reprogramadas


							FROM btycita a JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo JOIN btyestado_cita c ON c.esccodigo=b.esccodigo JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btycargo crg ON crg.crgcodigo=d.crgcodigo WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."'  AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$_POST['col']."'  ");

					  	$row = mysqli_fetch_array($Query);

					            $array[] = array(
					             	'nombre' 		=> $row[0], 
					            	'clbcodigo' 	=> $row[1],
					            	'cargo' 		=> $row[2],
					             	'agendaFuncio' 	=> $row[3], 
					             	'agendaClie'	=> $row[4], 
					             	'canceladas' 	=> $row[5], 
					             	'atendidas' 	=> $row[6], 
					             	'inasistencias' 	=> $row[7], 
					             	'reprogramadas' 	=> $row[8],
					             	'desde'           => $_POST['desde'],
					                  'hasta'           => $_POST['hasta']);

					            $array = utf8_converter($array);
						      echo json_encode(array("res" => "full", "json" => $array));
				}

			}
			else
			{//TODOS LOS CARGOS

				$r = "SELECT DISTINCT a.clbcodigo, c.trcrazonsocial FROM btycita a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' ORDER BY c.trcrazonsocial";

				//echo $r;
				 $array = array();

				$sql = mysqli_query($conn, $r);

				if (mysqli_num_rows($sql) > 0) 
				{
					while ($row = mysqli_fetch_array($sql)) 
					{

						$d = "SELECT DISTINCT(e.trcrazonsocial), a.clbcodigo, crg.crgnombre,
						(
							SELECT COUNT(*)
							FROM btycita a
							JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo
							JOIN btyestado_cita c ON c.esccodigo=b.esccodigo
							WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."'  AND b.esccodigo = 1 AND a.clbcodigo = '".$row['clbcodigo']."') AS agendadasFuncionario,

													(
							SELECT COUNT(*)
							FROM btycita a
							JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo
							JOIN btyestado_cita c ON c.esccodigo=b.esccodigo
							WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."'  AND b.esccodigo = 2 AND a.clbcodigo = '".$row['clbcodigo']."') AS agendadaCliente,

													(
							SELECT COUNT(*)
							FROM btycita a
							JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo
							JOIN btyestado_cita c ON c.esccodigo=b.esccodigo
							WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."'  AND b.esccodigo = 3 AND a.clbcodigo = '".$row['clbcodigo']."') AS canceladas,

													(
							SELECT COUNT(*)
							FROM btycita a
							JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo
							JOIN btyestado_cita c ON c.esccodigo=b.esccodigo
							WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."'  AND b.esccodigo = 8 AND a.clbcodigo = '".$row['clbcodigo']."') AS atendidas,

													(
							SELECT COUNT(*)
							FROM btycita a
							JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo
							JOIN btyestado_cita c ON c.esccodigo=b.esccodigo
							WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."'  AND b.esccodigo = 9 AND a.clbcodigo = '".$row['clbcodigo']."') AS inasistencias,

							(
							SELECT COUNT(*) FROM btycita a JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo JOIN btyestado_cita c ON c.esccodigo=b.esccodigo WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."'  AND b.esccodigo = 7 AND a.clbcodigo = '".$row['clbcodigo']."') AS reprogramadas


							FROM btycita a
							JOIN btynovedad_cita b ON b.citcodigo = a.citcodigo
							JOIN btyestado_cita c ON c.esccodigo=b.esccodigo
							JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo
							JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento
							JOIN btycargo crg ON crg.crgcodigo=d.crgcodigo
							WHERE a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' 
							AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' 
							AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$row['clbcodigo']."'";

							//echo $d;
						$Query = mysqli_query($conn, $d);

						
					  	$row2 = mysqli_fetch_array($Query);

					            $array[] = array(
					             	'nombre' 		=> $row2[0], 
					            	'clbcodigo' 	=> $row2[1],
					            	'cargo' 		=> $row2[2],
					             	'agendaFuncio' 	=> $row2[3], 
					             	'agendaClie'	=> $row2[4], 
					             	'canceladas' 	=> $row2[5], 
					             	'atendidas' 	=> $row2[6], 
					             	'inasistencias' 	=> $row2[7], 
					             	'reprogramadas' 	=> $row2[8],
					             	'desde'           => $_POST['desde'],
					                  'hasta'           => $_POST['hasta']);

					            $array = utf8_converter($array);
					}
						      echo json_encode(array("res" => "full", "json" => $array));
				}
				 
			}
		

			break;

		case 'selCol':
			
			
			$sql = mysqli_query($conn, "SELECT DISTINCT a.clbcodigo, c.trcrazonsocial FROM btycita a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND b.crgcodigo = '".$_POST['tipo']."' ORDER BY c.trcrazonsocial");

				if (mysqli_num_rows($sql) > 0) 
				{
					while ($row = mysqli_fetch_array($sql)) 
					{
						echo '<option value="'.$row['clbcodigo'].'">'.utf8_encode($row['trcrazonsocial']).'</option>';
					}
				}
				else
				{
					echo '<option value="">TODOS LOS COLABORADORES</option>';
				}


			break;

		case 'detalles':

			$Query = mysqli_query($conn, "SELECT a.citcodigo, c.trcrazonsocial as colaborador, d.sernombre, trcli.trcrazonsocial as cliente, trcusu.trcnombres as usuario, a.citfecha, a.cithora, a.citfecharegistro, a.cithoraregistro FROM btycita a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btyservicio d ON d.sercodigo=a.sercodigo JOIN btycliente cli ON cli.clicodigo=a.clicodigo JOIN btytercero trcli ON trcli.tdicodigo=cli.tdicodigo AND trcli.trcdocumento=cli.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero trcusu ON trcusu.tdicodigo=usu.tdicodigo AND trcusu.trcdocumento=usu.trcdocumento WHERE a.clbcodigo = '".$_POST['clbcodigo']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.citfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.citfecharegistro BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' ");

				$array = array();

				if (mysqli_num_rows($Query) > 0) 
				{
				

					while ($row = mysqli_fetch_array($Query)) 
					{

						$sql3 = mysqli_query($conn, "SELECT trc.trcnombres FROM btynovedad_cita a JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero trc ON trc.tdicodigo=usu.tdicodigo AND trc.trcdocumento=usu.trcdocumento WHERE a.citcodigo = '".$row['citcodigo']."' ");

						$sql = mysqli_query($conn, "SELECT bty_fnc_estadocita('".$row['citcodigo']."')");

						$row2 = mysqli_fetch_array($sql);

						$fila = mysqli_fetch_array($sql3);



						$nomEstado = mysqli_query($conn, "SELECT * FROM btyestado_cita a WHERE a.esccodigo= '".$row2[0]."' ");

						$estado = mysqli_fetch_array($nomEstado);



						$array[] = array(
							'citcodigo' 	=> $row['citcodigo'],
							'colaborador' 	=> $row['colaborador'],
							'sernombre' 	=> $row['sernombre'],
							'cliente' 	      => $row['cliente'],
							'usuario' 	      => $row['usuario'],
							'citfecha' 	      => $row['citfecha'],
							'cithora' 	      => $row['cithora'],
							'fechaReg'   	=> $row['citfecharegistro'],
							'horaReg'   	=> $row['cithoraregistro'],
							'estado'          => $estado['escnombre'],
							'usuNovedad'      => $fila['trcnombres']
						);
						
						$array = utf8_converter($array);
					}
						echo json_encode(array("res" => "full", "json" => $array));
				}
				else
				{
					echo json_encode(array("res" => "empty"));
				}
			
			break;

		case 'selColBio':

		//print_r($_POST);

		if (isset($_POST['cargo'])) 
		{
			$cargo = " AND crg.crgcodigo = '".$_POST['cargo']."' ";
		}
		else
		{
			$cargo = " ";
		}

		$r = "(SELECT a.clbcodigo, t.trcrazonsocial FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo IN (2, 3) ".$cargo." ORDER BY t.trcrazonsocial 

			) 
				UNION
			(SELECT a.clbcodigo, t.trcrazonsocial FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.abmcodigo IS NULL AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo IN(4,6) ".$cargo." ORDER BY t.trcrazonsocial
			) 
			UNION
			(
			SELECT a.clbcodigo, c.trcrazonsocial FROM btyasistencia_procesada a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo JOIN btyasistencia_procesada_tipo f ON f.aptcodigo=a.aptcodigo WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND  a.aptcodigo = 5 AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' ".$cargo."
		      )
		      UNION
			(
			SELECT a.clbcodigo, c.trcrazonsocial FROM btyasistencia_biometrico a JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo WHERE a.abmfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.abmerroneo = 1 AND a.slncodigo = '".$_SESSION['PDVslncodigo']."'  ".$cargo." ) ORDER BY trcrazonsocial";

			//echo $r;
			 	
			 	$sql = mysqli_query($conn, $r);

				if (mysqli_num_rows($sql) > 0) 
				{
					while ($row = mysqli_fetch_array($sql)) 
					{
						echo '<option value="'.$row['clbcodigo'].'">'.utf8_encode($row['trcrazonsocial']).'</option>';
					}
				}
				else
				{
					echo '<option value="0">NO HAY COLABORADORES</option>';
				}
			break;


		case 'reporteBiometrico':

			$detalles  = json_decode($_POST['colaborador'],true);

			$array = array();

			if ($_POST['cargos'] != 0) 
			{

				if ($_POST['col'] == "") 
				{
					
				

					if (is_array($detalles) || is_object($detalles))
					{

					       foreach($detalles as $obj)
					       {

					            $codigo = $obj['codigo'];


							         $Query = mysqli_query($conn, "(
							SELECT a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre, 
							(SELECT CONCAT('$', FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion 
							FROM btyasistencia_procesada a WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND
							a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = $codigo )as apcvalorizacion
							FROM btyasistencia_procesada a
							JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo
							JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo
							JOIN btytercero t ON t.trcdocumento=c.trcdocumento
							JOIN btysalon s ON s.slncodigo=a.slncodigo
							JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo
							JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo
							JOIN btyturno j ON j.trncodigo=a.trncodigo
							JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo
							WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' 
							AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' 
							AND NOT b.aptfactor = '0.0000'
							AND a.clbcodigo = $codigo 
							AND a.apcobservacion = '' 
							AND a.aptcodigo IN (2, 3) 
							)
							UNION 
							(
							SELECT a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre, 
							(SELECT CONCAT('$', FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion 
							FROM btyasistencia_procesada a WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND
							a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = $codigo)as apcvalorizacion
							FROM btyasistencia_procesada a
							JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo
							JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo
							JOIN btytercero t ON t.trcdocumento=c.trcdocumento
							JOIN btysalon s ON s.slncodigo=a.slncodigo
							JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo
							JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo
							JOIN btyturno j ON j.trncodigo=a.trncodigo
							WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.abmcodigo IS NULL AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo IN(4,6) AND a.clbcodigo = $codigo ORDER BY t.trcrazonsocial) 

							UNION 
							(
							SELECT a.clbcodigo, c.trcrazonsocial, crg.crgnombre, e.ctcnombre, 
							(SELECT CONCAT('$', FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion 
							FROM btyasistencia_procesada a WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND
							a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = $codigo)as apcvalorizacion
							FROM btyasistencia_procesada a
							JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo
							JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento
							JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo
							JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo
							JOIN btyasistencia_procesada_tipo f ON f.aptcodigo=a.aptcodigo
							WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.aptcodigo = 5 AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = $codigo ) 

							UNION (
							SELECT a.clbcodigo, c.trcrazonsocial, crg.crgnombre, e.ctcnombre,  
							(SELECT CONCAT('$', FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion 
							FROM btyasistencia_procesada a WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND
							a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = $codigo)as apcvalorizacion
							FROM btyasistencia_biometrico a
							JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo
							JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento
							JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo
							JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo
							WHERE a.abmfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.abmerroneo = 1 AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = $codigo )
							ORDER BY trcrazonsocial");



							         $row = mysqli_fetch_array($Query);

							            $array[] = array(
							             		'nombre' 		=> $row['trcrazonsocial'], 
								            	'clbcodigo' 	=> $row['clbcodigo'],
								            	'cargo' 		=> $row['crgnombre'],
								             	'categoria' 	=> $row['ctcnombre'], 
								             	'apcvalorizacion' => $row['apcvalorizacion'],
								             	'desde'           => $_POST['desde'],
								                  'hasta'           => $_POST['hasta']);
					      }

						      $array = utf8_converter($array);
						      echo json_encode(array("res" => "full", "json" => $array));			      	
					     

					}

				}
				else
				{
					$array = array();
					 $Query = mysqli_query($conn, "(
							SELECT a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre, 
							(SELECT CONCAT('$', FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion 
							FROM btyasistencia_procesada a WHERE a.clbcodigo = '".$_POST['col']."' AND a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND
							a.slncodigo = '".$_SESSION['PDVslncodigo']."' )as apcvalorizacion
							FROM btyasistencia_procesada a
							JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo
							JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo
							JOIN btytercero t ON t.trcdocumento=c.trcdocumento
							JOIN btysalon s ON s.slncodigo=a.slncodigo
							JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo
							JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo
							JOIN btyturno j ON j.trncodigo=a.trncodigo
							JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo
							WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' 
							AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' 
							AND NOT b.aptfactor = '0.0000' 
							AND a.apcobservacion = ''
							AND a.clbcodigo = '".$_POST['col']."' 
							AND a.aptcodigo IN (2, 3) 
							)

							UNION 
							(
							SELECT a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre, 
							(SELECT CONCAT('$', FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion 
							FROM btyasistencia_procesada a WHERE a.clbcodigo = '".$_POST['col']."' AND a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND
							a.slncodigo = '".$_SESSION['PDVslncodigo']."' )as apcvalorizacion
							FROM btyasistencia_procesada a
							JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo
							JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo
							JOIN btytercero t ON t.trcdocumento=c.trcdocumento
							JOIN btysalon s ON s.slncodigo=a.slncodigo
							JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo
							JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo
							JOIN btyturno j ON j.trncodigo=a.trncodigo
							WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.abmcodigo IS NULL AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.clbcodigo = '".$_POST['col']."' AND a.aptcodigo IN(4,6) ORDER BY t.trcrazonsocial) 

							UNION (
							SELECT a.clbcodigo, c.trcrazonsocial, crg.crgnombre, e.ctcnombre, 
							(SELECT CONCAT('$', FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion 
							FROM btyasistencia_procesada a WHERE a.clbcodigo = '".$_POST['col']."' AND a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND
							a.slncodigo = '".$_SESSION['PDVslncodigo']."' )as apcvalorizacion
							FROM btyasistencia_procesada a
							JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo
							JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento
							JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo
							JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo
							JOIN btyasistencia_procesada_tipo f ON f.aptcodigo=a.aptcodigo
							WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.aptcodigo = 5 AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$_POST['col']."' ) 

							UNION (
							SELECT a.clbcodigo, c.trcrazonsocial, crg.crgnombre, e.ctcnombre,  
							(SELECT CONCAT('$', FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion 
							FROM btyasistencia_procesada a WHERE a.clbcodigo = '".$_POST['col']."' AND a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND
							a.slncodigo = '".$_SESSION['PDVslncodigo']."' )as apcvalorizacion
							FROM btyasistencia_biometrico a
							JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo
							JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento
							JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo
							JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo
							WHERE a.abmfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.abmerroneo = 1 AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$_POST['col']."' )
							ORDER BY trcrazonsocial");

					  	$row = mysqli_fetch_array($Query);

					            $array[] = array(
					             	'nombre' 		=> $row['trcrazonsocial'], 
					            	'clbcodigo' 	=> $row['clbcodigo'],
					            	'cargo' 		=> $row['crgnombre'],
					             	'categoria' 	=> $row['ctcnombre'], 
					             	'apcvalorizacion' => $row['apcvalorizacion'], 
					             	'desde'           => $_POST['desde'],
					                  'hasta'           => $_POST['hasta']);

					            $array = utf8_converter($array);
						      echo json_encode(array("res" => "full", "json" => $array));
				}



			}
			else
			{//TODOS LOS COL CARGO

				$r = "(SELECT a.clbcodigo, t.trcrazonsocial FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo IN (2, 3) ORDER BY t.trcrazonsocial 

				) 
				UNION
					(SELECT a.clbcodigo, t.trcrazonsocial FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.abmcodigo IS NULL AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo IN(4,6) ORDER BY t.trcrazonsocial
				) 
				UNION
				(
					SELECT a.clbcodigo, c.trcrazonsocial FROM btyasistencia_procesada a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo JOIN btyasistencia_procesada_tipo f ON f.aptcodigo=a.aptcodigo WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND  a.aptcodigo = 5 AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' 
		      	)
		      	UNION
				(
				SELECT a.clbcodigo, c.trcrazonsocial FROM btyasistencia_biometrico a JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo WHERE a.abmfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.abmerroneo = 1 AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' ) ORDER BY trcrazonsocial";

				//echo $r;
	
			 	
			 	$sql = mysqli_query($conn, $r);

			 	$array = array();

			 	if (mysqli_num_rows($sql) > 0) 
			 	{
			 		while ($rows = mysqli_fetch_array($sql)) 
			 		{


						$d = "(
							SELECT a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre, 
							(SELECT CONCAT('$', FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion 
							FROM btyasistencia_procesada a WHERE a.clbcodigo = '".$rows['clbcodigo']."' AND a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND
							a.slncodigo = '".$_SESSION['PDVslncodigo']."' )as apcvalorizacion
							FROM btyasistencia_procesada a
							JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo
							JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo
							JOIN btytercero t ON t.trcdocumento=c.trcdocumento
							JOIN btysalon s ON s.slncodigo=a.slncodigo
							JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo
							JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo
							JOIN btyturno j ON j.trncodigo=a.trncodigo
							JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo
							WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' 
							AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' 
							AND NOT b.aptfactor = '0.0000' 
							AND a.apcobservacion = ''
							AND a.clbcodigo = '".$rows['clbcodigo']."' 
							AND a.aptcodigo IN (2, 3) 
							)

							UNION 
							(
							SELECT a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre, 
							(SELECT CONCAT('$', FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion 
							FROM btyasistencia_procesada a WHERE a.clbcodigo = '".$rows['clbcodigo']."' AND a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND
							a.slncodigo = '".$_SESSION['PDVslncodigo']."' )as apcvalorizacion
							FROM btyasistencia_procesada a
							JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo
							JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo
							JOIN btytercero t ON t.trcdocumento=c.trcdocumento
							JOIN btysalon s ON s.slncodigo=a.slncodigo
							JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo
							JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo
							JOIN btyturno j ON j.trncodigo=a.trncodigo
							WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.abmcodigo IS NULL AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.clbcodigo = '".$rows['clbcodigo']."' AND a.aptcodigo IN(4,6) ORDER BY t.trcrazonsocial) 

							UNION (
							SELECT a.clbcodigo, c.trcrazonsocial, crg.crgnombre, e.ctcnombre, 
							(SELECT CONCAT('$', FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion 
							FROM btyasistencia_procesada a WHERE a.clbcodigo = '".$rows['clbcodigo']."' AND a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND
							a.slncodigo = '".$_SESSION['PDVslncodigo']."' )as apcvalorizacion
							FROM btyasistencia_procesada a
							JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo
							JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento
							JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo
							JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo
							JOIN btyasistencia_procesada_tipo f ON f.aptcodigo=a.aptcodigo
							WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.aptcodigo = 5 AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$rows['clbcodigo']."' ) 

							UNION (
							SELECT a.clbcodigo, c.trcrazonsocial, crg.crgnombre, e.ctcnombre,  
							(SELECT CONCAT('$', FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion 
							FROM btyasistencia_procesada a WHERE a.clbcodigo = '".$rows['clbcodigo']."' AND a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND
							a.slncodigo = '".$_SESSION['PDVslncodigo']."' )as apcvalorizacion
							FROM btyasistencia_biometrico a
							JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo
							JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento
							JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo
							JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo
							WHERE a.abmfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.abmerroneo = 1 AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$rows['clbcodigo']."' )
							ORDER BY trcrazonsocial";

							//echo $d;
						$Query = mysqli_query($conn, $d);


				  		while($row2 = mysqli_fetch_array($Query))
				  		{

					            $array[] = array(
					             	'nombre' 		=> $row2['trcrazonsocial'], 
					            	'clbcodigo' 	=> $row2['clbcodigo'],
					            	'cargo' 		=> $row2['crgnombre'],
					             	'categoria' 	=> $row2['ctcnombre'],
					             	'apcvalorizacion' => $row2['apcvalorizacion'], 
					             	'desde'           => $_POST['desde'],
					                  'hasta'           => $_POST['hasta']);
					      }
			 		}
			 	}					

					  	
			            $array = utf8_converter($array);
			
				      echo json_encode(array("res" => "full", "json" => $array));

				 
			}

			break;


		case 'detallesBio':
			$array = array();

$f = "(
SELECT 
a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, 
s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, 
bio.abmnuevotipo,bio.abmhora, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, 
a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion,
TIMEDIFF(bio.abmhora, j.trndesde)AS dif
FROM btyasistencia_procesada a
JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo
JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo
JOIN btytercero t ON t.trcdocumento=c.trcdocumento
JOIN btysalon s ON s.slncodigo=a.slncodigo
JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo
JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo
JOIN btyturno j ON j.trncodigo=a.trncodigo
JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo
WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo = 2 AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$_POST['clbcodigo']."'
ORDER BY t.trcrazonsocial 

) 

UNION

(
SELECT 
a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, 
s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, 
bio.abmnuevotipo,bio.abmhora, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, 
a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion,
TIMEDIFF(j.trnhasta, bio.abmhora)AS dif
FROM btyasistencia_procesada a
JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo
JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo
JOIN btytercero t ON t.trcdocumento=c.trcdocumento
JOIN btysalon s ON s.slncodigo=a.slncodigo
JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo
JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo
JOIN btyturno j ON j.trncodigo=a.trncodigo
JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo
WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo = 3 AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$_POST['clbcodigo']."'
ORDER BY t.trcrazonsocial 

)

UNION
(
SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, 
CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS aptnombre, '','', j.trncodigo, 
a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, 
CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion, NULL
FROM btyasistencia_procesada a
JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo
JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo
JOIN btytercero t ON t.trcdocumento=c.trcdocumento
JOIN btysalon s ON s.slncodigo=a.slncodigo
JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo
JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo
JOIN btyturno j ON j.trncodigo=a.trncodigo
WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.abmcodigo IS NULL AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' 
AND a.aptcodigo IN(4,6) AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$_POST['clbcodigo']."'
ORDER BY t.trcrazonsocial
) UNION
(
SELECT a.abmcodigo, a.clbcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre,f.aptnombre,a.prgfecha, 
 NULL, NULL,NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, TIMEDIFF(bio.abmhora, j.trndesde)AS dif
FROM btyasistencia_procesada a
JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo
JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento
JOIN btycargo d ON d.crgcodigo=b.crgcodigo
JOIN btyturno j ON j.trncodigo=a.trncodigo
JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo
JOIN btyasistencia_procesada_tipo f ON f.aptcodigo=a.aptcodigo
JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo
WHERE a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.aptcodigo = 5 AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$_POST['clbcodigo']."'

) UNION
(
SELECT a.abmcodigo, a.clbcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre, a.abmtipoerror, 
TIMEDIFF(a.abmhora, j.trndesde)AS dif, NULL, a.abmnuevotipo, a.abmhora, NULL, a.abmtipo AS marco_como, a.abmfecha, 
NULL, NULL, NULL, NULL, NULL, NULL
FROM btyasistencia_biometrico a
JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo
JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento
JOIN btycargo d ON d.crgcodigo=b.crgcodigo
JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo
JOIN btyasistencia_procesada asi ON asi.abmcodigo=a.abmcodigo
JOIN btyturno j ON j.trncodigo= asi.trncodigo
WHERE a.abmfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.abmerroneo = 1 AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.clbcodigo = '".$_POST['clbcodigo']."')
ORDER BY trcrazonsocial";

$de = mysqli_query($conn, "SELECT CONCAT('$', FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion FROM btyasistencia_procesada a WHERE a.clbcodigo = '".$_POST['clbcodigo']."' AND a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."'");

$sfila = mysqli_fetch_array($de);





							//echo $f;
			
							$sql = mysqli_query($conn, $f);

										

							while ($row = mysqli_fetch_array($sql)) 
							{
								$array[] = array(
								     'prgfecha' 		=> $row['prgfecha'],
								     'hora' 		=> $row['abmhora'],
								     'clbcodigo' 		=> $row['clbcodigo'],
								     'trcrazonsocial' 	=> $row['trcrazonsocial'],
								     'crgnombre' 		=> $row['crgnombre'],
								     'turno' 		=> $row['desde'],
								     'ctcnombre' 		=> $row['ctcnombre'],
								     'aptnombre' 		=> $row['aptnombre'],
								     'apcvalorizacion'  => $row['apcvalorizacion'],
								     'tipo'             => $row['abmnuevotipo'],
								     'dif'              => $row['dif'],
								     'total'            => $sfila[0]
								);

			
							}
								$array = utf8_converter($array);

				      			echo json_encode(array("res" => "full", "json" => $array));
		break;


		
		default:
			# code...
			break;
	}		

?>