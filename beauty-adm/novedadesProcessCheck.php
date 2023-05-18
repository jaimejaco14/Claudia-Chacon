<?php 
	include '../cnx_data.php';


	switch ($_POST['opcion']) 
	{
		case 'colaboradores':

		if ($_POST['horad'] == "00:00" AND $_POST['horah'] == "23:59") 
		{
				$QueryColaboradores1 = mysqli_query($conn, "SELECT c.clbcodigo,terc.trcrazonsocial, cr.crgnombre, t.trndesde,t.trnhasta, t.trnnombre FROM btyprogramacion_colaboradores AS p, btytipo_programacion AS tp, btyturno AS t, btycolaborador AS c, btycargo AS cr, btytercero AS terc WHERE c.clbcodigo=p.clbcodigo AND c.crgcodigo=cr.crgcodigo AND cr.crgincluircolaturnos='1' AND t.trncodigo=p.trncodigo AND tp.tprcodigo=p.tprcodigo AND tp.tprlabora='1' AND p.slncodigo='".$_POST['salon']."' AND terc.trcdocumento=c.trcdocumento AND p.prgfecha= '".$_POST['fecha']."' ORDER BY trcrazonsocial");
		}
		else
		{


			
				$QueryColaboradores = mysqli_query($conn, "SELECT c.clbcodigo,terc.trcrazonsocial, cr.crgnombre, t.trndesde,t.trnhasta, t.trnnombre FROM btyprogramacion_colaboradores AS p, btytipo_programacion AS tp, btyturno AS t, btycolaborador AS c, btycargo AS cr, btytercero AS terc WHERE c.clbcodigo=p.clbcodigo AND c.crgcodigo=cr.crgcodigo AND cr.crgincluircolaturnos='1' AND t.trncodigo=p.trncodigo AND tp.tprcodigo=p.tprcodigo AND tp.tprlabora='1' AND p.slncodigo='".$_POST['salon']."' AND terc.trcdocumento=c.trcdocumento AND p.prgfecha= '".$_POST['fecha']."' AND '".$_POST['horad']."'  BETWEEN t.trndesde AND t.trnhasta AND '".$_POST['horah']."' BETWEEN t.trndesde AND t.trnhasta ORDER BY trcrazonsocial")or die(mysqli_error($conn));

				
		}

				if (mysqli_num_rows($QueryColaboradores) > 0) 
				{
					$jsonCol = array();
					$validar = array();

					while ($row = mysqli_fetch_array($QueryColaboradores)) 
					{
						$e = "SELECT a.clbcodigo, c.trcrazonsocial, b.nvpfecha, b.nvphoradesde FROM btynovedades_programacion_detalle a JOIN btynovedades_programacion b ON a.nvpcodigo=b.nvpcodigo JOIN btycolaborador d ON a.clbcodigo=d.clbcodigo JOIN btytercero c ON c.trcdocumento=d.trcdocumento WHERE b.nvpfecha = CURDATE() AND '".$_POST['horad']."'  BETWEEN b.nvphoradesde AND b.nvphorahasta AND a.clbcodigo = '".$row['clbcodigo']."' ";

						$QueryValidar = mysqli_query($conn, $e)or die(mysqli_error($conn));

						if (mysqli_num_rows($QueryValidar) > 0) 
						{
							$fila = mysqli_fetch_array($QueryValidar);
							

						}


						$jsonCol[] = array(
							'id' 		=> $row['clbcodigo'],
							'nombre' 	=> $row['trcrazonsocial'],
							'cargo' 	=> $row['crgnombre'],
							'clbcod'    => $fila['clbcodigo'],
							'nombre2'   => $fila['trcrazonsocial'],
						);
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

						$array= utf8_converter($jsonCol);



						echo json_encode(array("res" => "full", "json" => $array));
				}
				else
				{
					echo json_encode(array("res" => "empty"));
				}

			break;

		case 'counter':
			 $QueryNovedad = mysqli_query($conn, "SELECT MAX(a.nvpcodigo) FROM btynovedades_programacion a");
                $row = mysqli_fetch_array($QueryNovedad);
                $max = $row[0]+1;
                echo "Novedad N° $max";
			break;
		
		default:
			# code...
			break;
	}


	mysqli_close($conn);
 ?>

