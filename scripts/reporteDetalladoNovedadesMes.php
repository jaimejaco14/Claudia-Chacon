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
			$estadoM = 'TODAS LAS NOVEDADES DEL MES';
			break;
		
		default:
			
			break;
	}

	$mes = date('F', strtotime($_GET['fecha']));
		$semana = array(
		'January'  	=> 'ENERO' ,
		'February' 	=> 'FEBRERO',
		'March'     => 'MARZO',
		'April'     => 'ABRIL',
		'May' 	=> 'MAYO',
		'June' 	=> 'JUNIO',
		'July' 	=> 'JULIO',
		'August' 	=> 'AGOSTO',
		'September' => 'SEPTIEMBRE',
		'October' 	=> 'OCTUBRE',
		'November' 	=> 'NOVIEMBRE',
		'December' 	=> 'DICIEMBRE',
	);

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
      <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" /> 
</head>

<body>
	<center>
		<legend style="padding-top: 50px"><?php echo "NOVEDADES DE " . $salonNombre;  ?> <br> MES : <?php $mes = $semana[$mes]; echo $mes; ?></legend>
	</center>

	<div class="container" >
		<input type="hidden" value="<?php echo $_GET['tipo']; ?>" id="tipo">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-12">
					<h4><?php 
						if ($_GET['tipo'] == "alls" AND $_GET['val'] == "mes") 
						{							
							echo $estadoM; 
						}
						else
						{
							echo $estado; 
						}

						?>
						
						</h4>

						<div class="table-responsive">
					
