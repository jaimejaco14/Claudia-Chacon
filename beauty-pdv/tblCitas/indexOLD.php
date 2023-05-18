<?php 
	session_start();
	include '../../cnx_data.php';
	$sln = mysqli_query($conn, "SELECT slnnombre FROM btysalon WHERE slncodigo = '".$_SESSION['PDVslncodigo']."' AND slnestado = 1 ");

	$rowSln = mysqli_fetch_array($sln);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Gestión de Citas</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
	<link rel="stylesheet" href="mailtip.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.25.6/sweetalert2.min.css" />
</head>
<body>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3">
				<h3>LISTADO DE <?php echo $rowSln[0]; ?> <button type="button" class="btn btn-info text-info btn-rounded" onclick="recargar();" data-toggle="tooltip" data-placement="top" title="Volver a inicio"><i class="fa fa-arrow-circle-o-left"></i></button> <button type="button" class="btn btn-warning text-info btn-rounded" id="regClienteNew" data-toggle="tooltip" data-placement="top" title="Nuevo Cliente"><i class="fa fa-users"></i></button></h3>
				      <input type="text" name="" id="fechaAgenda" class="form-control " placeholder="Fecha" required="required" pattern="" title="" style="width: 100%">
						
				      <br>
			</div>
			<div class="col-md-9">
				<br>
				<div class="well">
					* Gracias por llamar a Claudia Chacón, ¿en qué podemos servirle?<br>
					* ¿A nombre de quién registro la reserva?<br>
					*¿Me indica la fecha y hora de su cita?<br>
					* ¿Me espera un momento por favor mientras busco la disponibilidad de la cita?<br>
					* Señor(a), se le ha asignado una cita para los servicios de XXXX con el XXXX (estilista, manicurista,esteticista) a las XXXX horas del día XXXX, me confirma si está de acuerdo?<br>
				</div>
			</div>
		</div>
		<div class="row">
				<div class="col-md-12">
				<div class="table-responsive" id="tablaLista">
					<table class="table table-hover table-bordered" id="tblListado">
						<thead>
							<tr>
								<?php 
									$sql = mysqli_query($conn, "SELECT COUNT(b.crgcodigo)as count, d.crgnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo JOIN btycargo d ON d.crgcodigo=b.crgcodigo WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.prgfecha = CURDATE() AND a.tprcodigo IN (1,9) AND d.crgincluircolaturnos = 1 GROUP BY b.crgcodigo, d.crgnombre ORDER BY d.crgnombre ");
										echo '<th colspan="1" class="active"> </th>';
										while ($rows = mysqli_fetch_array($sql)) 
										{
											echo '<th colspan="'.$rows[0].'" class="active"><center> '.$rows[1]."S ( ". $rows[0] . " ) ". '</center></th>';
										}

									
								?>

							</tr>
							<tr>
								<th>HORA</th>
								<?php 
									$sql = mysqli_query($conn, "SELECT c.trcnombres, a.clbcodigo, d.crgnombre, CONCAT(e.trnnombre, ' DE ', TIME_FORMAT(e.trndesde, '%H:%i'), ' A ', TIME_FORMAT(e.trnhasta,'%H:%i')) AS trnnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btyturno e ON e.trncodigo=a.trncodigo WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.prgfecha = CURDATE() AND a.tprcodigo IN (1,9) AND d.crgincluircolaturnos = 1 GROUP BY d.crgnombre, a.clbcodigo, e.trnnombre, e.trndesde, e.trnhasta ORDER BY d.crgnombre");

									$filas = mysqli_num_rows($sql);

									while ($row = mysqli_fetch_array($sql)) 
									{
										$nombre = explode(" ", $row['trcnombres']);
										
										switch ($row[2]) 
										{
											case 'ESTETICISTA':
												echo '
												
												<th class="info" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$row['trnnombre'].'">'.$nombre[0].' </th>';										
	
												break;

											case 'ESTILISTA':
												echo '<th class="danger" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$row['trnnombre'].'">'.$nombre[0].'</th>';										
	
												break;

											case 'MANICURISTA':
												echo '<th class="success" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$row['trnnombre'].'">'.$nombre[0].'</th>';										
	
												break;
											
											default:
												# code...
												break;
										}

										$codcol.=$row['clbcodigo'].',';
									}
								?>
							</tr>	
						</thead>
					<tbody>



