<?php
   
    include("../head.php");
    RevisarLogin();
    VerificarPrivilegio("TIPO DE TURNO",$_SESSION['tipo_u'],$conn);

    
    $clase2 = "fade in active";
    $clase = "fade";
    $active2 = "active";
    $active = "";
    if ($_REQUEST['puntero'] == 1) 
    {
       $clase = "fade in active";
       $clase2 = "fade";
       $active = "active";
       $active2 = "";

    }

?>
<div class="content animated-panel">
    <!-- Modal nuevo puesto de trabajo -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_ptr">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Nuevo turno</h4>
                </div>
                <form id="form_hora" name="form_hora" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-gruop">
                            <label>Nombre</label>
                            <input type="text" name="turno_name" id="turno_name" value="" placeholder="Nombre del turno" class="form-control text-uppercase" onchange="this.value = this.value.toUpperCase();" required>
                        </div>
                    </br>
                    <div class="form-gruop">
                        <label>
                            Hora de inicio 
                        </label>
                        <!-- <input class="form-control" id="desde" name="desde" type="time" maxlength="10" required> -->
                        <div class="form-group">
                            <div class="input-group date" >
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </span>
                                <input id="desde" name="desde" data-format="hh:mm:ss" type="text" class="form-control tipo-hora" required />
                            </div>
                        </div>
                    </div>
                    <div id="horas"></div>
                    <div class="form-gruop">
                        <label>
                            Hora de fin 
                        </label>
                        <div class="input-group date">
                        <span class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </span>
                        <input class="form-control tipo-hora" id="hasta" name="hasta" data-format="hh:mm:ss" type="text" required>
                        </div>
                    </div>
                    </br>
                    <div class="row">
                        <div class="form-group col-lg-8">
                            <label>Espacio de almuerzo</label>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="input-sm form-control fecha" id="start" name="start" required />
                                <span class="input-group-addon">a</span>
                                <input type="text" class="input-sm form-control fecha" id="end" name="end" required />
                            </div>    
                        </div>
                        <div class="col-lg-12 help-block" id="infoRangoAlmuerzo">
                            
                        </div>
                    </div>
                    <br>

                    <div class="form-gruop">
                        <label>Color :</label>
                        <input type="color" class="btn-success" id="html5colorpicker" name="color" onchange="clickColor(0, -1, -1, 5)" value="#ffeeee" style="width:50px;">
                        <div class="help-block">Click para seleccionar un color</div>
                        <div id="Info_color" class="help-block with-type-errors"></div>
                    </div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="rest();" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="validar" class="btn btn-success">Guardar</button>
       
      </div>
         </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 <!-- Modal nuevo puesto de trabajo -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_up">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Actualizar turno </h4>
                </div>
                <form id="form_update_hora" name="form_update_hora" method="post" enctype="multipart/form-data">
                    <div id="up" class="modal-body">
                    </div>
      <input type="hidden" name="sln" id="sln" value=" ">
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Guardar</button>
       
      </div>
         </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

 <div class="modal fade" tabindex="-1" role="dialog" id="modal_turno_salon">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="title" class="modal-title">Nuevo turno  </h4>
                </div>
                <form id="form_turno_salon" name="form_turno_salon" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    
                    <div class="form-gruop">
                        <label>Turno</label>
                        <select class="form-control" id="turno" name="turno" required>
                            <?php
                    
                            $sql = "SELECT t.trncodigo, CONCAT(t.trnnombre, ' DE: ', DATE_FORMAT(t.trndesde, '%H:%i'), ' A: ', DATE_FORMAT(t.trnhasta, '%H:%i'), ' ALM: ',DATE_FORMAT(t.trninicioalmuerzo, '%H:%i'), ' - ', DATE_FORMAT(t.trnfinalmuerzo, '%H:%i') ) AS turnos FROM btyturno as t WHERE t.trnestado = 1 ORDER BY t.trnnombre ";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='".$row['trncodigo']."'>".$row['turnos']."</option>";
                            }    
                            ?>
                        </select>
                    </div>
                    <div class="form-gruop">
                        <label>Horario</label>
                        <select class="form-control" id="horario" name="horario">
                            <?php
              
                            $sql = "SELECT * FROM btyhorario WHERE horestado = 1 ORDER BY FIELD(hordia, 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO', 'FESTIVO')";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='".$row['horcodigo']."'>".$row['hordia']." de ".substr($row['hordesde'], 0, -3)." a ".substr($row['horhasta'], 0, -3)."</option>";
                            }    
                            ?>
                        </select>
                        <input type="hidden" name="txthide_salon" id="txthide_salon" >
                    </div>
                </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Agregar</button>
       
      </div>
         </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

 <div class="modal fade" tabindex="-1" role="dialog" id="modal_turno_salon_up">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="titleup" class="modal-title">Actualizar turno</h4>
                </div>
                <form id="form_turno_salon_up" name="form_turno_salon" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    
                    <div class="form-gruop">
                    <input type="hidden" name="txthide_turno" id="txthide_turno">
                    <input type="hidden" name="txthide_horario" id="txthide_horario">
                        <label>Turno</label>
                        <select class="form-control" id="upturno" name="upturno">
                            <?php
                       
                            $sql = "SELECT trncodigo, trnnombre, trndesde, trnhasta, trninicioalmuerzo, trnfinalmuerzo, trncolor, trnestado FROM btyturno WHERE trnestado = 1 ORDER BY trnnombre, trndesde, trnhasta";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='".$row['trncodigo']."'>".$row['trnnombre']." ". $row['trndesde'] ." - ". $row['trnhasta'] ." | ALM ". $row['trninicioalmuerzo'] ." - ". $row['trnfinalmuerzo'] ."</option>";
                            }    
                            ?>
                        </select>
                    </div>
                    <div class="form-gruop">
                        <label>Horario</label>
                        <select class="form-control" id="uphorario" name="uphorario">
                            <?php
                          
                            $sql = "SELECT * FROM `btyhorario` WHERE horestado = 1 ORDER BY FIELD(hordia, 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO', 'FESTIVO')";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='".$row['horcodigo']."'>".$row['hordia']." de ".substr($row['hordesde'], 0, -3)." a ".substr($row['horhasta'], 0, -3)."</option>";
                            }    
                            ?>
                        </select>
                        <input type="hidden" name="uptxthide_salon" id="uptxthide_salon" >
                    </div>
                </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Guardar</button>       
      </div>
         </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="">
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        <a class="closebox"><i class="fa fa-times"></i></a>
                    </div>
                    TIPO TURNOS
                </div>
                <div class="panel-body">
                    <div>

                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="<?php echo $active2 ?>"><a href="#divHorario" aria-controls="divHorario" role="tab" data-toggle="tab">Tipo de turno</a></li>
                        <li role="presentation" class="<?php echo $active ?>" ><a href="#divHorarioSalon" aria-controls="divHorarioSalon" role="tab" data-toggle="tab">Salones</a></li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane <?php echo $clase2 ?>" id="divHorario">
                            <br>
                            <div class="content small-header">
                                <br>
                                <div class="hpanel">
                                    <div class="panel-body">
                                          <div class="col-md-9">
                                             <div class="row">
                                                <div class="col-lg-12">
                                                      <div class="input-group">
                                                         <input type="text" name="input_buscar" id="input_buscar" class="form-control" value="" placeholder="Buscar por nombre del turno">
                                                         <div class="input-group-btn">
                                                             
                                                               <a><button id="btn" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Nuevo turno"><i class="fa fa-plus-square-o text-info"></i></button></a>
                                                          
                                                         </div>
                                                         <div class="input-group">
                                                         </div>
                                                      </div>
                                                </div>
                                             </div>
                                          </div>
                                    </div>          
                                 </div> 
                            <div id="contenido" class="content animated-panel">
                                <?php include "find_turno.php"; ?>   
                            </div>
                        </div>
                    </div>  
                    <div role="tabpanel" class="tab-pane <?php echo $clase ?>" id="divHorarioSalon">
                        <br>
                                <div class="hpanel">
                                    <div class="panel-body">
                                        <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                        <div class="input-group">
                                                            <select class="form-control" type="text" id="salon" name="salon"> 
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
                                                            <div class="input-group-btn">
                                                                <a><button id="btn2" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Asignar horario"><i class="fa fa-plus-square-o text-info"></i></button></a>
                                                                <a><button id="btn_pdf_turno" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Reporte PDF"><i class="fa fa-file-pdf-o text-info"></i></button></a>
                                                                <a><button id="btn_pdf_turnoExc" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Reporte EXCEL"><i class="fa fa-file-excel-o text-info"></i></button></a>
                                                            </div>
                                                            <div class="input-group">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>        
                                    </div>
                                <div id="contenido1" class="content animated-panel">
                                    <?php include "find_turno_salon.php"; ?>   
                                </div>
                        </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                  

