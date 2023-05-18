<?php 
	include("head.php");
	include("php/conexion.php");
    VerificarPrivilegio("PERMISOS (PDV)",$_SESSION['PDVtipo_u'],$conn);


    
	include("librerias_js.php");

	$salon =$_SESSION['PDVslnNombre'];
	
?>

<input type="hidden" value="<?php echo $salon ?>" class="sln">
<input type="hidden" value="<?php echo $_SESSION['PDVslncodigo'] ?>" id="cod_salon">

<script>
	$(document).ready(function() {

		

		/*$('#modalDetalleCita').on('shown.bs.modal', function () {
 					$('body .fixed-navbar').removeClass("modal-open");
        });*/
        //$('body').removeAttr('style');
 	});



   
</script>


<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="content animate-panel">
				<div class="row">
					<div class="hpanel">
						<div class="panel-heading">
				            <!-- <div class="panel-tools">
				                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
				            				           </div> -->
				            CALENDARIO 
				            <button class="btn btn-default pull-right" id="btnReporte" title="Reporte de la programación por mes">
                                <span class="fa fa-file-pdf-o text-info"></span>
                            </button>
                            <input type="text" id="fechaPro" class="form-control" placeholder="0000-00-00" style="width: 30%">
				        </div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<div id="calendar"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



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
	</div>


<script src="php/programacion_pdv/progra_pdv.js"></script>
<script src="js/sube_baja.js"></script>


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
        
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div> <!-- colaborares en el turno -->


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
										<!-- <label class="label label-success" id="nombreColaboradorServicio"></label> -->					
									</div>
                  <div class="form-group">                  
                      <div id="listaData"></div>         
                  </div>
								<!--   <div class="form-group">
                  <label class="label label-warning" id="cargoColaboradorServicio"></label>
                
                </div> -->
									
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


<!-- Modal -->
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

<script>






$(document).on('click', '.sln_nombre', function() {
    var id = $('#cod_salon').val();
    $('#modalVerSalon').modal("show");
    $('body').removeClass("modal-open");
    $('body').removeAttr("style");

   $.ajax({
        url: 'php/sube_baja/cargar_imagen_sln.php',
        method: 'POST',
        data: {id:id},
        success: function (data) {
            var array = eval(data);
            for(var i in array){
                $('#title_imagen').html("Salón "+array[i].nombre);
                $("#imagen_salon").removeAttr("src");        
                $('#imagen_salon').attr("src", "../contenidos/imagenes/salon/"+array[i].imagen);
            }
        }
   });
});


/*===========================================
=            MODAL VER SERVICIOS            =
===========================================*/

$(document).ready(function() {
	
$('#inputbuscar').keyup(function(){
        var servicio = $(this).val();     
        
        $.ajax({
            type: "POST",
            url: "php/sube_baja/buscar_servicios.php",
            data: {servicio:servicio, cod:$('#txtCodigoColaborador').val()},
            success: function(data) {
                $('#list').html(data);
            }
        });

    }); 
$(document).on('click', '#btn_paginar', function() {
        var data = $(this).data("id");
        $.ajax({
        type: "POST",
        url: "php/sube_baja/lista_servicios.php",
        data: {page: data, cod: $('#txtCodigoColaborador').val()},
        success: function (data) {
           $('#list').html(data);
        }
    });
});
});



$(document).on('click', '#btn_ver_servicios', function() {
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
     		    	var duracion =    "";
     		
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
            // statements_def
            break;
    }
});


/*=====  End of MODAL VER SERVICIOS  ======*/


var date = new Date();
	var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

    $.fn.datepicker.dates['es'] = {
    days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
    daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
    daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
    months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
    today: "Today",
    weekStart: 0
};




$('#fechaPro').datepicker({ 
    format: "yyyy-mm-dd",
    setDate: "today",
    language: 'es',
});

$('#fechaPro').on('changeDate', function(ev)
{
    $(this).datepicker('hide');

    var fecha = $('#fechaPro').val();
    window.open("vistaProgramacion.php?fecha="+fecha+"&slncodigo="+$('#cod_salon').val()+" ",'_blank'); 
});





</script>