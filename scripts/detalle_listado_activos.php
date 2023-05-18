<?php 
	include(dirname(__FILE__).'/../cnx_data.php');

	$html='';



	if ($_GET['sbgcodigo'] != 0) 
	{
		$consulta = "SELECT d.tianombre, c.sbtnombre, b.granombre, a.sbganombre FROM btyactivo_subgrupo a JOIN btyactivo_grupo b ON a.gracodigo=b.gracodigo JOIN btyactivo_subtipo c ON c.sbtcodigo=b.sbtcodigo JOIN btyactivo_tipo d ON d.tiacodigo=c.tiacodigo WHERE a.sbgcodigo = '".$_GET['sbgcodigo']."'";

		$queryClas = "SELECT a.actcodigo, a.actnombre, a.actmodelo, a.actespecificaciones, a.actdescripcion FROM btyactivo a JOIN btyactivo_prioridad b ON b.pracodigo=a.pracodigo JOIN btyactivo_marca c ON c.marcodigo=a.marcodigo JOIN btyactivo_subgrupo d ON d.sbgcodigo=a.sbgcodigo JOIN btyproveedor e ON e.prvcodigo=a.prvcodigo JOIN btypais f ON f.paicodigo=a.paicodigo JOIN btyactivo_fabricante g ON g.fabcodigo=a.fabcodigo JOIN btyactivo_unidad h ON h.unacodigo=a.unacodigo_tiempo JOIN btyactivo_unidad i ON i.unacodigo=a.unacodigo_uso WHERE a.sbgcodigo = '".$_GET['sbgcodigo']."' ORDER BY a.actnombre";
	}
	else
	{
		$consulta = "";

		$queryClas = "SELECT a.actcodigo, a.actnombre, a.actmodelo, a.actespecificaciones, a.actdescripcion FROM btyactivo a JOIN btyactivo_prioridad b ON b.pracodigo=a.pracodigo JOIN btyactivo_marca c ON c.marcodigo=a.marcodigo JOIN btyactivo_subgrupo d ON d.sbgcodigo=a.sbgcodigo JOIN btyproveedor e ON e.prvcodigo=a.prvcodigo JOIN btypais f ON f.paicodigo=a.paicodigo JOIN btyactivo_fabricante g ON g.fabcodigo=a.fabcodigo JOIN btyactivo_unidad h ON h.unacodigo=a.unacodigo_tiempo JOIN btyactivo_unidad i ON i.unacodigo=a.unacodigo_uso ORDER BY a.actnombre";
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
      <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>REPORTE DETALLADO DE ACTIVOS</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 
</head>

<body>
		<center>
			<legend style="padding-top: 50px">
			<?php



				$query = mysqli_query($conn, $consulta);

				$clase = mysqli_fetch_array($query);

				echo 'LISTADO DE ACTIVOS';
			?>
			 </legend>
		</center>

	<div class="container" >
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-12">
					<div class="table-responsive">
						<?php 
							echo '<center><b>CLASIFICACIÓN: ' . $clase['tianombre'] . " | " . $clase['sbtnombre'] . " | " . $clase['granombre'] . " | " .  $clase['sbganombre'] . "</b></center>" ;
						?>
						<br>
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>CÓDIGO</th>
									<th>NOMBRE ACTIVO</th>
									<th>MODELO</th>
									<th>ESPECIFICACIONES</th>
									<th>DESCRIPCIÓN</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$sql = mysqli_query($conn, $queryClas);

										while ($row = mysqli_fetch_array($sql)) 
										{
											$html.='
												<tr>
													<td style="text-align: right">'.$row['actcodigo'].'</td>
													<td>'.$row['actnombre'].'</td>
													<td>'.$row['actmodelo'].'</td>
													<td>'.$row['actespecificaciones'].'</td>
													<td>'.$row['actdescripcion'].'</td>
												</tr>
											';
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

