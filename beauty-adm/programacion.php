<?php
    include("./head.php");
    include '../cnx_data.php';

    VerificarPrivilegio("PROGRAMACION DE COLABORADORES", $_SESSION['tipo_u'], $conn);
    RevisarLogin();
    $today = date("Y-m-d");    
?>
<div class="modal fade" tabindex="-1" role="dialog" id="my_modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Colaboradores en el turno</h4>
      </div>
        
      <div class="modal-body">
      <div id="lista"></div>
        
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div> <!-- colaborares en el turno -->



<div class="row">
    <div class="col-md-5" id="programacion" hidden>
        <div class="content animate-panel">
            <div class="row">
                <div class="hpanel">
                    <div class="panel-heading">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                            <a onclick="$('#programacion').attr('hidden', true); $('#nueva_programacion').attr('hidden', false);"><i class="fa fa-close"></i></a>
                        </div>
                        PROGRAMACIÓN   
                    </div>
                    <div class="panel-body">
                        <form id="formCopiarProgramacion">
                            <div class="table-responsive" id="prg_dia">
                                <h5>No hay programación para esta fecha.</h5>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="col-md-5" id="nueva_programacion">
        <div class="content animated-panel">
            <div class="row">
                <div class="hpanel">
                    <div class="panel-heading">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        NUEVA PROGRAMACIÓN  <a id="nuevo" type="button" class="btn " data-toggle="tooltip" data-placement="bottom" title="Nueva programaci&oacute;n" onclick="window.location = 'programacion.php';"><i class="fa fa-refresh text-info"></i></a>
                    </div>
                    <div class="panel-body">
                        <button type="button" class="btn btn-info btn-xs pull-right" data-toggle="modal" data-target="#modalFiltrocargo" id="btn_filtro_col" title="Ver colaboradores" style="margin-left: 10px"><i class="fa fa-plus-square"></i></button>
                        <button type="button" class="btn btn-primary btn-xs pull-right" id="btnVista" title="Vista general de programación"><i class="fa fa-search"></i></button>
                    <form id="form_proga" name="form_proga" >
                        <div class="row">                             
                                    <input type="hidden" value="salon" id="p">
                                    <label class="control-label">Salón</label>
                                    <div class="form-group">
                                       
                                        <select class="form-control" id="selectSalon" name="selectSalon">                                            
                                            <?php
                                            
                                                $sql = "SELECT `slncodigo`, `slnnombre`, `slnalias` FROM `btysalon` WHERE slnestado = 1 ORDER BY slnnombre";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0){
                                                    $sw = 0;
                                                    while ($row=$result->fetch_assoc()) {
                                                        if ($sw == 0) {
                                                            $sln = $row['slncodigo'];
                                                            $sw = 1;
                                                        }
                                                        echo "<option value='".$row['slncodigo']."'>".$row['slnnombre']."</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                        </div>
                                        <!-- <div class="input-group">
                                            <select name="sel_unimedida" id="sel_unimedida" class="form-control">
                                                   
                                            </select>
                                            <div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Unidad de Medida">
                                              <button type="button" data-toggle="modal" data-target="#modalunimedi" id="btn_unidad_med" name="btn_unidad_med" class="btn btn-default">
                                                <span class="fa fa-plus-square text-info"></span>
                                              </button>
                                            </div>
                                          </div> -->
                                
                            
                        </div>
                        <div class="row">
                            <!--<div class="col-sm-12">-->
                                <div class="form-group">
                                    <label class="control-label">Fecha</label>
                                    <input type="text" class="form-control fecha" id="fecha" name="fecha" value="<?php echo $today ?>" required>
                                </div>
                            <!--</div>-->
                        </div>
                        <div class="row">
                            <!--<div class="col-sm-12">-->
                                <div class="form-group">
                                    <label class="control-label">Turno</label>
                                    <select class="form-control" id="selectTurno" name="selectTurno" required>

                                    </select>
                                </div>
                            <!--</div>-->
                        </div>
                        <div class="form-group">
                            <button class="btn btn-default btn-sm" type="button" title="Fijar" onclick="if ($('#selectTurno').val() != '') {
                                $('#cola').attr('hidden', false);
                                $('#selectSalon').attr('readonly', true);
                                $('#selectTurno').attr('readonly', true);
                                //$('#fecha').attr('readonly', true);
                                $(this).attr('hidden', true);
                                }"><i class="pe-7s-pin text-info"></i></button>
                            
                        </div>
                        <div id="cola" hidden>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Colaborador</label>
                                    <div>
                                    <select id="selectColaborador" name="selectColaborador" class="js-example-basic-single form-control" placeholder="Nombre del Colaborador" required>
                                    <?php 
                                        // $sql = "SELECT c.`clbcodigo`, c.`trcdocumento`, t.trcrazonsocial FROM `btycolaborador` c INNER JOIN btytercero t ON t.trcdocumento = c.trcdocumento WHERE c.clbestado = 1 ORDER BY t.trcrazonsocial ";
                                        //     $result = $conn->query($sql);
                                        //     if ($result->num_rows > 0){
                                        //         while ($row=$result->fetch_assoc()) {
                                        //             echo "<option value='".$row['clbcodigo']."'>".utf8_encode($row['trcrazonsocial'])."</option>";
                                        //         }
                                        //     } else {
                                        //         echo "<option value=''>--No hay resultados--</option>";
                                        //     }
                                    ?>
                                    </select><!-- <div class="input-group-btn"><button id="agregar" class="btn btn-default"><i class="fa fa-save text-info"></i></button></div> -->
                                    </div>
                                    <div class="help-block">Seleccione colaboradores para agregar a la programacion.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Puesto de trabajo</label>
                                    <div class="input-group">
                                    <select name="selectPuestoTrabajo" id="selectPuestoTrabajo" class="form-control">
                                            <?php
                                                include 'select_puestos.php';  
                                            ?>
                                        </select>
                                        <div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Ver plano del salón">
                                            <button type="button" data-toggle="modal" data-target="#modalVerPlanoSln" id="btnVerPlano" name="btn_filtro_col" class="btn btn-default">
                                                <span class="fa fa-plus-square text-info"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Tipo programación</label>
                                        <select id="selectTipoProgramacion" name="selectTipoProgramacion" class="form-control" required>
                                            <?php
                                                $sql = "SELECT `tprcodigo`, `tprnombre`, `tpralias`, `tprlabora`, `tprestado` FROM `btytipo_programacion` WHERE tprestado = 1 ORDER BY tprnombre";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row=$result->fetch_assoc()) {
                                                        echo "<option value='".$row['tprcodigo']."'>".$row['tprnombre']."</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''> No hay resultados </option>";
                                                }
                                            ?>
                                        </select>
                                </div>
                            </div>    
                        </div>
                        <input  type="submit" id="btn" value="Agregar" class="btn btn-success" />  
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group" hidden>
                                    <label>Horario</label>
                                    <select class="form-control" id="selectHorario" name="selectHorario" required>
                                        <?php include 'select_horario.php'; ?>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                         
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
        <div class="col-md-7" id="panelTurnoColabrador">
        <div class="content animate-panel">
            <div class="row">
                <div class="hpanel">
                    <div class="panel-heading">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a><!-- calendar-o -->
                            <a onclick="$('#panelTurnoColabrador').attr('hidden', true); $('#panelCalendario').attr('hidden', false); $('#calendar').fullCalendar('destroy'); crear_calendario();"><i class="fa fa-calendar-o"></i></a>
                        </div>
                        Colaboradores en el turno
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <div id="col_on_turn">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12" id="panelCalendario">
        <div class="content animate-panel">
            <div class="row">
                <div class="hpanel">
                    <div class="panel-heading">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                            <a onclick="$('#panelTurnoColabrador').attr('hidden', false); $('#panelCalendario').attr('hidden', true);"><i class="fa fa-close"></i></a>
                        </div>
                        CALENDARIO
                        <button type="button" class="btn btn-default btn-xs" id="btnReporteMes" title="Imprimir en PDF"><i class="fa fa-file-pdf-o text-info"></i></button>
                    </div>
                    <div class="panel-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<div class="modal fade" tabindex="-1" role="dialog" id="copy">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Copiar programación en...</h4>
      </div>
        
    <div class="modal-body">
      <form id="formularioCopiarProgramacion">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="control-label">Fecha</label>
                    <input type="text" class="form-control fecha" id="copyOnfecha" name="copyOnfecha" value="<?php echo $today ?>" required>
                    <div class="help-block">  
                        Escoja la fecha en la cual copiar&aacute; la programaci&oacute;n
                    </div>
                </div>
            </div>
        </div>
        <div class="row" hidden>
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="control-label">Horario</label>
                    <select name="horarioCopy" id="horarioCopy" class="form-control">
                     <?php include 'select_horario.php'; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="control-label">Turno</label>
                    <select name="turnoCopy" id="turnoCopy" class="form-control">
                    </select>
                </div>
            </div>
        </div>
         <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="control-label">Informe</label>
                    <code><textarea name="" id="informelog" class="form-control" disabled rows="4"></textarea></code>
                </div>
            </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Copiar</button>
       </form>
      </div>
        
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div> <!-- Copiar y enviar -->



