<?php
include '../cnx_data.php';
include 'head.php';
include 'librerias_js.php';
?>
<div id="">

    <div class="small-header">
        <div class="hpanel">
            <div class="panel-body">
                <div id="hbreadcrumb" class="pull-right">
                    <ol class="hbreadcrumb breadcrumb">
                        <li><a href="index.php">Inicio</a></li>
                        <li class="active">
                            <span>Reportes</span>
                        </li>
                        <li class="active">
                            <span>Registro Domicilios</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    Reporte de Servicios a Domicilio
                </h2>
            </div>
        </div>
    </div>

<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-heading">
                </div>
                <div class="panel-body">

                        <div class="text-center m-b-md" id="wizardControl">

                            <button class="btn btn-primary" onclick="location.reload();" id="p1" data-toggle="tooltip" data-placement="top" title="">Paso 1 - Parametros del reporte</button>
                            <a class="btn btn-default" id="p2">Paso 2 - Procesando datos</a>
                            <a class="btn btn-default" id="p3">Paso 3 - Resultado Reporte</a>
                           <button class="btn btn-default pull-right exportbtn" data-toggle="tooltip" data-placement="top" title="Exportar a Excel" style="display:none;" id="expexcel"><span class="fa fa-file-excel-o" style="color:green;"></span></button>
                            <button class="btn btn-default pull-right exportbtn" data-toggle="tooltip" data-placement="top" title="Exportar a PDF" style="display:none;" id="exppdf"><span class="fa fa-file-pdf-o" style="color:red;"></span></button>

                        </div>

                        <div class="tab-content">
                        <div id="step1" class="p-m tab-pane active">

                            <div class="m-b-md" id="paso1">
                                <br>                          
                                    <div class="text-center m-b-md">
                                        <div class="form-group col-md-6 col-md-push-3">
                                            <div class="form-group col-md-6">
                                              <label for="fecha1">Desde: </label>
                                              <input type="text" class="form-control fecha text-center" id="fecha1" name="fecha1" value="Elija fecha" style="caret-color:white" >
                                            </div>
                                            <div class="form-group col-md-6">
                                              <label for="fecha2">Hasta: </label>
                                              <input type="text" class="form-control fecha text-center" id="fecha2" name="fecha2" value="Elija fecha" style="caret-color:white" disabled>

                                            </div>
                                            <div class="col-md-12 ">
                                            <label for="selsalon2">Salon: </label><br>
                                                <select class="form-control gen" name="selsalon2[]" id="selsalon2" data-error="Escoja una opcion" multiple="multiple" style="width:100%">
                                                    <!-- <option value="0">Todos los salones</option> -->
                                                    <?php
                                                    $result = $conn->query("SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado=1 ORDER BY slnnombre");
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {                
                                                            echo '<option value="'.$row['slncodigo'].'">'.$row['slnnombre'].'</option>';
                                                        }
                                                    }
                    
                                                    ?>
                                                </select>  
                                            </div>
                                    </div>
                                    </div>
                                    <div class="form-group col-md-12 ">
                                        <button class="btn pull-right" id="siguiente" disabled data-toggle="tooltip" data-placement="top" title="Siguiente"><span class="fa fa-chevron-circle-right" style=""></span></button>
                                    </div> 
                                
                            </div>
                            <div id="paso2" style="display:none;">
                                <div id="loading" style="display:none;">
                                    <center>
                                          <h1 id="insmsje">Generando reporte...</h1><br>
                                          <small>Si es la primera vez que lo genera, tomará mas tiempo mientras procesamos la informacion.</small><br>
                                          <style>
                                          /*style para la animacion del engranaje pequeño en reversa*/

                                              .fa-spin2 {
                                                transform: scaleX(-1);
                                                animation: spin-reverse 2s infinite linear;
                                              }
                                              @keyframes spin-reverse {
                                                0% {
                                                  transform: scaleX(-1) rotate(-360deg);
                                                }
                                                100% {
                                                  transform: scaleX(-1) rotate(0deg);
                                                }
                                              }
                                          </style>
                                          <i class="fa fa-cog fa-spin" style="font-size:100px;color:lightblue"></i><i class="fa fa-cog fa-spin2" style="font-size:50px;color:#FA9B3C"></i>
                                          <br><i class="fa fa-cog fa-spin2" style="font-size:50px;color:#FFFF99;margin-top: -10px !important;"></i>
                                          <br>
                                    </center>
                                </div>
                            </div>
                            <div id="paso3" style="display:none;">
                            <h4 class="text-center" id="encabezado">Reporte de Servicios a Domicilio por Salón </h4>
                                <div id="content" class="table-responsive" style="display:none;">
                                    <table id="tbregdom" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Cliente</th>
                                                <th class="text-center">Teléfono</th>
                                                <th class="text-center">Dirección</th>
                                                <th class="text-center">Salón</th>
                                                <th class="text-center">Fecha/Hora Agendado</th>
                                                <th class="text-center">Colaborador</th>
                                                <th class="text-center">Servicio</th>
                                                <th class="text-center">Fecha/Hora Servicio</th>
                                                <th class="text-center">Valor Servicio</th>
                                                <th class="text-center">Valor Recargo</th>
                                                <th class="text-center">Transp ida</th>
                                                <th class="text-center">Transp regreso</th>
                                                <th class="text-center">TOTAL</th>
                                                <th class="text-center">Estado</th>
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
<script>
    $("side-menu").children(".active").removeClass("active");  
    $("#REPORTES").addClass("active");
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });

    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

    $(document).ready(function() {
       $("#selsalon2").select2({
            placeholder: "TODOS LOS SALONES"
       });
    });

    $('.fecha').datepicker({
        format: "yyyy-mm-dd",
        today:"Today",
        option:"defaultDate"
      }).keydown(false); 

    $(".fecha").css('cursor', 'pointer');

    $("#fecha1").on('changeDate', function(e){
        $("#fecha2").removeAttr('disabled');
        $("#fecha2").val('');
        $("#fecha2").datepicker('show');
        $(this).datepicker('hide');
        $("#siguiente").attr('disabled', 'disabled');
        $("#siguiente").removeClass('btn-lg');
        $("#siguiente").removeClass('bg-primary');
    });
        
    $("#fecha2").on('changeDate', function(e){
        var fecha1=$("#fecha1").val();
        var fecha2=$("#fecha2").val();
        var a = Date.parse(fecha1);
        var b = Date.parse(fecha2);
        var c = b-a;
        if(c<0){
            swal('Error!','La fecha "hasta" debe ser posterior a la fecha "desde"','error');
            $("#fecha2").val('');
            $("#siguiente").attr('disabled', 'disabled');
            $("#siguiente").removeClass('btn-lg');
            $("#siguiente").removeClass('bg-primary');
        }else{
            $(this).datepicker('hide');
            $("#siguiente").addClass('btn-lg');
            $("#siguiente").removeAttr('disabled');
            $("#siguiente").addClass('bg-primary');
        }
    });
