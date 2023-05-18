<?php
    include("head.php");
  include '../cnx_data.php';
    $fecha=$_GET['fecha'];
    $vec=explode('-',$fecha);
    $nmes=$vec[1];
    switch($nmes)
    {
    	case '01':$mes='ENERO';
    	break;
    	case '02':$mes='FEBRERO';
    	break;
    	case '03':$mes='MARZO';
    	break;
    	case '04':$mes='ABRIL';
    	break;
    	case '05':$mes='MAYO';
    	break;
    	case '06':$mes='JUNIO';
    	break;
    	case '07':$mes='JULIO';
    	break;
    	case '08':$mes='AGOSTO';
    	break;
    	case '09':$mes='SEPTIEMBRE';
    	break;
    	case '10':$mes='OCTUBRE';
    	break;
    	case '11':$mes='NOVIEMBRE';
    	break;
    	case '12':$mes='DICIEMBRE';
    	break;
    }
  
?>
<?php include "librerias_js.php" ?>

<div class="content">

<input type="hidden" id="slncodigo" value="<?php echo $_GET['slncodigo']; ?>">
<input type="hidden" id="fecha" value="<?php echo $_GET['fecha']; ?>">

<div class="row">
    <div class="col-lg-12">
        <div class="hpanel">
            <div class="panel-heading">
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    <a class="closebox"><i class="fa fa-times"></i></a>
                </div>
               <?php 
               	$sql = mysqli_query($conn, "SELECT slnnombre FROM btysalon WHERE slncodigo = '".$_GET['slncodigo']."' AND slnestado = 1");

               	$fetch = mysqli_fetch_array($sql);

               	echo " VISTA GENERAL DE PROGRAMACIÓN " . "<b>" . $fetch['slnnombre'] ."</b> MES DE ".  $mes ;

                ?>
            </div>
            <div class="panel-body">
            	
            	<div class="table-responsive" id="divTabla">
                	<table class="table table-hover table-striped table-bordered">
                  	<thead>
                  	<tr>
                  		<th rowspan="2" class="text-center" style="vertical-align:middle;">
                            COLABORADOR<br><span> <i class="fa fa-filter text-info" id="btnModal" style="cursor: pointer;"></i></span><br>
                        </th>
                  		<?php 

                  			$dias = mysqli_query($conn, "SELECT DAY(LAST_DAY('$fecha')), MONTH('$fecha') ");

	                        	$rows = mysqli_fetch_array($dias); 

	                        	$semana = array('LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO');



	                        	$primerDia = mysqli_query($conn, "SET lc_time_names = 'es_CO';");

	                        	$y ="SELECT UCASE(DAYNAME(CAST(DATE_FORMAT('$fecha' ,'%Y-%m-01') as DATE)))";
	                        	

	                        	$primerDia = mysqli_query($conn, $y);


	                        	$filaDias = mysqli_fetch_array($primerDia);                 				

                  					$sw=true;
                  					$e=0;$i=0;$sem=1;
                  					while ($sw) 
                  					{

			                  				if ($filaDias[0] == "LUNES") 
			                  				{
			                  					$d=7;
			                  					$e+=$d;
            							
            									echo '<th colspan="7" class="text-center">SEMANA '.$sem.'</th>';
			                  					$sw=false;
			                  					$sem++;
			                  				}
			                  				else if ($filaDias[0] == $semana[$i]) 
			                  				{
			                        	 		$d = COUNT($semana) - $i;
			                        	 		$e+=$d;
			                        	 		$sw=false;
			                        	 		echo '<th colspan="'.$d.'" class="text-center">SEMANA '.$sem.'</th>';	
			                        	 		$sem++;				                        	 	
			                  				}

				                        	$i++; 	
		                        	 	
	                        			                 					
                  						
                  					}
                  					//echo $e;
                  					while ( $e <= $rows[0]) 
                  					{
            							$d=7;
            							$e+=$d;
            							echo '<th colspan="'.$d.'" class="text-center">SEMANA '.$sem.'</th>';
            							$sem++;
                  						
                  					}           					
            							

            						
                  				                			
                  		 ?>
                  	</tr>
	                    <tr>
	                        

	                        <?php 
	                        	$dias = mysqli_query($conn, "SELECT DAY(LAST_DAY('$fecha'))");

	                        	$rows = mysqli_fetch_array($dias);

	                        	$semana = array('LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO');



	                        	$primerDia = mysqli_query($conn, "SET lc_time_names = 'es_CO';");

	                        	$y ="SELECT UCASE(DAYNAME(CAST(DATE_FORMAT('$fecha' ,'%Y-%m-01') as DATE)))";
	                        	//echo $y;

	                        	$primerDia = mysqli_query($conn, $y);


	                        	$filaDias = mysqli_fetch_array($primerDia);

	                        	//echo $filaDias[0];

	                        	$queryFes = mysqli_query($conn, "SELECT DAY(a.fesfecha)AS dia, a.fesobservacion FROM btyfechas_especiales a WHERE MONTH(a.fesfecha) = MONTH('$fecha') ORDER BY dia");

	                        	$diaFestivo='';
	                        	$Festivo='';

	                        	while($fes = mysqli_fetch_array($queryFes))
	                        	{
	                        		$Festivo.=$fes['fesobservacion'].',';
	                        		$diaFestivo.=$fes['dia'].',';
	                        	}

	                        	$vectorFestivo = explode(',',$diaFestivo);
	                        	$vectorTipoFestivo = explode(',',$Festivo);
	                        	


	                        	$x = 0;
	                        	for ($i=0; $i < COUNT($semana); $i++) 
	                        	{

	                        	 	if ($semana[$i] == $filaDias[0]) 
	                        	 	{
	                        	 		$k=$i;

	                        	 		for ($j=1; $j <= $rows[0] ; $j++) 
			                        	{

			                        		if($semana[$k]== 'DOMINGO')
			                        		{
			                        			if ($vectorFestivo[$x] == $j)
			                        			{
			                        				$color='red';
			                        				$x++;
			                        			}
			                        			else
			                        			{
			                        				$color='red';
			                        			}                       			
			                        		}
			                        		else
			                        		{
			                        			if ($vectorFestivo[$x] == $j)
			                        			{
			                        				$color='red';
			                        				$x++;
			                        			}
			                        			else
			                        			{
			                        				$color='';
			                        			}
			                        			
	                        	 			
			                        		}
			                        		echo ' 
										<th style="text-align:center;color:'.$color.';" >'.$j .  "<br> " . substr($semana[$k],0,3).'</th>
			                        		';

			                        		//data-toggle="tooltip" data-placement="top" data-container="body" title="'.utf8_encode($vectorTipoFestivo[$k]).'"

			                        		$k++;                    		

			                        		if ($k > 6) 
			                        		{
			                        			$k=0;
			                        		}
			                        	}//end for
	                        	 	}
	                        	 	
	                        	}


	                        	

	                         ?>
	                        
	                    </tr>
                    	</thead>
                    	<tbody>

                    	<?php 


                            	$sql = mysqli_query($conn, "SELECT DISTINCT a.clbcodigo, c.trcrazonsocial, crg.crgnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo WHERE MONTH(a.prgfecha) = MONTH('$fecha')  AND a.slncodigo = '".$_GET['slncodigo']."' ORDER BY c.trcrazonsocial");

                    
                            		while ($row = mysqli_fetch_array($sql)) 
                            		{
                            			echo '<tr>
                            					<td style="white-space: nowrap">
										'.utf8_encode($row['trcrazonsocial']).' [<b>'.$row['crgnombre'].'</b>]
                        					</td>
                            				';

                            			$a="SELECT SUBSTRING(b.trnnombre, 1, 2)AS trnnombre, DAY(a.prgfecha)AS dia, b.trnnombre AS tipoturno, a.trncodigo, c.tprcodigo, CONCAT(TIME_FORMAT(b.trndesde,'%H:%i'), ' a ', TIME_FORMAT(b.trnhasta, '%H:%i')) AS turno, b.trndesde, b.trnhasta, SUBSTRING(c.tprnombre, 1,1) AS tprnombre, c.tprnombre AS tipo, pt.ptrnombre, b.trncolor FROM btyprogramacion_colaboradores a JOIN btyturno b ON a.trncodigo=b.trncodigo JOIN btytipo_programacion c ON c.tprcodigo=a.tprcodigo JOIN btypuesto_trabajo pt ON pt.ptrcodigo=a.ptrcodigo WHERE a.slncodigo = '".$_GET['slncodigo']."' AND MONTH(a.prgfecha) = MONTH('$fecha') AND a.clbcodigo = '".$row['clbcodigo']."' ORDER BY a.prgfecha";
                            				//echo $a . "<br>";
                            				$queryPro = mysqli_query($conn, $a);

                            				$i=1;


                            				$dias = mysqli_query($conn, "SELECT DAY(LAST_DAY('$fecha'))");

	                        	            $rows = mysqli_fetch_array($dias);
	                        	            $dia='';
	                        	            $turno='';
	                        	            $turnoNombre='';
	                        	            $tipoProg='';
	                        	            $tipoTurno='';
	                        	            $tipo='';
	                        	            $puestoT = '';
	                        	            $color = '';
	                        	            $turnoSubr = '';

	                        	            while($filas = mysqli_fetch_array($queryPro))
	                        	            {
	                        	            	$turno.=$filas['trnnombre'].',';
	                        	            	$dia.=$filas['dia'].',';
	                        	            	$turnoNombre.=$filas['turno'].',';
	                        	            	$tipoProg.=$filas['tprnombre'].',';
	                        	            	$tipoTurno.=$filas['tipoturno'].',';
	                        	            	$tipo.=$filas['tipo'].',';
	                        	            	$puestoT.=$filas['ptrnombre'].',';
	                        	            	$color.=$filas['trncolor'].',';
	                        	            	$turnoSubr.=$filas['tprcodigo'].',';

	                        	            }

	                        	            $vectorDia      = explode(',',$dia);
	                        	            $vectorTurno    = explode(',',$turno);
	                        	            $vectorTurnoNom = explode(',',$turnoNombre);
	                        	            $vectorTipo     = explode(',',$tipoProg);
	                        	            $vectorTipoTurno= explode(',',$tipoTurno);
	                        	            $vectorTipoProg = explode(',',$tipo);
	                        	            $vectorPuesto   = explode(',',$puestoT);
	                        	            $vectorColor    = explode(',',$color);
	                        	            $vectorTurnoSub = explode(',',$turnoSubr);

	                        	            $j=0;

                            				while ($i <= $rows[0]) 
                            				{
			                        	            if ($vectorDia[$j] == $i) 
			                        	            {

			                        	            	if ($vectorTurnoSub[$j] != 1) 
			                        	            	{
				                        	            	echo '
												<td style="background-color: '.$vectorColor[$j].'; color: #222; white-space: nowrap" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$vectorTipoTurno[$j] . " " . $vectorTurnoNom[$j]. " " . $vectorTipoProg[$j].' - PUESTO: '.$vectorPuesto[$j].'">
													<span><u>'.$vectorTurno[$j] . " ". $vectorTipo[$j].'</u></span>
												</td>';			                        	            		
			                        	            	}
			                        	            	else
			                        	            	{
			                        	            		echo '
												<td style="background-color: '.$vectorColor[$j].'; color: #222; white-space: nowrap" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$vectorTipoTurno[$j] . " " . $vectorTurnoNom[$j]. " " . $vectorTipoProg[$j].' - PUESTO: '.$vectorPuesto[$j].'">
													<span>'.$vectorTurno[$j] . " </span> ". $vectorTipo[$j].'</span>
												</td>';
			                        	            	}


			                        	            	$j++;
			                        	            }
		                            				else
		                            				{

		                            					$d = "SELECT a.clbcodigo, b.slnnombre FROM btyprogramacion_colaboradores a JOIN btysalon b ON b.slncodigo=a.slncodigo WHERE a.clbcodigo = '".$row['clbcodigo']."' AND MONTH(a.prgfecha) = MONTH('$fecha') AND DAY(a.prgfecha)='".$i."' AND NOT a.slncodigo='".$_GET['slncodigo']."'";

		                            					//echo $d;

		                            					$QueryProg = mysqli_query($conn, $d);
		          


		                            					if (mysqli_num_rows($QueryProg) > 0) 
		                            					{
		                            						while ($h = mysqli_fetch_array($QueryProg)) 
		                            						{
		                            							echo '<td data-toggle="tooltip" data-placement="top" data-container="body" title="'.$h['slnnombre'].'"><center><b><i class="pe-7s-less fa-2x" style="color: black"></i></b></center></td>';                    							
		                            						}
		                            					}
		                            					else
		                            					{
		                            						echo '<td></td>';
		                            					}

		                            				     //echo '<td>'.$j.'</td>';
		                            				     //$j++;                            				 	
		                            				}
                            			      
                            				     $i++;
	                        	            }
	                        	            	
	                        	            echo '</tr>';
	                        	      }//WHILE END                           	

                            	
                             ?>             
                    
                     </tbody>
                </table>

			</div>
			</div>
		</div>
	</div>