<div class="modal fade" tabindex="-1" role="dialog" id="copySemana">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Copiar programación</h4>
      </div>
        
    <div class="modal-body">
      <form id="formularioCopiarProgramacionBloque">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="control-label">Fecha</label>
                    <input type="text" class="form-control fecha" id="InFechaCopiar" name="InFechaCopiar" value="<?php echo $today ?>" required>
                  <!--  <div class="help-block">  
                      Escoja la fecha en la cual copiar&aacute; la programaci&oacute;n
                  </div> -->
                </div>
            </div>
            
            <br><br><br>
             <div class="col-sm-12">
                <div class="form-group">
                    <label class="control-label">Listado de Fechas</label>
                    <select name="SlFechaCopiar" size="4"  id="SlFechaCopiar" class="form-control">
                    </select>
                    <!-- <input type="text" class="form-control fecha" id="fecha3" name="copyOnfechaBloque" value="<?php echo $today ?>" required> -->
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="control-label">Turno</label>
                    <select name="SlTurnoCopiar"  id="SlTurnoCopiar" class="form-control">
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="control-label">Informe</label>
                   <textarea name="TaLogCopiar" id="TaLogCopiar" class="form-control" rows="3"></textarea>
                </div>
            </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn_copiarBloque" class="btn btn-success">Copiar</button>
       </form>
      </div>
        
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div> <!-- Copiar y enviar -->


