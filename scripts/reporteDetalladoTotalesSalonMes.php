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
			$estado = 'TODAS LAS NOVEDADES DEL MES';
			break;

		case 'e':
			$estado = 'ERRORES';
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
	<title>REPORTE DETALLADO DE NOVEDADES</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 
</head>

<body>
	<center><legend style="padding-top: 50px"><?php echo "NOVEDADES DE TODOS LOS SALONES" ?> <br> MES : <?php $mes = $semana[$mes]; echo $mes; ?>
	</legend></center>

	<div class="container" >
		<input type="hidden" value="<?php echo $_GET['tipo']; ?>" id="tipo">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-12">
					<center><h4 class="text-primary"><?php echo $estado; ?></h4></center>
					<div class="table-responsive">								
<?php 
 

$Query = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = '1' ORDER BY slnnombre");



if ($_GET['tipo'] != "alls") 
{
	

		if ($_GET['tipo'] != "e") 
		{
			while ($salon = mysqli_fetch_array($Query)) 
			{
				$t = "SELECT DISTINCT a.clbcodigo, c.trcrazonsocial, crg.crgnombre, ctc.ctcnombre FROM btyasistencia_procesada a JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=b.ctccodigo WHERE a.slncodigo = '".$salon['slncodigo']."' AND MONTH(a.prgfecha) = MONTH(CURDATE()) AND a.aptcodigo = '".$_GET['valor']."' ORDER BY c.trcrazonsocial";

			    $Sql = mysqli_query($conn, $t);

			      if (mysqli_num_rows($Sql) > 0) 
			      {
			    	    $html.='
					<h5 style="font-weight: bolder">'.$salon['slnnombre'].'</h5>
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
								<th style="text-align: center">COLABORADOR</th>
								<th style="text-align: center">CARGO</th>
								<th style="text-align: center">PERFIL</th>
								<th style="text-align: center">TOTAL</th>
								<th style="text-align: center">CANTIDAD</th>

						</thead>
			    		<tbody>';

				      while ($rows = mysqli_fetch_array($Sql)) 
					{
						$html.='<tr>
									<td>'.utf8_encode($rows['trcrazonsocial']).'</td>
									<td>'.$rows['crgnombre'].'</td>
									<td>'.$rows['ctcnombre'].'</td>';

									$QueryTotalMes = mysqli_query($conn, "SELECT CONCAT('$',FORMAT(SUM(ap.apcvalorizacion), 0)) AS valor FROM btyasistencia_procesada ap WHERE MONTH(ap.prgfecha) = MONTH(CURDATE()) AND ap.slncodigo= '".$salon['slncodigo']."' AND ap.aptcodigo = '".$_GET['valor']."' AND ap.clbcodigo = '".$rows['clbcodigo']."'");

									$fetch = mysqli_fetch_array($QueryTotalMes);


									$html.='<td style="text-align: right">'.$fetch['valor'].'</td>';

									$QueryCantidad = mysqli_query($conn, "SELECT COUNT(ap.aptcodigo) FROM btyasistencia_procesada ap WHERE ap.slncodigo = '".$salon['slncodigo']."' AND MONTH(ap.prgfecha) = MONTH(CURDATE()) AND ap.apcobservacion = '' AND NOT ap.aptcodigo = 1 AND ap.aptcodigo = '".$_GET['valor']."' AND ap.clbcodigo = '".$rows['clbcodigo']."'");

										$fetchCan = mysqli_fetch_array($QueryCantidad);

										$html.='
											<td><center><button class="btn btn-info btn-xs" id="btnVerDetalleMes" data-clbcodigo="'.$rows['clbcodigo'].'" data-aptcodigo="'.$_GET['valor'].'" data-slncodigo="'.$salon['slncodigo'].'">'.$fetchCan[0].'</button></center></td>
								</tr>';


					}
									$QueryTotal = mysqli_query($conn, "SELECT CONCAT('$', FORMAT(SUM(ap.apcvalorizacion), 0)) AS valor FROM btyasistencia_procesada ap WHERE MONTH(ap.prgfecha) = MONTH(CURDATE()) AND NOT ap.aptcodigo = 1 AND ap.aptcodigo = '".$_GET['valor']."' AND ap.slncodigo = '".$salon['slncodigo']."'"); 

										$fetch = mysqli_fetch_array($QueryTotal);


										$html.='
											<tr class="info"><td colspan="3"><b>TOTAL</b></td><td style="color: red; font-size: 1em; text-align: right"><b>'.$fetch['valor'].'</b></td>';

											$Total = mysqli_query($conn, "SELECT COUNT(ap.aptcodigo) FROM btyasistencia_procesada ap WHERE ap.slncodigo = '".$salon['slncodigo']."' AND MONTH(ap.prgfecha) = MONTH(CURDATE()) AND ap.apcobservacion = '' AND NOT ap.aptcodigo = 1 AND ap.aptcodigo = '".$_GET['valor']."'");

												$fetcTotal = mysqli_fetch_array($Total);

												$html.='
													<td style="font-weight: bold; font-size: 1em;"><center>'.$fetcTotal[0].'</center></td></tr>
												';

																		
									
					$html.='</tbody></table>';
			      }   

		     }
		}
		else
		{//inicio errores mes
			while ($salon = mysqli_fetch_array($Query)) 
			{
				$t = "SELECT a.clbcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre  FROM btyasistencia_biometrico a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo WHERE a.slncodigo = '".$salon['slncodigo']."' AND a.abmerroneo = 1 AND MONTH(a.abmfecha) = MONTH(CURDATE()) GROUP BY a.clbcodigo ORDER BY c.trcrazonsocial";

			    $Sql = mysqli_query($conn, $t);

			      if (mysqli_num_rows($Sql) > 0) 
			      {
			    	    $html.='
					<h5 style="font-weight: bolder">'.$salon['slnnombre'].'</h5>
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
								<th style="text-align: center">COLABORADOR</th>
								<th style="text-align: center">CARGO</th>
								<th style="text-align: center">PERFIL</th>
								<th style="text-align: center">CANTIDAD</th>

						</thead>
			    		<tbody>';

				      while ($rows = mysqli_fetch_array($Sql)) 
					{
						$html.='<tr>
									<td>'.utf8_encode($rows['trcrazonsocial']).'</td>
									<td>'.$rows['crgnombre'].'</td>
									<td>'.$rows['ctcnombre'].'</td>';

									

									$QueryCantidad = mysqli_query($conn, "SELECT COUNT(a.abmcodigo) FROM btyasistencia_biometrico a  WHERE a.slncodigo = '".$salon['slncodigo']."' AND a.clbcodigo = '".$rows['clbcodigo']."' AND a.abmerroneo = 1 AND MONTH(a.abmfecha) = MONTH(CURDATE())");

										$fetchCan = mysqli_fetch_array($QueryCantidad);

										$html.='
											<td><center><button class="btn btn-info btn-xs" id="btnVerDetalleMesError" data-clbcodigo="'.$rows['clbcodigo'].'" data-slncodigo="'.$salon['slncodigo'].'">'.$fetchCan[0].'</button></center></td>
								</tr>';



					}
									
								$Totalizado = mysqli_query($conn, "SELECT COUNT(a.abmcodigo) FROM btyasistencia_biometrico a WHERE a.slncodigo = '".$salon['slncodigo']."' AND a.abmerroneo = 1 AND MONTH(a.abmfecha) = MONTH(CURDATE())");

								$d = mysqli_fetch_array($Totalizado);

						$html.='
							<tr class="info"><td colspan="3"><b>TOTAL</b></td><td style="font-weight: bold"><center>'.$d[0].'</center></td></tr>
						';
																		
									
					$html.='</tbody></table>';
			      }   

		     }
		}//fin errores mes


			echo $html;
		}


