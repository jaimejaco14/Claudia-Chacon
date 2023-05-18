<?php 
	header("content-type: application/json");
  	include("../../../cnx_data.php");

  	//session_start();
	//$conn = mysqli_connect("localhost", "appbeauty", "bty_ERP@2017", "beauty_erp");

	

  	switch ($_POST['opcion']) 
  	{
  		case 'graph1':
  			if ($_POST['rango'] == 1) 
			{	
				$query = mysqli_query($conn,"SELECT COUNT(*)AS count, b.slnalias as nombre FROM btycita a JOIN btysalon b ON a.slncodigo=b.slncodigo WHERE MONTH(a.citfecharegistro) = MONTH(CURDATE()) AND b.slnestado=1 GROUP BY a.slncodigo  ORDER BY b.slnnombre");
			}
			else
			{
				$query = mysqli_query($conn,"SELECT COUNT(*)AS count, b.slnalias as nombre FROM btycita a JOIN btysalon b ON a.slncodigo=b.slncodigo WHERE MONTH(a.citfecharegistro) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND b.slnestado=1 GROUP BY a.slncodigo ORDER BY b.slnnombre");
			}


			$output = array();

			if ($query) 
			{

			    foreach ($query as $row) 
			    {
			        $output[] = $row;
			    }
			} 
			else 
			{
			    die("Error: ". mysqli_error($conn));
			}

				echo json_encode($output);
  			break;

  		case 'graph2':


  			if ($_POST['rango'] == 1)
  			{  				
  				$query = mysqli_query($conn, "SELECT CONCAT(t.trcnombres, ' (', bty_fnc_salon_colaborador(a.clbcodigo),')') AS nombre,  COUNT(*) AS count FROM btycita AS a, btytercero AS t, btycolaborador AS c WHERE a.clbcodigo=c.clbcodigo AND c.trcdocumento=t.trcdocumento AND c.tdicodigo=t.tdicodigo AND MONTH(a.citfecharegistro) = MONTH(CURDATE()) GROUP BY nombre ORDER BY COUNT DESC LIMIT 10");
  			}
  			else
  			{
  				$query = mysqli_query($conn, "SELECT CONCAT(t.trcnombres, ' (', bty_fnc_salon_colaborador(a.clbcodigo),')') AS nombre, COUNT(*) AS count FROM btycita AS a, btytercero AS t, btycolaborador AS c WHERE a.clbcodigo=c.clbcodigo AND c.trcdocumento=t.trcdocumento AND c.tdicodigo=t.tdicodigo AND MONTH(a.citfecharegistro) = MONTH(CURDATE() - INTERVAL 1 MONTH) GROUP BY nombre ORDER BY COUNT DESC LIMIT 10");
  			}
  			
  			

  			$output = array();

  			if ($query) 
			{

			    foreach ($query as $row) 
			    {
			        $output[] = $row;
			    }
			} 
			else 
			{
			    die("Error: ". mysqli_error($conn));
			}
				$output = utf8_converter($output);

				echo json_encode($output);

  			break;

  		case 'medios':


  				if ($_POST['rango'] == 1)
	  			{

  					$query = mysqli_query($conn, "SELECT  m.mecnombre AS nombre, count(*)AS count FROM btycita as c, btymedio_contacto as m WHERE m.meccodigo=c.meccodigo and c.slncodigo = '".$_SESSION['PDVslncodigo']."' AND MONTH(c.citfecharegistro) = MONTH(CURDATE()) GROUP BY m.mecnombre ORDER BY m.mecnombre");
				}
	  			else
	  			{
	  				$query = mysqli_query($conn, "SELECT  m.mecnombre AS nombre, count(*)AS count FROM btycita as c, btymedio_contacto as m WHERE m.meccodigo=c.meccodigo and c.slncodigo = '".$_SESSION['PDVslncodigo']."' AND MONTH(c.citfecharegistro) = MONTH(CURDATE() - INTERVAL 1 MONTH) GROUP BY m.mecnombre ORDER BY m.mecnombre");
				}
  			

  				$output = array();

	  			if ($query) 
				{

				    foreach ($query as $row) 
				    {
				        $output[] = $row;
				    }
				} 
				else 
				{
				    die("Error: ". mysqli_error($conn));
				}
					$output = utf8_converter($output);

					echo json_encode($output);
  			break;

  		case 'citasCol':

  				if ($_POST['rango'] == 1)
	  			{

	  				$query = mysqli_query($conn, "SELECT t.trcnombres AS nombre, t.trcrazonsocial AS nom, COUNT(*) AS count FROM btycita AS a, btytercero AS t, btycolaborador AS c WHERE a.clbcodigo=c.clbcodigo AND c.trcdocumento=t.trcdocumento AND c.tdicodigo=t.tdicodigo AND MONTH(a.citfecharegistro) = MONTH(CURDATE()) AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' GROUP BY t.trcnombres, t.trcrazonsocial ORDER BY COUNT DESC LIMIT 10");
	  			}
	  			else
	  			{
	  				$query = mysqli_query($conn, "SELECT t.trcnombres AS nombre, t.trcrazonsocial AS nom, COUNT(*) AS count FROM btycita AS a, btytercero AS t, btycolaborador AS c WHERE a.clbcodigo=c.clbcodigo AND c.trcdocumento=t.trcdocumento AND c.tdicodigo=t.tdicodigo AND MONTH(a.citfecharegistro) = MONTH(CURDATE()) AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND MONTH(a.citfecharegistro) = MONTH(CURDATE() - INTERVAL 1 MONTH) GROUP BY t.trcnombres, t.trcrazonsocial ORDER BY COUNT DESC LIMIT 10");
	  			}

	  			$output = array();

	  			if ($query) 
				{

				    foreach ($query as $row) 
				    {
				        $output[] = $row;
				    }
				} 
				else 
				{
				    die("Error: ". mysqli_error($conn));
				}
					$output = utf8_converter($output);

					echo json_encode($output);
  			break;

  		case 'colabSln':

  				if ($_POST['rango'] == 1)
	  			{

	  				$query = mysqli_query($conn, "SELECT t.trcnombres AS nombre, COUNT(*) AS count FROM btycita AS a, btytercero AS t, btycolaborador AS c WHERE a.clbcodigo=c.clbcodigo AND c.trcdocumento=t.trcdocumento AND c.tdicodigo=t.tdicodigo AND MONTH(a.citfecharegistro) = MONTH(CURDATE()) AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' GROUP BY t.trcnombres, t.trcrazonsocial ORDER BY COUNT DESC LIMIT 10");
	  			}
	  			else
	  			{
	  				$query = mysqli_query($conn, "SELECT t.trcnombres AS nombre, COUNT(*) AS count FROM btycita AS a, btytercero AS t, btycolaborador AS c WHERE a.clbcodigo=c.clbcodigo AND c.trcdocumento=t.trcdocumento AND c.tdicodigo=t.tdicodigo AND MONTH(a.citfecharegistro) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' GROUP BY t.trcnombres, t.trcrazonsocial ORDER BY COUNT DESC LIMIT 10");
	  			}

	  			$output = array();

	  			if ($query) 
				{

				    foreach ($query as $row) 
				    {
				        $output[] = $row;
				    }
				} 
				else 
				{
				    die("Error: ". mysqli_error($conn));
				}
					$output = utf8_converter($output);

					echo json_encode($output);
  			
  			break;

  		case 'permisos':
  			
  				switch ($_POST['rango']) 
  				{
  					case '1':

  					//AUN EN CONSTRUCCION

  						$query = mysqli_query($conn, "SELECT CONCAT(c.trcnombres, ' (', d.crgnombre, ')') AS nombre, COUNT(*)as count FROM btypermisos_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo WHERE a.slncodigo= '".$_SESSION['PDVslncodigo']."' AND a.perfecha_hasta BETWEEN CURDATE() - INTERVAL DAYOFMONTH(CURDATE()) - 1 DAY AND CURDATE() GROUP BY nombre ORDER BY count DESC LIMIT 10");
  						
  						break;

  					case '2':

  						$query = mysqli_query($conn, "SELECT CONCAT(c.trcnombres, ' (', d.crgnombre, ')') AS nombre, COUNT(*)as count FROM btypermisos_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo WHERE a.slncodigo= '".$_SESSION['PDVslncodigo']."' and MONTH(a.perfecha_desde) = MONTH(CURDATE() - INTERVAL 1 MONTH) GROUP BY nombre ORDER BY count DESC LIMIT 10");
  						
  						break;

  					case '3':
  						
  						$query = mysqli_query($conn, "SELECT CONCAT(c.trcnombres, ' (', d.crgnombre, ')') AS nombre, COUNT(*) AS count FROM btypermisos_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo WHERE a.slncodigo= '".$_SESSION['PDVslncodigo']."' AND YEAR(a.perfecha_desde) = YEAR(CURDATE()) GROUP BY nombre ORDER BY COUNT DESC LIMIT 10");

  						break;


  					
  					default:
  						# code...
  						break;
  				}

  				$output = array();

	  			if ($query) 
				{

				    	foreach ($query as $row) 
				    	{
				        	$output[] = $row;
				    	}
				} 

					$output = utf8_converter($output);

					echo json_encode($output);

  			break;

  		case 'novedades':
  			
  			switch ($_POST['rango']) 
  			{
				case '1':

					$query = mysqli_query($conn, "SELECT CONCAT(ter.trcnombres, ' ', '(', crg.crgnombre,')' )AS nombre, count(*)as count FROM btyasistencia_procesada ap JOIN btycolaborador col ON col.clbcodigo=ap.clbcodigo JOIN btytercero ter ON ter.tdicodigo=col.tdicodigo AND ter.trcdocumento=col.trcdocumento JOIN btycargo crg ON crg.crgcodigo=col.crgcodigo WHERE MONTH(ap.prgfecha) = MONTH(CURDATE()) AND ap.aptcodigo NOT IN(1,5) AND ap.slncodigo = '".$_SESSION['PDVslncodigo']."' GROUP BY nombre ORDER BY count DESC LIMIT 10");
					
					break;

				case '2':

					$query = mysqli_query($conn, "SELECT CONCAT(ter.trcnombres, ' ', '(', crg.crgnombre,')' )AS nombre, count(*)as count FROM btyasistencia_procesada ap JOIN btycolaborador col ON col.clbcodigo=ap.clbcodigo JOIN btytercero ter ON ter.tdicodigo=col.tdicodigo AND ter.trcdocumento=col.trcdocumento JOIN btycargo crg ON crg.crgcodigo=col.crgcodigo WHERE ap.prgfecha between ((CURDATE() - INTERVAL 1 MONTH) - INTERVAL DAYOFMONTH(CURDATE()) - 1 DAY) and LAST_DAY(curdate() - interval 1 month) AND ap.aptcodigo NOT IN(1,5) AND ap.slncodigo = '".$_SESSION['PDVslncodigo']."' GROUP BY nombre ORDER BY count DESC LIMIT 10");
					
					break;

				case '3':
					
					$query = mysqli_query($conn, "SELECT CONCAT(ter.trcnombres, ' ', '(', crg.crgnombre,')' )AS nombre, count(*)as count FROM btyasistencia_procesada ap JOIN btycolaborador col ON col.clbcodigo=ap.clbcodigo JOIN btytercero ter ON ter.tdicodigo=col.tdicodigo AND ter.trcdocumento=col.trcdocumento JOIN btycargo crg ON crg.crgcodigo=col.crgcodigo WHERE YEAR(ap.prgfecha) = YEAR(CURDATE()) AND ap.aptcodigo NOT IN(1,5) AND ap.slncodigo = '".$_SESSION['PDVslncodigo']."' GROUP BY nombre ORDER BY count DESC LIMIT 10");

					break;
				
				default:
					# code...
					break;
  			}

  				$output = array();

	  			if ($query) 
				{

				    	foreach ($query as $row) 
				    	{
				        	$output[] = $row;
				    	}
				} 

					$output = utf8_converter($output);

					echo json_encode($output);

  			break;

  			break;

  		case 'aniversario':


  				if ($_POST['rango1'] == 1) 
  				{
  					$consultaSQL =  "SELECT IFNULL(MONTH(a.clbfechanacimiento), null) AS mes, COUNT(*)AS count FROM btycolaborador a JOIN btytercero b ON a.trcdocumento=b.trcdocumento WHERE MONTH(a.clbfechanacimiento) <> '' GROUP BY mes ORDER BY mes ";   					
  				}
  				else
  				{
  					$consultaSQL =  "SELECT IFNULL(MONTH(a.clifechanacimiento), null) AS mes, COUNT(*)AS count FROM btycliente a JOIN btytercero b ON a.trcdocumento=b.trcdocumento WHERE MONTH(a.clifechanacimiento) <> '' GROUP BY mes ORDER BY mes "; 
  				}


				$query = mysqli_query($conn, $consultaSQL);
				
			
				$output = array();

				if ($query) 
				{

				    	foreach ($query as $row) 
				    	{
				        	$output[] = $row;
			    		}
				} 

				$output = utf8_converter($output);

				echo json_encode($output);

  			break;
  		
  		default:
  			# code...
  			break;
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
	

  	mysqli_close($conn);

?>