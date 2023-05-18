<?php
include 'head.php';
include "librerias_js.php"; 
$sql = "SELECT usucodigo FROM btyusuario u INNER JOIN btyprivilegioperfil p ON u.tiucodigo = p.tiucodigo AND p.pricodigo = 4 WHERE u.trcdocumento = ".$_SESSION['documento'];
$result =$conn->query($sql);
$sw = $result->num_rows;
if ($sw != 0) {
       // Aceptado
} else {
    //echo "string";
    header("Location: error_privilegio.php");
}

$today = date("Y-m-d");

if($_GET['operacion']=='update'){
    $docu=$_GET['id_cliente'];
?>
<script>
    $(document).ready(function() {
        var dcmt=parseInt(<?php echo $docu;?>);
        $("#no_documento").val(dcmt);
        $('#Info').html("");

        var user = dcmt;        
        var dataString = 'no_documento='+user;

        $.ajax({
            type: "POST",
            url: "check_user.php",
            data: dataString,
            success: function(data) {
                if (data[0] > 0) {
                    if (data[0] == 1 ) {
                        empresa();
                        $('#razon_social').val(data.split(",")[5]);
                        //$('#razon_social').attr('readonly', true);
                        $('#tipo_nombre1').attr('checked', 'checked');   
                    } 
                    else if (data[0] > 1) {     
                        persona();
                        $('#nombres').val(data.split(",")[3]);
                        //$('#nombres').attr('readonly', true);
                       // $('#apellidos').attr('readonly', true);
                                $('#apellidos').val(data.split(",")[4]); //
                                $('#tipo_documento option[value="'+data.split(",")[0]+'"]').attr('selected', 'selected');
                                //$('#tipo_documento').attr('disabled', true);
                                $("#sexo").val(data.split(",")[10]);
                                //$("#sexo").attr('disabled', true);
                                $("#datetimepicker").val(data.split(",")[13]);
                                //$("#datetimepicker").attr('readonly', true);
                                $("#ocu").val(data.split(",")[20]);
                                //$("#ocu").attr('disabled', true);
                                $("#email").val(data.split(",")[12]);
                                //$("#email").attr('readonly', true);
                                if((data.split(",")[11])=='S'){
                                    $("#extr").prop('checked','true');
                                }
                                //$("#extr").attr('disabled', true);
                                if((data.split(",")[15])=='S'){
                                    $("#notifmovil").prop('checked','true');
                                    //$("#notifmovil").attr('disabled', true);
                                }
                                if((data.split(",")[14])=='S'){
                                    $("#notifmail").prop('checked','true');
                                    //$("#notifmail").attr('disabled', true);
                                }
                                
                            }
                            //$('#tipo_nombre1').attr('disabled', true);
                            //$('#tipo_nombre2').attr('disabled', true);
                            $('#barrio option[value="'+data.split(",")[9]+'"]').attr('selected', 'selected');
                            //$('#barrio').attr('disabled', true);
                            //$('#ciudad').attr('disabled', true);
                            //$('#dep').attr('disabled', true);
                            //$('#direccion').attr('readonly', true);
                            $('#direccion').val(data.split(",")[6]);
                            $('#telefono_movil').val(data.split(",")[8]);
                            $('#telefono_fijo').val(data.split(",")[7]);
                            //$('#telefono_movil').attr('readonly', true);
                            //$('#telefono_fijo').attr('readonly', true);
                            $("#guardar").hide();
                            $("#guarcam").show();
                            $("#cancelar").show();
                            $("#no_documento").attr('readonly', true);
                            //$("#actualizar").show();
                        }                 
                    }
                });
        var dataString = 'user_cod='+user;
        $.ajax({
            type: "POST",
            url: "dv.php",
            data: dataString,
            success: function(data) {
                $('#dv').val(data);
            }
        });

    });
    
</script>
<?php

}


?>
<div id="hbreadcrumb" class="pull-right m-t-lg" style="margin-right: 10%">
  <ol class="hbreadcrumb breadcrumb">

    <li><a href="index.php">Inicio</a></li>
    <li>
      <a href="cliview.php">Clientes</a>
    </li>
    <li class="active">
      <span>Nuevo Cliente</span>
    </li>
  </ol>