<!-- Modal -->
<div class="modal fade" id="modalFiltrocargo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="txt_title">Colaboradores Salón </h4>
          </div>
          <div class="modal-body">           
            <div class="row">
                <div class="col-md-12">               
                    <table class="table table-hover table-bordered" id="tbl_filter_col">
                        <thead>
                            <tr>
                                <th>CARGO</th>
                                <th>COLABORADOR</th>
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


<!-- Modal -->
<div class="modal fade" id="VerCargosPeriles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="txt_title">Cargos y perfiles </h4>
          </div>
          <div class="modal-body">           
            <div class="row">
                <div class="col-md-12">               
                       <!-- <h6><b>Conteo de Colaboradores Según Categorías Tipo: LABORA</b></h6>  -->                      
                       <div id="listaCat"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="VerCargosEstados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="txt_title">Estados </h4>
          </div>
          <div class="modal-body">           
            <div class="row">
                <div class="col-md-12">               
                       <div class="panel panel-info">
                          <div class="panel-body">
                            <div id="listaEst"></div>
                          </div>
                         <!--  <div class="panel-footer">Panel footer</div> -->
                        </div>                      
                       
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalVerPlanoSln" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="SlnPlano"> </h4>
          </div>
          <div class="modal-body">           
            <div class="row">
                <div class="col-md-12">                                            
                     <img id="imagen_salon" src="" alt="Salón" class="img-responsive">
                </div>
            </div>
        </div>
    </div>
