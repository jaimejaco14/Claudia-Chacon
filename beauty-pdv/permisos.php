<?php
    include 'head.php';
    include 'php/conexion.php';
    VerificarPrivilegio("PERMISOS (PDV)",$_SESSION['PDVtipo_u'],$conn);
    
    
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
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
                        <span>Ausencias</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs">
                Gestión de Ausencias
            </h2>
        </div>
    </div>
</div>

<div class="content">

<div class="row">
    <div class="col-md-12">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1">Registro </a></li>
                <li class=""><a data-toggle="tab" href="#tab-2">Búsqueda</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="hpanel hblue">
                                <div class="panel-heading hbuilt">
                                    Ausencias
                                </div>
                                <div class="panel-body">
                                    <form action="" method="POST" role="form">                                  
                                        <div class="form-group">
                                            <label for="">Buscar Colaborador</label> 
                                            <select class="selectpicker form-control" id="col" data-live-search="true" title='Selecciona colaborador...' data-size="10" data-width="auto">
                                            <?php                                              
$queryCargo = mysqli_query($conn,"SELECT crgnombre, crgcodigo from btycargo where crgestado='1' order by crgnombre");

while ($rsCargo = mysqli_fetch_array($queryCargo)) 
{

    $query = mysqli_query($conn,"SELECT cr.crgnombre, c.clbcodigo, t.trcapellidos, t.trcnombres, concat(t.trcapellidos,' ',t.trcnombres) as trcrazonsocial from btycargo as cr, btycolaborador as c, btytercero as t where (select bty_fnc_estado_colaborador(c.clbcodigo)) ='VINCULADO' and cr.crgcodigo='".$rsCargo['crgcodigo']."' and c.crgcodigo=cr.crgcodigo and t.tdicodigo=c.tdicodigo and t.trcdocumento=c.trcdocumento and c.clbestado='1' order by cr.crgnombre, t.trcapellidos, t.trcnombres");

                                                echo '<optgroup label='.$rsCargo['crgnombre'].'>';

                                                while ($row = mysqli_fetch_array($query)) 
                                                {
                                                    
                                                    echo '<option value="'.$row['clbcodigo'].'">'.utf8_encode($row['trcrazonsocial']).'</option>';
                                                }

                                                echo '</optgroup>';
                                                }

                                            ?>

                                            
                                            </select>
                                        </div>
                                            <div class="col-sm-12">
                                                <label for="">De</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control" id="fecha_de" placeholder="0000-00-00"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="input-group clockpicker" data-autoclose="true">
                                                            <input type="text" class="form-control" value="00:00" id="hora_de">
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-clock-o"></span>
                                                                </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <label for="">Hasta</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control" id="fecha_hasta" placeholder="0000-00-00"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="input-group clockpicker2" data-autoclose="true">
                                                            <input type="text" class="form-control" value="00:00" id="hora_hasta">
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-clock-o"></span>
                                                                </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            
                                        
                                        

                                        <div class="form-group">
                                            <label for="">Observaciones</label>
                                            <textarea name="" id="observaciones" class="form-control" rows="3" placeholder="Digite observaciones (Opcional)"></textarea>
                                        </div>                  
                                        <button type="button" class="btn btn-primary pull-right" data-loading-text="Registrando..." id="btn-registar">Registrar</button>
                                    </form>
                                </div>
                                <!-- <div class="panel-footer">
                                    Mensaje aclaratorio
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane">
                    <div class="panel-body">
                        <strong>Listado de Ausencias</strong>

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
                                                    <button type="button" id="btn_busqueda" class="btn btn-info btn-block"><i class="fa fa-search"></i> Buscar</button>
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
                                            <center><table class="table table-hover table-bordered" id="tbl_permisos">
                                                <thead>
                                                    <tr>
                                                        <th>CONSECUTIVO</th>
                                                        <th>COLABORADOR</th>
                                                        <th>DESDE</th>
                                                        <th>HASTA</th>
                                                        <th>REGISTRADO POR</th>
                                                        <th>AUTORIZADO POR</th>
                                                        <th>ESTADO</th>
                                                        <th>ACCIONES</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table></center>
                                            </div>
                                        </div>                                                      
                                    </form>
                                </div>
                    </div>
                
                </div>
            </div>


        </div>
    </div>
 </div>

</div>

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




