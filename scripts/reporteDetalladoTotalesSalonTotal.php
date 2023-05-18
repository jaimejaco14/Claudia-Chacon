<?php 
	include(dirname(__FILE__).'/../cnx_data.php');

	$Query = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = '1'");


	switch ($_GET['tipo']) 
	{

		case 'alls':
			$estado = 'TODAS LAS NOVEDADES DEL MES';
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
</head>

<body>
		<center><legend style="padding-top: 50px"><?php echo $estado; $mes = $semana[$mes]; echo " " . $mes; ?> <br> 
		</legend></center>
	<div class="container" >
		<input type="hidden" value="<?php echo $_GET['tipo']; ?>" id="tipo">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-12">
					<div class="table-responsive">
					
<?php							

	$html="";

	while($rows = mysqli_fetch_array($Query))
	{

		$QueryTer = mysqli_query($conn, "(SELECT asi.clbcodigo, ter.trcrazonsocial, crg.crgnombre, ctc.ctcnombre FROM btyasistencia_procesada asi
JOIN btycolaborador col ON asi.clbcodigo=col.clbcodigo JOIN btytercero ter ON ter.tdicodigo=col.tdicodigo AND ter.trcdocumento=col.trcdocumento
JOIN btycargo crg ON crg.crgcodigo=col.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=col.ctccodigo WHERE asi.prgfecha = date_add(CURDATE(), interval -1 day) AND asi.slncodigo = '".$rows['slncodigo']."' AND NOT asi.aptcodigo = 1 ) union (SELECT a.clbcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre FROM btyasistencia_biometrico a JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo WHERE a.abmfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY) AND a.abmerroneo = 1 AND a.slncodigo =  '".$rows['slncodigo']."')");

		if (mysqli_num_rows($QueryTer) > 0) 
		{
			$html.='
				<h5 style="font-weight: bolder">'.$rows['slnnombre'].'</h5>
				<table class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th style="text-align: center">COLABORADOR</th>
							<th style="text-align: center">CARGO</th>
							<th style="text-align: center">PERFIL</th>
							<th style="text-align: center" id="thTipo">COSTO</th>
							<th style="text-align: center" id="">CANTIDAD</th></tr>
					</thead>
		    		<tbody>';

		    		while ($filas = mysqli_fetch_array($QueryTer)) 
		    		{
			    		$html.='
							<tr>
								<td>'.utf8_encode($filas['trcrazonsocial']).'</td>
								<td>'.utf8_encode($filas['crgnombre']).'</td>
								<td>'.utf8_encode($filas['ctcnombre']).'</td>
							
							
			    		';	

			    		$costo = mysqli_query($conn, "SELECT CONCAT('$',FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion FROM  btyasistencia_procesada a WHERE a.clbcodigo = '".$filas['clbcodigo']."' AND NOT a.aptcodigo = 1 AND MONTH(a.prgfecha) = MONTH(CURDATE())");

			    		$rowCosto = mysqli_fetch_array($costo);

			    		$html.='
							<td style="text-align: right;">'.$rowCosto[0].'</td>
			    		';

			    		$i = 0;

			    		$d = "(
								SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, bio.abmnuevotipo,bio.abmhora, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON  t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo in (2, 3) AND a.clbcodigo = '".$filas['clbcodigo']."' AND a.slncodigo = '".$rows['slncodigo']."' ORDER BY t.trcrazonsocial 

                            ) 
								UNION
							(
								SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS aptnombre, '','', j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND a.abmcodigo IS NULL AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo IN( 4,6) AND a.clbcodigo = '".$filas['clbcodigo']."' AND a.slncodigo = '".$rows['slncodigo']."' ORDER BY t.trcrazonsocial
							) 
	

								UNION
							(
								SELECT a.abmcodigo, a.clbcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre,f.aptnombre,a.prgfecha, NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL FROM btyasistencia_procesada a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo JOIN btyasistencia_procesada_tipo f ON f.aptcodigo=a.aptcodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND a.aptcodigo = 5 AND a.clbcodigo = '".$filas['clbcodigo']."' AND a.slncodigo = '".$rows['slncodigo']."'
							)

								UNION
							(
								SELECT a.abmcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre, a.abmtipo as marco_como, a.abmtipoerror, a.abmnuevotipo, a.abmfecha, a.abmhora, NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL FROM btyasistencia_biometrico a JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo WHERE MONTH(a.abmfecha) = MONTH(CURDATE()) AND a.abmerroneo = 1  AND a.clbcodigo = '".$filas['clbcodigo']."' AND a.slncodigo = '".$rows['slncodigo']."') ORDER BY trcrazonsocial";
									//echo $d . "<br>";

			    		$cantidad = mysqli_query($conn, $d);

			    		$cantidadNove = mysqli_num_rows($cantidad);

			    		$html.='
							<td style="text-align: right"><center><button class="btn btn-info btn-xs" data-clbcodigo="'.$filas['clbcodigo'].'" data-slncodigo="'.$rows['slncodigo'].'"  id="btnVerDetalle">'.$cantidadNove.'</button></center></td></tr>
			    		';

		    		}
			    		$html.='
							<tr class="info"><td colspan="3">TOTAL MES</td>';

							$totalMes = mysqli_query($conn, "SELECT CONCAT('$',FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion FROM btyasistencia_procesada a WHERE a.slncodigo = '".$rows['slncodigo']."' AND NOT a.aptcodigo = 1 AND MONTH(a.prgfecha) = MONTH(CURDATE())");

							$total = mysqli_fetch_array($totalMes);

							$html.='
								<td style="color: red; text-align: right; font-size: 1em; font-weight: bold">'.$total[0].'</td>								
							';

							$totalMes = mysqli_query($conn, "(
								SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS desde, bio.abmnuevotipo,bio.abmhora, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON  t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo in (2, 3) AND a.slncodigo = '".$rows['slncodigo']."' ORDER BY t.trcrazonsocial 

                            ) 
								UNION
							(
								SELECT a.abmcodigo, a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, s.slnnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', TIME_FORMAT(j.trnhasta,'%H:%i')) AS aptnombre, '','', j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo, CONCAT('$', FORMAT(a.apcvalorizacion,0)) AS apcvalorizacion FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento JOIN btysalon s ON s.slncodigo=a.slncodigo JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo JOIN btyturno j ON j.trncodigo=a.trncodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND a.abmcodigo IS NULL AND NOT b.aptfactor = '0.0000' AND a.apcobservacion = '' AND a.aptcodigo IN( 4,6) AND a.slncodigo = '".$rows['slncodigo']."' ORDER BY t.trcrazonsocial
							) 
	

								UNION
							(
								SELECT a.abmcodigo, a.clbcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre,f.aptnombre,a.prgfecha, NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL FROM btyasistencia_procesada a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo JOIN btyasistencia_procesada_tipo f ON f.aptcodigo=a.aptcodigo WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND a.aptcodigo = 5 AND a.slncodigo = '".$rows['slncodigo']."'
							)

								UNION
							(
								SELECT a.abmcodigo, c.trcrazonsocial, d.crgnombre, e.ctcnombre, a.abmtipo as marco_como, a.abmtipoerror, a.abmnuevotipo, a.abmfecha, a.abmhora, NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL FROM btyasistencia_biometrico a JOIN btycolaborador b ON b.clbcodigo=a.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo d ON d.crgcodigo=b.crgcodigo JOIN btycategoria_colaborador e ON e.ctccodigo=b.ctccodigo WHERE MONTH(a.abmfecha) = MONTH(CURDATE()) AND a.abmerroneo = 1  AND a.slncodigo = '".$rows['slncodigo']."') ORDER BY trcrazonsocial");

							$total = mysqli_num_rows($totalMes);

							$html.='
								<td style="text-align: right;"><center>'.$total.'</center></td>								
							';		    			    			

		    		$html.='
						     </tbody>
		            	</table>
		    		';
			
		}


	}

	$html.='
				<table class="table table-striped table-hover table-bordered">
					
		    		<tbody>
		    			<tr><td>TOTAL TODOS LOS SALONES</td>
		    		';

		    		$Meses = mysqli_query($conn, "SELECT CONCAT('$',FORMAT(SUM(a.apcvalorizacion),0)) AS apcvalorizacion FROM btyasistencia_procesada a WHERE MONTH(a.prgfecha) = MONTH(CURDATE())");

		    		$fetchAll = mysqli_fetch_array($Meses);

		    		$html.='
						<td style="color: red; text-align: right; font-size: 1em; font-weight: bold">'.$fetchAll[0].'</td></tr>
		    		';

		    		
		    		$html.='
						     </tbody>
		            	</table>
		    		';

		    		echo $html;

		    		

