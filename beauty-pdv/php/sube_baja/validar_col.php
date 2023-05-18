<?php 
	header("content-type: application/json");
	include("../../../cnx_data.php");

	$array = array();

	$sql = mysqli_query($conn, "SELECT a.slncodigo, a.clbcodigo, a.colposicion, a.coldisponible FROM btycola_atencion a WHERE a.slncodigo = '".$_POST['salon']."' AND a.tuafechai = CURDATE() AND a.colhorasalida IS NULL");

	if (mysqli_num_rows($sql) > 0) 
	{
		while ($row = mysqli_fetch_object($sql)) 
		{
			$array[] = array(
				'cod_sln' 	=> $row->slncodigo,
			    'cod_col'	=> $row->clbcodigo,
			    'cod_pos'	=> $row->colposicion,
			    'info'      => 'assigned'
			);
		}

			echo json_encode($array);
	}
	else
	{
		while ($row = mysqli_fetch_object($sql)) 
		{
			$array[] = array(
				'cod_sln' 	=> $row->slncodigo,
			    'cod_col'	=> $row->clbcodigo,
			    'cod_pos'	=> $row->colposicion,
			    'info'      => 'unassigned'
			);
		}
		   echo json_encode($array);
	}

	mysqli_close($conn);
 ?>