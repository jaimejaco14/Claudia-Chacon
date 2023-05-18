<?php
include '../cnx_data.php';
    $sql = "SELECT usucodigo FROM btyusuario u INNER JOIN btyprivilegioperfil p ON u.tiucodigo = p.tiucodigo AND p.pricodigo = 15 WHERE u.trcdocumento = ".$_SESSION['documento'];
    $result =$conn->query($sql);
    $sw = $result->num_rows;
    if ($sw != 0) {
       // Aceptado
    } else {
        echo "string";
        header("Location: index.php"); 
    }
include 'head.php';
$today = date("Y-m-d");
?>
<div class="content animated-panel">

    <div class="modal fade" tabindex="-1" role="dialog" id="my_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Colaboradores en el turno</h4>
      </div>
        
      <div class="modal-body">
      <div id="lista"></div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success">Guardar</button>
       
      </div>
        
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

<div class="hpanel">
        <div class="">
            <a class="small-header-action" href="">
                <div class="clip-header">
                    <i class="fa fa-arrow-up"></i>
                </div>
            </a>

            
           
        <div class="row">
            <div class="col-md-5">
                <div class="content animated-panel">
                    <div class="row">
                        <div class="hpanel">
                            <div class="panel-heading">
                                <div class="panel-tools">
                                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                                </div>
                                PROGRAMACI&Oacute;N
                            </div>
                            <div class="panel-body">
                            <form id="form_proga" name="form_proga" >
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="hidden" value="salon" id="p">
                                            <label class="control-label">Sal&oacute;n</label>
                                            <div class="input-group">
                                            <select class="form-control" id="salon" name="salon">
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
                                            </select><div class="input-group-btn">
                                    
                                      <a><button id="nuevo" type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Nueva programaci&oacute;n"><i class="fa fa-refresh text-info"></i></button></a>
                                 
                                </div>
                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-gruop">
                                            <div class="form-group">
                                                <label class="control-label">Fecha</label>
                                                <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $today ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">Turno</label>
                                            <select class="form-control" id="turno" required>
                                                <?php 
                                                $fecha = $today;
                                                $dia = date('l', strtotime($fecha));
                                                echo $dia;
                                                $semana = array(
                                                'Monday'  => 'LUNES' ,
                                                'Tuesday' => 'MARTES',
                                                'Wednesday' => 'MIERCOLES',
                                                'Thursday'  => 'JUEVES',
                                                'Friday' => 'VIERNES',
                                                'Saturday' => 'SABADO',
                                                'Sunday' => 'DOMINGO',
                                                );
                                                $dia = $semana[$dia];
                                                include "select_turno.php"; 
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="cola" hidden>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">Colaborador</label>
                                            <div>
                                            <select id="col" name="col" class="js-example-basic-single form-control" placeholder="Nombre del Colaborador">
                                            </select><!-- <div class="input-group-btn"><button id="agregar" class="btn btn-default"><i class="fa fa-save text-info"></i></button></div> -->
                                            </div>
                                            <div class="help-block">Seleccione colaboradores para agregar a la programacion.</div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="turno" id="t">
                                <input type="hidden" name="sln" id="sln" value="<?php echo $sln; ?>">
                                 <input  type="submit" id="btn" value="Agregar colaboradores" class="btn btn-success" /> 
                                </form>
 
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-md-7">
                <div class="content animate-panel">
                    <div class="row">
                        <div class="hpanel">
                            <div class="panel-heading">
                                <div class="panel-tools">
                                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                               </div>
                                CALENDARIO
                            </div>
                            <div class="panel-body">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                                <div class="col-sm-12" id="list">
                                        <!-- Aqui carga los colaboradores asignados en el turno -->
                                </div>

<!-- Vendor scripts -->
<?php include "librerias_js.php"; ?>

<script>
$('#side-menu').children(".active").removeClass("active");
  $("#COLABORADORES").addClass("active");
  $("#PROGRAMACI").addClass("active");
</script>

<script type="text/javascript">
call();
function ok(dir) {
    $('#t').val($('#turno').val());
    var formData = new FormData(document.getElementById("form_proga"));
    $.ajax({
        url: "insert_proga.php",
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    }).done(function(res){
        if (res == "TRUE"){
            swal({
                title: "Colaborador programado correctamente",
                text: "",
                type: "success",
                confirmButtonText: "Aceptar",
            },
            function () {
                call();
                look_for();
            });
        } else if (res == "FALSE") {
            rep ();
        }
        $("#col option[value='"+($('#col').val())+"']").remove();
    });
}
function rep() {
    var a = $('#turno').val();
    swal({
        title: "Colaborador ya fue Programado en un horario similar a este",
        text: "Por favor intente una Programacion diferente.",
        type: "warning",
        confirmButtonText: "Aceptar"
        });
}