?>				
					
	            </div>
			</div>
		</div>
	</div>
</div>




<!-- Modal Detalles -->
<div class="modal fade" id="modalVerDealles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title ColNombre" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
      	<div class="table-responsive">
	         <table class="table table-hover table-bordered" id="tblTotalMes">
	         	<thead>
	         		<tr>
	        			<th>Fecha</th>
	        			<th>Hora</th>
	        			<th>Registro</th>
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
	      $(document).prop('title', 'Reporte Todos los Salones| Beauty SOFT - ERP');		
	});

	$(document).on('click', '#btnVerDetalle', function() 
	{

		var clbcodigo = $(this).data("clbcodigo");
		var slncodigo = $(this).data("slncodigo");

		$('#modalVerDealles').modal("show");

		$.ajax({
	        url: 'loadTotalesMes.php',
	        method: 'POST',
	        data: {clbcodigo: clbcodigo, slncodigo:slncodigo},
	        success: function (data) 
	        {

	            var jsonDetalles = JSON.parse(data);
	            $('#tblTotalMes tbody').empty();
	            if (jsonDetalles.res == "full") 
	            {
	                for(var i in jsonDetalles.json)
	                {
	                  if (jsonDetalles.json[i].abmhora == null) 
	                  {
	                       jsonDetalles.json[i].abmhora = '';
	                  }

	                  if (jsonDetalles.json[i].fecha == null) 
	                  {
	                  	  jsonDetalles.json[i].fecha = '';
	                  }
	                  else
	                  {
	                  	jsonDetalles.json[i].fecha;
	                  }

	                   if (jsonDetalles.json[i].apcvalorizacion == null) 
	                  {
	                  	  jsonDetalles.json[i].apcvalorizacion = '';
	                  }
	                  else
	                  {
	                  	jsonDetalles.json[i].apcvalorizacion;
	                  }


	                  $('#tblTotalMes').append('<tr><td>'+jsonDetalles.json[i].fecha+'</td><td>'+jsonDetalles.json[i].hora+'</td><td>'+jsonDetalles.json[i].aptnombre+'</td><td>'+jsonDetalles.json[i].apcvalorizacion+'</td></tr>');

					
	                  $('.ColNombre').html('<i class="fa fa-user"></i> ' + jsonDetalles.json[i].nombre);                  
	                }
	            }
	            else
	            {
	                $('#tblTotalMes').append('<tr><td colspan="8"><b><center>NO REPORTA NOVEDADES</center></b></td></tr>');
	            }
	        }
	    
	    });
	});
</script>

