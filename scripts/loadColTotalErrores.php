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
		case 'Errormes':
	
			$j ="SELECT a.clbcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre, a.abmfecha, a.abmhora, a.abmnuevotipo, a.abmtipoerror FROM btyasistencia_biometrico a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo WHERE a.slncodigo = '".$_POST['slncodigo']."' AND a.abmerroneo = 1 AND MONTH(a.abmfecha) = MONTH(CURDATE()) AND a.clbcodigo = '".$_POST['clbcodigo']."' ORDER BY c.trcrazonsocial";

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
				      			'abmtipo'   => $row['abmnuevotipo'],
				      			'abmhora'   => $row['abmhora'],
				      			'fecha'     => $row['abmfecha'],
				      			'error'     => $row['abmtipoerror'],

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

		case 'ausencias':
			
			$j ="SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS aptnombre, '','', j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND a.abmcodigo IS NULL AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo IN(4) AND a.slncodigo = '".$_POST['slncodigo']."' AND a.clbcodigo = '".$_POST['clbcodigo']."' ORDER BY t.trcrazonsocial";

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
				      			'tipo'      => $row['aptnombre'],
				      			'salon'     => $row['slnnombre'],
				      			'fecha'     => $row['prgfecha'],
				      			'valor'     => $row['apcvalorizacion'],

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