<!-- Modal -->
<div class="modal fade" id="modalEditPerm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Modificar ausencia</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <form action="" method="POST" role="form">
                            <input type="hidden" id="codPermiso">
                            <input type="hidden" id="clbcodigo">
                                <label for="">Colaborador</label>
                                <div class="input-group">
                                    <input type="text" id="txtCol" class="form-control" readonly> 
                                        <span class="input-group-btn"> 
                                            <button type="button" class="btn btn-primary disabled" disabled data-toggle="tooltip" data-placement="top" title="Modificar Colaborador"><i class="fa fa-user"></i>
                                            </button> 
                                        </span>
                                </div>

                                <label for="">Fecha Desde</label>
                                <div class="input-group">
                                    <input type="text" id="txtFechaDesde" class="form-control disabled" disabled> 
                                        <span class="input-group-btn"> 
                                            <button type="button" class="btn btn-primary" id="btnEditFechaD" data-toggle="tooltip" data-placement="top" title="Modificar Fecha Desde"><i class="fa fa-edit"></i>
                                            </button> 
                                        </span>
                                </div>

                                <label for="">Hora Desde</label>
                                <div class="input-group">
                                    <input type="text" id="txtHoraDesde" class="form-control disabled" disabled> 
                                        <span class="input-group-btn"> 
                                            <button type="button" class="btn btn-primary" id="btnEditHoraD" data-toggle="tooltip" data-placement="top" title="Modificar Hora Desde"><i class="fa fa-edit"></i>
                                            </button> 
                                        </span>
                                </div>

                                <label for="">Fecha Hasta</label>
                                <div class="input-group">
                                    <input type="text" id="txtFechaHasta" class="form-control disabled" disabled> 
                                        <span class="input-group-btn"> 
                                            <button type="button" class="btn btn-primary" id="btnEditFechaH" data-toggle="tooltip" data-placement="top" title="Modificar Fecha Hasta"><i class="fa fa-edit"></i>
                                            </button> 
                                        </span>
                                </div>

                                <label for="">Hora Hasta</label>
                                <div class="input-group">
                                    <input type="text" id="txtHoraHasta" class="form-control disabled" disabled> 
                                        <span class="input-group-btn"> 
                                            <button type="button" class="btn btn-primary" id="btnEditHoraH" data-toggle="tooltip" data-placement="top" title="Modificar Hora Hasta"><i class="fa fa-edit"></i>
                                            </button> 
                                        </span>
                                </div>
                           
                        </form>
                    </div>

                     <div class="col-md-6">
                        <form action="" method="POST" role="form">
                            <input type="hidden" id="codPermiso">
                            <div class="form-group">
                                <label for="">Observaciones</label><span class="pull-right"><i class="fa fa-edit text-primary" id="btMOdObs" title="Modificar Observación" style="cursor: pointer;"></i></span>
                                <textarea name="" id="observacion" disabled class="form-control disabled" rows="12" required="required" style="resize: none"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="reset();" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarCambios">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>




<?php 
    include 'librerias_js.php';

