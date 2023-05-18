<?php 
	include("head.php");
	include("../cnx_data.php"); 
	include("librerias_js.php");

	$salon =$_SESSION['PDVslnNombre'];	
?>

<input type="hidden" value="<?php echo $salon ?>" class="sln">
<input type="hidden" value="<?php echo $_SESSION['PDVslncodigo'] ?>" id="cod_salon">

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="content animate-panel">
				<div class="row">
					<div class="hpanel">
						<div class="panel-heading">				           
				            BIOMÉTRICO				           
				        </div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-info">
										<div class="panel-heading">											
											<h3 class="panel-title"><i class="pe-7s-note2"></i> <span id="novdect">0 </span> <a herf="javascript:void(0)" class="pull-right" id="btnReportePDF" title="Ver Reporte PDF"><i class="fa fa-file-pdf-o"></i></a></h3>
										</div>

										<div class="panel-body">
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="tblBiometricoDet" style="width: 100%;">
													<thead>
														<tr>	
															<th style="display: none">CODIGO</th>				
															<th> COLABORADOR</th>
															<th>CARGO</th>
															<th>PERFIL</th>
															<th>TOTAL</th>
															<th>NOVEDADES</th>
														</tr>
													</thead>
													<tbody>
														
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- Fin Container -->


<!-- Inicio Modal detalle cita -->
<div class="modal fade" id="modalDetalleCita" data-backdrop="static" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h6 class="modal-title" id="">Programación Colaborador</h6>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<center><img src="" class="img-responsive img-thumbnail" alt="" id="imagen" style="width: 100px; height: 100px;"></center><br>
						<center><span class="label label-info" id="cargo"></span></center>
						<hr>	
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Colaborador</label>
							<input type="text" id="colaborador" placeholder="Colaborador" disabled class="form-control" style="font-size: .9em;">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Turno</label>
							<input type="text" id="turno" placeholder="Turno" disabled class="form-control" style="font-size: .9em;">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Fecha</label>
							<input type="date" id="fecha" placeholder="Fecha" disabled class="form-control">
							
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Día</label>
							<input type="text" id="dia" placeholder="Día" disabled class="form-control">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Desde</label>
							<input type="text" id="desde" placeholder="Desde" disabled class="form-control">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Hasta</label>
							<input type="text" id="hasta" placeholder="Hasta" disabled class="form-control">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Tipo Turno</label>
							<input type="text" id="tipoturno" placeholder="Tipo turno" disabled class="form-control">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Puesto de Trabajo</label>
							<input type="text" id="ptrabajo" placeholder="Puesto de Trabajo" disabled class="form-control">
						</div>
					</div>
				</div>
					
				<br>
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive" id="tablaNovedades">
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="btnCerrarModalDetalle" data-dismiss="modal" onclick="cerrarDetalleModal()">Cerrar</button>
				<button type="button" class="btn btn-success" id="btnActualizarModalDetalle" style="display: none" disabled>Actualizar</button>
			</div>
		</div>
	</div>
</div><!-- Fin Modal detalle cita -->


<!-- Modal Ver Salon -->
<div class="modal fade" id="modalVerSalon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="title_imagen">Imagen Salón</h4>
      		</div>
      		<div class="modal-body">
          		<img id="imagen_salon" src="" alt="Salón" class="img-responsive">
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      		</div>
    	</div>
  	</div>
</div>

<!-- Modal colaborares en el turno -->
<div class="modal fade" tabindex="-1" role="dialog" id="my_modal">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h5 class="modal-title">Colaboradores en el turno </h5>
	        	<span class="label label-info" id="fec_prg"></span>
	      	</div>
        
      		<div class="modal-body">
      			<div id="lista"></div>

      			<div class="modal-footer">
        			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>       
      			</div>        
    		</div>
  		</div>
	</div>
</div> <!-- Fin colaborares en el turno -->


<!-- Modal Observaciones-->
<div class="modal fade" id="modalObservaciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h5 class="" id="h5obs"></h5>
      		</div>
		     <div class="modal-body">
		        <form action="" method="POST" role="form">
		          	<input type="hidden" id="clbcodigo">
		          	<input type="hidden" id="trncodigo"> 
		          	<input type="hidden" id="horcodigo"> 
		          	<input type="hidden" id="slncodigo"> 
		          	<input type="hidden" id="prgfecha"> 
		          	<input type="hidden" id="abmcodigo">
		          	<input type="hidden" id="aptcodigo"> 

		          	<div class="form-group">
		          		<textarea name="" id="obs" class="form-control" rows="3" placeholder="Digite Observaciones" style="resize: none;"></textarea>
		          	</div>
		        </form>
		    </div>

      		<div class="modal-footer">
        		<button type="button" class="btn btn-info" id="btnIngObser" title="Guardar Observación"><i class="pe-7s-diskette"></i></button>
      		</div>
    	</div>
  	</div>
</div><!-- Fin Observaciones-->


