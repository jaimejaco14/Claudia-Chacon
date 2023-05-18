<?php 
	include '../../cnx_data.php';
	include("../funciones.php");

	

		$QueryColaboradores = mysqli_query($conn, "SELECT c.clbcodigo,terc.trcrazonsocial, cr.crgnombre, t.trndesde,t.trnhasta, t.trnnombre FROM btyprogramacion_colaboradores AS p, btytipo_programacion AS tp, btyturno AS t, btycolaborador AS c, btycargo AS cr, btytercero AS terc WHERE c.clbcodigo=p.clbcodigo AND c.crgcodigo=cr.crgcodigo AND t.trncodigo=p.trncodigo AND tp.tprcodigo=p.tprcodigo AND tp.tprlabora='1' AND p.slncodigo='".$_POST['salon']."' AND terc.trcdocumento=c.trcdocumento AND p.prgfecha= '".$_POST['fecha']."' ORDER BY trcrazonsocial")or die(mysqli_error($conn));

			$jsonCol = array();
				
				if (mysqli_num_rows($QueryColaboradores) > 0) 
				{
					$jsonCol = array();
					$validar = array();

					while ($row = mysqli_fetch_array($QueryColaboradores)) 
					{
						$e = "SELECT a.clbcodigo, c.trcrazonsocial, b.nvpfecha, b.nvphoradesde, b.nvphorahasta FROM btynovedades_programacion_detalle a JOIN btynovedades_programacion b ON a.nvpcodigo=b.nvpcodigo JOIN btycolaborador d ON a.clbcodigo=d.clbcodigo JOIN btytercero c ON c.trcdocumento=d.trcdocumento WHERE b.nvpfecha = '".$_POST['fecha']."' AND b.nvphoradesde = '00:00' AND b.nvphorahasta = '23:59' AND a.clbcodigo = '".$row['clbcodigo']."' ORDER BY trcrazonsocial";

						$QueryValidar = mysqli_query($conn, $e)or die(mysqli_error($conn));

						if (mysqli_num_rows($QueryValidar) > 0) 
						{
							
							/*$fila = mysqli_fetch_array($QueryValidar);
							$jsonCol[] = array(
								'id' 		=> $row['clbcodigo'],
								'nombre' 	=> $row['trcrazonsocial'],
								'cargo' 	=> $row['crgnombre'],
								'nombre2'   => $fila['trcrazonsocial']
							);*/
						}
						else
						{
							$fila = mysqli_fetch_array($QueryValidar);
							$jsonCol[] = array(
								'id' 		=> $row['clbcodigo'],
								'nombre' 	=> $row['trcrazonsocial'],
								'cargo' 	=> $row['crgnombre'],
								'nombre2'   => $fila['trcrazonsocial']
							);
						}
						

					}

					$array= utf8_converter($jsonCol);

					echo json_encode(array("res" => "full", "json" => $array));
						
				}
				else
				{
					echo json_encode(array("res" => "empty"));
				}
				

?>