?>
<script src="js/sube_baja.js"></script>
<style>
    .btn-group bootstrap-select open
    {
         width: 70%;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<script>

    $(document).ready(function() {
       $(".js-source-states").select2();

        $(document).prop('title', 'Ausencias | Beauty SOFT - ERP');

        
            $('[data-toggle="tooltip"]').tooltip();

            $('.selectpicker').css("display", "none");
            
    });

    

     

    $('#datapicker2').datepicker({ format: "yyyy-mm-dd"}).datepicker("setDate", "0");
    $('#datapicker3').datepicker({ format: "yyyy-mm-dd"}).datepicker("setDate", "0");

            $("#datepicker").on("changeDate", function(event) 
            {
                $("#my_hidden_input").val(
                        $("#datepicker").datepicker('getFormattedDate')
                )
                dateFormat: "yy-mm-dd"
            });

    $('.clockpicker').clockpicker({autoclose: true});
    $('.clockpicker2').clockpicker({autoclose: true});

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



    $('.input-group.date').datepicker({ 
        format: "yyyy-mm-dd",
        startDate: '-0d',
        language: 'es',
        today: "Today",
    });



    $(document).on('change', '#fecha_hasta', function(event) {
        
        var fecha1=$("#fecha_de").val();
        var fecha2=$("#fecha_hasta").val();
        var a = Date.parse(fecha1);
        var b = Date.parse(fecha2);
        var c = b-a;

         if(c<0)
        {
            swal('Error!','La fecha "hasta" debe ser posterior a la fecha "desde"','error');
        }
    });



    $('.input-group2.date2').datepicker({ format: "yyyy-mm-dd"});

    $(document).on('click', '#btn-registar', function(event) 
    {
        var sel     = $('#col').val();
        var fecde   = $('#fecha_de').val();
        var horade  = $('#hora_de').val();
        var fhasta  = $('#fecha_hasta').val();
        var hhasta  = $('#hora_hasta').val();
        var observ  = $('#observaciones').val();

        if (sel == "") 
        {
            swal("Debe seleccionar un colaborador", "", "warning");
        }else
        {

            if (fecde > fhasta) 
            {
                swal("Las fecha de inicio es mayor que la fecha final", "", "warning");
            }
            else
            {
                if (fecde == fhasta && horade >= hhasta) 
                {
                    swal("La hora inicial es mayor o igual a la hora final", "", "warning");
                }
                else
                {         
                    $('#btn-registar').button('loading');                     
                    $.ajax({
                        url: 'php/permisos/registropermiso.php',
                        method: 'POST',
                        data: {sel: sel, fecde:fecde, horade:horade, fhasta:fhasta, hhasta:hhasta, observ:observ},
                        success: function (data) 
                        {
                            if (data) 
                            {
                                swal("Ausencia registrada. Consecutivo N° "+data+" ", "", "success");
                                $('#col').val('');
                                $('#fecha_de').val('');
                                $('#hora_de').val('');
                                $('#fecha_hasta').val('');
                                $('#hora_hasta').val('');
                                $('#observaciones').val('');
                                tbl_permisos ();
                                $('#btn-registar').button('reset');
                            }
                            else{
                                swal('Oops!','Ha ocurrido un error al gestionar la ausencia, por favor recargue la página e inténtelo nuevamente','error');
                            }
                        },
                        error:function(){
                            swal('Boom!','Ha ocurrido una explosión en el codigo, por favor recargue la página e inténtelo nuevamente. Si el error persiste comuníquese con el departamento de sistemas','error');
                        }
                    });
                } 
            }
        }
    });

    $(document).ready(function() {
        tbl_permisos ();
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
                    url: 'php/permisos/busquedas_permisos_fechas.php',
                    method: 'POST',
                    data: {desde:desde, hasta:hasta},
                    success: function (data) 
                    {
                        var array = eval(data);
                        $('#tbl_permisos tbody').empty();
                        if (array != '1') 
                        {
                            for(var i in array)
                    {

                        if (array[i].estado == 'REGISTRADO') 
                        {

                            $('#tbl_permisos tbody').append('<tr class="active"><td class="idpermiso">'+array[i].id+'</td><td>'+array[i].colaborador+'</td><td>'+array[i].desde+'</td><td>'+array[i].hasta+'</td><td>'+array[i].usu_reg+'</td><td>'+array[i].usu_aut+'</td><td>'+array[i].estado+'</td><td><center><button class="btn btn-info btn-xs" id="btnEditPermiso" data-idpermiso="'+array[i].id+'" title="Modificar"><i class="fa fa-edit"></i></button></center></td></tr>');
                        }
                        else
                        {
                             $('#tbl_permisos tbody').append('<tr class="active"><td class="idpermiso">'+array[i].id+'</td><td>'+array[i].colaborador+'</td><td>'+array[i].desde+'</td><td>'+array[i].hasta+'</td><td>'+array[i].usu_reg+'</td><td>'+array[i].usu_aut+'</td><td>'+array[i].estado+'</td><td><center><button class="btn btn-info btn-xs disabled" disabled><i class="fa fa-edit"></i></button></center></td></tr>');
                        }
                    }
                            
                        }
                        else
                        {
                            swal("No hay registros disponibles", "", "warning");
                            $('#tbl_permisos tbody').append('<tr><td colspan="7"><center><b>No hay registros disponibles</b></center></td></tr>');
                        }
                    }
                });
            }


    });

    $(document).ready(function() {
    //load_lista_permisos () ;
    tbl_permisos();
});


var  tbl_permisos  = function() { 
   var tbl_est = $('#tbl_permisos').DataTable({
    "ajax": {
      "method": "POST",
      "url": "php/permisos/buscar_permisos.php",
      },
      "columns":[
        {"data": "percodigo"},
        {"data": "trcrazonsocial"},
        {"data": "fecha_desde"},
        {"data": "fecha_hasta"},
        {"data": "usu_reg"},
        {"data": "usu_aut"},
        {"data": "estado_tramite"},
      ],"language":{
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrada de _MAX_ registros)",
        "loadingRecords": "Cargando...",
        "processing":     "Procesando...",
        "search": "Buscar Colaborador:",
        "zeroRecords":    "No se encontraron registros coincidentes",
        "paginate": {
          "next":       "Siguiente",
          "previous":   "Anterior"
        } 
        },  
         "columnDefs":[
              {className:"idevento","targets":[0]},
            ],
             
        "order": [[0, "desc"]],
         "bDestroy": true,
  });
};