</div>





<style>
    .clickable
    {
       cursor: pointer;   
    }

    th{
        text-align: center;
    }

    /* .pbody
    {
        display: none;
    } */

</style>


<?php include "librerias_js.php" ?>

<script type="text/javascript">
    $(".js-example-basic-single").select2();

      $('.fecha').datetimepicker({
        format: "YYYY-MM-DD",
        locale: "es",
        
  });

   
</script>

<!-- RELACION FILTROS DE LOS COMBOS -->
<script type="text/javascript">
listar_horarios(0);
listar_horarios(1);
 // MUESTRA EL COMBO QUE PERMITE HACER EL UPDATE DEL TIPO DE PROGRAMACION
function cambiar_tipo (idSelect, tipoActual) 
{
    $('#'+idSelect).attr('hidden', false);
}
function actualizar_tipo (codigoColaborador, fecha) 
{
    var nuevoTipo = $('#'+codigoColaborador).val();
    $.ajax({
        type: "POST",
        url: "update_tipoProgramacion.php",
        data: {colaborador: codigoColaborador, fecha: fecha, nuevo: nuevoTipo},
        success: function (res) {
            if (res == "TRUE") 
            {
                 $('#'+codigoColaborador).attr('hidden', true);
                 $('#a'+codigoColaborador).attr('hidden', false);
                 $('#a'+codigoColaborador).html($('#'+codigoColaborador+' option[value='+nuevoTipo+']').html());
            } else {

            }
        }

    });

}
function eliminar (colaborador, fech, este) {
        swal({
            title: "¿Seguro que desea quitar este colaborador?",
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
                url: "delete_progra.php",
                data: {fecha: fech, col: colaborador},
                success: function (res) {
                    if (res == "TRUE") {
                        $(este).parent().parent().remove();
                        colaboradoresTurno ();
                    }
                }
            });
        });
}

function colaboradoresTurno () {
    var trn = $('#selectTurno').val();
    var fecha_turno = $('#fecha').val();
    // alert(trn+"+"+fecha_turno);
    $.ajax({
        type: "POST",
        url: "find_col_on_turn.php",
        data: {id_turno: trn, fch: fecha_turno,salon:$("#selectSalon").val()},
        success: function(data) {
            $('#col_on_turn').html(data);
        }
    });
}

function listar_horarios (puntero) {
    if (puntero == 1) {
        var fecha = $('#copyOnfecha').val();    
    } else {
        var fecha = $('#fecha').val();
    }
    var salon = $('#selectSalon').val();
    $.ajax({
        type: "POST",
        url: "select_horario.php",
        data: {fecha: fecha, salon: salon},
        success: function (res) {
            //alert(res);
            if (puntero == 1) {
                $('#horarioCopy').html(res);
                listar_turnos(1);
            } else {
                $('#selectHorario').html(res);
                listar_turnos();
            }
        }
    });
}

