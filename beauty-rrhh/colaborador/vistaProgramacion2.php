<?php


	function quitar_tildes($cadena) {
		$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
		$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
		$texto = str_replace($no_permitidas, $permitidas ,$cadena);
		return $texto;
	}



	///////////////////////////////////////////////////////////////////////////////////////////////
    include("../head.php");

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
<?php include "../librerias_js.php" ?>
<style type="text/css" media="screen">
	@media (min-width: 1200px) {
	   .modal-xlg {
	      width: 90%; 
	   }
	}
</style>
<div class="content">

<input type="hidden" id="slncodigo" value="<?php echo $_GET['slncodigo']; ?>">
<input type="hidden" id="fecha" value="<?php echo $_GET['fecha']; ?>">
<input type="hidden" id="usucod" value="<?php echo $_SESSION['codigoUsuario']?>">
<div class="row">
    <div class="col-lg-12">
        <div class="hpanel">
            <div class="panel-heading">
               <?php 
               	$sql = mysqli_query($conn, "SELECT slnnombre FROM btysalon WHERE slncodigo = '".$_GET['slncodigo']."' AND slnestado = 1");

               	$fetch = mysqli_fetch_array($sql);

               	echo "<h3> VISTA GENERAL DE PROGRAMACIÓN SALÓN " . "<b>" . $fetch['slnnombre'] ."</b> MES DE <b>".  $mes.'-'.$vec[0].'</b></h3>' ;

                ?>
                <div class="row">
                	<div class="col-md-3">
                		<select id="slsalon" class="form-control"></select>
                	</div>
                	<div class="col-md-9">
                		<a id="prevmes" data-toggle="tooltip" data-placement="top" title="Ir a mes anterior" class="btn btn-info" style="color:white;"><i class="fa fa-angle-double-left"></i> Mes anterior</a>
	                    <a href="aaprog.php" data-toggle="tooltip" data-placement="top" title="Ir a Crear programación" class="btn btn-info" style="color:white;"><i class="fa fa-plus"></i> Crear programación</a>
	                    <a data-toggle="modal" href='#modal-editpro' data-toggle="tooltip" data-placement="top" title="Editar Programacion de colaborador" class="btn btn-info edtprog" style="color:white;"><i class="fa fa-edit"></i> Editar</a>
	                    <a id="btnlog" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Muestra el registro de cambios en programación"><i class="fa fa-eye"></i> Consulta de Cambios</a>
	                    <a id="btnocu" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Muestra la ocupación de puestos en una fecha dada"><i class="fa fa-list"></i> Ocupacion de puestos</a>
						<a id="nxtmes" data-toggle="tooltip" data-placement="top" title="Ir a siguiente mes" class="btn btn-info" style="color:white;">Siguiente mes <i class="fa fa-angle-double-right"></i></a>
                	</div>
                </div>
            </div>
            <h4 class="loadmsj"><i class="fa fa-spin fa-spinner"></i> Cargando, por favor espere...</h4>
            <div class="panel-body">
            	<div class='table-cont hidden' id='table-cont'>
                	<table id="grilla" class="grilla table table-hover table-bordered" cellpadding="0" cellspacing="0">
                  	<thead>
                  	<tr>
                  		<th rowspan="2" class="text-center" style="vertical-align:middle;">
                            COLABORADOR<br><span> <i class="fa fa-filter text-info" id="btnModal" style="cursor: pointer;"></i></span><br>
                        </th>
                        <th rowspan="2" class="text-center" style="vertical-align:middle;">CARGO</th>
                        
                  		<?php 

                  			$dias = mysqli_query($conn, "SELECT DAY(LAST_DAY('$fecha')), MONTH('$fecha') ");

	                        	$rows = mysqli_fetch_array($dias); 

	                        	$semana = array('LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO');



	                        	$primerDia = mysqli_query($conn, "SET lc_time_names = 'es_CO';");

	                        	$y ="SELECT UCASE(DAYNAME(CAST(DATE_FORMAT('$fecha' ,'%Y-%m-01') as DATE)))";
	                        	

	                        	$primerDia = mysqli_query($conn, $y);


	                        	$filaDias = mysqli_fetch_array($primerDia);                 				
	                        	$filaDias[0]=quitar_tildes(utf8_encode($filaDias[0]));
	     
			                  					
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

	                        	$primerDia = mysqli_query($conn, $y);


	                        	$filaDias = mysqli_fetch_array($primerDia);   
	                        	$filaDias[0]=quitar_tildes(utf8_encode($filaDias[0]));

	                        	$queryFes = mysqli_query($conn, "SELECT DAY(a.fesfecha)AS dia, a.fesobservacion FROM btyfechas_especiales a WHERE MONTH(a.fesfecha) = MONTH('$fecha') and year(a.fesfecha)= year(curdate()) ORDER BY dia");

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


                            	$sql = mysqli_query($conn, "SELECT DISTINCT a.clbcodigo, c.trcrazonsocial, crg.crgalias, crg.crgcodigo FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo WHERE MONTH(a.prgfecha) = MONTH('$fecha') AND YEAR(a.prgfecha) = YEAR('$fecha')  AND a.slncodigo = '".$_GET['slncodigo']."' ORDER BY crg.crgnombre,c.trcrazonsocial");

                    
                            		while ($row = mysqli_fetch_array($sql)) 
                            		{
                            			echo '<tr class="crg'.$row['crgcodigo'].' resgrid" data-crg="'.$row['crgcodigo'].'">
			            		<td class="datacol" style="white-space: nowrap" data-clb="'.$row['clbcodigo'].'">'.utf8_encode($row['trcrazonsocial']).'</td><td><b>'.$row['crgalias'].'</b></td>';

                            			$a="SELECT SUBSTRING(b.trnnombre, 1, 2)AS trnnombre, DAY(a.prgfecha)AS dia, b.trnnombre AS tipoturno, a.trncodigo, c.tprcodigo, CONCAT(TIME_FORMAT(b.trndesde,'%H:%i'), ' a ', TIME_FORMAT(b.trnhasta, '%H:%i')) AS turno, b.trndesde, b.trnhasta, SUBSTRING(c.tprnombre, 1,1) AS tprnombre, c.tprnombre AS tipo, pt.ptrnombre, b.trncolor FROM btyprogramacion_colaboradores a JOIN btyturno b ON a.trncodigo=b.trncodigo JOIN btytipo_programacion c ON c.tprcodigo=a.tprcodigo JOIN btypuesto_trabajo pt ON pt.ptrcodigo=a.ptrcodigo WHERE a.slncodigo = '".$_GET['slncodigo']."' AND MONTH(a.prgfecha) = MONTH('$fecha') AND YEAR(a.prgfecha) = YEAR('$fecha') AND a.clbcodigo = '".$row['clbcodigo']."' ORDER BY a.prgfecha";

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
												<td style="background-color: gray; color: #222; white-space: nowrap" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$vectorTipoTurno[$j] . " " . $vectorTurnoNom[$j]. " " . $vectorTipoProg[$j].' - PUESTO: '.$vectorPuesto[$j].'">
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

		                            					$d = "SELECT a.clbcodigo, b.slnnombre FROM btyprogramacion_colaboradores a JOIN btysalon b ON b.slncodigo=a.slncodigo WHERE a.clbcodigo = '".$row['clbcodigo']."' AND MONTH(a.prgfecha) = MONTH('$fecha') AND YEAR(a.prgfecha) = YEAR('$fecha') AND DAY(a.prgfecha)='".$i."' AND NOT a.slncodigo='".$_GET['slncodigo']."'";

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

<!-- Modal Editar programación -->
<div class="modal fade" id="modal-editpro">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-edit"></i> Editar programación</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="mdlistcol">Colaborador</label>
					<select id="mdlistcol" class="form-control mdlistcol"></select>
				</div>
				<div class="form-group">
					<label for="mdfecha">Fecha</label>
					<input id="mdfecha" class="form-control calendario" placeholder="Click para seleccionar fecha..." readonly="">
				</div>
				<div class="form-group">
					<div class="row">
    					<div class="col-md-12 accion">
	    					<label for="mdaccion">Acción a ejecutar</label>
	    					<select id="mdaccion" class="form-control" style="font-family:'FontAwesome', Arial;"></select>
    					</div>
    					<div class="col-md-6 actividad hidden">
    						<label for="mdtilab">Tipo de actividad</label>
	    					<select id="mdtilab" class="form-control"></select>
    					</div>
					</div>
				</div>
				<div class="form-group">
					<label for="mdobser">Justificación del cambio (Obligatorio)</label>
					<textarea id="mdobser" class="form-control" style="resize: none;" rows="3" placeholder="Describa detalladamente la razón del cambio. Longitud mínima: 10 caracteres"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button id="snddata" type="button" class="btn btn-primary">Guardar cambios</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal logs programacion -->
<div class="modal fade" id="modal-logs">
	<div class="modal-dialog modal-xlg">
		<div class="modal-content">
			<div class="modal-header">
				<span class="btn btn-info contlog pull-right"></span>
				<h4 class="modal-title"><i class="fa fa-eye"></i> Registro de cambios</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<select id="loglistcol" class="form-control mdlistcol"></select>
				</div>
				<div class="preres hidden"></div>
				<div class="reslog hidden" class="table-responsive">
					<table class="tbres table table-hover">
						<thead>
							<tr>
								<th>Tipo</th>
								<th>Fecha</th>
								<th>Dato original</th>
								<th>Dato cambiado a</th>
								<th>Motivo del cambio</th>
								<th>Fecha cambio</th>
								<th>Realizado por</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Ocupacion puesto/fecha -->
<div class="modal fade" id="modal-ocu">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-list"></i> Ocupación de puestos por fecha</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<input id="ocufecha" class="form-control calendario" placeholder="Click para seleccionar fecha..." readonly>
				</div>
				<div class="row">
					<table class="table table-hover tbocusalon hidden">
						<thead>
							<tr>
								<th class="text-center">Puesto</th>
								<th class="text-center">Ocupado</th>
								<th class="text-center">Cargo</th>
							</tr>
						</thead>
						<tbody class=""></tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>


<style type="text/css">

	td,th{
		font-size: .8em;
	}
	.table-cont{
	  max-height: 400px; 
	  overflow: auto;
	} 
	
</style>
<script src="../../lib/vendor/ajftm/dist/js/freeze-table.js"></script>
<script type="text/javascript">
	window.onload = function(){
	  $(".table-cont").freezeTable({
	  	columnNum: 2,
	  	scrollable: true,
	  });

	  $(".loadmsj").addClass('hidden');
	  $("#table-cont").removeClass('hidden');
	  $(".table-cont").freezeTable('update');
	}
</script>
<script>
	$(document).ready(function() 
	{
	    $('[data-toggle="tooltip"]').tooltip(); 

	    	$('.selCargo').select2({
    			placeholder: "SELECCIONE CARGOS"
		});  
	    loadsln();
		loadselcol();  
		loadtilab();  
		$(".calendario").datepicker({
			format: 'yyyy-mm-dd',
		    startDate: 0,
		    autoclose: true,
		    //multidate: true,
		});
		var globaldate=$("#fecha").val().split('-');
		var yr=globaldate[0];
		var mes=globaldate[1];
		var udm=lastday(yr,mes);
		var today=new Date();
		var mesactual=today.getMonth()+1;
		$(".calendario").datepicker('setStartDate', yr+'-'+mes+'-01');
		$("#ocufecha").datepicker('setStartDate', yr+'-'+mes+'-01');
		$(".calendario").datepicker('setEndDate', yr+'-'+mes+'-'+udm);        			
		$("#ocufecha").datepicker('setEndDate', yr+'-'+mes+'-'+udm);        			
		
	});

	var lastday = function(y,m){
		return  new Date(y, m , 0).getDate();
	}



	$(document).on('click', '#btnModal', function() 
	{
		$('#modalFiltro').modal("show");

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
				$(".resgrid").hide();
				if(crgcodigo.length>1){
					for(var k=0;k<=crgcodigo.length;k++){
						$(".crg"+crgcodigo[k]).show();
					}
				}else{
					$(".crg"+crgcodigo).show();
				}

				$('#modalFiltro').modal('hide');			}
	 
		});
	});
	
	$(document).ready(function() 
	{
	    conteoPermisos ();
	});
	$("#slsalon").change(function(e){
		var sln=$(this).val();
		var fecha=$("#fecha").val();
		$("#divTabla").empty().html('<i class="fa fa-spin fa-spinner"></i> Cargando datos, por favor espere...');
		window.location.href = "vistaProgramacion.php?slncodigo="+sln+"&fecha="+fecha;
	});
	$("#mdlistcol").change(function(e){
		$("#mdfecha").val('');
		$("#mdaccion").empty();
		$(".actividad").addClass('hidden');
		$("#mdtilab").val('');
	});
	$("#mdfecha").change(function(e){
		$(".actividad").addClass('hidden');
		$("#mdtilab").val('');
		loadacciones();
	});
	$("#mdaccion").change(function(e){
		var opc=$(this).val();
		$("#mdtilab").val('');
		if(opc!='DEL'){
			$(".accion").removeClass('col-md-12').addClass('col-md-6');
			$(".actividad").removeClass('hidden');
		}else{
			$(".accion").removeClass('col-md-6').addClass('col-md-12');
			$(".actividad").addClass('hidden');
		}
	});
	$("#modal-editpro").on('hidden.bs.modal', function(e){
		$("#mdlistcol").val('');
		$("#mdfecha").val('');
		$("#mdaccion").empty();
		$(".actividad").addClass('hidden');
		$("#mdtilab").val('');
	});
	$("#snddata").click(function(e){
		var sln    = $("#slncodigo").val();
		var clb    = $("#mdlistcol").val();
		var fecha  = $("#mdfecha").val();
		var action = $("#mdaccion").val();
		var comment= $("#mdobser").val();
		var usucod = $("#usucod").val();
		if((clb>0)&&(fecha.length==10)&&(action!=null)&&(comment.length>9)){
			if(action=='DEL'){
				$.ajax({
					url:'zprog/fillcont.php',
					type:'POST',
					data:{opc:'modprog',sln:sln,clb:clb,fecha:fecha,action:action,comment:comment,usucod:usucod},
					success:function(res){
						if(res==1){
							$("#modal-editpro").modal('toggle');
							swal({
								title: "Correcto!",
								text: "La programación ha sido modificada exitósamente!",
								type: "success",
								confirmButtonClass: "btn-info",
								closeOnConfirm: false
							},function(isConfirm){
								location.reload();
							})
						}else if(res==2){
							swal('No se puede modficar','El colaborador seleccionado NO TIENE programación el día seleccionado.','warning');
						}else if(res==3){
							swal('Error','Comuniquese con el Dpto de sistemas. Codigo de error: SQL LOG INSERT','error');
						}else if(res==4){
							swal('Error','Comuniquese con el Dpto de sistemas. Codigo de error: SQL OLD-REG UPDATING','error');
						}else{
							swal({
								title: "Error",
								text: "Ha ocurrido un error inesperado, refresque la página e intentelo nuevamente.",
								type: "error",
								confirmButtonClass: "btn-info",
								closeOnConfirm: false
							},function(isConfirm){
								location.reload();
							})
						}
					}
				})
			}else{
				var hor=$("#mdaccion option:selected").data('horario');
				var tiprog=$("#mdtilab").val();
				if(tiprog!=null){
					$.ajax({
						url:'zprog/fillcont.php',
    					type:'POST',
    					data:{opc:'modprog',sln:sln,clb:clb,fecha:fecha,trn:action,hor:hor,tiprog:tiprog,comment:comment,usucod:usucod},
    					success:function(res){
    						if(res==1){
    							$("#modal-editpro").modal('toggle');
							swal({
									title: "Correcto!",
									text: "La programación ha sido modificada exitósamente!",
									type: "success",
									confirmButtonClass: "btn-info",
									closeOnConfirm: false
								},function(isConfirm){
									location.reload();
								})
    						}else if(res==2){
    							swal('No se puede modficar','El colaborador seleccionado NO TIENE programación el día seleccionado','warning');
    						}else if(res==3){
    							swal('Error','Comuniquese con el Dpto de sistemas. Codigo de error: SQL LOG INSERT','error');
    						}else if(res==4){
								swal('Error','Comuniquese con el Dpto de sistemas. Codigo de error: SQL OLD-REG DELETING','error');
    						}else{UPDATING
    							swal({
									title: "Error",
									text: "Ha ocurrido un error inesperado, refresque la página e intentelo nuevamente.",
									type: "error",
									confirmButtonClass: "btn-info",
									closeOnConfirm: false
								},function(isConfirm){
									location.reload();
								})
    						}
    					}
					});
				}else{
					swal('Faltan datos','Elija tipo de actividad','error');
				}
			}
		}else{
			swal('Faltan datos','Complete correctamente TODAS las opciones','error');
		}
		//var ;
	});