?>
	                </div>
				</div>
			</div>
		</div>
	</div>




<!-- Modal -->
<div class="modal fade" id="modalVerDetallesTotalMes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title ColNombre" id="myModalLabel"> </h4>
      </div>
      <div class="modal-body">
      	<div class="table-responsive">
	          <table class="table table-hover" id="tblTotalDetallesMes">
	        	<thead>
	        		<tr>
	        			<th>Fecha</th>
	        			<th>Turno</th>
	        			<th>Salón</th>
	        			<th>Costo</th>
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



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
	      $(document).prop('title', 'Reporte Mensual Todos los Salones | Beauty SOFT - ERP');		
	});

	$(document).on('click', '#btnVerDetalleMesError', function() 
	{
		var clbcodigo = $(this).data("clbcodigo");
		var slncodigo = $(this).data("slncodigo");

		$('#modalVerDetallesTotalMes').modal("show");

		$.ajax({
	        url: 'loadColTotalErrores.php',
	        method: 'POST',
	        data: {opcion: "Errormes", clbcodigo: clbcodigo, slncodigo:slncodigo},
	        success: function (data) 
	        {

	            var jsonDetalles = JSON.parse(data);
	            $('#tblTotalDetallesMes tbody').empty();
	            if (jsonDetalles.res == "full") 
	            {
	                for(var i in jsonDetalles.json)
	                {
	                  if (jsonDetalles.json[i].abmhora == null) 
	                  {
	                       jsonDetalles.json[i].abmhora = '';
	                  }

	                  $('#tblTotalDetallesMes').append('<tr><td>'+jsonDetalles.json[i].fecha+'</td><td>'+jsonDetalles.json[i].abmhora+'</td><td>'+jsonDetalles.json[i].abmtipo+'</td><td>'+jsonDetalles.json[i].error+'</td></tr>');

					
	                  $('.ColNombre').html('<i class="fa fa-user"></i> ' + jsonDetalles.json[i].nombre);                  
	                }
	            }
	            else
	            {
	                $('#tblTotalDetallesMes').append('<tr><td colspan="8"><b><center>NO REPORTA NOVEDADES</center></b></td></tr>');
	            }
	        }
	    
	    });

	});