function listar_turnos_Copiar() {
    
    var fecha = $('#InFechaCopiar').val();   

    var salon = $('#selectSalon').val();

    $.ajax({
        type: "POST",
        url: "select_turno_copiar.php",
        data: {fecha: fecha, salon: salon},
        success: function (res) 
        {
            $('#SlTurnoCopiar').html(res);             
        }
    });
}
function listar_turnos (puntero) {
    if (puntero == 1) {
        var horario = $('#horarioCopy').val();
    } else {
        var horario = $('#selectHorario').val();
    }
    var salon = $('#selectSalon').val();
    $.ajax({
        type: "POST",
        url: "select_turno.php",
        data: {horario: horario, salon: salon},
        success: function (res) {
           // alert(res);
            if (puntero == 1){
                $('#turnoCopy').html(res);
                //$('#turnoCopySem').html(res);

            } else {
                $('#selectTurno').html(res);
                //colaboradoresTurno();

                   // $('#calendar').fullCalendar('gotoDate', currentDate);
                   
            } 
        }
    });

    $(document).on('blur', '#fecha', function() 
    {
        $('#tbl_listado').remove();
        $('#calendar').fullCalendar('gotoDate', $('#fecha').val());
        //alert("data"+$('#fecha').val());
    });
}
    $('#selectTurno').change(function () {
        colaboradoresTurno();
    });
    $('#selectSalon').change(function() {
        var salon = "codigosalon="+$(this).val();
        $.ajax({
            type: "POST",
            url: "select_puestos.php",
            data: salon,
            success: function (res) {
                $('#selectPuestoTrabajo').html(res);

            }
        });
        listar_horarios(0);
        $('#calendar').fullCalendar('destroy');
        crear_calendario();
        colaboradoresTurno();
    });

    $('#fecha').change(function () {
        listar_horarios(0);
    });

        $('#fecha').blur(function () {
           listar_horarios(0);
        });
 
    $('#InFechaCopiar').change(function () {
        listar_turnos_Copiar();
    });

    $('#InFechaCopiar').blur(function () {
        listar_turnos_Copiar();
    });

    $('#selectHorario').change(function() {
        listar_turnos ();
    });

    $('#s2id_autogen1_search').keyup(function(){
        $.ajax({
            type: "POST",
            url: "selectColaborador.php",
            success: function (res) {
                $('#selectColaborador').html(res);
            }
        });
    });

</script>
 <!-- COPIAR PROGAMACION -->
<script type="text/javascript">
   function copiar (fechaProgramacion) {
        $('#copy').modal("show");
   }
</script>

<!-- ENVIO DE FORMULARIO PARA INSERTAR -->
<script type="text/javascript">
    $('#form_proga').on('submit', function(event) {
        event.preventDefault();
        var datosFormulario = new FormData(document.getElementById('form_proga'));
        $.ajax({
            type: "POST",
            url: "insert_proga.php",
            dataType: "html",
            data: datosFormulario,
            cache: false,
            contentType: false,
            processData: false,
            success: function (res) {

                if (res == "TRUE") {
                    swal({
                        title: "Colaborador programado correctamente.",
                        text: "",
                        type: "success",
                        confirmButtonText: "Aceptar",
                    },
                    function () {
                        //$('#calendar').fullCalendar('destroy');
                        crear_calendario();
                        colaboradoresTurno();
                        // $('#form_proga')[0].reset();

                    });
                } else if (res == "FALSEE") {
                    swal({
                        title: "Este colaborador ya fue programado en la fecha "+$('#fecha').val() + " ",
                        text: "",
                        type: "warning",
                        confirmButtonText: "Aceptar",
                    },
                    function () {
                        

                    });
                } else if (res == "EXIST") {
                    swal({
                        title: "No se puede asignar colaborador en este puesto de trabajo.",
                        text: "",
                        type: "warning",
                        confirmButtonText: "Aceptar",
                    },
                    function () {
                        

                    });
                }
            }
        });
    });