</script>
<script type="text/javascript">
    $("#siguiente").click(function(e){
        e.preventDefault();
        $("#p1").prop('onclick',null).off('click');
        $(this).attr('disabled', 'disabled');
        $("#paso1").hide();
        $("#paso2").show();
        $("#p1").removeClass('btn-primary');
        $("#p1").addClass('btn-default');
        $("#p2").removeClass('btn-default');
        $("#p2").addClass('btn-warning');
        $("#loading").show();
        var f1=$("#fecha1").val();
        var f2=$("#fecha2").val();
        var sln=$("#selsalon2").val();
        $(".fecha").attr('disabled', 'disabled');
        
        $("#p1").attr('onclick','location.reload()');
        $("#paso2").hide();
        $("#loading").hide();
        $("#paso3").show();
        $("#p2").removeClass('btn-warning');
        $("#p2").addClass('btn-default');
        $("#p3").removeClass('btn-default');
        $("#p3").css('background-color','green');
        $("#p3").css('color','white');
        $("#encabezado").append('  del '+f1+' al '+f2);
        $("#content").fadeIn(200);
        $("#salon").removeAttr('disabled');
        var listado = $('#tbregdom').DataTable({
            "ajax": {
            "method": "POST",
            "url": "reportes/repdomicilio.php",
            "data":{sln:sln,f1:f1,f2:f2},
            },
            dom: 'Bfrtip',
              buttons: [ 
                  {
                    extend:    'excel',
                    text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
                    titleAttr: 'Exportar a Excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 ]
                    },
                    title:'BeautySoft - Registro de Domicilios por salon del '+f1+' al '+f2,
                  }
              ],
            "columns":[
              {"data": "nomcli"},
              {"data": "telcli"},
              {"data": "dircli"},
              {"data": "salon"},
              {"data": "fechareg"},
              {"data": "nomcol"},
              {"data": "serv"},
              {"data": "fechaaten"},
              {"data": "valser" , render: $.fn.dataTable.render.number(',', '.', 0, '')},
              {"data": "valrec" , render: $.fn.dataTable.render.number(',', '.', 0, '')},
              {"data": "valtrai" , render: $.fn.dataTable.render.number(',', '.', 0, '')},
              {"data": "valtrar" , render: $.fn.dataTable.render.number(',', '.', 0, '')},
              {"data": "valtotal" , render: $.fn.dataTable.render.number(',', '.', 0, '')},
              {"data": "estado"}
              
            ],
            "language":{
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "",
                "infoFiltered": "(filtrada de _MAX_ registros)",
                "loadingRecords": "<h4><i class='fa fa-spin fa-spinner'></i> Cargando, por favor espere.\n Esta operación puede tardar varios minutos, sea paciente...</h4>",
                "processing":     "Procesando...",
                "search": "_INPUT_",
                "searchPlaceholder":"Buscar...",
                "zeroRecords":    "No se encontraron datos",
                "paginate": {
                  "next":       "Siguiente",
                  "previous":   "Anterior"
                } 
            },  
            "columnDefs":[
                {className:"text-center","targets":[1]},
                {className:"text-center","targets":[3]},
                {className:"text-center","targets":[4]},
                {className:"text-center","targets":[7]},
                {className:"text-right","targets":[8]},
                {className:"text-right","targets":[9]},
                {className:"text-right","targets":[10]},
                {className:"text-right","targets":[11]},
                {className:"text-right","targets":[12]},
                {className:"text-center","targets":[13]},
                
            ],  
            "order": [[4, "asc"]],
            "bDestroy": true,
            "pageLength":6,
        });
    });
</script>