<?php
    include("../head.php");

    VerificarPrivilegio("HORARIOS", $_SESSION['tipo_u'], $conn);
    RevisarLogin();  
?>
<div class="content animated-panel">
    <!-- Modal nuevo horarios -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_ptr">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="title" class="modal-title">Nuevo horario</h4>
                </div>
                <form id="form_hora" name="form_hora" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-gruop">
                        <label>
                            Día
                        </label>
                        <select class="form-control" id="dia" name="dia" type="text" required>
                            <option value="LUNES">LUNES</option>
                            <option value="MARTES">MARTES</option>
                            <option value="MIERCOLES">MIERCOLES</option>
                            <option value="JUEVES">JUEVES</option>
                            <option value="VIERNES">VIERNES</option>    
                            <option value="SABADO">SABADO</option>
                            <option value="DOMINGO">DOMINGO</option>
                            <option value="FESTIVO">FESTIVO</option>
                            <option value="ESPECIAL">ESPECIAL</option>
                        </select>
                        <div id="Info" class="help-block with-errors"></div>
                        </div>
                        <div class="form-gruop">
                            <label>
                                Hora de apertura 
                            </label>
                            <input class="form-control" id="desde" name="desde" type="text" maxlength="10" required>
                        </div>
                        <div id="horas"> </div>
                         <div class="form-gruop">
                            <label>
                                Hora de cierre 
                            </label>
                            <input class="form-control" id="hasta" name="hasta" type="text" maxlength="10" required>
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
<!-- MODAL CREAR NUEVO HORARIO SALON -->
    <div class="modal fade" tabindex="-1" role="dialog" id="horario_salon">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="title2" class="modal-title">Nuevo horarios para el salon</h4>
                </div>
                <form id="form_hora_salon" name="form_hora_salon" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-gruop">
                        <label>
                            Horario
                        </label>
                        <select class="form-control" id="horario" name="horario" type="text" required>
                        <?php
                        $sql = "SELECT `horcodigo`, `hordia`, `hordesde`, `horhasta`, `horestado` FROM `btyhorario` WHERE horestado = 1  ORDER BY FIELD(hordia,'LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO','FESTIVO')";

                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value=".$row['horcodigo'].">".$row['hordia']." de ".substr($row['hordesde'], 0, -3)." a ".substr($row['horhasta'], 0, -3)."</option>";
                            }
                        }

                        ?>
                        </select>
                        <div id="Info" class="help-block with-errors">Seleccione el horario que desea asignar al Salon</div>
                    </div>
                    <input type="hidden" name="sln" id="sln" value=" ">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Guardar</button>
       
      </div>
         </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- MODAL ACTUALIZAR HORARIO SALON -->
    <div class="modal fade" tabindex="-1" role="dialog" id="uphorario_salon">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="title2" class="modal-title">Cambiar horario para el salon</h4>
                </div>
                <form id="upform_hora_salon" name="upform_hora_salon" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                    <div class="form-gruop">
                        <label></label>
                        <input type="hidden" name="hor_codigo" id="hor_codigo" value="">
                    </div>
                        <div class="form-gruop">
                        <label>
                            Horario
                        </label>
                        <select class="form-control" id="uphorario" name="uphorario" type="text" required>
                        <?php
                        $sql = "SELECT `horcodigo`, `hordia`, `hordesde`, `horhasta`, `horestado` FROM `btyhorario` WHERE horestado = 1";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value=".$row['horcodigo'].">".$row['hordia']." de ".substr($row['hordesde'], 0, -3)." a ".substr($row['horhasta'], 0, -3)."</option>";
                            }
                        }

                        ?>
                        </select>
                        <div id="Info" class="help-block with-errors">Seleccione el horario que desea asignar al Salon</div>
                    </div>
                    <input type="hidden" name="upsln" id="upsln" value=" ">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Guardar</button>
       
      </div>
         </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

 <!-- Modal actualizar horario -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_up">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="title" class="modal-title">Actualizar horario </h4>
                </div>
            <form id="form_update_hora" name="form_update_hora" method="post" enctype="multipart/form-data">
                    <div id="up" class="modal-body">
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
                    M&Oacute;DULO DE HORARIOS
                </div>
                <div class="panel-body">
                    <div>

                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#divHorario" aria-controls="divHorario" role="tab" data-toggle="tab">Horario</a></li>
                        <li role="presentation"><a href="#divHorarioSalon" aria-controls="divHorarioSalon" role="tab" data-toggle="tab">Horario - Salon</a></li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="divHorario">
                            <br>
                            <div class="content small-header">
                                <br>
                                <div class="hpanel">
                                    <div class="panel-body">
                                        <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                        <div class="input-group">
                                                            <input type="text" name="input_buscar" id="input_buscar" class="form-control" value="" placeholder="Buscar por d&iacute;a del horario">
                                                            <div class="input-group-btn">
                                                                
                                                                  <a><button id="btn" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Nuevo horario"><i class="fa fa-plus-square-o text-info"></i></button></a>
                                                             
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
                                <?php include "find_horarios.php"; ?>   
                            </div>
                        </div>
                    </div>  
                    <div role="tabpanel" class="tab-pane fade" id="divHorarioSalon">
                        <br>
                                <div class="hpanel">
                                    <div class="panel-body">
                                        <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                        <div class="input-group">
                                                            <select id="combo_sln" class="form-control">
                                                                <?php
                                                               
                                                                $sql = "SELECT slnnombre, slncodigo FROM btysalon WHERE slnestado = 1";
                                                                $result = $conn->query($sql);
                                                                $sw = 0; 
                                                                if ($result->num_rows > 0) {
                                                                    while ($row = $result->fetch_assoc()) {
                                                                          if ($sw == 0){
                                                                            $salon = $row['slncodigo'];
                                                                            $sw = 1;
                                                                        }
                                                                        echo "<option value=".$row['slncodigo'].">".$row['slnnombre']."</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <div class="input-group-btn">
                                                                
                                                                  <a><button id="btn2" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Asignar horario"><i class="fa fa-plus-square-o text-info"></i></button></a>
                                                                  <a><button id="btn_pdf_horario" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Reporte PDF"><i class="fa fa-file-pdf-o text-info"></i></button></a>
                                                                  <a><button id="btn_horarioExc" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Reporte EXCEL"><i class="fa fa-file-excel-o text-info"></i></button></a>
                                                             
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
                                        <?php include "find_hor_salon.php"; ?>   
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
  $('#side-menu').children(".active").removeClass("active");  
  $("#SALONES").addClass("active");
  $("#HORARIOS").addClass("active");
$('#hasta').datetimepicker({
    format: "HH:mm ",
  });
$('#desde').datetimepicker({
    format: "HH:mm ",
  });
</script>
<script type="text/javascript">


$(document).ready(function() {
    $(document).on('click', '#btn', function() {
        $('#body').removeClass("modal-open").removeAttr('style');
    });

    $(document).on('click', '#btn2', function() {
        $('#body').removeClass("modal-open").removeAttr('style');
    });

    $(document).on('click', '#btn_edit_hor_sln', function() {
        $('#body').removeClass("modal-open").removeAttr('style');
    });

    $(document).on('click', '#btn_edit_salon_', function() {
       
    });

    

    
});



function ok(titulo, text) {
    swal({
        title: titulo,
        text: "",
        type: "success",
        confirmButtonText: "Aceptar"
        },
        function () {
            window.location = "horarios_salon.php";
        });
}
function rep(titulo, text) {
    var a = $('#dia').val();
    swal({
        title: titulo,
        text: text,
        type: "warning",
        confirmButtonText: "Aceptar"
        });
}

function eliminar(id, este) {
    swal({
                        title: "¿Seguro que desea eliminar este horario?",
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
                            url: "delete_turno_horario.php",
                            data: {horario: id, operacion: "deleteturno"}
                                }).done(function (msg) {
                                    $(este).parent().parent().remove();
                                }).fail(function () {
                                    alert("Error enviando los datos. Intente nuevamente");
                                });

                                swal("Eliminado!", "El registro ha sido eliminado.", "success");
                            });

}

