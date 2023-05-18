<?php 
	include(dirname(__FILE__).'/../cnx_data.php');

	$Query = mysqli_query($conn, "SELECT slnnombre FROM btysalon WHERE slncodigo = '".$_GET['slncodigo']."' AND slnestado = '1'");

	$row = mysqli_fetch_array($Query);

	$salonNombre = $row['slnnombre'];

	switch ($_GET['rango']) 
	{
		case 'dia':
			$QueryDate=mysqli_query($conn, "SET lc_time_names = 'es_CO'");
			$fecha =  " AND a.citfecharegistro='".$_GET['fecha']."' ";
			$QueryDate = mysqli_query($conn, "SELECT UCASE(DATE_FORMAT('".$_GET['fecha']."', '%d de %M de %Y'))AS dia");
			$f = mysqli_fetch_array($QueryDate);
			$QueryMes = $f[0];
			$dateHead =$QueryMes;
			break;

		case 'mes':
			$QueryDate=mysqli_query($conn, "SET lc_time_names = 'es_CO'");
			$fecha =  " AND MONTH(a.citfecharegistro)='".$_GET['valor']."' ";
			$QueryDate = mysqli_query($conn, "SELECT UCASE(DATE_FORMAT('0000-".$_GET['valor']."-00', '%M'))");
			$f = mysqli_fetch_array($QueryDate);
			$QueryMes = $f[0];
			$dateHead = "MES: " .$QueryMes;
			break;

		case 'ano':
			$QueryDate = mysqli_query($conn, "SELECT DATE_FORMAT('".$_GET['valor']."-00-00', '%Y')");
			$f = mysqli_fetch_array($QueryDate);
			$QueryMes = $f[0];
			$fecha =  " AND YEAR(a.citfecharegistro)='".$_GET['valor']."' ";
			$dateHead = "AÑO: " . $QueryMes;
			break;
		
		default:
			
			break;
	}

	if ($_GET['slncodigo'] != 0) 
	{
		$salon = " WHERE a.slncodigo = ".$_GET['slncodigo'] ;
		$salonNombre = "CITAS SALÓN " . $salonNombre;
	}
	else
	{
		$salon = "";
		$salonNombre = "TODOS LOS SALONES";
	}



	//echo "<script>alert(".$_GET['slncodigo'].");</script>";

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>REPORTE DETALLADO DE CITAS</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 
</head>
<body>
		<center><legend style="padding-top: 50px"><?php echo $salonNombre; ?> <br> <?php echo $dateHead; ?>
		</legend></center>
	<div class="container" >
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-6">
					<h4>AGENDADAS POR</h4>
					<div class="table-responsive">
					<table class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th style="text-align: left">FUNCIONARIO</th>
							<th style="text-align: left">CARGO</th>
							<th style="text-align: right">CANTIDAD</th>							
						</tr>
					</thead>
					<tbody>
						<?php 

							if ($_GET['slncodigo'] != 0) 
							{
								$r = "SELECT * FROM btycita a WHERE a.slncodigo = '".$_GET['slncodigo']."' ".$fecha;
							}
							else
							{
								$r = str_replace("AND", "WHERE", "SELECT * FROM btycita a ".$fecha);
							}
							

							$QueryCol = mysqli_query($conn, $r);

							$html="";

							if (mysqli_num_rows($QueryCol) > 0) 
							{

								if ($_GET['slncodigo'] != 0) 
								{
									$SqlFuncionario = "SELECT t.trcrazonsocial, cr.crgnombre, count(*) as cantidad from btycita as a, btyusuario as u, btytercero as t, btycolaborador as c, btycargo as cr where a.slncodigo='".$_GET['slncodigo']."' and u.usucodigo=a.usucodigo and t.tdicodigo=u.tdicodigo and t.trcdocumento=u.trcdocumento and c.trcdocumento=t.trcdocumento and c.tdicodigo=t.tdicodigo and c.crgcodigo=cr.crgcodigo ".$fecha." group by t.trcrazonsocial,  cr.crgnombre order by cantidad desc";
								}
								else
								{
									$SqlFuncionario = "SELECT t.trcrazonsocial, cr.crgnombre, count(*) as cantidad from btycita as a, btyusuario as u, btytercero as t, btycolaborador as c, btycargo as cr where u.usucodigo=a.usucodigo and t.tdicodigo=u.tdicodigo and t.trcdocumento=u.trcdocumento and c.trcdocumento=t.trcdocumento and c.tdicodigo=t.tdicodigo and c.crgcodigo=cr.crgcodigo ".$fecha." group by t.trcrazonsocial,  cr.crgnombre order by cantidad desc";
								}
								
								$RsFuncionario = mysqli_query($conn, $SqlFuncionario);

							
								$SumFuncionario=0;

								while ($DatFuncionario = mysqli_fetch_array($RsFuncionario)) 
								{		

									$html.='
										<tr>
											<td>'.utf8_encode($DatFuncionario[0]).'</td><td style="text-align: left">'.$DatFuncionario[1].'</td><td style="text-align: right">'.$DatFuncionario[2].'</td>
										</tr>
									';
									$SumFuncionario=$SumFuncionario+$DatFuncionario[2];

								}

								$html.='
										<tr class="info">
											<td>TOTAL</td><td style="text-align: right; font-weight: bold" colspan="2">'.$SumFuncionario.'</td>
										</tr>
									';
							}
							else
							{
								$html.='
									<tr>
										<td style="text-align: center" colspan="4">NO HAY REGISTROS PARA LA FECHA</td>
									</tr>
								';
							}								

								echo $html;									

						 ?>				
					</tbody>
	            </table>
	            </div>
				</div>

				<div class="col-md-6">
					<h4>COLABORADOR</h4>
					<div class="table-responsive">
					<table class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th>COLABORADOR</th>
							<th style="text-align: left">CARGO</th>
							<th style="text-align: left">PERFIL</th>
							<th style="text-align: right">CANTIDAD</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							if ($_GET['slncodigo'] != 0) 
							{
								$r = "SELECT * FROM btycita a WHERE a.slncodigo = '".$_GET['slncodigo']."' ".$fecha;
							}
							else
							{
								$r = str_replace("AND", "WHERE", "SELECT * FROM btycita a ".$fecha);
							}



							$QueryCanCol = mysqli_query($conn, $r);

							$htmlCantCol="";

							if (mysqli_num_rows($QueryCanCol) > 0) 
							{

								if ($_GET['slncodigo'] != 0) 
								{
									$QuColaborador ="SELECT t.trcrazonsocial, cr.crgnombre, p.ctcnombre, count(*) as cantidad from btycita as a, btytercero as t, btycolaborador as c, btycargo as cr, btycategoria_colaborador as p where a.slncodigo='".$_GET['slncodigo']."' and a.clbcodigo=c.clbcodigo and c.trcdocumento=t.trcdocumento and c.tdicodigo=t.tdicodigo and c.crgcodigo=cr.crgcodigo and p.ctccodigo=c.ctccodigo ".$fecha." group by t.trcrazonsocial, cr.crgnombre, p.ctcnombre  order by cantidad desc";
								}
								else
								{
									$QuColaborador ="SELECT t.trcrazonsocial, cr.crgnombre, p.ctcnombre, count(*) as cantidad from btycita as a, btytercero as t, btycolaborador as c, btycargo as cr, btycategoria_colaborador as p where  a.clbcodigo=c.clbcodigo and c.trcdocumento=t.trcdocumento and c.tdicodigo=t.tdicodigo and c.crgcodigo=cr.crgcodigo and p.ctccodigo=c.ctccodigo ".$fecha." group by t.trcrazonsocial, cr.crgnombre, p.ctcnombre  order by cantidad desc";
								}

									
										$RsColaborador=mysqli_query($conn,$QuColaborador);
										
										$SumColaborador=0;

								while ($DatColaborador = mysqli_fetch_array($RsColaborador)) 
								{
								

									$htmlCantCol.='
										<tr>
											<td>'.utf8_encode($DatColaborador[0]).'</td><td style="text-align: left">'.$DatColaborador[1].'</td><td style="text-align: left">'.$DatColaborador[2].'</td><td style="text-align: right">'.$DatColaborador[3].'</td>
										</tr>
									';
									$SumColaborador=$SumColaborador+$DatColaborador[3];
								}


								$htmlCantCol.='
										<tr class="info">
										<td>TOTAL</td><td style="text-align: right; font-weight: bold" colspan="3">'.$SumColaborador.'</td>
										</tr>
									';

								
							}
							else
							{
								$htmlCantCol.='
									<tr>
										<td style="text-align: center" colspan="4">NO HAY REGISTROS PARA LA FECHA</td>
									</tr>
								';
							}
								echo $htmlCantCol;									

						 ?>

					</tbody>
	            </table>
	            </div>
				</div>

				<!-- /***************   SEVICIOS   ***************/ -->

				 <div class="col-md-6">
					<h4>SERVICIOS</h4>
					<div class="table-responsive">
					<table class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th>SERVICIO</th>
							<th style="text-align: right">CANTIDAD</th>
						</tr>
					</thead>
					<tbody>
						<?php 

							if ($_GET['slncodigo'] != 0) 
							{
								$serVicio =  "SELECT * FROM btycita a WHERE a.slncodigo = '".$_GET['slncodigo']."' ".$fecha." ";
							}
							else
							{
								$serVicio = str_replace("AND", "WHERE", "SELECT * FROM btycita a ".$fecha);
							}

							$QueryCanCol = mysqli_query($conn, $serVicio);
							
				
							$htmlServicios="";
				
							if (mysqli_num_rows($QueryCanCol) > 0) 
							{
								$SumServicios=0;

								if ($_GET['slncodigo'] != 0) 
								{
									$QuServicios="SELECT s.sernombre, count(*) as cantidad from btycita as a, btyservicio as s where a.slncodigo='".$_GET['slncodigo']."' and s.sercodigo=a.sercodigo ".$fecha." group by s.sernombre order by cantidad desc";
								}
								else
								{
									$QuServicios="SELECT s.sernombre, count(*) as cantidad from btycita as a, btyservicio as s where s.sercodigo=a.sercodigo ".$fecha." group by s.sernombre order by cantidad desc";
								}

								
								//echo $QuServicios;

								$RsServicios=mysqli_query($conn,$QuServicios);


								while ($DatServicios = mysqli_fetch_array($RsServicios)) 
								{
										
									$htmlServicios.='
										<tr>
											<td>'.utf8_encode($DatServicios[0]).'</td><td style="text-align: right">'.$DatServicios[1].'</td>
										</tr>
									';			
										$SumServicios=$SumServicios+$DatServicios[1];
								}

								$htmlServicios.='
									<tr class="info">
										<td>TOTAL</td><td style="text-align: right; font-weight: bold">'.$SumServicios.'</td>
										</tr>
									';
				
							}
							else
							{
								$htmlServicios.='
									<tr>
										<td style="text-align: center" colspan="2">NO HAY REGISTROS PARA LA FECHA</td>
									</tr>
								';
							}
				
								echo $htmlServicios;									
						 ?>
				
					</tbody>
					</table>
					</div>
				</div> 

				<!-- /**************  TIEMPO  **************/ -->

				 <div class="col-md-6">
					<h4>CITAS AGENDADAS</h4>
					<div class="table-responsive">
					<table class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th>No. DÍAS</th>
							<th style="text-align: right">CANTIDAD</th>
						</tr>
					</thead>
					<tbody>
						<?php 


							if ($_GET['slncodigo'] != 0) 
							{
								$R1="(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a where a.slncodigo='".$_GET['slncodigo']."' ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia='0') AS R1";

								$R2="(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a where a.slncodigo='".$_GET['slncodigo']."' ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia='1') AS R2";

								$R3="(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a where a.slncodigo='".$_GET['slncodigo']."' ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia>='2' and diferencia<='3') AS R3";

								$R4="(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a where a.slncodigo='".$_GET['slncodigo']."' ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia>='4' and diferencia<='7') AS R4";

								$R5="(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a where a.slncodigo='".$_GET['slncodigo']."' ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia>='8' and diferencia<='15') AS R5";

								$R6="(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a where a.slncodigo='".$_GET['slncodigo']."' ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia>='16' and diferencia<='30') AS R6";	
								    

								$R7="(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a where a.slncodigo='".$_GET['slncodigo']."' ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia>='31') AS R7";
							}
							else
							{
								$R1 = str_replace("AND", "WHERE", "(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a  ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia='0') AS R1");

								//*echo $R1;
								

								//$R1="(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a  ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia='0') AS R1";

								$R2 = str_replace("AND", "WHERE", "(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a  ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia='1') AS R2");

								//$R2="(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a where a.slncodigo='".$_GET['slncodigo']."' ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia='1') AS R2";

								
								$R3 = str_replace("AND", "WHERE", "(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia>='2' and diferencia<='3') AS R3");


								//$R3="(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a where a.slncodigo='".$_GET['slncodigo']."' ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia>='2' and diferencia<='3') AS R3";

								$R4 = str_replace("AND", "WHERE", "(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia>='4' and diferencia<='7') AS R4");


								//$R4="(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a where a.slncodigo='".$_GET['slncodigo']."' ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia>='4' and diferencia<='7') AS R4";

								$R5 = str_replace("AND", "WHERE", "(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia>='8' and diferencia<='15') AS R5");

								//$R5="(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a where a.slncodigo='".$_GET['slncodigo']."' ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia>='8' and diferencia<='15') AS R5";

								$R6 = str_replace("AND", "WHERE", "(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia>='16' and diferencia<='30') AS R6");

								//$R6="(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a where a.slncodigo='".$_GET['slncodigo']."' ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia>='16' and diferencia<='30') AS R6";

								$R7 = str_replace("AND", "WHERE", "(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia>='31') AS R7");
	
								    

								//$R7="(SELECT IFNULL(SUM(cantidad),0) FROM (SELECT count(*) as cantidad, DATEDIFF(a.citfecha, a.citfecharegistro) as diferencia FROM btycita AS a where a.slncodigo='".$_GET['slncodigo']."' ".$fecha." GROUP BY diferencia) AS TABLA WHERE diferencia>='31') AS R7";
							}


						    								    				    

						    $QuTiempo="SELECT ".$R1." ,".$R2." ,".$R3." ,".$R4." ,".$R5." ,".$R6." ,".$R7;
							
							$RsTiempo = mysqli_fetch_array(mysqli_query($conn, $QuTiempo));

							$SumTiempo=$RsTiempo[0]+$RsTiempo[1]+$RsTiempo[2]+$RsTiempo[3]+$RsTiempo[4]+$RsTiempo[5]+$RsTiempo[6];

							$htmlTiempo="";
							
								$htmlTiempo.='
									<tr class="">
									<td>MISMO DÍA</td><td style="text-align: right;">'.$RsTiempo[0].'</td>
									</tr>

									<tr class="">
									<td>DÍA SIGUIENTE</td><td style="text-align: right;">'.$RsTiempo[1].'</td>					
									</tr>

									<tr class="">
									<td>2 A 3 DÍAS</td><td style="text-align: right;">'.$RsTiempo[2].'</td>
									</tr>

									<tr class="">
									<td>4 A 7 DÍAS</td><td style="text-align: right;">'.$RsTiempo[3].'</td>					
									</tr>

									<tr class="">
									<td>8 A 15 DÍAS</td><td style="text-align: right;">'.$RsTiempo[4].'</td>					
									</tr>

									<tr class="">
									<td>16 A 30 DÍAS</td><td style="text-align: right;">'.$RsTiempo[5].'</td>					
									</tr>

									<tr class="">
									<td>> 30 DÍAS</td><td style="text-align: right;">'.$RsTiempo[6].'</td>					
									</tr>

									<tr class="info">
									<td>TOTAL</td><td style="text-align: right; font-weight: bold">'.$SumTiempo.'</td>					
									</tr>';

								echo $htmlTiempo;									
							
				
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
</style>

<script>
	$(document).ready(function() {
	      $(document).prop('title', 'Citas | Beauty SOFT - ERP');		
	});
</script>