<?php							

	$html="";

	// COLABORADORES NOVEDADES IT

	$sql=mysqli_query($conn,"SELECT DISTINCT a.clbcodigo, c.trcrazonsocial FROM btyasistencia_procesada a JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.slncodigo = '".$_GET['slncodigo']."' AND MONTH(a.prgfecha) = MONTH(CURDATE()) ORDER BY c.trcrazonsocial");

		$array = array();

		if(mysqli_num_rows($sql) > 0)
		{

			if ($_GET['tipo'] != "alls")  
			{
						if ($_GET['tipo'] != "e") 
						{
							
						

							$html.='
							<table class="table table-striped table-hover table-bordered" id="tblListado">
								<thead>
									<tr>
										<th style="text-align: center">COLABORADOR</th>
										<th style="text-align: center">CARGO</th>
										<th style="text-align: center">PERFIL</th>
										<th style="text-align: center">TOTAL</th>
										<th style="text-align: center">CANTIDAD</th>
									</tr>
								</thead>
								<tbody>';

							while ($row = mysqli_fetch_array($sql)) 
							{

								$f =  "SELECT DISTINCT a.clbcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre, (SELECT COUNT(ap.aptcodigo) FROM btyasistencia_procesada ap WHERE ap.slncodigo = '".$_GET['slncodigo']."' AND MONTH(ap.prgfecha) = MONTH(CURDATE()) AND ap.clbcodigo = '".$row['clbcodigo']."' AND ap.apcobservacion = '' AND NOT ap.aptcodigo = 1 AND ap.aptcodigo = '".$_GET['valor']."') AS cantidad, (SELECT CONCAT('$', FORMAT(SUM(a.apcvalorizacion),0)) FROM btyasistencia_procesada a WHERE a.clbcodigo = '".$row['clbcodigo']."' AND MONTH(a.prgfecha) = MONTH(CURDATE()) AND NOT a.aptcodigo = 1  AND a.aptcodigo = '".$_GET['valor']."' AND a.apcobservacion = ''  AND a.slncodigo = '".$_GET['slncodigo']."') AS total FROM btyasistencia_procesada a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo WHERE a.slncodigo = '".$_GET['slncodigo']."' AND MONTH(a.prgfecha) = MONTH(CURDATE()) AND a.clbcodigo = '".$row['clbcodigo']."' AND a.aptcodigo = '".$_GET['valor']."'";

								$QueryCantidad = mysqli_query($conn,$f);




								while($data = mysqli_fetch_array($QueryCantidad))
						    		{
						        		$html.='
										<tr>
											<td>'.utf8_encode($data['trcrazonsocial']).'</td>
											<td>'.utf8_encode($data['crgnombre']).'</td>
											<td>'.utf8_encode($data['ctcnombre']).'</td>
											<td style="text-align: right">'.$data['total'].'</td>
											<td><center><button class="btn btn-info btn-xs" data-clbcodigo="'.$data['clbcodigo'].'" data-slncodigo="'.$_GET['slncodigo'].'" data-aptcodigo="'.$_GET['valor'].'" id="btnVerDetalles">'.$data['cantidad'].'</button></center></td>
										</tr>
						        		';
						    			
								}



							}
								$QueryTotal = mysqli_query($conn, "SELECT CONCAT('$', FORMAT(SUM(ap.apcvalorizacion), 0)) AS valor FROM btyasistencia_procesada ap WHERE MONTH(ap.prgfecha) = MONTH(CURDATE()) AND ap.slncodigo= '".$_GET['slncodigo']."' AND ap.aptcodigo = '".$_GET['valor']."' ");

								$fetch = mysqli_fetch_array($QueryTotal);


								$html.='
									<tr><td colspan="3"><b>TOTAL</b></td><td style="color: red; font-size: 1em; text-align: right"><b>'.$fetch['valor'].'</b></td>';
								
								$QueryTotalNov = mysqli_query($conn, "SELECT COUNT(ap.aptcodigo)as can FROM btyasistencia_procesada ap WHERE ap.slncodigo = '".$_GET['slncodigo']."' AND MONTH(ap.prgfecha) = MONTH(CURDATE()) AND ap.apcobservacion = '' AND NOT ap.aptcodigo = 1 AND ap.aptcodigo = '".$_GET['valor']."' ");

								$cantNov = mysqli_fetch_array($QueryTotalNov);

								$html.='
									<td style="text-align: center; font-weight: bold; font-size: 1em">'.$cantNov['can'].'</td></tr></tbody></table>
								';
						}
						else
						{

							$html.='
							<table class="table table-striped table-hover table-bordered" id="tblListado">
								<thead>
									<tr>
										<th style="text-align: center">COLABORADOR</th>
										<th style="text-align: center">CARGO</th>
										<th style="text-align: center">PERFIL</th>
										<th style="text-align: center">TURNO</th>
										<th style="text-align: center">HORA</th>
										<th style="text-align: center">MARCÓ</th>
										<th style="text-align: center">TIPO ERROR</th>
									</tr>
								</thead>
								<tbody>';


							$f =  "SELECT ter.trcrazonsocial, crc.crgnombre, ctc.ctcnombre, CONCAT(DATE_FORMAT(trn.trndesde, '%H:%i'), ' a ', DATE_FORMAT(trn.trnhasta, '%H:%i')) AS horario, ab.abmfecha,ab.abmhora,sl.slnnombre, IF(ab.abmtipo='','OTRO',ab.abmtipo) AS estado, ab.abmnuevotipo,ab.abmtipoerror FROM btyasistencia_biometrico ab LEFT JOIN btysalon sl ON sl.slncodigo=ab.slncodigo LEFT JOIN btycolaborador c ON c.clbcodigo=ab.clbcodigo LEFT JOIN btytercero ter ON ter.tdicodigo=c.tdicodigo AND ter.trcdocumento=c.trcdocumento LEFT JOIN btycargo crc ON crc.crgcodigo=c.crgcodigo LEFT JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo LEFT JOIN btyasistencia_procesada ap ON ap.abmcodigo=ab.abmcodigo LEFT JOIN btyturno trn ON trn.trncodigo=ap.trncodigo WHERE ab.slncodigo = '".$_GET['slncodigo']."' AND ab.abmerroneo = 1 AND MONTH(ab.abmfecha) = MONTH(CURDATE()) ORDER BY ter.trcrazonsocial";


						
								$QueryCantidad = mysqli_query($conn,$f);

								while($data = mysqli_fetch_array($QueryCantidad))
								{

									$html.='
										<tr>
											<td>'.utf8_encode($data['trcrazonsocial']).'</td>
											<td style="text-align: center">'.utf8_encode($data['crgnombre']).'</td>
											<td style="text-align: center">'.utf8_encode($data['ctcnombre']).'</td>
											<td style="text-align: center">'.$data['horario'].'</td>
											<td style="text-align: center">'.$data['abmhora'].'</td>
											<td style="text-align: right">'.$data['estado'].'</td>
											<td style="text-align: right">'.$data['abmtipoerror'].'</td>
											
										</tr>
							        	';

							      }
								        	$html.='
											</tbody></table>
								        	';


						}
			}
			else
			{
				$QueryTotalMes = mysqli_query($conn, "SELECT DISTINCT a.clbcodigo, c.trcrazonsocial FROM btyasistencia_procesada a JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.slncodigo = '".$_GET['slncodigo']."' AND MONTH(a.prgfecha) = MONTH(CURDATE()) ORDER BY c.trcrazonsocial");

				$html.='
							<table class="table table-striped table-hover table-bordered" id="tblListado">
								<thead>
									<tr>
										<th style="text-align: center">COLABORADOR</th>
										<th style="text-align: center">CARGO</th>
										<th style="text-align: center">PERFIL</th>
										<th style="text-align: center">TOTAL</th>
										<th style="text-align: center">CANTIDAD</th>
			
									</tr>
								</thead>
								<tbody>';



					

					while ($rows = mysqli_fetch_array($QueryTotalMes)) 
					{
						$filasCan = mysqli_query($conn, "(SELECT DISTINCT a.clbcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre, 


												(
												SELECT COUNT(ap.aptcodigo)
												FROM btyasistencia_procesada ap
												WHERE ap.slncodigo = '".$_GET['slncodigo']."' AND MONTH(ap.prgfecha) = MONTH(CURDATE()) AND ap.clbcodigo = '".$rows['clbcodigo']."' 
												AND ap.apcobservacion = '' AND NOT ap.aptcodigo = 1) AS cantidad,

												(
												SELECT CONCAT('$', FORMAT(SUM(a.apcvalorizacion),0))
												FROM btyasistencia_procesada a
												WHERE a.clbcodigo = '".$rows['clbcodigo']."' AND MONTH(a.prgfecha) = MONTH(CURDATE()) AND NOT a.aptcodigo = 1 AND a.apcobservacion = '' AND a.slncodigo = '".$_GET['slncodigo']."') AS total
												FROM btyasistencia_procesada a
												JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo
												JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento
												JOIN btycargo d ON d.crgcodigo=b.crgcodigo
												JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo
												WHERE a.slncodigo = '".$_GET['slncodigo']."' AND MONTH(a.prgfecha) = MONTH(CURDATE()) AND a.clbcodigo = '".$rows['clbcodigo']."' AND NOT a.aptcodigo = 1)

												union

												(SELECT a.clbcodigo, a.abmcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre, null  FROM btyasistencia_biometrico a JOIN btycolaborador b 
												ON b.clbcodigo=a.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento 
												JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo 
												WHERE MONTH(a.abmfecha) = MONTH(CURDATE()) AND a.abmerroneo = 1 AND a.clbcodigo = '".$rows['clbcodigo']."')");

							while ($fetch = mysqli_fetch_array($filasCan)) 
							{
								$html.='
										<tr>
											<td>'.utf8_encode($fetch['trcrazonsocial']).'</td>
											<td style="text-align: center">'.utf8_encode($fetch['crgnombre']).'</td>
											<td style="text-align: center">'.utf8_encode($fetch['ctcnombre']).'</td>
											<td style="text-align: center">'.$fetch['total'].'</td>
											<td style="text-align: center"><button class="btn btn-info btn-xs" data-clbcodigo="'.$fetch['clbcodigo'].'" data-slncodigo="'.$_GET['slncodigo'].'" id="btnVerNovMes">'.$fetch['cantidad'].'</button></td>
											
										</tr>
							        	';
							}

					}
						        	$html.='
									</tbody></table>
						        	';



						     $html.='
							<table class="table table-striped table-hover table-bordered" id="tblListado">
								<tbody>';

								$html.='
							<tr class="info"><td colspan="3">TOTAL MES</td>';

							$totalMes = mysqli_query($conn, "SELECT CONCAT('$',FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion FROM btyasistencia_procesada a WHERE a.slncodigo = '".$_GET['slncodigo']."' AND NOT a.aptcodigo = 1 AND MONTH(a.prgfecha) = MONTH(CURDATE())");

							$total = mysqli_fetch_array($totalMes);

							$html.='
								<td style="color: red; text-align: right; font-size: 1em; font-weight: bold">'.$total[0].'</td></tr>								
							';

							$html.='
									</tbody></table>
						        	';


			
		}
					
				
		}
			echo $html;