</script>
<!-- ENVIO DE FORMULARIO PARA COPIAR PROGRAMACION -->
<script type="text/javascript">
    $('#formularioCopiarProgramacion').on("submit", function(event) {
        event.preventDefault();

        if ($('#copyOnfecha').val() != "") {

            var fecha1 = $('#copyOnfecha').val();
            var fecha2 = $('#fecha').val();
            $.ajax({
                type: "POST",
                url: "copiarProgramacion.php",
                data: {fecha: fecha2, nuevafecha: fecha1, turno: $('#selectTurno').val(), nuevoTurno: $('#turnoCopy').val(), salon: $('#selectSalon').val(), horario: $('#horarioCopy').val()},
                success: function (res) 
                {
      
                    if (res) 
                    {
                        swal("Copia ejecutada", "", "success");
                        $('#calendar').fullCalendar('destroy');
                        crear_calendario();
                        colaboradoresTurno();
                        $('#informelog').val("Errores de pegado: El(los) siguiente(s) colaborador(es) tiene(n) asignada otra programación, para esta fecha:" + " \n" + res);
      
                    }
                  

                  
                   /*if (res == "TRUE") {
                        swal({
                        title: "Copia de programación realizada con exito.",
                        text: "Puede seguir copiando la programacion a otras fechas.",
                        type: "success",
                        confirmButtonText: "Aceptar",
                    },
                    function () {
                        $('#calendar').fullCalendar('destroy');
                        crear_calendario();
                        colaboradoresTurno();

                    });
                   } else {
                    swal({
                        title: "Colaborador ya fue programado el en la fecha "+$('#fecha').val(),
                        text: "",
                        type: "warning",
                        confirmButtonText: "Aceptar",
                    },
                    function () {
                        

                    });
                   } */
                }
            });
        }
    });


$(document).on('click', '#btn_copiarBloque', function() 
{
   var fecha2 = $('#fecha').val();

      $("#SlFechaCopiar option").each(function(){

       
            
            var fecha1 = $(this).attr('value');
          
            $.ajax({
                type: "POST",
                url: "copiarProgramacion.php",
                data: {fecha: fecha2, nuevafecha: fecha1, turno: $('#selectTurno').val(), nuevoTurno: $('#SlTurnoCopiar').val(), salon: $('#selectSalon').val()},
                success: function (res) 
                {
      
                    if (res) 
                    {
                        swal("Copia ejecutada", "", "success");
                        $('#calendar').fullCalendar('destroy');
                        crear_calendario();
                        colaboradoresTurno();

                        if(res.trim()!=''){
                            $('#TaLogCopiar').val($('#TaLogCopiar').val() + "Errores de pegado " + fecha1 + " : El(los) siguiente(s) colaborador(es) tiene(n) asignada otra programación, para esta fecha:" + " \n" + res);
                         }
                    }
                  

                }
            });
        





  });
 


});



$(document).on('blur', '#InFechaCopiar', function() 
{
    var FechaCopiar = $('#InFechaCopiar').val();

    $('#SlFechaCopiar').append('<option id="ki" value="'+FechaCopiar+'">'+FechaCopiar+'</option>');

});

$(document).on('dblclick', '#ki', function(event) {
     $(this).remove();
});


$('#formularioCopiarProgramacionBloque').on("submit", function(event) 
{
    event.preventDefault();
    
    
});

</script>
<!-- INICIALIZAR CALENDARIO -->
<script type="text/javascript">
    var trn ="";