</div>
</div>


<!-- Modal Filtro Cargos -->
<div class="modal fade" id="modalFiltro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-filter"></i> Filtrar Cargo</h4>
      </div>
      <div class="modal-body">
            <div class="panel panel-info">
            	<form  id="formModal"> 			
            		
	            	<div class="panel-body">
	            		<select  class="selCargo" id="tr" name="cargos" multiple="multiple" style="width: 100%">
	            			<?php 
	            				$sql = mysqli_query($conn, "SELECT a.crgcodigo, a.crgnombre FROM btycargo a WHERE a.crgestado = 1 ORDER BY a.crgnombre");

	            				while ($row = mysqli_fetch_array($sql)) 
	            				{
	            					echo '<option value="'.$row['crgcodigo'].'">'.utf8_encode($row['crgnombre']).'</option>';
	            				}
	            			 ?>
	            		</select>
	            	</div>
	            </form>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnBUscarFiltro">Buscar</button>
      </div>
    </div>
  </div>
</div>


<style type="text/css">
	td,th
	{
		font-size: .8em;
	}
</style>



<script>
	$(document).ready(function() {
	    $('[data-toggle="tooltip"]').tooltip(); 

	    //$('[data-toggle="popover"]').popover(); 

	    $('.selCargo').select2({
    			placeholder: "SELECCIONE CARGOS"
		});            			
		
	});


	$(document).on('click', '#btnModal', function() 
	{
		$('#modalFiltro').modal("show");
		//$(".selCargo").empty().trigger('change');

	});


	$('#modalFiltro').on('shown.bs.modal', function () {

		$(document).on('click', '#btnBUscarFiltro', function() 
		{
			var crgcodigo = $("#tr").val();
			if (crgcodigo == null) 
			{
				swal("Debe seleccionar un cargo", "", "warning");
			}
			else
			{
				var datos='slncodigo='+$('#slncodigo').val()+'&crgcodigo='+$("#tr").val()+'&fecha='+$('#fecha').val();
				console.log(datos);

				$.ajax({
					url: 'process.php',
					method: 'POST',
					data: datos,
					success: function (data) 
					{
						
					      $('#modalFiltro').modal("hide");
						$('#divTabla').empty();
					      $('#divTabla').html(data);
					      $("#tr").select2("val", "");						
						
					}
				});
				
			}
	 
		});
	});
	
$(document).ready(function() {
        conteoPermisos ();
});
</script>




