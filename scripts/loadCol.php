<?php 
	include(dirname(__FILE__).'/../cnx_data.php');

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
		case 'dia':
			$j ="(
			
			SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, bio.abmnuevotipo,bio.abmhora, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND NOT a.prgfecha = CURDATE() AND s.slncodigo ='".$_POST['slncodigo']."' AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.clbcodigo = '".$_POST['clbcodigo']."' AND a.aptcodigo = '".$_POST['aptcodigo']."' ORDER BY t.trcrazonsocial 
			) 

			UNION 

			(
			
			SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS aptnombre, '','', j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND a.abmcodigo IS NULL AND NOT a.aptcodigo=6 AND s.slncodigo = '".$_POST['slncodigo']."' AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.clbcodigo = '".$_POST['clbcodigo']."' AND a.aptcodigo = '".$_POST['aptcodigo']."' ORDER BY t.trcrazonsocial
			) 

			UNION 
			
			(
			SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre, b.aptnombre, s.slnnombre, CASE WHEN IFNULL(NULL, IF((SELECT ab.abmnuevotipo FROM btyasistencia_procesada ap2 JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap2.abmcodigo WHERE ap2.prgfecha = a.prgfecha AND ap2.clbcodigo=a.clbcodigo AND ap2.abmcodigo IS NOT NULL)='ENTRADA','SALIDA','ENTRADA')) = 'SALIDA' THEN CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) ELSE CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) END AS desde, IFNULL(NULL, IF((SELECT ab.abmnuevotipo FROM btyasistencia_procesada ap2 JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap2.abmcodigo WHERE ap2.prgfecha = a.prgfecha AND ap2.clbcodigo=a.clbcodigo AND ap2.abmcodigo IS NOT NULL)='ENTRADA','SALIDA','ENTRADA')) AS TIPO, NULL, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND a.abmcodigo IS NULL AND a.aptcodigo=6 AND s.slncodigo = '".$_POST['slncodigo']."' AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.clbcodigo = '".$_POST['clbcodigo']."' AND a.aptcodigo = '".$_POST['aptcodigo']."'
			)
			
			ORDER BY prgfecha";

			$sql = mysqli_query($conn, $j);

				//echo $j;

				$array=array();

		           	if(mysqli_num_rows($sql) > 0)
					{		    
				      	while ($row = mysqli_fetch_array($sql)) 
				      	{
				      		$array[] = array(
				      			'clbcodigo' => $row['clbcodigo'],
				      			'nombre'    => $row['trcrazonsocial'],
				      			'cargo'     => $row['crgnombre'],
				      			'categoria' => $row['ctcnombre'],
				      			'aptnombre' => $row['aptnombre'],
				      			'desde'     => $row['desde'],
				      			'salon'     => $row['slnnombre'],
				      			'abmtipo'   => $row['abmnuevotipo'],
				      			'abmhora'   => $row['abmhora'],
				      			'fecha'     => $row['prgfecha'],
				      			'valor'     => $row['apcvalorizacion'],
				      			'abmcodigo' => $row['abmcodigo'],
				      			'trncodigo' => $row['trncodigo'],
				      			'horcodigo' => $row['horcodigo'],
				      			'slncodigo' => $row['slncodigo'],
				      			'aptcodigo' => $row['aptcodigo']
				      		);
				      	}

				      	$array = utf8_converter($array);
				      	echo json_encode(array("res" => "full", "json" => $array));

				  	}
				  	else
				  	{
				    	$array[] = array('info', 'No hay datos coincidentes');
				    	echo json_encode($array);
				  	}

				  	
			break;

		case 'mes':
			
					$j ="(
						SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, bio.abmnuevotipo,bio.abmhora, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON  crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND NOT a.prgfecha = CURDATE() AND s.slncodigo ='".$_POST['slncodigo']."' AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.clbcodigo = '".$_POST['clbcodigo']."' ORDER BY t.trcrazonsocial 
						) 

						UNION 

						(
						
						SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS aptnombre, '','', j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND a.abmcodigo IS NULL AND NOT a.aptcodigo=6 AND s.slncodigo = '".$_POST['slncodigo']."' AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.clbcodigo = '".$_POST['clbcodigo']."' ORDER BY t.trcrazonsocial

						) 

						UNION 
						
						(

						SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre, b.aptnombre, s.slnnombre, CASE WHEN IFNULL(NULL, IF((SELECT ab.abmnuevotipo FROM btyasistencia_procesada ap2 JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap2.abmcodigo WHERE ap2.prgfecha = a.prgfecha AND ap2.clbcodigo=a.clbcodigo AND ap2.abmcodigo IS NOT NULL)='ENTRADA','SALIDA','ENTRADA')) = 'SALIDA' THEN CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) ELSE CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) END AS desde, IFNULL(NULL, IF((SELECT ab.abmnuevotipo FROM btyasistencia_procesada ap2 JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap2.abmcodigo WHERE ap2.prgfecha = a.prgfecha AND ap2.clbcodigo=a.clbcodigo AND ap2.abmcodigo IS NOT NULL)='ENTRADA','SALIDA','ENTRADA')) AS TIPO, NULL, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND a.abmcodigo IS NULL AND a.aptcodigo=6 AND s.slncodigo = '".$_POST['slncodigo']."' AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.clbcodigo = '".$_POST['clbcodigo']."'

						)
							ORDER BY prgfecha";

				$sql = mysqli_query($conn, $j);

				//echo $j;

				$array=array();

		           	if(mysqli_num_rows($sql) > 0)
					{		    
				      	while ($row = mysqli_fetch_array($sql)) 
				      	{
				      		$array[] = array(
				      			'clbcodigo' => $row['clbcodigo'],
				      			'nombre'    => $row['trcrazonsocial'],
				      			'cargo'     => $row['crgnombre'],
				      			'categoria' => $row['ctcnombre'],
				      			'aptnombre' => $row['aptnombre'],
				      			'desde'     => $row['desde'],
				      			'salon'     => $row['slnnombre'],
				      			'abmtipo'   => $row['abmnuevotipo'],
				      			'abmhora'   => $row['abmhora'],
				      			'fecha'     => $row['prgfecha'],
				      			'valor'     => $row['apcvalorizacion'],
				      			'abmcodigo' => $row['abmcodigo'],
				      			'trncodigo' => $row['trncodigo'],
				      			'horcodigo' => $row['horcodigo'],
				      			'slncodigo' => $row['slncodigo'],
				      			'aptcodigo' => $row['aptcodigo']
				      		);
				      	}

				      	$array = utf8_converter($array);
				      	echo json_encode(array("res" => "full", "json" => $array));

				  	}
				  	else
				  	{
				    		$array[] = array('info', 'No hay datos coincidentes');
				    		echo json_encode($array);
				  	}

					  	
					break;
		
		default:
			# code...
			break;
	}

		
mysqli_free_result($sql);
mysqli_close($conn);

 
                   
 ?>