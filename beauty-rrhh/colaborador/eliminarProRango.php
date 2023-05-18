<?php 
	include '../../cnx_data.php';

	function utf8_converter($array)
	{
    		array_walk_recursive($array, function(&$item, $key)
    		{
        		if(!mb_detect_encoding($item, 'utf-8', true)){
            	$item = utf8_encode($item);
        	}
    	});

    	return $array;
	}

	switch ($_POST['opcion']) 
	{
		case 'eliminarPro':
			
			$sql = mysqli_query($conn, "DELETE FROM btyprogramacion_colaboradores WHERE clbcodigo = '".$_POST['clbcod']."' AND prgfecha BETWEEN '".$_POST['fechai']."' AND '".$_POST['fechaf']."' ");

			if ($sql) 
			{
				echo 1;
			}

			break;

		case 'loadData':
			
			$sql = mysqli_query($conn, "SELECT b.trcrazonsocial FROM btycolaborador a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento WHERE a.clbcodigo = '".$_POST['clbcod']."'");

			$array = array();

			$row = mysqli_fetch_array($sql);

			$array[] = array('nombre' => $row['trcrazonsocial']);

			$array = utf8_converter($array);

			echo json_encode(array("res" => "full", "json" => $array));


			break;
		
		default:
			# code...
			break;
	}




	mysqli_close($conn);
?>