function crear_calendario () 
{
    var p = "salon";
    if (p == "salon")
    {
        var a = $("#selectSalon").val();
    }

    if (p== "clb") 
    {
        var a = $("#cola").val();
    }

    $('#calendar').fullCalendar({
        eventClick: function(calEvent, jsEvent, view) {

            trn = calEvent.id;
            var fecha = new Date(calEvent.start);
            y = fecha.getFullYear();
            m = fecha.getMonth();
            m++;
            d = fecha.getDate();
            var fecha_turno = y+"-"+m+"-"+d;
            //gotoDate: new Date(2012, 11);
            //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
            //alert('View: ' + view.name);
            $.ajax({
                type: "POST",
                url: "find_col_on_turn_modal.php",
                data: {id_turno: trn, fch: fecha_turno,salon:$("#selectSalon").val()},
                success: function(data) {
                    $('#lista').html(data);
                }
            });

            $('#my_modal').modal('show');
            $('body').removeClass("modal-open");
            $('body').removeAttr("style"); 
            // change the border color just for fun
            $(this).css('border-color', 'red');
        },
        eventRender: function(event, element){
                $(element).tooltip({title: event.title, container: "body"});
        },
        dayClick: function(date, jsEvent, view) {

             window.open("../beauty-pdv/php/programacion_pdv/generarReporteTurnos.php?salon="+$("#selectSalon").val()+"&fecha="+date.format()+"  ");

            //$("#programacion").attr("hidden", false);
            //$("#nueva_programacion").attr("hidden", true);

            var fecha = date.format();
            var codigo = $('#selectSalon').val();
            var salon = $('#selectSalon option[value='+codigo+']').html();
            $.ajax({
                type: "POST",
                url: "listar_programacion.php",
                data: {fecha: fecha, salon: salon, codigo: codigo},
                success: function (res) {
                    //$('#prg_dia').html(res);
                }
            });
        },
        dayRender: function(event, cell, date) {
                          
            cell.prepend("<i class='fa fa-print' title='Imprimir programación'></i>");
                 
        },
        textColor : "#0c0c0c",
        lang: 'es',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: false,
        droppable: false, // this allows things to be dropped onto the calendar
        drop: function() {
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
        },
        events: "find_progra.php?p="+p+"&codigo="+a //carga las programaciones existentes
    });
}
 crear_calendario();
 //$('#panelCalendario').attr('hidden', true);

</script>

<script type="text/javascript">
    $("#multi_puesto").on( 'change', function() {
    if( $(this).is(':checked') ) {
        var trn_mult  = $(this).val();
        var pt_trabaj = $('#selectPuestoTrabajo').val();
        var cod_salon = $('#selectSalon').val();
        console.log(trn_mult + ", " + pt_trabaj);
        // Hacer algo si el checkbox ha sido seleccionado
        $.ajax({
            url: 'cambiar_valor_multi_turnos.php',
            method: 'POST',
            data: {trn_mult:trn_mult, pt_trabaj:pt_trabaj,cod_salon:cod_salon},
            success: function (data) {
                if (data == 1) {

                swal("Este puesto de trabajo ha pasado a múltiple turno");
                }
            }
        });
        //alert("El checkbox con valor " + $(this).val() + " ha sido seleccionado");
    } else {
        // Hacer algo si el checkbox ha sido deseleccionado
        //alert("El checkbox con valor " + $(this).val() + " ha sido deseleccionado");
    }
});



/************** DATATABLE DE FILTROS COLABORDOR **************/


$(document).on('click', '#btn_filtro_col', function() 
{
    var salon = $('#selectSalon option:selected').text();
    $.ajax({
        url: 'php/programacion/listado_colaborador.php',
        method: 'POST',
        data: {salon:salon},
        success: function (data) 
        {
            var array = eval(data);
            $('#tbl_filter_col tbody').empty();
                var cargo = "";
                for(var i in array)
                {                   
                    $('#txt_title').html("COLABORADORES: " +salon);
                    $('#tbl_filter_col').append('<tr><td>'+array[i].cargo+'</td><td>'+array[i].nombre+'</td></td></tr>');
                }
           /* $('#modalFiltrocargo').on('shown.bs.modal', function () {
                
  
            });*/
        }
    });
});


$(document).on('click', '#btn_clean', function() 
{
    $('#InFechaCopiar').val('');
    $("#SlFechaCopiar option").remove();
    $('#SlTurnoCopiar').val('');
    $('#TaLogCopiar').val('');

});

function GetCurrentDisplayedMonth() { 
var date = new Date($('#calendar').fullCalendar('getDate'));
var month_int = date.getMonth();
return month_int+1; 
}

