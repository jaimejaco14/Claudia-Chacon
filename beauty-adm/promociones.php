<?php 
	include '../cnx_data.php';
  include "./librerias_js.php";
  include("head.php");
?>
<div class="small-header">
    	<div class="hpanel">
        	<div class="panel-body">
	            <a class="small-header-action" href="">
	                <div class="clip-header">
	                    <i class="fa fa-arrow-up"></i>
	                </div>
	            </a>

	            <div id="hbreadcrumb" class="pull-right m-t-lg">
	                <ol class="hbreadcrumb breadcrumb">	                    
	                    <li><a href="index.php">Inicio</a></li>
	             
	                    <li class="active"><span>Promociones</span></li>
	                </ol>
	            </div>

            	<div class="col-md-9">
            		<div class="row">
                			<div class="col-lg-12">
                            		 <h3 class="font-light m-b-xs">
                					PROMOCIONES
            				</h3>
                        	</div>
                  	</div>
            	</div>
            </div>
      </div>
</div>

<div class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="hpanel small-header">
            <div class="panel-heading hbuilt">
               
                Listado de Promociones
            </div>
            <div class="panel-body">
                <div class="text-center m-b-md">
                   <button type="button" class="btn btn-primary pull-left" style="border-radius: 0px" data-toggle="tooltip" data-placement="top" title="Nueva Promoción" id="btnTipo"><i class="fa fa-plus"></i></button><!-- <button type="button" class="btn btn-danger pull-right" style="border-radius: 0px" data-toggle="tooltip" data-placement="top" title="Exportar a Excel" id="btnReporteEXCEL"><i class="fa fa-file-excel-o"></i></button><button type="button" class="btn btn-info pull-right" style="border-radius: 0px; margin-right: 7px; background-color: #62cb31!important; border-color:#62cb31!important" data-toggle="tooltip" data-placement="top" title="Exportar a PDF" id="btnReportePDF"><i class="fa fa-file-pdf-o"></i></button> --><br>
                </div>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                		<div class="table-responsive">
	                  	<table class="table table-bordered table-hover" id="tblListadoPromo">
	                  		<thead>
	                  			<tr class="info">
	                  				<th style="display:none">Codigo</th>
                            <th>Tipo</th>
	                  				<th>Promoción</th>
	                  				<th>Descripción</th>
	                  				<th>Condiciones</th>
	                  				<th>Fecha Inicio</th>
	                  				<th>Fecha Final</th>
	                  				<th>Opciones</th>
	                  			</tr>
	                  		</thead>
	                  		
	                  	</table>
                  	</div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="modalNuevoTipoPromo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="pe-7s-ticket text-primary"></i> Nueva Promoción</h4>
      </div>
      <div class="modal-body">
      	<div class="row">
           		<div class="col-md-12">
	           		<div class="col-md-6">
	           			<form action="" method="POST" role="form">         
				         		<label for="">Tipo de Promoción</label>
				         	<div class="input-group">
				         	 	<select name="" id="selTipoPro" class="form-control" required="required" style="border-radius: 0px">
				         	 			<option selected value="0">SELECCIONE TIPO</option>
				         	 		<?php 
				         	 			$sql = mysqli_query($conn, "SELECT * FROM btypromocion_tipo WHERE tpmestado = 1 ORDER BY tpmnombre");

				         	 			while ($row = mysqli_fetch_array($sql)) 
				         	 			{
				         	 				echo '<option value="'.$row['tpmcodigo'].'">'.utf8_encode($row['tpmnombre']).'</option>';
				         	 			}
				         	 		?>
				         	 	</select>
				         	 		<span class="input-group-btn"> 
				         	 			<button type="button" id="btnNuevoTipo" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Nuevo Tipo de Promoción"><i class="fa fa-plus"></i></button> 
				         	 		</span>
				         	</div>

				         	<div class="form-group">
				         		<label for="">Promoción</label>
				         		<input type="text" class="form-control" id="txtPromocion" placeholder="Nombre de la promo">
				         	</div>

				         	<div class="form-group">
				         		<label for="">Descripción</label>
				         		<textarea placeholder="Descripción de la promo" id="txtDescripcionPr" class="form-control" rows="4" style="resize: none;"></textarea>
				         	</div>
				      </form>				         
	           		</div>

	           		<div class="col-md-6">	           			       
				         	<div class="form-group">
				         		<label for="">Condiciones y Restricciones</label>
				         		<textarea placeholder="Describa las condiciones y restricciones" id="txtCondiciones" class="form-control" rows="3" style="resize: none;"></textarea>
				         	</div>
                  <div class="row">
                    <div class="col-md-6">
    				         	<div class="form-group">
    				         		<label for="">Fecha Inicio</label>
    				         		<input type="text" class="form-control" id="fechaInicio" placeholder="<?php echo date('Y-m-d'); ?>">
    				         	</div>
                    </div>
                    <div class="col-md-6">
    				         	<div class="form-group">
    				         		<label for="">Fecha Fin</label>
    				         		<input type="text" class="form-control" id="fechaFinal" placeholder="<?php echo date('Y-m-d'); ?>">
    				         	</div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                       <label for="">Indefinido</label><br><br>
                       <div class="material-switch" data-toggle="tooltip" data-placement="bottom" title="Active si la duración de la promo es indefinida">
                          <input id="fecInd" name="someSwitchOption001" type="checkbox"/>
                          <label for="fecInd" class="label-primary"></label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="">Requiere registro WEB</label><br><br>
                      <div class="material-switch" data-toggle="tooltip" data-placement="bottom" title="Active si es necesario un registro previo del cliente (Ej: convenios)">
                          <input id="reqreg" name="someSwitchOption002" type="checkbox"/>
                          <label for="reqreg" class="label-primary"></label>
                      </div>
                    </div>
                  </div>	         
	           		</div>
	           	</div>           		
           </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarPromo">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalNuevoTipo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="pe-7s-pin"></i> Nuevo Tipo de Promoción</h4>
      </div>
      <div class="modal-body">
          <div class="row">
          		<div class="col-md-12">
          			<form action="" method="POST" role="form">          			
          				<div class="form-group">
          					<label for="">Nuevo Tipo</label>
          					<input type="text" class="form-control" id="txtNuevoTipo" placeholder="INGRESE TIPO DE PROMOCIÓN">
          				</div>

          				<div class="form-group">
          					<label for="">Descripción</label>
          					<textarea placeholder="DIGITE LA DESCRIPCIÓN" id="txtDescripcion" class="form-control" rows="3" style="resize: none;"></textarea>
          				</div>
          			</form>
          		</div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarTipo">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalAsignar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i>Asignar Promoción</h4>
      </div>
      <div class="modal-body">
      	<div class="table-responsive">
      		<button type="button" class="btn btn-primary pull-right" style="border-radius: 0px" data-toggle="tooltip" data-placement="top" title="Asignar Promoción a Salón" id="btnAddSaln"><i class="fa fa-plus"></i></button>
      		<input type="hidden" id="codigoPromo">
	        	<table class="table table-bordered table-hover" id="tblAsignar" style="width: 100%">
	        		<thead>
	        			<tr class="info">
                  <th style="display: none"></th>
                  <th style="display: none"></th>
	        				<th>Salón</th>
                  <th>Día</th>
	        				<th>Fecha Inicio</th>
	        				<th>Fecha Fin</th>
	        				<th>Eliminar</th>
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
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Asignar a Salón</h4>
      </div>
      <div class="modal-body">
          <form action="" method="POST" role="form">
         
          	<div class="form-group">
          		<label for="">Seleccione Salón</label>
          		<select name="" id="selSalon" class="form-control" name="salones[]" multiple="multiple">
          			<?php 
          				$sql = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = 1");

          				while ($row = mysqli_fetch_array($sql)) 
          				{
          					echo '<option value="'.$row['slncodigo'].'">'.utf8_encode($row['slnnombre']).'</option>';
          				}
          			?>
          		</select>
          		
          	</div>

          	<div class="form-group">
                <label for="">Seleccione Días</label>
          		<select id="selDias" class="form-control" name="dias[]" multiple="multiple">
          			<option value="LUNES">LUNES</option>
          			<option value="MARTES">MARTES</option>
          			<option value="MIERCOLES">MIÉRCOLES</option>
          			<option value="JUEVES">JUEVES</option>
          			<option value="VIERNES">VIERNES</option>
          			<option value="SABADO">SÁBADO</option>
          			<option value="DOMINGO">DOMINGO</option>
          		</select>
          	</div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Estadísticas -->