?>
					</div>
				</div>
			</div>
		</div>
	</div>





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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>

<!-- Modal -->
<div class="modal fade" id="modalVerDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title ColNombre" id="myModalLabel"> </h4>
      </div>
      <div class="modal-body">
      	<div class="table-responsive">
	          <table class="table table-hover" id="tblDetalles">
	        	<thead>
	        		<tr>
	        			<th>Colaborador</th>
	        			<th>Turno</th>
	        			<th>Salón</th>
	        			<th>Registro</th>
	        			<th>Hora Registro</th>
	        			<th>Resultado</th>
	        			<th>Valor</th>
	        		</tr>
	        	</thead>
	        	<tbody>
	        		
	        	</tbody>
	        </table>
	      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal -->
<div class="modal fade" id="modalVerDetallesMes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title ColNombre" id="myModalLabel"> </h4>
      </div>
      <div class="modal-body">
      	<div class="table-responsive">
	          <table class="table table-hover" id="tblDetallesMes">
	        	<thead>
	        		<tr>
	        			<th>Colaborador</th>
	        			<th>Turno</th>
	        			<th>Salón</th>
	        			<th>Registro</th>
	        			<th>Hora Registro</th>
	        			<th>Resultado</th>
	        			<th>Valor</th>
	        		</tr>
	        	</thead>
	        	<tbody>
	        		
	        	</tbody>
	        </table>
	      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<script>
	$(document).ready(function() {
	      $(document).prop('title', 'Reporte de Novedades Mensual | Beauty SOFT - ERP');	
	});

	
	$(document).on('click', '#btnVerDetalles', function() 
	{
		var clbcodigo = $(this).data("clbcodigo");
		var slncodigo = $(this).data("slncodigo");
		var aptcodigo = $(this).data("aptcodigo");

		$('#modalVerDetalles').modal("show");

		$.ajax({
	        url: 'loadCol.php',
	        method: 'POST',
	        data: {opcion: "dia", clbcodigo: clbcodigo, slncodigo:slncodigo, aptcodigo:aptcodigo},
	        success: function (data) 
	        {

	            var jsonDetalles = JSON.parse(data);
	            $('#tblDetalles tbody').empty();
	            if (jsonDetalles.res == "full") 
	            {
	                for(var i in jsonDetalles.json)
	                {
	                  if (jsonDetalles.json[i].abmhora == null) 
	                  {
	                       jsonDetalles.json[i].abmhora = '';
	                  }

	                  $('#tblDetalles').append('<tr><td>'+jsonDetalles.json[i].fecha+'</td><td>'+jsonDetalles.json[i].desde+'</td><td>'+jsonDetalles.json[i].salon+'</td><td>'+jsonDetalles.json[i].abmtipo+'</td><td>'+jsonDetalles.json[i].abmhora+'</td><td>'+jsonDetalles.json[i].aptnombre+'</td><td>'+jsonDetalles.json[i].valor+'</td><td></tr>');

					
	                  $('.ColNombre').html('<i class="fa fa-user"></i> ' + jsonDetalles.json[i].nombre);                  
	                }
	            }
	            else
	            {
	                $('#tblDetalles').append('<tr><td colspan="8"><b><center>NO REPORTA NOVEDADES</center></b></td></tr>');
	            }
	        }
	    
	    });		
	});



