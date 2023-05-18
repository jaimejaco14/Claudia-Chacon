	<?php 
	include(dirname(__FILE__).'/../cnx_data.php');

	switch ($_GET['tipo']) 
	{
		case 'it':
			$estado = 'LLEGADAS TARDE';
			$valor  = '2';
			break;

		case 'st':
			$estado = 'SALIDAS TEMPRANO';
			$valor  = '3';
			break;

		case 'a':
			$estado = 'AUSENCIAS';
			$valor  = '4';
			break;

		case 'pnp':
			$estado = 'PRESENCIAS NO PROGRAMADAS';
			$valor  = '5';
			break;

		case 'inc':
			$estado = 'INCOMPLETOS';
			$valor  = '6';
			break;

		case 'alls':
			$estado = 'TODAS LAS NOVEDADES DEL DÍA';
			break;
		
		default:
			
			break;
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
      <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>REPORTE DETALLADO DE NOVEDADES</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 
</head>

<body>
		<center><legend style="padding-top: 50px"><?php echo "NOVEDADES DE TODOS LOS SALONES" ?> <br> FECHA: <?php echo $_GET['fecha'] ?>
		</legend></center>
	<div class="container" >
		<input type="hidden" value="<?php echo $_GET['tipo']; ?>" id="tipo">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-12">
					<h4 style="text-align: center; font-weight: bold" class="text-primary"><?php echo $estado; ?></h4>
					<div class="table-responsive">
					
						<?php							

							if ($_GET['tipo'] != "e") 
							{
								

									$sln = "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = '1' ORDER BY slnnombre";  

									$Query = mysqli_query($conn, $sln);


									while ($FilasSln = mysqli_fetch_array($Query)) 
									{

										if ($_GET['tipo'] == "alls") 
								        {
								        		$h = "SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, bio.abmnuevotipo,bio.abmhora, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion, TIMEDIFF(bio.abmhora, j.trndesde) AS dif FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo LEFT JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE a.prgfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY) AND a.apcobservacion = '' AND NOT a.aptcodigo = 1 AND a.slncodigo = '".$FilasSln['slncodigo']."' ORDER BY slnnombre";
										
										}
										else
										{
											
											$h = "SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, bio.abmnuevotipo,bio.abmhora, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion, TIMEDIFF(bio.abmhora, j.trndesde) AS dif FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo  JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo LEFT JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE a.prgfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY) AND a.aptcodigo = '".$_GET['valor']."' AND a.slncodigo = '".$FilasSln['slncodigo']."' AND a.apcobservacion = '' ORDER BY trcrazonsocial";
										}



										$QueryLT = mysqli_query($conn, $h);


										if (mysqli_num_rows($QueryLT) > 0) 
										{
											$html.='
												<h5 style="font-weight: bolder">'.$FilasSln['slnnombre'].'</h5>
												<table class="table table-striped table-hover table-bordered">
													<thead>
														<tr>
															<th style="text-align: center">COLABORADOR</th>
															<th style="text-align: center">CARGO</th>
															<th style="text-align: center">PERFIL</th>
															<th style="text-align: center">TURNO</th>
															<th style="text-align: center">TIPO</th>
															<th style="text-align: center">HORA</th>
															<th style="text-align: center">MARCÓ</th>
															<th style="text-align: center">DIFERENCIA</th>
															<th style="text-align: center" id="thTipo">COSTO</th></tr>
													</thead>
										    		<tbody>';
											while ($filas = mysqli_fetch_array($QueryLT)) 
											{

												$html.='
													<tr><td>'.utf8_encode($filas['trcrazonsocial']).'</td><td>'.$filas['crgnombre'].'</td><td>'.$filas['ctcnombre'].'</td><td>'.$filas['desde'].'</td><td>'.$filas['aptnombre'].'</td><td>'.$filas['abmhora'].'</td><td>'.$filas['abmnuevotipo'].'</td><td style="text-align: right">'.$filas['dif'].'</td><td style="text-align: right">'.$filas['apcvalorizacion'].'</td></tr>';								
											}

											if ($_GET['tipo'] == "alls") 
								        	{
								        		$QueryTotal = mysqli_query($conn, "SELECT CONCAT('$',FORMAT(SUM(ap.apcvalorizacion), 0)) AS valor FROM btyasistencia_procesada ap WHERE ap.prgfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY) AND ap.slncodigo= '".$FilasSln['slncodigo']."' AND NOT ap.aptcodigo = 1 "); 
								        	}
								        	else
								        	{
								        		$QueryTotal = mysqli_query($conn, "SELECT CONCAT('$',FORMAT(SUM(ap.apcvalorizacion), 0)) AS valor FROM btyasistencia_procesada ap WHERE ap.prgfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY) AND ap.slncodigo= '".$FilasSln['slncodigo']."' AND ap.aptcodigo = '".$_GET['valor']."'"); 
								        	}

											

											$fetch = mysqli_fetch_array($QueryTotal);


												$html.='
													<tr class="info"><td colspan="8"><b>TOTAL</b></td><td style="color: red; font-size: 1em; text-align: right"><b>'.$fetch['valor'].'</b></td></tr></tbody></table>
												';

										}

									}

									$html.='
												<h5 style="font-weight: bolder">'.$FilasSln['slnnombre'].'</h5>
												<table class="table table-striped table-hover table-bordered">
													<thead>
														<tr class="danger">';

														if ($_GET['tipo'] == "alls") 
								        				{

															$QueryTotal = mysqli_query($conn, "SELECT CONCAT('$', FORMAT(SUM(ap.apcvalorizacion), 0)) AS valor FROM btyasistencia_procesada ap WHERE ap.prgfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY) AND NOT ap.aptcodigo = 1"); 
														}
														else
														{
															$QueryTotal = mysqli_query($conn, "SELECT CONCAT('$',FORMAT(SUM(ap.apcvalorizacion), 0)) AS valor FROM btyasistencia_procesada ap WHERE ap.prgfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY)  AND ap.aptcodigo = '".$_GET['valor']."'"); 
														}

														$fetch = mysqli_fetch_array($QueryTotal);


														$html.='
															<tr class="danger"><td><b>TOTAL TODOS LOS SALONES</b></td><td style="color: red; font-size: 1em; text-align: right"><b>'.$fetch['valor'].'</b></td></tr>
														';
																																		    		
														echo $html;		
							}
							else
							{

								$sln = "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = '1' ORDER BY slnnombre";  

									$Query = mysqli_query($conn, $sln);


									while ($FilasSln = mysqli_fetch_array($Query)) 
									{
										$h = "SELECT ter.trcrazonsocial, crc.crgnombre, ctc.ctcnombre, CONCAT(DATE_FORMAT(trn.trndesde, '%H:%i'), ' a ', DATE_FORMAT(trn.trnhasta, '%H:%i')) AS horario, ab.abmfecha,ab.abmhora,sl.slnnombre, IF(ab.abmtipo='','OTRO',ab.abmtipo) AS estado, ab.abmnuevotipo,ab.abmtipoerror FROM btyasistencia_biometrico ab LEFT JOIN btysalon sl ON sl.slncodigo=ab.slncodigo LEFT JOIN btycolaborador c ON c.clbcodigo=ab.clbcodigo LEFT JOIN btytercero ter ON ter.tdicodigo=c.tdicodigo AND ter.trcdocumento=c.trcdocumento LEFT JOIN btycargo crc ON crc.crgcodigo=c.crgcodigo LEFT JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo LEFT JOIN btyasistencia_procesada ap ON ap.abmcodigo=ab.abmcodigo LEFT JOIN btyturno trn ON trn.trncodigo=ap.trncodigo WHERE ab.slncodigo = '".$FilasSln['slncodigo']."' AND ab.abmerroneo = 1 AND ab.abmfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY)";


											$QueryLT = mysqli_query($conn, $h);

											if (mysqli_num_rows($QueryLT) > 0) 
											{
												$html.='
														<h5 style="font-weight: bolder">'.$FilasSln['slnnombre'].'</h5>
														<table class="table table-striped table-hover table-bordered">
															<thead>
																<tr>
																	<th style="text-align: center">COLABORADOR</th>
																	<th style="text-align: center">CARGO</th>
																	<th style="text-align: center">PERFIL</th>
																	<th style="text-align: center">TURNO</th>
																	<th style="text-align: center">HORA</th>
																	<th style="text-align: center">MARCÓ</th>
																	<th style="text-align: center">COMO</th>
																	<th style="text-align: center">TIPO ERROR</th>						
																</tr>
															</thead>
															<tbody>
													';
												while ($filas = mysqli_fetch_array($QueryLT)) 
												{
													$html.='
														<tr><td>'.utf8_encode($filas['trcrazonsocial']).'</td><td>'.$filas['crgnombre'].'</td><td>'.$filas['ctcnombre'].'</td><td>'.$filas['horario'].'</td><td>'.$filas['abmhora'].'</td><td style="text-align: center">'.$filas['estado'].'</td><td style="text-align: center">'.$filas['abmnuevotipo'].'</td><td style="text-align: center">'.$filas['abmtipoerror'].'</td></tr>
													';
												}

												

												$html.='</tbody>
				            								</table>';
											}

											
											
									}
											echo $html;
							}

								


						 ?>				
					
	            </div>
				</div>

							</div>
		</div>
	</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/core.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>

<style>
	body
	{
		font-family: 'Montserrat', sans-serif;
	}
	td
	{
		font-size: .8em;
	}

	th,td{
		white-space: nowrap;
	}
</style>

<script>
	$(document).ready(function() {
	      $(document).prop('title', 'Citas | Beauty SOFT - ERP');		
	});
</script>

