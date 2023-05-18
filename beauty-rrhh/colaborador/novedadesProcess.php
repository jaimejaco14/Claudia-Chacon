<?php 
	include '../../cnx_data.php';
	include("../funciones.php");


	
	switch ($_POST['opcion']) 
	{
		case 'colaboradores':

		//print_r($_POST);

		if ($_POST['horad'] == "00:00" AND $_POST['horah'] == "23:59") 
		{

			$d = "SELECT DISTINCT c.clbcodigo,terc.trcrazonsocial, cr.crgnombre FROM btyprogramacion_colaboradores AS p, btytipo_programacion AS tp, btyturno AS t, btycolaborador AS c, btycargo AS cr, btytercero AS terc WHERE c.clbcodigo=p.clbcodigo AND c.crgcodigo=cr.crgcodigo AND t.trncodigo=p.trncodigo AND tp.tprcodigo=p.tprcodigo AND tp.tprlabora='1' AND p.slncodigo='".$_POST['salon']."' AND terc.trcdocumento=c.trcdocumento AND p.prgfecha BETWEEN '".$_POST['fecha']."' AND '".$_POST['fechah']."'   ORDER BY trcrazonsocial";

			//echo $d;
				$QueryColaboradores = mysqli_query($conn, $d)or die(mysqli_error($conn));

				
				if (mysqli_num_rows($QueryColaboradores) > 0) 
				{
					$jsonCol = array();
					$validar = array();

					while ($row = mysqli_fetch_array($QueryColaboradores)) 
					{
						$e = "SELECT a.clbcodigo, c.trcrazonsocial, b.nvpfechadesde, b.nvphoradesde, b.nvphorahasta, tipo.tnvnombre FROM btynovedades_programacion_detalle a JOIN btynovedades_programacion b ON a.nvpcodigo=b.nvpcodigo JOIN btycolaborador d ON a.clbcodigo=d.clbcodigo JOIN btytercero c ON c.trcdocumento=d.trcdocumento JOIN btytipo_novedad_programacion tipo ON tipo.tnvcodigo=b.tnvcodigo WHERE b.nvpfechadesde = '".$_POST['fecha']."' AND ((ADDTIME('".$_POST['horad']."', '00:01') BETWEEN b.nvphoradesde AND b.nvphorahasta) OR (SUBTIME('".$_POST['horah']."', '00:00:01') BETWEEN b.nvphoradesde AND b.nvphorahasta)) AND a.clbcodigo = '".$row['clbcodigo']."' ORDER BY trcrazonsocial";

						//echo $e;

						$QueryValidar = mysqli_query($conn, $e)or die(mysqli_error($conn));

						if (mysqli_num_rows($QueryValidar) > 0) 
						{
							$fila = mysqli_fetch_array($QueryValidar);

								$jsonCol[] = array(
								'id' 		=> $fila['clbcodigo'],
								'nombre' 	=> $fila['trcrazonsocial'],
								'nombre2' 	=> $row['trcrazonsocial'],
								'cargo' 	=> $row['crgnombre'],
								'tipopro' 	=> $fila['tnvnombre'],
							);
													
							
						}
						else
						{	
							$jsonCol[] = array(
								'id' 		=> $row['clbcodigo'],
								'nombre' 	=> $row['trcrazonsocial'],
								'cargo' 	=> $row['crgnombre']
							);
						}

					}
						$array= utf8_converter($jsonCol);

						echo json_encode(array("res" => "full", "json" => $array));
				}
				else
				{
					    $array= utf8_converter($jsonCol);

						echo json_encode(array("res" => "full", "json" => $array));

				}
		}
		else
		{


				//$g =  "SELECT c.clbcodigo,terc.trcrazonsocial, cr.crgnombre, t.trndesde,t.trnhasta, t.trnnombre FROM btyprogramacion_colaboradores AS p, btytipo_programacion AS tp, btyturno AS t, btycolaborador AS c, btycargo AS cr, btytercero AS terc WHERE c.clbcodigo=p.clbcodigo AND c.crgcodigo=cr.crgcodigo AND t.trncodigo=p.trncodigo AND tp.tprcodigo=p.tprcodigo AND tp.tprlabora='1' AND p.slncodigo='".$_POST['salon']."' AND terc.trcdocumento=c.trcdocumento AND p.prgfecha= '".$_POST['fecha']."'  AND (('".$_POST['horad']."' BETWEEN t.trndesde AND t.trnhasta) OR ('".$_POST['horah']."' BETWEEN t.trndesde AND t.trnhasta))ORDER BY trcrazonsocial";

				$g =  "SELECT DISTINCT c.clbcodigo,terc.trcrazonsocial, cr.crgnombre FROM btyprogramacion_colaboradores AS p, btytipo_programacion AS tp, btyturno AS t, btycolaborador AS c, btycargo AS cr, btytercero AS terc WHERE c.clbcodigo=p.clbcodigo AND c.crgcodigo=cr.crgcodigo AND t.trncodigo=p.trncodigo AND tp.tprcodigo=p.tprcodigo AND tp.tprlabora='1' AND p.slncodigo= '".$_POST['salon']."' AND terc.trcdocumento=c.trcdocumento AND p.prgfecha BETWEEN '".$_POST['fecha']."' AND '".$_POST['fechah']."' AND (('".$_POST['horad']."' BETWEEN t.trndesde AND t.trnhasta) OR ('".$_POST['horah']."' BETWEEN t.trndesde AND t.trnhasta)) ORDER BY trcrazonsocial";


				
				$QueryColaboradores = mysqli_query($conn,$g)or die(mysqli_error($conn));

				
				if (mysqli_num_rows($QueryColaboradores) > 0) 
				{
					$jsonCol = array();
					$validar = array();

					while ($row = mysqli_fetch_array($QueryColaboradores)) 
					{
						$e = "SELECT a.clbcodigo, c.trcrazonsocial, b.nvpfechadesde, b.nvphoradesde, b.nvphorahasta, tipo.tnvnombre FROM btynovedades_programacion_detalle a JOIN btynovedades_programacion b ON a.nvpcodigo=b.nvpcodigo JOIN btycolaborador d ON a.clbcodigo=d.clbcodigo JOIN btytercero c ON c.trcdocumento=d.trcdocumento AND c.tdicodigo=d.tdicodigo JOIN btytipo_novedad_programacion tipo ON tipo.tnvcodigo=b.tnvcodigo WHERE b.nvpfechadesde = '".$_POST['fecha']."' AND ((ADDTIME('".$_POST['horad']."', '00:01') BETWEEN b.nvphoradesde AND b.nvphorahasta) OR (SUBTIME('".$_POST['horah']."', '00:00:01') BETWEEN b.nvphoradesde AND b.nvphorahasta)) AND a.clbcodigo = '".$row['clbcodigo']."' ORDER BY trcrazonsocial";


						$QueryValidar = mysqli_query($conn, $e)or die(mysqli_error($conn));
						
						$fila = mysqli_fetch_array($QueryValidar);	

						if (mysqli_num_rows($QueryValidar) > 0) 
						{					
							$jsonCol[] = array(
								'id' 		=> $row['clbcodigo'],
								'nombre' 	=> $row['trcrazonsocial'],
								'cargo' 	=> $row['crgnombre'],
								'nombre2' 	=> $fila['trcrazonsocial'],
								'tipopro' 	=> $fila['tnvnombre'],
							);
						}
						else
						{
							$jsonCol[] = array(
								'id' 		=> $row['clbcodigo'],
								'nombre' 	=> $row['trcrazonsocial'],
								'cargo' 	=> $row['crgnombre']

							);

						}
					}
							$array= utf8_converter($jsonCol);

							echo json_encode(array("res" => "full", "json" => $array));
				}
				else
				{
					echo json_encode(array("res" => "nodata"));
				}

				
		}

				

			break;

		case 'counter':
			 $QueryNovedad = mysqli_query($conn, "SELECT MAX(a.nvpcodigo) FROM btynovedades_programacion a");
                $row = mysqli_fetch_array($QueryNovedad);
                $max = $row[0]+1;
                echo "Novedad N° $max";
			break;


		case 'buscar':
			
				//$QueryBusqueda = mysqli_query($conn, "SELECT a.nvpcodigo, a.tnvcodigo, a.nvpfecharegistro, TIME_FORMAT(a.nvphoraregistro, '%H:%i')as nvphoraregistro, a.nvpfechadesde, a.nvpfechahasta, a.nvpobservacion, CASE WHEN a.nvphoradesde = '00:00:00' AND a.nvphorahasta = '23:59:00' THEN '<center>TODO EL DIA</center>' ELSE CONCAT('<b>DE:</b> ', TIME_FORMAT(a.nvphoradesde, '%H:%i'), ' <b>A:</b> ', TIME_FORMAT(a.nvphorahasta, '%H:%i')) END AS rango, a.usucodigo, a.slncodigo, c.slnnombre, d.trcrazonsocial, e.tnvnombre FROM btynovedades_programacion a JOIN btyusuario b ON a.usucodigo=b.usucodigo JOIN btysalon c ON a.slncodigo=c.slncodigo JOIN btytercero d ON d.trcdocumento=b.trcdocumento JOIN btytipo_novedad_programacion e ON e.tnvcodigo=a.tnvcodigo WHERE a.nvpfechadesde >= '".$_POST['fecha']."' AND a.nvpfechadesde <= '".$_POST['fechaHasta']."' AND a.slncodigo = '".$_POST['salon']."' AND a.nvpestado = 'REGISTRADO'");


				$QueryBusqueda = mysqli_query($conn, "SELECT a.nvpcodigo, a.tnvcodigo, a.nvpfecharegistro, TIME_FORMAT(a.nvphoraregistro, '%H:%i') AS nvphoraregistro, a.nvpfechadesde, a.nvpfechahasta, a.nvpobservacion, CASE WHEN a.nvphoradesde = '00:00:00' AND a.nvphorahasta = '23:59:00' THEN '<center>TODO EL DIA</center>' ELSE CONCAT('<b>DE:</b> ', TIME_FORMAT(a.nvphoradesde, '%H:%i'), ' <b>A:</b> ', TIME_FORMAT(a.nvphorahasta, '%H:%i')) END AS rango, a.usucodigo, a.slncodigo, c.slnnombre, d.trcrazonsocial, e.tnvnombre, a.nvpestado FROM btynovedades_programacion a JOIN btyusuario b ON a.usucodigo=b.usucodigo JOIN btysalon c ON a.slncodigo=c.slncodigo JOIN btytercero d ON d.trcdocumento=b.trcdocumento JOIN btytipo_novedad_programacion e ON e.tnvcodigo=a.tnvcodigo WHERE a.nvpfechadesde >= '".$_POST['fecha']."' AND a.nvpfechadesde <= '".$_POST['fechaHasta']."' AND a.slncodigo = '".$_POST['salon']."' AND a.nvpestado IN('REGISTRADO', 'MODIFICADO') ");

				if (mysqli_num_rows($QueryBusqueda) > 0) 
				{
					$jsonBuscar = array();

					while ($row = mysqli_fetch_array($QueryBusqueda)) 
					{
						$jsonBuscar[] = array(
							'codnovedad' 	=> $row['nvpcodigo'],
							'fechareg'  	=> $row['nvpfecharegistro'],
							'horareg'   	=> $row['nvphoraregistro'],
							'fecha'     	=> $row['nvpfechadesde'],
							'fechah'     	=> $row['nvpfechahasta'],
							'observac'  	=> $row['nvpobservacion'],
							'rango'  	      => $row['rango'],
							'salon'     	=> $row['slnnombre'],
							'usuadmin'  	=> $row['trcrazonsocial'],
							'novedad'         => $row['tnvnombre'],
							'estado'          => $row['nvpestado']
						);
					}

				

						$array= utf8_converter($jsonBuscar);

						echo json_encode(array("res" => "full", "json" => $array));
				}
				else
				{
					echo json_encode(array("res" => "empty"));
				}

			break;

		case 'vernovedad':
			
			$QueryVernovedad = mysqli_query($conn, "SELECT p.nvpcodigo, det.nvpfecharegistro, TIME_FORMAT(det.nvphoraregistro, '%H:%i') AS nvphoraregistro, det.nvpfechadesde, det.nvpfechahasta, det.nvpobservacion, p.clbcodigo, det.usucodigo, t2.trcrazonsocial AS usuadmin, t.trcrazonsocial AS col, CASE WHEN det.nvphoradesde = '00:00:00' AND det.nvphorahasta = '23:59:00' THEN 'TODO EL DIA' ELSE CONCAT('DE ', TIME_FORMAT(det.nvphoradesde, '%H:%i'), ' A ', TIME_FORMAT(det.nvphorahasta, '%H:%i')) END AS rango, sln.slnnombre, crg.crgnombre, tipo.tnvnombre FROM btynovedades_programacion_detalle AS p, btynovedades_programacion AS det, btycolaborador AS c, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2, btysalon AS sln, btycargo AS crg, btytipo_novedad_programacion AS tipo WHERE p.nvpcodigo=det.nvpcodigo AND det.usucodigo=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND u1.usucodigo=det.usucodigo AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND tipo.tnvcodigo=det.tnvcodigo AND sln.slncodigo=det.slncodigo AND crg.crgcodigo=c.crgcodigo AND det.nvpcodigo = '".$_POST['novedad']."' ORDER BY p.nvpcodigo DESC, col ASC");


			if (mysqli_num_rows($QueryVernovedad) > 0) 
				{
					$jsonBuscar = array();

					while ($row = mysqli_fetch_array($QueryVernovedad)) 
					{
						$jsonBuscar[] = array(
							'codnovedad' 	=> $row['nvpcodigo'],
							'fechareg'  	=> $row['nvpfecharegistro'],
							'horareg'   	=> $row['nvphoraregistro'],
							'fecha'     	=> $row['nvpfechadesde'],
							'fechah'     	=> $row['nvpfechahasta'],
							'observac'  	=> $row['nvpobservacion'],
							'rango'  	      => $row['rango'],
							'salon'     	=> $row['slnnombre'],
							'usuadmin'  	=> $row['usuadmin'],
							'colaborador'     => $row['col'],
							'cargo'           => $row['crgnombre'],
							'tipo'            => $row['tnvnombre'],
						);
					}

				

						$array= utf8_converter($jsonBuscar);

						echo json_encode(array("res" => "full", "json" => $array));
				}
				else
				{
					echo json_encode(array("res" => "empty"));
				}



			break;


		case 'eliminar':
			 
			$QueryEliminar = mysqli_query($conn, "DELETE FROM btynovedades_programacion WHERE nvpcodigo = '".$_POST['codNovedad']."' ");

			if ($QueryEliminar) 
			{
				echo 1;
			}


			break;

		case 'editar':
			
			$QueryEditar = mysqli_query($conn, "SELECT p.nvpcodigo, p.tnvcodigo, p.nvpfecharegistro, p.nvphoraregistro, p.nvpfechadesde, p.nvpfechahasta, p.nvpobservacion, TIME_FORMAT(p.nvphoradesde, '%H:%i')AS nvphoradesde, TIME_FORMAT(p.nvphorahasta, '%H:%i') AS nvphorahasta, t1.trcrazonsocial as usuario, t.trcrazonsocial as colaborador, tipo.tnvnombre, sln.slnnombre, sln.slncodigo, crg.crgnombre, f.clbcodigo FROM btynovedades_programacion p, btynovedades_programacion_detalle as f, btycolaborador AS c, btytercero AS t1, btytercero AS t, btyusuario AS u1, btytipo_novedad_programacion AS tipo, btysalon as sln, btycargo as crg  WHERE p.nvpcodigo=f.nvpcodigo AND p.usucodigo=u1.usucodigo AND u1.tdicodigo=t1.tdicodigo AND u1.trcdocumento=t1.trcdocumento AND f.clbcodigo=c.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND c.clbcodigo=f.clbcodigo AND tipo.tnvcodigo=p.tnvcodigo AND crg.crgcodigo=c.crgcodigo AND sln.slncodigo=p.slncodigo AND p.nvpcodigo = '".$_POST['novedad']."' ORDER BY t.trcrazonsocial");

				$jsonEditar = array();

			   	if (mysqli_num_rows($QueryEditar) > 0) 
			   	{
			   		while ($row = mysqli_fetch_array($QueryEditar)) 
			   		{
			   			$jsonEditar[] = array(
			   				'idnovedad' 	=> $row['nvpcodigo'],
			   				'idtiponovedad'   => $row['tnvcodigo'],
			   				'fecha'           => $row['nvpfechadesde'],
			   				'fechaH'          => $row['nvpfechahasta'],
			   				'fechareg' 	      => $row['nvpfecharegistro'],
			   				'horareg' 	      => $row['nvphoraregistro'],
			   				'observac' 	      => $row['nvpobservacion'],
			   				'desde' 	      => $row['nvphoradesde'],
			   				'hasta' 	      => $row['nvphorahasta'],
			   				'usuario' 	      => $row['usuario'],
			   				'colaborador' 	=> $row['colaborador'],
			   				'tipo'      	=> $row['tnvnombre'],
			   				'salon'      	=> $row['slnnombre'],
			   				'cargo'      	=> $row['crgnombre'],
			   				'codsalon'        => $row['slncodigo'],
			   				'idcol'           => $row['clbcodigo'],
			   			);
			   		}

			   		 $QuerySln = mysqli_query($conn, "SELECT a.tnvcodigo, a.tnvnombre FROM btytipo_novedad_programacion a WHERE a.aptestado = 1 ORDER BY a.tnvnombre");

			   		  $arrayTipo = array();

			   		while ($row = mysqli_fetch_array($QuerySln)) 
                    		{
                       			$arrayTipo[] = array("cod" => $row['tnvcodigo'], "nom" => $row['tnvnombre']);   
                    		}

			   		$array= utf8_converter($jsonEditar);
			   		$array2= utf8_converter($arrayTipo);

					echo json_encode(array("res" => "full", "json" => $array, "tipo" => $array2));
			   	}
			   	else
			   	{
			   		echo json_encode(array("res" => "empty"));
			   	}


			break;

		case 'individual':

			if (trim($_POST['horad']) == "00:00:00" AND trim($_POST['horah']) == "23:59:00") 
			{

				//$e = "SELECT b.nvpcodigo, a.clbcodigo, c.trcrazonsocial, b.nvpfechadesde, b.nvphoradesde, b.nvphorahasta, tipo.tnvnombre FROM btynovedades_programacion_detalle a JOIN btynovedades_programacion b ON a.nvpcodigo=b.nvpcodigo JOIN btycolaborador d ON a.clbcodigo=d.clbcodigo JOIN btytercero c ON c.trcdocumento=d.trcdocumento JOIN btytipo_novedad_programacion tipo ON tipo.tnvcodigo=b.tnvcodigo WHERE b.nvpfechadesde = '".$_POST['fecha']."' AND a.clbcodigo = '".$_POST['col']."' ORDER BY trcrazonsocial";

				if ($_POST['fecha'] == $_POST['fechah']) 
				{
					
					$e = "SELECT b.nvpcodigo, a.clbcodigo, c.trcrazonsocial, b.nvpfechadesde, b.nvphoradesde, b.nvphorahasta, tipo.tnvnombre FROM  btynovedades_programacion_detalle a JOIN btynovedades_programacion b ON a.nvpcodigo=b.nvpcodigo JOIN btycolaborador d ON a.clbcodigo=d.clbcodigo JOIN btytercero c ON c.trcdocumento=d.trcdocumento JOIN btytipo_novedad_programacion tipo ON tipo.tnvcodigo=b.tnvcodigo WHERE b.nvpfechadesde = '".$_POST['fecha']."' AND NOT b.nvphoradesde = '00:00:00' AND a.clbcodigo = '".$_POST['col']."' ORDER BY  trcrazonsocial";
				}
				else
				{
					$e = "SELECT b.nvpcodigo, a.clbcodigo, c.trcrazonsocial, b.nvpfechadesde, b.nvphoradesde, b.nvphorahasta, tipo.tnvnombre FROM  btynovedades_programacion_detalle a JOIN btynovedades_programacion b ON a.nvpcodigo=b.nvpcodigo JOIN btycolaborador d ON a.clbcodigo=d.clbcodigo JOIN btytercero c ON c.trcdocumento=d.trcdocumento JOIN btytipo_novedad_programacion tipo ON tipo.tnvcodigo=b.tnvcodigo WHERE b.nvpfechadesde BETWEEN '".$_POST['fecha']."' AND '".$_POST['fechah']."' AND a.clbcodigo = '".$_POST['col']."' ORDER BY  trcrazonsocial";
				}



				//echo $e;

					$QueryValidar = mysqli_query($conn, $e)or die(mysqli_error($conn));

					if (mysqli_num_rows($QueryValidar) > 0) 
					{
						$fetch = mysqli_fetch_array($QueryValidar);

						$v = "UPDATE btynovedades_programacion SET nvpestado = 'ELIMINADO' WHERE nvpcodigo = '".$fetch['nvpcodigo']."' ";

						//echo $v;

						$update = mysqli_query($conn, $v);

						if ($update) 
						{
							$cons = mysqli_query($conn, "SELECT MAX(nvpcodigo) FROM btynovedades_programacion");
							$r = mysqli_fetch_array($cons);
							$max = $r[0]+1;
						
							$QueryNov = mysqli_query($conn, "INSERT INTO btynovedades_programacion (nvpcodigo, tnvcodigo, nvpfecharegistro, nvphoraregistro, nvpfechadesde, nvpfechahasta, nvpobservacion, nvphoradesde, nvphorahasta, usucodigo, slncodigo, nvpestado) VALUES($max, '".$_POST['tipo']."',  CURDATE(), CURTIME(), '".$_POST['fecha']."', '".$_POST['fechah']."', '".utf8_decode(strtoupper($_POST['obs']))."', '".$_POST['horad']."','".$_POST['horah']."', '".$_SESSION['codigoUsuario']."', '".$_POST['salon']."', 'REGISTRADO')");

								if ($QueryNov) 
								{
								 	$sql = mysqli_query($conn, "INSERT INTO btynovedades_programacion_detalle (nvpcodigo, clbcodigo) VALUES($max, '".$_POST['col']."')")or die(mysqli_error($conn));

								 	if($sql)
								 	{
								 		echo json_encode(array("res" => "1"));
								 	}				
								}
						}



						
					}
					else
					{


						$cons = mysqli_query($conn, "SELECT MAX(nvpcodigo) FROM btynovedades_programacion");
						$r = mysqli_fetch_array($cons);
						$max = $r[0]+1;
						
						$QueryNov = mysqli_query($conn, "INSERT INTO btynovedades_programacion (nvpcodigo, tnvcodigo, nvpfecharegistro, nvphoraregistro, nvpfechadesde, nvpfechahasta, nvpobservacion, nvphoradesde, nvphorahasta, usucodigo, slncodigo, nvpestado) VALUES($max, '".$_POST['tipo']."',  CURDATE(), CURTIME(), '".$_POST['fecha']."', '".$_POST['fechah']."', '".utf8_decode(strtoupper($_POST['obs']))."', '".$_POST['horad']."','".$_POST['horah']."', '".$_SESSION['codigoUsuario']."', '".$_POST['salon']."', 'REGISTRADO')");

						if ($QueryNov) 
						{
						 	$sql = mysqli_query($conn, "INSERT INTO btynovedades_programacion_detalle (nvpcodigo, clbcodigo) VALUES($max, '".$_POST['col']."')")or die(mysqli_error($conn));

						 	if($sql)
						 	{
						 		echo json_encode(array("res" => "1"));
						 	}				
						}
					}

			}
			else
			{
				$e = "SELECT a.clbcodigo, c.trcrazonsocial, b.nvpfechadesde, b.nvphoradesde, b.nvphorahasta, tipo.tnvnombre FROM btynovedades_programacion_detalle a JOIN btynovedades_programacion b ON a.nvpcodigo=b.nvpcodigo JOIN btycolaborador d ON a.clbcodigo=d.clbcodigo JOIN btytercero c ON c.trcdocumento=d.trcdocumento JOIN btytipo_novedad_programacion tipo ON tipo.tnvcodigo=b.tnvcodigo WHERE b.nvpfechadesde BETWEEN '".$_POST['fecha']."' AND '".$_POST['fechah']."' AND ((ADDTIME('".$_POST['horad']."', '00:01') BETWEEN b.nvphoradesde AND b.nvphorahasta) OR (SUBTIME('".$_POST['horah']."', '00:00:01') BETWEEN b.nvphoradesde AND b.nvphorahasta)) AND a.clbcodigo = '".$_POST['col']."' ORDER BY trcrazonsocial";

					$QueryValidar = mysqli_query($conn, $e)or die(mysqli_error($conn));

					if (mysqli_num_rows($QueryValidar) > 0) 
					{
						echo json_encode(array("res" => "2"));//YA TIENE UNA NOVEDAD EN EL RANGO DE HORAS							
						
					}
					else
					{	
						$cons = mysqli_query($conn, "SELECT MAX(nvpcodigo) FROM btynovedades_programacion");
							$r = mysqli_fetch_array($cons);
							$max = $r[0]+1;
							
							$QueryNov = mysqli_query($conn, "INSERT INTO btynovedades_programacion (nvpcodigo, tnvcodigo, nvpfecharegistro, nvphoraregistro, nvpfechadesde, nvpfechahasta, nvpobservacion, nvphoradesde, nvphorahasta, usucodigo, slncodigo, nvpestado) VALUES($max, '".$_POST['tipo']."',  CURDATE(), CURTIME(), '".$_POST['fecha']."', '".$_POST['fechah']."', '".utf8_decode(strtoupper($_POST['obs']))."', '".$_POST['horad']."','".$_POST['horah']."', '".$_SESSION['codigoUsuario']."', '".$_POST['salon']."', 'REGISTRADO')");

							if ($QueryNov) 
							{
							 	$sql = mysqli_query($conn, "INSERT INTO btynovedades_programacion_detalle (nvpcodigo, clbcodigo) VALUES($max, '".$_POST['col']."')")or die(mysqli_error($conn));

							 	if($sql)
							 	{
							 		echo json_encode(array("res" => "1"));
							 	}				
							}
					}
			}





			break;
		
		default:
			break;
	}


	mysqli_close($conn);
 ?>

