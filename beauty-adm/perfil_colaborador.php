<?php 
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include '../cnx_data.php';
function tiempoTranscurridoFechas($fechaInicio,$fechaFin)
{
    $fecha1 = new DateTime($fechaInicio);
    $fecha2 = new DateTime($fechaFin);
    $fecha = $fecha1->diff($fecha2);
    $tiempo = "";
         
    //años
    if($fecha->y > 0)
    {
        $tiempo .= $fecha->y;
             
        if($fecha->y == 1)
            $tiempo .= " año, ";
        else
            $tiempo .= " años. ";
    }
         
    //meses
    if($fecha->m > 0)
    {
        $tiempo .= $fecha->m;
             
        if($fecha->m == 1)
            $tiempo .= " mes.";
        else
            $tiempo .= " meses.";
    }
    return $tiempo;
}

header('Content-Type: text/html; charset=utf-8');
$id_colaborador = $_POST['id_colaborador'];
  $result = $conn->query("SELECT c.cblimagen, c.clbfechaingreso, c.trcdocumento, a.ctcnombre, a.ctccolor, c.clbcodigo, c.`tdicodigo`, tdi.tdinombre, tdi.tdialias, trc.trcdigitoverificacion, trc.trcdireccion, trc.brrcodigo, brr.brrnombre, trc.trctelefonofijo, trc.trctelefonomovil, trc.trcnombres, trc.trcapellidos, trc.trcrazonsocial, car.crgnombre, c.`clbsexo`, c.`crgcodigo`, c.`ctccodigo`, ctc.ctcnombre, c.`clbemail`, c.`clbfechanacimiento`, c.`clbnotificacionemail`, c.`clbnotificacionmovil`, c.clbcodigoswbiometrico FROM `btycolaborador` c INNER JOIN btytercero trc ON c.trcdocumento = trc.trcdocumento INNER JOIN btycargo car ON car.crgcodigo = c.crgcodigo INNER JOIN btycategoria_colaborador ctc ON ctc.ctccodigo = c.ctccodigo INNER JOIN btytipodocumento tdi ON tdi.tdicodigo = c.tdicodigo INNER JOIN btybarrio brr ON trc.brrcodigo = brr.brrcodigo INNER JOIN btycategoria_colaborador a ON c.ctccodigo = a.ctccodigo where c.trcdocumento =".$id_colaborador);
  if ($result->num_rows > 0) {
    while ($row= $result->fetch_assoc()) {

        $codigo_incremental = $row['clbcodigo'];
        $colid              = $row['clbcodigo'];
        $nombre           = utf8_encode($row['trcrazonsocial']);
        $fecha_nacimiento = $row['clbfechanacimiento'];
        $fecha_na            = $row['clbfechanacimiento'];
        $documento        = $row['trcdocumento'];
        $tdi_alis         = $row['tdialias'].": ";
        $ruta_img         = "../contenidos/imagenes/colaborador/".$_SESSION['Db']."/".$row['cblimagen'];
        $fecha_ingreso    = $row['clbfechaingreso'];
        $cargo            = $row['crgnombre'];
        $codigo_colaborador = $row['clbcodigo'];
        $codbiometrico    = $row['clbcodigoswbiometrico'];
        $email = $row['clbemail'];
        $fijo = $row['trctelefonofijo'];
        $movil = $row['trctelefonomovil'];
        $direccion = $row['trcdireccion'];
        $rut = "../contenidos/documentos/rut/".$_SESSION['Db']."/".$documento.".pdf";
        $exists = is_file($rut);
        if ($exists == true) {    
            $file = "<a title='Ver RUT del colaborador' target='_blank' href='".$rut."'><i class='fa fa-file-text-o'></i></a>";
        } else {
            $file = "";
        }
        if ($row['clbnotificacionemail'] == "S") {
            $noti_email = '<i class="btn btn-lg pe-7s-mail text-info" title="Activas"></i>';
        } else {
            $noti_email = '<i class="btn btn-lg pe-7s-mail" title="Inactivadas"></i>';
        }
        if ($row['clbnotificacionmovil'] == "S") {
            $noti_movil = '<i class="btn btn-lg pe-7s-phone text-info" title="Activas"></i>';
        } else {
            $noti_movil = '<i class="btn btn-lg pe-7s-phone" title="Inactivadas"></i>';
        }
        if ($row['clbsexo'] == "M") {
            $sexo = "Masculino";
        } else {
            $sexo = "Femenino";
        }
        

        if ($row['ctccodigo']== 0){
             $categoria = "N/A";
             $hpanel = "";
         } else {
             $color = $row['ctccolor'];
             $categoria = '<span class="label pull-right" style="background: #'.$row['ctccolor'].'">'.$row['ctcnombre'].'</span>';
         }
    }
  }
    $fecha_nacimiento = str_replace("/","-",$fecha_nacimiento);
    $fecha_nacimiento = date('Y/m/d',strtotime($fecha_nacimiento));
    $hoy = date('Y/m/d');
    $edad = $hoy - $fecha_nacimiento;
    $today = date("Y-m-d");
    $tiempo = tiempoTranscurridoFechas($fecha_ingreso, $today);
  ?>
