<?php 
	include("../../cnx_data.php");
	include '../php/funciones.php';


	switch ($_POST['opcion']) 
	{
		case 'load':

			$sql = mysqli_query($conn, "SELECT a.clbcodigo, c.crgnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btycargo c ON c.crgcodigo=b.crgcodigo WHERE a.prgfecha = '".$_POST['fecha']."' AND a.slncodigo = '".$_POST['slncodigo']."' AND a.tprcodigo = 1 ORDER BY c.crgnombre");


			$array  = array();
			$array2 = array();

				$conteo = 0;
				while ($row = mysqli_fetch_array($sql)) 
				{

					$query = mysqli_query($conn, "SELECT a.clbcodigo, c.trcrazonsocial, d.crgnombre, CONCAT(trn.trnnombre, ' ', TIME_FORMAT(trn.trndesde, '%H:%i'), ' ', TIME_FORMAT(trn.trnhasta, '%H:%i'))AS turno, ti.tprnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btyturno trn ON trn.trncodigo=a.trncodigo JOIN btytipo_programacion ti ON ti.tprcodigo=a.tprcodigo WHERE a.prgfecha = '".$_POST['fecha']."' AND a.slncodigo = '".$_POST['slncodigo']."' AND a.tprcodigo = 1 AND a.clbcodigo = '".$row['clbcodigo']."' AND a.clbcodigo NOT IN (SELECT per.clbcodigo FROM btypermisos_colaboradores per JOIN btycolaborador b ON b.clbcodigo=per.clbcodigo JOIN btytercero t ON t.tdicodigo=b.tdicodigo AND t.trcdocumento=b.trcdocumento JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo WHERE per.perfecha_desde = '".$_POST['fecha']."' AND per.perestado_tramite IN('AUTORIZADO') AND per.clbcodigo = '".$row['clbcodigo']."' AND per.slncodigo = '".$_POST['slncodigo']."' )  GROUP BY a.clbcodigo, trn.trnnombre,turno,ti.tprnombre ORDER BY c.trcrazonsocial, d.crgnombre");

						while($row2 = mysqli_fetch_array($query))
						{							
							$array2[] = array('clbcodigo' => $row2['clbcodigo'], 'trcrazonsocial' => $row2['trcrazonsocial'], 'cargo' => $row2['crgnombre'], 'turno' => $row2['turno'], 'tipo' => $row2['tprnombre'], );
							$array2 = utf8_converter($array2);
							$conteo = $conteo +1;							
						}

				}						
						echo json_encode(array("res" => "full", "json" => $array2, "conteo" => $conteo));			

			break;
		
		default:
			# code...
			break;
	}

	mysqli_error($conn);
?>