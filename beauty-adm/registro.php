<?php
include '../cnx_data.php';


$today = date("Y-m-d");
$cli_type = $_GET['cli_type'];

if ($cli_type == "Empresa"){
    $val = "S";

    $p1= '<div class="form-group col-lg-12" id="divrazon" >
                            <label>Razon social</label>
                            <input  class="form-control" onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();" name="razon_social" id="razon_social" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" maxlength="50" placeholder="Digite su razon social" data-error="Campo obligatorio" required >
                            <div class="help-block with-errors"></div>

                        </div>
                         <div hidden><input  class="form-control" name="tipo_nombre" id="tipo_nombre" value="S" placeholder="Digite su razon social"  data-error="Campo obligatorio"></div>';
                        $p2 = "hidden";
                        $p3 = '<div class="form-group col-lg-12">
                                        
                                        <label>Numero de documento</label>
                                       <div class="form-inline">
                                        <input   type="number" class="form-control" name="no_documento" id="no_documento" min="0" placeholder="Numero de documento" data-error="Este campo es obligatorio y solo debe contener numeros" required >
                                            
                                        
                                        <label> - </label> <input  style="width: 70px"  type="text" class="form-control" pattern="[0-9]" maxlength="1" name="dv" id="dv" data-error="Este campo es obligatorio y solo debe contener numeros" placeholder="D.V" readonly required >
                                        <div id="Info" class="help-block with-errors"></div>
                                      
                                        
                                    </div>
                                    </div>';
} else if ($cli_type == "Persona"){
    $val = "N";
    $p1 = '<div class="form-group col-lg-12" id="divnombre" >
                                <label>Nombres </label>
                                <input  class="form-control"  name="nombres" id="nombres" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Digite sus nombres" data-error="Campo obligatorio" required>
                                <div class="help-block with-errors"></div>
                            </div>
    
                            <div class="form-group col-lg-12" id="divapellido">
                                <label>Apellidos</label>
                                <input  class="form-control" name="apellidos" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" id="apellidos" onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();" data-error="Campo obligatorio" placeholder="digite sus apellidos" required>
                                <div class="help-block with-errors"></div>
                            </div>';
                            $p2 = "";
                            $p3 = '<div class="form-group col-lg-9">
                                        
                                        <label>Numero de documento</label>
                                       <div class="form-inline">
                                        <input   type="number" class="form-control" name="no_documento" min="0" id="no_documento" placeholder="Numero de documento" data-error="Este campo es obligatorio y solo debe contener numeros" required >
                                            
                                        
                                         <input  style="width: 70px"  type="hidden" class="form-control" pattern="[0-9]" maxlength="1" name="dv" id="dv" data-error="Este campo es obligatorio y solo debe contener numeros" placeholder="D.V" readonly required >
                                        <div id="Info" class="help-block with-errors"></div>
                                      
                                        
                                    </div>
                                    </div>';
   

} else {
   header("Location: clitipo.php");
}
?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#c9ad7d" />

    <!-- Page title -->
    <title>Beauty | ERP Invelcon SAS</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="../lib/../lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../lib/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="../lib/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="../lib/vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../lib/styles/style.css">
    <link rel="stylesheet" href="../lib/vendor/sweetalert/lib/sweet-alert.css" />
    <link rel="stylesheet" href="../lib/vendor/toastr/build/toastr.min.css" />

    <script src="https://www.google.com/recaptcha/api.js?hl=es"></script>

</head>
<body>



<div class="color-line"></div>

