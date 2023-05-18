<?php 
	session_start();
  	include '../../../cnx_data.php';
	include("../funciones.php");

	switch ($_POST['opcion']) 
	{
		case 'listado':

				mysqli_query($conn, "SET lc_time_names = 'es_CO'" );

				if ($_POST['desde'] != "" || $_POST['hasta'] != "")
				{
					$desde = " AND a.prgfecha BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."'";
					$desdeX = " AND a.abmfecha BETWEEN '".$_POST['desdeX']."' AND '".$_POST['hastaX']."'";
				}
				else
				{
					$desde  = str_replace($desde);
					$desdeX = str_replace($desdeX);
				}
				

				


				if ($_POST['tipo'] == 1 || $_POST['tipo'] == 2) 
				{
					$f = "SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, bio.abmnuevotipo,bio.abmhora, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion, TIMEDIFF(bio.abmhora, j.trndesde) AS dif FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE a.apcobservacion = '' AND a.aptcodigo = '".$_POST['tipo']."' AND a.clbcodigo = '".$_POST['codColaborador']."' ".$desde." ORDER BY a.prgfecha DESC";
					
					$Query = mysqli_query($conn, $f);
				}else
				{
					if ($_POST['tipo'] == 4) 
					{
						$Query = mysqli_query($conn, "SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, ' ' AS 'abmhora', s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, '','', j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion, NULL FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo  WHERE a.abmcodigo IS NULL AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo = 4 AND a.clbcodigo = '".$_POST['codColaborador']."' ".$desde."");
					}
					else
					{
						if ($_POST['tipo'] == 6) 
						{
							$Query = mysqli_query($conn, "SELECT a.clbcodigo, b.aptnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion, a.prgfecha FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo WHERE a.abmcodigo IS NULL AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo = 6 AND a.clbcodigo = '".$_POST['codColaborador']."' ".$desde."");
						}
						else
						{
							if ($_POST['tipo'] == 5) 
							{
								$Query = mysqli_query($conn, "SELECT a.abmcodigo, a.clbcodigo, bio.abmhora, c.trcrazonsocial, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, d.crgnombre, e.ctcnombre,f.aptnombre,a.prgfecha, TIMEDIFF(bio.abmhora, j.trndesde) AS dif, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btyturno j ON j.trncodigo=a.trncodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo JOIN btyasistencia_procesada_tipo f ON f.aptcodigo=a.aptcodigo JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE a.aptcodigo = 5 AND a.clbcodigo = '".$_POST['codColaborador']."' ".$desde." ");
							}
							else
							{
								if ($_POST['tipo'] == 3) 
								{
									$f = "SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, bio.abmnuevotipo,bio.abmhora, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion, TIMEDIFF( j.trnhasta, bio.abmhora) AS dif FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE a.apcobservacion = '' AND a.aptcodigo = 3 AND a.clbcodigo = '".$_POST['codColaborador']."' ".$desde." ORDER BY a.prgfecha DESC";
					
										$Query = mysqli_query($conn, $f);
								}
								else
								{
									if ($_POST['tipo'] == "X") 
									{

										$f = "(
												SELECT b.aptnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, TIMEDIFF(bio.abmhora, j.trndesde)AS dif,bio.abmhora, a.prgfecha, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo = 2 AND a.clbcodigo = '".$_POST['codColaborador']."'  ".$desde." 
											) 

											UNION
											(
												SELECT b.aptnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, TIMEDIFF(j.trnhasta, bio.abmhora)AS dif,bio.abmhora, a.prgfecha, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo = 3 AND a.clbcodigo = '".$_POST['codColaborador']."'  ".$desde." 
											)
											UNION
											(
												SELECT b.aptnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, NULL, null,a.prgfecha, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo WHERE a.abmcodigo IS NULL AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo IN(4,6) AND a.clbcodigo = '".$_POST['codColaborador']."'  ".$desde."
											) 
											UNION
											(
												SELECT f.aptnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, NULL, bio.abmhora, a.prgfecha, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btyturno j ON j.trncodigo=a.trncodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo JOIN btyasistencia_procesada_tipo f ON f.aptcodigo=a.aptcodigo JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE a.aptcodigo = 5 AND a.clbcodigo = '".$_POST['codColaborador']."' ".$desde."		
											) 
											UNION
											(
												SELECT a.abmtipoerror, null, null, a.abmhora, a.abmfecha, NULL FROM btyasistencia_biometrico a JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo WHERE a.abmerroneo = 1 AND a.clbcodigo = '".$_POST['codColaborador']."' ".$desdeX.") ORDER BY prgfecha desc";

												//echo $f;
										$Query = mysqli_query($conn, $f);
									}
								}
							}
						}
					}
				}

				$Total = mysqli_query($conn, "SELECT CONCAT('$',FORMAT(SUM(a.apcvalorizacion),0)) AS total FROM btyasistencia_procesada a WHERE a.clbcodigo = '".$_POST['codColaborador']."' AND a.aptcodigo = '".$_POST['tipo']."' ".$desde." ");

				$fetch = mysqli_fetch_array($Total);

				$totalizado = $fetch[0];
				
				

				if(mysqli_num_rows($Query) > 0)
				{
			 		while($data = mysqli_fetch_assoc($Query))
			 		{
			        		$array['data'][] = $data;
			     		} 

			     				$array= utf8_converter($array);
			     				array_push($array, $totalizado); 
			     				echo json_encode($array); 
			    	}
			    	else
			    	{
			    		echo json_encode(array("No hay datos"));
			    	}

			break;


		
		default:
			
			break;
	}

	mysqli_close($conn);
?>