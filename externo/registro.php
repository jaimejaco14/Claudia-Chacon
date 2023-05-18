<?php
 include '../cnx_data.php';


$today = date("Y-m-d");
$cli_type = $_GET['cli_type'];


?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#c9ad7d" />

    <!-- Page title -->
    <title>Beauty | ERP Invelcon SAS</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" type="image/ico" href="../contenidos/imagenes/favicon.ico" />

    <!-- Vendor styles -->
    <link rel="stylesheet" href="../lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../lib/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="../lib/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="../lib/vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../lib/styles/style.css">
    <link rel="stylesheet" href="../lib/vendor/sweetalert/lib/sweet-alert.css" />
    <link rel="stylesheet" href="../lib/vendor/toastr/build/toastr.min.css" />
    <link rel="stylesheet" href="../lib/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="../lib/vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />

    <link rel="stylesheet" type="text/css" href="js/toastr.css">

    <link rel="stylesheet" href="js/select2-4-0-1.min.css" />

   <!--  <script src='https://www.google.com/recaptcha/api.js'></script> -->


</head>
<body>



<div class="color-line"></div>

<div class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="hpanel">
                <div class="panel-heading">REGISTRO DE CLIENTES <a href="./" class="btn btn-primary btn-xs pull-right" data-toggle="tooltip" data-placement="bottom" title="Volver al inicio."><i class="fa fa-chevron-left"></i></a></div>
                    <div class="panel-body">
                        <div class="text-center m-b-md" id="wizardControl">
                            <a class="btn btn-primary" id="paso1" href="#step1" data-toggle="tab" title="Indique su número de documento">Paso 1</a>
                            <a class="btn btn-default disabled" id="paso2" href="#step2" data-toggle="tab" title="Agende su cita">Paso 2</a>
                            <a class="btn btn-default disabled" id="paso3" href="#step3" data-toggle="tab">Paso 3</a>
                        </div>
                            
                        <div class="tab-content">
                            <div id="step1" class="p-m tab-pane active">
                                <div class="row">
                                <form id="formCliente" action="" method="POST">
                                   <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Tipo Documento</label>
                                                <select class="form-control" name="tipo_documento" id="tipo_documento">
                                                    <option selected value="0">Seleccione</option>
                                                    <?php
                                
                                                        $result = $conn->query("SELECT tdicodigo, tdinombre FROM btytipodocumento where not tdicodigo = 1 AND tdiestado = 1");
                                                        if ($res=mysqli_num_rows($result) > 0) 
                                                        {
                                                            while ($row = $result->fetch_assoc()) 
                                                            {                
                                                                echo '<option value="'.$row['tdicodigo'].'">'.$row['tdinombre'].'</option>';
                                                            }

                                                        }
                            
                                                        
                                                    ?>
                                                    </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Documento</label>
                                                <input type="number" class="form-control" id="doc" placeholder="Digite Documento">
                                                <input type="hidden" class="form-control" id="digitov" placeholder="">
                                                <input type="hidden" class="form-control" id="tipocliente" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Nombres</label>
                                                <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Digite Nombres">
                                        </div>
                                    </div>

                                   <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Apellidos</label>
                                            <input type="text" name="apellidos" class="form-control" id="apellidos" placeholder="Digite Apellidos">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Sexo</label>
                                            <select name="sexo" id="sexo" class="form-control">
                                                <option value="0" selected>Seleccione</option>
                                                <option value="F">Femenino</option>
                                                <option value="M">Masculino</option>
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Ocupación</label>
                                           <select class="form-control" name="ocupacion" id="ocupacion">
                                                    <option selected value="0">Seleccione</option>
                                                   <?php                                
                                                        $result = $conn->query("SELECT ocucodigo, ocunombre FROM btyocupacion where ocunombre NOT IN ('N/D')");
                                                        if ($result->num_rows > 0) 
                                                        {
                                                            while ($row = $result->fetch_assoc()) 
                                                            {                
                                                                echo '<option value="'.$row['ocucodigo'].'">'.$row['ocunombre'].'</option>';
                                                            }
                                                        }
                                                      
                                                    ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Extranjero</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="" id="extranjero">
                                                    
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="text-right m-t-xs">    
                                    <a class="btn btn-primary next">Siguiente</a>
                                </div>
                            </div>

                            <div id="step2" class="p-m tab-pane">
                                <div class="row">
                                    
                                    <div class="col-lg-12">
                                        <div class="row">
                                            

                                                <div class="form-group col-lg-6">
                                                   <div class="form-group">
                                                        <label for="">FECHA DE NACIMIENTO</label>
                                                            <div class="input-group date">
                                                                <input type="text" class="form-control" id="fechaNac" placeholder="0000-00-00"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6" id="coldepto">
                                                    <div class="form-group">
                                                            <label for="">Departamento</label>
                                                            <select class="selectpicker" id="selDepartamento" data-live-search="true" title='DEPARTAMENTO' data-size="10" style="width: 100%!important">
                                                                <option value="0" selected>Seleccione</option>
                                                                <?php                                            
                                                                    $sql = mysqli_query($conn,"SELECT depcodigo, depombre FROM btydepartamento WHERE NOT depcodigo = 0 AND depstado = 1");

                                                                        while ($row = mysqli_fetch_array($sql)) 
                                                                        {  
                                                                            echo '<option value="'.$row['depcodigo'].'">'.utf8_encode($row['depombre']).'</option>';

                                                                        }
                                                                ?>
                                                        </select>
                                                    </div>
                                                </div>                                               
                                                   
                                        </div><!-- row -->
                                        <div class="row">
                                            <div class="col-lg-6" id="colciudad">
                                                    <div class="form-group">
                                                            <label for="">Ciudad</label>
                                                            <select class="selectpicker" id="selCiudad" data-live-search="true" title='DEPARTAMENTO' data-size="10" style="width: 100%!important">
                                                                <option value="0" selected>Seleccione</option>
                                                                
                                                        </select>
                                                    </div>
                                            </div>

                                            <div class="col-lg-6" id="colbarrio">
                                                <div class="form-group">
                                                        <label for="">Barrio</label>
                                                        <select class="selectpicker" id="selBarrio" data-live-search="true" title='DEPARTAMENTO' data-size="10" style="width: 100%!important">
                                                            <option value="0" selected>Seleccione</option>
                                                            
                                                    </select>
                                                </div>
                                            </div>  


                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6" id="">
                                                <div class="form-group">
                                                    <label for="">Dirección</label>
                                                    <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Digite Dirección" value="" title="">
                                                </div>
                                            </div>

                                            <div class="col-lg-6" id="">
                                                <div class="form-group">
                                                    <label for="">Móvil</label>
                                                    <input type="number" maxlength="10" name="movil"  onblur="validar(this)" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="movil" class="form-control" placeholder="Digite Móvil" value="" title="">

                                                   <!--  <input type="number" maxlength="10" id="movil" onblur="validar(this)" placeholder="Digite número móvil" class="form-control" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" /> -->
                                                </div>
                                            </div> 
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6" id="">
                                                <div class="form-group">
                                                    <label for="">Tel. Fijo</label>
                                                    <input type="number" maxlength="7" id="fijo" placeholder="Digite número fijo" class="form-control" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" />


                                                </div>
                                            </div>

                                            <div class="col-lg-6" id="">
                                                <div class="form-group">
                                                    <label for="">E-mail</label>
                                                    <input type="email" name="email" id="email" class="form-control" placeholder="Digite E-mail" value="" title="">
                                                </div>
                                            </div> 

                                        </div>

                                        <div class="row">
                                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">NOTIFICACIONES AL MOVIL</label>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" value="" id="nm" checked>
                                                                        
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                         <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">NOTIFICACIONES AL E-MAIL</label>
                                                               <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" value="" id="ne" checked>
                                                                        
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                    </div><!-- col-lg-12 -->
                                </div><!-- row arriba -->

                                <div class="text-right m-t-xs">    
                                    <a class="btn btn-primary next finish">Siguiente</a>
                                </div>
                            </div><!-- /step2 -->

                            <div id="step3" class="tab-pane">
                                <div class="row text-center m-t-lg m-b-lg">
                                    <div class="col-lg-12">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">ACuerdo</h3>
                                            </div>
                                            <div class="panel-body">
                                                        <textarea class="form-control" readonly style="resize: none; min-height: 200px;font-family: Garamond; text-align:justify;">Declaro que he sido informado: (i) Que INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON, como responsable de los datos personales obtenidos a través de sus distintos canales de atención, han puesto a mi disposición la línea de atención nacional (5) 385 49 55, el correo electrónico direccion.comercial@claudiachacon.com y las oficinas de atención al cliente a nivel nacional, cuya información puedo consultar en www.claudiachacon.com, disponibles de lunes a viernes de 8:00 a.m. a 06:00 p.m., para la atención de requerimientos relacionados con el tratamiento de mis datos personales y el ejercicio de los derechos mencionados en esta autorización. (ii) Esta autorización permitirá al INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON, recolectar, transferir, almacenar, usar, circular, suprimir, compartir, actualizar y transmitir, de acuerdo con el procedimiento para el tratamiento de los datos personales en procura de cumplir con las siguientes finalidades: (1) validar la información en cumplimiento de la exigencia legal de conocimiento del cliente aplicable a INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON, (2) adelantar las acciones legales del caso, en procura de hacer sostenible y estable a INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON, (3) para el tratamiento de los datos personales protegidos por nuestro ordenamiento jurídico, (4) para el tratamiento y protección de los datos de contacto (direcciones de correo físico, electrónico, redes sociales y teléfono), (5) para solicitar y recibir de las distintas bases de datos y/o empresas de carácter privado la información personal, que reposa en sus bases de datos. A su vez se solicita a los titulares de los datos de los servicios ofrecidos por la Dirección Comercial de INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON, de manera expresa, libre y voluntaria autorice el tratamiento de datos personales sensibles tales como el origen racial o étnico, al tenor de lo dispuesto en el artículo 6 de la ley 1581 de 2012. El alcance de la autorización comprende la facultad para que INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON le envíe mensajes con contenidos institucionales, notificaciones, información del estado de cuenta, saldos, y demás información relativa al portafolio de servicios de la entidad, a través de correo electrónico y/o mensajes de texto al teléfono móvil. (iii) Mis derechos como titular del dato son los previstos en la constitución y la ley, especialmente el derecho a conocer, actualizar, rectificar y suprimir mi información personal; así como el derecho a revocar el consentimiento otorgado para el tratamiento de datos personales. Estos los puedo ejercer a través de los canales dispuestos por NVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON para la atención al público y observando la política de tratamiento de datos personales de INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON  disponible en www.claudiachacon.com; Otorgo mi consentimiento al INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON para tratar mi información personal, de acuerdo con la política de tratamiento de datos personales, y por tanto me comprometo a leer el aviso de privacidad y la política mencionada disponible en: www.claudiachacon.com. Autorizo a INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON a modificar o actualizar su contenido, a fin de atender reformas legislativas, políticas internas o nuevos requerimientos para la prestación u ofrecimiento de servicios o productos, dando aviso previo por medio de la página web de la compañía, y/o correo electrónico. La información del formato del cual forma parte la presente autorización la he suministrado de forma voluntaria y es verídica.
                                                </textarea>

                                                <div class="checkbox col-lg-12">
                                                    <input type="checkbox" class="i-checks approveCheck" name="approve" id="aprobar">
                                                        Estoy de acuerdo
                                                </div>


                                                <div class="text-right m-t-xs">
                                                    <button type="button" id="btnRegistrarCli" class="btn btn-primary">REGISTRAR</button>
                                                </div>
                                                
                                            </div>
                                        </div>
                                       
                                    </div>                               
                                </div>
                        </form>
                        </div>
                    </div> 
                </div><!-- panel-body -->
            </div>
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

<script src="../lib/vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>
<script src="../lib/vendor/moment/min/moment-with-locales.js"></script>
<!-- App scripts -->
<script src="../lib/scripts/homer.js"></script>

<script src="js/select-2-4-0-1.min.js"></script>

<script src="js/toastr.js"> </script>

<script src="js/cliente.js"></script>


<style type="text/css">
    .rc-anchor-normal {
    height: 74px;
    width: 100%!important;
}
</style>



</body>
</html>
<?php $conn->close();?>