</div>
<div class="content animate-panel">

    <div>
        <!-- form here-->
        <div class="row">
            <form id="formulario" role="form" name="form" method="post" onsubmit="return validateform();" action="insert.php" >
                <div class="col-lg-7">
                    <div class="hpanel">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                            </div>
                            TIPO DE CLIENTE
                        </div>
                        <div class="panel-body">
                            <div class="form-group" name='tipo' >
                                <div class="">
                                    <div class="">
                                        <div class="form-group col-lg-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="radio" name="tipo_nombre" id="tipo_nombre2" value="N" aria-label="..." >
                                                </span>
                                                <input type="text" class="form-control selected" readonly="" aria-label="..." value="Persona" style="width: 100px" >
                                            </div><!-- /input-group -->
                                        </div><!-- /.col-lg-6 -->

                                        <div class="form-group col-lg-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="radio" name="tipo_nombre"  id="tipo_nombre1" value="S" aria-label="..." required> 
                                                </span>
                                                <input type="text" class="form-control" readonly="" aria-label="..." value="Empresa" style="width: 100px" >
                                            </div><!-- /input-group -->
                                        </div><!-- /.col-lg-6 -->
                                    </div>
                                </div><!-- /.row -->
                                <br>
                                <div class="col-md-12">
                                <div id="divti" class="form-group col-md-3">
                                    <label>Tipo de Documento</label>
                                    <select style="width: 99px" class="form-control" name="tipo_documento" id="tipo_documento" data-error="Escoja una opcion" required="NIT, CC, TI, CE">
                                        <?php

                                        $result = $conn->query("SELECT tdicodigo, tdialias FROM btytipodocumento where not tdicodigo = 1 ");
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {                
                                                echo '<option value="'.$row['tdicodigo'].'">'.$row['tdialias'].'</option>';
                                            }
                                        }

                                        ?>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div> <!-- TIPO DE DOCUMENTO -->


                                <div class="form-group col-md-9">

                                    <label id="nun">Numero de documento</label>
                                    <div class="input-group">
                                        <input   type="number" class="form-control" name="no_documento" min="0" id="no_documento" placeholder="Numero de documento" data-error="Este campo es obligatorio y solo debe contener numeros" required >

                                        <div class="input-group-btn">
                                           <input  style="width: 70px"  type="text" class="form-control" pattern="[0-9]" maxlength="1" name="dv" id="dv" data-error="Este campo es obligatorio y solo debe contener numeros" readonly required >
                                       </div>
                                   </div>
                                   <div id="Info" class="help-block with-errors"></div>
                               </div>
                               </div>

                               <div class="form-group" id="divnombre" required>
                                <label>Nombres</label>
                                <input  class="form-control text-uppercase"  name="nombres" id="nombres" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,48}" placeholder="Digite sus nombres" data-error="Campo obligatorio" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group" id="divapellido" required>
                                <label>Apellidos</label>
                                <input  class="form-control text-uppercase" name="apellidos"  id="apellidos" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,48}"  data-error="Campo obligatorio" placeholder="digite sus apellidos" required>
                                <div class="help-block with-errors"></div>
                            </div>
                                        <!-- <div class="row">
                                        <div class="form-group col-lg-7" id="divsexo">
                                            <label>Sexo</label>
                                                <select style="width: 200px" class="form-control" name="sexo" id="sexo" data-error="Escoja una opcion" required>
                                                    <option value="M">Hombre</option>
                                                    <option value="F">Mujer</option>
                                                </select>
                                                <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group col-lg-4 " id="extranjero">
                                        <label>Extranjero</label>
                                            <input type="checkbox" name="extr" value="" >
                                        </div>
                                    </div> -->
                                    <div class="col sm12">
                                        <div class="form-group" id="divsexo">
                                            <label class="control-label">Sexo</label>
                                            <div class="input-group col-md-6">
                                                <select class="form-control" name="sexo" id="sexo" data-error="Escoja una opcion" required>
                                                    <option value="M">MASCULINO</option>
                                                    <option value="F">FEMENINO</option>
                                                </select>
                                                <div class="input-group-addon">
                                                    <span><strong>Extranjero</strong></span>
                                                </div>
                                                <div class="input-group-addon">
                                                    <input type="checkbox" name="extr" id="extr" value="S">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="divocu">
                                        <label> Ocupaci&oacute;n </label>
                                        <select style="width: 200px" class="form-control" id="ocu" name="ocupacion" data-error="Escoja una opcion" required="NIT, CC, TI, CE">
                                            <?php

                                            $result = $conn->query("SELECT ocucodigo, ocunombre FROM btyocupacion where ocunombre NOT IN ('N/D')");
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {                
                                                    echo '<option value="'.$row['ocucodigo'].'">'.$row['ocunombre'].'</option>';
                                                }
                                            }

                                            ?>
                                        </select>
                                    </div>                                        
                                    <div class="form-group" id="divrazon" hidden="">
                                        <label>Razon social</label>
                                        <input  class="form-control" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,48}" name="razon_social" id="razon_social" placeholder="Digite su razon social" data-error="Campo obligatorio" >
                                        <div class="help-block with-errors"></div>
                                    </div>                             
                                </div>   

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="hpanel">
                            <div class="panel-heading">
                                <div class="panel-tools">
                                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                                </div>
                                DATOS DE REGISTRO
                            </div>
                            <div class="panel-body">
                                <div class="form-group" id="divfecha">
                                    <label>fecha de nacimiento</label>

                                    <input  type="text" class="form-control fecha" name="fecha" id="datetimepicker" placeholder="AAAA-MM-DD" max="<?php echo $today;?>" format="YYYY-MM-DD" data-error="campo obligatorio" >
                                    <div class="help-block with-errors"></div>
                                    <p class="help-block"></p>
                                            <!-- <script>$(function () {
                                                $('.datepicker').datepicker({
                                                autoclose: true,
                                                keyboardNavigation : true ,
                                                daysOfWeekDisabled : [0]
                                                });
                                                $('#datetimepicker').datetimepicker({
                                                 pickTime: false
                                                });
                                                });
                                            </script> -->
                                        </div>
                                        <div id="location">
                                           <div class="form-group">
                                            <label>Departamento</label>
                                            <select  zize="30" class="form-control" name="dep" id="dep" data-error="Escoja una opcion" required>
                                                <?php

                                                $result = $conn->query("SELECT depcodigo, depombre FROM btydepartamento where depstado = 1 and NOT depcodigo = 0");
                                                if ($result->num_rows > 0) {
                                                    $sw = 0;
                                                    while ($row = $result->fetch_assoc()) {
                                                        if ($sw == 0) {
                                                            $depa = $row['depcodigo'];
                                                            $sw = 1;
                                                        }  
                                                        echo '<option value="'.$row['depcodigo'].'">'.$row['depombre'].'</option>';
                                                    }
                                                }

                                                ?>
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group">
                                            <label> Ciudad </label>
                                            <select  zize="30" class="form-control" name="ciudad" id="ciudad" data-error="Escoja una opcion" required>
                                                <?php

                                                $result = $conn->query("SELECT loccodigo, locnombre FROM btylocalidad where depcodigo = $depa");
                                                if ($result->num_rows > 0) {
                                                    $sw = 0;
                                                    while ($row = $result->fetch_assoc()) { 
                                                        if ($sw == 0) {
                                                            $ciu = $row['loccodigo'];
                                                            $sw = 1;
                                                        }                 
                                                        echo '<option value="'.$row['loccodigo'].'">'.$row['locnombre'].'</option>';
                                                    }
                                                }

                                                ?>
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group">
                                            <label> Barrio </label>
                                            <select zize="30" class="form-control" name="barrio" id="barrio" data-error="Escoja una opcion" required>
                                                <?php

                                                $result = $conn->query("SELECT brrcodigo, brrnombre FROM btybarrio where loccodigo = $ciu");
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) { 
                                                        echo '<option value="'.$row['brrcodigo'].'">'.$row['brrnombre'].'</option>';
                                                    }
                                                }

                                                ?>
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Direccion</label>
                                            <input  class="form-control text-uppercase" name="direccion" id="direccion"  placeholder="Ejemplo: CLL 01 kr 02 - 03" data-error="Campo obligatorio">
                                            <div class="help-block with-errors"></div>
                                        </div> 
                                    </div>                   
                                    <div class="form-group">
                                        <label>Tel&eacute;fono m&oacute;vil</label>
                                        <input  class="form-control" type="number" id="telefono_movil" min="0" name="telefono_movil" placeholder="Ingrese numero de telefono" data-error="camp obligatorio">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Tel&eacute;fono fijo</label>
                                        <input  class="form-control" type="number" id="telefono_fijo" min="0" name="telefono_fijo" placeholder="Ingrese numero de telefono">
                                        <div class="help-block">
                                            Campo opcional
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail" class="control-label">Email</label>
                                        <input  type="email" class="form-control text-uppercase" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$" id="email" placeholder="Email" data-error="Ingrese un direccion de correo valida">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <div class="help-block"> 
                                                    <input type="checkbox" name="notif[]" id="notifmovil" value="movil" aria-label="..." checked="checked" >
                                                    <label>
                                                        Recibir notificaciones al m&oacute;vil
                                                    </label> 
                                                </div>
                                            </div><!-- /input-group -->
                                        </div><!-- /.col-lg-6 -->
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <div class="help-block"> 
                                                    <input type="checkbox" name="notif[]" id="notifmail"  value="email" aria-label="..." checked="checked" > 
                                                    <label>
                                                        Recibir notificaciones al email
                                                    </label> 
                                                </div>
                                            </div><!-- /input-group -->
                                        </div><!-- /.col-lg-6 -->
                                    </div><!-- /.row -->


                                    <button type="submit" id="guardar" name="guardar" class="btn btn-success">
                                        Guardar
                                    </button>
                                    <button style="display:none;" id="actualizar" name="actualizar" class="btn btn-success">
                                        Actualizar datos
                                    </button>
                                    <button style="display:none;" id="guarcam" name="guarcam" class="btn btn-success">
                                        Guardar cambios
                                    </button>
                                    <button style="display:none;" id="cancelar" name="cancelar" class="btn btn-success">
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>

            </div>


            <?php
            include 'footer.php';
            ?> 


        </div>
        <!-- Vendor scripts -->
        
        <script type="text/javascript">
          $("#side-menu").children(".active").removeClass("active");  
          $("#CLIENTES").addClass("active");
          $('.fecha').datetimepicker({
            format: "YYYY-MM-DD",
            locale: "es",
        });
    </script>
    <script>
        function empresa () {
            $("#divnombre").hide();
            $("#divapellido").hide();
            $("#divrazon").show();
            $("#divsexo").hide();
            $("#divocu").hide();
            $("#divti").hide();
            $("#divfecha").hide();
            $("#datetimepicker").required = false;
            $("#nun").html("Nit");
            document.getElementById("sexo").required = false;
            document.getElementById("razon_social").required = true;
            document.getElementById("nombres").required = false;
            document.getElementById("apellidos").required = false;
            document.getElementById("nombres").value="";
            document.getElementById("apellidos").value="";
            document.getElementById("dv").required = true;
            document.getElementById("ocu").required = false;
            $('#razon_social').attr('readonly', false);
            $('#location').attr('hidden', false);
            $('#extr').attr('checked', false);
            $("tipo_nombre2").removeAttr("checked");
            $("tipo_nombre1").attr("checked", "checked");


        }
        function persona () {
            $("#divti").show();
            $("#nun").html("Documento");
            $("#divnombre").show();
            $("#divapellido").show();
            $("#divrazon").hide();
            $("#divsexo").show();
            $("#divocu").show();

            document.getElementById("sexo").required = true;
            document.getElementById("razon_social").required = false;
            document.getElementById("nombres").required = true;
            document.getElementById("apellidos").required = true;
            document.getElementById("razon_social").value="";
            document.getElementById("dv").required = true;
            document.getElementById("ocu").required = true;
            $('#nombres').attr('readonly', false);
            $('#apellidos').attr('readonly', false);
            $('#tipo_nombre1').attr('disabled', false);
            $('#tipo_nombre2').attr('disabled', false);
            $('#barrio').attr('disabled', false);
            $('#ciudad').attr('disabled', false);
            $('#dep').attr('disabled', false);
            $('#telefono_movil').attr('readonly', false);
            $('#telefono_fijo').attr('readonly', false);
            $('#direccion').attr('readonly', false);
            $('#tipo_nombre2').attr('checked', 'checked');
            $("tipo_nombre1").removeAttr("checked");
            $('#tipo_documento').attr('disabled', false);
            $("#email").attr('readonly', false);
            $("#ocu").attr('disabled', false);
            $("#notifmovil").attr('disabled', false);
            $("#notifmail").attr('disabled', false);
            $("#extr").attr('disabled', false);

        }
        $(document).ready(function(){
            $('#extr').click(function(event) {
                if (!$(this).is(':checked')) {
                    $('#location').attr('hidden', false);
                } else {
                    $('#location').attr('hidden', true);
                }
            });
            $("#tipo_nombre1").click(function(){
                empresa();

            });
            $("#tipo_nombre2").click(function(){
                persona();

            });
        });
    </script>

    <script type="text/javascript">

        $(document).ready(function() {  

            $('#no_documento').blur(function(){
                $('#Info').html("");

                var user = $(this).val();        
                var dataString = 'no_documento='+user;

                $.ajax({
                    type: "POST",
                    url: "check_user.php",
                    data: dataString,
                    success: function(data) {
                        if (data[0] > 0) {
                            if (data[0] == 1 ) {
                                
                                $('#razon_social').val(data.split(",")[5]);
                                //$('#razon_social').attr('readonly', true);
                                $('#tipo_nombre1').attr('checked', 'checked');   
                                empresa();
                            } 
                            else if (data[0] > 1) {     
                                
                                $('#nombres').val(data.split(",")[3]);
                                $("#nombres").required = true;
                                //$('#nombres').attr('readonly', true);
                                //$('#apellidos').attr('readonly', true);
                                $('#apellidos').val(data.split(",")[4]); //
                                $('#tipo_documento option[value="'+data.split(",")[0]+'"]').attr('selected', 'selected');
                                //$('#tipo_documento').attr('disabled', true);
                                $("#sexo").val(data.split(",")[10]);
                                //$("#sexo").attr('disabled', true);
                                $("#datetimepicker").val(data.split(",")[13]);
                               // $("#datetimepicker").attr('readonly', true);
                                $("#ocu").val(data.split(",")[20]);
                                //$("#ocu").attr('disabled', true);
                                $("#email").val(data.split(",")[12]);
                                //$("#email").attr('readonly', true);
                                if((data.split(",")[11])=='S'){
                                    $("#extr").prop('checked','true');
                                }
                                $("#extr").attr('disabled', true);
                                if((data.split(",")[15])=='S'){
                                    $("#notifmovil").prop('checked','true');
                                    //$("#notifmovil").attr('disabled', true);
                                }
                                if((data.split(",")[14])=='S'){
                                    $("#notifmail").prop('checked','true');
                                    //$("#notifmail").attr('disabled', true);
                                }
                                persona();
                                
                            }
                            //$('#tipo_nombre1').attr('disabled', true);
                            //$('#tipo_nombre2').attr('disabled', true);
                            $('#barrio option[value="'+data.split(",")[9]+'"]').attr('selected', 'selected');
                            //$('#barrio').attr('disabled', true);
                            //$('#ciudad').attr('disabled', true);
                            //$('#dep').attr('disabled', true);
                            //$('#direccion').attr('readonly', true);
                            $('#direccion').val(data.split(",")[6]);
                            $('#telefono_movil').val(data.split(",")[8]);
                            $('#telefono_fijo').val(data.split(",")[7]);
                            //$('#telefono_movil').attr('readonly', true);
                            //$('#telefono_fijo').attr('readonly', true);
                            $("#guardar").hide();
                            $("#guarcam").show();
                            $("#cancelar").show();
                            $("#no_documento").attr('readonly', true);
                            //$("#actualizar").show();
                        }                 
                    }
                });
                var dataString = 'user_cod='+user;
                $.ajax({
                    type: "POST",
                    url: "dv.php",
                    data: dataString,
                    success: function(data) {
                        $('#dv').val(data);
                    }
                });
            });  
            function ok() {
                swal({
                    title: "Cliente creado correctamente",
                    text: "Ir a vista de los clientes",
                    type: "success",
                    confirmButtonText: "Aceptar"
                },
                function () {
                    window.location = "cliview.php";
                });
            }
            function ok2() {
                swal({
                    title: "Cliente actualizado correctamente",
                    text: "",
                    type: "success",
                    confirmButtonText: "Aceptar"
                },
                function () {
                    window.location = "cliview.php";
                });
            }

            $("#actualizar").click(function(e){
                e.preventDefault();
                persona();
                $("#actualizar").hide();
                $("#guarcam").show();
                $("#cancelar").show();
                $("#no_documento").attr('readonly', true);

            });

            $("#cancelar").click(function(e){
                $("#sexo").attr('disabled', false);
                $("#datetimepicker").attr('readonly', false);
                $("#no_documento").attr('readonly', false);
                $("#formulario")[0].reset();
                $("#guarcam").hide();
                $("#cancelar").hide();
                $("#guardar").show();
            });

            $("#formulario").on("submit", function(event) {
                event.preventDefault();
                console.log($("#formulario").serialize());
                $.ajax({
                    type: "POST",
                    url: "insert.php",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data != ""){
                            console.log(data);
                          ok ();
                      } 


                  },
              });
            }); 
            $("#guarcam").click(function(e){
                e.preventDefault();
                
                var datastring = $("#formulario").serialize();
                console.log(datastring);
                $.ajax({
                    type: "POST",
                    url: "actualizar_cliente.php",
                    data: datastring,
                    success: function(res) {
                         console.log(res);
                        if (res== "TRUENC"){
                          ok();
                        }else if(res== "TRUE"){
                            ok2();
                        } 
                        else if (res=="FALSECAMPO"){
                            swal({
                                title: "Atención!",
                                text: "Asegúrese de diligenciar todos los campos para poder guardar.",
                                type: "warning",
                                confirmButtonText: "Aceptar"
                            });
                            
                        }

                    }

                });
            });
        });