<div class="modal fade" id="modal-stats">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="titstat"></h4>
      </div>
      <div class="modal-body">
        <div role="tabpanel">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="home active">
              <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">Redimidos</a>
            </li>
            <li role="presentation" class="uni nhome" style="display:none;">
              <a href="#tab5" aria-controls="tab" role="tab" data-toggle="tab">Registros</a>
            </li>
            <li role="presentation" class="uni nhome" style="display:none;">
              <a href="#tab4" aria-controls="tab" role="tab" data-toggle="tab">Universidades</a>
            </li>
            <li role="presentation" class="nhome">
              <a href="#tab2" aria-controls="tab" role="tab" data-toggle="tab">Salón</a>
            </li>
            <li role="presentation" class="nhome">
              <a href="#tab3" aria-controls="tab" role="tab" data-toggle="tab">Servicios</a>
            </li>
          </ul>
        
          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane home active" id="tab1">
              <table class="table table-hover table-bordered" id="tbstats" style="width: 100%;">
                <thead>
                  <tr>
                    <th>Salón</th>
                    <th>Servicio</th>
                    <th>Cliente</th>
                    <th>Fecha y hora</th>
                    <th>Redimido por:</th>
                  </tr>
                </thead>
              </table>
            </div>
            <div role="tabpanel" class="tab-pane nhome" id="tab4">
              <h4 class="text-center">DISTRIBUCIÓN DE REGISTRO POR UNIVERSIDADES</h4>
              <div id="canvasdiv3"> 
                  <canvas id="graphreg3"></canvas>
              </div>
              <button id="dlgraph3" disabled class="btn btn-info btn-xs pull-right btndl" data-toggle="tooltip" data-placement="left" title="Descargar grafico como imágen"><i class="fa fa-download"></i></button>
            </div>
            <div role="tabpanel" class="tab-pane nhome" id="tab2">
              <h4 class="text-center">REDENCIÓN DE PROMO POR SALÓN</h4>
              <div id="canvasdiv"> 
                  <canvas id="graphsln"></canvas>
              </div>
              <button id="dlgraph" disabled class="btn btn-info btn-xs pull-right btndl" data-toggle="tooltip" data-placement="left" title="Descargar grafico como imágen"><i class="fa fa-download"></i></button>
            </div>
            <div role="tabpanel" class="tab-pane nhome" id="tab3">
              <h4 class="text-center">REDENCIÓN DE PROMO POR SERVICIOS</h4>
              <div id="canvasdiv2"> 
                  <canvas id="graphser"></canvas>
              </div>
              <button id="dlgraph2" disabled class="btn btn-info btn-xs pull-right btndl" data-toggle="tooltip" data-placement="left" title="Descargar grafico como imágen"><i class="fa fa-download"></i></button>
            </div>
            <div role="tabpanel" class="tab-pane nhome" id="tab5">
              <h4 class="text-center">CLIENTES REGISTRADOS</h4>
              <table class="table table-hover table-bordered" id="tbclireg" style="width: 100%;">
                <thead>
                  <tr>
                    <th>Cliente</th>
                    <th>Universidad</th>
                    <th>Celular</th>
                    <th>Email</th>
                    <th>Fecha Registro</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<style>
	th{
		white-space: nowrap;
		text-align: center;
	}

	td{
		font-size: .7em;
	}

	.codPromo, .cod, .sln{
		display: none;
	}

    .material-switch > input[type="checkbox"] {
    display: none;   
  }

  .material-switch > label {
      cursor: pointer;
      height: 0px;
      position: relative; 
      width: 40px;  
  }

  .material-switch > label::before {
      background: rgb(0, 0, 0);
      box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
      border-radius: 8px;
      content: '';
      height: 16px;
      margin-top: -8px;
      position:absolute;
      opacity: 0.3;
      transition: all 0.4s ease-in-out;
      width: 40px;
  }
  .material-switch > label::after {
      background: rgb(255, 255, 255);
      border-radius: 16px;
      box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
      content: '';
      height: 24px;
      left: -4px;
      margin-top: -8px;
      position: absolute;
      top: -4px;
      transition: all 0.3s ease-in-out;
      width: 24px;
  }
  .material-switch > input[type="checkbox"]:checked + label::before {
      background: inherit;
      opacity: 0.5;
  }
  .material-switch > input[type="checkbox"]:checked + label::after {
      background: inherit;
      left: 20px;
  }