<?php 	

	$SQL=mysqli_query($conn, "SET lc_time_names = 'es_CO'");

	$SQL = mysqli_query($conn, "SELECT TIME_FORMAT(h.hordesde, '%H:%i') AS desde, TIME_FORMAT(h.horhasta, '%H:%i')AS horhasta, h.hordia FROM btyhorario h JOIN btyhorario_salon hs ON h.horcodigo=hs.horcodigo WHERE hs.slncodigo = '".$_SESSION['PDVslncodigo']."' AND h.hordia = DAYNAME(CURDATE())");


		$fil = mysqli_fetch_array($SQL);

		
		$r=0;

		/************/

		//FESTIVO

		$queryFes = mysqli_query($conn, "SELECT DAY(a.fesfecha)AS dia, a.fesobservacion FROM btyfechas_especiales a WHERE MONTH(a.fesfecha) = MONTH(CURDATE()) and year(a.fesfecha)= year(curdate()) ORDER BY dia");

    	$diaFestivo='';
    	$Festivo='';

    	while($fes = mysqli_fetch_array($queryFes))
    	{
    		$Festivo.=$fes['fesobservacion'].',';
    		$diaFestivo.=$fes['dia'].',';
    	}

    	$vectorFestivo = explode(',',$diaFestivo);
    	$vectorTipoFestivo = explode(',',$Festivo);


		/************/

		$veccodcol=explode(',',$codcol);
		$tam=count($veccodcol);
		while ($cenvertedTime < $fil['horhasta']) 
		{
			$i=0;
				$cenvertedTime = date('H:i',strtotime('+' . $r .' minutes',strtotime($fil['desde'])));
				$r = $r+30;
			
				echo '<tr><td data-hora="'.$cenvertedTime.'">'.$cenvertedTime.'</td>';

				
						
						for($i=0; $i<$tam; $i++) 
						{ 							

							$d = "SELECT a.citcodigo, a.clbcodigo, c.trcrazonsocial as clbnombre, a.slncodigo, d.slnnombre, d.slndireccion, a.sercodigo, e.sernombre, e.serduracion, a.clicodigo, g.trcrazonsocial as clinombre, a.usucodigo, i.trcrazonsocial as usunombre, a.citfecha, TIME_FORMAT(a.cithora, '%H:%i')AS cithora, a.citobservaciones, a.citfecharegistro, a.cithoraregistro FROM btycita a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btysalon d ON d.slncodigo=a.slncodigo JOIN btyservicio e ON e.sercodigo=a.sercodigo JOIN btycliente f ON f.clicodigo=a.clicodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btyusuario h ON h.usucodigo=a.usucodigo JOIN btytercero i ON i.tdicodigo=h.tdicodigo AND i.trcdocumento=h.trcdocumento WHERE a.clbcodigo = '".$veccodcol[$i]."' AND a.citfecha = CURDATE() AND a.cithora = '".$cenvertedTime."' AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' ";



								$sqlS = mysqli_query($conn, $d)or die(mysqli_error($conn));

																						

								$fetch = mysqli_fetch_array($sqlS);


								if ($fetch['serduracion'] > '30') 
								{

									$S = "SELECT TIME_FORMAT(trn.trninicioalmuerzo,'%H:%i')AS trninicioalmuerzo, TIME_FORMAT(trn.trnfinalmuerzo,'%H:%i')AS trnfinalmuerzo, trn.trnnombre FROM btyprogramacion_colaboradores prg JOIN btyturno trn ON trn.trncodigo=prg.trncodigo WHERE prg.clbcodigo = '".$veccodcol[$i]."' AND prg.prgfecha = CURDATE()";

											$filas= mysqli_query($conn, $S);

											$d = mysqli_fetch_array($filas);

											if ($d[0] == $cenvertedTime) 
											{
												$queryEstado = mysqli_query($conn, "SELECT MAX(a.esccodigo) AS codEstado, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$fetch['citcodigo']."' GROUP BY a.esccodigo ORDER BY a.esccodigo DESC LIMIT 1");

														$fetchEstado = mysqli_fetch_array($queryEstado);

														switch ($fetchEstado[0]) 
														{
															case '1':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" data-col="'.$veccodcol[$i].'" class="verCita" style="cursor:pointer;background-color: #f300ff; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-clock-o" aria-hidden="true"></i> EXT </td>';
																break;

															case '2':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: lime" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"></td>';
																break;

															case '3':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #ef0b0b;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-times"></i></td>';
																break;

															case '7':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #2ad1c1;color:black; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-calendar"></i></td>';

																break;
															case '8':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #4cd13a;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-check"></i></td>';
																break;

															case '9':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: purple; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-thumbs-down"></i></td>';
																break;
															
															default:
																	echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer; background-color: #f5d938; border-color="#f5d938" data-toggle="tooltip" data-placement="top" data-container="body" title=" ALMUERZO DE '.$d['trninicioalmuerzo'].' A '.$d['trnfinalmuerzo'].' - TURNO DE '.$d['trnnombre'].' "><center><i class="fa fa-cutlery" aria-hidden="true" style="color: #444"></i></center></td>';
																break;
														}
											}
											else
											{
												if ($fetch['cithora'] == $cenvertedTime) 
												{



														$queryEstado = mysqli_query($conn, "SELECT MAX(a.esccodigo) AS codEstado, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$fetch['citcodigo']."' GROUP BY a.esccodigo ORDER BY a.esccodigo DESC LIMIT 1");

														$fetchEstado = mysqli_fetch_array($queryEstado);

														switch ($fetchEstado[0]) 
														{
															case '1':
																echo '<td data-hora="'.$cenvertedTime.'" data-print="99"  data-codcita="'.$fetch['citcodigo'].'" data-col="'.$veccodcol[$i].'" class="verCita" style="cursor:pointer;background-color: #f300ff; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-clock-o" aria-hidden="true"></i> EXT  </td>';
																break;

															case '2':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: lime" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"></td>';
																break;

															/*case '3':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #ef0b0b;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-times"></i></td>';
																break;*/

															case '7':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #2ad1c1;color:black; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-calendar"></i></td>';

																break;
															case '8':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #4cd13a;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-check"></i></td>';
																break;

															case '9':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: purple; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-thumbs-down"></i></td>';
																break;
															
															default:
																echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer;"></td>';
																break;
														}

													}	
													else
													{
														echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer;">SE PASA</td>';
													}
											}
								}
								else
								{



											$S = "SELECT TIME_FORMAT(trn.trninicioalmuerzo,'%H:%i')AS trninicioalmuerzo, TIME_FORMAT(trn.trnfinalmuerzo,'%H:%i')AS trnfinalmuerzo, trn.trnnombre FROM btyprogramacion_colaboradores prg JOIN btyturno trn ON trn.trncodigo=prg.trncodigo WHERE prg.clbcodigo = '".$veccodcol[$i]."' AND prg.prgfecha = CURDATE()";

											$filas= mysqli_query($conn, $S);

											$d = mysqli_fetch_array($filas);

											if ($d[0] == $cenvertedTime) 
											{
												$queryEstado = mysqli_query($conn, "SELECT MAX(a.esccodigo) AS codEstado, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$fetch['citcodigo']."' GROUP BY a.esccodigo ORDER BY a.esccodigo DESC LIMIT 1");

														$fetchEstado = mysqli_fetch_array($queryEstado);

														switch ($fetchEstado[0]) 
														{
															case '1':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" data-col="'.$veccodcol[$i].'" class="verCita" style="cursor:pointer;background-color: #1981f2; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-clock-o" aria-hidden="true"></i></td>';
																break;

															case '2':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: lime" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"></td>';
																break;

															/*case '3':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #ef0b0b;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-times"></i></td>';
																break;*/

															case '7':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #2ad1c1;color:black; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-calendar"></i></td>';

																break;
															case '8':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #4cd13a;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-check"></i></td>';
																break;

															case '9':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: purple; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-thumbs-down"></i></td>';
																break;
															
															default:
																	echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer; background-color: #f5d938; border-color="#f5d938" data-toggle="tooltip" data-placement="top" data-container="body" title=" ALMUERZO DE '.$d['trninicioalmuerzo'].' A '.$d['trnfinalmuerzo'].' - TURNO DE '.$d['trnnombre'].' "><center><i class="fa fa-cutlery" aria-hidden="true" style="color: #444"></i></center></td>';
																break;
														}
											}
											else
											{
													if ($fetch['cithora'] == $cenvertedTime) 
													{


														$queryEstado = mysqli_query($conn, "SELECT MAX(a.esccodigo) AS codEstado, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$fetch['citcodigo']."' GROUP BY a.esccodigo ORDER BY a.esccodigo DESC LIMIT 1");

														$fetchEstado = mysqli_fetch_array($queryEstado);

														switch ($fetchEstado[0]) 
														{
															case '1':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" data-col="'.$veccodcol[$i].'" class="verCita" style="cursor:pointer;background-color: #1981f2; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-clock-o" aria-hidden="true"></i></td>';
																break;

															case '2':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: lime" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"></td>';
																break;

															/*case '3':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #ef0b0b;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-times"></i></td>';
																break;*/

															case '7':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #2ad1c1;color:black; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-calendar"></i></td>';

																break;
															case '8':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: #4cd13a;color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-check"></i></td>';
																break;

															case '9':
																echo '<td data-hora="'.$cenvertedTime.'" data-codcita="'.$fetch['citcodigo'].'" class="verCita" style="cursor:pointer;background-color: purple; color:white; text-align: center" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$fetchEstado[1].'"><i class="fa fa-thumbs-down"></i></td>';
																break;
															
															default:
																echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer;"></td>';
																break;
														}

													}	
													else
													{
														echo '<td data-hora="'.$cenvertedTime.'" data-col="'.$veccodcol[$i].'" class="tdCol" style="cursor:pointer;"></td>';
													}
											}
								}//end else
						}//end for
				
		}//end while
?>
							
</tr>							
						</tbody>
						<tfoot>
							<tr>
								<th></th>
								<?php 
									$sql = mysqli_query($conn, "SELECT c.trcnombres, a.clbcodigo, d.crgnombre, CONCAT(e.trnnombre, ' DE ', TIME_FORMAT(e.trndesde, '%H:%i'), ' A ', TIME_FORMAT(e.trnhasta,'%H:%i')) AS trnnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento AND c.tdicodigo=b.tdicodigo JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btyturno e ON e.trncodigo=a.trncodigo WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.prgfecha = CURDATE() AND a.tprcodigo IN (1,9) AND d.crgincluircolaturnos = 1 GROUP BY d.crgnombre, a.clbcodigo, e.trnnombre, e.trndesde, e.trnhasta ORDER BY d.crgnombre");

									$filas = mysqli_num_rows($sql);

									while ($row = mysqli_fetch_array($sql)) 
									{
										$nombre = explode(" ", $row['trcnombres']);
										
										switch ($row[2]) 
										{
											case 'ESTETICISTA':
												echo '
												
												<th class="info" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$row['trnnombre'].'">'.$nombre[0].' </th>';										
	
												break;

											case 'ESTILISTA':
												echo '<th class="danger" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$row['trnnombre'].'">'.$nombre[0].'</th>';										
	
												break;

											case 'MANICURISTA':
												echo '<th class="success" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$row['trnnombre'].'">'.$nombre[0].'</th>';										
	
												break;
											
											default:
												# code...
												break;
										}

										//$codcol.=$row['clbcodigo'].',';
									}
								?>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>

<!-- <div class="container">
	<center><table class="table table-bordered table-hover" style="width: 30%;">
		
		<tbody> -->
	<?php
		/*$a = "SELECT COUNT(nc.esccodigo)AS count, s.escnombre, (SELECT COUNT(ct.citcodigo) FROM btycita ct WHERE ct.slncodigo= 9 AND ct.citfecha = CURDATE())as conteo FROM btynovedad_cita nc JOIN btycita ct ON ct.citcodigo=nc.citcodigo JOIN btyestado_cita s ON s.esccodigo=nc.esccodigo WHERE ct.slncodigo= '".$_SESSION['PDVslncodigo']."' AND ct.citfecha = CURDATE() GROUP BY nc.esccodigo, s.escnombre";

		$html = '';
		$sql  = mysqli_query($conn, $a);
		while($d2   = mysqli_fetch_array($sql))
		{
			
			$html.= '
			<tr>
				<th>'.$d2[1]. " ". $d2[0] .'</th>

			</tr>
			
			';
		}

		echo $html;*/
	?>
			
		<!-- </tbody>
			</table></center>
		</div> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script src="citas.js"></script>
<script src="mailtip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

</body>
</html>

<!-- Modal -->
<div class="modal fade" id="modalAgendarCita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Agendar Cita </h4>

      </div>
      <div class="modal-body">
       	<div class="panel panel-info">
       		<div class="panel-heading">
       			<h3 class="panel-title" id="nombreCol"></h3>       			
       		</div>
       		<div class="panel-body">
       			<input type="hidden" id="codigoCol">
       			<input type="hidden" id="slncodigo">
				
       			<div class="col-md-6">
	       			<div class="form-group">
			        		<label for="">Medio</label>
			        		<select name="" id="selMedio" class="form-control" required="required">
			        			<?php 
			        				$sql = mysqli_query($conn, "SELECT meccodigo, mecnombre FROM btymedio_contacto WHERE mecestado = 1 ORDER BY mecnombre");
			        				while ($row = mysqli_fetch_array($sql)) 
			        				{
			        					if ($row['mecnombre'] == "PRESENCIAL") 
			        					{
			        						echo '<option value='.$row['meccodigo'].' selected>'.utf8_encode($row['mecnombre']).'</option>';
			        					}
			        					else
			        					{
			        						echo '<option value='.$row['meccodigo'].'>'.utf8_encode($row['mecnombre']).'</option>';
			        						
			        					}
			        				}
			        			?>
			        		</select>
			        	</div>
			     </div>


		        	 <div class="col-md-6">
			        	<div class="form-group">
			        		<label for="">Cliente</label>
			        		<div class="containerSel">
			        		<select name="" id="cliente" class="selectpicker form-control"  data-size="10" data-header="Selecciona" data-live-search="true" >
			        			<?php 
			        			$sql = mysqli_query($conn, "SELECT a.clicodigo, b.trcrazonsocial, b.trcdocumento FROM btycliente a JOIN btytercero b ON a.trcdocumento=b.trcdocumento AND a.tdicodigo=b.tdicodigo ORDER BY b.trcrazonsocial");

			        				while ($row = mysqli_fetch_array($sql)) 
			        				{
			        					echo '<option value="'.$row['clicodigo'].'">'.utf8_encode($row['trcrazonsocial']). ' ('.$row['trcdocumento'].')</option>';
			        				}
			        			 ?>
			        		</select>
			        		</div>
			        		<input type="text" name="" id="clienteCed" readonly class="form-control" value="" required="required" pattern="" title="" style="display: none">
			        		<input type="hidden" name="" id="IdclienteCed">
			        	</div>
		        	</div>


			    
			      <div class="col-md-12">
			        	<div class="form-group">
			        		<label for="">Servicio</label>
			        		<select name="" id="selServicio" onchange="validarTiempoSer();" class="form-control"  data-size="10" data-header="Selecciona" data-live-search="true" style="width: 100%!important;">
			        			
			        		</select>
			        	</div>
		        	</div>
       			<div class="col-md-6">
	       			<div class="form-group">
			        		<label for="">Hora</label>
			        		<input type="text" name="" id="horaAge" class="form-control" readonly="" value="" title="">
			        	</div>
			     </div>
		        	<div class="col-md-12">
			        	<div class="form-group">
			        		<label for="">Observaciones</label>
			        		<textarea id="observaciones" class="form-control" rows="3" style="resize: none;" placeholder="Opcional"></textarea>
			        	</div>
		        	</div>
       		</div>
       	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id="btnNuevoCli" data-toggle="tooltip" data-placement="top" title="Nuevo Cliente" data-container="body"><i class="fa fa-plus"></i></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarCita" data-toggle="tooltip" data-placement="top" title="Agendar Cita"><i class="fa fa-save"></i> Agendar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Reprogramar Cita -->
<div class="modal fade" id="modalAgendarCitaRepro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Modificar Cita</h4>
      </div>
      <div class="modal-body">
       	<div class="panel panel-info">
       		<div class="panel-heading">
       			<h3 class="panel-title" id="nombreColEdit"></h3>
       		</div>
       		<div class="panel-body">
       			<input type="hidden" id="codigoColEdit">
       			<input type="hidden" id="citcodigo">

       			<div class="col-md-12">
					<div class="form-group">
			        		<label for="">Colaborador</label>
			        		<select name="" id="colaboradorEdit" class="selectpicker form-control"  data-size="10" data-header="Selecciona" data-live-search="true" >
			        			<?php 
			        			$sql = mysqli_query($conn, "SELECT a.clbcodigo, b.trcrazonsocial, c.crgnombre FROM btycolaborador a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento JOIN btycargo c ON c.crgcodigo=a.crgcodigo WHERE c.crgincluircolaturnos = 1 ORDER BY b.trcrazonsocial");

			        				while ($row = mysqli_fetch_array($sql)) 
			        				{
			        					echo '<option value="'.$row['clbcodigo'].'">'.utf8_encode($row['trcrazonsocial']). ' ('.$row['crgnombre'].')</option>';
			        				}
			        			 ?>
			        		</select>
			      
			        		
			        	</div>
       			</div>

       			<div class="col-md-6">
	       			<div class="form-group">
			        		<label for="">Medio</label>
			        		<select name="" id="selMedioEdit" class="form-control" required="required">
			        			<?php 
			        				$sql = mysqli_query($conn, "SELECT meccodigo, mecnombre FROM btymedio_contacto WHERE mecestado = 1 ORDER BY mecnombre");
			        				while ($row = mysqli_fetch_array($sql)) 
			        				{
			        					if ($row['mecnombre'] == "PRESENCIAL") 
			        					{
			        						echo '<option value='.$row['meccodigo'].' selected>'.utf8_encode($row['mecnombre']).'</option>';
			        					}
			        					else
			        					{
			        						echo '<option value='.$row['meccodigo'].'>'.utf8_encode($row['mecnombre']).'</option>';
			        						
			        					}
			        				}
			        			?>
			        		</select>
			        	</div>
			     </div>


		        	 <div class="col-md-6">
			        	<div class="form-group">
			        		<label for="">Cliente</label>
			        		<select name="" id="clienteEdit" class="selectpicker form-control"  data-size="10" data-header="Selecciona" data-live-search="true" >
			        			<?php 
			        			$sql = mysqli_query($conn, "SELECT a.clicodigo, b.trcrazonsocial, b.trcdocumento FROM btycliente a JOIN btytercero b ON a.trcdocumento=b.trcdocumento AND a.tdicodigo=b.tdicodigo ORDER BY b.trcrazonsocial");

			        				while ($row = mysqli_fetch_array($sql)) 
			        				{
			        					echo '<option value="'.$row['clicodigo'].'">'.utf8_encode($row['trcrazonsocial']). ' ('.$row['trcdocumento'].')</option>';
			        				}
			        			 ?>
			        		</select>
			        	</div>
		        	</div>
			    
			      <div class="col-md-12">
			        	<div class="form-group">
			        		<label for="">Servicio</label>
			        		<select name="" id="selServicioEdit" class="form-control"  data-size="10" data-header="Selecciona" data-live-search="true" style="width: 100%!important;">
			        			
			        		</select>
			        	</div>
		        	</div>

		        	<div class="col-md-6">
	       			<div class="form-group">
			        		<label for="">Fecha</label>
			        		<input type="text" id="fechaEdit" class="form-control" placeholder="0000-00-00">
			        	</div>
			       </div>

       			<div class="col-md-6">
	       			<div class="form-group">
			        		<label for="">Hora</label>
			        		<select name="" id="horaAgeEdit" class="form-control" required="required">
			        			<option value="06:30">06:30</option>
			        			<option value="07:00">07:00</option>
			        			<option value="07:30">07:30</option>
			        			<option value="08:00">08:00</option>
			        			<option value="08:30">08:30</option>
			        			<option value="09:00">09:00</option>
			        			<option value="09:30">09:30</option>
			        			<option value="10:00">10:00</option>
			        			<option value="10:30">10:30</option>
			        			<option value="11:00">11:00</option>
			        			<option value="11:30">11:30</option>
			        			<option value="12:00">12:00</option>
			        			<option value="12:30">12:30</option>
			        			<option value="13:00">13:00</option>
			        			<option value="13:30">13:30</option>
			        			<option value="14:00">14:00</option>
			        			<option value="14:30">14:30</option>
			        			<option value="15:00">15:00</option>
			        			<option value="15:30">15:30</option>
			        			<option value="16:00">16:00</option>
			        			<option value="16:30">16:30</option>
			        			<option value="17:00">17:00</option>
			        			<option value="17:30">17:30</option>
			        			<option value="18:00">18:00</option>
			        			<option value="18:30">18:30</option>
			        			<option value="19:00">19:00</option>
			        			<option value="19:30">19:30</option>
			        		</select>
			        	</div>
			     </div>
		        	<div class="col-md-12">
			        	<div class="form-group">
			        		<label for="">Observaciones</label>
			        		<textarea id="observacionesEdit" class="form-control" rows="3" style="resize: none;" placeholder="Opcional"></textarea>
			        	</div>
		        	</div>
       		</div>
       	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarCitaRepro"><i class="fa fa-edit"></i> Modificar</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalAgendas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-search"></i> Ver Agenda</h4>
      </div>
      <div class="modal-body">
         <form action="" method="POST" role="form"> 
         	<input type="hidden" id="citcodigoEstado">        
         	<div class="form-group">
         		<label for="">Cliente</label>
         		<input type="text" class="form-control" id="txtcliente" placeholder="" readonly>
         	</div>

         	<div class="form-group">
         		<label for="">Servicio</label>
         		<input type="text" class="form-control" id="txtservicio" placeholder="" readonly>
         	</div>

         	<div class="form-group">
         		<label for="">Móvil</label>
         		<input type="text" class="form-control" id="txtmovil" placeholder="" readonly>
         	</div>

         	<div class="form-group">
         		<label for="">E-mail</label>
         		<input type="text" class="form-control" id="txtemail" placeholder="" readonly>
         	</div>

         	<div class="form-group">
         		<label for="">Agendó</label>
         		<input type="text" class="form-control" id="txtusuarioagenda" placeholder="" readonly>
         	</div>
		
		<center><div id="center">
	         	<div class="btn-group" role="group" aria-label="...">
			  	<button type="button" class="btn btn-default estado" data-estado="8" style="background-color: #4cd13a; color: white; border-color: #4cd13a">Asistida</button>
			  	<button type="button" class="btn btn-default estado" data-estado="3" style="background-color: red; color: white; border-color: red">Cancelada</button>
			  	<button type="button" class="btn btn-default estado" data-estado="9" style="background-color: purple; color: white; border-color: purple">Inasistencia</button>
			  	<button type="button" id="reprogramar" class="btn btn-primary estado reprogramar" data-toggle="modal" style=" color: white;">Reprogramar</button>
			</div>
		</div></center>
           </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalRepro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<!--=========================================
=            MODAL NUEVO CLIENTE            =
==========================================-->

<!-- Modal -->
<div class="modal fade" id="modalNuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> Nuevo Cliente</h4>
            </div>
            <div class="modal-body">                           
                                       

                    <input type="hidden" id="txtSexo">
                    <input type="hidden" id="txtFechaN">
                    <input type="hidden" id="txtTipoS">
                                            
                                            <div class="row">
                                                <div class="col-md-10" id="btnBarcode">
                                                    <span  data-toggle="tooltip" style="cursor: pointer" data-placement="top" title="Click para leer código de barra"><i class="fa fa-barcode fa fa-3x" ></i></span>
                                                    <div id="spin" style="display: none">
                                                        <i class="fa fa-spinner fa-spin fa 2x text-info" ></i> <span class="text-info"><b>Esperando por lectura de documento</b></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="text" id="dataCapture" class="form-control" style="border: none!important; border-color: transparent!important; color: transparent!important">
                                                </div>
                                            </div>
                                            
                                            <div class="row">                                                	
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">                                                        	
                                                        <label for="">TIPO DOCUMENTO</label>
                                                        <br>
                                                            <select class="form-control" id="tipodoc"  style="width: 100%!important">
                                                                <?php 
                                                                $sql = mysqli_query($conn, "SELECT tdicodigo, tdialias FROM btytipodocumento WHERE tdiestado = 1 ORDER BY tdialias");

                                                                while ($row = mysqli_fetch_array($sql)) 
                                                                {
                                                                if ($row[1] == "CC") 
                                                                {
                                                                echo '<option value="'.$row[0].'" selected data-toggle="tooltip" data-placement="top" title="Cedula">'.$row[1].'</option>';        			
                                                                }
                                                                else
                                                                {
                                                                echo '<option value="'.$row[0].'">'.$row[1].'</option>';
                                                                }

                                                                }
                                                                ?>
                                                            </select>
                                                            <input type="text" name="" id="docReadonly" class="form-control" value="" style="display: none">
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">DOCUMENTO</label>                                                               
                                                            <input type="text" id="nroDoc" placeholder="Digite documento" class="form-control">                                             
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">NOMBRES</label>
                                                            <input type="text" class="form-control" id="nombres" placeholder="Digite nombres">
                                                    </div>
                                                </div>

                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">APELLIDOS</label>
                                                            <input type="text" class="form-control" id="apellidos" placeholder="Digite apellidos">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">MES CUMPLEAÑOS</label>
                                                        <select name="" id="mes" class="form-control">
                                                            <option value="0" selected>SELECCIONE MES</option>
                                                            <option value="01">ENERO</option>
                                                            <option value="02">FEBRERO</option>
                                                            <option value="03">MARZO</option>
                                                            <option value="04">ABRIL</option>
                                                            <option value="05">MAYO</option>
                                                            <option value="06">JUNIO</option>
                                                            <option value="07">JULIO</option>
                                                            <option value="08">AGOSTO</option>
                                                            <option value="09">SEPTIEMBRE</option>
                                                            <option value="10">OCTUBRE</option>
                                                            <option value="11">NOVIEMBRE</option>
                                                            <option value="12">DICIEMBRE</option>
                                                        </select>

                                                        <input type="text" name="" id="mesReadonly" class="form-control" value="" style="display: none">
                                                    </div>	                                                      
                                                </div> 

                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">DÍA CUMPLEAÑOS</label>
                                                        <select name="" id="dia" class="form-control">
                                                            <option value="0">SELECCIONE DÍA</option>
                                                            <?php 
                                                            for ($i=01; $i <= 31; $i++) { 
                                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                                            }
                                                            ?>
                                                            </select>
                                                            <input type="text" name="" id="diaReadonly" class="form-control" value="" style="display: none">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-4">
                                                    <div class="form-group">
                                                        <label for="">E-MAIL</label>
                                                            <input type="email" class="form-control" id="email" placeholder="Digite el e-mail">
                                                                <p class="help-block text-danger" id="txtAlertEmail" style="display:none"><b>Digite el e-mail</b></p>
                                                    </div>
                                                </div>

                                                <div class="col-xs-6 col-sm-6 col-md-4">
                                                    <div class="form-group">
                                                        <label for="">MÓVIL</label>
                                                            <div class="input-group"><input type="number" maxlength="10" id="movil" onblur="validar(this)" placeholder="Digite número móvil" class="form-control" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" />
                                                                <p class="help-block text-danger" id="txtAlertMovil" style="display:none"><b>Digite el número del móvil</b></p></div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-6 col-sm-6 col-md-4">
                                                    <label for="">FIJO</label>
                                                        <div class="input-group"><input type="number" maxlength="7" id="fijo" placeholder="Digite número fijo" class="form-control" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" /> <p class="help-block text-danger" id="txtAlertFijo" style="display:none"><b>Digite el número fijo</b></p></span></div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">NOTIFICACIONES AL MOVIL</label>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" value="" id="nm" checked>
                                                                </label>
                                                            </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">NOTIFICACIONES AL E-MAIL</label>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" value="" id="ne" checked>
                                                                </label>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div> 

                                      

                                        <div class="text-right m-t-xs">
                                            <br>
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                                <a class="btn btn-primary next btnNext2" type="button" href="javascript:void(0)"><i class="fa fa-save"></i> Registrar</a>
                                        </div>
               
            </div>
        </div>
    </div>
</div>
        
      


<!--====  End of MODAL NUEVO CLIENTE  ====-->

<style>
	th
	{
		font-size: .9em;
	}

	.btn
	{
		border-radius: 0px!important;
	}
	
	.form-control:focus 
	{
		outline: 0;
		-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);
		box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0),0 0 8px rgb(255, 255, 255);
	}


</style>							
								
<script>


$(document).ready(function() 
{
	$('[data-toggle="tooltip"]').tooltip();


	var t = $('#tblListado tbody');
	t.find('td:last-child').remove();

	$('.selectpicker').selectpicker('refresh');	

	$('.selectpicker').selectpicker({
	  style: 'btn-info',
	  size: 5,

	});
});

function recargar () 
{
	window.location="../inicio.php";
}

$(document).on('click', '.tdCol', function() 
{
	var hora   = $(this).data("hora");
	var codigo = $(this).data("col");
	var fecha  = $('#fechaAgenda').val();

	$('#codigoCol').val('');
	$('#horaAgenda').val('');
	$('#codigoCol').val(codigo);
	$('#horaAge').val(hora);
	$('#salon').val('');	
	

	$.ajax({
		url: 'process.php',
		method: 'POST',
		data: {opcion: "col", codigo: codigo, hora:hora, fecha:fecha},
		success: function (data) 
		{

			var jsonSer = JSON.parse(data);

			if (jsonSer.res == "full") 
			{
				$('#selServicio').html('');
				for (var i in jsonSer.json)
				{
					$('#nombreCol').html('');
					$('#selServicio').append('<option value="'+jsonSer.json[i].idservicio+'">'+jsonSer.json[i].servicio + " ( "+ jsonSer.json[i].dur +" MIN )" +'</option>');
					$('#nombreCol').html('<i class="fa fa-user"></i> <b>'+jsonSer.nombre +'</b>');
					$('#slncodigo').val(jsonSer.slncodigo);
					$('#salon').val(jsonSer.salon);
					$('#modalAgendarCita').modal("show");
				}
			}
			else if (jsonSer.res == "empty") 
			{
				swal("No tiene servicios autorizados", "", "warning");
			}
			else if (jsonSer.res == "exists") 
			{
				swal("Aún se encuentra en turno", "Verifique cuánto dura el servicio anterior", "error");
			}
		}
	});
});


$(document).on('click', '#btnGuardarCita', function(e) 
{
	var clbcodigo      = $('#codigoCol').val();
	var hora           = $('#horaAge').val();
	var servicio       = $('#selServicio').val();
	var observaciones  = $('#observaciones').val();
	var medio          = $('#selMedio').val();
	var cliente        = $('#cliente').val();
	var cliente2       = $('#IdclienteCed').val();
	var fecha          = $('#fechaAgenda').val();

	validarTiempoSer();
		$.ajax({
			url: 'process.php',
			method: 'POST',
			data: {opcion: "insert", clbcodigo:clbcodigo, cliente:cliente, cliente2:cliente2, hora: hora,fecha:fecha, servicio:servicio, medio:medio, observaciones:observaciones},
			success: function (data) 
			{
				
				var jsonVal = JSON.parse(data);

				if (jsonVal.res == "full") 
				{
					for(var i in jsonVal.json)
					{					 
				
						swal("No puede agendar cita ya que tiene una a las " + jsonVal.json[i].hora + " y este servicio dura " + jsonVal.json[i].duracion + " minutos",  " ", "error");
				
					}
				}
				else
				{
					$('#modalAgendarCita').modal("hide");
					cargarFecha ();
					$('[data-toggle="tooltip"]').tooltip();
				}			
			}
		});	

});


/*===========================================
=            VER CITAS AGENDADAS            =
===========================================*/

$(document).on('click', '.verCita', function() 
{
	var citcodigo = $(this).data("codcita");
	var hora      = $(this).data("hora");
	var col       = $(this).data("col");
	$('#modalAgendas').modal("show");
	$('#citcodigoEstado').val(citcodigo);
	$('.reprogramar').attr('data-col', col); // sets 
	$('.reprogramar').attr('data-hora', hora); // sets
	$('.reprogramar').attr('data-citcodigo', citcodigo); // sets 



	$.ajax({
		url: 'process.php',
		method: 'POST',
		data: {opcion: "verAgenda", citcodigo:citcodigo},
		success: function (data) 
		{
			var json = JSON.parse(data);

			for(var i in json.json)
			{
				$('#txtcliente').val(json.json[i].cliente);
				$('#txtservicio').val(json.json[i].servicio + " DURACIÓN: [ " + json.json[i].duracion + " ]");
				$('#txtmovil').val(json.json[i].movil);
				$('#txtemail').val(json.json[i].email);
				$('#txtusuarioagenda').val(json.json[i].usuagenda);

				if (json.estadoCita == 3) 
				{
					$('.estado').attr('disabled', true);
				}
				else if (json.estadoCita == 9) 
				{
					$('.estado').attr('disabled', true);
				}
				else if (json.estadoCita == 8) 
				{
					$('.estado').attr('disabled', true);
				}
				else if (json.estadoCita == 1) 
				{
					$('.estado').attr('disabled', false);
				}
				else if (json.estadoCita == 7) 
				{
					$('#reprogramar').attr('disabled', true);
				}
			}
		}
	});
});


/*=====  End of VER CITAS AGENDADAS  ======*/



$('#modalAgendarCita').on('hide.bs.modal', function () 
{   
	$('#observaciones').val('');
	$('#nombreCol').val('');
});

var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

$.fn.datepicker.dates['es'] = {
days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
today: "Today",
weekStart: 0
};


$('#fechaAgenda').datepicker({ 

format: "yyyy-mm-dd",
setDate: "today",
language: 'es',
});


$('#fechaEdit').datepicker({ 
format: "yyyy-mm-dd",
setDate: "today",
language: 'es',
});



$('#fechaAgenda').on('changeDate', function(ev)
{
    $(this).datepicker('hide');
    $('[data-toggle="tooltip"]').tooltip();
    cargarLista ();
});


$('#fechaEdit').on('changeDate', function(ev)
{
    $(this).datepicker('hide');
});


function cargarFecha () 
{
	var fecha = $('#fechaAgenda').val();

	$.ajax({
		url: 'process.php',
		method: 'POST',
		data: {opcion: "cargarFecha", fecha:fecha},
		success: function (data) 
		{
			$('#tablaLista').html(data);
			$('[data-toggle="tooltip"]').tooltip();
			var t = $('#tblListado tbody');
			t.find('td:last-child').remove();
		}
	});
}


function cargarLista () 
{
	var fecha = $('#fechaAgenda').val();

	$.ajax({
		url: 'process.php',
		method: 'POST',
		data: {opcion: "cargarLista", fecha:fecha},
		success: function (data) 
		{
			$('#tablaLista').html(data);
			$('[data-toggle="tooltip"]').tooltip();
			var t = $('#tblListado tbody');
			t.find('td:last-child').remove();
		}
	});
}


$(".estado").on( 'click', function() 
{
    var estado    = $(this).data("estado");
    var citcodigo = $('#citcodigoEstado').val();

    	
    	$.ajax({
    		url: 'process.php',
    		method: 'POST',
    		data: {opcion: "estado", estado:estado, citcodigo:citcodigo},
    		success: function (data) 
    		{
    			if (data == 1) 
    			{
    				cargarFecha ();
    				$('#modalAgendas').modal("hide");
    			}
    		}
    	});
});

$(document).on('click', '.reprogramar', function() 
{
	var hora      = $(this).data("hora");
	var codigo    = $(this).data("col");
	var citcodigo = $(this).data("citcodigo");

	$('#modalAgendas').modal("hide");

	$('#codigoColEdit').val('');
	$('#horaAgenda').val('');
	$('#codigoColEdit').val(codigo);
	$('#horaAgeEdit').val(hora);
	$('#clienteEdit').prop('disabled', true);
	$('#clienteEdit').selectpicker('refresh');
	$('#citcodigo').val(citcodigo);
	

	$.ajax({
		url: 'process.php',
		method: 'POST',
		data: {opcion: "col", codigo: codigo, hora:hora},
		success: function (data) 
		{

			var jsonSer = JSON.parse(data);

			if (jsonSer.res == "full") 
			{
				$('#selServicio').html('');
				for (var i in jsonSer.json)
				{
					$('#nombreCol').html('');
					
					$('#selServicioEdit').append('<option value="'+jsonSer.json[i].idservicio+'">'+jsonSer.json[i].servicio+'</option>');
					
					$('#nombreColEdit').html('<i class="fa fa-user"></i> <b>'+jsonSer.nombre +'</b>');
					$('#slncodigo').val(jsonSer.slncodigo);
					$('#modalAgendarCitaRepro').modal("show");
				}
			}
			else if (jsonSer.res != 1) 
			{
				swal("No tiene servicios autorizados", "", "warning");
			}
		}
	});
});

$(document).on('change', '#colaboradorEdit', function(event) 
{
	$('#codigoColEdit').val('');
});

$(document).on('click', '#btnGuardarCitaRepro', function() 
{
	var medio     = $('#selMedioEdit').val();
	var cliente   = $('#clienteEdit').val();
	var servicio  = $('#selServicioEdit').val();
	var hora      = $('#horaAgeEdit').val();
	var observ    = $('#observacionesEdit').val();
	var col       = $('#codigoColEdit').val();
	var fecha     = $('#fechaEdit').val();
	var citcodigo = $('#citcodigo').val();
	var newCol    = $('#colaboradorEdit').val();

	if (fecha == "") 
	{
		swal("Seleccione la fecha", "","warning");
	}
	else
	{

		$.ajax({
			url: 'process.php',
			method: 'POST',
			data: {opcion: "reprogramar", clbcodigo: col, cliente:cliente, medio:medio, servicio:servicio, hora:hora, observ:observ, fecha:fecha, citcodigo:citcodigo, newCol:newCol},
			success: function (data) 
			{
				if (data == 1) 
				{
					cargarFecha ();
	    				$('#modalAgendarCitaRepro').modal("hide");
	    				//location.reload();
				}
				else if (data == 3) 
				{
					swal("El colaborador no labora este día", "Intente otro día", "error");
				}
				else
				{
					swal("Ya tiene una cita asignada para este día y esta hora", "", "error");
				}
			}
		});
	}
});

$(document).on('click', '#btnNuevoCli', function() 
{
	$('#modalNuevoCliente').modal("show");
	$('#modalNuevoCliente').on('shown.bs.modal', function () 
	{
      	$('#dataCapture').focus();
	}); 

});


/**************************************/

function validarTiempoSer () 
{
	var servicio = $('#selServicio').val();
	var hora     = $('#horaAge').val();
	var clb      = $('#codigoCol').val();
	var fecha    = $('#fechaAgenda').val();

	$.ajax({
		url: 'process.php',
		method: 'POST',
		data: {opcion: "validarServicio", servicio:servicio, hora:hora, clb:clb, fecha:fecha},
		success: function (data) 
		{
			var jsonSer = JSON.parse(data);

			if (jsonSer.res == "full") 
			{
				for(var i in jsonSer.json)
				{					 
			
					swal("No puede agendar cita ya que tiene una a las " + jsonSer.json[i].hora + " y este servicio dura " + jsonSer.json[i].duracion + " minutos",  " ", "error");
			
				}
			}
		}

	});
}


$(document).on('click', '#regClienteNew', function() 
{
	$('#modalNuevoCliente').modal("show");
	$('#modalNuevoCliente').on('shown.bs.modal', function () 
	{
      	$('#dataCapture').focus();
	});
});


$(document).on('keyup', '#email', function() 
{
	var doc = $('#nroDoc').val();

	$.ajax({
		url: 'process.php',
		method: 'POST',
		data: {opcion: "valDoc", doc:doc},
		success: function (data) 
		{
			var jsondata = JSON.parse(data);

			if (jsondata.res == "full" ) 
			{
				for(var i in jsondata.json)
				{
					swal("El cliente ya está registrado", "Agende su cita", "success");
					$('#email').val(jsondata.json[i].email);
					$('#fijo').val(jsondata.json[i].fijo);
					$('#movil').val(jsondata.json[i].movil);
				}
				$('.btnNext2').attr("disabled", true).addClass('disabled');
			}
		}
	});
});



</script>



					
								
								
								
								
								
								