$('#dep').change(function(){
    var depa = $(this).val();
    var depart = 'ciudad='+depa;
    $.ajax({
        type: "POST",
        url: "buscar_ciudad.php",
        data: depart,
        success: function(data) {
            $('#ciudad').html(data);
            brr ();
        }
    });
});
$('#ciudad').change(function(){
    brr ();
});
function editar(id) {
  window.location.href = "actualizar_cliente.php?operacion=update&id_cliente="+id;
  $.ajax({
    type: "POST",
    url: "actualizar_cliente.php",
    data: {operacion: 'update', id_cliente: id}
}).done(function (a) {
    $('#find').html(a);
}).false(function () {
    alert('Error al cargar modulo');
});
}
function brr () {
    var cod_brr = $('#ciudad').val();
    var brr = 'barrio='+cod_brr;
    $.ajax({
        type: "POST",
        url: "buscar_barrio.php",
        data: brr,
        success: function(data) {
            $('#barrio').html(data);
        }
    });
}


</script>
<script type="text/javascript" language="javascript">
    function validateform(){

        var captcha_response = grecaptcha.getResponse();
        if(captcha_response.length == 0)
        {
    // Captcha is not Passed
    $("captcha").html("ldsfljf");
    return false;

}
else
{
    // Captcha is Passed
    return true;
}
}
// ]]></script>
</body>
</html>