</style>

<script>
$(document).ready(function() {    
  $(document).prop('title', 'Promociones | Beauty SOFT - ERP'); 
  $(function () {
	$('[data-toggle="tooltip"]').tooltip();
	});
	listadoPromo();
	$('#selDias').select2({placeholder: "SELECCIONE DÍAS",allowClear: true});
	$('#selSalon').select2({placeholder: "SELECCIONE SALON(ES)",allowClear: true});
});

$(document).on('click', '#btnTipo', function() {
	$('#modalNuevoTipoPromo').modal("show");
});

$(document).on('click', '#btnNuevoTipo', function() {
	$('#modalNuevoTipo').modal("show");

	$('#modalNuevoTipo').on('shown.bs.modal', function () 
	{
  		$('#txtNuevoTipo').focus();
	});
});

$(document).on('click', '#btnGuardarTipo', function() {
	var tipo        = $('#txtNuevoTipo').val();
	var descripcion = $('#txtDescripcion').val();

	if (tipo == "") 
	{
		swal("Ingrese el tipo de promoción", "", "warning");
	}
	else
	{
		if (descripcion == "") 
		{
			swal("Ingrese la descripción", "", "warning");
		}
		else
		{
			$.ajax({
				url: 'php/promocion/process.php',
				method: 'POST',
				data: {opcion: "nuevoTipo", tipo: tipo, descripcion:descripcion},
				success: function (data)
				{
					if (data == 1) 
					{
						swal("Ingreso correcto", "", "success");
						loadLast ();
						$('#txtNuevoTipo').val('');
						$('#txtDescripcion').val('');
						$('#modalNuevoTipo').modal("hide");
					}
				}
			});
		}
	}
});

