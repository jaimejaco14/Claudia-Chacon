<?php 
	session_start();
	include("../../../cnx_data.php");

	$codSalon        = $_SESSION['PDVslncodigo'];
	$user            = $_SESSION['PDVcodigoUsuario'];
	$comment         = utf8_encode($_POST['comment']);

	$DocColaborador = mysqli_query($conn, "SELECT b.clbcodigo FROM btytercero a JOIN btycolaborador b ON a.trcdocumento=b.trcdocumento AND a.tdicodigo=b.tdicodigo WHERE a.trcdocumento = '".$_POST['trcdocumento']."'");

	$cod = mysqli_fetch_array($DocColaborador);

	$cod_colaborador = $cod[0];



	$validarProg = mysqli_query($conn, "SELECT b.clbcodigo FROM btyprogramacion_colaboradores b WHERE b.prgfecha = CURDATE() AND b.clbcodigo = '".$cod_colaborador."' AND b.slncodigo = '".$codSalon."' ");

	if (mysqli_num_rows($validarProg) > 0) 
	{



		$con = mysqli_query($conn,  "SELECT colhorasalida, coldisponible,clbcodigo FROM btycola_atencion WHERE clbcodigo = $cod_colaborador AND slncodigo = $codSalon AND tuafechai = CURDATE()");

		if (mysqli_num_rows($con) > 0) 
		{
			
			while ($row = mysqli_fetch_array($con)) 
			{
				if ($row['coldisponible'] == 0) 
				{
					echo json_encode(array("res" => 6));//se encuentra ocupado
				}
				else
				{
					if ($row[0] == null || $row[0] == "null") 
					{
						
						echo json_encode(array("res" => 4));											
					}
					else
					{
						echo json_encode(array("res" => 2));
					}
				}
			}
		}
		else
		{
			
			$cons = mysqli_query($conn,"SELECT * FROM  btyturnos_atencion WHERE slncodigo = $codSalon AND tuafechai = CURDATE()");

			if (mysqli_num_rows($cons) > 0) 
			{	

				$fetchCom = mysqli_fetch_array($cons);

				if ($fetchCom['tuaobservacionesi'] == "") 
				{
					$sql = mysqli_query($conn, "UPDATE btyturnos_atencion SET tuaobservacionesi = '$comment' WHERE slncodigo = $codSalon AND tuafechai =  CURDATE();")or die(mysqli_error($conn));
				}	



					$conteo = $conn->query("SELECT count(*) AS maximo_val FROM btycola_atencion WHERE tuafechai = CURDATE() AND slncodigo = $codSalon ");

					$max = $conteo->fetch_assoc();
					
					$res = $max['maximo_val'] + 1;
					

					$QueryValCol = mysqli_query($conn, "SELECT * FROM btycola_atencion WHERE clbcodigo = $cod_colaborador AND slncodigo = $codSalon AND tuafechai = CURDATE()");

					if (mysqli_num_rows($QueryValCol) > 0) 
					{					
						$FetchTurno = mysqli_fetch_array($QueryValCol);
						if ($FetchTurno['colhorasalida'] == null) 
						{
							//echo 3;
							echo json_encode(array("res" => 3));
						}
						else
						{
							//echo 2;
							echo json_encode(array("res" => 2));
						}
					}
					else
					{
						$consulta = mysqli_query($conn, "INSERT INTO btycola_atencion (slncodigo, tuafechai, clbcodigo, colposicion, colhoraingreso, colhorasalida, coldisponible) VALUES ('$codSalon', CURDATE(), '$cod_colaborador', $res, CURTIME(), null, '1') ")or die(mysqli_error($conn));

						if ($consulta) 
						{
							/*=============================================
							=            Section comment block            =
							=============================================*/
							
							$QueryDiponibles=mysqli_fetch_array(mysqli_query($conn,"SELECT max(colposicion) as colposicion  FROM btycola_atencion WHERE slncodigo = '".$codSalon."' AND coldisponible='1' AND tuafechai=CURDATE() AND colhorasalida IS NULL AND (clbcodigo <> '".$cod_colaborador."')"));

								if (is_null($QueryDiponibles['colposicion']))
								{
					                  	$colposicion_inicial=$colposicion=1;                  
								}
								else
								{
					               		$colposicion_inicial=$colposicion=($QueryDiponibles['colposicion']+1);               
								}

				

								$QueryColaNoDisponibles=mysqli_query($conn,"SELECT clbcodigo, colposicion FROM btycola_atencion WHERE (slncodigo = '".$codSalon."') AND (clbcodigo <> '".$cod_colaborador."') AND tuafechai=CURDATE() AND coldisponible='0' AND colhorasalida IS NULL ORDER BY colposicion");

					        
								while($registros = mysqli_fetch_array($QueryColaNoDisponibles))
								{
									
									$colposicion++;
									mysqli_query($conn,"UPDATE btycola_atencion SET colposicion='".$colposicion."' WHERE clbcodigo='".$registros["clbcodigo"]."' AND tuafechai=CURDATE() AND slncodigo='".$codSalon."'");			    
									
								}

					          	mysqli_query($conn,"UPDATE btycola_atencion SET colposicion ='".$colposicion_inicial."', coldisponible='1' WHERE clbcodigo = '".$cod_colaborador."' AND tuafechai = CURDATE() and slncodigo='".$codSalon."'");
											
											/*=====  End of Section comment block  ======*/
											
											echo json_encode(array("res" => 1, "codigocol" =>  $cod_colaborador));
										}					
									}
			    
			}
			else
			{
				$sql = mysqli_query($conn, "INSERT INTO btyturnos_atencion(slncodigo, tuafechai, tuafechaf, tuahorai, tuahoraf, usucodigoi, usucodigof, tuatotal, tuaobservacionesi, tuaobservacionesf)VALUES($codSalon, CURDATE(), CURDATE(), CURTIME(), CURTIME(), $user, $user, '0', '$comment' , '' )")or die(mysqli_error($conn));
				if ($sql) 
				{
					$conteo = $conn->query("SELECT count(*) AS maximo_val FROM btycola_atencion WHERE tuafechai = CURDATE() AND slncodigo = $codSalon ");

					$max = $conteo->fetch_assoc();
					$res = $max['maximo_val'] + 1;
					
			    
					$consulta = mysqli_query($conn, "INSERT INTO btycola_atencion (slncodigo, tuafechai, clbcodigo, colposicion, colhoraingreso, colhorasalida, coldisponible) VALUES ('$codSalon', CURDATE(), '$cod_colaborador', $res, CURTIME(), null, '1') ")or die(mysqli_error($conn));

					if ($consulta) 
					{
						//echo 1;
						echo json_encode(array("res" => 1, "codigocol" => $cod_colaborador));
					}
				}		
			}     
		}

	}
	else
	{
		echo json_encode(array("res" => 5));
	}


	mysqli_close($conn);

?>