function eliminar_hor_salon(id, este, sln) {
    swal({
                        title: "¿Seguro que desea eliminar este horario?",
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
                            url: "delete_turno_horario.php",
                            data: {horario: id, operacion: "deletets",salon:sln}
                                }).done(function (msg) {
                                    $(este).parent().parent().remove();
                                }).fail(function () {
                                    alert("Error enviando los datos. Intente nuevamente");
                                });

                                swal("Eliminado!", "El registro ha sido eliminado.", "success");
                            });

}

function editar(id) {
     $('#body').removeClass("modal-open").removeAttr('style');
    var dataString = "horario_cod="+id;
    $.ajax({
        type: "POST",
        url: "update_horario.php",
        data: dataString,
    }).done(function (html) {
        $('#up').html(html);
         $('#modal_up').modal('show'); 
    }).false(function () {
        alert('Error al cargar modulo');
    });
}
function editar_hor_sln(id) {
    var dataString = "horario_cod="+id;
    $("#hor_codigo").val(id);
    $('#uphorario_salon').modal('show');
    $.ajax({
        type: "POST",
        url: "get_horarios.php",
        data: dataString,
    }).done(function (res) {
        $('#uphorario').html(res);
        $("#uphorario option[value="+ id +"]").attr("selected",true);
    });
}
$('#combo_sln').change(function (){
    var cod = $(this).val();   
    //console.log(cod)     ;
        var dataString = 'sln='+cod;
        $.ajax({
            type: "POST",
            url: "find_hor_salon.php",
            data: dataString,
            success: function(data) {
                $('#contenido1').html(data);
            }
        });
});

