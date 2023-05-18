<?php 
	include("../../../cnx_data.php");

	//print_r($_POST);

	if ($_POST['abmcodigo'] != null || $_POST['abmcodigo'] != "") 
	{
		
		$QueryVerObs = mysqli_query($conn, "SELECT a.apcobservacion, t.trcrazonsocial FROM btyasistencia_procesada a JOIN btycolaborador c ON a.clbcodigo=c.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento WHERE a.clbcodigo = '".$_POST['codcol']."' AND a.trncodigo = '".$_POST['codtur']."' AND a.horcodigo = '".$_POST['codhor']."' AND a.slncodigo = '".$_POST['codsln']."' AND a.prgfecha = '".$_POST['fechaCod']."' AND a.abmcodigo = '".$_POST['abmcodigo']."' AND a.aptcodigo = '".$_POST['aptcod']."' AND t.tdicodigo=c.tdicodigo");

		$row = mysqli_fetch_array($QueryVerObs);
		$array = array();


	  	$array[] = array("observacion" => $row['apcobservacion'], "nombre" => $row['trcrazonsocial']);

	  	$array = utf8_converter($array);

		echo json_encode(array("res" => "full", "obs" => $array));
		
		
	}
	else
	{
		$QueryVerObs = mysqli_query($conn, "SELECT a.apcobservacion, t.trcrazonsocial FROM btyasistencia_procesada a JOIN btycolaborador c ON a.clbcodigo=c.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento WHERE a.clbcodigo = '".$_POST['codcol']."' AND a.trncodigo = '".$_POST['codtur']."' AND a.horcodigo = '".$_POST['codhor']."' AND a.slncodigo = '".$_POST['codsln']."' AND a.prgfecha = '".$_POST['fechaCod']."' AND a.abmcodigo IS NULL AND a.aptcodigo = '".$_POST['aptcod']."' AND t.tdicodigo=c.tdicodigo");

			$row = mysqli_fetch_array($QueryVerObs);
			$array = array();


		  	$array[] = array("observacion" => $row['apcobservacion'], "nombre" => $row['trcrazonsocial']);

		  	$array = utf8_converter($array);

			echo json_encode(array("res" => "full", "obs" => $array));
	}


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
	

	mysqli_close($conn);
 ?>