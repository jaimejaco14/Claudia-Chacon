
<?php 
	session_start();
	include '../../cnx_data.php';

	function utf8_converter($array)
	{
    		array_walk_recursive($array, function(&$item, $key)
    		{
        		if(!mb_detect_encoding($item, 'utf-8', true))
        		{
            		$item = utf8_encode($item);
        		}
    		});

    	return $array;
	}

	switch ($_POST['opcion']) 
	{
		
		case 'col':
			

		    if ($_POST['fecha'] != '') 
			{

				$sqlcon = "SELECT a.citcodigo, a.clbcodigo, b.serduracion, c.esccodigo FROM btycita a JOIN btyservicio b ON a.sercodigo=b.sercodigo JOIN btynovedad_cita c ON a.citcodigo=c.citcodigo WHERE a.citfecha = '".$_POST['fecha']."' AND a.cithora = ADDTIME('".$_POST['hora']."','-00:30') AND a.clbcodigo = '".$_POST['codigo']."' AND c.esccodigo = 1 AND c.citcodigo=a.citcodigo";
		
			}
			else
			{
				$sqlcon = "SELECT a.citcodigo, a.clbcodigo, b.serduracion, c.esccodigo FROM btycita a JOIN btyservicio b ON a.sercodigo=b.sercodigo JOIN btynovedad_cita c ON a.citcodigo=c.citcodigo WHERE a.citfecha = CURDATE() AND a.cithora = ADDTIME('".$_POST['hora']."','-00:30') AND a.clbcodigo = '".$_POST['codigo']."' AND c.esccodigo = 1 AND c.citcodigo=a.citcodigo";
			}


			//echo $sqlcon;


			$val = mysqli_query($conn, $sqlcon);

			if (mysqli_num_rows($val) > 0) 
			{
				$dc = mysqli_fetch_array($val);

				if ($dc[2] > 30) 
				{
					echo json_encode(array("res" => "exists"));
				}
				else
				{
						$b = "SELECT b.clbcodigo, a.trcrazonsocial, b.crgcodigo, crg.crgnombre FROM btytercero a JOIN btycolaborador b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo WHERE b.clbcodigo = '".$_POST['codigo']."' ";
			        

					      $sql1 = mysqli_query($conn, $b);

					      $row1 = mysqli_fetch_array($sql1);

					      $f = "SELECT a.sercodigo, a.sernombre, a.serduracion FROM btyservicio a JOIN btyservicio_colaborador b ON a.sercodigo=b.sercodigo WHERE b.clbcodigo = '".$_POST['codigo']."'";

					      $salon = mysqli_query($conn, "SELECT slnnombre, slncodigo FROM btysalon WHERE slncodigo = '".$_SESSION['PDVslncodigo']."' ");

					      $fr = mysqli_fetch_array($salon);

					      $Query = mysqli_query($conn, $f);
					        
					      $array = array();

					      if (mysqli_num_rows($Query) > 0) 
				      	{
				        	
						      while ($row = mysqli_fetch_array($Query)) 
						      {
						        	$array[] = array(
						        		'idservicio' => $row['sercodigo'], "servicio" => $row['sernombre'], "dur" => $row['serduracion']);
						      }

					        	$array = utf8_converter($array);	

					        	echo json_encode(array("res" => "full", "json" => $array, "nombre" => utf8_encode($row1['trcrazonsocial']), "salon" => $fr['slnnombre'], "slncodigo" => $fr['slncodigo'] ));
				      	}
				      	else
				      	{
				        		echo json_encode(array("res" => "empty"));
				      	}
				}								

			}
			else
			{
				$b = "SELECT b.clbcodigo, a.trcrazonsocial, b.crgcodigo, crg.crgnombre FROM btytercero a JOIN btycolaborador b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo WHERE b.clbcodigo = '".$_POST['codigo']."' ";
			        

			      $sql1 = mysqli_query($conn, $b);

			      $row1 = mysqli_fetch_array($sql1);

			      $f = "SELECT a.sercodigo, a.sernombre, a.serduracion FROM btyservicio a JOIN btyservicio_colaborador b ON a.sercodigo=b.sercodigo WHERE b.clbcodigo = '".$_POST['codigo']."'";

			      $salon = mysqli_query($conn, "SELECT slnnombre, slncodigo FROM btysalon WHERE slncodigo = '".$_SESSION['PDVslncodigo']."' ");

			      $fr = mysqli_fetch_array($salon);

			      $Query = mysqli_query($conn, $f);
			        
			      $array = array();

			      if (mysqli_num_rows($Query) > 0) 
		      	{
		        	
				      while ($row = mysqli_fetch_array($Query)) 
				      {
				        	$array[] = array(
				        		'idservicio' => $row['sercodigo'], "servicio" => $row['sernombre'], "dur" => $row['serduracion']);
				      }

			        	$array = utf8_converter($array);	

			        	echo json_encode(array("res" => "full", "json" => $array, "nombre" => utf8_encode($row1['trcrazonsocial']), "salon" => $fr['slnnombre'], "slncodigo" => $fr['slncodigo'] ));
		      	}
		      	else
		      	{
		        		echo json_encode(array("res" => "empty"));
		      	}
			}

		      
		break;

		case 'insert':


			$varT = mysqli_query($conn, "SELECT a.serduracion FROM btyservicio a WHERE a.sercodigo = '".$_POST['servicio']."' ");

			$d = mysqli_fetch_array($varT);

			if ($_POST['fecha'] != "") 
			{
				$s = "SELECT cita.citcodigo, TIME_FORMAT(cita.cithora, '%H:%i')AS cithora , b.serduracion FROM btycita cita JOIN btyservicio b ON b.sercodigo=cita.sercodigo JOIN btynovedad_cita c ON c.citcodigo=cita.citcodigo WHERE cita.citfecha = '".$_POST['fecha']."' AND cita.clbcodigo = '".$_POST['clbcodigo']."' and cita.cithora BETWEEN '".$_POST['hora']."' and SUBTIME(TIME_FORMAT(ADDTIME(TIME_FORMAT('".$_POST['hora']."', '%H:%i'), SEC_TO_TIME('".$d[0]."' *60)), '%H:%i'),1) and not c.esccodigo in (3,1)";
			}
			else
			{
				$s = "SELECT cita.citcodigo, TIME_FORMAT(cita.cithora, '%H:%i')AS cithora , b.serduracion FROM btycita cita JOIN btyservicio b ON b.sercodigo=cita.sercodigo JOIN btynovedad_cita c ON c.citcodigo=cita.citcodigo WHERE cita.citfecha = CURDATE() AND cita.clbcodigo = '".$_POST['clbcodigo']."' and cita.cithora BETWEEN '".$_POST['hora']."' and SUBTIME(TIME_FORMAT(ADDTIME(TIME_FORMAT('".$_POST['hora']."', '%H:%i'), SEC_TO_TIME('".$d[0]."' *60)), '%H:%i'),1) and not c.esccodigo in (3,1)";
			}

			

			//echo $s;


			$array = array();

			$varC = mysqli_query($conn, $s);

			if (mysqli_num_rows($varC) > 0) 
			{
				$row = mysqli_fetch_array($varC);

				$array[] = array('hora' => $row['cithora'], 'duracion' => $d[0]);
				echo json_encode(array("res" => "full", "json" => $array));
			}
			else
			{
				$sqlMax = mysqli_query($conn, "SELECT MAX(citcodigo) FROM btycita");

				$maxCita = mysqli_fetch_array($sqlMax);


				if ($_POST['cliente2'] != "") 
				{
					$queryDoc = mysqli_query($conn, "SELECT a.clicodigo FROM btycliente a WHERE a.trcdocumento = '".$_POST['cliente2']."'");

					$rw = mysqli_fetch_array($queryDoc);

					$cliente = $rw[0];				
				}
				else
				{
					$cliente = $_POST['cliente'];
				}


				$max = $maxCita[0] +1;

				if ($_POST['fecha'] != "") 
				{
					$e = "INSERT INTO btycita (citcodigo, meccodigo, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, citfecha, cithora, citfecharegistro, cithoraregistro, citobservaciones) VALUES($max, '".$_POST['medio']."', '".$_POST['clbcodigo']."', '".$_SESSION['PDVslncodigo']."', '".$_POST['servicio']."', '".$cliente."', '".$_SESSION['PDVcodigoUsuario']."' , '".$_POST['fecha']."' , '".$_POST['hora']."', '".$_POST['fecha']."' , CURTIME(), '".$_POST['observaciones']."' )";
				}
				else
				{
					$e = "INSERT INTO btycita (citcodigo, meccodigo, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, citfecha, cithora, citfecharegistro, cithoraregistro, citobservaciones) VALUES($max, '".$_POST['medio']."', '".$_POST['clbcodigo']."', '".$_SESSION['PDVslncodigo']."', '".$_POST['servicio']."', '".$cliente."', '".$_SESSION['PDVcodigoUsuario']."' , CURDATE() , '".$_POST['hora']."', CURDATE() , CURTIME(), '".$_POST['observaciones']."' )";
					
				}


			
			
				mysqli_query($conn, $e)or die(mysqli_error($conn));

				$h = "INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones)VALUES(1, $max, CURDATE(), CURTIME(), '".$_SESSION['PDVcodigoUsuario']."', '')";
				mysqli_query($conn, $h)or die(mysqli_error($conn));
			
				echo json_encode(array("res" => "insert"));
			}

			/************************************/
												
		break;

		case 'verAgenda':
			
			$sql = mysqli_query($conn, "SELECT a.cithora, b.sernombre, d.trcrazonsocial, c.cliemail, d.trctelefonomovil, CONCAT(b.serduracion, ' ', 'MIN') AS serduracion, f.trcnombres AS usuarioAgendo,c.clicodigo as clicod,a.sercodigo as sercod FROM btycita a JOIN btyservicio b ON a.sercodigo=b.sercodigo JOIN btycliente c ON c.clicodigo=a.clicodigo JOIN btytercero d ON d.tdicodigo=c.tdicodigo AND d.trcdocumento=c.trcdocumento JOIN btyusuario e ON e.usucodigo=a.usucodigo JOIN btytercero f ON f.tdicodigo=e.tdicodigo AND f.trcdocumento=e.trcdocumento WHERE a.citcodigo =  '".$_POST['citcodigo']."'");

			/****************************************/

			$queryEstado = mysqli_query($conn, "SELECT MAX(a.esccodigo) AS codEstado, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$_POST['citcodigo']."' GROUP BY a.esccodigo ORDER BY a.esccodigo DESC LIMIT 1");

			$fetchEstado = mysqli_fetch_array($queryEstado);



			$row = mysqli_fetch_array($sql);

			$array = array();

			$array[] = array('hora' => $row['cithora'], 'servicio' => $row['sernombre'], 'cliente' => $row['trcrazonsocial'], 'email' => $row['cliemail'], 'movil' => $row['trctelefonomovil'], 'duracion' => $row['serduracion'], 'usuagenda' => $row['usuarioAgendo'], 'clicod'=>$row['clicod'], 'sercod'=>$row['sercod'] );

			$array = utf8_converter($array);

			echo json_encode(array("res" => "full", "json" => $array, "estadoCita" => $fetchEstado[0]));
		break;


		case 'cargarFecha':
			
			echo '<table class="table table-hover table-bordered" id="tblListado">
						<thead><tr>';


									if ($_POST['fecha'] != "") 
									{
									     $s = "SELECT COUNT(b.crgcodigo)as count, d.crgnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo JOIN btycargo d ON d.crgcodigo=b.crgcodigo WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.prgfecha = '".$_POST['fecha']."' AND a.tprcodigo IN (1,9) AND d.crgincluircolaturnos = 1 GROUP BY b.crgcodigo, d.crgnombre ORDER BY d.crgnombre ";	
									}
									else
									{
										$s = "SELECT COUNT(b.crgcodigo)as count, d.crgnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo JOIN btycargo d ON d.crgcodigo=b.crgcodigo WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.prgfecha = CURDATE() AND a.tprcodigo IN (1,9) AND d.crgincluircolaturnos = 1 GROUP BY b.crgcodigo, d.crgnombre ORDER BY d.crgnombre ";
									}


									$sql = mysqli_query($conn, $s);
										echo '<th colspan="1" class="active"> </th>';
										while ($rows = mysqli_fetch_array($sql)) 
										{
											echo '<th colspan="'.$rows[0].'" class="active"><center> '.$rows[1]."S ( ". $rows[0] . " ) ". '</center></th>';
										}

									
							


							echo '</tr><tr>
								<th>HORA</th>';

									if ($_POST['fecha'] != "") 
									{
										
										$sql = mysqli_query($conn, "SELECT c.trcnombres, a.clbcodigo, d.crgnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo JOIN btycargo d ON d.crgcodigo=b.crgcodigo WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.prgfecha = '".$_POST['fecha']."' AND a.tprcodigo IN (1,9) AND d.crgincluircolaturnos = 1 GROUP BY d.crgnombre, a.clbcodigo ORDER BY d.crgnombre");
									}
									else
									{
										$sql = mysqli_query($conn, "SELECT c.trcnombres, a.clbcodigo, d.crgnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo JOIN btycargo d ON d.crgcodigo=b.crgcodigo WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.prgfecha = CURDATE() AND a.tprcodigo IN (1,9) AND d.crgincluircolaturnos = 1 GROUP BY d.crgnombre, a.clbcodigo ORDER BY d.crgnombre");
									}
								 

									$filas = mysqli_num_rows($sql);

									while ($row = mysqli_fetch_array($sql)) 
									{
										$nombre = explode(" ", $row['trcnombres']);
										
										switch ($row[2]) 
										{
											case 'ESTETICISTA':
												echo '<th class="info">'.$nombre[0].'</th>';										
	
												break;

											case 'ESTILISTA':
												echo '<th class="danger">'.$nombre[0].'</th>';										
	
												break;

											case 'MANICURISTA':
												echo '<th class="success">'.$nombre[0].'</th>';										
	
												break;
											
											default:
												# code...
												break;
										}
										$codcol.=$row['clbcodigo'].',';
									}
								
							echo '</tr>	
						</thead>
					<tbody>';



			

			$SQL=mysqli_query($conn, "SET lc_time_names = 'es_CO'");

			if ($_POST['fecha'] != "") 
			{

				$SQL = mysqli_query($conn, "SELECT TIME_FORMAT(h.hordesde, '%H:%i') AS desde, TIME_FORMAT(h.horhasta, '%H:%i')AS horhasta, h.hordia FROM btyhorario h JOIN btyhorario_salon hs ON h.horcodigo=hs.horcodigo WHERE hs.slncodigo = '".$_SESSION['PDVslncodigo']."' AND h.hordia = DAYNAME('".$_POST['fecha']."')");
			}
			else
			{
				$SQL = mysqli_query($conn, "SELECT TIME_FORMAT(h.hordesde, '%H:%i') AS desde, TIME_FORMAT(h.horhasta, '%H:%i')AS horhasta, h.hordia FROM btyhorario h JOIN btyhorario_salon hs ON h.horcodigo=hs.horcodigo WHERE hs.slncodigo = '".$_SESSION['PDVslncodigo']."' AND h.hordia = DAYNAME(CURDATE())");
			}


				$fil = mysqli_fetch_array($SQL);

		
				$r=0;



				$veccodcol=explode(',',$codcol);
				$tam=count($veccodcol);
				while ($cenvertedTime < $fil['horhasta']) 
				{
					$i=0;
					$cenvertedTime = date('H:i',strtotime('+' . $r .' minutes',strtotime($fil['desde'])));
					$r = $r+30;
			
					echo '<tr><td data-hora="'.$cenvertedTime.'">'.$cenvertedTime.'</td>';

				
						

						for($i=0;$i<$tam;$i++) 
						{

							if ($_POST['fecha'] != "") 
							{
							 	

								$d = "SELECT a.citcodigo, a.clbcodigo, c.trcrazonsocial as clbnombre, a.slncodigo, d.slnnombre, d.slndireccion, a.sercodigo, e.sernombre, e.serduracion, a.clicodigo, g.trcrazonsocial as clinombre, a.usucodigo, i.trcrazonsocial as usunombre, a.citfecha, TIME_FORMAT(a.cithora, '%H:%i')AS cithora, a.citobservaciones, a.citfecharegistro, a.cithoraregistro, (SELECT TIME_FORMAT(trn.trninicioalmuerzo,'%H:%i')AS trninicioalmuerzo FROM btyprogramacion_colaboradores prg JOIN btyturno trn ON trn.trncodigo=prg.trncodigo WHERE prg.clbcodigo = '".$veccodcol[$i]."' AND prg.prgfecha = CURDATE())AS trninicioalmuerzo FROM btycita a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btysalon d ON d.slncodigo=a.slncodigo JOIN btyservicio e ON e.sercodigo=a.sercodigo JOIN btycliente f ON f.clicodigo=a.clicodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btyusuario h ON h.usucodigo=a.usucodigo JOIN btytercero i ON i.tdicodigo=h.tdicodigo AND i.trcdocumento=h.trcdocumento WHERE a.clbcodigo = '".$veccodcol[$i]."' AND a.citfecha = '".$_POST['fecha']."' AND a.cithora = '".$cenvertedTime."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' ";
							} 
							else
							{
								$d = "SELECT a.citcodigo, a.clbcodigo, c.trcrazonsocial as clbnombre, a.slncodigo, d.slnnombre, d.slndireccion, a.sercodigo, e.sernombre, e.serduracion, a.clicodigo, g.trcrazonsocial as clinombre, a.usucodigo, i.trcrazonsocial as usunombre, a.citfecha, TIME_FORMAT(a.cithora, '%H:%i')AS cithora, a.citobservaciones, a.citfecharegistro, a.cithoraregistro, (SELECT TIME_FORMAT(trn.trninicioalmuerzo,'%H:%i')AS trninicioalmuerzo FROM btyprogramacion_colaboradores prg JOIN btyturno trn ON trn.trncodigo=prg.trncodigo WHERE prg.clbcodigo = '".$veccodcol[$i]."' AND prg.prgfecha = CURDATE())AS trninicioalmuerzo FROM btycita a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btysalon d ON d.slncodigo=a.slncodigo JOIN btyservicio e ON e.sercodigo=a.sercodigo JOIN btycliente f ON f.clicodigo=a.clicodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btyusuario h ON h.usucodigo=a.usucodigo JOIN btytercero i ON i.tdicodigo=h.tdicodigo AND i.trcdocumento=h.trcdocumento WHERE a.clbcodigo = '".$veccodcol[$i]."' AND a.citfecha = CURDATE() AND a.cithora = '".$cenvertedTime."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' ";
							}
							
								$sqlS = mysqli_query($conn, $d)or die(mysqli_error($conn));

																						

								$fetch = mysqli_fetch_array($sqlS);




								if ($fetch['serduracion'] > '30') 
								{
									
									if ($_POST['fecha'] != "") 
									{
										$S = "SELECT TIME_FORMAT(trn.trninicioalmuerzo,'%H:%i')AS trninicioalmuerzo, TIME_FORMAT(trn.trnfinalmuerzo,'%H:%i')AS trnfinalmuerzo, trn.trnnombre FROM btyprogramacion_colaboradores prg JOIN btyturno trn ON trn.trncodigo=prg.trncodigo WHERE prg.clbcodigo = '".$veccodcol[$i]."' AND prg.prgfecha ='".$_POST['fecha']."'";
									} 
									else
									{
										$S = "SELECT TIME_FORMAT(trn.trninicioalmuerzo,'%H:%i')AS trninicioalmuerzo, TIME_FORMAT(trn.trnfinalmuerzo,'%H:%i')AS trnfinalmuerzo, trn.trnnombre FROM btyprogramacion_colaboradores prg JOIN btyturno trn ON trn.trncodigo=prg.trncodigo WHERE prg.clbcodigo = '".$veccodcol[$i]."' AND prg.prgfecha =CURDATE()";
									}
									

											$filas= mysqli_query($conn, $S);

											$d = mysqli_fetch_array($filas);

											if ($d[0] == $cenvertedTime) 
											{
												$queryEstado = mysqli_query($conn, "SELECT MAX(a.esccodigo) AS codEstado, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$fetch['citcodigo']."' GROUP BY a.esccodigo ORDER BY a.esccodigo DESC LIMIT 1");

														$fetchEstado = mysqli_fetch_array($queryEstado);

														switch ($fetchEstado[0]) 
														{
															case '1':
																echo '<td data-hora="'.$cenvertedTime.'" data-print="99"  data-codcita="'.$fetch['citcodigo'].'" data-col="'.$veccodcol[$i].'" class="verCita" style="cursor:pointer;background-color: #f300ff; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-clock-o" aria-hidden="true"></i> EXT</td>';
																break;

															case '2':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: lime" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"></td>';
																break;

															/*case '3':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #ef0b0b;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-times"></i></td>';
																break;*/

															case '7':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #2ad1c1;color:black; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-calendar"></i></td>';

																break;
															case '8':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #4cd13a;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-check"></i></td>';
																break;

															case '9':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: purple; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-thumbs-down"></i></td>';
																break;
															
															default:
																	echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer; background-color: #f5d938; border-color="#f5d938" data-toggle="tooltip" data-placement="top" data-container="body" title=" ALMUERZO DE '.$d['trninicioalmuerzo'].' A '.$d['trnfinalmuerzo'].' - TURNO DE '.$d['trnnombre'].' "><center><i class="fa fa-cutlery" aria-hidden="true" style="color: #444"></i></center></td>';
																break;
														}
											}
											else
											{
												if ($fetch['cithora'] == $cenvertedTime) 
												{


														$queryEstado = mysqli_query($conn, "SELECT MAX(a.esccodigo) AS codEstado, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$fetch['citcodigo']."' GROUP BY a.esccodigo ORDER BY a.esccodigo DESC LIMIT 1");

														$fetchEstado = mysqli_fetch_array($queryEstado);

														switch ($fetchEstado[0]) 
														{
															case '1':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" data-col="'.$veccodcol[$i].'" class="verCita" style="cursor:pointer;background-color: #f300ff; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-clock-o" aria-hidden="true"></i> EXT</td>';
																break;

															case '2':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: lime" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"></td>';
																break;

															/*case '3':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #ef0b0b;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-times"></i></td>';
																break;*/

															case '7':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #2ad1c1;color:black; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-calendar"></i></td>';

																break;
															case '8':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #4cd13a;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-check"></i></td>';
																break;

															case '9':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: purple; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-thumbs-down"></i></td>';
																break;
															
															default:
																echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer;"></td>';
																break;
														}

													}	
													else
													{
														echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer;">SE PASA</td>';
													}
											}
								}
								else
								{

									if ($_POST['fecha'] != "") 
									{
										$S = "SELECT TIME_FORMAT(trn.trninicioalmuerzo,'%H:%i')AS trninicioalmuerzo, TIME_FORMAT(trn.trnfinalmuerzo,'%H:%i')AS trnfinalmuerzo, trn.trnnombre FROM btyprogramacion_colaboradores prg JOIN btyturno trn ON trn.trncodigo=prg.trncodigo WHERE prg.clbcodigo = '".$veccodcol[$i]."' AND prg.prgfecha = '".$_POST['fecha']."'";
									}
									else
									{
										$S = "SELECT TIME_FORMAT(trn.trninicioalmuerzo,'%H:%i')AS trninicioalmuerzo, TIME_FORMAT(trn.trnfinalmuerzo,'%H:%i')AS trnfinalmuerzo, trn.trnnombre FROM btyprogramacion_colaboradores prg JOIN btyturno trn ON trn.trncodigo=prg.trncodigo WHERE prg.clbcodigo = '".$veccodcol[$i]."' AND prg.prgfecha = CURDATE()";
									}

											

											$filas= mysqli_query($conn, $S);

											$d = mysqli_fetch_array($filas);

											if ($d[0] == $cenvertedTime) 
											{
												$queryEstado = mysqli_query($conn, "SELECT MAX(a.esccodigo) AS codEstado, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$fetch['citcodigo']."' GROUP BY a.esccodigo ORDER BY a.esccodigo DESC LIMIT 1");

														$fetchEstado = mysqli_fetch_array($queryEstado);

														switch ($fetchEstado[0]) 
														{
															case '1':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" data-col="'.$veccodcol[$i].'" class="verCita" style="cursor:pointer;background-color: #1981f2; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-clock-o" aria-hidden="true"></i></td>';
																break;

															case '2':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: lime" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"></td>';
																break;

															/*case '3':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #ef0b0b;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-times"></i></td>';
																break;*/

															case '7':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #2ad1c1;color:black; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-calendar"></i></td>';

																break;
															case '8':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #4cd13a;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-check"></i></td>';
																break;

															case '9':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: purple; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-thumbs-down"></i></td>';
																break;
															
															default:
																	echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer; background-color: #f5d938; border-color="#f5d938" data-toggle="tooltip" data-placement="top" data-container="body" title=" ALMUERZO DE '.$d['trninicioalmuerzo'].' A '.$d['trnfinalmuerzo'].' - TURNO DE '.$d['trnnombre'].' "><center><i class="fa fa-cutlery" aria-hidden="true" style="color: #444"></i></center></td>';
																break;
														}
											}
											else
											{
													if ($fetch['cithora'] == $cenvertedTime) 
													{


														$queryEstado = mysqli_query($conn, "SELECT MAX(a.esccodigo) AS codEstado, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$fetch['citcodigo']."' GROUP BY a.esccodigo ORDER BY a.esccodigo DESC LIMIT 1");

														$fetchEstado = mysqli_fetch_array($queryEstado);

														switch ($fetchEstado[0]) 
														{
															case '1':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" data-col="'.$veccodcol[$i].'" class="verCita" style="cursor:pointer;background-color: #1981f2; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-clock-o" aria-hidden="true"></i></td>';
																break;

															case '2':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: lime" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"></td>';
																break;

															/*case '3':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #ef0b0b;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-times"></i></td>';
																break;*/

															case '7':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #2ad1c1;color:black; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-calendar"></i></td>';

																break;
															case '8':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #4cd13a;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-check"></i></td>';
																break;

															case '9':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: purple; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-thumbs-down"></i></td>';
																break;
															
															default:
																echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer;"></td>';
																break;
														}

													}	
													else
													{
														echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer;"></td>';
													}
											}
								}//end else
						}//end for
				}

							
					echo '</tr>							
							</tbody>

							<tfoot>
							<tr>
								<th></th>';


								if ($_POST['fecha'] != "") 
								{

									$hj = "SELECT c.trcnombres, a.clbcodigo, d.crgnombre, CONCAT(e.trnnombre, ' DE ', TIME_FORMAT(e.trndesde, '%H:%i'), ' A ', TIME_FORMAT(e.trnhasta,'%H:%i')) AS trnnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btyturno e ON e.trncodigo=a.trncodigo WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.prgfecha = '".$_POST['fecha']."' AND a.tprcodigo IN (1,9) AND d.crgincluircolaturnos = 1 GROUP BY d.crgnombre, a.clbcodigo, e.trnnombre, e.trndesde, e.trnhasta ORDER BY d.crgnombre";
								}
								else
								{
									$hj = "SELECT c.trcnombres, a.clbcodigo, d.crgnombre, CONCAT(e.trnnombre, ' DE ', TIME_FORMAT(e.trndesde, '%H:%i'), ' A ', TIME_FORMAT(e.trnhasta,'%H:%i')) AS trnnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btyturno e ON e.trncodigo=a.trncodigo WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.prgfecha = CURDATE() AND a.tprcodigo IN (1,9) AND d.crgincluircolaturnos = 1 GROUP BY d.crgnombre, a.clbcodigo, e.trnnombre, e.trndesde, e.trnhasta ORDER BY d.crgnombre";
								}

								
									$sql = mysqli_query($conn, $hj);

									$filas = mysqli_num_rows($sql);

									while ($row = mysqli_fetch_array($sql)) 
									{
										$nombre = explode(" ", $row['trcnombres']);
										
										switch ($row[2]) 
										{
											case 'ESTETICISTA':
												echo '
												
												<th class="info" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$row['trnnombre'].'">'.$nombre[0].' </th>';										
	
												break;

											case 'ESTILISTA':
												echo '<th class="danger" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$row['trnnombre'].'">'.$nombre[0].'</th>';										
	
												break;

											case 'MANICURISTA':
												echo '<th class="success" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$row['trnnombre'].'">'.$nombre[0].'</th>';										
	
												break;
											
											default:
												# code...
												break;
										}

										//$codcol.=$row['clbcodigo'].',';
									}
							
							echo '</tr>
						</tfoot>
								</table>';
		break;


		case 'cargarLista':


			echo '<table class="table table-hover table-bordered" id="tblListado">
						<thead><tr>';


									if ($_POST['fecha'] != "") 
									{
									     $s = "SELECT COUNT(b.crgcodigo)as count, d.crgnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo JOIN btycargo d ON d.crgcodigo=b.crgcodigo WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.prgfecha = '".$_POST['fecha']."' AND a.tprcodigo IN (1,9) AND d.crgincluircolaturnos = 1 GROUP BY b.crgcodigo, d.crgnombre ORDER BY d.crgnombre ";	
									}
									else
									{
										$s = "SELECT COUNT(b.crgcodigo)as count, d.crgnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo JOIN btycargo d ON d.crgcodigo=b.crgcodigo WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.prgfecha = CURDATE() AND a.tprcodigo IN (1,9) AND d.crgincluircolaturnos = 1 GROUP BY b.crgcodigo, d.crgnombre ORDER BY d.crgnombre ";
									}


									$sql = mysqli_query($conn, $s);
										echo '<th colspan="1" class="active"> </th>';
										while ($rows = mysqli_fetch_array($sql)) 
										{
											echo '<th colspan="'.$rows[0].'" class="active"><center> '.$rows[1]."S ( ". $rows[0] . " ) ". '</center></th>';
										}

									
							


							echo '</tr><tr>
								<th>HORA</th>';

									if ($_POST['fecha'] != "") 
									{
										
										$sql = mysqli_query($conn, "SELECT c.trcnombres, a.clbcodigo, d.crgnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo JOIN btycargo d ON d.crgcodigo=b.crgcodigo WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.prgfecha = '".$_POST['fecha']."' AND a.tprcodigo IN (1,9) AND d.crgincluircolaturnos = 1 GROUP BY d.crgnombre, a.clbcodigo ORDER BY d.crgnombre");
									}
									else
									{
										$sql = mysqli_query($conn, "SELECT c.trcnombres, a.clbcodigo, d.crgnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo JOIN btycargo d ON d.crgcodigo=b.crgcodigo WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.prgfecha = CURDATE() AND a.tprcodigo IN (1,9) AND d.crgincluircolaturnos = 1 GROUP BY d.crgnombre, a.clbcodigo ORDER BY d.crgnombre");
									}
								 

									$filas = mysqli_num_rows($sql);

									while ($row = mysqli_fetch_array($sql)) 
									{
										$nombre = explode(" ", $row['trcnombres']);
										
										switch ($row[2]) 
										{
											case 'ESTETICISTA':
												echo '<th class="info">'.$nombre[0].'</th>';										
	
												break;

											case 'ESTILISTA':
												echo '<th class="danger">'.$nombre[0].'</th>';										
	
												break;

											case 'MANICURISTA':
												echo '<th class="success">'.$nombre[0].'</th>';										
	
												break;
											
											default:
												# code...
												break;
										}
										$codcol.=$row['clbcodigo'].',';
									}
								
							echo '</tr>	
						</thead>
					<tbody>';



			

			$SQL=mysqli_query($conn, "SET lc_time_names = 'es_CO'");

			if ($_POST['fecha'] != "") 
			{

				$SQL = mysqli_query($conn, "SELECT TIME_FORMAT(h.hordesde, '%H:%i') AS desde, TIME_FORMAT(h.horhasta, '%H:%i')AS horhasta, h.hordia FROM btyhorario h JOIN btyhorario_salon hs ON h.horcodigo=hs.horcodigo WHERE hs.slncodigo = '".$_SESSION['PDVslncodigo']."' AND h.hordia = DAYNAME('".$_POST['fecha']."')");
			}
			else
			{
				$SQL = mysqli_query($conn, "SELECT TIME_FORMAT(h.hordesde, '%H:%i') AS desde, TIME_FORMAT(h.horhasta, '%H:%i')AS horhasta, h.hordia FROM btyhorario h JOIN btyhorario_salon hs ON h.horcodigo=hs.horcodigo WHERE hs.slncodigo = '".$_SESSION['PDVslncodigo']."' AND h.hordia = DAYNAME(CURDATE())");
			}


				$fil = mysqli_fetch_array($SQL);

		
				$r=0;



				$veccodcol=explode(',',$codcol);
				$tam=count($veccodcol);
				while ($cenvertedTime < $fil['horhasta']) 
				{
					$i=0;
					$cenvertedTime = date('H:i',strtotime('+' . $r .' minutes',strtotime($fil['desde'])));
					$r = $r+30;
			
					echo '<tr><td data-hora="'.$cenvertedTime.'">'.$cenvertedTime.'</td>';

				
						

						for($i=0;$i<$tam;$i++) 
						{

							if ($_POST['fecha'] != "") 
							{
							 	

								$d = "SELECT a.citcodigo, a.clbcodigo, c.trcrazonsocial as clbnombre, a.slncodigo, d.slnnombre, d.slndireccion, a.sercodigo, e.sernombre, e.serduracion, a.clicodigo, g.trcrazonsocial as clinombre, a.usucodigo, i.trcrazonsocial as usunombre, a.citfecha, TIME_FORMAT(a.cithora, '%H:%i')AS cithora, a.citobservaciones, a.citfecharegistro, a.cithoraregistro, (SELECT TIME_FORMAT(trn.trninicioalmuerzo,'%H:%i')AS trninicioalmuerzo FROM btyprogramacion_colaboradores prg JOIN btyturno trn ON trn.trncodigo=prg.trncodigo WHERE prg.clbcodigo = '".$veccodcol[$i]."' AND prg.prgfecha = '".$_POST['fecha']."')AS trninicioalmuerzo FROM btycita a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btysalon d ON d.slncodigo=a.slncodigo JOIN btyservicio e ON e.sercodigo=a.sercodigo JOIN btycliente f ON f.clicodigo=a.clicodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btyusuario h ON h.usucodigo=a.usucodigo JOIN btytercero i ON i.tdicodigo=h.tdicodigo AND i.trcdocumento=h.trcdocumento WHERE a.clbcodigo = '".$veccodcol[$i]."' AND a.citfecha = '".$_POST['fecha']."' AND a.cithora = '".$cenvertedTime."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' ";
							} 
							else
							{
								$d = "SELECT a.citcodigo, a.clbcodigo, c.trcrazonsocial as clbnombre, a.slncodigo, d.slnnombre, d.slndireccion, a.sercodigo, e.sernombre, e.serduracion, a.clicodigo, g.trcrazonsocial as clinombre, a.usucodigo, i.trcrazonsocial as usunombre, a.citfecha, TIME_FORMAT(a.cithora, '%H:%i')AS cithora, a.citobservaciones, a.citfecharegistro, a.cithoraregistro, (SELECT TIME_FORMAT(trn.trninicioalmuerzo,'%H:%i')AS trninicioalmuerzo FROM btyprogramacion_colaboradores prg JOIN btyturno trn ON trn.trncodigo=prg.trncodigo WHERE prg.clbcodigo = '".$veccodcol[$i]."' AND prg.prgfecha = CURDATE())AS trninicioalmuerzo FROM btycita a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btysalon d ON d.slncodigo=a.slncodigo JOIN btyservicio e ON e.sercodigo=a.sercodigo JOIN btycliente f ON f.clicodigo=a.clicodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btyusuario h ON h.usucodigo=a.usucodigo JOIN btytercero i ON i.tdicodigo=h.tdicodigo AND i.trcdocumento=h.trcdocumento WHERE a.clbcodigo = '".$veccodcol[$i]."' AND a.citfecha = CURDATE() AND a.cithora = '".$cenvertedTime."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' ";
							}
							
								$sqlS = mysqli_query($conn, $d)or die(mysqli_error($conn));

																						

								$fetch = mysqli_fetch_array($sqlS);




								if ($fetch['serduracion'] > '30') 
								{
									//$cenvertedTime = date('H:i',strtotime('+' . $r .' minutes',strtotime($fetch['cithora'])));
									//$r = $r+$fetch['serduracion'];
									$S = "SELECT TIME_FORMAT(trn.trninicioalmuerzo,'%H:%i')AS trninicioalmuerzo, TIME_FORMAT(trn.trnfinalmuerzo,'%H:%i')AS trnfinalmuerzo, trn.trnnombre FROM btyprogramacion_colaboradores prg JOIN btyturno trn ON trn.trncodigo=prg.trncodigo WHERE prg.clbcodigo = '".$veccodcol[$i]."' AND prg.prgfecha = '".$_POST['fecha']."'";

											$filas= mysqli_query($conn, $S);

											$d = mysqli_fetch_array($filas);

											if ($d[0] == $cenvertedTime) 
											{
												$queryEstado = mysqli_query($conn, "SELECT MAX(a.esccodigo) AS codEstado, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$fetch['citcodigo']."' GROUP BY a.esccodigo ORDER BY a.esccodigo DESC LIMIT 1");

														$fetchEstado = mysqli_fetch_array($queryEstado);

														switch ($fetchEstado[0]) 
														{
															case '1':
																echo '<td data-hora="'.$cenvertedTime.'" data-print="99"  data-codcita="'.$fetch['citcodigo'].'" data-col="'.$veccodcol[$i].'" class="verCita" style="cursor:pointer;background-color: #f300ff; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-clock-o" aria-hidden="true"></i> EXT</td>';
																break;

															case '2':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: lime" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"></td>';
																break;

															/*case '3':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #ef0b0b;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-times"></i></td>';
																break;*/

															case '7':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #2ad1c1;color:black; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-calendar"></i></td>';

																break;
															case '8':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #4cd13a;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-check"></i></td>';
																break;

															case '9':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: purple; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-thumbs-down"></i></td>';
																break;
															
															default:
																	echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer; background-color: #f5d938; border-color="#f5d938" data-toggle="tooltip" data-placement="top" data-container="body" title=" ALMUERZO DE '.$d['trninicioalmuerzo'].' A '.$d['trnfinalmuerzo'].' - TURNO DE '.$d['trnnombre'].' "><center><i class="fa fa-cutlery" aria-hidden="true" style="color: #444"></i></center></td>';
																break;
														}
											}
											else
											{
												if ($fetch['cithora'] == $cenvertedTime) 
												{


														$queryEstado = mysqli_query($conn, "SELECT MAX(a.esccodigo) AS codEstado, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$fetch['citcodigo']."' GROUP BY a.esccodigo ORDER BY a.esccodigo DESC LIMIT 1");

														$fetchEstado = mysqli_fetch_array($queryEstado);

														switch ($fetchEstado[0]) 
														{
															case '1':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" data-col="'.$veccodcol[$i].'" class="verCita" style="cursor:pointer;background-color: #f300ff; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-clock-o" aria-hidden="true"></i> EXT</td>';
																break;

															case '2':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: lime" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"></td>';
																break;

															/*case '3':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #ef0b0b;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-times"></i></td>';
																break;*/

															case '7':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #2ad1c1;color:black; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-calendar"></i></td>';

																break;
															case '8':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #4cd13a;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-check"></i></td>';
																break;

															case '9':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: purple; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-thumbs-down"></i></td>';
																break;
															
															default:
																echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer;"></td>';
																break;
														}

													}	
													else
													{
														echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer;">SE PASA</td>';
													}
											}
								}
								else
								{



											$S = "SELECT TIME_FORMAT(trn.trninicioalmuerzo,'%H:%i')AS trninicioalmuerzo, TIME_FORMAT(trn.trnfinalmuerzo,'%H:%i')AS trnfinalmuerzo, trn.trnnombre FROM btyprogramacion_colaboradores prg JOIN btyturno trn ON trn.trncodigo=prg.trncodigo WHERE prg.clbcodigo = '".$veccodcol[$i]."' AND prg.prgfecha = '".$_POST['fecha']."'";

											$filas= mysqli_query($conn, $S);

											$d = mysqli_fetch_array($filas);

											if ($d[0] == $cenvertedTime) 
											{
												$queryEstado = mysqli_query($conn, "SELECT MAX(a.esccodigo) AS codEstado, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$fetch['citcodigo']."' GROUP BY a.esccodigo ORDER BY a.esccodigo DESC LIMIT 1");

														$fetchEstado = mysqli_fetch_array($queryEstado);

														switch ($fetchEstado[0]) 
														{
															case '1':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" data-col="'.$veccodcol[$i].'" class="verCita" style="cursor:pointer;background-color: #1981f2; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-clock-o" aria-hidden="true"></i></td>';
																break;

															case '2':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: lime" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"></td>';
																break;

															/*case '3':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #ef0b0b;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-times"></i></td>';
																break;*/

															case '7':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #2ad1c1;color:black; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-calendar"></i></td>';

																break;
															case '8':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #4cd13a;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-check"></i></td>';
																break;

															case '9':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: purple; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-thumbs-down"></i></td>';
																break;
															
															default:
																	echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer; background-color: #f5d938; border-color="#f5d938" data-toggle="tooltip" data-placement="top" data-container="body" title=" ALMUERZO DE '.$d['trninicioalmuerzo'].' A '.$d['trnfinalmuerzo'].' - TURNO DE '.$d['trnnombre'].' "><center><i class="fa fa-cutlery" aria-hidden="true" style="color: #444"></i></center></td>';
																break;
														}
											}
											else
											{
													if ($fetch['cithora'] == $cenvertedTime) 
													{


														$queryEstado = mysqli_query($conn, "SELECT MAX(a.esccodigo) AS codEstado, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$fetch['citcodigo']."' GROUP BY a.esccodigo ORDER BY a.esccodigo DESC LIMIT 1");

														$fetchEstado = mysqli_fetch_array($queryEstado);

														switch ($fetchEstado[0]) 
														{
															case '1':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" data-col="'.$veccodcol[$i].'" class="verCita" style="cursor:pointer;background-color: #1981f2; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-clock-o" aria-hidden="true"></i></td>';
																break;

															case '2':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: lime" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"></td>';
																break;

															/*case '3':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #ef0b0b;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-times"></i></td>';
																break;*/

															case '7':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #2ad1c1;color:black; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-calendar"></i></td>';

																break;
															case '8':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #4cd13a;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-check"></i></td>';
																break;

															case '9':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: purple; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-thumbs-down"></i></td>';
																break;
															
															default:
																echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer;"></td>';
																break;
														}

													}	
													else
													{
														echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer;"></td>';
													}
											}
								}//end else
						}//end for
				}

							
					echo '</tr>							
							</tbody>

							<tfoot>
							<tr>
								<th></th>';
								
									$sql = mysqli_query($conn, "SELECT c.trcnombres, a.clbcodigo, d.crgnombre, CONCAT(e.trnnombre, ' DE ', TIME_FORMAT(e.trndesde, '%H:%i'), ' A ', TIME_FORMAT(e.trnhasta,'%H:%i')) AS trnnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btyturno e ON e.trncodigo=a.trncodigo WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.prgfecha = '".$_POST['fecha']."' AND a.tprcodigo IN (1,9) AND d.crgincluircolaturnos = 1 GROUP BY d.crgnombre, a.clbcodigo, e.trnnombre, e.trndesde, e.trnhasta ORDER BY d.crgnombre");

									$filas = mysqli_num_rows($sql);

									while ($row = mysqli_fetch_array($sql)) 
									{
										$nombre = explode(" ", $row['trcnombres']);
										
										switch ($row[2]) 
										{
											case 'ESTETICISTA':
												echo '
												
												<th class="info" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$row['trnnombre'].'">'.$nombre[0].' </th>';										
	
												break;

											case 'ESTILISTA':
												echo '<th class="danger" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$row['trnnombre'].'">'.$nombre[0].'</th>';										
	
												break;

											case 'MANICURISTA':
												echo '<th class="success" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$row['trnnombre'].'">'.$nombre[0].'</th>';										
	
												break;
											
											default:
												# code...
												break;
										}

										//$codcol.=$row['clbcodigo'].',';
									}
							
							echo '</tr>
						</tfoot>
								</table>';
		break;

		case 'estado':

			//$sql = mysqli_query($conn, "UPDATE btynovedad_cita SET esccodigo = '".$_POST['estado']."' WHERE citcodigo = '".$_POST['citcodigo']."' ");

			$sql = mysqli_query($conn, "INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES('".$_POST['estado']."', '".$_POST['citcodigo']."', CURDATE(), CURTIME(), '".$_SESSION['PDVcodigoUsuario']."', '')");


			if ($sql) 
			{
				echo 1;
			}
		break;


		case 'reprogramar':

				if ($_POST['newCol'] != "") 
				{
					$codColaborador = $_POST['newCol'];
				}
				else
				{
					$codColaborador = $_POST['clbcodigo'];
				}


				$validate = mysqli_query($conn, "SELECT * FROM btycita a WHERE a.citfecha = '".$_POST['fecha']."' AND a.cithora = '".$_POST['hora']."' AND a.clbcodigo = '".$codColaborador."' ");

				if (mysqli_num_rows($validate) > 0) 
				{
					echo 2;
				}
				else
				{
					$query = "UPDATE btycita SET meccodigo = '".$_POST['medio']."', sercodigo = '".$_POST['servicio']."', citfecha = '".$_POST['fecha']."', cithora = '".$_POST['hora']."', citobservaciones = '".utf8_encode($_POST['observ'])."' WHERE citcodigo = '".$_POST['citcodigo']."' ";			
			
					$sql = mysqli_query($conn, $query)or die(mysqli_error($conn));

					if ($sql) 
					{
						$h = "INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones)VALUES(7, '".$_POST['citcodigo']."', CURDATE(), CURTIME(), '".$_SESSION['PDVcodigoUsuario']."', '')";
						
						mysqli_query($conn, $h)or die(mysqli_error($conn));
						echo 1;
					}
				}
		break;


		case 'validarServicio':
			
			$varT = mysqli_query($conn, "SELECT a.serduracion FROM btyservicio a WHERE a.sercodigo = '".$_POST['servicio']."' ");

			$d = mysqli_fetch_array($varT);

			if ($_POST['fecha'] != "") 
			{
				//$s = "SELECT cita.citcodigo, TIME_FORMAT(cita.cithora, '%H:%i')AS cithora , b.serduracion FROM btycita cita JOIN btyservicio b ON b.sercodigo=cita.sercodigo WHERE cita.citfecha = '".$_POST['fecha']."' AND cita.clbcodigo = '".$_POST['clb']."' and cita.cithora BETWEEN '".$_POST['hora']."' and SUBTIME(TIME_FORMAT(ADDTIME(TIME_FORMAT('".$_POST['hora']."', '%H:%i'), SEC_TO_TIME('".$d[0]."' *60)), '%H:%i'),1)";


				$s = "SELECT cita.citcodigo, TIME_FORMAT(cita.cithora, '%H:%i')AS cithora , b.serduracion FROM btycita cita JOIN btyservicio b ON b.sercodigo=cita.sercodigo JOIN btynovedad_cita c ON c.citcodigo=cita.citcodigo WHERE cita.citfecha = '".$_POST['fecha']."' AND cita.clbcodigo = '".$_POST['clbcodigo']."' and cita.cithora BETWEEN '".$_POST['hora']."' and SUBTIME(TIME_FORMAT(ADDTIME(TIME_FORMAT('".$_POST['hora']."', '%H:%i'), SEC_TO_TIME('".$d[0]."' *60)), '%H:%i'),1) and not c.esccodigo in (3,1)";

			}
			else
			{

				//$s = "SELECT cita.citcodigo, TIME_FORMAT(cita.cithora, '%H:%i')AS cithora , b.serduracion FROM btycita cita JOIN btyservicio b ON b.sercodigo=cita.sercodigo WHERE cita.citfecha = CURDATE() AND cita.clbcodigo = '".$_POST['clb']."' and cita.cithora BETWEEN '".$_POST['hora']."' and SUBTIME(TIME_FORMAT(ADDTIME(TIME_FORMAT('".$_POST['hora']."', '%H:%i'), SEC_TO_TIME('".$d[0]."' *60)), '%H:%i'),1)";

				$s = "SELECT cita.citcodigo, TIME_FORMAT(cita.cithora, '%H:%i')AS cithora , b.serduracion FROM btycita cita JOIN btyservicio b ON b.sercodigo=cita.sercodigo JOIN btynovedad_cita c ON c.citcodigo=cita.citcodigo WHERE cita.citfecha = CURDATE() AND cita.clbcodigo = '".$_POST['clbcodigo']."' and cita.cithora BETWEEN '".$_POST['hora']."' and SUBTIME(TIME_FORMAT(ADDTIME(TIME_FORMAT('".$_POST['hora']."', '%H:%i'), SEC_TO_TIME('".$d[0]."' *60)), '%H:%i'),1) and not c.esccodigo in (3,1)";
			}
			

			//echo $s;

			$array = array();

			$varC = mysqli_query($conn, $s);

			if (mysqli_num_rows($varC) > 0) 
			{
				$row = mysqli_fetch_array($varC);

				$array[] = array('hora' => $row['cithora'], 'duracion' => $d[0]);
				echo json_encode(array("res" => "full", "json" => $array));
			}
			else
			{
				echo json_encode(array("res" => "empty"));
			}

			break;

		case 'valDoc':

			$f = "SELECT a.cliemail, b.trctelefonofijo, b.trctelefonomovil FROM btycliente a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento WHERE a.trcdocumento = '".$_POST['doc']."' AND a.clitiposangre <> ' '";

			$array = array();
			
	       	$sql = mysqli_query($conn,$f);

			if (mysqli_num_rows($sql) > 0) 
			{
				$row = mysqli_fetch_array($sql);

				$array[] = array('email' => $row['cliemail'], 'fijo' => $row['trctelefonofijo'], 'movil' => $row['trctelefonomovil']);

				$array = utf8_converter($array);

				echo json_encode(array("res" => "full", "json" => $array));

			}
			else
			{
				echo json_encode(array("res" => "vacio"));
			}

			break;

		default: 
		break;
    }

   
?>