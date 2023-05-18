<?php 
	//session_start();
  	header('Content-Type: application/json');
  	include("../../../cnx_data.php");


  	$sql=mysqli_query($conn,"SELECT DISTINCT a.clbcodigo, c.trcrazonsocial FROM btyasistencia_procesada a JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND MONTH(a.prgfecha) = MONTH(CURDATE())  AND year(a.prgfecha) = year(CURDATE()) ORDER BY c.trcrazonsocial");



		if(mysqli_num_rows($sql) > 0)
		{


			while ($row = mysqli_fetch_array($sql)) 
			{
				$QueryCantidad = mysqli_query($conn, "SELECT DISTINCT a.clbcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre, (SELECT COUNT(ap.aptcodigo)FROM btyasistencia_procesada ap WHERE ap.slncodigo = '".$_SESSION['PDVslncodigo']."' AND MONTH(ap.prgfecha) = MONTH(CURDATE())  AND year(ap.prgfecha) = year(CURDATE()) AND ap.clbcodigo = '".$row['clbcodigo']."' AND ap.apcobservacion = '' AND ap.aptcodigo not in (1,5)) AS cantidad, (SELECT CONCAT('$',FORMAT(SUM(a.apcvalorizacion),0)) FROM btyasistencia_procesada a WHERE a.clbcodigo = '".$row['clbcodigo']."' AND MONTH(a.prgfecha) = MONTH(CURDATE()) AND year(a.prgfecha) = year(CURDATE()) AND NOT a.aptcodigo = 1 AND a.apcobservacion = '' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."')AS total FROM btyasistencia_procesada a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND MONTH(a.prgfecha) = MONTH(CURDATE()) AND year(a.prgfecha) = year(CURDATE()) AND a.clbcodigo = '".$row['clbcodigo']."'");




				while($data = mysqli_fetch_assoc($QueryCantidad))
		    		{
		        		$array['data'][] = $data;

		    		}        
		    
			}
		      		$array= utf8_converter($array);
		      		echo json_encode($array);


		 
		   
		      
		}
		else
		{
		    	$array[] = array('info', 'No hay datos coincidentes');
		    	echo json_encode($array);
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



  	mysqli_free_result($sql);
  	mysqli_close($conn);
 
 ?>