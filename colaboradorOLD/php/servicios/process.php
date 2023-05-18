<?php 
  include '../../../cnx_data.php';
	include("../funciones.php");

	switch ($_POST['opcion']) 
	{
		case 'listado':
				
				$Query = mysqli_query($conn, "SELECT a.sercodigo, a.sernombre, a.serdescripcion, CONCAT(a.serduracion, ' MIN') AS serduracion, b.crsnombre FROM btyservicio_colaborador c JOIN btyservicio a ON c.sercodigo=a.sercodigo JOIN btycaracteristica b ON a.crscodigo=b.crscodigo WHERE c.clbcodigo = '".$_POST['codColaborador']."' ORDER BY a.sernombre ");

				if(mysqli_num_rows($Query) > 0)
				{
			 		while($data = mysqli_fetch_assoc($Query))
			 		{
			        	$array['data'][] = $data;
			     	} 

			     	$array= utf8_converter($array); 
			     	echo json_encode($array); 
			    }

			break;
		
		default:
			# code...
			break;
	}

	mysqli_close($conn);
?>