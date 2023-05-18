<?php
    include("./head.php");
    include '../cnx_data.php';

    VerificarPrivilegio("PERMISOS", $_SESSION['tipo_u'], $conn);
    RevisarLogin();

?>



<div class="normalheader ">
    <div class="hpanel">
        <div class="panel-body">
            <a class="small-header-action" href="">
                <div class="clip-header">
                    <i class="fa fa-arrow-up"></i>
                </div>
            </a>

            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="inicio.php">Inicio</a></li>
                    <li class="active">
                        <span>Permisos</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs">
                Autorización de Permisos
            </h2>
        </div>
    </div>
</div>

<div class="content">

<div class="row">
    <div class="col-md-12">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1">Autorizar </a></li>                
                <button type="button" class="btn btn-link text-info" id="btn_reporteTotalPDF" title="Exportar permisos a PDF"><i class="fa fa-file-pdf-o"></i></button>
                <button type="button" class="btn btn-link text-info" id="btn_reporteTotalExcel" title="Exportar todos los permisos autorizados a Excel"><i class="fa fa-file-excel-o"></i></button>
               
                <!-- <li class=""><a data-toggle="tab" href="#tab-2">Búsqueda de Permisos</a></li> -->
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <div class="col-md-12">
					        <div class="hpanel hblue">
					            <div class="panel-heading hbuilt">
					                <div class="panel-tools">
					                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
					                    <a class="closebox"><i class="fa fa-times"></i></a>
					                </div>
					                Permisos
					            </div>
					            <div class="panel-body">	
                                        <div class="col-md-12">
                                        <label for="">Buscar por fechas</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" id="fecha_de_bus" placeholder="0000-00-00"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                   </div>
                                            </div>
                                             <div class="col-md-3">
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" id="fecha_hasta_bus" placeholder="0000-00-00"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                   </div>
                                            </div>
                                            <div class="col-md-3">
                                                    <button type="button" id="btn_busqueda" class="btn btn-info btn-block"><i class="fa fa-search"></i> Buscar por fechas</button>
                                            </div>
                                             <div class="col-md-3">
                                                    <select name="" id="sel_estados" class="form-control" required="required">
                                                        <option value="0" selected>Buscar por Estado</option>
                                                        <option value="REGISTRADO">REGISTRADO</option>
                                                        <option value="AUTORIZADO">AUTORIZADO</option>
                                                        <option value="NO AUTORIZADO">NO AUTORIZADO</option>
                                                    </select>
                                            </div>
                                        </div>
                                    </div>		
                                        <div class="col-md-12"> 
                                            <br>
                                            <br>
                                            <div class="table-responsive">
                                            <table class="table table-hover table-bordered" id="tbl_permisos_lista">
                                                <thead>
                                                    <tr>
                                                        <th>CONSECUTIVO</th>
                                                        <th>COLABORADOR</th>
                                                        <th>SALÓN</th>
                                                        <th>DESDE</th>
                                                        <th>HASTA</th>
                                                        <th>REGISTRADO POR</th>
                                                        <th>FECHA REGISTRO</th>
                                                        <th>AUTORIZADO POR</th>
                                                        <th>ESTADO</th>
                                                        <th>ACCIONES</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                	
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
						                    
										
	                                    

					                	
					            </div>
					            <div class="panel-footer">
					                Mensaje aclaratorio
					            </div>
					        </div>
    					</div>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane">
                    <div class="panel-body">
                        <strong>Listado de Permisos</strong>

                       			<div class="panel-body">
					               
	                                    
               					                	
					                </form>
					            </div>
                    </div>
                
                </div>
            </div>


        </div>
    </div>
 </div>

</div>

