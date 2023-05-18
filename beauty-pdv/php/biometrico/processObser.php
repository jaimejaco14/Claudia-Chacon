<?php 
	include("../../../cnx_data.php");

	


	$QueryValidar = mysqli_query($conn, "SELECT a.clbcodigo, a.trncodigo, a.horcodigo, a.slncodigo, a.prgfecha, a.abmcodigo, a.aptcodigo, a.apcvalorizacion, a.apcobservacion FROM btyasistencia_procesada a WHERE a.clbcodigo = '".$_POST['codcol']."' AND a.trncodigo = '".$_POST['codtur']."' AND a.horcodigo = '".$_POST['codhor']."' AND a.slncodigo = '".$_POST['codsln']."' AND a.prgfecha = '".$_POST['fechaCod']."' AND NOT a.aptcodigo = 1 AND NOT a.aptcodigo = 5");

	$array = array();

	while ($row = mysqli_fetch_array($QueryValidar)) 
	{
		$array[] = array(
			'clbcodigo' 	=> $row['clbcodigo'],
			'trncodigo' 	=> $row['trncodigo'],
			'horcodigo' 	=> $row['horcodigo'],
			'slncodigo' 	=> $row['slncodigo'],
			'prgfecha' 	    => $row['prgfecha'],
			'abmcodigo' 	=> $_POST['abmcodigo'],
			'aptcodigo' 	=> $row['aptcodigo']

		);

	}

	echo json_encode(array("res" => "full", "json" => $array));

 ?>

 
