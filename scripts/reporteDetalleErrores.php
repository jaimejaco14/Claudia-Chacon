	<?php 
	include(dirname(__FILE__).'/../cnx_data.php');

	$Query = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = '1' AND slncodigo = '".$_GET['slncodigo']."' ORDER BY slnnombre ");

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

		$salon = mysqli_fetch_array($Query);

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
	<center><legend style="padding-top: 50px"><?php echo "NOVEDADES SALÓN " . $salon[1]; ?> <br> MES : <?php $mes = $semana[$mes]; echo $mes; ?>
	</legend></center>

	<div class="container" >
		<input type="hidden" value="<?php echo $_GET['tipo']; ?>" id="tipo">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-12">
					<center><h4 class="text-primary"><b>ERRORES</b></h4></center>
					<div class="table-responsive">								
<?php 

$Salon = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = '1' ORDER BY slnnombre ");

 

	$t = "SELECT ter.trcrazonsocial, crc.crgnombre, ctc.ctcnombre, CONCAT(DATE_FORMAT(trn.trndesde, '%H:%i'), ' a ', DATE_FORMAT(trn.trnhasta, '%H:%i')) AS horario, ab.abmfecha,ab.abmhora,sl.slnnombre, IF(ab.abmtipo='','OTRO',ab.abmtipo) AS estado, ab.abmnuevotipo,ab.abmtipoerror FROM btyasistencia_biometrico ab LEFT JOIN btysalon sl ON sl.slncodigo=ab.slncodigo LEFT JOIN btycolaborador c ON c.clbcodigo=ab.clbcodigo LEFT JOIN btytercero ter ON ter.tdicodigo=c.tdicodigo AND ter.trcdocumento=c.trcdocumento LEFT JOIN btycargo crc ON crc.crgcodigo=c.crgcodigo LEFT JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo LEFT JOIN btyasistencia_procesada ap ON ap.abmcodigo=ab.abmcodigo LEFT JOIN btyturno trn ON trn.trncodigo=ap.trncodigo WHERE ab.slncodigo = '".$_GET['slncodigo']."' AND ab.abmerroneo = 1 AND MONTH(ab.abmfecha) = MONTH(CURDATE()) ORDER BY ter.trcrazonsocial";

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
								<th style="text-align: center">FECHA</th>
								<th style="text-align: center">HORA</th>
								<th style="text-align: center">TIPO</th>
								<th style="text-align: center">ERROR</th>

						</thead>
			    		<tbody>';

			    		while ($rows = mysqli_fetch_array($Sql)) 
					    {
						     $html.='<tr>
										<td>'.utf8_encode($rows['trcrazonsocial']).'</td>
										<td>'.$rows['crgnombre'].'</td>
										<td>'.$rows['ctcnombre'].'</td>
										<td>'.$rows['abmfecha'].'</td>
										<td>'.$rows['abmhora'].'</td>
										<td>'.$rows['estado'].'</td>
										<td>'.$rows['abmtipoerror'].'</td>							
								    </tr>';
					    }
								$QueryTotal = mysqli_query($conn, "SELECT CONCAT('$', FORMAT(SUM(ap.apcvalorizacion), 0)) AS valor FROM btyasistencia_procesada ap WHERE MONTH(ap.prgfecha) = MONTH(CURDATE()) AND NOT ap.aptcodigo = 1 AND ap.aptcodigo = '".$_GET['valor']."' AND ap.slncodigo = '".$salon['slncodigo']."'"); 

										$fetch = mysqli_fetch_array($QueryTotal);
																			    
			    }
			$total = mysqli_query($conn, "SELECT COUNT(a.abmcodigo) FROM btyasistencia_biometrico a  WHERE a.slncodigo = '".$_GET['slncodigo']."'  AND a.abmerroneo = 1 AND MONTH(a.abmfecha) = MONTH(CURDATE())");

			$h = mysqli_fetch_array($total);
			
			$html.='<tr class="info"><td colspan="6"><b>TOTAL ERRORES</b></td><td style="color: red; font-size: 1em; text-align: right; font-weight: bold">'.$h[0].'</td></tr>';
			$html.='</tbody></table>';
			echo $html;


?>
	                        </div>
				</div>
			</div>
		</div>
	</div>




<!-- Modal -->
<div class="modal fade" id="modalVerDetallesTotalMes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
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

	$(document).on('click', '#btnVerDetalleMes', function() 
	{
		var clbcodigo = $(this).data("clbcodigo");
		var slncodigo = $(this).data("slncodigo");
		var aptcodigo = $(this).data("aptcodigo");

		$('#modalVerDetallesTotalMes').modal("show");

		$.ajax({
	        url: 'loadColTotal.php',
	        method: 'POST',
	        data: {opcion: "mes", clbcodigo: clbcodigo, slncodigo:slncodigo, aptcodigo:aptcodigo},
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

	                  $('#tblTotalDetallesMes').append('<tr><td>'+jsonDetalles.json[i].fecha+'</td><td>'+jsonDetalles.json[i].desde+'</td><td>'+jsonDetalles.json[i].salon+'</td><td>'+jsonDetalles.json[i].abmtipo+'</td><td>'+jsonDetalles.json[i].abmhora+'</td><td>'+jsonDetalles.json[i].aptnombre+'</td><td>'+jsonDetalles.json[i].valor+'</td><td></tr>');

					
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



	
