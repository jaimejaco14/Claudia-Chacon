<?php 
	session_start();
	include("../../../cnx_data.php");

	$QueryColaboradores = mysqli_query($conn, "SELECT t.trcrazonsocial,  cr.crgnombre, case when bty_fnc_salon_colaborador(c.clbcodigo)  is null then '' else bty_fnc_salon_colaborador(c.clbcodigo)  end as slnnombre FROM btycolaborador AS c, btytercero as t, btycargo as cr WHERE MONTH(c.clbfechanacimiento) = MONTH(CURDATE()) AND DAY(c.clbfechanacimiento) = DAY(CURDATE()) and t.trcdocumento=c.trcdocumento and t.tdicodigo=c.tdicodigo and cr.crgcodigo=c.crgcodigo order by t.trcrazonsocial");

	$QueryClientes = mysqli_query($conn, "SELECT t.trcrazonsocial, t.trctelefonomovil, c.clifechanacimiento, c.cliemail FROM btycliente c JOIN btytercero t ON c.trcdocumento=t.trcdocumento WHERE MONTH(c.clifechanacimiento) = MONTH(CURDATE()) AND DAY(c.clifechanacimiento) = DAY(CURDATE())");

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

	

	$QueryCumple    = array();
	$QueryCumplClie = array();

	
		while ($row = mysqli_fetch_array($QueryColaboradores)) 
		{			
				$QueryCumple[] = array(
					'nombre'	=> $row['trcrazonsocial'],
					'cargo'	    => $row['crgnombre'],
					'salon'	    => $row['slnnombre'],
			     );			
		}


		while ($row2 = mysqli_fetch_array($QueryClientes)) 
		{
			
				$QueryCumplClie[] = array(
				'nombre'	=> $row2['trcrazonsocial'],
				'fecha'  	=> $row2['clifechanacimiento'],
				'movil'  	=> $row2['trctelefonomovil'],
				'email'  	=> $row2['cliemail']
		     );			
		}
			$array  = utf8_converter($QueryCumple);
			$array2 = utf8_converter($QueryCumplClie);

			echo json_encode(array("json" => $array, "resp" => "full", "cli" => $array2));		
			
 ?>