<!-- Modal Ver Salon -->
<div class="modal fade" id="modalVerObservaciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h5 class="modal-title" id="colaboradorObs" style="font-size: 1.4em!important"></h5>
      		</div>
      		<div class="modal-body">
      	  		<div class="panel panel-info">
      	  			<div class="panel-heading">
      	  				<h3 class="panel-title"><i class="fa fa-comment"></i> OBSERVACIÓN</h3>
      	  			</div>
      	  			<div class="panel-body">
          	   			<h6  id="verObser"></h6>
      	  			</div>
      	  		</div>
      		</div>

      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      		</div>
    	</div>
  	</div>
</div>



<!-- Modal Ver Detalles de Colaborador en Biometrico -->
<div class="modal fade" id="modalDetalleCol" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-lg" role="document" style="width: 80%;">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h5 class="modal-title" id="nombreCol"></h5>
      		</div>
      		<div class="modal-body">          	          
	          	<table class="table table-hover table-bordered" id="tblDetalles">
	          		<thead>
	          			<tr>
	          				<th>Fecha</th>
	          				<th>Turno</th>
	          				<th>Salón</th>
	          				<th>Registro</th>
	          				<th>Hora Registro</th>
	          				<th>Resultado</th>
	          				<th>Valor</th>
							<th></th>
	          			</tr>
	          		</thead>
	          		<tbody>
	          			
	          		</tbody>
	          	</table>
      		</div>
    	</div>
  	</div>
</div>
<!-- Fin Ver Detalles de Colaborador en Biometrico -->


<!-- Modal Servicios -->
<div class="modal fade" id="modalServicios" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Servicios del colaborador</h4>
			</div>
			<div class="modal-body">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Servicios Autorizados</h3>
					</div>
			  		
			  		<div class="panel-body">
			    		<div class="row">
							<div class="col-xs-3">
								<img src="" id="imagenColaboradorServicio" alt="Imagen colaborador" class="img-thumbail img-responsive" width="180" height="180">
							</div>
							<div class="col-xs-9">
							    <div class="form-group">
									<div class="col-sm-12">
										<input type="hidden" id="txtCodigoColaborador">
									</div>
								</div>								

					            <div class="form-group">                  
					            	<div id="listaData"></div>         
					            </div>						
							</div>
						</div> 
			  		</div>
				</div>
			
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive" id="">                             
					    	<table class="table table-hover table-bordered table-striped" id="tblLista" style="width: 100%">
            					<thead>
					              	<tr class="info">
					                	<th>Servicio</th>
					                	<th>Duración</th> 
					              	</tr>         
            					</thead>

            					<tbody>

            					</tbody>                        
        					</table>	                  
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" title="Cerrar ventana">Cerrar</button>
			</div>
		</div>
	</div>
</div>



<!-- Modal Comentario Biometrico Individual -->
<div class="modal fade" id="modalObserInd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="myModalLabel">Observaciones</h4>
      		</div>
	      	<div class="modal-body">
		   		<input type="hidden" id="clbcodigo_">
		     	<input type="hidden" id="trncodigo_"> 
		     	<input type="hidden" id="horcodigo_"> 
		     	<input type="hidden" id="slncodigo_"> 
		     	<input type="hidden" id="prgfecha_"> 
		     	<input type="hidden" id="abmcodigo_">
		     	<input type="hidden" id="aptcodigo_"> 
	        	<div class="form-group">
	        		<label for="">Ingrese</label>
	        		<textarea name="" id="textObervacion" placeholder="Digite su observación" class="form-control" rows="3" required="required" style="resize: none"></textarea>
	        	</div>
	      	</div>
      		
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        		<button type="button" id="btnGuardarObs" class="btn btn-primary">Guardar</button>
      		</div>
    	</div>
  	</div>
</div><!-- Fin Comentario Biometrico Individual -->


<!-- Modal Reporte-->
<div class="modal fade" id="modalReporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-sm" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 id="myModalLabel">Seleccionar Tipo Reporte</h4>
      		</div>
      		<div class="modal-body">
         		<div class="panel panel-info">
             		<div class="panel-heading">
                 		<h3 class="panel-title"></h3>
             		</div>
             		<div class="panel-body">
	                    <select name="" id="selReport" class="form-control" required="required">
	                        <option value="1">AGENDA</option>
	                        <option value="2">BIOMÉTRICO</option>
	                    </select>
             		</div>
         		</div>
      		</div>

      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        		<button type="button" class="btn btn-primary" id="btnIr">Ir</button>
      		</div>
    	</div>
  	</div>
</div>

<script src="js/biometricoo.js"></script>
<script src="js/sube_baja.js"></script>

<style>
	th, td
	{
		white-space: nowrap;
	}

	th
	{
		text-align: center;
	}

	.codcol, .codhor, .codtur, .codsln, .fechaCod, .aptcod, .abmcodigo
	{
		display: none;
	}

	.total
	{
		text-align: right;
	}

</style>

<script>