function loadLast () 
{
	$.ajax({
		url: 'php/promocion/process.php',
		method: 'POST',
		data: {opcion: "ultimoTipo"},
		success: function (data) 
		{
			$('#selTipoPro').html('');
			$('#selTipoPro').html(data);
		}
	});
}

/**
 *
 * FECHAS
 *
 */

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

$('#fechaInicio').datepicker({ 
    startDate: '-0d',
    format: "yyyy-mm-dd",
    setDate: "today",
    language: 'es',
});

$('#fechaFinal').datepicker({ 
    startDate: '-0d',
    format: "yyyy-mm-dd",
    setDate: "today",
    language: 'es',
});

$('#fechaInicio').on('changeDate', function(ev){
    $(this).datepicker('hide');
    $('#fechaFinal').focus();
});

$('#fechaFinal').on('changeDate', function(ev){
    $(this).datepicker('hide');
});

/**
 *
 * GUARDAR PROMOCIÓN
 *
 */

$("#fecInd").on( 'change', function() {
    if( $(this).is(':checked') ) 
    {
        $('#fechaFinal').attr('disabled', true);
        $('#fechaFinal').val('');
    } 
    else 
    {
        $('#fechaFinal').attr('disabled', false);
        $('#fechaFinal').val('');
    }
});