$(document).on('click', '#btnVerDetalleMes', function() 
	{
		var clbcodigo = $(this).data("clbcodigo");
		var slncodigo = $(this).data("slncodigo");

		$('#modalVerDetallesTotalMes').modal("show");

		$.ajax({
	        url: 'loadColTotalErrores.php',
	        method: 'POST',
	        data: {opcion: "ausencias", clbcodigo: clbcodigo, slncodigo:slncodigo},
	        success: function (data) 
	        {

	            var jsonDetalles = JSON.parse(data);
	            $('#tblTotalDetallesMes tbody').empty();
	            if (jsonDetalles.res == "full") 
	            {
	                for(var i in jsonDetalles.json)
	                {
	                  if (jsonDetalles.json[i].abmhora == null) 
	                  {
	                       jsonDetalles.json[i].abmhora = '';
	                  }

	                  $('#tblTotalDetallesMes').append('<tr><td>'+jsonDetalles.json[i].fecha+'</td><td>'+jsonDetalles.json[i].tipo+'</td><td>'+jsonDetalles.json[i].salon+'</td><td>'+jsonDetalles.json[i].valor+'</td></tr>');

					
	                  $('.ColNombre').html('<i class="fa fa-user"></i> ' + jsonDetalles.json[i].nombre);                  
	                }
	            }
	            else
	            {
	                $('#tblTotalDetallesMes').append('<tr><td colspan="8"><b><center>NO REPORTA NOVEDADES</center></b></td></tr>');
	            }
	        }
	    
	    });

	});

</script>



	
