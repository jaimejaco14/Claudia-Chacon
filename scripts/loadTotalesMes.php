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

	


	
			$j ="(
				SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, bio.abmnuevotipo,bio.abmhora, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo IN (2, 3) AND a.clbcodigo = '".$_POST['clbcodigo']."' AND a.slncodigo = '".$_POST['slncodigo']."' ORDER BY t.trcrazonsocial) 
				UNION 
				(
				SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS aptnombre, '','', j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND a.abmcodigo IS NULL AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo IN(4,6) AND a.clbcodigo = '".$_POST['clbcodigo']."' AND a.slncodigo = '".$_POST['slncodigo']."' ORDER BY t.trcrazonsocial) 
				UNION 
				(
				SELECT a.abmcodigo, a.clbcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre,f.aptnombre,a.prgfecha, NULL, NULL,q.abmhora, NULL, NULL, NULL, NULL, a.prgfecha, NULL, NULL, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo JOIN btyasistencia_procesada_tipo f ON f.aptcodigo=a.aptcodigo JOIN btyasistencia_biometrico q ON q.abmcodigo=a.abmcodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND a.aptcodigo = 5 AND a.clbcodigo = '".$_POST['clbcodigo']."' AND a.slncodigo = '".$_POST['slncodigo']."') 
				UNION 
				(
				SELECT a.abmcodigo, a.clbcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre, a.abmtipoerror, a.abmtipo, a.abmnuevotipo, null, a.abmhora, NULL, NULL, NULL, NULL, a.abmfecha, NULL, NULL, NULL FROM btyasistencia_biometrico a JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo WHERE MONTH(a.abmfecha) = MONTH(CURDATE()) AND a.abmerroneo = 1 AND a.clbcodigo = '".$_POST['clbcodigo']."' AND a.slncodigo = '".$_POST['slncodigo']."') ORDER BY prgfecha";

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
				      			'fecha'     => $row['prgfecha'],
				      			'hora'      => $row['abmhora'],	
				      			'aptnombre'   => $row['aptnombre'],	
				      			'apcvalorizacion'   => $row['apcvalorizacion']      	


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

					  	


		
mysqli_free_result($sql);
mysqli_close($conn);

 
                   
 ?>