function load_horarios_sln () {
    var salon = $('#combo_sln').val();
    var dataString = "sln="+salon
    $("#sln").val(salon);
    $.ajax({
        type: "POST",
        url: "find_hor_salon.php",
        data: dataString,
    }).done(function (html) {
        $("#contenido1").html(html); 
    }).fail(function () {
        alert('Error al cargar modulo');
    });
}
$('#upform_hora_salon').on("submit", function(event) {
    event.preventDefault();
    var old = $('#hor_codigo').val();
    var now = $('#uphorario').val();
    var sln = $('#combo_sln').val();
    if (old == now) {
        $('#uphorario_salon').modal('hide');
    } else {
        $.ajax({
            url: "update_hor_salon.php",
            type: "POST",
            data: {old_horario: old, nuevo: now, salon: sln},
            success: function (res) {
                $('#uphorario_salon').modal('hide');
                if (res == "TRUE") {
                    swal({
                        title: "Horario cambiado correctamente!",
                        text: "",
                        type: "success",
                        confirmButtonText: "Ok"
                    });
                    load_horarios_sln () ;
                }else{
                    swal({
                        title: "Oops!! Algo pasó...",
                        text: "Su solicitud no pudo ser procesada, comuniquese con el administrador del sistema.",
                        type: "warning",
                        confirmButtonText: "Ok"
                    });
                }
            }
        });
    }
});
$('#form_hora_salon').on("submit", function(event) {
    event.preventDefault();
    $("#sln").val($('#combo_sln').val());
    var formData = new FormData(document.getElementById("form_hora_salon"));
    $.ajax({
        url: "insert_hor_salon.php",
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (res) {
           var array = ["LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO", "DOMINGO", "FESTIVO", "ESPECIAL"] 
            if (res == "TRUE"){
                swal("Horario ha sido asignado al salon.","", "success");
                load_horarios_sln () ;
            } else if (array.indexOf(res) >= 0) {
                rep("Ya se establecio un horario para el d\u00EDa "+res, "");
                //alert("Ya se establecio un horario para el");
            }
        }
              
    });
});
$("#form_hora").on("submit", function(event) {
    event.preventDefault();
    if ($('#desde').val() < $('#hasta').val()){
            var formData = new FormData(document.getElementById("form_hora"));
            $.ajax({
                url: "insert_horario.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function(res){

                if (res == "TRUE"){
                    ok ("Horario Guardado correctamente", "");
                } 
                else if (res == "FALSE") {
                    swal({
                          title: 'Este horario ya se encuentra registrado pero desactivado.',
                          text: "¿Desea activarlo nuevamente?",
                          type: 'info',
                          cancelButtonText: 'Cancelar',
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'Activar!'
                        },
                        function() {
                          
                          $.ajax({
                                    url: "activar_horario.php",
                                    type: "POST",
                                    data: {dia: $("#dia").val(), desde: $("#desde").val(), hasta: $("#hasta").val()},
                                    
                                    success: function(res){
                                        window.location = "horarios_salon.php";
                                }
                            });                        
                        });
                }
                else if (res=="FALSE1"){
                    swal({
                      title: 'ERROR.',
                      text: "Ya existe un registro igual! No se puede guardar.",
                      type: 'warning',
                      showCancelButton: false,
                      cancelButtonColor: '#d33'
                    });
                }
            })
    } else {
        $(horas).html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> La hora de apertura debe ser anterior a la hora de cierre</font></div>');
    }
});
$('#hasta').change(function(){
    $(horas).html('');
});
$('#desde').change(function(){
    $(horas).html('');
});
$('#hasta').click(function(){
    $(horas).html('');
});
$('#desde').click(function(){
    $(horas).html('');
});
// $('#name').blur(function(){
//     $('#Info').html('<img src="loader.gif" alt="" />').fadeOut(1000);
//     this.value=this.value.toUpperCase();
//     var username = $(this).val();
//     var dataString = 'nombre='+username;
//     $.ajax({
//         type: "POST",
//         url: "check_puesto.php",
//         data: dataString,
//         success: function(data) {
//             $('#Info').fadeIn(1000).html(data);
//         }
//     });
// });
$('#btn').click(function(){
    $('#modal_ptr').modal('show'); 
});
$('#btn2').click(function(){
    $('#horario_salon').modal('show'); 
});
    $('#input_buscar').keyup(function() {
        var dataString = "name="+$(this).val();
        $.ajax({
            type: "POST",
            url: "find_horarios.php",
            data: dataString,
            success: function(data) {
                $('#contenido').html(data);
            }
        });
    });
    //la funcion pagina en los horarios, pendiente----> horario-salon.
    function paginar(id) {
        var name  = $('#inputbuscar'). val();
        $.ajax({
            type: "POST",
            url: "find_horarios.php",
            data: {nombre: name, page: id}
        }).done(function (a) {
            $('#contenido').html(a);
        }).fail(function () {
            alert('Error al cargar modulo');
        });
    }
    function paginar2(id) {
         var salon = $('#combo_sln').val();
         //console.log(salon);
            $.ajax({
            type: "POST",
            url: "find_hor_salon.php",
            data: {sln: salon, page: id}
        }).done(function (a) {
            $('#contenido1').html(a);
        }).fail(function () {
            alert('Error al cargar modulo');
        });
    }
    $(document).on('click', '#btn_pdf_horario', function() 
    {
        var codigosalon = $('#combo_sln').val();
        var salon       = $('#combo_sln option:selected').text();

        window.open("reporteHorariosSalon.php?opcion=pdf&codsalon="+codigosalon+"&salon="+salon+"");
    });

    $(document).on('click', '#btn_horarioExc', function() 
    {
        var codigosalon = $('#combo_sln').val();
        var salon       = $('#combo_sln option:selected').text();

        window.open("reporteHorariosSalon.php?codsalon="+codigosalon+"&salon="+salon+"");
    });

 $(document).ready(function() {
    
});
</script>
</body>
</html>