<div class="register-container" style="margin-top: -4%;">
    <div class="row">
        

            <div class="hpanel">
                <div class="panel-body">
                    <!-- form here-->
                    <form id="Registro" method="post">
                        
                    
                        <input type="hidden" name="tipo_nombre" value="<?php echo $val ?>">

                         <input type="hidden" name="externo" id="externo" value="si">

                        <div class="form-group col-lg-3" <?php echo $p2 ?>>
                            <label>Tipo de Documento</label>
                            <select class="form-control" name="tipo_documento" id="tipo_documento">

                                
                                <?php
            
                                    $result = $conn->query("SELECT tdicodigo, tdialias FROM btytipodocumento where not tdicodigo = 1");
                                    if ($res=mysqli_num_rows($result) > 0) {
                                        while ($row = $result->fetch_assoc()) {                
                                            echo '<option value="'.$row['tdicodigo'].'">'.$row['tdialias'].'</option>';
                                        }

                                    }
        
                                    
                                ?>
                                </select>
                                <div class="help-block with-errors"></div>
                        </div> <!-- TIPO DE DOCUMENTO -->

                       

                                    <?php
                                     echo $p3;
                                     echo $p1; ?>
                        <div class="form-group col-lg-12" <?php echo $p2; ?>>
                            <!-- <label>Sexo</label>
                            <select id="sexo" name="sexo" style="width: 200px" class="form-control">
                                <option value="M">Hombre</option>
                                <option value="F">Mujer</option>
                            </select> -->
                            <label class="control-label">Sexo</label>
                                                <div class="input-group">
                                                    <select class="form-control" name="sexo" id="sexo" data-error="Escoja una opcion" required>
                                                        <option value="M">Hombre</option>
                                                        <option value="F">Mujer</option>
                                                    </select>
                                                    <div class="input-group-addon">
                                                        <span><strong>Extranjero</strong></span>
                                                    </div>
                                                    <div class="input-group-addon">
                                                        <input type="checkbox" name="extr" id="extr" value="S">
                                                    </div>
                                            </div>
                                        </div>

                        <div class="form-group col-lg-12" id="divocu" <?php echo $p2;?>>
                            <label> Ocupacion </label>
                           <select class="form-control" id="ocu" name="ocupacion" data-error="Escoja una opcion" required="NIT, CC, TI, CE">
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
                        <div class="form-group col-lg-12">
                                        <label>fecha de nacimiento</label>
                                        <input  type="date" class="form-control" name="fecha" id="datetimepicker" placeholder="AAAA-MM-DD" max="<?php echo $today;?>" format="YYYY-MM-DD" data-error="campo obligatorio" required>
                                        <div class="help-block with-errors"></div>
                                        <p class="help-block"></p>
                                        <script>$(function () {
                                            $('.datepicker').datepicker({
                                            autoclose: true,
                                            keyboardNavigation : true ,
                                            daysOfWeekDisabled : [0]
                                            });
                                            $('#datetimepicker').datetimepicker({
                                             pickTime: false
                                            });
                                            });
                                        </script>
                                    </div>
                                    <div id="location">
                                     <div class="form-group col-lg-12">
                                <label>Departamento</label>
                                <select  zize="30" class="form-control" name="dep" id="dep" data-error="Escoja una opcion" required>
                                    <?php
                                        
                                        $result = $conn->query("SELECT depcodigo, depombre FROM btydepartamento where depstado = 1 and not depcodigo = 0");
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
                            <div class="form-group col-lg-12">
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
                            <div class="form-group col-lg-12">
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
                                    <div class="form-group col-lg-12">
                                        <label>Direccion</label>
                                        <input  class="form-control" name="direccion" id="direccion" onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ejemplo: CLL 01 kr 02 - 03" data-error="Campo obligatorio" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>                    
                                    <div class="form-group col-lg-7">
                                        <label>Tel&eacute;fono m&oacute;vil</label>
                                        <input  class="form-control" type="number" id="telefono_movil" name="telefono_movil" min="0" placeholder="Ingrese numero de telefono" data-error="camp obligatorio" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-lg-5">
                                        <label>Tel&eacute;fono fijo</label>
                                        <input  class="form-control" type="number" id="telefono_fijo" name="telefono_fijo" min="0" placeholder="Ingrese numero de telefono"><spam class="help-block">
                                            Campo opcional
                                        </spam>
                                      
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label>Email</label>
                                        <input  type="email" class="form-control" name="email" onchange="this.value=this.value.toUpperCase();"  pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$" id="email" placeholder="Email" data-error="Ingrese un direccion de correo valida" required=".">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    


                                    <div class="row" hidden>
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <div class="help-block"> 
                                                    <input type="checkbox" name="notif[]"  value="movil" aria-label="..." checked="checked" >
                                                        <label>
                                                            Recibir notificaciones a mi m&oacute;vil
                                                        </label> 
                                                </div>
                                            </div><!-- /input-group -->
                                        </div><!-- /.col-lg-6 -->
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <div class="help-block"> 
                                                    <input type="checkbox" name="notif[]"   value="email" aria-label="..." checked="checked" > 
                                                    <label>
                                                        Recibir notificaciones a mi email
                                                    </label> 
                                                </div>
                                            </div><!-- /input-group -->
                                        </div><!-- /.col-lg-6 -->
                                    </div><!-- /.row -->
                                    <div class="form-inline col-lg-12">
                                                                            <div class="">
                                            <div class="input-group col-lg-12">
                                                <div class="help-block"> 
                                                    <input type="checkbox" name=""  value="movil" aria-label="..." required>
                                                        <label>
                                                            He leído y acepto la política de <a onclick="ter()" title="Click para leer terminos y condiciones" class="text-success">TRATAMIENTO DE DATOS PERSONALES.</a>
                                                        </label> 
                                                </div>
                                            </div><!-- /input-group -->
                                        </div><!-- /.col-lg-6 -->
                                    </div>
                                    <div class="form-group col-lg-12" id="terminos" hidden>
                                        <textarea class="form-control" readonly style="resize: vertical; min-height: 100px;font-family: Garamond; text-align:justify;">Declaro que he sido informado: (i) Que INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON, como responsable de los datos personales obtenidos a través de sus distintos canales de atención, han puesto a mi disposición la línea de atención nacional (5) 385 49 55, el correo electrónico direccion.comercial@claudiachacon.com y las oficinas de atención al cliente a nivel nacional, cuya información puedo consultar en www.claudiachacon.com, disponibles de lunes a viernes de 8:00 a.m. a 06:00 p.m., para la atención de requerimientos relacionados con el tratamiento de mis datos personales y el ejercicio de los derechos mencionados en esta autorización. (ii) Esta autorización permitirá al INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON, recolectar, transferir, almacenar, usar, circular, suprimir, compartir, actualizar y transmitir, de acuerdo con el procedimiento para el tratamiento de los datos personales en procura de cumplir con las siguientes finalidades: (1) validar la información en cumplimiento de la exigencia legal de conocimiento del cliente aplicable a INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON, (2) adelantar las acciones legales del caso, en procura de hacer sostenible y estable a INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON, (3) para el tratamiento de los datos personales protegidos por nuestro ordenamiento jurídico, (4) para el tratamiento y protección de los datos de contacto (direcciones de correo físico, electrónico, redes sociales y teléfono), (5) para solicitar y recibir de las distintas bases de datos y/o empresas de carácter privado la información personal, que reposa en sus bases de datos. A su vez se solicita a los titulares de los datos de los servicios ofrecidos por la Dirección Comercial de INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON, de manera expresa, libre y voluntaria autorice el tratamiento de datos personales sensibles tales como el origen racial o étnico, al tenor de lo dispuesto en el artículo 6 de la ley 1581 de 2012. El alcance de la autorización comprende la facultad para que INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON le envíe mensajes con contenidos institucionales, notificaciones, información del estado de cuenta, saldos, y demás información relativa al portafolio de servicios de la entidad, a través de correo electrónico y/o mensajes de texto al teléfono móvil. (iii) Mis derechos como titular del dato son los previstos en la constitución y la ley, especialmente el derecho a conocer, actualizar, rectificar y suprimir mi información personal; así como el derecho a revocar el consentimiento otorgado para el tratamiento de datos personales. Estos los puedo ejercer a través de los canales dispuestos por NVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON para la atención al público y observando la política de tratamiento de datos personales de INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON  disponible en www.claudiachacon.com; Otorgo mi consentimiento al INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON para tratar mi información personal, de acuerdo con la política de tratamiento de datos personales, y por tanto me comprometo a leer el aviso de privacidad y la política mencionada disponible en: www.claudiachacon.com. Autorizo a INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON a modificar o actualizar su contenido, a fin de atender reformas legislativas, políticas internas o nuevos requerimientos para la prestación u ofrecimiento de servicios o productos, dando aviso previo por medio de la página web de la compañía, y/o correo electrónico. La información del formato del cual forma parte la presente autorización la he suministrado de forma voluntaria y es verídica.
                                    </textarea>
                                    </div>

                                    <div class="input-group col-lg-12">
                                    <!-- <label> </label>
                                        <div class="g-recaptcha col-lg-12" data-sitekey="6LcQ9S4UAAAAAPZm9IVrvG9Do27W4goyFmLOpOQp"  required></div> -->
                                        
                                    </div>
                                    
                                    <div class="col-lg-6 col-md-12">
                                    <br>
                                    <button type="submit" id="guardar" name="guardar" class="btn btn-lg btn-success">
                                        Guardar Registro
                                    </button>

                                    </div>
                                        


                                    </form>
                </div>
            </div>
       
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <strong>©</strong>2017 Copyright Claudia Chacón<br/> <a href="http://www.claudiachacon.com">www.claudiachacon.com </a>
        </div>
    </div>