/*===========================================
=            MODAL VER SERVICIOS            =
===========================================*/

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

                var imagen   =  "";
                var cod      =  "";
                var nombre   =  "";
                var cargo    =  "";
                    var servicio =  "";
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

/*=====  End of MODAL VER SERVICIOS  ======*/



$(document).on('change', '#sel_estados', function () 
{
    var estado = $('#sel_estados').val();

    if (estado == 0) 
    {
        swal("Debe seleccionar un estado.", "", "warning");
    }
    else
    {
        $.ajax({
            url: 'php/permisos/buscar_estado_permisos.php',
            method: 'POST',
            data: {estado:estado},
            success: function (data) 
            {
                 var array = eval(data);
                $('#tbl_permisos tbody').empty();
                if (array != '1') 
                {
                    for(var i in array)
                    {

                        if (array[i].estado == 'REGISTRADO') 
                        {

                            $('#tbl_permisos tbody').append('<tr class="active"><td class="idpermiso">'+array[i].id+'</td><td>'+array[i].colaborador+'</td><td>'+array[i].desde+'</td><td>'+array[i].hasta+'</td><td>'+array[i].usu_reg+'</td><td>'+array[i].usu_aut+'</td><td>'+array[i].estado+'</td><td><center><button class="btn btn-info btn-xs" id="btnEditPermiso" data-idpermiso="'+array[i].id+'" title="Modificar"><i class="fa fa-edit"></i></button></center></td></tr>');
                        }
                        else
                        {
                             $('#tbl_permisos tbody').append('<tr class="active"><td class="idpermiso">'+array[i].id+'</td><td>'+array[i].colaborador+'</td><td>'+array[i].desde+'</td><td>'+array[i].hasta+'</td><td>'+array[i].usu_reg+'</td><td>'+array[i].usu_aut+'</td><td>'+array[i].estado+'</td><td><center><button class="btn btn-info btn-xs disabled" disabled><i class="fa fa-edit"></i></button></center></td></tr>');
                        }
                    }
                    
                }
                else
                {
                    swal("No hay registros disponibles con el estado "+ estado, "", "warning");
                    $('#tbl_permisos tbody').append('<tr><td colspan="9"><center><b>No hay registros disponibles</b></center></td></tr>');
                }
            }
        });
    }
});


$(document).on('click', '#btnEditPermiso', function() 
{
    var idpermiso = $(this).data("idpermiso");
    $('#codPermiso').val(idpermiso);
    $('#modalEditPerm').modal("show");

    $.ajax({
        url: 'php/permisos/editarPermiso.php',
        method: 'POST',
        data: {idpermiso:idpermiso},
        success: function (data) 
        {
            var jsonPermiso = JSON.parse(data);

            if (jsonPermiso.res == "full") 
            {
                for(var i in jsonPermiso.json)
                {
                    $('#txtCol').val(jsonPermiso.json[i].colaborador);
                    $('#txtFechaDesde').val(jsonPermiso.json[i].Fechadesde);
                    $('#txtHoraDesde').val(jsonPermiso.json[i].Horadesde);
                    $('#txtFechaHasta').val(jsonPermiso.json[i].Fechahasta);
                    $('#txtHoraHasta').val(jsonPermiso.json[i].Horahasta);
                    $('#observacion').val(jsonPermiso.json[i].observacion);
                    $('#clbcodigo').val(jsonPermiso.json[i].clbcodigo);
                    
                }
            }
        }
    });

});



$(document).ready(function() 
{
    change_color_bar ();
});


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