$(document).on('click', '#btnGuardarPromo', function() 
{
    var tipoPromo 	= $('#selTipoPro').val();
    var promocion 	= $('#txtPromocion').val();
    var descripcion 	= $('#txtDescripcionPr').val();
    var condiciones   = $('#txtCondiciones').val();
    var fechainicio   = $('#fechaInicio').val();
    var reqreg        = $("#reqreg").prop('checked');
      
    if( $('#fecInd').is(':checked')) 
    {
        var fechafin = null;
    } 
    else
    {
        fechafin = $('#fechaFinal').val();
    }

    if (tipoPromo == 0) 
    {
    	swal("Seleccione el tipo de promoción", "", "warning");
    }
    else
    {
    	if (promocion == "") 
    	{
    		swal("Ingrese la promoción", "", "warning");
    	}
    	else
    	{
    		if (descripcion == "") 
    		{
    			swal("Ingrese la descripción", "", "warning");
    		}
    		else
    		{
    			if (condiciones == "") 
    			{
    				swal("Ingrese las condiciones", "", "warning");
    			}
    			else
    			{
    				if (fechainicio == "") 
    				{
    					swal("Ingrese la fecha de inicio de promoción", "", "warning");
    				}
    				else
    				{
    					
						$.ajax({
							url: 'php/promocion/process.php',
						method: 'POST',
						data: {opcion: "nuevaPromocion", tipoPromo:tipoPromo, promocion:promocion, descripcion:descripcion, condiciones:condiciones, fechainicio:fechainicio, fechafin:fechafin, reqreg:reqreg},
						success: function (data)
						{
							if (data == 1) 
							{
								swal("Se ha ingresado la promoción " + promocion + " correctamente", "", "success");
								$('#txtPromocion').val('');
								$('#txtDescripcionPr').val('');
								$('#txtCondiciones').val('');
								$('#fechaInicio').val('');
								$('#fechaFinal').val('');
								$('#selTipoPro option:contains("SELECCIONE TIPO")').prop('selected',true);
								$('#modalNuevoTipoPromo').modal("hide");
                $("#fecInd").attr('checked', false);
                $("#reqreg").attr('checked', false);
								listadoPromo();
							}
						}
						});
    					
    				}
    			}
    		}
    	}
    }
});

/**
 *
 * LISTADO
 *
 */

var  listadoPromo  = function() { 
   var listado = $('#tblListadoPromo').DataTable({
      "ajax": {
      "method": "POST",
      "url": "php/promocion/process.php",
      "data": {opcion: "listado"},
      },
      dom: 'Bfrtip',
        buttons: [
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o text-danger"></i>',
                titleAttr: 'PDF'
            }
        ],
      "columns":[
        {"data": "pmocodigo"},
        {"data": "tpmnombre"},
        {"data": "pmonombre"},
        {"data": "pmodescripcion"},
        {"data": "pmocondyrestric"},
        {"data": "lgbfechainicio"},
        {"data": "lgbfechafin"},
        {"render": function (data, type, JsonResultRow, meta) { 
		          return "<center><button type='button' style='margin-left:7px; border-radius: 0px' class='btn btn-warning btn-sm' title='Asignar Promociones a Salones' data-toggle='modal' data-target='#modalAsignar' id='btnAsignar'><i class='fa fa-plus'></i></button><button class='btn btn-info btn-sm stats' id='stats' title='Estadísticas' data-toggle='modal' data-target='#modal-stats' data-promo='"+JsonResultRow.pmocodigo+"'><i class='fa fa-bar-chart'></i></button></center>"; 
		         } 
		    },  
      ],"language":{
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrada de _MAX_ registros)",
        "loadingRecords": "Cargando...",
        "processing":     "Procesando...",
        "search": "_INPUT_",
        "searchPlaceholder":"Buscar...",
        "zeroRecords":    "No se encontraron registros coincidentes",
        "paginate": {
          "next":       "Siguiente",
          "previous":   "Anterior"
        } 
        },  
         "columnDefs":[
              {className:"codPromo","targets":[0]},
         ],
             
         "order": [[0, "desc"]],
         "bDestroy": true,
         "pageLength": 10,
  });
};

/**
 *
 * Asignar Promo
 *
 */
