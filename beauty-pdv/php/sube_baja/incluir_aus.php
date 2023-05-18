<?php 
	include("../../../cnx_data.php");

	$sql = mysqli_query($conn, "SELECT b.clbcodigo, b.trcdocumento, c.trcrazonsocial, ctc.ctcnombre, d.trnnombre, cargo.crgnombre, tp.tprnombre, CONCAT(d.trnnombre, ' DE: ', DATE_FORMAT(d.trndesde, '%H:%i'), ' A: ', DATE_FORMAT(d.trnhasta, '%H:%i'), ' ALM: ', DATE_FORMAT(d.trninicioalmuerzo, '%H:%i'), ' - ', DATE_FORMAT(d.trnfinalmuerzo, '%H:%i')) AS turno FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON b.trcdocumento=c.trcdocumento JOIN btyturno d ON d.trncodigo=a.trncodigo JOIN btycargo cargo ON b.crgcodigo=cargo.crgcodigo JOIN btytipo_programacion tp ON tp.tprcodigo=a.tprcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=b.ctccodigo WHERE a.prgfecha = CURDATE() AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND cargo.crgincluircolaturnos = 1 AND NOT tp.tprlabora=1 ORDER BY d.trnnombre, cargo.crgnombre");

	$array = array();

	if (mysqli_num_rows($sql) > 0) 
	{
		while ($row = mysqli_fetch_array($sql)) 
		{

			$consulta2 = mysqli_query($conn, "SELECT b.clbcodigo, b.trcdocumento, c.trcrazonsocial, d.trnnombre,  tpg.tprnombre, tpg.tprcodigo,  cargo.crgnombre, ctc.ctcnombre, tp.tprlabora,CONCAT(d.trnnombre, ' DE: ', DATE_FORMAT(d.trndesde, '%H:%i'), ' A: ', DATE_FORMAT(d.trnhasta, '%H:%i'), ' ALM: ', DATE_FORMAT(d.trninicioalmuerzo, '%H:%i'), ' - ', DATE_FORMAT(d.trnfinalmuerzo, '%H:%i')) AS turno, (SELECT coldisponible FROM btycola_atencion WHERE clbcodigo = '".$row['clbcodigo']."' AND slncodigo = '".$_POST['salon']."' AND tuafechai = CURDATE()) AS disponible, (SELECT colhorasalida FROM btycola_atencion WHERE clbcodigo = '".$row['clbcodigo']."' AND slncodigo = '".$_SESSION['PDVslncodigo']."' AND tuafechai = CURDATE()) AS horasalida, (SELECT colhoraingreso FROM btycola_atencion WHERE clbcodigo = '".$row['clbcodigo']."' AND slncodigo = '".$_SESSION['PDVslncodigo']."' AND tuafechai = CURDATE()) AS hraingreso FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON b.trcdocumento=c.trcdocumento JOIN btyturno d ON d.trncodigo=a.trncodigo JOIN btycargo cargo ON b.crgcodigo=cargo.crgcodigo JOIN btytipo_programacion tp ON tp.tprcodigo=a.tprcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=b.ctccodigo JOIN btytipo_programacion tpg ON tpg.tprcodigo=a.tprcodigo WHERE a.prgfecha = CURDATE() AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND cargo.crgincluircolaturnos = 1 AND NOT tp.tprlabora= 1 AND a.clbcodigo = '".$row['clbcodigo']."' ORDER BY d.trnnombre, cargo.crgnombre");


			 $fec = mysqli_fetch_array($consulta2);

		    	 $array[] = array(
		    	 	 'doc'     => $fec['trcdocumento'],
		             'cod_col' => $fec['clbcodigo'],
		             'nombre'  => $fec['trcrazonsocial'],
		             'turno'   => $fec['turno'],
		             'cargo'   => $fec['crgnombre'],
		             'perfil'  => $fec['ctcnombre'],
		             'tipo'    => $fec['tprnombre'],
		             'salon'   => $_SESSION['PDVslncodigo'],
		             'disp'    => $fec['disponible'],
		             'hsalida' => $fec['horasalida'],
		             'hingreso' => $fec['hraingreso'],
		             'tprcodigo' => $fec['tprcodigo']

		    	 );
		}

		function utf8_converter($array)
		{
	    	array_walk_recursive($array, function(&$item, $key){
		      if(!mb_detect_encoding($item, 'utf-8', true)){
		        $item = utf8_encode($item);
		      }
	    	});

    		return $array;
  		}

  		$array= utf8_converter($array);

  		echo json_encode(array("res" => "full", "json" => $array)); 
	}


?>