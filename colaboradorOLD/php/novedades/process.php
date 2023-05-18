<?php 
	session_start();
  include '../../../cnx_data.php';
	include("../funciones.php");

	switch ($_POST['opcion']) 
	{
		case 'listado':
				mysqli_query($conn, "SET lc_time_names = 'es_CO'" );
				
				$Query = mysqli_query($conn, "SELECT a.nvpcodigo, c.tnvnombre, a.nvpobservacion, a.nvphoradesde, a.nvphorahasta, DATE_FORMAT(a.nvpfecha, '%d de %M de %Y')as nvpfecha, a.nvpestado FROM btynovedades_programacion a JOIN btynovedades_programacion_detalle b ON a.nvpcodigo=b.nvpcodigo JOIN  btytipo_novedad_programacion c ON c.tnvcodigo=a.tnvcodigo WHERE MONTH(a.nvpfecha) = MONTH(CURDATE()) AND b.clbcodigo = '".$_POST['codColaborador']."'");

				if(mysqli_num_rows($Query) > 0)
				{
			 		while($data = mysqli_fetch_assoc($Query))
			 		{
			        		$array['data'][] = $data;
			     		} 

			     				$array= utf8_converter($array); 
			     				echo json_encode($array); 
			    	}
			    	else
			    	{
			    		echo json_encode(array("No hay datos"));
			    	}

			break;

		case 'searchApp':

			mysqli_query($conn, "SET lc_time_names = 'es_CO'" );
				
				$Query = mysqli_query($conn, "SELECT a.nvpcodigo, c.tnvnombre, a.nvpobservacion, a.nvphoradesde, a.nvphorahasta, DATE_FORMAT(a.nvpfecha, '%d de %M de %Y')as nvpfecha, a.nvpestado FROM btynovedades_programacion a JOIN btynovedades_programacion_detalle b ON a.nvpcodigo=b.nvpcodigo JOIN  btytipo_novedad_programacion c ON c.tnvcodigo=a.tnvcodigo WHERE MONTH(a.nvpfecha) = MONTH(CURDATE()) AND b.clbcodigo = '".$_POST['codColaborador']."' AND a.nvpfecha = '".$_POST['fecha']."' ");

				$array = array();
				$conteo = mysqli_num_rows($Query);

				if (mysqli_num_rows($Query) > 0) 
				{
					while ($row = mysqli_fetch_array($Query)) 
					{
						$array[] = array(
							'id' 	=> $row['nvpcodigo'],
							'tipo' 	=> $row['tnvnombre'],
							'obser' => $row['nvpobservacion'],
							'desde' => $row['nvphoradesde'],
							'hasta' => $row['nvphorahasta'],
							'fecha' => $row['nvpfecha'],
							'estado'=> $row['nvpestado'],
							'conteo' => $conteo
						);
					}


			     	$array= utf8_converter($array); 
			     	echo json_encode(array("res" => "full", "json" => $array)); 
				}
				else
				{
					echo json_encode(array("res" => "empty")); 
				}
			
			break;

		case 'conteo':

			
				 $Query = mysqli_query($conn, "SELECT a.nvpcodigo, c.tnvnombre, a.nvpobservacion, a.nvphoradesde, a.nvphorahasta, a.nvpfecha, a.nvpestado FROM btynovedades_programacion a JOIN btynovedades_programacion_detalle b ON a.nvpcodigo=b.nvpcodigo JOIN  btytipo_novedad_programacion c ON c.tnvcodigo=a.tnvcodigo WHERE MONTH(a.nvpfecha) = MONTH(CURDATE()) AND b.clbcodigo = '".$_SESSION['clbcodigo']."' ");

                          $count = mysqli_num_rows($Query);

                          echo $count;

			break;
		
		default:
			
			break;
	}

	mysqli_close($conn);
?>