/***********************/

$(document).on('click', '#btnVerNovMes', function() 
	{
		var clbcodigo = $(this).data("clbcodigo");
		var slncodigo = $(this).data("slncodigo");

		$('#modalVerDetallesMes').modal("show");

		$.ajax({
	        url: 'loadCol.php',
	        method: 'POST',
	        data: {opcion:"mes", clbcodigo: clbcodigo, slncodigo:slncodigo},
	        success: function (data) 
	        {

	            var jsonDetalles = JSON.parse(data);
	            $('#tblDetallesMes tbody').empty();
	            if (jsonDetalles.res == "full") 
	            {
	                for(var i in jsonDetalles.json)
	                {
	                  if (jsonDetalles.json[i].abmhora == null) 
	                  {
	                       jsonDetalles.json[i].abmhora = '';
	                  }

	                  $('#tblDetallesMes').append('<tr><td>'+jsonDetalles.json[i].fecha+'</td><td>'+jsonDetalles.json[i].desde+'</td><td>'+jsonDetalles.json[i].salon+'</td><td>'+jsonDetalles.json[i].abmtipo+'</td><td>'+jsonDetalles.json[i].abmhora+'</td><td>'+jsonDetalles.json[i].aptnombre+'</td><td>'+jsonDetalles.json[i].valor+'</td><td></tr>');

					
	                  $('.ColNombre').html('<i class="fa fa-user"></i> ' + jsonDetalles.json[i].nombre);                  
	                }
	            }
	            else
	            {
	                $('#tblDetallesMes').append('<tr><td colspan="8"><b><center>NO REPORTA NOVEDADES</center></b></td></tr>');
	            }
	        }
	    
	    });		
	});





</script>




