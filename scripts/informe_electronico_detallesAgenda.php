<?php 
	include(dirname(__FILE__).'/../cnx_data.php');

	$Query = mysqli_query($conn, "SELECT b.trcrazonsocial FROM btycolaborador a JOIN btytercero b ON a.trcdocumento=b.trcdocumento AND a.tdicodigo=b.tdicodigo WHERE a.clbcodigo = '".$_GET['colaborador']."'");

	$row = mysqli_fetch_array($Query);

	$colaborador = utf8_encode($row['trcrazonsocial']);

	$SqlFecha=mysqli_query($conn, "SET lc_time_names = 'es_CO'");

	$SqlFecha=mysqli_query($conn, "SELECT UCASE(DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -1 DAY), '%M')) AS Mes, DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -1 DAY), '%Y') AS Ano, DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -1 DAY), '%d') AS DiaNumero, UCASE(DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -1 DAY), '%W')) AS DiaNombre, MONTH(DATE_ADD(CURDATE(), INTERVAL -1 DAY)) AS MES, DATE_ADD(CURDATE(), INTERVAL -1 DAY)AS FECHA");

	$RsFecha = mysqli_fetch_array($SqlFecha);



 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>REPORTE DETALLADO POR COLABORADOR</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 
</head>
<body>
		<center><h4 style="padding-top: 50px"><?php echo "REPORTE DE <br><b>" . $colaborador . "</b><br>  FECHA " . $RsFecha['DiaNumero'] . " DE " . $RsFecha['Mes'] . " DE " . $RsFecha['Ano']; ?>
		</h4></center>
	<div class="container" >
		<div class="row">
			<div class="col-md-12">
					<div class="table-responsive">
					<h4 style="text-align: center"><b>CITAS</b></h4>
					<table class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th style="text-align: left">CÓD CITA</th>
							<th style="text-align: left;">SERVICIO</th>
							<th style="text-align: left;">CLIENTE</th>
							<th style="text-align: left;">FECHA</th>
							<th style="text-align: left;">HORA</th>
							<th style="text-align: left;">FECHA REGISTRO</th>
							<th style="text-align: left;">HORA REGISTRO</th>
							<th style="text-align: left;">AGENDADA POR</th>
							<th style="text-align: center;">ESTADO</th>							
						</tr>
					</thead>
					<tbody>
						<?php 

$r = "SELECT a.citcodigo, t1.trcrazonsocial AS colaborador, sal.slnnombre, CONCAT(ser.sernombre, ' ', ser.serduracion, ' MIN')AS servicio, t2.trcrazonsocial AS cliente, cli.cliemail, a.citfecha, a.cithora, a.citfecharegistro, a.cithoraregistro, t3.trcrazonsocial AS usuario, a.citobservaciones FROM btycita a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero t1
ON t1.tdicodigo=b.tdicodigo AND t1.trcdocumento=b.trcdocumento JOIN btyservicio ser ON ser.sercodigo=a.sercodigo JOIN btycliente cli
ON cli.clicodigo=a.clicodigo JOIN btytercero t2 ON t2.tdicodigo=cli.tdicodigo AND t2.trcdocumento=cli.trcdocumento JOIN btyusuario usu
ON usu.usucodigo=a.usucodigo JOIN btytercero t3 ON t3.tdicodigo=usu.tdicodigo AND t3.trcdocumento=usu.trcdocumento JOIN btysalon sal
ON sal.slncodigo=a.slncodigo WHERE a.slncodigo = '".$_GET['slncodigo']."' AND a.clbcodigo = '".$_GET['colaborador']."' AND a.citfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY) ORDER BY a.citfecha, a.cithora";

$sql = mysqli_query($conn, $r);

		$mensaje = "";

		if (mysqli_num_rows($sql) > 0) 
		{
			while ($row = mysqli_fetch_array($sql)) 
			{

				
				$queryEstado = mysqli_query($conn, "SELECT MAX(a.esccodigo) AS codEstado, b.escnombre FROM btynovedad_cita a JOIN btyestado_cita b ON a.esccodigo=b.esccodigo WHERE a.citcodigo = '".$row['citcodigo']."' GROUP BY a.esccodigo ORDER BY a.esccodigo DESC LIMIT 1");

				$filas = mysqli_fetch_array($queryEstado);


				$mensaje.='
					<tr>
						<td style="text-align: right">'.$row['citcodigo'].'</td>
						<td>'.$row['servicio'].'</td>
						<td>'.$row['cliente'].'</td>
						<td style="text-align: center">'.$row['citfecha'].'</td>
						<td style="text-align: center">'.$row['cithora'].'</td>
						<td style="text-align: center">'.$row['citfecharegistro'].'</td>
						<td style="text-align: center">'.$row['cithoraregistro'].'</td>
						<td>'.$row['usuario'].'</td>';

						if ($filas['escnombre'] == 'ATENDIDA') 
						{
							$mensaje.='<td><label class="label label-success">'.$filas['escnombre'].'</label></td>';					
						}
						else
						{
							if ($filas['escnombre'] == 'CANCELADA') 
							{
								$mensaje.='<td><label class="label label-danger">'.$filas['escnombre'].'</label></td>';
							}
							else
							{
								if ($filas['escnombre'] == 'REPROGRAMADA') 
								{
									$mensaje.='<td><label class="label label-info">'.$filas['escnombre'].'</label></td>';
								}
								else
								{
									if ($filas['escnombre'] == 'INASISTENCIA') 
									{
										$mensaje.='<td><label class="label label-primary">'.$filas['escnombre'].'</label></td>';
									}
									else
									{
										if ($filas['escnombre'] == 'AGENDADA POR FUNCIONARIO') 
										{
											$mensaje.='<td><label class="label label-warning">'.$filas['escnombre'].'</label></td>';
										}
									}
								}
							}
						}
						
					$mensaje.='</tr>';
				
			}

			echo $mensaje;
		}
		else
		{
			$mensaje.='<tr><td colspan="9"><b><center>NO HAY DATOS PARA LA FECHA</center></b></td></tr>';
			echo $mensaje;
		}
														
							

						?>
				
					</tbody>
				</table>
				</div> 
			</div>
			<div class="col-md-12">
				<div class="table-responsive">
					<h4 style="text-align: center"><b>NOVEDADES</b></h4>
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th style="text-align: left">CÓD CITA</th>
								<th style="text-align: left;">SERVICIO</th>
								<th style="text-align: left;">CLIENTE</th>
								<th style="text-align: left;">FECHA</th>
								<th style="text-align: left;">HORA</th>
								<th style="text-align: left;">FECHA REGISTRO</th>
								<th style="text-align: left;">HORA REGISTRO</th>
								<th style="text-align: left;">AGENDADA POR</th>
								<th style="text-align: center;">ESTADO</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>regstros novedades</td>
								<td>regstros novedades</td>
								<td>regstros novedades</td>
								<td>regstros novedades</td>
								<td>regstros novedades</td>
								<td>regstros novedades</td>
								<td>regstros novedades</td>
								<td>regstros novedades</td>
								<td>regstros novedades</td>
							</tr>
						</tbody>
					</table>
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
	td, th
	{
		font-size: .8em;
		white-space: nowrap;
	}

	th
</style>

<script>
	$(document).ready(function() {
	      $(document).prop('title', 'Citas | Beauty SOFT - ERP');		
	});
</script>