$(document).ready(function() {
	
	$('#tblListadoPromo tbody').on('click', '#btnAsignar', function() {
	      var $row = $(this).closest("tr");    // Find the row
	      var $id = $row.find(".codPromo").text(); // Find the text
	      var cod = $id;
	      $('#codigoPromo').val(cod);
	      $.ajax({
	      	url: 'php/promocion/process.php',
	      	method: 'POST',
	      	data: {opcion: "asignar", cod:cod},
	      	success: function (data) 
	      	{
	      		asignarPromo(cod);
	      	}
	      });
	});

  $('#tblListadoPromo tbody').on('click', '#stats', function() {
    var $row = $(this).closest("tr");    // Find the row
    var nom=$row.find("td").eq(1).text()+' '+$row.find("td").eq(2).text();
    var codpro=$(this).data('promo');
    if(codpro==3){
    	graphuni();
      loadclireg();
    	$(".uni").show();
    }
    $(".btndl").attr('data-nom', nom);
    $("#titstat").html("<i class='fa fa-bar-chart'></i> Estadísticas de "+nom);
    loadstats(codpro);  
    graphsln(codpro);
    graphser(codpro);

  })
});
var loadstats=function(codpro){
  var est = $('#tbstats').DataTable({
      "ajax": {
      "method": "POST",
      "url": "php/promocion/estadisticas.php",
      "data": {opc: "loadstats", codpro:codpro},
      },
      dom: 'Bfrtip',
        buttons: [
            {
                extend:    'excel',
                text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
                titleAttr: 'Exportar a Excel'
            },
            {
                extend:    'pdf',
                text:      '<i class="fa fa-file-pdf-o text-danger"></i>',
                titleAttr: 'Exportar a PDF'
            },
        ],
      "columns":[
        {"data": "slnnombre"},
        {"data": "sernombre"},
        {"data": "trcrazonsocial"},
        {"data": "repfecha"},
        {"data": "trcnombres"},       

      ],"language":{
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "info": "Mostrando página _PAGE_ de _PAGES_ <br><b class='text-primary'> Total redenciones:  _MAX_ </b>",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrada de _MAX_ registros)",
        "loadingRecords": "<i class='fa fa-spinner fa-spin'></i> Cargando, por favor espere...",
        "processing":     "Procesando...",
        "search": "_INPUT_",
        "searchPlaceholder":"Buscar...",
        "zeroRecords":    "No se encontraron registros coincidentes",
        "paginate": {
          "next":       "Siguiente",
          "previous":   "Anterior"
        } 
        },  

         
             
         "order": [[0, "desc"]],
         "bDestroy": true,
         "pageLength": 5,
  })

}
var loadclireg=function(codpro){
  var est = $('#tbclireg').DataTable({
      "ajax": {
      "method": "POST",
      "url": "php/promocion/estadisticas.php",
      "data": {opc: "loadclireg", codpro:codpro},
      },
      dom: 'Bfrtip',
        buttons: [
            {
                extend:    'excel',
                text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
                titleAttr: 'Exportar a Excel'
            },
            {
                extend:    'pdf',
                text:      '<i class="fa fa-file-pdf-o text-danger"></i>',
                titleAttr: 'Exportar a PDF'
            },
        ],
      "columns":[
        {"data": "trcrazonsocial"},
        {"data": "punnombre"},
        {"data": "trctelefonomovil"},
        {"data": "cliemail"},
        {"data": "profechareg"},      

      ],"language":{
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "info": "Mostrando página _PAGE_ de _PAGES_  <br><b class='text-primary'> Total clientes registrados:  _MAX_ </b>",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrada de _MAX_ registros)",
        "loadingRecords": "<i class='fa fa-spinner fa-spin'></i> Cargando, por favor espere...",
        "processing":     "Procesando...",
        "search": "_INPUT_",
        "searchPlaceholder":"Buscar...",
        "zeroRecords":    "No se encontraron registros coincidentes",
        "paginate": {
          "next":       "Siguiente",
          "previous":   "Anterior"
        } 
        },  

         "order": [[0, "asc"]],
         "bDestroy": true,
         "pageLength": 5,
  })

}