$(document).on('click', '.sln_nombre', function() 
{
	    var id = $('#cod_salon').val();
	    $('#modalVerSalon').modal("show");
	    $('body').removeClass("modal-open");
	    $('body').removeAttr("style");

	   	$.ajax({
	        url: 'php/sube_baja/cargar_imagen_sln.php',
	        method: 'POST',
	        data: {id:id},
	        success: function (data) 
	        {
	            var array = eval(data);
	            for(var i in array)
	            {
	                $('#title_imagen').html("Salón "+array[i].nombre);
	                $("#imagen_salon").removeAttr("src");        
	                $('#imagen_salon').attr("src", "../contenidos/imagenes/salon/"+array[i].imagen);
	            }
	        }
	   });
});


$(document).on('click', '.btnModalReporte', function(event) 
{
    $('#modalReporte').modal("show");
});

$(document).on('click', '#btnIr', function(event) 
{
    var sel = $('#selReport').val();

    switch (sel) 
    {
        case '1':
            window.location="reporteAgenda.php";
            break;

        case '2':
            window.location="reporteBiometrico.php";
            break;
        default:
            break;
    }
});


$(document).on('click', '#btn_ver_servicios', function() 
{
    var cod_col  = $(this).data("id_col");
    var img      = $(this).data("img");
    var cargo_   = $(this).data("cargo");
    var nom_col  = $(this).data("nombrecol");

    load_service (cod_col);
    $.ajax({
     	url: 'php/sube_baja/mostrar_servicios.php',
     	method: 'POST',
     	data: {cod_col:cod_col, buscar:"no"},
     	success: function (data) 
     	{


     		var jsonServicios = JSON.parse(data);

            	var imagen   = 	"";
     			var cod      = 	"";
     			var nombre   = 	"";
     			var cargo    = 	"";
     		    var servicio = 	"";
     		    var duracion =  "";
     		
	     		$('#tbl_servicios tbody').empty();
	     		$('#nombreColaboradorServicio').empty();
	            $('#cargoColaboradorServicio').empty(); 


	            	if (jsonServicios.res == "full") 
     				{

     					for(var i in jsonServicios.json)
			            {                  

     						$('#listaData').empty();

		            		if(jsonServicios.json[i].img_servici == "default.jpg" || jsonServicios.json[i].img_servici == null )
		            		{
								imagen = "contenidos/imagenes/default.jpg";
							}
							else
							{
								imagen = "../contenidos/imagenes/colaborador/beauty_erp/"+jsonServicios.json[i].img_servici+"";
							}

							$('#imagenColaboradorServicio').attr("src", ""+imagen+"").addClass('img-responsive, img-thumbnail');
		     				$('#imagenColaboradorServicio').attr('title', jsonServicios.json[i].nom_colabor);
		     				$('#txtCodigoColaborador').val(jsonServicios.json[i].cod_colabor);
		     				$('#listaData').html('<div class="list-group"><button type="button" title="'+jsonServicios.json[i].nom_colabor+'" class="list-group-item success"><b>NOMBRE:</b> '+jsonServicios.json[i].nom_colabor+'</button><button type="button" title="'+jsonServicios.json[i].cargo_colab+'" class="list-group-item"><b>CARGO:</b> '+jsonServicios.json[i].cargo_colab+'</button><button type="button" title="'+jsonServicios.json[i].salon_base+'" class="list-group-item"><b>SALÓN BASE:</b> '+jsonServicios.json[i].salon_base+'</button><button type="button" title="'+jsonServicios.json[i].categoria+'" class="list-group-item"><b>CATEGORÍA:</b> '+jsonServicios.json[i].categoria+'</button></div>');
			            }
		     		}
		     		else
		     		{

		     			var jsonServicios2 = JSON.parse(data);

		     			for(var j in jsonServicios2.json)
			            {			            		                  

     						$('#listaData').empty();

		            		if(jsonServicios2.json[j].img_servici == "default.jpg" || jsonServicios2.json[j].img_servici == null )
		            		{
								imagen = "contenidos/imagenes/default.jpg";
							}
							else
							{
								imagen = "../contenidos/imagenes/colaborador/beauty_erp/"+jsonServicios2.json[j].img_servici+"";
							}

							$('#imagenColaboradorServicio').attr("src", ""+imagen+"").addClass('img-responsive, img-thumbnail');
		     				$('#imagenColaboradorServicio').attr('title', jsonServicios2.json[j].nom_colabor);
		     				$('#listaData').html('<div class="list-group"><button type="button" title="'+jsonServicios2.json[j].nom_colabor+'" class="list-group-item success"><b>NOMBRE:</b> '+jsonServicios2.json[j].nom_colabor+'</button><button type="button" title="'+jsonServicios2.json[j].cargo_colab+'" class="list-group-item"><b>CARGO:</b> '+jsonServicios2.json[j].cargo_colab+'</button><button type="button" title="'+jsonServicios2.json[j].salon_base+'" class="list-group-item"><b>SALÓN BASE:</b> '+jsonServicios2.json[j].salon_base+'</button><button type="button" title="'+jsonServicios2.json[j].categoria+'" class="list-group-item"><b>CATEGORÍA:</b> '+jsonServicios2.json[j].categoria+'</button></div>');

			            }
		     		}	
		}
     	
    });
});


</script>