ListarCola();
function change_color_bar () {
    $.ajax({
        url: 'php/sube_baja/change_color_bar.php',
        method: 'POST',
        data: {cod_salon: $('#cod_salon').val()},
        success: function (data) {
            if (data == 1) {
                $('#sidebar').css("color", "red").html('<i class="pe-7s-add-user"></i>');
            }else{
                $('#sidebar').css("color", "#9d9fa2").html('<i class="pe-7s-menu"></i>');
            }
        }
    });
}


    $(document).ready(function() {
        $(document).on('click', '.selector', function(event) {
            var url = $(this).data("url");
            var res = url.substr(19); 
            
            $.ajax({
                url: 'bloquear_pantalla.php',
                method: 'POST',
                data: {url:url},
                success: function (data) 
                {
          
                    window.location="bloquear_pantalla.php?url="+res+"";
                }
            });
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


/****************************/

//Habilitar Edición

/***************************/

$('#txtFechaDesde').datepicker({ 
    format: "yyyy-mm-dd",
    startDate: '-0d',
    language: 'es',
    today: "Today",
});

$('#txtFechaHasta').datepicker({ 
    format: "yyyy-mm-dd",
    startDate: '-0d',
    language: 'es',
    today: "Today",
});


$('#txtHoraDesde').clockpicker({autoclose: true});

$('#txtHoraHasta').clockpicker({autoclose: true});

$(document).on('click', '#btnEditFechaD', function() 
{
   $('#txtFechaDesde').removeClass('disabled', true);
   $('#txtFechaDesde').removeAttr('disabled', true);
});


$(document).on('click', '#btnEditHoraD', function() 
{
   $('#txtHoraDesde').removeClass('disabled', true);
   $('#txtHoraDesde').removeAttr('disabled', true);
});


$(document).on('click', '#btnEditFechaH', function() 
{
   $('#txtFechaHasta').removeClass('disabled', true);
   $('#txtFechaHasta').removeAttr('disabled', true);
});


$(document).on('click', '#btnEditHoraH', function() 
{
   $('#txtHoraHasta').removeClass('disabled', true);
   $('#txtHoraHasta').removeAttr('disabled', true);
});

$(document).on('click', '#btMOdObs', function() 
{
   $('#observacion').removeClass('disabled', true);
   $('#observacion').removeAttr('disabled', true);
});


$(document).on('click', '#btnGuardarCambios', function() 
{
    var fd = $('#txtFechaDesde').val();
    var hd = $('#txtHoraDesde').val();
    var fh = $('#txtFechaHasta').val();
    var hh = $('#txtHoraHasta').val();
    var ob = $('#observacion').val();
    var id = $('#codPermiso').val();

    if (fd == "") 
    {
        swal("Ingrese la fecha desde", "", "warning");
    }
    else
    {
        if (hd == "") 
        {
            swal("Ingrese la hora", "", "warning");
        }
        else
        {
            if (fh == "") 
            {
                swal("Ingrese la fecha hasta", "", "warning");
            }
            else
            {
                if (hh == "") 
                {
                    swal("Ingrese la hora", "", "warning");
                }
                else
                {
                    if (ob == "") 
                    {
                        swal("Debe ingresar la observación", "", "warning");
                    }
                    else
                    {

                        if (fd > fh) 
                        {
                            swal("Las fecha de inicio es mayor que la fecha final", "", "warning");
                        }
                        else
                        {
                            if (fd == fh && hd >= hh) 
                            {
                                swal("La hora inicial es mayor o igual a la hora final", "", "warning");
                            }
                            else
                            { 
                                $.ajax({
                                    url: 'php/permisos/modificar.php',
                                    method: 'POST',
                                    data: {fd:fd, hd:hd, fh:fh, hh:hh, ob:ob, id:id},
                                    success: function (data) 
                                    {                                        
                                        if (data == 1) 
                                        {
                                            swal("Se ha modificado el permiso", "", "success");
                                            $('#modalEditPerm').modal("hide");    
                                            $('#sel_estados').change();                                        

                                        }
                                    }
                                });
                            }
                        }
                    }
                }
            }
        }
    }
});


 $(document).on('change', '#txtFechaHasta', function(event) 
 {
        
        var fecha1=$("#txtFechaDesde").val();
        var fecha2=$("#txtFechaHasta").val();
        var a = Date.parse(fecha1);
        var b = Date.parse(fecha2);
        var c = b-a;

        if(c<0)
        {
            swal('Error!','La fecha "hasta" debe ser posterior a la fecha "desde"','error');
        }
});


 function reset () 
 {
    $('#txtFechaDesde').addClass('disabled', true);
    $('#txtFechaDesde').attr('disabled', true);
    $('#txtHoraDesde').addClass('disabled', true);
    $('#txtHoraDesde').attr('disabled', true);
    $('#txtFechaHasta').addClass('disabled', true);
    $('#txtFechaHasta').attr('disabled', true);
    $('#txtHoraHasta').addClass('disabled', true);
    $('#txtHoraHasta').attr('disabled', true);
    $('#observacion').addClass('disabled', true);
    $('#observacion').attr('disabled', true);
 }



</script>



<style>
    th,td{
        white-space: nowrap;
        font-size: .8em;
    }
</style>