<!-- Modal -->
<div class="modal fade" id="modal_ver_permisos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Autorizar Permisos</h4>
        <button type="button" class="btn btn-link text-info pull-right" id="btn_reporteEx" title="Exportar a EXCEL"><i class="fa fa-file-excel-o"></i></button>
        <button type="button" class="btn btn-link text-info pull-right" id="btn_reporte" title="Exportar a PDF"><i class="fa fa-file-pdf-o"></i></button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                     <div class="col-md-6">
                         <form action="" method="POST" role="form"> 
                         <input type="hidden" id="cod_col">        
                         <div class="form-group">
                             <label for="">Codigo Permiso</label>
                             <input type="number" class="form-control" disabled id="txt_codigo">
                         </div> 

                         <div class="form-group">
                             <label for="">Colaborador</label>
                             <input type="text" class="form-control" disabled id="txt_colaborador">
                         </div> 

                          <div class="form-group">
                             <label for="">Permiso Desde</label>
                             <input type="text" class="form-control" disabled id="txt_perdesde">
                         </div> 

                         <div class="form-group">
                             <label for="">Permiso Hasta</label>
                             <input type="text" class="form-control" disabled id="txt_perhasta">
                         </div> 

                         <div class="form-group">
                             <label for="">Comentarios Registro</label>
                             <textarea name="" id="txt_comentario" disabled class="form-control" rows="3" required="required"></textarea>
                         </div> 
                         <hr>
                         <div class="form-group">
                             <div class="radio" id="radio_aut">
                                
                             </div> 

                                            
                              
                         </div>               
         
                    </form>
                     </div>
                     <div class="col-md-6">
                        <form action="" method="POST" role="form">         
                             <div class="form-group">
                                 <label for="">Fecha de Permiso</label>
                                 <input type="text" class="form-control" disabled id="txt_fecha">
                             </div>

                             <div class="form-group">
                                 <label for="">Usuario Registro</label>
                                 <input type="text" class="form-control" disabled id="txt_usureg">
                             </div>  

                             <div class="form-group hidden">
                                 <label for="">Usuario Autoriza</label>
                                 <input type="hidden" class="form-control" disabled id="txt_usuaut">
                             </div> 

                              <div class="form-group">
                                 <label for="">Comentarios al Autorizar</label>
                                 <textarea name="" id="comen_autor" class="form-control" rows="7" required="required"></textarea>
                             </div>        
                        </form>
                     </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn_autorizar" class="btn btn-primary">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<?php include("librerias_js.php"); ?>
<script src="js/permisos.js"></script>
<script>
     $('.input-group2.date2').datepicker({ format: "yyyy-mm-dd"});

     $('.input-group.date').datepicker({ 
        format: "yyyy-mm-dd",
        setDate: "0"
    });

    $(document).on('click', '#btn_busqueda', function() 
    {
            var desde = $('#fecha_de_bus').val();
            var hasta = $('#fecha_hasta_bus').val();

            if (desde == "" || hasta == "") 
            {
                 swal("Debe seleccionar las fechas", "", "warning");   
            }

            if (desde > hasta) 
            {
                swal("La fecha de inicio es mayor a la fecha final", "", "warning");
            }
            else
            {
                $.ajax({
                    url: 'busquedas_permisos.php',
                    method: 'POST',
                    data: {desde:desde, hasta:hasta},
                    success: function (data) 
                    {
                        var array = eval(data);
                        $('#tbl_permisos_lista tbody').empty();
                        if (array != '1') 
                        {
                            for(var i in array)
                            {
                                $('#tbl_permisos_lista tbody').append('<tr class="active"><td style="text-align: center">'+array[i].id+'</td><td>'+array[i].colaborador+'</td><td style="text-align: right">'+array[i].salon+'</td><td>'+array[i].desde+'</td><td>'+array[i].hasta+'</td><td>'+array[i].usu_reg+'</td><td>'+array[i].fecha+'</td><td>'+array[i].usu_aut+'</td><td>'+array[i].estado+'</td><td><button type="button" data-idpermiso="'+array[i].id+'" id="btn_verpermisos" class="btn btn-link text-info" title="Click para los detalles"><i class="fa fa-search"></i></button></td></tr>');
                            }
                            
                        }
                        else
                        {
                            $('#tbl_permisos_lista tbody').append('<tr><td colspan="9"><center><b>No hay registros disponibles</b></center></td></tr>');
                        }
                    }
                });
            }


    });