var  asignarPromo  = function(cod) { 
   var listado = $('#tblAsignar').DataTable({
      "ajax": {
      "method": "POST",
      "url": "php/promocion/process.php",
      "data": {opcion: "asignar", cod:cod},
      },
      "columns":[
        {"data": "pmocodigo"},
        {"data": "slncodigo"},
        {"data": "slnnombre"},
        {"data": "pmddia"},
        {"data": "lgbfechainicio"},
        {"data": "lgbfechafin"},
        {"defaultContent": "<center><button type='button' style='margin-left:0px; border-radius: 0px' class='btn btn-danger btn-xs' title='Eliminar Promoción' id='btnEliminar'><i class='fa fa-minus'></i></button></center>"},        

      ],"language":{
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrada de _MAX_ registros)",
        "loadingRecords": "Cargando...",
        "processing":     "Procesando...",
        "search": "Buscar:",
        "zeroRecords":    "No se encontraron registros coincidentes",
        "paginate": {
          "next":       "Siguiente",
          "previous":   "Anterior"
        } 
        },  
         "columnDefs":[
              {className:"cod","targets":[0]},
              {className:"sln","targets":[1]},
              {className:"dia","targets":[3]},
         ],
             
         "order": [[2, "asc"]],
         "bDestroy": true,
         "pageLength": 10,
  });
};

/**
 *
 * ADD
 *
 */

$(document).on('click', '#btnAddSaln', function() {
	$('#modalAdd').modal("show");

    $("#selDias").val('').trigger('change');
    $("#selSalon").val('').trigger('change');
});

$(document).on('click', '#btnGuardar', function() {
	var dias  = $('#selDias').val();
	var salon = $('#selSalon').val();
	var cod   = $('#codigoPromo').val();

	var datos = "opcion=nuevoPromoSln&dias="+dias+"&salon="+salon+"&cod="+cod;

	$.ajax({
		url: 'php/promocion/process.php',
	      method: 'POST',
	      data: datos,
	      success: function (data) 
	      {
	      	asignarPromo(cod);
	      }
	});
});


/**
 *
 * ELIMINAR PROMO A SALON
 *
 */

 $('#tblAsignar tbody').on('click', '#btnEliminar', function() {
        var $row = $(this).closest("tr");    // Find the row
        var $id  = $row.find(".cod").text(); // Find the text
        var $sln = $row.find(".sln").text();
        var $dia = $row.find(".dia").text();
        var cod = $id;
        var sln = $sln;
        var dia = $dia;

         swal({
                title: "¿Desea eliminar esta promoción?",
                text: "",
                type: "warning",
                showCancelButton:  true,
                cancelButtonText:"No",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sí"
            },
            function () {
                $.ajax({
                    type: "POST",
                    url: "php/promocion/process.php",
                    data: {opcion: "eliminar", cod: cod, sln:sln, dia:dia},
                    success: function (data) 
                    {
                        if (data == 1) 
                        {
                             asignarPromo(cod);
                        }
                    }
                });
            });
 });