GetCurrentDisplayedMonth();


$(document).ready(function() {
     $(document).on('click', '#btnReporteMes', function() {
        var nomsalon = $('#selectSalon option:selected').text();
        window.open("php/programacion/generarReporteTurnosMes.php?salon="+$("#selectSalon").val()+"&fecha="+$('#fecha').val()+"&nomsalon="+nomsalon+"");        
    });
    
});


$(document).on('click', '#btnVerCargos', function() 
{
    var salon = $('#selectSalon').val();
    var fecha = $('#fecha').val();
    var turno = $('#selectTurno').val();

    $.ajax({
        url: 'conteoCategoriasPgr.php',
        method: 'POST',
        data: {salon:salon, fecha:fecha, turno: turno, opcion: 1},
        success: function (data) 
        {
            $('#listaCat').empty();
            $('#VerCargosPeriles').on('shown.bs.modal', function () {
                $('#listaCat').html(data); 
            })
            
        }
    });
});

$(document).on('click', '#btnVerEstados', function() 
{
    var salon = $('#selectSalon').val();
    var fecha = $('#fecha').val();
    var turno = $('#selectTurno').val();

    $.ajax({
        url: 'conteoCategoriasPgr.php',
        method: 'POST',
        data: {salon:salon, fecha:fecha, turno: turno, opcion: 2},
        success: function (data) 
        {
            var tipo = JSON.parse(data);
            $('#listaEst').empty();
            //console.log(data);
            for(i in tipo.estados)
            {
                cantidad   = tipo.estados[i].cantidad;
                estados    = tipo.estados[i].estado; 
                var state = ""; 
                switch (estados) 
                {
                   case 'LABORA':
                       state = '<li class="list-group-item">'+estados+' <span class="badge badge-info">'+cantidad +'</span></li>';
                       break;

                    case 'DESCANSO':
                       state = '<li class="list-group-item">'+estados+' <span class="badge badge-warning">'+cantidad +'</span></li>';
                       break;

                    case 'INCAPACIDAD':
                       state = '<li class="list-group-item">'+estados+' <span class="badge badge-primary">'+cantidad +'</span></li>';
                       break;

                    case 'CAPACITACION':
                       state = '<li class="list-group-item">'+estados+' <span class="badge badge-danger">'+cantidad +'</span></li>';
                       break;

                     case 'META':
                       state = '<li class="list-group-item">'+estados+' <span class="badge badge-success">'+cantidad +'</span></li>';
                       break;

                     case 'PERMISO':
                       state = '<li class="list-group-item">'+estados+' <span class="badge badge-info">'+cantidad +'</span></li>';
                       break;

                     case 'VACACIONES':
                       state = '<li class="list-group-item">'+estados+' <span class="badge badge-warning">'+cantidad +'</span></li>';
                       break;
                     default:
                       // statements_def
                       break;
               }               
                $('#listaEst').append(state);
            }                                    
            
        }
    });
});


$(document).on('click', '#btnVerPlano', function() 
{
    var codSalon = $('#selectSalon').val();

    $.ajax({
        url: 'cargarPlanoSalon.php',
        method: 'POST',
        data: {codSalon: codSalon},
        success: function (data) 
        {
            var array = eval(data);
            for(var i in array){
                $('#SlnPlano').html("SALÓN "+array[i].nombre);
                $("#imagen_salon").removeAttr("src");        
                $('#imagen_salon').attr("src", "../contenidos/imagenes/salon/"+array[i].imagen);
            }
        }
    });
});

/**************************************************************************/


$(document).on('click', '#btnVista', function() 
{
    window.open("vistaProgramacion.php?slncodigo="+$('#selectSalon').val()+"&fecha="+$("#fecha").val()+"", '_blank');
});


 $(document).ready(function() {
        conteoPermisos ();
    });

</script>
</body>
</html>