$(document).ready(function() {
    
     $('#tbl_permisos_lista tbody').on('click', '#btn_verpermisos', function() 
     {
           $('#modal_ver_permisos').modal("show");
           var idpermiso = $(this).data("idpermiso");
            $('#txt_codigo').val('');
            $('#txt_colaborador').val('');
            $('#txt_fecha').val('');
            $('#txt_perdesde').val('');
            $('#txt_perhasta').val('');
            $('#txt_usureg').val('');
            $('#txt_usuaut').val('');
            $('#txt_comentario').val(''); 
            $('#txt_fecha_aut').val('');

            $.ajax({
                url: 'listar_detalle_permiso.php',
                method: 'POST',
                data: {cod:idpermiso},
                success: function (data) 
                {
                    var array = eval(data);
                    $('#radio_aut').empty();
                    $('#btn_autorizar').removeClass('disabled');
                    for(var i in array)
                    {
                        $('#txt_codigo').val(array[i].id);
                        $('#cod_col').val(array[i].codcolab);
                        $('#txt_colaborador').val(array[i].colaborador);
                        $('#txt_fecha').val(array[i].fecha);
                        $('#txt_perdesde').val(array[i].desde);
                        $('#txt_perhasta').val(array[i].hasta);
                        $('#txt_usureg').val(array[i].usu_reg);
                        $('#txt_usuaut').val('array[i].usu_aut');
                        $('#txt_comentario').val(array[i].observacion); 
                        $('#txt_fecha_aut').val(array[i].fecha_aut);

                         var permiso = "";

                        switch (array[i].estado) 
                        {
                            case 'REGISTRADO':
                                permiso = '<label><input type="radio" name="autorizar" id="aut" value="Autorizado">Autorizar</label><div class="radio" id="aut"><label><input type="radio" name="autorizar" id="aut" value="Noautorizado">No autorizar</label></div>';
                               
                                break;

                            case 'AUTORIZADO':

                                 $('#btn_autorizar').addClass('disabled');
                                
                                break;

                            case 'NO AUTORIZADO':

                                 $('#btn_autorizar').addClass('disabled');

                                break;
                            default:
                                // statements_def
                                break;
                        }


                        $('#radio_aut').append(permiso);
                    }
                }
            });

    });
});

$(document).on('click', '#btn_reporte', function() {
     window.open("reportePermisos.php?idpermiso="+ $("#txt_codigo").val()+"&idcolaborador="+$('#cod_col').val()+"&colaborador="+$('#txt_colaborador').val());
});

$(document).on('click', '#btn_reporteEx', function() {    

     window.open("http://192.168.1.202/beauty/reportePermisoExc.php?idpermiso="+ $("#txt_codigo").val()+"&idcolaborador="+$('#cod_col').val()+"&colaborador="+$('#txt_colaborador').val());
});


$(document).on('click', '#btn_reporteTotalPDF', function() 
{     
    window.open("reportePermisosPDF.php?estado="+$("#sel_estados").val()+"&fechaini="+$('#fecha_de_bus').val()+"&fechafin="+$('#fecha_hasta_bus').val()+"&colaborador="+$('input[type="search"]').val());

});

$(document).on('blur', '#fecha_hasta_bus', function() {
    $('#sel_estados option:contains("Buscar por Estado")').prop('selected',true);
});

$(document).on('change', '#sel_estados', function() {
    $('#fecha_de_bus').val('');
    $('#fecha_hasta_bus').val('');

});


$(document).on('keydown', $("input[type='search']").val(), function() {
    $('#sel_estados option:contains("Buscar por Estado")').prop('selected',true);
});




$(document).on('click', '#btn_reporteTotalExcel', function() 
{
     window.open("reportePermisosExcel.php?estado="+$("#sel_estados").val()+"&fechaini="+$('#fecha_de_bus').val()+"&fechafin="+$('#fecha_hasta_bus').val()+"&colaborador="+$('input[type="search"]').val());
});





$(document).on('change', '#sel_estados', function() 
{
    var estado = $('#sel_estados').val();

    if (estado == 0) 
    {
        swal("Debe seleccionar un estado.", "", "warning");
    }
    else
    {
        $.ajax({
            url: 'buscar_estado_permisos.php',
            method: 'POST',
            data: {estado:estado},
            success: function (data) 
            {
                 var array = eval(data);
                $('#tbl_permisos_lista tbody').empty();
                if (array != '1') 
                {
                    for(var i in array)
                    {
                        $('#tbl_permisos_lista tbody').append('<tr class="active"><td class="idpermiso" style="text-align: right">'+array[i].id+'</td><td>'+array[i].colaborador+'</td><td>'+array[i].salon+'</td><td>'+array[i].desde+'</td><td>'+array[i].hasta+'</td><td>'+array[i].usu_reg+'</td><td>'+array[i].fecha+'</td><td>'+array[i].usu_aut+'</td><td>'+array[i].estado+'</td><td><button type="button" data-idpermiso="'+array[i].id+'" id="btn_verpermisos" class="btn btn-link text-info" title="Click para los detalles"><i class="fa fa-search"></i></button></td></tr>');
                    }
                    
                }
                else
                {
                    swal("No hay registros disponibles con el estado "+ estado, "", "warning");
                    $('#tbl_permisos_lista tbody').append('<tr><td colspan="8"><center><b>No hay registros disponibles</b></center></td></tr>');
                }
            }
        });
    }
});



$(document).ready(function() 
{
    conteoPermisos ();
});

</script>

<style>
    th,td{
        white-space: nowrap;
        font-size: .8em;
    }
</style>