</script>
<script type="text/javascript">

  //funciones de gráficos 
	function getRandomColor() {
	  var letters = '0123456789ABCDEF'.split('');
	  var color = '#';
	  for (var i = 0; i < 6; i++ ) {
	      color += letters[Math.floor(Math.random() * 16)];
	  }
	  return color;
	}
  function graphsln(codpromo){
		$("#canvasdiv").empty();
		$("#canvasdiv").html('<br><br><br><br><center><i class="fa fa-spin fa-spinner"></i> Cargando...</center>');
		var sln=[];
		var cant=[];
		var color=[];
		$.ajax({
		  url:'php/promocion/estadisticas.php',
		  type:'POST',
		  data:{opc:'graphsln', codpromo:codpromo},
		  success:function(res){
		    var json = JSON.parse(res);
		    if(json!=null){
		    	$("#dlgraph").removeAttr('disabled');
			    for(var i in json){
			        sln.push(json[i].salon);
			        cant.push(json[i].cant);
			        color.push(getRandomColor());
			    }
			    $("#canvasdiv").html('<canvas id="graphsln"></canvas>');
			    new Chart(document.getElementById("graphsln"), 
			    {
			      type: 'pie',
			      data: 
			      {
			          labels: sln,
			          datasets: [{
			              backgroundColor:color,
			              data: cant
			          }]
			      },
			      options: {
			          title: {
			              display: true,
			          },
			          legend:{
			              display: true,
			              position:'left',
			          }
			      }
			    });
		    }else{
		    	$("#canvasdiv").html('<br><br><br><br><center><i class="fa fa-times"></i> No hay datos disponibles</center>');
		    }
		  }
		})
  }
	function graphser(codpromo){
	    $("#canvasdiv2").empty();
	    $("#canvasdiv2").html('<br><br><br><br><center><i class="fa fa-spin fa-spinner"></i> Cargando...</center>');
	    var ser=[];
	    var cant=[];
	    var color=[];
	    $.ajax({
	      url:'php/promocion/estadisticas.php',
	      type:'POST',
	      data:{opc:'graphser', codpromo:codpromo},
	      success:function(res){
	        var json = JSON.parse(res);
	        if(json!=null){
	        	$("#dlgraph2").removeAttr('disabled');
		        for(var i in json){
		            ser.push(json[i].serv);
		            cant.push(json[i].cant);
		            color.push(getRandomColor());
		        }
		        $("#canvasdiv2").html('<canvas id="graphser"></canvas>');
		        new Chart(document.getElementById("graphser"), 
		        {
		          type: 'pie',
		          data: 
		          {
		              labels: ser,
		              datasets: [{
		                  backgroundColor:color,
		                  data: cant
		              }]
		          },
		          options: {
		              title: {
		                  display: true,
		              },
		              legend:{
		                  display: true,
		                  position:'left',
		              }
		          }
		        });
		    }else{
		    	$("#canvasdiv2").html('<br><br><br><br><center><i class="fa fa-times"></i> No hay datos disponibles</center>');
		    }   
	      }
	    })
	}
	function graphuni(){
	    $("#canvasdiv3").empty();
	    $("#canvasdiv3").html('<br><br><br><br><center><i class="fa fa-spin fa-spinner"></i> Cargando...</center>');
	    var uni=[];
	    var cant=[];
	    var color=[];
	    $.ajax({
	      url:'php/promocion/estadisticas.php',
	      type:'POST',
	      data:{opc:'graphuni'},
	      success:function(res){
	        var json = JSON.parse(res);
	        if(json!=null){
	        	$("#dlgraph3").removeAttr('disabled');
		        for(var i in json){
		            uni.push(json[i].uni);
		            cant.push(json[i].cant);
		            color.push(getRandomColor());
		        }
		        $("#canvasdiv3").html('<canvas id="graphser3"></canvas>');
		        new Chart(document.getElementById("graphser3"), 
		        {
		          type: 'pie',
		          data: 
		          {
		              labels: uni,
		              datasets: [{
		                  backgroundColor:color,
		                  data: cant
		              }]
		          },
		          options: {
		              title: {
		                  display: true,
		              },
		              legend:{
		                  display: true,
		                  position:'left',
		              }
		          }
		        });
		    }else{
		    	$("#canvasdiv3").html('<br><br><br><br><center><i class="fa fa-times"></i> No hay datos disponibles</center>');
		    }  
	      }
	    })
	}
  

  //botones descargar gráficos
	$("#dlgraph").click(function(){
		domtoimage.toBlob(document.getElementById('canvasdiv'))
		.then(function(blob) {
		  window.saveAs(blob, 'PromoPorSalon.jpg');
		});
	})
	$("#dlgraph2").click(function(){
		domtoimage.toBlob(document.getElementById('canvasdiv2'))
		.then(function(blob) {
		  window.saveAs(blob, 'PromoPorServicio.jpg');
		});
	});
	$("#dlgraph3").click(function(){
		domtoimage.toBlob(document.getElementById('canvasdiv3'))
		.then(function(blob) {
		  window.saveAs(blob, 'RegistroClientesUni.jpg');
		});
	});
	$("#modal-stats").on("hidden.bs.modal", function () {
	    $(".btndl").attr('disabled', 'disabled');
	    $(".uni").hide();
      $(".nhome").removeClass('active');
      $(".home").addClass('active');
	});

</script>

