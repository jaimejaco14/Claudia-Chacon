<?php 
	include("../../../cnx_data.php");

	$sql = mysqli_query($conn, "SELECT a.pmocondyrestric, b.pmddia FROM btypromocion a JOIN btypromocion_detalle b ON b.pmocodigo=a.pmocodigo WHERE a.pmocodigo = '".$_POST['idpromo']."' AND b.slncodigo = '".$_SESSION['PDVslncodigo']."' ");

	$array = array();

	while($row = mysqli_fetch_array($sql))
	{
		$array[] = array('condicion' => $row['pmocondyrestric'], "dia" => $row['pmddia']);
	}

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

	$array  = utf8_converter($array);
	echo json_encode(array("json" => $array, "res" => "full"));

	mysqli_close($conn);
?>