<!-- Vendor scripts -->
<?php include "../librerias_js.php"; ?>
<script>
  $("side-menu").children(".active").removeClass("active");  
  $("#SALONES").addClass("active");
  $("#TIPO_TURNO").addClass("active");

  $('#desde').datetimepicker({
    format: "HH:mm ",
  });

  $('#hasta').datetimepicker({
    format: "HH:mm ",
  });

  $('.fecha').datetimepicker({
    format: "HH:mm ",
  });

 $(document).ready(function() {
       $('#body').removeClass("modal-open").removeAttr('style');
   });  
</script>




<script type="text/javascript">
    $('.modal').modal({backdrop: "static", keyboard: false, show: false});

    function rest () 
    {
       $("#horas").html('');
       $('#form_hora')[0].reset();   

    }

    function paginar(id) 
    {
        $.ajax({
            type: "POST",
            url: "find_turno.php",
            data: {operacion: 'update', page: id}
        }).done(function (a) {
            $('#contenido').html(a);
        }).false(function () {
            alert('Error al cargar modulo');
        });
    }

    function paginar_turnoSalon (id) 
    {
        var salon = $('#salon').val();
            $.ajax({
            type: "POST",
            url: "find_turno_salon.php",
            data: {sln_cod: salon, page: id}
        }).done(function (a) {
            $('#contenido1').html(a);
        }).fail(function () {
            alert('Error al cargar modulo');
        });
    }

    function confirmacion (url) 
    {
        swal({
            title: "Turno Guardado correctamente.",
            text: "",
            type: "success",
            confirmButtonText: "Aceptar"
            },
            function () {
                var cod = $('#salon').val();        
                var dataString = 'sln_cod='+cod;
                $.ajax({
                    type: "POST",
                    url: "find_turno_salon.php",
                    data: dataString,
                    success: function(data) {
                        $('#contenido1').html(data);
                    }
                });
            });
    }

    function ok(url) 
    {
        swal({
            title: "Turno Guardado correctamente.",
            text: "",
            type: "success",
            confirmButtonText: "Aceptar"
            },
            function () {
                window.location = "tipo_turno.php"+url;
            });
    }

    function rep() 
    {
        var a = $('#salon option:selected').html();
        swal({
            title: "Ya fue creado un turno igual en "+a,
            text: "Por favor intente con un turno diferente",
            type: "warning",
            confirmButtonText: "Aceptar"
            });
    }

    function editar(id) 
    {
        var dataString = "codigo="+id; 
        $.ajax({
            type: "POST",
            url: "update_turno.php",
            data: dataString,
        }).done(function (html) {
                $('#up').html(html);
                $('#modal_up').modal('show'); 
        }).false(function () {
            alert('Error al cargar modulo');
        });
    }

    function editar2(turno, horario, salon) 
    {
        $('#upturno').val(turno);
        $('#txthide_turno').val(turno);
        $('#uphorario').val(horario);
        $('#txthide_horario').val(horario);
        $('#uptxthide_salon').val(salon);
        $('#titleup').html("Actualizar turno-salon "+$('#salon option:selected').html());

       var dataString = "salon="+salon;
        $.ajax({
            type: "POST",
            url: "find_hor.php",
            data: dataString,
            success: function (data) {
                $('#uphorario').html(data);
            }
        });
        $('#modal_turno_salon_up').modal("show");
    }

    function eliminar(id, este) 
    {
        swal({
            title: "¿Seguro que desea eliminar este turno?",
            text: "",
            type: "warning",
            showCancelButton:  true,
            cancelButtonText:"No",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí"
                            
        },
            function () 
            {
                $.ajax({
                type: "POST",
                url: "delete_turno.php",
                data: {turno: id, operacion: "delete"}
                }).done(function (msg) {
                    $(este).parent().parent().remove();
                }).fail(function () {
                    alert("Error enviando los datos. Intente nuevamente");
                });

                    swal("Eliminado!", "success");
                });
    }


    function eliminar2(id, este1, hor, sln) 
    {
        swal({
            title: "¿Seguro que desea eliminar este horario?",
            text: "ALERTA! Toda programación asociada a este turno se borrará de forma permanente",
            type: "warning",
            showCancelButton:  true,
            cancelButtonText:"No",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí"           
        },
        function () 
        {
            $.ajax({
            type: "POST",
            url: "delete_turno.php",
            data: {turno: id, horario: hor, salon:sln}
                }).done(function (res) {
                    $(este1).parent().parent().remove();
                }).fail(function () {
                    alert("Error enviando los datos. Intente nuevamente");
                });
        });
    }

    $('#btn2').click(function() 
    {
            var titulo = "Agregar tipo de turno:  "+ $('#salon option:selected').html();
            $('#title').html(titulo);
            
            $('#txthide_salon').val($('#salon').val());
            var dataString = "salon="+$('#txthide_salon').val();
            $.ajax({
                type: "POST",
                url: "find_hor.php",
                data: dataString,
                success: function (data) 
                {
                    $('#horario').html(data);
                }
            });

            $("#modal_turno_salon").modal("show");
    });


    $('#html5colorpicker').change(function () 
    {
        var dataString = "color="+$(this).val();
        $.ajax({
            type: "POST",
            url: "check_turno.php",
            data: dataString,
        }).done(function (res) 
        {
            if (res == "TRUE") 
            {
                $('#Info_color').html();
            } 
            else 
            {
                $('#Info_color').html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red">Ya fue asignado este color a otro turno, intente con uno diferente.</font></div>');
            }
        });
    });

    $('#form_turno_salon').on("submit", function(event)
    {
        event.preventDefault();
        var formData = new FormData(document.getElementById("form_turno_salon"));
        $.ajax({
            url: "insert_turno_salon.php",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function(res)
        {
            if (res == "TRUE")
            {
                confirmacion ("?puntero=1");
            } 
            else if (res == "FALSE") 
            {
                rep();
            } 
            else if (res == "ACTIVAR") 
            {
                activar();
            }
        });
    });

    $('#form_turno_salon_up').on("submit", function(event)
    {
        event.preventDefault();
        var formData = new FormData(document.getElementById("form_turno_salon_up"));
        $.ajax({
            url: "actualizar_turno_salon.php",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function(res)
        {
            if (res == "TRUE")
            {
                ok ("?puntero=1");
            } 
            else if (res == "FALSE") 
            {
                rep();
            }
        });
    });



    $("#form_hora").on("submit", function(event) 
    {
        event.preventDefault();

        if ($('#desde').val() < $('#hasta').val())
        {
            if ($('#desde').val() < $('#start').val() && $('#start').val() < $('#end').val() && $('#end').val() < $('#hasta').val())
            {
                var formData = new FormData(document.getElementById("form_hora"));

                 $.ajax({
                    url: "check_turno.php",
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                })
                .done(function(res)
                {
                    if (res == "TRUE") 
                    {
                        $.ajax({
                            url: "insert_turno.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false
                        })
                        .done(function(res)
                        {
                            if (res == "TRUE")
                            {
                                ok ("");
                            } 
                            else if (res == "FALSE") 
                            {
                                rep();
                            }
                        });
                    } 
                    else if(res=="FALSE")
                    {
                            $(horas).html('');

                            swal({
                              title: 'Este turno ya se encuentra registrado.',
                              text: "¿Desea activarlo nuevamente?",
                              type: 'info',
                              cancelButtonText: 'Cancelar',
                              cancelButtonColor: '#d33',
                              showCancelButton: true,
                              closeOnCancel: true,
                              confirmButtonColor: '#3085d6',
                              confirmButtonText: 'Activar!'
                            },
                            function() 
                            {
                              
                              $.ajax({
                                        url: "activar_turno.php",
                                        type: "POST",
                                        data: {nombre: $("#turno_name").val(), desde: $("#desde").val(), hasta: $("#hasta").val(), start: $("#start").val(), end: $("#end").val(), color: $("#html5colorpicker").val()},
                                        
                                        success: function(res)
                                        {
                                            window.location = "tipo_turno.php";
                                        }
                                });                            
                            });             
                    }else if(res=="OTHER"){
                        $(horas).html('');
                        swal({
                              title: 'ERROR.',
                              text: "Horario duplicado",
                              type: 'warning',
                              showCancelButton: false,
                              cancelButtonColor: '#d33'
                            });
                    }else if(res=="OTHER2"){
                        $(horas).html('');

                            swal({
                              title: 'Este turno ya se encuentra registrado con otro nombre.',
                              text: "¿Desea continuar?",
                              type: 'info',
                              cancelButtonText: 'No',
                              cancelButtonColor: '#d33',
                              showCancelButton: true,
                              closeOnCancel: true,
                              confirmButtonColor: '#3085d6',
                              confirmButtonText: 'Si'
                            },
                            function() 
                            {
                              
                                      $.ajax({
                                    url: "insert_turno.php",
                                    type: "post",
                                    dataType: "html",
                                    data: formData,
                                    cache: false,
                                    contentType: false,
                                    processData: false
                                })
                                .done(function(res)
                                {
                                    window.location = "tipo_turno.php";
                                });                           
                            });  
                    }
                });
            } 
            else 
            {
                $('#infoRangoAlmuerzo').html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red">Rango no valido</font></div>');    
            } 
        } 
        else 
        {
            $(horas).html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> La hora de inicio debe ser anterior a la hora de fin</font></div>');
        }
    });

    $('#hasta').change(function(){
        $(horas).html('');
    });
    $('#dia').change(function(){
        $(horas).html('');
    });
    $('#desde').change(function(){
        $(horas).html('');
    });
    $('#hasta').click(function(){
        $(horas).html('');
    });
    $('#dia').click(function(){
        $(horas).html('');
    });
    $('#desde').click(function(){
        $(horas).html('');
    });
    $('#start').click(function(){
        $('#infoRangoAlmuerzo').html('');
    });
    $('#end').click(function(){
        $('#infoRangoAlmuerzo').html('');
    });


    $('#btn').click(function()
    {

        var codigo = "codi="+ $('#salon').val();
        $('#sln').val($('#salon').val());
        $.ajax({
            type: "POST",
            url: "find_dia.php",
            data: codigo,
        }).done(function (html) {
            $('#dia').html(html); 
            $('#modal_ptr').modal('show');
        }).false(function () {
            alert('Error al cargar modulo');
        });   

    }); 


    $('#input_buscar').keyup(function() 
    {
        var dataString = "nombre="+$(this).val();
        $.ajax({
            type: "POST",
            url: "find_turno.php",
            data: dataString,
            success: function(data) 
            {
                $("#contenido").html(data);
            }
        });
    });

    $('#salon').change(function()
    {
        var cod = $(this).val();        
        var dataString = 'sln_cod='+cod;
        $.ajax({
            type: "POST",
            url: "find_turno_salon.php",
            data: dataString,
            success: function(data) {
                $('#contenido1').html(data);
            }
        });
    });


$(document).on('click', '#btn_pdf_turno', function() 
{
    var codigosalon = $('#salon').val();
    var salon       = $('#salon option:selected').text();

    window.open("reporteTurnosSalon.php?opcion=pdf&codsalon="+codigosalon+"&salon="+salon+"");
});

$(document).on('click', '#btn_pdf_turnoExc', function() 
{
    var codigosalon = $('#salon').val();
    var salon       = $('#salon option:selected').text();

    window.open("reporteTurnosSalon.php?codsalon="+codigosalon+"&salon="+salon+"");
});

 $(document).ready(function() {
       // conteoPermisos ();
    });

</script>
</body>
</html>