<?php 
	include(dirname(__FILE__).'/../cnx_data.php');

	$Query = mysqli_query($conn, "SELECT slnnombre FROM btysalon WHERE slncodigo = '".$_GET['slncodigo']."' AND slnestado = '1'");

	$row = mysqli_fetch_array($Query);

	$salonNombre = $row['slnnombre'];

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
		<center><legend style="padding-top: 50px"><?php echo "NOVEDADES DE " . $salonNombre;  ?> <br> FECHA: <?php echo $_GET['fecha'] ?>
		</legend></center>
	<div class="container" >
		<input type="hidden" value="<?php echo $_GET['tipo']; ?>" id="tipo">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-12">
					<h4><?php echo $estado; ?></h4>
					<div class="table-responsive">
					
						<?php							

							$html="";

							// COLABORADORES NOVEDADES IT

							if ($_GET['tipo'] != "e") 
							{

								$html.='
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
												<th style="text-align: center" id="thTipo">COSTO</th></tr>';		
											
										$html.='</thead>
										           <tbody>';
								

								if ($_GET['tipo'] == "alls") 
								{
									$h = "
									(
										SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, bio.abmnuevotipo,bio.abmhora, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON  t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo in (2, 3) AND a.slncodigo = '".$_GET['slncodigo']."' ORDER BY t.trcrazonsocial 

		                            			) 
										UNION
									(
										SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS aptnombre, '','', j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND a.abmcodigo IS NULL AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo IN( 4,6) AND a.slncodigo = '".$_GET['slncodigo']."' ORDER BY t.trcrazonsocial
									) 
	

									UNION
									(
										SELECT a.abmcodigo, a.clbcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre,f.aptnombre,a.prgfecha, NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL FROM btyasistencia_procesada a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo JOIN btyasistencia_procesada_tipo f ON f.aptcodigo=a.aptcodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND a.aptcodigo = 5 AND a.slncodigo = '".$_GET['slncodigo']."'
									)

										UNION
									(
										SELECT a.abmcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre, a.abmtipo as marco_como, a.abmtipoerror, a.abmnuevotipo, a.abmfecha, a.abmhora, NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL FROM btyasistencia_biometrico a JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo WHERE MONTH(a.abmfecha) = MONTH(CURDATE()) AND a.abmerroneo = 1  AND a.slncodigo = '".$_GET['slncodigo']."') ORDER BY trcrazonsocial";
								}
								else
								{

									$h = "SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, bio.abmnuevotipo,bio.abmhora, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo IN (2) AND a.slncodigo = '".$_GET['slncodigo']."' ORDER BY t.trcrazonsocial ";

								}
								

								$QueryLT = mysqli_query($conn, $h);

								if (mysqli_num_rows($QueryLT) > 0) 
								{
									while ($filas = mysqli_fetch_array($QueryLT)) 
									{
										$html.='
											<tr><td>'.utf8_encode($filas['trcrazonsocial']).'</td><td>'.$filas['crgnombre'].'</td><td>'.$filas['ctcnombre'].'</td><td>'.$filas['desde'].'</td><td>'.$filas['aptnombre'].'</td><td>'.$filas['abmhora'].'</td><td>'.$filas['abmnuevotipo'].'</td><td style="text-align: right">'.$filas['apcvalorizacion'].'</td>';

													
											
									
									}

									if ($_GET['tipo'] == "alls") 
									{
										$QueryTotal = mysqli_query($conn, "SELECT CONCAT('$', FORMAT(SUM(ap.apcvalorizacion), 0)) AS valor FROM btyasistencia_procesada ap WHERE ap.prgfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY) AND ap.slncodigo= '".$_GET['slncodigo']."' ");
									}
									else
									{

										$QueryTotal = mysqli_query($conn, "SELECT CONCAT('$',FORMAT(SUM(ap.apcvalorizacion), 0)) AS valor FROM btyasistencia_procesada ap WHERE ap.prgfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY) AND ap.slncodigo= '".$_GET['slncodigo']."' AND ap.aptcodigo = '".$_GET['valor']."'");
									}

										$fetch = mysqli_fetch_array($QueryTotal);


										$html.='
											<tr class="info"><td colspan="7"><b>TOTAL</b></td><td style="color: red; font-size: 1em; text-align: right"><b>'.$fetch['valor'].'</b></td></tr>
										';
								}
								else
								{
									$html.='
											<tr><td colspan="8"><center><b>NO SE REGISTRAN DATOS</b></center></td></tr>
											</tbody>
	            								</table>
										';
								}
								
							}
							else
							{

								$h = "SELECT ter.trcrazonsocial, crc.crgnombre, ctc.ctcnombre, CONCAT(DATE_FORMAT(trn.trndesde, '%H:%i'), ' a ', DATE_FORMAT(trn.trnhasta, '%H:%i')) AS horario, ab.abmfecha,ab.abmhora,sl.slnnombre, IF(ab.abmtipo='','OTRO',ab.abmtipo) AS estado, ab.abmnuevotipo,ab.abmtipoerror FROM btyasistencia_biometrico ab LEFT JOIN btysalon sl ON sl.slncodigo=ab.slncodigo LEFT JOIN btycolaborador c ON c.clbcodigo=ab.clbcodigo LEFT JOIN btytercero ter ON ter.tdicodigo=c.tdicodigo AND ter.trcdocumento=c.trcdocumento LEFT JOIN btycargo crc ON crc.crgcodigo=c.crgcodigo LEFT JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo LEFT JOIN btyasistencia_procesada ap ON ap.abmcodigo=ab.abmcodigo LEFT JOIN btyturno trn ON trn.trncodigo=ap.trncodigo WHERE ab.slncodigo = '".$_GET['slncodigo']."' AND ab.abmerroneo = 1 AND ab.abmfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY)";

								$html.='
									<h4>REGISTROS ERRÓNEOS	</h4>
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

								$QueryLT = mysqli_query($conn, $h);

								if (mysqli_num_rows($QueryLT) > 0) 
								{
									while ($filas = mysqli_fetch_array($QueryLT)) 
									{
										$html.='
											<tr><td>'.utf8_encode($filas['trcrazonsocial']).'</td><td>'.$filas['crgnombre'].'</td><td>'.$filas['ctcnombre'].'</td><td>'.$filas['horario'].'</td><td>'.$filas['abmhora'].'</td><td style="text-align: center">'.$filas['estado'].'</td><td style="text-align: center">'.$filas['abmnuevotipo'].'</td><td style="text-align: center">'.$filas['abmtipoerror'].'</td></tr>
										';
									}

									
								}
								else
								{
									$html.='
											<tr><td colspan="8"><center>NO SE REGISTRAN DATOS</center></td></tr>
											</tbody>
	            								</table>
										';
								}
							}	

							echo $html;


						 ?>				
					</tbody>
	            </table>
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