</script>
<script type="text/javascript">
	function loadselcol(){
		var opc='<option value="" selected disabled>Seleccione Colaborador...</option>';
		$(".datacol").each(function(e){
			var clbcod=$(this).data('clb');
			var clbnom=$(this).html();
			var crg=$(this).parent().data('crg');
			opc+='<option value="'+clbcod+'" data-crg="'+crg+'">'+clbnom+'</option>';
		})
		$(".mdlistcol").html(opc);
	}
	function loadtilab(){
		$.ajax({
			url:'zprog/fillcont.php',
			type:'POST',
			data:{opc:'tilab'},
			success:function(data){
				var json = JSON.parse(data);
				var opcs = "<option value='' selected disabled>Elija Tipo de actividad</option>";
				for(var i in json){
						opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+"</option>";
                }
                $("#mdtilab").html(opcs);
			}
		})
	}
	function loadacciones(){
		var crg=$("#mdlistcol option:selected").data('crg');
		var fecha=$("#mdfecha").val();
		if((crg>0)&&(fecha.length==10)){
			var arrdt = fecha.split('-');
			var sln=$("#slncodigo").val();
			var diasem=diaSemana(arrdt[2],arrdt[1],arrdt[0]).toUpperCase();
			$("#mdaccion").html('<option selected disabled>cargando, por favor espere...</option>');
			$.ajax({
				url:'zprog/fillcont.php',
				type:'POST',
				data:{opc:'trndia', fecha:fecha, diasem:diasem, sln:sln, crg:crg},
				success:function(res){
					var datahor=JSON.parse(res);
					var opcs='<option value="" selected disabled>Elija una acción...</option><optgroup label="Cambiar turno a:">';
					for(var i in datahor){
						opcs += "<option value='"+datahor[i].codigo+"' data-horario='"+datahor[i].horario+"' style='background-color:"+datahor[i].color+";'>"+datahor[i].nombre+"</option>";
					}
					opcs+='</optgroup><optgroup label="Borrar Programación"><option style="background-color:#FF3333;" value="DEL"><b>&#xf1f8 Eliminar programación del día seleccionado</b></option></optgroup>';
					$("#mdaccion").html(opcs);
				}
			})
		}else{
			swal('Opciones incompletas','Seleccione las opciones correctamente','error');
			$("#mdfecha").val('');
		}
	}
	function diaSemana(dia,mes,anio){
	    var dias=["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"];
	    var dt = new Date(mes+' '+dia+', '+anio+' 12:00:00');
	    return dias[dt.getUTCDay()];    
	}
	$("#nxtmes").click(function(e){
		$("#divTabla").empty().html('<i class="fa fa-spin fa-spinner"></i> Cargando datos, por favor espere...');
		var fecha = $("#fecha").val().split('-');
		var sln = $("#slncodigo").val();
		var nfecha = new Date(fecha[0], fecha[1] - 1, fecha[2]);
		nfecha.setMonth(nfecha.getMonth()+1);
		var mes=nfecha.getMonth()+1;
		var anio=nfecha.getUTCFullYear();
		var nxtm=anio+'-'+mes+'-01';
		window.location.href = "vistaProgramacion.php?slncodigo="+sln+"&fecha="+nxtm;
	});
	$("#prevmes").click(function(e){
		$("#divTabla").empty().html('<i class="fa fa-spin fa-spinner"></i> Cargando datos, por favor espere...');
		var fecha = $("#fecha").val().split('-');
		var sln = $("#slncodigo").val();
		var nfecha = new Date(fecha[0], fecha[1] - 1, fecha[2]);
		nfecha.setMonth(nfecha.getMonth()-1);
		var mes=nfecha.getMonth()+1;
		var anio=nfecha.getUTCFullYear();
		var nxtm=anio+'-'+mes+'-01';
		window.location.href = "vistaProgramacion.php?slncodigo="+sln+"&fecha="+nxtm;
	});
	function loadsln(){
		$.ajax({
			url:'zprog/fillcont.php',
			type:'POST',
			data:{opc:'sln'},
			success:function(data){
				var json = JSON.parse(data);
				var opcs = "<option value='' selected disabled>Cambiar salón...</option>";
				for(var i in json){
					opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+"</option>";
                }
                $("#slsalon").html(opcs);
			}
		})
	}
	$("#btnlog").click(function(e){
		var sln = $("#slncodigo").val();
		var fecha = $("#fecha").val();
		$.ajax({
			url:'zprog/fillcont.php',
			type:'POST',
			data:{opc:'contlog',sln:sln,fecha:fecha},
			success:function(res){
				$(".contlog").html('Total cambios en este salón: '+res);
			}
		})
		$("#modal-logs").modal('show');
	});
	$("#loglistcol").change(function(e){
		var col = $(this).val();
		var sln = $("#slncodigo").val();
		var fecha = $("#fecha").val();
		$(".reslog").addClass('hidden');
		$(".preres").removeClass('hidden');
		$(".preres").html('<i class="fa fa-spin fa-spinner"></i> Cargando datos, por favor espere...');
		$.ajax({
			url:'zprog/fillcont.php',
			type:'POST',
			data:{opc:'seelog', col:col, sln:sln, fecha:fecha},
			success:function(res){
				var json=JSON.parse(res);
				var row='';
				if(json!=null){
					for(var i in json){
						row += "<tr><td>"+json[i].tipo+"</td><td>"+json[i].fecha+"</td><td>"+json[i].orig+"</td><td>"+json[i].cambio+"</td><td>"+json[i].motivo+"</td><td>"+json[i].datecam+"</td><td>"+json[i].usuario+"</td></tr>";
					}
					$(".tbres tbody").html(row);
					$(".preres").addClass('hidden').empty();
					$(".reslog").removeClass('hidden');
				}else{
					$(".preres").html('<i class="fa fa-info-circle"></i> En este salón no hay cambios registrados para el colaborador seleccionado');
				}
			}
		})
	});
</script>
<script type="text/javascript">
	$("#btnocu").click(function(e){
		$("#modal-ocu").modal('show');
	})
	$("#ocufecha").change(function(e){
		$(".tbocusalon").removeClass('hidden');
		$(".tbocusalon tbody").empty().html('<i class="fa fa-spin fa-spinner"></i> Cargando, pro favor espere...');
		var sln=$("#slncodigo").val();
		var fecha=$(this).val();
		$.ajax({
			url:'zprog/fillcont.php',
			type:'POST',
			data:{opc:'ocu',sln:sln,fecha:fecha},
			success:function(res){
				var json = JSON.parse(res);
				var tabla='';
				for(var i in json){
					if(json[i].ocu==1){
						icon='<i class="fa fa-check" style="color:green;"></i>';
					}else{
						icon='<i class="fa fa-times text-danger"></i>';
					}
					tabla+='<tr><td class="text-center">'+json[i].pto+'</td><td class="text-center">'+icon+'</td><td class="text-center">'+json[i].crg+'</td></tr>';
				}
				$(".tbocusalon tbody").html(tabla);
			}
		})
	})
</script>