<div class="row">
    <div class="col-lg-4">
        <div class="hpanel hgreen">
            <div class="panel-body">
                <div class="pull-right text-right">
                    <div class="btn-group">
                        <?php echo $categoria ?>
                      
<!--                         <i class="fa fa-facebook btn btn-default btn-xs"></i>
                        <i class="fa fa-twitter btn btn-default btn-xs"></i>
                        <i class="fa fa-linkedin btn btn-default btn-xs"></i> -->
                    </div>
                </div>
                <img alt="logo" class="img-thumbnail m-b" width="100" onerror="this.src='../contenidos/imagenes/default.jpg';" src="<?php echo $ruta_img ?>">
                <h3><a href=""><?php echo $nombre; ?></a></h3>
                <div class="text-muted font-bold m-b-xs"><?php echo "Cargo: ".$cargo ?></div>
            
                <p>
                    <strong><?php echo $tdi_alis ?></strong><?php echo $documento." ".$file; ?><br>
                    <strong>Edad: </strong><?php echo $edad ?> años<br>
                    <strong>Genero: </strong><?php echo $sexo ?> <br>
                    <strong>Código: </strong><?php echo $codigo_incremental ?><br>
                    <strong>Cód Biométrico: </strong><?php echo $codbiometrico ?><br>
                    <strong>Email: </strong><?php echo $email ?><br>
                    <strong>Telefonos: </strong><?php echo $fijo."  ".$movil ?><br>
                    <strong>Direccion: </strong><?php echo $direccion ?><br> 

               
                </p>
                <div class="pull-left">  <?php echo $noti_email; echo $noti_movil; ?></div>
               <?php echo '<p><button class="btn btn-default pull-right" type="button" onclick="editar('.$documento.');"><i class="pe-7s-note text-info"></i></button></p>'; ?>
            </div>
            <input type="hidden" id="txtDocumento" value="<?php echo $documento ?>">

            <div class="panel-footer contact-footer">
                <div class="row">
                    <div class="col-md-4 border-right">
                        <div class="contact-stat"><span>F. nacimiento</span> <strong><?php echo $fecha_na ?></strong></div>
                    </div>
                    <div class="col-md-4 border-right">
                        <div class="contact-stat"><span>F. ingreso</span> <strong><?php echo $fecha_ingreso ?></strong></div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-stat"><span>Antiguedad: </span> <strong><?php echo $tiempo ?></strong></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-lg-8">
        <div class="hpanel">
            <div class="hpanel">

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1">Programaci&oacute;n</a></li>
                <li class=""><a data-toggle="tab" href="#tab-2">Servicios autorizados</a></li>
                <li class=""><a data-toggle="tab" href="#tab-3">Salón base</a></li>
                <li class=""><a data-toggle="tab" href="#tab-4">Estado</a></li>
                <li class=""><a data-toggle="tab" href="#tab-5">Documentos</a></li>
            </ul>

            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                         <input type="hidden" id="mes_pgr" value="">
                         <script>
                             var mes = $('#mes_pgr').val();
                         </script>
                        <div id="calendar"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- <span class="label" style="background-color: #24e237">LABORA</span>
                                <span class="label" style="background-color: #f7ec18">DESCANSO</span>
                                <span class="label" style="background-color: #e53fff">PERMISO</span>
                                <span class="label" style="background-color: #6ad1f7">CAPACITACION</span>
                                <span class="label" style="background-color: #fc7d0f">META</span>
                                <span class="label" style="background-color: #cccace">INCAPACIDAD</span> -->
                                
                               
                                 <?php 
                        if ($email == "") {
                            $ParameroEmail = 0;
                        } else {
                            $ParameroEmail = $email;
                        }

                        $f = mysqli_query($conn, "SELECT b.trcrazonsocial FROM btycolaborador a JOIN btytercero b ON a.trcdocumento=b.trcdocumento WHERE a.clbcodigo= $codigo_colaborador");
                        $h = mysqli_fetch_array($f);

                        echo '<a class="pull-right"  title="Enviar al email" onclick="EnviarProgramacion(\''.$ParameroEmail.'\', '.$codigo_colaborador.');enpro('.$codigo_colaborador.')"><button class="btn btn-default pull-right"><i class="fa fa-mail-forward text-info"></i> <i class="pe-7s-mail text-info"></i></button></a>
                        <a class="pull-right" type="button" id="btn_prg" href="consultaProgramacionImg.php?codigo='.$codigo_colaborador.'&nombre='.$h[0].'" target="_blank" title="Exportar a  imagen o PDF"><button class="btn btn-default pull-right"></i> <i class="pe-7s-date text-info"></i></button></a>';
                        ?> 
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div id="tab-2" class="tab-pane">
                    <div class="panel-body no-padding">


                        <div class="chat-discussion" id="sPc" style="height: auto">
                             <?php
                             $codigoColaborador = $codigo_colaborador;
                            //  $sql = "SELECT sc.`secdesde`, s.sernombre, s.serdescripcion, s.serimagen FROM `btyservicio_colaborador` sc INNER JOIN btyservicio s ON sc.sercodigo = s.sercodigo WHERE sc.clbcodigo = ".$codigo_colaborador;
                            //  $result = $conn->query($sql);
                            //  if ($result->num_rows > 0) {
                            //       while ($row = $result->fetch_assoc()) {
                            //           echo '<div class="chat-message">
                            //     <img class="message-avatar" onerror="this.src=\'imagenes/default.jpg\';" src="imagenes/servicio/'.$row['serimagen'].'">
                            //     <div class="message">
                            //         <a class="message-author" href="#"> '.utf8_encode($row['sernombre']).' </a>
                            //         <span class="message-date">Autorisdo desde '.$row['secdesde'].' </span>
                            //                 <span class="message-content">
                            //                 '.utf8_encode($row['serdescripcion']).'
                            //                 </span>

                            //         <div class="m-t-md">
                                        
                            //         </div>
                            //     </div>
                            // </div>';
                            //       }
                            //   } else {
                            //       echo ' <div class="chat-message">
                            //     <div class="message">
                            //         <a class="message-author" href="#">  </a>
                            //         <span class="message-date"></span>
                            //                 <span class="message-content">
                            //                No tiene servicios asignados actualmente.
                            //                 </span>

                            //         <div class="m-t-md">
                                       
                            //         </div>
                            //     </div>
                            // </div>';
                            //   }
                               include 'serviciosPorColaborador.php';
                             ?>
                            

                        </div>

                    </div>
                </div>
                <div id="tab-3" class="tab-pane">
                    <div class="panel-body">
                    <h5> Historial de salones. <button class="btn btn-default btn-sm" onclick="nuevo_salon_base(<?php echo $codigo_incremental  ?>);"><i class="fa fa-plus-square-o text-info"></i></button>    </h5> 
                        <div class="help-block">

                            <div id="table_bases" class="table-responsive"> 
                                <table class="table table-hover table-bordered table-striped">
                                <thead>
                                    <th>Salón</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                    <th>Observaciones</th>
                                    <th>Eliminar</th>
                                </thead>
                                <tbody>
                                    <?php 
                                    
                                        $sql = "SELECT base.`clbcodigo`, base.`slncodigo`, s.slnnombre, `slcobservaciones`, `slcdesde`, `slchasta`, `slccreacion` FROM `btysalon_base_colaborador` base INNER JOIN btysalon s ON base.slncodigo = s.slncodigo WHERE clbcodigo = $codigo_incremental ORDER BY base.slcdesde desc";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row= $result->fetch_assoc()) {
                                                if ($row['slchasta'] == null) {
                                                    echo "<tr class='success'>";
                                                    $f_fin = "Base actual";
                                                } else {
                                                    echo "<tr>";
                                                    $f_fin = $row['slchasta'];
                                                }
                                                    echo "<td>".$row['slnnombre']."</td>";
                                                    echo "<td>".$row['slcdesde']."</td>";
                                                    echo "<td>".$f_fin."</td>";
                                                    echo "<td>".$row['slcobservaciones']."</td>";
                                                    echo "<td><center><button type='button' id='btn_eliminar_est' class='btn btn-xs btn-link' data-colab='".$row['clbcodigo']."' data-salon='".$row['slncodigo']."' data-fe_desde='".$row['slcdesde']."'><i class='fa fa-trash text-info'></i></button></center></td>";
                                                echo "</tr>";

                                            }
                                        } else {
                                            echo "<tr>
                                                    <td colspan='5' style='border-width:1px 1px 0'><center>No tiene salón base asignado actualmente.</center></td>
                                                </tr>";
                                        }
                                    ?>
                                </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div id="tab-4" class="tab-pane">
                    <div class="panel-body">
                    <h5> Histórico Estado. <button class="btn btn-default btn-sm" id="btn_add_new_col" data-id="<?php echo $codigo_incremental;?>" data-toggle="modal" data-target="#modal_add_new_est_col"><i class="fa fa-plus-square-o text-info"></i></button> </h5> 
                        <div class="help-block">
                                <input type="hidden" id="codigo_del_col">
                            <div id="table_estados_col" class="table-responsive"> 
                                <table class="table table-hover table-bordered table-striped">
                                <thead>
                                    <th style="display: none"></th>
                                    <th>Tipo</th>
                                    <th>Fecha</th>
                                    <th>Observaciones</th>
                                    <th>Opciones</th>
                                </thead>
                                <tbody>
                                    <?php 
                                       
                                        $sql = "SELECT c.clecodigo, c.clbcodigo, b.trcrazonsocial, c.clefecha, c.cleobservaciones, c.cletipo, c.cleestado FROM  btycolaborador a JOIN btytercero b ON a.trcdocumento=b.trcdocumento JOIN btyestado_colaborador c ON a.clbcodigo=c.clbcodigo WHERE c.cleestado='1' and c.clbcodigo = $codigo_incremental ORDER BY c.clefecha DESC";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                      
                                            while ($row= $result->fetch_assoc()) {
                                                    echo "<td id='txt_codigo' style='display:none'>".$row['clecodigo']."</td>";
                                                    echo "<td>".$row['cletipo']."</td>";
                                                    echo "<td>".$row['clefecha']."</td>";
                                                    echo "<td>".$row['cleobservaciones']."</td>";
                                                    if($row['cletipo']=='VINCULADO'){
                                                        echo "<td><center>
                                                        <button type='button' data-clecod=".$row['clecodigo']." id='detvincu' title='Ver/Editar detalles de vinculacion' class='btn btn-xs text-info'><i class='fa fa-eye'></i></button>
                                                        <button type='button' data-id=".$row['clbcodigo']." data-cod=".$row['clecodigo']." data-fecha=".$row['clefecha']."  id='btn_edit_col' class='btn btn-xs text-info' data-toggle='modal' data-target='#modalEditarEstColab'><i class='fa fa-edit'></i></button> 
                                                        <button type='button' data-id=".$row['clbcodigo']." data-fecha=".$row['clefecha']." id='btn_elim_col' title='Eliminar estado' class='btn btn-xs text-info'><i class='fa fa-times'></i></button></center></td>";
                                                    }else{
                                                        echo "<td><center><button type='button' data-id=".$row['clbcodigo']." data-cod=".$row['clecodigo']." data-fecha=".$row['clefecha']."  id='btn_edit_col' class='btn btn-xs text-info' data-toggle='modal' data-target='#modalEditarEstColab'><i class='fa fa-edit'></i></button> <button type='button' data-id=".$row['clbcodigo']." data-fecha=".$row['clefecha']." id='btn_elim_col' title='Eliminar estado' class='btn btn-xs text-info'><i class='fa fa-times'></i></button></center></td>";
                                                    }
                                                echo "</tr>";
                
                                            }
                                        } else {
                                            echo "<tr>
                                                    <td colspan='5'><center>No tiene estado actualmente.</center></td>
                                                </tr>";
                                        }
                                    ?>
                                </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div id="tab-5" class="tab-pane">
                    <div class="panel-body">
                        <h5> Adjuntar Documentos. <button type="button" class="btn btn-default btn-sm" id="btn_newdoc" data-id="<?php echo $codigo_incremental;?>" data-toggle="modal" data-target="#modal_newdoc"><i class="fa fa-plus-square-o text-info"></i></button></h5> 
                        <div class="help-block" id="divtbadjuntos">
                           
                        </div>
                        
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
$('[data-toggle="tooltip"]').tooltip(); 
    var codigo_colaborador = $('#txtDocumento').val();
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
            $(this).css('border-color', '#999');
        },
        lang: 'es',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: false,
        droppable: false, // this allows things to be dropped onto the calendar
         eventRender: function(event, element){           
                $(element).tooltip({title: event.salon + " - " + event.turno, container: "body"});                                                                                             
        },
        drop: function() {
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
        },
        events: "find_progra.php?p=clb&codigo="+codigo_colaborador //carga las programaciones existentes
    });

        var moment = $('#calendar').fullCalendar('getDate');
        var mes = moment.format('M');
    

    $(document).on('click', '#btn_edit_est_col', function() {
        var id = $(this).data("id");
        $.ajax({
            url:'edit_estado_colaborador_historico.php',
            method: 'POST',
            data: {id: id},
            success: function (data) {
                var array = eval(data);
                console.log(array);
                for (var i in array){
                    $('#fecha_col_esta').val(array[i].fec);
                }
            }
        });
    });


    $(document).on('click', '#btn_eliminar_est', function() {
            var cod_col   = $(this).data("colab");
            var cod_sln   = $(this).data("salon");
            var cod_desde = $(this).data("fe_desde");
            
            $.ajax({
                url: 'eliminar_salon_base_col.php',
                method: 'POST',
                data: {cod_col: cod_col, cod_sln: cod_sln, cod_desde: cod_desde},
                success: function (data) {
                    if (data == 1) {
                        swal("Salón eliminado del colaborador","", "success");
                        listar(cod_col);
                        //location.reload(); 
                    }
                }
            });
    });


        /**************************************************************/
        var dropzone = document.getElementById('area');
        var  fileInput = document.getElementById("files");
        var  body = document.getElementById("body");

        dropzone.ondragover = function(e){e.preventDefault(); 
          dropzone.classList.add('dragging');
          $("#msj1").html('Suelte el archivo aquí!<br>.');
          $("#msj2").hide();
         }
        dropzone.ondrop = function(e){ onDragOver(e); } 

        function onDragOver(e) {
            fileInput.files = e.dataTransfer.files;
        } 
        dropzone.addEventListener('dragleave', () => {
          dropzone.classList.remove('dragging');
          $("#msj1").html('Arrastre archivo PDF aquí');
          $("#msj2").show();
        });  
        /***************************************************************/
        var dropzone2 = document.getElementById('area2');
        var  fileInput2 = document.getElementById("files2");
        var  body = document.getElementById("body");

        dropzone2.ondragover = function(e){e.preventDefault(); 
          dropzone2.classList.add('dragging2');
          $("#msj12").html('Suelte el archivo aquí!<br>.');
          $("#msj22").hide();
         }
        dropzone2.ondrop = function(e){ onDragOver(e); } 

        function onDragOver(e) {
            fileInput2.files = e.dataTransfer.files;
        } 
        dropzone2.addEventListener('dragleave', () => {
          dropzone2.classList.remove('dragging2');
          $("#msj12").html('Arrastre archivo PDF aquí');
          $("#msj22").show();
        });  
        /***************************************************************/
        $("#files").change(function(e){
            var ext = $("#files").val();
            var aux = ext.split('.');
            $("#nomarchivo").text(this.files[0].name);
            if(aux[aux .length-1] == 'pdf') {

               $("#area").hide();
               $("#iconoPDF").show();

            }else{
                swal("ERROR","Tipo de archivo NO admitido","error");
                $("#area").removeClass('dragging');
                $("#formul")[0].reset();
                $("#msj1").html('Arrastre archivo PDF aquí');
                $("#msj2").show();
            }
            
        });
        $("#files2").change(function(e){
            var ext = $("#files2").val();
            var aux = ext.split('.');
            $("#nomarchivo2").text(this.files[0].name);
            if(aux[aux .length-1] == 'pdf') {

               $("#area2").hide();
               $("#iconoPDF2").show();

            }else{
                swal("ERROR","Tipo de archivo NO admitido","error");
                $("#area2").removeClass('dragging');
                $("#formul2")[0].reset();
                $("#msj12").html('Arrastre archivo PDF aquí');
                $("#msj22").show();
            }
            
        });
        /*************************************************************************************************************/ 
        $("#resetform").click(function(e){
            e.preventDefault();
            $("#area").show();
            $("#iconoPDF").hide();
            $("#formul")[0].reset();   
            $(".newtidocform").hide();
            $(".carga").show();
            $("#respuesta").html('');
            $("#area").removeClass('dragging');
          $("#msj1").html('Arrastre archivo CSV aquí');
          $("#msj2").show();
        });
        $("#resetform2").click(function(e){
            e.preventDefault();
            $("#area2").show();
            $("#iconoPDF2").hide();
            $("#formul2")[0].reset();   
            $(".newtidocform").hide();
            $(".carga").show();
            $("#respuest2a").html('');
            $("#area2").removeClass('dragging2');
          $("#msj12").html('Arrastre archivo CSV aquí');
          $("#msj22").show();
        });
        /*************************************************************************************************************/
        $("#formnuca").submit(function(e){
            e.preventDefault();
            var form=$(this).serialize();
            $.ajax({
                url:'operadjuntocol.php',
                type:'POST',
                data:'opc=nuca&'+form,
                success:function(res){
                    cargarselect();
                    $("#formnuca")[0].reset();
                    $("#btnback").click();
                }
            });

        });
        $("#resetnutido").click(function(e){
            $("#btnback").click();
        })
        /*************************************************************************************************************/
        function cargando(){
            if($( '.oculgen' ).is(":visible")){
                      $( '.oculgen' ).hide();
                 }
            $("#respuesta").html('Cargando...');
        } 
        function resultadoOk(){
          $("#respuesta").html('Guardado exitosamente!');
        } 
        function resultadoErroneo(){
          $("#respuesta").html('Ha surgido un error y no se ha podido subir el archivo.');
        } 
        function cargando2(){
            if($( '.oculgen' ).is(":visible")){
                      $( '.oculgen' ).hide();
                 }
            $("#respuesta2").html('Cargando...');
        } 
        function resultadoOk2(){
          $("#respuesta2").html('Actualizado exitosamente!.');
        } 
        function resultadoErroneo2(){
          $("#respuesta2").html('Ha surgido un error y no se ha podido actualizar el archivo.');
        } 
        /*************************************************************************************************************/
        function cargartabla(){
            var id='<?php echo $codigo_colaborador;?>';
            $("#divtbadjuntos").html('');
            $.ajax({
                url:'adjuntocol.php',
                type:'POST',
                dataType:'html',
                data:'id='+id,
                success:function(res){
                    $("#divtbadjuntos").html(res);
                }
            });
        }
        function cargarselect(){
            $("#seltidoc").html('');
            $.ajax({
                url:'operadjuntocol.php',
                type:'POST',
                dataType:'html',
                data:'opc=load',
                success:function(res){
                    $("#seltidoc").html(res);
                }
            });
        }
        /*************************************************************************************************************/
        $(document).ready(function(){
            cargartabla();
            cargarselect();
           $("#subirarchivo").click(function(){
                var bool=false;
                if(($("#seltidoc").val()!=null) && ($("#txtobserv").val()!='')){
                    bool=true;
                }
                if(bool){
                    //$(".oculgen").hide();
                    cargando();
                }
           });
           $("#subirarchivo2").click(function(){
                $("#area2").hide();
                var bool=false;
                if(($("#seltidoc2").val()!=null) && ($("#txtobserv2").val()!='')){
                    bool=true;
                }
                if(bool){
                    //$(".oculgen").hide();
                    cargando2();
                }
           });
        }); 
        /*************************************************************************************************************/
        $("#addti_doc").click(function(e){
            $(".carga").hide();
            $(".newtidocform").fadeIn();
        });

        $("#btnback").click(function(e){
            $(".carga").fadeIn();
            $(".newtidocform").hide();
            $("#resetform").click();
        });
        /*************************************************************************************************************/
        $('#modal_newdoc').on('hidden.bs.modal', function () {
            $("#area").show();
            $("#iconoPDF").hide();
            $("#formul")[0].reset();   
            $(".newtidocform").hide();
            $(".carga").show();
            $("#respuesta").html('');
            $("#divtbadjuntos").html('');
            var id='<?php echo $codigo_colaborador;?>';
            $.ajax({
                url:'adjuntocol.php',
                type:'POST',
                dataType:'html',
                data:'id='+id,
                success:function(res){
                    $("#divtbadjuntos").html(res);
                }
            })
        });
        $('#modal_newdoc2').on('hidden.bs.modal', function () {
            $("#area2").show();
            $("#iconoPDF2").hide();
            $("#formul2")[0].reset();   
            $(".newtidocform").hide();
            $(".carga").show();
            $("#respuesta2").html('');
            $("#divtbadjuntos").html('');
            var id='<?php echo $codigo_colaborador;?>';
            $.ajax({
                url:'adjuntocol.php',
                type:'POST',
                dataType:'html',
                data:'id='+id,
                success:function(res){
                    $("#divtbadjuntos").html(res);
                }
            })
        });
        /*************************************************************************************************************/
</script>
<script>

     $(document).on('click', '#detvincu', function(e) {
        e.preventDefault();
        var clecod=$(this).data('clecod');
        $("#idcle").val(clecod);
        $("#tb_vincactual").html('');
        $.ajax({
            url:'opervinculacion.php',
            type:'POST',
            data:'opc=loadvincu&clecod='+clecod,
            success:function(res){
                $("#tb_vincactual").html(res);
            }
        });
        $("#modal_tipovinculacion").modal('show');
    });

    $(document).ready(function() {
        loadtivin();
        loadvinculador();
    });
</script>