</div>

<!-- Vendor scripts -->
<script src="../lib/vendor/jquery/dist/jquery.min.js"></script>
<script src="../lib/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="../lib/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="../lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../lib/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="../lib/vendor/iCheck/icheck.min.js"></script>
<script src="../lib/vendor/sparkline/index.js"></script>
<script src="../lib/vendor/sweetalert/lib/sweet-alert.min.js"></script>
<script src="../lib/vendor/toastr/build/toastr.min.js"></script>


<!-- App scripts -->
<script src="../lib/scripts/homer.js"></script>


<script type="text/javascript">
 function ok() {
            swal({

                        title: "Su registro ha sido exitoso!",
                        text: "Gracias por confiar en nosotros.",
                        type: "success",
                        confirmButtonText: "Aceptar"
                    },
                    function () {
                        window.location = "clitipo.php";
                    });
    

}
function ter () {
    $('#terminos').attr('hidden', false);
}
$(document).ready(function() {
$('#extr').click(function(event) {
        if (!$(this).is(':checked')) {
            $('#location').attr('hidden', false);
        } else {
            $('#location').attr('hidden', true);
        }
    });    
    /*$('#no_documento').blur(function(){
        $('#Info').html("");
        var username = $(this).val();        
        var dataString = 'no_documento='+username;
        $.ajax({
            type: "POST",
            url: "check_user.php",
            data: dataString,
            success: function(data) {
                if (data == "TRUE"){
                    $('#Info').html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Usuario ya esta registrado </font></div>');
                     swal({

                        title: "Error",
                        text: "El documento que ingreso ya se encuentra registrado",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    },
                    function () {
                        
                    });
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
                        $('#tipo_documento').attr('disabled', false);
                        $('#nombres').val('');
                        $('#apellidos').val('');
                        $('#telefono_movil').val('');
                        $('#telefono_fijo').val('');
                        $('#direccion').val('');

                        $('#')
                } else if (data[0] > 0) {
                    if (data[0] == 1 ) {
                        empresa();
                        $('#razon_social').val(data.split(",")[5]);
                        $('#razon_social').attr('readonly', true);
                        $('#tipo_nombre1').attr('checked', 'checked');
                        
                        
                    } else {
                        $('#razon_social').val(data.split(",")[5]);
                        $('#razon_social').attr('readonly', true);
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
                        $('#tipo_documento').attr('disabled', false);
                        $('#nombres').val(data.split(",")[3]);
                        $('#nombres').attr('readonly', true);
                        $('#apellidos').attr('readonly', true);
                        $('#apellidos').val(data.split(",")[4]); //
                        $('#tipo_documento option[value="'+data.split(",")[0]+'"]').attr('selected', 'selected');
                        $('#tipo_documento').attr('disabled', true);
                    }
                        $('#tipo_nombre1').attr('disabled', true);
                        $('#tipo_nombre2').attr('disabled', true);
                        $('#barrio option[value="'+data.split(",")[9]+'"]').attr('selected', 'selected');
                        $('#barrio').attr('disabled', true);
                        $('#ciudad').attr('disabled', true);
                        $('#dep').attr('disabled', true);
                        $('#direccion').attr('readonly', true);
                        $('#direccion').val(data.split(",")[6]);
                        $('#telefono_movil').val(data.split(",")[8]);
                        $('#telefono_fijo').val(data.split(",")[7]);
                        $('#telefono_movil').attr('readonly', true);
                        $('#telefono_fijo').attr('readonly', true);

                } else {
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
        $('#tipo_documento').attr('disabled', false);

         $('#nombres').val('');
         $('#apellidos').val('');
         $('#telefono_movil').val('');
         $('#telefono_fijo').val('');
         $('#direccion').val('');

                }
        var dataString = 'user_cod='+username;
        $.ajax({
            type: "POST",
            url: "dv.php",
            data: dataString,
            success: function(data) {
                $('#dv').val(data);
            }
        });
            }
        });
    }); */  
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
                                //empresa();
                                /*$('#razon_social').val(data.split(",")[5]);
                                $('#razon_social').attr('readonly', true);
                                $('#tipo_nombre1').attr('checked', 'checked');  */ 
                            } 
                            else if (data[0] > 1) {     
                                //persona();
                                /*$('#nombres').val(data.split(",")[3]);
                                $('#nombres').attr('readonly', true);
                                $('#apellidos').attr('readonly', true);
                                $('#apellidos').val(data.split(",")[4]); //
                                $('#tipo_documento option[value="'+data.split(",")[0]+'"]').attr('selected', 'selected');
                                $('#tipo_documento').attr('disabled', true);
                                $("#sexo").val(data.split(",")[10]);
                                $("#sexo").attr('disabled', true);
                                $("#datetimepicker").val(data.split(",")[13]);
                                $("#datetimepicker").attr('readonly', true);
                                $("#ocu").val(data.split(",")[20]);
                                $("#ocu").attr('disabled', true);
                                $("#email").val(data.split(",")[12]);
                                $("#email").attr('readonly', true);
                                if((data.split(",")[11])=='S'){
                                    $("#extr").prop('checked','true');
                                }
                                $("#extr").attr('disabled', true);
                                if((data.split(",")[15])=='S'){
                                    $("#notifmovil").prop('checked','true');
                                    $("#notifmovil").attr('disabled', true);
                                }
                                if((data.split(",")[14])=='S'){
                                    $("#notifmail").prop('checked','true');
                                    $("#notifmail").attr('disabled', true);
                                }*/
                                
                            }
                            /*$('#tipo_nombre1').attr('disabled', true);
                            $('#tipo_nombre2').attr('disabled', true);
                            $('#barrio option[value="'+data.split(",")[9]+'"]').attr('selected', 'selected');
                            $('#barrio').attr('disabled', true);
                            $('#ciudad').attr('disabled', true);
                            $('#dep').attr('disabled', true);
                            $('#direccion').attr('readonly', true);
                            $('#direccion').val(data.split(",")[6]);
                            $('#telefono_movil').val(data.split(",")[8]);
                            $('#telefono_fijo').val(data.split(",")[7]);
                            $('#telefono_movil').attr('readonly', true);
                            $('#telefono_fijo').attr('readonly', true);
                            $("#guardar").hide();
                            $("#actualizar").show();*/
                            swal({

                                title: "Este documento ya se encuentra registrado!",
                                text: "Si desea actualizar sus datos comuníquese con nuestras lineas o acérquese a uno de nuestros puntos. ",
                                type: "error",
                                confirmButtonText: "Aceptar"
                            },
                            function () {
                                $("#Registro")[0].reset();
                                location.reload();
                            });
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

        $("#Registro").on("submit", function(event) {
                event.preventDefault();
                /*var captcha_response = grecaptcha.getResponse();
                if(captcha_response.length == "") {
    // Captcha is not Passed
                $("captcha").html("ldsfljf");
                return false;
     
}
else
{*/
    // Captcha is Passed
                  $.ajax({
                    type: "POST",
                    url: "insert.php",
                    data: $(this).serialize(),
                    success: function(a) {
                        //$("#chatbox").append(data+"<br/>");//instead this line here you can call some function to read database values and display
                        if (a == "TRUE"){

                            ok ();

                        } else {
                            alert(a);
                        }


                    },
                });
//}

            });
    
    
});    


</script>

<script>
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



</body>
</html>
<?php $conn->close();?>