function insert() {
    var a = 0;
    swal({
        title: "¿Desea Agregar Colaborador a la programacion?",
        text: "",
        type: "warning",
        showCancelButton:  true,
        cancelButtonText:"No",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sí"
    },
    function () {
        setTimeout(function(){
            ok(1);
  }, 200);
    });
        
}
//CREAR CALENDARIO
function call () {
    var p = $("#p").val();
    if (p == "salon"){
        var a = $("#salon").val();
    } 
    if (p== "clb") {
        var a = $("#cola").val();
    }
    $('#calendar').fullCalendar({
        eventClick: function(calEvent, jsEvent, view) {
            var trn = calEvent.id;
            var fecha = new Date(calEvent.start);
            y = fecha.getFullYear();
            m = fecha.getMonth();
            m++;
            d = fecha.getDate();
            var fecha_turno = y+"-"+m+"-"+d;
            //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
            //alert('View: ' + view.name);
            $.ajax({
                type: "POST",
                url: "find_col_on_turn.php",
                data: {id_turno: trn, fch: fecha_turno},
                success: function(data) {
                    $('#lista').html(data);
                }
            });
            $('#my_modal').modal('show'); 
            // change the border color just for fun
            $(this).css('border-color', 'red');
        },
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

function editar(sln, id) {
    $.ajax({
        type: "POST",
        url: "update_horario.php",
        data: {salon: sln, dia: id}
    }).done(function (html) {
        $('#up').html(html);
         $('#modal_up').modal('show'); 
    }).false(function () {
        alert('Error al cargar modulo');
    });
}
function eliminar(id, tur, f, este) {
    swal({
            title: "¿Seguro que desea anular esta programacion?",
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
                            data: {col: id, turno: tur, fecha: f}
    }).done(function (msg) {
        $(este).parent().parent().remove();
    }).fail(function () {
        alert("Error enviando los datos. Intente nuevamente");
    });

    swal("Deleted!", "Your imaginary file has been deleted.", "success");
    call();
    });
}
function look_for () {
    $('#t').val($('#turno').val());
    var formData = new FormData(document.getElementById("form_proga"));
            $.ajax({
                url: "list_col_proga.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function(res){
                $('#list').html(res);
            }); 
}
$('#fecha').change(function (){
    var sln = $('#sln').val();
    var fch = $('#fecha').val();
    $.ajax({
        type: "POST",
        url: "select_turno.php",
        data: {sln_cod: sln, fecha: fch},
        success: function(data){
             $('#turno').html(data);
        }

    })
});
$('#nuevo').click(function () {
    $('#turno').attr("disabled", false);
    $('#fecha').attr("readonly", false);
    $('#cola').attr("hidden",true);
    $("#col").select2("val", "");
    $('#list').html("");
});
 $("#form_proga").on("submit", function(event) {
    event.preventDefault();
    $('#turno').attr("disabled", true);
    $('#fecha').attr("readonly", true);
    $('#cola').attr("hidden",false);
    look_for();
});
$('#agregar').click(function (){
   
});
 $('#col').change(function(){
    insert(); 
 });
    $('#salon').change(function(){
        $('#calendar').fullCalendar('destroy');
        call();
        $('#sln').val($(this).val());
        //var cod = $(this).val();        
        //var dataString = 'sln_cod='+cod;
        var sln = $('#sln').val();
        var fch = $('#fecha').val();
        $.ajax({
            type: "POST",
            url: "select_turno.php",
            data: {sln_cod: sln, fecha: fch},
            success: function(data) {
                $('#turno').html(data);
            }
        });
    });
</script>
<script type="text/javascript">
    $(".js-example-basic-single").select2();
    $('#s2id_autogen1_search').keypress(function() {
      var cod = $(this).val();        
        var dataString = 'col_cod='+cod;
        $.ajax({
            type: "POST",
            url: "select_col.php",
            data: dataString,
            success: function(data) {
                $('#col').html("<option disabled selected value=''>--Seleccione un colaborador--</option>");
                $('#col').append(data);
                 //$("#col").select2("val", "");
                // $('#col').children("[selected]").removeAttr('selected');
            }
        });

 });
</script>

</body>
</html>